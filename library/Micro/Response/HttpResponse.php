<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Response;

/**
 * Manages the compiling and rendering of an application's response
 * 
 * Includes both headers and body content.
 * 
 * @category  Epixa
 * @package   Response
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class HttpResponse implements ResponseInterface
{
    /**
     * @var array
     */
    protected $_body = array();
    
    /**
     * @var array
     */
    protected $_headers = array();
    
    
    /**
     * Appends a value to the response body
     * 
     * The content can be of any type so long as that type can be casted to a 
     * string.
     * 
     * @param  string $name
     * @param  mixed  $content
     * @return Response *Fluent interface*
     */
    public function append($name, $content)
    {
        if (array_key_exists($name, $this->_body)) {
            unset($this->_body[$name]);
        }
        
        $this->_body[$name] = $content;
        
        return $this;
    }
    
    /**
     * Prepends a value to the response body
     * 
     * The content can be of any type so long as that type can be casted to a 
     * string.
     * 
     * @param  string $name
     * @param  mixed  $content
     * @return Response *Fluent interface*
     */
    public function prepend($name, $content)
    {
        if (array_key_exists($name, $this->_body)) {
            unset($this->_body[$name]);
        }
        
        $body = array($name => $content);
        $this->_body = array_merge($body, $this->_body);
        
        return $this;
    }
    
    /**
     * Clear the response headers
     * 
     * @return Response *Fluent interface*
     */
    public function clearHeaders()
    {
        $this->_headers = array();
        
        return $this;
    }
    
    /**
     * Clear the response body
     * 
     * @return Response *Fluent interface*
     */
    public function clearBody()
    {
        $this->_body = array();
        
        return $this;
    }
    
    /**
     * Sends all of the response headers
     * 
     * Does nothing if headers have already been sent.
     * 
     * @return Response *Fluent interface*
     */
    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }
        
        foreach ($this->_headers as $header) {
            header($header['string'], $header['replace'], $header['http_response_code']);
        }
        
        return $this;
    }
    
    /**
     * Send the response to screen
     * 
     * @return Response *Fluent interface*
     */
    public function send()
    {
        $this->sendHeaders();
        
        echo $this->getBodyAsString();
        
        return $this;
    }
    
    /**
     * Gets the body values in their native array
     * 
     * @return array
     */
    public function getBody()
    {
        return $this->_body;
    }
    
    /**
     * Gets the body values concatenated as a string
     * 
     * @return string
     */
    public function getBodyAsString()
    {
        return implode('', $this->_body);
    }
}