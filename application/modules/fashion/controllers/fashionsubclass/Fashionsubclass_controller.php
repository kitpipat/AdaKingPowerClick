<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashionsubclass_controller extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('fashion/fashionsubclass/Fashionsubclass_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function index($nSCLBrowseType, $tSCLBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('masPDTSubClass/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('fashion/fashionsubclass/wFashionsubclass', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nSCLBrowseType'    => $nSCLBrowseType,
            'tSCLBrowseOption'  => $tSCLBrowseOption
        ));
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSvCSCLPageList(){
        $this->load->view('fashion/fashionsubclass/wFashionsubclassList');
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSvCSCLPageDataTable(){
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

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'tSearchAll'    => $tSearchAll
        );
        $aGenTable = array(
            'aDataList'     => $this->Fashionsubclass_model->FSaMSCLDataList($aData),
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('fashion/fashionsubclass/wFashionsubclassDataTable', $aGenTable);
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSvCSCLPageAdd(){
        $aDataAdd = array(
            'aResult'   => array('rtCode' => '99')
        );
        $this->load->view('fashion/fashionsubclass/wFashionsubclassAdd', $aDataAdd);
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSvCSCLEventAdd(){
        try {
            $tIsAutoGenCode = $this->input->post('ocbSCLAutoGenCode');

            // Setup Reason Code
            $tSclCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TFHMPdtF3SubClass',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tSclCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tSclCode); die();
            } else {
                $tSclCode = $this->input->post('oetSclCode');
            }

            $aDataMaster = array(
                'FTSclCode'         => $tSclCode,
                'FTAgnCode'         => $this->input->post('oetSclAgnCode'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTSclName'         => $this->input->post('oetSclName'),
                'FTSclRmk'          => $this->input->post('otaSclRmk')
            );
            // print_r($aDataMaster);
            $bStaDup  = $this->Fashionsubclass_model->FSbMSCLCheckDuplicate($aDataMaster);
            if ($bStaDup) {
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            } else {
                $this->db->trans_begin();
                $this->Fashionsubclass_model->FSaMSCLEventAdd($aDataMaster);
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                } else {
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'      => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'       => $aDataMaster['FTSclCode'],
                        'nStaEvent'         => '1',
                        'tStaMessg'         => 'Success Add Event'
                    );
                }
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSvCSCLPageEdit(){
        $aData  = array(
            'FTSclCode' => $this->input->post('tSclCode'),
            // 'FTAgnCode' => $this->input->post('tAgnCode'),
            'FNLngID'   => $this->session->userdata("tLangEdit")
        );
        $aGetData       = $this->Fashionsubclass_model->FSaMSCLEventGetData($aData);
        $aDataEdit      = array('aResult' => $aGetData);
        $this->load->view('fashion/fashionsubclass/wFashionsubclassAdd', $aDataEdit);
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSvCSCLEventEdit(){
        $aDataMaster = array(
            'FTSclCode'         => $this->input->post('oetSclCode'),
            'FTAgnCode'         => $this->input->post('oetSclAgnCode'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'FTSclName'         => $this->input->post('oetSclName'),
            'FTSclRmk'          => $this->input->post('otaSclRmk'),
        );
        $this->db->trans_begin();
        $this->Fashionsubclass_model->FSxMSCLEventEdit($aDataMaster);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Edit Event"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack'      => $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'       => $aDataMaster['FTSclCode'],
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success Edit Event'
            );
        }
        echo json_encode($aReturn);
    }

    //Creator : 28/04/2021 Napat(Jame)
    public function FSvCSCLEventDelete(){
        try {
            $aDataCodeDel  = $this->input->post('aDataCodeDel');

            $this->db->trans_begin();
            $this->Fashionsubclass_model->FSxMSCLEventDelete($aDataCodeDel);
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data'
                );
            } else {
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete'
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

}

?>