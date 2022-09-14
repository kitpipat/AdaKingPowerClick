<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cDocEndOfBill extends MX_Controller {

    public function __construct() {

        parent::__construct ();
        $this->load->helper('url');
        $this->load->model('document/document/mDocEndOfBill');

    }

    /**
     * คำนวณ ภาษีท้ายบิล
     * ดึงข้อมูลจากตาราง TCNTDocDTTmp
     */
    public function FStCDOCEndOfBillCalVat(){

        $tDocNo = $this->input->post('tDocNo');
        
        $aParams = [
            'tDocNo' => $tDocNo,
            'tDocKey' => 'TAPTPcHD',
            'nLngID' => FCNaHGetLangEdit(),
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tBchCode' => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode')
        ];
        $aResult = FCNaDOCEndOfBillCalVat($aParams);
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResult));
    }
    
    /**
     * คำนวณ รายการท้ายบิล
     * ดึงข้อมูลจากตาราง TCNTDocDTTmp
     */
    public function FStCDOCEndOfBillCal(){

        $tDocNo = $this->input->post('tDocNo');
        $tDocKey = $this->input->post('tDocKey');
        
        $aCalcDTParams = [
            'tDataDocEvnCall' => '1',
            'tDataVatInOrEx' => '2',
            'tDataDocNo' => $tDocNo,
            'tDataDocKey' => 'TAPTPcHD',
            'tDataSeqNo' => ''
        ];
        
        var_dump(FCNbHCallCalcDocDTTemp($aCalcDTParams));
        
        $aParams = [
            'tDocNo' => $tDocNo,
            'tDocKey' => 'TAPTPcHD',
            'nLngID' => FCNaHGetLangEdit(),
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tBchCode' => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode')
        ];
        $aResult = FCNaDOCEndOfBillCal($aParams);
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResult));
    }

}


















































