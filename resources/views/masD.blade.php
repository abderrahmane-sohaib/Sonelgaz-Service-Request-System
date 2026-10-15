

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ecpace client</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{'assets/vendors/owl.carousel/owl.carousel.min.css'}}">
        <link rel="stylesheet" href="{{'assets/vendors/owl.carousel/owl.theme.default.min.css'}}">
        <link rel="stylesheet" href="{{'assets/vendors/animate.css/animate.min.css'}}">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
    <!-- End layout styles -->
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        
	
        <style>


        
.flip-image {
  transition: transform 0.5s ease-in-out; /* Set animation duration and easing */
}

.flip-image.flipped {
  transform: scaleX(-1); /* Flips the image horizontally (left) */
}

            /* Styles pour changer la couleur lors du survol */
            .change-color-on-hover:hover {
  filter: brightness(1) saturate(200%) hue-rotate(40deg); /* Adjusted hue for orange */
  font-size: 16px; /* Example font size */
}

  
.form-label{
  color: black
}

.form-control:focus {
        color: black; /* Changer la couleur du texte en noir */
    }
   
  *{
    margin: 0px;
    padding: 0px;
    box-sizing: border-box; 
  }

 


        </style>
        @notifyCss
      </head>
    <body  class="font-sans antialiased">
      <x-notify::notify />
    
      <div>
  
          <!-- partial:partials/_sidebar.html -->
          <nav class="sidebar" style="background-color: rgba(0, 159, 227, 0.4);">
            <div class="sidebar-header">
              <a href="#" class="sidebar-brand" >
               <span style="color: gray ;font-size:16px">Espace Client</span>
              </a>
              <div class="sidebar-toggler not-active" >
                <img src="{{ asset('images/arrow-right-circle.svg') }}" alt="" class="change-color-on-hover flip-image">
              </div>
               </div>
               <div class="sidebar-body"  style="background-color: rgba(0, 159, 227,0.8);">
              <ul class="nav">
                <li class="nav-item nav-category">Main</li>
                <li class="nav-item">
                  <a href="{{route('dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title" style="color: white">Espace Client</span>
                  </a>
                </li>
                <li class="nav-item nav-category">web apps</li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title" style="color: white">Demande</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                      <li class="nav-item">
                        <a href="{{route('nouvelle_D')}}"  class="nav-link"  style="color: white">Nouvelle demande</a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('mas_D')}}" id="create-ing-account-link" class="nav-link" style="color: white">Mettre a jour demande</a>
                      </li>

                      <li class="nav-item">
                        <a href="{{route('annuler_D')}}" id="create-ing-account-link" class="nav-link" style="color: white">Annuler la demande</a>
                      </li>
                     
                    </ul>
                  </div>
                </li>
                <li class="nav-item">
                  <a href="{{route('consulter_D')}}" class="nav-link"  >
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title" style="color: white">Consulter l'état de demande</span>
                  </a>
                </li>
    
               
              </ul>
            </div>
          </nav>
    
          <!-- partial -->
      
          
      
  
      <!-- Custom js for this page -->
    
      <!-- End custom js for this page -->





















      <div  >
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header>
              <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                
                </div>
                
            </header>
        @endif


           
<main>
  <p style="color: red; text-align: center;"><strong>* La demande ne sera pas modifiée si elle est acceptée </strong></p>
<div class="bg-gray-100 rounded shadow d-flex justify-content-center align-items-center">
    <div class="modal-body">
        @php
            $demandeAModifier = null;
            foreach ($demandesPrestations as $demandePrestation) {
                if ($demandePrestation->etat !== 'demande_exécutée' && $demandePrestation->etat !== 'refuser') {
                    $demandeAModifier = $demandePrestation;
                    break;
                }
            }
        @endphp

        @if($demandeAModifier)
        <form id="updateForm" method="post" action="{{ route('demande_mod', ['demandeId' => $demandeAModifier->demande_id]) }}" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="mb-3 row justify-content-center" style="margin-top: 40px">
                <label for="chapitre" class="col-sm-3 col-form-label text-start">Intitule Prestation:</label>
                <div class="col-sm-5">
                    <select id="countries" name="countries[]" multiple class="form-select">
                        @foreach($prestations as $prestation)
                            <option value="{{ $prestation->id }}">{{ $prestation->nom_pres }} - {{ $prestation->prix }} DA</option>
                        @endforeach
                    </select>
                  
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="texte2" class="col-sm-3 col-form-label text-start">Nom Client:</label>
                <div class="col-sm-5">
                    <input type="text" name="nameD" class="form-control bg-gray-100" id="texte2" value="{{ $demandeAModifier->client_nameD }}" required onkeyup="validateName()">
                    <span id="name-Error"></span>
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="texte4" class="col-sm-3 col-form-label text-start">Adresse Client:</label>
                <div class="col-sm-5">
                    <input type="text" name="adrCL" class="form-control bg-gray-100" id="texte4" value="{{ $demandeAModifier->client_adr }}" required>
                    <span id="adr-Error"></span>
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="texte5" class="col-sm-3 col-form-label text-start">Adresse Intervention:</label>
                <div class="col-sm-5">
                    <input type="text" name="adrIN" class="form-control bg-gray-100" id="texte5" value="{{ $demandeAModifier->adr_int }}" required>
                    <span id="adrI-Error"></span>
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="texte6" class="col-sm-3 col-form-label text-start">N°Tel:</label>
                <div class="col-sm-5">
                    <input type="text" name="tel" class="form-control bg-gray-100" id="texte6" value="{{ $demandeAModifier->client_tel }}" required onkeyup="validatePhone()">
                    <span id="phone-Error"></span>
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="texte7" class="col-sm-3 col-form-label text-start">N°Fax:</label>
                <div class="col-sm-5">
                    <input type="text" name="fax" class="form-control bg-gray-100" id="texte7" value="{{ $demandeAModifier->client_fax }}" required onkeyup="validateFax()">
                    <span id="fax-Error"></span>
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="texte8" class="col-sm-3 col-form-label text-start">Email:</label>
                <div class="col-sm-5">
                    <input type="email" name="emailD" class="form-control bg-gray-100" id="texte8" value="{{ $demandeAModifier->client_emailD }}" required onkeyup="validateEmail()">
                    <span id="email-Error"></span>
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="date" class="col-sm-3 col-form-label text-start">Date:</label>
                <div class="col-sm-5">
                    <input type="date" name="date" class="form-control bg-gray-100" id="date" required>
                </div>
            </div>

            <div class="mb-3 row justify-content-center">
                <label for="pdfFile" class="col-sm-3 col-form-label text-start">Upload PDF:</label>
                <div class="col-sm-5">
                    <input type="file" name="pdfFile" class="form-control bg-gray-100" id="pdfFile" accept=".pdf">
                </div>
            </div>

            <div class="d-flex justify-content-end" style="margin-right: 20px; margin-bottom: 20px;">
                @if($demandeAModifier->etat !== 'demande_a_considérée')
                    <button type="submit" onclick="return validate(event)" style="background-color: #6571ff;" class="btn btn-primary" disabled>Modifier</button>
                    
                @else
                    <button type="submit" onclick="return validate(event)" style="background-color: #6571ff;" class="btn btn-primary">Modifier</button>
                    
                @endif
            </div>
        </form>
        @else
        <p style="color: red; text-align: center;"><strong>* Aucune demande à modifier</strong></p>
        @endif
    </div>
</div>
  
</main>
        </div>

        <script>
          let nameError = document.getElementById('name-Error');
          let phoneError = document.getElementById('phone-Error');
          let emailError = document.getElementById('email-Error');
          let adrError = document.getElementById('adr-Error');
          let adrIError = document.getElementById('adrI-Error');
          let faxError = document.getElementById('fax-Error');
          
          function validateName() {
              let userInput = document.getElementById('texte2').value;
              let test1 = /^[A-Za-z]+\s[A-Za-z]+$/;
          
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
              let phoneInput = document.getElementById('texte6').value;
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
              let emailInput = document.getElementById('texte8').value;
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
          
          function validateFax() {
              let faxInput = document.getElementById('texte7').value;
              let reg = /^025[0-9]{6}$/;
          
              if (faxInput.length == 0) {
                  faxError.innerHTML = "Please enter your fax";
                  faxError.style.color = "red";
                  return false;
              }
              if (!faxInput.match(reg)) {
                  faxError.innerHTML = "Please enter a correct number";
                  faxError.style.color = "red";
                  return false;
              }
              window.sessionStorage.setItem("fax", faxInput);
              faxError.innerHTML = "Correct";
              faxError.style.color = "green";
              return true;
          }
          
          function validate(event) {
              if (!validateName() || !validatePhone() || !validateEmail() || !validateFax()) {
                  
                  setTimeout(function () {
                      document.getElementById('Submit-Error').style.display = "none";
                  }, 1000);
                  event.preventDefault();
                  return false;
              }
              return true;
          }
          </script>
        <!-- core:js -->
	<script src="{{asset ('assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->
<!-- Plugin js for this page -->


<script src="{{'assets/vendors/owl.carousel/owl.carousel.min.js'}}"></script>
<script src="{{'assets/js/carousel.js'}}"></script>
<script src="{{'assets/vendors/jquery-mousewheel/jquery.mousewheel.js'}}"></script>

<script src="{{asset ('assets/vendors/feather-icons/feather.min.js')}}"></script>
<script src="{{asset ('assets/js/template.js')}}"></script>
<!-- endinject -->
         
     
         
         <script src="{{asset('assets/vendors/jquery-validation/jquery.validate.min.js')}}"></script>
         <script src="{{asset('assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
         <script src="{{asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
         <script src="{{asset('assets/js/oep.js')}}"></script>
         <script src="{{asset('assets/js/contrat.js')}}"></script>
         <script src="{{asset('assets/js/data.js')}}"></script>
         <script src="{{asset('assets/js/datatable2.js')}}"></script>
         <script src="{{asset('assets/vendors/sweetalert2/sweetalert2.min.js')}}"></script>
         <script src="{{asset('assets/js/sweet-alert.js')}}"></script>
         <script src="{{asset('assets/vendors/prismjs/prism.js')}}"></script> 
          <script src="{{asset('assets/vendors/clipboard/clipboard.min.js')}}"></script>
          
          <script src="{{asset('assets/js/bootstrap-maxlength.js')}}"></script>
          <script src="{{asset('assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
          <script src="{{asset('assets/vendors/inputmask/jquery.inputmask.min.js')}}"></script>
      
          <script src="{{asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.js')}}"></script>
          <script src="{{asset('assets/js/tags-input.js')}}"></script>
          <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
          <script>
           new MultiSelectTag('countries', {
    rounded: true,    // default true
    shadow: true,      // default false
    placeholder: 'Search',  // default Search...
    tagColor: {
        textColor: '#327b2c',
        borderColor: '#92e681',
        bgColor: '#eaffe6',
    },
    onChange: function(values) {
        console.log(values)
    }
})
        </script>
          
          @notifyJs
         
    </body>
</html>
