
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
  

  {{-- table de oeps --}}

  <div class="op" id="toep"   style=" width:1250px; height:652px;margin-top:100px; margin-left:260px ">
    <table  id="oep" class="table" style="">
        <thead>
            <tr>
              <th >#</th>
              <th >Nom Client</th>
              <th >Intitulé Prestation</th>
              <th >Tel</th>
              <th >Type client</th>
              <th >N oep</th>
              <th>Etat</th>
                
                <th >
                  <button style="padding-left: 50px ;width:20px;height:20px">
                    
                    <i data-feather="settings"></i>
                  </button>
                </th>
                
                
                
            </tr>
           </thead>
        
           @php
    $cpt = -3;
@endphp
           <tbody>
            @foreach ($demandesPrestations as $demandePrestation)
    @php
        $cpt++;
    @endphp

    @if ($demandePrestation->type_demande === 'oep')
        <tr>
            <td>{{ $cpt }}</td> <!-- ID de la demande -->
            <td>{{ $demandePrestation->client_nameD }}</td> <!-- Nom du client -->
            <td>{{ $demandePrestation->intitules_prestations }}</td> <!-- Intitulés des prestations -->
            <!-- Autres colonnes de la demande de prestation -->
            <td>{{ $demandePrestation->client_tel }}</td>
            <td>{{ $demandePrestation->client_type }}</td>
            
            @if($demandePrestation->etat == 'oep_etabli')
             <td>{{$demandePrestation->num_oep}}</td>
                             
                    @else
                        <td>&nbsp;</td>
                    @endif
                  <td>{{ $demandePrestation->etat }}</td>
                
               

                    <td>
                      <div class="d-flex align-items-center">
                        @if($demandePrestation->etat === 'oep_etabli')

                       <a class="change-color-on-hover" target="_blank" href="{{route('testOP',['opId' => $demandePrestation->id])}}">
                  <button type="button" class="btn btn-primary btn-icon  " style="background-color:#6571ff; margin-right:10px;width:15px;height:15px;">
                      <i data-feather="printer"></i>
                  </button>
              </a>

                    {{-- <form method="POST" action="{{ route('typeF.change',['FId' => $demandePrestation->id]) }}"> --}}
                    <form method="POST" action="{{ route('typeO.change',['OId' => $demandePrestation->id]) }}">
                      @csrf
                      <button type="submit" class="btn btn-primary btn-icon" style="background-color:#6571ff; margin-right:10px;width:15px;height:15px">
                          <i data-feather="check"></i>
                      </button>
                      </form>
                      @endif

                      @if($demandePrestation->etat === 'demande_exécutée')
                      
                      @endif
                    </div>
                    </td>
                  </div>
                  
            </tr>


            @endif
            
            @endforeach
        </tbody>
    </table>
</div>

  {{--/ table de oeps --}}


            </main>
        </div>
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
  function updatePrestations(id) {
    const selectedChapter = document.getElementById('select1_' + id).value;
    const prestationsSelect = document.getElementById('select2_' + id);
    const url = `{{ route('getPrestations') }}?chapitre=${selectedChapter}`;
  
    fetch(url)
      .then(response => response.json())
      .then(data => {
        prestationsSelect.innerHTML = ''; // Clear existing options
  
        data.forEach(prestation => {
          const option = document.createElement('option');
          option.value = prestation.nom_pres;
          option.text = prestation.nom_pres;
          prestationsSelect.appendChild(option);
        });
      })
      .catch(error => console.error('Error fetching prestations:', error));
}
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
<script>
  function deletePrestation(demandeId, prestationName,$prestationprice) {
      if (confirm("Are you sure you want to delete this prestation?")) {
          // Make an AJAX request to delete the prestation
          $.ajax({
              url: '/dashboard/ingenieur/deleteprestation', // Change the URL to your Laravel route for deleting prestation
              type: 'POST',
              data: {
                  demande_id: demandeId,
                  prestation_name: prestationName,
                  
                  _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                  // If deletion is successful, you can handle the response accordingly
                  console.log(response);
                  // Reload the page or update the UI as needed
                  location.reload();
              },
              error: function(xhr, status, error) {
                  // If there is an error, handle it here
                  console.error(xhr.responseText);
              }
          });
      }
  }
</script>

<script>
 function calculateTotalPrice(element) {
    const id = element.dataset.id;
    const selectedPrestation = document.getElementById('select2_' + id).value;
    const quantity = document.getElementById('nombre_' + id).value;
    
    // Ensure that selectedPrestation and quantity are not empty
    if (!selectedPrestation || !quantity) {
        console.error('Selected prestation or quantity is empty');
        return;
    }
    
    // Construct the fetch URL with selected prestation and quantity
    const url = `/dashboard/ingenieur/getPrice?prestation=${selectedPrestation}&quantity=${quantity}`;

    // Fetch the total price from the server
    fetch(url)
        .then(response => response.json())
        .then(data => {
            // Update the input field with the total price
            document.getElementById('prix_' + id).value = data.totalPrice;
        })
        .catch(error => console.error('Error fetching prix:', error));
}

// Écouter les événements de changement sur les champs de prestation sélectionnée et de quantité
document.addEventListener("DOMContentLoaded", function() {
    @foreach ($demandesPrestations as $demandePrestation)
        document.getElementById('select2_{{ $demandePrestation->id }}').addEventListener('change', function() {
            calculateTotalPrice(this);
        });
        document.getElementById('nombre_{{ $demandePrestation->id }}').addEventListener('input', function() {
            calculateTotalPrice(this);
        });
    @endforeach
});

</script>

<script>
  function show() {
      // Afficher la pop-up modale
      $('#editModal').modal('show');
  }
  </script>
  <script>
   function show1(id) {
  // Show the modal using the provided ID
  $('#editModal1' + id).modal('show');
}
  </script>
   <script>
    function show2(id) {
        // Afficher la pop-up modale
        $('#editModal2' + id).modal('show');
    }
    </script>
    <script>
      function toWorld(id) {
          // Afficher la pop-up modale
          $('#editer' + id).modal('show');
      }
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
