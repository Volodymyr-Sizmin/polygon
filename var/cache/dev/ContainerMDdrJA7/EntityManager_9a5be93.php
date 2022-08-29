<?php

namespace ContainerMDdrJA7;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder46d8d = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerc2656 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesc20f1 = [
        
    ];

    public function getConnection()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getConnection', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getMetadataFactory', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getExpressionBuilder', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'beginTransaction', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getCache', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getCache();
    }

    public function transactional($func)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'transactional', array('func' => $func), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'wrapInTransaction', array('func' => $func), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'commit', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->commit();
    }

    public function rollback()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'rollback', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getClassMetadata', array('className' => $className), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'createQuery', array('dql' => $dql), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'createNamedQuery', array('name' => $name), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'createQueryBuilder', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'flush', array('entity' => $entity), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'clear', array('entityName' => $entityName), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->clear($entityName);
    }

    public function close()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'close', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->close();
    }

    public function persist($entity)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'persist', array('entity' => $entity), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'remove', array('entity' => $entity), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'refresh', array('entity' => $entity), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'detach', array('entity' => $entity), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'merge', array('entity' => $entity), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getRepository', array('entityName' => $entityName), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'contains', array('entity' => $entity), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getEventManager', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getConfiguration', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'isOpen', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getUnitOfWork', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getProxyFactory', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'initializeObject', array('obj' => $obj), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'getFilters', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'isFiltersStateClean', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'hasFilters', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return $this->valueHolder46d8d->hasFilters();
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

        $instance->initializerc2656 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config)
    {
        static $reflection;

        if (! $this->valueHolder46d8d) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder46d8d = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder46d8d->__construct($conn, $config);
    }

    public function & __get($name)
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, '__get', ['name' => $name], $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        if (isset(self::$publicPropertiesc20f1[$name])) {
            return $this->valueHolder46d8d->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder46d8d;

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

        $targetObject = $this->valueHolder46d8d;
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
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder46d8d;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder46d8d;
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
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, '__isset', array('name' => $name), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder46d8d;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder46d8d;
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
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, '__unset', array('name' => $name), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder46d8d;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder46d8d;
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
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, '__clone', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        $this->valueHolder46d8d = clone $this->valueHolder46d8d;
    }

    public function __sleep()
    {
        $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, '__sleep', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;

        return array('valueHolder46d8d');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerc2656 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerc2656;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerc2656 && ($this->initializerc2656->__invoke($valueHolder46d8d, $this, 'initializeProxy', array(), $this->initializerc2656) || 1) && $this->valueHolder46d8d = $valueHolder46d8d;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder46d8d;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder46d8d;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
