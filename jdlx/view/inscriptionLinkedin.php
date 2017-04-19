<?php

require(__DIR__.'/../../vendor/autoload.php');

ini_set('display_errors', 'on');



$google=new Mybestpro\Selfcare\IdentityService\Linkedin();
$stateId=uniqId();
$url=$google->getConsentURL($stateId);
header('Location: '.$url);





