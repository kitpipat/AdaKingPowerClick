<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/*require_once(APPPATH.'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH.'controllers/rabbitmq/config.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;*/


class cRabbitMQ extends MX_Controller {

    public function __construct() {
        parent::__construct ();
    }

    /**
     * Functionality : Delete queue chanel by name
     * Parameters : -
     * Creator : 22/02/2019 piya
     * Last Modified : -
     * Return : status
     * Return Type : string
     */
    public function FStDeleteQname(){
        $tPrefixQname  = $this->input->post('tPrefixQname');
        $ptDocNo  = $this->input->post('ptDocNo');
        $ptUsrCode  = $this->input->post('ptUsrCode');
        $ptBchCode  = $this->input->post('ptBchCode');
        $aDelQnameParam = json_decode($this->input->post('tDelQnameParam'), true);
        $tVhostType = isset($aDelQnameParam['tVhostType'])?$aDelQnameParam['tVhostType']:"D";

        try{    
            $paParams = [
                "prefixQueueName" => $tPrefixQname, 
                "tVhostType" => $tVhostType,
                "params" => [
                    "ptBchCode" => $ptBchCode, 
                    "ptDocNo" => $ptDocNo, 
                    "ptUsrCode" => $ptUsrCode
                ]
            ];
            FCNxRabbitMQDeleteQName($paParams);
        }catch(\ErrorException $err){
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => 'Delete Qname fail.',
                'err' => $err
            );
            echo json_encode($aReturn);
        }
    }
    
    /**
     * Functionality : Update Status Delete queue name
     * Parameters : -
     * Creator : 22/02/2019 piya
     * Last Modified : -
     * Return : status
     * Return Type : string
     */
    public function FStUpdateStaDeleteQname(){
        try{    
            $tDocTableName = $this->input->post('ptDocTableName');
            $tDocFieldDocNo = $this->input->post('ptDocFieldDocNo');
            $tDocFieldStaApv = $this->input->post('ptDocFieldStaApv');
            $tDocFieldStaDelMQ = $this->input->post('ptDocFieldStaDelMQ');
            $tDocStaDelMQ = $this->input->post('ptDocStaDelMQ');
            $tDocNo = $this->input->post('ptDocNo');
            
            $aData = [
                'tDocTableName' => $tDocTableName,
                'tDocFieldDocNo' => $tDocFieldDocNo,
                'tDocFieldStaApv' => $tDocFieldStaApv,
                'tDocFieldStaDelMQ' => $tDocFieldStaDelMQ,
                'tDocStaDelMQ' => $tDocStaDelMQ,
                'tDocNo' => $tDocNo
            ];
            FSaHRabbitMQUpdateStaDelQnameHD($aData);
        }catch(\ErrorException $err){
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => 'Update Status Delete Qname fail.',
                'err' => $err
            );
            echo json_encode($aReturn);
        }
    }

}





