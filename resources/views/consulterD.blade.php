

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
          
           
            <div class="demande"    style=" width:1250px; height:652px;margin-top:100px; margin-left:260px ">
              @php
              $cpt = 1;
             
          @endphp
                <table  id="datatab" class="table" style="">
                    <thead>

                        <tr>
                          <th >Type de demande</th>
                          <th >Numéro de la demande</th>
                          <th >Nom du demandeur</th>
                          <th >Date de soumission</th>
                          <th >Etat actuel</th>
                          
                            
                            
                            
                            
                            
                        </tr>
                       </thead>
                       
                       <tbody>
                          
                         @foreach($demandesPrestations as $demandePrestation)
                           <tr>
                            <td>{{$demandePrestation->intitules_prestations}}</td>
                            <td>{{ $cpt}}</td>
                            @php
                            $cpt++;
                           
                        @endphp
                            <td>{{$demandePrestation->client_nameD}}</td>
                            <td>{{$demandePrestation->created_at}}</td>
                            <td>{{$demandePrestation->etat}}</td>
                        </tr>
                        @endforeach
      
                      
                    </tbody>
                </table>
            </div>
        
        
      </main>
      
  </div>
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
