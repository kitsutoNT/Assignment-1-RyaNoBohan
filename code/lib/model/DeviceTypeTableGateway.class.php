<?php
/*
  Table Data Gateway for the device-type table.
 */
class DeviceTypeTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "DeviceType";
   } 
   protected function getTableName()
   {
      return "device_types";
   }
   protected function getOrderFields() 
   {
      return 'name';
   }
  
   protected function getPrimaryKeyName() {
      return "ID";
   }


}

?>