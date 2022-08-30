<?php

namespace ContainerEaNYjdj;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderf4699 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerd5888 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties21c4d = [
        
    ];

    public function getConnection()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getConnection', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getMetadataFactory', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getExpressionBuilder', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'beginTransaction', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getCache', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getCache();
    }

    public function transactional($func)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'transactional', array('func' => $func), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'wrapInTransaction', array('func' => $func), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'commit', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->commit();
    }

    public function rollback()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'rollback', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getClassMetadata', array('className' => $className), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'createQuery', array('dql' => $dql), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'createNamedQuery', array('name' => $name), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'createQueryBuilder', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'flush', array('entity' => $entity), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'clear', array('entityName' => $entityName), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->clear($entityName);
    }

    public function close()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'close', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->close();
    }

    public function persist($entity)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'persist', array('entity' => $entity), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'remove', array('entity' => $entity), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'refresh', array('entity' => $entity), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'detach', array('entity' => $entity), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'merge', array('entity' => $entity), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getRepository', array('entityName' => $entityName), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'contains', array('entity' => $entity), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getEventManager', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getConfiguration', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'isOpen', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getUnitOfWork', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getProxyFactory', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'initializeObject', array('obj' => $obj), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'getFilters', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'isFiltersStateClean', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'hasFilters', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return $this->valueHolderf4699->hasFilters();
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

        $instance->initializerd5888 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config)
    {
        static $reflection;

        if (! $this->valueHolderf4699) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderf4699 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderf4699->__construct($conn, $config);
    }

    public function & __get($name)
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, '__get', ['name' => $name], $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        if (isset(self::$publicProperties21c4d[$name])) {
            return $this->valueHolderf4699->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4699;

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

        $targetObject = $this->valueHolderf4699;
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
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4699;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderf4699;
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
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, '__isset', array('name' => $name), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4699;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderf4699;
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
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, '__unset', array('name' => $name), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4699;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderf4699;
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
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, '__clone', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        $this->valueHolderf4699 = clone $this->valueHolderf4699;
    }

    public function __sleep()
    {
        $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, '__sleep', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;

        return array('valueHolderf4699');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerd5888 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerd5888;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerd5888 && ($this->initializerd5888->__invoke($valueHolderf4699, $this, 'initializeProxy', array(), $this->initializerd5888) || 1) && $this->valueHolderf4699 = $valueHolderf4699;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderf4699;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderf4699;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
