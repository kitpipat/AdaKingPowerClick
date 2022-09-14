<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSetprinter extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/setprinter/mSetprinter');
    }
    
    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy Supawat
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function index($nSprBrowseType, $tSprBrowseOption){
        $aDataConfigView    = array(
            'nSprBrowseType'    => $nSprBrowseType,
            'tSprBrowseOption'  => $tSprBrowseOption,
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('setprinter/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view ( 'pos/setprinter/wSetprinter',$aDataConfigView);
    }
    
    /**
     * Functionality : Function Call Set Printer Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCSPRListPage(){
        $this->load->view('pos/setprinter/wSetprinterList');
    }

    /**
     * Functionality : Function Call DataTables Printer
     * Parameters : Ajax and Function Parameter
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCSPRDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    // $aLangHave      = FCNaHGetAllLangByTable('TCNMPrinter_L');
        // $nLangHave      = FCNnHSizeOf($aLangHave);
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => trim($tSearchAll)
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList   = $this->mSetprinter->FSaMSPRList($tAPIReq, $tMethodReq, $aData);
        $aGenTable  = array(
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('pos/setprinter/wSetprinterDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Printer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCSPRAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMPrinter_L');
        // $nLangHave      = FCNnHSizeOf($aLangHave);
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }
        
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        
        $this->load->view('pos/setprinter/wSetprinterAdd',$aDataAdd);
    }
    
    /**
     * Functionality : Function CallPage Printer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCSPREditPage(){
        
        $tSprCode       = $this->input->post('tSprCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMPrinter_L');
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
            'FTPrnCode' => $tSprCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aSpnData       = $this->mSetprinter->FSaMSPRSearchByID($tAPIReq, $tMethodReq, $aData);
        $aDataEdit      = array('aResult' => $aSpnData);
        $this->load->view('pos/setprinter/wSetprinterAdd', $aDataEdit);
    }
    
    /**
     * Functionality : Event Add Printer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCSPRAddEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataMaster    = array(
                'tIsAutoGenCode' => $this->input->post('ocbSetprinerAutoGenCode'),
                'FTPrnCode'     => $this->input->post('oetSprCode'),
                'FTPrnSrcType'  => $this->input->post('ocmSelectSrcType'),
                'FTSppCode'     => $this->input->post('oetSetprinterRef') != "" ? $this->input->post('oetSetprinterRef') : "-",
                'FTPrnDriver'   => '-',
                'FTPrnType'     => $this->input->post('ocmSelectTypePrinter'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTPrnName'     => $this->input->post('oetSprName'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTPrnRmk'      => $this->input->post('oetSprReason')
            );

        
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
                // Auto Gen Department Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPrinter',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTPrnCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMPrinter','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTPrnCode'] = $aGenCode['rtPrnCode'];
                // }
            }

            $oCountDup  = $this->mSetprinter->FSoMSPNCheckDuplicate($aDataMaster['FTPrnCode']);
            $nStaDup    = $oCountDup[0]->counts;


            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaRsnMaster  = $this->mSetprinter->FSaMSPRAddUpdateMaster($aDataMaster);
                $aStaRsnLang    = $this->mSetprinter->FSaMSPRAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'	=> $aDataMaster['FTPrnCode'],
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

    /**
     * Functionality : Event Edit Printer
     * Parameters : Ajax and Function Parameter
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCSPREditEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataMaster    = array(
                'FTPrnCode'     => $this->input->post('oetSprCode'),
                'FTPrnSrcType'  => $this->input->post('ocmSelectSrcType'),
                'FTSppCode'     => $this->input->post('ocmSelectSrcType') == "2" ? "-" : $this->input->post('oetSetprinterRef') ,
                'FTPrnDriver'   => '-',
                'FTPrnType'     => $this->input->post('ocmSelectTypePrinter'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTPrnName'     => $this->input->post('oetSprName'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTPrnRmk'      => $this->input->post('oetSprReason')
            );
            $this->db->trans_begin();
            $aStaRsnMaster  = $this->mSetprinter->FSaMSPRAddUpdateMaster($aDataMaster);
            $aStaRsnLang    = $this->mSetprinter->FSaMSPRAddUpdateLang($aDataMaster);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTPrnCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
    
    /**
     * Functionality : Event Delete Printer
     * Parameters : Ajax and Function Parameter
     * Creator :  28/01/2018 supawat
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSoCSPRDelete(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPrnCode' => $tIDCode
        );
        $aResDel = $this->mSetprinter->FSnMSPRDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


   
    /**
     * Functionality : Function Event Multi Delete 
     * Parameters : Ajax Function Delete SalePerson
     * Creator :  28/01/2018 supawat
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : oject
    */
    public function FSoCSPRDeleteMulti(){
        try{
            $tIDCode = $this->input->post('tIDCode');
            $aDataMaster = array(
                'FTPrnCode' => $tIDCode
            );
            $aResDel = $this->mSetprinter->FSnMSPRDel($aDataMaster);
            $aReturn = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    /**
     * Functionality : Function CallPage modul cardreader
     * Parameters : Ajax and Function Parameter
     * Creator : 12/07/2019 saharat(Golf)
     * Last Modified : -
     * Return : String View
     * Return Type : View
    */
    public function FSvCCRDListPage($nCrdBrowseType,$tCrdBrowseOption){
        $aData = array(
            'nCrdBrowseType'    => $nCrdBrowseType,
            'tCrdBrowseOption'  => $tCrdBrowseOption
        );
        $this->load->view('pos/cardreader/wCardreader',$aData);
    }
    
    /**
     * Functionality : Function CallPage cardreader Add
     * Parameters : Ajax and Function Parameter
     * Creator : 12/07/2019 saharat(Golf)
     * Last Modified : -
     * Return : String View
     * Return Type : View
    */
    public function FSvCCRDPageAdd(){
        $this->load->view('pos/cardreader/wCardreaderAdd');
    }
    
}