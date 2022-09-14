<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAdjustStockSum extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->helper("file");
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/adjuststocksum/mAdjustStockSum');
    }

    public function index($nBrowseType, $tBrowseOption){
        
        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
     	$aData['aAlwEvent'] = FCNaHCheckAlwFunc('docSM/0/0'); // Controle Event
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('docSM/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        // Get Option Show Decimal
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow(); 
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave(); 

        $this->load->view('document/adjuststocksum/wAdjustStockSum', $aData);

    }
    
    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : String View
    // Return Type : View
    public function FSvCSMFormSearchList(){
        $this->load->view('document/adjuststocksum/wAdjustStockSumFormSearchList');
    }


     // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCSMGetDataTable() {
        try{
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');
            $aAlwEvent          = FCNaHCheckAlwFunc('docSM/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Page Current 
            if ($nPage == '' || $nPage == null) {
                $nPage = 1;
            } else {
                $nPage = $this->input->post('nPageCurrent');
            }

            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition = array(
                'FNLngID'   => $nLangEdit,
                'nPage'     => $nPage,
                'nRow'      => 10,
                'aDatSessionUserLogIn'  => $this->session->userdata("tSesUsrInfo"),
                'aAdvanceSearch'        => $aAdvanceSearch
            );
            $aDataList      = $this->mAdjustStockSum->FSaMAdjStkSumDataTableList($aDataCondition);
            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tRDHViewDataTableList  = $this->load->view('document/adjuststocksum/wAdjustStockSumDataTable',$aConfigView,true);
            $aReturnData = array(
                'tRDHViewDataTableList' => $tRDHViewDataTableList,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        }catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        unset($aAdvanceSearch);
        unset($nPage);
        unset($aAlwEvent);
        unset($nOptDecimalShow);
        unset($nPage);
        unset($nLangEdit);
        unset($aDataCondition);
        unset($aDataList);
        unset($aConfigView);
        unset($tRDHViewDataTableList);
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCSMCallPageAdd(){
        // Get Option Show Decimal
        $nOptDecimalShow        = FCNxHGetOptionDecimalShow();
        // Get Option Doc Save
        $nOptDocSave            = FCNnHGetOptionDocSave();
        $tBchCodeLogin          = (!empty($this->session->userdata('tSesUsrBchCodeDefault')) ? $this->session->userdata('tSesUsrBchCodeDefault') : $this->session->userdata('tSesUsrBchCodeDefault'));
        $nLngID                 = FCNaHGetLangEdit();
        $tShpCode               =  (!empty($this->session->userdata('tSesUsrShpCode')) ? $this->session->userdata('tSesUsrShpCode') : $this->session->userdata('tSesUsrShpCode'));
        $aCompInfoParams        = [
            'nLngID'   => $nLngID,
            'tBchCode' => $tBchCodeLogin
        ];
        $aResultCompany = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];


         $tSMUserLevel = $this->session->userdata('tSesUsrLevel');
         $tSMBchCode = ($tSMUserLevel == 'HQ') ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
         $tSMDocNo   = $this->input->post('tSMDocNo');
        // $aDataPdtParams = array(
        //     'tDocNo'      => $tSMDocNo,
        //     'tBchCode'    => $tSMBchCode,
        //     'tSessionID'  => $this->session->userdata('tSesSessionID'),
        // );
        $this->mAdjustStockSum->FSxMClearPdtInTmp();
        // $this->mConditionRedeem->FSxMSMClearTempRedeemDefaultDT($aDataPdtParams);


        $aDataConfigViewAdd = [
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'tUserBchCode'      => $tSMBchCode,
            'tUserShpCode'      => $tShpCode,
            'aDataDocHD'        => array('rtCode' => '800'),
        ];
        $tSMViewPageAdd    = $this->load->view('document/adjuststocksum/wAdjustStockSumAdd',$aDataConfigViewAdd,true);
        $aReturnData        = [
            'tSMViewPageAdd'   => $tSMViewPageAdd,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        ];
        unset($nOptDecimalShow);
        unset($nOptDocSave);
        unset($aDataConfigViewAdd);
        unset($tRDHViewPageAdd);
        echo json_encode($aReturnData);
    }



    public function FSoCSMCallPageEdit(){

        // Get Option Show Decimal
        $nOptDecimalShow        = FCNxHGetOptionDecimalShow();
        // Get Option Doc Save
        $nOptDocSave            = FCNnHGetOptionDocSave();
        $tBchCodeLogin          = (!empty($this->session->userdata('tSesUsrBchCodeDefault')) ? $this->session->userdata('tSesUsrBchCodeDefault') : $this->session->userdata('tSesUsrBchCodeDefault'));
        $nLngID                 = FCNaHGetLangEdit();
        $tShpCode               =  (!empty($this->session->userdata('tSesUsrShpCode')) ? $this->session->userdata('tSesUsrShpCode') : $this->session->userdata('tSesUsrShpCode'));
        $aCompInfoParams        = [
            'nLngID'   => $nLngID,
            'tBchCode' => $tBchCodeLogin
        ];
        $aResultCompany = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];


         $tSMUserLevel = $this->session->userdata('tSesUsrLevel');
         $tSMBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
         $tSMDocNo   = $this->input->post('ptAjhDocNo');
        $aDataPdtParams = array(
            'FTAjhDocNo'      => $tSMDocNo,
            'tBchCode'    => $tSMBchCode,
            'FNLngID'   => $nLngID,
            'tSessionID'  => $this->session->userdata('tSesSessionID'),
        );
        $this->mAdjustStockSum->FSxMClearPdtInTmp();
        // $this->mConditionRedeem->FSxMSMClearTempRedeemDefaultDT($aDataPdtParams);
        $aDataDocHD = $this->mAdjustStockSum->FSaMAdjStkSumGetHD($aDataPdtParams);
        $this->mAdjustStockSum->FSaMAdjStkSumInsertDTToTemp($aDataPdtParams);
        $this->mAdjustStockSum->FSaMAdjStkSumInsertDTFhnToTemp($aDataPdtParams);
        
        $aDataConfigViewAdd = [
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'tUserBchCode'      => $tSMBchCode,
            'tUserShpCode'      => $tShpCode,
            'aDataDocHD'        => $aDataDocHD,
        ];
        $tSMViewPageAdd    = $this->load->view('document/adjuststocksum/wAdjustStockSumAdd',$aDataConfigViewAdd,true);
        $aReturnData        = [
            'tSMViewPageAdd'   => $tSMViewPageAdd,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        ];
        unset($nOptDecimalShow);
        unset($nOptDocSave);
        unset($aDataConfigViewAdd);
        unset($tRDHViewPageAdd);
        echo json_encode($aReturnData);

    }

    // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCSMCallTableLoadData(){

        $tSearchAll     = $this->input->post('tSearchAll');
        $tAjhDocNo      = $this->input->post('tAjhDocNo');
        $tAjhStaApv     = $this->input->post('tAjhStaApv');
        $tAjhStaDoc     = $this->input->post('tAjhStaDoc');
        $tAjhBchCode    = $this->input->post('tAjhBchCode');
        $tAjhWahCode    = $this->input->post('tAjhWahCode');
        $nAdjCheckTime  = $this->input->post('nAdjCheckTime');
        $nPage          = $this->input->post('nPageCurrent');

        $aDataWhere = array(
            'tSearchAll' => $tSearchAll,
            'FTAjhDocNo' => $tAjhDocNo,
            'FTXthDocKey' => 'TCNTPdtAdjStkHD',
            'FTBchCode'  => $tAjhBchCode,
            'FTWahCode'  => $tAjhWahCode,
            'nAdjCheckTime'  => $nAdjCheckTime,
            'nPage' => $nPage,
            'nRow' => 10,
            'FTSessionID' => $this->session->userdata('tSesSessionID'),
        );

        // คำนวน DT ใหม่
        // $aResCalDTTmp = $this->FSnCAdjStkSubCalulateDTTemp($tAjhDocNo, $tXthVATInOrEx);

        // Edit in line
        $tPdtCode = $this->input->post('ptPdtCode');
        $tPunCode = $this->input->post('ptPunCode');

        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        $aColumnShow = FCNaDCLGetColumnShow('TCNTPdtAdjStkDT');

        $aDataDT = $this->mAdjustStockSum->FSaMAdjStkSumGetDTTempListPage($aDataWhere);

        // $aDataDTSum = $this->mAdjustStockSum->FSaMAdjStkSumSumDTTemp($aDataWhere);

        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aColumnShow']       = $aColumnShow;
        $aData['tPdtCode']          = $tPdtCode;
        $aData['tPunCode']          = $tPunCode;
        $aData['aDataDT']           = $aDataDT;
        // $aData['aDataDTSum']        = $aDataDTSum;
        $aData['tAjhStaApv']        = $tAjhStaApv;
        $aData['tAjhStaDoc']        = $tAjhStaDoc;
        $aData['nPage']             = $nPage;

        $this->load->view('document/adjuststocksum/advancetable/wAdjustStockSumPdtAdvTableData', $aData);

        
    }


    // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCSMEventEditInLine(){
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
        $dDateTimeUpdate = date('Y-m-d H:i:s');
        $aDataMaster = array(
            'FTAjhDocNo' => $this->input->post('FTXthDocNo'),
            'tSeq' => $this->input->post('tSeq'),
            'FTSessionID' => $this->session->userdata('tSesSessionID'),
            'FTXthDocKey' => 'TCNTPdtAdjStkHD'
        );
        $aDataUpdate = array(
            'FDLastUpdOn' => $dDateTimeUpdate,
            'FTLastUpdBy' => $this->session->userdata('tSesUserCode'),
            'FDAjdDateTime' => $dDateTimeUpdate,
            'FCAjdUnitQty' => empty($this->input->post('ptValue'))?0:$this->input->post('ptValue'),
            'cUnitfact' => empty($this->input->post('cUnitfact'))?0:$this->input->post('cUnitfact'),
        );

        $aResDel = $this->mAdjustStockSum->FSnMAdjStkSumUpdateInlineDTTemp($aDataUpdate,$aDataMaster);

        $aDataFine4Balance = array(
            'tBchCode'  => $this->input->post('tBchCode'),
            'tWahCode'  => $this->input->post('tWahCode'),
            'FTPdtCode' => $this->input->post('FTPdtCode'),
            'FTPunCode' => $this->input->post('FTPunCode'),
            'FTAjhDocNo' => $this->input->post('FTXthDocNo'),
            'FTSessionID' => $this->session->userdata('tSesSessionID'),
            'FCAjdUnitQty' => empty($this->input->post('ptValue'))?0:$this->input->post('ptValue'),
            'FTXthDocKey' => 'TCNTPdtAdjStkHD'
        );
        $aResBal = $this->mAdjustStockSum->FSnMAdjStkSumFine4BalanceDTTemp($aDataFine4Balance);

        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc'],
            'rcAjdUnitQty'=>$aResDel['rcAjdUnitQty'],
            'rdAjdDateC3'=>$aResDel['rdAjdDateC3'],
            'rdAjdTimeC3'=>$aResDel['rdAjdTimeC3'],
            'FCAjdWahB4Adj'=> number_format($aResBal['raItems']['FCAjdWahB4Adj'],$nOptDecimalShow),
            'FCAjdQtyAllDiff' => number_format($aResBal['raItems']['FCAjdQtyAllDiff'],$nOptDecimalShow),
            'AfterAdj' => number_format($aResBal['raItems']['FCAjdWahB4Adj'] + $aResBal['raItems']['FCAjdQtyAllDiff'],$nOptDecimalShow)
        );
        // print_r($aReturn);
        // die();
        echo json_encode($aReturn);
    }


    
     // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Page Add
    // Return Type : object
    public function FSvCEventRemovePdtInDTTmp(){

        $aDataWhere = array(
            'FTAjhDocNo'    => $this->input->post('ptXthDocNo'),
            'FTPdtCode'     => $this->input->post('ptPdtCode'),
            'FNXtdSeqNo'    => $this->input->post('ptSeqno'),
            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
        );

        $aResDel = $this->mAdjustStockSum->FSnMAdjStkSumDelDTTmp($aDataWhere);

    }



    // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCSMEventCallPdtStkSum(){
            
        
        $aDataWhere = array(
            'FTAjhDocNo'   => $this->input->post('ptXthDocNo'),
            'FTBchCode'    => $this->input->post('ptBchCode'),
            'FTWahCode'    => $this->input->post('ptWahCode'),
            'FTSessionID'  => $this->session->userdata('tSesSessionID'),
            'FTXthDocKey'  => 'TCNTPdtAdjStkHD',
        );

        $aReuslt =  $this->mAdjustStockSum->FSaMAdjStkSumInsertPDTToTemp($aDataWhere);
        $aReuslt =  $this->mAdjustStockSum->FSaMAdjStkSumInsertPDTFhnToTemp($aDataWhere);
        $aDocRef =  $this->mAdjustStockSum->FSaMAdjStkSumFindDocRef($aDataWhere);

        echo json_encode($aDocRef);

    }


    /**
     * Functionality : Event Clear Temp
     * Parameters : Ajax jReason()
     * Creator : 22/05/2019 Piya
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSxCSMEventClearTemp(){

        try{
                 $this->mAdjustStockSum->FSxMClearPdtInTmp();
        } catch(Exception $oError){
                return $oError;
        }
    }


    
       /**
     * Functionality : Event Delete Product
     * Parameters : Ajax jReason()
     * Creator : 22/05/2019 Piya
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSvCEventRemoveMultiPdtInDTTmp(){
        $FTAjhDocNo = $this->input->post('tDocNo');
        $FTPdtCode  = $this->input->post('tPdtCode');
        $FTPunCode  = $this->input->post('tPunCode');
        $aSeqCode   = $this->input->post('tSeqCode');
        $tSession   = $this->session->userdata('tSesSessionID');
        $nCount     = FCNnHSizeOf($aSeqCode);

        if($nCount > 1){

            for($i=0; $i<$nCount; $i++){

                $aDataMaster = array(
                    'FTAjhDocNo'    => $FTAjhDocNo,
                    'FNXtdSeqNo'    => $aSeqCode[$i],
                    'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                    'FTSessionID'   => $tSession
                );
                $aResDel = $this->mAdjustStockSum->FSaMAdjStkSumPdtTmpMultiDel($aDataMaster);
            }

        }else{

            $aDataMaster = array(
                'FTAjhDocNo'    => $FTAjhDocNo,
                'FNXtdSeqNo'    => $aSeqCode[0],
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                'FTSessionID'   => $tSession
            );
            $aResDel = $this->mAdjustStockSum->FSaMAdjStkSumPdtTmpMultiDel($aDataMaster);
        }
        
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }




    // Functionality : Function Add  Coupon Data
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object 
    // Return Type : object
    public function FSoCSMEventAdd(){
        try{
        
            $aDataDocument          = $this->input->post();
            $tAjhAutoGenCode        = (isset($aDataDocument['ocbAdjStkSumSubAutoGenCode'])) ? 1 : 0;
            $tAjhDocNo              = (isset($aDataDocument['oetAdjStkSumAjhDocNo'])) ? $aDataDocument['oetAdjStkSumAjhDocNo'] : '';
            $tAjhDocDate            = $aDataDocument['oetAdjStkSumAjhDocDate'].' '.$aDataDocument['oetAdjStkSumAjhDocTime'];

            $tAjhStaClosed          = (isset($aDataDocument['oetAjhFrmAjhStaClosed'])) ? 1 : 2;
            $tBchCode               =  $this->input->post('oetAdjStkSumBchCode');
            $aSMXtdDocNoRef               =  $this->input->post('ohdSMXtdDocNoRef');


            //เงื่อนไขกลุ่ม

            // Check Auto GenCode Document
            if ($tAjhAutoGenCode == '1') {
                // 15/05/2020 Nattakit(Nale)
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtAdjStkHD',                           
                    "tDocType"    => 2,                                          
                    "tBchCode"    => $tBchCode,                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")     
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tAjhDocNo   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $tAjhDocNo      = $tAjhDocNo;
            }

            $aCheckTime=array('C1'=> 1 , 'C2'=> 2 , ''=> 3);
            $aDataAdjStkSum      = [
                'FTBchCode'         => $this->input->post('oetAdjStkSumBchCode'), 
                'FTAjhDocNo'        => $tAjhDocNo,
                'FNAjhDocType'      => 11,
                'FTAjhDocType'      => '2',
                'FDAjhDocDate'      => (!empty($tAjhDocDate)) ? $tAjhDocDate : NULL,
                'FTAjhBchTo'        => $this->input->post('oetAdjStkSumBchCode'), 
                'FTAjhWhTo'         => $this->input->post('oetAdjStkSumWahCode'),
                'FTAjhApvSeqChk'    => $aCheckTime[$this->input->post('ocmAdjStkSumCheckTime')],
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTRsnCode'         => $this->input->post('oetAdjStkSumReasonCode'),
                'FTAjhRmk'          => $this->input->post('otaAdjStkSumAjhRmk'),
                'FNAjhStaDocAct' => !empty($aDataDocument['ocbAdjStkSumStaDocAct']) ? $aDataDocument['ocbAdjStkSumStaDocAct'] : 0,
                /// Status Document
                'FTAjhStaDoc'       => 1,
                'FTAjhStaApv'       => $this->input->post('ohdAjhStaPrcDoc'),
                'FNAjhDocPrint'     => $this->input->post('oetAjhLimitQty'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'        => date('Y-m-d H:i:s'),
            ];

          
            $this->db->trans_begin();

            $this->mAdjustStockSum->FSaMAjhAddUpdateHD($aDataAdjStkSum);
            $this->mAdjustStockSum->FSaMAjhAddUpdateDT($aDataAdjStkSum);
            $this->mAdjustStockSum->FSaMAjhAddUpdateDTFhn($aDataAdjStkSum);
            

            $aUpdateRefDocSub = array(
                'aSMXtdDocNoRef' => $aSMXtdDocNoRef ,
                'FTAjhDocNo'     => $tAjhDocNo,
            );
            $this->mAdjustStockSum->FSaMAjhUpdateRefDocStockSubHD($aUpdateRefDocSub);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                    $aDataStaReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
            }else{
                $this->db->trans_commit();
                // Loop Delet Insert Image

                $aDataStaReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataAdjStkSum['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
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

    //Functionality : Event Edit Coupon Document
    //Parameters : Ajax jReaRDHn()
    //Creator : 02/03/2020 Nattakit (Nale)
    //Last Modified : -
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCSMEventEdit(){
        try{
         
            $aDataDocument          = $this->input->post();
            $tAjhAutoGenCode        = (isset($aDataDocument['ocbAdjStkSumSubAutoGenCode'])) ? 1 : 0;
            $tAjhDocNo              = (isset($aDataDocument['oetAdjStkSumAjhDocNo'])) ? $aDataDocument['oetAdjStkSumAjhDocNo'] : '';
            $tAjhDocDate            = $aDataDocument['oetAdjStkSumAjhDocDate'].' '.$aDataDocument['oetAdjStkSumAjhDocTime'];

            $tAjhStaClosed          = (isset($aDataDocument['oetAjhFrmAjhStaClosed'])) ? 1 : 2;
            $tBchCode               =  $this->input->post('oetAdjStkSumBchCode');
            //เงื่อนไขกลุ่ม


            $aCheckTime=array('C1'=> 1 , 'C2'=> 2 , ''=> 3);
            $aDataAdjStkSum      = [
                'FTBchCode'         => $this->input->post('oetAdjStkSumBchCode'), 
                'FTAjhDocNo'        => $tAjhDocNo,
                'FNAjhDocType'      => 11,
                'FTAjhDocType'      => '2',
                'FDAjhDocDate'      => (!empty($tAjhDocDate)) ? $tAjhDocDate : NULL,
                'FTAjhBchTo'        => $this->input->post('oetAdjStkSumBchCode'), 
                'FTAjhWhTo'         => $this->input->post('oetAdjStkSumWahCode'),
                'FTAjhApvSeqChk'    => $aCheckTime[$this->input->post('ocmAdjStkSumCheckTime')],
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTRsnCode'         => $this->input->post('oetAdjStkSumReasonCode'),
                'FTAjhRmk'          => $this->input->post('otaAdjStkSumAjhRmk'),
                'FNAjhStaDocAct' => !empty($aDataDocument['ocbAdjStkSumStaDocAct']) ? $aDataDocument['ocbAdjStkSumStaDocAct'] : 0,
                /// Status Document
                'FTAjhStaDoc'       => 1,
                'FTAjhStaApv'       => $this->input->post('ohdAjhStaPrcDoc'),
                'FNAjhDocPrint'     => $this->input->post('oetAjhLimitQty'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'        => date('Y-m-d H:i:s'),
            ];

          
            $this->db->trans_begin();

            $this->mAdjustStockSum->FSaMAjhAddUpdateHD($aDataAdjStkSum);
            $this->mAdjustStockSum->FSaMAjhAddUpdateDT($aDataAdjStkSum);
            $this->mAdjustStockSum->FSaMAjhAddUpdateDTFhn($aDataAdjStkSum);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                    $aDataStaReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Edit Event"
                    );
            }else{
                $this->db->trans_commit();
                // Loop Delet Insert Image

                $aDataStaReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataAdjStkSum['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Event'
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

    // Function : Approve Doc
    public function FSaCSMEventAppove(){

        $tXthDocNo  = $this->input->post('tXthDocNo');
        $tXthStaApv = $this->input->post('tXthStaApv');

        $aDataUpdate = array(
            'FTAjhDocNo' => $tXthDocNo,
            'FTXthApvCode' => $this->session->userdata('tSesUsername')
        );
        $tUsrBchCode = $this->input->post('tBchCode');
        $tWahCode = $this->input->post('tWahCode');

        $aUpdateBal = array(
            'FTAjhDocNo' => $tXthDocNo,
            'FTAjhBchTo' => $tUsrBchCode,
            'FTAjhWhTo' => $tWahCode,
        );


        $this->mAdjustStockSum->FSaMUpdateDTBal($aUpdateBal);
        $this->mAdjustStockSum->FSaMUpdateDTFhnBal($aUpdateBal);
        
        $aStaApv = $this->mAdjustStockSum->FSvMAdjStkSumApprove($aDataUpdate); 

        // die();
        
        $this->db->trans_begin();

        try{
            // $aMQParams = [
            //     "queueName" => "TNFWAREHOSEOUT",
            //         "params" => [
            //             "ptBchCode"     => $tUsrBchCode,
            //             "ptDocNo"       => $tXthDocNo,
            //             "ptDocType"     => '3',
            //             "ptUser"        => $this->session->userdata('tSesUsername'),
            //             "ptConnStr"     => DB_CONNECT,
            //         ]
            // ];
            $aMQParams = [
                "queueName"  =>  "ADJUSTSTOCK",
                "params"   => [
                    "ptBchCode"      => $tUsrBchCode,
                    "ptDocNo"        => $tXthDocNo,
                    "ptDocType"      => '3',
                    "ptUser"         => $this->session->userdata('tSesUsername')
                ]
            ];

            FCNxCallRabbitMQ($aMQParams);

        }catch(\ErrorException $err){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }

    }

    // Function : Approve Doc
    public function FSaCSMEventCancel(){

        $tXthDocNo = $this->input->post('tXthDocNo');

        $aDataUpdate = array(
            'FTAjhDocNo' => $tXthDocNo,
        );

        $aStaApv = $this->mAdjustStockSum->FSvMAdjStkSumCancel($aDataUpdate); 

        if($aStaApv['rtCode'] == 1){
            $aApv = array(
                'nSta' => 1,
                'tMsg' => "Cancel done.",
            );
        }else{
            $aApv = array(
                'nSta' => 2,
                'tMsg' => "Not Cancel.",
            );
        }
        echo json_encode($aApv);

    }

    //Functionality : Event Delete Document
    //Parameters : Ajax 
    //Creator : 02/03/2020 Nattakit(Nale)
    //Return : Status Edit Event
    //Return Type : String
    public function FSaCSMEventDelete(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTAjhDocNo' => $tIDCode
        );

        $aResDel    = $this->mAdjustStockSum->FSnMAdjStkSumDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


    //Functionality : Event Delete Document
    //Parameters : Ajax 
    //Creator : 02/03/2020 Nattakit(Nale)
    //Return : Status Edit Event
    //Return Type : String
    public function FSaCSMEventEditProductsFashion(){

        // settings variable
        $aDataDTFhn  = $this->input->post('paDataDTFhn');
        $aGetDataInsert = $this->input->post('paDataInsert');
        
        $nSumQty = 0;
        if($aDataDTFhn['tType']=='confirm'){
            if(!empty($aDataDTFhn['aResult'])){
                    foreach($aDataDTFhn['aResult'] as $aDataPdtFhn){
                        $aDataInsert = array(
                            'FTBchCode'     => $aGetDataInsert['tBchCode'],
                            'FTXshDocNo'    => $aGetDataInsert['tDocNo'],
                            'FNXsdSeqNo'    => $aGetDataInsert['nDTTmpSeq'],
                            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                            'FTPdtCode'     => $aDataPdtFhn['tPDTCode'],
                            'FTFhnRefCode'  => $aDataPdtFhn['tRefCode'],
                            'FTXtdBarCode'  => $aDataPdtFhn['tBarCode'],
                            'FDAjdDateTime' => $aDataPdtFhn['tDateAdj'].' '.$aDataPdtFhn['tTimeAdj'],
                            'FCAjdUnitQty'  => $aDataPdtFhn['nQtyAdj'],
                            'FCAjdQtyAll'   => $aDataPdtFhn['nQtyAdj'],
                            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                            'FDCreateOn'    => date('Y-m-d H:i:s'),
                            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        );
                          $nSumQty = $nSumQty + $aDataPdtFhn['nQtyAdj'];

                          $nPdtUnitFact = $this->mAdjustStockSum->FSnMAJHGetPdtUnitFactDTTemp($aDataInsert);
                          $aDataInsert['FCAjdQtyAll'] = $aDataPdtFhn['nQtyAdj']*$nPdtUnitFact;
                        $aResultPDT = $this->mAdjustStockSum->FSaMAJHEventAddProductsFashion($aDataInsert);
                    }

                    $aDataUpdateDTTmp = array(
                        'FTBchCode'     => $aGetDataInsert['tBchCode'],
                        'FTXthDocNo'    => $aGetDataInsert['tDocNo'],
                        'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                        'FTPdtCode'     => $aDataInsert['FTPdtCode'],
                        'FNXtdSeqNo'    => $aGetDataInsert['nDTTmpSeq'],
                        'FDAjdDateTime' => $aDataInsert['FDAjdDateTime'],
                        'FCAjdUnitQty'  => $nSumQty,
                        'FCAjdQtyAll'   => $nSumQty*$nPdtUnitFact,
                        'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    );
              
                    $aResultPDT = $this->mAdjustStockSum->FSaMAJHEventUpdateDTTmp($aDataUpdateDTTmp);
            }
        }
}





}





























































































































































































