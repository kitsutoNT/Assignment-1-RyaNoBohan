<?php
/*
  Table Data Gateway for the operating-systems table.
 */
class OperatingSystemTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "OperatingSystem";
   } 
   protected function getTableName()
   {
      return "operating_systems";
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