@extends('layouts.mainlayout')

@section('content')
<p>
		<a href="{{ route('formateurs.create') }}" title="ajouter une formateur" >Ajoute un formateur</a>
	</p>


	<div class="container">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Voir plus d'informations</h5>

				<table class="table" >
		<thead>
			<tr>
				<th>nom</th>
				<th>prénom</th>
				<th>email</th>
				<th colspan="2" >options</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $formateur->nom }}</a></td>
                <td>{{ $formateur->prenom }}</td>
                <td>{{ $formateur->email }}</td>
				<td>
					<a href="{{ route('formateurs.edit',$formateur) }}" title="Modifier les informateurs de la formateur" >Modifier</a>
				</td>
				<td>
					<form method="POST" action="{{ route('formateurs.destroy', $formateur) }}" >
						@csrf
						@method("DELETE")
						<input class="btn btn-danger" onClick="return confirm('Etes-vous sûr de vouloir supprimer')" type="submit" value="x Supprimer" >
					</form>
				</td>
			</tr>
		</tbody>
	</table>
			</div>
		</div>
	</div>

@endsection