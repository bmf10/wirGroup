<?php

require_once('User.php');

class Ani implements User
{
    private $name;
    private $address;
    private $phone;

    public function __construct()
    {
        $this->name = "Ani";
        $this->address = "Pontianak Kalimantan Barat Indonesia";
        $this->phone = "08123456789";
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
