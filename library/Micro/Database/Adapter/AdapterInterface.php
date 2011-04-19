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
interface AdapterInterface
{
    /**
     * Creates a new database connection
     */
    public function connect();
    
    /**
     * Executes the given query and injects the given parameters
     * 
     * @param string $sql
     * @param array  $bind
     */
    public function query($sql, array $bind = array());
    
    /**
     * Attempts to begin a new transaction
     * 
     * To allow stacked transactions, the transaction level is always 
     * incremented, but a new transaction is only begun when there are no others
     * started.
     */
    public function beginTransaction();
    
    /**
     * Attempts to commit the current transaction
     * 
     * To allow stacked transactions, a commit is only executed if there is only
     * one transaction that is suppose to be started.
     */
    public function commit();
    
    /**
     * Attempts to rollback the current transaction
     * 
     * To allow stacked transactions, a rollback is only executed if there is 
     * only one transaction that is suppose to be started.
     */
    public function rollback();
}