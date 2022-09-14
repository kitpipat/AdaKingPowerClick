<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cReason extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('other/reason/mReason');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nRsnBrowseType,$tRsnBrowseOption){
        $nMsgResp = array('title'=>"Reason");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('reason/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventReason	= FCNaHCheckAlwFunc('reason/0/0');
        $this->load->view ( 'other/reason/wReason', array (
            'nMsgResp'          =>$nMsgResp,
            'vBtnSave'          =>$vBtnSave,
            'nRsnBrowseType'    =>$nRsnBrowseType,
            'tRsnBrowseOption'  =>$tRsnBrowseOption,
            'aAlwEventReason'   =>$aAlwEventReason
        ));
    }

    //Functionality : Function Call Page Reason List
    //Parameters : Ajax jReason()
    //Creator : 25/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRSNListPage(){
        $aAlwEventReason	= FCNaHCheckAlwFunc('reason/0/0');
        $aNewData  		    = array( 'aAlwEventReason' => $aAlwEventReason);
        $this->load->view('other/reason/wReasonList',$aNewData);
    }

    //Functionality : Function Call DataTables Reason List
    //Parameters : Ajax jReason()
    //Creator : 25/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRSNDataList(){
        $nPage  = $this->input->post('nPageCurrent');
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
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList   = $this->mReason->FSaMRSNList($tAPIReq,$tMethodReq,$aData);
        $aAlwEvent = FCNaHCheckAlwFunc('reason/0/0'); //Controle Event

        $aGenTable  = array(
            'aAlwEventReason' => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('other/reason/wReasonDataTable',$aGenTable);
    }

    //Functionality : Function Call Add Page Reason
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRSNAddPage(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aRsnSysData    = $this->mReason->FSaMRSNSysGroup($tAPIReq,$tMethodReq,$aData);
        $tSelected      = $this->FSaRSNDropdown('','ocmRcnGroup',$aRsnSysData);

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99','rtSelected'=>$tSelected),
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
        );


        $this->load->view('other/reason/wReasonAdd',$aDataAdd);
    }

    //Functionality : Function Call Edit Page Reason
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRSNEditPage(){
        $tRsnCode       = $this->input->post('tRsnCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FTRsnCode' => $tRsnCode,
            'FNLngID'   => $nLangEdit
        );


        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aRsnData       = $this->mReason->FSaMRSNSearchByID($tAPIReq,$tMethodReq,$aData);
        //Create Selecte Box --
        $aRsnSysData    = $this->mReason->FSaMRSNSysGroup($tAPIReq,$tMethodReq,$aData);
        $nRsnSysID      = ($aRsnData['rtCode']=='1')? $aRsnData['raItems']['rtRsgCode'] : "";
        $tSelected      = $this->FSaRSNDropdown($nRsnSysID,'ocmRcnGroup',$aRsnSysData);
        if($tSelected !=''){
            // ทำการยัด Array RtDropdown เข้าในตัวแปร $aRsnData
            $aRsnData = array_merge($aRsnData,array('rtSelected'=>$tSelected));          
        }
        $aDataEdit = array(
            'aResult'   => $aRsnData,
        );
        $this->load->view('other/reason/wReasonAdd',$aDataEdit);
    }

    //Functionality : Function Create Selected
    //Parameters : Function Parameter
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSaRSNDropdown($ptRntID,$ptIDname,$poData){
        //Parameters : $ptRntID = ข้อมูลที่ใช้เช็คทำ Selected(EDIT)
        //$ptIDname = ชื่อ ID กับ Name
        //$poData = ข้อมูลที่ใช้ทำ Dropdown
        $tDropdown  = "<select required class='selection-2 selectpicker form-control' id='".$ptIDname."' name='".$ptIDname."' >";
        if($poData['rtCode']=='1'){
            foreach($poData['raItems'] AS $key=>$aValue){
                $selected = ($ptRntID!='' && $ptRntID == $aValue['rtRsgCode'])? 'selected':'';
                $tDropdown .= "<option value='".$aValue['rtRsgCode']."' ".$selected.">".$aValue['rtRsgName']."</option>";
            }
        }
        $tDropdown  .= "</select>";
        return $tDropdown;
    }

    //Functionality : Event Add Reason
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaRSNAddEvent(){
        try{

            $aDataMaster    = array(
                'tIsAutoGenCode'        => $this->input->post('ocbReasonAutoGenCode'),
                'FTRsnCode'             => $this->input->post('oetRsnCode'),
                'FTRsgCode'             => $this->input->post('ocmRcnGroup'),
                'FTRsnName'             => $this->input->post('oetRsnName'),
                'FTRsnRmk'              => $this->input->post('oetRsnRemark'),
                'FTRsnRefID'            => $this->input->post('oetRsnRefID'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FNLngID'               => $this->session->userdata("tLangEdit"),
                'FTAgnCode'             => $this->input->post('oetRSNAgnCode'),
            );
            
            if($aDataMaster['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"   => 'TCNMRsn',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   				= FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTRsnCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
          
            $oCountDup  = $this->mReason->FSoMRSNCheckDuplicate($aDataMaster['FTRsnCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaRsnMaster  = $this->mReason->FSaMRSNAddUpdateMaster($aDataMaster);
                $aStaRsnLang    = $this->mReason->FSaMRSNAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'	=> $aDataMaster['FTRsnCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => language('other/reason/reason','tRSNValidCodeDup')
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Reason
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaRSNEditEvent(){
        try{
            $aDataMaster    = array(
                'FTRsnCode'     => $this->input->post('oetRsnCode'),
                'FTRsgCode'     => $this->input->post('ocmRcnGroup'),
                'FTRsnName'     => $this->input->post('oetRsnName'),
                'FTRsnRmk'      => $this->input->post('oetRsnRemark'),
                'FTRsnRefID'    => $this->input->post('oetRsnRefID'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetRSNAgnCode'),
            );
            $this->db->trans_begin();
            $aStaRsnMaster  = $this->mReason->FSaMRSNAddUpdateMaster($aDataMaster);
            $aStaRsnLang    = $this->mReason->FSaMRSNAddUpdateLang($aDataMaster);

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
                    'tCodeReturn'	=> $aDataMaster['FTRsnCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
        
    }

    //Functionality : Event Delete Reason
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaRSNDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');


        $aDataMaster = array(
            'FTRsnCode' => $tIDCode
        );
        $tAPIReq        = 'API/Reason/Delete';
        $tMethodReq     = 'POST';
        $aResDel        = $this->mReason->FSnMRSNDel($tAPIReq,$tMethodReq,$aDataMaster);
        $nNumRowRsnLoc  = $this->mReason->FSnMLOCGetAllNumRow();

        if($nNumRowRsnLoc !== false){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowRsnLoc' => $nNumRowRsnLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }
    }
}
