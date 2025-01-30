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
use App\Models\Paiement;
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
        ->selectRaw('
            SUM(
                CASE 
                    WHEN contrats.type_contrat = "Promotion" 
                    THEN products.pay_mensuel * (products.duration_contrat - 1) * contrats.quantite
                    ELSE products.pay_mensuel * products.duration_contrat * contrats.quantite
                END
            ) +
            SUM(contrats.premier_pay * contrats.quantite) as total_combined
        ')
        ->value('total_combined');


        // Somme Paiement valide
        $paiement_valide = Paiement::whereHas('contrat', function ($query) use ($user) {
            $query->whereHas('client', function ($subQuery) use ($user) {
                $subQuery->where('user_id', $user->id);
            });
        })
        ->where('status', 1) 
        ->sum('amount'); 

    
        // Somme Montant Restant
        $montantRestant = $solde_total - $paiement_valide;
        
    
        $nombre_contrats = Contrat::whereHas('client', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $total_vehicules = Contrat::whereHas('client', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('quantite');
        
        return view('compte.index', compact('solde_total','nombre_contrats','total_vehicules','paiement_valide','montantRestant')); 

    } 
}
