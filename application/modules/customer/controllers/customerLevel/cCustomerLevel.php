<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cCustomerLevel extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer/customerLevel/mCustomerLevel');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Customer Level
     * Parameters : $nCstLevBrowseType, $tCstLevBrowseOption
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCstLevBrowseType, $tCstLevBrowseOption)
    {
        $aDataConfigView    =   [
            'nCstLevBrowseType'     => $nCstLevBrowseType,
            'tCstLevBrowseOption'   => $tCstLevBrowseOption,
            'aAlwEvent'             => FCNaHCheckAlwFunc('customerLevel/0/0'),
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('customerLevel/0/0'),
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('customer/customerLevel/wCustomerLevel', $aDataConfigView);
    }

    /**
     * Functionality : Function Call Customer Level Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstLevListPage()
    {
        $this->load->view('customer/customerLevel/wCustomerLevelList');
    }

    /**
     * Functionality : Function Call DataTables Customer Level
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstLevDataList()
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
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMCstLev_L');
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
        $aResList = $this->mCustomerLevel->FSaMCstLevList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('customer/customerLevel/wCustomerLevelDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Customer Level Add
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstLevAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave = FCNaHGetAllLangByTable('TCNMCstLev_L');
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

        $this->load->view('customer/customerLevel/wCustomerLevelAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Customer Level Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstLevEditPage()
    {

        $tCstLevCode    = $this->input->post('tCstLevCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FTCstLevCode' => $tCstLevCode,
            'FNLngID'   => $nLangEdit
        );

        // Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aCstLevData       = $this->mCustomerLevel->FSaMCstLevSearchByID($tAPIReq, $tMethodReq, $aData);
        $aDataEdit      = array(
            'aResult' => $aCstLevData,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        
        $this->load->view('customer/customerLevel/wCustomerLevelAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Customer Level
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCstLevAddEvent()
    {
        try {
            date_default_timezone_set("Asia/Bangkok");
            $aDataMaster = array(
                'tIsAutoGenCode'  => $this->input->post('ocbCustomerLevelAutoGenCode'),
                'FTCstLevCode'    => $this->input->post('oetCstLevCode'),
                'FTCstLevRmk'     => $this->input->post('otaCstLevRemark'),
                'FTCstLevName'    => $this->input->post('oetCstLevName'),
                'FCLevRtePntAge'  => floatval($this->input->post('oetCstPointExp')),
                'FTPplCode'       => $this->input->post('oetCstLevPplCode'),
                'FCLevRtePntAmt'  => floatval($this->input->post('oetCstLevRtePntAmt')),
                'FCLevRtePntQty'  => floatval($this->input->post('oetCstLevRtePntQty')),
                'FTLevStaAlwPnt'  => (!empty($this->input->post('ocbCstLevStaAlwAccPoint'))) ? 1 : 2,
                'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                'FDCreateOn'      => date('Y-m-d H:i:s'),
                'FNLngID'         => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetCstLevAgnCode')
            );

            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen CustomerLevel Code?
                // Auto Gen CustomerLevel Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMCstLev',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTCstLevCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMCstLev','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTCstLevCode'] = $aGenCode['rtClvCode'];
                // }
            }

            $oCountDup  = $this->mCustomerLevel->FSoMCstLevCheckDuplicate($aDataMaster['FTCstLevCode']);
            $nStaDup    = $oCountDup[0]->counts;

            if ($nStaDup == 0) {
                $this->db->trans_begin();
                $aStaCstLevMaster  = $this->mCustomerLevel->FSaMCstLevAddUpdateMaster($aDataMaster);
                $aStaCstLevLang    = $this->mCustomerLevel->FSaMCstLevAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'    => $aDataMaster['FTCstLevCode'],
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
     * Functionality : Event Edit Customer Level
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCstLevEditEvent()
    {
        try {
            $aDataMaster = array(
                'FTCstLevCode' => $this->input->post('oetCstLevCode'),
                'FTCstLevRmk' => $this->input->post('otaCstLevRemark'),
                'FTCstLevName' => $this->input->post('oetCstLevName'),
                'FCLevRtePntAge'  => $this->input->post('oetCstPointExp'),
                'FTPplCode'       => $this->input->post('oetCstLevPplCode'),
                'FCLevRtePntAmt'  => str_replace(',', '', $this->input->post('oetCstLevRtePntAmt')),
                'FCLevRtePntQty'  => $this->input->post('oetCstLevRtePntQty'),
                'FTLevStaAlwPnt'   => (!empty($this->input->post('ocbCstLevStaAlwAccPoint'))) ? 1 : 2,
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'   => date('Y-m-d H:i:s'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetCstLevAgnCode'),
            );
            $this->db->trans_begin();
            $aStaCstLevMaster  = $this->mCustomerLevel->FSaMCstLevAddUpdateMaster($aDataMaster);
            $aStaCstLevLang    = $this->mCustomerLevel->FSaMCstLevAddUpdateLang($aDataMaster);
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
                    'tCodeReturn'    => $aDataMaster['FTCstLevCode'],
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
     * Functionality : Event Delete Customer Level
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCstLevDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCstLevCode' => $tIDCode
        );

        $aResDel = $this->mCustomerLevel->FSnMCstLevDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CstLevcode"
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCstLevUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'CstLevCode') {

                $tCstLevCode = $this->input->post('tCstLevCode');
                $oCustomerLevel = $this->mCustomerLevel->FSoMCstLevCheckDuplicate($tCstLevCode);

                $tStatus = 'false';
                if ($oCustomerLevel[0]->counts > 0) { // If have record
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
    //Parameters : Ajax Function Delete Customer Level
    //Creator : 14/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Delete And Status Call Back Event
    //Return Type : object
    public function FSoCstLevDeleteMulti()
    {
        $tCstLevCode = $this->input->post('tCstLevCode');

        $aCstLevCode = json_decode($tCstLevCode);
        foreach ($aCstLevCode as $oCstLevCode) {
            $aCstLev = ['FTCstLevCode' => $oCstLevCode];
            $this->mCustomerLevel->FSnMCstLevDel($aCstLev);
        }
        echo json_encode($aCstLevCode);
    }

    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCstLevDelete()
    {
        $tCstLevCode = $this->input->post('tCstLevCode');

        $aCstLev = ['FTCstLevCode' => $tCstLevCode];
        $this->mCustomerLevel->FSnMCstLevDel($aCstLev);
        echo json_encode($tCstLevCode);
    }
}
