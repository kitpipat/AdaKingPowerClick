<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cShopGpByPdt extends MX_Controller {
    
    public function __construct() {
        parent::__construct ();
        $this->load->model('company/shop/mShop');
        $this->load->model('company/shopgpbypdt/mShopGpByPdt');
    }

    //Call Shop Gp By Product Page Main
    public function FSvCShopGpByPdtMainPage(){
        $tBchCode               = $this->input->post('tBchCode');
        $tShpCode               = $this->input->post('tShpCode');
        $aAlwEventShopGpByPdt   = FCNaHCheckAlwFunc('shop/0/0');
        
        $tSesUserLevel = $this->session->userdata("tSesUsrLevel"); 
        if($tSesUserLevel == 'HQ'){
            $tBchCode = $tBchCode;
        }else{
            $tBchCode = $this->session->userdata("tSesUsrBchCode"); 
        }
        

        $this->load->view('company/shopgpbypdt/wShopGpByPdtMain',array(
            'tBchCode'              => $tBchCode,
            'tShpCode'              => $tShpCode,
            'aAlwEventShopGpByPdt'  => $aAlwEventShopGpByPdt
        ));

        //ล้าง temp ทุกครั้งที่เข้ามา
        $this->mShopGpByPdt->FSxMShopGpByRemoveTemp($this->session->userdata("tSesSessionID"));
    }

    //Function Table
    public function FSvCShopGpByPdtDataList(){
        $tBchCode      = $this->input->post('tBchCode');
        $tShpCpde      = $this->input->post('tShpCode');
        $nPage         = $this->input->post('nPageCurrent');
        $tSearchAll    = $this->input->post('tSearchAll');
        $nLangEdit     = $this->session->userdata("tLangEdit");
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}

        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCpde,
            'tSearchAll'    => $tSearchAll,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit
        );

        $aResList           = $this->mShopGpByPdt->FSaMShopGpByProductDataList($aData);
        $aAlwEventGpShop    = FCNaHCheckAlwFunc('shop/0/0'); 
        $aGenTable          = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'tSearchAll'        => $tSearchAll,
            'aAlwEventGpShop'   => $aAlwEventGpShop
        );

        // Return Data View
        $this->load->view('company/shopgpbypdt/wShopGpByPdtDataTable',$aGenTable);
    }

    //Page Add
    public function FSvCShopGpByPdtPageAdd(){
        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $tPageEvent         = $this->input->post('tPageEvent');
        $aAlwEventGpShop    = FCNaHCheckAlwFunc('shop/0/0'); 
        
        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode
        );

        //Get ชื่อร้านค้า
        $aDT                = $this->mShopGpByPdt->FSaMShopGpBySelectDataDT($aData,'shop');
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
        

        $vBtnSave		    = FCNaHBtnSaveActiveHTML('shop/0/0');
        $aGenTable          = array(
            'aDT'                    => $aDT,
            'tNameBch'               => $tNameBch,
            'vBtnSave' 			     => $vBtnSave,
            'tWhereBranch'           => $tWhereBranch,
            'tBchCode' 	             => $tBchCode,
            'tShpCode'     	         => $tShpCode,
            'tPageEvent'             => $tPageEvent,
            'aAlwEventShopGpByPdt'   => $aAlwEventGpShop
        );

        $this->load->view('company/shopgpbypdt/wShopGpByPdtAdd',$aGenTable);
    }

    //Page Edit
    public function FSvCShopGpByPdtPageEdit(){
        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $tPageEvent         = $this->input->post('tPageEvent');
        $tDateStart         = $this->input->post('tDateStart');
        $aAlwEventGpShop    = FCNaHCheckAlwFunc('shop/0/0'); 
        $vBtnSave		    = FCNaHBtnSaveActiveHTML('shop/0/0');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $pnSeq              = $this->input->post('pnSeq');

        $aDataSelectWhere  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode,
            'FDSgpStart'    => $tDateStart,
            'FNLngID'       => $nLangEdit,
            'FNSgpSeq'      => $pnSeq
        );

        $aDetailDT          = $this->mShopGpByPdt->FSaMShopGpSelectPDT($aDataSelectWhere);
        $aGenTable          = array(
            'aDT'                    => $aDetailDT,
            'vBtnSave' 			     => $vBtnSave,
            'aAlwEventShopGpByPdt'   => $aAlwEventGpShop,
            'pnSeq'                  => $pnSeq
        );

        $this->load->view('company/shopgpbypdt/wShopGpByPdtEdit',$aGenTable);
    }

    //Table Product Page Add
    public function FSvCShopGpByPdtTableInsertProduct(){
        $aAlwEventGpShop    = FCNaHCheckAlwFunc('shop/0/0'); 
        $aGenTable          = array(
            'aAlwEventShopGpByPdt'  => $aAlwEventGpShop
        );

        $this->load->view('company/shopgpbypdt/wShopGpByPdtTableInsert',$aGenTable);
    }

    //Table Product Page Edit
    public function FSvCShopGpByPdtTableEditProduct(){
        $aDataItem          = $this->input->post('aDataItem');
        $aAlwEventGpShop    = FCNaHCheckAlwFunc('shop/0/0'); 
        $aGenTable          = array(
            'aAlwEventShopGpByPdt'  => $aAlwEventGpShop,
            'aDataItem'             => $aDataItem,
            'pnSeq'                 => $this->input->post('pnSeq')
        );
        $this->load->view('company/shopgpbypdt/wShopGpByPdtTableEdit',$aGenTable);


        $aData =  array(
            'FTShpCode'         => $this->input->post('tSHP'),
            'FTBchCode'         => $this->input->post('tBCH'),
            'FDSgpStart'        => $this->input->post('tDate'),
            'FTMttSessionID'    => $this->session->userdata("tSesSessionID")
        );
        $this->mShopGpByPdt->FSxMShopGpMoveDTToTemp($aData);
    }

    //Event Insert PDT
    public function FSvCShopGpByPdtEventInsertProduct(){
        $aDataItem          = $this->input->post('aDataItem');

        $tSesUserLevel = $this->session->userdata("tSesUsrLevel"); 
        if($tSesUserLevel == 'HQ'){
            $tBCH = $this->input->post('tBCH');
        }else{
            $tBCH = $this->session->userdata("tSesUsrBchCode"); 
        }

        $tSHP               = $this->input->post('tSHP');
        $tDataStart         = $this->input->post('tDataStart');
        $aGP                = $this->input->post('aGP');

        //step 1 : เช็ควันที่ห้ามซ้ำ
        $tReturnCheckDate = $this->mShopGpByPdt->FSaMShopGpByPDTCheckDate($tDataStart,$tBCH,$tSHP);
        if($tReturnCheckDate['rtDesc'] == 'found'){
            //return
            $aReturnData = array(
                'nStaProcess'       => 'DateDuplicate'
            );
        }else{  
            for($i=0;$i<FCNnHSizeOf($aDataItem); $i++){

                $nRunSeq  = $this->mShopGpByPdt->FSaMShopGpFindSeq($tBCH,$tSHP);
                if($nRunSeq == '' || $nRunSeq == null || $nRunSeq == false){
                    $nSeq = 1;
                }else{
                    $nSeq = $nRunSeq[0]->FNSgpSeq + 1;
                }
                
                $aInsertGPPDT = array(
                    'FTBchCode'     => $tBCH,
                    'FTShpCode'     => $tSHP,
                    'FDSgpStart'    => $tDataStart .' '. date('H:i:s'),
                    'FTPdtCode'     => $aDataItem[$i]['PDTCODE'],
                    'FNSgpSeq'      => $nSeq,
                    'FCSgpPerAvg'   => $aGP[$i],
                    'FCSgpPerSun'   => '0.00',
                    'FCSgpPerMon'   => '0.00',
                    'FCSgpPerTue'   => '0.00',
                    'FCSgpPerWed'   => '0.00',
                    'FCSgpPerThu'   => '0.00',
                    'FCSgpPerFri'   => '0.00',
                    'FCSgpPerSat'   => '0.00',
                );
                $this->mShopGpByPdt->FSaMShopGpByPDTInsert($aInsertGPPDT);
            }

            //return
            $aReturnData = array(
                'nStaProcess'       => 'Success',
                'nStaCallBack'		=> $this->session->userdata('tBtnSaveStaActive')
            );
        }
        echo json_encode($aReturnData);
    }

    //Event Edit PDT
    public function FSvCShopGpByPdtEventEditProduct(){
        $aDataItem          = $this->input->post('aDataItem');

        $tSesUserLevel = $this->session->userdata("tSesUsrLevel"); 
        if($tSesUserLevel == 'HQ'){
            $tBCH = $this->input->post('tBCH');
        }else{
            $tBCH = $this->session->userdata("tSesUsrBchCode"); 
        }

        $tSHP               = $this->input->post('tSHP');
        $tOldDataStart      = $this->input->post('tOldDataStart');
        $tDataStart         = $this->input->post('tDataStart');
        $aGP                = $this->input->post('aGP');

        //step 1 : เช็คว่าข้อมูลถูกเปลี่ยนไหม 
        if($tOldDataStart == $tDataStart){
            $tStatusDate = 'dupdate';
        }else{
            $tStatusDate = 'newdate';
        }

        if($tStatusDate == 'newdate'){
            $tReturnCheckDate = $this->mShopGpByPdt->FSaMShopGpByPDTCheckDate($tDataStart,$tBCH,$tSHP);
            if($tReturnCheckDate['rtDesc'] == 'found'){
                //Date Duplicate
                $aReturnData = array(
                    'nStaProcess'       => 'DateDuplicate'
                );
                $tStatusInsert = 'exit';
            }else{
                //Insert
                $tStatusInsert = 'Insert';
            }
        }else{
            //Insert
            $tStatusInsert = 'Insert';
        }


        if($tStatusInsert == 'Insert'){

            //check gp แต่ละ product ในตาราง temp 
            $pnSeq = $this->input->post('pnSeq');
            $this->mShopGpByPdt->FSaMShopGpByDeleteGPOld($tOldDataStart,$tBCH,$tSHP,$pnSeq);
            $aGetGPTemp = array(
                'FTBchCode'     => $tBCH,
                'FTShpCode'     => $tSHP,
                'FDSgpStart'    => $tOldDataStart,
                'FTMttSessionID'=>  $this->session->userdata("tSesSessionID"),
                'FTMttTableKey' => 'TCNMShopGP',
                'FTMttRefKey'   => 'TCNMShopGP'
            );
            $tResult = $this->mShopGpByPdt->FSaMShopGpBySelectTemp($aGetGPTemp);
            if($tResult['rtCode'] == 1){
                $tSysTemp = 'Havedate';
            }else{
                $tSysTemp = 'Nodata';
            }

            for($i=0;$i<FCNnHSizeOf($aDataItem); $i++){
                if($tSysTemp == 'Havedate'){
                    for($k=0; $k<FCNnHSizeOf($tResult['raItem']); $k++){
                        if($aDataItem[$i]['PDTCODE'] == $tResult['raItem'][$k]['FTPdtCode']){
                            $nValueMon = $tResult['raItem'][$k]['FCSgpPerMon'];
                            $nValueTue = $tResult['raItem'][$k]['FCSgpPerTue'];
                            $nValueWed = $tResult['raItem'][$k]['FCSgpPerWed'];
                            $nValueThu = $tResult['raItem'][$k]['FCSgpPerThu'];
                            $nValueFri = $tResult['raItem'][$k]['FCSgpPerFri'];
                            $nValueSat = $tResult['raItem'][$k]['FCSgpPerSat'];
                            $nValueSun = $tResult['raItem'][$k]['FCSgpPerSun'];
                            break;
                        }else{
                            $nValueMon = "0.00";
                            $nValueTue = "0.00";
                            $nValueWed = "0.00";
                            $nValueThu = "0.00";
                            $nValueFri = "0.00";
                            $nValueSat = "0.00";
                            $nValueSun = "0.00";
                        }
                    }
                }else{
                    $nValueMon = "0.00";
                    $nValueTue = "0.00";
                    $nValueWed = "0.00";
                    $nValueThu = "0.00";
                    $nValueFri = "0.00";
                    $nValueSat = "0.00";
                    $nValueSun = "0.00";
                }

                $nRunSeq  = $this->mShopGpByPdt->FSaMShopGpFindSeq($tBCH,$tSHP);
                if($nRunSeq == '' || $nRunSeq == null || $nRunSeq == false){
                    $nSeq = 1;
                }else{
                    $nSeq = $nRunSeq[0]->FNSgpSeq + 1;
                }

                $aInsertGPPDT = array(
                    'FTBchCode'     => $tBCH,
                    'FTShpCode'     => $tSHP,
                    'FDSgpStart'    => $tDataStart .' '. date('H:i:s'),
                    'FTPdtCode'     => $aDataItem[$i]['PDTCODE'],
                    'FNSgpSeq'      => $nSeq,
                    'FCSgpPerAvg'   => $aGP[$i],
                    'FCSgpPerSun'   => $nValueSun,
                    'FCSgpPerMon'   => $nValueMon,
                    'FCSgpPerTue'   => $nValueTue,
                    'FCSgpPerWed'   => $nValueWed,
                    'FCSgpPerThu'   => $nValueThu,
                    'FCSgpPerFri'   => $nValueFri,
                    'FCSgpPerSat'   => $nValueSat
                );
                $this->mShopGpByPdt->FSaMShopGpByPDTInsert($aInsertGPPDT);
            }

            //ลบข้อมูลใน ตาราง temp
            $this->mShopGpByPdt->FSaMShopGpByDeleteTemp($aGetGPTemp);
            $aReturnData = array(
                'nStaProcess'       => 'Success',
                'nStaCallBack'		=> $this->session->userdata('tBtnSaveStaActive')
            );
        }

        echo json_encode($aReturnData);
    }

    //Event Delete หน้า list
    public function FSvCShopGpByPdtEventDeleteList(){
        $tBCH               = $this->input->post('tBchCode');
        $tSHP               = $this->input->post('tShpCode');
        $tDataStart         = $this->input->post('tDateStart');
        $pnSeq              = $this->input->post('pnSeq');
        $this->mShopGpByPdt->FSaMShopGpByDeleteGPOld($tDataStart,$tBCH,$tSHP,$pnSeq);
    }

    //Event Insert GP รายสัปดาห์ To Temp
    public function FSvCShopGpByPdtEventInsertGPToTemp(){
        $tType = $this->input->post('tType');
        if($tType == 'Insert'){
            $tOldStartDate  = $this->input->post('tOldStartDate');
            $tBch           = $this->input->post('tBch');
            $tShp           = $this->input->post('tShp');
            $tPDTCode       = $this->input->post('tPDTCode');

            $aInsertGPPDT = array(
                'FTBchCode'     => $tBch,
                'FTShpCode'     => $tShp,
                'FTPdtCode'     => $tPDTCode,
                'FDSgpStart'    => $tOldStartDate,
                'FCSgpPerSun'   => $this->input->post('nSun'), 
                'FCSgpPerMon'   => $this->input->post('nMon'),
                'FCSgpPerTue'   => $this->input->post('nTue'),
                'FCSgpPerWed'   => $this->input->post('nWed'),
                'FCSgpPerThu'   => $this->input->post('nThu'),
                'FCSgpPerFri'   => $this->input->post('nFri'),
                'FCSgpPerSat'   => $this->input->post('nSat'),
                'FTMttSessionID'=>  $this->session->userdata("tSesSessionID"),
                'FTMttTableKey' => 'TCNMShopGP',
                'FTMttRefKey'   => 'TCNMShopGP'
            );
            $this->mShopGpByPdt->FSaMShopGpByPDTInsertGPWeek($aInsertGPPDT);
        }else if($tType == 'Edit'){
            $tOldStartDate  = $this->input->post('tOldStartDate');
            $tBch           = $this->input->post('tBch');
            $tShp           = $this->input->post('tShp');
            $tPDTCode       = $this->input->post('tPDTCode');
            $aGetGPPDT = array(
                'FTBchCode'     => $tBch,
                'FTShpCode'     => $tShp,
                'FTPdtCode'     => $tPDTCode,
                'FDSgpStart'    => $tOldStartDate,
                'FTMttSessionID'=>  $this->session->userdata("tSesSessionID"),
                'FTMttTableKey' => 'TCNMShopGP',
                'FTMttRefKey'   => 'TCNMShopGP'
            );
            $tResult = $this->mShopGpByPdt->FSaMShopGpGetDataGPWeek($aGetGPPDT);
            echo json_encode($tResult); 
        }
    }

    //Event Delete Mutirecord
    public function FSvCShopGpByPdtEventDeleteMutirecord(){
        $aPackData = $this->input->post('aPackData');
        for($i=0; $i<FCNnHSizeOf($aPackData); $i++){
            $aDelete = array(
                'FTBchCode'     => $aPackData[$i][1],
                'FTShpCode'     => $aPackData[$i][2],
                'FDSgpStart'    => $aPackData[$i][0]
            );
            $this->mShopGpByPdt->FSaMShopGpByPDTDeleteMutirecord($aDelete);
        }
    }
}