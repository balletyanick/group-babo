<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Business;
    use App\Models\Role;
    use App\Models\Region;
    use App\Models\Customer;
    use App\Models\Facture;
    use App\Models\Contrat;
    use App\Models\Employe;
    use App\Models\Agence;
    use App\Models\ContratsEmployes;
    use App\Models\AgenceUser;
    use App\Models\Client;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Http;


    class UserController extends Controller
    {
        public function index()
        {
            Auth::user()->access('LISTE UTILISATEUR');

            $departement_id = Auth::user()->departement_id;
            $region_id = Auth::user()->region_id;
            $sous_prefecture_id = Auth::user()->sous_prefecture_id;
            

            if(!is_null($sous_prefecture_id)){

                $users = User::where('sous_prefecture_id',$sous_prefecture_id)->paginate(100);

            }elseif(!is_null($departement_id)){

                $users = User::where('departement_id',$departement_id)->paginate(100);

            }elseif(!is_null($region_id)){

                $users = User::where('region_id',$region_id)->paginate(100);

            }else{
                $users = User::whereHas('role', function($query) {
                    $query->where('name', '<>', 'PARTENAIRE');
                })->paginate(100);
                
            }
            
            return view('user.index',compact('users'));
        }

        public function liste()
        {
            Auth::user()->access('LISTE UTILISATEUR PARTENAIRE');

            $departement_id = Auth::user()->departement_id;
            $region_id = Auth::user()->region_id;
            $sous_prefecture_id = Auth::user()->sous_prefecture_id;
            

            if(!is_null($sous_prefecture_id)){

                $users = User::where('sous_prefecture_id',$sous_prefecture_id)->paginate(100);

            }elseif(!is_null($departement_id)){

                $users = User::where('departement_id',$departement_id)->paginate(100);

            }elseif(!is_null($region_id)){

                $users = User::where('region_id',$region_id)->paginate(100);

            }else{
                $users = User::paginate(100);
                $users = User::whereHas('role', function ($query) {
                    $query->where('name', 'PARTENAIRE');
                })->paginate(100);                
            }
            
            return view('user.liste',compact('users'));
        }


        public function add($id)
        {
            $user = User::find($id);

            if(!is_null($user)){
                $title = "Modifier $user->fist_name $user->last_name";

                Auth::user()->access('EDITION UTILISATEUR');
            }else{
                $user = new User;
                $title = 'Ajouter un utilisateur';

                Auth::user()->access('AJOUT UTILISATEUR');
            }
            
            $roles = Role::all();
            return view('user.save',compact('user','title','roles'));
        }

        public function add_user($id)
        {
            $user = User::find($id);

            if(!is_null($user)){
                $title = "Modifier $user->fist_name $user->last_name";

                Auth::user()->access('EDITION UTILISATEUR');
            }else{
                $user = new User;
                $title = 'Ajouter un utilisateur';

                Auth::user()->access('AJOUTER UTILISATEUR PARTENAIRE');
            }
            
            $roles = Role::all();
            return view('user.saves',compact('user','title','roles'));
        }

        public function save(Request $request)
        {
            $validator = $request->validate([
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
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

            // Message à envoyer
            $smsMessage = "Connecter vous via ce lien: https://pay.babo-manager.com. Vos accès: Email : {$request->email} et le Mot de passe : {$request->password}";
    
            // Envoyer le SMS via l'API SMS
            $response = Http::post('https://sms.acim-ci.net:8443/api/addFullSms', [
                'Username' => 'phenixApi',
                'Token' => '$2a$10$ecyCD2d.Igj2n6ZpPcka5uMQmRW53dGOFnSm/OzSiubtYWm9q86kK',
                'Sender' => 'PHENIX TRAN',
                'Flash' => '0',
                'Sms' => $smsMessage,
                'Title' => 'Bienvenue',
                'Contact' => [
                    ['Dest' => $request->phone]
                ],
            ]);
            
            
            $data = $request->except(['avatar']);
            $user = User::where('email', $data['email'])->where('id', '!=', $request->id)->first();

            if ($user) {
                return response()->json(['message' => 'L\'adresse e-mail est déjà utilisée.',"status"=>"error"]);
            } else {
                
                $file = $request->file('avatar');
                if ($file) {
                    $filePath = $file->storeAs('public/avatar', $file->hashName());
                    $data['avatar'] = $filePath ?? '';
                    $data['avatar'] = str_replace('public/','',$data['avatar']);
                }
            
                if ($request->filled('password')) {
                    $data['password'] = bcrypt($request->password);
                }else{
                    $user = User::find($request->id);
                    $data['password'] = $user->password;
                }
            
                $user = User::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
             
            return response()->json(['message' => 'Utilisateur enregistré avec succès', 'status' => 'success']);
            

        }

        public function delete(Request $request){ 

            Auth::user()->access('SUPPRESSION UTILISATEUR');
            $user = User::find($request->id);
            $hasCusromers = Customer::where('user_id', $user->id)->exists();
            $hasContrats = Contrat::where('user_id', $user->id)->exists();
            $hasFacture = Facture::where('user_id', $user->id)->exists();
            $hasEmployes = Employe::where('user_id', $user->id)->exists();
            $AgenceUsers = AgenceUser::where('user_id', $user->id)->exists();
            $HasClient = Client::where('user_id', $user->id)->exists();


            if ($HasClient) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un client.',
                    'status' => 'error'
                ]);
            }

            if ($hasCusromers) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un client.',
                    'status' => 'error'
                ]);
            }

            if ($hasContrats) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à une contrat.',
                    'status' => 'error'
                ]);
            }

            if ($hasFacture) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à une facture.',
                    'status' => 'error'
                ]);
            }
            
            if ($hasEmployes) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un employé.',
                    'status' => 'error'
                ]);
            }

            
            if ($AgenceUsers) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un agents.',
                    'status' => 'error'
                ]);
            }


            if($user->delete()){
                return response()->json(['message' => 'Utilisateur supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }