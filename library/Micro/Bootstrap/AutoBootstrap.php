<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Bootstrap;

use Micro\Config\ArrayConfig,
    Micro\Exception\ConfigException,
    InvalidArgumentException,
    LogicException;

/**
 * @category  Epixa
 * @package   Bootstrap
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
abstract class AutoBootstrap implements Bootstrappable
{
    /**
     * @var array
     */
    protected $_config = array();
    
    /**
     * @var array
     */
    protected $_resources = array();
    
    /**
     *
     * @var array
     */
    protected $_bootstrappedResources = array();
    
    
    /**
     * Sets up the application path and environment constants and loads the 
     * appropriate config
     * 
     * @param string $appPath 
     */
    public function __construct($appPath)
    {
        if (!defined('APPLICATION_PATH')) {
            if (!file_exists($appPath)) {
                throw new InvalidArgumentException(sprintf(
                    'Application path `%s` does not exist', $appPath
                ));
            }
            define('APPLICATION_PATH', $appPath);
        }
        
        if (!defined('APPLICATION_ENV')) {
            define('APPLICATION_ENV', 'production');
        }
        
        $configPath = $this->_configPathFactory(APPLICATION_PATH, APPLICATION_ENV);
        $config = $this->loadConfig($configPath);
        $this->setConfig($config);
    }
    
    /**
     * Sets the application's config
     * 
     * @param  ArrayConfig $config
     * @return AutoBootstrap *Fluent interface*
     */
    public function setConfig(ArrayConfig $config)
    {
        $this->_config = $config;
        
        return $this;
    }
    
    /**
     * Gets the application's config
     * 
     * If the optional name is specified, then return that specific config 
     * section.  If the given name does not exist, then null is returned.
     * 
     * @param  null|string $name
     * @return mixed
     */
    public function getConfig($name = null)
    {
        if ($name !== null) {
            return isset($this->_config[$name])
                 ? $this->_config[$name]
                 : null;
        }
        
        return $this->_config;
    }
    
    /**
     * Sets the resources to bootstrap
     * 
     * @param  array $resources
     * @return AutoBootstrap *Fluent interface*
     */
    public function setResources(array $resources)
    {
        $this->_resources = $resources;
        
        return $this;
    }
    
    /**
     * Gets the resources to bootstrap
     * 
     * @return array
     */
    public function getResources()
    {
        return $this->_resources;
    }
    
    /**
     * Bootstraps all of the set resources
     * 
     * @return AutoBootstrap *Fluent interface*
     */
    public function bootstrap()
    {
        foreach ($this->getResources() as $resource) {
            $this->bootstrapResource($resource);
        }
        
        return $this;
    }
    
    /**
     * Bootstrap a specific resource
     * 
     * @param  string $resource
     * @return mixed
     */
    public function bootstrapResource($resource)
    {
        $resource = strtolower($resource);
        
        if (!array_key_exists($resource, $this->_bootstrappedResources)) {
            $method = $this->_resourceMethodFactory($resource);
            if (!method_exists($this, $method)) {
                throw new ConfigException(sprintf(
                    'Bootstrapping resource `%s` does not exist', $resource
                ));
            }

            $this->_bootstrappedResources[$resource] = $this->$method();
        }
        
        return $this->_bootstrappedResources[$resource];
    }
    
    /**
     * Load an array configuration from the given file path
     * 
     * @param  string $configPath
     * @return ArrayConfig
     * @throws InvalidArgumentException If the config file does not exist
     * @throws LogicException           If the file does not return an array
     */
    public function loadConfig($configPath)
    {
        if (!file_exists($configPath)) {
            throw new InvalidArgumentException(sprintf(
                'Config file located at `%s` does not exist', $configPath
            ));
        }
        
        $config = include $configPath;
        if (!is_array($config)) {
            throw new LogicException('Invalid config format');
        }
        
        return new ArrayConfig($config);
    }
    
    /**
     * Runs the application
     */
    abstract public function run();
    
    
    /**
     * Creates the appropriate config path for the given application
     * 
     * @param  string $appPath
     * @param  string $appEnv
     * @return string
     */
    protected function _configPathFactory($appPath, $appEnv)
    {
        return $appPath . '/config/' . $appEnv . '.php';
    }
    
    /**
     * Creates the appropriate method name for the given resource
     * 
     * @param  string $resource
     * @return string
     */
    protected function _resourceMethodFactory($resource)
    {
        return '_init' . str_replace(' ', '', ucwords($resource));
    }
}