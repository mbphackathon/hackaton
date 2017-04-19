<?php
namespace Mybestpro\SSO\IdentityProvider\Service\Authentification;



Trait TraitOAuthConfiguration
{

    /*
    protected static $APPLICATION_ID = '';
    protected static $APPLICATION_KEY = '';
    protected static $CALLBACK_URL = '';
    */


    public function getApplicationId() {
        return static::$APPLICATION_ID;
    }

    public function getCallbackURL() {
        return static::$CALLBACK_URL;
    }

    protected function getApplicationKey() {
        return static::$APPLICATION_KEY;
    }


}