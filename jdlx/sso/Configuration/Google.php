<?php
namespace Mybestpro\Selfcare\Configuration\IdentityService;

use Mybestpro\SSO\IdentityProvider\Service\Authentification\TraitOAuthConfiguration;

Trait Google
{

    use TraitOAuthConfiguration;

    protected static $APPLICATION_ID = '294652647829-g4li1ghs02dl1h2hvjv3pm5gkn9jdp81.apps.googleusercontent.com';
    protected static $APPLICATION_KEY = 'dwMj0Bph2hyva-2bc-hgUOdx';
    protected static $CALLBACK_URL = 'http://sso.mybestpro.dev/auth/Google/callback';

}



