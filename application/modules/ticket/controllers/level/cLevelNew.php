<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cLevelNew extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/level/mLevel', 'mLevel');
        $this->load->library("session");
    }

    public function FSxCLVL($nLocID) {
        $oHeader = $this->mLevel->FSxMLVLHeader($nLocID);
        $oArea = $this->mLevel->FSxMLVLArea($nLocID);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('ticket/level/wLevelNew', array(
            'oAuthen' => $oAuthen,
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID
        ));
    }

    /**
     * FS แสดงข้อมูล Table ในชั้น
     */
    public function FSxCLVLList() {
        $tFTLvlName = $this->input->post('tFTLvlName');
        $nPageNo = $this->input->post('nPageNo');
        $nLocID = $this->input->post('nLocID');
        $nPageActive = $nPageNo;
        $oLvlList = $this->mLevel->FSaMLVLList($tFTLvlName, $nLocID, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('ticket/level/wLevelListNew', array(
            'oAuthen' => $oAuthen,
            'oLvlList' => $oLvlList
        ));
    }

    public function FStCLVLCount() {
        $tFTLvlName = $this->input->post('tFTLvlName');
        $nLocID = $this->input->post('nLocID');
        $oParkCntSh = $this->mLevel->FStMLVLCount($tFTLvlName, $nLocID);
        $tParkCount = $oParkCntSh [0]->counts;
        echo $tParkCount;
    }

    /**
     * FS เพิ่มข้อมูลชั้น
     */
    public function FSxCLVLAdd($nLocID) {
        $oHeader = $this->mLevel->FSxMLVLHeader($nLocID);
        $oArea = $this->mLevel->FSxMLVLArea($nLocID);
        $this->load->view('ticket/level/wAddNew', array(
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID
        ));
    }

    public function FSxCLVLAddAjax() {
        if ($this->input->post('oetFTLevName')) {
            $aData = array(
                'FTLevName' => $this->input->post('oetFTLevName'),
                'FNLocID' => $this->input->post('ohdFNLocID')
            );
            $tLvlID = $this->mLevel->FSxMLVLAdd($aData);
            echo $tLvlID;
        }
    }

    /**
     * FS แก้ไขชั้น
     */
    public function FSxCLVLEdit($nLocID, $nLvlID) {
        $oHeader = $this->mLevel->FSxMLVLHeader($nLocID);
        $oArea = $this->mLevel->FSxMLVLArea($nLocID);
        $oEdit = $this->mLevel->FSxMLVLShowEdit($nLvlID);
        $this->load->view('ticket/level/wEditNew', array(
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID,
            'nLvlID' => $nLvlID,
            'oEdit' => $oEdit
        ));
    }

    public function FSxCLVLEditAjax() {
        if ($this->input->post('ohdFNLevID')) {
            $tData = array(
                'FTLevName' => $this->input->post('oetFTLevName'), // ชื่อชั้น
                'FNLevID' => $this->input->post('ohdFNLevID')
            ); // รหัสอ้างอืงสถานที่
            $tDB = $this->mLevel->FSxMLVLEdit($tData);
            echo $tDB;
        }
    }

    /**
     * FS ลบชั้น
     */
    public function FSxCLVLDel() {
        if ($this->input->post('tLevID')) {
            $ocbListItem = $this->input->post('tLevID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $aData = array(
                    'FNLevID' => $oValue
                );
                $o = $this->mLevel->FSxMLVLDel($aData);
                $aJson = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                echo json_encode($aJson);
            }
        }
    }

    public function FStCLVLCheck() {
        if ($this->input->post('oetFTLevName')) {
            $tData = array(
                'FTLevName' => $this->input->post('oetFTLevName'),
                'FNLocID' => $this->input->post('ohdFNLocID')
            );
            $tCheck = $this->mLevel->FStMLVLCheck($tData);

            if (@$tCheck [0]->counts > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

}
