@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('formateurs.update',$formateur)}}" method="POST">
  @csrf   
  @method('put')
  <div class="form-group" >
    <label for="nom">Nom</label>
    <input type="text" class="form-control" value="{{old('nom',$formateur->nom)}}" id="nom" name="nom"  placeholder="Entrez le nom">
  </div>
  <div class="form-group" >
    <label for="prenom" >Prénom</label>
    <input type="text" value="{{old('prenom',$formateur->prenom)}}" class="form-control" id="prenom" name="prenom"  placeholder="Entrez le prénom">
  </div>
  <div class="form-group" >
    <label for="email">email</label>
    <input type="email" class="form-control" value="{{old('email',$formateur->email)}}" id="email" name="email"  placeholder="Entrez l'email">
  </div>

  <button type="submit" class="btn btn-primary">créer</button>
</form>
</div>

@endsection 