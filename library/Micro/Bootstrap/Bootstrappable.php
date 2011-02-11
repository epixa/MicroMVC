<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Bootstrap;

/**
 * @category  Epixa
 * @package   Bootstrap
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
interface Bootstrappable
{
    /**
     * Runs bootstrapping operations
     */
    public function bootstrap();
}