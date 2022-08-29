<?php

namespace ContainerAeEyAl0;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder50675 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer56b04 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties2a28b = [
        
    ];

    public function getConnection()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getConnection', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getMetadataFactory', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getExpressionBuilder', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'beginTransaction', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getCache', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getCache();
    }

    public function transactional($func)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'transactional', array('func' => $func), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'wrapInTransaction', array('func' => $func), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'commit', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->commit();
    }

    public function rollback()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'rollback', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getClassMetadata', array('className' => $className), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'createQuery', array('dql' => $dql), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'createNamedQuery', array('name' => $name), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'createQueryBuilder', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'flush', array('entity' => $entity), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'clear', array('entityName' => $entityName), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->clear($entityName);
    }

    public function close()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'close', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->close();
    }

    public function persist($entity)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'persist', array('entity' => $entity), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'remove', array('entity' => $entity), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'refresh', array('entity' => $entity), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'detach', array('entity' => $entity), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'merge', array('entity' => $entity), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getRepository', array('entityName' => $entityName), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'contains', array('entity' => $entity), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getEventManager', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getConfiguration', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'isOpen', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getUnitOfWork', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getProxyFactory', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'initializeObject', array('obj' => $obj), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'getFilters', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'isFiltersStateClean', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'hasFilters', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return $this->valueHolder50675->hasFilters();
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

        $instance->initializer56b04 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config)
    {
        static $reflection;

        if (! $this->valueHolder50675) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder50675 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder50675->__construct($conn, $config);
    }

    public function & __get($name)
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, '__get', ['name' => $name], $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        if (isset(self::$publicProperties2a28b[$name])) {
            return $this->valueHolder50675->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder50675;

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

        $targetObject = $this->valueHolder50675;
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
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder50675;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder50675;
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
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, '__isset', array('name' => $name), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder50675;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder50675;
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
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, '__unset', array('name' => $name), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder50675;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder50675;
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
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, '__clone', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        $this->valueHolder50675 = clone $this->valueHolder50675;
    }

    public function __sleep()
    {
        $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, '__sleep', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;

        return array('valueHolder50675');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer56b04 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer56b04;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer56b04 && ($this->initializer56b04->__invoke($valueHolder50675, $this, 'initializeProxy', array(), $this->initializer56b04) || 1) && $this->valueHolder50675 = $valueHolder50675;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder50675;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder50675;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
