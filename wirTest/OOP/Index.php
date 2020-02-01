<?php

require_once('Bima.php');
require_once('Ani.php');
require_once('UserFill.php');

$user = new Bima;
//$user = new Ani; //Other User

$userFill = new UserFill($user);
$userFill->Fill();
