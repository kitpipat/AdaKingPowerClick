<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cProvince extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('address/province/mProvince');
    }
    
    public function index($nPvnBrowseType,$tPvnBrowseOption){
        $nMsgResp = array('title'=>"Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('province/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน

        $aAlwEventProvince	= FCNaHCheckAlwFunc('province/0/0');
        $this->load->view ( 'address/province/wProvince', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPvnBrowseType'    => $nPvnBrowseType,
            'tPvnBrowseOption'  => $tPvnBrowseOption,
            'aAlwEventProvince' => $aAlwEventProvince
        ));
    }

    //Functionality : Function Call Province Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 14/05/2018 wasin
    //Last Modified : 30/05/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvPVNListPage(){
        $aAlwEventProvince	= FCNaHCheckAlwFunc('province/0/0');
		$aNewData  			= array( 'aAlwEventProvince' => $aAlwEventProvince );
        $this->load->view('address/province/wProvinceList',$aNewData);
    }

    //Functionality : Function Call DataTables Province List
    //Parameters : Ajax jProvince()
    //Creator : 30/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvPVNDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMProvince_L');
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
        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList   = $this->mProvince->FSaMPVNList($tAPIReq,$tMethodReq,$aData);
      
        $aAlwEvent = FCNaHCheckAlwFunc('province/0/0'); //Controle Event
        $aGenTable  = array(
            'aAlwEventProvince' 	=> $aAlwEvent,
            'aDataList'             => $aResList,
            'nPage'                 => $nPage,
            'tSearchAll'            => $tSearchAll
        );
        $this->load->view('address/province/wProvinceDataTable',$aGenTable);
    }
    
    //Functionality : Function CallPage Province Add
    //Parameters : Ajax jProvince()
    //Creator : 14/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvPVNAddPage(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TCNMProvince_L');
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
        $this->load->view('address/province/wProvinceAdd',$aDataAdd);
    }
    
    //Functionality : Function CallPage Province Edit
    //Parameters : Ajax jProvince()
    //Creator : 14/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvPVNEditPage(){
        $tPvnCode = $this->input->post('tPvnCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TCNMProvince_L');
        $nLangHave = FCNnHSizeOf($aLangHave);
        if($nLangHave > 1){
            if($nLangEdit != ''){
                $nLangEdit = $nLangEdit;
            }else{
                $nLangEdit = $nLangResort;
            }
        }else{
            $nLangEdit = $aLangHave[0]->nLangList;
        }
        
        $aData  = array(
            'FTPvnCode' => $tPvnCode,
            'FNLngID'   => $nLangEdit
        );
        
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aPvnData       = $this->mProvince->FSaMPVNSearchByID($tAPIReq,$tMethodReq,$aData);
        $aDataEdit      = array('aResult' => $aPvnData);
        $this->load->view('address/province/wProvinceAdd',$aDataEdit);
        
    }
    
    //Functionality : Event Add Province
    //Parameters : Ajax jProvince()
    //Creator : 14/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaPVNAddEvent(){
        try{
            
            $tIsAutoGenCode =   $this->input->post('ocbPvnAutoGenCode');

            $tPvnCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                // Call helper for GenCode
                $aStoreParam = array(
                    "tTblName"    => 'TCNMProvince',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tPvnCode   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMProvince'); 
                // if($aGenCode['rtCode'] == '1'){
                //     $tPvnCode = $aGenCode['rtPvnCode'];
                // }
            }else{
                $tPvnCode = $this->input->post('oetPvnCode');
            }
            $aDataMaster = array(
                'FTPvnCode'         => $tPvnCode,
                'FTZneCode'         => $this->input->post('oetPvnZnecode'),
                'FTPvnName'         => $this->input->post('oetPvnName'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit")
            );

    
            $oCountDup  = $this->mProvince->FSnMPVNCheckDuplicate($aDataMaster['FTPvnCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaPvnMaster  = $this->mProvince->FSaMPVNAddUpdateMaster($aDataMaster);
                $aStaPvnLang    = $this->mProvince->FSaMPVNAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTPvnCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => language('common/main/main','tDataDuplicate')
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
    
    //Functionality : Event Edit Province
    //Parameters : Ajax jProvince()
    //Creator : 14/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaPVNEditEvent(){
        try{
            $aDataMaster = array(
                'FTPvnCode'     => $this->input->post('oetPvnCode'),                
                'FTZneCode'     => $this->input->post('oetPvnZnecode'),
                'FTPvnName'     => $this->input->post('oetPvnName'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $this->db->trans_begin();
            $aStaPvnMaster  = $this->mProvince->FSaMPVNAddUpdateMaster($aDataMaster);
            $aStaPvnLang    = $this->mProvince->FSaMPVNAddUpdateLang($aDataMaster);
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
                    'tCodeReturn'	=> $aDataMaster['FTPvnCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
    
    //Functionality : Event Delete Province
    //Parameters : Ajax jProvince()
    //Creator : 14/05/2018 wasin
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaPVNDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPvnCode' => $tIDCode
        );
        $tAPIReq        = 'API/Reason/Delete';
        $tMethodReq     = 'POST';
        $aResDel        = $this->mProvince->FSnMPVNDel($tAPIReq,$tMethodReq,$aDataMaster);
        $nNumRowPvnLoc  = $this->mProvince->FSnMLOCGetAllNumRow();

        if($nNumRowPvnLoc){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }
    }
    
}