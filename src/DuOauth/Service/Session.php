<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Service;

use Zend\Session\SessionManager;
use Zend\Session\Container as SessionContainer;

class Session
{
    const SESSION_NAMESPACE = 'duoauth_twitter';
    
    protected $sessionNamespace = self::SESSION_NAMESPACE;
    protected $sessionManager;
    protected $sessionContainer;
    
    public function setSessionManager(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        return $this;
    }
    
    /**
     * @return  \Zend\Session\SessionManager
     */
    public function getSessionManager()
    {
        return $this->sessionManager;
    }
    
    public function startSession($preserveStorage = false)
    {
        $sessionManager = $this->getSessionManager();
        if(! $sessionManager->sessionExists()) {
            $sessionManager->start($preserveStorage);
        }
    }
    
    /**
     * @return  \Zend\Session\Container
     */
    public function getSessionContainer()
    {
        if(null === $this->sessionContainer && ! $this->sessionContainer instanceof SessionContainer) {
            $this->sessionContainer = new SessionContainer($this->sessionNamespace);
        }
        return $this->sessionContainer;
    }
}
