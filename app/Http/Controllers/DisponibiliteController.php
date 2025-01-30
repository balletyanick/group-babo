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
        Auth::user()->access('LISTE VERSEMENT');
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


    public function delete($id)
    {
        // Vérifier si l'utilisateur a les permissions nécessaires
        Auth::user()->access("SUPPRESSION DISPONIBILITE");

        $contrat = Contrat::find($id);

        Disponibilite::where('contrat_id', $contrat->id)->delete();

        // Réponse JSON de succès
        return response()->json([
            'status' => 'success',
            'message' => 'Toutes les disponibilités associées ont été supprimées avec succès.',
        ]);
    }

}
