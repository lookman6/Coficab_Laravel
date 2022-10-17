    @extends('layouts.mainlayout')

    @section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <div class="pagetitle">
        <h1>Liste des seances en cours</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('index')}}">Accueil</a></li>
            <li class="breadcrumb-item">Formations en cours</li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
        </nav>
    </div>

        <p>
            <a href="{{ route('tests.index') }}" title="ajouter un seance" ><button type="button" class="btn btn-primary">planifier une séance</button></a>
            <!-- <input hidden id="searchbar" onkeyup="search_personnel()" type="text" name="search" placeholder="search personnel ..."> -->
            <ol id='listePersonnel' hidden>
            </ol>
        </p>

        @if (Session::has('warning') || Session::has('success'))
        {{$classe = ""}}
        @if(Session::has('warning') ? $classe = "warning" : $classe = "success")@endif
            <div class="alert alert-{{$classe}}">
                {{Session::get($classe)}}
            </div>
        @endif	

        <div class="container ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Les formations en cours</h4>		
        <table class="table" >
            <thead>
                <tr>
                    <th scope="col">thème de formation</th>
                    <th scope="col">date de début</th>
                    <th scope="col">date de fin</th>
                    <th scope="col">duree</th>
                    <th scope="col">options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seances as $seance)
                <tr>
                    <td>{{$seance->formation->theme}}</td>
                    <td>{{ $seance->dateDebut }}</td>
                    <td>{{ $seance->dateFin }}</td>
                    <td>{{$seance->duree}}</td>
                   <td> <a style="padding-right:10px;padding-left:10px" href="{{ route('seances.participants', $seance) }}" title="voir plus dinformations" ><button type="button" class="btn btn-light btn-sm" title="View"><i class="bi bi-eye"></i></button></a>
                   <a href="{{ route('seances.edit', $seance) }}" title="Modifier les informations d'un personnel" ><button type="button" class="btn btn-info btn-sm" title="modifier"><i class="bi bi-pencil-square"></i></button></a>   
                </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                <th scope="col">thème de formation</th>
                    <th scope="col">date de début</th>
                    <th scope="col">date de fin</th>
                    <th scope="col">duree</th>
                    <th scope="col">options</th>
                </tr>
            </tfoot>
        </table>
        </div>
        </div>
        </div>


    <script>
        var $table = $('table');

    // Setup - add a text input to each footer cell
    $table.find('tfoot th').filter(':eq(1),:eq(2)').css('visibility', 'visible').each(function() {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    // DataTable
    var table = $table.DataTable({
    lengthChange: false
    });

    // Apply the search
    table.columns().every(function() {
    var col = this;
    $('input', this.footer()).on('keyup change', function() {
        if (col.search() !== this.value)
        col.search(this.value).draw();
    });
    });

//     $('#listePersonnel').ready(function(){
//     var departement = $("#departement").val();
//     var debut = $('#dateDebut').val();
//     var fin = $('#dateFin').val();
  
//     $.get('{{url('getPersonnel')}}/',function(data){
//         $('#listePersonnel').empty()
        
//               $.each(data,function(index,personnel){
//                 $('#listePersonnel').append($('<li>',{
//                                   value: personnel.matricule,
//                                   text:  personnel.matricule+" "+personnel.nom+" "+personnel.prenom
//                          }))
//               })
    
//     })

//   })


//   function search_personnel() {
//     let input = document.getElementById('searchbar').value
//     input=input.toLowerCase();
//     let a = document.getElementById('id');
//     let x = document.getElementsByTagName('li');
      
//     for (i = 0; i < x.length; i++) { 
//         // if (x[i].innerHTML.toLowerCase().includes(input)) {
//         //    console.log(x[i].innerHTML.toLowerCase()  input) ;
//         // }

//         if (x[i].innerHTML.toLowerCase().split(" ")[0] == input) {
//             var nom = x[i].innerHTML;
//             confirm("ajouter "+ nom+" ?");
//            console.log(x[i].innerHTML) ;
//         }
       
//     }
// }
    </script>

    @endsection