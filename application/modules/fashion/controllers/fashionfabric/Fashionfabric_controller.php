<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashionfabric_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('fashion/fashionfabric/Fashionfabric_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Fashion Fabric  
     * Parameters : $nFabBrowseType, $tFabBrowseOption
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nFabBrowseType, $tFabBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('masPDTFabric/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('fashion/fashionfabric/wFashionfabric', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nFabBrowseType' => $nFabBrowseType,
            'tFabBrowseOption' => $tFabBrowseOption
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
    public function FSvCFSFListPage()
    {

        $this->load->view('fashion/fashionfabric/wFashionfabricList');
    }

    /**
     * Functionality : Function Call DataTables Fashion Fabric
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCFSFDataList()
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
        $aResList = $this->Fashionfabric_model->FSaMFSFList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('fashion/fashionfabric/wFashionfabricDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Fashion Fabric Add
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSFAddPage()
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

        $this->load->view('fashion/fashionfabric/wFashionfabricAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Fashion FabricEdit
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSFEditPage()
    {

        $tFabCode       = $this->input->post('tFabCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");


        $aData  = array(
            'FTFabCode' => $tFabCode,
            'FNLngID'   => $nLangEdit
        );


        $aChnData       = $this->Fashionfabric_model->FSaMFSFSearchByID($aData);
        $aDataEdit      = array('aResult' => $aChnData);
        $this->load->view('fashion/fashionfabric/wFashionfabricAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Fashion Fabric
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSFAddEvent()
    {
        try {
            $tIsAutoGenCode = $this->input->post('ocbFashionFabricAutoGenCode');

            // Setup Reason Code
            $tFabCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TFHMPdtFabric',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tFabCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tFabCode); die();
            } else {
                $tFabCode = $this->input->post('oetFabCode');
            }
            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");

            $aDataMaster = array(

                'FTFabCode'   =>  $tFabCode,
                // 'FTAgnCode'   =>  $tSesUsrAgnCode,
                'FTAgnCode'   =>   $this->input->post('oetFabAgnCode'), 
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTFabName'            => $this->input->post('oetFabName'),
                'FTFabRmk'            => $this->input->post('otaFabartRmk'),
                'tTypeInsertUpdate' => 'Insert'



            );
            // print_r($aDataMaster);
            // die();

            $oCountDup  = $this->Fashionfabric_model->FSoMFSFCheckDuplicate($aDataMaster['FTFabCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                // Add or Update Slip
                $this->Fashionfabric_model->FSaMFSFAddUpdateHD($aDataMaster);


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
                        'tCodeReturn'    => $aDataMaster['FTFabCode'],
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
     * Functionality : Event Edit Fashion Fabric
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSFEditEvent()
    {
        try {


            $aDataMaster = array(
                'FTFabCode'   =>  $this->input->post('oetFabCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTFabName'            => $this->input->post('oetFabName'),
                'FTFabRmk'            => $this->input->post('otaFabartRmk'),
                'FTAgnCode'   =>   $this->input->post('oetFabAgnCode'),
                'tTypeInsertUpdate' => 'Update'
            );

            $this->db->trans_begin();
            // Add or Update 
            $this->Fashionfabric_model->FSaMFSFAddUpdateHD($aDataMaster);

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
                    'tCodeReturn'    => $aDataMaster['FTFabCode'],
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


    public function FStFSFUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'smgcode') {

                $tChnCode = $this->input->post('tChnCode');
                $oSlipMessage = $this->Fashionfabric_model->FSoMFSFCheckDuplicate($tChnCode);

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
    public function FSoFSFDeleteMulti()
    {

        try {
            $this->db->trans_begin();
            $aDataWhereDel  = $this->input->post('paDataWhere');
            // print_r($aDataWhereDel); die();
            $aDataDelete    = [
                'FTFabCode' => $aDataWhereDel['paFabCode'],
            ];

            $tResult    = $this->Fashionfabric_model->FSaMFSFDeleteMultiple($aDataDelete);
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
    public function FSoFSFDelete()
    {


        $tFabCode = $this->input->post('tFabCode');
        $aDataMaster = array(
            'FTFabCode' => $tFabCode,

        );
        $aResDel    = $this->Fashionfabric_model->FSnMFSFDelHD($aDataMaster);
        $nNumRowChnLoc = $this->Fashionfabric_model->FSnMLOCGetAllNumRow();
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
