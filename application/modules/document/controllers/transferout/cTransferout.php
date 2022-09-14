<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cTransferout extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->helper("file");
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/transferout/mTransferout');
    }

    public function index($nBrowseType,$tBrowseOption,$tDocType){
        $aDataConfigView = array(
            'nBrowseType'       => $nBrowseType,
            'tBrowseOption'     => $tBrowseOption,
            'tDocType'          => $tDocType,
            'aAlwEvent'         => FCNaHCheckAlwFunc('dcmTXO/0/0/'.$tDocType), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('dcmTXO/0/0/'.$tDocType), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/transferout/wTransferout',$aDataConfigView);
    }

    // Function: ฟังก์ชั่นแยกข้อมูล Database Table 
    // Parameters: Function Parameter Controller
    // Creator: 10/05/2018 wasin
    // LastUpdate: -
    // Return:  String Table Name 
    // ReturnType: String
    public function FStCTXOSwitchDatabase($ptTXODocType){
        $tTblSelectData = '';
        switch($ptTXODocType){
            case 'PTO': // ใบเบิกออก FNXthDocType = 2
                $tTblSelectData = "TCNTPdtTwo";
            break;
            case 'WAH': // ใบจ่ายโอนสินค้าระหว่างคลัง FNXthDocType = 4
                $tTblSelectData = "TCNTPdtTwo";
            break;
            case 'BCH': // ใบจ่ายโอนสินค้าระหว่างสาขา 
                $tTblSelectData = "TCNTPdtTbo";
            break;
        }
        return $tTblSelectData;
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 30/04/2018 wasin
    // Return : String View
    // Return Type : View
    public function FSvCTXOFormSearchList(){
        $this->load->view('document/transferout/wTransferoutFormSearchList');
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 02/05/2018 wasin
    // Return : Object View Data Table
    // Return Type : object
    public function FSxCTXODataTable(){
        try{
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');
            $tTXODocType        = $this->input->post('tTXODocType');
            // Controle Event
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmTXO/0/0/'.$tTXODocType);

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}

            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'tTXODocType'       => $tTXODocType,
                'tTblSelectData'    => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
                'FNLngID'           => $nLangEdit,
                'nPage'             => $nPage,
                'nRow'              => 10,
                'aAdvanceSearch'    => $aAdvanceSearch
            );

            $aDataList      = $this->mTransferout->FSaMTXOGetDataTable($aDataCondition);

            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tTXODocType'       => $tTXODocType,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );

            $tTXOViewDataTable = $this->load->view('document/transferout/wTransferoutDataTable',$aConfigView,true);

            $aReturnData = array(
                'tTXOViewDataTable' => $tTXOViewDataTable,
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

    // Functionality : Function Delete Document Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 03/05/2018 wasin
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCTXODeleteEventDoc(){
        try{
            $tTXODocType    = $this->input->post('tTXODocType');
            $tTxoDocNo      = $this->input->post('tTxoDocNo');

            $aDataMaster = array(
                'tTXODocType'   => $tTXODocType,
                'tTxoDocNo'     => $tTxoDocNo
            );

            $aResDelDoc = $this->mTransferout->FSnMTXODelDocument($aDataMaster);
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
            $aDataStaReturn  = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    // Functionality : Function Call Page Add Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 03/05/2018 wasin
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCTXOAddPage(){
        try{
            $tTXODocType        = $this->input->post('tTXODocType');
            // Clear Product IN Temp
            $tTblSelectData     = $this->FStCTXOSwitchDatabase($tTXODocType);
            $this->mTransferout->FSxMTXOClearPdtInTmp($tTblSelectData);
            // Get Option Show Decimal  
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave(); 
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            $aDataWhere = array(
                'FNLngID'   =>  $nLangEdit
            );

            $tAPIReq    = "";
            $tMethodReq = "GET";
            $aCompData  = $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);

            if($aCompData['rtCode'] == '1'){
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
                $tVatCode       = $aCompData['raItems']['rtVatCodeUse'];
                $aVatRate       = FCNoHCallVatlist($tVatCode); 
                $cVatRate       = $aVatRate['FCVatRate'][0];
                $aDataRate      = array(
                    'FTRteCode' => $tCmpRteCode,
                    'FNLngID'   => $nLangEdit
                );
                $aResultRte     = $this->mRate->FSaMRTESearchByID($aDataRate);
                $cXthRteFac     = $aResultRte['raItems']['rcRteRate'];
            }else{
                $tBchCode       = FCNtGetBchInComp();
                $tCmpRteCode    = "";
                $tVatCode       = "";
                $cVatRate       = "";
                $cXthRteFac     = "";
            }

            // Get Department Code
            $tUsrLogin  = $this->session->userdata('tSesUsername');
            $tDptCode   = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $aDataShp   = array(
                'FNLngID'   => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );
            $aDataUserGroup = $this->mTransferout->FSaTXOGetShpCodeForUsrLogin($aDataShp);
            if(empty($aDataUserGroup)){
                $tBchCode       = "";
                $tBchName       = "";
                $tMchCode       = "";
                $tMchName       = "";
                $tShpCodeFrom   = "";
                $tShpNameFrom   = "";
                $tShpCodeTo     = "";
                $tShpNameTo     = "";
                $tWahCodeFrom   = "";
                $tWahNameFrom   = "";
                $tWahCodeTo     = "";
                $tWahNameTo     = "";
                $tShpType       = "";
            }else{
                $tShpType       = $aDataUserGroup["FTShpType"];
                // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
                if(empty($aDataUserGroup["FTBchCode"])){
                    // ถ้าว่าง ให้ Get Option Def
                    $tBchCode   = '';
                    $tBchName   = '';
                }else{
                    $tBchCode   = $aDataUserGroup["FTBchCode"];
                    $tBchName   = $aDataUserGroup["FTBchName"];
                }

                $tMchCode   = $aDataUserGroup["FTMerCode"];
                $tMchName   = $aDataUserGroup["FTMerName"];

                if(empty($aDataUserGroup["FTShpCode"])){
                    $tShpCodeFrom   = "";
                    $tShpNameFrom   = "";
                    $tShpCodeTo     = "";
                    $tShpNameTo     = "";
                    $tWahCodeFrom   = "";
                    $tWahNameFrom   = "";
                    $tWahCodeTo     = "";
                    $tWahNameTo     = "";
                }else{
                    $tShpCodeFrom   = $aDataUserGroup["FTShpCode"];
                    $tShpNameFrom   = $aDataUserGroup["FTShpName"];
                    $tShpCodeTo     = "";
                    $tShpNameTo     = "";
                    $tWahCodeFrom   = $aDataUserGroup["FTWahCode"];
                    $tWahNameFrom   = $aDataUserGroup["FTWahName"];
                    $tWahCodeTo     = "";
                    $tWahNameTo     = "";
                }
            }

            $aDataConfigViewAdd     = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'nOptScanSku'       => $nOptScanSku,
                'tCmpRteCode'       => $tCmpRteCode,
                'tVatCode'          => $tVatCode,
                'cVatRate'          => $cVatRate,
                'cXthRteFac'        => $cXthRteFac,
                'tDptCode'          => $tDptCode,
                'tBchCode'          => $tBchCode,
                'tBchName'          => $tBchName,
                'tMchCode'          => $tMchCode,
                'tMchName'          => $tMchName,
                'tShpType'          => $tShpType,
                'tShpCodeFrom'      => $tShpCodeFrom,
                'tShpNameFrom'      => $tShpNameFrom,
                'tShpCodeTo'        => $tShpCodeTo,
                'tShpNameTo'        => $tShpNameTo,
                'tWahCodeFrom'      => $tWahCodeFrom,
                'tWahNameFrom'      => $tWahNameFrom,
                'tWahCodeTo'        => $tWahCodeTo,
                'tWahNameTo'        => $tWahNameTo,
                'tTXODocType'       => $tTXODocType,
                'aDataDocHD'        => array('rtCode'=>'99'),
                'aDataDocHDRef'     => array('rtCode'=>'99'),
                'tBchCompCode'      =>  FCNtGetBchInComp(),
                'tBchCompName'      =>  FCNtGetBchNameInComp()  
            );
            $tTXOViewPageAdd    = $this->load->view('document/transferout/wTransferoutAdd',$aDataConfigViewAdd,true);
            $aReturnData        = array(
                'tTXOViewPageAdd'   => $tTXOViewPageAdd,
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

    // Functionality : Function Call Page Product Advance Table 
    // Parameters : Ajax and Function Parameter
    // Creator : 10/05/2018 wasin
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCTXOPdtAdvTblLoadData(){
        try{
            $tTXODocNo          = $this->input->post('ptTXODocNo');
            $tTXOStaApv         = $this->input->post('ptTXOStaApv');
            $tTXOStaDoc         = $this->input->post('ptTXOStaDoc');
            $tTXOVATInOrEx      = $this->input->post('ptTXOVATInOrEx');
            $nTXOPageCurrent    = $this->input->post('pnTXOPageCurrent');
            $tTXODocType        = $this->input->post('ptTXODocType');

            $aDataWhere = array(
                'FTXthDocNo'    => $tTXODocNo,
                'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
                'nPage'         => $nTXOPageCurrent,
                'nRow'          => 10,
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
            );

            // คำนวน DT ใหม่
            $aResCalDTTmp       = $this->FSnCTXOCalulateDTTemp($tTXODocNo,$tTXOVATInOrEx,$tTXODocType);

            // Edit in line
            $tPdtCode           = $this->input->post('ptPdtCode');
            $tPunCode           = $this->input->post('ptPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableTransferOut  = $this->FStCTXOSwitchDatabase($tTXODocType).'DT';
            $aColumnShow        = FCNaDCLGetColumnShow($tTableTransferOut);

            $aDataDT            = $this->mTransferout->FSaMTXOGetDTTempListPage($aDataWhere);
            $aDataDTSum         = $this->mTransferout->FSaMTXOSumDTTemp($aDataWhere);
            
            $aDataView          = array(
                'aColumnShow'       => $aColumnShow,
                'aDataDT'           => $aDataDT,
                'aDataDTSum'        => $aDataDTSum,
                'tPdtCode'          => $tPdtCode,
                'tPunCode'          => $tPunCode,
                'tTXOStaApv'        => $tTXOStaApv,
                'tTXOStaDoc'        => $tTXOStaDoc,
                'nOptDecimalShow'   => $nOptDecimalShow,
            );

            $tTransferOutPdtAdvTableView = $this->load->view('document/transferout/wTransferoutPdtAdvTableData',$aDataView,true);
            
            $aReturnData = array(
                'tTransferOutPdtAdvTableView'   => $tTransferOutPdtAdvTableView,
                'nStaEvent'                     => '1',
                'tStaMessg'                     => 'Success View'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Process Calulate DT Temp
    // Parameters: Function Parameter Controller
    // Creator: 10/05/2018 wasin
    // LastUpdate: -
    // Return:
    // ReturnType:
    public function FSnCTXOCalulateDTTemp($ptTXODocNo,$ptTXOVATInOrEx,$ptTXODocType){

        $tTXODocType    = $ptTXODocType;
        
        $aDataWhere = array(
            'FTXthDocNo'    => $ptTXODocNo,
            'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
        );

        // Get Option Save Decimal  
        $nOptTXODecimalSave = FCNxHGetOptionDecimalSave(); 

        //Get DT Tmp
        $aTXODataDTTmp  = $this->mTransferout->FSaMTXOGetDTTemp($aDataWhere);

        if(isset($aTXODataDTTmp['rtCode']) &&  $aTXODataDTTmp['rtCode'] == '1'){
            $aTXODataDTTmp  = $aTXODataDTTmp['raItems'];
            foreach($aTXODataDTTmp as $nKey => $aValue){
                // คำนวน FCXtdQtyAll จำนวนรวมหน่วยเล็กสุด(จ่ายโอน)(Qty*Factor*StkFac)
                $FCXtdQtyAll                            = $aValue['FCXtdQty']*$aValue['FCXtdFactor'];
                $aTXODataDTTmp[$nKey]['FCXtdQtyAll']    = $FCXtdQtyAll;

                // คำนวน FCXtdAmt  (Qty*SetPrice) 
                $FCXtdAmt                           = $aValue['FCXtdQty']*$aValue['FCXtdSetPrice'];
                $aTXODataDTTmp[$nKey]['FCXtdAmt']   = number_format($FCXtdAmt, $nOptTXODecimalSave, '.', '');

                //มูลค่าภาษี IN: ((Net*VatRate)/(100+VatRate)) ,EX: ((Net*(100+VatRate))/100)
                if($ptTXOVATInOrEx == 1){
                    // $FCXtdVat = $FCXtdAmt*$value['FCXtdVatRate'];
                    $FCXtdVat = (($FCXtdAmt*$aValue['FCXtdVatRate'])/(100+$aValue['FCXtdVatRate']));
                }else{
                    $FCXtdVat = (($FCXtdAmt*(100+$aValue['FCXtdVatRate']))/100);
                }
                $aTXODataDTTmp[$nKey]['FCXtdVat']       = number_format($FCXtdVat, $nOptTXODecimalSave, '.', '');

                //มูลค่าแยกภาษี (Amt-FCXpdVat)
                $FCXtdVatable = $FCXtdAmt-$FCXtdVat;
                $aTXODataDTTmp[$nKey]['FCXtdVatable']   = number_format($FCXtdVatable, $nOptTXODecimalSave, '.', '');

                //มูลค่าสุทธิก่อนท้ายบิล (FCXpdVat+FCXpdVatable)
                if($ptTXOVATInOrEx == 1){
                    $FCXtdNet = $FCXtdVat+$FCXtdVatable;
                }else{
                    $FCXtdNet = $FCXtdVat;
                }
                $aTXODataDTTmp[$nKey]['FCXtdNet']       = number_format($FCXtdNet, $nOptTXODecimalSave, '.', '');

                //ต้นทุนรวมใน (FCXpdVat+FCXpdVatable)
                $FCXtdCostIn = $FCXtdVat+$FCXtdVatable;
                $aTXODataDTTmp[$nKey]['FCXtdCostIn']    = number_format($FCXtdCostIn, $nOptTXODecimalSave, '.', '');

                //ต้นทุนแยกนอก (FCXpdVatable)
                $aTXODataDTTmp[$nKey]['FCXtdCostEx']    = number_format($FCXtdVatable, $nOptTXODecimalSave, '.', '');

            }
            $aResUpd = $this->mTransferout->FSnMTXOUpdateDTTemp($aTXODataDTTmp,$aDataWhere);
        }
    }

    // Function: Process Calulate DT Temp
    // Parameters: Function Parameter Controller
    // Creator: 10/05/2018 wasin
    // LastUpdate: -
    // Return: View
    // ReturnType: Srt View
    public function FSoCTXOVatLoadData(){
        try{
            $tTXODocType    = $this->input->post('tTXODocType');
            $tTXODocNo      = $this->input->post('tTXODocNo');
            $tTXOVATInOrEx  = $this->input->post('tTXOVATInOrEx');

            $aDataWhere = array(
                'FTXthDocNo'    => $tTXODocNo,
                'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
            );
            
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // คำนวน DT ใหม่
            $aResCalDTTmp       = $this->FSnCTXOCalulateDTTemp($tTXODocNo,$tTXOVATInOrEx,$tTXODocType);
            // Get Data Vat DT Temp
            $aDataVatDT         = $this->mTransferout->FSaMTXOGetVatDTTemp($aDataWhere);
            // Get Data DT Tmp
            $aDataDTTmp         = $this->mTransferout->FSaMTXOGetDTTemp($aDataWhere);

            $cTXOTotal          = 0;
            if($aDataDTTmp['rtCode'] == '1'){
                $aDataDTTmp = $aDataDTTmp['raItems'];
                foreach ($aDataDTTmp as $nKey => $aValueDataTmp){
                    //รวมใน 
                    if($tTXOVATInOrEx == 1){
                        $cTXOTotal  += $aValueDataTmp['FCXtdVat']+$aValueDataTmp['FCXtdVatable'];
                    }else{
                    //แยกนอก
                        $cTXOTotal  += $aValueDataTmp['FCXtdVat'];
                    }
                }
                $cTXOTotal      = number_format($cTXOTotal,$nOptDecimalShow, '.', ',');
                $tTXOTotalText  = FCNtNumberToTextBaht($cTXOTotal);
            }else{
                $cTXOTotal      = number_format($cTXOTotal,$nOptDecimalShow, '.', ',');
                $tTXOTotalText  = '-';
            }

            $aDataViewVatTableData  = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tTXOVATInOrEx'     => $tTXOVATInOrEx,
                'cTXOTotal'         => $cTXOTotal,
                'tTXOTotalText'     => $tTXOTotalText,
                'aDataVatDT'        => $aDataVatDT
            );

            $tTXOViewVatTableData  =  $this->load->view('document/transferout/wTransferoutVatTableData',$aDataViewVatTableData,true);
            $aReturnData = array(
                'tTXOViewVatTableData'  => $tTXOViewVatTableData,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Process Calulate DT Temp
    // Parameters: Function Parameter Controller
    // Creator: 10/05/2018 wasin
    // LastUpdate: -
    // Return:
    // ReturnType:
    public function FSoCTXOCalculateLastBill(){
        try{
            $tTXODocType    = $this->input->post('tTXODocType');
            $tTXODocNo      = $this->input->post('tTXODocNo');
            $tTXOVATInOrEx  = $this->input->post('tTXOVATInOrEx');

            $aDataWhere = array(
                'FTXthDocNo'    => $tTXODocNo,
                'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
            );

            //Get Option Save Decimal  
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
            $aDataDTTmp         = $this->mTransferout->FSaMTXOGetDTTemp($aDataWhere);
            $aDataVatDT         = $this->mTransferout->FSaMTXOGetVatDTTemp($aDataWhere);

            $cTXOTotal          = 0;
            if($aDataDTTmp['rtCode'] == '1'){
                $aDataDTTmp = $aDataDTTmp['raItems'];
                foreach ($aDataDTTmp as $nKey => $aValueDataTmp){
                    //รวมใน 
                    if($tTXOVATInOrEx == 1){
                        $cTXOTotal  += $aValueDataTmp['FCXtdVat']+$aValueDataTmp['FCXtdVatable'];
                    }else{
                    //แยกนอก
                        $cTXOTotal  += $aValueDataTmp['FCXtdVat'];
                    }
                }
                $cTXOTotal      = number_format($cTXOTotal,$nOptDecimalShow, '.', ',');
                $tTXOTotalText  = FCNtNumberToTextBaht($cTXOTotal);
            }else{
                $cTXOTotal      = number_format($cTXOTotal,$nOptDecimalShow, '.', ',');
                $tTXOTotalText  = '-';
            }

            $cTXOSumVat = 0;
            if($aDataVatDT['rtCode'] == '1'){
                foreach($aDataVatDT['raItems'] AS $nKey => $aValue){
                    if($tTXOVATInOrEx == 1){
                        $cTXOSumVat += $aValue['FCXtdVat'];
                    }else{
                        $cTXOSumVat += ($aValue['FCXtdVatable']*-1);
                    }
                }
            }

            $aDataViewCalcLastBill  = array(
                'tTXOTotalText' => $tTXOTotalText,
                'cTXOTotal'     => $cTXOTotal,
                'cTXOSumVat'    => number_format($cTXOSumVat,$nOptDecimalShow, '.', ',')
            );

            $tTXOViewCalcLastBill = $this->load->view('document/transferout/wTransferoutCalculateLastBill',$aDataViewCalcLastBill,true);
            $aReturnData = array(
                'tTXOViewCalcLastBill'  => $tTXOViewCalcLastBill,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Call View Table Manage Advance Table
    // Parameters: Document Type
    // Creator: 15/05/2018 wasin
    // LastUpdate: -
    // Return: Object View Advance Table
    // ReturnType: Object
    public function FSoCTXOAdvTblShowColList(){
        try{
            $tTXODocType        = $this->input->post('tTXODocType');
            $tTableShowColums   = $this->FStCTXOSwitchDatabase($tTXODocType).'DT';
            $aAvailableColumn   = FCNaDCLAvailableColumn($tTableShowColums);

            $aDataViewAdvTbl    = array(
                'aAvailableColumn'  => $aAvailableColumn
            );
            $tViewTableShowCollist  = $this->load->view('document/transferout/advancetable/wTransferoutTableShowColList',$aDataViewAdvTbl,true);
            $aReturnData = array(
                'tViewTableShowCollist' => $tViewTableShowCollist,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Save Columns Advance Table
    // Parameters: Data Save Colums Advance Table
    // Creator: 15/05/2018 wasin
    // LastUpdate: -
    // Return: Object Sta Save Advance Table
    // ReturnType: Object
    public function FSoCTXOShowColSave(){
        try{
            $this->db->trans_begin();

            $tTXODocType            = $this->input->post('tTXODocType');
            $aTXOColShowSet         = $this->input->post('aTXOColShowSet');
            $aTXOColShowAllList     = $this->input->post('aTXOColShowAllList');
            $aTXOColumnLabelName    = $this->input->post('aTXOColumnLabelName');
            $nTXOStaSetDef          = $this->input->post('nTXOStaSetDef');

            // Table Set Show Colums
            $tTableShowColums   = $this->FStCTXOSwitchDatabase($tTXODocType).'DT';

            FCNaDCLSetShowCol($tTableShowColums,'','');
            if($nTXOStaSetDef == '1'){
                FCNaDCLSetDefShowCol($tTableShowColums);
            }else{
                for($i = 0; $i < FCNnHSizeOf($aTXOColShowSet); $i++){
                    FCNaDCLSetShowCol($tTableShowColums,1,$aTXOColShowSet[$i]);
                }
            }

            // Reset Seq Advannce Table
            FCNaDCLUpdateSeq($tTableShowColums,'','','');
            $q  = 1;
            for($n = 0; $n<FCNnHSizeOf($aTXOColShowAllList); $n++){
                FCNaDCLUpdateSeq($tTableShowColums,$aTXOColShowAllList[$n],$q,$aTXOColumnLabelName[$n]);
                $q++;
            }

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Eror Not Save Colums'
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Add Product Into DT Tmp 
    // Parameters: Data Save Colums Advance Table
    // Creator: 17/05/2018 wasin
    // LastUpdate: -
    // Return: Object View Product DT Tmp
    // ReturnType: Object
    public function FSoCTXOAddPdtIntoTableDTTmp(){
        $tTXODocType        = $this->input->post('ptTXODocType'); 
        $tTXODocNo          = $this->input->post('ptTXODocNo');
        $tTXOBchCode        = $this->input->post('ptTXOBchCode');
        $tTXOVATInOrEx      = $this->input->post('ptTXOVATInOrEx');
        $tTXOOptionAddPdt   = $this->input->post('ptTXOOptionAddPdt');
        $oTXOPdtDataReturn  = $this->input->post('poTXOPdtDataReturn');
        $aTXOPdtDataReturn  = json_decode($oTXOPdtDataReturn,true);
        $aDataWhere = array(
            'FTXthDocNo'    => $tTXODocNo,
            'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
        );
       
        $nCounts = $this->mTransferout->FSnMTXOGetCountDTTemp($aDataWhere);
        
        foreach($aTXOPdtDataReturn AS $nKey => $aValue){
            $pnPdtCode      = $aValue['pnPdtCode'];
            $ptBarCode      = $aValue['ptBarCode']; 
            $ptPunCode      = $aValue['ptPunCode'];
            $pcPrice        = $aValue['packData']['Price'];
            $FCXtdSetPrice  = $pcPrice*1; //1 คือ Rate
            $nCounts        = $nCounts+1;
            $aDataPdtWhere = array(
                'FTXthDocNo'    => $tTXODocNo,  
                'FTBchCode'     => $tTXOBchCode,    // จากสาขาที่ทำรายการ
                'FTPdtCode'     => $pnPdtCode,      // จาก Browse Pdt
                'FTPunCode'     => $ptPunCode,      // จาก Browse Pdt
                'FTBarCode'     => $ptBarCode,      // จาก Browse Pdt
                'FCXtdSetPrice' => $FCXtdSetPrice,  // ราคาสินค้าจาก Browse Pdt
                'nCounts'       => $nCounts,        // จำนวนล่าสุด Seq
                'tOptionAddPdt' => $tTXOOptionAddPdt,  // Option Add Pdt
                'FNLngID'       => $this->session->userdata("tLangID"), //รหัสภาษาที่ login
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
            );

            $aDataPdtMaster     = $this->mTransferout->FSaMTXOGetDataPdt($aDataPdtWhere);
            $nStaInsPdtToTmp    = $this->mTransferout->FSaMTXOInsertPDTToTmp($aDataPdtMaster,$aDataPdtWhere);
        }

        //คำนวน DT ใหม่
        $aResCalDTTmp   = $this->FSnCTXOCalulateDTTemp($tTXODocNo,$tTXOVATInOrEx,$tTXODocType);
    } 

    // Function: Edit Product Into DTTmp
    // Parameters: Event Ajax Delete DTTmp
    // Creator: 17/05/2018 wasin
    // LastUpdate: -
    // Return: Object Status Edit DTTmp
    // ReturnType: Object
    public function FSoCTXOEditPdtIntoTableDTTmp(){
        try{
            $tTXODocType    = $this->input->post('ptTXODocType');
            $tTXODocNo      = $this->input->post('ptTXODocNo');
            $tTXOEditSeqNo  = $this->input->post('ptTXOEditSeqNo');
            $aTXOFieldData  = $this->input->post('paTXOFieldData');
            $aTXOValueData  = $this->input->post('paTXOValueData');
            
            $aDataWhere = array(
                'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType) . 'HD',
                'FTXthDocNo'    => $tTXODocNo,
                'FNXtdSeqNo'    => $tTXOEditSeqNo,
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            );

            $aDataUpdateDT = array();
            foreach($aTXOFieldData as $nKey => $aFieldName) {
                $aDataUpdateDT[$aFieldName] = $aTXOValueData[$nKey];
            }
            //Edit Inline
            $aResUpdDTTmpInline = $this->mTransferout->FSaMTXOUpdateInlineDTTmp($aDataUpdateDT, $aDataWhere);
            $aReturnData = array(
                'nStaEvent' => $aResUpdDTTmpInline['rtCode'],
                'tStaMessg' => $aResUpdDTTmpInline['rtDesc'],
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Delect Product Into DTTmp
    // Parameters: Event Ajax Delete DTTmp
    // Creator: 17/05/2018 wasin
    // LastUpdate: -
    // Return: Object Status Delete DTTmp
    // ReturnType: Object
    public function FSoCTXORemovePdtInDTTmp(){
        try{
            $tTXODocType    = $this->input->post('ptTXODocType');
            $tTXODocNo      = $this->input->post('ptTXODocNo');
            $tTXOPdtCode    = $this->input->post('ptTXOPdtCode');
            $tTXOPdtSeqNo   = $this->input->post('ptTXOPdtSeqNo');
            $tTXOSessionID  = $this->session->userdata('tSesSessionID');
            $tTXODocKey     = $this->FStCTXOSwitchDatabase($tTXODocType).'HD';

            $aDataWhere = array(
                'FTXthDocNo'    => $tTXODocNo,
                'FNXtdSeqNo'    => $tTXOPdtSeqNo,
                // 'FTPdtCode'     => $tTXOPdtCode,
                'FTSessionID'   => $tTXOSessionID,
            );

            $aDataDelPdtInDtTemp    = $this->mTransferout->FSaMTXOPdtDeleteInDtTmp($aDataWhere);
            $aReturnData = array(
                'nStaEvent' => $aDataDelPdtInDtTemp['rtCode'],
                'tStaMessg' => $aDataDelPdtInDtTemp['rtDesc']
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Delect Multiple Product Into DTTmp
    // Parameters: Event Ajax Delete DTTmp
    // Creator: 21/05/2018 wasin
    // LastUpdate: -
    // Return: Object Status Delete DTTmp
    // ReturnType: Object
    public function FSoCTXORemovePdtMultiInDTTmp(){
        try{
            $tTXODocType    = $this->input->post('tTXODocType');
            $tTXODocNo      = $this->input->post('tTXODocNo');
            $aTXOSeqData    = $this->input->post('aTXOSeqData');
            $tTXOSessionID  = $this->session->userdata('tSesSessionID');
            $tTXODocKey     = $this->FStCTXOSwitchDatabase($tTXODocType).'HD';
            $nCountSeqData  = FCNnHSizeOf($aTXOSeqData);

            // Start Transaction Begin (เริ่มทรานเซคชั่นของ DB)
            $this->db->trans_begin();

            if($nCountSeqData > 1){
                for($i = 0; $i < $nCountSeqData; $i++){
                    $aDataMaster = array(
                        'FTXthDocNo'    => $tTXODocNo,
                        'FNXtdSeqNo'    => $aTXOSeqData[$i],
                        'FTXthDocKey'   => $tTXODocKey,
                        'FTSessionID'   => $tTXOSessionID
                    );
                    $aResDel = $this->mTransferout->FSxMTXODelMultiDTTmp($aDataMaster);
                }
            }

            // Check Sta Transaction True = RollBack , False == Commit 
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '905',
                    'tStaMessg' => 'Cannot Delete Multiple Product Item.',
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Delete Multiple Complete.',
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Check Product Have In Temp For Transfer DT
    // Parameters: Ajex Event Before Save DT
    // Creator: 22/05/2018 wasin
    // LastUpdate: -
    // Return: Object Status Check Product DT Temp
    // ReturnType: Object
    public function FSoCTXOChkHavePdtForTnf(){
        try{
            $tTXODocType    = $this->input->post("ptTXODocType");
            $tTXODocNo      = $this->input->post("ptTXODocNo");
            $tTXOSessionID  = $this->session->userdata('tSesSessionID');
            $aDataWhere     = array(
                'FTXthDocNo'    => $tTXODocNo,
                'FTXthDocKey'   => $this->FStCTXOSwitchDatabase($tTXODocType).'HD',
                'FTSessionID'   => $tTXOSessionID
            );

            $nCountPdtInDtTmp   = $this->mTransferout->FSnMTXOChkPdtDtTmpForTnf($aDataWhere);
            if($nCountPdtInDtTmp > 0){
                $aReturnData = array(
                    'nStaReturn'    => '1',
                    'tStaMessg'     => 'Found Data In Doc DT.'
                );
            }else{
                $aReturnData = array(
                    'nStaReturn'    => '800',
                    'tStaMessg'     => language('document/transferout/transferout', 'tTXOPlsAddPdtToDocDT')
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaReturn'    => '500',
                'tStaMessg'     => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Add Document 
    // Parameters: Ajex Event Add Document
    // Creator: 22/05/2018 wasin
    // LastUpdate: -
    // Return: Object Status Add Document
    // ReturnType: Object
    public function FSoCTXOAddEventDoc(){
        try{
            $aDataDocument      = $this->input->post();
            $tTXODocType        = $aDataDocument['ohdTXODocType'];
            $tTXOAutoGenCode    = (isset($aDataDocument['ocbTXOStaAutoGenCode']))? 1: 0;
            $tTXODocNo          = (isset($aDataDocument['oetTXODocNo']))? $aDataDocument['oetTXODocNo']: '';
            $tTXODocDate        = $aDataDocument['oetTXODocDate']." ".$aDataDocument['oetTXODocTime'];
            $tTXOStaDocAct      = (isset($aDataDocument['ocbTXOStaDocAct']))? 1: 0;
            $tTXOVATInOrEx      = $aDataDocument['ostTXOVATInOrEx'];
            $tTableNameMain     = $this->FStCTXOSwitchDatabase($tTXODocType);
            // แยกใบเอกสาร 
            switch($tTXODocType){
                case 'WAH':
                    $aDataMaster        = array(
                        'FTBchCode'         => $aDataDocument['oetTXOBchCode'],
                        'FNXthDocType'      => 4,
                        'FTXthRsnType'      => 1,
                        // 'FTShpCode'         => '',
                        'FDXthDocDate'      => $tTXODocDate,
                        'FTXthMerCode'      => $aDataDocument['oetTXOMchCode'],
                        'FTXthShopFrm'      => $aDataDocument['oetTXOShpCodeFrom'],
                        'FTXthShopTo'       => $aDataDocument['oetTXOShpCodeTo'],
                        'FTXthVATInOrEx'    => $tTXOVATInOrEx,
                        'FTDptCode'         => $aDataDocument['ohdTXODptCode'],
                        'FTXthWhFrm'        => $aDataDocument['oetTXOWahCodeFrom'],
                        'FTXthWhTo'         => $aDataDocument['oetTXOWahCodeTo'],
                        'FTUsrCode'         => $aDataDocument['ohdTXOUsrCode'],
                        'FTXthRefExt'       => $aDataDocument['oetTXORefExt'],
                        'FDXthRefExtDate'   => $aDataDocument['oetTXORefExtDate'],
                        'FTXthRefInt'       => $aDataDocument['oetTXORefInt'],
                        'FDXthRefIntDate'   => $aDataDocument['oetTXORefIntDate'],
                        'FNXthDocPrint'     => 0,
                        'FCXthTotal'        => 0,
                        'FCXthVat'          => 0,
                        'FCXthVatable'      => 0,
                        'FTXthRmk'          => $this->input->post('otaTXORmk'),
                        'FTXthStaDoc'       => 1,
                        'FTXthStaApv'       => '',
                        'FTXthStaPrcStk'    => '',
                        'FNXthStaDocAct'    => $tTXOStaDocAct,
                        'FNXthStaRef'       => $aDataDocument['ostTXOStaRef'],
                    );

                    $aTableAddUpdate    = array(
                        'tTableHD'      => $tTableNameMain.'HD',
                        'tTableDT'      => $tTableNameMain.'DT',
                        'tTableHDRef'   => $tTableNameMain.'HDRef',
                        'tTableStaGen'  => 4
                    );

                    $aDataHDRef = array(
                        'FTXthCtrName'          => $aDataDocument['oetTXOCtrName'],
                        'FDXthTnfDate'          => $aDataDocument['oetTXOTnfDate'],
                        'FTXthRefTnfID'         => $aDataDocument['oetTXORefTnfID'],
                        'FTXthRefVehID'         => $aDataDocument['oetTXORefVehID'],
                        'FTXthQtyAndTypeUnit'   => $aDataDocument['oetTXOQtyAndTypeUnit'],
                        'FNXthShipAdd'          => $aDataDocument['ohdTXOShipAdd'],
                        'FTViaCode'             => $aDataDocument['oetTXOViaCode']
                    );

                    $aDataWhere = array(
                        'FTXthDocNo'        => $tTXODocNo,
                        'FTBchCode'         => $aDataDocument['oetTXOBchCode'],
                        'FDLastUpdOn'       => date('Y-m-d'),
                        'FDCreateOn'        => date('Y-m-d'),
                        'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                        'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                        'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                        'FTXthVATInOrEx'    => $tTXODocDate,
                        'FTTXODocType'      => $tTXODocType
                    );
                break;
                case 'BCH':
                break;
            }
            
            $this->db->trans_begin();

            // Check Auto GenCode Document
            if($tTXOAutoGenCode == '1'){

                $aStoreParam = array(
                    "tTblName"    => $aTableAddUpdate['tTableHD'],                           
                    "tDocType"    => $aTableAddUpdate['tTableStaGen'],                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXthDocNo']   = $aAutogen[0]["FTXxhDocNo"];

                // $aTXOGenCode    =   FCNaHGenCodeV5($aTableAddUpdate['tTableHD'],$aTableAddUpdate['tTableStaGen']);
                // if($aTXOGenCode['rtCode'] == '1'){
                //     $aDataWhere['FTXthDocNo']   = $aTXOGenCode['rtXthDocNo'];
                // }
            }else{
                $aDataWhere['FTXthDocNo']   = $tTXODocNo;
            }
            
            // Add Update Document HD
            $aStaInsHD      = $this->mTransferout->FSaMTXOAddUpdateHD($aDataMaster,$aDataWhere,$aTableAddUpdate);
            // // Add Update Document HD Ref
            $aStaInsHDRef   = $this->mTransferout->FSaMTXOAddUpdateHDRef($aDataHDRef,$aDataWhere,$aTableAddUpdate);
            // // Update Doc No Into Doc Temp
            $aStaUpdDocNoInDT   = $this->mTransferout->FSaMTXOAddUpdateDocNoInDocTemp($aDataWhere,$aTableAddUpdate);
            // // Move Doc Tmp To DT
            $this->FSxCTXOAddTmpToDT($aDataWhere,$aTableAddUpdate);
            // // Sum DT Into HD
            $this->FSxCTXOSumDTIntoHD($aDataWhere,$aTableAddUpdate);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent'     => '900',
                    'tStaMessg'     => "Error Unsucess Add Document."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataWhere['FTXthDocNo'],
                    'nStaReturn'    => '1',
                    'tStaMessg'		=> 'Success Add Document.'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaReturn'    => '500',
                'tStaMessg'     => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Move Doc Temp To Doc DT
    // Parameters : function parameters
    // Creator : 22/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Move Doc Temp To Doc DT
    // Return Type : array
    public function FSxCTXOAddTmpToDT($paDataWhere,$paTableAddUpdate){
        $tTXODocType    = $paDataWhere['FTTXODocType'];
        $tTXODocNo      = $paDataWhere['FTXthDocNo'];
        $tTXOVATInOrEx  = $paDataWhere['FTXthVATInOrEx'];
        
        $aDataWhere = array(
            'FTXthDocNo'    => $tTXODocNo,
            'FTXthDocKey'   => $paTableAddUpdate['tTableHD']
        );
        $this->FSnCTXOCalulateDTTemp($tTXODocNo,$tTXOVATInOrEx,$tTXODocType);
        $this->mTransferout->FSaMTXOInsertTmpToDT($paDataWhere,$paTableAddUpdate);
        return;
    }

    // Functionality : Sum Data DT Into HD
    // Parameters : function parameters
    // Creator : 23/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Sum Data DT Into HD
    // Return Type : array
    public function FSxCTXOSumDTIntoHD($paDataWhere,$paTableAddUpdate){
        $tTXODocType    = $paDataWhere['FTTXODocType'];
        $tTXODocNo      = $paDataWhere['FTXthDocNo'];
        $tTXOVATInOrEx  = $paDataWhere['FTXthVATInOrEx'];
        //Get Option Save Decimal  
        $nOptDecimalSave    = FCNxHGetOptionDecimalSave();
        $aData  = array(
            'tTXODocType'   => $tTXODocType,
            'FTXthDocNo'    => $tTXODocNo,
            'nRow'          => 10000,
            'nPage'         => 1,
        );

        $aDataDTDoc = $this->mTransferout->FSaMTXOGetDTDocument($aData,$paTableAddUpdate);
        $FCXthTotal = 0;
        if($aDataDTDoc['rtCode'] == 1){
            $aDataItemsDT   = $aDataDTDoc['raItems'];
            foreach ($aDataItemsDT as $nKey => $aValue){
                if($tTXOVATInOrEx == 1){
                    $FCXthTotal +=  $aValue['FCXtdVat']+$aValue['FCXtdVatable'];
                }else{
                    $FCXthTotal +=  $aValue['FCXtdVat'];
                }
            }
        }
        $aDataUpdTotalHD = array(
            'FCXthTotal'    => number_format($FCXthTotal,$nOptDecimalSave,'.','')
        );

        $this->mTransferout->FSnMTXOUpdateHDFCXthTotal($aDataUpdTotalHD,$paDataWhere,$paTableAddUpdate);
    }

    // Functionality : Clear Data In DocTemp
    // Parameters : function parameters
    // Creator : 07/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data
    // Return Type : array
    public function FSoCTXOClearDataDocTemp(){
        try{
            $tTXODocType    = $this->input->post('ptTXODocType');
            $tTXODocNo      = $this->input->post('ptTXODocNo');
            $tTXOSessionID  = $this->session->userdata('tSesSessionID');
            $tTXODockey     = $this->FStCTXOSwitchDatabase($tTXODocType)."HD";

            $aDataWhere     = array(
                "FTXthDocNo"    => $tTXODocNo,
                "FTXthDocKey"   => $tTXODockey,
                "FTSessionID"   => $tTXOSessionID,
            );

            $this->db->trans_begin();

            $this->mTransferout->FSaMTXOClearDataDocTemp($aDataWhere);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaReturn' => '900',
                    'tStaMessg' => "Error Not Delete Document Temp."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Success Delete Document Temp.'
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaReturn'    => '500',
                'tStaMessg'     => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Edit Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 23/05/2018 wasin
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCTXOEditPage(){
        try{
            $tTXODocType    = $this->input->post('tTXODocType');
            $tTXODocNo      = $this->input->post('tTXODocNo');
            //Get Option Show Decimal  
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
            //Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave(); 
            //Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            
            //Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $tUsrLogin  = $this->session->userdata('tSesUsername');
            $aDataShp   = array(
                'FNLngID'   => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );
            $aDataUserGroup = $this->mTransferout->FSaTXOGetShpCodeForUsrLogin($aDataShp);
            if(empty($aDataUserGroup)){
                $tBchCode   = '';
                $tMchCode   = '';
                $tShpCode   = '';
                $tShpType   = '';
            }else{
                $tShpType   = $aDataUserGroup["FTShpType"];

                // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
                if(empty($aDataUserGroup["FTBchCode"])){
                    $tBchCode   = '';
                }else{
                    $tBchCode   = $aDataUserGroup["FTBchCode"];
                }

                // เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
                if(empty($aDataUserGroup["FTShpCode"])){
                    $tMchCode   = '';
                    $tShpCode   = '';
                }else{
                    $tMchCode   = $aDataUserGroup["FTMerCode"];
                    $tShpCode   = $aDataUserGroup["FTShpCode"];
                }
            }

            // Control Event 
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmTXO/0/0/'.$tTXODocType); 
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();

            // Name Table Switch 3 DOC
            $tTXOTableMain      = $this->FStCTXOSwitchDatabase($tTXODocType);
            $aTableAddUpdate    = array(
                'tTableHD'      => $tTXOTableMain.'HD',
                'tTableDT'      => $tTXOTableMain.'DT',
                'tTableHDRef'   => $tTXOTableMain.'HDRef',
            );
            // Array Data Where Get HD,DT
            $aDataWhere         = array(
                'tTXODocType'   => $tTXODocType,
                'FTXthDocNo'    => $tTXODocNo,
                'FNLngID'       => $nLangEdit,
                'nRow'          => 10000,
                'nPage'         => 1,
            );

            // Get Data Document HD
            $aDataDocHD     = $this->mTransferout->FSaMTXOGetDataDocHD($aDataWhere);
            // Get Data Document HD Ref
            $aDataDocHDRef  = $this->mTransferout->FSaMTXOGetDataDocHDRef($aDataWhere);
            // Get Data Document DT
            $aDataDocDT     = $this->mTransferout->FSaMTXOGetDTDocument($aDataWhere,$aTableAddUpdate);
            // Move DT Insert To DocDTTemp
            $aStaIns        = $this->mTransferout->FSaMTXOInsertDTToTemp($aDataDocDT,$aTableAddUpdate);
            
            $aDataConfigViewAdd = array(
                'tTXODocType'       => $tTXODocType,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'nOptScanSku'       => $nOptScanSku,
                'tUserBchCode'      => $tBchCode,
                'tUserMchCode'      => $tMchCode,
                'tUserShpCode'      => $tShpCode,
                'aDataDocHD'        => $aDataDocHD,
                'aDataDocHDRef'     => $aDataDocHDRef,
                'aAlwEvent'         => $aAlwEvent,
            );
            $tTXOViewPageAdd    = $this->load->view('document/transferout/wTransferoutAdd',$aDataConfigViewAdd,true);
            $aReturnData        = array(
                'tTXOViewPageAdd'   => $tTXOViewPageAdd,
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

    // Functionality : Function Edit Event Document
    // Parameters : Ajax and Function Parameter
    // Creator : 28/05/2018 wasin
    // Return : Object Status Event Edit
    // Return Type : object
    public function FSoCTXOEditEventDoc(){
        try{
            $aDataDocument      = $this->input->post();
            $tTXODocType        = $aDataDocument['ohdTXODocType'];
            $tTXOAutoGenCode    = (isset($aDataDocument['ocbTXOStaAutoGenCode']))? 1: 0;
            $tTXODocNo          = (isset($aDataDocument['oetTXODocNo']))? $aDataDocument['oetTXODocNo']: '';
            $tTXODocDate        = $aDataDocument['oetTXODocDate']." ".$aDataDocument['oetTXODocTime'];
            $tTXOStaDocAct      = (isset($aDataDocument['ocbTXOStaDocAct']))? 1: 0;
            $tTXOVATInOrEx      = $aDataDocument['ostTXOVATInOrEx'];
            $tTableNameMain     = $this->FStCTXOSwitchDatabase($tTXODocType);
            // แยกใบเอกสาร 
            switch($tTXODocType){
                case 'WAH':
                    $aDataMaster        = array(
                        'FTBchCode'         => $aDataDocument['oetTXOBchCode'],
                        'FNXthDocType'      => 4,
                        'FTXthRsnType'      => 1,
                        'FTShpCode'         => '',
                        'FDXthDocDate'      => $tTXODocDate,
                        'FTXthMerCode'      => $aDataDocument['oetTXOMchCode'],
                        'FTXthShopFrm'      => $aDataDocument['oetTXOShpCodeFrom'],
                        'FTXthShopTo'       => $aDataDocument['oetTXOShpCodeTo'],
                        'FTXthVATInOrEx'    => $tTXOVATInOrEx,
                        'FTDptCode'         => $aDataDocument['ohdTXODptCode'],
                        'FTXthWhFrm'        => $aDataDocument['oetTXOWahCodeFrom'],
                        'FTXthWhTo'         => $aDataDocument['oetTXOWahCodeTo'],
                        'FTUsrCode'         => $aDataDocument['ohdTXOUsrCode'],
                        'FTXthRefExt'       => $aDataDocument['oetTXORefExt'],
                        'FDXthRefExtDate'   => $aDataDocument['oetTXORefExtDate'],
                        'FTXthRefInt'       => $aDataDocument['oetTXORefInt'],
                        'FDXthRefIntDate'   => $aDataDocument['oetTXORefIntDate'],
                        'FNXthDocPrint'     => 0,
                        'FCXthTotal'        => 0,
                        'FCXthVat'          => 0,
                        'FCXthVatable'      => 0,
                        'FTXthRmk'          => $this->input->post('otaTXORmk'),
                        'FTXthStaDoc'       => 1,
                        'FTXthStaApv'       => '',
                        'FTXthStaPrcStk'    => '',
                        'FNXthStaDocAct'    => $tTXOStaDocAct,
                        'FNXthStaRef'       => $aDataDocument['ostTXOStaRef'],
                    );

                    $aTableAddUpdate    = array(
                        'tTableHD'      => $tTableNameMain.'HD',
                        'tTableDT'      => $tTableNameMain.'DT',
                        'tTableHDRef'   => $tTableNameMain.'HDRef',
                        'tTableStaGen'  => 4
                    );

                    $aDataHDRef = array(
                        'FTXthCtrName'          => $aDataDocument['oetTXOCtrName'],
                        'FDXthTnfDate'          => $aDataDocument['oetTXOTnfDate'],
                        'FTXthRefTnfID'         => $aDataDocument['oetTXORefTnfID'],
                        'FTXthRefVehID'         => $aDataDocument['oetTXORefVehID'],
                        'FTXthQtyAndTypeUnit'   => $aDataDocument['oetTXOQtyAndTypeUnit'],
                        'FNXthShipAdd'          => $aDataDocument['ohdTXOShipAdd'],
                        'FTViaCode'             => $aDataDocument['oetTXOViaCode']
                    );

                    $aDataWhere = array(
                        'FTXthDocNo'        => $tTXODocNo,
                        'FTBchCode'         => $aDataDocument['oetTXOBchCode'],
                        'FDLastUpdOn'       => date('Y-m-d'),
                        'FDCreateOn'        => date('Y-m-d'),
                        'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                        'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                        'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                        'FTXthVATInOrEx'    => $tTXODocDate,
                        'FTTXODocType'      => $tTXODocType
                    );
                break;
                case 'BCH':
                    
                break;
            }

            $this->db->trans_begin();
            // Add Update Document HD
            $aStaInsHD      = $this->mTransferout->FSaMTXOAddUpdateHD($aDataMaster,$aDataWhere,$aTableAddUpdate);
            // Add Update Document HD Ref
            $aStaInsHDRef   = $this->mTransferout->FSaMTXOAddUpdateHDRef($aDataHDRef,$aDataWhere,$aTableAddUpdate);
            // Update Doc No Into Doc Temp
            $aStaUpdDocNoInDT   = $this->mTransferout->FSaMTXOAddUpdateDocNoInDocTemp($aDataWhere,$aTableAddUpdate);
            // Move Doc Tmp To DT
            $this->FSxCTXOAddTmpToDT($aDataWhere,$aTableAddUpdate);
            // Sum DT Into HD
            $this->FSxCTXOSumDTIntoHD($aDataWhere,$aTableAddUpdate);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent'     => '900',
                    'tStaMessg'     => "Error Unsucess Add Document."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataWhere['FTXthDocNo'],
                    'nStaReturn'    => '1',
                    'tStaMessg'		=> 'Success Add Document.'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Cheack Shp Via Code From Appove
    // Parameters : Ajax and Function Parameter
    // Creator : 28/05/2018 wasin
    // Return : Object Status Event Edit
    // Return Type : object
    public function FSoCTXOCheckViaCodeForApv(){
        $tTXODocType    = $this->input->post('ptTXODocType');
        $tTXODocNo      = $this->input->post('ptTXODocNo');
        $aDataWhere     = array(
            'tTXOTblHDRef'  => $this->FStCTXOSwitchDatabase($tTXODocType).'HDRef',
            'tTXODocNo'     => $tTXODocNo
        );
        $aResultChkVia  = $this->mTransferout->FSaMTXOCheckViaCodeForApv($aDataWhere);
        if($aResultChkVia['rtCode'] == '1'){
            if($aResultChkVia["raItems"]['FTViaCode'] != ""){
                $aReturnData    = array(
                    'staPrc'        => true,
                    'staHasVia'     => true,
                    'tViaCode'      => $aResultChkVia["raItems"]['FTViaCode'],
                );
            }else{
                $aReturnData    = array(
                    'staPrc'        => true,
                    'staHasVia'     => false,
                    "tViaCode"      => "",
                );
            }
        }else{
            $aReturnData    = array(
                'staPrc'    => false,
                'staHasVia' => false,
                "tViaCode"  => "",
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Appove Document
    // Parameters : Ajax and Function Parameter
    // Creator : 29/05/2018 wasin
    // Return : Object Status Event Edit
    // Return Type : object
    public function FSoCTXOApproveDocument(){
        $tTXODocType    = $this->input->post('ptTXODocType');
        $tTXODocNo      = $this->input->post('ptTXODocNo');
        $tTableNameDoc  = $this->FStCTXOSwitchDatabase($tTXODocType);
        $tTXOUsrBchCode = FCNtGetBchInComp();
        $aDataTableAppove   = array(
            'tTableHD'      => $tTableNameDoc.'HD',
            'tTableHDRef'   => $tTableNameDoc.'HDRef',
            'tTableDT'      => $tTableNameDoc.'DT',
        );
        
        // Switch Document Type Data Update Status Appove
        switch($tTXODocType){
            case 'WAH':
                // Data Update Status Document
                $aDataUpdate    = array(
                    'aDataWhereDoc' => array(
                        'FTXthDocNo'    => $tTXODocNo,
                    ),
                    'aDataUpdStaDoc'    => array(
                        'FTXthStaPrcStk'    => 2,
                        'FTXthStaApv'       => 2,
                        'FTXthApvCode'      => $this->session->userdata('tSesUsername')
                    )
                );
                // Data MQ 
                $tTXOMqName     = "TNFWAREHOSEOUT";
                $tTXOMqTypeDoc  = '4';
            break;
            case 'BCH':
                
            break;
        }

        $aStaDocApv     = $this->mTransferout->FSaMTXOApproveDocument($aDataUpdate,$aDataTableAppove);
        $this->db->trans_begin();
        try{
            $aMQParams  = [
                "queueName" => $tTXOMqName,
                    "params" => [
                        "ptBchCode"     => $tTXOUsrBchCode,
                        "ptDocNo"       => $tTXODocNo,
                        "ptDocType"     => $tTXOMqTypeDoc,
                        "ptUser"        => $this->session->userdata('tSesUsername'),
                        "ptConnStr"     => DB_CONNECT,
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
























    

}