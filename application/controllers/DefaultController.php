<?php
/**
 * Epixa MVC - example application
 */

namespace App\Controller;

use Micro\Controller\AbstractController;

/**
 * @category  App
 * @package   Controller
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class DefaultController extends AbstractController
{
    public function defaultAction()
    {
        return $this->getView()->render();
    }
}