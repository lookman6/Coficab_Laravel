@extends('layouts.mainlayout')

@section('content')
<div class="container">


<form action="{{route('formateurs.store')}}" method="POST">
  @csrf  
  <div class="form-group">
    <label>selectionnez le type</label>
     <select id="type" required="" name="type" class="form-control">
      <option selected>interne</option>
      <option>externe</option>
    </select>
    </div> 
  <div class="form-group" >
    <label for="nom">Nom</label>
    <input type="text" class="form-control" id="nom" name="nom"  placeholder="Entrez le nom">
  </div>
  <div class="form-group" >
    <label for="prenom">Prénom</label>
    <input type="text" class="form-control" id="prenom" name="prenom"  placeholder="Entrez le prénom">
  </div>

  <div class="form-group" >
    <label for="email">email</label>
    <input type="email" class="form-control" id="email" name="email"  placeholder="Entrez l'email">
  </div>
  <div class="form-group" id="cabinetDiv">
    <label>selectionnez le cabinet</label>
     <select id="cabinet" required="" name="cabinet" class="form-control">
      <option selected>cabinet1</option>
      <option>cabinet2</option>
    </select>
    </div>


  <div class="form-group" id="password">
    <label for="password">password</label>
    <input type="password" class="form-control"  name="password" id="pass" >
  </div>
  <button type="submit" class="btn btn-primary">créer</button>
</form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  
         $('#email').ready(function(){
        var selection = $(this).children("option:selected").val();
        if(selection == "externe")
        {
            $('#password').slideUp();
            $('#cabinetDiv').slideDown();
          }
          else{
            $('#password').slideDown();
            $('#cabinetDiv').slideUp();
            $('#pass').required = true;
        }
    })

    $('#type').change(function(){
        var selection = $(this).children("option:selected").val();
        if(selection == "externe")
        {
            $('#password').slideUp();
            $('#cabinetDiv').slideDown();
          }
          else{
            $('#password').slideDown();
            $('#cabinetDiv').slideUp();
            $('#pass').required = true;
        }
    })

    $('#cabinet').ready(function(){

       $.get('{{url('getCabinets')}}',function(data){
        // console.log(data)  
        $("#cabinet").empty()
        $.each(data,function(index,cabinet){
          $("#cabinet").append($('<option>',{
                          value:cabinet.id,
                          text:cabinet.nom}))
          console.log(cabinet)
        })
       })
    })
</script>
@endsection 