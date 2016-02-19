<?php
/*
   Represents a single row for the Countries table. 
   
   This a concrete implementation of the Domain Model pattern.
 */
class Country extends DomainObject implements JsonSerializable
{  
   
   static function getFieldNames() {
      return array('ISO','fipsCountryCode','ISO3','ISONumeric','CountryName','Capital','GeoNameID','Area','Population','Continent','TopLevelDomain','CurrencyCode','CurrencyName','PhoneCountryCode','Languages','PostalCodeFormat','PostalCodeRegex','Neighbours','CountryDescription');
   }

   public function __construct(array $data, $generateExc)
   {
      parent::__construct($data, $generateExc);
   }
   
   public function jsonSerialize() {
      return ['ISO'=> $this->__get('ISO'), 
               'fipsCountryCode'=>$this->__get('fipsCountryCode'),
               'ISO3'=> $this->__get('ISO3'),
               'ISONumeric'=> $this->__get('ISONumeric'),
               'CountryName'=> $this->__get('CountryName'),
               'Capital'=> $this->__get('Capital'),
               'GeoNameID'=> $this->__get('GeoNameID'),
               'Area'=> $this->__get('Area'),
               'Population'=> $this->__get('Population'),
               'Continent'=> $this->__get('Continent'),
               'TopLevelDomain'=> $this->__get('TopLevelDomain'),
               'CurrencyCode'=> $this->__get('CurrencyCode'),
               'CurrencyName'=> $this->__get('CurrencyName'),
               'PhoneCountryCode'=> $this->__get('PhoneCountryCode'),
               'Languages'=> $this->__get('Languages'),
               'PostalCodeFormat'=> $this->__get('PostalCodeFormat'),
               'PostalCodeRegex'=> $this->__get('PostalCodeRegex'),
               'Neighbours'=> $this->__get('Neighbours'),
               'CountryDescription'=> $this->__get('CountryDescription')];
   }
   
   // implement any setters that need input checking/validation
}

?>