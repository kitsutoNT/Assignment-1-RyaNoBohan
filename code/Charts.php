<?php
require_once("lib/helpers/visits-setup.inc.php");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "lib/includes/visits-head.inc.php"; ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
        <script type="text/javascript" src="./ChartsCard.js"></script>
    </script>

    </head>
    <body>
        <!-- Simple header with fixed tabs. -->
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header
                    mdl-layout--fixed-tabs">
        <?php include "lib/includes/visits-header.inc.php" ?>
        <main class="mdl-layout__content">
            <div class="page-content">
              <!-- Your content goes here -->
            <div class="mdl-grid">
                
                
                <!-- Area Chart Card -->
                <div class="mdl-cell mdl-cell--4-col">
                <div id="areaChartCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                        <h2 class="mdl-card__title-text">Area Chart</h2>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                      <select id="monthDrop1" class="mdl-textfield__input" name="month">
                        <option value="01">Choose a Month in 2016</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                      </select>
                    </div>
                    <div class="mdl-spinner mdl-js-spinner"></div>
                    <div>
                    <div id="chart_div"></div>  
                    </div>
                </div>
                </div>
                
                <!-- Geo Chart Card -->
                <div class="mdl-cell mdl-cell--4-col">
                <div id="geoChartCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                        <h2 class="mdl-card__title-text">Geo Chart</h2>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                      <select id="monthDrop2" class="mdl-textfield__input" name="month">
                        <option value="00">Choose a Month in 2016</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                      </select>
                    </div>
                    <div class="mdl-spinner mdl-js-spinner"></div>
                    <div>
                    <div id="regions_div"></div>  
                    </div>
                </div>
                </div>
            
                <!-- Column Chart Card -->
                <div class="mdl-cell mdl-cell--4-col">
                <div id="columnChartCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                        <h2 class="mdl-card__title-text">Column Chart</h2>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <select id="countryDrop1" class="mdl-textfield__input" name="countryName1">
                            <option value="0">Choose a Country</option>
                        </select>
                        <select id="countryDrop2" class="mdl-textfield__input" name="countryName2">
                            <option value="0">Choose a Country</option>
                        </select>
                        <select id="countryDrop3" class="mdl-textfield__input" name="countryName3">
                            <option value="0">Choose a Country</option>
                        </select>
                    </div>
                    <div class="mdl-spinner mdl-js-spinner"></div>
                    <div>
                    <div id="columnchart_material"></div>  
                    <div class="mdl-spinner mdl-js-spinner"></div>
                    <button id="chartIt" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                        Chart It
                    </button>
                    <div class="mdl-spinner mdl-js-spinner"></div>
                    <button id="switch" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                        switch
                    </button>
                    <div class="mdl-spinner mdl-js-spinner"></div>
                    </div>
                </div>
                </div>
                
            </div> 
            </div>
        </main>        
        </div> 
    </body>
</html>