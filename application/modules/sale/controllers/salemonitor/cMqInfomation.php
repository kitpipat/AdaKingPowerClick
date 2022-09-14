<?php 
defined('BASEPATH') or exit('No direct script access allowed');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
require APPPATH .'libraries\rabbitapi\RabbitApi.php';

class cMqInfomation extends MX_Controller {

    public function __construct() {
        $this->load->model('sale/salemonitor/mMqinformation');
        parent::__construct();
    }


    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvMQICallMainPage(){

        
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "SMTRS", "tUfrRef" => "SMTRS", "tGhdApp" => "SB"];
        $bChkRoleButton = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        
        $aDataPaRam = [
            'bChkRoleButton' => $bChkRoleButton,
        ];
        $this->load->view('sale/salemonitor/mqinformation/wMqinformationMain',$aDataPaRam);
    }   
    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvMQICallDataTable(){
    //    echo APPPATH .'libraries\rabbitapi\RabbitApi.php';
        try {
  
            $aConfig = [
                'rabbitHost' => MQ_Sale_HOST,
                'rabbitPort' => 15672,
                'rabbitUser' => MQ_Sale_USER,
                'rabbitPass' => MQ_Sale_PASS
            ];
            
            $oRabbit = new Application\Libraries\rabbitapi\RabbitApi($aConfig);
            $tQUEUESName = MQ_Sale_QUEUES;
            $aQUEUESName = explode(',',$tQUEUESName);
            $oRabbit->setVirtualHost(MQ_Sale_VHOST);
            
            $aListByQueue = [];
            if(!empty($aQUEUESName)){
                foreach($aQUEUESName as $aDataQueueName){
                    $aListByQueue[] =   $oRabbit->getQueuesVHost($aDataQueueName)->result();    
                }
            }

            // $qlist = $oRabbit->getQueuesVHosts()->result();  
            // $aListByQueue = [];
            // foreach($qlist as $data){
            //     $aListByQueue[] = $data['name'];

            //     if($data['name']=='RESPAY_S2000009000030000030_00010'){
            //         $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
            //         $oChannel = $oConnection->channel();
            //         $oChannel->queue_delete($data['name']);
            //         $oChannel->close();
            //         $oConnection->close();
            //     }

            // }   
            // echo '<pre>';
            //   echo print_r($aListByQueue);
            //   echo '</pre>';
            $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "SMTRS", "tUfrRef" => "SMTRS", "tGhdApp" => "SB"];
            $bChkRoleButton = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
            $aDataPaRam = [
                'aListByQueue' => $aListByQueue,
                'bChkRoleButton' => $bChkRoleButton,
            ];

            $this->load->view('sale/salemonitor/mqinformation/wMqinformationDataTable',$aDataPaRam);

        } catch (EntityNotFoundException $e) {
            echo "The queue is not found";
        }
        


    }


    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvMQIEventReConsumer(){

        try{
            $oListItem = $this->input->post('oListItem');

            $aMQParams = [
                "exchangeName" => "AR_XReStartConsumer",
                "queueName" => "",
                "params"    => array(
                    'ptFunction' => "Restart MQ",
                    'ptSource' => "AdaStoreback",
                    'ptDest' => "MQReceuvePrc",
                    'ptFilter' => MQ_Sale_VHOST,
                    'paData' => $oListItem
                )
            ];
            $tRouting = '';

            $this->FSxCMQIRabbitMQRequest($aMQParams);

            sleep(5);

            $aResultCallBack = $this->FSaCMQICallMassageCountOnExchage($aMQParams['exchangeName']);  



            if($aResultCallBack['nStaEvent']=='1'){
                        if($aResultCallBack['nMassage']=='0' && $aResultCallBack['nUnAck']=='0'){
                            $aReturn = array(
                                'nStaEvent'    => '1',
                                'tStaMessg'    => 'ok'
                            );
                        }else{
                            if($aResultCallBack['nUnAck']!='0'){
                                $aReturn = array(
                                    'nStaEvent'    => '500',
                                    'tStaMessg'    => 'ทำงานไม่สำเร็จ'
                                );
                             }else if($aResultCallBack['nMassage']!='0'){
                                $aReturn = array(
                                    'nStaEvent'    => '500',
                                    'tStaMessg'    => 'Consumer ไม่ทำงาน'
                                );
                             }
                        }

            }else{
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => 'something went wrong.'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => 'Error'
            );
            echo json_encode($aReturn);
            return;
        }

        
    }


    public function FSaCMQICallMassageCountOnExchage($ptExchangeName){
        try{

            $aConfig = [
                'rabbitHost' => MQ_Sale_HOST,
                'rabbitPort' => 15672,
                'rabbitUser' => MQ_Sale_USER,
                'rabbitPass' => MQ_Sale_PASS
            ];
        $oRabbit = new Application\Libraries\rabbitapi\RabbitApi($aConfig);
            
        $oRabbit->setVirtualHost(MQ_Sale_VHOST);
        $exchangeList = $oRabbit->getQueueNameByExchange($ptExchangeName)->result();
            $nMassage = 0;
            $nUnAck = 0;
        if(!empty($exchangeList)){
                foreach($exchangeList as $aData){
                    $aQueueNameByExchange =  $oRabbit->getQueuesVHost($aData['destination'])->result();
                    $nMassage = $nMassage + @$aQueueNameByExchange['messages_ready'];
                    $nUnAck = $nUnAck + @$aQueueNameByExchange['messages_unacknowledged'];
                }
                $aReturn = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'ok',
                    'nMassage'     => $nMassage,
                    'nUnAck'       => $nUnAck,
                );
        }else{
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok',
                'nMassage'     => '1',
                'nUnAck'       => '0',
            );
        }
        // echo json_encode($exchangeList);
        // die();

        return $aReturn;
    }catch(Exception $Error){
      
        $aReturn = array(
            'nStaEvent'    => '900',
            'tStaMessg'    => 'Error'
        );
  
        return $aReturn;
    }

    }

    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSxCMQIRabbitMQRequest($paParams,$ptRouting=null){

        $tQueueName = $paParams['queueName'];
        $aParams = $paParams['params'];
        $aParams['ptConnStr'] = DB_CONNECT;
        $tExchange = $paParams['exchangeName'];

        $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
        $oChannel = $oConnection->channel();
        // $oChannel->queue_declare($tQueueName, false, false, false, false);
        $oChannel->exchange_declare($tExchange, 'fanout', false, false, false);
        $tBinding_key='';
        // $oChannel->queue_bind($tQueueName, $tExchange,$tBinding_key);
        
        $oMessage = new AMQPMessage(json_encode($aParams));
    
        // $tRouting = '';
        // if(!empty($aParams['ptBchCode'])){
        //     $tRouting .= $aParams['ptBchCode'];   
        // }
        // if(!empty($aParams['ptPosCode'])){
        //     $tRouting .= $aParams['ptPosCode'];   
        // }

        if(!empty($ptRouting)){
            $oChannel->basic_publish($oMessage, $tExchange,$tRouting);
        }else{
            $oChannel->basic_publish($oMessage, $tExchange);
        }
    
        $oChannel->close();
        $oConnection->close();
            return 1; /** Success */
        }
    

}