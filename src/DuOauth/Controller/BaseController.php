<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Controller;

use Zend\Mvc\Controller\AbstractActionController;

abstract class BaseController extends AbstractActionController
{
    protected $configs;
    
    protected $twitterService;
    
    protected $sessionService;
    
    protected $userService;
    
    /**
     * 
     * @return  \Zend\Http\Request
     */
    public function getRequest()
    {
        return parent::getRequest();
    }
    
    /**
     * @return  array
     */
    public function getConfigs()
    {
        if(! $this->configs || ! is_array($this->configs)) {
            $configs = $this->getServiceLocator()->get('config');
            $this->configs = $configs['duoauth'];
        }
        return $this->configs;
    }
    
    /**
     * @return  \DuOauth\Service\Twitter
     */
    public function getTwitterService()
    {
        if(! $this->twitterService) {
            $this->twitterService = $this->getServiceLocator()->get('duoauth-service-twitter');
        }
        return $this->twitterService;
    }
    
    /**
     * @return  \DuOauth\Service\Session
     */
    public function getSessionService()
    {
        if(! $this->sessionService) {
            $this->sessionService = $this->getServiceLocator()->get('duoauth-service-session');
        }
        return $this->sessionService;
    }
    
    /**
     * @return  \DuOauth\Service\User
     */
    public function getUserService()
    {
        if(! $this->userService) {
            $this->userService = $this->getServiceLocator()->get('duoauth-service-user');
        }
        return $this->userService;
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $configs = $this->getConfigs();
        $layout  = $configs['layout'];
        $this->layout($layout);
        
        parent::onDispatch($e);
    }
}
