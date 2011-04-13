<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Dispatcher;

use Micro\Request\RequestInterface,
    Micro\Response\ResponseInterface,
    Micro\Exception\ConfigException,
    Micro\Exception\NotFoundException,
    Micro\Config\ArrayConfig,
    Micro\Controller\ControllerInterface,
    LogicException;

/**
 * @category  Epixa
 * @package   Dispatcher
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class MvcDispatcher implements Dispatchable
{
    /**
     * @var null|string
     */
    protected $_controllerPath = null;

    /**
     * @var ArrayConfig
     */
    protected $_controllerConfig;
    
    
    /**
     * Constructor
     * 
     * Configures the directory path for application controllers
     * 
     * @param string           $controllerPath
     * @param null|ArrayConfig $controllerPath
     */
    public function __construct($controllerPath, $controllerConfig = null)
    {
        $this->setControllerPath($controllerPath);

        $this->setControllerConfig($controllerConfig ?: new ArrayConfig(array()));
    }
    
    /**
     * Sets the directory path for application controllers
     * 
     * @param  string $path
     * @return MvcDispatcher *Fluent interface*
     */
    public function setControllerPath($path)
    {
        $this->_controllerPath = rtrim((string)$path, DIRECTORY_SEPARATOR);
        
        return $this;
    }
    
    /**
     * Gets the controller path for application controllers
     * 
     * @return string
     */
    public function getControllerPath()
    {
        if ($this->_controllerPath === null) {
            throw new ConfigException('No controller path configured');
        }
        
        return $this->_controllerPath;
    }

    /**
     * Sets the config for all dispatched controllers
     *
     * @param  ArrayConfig $config
     * @return MvcDispatcher *Fluent interface*
     */
    public function setControllerConfig(ArrayConfig $config)
    {
        $this->_controllerConfig = $config;

        return $this;
    }

    /**
     * Gets the config for all dispatched controllers
     *
     * @return string
     */
    public function getControllerConfig()
    {
        return $this->_controllerConfig;
    }
    
    /**
     * Dispatches the given request, appending returned controller values to 
     * the response, and sending the response on completion
     * 
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     */
    public function dispatch(RequestInterface $request, ResponseInterface $response)
    {
        $actionName = $this->_formatActionName($request->getAction());
        $controllerName = $this->_formatControllerName($request->getController());
        $controller = $this->loadController($controllerName, $request);
        $controller->setConfig($this->getControllerConfig());

        if (!method_exists($controller, $actionName)) {
            throw new NotFoundException(
                sprintf('Action method `%s` does not exist in controller `%s`',
                $actionName, $controllerName
            ));
        }

        $content = call_user_func_array(array($controller, $actionName), $request->getParams());
        $response->append('body', $content);
        
        $response->send();
    }
    
    /**
     * Instantiates and returns a controller by the unqualified class name
     * 
     * @param  string           $name
     * @param  RequestInterface $request
     * @return AbstractController
     */
    public function loadController($name, $request)
    {
        $path = $this->_getControllerFilePath($name);
        if (!file_exists($path)) {
            throw new NotFoundException(
                sprintf('Controller file `%s` not found', 
                $path
            ));
        }
        
        require $path;
        
        $className = $this->_formatFullyQualifiedControllerName($name);
        if (!class_exists($className)) {
            throw new LogicException(sprintf(
                'Controller class `%s` does not exist', $className
            ));
        }

        $controller = new $className($request);
        if (!$controller instanceof ControllerInterface) {
            throw new LogicException(sprintf(
                'Class `%s` is not a valid controller', $className
            ));
        }
        
        return $controller;
    }
    
    
    /**
     * Formats the given unqualified controller class name as the appropriate 
     * full qualification
     * 
     * @param  string $className
     * @return string
     */
    protected function _formatFullyQualifiedControllerName($className)
    {
        return 'App\\Controller\\' . $className;
    }
    
    /**
     * Gets the appropriate absolute file for the given controller class
     * 
     * @param  string $className
     * @return string 
     */
    protected function _getControllerFilePath($className)
    {
        return $this->getControllerPath() . DIRECTORY_SEPARATOR . $className . '.php';
    }

    /**
     * Given the raw name of an action, formats the result into the appropriate
     * method name
     *
     * @param  string $controller
     * @return string
     */
    protected function _formatActionName($action)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $action))) . 'Action';
    }
    
    /**
     * Given the raw name of a controller, formats the result into the 
     * appropriate non-qualified class name
     * 
     * @param  string $controller
     * @return string
     */
    protected function _formatControllerName($controller)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $controller))) . 'Controller';
    }
}