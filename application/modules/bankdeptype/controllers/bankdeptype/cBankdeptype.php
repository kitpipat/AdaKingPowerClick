<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBankdeptype extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('bankdeptype/bankdeptype/mBankdeptype');
    }
      
    /*
    //Functionality : Function CallGetdata list
    //Parameters : 
    //Creator : nonpawich
    //Last Modified : -
    //Return :  View
    //Return Type : View
    */
    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aAlwEventBankdeptype']   = FCNaHCheckAlwFunc('bankdeptype/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('bankdeptype/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        
        $this->load->view('bankdeptype/bankdeptype/wBankdeptype',$aData);
    }

    
    /*
    //Functionality : Function CallGetdata list
    //Parameters : 
    //Creator : nonpawich
    //Last Modified : -
    //Return :  View
    //Return Type : View
    */
    public function FSxCBDTGetDatalist(){


        $aAlwEvent	= FCNaHCheckAlwFunc('bankdeptype/0/0');
        $aNewData  			= array( 'aAlwEvent' => $aAlwEvent);

        $this->load->view('bankdeptype/bankdeptype/wBankdeptypelist',$aNewData);

    }

    public function FSxCBDTAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TFNMBnkDepType_L');
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

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );

        $this->load->view('bankdeptype/bankdeptype/wBankdeptypeAdd',$aDataAdd);
    }


    public function FSxCBNKFormSearchList(){
           $this->load->view('bankdeptype/bankdeptype/wBankFormSearchList');
    }

    
    //Functionality : Event Add District
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCBDTAddEvent(){
        try{

            $aDataMaster = array(
                'FTBdtCode'     => $this->input->post('oetBdtCode'),
                'FTBdtName'     => $this->input->post('oetBdtName'),
                'FDLastUpdOn'   => date('Y-m-d'),
                'FTLastUpdBy'   =>  $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d'),
                'FTCreateBy'    =>  $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetBDTUsrAgnCode'),
                'tIsAutoGenCode' => $this->input->post('ocbBdtAutoGenCode'),
            );

       

            
             // Check Auto Gen Code?
             if ($aDataMaster['tIsAutoGenCode'] == '1') {
                // 15/05/2020 Nattakit(Nale)
                $aStoreParam = array(
                    "tTblName"    => 'TFNMBnkDepType',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                              
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")  
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);

                $aDataMaster['FTBdtCode'] =  $aAutogen[0]["FTXxhDocNo"];

            }

            $oCountDup  = $this->mBankdeptype->FSnMBDTCheckDuplicate($aDataMaster['FTBdtCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mBankdeptype->FSaMBDTAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mBankdeptype->FSaMBDTAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event 1"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTBdtCode'],
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

    //Functionality : Event Edit Bank
    //Parameters : Ajax jReason()
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCBNKEditEvent(){
        try{
            $aDataMaster = array(
                'tIsAutoGenCode'    => $this->input->post('ocbBdtAutoGenCode'),
                'FTBdtCode' => $this->input->post('oetBdtCode'),
                'FTBdtName' => $this->input->post('oetBdtName'),
                'FDLastUpdOn' => date('Y-m-d'),
                'FTLastUpdBy' =>  $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d'),
                'FTCreateBy' =>  $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),

                'FTAgnCode'     => $this->input->post('oetBDTUsrAgnCode'),
            );

            $this->db->trans_begin();
            $aStaEventMaster  = $this->mBankdeptype->FSaMBDTAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mBankdeptype->FSaMBDTAddUpdateLang($aDataMaster);
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
                    'tCodeReturn'	=> $aDataMaster['FTBdtCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }


    //Functionality : Event Delete Bank
    //Parameters : Ajax jReason()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCBDTDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTBdtCode' => $tIDCode
        );

        $aResDel        = $this->mBankdeptype->FSnMBDTDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


    public function FSvCBDTEditPage(){

		$aAlwEventBankdeptype	= FCNaHCheckAlwFunc('bankdeptype/0/0'); //Controle Event

        $tBdtCode       = $this->input->post('tBdtCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMBnkDepType_L');
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
	            $nLangEdit = $nLangEdit;
	        }
        }
        
        $aData  = array(
            'FTBdtCode' => $tBdtCode,
            'FNLngID'   => $nLangEdit
        );

        $aDstData       = $this->mBankdeptype->FSaMBDTSearchByID($aData);
        $aDataEdit      = array('aResult'       => $aDstData,
                                'aAlwEventBankdeptype' => $aAlwEventBankdeptype
                            );
        $this->load->view('bankdeptype/bankdeptype/wBankdeptypeAdd',$aDataEdit);

    }


	//Functionality : Function Call DataTables Bank
    //Parameters : Ajax jBranch()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCBDTDataTable(){

        $aAlwEventBankdeptype = FCNaHCheckAlwFunc('bankdeptype/0/0'); //Controle Event
        
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TFNMBnkDepType_L');
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

        $aResList   = $this->mBankdeptype->FSaMBDTListBDT($aData);
        $aGenTable  = array(

            'aAlwEventBankdeptype' => $aAlwEventBankdeptype,
            'aDataList' => $aResList,
            'nPage'     => $nPage,
            'tSearchAll'    => $tSearchAll
        );

        $this->load->view('bankdeptype/bankdeptype/wBankdeptypeTable',$aGenTable);
    }


}    
?>

