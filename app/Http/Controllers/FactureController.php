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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FactureController extends Controller 
{
    public function index()
    {
        Auth::user()->access("LISTE FACTURE");
        $factures = Facture::with('customer','product','user','agence','contrat')
        ->paginate(100);

        return view('facture.index',compact('factures'));
    }

    public function delete(Request $request)
    { 
        Auth::user()->access('SUPPRESSION FACTURE');

        $facture = Facture::find($request->id);

        if($facture->delete()){
            return response()->json(['message' => 'Information de la facture supprimé avec succès',"status"=>"success"]);
        }else{
            return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
        }
    }

    public function downloadFile($id) 
    {

        Auth::user()->access('TELECHARGER FACTURE');

        $facture = Facture::find($id);
        $product = Product::all();
        $customer = Customer::all();
        $contrat = Contrat::all();
        $agence = Agence::all();

        if (!$facture || !$facture->chemin_file) {
            return redirect()->route('facture.index')->with('error', 'Fichier non trouvé.');
        }

        // Chemin du fichier
        $fileName = 'FA'.$facture->numero_contrat.'_'.rand(1000,9999).'.docx';
        $filePath = storage_path('app/public/' . $facture->chemin_file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->route('facture.index')->with('error', 'Fichier non trouvé.');
        }
    }

}
