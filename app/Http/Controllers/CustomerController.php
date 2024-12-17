<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Customer;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage; 

    class CustomerController extends Controller
    {
        public function index()
        {
            Auth::user()->access("LISTE CLIENT");
            $customers = Customer::paginate(100);
            return view('customer.index',compact('customers'));
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

            if($customer->delete()){
                return response()->json(['message' => 'Client supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function edit($id)
        { 
            Auth::user()->access('EDITION CLIENT');
            $customer = Customer::find($id);
            $title = "Modifier un client";
    
            return view('customer.edit', compact('title', 'customer'));
        }
    
    
        public function save_edit(Request $request)
        {   
    
            Auth::user()->access('EDITION CLIENT');
        
            $validator = $request->validate([
                    'user_id' => 'required|string|exists:users,id',
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
        
            $customer = Customer::findOrFail($request->id);
        
            $data = $request->only(['first_name','last_name','genre', 'date_of_birth', 'place_of_birth', 'neighborhood', 'common', 'numero_cni',
            'date_start_cni', 'date_end_cni', 'etat_matrimonial', 'work', 'name_doc_client', 'email', 'phone', 'note_second',
            'note_first', 'first_name_death', 'last_name_death', 'numero_piece_death', 'name_doc', 'date_start_doc_death', 'date_end_doc_death', 'date_of_birth_death',
            'place_of_birth_death', 'place_death', 'phone_number_death', 'genre_death',]);
            
            $customer->update($data);
        
            return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
        }
    }