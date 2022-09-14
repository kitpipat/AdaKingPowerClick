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
function FCNxRentalCallRabbitMQ($paParams) {
    $tQueuesName            = $paParams['queuesname'];
    $tExchangeName          = $paParams['exchangname'];
    $tBindingKey            = "";
    $aParams                = $paParams['params'];
    $aParams['ptConnStr']   = DB_CONNECT;
    $tExchange              = EXCHANGE;
    $oConnection            = new AMQPStreamConnection(HOST,PORT,USER,PASS,VHOST);
    $oChannel               = $oConnection->channel();
    // Declare Exchange Name
    $oChannel->exchange_declare(
        $tExchangeName, 
        'fanout', # type
        false,    # passive
        true,    # durable
        false     # auto_delete
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



function FCNxSendExchange($paParams){
    $tQueuesName            = $paParams['queuesname'];
    $tExchangeName          = $paParams['exchangname'];
    $tBindingKey            = "";
    $aParams                = $paParams['params'];
    $aParams['ptConnStr']   = DB_CONNECT;
    $tExchange              = EXCHANGE;
    $oConnection            = new AMQPStreamConnection(HOST,PORT,USER,PASS,VHOST);
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



// Function: Delete Q Rabbit MQ
// Parameters: Ajex Event Add Document
// Creator: 09/07/2019 wasin(Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function FCNxRentalRabbitMQDeleteQName($paParams) {
    $tPrefixQueueName   = $paParams['queueName'];
    $aParams            = $paParams['params'];
    $oConnection        = new AMQPStreamConnection(MQ_LOCKER_HOST,MQ_LOCKER_PORT,MQ_LOCKER_USER,MQ_LOCKER_PASS,MQ_LOCKER_VHOST);
    $oChannel           = $oConnection->channel();
    $oChannel->queue_delete($tPrefixQueueName);
    $oChannel->close();
    $oConnection->close();
    return;
}



