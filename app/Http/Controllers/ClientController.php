<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Agence;
use App\Models\Role;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use App\Models\Employe;
use App\Models\Facture;
use App\Models\AgenceUser;
use App\Models\ContratsEmployes;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE PARTENAIRE");
        $clients = Client::with('user','customer')
        ->paginate(100);
        return view('client.index',compact('clients'));
    } 

    public function add($id)
    {
        $client = Client::find($id);
       
        $client = new Client;
        $title = "Affectation d'un utilisateur à un client";

        Auth::user()->access('AJOUT PARTENAIRE');
        
        $user = User::orderBy('first_name', 'asc')->get();
        $customer = Customer::orderBy('first_name', 'asc')->get();
        return view('client.save',compact('client','title','user','customer'));
    }

    public function save(Request $request)
    {
        Auth::user()->access('AJOUT PARTENAIRE');

        $validator = $request->validate([
            'user_id' => 'required|string|exists:users,id',
            'customer_id' => 'required|string|exists:customers,id',
        ]);

        $utilisateur = Client::where('user_id', $request->user_id)
        ->where('id', '!=', $request->id)
        ->first();

        if ($utilisateur) {
            return response()->json([
                'message' => 'Cet utilisateur est déjà affecté à une client.','status' => 'error'
            ]);
        } 
        
        else {
            // Création de l'enregistrement dans la table agences_user
            $data = [
                'user_id' => $request->user_id,
                'customer_id' => $request->customer_id,
            ];

            $client = Client::create($data);

            return response()->json([
                'message' => 'Partenaire enregistré avec succès.',
                'status' => 'success',
            ]);
        }
    }

    public function delete(Request $request)
        {

            Auth::user()->access('SUPPRESSION PARTENAIRE');

            $client = Client::find($request->id);
            $hasContrats = Contrat::where('client_id', $client->id)->exists();
            $hasFactures = Facture::where('client_id', $client->id)->exists();

            if ($hasContrats) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un ou plusieurs contrats.',
                    'status' => 'error'
                ]);
            }

            if ($hasFactures) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à une ou plusieurs factures.',
                    'status' => 'error'
                ]);
            }

            if($client->delete()){
                return response()->json(['message' => 'Partenaire supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
}
