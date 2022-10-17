@extends('layouts.mainlayout')

@section('content')
<div class="container">
<form action="{{route('users.updateRole',$user->id)}}" method="POST" >
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
    
  <p style="padding-bottom:0px;margin-bottom:2px">réaffecter les roles</p>
  <!-- <div class="form-check">
  <input class="form-check-input" type="checkbox" name="roles[]" value="rh" id="rh">
  <label class="form-check-label" for="rh">
    rh
  </label>
</div> -->
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="admin" name="roles[]" id="admin">
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
  <button type="submit" class="btn btn-primary">modifier  </button>
</form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var valeur = "{{$user->name}}";

        @foreach($roles as $role)
        {
          console.log("{{$role["intitule"]}}");
          $("#"+"{{$role["intitule"]}}").prop("checked",true);
        }
        @endforeach
    })
</script>
@endsection 