<?php 
defined('BASEPATH') or exit('No direct script access allowed');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
require APPPATH .'libraries\rabbitapi\RabbitApi.php';

class cSaleTools extends MX_Controller {

    public function __construct() {
        $this->load->model('sale/salemonitor/mSaleTools');
        parent::__construct();
    }


    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvSTLCallMainPage(){

        $this->load->view('sale/salemonitor/saletools/wSaleToolsMain');
    }   
    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvSTLCallDataTable(){
        try {
  
         
            $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
            );
    
    
            $aTextLangTotalByBranch   = array(
                'tDSHSALModalBranch'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBranch'),
                'tDSHSALModalPos'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPos'),
                'tDSHSALType'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALType'),
                'tDSHSALFromBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALFromBill'),
                'tDSHSALToBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALToBill'),
                'tDSHSALQtyBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALQtyBill'),
                'tDSHSALValue'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALValue'),
                'tDSHSALCheckOut'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALCheckOut'),
                'tDSHSALSale'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALSale'),
                'tDSHSALReturn'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALReturn'),
                'tDSHSALDiff'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALDiff'),
                'tDSHSALDateTBB'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateTBB'),
                'tDSHSALSalesCycle'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALSalesCycle'),
                'tSMTSign-in'   => language('sale/salemonitor/salemonitor', 'tSMTSign-in'),
                'tSMTSign-out'   => language('sale/salemonitor/salemonitor', 'tSMTSign-out'),
    
    
            );
    
            $aListData = array(
                'aTotalSaleByBranchData' => $this->mSaleTools->FSaMSTLSALTotalSaleByBranch($aData),
                'aTextLangTotalByBranchShow' => $aTextLangTotalByBranch,
                'nPage'         => $nPage,
                'tSort' => $this->input->post('oetSTLSALSort'),
                'tfild' => $this->input->post('oetSTLSALFild'),
            );
            $this->load->view('sale/salemonitor/saletools/wSaleToolsDataTable',$aListData);

        } catch (EntityNotFoundException $e) {
            echo "The queue is not found";
        }
        


    }


    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvSTLEventRePair(){

        try{
            $oListItem = $this->input->post('oListItem');

            // {
            //     "ptFunction" : "002",  //ฟังก์ชั่น Sale by Shift
            //     "ptSource" : "AdaStoreback",
            //     "ptDest" : "POS.PosTools",
            //     "ptFilter" : "000010002",
            //     "ptResQ" : "", //ไม่ต้องส่งก็ได้ เพราะไม่ได้ตอบกลับ
            //     "poData" : 
            //      {
            //          "ptFTShfCode" : "2008000010000200013" //ถ้าส่งเป็นว่างมา จะใช้ Shift ล่าสุด
            //      }
            // }

            if(!empty($oListItem)){
                foreach($oListItem as $aData){

                   $aParam = [
                       'ptFunction' => '002',
                       'ptSource' => 'AdaStoreback',
                       'ptDest' => 'POS.PosTools',
                       'ptFilter' => $aData['tRouting'],
                       'ptResQ' => "",
                        'poData' => array(
                            'ptFTShfCode' => $aData['tShiftCode']
                        )
                   ]; 
                    $aMQParams = [
                        "exchangeName" => "PS_XPosTools",
                        "queueName" => "PS_QPos".$aData['tRouting'],
                        "params"    => $aParam
                    ];
                    $tRouting = $aData['tRouting'];

             $this->FSxCSTLRabbitMQRequest($aMQParams,$tRouting);
                }
            }else{

                $aParam = [
                    'ptFunction' => '002',
                    'ptSource' => 'AdaStoreback',
                    'ptDest' => 'POS.PosTools',
                    'ptFilter' => '',
                    'ptResQ' => "",
                     'poData' => array(
                         'ptFTShfCode' => ''
                     )
                ]; 
                 $aMQParams = [
                     "exchangeName" => "PS_XPosTools",
                     "queueName" => "",
                     "params"    => $aParam
                 ];
                 $tRouting = '';

                 $this->FSxCSTLRabbitMQRequest($aMQParams,$tRouting);

            }
        

            // sleep(10);

            // $aResultCallBack = $this->FSaCSTLCallMassageCountOnExchage($aMQParams['queueName']);  


            // if($aResultCallBack['nStaEvent']=='1'){
            //             // if($aResultCallBack['nMassageTotal']=='0'){
            //                 $aReturn = array(
            //                     'nStaEvent'    => '1',
            //                     'tStaMessg'    => 'ok'
            //                 );
            //             // }else{
            //             //         $aReturn = array(
            //             //             'nStaEvent'    => '500',
            //             //             'tStaMessg'    => 'ส่งเรื่องซ่อมเรียบร้อยแล้ว กรุณาเปิดโปรแกรม AdaStoreFront เพื่อประมลผลซ่อมให้สมบูรณ์'
            //             //         );
            //             // }

            // }else{
            //     $aReturn = array(
            //         'nStaEvent'    => '900',
            //         'tStaMessg'    => 'something went wrong.'
            //     );
            // }
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
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

    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSxCSTLRabbitMQRequest($paParams,$ptRouting){

        $tQueueName = $paParams['queueName'];
        $aParams = $paParams['params'];
        $aParams['ptConnStr'] = DB_CONNECT;
        $tExchange = $paParams['exchangeName'];

        $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
        $oChannel = $oConnection->channel();
        // $oChannel->queue_declare($tQueueName, false, false, false, false);
        $oChannel->exchange_declare($tExchange, 'direct', false, false, false);
        $tBinding_key = $ptRouting;
        // $oChannel->queue_bind($tQueueName, $tExchange,$tBinding_key);
        
        $oMessage = new AMQPMessage(json_encode($aParams));
    
        $oChannel->basic_publish($oMessage, $tExchange,$tBinding_key);
        
    
        $oChannel->close();
        $oConnection->close();
            return 1; /** Success */
        }
    

        public function FSaCSTLCallMassageCountOnExchage($ptqueueName){
            try{
    
                $aConfig = [
                    'rabbitHost' => MQ_Sale_HOST,
                    'rabbitPort' => 15672,
                    'rabbitUser' => MQ_Sale_USER,
                    'rabbitPass' => MQ_Sale_PASS
                ];
            $oRabbit = new Application\Libraries\rabbitapi\RabbitApi($aConfig);
            if($ptqueueName!=''){
            $oRabbit->setVirtualHost(MQ_Sale_VHOST);
            $aQueueNameData =  $oRabbit->getQueuesVHost($ptqueueName)->result();
            $nMassage =  @$aQueueNameData['messages_ready'];
            $nUnAck =  @$aQueueNameData['messages_unacknowledged'];
            $nMassageTotal = @$aQueueNameData['messages'];
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok',
                'nMassage'     => $nMassage,
                'nUnAck'       => $nUnAck,
                'nMassageTotal' => $nMassageTotal,
            );
            }else{
                $aReturn = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'ok',
                    'nMassage'     => '0',
                    'nUnAck'       => '0',
                    'nMassageTotal' => '0',
                );
            }

    
            return $aReturn;
        }catch(Exception $Error){
          
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => 'Error'
            );
      
            return $aReturn;
        }
    
        }



}