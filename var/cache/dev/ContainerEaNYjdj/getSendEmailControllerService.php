<?php

namespace ContainerEaNYjdj;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSendEmailControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\SendEmailController' shared autowired service.
     *
     * @return \App\Controller\SendEmailController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/SendEmailController.php';
        include_once \dirname(__DIR__, 4).'/src/Service/TokenService.php';

        $container->services['App\\Controller\\SendEmailController'] = $instance = new \App\Controller\SendEmailController(($container->privates['App\\Service\\TokenService'] ?? ($container->privates['App\\Service\\TokenService'] = new \App\Service\TokenService())), ($container->services['request_stack'] ?? ($container->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));

        $instance->setContainer(($container->privates['.service_locator.GNc8e5B'] ?? $container->load('get_ServiceLocator_GNc8e5BService'))->withContext('App\\Controller\\SendEmailController', $container));

        return $instance;
    }
}