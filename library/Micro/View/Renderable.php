<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\View;

/**
 * @category  Epixa
 * @package   View
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
interface Renderable
{
    /**
     * Generates and returns a view's output
     */
    public function render();
}