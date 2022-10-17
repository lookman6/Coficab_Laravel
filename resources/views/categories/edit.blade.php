@extends('layouts.mainlayout')
@section('content')
<div class="container">
<form action="{{route('categories.update',$category->id)}}" method="POST">
  @csrf
  @method('put')
  <div class="form-group" >
    <label for="intitule">intitulé</label>
    <input type="text" class="form-control" value="{{ old('intitule',$category->intitule) }}" id="intitule" name="intitule"  placeholder="Entrez l'intitulé">
  </div>
  <button type="submit" class="btn btn-primary">modifier</button>
</form>
</div>

@endsection 
