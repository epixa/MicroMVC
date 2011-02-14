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
interface ResultInterface
{
    /**
     * Gets the name of the controller
     * 
     * @return string
     */
    public function getController();
    
    /**
     * Gets the name of the action
     * 
     * @return string
     */
    public function getAction();
    
    /**
     * Gets any and all additional params
     * 
     * @return array
     */
    public function getParams();
}