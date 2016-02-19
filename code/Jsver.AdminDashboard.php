<?php
require_once("lib/helpers/visits-setup.inc.php");


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "lib/includes/visits-head.inc.php"; ?>
        <script type="text/javascript" src="./BrowserCard.js"></script>
    </head>
    <body>
        <!-- Simple header with fixed tabs. -->
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header
                    mdl-layout--fixed-tabs">
         
         <?php include "lib/includes/visits-header.inc.php" ?>
         
          <main class="mdl-layout__content">
            <div class="page-content">
              <!-- Your content goes here -->
            <div>
              <div class="mdl-grid">
                
                <div id="browser" class="mdl-cell mdl-cell--4-col">
                  <!-- Side Card 1  -->
                  <div class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Browsers</h2>
                    </div>
                      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                        <thead>
                          <tr>
                            <th class="mdl-data-table__cell--non-numeric">Browser</th>
                            <th>Percentage of Visits</th>
                          </tr>
                        </thead>
                        <tbody id='browserOutput'>
                        
                        </tbody>
                      </table>
                    </div>  
                   
                  
                  <!-- Side Card 2 -->
                  <div id="deviceCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Devices</h2>
                    </div>
                    <div>
                      <div class="mdl-textfield mdl-js-textfield">
                        <select id="deviceDrop" class="mdl-textfield__input" name="brand_id">
                          <option value="0">Choose Device Brand</option>
                        <select>
                      </div>
                      <div class="mdl-spinner mdl-js-spinner"></div>
                      
                    </div>
                    <div id="brandResult" class="mdl-card__actions mdl-card--border">
                      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                        <thead>
                          <tr>
                            <th class="mdl-data-table__cell--non-numeric">Device Brand</th>
                            <th class="mdl-data-table__cell--non-numeric">Visits</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td id="brandName" class="mdl-data-table__cell--non-numeric"></td>
                            <td id="brandCount"></td>
                          </tr>
                        </table>
                    </div>
                  </div>
                </div>
                
                <div class="mdl-cell mdl-cell--4-col">
                <!-- Side Card 3 -->
                <!-- Should be wide to fit the space right of the other cards  -->
                
                  <div id="countryCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                      <h2 class="mdl-card__title-text">Countries</h2>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                      <select id="continentDrop" class="mdl-textfield__input" name="continentCode">
                        <option value="0">Choose a Continent</option>
                      </select>
                    </div>
                    <div class="mdl-spinner mdl-js-spinner"></div>
                    <div>
                      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                        <thead>
                          <tr>
                            <th class="mdl-data-table__cell--non-numeric">Country</th>
                            <th>Visits</th>
                          </tr>
                        </thead>
                        <tbody id="countryCount">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
              </div>
              <?php include "lib/includes/visits-footer.inc.php" ?>
              </div>
            </div>
          </main>
        </div>
    </body>
</html>