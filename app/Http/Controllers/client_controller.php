<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\contrat;
use App\Models\demande;
use App\Models\demande_prestation;
use App\Models\notification;
use App\Models\oep;
use App\Models\prestation;
use App\Models\reçu;
use App\Http\Controllers\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
class client_controller extends Controller
{

    public function dash(){

        return view('dashboard');
    }



    public function nouvelle_D() {
        $userId = auth()->id();
        // Fetch the required data from the database
        $demandesPrestations = DB::table('demande_prestations')
            ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
            ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
            ->join('users', 'demandes.id_user', '=', 'users.id')
            ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id')
            ->select('demandes.id as demande_id', 'users.id as user_id', 'users.name as client_name', 
                     'users.tel as client_tel', 'users.email as client_email', 'users.typeCL as client_type', 
                     'users.adrCL as client_adr', 'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', 
                     'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque', 
                     'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte', 
                     'contrats.signataire as contrat_signataire',
                     DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
            )
            ->where('users.id', $userId) // Filter by authenticated user ID
            ->groupBy('demandes.id')
            ->get();
        // Cache the prestation prices to avoid multiple database queries
        $prestationPrices = prestation::pluck('prix', 'nom_pres');
    
        $prestationsQuantities = [];
        foreach ($demandesPrestations as $demandePrestation) {
            $prestationsList = explode(', ', $demandePrestation->intitules_prestations);
            $tempPrestationsQuantities = [];
            foreach ($prestationsList as $prestationQuantityPair) {
                $prestationAndQuantity = explode(' (', $prestationQuantityPair);
                $prestationName = trim($prestationAndQuantity[0]);
                $quantity = (int) trim(str_replace(')', '', $prestationAndQuantity[1]));
                $prestationPrice = $prestationPrices[$prestationName] ?? 0.0;
                if (!isset($tempPrestationsQuantities[$prestationName])) {
                    $tempPrestationsQuantities[$prestationName] = [
                        'quantity' => 0,
                        'price' => $prestationPrice,
                        'totalPrice' => 0.0,
                    ];
                }
                $tempPrestationsQuantities[$prestationName]['quantity'] += $quantity;
                $tempPrestationsQuantities[$prestationName]['totalPrice'] = $tempPrestationsQuantities[$prestationName]['quantity'] * $prestationPrice;
            }
            $prestationsQuantities[$demandePrestation->demande_id] = $tempPrestationsQuantities;
        }
    
        // Fetch additional data
        $prestations = prestation::all();
        $users = User::where('role', 'user')->get();
    
        // Check if the current user already has a demande
        // $userHasDemande = DB::table('demandes')
        // ->where('id_user', auth()->id())
        // ->where('etat', '!=', 'demande_exécutée')
        // ->exists();
        
        return view('nouvelleD', [
            'prestations' => $prestations,
            'users' => $users,
            'demandesPrestations' => $demandesPrestations,
            'prestationsQuantities' => $prestationsQuantities,
            // 'userHasDemande' => $userHasDemande,
        ]);
    }
    
    public function mas_D(){
        $userId = auth()->id(); // Get the ID of the authenticated user
    
        $demandesPrestations = DB::table('demande_prestations')
            ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
            ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
            ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
            ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
            ->select('demandes.id as demande_id',
                'users.id as user_id', 'users.name as client_name', 'users.nameD as client_nameD' ,'users.emailD as client_emailD', 'users.tel as client_tel',
                'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
                'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
                'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
                'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
                'contrats.signataire as contrat_signataire',
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
            )
            ->where('users.id', $userId) // Filter by authenticated user ID
            ->groupBy('demandes.id')
            ->get();
    
        // Process prestations and quantities, handling missing data
        $prestationsQuantities = [];
        foreach ($demandesPrestations as $demandePrestation) {
            $prestationsList = explode(', ', $demandePrestation->intitules_prestations);
            $tempPrestationsQuantities = [];
            foreach ($prestationsList as $prestationQuantityPair) {
                $prestationAndQuantity = explode(' (', $prestationQuantityPair);
                $prestationName = trim($prestationAndQuantity[0]);
                $quantity = trim(str_replace(')', '', $prestationAndQuantity[1]));
    
                // Check for missing prestation price (database or processing issue)
                $prestationPrice = prestation::where('nom_pres', $prestationName)->first()->prix;
    
                if (!isset($tempPrestationsQuantities[$prestationName])) {
                    $tempPrestationsQuantities[$prestationName] = [
                        'quantity' => (int) 0,
                        'price' => $prestationPrice === null ? 0.0 : $prestationPrice,  // Default to 0.0 for missing price
                        'totalPrice' => 0.0,
                    ];
                }
    
                $tempPrestationsQuantities[$prestationName]['quantity'] += (int) $quantity;
                $tempPrestationsQuantities[$prestationName]['totalPrice'] = $tempPrestationsQuantities[$prestationName]['quantity'] * ($prestationPrice === null ? 0.0 : $prestationPrice);
            }
            $prestationsQuantities[$demandePrestation->demande_id] = $tempPrestationsQuantities;
        }
    
        // Fetch additional data (consider using eager loading or model relationships)
        $prestations = prestation::all();
        $users = User::where('id', $userId)->get(); // Fetch only the authenticated user
        // dd($prestations, $users,$demandesPrestations);
       
        return view('masD', [
            'prestations' => $prestations,
            'users' => $users,
            'demandesPrestations' => $demandesPrestations,
            'prestationsQuantities' => $prestationsQuantities,
        ]);
    }
    
    public function annuler_D(){
        $userId = auth()->id(); // Get the ID of the authenticated user
    
        $demandesPrestations = DB::table('demande_prestations')
            ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
            ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
            ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
            ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
            ->select('demandes.id as demande_id',
                'users.id as user_id', 'users.name as client_name', 'users.nameD as client_nameD' ,'users.emailD as client_emailD', 'users.tel as client_tel',
                'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
                'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
                'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
                'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
                'contrats.signataire as contrat_signataire',
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
            )
            ->where('users.id', $userId) // Filter by authenticated user ID
            ->groupBy('demandes.id')
            ->get();
    
        // Process prestations and quantities, handling missing data
        $prestationsQuantities = [];
        foreach ($demandesPrestations as $demandePrestation) {
            $prestationsList = explode(', ', $demandePrestation->intitules_prestations);
            $tempPrestationsQuantities = [];
            foreach ($prestationsList as $prestationQuantityPair) {
                $prestationAndQuantity = explode(' (', $prestationQuantityPair);
                $prestationName = trim($prestationAndQuantity[0]);
                $quantity = trim(str_replace(')', '', $prestationAndQuantity[1]));
    
                // Check for missing prestation price (database or processing issue)
                $prestationPrice = prestation::where('nom_pres', $prestationName)->first()->prix;
    
                if (!isset($tempPrestationsQuantities[$prestationName])) {
                    $tempPrestationsQuantities[$prestationName] = [
                        'quantity' => (int) 0,
                        'price' => $prestationPrice === null ? 0.0 : $prestationPrice,  // Default to 0.0 for missing price
                        'totalPrice' => 0.0,
                    ];
                }
    
                $tempPrestationsQuantities[$prestationName]['quantity'] += (int) $quantity;
                $tempPrestationsQuantities[$prestationName]['totalPrice'] = $tempPrestationsQuantities[$prestationName]['quantity'] * ($prestationPrice === null ? 0.0 : $prestationPrice);
            }
            $prestationsQuantities[$demandePrestation->demande_id] = $tempPrestationsQuantities;
        }
    
        // Fetch additional data (consider using eager loading or model relationships)
        $prestations = prestation::all();
        $users = User::where('id', $userId)->get(); // Fetch only the authenticated user
        
        return view('annulerD', [
            'prestations' => $prestations,
            'users' => $users,
            'demandesPrestations' => $demandesPrestations,
            'prestationsQuantities' => $prestationsQuantities,
        ]);
    }
       
        
   
    public function consulter_D(){
        $userId = auth()->id(); // Get the ID of the authenticated user
    
        $demandesPrestations = DB::table('demande_prestations')
            ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
            ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
            ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
            ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
            ->select('demandes.id as demande_id',
                'users.id as user_id', 'users.name as client_name', 'users.nameD as client_nameD' ,'users.emailD as client_emailD', 'users.tel as client_tel',
                'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
                'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
                'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
                'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
                'contrats.signataire as contrat_signataire',
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
            )
            ->where('users.id', $userId) // Filter by authenticated user ID
            ->groupBy('demandes.id')
            ->get();
    
        // Process prestations and quantities, handling missing data
        $prestationsQuantities = [];
        foreach ($demandesPrestations as $demandePrestation) {
            $prestationsList = explode(', ', $demandePrestation->intitules_prestations);
            $tempPrestationsQuantities = [];
            foreach ($prestationsList as $prestationQuantityPair) {
                $prestationAndQuantity = explode(' (', $prestationQuantityPair);
                $prestationName = trim($prestationAndQuantity[0]);
                $quantity = trim(str_replace(')', '', $prestationAndQuantity[1]));
    
                // Check for missing prestation price (database or processing issue)
                $prestationPrice = prestation::where('nom_pres', $prestationName)->first()->prix;
    
                if (!isset($tempPrestationsQuantities[$prestationName])) {
                    $tempPrestationsQuantities[$prestationName] = [
                        'quantity' => (int) 0,
                        'price' => $prestationPrice === null ? 0.0 : $prestationPrice,  // Default to 0.0 for missing price
                        'totalPrice' => 0.0,
                    ];
                }
    
                $tempPrestationsQuantities[$prestationName]['quantity'] += (int) $quantity;
                $tempPrestationsQuantities[$prestationName]['totalPrice'] = $tempPrestationsQuantities[$prestationName]['quantity'] * ($prestationPrice === null ? 0.0 : $prestationPrice);
            }
            $prestationsQuantities[$demandePrestation->demande_id] = $tempPrestationsQuantities;
        }
    
        // Fetch additional data (consider using eager loading or model relationships)
        $prestations = prestation::all();
        $users = User::where('id', $userId)->get(); // Fetch only the authenticated user
   
        return view('consulterD', [
            'prestations' => $prestations,
            'users' => $users,
            'demandesPrestations' => $demandesPrestations,
            'prestationsQuantities' => $prestationsQuantities,
        ]);
       
       
    }




  
    
    
    public function StoreInfo(Request $request)
    {
      
        // Validation des données
        $validatedData = $request->validate([
            'nameD' => 'required|string',
            'adrCL' => 'required|string',
            'adrIN' => 'required|string',
            'tel' => 'required',
            'fax' => 'required',
            'emailD' => 'required|email' ,
            'date' => 'required|date',
            'pdfFile' => 'required|file|mimes:pdf|max:2048' // Validation for PDF file
        ]);
    
        // Calculate total price of prestations
        $totalPrix = 0;
        foreach ($request->input('countries', []) as $prestationId) {
            $prestation = prestation::find($prestationId);
            if ($prestation) {
                $totalPrix += $prestation->prix;
            }
        }
    
        $user=User::find(auth()->id());
        // Create user
        $user->nameD =$validatedData['nameD'];
        $user->typeCL ='externe';
        $user->adrCL =$validatedData['adrCL'];
        $user->tel =$validatedData['tel'];
        $user->fax =$validatedData['fax'];
        $user->emailD =$validatedData['emailD'];

        $user->save();

           
        
    
        // Create demande
        $demande = new demande();
        $demande->date_d = $validatedData['date'];
        $demande->adr_int = $validatedData['adrIN'];
        $demande->id_user = auth()->id();
        $demande->total_prix = $totalPrix;
        $demande->type_demande = 'enligne';
        $demande->etat='demande_a_considérée';
        // Handle the PDF file upload
        
            $file = $request->pdfFile;
        $fileName = time() . '_' . $file->getClientOriginalName();
        $request->pdfFile->move('assets',$fileName);
            // Save the file path to the demande
            $demande->pdf_file = $fileName;
        
    
        $demande->save();
    
        // Associate prestations with the created demande
        foreach ($request->input('countries', []) as $prestationId) {
            $de_prestation = new demande_prestation();
            $de_prestation->id_pres = $prestationId;
            $de_prestation->id_demande = $demande->id;
            $de_prestation->quantite = "1";
            $de_prestation->save();
        }
    
        notify()->success('Demande a été enregistrée.');
        return redirect(route('nouvelle_D'));
    }

    
public function view($id){

$demande=demande::find($id);
return view('viewdemande',compact('demande'));
}


public function StoreInfoUpdate(Request $request, $demandeId)
{
    // Validation des données
    $validatedData = $request->validate([
        'nameD' => 'required|string',
        'adrCL' => 'required|string',
        'adrIN' => 'required|string',
        'tel' => 'required',
        'fax' => 'required',
        'emailD' => 'required|email',
        'date' => 'required|date',
        'pdfFile' => 'required|file|mimes:pdf|max:2048' // Validation for PDF file
    ]);

    // Calculate total price of prestations
    $totalPrix = 0;
    foreach ($request->input('countries', []) as $prestationId) {
        $prestation = prestation::find($prestationId);
        if ($prestation) {
            $totalPrix += $prestation->prix;
        }
    }

    $demande = demande::find($demandeId);
    $user = User::find($demande->id_user);

    // Update user information
    $user->nameD = $validatedData['nameD'];
    $user->typeCL = 'externe';
    $user->adrCL = $validatedData['adrCL'];
    $user->tel = $validatedData['tel'];
    $user->fax = $validatedData['fax'];
    $user->emailD = $validatedData['emailD'];
    $user->save();

    // Update demande information
    $demande->date_d = $request->date;
    $demande->adr_int = $request->adrIN;

    // Handle the PDF file upload
    $file = $request->pdfFile;
    $fileName = time() . '_' . $file->getClientOriginalName();
    $request->pdfFile->move('assets', $fileName);
    $demande->pdf_file = $fileName;
    $demande->save();

    // Delete existing prestations associated with the demande
    demande_prestation::where('id_demande', $demandeId)->delete();

    // Associate new prestations with the demande
    foreach ($request->input('countries', []) as $prestationId) {
        $de_prestation = new demande_prestation();
        $de_prestation->id_pres = $prestationId;
        $de_prestation->id_demande = $demande->id;
        $de_prestation->quantite = "1";
        $de_prestation->save();
    }

    notify()->success('Demande a été modifiée.');
    return redirect(route('mas_D'));
}




public function annulerD($id) {
    // Retrieve the demande prestations and delete them
    $demandePrestations = demande_prestation::where('id_demande', $id)->get();
    foreach ($demandePrestations as $demandePrestation) {
        $demandePrestation->delete();
    }

    // Retrieve the demande and delete it
    $demande = demande::findOrFail($id);
    $demande->delete();

    // **DO NOT ATTEMPT TO DELETE USER**

    // Notify about successful cancellation
    notify()->success('Demande annulée avec succès.');
    return redirect(route('annuler_D'));
}






public function pass(){
   

    return view('password');
   
   
}
public function verifyMot(Request $request)
{
    // Récupérer le mot de passe de sécurité de la requête
    $securityWord = $request->input('security_word');

    // Vérifier si le mot de passe de sécurité existe dans la base de données
    $user = User::where('resetP', $securityWord)->first();

    if ($user) {
        // Le mot de passe de sécurité existe, autoriser la réinitialisation du mot de passe
        return response()->json(['success' => true]);
    } else {
        // Le mot de passe de sécurité n'existe pas, envoyer une réponse d'erreur
        return response()->json(['success' => false, 'error' => 'Security word not found.']);
    }
}



public function resetPassword(Request $request)
{
    $request->validate([
        'newPassword' => 'required|min:8',
        'security_word' => 'required', // Assurez-vous que le champ security_word est requis
    ]);

    // Récupérer le mot de passe de sécurité et le nouveau mot de passe
    $securityWord = $request->input('security_word');
    $newPassword = $request->input('newPassword');

    // Trouver l'utilisateur par le mot de passe de sécurité
    $user = User::where('resetP', $securityWord)->first();

    if ($user) {
        // Hacher le nouveau mot de passe
        $user->password = Hash::make($newPassword);
        // Sauvegarder l'utilisateur mis à jour
        $user->save();

        // Retourner une réponse de succès ou effectuer une redirection, selon vos besoins
        notify()->success('Password modifier.');
        return redirect(route('lg'));
    } 
}






}
