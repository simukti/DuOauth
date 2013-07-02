<?php
return array(
    'duoauth'     => include_once __DIR__ . '/duoauth.config.php',
    'controllers' => array(
        'invokables' => array(
            'DuOauth\Controller\Assets'      => 'DuOauth\Controller\Assets',
            'DuOauth\Controller\Login'       => 'DuOauth\Controller\Login',
            'DuOauth\Controller\Twitter'     => 'DuOauth\Controller\Twitter',
            'DuOauth\Controller\DuoSecurity' => 'DuOauth\Controller\DuoSecurity'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'duoauth-service-session' => 'DuOauth\Factory\ServiceSession',
            'duoauth-service-twitter' => 'DuOauth\Factory\ServiceTwitter',
            'duoauth-service-user'    => 'DuOauth\Factory\ServiceUser',
        )
    ),
    'router' => array(
        'routes' => include_once __DIR__ . '/module.routes.php',
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/duoauth-layout'  => realpath(__DIR__ . '/../view/layout/layout.phtml'),
        ),
        'template_path_stack' => array(
            'duoauth' => realpath(__DIR__ . '/../view')
        ),
    )
);