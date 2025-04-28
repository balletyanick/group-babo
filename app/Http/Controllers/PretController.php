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



class PretController extends Controller
{
    public function index()
    {
        Auth::user()->access('LISTE PRET EN COURS'); 

        $prets = Pret::with('contrat')->where('status', 0) // Filtrer les prêts avec status = 0
        ->paginate(100);

        return view('pret.index', compact('prets')); 
    }

    public function liste()
    {
        Auth::user()->access('LISTE PRET VALIDEE'); 

        $prets = Pret::with('contrat')->whereIn('status', [1, 2]) // Filtrer les prêts avec status = 1 ou 2
        ->paginate(100);

        return view('pret.liste', compact('prets')); 
    }


    public function add($id)
    {
        $pret = Pret::find($id);
      
        $pret = new Pret;
        $title = 'Demander un prêt';

        Auth::user()->access('AJOUT PRET'); 
        
        $contrat = Contrat::all();
        return view('pret.save',compact('pret','contrat','title'));
    }

    public function save(Request $request)
    {
        Auth::user()->access('AJOUT PRET');

        $validator = $request->validate([
            'contrat_id' => 'required|string|exists:contrats,id', 
            'amount' => 'required|integer',
            'duration' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['status'] = 0;
        $data['date_day'] = Carbon::now()->format('Y-m-d');

        // Vérifier si un prêt existe déjà pour ce contrat
        $existingPret = Pret::where('contrat_id', $data['contrat_id'])->first();
        
        if ($existingPret) {
            return response()->json([
                'message' => "Un prêt existe déjà pour ce contrat.",
                'status'  => 'error'
            ], 400);
        }


        $contrat = Contrat::with('product')->find($data['contrat_id']);
        $durationContrat = $contrat->product->duration_contrat;

        if ($data['duration'] > $durationContrat) {
            return response()->json([
                'message' => "La durée du prêt dépasse la durée du contrat.",
                'status'  => 'error'
            ], 400);
        }


        // Récupérer les valeurs demandées
        $quantite = $contrat->quantite;
        $payMensuel = $contrat->product->pay_mensuel;
        $durationContrat = $contrat->product->duration_contrat;

        // Calcul du montant total
        $totalAmount = $quantite * $payMensuel;

        if ($data['amount'] > $totalAmount) {
            return response()->json([
                'message' => "Le montant demandé dépasse le montant disponible par mois.",
                'status'  => 'error'
            ], 400);
        }

        // Récupérer la deuxième date disponible pour ce contrat 
        // (la date_payment doit être supérieure à $data['date_day'])
        $disponibilite = Disponibilite::where('contrat_id', $data['contrat_id'])
        ->where('date_payment', '>', $data['date_day'])
        ->orderBy('date_payment') // ordre croissant des dates
        ->skip(1) // ignorer la première date
        ->first(); // récupérer la deuxième date

        if (!$disponibilite) {
            return response()->json([
                'message' => "Aucun montant disponible trouvée pour ce contrat.",
                'status'  => 'error'
            ], 400);
        }

        $data['date_start'] = $disponibilite->date_payment;
        $periode =  $data['duration'] - 1;

        $data['date_end'] = Carbon::parse($data['date_start'])
        ->addMonthsNoOverflow($periode)
        ->format('Y-m-d');

        $pret = Pret::create($data);
        return response()->json(['message' => 'Pret enregistré avec succès', 'status' => 'success']);
    }

    public function edit($id)
    { 
        Auth::user()->access('EDITION PRET');
        $title = 'Modifier le prêt';

        $pret = Pret::find($id);
        $contrat = Contrat::all();

        return view('pret.edit', compact('contrat', 'title', 'pret'));
    }


    public function save_edit(Request $request)
    {   

        Auth::user()->access('EDITION PRET');

        $validator = $request->validate([
            'contrat_id' => 'required|string|exists:contrats,id', 
            'amount' => 'required|integer',
            'duration' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $pret = Pret::findOrFail($request->id);
        $data = $request->all();

        $date_start = $pret->date_start;
        $periode =  $data['duration'] - 1;

        $data['date_end'] = Carbon::parse($date_start)
        ->addMonthsNoOverflow($periode)
        ->format('Y-m-d');

        $pret->update($data);

        return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
    }



    public function delete(Request $request)
    { 
        Auth::user()->access('SUPPRESSION PRET');
        $pret = Pret::find($request->id);


        if($pret->delete()){
            return response()->json(['message' => 'Information du contrat supprimé avec succès',"status"=>"success"]);
        }else{
            return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
        }
    }

    public function mensualite($id)
    {
        Auth::user()->access('LISTE MENSUALITE PRET'); 

        $pret = Pret::with('contrat') // Charger la relation contrat
        ->where('id', $id)
        ->first(); 

        return view('pret.mensualite', compact('pret'));
    }

    public function refuser_pret($id)
    {
        Auth::user()->access("REFUSER PRET");

        $pret = Pret::find($id); 

        // Vérification si le paiement existe
        if (!$pret) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prêt introuvable.',
            ]);
        }

        // Modifier le statut en 2 (refusé)
        $pret->status = 2;
        $pret->save();

        // Réponse JSON de succès
        return response()->json([
            'status' => 'success',
            'message' => 'Prêt refusé avec succès.',
        ]);
    }

    public function valider_pret($id)
    {
        Auth::user()->access("VALIDER PRET");

        $pret = Pret::find($id);

        // Récupérer le contrat associé au paiement
        $contrat = Contrat::find($pret->contrat_id);

        // Calcul de la mensualité et arrondir
        $paiementMensuel = ($pret->amount * 18 / 100 + $pret->amount) / $pret->duration;
        $paiementMensuelInt = (int) round($paiementMensuel);


        $disponibilites = Disponibilite::where('contrat_id', $pret->contrat_id)
        ->whereBetween('date_payment', [$pret->date_start, $pret->date_end]) // Inclut date_start et date_end
        ->get(); // Récupérer toutes les dates


        // Pour chaque disponibilité, on soustrait le paiement mensuel du montant (amount)
        foreach ($disponibilites as $disponibilite) {
            $nouveauMontant = $disponibilite->amount - $paiementMensuelInt;
            $disponibilite->update(['amount' => $nouveauMontant]);
        }

        // Modifier le statut en 1 (validé)
        $pret->status = 1;
        $pret->save();

        return response()->json([
                'status' => 'success',
                'message' => 'Paiement validé avec succès..',
        ]);
    } 


    public function mes_prets()
    {
        Auth::user()->access('LISTE PRET CLIENT'); 

        $prets = Pret::whereHas('contrat', function ($query) {
            $query->where('user_id', Auth::id()); // Vérifie que le contrat appartient à l'utilisateur connecté
        })
        ->paginate(100);

        return view('pret.mes_prets', compact('prets')); 
    }
    
}
