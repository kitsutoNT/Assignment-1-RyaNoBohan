<?php
/*
  Table Data Gateway for the continents table.
 */
class ContinentTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "Continent";
   } 
   protected function getTableName()
   {
      return "continents";
   }
   protected function getOrderFields() 
   {
      return 'ContinentName';
   }
  
   protected function getPrimaryKeyName() {
      return "ContinentCode";
   }


}

?>