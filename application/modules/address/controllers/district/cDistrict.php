<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cDistrict extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('address/district/mDistrict');
        $this->load->model('address/province/mProvince');
    }
    
    public function index($nDstBrowseType,$tDstBrowseOption){
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave           = FCNaHBtnSaveActiveHTML('district/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventDistrict	= FCNaHCheckAlwFunc('district/0/0');
        
        $this->load->view ( 'address/district/wDistrict', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nDstBrowseType'    => $nDstBrowseType,
            'tDstBrowseOption'  => $tDstBrowseOption,
            'aAlwEventDistrict' => $aAlwEventDistrict
        ));
    }
    
    //Functionality : Function Get District PostCode 
    //Parameters : Ajax Paramiter
    //Creator : 23/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : String Num
    //Return Type : Num
    public function FSnCDSTGetPostCode(){
    	
    	$tDstCode = $this->input->post('tDstCode');
    	
    	$aResult = $this->mDistrict->FSnMDSTGetPostCode($tDstCode);
    	
    	if($aResult['rtCode']=='1'){
    		echo $aResult['raItems']['rtDstPost'];
    	}
    	
    }
    
    //Functionality : Function Call District Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 15/05/2018 wasin
    //Update : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvDSTListPage(){
        $aAlwEventDistrict	= FCNaHCheckAlwFunc('district/0/0');
        $aNewData  			= array( 'aAlwEventDistrict' => $aAlwEventDistrict );
        $this->load->view('address/district/wDistrictList',$aNewData);
    }

    //Functionality : Function Call DataTables District
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvDSTDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TCNMDistrict_L');
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

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aResList       = $this->mDistrict->FSaMDSTList($tAPIReq,$tMethodReq,$aData);
        $aAlwEvent      = FCNaHCheckAlwFunc('district/0/0'); 
        $aGenTable  = array(
            'aAlwEventDistrict' 	=> $aAlwEvent,
            'aDataList'             => $aResList,
            'nPage'                 => $nPage,
            'tSearchAll'            => $tSearchAll
        );
        $this->load->view('address/district/wDistrictDataTable',$aGenTable);
    }

    //Functionality : Function CallPage District Add
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvDSTAddPage(){
        
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TCNMDistrict_L');
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
        
        $this->load->view('address/district/wDistrictAdd',$aDataAdd);
    }
    
    //Functionality : Function CallPage District Edit
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvDSTEditPage(){
        
        $tDstCode       = $this->input->post('tDstCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMDistrict_L');
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
            'FTDstCode' => $tDstCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aDstData       = $this->mDistrict->FSaMDSTSearchByID($tAPIReq,$tMethodReq,$aData);
        $aDataEdit      = array('aResult' => $aDstData);
        $this->load->view('address/district/wDistrictAdd',$aDataEdit);
    }
    
    //Functionality : Event Add District
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaDSTAddEvent(){
        try{

            $tIsAutoGenCode =   $this->input->post('ocbDstAutoGenCode');
            // Setup Reason Code
            $tDstCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName"    => 'TCNMDistrict',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
				 $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
				 $tDstCode = $aAutogen[0]["FTXxhDocNo"];

                //  $aGenCode = FCNaHGenCodeV5('TCNMDistrict');
                //  if($aGenCode['rtCode'] == '1'){
                //     $tDstCode = $aGenCode['rtDstCode'];
                //  }
            }else{
                $tDstCode = $this->input->post('oetDstCode');
            }

            $aDataMaster = array(
                'FTDstCode'         => $tDstCode,
                'FTDstPost'         => $this->input->post('oetDstPost'),
                'FTPvnCode'         => $this->input->post('oetDstPvncode'),
                'FTDstName'         => $this->input->post('oetDstName'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit")
            );

            // print_r($aDataMaster);
            // exit();

            $oCountDup  = $this->mDistrict->FSnMDSTCheckDuplicate($aDataMaster['FTDstCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaDstMaster  = $this->mDistrict->FSaMDSTAddUpdateMaster($aDataMaster);
                $aStaDstLang    = $this->mDistrict->FSaMDSTAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'	=> $aDataMaster['FTDstCode'],
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
    
    //Functionality : Event Edit District
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaDSTEditEvent(){
        try{
            $aDataMaster = array(
                'FTDstCode' => $this->input->post('oetDstCode'),
                'FTDstPost' => $this->input->post('oetDstPost'),
                'FTPvnCode' => $this->input->post('oetDstPvncode'),
                'FTDstName' => $this->input->post('oetDstName'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $this->db->trans_begin();
            $aStaDstMaster  = $this->mDistrict->FSaMDSTAddUpdateMaster($aDataMaster);
            $aStaDstLang    = $this->mDistrict->FSaMDSTAddUpdateLang($aDataMaster);
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
                    'tCodeReturn'	=> $aDataMaster['FTDstCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }
    
    //Functionality : Event Delete District
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaDSTDeleteEvent(){
        try{
            $tIDCode = $this->input->post('tIDCode');
            $aDataMaster = array(
                'FTDstCode' => $tIDCode
            );
            $aResDel    = $this->mDistrict->FSnMDSTDel($aDataMaster);
            $nNumRowDstLoc  = $this->mDistrict->FSnMLOCGetAllNumRow();

            if($nNumRowDstLoc){
                $aReturn    = array(
                    'nStaEvent'     => $aResDel['rtCode'],
                    'tStaMessg'     => $aResDel['rtDesc'],
                    'nNumRowDstLoc' => $nNumRowDstLoc
                );
                echo json_encode($aReturn);
            }else{
                echo "database error";
            }
 
        }catch(Exception $Error){
            echo $Error;
        }

    }
    
    
    
    
    
    

}