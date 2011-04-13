<?php
/**
 * Epixa MVC - example application
 */

namespace App\Controller;

use Micro\Controller\AbstractController,
    Micro\Exception\NotFoundException,
    Exception;

/**
 * @category  App
 * @package   Controller
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class ErrorController extends AbstractController
{
    public function defaultAction(Exception $exception, array $params)
    {
        $view = $this->getView();
        $view->request = $this->getRequest();

        $debugConfig = $this->getConfig()->debug;
        if ($debugConfig && $debugConfig->renderExceptions) {
            $view->exception = $exception;
        }

        if ($exception instanceof NotFoundException) {
            return $view->render('error/not-found');
        }

        return $view->render('error/default');
    }
}