<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Customer;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Employe;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage; 

class EmployesController extends Controller
{
    public function index()
        {
            Auth::user()->access("LISTE EMPLOYE");
            $employes = Employe::paginate(100);
            return view('employe.index',compact('employes'));
        }
 
        public function add($id)
        {
            $employe = Employe::find($id);
            
            $employe = new Employe;
            $title = 'Ajouter un employé';

            Auth::user()->access('AJOUT EMPLOYE');
            
            return view('employe.save',compact('employe','title'));
        }
}
