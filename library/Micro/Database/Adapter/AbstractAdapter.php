<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Database\Adapter;

use PDO,
    LogicException,
    Micro\Exception\ConfigException;

/**
 * @category   Epixa
 * @package    Database
 * @subpackage Adapter
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var integer
     */
    protected static $_transactionLevel = 0;
    
    /**
     * @var null|PDO
     */
    protected $_connection = null;

    /**
     * @var null|array
     */
    protected $_connectionInfo = null;


    /**
     * Sets the database connection information
     *
     * @param  array       $params
     * @param  null|string $user
     * @param  null|string $pass
     * @param  array       $driverOptions
     * @return AbstractAdapter *Fluent interface*
     */
    public function setConnectionInfo(array $params, $user = null, $pass = null, array $driverOptions = array())
    {
        $this->_connectionInfo = array(
            'dsnParams' => $params,
            'dbUsername' => $user,
            'dbPassword' => $pass,
            'dbDriverOptions' => $driverOptions
        );

        return $this;
    }

    /**
     * Creates a new PDO connection
     *
     * @throws LogicException|ConfigException
     */
    public function connect()
    {
        if ($this->_connection !== null) {
            throw new LogicException('Connection is already established');
        }

        if ($this->_connectionInfo === null) {
            throw new ConfigException('No database connection information specified');
        }

        $params        = $this->_connectionInfo['dsnParams'];
        $user          = $this->_connectionInfo['dbUsername'];
        $pass          = $this->_connectionInfo['dbPassword'];
        $driverOptions = $this->_connectionInfo['dbDriverOptions'];

        $pdo = new PDO($this->_createDsn($params), $user, $pass, $driverOptions);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->setConnection($pdo);
    }

    /**
     * Executes the given sql query with the optional bound parameters
     *
     * If the given query is a select statement, the results are returned in an array.
     * If the given query is an insert statement, the last inserted id is returned.
     * For all other queries, true is returned on success.
     *
     * @param  string $sql
     * @param  array  $bind
     * @return boolean|array|integer
     */
    public function query($sql, array $bind = array())
    {
        $sql = trim($sql);

        foreach ($bind as $name => $value) {
            if (!is_int($name) && strpos($name, ':') !== 0) {
                unset($bind[$name]);
                $bind[':' . $name] = $value;
            }
        }

        $connection = $this->getConnection();

        $stmt = $connection->prepare($sql);
        $return = $stmt->execute($bind);

        if (stripos($sql, 'SELECT') === 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $return = $stmt->fetchAll();
        } else if (stripos($sql, 'INSERT') === 0) {
            $return = $connection->lastInsertId();
        }

        return $return;
    }
    
    /**
     * Attempts to begin a new transaction
     * 
     * To allow stacked transactions, the transaction level is always 
     * incremented, but a new transaction is only begun when there are no others
     * started.
     */
    public function beginTransaction()
    {
        self::$_transactionLevel++;
        
        if (self::$_transactionLevel == 1) {
            $this->getConnection()->beginTransaction();
        }
    }
    
    /**
     * Attempts to commit the current transaction
     * 
     * To allow stacked transactions, a commit is only executed if there is only
     * =one transaction that is suppose to be started.
     */
    public function commit()
    {
        if (self::$_transactionLevel == 1) {
            $this->getConnection()->commit();
        }
        
        if (self::$_transactionLevel > 0) {
            self::$_transactionLevel--;
        }
    }
    
    /**
     * Attempts to rollback the current transaction
     * 
     * To allow stacked transactions, a rollback is only executed if there is 
     * only one transaction that is suppose to be started.
     */
    public function rollback()
    {
        if (self::$_transactionLevel == 1) {
            $this->getConnection()->rollBack();
        }
        
        if (self::$_transactionLevel > 0) {
            self::$_transactionLevel--;
        }
    }
    
    /**
     * Sets the current database connection
     * 
     * @param  PDO $pdo
     * @return AbstractAdapter *Fluent interface*
     */
    public function setConnection(PDO $pdo)
    {
        $this->_connection = $pdo;
        
        return $this;
    }
    
    /**
     * Gets the current database connection
     * 
     * @return PDO
     */
    public function getConnection()
    {
        if ($this->_connection === null) {
            $this->connect();
        }
        
        return $this->_connection;
    }
    
    
    /**
     * Creates a dsn string from the given parameters
     * 
     * @param  array $params
     * @return string 
     */
    abstract protected function _createDsn(array $params);
}