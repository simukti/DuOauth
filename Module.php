<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $event)
    {
        $twitterService = $event->getApplication()->getServiceManager()->get('duoauth-service-session');
        // start session if no session started
        $twitterService->startSession(); 
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
                'fallback_autoloader' => true,
            ),
            'Zend\Loader\ClassMapAutoloader' => array(
                array(
                    'Duo' => __DIR__ . '/lib/Duo.php',
                )
            ),
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
