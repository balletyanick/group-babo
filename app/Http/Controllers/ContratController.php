<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContratController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE CONTRAT");
        $contrats = Contrat::with('customer','product')
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
        return view('contrat.save',compact('contrat','title','customer','product','user'));
    }

    public function save(Request $request)
    {
        Auth::user()->access('AJOUT CONTRAT');

        $validator = $request->validate([
            'customer_id' => 'required|string|exists:customers,id',
            'product_id' => 'required|string|exists:products,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'amount_global' => 'required|integer',
            'num_contrat' => 'required|string',
            'type_contrat' => 'required|string',
            'quantite' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $data = $request->only([ 
        'date_start','date_end','num_contrat','type_contrat','quantite', 'note']);

        $data['customer_id'] = $request->input('customer_id');
        $data['product_id'] = $request->input('product_id');
        $data['amount_global'] = $request->input('amount_global') * $request->input('quantite');
        $data['dispo_retrait'] = 0;
        
        Contrat::create($data);

        return response()->json(['message' => 'Informations du contrat enregistré avec succès', 'status' => 'success']);
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
        $title = 'Modifier les informations du contrat';

        $contrat = Contrat::find($id);
        $customer = User::all();
        $product = Product::all();

        return view('contrat.edit', compact('contrat', 'title', 'customer', 'product'));
    }


    public function save_edit(Request $request)
    {   

        Auth::user()->access('EDITION CONTRAT');

        $validator = $request->validate([
            'customer_id' => 'required|string|exists:customers,id',
            'product_id' => 'required|string|exists:products,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'amount_global' => 'required|integer',
            'num_contrat' => 'required|string',
            'type_contrat' => 'required|string',
            'quantite' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $contrat = Contrat::findOrFail($request->id);

        $data = $request->only(['customer_id','product_id', 
        'date_start','date_end','amount_global','num_contrat','type_contrat', 'note', 'quantite']);
        
        $contrat->update($data);

        return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
    }

    public function add_montant($id)
    { 
        Auth::user()->access('AJOUTER DISPONIBILITE RETRAIT');
        $title = 'Augmenter le montant disponible pour le retrait';

        $contrat = Contrat::find($id);
        $customer = User::all();
        $product = Product::all();

        return view('contrat.add_montant', compact('contrat', 'title', 'customer', 'product'));
    }

    public function save_add_montant(Request $request) 
{
    Auth::user()->access('AJOUTER DISPONIBILITE RETRAIT');

    $validator = $request->validate([
        'dispo_retrait' => 'required|integer',
    ]);

    $contrat = Contrat::findOrFail($request->id); 

    // Additionner la valeur existante et la valeur envoyée
    $nouveau_dispo_retrait = $contrat->dispo_retrait + $request->input('dispo_retrait');

    // Récupérer la somme de tous les paiements validés (status = 1) liés à ce contrat
    $pay = Paiement::where('contrat_id', $contrat->id)
    ->where('customer_id', $contrat->customer_id)
    ->where('status', 1)
    ->sum('amount'); 

    $payer = $contrat->amount_global - $pay;

    // Vérifier si le nouveau dispo_retrait est <= à amount_global
    if ($nouveau_dispo_retrait <= $payer) {
        // Mettre à jour la valeur de dispo_retrait dans la base de données
        $contrat->dispo_retrait = $nouveau_dispo_retrait;
        $contrat->save();

        return response()->json(['message' => 'Disponibilité retrait mise à jour avec succès', 'status' => 'success']);
    } 
    
    else {
        // Retourner un message d'erreur si la condition n'est pas respectée
        return response()->json(['message' => 'Erreur : la somme dépasse le montant disponible', 'status' => 'error'], 400);
    }
}

}
