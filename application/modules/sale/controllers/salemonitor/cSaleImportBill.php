<?php 
defined('BASEPATH') or exit('No direct script access allowed');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cSaleImportBill extends MX_Controller {

    public function __construct() {
        $this->load->model('sale/salemonitor/mSaleImportBill');
        parent::__construct();
    }


    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCIMPCallMianPage(){

        $this->load->view('sale/salemonitor/saleimportbill/wSaleImportBillMain');
    }   
    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCIMPCallPageFrom(){
    //    echo APPPATH .'libraries\rabbitapi\RabbitApi.php';
        try {
  

            $aGetDT     = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => 1,
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
            $aGetHD     = array(
                            'rtCode'        => '800',
                            'rtDesc'        => 'data not found'
                        );

            $aPackData  = array(
                'nPage'         => 1,
                'aGetDT'        => $aGetDT,
                'aGetHD'        => $aGetHD,
                'tTypePage'     => 'Insert'
            );
            $this->load->view('sale/salemonitor/saleimportbill/wSaleImportPageFrom',$aPackData);

        } catch (EntityNotFoundException $e) {
            echo "The queue is not found";
        }
        

    }

    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCIMPCallDataTable(){
        try {
  
            $this->load->view('sale/salemonitor/saleimportbill/wSaleImportDataTable');

        } catch (EntityNotFoundException $e) {
            echo "The queue is not found";
        }

    }

    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCIMPEventReConsumer(){

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

            $this->FSxCIMPRabbitMQRequest($aMQParams);
            
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
    public function FSxCIMPRabbitMQRequest($paParams,$ptRouting=null){

        $tQueueName = $paParams['queueName'];
        $aParams = $paParams['params'];
        $aParams['ptConnStr'] = DB_CONNECT;
        $tExchange = $paParams['exchangeName'];

        $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, false, false, false);
        $oChannel->exchange_declare($tExchange, 'fanout', false, false, false);
        $tBinding_key='';
        $oChannel->queue_bind($tQueueName, $tExchange,$tBinding_key);
        
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
    
    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
        public function FSaCIMPUploadFile(){
            try{
               
                $oefSaleImportBillFile = $_FILES['oefSaleImportBillFile'];
                $oStringBillFile = file_get_contents($oefSaleImportBillFile['tmp_name']);
                $aBillFile = json_decode($oStringBillFile, true);
                // print_r($aBillFile);

                $aoTPSTSalHD = $aBillFile['aoTPSTSalHD'];
                $aoTPSTSalHDDis = $aBillFile['aoTPSTSalHDDis'];
                $aoTPSTSalHDCst = $aBillFile['aoTPSTSalHDCst'];
                $aoTPSTSalDT = $aBillFile['aoTPSTSalDT'];
                $aoTPSTSalDTDis = $aBillFile['aoTPSTSalDTDis'];
                $aoTPSTSalDTPmt = $aBillFile['aoTPSTSalDTPmt'];
                $aoTPSTSalRC = $aBillFile['aoTPSTSalRC'];
                $aoTPSTSalRD = $aBillFile['aoTPSTSalRD'];
                $aoTPSTSalPD = $aBillFile['aoTPSTSalPD'];
                $aoTCNTMemTxnSale = $aBillFile['aoTCNTMemTxnSale'];
                $aoTCNTMemTxnRedeem = $aBillFile['aoTCNTMemTxnRedeem'];
                

                $tXshDocNo = $aoTPSTSalHD[0]['FTXshDocNo'];
                // echo $tXshDocNo;
                $this->db->trans_begin();
                $this->mSaleImportBill->FSaMIMPAddUpdateBill($aBillFile);
                $this->mSaleImportBill->FSaMIMPUpdateSalHDSpc($tXshDocNo);
                $this->mSaleImportBill->FSaMIMPUpdateSalDTSpc($tXshDocNo);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aDataStaReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Import Unsucess"
                    );
                }else{
                    $this->db->trans_commit();
                    $aDataStaReturn = array(
                        'tCodeReturn'	=> $tXshDocNo,
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Import Success'
                    );
                }

            }catch (Exception $Error) {
                $aDataStaReturn = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => $Error->getMessage()
                );
            }
            echo json_encode($aDataStaReturn);
        }


          //Load Datatable
              
    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCIMPLoadDatatable(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tSearchPDT         = $this->input->post('tSearchPDT');
        $nPage              = $this->input->post('nPage');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $aWhere = array(
            'tDocumentNumber' => $tDocumentNumber,
            'tSearchPDT'      => $tSearchPDT,
            'nRow'            => 10,
            'nPage'           => $nPage ,
            'nLangEdit'       => $nLangEdit
        );

        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $aGetDT     = array(
                            'rnAllRow'      => 0,
                            'rnCurrentPage' => 1,
                            "rnAllPage"     => 0,
                            'rtCode'        => '800',
                            'rtDesc'        => 'data not found'
                        );
            $aGetHD     = array(
                            'rtCode'        => '800',
                            'rtDesc'        => 'data not found'
                        );
        }else{
            $aGetDT     = $this->mSaleImportBill->FSaMIMPGetDT($aWhere);
            $aGetHD     = $this->mSaleImportBill->FSaMIMPGetHD($aWhere);
        }

        // $aGetDT     = $this->mTaxinvoice->FSaMTAXGetDT($aWhere);
        // $aGetHD     = $this->mTaxinvoice->FSaMTAXGetHD($aWhere);

        $aPackData  = array(
            'nPage'         => $nPage,
            'aGetDT'        => $aGetDT,
            'aGetHD'        => $aGetHD,
            'tTypePage'     => 'Insert'
        );
        $aReturnData = array(
            'tContentPDT'         => $this->load->view('sale/salemonitor/saleimportbill/wSaleImportDataTable',$aPackData, true),
            'tContentSumFooter'   => $this->load->view('sale/salemonitor/saleimportbill/wSaleImportBillSumFooter',$aPackData, true),
            'aDetailHD'           => $aGetHD
        );
        echo json_encode($aReturnData);
    }

        
    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSaCIMPInsertBillData(){
        try{

        $tImpXthDocNo = $this->input->post('tImpXthDocNo');

        $aDataWhere = array(
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tImpXthDocNo' => $tImpXthDocNo
        );
        $this->db->trans_begin();
        $this->mSaleImportBill->FSaMIMPTPSTSalHD($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalDT($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalDTDis($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalDTPmt($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalHDCst($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalHDDis($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalPD($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalRC($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTPSTSalRD($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTCNTMemTxnRedeem($aDataWhere);
        $this->mSaleImportBill->FSaMIMPTCNTMemTxnSale($aDataWhere);
         if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aDataStaReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Insert Unsucess"
                );
            }else{
                $this->db->trans_commit();
                $aDataStaReturn = array(
                    'tCodeReturn'	=> $tImpXthDocNo,
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Insert Success'
                );
            }

        }catch (Exception $Error) {
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);


    }

}