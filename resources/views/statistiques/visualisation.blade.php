
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

@extends('layouts.mainlayout')
@section('content')
<form method="post" action="{{route('statistiques.store')}}">
              @csrf
               <div class="row">
                  <div class="col">
                     <input type="date" class="form-control" name="dateDebut" id="dateDebut" @isset($debut) value="{{$debut}}" @endisset>
                  </div>
                 
                 <div class="col">
                   <input type="date" class="form-control" name="dateFin" id="dateFin"
                   @isset($fin) value="{{$fin}}" @endisset>
                 </div>

                 <div class="col"> 
                    <select id="trier" required name="trier" class="form-control">
                      <option>------ trier par ------</option>
                      <option>par département</option>
                      <option>par catégorie</option>
                    </select>
                  </div>
                 <div class="col" id="triDepartement">
                    <select id="departement" required name="departement" class="form-control">
                    </select>
                  </div>
                  <div class="col" id="triCategorie">
                    <select id="categorie" required name="categorie" class="form-control">
                    </select>
                  </div>
                 <!-- <div class="col">
                   <input type="text" class="form-control" @isset($departement) value="{{$departement}}" @endisset id="departement" name="departement" placeholder="selectionnez le département">
                 </div> -->
                 <div class="col">
                   <input type="submit" class="form-control" id="soumettre" value="valider">
                 </div>
               </div>
</form>
<div id="cartes">
<div class="row">
<div class="col-lg-3 col-6">

<div class="small-box bg-info">
<div class="inner">
<h3 id="DSession"></h3>
<p>Sessions de formation</p>
</div>
<div class="icon">
<i class="bi bi-person-bounding-box"></i>
</div>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-success">
<div class="inner">
<h3 id="DTheme"></h3>
<p>Thèmes de formation</p>
</div>
<div class="icon">
<i class="bi bi-person-bounding-box"></i>
</div>
</div>
</div>
<div class="col-lg-3 col-6">

<div class="small-box bg-warning">
<div class="inner">
<h3 id="DEmploye"></h3>
<p>Employés formés</p>
</div>
<div class="icon">
<i class="bi bi-people"></i>
</div>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-danger">
<div class="inner">
<h3 id="DHeure"></h3>
<p>Heures de formation</p>
</div>
<div class="icon">
<i class="bi bi-clock"></i>
</div>
</div>
</div>

</div>
</div>
<div class="container">
<br>
<br>

<div class="card bg-secondary" style="width:100%" >
    <div class="card-body">
      <h6 class="card-title text-white">Top 5 des thèmes de formation par participants</h6>
      <div  class="col" id="mon-chart"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
<div class="card bg-secondary" style="width:100%">
    <div class="card-body">
      <h6 class="card-title text-white">Top des formateurs par nombre d'heures de formation </h6>
      <div class="col" id="topFormateurs"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
  </div>

<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary" style="width:100%" >
    <div class="card-body">
      <h6 class="card-title text-white">Les formations par participants et par nombre d'heures</h6>
      <div id="mon-chart3" style="width: 100%; height: 350"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
</div>


<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary" style="width:100%" >
    <div class="card-body">
      <h6 class="card-title text-white">Le coût et les participants par département</h6>
      <div id="chartContainer3" style="height: 200px; width: 100%;"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
</div>


<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary" style="width:100%" >
    <div class="card-body">
      <h6 class="card-title text-white">Total des heures de formation département</h6>
      <div  id="chartContainer" style="height: 300px; width: 100%;"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
</div>




<!-- debut -->


<div class="card bg-secondary" style="width:100%" >
    <div class="card-body">
      <h6 class="card-title text-white">Top 5 des thèmes de formation par heures</h6>
      <div id="mon-chart1"  class="col"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
<div class="card bg-secondary" style="width:100%">
    <div class="card-body">
      <h6 class="card-title text-white">Top des formateurs par nombre d'heures de formation </h6>
      <div class="container" style="height: 200px; width: 100%;" id="NHeuresParDept"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
  </div>
</div>

<div class="card bg-secondary" style="width:100%" >
    <div class="card-body">
      <h6 class="card-title text-white">Total des heures de formation par mois</h6>
      <div class="col"  id="chartContainer2" style="height: 300px; width: 100%;"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>

<div class="container">
              <form method="post" action="{{route('statistiques.image')}}">
                @csrf
                <div class="row">
                    <div class="col">
                      <input type="date" class="form-control" name="dateDebut" id="dateDebut" placeholder="date de début">
                    </div>
                  
                  <div class="col">
                    <input type="date" class="form-control" name="dateFin" id="dateFin"
                    @isset($fin) placeholder="{{$fin}}" @endisset>
                  </div>

                  <!-- <div class="col">
                    <select id="departement" required name="type" class="form-control">
                    </select>
                  </div> -->

                  <!-- <div class="col">
                    <input type="text" class="form-control" id="departement" name="departement" placeholder="selectionnez le département">
                  </div> -->
                  <div class="col">
                    <input type="submit" class="form-control" id="soumettre" value="valider">
                  </div>
                </div>
  
  </form>
  </div>



<!-- fin -->

<canvas id="myChart" style="width:100%"></canvas>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script>

function vider()
{
       $("#DSession").text("");
      $("#DTheme").text("");
      $("#DEmploye").text("");
      $("#DHeure").text("");
}
  $('#dateDebut').ready(function(){
          // chargerDepartements();
          // $('#cartes').hide();

          $('#triCategorie').slideUp()
          $('#triDepartement').slideUp()

          $.get('{{url('getDepartement')}}/',function(data){
            $('#departement').empty()
            $('#departement').append($('<option>',{
              value:"-- choisir le département --",
              text: "-- choisir le département --"
            }))
              $.each(data,function(index,departement){
                $('#departement').append($('<option>',{
                                  value: departement.departement,
                                  text: departement.departement
                         }))
              })
            })

            $.get('{{url('getCategorie')}}/',function(data){
            $('#categorie').empty()
            $('#categorie').append($('<option>',{
              value:"-- choisir le domaine de formation --",
              text: "-- choisir le domaine de formation --"
            }))
              $.each(data,function(index,categorie){
                $('#categorie').append($('<option>',{
                                  value: categorie.intitule,
                                  text: categorie.intitule
                         }))
              })
            })

        })  
  
$('#trier').change(function () {
  var valeur = $('#trier').val();

  if( valeur == "par département")
  {
    $('#triCategorie').slideUp();
    $('#triDepartement').slideDown();
    $('#departement').removeAttr('selected').find('option:first').attr('selected', 'selected');
    vider();
  }
  else{
    $('#triDepartement').slideUp();
    $('#triCategorie').slideDown();
    vider();
    $('#categorie').removeAttr('selected').find('option:first').attr('selected', 'selected');
  }
})


  $('#departement').change(function(){
    var departement = $("#departement").val();
    var debut = $('#dateDebut').val();
    var fin = $('#dateFin').val();
  
    $.get('{{url('getStatDepartement')}}/'+debut+'/'+fin+'/'+departement,function(data){
      
      $("#DSession").text(data.sessions);
      $("#DTheme").text(data.themes);
      $("#DEmploye").text(data.employes);
      $("#DHeure").text(data.duree);
    })

  })

  $('#categorie').change(function(){
    var categorie = $("#categorie").val();
    var debut = $('#dateDebut').val();
    var fin = $('#dateFin').val();

    $.get('{{url('getStatCategorie')}}/'+debut+'/'+fin+'/'+categorie,function(data){
      
      $("#DSession").text(data.sessions);
      $("#DTheme").text(data.themes);
      $("#DEmploye").text(data.employes);
      $("#DHeure").text(data.duree);
    })

  })

function fonction2()
{
  var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	
	title:{
		text:" Total des heures de formation par département"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "Nombre heures"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#014D65",
		dataPoints: [
      @foreach ($heuresParDept as $clef => $valeur) 
          { y: {{$valeur['duree']}} , label: "{{$clef}}"},
      @endforeach
			
		]
	}]
});
chart.render()
}

function fonction3() {
  var chart2 = new CanvasJS.Chart("chartContainer2",
    {

      title:{
        text: "Total des heures de formation par mois"
      },
      axisX:{  
      //Try Changing to MMMM
              valueFormatString: "MMM"
      },

      axisY: {
              valueFormatString: "0.0#"
      },
      
      data: [
      {        
        type: "line",
        lineThickness: 1.5,
        dataPoints: [
          @foreach ($nbrHeuresEtCoutParMois["nbreHeuresParMois"] as $clef => $valeur) 
              {x:new Date("{{$annee}}","{{$clef - 1}}"),y:{{$valeur}}},
          @endforeach
        // { x: new Date(2000,0), y: 0.65 },
       
        ]
      }    
      ]
    });
    chart2.render()
}

function debut () {


  var chart3 = new CanvasJS.Chart("chartContainer3",
    {
      title:{
        text: "Le coût et les participants par département"
      
      },   
      axisX: {
				labelAngle: -30
			},
      data: [{        
        type: "column",
        dataPoints: [
            @foreach ($heuresParDept as $clef => $valeur) 
            {  y: {{$valeur['cout']}},label: "{{$clef}}" },
            @endforeach
        ]
      },
      {        
        type: "line",
        dataPoints: [
            @foreach ($heuresParDept as $clef => $valeur) 
              {  y: {{$valeur['participants']
               }} ,label: "{{$clef}}"},
            @endforeach
        ]
      }
        
      ]
    });

chart3.render();

}

// window.onload = function () {

// var chart = new CanvasJS.Chart("chartContainer", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	title:{
// 		text: "Simple Line Chart"
// 	},
// 	data: [{        
// 		type: "line",
//       	indexLabelFontSize: 16,
// 		dataPoints: [
// 			{ y: 450 },
// 			{ y: 414},
// 			{ y: 520, indexLabel: "\u2191 highest",markerColor: "red", markerType: "triangle" },
// 			{ y: 460 },
// 			{ y: 450 },
// 			{ y: 500 },
// 			{ y: 480 },
// 			{ y: 480 },
// 			{ y: 410 , indexLabel: "\u2193 lowest",markerColor: "DarkSlateGrey", markerType: "cross" },
// 			{ y: 500 },
// 			{ y: 480 },
// 			{ y: 510 }
// 		]
// 	}]
// });
// chart.render();
// }

// var xyValues = [
//   {x:50, y:7},
//   {x:60, y:8},
//   {x:70, y:8},
//   {x:80, y:9},
//   {x:90, y:9},
//   {x:100, y:9},
//   {x:110, y:10},
//   {x:120, y:11},
//   {x:130, y:14},
//   {x:140, y:14},
//   {x:150, y:15}
// ];

// new Chart("myChart", {
//   type: "scatter",
//   data: {
//     datasets: [{
//       pointRadius: 4,
//       pointBackgroundColor: "rgba(0,0,255,1)",
//       data: xyValues
//     }]
//   },
//   // options:{...}
// });



  google.charts.load('current', {'packages':['corechart']});
  google.charts.load('current', {'packages':['bar']});
  var dateDebut = document.getElementById('dateDebut');
  var dateFin = document.getElementById('dateFin');
  var departement = document.getElementById('departement');

 

  // if(dateDebut.value == "" && dateFin.value !== "" && departement.value !== "")
  // {
     google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawStuff);
    google.charts.setOnLoadCallback(drawChart4);
    google.charts.setOnLoadCallback(drawChartTopFormateurs);
    google.charts.setOnLoadCallback(drawChartHeuresParDepartement);
    debut();
    fonction3();
    fonction2();
  // }


  function drawChartTopFormateurs() {
      var data = google.visualization.arrayToDataTable([
        ['Year', 'nbre.Heures' ],
            @foreach ($formateeurs as $clef => $valeur) 
                [ "{{ $clef }}", {{ $valeur}} ], 
            @endforeach
      ]);

      var options = {
      title: 'Top des formateurs par nombre d\'heures de formation', // Le titre
      is3D : true // En 3D
    };
    
      var chart = new google.visualization.BarChart(document.getElementById('topFormateurs'));

     chart.draw(data, options);
    }

    function drawChartHeuresParDepartement() {
      var data = google.visualization.arrayToDataTable([
        ['Year', 'nbre.Heures' ],
            @foreach ($heuresParDept as $clef => $valeur) 
                [ "{{ $clef }}", {{ $valeur["duree"]}} ], 
            @endforeach
      ]);

      var options = {
      title: 'Top des départements par nombre d\'heures de formation', // Le titre
      is3D : true // En 3D
    };
    
      var chart = new google.visualization.BarChart(document.getElementById('NHeuresParDept'));

     chart.draw(data, options);
    }

  function drawChart(){    
    var data = google.visualization.arrayToDataTable([
      ['Formations', 'participants'],
      @foreach ($participants as $clef => $valeur) 
      [ "{{ $clef }}", {{ $valeur}} ], 
      @endforeach
    ]);
    
    var options = {
      title: 'Top 5 des thèmes de formation par participants', // Le titre
      is3D : true // En 3D
    };

    // On crée le chart en indiquant l'élément où le placer "#mon-chart"
    var chart = new google.visualization.PieChart(document.getElementById('mon-chart'));

    // On désine le chart avec les )fgcv et les options
    chart.draw(data, options);
  }
  function drawChart1(){
    var data = google.visualization.arrayToDataTable([
      ['Formations', 'heures'],
      @foreach ($heures as $clef => $valeur) // On parcourt les catégories
      [ "{{ $clef }}", {{ $valeur}} ], // Proportion des produits de la catégorie
      @endforeach
    ]);
    
    var options = {
      title: 'Top 5 des thèmes de formation par heures', // Le titre
      is3D : true // En 3D
    };

    // On crée le chart en indiquant l'élément où le placer "#mon-chart"
    var chart = new google.visualization.PieChart(document.getElementById('mon-chart1'));

    // On désine le chart avec les )fgcv et les options
    chart.draw(data, options);
  }

 function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['théme de formation', 'NB.participants', 'NB.heures'],
          @foreach ($formations as $clef => $valeur) // On parcourt les catégories
          [ "{{ $clef }}", {{ $valeur["nbreParticipants"]}}, {{ $valeur["nbreHeures"]}} ], // Proportion des produits de la catégorie
      @endforeach
        ]);

        var options = {
          chart: {
            width:800,
            title: 'Les formations par participants et par nombre d\'heures'
           
          },
          bars: 'horizontal', // Required for Material Bar Charts.
          series: {
            0: { axis: 'participants' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'heures' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            x: {
              distance: {label: 'parsecs'}, // Bottom x-axis.
              brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
            }
          }
        }

      var chart = new google.charts.Bar(document.getElementById('mon-chart3'));
      chart.draw(data, options);
    }


   
    function drawChart4() {
      var data = google.visualization.arrayToDataTable([
        ['formateurs', 'NB.Heures'],
          @foreach ($formateeurs as $clef => $valeur) // On parcourt les catégories
          [ "{{ $clef }}", {{ $valeur}} ],
          @endforeach
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("formateur"));
      chart.draw(data, options);
  };


</script>

@endsection 