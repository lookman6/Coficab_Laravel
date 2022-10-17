@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('salles.update',$salle)}}" method="POST">
  @csrf   
  @method('put')
  <div class="form-group" >
    <label for="intitule">adresse</label>
    <input type="text" value="{{old('intitule',$salle->intitule)}}" class="form-control" id="intitule" name="intitule"  placeholder="Entrez le intitule">
  </div>
  <button type="submit" class="btn btn-primary">modifier</button>
</form>
</div>

@endsection 