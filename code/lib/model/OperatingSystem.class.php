<?php
/*
   Represents a single row for the operating-systems table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class OperatingSystem extends DomainObject implements JsonSerializable
{  
   
   static function getFieldNames() {
      return array('ID','name');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   public function jsonSerialize() {
      return ['ID'=> $this->__get('ID'), 'name'=>$this->__get('name')];
   }
   
   // implement any setters that need input checking/validation
}

?>