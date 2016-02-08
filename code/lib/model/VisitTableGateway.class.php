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


}

?>