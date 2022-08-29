<?php

namespace Symfony\Config;

require_once __DIR__.\DIRECTORY_SEPARATOR.'ZenstruckFoundry'.\DIRECTORY_SEPARATOR.'FakerConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'ZenstruckFoundry'.\DIRECTORY_SEPARATOR.'InstantiatorConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;


/**
 * This class is automatically generated to help in creating a config.
 */
class ZenstruckFoundryConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $autoRefreshProxies;
    private $faker;
    private $instantiator;
    private $_usedProperties = [];
    
    /**
     * Whether to auto-refresh proxies by default (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#auto-refresh)
     * @default null
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function autoRefreshProxies($value): self
    {
        $this->_usedProperties['autoRefreshProxies'] = true;
        $this->autoRefreshProxies = $value;
    
        return $this;
    }
    
    public function faker(array $value = []): \Symfony\Config\ZenstruckFoundry\FakerConfig
    {
        if (null === $this->faker) {
            $this->_usedProperties['faker'] = true;
            $this->faker = new \Symfony\Config\ZenstruckFoundry\FakerConfig($value);
        } elseif ([] !== $value) {
            throw new InvalidConfigurationException('The node created by "faker()" has already been initialized. You cannot pass values the second time you call faker().');
        }
    
        return $this->faker;
    }
    
    public function instantiator(array $value = []): \Symfony\Config\ZenstruckFoundry\InstantiatorConfig
    {
        if (null === $this->instantiator) {
            $this->_usedProperties['instantiator'] = true;
            $this->instantiator = new \Symfony\Config\ZenstruckFoundry\InstantiatorConfig($value);
        } elseif ([] !== $value) {
            throw new InvalidConfigurationException('The node created by "instantiator()" has already been initialized. You cannot pass values the second time you call instantiator().');
        }
    
        return $this->instantiator;
    }
    
    public function getExtensionAlias(): string
    {
        return 'zenstruck_foundry';
    }
    
    public function __construct(array $value = [])
    {
    
        if (array_key_exists('auto_refresh_proxies', $value)) {
            $this->_usedProperties['autoRefreshProxies'] = true;
            $this->autoRefreshProxies = $value['auto_refresh_proxies'];
            unset($value['auto_refresh_proxies']);
        }
    
        if (array_key_exists('faker', $value)) {
            $this->_usedProperties['faker'] = true;
            $this->faker = new \Symfony\Config\ZenstruckFoundry\FakerConfig($value['faker']);
            unset($value['faker']);
        }
    
        if (array_key_exists('instantiator', $value)) {
            $this->_usedProperties['instantiator'] = true;
            $this->instantiator = new \Symfony\Config\ZenstruckFoundry\InstantiatorConfig($value['instantiator']);
            unset($value['instantiator']);
        }
    
        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }
    
    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['autoRefreshProxies'])) {
            $output['auto_refresh_proxies'] = $this->autoRefreshProxies;
        }
        if (isset($this->_usedProperties['faker'])) {
            $output['faker'] = $this->faker->toArray();
        }
        if (isset($this->_usedProperties['instantiator'])) {
            $output['instantiator'] = $this->instantiator->toArray();
        }
    
        return $output;
    }

}
