<?php
namespace Mybestpro\Selfcare\IdentityService;



class Google
{


    const CONSENT_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    const GET_TOKEN_URL = 'https://www.googleapis.com/oauth2/v4/token';
    const GET_USER_DATA_URL = 'https://www.googleapis.com/oauth2/v2/userinfo';


    protected static $APPLICATION_ID = '294652647829-g4li1ghs02dl1h2hvjv3pm5gkn9jdp81.apps.googleusercontent.com';
    protected static $APPLICATION_KEY = 'dwMj0Bph2hyva-2bc-hgUOdx';
    protected static $CALLBACK_URL = 'http://www.mybestteam.dev/auth/Google/callback.php';


    const STATE_INIT = 'state.google.init';

    const SCOPE_DEFAULT = 'profile email';




    public function getApplicationId() {
        return static::$APPLICATION_ID;
    }

    public function getCallbackURL() {
        return static::$CALLBACK_URL;
    }

    protected function getApplicationKey() {
        return static::$APPLICATION_KEY;
    }


    public function getConsentURL($state, $scopes = null)
    {
        if ($scopes === null) {
            $scopes = static::SCOPE_DEFAULT;
        }

        $url =
            self::CONSENT_URL .
            '?client_id=' . $this->getApplicationId() .
            '&redirect_uri=' . $this->getCallbackURL() .
            '&state=' . $state .
            '&scope=' . $scopes .
            '&response_type=code ';
        return $url;
    }


    public function getToken($code)
    {

        $url = self::GET_TOKEN_URL;

        $configuration = array(
            'code' => $code,
            'client_id' => $this->getApplicationId(),
            'client_secret' => $this->getApplicationKey(),
            'redirect_uri' => $this->getCallbackURL(),
            'grant_type' => 'authorization_code'
        );

        $json = $this->httpQuery($url, 'POST', $configuration);
        $response = json_decode($json, true);
        $token = $response['access_token'];
        return $token;
    }

    public function getUserData($token)
    {
        $queryURL = self::GET_USER_DATA_URL;

        $userData = $this->httpQuery($queryURL, 'GET', array(), array(
            'Authorization' => 'Bearer ' . $token
        ));
        return $userData;
    }



    public function callback($parameters = array())
    {

        $userData = null;

        if (isset($parameters[static::KEY_STATE]) && isset($parameters[static::KEY_CODE])) {

            $stateId = $parameters[static::KEY_STATE];
            $code = $parameters[static::KEY_CODE];

            $token = $this->getToken($code);
            $userData = $this->getUserData($token);

            if ($userData) {
                $state = $this->saveUserData($stateId, $userData);
                $array = $state->toArray();
                \SimpleSAML_Auth_Source::completeAuth($array);
            }
        }

        if (!$userData) {
            if (isset($parameters[static::KEY_STATE])) {
                $stateId = $parameters[static::KEY_STATE];
                $state = \Mybestpro\SSO\IdentityProvider\State::getById($stateId, static::STATE_INIT);
                $this->consentFail($state);
            } else {
                $this->noStateError();
            }
        }
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


    protected function saveUserData($stateId, $userData)
    {
        $state = \Mybestpro\SSO\IdentityProvider\State::getById($stateId, static::STATE_INIT);
        $state->setUserAttributes(array('google' => array($userData)));
        return $state;
    }


    protected function consentFail(State $state)
    {
        $restartURL = $state->getRestartURL();
        header('Location: ' . $restartURL);
        exit();
    }


    protected function saveState()
    {
        $state = $this->getCurrentState();
        if ($state) {
            return $state->save(static::STATE_INIT);
        } else {
            $this->noStateError();
        }
    }

    protected function getCurrentState()
    {
        return State::getCurrent();
    }

    protected function noStateError()
    {
        throw new \RuntimeException('Can not retrieve valid state');
    }


}



