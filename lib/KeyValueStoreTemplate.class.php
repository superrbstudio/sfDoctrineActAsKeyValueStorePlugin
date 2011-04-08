<?php

/**
 * KeyValueStore
 *
 * Add simple key/value attributes to any Doctrine object. These attributes
 * cannot be selected upon and should not be large data (note the BLOB size limitation
 * and the performance implications of loading a lot of them with every object). You should
 * use them for permanent user attributes and the like. Data worth querying across all rows
 * for later is worth a real schema addition
 *
 * @package     sfDoctrineActAsKeyValueStore
 * @subpackage  Template
 * @license     BSD
 * @author      Tom Boutell <tom@punkave.com>
 */
class KeyValueStore extends Doctrine_Template
{
    /**
     * Array of KeyValueStore options
     *
     * @var string
     */
    protected $_options = array('name'          =>  'key_value_store',
                                'alias'         =>  null,
                                'type'          =>  'blob',
                                'disabled'      =>  false,
                                'options'       =>  array());

    /**
     * Set table definition for KeyValueStore behavior
     *
     * @return void
     */
    public function setTableDefinition()
    {
        if ( ! $this->_options['disabled']) {
            $name = $this->_options['name'];
            if ($this->_options['alias']) {
                $name .= ' as ' . $this->_options['alias'];
            }
            $this->hasColumn($name, $this->_options['type'], null, $this->_options['options']);
        }

        if ( ! $this->_options['disabled']) {
            $name = $this->_options['name'];
            if ($this->_options['alias']) {
                $name .= ' as ' . $this->_options['alias'];
            }
            $this->hasColumn($name, $this->_options['type'], null, $this->_options['options']);
        }

        $this->addListener(new KeyValueStoreListener($this->_options));
    }
 
    public function getKeyValue($key, $default = null)
    {
      $invoker = $this->getInvoker();
      if (!isset($invoker->sfKeyValueStoreData))
      {
        $name = $this->_options['name'];
        $value = $invoker->$name;
        if (substr($value, 0, 1) !== '{')
        {
          $data = array();
        }
        else
        {
          $data = json_decode($invoker->$name, true);
        }
        $invoker->sfKeyValueStoreData = $data;
      }
      if (!isset($invoker->sfKeyValueStoreData[$key]))
      {
        return $default;
      }
      return $invoker->sfKeyValueStoreData[$key];
    }
    
    public function setKeyValue($key, $value)
    {
      $invoker->sfKeyValueStoreData[$key] = $value;
      $invoker->sfKeyValueStoreModified = true;
    }
}