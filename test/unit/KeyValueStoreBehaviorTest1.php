<?php

/**
 * KeyValueStoreBehavior tests, part 1: setting things.
 */
include dirname(__FILE__).'/../bootstrap/unit.php';

$databaseManager = new sfDatabaseManager($configuration);

$t = new lime_test(3);

$q = new Doctrine_Query();
$q->delete('sfGuardUser')->execute();
$user1 = new sfGuardUser();
$user1->setUsername('fred');
// Newer sfDoctrineGuardPlugin requires this
$user1->setEmailAddress('fred@test.com');
$user1->aSet('seen_welcome_message', true);
$user1->aSet('colors', array('red', 'green', 'blue'));
$user1->save();
$t->is(!!$user1->id, true, "First object created");
// Try another change and another save, make sure Doctrine
// doesn't optimize the save away
$user1->aSet('flavor', 'grape');
$user1->save();
$t->comment("First object resaved, we can't test this here but the second group of unit tests will check");
$user2 = new sfGuardUser();
$user2->setUsername('alice');
// Newer sfDoctrineGuardPlugin requires this
$user2->setEmailAddress('alice@test.com');
$user2->aSet('colors', array('orange', 'tangerine'));
$user2->save();
$t->is(!!$user2->id, true, "Second object created");
$user3 = new sfGuardUser();
$user3->setUsername('jane');
$user3->aSetAll(array('age' => 40, 'beer' => 'porter'));
$user3->save();
$t->is(!!$user3->id, true, "Third object created");

