

<?php
    /*
        Webservices that supply data from the visits database in JSON format
    */

    require_once("lib/helpers/visits-setup.inc.php");
    
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    
    
    
    if ($_GET["table"] == "device" && !isset($_GET["brand_id"])) {
        outputDevice($dbAdapter);
    }
    #update table and display brand based on id
    else if ($_GET["table"] == "device" && isset($_GET["brand_id"])) {
        outputBrandCounts($dbAdapter);
    }
    #first visit of the page, dump device brands in drop down list
    else if ($_GET["table"] == "browser" && !isset($_GET["browser_id"])) {
        outputBrowser($dbAdapter);
    }
    else if ($_GET["table"] == "continent" && !isset($_GET["continentCode"])) {
        outputContinents($dbAdapter);
    }
    else if ($_GET["table"] == "country" && isset($_GET["continentCode"])) {
        #returns countries in a certain contenent
        outputCountries($dbAdapter);
        #console.log("correct if statement");
    }
    else if ($_GET["table"] == "referrer") {
        outputReferrers($dbAdapter);
    }
    else if ($_GET["table"] == "deviceType") {
        outputDeviceTypes($dbAdapter);
    }
    else if ($_GET["table"] == "operatingSystem") {
        outputOperatingSystems($dbAdapter);
    }
    
    function outputReferrers($dbAdapter) {
        $referrerGate= new ReferrerTableGateway($dbAdapter);
        $result= $referrerGate->findAllSorted(name);
        
        echo json_encode($result);
    }
    
    function outputOperatingSystems($dbAdapter) {
        $osGate= new OperatingSystemTableGateway($dbAdapter);
        $result= $osGate->findAllSorted(name);
        
        echo json_encode($result);
    }
    
    function outputDeviceTypes($dbAdapter) {
        $deviceTypeGate= new DeviceTypeTableGateway($dbAdapter);
        $result= $deviceTypeGate->findAllSorted(name);
        
        echo json_encode($result);
    }
    
    function outputCountries($dbAdapter) {
        $userContinent = $_GET["continentCode"];
        $countryGate = new CountryTableGateway($dbAdapter);
        $result = $countryGate->findCountriesWithCountsById($userContinent);
        
        
        $countryInfoArray = [];
        foreach($result as $row) {
            $countryInfo = new stdClass();
            $countryInfo->name = $row->CountryName;
            $countryInfo->visitCount = $row->VisitsFromCountry;
            array_push($countryInfoArray,$countryInfo);
        }
        echo json_encode($countryInfoArray);
    }
    
    function outputDevice ($dbAdapter) {
        $gateBrands = new DeviceBrandTableGateway($dbAdapter);
        $result = $gateBrands->findAllSorted(name);
        echo json_encode($result);
    }
    
    
    function outputBrandCounts($dbAdapter) {
        $id = $_GET["brand_id"];
        if (!empty($id) && is_numeric($id) && $id >= 1 && $id <= 12){
            $gateBrand = new DeviceBrandTableGateway($dbAdapter);
            $result = $gateBrand->findBrandWithCountsById($id);
            $visitCount = $result->DeviceVisits;
            echo json_encode($visitCount);
        }
    }
    
    function outputBrowser($dbAdapter) {
        $gateVisits = new VisitTableGateway($dbAdapter);
        $result = $gateVisits->findNumberOfVisits();
        
        $browserInfoArray = [];
        foreach($result as $row) {
            $browserInfo = new stdClass();
            $browserInfo->name = $row->name;
            $browserInfo->percentVisits = $row->PercentVisits;
            array_push($browserInfoArray,$browserInfo);
        }
        echo json_encode($browserInfoArray);
    }
    
    function outputContinents($dbAdapter) {
        $gateContinent = new ContinentTableGateway($dbAdapter);
        $result = $gateContinent->findAllSorted(ContinentName);
        echo json_encode($result);
    }

?>