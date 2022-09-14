<?php 
require_once('././config_deploy.php');
defined('BASEPATH') OR exit('No direct script access allowed');

$config['socket_type']      = 'tcp'; //`tcp` or `unix`
$config['socket']           = '/var/run/redis.sock'; // in case of `unix` socket type
$config['database']         = REDIS_DB;
$config['host']             = REDIS_HOST;
$config['password']         = REDIS_PASS;
$config['port']             = REDIS_PORT; //Default Port : 6379
$config['timeout']          = 0;