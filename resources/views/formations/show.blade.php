@extends('layouts.mainlayout')

@section('content')
<p>
		<a href="{{ route('formations.create') }}" title="ajouter une formation" >Ajouter une formation</a>
	</p>


	<div class="container">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Voir plus d'informations</h5>
					<table class="table" >
		<thead>
			<tr>
				<th>theme</th>
				<th>catégorie</th>
				<th colspan="2" >options</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $formation->theme }}</a></td>
                <td>{{ $formation->categorie->intitule }}</td>
				<td>
					<a href="{{ route('formations.edit',$formation) }}" title="Modifier les informations de la formation" >Modifier</a>
				</td>
				<td>
					<form method="POST" action="{{ route('formations.destroy', $formation) }}" >
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