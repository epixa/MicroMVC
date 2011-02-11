<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Dispatcher;

use Micro\Request\RequestInterface,
    Micro\Response\ResponseInterface;

/**
 * @category  Epixa
 * @package   Dispatcher
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
interface Dispatchable
{
    /**
     * Dispatches the given request and adds to the response
     * 
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     */
    public function dispatch(RequestInterface $request, ResponseInterface $response);
}