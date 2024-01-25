<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	/*'hostname' => 'localhost',
	'username' => 'dev',
	'password' => '12345678',
	'database' => 'kordapil',*/

	'hostname'     => $_ENV['DB_HOSTNAME'],
    'username'     => $_ENV['DB_USERNAME'],
    'password'     => $_ENV['DB_PASSWORD'],
    'database'     => $_ENV['DB_DATABASE'],
    
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => 'application/cache',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
