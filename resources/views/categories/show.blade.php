@extends('layouts.mainlayout')

@section('content')
<p>
		<a href="{{ route('categories.create') }}" title="ajouter une catégorie" >Ajouter une catégorie</a>
	</p>

<div class="container">
	<div class="card">
		<div class="card-body">
	<h4 class="card-title">Voir plus d'informatoins</h4>
		
	<table class="table" >
		<thead>
			<tr>
				<th>intitule</th>
				<th colspan="2" >options</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $category->intitule }}</a></td>
				<td>
					<a href="{{ route('categories.edit',$category) }}" title="Modifier les informations de la catégorie" >Modifier</a>
				</td>
				<td>
					<form method="POST" action="{{ route('categories.destroy', $category) }}" >
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