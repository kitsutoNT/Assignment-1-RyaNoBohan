<?php
require_once("lib/helpers/visits-setup.inc.php");

function dropDownListMonth()
{
    
}

function displayDataOfMonth($dbAdapter)
{
    $defaultMonth = 1;
    $defaultYear = 2016;

    $gateBrands = new VisitTableGateway($dbAdapter);
    $result = $gateBrands->findNumberOfVisitsByMonth();
    
    $day = 1;
    foreach($result as $key)
    {
        /*echo "['".$day."', ".$key["number"]."],";*/
        echo '["10", "100"],';
		$day++;	
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "lib/includes/visits-head.inc.php"; ?>
    </head>
    <body>
        <?php include "lib/includes/visits-header.inc.php" ?>
        
        <main class="mdl-layout__content">
            <div class="page-content">
              <!-- Your content goes here -->
              
                <h1>Charts Page and i will try to finish this page tmr</h1>
                
                    <!-- Side Card 1  -->
                    <div class="mdl-grid">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-card--expand">
                              <h2 class="mdl-card__title-text">Area Chart</h2>
                            </div>
                            <div>
                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                            <script type="text/javascript">
                            /*global google*/
                                google.charts.load('current', {'packages':['corechart']});
                                google.charts.setOnLoadCallback(drawChart);
                                function drawChart() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Day', 'Visits'],
                                        <?php displayDataOfMonth($dbAdapter); ?>
                                        /*
                                        ['2013',  1000],    
                                        ['2014',  1170],
                                        ['2015',  660],
                                        ['2016',  1030]
                                        */
                                    ]);

                                    var options = {
                                        title: 'November Visits',
                                        hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
                                        vAxis: {minValue: 0}
                                    };

                                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                                    chart.draw(data, options);
                                }
                            </script>
                            <div id="chart_div" style="width: 350px; height: 200px;"></div>
                            </div>
                        </div> 
                    </div>
                    
                    <!-- Side Card 2  -->
                    <div class="mdl-grid">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-card--expand">
                              <h2 class="mdl-card__title-text">Geo Chart</h2>
                            </div>
                            <div>
                              
                            </div>
                        </div> 
                    </div>
                    
                    <!-- Side Card 3  -->
                    <div class="mdl-grid">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-card--expand">
                              <h2 class="mdl-card__title-text">Column Chart</h2>
                            </div>
                            <div>
                           
                            </div>
                        </div> 
                    </div>
              
              
            </div>
          </main>
        <?php include "lib/includes/visits-footer.inc.php" ?>
        </div>
      </div>
    </body>
</html>