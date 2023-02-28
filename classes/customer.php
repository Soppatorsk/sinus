<?php
class Customer
{
    private $firstName;
    private $lastName;
    private $city;
    private $street;
    private $country;
    private $zipCode;
    private $eMail;

    public function __construct($firstName, $lastName, $city, $street,$country,$zipCode, $eMail)
    {   
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->city = $city;
        $this->street = $street;
        $this->country = $country;
        $this->zipCode = $zipCode;
        $this->eMail = $eMail;
    }

    public function get_FirstName()
    {
        return $this->firstName;    
    }
    public function get_LastName()
    {
        return $this->lastName;
    }
    public function get_City()
    {
        return $this->city;
    }
    public function get_Street()
    {
        return $this->street;
    }
    public function get_Country()
    {
        return $this->country;
    }
    public function get_ZipCode()
    {
        return $this->zipCode;
    }
}
?>