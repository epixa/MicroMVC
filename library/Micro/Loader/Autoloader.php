<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Loader;

/**
 * @link http://groups.google.com/group/php-standards/web/final-proposal
 */
class Autoloader
{
    private $_namespace;
    private $_path;
    private $_separator = '\\';

    /**
     * Constructor
     *
     * Sets the namespace, path, and separator to use for this autoloader
     * 
     * @param null|string $namespace
     * @param null|string $path
     * @param null|string $path
     */
    public function __construct($namespace = null, $path = null, $separator = null)
    {
        $this->_namespace = $namespace;
        $this->_path = $path;

        if ($separator !== null) {
            $this->_separator = $separator;
        }
    }

    /**
     * Loads the file for the given class name
     *
     * @param  string $className
     * @return void
     */
    public function loadClass($className)
    {
        if ($this->_namespace === null || strpos($className, $this->_namespace . $this->_separator) === 0) {
            $fileName = '';
            
            $lastNsPos = strrpos($className, $this->_separator);
            if ($lastNsPos !== false) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace($this->_separator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }
            
            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

            require ($this->_path !== null ? $this->_path . DIRECTORY_SEPARATOR : '') . $fileName;
        }
    }
}