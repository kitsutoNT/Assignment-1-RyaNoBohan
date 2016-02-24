<?php
    /*
        Webservices that supply data from the visits database in JSON format
    */

    require_once("lib/helpers/visits-setup.inc.php");
    
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    
    /*
        If else statements to process the passed query string parameters
        table = table being accessed or specific data operation
        Set along with an identifier when a specific value is required
    */
    
    if ($_GET["table"] == "device" && !isset($_GET["brand_id"])) {
        outputDevice($dbAdapter);
    }
    else if ($_GET["table"] == "device" && isset($_GET["brand_id"])) {
        outputBrandCounts($dbAdapter);
    }
    else if ($_GET["table"] == "browser" && !isset($_GET["browser_id"])) {
        outputBrowser($dbAdapter);
    }
    else if ($_GET["table"] == "continent" && !isset($_GET["continentCode"])) {
        outputContinents($dbAdapter);
    }
    else if ($_GET["table"] == "country" &&  !isset($_GET["continentCode"]) && !isset($_GET["term"])) {
        outputCountries($dbAdapter);
    }
    else if ($_GET["table"] == "country" && isset($_GET["continentCode"]) && !isset($_GET["term"])) {
        #returns countries in a certain contenent
        outputCountriesByContinent($dbAdapter);
    }
    else if ($_GET["table"] == "country" && isset($_GET["term"]) && !isset($_GET["continentCode"])) {
        outputFilteredCountries($dbAdapter);
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
    else if ($_GET["table"] == "visits" && isset($_GET["month"])) {
        outputVisitOfMonth($dbAdapter);
    }
    else if ($_GET["table"] == "countryVisitsTop10" && isset($_GET["countryISO"])) {
        outputTop10CountryNames($dbAdapter);
    }
    else if ($_GET["table"] == "countryVisitsGeoChart" && isset($_GET["month"])) {
        outputCountryVisitOfMonth($dbAdapter);
    } 
    else if ($_GET["table"] == "countryVisitsJanMaySept" && isset($_GET["countryISO"])) {
        outputCountryVisitJanMaySept($dbAdapter);
    }
    else if ($_GET["table"] == "filteredData") {
        outputFilteredVisits($dbAdapter);
    }
    else if ($_GET["table"] == "visits" && isset($_GET["visitID"]) && !isset($_GET["month"])) {
        //get full info for visit by ID
        outputFullVisitData($dbAdapter);
        //
    }

    /*
        Takes the visit id passed by query string parameter and uses the id to get the specific
        visit record. Then handles the result and returns it in JSON format
    */
    function outputFullVisitData ($dbAdapter) {
        $id = $_GET["visitID"];
        
        $visitGate = new VisitTableGateway($dbAdapter);
        $result = $visitGate->singleVisitData($id);
        
        $visitInfo = new stdClass();
        $visitInfo->visitID = $result->id;
        $visitInfo->visitDate = $result->visit_date;
        $visitInfo->visitTime = $result->visit_time;
        $visitInfo->visitIP = $result->ip_address;
        $visitInfo->visitDeviceType = $result->typeName;
        $visitInfo->visitDeviceBrand = $result->brandName;
        $visitInfo->visitBrowser = $result->browserName;
        $visitInfo->visitReferrer = $result->referrerName;
        $visitInfo->visitOS = $result->osName;
        $visitInfo->countryName = $result->countryName;
            
        
        echo json_encode($visitInfo);
        //echo json_encode($result);
    }
    
    /*
        Forms the FROM and WHERE clauses that will be used in the data access layer
        Then handles the result and returns it in JSON format
    */
    function outputFilteredVisits($dbAdapter){
        
        $joinWhereClause = "visits.country_code = countries.ISO";
        $filterWhereClause = "";
        $fromClause = "visits, countries";
        
        if( $_GET["type"] != "") {
            $joinWhereClause .= " AND visits.device_type_id = device_types.id";
            $filterWhereClause .= " AND device_types.name = '" . $_GET["type"] . "'"; 
            $fromClause .= ", device_types";
        }
        
        if($_GET["brand"] != "") {
            $joinWhereClause .= " AND visits.device_brand_id = device_brands.id";
            $filterWhereClause .= " AND device_brands.name = '" . $_GET["brand"] . "'";
            $fromClause .= ", device_brands";
        }
        
        if($_GET["browser"] != "") {
            $joinWhereClause .= " AND visits.browser_id = browsers.id";
            $filterWhereClause .= " AND browsers.name = '" . $_GET["browser"] . "'";
            $fromClause .= ", browsers";
            //$firstFilter = false;
        }
        
        if($_GET["referrer"] != "") {
            $joinWhereClause .= " AND visits.referrer_id = referrers.id";
            $filterWhereClause .= " AND referrers.name = '" . $_GET["referrer"] . "'";
            $fromClause .= ", referrers";
            //$firstFilter = false;
        }
        
        if($_GET["operatingSys"] != "") {
            $joinWhereClause .= " AND visits.os_id = operating_systems.id";
            $filterWhereClause .= " AND operating_systems.name = '" . $_GET["operatingSys"] . "'";
            $fromClause .= ", operating_systems";
        }
        
        if($_GET["country"] != "") {
            $filterWhereClause .= " AND countries.CountryName = '" . $_GET["country"] . "'";
        }
        
        $joinWhereClause .= " ";
        $filterWhereClause .= " ";
        $fromClause .= " ";
        
        $visitGate = new VisitTableGateway($dbAdapter);
        $result = $visitGate->filteredVisitData($joinWhereClause, $fromClause, $filterWhereClause); 
        
        $dataInfoArray = [];
        foreach($result as $row) {
            $dataInfo = new stdClass();
            $dataInfo->visitID = $row->id;
            $dataInfo->visitDate = $row->visit_date;
            $dataInfo->visitTime = $row->visit_time;
            $dataInfo->visitIP = $row->ip_address;
            $dataInfo->visitCountry = $row->countryName;
            array_push($dataInfoArray,$dataInfo);
        }
        
        echo json_encode($dataInfoArray);
    }
    
    //outputs filtered countries by partial string
    function outputFilteredCountries($dbAdapter) {
        $term = $_GET["term"];
        $countryGate = new CountryTableGateway($dbAdapter);
        $result = $countryGate->filteredCountries($term);
        
        $countryInfoArray = [];
        foreach($result as $row) {
            $countryInfo = new stdClass();
            $countryInfo->label = $row->CountryName;
            $countryInfo->value = $row->CountryName;
            array_push($countryInfoArray,$countryInfo);
        }
        echo json_encode($countryInfoArray);  
    }
    
    //output all countries
    function outputCountries($dbAdapter) {
        $countryGate = new CountryTableGateway($dbAdapter);
        $result = $countryGate->findAllSorted(CountryName);
        
        $countryInfoArray = [];
        foreach($result as $row) {
            $countryInfo = new stdClass();
            $countryInfo->value = $row->CountryName;
            $countryInfo->label = $row->CountryName;
            array_push($countryInfoArray,$countryInfo);
        }
        echo json_encode($countryInfoArray);
    }
    
    //output all referrers
    function outputReferrers($dbAdapter) {
        $referrerGate= new ReferrerTableGateway($dbAdapter);
        $result= $referrerGate->findAllSorted(name);
        
        echo json_encode($result);
    }
    
    //output all operating systems
    function outputOperatingSystems($dbAdapter) {
        $osGate= new OperatingSystemTableGateway($dbAdapter);
        $result= $osGate->findAllSorted(name);
        
        echo json_encode($result);
    }
    
    //output all device types
    function outputDeviceTypes($dbAdapter) {
        $deviceTypeGate= new DeviceTypeTableGateway($dbAdapter);
        $result= $deviceTypeGate->findAllSorted(name);
        
        echo json_encode($result);
    }
    
    //output countries that are located in a certain continent
    function outputCountriesByContinent($dbAdapter) {
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
    
    //output all device brands
    function outputDevice ($dbAdapter) {
        $gateBrands = new DeviceBrandTableGateway($dbAdapter);
        $result = $gateBrands->findAllSorted(name);
        echo json_encode($result);
    }
    
    //output all device brands with their associated visit counts
    function outputBrandCounts($dbAdapter) {
        $id = $_GET["brand_id"];
        if (!empty($id) && is_numeric($id) && $id >= 1 && $id <= 12){
            $gateBrand = new DeviceBrandTableGateway($dbAdapter);
            $result = $gateBrand->findBrandWithCountsById($id);
            $visitCount = $result->DeviceVisits;
            echo json_encode($visitCount);
        }
    }
    
    //output #of visits by browser
    function outputBrowser($dbAdapter) {
        $gateVisits = new VisitTableGateway($dbAdapter);
        $result = $gateVisits->findNumberOfVisits();
        
        $browserInfoArray = [];
        foreach($result as $row) {
            $browserInfo = new stdClass();
            $browserInfo->name = $row->name;
            $browserInfo->id = $row->ID;
            $browserInfo->percentVisits = $row->PercentVisits;
            array_push($browserInfoArray,$browserInfo);
        }
        echo json_encode($browserInfoArray);
    }
    
    // output all continents
    function outputContinents($dbAdapter) {
        $gateContinent = new ContinentTableGateway($dbAdapter);
        $result = $gateContinent->findAllSorted(ContinentName);
        echo json_encode($result);
    }
    
    /*
    This can output the data which are the visits of the month
    Parameters: $dbAdapter
    */
    function outputVisitOfMonth($dbAdapter) {
        $gateVisits = new VisitTableGateway($dbAdapter);
        $result = $gateVisits->findNumberOfVisitsByMonth($_GET["month"]);
        
        $visitsInfoArray = [];
        foreach($result as $row) {
            $visitsInfo = new stdClass();
            $visitsInfo->visitDate = $row->visit_date;
            $visitsInfo->numVisits = $row->number;
            array_push($visitsInfoArray,$visitsInfo);
        }
        echo json_encode($visitsInfoArray); 
    }
    
    /*
    This can output the coutnry visit of the month 
    Parameters: $dbAdapter
    */
    function outputCountryVisitOfMonth($dbAdapter) {
        $gateVisits = new VisitTableGateway($dbAdapter);
        $result = $gateVisits->findNumberOfCountryVisitsByMonth($_GET["month"]);
        
        $visitsInfoArray = [];
        foreach($result as $row) {
            $visitsInfo = new stdClass();
            $visitsInfo->numVisits = $row->number;
            $visitsInfo->countryName = $row->countryName;
            array_push($visitsInfoArray,$visitsInfo);
        }
        echo json_encode($visitsInfoArray); 
    }
    
    /*
    This can output the top 10 countries names
    Parameters: $dbAdapter
    */
    function outputTop10CountryNames($dbAdapter) {
        $gateVisits = new VisitTableGateway($dbAdapter);
        $result = $gateVisits->findTop10CountryVisits();
        
        $countryNamesInfoArray = [];
        foreach($result as $row) {
            $countryNamesInfo = new stdClass();
            $countryNamesInfo->countryISO = $row->ISO;
            $countryNamesInfo->countryName = $row->countryName;
            array_push($countryNamesInfoArray,$countryNamesInfo);
        }
        echo json_encode($countryNamesInfoArray); 
    }
    
    /*
    This can output the country visit in Jan May Sept
    Parameters: $dbAdapter
    */
    function outputCountryVisitJanMaySept($dbAdapter) {
        $gateVisits = new VisitTableGateway($dbAdapter);
        $result = $gateVisits->findCountryVisitsJanMaySept($_GET["countryISO"]);
        
        $countryInfoArray = [];
        foreach($result as $row) {
            $countryInfo = new stdClass();
            $countryInfo->countryISO = $row->ISO;
            $countryInfo->countryName = $row->countryName;
            $countryInfo->visitsJan = $row->visitJan;
            $countryInfo->visitsMay = $row->visitMay;
            $countryInfo->visitsSept = $row->visitSept;
            array_push($countryInfoArray,$countryInfo);
        }
        echo json_encode($countryInfoArray); 
    }

?>