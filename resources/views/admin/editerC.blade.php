<div class="any"  style="display: none; margin-top:70px;">
    <button type="button" class="btn btn-primary" style="background-color:#6571ff;" onclick="show3()" >créer un compte ingénieure</button>
    <!-- Pop-up modale -->
    <div id="ajouter" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> créer compte ing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ing" method="POST" action="{{route('admin.store')}}" class="bg-gray-100">
                        @csrf <!-- Ajouter le jeton CSRF -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input id="name" class="form-control" name="nom" type="text">
                        </div>
                        <div class="mb-3">
                          <label for="prenom" class="form-label">Prénom</label>
                          <input id="prenom" class="form-control" name="prenom" type="text" >
                      </div>
                      <div class="mb-3">
                          <label for="email" class="form-label">Email</label>
                          <input id="email" class="form-control" name="email" type="email" >
                      </div>
                     
                      <div class="mb-3">
               <label for="tel" class="form-label">tel</label>
               <input id="tel" class="form-control" name="tel" type="text" >
              </div>
              
              <div class="mb-3">
                <label for="password" class="form-label">password</label>
                <input id="password" class="form-control" name="password" type="password" >
               </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bg-gray-100" style="color: black" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" style="background-color:#6571ff;" form="ing" class="btn btn-primary">valider</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de la pop-up modale -->
  <table id="dataTableExample" class="table" >
      <thead>
          <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Num</th>
              <th >
                <button style="padding-left: 150px ;width:20px;height:20px">
                  
                  <i data-feather="settings"></i>
                </button>
              </th>
          </tr>
      </thead>
      <tbody>
          @foreach($ingenieurs as $ingenieur)
          <tr>
              <td>{{$ingenieur->name}}</td>
              <td>{{$ingenieur->prenom}}</td>
              <td>{{$ingenieur->email}}</td>
              <td>
                {{$ingenieur->tel}}

                      
                      
                        </td>
                        <td >
                            <div class="d-flex align-items-center" style="padding-left:60px ">
                                <a class="change-color-on-hover"  onclick="show('{{$ingenieur->id}}')">
                                    <button type="button" class="btn btn-primary btn-icon " style="background-color:#6571ff;">
                                        <i data-feather="edit"></i>
                                    </button>
                                </a>
                                <!-- Pop-up modale -->
                                <div id="editModal{{$ingenieur->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modifier le compte</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="updateForm{{$ingenieur->id}}" method="POST" action="{{ route('admin.edit', ['ingenieurId' => $ingenieur->id]) }}" class="bg-gray-100">
                                                    @csrf <!-- Ajouter le jeton CSRF -->
                                                    <div class="mb-3">
                                                        <label for="name{{$ingenieur->id}}" class="form-label">Nom</label>
                                                        <input id="name{{$ingenieur->id}}" class="form-control" name="name" type="text" value="{{ $ingenieur->name }}">
                                                    </div>
                                                    <div class="mb-3">
                                                      <label for="prenom" class="form-label">Prénom</label>
                                                      <input id="prenom" class="form-control" name="prenom" type="text" value="{{ $ingenieur->prenom }}">
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="email" class="form-label">Email</label>
                                                      <input id="email" class="form-control" name="email" type="email" value="{{ $ingenieur->email }}">
                                                  </div>
                                                  <div class="mb-3">
                                                    <label for="tel" class="form-label">tel</label>
                                                    <input id="tel" class="form-control" name="tell" type="text" value="{{ $ingenieur->tel }}">
                                                   </div>
                                                  <div class="mb-3">
                                           <label for="password" class="form-label">Password</label>
                                           <input id="password" class="form-control" name="password" type="password" >
                                          </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary bg-gray-100" style="color: black" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" style="background-color:#6571ff;" form="updateForm{{$ingenieur->id}}" class="btn btn-primary">valider</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin de la pop-up modale -->
                                <form method="post" action="{{ route('ingenieur.toggleStatus', $ingenieur->id) }}">
                                  @csrf
                               @method('post')
                                  <button type="submit" class="btn btn-primary" style="background-color: #6571ff; margin-left: 20px; margin-right: 20px;" {{ $ingenieur->status === 'active' ? 'disabled' : '' }}>
                                      {{ $ingenieur->status === 'active' ? 'Activer' : 'Activer ' }}
                                  </button>
                              </form>
                                <form method="post" action="{{ route('ingenieur.toggleStatus', $ingenieur->id) }}">
                                  @csrf
                                  @method('post')
                                   
                                    <button type="submit" class="btn btn-primary" style="background-color: #ff3366;" {{ $ingenieur->status === 'inactive' ? 'disabled' : '' }}>
                                        {{ $ingenieur->status === 'inactive' ? 'Désactiver' : 'Désactiver ' }}
                                    </button>
                                </form>
                            </div>
                        </td>
          </tr>
          @endforeach
      </tbody>
  </table>
</div>
              


<!-- Contenu existant -->


<div class="prestation" style="display: none; margin-top: 70px; margin-left:300px">
<button type="button" class="btn btn-primary" style="background-color:#6571ff;" onclick="show1()" >Ajouter Nouvelle  Prestation</button>
 <!-- Pop-up modale -->
 <div id="edit" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter prestation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update" method="POST" action="{{route('admin.prestation')}}" class="bg-gray-100">
                    @csrf <!-- Ajouter le jeton CSRF -->
                    <div class="mb-3">
                        <label for="Intitule Prestation" class="form-label">Intitulé Prestation</label>
                        <input id="Intitule Prestation" class="form-control" name="IntitulePrestation" type="text" >
                    </div>
                    <div class="mb-3">
                      <label for="Chapitre" class="form-label">Chapitre</label>
                      <input id="Chapitre" class="form-control" name="Chapitre" type="text" >
                  </div>
                  <div class="mb-3">
                      <label for="Prix" class="form-label">Prix</label>
                      <input id="Prix" class="form-control" name="Prix" type="text" >
                  </div>
                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-gray-100" style="color: black" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" style="background-color:#6571ff;" form="update" class="btn btn-primary">valider</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin de la pop-up modale -->
<table  id="datatab" class="table" >
    <thead>
        <tr>
          <th >#</th>
          <th >Intitulé Prestation</th>
          <th >Chapitre</th>
          <th >Prix</th>
            
            <th >
              <button style="padding-left: 50px ;width:20px;height:20px">
                
                <i data-feather="settings"></i>
              </button>
            </th>
            
        
        </tr>
       </thead>
       <tbody>
        @foreach($prestations as $prestation)
          
           <tr>
            
              <td>{{$prestation->id}}</td> <!-- ID de la demande -->
              <td>{{$prestation->nom_pres}}</td> <!-- Nom du client -->
              <td>{{$prestation->chapitre}}</td> <!-- Intitulés des prestations -->
              <!-- Autres colonnes de la demande de prestation -->
              <td>{{$prestation->prix}}</td>
             
            
           
            <td>
                <div class="d-flex align-items-center" style="padding-left:30px " >
                <a class="change-color-on-hover" style="padding-right:25px"  onclick="show2('{{$prestation->id}}')">
                    <button type="button" class="btn btn-primary btn-icon " style="background-color:#6571ff;width:20px;height:20px;">
                        <i data-feather="edit"></i>
                    </button>
                </a>
                 <!-- Pop-up modale -->
<div id="modifier{{$prestation->id}}" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modifier prestation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="modifier1{{$prestation->id}}" method="POST" action="{{route('admin.update', ['prsID' => $prestation->id]) }}" class="bg-gray-100">
                @csrf <!-- Ajouter le jeton CSRF -->
                <div class="mb-3">
                    <label for="Intitule Prestation" class="form-label">Intitulé Prestation</label>
                    <input id="Intitule Prestation" class="form-control" name="Intitule" type="text" value="{{$prestation->nom_pres}}" >
                </div>
                <div class="mb-3">
                  <label for="Chapitre" class="form-label">Chapitre</label>
                  <input id="Chapitre" class="form-control" name="Chap" type="text" value="{{$prestation->chapitre}}" >
              </div>
              <div class="mb-3">
                  <label for="Prix" class="form-label">Prix</label>
                  <input id="Prix" class="form-control" name="Pr" type="text" value="{{$prestation->prix}}">
              </div>
              
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary bg-gray-100" style="color: black" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" style="background-color:#6571ff;" form="modifier1{{$prestation->id}}" class="btn btn-primary">valider</button>
        </div>
    </div>
</div>
</div>
<!-- Fin de la pop-up modale -->

                <form  method="POST" action="{{route('admin.delete', ['ID' => $prestation->id]) }}" >
                    @csrf
                    <button type="submit" class="btn btn-danger btn-icon" style="background-color:#ff3366;width:20px;height:20px;">
                        <i data-feather="x"></i>
                    </button>
                </form>
            
                </div>
            </td>
               
              
            </div>
        </tr>


       @endforeach
    </tbody>
</table>
</div>

