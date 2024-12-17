<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request; 
    use App\Models\Customer;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Employe;
    use App\Models\Agence;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage; 

class EmployesController extends Controller
{
    public function index()
        {
            Auth::user()->access("LISTE EMPLOYE");
            $employes = Employe::with('user','agence')
            ->paginate(100);

            // Regrouper les employés par agence
            $agence = Agence::All();

            return view('employe.index',compact('employes','agence'));
        }

        public function list($id)
        {
             // Récupérer l'agence en utilisant l'ID de l'employé (agence_id)
            $agence = Agence::findOrFail($id);

            // Paginer les employés
            $employes = Employe::where('agence_id', $agence->id)->paginate(100);

            // Passer les données à la vue
            return view('employe.list', compact('employes', 'agence'));
        }

 
        public function add($id)
        {
            $employe = Employe::find($id);
            
            $employe = new Employe;
            $title = 'Ajouter un employé';

            Auth::user()->access('AJOUT EMPLOYE');
            $agence = Agence::orderBy('libelle', 'asc')->get();
            
            return view('employe.save',compact('employe','title','agence')); 
        }


        public function save(Request $request) 
        {
            Auth::user()->access('AJOUT EMPLOYE');

            $validator = $request->validate([
                'agence_id' => 'required|string|exists:agences,id',
                'genre' => 'required|string',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'place_of_birth' => 'required|string',
                'date_of_birth' => 'required|date',
                'note' => 'nullable|string',
                'name_doc_client' => 'required|string',
                'numero_piece' => 'required|string',
                'common' => 'required|string',
                'neighborhood' => 'required|string',
                'date_start_doc' => 'required|date',
                'date_end_doc' => 'required|date',
            ]);

            $employe =  Employe::where('email', $request->email)
                                ->where('id', '!=', $request->id)
                                ->first();

            $utilisateur = Employe::where('phone', $request->phone)
                                ->where('phone', '!=', $request->phone)
                                ->first();

            $piece_identite = Employe::where('numero_piece', $request->numero_piece)
                                ->where('numero_piece', '!=', $request->numero_piece)
                                ->first();

            if ($employe) {
                return response()->json(['message' => 'Le mail est déja lié à un client..', "status" => "error"]);
            } 
            
            else if ($utilisateur) {
                return response()->json(['message' => 'Le numero de téléphone est déja lié à un client.', "status" => "error"]);
            }

            else if ($piece_identite) {
                return response()->json(['message' => 'Le numero de la pièce est déja lié à un client.', "status" => "error"]);
            }

            else {

                $data = $request->all();
                $data['user_id'] = Auth::user()->id; // Ajoute l'ID de l'utilisateur connecté
                $data['mat_employe'] = 'BC-' . random_int(1000, 9999); // Génération du matricule BC-4chiffres

                $employe = Employe::create($data);
            }

            return response()->json(['message' => 'Employé enregistré avec succès', 'status' => 'success']);
        }
 

        public function delete(Request $request){

            Auth::user()->access('SUPPRESSION EMPLOYE');

            $employe = Employe::find($request->id);

            if($employe->delete()){
                return response()->json(['message' => 'Client supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function edit($id)
        { 
            Auth::user()->access('EDITION EMPLOYE');
            $employe = Employe::find($id);
            $title = "Modifier un employé";

            $agence = Agence::orderBy('libelle', 'asc')->get();

            return view('employe.edit', compact('title', 'employe', 'agence'));
        }
    
    
        public function save_edit(Request $request)
        {   
            Auth::user()->access('EDITION EMPLOYE');
        
            $validator = $request->validate([
                'agence_id' => 'required|string|exists:agences,id',
                'user_id' => 'required|string|exists:users,id',
                'genre' => 'required|string',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'place_of_birth' => 'required|string',
                'date_of_birth' => 'required|date',
                'note' => 'nullable|string',
                'name_doc_client' => 'required|string',
                'numero_piece' => 'required|string',
                'common' => 'required|string',
                'neighborhood' => 'required|string',
                'date_start_doc' => 'required|date',
                'date_end_doc' => 'required|date',
            ]);
        
            $employe = Employe::findOrFail($request->id);
        
            $data = $request->all();
            $employe->update($data);
        
            return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
        }
}
 