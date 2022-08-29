<?php

namespace ContainerAJMzacJ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getLoginByIdControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\LoginByIdController' shared autowired service.
     *
     * @return \App\Controller\LoginByIdController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/LoginByIdController.php';
        include_once \dirname(__DIR__, 4).'/src/Service/TokenService.php';

        $container->services['App\\Controller\\LoginByIdController'] = $instance = new \App\Controller\LoginByIdController(($container->privates['App\\Service\\TokenService'] ?? ($container->privates['App\\Service\\TokenService'] = new \App\Service\TokenService())));

        $instance->setContainer(($container->privates['.service_locator.GNc8e5B'] ?? $container->load('get_ServiceLocator_GNc8e5BService'))->withContext('App\\Controller\\LoginByIdController', $container));

        return $instance;
    }
}
