
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  @extends('layouts.mainlayout')
  @section('content')
  <p class="h3">Statistiques</p>
  <div class="container">
              <form method="post" action="{{route('statistiques.store')}}">
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
  <!-- <br>
  <br>

  <div id="mon-chart3" style="width: 900px; height: 350px"></div>
  <div id="mon-chart"></div>
  <div id="mon-chart1"></div>
  <div id="formateur"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>

      $('#departement').ready(function(){
          // chargerDepartements();
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
        })  

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
    // }
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


  </script> -->

  @endsection 