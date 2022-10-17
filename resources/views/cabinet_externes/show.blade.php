@extends('layouts.mainlayout')

@section('content')
<p>
		<a href="{{ route('cabinets.create') }}" title="ajouter une catégorie" >Ajouter un cabinet externe</a>
        <button class="btn btn-primary">créer un formateur</button>
	</p>
<h5>Voir plus d'informatoins</h5>


	<table border="1" >
		<thead>
			<tr>
				<th>nom</th>
				<th>adresse</th>
				<th colspan="2" >options</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $cabinet->nom }}</a></td>
				<td>{{ $cabinet->adresse }}</a></td>
				<td>
					<a href="{{ route('cabinets.edit',$cabinet) }}" title="Modifier les informations du cabinet" >Modifier</a>
				</td>
				<td>
					<form method="POST" action="{{ route('cabinets.destroy', $cabinet) }}" >
						@csrf
						@method("DELETE")
						<input class="btn btn-danger" onClick="return confirm('Etes-vous sûr de vouloir supprimer')" type="submit" value="x Supprimer" >
					</form>
				</td>
			</tr>
		</tbody>
	</table>

@endsection