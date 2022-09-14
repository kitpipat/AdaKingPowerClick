<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtSize extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtsize/mPdtSize');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPszBrowseType,$tPszBrowseOption){
        $nMsgResp   = array('title'=>"Product Size");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('pdtsize/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtSize	    = FCNaHCheckAlwFunc('pdtsize/0/0');
        $this->load->view('product/pdtsize/wPdtSize', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPszBrowseType'    => $nPszBrowseType,
            'tPszBrowseOption'  => $tPszBrowseOption,
            'aAlwEventPdtSize'  => $aAlwEventPdtSize
        ));
    }

    //Functionality : Function Call Product Size Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPSZListPage(){ 
        $aAlwEventPdtSize	    = FCNaHCheckAlwFunc('pdtsize/0/0'); 
        $this->load->view('product/pdtsize/wPdtSizeList', array(
            'aAlwEventPdtSize'  => $aAlwEventPdtSize
        ));
    }

    
    //Functionality : Function Call DataTables Product Size
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPSZDataList(){ 
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtSize_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave != ""){
            //     if($nLangHave > 1){
            //         $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            //     }else{
            //         $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            //     }
            // }

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );

            $aPszDataList           = $this->mPdtSize->FSaMPSZList($aData); 
            $aAlwEventPdtSize	    = FCNaHCheckAlwFunc('pdtsize/0/0');
            $aGenTable  = array(
                'aPszDataList'      => $aPszDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventPdtSize'  => $aAlwEventPdtSize
            );
            $this->load->view('product/pdtsize/wPdtSizeDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Size Add
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPSZAddPage(){
        try{
            $aDataPdtSize = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('product/pdtsize/wPdtSizeAdd',$aDataPdtSize);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Product Size Edits
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPSZEditPage(){  
        try{
            $tPszCode       = $this->input->post('tPszCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtSize_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave != ""){
            //     if($nLangHave > 1){
            //         $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            //     }else{
            //         $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            //     }
            // }
            $aData  = array(
                'FTPszCode' => $tPszCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aPszData       = $this->mPdtSize->FSaMPSZGetDataByID($aData);
            $aDataPdtSize   = array(
                'nStaAddOrEdit' => 1,
                'aPszData'      => $aPszData
            );
            $this->load->view('product/pdtsize/wPdtSizeAdd',$aDataPdtSize);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Add Product Size
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPSZAddEvent(){  
        try{
            $aDataPdtSize   = array(
                'tIsAutoGenCode' => $this->input->post('ocbPszAutoGenCode'),
                'FTPszCode' => $this->input->post('oetPszCode'),
                'FTPszName' => $this->input->post('oetPszName'),
                'FTPszRmk'  => $this->input->post('otaPszRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetPszAgnCode')
            );
       
            if($aDataPdtSize["tIsAutoGenCode"] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode   = FCNaHGenCodeV5('TCNMPdtSize','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtSize["FTPszCode"]    =   $aGenCode['rtPszCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtSize',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtSize["FTPszCode"]   = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup      = $this->mPdtSize->FSnMPSZCheckDuplicate($aDataPdtSize['FTPszCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaPszMaster  = $this->mPdtSize->FSaMPSZAddUpdateMaster($aDataPdtSize);
                $aStaPszLang    = $this->mPdtSize->FSaMPSZAddUpdateLang($aDataPdtSize);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Product Size"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataPdtSize['FTPszCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Product Size'
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


    //Functionality : Event Edit Product Size
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPSZEditEvent(){  
        try{
            $this->db->trans_begin();
            $aDataPdtSize   = array(
                'FTPszCode' => $this->input->post('oetPszCode'),
                'FTPszName' => $this->input->post('oetPszName'),
                'FTPszRmk'  => $this->input->post('otaPszRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetPszAgnCode')
            );
            $aStaPszMaster  = $this->mPdtSize->FSaMPSZAddUpdateMaster($aDataPdtSize);
            $aStaPszLang    = $this->mPdtSize->FSaMPSZAddUpdateLang($aDataPdtSize);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Size"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtSize['FTPszCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Size'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete Product Size
    //Parameters : Ajax jReason()
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPSZDeleteEvent(){ 
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPszCode' => $tIDCode
        );
        $aResDel    = $this->mPdtSize->FSaMPSZDelAll($aDataMaster);
        $nNumRowPsz = $this->mPdtSize->FSnMPGPGetAllNumRow();
        if($nNumRowPsz!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPsz' => $nNumRowPsz
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

}