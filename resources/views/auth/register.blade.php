
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

     <!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<!-- End fonts -->

  <!-- core:css -->
  <link rel="stylesheet" href="{{asset('assets/vendors/core/core.css')}}">
  <!-- endinject -->

  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->

  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/fonts/feather-font/css/iconfont.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
  <!-- endinject -->

<!-- Layout styles -->  
  <link rel="stylesheet" href="{{asset('assets/css/demo1/style.css')}}">
<!-- End layout styles -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
<link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>


<style>
  .auth-side-wrapper {
     position: relative; /* Assurez-vous que le conteneur a une position définie */
     width: 100%; /* Assurez-vous que le conteneur a une largeur définie */
     height: 100%; /* Assurez-vous que le conteneur a une hauteur définie */
 }
 
 .full-width {
     width: 100%; /* L'image occupera toute la largeur de son conteneur */
     height: 100%; /* L'image occupera toute la hauteur de son conteneur */
     object-fit: cover; /* Redimensionne l'image tout en préservant ses proportions et en la coupant si nécessaire */
 }
 </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form method="POST" action="{{ route('register') }}">
        @csrf


        <div class="main-wrapper">
            <div class="page-wrapper full-page">
                <div class="page-content d-flex align-items-center justify-content-center" style="height: 680px">
    
                    <div class="row w-100 mx-0 auth-page">
                        <div class="col-md-8 col-xl-6 mx-auto">
                            <div class="card" >
                                <div class="row animate__animated animate__backInDown">
                    <div class="col-md-4 pe-md-0">
                      <div class="auth-side-wrapper">
                        <img class="full-width" src="{{asset('images/soller.svg')}}"  alt="">
                      </div>
                    </div>
                    <div class="col-md-8 ps-md-0">
                      <div class="auth-form-wrapper px-4 py-5">
                        <a href="#" class="noble-ui-logo logo-light d-block mb-2"><span style="color: rgb(40, 40, 252)">Sonel</span> <span style="color: rgb(252, 146, 66)">GAZ</span></a>
                        <h5 class="text-muted fw-normal mb-4">Create a free account.</h5>
                        <form class="forms-sample">
                          <div class="mb-3">
                            <div>
                                <x-input-label for="name" :value="__('nom')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                          </div>
                          <div class="mb-3">
                            <div>
                                <x-input-label for="prenom" :value="__('prénom')" />
                                <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="prenom" />
                                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                    
                          </div>
                          
                          <div class="mb-3">
                            <div>
                                <x-input-label for="NumS" :value="__('numero d\'inscription')" />
                                <x-text-input id="NumS" class="block mt-1 w-full" type="text" name="NumS" :value="old('NumS')" required autofocus autocomplete="NumS" />
                                <x-input-error :messages="$errors->get('NumS')" class="mt-2" />
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />
                    
                                <x-text-input id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />
                    
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                          </div>
                          <div class="mb-3">
                            <div>
                                <x-input-label for="resetP" :value="__('mot de sécurité')" />
                                <x-text-input id="resetP" class="block mt-1 w-full" type="text" name="resetP" :value="old('resetP')" required autofocus autocomplete="resetP" />
                                <x-input-error :messages="$errors->get('resetP')" class="mt-2" />
                            </div>
                          {{-- <div class="mb-3">
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    
                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />
                    
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                    
                          </div> --}}
                         
                          

                          
                          <div>
                            {{-- <a href="../../dashboard.html" class="btn btn-primary text-white me-2 mb-2 mb-md-0">Sign up</a> --}}
                            <x-primary-button class="ms-4">
                                {{ __('Register') }}
                            </x-primary-button>
                          </div>
                          <a href="{{ route('login') }}" class="d-block mt-3 text-muted">Already a user? Sign in</a>
                        </form>
                      </div>
                    </div>
                  </div>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </form>

    <script src="{{asset('assets/vendors/core/core.js')}}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="{{asset('assets/vendors/feather-icons/feather.min.js')}}"></script>
	<script src="{{asset('assets/js/template.js')}}"></script>
	<!-- endinject -->
</body>
</html>
   

