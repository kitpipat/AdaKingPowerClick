<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cGate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eticket/gate/mGate', 'mGate');
        $this->load->library("session");
    }

    // โหลดรายการสาขา Ajax
    public function FSxCGTE($nLocID) {
        $oHeader = $this->mGate->FSxMGTEHeader($nLocID);
        $oArea = $this->mGate->FSxMGTEArea($nLocID);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('eticket/gate/wGate', array(
            'oHeader' => $oHeader,
            'oAuthen' => $oAuthen,
            'oArea' => $oArea,
            'nLocID' => $nLocID
        ));
    }

    public function FSxCGTEList() {
        $tFTGateName = $this->input->post('tFTGateName');
        $nPageNo = $this->input->post('nPageNo');
        $nLocID = $this->input->post('nLocID');
        $nPageActive = $nPageNo;
        $oGateList = $this->mGate->FSxMGTE($tFTGateName, $nLocID, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('eticket/gate/wGateList', array(
            'oAuthen' => $oAuthen,
            'oGateList' => $oGateList
        ));
    }

    // นับจำนวนสาขา
    public function FSxCGTECount() {
        $tFTGateName = $this->input->post('tFTGateName');
        $nLocID = $this->input->post('nLocID');
        $oGateCntSh = $this->mGate->FSxMGTECount($tFTGateName, $nLocID);
        $tGateCount = $oGateCntSh [0]->counts;
        echo $tGateCount;
    }

    /**
     * FS เพิ่มข้อมูลทางเข้า
     */
    public function FSxCGTEAdd($nLocID) {
        $oHeader = $this->mGate->FSxMGTEHeader($nLocID);
        $oArea = $this->mGate->FSxMGTEArea($nLocID);
        $oSlc = $this->mGate->FSxMGTESlcZone($nLocID);
        $this->load->view('eticket/gate/wAdd', array(
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID,
            'oSlc' => $oSlc
        ));
    }

    /**
     * FS เพิ่มข้อมูลทางเข้า
     */
    public function FSxCGTEAddAjax() {
        if ($this->input->post('ocmFNZneID')) {
            $tData = array(
                'FNZneID' => $this->input->post('ocmFNZneID'),
                'FTGteName' => $this->input->post('oetFTGteName')
            );
            $tGteID = $this->mGate->FSxMGTEAdd($tData);
            echo $tGteID;
        }
    }

    /**
     * FS แก้ไขทางเข้า
     */
    public function FSxCGTEEdit($nLocID, $nGteID) {
        $oHeader = $this->mGate->FSxMGTEHeader($nLocID);
        $oArea = $this->mGate->FSxMGTEArea($nLocID);
        $oSlc = $this->mGate->FSxMGTESlcZone($nLocID);
        $oShow = $this->mGate->FSxMGTEShowEdit($nGteID);
        $this->load->view('eticket/gate/wEdit', array(
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID,
            'oShow' => $oShow,
            'oSlc' => $oSlc
        ));
    }

    /**
     * FS แก้ไขทางเข้า
     */
    public function FSxCGTEEditAjax() {
        if ($this->input->post('ohdFNGteID')) {
            $aData = array(
                'FNZneID' => $this->input->post('ocmFNZneID'),
                'FNGteID' => $this->input->post('ohdFNGteID'),
                'FTGteName' => $this->input->post('oetFTGteName')
            );
            $this->mGate->FSxMGTEEdit($aData);
        }
    }

    /**
     * FS ลบทางเข้า
     */
    public function FSxCGTEDel() {
        if ($this->input->post('tGteID')) {
            $ocbListItem = $this->input->post('tGteID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $tData = array(
                    'FNGteID' => $oValue
                );
                $this->mGate->FSxMGTEDel($tData);
            }
        }
    }

    public function FStCGTECheck() {
        if ($this->input->post('oetFTGteName')) {
            $tData = array(
                'FTGteName' => $this->input->post('oetFTGteName'),
                'FNZneID' => $this->input->post('nFNZneID')
            );
            $tCheck = $this->mGate->FSnMGTECheck($tData);
            if (@$tCheck [0]->counts > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

}
