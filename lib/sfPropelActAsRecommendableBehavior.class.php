<?php
/*
 * This file is part of the sfPropelActAsRecommendableBehavior package.
 *
 * (c) 2007 Rémi Cieplicki <rcieplicki@clever-age.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This plugin implements a behavior that permits to recommend objects. A
 * recommandation acts as the incrementation of a counter "à la Digg".
 *
 * - One user can only recommend one item once
 * - For non-authenticated users, the recommendation is based on a cookie
 *
 * @author   Rémi Cieplicki <rcieplicki@clever-age.com>
 * @see      http://www.symfony-project.com/trac/wiki/sfPropelActAsRecommendableBehaviorPlugin
 */

class sfPropelActAsRecommendableBehavior
{
  /**
   * Retrieves an existing sfRecommendation object, or return a new empty one
   *
   * @param  BaseObject  $object
   * @return sfRecommendation
   **/
  protected function getOrCreateRecommendation(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfRecommendationPeer::RECOMMENDABLE_ID, $object->getPrimaryKey());
    $c->add(sfRecommendationPeer::RECOMMENDABLE_MODEL, get_class($object));
    $result = sfRecommendationPeer::doSelectOne($c);
    return is_null($result) ? new sfRecommendation() : $result;
  }

  /**
   * Retrieve te recommendation score attached to the object
   *
   * @param   BaseObject  $object
   * @return  integer
   */
  public function getRecommendationScore(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfRecommendationPeer::RECOMMENDABLE_MODEL, get_class($object));
    $c->add(sfRecommendationPeer::RECOMMENDABLE_ID, $object->getPrimaryKey());
    $recommendation = sfRecommendationPeer::doSelectOne($c);

    if ($recommendation !== null)
    {
      return $recommendation->getScore();
    }
    else
    {
      return 0;
    }
  }

  /**
   * Adds a user recommendation to the object.
   *
   * @param BaseObject  $object
   * @param integer     $user_id
   * @return bool
   */
  public function recommend(BaseObject $object, $user_id = null)
  {
    if (true === $object->isNew())
    {
      throw new Exception('Comments can only be attached to already saved objects');
    }

    // unregistered user handling (via cookie)
    if ($user_id === null)
    {
      $sfContext   = sfContext::getInstance();
      $cookieName  = md5($object->getPrimaryKey().get_class($object));
      $cookieValue = 'ok';

      if (!$sfContext->getRequest()->getCookie($cookieName) == $cookieValue)
      {
        $sfContext->getResponse()->setCookie($cookieName, $cookieValue);
        return $this->saveRecommendation($object);
      }
    }
    // registered user recommendation
    else
    {
      if (!$this->userRecommendationExists($object, $user_id))
      {
        $this->saveUserRecommendation($object, $user_id);
        return $this->saveRecommendation($object);
      }
    }

    return false;
  }

  /**
   * Save recommendation (increments existing score, or create a new one)
   *
   * @param  BaseObject  $object
   * @return bool
   **/
  protected function saveRecommendation(BaseObject $object)
  {
    // Recommendation
    $recommendation_object = $this->getOrCreateRecommendation($object);
    $recommendation_object->setRecommendableModel(get_class($object));
    $recommendation_object->setRecommendableId($object->getPrimaryKey());
    $recommendation_object->setScore($recommendation_object->getScore() + 1);
    return $recommendation_object->save();
  }

  /**
   * Save userRecommendation
   *
   * @param  BaseObject  $object
   * @param  integer     $user_id
   * @return bool
   **/
  protected function saveUserRecommendation(BaseObject $object, $user_id)
  {
    $userRecommendation_object = new sfUserRecommendation;
    $userRecommendation_object->setRecommendableModel(get_class($object));
    $userRecommendation_object->setRecommendableId($object->getPrimaryKey());
    $userRecommendation_object->setUserId($user_id);
    return $userRecommendation_object->save();
  }

  /**
   * Tells if a given user has already recommended the object
   *
   * @param  BaseObject  $object
   * @param  integer     $user_id
   * @return bool
   **/
  protected function userRecommendationExists(BaseObject $object, $user_id)
  {
    $c = new Criteria();
    $c->add(sfUserRecommendationPeer::RECOMMENDABLE_ID, $object->getPrimaryKey());
    $c->add(sfUserRecommendationPeer::RECOMMENDABLE_MODEL, get_class($object));
    $c->add(sfUserRecommendationPeer::USER_ID, $user_id);
    $result = sfUserRecommendationPeer::doSelectOne($c);
    return is_null($result) ? false : true;
  }
}