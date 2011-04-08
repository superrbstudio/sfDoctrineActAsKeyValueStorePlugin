<?php

/**
 * Listener for the KeyValueStore behavior which automatically sets the key_value_store
 * column when a record is inserted and updated.
 *
 * @package     sfKeyValueStore
 * @subpackage  Template
 * @license     BSD
 * @author      Tom Boutell <tom@punkave.com>
 */
class KeyValueStoreListener extends Doctrine_Record_Listener
{
    /**
     * Array of KeyValueStore options
     *
     * @var string
     */
    protected $_options = array();

    /**
     * __construct
     *
     * @param string $options 
     * @return void
     */
    public function __construct(array $options)
    {
        $this->_options = $options;
    }

    /**
     * Set updated KeyValueStore column when a record is saved
     *
     * @param Doctrine_Event $event
     * @return void
     */
    public function preSave(Doctrine_Event $event)
    {
        if ( ! $this->_options['disabled']) {
            $invoker = $event->getInvoker();
            $updatedName = $invoker->getTable()->getFieldName($this->_options['name']);
            if (isset($invoker->sfKeyValueStoreModified))
            {
              $invoker->$updatedName = json_encode($invoker->sfKeyValueStoreData);
            }
        }
    }
}