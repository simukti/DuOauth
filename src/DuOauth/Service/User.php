<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\AdapterInterface;
use DuOauth\Mapper\UserFinderInterface;
use \Duo;

class User
{
    protected $configs;
    protected $mapper;
    protected $authService;
    protected $authAdapter;
    
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
        return $this;
    }
    
    public function getConfigs()
    {
        return $this->configs;
    }
    
    public function setMapper(UserFinderInterface $mapper)
    {
        $this->mapper = $mapper;
    }
    
    /**
     * @return  \DuOauth\Mapper\UserFinderInterface
     */
    public function getMapper()
    {
        if(! $this->mapper) {
            $configs = $this->getConfigs();
            $mapperClassName = $configs['user_mapper'];
            $mapper = new $mapperClassName;
            $this->setMapper($mapper);
        }
        return $this->mapper;
    }
    
    /**
     * Proxy to user mapper
     * 
     * @param   string $username
     * @return  null|array|Traversable
     */
    public function findOneByUsername($username)
    {
        $user = $this->getMapper()->findOneByUsername($username);
        return $user;
    }
    
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }
    
    /**
     * @return  \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        if(! $this->authService) {
            $this->authService = new AuthenticationService;
        }
        return $this->authService;
    }
    
    public function setAuthAdapter(AdapterInterface $adapter)
    {
        $this->authAdapter = $adapter;
        return $this;
    }
    
    /**
     * @return  \DuOauth\Authentication\Adapter\DuoSecurity
     */
    public function getAuthAdapter()  
    {
        return $this->authAdapter;
    }
    
    /**
     * @param   string $username
     * @return  false|array
     */
    public function verifyUser($username)
    {
        $validUser = $this->findOneByUsername($username);
        if(! $validUser) {
            return false;
        }
        $configs        = $this->getConfigs();
        $usernameColumn = $configs['username_columnName'];
        
        if(is_array($validUser)) {
            $currentUser = $validUser[$usernameColumn];
        } elseif(is_object($validUser)) {
            $currentUser = $validUser->{$usernameColumn};
        }
        
        // make sure this is a same username, 
        // 'cause we need twitter username for duosecurity response verification.
        if($username !== $currentUser) {
            return false;
        }
        
        $result      = array();
        $duoConfigs  = $configs['duo'];
        $sig_request = Duo::signRequest($duoConfigs['ikey'],
                                        $duoConfigs['skey'],
                                        $duoConfigs['akey'],
                                        $currentUser);
        $result['username']    = $currentUser;
        $result['sig_request'] = $sig_request;
        $result['host']        = $duoConfigs['host'];
        
        return $result;
    }
}
