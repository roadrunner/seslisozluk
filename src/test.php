<?php

require_once 'src/api.php';
require_once 'src/api/response.php';



$sapi = new Seslisozluk\Api();

print_r($sapi->lookup('engan'));