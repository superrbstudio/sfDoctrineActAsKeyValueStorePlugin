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
 
    public function aGet($key, $default = null)
    {
      $data = $this->aGetAll();
      if (!isset($data[$key]))
      {
        return $default;
      }
      return $data[$key];
    }
    
    public function aSet($key, $value)
    {
      $invoker = $this->getInvoker();
      $data = $this->aGetAll();
      $data[$key] = $value;
      $this->aSetAll($data);
    }
    
    public function aGetAll()
    {
      $invoker = $this->getInvoker();
      if (!$invoker->hasMappedValue('_sfKeyValueStoreData'))
      {
        $name = $this->_options['name'];
        $value = $invoker->$name;
        if (!strlen($value))
        {
          $data = array();
        }
        else
        {
          $data = unserialize($value);
        }
        $invoker->mapValue('_sfKeyValueStoreData', $data);
      }
      else
      {
        $data = $invoker->_sfKeyValueStoreData;
      }
      return $data;
    }
    
    public function aSetAll($data)
    {
      $invoker = $this->getInvoker();
      // mapValue is nothing but a simple associative array set,
      // so calling it more than once is actually faster than
      // going through __call() 
      $invoker->mapValue('_sfKeyValueStoreData', $data);
      $invoker->mapValue('_sfKeyValueStoreModified', true);
    }
    
}