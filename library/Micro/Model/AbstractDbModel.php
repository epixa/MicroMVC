<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Model;

use Micro\Database\Adapter\AdapterInterface,
    Micro\Exception\ConfigException;

/**
 * An abstract representation of a standard model with database access
 * 
 * @category  Epixa
 * @package   Model
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
abstract class AbstractDbModel extends AbstractModel
{
    /**
     * @var null|AdapterInterface
     */
    protected static $_defaultAdapter = null;

    /**
     * @var null|AdapterInterface
     */
    protected $_adapter = null;


    /**
     * Sets the default database adapter for all database models
     * 
     * @static
     * @param  AdapterInterface $adapter
     * @return void
     */
    public static function setDefaultAdapter(AdapterInterface $adapter)
    {
        self::$_defaultAdapter = $adapter;
    }

    /**
     * Gets the default database adapter for all database models
     * 
     * @static
     * @return AdapterInterface|null
     */
    public static function getDefaultAdapter()
    {
        if (self::$_defaultAdapter === null) {
            throw new ConfigException('No default database adapter configured');
        }

        return self::$_defaultAdapter;
    }
    
    /**
     * Sets the database adapter for this database model
     * 
     * @param  AdapterInterface $adapter
     * @return AbstractDbModel *Fluent interface*
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->_adapter = $adapter;
        
        return $this;
    }

    /**
     * Gets the database adapter for this database model
     *
     * If no adapter is set, then the default is used instead.
     * 
     * @return AdapterInterface|null
     */
    public function getAdapter()
    {
        if ($this->_adapter === null){
            $this->setAdapter(self::getDefaultAdapter());
        }
        
        return $this->_adapter;
    }
}