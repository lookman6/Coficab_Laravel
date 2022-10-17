@extends('layouts.mainlayout')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<div class="pagetitle">
	<h1>Liste du personnel</h1>
	<nav>
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{url('index')}}">Accueil</a></li>
		<li class="breadcrumb-item">Personnels</li>
		<li class="breadcrumb-item active">Liste</li>
	  </ol>
	</nav>
  </div>

	<p>
		<a style="margin-right:200px" href="{{ route('personnels.create')}}" title="ajouter un personnel" ><button type="button" class="btn btn-primary"><i class="bi bi-person-plus"></i> nouveau personnel</button></a>

		<a href="{{ route('personnels.importer') }}" title="importer la liste" ><button type="button" class="btn btn-primary"> importer la liste</button></a>
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
			<h4 class="card-title">Liste du personnel</h4>		
	<table class="table" >
		<thead>
			<tr>
				<th scope="col">matricule</th>
				<th scope="col">Nom</th>
				<th scope="col">Prénom</th>
				<th scope="col">fonction</th>
				<th scope="col">departement</th>
				<th scope="col">options</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($personnels as $personnel)
			<tr>
				<td>{{ $personnel->matricule }}</td>
				<td>{{ $personnel->nom }}</td>
				<td>{{$personnel->prenom}}</td>
				<td>{{$personnel->fonction}}</td>
				<td>{{$personnel->departement}}</td>
			<td style="display:flex; flex-direction: row; justify-content: center; align-items: center">
				<form method="POST" action="{{ route('personnels.destroy', $personnel) }}" >
						<!-- CSRF token -->
						@csrf
						<!-- <input type="hidden" name="_method" value="DELETE"> -->
						@method("DELETE")
						<button  type="submit" class="btn btn-danger btn-sm js-sweetalert" title="Delete" data-type="confirm" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="bi bi-trash"></i></button>
						<!-- {{-- <input class="btn btn-danger" onClick="return confirm('Etes-vous sûr de vouloir supprimer')" type="submit" value="x Supprimer" > --}} -->
					</form>
				<a style="padding-right:10px;padding-left:10px" href="{{ route('personnels.show', $personnel) }}" title="voir plus dinformations" ><button type="button" class="btn btn-light btn-sm" title="View"><i class="bi bi-eye"></i></button></a>
				<a href="{{ route('personnels.edit', $personnel) }}" title="Modifier les informations d'un personnel" ><button type="button" class="btn btn-info btn-sm" title="modifier"><i class="bi bi-pencil-square"></i></button></a>

				
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>fonction</th>
                <th>departement</th>
                <th>options</th>
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