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


}

?>