<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCreditcard extends MX_Controller {

    public function __construct(){
        date_default_timezone_set("Asia/Bangkok");
        parent::__construct ();
        $this->load->model('creditcard/creditcard/mCreditcard');
    }

    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']           = $nBrowseType;
        $aData['tBrowseOption']         = $tBrowseOption;
		$aData['aAlwEventCreditcard']   = FCNaHCheckAlwFunc('creditcard/0/0'); //Controle Event
        $aData['vBtnSave']              = FCNaHBtnSaveActiveHTML('creditcard/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('creditcard/creditcard/wCreditcard',$aData);
    }

    //Functionality : Event PageAdd Creditcard
    //Parameters : Ajax jCreditcard()
    //Creator : 28/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : view
    //Return Type : view
    public function FSxCCDCAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        $this->load->view('creditcard/creditcard/wCreditcardAdd',$aDataAdd);
    }

    //Functionality : call view List
    //Parameters : Ajax jCreditcard()
    //Creator : 28/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : view
    //Return Type : view
    public function FSxCCDCFormSearchList(){
           $this->load->view('creditcard/creditcard/wCreditcardFormSearchList');
    }

    //Functionality : Event Add Creditcard
    //Parameters : Ajax jCreditcard()
    //Creator : 28/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCCDCAddEvent(){
        try{

            $tImgColor              = $this->input->post("orbChecked");
            $tImgInputCrd           = $this->input->post("oetImgInputCrd");
            $tImgInputCrdOld        = $this->input->post("oetImgInputCrdOld");
            $tCrdChgPer             =  ($this->input->post("oetCrdChgPer") == '' ? 0 : $this->input->post("oetCrdChgPer"));
           
            $aDataMaster = array(
                'tIsAutoGenCode'    => $this->input->post('ocbCreditcardAutoGenCode'),
                'FTCrdCode'         => $this->input->post('oetCrdCode'),
                'FTCrdName'         => $this->input->post('oetCrdName'),
                'FTBnkCode'         => $this->input->post('ohdBnkCode'),
                'FCCrdChgPer'       => $tCrdChgPer,
                'FTCrdCrdFmt'       => $this->input->post('oetCrdFmt'),
                'FTCrdRmk'          => $this->input->post('oetCrdRmk'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                
                'FTAgnCode'         => $this->input->post('oetCDCUsrAgnCode'),
            );
           
            // Check Auto Gen Department Code?
            if($aDataMaster['tIsAutoGenCode'] == '1'){ 
                // Auto Gen Department Code
                // $aGenCode = FCNaHGenCodeV5('TFNMCreditCard','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTCrdCode'] = $aGenCode['rtCrdCode'];
                // }

                                // 15/05/2020 Nattakit(Nale)
                                $aStoreParam = array(
                                    "tTblName"    => 'TFNMCreditCard',                           
                                    "tDocType"    => 0,                                          
                                    "tBchCode"    => "",                                 
                                    "tShpCode"    => "",                               
                                    "tPosCode"    => "",                     
                                    "dDocDate"    => date("Y-m-d H:i:s")     
                                );
                                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                                $aDataMaster['FTCrdCode']   = $aAutogen[0]["FTXxhDocNo"];

            }
            $oCountDup  = $this->mCreditcard->FSnMCRDCheckDuplicate($aDataMaster['FTCrdCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mCreditcard->FSaMCDCAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mCreditcard->FSaMCDCAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $tImgInputCrd        = $this->input->post("oetImgInputCreditCard");
                    $tImgInputCrdOld     = $this->input->post("oetImgInputCreditCardOld");
                    $aPackUplode = array(
                        'tModuleName'       => 'creditcard',
                        'tImgFolder'        => 'creditcard',
                        'tImgRefID'         => $aDataMaster['FTCrdCode'],
                        'tImgTable'         => 'TFNMCreditCard',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FDCreateOn'        => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                        'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1,
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    );
                    if( isset($tImgInputCrd) && !empty($tImgInputCrd) && $tImgInputCrd != $tImgInputCrdOld ){
                        $aPackUplode['tImgObj'] = $tImgInputCrd;
                        $aImgReturn = FCNnHAddImgObj($aPackUplode);
                    }else{
                        $tCheckedColor  = $this->input->post('orbChecked');
                        $tInputColor    = $this->input->post('oetImgColorCreditCard');
                        
                        if( ( isset($tCheckedColor) && !empty($tCheckedColor) ) || ( isset($tInputColor) && !empty($tInputColor) ) ){
                            $aPackUplode['tImgObj'] = ( isset($tCheckedColor) && !empty($tCheckedColor) ? $tCheckedColor : $tInputColor );
                            FCNxHAddColorObj($aPackUplode);
                        }
                    }
                    $aReturn = array(
                        'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTCrdCode'],
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

    //Functionality : Event PageEdit Creditcard
    //Parameters : Ajax jCreditcard()
    //Creator : 28/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSvCCDCEditPage(){
		$aAlwEventCreditcard	= FCNaHCheckAlwFunc('creditcard/0/0'); //Controle Event
        $tCrdCode       = $this->input->post('tCrdCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FTCrdCode'    => $tCrdCode,
            'FNLngID'      => $nLangEdit,
            'FTImgTable'   => "TFNMCreditCard",
        );

        $aResult       = $this->mCreditcard->FSaMCDCSearchByID($aData);
        // if(isset($aResult['raItems']['rtImgObj']) && !empty($aResult['raItems']['rtImgObj'])){
        //     $tImgObj        = $aResult['raItems']['rtImgObj'];
        //     $aImgObj        = explode("application/modules/",$tImgObj);
        //     $aImgObjName    = explode("/",$tImgObj);
        //     $tImgObjAll     = $aImgObj[1];
        //     $tImgName		= end($aImgObjName);
        // }else{
        //     $tImgObjAll = "";
        //     $tImgName	= "";
        // }

        $aDataEdit  = [
            // 'tImgName'              => $tImgName,
            // 'tImgObjAll'            => $tImgObjAll,
            'aResult'               => $aResult,
            'aAlwEventCreditcard'   => $aAlwEventCreditcard
        ];

        $this->load->view('creditcard/creditcard/wCreditcardAdd',$aDataEdit);
    }

    //Functionality : Event Edit Creditcard
    //Parameters : Ajax jCreditcard()
    //Creator : 30/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCCDCEditEvent(){
        try{
            // $tImgColor           = $this->input->post("orbChecked");
            // $tCrdcheckImg        = $this->input->post("ohdCrdcheckImg");
            

            $aDataMaster = array(
                'FTCrdCode'     => $this->input->post('oetCrdCode'),
                'FTCrdName'     => $this->input->post('oetCrdName'),
                'FTBnkCode'     => $this->input->post('ohdBnkCode'),
                'FCCrdChgPer'   => $this->input->post('oetCrdChgPer'),
                'FTCrdCrdFmt'   => $this->input->post('oetCrdFmt'),
                'FTCrdRmk'      => $this->input->post('oetCrdRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),

                'FTAgnCode'         => $this->input->post('oetCDCUsrAgnCode'),
            );
            $this->db->trans_begin();
            $aStaEventMaster  = $this->mCreditcard->FSaMCDCAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mCreditcard->FSaMCDCAddUpdateLang($aDataMaster);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $tImgInputCrd        = $this->input->post("oetImgInputCreditCard");
                $tImgInputCrdOld     = $this->input->post("oetImgInputCreditCardOld");
                $aPackUplode = array(
                    'tModuleName'       => 'creditcard',
                    'tImgFolder'        => 'creditcard',
                    'tImgRefID'         => $aDataMaster['FTCrdCode'],
                    'tImgTable'         => 'TFNMCreditCard',
                    'tTableInsert'      => 'TCNMImgObj',
                    'tImgKey'           => 'main',
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1,
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                );
                if( isset($tImgInputCrd) && !empty($tImgInputCrd) && $tImgInputCrd != $tImgInputCrdOld ){
                    $aPackUplode['tImgObj'] = $tImgInputCrd;
                    $aImgReturn = FCNnHAddImgObj($aPackUplode);
                }else{
                    $tCheckedColor  = $this->input->post('orbChecked');
                    $tInputColor    = $this->input->post('oetImgColorCreditCard');
                    
                    if( ( isset($tCheckedColor) && !empty($tCheckedColor) ) || ( isset($tInputColor) && !empty($tInputColor) ) ){
                        $aPackUplode['tImgObj'] = ( isset($tCheckedColor) && !empty($tCheckedColor) ? $tCheckedColor : $tInputColor );
                        FCNxHAddColorObj($aPackUplode);
                    }
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTCrdCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }

    //Functionality : Event Delete Creditcard
    //Parameters : Ajax jCreditcard()
    //Creator : 30/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCDCDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCrdCode'     => $tIDCode,
            'FTImgTable'    => "TFNMCreditCard"
        );

        $aResDel    = $this->mCreditcard->FSnMCDCDel($aDataMaster);
        $aDeleteImage           = array(
                'tModuleName'  => 'creditcard',
                'tImgFolder'   => 'creditcard',
                'tImgRefID'    => $tIDCode ,
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TFNMCreditCard'
                );
        //ลบข้อมูลในตาราง         
        $nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
        if($nStaDelImgInDB == 1){
            //ลบรูปในโฟลเดอ
            FSnHDeleteImageFiles($aDeleteImage);
        }
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

	//Functionality : Function Call DataTables Creditcard
    //Parameters : Ajax jCreditcard()
    //Creator : 30/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCDCDataTable(){

        $aAlwEvent = FCNaHCheckAlwFunc('creditcard/0/0'); //Controle Event
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
            'FTImgTable'    => "TFNMCreditCard"
        );

        $aResList   = $this->mCreditcard->FSaMCDCList($aData);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );

        $this->load->view('creditcard/creditcard/wCreditcardDatatable',$aGenTable);
    }



}
?>