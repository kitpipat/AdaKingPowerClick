<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cTimetable extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->model('ticket/timetable/mTimeTable', 'mTimeTable');
    }

    public function FSxCTTB() {
        $oAuthen = FCNaHCheckAlwFunc('EticketTimeTable');
        $this->load->view('ticket/timetable/wTimeTable', array(
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCTTBAjaxList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketTimeTable');
        $tFTTmhName = $this->input->post('tFTTmhName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oList = $this->mTimeTable->FSxMTTBAjaxList($tFTTmhName, $nPageActive);
        $this->load->view('ticket/timetable/wTimeTableList', array(
            'oAuthen'   => $oAuthen,
            'oList'     => $oList,
            'nPageNo'   => $nPageNo
        ));
    }

    public function FStCTTBCount() {
        $tFTTmhName = $this->input->post('tFTTmhName');
        $oCnt = $this->mTimeTable->FStMTTBCount($tFTTmhName);
        $oCount = $oCnt [0]->counts;
        echo $oCount;
    }

    public function FSxCTTBAdd() {
        $this->load->view('ticket/timetable/wAdd', array());
    }

    public function FSxCTTBAddAjax() {
        if ($this->input->post('oetFTTmhName')) {
            $aData = array(
                'FTTmhName' => $this->input->post('oetFTTmhName'),
                'FTTmhStaActive' => ($this->input->post('ocbFTTmhStaActive') == "" ? "2" : "1"),
                'FTTmhRmk' => $this->input->post('otaFTTmhRmk')
            );
            $nFNTmhID = $this->mTimeTable->FSxMTTBAddAjax($aData);
            echo $nFNTmhID;
        }
    }

    public function FSxCTTBEdit($nFNTmhID) {
        $oShow = $this->mTimeTable->FSxMTTBEdit($nFNTmhID);
        $this->load->view('ticket/timetable/wEdit', array(
            'oShow' => $oShow
        ));
    }

    public function FSxCTTBEditAjax() {
        if ($this->input->post('ohdFNTmhID')) {
            $aData = array(
                'FNTmhID' => $this->input->post('ohdFNTmhID'),
                'FTTmhName' => $this->input->post('oetFTTmhName'),
                'FTTmhStaActive' => ($this->input->post('ocbFTTmhStaActive') == "" ? "2" : "1"),
                'FTTmhRmk' => $this->input->post('otaFTTmhRmk')
            );
            $this->mTimeTable->FSxMTTBEditAjax($aData);
        }
    }

    public function FSxCTTBDelete() {
        if ($this->input->post('nFNTmhID')) {
            $ocbListItem = $this->input->post('nFNTmhID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $nFNTmhID = $oValue;
                $o = $this->mTimeTable->FSxMTTBDelete($nFNTmhID);
                $aData = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                echo json_encode($aData);
            }
        }
    }

    // รอบการแสดง
    public function FSxCTTBDt($nFNTmhID) {
        $oAuthen = FCNaHCheckAlwFunc('EticketTimeTable');
        $this->load->view('ticket/timetable/dt/wTimeTableDT', array(
            'oAuthen' => $oAuthen,
            'nFNTmhID' => $nFNTmhID
        ));
    }

    public function FSxCTTBDtAjaxList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketTimeTable');
        $nFNTmhID = $this->input->post('nFNTmhID');
        $tFTTmdName = $this->input->post('tFTTmdName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oList = $this->mTimeTable->FSxMTTBDtAjaxList($tFTTmdName, $nFNTmhID, $nPageActive);
        $this->load->view('ticket/timetable/dt/wTimeTableDTList', array(
            'oAuthen'   => $oAuthen,
            'nFNTmhID'  => $nFNTmhID,
            'oList'     => $oList,
            'nPageNo'   => $nPageNo
        ));
    }

    public function FStCTTBDtCount() {
        $tFTTmdName = $this->input->post('tFTTmdName');
        $nFNTmhID = $this->input->post('nFNTmhID');
        $oCnt = $this->mTimeTable->FStMTTBDtCount($tFTTmdName, $nFNTmhID);
        $oCount = $oCnt [0]->counts;
        echo $oCount;
    }

    public function FSxCTTBDtAdd($nFNTmhID) {
        $this->load->view('ticket/timetable/dt/wAdd', array(
            'nFNTmhID' => $nFNTmhID
        ));
    }

    public function FSxCTTBDtAddAjax() {
        if ($this->input->post('oetFTTmdName')) {
            $aData = array(
                'FNTmhID' => $this->input->post('ohdFNTmhID'),
                'FTTmdName' => $this->input->post('oetFTTmdName'),
                'FTTmdStartTime' => $this->input->post('oetFTTmdStartTime'),
                'FTTmdEndTime' => $this->input->post('oetFTTmdEndTime')
            );
            $tStartTime = date('H:i', strtotime($aData['FTTmdStartTime']));
            $tEndTime = date('H:i', strtotime($aData['FTTmdEndTime']));
            $aCheckTime = $this->mTimeTable->FSxMTTBDtCheckTime($aData);
            
            if (($tStartTime == $tEndTime)) {
                echo 0;
            } else {
                if (@$aCheckTime[0]->FNTmdID == '') {
                    echo 0;
                } else {
                    $nFNTmdID = $this->mTimeTable->FSxMTTBDtAddAjax($aData);
                    echo $nFNTmdID;
                }
            }
        }
    }

    public function FSxCTTBDtEditAjax() {
        if ($this->input->post('ohdFNTmdID')) {
            $aData = array(
                'FNTmdID' => $this->input->post('ohdFNTmdID'),
                'FNTmhID' => $this->input->post('ohdFNTmhID'),
                'FTTmdName' => $this->input->post('oetFTTmdName'),
                'FTTmdStartTime' => $this->input->post('oetFTTmdStartTime'),
                'FTTmdEndTime' => $this->input->post('oetFTTmdEndTime')
            );
            $tStartTime = date('H:i', strtotime($aData['FTTmdStartTime']));
            $tEndTime = date('H:i', strtotime($aData['FTTmdEndTime']));
            $aCheckTime = $this->mTimeTable->FSxMTTBDtCheckTime($aData);
            if (($tStartTime == $tEndTime)) {
                echo 0;
            } else {
                if (@$aCheckTime[0]->FNTmdID == '') {
                    echo 0;
                } else {
                    $this->mTimeTable->FSxMTTBDtEditAjax($aData);
                }
            }
        }
    }


    public function FSxCTTBDtEdit($nFNTmdID, $nFNTmhID) {
        $oShow = $this->mTimeTable->FSxMTTBDtEdit($nFNTmdID);
        $this->load->view('ticket/timetable/dt/wEdit', array(
            'nFNTmhID' => $nFNTmhID,
            'oShow' => $oShow,
        ));
    }



    public function FSxCTTBDtDelete() {
        if ($this->input->post('nFNTmdID')) {
            $ocbListItem = $this->input->post('nFNTmdID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $this->mTimeTable->FSxMTTBDtDelete($oValue);
            }
        }
    }

}

?>