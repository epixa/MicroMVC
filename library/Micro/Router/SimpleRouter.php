<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Router;

use Micro\Exception\ConfigException;

/**
 * @category  Epixa
 * @package   Router
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class SimpleRouter implements RouterInterface
{
    /**
     * @var null|string
     */
    protected $_defaultAction = null;
    
    /**
     * @var null|string
     */
    protected $_defaultController = null;
    
    
    /**
     * Sets the default action name
     * 
     * @param  string $action
     * @return BaseRouter *Fluent interface*
     */
    public function setDefaultAction($action)
    {
        $this->_defaultAction = (string)$action;
        
        return $this;
    }
    
    /**
     * Gets the default action name
     * 
     * @return string
     * @throws ConfigException If a default action name was not set
     */
    public function getDefaultAction()
    {
        if ($this->_defaultAction === null) {
            throw new ConfigException('No default action was configured');
        }
        
        return $this->_defaultAction;
    }
    
    /**
     * Sets the default controller name
     * 
     * @param  string $controller
     * @return BaseRouter *Fluent interface*
     */
    public function setDefaultController($controller)
    {
        $this->_defaultController = (string)$controller;
        
        return $this;
    }
    
    /**
     * Gets the default controller name
     * 
     * @return string
     * @throws ConfigException If a default controller name was not set
     */
    public function getDefaultController()
    {
        if ($this->_defaultController === null) {
            throw new ConfigException('No default controller was configured');
        }
        
        return $this->_defaultController;
    }
    
    /**
     * Parses the given uri agaisnt a simple scheme and returns the parse result
     * 
     * The scheme is as follows:
     *  /:controller/:action/:param1/:param2 etc
     * 
     * @param  string $uri
     * @return ParseResult
     */
    public function parseUri($uri)
    {
        $uri = trim($uri, '/');
        $segments = explode('/', $uri);
        
        $action = array_shift($segments);
        if ($action === null) {
            $action = $this->getDefaultAction();
        }
        
        $controller = array_shift($segments);
        if ($controller === null) {
            $controller = $this->getDefaultController();
        }
        
        return new ParseResult($controller, $action, $segments);
    }
}