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
		<li class="breadcrumb-item">personnel administratif</li>
		<li class="breadcrumb-item active">Liste</li>
	  </ol>
	</nav>
  </div>
  <p>
		<a href="{{ route('users.create') }}" title="ajouter un nouvel utilisateur" ><button type="button" class="btn btn-primary"><i class="bi bi-person-plus"></i> nouvel utilisateur</button></a>
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
			<h4 class="card-title">Liste des utilisateurs</h4>		
	<table class="table">
		<thead>
			<tr>
				<th scope="col">nom</th>
				<th scope="col">email</th>
				<th scope="col">modifier les roles</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
			<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td style="display:flex; flex-direction: row; justify-content: center; align-items: center"><a href="{{ route('users.editRole', $user) }}" title="Modifier les rôles" ><button type="button" class="btn btn-info btn-sm" title="modifier les rôles"><i class="bi bi-pencil-square"></i></button></a>
					<form style="padding-right:10px;padding-left:10px" method="POST" action="{{ route('users.destroy', $user) }}" >
						<!-- CSRF token -->
						@csrf
						<!-- <input type="hidden" name="_method" value="DELETE"> -->
						@method("DELETE")
						<button  type="submit" class="btn btn-danger btn-sm js-sweetalert" title="Delete" data-type="confirm" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="bi bi-trash"></i></button>
						<!-- {{-- <input class="btn btn-danger" onClick="return confirm('Etes-vous sûr de vouloir supprimer')" type="submit" value="x Supprimer" > --}} -->
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
            <tr>
				<th scope="col">nom</th>
				<th scope="col">email</th>
				<th scope="col">modifier les roles</th>
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