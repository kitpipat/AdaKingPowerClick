<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAdjustmentcost extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/adjustmentcost/mAdjustmentcost');
    }

    public function index($nBrowseType,$tBrowseOption){
        $aDataConfigView    = array(
            'nBrowseType'       => $nBrowseType,    // nBrowseType สถานะการเข้าเมนู 0 :เข้ามาจากการกด Menu / 1 : เข้ามาจากการเพิ่มข้อมูลจาก Modal Browse ข้อมูล
            'tBrowseOption'     => $tBrowseOption,  // 
            'aAlwEvent'         => FCNaHCheckAlwFunc('docADCCost/0/0'), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('docADCCost/0/0'), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(), // Setting Config การโชว์จำนวนเลขทศนิยม
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave() // Setting Config การ Saveจ ำนวนเลขทศนิยม
        );
        $this->load->view('document/adjustmentcost/wAdjustmentcost',$aDataConfigView);
    }


    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 23/02/2021 Sooksanti(Nont)
    // Return : String View
    // ReturnType : View
    public function FSvCADCFormSearchList(){
        $this->load->view('document/adjustmentcost/wAdjustmentcostFormSearchList');    
    }


    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 06/06/2019 wasin (Yoshi)
    // Return : Object View Data Table
    // ReturnType : object
    public function FSoCASTDataTable(){
        try{
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');

            // Controle Event
            $aAlwEvent          = FCNaHCheckAlwFunc('docADCCost/0/0');

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}

            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'FNLngID'           => $nLangEdit,
                'nPage'             => $nPage,
                'nRow'              => 10,
                'aAdvanceSearch'    => $aAdvanceSearch
            );

            $aDataList  = $this->mAdjustmentcost->FSaMADCGetDataTable($aDataCondition);

            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );

            $tASTViewDataTable = $this->load->view('document/adjustmentcost/wAdjustmentcostDataTable',$aConfigView,true);
            $aReturnData = array(
                'tViewDataTable'    => $tASTViewDataTable,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : Function Call Page Add Adjust Cost
    // Parameters : Ajax and Function Parameter
    // Creator : 24/02/2021 Sooksanti(Nont)
    // Return : String View
    // ReturnType : View
    public function FSvCADCAddPage(){
        try{

        // Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        //Lang ภาษา
        $nLangEdit          = $this->session->userdata("tLangEdit");

        $aDataConfigViewAdd = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'aDataDocHD'        => array('rtCode'=>'99')
        );

        $tViewPageAdd = $this->load->view('document/adjustmentcost/wAdjustmentcostAdd',$aDataConfigViewAdd,true);

        $aReturnData        = array(
            'tViewPageAdd'      => $tViewPageAdd,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : Function Call Page Add Adjust Stock
    // Parameters : Ajax and Function Parameter
    // Creator : 24/02/2021 Sooksanti(Nont)
    // Return : String View
    // ReturnType : View
    public function FSvCADCEditPage(){
        try{
            $tXchDocNo          = $this->input->post('ptXchDocNo');
        // Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        //Lang ภาษา
        $nLangEdit          = $this->session->userdata("tLangEdit");
        
        //Data Master
        $aDataWhere  = array(
            'FTXchDocNo'    => $tXchDocNo,
            'FNLngID'       => $nLangEdit,
            'nRow'          => 10000,
            'nPage'         => 1,
            'FTXchDocKey'   => 'TCNTPdtAdjCostHD',
        );
        $aResult    = $this->mAdjustmentcost->FSaMADCGetHD($aDataWhere);  //TCNTPdtAdjCostHD

        $aDataConfigViewAdd = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'aDataDocHD'        => $aResult,
        );

        $tViewPageAdd = $this->load->view('document/adjustmentcost/wAdjustmentcostAdd',$aDataConfigViewAdd,true);

        $aReturnData        = array(
            'tViewPageAdd'      => $tViewPageAdd,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    // Functionality : Get PDT From Doc
    // Parameters : Ajax and Function Parameter
    // Creator : 25/02/2021 Sooksanti(Nont)
    // Return : 
    // Return Type : object
    public function FSoCADCGetPdtFromDoc(){
        try{
            $tTable         = $this->input->post('tTable');
            $tDocNo         = $this->input->post('tDocNo');
            $tPdtCodeDup    = $this->input->post('tPdtCodeDup');
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aParams = array(
                'tTable' => $tTable,
                'tDocNo' => $tDocNo,
                'tPdtCodeDup' => $tPdtCodeDup,
                'FNLngID' => $nLangEdit,
            );

            $aData = $this->mAdjustmentcost->FSaMADCGetPdtFromDoc($aParams);
            
            if ($aData['rtCode'] == '1') {
                $aReturnData = array(
                    'aData' => $aData['raItems'],
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            } else {
                $aReturnData = array(
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : Get PDT From Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 25/02/2021 Sooksanti(Nont)
    // Return : 
    // Return Type : object
    public function FSoCADCGetPdtFromFilter(){
        try{
            $tPdtCodeFrom         = $this->input->post('tPdtCodeFrom');
            $tPdtCodeTo         = $this->input->post('tPdtCodeTo');
            $tBarCodeFrom    = $this->input->post('tBarCodeFrom');
            $tBarCodeCodeTo    = $this->input->post('tBarCodeCodeTo');
            $tPdtCodeDup    = $this->input->post('tPdtCodeDup');
            $tBchCode    = $this->input->post('tBchCode');
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aParams = array(
                'tPdtCodeFrom' => $tPdtCodeFrom,
                'tPdtCodeTo' => $tPdtCodeTo,
                'tBarCodeFrom' => $tBarCodeFrom,
                'tBarCodeCodeTo' => $tBarCodeCodeTo,
                'tPdtCodeDup' => $tPdtCodeDup,
                'tBchCode'  => $tBchCode,
                'FNLngID' => $nLangEdit,
            );


            $aData = $this->mAdjustmentcost->FSaMADCGetPdtFromFilter($aParams);
            
            if ($aData['rtCode'] == '1') {
                $aReturnData = array(
                    'aData' => $aData['raItems'],
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            } else {
                $aReturnData = array(
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : Get PDT From Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 25/02/2021 Sooksanti(Nont)
    // Return : 
    // Return Type : object
    public function FSoCADCGetPdtFromImportExcel(){
        try{
            $tPdtCodeDup   = $this->input->post('tPdtCodeDup');
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aParams = array(
                'tPdtCodeDup' => $tPdtCodeDup,
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'FNLngID' => $nLangEdit,
            );


            $aData = $this->mAdjustmentcost->FSaMADCGetPdtFromImportExcel($aParams);
            
            if ($aData['rtCode'] == '1') {
                $aReturnData = array(
                    'aData' => $aData['raItems'],
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            } else {
                $aReturnData = array(
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Event Add
    // Parameters : Ajax and Function Parameter
    // Creator : 03/03/2021 Sooksanti(Nont)
    // Return : 
    // Return Type : object
    public function FSoCADCEventAdd(){
        try{
            $tBchCode   = $this->input->post('ohdADCBchCode');
            $tDocDate    = $this->input->post('oetADCDocDate');
            $tDocTime    = $this->input->post('oetADCDocTime');
            $tEffectiveDate    = $this->input->post('oetADCEffectiveDate');
            $tRefInt    = $this->input->post('oetADCRefInt');
            $tRefIntDate    = $this->input->post('oetADCRefIntDate');
            $tRmk   = $this->input->post('otaADCRmk');
            $aDataInsert   = $this->input->post('aDataInsert');
   
            $aStoreParam = array(
                "tTblName"    => 'TCNTPdtAdjCostHD',                           
                "tDocType"    => '10',                                          
                "tBchCode"    => $tBchCode,                                 
                "tShpCode"    => "",                               
                "tPosCode"    => "",                     
                "dDocDate"    => date("Y-m-d")       
            );
            $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
            $aDataMaster['FTXchDocNo']  = $aAutogen[0]["FTXxhDocNo"];

            $this->db->trans_begin();
            // echo '<pre>';
            // print_r($aDataInsert);
            // echo '</pre>';
            foreach ($aDataInsert as $aValue) {
                if(empty($aValue[3])){
                    $tBarScan = '';
                }else{
                    $tBarScan = $aValue[3];
                }

                if(empty($aValue[6])){
                    $tFCXcdCostNew = NULL;
                }else{
                    $tFCXcdCostNew = $aValue[6];
                }

                if(empty($aValue[8])){
                    $tPunCode = '';
                }else{
                    $tPunCode = $aValue[8];
                }
                if(empty($aValue[9])){
                    $nXcdFactor = 0;
                }else{
                    $nXcdFactor = $aValue[9];
                }

                if($aValue[7] != 0){
                    $aDataIns = array(
                        'FTBchCode'         => $tBchCode,
                        'FTXchDocNo'        => $aDataMaster['FTXchDocNo'],
                        'FNXcdSeqNo'        => $aValue[0],
                        'FTPdtCode'         => $aValue[1],
                        'FTPdtName'         => $aValue[2],
                        'FCXcdCostOld'      => $aValue[4],
                        'FCXcdDiff'         => $aValue[5],
                        'FCXcdCostNew'      => $tFCXcdCostNew,
                        'FTPunCode'         => $tPunCode,
                        'FCXcdFactor'       => $nXcdFactor,
                        'FTXcdBarScan'      => $tBarScan,
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'       => '',
                        'FDCreateOn'        => date('Y-m-d H:i:s'),
                        'FTCreateBy'        => $this->session->userdata('tSesUserCode'),
                    );
                    $this->mAdjustmentcost->FSaMADCEventAddDT($aDataIns);
                }

            }
            $aParams = array(
                'FTBchCode'    => $tBchCode,
                'FTXchDocNo'   => $aDataMaster['FTXchDocNo'],
                'FNXchDocType' => 10,
                'FDXchDocDate' => $tDocDate,
                'FTXchDocTime' => $tDocTime,
                'FDXchAffect'  => $tEffectiveDate,
                'FTXchRefInt'  => $tRefInt,
                'FDXchRefIntDate' => $tRefIntDate,
                'FTUsrCode'    => $this->session->userdata("tSesUserCode"),
                'FTXchStaDoc'  => '1',
                'FTXchRmk'     => $tRmk
            );

            $this->mAdjustmentcost->FSaMADCEventAddHD($aParams);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '99',
                    'tStaMessg' => 'not success',
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'success',
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXchDocNo'],
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Event Edit
    // Parameters : Ajax and Function Parameter
    // Creator : 25/02/2021 Sooksanti(Nont)
    // Return : 
    // Return Type : object
    public function FSoCADCEventEdit(){
        try{
            $tDocNo      = $this->input->post('ohdADCDocNo');
            $tBchCode   = $this->input->post('ohdADCBchCode');
            $tDocDate    = $this->input->post('oetADCDocDate');
            $tDocTime    = $this->input->post('oetADCDocTime');
            $tEffectiveDate    = $this->input->post('oetADCEffectiveDate');
            $tRefInt    = $this->input->post('oetADCRefInt');
            $tRefIntDate    = $this->input->post('oetADCRefIntDate');
            $tRmk   = $this->input->post('otaADCRmk');
            $aDataInsert   = $this->input->post('aDataInsert');

            $aParams = array(
                'FTBchCode'    => $tBchCode,
                'FTXchDocNo'   => $tDocNo,
                'FNXchDocType' => 10,
                'FDXchDocDate' => $tDocDate,
                'FTXchDocTime' => $tDocTime,
                'FDXchAffect'  => $tEffectiveDate,
                'FTXchRefInt'  => $tRefInt,
                'FDXchRefIntDate' => $tRefIntDate,
                'FTUsrCode'    => $this->session->userdata("tSesUserCode"),
                'FTXchStaDoc'  => '1',
                'FTXchRmk'     => $tRmk
            );
            $this->db->trans_begin();
            $this->mAdjustmentcost->FSaMADCClearDT($aParams);
            foreach ($aDataInsert as $aValue) {
                if(empty($aValue[3])){
                    $tBarScan = '';
                }else{
                    $tBarScan = $aValue[3];
                }
                if(empty($aValue[6])){
                    $tFCXcdCostNew = NULL;
                }else{
                    $tFCXcdCostNew = $aValue[6];
                }
                if(empty($aValue[8])){
                    $tPunCode = '';
                }else{
                    $tPunCode = $aValue[8];
                }
                if(empty($aValue[9])){
                    $nXcdFactor = 0;
                }else{
                    $nXcdFactor = $aValue[9];
                }
                
                $aDataIns = array(
                    'FTBchCode'         => $tBchCode,
                    'FTXchDocNo'        => $tDocNo,
                    'FNXcdSeqNo'        => $aValue[0],
                    'FTPdtCode'         => $aValue[1],
                    'FTPdtName'         => $aValue[2],
                    'FCXcdCostOld'      => $aValue[4],
                    'FCXcdDiff'         => $aValue[5],
                    'FCXcdCostNew'      => $tFCXcdCostNew,
                    'FTPunCode'         => $tPunCode,
                    'FCXcdFactor'       => $nXcdFactor,
                    'FTXcdBarScan'      => $tBarScan,
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUserCode'),
                );

                $this->mAdjustmentcost->FSaMADCEventAddDT($aDataIns);
            }
            $this->mAdjustmentcost->FSaMADCEventEditHD($aParams);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '99',
                    'tStaMessg' => 'not success',
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'success',
                    'tCodeReturn' => $tDocNo,
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Get PDT From DT
    // Parameters : Ajax and Function Parameter
    // Creator : 03/03/2021 Sooksanti(Nont)
    // Return : 
    // Return Type : object
    public function FSoCADCGetPdtFromDT(){
        try{
            $tDocNo = $this->input->post('tDocNo');
            $aParams = array(
                'tDocNo' => $tDocNo,
            );

            $aData = $this->mAdjustmentcost->FSaMADCGetPdtFromDT($aParams);
            
            if ($aData['rtCode'] == '1') {
                $aReturnData = array(
                    'aData' => $aData['raItems'],
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            } else {
                $aReturnData = array(
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    //Function : Cancel ApproveDoc
    //Parameters : Cancel ApproveDoc
    //Creator : 03/03/2021 Sooksanti(Nont)
    //Return : Array 
    //Return Type : Array
    public function FSoCADCCancel(){
    
        $tXchDocNo =  $this->input->post('tXchDocNo');
        
        $aDataUpdate    =  array(
            'FTXchDocNo'  => $tXchDocNo,
        );

            $aStaApv = $this->mAdjustmentcost->FSaMADCCancel($aDataUpdate);

            if($aStaApv['rtCode'] == 1 ){
                $aApv = array(
                    'nSta'  => 1,
                    'tMsg'  => "Cancel done",
                );
            }else{
                $aApv = array(
                    'nSta' => 2,
                    'tMsg' => "Not Cancel",
                );
            }
            echo json_encode($aApv);
    }

    // Function: Approve Document
    // Parameters: Ajex Event Add Document
    // Creator: 03/03/2021 Sooksanti(Nont)
    // LastUpdate: -
    // Return: Object Status Cancel Document
    // ReturnType: Object
    public function FSvCADCApproveDocument() {
        try {
            $tADCDocNo = $this->input->post('ptADCDocNo');
            $tADCBchCode = $this->input->post('ptADCBchCode');
            
            $aDataUpdate = array(
                'FTXchDocNo' => $tADCDocNo,
                'FTXchApvCode' => $this->session->userdata('tSesUsername')
            );

            $aStaApv = $this->mAdjustmentcost->FSvMADCApprove($aDataUpdate);

            if($aStaApv['rtCode'] == '1'){
                $aMQParams = [
                    "queueName" => "CN_QDocApprove",
                    "params" => [
                        'ptFunction' => "AdjustCost",
                        'ptSource' => 'AdaStoreBack',
                        'ptDest' =>'MQReceivePrc',
                        'ptFilter' => $tADCBchCode,
                        'ptData'=>json_encode([
                            "ptBchCode" => $tADCBchCode,
                            "ptDocNo" => $tADCDocNo,
                            "ptUser" => $this->session->userdata("tSesUsername"),
                        ])
                    ]
                ];
                FCNxCallRabbitMQ($aMQParams);
         
                $aReturn = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'ok'
                );
            }
            else{
                $aReturn = array(
                    'nStaEvent'    => '99',
                    'tStaMessg'    => 'Not Approve'
                );
            }
            
        } catch (ErrorException $err) {
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }
    }

    // Functionality: Function Delete Document Adjust Cost
    // Parameters: Ajax and Function Parameter
    // Creator: 03/03/2021 Sooksanti(Non)
    // Return: Object View Data Table
    // ReturnType: object
    public function FSoCADCDeleteEventDoc(){
        try{    
            $tADCDocNo  = $this->input->post('tADCDocNo');
            $aDataMaster = array(
                'tADCDocNo'     => $tADCDocNo
            );
            $aResDelDoc = $this->mAdjustmentcost->FSnMADCDelDocument($aDataMaster);
            if($aResDelDoc['rtCode'] == '1'){
                $aDataStaReturn  = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }else{
                $aDataStaReturn  = array(
                    'nStaEvent' => $aResDelDoc['rtCode'],
                    'tStaMessg' => $aResDelDoc['rtDesc']
                );
            }
        }catch(Exception $Error){
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }
}



