


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
  <link rel="stylesheet" href="{{asset('assets/fonts/feather-font/css/iconfont.css')}}">
  <link
  rel="stylesheet"
  href="{{asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}"
/>
<link rel="stylesheet" href="{{asset('assets/vendors/prismjs/themes/prism.css')}}">
    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{asset ('assets/css/demo1/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/sweetalert2/sweetalert2.min.css')}}">
    <!-- End layout styles -->
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        
        <style>
            .error {
    border-color: red;
}
div#datatab_filter.dataTables_filter{
  margin-right: 170px;
  margin-top: -100px;
}
div#datatab_paginate.dataTables_paginate.paging_simple_numbers{
  margin-right: 180px;
  margin-top: 5px;
}
.modal-lg{
    width: 2000px;
    
    padding-top: 66px;
    margin-left: -80px;
    
}
div#datatab_length.dataTables_length{
  margin-top: -100px;
}
div#dataTableExample_filter.dataTables_filter{
    margin-right: -300px;
  margin-top: -60px;
}
table.dataTable th,
table.dataTable td {
    border: 1px solid rgb(222, 218, 218);
}
div#dataTableExample_paginate.dataTables_paginate.paging_simple_numbers{
  margin-right: 180px;
  margin-top: 5px;
}
.modal-lg{
    width: 2000px;
    
    padding-top: 66px;
    margin-left: -80px;
    
}
div#dataTableExample_length.dataTables_length{
  margin-top: -100px;
}
.success {
    border-color: green;
}
.flip-image {
    transition: transform 0.5s ease-in-out; /* Set animation duration and easing */
}

.flip-image.flipped {
  transform: scaleX(-1); /* Flips the image horizontally (left) */
}

            /* Styles pour changer la couleur lors du survol */
.change-color-on-hover:hover {
    filter: brightness(0.5) saturate(200%) hue-rotate(200deg);
    font-size: 9
    
}
.page-content {
    display: none;

}
.card-body{
   

}
.form-label{
  color: black
}

.form-control:focus {
    color: black; /* Changer la couleur du texte en noir */
}
   
table {
  border-spacing: 10px; /* Replace 10px with your desired value */
}


div#dataTableExample_filter.dataTables_filter{
  margin-right: -195px;
}
div#dataTableExample_paginate.dataTables_paginate.paging_simple_numbers{
  margin-right: -195px;
  margin-top: 5px
}

        </style>
    @notifyCss
    </head>
    <body class="font-sans antialiased">
        <x-notify::notify />
    
      <div >
          
          <!-- partial:partials/_sidebar.html -->
          <nav class="sidebar">
        <div class="sidebar-header">
          <a href="#" class="sidebar-brand">
           <span style="color: rgb(40, 40, 252)">Sonel</span> <span style="color: rgb(252, 146, 66)">GAZ</span>
        </a>
          <div class="sidebar-toggler not-active">
            <img src="{{ asset('images/arrow-right-circle.svg') }}" alt="" class="change-color-on-hover flip-image">
          </div>
        </div>
        <div class="sidebar-body" style="background-color: whitesmoke">
          <ul class="nav">
              <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
              <a href="{{route('admin.dash')}}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category">web apps</li>
           
            <li class="nav-item">
              <a href="{{route('admin_ing')}}" class="nav-link" >
                <i class="link-icon" data-feather="users"></i>
                <span class="link-title"> liste Ingénieures</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin_prestation')}}" class="nav-link"   >
                <i class="link-icon" data-feather="user-plus"></i>
                <span class="link-title">liste Prestations</span>
               
              </a>
              
            </li>

           
          </ul>
        </div>
      </nav>
    
          <!-- partial -->
      
          
      
  
      <!-- Custom js for this page -->
    
      <!-- End custom js for this page -->





















        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white ">
                   
                        
                    </div>
                    
                </header>
            @endif

            <!-- Page Content -->
            <main>
               
                <div class="any"  style="width:1250px; height:652px;margin-top:100px; margin-left:260px ">
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
                                            <input id="name" class="form-control" name="nom" type="text" required onkeyup="validateName()">
                                            <span id="name-Error"></span>
                                        </div>
                                        <div class="mb-3">
                                          <label for="prenom" class="form-label">Prénom</label>
                                          <input id="prenom" class="form-control" name="prenom" type="text" required>
                                      </div>
                                      <div class="mb-3">
                                          <label for="email" class="form-label">Email</label>
                                          <input id="email" class="form-control" name="email" type="email"  onkeyup="validateEmail()" required >
                                          <span id="email-Error"></span>
                                      </div>
                                     
                                      <div class="mb-3">
                               <label for="tel" class="form-label">tel</label>
                               <input id="tel" class="form-control" name="tel" type="text" required onkeyup="validatePhone()">
                               <span id="phone-Error"></span>
                              </div>
                              
                              <div class="mb-3">
                                <label for="password" class="form-label">password</label>
                                <input id="password" class="form-control" name="password" type="password" required>
                               </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary bg-gray-100" style="color: black" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" style="background-color:#6571ff;"  form="ing" class="btn btn-primary">valider</button>
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
              


            </main>
        </div>
        <script>
          let nameError = document.getElementById('name-Error');
          let phoneError = document.getElementById('phone-Error');
          let emailError = document.getElementById('email-Error');
         
          
          function validateName() {
              let userInput = document.getElementById('name').value;
              let test1 = /^[A-Za-z]+[A-Za-z]+$/;
          
              if (userInput.length == 0) {
                  nameError.innerHTML = "Please enter your full name";
                  nameError.style.color = "red";
                  return false;
              }
              if (!userInput.match(test1)) {
                  nameError.innerHTML = "Please enter a correct name";
                  nameError.style.color = "red";
                  return false;
              }
              window.sessionStorage.setItem("name", userInput);
              nameError.innerHTML = "Correct";
              nameError.style.color = "green";
              return true;
          }
          
          function validatePhone() {
              let phoneInput = document.getElementById('tel').value;
              let reg = /^(00213|\+213|0)(5|6|7)[0-9]{8}$/;
          
              if (phoneInput.length == 0) {
                  phoneError.innerHTML = "Please enter your phone";
                  phoneError.style.color = "red";
                  return false;
              }
              if (!phoneInput.match(reg)) {
                  phoneError.innerHTML = "Please enter a correct number";
                  phoneError.style.color = "red";
                  return false;
              }
              window.sessionStorage.setItem("phone", phoneInput);
              phoneError.innerHTML = "Correct";
              phoneError.style.color = "green";
              return true;
          }
          
          function validateEmail() {
              let emailInput = document.getElementById('email').value;
              let test3 = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
          
              if (emailInput.length == 0) {
                  emailError.innerHTML = "Please enter your email";
                  emailError.style.color = "red";
                  return false;
              }
              if (!emailInput.match(test3)) {
                  emailError.innerHTML = "Please enter a correct email";
                  emailError.style.color = "red";
                  return false;
              }
              window.sessionStorage.setItem("email", emailInput);
              emailError.innerHTML = "Correct";
              emailError.style.color = "green";
              return true;
          }
          
         
          
         
          </script>
        <!-- core:js -->
	<script src="{{asset ('assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->
<!-- Plugin js for this page -->
<script>
    const toggleIcon = document.getElementById("toggle-icon");
const sidebar = document.querySelector(".sidebar");


let timeoutId;

toggleIcon.addEventListener("click", () => {
  // Basculer la classe de masquage du menu
  sidebar.classList.toggle("hidden");
  // Gérer l'apparition et la disparition du menu
  if (sidebar.classList.contains("hidden")) {
    // Le menu est caché, on démarre le timer pour sa réapparition
    timeoutId = setTimeout(() => {
      
      sidebar.classList.remove("hidden");
    }, 2000); // Remplacer 2000 par le temps de disparition souhaité en ms
  } else {
    // Le menu est visible, on annule le timer s'il existe
    clearTimeout(timeoutId);
  }
});
    });
    </script>


<script>
  const image = document.querySelector('.flip-image');
  
  image.addEventListener('click', function() {
    image.classList.toggle('flipped');
  });
  
</script>

<script>
  // Sélectionnez l'élément de l'alerte
  const alertElement = document.querySelector('.alert');

  // Vérifiez si l'élément existe avant d'appliquer la temporisation
  if (alertElement) {
      // Définissez le temps en millisecondes après lequel l'alerte doit disparaître (par exemple, 3000ms pour 3 secondes)
      const timeoutDuration = 5000;

      // Fonction pour faire disparaître l'alerte après un certain temps
      const hideAlert = () => {
          // Ajoutez la classe 'd-none' pour masquer l'alerte
          alertElement.classList.add('d-none');
      };

      // Utilisez setTimeout pour appeler la fonction hideAlert après le délai spécifié
      setTimeout(hideAlert, timeoutDuration);
  }
</script>
<!-- core:js -->

<!-- endinject -->

<!-- inject:js -->
-- <script src="{{asset ('assets/vendors/feather-icons/feather.min.js')}}"></script>
<script src="{{asset ('assets/js/template.js')}}"></script>
<!-- endinject -->
         
     
         
         <script src="{{asset('assets/vendors/jquery-validation/jquery.validate.min.js')}}"></script>
         <script src="{{asset('assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
         <script src="{{asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
         <script src="{{asset('assets/js/datatable2.js')}}"></script>
         <script src="{{asset('assets/js/data.js')}}"></script>
         <script src="{{asset('assets/vendors/sweetalert2/sweetalert2.min.js')}}"></script>
         <script src="{{asset('assets/js/sweet-alert.js')}}"></script>
         <script src="{{asset('assets/vendors/prismjs/prism.js')}}"></script> 
          <script src="{{asset('assets/vendors/clipboard/clipboard.min.js')}}"></script>
          
          <script src="{{asset('assets/js/bootstrap-maxlength.js')}}"></script>
          <script src="{{asset('assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
          <script src="{{asset('assets/vendors/inputmask/jquery.inputmask.min.js')}}"></script>
          <script src="{{asset('assets/vendors/select2/select2.min.js')}}"></script>
          <script src="{{asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.js')}}"></script>
          <script src="{{asset('assets/js/tags-input.js')}}"></script>
          
        
  
    <script>
    // Sélectionnez tous les champs d'entrée
    const inputs = document.querySelectorAll('.form-control');
  
    // Parcourez tous les champs d'entrée
    inputs.forEach(input => {
        // Ajoutez un gestionnaire d'événements pour l'événement "focus"
        input.addEventListener("focus", function() {
            // Changer la couleur de fond de l'input lorsqu'il obtient le focus
            this.style.backgroundColor = "white";
        });
        
        // Ajoutez un gestionnaire d'événements pour l'événement "blur"
        input.addEventListener("blur", function() {
            // Réinitialisez la couleur de fond de l'input lorsqu'il perd le focus
            this.style.backgroundColor = "";
        });
    });
  </script>
  
  <script>
    function show(id) {
        // Afficher la pop-up modale
        $('#editModal'+ id).modal('show');
    }
    </script>
 <script>
     function show1() {
        // Afficher la pop-up modale
        $('#edit').modal('show');
    }
    </script>
    <script>
        function show2(id) {
            // Afficher la pop-up modale
            $('#modifier'+ id).modal('show');
        }
        </script>
        <script>
            function show3() {
                // Afficher la pop-up modale
                $('#ajouter').modal('show');
            }
            </script>
@notifyJs
</body>
</html>
