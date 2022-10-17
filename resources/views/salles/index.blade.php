@extends('layouts.mainlayout')

@section('content')
<p>
		<a href="{{ route('salles.create') }}" title="ajouter un salle externe" ><button class="btn btn-primary">Nouveau lieu de formations</button></a>
	</p>
<h1>La Liste des lieux de formation </h1>

	@if (Session::has('warning') || Session::has('success'))
	{{$classe = ""}}
	@if(Session::has('warning') ? $classe = "warning" : $classe = "success")@endif
		<div class="alert alert-{{$classe}}">
			{{Session::get($classe)}}
		</div>
	@endif	
    @isset($salles)
	<table  class="table">
		<thead>
			<tr>
				<th>adresse</th>
				<th colspan="2" >options</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($salles as $salle)
			<tr>
                <td>
					{{ $salle->intitule }}
				</td>
                
				<td>
					<a href="{{ route('salles.edit',$salle) }}" title="Modifier les informations de la salle" ><i class="bi bi-pencil-square"></i></a>
				</td>
				<td>
					<form method="POST" action="{{ route('salles.destroy', $salle) }}" >
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
	</table>
    @endisset

@endsection