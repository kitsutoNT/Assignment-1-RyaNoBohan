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
}

?>