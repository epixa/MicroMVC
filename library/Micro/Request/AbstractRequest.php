<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Request;

use InvalidArgumentException,
    Micro\Exception\NotFoundException;

/**
 * @category  Epixa
 * @package   Request
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * @var string
     */
    protected static $_defaultAction = 'default';
    
    /**
     * @var string
     */
    protected static $_defaultController = 'default';
    
    /**
     * @var null|string
     */
    protected $_action = null;
    
    /**
     * @var null|string
     */
    protected $_controller = null;
    
    /**
     * @var array
     */
    protected $_params = array();
    
    
    /**
     * Sets the name of the default action
     * 
     * @param  string $action
     * @throws InvalidArgumentException If an invalid action name is passed
     */
    public static function setDefaultAction($action)
    {
        $action = (string)$action;
        if (!$action) {
            throw new InvalidArgumentException('Default action name cannot be empty');
        }
        
        self::$_defaultAction = $action;
    }
    
    /**
     * Gets the name of the default action
     * 
     * @return string
     */
    public static function getDefaultAction()
    {
        return self::$_defaultAction;
    }
    
    /**
     * Sets the name of the default controller
     * 
     * @param  string $controller
     * @throws InvalidArgumentException If an invalid controller name is passed
     */
    public static function setDefaultController($controller)
    {
        $controller = (string)$controller;
        if (!$controller) {
            throw new InvalidArgumentException('Default controller name cannot be empty');
        }
        
        self::$_defaultController = $controller;
    }
    
    /**
     * Gets the name of the default controller
     * 
     * @return string
     */
    public static function getDefaultController()
    {
        return self::$_defaultController;
    }
    
    /**
     * Sets the name of the current action
     * 
     * @param  string $name
     * @return AbstractRequest *Fluent interface*
     */
    public function setAction($name)
    {
        $this->_action = (string)$name;
        
        return $this;
    }
    
    /**
     * Gets the name of the current action
     * 
     * @return string
     */
    public function getAction()
    {
        if ($this->_action === null) {
            $this->setAction(self::getDefaultAction());
        }
        
        return $this->_action;
    }
    
    /**
     * Sets the name of the current controller
     * 
     * @param  string $name
     * @return AbstractRequest *Fluent interface*
     */
    public function setController($name)
    {
        $this->_controller = (string)$name;
        
        return $this;
    }
    
    /**
     * Gets the name of the current controller
     * 
     * @return string
     */
    public function getController()
    {
        if ($this->_controller === null) {
            $this->setController(self::getDefaultController());
        }
        
        return $this->_controller;
    }
    
    /**
     * Sets the parameters of this request
     * 
     * @param  array $params
     * @return AbstractRequest *Fluent interface*
     */
    public function setParams(array $params)
    {
        $this->_params = $params;
        
        return $this;
    }
    
    /**
     * Gets the parameters of this request
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
}