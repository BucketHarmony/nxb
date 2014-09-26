<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace OAuthGate;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container as SessionContainer;

class Module
{
    /**
     * Bootstapping called by the framework
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        // set up an event listener for
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array(
            $this,
            'authPreRoute'
        ), 1);
    }

    /**
     * Get the configuration for this module
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Get the autoloader set up for this module
     * @return multitype:multitype:multitype:string
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    /**
     * Before Routing
     * Authenticate user or redirect to authentication route
     *
     * @param
     *            $event
     */
    public function authPreRoute($event)
    {
        $this->requireAuthentication($event);
    }

    /**
     * Force Login if the user is not authenticated
     *
     * @param
     *            $event
     */
    public function requireAuthentication($event)
    {
        $auth = new AuthenticationService();
        $route = $event->getRouteMatch();
        $routeName = $route->getMatchedRouteName();

        if (! $auth->hasIdentity() && ($routeName != 'authenticate') && ($routeName != 'logout')) {

            // save the route the user intended to go to
            $session = new SessionContainer('TemaLdapReferrerRoute');
            $session->routeMatch = $route;

            // redirect the user to the authentication page
            $url = $event->getRouter()->assemble(array(
                'routes' => 'authenticate'
            ), array(
                'name' => 'authenticate'
            ));
            // Add the ZF2 cruft required to do a clean redirect
            $response = $event->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit();
        }
    }
}
