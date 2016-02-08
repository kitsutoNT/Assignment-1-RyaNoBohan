<?php
/*
  Table Data Gateway for the referrers table.
 */
class ReferrerTableGateway extends TableDataGateway
{    
   public function __construct($dbAdapter) 
   {
      parent::__construct($dbAdapter);
   }
  
   protected function getDomainObjectClassName()  
   {
      return "Referrer";
   } 
   protected function getTableName()
   {
      return "referrers";
   }
   protected function getOrderFields() 
   {
      return 'name';
   }
  
   protected function getPrimaryKeyName() {
      return "id";
   }


}

?>