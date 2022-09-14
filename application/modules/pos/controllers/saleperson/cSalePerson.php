<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSalePerson extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/saleperson/mSalePerson');
        $this->load->model('company/shop/mShop');
        $this->load->model('company/branch/mBranch');
    }
    
    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function index($nSpnBrowseType, $tSpnBrowseOption){
        $nMsgResp = array('title'=>"Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('department/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view ( 'pos/saleperson/wSalePerson', array (
            'nMsgResp'=>$nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nSpnBrowseType'=>$nSpnBrowseType,
            'tSpnBrowseOption'=>$tSpnBrowseOption
        ));
    }
    
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSPNListPage(){
        $this->load->view('pos/saleperson/wSalePersonList');
    }

    /**
     * Functionality : Function Call DataTables SalePerson
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSPNDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TCNMSpn_L');
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
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mSalePerson->FSaMSPNList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('pos/saleperson/wSalePersonDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage SalePerson Add
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSPNAddPage(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TCNMSpn_L');
        $nLangHave = FCNnHSizeOf($aLangHave);
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
            'FNLngID'   => $nLangEdit,
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        
        $this->load->view('pos/saleperson/wSalePersonAdd',$aDataAdd);
    }
    
    /**
     * Functionality : Function CallPage SalePerson Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : 20/09/2019 Wasin(Yoshi)
     * Return : String View
     * Return Type : View
    */
    public function FSvSPNEditPage(){
        $tSpnCode       = $this->input->post('tSpnCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMSpn_L');
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
            'FTSpnCode' => $tSpnCode,
            'FNLngID'   => $nLangEdit
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aSpnData       = $this->mSalePerson->FSaMSPNSearchByID($tAPIReq, $tMethodReq, $aData);
        if(isset($aSpnData['raItems']['rtImgObj']) && !empty($aSpnData['raItems']['rtImgObj'])){
            $tImgObj        = $aSpnData['raItems']['rtImgObj'];
            $aImgObj        = explode("application/modules/",$tImgObj);
            $aImgObjName    = explode("/",$tImgObj);
            $tImgObjAll		= $aImgObj[1];
            $tImgName		= end($aImgObjName);
        }else{
            $tImgObjAll     = "";
            $tImgName       = "";
        }
        $aDataEdit  = [
            'tImgName'      => $tImgName,
            'tImgObjAll'    => $tImgObjAll,
            'aResult'       => $aSpnData
        ];
        $this->load->view('pos/saleperson/wSalePersonAdd', $aDataEdit);
    }
    
    /**
     * Functionality : Event Add SalePerson
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : 20/09/2019 Wasin(Yoshi)
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaSPNAddEvent(){
        /** ========================= Image Input Data ========================= */
        $tImgInputSalePerson    = $this->input->post('oetImgInputSalePerson');
        $tImgInputSalePersonOld = $this->input->post('oetImgInputSalePersonOld');
        /** ========================= Image Input Data ========================= */
        $FTSpnStaShop   = ($this->input->post('oetShopCode') != "") ? "1" : "0";
        $tSpnLevel      = $this->input->post('oetSpnLevel');
        $aDataMaster    = [
            'tIsAutoGenCode'    => $this->input->post('ocbSalePersonAutoGenCode'),
            'FTSpnCode'         => $this->input->post('oetSpnCode'),
            'FTSpnName'         => $this->input->post('oetSpnName'),
            'FTSpnRmk'          => $this->input->post('otaSpnRemark'),
            'FTSpnTel'          => $this->input->post('oetSpnTel'),
            'FTSpnEmail'        => $this->input->post('oetSpnEmail'),
            'FTSpnStaShop'      => $FTSpnStaShop,
            'FDSpnStart'        => $this->input->post('oetUsrDateStart'),
            'FDSpnStop'         => $this->input->post('oetUsrDateStop'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FNLngID'           => $this->session->userdata('tLangEdit')
        ];

        // Setup Reason Code
        if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
            // Auto Gen Reason Code
            // $aGenCode = FCNaHGenCodeV5('TCNMSpn');
            // if($aGenCode['rtCode'] == '1'){
            //     $aDataMaster['FTSpnCode'] = $aGenCode['rtSpnCode'];
            // }

            // Update new gencode
            // 22/05/2020 Napat(Jame)
            $aStoreParam = array(
                "tTblName"    => 'TCNMSpn',                           
                "tDocType"    => 0,                                          
                "tBchCode"    => "",                                 
                "tShpCode"    => "",                               
                "tPosCode"    => "",                     
                "dDocDate"    => date("Y-m-d")       
            );
            $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
            $aDataMaster['FTSpnCode']   = $aAutogen[0]["FTXxhDocNo"];
        }
        
        // Level filter
        if($tSpnLevel == 1){ // Branch level : 1
            $aDataMaster['FTBchCode'] = $this->input->post('oetBchCode');
            $aDataMaster['FTShpCode'] = NULL;
        }else{ // Shop level : 2
            $tShopCode = $this->input->post('oetShpCode');
            
            $aShop = ['FTShpCode' => $tShopCode, 'FNLngID' => $aDataMaster['FNLngID']];
            $tBchCode = $this->mShop->FSaMSHPSearchByID($aShop)['roItem']['rtBchCode'];
            
            $aDataMaster['FTBchCode'] = $tBchCode;
            $aDataMaster['FTShpCode'] = $tShopCode;
        }
        // print_r($aDataMaster);
        // exit;
        $oCountDup  = $this->mSalePerson->FSoMSPNCheckDuplicate($aDataMaster['FTSpnCode']);
        $nStaDup    = $oCountDup[0]->counts;
        if($nStaDup == 0){
            $this->db->trans_begin();
            $this->mSalePerson->FSaMSPNAddUpdateMaster($aDataMaster);
            $this->mSalePerson->FSaMSPNAddUpdateLang($aDataMaster);
            $this->mSalePerson->FSaMSPNAddUpdateGroup($aDataMaster);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                // Insert image
                if($tImgInputSalePerson != $tImgInputSalePersonOld){
                    $aImageData = array(
                        'tModuleName'       => 'pos',
                        'tImgFolder'        => 'saleperson',
                        'tImgRefID'         => $aDataMaster['FTSpnCode'],
                        'tImgObj'           => $tImgInputSalePerson,
                        'tImgTable'         => 'TCNMSpn',
                        'tTableInsert'      => 'TCNMImgPerson',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    FCNnHAddImgObj($aImageData);
                }
                // Set return
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTSpnCode'],
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
    }

    /**
     * Functionality : Event Edit SalePerson
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : 20/09/2019 Wasin(Yoshi)
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaSPNEditEvent(){
        /** ========================= Image Input Data ========================= */
        $tImgInputSalePerson    = $this->input->post('oetImgInputSalePerson');
        $tImgInputSalePersonOld = $this->input->post('oetImgInputSalePersonOld');
        /** ========================= Image Input Data ========================= */
        $FTSpnStaShop = ($this->input->post('oetShopCode') != "") ? "1" : "0";
        $tSpnLevel = $this->input->post('oetSpnLevel');
        $aDataMaster = array(
            'FTImgObj'      => $this->input->post('oetImgInputSalePerson'),
            'FTSpnCode'     => $this->input->post('oetSpnCode'),
            'FTSpnName' => $this->input->post('oetSpnName'),
            'FTSpnRmk' => $this->input->post('otaSpnRemark'),
            'FTSpnTel'      => $this->input->post('oetSpnTel'),
            'FTSpnEmail'    => $this->input->post('oetSpnEmail'),
            
            'FTSpnStaShop'  => $FTSpnStaShop,
            'FDSpnStart'    => $this->input->post('oetUsrDateStart'),
            'FDSpnStop'     => $this->input->post('oetUsrDateStop'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FTCreateBy'   => $this->session->userdata('tSesUsername'),
            'FDCreateOn'   => date('Y-m-d H:i:s'),
            'FNLngID'       => $this->session->userdata('tLangEdit')
        );
        
        // Level filter
        if($tSpnLevel == 1){ // Branch level : 1
            $aDataMaster['FTBchCode'] = $this->input->post('oetBchCode');
            $aDataMaster['FTShpCode'] = NULL;
        }else{ // Shop level : 2
            $tShopCode = $this->input->post('oetShpCode');
            
            $aShop = ['FTShpCode' => $tShopCode, 'FNLngID' => $aDataMaster['FNLngID']];
            $tBchCode = $this->mShop->FSaMSHPSearchByID($aShop)['roItem']['rtBchCode'];
            
            $aDataMaster['FTBchCode'] = $tBchCode;
            $aDataMaster['FTShpCode'] = $tShopCode;
        }
        
        $this->db->trans_begin();
        $this->mSalePerson->FSaMSPNAddUpdateMaster($aDataMaster);
        $this->mSalePerson->FSaMSPNAddUpdateLang($aDataMaster);
        $this->mSalePerson->FSaMSPNAddUpdateGroup($aDataMaster);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add Event"
            );
        }else{
            $this->db->trans_commit();
            // Edit Image
            if($tImgInputSalePerson != $tImgInputSalePersonOld){
                $aImageData = array(
                    'tModuleName'       => 'pos',
                    'tImgFolder'        => 'saleperson',
                    'tImgRefID'         => $aDataMaster['FTSpnCode'],
                    'tImgObj'           => $tImgInputSalePerson,
                    'tImgTable'         => 'TCNMSpn',
                    'tTableInsert'      => 'TCNMImgPerson',
                    'tImgKey'           => 'main',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
                );
                FCNnHAddImgObj($aImageData);
            }
            $aReturn = array(
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'	=> $aDataMaster['FTSpnCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Add Event'
            );
        }
        echo json_encode($aReturn);
    }
    
    /**
     * Functionality : Event Delete SalePerson
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    // public function FSaSPNDeleteEvent(){
    //     $tIDCode = $this->input->post('tIDCode');
    //     $aDataMaster = array(
    //         'FTSpnCode' => $tIDCode
    //     );

    //     $aResDel = $this->mSalePerson->FSnMSPNDel($aDataMaster);
    //     $aReturn = array(
    //         'nStaEvent' => $aResDel['rtCode'],
    //         'tStaMessg' => $aResDel['rtDesc']
    //     );
    //     echo json_encode($aReturn);
    // }


   
    /**
     * Functionality : Function Event Multi Delete
     * Parameters : Ajax Function Delete SalePerson
     * Creator : 04/08/2018 piya
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : oject
     */
    // public function FSoSPNDeleteMulti(){
    //     $tSpnCode = $this->input->post('tSpnCode');
      
    //     $aSpnCode = json_decode($tSpnCode);
    //     foreach($aSpnCode as $oSpnCode){
    //         $aSpn = ['FTSpnCode' => $oSpnCode];
    //         $this->mSalePerson->FSnMSPNDel($aSpn);
    //     }
    //     echo json_encode($aSpnCode);
    // }
    
    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 27/08/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoSPNDelete(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTSpnCode' => $tIDCode
        );
        $aResDel        =  $this->mSalePerson->FSnMSPNDel($aDataMaster);
        $nNumRowSpnLoc  =  $this->mSalePerson->FSnMLOCGetAllNumRow();

        if($aResDel['rtCode'] == 1){
            $aDeleteImage = array(
                'tModuleName'	=> 'pos',
                'tImgFolder'    => 'saleperson',
                'tImgRefID'     =>  $tIDCode,
                'tTableDel'     => 'TCNMImgObj',
                'tImgTable'     => 'TCNMSpn'
            );
            $nStaDelImgInDB  = FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }

        if($nNumRowSpnLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowSpnLoc' => $nNumRowSpnLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }
    }
}