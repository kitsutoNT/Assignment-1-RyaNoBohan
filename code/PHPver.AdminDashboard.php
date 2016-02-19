<?php
require_once("lib/helpers/visits-setup.inc.php");

function outputBrowser($dbAdapter) {
  $gateVisits = new VisitTableGateway($dbAdapter);
  $result = $gateVisits->findNumberOfVisits();
  
  
  echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
          <thead>
            <tr>
              <th class="mdl-data-table__cell--non-numeric">Browser</th>
              <th>Percentage of Visits</th>
            </tr>
          </thead>
          <tbody>';
  
  foreach($result as $row) {
    echo '<tr>
              <td class="mdl-data-table__cell--non-numeric">'. $row->name .'</td>
              <td>'. $row->PercentVisits .'</td>
              </tr>';
  }
  
  echo '</tbody>
            </table>';

}

function outputFilterBrand($dbAdapter) {
  $gateBrands = new DeviceBrandTableGateway($dbAdapter);
  $result = $gateBrands->findAllSorted(name);
  
  foreach ($result as $row) {
    echo '<option value="'.$row->id. '">';
		echo $row->name;
		echo '</option>';
  }
  
}

function outputBrandCounts($dbAdapter){
  $id = $_GET[brand_id];
    if (!empty($id) && is_numeric($id) && $id >= 1 && $id <= 12){
    $gateBrand = new DeviceBrandTableGateway($dbAdapter);
    $result = $gateBrand->findBrandWithCountsById($id);
    
    echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
          <thead>
            <tr>
              <th class="mdl-data-table__cell--non-numeric">Device Brand</th>
              <th>Visits</th>
            </tr>
          </thead>
          <tbody>';
    echo '<tr>
              <td class="mdl-data-table__cell--non-numeric">'. $result->name .'</td>
              <td>'. $result->DeviceVisits.'</td>
              </tr>'; 
    echo '</tbody>
            </table>';
          
  }
  else 
  echo "<h2>Device brand does not exist</h2>";
}

function outputContinents($dbAdapter) {

    $gateContinent = new ContinentTableGateway($dbAdapter);
    $result = $gateContinent->findAllSorted(ContinentName);
    
    foreach ($result as $row) {
      echo '<option value="'.$row->ContinentCode. '">';
  		echo $row->ContinentName;
  		echo '</option>';
    }
}

function outputCountriesWithVisits($dbAdapter) {
  $id = $_GET[continent];
    if (!empty($id) && !is_numeric($id) && strlen($id) == 2 && ctype_upper($id)){
    $gateCountry = new CountryTableGateway($dbAdapter);
    $result = $gateCountry->findCountriesWithCountsById($id);
    
    echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
          <thead>
            <tr>
              <th class="mdl-data-table__cell--non-numeric">Country</th>
              <th>Visits</th>
            </tr>
          </thead>
          <tbody>';
    foreach($result as $row) {
      echo '<tr>
          <td class="mdl-data-table__cell--non-numeric">'. $row->CountryName .'</td>
          <td>'. $row->VisitsFromCountry.'</td>
          </tr>';
  }
              
              
    echo '</tbody>
            </table>';
          
  }
  else 
  echo "<h2>Chosen continent does not exist</h2>";
}



?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "lib/includes/visits-head.inc.php"; ?>
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
              
                
                <div class="mdl-cell mdl-cell--4-col">
                  <!-- Side Card 1  -->
                  <div class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Browsers</h2>
                    </div>
                    <div>
                      <?php outputBrowser($dbAdapter); ?>
                    </div>
                  </div>  
                  
                  <!-- Side Card 2 -->
                  <div class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                      <h2 class="mdl-card__title-text">Devices</h2>
                    </div>
                    <div>
                      <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                        <div class="mdl-textfield mdl-js-textfield">
                          <select class="mdl-textfield__input" name="brand_id">
                            <option value="0">Choose Device Brand</option>
                            <?php outputFilterBrand($dbAdapter); ?>
                          <select>
                        </div>
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                          Submit
                        </button>
                      </form>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                      <?php if (!empty($_GET["brand_id"])){outputBrandCounts($dbAdapter);} ?>
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
                      <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <select class="mdl-textfield__input" name="continent">
                        <option value="0">Choose a Continent</option>
                        <?php outputContinents($dbAdapter); ?>
                      </select>
                    </div>
                      <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                          Submit
                      </button>
                      </form>
                    <div>
                      <?php if (!empty($_GET["continent"])){outputCountriesWithVisits($dbAdapter);} ?>
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