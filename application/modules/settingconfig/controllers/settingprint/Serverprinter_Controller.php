<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Serverprinter_Controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settingconfig/settingprint/Serverprinter_Model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Server Printer
     * Parameters : $nSrvPriBrowseType, $tSrvPriBrowseOption
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nSrvPriBrowseType, $tSrvPriBrowseOption)
    {
        $aDataConfigView    = [
            'nSrvPriBrowseType'     => $nSrvPriBrowseType,
            'tSrvPriBrowseOption'   => $tSrvPriBrowseOption,
            // 'aAlwEvent'             => FCNaHCheckAlwFunc('settingprint/0/0'),
            'aAlwEvent'             => ['tAutStaFull' => 1, 'tAutStaAdd' => 1, 'tAutStaEdit' => 1],
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('settingprint/0/0'),
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('settingconfig/settingprint/wServerPrinter', $aDataConfigView);
    }

    /**
     * Functionality : Function Call Server Printer Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSrvPriListPage()
    {
        $aDataConfigView    = ['aAlwEvent'             => ['tAutStaFull' => 1, 'tAutStaAdd' => 1, 'tAutStaEdit' => 1]];
        $this->load->view('settingconfig/settingprint/wServerPrinterList', $aDataConfigView);
    }

    /**
     * Functionality : Function Call DataTables Server Printer
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSrvPriDataList()
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


        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
        );


        $aResList = $this->Serverprinter_Model->FSaMSrvPriList($aData);

        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('settingconfig/settingprint/wServerPrinterDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Server Printer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSrvPriAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");


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

        $this->load->view('settingconfig/settingprint/wServerPrinterAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Server Printer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSrvPriEditPage()
    {

        $tSrvPriCode       = $this->input->post('tSrvPriCode');
        $tSrvPriAgnCode       = $this->input->post('tSrvPriAgnCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");


        $aData  = array(
            'FTSrvPriCode' => $tSrvPriCode,
            'FTAgnCode' => $tSrvPriAgnCode,
            'FNLngID'   => $nLangEdit
        );


        $aSrvPriData       = $this->Serverprinter_Model->FSaMSrvPriSearchByID($aData);
        $aDataEdit      = array('aResult' => $aSrvPriData);
        $this->load->view('settingconfig/settingprint/wServerPrinterAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Server Printer
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaSrvPriAddEvent()
    {
        try {
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbSrvPriAutoGenCode'),
                'FTAgnCode'   => $this->input->post('oetSrvPriAgnCode'),
                'FTSrvPriCode'   => $this->input->post('oetSrvPriCode'),
                'FTSrvPriRmk'    => $this->input->post('otaSrvPriRemark'),
                'FTSrvPriName'   => $this->input->post('oetSrvPriName'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FDCreateOn'     => date('Y-m-d H:i:s'),
                'FNLngID'        => $this->session->userdata("tLangEdit"),
                'FTSrvPriStaUse'       => (!empty($this->input->post('ocbSrvPriStatusUse'))) ? 1 : 2,
            );

            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen Server Printer Code?
                // Auto Gen Server Printer Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPrnServer',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTSrvPriCode']   = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup  = $this->Serverprinter_Model->FSoMSrvPriCheckDuplicate($aDataMaster['FTSrvPriCode'],$aDataMaster['FTAgnCode']);
            $nStaDup    = $oCountDup[0]->counts;

            if ($nStaDup == 0) {
                $this->db->trans_begin();
                $aStaSrvPriMaster  = $this->Serverprinter_Model->FSaMSrvPriAddUpdateMaster($aDataMaster);
                $aStaSrvPriLang    = $this->Serverprinter_Model->FSaMSrvPriAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'    => $aDataMaster['FTSrvPriCode'],
                        'tCodeReturn2'    => $aDataMaster['FTAgnCode'],
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
     * Functionality : Event Edit Server Printer
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaSrvPriEditEvent()
    {
        try {
            $aDataMaster = array(
                'FTAgnCode'    => $this->input->post('oetSrvPriAgnCode'),
                'FTSrvPriCode'  => $this->input->post('ohdSrvPriCode'),
                'FTSrvPriRmk'   => $this->input->post('otaSrvPriRemark'),
                'FTSrvPriName'  => $this->input->post('oetSrvPriName'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTSrvPriStaUse'       => (!empty($this->input->post('ocbSrvPriStatusUse'))) ? 1 : 2,
                // 'FTAgnCode'  => $this->input->post('oetCstAgnCode')
            );

            $this->db->trans_begin();
            $aStaSrvPriMaster  = $this->Serverprinter_Model->FSaMSrvPriAddUpdateMaster($aDataMaster);
            $aStaSrvPriLang    = $this->Serverprinter_Model->FSaMSrvPriAddUpdateLang($aDataMaster);

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
                    'tCodeReturn'    => $aDataMaster['FTSrvPriCode'],
                    'tCodeReturn2'    => $aDataMaster['FTAgnCode'],
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
     * Functionality : Event Delete Server Printer
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaSrvPriDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $tAgnCode = $this->input->post('tAgnCode');
        $aDataMaster = array(
            'FTSrvPriCode' => $tIDCode,
            'FTAgnCode' => $tAgnCode
        );

        $aResDel = $this->Serverprinter_Model->FSnMSrvPriDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "SrvPricode"
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String 
     */
    public function FStSrvPriUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'SrvPriCode') {

                $tSrvPriCode = $this->input->post('tSrvPriCode');
                $tSrvPriAgnCode = $this->input->post('tSrvPriAgnCode');
                $oCustomerGroup = $this->Serverprinter_Model->FSoMSrvPriCheckDuplicate($tSrvPriCode,$tSrvPriAgnCode);

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
    //Parameters : Ajax Function Delete Server Printer
    //Creator : 14/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Delete And Status Call Back Event
    //Return Type : object
    public function FSoSrvPriDeleteMulti()
    {
        $tSrvPriCode = $this->input->post('tSrvPriCode');
        $tSrvPriAgnCode = $this->input->post('tSrvPriAgnCode');
        $aSrvPriCode = json_decode($tSrvPriCode);
        $aSrvPriAgnCode = json_decode($tSrvPriAgnCode);
        foreach ($aSrvPriCode as $nK => $oSrvPriCode) {
            $aSrvPri = ['FTSrvPriCode' => $oSrvPriCode , 'FTAgnCode' => $aSrvPriAgnCode[$nK]];
            $this->Serverprinter_Model->FSnMSrvPriDel($aSrvPri);
        }
        echo json_encode($aSrvPriCode);
    }

    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoSrvPriDelete()
    {
        $tSrvPriCode = $this->input->post('tSrvPriCode');
        $tSrvPriAgnCode = $this->input->post('tSrvPriAgnCode');
        $aSrvPri = ['FTSrvPriCode' => $tSrvPriCode , 'FTAgnCode'=> $tSrvPriAgnCode];
        $this->Serverprinter_Model->FSnMSrvPriDel($aSrvPri);
        echo json_encode($tSrvPriCode);
    }
}
