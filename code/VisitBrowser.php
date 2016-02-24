<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "lib/includes/visits-head.inc.php"; ?>
        
        <link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <script src="jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
        <script src="jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./VisitBrowser.js"></script>
    </head>
    <body>
      
      <div id="modalBox"></div>
           <?php include "lib/includes/visits-header.inc.php" ?>
       <main class="mdl-layout__content">
            <div class="page-content">
              <!-- Your content goes here -->
              
              <div class="mdl-grid">
                
                <div id="Filter" class="mdl-cell mdl-cell--4-col">
                  <!-- Filter Card-->
                  <div id= "filterCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Filter</h2>
                    </div>
                      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                        <thead>
                          <tr>
                            <th class="mdl-data-table__cell--non-numeric">Filter</th>
                          </tr>
                        </thead>
                        <tbody id="filters">
                            <tr id="type"></tr>
                            <tr id="brand"></tr>
                            <tr id="browser"></tr>
                            <tr id="referrer"></tr>
                            <tr id="operatingSys"></tr>
                            <tr id="country">
                              <td>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                  <input class="mdl-textfield__input" type="text" id="search">
                                  <label class="mdl-textfield__label" for="search">Country</label>
                                </div>
                              </td>
                            </tr>
                        </tbody>
                      </table>
                    </div>  
                  <!--  End Filter Card -->
                </div> 

                <div id="data" class="mdl-cell mdl-cell--8-col">
                  <!-- Data Card -->
                  <div id="dataCard" class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Data</h2>
                    </div>
                    <div id="dataResult" class="mdl-card__actions mdl-card--border">
                      <table id="dataTable" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                        <thead>
                          <tr>
                            <th class="mdl-data-table__cell--non-numeric">Detail</th>
                            <th class="mdl-data-table__cell--non-numeric">Visit Date</th>
                            <th class="mdl-data-table__cell--non-numeric">Visit Time</th>
                            <th class="mdl-data-table__cell--non-numeric">IP Address</th>
                            <th class="mdl-data-table__cell--non-numeric">Country Name</th>
                          </tr>
                        </thead>
                        <div class="mdl-spinner mdl-js-spinner"></div>
                        <tbody id="filteredResult">
                          <!-- Data will be appended here-->
                        </tbody>
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