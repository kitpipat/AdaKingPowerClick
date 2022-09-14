<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Installmentterms_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('payment/installmentterms/Installmentterms_model');
        date_default_timezone_set("Asia/Bangkok");
        // Test XSS Load Helper Security
        $this->load->helper("security");
        if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE){
            echo "ERROR XSS Filter";
        }
    }

    public function index($nStmBrowseType,$tStmBrowseOption){
        $nMsgResp   = array('title'=>"GroupSupplier");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('masInstallmentTerms/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('payment/installmentterms/wInstallmentTerms', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nStmBrowseType'    => $nStmBrowseType,
            'tStmBrowseOption'  => $tStmBrowseOption
        ));
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSvCSTMListPage(){
        $this->load->view('payment/installmentterms/wInstallmentTermsList');
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSvCSTMDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesUsrLevel'  => $this->session->userdata("tSesUsrLevel"),
                'tAgnCode'      => $this->session->userdata("tSesUsrAgnCode")
            );
            $aStmDataList   = $this->Installmentterms_model->FSaMSTMList($aData);
            $aGenTable  = array(
                'aStmDataList'      => $aStmDataList,
                'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll
            );
            $this->load->view('payment/installmentterms/wInstallmentTermsDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSvCSTMAddPage(){
        try{
            $aDataSupplierLevel = array(
                'nStaAddOrEdit'     => 99,
                'nOptDecimalShow'   => FCNxHGetOptionDecimalShow()
            );
            $this->load->view('payment/installmentterms/wInstallmentTermsAdd',$aDataSupplierLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSvCSTMEditPage(){
        try{
            $tStmCode       = $this->input->post('tStmCode');
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData  = array(
                'FTStmCode' => $tStmCode,
                'FNLngID'   => $nLangEdit
            );

            $aStmData = $this->Installmentterms_model->FSaMSTMGetDataByID($aData);
            $aDataSupplierLevel   = array(
                'nStaAddOrEdit'     => 1,
                'aStmData'          => $aStmData,
                'nOptDecimalShow'   => FCNxHGetOptionDecimalShow()
            );
            $this->load->view('payment/installmentterms/wInstallmentTermsAdd',$aDataSupplierLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSoCSTMAddEvent(){
        try{
            $aDataInsert   = array(
                'tIsAutoGenCode' => $this->input->post('ocbStmAutoGenCode'),
                'FTAgnCode'      => $this->input->post('oetStmAgnCode'),
                'FTStmCode'      => $this->input->post('oetStmCode'),
                'FTStmName'      => $this->input->post('oetStmName'),

                'FCStmLimit'     => floatval($this->input->post('oetStmLimit')),
                'FNStmQty'       => intval($this->input->post('oetStmQty')),
                'FCStmRate'      => floatval($this->input->post('oetStmRate')),
                'FTStmStaUnit'   => $this->input->post('ocmStmStaUnit'),

                'FTStmRmk'       => $this->input->post('otaStmRmk'),
                'FDLastUpdOn'    => date('Y-m-d H:i:s'),
                'FDCreateOn'     => date('Y-m-d H:i:s'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit")
            );

            if($aDataInsert['tIsAutoGenCode'] == '1'){
                $aStoreParam = array(
                    "tTblName"   => 'TFNMInstallment',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataInsert['FTStmCode']   = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup      = $this->Installmentterms_model->FSnMSTMCheckDuplicate($aDataInsert);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaStmMaster  = $this->Installmentterms_model->FSaMSTMAddUpdateMaster($aDataInsert);
                $aStaStmLang    = $this->Installmentterms_model->FSaMSTMAddUpdateLang($aDataInsert);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add TFNMInstallment"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataInsert['FTStmCode'],
                        'tAgnCode'	    => $aDataInsert['FTAgnCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add TFNMInstallment'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "รหัสเงื่อนไขนี้มีอยู่ในระบบแล้วกรุณาตรวจสอบอีกครั้ง"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSoCSTMEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataSupplierLevel   = array(
                'FTAgnCode'     => $this->input->post('oetStmAgnCode'),
                'FTStmCode'     => $this->input->post('oetStmCode'),
                'FTStmName'     => $this->input->post('oetStmName'),
                'FTStmRmk'      => $this->input->post('otaStmRmk'),

                'FCStmLimit'     => floatval($this->input->post('oetStmLimit')),
                'FNStmQty'       => intval($this->input->post('oetStmQty')),
                'FCStmRate'      => floatval($this->input->post('oetStmRate')),
                'FTStmStaUnit'   => $this->input->post('ocmStmStaUnit'),
                
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $aStaStmMaster  = $this->Installmentterms_model->FSaMSTMAddUpdateMaster($aDataSupplierLevel);
            $aStaStmLang    = $this->Installmentterms_model->FSaMSTMAddUpdateLang($aDataSupplierLevel);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit GroupSupplier"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataSupplierLevel['FTStmCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit GroupSupplier'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSoCSTMDeleteEvent(){
        $aDataMaster = array(
            'FTStmCode' => $this->input->post('tIDCode')
        );
        $aResDel    = $this->Installmentterms_model->FSaMSTMDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSvCSTMSubDataList(){
        try{
            $aData  = array(
                'nLngID'        => $this->session->userdata("tLangEdit"),
                'tAgnCode'      => $this->input->post('tAgnCode'),
                'tStmCode'      => $this->input->post('tStmCode'),
                'tCrdCode'      => $this->input->post('tCrdCode'),
                'tBnkCode'      => $this->input->post('tBnkCode')
            );
            $aStmSubDataList   = $this->Installmentterms_model->FSaMSTMSubList($aData);
            $aGenTable  = array(
                'aStmSubDataList'   => $aStmSubDataList
            );
            $this->load->view('payment/installmentterms/wInstallmentTermsSubDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSoCSTMSubEventAddEdit(){
        $oDataParam     = $this->input->post('poDataParam');
        $aDataAddEdit   = array();
        foreach($oDataParam as $nKey => $oValue){
            $aValue = json_decode($oValue);
            $aPackData = array(
                'FTAgnCode'     => $this->input->post('oetStmAgnCode'),
                'FTStmCode'     => $this->input->post('oetStmCode'),
                'FTCrdCode'     => $aValue[0],
                'FTBnkCode'     => $aValue[1]
            );
            array_push($aDataAddEdit,$aPackData);
        }
        $aResDel    = $this->Installmentterms_model->FSaMSTMSubEventAdd($aDataAddEdit);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSoCSTMSubEventDelete(){
        $aDataAddEdit = array(
            'FTAgnCode'     => $this->input->post('oetStmAgnCode'),
            'FTStmCode'     => $this->input->post('oetStmCode'),
            'FTCrdCode'     => $this->input->post('oetStmCrdCode')
        );
        $aResDel    = $this->Installmentterms_model->FSaMSTMSubEventDelete($aDataAddEdit);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}
