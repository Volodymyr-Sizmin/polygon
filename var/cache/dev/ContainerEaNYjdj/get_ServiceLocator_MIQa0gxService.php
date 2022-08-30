<?php

namespace ContainerEaNYjdj;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_MIQa0gxService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.mIQa0gx' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.mIQa0gx'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'doctrine' => ['services', 'doctrine', 'getDoctrineService', false],
            'encoder' => ['privates', 'security.user_password_hasher', 'getSecurity_UserPasswordHasherService', true],
        ], [
            'doctrine' => '?',
            'encoder' => '?',
        ]);
    }
}