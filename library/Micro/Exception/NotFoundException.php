<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Exception;

use LogicException;

/**
 * An exception indicating that a certain resource was not found
 * 
 * @category  Epixa
 * @package   Exception
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class NotFoundException extends LogicException
{}