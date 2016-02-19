<?php
/*
   Represents a single row for the device-brand table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class DeviceBrand extends DomainObject implements JsonSerializable
{  
   
   static function getFieldNames() {
      return array('id','name');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   
   // implement any setters that need input checking/validation
   
   public function jsonSerialize() {
      return ['id'=> $this->__get('id'), 'name'=>$this->__get('name')];
   }
   
   // public function unserialize($data) {
   //    $data = unserialize($data);
   //    $this->__set("id", $data['id']);
   //    $this->__set("name", $data['name']);
   // }
   
}

?>