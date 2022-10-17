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
				<th>adresse</th>
				<th colspan="2" >options</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $salle->intitule }}</a></td>
				<td>
					<a href="{{ route('salles.edit',$salle) }}" title="Modifier les informations du cabinet" >Modifier</a>
				</td>
				<td>
					<form method="POST" action="{{ route('salles.destroy', $salle) }}" >
						@csrf
						@method("DELETE")
						<input class="btn btn-danger" onClick="return confirm('Etes-vous sûr de vouloir supprimer')" type="submit" value="x Supprimer" >
					</form>
				</td>
               
			</tr>
		</tbody>
	</table>

@endsection