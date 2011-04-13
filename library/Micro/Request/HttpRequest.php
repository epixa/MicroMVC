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
class HttpRequest extends AbstractRequest
{
    /**
     * Gets the http method of the current request
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * Gets the current request uri
     * 
     * @return string
     */
    public function getRequestUri()
    {
        return $this->getServer('REQUEST_URI');
    }
    
    /**
     * Is the current request of method POST?
     * 
     * @return boolean
     */
    public function isPost()
    {
        return $this->getMethod() == 'POST';
    }
    
    /**
     * Is the current request of method GET?
     * 
     * @return boolean
     */
    public function isGet()
    {
        return $this->getMethod() == 'GET';
    }
    
    /**
     * Is the current request of method HEAD?
     * 
     * @return boolean
     */
    public function isHead()
    {
        return $this->getMethod() == 'HEAD';
    }
    
    /**
     * Is the current request of method DELETE?
     * 
     * @return boolean
     */
    public function isDelete()
    {
        return $this->getMethod() == 'DELETE';
    }
    
    /**
     * Gets value(s) from the server array
     * 
     * If $name is provided, then a specific server variable is returned.  
     * Otherwise, the entire server array is returned.
     * 
     * @param  null|string $name
     * @return mixed
     */
    public function getServer($name = null)
    {
        if ($name === null) {
            return $_SERVER;
        }
        
        return isset($_SERVER[$name]) ? $_SERVER[$name] : null;
    }
    
    /**
     * Gets value(s) from the post array
     * 
     * If $name is provided, then a specific post variable is returned.  
     * Otherwise, the entire post array is returned.
     * 
     * @param  null|string $name
     * @return mixed
     */
    public function getPost($name = null)
    {
        if ($name === null) {
            return $_POST;
        }
        
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }
    
    /**
     * Gets value(s) from the get (query) array
     * 
     * If $name is provided, then a specific get variable is returned.  
     * Otherwise, the entire get array is returned.
     * 
     * @param  null|string $name
     * @return mixed
     */
    public function getQuery($name = null)
    {
        if ($name === null) {
            return $_GET;
        }
        
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }
}