<?php

// Default values
$config = array(
  'connection'                => 'propel',
  'user_table'                => 'sf_guard_user',
  'user_id'                   => 'id',
  'user_class'                => 'sfGuardUser',
  'recommendation_table'      => 'sf_recommendation',
  'recommendation_user_table' => 'sf_user_recommendation',
);

// Check custom project values
if(is_readable($config_file = sfConfig::get('sf_config_dir').'/sfPropelActAsRecommendableBehaviorPlugin.yml'))
{
  $user_config = sfYaml::load($config_file);
  if(isset($user_config['schema']))
  {
    $config = array_merge($config, $user_config['schema']);
  }
}