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
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{
    public function index()
    {
        Auth::user()->access("MON COMPTE");
        $user = Auth::user();

        $solde_total = Contrat::whereHas('client', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->join('products', 'contrats.product_id', '=', 'products.id')
        ->selectRaw('SUM(products.amout_global * contrats.quantite) as total')
        ->value('total');

        $nombre_contrats = Contrat::whereHas('client', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
    
        $nombre_contrats = Contrat::whereHas('client', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $total_vehicules = Contrat::whereHas('client', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('quantite');
        
        return view('compte.index', compact('solde_total','nombre_contrats','total_vehicules')); 

    } 
}
