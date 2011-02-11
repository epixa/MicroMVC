<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Response;

/**
 * Manages the compiling and rendering of an application's response
 * 
 * @category  Epixa
 * @package   Response
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
interface ResponseInterface
{
    /**
     * Appends a value to the response body
     * 
     * The content can be of any type so long as that type can be casted to a 
     * string.
     * 
     * @param  string $name
     * @param  mixed  $content
     */
    public function append($name, $content);
    
    /**
     * Prepends a value to the response body
     * 
     * The content can be of any type so long as that type can be casted to a 
     * string.
     * 
     * @param  string $name
     * @param  mixed  $content
     */
    public function prepend($name, $content);
    
    /**
     * Send the response to screen
     */
    public function send();
}