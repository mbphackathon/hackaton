<?php

require(__DIR__.'/../../vendor/autoload.php');

ini_set('display_errors', 'on');




$manager=new JDLX\SocialLogin();
$data=$manager->gotoGoogleLogin();



