<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBanknote extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('payment/banknote/mBanknote');
    }

    public function index($nBntBrowseType,$tBntBrowseOption){
        $nMsgResp   = array('title'=>"BankNote");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('banknote/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน

        $aAlwEventBankNote	= FCNaHCheckAlwFunc('banknote/0/0');

        $this->load->view('payment/banknote/wBanknote', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nBntBrowseType'    => $nBntBrowseType,
            'tBntBrowseOption'  => $tBntBrowseOption,
            'aAlwEventBankNote' => $aAlwEventBankNote
        ));
    }

    //Functionality : Function Call BankNote Page Lists
    //Parameters : Ajax and Function Parameter
    //Creator : 30/01/2019 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCBNTListPage(){ 
        $aAlwEventBankNote	= FCNaHCheckAlwFunc('banknote/0/0');
        $aNewData  		= array( 'aAlwEventBankNote' => $aAlwEventBankNote);
        $this->load->view('payment/banknote/wBanknoteList',$aNewData);
    }

    //Functionality : Function Call DataTables BankNote
    //Parameters : Ajax Call View DataTable
    //Creator : 30/01/2019 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNTDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMBankNote_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );
            $aBntDataList   = $this->mBanknote->FSaMBNTList($aData); 
            $aAlwEvent = FCNaHCheckAlwFunc('banknote/0/0'); //Controle Event
            $aGenTable  = array(
                'aAlwEventBankNote' => $aAlwEvent,
                'aBntDataList'  => $aBntDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('payment/banknote/wBanknoteDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product  Brand Add
    //Parameters : Ajax Call View Add
    //Creator : 30/01/2019 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNTAddPage(){
        $aDataBnt = array(
            'nStaAddOrEdit'   => 99,
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
        );
        $this->load->view('payment/banknote/wBanknoteAdd',$aDataBnt);
    }

    // Functionality : Function CallPage BankNote Edits
    // Parameters : Ajax Call View Add
    // Creator : 30/01/2019 Witsarut
    // LastUpdate: 20/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCBNTEditPage(){
        $tBntCode       = $this->input->post('tBntCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMBankNote_L');
        $nLangHave      = FCNnHSizeOf($aLangHave);
        if($nLangHave > 1){
            $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
        }else{
            $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
        }
        $aData      = [
            'FTBntCode' => $tBntCode,
            'FNLngID'   => $nLangEdit
        ];
        $aResList   = $this->mBanknote->FSaMBNTGetDataByID($aData);
       
        $aDataBnt   = array(
            'nStaAddOrEdit' => 1,
            'tImgObjAll'    => $aResList['raItems']['rtBntImage'],
            'aBntData'      => $aResList
        );
        $this->load->view('payment/banknote/wBanknoteAdd',$aDataBnt);
    }

    // Functionality: Event Add BankNote
    // Parameters: Ajax Event
    // Creator: 30/01/2019 (Bell)
    // LastUpdate: 20/09/2019 Wasin(Yoshi)
    // Return: Status Add Event
    // ReturnType: String
    public function FSoCBNTAddEvent(){ 
        /** ==================== Input Image Data ==================== */
        $tImgInputBanknote      = $this->input->post('oetImgInputBanknote');
        $tImgInputBanknoteOld   = $this->input->post('oetImgInputBanknoteOld');
        /** ==================== Input Image Data ==================== */
        $tIsAutoGenCode = $this->input->post('ocbBanknoteAutoGenCode');
        // Setup BackNote Code
        $tBntCode = "";
        if(isset($tIsAutoGenCode) &&  $tIsAutoGenCode == '1'){
            // Call Auto Gencode Helper
            $aStoreParam = array(
                "tTblName" => 'TFNMBankNote',                           
                "tDocType" => 0,                                          
                "tBchCode" => "",                                 
                "tShpCode" => "",                               
                "tPosCode" => "",                     
                "dDocDate" => date("Y-m-d")       
            );
            $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
            $tBntCode = $aAutogen[0]["FTXxhDocNo"];

            /* $aGenCode = FCNaHGenCodeV5('TFNMBankNote');
            if($aGenCode['rtCode'] == '1'){
                $tBntCode = $aGenCode['rtBntCode'];
            } */
        }else{
            $tBntCode = $this->input->post('oetBntCode');
        }
        $aDataBnt   = array(
            'FTRteCode'     => "THB",
            'FTBntCode'     => $tBntCode,
            'FTBntName'     => $this->input->post('oetBntName'),
            'FCBntRateAmt'  => empty($this->input->post('oetBntAmt'))?0:str_replace(',','',$this->input->post('oetBntAmt')),
            'FTBntStaShw'   => '',
            'FTBntRmk'      => $this->input->post('otaBntRemark'),
            'FDCreateOn'    => date('Y-m-d H:i:s'),
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAgnCode'         => $this->input->post('oetBntAgnCode')
        );
        $oCountDup      = $this->mBanknote->FSnMBNTCheckDuplicate($aDataBnt['FTBntCode']);
        $nStaDup        = $oCountDup['counts'];
        if($oCountDup !== FALSE && $nStaDup == 0){
            $this->db->trans_begin();
            $this->mBanknote->FSaMBNTAddUpdateMaster($aDataBnt);
            $this->mBanknote->FSaMBNTAddUpdateLang($aDataBnt);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add BankNote"
                );
            }else{
                $this->db->trans_commit();
                if($tImgInputBanknote != $tImgInputBanknoteOld){
                    $aImageData = [
                        'tModuleName'       => 'payment',
                        'tImgFolder'        => 'banknote',
                        'tImgRefID'         => $tBntCode,
                        'tImgObj'           => $tImgInputBanknote,
                        'tImgTable'         => 'TFNMBankNote',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    ];
                    $aImgReturn = FCNnHAddImgObj($aImageData);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataBnt['FTBntCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add BankNote'
                );
            }
        }else{
            $aReturn = array(
                'nStaEvent'    => '801',
                'tStaMessg'    => language('common/main/main','tDataDuplicate')
            );
        }
        echo json_encode($aReturn);
    }

    //Functionality : Event Edit BankNote
    //Parameters : Ajax Event
    //Creator : 30/01/2019 Witsarut
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCBNTEditEvent(){ 
        $this->db->trans_begin();
        /** ==================== Input Image Data ==================== */
        $tImgInputBanknote      = $this->input->post('oetImgInputBanknote');
        $tImgInputBanknoteOld   = $this->input->post('oetImgInputBanknoteOld');
        $bBntStaShw             = $this->input->post('ocbBntStaShw');
        /** ==================== Input Image Data ==================== */
        $aDataBnt   = [
            'FTRteCode'     => "THB",
            'FTBntCode'     => $this->input->post('oetBntCode'),
            'FTBntName'     => $this->input->post('oetBntName'),
            'FCBntRateAmt'  => empty($this->input->post('oetBntAmt'))?0:str_replace(',','',$this->input->post('oetBntAmt')),
            'FTBntStaShw'   => ($bBntStaShw != '')? '1' : '',
            'FTBntRmk'      => $this->input->post('otaBntRemark'),
            'FDCreateOn'    => date('Y-m-d H:i:s'),
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAgnCode'     => $this->input->post('oetBntAgnCode')
        ];
		
        $aStaBntMaster  = $this->mBanknote->FSaMBNTAddUpdateMaster($aDataBnt);
        $aStaBntLang    = $this->mBanknote->FSaMBNTAddUpdateLang($aDataBnt);
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Edit BankNote"
            );
        }else{
            $this->db->trans_commit();
            if($tImgInputBanknote != $tImgInputBanknoteOld){
                $aImageUplode = array(
                    'tModuleName'       => 'payment',
                    'tImgFolder'        => 'banknote',
                    'tImgRefID'         => $aDataBnt['FTBntCode'],
                    'tImgObj'           => $tImgInputBanknote,
                    'tImgTable'         => 'TFNMBankNote',
                    'tTableInsert'      => 'TCNMImgObj',
                    'tImgKey'           => 'main',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
                );
                $aImgReturn = FCNnHAddImgObj($aImageUplode);
            }
            $aReturn = array(
                'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'	=> $aDataBnt['FTBntCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Edit BankNote'
            );
        }
        echo json_encode($aReturn);
    }

    //Functionality : Event Delete Banknote
    //Parameters : Ajax jReason()
    //Creator : 30/01/2019 Witsarut
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCBNTDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTBntCode' => $tIDCode
        );
        $aResDel    = $this->mBanknote->FSaMBNTDelAll($aDataMaster);
        $nNumRowBntLoc = $this->mBanknote->FSnMLOCGetAllNumRow();

        if($aResDel['rtCode'] == 1){
            $aDeleteImage = array(
                'tModuleName'	=> 'payment',
                'tImgFolder'    => 'banknote',
                'tImgRefID'     =>  $tIDCode,
                'tTableDel'     => 'TCNMImgObj',
                'tImgTable'     => 'TFNMBankNote'
            );
            $nStaDelImgInDB  = FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }

        if($nNumRowBntLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowBntLoc' => $nNumRowBntLoc
            );
            echo json_encode($aReturn);
        }else{
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowBntLoc' => $nNumRowBntLoc
            );
            echo json_encode($aReturn);
        }
    }

    /**
     * Functionality : Check Code No. Duplicate
     * Parameters : -
     * Creator : 11/06/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCBanknoteUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check
            $tBanknoteCode = $this->input->post('tBanknoteCode');
            $bIsDocNoDup = $this->mBanknote->FSbMCheckDuplicate($tBanknoteCode);

            if ($bIsDocNoDup) { // If have record
                $aStatus['bStatus'] = true;
            }
        }
        $aStatus["code"] = $tBanknoteCode;
        $this->output->set_content_type('application/json')->set_output(json_encode($aStatus));
    }


    /**
     * Functionality : Check Chk Sta Show limit 
     * Parameters : -
     * Creator : 28/10/2020 nale
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaCBNTChkStaShw(){

        try{

            if($this->input->post('tBntStaShw')!='1'){
                $tBntCode = $this->input->post('tBntCode');
                $aDataUpdateStaShw = array(
                    'FTRteCode'   => "THB",
                    'FTBntCode'   => $tBntCode,
                    'FTBntStaShw' => '',
                    'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                    'FDLastUpdOn' => date('Y-m-d H:i:s')
                );
                $this->mBanknote->FSaMUpdateStaShw($aDataUpdateStaShw);
                $aReturn    = array(
                    'nStaEvent'     => '002',
                    'tStaMessg'     => 'Success',
                    'nApvrStaShwChecked' => 1
                );
            }else{

                $nBNTStaChklimit =  $this->mBanknote->FSnMChkStaShw();
                    if($nBNTStaChklimit<5){
                    $tBntCode = $this->input->post('tBntCode');
                            $aDataUpdateStaShw = array(
                                'FTRteCode'   => "THB",
                                'FTBntCode'   => $tBntCode,
                                'FTBntStaShw' => '1',
                                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                                'FDLastUpdOn' => date('Y-m-d H:i:s')
                            );
                        $this->mBanknote->FSaMUpdateStaShw($aDataUpdateStaShw);
                        $nApvrStaShwChecked = 1;
                        $aReturn    = array(
                            'nStaEvent'     => '002',
                            'tStaMessg'     => 'Success',
                            'nApvrStaShwChecked' => $nApvrStaShwChecked
                        );
                    }else{
                        $nApvrStaShwChecked = 0;
                        $aReturn    = array(
                            'nStaEvent'     => '008',
                            'tStaMessg'     => language('payment/banknote/banknote','tBntStaShwLimit'),
                            'nApvrStaShwChecked' => $nApvrStaShwChecked
                        );
                    }
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }
}