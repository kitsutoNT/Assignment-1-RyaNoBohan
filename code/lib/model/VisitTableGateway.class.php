<?php
/*
  Table Data Gateway for the visits table.
 */
class VisitTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "Visit";
   } 
   protected function getTableName()
   {
      return "visits";
   }
   protected function getOrderFields() 
   {
      return 'name';
   }
  
   protected function getPrimaryKeyName() {
      return "id";
   }

   public function findNumberOfVisits() {
      
      /*
         Previous SQL
         SELECT browsers.name, COUNT(visits.id) AS NumVisits, ((NumVisits/(SELECT COUNT(visits.id) FROM visits)*100)) AS PercentVisits
         FROM browsers INNER JOIN visits ON browsers.ID = visits.browser_id
         GROUP BY browsers.name
      */
      
      $sql = "SELECT browsers.name, browsers.ID, ((COUNT(visits.id)/(SELECT COUNT(visits.id) FROM visits)*100)) AS PercentVisits
FROM browsers INNER JOIN visits ON browsers.ID = visits.browser_id
GROUP BY browsers.name";
      $result = $this->dbAdapter->fetchAsArray($sql, null);      
      return $this->convertRecordsToObjects($result);    
   }
   
   /*
   This function can find the number of visits in a spcific month
   Parameters: $month
   */
   public function findNumberOfVisitsByMonth($month)
   {
      $fullDate = "2016-" . $month . "-%";
      $sql = "SELECT count(visit_date) AS number, visit_date 
      FROM visits where visit_date LIKE :month 
      GROUP BY visit_date having (count(visit_date)>=1) 
      ORDER BY visit_date";

      $results = $this->dbAdapter->fetchAsArray($sql, Array(':month' => $fullDate));
      return $this->convertRecordsToObjects($results); 
   }
   
   /*
   This function can find the number of visists by month
   Parameters: $month
   */
   public function findNumberOfCountryVisitsByMonth($month)
   {
      $formated = sprintf('%02d', $month);
      $firstDay = "2016-".$formated."-01";
      $lastDay = date("Y-m-t", strtotime($firstDay));
      
      $sql = "SELECT count(visit_date) AS number, countryName 
      FROM visits, countries  
      WHERE visit_date BETWEEN :dayFirst AND :dayLast
      AND countries.ISO = visits.country_Code 
      GROUP BY country_Code having (count(country_Code)>= 10)
      ORDER BY country_Code";
      
      $results = $this->dbAdapter->fetchAsArray($sql, Array(':dayFirst' => $firstDay, ':dayLast' => $lastDay));
      return $this->convertRecordsToObjects($results); 
   }
   
   /*
   This can fin the top 10 countries of visits
   */
   public function findTop10CountryVisits()
   {
      $sql = "SELECT count(visit_date) AS number, countryName, ISO 
      FROM visits, countries where visit_date LIKE '2016-01-%' 
      AND countries.ISO = visits.country_Code 
      GROUP BY country_Code 
      ORDER BY number DESC LIMIT 10";
      
      $results = $this->dbAdapter->fetchAsArray($sql, null);      
      return $this->convertRecordsToObjects($results);
   }
   
   /*
   This can find the country of visits in Jan, May, Sept in a spcific country
   Parameters: $ISO
   */
   public function findCountryVisitsJanMaySept($ISO)
   {
      $sql = "SELECT countryName, ISO, 
      (SELECT count(visit_date) FROM visits, countries where visit_date LIKE '2016-01-%' AND countries.ISO = visits.country_Code AND ISO = :iso ) as visitJan,
      (SELECT count(visit_date) FROM visits, countries where visit_date LIKE '2016-05-%' AND countries.ISO = visits.country_Code AND ISO = :iso ) as visitMay,
      (SELECT count(visit_date) FROM visits, countries where visit_date LIKE '2016-09-%' AND countries.ISO = visits.country_Code AND ISO = :iso ) as visitSept
      FROM visits, countries 
      WHERE countries.ISO = visits.country_Code AND ISO = :iso
      GROUP BY country_Code 
      ORDER BY country_Code";
      
      $results = $this->dbAdapter->fetchAsArray($sql, Array(':iso' => $ISO));
      return $this->convertRecordsToObjects($results); 
   }
   
   public function filteredVisitData($joinWhereClause, $fromClause, $filterWhereClause) {
      
      $sql = "SELECT visits.id, visits.visit_date, visits.visit_time, visits.ip_address, countries.countryName ";
      
      $sql .= "FROM " . $fromClause . "WHERE " . $joinWhereClause . $filterWhereClause;
      $sql .= " ORDER BY visits.visit_date, visits.visit_time LIMIT 100";
      $results = $this->dbAdapter->fetchAsArray($sql, null);      
      return $this->convertRecordsToObjects($results);
      //return $sql;
   }
   
   public function singleVisitData ($visitID) {
      $sql = "SELECT visits.id, visits.visit_date, visits.visit_time, visits.ip_address, countries.countryName,"
                . " device_types.name AS 'typeName', device_brands.name AS 'brandName', "
                . "browsers.name AS 'browserName', referrers.name AS 'referrerName', "
                . "operating_systems.name AS 'osName'";
      $sql .= " FROM visits";
      $sql .= " INNER JOIN countries ON visits.country_code = countries.ISO" 
                  . " INNER JOIN device_types ON visits.device_type_id = device_types.id" 
                  . " INNER JOIN device_brands ON visits.device_brand_id = device_brands.id" 
                  . " INNER JOIN browsers ON visits.browser_id = browsers.id" 
                  . " INNER JOIN referrers ON visits.referrer_id = referrers.id" 
                  . " INNER JOIN operating_systems ON visits.os_id = operating_systems.id" 
               . " WHERE visits.id = " . $visitID;
      
      $result = $this->dbAdapter->fetchRow($sql, null);
      return $this->convertRowToObject($result);
      // return $sql;
   }
}

?>