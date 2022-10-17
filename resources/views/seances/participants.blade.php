@extends('layouts.mainlayout')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<div class="pagetitle">

	<h1>Liste des participants</h1>
	<nav>
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{url('index')}}">Accueil</a></li>
		<li class="breadcrumb-item">Formations en cours</li>
		<li class="breadcrumb-item active">Liste</li>
	  </ol>
	</nav>
  </div>

  <table class=   "table table-user-information">
	<tbody>
	  <tr>
		<td>Date de début</td>
		<td>{{$seance->dateDebut}}</td>
	  </tr>
	  <tr>
		<td>Date de fin</td>
		<td>{{$seance->dateFin}}</td>
	  </tr>

	   <tr>
		<td>Thème</td>
		<td>{{$seance->formation->theme}}</td>
	  </tr>
	  <tr>
		<td>Formateur</td>
		<td>{{$seance->formateur->nom}} {{$seance->formateur->prenom}}</td>
	  </tr>
   </tbody>
  </table> 

	<p>
	<input id="searchbar" class="form-control form-control-lg form-control-borderless" onkeyup="search_personnel()" type="text" name="search" placeholder="saisir le matricule du personnel pour l'ajouter à la formation">
	<ol id='listePersonnel' hidden>
	</ol>
</p>

	@if (Session::has('warning') || Session::has('success'))
	{{$classe = ""}}
	@if(Session::has('warning') ? $classe = "warning" : $classe = "success")@endif
		<div class="alert alert-{{$classe}}">
			{{Session::get($classe)}}
		</div>
	@endif	

	<div class="container ">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">Liste des participants</h4>		
            @isset($participants)
	<table class="table" >
		<thead>
			<tr>
                <th scope="col">matricule</th>
				<th scope="col">Nom</th>
				<th scope="col">Prénom</th>
				<th scope="col">options</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($participants as $participant)
			<tr>
				<td><a href="{{route('personnels.show',$participant->id)}}">{{$participant->matricule}}</a></td>
				<td>{{ $participant->nom }}</td>
				<td>{{ $participant->prenom }}</td>
				<td>
					<button id="retirer" onclick="retirerDesParticipants()" value={{$participant->id}} class="btn btn-danger btn-sm js-sweetalert" title="Delete" data-type="confirm" ><i class="bi bi-trash"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
            <tr>
                <th scope="col">matricule</th>
				<th scope="col">Nom</th>
				<th scope="col">Prénom</th>
				<th scope="col">options</th>
            </tr>
        </tfoot>
	</table>
    @endisset
	</div>
	</div>
	</div>


<script>
	
	function retirerDesParticipants()
	{
		var seance = "{{$seance->id}}"
		var participant = $("#retirer").val()

		if(confirm("Etes-vous sûr de vouloir retirer ce personnel de la liste des participants?"))
		{
			$.get('{{url('retirerDesParticipants')}}/'+seance+'/'+participant,function(data){
				alert(data);
				$.ajax({
					url: "",
					context: document.body,
					success: function(s,x){
						$(this).html(s);
					}
				});
			})
		}
	}
	$('#listePersonnel').ready(function(){
	var debut = {{$seance->dateDebut}};
    var fin = {{$seance->dateFin}};
  
    $.get('{{url('getPersonnel')}}/',function(data){
        $('#listePersonnel').empty()
        
              $.each(data,function(index,personnel){
                $('#listePersonnel').append($('<li>',{
                                  value: personnel.matricule,
                                  text:  personnel.matricule+" "+personnel.nom+" "+personnel.prenom
                         }))
              })
    
    })

  })


  function search_personnel() {
    let input = document.getElementById('searchbar').value
    input = input.toLowerCase();
    let a = document.getElementById('id');
    let x = document.getElementsByTagName('li');
      
    for (i = 0; i < x.length; i++) { 
        // if (x[i].innerHTML.toLowerCase().includes(input)) {
        //    console.log(x[i].innerHTML.toLowerCase()  input) ;
        // }
		// $.get('{{url('getStatDepartement')}}/'+debut+'/'+fin+'/'+departement,function(data)

        if (x[i].innerHTML.toLowerCase().split(" ")[0] == input) {
			var matricule = x[i].innerHTML.toLowerCase().split(" ")[0]
            var nom = x[i].innerHTML;
			var seance = "{{$seance->id}}"
           if(confirm("ajouter "+ nom+" ?"))
		   {
				$.get('{{url('ajouterParticipant')}}/'+seance+'/'+matricule,function(data){
					alert(data);
					$.ajax({
					url: "",
					context: document.body,
					success: function(s,x){
						$(this).html(s);
					}
				});
	    	})
		   }
		  
        }
	} 
    
}

	var $table = $('table');

// Setup - add a text input to each footer cell
$table.find('tfoot th').filter(':eq(1),:eq(2)').css('visibility', 'visible').each(function() {
  var title = $(this).text();
  $(this).html('<input type="text" placeholder="Search ' + title + '" />');
});

// DataTable
var table = $table.DataTable({
  lengthChange: false
});

// Apply the search
table.columns().every(function() {
  var col = this;
  $('input', this.footer()).on('keyup change', function() {
    if (col.search() !== this.value)
      col.search(this.value).draw();
  });
});

// _source: function(request, response) {
//       var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
//       response(this.element.children("option").map(function() {
//         // get text of the option
//         var text = $(this).text();
//         // get value of the option
//         var value = $(this).val();
//         // check is value is set and pass value to matcher.test() method
//         if (this.value && (!request.term || matcher.test(value)))
//           return {
//             label: text,
//             value: text,
//             option: this
//           };
//       }));
//     }

	

</script>

@endsection