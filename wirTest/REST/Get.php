<?php

header("Content-Type: application/json; charset=UTF-8");

$arraydata = array();

$arraydata['status'] = 200;
$arraydata['message'] = "success";
$arraydata['data'] = [
    'id' => 1,
    'Name' => 'Bima Febriansyah',
    'Address' => 'Jl Kaliurang Km 5, Jl Pogung Baru F9'
];

echo json_encode($arraydata);
