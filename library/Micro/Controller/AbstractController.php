<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Controller;

use Micro\View,
    Micro\Exception\ConfigException;

/**
 * An abstract representation of an application controller
 * 
 * @category  Epixa
 * @package   Controller
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
abstract class AbstractController
{
    /**
     * @var null|View
     */
    protected static $_defaultView = null;
    
    /**
     * @var null|View
     */
    protected $_view = null;
    
    
    /**
     * Gets the controller's default view
     * 
     * @return View
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
     * @param View $view
     */
    public static function setDefaultView(View $view)
    {
        self::$_defaultView = $view;
    }
    
    /**
     * Gets the controller's view
     * 
     * @return View
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
     * @param  View $view
     * @return AbstractController *Fluent interface*
     */
    public function setView(View $view)
    {
        $this->_view = $view;
        
        return $this;
    }
}