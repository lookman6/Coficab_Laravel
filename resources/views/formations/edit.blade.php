@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('formations.update',$formation)}}" method="POST">
  @csrf   
  @method('put')
  <div class="form-group" >
    <label for="theme">thème</label>
    <input type="text" class="form-control" id="theme" name="theme" value="{{ old('theme',$formation->theme) }} " placeholder="Entrez le thème">
  </div>

  <div class="form-group">
      <label>selectionnez la catégorie (domaine)</label>
      <select id="categorie" required="" name="categorie" class="form-control">
    @isset($categories)
    @foreach ($categories as $categorie )
    <option >{{$categorie->intitule}}</option>
        
    @endforeach
    </select>
   </div>
   @endisset

  <button type="submit" class="btn btn-primary">modifier</button>
</form>
</div>

@endsection 