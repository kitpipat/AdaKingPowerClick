<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPosChanel extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos/chanel/mPosChanel');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for slip message
     * Parameters : $nChnBrowseType, $tChnBrowseOption
     * Creator : 29/12/2020 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nChnBrowseType, $tChnBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('chanel/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('pos/chanel/wPosChanel', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nChnBrowseType' => $nChnBrowseType,
            'tChnBrowseOption' => $tChnBrowseOption
        ));
    }

    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 29/12/2020 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCCHNListPage()
    {
        $this->load->view('pos/chanel/wPosChanelList');
    }

    /**
     * Functionality : Function Call DataTables Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 29/12/2020 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCCHNDataList()
    {
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }
        //Lang ภาษา
        // $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMSlipMsgHD_L');
        // $nLangHave      = count($aLangHave);
        // if ($nLangHave > 1) {
        //     if ($nLangEdit != '') {
        //         $nLangEdit = $nLangEdit;
        //     } else {
        //         $nLangEdit = $nLangResort;
        //     }
        // } else {
        //     if (@$aLangHave[0]->nLangList == '') {
        //         $nLangEdit = '1';
        //     } else {
        //         $nLangEdit = $aLangHave[0]->nLangList;
        //     }
        // }

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mPosChanel->FSaMCHNList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('pos/chanel/wPosChanelDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Slip Message Add
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCHNAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave = FCNaHGetAllLangByTable('TCNMSlipMsgHD_L');
        // $nLangHave = count($aLangHave);
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
            'aResult'   => array('rtCode' => '99')
        );

        $this->load->view('pos/chanel/wPosChanelAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Slip Message Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCHNEditPage()
    {

        $tChnCode       = $this->input->post('tChnCode');
        // $tChnBchCode       = $this->input->post('tChnBchCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMSlipMsgHD_L');
        // $nLangHave      = count($aLangHave);

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
            'FTChnCode' => $tChnCode,
            // 'FTBchCode' => $tChnBchCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aChnData       = $this->mPosChanel->FSaMCHNSearchByID($tAPIReq, $tMethodReq, $aData);
        $aDataEdit      = array('aResult' => $aChnData);
        $this->load->view('pos/chanel/wPosChanelAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCHNAddEvent()
    {
        try {
            $tIsAutoGenCode = $this->input->post('ocbSlipmessageAutoGenCode');
            // $tBchCodeCreate = $this->input->post('oetWahBchCodeCreated');

            // Setup Reason Code
            $tChnCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TCNMChannel',
                    "tDocType"   => 0,
                    // "tBchCode"   => $tBchCodeCreate,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tChnCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tChnCode); die();
            } else {
                $tChnCode = $this->input->post('oetChnCode');
            }

            // $nCountSeq   = $this->mPosChanel->FSnMChnCountSeq($tBchCodeCreate);
            $nCountSeq   = $this->mPosChanel->FSnMChnCountSeq($this->input->post('oetChnAppCode'));
            $nCountSeq   = $nCountSeq + 1;


            $aDataMaster = array(
                'FTChnCode'             => $tChnCode,
                'FTAppCode' => $this->input->post('oetChnAppCode'),
                'FNChnSeq' => $nCountSeq,
                'FTChnStaUse'   => (!empty($this->input->post('ocbChnStatusUse'))) ? 1 : 2,
                'FTChnRefCode'  => $this->input->post('oetChnRefCode'),
                'FTPplCode'     => $this->input->post('oetChnPplCode'),
                'FTWahCode'     => $this->input->post('oetBchWahCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTChnStaUseDO'     => (!empty($this->input->post('ocbChnStaUseDO'))) ? 1 : 2,
                'FTChnStaAlwSNPL'   => (!empty($this->input->post('ocbChnStaAlwSNPL'))) ? 1 : 2,
                'FTChnWahDO'        => $this->input->post('oetDeliveryWahCode'),

                'FTChnName'            => $this->input->post('oetChnName'),
                'FTAgnCode' => $this->input->post('oetChnAgnCode'),
                'FTBchCode'             => $this->input->post('oetWahBchCodeCreated'),
                'tTypeInsertUpdate' => 'Insert'
            );


            // $oCountDup  = $this->mPosChanel->FSoMCHNCheckDuplicate($aDataMaster['FTChnCode'], $aDataMaster['FTBchCode']);
            $oCountDup  = $this->mPosChanel->FSoMCHNCheckDuplicate($aDataMaster['FTChnCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                // Add or Update Slip
                $this->mPosChanel->FSaMCHNAddUpdateHD($aDataMaster);


                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                } else {
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'    => $aDataMaster['FTChnCode'],
                        // 'tCodeBchReturn'    => $aDataMaster['FTBchCode'],
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Event'
                    );
                }
            } else {
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Event Edit Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCHNEditEvent()
    {
        try {


            $aDataMaster = array(
                'FTChnCode'         => $this->input->post('oetChnCode'),
                'FTAppCode'         => $this->input->post('oetChnAppCode'),
                'FNChnSeq'          => $this->input->post('oetChnSeq'),
                'FTChnStaUse'       => (!empty($this->input->post('ocbChnStatusUse'))) ? 1 : 2,
                'FTChnRefCode'      => $this->input->post('oetChnRefCode'),
                'FTPplCode'         => $this->input->post('oetChnPplCode'),
                'FTWahCode'         => $this->input->post('oetBchWahCode'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTChnStaUseDO'     => (!empty($this->input->post('ocbChnStaUseDO'))) ? 1 : 2,
                'FTChnStaAlwSNPL'     => (!empty($this->input->post('ocbChnStaAlwSNPL'))) ? 1 : 2,
                'FTChnWahDO'        => $this->input->post('oetDeliveryWahCode'),


                'FTChnName'            => $this->input->post('oetChnName'),
                'FTAgnCode' => $this->input->post('oetChnAgnCode'),
                'FTBchCode'             => $this->input->post('oetWahBchCodeCreated'),

                'tTypeInsertUpdate' => 'Update'
            );

            $this->db->trans_begin();
            // Add or Update
            $this->mPosChanel->FSaMCHNAddUpdateHD($aDataMaster);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Event"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTChnCode'],
                    'tCodeBchReturn'    => $aDataMaster['FTBchCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Update Event'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Event Delete Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    // public function FSaCHNDeleteEvent(){
    //     $tIDCode = $this->input->post('tIDCode');
    //     $aDataMaster = array(
    //         'FTChnCode' => $tIDCode
    //     );

    //     $aResDel = $this->mPosChanel->FSnMCHNDelHD($aDataMaster);
    //     $aReturn = array(
    //         'nStaEvent' => $aResDel['rtCode'],
    //         'tStaMessg' => $aResDel['rtDesc']
    //     );
    //     echo json_encode($aReturn);
    // }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "smgcode"
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCHNUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'smgcode') {

                $tChnCode = $this->input->post('tChnCode');
                $oSlipMessage = $this->mPosChanel->FSoMCHNCheckDuplicate($tChnCode);

                $tStatus = 'false';
                if ($oSlipMessage[0]->counts > 0) { // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;

                return;
            }
            echo 'Param not match.';
        } else {
            echo 'Method Not Allowed';
        }
    }

    /**
     * Functionality : Function Event Multi Delete
     * Parameters : Ajax Function Delete
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoCHNDeleteMulti()
    {
        // $tChnCode = $this->input->post('tIDCode');

        // $aChnCode = json_decode($tChnCode);
        // foreach ($aChnCode as $oChnCode) {
        //     $aChn = ['FTChnCode' => $oChnCode];
        //     $this->mPosChanel->FSnMCHNDelHD($aChn);
        // }
        // echo json_encode($aChnCode);
        try {
            $this->db->trans_begin();
            $aDataWhereDel  = $this->input->post('paDataWhere');
            // print_r($aDataWhereDel); die();
            $aDataDelete    = [
                'FTChnCode' => $aDataWhereDel['paChnCode'],
                'FTBchCode' => $aDataWhereDel['paBchCode'],
            ];

            // $tRevCodeWhere =  $this->input->post('ptRevCodeWhere');
            $tResult    = $this->mPosChanel->FSaMChnDeleteMultiple($aDataDelete);
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Multiple'
                );
            } else {
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete  Multiple'
                );
            }
        } catch (Exception $Error) {
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }

    /**
     * Functionality : Delete
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCHNDelete()
    {

        $tChnBchCode = $this->input->post('tChnBchCode');
        $tChnCode = $this->input->post('tChnCode');
        $aDataMaster = array(
            'FTChnCode' => $tChnCode,
            'FTBchCode' => $tChnBchCode
        );
        $aResDel    = $this->mPosChanel->FSnMCHNDelHD($aDataMaster);
        $nNumRowChnLoc = $this->mPosChanel->FSnMLOCGetAllNumRow();
        if ($nNumRowChnLoc !== false) {
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowChnLoc' => $nNumRowChnLoc
            );
            echo json_encode($aReturn);
        } else {
            echo "database error";
        }
    }

    // Create By: Napat(Jame) 10/06/2022
    public function FSvCCHNPageSpcWah(){
        $nPage      = $this->input->post('nPageCurrent');
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $aDataSearch = array(
            'tType'     => 'List',
            'nPage'     => $nPage,
            'nRow'      => 10,
            'tChnCode'  => $this->input->post('tChnCode'),
            'FNLngID'   => $this->session->userdata("tLangEdit")
        );
        $aGetDataSpcWah = $this->mPosChanel->FSaMCHNGetDataSpcWah($aDataSearch);
        $aDataSpcWah = array(
            'aDataList' => $aGetDataSpcWah,
            'nPage'     => $nPage
        );
        $this->load->view('pos/chanel/wPosChanelSpcWah.php', $aDataSpcWah);
    }

    // Create By: Napat(Jame) 13/06/2022
    public function FSvCCHNPageSpcWahAdd(){
        $aDataSpcWahAdd = array(
            'aDataList' => array(
                'tCode' => '800',
                'tDesc' => 'Call Page Add'
            ),
        );
        $this->load->view('pos/chanel/wPosChanelSpcWahAdd.php', $aDataSpcWahAdd);
    }

    // Create By: Napat(Jame) 13/06/2022
    public function FSaCCHNEventSpcWahAdd(){
        $aDataAdd = array(
            'FTAgnCode'     => $this->input->post('oetCSWAgnCode'),
            'FTBchCode'     => $this->input->post('oetCSWBchCode'),
            'FTWahCode'     => $this->input->post('oetCSWWahCode'),
            'FTChnCode'     => $this->input->post('oetCSWChnCode'),
            'FTChnStaDoc'   => $this->input->post('osbCSWType'),
        );
        $aSpcWahChkDup = $this->mPosChanel->FSaMCHNEventSpcWahChkDup($aDataAdd);
        if( $aSpcWahChkDup['tCode'] != '1' ){
            $this->db->trans_begin();
            $this->mPosChanel->FSxMCHNEventSpcWahAdd($aDataAdd);
            $this->mPosChanel->FSxMCHNEventUpdDate($aDataAdd);
            if( $this->db->trans_status() === false ){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Add Channel Spc Wah'
                );
            }
        }else{
            $aReturn = array(
                'nStaEvent'        => '600',
                'tStaMessg'        => 'มีข้อมูลนี้อยู่แล้วในระบบ'
            );
        }
        echo json_encode($aReturn);
    }

    // Create By: Napat(Jame) 13/06/2022
    public function FSvCCHNPageSpcWahEdit(){
        $aDataSearch = array(
            'tType'        => 'Edit',
            'tChnCode'     => $this->input->post('tChnCode'),
            'tBchCode'     => $this->input->post('tBchCode'),
            'tWahCode'     => $this->input->post('tWahCode'),
            'FNLngID'      => $this->session->userdata("tLangEdit")
        );
        $aDataSpcWah     = $this->mPosChanel->FSaMCHNGetDataSpcWah($aDataSearch);
        $aDataSpcWahEdit = array(
            'aDataList' => $aDataSpcWah,
        );
        $this->load->view('pos/chanel/wPosChanelSpcWahAdd.php', $aDataSpcWahEdit);
    }

    
    // Create By: Napat(Jame) 13/06/2022
    public function FSaCCHNEventSpcWahEdit(){
        $aDataSearch = array(
            'FTAgnCode'     => $this->input->post('oetCSWAgnCodeOld'),
            'FTBchCode'     => $this->input->post('oetCSWBchCodeOld'),
            'FTWahCode'     => $this->input->post('oetCSWWahCodeOld'),
            'FTChnCode'     => $this->input->post('oetCSWChnCode'),
        );
        $aDataEdit = array(
            'FTAgnCode'     => $this->input->post('oetCSWAgnCode'),
            'FTBchCode'     => $this->input->post('oetCSWBchCode'),
            'FTWahCode'     => $this->input->post('oetCSWWahCode'),
            'FTChnCode'     => $this->input->post('oetCSWChnCode'),
            'FTChnStaDoc'   => $this->input->post('osbCSWType'),
        );
        // echo "<pre>";print_r($aDataSearch);print_r($aDataEdit);

        // ถ้าแก้ไขข้อมูล ให้เช็คว่าซ้ำไหม
        // แต่ถ้าไม่ได้แก้ไข แค่กดบันทึกเฉยๆ ข้ามการเช็คข้อมูลซ้ำ
        if( $aDataSearch['FTAgnCode'] != $aDataEdit['FTAgnCode'] || $aDataSearch['FTBchCode'] != $aDataEdit['FTBchCode'] || $aDataSearch['FTWahCode'] != $aDataEdit['FTWahCode'] ){
            $aSpcWahChkDup = $this->mPosChanel->FSaMCHNEventSpcWahChkDup($aDataEdit);
            if( $aSpcWahChkDup['tCode'] == '1' ){
                $aReturn = array(
                    'nStaEvent'        => '600',
                    'tStaMessg'        => 'มีข้อมูลนี้อยู่แล้วในระบบ'
                );
                echo json_encode($aReturn);
                return;
            }
        }

        $this->db->trans_begin();
        $this->mPosChanel->FSxMCHNEventSpcWahEdit($aDataSearch,$aDataEdit);
        $this->mPosChanel->FSxMCHNEventUpdDate($aDataEdit);
        if( $this->db->trans_status() === false ){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Edit Event"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success Edit Channel Spc Wah'
            );
        }
        echo json_encode($aReturn);
    }

    
    // Create By: Napat(Jame) 13/06/2022
    public function FSaCCHNEventSpcWahDel(){
        $aDataDel = array(
            'FTBchCode'     => $this->input->post('tBchCode'),
            'FTWahCode'     => $this->input->post('tWahCode'),
            'FTChnCode'     => $this->input->post('tChnCode')
        );
        $this->db->trans_begin();
        $this->mPosChanel->FSxMCHNEventSpcWahDel($aDataDel);
        if( $this->db->trans_status() === false ){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Delete Event"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success Delete Channel Spc Wah'
            );
        } 
        echo json_encode($aReturn);
    }

    // Create By: Napat(Jame) 14/06/2022
    public function FSaCHNEventChkSpcWah(){
        $aParamsData = array(
            'FTChnCode'     => $this->input->post('oetChnCode'),
            'FTAgnCode'     => $this->input->post('oetChnAgnCode'),
            'FTBchCode'     => $this->input->post('oetWahBchCodeCreated'),
        );

        if( $aParamsData['FTBchCode'] == "" && $aParamsData['FTAgnCode'] == "" ){
            $aChkSpcWah = array(
                'tCode' => '800',
                'tDesc' => 'not found data',
            );
        }else{
            $aChkSpcWah = $this->mPosChanel->FSaMCHNEventChkSpcWah($aParamsData);
        }
        echo json_encode($aChkSpcWah);
    }

    // Create By: Napat(Jame) 14/06/2022
    public function FSaCHNEventClearSpcWah(){
        $aParamsData = array(
            'FTChnCode'     => $this->input->post('oetChnCode'),
            'FTAgnCode'     => $this->input->post('oetChnAgnCode'),
            'FTBchCode'     => $this->input->post('oetWahBchCodeCreated'),
        );
        $this->mPosChanel->FSxMCHNEventClearSpcWah($aParamsData);
        if( $this->db->trans_status() === false ){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => $this->db->error()['message']
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success Clear Spc Wah'
            );
        } 
        echo json_encode($aReturn);
    }

    
    
}
