<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request; 
    use App\Models\Customer;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Employe;
    use App\Models\Agence;
    use App\Models\ContratsEmployes;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage; 

class ContratsEmployesController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE CONTRAT EMPLOYE");
        $contratsemployes = ContratsEmployes::with('employe')
        ->paginate(100);

        return view('contrat-employe.index',compact('contratsemployes'));
    }


    public function add($id)
    {
        Auth::user()->access('LISTE CONTRAT EMPLOYE');
        $title = 'Créer un contrat';

        $contratsemploye = ContratsEmployes::find($id);

        $contratsemploye = new ContratsEmployes;
        $employe = Employe::All();

        
        return view('contrat-employe.save',compact('contratsemploye','title','employe')); 
    }

    public function save(Request $request) 
        {
            Auth::user()->access('AJOUT CONTRAT EMPLOYE');

            $validator = $request->validate([
                'employe_id' => 'required|string|exists:employes,id',
                'poste' => 'required|string',
                'date_start' => 'required|date',
                'salaire' => 'required|integer',
                'time_contrat' => 'required|integer',
                'note' => 'nullable|string',
            ]);


            $data = $request->all();
            $data['status'] = 0; 
            $contratsemploye = ContratsEmployes::create($data);

            return response()->json(['message' => 'Contrat enregistré avec succès', 'status' => 'success']);
        }
 

        public function delete(Request $request){

            Auth::user()->access('SUPPRESSION CONTRAT EMPLOYE');

            $contratsemploye = ContratsEmployes::find($request->id);

            if($contratsemploye->delete()){
                return response()->json(['message' => 'Contrat supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function resilier(Request $request)
        {
            Auth::user()->access('RESILIATION CONTRAT EMPLOYE');

            $contratsemploye = ContratsEmployes::find($request->id);

            // Mettre à jour le statut à 1 (Résilié)
            $contratsemploye->status = 1;

            if ($contratsemploye->save()) {
                return response()->json(['message' => 'Contrat résilié avec succès', "status" => "success"]);
            } else {
                return response()->json(['message' => 'Échec de la résiliation, veuillez réessayer', "status" => "error"]);
            }
        }


        public function edit($id)
        { 
            Auth::user()->access('EDITION CONTRAT EMPLOYE');
            $contratsemploye = ContratsEmployes::find($id);
            $title = "Modifier un contrat";

            $employe = Employe::All();
            return view('contrat-employe.edit', compact('title', 'contratsemploye', 'employe'));
        }
    
    
        public function save_edit(Request $request)
        {   
            Auth::user()->access('EDITION CONTRAT EMPLOYE');
        
            $validator = $request->validate([
                'employe_id' => 'required|string|exists:employes,id',
                'poste' => 'required|string',
                'date_start' => 'required|date',
                'salaire' => 'required|integer',
                'time_contrat' => 'required|integer',
                'note' => 'nullable|string',
            ]);
        
            $contratsemploye = ContratsEmployes::findOrFail($request->id);
        
            $data = $request->all();
            $contratsemploye->update($data);
        
            return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
        }
}
