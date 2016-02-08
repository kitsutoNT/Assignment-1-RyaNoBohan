<?php
/*
   Represents a single row for the device-types table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class DeviceType extends DomainObject
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