<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cGateNew extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/gate/mGate', 'mGate');
        $this->load->library("session");
    }

    // โหลดรายการสาขา Ajax
    public function FSxCGTE($nLocID) {
        $oHeader = $this->mGate->FSxMGTEHeader($nLocID);
        $oArea = $this->mGate->FSxMGTEArea($nLocID);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('ticket/gate/wGateNew', array(
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
        $this->load->view('ticket/gate/wGateListNew', array(
            'oAuthen'   => $oAuthen,
            'oGateList' => $oGateList,
            'nPageNo'   => $nPageActive
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
        $this->load->view('ticket/gate/wAddNew', array(
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
        $this->load->view('ticket/gate/wEditNew', array(
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
