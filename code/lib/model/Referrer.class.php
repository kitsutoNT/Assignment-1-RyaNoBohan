<?php
/*
   Represents a single row for the referrers table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class Referrer extends DomainObject
{  
   
   static function getFieldNames() {
      return array('id','name');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   
   // implement any setters that need input checking/validation
}

?>