<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cDayoffNew extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/dayoff/mDayoffNew', 'mDayoff');
        $this->load->library("session");
    }

    public function FSxCDOF($nLocID) {
        $oHeader = $this->mDayoff->FSxMDOFHeader($nLocID);
        $oArea = $this->mDayoff->FSxMDOFArea($nLocID);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('ticket/dayoff/wDayoffNew', array(
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'oAuthen' => $oAuthen,
            'nLocID' => $nLocID
        ));
    }

    public function FSxCDOFList() {
        $tFDLdoDateFrm = FsxDate($this->input->post('tFDLdoDateFrm'));
        $nPageNo = $this->input->post('nPageNo');
        $nLocID = $this->input->post('nLocID');
        $nPageActive = $nPageNo;
        $oDOFList = $this->mDayoff->FSaMDOFList($tFDLdoDateFrm, $nLocID, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('ticket/dayoff/wDayoffList', array(
            'oDOFList' => $oDOFList,
            'oAuthen' => $oAuthen
        ));
    }

    public function FStCDOFCount() {
        $tFDLdoDateFrm = FsxDate($this->input->post('tFDLdoDateFrm'));
        $nLocID = $this->input->post('nLocID');
        $oDOWCnt = $this->mDayoff->FStMDOFCount($tFDLdoDateFrm, $nLocID);
        $tDOWCnt = $oDOWCnt [0]->counts;
        echo $tDOWCnt;
    }

    public function FSxCDOFAdd($nLocID) {
        $oHeader = $this->mDayoff->FSxMDOFHeader($nLocID);
        $oArea = $this->mDayoff->FSxMDOFArea($nLocID);
        $this->load->view('ticket/dayoff/wAddNew', array(
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID
        ));
    }

    public function FSxCDOFAjax() {
        if ($this->input->post('oetFDLdoDateFrm')) {
            $aData = array(
                'FDLdoDateFrm' => FsxDateTime($this->input->post('oetFDLdoDateFrm')),
                'FDLdoDateTo' => FsxDateTime($this->input->post('oetFDLdoDateTo')),
                'FTLdoRmk' => $this->input->post('otaFTLdoRmk'),
                'FNLocID' => $this->input->post('ohdFNLocID')
            );
            $nLdoID = $this->mDayoff->FSxMDOFAdd($aData);
            echo $nLdoID;
        }
    }

    /**
     * FS แก้ไขชั้น
     */
    public function FSxCDOFEdit($nLocID, $nDOFID) {
        $oHeader = $this->mDayoff->FSxMDOFHeader($nLocID);
        $oArea = $this->mDayoff->FSxMDOFArea($nLocID);
        $oEdit = $this->mDayoff->FSxMDOFShowEdit($nDOFID);
        $this->load->view('ticket/dayoff/wEditNew', array(
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID,
            'nDOFID' => $nDOFID,
            'oEdit' => $oEdit
        ));
    }

    public function FSxCDOFEditAjax() {
        if ($this->input->post('oetFDLdoDateFrm')) {
            $tData = array(
                'FDLdoDateFrm' => FsxDateTime($this->input->post('oetFDLdoDateFrm')),
                'FDLdoDateTo' => FsxDateTime($this->input->post('oetFDLdoDateTo')),
                'FTLdoRmk' => $this->input->post('otaFTLdoRmk'),
                'FNLdoID' => $this->input->post('ohdFNLdoID')
            );
            $this->mDayoff->FSxMDOFEdit($tData);
        }
    }

    /**
     * FS ลบชั้น
     */
    public function FSxCDOFDel() {
        if ($this->input->post('nFNLdoID')) {
            $tData = array(
                'FNLdoID' => $this->input->post('nFNLdoID')
            );
            $this->mDayoff->FSxMDOFDel($tData);
        }
    }

}
