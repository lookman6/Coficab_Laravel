@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('categories.store')}}" method="POST">
  @csrf   
  <div class="form-group" >
    <label for="intitule">intitulé</label>
    <input type="text" class="form-control" id="intitule" name="intitule"  placeholder="Entrez l'intitulé">
  </div>

  <button type="submit" class="btn btn-primary">créer</button>
</form>
</div>

@endsection 