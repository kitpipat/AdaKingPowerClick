<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cShopGpByShp extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/shop/mShop');
        $this->load->model('company/shopgpbyshp/mShopGpByShp');
    }

    //Functionality : Function Call Page Main
	//Parameters : From Ajax File jShopGpByShp
	//Creator : 25/01/2019 Wasin(Yoshi)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCShopGpByShpMainPage(){
        $tBchCode               = $this->input->post('tBchCode');
        $tShpCode               = $this->input->post('tShpCode');
        $nPageShpCallBack       = $this->input->post('nPageShpCallBack');
        $vBtnSaveGpShp          = FCNaHBtnSaveActiveHTML('shop/0/0');
        $aAlwEventShopGpByShp   = FCNaHCheckAlwFunc('shop/0/0');
     
        $this->load->view('company/shopgpbyshp/wShopGpByShpMain',array(
            'tBchCode'              => $tBchCode,
            'tShpCode'              => $tShpCode,
            'nPageShpCallBack'      => $nPageShpCallBack,
            'vBtnSaveGpShp'         => $vBtnSaveGpShp,
            'aAlwEventShopGpByShp'  => $aAlwEventShopGpByShp
        ));
    }
    
    //Functionality : Function Call DataTables Shop GP By Shop
    //Parameters : From Ajax File jShopGpByShp
    //Creator : 25/01/2019 Wasin(Yoshi)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCShopGpByShpDataList(){
        try{
            $tOcmBchCode   = $this->input->post('tOcmBchCode');
            $tBchCode      = $this->input->post('tBchCode');
            $tShpCpde      = $this->input->post('tShpCpde');
            $nPage         = $this->input->post('nPageCurrent');
            $tSearchAll    = $this->input->post('tSearchAll');

            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
            if(!$tSearchAll){$tSearchAll='';}
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMShop_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }

            $aData  = array(
                'tOcmBchCode'   => $tOcmBchCode,
                'FTBchCode'     => $tBchCode,
                'FTShpCode'     => $tShpCpde,
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );
  
            $aResList           = $this->mShopGpByShp->FSaMShopGpByShpDataList($aData);
            $aAlwEventGpShop    = FCNaHCheckAlwFunc('shop/0/0'); 
            $aGenTable          = array(
                'aDataList' 	    => $aResList,
                'nPage'     	    => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventGpShop'   => $aAlwEventGpShop
            );

            // Return Data View
            $aReturnData = array(
                'vShopGpByShpDataList'  => $this->load->view('company/shopgpbyshp/wShopGpByShpDataTable',$aGenTable,true),
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
    
    //Functionality : Function Add/Shop GP By Shop
    //Parameters : From Ajax File jShopGpByShp
    //Creator : 09/05/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSvCShopGpByShpAdd(){
        $tBchCode      = $this->input->post('tBchCode');
        $tShpCode      = $this->input->post('tShpCode');
        $tPdtCode      =  '';
        $tStaGp        = $this->input->post('tStaGp');
  
        $tShpGpAvg     = $this->input->post('tShpGpAvg');
        $tBchName      = $this->input->post('tBchName');
        $dDateNew      = $this->input->post('dDateNew');
        $dDateOld      = $this->input->post('dDateOld');
        $nLangEdit     = $this->session->userdata("tLangEdit");

        try{
            

            $nRunSeq  = $this->mShopGpByShp->FSaMShopGpFindSeq($tBchCode,$tShpCode);
            if($nRunSeq == '' || $nRunSeq == null || $nRunSeq == false){
                $nSeq = 1;
            }else{
                $nSeq = $nRunSeq[0]->FNSgpSeq + 1;
            }

            $aDataMaster = array(
                'FTBchCode'       => $tBchCode,
                'FTShpCode'       => $tShpCode,
                'FNSgpSeq'        => $nSeq,
                'FTPdtCode'       => $tPdtCode,
                'FDSgpStartNew'   => $dDateNew,
                'FDSgpStartOld'   => $dDateOld,
                'FCSgpPerAvg'     => $tShpGpAvg,
                'FNLngID'         => $nLangEdit
            );

           //เช็ควันที่ซ้ำหรือไม่
            $aCheckData      = $this->mShopGpByShp->FSaMShopGpByShpCheckeData($aDataMaster);
            if($aCheckData['rtCode'] == '1'){
                 $aStatus = array(
                    'nStaEvent'	    => '600',
                    'tCodeReturn'   =>  $aDataMaster['FTBchCode'],
                    'rtDesc'  => language('common/main/main','tModalDecsShpGP'),
                );
            }else{
                $aStaDelete  =  $this->mShopGpByShp->FSaMShopGpByShpDateDeleteData($aDataMaster);
                if($aStaDelete['rtCode'] == '1'){
                    $aStaAddUpdateMaster  =  $this->mShopGpByShp->FSaMSHPAddUpdateMaster($aDataMaster);
                        $aStatus = array(
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                            'nStaEvent'	    => '1',
                            'tCodeReturn'   =>  $aDataMaster['FTBchCode'],
                            'tStaMessg'		=> 'Success Edit Event'
                        );
                    }
                }
            echo json_encode($aStatus);
        }
        catch(Exception $Error){
            echo $Error;
        }    
    }

    //Functionality : Function Add/Shop GP By Shop
    //Parameters : From Ajax File jShopGpByShp
    //Creator : 09/05/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSvCShopGpByShpEdit(){
        $tPdtCode      =  '';
        $tBchCode      = $this->input->post('tBchCode');
        $nSeq          = $this->input->post('pnSeq');
        $tShpCode      = $this->input->post('tShpCode');
        $tShpGpAvg     = $this->input->post('tShpGpAvg');

        $nLangEdit     = $this->session->userdata("tLangEdit");
        $dDateNew      = $this->input->post('dDateNew');
        $dDateOld      = $this->input->post('dDateOld');
        try{
            $aDataMaster = array(
                'FTBchCode'       => $tBchCode,
                'FTShpCode'       => $tShpCode,
                'FTPdtCode'       => $tPdtCode,
                'FDSgpStartNew'   => $dDateNew,
                'FDSgpStartOld'   => $dDateOld,
                'FCSgpPerAvg'     => $tShpGpAvg,
                'FNLngID'         => $nLangEdit,
                'FNSgpSeq'        => $nSeq
            );
            
            //เช็ควันที่ใหม่กับวันที่เดิมตรงกัน
            if($dDateNew == $dDateOld){
                $aStaAddUpdateMaster  =  $this->mShopGpByShp->FSaMSHPEditUpdateMaster($aDataMaster);
                $aStatus = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Event Edit Success  duplicate',
                    'tCodeReturn'   =>  $aDataMaster['FTBchCode']
                );
            } 

            if($dDateNew != $dDateOld){
                $aCheckData      = $this->mShopGpByShp->FSaMShopGpByShpCheckeData($aDataMaster);
                if($aCheckData['rtCode'] == '1'){
                    $aStatus = array(
                        'nStaEvent'	    => '600',
                        'tCodeReturn'   =>  $aDataMaster['FTBchCode'],
                        'rtDesc'        => language('common/main/main','tModalDecsShpGP'),
                    );
                }else{
                    $aStaAddUpdateMaster  =  $this->mShopGpByShp->FSaMSHPEditUpdateMaster($aDataMaster);
                    $aStatus = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'nStaEvent'	    => '1',
                        'tCodeReturn'   =>  $aDataMaster['FTBchCode'],
                        'tStaMessg'		=> 'Success Edit Event'
                    );
                }
            }
            echo json_encode($aStatus);
        }catch(Exception $Error){
            echo $Error;
        }    
    }

    //Functionality : Function Delete&DeleteAll GP By Shop
    //Parameters : From Ajax File jShopGpByDel
    //Creator : 09/05/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSvCShopGpByShpDel(){
        if ($this->input->post('tIDCode')) {
            $aData = array(
                'tDstCode'  => $this->input->post('tIDCode'),
                'tBchCode'  => $this->input->post('tBchCode'),
                'pnSeq'     => $this->input->post('pnSeq'),
                'pnSHP'     => $this->input->post('pnSHP')
            );
            $aResDel                = $this->mShopGpByShp->FSaMSHPDelAll($aData);
            $nNumRowPdtGpbyShop     = $this->mShopGpByShp->FSnMMSHPGetAllNumRow();
            //เช็ด เปลี่ยนหน้า 
            if($nNumRowPdtGpbyShop!==false){
                $aReturn    = array(
                    'nStaEvent'  => $aResDel['rtCode'],
                    'tStaMessg'  => $aResDel['rtDesc'],
                    'nNumRowPdtGpbyShop' => $nNumRowPdtGpbyShop
                );
                echo json_encode($aReturn);
            }else{
                echo "database error!";
            }           
        }
    }

    //Functionality : Function Update Inline GP By Shop
    //Parameters : From Ajax File wShopGpByShpDataDataTable
    //Creator : 14/05/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Update Inline
    //Return Type : String
    public function FSvCShopGpByEditinLinePageShop(){
        try{
            $aData = array(
                'FTPdtCode'     => $this->input->post('tPdtCode'),
                'FTBchCode'     => $this->input->post('tBchCode'),
                'FTShpCode'     => $this->input->post('tShpCode'),
                'FDSgpStart'    => $this->input->post('dDateStr'),
                'FCSgpPerAvg'   => $this->input->post('tGPPerAvg'),
                'FCSgpPerMon'   => $this->input->post('tGPPerMon'),
                'FCSgpPerTue'   => $this->input->post('tGPPerTue'),
                'FCSgpPerWed'   => $this->input->post('tGPPerWed'),
                'FCSgpPerThu'   => $this->input->post('tGPPerThu'),
                'FCSgpPerFri'   => $this->input->post('tGPPerFri'),
                'FCSgpPerSat'   => $this->input->post('tGPPerSat'),
                'FCSgpPerSun'   => $this->input->post('tGPPerSun')
            );
            $aShpShopData  = $this->mShopGpByShp->FSaMSHPCheckDatabeforeUpdate($aData);
            if(isset($aShpShopData)){
                $aStatus   = $this->mShopGpByShp->FSaMSHPUpdateDataInline($aData);
                echo json_encode($aStatus);
            }
    
        }
        catch(Exception $Error){
            echo $Error;
        }   
    }

    //Functionality : Function Call DataTables Shop GP By Shop
    //Parameters : From Ajax File jShopGpByShp
    //Creator : 25/01/2019 Wasin(Yoshi)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCShopGpByShpCheckDataList(){
        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCpde,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
        $aResList           = $this->mShopGpByShp->FSaMShopGpByShpDataList($aData);
    
    }

    //Page Add
    public function FSvCShopGpByShpPageAdd(){

        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $tPageEvent         = $this->input->post('tPageEvent');
        $aAlwEventGpShop    = FCNaHCheckAlwFunc('shop/0/0'); 
        $tLangID             = $this->session->userdata("tLangID");

        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode,
            'FNLngID'       => $tLangID 
        );

        //Get ชื่อร้านค้า
        $aDT                = $this->mShopGpByShp->FSaMShopGpBySelectDataDT($aData,'shop');
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
                $tNameBch           = $this->mShopGpByShp->FSaMShopGpBySelectDataDT($aData,'branch');
            }
        }else{
            $tOptionBrowseBch   = 0;
            $tWhereBranch       = '';
            $tNameBch           = $this->mShopGpByShp->FSaMShopGpBySelectDataDT($aData,'branch');
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
            'aAlwEventShopGpByShp'   => $aAlwEventGpShop,
            'aResult'                => array('rtCode'=>'99')
        );

        $this->load->view('company/shopgpbyshp/wShopGpByShpAdd',$aGenTable);
    }

    //Functionality :  Load Page Edit  
    //Parameters : 
    //Creator : 10/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    function FSvCSHPEditPage(){
        $aAlwEventShopGp	= FCNaHCheckAlwFunc('shop/0/0'); //Controle Event
        $dDateStr           = $this->input->post('dDateStr');
        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $nLangResort        = $this->session->userdata("tLangID");
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $aLangHave          = FCNaHGetAllLangByTable('TCNMShop_L');
        $nLangHave          = FCNnHSizeOf($aLangHave);
        
        if($nLangHave > 1){
            if($nLangEdit != ''){
                $nLangEdit = $nLangEdit;
            }else{
                $nLangEdit = $nLangResort;
            }
        }else{
            if(@$aLangHave[0]->nLangList == ''){
                $nLangEdit = '1';
            }else{
                $nLangEdit = $nLangEdit;
            }
        }
        
        $aData  = array(
            'FTBchCode'   => $this->input->post('ptBchCode'),
            'FTShpCode'   => $tShpCode,
            'FDSgpStart'  => $dDateStr,
            'FNLngID'     => $nLangEdit
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
                $tNameBch           = $this->mShopGpByShp->FSaMShopGpBySelectDataDT($aData,'branch');
            }
        }else{
            $tOptionBrowseBch   = 0;
            $tWhereBranch       = '';
            $tNameBch           = $this->mShopGpByShp->FSaMShopGpBySelectDataDT($aData,'branch');
        }


        $vBtnSave		= FCNaHBtnSaveActiveHTML('shop/0/0');
        $aResult        = $this->mShopGpByShp->FSaMShopGpGetData($aData);
        $aDataEdit      = array(
                                'aResult'                => $aResult,
                                'aAlwEventShopGpByShp'   => $aAlwEventShopGp,
                                'vBtnSave'               => $vBtnSave,
                                'tNameBch'               => $tNameBch,
                                'tWhereBranch'           => $tWhereBranch
                            );
        
        $this->load->view('company/shopgpbyshp/wShopGpByShpAdd',$aDataEdit);

    }

    //Functionality : call module Data ShopByGP  
    //Parameters : 
    //Creator : 03/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : 
    //Return Type : 
    public function FSvCShopGpByShpEventCheckData(){
        $tOldStartDate  = $this->input->post('tOldStartDate');
        $tBch           = $this->input->post('tBchCode');
        $tShp           = $this->input->post('tShpCode');
        $nLangEdit     = $this->session->userdata("tLangEdit");

        $aGetGPShop = array(
            'FTBchCode'     => $tBch,
            'FTShpCode'     => $tShp,
            'FDSgpStartNew' => $tOldStartDate,
            'FNLngID'       => $nLangEdit
        );
        $tResult = $this->mShopGpByShp->FSaMShopGpByShpCheckeData($aGetGPShop);
        $aResList   = array(
            'rtCode'      => '1',
            'rtDesc'      => 'Data not found.',
            'FTBchCode'   => $tBch,
            'FTShpCode'   => $tShp,
            'FDSgpStart'  => $tOldStartDate, 
            'FCSgpPerSun' => ($tResult['raItems']['FCSgpPerSun'] == '' ? '0' : $tResult['raItems']['FCSgpPerSun']), //GP วันอสทิตย์
            'FCSgpPerMon' => ($tResult['raItems']['FCSgpPerMon'] == '' ? '0' : $tResult['raItems']['FCSgpPerMon']), //GP วันจันทร์
            'FCSgpPerTue' => ($tResult['raItems']['FCSgpPerTue'] == '' ? '0' : $tResult['raItems']['FCSgpPerTue']), //GP วันอังคาร
            'FCSgpPerWed' => ($tResult['raItems']['FCSgpPerWed'] == '' ? '0' : $tResult['raItems']['FCSgpPerWed']), //GP วันพุธ
            'FCSgpPerThu' => ($tResult['raItems']['FCSgpPerThu'] == '' ? '0' : $tResult['raItems']['FCSgpPerThu']), //GP วันพฤหัส
            'FCSgpPerFri' => ($tResult['raItems']['FCSgpPerFri'] == '' ? '0' : $tResult['raItems']['FCSgpPerFri']), //GP วันศุกร์
            'FCSgpPerSat' => ($tResult['raItems']['FCSgpPerSat'] == '' ? '0' : $tResult['raItems']['FCSgpPerSat'])  //GP วันเสาร์
        );
        echo json_encode($aResList); 
    }

    //Functionality : Edit Data Shop by GP  
    //Parameters : 
    //Creator : 03/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : 
    //Return Type : 
    public function FSvCShopGpByShpEventInsertGP(){
            $tOldStartDate  = $this->input->post('tOldStartDate');
            $tBch           = $this->input->post('tBch');
            $tShp           = $this->input->post('tShp');

            $aDataMaster    = array(
                'FTBchCode'     => $tBch,
                'FTShpCode'     => $tShp,
                'FDSgpStart'    => $tOldStartDate,
                'FCSgpPerSun'   => $this->input->post('nSun'), 
                'FCSgpPerMon'   => $this->input->post('nMon'),
                'FCSgpPerTue'   => $this->input->post('nTue'),
                'FCSgpPerWed'   => $this->input->post('nWed'),
                'FCSgpPerThu'   => $this->input->post('nThu'),
                'FCSgpPerFri'   => $this->input->post('nFri'),
                'FCSgpPerSat'   => $this->input->post('nSat'),
                'FTMttSessionID'=>  $this->session->userdata("tSesSessionID"),
            );
            $this->mShopGpByShp->FSaMSHPGPEditUpdateMaster($aDataMaster);
        }
    }