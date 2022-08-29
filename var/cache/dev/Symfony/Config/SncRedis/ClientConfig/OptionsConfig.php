<?php

namespace Symfony\Config\SncRedis\ClientConfig;

require_once __DIR__.\DIRECTORY_SEPARATOR.'Options'.\DIRECTORY_SEPARATOR.'ParametersConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;


/**
 * This class is automatically generated to help in creating a config.
 */
class OptionsConfig 
{
    private $connectionAsync;
    private $connectionPersistent;
    private $connectionTimeout;
    private $readWriteTimeout;
    private $iterableMultibulk;
    private $throwErrors;
    private $serialization;
    private $profile;
    private $cluster;
    private $prefix;
    private $replication;
    private $service;
    private $slaveFailover;
    private $parameters;
    private $_usedProperties = [];
    
    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function connectionAsync($value): self
    {
        $this->_usedProperties['connectionAsync'] = true;
        $this->connectionAsync = $value;
    
        return $this;
    }
    
    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function connectionPersistent($value): self
    {
        $this->_usedProperties['connectionPersistent'] = true;
        $this->connectionPersistent = $value;
    
        return $this;
    }
    
    /**
     * @default 5
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function connectionTimeout($value): self
    {
        $this->_usedProperties['connectionTimeout'] = true;
        $this->connectionTimeout = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function readWriteTimeout($value): self
    {
        $this->_usedProperties['readWriteTimeout'] = true;
        $this->readWriteTimeout = $value;
    
        return $this;
    }
    
    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function iterableMultibulk($value): self
    {
        $this->_usedProperties['iterableMultibulk'] = true;
        $this->iterableMultibulk = $value;
    
        return $this;
    }
    
    /**
     * @default true
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function throwErrors($value): self
    {
        $this->_usedProperties['throwErrors'] = true;
        $this->throwErrors = $value;
    
        return $this;
    }
    
    /**
     * @default 'default'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function serialization($value): self
    {
        $this->_usedProperties['serialization'] = true;
        $this->serialization = $value;
    
        return $this;
    }
    
    /**
     * @default 'default'
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function profile($value): self
    {
        $this->_usedProperties['profile'] = true;
        $this->profile = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function cluster($value): self
    {
        $this->_usedProperties['cluster'] = true;
        $this->cluster = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function prefix($value): self
    {
        $this->_usedProperties['prefix'] = true;
        $this->prefix = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|true|false|'sentinel' $value
     * @return $this
     */
    public function replication($value): self
    {
        $this->_usedProperties['replication'] = true;
        $this->replication = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function service($value): self
    {
        $this->_usedProperties['service'] = true;
        $this->service = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|'none'|'error'|'distribute'|'distribute_slaves' $value
     * @return $this
     */
    public function slaveFailover($value): self
    {
        $this->_usedProperties['slaveFailover'] = true;
        $this->slaveFailover = $value;
    
        return $this;
    }
    
    public function parameters(array $value = []): \Symfony\Config\SncRedis\ClientConfig\Options\ParametersConfig
    {
        if (null === $this->parameters) {
            $this->_usedProperties['parameters'] = true;
            $this->parameters = new \Symfony\Config\SncRedis\ClientConfig\Options\ParametersConfig($value);
        } elseif ([] !== $value) {
            throw new InvalidConfigurationException('The node created by "parameters()" has already been initialized. You cannot pass values the second time you call parameters().');
        }
    
        return $this->parameters;
    }
    
    public function __construct(array $value = [])
    {
    
        if (array_key_exists('connection_async', $value)) {
            $this->_usedProperties['connectionAsync'] = true;
            $this->connectionAsync = $value['connection_async'];
            unset($value['connection_async']);
        }
    
        if (array_key_exists('connection_persistent', $value)) {
            $this->_usedProperties['connectionPersistent'] = true;
            $this->connectionPersistent = $value['connection_persistent'];
            unset($value['connection_persistent']);
        }
    
        if (array_key_exists('connection_timeout', $value)) {
            $this->_usedProperties['connectionTimeout'] = true;
            $this->connectionTimeout = $value['connection_timeout'];
            unset($value['connection_timeout']);
        }
    
        if (array_key_exists('read_write_timeout', $value)) {
            $this->_usedProperties['readWriteTimeout'] = true;
            $this->readWriteTimeout = $value['read_write_timeout'];
            unset($value['read_write_timeout']);
        }
    
        if (array_key_exists('iterable_multibulk', $value)) {
            $this->_usedProperties['iterableMultibulk'] = true;
            $this->iterableMultibulk = $value['iterable_multibulk'];
            unset($value['iterable_multibulk']);
        }
    
        if (array_key_exists('throw_errors', $value)) {
            $this->_usedProperties['throwErrors'] = true;
            $this->throwErrors = $value['throw_errors'];
            unset($value['throw_errors']);
        }
    
        if (array_key_exists('serialization', $value)) {
            $this->_usedProperties['serialization'] = true;
            $this->serialization = $value['serialization'];
            unset($value['serialization']);
        }
    
        if (array_key_exists('profile', $value)) {
            $this->_usedProperties['profile'] = true;
            $this->profile = $value['profile'];
            unset($value['profile']);
        }
    
        if (array_key_exists('cluster', $value)) {
            $this->_usedProperties['cluster'] = true;
            $this->cluster = $value['cluster'];
            unset($value['cluster']);
        }
    
        if (array_key_exists('prefix', $value)) {
            $this->_usedProperties['prefix'] = true;
            $this->prefix = $value['prefix'];
            unset($value['prefix']);
        }
    
        if (array_key_exists('replication', $value)) {
            $this->_usedProperties['replication'] = true;
            $this->replication = $value['replication'];
            unset($value['replication']);
        }
    
        if (array_key_exists('service', $value)) {
            $this->_usedProperties['service'] = true;
            $this->service = $value['service'];
            unset($value['service']);
        }
    
        if (array_key_exists('slave_failover', $value)) {
            $this->_usedProperties['slaveFailover'] = true;
            $this->slaveFailover = $value['slave_failover'];
            unset($value['slave_failover']);
        }
    
        if (array_key_exists('parameters', $value)) {
            $this->_usedProperties['parameters'] = true;
            $this->parameters = new \Symfony\Config\SncRedis\ClientConfig\Options\ParametersConfig($value['parameters']);
            unset($value['parameters']);
        }
    
        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }
    
    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['connectionAsync'])) {
            $output['connection_async'] = $this->connectionAsync;
        }
        if (isset($this->_usedProperties['connectionPersistent'])) {
            $output['connection_persistent'] = $this->connectionPersistent;
        }
        if (isset($this->_usedProperties['connectionTimeout'])) {
            $output['connection_timeout'] = $this->connectionTimeout;
        }
        if (isset($this->_usedProperties['readWriteTimeout'])) {
            $output['read_write_timeout'] = $this->readWriteTimeout;
        }
        if (isset($this->_usedProperties['iterableMultibulk'])) {
            $output['iterable_multibulk'] = $this->iterableMultibulk;
        }
        if (isset($this->_usedProperties['throwErrors'])) {
            $output['throw_errors'] = $this->throwErrors;
        }
        if (isset($this->_usedProperties['serialization'])) {
            $output['serialization'] = $this->serialization;
        }
        if (isset($this->_usedProperties['profile'])) {
            $output['profile'] = $this->profile;
        }
        if (isset($this->_usedProperties['cluster'])) {
            $output['cluster'] = $this->cluster;
        }
        if (isset($this->_usedProperties['prefix'])) {
            $output['prefix'] = $this->prefix;
        }
        if (isset($this->_usedProperties['replication'])) {
            $output['replication'] = $this->replication;
        }
        if (isset($this->_usedProperties['service'])) {
            $output['service'] = $this->service;
        }
        if (isset($this->_usedProperties['slaveFailover'])) {
            $output['slave_failover'] = $this->slaveFailover;
        }
        if (isset($this->_usedProperties['parameters'])) {
            $output['parameters'] = $this->parameters->toArray();
        }
    
        return $output;
    }

}
