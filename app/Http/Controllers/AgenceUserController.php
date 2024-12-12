<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Contrat;
use App\Models\Agence;
use App\Models\AgenceUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgenceUserController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE AGENT");
        $agenceUsers = AgenceUser::with('user','agence')
        ->paginate(100);
        return view('agent.index',compact('agenceUsers'));
    }

    public function add($id)
        {
            $agenceUser = AgenceUser::find($id);
           
            $agenceUser = new AgenceUser;
            $title = "Affectation d'un utilisateur";

            Auth::user()->access('AJOUT AGENT');
            
            $user = User::orderBy('first_name', 'asc')->get();
            $agence = Agence::orderBy('libelle', 'asc')->get();
            return view('agent.save',compact('agenceUser','title','user','agence'));
        }


    public function save(Request $request)
    {
        Auth::user()->access('AJOUT AGENT');

        $validator = $request->validate([
            'user_id' => 'required|string|exists:users,id',
            'agence_id' => 'required|string|exists:agences,id',
        ]);

        $utilisateur = AgenceUser::where('user_id', $request->user_id)
        ->where('id', '!=', $request->id)
        ->first();

        if ($utilisateur) {
            return response()->json([
                'message' => 'Cet utilisateur est déjà affecté à une agence.','status' => 'error'
            ]);
        } 
        
        else {
            // Création de l'enregistrement dans la table agences_user
            $data = [
                'user_id' => $request->user_id,
                'agence_id' => $request->agence_id,
            ];

            $agenceUser = AgenceUser::create($data);

            return response()->json([
                'message' => 'Utilisateur enregistré avec succès.',
                'status' => 'success',
            ]);
        }
    }

    public function delete(Request $request)
        {

            Auth::user()->access('SUPPRESSION AGENT');

            $agenceUser = AgenceUser::find($request->id);

            if($agenceUser->delete()){
                return response()->json(['message' => 'Agent supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

}
 