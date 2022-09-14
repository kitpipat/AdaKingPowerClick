<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSmartlockerlayout extends MX_Controller {


    public function __construct() {
        parent::__construct ();
        $this->load->model('company/smartlockerlayout/mSmartlockerlayout');
        $this->load->model('company/shopgpbypdt/mShopGpByPdt');
    }

    //Main page
    public function FSvCSMLMainPage(){
        $tSesUserLevel  = $this->session->userdata("tSesUsrLevel"); 
        $tBchCode       = $this->input->post('tBchCode');
        if($tSesUserLevel == 'HQ'){ //เช้ามาแบบสำนักงานใหญ่
            $tBchCode = $this->input->post('tBchCode');
        }else{ //เข้ามาแบบสาขาหรือช็อป
            if (strpos($tBchCode, ',') !== false) {
                //มีหลายสาขา
                $tBchCode = $this->session->userdata("tSesUsrBchCode"); 
            }else{
                //มีสาขาเดียว
                $tBchCode = $this->input->post('tBchCode');
            }
        }

        $tShpCode         = $this->input->post('tShpCode');
        $vBtnSML          = FCNaHBtnSaveActiveHTML('shop/0/0/LOCKER');
        $aAlwEventSML     = FCNaHCheckAlwFunc('shop/0/0/LOCKER');
        $nLangEdit        = $this->session->userdata("tLangEdit");
        
        //ส่วน Insert
        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode
        );

        $tSesUserLevel      = $this->session->userdata("tSesUsrLevel"); 
        if($tSesUserLevel == 'HQ'){
            //Check ว่าร้านนี้มีกี่สาขา
            if (strpos($tBchCode, ',') !== false) {
                //มีหลายสาขาเดียว
                $tOptionBrowseBch = 1;
                $tNameBch         = '';
                $aNewBranch = explode(",",$tBchCode);
                $tWhereBranch = '';
                for($i=0; $i<FCNnHSizeOf($aNewBranch); $i++){
                    $tWhereBranch .= "'".trim($aNewBranch[$i])."'".',';
                    if($i == FCNnHSizeOf($aNewBranch) - 1){
                        $tWhereBranch = substr($tWhereBranch,0,-1);
                    }
                }
            }else{
                //มีสาขาเดียว
                $tOptionBrowseBch   = 0;
                $tWhereBranch       = '';
                $tNameBch           = $this->mShopGpByPdt->FSaMShopGpBySelectDataDT($aData,'branch');
            }
        }else{
            $tOptionBrowseBch   = 0;
            $tWhereBranch       = '';
            $tNameBch           = $this->mShopGpByPdt->FSaMShopGpBySelectDataDT($aData,'branch');
        }   

        $tGetLayoutGroup    = $this->mSmartlockerlayout->FSaMSMLGetGroup($tBchCode,$tShpCode,$nLangEdit);
        $tGetLayoutColumn   = $this->mSmartlockerlayout->FSaMSMLGetColumn($tBchCode,$tShpCode);

        //Get Group
        if($tGetLayoutGroup['rtCode'] == '1'){
            $tLayoutGroup = '';
            for($i=0; $i<FCNnHSizeOf($tGetLayoutGroup['aList']); $i++){
                $tLayoutGroup .= $tGetLayoutGroup['aList'][$i]['FTRakCode'] . ':' . $tGetLayoutGroup['aList'][$i]['FTRakName'] .',' ;
                
                if($i==FCNnHSizeOf($tGetLayoutGroup['aList']) - 1){
                    $tLayoutGroup = substr($tLayoutGroup,0,-1);
                }
            }
        }else{
            $tLayoutGroup = '';
        }

        //Get Column
        if($tGetLayoutColumn['rtCode'] == '1'){
            $tLayoutColumn = '';
            for($i=0; $i<FCNnHSizeOf($tGetLayoutColumn['aList']); $i++){
                $tLayoutColumn .= $tGetLayoutColumn['aList'][$i]['FNLayNo'] . ',';

                if($i==FCNnHSizeOf($tGetLayoutColumn['aList']) - 1){
                    $tLayoutColumn = substr($tLayoutColumn,0,-1);
                }
            }
        }else{
            $tLayoutColumn = '';
        }

        $this->load->view('company/smartlockerlayout/wSmartlockerlayoutMain',array(
            'tNameBch'              => $tNameBch,
            'tWhereBranch'          => $tWhereBranch,
            'tBchCode'              => $tBchCode,
            'tShpCode'              => $tShpCode,
            'vBtnSaveSML'           => $vBtnSML,
            'aAlwEventSML'          => $aAlwEventSML,

            'tSearchLayoutGroup'    => $tLayoutGroup,
            'tSearchLayoutColumn'   => $tLayoutColumn,
        ));
    }

    //List Data
    public function FSvCSMLDataList(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShpCode       = $this->input->post('tShpCode');
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventSML   = FCNaHCheckAlwFunc('shop/0/0/LOCKER');

        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
        $aResList           = $this->mSmartlockerlayout->FSaMSMLDataList($aData);
     
        $aGenTable          = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'aAlwEventSML'      => $aAlwEventSML
        );

        //Return Data View
        $this->load->view('company/smartlockerlayout/wSmartlockerlayoutDataTable',$aGenTable);
    }

    //Insert 
    public function FSvCSMLInsert(){
        $tBch               = $this->input->post('tBch');
        $tShp               = $this->input->post('tShp');
        $tRack              = $this->input->post('tRack');
        $tSize              = $this->input->post('tSize');
        $tLayno             = $this->input->post('tLayno');
        $nScaleX            = $this->input->post('nScaleVertical');
        $nScaleY            = $this->input->post('nScaleHorizontal');
        $nFloor             = $this->input->post('nFloor');
        $nColumn            = $this->input->post('nColumn');
        $tStatus            = $this->input->post('tStatus');
        $tLayoutName        = $this->input->post('tLayoutName');
        $tSMLRemark         = $this->input->post('tSMLRemark');

        $aData = array(
            'FTBchCode'     => $tBch,
            'FTShpCode'     => $tShp,
            'FNLayNo'       => $tLayno,
            'FNLayScaleX'   => $nScaleX,
            'FNLayScaleY'   => $nScaleY,      
            'FNLayRow'      => $nFloor,
            'FNLayCol'      => $nColumn,
            'FTPzeCode'     => $tSize,
            'FTRakCode'     => $tRack,
            'FTLayStaUse'   => $tStatus,
            'FDCreateOn'    => date('Y-m-d'),
            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            'FTLayName'     => $tLayoutName,
            'FTLayRemark'   => $tSMLRemark,
            'FNLngID'       => $this->session->userdata("tLangEdit")
        );
        $tCheckLayno = $this->mSmartlockerlayout->FSaMSMLCheckLayout($aData);
       
        if($tCheckLayno['rtCode'] == '1'){
            $tCheckColumnAndFloor = $this->mSmartlockerlayout->FSaMSMLCheckColumnANDFloor($aData,'ADD');
            if($tCheckColumnAndFloor['rtCode'] == '1' ){
                //Insert
                $this->mSmartlockerlayout->FSaMSMLInsertLayout($aData);
            }else{
                //2 คอลั่ม และ ชั่น ซ้ำ
                echo 2;
            }
        }else{
            //1 ช่องซ้ำ
            echo 1;
        }
    }

    //Delete Single
    public function FSvCSMLDelete(){
        $tBch      = $this->input->post('pnBch');
        $tShp      = $this->input->post('pnShp');
        $nLayno    = $this->input->post('pnLayno');

        $aData = array(
            'FTBchCode'     => $tBch,
            'FTShpCode'     => $tShp,
            'FNLayNo'       => $nLayno
        );
        $this->mSmartlockerlayout->FSaMSMLDelete($aData);

    }

    //Delete Mutirecord
    public function FSvCSMLDeleteMutirecord(){
        $tTextLaynoMultiple     = $this->input->post('aTextLaynoMultiple');
        $tTextBchMultiple       = $this->input->post('aTextBchMultiple');
        $tSMLShop               = $this->input->post('tSMLShop');

        $aExplodeLayno  = explode(",",$tTextLaynoMultiple);
        $aExplodeBCH    = explode(",",$tTextBchMultiple);
        for($i=0;$i<FCNnHSizeOf($aExplodeLayno);$i++){
            $aData = array(
                'FTBchCode'     => $aExplodeBCH[$i],
                'FTShpCode'     => $tSMLShop,
                'FNLayNo'       => $aExplodeLayno[$i]
            );
            $this->mSmartlockerlayout->FSaMSMLDelete($aData);
        }
    }

    //Event Edit
    public function FSvCSMLEdit(){
        $tSMLOldLayno       = $this->input->post('tSMLOldLayno');
        $tSMLOldBch         = $this->input->post('tSMLOldBch');
        $tSMLOldShp         = $this->input->post('tSMLOldShp');

        $tBch               = $this->input->post('tBch');
        $tShp               = $this->input->post('tShp');
        $tRack              = $this->input->post('tRack');
        $tSize              = $this->input->post('tSize');
        $tLayno             = $this->input->post('tLayno');
        $nScaleVertical     = $this->input->post('nScaleVertical');
        $nScaleHorizontal   = $this->input->post('nScaleHorizontal');
        $nFloor             = $this->input->post('nFloor');
        $nColumn            = $this->input->post('nColumn');
        $tStatus            = $this->input->post('tStatus');
        $tLayoutName        = $this->input->post('tLayoutName');
        $tSMLRemark         = $this->input->post('tSMLRemark');

        $aData = array(
            'FTBchCode'     => $tBch,
            'FTShpCode'     => $tShp,
            'FNLayNo'       => $tLayno,
            'FNLayScaleX'   => $nScaleVertical,
            'FNLayScaleY'   => $nScaleHorizontal,      
            'FNLayRow'      => $nFloor,
            'FNLayCol'      => $nColumn,
            'FTPzeCode'     => $tSize,
            'FTRakCode'     => $tRack,
            'FTLayStaUse'   => $tStatus,
            'FDLastUpdOn'    => date('Y-m-d'),
            'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
            'FTLayName'     => $tLayoutName,
            'FTLayRemark'   => $tSMLRemark,
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'TYPE'          => 'EDIT'
        );

        $aWhere = array(
            'FNLayNoOld'       => $tSMLOldLayno,
            'FTBchCodeOld'     => $tSMLOldBch,
            'FTShpCodeOld'     => $tSMLOldShp
        );

        if($tBch == $tSMLOldBch && $tSMLOldShp == $tSMLOldShp &&  $tSMLOldLayno == $tLayno){
            $tCheckColumnAndFloor = $this->mSmartlockerlayout->FSaMSMLCheckColumnANDFloor($aData,$aWhere);
            if($tCheckColumnAndFloor['rtCode'] == '1' ){
               //update
                $this->mSmartlockerlayout->FSaMSMLUpdateLayout($aData,$aWhere);
            }else{
                //2 คอลั่ม และ ชั่น ซ้ำ
                echo 2;
            }
        }else{
            $tCheckLayno = $this->mSmartlockerlayout->FSaMSMLCheckLayout($aData);
            if($tCheckLayno['rtCode'] == '1'){

                $tCheckColumnAndFloor = $this->mSmartlockerlayout->FSaMSMLCheckColumnANDFloor($aData,$aWhere);
                if($tCheckColumnAndFloor['rtCode'] == '1' ){
                    //update
                    $this->mSmartlockerlayout->FSaMSMLUpdateLayout($aData,$aWhere);
                }else{
                    //2 คอลั่ม และ ชั่น ซ้ำ
                    echo 2;
                }
            }else{
                //1 ช่องซ้ำ
                echo 1;
            }
        }
    }

    //Get Search
    public function FSvCSMLGetSearch(){
        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $nLangEdit          = $this->session->userdata("tLangEdit");

        $tGetLayoutGroup    = $this->mSmartlockerlayout->FSaMSMLGetGroup($tBchCode,$tShpCode,$nLangEdit);
        $tGetLayoutColumn   = $this->mSmartlockerlayout->FSaMSMLGetColumn($tBchCode,$tShpCode);
        $aPackData = array(
            'GetLayoutGroup'    => $tGetLayoutGroup,
            'GetLayoutColumn'   => $tGetLayoutColumn
        );
        echo json_encode($aPackData);
    }

}