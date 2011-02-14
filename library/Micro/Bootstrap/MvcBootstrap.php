<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Bootstrap;

use Micro\Request\HttpRequest,
    Micro\Response\HttpResponse,
    Micro\Router\SimpleRouter,
    Micro\Dispatcher\MvcDispatcher,
    Micro\View\FileView,
    Micro\Controller\AbstractController,
    Micro\Exception\ConfigException;

/**
 * @category  Epixa
 * @package   Bootstrap
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class MvcBootstrap extends AutoBootstrap
{
    /**
     * {@inheritdoc}
     * 
     * Since this is an MVC request, the response and request resources are 
     * automatically added.
     * 
     * @param string $appPath 
     */
    public function __construct($appPath)
    {
        parent::__construct($appPath);
        
        $config = $this->getConfig();
        
        $resources = array('router', 'request', 'response', 'dispatcher');
        if (isset($config['resources']) && is_array($config['resources'])) {
            unset($config['resources'], $config['response']);
            $resources = array_merge($config['resources'], $resources);
        }
        
        unset($config['resources']);
        
        $this->setResources($resources);
    }
    
    
    /**
     * Initializes the application's router object
     * 
     * @return SimpleRouter
     */
    protected function _initRouter()
    {
        return new SimpleRouter();
    }
    
    /**
     * Initializes the application's request object
     * 
     * @return HttpRequest
     */
    protected function _initRequest()
    {
        $request = new HttpRequest();
        
        $router = $this->bootstrapResource('router');
        $router->setDefaultController(HttpRequest::getDefaultController());
        $router->setDefaultAction(HttpRequest::getDefaultAction());
        
        $parseResult = $router->parseUri($request->getRequestUri());
        $request->setController($parseResult->getController());
        $request->setAction($parseResult->getAction());
        $request->setParams($parseResult->getParams());
        
        return $request;
    }
    
    /**
     * Initializes the application's response object
     * 
     * @return HttpResponse
     */
    protected function _initResponse()
    {
        return new HttpResponse();
    }
    
    /**
     * Initializes the application's dispatcher object
     * 
     * @return MvcDispatcher
     */
    protected function _initDispatcher()
    {
        $config = $this->getConfig('dispatcher');
        if (isset($config['controller_path'])) {
            $path = (string)$config['controller_path'];
        } else {
            $path = $this->_controllerPathFactory();
        }
        
        return new MvcDispatcher($path);
    }
    
    /**
     * Initializes the application's primary view object
     * 
     * @return FileView
     */
    protected function _initView()
    {
        $view = new FileView();
        $view->setBasePath($this->_viewBasePathFactory());
        
        AbstractController::setDefaultView($view);
        
        return $view;
    }
    
    /**
     * Runs the application
     */
    public function run()
    {
        $dispatcher = $this->bootstrapResource('dispatcher');
        $request = $this->bootstrapResource('request');
        $response = $this->bootstrapResource('response');
        
        $dispatcher->dispatch($request, $response);
    }
    
    
    /**
     * Creates the controller path based on the application path
     * 
     * @return string
     */
    protected function _controllerPathFactory()
    {
        return APPLICATION_PATH . '/sources/Controller';
    }
    
    /**
     * Creates the base path for view templates based on the application path
     * 
     * @return string
     */
    protected function _viewBasePathFactory()
    {
        return APPLICATION_PATH . '/templates';
    }
}