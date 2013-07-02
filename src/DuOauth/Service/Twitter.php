<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Service;

use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\Http;
use ZendService\Twitter\Twitter as ZendServiceTwitter;
use ZendOAuth\Token\Access as TokenAccess;
use ZendOAuth\Consumer as OAuthConsumer;
use Zend\Http\Client as HttpClient;

class Twitter
{
    protected $twitter;
    protected $configs;
    protected $serverUrl;
    protected $router;
    
    /**
     * @var \DuOauth\Service\Session
     */
    protected $sessionService;
    
    /**
     * @var     array
     * @todo    If this set to https, zendoauth http client will throw InvalidArgumentException
     */
    protected $options = array(
        'requestTokenUrl'   => 'https://api.twitter.com/oauth/request_token',
        'authorizeUrl'      => 'https://api.twitter.com/oauth/authorize',
        'accessTokenUrl'    => 'https://api.twitter.com/oauth/access_token'
    );
    
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
        return $this;
    }
    
    public function setServerUrl($serverUrl)
    {
        $this->serverUrl = $serverUrl;
        return $this;
    }
    
    public function getServerUrl()
    {
        return $this->serverUrl;
    }
    
    public function setRouter(TreeRouteStack $router)
    {
        $this->router = $router;
        return $this;
    }
    
    /**
     * @return  \Zend\Mvc\Router\Http\TreeRouteStack
     */
    public function getRouter()
    {
        return $this->router;
    }
    
    public function setSessionService($sessionService)
    {
        $this->sessionService = $sessionService;
    }
    
    /**
     * @return  \ZendService\Twitter\Twitter
     */
    public function getTwitter()
    {
        if(null === $this->twitter || ! $this->twitter instanceof ZendServiceTwitter) {
            $httpConfig = array(
    		    'adapter'       => 'Zend\Http\Client\Adapter\Socket',
    		    'sslverifypeer' => false,
                'sslcapath'     => realpath('/../../../data/cacert.pem')
    		   );
            $httpClient = new HttpClient(null, $httpConfig);
            OAuthConsumer::setHttpClient($httpClient);
            
            $options = $this->options;
            $session = $this->sessionService->getSessionContainer();
            
            if($session->accessToken && $session->accessToken instanceof TokenAccess) {
                $token = $session->accessToken;
                $options['username']    = $token->screen_name;
                $options['accessToken'] = $token;
            } else {
                // library zendservice twitter yang baru options-nya memakai "oauthOptions"
                $options['oauthOptions']['requestTokenUrl'] = $this->options['requestTokenUrl'];
                $options['oauthOptions']['authorizeUrl']    = $this->options['authorizeUrl'];
                $options['oauthOptions']['accessTokenUrl']  = $this->options['accessTokenUrl'];
                $options['oauthOptions']['consumerKey']     = $this->configs['consumer_key'];
                $options['oauthOptions']['consumerSecret']  = $this->configs['consumer_secret'];
                $options['oauthOptions']['callbackUrl']     = $this->getServerUrl() 
                                            . $this->getRouter()->assemble(array(), array(
                                                   'name' => 'duoauth-twitter-callback'
                                               ));
            }
            $this->twitter = new ZendServiceTwitter($options);
        }
        return $this->twitter;
    }
    
    public function validateCallback(Http\Request $request)
    {
        $twitter = $this->getTwitter();
        $sessionContainer = $this->sessionService->getSessionContainer();
        
        if($twitter->isAuthorised()) {
            // user sudah approve twitter oauth
            return true;
        }
        
        $requestToken = $sessionContainer->requestToken;
        $query = $request->getQuery();
        
        if( (! count($query)) || (null !== $query->denied) ) {
            return false;
        }
        
        if(null !== $requestToken) {
            $accessToken = $twitter->getAccessToken($query->toArray(), $requestToken);
            $sessionContainer->accessToken = $accessToken;
            unset($sessionContainer->requestToken);
            return true;
        }
    }
}
