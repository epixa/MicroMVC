<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Request;

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
    protected $_action = 'default';
    
    /**
     * @var string
     */
    protected $_controller = 'default';
    
    
    /**
     * Set the name of the current action
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
     * Get the name of the current action
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }
    
    /**
     * Set the name of the current controller
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
     * Get the name of the current controller
     * 
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }
}