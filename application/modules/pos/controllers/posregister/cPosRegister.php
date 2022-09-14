<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPosRegister extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('pos/posregister/mPosRegister');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPosRegBrowseType,$tPosRegBrowseOption){

        $aDataConfigView    = [
            'nPosRegBrowseType'     => $nPosRegBrowseType,
            'tPosRegBrowseOption'   => $tPosRegBrowseOption,
            'aAlwEvent'             => FCNaHCheckAlwFunc('posreg/0/0'),
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('posreg/0/0'), 
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()
        ];

        $this->load->view('pos/posregister/wPosRegister',$aDataConfigView);

    }

    // Function : Get Page List PosRegister
    // Create By Witsarut 14/07/2020
    public function FSvPRGPageList(){
        $aOption = $this->mPosRegister->FSaMPRGGetStaApp();
        $aReturn = array(
            'aOption' => $aOption
        );

        $this->load->view('pos/posregister/wPosRegisterList', $aReturn);
    }

    // Function :  Get Data Table
    // Create By Witsarut 14/07/2020
    public function FSvPRGGetTable(){
        try{
            $aAlwEvent  = FCNaHCheckAlwFunc('posreg/0/0'); 
            $tStaApv    = $this->input->post('tStaApv');
            $tSearchAll = $this->input->post('tSearch');
            $nLangEdit  = $this->session->userdata("tLangEdit");

            // เพิ่มระดับผู้ใช้ 10/08/2020 Witsarut
            $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
            $tUsrBchCode     = $this->session->userdata("tSesUsrBchCodeMulti"); 
        
            $aData  = array(
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tStaApv'       => $tStaApv,
                'tStaUsrLevel'  => $tStaUsrLevel,
                'tUsrBchCode'   => $tUsrBchCode
            );

            $aResultDatatable =  $this->mPosRegister->FSaMPRGDataTable($aData);

            $aGenTable = array(
                'aAlwEvent'    => $aAlwEvent,
                'aResultDatatable'  => $aResultDatatable
            );

            $this->load->view('pos/posregister/wPosRegisterDataTable', $aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Add Data  Add/Edit  
    //Creator : 15/07/2020 witsarut (Bell)
    //Return : View
    //Return Type : View
    public function FSvPRGSaveData(){
        try{
            // loop Data จาก Ajax
            // ***********************************************************************************
            $tBchCode = $this->input->post('aDataBchCode'); //รหัสสาขา
            $tPosCode = $this->input->post('aDataPosCode');  //รหัสเครื่องจุดขาย
            $tPrgDate = $this->input->post('aDataohdPrgDate'); //วันที่ลงทะเบียน
            $tMacAddr = $this->input->post('aDataMacAddr'); //รหัส Mac Addr ของเครื่องจุดขาย (POS)
            $tPrgExp  = $this->input->post('aDataPrgExp'); //วันที่ลงทะเบียนหมดอายุ
            $tEncPassword = $this->input->post('aDataEncPassword');

            $tPosRegDate  = $this->input->post('tPosRegDate');
            // ***********************************************************************************

            $aDataInsert  = array(
                'FDPrgExpire'   => $tPosRegDate,
                'FTPrgStaApv'   => '1',
                'FTPrgUsrApv'   => $this->session->userdata('tSesUsername'), //รหัสผู้อนุมัติ
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'), //วันที่ปรับปรุงรายการล่าสุด
                'FTCreateBy'    => $this->session->userdata('tSesUsername') //ผู้สร้างรายการ
            );

            // Insert loop MacAddr ตาราง TPSTPosReg
            if(isset($tMacAddr) != empty($tMacAddr)){
                for($i=0; $i < FCNnHSizeOf($tMacAddr); $i++){
                    if($tMacAddr[$i] == '' ){
                        continue;
                    }
                    $this->mPosRegister->FSaMPRGAddUpdateMaster($aDataInsert, $tMacAddr[$i]['ohdMacAddr'], $tEncPassword[$i]['tEncPassword'], $tBchCode[$i]['ohdBchCode'], $tPosCode[$i]['ohdPosCode'], $tPrgDate[$i]['ohdPrgDate']); 
                }
            }

            //Insert loop master ตาราง TCNMPOS
            if(isset($tPosCode) != empty($tPosCode)){
                for($n=0; $n < FCNnHSizeOf($tPosCode); $n++){
                    if($tPosCode[$n] == ''){
                        continue;
                    } 
                    $this->mPosRegister->FSaMPRGAddUpdateMasterPOS($aDataInsert, $tPosCode[$n]['ohdPosCode'], $tEncPassword[$n]['tEncPassword'], $tBchCode[$n]['ohdBchCode']);
                }
            }

        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Cancel Data  Add/Edit  
    //Creator : 15/07/2020 witsarut (Bell)
    //Return : View
    //Return Type : View
    public function FSvPRGCancelData(){
       try{
          // loop Data จาก Ajax
          // ***********************************************************************************
                $tCancelBchCode   = $this->input->post('aDataCancelBchCode');
                $tCancelPosCode   = $this->input->post('aDataCancelPosCode');
                $tCancelMacAddr   = $this->input->post('aDataCancelMacAddr');
                $tCancelPrgDate   = $this->input->post('aDataCancelPrgDate');
                $tCancelEncPassword =  $this->input->post('aDataCancelEncPassword');
          // ***********************************************************************************

            $aDataCancelUpdate =  array(
                'FTPrgStaApv'   => '3',
                'FTPrgUsrApv'   => $this->session->userdata('tSesUsername'), //รหัสผู้อนุมัติ
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'), //วันที่ปรับปรุงรายการล่าสุด
                'FTCreateBy'    => $this->session->userdata('tSesUsername') //ผู้สร้างรายการ
            );

            // Insert loop MacAddr ตาราง TPSTPosReg
            if(isset($tCancelMacAddr) != empty($tCancelMacAddr)){
                for($j=0; $j < FCNnHSizeOf($tCancelMacAddr); $j++){
                    if($tCancelMacAddr[$j] == '' ){
                        continue;
                    }
                    $this->mPosRegister->FSaMPRGCancelUpdateMaster($aDataCancelUpdate, $tCancelMacAddr[$j]['ohdCancelMacAddr'], $tCancelEncPassword[$j]['tEncryptCancelPassword'], $tCancelBchCode[$j]['ohdCancelBchCode'], $tCancelPosCode[$j]['ohdCancelPosCode']); 
                }
            }


            //Insert loop master ตาราง TCNMPOS
            if(isset($tCancelPosCode) != empty($tCancelPosCode)){
                for($k=0; $k < FCNnHSizeOf($tCancelPosCode); $k++){
                    if($tCancelPosCode[$k] == ''){
                        continue;
                    } 
                    $this->mPosRegister->FSaMPRGCancelUpdateMasterPOS($aDataCancelUpdate, $tCancelPosCode[$k]['ohdCancelPosCode'], $tCancelEncPassword[$k]['tEncryptCancelPassword'], $tCancelBchCode[$k]['ohdCancelBchCode']);
                }
            }
       }catch(Exception $Error){
           echo $Error;
       }
    }

    



}