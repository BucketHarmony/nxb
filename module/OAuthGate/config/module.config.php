<?php
/**
 * Module Configuration for OAuthGate.
 */

return array(
    'router' => array(
        'routes' => array(
            'authenticate' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/authenticate',
                    'defaults' => array(
                        'controller' => 'OAuthGate\Controller\Index',
                        'action'     => 'authenticate',
                    ),
                ),
            ),
            'authenticateReturn' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/authenticateReturn',
                    'defaults' => array(
                        'controller' => 'OAuthGate\Controller\Index',
                        'action'     => 'authenticateReturn',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'OAuthGate\Controller\Index',
                        'action'     => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'OAuthGate\Controller\Index' => 'OAuthGate\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
);
