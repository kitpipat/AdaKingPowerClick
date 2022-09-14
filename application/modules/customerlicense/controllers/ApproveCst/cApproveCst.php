<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cApproveCst extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('customerlicense/ApproveCst/mApproveCst');
        $this->load->model('company/shop/mShop');
        $this->load->model('company/branch/mBranch');
        date_default_timezone_set("Asia/Bangkok");
    }
    

    public function index(){
        $vBtnSave = FCNaHBtnSaveActiveHTML('ApproveCst'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('customerlicense/ApproveCst/wApproveCst',array('vBtnSave'=>$vBtnSave));
    }
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCAPCListPage(){
        $this->load->view('customerlicense/ApproveCst/wApproveCstList');
    }

    /**
     * Functionality : Function Call DataTables Customer
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCAPCDataList(){

        $tCstCode = $this->input->post('tCstCode');
        $nPage      = $this->input->post('nPageCurrent');
        $dCreateOn = $this->input->post('dApvLicStart');
        $tRegBusName = $this->input->post('tAPCRegBusName');
        $tRegLicGroup = $this->input->post('nAPCRegLicGroup');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
     
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'tCstCode'      => $tCstCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'FDCreateOn'    => $dCreateOn,
            'FTRegBusName'   => $tRegBusName,
            'FTRegLicGroup'   => $tRegLicGroup,
        );

        $aResList = $this->mApproveCst->FSaMAPCList($aData);

   
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'FDCreateOn'    => $dCreateOn,
            'FTRegBusName'   => $tRegBusName,
            'FTRegLicGroup'   => $tRegLicGroup,
        );
        $this->load->view('customerlicense/ApproveCst/wApproveCstDataTable', $aGenTable);
    }
    



     /**
     * Functionality : Function CallPage Customer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCAPCEditPage(){
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aParam = array(
            'FNLngID' => $nLangEdit,
            'FNRegID' => $this->input->post('pnRegID'),
        );
        $aResult = $this->mApproveCst->FSaMAPCSearchByID($aParam);
        $aDataAdd = array(
            'aResult'   => $aResult,
            'FNLngID'   => $nLangEdit,
        );

      
        $this->load->view('customerlicense/ApproveCst/wApproveCstPageForm',$aDataAdd);
    }



    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCAPCEditEvent(){
        try{

            $nRegID = $this->input->post('ohdRegID');
            $tRegBusName = $this->input->post('oetRegBusName');
            $nRegQtyBch = $this->input->post('oenRegQtyBch');
            // $nRegLicGroup = $this->input->post('ocmRegLicGroup');
            $nRegLicType = $this->input->post('ocmRegLicType');
            $tRegEmail = $this->input->post('oetRegEmail');
            $tRegTel = $this->input->post('oetRegTel');

       
            $tRegBusOth = $this->input->post('oetRegBusOth');
            
            $tRegRefCst = $this->input->post('oetRegRefCst');
            $nRegStaActive = $this->input->post('ocmRegStaActive');

            $aDataCstBch = array(
                'FNRegID' => $nRegID,
                'FTRegBusName' => $tRegBusName,
                'FNRegQtyBch' => $nRegQtyBch,
                // 'FTRegLicGroup' => $nRegLicGroup,
                'FTRegLicType' => $nRegLicType,
                'FTRegBusOth' => $tRegBusOth,
                'FTRegRefCst' => $tRegRefCst,
                'FTRegStaActive' => $nRegStaActive,
                'FTRegEmail' => $tRegEmail,
                'FTRegTel' => $tRegTel,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUserCode'),
            );

            $this->db->trans_begin();
            $this->mApproveCst->FSaMAPCInsertUpdateApproveCst($aDataCstBch);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'    => '01',
                    'tStaMessg'    => "Sucess Add Event"
                );

            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCAPCAproveEvent(){
        try{

        $nLangEdit      = $this->session->userdata("tLangEdit");
        $rnRegID = $this->input->post('rnRegID');
        $tAPCSrvCode = $this->input->post('tAPCSrvCode');
        
        if(!empty($rnRegID)){

                        $aParamAproveCst = array(
                            'FNLngID' => $nLangEdit,
                            'FNRegID' => $rnRegID,
                        );
                        $aRegCstData = $this->mApproveCst->FSaMAPCSearchByID($aParamAproveCst);
                        
                        $aParamMqCst = array(
                            'ptRegBusName' =>  $aRegCstData['raItems']['FTRegBusName'],
                            'pnRegQtyBch' =>  $aRegCstData['raItems']['FNRegQtyBch'],
                            'ptRegLicType' =>  $aRegCstData['raItems']['FTRegLicType'],
                            'ptRegBusOth' =>  $aRegCstData['raItems']['FTRegBusOth'],
                            'ptCstMail' => $aRegCstData['raItems']['FTRegEmail'],
                            'ptCstTel' => $aRegCstData['raItems']['FTRegTel'],
                            'pnRegID' => $aRegCstData['raItems']['FNRegID'],
                            'ptCstKey' => "",
                            'ptSrvCode' => $tAPCSrvCode
                        );

   
                     $aParamFunctionMq = array(
                             "ptFunction"=>"RG_CstRegister",
                             "ptSource"=>"POS",
                             "ptDest"=>"RegisterServer",
                             "ptFilter"=>"",
                             'ptData' => json_encode($aParamMqCst)
                        );

                     $aParamMaageMq = array(
                            'queueName' => 'RG_CstApprove',
                            'params' => $aParamFunctionMq
                        );


                        $this->FSnCAPCApproveCallMq($aParamMaageMq);

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
    public function FSnCAPCApproveCallMq($paParams){

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
    


    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCAPCExportEvent(){
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $nRegID = $this->input->get('nRegID');
        $aParamAproveCst = array(
            'FNLngID' => $nLangEdit,
            'FNRegID' => $nRegID,
        );
        $aRegCstData = $this->mApproveCst->FSaMAPCSearchByID($aParamAproveCst);
        header('Content-type: application/json');
        header('Content-disposition: attachment; filename=RegId_'.$nRegID.'.json');
        echo json_encode($aRegCstData['raItems']);
        exit();

    }

}
