<?php
namespace Mybestpro\Selfcare\Configuration\IdentityService;

use Mybestpro\SSO\IdentityProvider\Service\Authentification\TraitOAuthConfiguration;

Trait Linkedin
{

    use TraitOAuthConfiguration;

    protected static $APPLICATION_ID = '77huxgd27bxduy';
    protected static $APPLICATION_KEY = 'grsGWIv3ikX2TKbZ';
    protected static $CALLBACK_URL = 'http://selfcare.mybestpro.local/auth/Linkedin/callback';



}



