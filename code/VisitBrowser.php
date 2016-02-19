<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "lib/includes/visits-head.inc.php"; ?>
        <script type="text/javascript" src="./VisitBrowser.js"></script>
    </head>
    <body>
         
         
           <?php include "lib/includes/visits-header.inc.php" ?>
        
       <main class="mdl-layout__content">
            <div class="page-content">
              <!-- Your content goes here -->
              
              <div class="mdl-grid">
                
                <div id="Filter" class="mdl-cell mdl-cell--4-col">
                  <!-- Filter Card-->
                  <div class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Filter</h2>
                    </div>
                      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                        <thead>
                          <tr>
                            <th class="mdl-data-table__cell--non-numeric">Filter</th>

                          </tr>
                        </thead>
                        <tbody>
                            <tr id="device-typeFilter"></tr>
                            <tr id="device-brandFilter"></tr>
                            <tr id="browserName"></tr>
                            <tr id="referrerName"></tr>
                            <tr id="operatingSystem"></tr>
                            <tr id="countryName"></tr>
                        </tbody>
                      </table>
                    </div>  
                  <!--  End Filter Card -->
                </div> 

                <div id="Browser" class="mdl-cell mdl-cell--8-col">
                  <!-- Data Card -->
                  <div id="deviceCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Data</h2>
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
                  <!-- End Data Card -->
                </div>
            </div>
              
            </div>
          </main>
        <?php include "lib/includes/visits-footer.inc.php" ?>
        </div>
      </div>
    </body>
</html>