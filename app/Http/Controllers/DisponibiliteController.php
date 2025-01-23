<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use App\Models\Agence;
use App\Models\Facture;
use App\Models\Client;
use App\Models\Disponibilite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DisponibiliteController extends Controller
{
    public function index($id)
    { 
        Auth::user()->access('EDITION CONTRAT');
        $title = 'Modifier le contrat';

        // Récupérer le contrat spécifique avec pagination
        $contrat = Contrat::findOrFail($id);

         // Récupérer uniquement les disponibilités liées à ce contrat
        $disponibilites = Disponibilite::where('contrat_id', $id)->paginate(100);

        // Récupérer les autres données nécessaires
        $client = Client::all();
        $product = Product::all();
        $agence = Agence::all();

        return view('dispo.index', compact('disponibilites', 'title', 'client', 'product','agence','contrat'));
    }
}
