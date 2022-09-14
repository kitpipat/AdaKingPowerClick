<?php
require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once('././config_deploy.php');
if (isset($_COOKIE['ModuleName'])) {

    $tCookie = $_COOKIE['ModuleName'];

    switch ($tCookie) {
        case '':
            define('DB_CONNECT', 'Server='.DATABASE_IP.';Database='.BASE_DATABASE.';User Id='.DATABASE_USERNAME.';Password='.DATABASE_PASSWORD.';');
            break;
        case 'FC':
            break;
        case 'VD':
            break;
        case 'WTP':
            break;
        case 'POS5':
            break;
        case 'TK':
            break;
        default:
            define('DB_CONNECT', 'Server='.DATABASE_IP.';Database='.BASE_DATABASE.';User Id='.DATABASE_USERNAME.';Password='.DATABASE_PASSWORD.';');
            break;
    }
} else {
    define('DB_CONNECT', 'Server='.DATABASE_IP.';Database='.BASE_DATABASE.';User Id='.DATABASE_USERNAME.';Password='.DATABASE_PASSWORD.';');
}
define('AMQP_DEBUG', true);

