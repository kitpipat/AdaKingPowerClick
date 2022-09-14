<?php
require_once(APPPATH.'libraries/rabbitmq/vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Function: Call Rabbit Report MQ Export File
// Parameters: Ajex Event Add Document
// Creator: 16/08/2019 wasin(Yoshi)
// LastUpdate: -
// Return:-
// ReturnType: Object
function FCNxReportCallRabbitMQ($paParams){
    $ci = &get_instance();
    
    $tQueueName = $paParams['tQueueName'];
    $aParams = $paParams['aParams'];
    $aParams['ptConnStr'] = DB_CONNECT;
    $aParams['ptBchCode'] = $ci->session->userdata("tSesUsrBchCodeDefault");
    $tExchange = EXCHANGE;
    $oConnection = new AMQPStreamConnection(MQ_REPORT_HOST,MQ_REPORT_PORT,MQ_REPORT_USER,MQ_REPORT_PASS,MQ_REPORT_VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_declare($tQueueName, false, true, false, false);
    $oMessage = new AMQPMessage(json_encode($aParams));
    $oChannel->basic_publish($oMessage, "", $tQueueName);
    $oChannel->close();
    $oConnection->close();
    return;
}

// Function: Delete Q Rabbit MQ
// Parameters: Ajex Event Add Document
// Creator: 09/07/2019 wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function FCNxReportRabbitMQDeleteQName($paParams){
    $tQueueName = $paParams['tQueueName'];
    $oConnection = new AMQPStreamConnection(MQ_REPORT_HOST,MQ_REPORT_PORT,MQ_REPORT_USER,MQ_REPORT_PASS,MQ_REPORT_VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_delete($tQueueName);
    $oChannel->close();
    $oConnection->close();
    return;
}




