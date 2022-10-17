<!--<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PDF</title>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<h1>TEST</h1>

<script>

	google.charts.load('current', {'packages':['corechart']});
  google.charts.load('current', {'packages':['bar']});
  //var dateDebut = document.getElementById('dateDebut');
  //var dateFin = document.getElementById('dateFin');
  //var departement = document.getElementById('departement');

  google.charts.setOnLoadCallback(drawChart);

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


    var mon-chart = document.getElementById('mon-chart');
    // On crée le chart en indiquant l'élément où le placer "#mon-chart"
    var chart = new google.visualization.PieChart(mon-chart);

     // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        mon-chart.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(mon-chart.innerHTML);
      });

    // On désine le chart avec les )fgcv et les options
    chart.draw(data, options);
  }

  </script>-->

<!--<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary" style="width:49%" >
    <div class="card-body">
      <h6 class="card-title text-white">Top 5 des thèmes de formation par participants</h6>-->
      <!--<div  class="col" id="mon-chart"></div>-->
    <!--</div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
</div>-->

<!--<canvas id="myChart" style="width:100%;max-width:700px"></canvas>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 


</body>
</html>-->

<!--***************************************************************-->

<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawStuff);
    google.charts.setOnLoadCallback(drawChart4);
    google.charts.setOnLoadCallback(drawChartTopFormateurs);
    google.charts.setOnLoadCallback(drawChartHeuresParDepartement);

    function drawChart() {

      /*var data = google.visualization.arrayToDataTable([
        ['Element', 'Density', { role: 'style' }],
        ['Copper', 8.94, '#b87333', ],
        ['Silver', 10.49, 'silver'],
        ['Gold', 19.30, 'gold'],
        ['Platinum', 21.45, 'color: #e5e4e2' ]
      ]);*/

      var data = google.visualization.arrayToDataTable([
      ['Formations', 'participants'],
      @foreach ($participants as $clef => $valeur) 
      [ "{{ $clef }}", {{ $valeur}} ], 
      @endforeach
    ]);

      var options = {
        title: "Top 5 des thèmes de formation par participants",
        bar: {groupWidth: '95%'},
        legend: 'none',
      };

      var chart_div = document.getElementById('chart_div');
      var chart = new google.visualization.PieChart(chart_div);
      //var btnSave = document.getElementById('save-pdf');

  /*google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF();
    doc.addImage(chart.getImageURI(), 0, 0);
    doc.save('chart.pdf');
  }, false);*/

      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(chart_div.innerHTML);
      });

      var myc = chart.getImageURI();
      chart.draw(data, options);

  }
  /*function drawChartTopFormateurs() {
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
      var topFormateurs = document.getElementById('topFormateurs');
      var chart = new google.visualization.BarChart(topFormateurs );

      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        topFormateurs.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(topFormateurs.innerHTML);
      });

     chart.draw(data, {
    chartArea: {
      bottom: 24,
      left: 36,
      right: 12,
      top: 48,
      width: '100%',
      height: '100%'
    },
    height: 600,
    title: 'chart title',
    width: 600
  });
    }*/

    /*function drawChartHeuresParDepartement() {
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
       var NHeuresParDept =  document.getElementById('NHeuresParDept')
      var chart = new google.visualization.BarChart( NHeuresParDept);

      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        NHeuresParDept.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(NHeuresParDept.innerHTML);
      });

     chart.draw(data, options);
    }*/

   /* function drawChart1(){
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


    var mon-chart1 = document.getElementById('mon-chart1');
    // On crée le chart en indiquant l'élément où le placer "#mon-chart"
    var chart = new google.visualization.PieChart(mon-chart1);

    // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        mon-chart1.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(mon-chart1.innerHTML);
      });

    // On désine le chart avec les )fgcv et les options
    chart.draw(data, options);
  }*/

 /*function drawStuff() {
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


        var mon-chart3 = document.getElementById('mon-chart3');
      var chart = new google.charts.Bar(mon-chart3);

       // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        mon-chart3.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(mon-chart3.innerHTML);
      });
      chart.draw(data, options);
    }*/


   
   /* function drawChart4() {
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

      var formateur = document.getElementById("formateur");
      var chart = new google.visualization.ColumnChart(formateur);

       // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        formateur.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(formateur.innerHTML);
      });
      chart.draw(data, options);
  }*/
  </script>

<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary m-3" style="width:48%" >
    <div class="card-body">
      <h6 class="card-title text-white">Top 5 des thèmes de formation par participants</h6>
<div id='chart_div'></div>
</div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>

</div>


<!--<div class="card bg-secondary m-3" style="width:48%">
    <div class="card-body">
      <h6 class="card-title text-white">Top des formateurs par nombre d'heures de formation </h6>
      <div class="col" id="topFormateurs"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
  </div>-->
<!--<input id="save-pdf" type="button" value="Save as PDF" enabled />-->
<!--</div>

<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary m-3" style="width:48%" >
    <div class="card-body">
      <h6 class="card-title text-white">Les formations par participants et par nombre d'heures</h6>
      <div id="mon-chart3" style="width: 50%; height: 100px"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>




<div class="card bg-secondary m-3" style="width:48%" >
    <div class="card-body">
      <h6 class="card-title text-white">Le coût et les participants par département</h6>
      <div id="chartContainer3" style="height: 100px; width: 50%;"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
</div>


<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary m-3" style="width:48%" >
    <div class="card-body">
      <h6 class="card-title text-white">Total des heures de formation département</h6>
      <div  id="chartContainer" style="height: 100px; width: 50%;"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>-->





<!-- debut -->



<!--div class="card bg-secondary m-3" style="width:48%" >
    <div class="card-body">
      <h6 class="card-title text-white">Top 5 des thèmes de formation par heures</h6>
      <div id="mon-chart1"  class="col"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
</div>
<div style="display:flex; flex-direction: row;justify-content: space-between ">
<div class="card bg-secondary m-3" style="width:48%">
    <div class="card-body">
      <h6 class="card-title text-white">Top des formateurs par nombre d'heures de formation </h6>
      <div class="container" style="height: 100px; width: 50%;" id="NHeuresParDept"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
  </div>



<div class="card bg-secondary m-3" style="width:48%" >
    <div class="card-body">
      <h6 class="card-title text-white">Total des heures de formation par mois</h6>
      <div class="col"  id="chartContainer2" style="height: 100px; width: 50%;"></div>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
</div>
</div>-->