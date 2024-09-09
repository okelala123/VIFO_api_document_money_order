<?php

use App\Services\VifoServiceFactory;

require 'vendor/autoload.php';
$login = new VifoServiceFactory('dev');
$a =$login->login('NEWSPACE_sale_demo','newspace@vifo123');
print_r($a);
