<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Permission;
    use App\Models\Role;
    use Illuminate\Support\Facades\Auth;

    class PermissionController extends Controller
    {
        public function index()
        {
            Auth::user()->access('LISTE PERMISSION');

            $permissions = Permission::paginate(100);
            return view('permission.index',compact('permissions'));
        }
        
        public function add($id)
        {
            $permission = Permission::find($id);

            if(!is_null($permission)){
                $title = "Modifier $permission->name";
                Auth::user()->access('EDITION PERMISSION');
            }else{
                $permission = new Permission;
                $title = 'Ajouter une permission';
                Auth::user()->access('AJOUT PERMISSION');
            }

            return view('permission.save',compact('permission','title'));
        }

        public function save(Request $request)
        {
            if($request->id){
                Auth::user()->access('EDITION PERMISSION');
            }else{
                Auth::user()->access('AJOUT PERMISSION');
            }
            
            $validator = $request->validate([
                'name' => 'required|string',
            ]);
            
            $data = $request->except(['data']);
            $data['user_id'] = Auth::user()->id;
            
            $permission = Permission::where('name', $data['name'])->where('id', '!=', $request->id)->first();
            
            if ($permission) {
                return response()->json(['message' => 'Ce permission a déjà été  enregisté.',"status"=>"error"]);
            } else {
                $permission = Permission::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
            
            return response()->json(['message' => 'Permission enregistré avec succès',"status"=>"success"]);

        }

        public function set_permission(Request $request)
        {
            Auth::user()->access('AJOUT PERMISSION');

            $role = Role::findOrFail($request->role_id);
            $role->permissions()->sync($request->input('permission_id', []));

            return response()->json(['message' => 'Permissions mises à jour avec succès pour le rôle ' . $role->name,"status"=>"success"]);
        }

        public function delete(Request $request){

            Auth::user()->access('SUPPRESSION PERMISSION');

            $permission = Permission::find($request->id);

            if($permission->delete()){
                return response()->json(['message' => 'Permission supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }