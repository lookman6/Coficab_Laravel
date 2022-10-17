@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('salles.store')}}" method="POST">
  @csrf   
  <div class="form-group" >
    <label for="intitule">adresse</label>
    <input type="text" class="form-control" id="intitule" name="intitule"  placeholder="Entrez l'adresse">
  </div>

  <button type="submit" class="btn btn-primary">ajouter</button>
</form>
</div>

@endsection 