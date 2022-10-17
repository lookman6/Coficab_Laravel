@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('users.store')}}" method="POST" >
  @csrf
  <div class="form-group" >
    <label for="name">name</label>
    <input type="text" class="form-control" id="name" name="name"  placeholder="Entrez le nom">
  </div>
  <div class="form-group">
    <label for="email">email</label>
    <input value=""  style="padding-bottom:0px;margin-bottom:5px" type="email" class="form-control" id="email" name="email"  placeholder="Entrez l'email">
  </div>
    
  <p style="padding-bottom:0px;margin-bottom:2px">Choisir les roles</p>
  <!-- <div class="form-check"> -->
  <!-- <input class="form-check-input" type="checkbox" name="roles[]" value="rh" id="rh">
  <label class="form-check-label" for="rh">
    rh
  </label> -->
<!-- </div> -->
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="admin" name="roles[]" id="admin" >
  <label class="form-check-label" for="admin">
    admin
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="formateur" name="roles[]" id="formateur" >
  <label class="form-check-label" for="formateur">
    formateur
  </label>
</div>
  <button type="submit" class="btn btn-primary">ajouter</button>
</form>
</div>

@endsection 