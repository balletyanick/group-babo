<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Customer;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Facture;
    use App\Models\Contrat;
    use App\Models\Client;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage; 
    use Illuminate\Support\Facades\DB;

    class CustomerController extends Controller
    {
        public function index()
        {
            // Filtrer les clients selon les permissions de l'utilisateur
            $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'PARTENAIRE')
            ->select('users.*')
            ->paginate(100);
            
            return view('customer.index', compact('users'));
        }

 
        public function add($id)
        {
            $customer = Customer::find($id);
            
            $customer = new Customer;
            $title = 'Ajouter un client';

            Auth::user()->access('AJOUT CLIENT');
            
            return view('customer.save',compact('customer','title'));
        }

        public function save(Request $request) 
        {
            Auth::user()->access('AJOUT CLIENT');

            $validator = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'genre' => 'required|string',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string',
                'neighborhood' => 'required|string',
                'common' => 'required|string',
                'numero_cni' => 'required|string',
                'date_start_cni' => 'nullable|date',
                'date_end_cni' => 'nullable|date',
                'etat_matrimonial' => 'required|string',
                'work' => 'required|string',
                'name_doc_client' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'note_second' => 'nullable|string',
                'note_first' => 'nullable|string',
                'first_name_death' => 'required|string',
                'last_name_death' => 'required|string',
                'numero_piece_death' => 'required|string',
                'name_doc' => 'required|string',
                'date_start_doc_death' => 'nullable|date',
                'date_end_doc_death' => 'nullable|date',
                'date_of_birth_death' => 'required|date',
                'place_of_birth_death' => 'required|string',
                'place_death' => 'required|string',
                'phone_number_death' => 'nullable|string',
                'genre_death' => 'required|string',
            ]);

            $customer = Customer::where('numero_cni', $request->numero_cni)
                                ->where('id', '!=', $request->id)
                                ->first();

            $utilisateur = Customer::where('phone', $request->phone)
                                ->where('phone', '!=', $request->phone)
                                ->first();

            if ($customer) {
                return response()->json(['message' => 'Identifiant de la pièce est déja lié à un client..', "status" => "error"]);
            } 
            
            else if ($utilisateur) {
                return response()->json(['message' => 'Le numero de téléphone est déja lié à un client.', "status" => "error"]);
            }

            else {

                $data = $request->all();
                $data['user_id'] = Auth::user()->id; // Ajoute l'ID de l'utilisateur connecté

                $customer = Customer::create($data);
            }

            return response()->json(['message' => 'Client enregistré avec succès', 'status' => 'success']);
        }
 

        public function delete(Request $request){

            Auth::user()->access('SUPPRESSION CLIENT');

            $customer = Customer::find($request->id); 
            $hasClient = Client::where('customer_id', $customer->id)->exists();

            if ($hasClient) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un partenaire.',
                    'status' => 'error'
                ]);
            }

            if($customer->delete()){
                return response()->json(['message' => 'Client supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function edit($id)
        { 
            Auth::user()->access('EDITION CLIENT');
            $user = User::find($id);
            $title = "Modifier un client";
    
            return view('customer.edit', compact('title', 'user'));
        }
    
    
    public function save_edit(Request $request)
        {   
            Auth::user()->access('EDITION CLIENT');

            $validator = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'password' => 'nullable|string|min:6|confirmed',
                'genre' => 'nullable|string',
                'date_of_birth' => 'nullable|date',
                'place_of_birth' => 'nullable|string',
                'neighborhood' => 'nullable|string',
                'common' => 'nullable|string',
                'numero_cni' => 'nullable|string',
                'date_start_cni' => 'nullable|date',
                'date_end_cni' => 'nullable|date',
                'etat_matrimonial' => 'nullable|string',
                'name_doc_client' => 'nullable|string',
                'note_second' => 'nullable|string',
                'note_first' => 'nullable|string',
                'first_name_death' => 'nullable|string',
                'last_name_death' => 'nullable|string',
                'numero_piece_death' => 'nullable|string',
                'name_doc' => 'nullable|string',
                'date_start_doc_death' => 'nullable|date',
                'date_end_doc_death' => 'nullable|date',
                'date_of_birth_death' => 'nullable|date',
                'place_of_birth_death' => 'nullable|string',
                'place_death' => 'nullable|string',
                'phone_number_death' => 'nullable|string',
                'genre_death' => 'nullable|string',
            ]);

            // Vérifier si l'utilisateur existe
            $user = User::find($request->id);
            if (!$user) {
                return response()->json(['message' => 'Utilisateur non trouvé'], 404);
            }

            // Récupérer les données
            $data = $request->all();

            // Vérifier si un nouveau mot de passe est fourni
            if (!$request->filled('password')) {
                $data['password'] = $user->password;
            } else {
                $data['password'] = bcrypt($request->password);
            }

            // Mettre à jour l'utilisateur
            $user->update($data);

            return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
        }

    }