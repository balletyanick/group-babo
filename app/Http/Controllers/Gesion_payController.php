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
use App\Models\Disponibilite;
use App\Models\Client;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class Gesion_payController extends Controller
{
     
    public function index()
    {
        Auth::user()->access("LISTE PAIEMENT TRAITEE");
        $user = Auth::user();

        // Récupérer les paiements avec status égal à 1 ou 2
        $paiements = Paiement::whereIn('status', [1, 2])->paginate(100);

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

        // Vérification si le paiement existe
        if (!$paiement) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paiement introuvable.',
            ]);
        }

        // Modifier le statut en 2 (refusé)
        $paiement->status = 2;
        $paiement->save();

        // Réponse JSON de succès
        return response()->json([
            'status' => 'success',
            'message' => 'Paiement refusé avec succès.',
        ]);
    }

    public function valider_paiement($id)
    {
        Auth::user()->access("VALIDER PAIEMENT");

        $paiement = Paiement::find($id);

        // Récupérer le contrat associé au paiement
        $contrat = Contrat::find($paiement->contrat_id);
       
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


        // Vérifier si le montant du paiement dépasse le montant dispo_retrait
        if ($paiement->amount <=  $contrat->totalDisponibilite ) {

            // Modifier le statut en 1 (validé)
            $paiement->status = 1;
            $paiement->save(); 

            if (!$paiement->user) {
                return response()->json(['status' => 'error', 'message' => 'Utilisateur introuvable pour ce paiement.']);
            }

            // Message à envoyer
            $smsMessage = "Vous avez recu un paiement de la part de Babo Corporate d'un montant de: {$paiement->amount} sur votre {$paiement->user->phone} via {$paiement->mode_paiement}";
    
             // Envoyer le SMS via l'API SMS
            $response = Http::post('https://sms.acim-ci.net:8443/api/addFullSms', [
                  'Username' => 'phenixApi',
                  'Token' => '$2a$10$ecyCD2d.Igj2n6ZpPcka5uMQmRW53dGOFnSm/OzSiubtYWm9q86kK',
                  'Sender' => 'PHENIX TRAN',
                  'Flash' => '0',
                  'Sms' => $smsMessage,
                  'Title' => 'Bienvenue',
                  'Contact' => [
                      ['Dest' => $paiement->user->phone]
                  ],
             ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Paiement validé avec succès..',
            ]);
        }

        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Le montant du paiement dépasse le montant disponible pour retrait.',
            ]);
        }

        
    } 


}
