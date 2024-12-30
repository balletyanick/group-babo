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
use App\Models\Employe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SmsController extends Controller
{
    public function send($id)
    {
        $title = 'Envoyer un message personel';

        Auth::user()->access('ENVOYER MESSAGE PERSONNEL');
        $contrat = Contrat::find($id);
        $customer = $contrat->customer;
        $phone = $customer->phone;

        return view('sms.send',compact('title','phone'));
    } 

    public function save_send(Request $request)
    {
        Auth::user()->access('ENVOYER MESSAGE PERSONNEL');
        // Validation du message et du numéro de téléphone
        $validator = $request->validate([
            'message' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Récupérer les données validées
        $smsMessage = $validator['message'];
        $phone = $validator['phone'];

        // Construire la structure pour "Contact" (un seul numéro)
        $contacts = [
            ['Dest' => $phone], // Ajouter un seul numéro dans le format attendu
        ];

        // Envoyer le SMS via l'API `addFullSms`
        $response = Http::post('https://sms.acim-ci.net:8443/api/addFullSms', [
            'Username' => 'phenixApi', // Détails extraits de votre collection Postman
            'Token' => '$2a$10$ecyCD2d.Igj2n6ZpPcka5uMQmRW53dGOFnSm/OzSiubtYWm9q86kK',
            'Sender' => 'PHENIX TRAN',
            'Flash' => '0',            // Pas de SMS flash
            'Sms' => $smsMessage,      // Message validé
            'Title' => 'Bienvenue',    // Titre du message
            'Contact' => $contacts,    // Structure correcte pour un seul numéro
        ]);

        // Gérer la réponse
        if ($response->successful()) {
            return response()->json(['message' => 'SMS envoyé avec succès !', 'status' => 'success']);
        } else {
            // Retourner les détails de l'erreur pour débogage
            return response()->json([
                'message' => 'Erreur lors de l\'envoi des messages.',
                'status' => 'error',
                'response' => $response->json(),
            ], $response->status());
        }
    }

    public function send_client()
    {
        $title = 'Envoyer un message aux clients';

        Auth::user()->access('ENVOYER SMS AUX CLIENTS');
      

        return view('sms.client',compact('title'));
    } 

    public function save_send_client(Request $request)
    {

        Auth::user()->access('ENVOYER SMS AUX CLIENTS');

        $customers = Customer::all(); // Récupérer tous les clients

        // Validation du message
        $validator = $request->validate([
            'message' => 'required|string',
        ]); 

        // Récupérer le message validé
        $smsMessage = $validator['message'];

        // Construire la liste des contacts
        $contacts = [];
        foreach ($customers as $customer) {
            if (!empty($customer->phone)) { // Vérifiez que le numéro de téléphone existe
                $contacts[] = ['Dest' => $customer->phone];
            }
        }

        // Vérifier qu'il y a des contacts avant d'envoyer le SMS
        if (!empty($contacts)) {
            // Envoyer le SMS via l'API SMS
            $response = Http::post('https://sms.acim-ci.net:8443/api/addFullSms', [
                'Username' => 'phenixApi',
                'Token' => '$2a$10$ecyCD2d.Igj2n6ZpPcka5uMQmRW53dGOFnSm/OzSiubtYWm9q86kK',
                'Sender' => 'PHENIX TRAN',
                'Flash' => '0',
                'Sms' => $smsMessage,  // Utilisation du message validé
                'Title' => 'Bienvenue',
                'Contact' => $contacts,
            ]);

            // Gérer la réponse
            if ($response->successful()) {
                return response()->json(['message' => 'SMS envoyés avec succès !',"status"=>"success"]);
            } else {
                return response()->json(['message' => 'Erreur lors de l\'envoi des messages',"status"=>"error"]);
            }
        } else {
            return response()->json(['message' => 'Aucun numéro de téléphone disponible.',"status"=>"error"]);
        }
    }

    public function send_employe()
    {
        $title = 'Envoyer un message aux employés';

        Auth::user()->access('ENVOYER SMS AUX EMPLOYES');
      

        return view('sms.employe',compact('title'));
    } 

    public function save_send_employe(Request $request)
    {
        Auth::user()->access('ENVOYER SMS AUX EMPLOYES');

        $employes = Employe::all(); // Récupérer tous les employes

        // Validation du message
        $validator = $request->validate([
            'message' => 'required|string',
        ]); 

        // Récupérer le message validé
        $smsMessage = $validator['message'];

        // Construire la liste des contacts
        $contacts = [];
        foreach ($employes as $employe) {
            if (!empty($employe->phone)) { // Vérifiez que le numéro de téléphone existe
                $contacts[] = ['Dest' => $employe->phone];
            }
        }

        // Vérifier qu'il y a des contacts avant d'envoyer le SMS
        if (!empty($contacts)) {
            // Envoyer le SMS via l'API SMS
            $response = Http::post('https://sms.acim-ci.net:8443/api/addFullSms', [
                'Username' => 'phenixApi',
                'Token' => '$2a$10$ecyCD2d.Igj2n6ZpPcka5uMQmRW53dGOFnSm/OzSiubtYWm9q86kK',
                'Sender' => 'PHENIX TRAN',
                'Flash' => '0',
                'Sms' => $smsMessage,  // Utilisation du message validé
                'Title' => 'Bienvenue',
                'Contact' => $contacts,
            ]);

            // Gérer la réponse
            if ($response->successful()) {
                return response()->json(['message' => 'SMS envoyés avec succès !',"status"=>"success"]);
            } else {
                return response()->json(['message' => 'Erreur lors de l\'envoi des messages',"status"=>"error"]);
            }
        } else {
            return response()->json(['message' => 'Aucun numéro de téléphone disponible.',"status"=>"error"]);
        }
    }
}
