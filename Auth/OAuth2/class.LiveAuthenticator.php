<?php
namespace Auth\OAuth2;

class LiveAuthenticator extends OAuth2Authenticator
{
    protected $app_id;
    protected $app_secret;

    public function __construct($params)
    {
        parent::__construct($params);
        $this->app_id = $params['app_id'];
        $this->app_secret = $params['app_secret'];
    }

    public function getHostName()
    {
        return 'live.com';
    }

    public function getAuthorizationUrl()
    {
        return 'https://login.live.com/oauth20_authorize.srf?client_id='.urlencode($this->app_id).'&redirect_uri='.urlencode($this->redirect_uri).'&response_type=code&scope=wl.basic,wl.emails';
    }

    public function getAccessTokenUrl()
    {
        return 'https://login.live.com/oauth20_token.srf';
    }

    public function doAuthPost($params)
    {
        return \Httpful\Request::post($this->getAccessTokenUrl())->sendisType(\Httpful\Mime::FORM)->addHeader('Content-Type', 'application/x-www-form-urlencoded')->body('client_id='.urlencode($this->app_id).'&client_secret='.urlencode($this->app_secret).'&redirect_uri='.urlencode($this->redirect_uri).'&code='.$params['code'].'&grant_type=authorization_code')->send();
    }

    public function getUserFromToken($token)
    {
        if($token === false)
        {
            $token = \FlipSession::get_var('OAuthToken');
        }
        $resp = \Httpful\Request::get('https://apis.live.net/v5.0/me')->addHeader('Authorization', 'Bearer '.$token->access_token)->send();
        $live_user = $resp->body;
        $user = new \Auth\PendingUser();
        $user->setEmail($live_user->emails->preferred);
        $user->setGivenName($live_user->first_name);
        $user->setLastName($live_user->last_name);
        $user->addLoginProvider($this->getHostName());
        return $user;
    }
}
?>
