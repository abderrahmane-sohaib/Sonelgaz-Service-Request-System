
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sonelgaz</title>
    
    <!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<!-- End fonts -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
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

<link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>


<style>
.auth-page .card .row {
    align-items: stretch;
    overflow: hidden;
}

.auth-page .auth-side-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 100%;
    overflow: hidden;
    background-color: #f7f8fc;
    background-image: url('{{ asset('images/soller.svg') }}');
    background-repeat: no-repeat;
    background-position: 62% center;
    background-size: cover;
}

.auth-page .auth-side-wrapper img {
    display: none;
}
</style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @notifyCss
</head>
<body>
    <x-notify::notify />
    

    
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
    
            <div class="main-wrapper">
                <div class="page-wrapper full-page">
                    <div class="page-content d-flex align-items-center justify-content-center">
            
                        <div class="row w-100 mx-0 auth-page ">
                            <div class="col-md-8 col-xl-6 mx-auto">
                                <div class="card ">
                                    <div class="row animate__animated animate__backInDown">
                                                <div class="col-md-5 pe-md-0 d-flex">
                          <div class="auth-side-wrapper">
                            <img class="full-width" src="{{asset('images/soller.svg')}}"  alt="">
                          </div>
                        </div>
                                                <div class="col-md-7 ps-md-0">
                          <div class="auth-form-wrapper px-4 py-5">
                            <a href="#" class="noble-ui-logo logo-light d-block mb-2"><span style="color: rgb(40, 40, 252)">Sonel</span> <span style="color: rgb(252, 146, 66)">GAZ</span></a>
                            <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                            <form class="forms-sample">
            
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                        
            
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Password')" />
                        
                                    <x-text-input id="password" class="block mt-1 w-full"
                                                    type="password"
                                                    name="password"
                                                    required autocomplete="current-password" />
                        
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
            
                                <div class="block mt-4">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" style="display: none" name="remember">
                                        <span class="ms-2 text-sm text-gray-600">       </span>
                                    </label>
                                </div>
                                
                                <x-primary-button class="btn btn-primary me-2 mb-2 mb-md-0 text-white">
                                    {{ __('Log in') }}
                                </x-primary-button>
                                <a href="{{ route('password') }}" class="d-block mt-3 text-muted">Forget password? </a>
                              <a href="{{ route('register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>
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
    @notifyJs
</body>
</html>
    <!-- Session Status -->
   



