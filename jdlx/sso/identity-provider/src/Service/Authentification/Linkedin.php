<?php
namespace Mybestpro\SSO\IdentityProvider\Service\Authentification;

use Mybestpro\SSO\IdentityProvider\State;


abstract class Linkedin extends OAuthClient
{


    const AUTHORIZATION_URL = 'https://www.linkedin.com/oauth/v2/authorization';
    const ACCESS_TOKEN_URL = 'https://www.linkedin.com/oauth/v2/accessToken';
    const GET_USER_DATA_URL = 'https://api.linkedin.com/v1/people/~:';


    const SCOPE_DEFAULT = 'r_emailaddress';
    const SCOPE_BASIC = 'r_basicprofile';


    const STATE_INIT='state.linkedin.init';



    public function getConsentURL(State $state, $scopes = null)
    {
        if ($scopes === null) {
            $scopes = static::SCOPE_DEFAULT.' '.static::SCOPE_BASIC;
        }

        $url =
            self::AUTHORIZATION_URL .
            '?client_id=' . $this->getApplicationId() .
            '&redirect_uri=' . $this->getCallbackURL() .
            '&state=' . $state->getId() .
            '&scope=' . $scopes .
            '&response_type=code';

        return $url;
    }


    public function getToken($code)
    {
        $configuration = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->getCallbackURL(),
            'client_id' => $this->getApplicationId(),
            'client_secret' => $this->getApplicationKey()
        );

        $tokenResponse = $this->httpQuery(static::ACCESS_TOKEN_URL, 'POST', $configuration);
        $this->accessToken = json_decode($tokenResponse, true)['access_token'];

        return $this->accessToken;
    }

    public function getUserData($token)
    {
        $fields=array(
            'id',
            'first-name',
            'last-name',
            'location',
            'industry',
            'num-connections',
            'picture-url',
            'summary',
            'email-address',
            'specialties,headline'
        );


        $data=$this->httpQuery(self::GET_USER_DATA_URL.'('.implode(',', $fields).')?format=json', 'GET', array(), array(
            'Authorization'=>'Bearer '. $token
        ));

        return $data;
    }

}



