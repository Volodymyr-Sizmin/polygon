<?php

namespace ContainerNGyaF9P;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderf1b62 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer62778 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties82c6b = [
        
    ];

    public function getConnection()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getConnection', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getMetadataFactory', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getExpressionBuilder', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'beginTransaction', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getCache', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getCache();
    }

    public function transactional($func)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'transactional', array('func' => $func), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'wrapInTransaction', array('func' => $func), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'commit', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->commit();
    }

    public function rollback()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'rollback', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getClassMetadata', array('className' => $className), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'createQuery', array('dql' => $dql), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'createNamedQuery', array('name' => $name), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'createQueryBuilder', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'flush', array('entity' => $entity), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'clear', array('entityName' => $entityName), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->clear($entityName);
    }

    public function close()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'close', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->close();
    }

    public function persist($entity)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'persist', array('entity' => $entity), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'remove', array('entity' => $entity), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'refresh', array('entity' => $entity), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'detach', array('entity' => $entity), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'merge', array('entity' => $entity), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getRepository', array('entityName' => $entityName), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'contains', array('entity' => $entity), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getEventManager', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getConfiguration', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'isOpen', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getUnitOfWork', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getProxyFactory', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'initializeObject', array('obj' => $obj), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'getFilters', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'isFiltersStateClean', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'hasFilters', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return $this->valueHolderf1b62->hasFilters();
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

        $instance->initializer62778 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config)
    {
        static $reflection;

        if (! $this->valueHolderf1b62) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderf1b62 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderf1b62->__construct($conn, $config);
    }

    public function & __get($name)
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, '__get', ['name' => $name], $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        if (isset(self::$publicProperties82c6b[$name])) {
            return $this->valueHolderf1b62->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf1b62;

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

        $targetObject = $this->valueHolderf1b62;
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
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf1b62;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderf1b62;
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
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, '__isset', array('name' => $name), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf1b62;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderf1b62;
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
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, '__unset', array('name' => $name), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf1b62;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderf1b62;
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
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, '__clone', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        $this->valueHolderf1b62 = clone $this->valueHolderf1b62;
    }

    public function __sleep()
    {
        $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, '__sleep', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;

        return array('valueHolderf1b62');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer62778 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer62778;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer62778 && ($this->initializer62778->__invoke($valueHolderf1b62, $this, 'initializeProxy', array(), $this->initializer62778) || 1) && $this->valueHolderf1b62 = $valueHolderf1b62;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderf1b62;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderf1b62;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
