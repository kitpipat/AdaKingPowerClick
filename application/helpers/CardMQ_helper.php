<?php
require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/* Params MQ
{
    "ptFunction":"CardListShiftPickup", < ชื่อ Function
    "ptSource":"", < ต้นทาง
    "ptDest":"", < ปลายทาง
    "ptDocNo":"", < เลขที่เอกสาร
    "ptData":{   < ข้อมูล เป็น Object หรือ Array
            "ptBchCode":"",
            "ptDocNo":"", < เลขที่เอกสารใบเบิก TFNTCrdShiftHD
            "ptUsrCode":"",
            "ptConnStr":"",
    }
}
*/
function FCNxCardCallRabbitMQ($paParams, $pbStaUseConnStr = true)
{
    $tQueueName = $paParams['queueName'];
    $aParams = $paParams['params'];
    if ($pbStaUseConnStr == true) {
        $aParams['ptData']['ptConnStr'] = DB_CONNECT;
    }
    $tExchange = EXCHANGE; // This use default exchange

    $oConnection = new AMQPStreamConnection(MQ_CRD_HOST, MQ_CRD_PORT, MQ_CRD_USER, MQ_CRD_PASS, MQ_CRD_VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_declare($tQueueName, false, false, false, false);
    $oMessage = new AMQPMessage(json_encode($aParams));
    $oChannel->basic_publish($oMessage, "", $tQueueName);
    $oChannel->close();
    $oConnection->close();
    return 1;
    /** Success */

    /*$tQueueName = $paParams['queueName'];
    $aParams = $paParams['params'];
    $aParams['ptConnStr'] = DB_CONNECT;
    $tExchange = EXCHANGE;
    
    $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_declare($tQueueName, false, false, false, false);
    $oChannel->exchange_declare($tExchange, 'direct', false, false, false);
    $oChannel->queue_bind($tQueueName, $tExchange);
    $oMessage = new AMQPMessage(json_encode($aParams));
    $oChannel->basic_publish($oMessage, $tExchange);

    echo "[x] Sent $tQueueName Success";

    $oChannel->close();
    $oConnection->close();*/
}

/**
 * 
 * @param array $paParams
 * 
 * $paParams = [
        "prefixQueueName" => "", 
        "params" => [
            "ptBchCode" => "", "ptDocNo" => "", "ptUsrCode" => ""
        ]
    ];
 */
function FCNxCardRabbitMQDeleteQName($paParams)
{
    $tPrefixQueueName = $paParams['prefixQueueName'];
    $aParams = $paParams['params'];
    $tQueueName = $tPrefixQueueName . '_' . $aParams['ptDocNo'] . '_' . $aParams['ptUsrCode'];
    // $oConnection = new AMQPStreamConnection('172.16.30.28', '5672', 'admin', '1234', 'Pandora_PPT1');
    $oConnection = new AMQPStreamConnection(MQ_CRD_HOST, MQ_CRD_PORT, MQ_CRD_USER, MQ_CRD_PASS, MQ_CRD_VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_delete($tQueueName);
    $oChannel->close();
    $oConnection->close();
    return 1;
}

function FSaCardRabbitMQUpdateStaDelQnameHD($paData)
{
    try {
        $tDocTableName = $paData['tDocTableName'];
        $tDocFieldDocNo = $paData['tDocFieldDocNo'];
        $tDocFieldStaApv = $paData['tDocFieldStaApv'];
        $tDocFieldStaDelMQ = $paData['tDocFieldStaDelMQ'];
        $tDocStaDelMQ = $paData['tDocStaDelMQ'];
        $tDocNo = $paData['tDocNo'];

        $ci = &get_instance();
        $ci->load->database();

        // Update HD
        $ci->db->set($tDocFieldStaDelMQ, 1);
        $ci->db->where($tDocFieldDocNo, $tDocNo);
        $ci->db->update($tDocTableName);

        if ($ci->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }
        return $aStatus;
    } catch (Exception $Error) {
        return $Error;
    }
}
function FCNxCardRabbitMQGetMassage($paData)
{
    /*$tQname = $paData['tQname'];
		$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
		$channel = $connection->channel();
        $channel->queue_declare($tQname, false, true, false, false);
        $message = $channel->basic_get($tQname);
        if(!empty($message)){
            $channel->basic_ack($message->delivery_info['delivery_tag']);
            $nProgress = intval($message->body);
        }else{
            $nProgress = 'false' ;
        }
        $channel->close();
        $connection->close();
        return $nProgress;*/

    try {
        $tQname = $paData['tQname'];
        $connection = new AMQPStreamConnection(MQ_CRD_HOST, MQ_CRD_PORT, MQ_CRD_USER, MQ_CRD_PASS, MQ_CRD_VHOST);
        $channel = $connection->channel();
        $channel->queue_declare($tQname, false, true, false, false);
        $message = $channel->basic_get($tQname);

        if (!empty($message)) {
            if (!empty($message->body)) {
                $channel->basic_ack($message->delivery_info['delivery_tag']);
                $nProgress = $message->body;
            } else {
                $nProgress = 'end';
            }
        } else {
            $nProgress = 'false';
        }

        $channel->close();
        $connection->close();
        return $nProgress;
    } catch (Exception $Error) {
        return $Error;
    }
}
