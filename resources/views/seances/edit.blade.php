@extends('layouts.mainlayout')

  @section('content' )
  <div class="container " style="background-color:rgb(255,255,255)">
  <form action="{{route('seances.update',$seance)}}" method="POST" >
    @method('put')
    @csrf
  


  <div class="form-group">
  <label>Choisir le type</label>
   <select id="type" required name="type" class="form-control">
    <option>interne</option>
    <option selected>externe</option>
  </select>
  </div>


  <div class="row">
  <div class="form-group col" id="divCabinet">
    <label>selectionnez le cabinet</label>
     <select id="cabinet"  name="cabinet" class="form-control">
     </select>
  </div>
  
  <div class="form-group col" id="divFormateur">
    <label>selectionnez le formateur</label>
     <select id="formateur"  name="formateur" class="form-control">
      <option value=""></option>
     </select>
    </div>
</div>

  <div class="row">
    <div class="form-group col">
    <label>selectionnez le domaine</label>
    <select id="categorie" required name="categorie" class="form-control">
      <option value=""></option>
    </select>
    </div>


    <div class="form-group col">
    <label>selectionnez le thème</label>
    <select id="theme" required name="theme" class="form-control">
    </select>
    </div>
</div>

  <div class="form-group" id="divFormateurInterne">
    <label>Choisir le formateur</label>
     <select id="formateurInterne" name="formateurInterne" class="form-control">
     </select>
  </div>


  <div class="row">
  <div class="form-group col" >
    <label for="dateDebut">date de début</label>
    <input type="date" id="dateDebut" class="form-control" value="{{$seance->dateDebut}}" name="dateDebut"  placeholder="Entrez la date de début">
  </div>

  <div class="form-group col" >
    <label for="dateFin">date de fin</label>
    <input type="date" id="dateFin" class="form-control"  value="{{$seance->dateFin}}" name="dateFin"  placeholder="Entrez la date de fin">
  </div>
  <div class="form-group col-sm-2" >
    <label for="duree">Durée</label>
    <input type="number" id="duree" class="form-control" value="{{$seance->duree}}" name="duree"  placeholder="durée formation">
  </div>
</div>

  


  <div class="row">
    <div class="form-group col" hidden>
    <label>Choisissez le groupe</label>
    <!-- Récupérer de la base de données pour l'instant ce sera en dur -->
    <select id="groupe" required="" name="groupe" class="form-control"></select>
    </div>

    <div class="form-group col">
    <label>Sélectionnez le lieu de formation</label>
    <!-- Récupérer de la base de données pour l'instant ce sera en dur -->
    <select id="salle" required="" name="salle" class="form-control"></select>
    </div>
    <div class="form-group col-sm-2" id="divCout">
    <label for="cout">coût</label>
    <input type="number" id="cout" class="form-control"  name="cout" value="{{$seance->cout}}"  placeholder="Entrez le coût de la formation">
  </div>
</div>

  

  <button type="submit" class="btn btn-primary">modifier</button>
</form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


<script>



  // synchroniser les thèmes de formation
  // Lorsque la catégorie change
  $('#categorie').change(function(e){
      //On récupère sa valeur
      var categorie = e.target.value;

      if(categorie != ""){
            console.log('{{ url('testss') }}/'+ categorie );
          $.get('{{ url('testss') }}/'+ categorie ,function(data){
              $('#theme').empty();
              $.each(data, function(index,formation){
                            $('#theme').append($('<option>',{
                                  value: formation.id,
                                  text: formation.theme
                         }));
              });
          });
          $('#theme option[value="{{$seance->formation_id}}"]').prop('selected', true);
      }
    
  });



  //Charger les formateurs
  $('#cabinet').change(function(e){
      //On récupère sa valeur
      var cabinet = e.target.value;

      if(cabinet != ""){
            console.log('{{ url('formateur') }}/'+ cabinet );
          $.get('{{ url('formateur') }}/'+ cabinet ,function(data){
              $('#formateur').empty();
              $.each(data, function(index,formateur){
                            $('#formateur').append($('<option>',{
                                  value: formateur.id,
                                  text: formateur.nom+" "+formateur.prenom
                         }));
              });
          });
      }
    
  });


  $('#type').change(function(){
      var selection = $(this).children("option:selected").val();
      if(selection == "externe")
      {
          $('#divCabinet').slideDown();
          $('#divCout').slideDown();
          $('#divFormateurInterne').slideUp();
          $('#divFormateur').slideDown();
          $('#pass').required = false;
      }
      else{
          $('#divCabinet').slideUp();
          $('#divCout').slideUp();
          $('#divFormateurInterne').slideDown();
          chargerFormateursInternes();
          $('#divFormateur').slideUp();
          $('#pass').required = true;
      }
  })

  function getGroupes()
  {
    $.get('{{url('getGroupes')}}',function(data){
      $('#groupe').empty();
      $.each(data,function(index,groupe){
            $('#groupe').append($('<option>',{
                value: groupe.id,
                text:groupe.intitule
            }));
      });
    });
  }

  function getSalles()
  { 
      $.get('{{url('getSalles')}}',function(data){
        $.each(data,function(index,salle){

            $('#salle').append($('<option>',{
                value:salle.id,
                text:salle.intitule
            }));
        });
      });
  }
  
  function chargerFormateursInternes()
  {
    $.get('{{url('formateursInternes')}}',function(data){
      $('#formateurInterne').empty();
      $.each(data,function(index,formateurInterne){
        if(formateurInterne != null)
        {$('#formateurInterne').append($('<option>',
          {value:formateurInterne.id,
          text:formateurInterne.prenom}))}
      });
    });
  }

  $('#type').ready(function(){
    chargerFormateursInternes();
    getGroupes();
    getSalles();
    $('#divFormateurInterne').slideUp();
    $.get('{{url('categorie')}}/',function(data){
        // $('#categorie').empty()
        $.each(data,function(index,categorie){
          $('#categorie').append($('<option>',{
            value:categorie.intitule,
            text:categorie.intitule
          }))
        })
      })
      $('#cabinet option[value="{{$seance->categorie_id}}"]').prop('selected', true);
  })  


  $('#cabinet').ready(function(){
      $.get('{{url('cabinet')}}/',function(data){
        $('#cabinet').empty()
        $('#cabinet').append($('<option>'),{
          value:"",
          text:""
        });
        $.each(data,function(index,categorie){
          $('#cabinet').append($('<option>',{
            value:categorie.id,
            text:categorie.nom
          }))
        })
      })
      
    //   alert("{{$seance->cabinet_id}}")
    //   $('#cabinet option:eq("cabinet4")')
    var valuer = $('#cabinet').val("{{$seance->cabinet_id}}");
      $('#cabinet option:eq(2)').prop('selected', true);
  }) 

</script>

@endsection 