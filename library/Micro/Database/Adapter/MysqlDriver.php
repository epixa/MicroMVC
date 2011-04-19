<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Database\Adapter;

/**
 * @category   Epixa
 * @package    Database
 * @subpackage Adapter
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class MysqlDriver extends AbstractAdapter
{
    /**
     * Creates a dsn string from the given parameters
     *
     * @param  array $params
     * @return string
     */
    protected function _createDsn(array $params)
    {
        $dsn = 'mysql:';

        if (isset($params['host'])) {
            $dsn .= 'host=' . $params['host'] . ';';
        }

        if (isset($params['port'])) {
            $dsn .= 'port=' . $params['port'] . ';';
        }

        if (isset($params['dbname'])) {
            $dsn .= 'dbname=' . $params['dbname'] . ';';
        }

        if (isset($params['unix_socket'])) {
            $dsn .= 'unix_socket=' . $params['unix_socket'] . ';';
        }

        return $dsn;
    }
}