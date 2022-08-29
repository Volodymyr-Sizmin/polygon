<?php

namespace Symfony\Config\SncRedis;

require_once __DIR__.\DIRECTORY_SEPARATOR.'ClientConfig'.\DIRECTORY_SEPARATOR.'OptionsConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;


/**
 * This class is automatically generated to help in creating a config.
 */
class ClientConfig 
{
    private $type;
    private $alias;
    private $logging;
    private $dsns;
    private $options;
    private $_usedProperties = [];
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function type($value): self
    {
        $this->_usedProperties['type'] = true;
        $this->type = $value;
    
        return $this;
    }
    
    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function alias($value): self
    {
        $this->_usedProperties['alias'] = true;
        $this->alias = $value;
    
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
     * @param ParamConfigurator|list<mixed|ParamConfigurator> $value
     * @return $this
     */
    public function dsns($value): self
    {
        $this->_usedProperties['dsns'] = true;
        $this->dsns = $value;
    
        return $this;
    }
    
    public function options(array $value = []): \Symfony\Config\SncRedis\ClientConfig\OptionsConfig
    {
        if (null === $this->options) {
            $this->_usedProperties['options'] = true;
            $this->options = new \Symfony\Config\SncRedis\ClientConfig\OptionsConfig($value);
        } elseif ([] !== $value) {
            throw new InvalidConfigurationException('The node created by "options()" has already been initialized. You cannot pass values the second time you call options().');
        }
    
        return $this->options;
    }
    
    public function __construct(array $value = [])
    {
    
        if (array_key_exists('type', $value)) {
            $this->_usedProperties['type'] = true;
            $this->type = $value['type'];
            unset($value['type']);
        }
    
        if (array_key_exists('alias', $value)) {
            $this->_usedProperties['alias'] = true;
            $this->alias = $value['alias'];
            unset($value['alias']);
        }
    
        if (array_key_exists('logging', $value)) {
            $this->_usedProperties['logging'] = true;
            $this->logging = $value['logging'];
            unset($value['logging']);
        }
    
        if (array_key_exists('dsns', $value)) {
            $this->_usedProperties['dsns'] = true;
            $this->dsns = $value['dsns'];
            unset($value['dsns']);
        }
    
        if (array_key_exists('options', $value)) {
            $this->_usedProperties['options'] = true;
            $this->options = new \Symfony\Config\SncRedis\ClientConfig\OptionsConfig($value['options']);
            unset($value['options']);
        }
    
        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }
    
    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['type'])) {
            $output['type'] = $this->type;
        }
        if (isset($this->_usedProperties['alias'])) {
            $output['alias'] = $this->alias;
        }
        if (isset($this->_usedProperties['logging'])) {
            $output['logging'] = $this->logging;
        }
        if (isset($this->_usedProperties['dsns'])) {
            $output['dsns'] = $this->dsns;
        }
        if (isset($this->_usedProperties['options'])) {
            $output['options'] = $this->options->toArray();
        }
    
        return $output;
    }

}
