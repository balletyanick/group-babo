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
use App\Models\Pret;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{
    public function index()
    {
        Auth::user()->access("MON COMPTE");
        $user = Auth::user();

       // Récupérer les contrats de l'utilisateur avec le produit associé
       $contrats = Contrat::where('user_id', $user->id)
       ->with('product')
       ->get();

        $solde_total = 0;

        foreach ($contrats as $contrat) {
            // S'assurer que le contrat possède un produit associé
            if (!$contrat->product) {
                continue;
            }

            $payMensuel = $contrat->product->pay_mensuel;
            $duration   = $contrat->product->duration_contrat;
            $quantite   = $contrat->quantite;
            $premierPay = $contrat->premier_pay;

            // Calcul selon le type de contrat
            if ($contrat->type_contrat === 'Promotion') {
                $calcul = $payMensuel * ($duration - 1) * $quantite;
            } else {
                $calcul = $payMensuel * $duration * $quantite;
            }

            // Ajouter le paiement initial
            $calcul += $premierPay * $quantite;
            $solde_total += $calcul;
        }

        // Somme Paiement valide
        $paiement_valide = Paiement::whereHas('contrat', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 1)
        ->sum('amount');

    
        // Somme Montant Restant
        $montantRestant = $solde_total - $paiement_valide;
        
        $nombre_contrats = Contrat::where('user_id', $user->id)->count();

        $total_vehicules = Contrat::where('user_id', $user->id)->sum('quantite');

        $Total_pret = Pret::whereHas('contrat', function ($query) {
            $query->where('user_id', Auth::id()); // Filtrer les contrats liés à l'utilisateur connecté
        })
        ->sum('amount');

        return view('compte.index', compact('solde_total','nombre_contrats','total_vehicules','paiement_valide','montantRestant','Total_pret')); 

    } 
}
