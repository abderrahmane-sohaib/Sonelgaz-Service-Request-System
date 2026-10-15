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
class IngController extends Controller
{
  
  public function ingenieur_Dash()
  {
      
      return view('ingenieur.ing_dash');
  }
  
  public function ingenieur_Dash_demandeE()
  {
      // ... (rest of the code before the query)
  
      $demandesPrestations = DB::table('demande_prestations')
      ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
      ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
      ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
      ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
      ->select('demandes.id as demande_id',
          'users.id as user_id', 'users.name as client_name','users.nameD as client_nameD','users.emailD as client_emailD' ,'users.tel as client_tel',
          'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
          'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
          'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
          'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
          'contrats.signataire as contrat_signataire',
          DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
      )
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
              $prestationPrice = null;  // Initialize as null for clarity
             
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
   
  
      // Debugging to check the result (optional)
      // dd($demandesPrestations, $prestationsQuantities);
  
      // Fetch additional data (consider using eager loading or model relationships)
      $prestations = prestation::all();
      $users = User::where('role', 'user')->get();
      
      return view('ingenieur.ing_demandeE', [
          'prestations' => $prestations,
          'users' => $users,
          'demandesPrestations' => $demandesPrestations,
          'prestationsQuantities' => $prestationsQuantities,
      ]);
  }

  public function ingenieur_Dash_demandeS()
  {
      // ... (rest of the code before the query)
  
      $demandesPrestations = DB::table('demande_prestations')
      ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
      ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
      ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
      ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
      ->select('demandes.id as demande_id',
          'users.id as user_id', 'users.name as client_name', 'users.tel as client_tel',
          'users.email as client_email', 'users.typeCL as client_type','users.nameD as client_nameD','users.emailD as client_emailD', 'users.adrCL as client_adr',
          'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
          'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
          'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
          'contrats.signataire as contrat_signataire',
          DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
      )
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
              $prestationPrice = null;  // Initialize as null for clarity
             
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
   
  
      // Debugging to check the result (optional)
      // dd($demandesPrestations, $prestationsQuantities);
  
      // Fetch additional data (consider using eager loading or model relationships)
      $prestations = prestation::all();
      $users = User::where('role', 'user')->get();
     
      return view('ingenieur.ing_demandeS', [
          'prestations' => $prestations,
          'users' => $users,
          'demandesPrestations' => $demandesPrestations,
          'prestationsQuantities' => $prestationsQuantities,
      ]);
  }

  public function ingenieur_Dash_demandeC()
  {
      // ... (rest of the code before the query)
  
      $demandesPrestations = DB::table('demande_prestations')
      ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
      ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
      ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
      ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
      ->select('demandes.id as demande_id',
          'users.id as user_id', 'users.name as client_name', 'users.tel as client_tel',
          'users.email as client_email', 'users.typeCL as client_type','users.nameD as client_nameD','users.emailD as client_emailD', 'users.adrCL as client_adr',
          'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
          'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
          'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
          'contrats.signataire as contrat_signataire',
          DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
      )
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
              $prestationPrice = null;  // Initialize as null for clarity
             
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
   
  
      // Debugging to check the result (optional)
      // dd($demandesPrestations, $prestationsQuantities);
  
      // Fetch additional data (consider using eager loading or model relationships)
      $prestations = prestation::all();
      $users = User::where('role', 'user')->get();
      
      return view('ingenieur.contratS', [
          'prestations' => $prestations,
          'users' => $users,
          'demandesPrestations' => $demandesPrestations,
          'prestationsQuantities' => $prestationsQuantities,
      ]);
  }

  public function ingenieur_Dash_demandeO()
  {
      // ... (rest of the code before the query)
  
      $demandesPrestations = DB::table('demande_prestations')
          ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
          ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
          ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
          ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
          ->leftJoin('oeps', 'demandes.id_oep', '=', 'oeps.id')
          ->select('demandes.id as demande_id',
              'users.id as user_id', 'users.name as client_name','users.nameD as client_nameD','users.emailD as client_emailD', 'users.tel as client_tel',
              'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
              'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
              'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
              'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
              'contrats.signataire as contrat_signataire',
              'oeps.num_oep as num_oep',
              DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
          )
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
              $prestationPrice = null;  // Initialize as null for clarity
             
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
      $users = User::where('role', 'user')->get();
      
      // Fetch data from the 'oeps' table
      $oeps = DB::table('oeps')->get();
      
      return view('ingenieur.oepS', [
          'prestations' => $prestations,
          'users' => $users,
          'demandesPrestations' => $demandesPrestations,
          'prestationsQuantities' => $prestationsQuantities,
          'oeps' => $oeps,  // Add 'oeps' data to the view
      ]);
  }
  
  public function ingenieur_Dash_demandeR()
  {
      // ... (rest of the code before the query)
  
      $demandesPrestations = DB::table('demande_prestations')
      ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
      ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
      ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
      ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
      ->select('demandes.id as demande_id',
          'users.id as user_id', 'users.name as client_name', 'users.tel as client_tel',
          'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
          'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
          'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
          'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
          'contrats.signataire as contrat_signataire',
          DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
      )
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
              $prestationPrice = null;  // Initialize as null for clarity
             
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
   
  
      // Debugging to check the result (optional)
      // dd($demandesPrestations, $prestationsQuantities);
  
      // Fetch additional data (consider using eager loading or model relationships)
      $prestations = prestation::all();
      $users = User::where('role', 'user')->get();
      
      return view('ingenieur.rapportM', [
          'prestations' => $prestations,
          'users' => $users,
          'demandesPrestations' => $demandesPrestations,
          'prestationsQuantities' => $prestationsQuantities,
      ]);
  }

  
public function testPdf($pdfId){
    
    return $this->pdf_dash($pdfId);
}
public function pdf_dash($devisId)
{
    $demandesPrestations = DB::table('demande_prestations')
        ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
        ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
        ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
        ->select('demandes.id as demande_id',
            'users.id as user_id', 'users.name as client_name','users.nameD as client_nameD','users.emailD as client_emailD', 'users.tel as client_tel',
            'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
            'users.fax as client_fax', 'demandes.*',
            DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations'))
        ->where('demandes.id', $devisId) // Filter by demand ID
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
            $prestationPrice = null;  // Initialize as null for clarity
         
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
    $prestations = prestation::all();
    $users = User::where('role', 'user')->get();

    // 1. Générer le contenu HTML du devis
    $devis = [
        'id' => $devisId,
        'demandesPrestations' => $demandesPrestations,
        'prestationsQuantities' => $prestationsQuantities,
        // Ajoutez d'autres attributs fictifs du devis au besoin
    ];

    $html = View::make('ingenieur.pdf', compact('devis'))->render();

    // 2. Instancier Dompdf
    $pdf = new Dompdf();

    // 3. Charger le contenu HTML dans Dompdf et générer le PDF
    $pdf->loadHtml($html);
    $pdf->render();

    // 4. Récupérer le contenu PDF généré
    $pdfContent = $pdf->output();

    // 5. Passez le contenu HTML à la vue
  
    return view('ingenieur.vue', [
        'pdfContent' => $pdfContent]);
}

    



public function StoreInfoDemande(Request $request)
{
    
    
  // Validation des données (using try-catch for error handling)

$validatedData = $request->validate([
    'nameD' => 'required|string',
  'typeCL' => 'required|string',
  'adrCL' => 'required|string',
  'adrIN' => 'required|string',
  'tel' => 'required',
  'fax' => 'required',
  'emailD' => 'required|email', // Check for unique email
  'date' => 'required|date',
 
]);

// Transaction for data saving (ensures all data is saved or none)
$totalPrix = 0;
foreach ($request->input('countries', []) as $prestationId) {
  $prestation = prestation::find($prestationId); // Replace with your model logic
  if ($prestation) {
    $totalPrix += $prestation->prix;
  }
}

// Create user
$user = User::create([
  'nameD' => $validatedData['nameD'],
  'typeCL' => $validatedData['typeCL'],
  'adrCL' => $validatedData['adrCL'],
  'tel' => $validatedData['tel'],
  'fax' => $validatedData['fax'],
  'emailD' => $validatedData['emailD'],
  'role' => 'user', // Consider using a configuration or logic here
 
]);

// Create demande
$demande = new demande(); // Replace with your model logic
$demande->date_d = $validatedData['date'];
$demande->adr_int = $validatedData['adrIN'];
$demande->id_user = $user->id;
$demande->total_prix = $totalPrix;
$demande->type_demande = 'sonalgaz';
$demande->save();

// Associate prestations with the created demande (assuming demande_prestation model)
foreach ($request->input('countries', []) as $prestationId) {
  $de_prestation = new demande_prestation(); // Replace with your model logic
  $de_prestation->id_pres = $prestationId;
  $de_prestation->id_demande = $demande->id;
  $de_prestation->quantite = "1";
  $de_prestation->save();
}


notify()->success('Demande a été enregistrer. ') ;
    return redirect(route('demande_sonalgaz'));


}



public function update(Request $request,$demandeId)
{
    
     
    // Validate the incoming form data
    $request->validate([
        'nameD' => 'required|string',
        'typeCL' => 'required|string',
        'adrCL' => 'required|string',
        'adrIN' => 'required|string',
        'tel' => 'required',
        'fax' => 'required',
        'emailD' => 'required|email', // Check for unique email
        'date' => 'required|date',
        // ... other validation rules if needed
    ]);

    // Find the demande and potentially the user
    $demande = demande::find($demandeId);
    $user = User::find($demande->id_user);

   // Update the user information (if applicable)
$user->nameD =  $request->nameD;
$user->typeCL =  $request->typeCL;
$user->adrCL =  $request->adrCL;
$user->tel =  $request->tel;
$user->fax = $request->fax;
$user->emailD =  $request->emailD; // Keep existing email if not changed

$user->save();

// Update the demande information
$demande->date_d =  $request->date;
$demande->adr_int =  $request->adrIN;
$demande->save();

    
notify()->success('Demande a été modifier. ') ;
return redirect(route('demande_sonalgaz'));



  }

  public function getPrestations(Request $request)
{
  $selectedChapitre = $request->query('chapitre');
  $demandeId = $request->query('demandeId'); // Access the demandeId parameter

  // Filter based on both chapitre and demandeId (if provided)
  $query = prestation::where('chapitre', $selectedChapitre);
  if ($demandeId) {
    $query->where('demande_id', $demandeId);
  }

  $prestations = $query->get();
  

  return response()->json($prestations);
}


public function getPrice(Request $request)


    {
     
        // Récupérer le nom de la prestation et la quantité depuis la requête GET
        $prestation = $request->input('prestation');
        $quantity = $request->input('quantity');
      
        Log::info('Prestation: ' . $prestation);
        Log::info('Quantity: ' . $quantity);
        // Requête pour récupérer le prix de la prestation depuis la base de données
        $prixUnitaire = prestation::where('nom_pres', $prestation)->value('prix');

        // Calculer le prix total en fonction de la quantité
        $totalPrice = $prixUnitaire * $quantity;

        // Renvoyer le prix total au format JSON
        return response()->json(['totalPrice' => $totalPrice]);
    }

   
    



 public function storePrestation(Request $request,$idP){
 
 
    // Récupérez les données envoyées par le formulaire
    
    $nomPrestation = $request->input('prest');
    $quantite = $request->input('quantite');

    // Recherchez l'ID de la prestation à partir de son nom
    $prestation = prestation::where('nom_pres', $nomPrestation)->first();

   

    // Vérifiez si une demande de prestation avec la même prestation existe déjà
    $existingPrestation = demande_prestation::where('id_demande', $idP)
        ->where('id_pres', $prestation->id)
        ->first();
        
    if ($existingPrestation) {
        // Mettez à jour la quantité existante
        $existingPrestation->quantite += $quantite;
        $existingPrestation->save();
    } else {
        // Créez une nouvelle entrée dans la base de données
        demande_prestation::create([
            'id_demande' => $idP,
            'id_pres' => $prestation->id, // Utilisez l'ID de la prestation
            'quantite' => $quantite,
        ]);
    }
    $demande = Demande::find($idP);
    $demande->total_prix += $prestation->prix * $quantite;
    $demande->save();

    // Redirigez l'utilisateur vers une page appropriée
    notify()->success('Prestation a été ajoutée avec succès. ') ;
    return redirect(route('demande_sonalgaz'));

  }

  public function deletePrestation(Request $request)
{
    // Récupérer les données de la requête
    $demandeId = $request->input('demande_id');
    $prestationName = $request->input('prestation_name');
   
    // Récupérer la prestation associée au nom de la prestation
    $prestation = prestation::where('nom_pres', $prestationName)->first();

    // Vérifier si la prestation existe
    if ($prestation) {
        // Récupérer la demande associée
        $demande = demande::find($demandeId);

        // Vérifier si une demande de prestation avec la même prestation existe déjà
        $existingPrestation = demande_prestation::where('id_demande', $demandeId)
            ->where('id_pres', $prestation->id)
            ->first();

        // Si une demande de prestation existe déjà, procédez à la suppression et à la mise à jour du prix total de la demande
        if ($existingPrestation) {
            // Enregistrer le prix de la prestation avant la suppression
            $prixPrestation = $prestation->prix;

            // Supprimer la prestation
            if ($existingPrestation->quantite > 1) {
                $existingPrestation->quantite = $existingPrestation->quantite - 1;
                $existingPrestation->save();
            } else {
                $existingPrestation->delete();
            }
            // Mettre à jour le prix total de la demande en soustrayant le prix de la prestation supprimée
            $demande->total_prix -= $prixPrestation;
            $demande->save();

            // Retourner une réponse indiquant le succès de la suppression
            notify()->success('Prestation a été supprimée.');
            return redirect(route('demande_sonalgaz'));
        } else {
            // Retourner une réponse indiquant que la demande de prestation n'existe pas
            return response()->json(['message' => 'Prestation not found for this demande']);
        }
    } else {
        // Retourner une réponse indiquant que la prestation n'existe pas
        return response()->json(['message' => 'Prestation not found']);
    }
}


public function validerDevis($demandeId)
{

    // Trouver la demande à valider
    $demande = demande::find($demandeId);

    // Vérifier si la demande existe
    if ($demande) {
        // Changer l'état de la demande
        $demande->etat = 'devis_etabli'; // Modifier 'Validé' selon vos besoins

        // Enregistrer les modifications
        $demande->save();

        // Rediriger l'utilisateur ou retourner une réponse JSON, selon vos besoins
        notify()->success('Devis a été valider. ') ;
        return redirect(route('demande_sonalgaz'));
    } else {
        
        return redirect()->back()->with('error', 'Demande introuvable.');
    }
}

public function changerTypeDemande(Request $request,$typeId) {
   
    $demande = demande::find($typeId);
   
        $demande->type_demande ='sonalgaz';
        $demande->etat='demande_enregistrer _enligne';
        $demande->save();
        notify()->success('demande a été accepter. ') ;
        return redirect(route('demande_enligne'));
        
}

public function deleteDataE(Request $request, $demandeId)
{
  

    // Récupérer la demande
    
    $demande = demande::findOrFail($demandeId);
   $demande->etat='refuser';
    // Supprimer la demande elle-même
    $demande->save();
    // Supprimer l'utilisateur associé à la demande
    notify()->success('demande a été refusée . ') ;
    return redirect(route('demande_enligne'));
    
}

public function deleteData(Request $request, $demandeId)
{
    // Récupérer tous les enregistrements de DemandePrestation associés à cette demande
    $demandePrestations = demande_prestation::where('id_demande', $demandeId)->get();

    // Parcourir tous les enregistrements et les supprimer
    foreach ($demandePrestations as $demandePrestation) {
        $demandePrestation->delete();
    }

    // Récupérer la demande
    
    $demande = demande::findOrFail($demandeId);
    User::where('id', $demande->id_user)->delete();
    // Supprimer la demande elle-même
    $demande->delete();

    // Supprimer l'utilisateur associé à la demande
    notify()->success('demande a été supprimée . ') ;
    return redirect(route('demande_sonalgaz'));
}

public function devisPaye($demandeId)
{
   
    // Trouver la demande à valider
    $demande = demande::find($demandeId);
    
    $userID = $demande->id_user;
    $contrat= new contrat();
    $contrat->id_user=$userID ;
    $contrat->save();


    // Vérifier si la demande existe
    if ($demande) {
        // Changer l'état de la demande
        $demande->etat = 'devis_paye'; // Modifier 'Validé' selon vos besoins
        $demande->type_demande='contrat';
        $demande->id_contrat=$contrat->id;
        // Enregistrer les modifications
        $demande->save();

        // Rediriger l'utilisateur ou retourner une réponse JSON, selon vos besoins
        notify()->success('Devis a été payé. ') ;
        return redirect(route('demande_sonalgaz'));
    } else {
        
        return redirect()->back()->with('error', 'Demande introuvable.');
    }
}








public function testcontrat($contratId){
    
    return $this->contrat_dash($contratId);
}
public function contrat_dash($contratId)
{
    $demandesPrestations = DB::table('demande_prestations')
        ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
        ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
        ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
        ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
        ->select('demandes.id as demande_id',
        'users.id as user_id', 'users.name as client_name', 'users.tel as client_tel',
        'users.email as client_email', 'users.typeCL as client_type','users.nameD as client_nameD','users.emailD as client_emailD', 'users.adrCL as client_adr',
        'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
        'contrats.Nregistre as contrat_Nregistre','contrats.id as contrat_id', 'contrats.banque as contrat_banque',
        'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
        'contrats.signataire as contrat_signataire',
            DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations'))
        ->where('demandes.id', $contratId) // Filter by demand ID
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
            $prestationPrice = null;  // Initialize as null for clarity
         
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
    $prestations = prestation::all();
    $users = User::where('role', 'user')->get();

    // 1. Générer le contenu HTML du devis
    $contrat = [
        'id' => $contratId,
        'demandesPrestations' => $demandesPrestations,
        'prestationsQuantities' => $prestationsQuantities,
        // Ajoutez d'autres attributs fictifs du devis au besoin
    ];

    $html = View::make('ingenieur.contrat', compact('contrat'))->render();

    // 2. Instancier Dompdf
    $pdf = new Dompdf();

    // 3. Charger le contenu HTML dans Dompdf et générer le PDF
    $pdf->loadHtml($html);
    $pdf->render();

    // 4. Récupérer le contenu PDF généré
    $pdfContent = $pdf->output();

    // 5. Passez le contenu HTML à la vue
  
    return view('ingenieur.vue2', [
        'pdfContent' => $pdfContent]);
}


public function editContrat(Request $request, $demandeID){

    $request->validate([
        'Nregistre' => 'required|string ',
        'banque' => 'required|string',
        'agence' => 'required|numeric',
        'Ncompte' => 'required|numeric  ',
        'signataire' => 'required|string',
       
    ]);

    $demande = demande::find($demandeID);
    
    
    $contrat = contrat::find($demande->id_contrat);;
   

$contrat->Nregistre =  $request->Nregistre;
$contrat->banque =  $request->banque;
$contrat->agence =  $request->agence;
$contrat->Ncompte =  $request->Ncompte;
$contrat->signataire = $request->signataire;

$contrat->save();



notify()->success('Contrat editer avec succés. ') ;
        return redirect(route('contrat_sonalgaz'));
}


public function changerTypeContrat(Request $request,$contratId) {
   
    $demande = demande::find($contratId);
   
        
        $demande->etat='contrat_etabli';
        $demande->save();
        notify()->success('contrat a été valider. ') ;
        return redirect(route('contrat_sonalgaz'));
        
}

public function changerTypeOep(Request $request,$oepId) {
   
    $oep= new oep();
    $oep->num_oep = $oepId . '-DRC-OEP/2024';
    $oep->save();

    $demande = demande::find($oepId);
        $demande->etat='oep_etabli';
        $demande->type_demande='oep';
        $demande->id_oep= $oep->id;
        $demande->save();
        notify()->success('contrat a été signé. ') ;
        return redirect(route('contrat_sonalgaz'));
        
}





public function testoep($opId){
    
    return $this->oep_dash($opId);
}
public function oep_dash($oepId)
{
    $demandesPrestations = DB::table('demande_prestations')
        ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
        ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
        ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
        ->leftJoin('oeps', 'demandes.id_oep', '=', 'oeps.id')
        ->select('demandes.id as demande_id',
            'users.id as user_id', 'users.name as client_name', 'users.tel as client_tel',
            'users.email as client_email', 'users.typeCL as client_type','users.nameD as client_nameD','users.emailD as client_emailD', 'users.adrCL as client_adr',
            'users.fax as client_fax', 'demandes.*','demandes.type_demande', // Ajout du champ type_demande
            'oeps.num_oep as num_oep',
            DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations'))
        ->where('demandes.id', $oepId) // Filter by demand ID
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
            $prestationPrice = null;  // Initialize as null for clarity
         
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
    $prestations = prestation::all();
    $users = User::where('role', 'user')->get();

    // 1. Générer le contenu HTML du devis
    $oep = [
        'id' => $oepId,
        'demandesPrestations' => $demandesPrestations,
        'prestationsQuantities' => $prestationsQuantities,
        // Ajoutez d'autres attributs fictifs du devis au besoin
    ];

    $html = View::make('ingenieur.oep', compact('oep'))->render();

    // 2. Instancier Dompdf
    $pdf = new Dompdf();

    // 3. Charger le contenu HTML dans Dompdf et générer le PDF
    $pdf->loadHtml($html);
    $pdf->render();

    // 4. Récupérer le contenu PDF généré
    $pdfContent = $pdf->output();

    // 5. Passez le contenu HTML à la vue
  
    return view('ingenieur.vue3', [
        'pdfContent' => $pdfContent]);
}

public function changerType(Request $request,$OId) {
   
   
    $demande = demande::find($OId);
        $demande->etat='demande_exécutée';
        $demande->type_demande='terminer';
        
        $demande->save();
        notify()->success('demande exécutée. ') ;
        return redirect(route('oep_sonalgaz'));
        
}

public function index(Request $request)
{
    
    $demandesPrestations = DB::table('demande_prestations')
    ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
    ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
    ->join('users', 'demandes.id_user', '=', 'users.id') // Join users table
    ->leftJoin('contrats', 'demandes.id_contrat', '=', 'contrats.id') // Use LEFT JOIN for contrats table
    ->select('demandes.id as demande_id',
        'users.id as user_id', 'users.name as client_name', 'users.tel as client_tel',
        'users.email as client_email', 'users.typeCL as client_type', 'users.adrCL as client_adr',
        'users.fax as client_fax', 'demandes.*', 'demandes.type_demande', // Ajout du champ type_demande
        'contrats.Nregistre as contrat_Nregistre', 'contrats.banque as contrat_banque',
        'contrats.agence as contrat_agence', 'contrats.Ncompte as contrat_Ncompte',
        'contrats.signataire as contrat_signataire',
        DB::raw('GROUP_CONCAT(DISTINCT CONCAT(prestations.nom_pres, " (", demande_prestations.quantite, ")") SEPARATOR ", ") AS intitules_prestations')
    )
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
            $prestationPrice = null;  // Initialize as null for clarity
           
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
 

    // Debugging to check the result (optional)
    // dd($demandesPrestations, $prestationsQuantities);

    // Fetch additional data (consider using eager loading or model relationships)
    $prestations = prestation::all();
    $users = User::where('role', 'user')->get();
    
    $selectedMonthYear = $request->query('selectedMonthYear');
    // Ex: "2024-02"
    $results = [];

    if ($selectedMonthYear) {
        list($selectedYear, $selectedMonth) = explode('-', $selectedMonthYear);

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->endOfMonth();

        // Nombre de demandes de prestations reçues
        $nbrDemandes = DB::table('demandes')
            ->whereBetween('date_d', [$startDate, $endDate])
            ->count();

        // Nombre de prestations par type
        $nbrPrestationsByType = DB::table('demande_prestations')
        ->join('prestations', 'demande_prestations.id_pres', '=', 'prestations.id')
        ->join('demandes', 'demande_prestations.id_demande', '=', 'demandes.id')
        ->whereBetween('demandes.date_d', [$startDate, $endDate])
        ->select('prestations.chapitre', DB::raw('SUM(demande_prestations.quantite) as total'))
        ->groupBy('prestations.chapitre')
        ->get()
        ->keyBy('chapitre');

        // Nombre de contrats
        $nbrContrats = DB::table('demandes')
            ->whereBetween('date_d', [$startDate, $endDate])
            ->whereNotNull('id_contrat')
            ->count();

        // Nombre de prestations réalisées (en supposant que 'réalisée' est l'état souhaité)
        $nbrPrestationsRealisees = DB::table('demandes')
            ->whereBetween('demandes.date_d', [$startDate, $endDate])
            ->where('demandes.etat', 'demande_exécutée')
            ->count();

        // Préparer les résultats pour l'affichage
        $results = [
            'date'=>$selectedMonthYear,
            'Nombre de demandes de prestations reçues' => $nbrDemandes,
            'Nombre de prestations Maintenance' => $nbrPrestationsByType['Maintenance']->total ?? 0,
            'Nombre de prestations Mesures' => $nbrPrestationsByType['Mesure et diagnostic']->total ?? 0,
            'Nombre de prestations Assistance' => $nbrPrestationsByType['Assistance aux clients']->total ?? 0,
            'Nombre de prestations Location' => $nbrPrestationsByType['Location']->total ?? 0,
            'Nombre de contrats' => $nbrContrats,
            'Nombre de prestations réalisées' => $nbrPrestationsRealisees,
        ];
    }
//    return view('ingenieur.ing_dash', [
//         'results' => $results,
//         'selectedMonthYear' => $selectedMonthYear,
//         'prestations' => $prestations,
//         'users' => $users,
//         'demandesPrestations' => $demandesPrestations,
//         'prestationsQuantities' => $prestationsQuantities,
//     ]);
return response()->json([
    'date'=>$selectedMonthYear,
    'Nombre de demandes de prestations reçues' => $nbrDemandes,
    'Nombre de prestations Maintenance' => $nbrPrestationsByType['Maintenance']->total ?? 0,
    'Nombre de prestations Mesures' => $nbrPrestationsByType['Mesure et diagnostic']->total ?? 0,
    'Nombre de prestations Assistance' => $nbrPrestationsByType['Assistance aux clients']->total ?? 0,
    'Nombre de prestations Location' => $nbrPrestationsByType['Location']->total ?? 0,
    'Nombre de contrats' => $nbrContrats,
    'Nombre de prestations réalisées' => $nbrPrestationsRealisees,
], 201);
    
}


}














  