<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Controller;

use Micro\Request\RequestInterface,
    Micro\Config\ArrayConfig;

/**
 * @category  Epixa
 * @package   Controller
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
interface ControllerInterface
{
    /**
     * Sets the currently dispatched request
     *
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request);

    /**
     * Sets the controller config
     *
     * @param ArrayConfig $config
     */
    public function setConfig(ArrayConfig $config);
}