<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use App\Models\Agence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContratController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE CONTRAT");
        $contrats = Contrat::with('customer','product','user','agence')
        ->paginate(100);

        return view('contrat.index',compact('contrats'));
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
        
        $customer = Customer::all();
        $product = Product::all();
        $user = User::all();
        $agence = Agence::all();
        return view('contrat.save',compact('contrat','title','customer','product','user','agence'));
    }

    public function save(Request $request)
    {
        Auth::user()->access('AJOUT CONTRAT');

        $validator = $request->validate([
            'customer_id' => 'required|string|exists:customers,id', 
            'product_id' => 'required|string|exists:products,id',
            'agence_id' => 'required|string|exists:agences,id',
            'quantite' => 'required|integer',
            'note' => 'nullable|string',
            'method_versement' => 'required|string',
        ]);

        $data = $request->all();

        $data['user_id'] = Auth::user()->id; // Ajoute l'ID de l'utilisateur connecté
        $data['date_day'] = date('Y-m-d'); // date d'aujourd'hui (date de début)
        $data['numero_contrat'] = 'BC-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $data['status'] = 0;


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
  
        
        Contrat::create($data);

        return response()->json(['message' => 'Contrat enregistré avec succès', 'status' => 'success']);
    }

    public function delete(Request $request){ 

        Auth::user()->access('SUPPRESSION CONTRAT');

        $contrat = Contrat::find($request->id);

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
        $customer = User::all();
        $product = Product::all();
        $agence = Agence::all();

        return view('contrat.edit', compact('contrat', 'title', 'customer', 'product','agence'));
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




}
