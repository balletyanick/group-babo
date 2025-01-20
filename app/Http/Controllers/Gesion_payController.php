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

class Gesion_payController extends Controller
{
     
    public function index()
    {
        Auth::user()->access("LISTE PAIEMENT TRAITEE");
        $user = Auth::user();

        // Récupérer les paiements avec status = 0
        $paiements = Paiement::where('status', 1)->paginate(100);


        return view('gestion-paiement.index',compact('paiements'));
    }

    public function en_cours()
    {
        Auth::user()->access("LISTE PAIEMENT EN COURS");
        $user = Auth::user();

        // Récupérer les paiements avec status = 1
        $paiements = Paiement::where('status', 0)->paginate(100);


        return view('gestion-paiement.en_cours',compact('paiements'));
    }

    
    public function refuser_paiement($id)
    {
        Auth::user()->access("REFUSER PAIEMENT");

        $paiement = Paiement::find($id); 

        // Modifier le statut en 2 (refusé)
        $paiement->status = 2;
        $paiement->save();

        return redirect()->back()->with('success', 'Paiement refusé avec succès.');
    }


}
