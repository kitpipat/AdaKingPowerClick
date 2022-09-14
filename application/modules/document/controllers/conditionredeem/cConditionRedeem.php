<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cConditionRedeem extends MX_Controller {

    public function __construct() {
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('company/company/mCompany');
        $this->load->model('document/conditionredeem/mConditionRedeem');
        parent::__construct();
    }

    public function index($pnBrowseType,$ptBrowseOption){
        $aDataConfigView    = [
            'nRDHBrowseType'    => $pnBrowseType,
            'tRDHBrowseOption'  => $ptBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('dcmRDH/0/0'),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('dcmRDH/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('document/conditionredeem/wConditionRedeem',$aDataConfigView);
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : String View
    // Return Type : View
    public function FSvCRDHFormSearchList(){
        $this->load->view('document/conditionredeem/wConditionRedeemFormSearchList');
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCRDHGetDataTable() {
        try{
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmRDH/0/0');
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
            $aDataList      = $this->mConditionRedeem->FSaMRDHGetDataTableList($aDataCondition);
            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tRDHViewDataTableList  = $this->load->view('document/conditionredeem/wConditionRedeemDataTable',$aConfigView,true);
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
    public function FSoCRDHCallPageAdd(){
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


        $tRDHUserLevel = $this->session->userdata('tSesUsrLevel');
        $tRDHBchCode = ($tRDHUserLevel == 'HQ') ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $tRDHDocNo   = $this->input->post('tRDHDocNo');
        $tRDDGrpCode   = $this->input->post('tRDDGrpCode');
        $aDataPdtParams = array(
            'tDocNo'      => $tRDHDocNo,
            'tBchCode'    => $tRDHBchCode,
            'tSessionID'  => $this->session->userdata('tSesSessionID'),
        );
 
        $this->mConditionRedeem->FSxMRDHClearTempRedeemDefaultDT($aDataPdtParams);


        $aDataConfigViewAdd = [
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'tUserBchCode'      => $tRDHBchCode,
            'tUserShpCode'      => $tShpCode,
            'aDataDocHD'        => array('rtCode' => '800'),
        ];
        $tRDHViewPageAdd    = $this->load->view('document/conditionredeem/wConditionRedeemPageForm',$aDataConfigViewAdd,true);
        $aReturnData        = [
            'tRDHViewPageAdd'   => $tRDHViewPageAdd,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        ];
        unset($nOptDecimalShow);
        unset($nOptDocSave);
        unset($aDataConfigViewAdd);
        unset($tRDHViewPageAdd);
        echo json_encode($aReturnData);
    }


    public function FSxCRDHClearConditionRedeemTmp(){
        
        $tRDHUserLevel = $this->session->userdata('tSesUsrLevel');
        $tRDHBchCode = $this->input->post('tBchCode');
        $tRDHDocNo   = $this->input->post('tRDHDocNo');
        $tRDDGrpCode   = $this->input->post('tRDDGrpCode');
        $aDataPdtParams = array(
            'tDocNo'      => $tRDHDocNo,
            'tBchCode'    => $tRDHBchCode,
            'tRDDGrpCode' => $tRDDGrpCode,
            'tSessionID'  => $this->session->userdata('tSesSessionID'),
        );
        $this->mConditionRedeem->FSxMRDHClearTempRedeemDT($aDataPdtParams);

    }

    //Functionality :  call Page Edit Coupon
    //Parameters : Ajax and Function Parameter
    //Creator : 02/03/2020 saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSoCRDHCallPageEdit(){

        
        $tBchCode   = $this->input->post('tBchCode');
        $tRDHDocNo  = $this->input->post('tRDHDocNo');
        $nLangEdit  = $this->session->userdata("tLangEdit");


        $aData  = array(
            'FTRdhDocNo' => $tRDHDocNo,
            'FNLngID'    => $nLangEdit,
            'FTBchCode'  => $tBchCode
        );

        $aResult       = $this->mConditionRedeem->FSaMRDHGetDataByID($aData);
        $aResultCD     = $this->mConditionRedeem->FSaMRDHGetDataCDByID($aData);
        $aResultBch    = $this->mConditionRedeem->FSaMRDHGetDataBchByID($aData);
        $aResultCstPri = $this->mConditionRedeem->FSaMRDHGetDataCstPriByID($aData);

        $aDataEdit  = [
            'aDataDocHD'        => $aResult,
            'aDataDocCD'        => $aResultCD,
            'aDataDocBch'       => $aResultBch,
            'aDataDocCstPri'    => $aResultCstPri,
        ];


        $aDataGenPdtInsertTemp = array(
            'FTRdhDocNo' => $tRDHDocNo,
            'tSessionID'  => $this->session->userdata('tSesSessionID'),
        );

        $this->mConditionRedeem->FSaMRDHGenPdtInsertTempConditionRedeemDT($aDataGenPdtInsertTemp);
 
        $this->load->view('document/conditionredeem/wConditionRedeemPageForm',$aDataEdit);
    }



    // Functionality : Function Event Delete Coupon Document
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCRDHEventDelete(){
        try{
            $tDataDocNo     = $this->input->post('ptDataDocNo');
            $aDataMaster    = array(
                'tDataDocNo'    => $tDataDocNo
            );
            $aResDelDoc     = $this->mConditionRedeem->FSnMRDHDelDocument($aDataMaster);
            if ($aResDelDoc['rtCode'] == '1') {
           
          
                $aDataStaReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            } else {
                $aDataStaReturn = array(
                    'nStaEvent' => $aResDelDoc['rtCode'],
                    'tStaMessg' => $aResDelDoc['rtDesc']
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



    // Functionality : Function Add  Coupon Data
    // Parameters : Ajax and Function Parameter
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Object 
    // Return Type : object
    public function FSoCRDHEventAdd(){
        try{
        
            $aDataDocument          = $this->input->post();
            $tRDHAutoGenCode        = (isset($aDataDocument['ocbRDHStaAutoGenCode'])) ? 1 : 0;
            $tRDHDocNo              = (isset($aDataDocument['oetRDHDocNo'])) ? $aDataDocument['oetRDHDocNo'] : '';
            $tRDHDocDate            = $aDataDocument['oetRDHDocDate'];

            $tRDHFrmRDHDateStart  = (isset($aDataDocument['oetRDHFrmRDHDateStart'])) ? $aDataDocument['oetRDHFrmRDHDateStart'] : NULL;
            $tRDHFrmRDHDateStop   = (isset($aDataDocument['oetRDHFrmRDHDateStop'])) ? $aDataDocument['oetRDHFrmRDHDateStop'] : NULL ;
            $tRDHFrmRDHTimeStart  = (isset($aDataDocument['oetRDHFrmRDHTimeStart'])) ? $aDataDocument['oetRDHFrmRDHTimeStart'] : NULL ;
            $tRDHFrmRDHTimeStop   = (isset($aDataDocument['oetRDHFrmRDHTimeStop'])) ? $aDataDocument['oetRDHFrmRDHTimeStop'] : NULL ;
           

            $tRDHStaClosed          = (isset($aDataDocument['oetRDHFrmRDHStaClosed'])) ? 1 : 2;
            $tBchCode               =  $this->input->post('ohdRDHUsrBchCode');
            //เงื่อนไขกลุ่ม
            $aRdcRefCode        = $this->input->post('oetRdcRefCode');
            $aRddGroupNameInput = $this->input->post('ohdRddGroupNameInput');
            $aRdcUsePoint       = $this->input->post('oetRdcUsePoint');
            $aRdcUseMny         = $this->input->post('oetRdcUseMny');
            $aRdcMinTotBill     = $this->input->post('oetRdcMinTotBill');

            //เงื่อนไขเฉพาะ
            //กลุ่มราคา
            $aRddPplCode         = $this->input->post('ohdRddPplCode');
            $aRdhPplStaType      = $this->input->post('ohdRdhPplStaType');
            //สาขา
            $aRddConditionRedeemAgnCode = $this->input->post('ohdRddConditionRedeemAgnCode');
            $aRddConditionRedeemBchCode = $this->input->post('ohdRddConditionRedeemBchCode');
            $aRddConditionRedeemMerCode = $this->input->post('ohdRddConditionRedeemMerCode');
            $aRddConditionRedeemShpCode = $this->input->post('ohdRddConditionRedeemShpCode');
            $aRddBchModalType           = $this->input->post('ohdRddBchModalType');
    

            $tRDHStaOnTopPmt     = (isset($aDataDocument['oetRDHStaOnTopPmt'])) ? 1 : 2;
            $tRDHFrmRDHStaDocAct = (isset($aDataDocument['oetRDHFrmRDHStaDocAct'])) ? 1 : 0;
      

            // Check Auto GenCode Document
            if ($tRDHAutoGenCode == '1') {
                // $aRDHGenCode    = FCNaHGenCodeV5('TARTRedeemHD',$this->input->post('ocmRDHDocType'));
                // if ($aRDHGenCode['rtCode'] == '1') {
                //     $tRDHDocNo  = $aRDHGenCode['rtRdhDocNo'];
                // }
                // 15/05/2020 Nattakit(Nale)
                $aStoreParam = array(
                    "tTblName"    => 'TARTRedeemHD',                           
                    "tDocType"    => $this->input->post('ocmRDHDocType'),                                          
                    "tBchCode"    => $tBchCode,                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")     
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tRDHDocNo   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $tRDHDocNo      = $tRDHDocNo;
            }

           
            //ประเภทการแลกแต้ม
            $aRdhDocType[1] = array('FTRdhDocType'=>1,'FTRdhCalType'=>1);
            $aRdhDocType[2] = array('FTRdhDocType'=>2,'FTRdhCalType'=>1);
            $aRdhDocType[3] = array('FTRdhDocType'=>2,'FTRdhCalType'=>2);
      
            // FTBchCode  (ohdRDHUsrBchCode)
            // FTRdhDocNo (ohdRDHDocNo)
            // FDRdhDocDate (oetRDHDocDate)
            // FTRdhDocType ประเภทเอกสาร 1: Redeem แต้ม+เงิน 2: Redeem ส่วนลด
            // FTRdhCalType การคำนวน 1: ส่วนลด(Default)  2: เงินสด (ไม่ re-cal Vat)
            // FTRdhRefCode Redeem code
            // FDRdhDStart (oetRDHFrmRDHDateStart)
            // FDRdhDStop (oetRDHFrmRDHDateStop)
            // FDRdhTStart (oetRDHFrmRDHTimeStart)
            // FDRdhTStop (oetRDHFrmRDHTimeStop)
            // FTUsrCode รหัสผู้บันทึก 
            // FTRdhStaClosed 0: เปิดใช้  1: หยุด (oetRDHFrmRDHStaClosed)
            // FTRdhStaOnTopPmt 1:อนญาตคำนวน 2:ไม่อนญาตคำนวน   (oetRDHStaOnTopPmt)
            // FNRdhLimitQty จำนวนครั้งที่อนุญาต/บิล 0: ไม่จำกัด
            // FNRdhStaDocAct เคลื่อนไหว oetRDHFrmRDHStaDocAct
           
            $aDataConditionRedeemHD      = [
                'FTBchCode'         => $this->input->post('ohdRDHUsrBchCode'), 
                'FTRdhDocNo'        => $tRDHDocNo,
                'FDRdhDocDate'      => (!empty($tRDHDocDate)) ? $tRDHDocDate : NULL,
                'FTRdhDocType'      => $this->input->post('ocmRDHDocType'),
                'FTRdhCalType'      => $this->input->post('ocmRDHCalType'),
                'FTRdhRefCode'      => '', 
                'FDRdhDStart'       => $tRDHFrmRDHDateStart,
                'FDRdhDStop'        => $tRDHFrmRDHDateStop,
                'FDRdhTStart'       => $tRDHFrmRDHTimeStart,
                'FDRdhTStop'        => $tRDHFrmRDHTimeStop,
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTRdhRefAccCode'   => $this->input->post('oetRDHRefAccCode'),
                /// Status Document
                'FTRdhStaClosed'    => $tRDHStaClosed,
                'FTRdhStaDoc'       => $this->input->post('ohdRDHStaDoc'),
                'FTRdhStaApv'       => $this->input->post('ohdRDHStaApv'),
                'FTRdhStaPrcDoc'    => $this->input->post('ohdRDHStaPrcDoc'),
                'FNRdhStaDocAct'    => $tRDHFrmRDHStaDocAct,
                'FTRdhStaOnTopPmt'  => $tRDHStaOnTopPmt,
                'FNRdhLimitQty'     => $this->input->post('oetRDHLimitQty')
            ];

            $aDataConditionRedeemHD_L = [
                'FTBchCode'     => $this->input->post('ohdRDHUsrBchCode'),
                'FTRdhDocNo'    => $tRDHDocNo,
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTRdhName'     => $this->input->post('oetRDHName'),
                'FTRdhNameSlip' => $this->input->post('oetRDHNameSlip')
            ];

            $aDataConditionRedeemDT = [
                'FTBchCode'     => $this->input->post('ohdRDHUsrBchCode'),
                'FTRdhDocNo'    => $tRDHDocNo,
            ];

            $aDataWhere = [
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            ];

            $aDataWhereDTTmp = [
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            ];

             $nCountGenCodeAuto = FCNnHSizeOf($aRdcRefCode);
             $nLastNumber = $this->mConditionRedeem->FSnMGetMaxCodeCDConditionRedeem();
             $aRefCodeAuto =  FCNaHGenCoupon(20,$tRDHDocNo,$nCountGenCodeAuto,$nLastNumber);
            
            //เงื่อนไขกลุ่ม
            $aDataConditionRedeemGRP = [
                'aRdcRefCode'        => $aRdcRefCode,
                'aRefCodeAuto'       => $aRefCodeAuto,
                'aRddGroupNameInput' => $aRddGroupNameInput,
                'aRdcUsePoint'       => $aRdcUsePoint,
                'aRdcUseMny'         => $aRdcUseMny,
                'aRdcMinTotBill'     => $aRdcMinTotBill
            ];

           //กลุ่มราคา
            $aDataConditionRedeemCRPpl = [
                'aRddPplCode'     => $aRddPplCode,
                'aRdhPplStaType'  => $aRdhPplStaType,
            ];

          //สาขา
            $aDataConditionRedeemCRBch = [
                'aRddConditionRedeemAgnCode' => $aRddConditionRedeemAgnCode,
                'aRddConditionRedeemBchCode' => $aRddConditionRedeemBchCode,
                'aRddConditionRedeemMerCode' => $aRddConditionRedeemMerCode,
                'aRddConditionRedeemShpCode' => $aRddConditionRedeemShpCode,
                'aRddBchModalType'           => $aRddBchModalType,
            ];


            $aDataConditionRedeemPdtDT = array(
                'FTRdhDocNoWhere'      => (isset($aDataDocument['oetRDHDocNo'])) ? $aDataDocument['oetRDHDocNo'] : '',
                'FTRdhDocNo'    => $tRDHDocNo,
                'nRDHDocType'     => $aDataDocument['ocmRDHDocType'],
                'FTBchCode'    => $this->input->post('ohdRDHUsrBchCode'),
                'tSessionID'  => $this->session->userdata('tSesSessionID'),
            );

            // echo '<pre>';

            // print_r($aDataConditionRedeemHD);
            // echo '</pre>';
            // die();
            

            $this->db->trans_begin();
            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHD($aDataConditionRedeemHD,$aDataWhere);
            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHDL($aDataConditionRedeemHD_L);

            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemDT($aDataConditionRedeemPdtDT);

            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemCD($aDataConditionRedeemGRP,$aDataConditionRedeemDT);

            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHDBch($aDataConditionRedeemCRBch,$aDataConditionRedeemDT);
            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHDCstPri($aDataConditionRedeemCRPpl,$aDataConditionRedeemDT);


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
                    'tCodeReturn'	=> $aDataConditionRedeemHD['FTRdhDocNo'],
                    'tBchCode'      => $aDataConditionRedeemHD['FTBchCode'],
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
    public function FSoCRDHEventEdit(){
        try{
            $aDataDocument          = $this->input->post();
            $tRDHAutoGenCode        = (isset($aDataDocument['ocbRDHStaAutoGenCode'])) ? 1 : 0;
            $tRDHDocNo              = (isset($aDataDocument['oetRDHDocNo'])) ? $aDataDocument['oetRDHDocNo'] : '';
            $tRDHDocDate            = $aDataDocument['oetRDHDocDate'];

            $tRDHFrmRDHDateStart  = (isset($aDataDocument['oetRDHFrmRDHDateStart'])) ? $aDataDocument['oetRDHFrmRDHDateStart'] : NULL;
            $tRDHFrmRDHDateStop   = (isset($aDataDocument['oetRDHFrmRDHDateStop'])) ? $aDataDocument['oetRDHFrmRDHDateStop'] : NULL ;
            $tRDHFrmRDHTimeStart  = (isset($aDataDocument['oetRDHFrmRDHTimeStart'])) ? $aDataDocument['oetRDHFrmRDHTimeStart'] : NULL ;
            $tRDHFrmRDHTimeStop   = (isset($aDataDocument['oetRDHFrmRDHTimeStop'])) ? $aDataDocument['oetRDHFrmRDHTimeStop'] : NULL ;
           

            $tRDHStaClosed          = (isset($aDataDocument['oetRDHFrmRDHStaClosed'])) ? 1 : 2;
            $tBchCode               =  $this->input->post('ohdRDHUsrBchCode');
            //เงื่อนไขกลุ่ม
            $aRdcRefCode        = $this->input->post('oetRdcRefCode');
            $aRddGroupNameInput = $this->input->post('ohdRddGroupNameInput');
            $aRdcUsePoint       = $this->input->post('oetRdcUsePoint');
            $aRdcUseMny         = $this->input->post('oetRdcUseMny');
            $aRdcMinTotBill     = $this->input->post('oetRdcMinTotBill');

            //เงื่อนไขเฉพาะ
            //กลุ่มราคา
            $aRddPplCode         = $this->input->post('ohdRddPplCode');
            $aRdhPplStaType      = $this->input->post('ohdRdhPplStaType');
            //สาขา
            $aRddConditionRedeemAgnCode = $this->input->post('ohdRddConditionRedeemAgnCode');
            $aRddConditionRedeemBchCode = $this->input->post('ohdRddConditionRedeemBchCode');
            $aRddConditionRedeemMerCode = $this->input->post('ohdRddConditionRedeemMerCode');
            $aRddConditionRedeemShpCode = $this->input->post('ohdRddConditionRedeemShpCode');
            $aRddBchModalType           = $this->input->post('ohdRddBchModalType');
    

            $tRDHStaOnTopPmt     = (isset($aDataDocument['oetRDHStaOnTopPmt'])) ? 1 : 2;
            $tRDHFrmRDHStaDocAct = (isset($aDataDocument['oetRDHFrmRDHStaDocAct'])) ? 1 : 0;
      

            // Check Auto GenCode Document
            if ($tRDHAutoGenCode == '1') {
                $aRDHGenCode    = FCNaHGenCodeV5('TARTRedeemHD',1);
                if ($aRDHGenCode['rtCode'] == '1') {
                    $tRDHDocNo  = $aRDHGenCode['rtRdhDocNo'];
                }
            } else {
                $tRDHDocNo      = $tRDHDocNo;
            }

           
            //ประเภทการแลกแต้ม
            $aRdhDocType[1] = array('FTRdhDocType'=>1,'FTRdhCalType'=>1);
            $aRdhDocType[2] = array('FTRdhDocType'=>2,'FTRdhCalType'=>1);
            $aRdhDocType[3] = array('FTRdhDocType'=>2,'FTRdhCalType'=>2);
      
            // FTBchCode  (ohdRDHUsrBchCode)
            // FTRdhDocNo (ohdRDHDocNo)
            // FDRdhDocDate (oetRDHDocDate)
            // FTRdhDocType ประเภทเอกสาร 1: Redeem แต้ม+เงิน 2: Redeem ส่วนลด
            // FTRdhCalType การคำนวน 1: ส่วนลด(Default)  2: เงินสด (ไม่ re-cal Vat)
            // FTRdhRefCode Redeem code
            // FDRdhDStart (oetRDHFrmRDHDateStart)
            // FDRdhDStop (oetRDHFrmRDHDateStop)
            // FDRdhTStart (oetRDHFrmRDHTimeStart)
            // FDRdhTStop (oetRDHFrmRDHTimeStop)
            // FTUsrCode รหัสผู้บันทึก 
            // FTRdhStaClosed 0: เปิดใช้  1: หยุด (oetRDHFrmRDHStaClosed)
            // FTRdhStaOnTopPmt 1:อนญาตคำนวน 2:ไม่อนญาตคำนวน   (oetRDHStaOnTopPmt)
            // FNRdhLimitQty จำนวนครั้งที่อนุญาต/บิล 0: ไม่จำกัด
            // FNRdhStaDocAct เคลื่อนไหว oetRDHFrmRDHStaDocAct
           
            $aDataConditionRedeemHD      = [
                'FTBchCode'         => $this->input->post('ohdRDHUsrBchCode'), 
                'FTRdhDocNo'        => $tRDHDocNo,
                'FDRdhDocDate'      => (!empty($tRDHDocDate)) ? $tRDHDocDate : NULL,
                'FTRdhDocType'      => $this->input->post('ocmRDHDocType'),
                'FTRdhCalType'      => $this->input->post('ocmRDHCalType'),
                'FTRdhRefCode'      => '', 
                'FDRdhDStart'       => $tRDHFrmRDHDateStart,
                'FDRdhDStop'        => $tRDHFrmRDHDateStop,
                'FDRdhTStart'       => $tRDHFrmRDHTimeStart,
                'FDRdhTStop'        => $tRDHFrmRDHTimeStop,
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTRdhRefAccCode'   => $this->input->post('oetRDHRefAccCode'),
                /// Status Document
                'FTRdhStaClosed'    => $tRDHStaClosed,
                'FTRdhStaDoc'       => $this->input->post('ohdRDHStaDoc'),
                'FTRdhStaApv'       => $this->input->post('ohdRDHStaApv'),
                'FTRdhStaPrcDoc'    => $this->input->post('ohdRDHStaPrcDoc'),
                'FNRdhStaDocAct'    => $tRDHFrmRDHStaDocAct,
                'FTRdhStaOnTopPmt'  => $tRDHStaOnTopPmt,
                'FNRdhLimitQty'     => $this->input->post('oetRDHLimitQty')
            ];

            $aDataConditionRedeemHD_L = [
                'FTBchCode'     => $this->input->post('ohdRDHUsrBchCode'),
                'FTRdhDocNo'    => $tRDHDocNo,
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTRdhName'     => $this->input->post('oetRDHName'),
                'FTRdhNameSlip' => $this->input->post('oetRDHNameSlip')
            ];

            $aDataConditionRedeemDT = [
                'FTBchCode'     => $this->input->post('ohdRDHUsrBchCode'),
                'FTRdhDocNo'    => $tRDHDocNo,
            ];

            $aDataWhere = [
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            ];

            $aDataWhereDTTmp = [
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            ];

             $nCountGenCodeAuto = FCNnHSizeOf($aRdcRefCode);
             $nLastNumber = $this->mConditionRedeem->FSnMGetMaxCodeCDConditionRedeem();
             $aRefCodeAuto =  FCNaHGenCoupon(20,$tRDHDocNo,$nCountGenCodeAuto,$nLastNumber);
            
            //เงื่อนไขกลุ่ม
            $aDataConditionRedeemGRP = [
                'aRdcRefCode'        => $aRdcRefCode,
                'aRefCodeAuto'       => $aRefCodeAuto,
                'aRddGroupNameInput' => $aRddGroupNameInput,
                'aRdcUsePoint'       => $aRdcUsePoint,
                'aRdcUseMny'         => $aRdcUseMny,
                'aRdcMinTotBill'     => $aRdcMinTotBill
            ];

           //กลุ่มราคา
            $aDataConditionRedeemCRPpl = [
                'aRddPplCode'     => $aRddPplCode,
                'aRdhPplStaType'  => $aRdhPplStaType,
            ];

          //สาขา
            $aDataConditionRedeemCRBch = [
                'aRddConditionRedeemAgnCode' => $aRddConditionRedeemAgnCode,
                'aRddConditionRedeemBchCode' => $aRddConditionRedeemBchCode,
                'aRddConditionRedeemMerCode' => $aRddConditionRedeemMerCode,
                'aRddConditionRedeemShpCode' => $aRddConditionRedeemShpCode,
                'aRddBchModalType'           => $aRddBchModalType,
            ];


            $aDataConditionRedeemPdtDT = array(
                'FTRdhDocNoWhere' => (isset($aDataDocument['oetRDHDocNo'])) ? $aDataDocument['oetRDHDocNo'] : '',
                'FTRdhDocNo'      => $tRDHDocNo,
                'nRDHDocType'     => $aDataDocument['ocmRDHDocType'],
                'FTBchCode'       => $this->input->post('ohdRDHUsrBchCode'),
                'tSessionID'      => $this->session->userdata('tSesSessionID'),
            );
            

            $this->db->trans_begin();
            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHD($aDataConditionRedeemHD,$aDataWhere);
            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHDL($aDataConditionRedeemHD_L);

            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemDT($aDataConditionRedeemPdtDT);

            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemCD($aDataConditionRedeemGRP,$aDataConditionRedeemDT);

            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHDBch($aDataConditionRedeemCRBch,$aDataConditionRedeemDT);
            $this->mConditionRedeem->FSaMRDHAddUpdateConditionRedeemHDCstPri($aDataConditionRedeemCRPpl,$aDataConditionRedeemDT);
            
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
            }else{
                $this->db->trans_commit();
                // Loop Delet Insert Image
      

                $aDataStaReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $tRDHDocNo,
                    'tBch'          => $tBchCode,
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Event'
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

    //Functionality : Event Cancel Document
    //Parameters : Ajax jReaRDHn()
    //Creator : 02/03/2020 Nattakit (Nale)
    //Return : Status Edit Event
    //Return Type : String
    public function FSaCRDHEventCancel(){
        $tDocumentNumber        = $this->input->post('tDocumentNumber');
        $tBchCode               = $this->input->post('tBchCode');
        $aData              = array(
            'FTBchCode'    => $tBchCode,
            'FTRDHDocNo'   => $tDocumentNumber
        );
        $this->mConditionRedeem->FSaMRDHCancelStatus($aData);
    }

    //Functionality : Event Appove Document
    //Parameters : Ajax jReaRDHn()
    //Creator : 02/03/2020 Nattakit(Nale)
    //Return : Status Edit Event
    //Return Type : String
    public function FSaCRDHEventAppove(){
        $tDocumentNumber        = $this->input->post('tDocumentNumber');
        $tBchCode               = $this->input->post('tBchCode');
        $tUserAppove            = $this->session->userdata('tSesUsername');
        $aData              = array(
            'FTBchCode'     => $tBchCode,
            'FTRdhDocNo'    => $tDocumentNumber,
            'FTRdhUsrApv'   => $tUserAppove
        );
        $this->mConditionRedeem->FSaMRDHAppoveStatus($aData);
    }

     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHEventAddPdtTemp() {
        try {
            $tRDHUserLevel = $this->session->userdata('tSesUsrLevel');
            $tRDHDocNo = $this->input->post('tRDHDocNo');
            $tRDHBchCode = $this->input->post('tBchCode');
            // tBchCode
            // $tRDHBchCode = ($tRDHUserLevel == 'HQ') ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
            $tRDDGrpName = $this->input->post('tRDDGrpName');
            $nRDDStaType = $this->input->post('nRDDStaType');
            $tRDHPdtData = $this->input->post('tRDHPdtData');
            $aRDHPdtData = json_decode($tRDHPdtData);

            $aDataPdtParams = array(
                'tDocNo'      => $tRDHDocNo,
                'tBchCode'    => $tRDHBchCode,
                'tGrpName'    => $tRDDGrpName,
                'nRDDStaType' => $nRDDStaType,
                'aPdtData'    => $aRDHPdtData,
                'tSessionID'  => $this->session->userdata('tSesSessionID'),
            );
            //ตรวจตอบสินค้าว่ามีการเลือกไปแล้วหรือไม่ในกลุ่มอื่นๆ
            $nResultDuplicate = $this->mConditionRedeem->FSxMRDHFindDuplicatePdt($aDataPdtParams);
            // echo $nResultDuplicate;

            // die();
            if($nResultDuplicate==0){
            $this->db->trans_begin();
            //insert to table Temp

            $bStaInsPdtToTmp  = $this->mConditionRedeem->FSaMRDHInsertPDTToTemp($aDataPdtParams);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $aReturnData = array(
                            'nStaEvent' => '500',
                            'tStaMessg' => 'Error Insert Product Error Please Contact Admin.'
                        );
                    } else {
                        $this->db->trans_commit();
                        // Calcurate Document DT Temp Array Parameter
        
                        if ($bStaInsPdtToTmp === TRUE) {
                    
                            $aReturnData = array(
                                'nStaEvent' => '1',
                                'tStaMessg' => 'Success Add Product Into Document DT Temp.'
                            );
                        } else {
                            $aReturnData = array(
                                'nStaEvent' => '500',
                                'tStaMessg' => 'Error Calcurate Document DT Temp Please Contact Admin.'
                            );
                        }
                    }
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'This products has already been selected. '
                );
            }


        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    

     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHECallEventPdtTemp(){
        try {
            $nLangEdit  = $this->session->userdata("tLangEdit");
            $tRDHDocNo = $this->input->post('ptRDHDocNo');
            $tRDDGrpName = $this->input->post('tRDDGrpName');
            $tRDDGrpCode = $this->input->post('tRDDGrpCode');
            $tRDHStaApv = $this->input->post('ptRDHStaApv');
            $tRDHStaDoc = $this->input->post('ptRDHStaDoc');
            $nRDHPageCurrent = $this->input->post('pnRDHPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            
            $aDataWhere = array(
                'FNLngID'            => $nLangEdit,
                'tSearchPdtAdvTable' => $tSearchPdtAdvTable,
                'FTXthDocNo'         => $tRDHDocNo,
                'FTRddGrpName'       => $tRDDGrpName,
                'FTRddGrpCode'        =>$tRDDGrpCode,
                'nPage'              => $nRDHPageCurrent,
                'nRow'               => 10,
                'FTSessionID'        => $this->session->userdata('tSesSessionID'),
            );

            $aDataDocDTTemp = $this->mConditionRedeem->FSaMRDHGetDocDTTempListPage($aDataWhere);
 

            $aDataView = array(
       
                'tRDHStaApv' => $tRDHStaApv,
                'tRDHStaDoc' => $tRDHStaDoc,
                'nPage' => $nRDHPageCurrent,
                'aDataDocDTTemp' => $aDataDocDTTemp,
            
            );

            $tRDHPdtAdvTableHtml = $this->load->view('document/conditionredeem/tab/wConditionRedeemPdtAdvTabledData', $aDataView, true);


        //     echo '<pre>';
        //     print_r($tRDHPdtAdvTableHtml);
        // echo '</pre>';
        // die();
            // Call Footer Document
            $aEndOfBillParams = array(
                'tDocNo' => $tRDHDocNo,
                'nLngID' => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode' => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCodeDefault')
            );

            $aReturnData = array(
                'tRDHPdtAdvTableHtml' => $tRDHPdtAdvTableHtml,
                'nStaEvent' => '1',
                'tStaMessg' => "Fucntion Success Return View."
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }



     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHPdtAdvanceTableDeleteSingle(){
        try {

            $tRDHDocNo    = $this->input->post('tRDHDocNo');
            $nRddSeq      = $this->input->post('nRddSeq');
            $tSessionID   = $this->input->post('tSessionID');
            $tBchCode     = $this->input->post('tBchCode');

            $aDataParam = array(
                'tRDHDocNo' => $tRDHDocNo,
                'nRddSeq' => $nRddSeq,
                'tSessionID' => $tSessionID,
                'tBchCode' => $tBchCode,
            );

           $aResult = $this->mConditionRedeem->FSaMRDHPdtAdvanceTableDeleteSingle($aDataParam);

           if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);

    }


     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHInsertGrpNamePDTToTemp(){
        try {

            $tRDHDocNo = $this->input->post('tRDHDocNo');
            $tBchCode = $this->input->post('tBchCode');
            $tRDDGrpName = $this->input->post('tRDDGrpName');
            $tRDDGrpCode = $this->input->post('tRDDGrpCode');
            $nRDDStaType = $this->input->post('nRDDStaType');
            
            $aDataPdtParams = array(
                'tDocNo'      => $tRDHDocNo,
                'tBchCode'    => $tBchCode,
                'tGrpName'    => $tRDDGrpName,
                'tGrpCode'    => $tRDDGrpCode,
                'nRDDStaType' => $nRDDStaType,
                'tSessionID'  => $this->session->userdata('tSesSessionID'),
            );
            $aResult = $this->mConditionRedeem->FSaMRDHInsertGrpNamePDTToTemp($aDataPdtParams);

           if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }



         // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHCanCelGrpNamePDTToTemp(){
        try {

            $tRDHDocNo = $this->input->post('tRDHDocNo');
            $tBchCode = $this->input->post('tBchCode');
            $tRDDGrpName = $this->input->post('tRDDGrpName');
            $tRDDGrpCode = $this->input->post('tRDDGrpCode');
            $nRDDStaType = $this->input->post('nRDDStaType');
            
            $aDataPdtParams = array(
                'tDocNo'      => $tRDHDocNo,
                'tBchCode'    => $tBchCode,
                'tGrpName'    => $tRDDGrpName,
                'tGrpCode'    => $tRDDGrpCode,
                'nRDDStaType' => $nRDDStaType,
                'tSessionID'  => $this->session->userdata('tSesSessionID'),
            );
            $aResult = $this->mConditionRedeem->FSaMRDHDeleteGrpNamePDTToTemp($aDataPdtParams);

           if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHGetGrpNamePDTToTemp(){
        try {

            $tRDHDocNo      = $this->input->post('tRDHDocNo');
       
            $tBchCode = $this->input->post('tBchCode');

            $aDataPdtParams = array(
                'tDocNo'      => $tRDHDocNo,
                'tBchCode'    => $tBchCode,
                'tSessionID'  => $this->session->userdata('tSesSessionID'),
            );
            $aResult = $this->mConditionRedeem->FSaMRDHGetGrpNamePDTToTemp($aDataPdtParams);
            

            
           if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'titem'     => $aResult,
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
        
    }


     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHSetPdtGrpDTTemp(){
        try {

            $tRDHDocNo      = $this->input->post('tRDHDocNo');
            $tGrpCode       = $this->input->post('tGrpCode');
            $tBchCode       = $this->input->post('tBchCode');

            $aDataPdtParams = array(
                'tDocNo'      => $tRDHDocNo,
                'tBchCode'    => $tBchCode,
                'tGrpCode'    => $tGrpCode,
                'tSessionID'  => $this->session->userdata('tSesSessionID'),
            );
            $aResult = $this->mConditionRedeem->FSaMRDHSetPdtGrpDTTemp($aDataPdtParams);
            

            
           if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHDelGroupInDTTemp(){
        try {

            $tRDHDocNo      = $this->input->post('tRDHDocNo');
            $tGrpCode       = $this->input->post('tGrpCode');
            $tBchCode       = $this->input->post('tBchCode');

            $aDataPdtParams = array(
                'tDocNo'      => $tRDHDocNo,
                'tBchCode'    => $tBchCode,
                'tGrpCode'    => $tGrpCode,
                'tSessionID'  => $this->session->userdata('tSesSessionID'),
            );
            $aResult = $this->mConditionRedeem->FSaMRDHDelGroupInDTTemp($aDataPdtParams);
            

            
           if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);

    }


     // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSaCRDHChangStatusAfApv(){
        try {
        $nStaClosed      = $this->input->post('nStaClosed');
        $nStaDocAct       = $this->input->post('nStaDocAct');
        $tRDHDocNo       = $this->input->post('tRDHDocNo');
        $tBchCode       = $this->input->post('tBchCode');
        
        $aDataPdtParams = array(
            'tRDHDocNo'      => $tRDHDocNo,
            'tBchCode'     => $tBchCode ,
            'nStaClosed'    => $nStaClosed,
            'nStaDocAct'    => $nStaDocAct,
            'tSessionID'  => $this->session->userdata('tSesSessionID'),
        );
        $aResult = $this->mConditionRedeem->FSaMRDHChangStatusAfApv($aDataPdtParams);
           if($aResult['rtCode']=="1"){
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Fucntion Success"
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Fucntion Error"
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);


    }

}