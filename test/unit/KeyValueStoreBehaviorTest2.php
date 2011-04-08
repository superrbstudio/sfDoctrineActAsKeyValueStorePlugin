<?php

/**
 * KeyValueStoreBehavior tests, part 1: setting things.
 */
include dirname(__FILE__).'/../bootstrap/unit.php';

$databaseManager = new sfDatabaseManager($configuration);

$t = new lime_test(7);

$t->comment("This is the second group of tests. This split is necessary because");
$t->comment("Doctrine reuses objects in memory making it tough to test what");
$t->comment("was really saved in a single run.");

$user1 = Doctrine::getTable('sfGuardUser')->createQuery('u')->where('u.username = ?', 'fred')->fetchOne();
$t->is(!!$user1, true, "If this test fails you probably didn't run KeyValueStoreBehaviorTest1 yet");
$t->is($user1->aGet('seen_welcome_message'), true, 'seen_welcome_message boolean value successfully retrieved');
$t->is($user1->aGet('colors'), array('red', 'green', 'blue'), 'colors array value successfully retrieved');
$t->is($user1->aGet('flavor'), 'grape', 'flavor value from second save successfully retrieved');
$user2 = Doctrine::getTable('sfGuardUser')->createQuery('u')->where('u.username = ?', 'alice')->fetchOne();
$t->is($user2->aGet('seen_welcome_message', null), null, 'seen_welcome_message not defined (that\'s good)');
$t->is($user2->aGet('colors'), array('orange', 'tangerine'), 'colors array value successfully retrieved, distinct from user1');

$user3 = Doctrine::getTable('sfGuardUser')->createQuery('u')->where('u.username = ?', 'jane')->fetchOne();
$t->is($user3->aGetAll(), array('age' => 40, 'beer' => 'porter'), 'All values retrieved accurately with aGetAll for user3');

