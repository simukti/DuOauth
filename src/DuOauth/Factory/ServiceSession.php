<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use DuOauth\Service\Session;

class ServiceSession implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleConfigs   = $serviceLocator->get('config');
        
        $sessionConfig   = new SessionConfig();
        $sessionConfig->setOptions($moduleConfigs['duoauth']['session']);
        $sessionManager  = new SessionManager($sessionConfig);
        
        $session = new Session;
        $session->setSessionManager($sessionManager);
        return $session;
    }
}
