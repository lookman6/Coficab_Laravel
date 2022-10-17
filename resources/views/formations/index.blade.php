@extends('layouts.mainlayout')

@section('content') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
   <div class="container">
   <p>
    	<a href="{{ route('formations.create') }}" title="ajouter une formation" ><button class="btn btn-primary">Ajouter une formation</button></a>
		<a href="{{ route('formations.importer') }}" title="importer la liste" ><button type="button" class="btn btn-primary"> importer la liste</button></a>
	</p>

	@if (Session::has('warning') || Session::has('success'))
	{{$classe = ""}}
	@if(Session::has('warning') ? $classe = "warning" : $classe = "success")@endif
		<div class="alert alert-{{$classe}}">
			{{Session::get($classe)}}
		</div>
	@endif	
    @isset($formations)
	
		<div class="container">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Liste des thèmes de formation</h5>
					<table class="table" >
		<thead>
			<tr>
				<th>thème</th>
				<th>catégorie</th>
				<th >options</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($formations as $formation)
			<tr>
				<td>
					{{ $formation->theme }}
				</td>
                <td>{{$formation->categorie->intitule}}</td>
				<td style="display:flex; flex-direction: row; justify-content: center; align-items: center">
					<a style="padding-right:7px" href="{{ route('formations.edit',$formation) }}" title="Modifier les informations d'une formation" ><button type="button" class="btn btn-info btn-sm" title="modifier"><i class="bi bi-pencil-square"></i></button></a>
				
					<form method="POST" action="{{ route('formations.destroy', $formation) }}" >
						<!-- CSRF token -->
						@csrf
						<!-- <input type="hidden" name="_method" value="DELETE"> -->
						@method("DELETE")
						<button type="submit" class="btn btn-danger btn-sm js-sweetalert" title="Delete" data-type="confirm" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="bi bi-trash"></i></button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th>thème</th>
				<th>catégorie</th>
				<th >options</th>
			</tr>
		</tfoot>
	</table>
			</div>
			</div>
		</div>

   </div>
    @endisset
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