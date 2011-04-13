<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Controller;

use Micro\Request\RequestInterface,
    Micro\View\Renderable,
    Micro\Exception\ConfigException,
    Micro\Config\ArrayConfig;

/**
 * An abstract representation of an application controller
 * 
 * @category  Epixa
 * @package   Controller
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
abstract class AbstractController implements ControllerInterface
{
    /**
     * @var null|Renderable
     */
    protected static $_defaultView = null;
    
    /**
     * @var null|Renderable
     */
    protected $_view = null;

    /**
     * @var null|RequestInterface
     */
    protected $_request = null;

    /**
     * @var null|ArrayConfig
     */
    protected $_config = null;


    /**
     * Constructor
     *
     * Sets up the controller
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->setRequest($request);
    }

    /**
     * Gets the controller's default view
     * 
     * @return Renderable
     * @throws ConfigException If no default view is configured
     */
    public static function getDefaultView()
    {
        if (self::$_defaultView === null) {
            throw new ConfigException('No default view is configured');
        }
        
        return self::$_defaultView;
    }
    
    /**
     * Sets the controller's default view
     * 
     * @param Renderable $view
     */
    public static function setDefaultView(Renderable $view)
    {
        self::$_defaultView = $view;
    }
    
    /**
     * Gets the controller's view
     * 
     * @return Renderable
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->setView(self::getDefaultView());
        }
        
        return $this->_view;
    }
    
    /**
     * Sets the controller's view
     * 
     * @param  Renderable $view
     * @return AbstractController *Fluent interface*
     */
    public function setView(Renderable $view)
    {
        $this->_view = $view;
        
        return $this;
    }

    /**
     * Gets the currently dispatched request
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Sets the currently dispatched request
     *
     * @param  RequestInterface $request
     * @return AbstractController *Fluent interface*
     */
    public function setRequest(RequestInterface $request)
    {
        $this->_request = $request;

        return $this;
    }

    /**
     * Gets the controller config
     *
     * @return ArrayObject
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Sets the controller config
     *
     * @param  ArrayConfig $config
     * @return AbstractController *Fluent interface*
     */
    public function setConfig(ArrayConfig $config)
    {
        $this->_config = $config;

        return $this;
    }
}