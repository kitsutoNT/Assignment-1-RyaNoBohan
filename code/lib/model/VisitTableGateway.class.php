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
      
      $sql = "SELECT browsers.name, ((COUNT(visits.id)/(SELECT COUNT(visits.id) FROM visits)*100)) AS PercentVisits
FROM browsers INNER JOIN visits ON browsers.ID = visits.browser_id
GROUP BY browsers.name";
      $result = $this->dbAdapter->fetchAsArray($sql, null);      
      return $this->convertRecordsToObjects($result);    
   }
   
   
   //Be careful when adding your function, an error here can mess up the web service
   public function findNumberOfVisitsByMonth()
   {
      $sql = "SELECT count(visit_date) AS number, visit_date FROM `visits` where visit_date LIKE '2016-01-%' group by visit_date";
      $result = $this->dbAdapter->fetchAsArray($sql, null);      
      return $this->convertRecordsToObjects($result); 
   }

}

?>