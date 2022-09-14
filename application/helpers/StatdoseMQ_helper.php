<?php
require_once(APPPATH.'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH.'config/lockermq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Function: Call Rabbit MQ
// Parameters: Ajex Event Add Document
// Creator: 09/07/2019 wasin(Yoshi)
// LastUpdate: -
// Return:-
// ReturnType: Object
function FCNxStatDoseCallRabbitMQ($paParams) {
    $tQueuesName            = $paParams['queuesname'];
    $tExchangeName          = $paParams['exchangname'];
    $tBindingKey            = "";
    $aParams                = $paParams['params'];
    //$aParams['ptConnStr']   = DB_CONNECT;
    $tExchange              = EXCHANGE;
    $oConnection            = new AMQPStreamConnection(STATDOSE_HOST,STATDOSE_PORT,STATDOSE_USER,STATDOSE_PASS,STATDOSE_VHOST);
    $oChannel               = $oConnection->channel();
    // Declare Exchange Name
    $oChannel->exchange_declare(
        $tExchangeName, 
        'fanout', 
        false, 
        true,   
        false 
    );
    // Declare Queues Name
    $oChannel->queue_declare($tQueuesName,false,true,false,false);

    // Binding Queues To Exchange
    $oChannel->queue_bind($tQueuesName,$tExchangeName,$tBindingKey);

    $oMessage   = new AMQPMessage(json_encode($aParams));
    $oChannel->basic_publish($oMessage,$tExchangeName);
    $oChannel->close();
    $oConnection->close();
    return;
}



function FCNxSendExchangeStatDose($paParams){
    $tQueuesName            = $paParams['queuesname'];
    $tExchangeName          = $paParams['exchangname'];
    $tBindingKey            = "";
    $aParams                = $paParams['params'];
    //$aParams['ptConnStr']   = DB_CONNECT;
    $tExchange              = EXCHANGE;
    $oConnection            = new AMQPStreamConnection(STATDOSE_HOST,STATDOSE_PORT,STATDOSE_USER,STATDOSE_PASS,STATDOSE_VHOST);
    $oChannel               = $oConnection->channel();
        // Declare Exchange Name
        $oChannel->exchange_declare(
            $tExchangeName, 
            'fanout', # type
            false,    # passive
            true,    # durable
            false     # auto_delete
        );

        $oMessage   = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage,$tExchangeName);
        $oChannel->close();
        $oConnection->close();
}

//Declear Exchange - notification
function FCNxDeclearExchangeStatDosenotification($paParams){
    $tQueuesName            = $paParams['queuesname'];
    $tExchangeName          = $paParams['exchangname'];
    $tBindingKey            = "";
    $aParams                = $paParams['params'];
    $tExchange              = EXCHANGE;
    $oConnection            = new AMQPStreamConnection(STATDOSE_HOST,STATDOSE_PORT,STATDOSE_USER,STATDOSE_PASS,'AdaPos5.0StatDose');
    $oChannel               = $oConnection->channel();
    $oChannel->exchange_declare(
        $tExchangeName, 
        'fanout',
        false, 
        true,  
        false
    );

    // Declare Queues Name
    $oChannel->queue_declare($tQueuesName,false,true,false,false);
    $oMessage   = new AMQPMessage(json_encode($aParams));
    //$oChannel->basic_publish($oMessage,$tExchangeName);
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
function FCNxStatDoseRabbitMQDeleteQName($paParams) {
    $tPrefixQueueName   = $paParams['queueName'];
    $aParams            = $paParams['params'];
    $oConnection        = new AMQPStreamConnection(STATDOSE_HOST,STATDOSE_PORT,STATDOSE_USER,STATDOSE_PASS,STATDOSE_VHOST);
    $oChannel           = $oConnection->channel();
    $oChannel->queue_delete($tPrefixQueueName);
    $oChannel->close();
    $oConnection->close();
    return;
}



