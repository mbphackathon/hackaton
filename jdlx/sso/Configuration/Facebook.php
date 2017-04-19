<?php
namespace Mybestpro\Selfcare\Configuration\IdentityService;



use Mybestpro\SSO\IdentityProvider\Service\Authentification\TraitOAuthConfiguration;

Trait Facebook
{

    //configure here https://developers.facebook.com

    use TraitOAuthConfiguration;

    protected static $APPLICATION_ID = '786663848153107';
    protected static $APPLICATION_KEY = '5f072045e86654fbb34de47b8a51e540';
    protected static $CALLBACK_URL = 'http://sso.mybestpro.dev/auth/Facebook/callback';

}



