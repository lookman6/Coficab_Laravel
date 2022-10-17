@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('personnels.store')}}" method="POST">
  @csrf   

  <div class="form-group" >
    <label for="matricule">Matricule</label>
    <input type="text" class="form-control" id="matricule" name="matricule"  placeholder="Entrez le matricule">
  </div>
  <div class="form-group" >
    <label for="fonction">Fonction</label>
    <input type="text" class="form-control" id="fonction" name="fonction"  placeholder="Technicien">
  </div>
  
  <div class="form-group" >
    <label for="nom">Nom</label>
    <input type="text" class="form-control" id="nom" name="nom"  placeholder="Entrez le nom">
  </div>
  <div class="form-group">
    <label for="prenom">Prenom  </label>
    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez le prenom">
  </div>

  <div class="form-group">
  <label>selectionnez le département</label>
   <select id="departement" required="" name="departement" class="form-control">
    <option >departement1</option>
    <option>departement2</option>
    <option>departement3</option>
  </select>
  </div>
  <!-- <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div> -->
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

@endsection 