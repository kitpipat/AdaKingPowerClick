<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashiondepart_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('fashion/fashiondepart/Fashiondepart_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Fashion Depart
     * Parameters : $nDepBrowseType, $tDepBrowseOption
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nDepBrowseType, $tDepBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('fashiondepart/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('fashion/fashiondepart/wFashiondepart', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nDepBrowseType' => $nDepBrowseType,
            'tDepBrowseOption' => $tDepBrowseOption
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
    public function FSvCFSDListPage()
    {

        $this->load->view('fashion/fashiondepart/wFashiondepartList');
    }

    /**
     * Functionality : Function Call DataTables Fashion Depart
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCFSDDataList()
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
        $aResList = $this->Fashiondepart_model->FSaMFSDList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('fashion/fashiondepart/wFashiondepartDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Fashion Depart Add
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSDAddPage()
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

        $this->load->view('fashion/fashiondepart/wFashiondepartAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Fashion DepartEdit
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSDEditPage()
    {

        $tDepCode       = $this->input->post('tDepCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");


        $aData  = array(
            'FTDepCode' => $tDepCode,
            'FNLngID'   => $nLangEdit
        );


        $aChnData       = $this->Fashiondepart_model->FSaMFSDSearchByID($aData);
        $aDataEdit      = array('aResult' => $aChnData);
        $this->load->view('fashion/fashiondepart/wFashiondepartAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Fashion Depart
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSDAddEvent()
    {
        try {
            $tIsAutoGenCode = $this->input->post('ocbFashionDepartAutoGenCode');

            // Setup Reason Code
            $tChnCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TFHMPdtF1Depart',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tChnCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tChnCode); die();
            } else {
                $tChnCode = $this->input->post('oetDepCode');
            }
            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");

            $aDataMaster = array(

                'FTDepCode'   =>  $tChnCode,
                // 'FTAgnCode'   =>  $tSesUsrAgnCode,
                'FTAgnCode'   =>   $this->input->post('oetDepAgnCode'), 
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTDepName'            => $this->input->post('oetDepName'),
                'FTDepRmk'            => $this->input->post('otaDepartRmk'),
                'tTypeInsertUpdate' => 'Insert'



            );
        

            $oCountDup  = $this->Fashiondepart_model->FSoMFSDCheckDuplicate($aDataMaster['FTDepCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                // Add or Update Slip
                $this->Fashiondepart_model->FSaMFSDAddUpdateHD($aDataMaster);


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
                        'tCodeReturn'    => $aDataMaster['FTDepCode'],
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
     * Functionality : Event Edit Fashion Depart
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSDEditEvent()
    {
        try {


            $aDataMaster = array(
                'FTDepCode'   =>  $this->input->post('oetDepCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTDepName'            => $this->input->post('oetDepName'),
                'FTDepRmk'            => $this->input->post('otaDepartRmk'),
                'FTAgnCode'   =>   $this->input->post('oetDepAgnCode'), 
                'tTypeInsertUpdate' => 'Update'
            );

            // print_r($aDataMaster);
            // die();

            $this->db->trans_begin();
            // Add or Update 
            $this->Fashiondepart_model->FSaMFSDAddUpdateHD($aDataMaster);

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
                    'tCodeReturn'    => $aDataMaster['FTDepCode'],
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


    public function FStFSDUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'smgcode') {

                $tChnCode = $this->input->post('tChnCode');
                $oSlipMessage = $this->Fashiondepart_model->FSoMFSDCheckDuplicate($tChnCode);

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
    public function FSoFSDDeleteMulti()
    {

        try {
            $this->db->trans_begin();
            $aDataWhereDel  = $this->input->post('paDataWhere');
            // print_r($aDataWhereDel); die();
            $aDataDelete    = [
                'FTDepCode' => $aDataWhereDel['paDepCode'],
            ];

            $tResult    = $this->Fashiondepart_model->FSaMFSDDeleteMultiple($aDataDelete);
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
    public function FSoFSDDelete()
    {


        $tDepCode = $this->input->post('tDepCode');
        $aDataMaster = array(
            'FTDepCode' => $tDepCode,

        );
        $aResDel    = $this->Fashiondepart_model->FSnMFSDDelHD($aDataMaster);
        $nNumRowChnLoc = $this->Fashiondepart_model->FSnMLOCGetAllNumRow();
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
