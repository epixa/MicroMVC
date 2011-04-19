<?php
/**
 * Epixa MicroMVC
 */

namespace Micro\Config;

use ArrayAccess,
    IteratorAggregate,
    Serializable;

/**
 * @category  Epixa
 * @package   Config
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/MicroMVC/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class ArrayConfig implements ArrayAccess, IteratorAggregate, Serializable
{
    /**
     * @var array
     */
    protected $_data = array();


    /**
     * Constructs a new array config
     * 
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->populate($data);
    }

    /**
     * Gets a specific data value
     * 
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!isset($this->_data[$name])) {
            return null;
        }

        return $this->_data[$name];
    }

    /**
     * Is the specific value defined in this config?
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->_data);
    }

    /**
     * Unset the specific value from the config
     *
     * @param string $name
     */
    public function __unset($name)
    {
        unset($this->_data[$name]);
    }

    /**
     * Sets a specific data value
     *
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    /**
     * Populates the current array config with the given data set
     *
     * @param array $data
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = new ArrayConfig($value);
            }

            $this->_data[$key] = $value;
        }
    }

    /**
     * Returns the entire config as an array
     * 
     * @return array
     */
    public function toArray()
    {
        $data = array();

        foreach ($this->_data as $key => $value) {
            if ($value instanceof ArrayConfig) {
                $value = $value->toArray();
            }

            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * From Serializable
     * 
     * @return string
     */
    public function serialize()
    {
        return serialize($this->_data);
    }

    /**
     * From Serializable
     *
     * @param  string $data
     * @return void
     */
    public function unserialize($data)
    {
        $this->populate(unserialize($data));
    }

    /**
     * From IteratorAggregate
     * 
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->_data);
    }

    /**
     * From ArrayAccess
     * 
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    /**
     * From ArrayAccess
     *
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    /**
     * From ArrayAccess
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

    /**
     * From ArrayAccess
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }
}