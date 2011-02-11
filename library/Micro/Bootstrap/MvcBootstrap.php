<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Bootstrap;

use Micro\Request\HttpRequest,
    Micro\Response\HttpResponse,
    Micro\Dispatcher\MvcDispatcher,
    Micro\Exception\ConfigException;

/**
 * @category  Epixa
 * @package   Bootstrap
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class MvcBootstrap extends AutoBootstrap
{
    /**
     * {@inheritdoc}
     * 
     * Since this is an MVC request, the response and request resources are 
     * automatically added.
     * 
     * @param string $configPath 
     */
    public function __construct($configPath)
    {
        parent::__construct($configPath);
        
        $config = $this->getConfig();
        
        $resources = array('request', 'response', 'dispatcher');
        if (isset($config['resources']) && is_array($config['resources'])) {
            unset($config['resources'], $config['response']);
            $resources = array_merge($config['resources'], $resources);
        }
        
        unset($config['resources']);
        
        $this->setResources($resources);
    }
    
    
    /**
     * Initializes the application's request object
     * 
     * @return HttpRequest
     */
    protected function _initRequest()
    {
        $request = new HttpRequest();
        
        // todo: get the action and controller from the uri (router?)
        
        return $request;
    }
    
    /**
     * Initializes the application's response object
     * 
     * @return HttpResponse
     */
    protected function _initResponse()
    {
        return new HttpResponse();
    }
    
    /**
     * Initializes the application's dispatcher object
     * 
     * @return MvcDispatcher
     */
    protected function _initDispatcher()
    {
        $config = $this->getConfig('dispatcher');
        if (isset($config['controller_path'])) {
            $path = (string)$config['controller_path'];
        } else if (defined('APPLICATION_PATH')) {
            $path = APPLICATION_PATH;
        } else {
            throw new ConfigException('Cannot determine controller path');
        }
        
        return new MvcDispatcher($path);
    }
    
    /**
     * Runs the application
     */
    public function run()
    {
        $dispatcher = $this->bootstrapResource('dispatcher');
        $request = $this->bootstrapResource('request');
        $response = $this->bootstrapResource('response');
        
        $dispatcher->dispatch($request, $response);
    }
}