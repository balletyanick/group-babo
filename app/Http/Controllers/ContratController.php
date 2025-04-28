<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use App\Models\Agence;
use App\Models\Facture;
use App\Models\Client;
use App\Models\Disponibilite;
use App\Models\Paiement;
use App\Models\Pret;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class ContratController extends Controller
{
    
    public function index()
    {
        // Filtrer les contrats selon les permissions de l'utilisateur
        $contrats = Contrat::with('product', 'user', 'agence')
            ->accessibleBy(Auth::user())
            ->paginate(100);


        // Pour chaque contrat, calculer la somme des paiements associés
        foreach ($contrats as $contrat) {
            // Calcul de la somme des paiements associés au contrat avec 'status' = 1
            $contrat->somme_retire = Paiement::where('status', 1)
                ->where('contrat_id', $contrat->id) // Assurez-vous que le paiement est lié au contrat
                ->sum('amount');
        }

        return view('contrat.index', compact('contrats')); 
    }


    public function add($id)
    {
        $contrat = Contrat::find($id);

        if(!is_null($contrat)){
            $title = "Modifier le contrat";

            Auth::user()->access('EDITION CONTRAT');
        }else{
            $contrat = new Contrat;
            $title = 'Ajouter un contrat';

            Auth::user()->access('AJOUT CONTRAT'); 
        } 
        
        $product = Product::all();
        $user = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'PARTENAIRE')
            ->select('users.*')
            ->paginate(100);
        $agence = Agence::all();
        return view('contrat.save',compact('contrat','title','product','user','agence'));
    }

    public function save(Request $request)
    {
        Auth::user()->access('AJOUT CONTRAT');

        $validator = $request->validate([
            'user_id' => 'required|string|exists:users,id', 
            'product_id' => 'required|string|exists:products,id',
            'agence_id' => 'required|string|exists:agences,id',
            'quantite' => 'required|integer',
            'note' => 'nullable|string',
            'method_versement' => 'required|string',
            'type_contrat' => 'required|string',
            'date_day' => 'required|date',
            
        ]);

        $data = $request->all();

        $data['numero_contrat'] = 'BC-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $data['status'] = 0;

        // Vérifie si le type de contrat est "normal"
        if ($data['type_contrat'] === 'Normal') {

            $data['numero_contrat'] = 'BC-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $data['status'] = 0; 

        } else {
            $data['numero_contrat'] = 'BCP-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $data['status'] = 0;
            $data['premier_pay'] = 200000;
        }


        // Logique pour date_firt_payment
        $currentDate = new \DateTime($data['date_day']);
        $dayOfMonth = (int) $currentDate->format('d');

        if ($dayOfMonth <= 15) {
            // Si la date est entre le 1 et le 15, premier paiement dans deux mois au 15
            $currentDate->modify('+2 months');
            $currentDate->setDate((int) $currentDate->format('Y'), (int) $currentDate->format('m'), 15);

        } else {
            $currentDate->modify('+2 months'); 
            // Vérification si le mois est février
            if ((int) $currentDate->format('m') === 2) {
                // Ajuster la date au 28 février
                $currentDate->setDate((int) $currentDate->format('Y'), 2, 28);
            } else {
                // Autres mois, fixer la date au 30
                $currentDate->setDate((int) $currentDate->format('Y'), (int) $currentDate->format('m'), 30);
            }
        }

        $data['date_firt_payment'] = $currentDate->format('Y-m-d');

        // Récupérer la durée du contrat depuis la table products
        $product = Product::findOrFail($request->input('product_id'));
        $durationInMonths = $product->duration_contrat;

         // Calcul de la date de fin de paiement
        $endPaymentDate = new \DateTime($data['date_firt_payment']);
        $endPaymentDate->modify("+{$durationInMonths} months");
        $data['date_end_payment'] = $endPaymentDate->format('Y-m-d');
  
        $contrat = Contrat::create($data);

        // Appeler la fonction d'ajout des disponibilités (versements)
        $dispoResult = $this->auto_add_disponibilite($contrat->id);

        // S'il y a une erreur lors de l'ajout des disponibilités, renvoyer une réponse d'erreur
        if (isset($dispoResult['error'])) {
            return response()->json([
                'message' => $dispoResult['error'],
                'status'  => 'error'
            ]);
        }

        // Message à envoyer
        $smsMessage = "Bienvenue chez Babo Corporate ! Votre contrat a été créé avec succès. Nous sommes ravis de vous accompagner.";
    
        // Envoyer le SMS via l'API SMS
        $response = Http::post('https://sms.acim-ci.net:8443/api/addFullSms', [
            'Username' => 'phenixApi',
            'Token' => '$2a$10$ecyCD2d.Igj2n6ZpPcka5uMQmRW53dGOFnSm/OzSiubtYWm9q86kK',
            'Sender' => 'PHENIX TRAN',
            'Flash' => '0',
            'Sms' => $smsMessage,
            'Title' => 'Bienvenue',
            'Contact' => [
                ['Dest' => $request->phone]
            ],
        ]);
        

        return response()->json(['message' => 'Contrat enregistré avec succès', 'status' => 'success']);
    }

    public function delete(Request $request)
    { 
        Auth::user()->access('SUPPRESSION CONTRAT');
        $contrat = Contrat::find($request->id);

        $hasFactures = Facture::where('contrat_id', $contrat->id)->exists();
        $hasPrets = Pret::where('contrat_id', $contrat->id)->exists();


        if ($hasFactures) {
            return response()->json([
                'message' => 'Impossible de supprimer cet élément : il est lié à une ou plusieurs factures.',
                'status' => 'error'
            ]);
        }

        if ($hasPrets) {
            return response()->json([
                'message' => 'Impossible de supprimer cet élément : il est lié à une ou plusieurs prets.',
                'status' => 'error'
            ]);
        }

        if($contrat->delete()){
            return response()->json(['message' => 'Information du contrat supprimé avec succès',"status"=>"success"]);
        }else{
            return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
        }
    }

    public function edit($id)
    { 
        Auth::user()->access('EDITION CONTRAT');
        $title = 'Modifier le contrat';

        $contrat = Contrat::find($id);
        $client = Client::all();
        $product = Product::all();
        $agence = Agence::all();

        return view('contrat.edit', compact('contrat', 'title', 'client', 'product','agence'));
    }


    public function save_edit(Request $request)
    {   

        Auth::user()->access('EDITION CONTRAT');

        $validator = $request->validate([
            'quantite' => 'required|integer',
            'note' => 'nullable|string',
            'method_versement' => 'required|string',
        ]);

        $contrat = Contrat::findOrFail($request->id);

        $data = $request->all();
        $contrat->update($data);

        return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
    }

    public function resilier(Request $request)
    {
            Auth::user()->access('RESILIATION CONTRAT EMPLOYE');

            $contrat = Contrat::find($request->id);

            // Mettre à jour le statut à 1 (Résilié)
            $contrat->status = 1;

            if ($contrat->save()) {
                return response()->json(['message' => 'Contrat résilié avec succès', "status" => "success"]);
            } else {
                return response()->json(['message' => 'Échec de la résiliation, veuillez réessayer', "status" => "error"]);
            }
    }


    public function generate_and_save($id) 
    {

        Auth::user()->access('GENERATION CONTRAT');
            
        $contrat = Contrat::find($id);
        $product = Product::all();
        $user = User::all();
        $agence = Agence::all();

    
        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé.'], 404);
        }
    
        // Charger le modèle Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/Templates/Modele.docx'));
    
        // Fonction pour convertir les nombres en lettres
        function convertirNombreEnLettres($nombre) {
            $f = new \NumberFormatter("fr", \NumberFormatter::SPELLOUT);
            return mb_strtoupper($f->format($nombre)); // En majuscules
        }
    
        // Fonction pour ajouter des points au format français
        function formatNombreAvecPoints($nombre) {
            return number_format($nombre, 0, ',', '.');
        }
    
        // les Variables sans calcule
        $amout_global = $contrat->product->amout_global;
        $frais_gestion = $contrat->product->frais_gestion;
        $pay_mensuel = $contrat->product->pay_mensuel;
        $pay_day = $contrat->product->pay_day;
        $dure_contrat = $contrat->product->duration_contrat;
        $quantite = $contrat->quantite; 
        $date_day = $contrat->date_day;


        $prix_produit = $amout_global * $quantite;  // montant total sans les frais de gestion
        $frais = $frais_gestion * $quantite;  // total des frais de gestion
        
        $prix_produit_avec_frais = $prix_produit;  // montant total sans avec frais de gestion
        $prix_produit_sans_frais = $prix_produit - $frais;  // montant total sans avec frais de gestion

        $pay_mois = $pay_mensuel * $quantite;  // total paiement mensuel
        $pay_jour = $pay_day * $quantite;  // total paiement par jour

        $montant = $pay_mois * $dure_contrat;  // tMontant total recu par le 
        $date_aujourdhui = Carbon::now()->toDateString(); 



        // Date de carrence
        $date = new \DateTime($date_day);
        $date->modify('+1 month');
        $date_carrence = $date->format('Y-m-d');

        // Debut periode activite
        $periode_date = new \DateTime($date_carrence);
        $periode_date->modify('+1 day');
        $debut_activite = $periode_date->format('Y-m-d');


        // periode d'activité
        $dates = new \DateTime($date_carrence);
        $dates->modify('+1 month');
        $date_activite = $dates->format('Y-m-d');

        
    
        //client
        $templateProcessor->setValue('first_name', $contrat->user->first_name);
        $templateProcessor->setValue('last_name', $contrat->user->last_name);
        $templateProcessor->setValue('genre', $contrat->user->genre);
        $templateProcessor->setValue('date_of_birth', Carbon::parse($contrat->user->date_of_birth)->format('d/m/Y'));
        $templateProcessor->setValue('place_of_birth', $contrat->user->place_of_birth);
        $templateProcessor->setValue('neighborhood', $contrat->user->neighborhood);
        $templateProcessor->setValue('common', $contrat->user->common);
        $templateProcessor->setValue('numero_cni', $contrat->user->numero_cni);
        $templateProcessor->setValue('date_start_cni', Carbon::parse($contrat->user->date_start_cni)->format('d/m/Y'));
        $templateProcessor->setValue('date_end_cni', Carbon::parse($contrat->user->date_end_cni)->format('d/m/Y'));
        $templateProcessor->setValue('etat_matrimonial', $contrat->user->etat_matrimonial);
        $templateProcessor->setValue('work', $contrat->user->fonction);
        $templateProcessor->setValue('email', $contrat->user->email);
        $templateProcessor->setValue('phone', $contrat->user->phone);
        $templateProcessor->setValue('name_doc_client', $contrat->user->name_doc_client);
        
    
        //ayant droit
        $templateProcessor->setValue('first_name_death', $contrat->user->first_name_death);
        $templateProcessor->setValue('last_name_death', $contrat->user->last_name_death);
        $templateProcessor->setValue('numero_piece_death', $contrat->user->numero_piece_death);
        $templateProcessor->setValue('name_doc', $contrat->user->name_doc);
        $templateProcessor->setValue('date_start_doc_death', Carbon::parse($contrat->user->date_start_doc_death)->format('d/m/Y'));
        $templateProcessor->setValue('date_end_doc_death', Carbon::parse($contrat->user->date_end_doc_death)->format('d/m/Y'));
        $templateProcessor->setValue('date_of_birth_death', Carbon::parse($contrat->user->date_of_birth_death)->format('d/m/Y'));
        $templateProcessor->setValue('place_of_birth_death', $contrat->user->place_of_birth_death);
        $templateProcessor->setValue('place_death', $contrat->user->place_death);
        $templateProcessor->setValue('phone_number_death', $contrat->user->phone_number_death);
        $templateProcessor->setValue('genre_death', $contrat->user->genre_death);


    
        // placeholder produit
        $templateProcessor->setValue('libelle', $contrat->product->libelle);
        $templateProcessor->setValue('description', $contrat->product->description);
        $templateProcessor->setValue('duration_contrat', $contrat->product->duration_contrat);
        $templateProcessor->setValue('duration_contrat_l', convertirNombreEnLettres($contrat->product->duration_contrat));
        $templateProcessor->setValue('duration_contrat_c', formatNombreAvecPoints($contrat->product->duration_contrat));
        $templateProcessor->setValue('amout_global', $contrat->product->amout_global);
        $templateProcessor->setValue('type', $contrat->product->type);
        $templateProcessor->setValue('moto_restitue', $contrat->product->moto_restitue);




        // Placeholder information du contrat 
        $templateProcessor->setValue('date_aujourdhui', $date_aujourdhui);
        $templateProcessor->setValue('numero_contrat', $contrat->numero_contrat);
       
        $templateProcessor->setValue('prix_produit_l', convertirNombreEnLettres($prix_produit));
        $templateProcessor->setValue('prix_produit_c', formatNombreAvecPoints($prix_produit));
        $templateProcessor->setValue('frais_l', convertirNombreEnLettres($frais));
        $templateProcessor->setValue('frais_c', formatNombreAvecPoints($frais));
        $templateProcessor->setValue('quantite_l', convertirNombreEnLettres($quantite));
        $templateProcessor->setValue('quantite_c', formatNombreAvecPoints($quantite));
        $templateProcessor->setValue('method_versement', $contrat->method_versement);
        $templateProcessor->setValue('prix_produit_avec_frais_l', convertirNombreEnLettres($prix_produit_avec_frais));
        $templateProcessor->setValue('prix_produit_avec_frais_c', formatNombreAvecPoints($prix_produit_avec_frais));
        $templateProcessor->setValue('pay_mois_l', convertirNombreEnLettres($pay_mois));
        $templateProcessor->setValue('pay_mois_c', formatNombreAvecPoints($pay_mois));
        $templateProcessor->setValue('pay_jour_l', convertirNombreEnLettres($pay_jour));
        $templateProcessor->setValue('pay_jour_c', formatNombreAvecPoints($pay_jour));
        $templateProcessor->setValue('date_firt_payment', Carbon::parse($contrat->date_firt_payment)->format('d/m/Y'));
        $templateProcessor->setValue('date_end_payment', Carbon::parse($contrat->date_end_payment)->format('d/m/Y'));
        $templateProcessor->setValue('montant_l', convertirNombreEnLettres($montant));
        $templateProcessor->setValue('montant_c', formatNombreAvecPoints($montant));
        $templateProcessor->setValue('date_carrence', Carbon::parse($date_carrence)->format('d/m/Y'));
        $templateProcessor->setValue('date_activite', Carbon::parse($date_activite)->format('d/m/Y'));
        $templateProcessor->setValue('date_day', Carbon::parse($date_day)->format('d/m/Y'));
        $templateProcessor->setValue('debut_activite', Carbon::parse($debut_activite)->format('d/m/Y'));

        $templateProcessor->setValue('prix_produit_sans_frais_l', convertirNombreEnLettres($prix_produit_sans_frais));
        $templateProcessor->setValue('prix_produit_sans_frais_c', formatNombreAvecPoints($prix_produit_sans_frais));
        

        // Définir le nom du fichier et le chemin
        $fileName = 'C'.$contrat->user->numero_cni.'_'.rand(1000,9999).'.docx';
        $path_file = 'contrats/' . $fileName;

        // verification
        $fullPath = storage_path('app/public/' . $path_file);
        $directory = dirname($fullPath); // Chemin du répertoire

        // Vérifiez et créez le répertoire si nécessaire
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
    
        // Sauvegarder le fichier Word généré
        $templateProcessor->saveAs(storage_path('app/public/' . $path_file));
    
        // Stocker les informations du contrat dans la base de données
        $contrat->chemin_file = $path_file;
        $contrat->save();
    
        return redirect()->route('contrat.index')->with('success', 'Contrat généré et sauvegardé avec succès.');
        return response()->json(['message' => 'Contrat généré et sauvegardé avec succès.', 'status' => 'success']);
    }


    public function downloadFile($id) 
    {

        Auth::user()->access('TELECHARGER CONTRAT');

        $contrat = Contrat::find($id);
        $product = Product::all();

        if (!$contrat || !$contrat->chemin_file) {
            return redirect()->route('contrat.index')->with('error', 'Fichier non trouvé.');
        }

        // Chemin du fichier
        $fileName = 'C'.$contrat->user->numero_cni.'_'.rand(1000,9999).'.docx';
        $filePath = storage_path('app/public/' . $contrat->chemin_file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->route('contrat.index')->with('error', 'Fichier non trouvé.');
        }
    }

    
    public function generate_facture($id)
    {
        // Récupérer le contrat par ID
        $contrat = Contrat::find($id);

       // Vérifier si une facture existe déjà pour ce contrat
        $existingFacture = Facture::where('contrat_id', $contrat->id)->first();

        if ($existingFacture) {
            return redirect()->route('facture.index')->with('error', 'Une facture existe déjà pour ce contrat.');
        }

        // Créer une nouvelle facture à partir des données du contrat
        $facture = new Facture();
        $facture->contrat_id = $contrat->id; 
        $facture->user_id = $contrat->user_id; 
        $facture->agence_id = $contrat->agence_id;
        $facture->product_id = $contrat->product_id; 
        $facture->date_day = date('Y-m-d'); // date d'aujourd'hui (date de début) 
        $facture->numero_facture = 'FA-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Sauvegarder la facture dans la base de données
        $facture->save();

        // Charger le modèle Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/Templates/Facture.docx'));
        
        $date_aujourdhui = Carbon::now()->toDateString(); 
        $montant = $contrat->product->amout_global;
        $frais_gestion = $contrat->product->frais_gestion;
        $quantite =  $contrat->quantite;


        $pat_sf = $montant - $frais_gestion;

        $pat_sf_t = $quantite * $pat_sf;
        $frais_t = $frais_gestion * $quantite;

        $total = $pat_sf_t + $frais_t;


        // Fonction pour convertir les nombres en lettres
        function convertirNombreEnLettres($nombre) {
            $f = new \NumberFormatter("fr", \NumberFormatter::SPELLOUT);
            return mb_strtoupper($f->format($nombre)); // En majuscules
        }
    
        // Fonction pour ajouter des points au format français
        function formatNombreAvecPoints($nombre) {
            return number_format($nombre, 0, ',', '.');
        }
        
        
        $templateProcessor->setValue('date_aujourdhui', $date_aujourdhui);
        $templateProcessor->setValue('numero_facture', $facture->numero_facture);
        $templateProcessor->setValue('first_name', $contrat->user->first_name);
        $templateProcessor->setValue('last_name', $contrat->user->last_name);
        $templateProcessor->setValue('phone', $contrat->user->phone);
        $templateProcessor->setValue('libelle', $contrat->product->libelle);
        $templateProcessor->setValue('localisation', $contrat->agence->localisation);
        $templateProcessor->setValue('duration_contrat', $contrat->product->duration_contrat);
        $templateProcessor->setValue('quantite', $contrat->quantite);
        $templateProcessor->setValue('frais_gestion', formatNombreAvecPoints($contrat->product->frais_gestion));
        $templateProcessor->setValue('pat_sf', formatNombreAvecPoints($pat_sf));
        $templateProcessor->setValue('pat_sf_t', formatNombreAvecPoints($pat_sf_t));
        $templateProcessor->setValue('frais_t', formatNombreAvecPoints($frais_t));
        $templateProcessor->setValue('total', formatNombreAvecPoints($total));

        
        // Définir le nom du fichier et le chemin
        $fileName = 'FA'.$facture->numero_contrat.'_'.rand(1000,9999).'.docx';
        $path_file = 'factures/' . $fileName;
 
        // verification
        $fullPath = storage_path('app/public/' . $path_file);
        $directory = dirname($fullPath); // Chemin du répertoire
 
         // Vérifiez et créez le répertoire si nécessaire
         if (!file_exists($directory)) {
             mkdir($directory, 0755, true);
         }
     
         // Sauvegarder le fichier Word généré
         $templateProcessor->saveAs(storage_path('app/public/' . $path_file));
     
         // Stocker les informations du contrat dans la base de données
         $facture->chemin_file = $path_file;
         $facture->save();

        // Retourner une réponse
        return redirect()->route('facture.index')->with('success', 'Facture généré et sauvegardé avec succès.');
    }


    public function generate_promo_save($id) 
    {

        Auth::user()->access('GENERATION CONTRAT');
            
        $contrat = Contrat::find($id);
        $product = Product::all();
        $user = User::all();
        $agence = Agence::all();
        $customer = Customer::all();

    
        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé.'], 404);
        }
    
        // Charger le modèle Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/Templates/Promo/Promotion.docx'));
    
        // Fonction pour convertir les nombres en lettres
        function convertirNombreEnLettres($nombre) {
            $f = new \NumberFormatter("fr", \NumberFormatter::SPELLOUT);
            return mb_strtoupper($f->format($nombre)); // En majuscules
        }
    
        // Fonction pour ajouter des points au format français
        function formatNombreAvecPoints($nombre) {
            return number_format($nombre, 0, ',', '.');
        }
    
        // les Variables sans calcule
        $amout_global = $contrat->product->amout_global;
        $frais_gestion = $contrat->product->frais_gestion;
        $pay_mensuel = $contrat->product->pay_mensuel;
        $pay_day = $contrat->product->pay_day;
        $dure_contrat = $contrat->product->duration_contrat;
        $quantite = $contrat->quantite; 
        $date_day = $contrat->date_day;


        $prix_produit = $amout_global * $quantite;  // montant total sans les frais de gestion
        $frais = $frais_gestion * $quantite;  // total des frais de gestion
        
        $prix_produit_avec_frais = $prix_produit;  // montant total sans avec frais de gestion
        $prix_produit_sans_frais = $prix_produit - $frais;  // montant total sans avec frais de gestion

        $pay_mois = $pay_mensuel * $quantite;  // total paiement mensuel
        $pay_jour = $pay_day * $quantite;  // total paiement par jour

        $montant = ($pay_mois * 12) + 200000;  // tMontant total recu par le 
        $date_aujourdhui = Carbon::now()->toDateString(); 

        $premier = $quantite * 200000;  // 


        // Date de carrence
        $date = new \DateTime($date_day);
        $date->modify('+1 month');
        $date_carrence = $date->format('Y-m-d');

        // Debut periode activite
        $periode_date = new \DateTime($date_carrence);
        $periode_date->modify('+1 day');
        $debut_activite = $periode_date->format('Y-m-d');


        // periode d'activité
        $dates = new \DateTime($date_carrence);
        $dates->modify('+1 month');
        $date_activite = $dates->format('Y-m-d');

        
    
        //client
        $templateProcessor->setValue('first_name', $contrat->user->first_name);
        $templateProcessor->setValue('last_name', $contrat->user->last_name);
        $templateProcessor->setValue('genre', $contrat->user->genre);
        $templateProcessor->setValue('date_of_birth', Carbon::parse($contrat->user->date_of_birth)->format('d/m/Y'));
        $templateProcessor->setValue('place_of_birth', $contrat->user->place_of_birth);
        $templateProcessor->setValue('neighborhood', $contrat->user->neighborhood);
        $templateProcessor->setValue('common', $contrat->user->common);
        $templateProcessor->setValue('numero_cni', $contrat->user->numero_cni);
        $templateProcessor->setValue('date_start_cni', Carbon::parse($contrat->user->date_start_cni)->format('d/m/Y'));
        $templateProcessor->setValue('date_end_cni', Carbon::parse($contrat->user->date_end_cni)->format('d/m/Y'));
        $templateProcessor->setValue('etat_matrimonial', $contrat->user->etat_matrimonial);
        $templateProcessor->setValue('work', $contrat->user->fonction);
        $templateProcessor->setValue('email', $contrat->user->email);
        $templateProcessor->setValue('phone', $contrat->user->phone);
        $templateProcessor->setValue('name_doc_client', $contrat->user->name_doc_client);
        
    
        //ayant droit
        $templateProcessor->setValue('first_name_death', $contrat->user->first_name_death);
        $templateProcessor->setValue('last_name_death', $contrat->user->last_name_death);
        $templateProcessor->setValue('numero_piece_death', $contrat->user->numero_piece_death);
        $templateProcessor->setValue('name_doc', $contrat->user->name_doc);
        $templateProcessor->setValue('date_start_doc_death', Carbon::parse($contrat->user->date_start_doc_death)->format('d/m/Y'));
        $templateProcessor->setValue('date_end_doc_death', Carbon::parse($contrat->user->date_end_doc_death)->format('d/m/Y'));
        $templateProcessor->setValue('date_of_birth_death', Carbon::parse($contrat->user->date_of_birth_death)->format('d/m/Y'));
        $templateProcessor->setValue('place_of_birth_death', $contrat->user->place_of_birth_death);
        $templateProcessor->setValue('place_death', $contrat->user->place_death);
        $templateProcessor->setValue('phone_number_death', $contrat->user->phone_number_death);
        $templateProcessor->setValue('genre_death', $contrat->user->genre_death);


    
        // placeholder produit
        $templateProcessor->setValue('libelle', $contrat->product->libelle);
        $templateProcessor->setValue('description', $contrat->product->description);
        $templateProcessor->setValue('duration_contrat', $contrat->product->duration_contrat);
        $templateProcessor->setValue('duration_contrat_l', convertirNombreEnLettres($contrat->product->duration_contrat));
        $templateProcessor->setValue('duration_contrat_c', formatNombreAvecPoints($contrat->product->duration_contrat));
        $templateProcessor->setValue('amout_global', $contrat->product->amout_global);
        $templateProcessor->setValue('type', $contrat->product->type);
        $templateProcessor->setValue('moto_restitue', $contrat->product->moto_restitue);




        // Placeholder information du contrat 
        $templateProcessor->setValue('date_aujourdhui', $date_aujourdhui);
        $templateProcessor->setValue('numero_contrat', $contrat->numero_contrat);
       
        $templateProcessor->setValue('prix_produit_l', convertirNombreEnLettres($prix_produit));
        $templateProcessor->setValue('prix_produit_c', formatNombreAvecPoints($prix_produit));
        $templateProcessor->setValue('frais_l', convertirNombreEnLettres($frais));
        $templateProcessor->setValue('frais_c', formatNombreAvecPoints($frais));
        $templateProcessor->setValue('quantite_l', convertirNombreEnLettres($quantite));
        $templateProcessor->setValue('quantite_c', formatNombreAvecPoints($quantite));
        $templateProcessor->setValue('method_versement', $contrat->method_versement);
        $templateProcessor->setValue('prix_produit_avec_frais_l', convertirNombreEnLettres($prix_produit_avec_frais));
        $templateProcessor->setValue('prix_produit_avec_frais_c', formatNombreAvecPoints($prix_produit_avec_frais));
        $templateProcessor->setValue('pay_mois_l', convertirNombreEnLettres($pay_mois));
        $templateProcessor->setValue('pay_mois_c', formatNombreAvecPoints($pay_mois));
        $templateProcessor->setValue('pay_jour_l', convertirNombreEnLettres($pay_jour));
        $templateProcessor->setValue('pay_jour_c', formatNombreAvecPoints($pay_jour));
        $templateProcessor->setValue('date_firt_payment', Carbon::parse($contrat->date_firt_payment)->format('d/m/Y'));
        $templateProcessor->setValue('date_end_payment', Carbon::parse($contrat->date_end_payment)->format('d/m/Y'));
        $templateProcessor->setValue('montant_l', convertirNombreEnLettres($montant));
        $templateProcessor->setValue('montant_c', formatNombreAvecPoints($montant));
        $templateProcessor->setValue('date_carrence', Carbon::parse($date_carrence)->format('d/m/Y'));
        $templateProcessor->setValue('date_activite', Carbon::parse($date_activite)->format('d/m/Y'));
        $templateProcessor->setValue('date_day', Carbon::parse($date_day)->format('d/m/Y'));
        $templateProcessor->setValue('debut_activite', Carbon::parse($debut_activite)->format('d/m/Y'));

        $templateProcessor->setValue('prix_produit_sans_frais_l', convertirNombreEnLettres($prix_produit_sans_frais));
        $templateProcessor->setValue('prix_produit_sans_frais_c', formatNombreAvecPoints($prix_produit_sans_frais));
        

        
        $templateProcessor->setValue('premier_l', convertirNombreEnLettres($premier));
        $templateProcessor->setValue('premier_c', formatNombreAvecPoints($premier));
        

        // Définir le nom du fichier et le chemin
        $fileName = 'CP'.$contrat->user->numero_cni.'_'.rand(1000,9999).'.docx';
        $path_file = 'contrats/' . $fileName;

        // verification
        $fullPath = storage_path('app/public/' . $path_file);
        $directory = dirname($fullPath); // Chemin du répertoire

        // Vérifiez et créez le répertoire si nécessaire
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
    
        // Sauvegarder le fichier Word généré
        $templateProcessor->saveAs(storage_path('app/public/' . $path_file));
    
        // Stocker les informations du contrat dans la base de données
        $contrat->chemin_file_promo = $path_file;
        $contrat->save();
    
        return redirect()->route('contrat.index')->with('success', 'Contrat généré et sauvegardé avec succès.');
        return response()->json(['message' => 'Contrat généré et sauvegardé avec succès.', 'status' => 'success']);
    }

    public function downloadFilePromo($id) 
    {

        Auth::user()->access('TELECHARGER CONTRAT');

        $contrat = Contrat::find($id);
        $product = Product::all();

        if (!$contrat || !$contrat->chemin_file_promo) {
            return redirect()->route('contrat.index')->with('error', 'Fichier non trouvé.');
        }

        // Chemin du fichier
        $fileName = 'C'.$contrat->user->numero_cni.'_'.rand(1000,9999).'.docx';
        $filePath = storage_path('app/public/' . $contrat->chemin_file_promo);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->route('contrat.index')->with('error', 'Fichier non trouvé.');
        }
    }

    public function add_disponibilite($id)
    {
        Auth::user()->access('AJOUT VERSEMENT');
    
        $contrat = Contrat::with('product')->findOrFail($id);
    
        // Vérifier que le produit est disponible
        if (!$contrat->product) {
            return redirect()->route('contrat.index')->with('error', 'Produit associé introuvable.');
        }
    
        // Vérifier si des versements existent déjà pour ce contrat
        if (Disponibilite::where('contrat_id', $contrat->id)->exists()) {
            return redirect()->route('contrat.index')->with('error', 'Ce contrat est déjà lié à un ou plusieurs versements.');
        }
    
        // Récupérer les paramètres du contrat
        $duree = $contrat->product->duration_contrat; 
        $amount_mensuel = $contrat->product->pay_mensuel; 
        $quantite = $contrat->quantite; 
        $amount_mensuel_total = $amount_mensuel * $quantite; 
    
        // Date du premier paiement
        $firstPayment = Carbon::parse($contrat->date_firt_payment);
    
        // Pour un contrat Normal, le premier versement est à la date du premier paiement
        // Pour l'autre type, on commence à partir du mois suivant.
        if ($contrat->type_contrat === 'Normal') {
            $duration = $duree;     // Nombre total de versements
            $startIndex = 0;        // i = 0 correspond à la date du premier paiement
        } else {
            $duration = $duree - 1;  // Par exemple, si le contrat comporte 12 mois, on génère 11 versements.
            $startIndex = 1;        // Le premier versement se fait 1 mois après le premier paiement.
        }
    
        $disponibilites = [];
        for ($i = $startIndex; $i < $startIndex + $duration; $i++) {
            // On calcule la date de paiement en ajoutant $i mois à la date du premier paiement.
            // La méthode addMonthNoOverflow() permet de conserver le jour (exemple : 30) si celui-ci existe,
            // ou bien de renvoyer le dernier jour du mois sinon.
            $datePayment = $firstPayment->copy()->addMonthNoOverflow($i);
    
            $disponibilites[] = [
                'id'           => (string) Str::uuid(),
                'user_id'      => $contrat->user_id,
                'product_id'   => $contrat->product->id,
                'contrat_id'   => $contrat->id,
                'date_day'     => today(),
                'date_payment' => $datePayment,
                'amount'       => $amount_mensuel_total,
                'compter'      => $i - $startIndex + 1, // Numérotation à partir de 1
            ];
        }
    
        // Insertion groupée pour optimiser
        Disponibilite::insert($disponibilites);
    
        return redirect()->route('contrat.index')->with('success', 'Création de versements réussie.');
    }

    public function auto_add_disponibilite($id)
{
    Auth::user()->access('AJOUT VERSEMENT');

    $contrat = Contrat::with('product')->findOrFail($id);

    // Vérifier que le produit est disponible
    if (!$contrat->product) {
        return redirect()->route('contrat.index')->with('error', 'Produit associé introuvable.');
    }

    // Vérifier si des versements existent déjà pour ce contrat
    if (Disponibilite::where('contrat_id', $contrat->id)->exists()) {
        return redirect()->route('contrat.index')->with('error', 'Ce contrat est déjà lié à un ou plusieurs versements.');
    }

    // Récupérer les paramètres du contrat
    $duree = $contrat->product->duration_contrat; 
    $amount_mensuel = $contrat->product->pay_mensuel; 
    $quantite = $contrat->quantite; 
    $amount_mensuel_total = $amount_mensuel * $quantite; 

    // Date du premier paiement
    $firstPayment = Carbon::parse($contrat->date_firt_payment);

    // Pour un contrat Normal, le premier versement est à la date du premier paiement
    // Pour l'autre type, on commence à partir du mois suivant.
    if ($contrat->type_contrat === 'Normal') {
        $duration = $duree;     // Nombre total de versements
        $startIndex = 0;        // i = 0 correspond à la date du premier paiement
    } else {
        $duration = $duree - 1;  // Par exemple, si le contrat comporte 12 mois, on génère 11 versements.
        $startIndex = 1;        // Le premier versement se fait 1 mois après le premier paiement.
    }

    $disponibilites = [];
    for ($i = $startIndex; $i < $startIndex + $duration; $i++) {
        // On calcule la date de paiement en ajoutant $i mois à la date du premier paiement.
        // La méthode addMonthNoOverflow() permet de conserver le jour (exemple : 30) si celui-ci existe,
        // ou bien de renvoyer le dernier jour du mois sinon.
        $datePayment = $firstPayment->copy()->addMonthNoOverflow($i);

        $disponibilites[] = [
            'id'           => (string) Str::uuid(),
            'user_id'      => $contrat->user_id,
            'product_id'   => $contrat->product->id,
            'contrat_id'   => $contrat->id,
            'date_day'     => today(),
            'date_payment' => $datePayment,
            'amount'       => $amount_mensuel_total,
            'compter'      => $i - $startIndex + 1, // Numérotation à partir de 1
        ];
    }

    // Insertion groupée pour optimiser
    Disponibilite::insert($disponibilites);

    return ['success' => 'Versements ajoutés avec succès.'];
}

}
