<?php
/*
   Represents a single row for the Continents table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class Continent extends DomainObject
{  
   
   static function getFieldNames() {
      return array('ContinentCode','ContinentName','GeoNameId');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   
   // implement any setters that need input checking/validation
}

?>