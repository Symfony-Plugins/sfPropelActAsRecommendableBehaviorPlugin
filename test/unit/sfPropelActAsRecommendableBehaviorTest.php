<?php
// test variables definition
define('TEST_CLASS', 'SfTest');

// initializes testing framework
$app = 'frontend';
include(dirname(__FILE__).'/../../../../test/bootstrap/functional.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
$con = Propel::getConnection();

// clean the database
RecommendationPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

// start tests
$t = new lime_test(9, new lime_output_color());

// these tests check for the comments attachement consistency
$t->diag('start tests');

// objects creation
$object1 = _create_object();
$object1->setName('one');
$object1->save();

$object2 = _create_object();
$object2->setName('two');
$object2->save();

$user1 = new sfGuardUser();
$user1->setUsername('one');
$user1->save();

$t->ok(is_numeric($object1->getRecommendationScore()), 'getRecommendationScore() returns numeric value');
$t->is($object1->getRecommendationScore(), 0, 'getRecommendationScore() object 1 score initialized : 0');
$t->ok($object1->recommend(), 'recommend() object 1');
$t->is($object1->getRecommendationScore(), 1, 'getRecommendationScore() object 1 score updated : 1');
$object2->recommend();
$object2->recommend();
$object2->recommend();
$t->is($object1->getRecommendationScore(), 1, 'getRecommendationScore() object 1 score not updated : 1');
$t->is($object2->getRecommendationScore(), 3, 'getRecommendationScore() object 2 score updated : 3');
$t->ok($object1->recommend($user1->getPrimaryKey()), 'recommend() a user can recommend object 1 once');
$t->ok(!$object1->recommend($user1->getPrimaryKey()), 'recommend() a user cannot recommend object 1 twice');
$t->ok($object2->recommend($user1->getPrimaryKey()), 'recommend() a user can recommend object 2');

// test object creation
function _create_object()
{
  $classname = TEST_CLASS;

  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  return new $classname();
}