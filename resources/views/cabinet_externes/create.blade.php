@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('cabinets.store')}}" method="POST">
  @csrf   
  <div class="form-group" >
    <label for="nom">Nom</label>
    <input type="text" class="form-control" id="nom" name="nom"  placeholder="Entrez le nom">
  </div>
  <div class="form-group" >
    <label for="adresse">adresse</label>
    <input type="text" class="form-control" id="adresse" name="adresse"  placeholder="Entrez l'adresse">
  </div>

  <button type="submit" class="btn btn-primary">créer</button>
</form>
</div>

@endsection 