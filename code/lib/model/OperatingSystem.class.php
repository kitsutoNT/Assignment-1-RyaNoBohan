<?php
/*
   Represents a single row for the operating-systems table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class OperatingSystem extends DomainObject
{  
   
   static function getFieldNames() {
      return array('ID','name');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   
   // implement any setters that need input checking/validation
}

?>