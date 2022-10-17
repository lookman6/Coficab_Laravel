@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('users.updateMesInfos',$user->id)}}" method="POST" >
  @csrf
  @method("PUT")
  <div class="form-group" >
    <label for="name">name</label>
    <input type="text" class="form-control" id="name" name="name"  value="{{$user->name}}" placeholder="Entrez le nom">
  </div>
  <div class="form-group">
    <label for="email">email</label>
    <input value="{{$user->email}}"  style="padding-bottom:0px;margin-bottom:5px" type="email" class="form-control" id="email" name="email"  placeholder="Entrez l'email">
  </div>
  <div class="form-group" >
    <label for="password">mot de passe</label>
    <input type="password" class="form-control" id="password" name="password"  placeholder="mot de passe">
  </div>  

  <button type="submit" class="btn btn-primary">modifier  </button>
</form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

@endsection 