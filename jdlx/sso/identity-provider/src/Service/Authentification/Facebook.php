<?php
namespace Mybestpro\SSO\IdentityProvider\Service\Authentification;

use Mybestpro\SSO\IdentityProvider\State;


abstract class Facebook extends OAuthClient
{

    const AUTHORIZATION_URL = 'https://www.facebook.com/v2.8/dialog/oauth';
    const GET_TOKEN_URL = 'https://graph.facebook.com/v2.8/oauth/access_token';
    const GET_USER_DATA_URL = 'https://graph.facebook.com/v2.5/me';


    const STATE_INIT='state.facebook.init';



    public function getConsentURL(State $state, $scopes = null)
    {

        //for scope go to this url
        //https://developers.facebook.com/docs/facebook-login/permissions

        $url =
            self::AUTHORIZATION_URL .
            '?client_id=' . $this->getApplicationId() .
            '&redirect_uri=' . $this->getCallbackURL() .
            '&state=' . $state->getId() .
            '&scope=' . 'public_profile,email' .
            '&response_type=code';

        return $url;
    }


    public function getToken($code)
    {


        $url = static::GET_TOKEN_URL.'?';

        $configuration = array(
            'code' => $code,
            'client_id' => $this->getApplicationId(),
            'client_secret' => $this->getApplicationKey(),
            'redirect_uri' => $this->getCallbackURL(),
        );



        foreach ($configuration as $key=>$value) {
            $url.='&'.$key.'='.$value;
        }


        $json = $this->httpQuery($url, 'GET', $configuration);
        $response = json_decode($json, true);
        $token = $response['access_token'];
        return $token;
    }

    public function getUserData($token)
    {

        $fields=array(
            'id',
            'email',
            'cover',
            'first_name',
            'last_name',
            'gender',
        );


        $data=$this->httpQuery(self::GET_USER_DATA_URL.'?&fields='.implode(',', $fields), 'GET', array(), array(
            'Authorization'=>'Bearer '. $token
        ));

        return $data;
    }

}



