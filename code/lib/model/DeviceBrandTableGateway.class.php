<?php
/*
  Table Data Gateway for the device-brand table.
 */
class DeviceBrandTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "DeviceBrand";
   } 
   protected function getTableName()
   {
      return "device_brands";
   }
   protected function getOrderFields() 
   {
      return 'name';
   }
  
   protected function getPrimaryKeyName() {
      return "id";
   }
   
   public function findBrandWithCounts() {
      $sql = "SELECT device_brands.name, device_brands.ID, Count(visits.id) AS DeviceVisits
      FROM device_brands INNER JOIN visits ON device_brands.ID = visits.device_brand_id
      GROUP BY device_brands.name";

      $result = $this->dbAdapter->fetchAsArray($sql, null);      
      return $this->convertRecordsToObjects($result);  
   }
   
   public function findBrandWithCountsById($id) {
      $sql = "SELECT device_brands.name, Count(visits.id) AS DeviceVisits
      FROM device_brands INNER JOIN visits ON device_brands.ID = visits.device_brand_id
      WHERE device_brand_id=:id
      GROUP BY device_brands.name";
      $results = $this->dbAdapter->fetchRow($sql, Array(':id' => $id));   
      return $this->convertRowToObject($results);  
   }

}

?>