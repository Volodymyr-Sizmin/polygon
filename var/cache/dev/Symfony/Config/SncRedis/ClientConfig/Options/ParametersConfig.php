<?php

namespace Symfony\Config\SncRedis\ClientConfig\Options;


use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;


/**
 * This class is automatically generated to help in creating a config.
 */
class ParametersConfig 
{
    private $database;
    private $username;
    private $password;
    private $logging;
    private $sslContext;
    private $_usedProperties = [];
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function database($value): self
    {
        $this->_usedProperties['database'] = true;
        $this->database = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function username($value): self
    {
        $this->_usedProperties['username'] = true;
        $this->username = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function password($value): self
    {
        $this->_usedProperties['password'] = true;
        $this->password = $value;
    
        return $this;
    }
    
    /**
     * @default true
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function logging($value): self
    {
        $this->_usedProperties['logging'] = true;
        $this->logging = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function sslContext($value = NULL): self
    {
        $this->_usedProperties['sslContext'] = true;
        $this->sslContext = $value;
    
        return $this;
    }
    
    public function __construct(array $value = [])
    {
    
        if (array_key_exists('database', $value)) {
            $this->_usedProperties['database'] = true;
            $this->database = $value['database'];
            unset($value['database']);
        }
    
        if (array_key_exists('username', $value)) {
            $this->_usedProperties['username'] = true;
            $this->username = $value['username'];
            unset($value['username']);
        }
    
        if (array_key_exists('password', $value)) {
            $this->_usedProperties['password'] = true;
            $this->password = $value['password'];
            unset($value['password']);
        }
    
        if (array_key_exists('logging', $value)) {
            $this->_usedProperties['logging'] = true;
            $this->logging = $value['logging'];
            unset($value['logging']);
        }
    
        if (array_key_exists('ssl_context', $value)) {
            $this->_usedProperties['sslContext'] = true;
            $this->sslContext = $value['ssl_context'];
            unset($value['ssl_context']);
        }
    
        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }
    
    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['database'])) {
            $output['database'] = $this->database;
        }
        if (isset($this->_usedProperties['username'])) {
            $output['username'] = $this->username;
        }
        if (isset($this->_usedProperties['password'])) {
            $output['password'] = $this->password;
        }
        if (isset($this->_usedProperties['logging'])) {
            $output['logging'] = $this->logging;
        }
        if (isset($this->_usedProperties['sslContext'])) {
            $output['ssl_context'] = $this->sslContext;
        }
    
        return $output;
    }

}
