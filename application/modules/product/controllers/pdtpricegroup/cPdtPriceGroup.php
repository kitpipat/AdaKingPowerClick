<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtPriceGroup extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtpricegroup/mPdtPriceGroup');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPplBrowseType,$tPplBrowseOption){
        $nMsgResp   = array('title'=>"Product Price Group ");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('pdtpricegroup/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtPrice	    = FCNaHCheckAlwFunc('pdtpricegroup/0/0');

        $this->load->view('product/pdtpricegroup/wPdtPriceGroup', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPplBrowseType'    => $nPplBrowseType,
            'tPplBrowseOption'  => $tPplBrowseOption,
            'aAlwEventPdtPrice' => $aAlwEventPdtPrice
        ));
    }

    //Functionality : Function Call Product Price List Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPPLListPage(){
        $aAlwEventPdtPrice	    = FCNaHCheckAlwFunc('pdtpricegroup/0/0');
        $this->load->view('product/pdtpricegroup/wwPdtPriceGroupList', array(
            'aAlwEventPdtPrice' => $aAlwEventPdtPrice
        ));
    }

    
    //Functionality : Function Call DataTables Product Price List
    //Parameters : Ajax Call View DataTable
    //Creator : 18/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPPLDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtPriList_L');
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
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );

            $aPplDataList           = $this->mPdtPriceGroup->FSaMPPLList($aData);
            $aAlwEventPdtPrice	    = FCNaHCheckAlwFunc('pdtpricegroup/0/0');
            $aGenTable  = array(
                'aPplDataList'          => $aPplDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventPdtPrice'     => $aAlwEventPdtPrice
            );
            $this->load->view('product/pdtpricegroup/wwPdtPriceGroupDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Price List Add
    //Parameters : Ajax Call View Add
    //Creator : 18/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPPLAddPage(){
        try{
            $aDataPdtType = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
            );
            $this->load->view('product/pdtpricegroup/wwPdtPriceGroupAdd',$aDataPdtType);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Product Price List Edits
    //Parameters : Ajax Call View Add
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPPLEditPage(){
        try{
            $tPplCode       = $this->input->post('tPplCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtPriList_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTPplCode' => $tPplCode,
                'FNLngID'   => $nLangEdit
            );

            $aPplData       = $this->mPdtPriceGroup->FSaMPPLGetDataByID($aData);
            $aDataPdtPrice   = array(
                'nStaAddOrEdit' => 1,
                'aPplData'      => $aPplData
            );
            $this->load->view('product/pdtpricegroup/wwPdtPriceGroupAdd',$aDataPdtPrice);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add Product Price List
    //Parameters : Ajax Event
    //Creator : 19/09/2018 Witsarut (Bell)
    //Update : 26/03/2019 pap
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPPLAddEvent(){
        try{
            $aDataPdtPrice   = array(
                'tIsAutoGenCode'    => $this->input->post('ocbPplAutoGenCode'),
                'FTPplCode' => $this->input->post('oetPplCode'),
                'FTPplName' => $this->input->post('oetPplName'),
                'FTPplRmk'  => $this->input->post('otaPplRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit"),
                'FTAgnCode'   => $this->input->post('oetPplAgnCode'),
            );
            // Setup Reason Code
            if($aDataPdtPrice['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode = FCNaHGenCodeV5('TCNMPdtPriList','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtPrice['FTPplCode'] = $aGenCode['rtPplCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtPriList',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtPrice['FTPplCode']  = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup      = $this->mPdtPriceGroup->FSnMPPLCheckDuplicate($aDataPdtPrice['FTPplCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaPplMaster  = $this->mPdtPriceGroup->FSaMPPLAddUpdateMaster($aDataPdtPrice);
                $aStaPplLang    = $this->mPdtPriceGroup->FSaMPPLAddUpdateLang($aDataPdtPrice);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Product Price List"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataPdtPrice['FTPplCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Product Price List'
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


    //Functionality : Event Edit Product Price List
    //Parameters : Ajax Event
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPPLEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataPdtPrice  = array(
                'FTPplCode' => $this->input->post('oetPplCode'),
                'FTPplName' => $this->input->post('oetPplName'),
                'FTPplRmk'  => $this->input->post('otaPplRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),
                'FTAgnCode'   => $this->input->post('oetPplAgnCode'),
            );
            $aStaPplMaster  = $this->mPdtPriceGroup->FSaMPPLAddUpdateMaster($aDataPdtPrice);
            $aStaPplLang    = $this->mPdtPriceGroup->FSaMPPLAddUpdateLang($aDataPdtPrice);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Price List"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtPrice['FTPplCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Price List'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Delete Product Price List
    //Parameters : Ajax jReason()
    //Creator : 19/09/2018 Witsarut(Bell)
    //Update : 1/04/2019 Pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPPLDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPplCode' => $tIDCode
        );
        $aResDel    = $this->mPdtPriceGroup->FSaMPPLDelAll($aDataMaster);
        $nNumRowPdtGrp = $this->mPdtPriceGroup->FSnMPdtGrpGetAllNumRow();
        if($nNumRowPdtGrp!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtGrp' => $nNumRowPdtGrp
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

}