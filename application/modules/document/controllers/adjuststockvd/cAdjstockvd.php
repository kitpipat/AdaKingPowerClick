<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAdjstockvd extends MX_Controller {
    
	public function __construct() {
            parent::__construct ();
            $this->load->helper("file");
            $this->load->model('company/company/mCompany');
            $this->load->model('company/shop/mShop');
            $this->load->model('payment/rate/mRate');
            $this->load->model('document/adjuststockvd/mAdjuststockvd');
            date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nBrowseType,$tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aAlwEvent']         = FCNaHCheckAlwFunc('ADJSTKVD/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('ADJSTKVD/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow(); 
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave(); 
        $this->load->view('document/adjuststockvd/wAdjstockvd',$aData);
    }

    //Page List
    public function FSxCADJVDFormSearchList(){
        $this->mAdjuststockvd->FSnMADJVDDeleteItemAllInTempBySession();
        $this->load->view('document/adjuststockvd/wAdjstockvdFormSearchList');
    }

    //Page Table
    public function FSxCADJVDDataTable(){
        $oAdvanceSearch     = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');

        //Controle Event
        $aAlwEvent          = FCNaHCheckAlwFunc('TWXVD/0/0'); 

        //Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
        if($nPage == '' || $nPage == null){
            $nPage = 1;
        }else{
            $nPage = $this->input->post('nPageCurrent');
        }

        //Lang ภาษา
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'oAdvanceSearch'    => $oAdvanceSearch
        );

        $aResList   = $this->mAdjuststockvd->FSaMADJVDList($aData);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'nOptDecimalShow'=> $nOptDecimalShow
        );

        $this->load->view('document/adjuststockvd/wAdjstockvdDataTable',$aGenTable);
    }

    //เข้าหน้าเพิ่มข้อมูล
    public function FSxCADJVDAddPage(){

        $aAlwEvent = FCNaHCheckAlwFunc('ADJSTKVD/0/0');

        //ลบข้อมูลทุกครั้ง
        $this->mAdjuststockvd->FSxMClearPdtInTmp();

        //Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        //Get Option Scan SKU
        $nOptDocSave    = FCNnHGetOptionDocSave(); 

        //Lang ภาษา
        $nLangEdit      = $this->session->userdata("tLangID");
        $aDataWhere  = array(
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  
        if($aResList['rtCode'] == '1'){
            $tCompCode      = $aResList['raItems']['rtCmpCode'];
        }else{
            $tCompCode      = "";
        }

        $tUsrLogin  = $this->session->userdata('tSesUsername');
        $tDptCode   = FCNnDOCGetDepartmentByUser($tUsrLogin); 

        $aDataAdd = array(
            'aResult'           =>  array('rtCode'=>'99'),
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptDocSave'       =>  $nOptDocSave,
            'aAlwEvent'         =>  $aAlwEvent,
            'tDptCode'          =>  $tDptCode,
            'tCompCode'         =>  $tCompCode
        );
        $this->load->view('document/adjuststockvd/wAdjstockvdAdd',$aDataAdd);
    }

    //Table Temp (โครง)
    public function FSxCADJVDPdtDtLoadToTem(){
        $tRoute     = $this->input->post("tRoute");
        $tEvent     = $this->input->post("tEvent");

        if($tEvent == 'fisrtload'){
            return;
        }

        if($tRoute ==  "ADJSTKVDEventAdd" || $tEvent == 'ProcessInPageEdit'){
            if($tRoute == "ADJSTKVDEventAdd"){
                $tXthDocNo = '';
            }else{
                $tXthDocNo = $this->input->post("tXthDocNo");
            }

            $aInfoWhereDel = array(
                "tBchCode"      => $this->input->post("tBchCode"),
                "tXthDocNo"     => $tXthDocNo,
                "FTXthDocKey"   => "TCNTPdtAdjStkHD" 
            );
            $this->mAdjuststockvd->FSxMDeleteDoctemForNewEvent($aInfoWhereDel);
        }
        
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aInfoWhere = array(
            "tBchCode"   =>  $this->input->post("tBchCode"),
            "tShpCode"   =>  $this->input->post("tShpCodeStart"),
            "tPosCode"   =>  $this->input->post("tPosCodeStart"),
            "tWahCode"   =>  $this->input->post("tWahCodeStart"),
            "nLangID"    =>  $nLangEdit,
            "FTXthDocNo" =>  $this->input->post("tXthDocNo")
        );
        
        if($tRoute == "ADJSTKVDEventAdd" || $tEvent == 'ProcessInPageEdit'){

            $aDataInfor = $this->mAdjuststockvd->FSaMADJVDGetPdtLayoutToTem($aInfoWhere);
            $aData      = $aDataInfor;

            if($tRoute == "ADJSTKVDEventAdd"){
                $tXthDocNo  = '';
            }else{
                $tXthDocNo  = $this->input->post("tXthDocNo");
            }

            if($aData){
                for($nI=0;$nI<FCNnHSizeOf($aData);$nI++){
                    $aInforInsert = array(
                        "FTBchCode"                 =>  $this->input->post("tBchCode"),
                        "FTShpCode"                 =>  $aData[$nI]["FTShpCode"],
                        "FTXthDocNo"                =>  $tXthDocNo,
                        "FNXtdSeqNo"                =>  ($nI+1),
                        "FNLayRowForADJSTKVD"       =>  $aData[$nI]["FNLayRow"],
                        "FNLayColForADJSTKVD"       =>  $aData[$nI]["FNLayCol"],
                        "FCLayColQtyMaxForADJSTKVD" =>  ($aData[$nI]["FCLayColQtyMax"] == '') ? 0.00 : $aData[$nI]["FCLayColQtyMax"],
                        "FTPdtCode"                 =>  $aData[$nI]["FTPdtCode"],
                        "FCStkQty"                  =>  ($aData[$nI]["FCStkQty"] == '') ? 0.00 : $aData[$nI]["FCStkQty"],
                        "FTXthDocKey"               =>  "TCNTPdtAdjStkHD",
                        "FTXtdPdtName"              =>  $aData[$nI]["FTPdtName"],
                        "FCAjdWahB4Adj"             =>  0,
                        "FCUserInPutForADJSTKVD"    =>  0, /*$aData[$nI]["FCStkQty"]*/
                        "FNCabSeq"                  =>  $aData[$nI]["FNCabSeq"],
                        "FCDateTimeInputForADJSTKVD"=>  date('Y-m-d H:i:s')
                    );
                    $this->mAdjuststockvd->FSxMADJVDUpdateDocTmpPdtFromDT($aInforInsert);
                }
            }
        }
    }

    //DataTable Temp 
    public function FSvCADJVDPdtAdvTblLoadData(){
        $nPage          = $this->input->post('nPageCurrent');
        $tRoute         = $this->input->post('tRoute');
        if($tRoute == 'ADJSTKVDEventAdd'){
            $tDocumentNumber = '';
        }else{
            $tDocumentNumber = $this->input->post("tXthDocNo");
        }

        $aInfoWhere     = array(
            "tBchCode"      =>  $this->input->post("tBchCode"),
            "tXthDocNo"     =>  $tDocumentNumber,
            "FTXthDocKey"   =>  "TCNTPdtAdjStkHD",
            "nPage"         =>  $nPage,
            "nRow"          =>  99999
        );
        $aDataInfor       = $this->mAdjuststockvd->FSaMADJVDGetPdtLayoutFRomTem($aInfoWhere);
        $aInfor = array(
            "aDataList"         => $aDataInfor,
            "nPage"             => $nPage
        );
        $this->load->view('document/adjuststockvd/advancetable/wAdjVDTableTmp',$aInfor);
    }

    //แก้ไขจำนวน การตรวจนับ
    public function FSvCADJVDEditPdtIntoTableDT(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $nQty               = $this->input->post('nQty');
        $nSeqNo             = $this->input->post('nSeqNo');
        $tPdtCode           = $this->input->post('tPdtCode');
        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $tPosCode           = $this->input->post('tPosCode');
        $tWahCode           = $this->input->post('tWahCode');
        $nCabSeq            = $this->input->post('nCabSeq');
        $tRoute             = $this->input->post('tRoute');

        if($tRoute == 'ADJSTKVDEventAdd'){
            $tDocumentNumber = '';
        }else{
            $tDocumentNumber = $this->input->post("tDocumentNumber");
        }

        $aDataUpdateDT = array(
            'FCUserInPutForADJSTKVD'        => $nQty,
            'FCDateTimeInputForADJSTKVD'    => date("Y-m-d H:i:s")
        );

        $aDataWhere = array(
            'FTXthDocNo'        => $tDocumentNumber,
            'FNXtdSeqNo'        => $nSeqNo,
            'FTXthDocKey'       => 'TCNTPdtAdjStkHD',
            'FTPdtCode'         => $tPdtCode ,
            'FTBchCode'         => $tBchCode ,
            'FTShpCode'         => $tShpCode ,
            'FNCabSeqForTWXVD'  => $nCabSeq
        );
        $this->mAdjuststockvd->FSnMADJVDUpdateInlineDTTemp($aDataUpdateDT,$aDataWhere);
    }

    //กดบันทึกต้องเช็คก่อนว่า มี Temp ไหม
    public function FSbCADJVDheckHaveProductInTemp(){
        $tRoute = $this->input->post('tRoute');
        if($tRoute == 'ADJSTKVDEventAdd'){
            $tDocumentNumber = '';
        }else{
            $tDocumentNumber = $this->input->post("tDocNo");
        }

        $nNumPdt = $this->mAdjuststockvd->FSnMADJVDCheckPdtTemp($tDocumentNumber);
        if($nNumPdt>0){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    //การบันทึกข้อมูลลงฐานข้อมูล HD
    public function FSaCADJVDAddEvent(){
        try{
            $dXthDocDate = $this->input->post('oetXthDocDate')." ".$this->input->post('oetXthDocTime');
            $aDataDocument = $this->input->post();

            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbADJVDAutoGenCode'),
                'FTBchCode'             => $this->input->post('oetBchCode'),  
                'FTAjhDocNo'            => $this->input->post('oetXthDocNo'),
                'FDAjhDocDate'          => $dXthDocDate,
                'FTAjhBchTo'            => $this->input->post('oetBchCode'),
                'FTAjhMerchantTo'       => $this->input->post('oetMchCode'),
                'FTAjhShopTo'           => $this->input->post('oetShpCodeStart'),
                'FTAjhPosTo'            => $this->input->post('oetPosCodeStart'),
                'FTAjhWhTo'             => $this->input->post('ohdWahCodeStart'),
                'FTAjhPlcCode'          => "",
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTUsrCode'             => $this->input->post('oetUsrCode'),
                'FTRsnCode'             => $this->input->post('oetASTRsnCode'),
                'FTAjhRmk'              => $this->input->post('oetASTRsnCode'),
                'FNAjhDocPrint'         => 0,
                'FTAjhApvSeqChk'        => '3',
                'FTAjhApvCode'          => '',
                'FTAjhStaApv'           => '',  
                'FTAjhStaPrcStk'        => '',  
                'FTAjhStaDoc'           => 1,   
                'FNAjhStaDocAct'        => !empty($aDataDocument['ocbASTStaDocAct']) ? $aDataDocument['ocbASTStaDocAct'] : 0,
                'FTAjhDocRef'           => '', 
                'FTAjhStaDelMQ'         => '', 
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername')
            );  

            if($aDataMaster['tIsAutoGenCode'] == '1'){ 
                // Auto Gen
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtAdjStkHD',                           
                    "tDocType"    => '3',                                          
                    "tBchCode"    => $this->input->post('oetBchCode'),                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTAjhDocNo']  = $aAutogen[0]["FTXxhDocNo"];
            }else{
                //เช็คว่ารหัสซ้ำกับในระบบไหม
                $tResult = $this->mAdjuststockvd->FSaMADJVDCheckDocumentNumber($this->input->post('oetXthDocNo'));
                if($tResult['rtCode'] == 1){
                    $aReturn = array(
                        'nStaEvent'    => '80',
                        'tStaMessg'    => "เลขที่เอกสารซ้ำกรุณาลองใหม่อีกครั้ง"
                    );
                    echo json_encode($aReturn);
                }
            }   
            
            //Lang ภาษา
            $nLangEdit      = $this->session->userdata("tLangID");
            $aDataWhere     = array(
                'FTXthDocNo'    =>  $aDataMaster['FTAjhDocNo'],
                'FTBchCode'     =>  $this->input->post('oetBchCode'),
                'FTXtdShpTo'    =>  $this->input->post('oetShpCodeStart'),
                'FTXthDocKey'   =>  'TCNTPdtAdjStkHD',
                'nLangID'       =>  $nLangEdit
            );

            $this->db->trans_begin();
            
            $this->mAdjuststockvd->FSaMADJVDAddUpdateHD($aDataMaster);
            $this->mAdjuststockvd->FSaMADJVDAddUpdateDocNoInDocTemp($aDataWhere);
            $this->mAdjuststockvd->FSaMADJVDInsertTmpToDT($aDataWhere);
            
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
 
    //เข้าหน้าแก้ไข
    public function FSvCADJVDEditPage(){
        $nLangEdit          = $this->session->userdata("tLangID");
        $tUsrLogin          = $this->session->userdata('tSesUsername');
        $ptDocumentNumber   = $this->input->post('ptDocumentNumber');
        $aAlwEvent          = FCNaHCheckAlwFunc('ADJSTKVD/0/0');

        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        //Get Option Scan SKU
        $nOptDocSave    = FCNnHGetOptionDocSave(); 

        //Data Master
        $aDataWhere  = array(
            'FTXthDocNo'    => $ptDocumentNumber,
            'FNLngID'       => $nLangEdit
        );

        //Get Data
        $aResult    = $this->mAdjuststockvd->FSaMADJVDGetHD($aDataWhere);
        $aInfoWhere = array(
            "FTXthDocNo" =>  $ptDocumentNumber,
            "tBchCode"   =>  $aResult["raItems"]["FTBchCode"],
            "tShpCode"   =>  $aResult["raItems"]["FTXthShopFrm"],
            "tPosCode"   =>  $aResult["raItems"]["FTXthPosFrm"],
            "tWahCode"   =>  $aResult["raItems"]["FTXthWhFrm"],
            "nLangID"    =>  $nLangEdit
        );

        $aDeleteB4 = array(
            "tBchCode"      => $aResult["raItems"]["FTBchCode"],
            "tXthDocNo"     => '',
            "FTXthDocKey"   => "TCNTPdtAdjStkHD"
        );
        $this->mAdjuststockvd->FSxMDeleteDoctemForNewEvent($aDeleteB4);

        //ย้ายจาก DT เข้า Temp
        $aDataInfor     = $this->mAdjuststockvd->FSaMADJVDGetDT($aInfoWhere);
        for($nI=0;$nI<FCNnHSizeOf($aDataInfor['raItems']);$nI++){
            $aInforInsert = array(
                "FTBchCode"                 =>  $aResult["raItems"]["FTBchCode"],
                "FTShpCode"                 =>  $aResult["raItems"]["FTXthShopFrm"],
                "FTXthDocNo"                =>  $ptDocumentNumber,
                "FNXtdSeqNo"                =>  $nI,
                "FNLayRowForADJSTKVD"       =>  $aDataInfor['raItems'][$nI]["FNAjdLayRow"],
                "FNLayColForADJSTKVD"       =>  $aDataInfor['raItems'][$nI]["FNAjdLayCol"],
                "FCLayColQtyMaxForADJSTKVD" =>  ($aDataInfor['raItems'][$nI]["FCLayColQtyMax"] == '' ) ? '0' : $aDataInfor['raItems'][$nI]["FCLayColQtyMax"],
                "FTPdtCode"                 =>  $aDataInfor['raItems'][$nI]["FTPdtCode"],
                "FCStkQty"                  =>  ($aDataInfor['raItems'][$nI]["FCAjdQtyAllDiff"] == '' ) ? '0' : $aDataInfor['raItems'][$nI]["FCAjdQtyAllDiff"],
                "FCAjdWahB4Adj"             =>  ($aDataInfor['raItems'][$nI]["FCAjdWahB4Adj"] == '' ) ? '0' : $aDataInfor['raItems'][$nI]["FCAjdWahB4Adj"], 
                "FTXthDocKey"               =>  "TCNTPdtAdjStkHD",
                "FTXtdPdtName"              =>  $aDataInfor['raItems'][$nI]["FTPdtName"],
                "FCUserInPutForADJSTKVD"    =>  ($aDataInfor['raItems'][$nI]["FCAjdUnitQty"] == '' ) ? '0' : $aDataInfor['raItems'][$nI]["FCAjdUnitQty"], 
                "FNCabSeq"                  =>  $aDataInfor['raItems'][$nI]["FNCabSeq"],
                "FCDateTimeInputForADJSTKVD"=>  $aDataInfor['raItems'][$nI]["FDAjdDateTime"]
            );
            $this->mAdjuststockvd->FSxMADJVDUpdateDocTmpPdtFromDT($aInforInsert);
        }

        $aDataEdit = array(
            'aResult'           =>  $aResult,
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptDocSave'       =>  $nOptDocSave,
            'aAlwEvent'         =>  $aAlwEvent,
            'tDptCode'          =>  '',
            'tCompCode'         =>  ''
        );
        $this->load->view('document/adjuststockvd/wAdjstockvdAdd',$aDataEdit);
    }

    //แก้ไขข้อมูล
    public function FSaCADJVDEditEvent(){
        try{
            $dXthDocDate = $this->input->post('oetXthDocDate')." ".$this->input->post('oetXthDocTime');
            $aDataDocument = $this->input->post();

            $aDataMaster = array(
                'FTBchCode'             => $this->input->post('ohdBchCodeOld'),  
                'FTAjhDocNo'            => $this->input->post('oetXthDocNo'),
                'FDAjhDocDate'          => $dXthDocDate,
                'FTAjhBchTo'            => $this->input->post('oetBchCode'),
                'FTAjhMerchantTo'       => $this->input->post('oetMchCode'),
                'FTAjhShopTo'           => $this->input->post('oetShpCodeStart'),
                'FTAjhPosTo'            => $this->input->post('oetPosCodeStart'),
                'FTAjhWhTo'             => $this->input->post('ohdWahCodeStart'),
                'FTAjhPlcCode'          => "",
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTUsrCode'             => $this->input->post('oetUsrCode'),
                'FTRsnCode'             => $this->input->post('oetASTRsnCode'),
                'FTAjhRmk'              => $this->input->post('oetASTRsnCode'),
                'FNAjhDocPrint'         => 0,
                'FTAjhApvSeqChk'        => '3',
                'FTAjhApvCode'          => '',
                'FTAjhStaApv'           => '',  
                'FTAjhStaPrcStk'        => '',  
                'FTAjhStaDoc'           => 1,   
                'FNAjhStaDocAct'        => !empty($aDataDocument['ocbASTStaDocAct']) ? $aDataDocument['ocbASTStaDocAct'] : 0,
                'FTAjhDocRef'           => '', 
                'FTAjhStaDelMQ'         => '', 
                'FDLastUpdOn'           => date('Y-m-d'),
                'FDCreateOn'            => date('Y-m-d'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername')
            );

            //Lang ภาษา
            $nLangEdit      = $this->session->userdata("tLangID");
            $aDataWhere = array(
                'FTXthDocNo'    => $aDataMaster['FTAjhDocNo'],
                'FTBchCode'     => $this->input->post('ohdBchCodeOld'),
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                'FTXtdShpTo'    => $this->input->post('oetShpCodeStart'),
                'nLangID'       => $nLangEdit
            );

            $this->db->trans_begin();
            $this->mAdjuststockvd->FSaMADJVDAddUpdateHD($aDataMaster);
            $this->mAdjuststockvd->FSaMADJVDAddUpdateDocNoInDocTemp($aDataWhere);
            $this->mAdjuststockvd->FSaMADJVDInsertTmpToDT($aDataWhere);
            
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //ยกเลิกเอกสาร
    public function FSvCADJVDCancel(){
        $tDocumentNumber = $this->input->post('tDocumentNumber');
        $aDataUpdate = array(
            'FTAjhDocNo' => $tDocumentNumber,
        );
        $aStaCancel = $this->mAdjuststockvd->FSvMADJCancel($aDataUpdate); 
        if($aStaCancel['rtCode'] == 1){
            $aApv = array(
                'nStaCallBack'  => 1,
                'tStaMessg'     => "Cancel done.",
            );
        }else{
            $aApv = array(
                'nStaCallBack'  => 2,
                'tStaMessg'     => "Not Cancel.",
            );
        }
        echo json_encode($aApv);
    }

    //ลบช้อมูล
    public function FSaCADJVDDeleteEvent(){
        $tIDCode        = $this->input->post('tIDCode');
        $aDataMaster    = array(
            'FTAjhDocNo' => $tIDCode
        );

        $aResDel    = $this->mAdjuststockvd->FSnMADJVDDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    //อนุมัติเอกสาร
    public function FSvCADJVDApprove(){
        $tDocumentNumber  = $this->input->post('tDocumentNumber');
        $aDataUpdate = array(
            'FTAjhDocNo'    => $tDocumentNumber,
            'FTXthApvCode'  => $this->session->userdata('tSesUsername')
        );
        $this->mAdjuststockvd->FSvMADJVDApprove($aDataUpdate); 


        $nLangEdit   = $this->session->userdata("tLangID");
        $aDataWhere  = array(
            'FTXthDocNo'    => $tDocumentNumber,
            'FNLngID'       => $nLangEdit
        );
        $aResult    = $this->mAdjuststockvd->FSaMADJVDGetHD($aDataWhere);
        $aInfoWhere = array(
            'FTXthDocNo'    =>  $tDocumentNumber,
            "tBchCode"      =>  $aResult["raItems"]["FTBchCode"],
            "tShpCode"      =>  $aResult["raItems"]["FTXthShopFrm"],
            "tPosCode"      =>  $aResult["raItems"]["FTXthPosFrm"],
            "tWahCode"      =>  $aResult["raItems"]["FTXthWhFrm"],
            "nLangID"       =>  $nLangEdit
        );
        $aDataInfor = $this->mAdjuststockvd->FSaMADJVDGetPdtLayoutToTem($aInfoWhere);
        $this->mAdjuststockvd->FSxMADJVDUpdateBalToDT($aDataInfor,$aInfoWhere); 

        try{
            $aMQParams = [
                "queueName" => "ADJUSTSTOCK",
                "params" => [
                    "ptBchCode"     => $aResult["raItems"]["FTBchCode"],
                    "ptDocNo"       => $tDocumentNumber,
                    "ptDocType"     => '11',
                    "ptUser"        => $this->session->userdata('tSesUsername')
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
            echo json_encode($aReturn);
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


    //ลบสินค้าใน Temp
    public function FSxCADJVDDeletePDTInTemp(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $nSeq               = $this->input->post('nSeq');
        $nPdtCode           = $this->input->post('nPdtCode');
        $nCabinet           = $this->input->post('nCabinet');

        $aDataWhere = array(
            'FTXthDocNo'        => $tDocumentNumber,
            'FNXtdSeqNo'        => $nSeq,
            'FTXthDocKey'       => 'TCNTPdtAdjStkHD',
            'FTPdtCode'         => $nPdtCode ,
            'FTBchCode'         => $tBchCode ,
            'FTShpCode'         => $tShpCode ,
            'FNCabSeqForTWXVD'  => $nCabinet
        );
        $this->mAdjuststockvd->FSnMADJVDDeleteInlineDTTemp($aDataWhere);
    }

     //ลบสินค้าแบบ Multi ใน Temp
    public function FSxCADJVDDeleteMultiPDTInTemp(){
        try{
            $this->db->trans_begin();

            $aDataWhere = array(
                'FTXthDocNo'        => $this->input->post('tDocNo'),
                'FNXtdSeqNo'        => $this->input->post('paDataSeqNo'),
                'FTXthDocKey'       => 'TCNTPdtAdjStkHD',
                'FTPdtCode'         => $this->input->post('paDataPdtCode'),
                'FTBchCode'         => $this->input->post('tBchCode'),
                'FTShpCode'         => $this->input->post('aDataShpCode'),
                'FNCabSeqForTWXVD'  => $this->input->post('paDataCabinet'),
            );

            $this->mAdjuststockvd->FSnMADJVDDeleteMultiDTTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success Delete Product'
                );
            }
        }catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //กดเปลี่ยนข้อมูล ต้องลบใน temp ออก
    public function FSxCADJVDDeleteItemAllInTemp(){
        $tBchCode       = $this->input->post('tBchCode');
        $tDocNo         = $this->input->post('tDocNo');

        $aDataWhere = array(
            'FTXthDocNo'        => $tDocNo,
            'FTBchCode'         => $tBchCode,
            'FTXthDocKey'       => 'TCNTPdtAdjStkHD'
        );
        $this->mAdjuststockvd->FSnMADJVDDeleteItemAllInTemp($aDataWhere);
    }
}

