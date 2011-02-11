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
     * Set the name of the current action
     * 
     * @param  string $name
     */
    public function setAction($name);
    
    /**
     * Get the name of the current action
     */
    public function getAction();
    
    /**
     * Set the name of the current controller
     * 
     * @param  string $name
     */
    public function setController($name);
    
    /**
     * Get the name of the current controller
     */
    public function getController();
}