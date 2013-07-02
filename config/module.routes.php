<?php
return array(
    'duoauth-login-index' => array(
        'type' => 'Literal',
        'options' => array(
            'route'    => '/duoauth/superuser/login/',
            'defaults' => array(
                'controller' => 'DuOauth\Controller\Login',
                'action'     => 'index',
            ),
        ),
        'may_terminate' => true,
    ),
    'duoauth-login-logout' => array(
        'type' => 'Literal',
        'options' => array(
            'route'    => '/duoauth/superuser/logout/',
            'defaults' => array(
                'controller' => 'DuOauth\Controller\Login',
                'action'     => 'logout',
            ),
        ),
        'may_terminate' => true,
    ),
    'duoauth-twitter-login' => array(
        'type' => 'Literal',
        'options' => array(
            'route'    => '/duoauth/superuser/twitter/authentication/',
            'defaults' => array(
                'controller' => 'DuOauth\Controller\Twitter',
                'action'     => 'login',
            ),
        ),
        'may_terminate' => true,
    ),
    'duoauth-twitter-callback' => array(
        'type' => 'Literal',
        'options' => array(
            'route'    => '/duoauth/superuser/twitter/authentication-callback/',
            'defaults' => array(
                'controller' => 'DuOauth\Controller\Twitter',
                'action'     => 'callback',
            ),
        ),
        'may_terminate' => true,
    ),
    'duoauth-duosecurity-userverify' => array(
        'type' => 'Literal',
        'options' => array(
            'route'    => '/duoauth/superuser/duo_security/user-verification/',
            'defaults' => array(
                'controller' => 'DuOauth\Controller\DuoSecurity',
                'action'     => 'userVerify',
            ),
        ),
        'may_terminate' => true,
    ),
    'duoauth-duosecurity-responseverify' => array(
        'type' => 'Literal',
        'options' => array(
            'route'    => '/duoauth/superuser/duo_security/user-response-verification/',
            'defaults' => array(
                'controller' => 'DuOauth\Controller\DuoSecurity',
                'action'     => 'responseVerify',
            ),
        ),
        'may_terminate' => true,
    ),
    
    // or you can use assetic
    'duoauth-assets' => array(
        'type' => 'Segment',
        'options' => array(
            'route'    => '/duoauth/superuser/assets/:file',
            'defaults' => array(
                'controller' => 'DuOauth\Controller\Assets',
                'action'     => 'getFile',
            ),
        ),
        'may_terminate' => true,
    ),
);