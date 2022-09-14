<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cChkSaleOrderApprove extends MX_Controller {

    public function __construct() {
        date_default_timezone_set("Asia/Bangkok");
        parent::__construct();
        $this->load->model('document/checksaleorderapprove/mChkSaleOrderApprove');
        $this->load->helper('array_helper');
    }

    public function index($pnBrowseType,$ptBrowseOption){
        $aDataConfigView    = [
            'nChkSoBrowseType'     => $pnBrowseType,
            'tChkSoBrowseOption'   => $ptBrowseOption,
            'aAlwEvent'            => FCNaHCheckAlwFunc('dcmCheckSO/0/0'),
            'vBtnSave'             => FCNaHBtnSaveActiveHTML('dcmCheckSO/0/0'),
            'nOptDecimalShow'      => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'      => FCNxHGetOptionDecimalSave()
        ];

        $aMQParams = [
            "queuesname" => "MQAPROVE".$this->session->userdata('tSesSessionID'),
            "exchangname" => "EX_MQApprove",
            "params" => [
                "ptBchCode" => "",
                "ptDocNo" => "",
                "ptDocType" => 1,
                "ptUser" => $this->session->userdata('tSesUsername'),
                "ptConnStr" => 0
            ]
        ];
        // FCNxRentalCallRabbitMQ($aMQParams);

        $this->load->view('document/checksaleorderapprove/wChkSaleOrderApproveFormSearchList',$aDataConfigView);
    } 

    // Functionality: Function Call Page Booking Locker Main
    // Parameters: Ajax and Function Parameter
    // Creator: 22/01/2019 Witsarut(Bell)
    // Return: String View
    // ReturnType: View
    public function FSvCCHKSoCallPageMain(){

        $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $tBchCode           = $this->session->userdata('tSesUsrBchCom');

        // Page Current 
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        // Lang ภาษา
        $nLangEdit = $this->session->userdata("tLangEdit");

        // Data Conditon Get Data Document
        $aDataCondition     = array(
            'FTBchCode'      => $tBchCode,
            'FNLngID'        => $nLangEdit,
            'nPage'          => $nPage,
            'nRow'           => 10,
            'aAdvanceSearch' => $aAdvanceSearch,
            'aDatSessionUserLogIn' => $this->session->userdata("tSesUsrInfo")
        );

        //Get Data of SOHD
        $aResultData    = $this->mChkSaleOrderApprove->FSaMCHKSoGetDetailData($aDataCondition);

        //Get Data Loop for Seq 1-6
        $aResultSeq = $this->mChkSaleOrderApprove->FSaMCHKSoGetdataloop($aDataCondition);

        if($aResultData['rtCode'] == 800){
            $aDataSeq   = [];
        }else{
            $aDataSeq=array();
            foreach($aResultData['raItems'] as $nK => $aValue){
                $aDataSeq[$aValue['LastSeq']][] = $aValue;
            }
        }
        $nSetLimitTimeReloadPageMain = $this->mChkSaleOrderApprove->FSnMCHKSoGetTimeMonitorCountDown();

        $aDataConfigView    =  [
            'aResultSeq'        => $aResultSeq,
            'aResultData'       => $aDataSeq,
            'aAlwEventBKL'      => FCNaHCheckAlwFunc('dcmCheckSO/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave(),
            'nSetLimitTimeReloadPageMain' => ($nSetLimitTimeReloadPageMain*1000)
        ];
        $tQueueName['queueName'] = 'AR_QNotiMsgByUser'.$this->session->userdata('tSesUserCode');
        $tQueueName['params'] = '';
        FCNxStatDoseRabbitMQDeleteQName($tQueueName);
        $this->load->view('document/checksaleorderapprove/wChkSaleOrderApproveMain',$aDataConfigView);
    }

    // Functionality: Function Get Massage MQ On Exchage
    // Parameters: Ajax and Function Parameter
    // Creator: 22/01/2019 Nattakit(Nale)
    // Return: String View
    // ReturnType: View
    public function FSvCCHKSoGetMassage(){
        // try{
            // echo 'text';
            $tExchangeName   = 'AR_XSaleOrder';
            $tQueuesName     = $this->input->post('tQName');
            $tBindingKey     = "";
            $oConnection = new AMQPStreamConnection(STATDOSE_HOST, STATDOSE_PORT, STATDOSE_USER, STATDOSE_PASS, STATDOSE_VHOST);
            $oChannel = $oConnection->channel();

               // Declare Exchange Name
              $oChannel->exchange_declare( $tExchangeName, 'fanout', false, true, false  );
              $oChannel->queue_declare($tQueuesName, false, true, false, false);
                  // Binding Queues To Exchange
              $oChannel->queue_bind($tQueuesName,$tExchangeName,$tBindingKey);

              $tMessage    = $oChannel->basic_get($tQueuesName);
             if(!empty($tMessage->body)){
                 $oChannel->basic_ack($tMessage->delivery_info['delivery_tag']);
                 
                  $aMessage = json_decode($tMessage->body); 

                  $aMessageData =json_decode($aMessage->ptData);

                  $tFTBchCode = $aMessageData->ptFTBchCode;

                  $tSesUsrBchCodeMulti =  $this->session->userdata('tSesUsrBchCodeMulti');
                  $tBchCode   = str_replace("'","",$tSesUsrBchCodeMulti);
                  $aBchCode   = explode(",",$tBchCode);


                  $nLoopCheckBch = 0;
                  if(!empty($aBchCode)){
                      foreach($aBchCode as $tBchCodeValue){
                          if($tBchCodeValue == $tFTBchCode){
                              $nLoopCheckBch++;
                          }
                      }
                  }

                  if($nLoopCheckBch>0){
                    echo  $nLoopCheckBch ;
                  }else{
                    echo  'false' ; 
                  }
                }else{
                  echo  'false' ;
                }
     

            // return $tMassge;
            $oChannel->close();
            $oConnection->close();
        // }catch(Exception $Error){
        //     return $Error;
        // }
    }

}