<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBookBank extends MX_Controller {

    public function __construct(){
        date_default_timezone_set("Asia/Bangkok");
        parent::__construct ();
        $this->load->model('BookBank/BookBank/mBookBank');
    }

    public function index($nBrowseType,$tBrowseOption){
        $aData['nBrowseType']           = $nBrowseType;
        $aData['tBrowseOption']         = $tBrowseOption;
		$aData['aAlwEventBookBank']   = FCNaHCheckAlwFunc('BookBank/0/0'); //Controle Event
        $aData['vBtnSave']              = FCNaHBtnSaveActiveHTML('BookBank/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('BookBank/BookBank/wBookBank',$aData);
    }

    //Functionality : call view List
    //Parameters : Ajax jBookBank()
    //Creator : 31/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : view
    //Return Type : view
    public function FSxCBBKCallPageList(){
        $this->load->view('BookBank/BookBank/wBookBankList');
    }

    //Functionality : โหลดข้อมูล สมุดบัญชีธนาคาร 
    //Parameters : Ajax jBookBank()
    //Creator : 31/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCBBKDataTable(){

        $aAlwEvent          = FCNaHCheckAlwFunc('BookBank/0/0'); //Controle Event
        $nPage              = $this->input->post('nPageCurrent');
        $tSearchAll         = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'tSearchAll'    => $tSearchAll
        );

        $aResList   = $this->mBookBank->FSaMBBKList($aData);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('BookBank/BookBank/wBookBankDataTable',$aGenTable);
    }
    
    //Functionality : Event PageAdd Bookbank
    //Parameters : Ajax jBookBank()
    //Creator : 31/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : view
    //Return Type : view
    public function FSxCBBKPageAdd(){

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        $this->load->view('BookBank/BookBank/wBookBankAdd',$aDataAdd);

    }

    //Functionality : Event ContentDetail Bookbank
    //Parameters : Ajax jBookBank()
    //Creator : 03/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : view
    //Return Type : view
    public function FSxCBBKPageContentDetail(){
        $this->load->view('BookBank/BookBank/Content/wBBKContentDetail');
    }

    //Functionality : Event ContentAccountActivity Bookbank
    //Parameters : Ajax jBookBank()
    //Creator : 03/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : view
    //Return Type : view
    public function FSxCBBKPageContentAccountActivity(){
        $this->load->view('BookBank/BookBank/Content/wBBKContentAccountActivity');
    }

    //Functionality : Event Add BookBank
    //Parameters : Ajax jBookBank()
    //Creator : 28/01/2020 Saharat(Golf)
    //Last Modified : 10/04/2020 surawat
    //Return : Status Add Event
    //Return Type : String
    public function FSaCBBKAddEvent(){
        try{
            // ตรวจสอบการเปิดใช้งาน
            if($this->input->post('ocbStaActive') != ""){$tStaActive = '1';}else{$tStaActive = '2';}

            $aDataMaster = array(
                'tOldBchCode'       => $this->input->post('ohdOldBchCode'),
                'tOldBbkCode'       => $this->input->post('ohdOldBbkCode'),
                'tIsAutoGenCode'    => $this->input->post('ocbBookbankAutoGenCode'),
                'FTBchCode'         => $this->input->post('oetBbkBchCode'),
                'FTMerCode'         => $this->input->post('oetBbkMerCode'),
                'FTBbkCode'         => $this->input->post('oetBbkCode'),
                'FTBbkName'         => $this->input->post('oetBbkName'),
                'FTBbkAccNo'        => $this->input->post('oetBbkAccNo'),
                'FTBbkType'         => $this->input->post('ocmBbkType'),
                'FTBnkCode'         => $this->input->post('ohdBnkCode'),
                'FTBbkBranch'       => $this->input->post('oetBbkBranch'),
                'FDBbkOpen'         => $this->input->post('oetBbkOpen'),
                'FTBbkRmk'          => $this->input->post('oetBbkRmk'),
                'FTBbkStaActive'    => $tStaActive,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
            );

            // Check Auto Gen Code?
            if($aDataMaster['tIsAutoGenCode'] == '1'){ 
                // Auto Gen Code
                // $aGenCode = FCNaHGenCodeV5('TFNMBookBank','0',$this->input->post('oetBbkBchCode'));
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTBbkCode'] = $aGenCode['rtBbkCode'];
                // }
                // 15/05/2020 Nattakit(Nale)
                $aStoreParam = array(
                "tTblName"    => 'TFNMBookBank',                           
                "tDocType"    => 0,                                          
                "tBchCode"    => $this->input->post('oetBbkBchCode'),                                 
                "tShpCode"    => "",                               
                "tPosCode"    => "",                     
                "dDocDate"    => date("Y-m-d H:i:s")      
            );
            $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
            $aDataMaster['FTBbkCode'] =  $aAutogen[0]["FTXxhDocNo"];

            }
            // $oCountDup  = $this->mBookBank->FSnMBbkCheckDuplicate($aDataMaster['FTBbkCode'], $aDataMaster['FTBchCode']);
            // $nStaDup    = $oCountDup[0]->counts;
            $bBbkIsDuplicate = $this->mBookBank->FSnMBbkCheckDuplicate($aDataMaster['FTBbkCode'], $aDataMaster['FTBchCode']);
            // if($nStaDup == 0){
            if(!$bBbkIsDuplicate){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mBookBank->FSaMBBKAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mBookBank->FSaMBBKAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	    => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	    => $aDataMaster['FTBbkCode'],
                        'tTypeReturn'	    => $aDataMaster['FTBbkType'],
                        'tStaActiveReturn'	=> $aDataMaster['FTBbkStaActive'],
                        'tBchCodeReturn'    => $aDataMaster['FTBchCode'],
                        'nStaEvent'	        => '1',
                        'tStaMessg'		    => 'Success Add Event'
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

    //Functionality : Event PageEdit BookBank
    //Parameters : Ajax jBookBank()
    //Creator : 04/02/2020 Saharat(Golf)
    //Last Modified : 10/04/2020 surawat
    //Return : Status Add Event
    //Return Type : String
    public function FSvCBBKEditPage(){
		$aAlwEvent  	= FCNaHCheckAlwFunc('BookBank/0/0'); //Controle Event
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FTBbkCode'    => $this->input->post('tBbkCode'),
            'FTBchCode'    => $this->input->post('tBchCode'),
            'FNLngID'      => $nLangEdit
        );

        $aResult           = $this->mBookBank->FSaMBBKSearchByID($aData);
        $aDataEdit  = [
            'aResult'               => $aResult,
            'aAlwEventBookbank'     => $aAlwEvent
        ];
        $this->load->view('BookBank/BookBank/wBookBankAdd',$aDataEdit);
    }

    //Functionality : Event Edit Creditcard
    //Parameters : Ajax jBookBank()
    //Creator : 30/01/2020 Saharat(Golf)
    //Last Modified : 10/04/2020 surawat
    //Return : Status Add Event
    //Return Type : String
    public function FSaCBBKEditEvent(){
        try{
            // ตรวจสอบการเปิดใช้งาน
            if($this->input->post('ocbStaActive') != ""){$tStaActive = '1';}else{$tStaActive = '2';}

            $aDataMaster = array(
                'tOldBchCode'       => $this->input->post('ohdOldBchCode'),
                'tOldBbkCode'       => $this->input->post('ohdOldBbkCode'),
                'tIsAutoGenCode'    => $this->input->post('ocbBookbankAutoGenCode'),
                'FTBbkCode'         => $this->input->post('oetBbkCode'),
                'FTBchCode'         => $this->input->post('oetBbkBchCode'),
                'FTMerCode'         => $this->input->post('oetBbkMerCode'),
                'FTBbkName'         => $this->input->post('oetBbkName'),
                'FTBbkAccNo'        => $this->input->post('oetBbkAccNo'),
                'FTBbkType'         => $this->input->post('ocmBbkType'),
                'FTBnkCode'         => $this->input->post('ohdBnkCode'),
                'FTBbkBranch'       => $this->input->post('oetBbkBranch'),
                'FDBbkOpen'         => $this->input->post('oetBbkOpen'),
                'FTBbkRmk'          => $this->input->post('oetBbkRmk'),
                'FTBbkStaActive'    => $tStaActive,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
            );

            $this->db->trans_begin();
            $aStaEventMaster  = $this->mBookBank->FSaMBBKAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mBookBank->FSaMBBKAddUpdateLang($aDataMaster);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	    => $aDataMaster['FTBbkCode'],
                    'tTypeReturn'	    => $aDataMaster['FTBbkType'],
                    'tStaActiveReturn'	=> $aDataMaster['FTBbkStaActive'],
                    'tBchCodeReturn'    => $aDataMaster['FTBchCode'],
                    'nStaEvent'	        => '1',
                    'tStaMessg'		    => 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }

    //Functionality : Event Delete Creditcard
    //Parameters : Ajax jBookBank()
    //Creator : 30/01/2020 Saharat(Golf)
    //Last Modified : 10/04/2020 surawat
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCBBKDeleteEvent(){
        $aDataMaster = [];

        if($aBbkDataToDelete = $this->input->post('aBbkDataToDelete')){
            foreach($aBbkDataToDelete as $aBbkRow){
                $aDataMaster[] =    array(
                                        'FTBbkCode' => $aBbkRow['tIDCode'],
                                        'FTBchCode' => $aBbkRow['tBchCode']
                                    );
            }
        } else {
            //กรณีกดที่ปุ่มถึงขยะท้ายรายการเชคเป็นการลบรายการเดียว จะมีการส่งรหัสเชคและรหัสสาขามาผ่านตัวแปร tIDCode, tBchCode โดย
            // tIDCode = รหัสเชค
            // tฺBchCode = รหัสสาขา
            $tIDCode = $this->input->post('tIDCode');
            $tBchCode = $this->input->post('tBchCode');
            $aDataMaster[] = array(
                                        'FTBbkCode' => $tIDCode,
                                        'FTBchCode' => $tBchCode
                                    );
        }

        $aResDel        = $this->mBookBank->FSnMBBKDel($aDataMaster);
        $nNumRowBbk     = $this->mBookBank->FSnMBBKGetAllNumRow();

        if($nNumRowBbk !== false){
            $aReturn    = array(
                'nStaEvent'  => $aResDel['rtCode'],
                'tStaMessg'  => $aResDel['rtDesc'],
                'nNumRowBbk' => $nNumRowBbk
            );
            echo json_encode($aReturn);
        }else{
            echo json_encode($aReturn);
        }


    }





}
?>