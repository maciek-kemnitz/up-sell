<?php
// This file generated by Propel 1.7.1 convert-conf target
// from XML runtime conf file /home/maciek/workspace/up-sell/src/Config/runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'up-sell' => 
    array (
      'adapter' => 'mysql',
      'connection' => 
      array (
        'dsn' => 'mysql:host=local.phpmyadmin.pl;dbname=shoplo_up_sell',
        'user' => 'root',
        'password' => 'maciekmarekmama',
        'settings' => 
        array (
          'charset' => 
          array (
            'value' => 'utf8',
          ),
        ),
      ),
    ),
    'default' => 'up-sell',
  ),
  'generator_version' => '1.7.1',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-up-sell-conf.php');
return $conf;