@extends('layouts.mainlayout')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<p>
		<a href="{{ route('cabinets.create') }}" title="ajouter un cabinet externe" ><button class="btn btn-primary">Ajouter un cabinet externe</button></a>
	</p>
<h1>La Liste des cabinets externes</h1>

	@if (Session::has('warning') || Session::has('success'))
	{{$classe = ""}}
	@if(Session::has('warning') ? $classe = "warning" : $classe = "success")@endif
		<div class="alert alert-{{$classe}}">
			{{Session::get($classe)}}
		</div>
	@endif	
    @isset($cabinets)
	<table  class="table">
		<thead>
			<tr>
				<th>nom</th>
				<th>adresse</th>
				<th colspan="2" >options</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($cabinets as $cabinet)
			<tr>
				<td>
					<!-- <a href="{{ route('cabinets.show', $cabinet) }}" title="voir plus d'informations" >{{ $cabinet->nom }}</a> -->
					{{$cabinet->nom}}
				</td>
                <td>
					{{ $cabinet->adresse }}
				</td>
				<td>
					<a href="{{ route('cabinets.edit',$cabinet) }}" title="Modifier les informations d'une catégorie" ><i class="bi bi-pencil-square"></i></a>
				</td>
				<td>
					<form method="POST" action="{{ route('cabinets.destroy', $cabinet) }}" >
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
				<th>nom</th>
				<th>adresse</th>
				<th colspan="2">options</th>
            </tr>
        </tfoot>
	</table>
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