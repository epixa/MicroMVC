<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Router;

/**
 * @category  Epixa
 * @package   Router
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class ParseResult implements ResultInterface
{
    /**
     * @var string
     */
    protected $_controller;
    
    /**
     * @var string
     */
    protected $_action;
    
    /**
     * @var array
     */
    protected $_params = array();
    
    
    /**
     * Constructor
     * 
     * Sets the controller, action, and additional params of this router result
     * 
     * @param string $controller
     * @param string $action
     * @param array  $params 
     */
    public function __construct($controller, $action, array $params)
    {
        $this->_controller = (string)$controller;
        $this->_action = (string)$action;
        $this->_params = $params;
    }
    
    /**
     * Gets the name of the controller
     * 
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }
    
    /**
     * Gets the name of the action
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }
    
    /**
     * Gets any and all additional params
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
}