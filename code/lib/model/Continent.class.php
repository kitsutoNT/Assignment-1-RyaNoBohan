<?php
/*
   Represents a single row for the Continents table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class Continent extends DomainObject implements JsonSerializable
{  
   
   static function getFieldNames() {
      return array('ContinentCode','ContinentName','GeoNameId');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   
   public function jsonSerialize() {
      return ['ContinentCode'=> $this->__get('ContinentCode'), 'ContinentName'=>$this->__get('ContinentName'), 'GeoNameId'=> $this->__get('GeoNameId')];
   }
   // implement any setters that need input checking/validation
}

?>