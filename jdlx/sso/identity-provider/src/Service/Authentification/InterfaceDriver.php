<?php

namespace Mybestpro\SSO\IdentityProvider\Service\Authentification;


interface InterfaceDriver
{
    public function run($state = null);
    public function callback($parameters = array());


}