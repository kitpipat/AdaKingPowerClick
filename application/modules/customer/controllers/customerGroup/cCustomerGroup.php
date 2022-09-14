<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cCustomerGroup extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer/customerGroup/mCustomerGroup');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Customer Group
     * Parameters : $nCstGrpBrowseType, $tCstGrpBrowseOption
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCstGrpBrowseType, $tCstGrpBrowseOption)
    {
        $aDataConfigView    = [
            'nCstGrpBrowseType'     => $nCstGrpBrowseType,
            'tCstGrpBrowseOption'   => $tCstGrpBrowseOption,
            'aAlwEvent'             => FCNaHCheckAlwFunc('customerGroup/0/0'),
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('customerGroup/0/0'),
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('customer/customerGroup/wCustomerGroup', $aDataConfigView);
    }

    /**
     * Functionality : Function Call Customer Group Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstGrpListPage()
    {
        $aDataConfigView    = ['aAlwEvent' => FCNaHCheckAlwFunc('customerGroup/0/0')];
        $this->load->view('customer/customerGroup/wCustomerGroupList', $aDataConfigView);
    }

    /**
     * Functionality : Function Call DataTables Customer Group
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstGrpDataList()
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
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMCstGrp_L');
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
            'tSearchAll'    => $tSearchAll,
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mCustomerGroup->FSaMCstGrpList($tAPIReq, $tMethodReq, $aData);

        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('customer/customerGroup/wCustomerGroupDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Customer Group Add
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstGrpAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave = FCNaHGetAllLangByTable('TCNMCstGrp_L');
        // $nLangHave = FCNnHSizeOf($aLangHave);
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
            'aResult'   => array(
                'rtCode' => '99',            
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName")
            )
        );

        $this->load->view('customer/customerGroup/wCustomerGroupAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Customer Group Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstGrpEditPage()
    {

        $tCstGrpCode       = $this->input->post('tCstGrpCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMCstGrp_L');
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
            'FTCstGrpCode' => $tCstGrpCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aCstGrpData       = $this->mCustomerGroup->FSaMCstGrpSearchByID($tAPIReq, $tMethodReq, $aData);
        $aDataEdit      = array('aResult' => $aCstGrpData);
        $this->load->view('customer/customerGroup/wCustomerGroupAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Customer Group
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCstGrpAddEvent()
    {
        try {
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCustomerGroupAutoGenCode'),
                'FTCstGrpCode'   => $this->input->post('oetCstGrpCode'),
                'FTCstGrpRmk'    => $this->input->post('otaCstGrpRemark'),
                'FTCstGrpName'   => $this->input->post('oetCstGrpName'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FDCreateOn'     => date('Y-m-d H:i:s'),
                'FNLngID'        => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetCstAgnCode')
            );

            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen Customer Group Code?
                // Auto Gen Customer Group Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMCstGrp',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTCstGrpCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMCstGrp','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTCstGrpCode'] = $aGenCode['rtCgpCode'];
                // }
            }

            $oCountDup  = $this->mCustomerGroup->FSoMCstGrpCheckDuplicate($aDataMaster['FTCstGrpCode']);
            $nStaDup    = $oCountDup[0]->counts;

            if ($nStaDup == 0) {
                $this->db->trans_begin();
                $aStaCstGrpMaster  = $this->mCustomerGroup->FSaMCstGrpAddUpdateMaster($aDataMaster);
                $aStaCstGrpLang    = $this->mCustomerGroup->FSaMCstGrpAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'    => $aDataMaster['FTCstGrpCode'],
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
     * Functionality : Event Edit Customer Group
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCstGrpEditEvent()
    {
        try {
            $aDataMaster = array(
                'FTCstGrpCode'  => $this->input->post('oetCstGrpCode'),
                'FTCstGrpRmk'   => $this->input->post('otaCstGrpRemark'),
                'FTCstGrpName'  => $this->input->post('oetCstGrpName'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetCstAgnCode')
            );

            $this->db->trans_begin();
            $aStaCstGrpMaster  = $this->mCustomerGroup->FSaMCstGrpAddUpdateMaster($aDataMaster);
            $aStaCstGrpLang    = $this->mCustomerGroup->FSaMCstGrpAddUpdateLang($aDataMaster);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTCstGrpCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Event Delete Customer Group
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCstGrpDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCstGrpCode' => $tIDCode
        );

        $aResDel = $this->mCustomerGroup->FSnMCstGrpDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CstGrpcode"
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String 
     */
    public function FStCstGrpUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'CstGrpCode') {

                $tCstGrpCode = $this->input->post('tCstGrpCode');
                $oCustomerGroup = $this->mCustomerGroup->FSoMCstGrpCheckDuplicate($tCstGrpCode);

                $tStatus = 'false';
                if ($oCustomerGroup[0]->counts > 0) { // If have record
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

    //Functionality : Function Event Multi Delete
    //Parameters : Ajax Function Delete Customer Group
    //Creator : 14/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Delete And Status Call Back Event
    //Return Type : object
    public function FSoCstGrpDeleteMulti()
    {
        $tCstGrpCode = $this->input->post('tCstGrpCode');

        $aCstGrpCode = json_decode($tCstGrpCode);
        foreach ($aCstGrpCode as $oCstGrpCode) {
            $aCstGrp = ['FTCstGrpCode' => $oCstGrpCode];
            $this->mCustomerGroup->FSnMCstGrpDel($aCstGrp);
        }
        echo json_encode($aCstGrpCode);
    }

    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCstGrpDelete()
    {
        $tCstGrpCode = $this->input->post('tCstGrpCode');

        $aCstGrp = ['FTCstGrpCode' => $tCstGrpCode];
        $this->mCustomerGroup->FSnMCstGrpDel($aCstGrp);
        echo json_encode($tCstGrpCode);
    }
}
