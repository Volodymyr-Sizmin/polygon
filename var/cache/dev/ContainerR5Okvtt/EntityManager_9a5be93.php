<?php

namespace ContainerR5Okvtt;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderb9bbf = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer43ae2 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesb6e58 = [
        
    ];

    public function getConnection()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getConnection', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getMetadataFactory', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getExpressionBuilder', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'beginTransaction', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getCache', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getCache();
    }

    public function transactional($func)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'transactional', array('func' => $func), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'wrapInTransaction', array('func' => $func), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'commit', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->commit();
    }

    public function rollback()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'rollback', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getClassMetadata', array('className' => $className), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'createQuery', array('dql' => $dql), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'createNamedQuery', array('name' => $name), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'createQueryBuilder', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'flush', array('entity' => $entity), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'clear', array('entityName' => $entityName), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->clear($entityName);
    }

    public function close()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'close', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->close();
    }

    public function persist($entity)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'persist', array('entity' => $entity), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'remove', array('entity' => $entity), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'refresh', array('entity' => $entity), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'detach', array('entity' => $entity), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'merge', array('entity' => $entity), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getRepository', array('entityName' => $entityName), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'contains', array('entity' => $entity), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getEventManager', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getConfiguration', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'isOpen', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getUnitOfWork', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getProxyFactory', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'initializeObject', array('obj' => $obj), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'getFilters', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'isFiltersStateClean', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'hasFilters', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return $this->valueHolderb9bbf->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer43ae2 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config)
    {
        static $reflection;

        if (! $this->valueHolderb9bbf) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderb9bbf = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderb9bbf->__construct($conn, $config);
    }

    public function & __get($name)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, '__get', ['name' => $name], $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        if (isset(self::$publicPropertiesb6e58[$name])) {
            return $this->valueHolderb9bbf->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderb9bbf;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderb9bbf;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderb9bbf;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderb9bbf;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, '__isset', array('name' => $name), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderb9bbf;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderb9bbf;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, '__unset', array('name' => $name), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderb9bbf;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderb9bbf;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, '__clone', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        $this->valueHolderb9bbf = clone $this->valueHolderb9bbf;
    }

    public function __sleep()
    {
        $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, '__sleep', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;

        return array('valueHolderb9bbf');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer43ae2 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer43ae2;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer43ae2 && ($this->initializer43ae2->__invoke($valueHolderb9bbf, $this, 'initializeProxy', array(), $this->initializer43ae2) || 1) && $this->valueHolderb9bbf = $valueHolderb9bbf;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderb9bbf;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderb9bbf;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
