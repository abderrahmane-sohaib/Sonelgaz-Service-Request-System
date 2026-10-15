<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IngController;
use App\Http\Controllers\client_controller;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('auth.login');
})->name('lg');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/client/nouvelle_demande', [client_controller::class, 'nouvelle_D'])->name('nouvelle_D');
Route::get('/dashboard/client/mas_demande', [client_controller::class, 'mas_D'])->name('mas_D');
Route::get('/dashboard/client/annuler_demande', [client_controller::class, 'annuler_D'])->name('annuler_D');
Route::get('/dashboard/client/consulter_demande', [client_controller::class, 'consulter_D'])->name('consulter_D');
Route::post('/dashboard/client/nouvelle_demande',[client_controller::class, 'StoreInfo'])->name('demande_store');
Route::get('/pdfDemande/{is}',[client_controller::class, 'view']);
Route::post('/dashboard/client/mas_demande/{demandeId}', [client_controller::class, 'StoreInfoUpdate'])->name('demande_mod');
Route::post('/dashboard/client/mannuler_demande/{id}', [client_controller::class, 'annulerD'])->name('demande_ann');

Route::get('/Forget_password', [client_controller::class, 'pass'])->name('password');
Route::post('/verify_mot', [client_controller::class, 'verifyMot'])->name('verify');
Route::post('/reset_password', [client_controller::class, 'resetPassword'])->name('reset');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'admin_Dash'])->name('admin.dash');
    Route::get('/dashboard/admin/ing', [AdminController::class, 'admin_ing'])->name('admin_ing');
    Route::get('/dashboard/admin/prestation', [AdminController::class, 'admin_prestation'])->name('admin_prestation');
   
    Route::post('/dashboard/admin',[AdminController::class, 'StoreInfo'])->name('admin.store');
    Route::get('/dashboard/admin/{id}', [AdminController::class,'data']);
    Route::post('/dashboard/admin/update/{ingenieurId}', [AdminController::class, 'update'])->name('admin.edit');
    Route::post('/dashboard/admin/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('ingenieur.toggleStatus');
    Route::post('/dashboard/admin/prestation', [AdminController::class, 'StoreP'])->name('admin.prestation');
    Route::post('/dashboard/admin/prestation/{prsID}', [AdminController::class, 'updateP'])->name('admin.update');
    Route::post('/dashboard/admin/prestation/delete/{ID}', [AdminController::class, 'deleteP'])->name('admin.delete');
   
    


});

Route::middleware(['auth','role:ingenieur'])->group(function () {


    Route::get('/dashboard/ingenieur/demande_enligne', [IngController::class, 'ingenieur_Dash_demandeE'])->name('demande_enligne');
    Route::get('/dashboard/ingenieur/demande_sonalgaz', [IngController::class, 'ingenieur_Dash_demandeS'])->name('demande_sonalgaz');
    Route::get('/dashboard/ingenieur/contrat_sonalgaz', [IngController::class, 'ingenieur_Dash_demandeC'])->name('contrat_sonalgaz');
    Route::get('/dashboard/ingenieur/oep_sonalgaz', [IngController::class, 'ingenieur_Dash_demandeO'])->name('oep_sonalgaz');
    Route::get('/dashboard/ingenieur/rapport_sonalgaz', [IngController::class, 'ingenieur_Dash_demandeR'])->name('rapport_sonalgaz');
    Route::get('/dashboard/ingenieur', [IngController::class, 'ingenieur_Dash'])->name('ingenieur.dash');
    Route::post('/dashboard/ingenieur/demande_sonalgaz',[IngController::class, 'StoreInfoDemande'])->name('demande.store');
    Route::post('/dashboard/ingenieur/demande_sonalgaz/updateP/{idP}', [IngController::class, 'storePrestation'])->name('prestation.store');
    Route::post('/dashboard/ingenieur/demande_sonalgaz/deleteprestation', [IngController::class, 'deletePrestation'])->name('prestation.delete');
    Route::post('/valider-devis/{demandeId}', [IngController::class, 'validerDevis'])->name('valider.devis');
    Route::post('/dashboard/ingenieur/demande_sonalgaz/deleteD/{idD}', [IngController::class, 'deleteData'])->name('delete.demande');
    Route::post('/dashboard/ingenieur/demande_enligne/delete/{id}', [IngController::class, 'deleteDataE'])->name('delete.demandeE');
    Route::get('/test-pdf/{pdfId}', [IngController::class, 'testPdf'])->name('test');
    Route::post('/devis-payé/{demandeId}', [IngController::class, 'devisPaye'])->name('devis.paye');
    Route::get('/dashboard/ingenieur/demande_sonalgaz/getPrice', [IngController::class, 'getPrice']);
    Route::get('/dashboard/ingenieur/demande_sonalgaz/getPrestations', [IngController::class, 'getPrestations'])->name('getPrestations');
    Route::get('/dashboard/ingenieur/pdf/{id}', [IngController::class, 'pdf_dash'])->name('anything');
    Route::post('/dashboard/ingenieur/demande_sonalgaz/update/{demandeId}', [IngController::class, 'update'])->name('ingenieur.edit');
    Route::post('/dashboard/ingenieur/contrat_sonalgaz/changertypeC/{contratId}', [IngController::class, 'changerTypeContrat'])->name('typeC.change');
    Route::post('/dashboard/ingenieur/contrat_sonalgaz/contratedit/{contratID}', [IngController::class, 'editContrat'])->name('edit.contrat');
    Route::post('/dashboard/ingenieur/contrat_sonalgaz/changertypeE/{oepId}', [IngController::class, 'changerTypeOep'])->name('typeE.change');
    Route::post('/dashboard/ingenieur/contrat_sonalgaz/changertypeO/{OId}', [IngController::class, 'changerType'])->name('typeO.change');

    Route::post('/dashboard/ingenieur/demande_enligne/changertype/{typeId}', [IngController::class, 'changerTypeDemande'])->name('type.change');

    Route::get('/test-contrat/{contratId}', [IngController::class, 'testcontrat'])->name('testCN');
    Route::get('/test-oep/{opId}', [IngController::class, 'testoep'])->name('testOP');
    Route::get('/dashboard/ingenieur/rapport_sonalgaz/statistiques', [IngController::class, 'index'])->name('statistiques.index');



    // Route::get('/dashboard/ingenieur/{id}/pdf', [DevisController::class, 'generatePdf'])->name('devis.pdf');

});
