<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Role;
    use App\Models\Permission;
    use Illuminate\Support\Facades\Auth;

    class RoleController extends Controller
    {
        public function index()
        {
            Auth::user()->access('LISTE ROLE');

            $roles = Role::paginate(100);
            return view('role.index',compact('roles'));
        }

        public function permissions($id)
        {

            Auth::user()->access('AJOUT ROLE');

            $permissions = Permission::orderBy('created_at', 'desc')->get();
            $role = Role::findOrfail($id);
            $title = "Liste des permisions du rôle $role->name";

            return view('role.permission-role',compact('permissions','title','role'));
        }

        public function add($id)
        {

            $role = Role::find($id);

            if(!is_null($role)){
                $title = "Modifier $role->name";
                Auth::user()->access('EDITION ROLE');
            }else{
                $role = new Role;
                $title = 'Ajouter un role';
                Auth::user()->access('AJOUT ROLE');
            }

            return view('role.save',compact('role','title'));
        }

        public function save(Request $request)
        {

            if($request->id){
                Auth::user()->access('EDITION ROLE');
            }else{
                Auth::user()->access('AJOUT ROLE');
            }
            
            $validator = $request->validate([
                'name' => 'required|string',
            ]);
            
            $data = $request->except(['data']);
            $data['user_id'] = Auth::user()->id;
            
            $role = Role::where('name', $data['name'])->where('id', '!=', $request->id)->first();
            
            if ($role) {
                return response()->json(['message' => 'Ce rôle a déjà été  enregisté.',"status"=>"error"]);
            } else {
                $role = Role::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
            
            return response()->json(['message' => 'Rôle enregistré avec succès',"status"=>"success"]);

        }

        public function delete(Request $request){

            Auth::user()->access('SUPPRESSION ROLE');

            $role = Role::find($request->id);

            if($role->delete()){
                return response()->json(['message' => 'Rôle supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }