<?php

require_once('User.php');

class Bima implements User
{
    private $name;
    private $address;
    private $phone;

    public function __construct()
    {
        $this->name = "Bima Febriansyah";
        $this->address = "Jl Kaliurang Km 5, Jl Pogung Baru F9";
        $this->phone = "089693943932";
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
