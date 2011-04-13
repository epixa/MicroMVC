<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\View;

use Micro\Exception\ConfigException,
    InvalidArgumentException;

/**
 * @category  Epixa
 * @package   View
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class FileView implements Renderable
{
    /**
     * @var null|string
     */
    protected $_basePath = null;
    
    /**
     * @var string
     */
    protected $_fileExtension = '.phtml';
    
    /**
     * @var boolean
     */
    private $_isRendering = false;

    
    /**
     * Ensures that any non-existing key returns null if and only if we are 
     * currently rendering a view script
     *
     * @param  string $key
     * @return null
     */
    public function __get($key)
    {
        if (!$this->_isRendering) {
            trigger_error(sprintf('Key `%s` does not exist', $key), E_USER_NOTICE);
        }
        
        return null;
    }
    
    /**
     * Ensures that only non-underscored-prefixed (so assumed public) properties
     * can be set
     * 
     * If a property prefixed with an underscore is attempted to be set, a 
     * warning is triggered.
     * 
     * @param string $name
     * @param mixed  $value 
     */
    public function __set($name, $value)
    {
        if (strpos($name, '_') === 0) {
            trigger_error('Cannot set protected or private properties', E_USER_WARNING);
        }

        $this->$name = $value;
    }
    
    /**
     * Sets the base path for all rendered view scripts
     * 
     * @param  string $path
     * @return FileView *Fluent interface*
     */
    public function setBasePath($path)
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->_basePath = rtrim((string)$path, $ds);
        
        return $this;
    }
    
    /**
     * Gets the base path for all rendered view scripts
     * 
     * @return string
     * @throws ConfigException If the base path is not set
     */
    public function getBasePath()
    {
        if ($this->_basePath === null) {
            throw new ConfigException('No base script path configured');
        }
        
        return $this->_basePath;
    }
    
    /**
     * Sets the file extension to use for all rendered view scripts
     * 
     * @param  string $extension
     * @return FileView *Fluent interface*
     */
    public function setFileExtension($extension)
    {
        $this->_fileExtension = (string)$extension;
        
        return $this;
    }
    
    /**
     * Gets the file extension to use for all rendered view scripts
     * 
     * @return string
     */
    public function getFileExtension()
    {
        return $this->_fileExtension;
    }
    
    /**
     * Renders the named view script located in the base path within the scope 
     * of the current view
     * 
     * Asserts that the input does not contain characters that could lead to 
     * files above the base path being included.
     * 
     * @return string
     */
    public function render($name)
    {
        $this->assertNoParentTraversal($name);

        ob_start();
        
        $this->_isRendering = true;
        $this->_includeFile($this->_createScriptPath($name));
        $this->_isRendering = false;
        
        return ob_get_clean();
    }
    
    /**
     * Asserts that the given path does not contain any parent directory 
     * traversing
     * 
     * This helps to protect the injection of files above the expected 
     * directory (local file inclusion).
     * 
     * @param  string $path 
     * @throws InvalidArgumentException If parent directory traversal is found
     */
    public function assertNoParentTraversal($path)
    {
        if (preg_match('#\.\.[\\\/]#', $path)) {
            throw new InvalidArgumentException('File paths cannot not contain parent directory traversal');
        }
    }
    
    
    /**
     * Includes the given file in the scope of this class
     * 
     * In order to ensure that the file path is not included as a variable in 
     * the scope of the file, the path parameter is retrieved via func_get_arg()
     * 
     * @param string $path
     */
    protected function _includeFile()
    {
        include func_get_arg(0);
    }
    
    /**
     * Compiles the path to the view script identified by the given name
     * 
     * @param  string $name
     * @return string
     */
    protected function _createScriptPath($name)
    {
        $basePath = $this->getBasePath();
        $fileExtension = $this->getFileExtension();
        
        return $basePath . DIRECTORY_SEPARATOR . $name . $fileExtension;
    }
}