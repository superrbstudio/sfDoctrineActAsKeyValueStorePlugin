<?php

/**
 * sfDoctrineActAsKeyValueStorePluginConfiguration configuration.
 * 
 * @package     sfDoctrineActAsKeyValueStorePlugin
 * @subpackage  config
 * @author      Your name here
 * @version     SVN: $Id: sfDoctrineActAsKeyValueStorePluginConfiguration.class.php 31458 2010-11-19 08:38:57Z gimler $
 */
class sfDoctrineActAsKeyValueStorePluginConfiguration extends sfPluginConfiguration
{
  static $registered = false;

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    // Yes, this can get called twice. This is Fabien's workaround:
    // http://trac.symfony-project.org/ticket/8026
    if (!self::$registered)
    {
      // Do any necessary initialization here
      self::$registered = true;
    }
  }
  
}
