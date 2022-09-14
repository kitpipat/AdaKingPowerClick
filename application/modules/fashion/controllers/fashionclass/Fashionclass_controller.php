<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashionclass_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('fashion/fashionclass/Fashionclass_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Fashion Class  
     * Parameters : $nClsBrowseType, $tClsBrowseOption
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nClsBrowseType, $tClsBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('masPDTClass/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('fashion/fashionclass/wFashionclass', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nClsBrowseType' => $nClsBrowseType,
            'tClsBrowseOption' => $tClsBrowseOption
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

        $this->load->view('fashion/fashionclass/wFashionclassList');
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
        $aResList = $this->Fashionclass_model->FSaMFSCList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('fashion/fashionclass/wFashionclassDataTable', $aGenTable);
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

        $this->load->view('fashion/fashionclass/wFashionclassAdd', $aDataAdd);
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

        $tClsCode       = $this->input->post('tClsCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");


        $aData  = array(
            'FTClsCode' => $tClsCode,
            'FNLngID'   => $nLangEdit
        );


        $aChnData       = $this->Fashionclass_model->FSaMFSCSearchByID($aData);
        $aDataEdit      = array('aResult' => $aChnData);
        $this->load->view('fashion/fashionclass/wFashionclassAdd', $aDataEdit);
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
            $tIsAutoGenCode = $this->input->post('ocbFashionClassAutoGenCode');

            // Setup Reason Code
            $tClsCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TFHMPdtF2Class',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tClsCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tClsCode); die();
            } else {
                $tClsCode = $this->input->post('oetClsCode');
            }
            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");

            $aDataMaster = array(

                'FTClsCode'   =>  $tClsCode,
                // 'FTAgnCode'   =>  $tSesUsrAgnCode,
                'FTAgnCode'   =>   $this->input->post('oetClsAgnCode'), 
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTClsName'            => $this->input->post('oetClsName'),
                'FTClsRmk'            => $this->input->post('otaClsartRmk'),
                'tTypeInsertUpdate' => 'Insert'



            );
            // print_r($aDataMaster);
            // die();

            $oCountDup  = $this->Fashionclass_model->FSoMFSCCheckDuplicate($aDataMaster['FTClsCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                // Add or Update Slip
                $this->Fashionclass_model->FSaMFSCAddUpdateHD($aDataMaster);


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
                        'tCodeReturn'    => $aDataMaster['FTClsCode'],
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
                'FTClsCode'   =>  $this->input->post('oetClsCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTClsName'            => $this->input->post('oetClsName'),
                'FTClsRmk'            => $this->input->post('otaClsartRmk'),
                'FTAgnCode'   =>   $this->input->post('oetClsAgnCode'),
                'tTypeInsertUpdate' => 'Update'
            );

            $this->db->trans_begin();
            // Add or Update 
            $this->Fashionclass_model->FSaMFSCAddUpdateHD($aDataMaster);

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
                    'tCodeReturn'    => $aDataMaster['FTClsCode'],
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
                $oSlipMessage = $this->Fashionclass_model->FSoMFSCCheckDuplicate($tChnCode);

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
                'FTClsCode' => $aDataWhereDel['paClsCode'],
            ];

            $tResult    = $this->Fashionclass_model->FSaMFSCDeleteMultiple($aDataDelete);
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


        $tClsCode = $this->input->post('tClsCode');
        $aDataMaster = array(
            'FTClsCode' => $tClsCode,

        );
        $aResDel    = $this->Fashionclass_model->FSnMFSCDelHD($aDataMaster);
        $nNumRowChnLoc = $this->Fashionclass_model->FSnMLOCGetAllNumRow();
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
