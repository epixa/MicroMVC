<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Router;

/**
 * @category  Epixa
 * @package   Router
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
interface RouterInterface
{
    /**
     * Parses the given uri agaisnt a simple scheme and returns parse result
     * 
     * @param  string $uri
     * @return ResultInterface
     */
    public function parseUri($uri);
}