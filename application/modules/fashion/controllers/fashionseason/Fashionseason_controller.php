<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashionseason_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('fashion/fashionseason/Fashionseason_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Fashion Season  
     * Parameters : $nSeaBrowseType, $tSeaBrowseOption
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nSeaBrowseType, $tSeaBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('masPDTSeason/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('fashion/fashionseason/wFashionseason', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nSeaBrowseType' => $nSeaBrowseType,
            'tSeaBrowseOption' => $tSeaBrowseOption
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
    public function FSvCFSSListPage()
    {

        $this->load->view('fashion/fashionseason/wFashionseasonList');
    }

    /**
     * Functionality : Function Call DataTables Fashion Season
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCFSSDataList()
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
        $aResList = $this->Fashionseason_model->FSaMFSSList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('fashion/fashionseason/wFashionseasonDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Fashion Season Add
     * Parameters : Ajax and Function Parameter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSSAddPage()
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

        $this->load->view('fashion/fashionseason/wFashionseasonAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Fashion SeasonEdit
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvFSSEditPage()
    {

        $tSeaCode       = $this->input->post('tSeaCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");


        $aData  = array(
            'FTSeaCode' => $tSeaCode,
            'FNLngID'   => $nLangEdit
        );


        $aChnData       = $this->Fashionseason_model->FSaMFSSSearchByID($aData);
        $aDataEdit      = array('aResult' => $aChnData);
        $this->load->view('fashion/fashionseason/wFashionseasonAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Fashion Season
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSSAddEvent()
    {
        try {
            $tIsAutoGenCode = $this->input->post('ocbFashionSeasonAutoGenCode');

            // Setup Reason Code
            $tSeaCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TFHMPdtSeason',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tSeaCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tSeaCode); die();
            } else {
                $tSeaCode = $this->input->post('oetSeaCode');
            }
            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");
            $nSeaLel =     $this->input->post('ocbFashionSeasonLevel');
    
            if ($nSeaLel !='' && !empty($nSeaLel)) {
             
                $nSeaLevel = 1;
                $tSeaChain = $tSeaCode;
                $tSeaChainName = $this->input->post('oetSeaName');
                $tSeaParent = $tSeaCode;
                
            } else {
           
                $nSeaLevel = $this->input->post('oetSeaChainLev');
                $tSeaChain = $this->input->post('oetSeaChainCode').$tSeaCode;
                $tSeaChainName = $this->input->post('oetSeaChainNameShow').' > '.$this->input->post('oetSeaName');
                $tSeaParent = $this->input->post('oetSeaParentCode');
            }

            $aDataMaster = array(

                'FTSeaCode'   =>  $tSeaCode,
                'FTSeaChain'   =>  $tSeaChain,
                'FNSeaLevel'   =>  $nSeaLevel,
                'FTSeaParent'   => $tSeaParent,
                'FTAgnCode'     =>  $this->input->post('oetSeaAgnCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),


                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTSeaName'         => $this->input->post('oetSeaName'),
                'FTSeaChainName'     => $tSeaChainName,
                'FTSeaRmk'           => $this->input->post('otaSeaartRmk'),
                'tTypeInsertUpdate' => 'Insert'



            );
       
            $oCountDup  = $this->Fashionseason_model->FSoMFSSCheckDuplicate($aDataMaster['FTSeaCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                // Add or Update Slip
                $this->Fashionseason_model->FSaMFSSAddUpdateHD($aDataMaster);


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
                        'tCodeReturn'    => $aDataMaster['FTSeaCode'],
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
     * Functionality : Event Edit Fashion Season
     * Parameters : Ajax and Function Parameter
     * Creator :26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaFSSEditEvent()
    {
        try {


            $aDataMaster = array(
                'FTSeaCode'   =>  $this->input->post('oetSeaCode'),
                'FTSeaChain'   =>  $this->input->post('oetSeaChainCode'),
                'FNSeaLevel'   =>  $this->input->post('oetSeaChainLev'),
                'FTSeaParent'   => $this->input->post('oetSeaParentCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTSeaName'            => $this->input->post('oetSeaName'),
                'FTSeaChainName'            => $this->input->post('oetSeaName'),
                'FTSeaRmk'            => $this->input->post('otaSeaartRmk'),
                'FTAgnCode'   =>   $this->input->post('oetSeaAgnCode'),
                'tTypeInsertUpdate' => 'Update'
            );

            $this->db->trans_begin();
            // Add or Update 
            $this->Fashionseason_model->FSaMFSSAddUpdateHD($aDataMaster);

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
                    'tCodeReturn'    => $aDataMaster['FTSeaCode'],
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


    public function FStFSSUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'smgcode') {

                $tChnCode = $this->input->post('tChnCode');
                $oSlipMessage = $this->Fashionseason_model->FSoMFSSCheckDuplicate($tChnCode);

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
    public function FSoFSSDeleteMulti()
    {

        try {
            $this->db->trans_begin();
            $aDataWhereDel  = $this->input->post('paDataWhere');
            // print_r($aDataWhereDel); die();
            $aDataDelete    = [
                'FTSeaCode' => $aDataWhereDel['paSeaCode'],
            ];

            $tResult    = $this->Fashionseason_model->FSaMFSSDeleteMultiple($aDataDelete);
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
    public function FSoFSSDelete()
    {


        $tSeaCode = $this->input->post('tSeaCode');
        $aDataMaster = array(
            'FTSeaCode' => $tSeaCode,

        );
        $aResDel    = $this->Fashionseason_model->FSnMFSSDelHD($aDataMaster);
        $nNumRowChnLoc = $this->Fashionseason_model->FSnMLOCGetAllNumRow();
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


    public function FSvCFSSDataListChain()
    {

        $tSeaChain  = $this->input->post('tSeaChain');
        $tSeaLevel  = $this->input->post('tSeaLevel');
        echo   $this->Fashionseason_model->FSaMFSSListChain($tSeaChain, $tSeaLevel);
    }
}
