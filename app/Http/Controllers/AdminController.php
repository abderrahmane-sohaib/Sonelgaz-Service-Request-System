<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\prestation;
class AdminController extends Controller
{
    public function admin_Dash(){
        $ingenieurs = User::where('role', 'ingenieur')->get();
        $prestations=prestation::all();
        return view('admin.admin_dash',['ingenieurs' =>$ingenieurs,'prestations' => $prestations]);
    }
    public function admin_ing(){
        $ingenieurs = User::where('role', 'ingenieur')->get();
        $prestations=prestation::all();
        return view('admin.liste_ing',['ingenieurs' =>$ingenieurs,'prestations' => $prestations]);
    }
    public function admin_prestation(){
        $ingenieurs = User::where('role', 'ingenieur')->get();
        $prestations=prestation::all();
        return view('admin.listeP',['ingenieurs' =>$ingenieurs,'prestations' => $prestations]);
    }
    public function admin_client(){
        $ingenieurs = User::where('role', 'ingenieur')->get();
        $prestations=prestation::all();
        return view('admin.editerC',['ingenieurs' =>$ingenieurs,'prestations' => $prestations]);
    }

    public function data($id) {
        $ingenieurs = User::where('role', 'ingenieur')->get();

// Récupérer un ingénieur spécifique par son ID s'il existe
$ingenieur = $ingenieurs->where('id', $id)->first();
        return response()->json($ingenieur);
    }
    
    public function StoreInfo(Request $request){
        $request->validate([
            'nom' => 'required|string|min:3',
            'prenom' => 'required|string|min:3',
            'email' => 'required|email',
            'tel'=>'required|max:10',
            'password' => 'required|min:8',
        ]);
        $user = User::create([
            'name' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
            'role'=>'ingenieur',
            
        ]);
        
 
 
 
notify()->success('L\'ingénieur a bien été ajouté avec succes. ') ;
return redirect(route('admin_ing'));
 
                 
         
     
     }

     public function update(Request $request , $ingenieurId)
    {


    // Valider les données du formulaire
     $request->validate([
            'name' => 'required|string|min:3',
            'prenom' => 'required|string|min:3',
            'email' => 'required|email',
            'tell' => 'required|max:10',
            'password' => 'required|min:8',
        // Autres règles de validation pour d'autres champs si nécessaire
    ]);

    // Récupérer l'ingénieur à mettre à jour
    $ingenieur = User::findOrFail($ingenieurId);

    // Mettre à jour les informations de l'ingénieur avec les données du formulaire
    $ingenieur->name = $request->name;
    $ingenieur->prenom = $request->prenom;
    $ingenieur->email = $request->email;
    $ingenieur->tel = $request->tell;
    $ingenieur->password = Hash::make($request->password);
    // Mettre à jour d'autres champs si nécessaire

    // Sauvegarder les modifications dans la base de données
    $ingenieur->save();

    // Rediriger l'utilisateur vers une page appropriée après la modification
    
notify()->success('Les informations sont modifier avec succes.') ;
return redirect(route('admin_ing'));
    
}

       


public function toggleStatus($id)
{
    $ingenieur = User::findOrFail($id);

    // Inverser le statut
    $ingenieur->status = $ingenieur->status === 'active' ? 'inactive' : 'active';
    $ingenieur->save();

    notify()->success('le compte  a bien été modifier avec succes..') ;
    return redirect(route('admin_ing'));
   
}

public function StoreP(Request $request ){
    $request->validate([
        'IntitulePrestation' => 'required|string',
        'Chapitre' => 'required|string',
        'Prix' => 'required|numeric',
        
    ]);
   prestation::create([
        'nom_pres' => $request->IntitulePrestation,
        'prix' => $request->Prix,
        'chapitre' => $request->Chapitre,
       
        
    ]);
    notify()->success('Prestation a été ajouter.') ;
    return redirect(route('admin_prestation'));
    
    
}

public function updateP(Request $request,$prsID ){
    
    $request->validate([
        'Intitule' => 'required|string',
        'Chap' => 'required|string',
        'Pr' => 'required|numeric',
        
    ]);
    $prestation=prestation::findOrFail($prsID);
   
    $prestation->nom_pres = $request->Intitule;
    $prestation->prix =$request->Pr;
    $prestation->chapitre =$request->Chap;
    $prestation->save();
        
    notify()->success('Prestation a été modifier.') ;
    return redirect(route('admin_prestation'));
    
}

public function deleteP(int $ID)
{
   
   
    $prestation = prestation::findOrFail($ID);

    // Soft delete (recommended for data integrity)
    $prestation->delete();
    
    notify()->success('Prestation a été supprimée.') ;
    return redirect(route('admin_prestation'));
   
}

}