<?php

namespace JDLX;


class SocialLogin
{

    public function gotoGoogleLogin()
    {
        $google=new \Mybestpro\Selfcare\IdentityService\Google();
        $stateId=uniqId();
        $url=$google->getConsentURL($stateId);
        header('Location: '.$url);
    }

    public function getGoogleUserData()
    {
        $google=new \Mybestpro\Selfcare\IdentityService\Google();


        $code=$_GET['code'];
        $token=$google->getToken($code);

        $userData=$google->getUserData($token);
        $userData=json_decode($userData, true);

        return $userData;
    }



    public function gotoLinkedinLogin()
    {

    }


    public function getLinkedinUserData()
    {

    }



}
