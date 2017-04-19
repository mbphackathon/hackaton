<?php
namespace Mybestpro\SSO\IdentityProvider\Service\Authentification;


abstract class OAuthClient implements InterfaceDriver
{

    const KEY_STATE = 'state';
    const KEY_CODE = 'code';


    protected $applicationId;
    protected $applicationKey;
    protected $callbackURL;


    public abstract function getConsentURL($state, $scopes = null);

    public abstract function getToken($code);

    public abstract function getUserData($token);


    public abstract function getApplicationId();
    public abstract function getApplicationKey();
    public abstract function getCallbackURL();


    public function __construct()
    {
    }


    public function run($state = null)
    {

    }




}



