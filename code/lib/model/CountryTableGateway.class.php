<?php
/*
  Table Data Gateway for the countries table.
 */
class CountryTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "Country";
   } 
   protected function getTableName()
   {
      return "countries";
   }
   protected function getOrderFields() 
   {
      return 'CountryName';
   }
  
   protected function getPrimaryKeyName() {
      return "ISO";
   }

   public function findCountriesWithCountsById($id) {
      $sql = "SELECT CountryName, COUNT( visits.id ) AS VisitsFromCountry
      FROM visits
      INNER JOIN countries ON visits.country_code = countries.ISO
      WHERE countries.continent=:id
      GROUP BY CountryName";
      $results = $this->dbAdapter->fetchAsArray($sql, Array(':id' => $id));   
      return $this->convertRecordsToObjects($results);  
   }
   
   public function filteredCountries($country) {
      $country .= "%";
      $sql = "SELECT countries.CountryName, countries.ISO
               FROM countries
               WHERE countries.CountryName LIKE :country 
               ORDER BY countries.CountryName";
      
      $results = $this->dbAdapter->fetchAsArray($sql, Array(':country' => $country));   
      return $this->convertRecordsToObjects($results);  
   }
}

?>