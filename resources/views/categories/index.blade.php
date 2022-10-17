@extends('layouts.mainlayout')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<p>
	<a href="{{ route('categories.create') }}" title="ajouter une catégorie" ><button type="button" class="btn btn-primary"> Ajouter une catégorie</button></a>
	<a href="{{ route('categories.importer') }}" title="importer la liste" ><button type="button" class="btn btn-primary"> importer la liste</button></a>
</p>
	<div class="container">

	@if (Session::has('warning') || Session::has('success'))
	{{$classe = ""}}
	@if(Session::has('warning') ? $classe = "warning" : $classe = "success")@endif
		<div class="alert alert-{{$classe}}">
			{{Session::get($classe)}}
		</div>
	@endif	
    @isset($categories)


	<div class="card">
		<div class="card-body">
			<h4 class="card-title">Liste des domaines de formation</h4>
	<table class="table" >
		<thead>
			<tr>
				<th>domaines de formation</th>
				<th>options</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($categories as $categorie)
			<tr>
				<td>{{ $categorie->intitule }}</td>
				<td style="display:flex; flex-direction: row; justify-content: center; align-items: center">
					<a style="padding-right:7px" href="{{ route('categories.edit',$categorie) }}" title="Modifier les informations d'une catégorie" ><button type="button" class="btn btn-info btn-sm" title="modifier"><i class="bi bi-pencil-square"></i></button></a>
					<form method="POST" action="{{ route('categories.destroy', $categorie) }}" >
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
                <th>domaines de formation</th>
                <th >options</th>
            </tr>
        </tfoot>
	</table>
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