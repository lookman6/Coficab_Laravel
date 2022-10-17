@extends('layouts.mainlayout')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<div class="pagetitle">
    <h1>Liste des formations cloturées</h1>
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
    </p>

    <p>
        
        <form method="post" action="/export-excel">
        @csrf
        
            <label for="debut">Date de Debut :</label>
            <input type="date" name="dateDebut" id="debut" required>
            
            <label for="fin">Date de Fin :</label>
            <input type="date" name="dateFin" id="fin" required>
            
            <input type="submit" name="Export" value="Exporter">
        
        </form>

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
            <h4 class="card-title">Les formations cloturées</h4>		
    <table class="table" >
        <thead>
            <tr>
                <th scope="col">thème de formation</th>
                <th scope="col">date de début</th>
                <th scope="col">date de fin</th>
                <th scope="col">duree</th>
                <th scope="col">détails</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seances as $seance)
            <tr>
                <td>{{$seance->formation->theme}}</td>
                <td>{{ $seance->dateDebut }}</td>
                <td>{{ $seance->dateFin }}</td>
                <td>{{$seance->duree}}</td>
               <td> <a style="padding-right:10px;padding-left:10px" href="{{ route('seances.participantsClotures', $seance) }}" title="voir plus dinformations" ><button type="button" class="btn btn-light btn-sm" title="View"><i class="bi bi-eye"></i></button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>thème de formation</th>
                <th>date de début</th>
                <th>date de fin</th>
                <th>duree</th>
                <th scope="col">détails</th>
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

</script>

@endsection