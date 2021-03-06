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
interface RequestInterface
{
    /**
     * Gets the name of the current action
     * 
     * @return string
     */
    public function getAction();
    
    /**
     * Gets the name of the current controller
     * 
     * @return string
     */
    public function getController();
    
    /**
     * Gets the parameters of the current request
     * 
     * @return array
     */
    public function getParams();
}