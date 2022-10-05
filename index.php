<?php

require('classe.php');


$imposto = new IRPF(3000,0);

$imposto->calcIRPF();



$imposto-> getTax();

$imposto->getRealTax(); 

$imposto->getIRPF();