<?php
/*
 * This file is part of the sfPropelActAsRecommendableBehavior package.
 *
 * (c) 2007 Rémi Cieplicki <rcieplicki@clever-age.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// @ TODO: Verifier

sfPropelBehavior::registerMethods('sfPropelActAsRecommendableBehavior', array (
  array (
    'sfPropelActAsRecommendableBehavior',
    'recommend'
  ),
  array (
    'sfPropelActAsRecommendableBehavior',
    'getRecommendationScore'
  )
));