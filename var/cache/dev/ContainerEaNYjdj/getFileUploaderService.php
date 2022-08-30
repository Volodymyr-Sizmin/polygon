<?php

namespace ContainerEaNYjdj;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getFileUploaderService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Service\FileUploader' shared autowired service.
     *
     * @return \App\Service\FileUploader
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Interfaces/FileUploaderInterface.php';
        include_once \dirname(__DIR__, 4).'/src/Service/FileUploader.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/string/Slugger/SluggerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/translation-contracts/LocaleAwareInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/string/Slugger/AsciiSlugger.php';

        return $container->services['App\\Service\\FileUploader'] = new \App\Service\FileUploader((\dirname(__DIR__, 4).'/public/'.$container->getEnv('string:FILE_UPLOAD_PATH')), ($container->privates['slugger'] ?? ($container->privates['slugger'] = new \Symfony\Component\String\Slugger\AsciiSlugger('en'))), ($container->services['doctrine.orm.default_entity_manager'] ?? $container->getDoctrine_Orm_DefaultEntityManagerService()));
    }
}