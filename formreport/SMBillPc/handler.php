<?php
require_once "stimulsoft/helper.php";
require_once('../../config_deploy.php');
// Please configure the security level as you required.
// By default is to allow any requests from any domains.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token");

$handler = new StiHandler();
$handler->registerErrorHandlers();

$handler->onBeginProcessData = function ($args) {
	if ($args->connection == "Vending")
		$args->connectionString = "Data Source=".DATABASE_IP.";Initial Catalog=".BASE_DATABASE.";Integrated Security=False;User ID=".DATABASE_USERNAME.";Password=".DATABASE_PASSWORD.";";
	return StiResult::success();
};

$handler->process();
