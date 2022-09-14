<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPosShop extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/posshop/mPosShop');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPshBrowseType,$tPshBrowseOption){
        $nMsgResp   = array('title'=>"Product Location");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave           = FCNaHBtnSaveActiveHTML('salemachine/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPosShop   = FCNaHCheckAlwFunc('salemachine/0/0');
        $this->load->view('pos/posshop/wPosShop', array (
            'nMsgResp'              => $nMsgResp,
            'vBtnSave'              => $vBtnSave,
            'nPshBrowseType'        => $nPshBrowseType,
            'tPshBrowseOption'      => $tPshBrowseOption,
            'aAlwEventPosShop'      => $aAlwEventPosShop
        ));
    }

    //Functionality : Function Call POS SHOP Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 12/02/2019 Napat(Jame)
    //Return : String View
    //Return Type : View
    public function FSvCPSHListPage(){ 
        $tPSHMerCode       = $this->input->post('tMerCode');
        $tPSHBchCode       = $this->input->post('tBchCode');
        $tPSHShpCode       = $this->input->post('tShpCode');
        $tShpTypeCode      = $this->input->post('tShpTypeCode');

        //มีสองสาขา
        $aBchCode  = explode(", ",$tPSHBchCode);
        $nCountBch = FCNnHSizeOf($aBchCode);  
        if($nCountBch != '1' ){
            $aBchCodeAll  = explode(", ",$tPSHBchCode);
            $tConvertBchCode  = $aBchCodeAll;
        }else{
            $tConvertBchCode  = explode(", ",$tPSHBchCode);
        }

        $aData = array(
            'tPSHMerCode'   => $tPSHMerCode ,
            'tPSHBchCode'   => $tConvertBchCode,
            'tPSHShpCode'   => $tPSHShpCode,
            'tShpTypeCode'  => $tShpTypeCode  
        );
        $tRefCode =  json_encode($aData);

        $aAlwEventPosShop	    = FCNaHCheckAlwFunc('salemachine/0/0'); 
        $this->load->view('pos/posshop/wPosShopList', array(
            'aAlwEventPosShop'  => $aAlwEventPosShop,
            'aPSHBchCode'       => $tPSHBchCode,
            'aPSHShpCode'       => $tPSHShpCode,
            'aPSHMerCode'       => $tPSHMerCode,
            'tPSHShpTypeCode'   => $tShpTypeCode,
            'tRefCode'          => $tRefCode   
        ));
    }

    //Functionality : Function Call POS SHOP Add Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 09/07/2019 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCPSHCallPageAdd(){ 
        $tPSHMerCode       = $this->input->post('tMerCode');
        $tPSHBchCode       = $this->input->post('tBchCode');
        $tPSHShpCode       = $this->input->post('tShpCode');
        $tShpTypeCode      = $this->input->post('tShpTypeCode');
        $tShpType          = $this->input->post('tShpType');
        //มีสองสาขา
        $aBchCode  = explode(", ",$tPSHBchCode);
        $nCountBch = FCNnHSizeOf($aBchCode);  
        if($nCountBch != '1' ){
            $aBchCodeAll  = explode(", ",$tPSHBchCode);
            $tConvertBchCode  = $aBchCodeAll;
        }else{
            $tConvertBchCode  = explode(", ",$tPSHBchCode);
        }

        $aData = array(
            'tPSHMerCode'   => $tPSHMerCode ,
            'tPSHBchCode'   => $tConvertBchCode,
            'tPSHShpCode'   => $tPSHShpCode,
            'tShpTypeCode'  => $tShpTypeCode  
        );
        $tRefCode =  json_encode($aData);

        $aAlwEventPosShop	    = FCNaHCheckAlwFunc('salemachine/0/0'); 
        $this->load->view('pos/posshop/wPosShopAddNew', array(
            'aAlwEventPosShop'  => $aAlwEventPosShop,
            'aPSHBchCode'       => $tPSHBchCode,
            'aPSHShpCode'       => $tPSHShpCode,
            'aPSHMerCode'       => $tPSHMerCode,
            'tShpTypeCode'      => $tShpTypeCode,
            'aResult'           => 99,
            'tRefCode'          => $tRefCode,
            'rtCode'            => 1,
            'tShpType'          => $tShpType,       
        ));
    }


    //Functionality : Function Call POS SHOP Edit Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 09/07/2019 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCPSHCallPageEdit(){ 
        $nLangEdit               = $this->session->userdata("tLangEdit");
        $aAlwEventPosShop        = FCNaHCheckAlwFunc('salemachine/0/0');
        $tShpTypeCode            = $this->input->post('tShpTypeCode');
        $tShpType                = $this->input->post('tShpType');

        $aData = array( 
            'FTBchCode' => $this->input->post('tBchCode'),
            'FTPosCode' => $this->input->post('tPosCode'),
            'FTShpCode' => $this->input->post('tShpCode'),
            'tShpType'  => $tShpTypeCode,
            'FNLngID'   => $nLangEdit
        );

        switch ($aData['tShpType']) {
            case "4":
                    $aResult   =   $this->mPosShop->FSaMPSHGetDataPosShopType4($aData);
                break;
            case "5":
                    $aResult   =   $this->mPosShop->FSaMPSHGetDataPosShopType5($aData);
                break;
            default:
                    $aResult   =   $this->mPosShop->FSaMPSHGetDataPosShopType4($aData);    
            }

        $aDataEdit = array(
            'aResult'               => $aResult,
            'aAlwEventPosShop'      => $aAlwEventPosShop,
            'aPSHBchCode'           => $aData['FTBchCode'],
            'aPSHShpCode'           => $aData['FTShpCode'],
            'FTPosCode'             => $aData['FTPosCode'],
            'tShpTypeCode'          => $tShpTypeCode,
            'rtCode'                => 99,
            'tShpType'              => $tShpType, 
        );
        $this->load->view('pos/posshop/wPosShopAddNew',$aDataEdit);
    }

    //Functionality : Function Call POS SHOP Page Setting Layout
    //Parameters : Ajax and Function Parameter
    //Creator : 05/07/2019 saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCPSHCallPageSettingLayout(){ 
        $tPSHBchCode       = $this->input->post('tBchCode');
        $tPSHShpCode       = $this->input->post('tShpCode');
        $tPSHMerCode       = $this->input->post('tMerCode');
        $tPSHPosCode       = $this->input->post('tPosCode');

        $aResultRack     = $this->mPosShop->FSaMPSHGetDataRack();
        $aResultLayout   = $this->mPosShop->FSaMPSHGetDataLayout();
        $aAlwEventPosShop	    = FCNaHCheckAlwFunc('salemachine/0/0'); 
        $this->load->view('pos/posshop/wPosShoplayoutSetting', array(
            'aAlwEventPosShop'  => $aAlwEventPosShop,
            'aPSHBchCode'       => $tPSHBchCode,
            'aPSHShpCode'       => $tPSHShpCode,
            'aPSHMerCode'       => $tPSHMerCode,
            'aResultRack'       => $aResultRack,
            'aResultLayout'     => $aResultLayout,
            'tPSHPosCode'       => $tPSHPosCode
        ));
    }

    //Functionality : Function Call DataTables POS SHOP
    //Parameters : Ajax JSvPSHDataTable Function  Call View DataTable
    //Creator : 05/05/2019 Saharat(Golf)
    //Return : String View
    //Return Type : View
     public function FSvCPSHSettingLayoutDataList(){
        $nPage         = $this->input->post('nPageCurrent');
        $nLangEdit     = $this->session->userdata("tLangEdit");
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        $aData  = array(
            'FTPosCode'     => $this->input->post('tPosCode'),
            'FTBchCode'     => $this->input->post('tBchCode'),
            'FTBchCodeOver' => $this->input->post('tBchCodeOver'),
            'FTShpCode'     => $this->input->post('tShpCode'),
            'FTMerCode'     => $this->input->post('tMerCode'),
            'FTRakCode'     => $this->input->post('tRakCode'),
            'FNLayNo'       => $this->input->post('tLayNo'),
            'FNLayRow'      => $this->input->post('tRow'),
            'FNLayCol'      => $this->input->post('tColumn'),
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit
        );

        $aResList           = $this->mPosShop->FSaMPSHDataList($aData);
        $aAlwEventPost      = FCNaHCheckAlwFunc('salemachine/0/0'); 
        $aGenTable          = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'aAlwEventPosShop'  => $aAlwEventPost,
            'tBchCode'          => $aData['FTBchCode'], 
            'tShpCode'          => $aData['FTShpCode'],
            'tPosCode'          => $aData['FTPosCode']

        );

        // Return Data View
        $this->load->view('pos/posshop/wPosShoplayoutSettingTable',$aGenTable);
    }

    //Functionality : Function Call DataTables POS SHOP
    //Parameters : Ajax Call View DataTable
    //Creator : 11/07/2019 saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCPSHDataList(){ 
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $tBchCode       = $this->input->post('tBchCode');
            $tShpCode       = $this->input->post('tShpCode');
            $tShpType       = $this->input->post('tShpType');

            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtLoc_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tBchCode'      => $tBchCode,
                'tShpCode'      => $tShpCode,
                'tShpType'      => $tShpType
            );   
            switch ($tShpType) {
                case "4":
                    $aPshDataList   = $this->mPosShop->FSaMPSHListType4($aData); 
                    break;
                case "5":
                    $aPshDataList   = $this->mPosShop->FSaMPSHListType5($aData); 
                    break;
                default:
                    $aPshDataList   = $this->mPosShop->FSaMPSHListType4($aData); 
            }
            $aAlwEventPosShop	    = FCNaHCheckAlwFunc('salemachine/0/0');
            $aGenTable  = array(
                'aPshDataList'          => $aPshDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventPosShop'      => $aAlwEventPosShop,
                'tShpType'              => $tShpType
            );
            $this->load->view('pos/posshop/wPosShopDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add POS SHOP
    //Parameters : Ajax Event
    //Creator : 11/07/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPSHAddEvent(){  
        try{
            $tBCHCode       = $this->input->post('oetPshPSHBchCode');
            $aBranchCode    = explode(",",$tBCHCode);
            $nCountBranch   = FCNnHSizeOf($aBranchCode);
            for($i=0; $i<$nCountBranch; $i++){
                $aData   = array(
                    'FTBchCode'     => trim($aBranchCode[$i]),
                    'FTShpCode'     => $this->input->post('oetPshPSHShpCod'),
                    'tShpName'      => $this->input->post('oetShpName'),
                    'FTPosCode'     => $this->input->post('oetPosCodeSN'),
                    'FTPosCodeOld' => $this->input->post('oetPosCodeSNOld'),
                    'FTPshPosSN'    => $this->input->post('oetPshPosSN'),
                    'FTPshStaUse'   => $this->input->post('ocmPshStaUse'),
                    'FTPshNetIP'    => $this->input->post('oetPshPosShopIP'),
                    'FTPshNetPort'  => $this->input->post('oetPshPosShopPort'),
                    'tShpType'      => $this->input->post('oetPshPSHShpType'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit"),
                    'FTShpSceLayout'=> $this->input->post('ocmPshStaSceLayout')
                );
                $this->db->trans_begin();
                switch ($aData['tShpType']) {
                    case "4":
                            $this->mPosShop->FSaMPSHAddUpdateMasterType4($aData);
                        break;
                    case "5":
                            $this->mPosShop->FSaMPSHAddUpdateMasterType5($aData);
                        break;
                    default:
                            $this->mPosShop->FSaMPSHAddUpdateMasterType4($aData);  
                    }

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add POS SHOP"
                    );
                }else{
                    $this->db->trans_commit();
                    $aDataPosShop = array(
                        'FTShpCode'     => $aData['FTShpCode'],
                        'FTBchCode'     => $aData['FTBchCode'],
                        'FTPosCode'     => $aData['FTPosCode'],
                        'FTPshStaUse'   => $aData['FTPshStaUse']
                    );
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataPosShop,
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add POS SHOP'
                    );
                }
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit POS SHOP
    //Parameters : Ajax Event
    //Creator :     08/07/2019 saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPSHEditEvent(){  
        try{
            $aData   = array(
                'FTBchCode'     => $this->input->post('oetPshPSHBchCode'),
                'FTShpCode'     => $this->input->post('oetPshPSHShpCod'),
                'tShpName'      => $this->input->post('oetShpName'),
                'FTPosCode'     => $this->input->post('oetPosCodeSN'),
                'FTPosCodeOld' => $this->input->post('oetPosCodeSNOld'),
                'FTPshPosSN'    => $this->input->post('oetPshPosSN'),
                'FTPshStaUse'   => $this->input->post('ocmPshStaUse'),
                'FTPshNetIP'    => $this->input->post('oetPshPosShopIP'),
                'FTPshNetPort'  => $this->input->post('oetPshPosShopPort'),
                'tShpType'      => $this->input->post('oetPshPSHShpType'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTShpSceLayout'=> $this->input->post('ocmPshStaSceLayout')
            );
            $this->db->trans_begin();
            switch ($aData['tShpType']) {
                case "4":
                        $this->mPosShop->FSaMPSHAddUpdateMasterType4($aData);
                    break;
                case "5":
                        $this->mPosShop->FSaMPSHAddUpdateMasterType5($aData);
                    break;
                default:
                        $this->mPosShop->FSaMPSHAddUpdateMasterType4($aData); 
                }
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update POS SHOP"
                );
            }else{
                $this->db->trans_commit();
                $aDataPosShop = array(
                    'FTShpCode'     => $aData['FTShpCode'],
                    'FTBchCode'     => $aData['FTBchCode'],
                    'FTPosCode'     => $aData['FTPosCode'],
                    'FTPshStaUse'   => $aData['FTPshStaUse']
                );
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPosShop,
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update POS SHOP'
                );
            }
        echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete POS SHOP
    //Parameters : Ajax jReason()
    //Creator : 09/07/2019 Saharat(Golf)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPSHDeleteEvent(){ 

        $tBchCode   = $this->input->post('FTBchCode');
        $tShpCode   = $this->input->post('FTShpCode');
        $tPosCode   = $this->input->post('FTPosCode');
        $tShpType   = $this->input->post('tShpType');

        $aDataMaster = array(
            'FTBchCode'    => $tBchCode,
            'FTShpCode'    => $tShpCode,
            'FTPosCode'    => $tPosCode
        );
        
        switch ($tShpType) {
            case "4":
                        $aResDel    = $this->mPosShop->FSaMPSHDelAllType4($aDataMaster);
                break;
            case "5":
                        $aResDel    = $this->mPosShop->FSaMPSHDelAllType5($aDataMaster);
                break;
            default:
                        $aResDel    = $this->mPosShop->FSaMPSHDelAllType4($aDataMaster);
        }



        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    //Functionality : Function CallPage POS SHOP Edits
    //Parameters : Ajax Call View Edit
    //Creator : 13/02/2019 Napat(Jame)
    //Return : String View
    //Return Type : View
    public function FSvCPSHEditPage(){  
        try{
            $FTBchCode      = $this->input->post('tBchCode');
            $FTShpCode      = $this->input->post('tShpCode');
            $FTPosCode      = $this->input->post('tPosCode');
            $tShpType      = $this->input->post('tShpType');

            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtLoc_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTBchCode' => $FTBchCode,
                'FTShpCode' => $FTShpCode,
                'FTPosCode' => $FTPosCode,
                'FNLngID'   => $nLangEdit,
                'tShpType'  => $tShpType 
            );                     
            $aPosShopData   = $this->mPosShop->FSaMPSHGetDataByID($aData);
            $aDataPsh       = array(
                'nStaAddOrEdit' => 1,
                'aPshData'      => $aPosShopData
            );
            $this->load->view('pos/posshop/wPosShopEdit',$aDataPsh);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Edit inline 
    public function FSvCPSHEditInLinePageShop(){
        try{
            $pnSHOP             = $this->input->post('pnSHOP');
            $OldPosCode         = $this->input->post('OldPosCode');
            $OldSN              = $this->input->post('OldSN');
            $OldStatus          = $this->input->post('OldStatus');
            $NewPosCode         = $this->input->post('NewPosCode');
            $NewPosSN           = $this->input->post('NewPosSN');
            $NewPosStatus       = $this->input->post('NewPosStatus');

            if($OldPosCode == $NewPosCode && $OldSN == $NewPosSN && $OldStatus == $NewPosStatus){
                echo 'original';
            }else{
                $aData  = array(
                    'FTShpCode'     => $pnSHOP,
                    'FTPosCode'     => $NewPosCode,
                    'FTPshPosSN'    => $NewPosSN,
                    'FTPshStaUse'   => $NewPosStatus,
                    'FDLastUpdOn'   => date('Y-m-d'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'OldPosCode'    => $OldPosCode
                );                     
                $aPosShopData   = $this->mPosShop->FSaMPSHCheckDatabeforeUpdate($aData);
                if(empty($aPosShopData)){
                    $this->mPosShop->FSaMPSHUpdateDataInline($aData);
                }else{
                    if($OldPosCode == $NewPosCode){
                        $this->mPosShop->FSaMPSHUpdateDataInline($aData);
                    }else{
                        echo 'duplicate';
                    }
                }
                // echo print_r($aPosShopData);
            }

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Get Data ShopPost Layout
    //Parameters : Ajax Function FSaPSHSettingChannel  
    //Creator : 08/07/2019 saharat(Golf)
    //Return : array
    //Return Type : array
    function FSvCPSHSettingLayoutCheckData(){
        $tBchCode    = $this->input->post('tBchCode');
        $tShpCode    = $this->input->post('tShpCode');
        $tPosCode    = $this->input->post('tPosCode');
        $tLayNoCode  = $this->input->post('tLayNoCode');

        $aData     = array(
            'FTBchCode' => $tBchCode,
            'FTShpCode' => $tShpCode,
            'FNLayNo'   => $tLayNoCode,
            'FTPosCode' => $tPosCode,
       
        );
        $aResult   = $this->mPosShop->FSaMPSHGetDataSetting($aData);
        echo json_encode($aResult); 
    }

    //Functionality : Function Add Data ShopPost Layout
    //Parameters : Ajax Function FSaPSHSettingChannel  
    //Creator :   08/07/2019 saharat(Golf)
    //Return : array
    //Return Type : array
    function FSvCPSHSettingLayoutEventAdd(){
        $aData     = array(
            'FTPosCode'     => $this->input->post('tPosCode'),
            'FTBchCode'     => $this->input->post('tBchCode'),
            'FTShpCode'     => $this->input->post('tShpCode'),
            // 'FTPosCode'     => $this->input->post('tPosCode'),
            'FNLayNo'       => $this->input->post('tLnoCode'),
            'FNLayBoardNo'  => $this->input->post('tBoardnum'),
            'FTLayBoxNo'    => $this->input->post('tChannelCode')
        );
        $aResult   = $this->mPosShop->FSaMPSHUpdateMaster($aData);
        if($aResult['rtCode'] == 1 ){
            $aStatus  = array(
                'FTBchCode' => $aData['FTBchCode'],
                'rtCode'    => $aResult['rtCode'],
                'rtDesc'    => $aResult['rtDesc'],
            );
        }
        echo json_encode($aStatus); 
    }


    //Functionality : Event Add EDC
    //Parameters : Ajax Event
    //Creator : 11/07/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSoEdcAddEvent(){  
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataMaster = array(
                'tIsAutoGenCode'    => $this->input->post('ocbEdcAutoGenCode'),
                'FTEdcCode'         => $this->input->post('oetEdcCode'),
                'FTSedCode'         => $this->input->post('oetEdcCodeBrowse'),
                'FTBnkCode'         => $this->input->post('oetBnkCode'),
                'FTEdcShwFont'      => $this->input->post('oetShwFont'),
                'FTEdcShwBkg'       => $this->input->post('oetEdcShwBkg'),
                'FTEdcOther'        => $this->input->post('oetEdcOther'),
                'FTEdcRmk'          => $this->input->post('otaEdcRemark'),
                'FTEdcName'         => $this->input->post('oetEdcName'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            );
     
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
                // Auto Gen EDC Code
                $aStoreParam = array(
                    "tTblName"    => 'TFNMEdc',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTEdcCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TFNMEdc','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTEdcCode'] = $aGenCode['rtEdcCode'];
                // }
            }
            $oCountDup  = $this->mPosShop->FSnMEdcCheckDuplicate($aDataMaster['FTEdcCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mPosShop->FSaMEdcAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mPosShop->FSaMEdcAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTEdcCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
    

}