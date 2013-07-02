<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DuOauth\Service\Twitter;

class ServiceTwitter implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleConfigs   = $serviceLocator->get('config');
        $duoauthConfigs  = $moduleConfigs['duoauth'];
        $twitterConfigs  = $duoauthConfigs['oauth']['twitter'];
        
        $viewHelperManager = $serviceLocator->get('viewhelpermanager');
        $serverUrlHelper   = $viewHelperManager->get('serverUrl');
        $serverUrl         = $serverUrlHelper->getScheme() . '://' . $serverUrlHelper->getHost();
        $router            = $serviceLocator->get('Router');
        
        $twitterService  = new Twitter;
        $twitterService->setConfigs($twitterConfigs)
                       ->setServerUrl($serverUrl)
                       ->setRouter($router)
                       ->setSessionService($serviceLocator->get('duoauth-service-session'));
        
        return $twitterService;
    }
}
