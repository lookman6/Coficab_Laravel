@extends('layouts.mainlayout')

@section('content')

<div class="">

	<p>

  		<form action="{{route('personnels.fichierPersonnel')}}" method="POST" enctype="multipart/form-data">
   		 @csrf
         <div class="row">
			<div class="form-group col">
				<input type="file" name="fichier">
			<label>joindre le fichier du personnel</label>
			</div>
			
 			 <button type="submit" style="width:30px" class="btn btn-primary col">soumettre</button>
        </div>
		</form>
	</p>

@endsection