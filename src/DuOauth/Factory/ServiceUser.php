<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DuOauth\Service\User;
use DuOauth\Authentication\Adapter;

class ServiceUser implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleConfigs  = $serviceLocator->get('config');
        $duoauthConfigs = $moduleConfigs['duoauth'];
        $authAdapter    = new Adapter\DuoSecurity();
        $authAdapter->setDuoConfigs($duoauthConfigs['duo']);
        
        $userService = new User;
        $userService->setConfigs($duoauthConfigs)
                     ->setAuthAdapter($authAdapter);
        return $userService;
    }
}
