<?php

namespace ContainerAJMzacJ;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderae495 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerbd569 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties56fad = [
        
    ];

    public function getConnection()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getConnection', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getMetadataFactory', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getExpressionBuilder', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'beginTransaction', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getCache', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getCache();
    }

    public function transactional($func)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'transactional', array('func' => $func), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'wrapInTransaction', array('func' => $func), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'commit', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->commit();
    }

    public function rollback()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'rollback', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getClassMetadata', array('className' => $className), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'createQuery', array('dql' => $dql), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'createNamedQuery', array('name' => $name), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'createQueryBuilder', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'flush', array('entity' => $entity), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'clear', array('entityName' => $entityName), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->clear($entityName);
    }

    public function close()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'close', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->close();
    }

    public function persist($entity)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'persist', array('entity' => $entity), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'remove', array('entity' => $entity), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'refresh', array('entity' => $entity), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'detach', array('entity' => $entity), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'merge', array('entity' => $entity), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getRepository', array('entityName' => $entityName), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'contains', array('entity' => $entity), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getEventManager', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getConfiguration', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'isOpen', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getUnitOfWork', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getProxyFactory', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'initializeObject', array('obj' => $obj), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'getFilters', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'isFiltersStateClean', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'hasFilters', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return $this->valueHolderae495->hasFilters();
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

        $instance->initializerbd569 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config)
    {
        static $reflection;

        if (! $this->valueHolderae495) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderae495 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderae495->__construct($conn, $config);
    }

    public function & __get($name)
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, '__get', ['name' => $name], $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        if (isset(self::$publicProperties56fad[$name])) {
            return $this->valueHolderae495->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderae495;

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

        $targetObject = $this->valueHolderae495;
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
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderae495;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderae495;
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
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, '__isset', array('name' => $name), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderae495;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderae495;
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
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, '__unset', array('name' => $name), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderae495;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderae495;
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
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, '__clone', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        $this->valueHolderae495 = clone $this->valueHolderae495;
    }

    public function __sleep()
    {
        $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, '__sleep', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;

        return array('valueHolderae495');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerbd569 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerbd569;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerbd569 && ($this->initializerbd569->__invoke($valueHolderae495, $this, 'initializeProxy', array(), $this->initializerbd569) || 1) && $this->valueHolderae495 = $valueHolderae495;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderae495;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderae495;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
