<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cApproveLic extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('customerlicense/ApproveLic/mApproveLic');
        $this->load->model('company/shop/mShop');
        $this->load->model('company/branch/mBranch');
        date_default_timezone_set("Asia/Bangkok");
    }
    

    public function index(){
        $vBtnSave = FCNaHBtnSaveActiveHTML('ApproveLic'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('customerlicense/ApproveLic/wApproveLic',array('vBtnSave'=>$vBtnSave));
    }
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCAPLListPage(){
        $this->load->view('customerlicense/ApproveLic/wApproveLicList');
    }

    /**
     * Functionality : Function Call DataTables Customer
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCAPLDataList(){

        $tCstCode = $this->input->post('tCstCode');
        $nPage      = $this->input->post('nPageCurrent');
        $dXshDocDate = $this->input->post('dApvLicStart');
        $tAPCKeyword = $this->input->post('tAPCKeyword');


        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
     
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'tCstCode'      => $tCstCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'FDXshDocDate'    => $dXshDocDate,
            'tAPCKeyword'   => $tAPCKeyword,
     
        );

        $aResList = $this->mApproveLic->FSaMAPLList($aData);

        $nDecimalShow = FCNxHGetOptionDecimalShow();
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'dXshDocDate'    => $dXshDocDate,
            'FDXshDocDate'   => $tAPCKeyword,
            'nDecimalShow' => $nDecimalShow
     
        );
        $this->load->view('customerlicense/ApproveLic/wApproveLicDataTable', $aGenTable);
    }
    



     /**
     * Functionality : Function CallPage Customer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCAPLEditPage(){
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aParam = array(
            'FNLngID' => $nLangEdit,
            'tDocumentNumber' => $this->input->post('ptDocumentNumber'),
        );

        $aRegBusTypeName = array(
            1 => 'Grocery Store',
            2 => 'Mini-mart',
            3 => 'ร้านอาหาร & เครื่องดื่ม',
            4 => 'Specialty Store',
            5 => 'Other (Department Store ,Supermarket,Hypermarket,Shopping Mall,Convenience Store)',
        );

        $nDecimalShow = FCNxHGetOptionDecimalShow();
        $aResultPdtHD = $this->mApproveLic->FSaMAPLDataHD($aParam);
        $aResultPdtDT = $this->mApproveLic->FSaMAPLDataDT($aParam);
        $aDataAdd = array(
            'aResultPdtHD'   => $aResultPdtHD,
            'aResultPdtDT'   => $aResultPdtDT,
            'nDecimalShow'   => $nDecimalShow,
            'aRegBusTypeName'=> $aRegBusTypeName,
            'FNLngID'        => $nLangEdit,
        );
      
        $this->load->view('customerlicense/ApproveLic/wApproveLicPageForm',$aDataAdd);
    }


    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCAPLAproveEvent(){
        try{

        $nLangEdit      = $this->session->userdata("tLangEdit");
        $tCstKey = $this->input->post('tCstKey');
        $tDocNo = $this->input->post('tDocNo');
        $dCbrLicStrDate = $this->input->post('dCbrLicStrDate');
        
        
        $aDataUpdate = array(
            'FTXshDocNo' => $tDocNo,
            'FTXshStaPaid' => 3,
            'FDLastUpdOn' => date('Y-m-d H:i:s'),
            'FTLastUpdBy' => $this->session->userdata('tSesUserCode'),
        );

          $aResult =  $this->mApproveLic->FSaMAPLUpdateApproveLic($aDataUpdate);

            $aDataUpdateSalRC = array(
                'FTXshDocNo' => $tDocNo,
                'FNXrcSeqNo' => 1 ,
                'FDXrcRefDate' => $dCbrLicStrDate,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUserCode'),
            );

          $this->mApproveLic->FSaMAPLUpdateDateApproveSalRC($aDataUpdateSalRC);

        if($aResult['rtCode']=='01'){
    

                        $aParamMqCst = array(
                            'ptDocNo' =>  $tDocNo,
                            'ptCstKey' => $tCstKey
                        );

   
                     $aParamFunctionMq = array(
                             "ptFunction"=>"RG_CstRegister",
                             "ptSource"=>"POS",
                             "ptDest"=>"RegisterServer",
                             "ptFilter"=>"",
                             'ptData' => json_encode($aParamMqCst)
                        );

                     $aParamMaageMq = array(
                            'queueName' => 'RG_LicApprove',
                            'params' => $aParamFunctionMq
                        );

                        // print_r(json_encode($aParamMaageMq));
                        // die();
                        $this->FSnCAPLApproveCallMq($aParamMaageMq);

            }
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => "Success"
            );
        }catch(\ErrorException $err){
            // $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => language('common/main/main', 'tApproveFail')
            );
        }

        echo json_encode($aReturn);
            /** Success */

    }



    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSnCAPLApproveCallMq($paParams){

        $tQueueName = $paParams['queueName'];
        $aParams    = $paParams['params'];
        $aParams['ptConnStr']   = DB_CONNECT;
        $tExchange              = EXCHANGE; // This use default exchange
        $oConnection = new AMQPStreamConnection(LICENSE_HOST, LICENSE_PORT, LICENSE_USER, LICENSE_PASS, LICENSE_VHOST);

        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);

        $oChannel->close();
        $oConnection->close();

        return 1;
        /** Success */

    }
    


  

}
