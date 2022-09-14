<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashioncomlines_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('fashion/fashioncomlines/Fashioncomlines_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Fashion Class
     * Parameters : $nCmlBrowseType, $tCmlBrowseOption
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCmlBrowseType, $tCmlBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('masPDTComlines/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('fashion/fashioncomlines/wFashioncomlines', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nCmlBrowseType' => $nCmlBrowseType,
            'tCmlBrowseOption' => $tCmlBrowseOption
        ));
    }

    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCFSCListPage()
    {

        $this->load->view('fashion/fashioncomlines/wFashioncomlinesList');
    }

    /**
     * Functionality : Function Call DataTables Fashion Class
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCFSCDataList()
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
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->Fashioncomlines_model->FSaMFSCList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('fashion/fashioncomlines/wFashioncomlinesDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Fashion Class Add
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSCAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aDataAdd = array(
            'aResult'   => array('rtCode' => '99')
        );

        $this->load->view('fashion/fashioncomlines/wFashioncomlinesAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Fashion ClassEdit
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSCEditPage()
    {

        $tCmlCode       = $this->input->post('tCmlCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");


        $aData  = array(
            'FTCmlCode' => $tCmlCode,
            'FNLngID'   => $nLangEdit
        );


        $aChnData       = $this->Fashioncomlines_model->FSaMFSCSearchByID($aData);
        $aDataEdit      = array('aResult' => $aChnData);
        $this->load->view('fashion/fashioncomlines/wFashioncomlinesAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Fashion Class
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSCAddEvent()
    {
        try {
            $tIsAutoGenCode = $this->input->post('ocbFashionComlinesAutoGenCode');

            // Setup Reason Code
            $tCmlCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TFHMPdtF5ComLines',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tCmlCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tCmlCode); die();
            } else {
                $tCmlCode = $this->input->post('oetCmlCode');
            }
            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");

            $aDataMaster = array(

                'FTCmlCode'   =>  $tCmlCode,
                // 'FTAgnCode'   =>  $tSesUsrAgnCode,
                'FTAgnCode'   =>   $this->input->post('oetCmlAgnCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTCmlName'            => $this->input->post('oetCmlName'),
                'FTCmlRmk'            => $this->input->post('otaCmlartRmk'),
                'tTypeInsertUpdate' => 'Insert'



            );
            // print_r($aDataMaster);
            // die();

            $oCountDup  = $this->Fashioncomlines_model->FSoMFSCCheckDuplicate($aDataMaster['FTCmlCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                // Add or Update Slip
                $this->Fashioncomlines_model->FSaMFSCAddUpdateHD($aDataMaster);


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
                        'tCodeReturn'    => $aDataMaster['FTCmlCode'],
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
     * Functionality : Event Edit Fashion Class
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSCEditEvent()
    {
        try {


            $aDataMaster = array(
                'FTCmlCode'   =>  $this->input->post('oetCmlCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTCmlName'            => $this->input->post('oetCmlName'),
                'FTCmlRmk'            => $this->input->post('otaCmlartRmk'),
                'FTAgnCode'   =>   $this->input->post('oetCmlAgnCode'),
                'tTypeInsertUpdate' => 'Update'
            );

            $this->db->trans_begin();
            // Add or Update
            $this->Fashioncomlines_model->FSaMFSCAddUpdateHD($aDataMaster);

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
                    'tCodeReturn'    => $aDataMaster['FTCmlCode'],
                    // 'tCodeBchReturn'    => $aDataMaster['FTBchCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Update Event'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    public function FStFSCUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'smgcode') {

                $tChnCode = $this->input->post('tChnCode');
                $oSlipMessage = $this->Fashioncomlines_model->FSoMFSCCheckDuplicate($tChnCode);

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
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoFSCDeleteMulti()
    {

        try {
            $this->db->trans_begin();
            $aDataWhereDel  = $this->input->post('paDataWhere');
            // print_r($aDataWhereDel); die();
            $aDataDelete    = [
                'FTCmlCode' => $aDataWhereDel['paCmlCode'],
            ];

            $tResult    = $this->Fashioncomlines_model->FSaMFSCDeleteMultiple($aDataDelete);
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
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoFSCDelete()
    {


        $tCmlCode = $this->input->post('tCmlCode');
        $aDataMaster = array(
            'FTCmlCode' => $tCmlCode,

        );
        $aResDel    = $this->Fashioncomlines_model->FSnMFSCDelHD($aDataMaster);
        $nNumRowChnLoc = $this->Fashioncomlines_model->FSnMLOCGetAllNumRow();
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
}
