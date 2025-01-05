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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgenceController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE AGENCE");
        $agences = Agence::paginate(100);
        return view('agence.index',compact('agences'));
    } 

    public function add($id)
    {
        $agence = Agence::find($id);

        if(!is_null($agence)){
            $title = "Modifier l'agence";

            Auth::user()->access('EDITION AGENCE');
        }else{
            $agence = new Agence;
            $title = 'Ajouter une agence';

            Auth::user()->access('AJOUT AGENCE');
        } 
        return view('agence.save',compact('agence','title')); 
    }

    
    public function save(Request $request)
        {
            if($request->id){
                Auth::user()->access('EDITION AGENCE');
            } else {
                Auth::user()->access('AJOUT AGENCE');
            }

            $validator = $request->validate([
                'libelle' => 'required|string',
                'localisation' => 'required|string',
                'note' => 'nullable|string',
            ]);

            $agence = Agence::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            ); 

            return response()->json(['message' => 'Agence enregistré avec succès', 'status' => 'success']);
        }


    public function delete(Request $request)
        {
            Auth::user()->access('SUPPRESSION AGENCE');

            $agence = Agence::find($request->id);
            $hasContrats = Contrat::where('agence_id', $agence->id)->exists();
            $hasEmployes = Employe::where('agence_id', $agence->id)->exists();
            $hasFactures = Facture::where('agence_id', $agence->id)->exists();
            $hasAgenceUser = AgenceUser::where('agence_id', $agence->id)->exists();


            if ($hasContrats) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un ou plusieurs contrats.',
                    'status' => 'error'
                ]);
            }

            if ($hasEmployes) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un ou plusieurs employés.',
                    'status' => 'error'
                ]);
            }

            if ($hasFactures) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à une ou plusieurs factures.',
                    'status' => 'error'
                ]);
            }

            if ($hasAgenceUser) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un ou plusieurs agent.',
                    'status' => 'error'
                ]);
            }
            

            if($agence->delete()){
                return response()->json(['message' => 'Agence supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }


    
}
