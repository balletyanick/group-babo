<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\AgenceUserController;
use App\Http\Controllers\EmployesController;
use App\Http\Controllers\ContratsEmployesController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\Gesion_payController;
use App\Http\Controllers\DisponibiliteController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
 
Route::get('/connexion', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/deconnexion', [AuthController::class, 'logout'])->name('logout');

    #dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard_yop', [DashboardController::class, 'yop'])->name('dashboard.yop');
    Route::get('/dashboard_cocody', [DashboardController::class, 'cocody'])->name('dashboard.cocody');


    #compte
    Route::get('/mon-compte', [CompteController::class, 'index'])->name('compte.index');

    
    #utilisateur
    Route::get('/liste-des-utilisateurs', [UserController::class, 'index'])->name('user.index');
    Route::get('/utilisateur/{id}', [UserController::class, 'add'])->name('user.add');
    Route::get('/utilisateurs/{id}', [UserController::class, 'add_user'])->name('user.add_user');
    Route::post('/save-user', [UserController::class, 'save'])->name('user.save');
    Route::get('/delete-user', [UserController::class, 'delete'])->name('user.delete'); 


    #agence
    Route::get('/liste-agence', [AgenceController::class, 'index'])->name('agence.index');
    Route::get('/agence/{id}', [AgenceController::class, 'add'])->name('agence.add');
    Route::post('/save-agence', [AgenceController::class, 'save'])->name('agence.save');
    Route::get('/delete-agence', [AgenceController::class, 'delete'])->name('agence.delete');


    #agent (utilisateur en agence) 
    Route::get('/liste-agent', [AgenceUserController::class, 'index'])->name('agent.index');
    Route::get('/agent/{id}', [AgenceUserController::class, 'add'])->name('agent.add');
    Route::post('/save-agent', [AgenceUserController::class, 'save'])->name('agent.save');
    Route::get('/delete-agent', [AgenceUserController::class, 'delete'])->name('agent.delete');
 

    #client
    Route::get('/liste-clients', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/client/{id}', [CustomerController::class, 'add'])->name('customer.add');
    Route::post('/save-customer', [CustomerController::class, 'save'])->name('customer.save');
    Route::get('/delete-customer', [CustomerController::class, 'delete'])->name('customer.delete');
    Route::get('/edit-client/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('/save-edit-client', [CustomerController::class, 'save_edit'])->name('customer.save_edit');

    
    


    #employe
    Route::get('/liste-employes', [EmployesController::class, 'index'])->name('employe.index');
    Route::get('/employe/{id}', [EmployesController::class, 'add'])->name('employe.add');
    Route::post('/save-employe', [EmployesController::class, 'save'])->name('employe.save');
    Route::get('/delete-employe', [EmployesController::class, 'delete'])->name('employe.delete');
    Route::get('/edit-employe/{id}', [EmployesController::class, 'edit'])->name('employe.edit');
    Route::post('/save-edit-employe', [EmployesController::class, 'save_edit'])->name('employe.save_edit');
    Route::get('/liste-employe-agence/{id}', [EmployesController::class, 'list'])->name('employe.list');


    #contrat_employe
    Route::get('/liste-contrat-employe', [ContratsEmployesController::class, 'index'])->name('contrat-employe.index');
    Route::get('/contrat-employe/{id}', [ContratsEmployesController::class, 'add'])->name('contrat-employe.add');
    Route::post('/save-contrat-employe', [ContratsEmployesController::class, 'save'])->name('contrat-employe.save');
    Route::get('/delete-contrat-employe', [ContratsEmployesController::class, 'delete'])->name('contrat-employe.delete');
    Route::get('/resilier-contrat-employe', [ContratsEmployesController::class, 'resilier'])->name('contrat-employe.resilier');
    Route::get('/edit-contrat-employe/{id}', [ContratsEmployesController::class, 'edit'])->name('contrat-employe.edit');
    Route::post('/save-edit-contrat-employe', [ContratsEmployesController::class, 'save_edit'])->name('contrat-employe.save_edit');
    
 
    #produit
    Route::get('/liste-produits', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{id}', [ProductController::class, 'add'])->name('product.add');
    Route::post('/save-product', [ProductController::class, 'save'])->name('product.save');
    Route::get('/delete-product', [ProductController::class, 'delete'])->name('product.delete');

    #contrat
    Route::get('/liste-contrat', [ContratController::class, 'index'])->name('contrat.index');
    Route::get('/contrat/{id}', [ContratController::class, 'add'])->name('contrat.add');
    Route::post('/save-contrat', [ContratController::class, 'save'])->name('contrat.save');
    Route::get('/delete-contrat', [ContratController::class, 'delete'])->name('contrat.delete');
    Route::get('/edit-contrat/{id}', [ContratController::class, 'edit'])->name('contrat.edit');
    Route::post('/save-edit-contrat', [ContratController::class, 'save_edit'])->name('contrat.save_edit');
    Route::get('/resilier-contrat', [ContratController::class, 'resilier'])->name('contrat.resilier');
    Route::get('/generate-save/{id}', [ContratController::class, 'generate_and_save'])->name('contrat.generate_and_save');
    Route::get('/generate-save-promo/{id}', [ContratController::class, 'generate_promo_save'])->name('contrat.generate_promo_save');
    Route::get('/contrat/telecharger/{id}', [ContratController::class, 'downloadFile'])->name('contrat.download');
    Route::get('/generate-facture/{id}', [ContratController::class, 'generate_facture'])->name('contrat.generate_facture');
    Route::get('/contrat/telecharger-promo/{id}', [ContratController::class, 'downloadFilePromo'])->name('contrat.download_promo');
  
    Route::get('/ajouter-disponibilité/{id}', [ContratController::class, 'add_disponibilite'])->name('contrat.add_disponibilite');


    #facture
    Route::get('/liste-facture', [FactureController::class, 'index'])->name('facture.index');
    Route::get('/delete-facture', [FactureController::class, 'delete'])->name('facture.delete');
    Route::get('/edit-facture/{id}', [FactureController::class, 'edit'])->name('facture.edit');
    Route::post('/save-edit-facture', [FactureController::class, 'save_edit'])->name('facture.save_edit');
    Route::get('/facture/telecharger/{id}', [FactureController::class, 'downloadFile'])->name('facture.download');


    #Disponibilite
    Route::get('/disponibilite/{id}', [DisponibiliteController::class, 'index'])->name('dispo.index');
    Route::get('/supprimer-disponibilite/{id}', [DisponibiliteController::class, 'delete'])->name('dispo.delete');


    #paiement client
    Route::get('/liste-paiement-partenaire', [PaiementController::class, 'index'])->name('paiement.index');
    Route::get('/demander-paiement/{id}', [PaiementController::class, 'add'])->name('paiement.add');
    Route::post('/save-paiement', [PaiementController::class, 'save'])->name('paiement.save');
    Route::get('/historique-paiement', [PaiementController::class, 'historique'])->name('paiement.historique');


    #paiement gestion
    Route::get('/liste-paiement-en-cours', [Gesion_payController::class, 'en_cours'])->name('gestion_paiement.en_cours');
    Route::get('/liste-paiements-traitées', [Gesion_payController::class, 'index'])->name('gestion_paiement.index');
    Route::get('/paiement-refuser/{id}', [Gesion_payController::class, 'refuser_paiement'])->name('gestion_paiement.refuser');
    Route::get('/paiement-valider/{id}', [Gesion_payController::class, 'valider_paiement'])->name('gestion_paiement.valider');

    #sms
    Route::get('/envoyer-sms-personnel/{id}', [SmsController::class, 'send'])->name('sms.send');
    Route::post('/save-send', [SmsController::class, 'save_send'])->name('sms.save_send');
    Route::get('/envoyer-sms-client', [SmsController::class, 'send_client'])->name('sms.client');
    Route::post('/save-send-client', [SmsController::class, 'save_send_client'])->name('sms.save_send_client');
    Route::get('/envoyer-sms-employe', [SmsController::class, 'send_employe'])->name('sms.employe');
    Route::post('/save-send-employe', [SmsController::class, 'save_send_employe'])->name('sms.save_send_employe');

  
    #role
    Route::get('/liste-des-roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/{id}', [RoleController::class, 'add'])->name('role.add');
    Route::get('/role/permissions/{id}', [RoleController::class, 'permissions'])->name('role.permissions');
    Route::post('/save-role', [RoleController::class, 'save'])->name('role.save');
    Route::get('/delete-role', [RoleController::class, 'delete'])->name('role.delete');


    #permission
    Route::get('/liste-des-permissions', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/{id}', [PermissionController::class, 'add'])->name('permission.add');
    Route::post('/save-permission', [PermissionController::class, 'save'])->name('permission.save');
    Route::post('/set-permission', [PermissionController::class, 'set_permission'])->name('set-permission.save');
    Route::get('/delete-permission', [PermissionController::class, 'delete'])->name('permission.delete');
    
});