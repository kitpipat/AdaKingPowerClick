<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtGroup extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtgroup/mPdtGroup');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPgpBrowseType,$tPgpBrowseOption){
        $nMsgResp   = array('title'=>"Product Group");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('pdtgroup/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtGroup	    = FCNaHCheckAlwFunc('pdtgroup/0/0');

        $this->load->view('product/pdtgroup/wPdtGroup', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPgpBrowseType'    => $nPgpBrowseType,
            'tPgpBrowseOption'  => $tPgpBrowseOption,
            'aAlwEventPdtGroup' => $aAlwEventPdtGroup
        ));
    }
    
    //Functionality : Function Call Product Group Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 17/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPGPListPage(){
        $aAlwEventPdtGroup	    = FCNaHCheckAlwFunc('pdtgroup/0/0');
        $this->load->view('product/pdtgroup/wPdtGroupList', array(
            'aAlwEventPdtGroup' => $aAlwEventPdtGroup
        ));
    }

    //Functionality : Function Call DataTables Product Group
    //Parameters : Ajax Call View DataTable
    //Creator : 18/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPGPDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtGrp_L');
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
            $aPgpDataList           = $this->mPdtGroup->FSaMPGPList($aData);
            $aAlwEventPdtGroup	    = FCNaHCheckAlwFunc('pdtgroup/0/0');
            $aGenTable  = array(
                'aPgpDataList'      => $aPgpDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventPdtGroup' => $aAlwEventPdtGroup
            );
            $this->load->view('product/pdtgroup/wPdtGroupDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Group Page Add
    //Parameters : Ajax Call View Add
    //Creator : 18/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPGPAddPage(){
        try{
            $aDataPdtGroup = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
            );
            $this->load->view('product/pdtgroup/wPdtGroupAdd',$aDataPdtGroup);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Group Page Edit
    //Parameters : Ajax Call View Add
    //Creator : 18/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPGPEditPage(){
        try{
            $tPgpCode       = $this->input->post('tPgpCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtGrp_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTPgpCode' => $tPgpCode,
                'FNLngID'   => $nLangEdit
            );
            $aResult       = $this->mPdtGroup->FSaMPGPGetDataByID($aData);
        
            $aDataPdtGroup  = array(
                'nStaAddOrEdit' => 1,
                'aPgpData'      => $aResult,
                'tImgObjAll'    => $aResult['raItems']['rtFTImgObj'],
            );
            $this->load->view('product/pdtgroup/wPdtGroupAdd',$aDataPdtGroup);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product Group
    //Parameters : Ajax Event
    //Creator : 18/09/2018 wasin
    //Update : 26/03/2019 pap
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPGPAddEvent(){
        try{
            $tSelectRoot    = $this->input->post('ocbPdtGrpSelectRoot');
            $tIsAutoGenCode = $this->input->post('ocbPgpAutoGenCode');
            $nLngID         = $this->session->userdata("tLangEdit");

            $tImgInputPdtGrpParentOld = $this->input->post('oetImgInputPdtGrpParentOld');
            $tImgInputPdtGrpParent    = $this->input->post('oetImgInputPdtGrpParent');

            // Setup Reason Code
            $tPgpCodeAutoGen    =  "";
            if($tIsAutoGenCode == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode   = FCNaHGenCodeV5('TCNMPdtGrp');
                // if($aGenCode['rtCode'] == '1'){
                //     $tPgpCodeAutoGen    =   $aGenCode['rtPgpCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtGrp',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen           = FCNaHAUTGenDocNo($aStoreParam);
                $tPgpCodeAutoGen    = $aAutogen[0]["FTXxhDocNo"];
            }else{
                $tPgpCodeAutoGen    = $this->input->post('oetPgpCode');
            }


            if($tSelectRoot == 'on'){
                $nPgpLevel      = 1;
                $tPgpParent     = '';
                $tPgpChain      = $tPgpCodeAutoGen;
                $tPgpChainName  = $this->input->post('oetPgpName');
            }else{
                $tPgpChain          = $this->input->post('oetPgpChain');
                $tPgpParent         = $tPgpChain;
                $aDataPgpSelect     = $this->mPdtGroup->FSaMPGPGetDataParent($tPgpParent,$nLngID);
                $nPgpLevel          = ($aDataPgpSelect !== FALSE)? $aDataPgpSelect['rtPgpLevel']+1 : 1;
                $tPgpChain          = ($aDataPgpSelect !== FALSE)? $aDataPgpSelect['rtPgpChain'].$tPgpCodeAutoGen : $tPgpCodeAutoGen;
                $tPgpChainName      = ($aDataPgpSelect !== FALSE)? $aDataPgpSelect['rtPgpChainName']." > ".$this->input->post('oetPgpName') : $this->input->post('oetPgpName');
            }

            $aDataPdtGroup = array(
                'FTPgpCode'         => $tPgpCodeAutoGen,
                'FTPgpChainOld'     => $this->input->post('oetPgpChainOld'),                
                'FNPgpLevelOld'     => $this->input->post('oetPgpLevelOld'),                
                'FNPgpLevel'        => $nPgpLevel,
                'FTPgpParent'       => $tPgpParent,
                'FTPgpChain'        => $tPgpChain,
                'FTPgpName'         => $this->input->post('oetPgpName'),
                'FTPgpChainName'    => $tPgpChainName,
                'FTPgpRmk'          => $this->input->post('otaPgpRmk'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTAgnCode'         => $this->input->post('oetPgpAgnCode'),
            );
            $this->db->trans_begin();
            $aStaPgpMaster  = $this->mPdtGroup->FSaMPGPAddUpdateMaster($aDataPdtGroup);
            $aStaPgpLang    = $this->mPdtGroup->FSaMPGPAddUpdateLang($aDataPdtGroup);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                if($tImgInputPdtGrpParent != $tImgInputPdtGrpParentOld){
            
                    $aImageUplode = array(
                        'tModuleName'       => 'product',
                        'tImgFolder'        => 'pdtgroup',
                        'tImgRefID'         => $tPgpCodeAutoGen ,
                        'tImgObj'           => $tImgInputPdtGrpParent,
                        'tImgTable'         => 'TCNMPdtGrp',
                        'tTableInsert'      => 'TCNMImgPdt',
                        'tImgKey'           => 'master',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtGroup['FTPgpCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Product Group
    //Parameters : Ajax Event
    //Creator : 19/09/2018 wasin
    //Update : 26/03/2019 pap
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPGPEditEvent(){
        try{
            $tSelectRoot    = $this->input->post('ocbPdtGrpSelectRoot');
            $tIsAutoGenCode = $this->input->post('ocbPgpAutoGenCode');
            $nLngID         = $this->session->userdata("tLangEdit");

            
            $tPgpCodeAutoGen    = $this->input->post('oetPgpCode');

            $tImgInputPdtGrpParentOld = $this->input->post('oetImgInputPdtGrpParentOld');
            $tImgInputPdtGrpParent    = $this->input->post('oetImgInputPdtGrpParent');
   
            if($tSelectRoot == 'on'){
                $nPgpLevel      = 1;
                $tPgpParent     = '';
                $tPgpChain      = $tPgpCodeAutoGen;
                $tPgpChainName  = $this->input->post('oetPgpName');
            }else{
                $tPgpChain          = $this->input->post('oetPgpChain');
                $tPgpParent         = $tPgpChain;
                $aDataPgpSelect     = $this->mPdtGroup->FSaMPGPGetDataParent($tPgpParent,$nLngID);
                $nPgpLevel          = ($aDataPgpSelect !== FALSE)? $aDataPgpSelect['rtPgpLevel']+1 : 1;
                $tPgpChain          = ($aDataPgpSelect !== FALSE)? $aDataPgpSelect['rtPgpChain'].$tPgpCodeAutoGen : $tPgpCodeAutoGen;
                $tPgpChainName      = ($aDataPgpSelect !== FALSE)? $aDataPgpSelect['rtPgpChainName']." > ".$this->input->post('oetPgpName') : $this->input->post('oetPgpName');
            }

            $aDataPdtGroup = array(
                'FTPgpCode'         => $tPgpCodeAutoGen,
                'FTPgpChainOld'     => $this->input->post('oetPgpChainOld'),                
                'FNPgpLevelOld'     => $this->input->post('oetPgpLevelOld'),                
                'FNPgpLevel'        => $nPgpLevel,
                'FTPgpParent'       => $tPgpParent,
                'FTPgpChain'        => $tPgpChain,
                'FTPgpName'         => $this->input->post('oetPgpName'),
                'FTPgpChainName'    => $tPgpChainName,
                'FTPgpRmk'          => $this->input->post('otaPgpRmk'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTAgnCode'         => $this->input->post('oetPgpAgnCode'),
            );
            $this->db->trans_begin();
            $aStaPgpMaster  = $this->mPdtGroup->FSaMPGPAddUpdateMaster($aDataPdtGroup);
            $aStaPgpLang    = $this->mPdtGroup->FSaMPGPAddUpdateLang($aDataPdtGroup);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                if($tImgInputPdtGrpParent != $tImgInputPdtGrpParentOld){
                    $aImageUplode = array(
                        'tModuleName'       => 'product',
                        'tImgFolder'        => 'pdtgroup',
                        'tImgRefID'         => $aDataPdtGroup['FTPgpCode'] ,
                        'tImgObj'           => $tImgInputPdtGrpParent,
                        'tImgTable'         => 'TCNMPdtGrp',
                        'tTableInsert'      => 'TCNMImgPdt',
                        'tImgKey'           => 'master',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtGroup['FTPgpCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Product Group
    //Parameters : Ajax jReason()
    //Creator : 19/09/2018 wasin
    //Update: 1/04/2019 pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPGPDeleteEvent(){
        try{
            $tIDCode    = $this->input->post('tIDCode');
            $aDataMaster = array(
                'FTPgpCode' => $tIDCode,
            );
            $aDataDelete = $this->mPdtGroup->FSaMGetChainForDelete($aDataMaster);
            $aResDel    = $this->mPdtGroup->FSaMPGPDelAll($aDataDelete);
            $nNumRowPdtPGP = $this->mPdtGroup->FSnMPGPGetAllNumRow();
            $aDeleteImage = array(
                'tModuleName'  => 'product',
                'tImgFolder'   => 'pdtgroup',
                'tImgRefID'    => $tIDCode  ,
                'tTableDel'    => 'TCNMImgPdt',
                'tImgTable'    => 'TCNMPdtGrp'
                );
        //ลบข้อมูลในตาราง         
        $nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
        if($nStaDelImgInDB == 1){
            //ลบรูปในโฟลเดอ
            FSnHDeleteImageFiles($aDeleteImage);
        }
            if($nNumRowPdtPGP!==false){
                $aReturn    = array(
                    'nStaEvent' => $aResDel['rtCode'],
                    'tStaMessg' => $aResDel['rtDesc'],
                    'nNumRowPdtPgp' => $nNumRowPdtPGP
                );
                echo json_encode($aReturn);
            }else{
                echo "database error!";
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }




}