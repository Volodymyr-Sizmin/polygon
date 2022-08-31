<?php

// This file has been auto-generated by the Symfony Dependency Injection Component
// You can reference it in the "opcache.preload" php.ini setting on PHP >= 7.4 when preloading is desired

use Symfony\Component\DependencyInjection\Dumper\Preloader;

if (in_array(PHP_SAPI, ['cli', 'phpdbg'], true)) {
    return;
}

require dirname(__DIR__, 3).'/vendor/autoload.php';
(require __DIR__.'/App_KernelDevDebugContainer.php')->set(\ContainerKqYuaVZ\App_KernelDevDebugContainer::class, null);
require __DIR__.'/ContainerKqYuaVZ/EntityManager_9a5be93.php';
require __DIR__.'/ContainerKqYuaVZ/getValidator_NotCompromisedPasswordService.php';
require __DIR__.'/ContainerKqYuaVZ/getValidator_ExpressionService.php';
require __DIR__.'/ContainerKqYuaVZ/getValidator_EmailService.php';
require __DIR__.'/ContainerKqYuaVZ/getValidator_BuilderService.php';
require __DIR__.'/ContainerKqYuaVZ/getTwig_Runtime_SerializerService.php';
require __DIR__.'/ContainerKqYuaVZ/getTwig_Runtime_SecurityCsrfService.php';
require __DIR__.'/ContainerKqYuaVZ/getTwig_Runtime_HttpkernelService.php';
require __DIR__.'/ContainerKqYuaVZ/getTwig_Mailer_MessageListenerService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslatorService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_YmlService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_XliffService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_ResService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_QtService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_PoService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_PhpService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_MoService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_JsonService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_IniService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_DatService.php';
require __DIR__.'/ContainerKqYuaVZ/getTranslation_Loader_CsvService.php';
require __DIR__.'/ContainerKqYuaVZ/getStofDoctrineExtensions_Listener_TimestampableService.php';
require __DIR__.'/ContainerKqYuaVZ/getStofDoctrineExtensions_Listener_SluggableService.php';
require __DIR__.'/ContainerKqYuaVZ/getServicesResetterService.php';
require __DIR__.'/ContainerKqYuaVZ/getSerializer_Mapping_ClassMetadataFactoryService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Validator_UserPasswordService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_UserPasswordHasherService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_User_Provider_Concrete_AppUserProviderService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_PasswordHasherFactoryService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Logout_Listener_CsrfTokenClearingService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Listener_UserProviderService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Listener_UserChecker_MainService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Listener_Session_MainService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Listener_PasswordMigratingService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Listener_Main_UserProviderService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Listener_CsrfProtectionService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Listener_CheckAuthenticatorCredentialsService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Firewall_Map_Context_MainService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Firewall_Map_Context_DevService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Firewall_Authenticator_MainService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_Csrf_TokenStorageService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_ChannelListenerService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecurity_AccessListenerService.php';
require __DIR__.'/ContainerKqYuaVZ/getSecrets_VaultService.php';
require __DIR__.'/ContainerKqYuaVZ/getRouting_LoaderService.php';
require __DIR__.'/ContainerKqYuaVZ/getPropertyInfo_SerializerExtractorService.php';
require __DIR__.'/ContainerKqYuaVZ/getPropertyInfoService.php';
require __DIR__.'/ContainerKqYuaVZ/getMimeTypesService.php';
require __DIR__.'/ContainerKqYuaVZ/getFragment_Renderer_InlineService.php';
require __DIR__.'/ContainerKqYuaVZ/getErrorControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_UuidGeneratorService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_UlidGeneratorService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_Orm_Validator_UniqueService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_Orm_Listeners_PdoCacheAdapterDoctrineSchemaSubscriberService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_Orm_Listeners_DoctrineTokenProviderSchemaSubscriberService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_Orm_DefaultListeners_AttachEntityListenersService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_Orm_DefaultEntityManager_PropertyInfoExtractorService.php';
require __DIR__.'/ContainerKqYuaVZ/getDoctrine_Fixtures_LoaderService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_Security_Voter_VoteListenerService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_Security_Voter_Security_Access_RoleHierarchyVoterService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_Security_Voter_Security_Access_AuthenticatedVoterService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_Security_UserValueResolverService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_ArgumentResolver_VariadicService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_ArgumentResolver_SessionService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_ArgumentResolver_ServiceService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_ArgumentResolver_RequestAttributeService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_ArgumentResolver_RequestService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_ArgumentResolver_NotTaggedControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getDebug_ArgumentResolver_DefaultService.php';
require __DIR__.'/ContainerKqYuaVZ/getContainer_EnvVarProcessorsLocatorService.php';
require __DIR__.'/ContainerKqYuaVZ/getContainer_EnvVarProcessorService.php';
require __DIR__.'/ContainerKqYuaVZ/getCache_ValidatorExpressionLanguageService.php';
require __DIR__.'/ContainerKqYuaVZ/getCache_SystemClearerService.php';
require __DIR__.'/ContainerKqYuaVZ/getCache_SystemService.php';
require __DIR__.'/ContainerKqYuaVZ/getCache_GlobalClearerService.php';
require __DIR__.'/ContainerKqYuaVZ/getCache_AppClearerService.php';
require __DIR__.'/ContainerKqYuaVZ/getCache_AppService.php';
require __DIR__.'/ContainerKqYuaVZ/getConfigurationService.php';
require __DIR__.'/ContainerKqYuaVZ/getChainManagerRegistryService.php';
require __DIR__.'/ContainerKqYuaVZ/getTemplateControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getRedirectControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getFixturesLoaderFactoryService.php';
require __DIR__.'/ContainerKqYuaVZ/getDatabaseToolCollectionService.php';
require __DIR__.'/ContainerKqYuaVZ/getSqliteDatabaseBackupService.php';
require __DIR__.'/ContainerKqYuaVZ/getMysqlDatabaseBackupService.php';
require __DIR__.'/ContainerKqYuaVZ/getMongodbDatabaseBackupService.php';
require __DIR__.'/ContainerKqYuaVZ/getFileUploaderService.php';
require __DIR__.'/ContainerKqYuaVZ/getUserRepositoryService.php';
require __DIR__.'/ContainerKqYuaVZ/getUserFactoryService.php';
require __DIR__.'/ContainerKqYuaVZ/getSendEmailControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getSaveRegisterDataControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getSaveNonBankClientDataControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getResetPinControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getResetPasswordControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getResetControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getResetCodeControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getPasswordControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getOwnQuestionControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getNonClientRegisterControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getMatchCodesControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getLoginControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getLoginByIdControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getFetchControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getDecodeControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/getCreatePinControllerService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Session_DeprecatedService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_WkLA6hhService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_MIQa0gxService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_T7xmfzkService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_SRxqn0YService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_O7AvvigService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_NJbzd4rService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_KfwZsneService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_KfbR3DYService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_GNc8e5BService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_FP_PbDeService.php';
require __DIR__.'/ContainerKqYuaVZ/get_ServiceLocator_EhNGjzfService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Container_Private_ValidatorService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Container_Private_TwigService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Container_Private_SessionService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Container_Private_SerializerService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Container_Private_Security_Csrf_TokenManagerService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Container_Private_FilesystemService.php';
require __DIR__.'/ContainerKqYuaVZ/get_Container_Private_CacheClearerService.php';

$classes = [];
$classes[] = 'Symfony\Bundle\FrameworkBundle\FrameworkBundle';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\DoctrineBundle';
$classes[] = 'Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle';
$classes[] = 'Symfony\Bundle\MakerBundle\MakerBundle';
$classes[] = 'Symfony\Bundle\SecurityBundle\SecurityBundle';
$classes[] = 'Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle';
$classes[] = 'Zenstruck\Foundry\ZenstruckFoundryBundle';
$classes[] = 'Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle';
$classes[] = 'Symfony\Bundle\TwigBundle\TwigBundle';
$classes[] = 'Liip\TestFixturesBundle\LiipTestFixturesBundle';
$classes[] = 'Symfony\Component\HttpKernel\CacheClearer\ChainCacheClearer';
$classes[] = 'Symfony\Component\Filesystem\Filesystem';
$classes[] = 'Symfony\Component\Security\Core\Authorization\AuthorizationChecker';
$classes[] = 'Symfony\Component\Security\Csrf\CsrfTokenManager';
$classes[] = 'Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator';
$classes[] = 'Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage';
$classes[] = 'Symfony\Component\DependencyInjection\ServiceLocator';
$classes[] = 'Symfony\Component\Serializer\Serializer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer';
$classes[] = 'Symfony\Component\PropertyAccess\PropertyAccessor';
$classes[] = 'Symfony\Component\Cache\Adapter\ArrayAdapter';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ProblemNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\UidNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DateTimeNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ConstraintViolationListNormalizer';
$classes[] = 'Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter';
$classes[] = 'Symfony\Component\Serializer\Normalizer\MimeMessageNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\PropertyNormalizer';
$classes[] = 'Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\FormErrorNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DataUriNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ArrayDenormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ObjectNormalizer';
$classes[] = 'Symfony\Component\Serializer\Encoder\XmlEncoder';
$classes[] = 'Symfony\Component\Serializer\Encoder\JsonEncoder';
$classes[] = 'Symfony\Component\Serializer\Encoder\YamlEncoder';
$classes[] = 'Symfony\Component\Serializer\Encoder\CsvEncoder';
$classes[] = 'Symfony\Component\HttpFoundation\Session\Session';
$classes[] = 'Symfony\Component\HttpFoundation\Session\SessionFactory';
$classes[] = 'Twig\Cache\FilesystemCache';
$classes[] = 'Twig\Extension\CoreExtension';
$classes[] = 'Twig\Extension\EscaperExtension';
$classes[] = 'Twig\Extension\OptimizerExtension';
$classes[] = 'Twig\Extension\StagingExtension';
$classes[] = 'Twig\ExtensionSet';
$classes[] = 'Twig\Template';
$classes[] = 'Twig\TemplateWrapper';
$classes[] = 'Twig\Environment';
$classes[] = 'Twig\Loader\FilesystemLoader';
$classes[] = 'Symfony\Bridge\Twig\Extension\CsrfExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\LogoutUrlExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\SecurityExtension';
$classes[] = 'Symfony\Component\Security\Http\Impersonate\ImpersonateUrlGenerator';
$classes[] = 'Symfony\Bridge\Twig\Extension\ProfilerExtension';
$classes[] = 'Twig\Profiler\Profile';
$classes[] = 'Symfony\Bridge\Twig\Extension\TranslationExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\CodeExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\RoutingExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\YamlExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\StopwatchExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\HttpKernelExtension';
$classes[] = 'Symfony\Bridge\Twig\Extension\HttpFoundationExtension';
$classes[] = 'Symfony\Component\HttpFoundation\UrlHelper';
$classes[] = 'Symfony\Bridge\Twig\Extension\SerializerExtension';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Twig\DoctrineExtension';
$classes[] = 'Twig\Extension\DebugExtension';
$classes[] = 'Symfony\Bridge\Twig\AppVariable';
$classes[] = 'Twig\RuntimeLoader\ContainerRuntimeLoader';
$classes[] = 'Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\EnvironmentConfigurator';
$classes[] = 'Symfony\Component\Validator\Validator\ValidatorInterface';
$classes[] = 'Symfony\Component\HttpFoundation\RequestMatcher';
$classes[] = 'Symfony\Component\HttpFoundation\Session\SessionInterface';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Session\DeprecatedSessionFactory';
$classes[] = 'App\Controller\CreatePinController';
$classes[] = 'App\Controller\DecodeController';
$classes[] = 'App\Controller\FetchController';
$classes[] = 'App\Controller\LoginByIdController';
$classes[] = 'App\Controller\LoginController';
$classes[] = 'App\Controller\MatchCodesController';
$classes[] = 'App\Controller\NonClientRegisterController';
$classes[] = 'App\Controller\OwnQuestionController';
$classes[] = 'App\Controller\PasswordController';
$classes[] = 'App\Controller\ResetCodeController';
$classes[] = 'App\Controller\ResetController';
$classes[] = 'App\Controller\ResetPasswordController';
$classes[] = 'App\Controller\ResetPinController';
$classes[] = 'App\Controller\SaveNonBankClientDataController';
$classes[] = 'App\Controller\SaveRegisterDataController';
$classes[] = 'App\Controller\SendEmailController';
$classes[] = 'App\EventListener\ExceptionListener';
$classes[] = 'App\EventSubscriber\RequestSubscriber';
$classes[] = 'App\EventSubscriber\ResponseSubscriber';
$classes[] = 'App\Factory\FileFactory';
$classes[] = 'App\Factory\UserFactory';
$classes[] = 'App\Repository\UserRepository';
$classes[] = 'App\Service\FileUploader';
$classes[] = 'App\Service\TokenService';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseBackup\MongodbDatabaseBackup';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseBackup\MysqlDatabaseBackup';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseBackup\SqliteDatabaseBackup';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseToolCollection';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseTools\ORMDatabaseTool';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseTools\ORMSqliteDatabaseTool';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseTools\MongoDBDatabaseTool';
$classes[] = 'Liip\TestFixturesBundle\Services\DatabaseTools\PHPCRDatabaseTool';
$classes[] = 'Liip\TestFixturesBundle\Services\FixturesLoaderFactory';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Controller\RedirectController';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Controller\TemplateController';
$classes[] = 'Zenstruck\Foundry\ChainManagerRegistry';
$classes[] = 'Zenstruck\Foundry\Configuration';
$classes[] = 'Zenstruck\Foundry\StoryManager';
$classes[] = 'Zenstruck\Foundry\ModelFactoryManager';
$classes[] = 'Zenstruck\Foundry\Instantiator';
$classes[] = 'Faker\Generator';
$classes[] = 'Faker\Factory';
$classes[] = 'Symfony\Component\Cache\Adapter\PhpArrayAdapter';
$classes[] = 'Doctrine\Common\Annotations\PsrCachedReader';
$classes[] = 'Doctrine\Common\Annotations\AnnotationReader';
$classes[] = 'Doctrine\Common\Annotations\AnnotationRegistry';
$classes[] = 'Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory';
$classes[] = 'Symfony\Component\Cache\Adapter\AdapterInterface';
$classes[] = 'Symfony\Component\Cache\Adapter\AbstractAdapter';
$classes[] = 'Symfony\Component\Cache\Adapter\FilesystemAdapter';
$classes[] = 'Symfony\Component\Cache\Marshaller\DefaultMarshaller';
$classes[] = 'Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer';
$classes[] = 'Symfony\Component\Config\Resource\SelfCheckingResourceChecker';
$classes[] = 'Symfony\Component\Config\ResourceCheckerConfigCacheFactory';
$classes[] = 'Symfony\Component\DependencyInjection\EnvVarProcessor';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\TraceableValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\NotTaggedControllerValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\ServiceValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\DebugHandlersListener';
$classes[] = 'Symfony\Component\HttpKernel\Debug\FileLinkFormatter';
$classes[] = 'Symfony\Component\Security\Core\Authorization\TraceableAccessDecisionManager';
$classes[] = 'Symfony\Component\Security\Core\Authorization\AccessDecisionManager';
$classes[] = 'Symfony\Bundle\SecurityBundle\Debug\TraceableFirewallListener';
$classes[] = 'Symfony\Component\Security\Http\Controller\UserValueResolver';
$classes[] = 'Symfony\Component\Security\Core\Authorization\Voter\TraceableVoter';
$classes[] = 'Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter';
$classes[] = 'Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter';
$classes[] = 'Symfony\Bundle\SecurityBundle\EventListener\VoteListener';
$classes[] = 'Symfony\Component\Stopwatch\Stopwatch';
$classes[] = 'Symfony\Component\DependencyInjection\Config\ContainerParametersResourceChecker';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\DisallowRobotsIndexingListener';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Registry';
$classes[] = 'Doctrine\DBAL\Connection';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\ConnectionFactory';
$classes[] = 'Doctrine\DBAL\Configuration';
$classes[] = 'Doctrine\DBAL\Logging\DebugStack';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Dbal\SchemaAssetsFilterManager';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Dbal\BlacklistSchemaAssetFilter';
$classes[] = 'Symfony\Bridge\Doctrine\ContainerAwareEventManager';
$classes[] = 'Doctrine\Bundle\FixturesBundle\Loader\SymfonyFixturesLoader';
$classes[] = 'App\DataFixtures\RegistrationFixtures';
$classes[] = 'Doctrine\ORM\Mapping\Driver\AnnotationDriver';
$classes[] = 'Doctrine\ORM\Proxy\Autoloader';
$classes[] = 'Doctrine\ORM\EntityManager';
$classes[] = 'Doctrine\ORM\Configuration';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Mapping\MappingDriver';
$classes[] = 'Doctrine\Persistence\Mapping\Driver\MappingDriverChain';
$classes[] = 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy';
$classes[] = 'Doctrine\ORM\Mapping\DefaultQuoteStrategy';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Mapping\ContainerEntityListenerResolver';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Repository\ContainerRepositoryFactory';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\ManagerConfigurator';
$classes[] = 'Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor';
$classes[] = 'Doctrine\ORM\Tools\AttachEntityListenersListener';
$classes[] = 'Symfony\Bridge\Doctrine\SchemaListener\RememberMeTokenProviderDoctrineSchemaSubscriber';
$classes[] = 'Symfony\Bridge\Doctrine\SchemaListener\PdoCacheAdapterDoctrineSchemaSubscriber';
$classes[] = 'Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator';
$classes[] = 'Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator';
$classes[] = 'Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ErrorController';
$classes[] = 'Symfony\Component\ErrorHandler\ErrorRenderer\SerializerErrorRenderer';
$classes[] = 'Symfony\Bridge\Twig\ErrorRenderer\TwigErrorRenderer';
$classes[] = 'Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer';
$classes[] = 'Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher';
$classes[] = 'Symfony\Component\EventDispatcher\EventDispatcher';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\ErrorListener';
$classes[] = 'Symfony\Component\HttpKernel\Fragment\InlineFragmentRenderer';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentNameConverter';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\EventListener\IsGrantedListener';
$classes[] = 'Symfony\Component\Runtime\Runner\Symfony\HttpKernelRunner';
$classes[] = 'Symfony\Component\Runtime\Runner\Symfony\ResponseRunner';
$classes[] = 'Symfony\Component\Runtime\SymfonyRuntime';
$classes[] = 'Symfony\Component\HttpKernel\HttpKernel';
$classes[] = 'Symfony\Component\HttpKernel\Controller\TraceableControllerResolver';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\TraceableArgumentResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver';
$classes[] = 'App\Kernel';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\LocaleAwareListener';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\LocaleListener';
$classes[] = 'Symfony\Component\HttpKernel\Log\Logger';
$classes[] = 'Symfony\Component\Mailer\EventListener\EnvelopeListener';
$classes[] = 'Symfony\Component\Mailer\EventListener\MessageLoggerListener';
$classes[] = 'Symfony\Component\Mime\MimeTypes';
$classes[] = 'Symfony\Component\DependencyInjection\ParameterBag\ContainerBag';
$classes[] = 'Symfony\Component\PropertyInfo\PropertyInfoExtractor';
$classes[] = 'Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor';
$classes[] = 'Symfony\Component\PropertyInfo\Extractor\SerializerExtractor';
$classes[] = 'Symfony\Component\HttpFoundation\RequestStack';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\ResponseListener';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Routing\Router';
$classes[] = 'Symfony\Component\Routing\RequestContext';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\RouterListener';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader';
$classes[] = 'Symfony\Component\Config\Loader\LoaderResolver';
$classes[] = 'Symfony\Component\Routing\Loader\XmlFileLoader';
$classes[] = 'Symfony\Component\HttpKernel\Config\FileLocator';
$classes[] = 'Symfony\Component\Routing\Loader\YamlFileLoader';
$classes[] = 'Symfony\Component\Routing\Loader\PhpFileLoader';
$classes[] = 'Symfony\Component\Routing\Loader\GlobFileLoader';
$classes[] = 'Symfony\Component\Routing\Loader\DirectoryLoader';
$classes[] = 'Symfony\Component\Routing\Loader\ContainerLoader';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Routing\AnnotatedRouteControllerLoader';
$classes[] = 'Symfony\Component\Routing\Loader\AnnotationDirectoryLoader';
$classes[] = 'Symfony\Component\Routing\Loader\AnnotationFileLoader';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Secrets\SodiumVault';
$classes[] = 'Symfony\Component\String\LazyString';
$classes[] = 'Symfony\Component\Security\Http\Firewall\AccessListener';
$classes[] = 'Symfony\Component\Security\Http\AccessMap';
$classes[] = 'Symfony\Component\Security\Http\Authentication\NoopAuthenticationManager';
$classes[] = 'Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolver';
$classes[] = 'Symfony\Component\Security\Http\Firewall\ChannelListener';
$classes[] = 'Symfony\Component\Security\Http\EntryPoint\RetryAuthenticationEntryPoint';
$classes[] = 'Symfony\Component\Security\Http\Firewall\ContextListener';
$classes[] = 'Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage';
$classes[] = 'Symfony\Component\Security\Http\Firewall\AuthenticatorManagerListener';
$classes[] = 'Symfony\Component\Security\Http\Authentication\AuthenticatorManager';
$classes[] = 'Symfony\Bundle\SecurityBundle\Security\FirewallMap';
$classes[] = 'Symfony\Bundle\SecurityBundle\Security\FirewallContext';
$classes[] = 'Symfony\Bundle\SecurityBundle\Security\FirewallConfig';
$classes[] = 'Symfony\Bundle\SecurityBundle\Security\LazyFirewallContext';
$classes[] = 'Symfony\Component\Security\Http\Firewall\ExceptionListener';
$classes[] = 'Symfony\Component\Security\Http\HttpUtils';
$classes[] = 'Symfony\Component\Security\Http\EventListener\CheckCredentialsListener';
$classes[] = 'Symfony\Component\Security\Http\EventListener\CsrfProtectionListener';
$classes[] = 'Symfony\Component\Security\Http\EventListener\UserProviderListener';
$classes[] = 'Symfony\Component\Security\Http\EventListener\PasswordMigratingListener';
$classes[] = 'Symfony\Component\Security\Http\EventListener\SessionStrategyListener';
$classes[] = 'Symfony\Component\Security\Http\Session\SessionAuthenticationStrategy';
$classes[] = 'Symfony\Component\Security\Http\EventListener\UserCheckerListener';
$classes[] = 'Symfony\Component\Security\Core\User\InMemoryUserChecker';
$classes[] = 'Symfony\Component\Security\Http\EventListener\CsrfTokenClearingLogoutListener';
$classes[] = 'Symfony\Component\Security\Http\Logout\LogoutUrlGenerator';
$classes[] = 'Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory';
$classes[] = 'Symfony\Component\Security\Http\RememberMe\ResponseListener';
$classes[] = 'Symfony\Component\Security\Core\Role\RoleHierarchy';
$classes[] = 'Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage';
$classes[] = 'Symfony\Bridge\Doctrine\Security\User\EntityUserProvider';
$classes[] = 'Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher';
$classes[] = 'Symfony\Component\Security\Core\Validator\Constraints\UserPasswordValidator';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\EventListener\HttpCacheListener';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\EventListener\ControllerListener';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DateTimeParamConverter';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\EventListener\SecurityListener';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener';
$classes[] = 'Sensio\Bundle\FrameworkExtraBundle\Templating\TemplateGuesser';
$classes[] = 'Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory';
$classes[] = 'Symfony\Component\Serializer\Mapping\Loader\LoaderChain';
$classes[] = 'Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader';
$classes[] = 'Symfony\Component\DependencyInjection\ContainerInterface';
$classes[] = 'Symfony\Component\HttpKernel\DependencyInjection\ServicesResetter';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\SessionListener';
$classes[] = 'Symfony\Component\String\Slugger\AsciiSlugger';
$classes[] = 'Gedmo\Sluggable\SluggableListener';
$classes[] = 'Gedmo\Timestampable\TimestampableListener';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\StreamedResponseListener';
$classes[] = 'Symfony\Component\Translation\Loader\CsvFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\IcuDatFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\IniFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\JsonFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\MoFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\PhpFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\PoFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\QtFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\IcuResFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\XliffFileLoader';
$classes[] = 'Symfony\Component\Translation\Loader\YamlFileLoader';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Translation\Translator';
$classes[] = 'Symfony\Component\Translation\Formatter\MessageFormatter';
$classes[] = 'Symfony\Component\Translation\IdentityTranslator';
$classes[] = 'Symfony\Component\Mailer\EventListener\MessageListener';
$classes[] = 'Symfony\Bridge\Twig\Mime\BodyRenderer';
$classes[] = 'Symfony\Bridge\Twig\Extension\HttpKernelRuntime';
$classes[] = 'Symfony\Component\HttpKernel\DependencyInjection\LazyLoadingFragmentHandler';
$classes[] = 'Symfony\Component\HttpKernel\Fragment\FragmentUriGenerator';
$classes[] = 'Symfony\Component\HttpKernel\UriSigner';
$classes[] = 'Symfony\Bridge\Twig\Extension\CsrfRuntime';
$classes[] = 'Symfony\Bridge\Twig\Extension\SerializerRuntime';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\ValidateRequestListener';
$classes[] = 'Symfony\Component\Validator\ValidatorBuilder';
$classes[] = 'Symfony\Component\Validator\Validation';
$classes[] = 'Symfony\Component\Validator\ContainerConstraintValidatorFactory';
$classes[] = 'Symfony\Bridge\Doctrine\Validator\DoctrineInitializer';
$classes[] = 'Symfony\Component\Validator\Mapping\Loader\PropertyInfoLoader';
$classes[] = 'Symfony\Bridge\Doctrine\Validator\DoctrineLoader';
$classes[] = 'Symfony\Component\Validator\Constraints\EmailValidator';
$classes[] = 'Symfony\Component\Validator\Constraints\ExpressionValidator';
$classes[] = 'Symfony\Component\Validator\Constraints\NotCompromisedPasswordValidator';
$classes[] = 'Symfony\Contracts\HttpClient\HttpClientInterface';
$classes[] = 'Symfony\Component\HttpClient\HttpClient';

$preloaded = Preloader::preload($classes);
require_once __DIR__.'/twig/b9/b9b833449724af941e55c8ab28e54cf8f4e80977687f0563583e3caffbd89e12.php';
require_once __DIR__.'/twig/b2/b2b84312337dc05fa167286f9d288a457953b85493b5874d483093ec84e19461.php';
require_once __DIR__.'/twig/93/93669ff6e05a824c8985f522a89ede83ec1f5b6710f21a3e25f27141a4e11b4d.php';
require_once __DIR__.'/twig/56/564d37b42bab72fb39e88c594de098953d7542b9265de885475d14abcec62dcd.php';
require_once __DIR__.'/twig/65/65601e9e81d17eec27ffd141c4f117951dcd1044ef0ff8903d63c1921c875128.php';
require_once __DIR__.'/twig/dd/dd6af0ad2bd3494141092e810e601e3e9910ce5b0cd2823b067c3c26c2f68094.php';
require_once __DIR__.'/twig/c2/c28ebeceb207c96635c81e2a0813476eb43e1f6b3d3d98daf5d8bd2d6b488e4e.php';
require_once __DIR__.'/twig/a1/a1bdd9aa29638567f7bc3dba6b64643b314716faa9d5f940d2512bb715d5816e.php';
require_once __DIR__.'/twig/75/75a83ec1fde45aff62f11a2c11f5d3fb8887dc5ef9f6db0c2ee8f5da5ba76aaa.php';
require_once __DIR__.'/twig/2b/2bebf2e706d147fb40884acdcefcbd9599a3cdfc57ca3b87c941d7302e163ec9.php';
require_once __DIR__.'/twig/db/db433b3433e5834f681f1a2979b0cabb5f46af138b0b88cc6821fc1fef25ad8d.php';
require_once __DIR__.'/twig/c2/c26181d9c564a949283d9e574ee1a5024af0115b7b2a3b36df445d239651b9fe.php';
require_once __DIR__.'/twig/9b/9b0adef724cf70a768f04827d0e65767426789054c1d1e2a44346a156847f230.php';
require_once __DIR__.'/twig/1d/1d8345cc939fd9ac7694e65b1ee7f22bfd3bd1957f490ad3115ebb5699209996.php';
require_once __DIR__.'/twig/81/819e5dfa1260f95bdc5df437432209d4d4a0f0f6c11052cfdc92fd5e11f44c33.php';
require_once __DIR__.'/twig/b7/b73b66028b8b1022e772b044e18bfe7a7a43cd8b51065b44dae6f805b6c186b4.php';
require_once __DIR__.'/twig/7e/7e5ae29046ff50a676b89a89128008343350eb4c0beffd7ab9eaa9f2dce06a9f.php';
require_once __DIR__.'/twig/d0/d09ff24b8f0f67ee8a4cabbb9cf37cb130bbedecdd8a9387418118f2747ebc20.php';
require_once __DIR__.'/twig/12/1292bf516a5783cd267d622f60ce905975a51eb0a1fb0e38b1514bfd262f4efa.php';
require_once __DIR__.'/twig/8b/8b0f0d5754df3bd7d47ab3c0470e1a6099822125885db144cf0587e08216bf16.php';
require_once __DIR__.'/twig/7a/7a5deebce13b72aa11f0fa3c36c91408855431da105fe3ed83c487589d7e0480.php';
require_once __DIR__.'/twig/b2/b23d4c54a4892f28664f27e711bb2b68e99bea4fb24361e711fbf53e13054dce.php';
require_once __DIR__.'/twig/2f/2fc6fcf5e38271bfecd5cc540b6b1119578634246fd9ee25513a970ef2362bae.php';
require_once __DIR__.'/twig/00/006a899a4838a781bba54c5c62918e9c62a7a33c19f7e58396046696e0999926.php';
require_once __DIR__.'/twig/a3/a3c074b1db0f67019edecce2befce5e5b52306284b539d013910e3a7e76a2c11.php';
require_once __DIR__.'/twig/ac/ac76ed18a7ad30992f522bfb76f214fb56080a57a903c709832bdc9cb6319bc6.php';
require_once __DIR__.'/twig/7e/7ee1577999fb4e2c9029b55f40cb2e35c12a0e17f5e9eaa7fd999553bb7b6374.php';
require_once __DIR__.'/twig/71/719a32a4cd8849f026cf26241e01cb03762371a1a8c0b3ed67075127690493b8.php';
require_once __DIR__.'/twig/6e/6eeb88a1283584f9632da0e74589b0c7ead31c318f16ff9aad857ca28f9e7405.php';

$classes = [];
$classes[] = 'Symfony\\Component\\Routing\\Generator\\CompiledUrlGenerator';
$classes[] = 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableCompiledUrlMatcher';
$classes[] = 'Symfony\\Component\\Routing\\Annotation\\Route';
$classes[] = 'Doctrine\\ORM\\Mapping\\Entity';
$classes[] = 'Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntity';
$classes[] = 'Doctrine\\ORM\\Mapping\\Id';
$classes[] = 'Doctrine\\ORM\\Mapping\\GeneratedValue';
$classes[] = 'Doctrine\\ORM\\Mapping\\Column';
$classes[] = 'Symfony\\Component\\Validator\\Constraints\\Regex';
$classes[] = 'Symfony\\Component\\Validator\\Constraints\\Length';
$classes[] = 'Symfony\\Component\\Validator\\Constraints\\NotBlank';
$classes[] = 'Doctrine\\ORM\\Mapping\\Table';
$classes[] = 'Doctrine\\ORM\\Mapping\\Index';
$classes[] = 'Doctrine\\ORM\\Mapping\\MappedSuperclass';
$classes[] = 'Doctrine\\ORM\\Mapping\\UniqueConstraint';
$preloaded = Preloader::preload($classes, $preloaded);
