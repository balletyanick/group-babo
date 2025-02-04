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
use App\Models\Disponibilite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class PaiementController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE CONTRAT PARTENAIRE");
        $user = Auth::user();

        $contrats = Contrat::where('user_id', $user->id)
        ->with('product') // Charge les produits liés
        ->paginate(100);

        $contrats->each(function ($contrat) {
            // Récupérer la somme des paiements dans disponibilités
            $totalDisponibilite = Disponibilite::where('contrat_id', $contrat->id)
            ->whereDate('date_payment', '<=', now()) // Filtrer par date
            ->sum('amount');


            // Récupérer la somme des paiements validés
            $totalPaiementsValides = Paiement::where('contrat_id', $contrat->id)
            ->where('status', 1) 
            ->sum('amount');

        
            // Disponibilité pour retrait*
            $contrat->totalDisponibilite = ($totalDisponibilite + $contrat->premier_pay) - $contrat->totalPaiementsValides;
            // Paiement validé*
            $contrat->totalPaiementsValides = $totalPaiementsValides; 
        });

        return view('paiement.index',compact('contrats'));
    } 

    public function historique()
    {
        Auth::user()->access("LISTE CONTRAT PARTENAIRE");
        $user = Auth::user();

        // Récupérer les paiements liés à l'utilisateur connecté
        $paiements = Paiement::whereHas('contrat.user', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->paginate(100);
    

        return view('paiement.historique', compact('paiements'));
    }

    public function add($id)
    {
        $paiement = Paiement::find($id);

        $contrat = new Contrat;
        $title = 'Demander un paiement';

        Auth::user()->access('DEMANDER PAIEMENT'); 
        $user = Auth::user();
        
        $contrat = Contrat::where('user_id', $user->id)
        ->with('product') // Charge les produits liés
        ->paginate(100);

        
        $contrat->each(function ($contrat) {
            // Récupérer la somme des paiements dans disponibilités
            $totalDisponibilite = Disponibilite::where('contrat_id', $contrat->id)
            ->whereDate('date_payment', '<=', now()) // Filtrer par date
            ->sum('amount');


            // Récupérer la somme des paiements validés
            $totalPaiementsValides = Paiement::where('contrat_id', $contrat->id)
            ->where('status', 1) 
            ->sum('amount');

        
            // Disponibilité pour retrait*
            $contrat->totalDisponibilite = ($totalDisponibilite + $contrat->premier_pay) - $contrat->totalPaiementsValides;
            // Paiement validé*
            $contrat->totalPaiementsValides = $totalPaiementsValides; 
        });
        
        return view('paiement.save',compact('contrat','title'));
    }

    public function save(Request $request)
    {
        
        $validator = $request->validate([
            'user_id' => 'required|string|exists:users,id',
            'contrat_id' => 'required|string|exists:contrats,id',
            'amount' => 'required|integer',
            'date_demande' => 'required|date',
            'mode_paiement' => 'required|string',
        ]);

        $user = $request->input('user_id');
        $contratId = $request->input('contrat_id');
        $montantDemande = $request->input('amount');
        $premierPay = Contrat::where('id', $contratId)->value('premier_pay');
        $status = Contrat::where('id', $contratId)->value('status');

        // Vérifier si le contrat est résilié (status == 1)
        if ($status == 1) {
            return response()->json([
                'message' => 'Votre contrat a été résilié.',
                'status' => 'error'
            ], 400);
        }

        // Récupérer la somme des paiements existants pour le contrat donné
        $montantDispo = DB::table('disponibilites') 
        ->where('contrat_id', $contratId)
        ->whereDate('date_payment', '<=', now()) 
        ->sum('amount'); 

        // Récupérer la somme des paiements en cours
        $pay_cours = Paiement::where('contrat_id', $contratId)
        ->where('status', 0)
        ->sum('amount');


        // Récupérer la somme des paiements validés
        $pay_valider = Paiement::where('contrat_id', $contratId)
        ->where('status', 1)
        ->sum('amount');

        $dispo_retrait = ($montantDispo +  $premierPay) - ($pay_valider + $pay_cours);

        // Vérifier si l'amount est inférieur ou égal à la somme de dispo_retrait
        if ($montantDemande <= $dispo_retrait) {
            $data = $request->only(['amount', 'date_demande', 'mode_paiement']);
            $data['user_id'] = $request->input('user_id');
            $data['contrat_id'] = $request->input('contrat_id');
            $data['status'] = 0;

            Paiement::create($data);

            return response()->json(['message' => 'Demande de paiement enregistré avec succès', 'status' => 'success']);
        } else {
            // Retourner un message d'erreur si la condition n'est pas respectée
            return response()->json(['message' => 'Erreur : le montant demandé dépasse la disponibilité des retraits', 'status' => 'error'], 400);
        }
    }

}
