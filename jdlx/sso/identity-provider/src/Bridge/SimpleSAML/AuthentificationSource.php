<?php
namespace Mybestpro\SSO\IdentityProvider\Bridge\SimpleSAML;


abstract class AuthentificationSource extends \sspmod_core_Auth_UserPassBase
{



    public function __construct($info, $config) {
        assert('is_array($info)');
        assert('is_array($config)');
        // Call the parent constructor first, as required by the interface
        parent::__construct($info, $config);
    }

    protected function loginFail() {
        throw new \SimpleSAML_Error_Error('WRONGUSERPASS');
    }
}


