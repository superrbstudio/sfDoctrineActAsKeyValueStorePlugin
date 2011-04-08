<?php

/**
 * KeyValueStoreBehavior tests.
 */
include dirname(__FILE__).'/../bootstrap/unit.php';

$databaseManager = new sfDatabaseManager($configuration);

$t = new lime_test(2);

$user = new sfGuardUser();
$user->setUsername('fred');
// Newer sfDoctrineGuardPlugin requires this
$user->setEmailAddress('fred@test.com');
$user->setKeyValue('seen_welcome_message', true);
$user->setKeyValue('colors', array('red', 'green', 'blue'));
$user->save();

$user = sfGuardUserTable::getInstance()->createQuery('u')->where('u.username = ?', 'fred')->fetchOne();
$t->is($user->getKeyValue('seen_welcome_message'), true, 'seen_welcome_message boolean value successfully retrieved');
$t->is($user->getKeyValue('colors'), array('red', 'green', 'blue'), 'colors array value successfully retrieved');
