@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('cabinets.update',$cabinet)}}" method="POST">
  @csrf   
  @method('put')
  <div class="form-group" >
    <label for="nom">Nom</label>
    <input type="text" value="{{old('nom',$cabinet->nom)}}" class="form-control" id="nom" name="nom"  placeholder="Entrez le nom">
  </div>
  <div class="form-group" >
    <label for="adresse">adresse</label>
    <input type="text" value="{{old('adresse',$cabinet->adresse)}}" class="form-control" id="adresse" name="adresse"  placeholder="Entrez l'adresse">
  </div>

  <button type="submit" class="btn btn-primary">modifier</button>
</form>
</div>

@endsection 