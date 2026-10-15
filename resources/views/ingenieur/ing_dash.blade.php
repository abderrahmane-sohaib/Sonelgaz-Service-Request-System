
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ingénieure</title>

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

.table-cell {
    border: 1px solid black;
    
    padding: 6px;
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
  
.form-label{
  color: black
}
table.dataTable th,
table.dataTable td {
  border: 1px solid rgb(222, 218, 218);
}
.form-control:focus {
        color: black; /* Changer la couleur du texte en noir */
    }
   
    table {
  border-spacing: 10px; /* Replace 10px with your desired value */
}

.table1 {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .table1 th {
        background-color: #f2f2f2;
        padding: 8px;
        text-align: center;
        border: 1px solid #dddddd;
    }
    .table1 td {
        padding: 8px;
        text-align: center;
        border: 1px solid #dddddd;
    }
    body {
    font-family: Arial, sans-serif;
}

 


div#dataTableExample_filter.dataTables_filter{
  margin-right: 170px;
  margin-top: -100px;
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
        </style>
        @notifyCss
      </head>
    <body class="font-sans antialiased">
      <x-notify::notify />
    
      <div >
  
          <!-- partial:partials/_sidebar.html -->
          <nav class="sidebar" >
            <div class="sidebar-header">
              <a href="#" class="sidebar-brand" >
               <span style="color: gray ;font-size:16px">Prestation de service</span>
              </a>
              <div class="sidebar-toggler not-active" >
                <img src="{{ asset('images/arrow-right-circle.svg') }}" alt="" class="change-color-on-hover flip-image">
              </div>
            </div>
            <div class="sidebar-body" style="background-color:#081c37">
              <ul class="nav">
                <li class="nav-item nav-category">Main</li>
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title" style="color: white">Demande de Prestation</span>
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
                        <a href="{{route('demande_enligne')}}"  class="nav-link" style="color: white">En ligne</a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('demande_sonalgaz')}}" id="create-ing-account-link" class="nav-link" style="color: white">a sonelgaz</a>
                      </li>
                     
                    </ul>
                  </div>
                </li>
                <li class="nav-item">
                  <a href="{{route('contrat_sonalgaz')}}" class="nav-link" id="tabeCN" >
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title" style="color: white">Contrat</span>
                  </a>
                </li>
    
                <li class="nav-item">
                    <a href="{{route('oep_sonalgaz')}}" class="nav-link" id="tableOP">
                      <i class="link-icon" data-feather="clipboard"></i>
                      <span class="link-title" style="color: white">OEP</span>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('rapport_sonalgaz')}}" class="nav-link" id="reporting">
                      <i class="link-icon" data-feather="clipboard"></i>
                      <span class="link-title" style="color: white">Rapport Mensuel</span>
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
              <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                
                </div>
                
            </header>
        @endif


            <!-- Page Content -->
            <main>
              {{-- welcome --}}
              <div class="wel" style="padding-top:220px; ">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="animate__animated animate__fadeInLeftBig p-6 text-gray-900" style="text-align: center ">
                            <span style="font-size: 24px;">{{ __("Bienvenue, monsieur") }} {{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
          {{-- /welcome --}}




            </main>
        </div>
        <!-- core:js -->
	<script src="{{asset ('assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->
<!-- Plugin js for this page -->


<!-- inject:js -->
-- <script src="{{asset ('assets/vendors/feather-icons/feather.min.js')}}"></script>
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
         
    </body>
</html>
