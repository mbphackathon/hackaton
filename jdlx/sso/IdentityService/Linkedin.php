<?php
namespace Mybestpro\Selfcare\IdentityService;



class Linkedin
{



    const AUTHORIZATION_URL = 'https://www.linkedin.com/oauth/v2/authorization';
    const ACCESS_TOKEN_URL = 'https://www.linkedin.com/oauth/v2/accessToken';
    const GET_USER_DATA_URL = 'https://api.linkedin.com/v1/people/~:';


    const SCOPE_DEFAULT = 'r_emailaddress';
    const SCOPE_BASIC = 'r_basicprofile';


    const STATE_INIT='state.linkedin.init';



    const KEY_STATE = 'state';
    const KEY_CODE = 'code';

    protected static $APPLICATION_ID = '77huxgd27bxduy';
    protected static $APPLICATION_KEY = 'grsGWIv3ikX2TKbZ';
    protected static $CALLBACK_URL = 'http://www.mybestteam.dev/auth/linkedin/callback.php';



    public function getConsentURL($state, $scopes = null)
    {
        if ($scopes === null) {
            $scopes = static::SCOPE_DEFAULT.' '.static::SCOPE_BASIC;
        }

        $url =
            self::AUTHORIZATION_URL .
            '?client_id=' . $this->getApplicationId() .
            '&redirect_uri=' . $this->getCallbackURL() .
            '&state=' . $state .
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




    public function getApplicationId() {
        return static::$APPLICATION_ID;
    }

    public function getCallbackURL() {
        return static::$CALLBACK_URL;
    }

    protected function getApplicationKey() {
        return static::$APPLICATION_KEY;
    }


    public function httpQuery($url, $method = 'get', $data = array(), $headers = array())
    {
        $headerString = '';
        foreach ($headers as $name => $value) {
            $headerString .= $name . ': ' . $value . "\r\n";
        }

        $raw = http_build_query($data);
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($raw) . "\r\n" . $headerString,
                'method' => strtoupper($method),
                'content' => $raw,
                'request_fulluri' => true
            ),
        );

        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

}



