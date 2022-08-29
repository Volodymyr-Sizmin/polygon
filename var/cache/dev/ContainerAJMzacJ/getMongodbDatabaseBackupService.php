<?php

namespace ContainerAJMzacJ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getMongodbDatabaseBackupService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Liip\TestFixturesBundle\Services\DatabaseBackup\MongodbDatabaseBackup' shared service.
     *
     * @return \Liip\TestFixturesBundle\Services\DatabaseBackup\MongodbDatabaseBackup
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/liip/test-fixtures-bundle/src/Services/DatabaseBackup/DatabaseBackupInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/liip/test-fixtures-bundle/src/Services/DatabaseBackup/AbstractDatabaseBackup.php';
        include_once \dirname(__DIR__, 4).'/vendor/liip/test-fixtures-bundle/src/Services/DatabaseBackup/MongodbDatabaseBackup.php';

        return $container->services['Liip\\TestFixturesBundle\\Services\\DatabaseBackup\\MongodbDatabaseBackup'] = new \Liip\TestFixturesBundle\Services\DatabaseBackup\MongodbDatabaseBackup($container, ($container->services['Liip\\TestFixturesBundle\\Services\\FixturesLoaderFactory'] ?? $container->load('getFixturesLoaderFactoryService')));
    }
}
