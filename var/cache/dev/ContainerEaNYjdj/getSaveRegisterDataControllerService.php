<?php

namespace ContainerEaNYjdj;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSaveRegisterDataControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\SaveRegisterDataController' shared autowired service.
     *
     * @return \App\Controller\SaveRegisterDataController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/SaveRegisterDataController.php';

        $container->services['App\\Controller\\SaveRegisterDataController'] = $instance = new \App\Controller\SaveRegisterDataController(($container->services['request_stack'] ?? ($container->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));

        $instance->setContainer(($container->privates['.service_locator.GNc8e5B'] ?? $container->load('get_ServiceLocator_GNc8e5BService'))->withContext('App\\Controller\\SaveRegisterDataController', $container));

        return $instance;
    }
}