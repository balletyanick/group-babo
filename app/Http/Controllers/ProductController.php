<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Product;
use App\Models\Facture;
use App\Models\Customer;
use App\Models\Employe;
use App\Models\AgenceUser;
use App\Models\ContratsEmployes;
use App\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE PRODUIT");
        $products = Product::paginate(250);
        return view('product.index',compact('products'));
    } 

    public function add($id)
    {
        $product = Product::find($id);

        if(!is_null($product)){
            $title = "Modifier le produit";

            Auth::user()->access('EDITION PRODUIT');
        }else{
            $product = new Product;
            $title = 'Ajouter un produit';

            Auth::user()->access('AJOUT PRODUIT');
        } 
        
        return view('product.save',compact('product','title'));
    }


    public function save(Request $request)
        {
            if($request->id){
                Auth::user()->access('EDITION PRODUIT');
            } else {
                Auth::user()->access('AJOUT PRODUIT');
            }

            $validator = $request->validate([
                'libelle' => 'required|string',
                'description' => 'nullable|string',
                'duration_contrat' => 'required|integer',
                'frais_gestion' => 'required|integer',
                'amout_global' => 'required|integer',
                'pay_mensuel' => 'required|integer',
                'pay_day' => 'required|integer',
                'note' => 'nullable|string',
                'type' => 'required|string',
                'moto_restitue' => 'required|string',
            ]); 

            $product = Product::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            ); 

            return response()->json(['message' => 'Produit enregistré avec succès', 'status' => 'success']);
        }

    public function delete(Request $request)
        {
            Auth::user()->access('SUPPRESSION PRODUIT');

            $product = Product::find($request->id);
            $hasContrats = Contrat::where('product_id', $product->id)->exists();
            $hasFactures = Facture::where('product_id', $product->id)->exists();


            if ($hasContrats) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à un ou plusieurs contrats.',
                    'status' => 'error'
                ]);
            }

            if ($hasFactures) {
                return response()->json([
                    'message' => 'Impossible de supprimer cet élément : il est lié à une ou plusieurs factures.',
                    'status' => 'error'
                ]);
            }

            if($product->delete()){
                return response()->json(['message' => 'Produit supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
}
