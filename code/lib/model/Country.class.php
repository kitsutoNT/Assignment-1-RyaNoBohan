<?php
/*
   Represents a single row for the Countries table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class Country extends DomainObject
{  
   
   static function getFieldNames() {
      return array('ISO','fipsCountryCode','ISO3','ISONumeric','CountryName','Capital','GeoNameID','Area','Population','Continent','TopLevelDomain','CurrencyCode','CurrencyName','PhoneCountryCode','Languages','PostalCodeFormat','PostalCodeRegex','Neighbours','CountryDescription');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   
   // implement any setters that need input checking/validation
}

?>