<?php
namespace Flipside\Auth\OAuth2;

class FlipsideAuthenticator extends OAuth2Authenticator
{
    private $apiUrl;
    private $oauthUrl;

    public function __construct($params)
    {
        parent::__construct($params);
        if(isset($params['api_url']))
        {
            $this->apiUrl = $params['api_url'];
        }
        else
        {
            throw new \Exception('Incorrectly configured! Missing api_url parameter.');
        }
        if(isset($params['oauth_url']))
        {
            $this->oauthUrl = $params['oauth_url'];
        }
        else
        {
            throw new \Exception('Incorrectly configured! Missing oauth_url parameter.');
        }
    }

    public function getHostName()
    {
        return 'burningflipside.com';
    }

    public function getAuthorizationUrl()
    {
        return $this->oauthUrl.'/authorize.php?client_id=test&redirect_uri='.urlencode($this->redirect_uri).'&scope=user';
    }

    public function getAccessTokenUrl()
    {
        return $this->oauthUrl.'/token.php?client_id=test&redirect_uri='.urlencode($this->redirect_uri);
    }

    public function getUserFromToken($token)
    {
        if($token === false)
        {
            $token = \Flipside\FlipSession::getVar('OAuthToken');
        }
        $resp = \Httpful\Request::get($this->apiUrl.'/users/me')->addHeader('Authorization', 'token '.$token['access_token'])->send();
        $data = array('extended'=>$resp->body);
        $user = new \Flipside\Auth\FlipsideAPIUser($data);
        $user->addLoginProvider($this->getHostName());
        return $user;
    }

    public function login($username, $password)
    {
        $resp = \Httpful\Request::post($this->apiUrl.'/login?username='.urlencode($username).'&password='.urlencode($password))->send();
        if($resp->hasErrors())
        {
            return false;
        }
        $this->user = $resp->body->extended;
        $this->user->userPassword = $password;
        return array('res'=>true, 'extended'=>$this->user);
    }

    public function isLoggedIn($data)
    {
        if(isset($this->user))
        {
            return true;
        }
        if(isset($data['res']))
        {
            return $data['res'];
        }
        return false;
    }

    public function getUser($data)
    {
        return new \Flipside\Auth\FlipsideAPIUser($data, $this->apiUrl);
    }
}
