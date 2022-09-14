<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cPackage extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/package/mPackage', 'oPackage');
        $this->load->library("session");
        date_default_timezone_set("Asia/Bangkok");
    }

    // โหลดหน้าจอหลัก และข้อมูลสาขาทั้งหมด
    public function index() {
        $oModelList = $this->oPackage->FSxMPKGGetModelList();
        $oAuthen = FCNaHCheckAlwFunc('EticketPackage');
        $this->load->view('ticket/package/wPackage', array(
            'oAuthen' => $oAuthen,
            'oModelList' => $oModelList
        ));
    }

    public function FSnCPKGAddPkgSpcPriHLD() {
        if ($this->input->post('nPpkID')) {
            $nPpkID = $this->input->post('nPpkID');
            $dPphCheckIn = $this->input->post('dPphCheckIn');
            $nPphSign = $this->input->post('nPphSign');
            $nPphAdjType = $this->input->post('nPphAdjType');
            $nPphValue = $this->input->post('nPphValue');
            $aData = array(
                'FNPpkID' => $nPpkID,
                'FDPphCheckIn' => $dPphCheckIn,
                'FNPphSign' => $nPphSign,
                'FTPphAdjType' => $nPphAdjType,
                'FCPphValue' => $nPphValue,
                'FDDateUpd' => date('Y-m-d'),
                'FTTimeUpd' => date('h:i:s'),
                'FTWhoUpd' => $this->session->userdata("username")
            );
            $nSttAdd = $this->oPackage->FSnMPKGAddPkgSpcPriHLD($aData);
            switch ($nSttAdd) {
                case '1' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                    break;
                case '0' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddFailMSG');
                    break;
                case '500' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AlreadyHaveMSG');
                    break;
            }
        }
    }

    public function FSnCPKGDelPkgSpcPriHLD() {
        $nPpkID = $this->input->post('nPpkID');
        $dPphCheckIn = $this->input->post('dPphCheckIn');

        $nSttDel = $this->oPackage->FSnMPKGDelPkgSpcPriHLD($nPpkID, $dPphCheckIn);

        switch ($nSttDel) {
            case '1' :
                $msg = language('ticket/package/package', 'tPkg_DelSuccessMSG');
                echo $nSttDel . ',' . $msg;
                break;

            case '0' :
                $msg = language('ticket/package/package', 'tPkg_DelFailMSG');
                echo $nSttDel . ',' . $msg;
                break;
        }
    }

    public function FSoCPKGGetPkgFullCalendar() {
        if ($this->input->post('nPpkID')) {
            $nPpkID = $this->input->post('nPpkID');

            $oPkgPriHoliday = $this->oPackage->FSoMPKGGetPkgFullCalendar($nPpkID);

            if (@$oPkgPriHoliday [0]->FNPpkID != "") {
                $aPkgPriHoliday = array();

                foreach ($oPkgPriHoliday as $tValue) {
                    $a = array();
                    $a ['id'] = $tValue->FNPpkID;
                    $a ['datetime'] = $tValue->FDPphCheckIn;
                    $a ['title'] = $tValue->FCPphValue;
                    $a ['start'] = date("Y-m-d", strtotime($tValue->FDPphCheckIn));
                    // $e['end'] = $row['end'];
                    $a ['color'] = "#087380";
                    $a ['textColor'] = "#FFFFFF";
                    array_push($aPkgPriHoliday, $a);
                }

                echo json_encode($aPkgPriHoliday);
            }
        }
    }

    public function FSoCPKGGetPkgFullCalendarList() {
        if ($this->input->post('nPpkID')) {
            $nPpkID = $this->input->post('nPpkID');
            $dPphCheckIn = $this->input->post('dPphCheckIn');

            $oPkgPriHoliday = $this->oPackage->FSoMPKGGetPkgFullCalendarList($nPpkID, $dPphCheckIn);

            if (@$oPkgPriHoliday [0]->FNPpkID != "") {
                echo '<p style="font-size: 18px;"></p>';
                foreach (@$oPkgPriHoliday as $key => $oValue) {
                    echo '<div style="padding-top: 5px; padding-bottom: 5px;">
					<div class="row" style="background:#f7f7f7;">
					<div class="col-md-12">
					<div class="form-group">
					<span>' . $oValue->FDPphCheckIn . '</span>
					<a id="olaDelHLDBtn" style="color: #000; float: right;margin-right: 10px;" title="ลบ" onclick="JSnPKGDelPkgHoliday(\'' . $nPpkID . '\',\'' . $oValue->FDPphCheckIn . '\');">
					<i class="fa fa-remove"></i>
					</a>
					</div>
					</div>
					<div class="col-md-12">
					<div class="form-group">
					<span>' . language('ticket/package/package', 'tPkg_PackagePphSign' . $oValue->FNPphSign) . '</span> / <span>' . language('ticket/package/package', 'tPkg_PackageAdjType' . $oValue->FTPphAdjType) . '</span>
					</div>
					</div>
					<div class="col-md-11">
					<div class="form-group">
					<span>' . $oValue->FCPphValue . '</span>
					</div>
					</div>
					</div>
					</div>
					';
                }
            } else {
                echo '';
            }
        }
    }

    public function FSoCPKGGetGrpFullCalendar() {
        if ($this->input->post('nPgpGrpID')) {
            $nPgpGrpID = $this->input->post('nPgpGrpID');

            $oGrpPriHoliday = $this->oPackage->FSoMPKGGetGrpFullCalendar($nPgpGrpID);
            if (@$oGrpPriHoliday [0]->FNPgpGrpID != "") {
                $aGrpPriHoliday = array();

                foreach ($oGrpPriHoliday as $tValue) {
                    $a = array();
                    $a ['id'] = $tValue->FNPgpGrpID;
                    $a ['datetime'] = $tValue->FDGphCheckIn;
                    $a ['title'] = $tValue->FCGphValue;
                    $a ['start'] = date("Y-m-d", strtotime($tValue->FDGphCheckIn));
                    // $e['end'] = $row['end'];
                    $a ['color'] = "#087380";
                    $a ['textColor'] = "#FFFFFF";
                    array_push($aGrpPriHoliday, $a);
                }

                echo json_encode($aGrpPriHoliday);
            }
        }
    }

    public function FSoCPKGGetGrpFullCalendarList() {
        if ($this->input->post('nPgpGrpID')) {
            $nPgpGrpID = $this->input->post('nPgpGrpID');
            $dGphCheckIn = $this->input->post('dGphCheckIn');

            $oGrpPriHoliday = $this->oPackage->FSoMPKGGetGrpFullCalendarList($nPgpGrpID, $dGphCheckIn);

            if (@$oGrpPriHoliday [0]->FNPgpGrpID != "") {
                echo '<p style="font-size: 18px;"></p>';
                foreach (@$oGrpPriHoliday as $key => $oValue) {
                    echo '<div style="padding-top: 5px; padding-bottom: 5px;">
					<div class="row" style="background:#f7f7f7;">
					<div class="col-md-12">
					<div class="form-group">
					<span>' . $oValue->FDGphCheckIn . '</span>
					<a id="olaDelHLDBtn" style="color: #000; float: right;margin-right: 10px;" title="ลบ" onclick="JSnPKGDelGrpHoliday(\'' . $nPgpGrpID . '\',\'' . $oValue->FDGphCheckIn . '\');">
					<i class="fa fa-remove"></i>
					</a>
					</div>
					</div>
					<div class="col-md-12">
					<div class="form-group">
					<span>' . language('ticket/package/package', 'tPkg_PackagePphSign' . $oValue->FNGphSign) . '</span> / <span>' . language('ticket/package/package', 'tPkg_PackageAdjType' . $oValue->FTGphAdjType) . '</span>
					</div>
					</div>
					<div class="col-md-11">
					<div class="form-group">
					<span>' . $oValue->FCGphValue . '</span>
					</div>
					</div>
					</div>
					</div>
					';
                }
            } else {
                echo '';
            }
        }
    }

    public function FSnCPKGAddGrpSpcPriHLD() {
        if ($this->input->post('nPgpGrpID')) {

            $nPgpGrpID = $this->input->post('nPgpGrpID');
            $dGphCheckIn = $this->input->post('dGphCheckIn');
            $nGphSign = $this->input->post('nGphSign');
            $nGphAdjType = $this->input->post('nGphAdjType');
            $nGphValue = $this->input->post('nGphValue');

            $aData = array(
                'FNPgpGrpID' => $nPgpGrpID,
                'FDGphCheckIn' => $dGphCheckIn,
                'FNGphSign' => $nGphSign,
                'FTGphAdjType' => $nGphAdjType,
                'FCGphValue' => $nGphValue,
                'FDDateUpd' => date('Y-m-d'),
                'FTTimeUpd' => date('h:i:s'),
                'FTWhoUpd' => $this->session->userdata("username")
            );

            $nSttAdd = $this->oPackage->FSnMPKGAddGrpSpcPriHLD($aData);

            switch ($nSttAdd) {
                case '1' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                    break;
                case '0' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddFailMSG');
                    break;
                case '500' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AlreadyHaveMSG');
                    break;
            }
        }
    }

    public function FSnCPKGDelGrpSpcPriHLD() {
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $dGphCheckIn = $this->input->post('dGphCheckIn');

        $nSttDel = $this->oPackage->FSnMPKGDelGrpSpcPriHLD($nPgpGrpID, $dGphCheckIn);

        switch ($nSttDel) {
            case '1' :
                $msg = language('ticket/package/package', 'tPkg_DelSuccessMSG');
                echo $nSttDel . ',' . $msg;
                break;

            case '0' :
                $msg = language('ticket/package/package', 'tPkg_DelFailMSG');
                echo $nSttDel . ',' . $msg;
                break;
        }
    }

    public function FSnCPKGDelPdtSpcPriHLD() {
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $dPphCheckIn = $this->input->post('dPphCheckIn');

        $nSttDel = $this->oPackage->FSnMPKGDelPdtSpcPriHLD($nPkgPdtID, $dPphCheckIn);

        switch ($nSttDel) {
            case '1' :
                $msg = language('ticket/package/package', 'tPkg_DelSuccessMSG');
                echo $nSttDel . ',' . $msg;
                break;

            case '0' :
                $msg = language('ticket/package/package', 'tPkg_DelFailMSG');
                echo $nSttDel . ',' . $msg;
                break;
        }
    }

    public function FSnCPKGAddPdtSpcPriHLD() {
        if ($this->input->post('nPkgPdtID')) {

            $nPkgPdtID = $this->input->post('nPkgPdtID');
            $dPphCheckIn = $this->input->post('dPphCheckIn');
            $nPphSign = $this->input->post('nPphSign');
            $nPphAdjType = $this->input->post('nPphAdjType');
            $nPphValue = $this->input->post('nPphValue');

            $aData = array(
                'FNPkgPdtID' => $nPkgPdtID,
                'FDPphCheckIn' => $dPphCheckIn,
                'FNPphSign' => $nPphSign,
                'FTPphAdjType' => $nPphAdjType,
                'FCPphValue' => $nPphValue,
                'FDDateUpd' => date('Y-m-d'),
                'FTTimeUpd' => date('h:i:s'),
                'FTWhoUpd' => $this->session->userdata("username")
            );

            $nSttAdd = $this->oPackage->FSnMPKGAddPdtSpcPriHLD($aData);

            switch ($nSttAdd) {
                case '1' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                    break;
                case '0' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddFailMSG');
                    break;
                case '500' :
                    echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AlreadyHaveMSG');
                    break;
            }
        }
    }

    public function FSoCPKGGetPdtFullCalendarList() {
        if ($this->input->post('nPkgPdtID')) {
            $nPkgPdtID = $this->input->post('nPkgPdtID');
            $dPphCheckIn = $this->input->post('dPphCheckIn');

            $oPdtPriHoliday = $this->oPackage->FSoMPKGGetPdtFullCalendarList($nPkgPdtID, $dPphCheckIn);

            if (@$oPdtPriHoliday [0]->FNPkgPdtID != "") {
                echo '<p style="font-size: 18px;"></p>';
                foreach (@$oPdtPriHoliday as $key => $oValue) {
                    echo '<div style="padding-top: 5px; padding-bottom: 5px;">

					<div class="row" style="background:#f7f7f7;">
					<div class="col-md-12">
					<div class="form-group">
					<span>' . $oValue->FDPphCheckIn . '</span>
					<a id="olaDelHLDBtn" style="color: #000; float: right;margin-right: 10px;" title="ลบ" onclick="JSnPKGDelPdtHoliday(\'' . $nPkgPdtID . '\',\'' . $oValue->FDPphCheckIn . '\');">
					<i class="fa fa-remove"></i>
					</a>
					</div>
					</div>
					<div class="col-md-12">
					<div class="form-group">
					<span>' . language('ticket/package/package', 'tPkg_PackagePphSign' . $oValue->FNPphSign) . '</span> / <span>' . language('ticket/package/package', 'tPkg_PackageAdjType' . $oValue->FTPphAdjType) . '</span>
					</div>
					</div>
					<div class="col-md-11">
					<div class="form-group">
					<span>' . $oValue->FCPphValue . '</span>
					</div>
					</div>
					</div> 
					</div>
					';
                }
            } else {
                echo '';
            }
        }
    }

    public function FSoCPKGGetPdtFullCalendar() {
        if ($this->input->post('nPkgPdtID')) {
            $nPkgPdtID = $this->input->post('nPkgPdtID');

            $oPdtPriHoliday = $this->oPackage->FSoMPKGGetPdtFullCalendar($nPkgPdtID);
            if (@$oPdtPriHoliday [0]->FNPkgPdtID != "") {
                $aPdtPriHoliday = array();

                foreach ($oPdtPriHoliday as $tValue) {
                    $a = array();
                    $a ['id'] = $tValue->FNPkgPdtID;
                    $a ['datetime'] = $tValue->FDPphCheckIn;
                    $a ['title'] = $tValue->FCPphValue;
                    $a ['start'] = date("Y-m-d", strtotime($tValue->FDPphCheckIn));
                    // $e['end'] = $row['end'];
                    $a ['color'] = "#087380";
                    $a ['textColor'] = "#FFFFFF";
                    array_push($aPdtPriHoliday, $a);
                }

                echo json_encode($aPdtPriHoliday);
            }
        }
    }

    public function FSnCPKGAddPkgPdtPriBKG() {
        $nPkgPdtID = $this->input->post('oetHidePkgPdtID');
        $nPpbDayFrm = $this->input->post('oetPpbDayFrm');
        $nPpbDayTo = $this->input->post('oetPpbDayTo');
        $nPpbSign = $this->input->post('ocmPpbSign');
        $cPpbAdjType = $this->input->post('ocmPpbAdjType');
        $nPpbValue = $this->input->post('oetPpbValue');

        $aData = array(
            'FNPkgPdtID' => $nPkgPdtID,
            'FNPpbDayFrm' => $nPpbDayFrm,
            'FNPpbDayTo' => $nPpbDayTo,
            'FNPpbSign' => $nPpbSign,
            'FTPpbAdjType' => $cPpbAdjType,
            'FCPpbValue' => $nPpbValue,
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s'),
            'FTWhoUpd' => $this->session->userdata("username")
        );

        $nSttAdd = $this->oPackage->FSnMPKGAddPkgPpbPriBKG($aData);

        switch ($nSttAdd) {
            case '1' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                break;

            case '0' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_MsgAlreadyBKG');
                break;
        }
    }

    public function FSxCPKGEditPkgPdtPriBKG() {
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $nPdtDayFrm = $this->input->post('nPdtDayFrm');
        $nPdtDayTo = $this->input->post('nPdtDayTo');
        $nPdtAdjType = $this->input->post('nPdtAdjType');
        $nPdtValue = $this->input->post('nPdtValue');

        $aData = array(
            'FNPkgPdtID' => $nPkgPdtID,
            'FNPpbDayFrm' => $nPdtDayFrm,
            'FNPpbDayTo' => $nPdtDayTo,
            'FTPpbAdjType' => $nPdtAdjType,
            'FCPpbValue' => $nPdtValue
        );

        $nSttEdit = $this->oPackage->FSxMPKGEditPkgPdtPriBKG($aData);
        echo $nSttEdit;
    }

    public function FSxCPKGDelPkgPriBKG() {
        $nPpkID = $this->input->post('nPpkID');
        $nPpbDayFrm = $this->input->post('nPpbDayFrm');
        $nPpbDayTo = $this->input->post('nPpbDayTo');
        $nSttDel = $this->oPackage->FSxMPKGDelPkgPriBKG($nPpkID, $nPpbDayFrm, $nPpbDayTo);
        switch ($nSttDel) {
            case '1' :
                $msg = language('ticket/package/package', 'tPkg_DelSuccessMSG');
                echo $nSttDel . ',' . $msg;
                break;

            case '0' :
                $msg = language('ticket/package/package', 'tPkg_DelFailMSG');
                echo $nSttDel . ',' . $msg;
                break;
        }
    }

    public function FSxCPKGDelPdtGrpPriBKG() {
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $nPdtDayFrm = $this->input->post('nPdtDayFrm');
        $nPdtDayTo = $this->input->post('nPdtDayTo');
        $nSttDel = $this->oPackage->FSxMPKGDelPkgPdtPriBKG($nPkgPdtID, $nPdtDayFrm, $nPdtDayTo);
        echo $nSttDel;
    }

    public function FSxCPKGDelPkgGrpPriBKG() {
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $nGpbDayFrm = $this->input->post('nGpbDayFrm');
        $nGpbDayTo = $this->input->post('nGpbDayTo');

        $nSttDel = $this->oPackage->FSxMPKGDelPkgGrpPriBKG($nPgpGrpID, $nGpbDayFrm, $nGpbDayTo);

        echo $nSttDel;
    }

    public function FSxCPKGEditPkgGrpPriBKG() {
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $nGpbDayFrm = $this->input->post('nGpbDayFrm');
        $nGpbDayTo = $this->input->post('nGpbDayTo');
        $nGpbAdjType = $this->input->post('nGpbAdjType');
        $nGpbValue = $this->input->post('nGpbValue');

        $aData = array(
            'FNPgpGrpID' => $nPgpGrpID,
            'FNGpbDayFrm' => $nGpbDayFrm,
            'FNGpbDayTo' => $nGpbDayTo,
            'FTGpbAdjType' => $nGpbAdjType,
            'FCGpbValue' => $nGpbValue
        );

        $nSttEdit = $this->oPackage->FSxMPKGEditPkgGrpPriBKG($aData);

        echo $nSttEdit;
    }

    public function FSnCPKGAddPkgGrpPriBKG() {
        $nPgpGrpID = $this->input->post('oetHidePgpGrpID');
        $nGpbDayFrm = $this->input->post('oetGpbDayFrm');
        $nGpbDayTo = $this->input->post('oetGpbDayTo');
        $nGpbSign = $this->input->post('ocmGpbSign');
        $cGpbAdjType = $this->input->post('ocmGpbAdjType');
        $nGpbValue = $this->input->post('oetGpbValue');

        $aData = array(
            'FNPgpGrpID' => $nPgpGrpID,
            'FNGpbDayFrm' => $nGpbDayFrm,
            'FNGpbDayTo' => $nGpbDayTo,
            'FNGpbSign' => $nGpbSign,
            'FTGpbAdjType' => $cGpbAdjType,
            'FCGpbValue' => $nGpbValue,
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s'),
            'FTWhoUpd' => $this->session->userdata("username")
        );

        $nSttAdd = $this->oPackage->FSnMPKGAddPkgGrpPriBKG($aData);

        switch ($nSttAdd) {
            case '1' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                break;

            case '0' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_MsgAlreadyBKG');
                break;
        }
    }

    public function FSxCPKGEditPkgPriBKG() {
        $nPpkID = $this->input->post('nPpkID');
        $nPkgDayFrm = $this->input->post('nPkgDayFrm');
        $nPkgDayTo = $this->input->post('nPkgDayTo');
        $nPkgAdjType = $this->input->post('nPkgAdjType');
        $nPkgValue = $this->input->post('nPkgValue');

        $aData = array(
            'FNPpkID' => $nPpkID,
            'FNPpbDayFrm' => $nPkgDayFrm,
            'FNPpbDayTo' => $nPkgDayTo,
            'FTPpbAdjType' => $nPkgAdjType,
            'FCPpbValue' => $nPkgValue
        );

        $nSttEdit = $this->oPackage->FSxMPKGEditPkgPriBKG($aData);

        echo $nSttEdit;
    }

    public function FSnCPKGAddPkgPriBKG() {
        $nPpkID = $this->input->post('oetHidePpkID');
        $nPpbDayFrm = $this->input->post('oetPpbDayFrm');
        $nPpbDayTo = $this->input->post('oetPpbDayTo');
        $nPpbSign = $this->input->post('ocmPpbSign');
        $cPpbAdjType = $this->input->post('ocmPpbAdjType');
        $nPpbValue = $this->input->post('oetPpbValue');

        $aData = array(
            'FNPpkID' => $nPpkID,
            'FNPpbDayFrm' => $nPpbDayFrm,
            'FNPpbDayTo' => $nPpbDayTo,
            'FNPpbSign' => $nPpbSign,
            'FTPpbAdjType' => $cPpbAdjType,
            'FCPpbValue' => $nPpbValue,
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s'),
            'FTWhoUpd' => $this->session->userdata("username")
        );

        $nSttAdd = $this->oPackage->FSnMPKGAddPkgPriBKG($aData);

        switch ($nSttAdd) {
            case '1' :
                $msg = language('ticket/package/package', 'tPkg_AddSuccessMSG');
                echo $nSttAdd . "," . $msg;
                break;

            case '0' :
                $msg = language('ticket/package/package', 'tPkg_AddFailMSG');
                echo $nSttAdd . "," . $msg;
                break;

            case '500' :
                $msg = language('ticket/package/package', 'tPkg_AddFailMSG');
                echo $nSttAdd . "," . $msg;
                break;
        }
    }

    public function FSnCPKGEditPkgPriSpcPriByDOW() {
        $nPpkID = $this->input->post('nPpkID');
        $nPpdDayOfWeek = $this->input->post('nPpdDayOfWeek');
        $cPpdPrice = $this->input->post('cPpdPrice');

        $aData = array(
            'FCPpdPrice' => $cPpdPrice
        );

        $nSttEdit = $this->oPackage->FSnMPKGEditPkgPriSpcPriByDOW($nPpkID, $nPpdDayOfWeek, $aData);

        switch ($nSttEdit) {
            case '1' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateSuccessMSG');
                break;
            case '0' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateFailMSG');
                break;
        }
    }

    public function FSnCPKGEditGrpPriSpcPriByDOW() {
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $nGpdDayOfWeek = $this->input->post('nGpdDayOfWeek');
        $cGpdPrice = $this->input->post('cGpdPrice');

        $aData = array(
            'FCGpdPrice' => $cGpdPrice
        );

        $nSttEdit = $this->oPackage->FSnMPKGEditGrpPriSpcPriByDOW($nPgpGrpID, $nGpdDayOfWeek, $aData);

        switch ($nSttEdit) {
            case '1' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateSuccessMSG');
                break;
            case '0' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateFailMSG');
                break;
        }
    }

    public function FSnCPKGEditPdtPriSpcPriByDOW() {
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $nPpdDayOfWeek = $this->input->post('nPpdDayOfWeek');
        $cPpdPrice = $this->input->post('cPpdPrice');

        $aData = array(
            'FCPpdPrice' => $cPpdPrice
        );

        $nSttEdit = $this->oPackage->FSnMPKGEditPdtPriSpcPriByDOW($nPkgPdtID, $nPpdDayOfWeek, $aData);

        switch ($nSttEdit) {
            case '1' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateSuccessMSG');
                break;
            case '0' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateFailMSG');
                break;
        }
    }

    // FS อนุมัติ แพ็คเกจ
    public function FSxCPKGApprovePkg() {
        $nPkgID = $this->input->post('nPkgID');

        $oPkgHavePdt = $this->oPackage->FSxMPKGCheckPkgHaveProduct($nPkgID);
        $nPkgHavePdt = $oPkgHavePdt [0]->counts;

        if ($nPkgHavePdt < 1) {
            // Check เงื่อนไขที่ 1 มีสินค้าในแพ็คเกจหรือไม่
            $nSttApv = 0;
            $MsgSttApv = language('ticket/package/package', 'tPkg_CannotApprovePackageIsNotSpecified');
            echo $nSttApv . ',' . $MsgSttApv;
        } else {
            // Check เงื่อนไขที่ 2 วันที่อนุมัติ เกินกำหนดวันอนุมัติใช้งาน
            $dDateNow = date("Y-m-d H:i");
            $oChkDate = $this->oPackage->FSxMPKGCheckApvDateStartChkIn($nPkgID, $dDateNow);
            $nChkDate = $oChkDate [0]->counts;
            if ($nChkDate == 0) {

                $nSttApv = 0;
                $MsgSttApv = language('ticket/package/package', 'tPkg_CannotApproveDateOutOfUse');
                echo $nSttApv . ',' . $MsgSttApv;
            } else {
                // Check เงื่อนไขที่ 3 วันที่อนุมัติ ยังไม่มีการกำหนดสาขาเข้า
                $oModelCstHave = $this->oPackage->JSxMPKGCheckPkgHaveModelCstMore1Place($nPkgID);
                $nPrkHave = $oModelCstHave [0]->counts;

                if ($nPrkHave == 0) {

                    $nSttApv = 0;
                    $MsgSttApv = language('ticket/package/package', 'tPkg_CannotApprovePackageIsNotSpecifiedModel');
                    echo $nSttApv . ',' . $MsgSttApv;
                } else {
                    // Check เงื่อนไขที่ 4 กำหนดสาขาเข้าไม่ตรงกับ FNPkgMaxPark

                    $oPkgMaxPark = $this->oPackage->JSxMPKGGetFNPkgMaxPark($nPkgID);
                    $nPkgMaxPark = $oPkgMaxPark [0]->FNPkgMaxPark;

                    if ($nPrkHave >= $nPkgMaxPark) {

                        $aDataStaApv = array(
                            // 1 ทำแล้ว , ว่างยังไม่ทำ
                            'FTPkgStaPrcDoc' => '1'
                        );

                        $SttSave = $this->oPackage->FSxMPKGApprovePkgSave($nPkgID, $aDataStaApv);
                        $nSttApv = $SttSave;
                        $MsgSttApv = language('ticket/package/package', 'tPkg_ApprovePkgSucc');
                        echo $nSttApv . ',' . $MsgSttApv;
                    } else {

                        $aDataStaApv = array(
                            // 1 ทำแล้ว , ว่างยังไม่ทำ
                            'FTPkgStaPrcDoc' => ''
                        );
                        $SttSave = $this->oPackage->FSxMPKGApprovePkgSave($nPkgID, $aDataStaApv);
                        $nSttApv = 0;
                        $MsgSttApv = language('ticket/package/package', 'tPkg_CannotApproveModelMustMorthanModelPerPkg');
                        echo $nSttApv . ',' . $MsgSttApv;
                    }
                }
            }
        }
    }

    public function FSxCPKGDelPkgProduct() {
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $nPkgID = $this->input->post('nPkgID');

        $nStatus = $this->oPackage->FSxMPKGDelPkgProduct($nPkgPdtID, $nPkgID);

        switch ($nStatus) {
            case '1' :
                echo $nStatus . "," . language('ticket/package/package', 'tPkg_DelSuccessMSG');
                break;
            case '0' :
                echo $nStatus . "," . language('ticket/package/package', 'tPkg_MsgPkgPdtMustleast1piece');
                break;
        }
    }

    public function FSxCPKGDelPkgSpcGrpPri() {
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $nPkgID = $this->input->post('nPkgID');

        $nStatus = $this->oPackage->FSnMPKGDelPkgSpcGrpPri($nPgpGrpID, $nPkgID);

        echo $nStatus;
    }

    public function FSxCPKGDelPkgPdtGrpPri() {
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $nPkgID = $this->input->post('nPkgID');

        $nStatus = $this->oPackage->FSnMPKGDelPkgPdtGrpPri($nPgpGrpID, $nPkgID);

        switch ($nStatus) {
            case '1' :
                echo $nStatus . "," . language('ticket/package/package', 'tPkg_DelSuccessMSG');
                break;
            case '0' :
                echo $nStatus . "," . language('ticket/package/package', 'tPkg_DelFailMSG');
                break;
        }
    }

    public function FSxCPKGEditPkgProduct() {
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $nPdtMaxPerson = $this->input->post('nPdtMaxPerson');
        $nPdtPdtPrice = $this->input->post('nPdtPdtPrice');

        $aData = array(
            'FNPdtMaxPerson' => $nPdtMaxPerson,
            'FCPdtPrice' => $nPdtPdtPrice
        );

        $nSttEdit = $this->oPackage->FSxMPKGEditPkgProduct($nPkgPdtID, $aData);

        switch ($nSttEdit) {
            case '1' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateSuccessMSG');
                break;
            case '0' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateFailMSG');
                break;
        }
    }

    // แก้ไข ราคาพิเศษตามกลุ่ม
    public function FSnCPKGEditPkgSpcGrpPri() {
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $nPgpPdtPrice = $this->input->post('nPgpPdtPrice');

        $aData = array(
            'FCPgpPdtPrice' => $nPgpPdtPrice
        );

        $nSttEdit = $this->oPackage->FSnMPKGEditPkgSpcGrpPri($nPgpGrpID, $aData);

        switch ($nSttEdit) {
            case '1' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateSuccessMSG');
                break;
            case '0' :
                echo $nSttEdit . "," . language('ticket/package/package', 'tPkg_UpdateFailMSG');
                break;
        }
    }

    /**
     * FS เพิ่มแพ็คเกจ
     */
    public function FSxCPKGAddPackage() {
        if ($this->input->post('oetAddPkgName')) {

            $tAddPkgName = $this->input->post('oetAddPkgName');
            $dAdddPkgStartChkIn = $this->input->post('oetAdddPkgStartChkIn');
            $tAddtPkgStartChkIn = $this->input->post('oetAddtPkgStartChkIn');
            $dAdddPkgStopChkIn = $this->input->post('oetAdddPkgStopChkIn');
            $tAddtPkgStopChkIn = $this->input->post('oetAddtPkgStopChkIn');
            $tAddPkgTchGroup = $this->input->post('oetAddPkgTchGroup');
            $tAddPkgMaxPark = $this->input->post('oetAddPkgMaxPark');
            $tAddPkgStaLimitType = $this->input->post('oetAddPkgStaLimitType');
            $tAddPickTypePrice = $this->input->post('ocmAddPickTypePrice');
            $tAddPkgMaxChkIn = $this->input->post('oetAddPkgMaxChkIn');
            $tAddPkgDesc1 = $this->input->post('oetAddPkgDesc1');
            $tAddPkgDesc2 = $this->input->post('oetAddPkgDesc2');
            $tAddPkgDesc3 = $this->input->post('oetAddPkgDesc3');
            $tAddPkgDesc4 = $this->input->post('oetAddPkgDesc4');
            $tAddPkgDesc5 = $this->input->post('oetAddPkgDesc5');
            $dAddPkgStartChkIn = $dAdddPkgStartChkIn . " " . $tAddtPkgStartChkIn;
            $dAddPkgStopChkIn = $dAdddPkgStopChkIn . " " . $tAddtPkgStopChkIn;

            $aData = array(
                'FTPkgName' => $tAddPkgName,
                'FNTcgID' => $tAddPkgTchGroup,
                'FTPkgType' => $tAddPickTypePrice,
                'FDPkgStartChkIn' => $dAddPkgStartChkIn,
                'FDPkgStopChkIn' => $dAddPkgStopChkIn,
                'FNPkgMaxChkIn' => $tAddPkgMaxChkIn,
                'FNPkgMaxPark' => $tAddPkgMaxPark,
                'FTPkgStaLimitType' => $tAddPkgStaLimitType,
                'FTPkgDesc1' => $tAddPkgDesc1,
                'FTPkgDesc2' => $tAddPkgDesc2,
                'FTPkgDesc3' => $tAddPkgDesc3,
                'FTPkgDesc4' => $tAddPkgDesc4,
                'FTPkgDesc5' => $tAddPkgDesc5
            );

            // $nAddPackage = $this->oPackage->FSxMPKGAddPackage($aData);
            // $nIDPgk = $nAddPackage;
            $nIDPgk = '61';
            if ($this->input->post('oetPdtCodeArr') && $nIDPgk != '') {

                $tFTPdtCode = $this->input->post('oetPdtCodeArr');
                $tFNPdtMaxPerson = $this->input->post('oetPdtMaxPersonArr');
                $tFNPdtMaxPriceArr = $this->input->post('oetPdtMaxPriceArr');

                foreach ($tFTPdtCode as $key => $tValue) {
                    $aDataPdt = array(
                        'FNPkgID' => $nIDPgk,
                        'FNPdtID' => $tFTPdtCode [$key],
                        'FNPdtMaxPerson' => $tFNPdtMaxPerson [$key],
                        'FCPdtPrice' => $tFNPdtMaxPriceArr [$key]
                    );
                    // $this->oPackage->FSxMPKGAddPkgPdtPri($aDataPdt);
                }
            }
        } else {
            echo language('ticket/package/package', 'tPkg_NoValue');
        }
    }

    // FS เพิ่ม อนูญาติเข้าชม Model Customer
    public function FSxCPKGAddPkgModelZone() {
        $aZneID = $this->input->post('nZneID');
        $nPkgLocID = $this->input->post('nPkgLocID');
        $nPkgID = $this->input->post('nPkgID');
        $nPmoID = $this->input->post('nPmoID');
        $nPpkPrice = $this->input->post('nPpkPrice');

        if ($nPpkPrice == '') {
            $nPpkPrice = null;
        }

        foreach ($aZneID as $key => $nZneID) {
            $nStatus = $this->oPackage->FSxMPKGAddPkgModelZone($nZneID, $nPkgLocID, $nPkgID, $nPmoID, $nPpkPrice);
            echo $nStatus;
        }
    }

    public function FSnCPKGAddPkgModelZoneStep2() {
        $aZneID = $this->input->post('nZneID');
        $nPkgLocID = $this->input->post('nPkgLocID');
        $nPkgID = $this->input->post('nPkgID');
        $nPmoID = $this->input->post('nPmoID');
        $aZnePriID = $this->input->post('aZnePriID');
        $nBookingType = $this->input->post('nBookingType');

        if ($aZnePriID == '') {
            $nZnePri = NULL;
        }
        foreach ($aZneID as $key => $nZneID) {
            $nZnePri = $aZnePriID [$key];

            if ($nZnePri == '') {
                $nZnePri = NULL;
            }
            $nStatus = $this->oPackage->FSxMPKGCheckPkgModelZoneMore2($nZneID, $nPkgLocID, $nPkgID, $nPmoID);

            if ($nStatus > 0) {

                $nPkgPdt = $this->oPackage->FSxMPKGCheckPdtSpecific($nPkgID);
                $nNumPdt = $nPkgPdt [0]->counts;

                if ($nNumPdt == 0) {
                    // Return สามารถ Insert ได้ เพราะไม่มีสินค้าเฉพราะ
                    $oBookingType = $this->oPackage->FSxMPKGGetZneBookingType($nZneID);
                    $nBookingType = $oBookingType [0]->FTZneBookingType;

                    // สถานะ Seat
                    if ($nBookingType == '1') {
                        // Check Pdt ใน Pkg ว่ามีสถานะเป็น Room หรือไม่
                        $oHaveStaRoom = $this->oPackage->FSxMPKGCheckPdtHaveStaRoom4($nPkgID);
                        $nStaRoom = $oHaveStaRoom [0]->counts;

                        if ($nStaRoom > 0) {
                            $stt = '0';
                            $Msg = language('ticket/package/package', 'tPkg_HavePdtRoomCantAdd');
                            echo $stt . "," . $Msg;
                            break;
                        } else {
                            // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Package อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                            $oHaveStaPkg = $this->oPackage->FSxMPKGCheckPdtHaveStaPackage3($nPkgID);
                            $nStaPkg = $oHaveStaPkg [0]->counts;
                            if ($nStaPkg > 0) {
                                $stt = '0';
                                $Msg = language('ticket/package/package', 'tPkg_HavePdtPackageCantAdd');
                                echo $stt . "," . $Msg;
                                break;
                            } else {
                                // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น สินค้าปรุง อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                                $oHavePdtAdj = $this->oPackage->FSxMPKGCheckPdtHaveStaPdtAdj1($nPkgID);
                                $nPdtAdj = $oHavePdtAdj [0]->counts;
                                if ($nPdtAdj > 0) {
                                    $stt = '0';
                                    $Msg = language('ticket/package/package', 'tPkg_HavePdtAdjCantAdd');
                                    echo $stt . "," . $Msg;
                                    break;
                                } else {
                                    $stt = '1';
                                    $Msg = language('ticket/package/package', 'tPkg_AddZoneSeatSucc');

                                    $nStatus = $this->oPackage->FSxMPKGAddPkgModelZone($nZneID, $nPkgLocID, $nPkgID, $nPmoID, $nZnePri);

                                    if ($nStatus == 0) {
                                        $stt = '0';
                                        $Msg = language('ticket/package/package', 'tPkg_AlreadyZone');
                                        echo $stt . "," . $Msg;
                                    }
                                }
                            }
                        }
                    }

                    // สถานะ Room
                    if ($nBookingType == '2') {

                        // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Seat อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                        $oHaveStaSeat = $this->oPackage->FSxMPKGCheckPdtHaveStaSeat5($nPkgID);
                        $nStaSeat = $oHaveStaSeat [0]->counts;

                        if ($nStaSeat > 0) {
                            $stt = '0';
                            $Msg = language('ticket/package/package', 'tPkg_HavePdtSeatCantAdd');
                            echo $stt . "," . $Msg;
                            break;
                        } else {
                            // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Package อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                            $oHaveStaPkg = $this->oPackage->FSxMPKGCheckPdtHaveStaPackage3($nPkgID);
                            $nStaPkg = $oHaveStaPkg [0]->counts;
                            if ($nStaPkg > 0) {
                                $stt = '0';
                                $Msg = language('ticket/package/package', 'tPkg_HavePdtPackageCantAdd');
                                echo $stt . "," . $Msg;
                                break;
                            } else {
                                // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น สินค้าปรุง อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                                $oHavePdtAdj = $this->oPackage->FSxMPKGCheckPdtHaveStaPdtAdj1($nPkgID);
                                $nPdtAdj = $oHavePdtAdj [0]->counts;
                                if ($nPdtAdj > 0) {
                                    $stt = '0';
                                    $Msg = language('ticket/package/package', 'tPkg_HavePdtAdjCantAdd');
                                    echo $stt . "," . $Msg;
                                    break;
                                } else {
                                    $stt = '1';
                                    $Msg = language('ticket/package/package', 'tPkg_AddZoneRoomSucc');

                                    $nStatus = $this->oPackage->FSxMPKGAddPkgModelZone($nZneID, $nPkgLocID, $nPkgID, $nPmoID, $nZnePri);
                                    if ($nStatus == 0) {
                                        $stt = '0';
                                        $Msg = language('ticket/package/package', 'tPkg_AlreadyZone');
                                        echo $stt . "," . $Msg;
                                    }
                                }
                            }
                        }
                    }

                    if ($nBookingType == '3') {
                        // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Seat อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                        $oHaveStaSeat = $this->oPackage->FSxMPKGCheckPdtHaveStaSeat5($nPkgID);
                        $nStaSeat = $oHaveStaSeat [0]->counts;

                        if ($nStaSeat > 0) {
                            $stt = '0';
                            $Msg = language('ticket/package/package', 'tPkg_HavePdtSeatCantAdd');
                            echo $stt . "," . $Msg;
                        } else {
                            // Check Pdt ใน Pkg ว่ามีสถานะเป็น Room หรือไม่
                            $oHaveStaRoom = $this->oPackage->FSxMPKGCheckPdtHaveStaRoom4($nPkgID);
                            $nStaRoom = $oHaveStaRoom [0]->counts;

                            if ($nStaRoom > 0) {
                                $stt = '0';
                                $Msg = language('ticket/package/package', 'tPkg_HavePdtRoomCantAdd');
                                echo $stt . "," . $Msg;
                                break;
                            } else {
                                // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Package อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                                $oHaveStaPkg = $this->oPackage->FSxMPKGCheckPdtHaveStaPackage3($nPkgID);
                                $nStaPkg = $oHaveStaPkg [0]->counts;
                                if ($nStaPkg > 0) {
                                    $stt = '0';
                                    $Msg = language('ticket/package/package', 'tPkg_HavePdtPackageCantAdd');
                                    echo $stt . "," . $Msg;
                                    break;
                                } else {
                                    // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น สินค้าปรุง อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                                    $oHavePdtAdj = $this->oPackage->FSxMPKGCheckPdtHaveStaPdtAdj1($nPkgID);
                                    $nPdtAdj = $oHavePdtAdj [0]->counts;
                                    if ($nPdtAdj > 0) {
                                        $stt = '0';
                                        $Msg = language('ticket/package/package', 'tPkg_HavePdtAdjCantAdd');
                                        echo $stt . "," . $Msg;
                                        break;
                                    } else {
                                        $stt = '1';
                                        $Msg = language('ticket/package/package', 'tPkg_AddZoneTicketSucc');
                                        $nStatus = $this->oPackage->FSxMPKGAddPkgModelZone($nZneID, $nPkgLocID, $nPkgID, $nPmoID, $nZnePri);
                                        if ($nStatus == 0) {
                                            $stt = '0';
                                            $Msg = language('ticket/package/package', 'tPkg_AlreadyZone');
                                            echo $stt . "," . $Msg;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    // Return ไม่สามารถ Insert ได้
                    $stt = '0';
                    $Msg = language('ticket/package/package', 'tPkg_HaveSpecificPdtOfModelCantAddPlsRemove');
                    echo $stt . "," . $Msg;
                    break;
                }
            } else {
                $oBookingType = $this->oPackage->FSxMPKGGetZneBookingType($nZneID);
                $nBookingType = $oBookingType [0]->FTZneBookingType;

                // สถานะ Seat
                if ($nBookingType == '1') {
                    // Check Pdt ใน Pkg ว่ามีสถานะเป็น Room หรือไม่
                    $oHaveStaRoom = $this->oPackage->FSxMPKGCheckPdtHaveStaRoom4($nPkgID);
                    $nStaRoom = $oHaveStaRoom [0]->counts;

                    if ($nStaRoom > 0) {
                        $stt = '0';
                        $Msg = language('ticket/package/package', 'tPkg_HavePdtRoomCantAdd');
                        echo $stt . "," . $Msg;
                        break;
                    } else {
                        // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Package อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                        $oHaveStaPkg = $this->oPackage->FSxMPKGCheckPdtHaveStaPackage3($nPkgID);
                        $nStaPkg = $oHaveStaPkg [0]->counts;
                        if ($nStaPkg > 0) {
                            $stt = '0';
                            $Msg = language('ticket/package/package', 'tPkg_HavePdtPackageCantAdd');
                            echo $stt . "," . $Msg;
                            break;
                        } else {
                            // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น สินค้าปรุง อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                            $oHavePdtAdj = $this->oPackage->FSxMPKGCheckPdtHaveStaPdtAdj1($nPkgID);
                            $nPdtAdj = $oHavePdtAdj [0]->counts;
                            if ($nPdtAdj > 0) {
                                $stt = '0';
                                $Msg = language('ticket/package/package', 'tPkg_HavePdtAdjCantAdd');
                                echo $stt . "," . $Msg;
                                break;
                            } else {

                                $stt = '1';
                                $Msg = language('ticket/package/package', 'tPkg_AddZoneSeatSucc');
                                $nStatus = $this->oPackage->FSxMPKGAddPkgModelZone($nZneID, $nPkgLocID, $nPkgID, $nPmoID, $nZnePri);
                                if ($nStatus == 0) {
                                    $stt = '0';
                                    $Msg = language('ticket/package/package', 'tPkg_AlreadyZone');
                                    echo $stt . "," . $Msg;
                                }
                            }
                        }
                    }
                }

                // สถานะ Room
                if ($nBookingType == '2') {

                    // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Seat อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                    $oHaveStaSeat = $this->oPackage->FSxMPKGCheckPdtHaveStaSeat5($nPkgID);
                    $nStaSeat = $oHaveStaSeat [0]->counts;

                    if ($nStaSeat > 0) {
                        $stt = '0';
                        $Msg = language('ticket/package/package', 'tPkg_HavePdtSeatCantAdd');
                        echo $stt . "," . $Msg;
                        break;
                    } else {
                        // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Package อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                        $oHaveStaPkg = $this->oPackage->FSxMPKGCheckPdtHaveStaPackage3($nPkgID);
                        $nStaPkg = $oHaveStaPkg [0]->counts;
                        if ($nStaPkg > 0) {
                            $stt = '0';
                            $Msg = language('ticket/package/package', 'tPkg_HavePdtPackageCantAdd');
                            echo $stt . "," . $Msg;
                            break;
                        } else {
                            // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น สินค้าปรุง อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                            $oHavePdtAdj = $this->oPackage->FSxMPKGCheckPdtHaveStaPdtAdj1($nPkgID);
                            $nPdtAdj = $oHavePdtAdj [0]->counts;
                            if ($nPdtAdj > 0) {
                                $stt = '0';
                                $Msg = language('ticket/package/package', 'tPkg_HavePdtAdjCantAdd');
                                echo $stt . "," . $Msg;
                                break;
                            } else {
                                $stt = '1';
                                $Msg = language('ticket/package/package', 'tPkg_AddZoneRoomSucc');
                                $nStatus = $this->oPackage->FSxMPKGAddPkgModelZone($nZneID, $nPkgLocID, $nPkgID, $nPmoID, $nZnePri);
                                if ($nStatus == 0) {
                                    $stt = '0';
                                    $Msg = language('ticket/package/package', 'tPkg_AlreadyZone');
                                    echo $stt . "," . $Msg;
                                }
                            }
                        }
                    }
                }

                if ($nBookingType == '3') {
                    // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Seat อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                    $oHaveStaSeat = $this->oPackage->FSxMPKGCheckPdtHaveStaSeat5($nPkgID);
                    $nStaSeat = $oHaveStaSeat [0]->counts;

                    if ($nStaSeat > 0) {
                        $stt = '0';
                        $Msg = language('ticket/package/package', 'tPkg_HavePdtSeatCantAdd');
                        echo $stt . "," . $Msg;
                        break;
                    } else {
                        // Check Pdt ใน Pkg ว่ามีสถานะเป็น Room หรือไม่
                        $oHaveStaRoom = $this->oPackage->FSxMPKGCheckPdtHaveStaRoom4($nPkgID);
                        $nStaRoom = $oHaveStaRoom [0]->counts;

                        if ($nStaRoom > 0) {
                            $stt = '0';
                            $Msg = language('ticket/package/package', 'tPkg_HavePdtRoomCantAdd');
                            echo $stt . "," . $Msg;
                            break;
                        } else {
                            // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น Package อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                            $oHaveStaPkg = $this->oPackage->FSxMPKGCheckPdtHaveStaPackage3($nPkgID);
                            $nStaPkg = $oHaveStaPkg [0]->counts;
                            if ($nStaPkg > 0) {
                                $stt = '0';
                                $Msg = language('ticket/package/package', 'tPkg_HavePdtPackageCantAdd');
                                echo $stt . "," . $Msg;
                                break;
                            } else {
                                // Check Pdt ใน Pkg ว่ามีสินค้าที่เป็น สินค้าปรุง อยู่หรือไม่ถ้ามีจะไม่สามารถเพิ้มได้
                                $oHavePdtAdj = $this->oPackage->FSxMPKGCheckPdtHaveStaPdtAdj1($nPkgID);
                                $nPdtAdj = $oHavePdtAdj [0]->counts;
                                if ($nPdtAdj > 0) {
                                    $stt = '0';
                                    $Msg = language('ticket/package/package', 'tPkg_HavePdtAdjCantAdd');
                                    echo $stt . "," . $Msg;
                                    break;
                                } else {
                                    $stt = '1';
                                    $Msg = language('ticket/package/package', 'tPkg_AddZoneTicketSucc');
                                    $nStatus = $this->oPackage->FSxMPKGAddPkgModelZone($nZneID, $nPkgLocID, $nPkgID, $nPmoID, $nZnePri);
                                    if ($nStatus == 0) {
                                        $stt = '0';
                                        $Msg = language('ticket/package/package', 'tPkg_AlreadyZone');
                                        echo $stt . "," . $Msg;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // @Natt Add Check
        if (trim($nBookingType) != '3') {
            $this->oPackage->FSxMPKGUpdateMaxPark($nPkgID);
        }
    }

    public function FSxCPKGCheckPkgModelZoneMore2() {
        $aZneID = $this->input->post('nZneID');
        $nPkgLocID = $this->input->post('nPkgLocID');
        $nPkgID = $this->input->post('nPkgID');
        $nPmoID = $this->input->post('nPmoID');
        $nPpkPrice = $this->input->post('nPpkPrice');

        $nBktold = '';
        $staAcc = '';

        $n = FCNnHSizeOf($aZneID);
        if ($n == 1) {
            // FSnCPKGAddPkgModelZone($aZneID,$nPkgLocID,$nPkgID,$nPmoID,$nPpkPrice);
            $staAcc = 1;
        } else {
            foreach ($aZneID as $key => $nZneID) {

                $oBkt = $this->oPackage->JSnPKGCheckZneBookingType($nZneID);
                $nBkt = $oBkt [0]->FTZneBookingType;

                if ($nBktold != '') {
                    if ($nBktold != $nBkt) {
                        $staAcc = '0';
                    } else {
                        $staAcc = 1;
                        // FSnCPKGAddPkgModelZone($aZneID,$nPkgLocID,$nPkgID,$nPmoID,$nPpkPrice);
                    }
                }

                $nBktold = $nBkt;
            }
        }

        if ($staAcc != '') {
            echo $staAcc;
        }
    }

    public function FSxCPKGCallPagePkgModalCstZone() {
        $nLocID = $this->input->post('nLocID');
        $nPkgID = $this->input->post('nPkgID');

        $oZoneList = $this->oPackage->FSxMPKGGetZoneList($nLocID, $nPkgID);

        $this->load->view('ticket/package/wPackagePageModalModelCstZonePanal', array(
            'oZoneList' => $oZoneList
        ));
    }

    public function FSxCPKGCallPagePkgModalCstShowTime() {
        $nLocID = $this->input->post('nLocID');
        $nPkgID = $this->input->post('nPkgID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
        $nEvnID = $oPkgDetail [0]->FNEvnID;
        $oLocShwTime = $this->oPackage->FSxMPKGGetLocShowTimeList($nLocID, $nEvnID);
        $oLocTimeTableHD = $this->oPackage->FSxMPKGGetLocTimeTableHDList();

        $this->load->view('ticket/package/wPackagePageModalModelCstShowTimePanal', array(
            'oPkgDetail' => $oPkgDetail,
            'oLocShwTime' => $oLocShwTime,
            'oLocTimeTableHD' => $oLocTimeTableHD
        ));
    }

    public function FSxCPKGCallPageViewDetailLocShowTime() {
        $nTmhID = $this->input->post('nTmhID');

        $oDetailTimeTable = $this->oPackage->FSxMPKGGetDetailTimeTableDT($nTmhID);

        $this->load->view('ticket/package/wPackageViewDetailLocShowTime', array(
            'oDetailTimeTable' => $oDetailTimeTable
        ));
    }

    public function FSnCPKGAddLocShowTime() {
        $nLocID = $this->input->post('nLocID');
        $nTmhID = $this->input->post('nTmhID');
        $nPkgID = $this->input->post('nPkgID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
        $nEvnID = $oPkgDetail [0]->FNEvnID;

        // $dShwStartDate = date("Y-01-01");
        // $dShwEndDate = date("Y-12-31",strtotime('+10 years'));
        $dDateNow = date("Y-m-d");

        // GET Date From Event
        $oEvnStartAndFinish = $this->oPackage->FSnMPKGGetDateEvnStartAndFinish($nEvnID);
        $dEvnDateStart = $oEvnStartAndFinish [0]->FDEvnStart;
        $dEvnDateFinish = $oEvnStartAndFinish [0]->FDEvnFinish;

        // GET Time From TimeDT
        $oTimeMaxAndMinTime = $this->oPackage->FSnMPKGGetTimeMaxAndMinTimeTableDT($nTmhID);
        $dMinStartTime = $oTimeMaxAndMinTime [0]->MinStartTime;
        $dMaxEndTime = $oTimeMaxAndMinTime [0]->MaxEndTime;
        $aData = array(
            'FNEvnID' => $nEvnID,
            'FNLocID' => $nLocID,
            'FNTmhID' => $nTmhID,
            'FDShwStartDate' => $dEvnDateStart,
            'FTShwStartTime' => $dMinStartTime,
            'FTShwEndTime' => $dMaxEndTime,
            'FDShwEndDate' => $dEvnDateFinish
        );
        $nSttAdd = $this->oPackage->FSnMPKGAddLocShowTime($aData, $dDateNow);
        switch ($nSttAdd) {
            case '500' :
                echo language('ticket/package/package', 'tPkg_AlreadyHaveShowtimeMSG');
                break;
            case '1' :
                echo language('ticket/package/package', 'tPkg_AddShowTimeSuccessMSG');
                break;
            case '0' :
                echo language('ticket/package/package', 'tPkg_AddShowTimeFailMSG');
                break;
        }
    }

    public function FSxCPKGCheckLocHaveShowTime() {
        $nLocID = $this->input->post('nPkgLocID');
        $nEvnID = $this->input->post('nEvnID');

        $oShwTimeNum = $this->oPackage->FSxMPKGCheckHaveLocShowTimeBeforeAddZone($nLocID, $nEvnID);
        $nShwTimeNum = $oShwTimeNum [0]->counts;

        if ($nShwTimeNum == 0) {
            echo $nShwTimeNum . "," . language('ticket/package/package', 'tPkg_PleaseSelectShowtimeMSG');
        } else {
            echo $nShwTimeNum . "," . language('ticket/package/package', 'tPkg_CanAddZoneMSG');
        }
    }

    public function FSnCPKGCallPageLocShowTimePanal() {
        $nLocID = $this->input->post('nLocID');
        $nPkgID = $this->input->post('nPkgID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
        $nEvnID = $oPkgDetail [0]->FNEvnID;

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
        $oLocShwTime = $this->oPackage->FSxMPKGGetLocShowTimeList($nLocID, $nEvnID);

        $this->load->view('ticket/package/wPackageLocShowTimePanal', array(
            'oPkgDetail' => $oPkgDetail,
            'oLocShwTime' => $oLocShwTime
        ));
    }

    public function FSxCPKGDelPkgLocShowTimePanal() {
        $nEvnID = $this->input->post('nEvnID');
        $nLocID = $this->input->post('nLocID');
        $nTmhID = $this->input->post('nTmhID');

        $nSttDel = $this->oPackage->FSxMPKGDelPkgLocShowTime($nEvnID, $nLocID, $nTmhID);

        echo $nSttDel;
    }

    public function FSxCPKGCallPageTimeTableHDPanal() {
        $nPkgID = $this->input->post('nPkgID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $oLocTimeTableHD = $this->oPackage->FSxMPKGGetLocTimeTableHDList();

        $this->load->view('ticket/package/wPackageLocTimeTableHDPanal', array(
            'oLocTimeTableHD' => $oLocTimeTableHD,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPageModalModelCustomer() {
        $nPmoID = $this->input->post('nPmoID');
        $nPkgID = $this->input->post('nPkgID');

        $oLocationList = $this->oPackage->FSxMPKGGetLocationList($nPmoID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/wPackagePageModalModelCustomer', array(
            'oLocationList' => $oLocationList,
            'nPmoID' => $nPmoID,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGDelPkgModelCustomer() {
        $nPpkID = $this->input->post('nPpkID');
        $nPkgID = $this->input->post('nPkgID');

        $oSttDelPpkModelCst = $this->oPackage->FSxMPKGDelPkgModelCustomer($nPpkID);
        echo $oSttDelPpkModelCst;

        $oType = $this->oPackage->FSxCPKGCheckZoneType($nPkgID);
        if (@$oType[0]->FTZneBookingType == "") {
            $this->oPackage->FSxMPKGUpdateMaxPark($nPkgID);
        }
    }

    public function FSxCPKGDelPkgModelAdmin() {
        $nPkgID = $this->input->post('nPkgID');
        $nPmoID = $this->input->post('nPmoID');

        $nSttDelPkgModel = $this->oPackage->FSxMPKGDelPkgModelAdmin($nPkgID, $nPmoID);

        switch ($nSttDelPkgModel) {
            case '1' :
                echo $nSttDelPkgModel . "," . language('ticket/package/package', 'tPkg_DelSuccessMSG');
                break;
            case '0' :
                echo $nSttDelPkgModel . "," . language('ticket/package/package', 'tPkg_DelFailMSG');
                break;
        }
    }

    public function FSxCPKGAddPkgModel() {
        $nPkgID = $this->input->post('oetHidePkgID');
        $nPmoID = $this->input->post('ocmPkgPmoID');
        $nPpkType = $this->input->post('ocmPkgPpkType');

        $aData = array(
            'FNPkgID' => $nPkgID,
            'FNPmoID' => $nPmoID,
            'FTPpkType' => $nPpkType
        );

        $nSttAdd = $this->oPackage->FSxMPKGAddPkgModel($aData);

        switch ($nSttAdd) {
            case '1' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                break;
            case '0' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddFailMSG');
                break;
            case '500' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_MsgAlreadyHaveModel');
                break;
        }
    }

    public function FSxCPKGCallPagePkgModel() {
        $nPkgID = $this->input->post('nPkgID');

        $oProvinceList = $this->oPackage->FSxMPKGGetProvinceList();
        $oModelList = $this->oPackage->FSxMPKGGetModelList();

        $oPkgModelForAdmin = $this->oPackage->FSxMPKGGetPkgModelForAdminList($nPkgID);
        $oPkgModelForCustomer = $this->oPackage->FSxMPKGGetPkgModelForCustomerList($nPkgID);
        $oPkgModelForCustomerCount = $this->oPackage->FSxMPKGGetPkgModelForCustomerListCount($nPkgID);
        $oPkgMaxPark = $this->oPackage->FSxMPKGGetPkgMaxPark($nPkgID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
        
        $this->load->view('ticket/package/wPackagePageModel', array(
            'oModelList' => $oModelList,
            'oPkgModelForAdmin' => $oPkgModelForAdmin,
            'oPkgModelForCustomer' => $oPkgModelForCustomer,
            'nPkgID' => $nPkgID,
            'oPkgModelForCustomerCount' => $oPkgModelForCustomerCount,
            'oPkgMaxPark' => $oPkgMaxPark,
            'oProvinceList' => $oProvinceList,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePkgProduct() {
        $nPkgID = $this->input->post('nPkgID');

        $nPmoID = '';
        $oTchGroupList = $this->oPackage->FSxMPKGGetTchGroupListPagePdt($nPmoID, $nPkgID);
        // $oProductList = $this->oPackage->FSxMPKGGetProductList();
        $oPkgProductList = $this->oPackage->FSxMPKGGetPkgProductList($nPkgID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
        $oPkgModelForCustomer = $this->oPackage->FSxMPKGGetPkgModelForCustomerListSelectBox($nPkgID);
        $this->load->view('ticket/package/wPackagePageProduct', array(
            'oTchGroupList' => $oTchGroupList,
            'oPkgProductList' => $oPkgProductList,
            'oPkgDetail' => $oPkgDetail,
            'oPkgModelForCustomer' => $oPkgModelForCustomer,
            'nPkgID' => $nPkgID
        ));
    }

    public function FSxCPKGCallPagePkgSpcPriByGrp() {
        $nPkgID = $this->input->post('nPkgID');
        $nPpkID = $this->input->post('nPpkID');
        $tZneName = $this->input->post('tZneName');

        $oPkgGrpPriList = $this->oPackage->FSoMPKGGetPkgGrpPriList($nPpkID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/wPackagePagePkgGrpPri', array(
            'oPkgGrpPriList' => $oPkgGrpPriList,
            'oPkgDetail' => $oPkgDetail,
            'nPkgID' => $nPkgID,
            'nPpkID' => $nPpkID,
            'tZneName' => $tZneName
        ));
    }

    public function FSxCPKGAddPkgModelProduct() {
        $nPkgID = $this->input->post('nPkgID');
        $nTchID = $this->input->post('nTchGroupID');
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $nPkgPdtPrice = $this->input->post('nPkgPdtPrice');
        $nPdtMaxPerson = $this->input->post('nPdtMaxPerson');

        if ($nPkgPdtPrice == '') {
            $nPkgPdtPrice = 0;
        }
        $aData = array(
            'FNPkgID' => $nPkgID,
            'FNPdtID' => $nPkgPdtID,
            'FCPdtPrice' => $nPkgPdtPrice,
            'FNPdtMaxPerson' => $nPdtMaxPerson
        );

        $nSttAdd = $this->oPackage->FSxMPKGAddPkgModelProduct($aData);

        switch ($nSttAdd) {
            case '1' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                break;
            case '0' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddFailMSG');
                break;
            case '500' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_MsgAlreadyHaveProduct');
                break;
        }
    }

    public function FSnCPKGAddSpcPkgGrpPri() {
        $nPpkID = $this->input->post('nPpkID');
        $nPkgGrpPriType = $this->input->post('nPkgGrpPriType');
        $nPkgGrpPriTypeList = $this->input->post('nPkgGrpPriTypeList');
        $nPkgPgpPdtPrice = $this->input->post('nPkgPgpPdtPrice');

        $aData = array(
            'FNPpkID' => $nPpkID,
            'FNPkgPdtID' => '',
            'FTPgpType' => $nPkgGrpPriType,
            'FNPgpRefID' => $nPkgGrpPriTypeList,
            'FCPgpPdtPrice' => $nPkgPgpPdtPrice
        );

        $nSttAdd = $this->oPackage->FSnMPKGAddSpcPkgGrpPri($aData);

        switch ($nSttAdd) {
            case '1' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                break;
            case '0' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddFailMSG');
                break;
            case '500' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_MsgAlreadyHaveGroup');
                break;
        }
    }

    public function FSnCPKGAddPkgPdtGrpPri() {
        $nPkgID = $this->input->post('nPkgID');
        $nPkgGrpPriType = $this->input->post('nPkgGrpPriType');
        $nPkgGrpPriTypeList = $this->input->post('nPkgGrpPriTypeList');
        $nPkgPgpPdtPrice = $this->input->post('nPkgPgpPdtPrice');
        $nPkgPdtID = $this->input->post('nPkgPdtID');

        $aData = array(
            'FNPpkID' => $nPkgID,
            'FNPkgPdtID' => '',
            'FTPgpType' => $nPkgGrpPriType,
            'FNPgpRefID' => $nPkgGrpPriTypeList,
            'FCPgpPdtPrice' => $nPkgPgpPdtPrice,
            'FNPkgPdtID' => $nPkgPdtID
        );

        $nSttAdd = $this->oPackage->FSnMPKGAddPkgPdtGrpPri($aData);

        switch ($nSttAdd) {
            case '1' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddSuccessMSG');
                break;
            case '0' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_AddFailMSG');
                break;
            case '500' :
                echo $nSttAdd . "," . language('ticket/package/package', 'tPkg_MsgAlreadyHaveGroup');
                break;
        }
    }

    public function FSxCPKGGetSelectPdtHTML() {
        $nTchID = $this->input->post('nTchID');
        $nPkgID = $this->input->post('nPkgID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $nPkgType = $oPkgDetail [0]->FTPkgType;

        $oPdtList = $this->oPackage->FSxMPKGGetSelectPdtHTML($nTchID, $nPkgID, $nPkgType);

        // var_dump($oPdtList);
        if (isset($oPdtList [0]->FNPdtID)) {
            echo "<option  value='' >" . language('ticket/package/package', 'tPkg_SelectPdt') . "</option>";
            foreach ($oPdtList as $Value) {
                echo "<option  value='" . $Value->FNPdtID . "' data-id='" . $Value->FNPdtOthSystem . "'>" . $Value->FTPdtName . " (" . language('ticket/package/package', 'tPkg_PackagePdtOthSystem' . $Value->FNPdtOthSystem) . ")</option>";
            }
        } else {

            echo "<option  value=''>" . language('ticket/package/package', 'tPkg_DontHavePdt') . "</option>";
        }
    }

    public function FSxCPKGGetSelectTchGrpByPmoHTML() {
        $nPmoID = $this->input->post('nPmoID');
        $nPkgID = $this->input->post('nPkgID');

        $oTchGrpList = $this->oPackage->FSxMPKGGetTchGroupListPagePdt($nPmoID, $nPkgID);

        // var_dump($oPdtList);
        if (isset($oTchGrpList [0]->FNTcgID)) {

            echo "<option  value='' data-name=''>" . language('ticket/package/package', 'tPkg_TchGroup') . "</option>";
            foreach ($oTchGrpList as $Value) {
                echo "<option  value='" . $Value->FNTcgID . "' data-name='" . $Value->FTTcgName . "'>" . $Value->FTTcgName . "</option>";
            }
        } else {

            echo "<option  value=''>" . language('ticket/package/package', 'tPkg_NoPdtGrp') . "</option>";
        }
    }

    public function FStCPKGGetSelectPkgGrpPriHTML() {
        $nPgpType = $this->input->post('nPgpType');

        // Agenicy
        if ($nPgpType == '1') {

            $oAgencyList = $this->oPackage->FSoMPKGGetSelectPkgGrpPriAgencyHTML();

            if (isset($oAgencyList [0]->FTAggCode)) {
                foreach ($oAgencyList as $Value) {
                    echo "<option  value='" . $Value->FTAggCode . "' >" . $Value->FTAggName . "</option>";
                }
            } else {
                echo "<option  value=''>" . language('ticket/package/package', 'tPkg_NoAgency') . "</option>";
            }
        } else {
            // Customer
            $oCstList = $this->oPackage->FSoMPKGGetSelectPkgGrpPriCustomerHTML();

            if (isset($oCstList [0]->FNCgpID)) {

                foreach ($oCstList as $Value) {
                    echo "<option  value='" . $Value->FNCgpID . "' >" . $Value->FTCgpName . "</option>";
                }
            } else {
                echo "<option  value=''>" . language('ticket/package/package', 'tPkg_NoCustomer') . "</option>";
            }
        }
    }

    public function FSxCPKGGetSelectModelHTML() {
        $nPvnID = $this->input->post('nPvnID');
        if ($nPvnID != '') {

            $oMolList = $this->oPackage->FSxMPKGGetSelectProvinceHTML($nPvnID);
            if (isset($oMolList [0]->FNPmoID)) {
                
                foreach ($oMolList as $Value) {
                    echo "<option class='xWModelList' value='" . $Value->FNPmoID . "' data-name='" . $Value->FTBchName . "'>" . $Value->FTBchName . "</option>";
                }
            } else {
                echo "<option  value=''>" . language('ticket/package/package', 'tPkg_NoModel') . "</option>";
            }
        } else {
            $oMolList = $this->oPackage->FSxMPKGGetModelList();

            if (isset($oMolList [0]->FTBchCode)) {

                echo "<option value=''>" . language('ticket/package/package', 'tPkg_SelectPark') . "</option>";
                foreach ($oMolList as $Value) {
                    echo "<option  value='" . $Value->FTBchCode . "'>" . $Value->FTBchName . "</option>";
                }
            } else {
                
                echo "<option  value=''>" . language('ticket/package/package', 'tPkg_NoModel') . "</option>";
            }
        }
    }

    public function FSxCPKGCallPagePkgDetail() {
        $nPkgID = $this->input->post('nPkgID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/wPackagePageDetail', array(
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPageModelAndPdtPanal() {
        $nPkgID = $this->input->post('nPkgID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/wPackagePageModelAndPdtPanal', array(
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePdtPriSpcPri() {
        $nPkgID = $this->input->post('nPkgID');
        $nPkgPdtID = $this->input->post('nPkgPdtID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/PkgProduct/PkgPdtSpcialPrice/wPackagePagePdtPriSpcPri', array(
            'nPkgID' => $nPkgID,
            'oPkgDetail' => $oPkgDetail,
            'nPkgPdtID' => $nPkgPdtID
        ));
    }

    public function FSxCPKGCallPagePkgGrpPriSpcPri() {
        $nPkgID = $this->input->post('nPkgID');
        $nPgpGrpID = $this->input->post('nPgpGrpID');
        $tGrpName = $this->input->post('tGrpName');
        $tZneName = $this->input->post('tZneName');
        $nPpkID = $this->input->post('nPpkID');
        $nStaPage = $this->input->post('nStaPage');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/Pkg/PkgGrpPriSpcPri/wPackagePagePkgGrpPriSpcPri', array(
            'nPkgID' => $nPkgID,
            'oPkgDetail' => $oPkgDetail,
            'nPgpGrpID' => $nPgpGrpID,
            'tGrpName' => $tGrpName,
            'tZneName' => $tZneName,
            'nPpkID' => $nPpkID,
            'nStaPage' => $nStaPage
        ));
    }

    public function FSxCPKGCallPagePpkPriSpcPri() {
        $nPkgID = $this->input->post('nPkgID');
        $nPpkID = $this->input->post('nPpkID');
        $tZneName = $this->input->post('tZneName');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/Pkg/PkgPriSpcPri/wPackagePagePpkPriSpcPri', array(
            'nPkgID' => $nPkgID,
            'oPkgDetail' => $oPkgDetail,
            'nPpkID' => $nPpkID,
            'tZneName' => $tZneName
        ));
    }

    public function FSxCPKGCallPagePdtGrpPri() {
        $nPkgID = $this->input->post('nPkgID');
        $nPkgPdtID = $this->input->post('nPkgPdtID');
        $tPdtName = $this->input->post('tPdtName');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
        $oPkgPdtPriByGrpList = $this->oPackage->FSoMPKGGetPkgPdtPriByGrpList($nPkgID, $nPkgPdtID);

        $this->load->view('ticket/package/PkgProduct/PkgPdtGrpPri/wPackagePagePdtGrpPri', array(
            'nPkgID' => $nPkgID,
            'oPkgDetail' => $oPkgDetail,
            'nPkgPdtID' => $nPkgPdtID,
            'tPdtName' => $tPdtName,
            'oPkgPdtPriByGrpList' => $oPkgPdtPriByGrpList
        ));
    }

    public function FSxCPKGCallPagePdtPriSpcPriByDOWPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPkgPdtID = $this->input->post('nPkgPdtID');

        $oPkgPdtPriDOWList = $this->oPackage->FSxMPKGGetPdtPriSpcPriByDOWPanal($nPkgID, $nPkgPdtID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/PkgProduct/PkgPdtSpcialPrice/wPkgPdtPriSpcPriByDOWPanal', array(
            'nPkgID' => $nPkgID,
            'nPkgPdtID' => $nPkgPdtID,
            'oPkgPdtPriDOWList' => $oPkgPdtPriDOWList,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePdtPriSpcPriByHLDPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPkgPdtID = $this->input->post('nPkgPdtID');

        // $oPkgPdtPriHLDList = $this->oPackage->FSxMPKGGetPdtPriSpcPriByDOWPanal($nPkgID,$nPkgPdtID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/PkgProduct/PkgPdtSpcialPrice/wPkgPdtPriSpcPriByHLDPanal', array(
            'nPkgID' => $nPkgID,
            'nPkgPdtID' => $nPkgPdtID,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePdtPriSpcPriByBKGPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPkgPdtID = $this->input->post('nPkgPdtID');

        $oPdtPriBKG = $this->oPackage->FSxMPKGGetPdtPriSpcPriByBKG($nPkgPdtID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/PkgProduct/PkgPdtSpcialPrice/wPkgPdtPriSpcPriByBKGPanal', array(
            'nPkgID' => $nPkgID,
            'nPkgPdtID' => $nPkgPdtID,
            'oPdtPriBKG' => $oPdtPriBKG,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePkgGrpPriSpcPriByDOWPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPgpGrpID = $this->input->post('nPgpGrpID');

        $oPkgGrpPriDOWList = $this->oPackage->FStMPKGGetGrpPriSpcPriByDOWPanal($nPkgID, $nPgpGrpID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/Pkg/PkgGrpPriSpcPri/wPackagePagePkgGrpPriSpcPriByDOWPanal', array(
            'nPkgID' => $nPkgID,
            'nPgpGrpID' => $nPgpGrpID,
            'oPkgGrpPriDOWList' => $oPkgGrpPriDOWList,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePkgGrpPriSpcPriByHLDPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPgpGrpID = $this->input->post('nPgpGrpID');

        // $oPkgGrpPriDOWList = $this->oPackage->FStMPKGGetGrpPriSpcPriByDOWPanal($nPkgID,$nPgpGrpID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/Pkg/PkgGrpPriSpcPri/wPackagePagePkgGrpPriSpcPriByHLDPanal', array(
            'nPkgID' => $nPkgID,
            'nPgpGrpID' => $nPgpGrpID,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePkgGrpPriSpcPriByBKGPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPgpGrpID = $this->input->post('nPgpGrpID');

        // $oPkgGrpPriDOWList = $this->oPackage->FStMPKGGetGrpPriSpcPriByDOWPanal($nPkgID,$nPgpGrpID);
        $oGrpPriBKG = $this->oPackage->FSxMPKGGetGrpPriSpcPriByBKG($nPgpGrpID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/Pkg/PkgGrpPriSpcPri/wPackagePagePkgGrpPriSpcPriByBKGPanal', array(
            'nPkgID' => $nPkgID,
            'nPgpGrpID' => $nPgpGrpID,
            'oPkgDetail' => $oPkgDetail,
            'oGrpPriBKG' => $oGrpPriBKG
        ));
    }

    public function FSxCPKGCallPagePkgPriByDOWPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPpkID = $this->input->post('nPpkID');

        $oPkgPriDOWList = $this->oPackage->FSoMPKGCallPagePkgPriByDOWPanal($nPpkID);
        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/Pkg/PkgPriSpcPri/wPackagePagePkgPriByDOWPanal', array(
            'nPkgID' => $nPkgID,
            'oPkgPriDOWList' => $oPkgPriDOWList,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGCallPagePkgPriByBKGPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPpkID = $this->input->post('nPpkID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $oPkgPriBKG = $this->oPackage->FSxMPKGGetPkgPriByBKG($nPpkID);

        $this->load->view('ticket/package/Pkg/PkgPriSpcPri/wPackagePagePkgPriByBKGPanal', array(
            'nPkgID' => $nPkgID,
            'nPpkID' => $nPpkID,
            'oPkgDetail' => $oPkgDetail,
            'oPkgPriBKG' => $oPkgPriBKG
        ));
    }

    public function FSxCPKGCallPagePkgPriByHLDPanal() {
        $nPkgID = $this->input->post('nPkgID');
        $nPpkID = $this->input->post('nPpkID');

        $oPkgDetail = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $this->load->view('ticket/package/Pkg/PkgPriSpcPri/wPackagePagePkgPriByHLDPanal', array(
            'nPkgID' => $nPkgID,
            'nPpkID' => $nPpkID,
            'oPkgDetail' => $oPkgDetail
        ));
    }

    public function FSxCPKGEditPkg() {
        $tPkgID = $this->input->post('oetEditPkgID');
        $tPkgName = $this->input->post('oetEditPkgName');
        $nStaLimitType = $this->input->post('oetEditPkgStaLimitType');
        $nStaLimitBy = $this->input->post('oetEditPkgStaLimitBy');
        $nLimitQty = $this->input->post('oetHideEditPkgLimitQty');

        $nEvnID = $this->input->post('oetEditPkgEvn');

        $dPkgStartSale = FsxDateTime($this->input->post('oetEditPkgStartSale'));
        $dPkgStopSale = FsxDateTime($this->input->post('oetEditPkgStopSale'));
        $dPkgStartChkIn = FsxDateTime($this->input->post('oetEditPkgStartChkIn'));
        $dPkgStopChkIn = FsxDateTime($this->input->post('oetEditPkgStopChkIn'));

        $nPkgTchGroup = $this->input->post('oetEditPkgTchGroup');

        $nPkgMaxPark = $this->input->post('oetEditPkgMaxPark');
        $nPkgMaxChkIn = $this->input->post('oetEditPkgMaxChkIn');

        $nPkgMinGrpQty = $this->input->post('oetEditPkgMinGrpQty');
        $nPkgMaxGrpQty = $this->input->post('oetEditPkgMaxGrpQty');

        $nPkgType = $this->input->post('ocmEditPkgType');

        $nPkgStaActive = $this->input->post('ocmEditPkgStaActive');

        $nPkgStaFreeGuide = $this->input->post('oetEditPkgStaFreeGuide');

        $tPkgDesc1 = $this->input->post('oetEditPkgDesc1');
        $tPkgDesc2 = $this->input->post('oetEditPkgDesc2');
        $tPkgDesc3 = $this->input->post('oetEditPkgDesc3');
        $tPkgDesc4 = $this->input->post('oetEditPkgDesc4');
        $tPkgDesc5 = $this->input->post('oetEditPkgDesc5');

        $nPkgTypeOld = $this->input->post('oetEditPkgStaLimitByOld');

        if ($nPkgStaFreeGuide == 'on') {
            $nPkgStaFreeGuide = '1';
        } else {
            $nPkgStaFreeGuide = '0';
        }

        if ($nEvnID == '') {
            $nEvnID = NULL;
        }

        if ($dPkgStartSale == '') {
            $dPkgStartSale = NULL;
        }
        if ($dPkgStopSale == '') {
            $dPkgStopSale = NULL;
        }
        if ($dPkgStartChkIn == '') {
            $dPkgStartChkIn = NULL;
        }
        if ($dPkgStopChkIn == '') {
            $dPkgStopChkIn = NULL;
        }

        if ($nStaLimitBy == 1) {
            $nLimitQty = '0';
        }

        if ($nPkgMinGrpQty == '') {
            $nPkgMinGrpQty = 1;
        }
        if ($nPkgMaxGrpQty == '') {
            $nPkgMaxGrpQty = NULL;
        }

        $aDataPkgList = array(
            'FTPkgStaLimitType' => $nStaLimitType,
            'FTPkgStaLimitBy' => $nStaLimitBy,
            'FNPkgLimitQty' => $nLimitQty,
            'FDPkgStartSale' => $dPkgStartSale,
            'FDPkgStopSale' => $dPkgStopSale,
            'FDPkgStartChkIn' => $dPkgStartChkIn,
            'FDPkgStopChkIn' => $dPkgStopChkIn,
            'FNTcgID' => $nPkgTchGroup,
            'FNPkgMaxPark' => $nPkgMaxPark,
            'FNPkgMaxChkIn' => $nPkgMaxChkIn,
            'FNPkgMinGrpQty' => $nPkgMinGrpQty,
            'FNPkgMaxGrpQty' => $nPkgMaxGrpQty,
            'FTPkgType' => $nPkgType,
            'FTPkgStaActive' => $nPkgStaActive,
            //'FTPkgStaFreeGuide' => $nPkgStaFreeGuide, //ยกเว้นค่าบริการไกด์
            'FTPkgStaFreeGuide' => 1, //ยกเว้นค่าบริการไกด์
            'FNPkgMinQtyByBill' => $this->input->post('oetFNPkgMinQtyByBill'),
            'FNPkgMaxQtyByBill' => $this->input->post('oetFNPkgMaxQtyByBill'),
            'FNEvnID' => $nEvnID,
            'FTWhoIns' => $this->session->userdata("username"),
            'FDDateIns' => date('Y-m-d'),
            'FTTimeIns' => date('h:i:s')
        );

        $aDataPkgList_L = array(
            'FTPkgName' => $tPkgName,
            'FTPkgDesc1' => $tPkgDesc1,
            'FTPkgDesc2' => $tPkgDesc2,
            'FTPkgDesc3' => $tPkgDesc3,
            'FTPkgDesc4' => $tPkgDesc4,
            'FTPkgDesc5' => $tPkgDesc5
        );

        if ($this->input->post('ohdPkgImg')) {
            $tImg = $this->input->post('ohdPkgImg');
            // FSaHUpdateImgObj($tPkgID, 'TTKMImgPdt', 4, 'main', $tImg, 'package');
            $aImageUplode = array(
                'tModuleName'       => 'ticket', 
                'tImgFolder'        => 'ticketpackage',
                'tImgRefID'         => $tPkgID,
                'tImgObj'           => $tImg,
                'tImgTable'         => 'TTKTPkgList',
                'tTableInsert'      => 'TCNMImgObj',
                'tImgKey'           => 'main',
                'dDateTimeOn'       => date('Y-m-d H:i:s'),
                'tWhoBy'            => $this->session->userdata('tSesUsername'),
                'nStaDelBeforeEdit' => 1
            );
            $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
        }

        $nAddPackage = $this->oPackage->FSxMPKGEditPackage($tPkgID, $aDataPkgList, $aDataPkgList_L);

        $aPpkID = $this->oPackage->FSxMPKGGetPpkID($tPkgID);

        // ถ้าเป็น Type ราคาตาม Pkg จะต้องส่งค่าไปล้าง สามตารางที่เหลือออก
        if ($nPkgType == 1) {
            if (isset($aPpkID [0]->FNPpkID)) {

                foreach ($aPpkID as $aValue) {
                    $nClearPpk = $this->oPackage->FSxMPKGClearDataOfPpkIDAllTable($aValue->FNPpkID);
                }

                $nStaClear = $this->oPackage->FSxMPKGClearModelCustomer($tPkgID, $nPkgType, $nPkgTypeOld);
                echo $tPkgID . "," . $nAddPackage;
            } else {
                echo $tPkgID . "," . $nAddPackage;
            }
        } else {
            $nStaClear = $this->oPackage->FSxMPKGClearModelCustomer($tPkgID, $nPkgType, $nPkgTypeOld);
            echo $tPkgID . "," . $nAddPackage;
        }
    }

    public function FSxCPKGAddPkg() {

        // $tPkgID = $this->input->post('oetEditPkgID');
        $tPkgName = $this->input->post('oetAddPkgName');
        $nStaLimitType = $this->input->post('oetAddPkgStaLimitType');
        $nStaLimitBy = $this->input->post('oetAddPkgStaLimitBy');
        $nLimitQty = $this->input->post('oetAddPkgLimitQty');
        $nEvnID = $this->input->post('oetAddPkgEvn');

        $dPkgStartSale = FsxDateTime($this->input->post('oetAddPkgStartSale'));
        $dPkgStopSale = FsxDateTime($this->input->post('oetAddPkgStopSale'));
        $dPkgStartChkIn = FsxDateTime($this->input->post('oetAddPkgStartChkIn'));
        $dPkgStopChkIn = FsxDateTime($this->input->post('oetAddPkgStopChkIn'));


        $nPkgTchGroup = $this->input->post('oetAddPkgTchGroup');

        $nPkgMaxPark = $this->input->post('oetAddPkgMaxPark');
        $nPkgMaxChkIn = $this->input->post('oetAddPkgMaxChkIn');

        $nPkgMinGrpQty = $this->input->post('oetAddPkgMinGrpQty');
        $nPkgMaxGrpQty = $this->input->post('oetAddPkgMaxGrpQty');

        $nPkgType = $this->input->post('ocmAddPkgType');
        // $nPkgPdtPrice = $this->input->post('oetAddPkgPdtPrice');

        $nPkgStaActive = $this->input->post('ocmAddPkgStaActive');

        $nPkgStaFreeGuide = $this->input->post('oetAddPkgStaFreeGuide');

        $tPkgDesc1 = $this->input->post('oetAddPkgDesc1');
        $tPkgDesc2 = $this->input->post('oetAddPkgDesc2');
        $tPkgDesc3 = $this->input->post('oetAddPkgDesc3');
        $tPkgDesc4 = $this->input->post('oetAddPkgDesc4');
        $tPkgDesc5 = $this->input->post('oetAddPkgDesc5');

        if ($nPkgStaFreeGuide == 'on') {
            $nPkgStaFreeGuide = '1';
        } else {
            $nPkgStaFreeGuide = '0';
        }

        if ($nEvnID == '') {
            $nEvnID = NULL;
        }

        if ($dPkgStartSale == '') {
            $dPkgStartSale = NULL;
        }
        if ($dPkgStopSale == '') {
            $dPkgStopSale = NULL;
        }
        if ($dPkgStartChkIn == '') {
            $dPkgStartChkIn = NULL;
        }
        if ($dPkgStopChkIn == '') {
            $dPkgStopChkIn = NULL;
        }

        if ($nStaLimitBy == 1) {
            $nLimitQty = '0';
        }

        if ($nPkgMinGrpQty == '') {
            $nPkgMinGrpQty = 1;
        }
        if ($nPkgMaxGrpQty == '') {
            $nPkgMaxGrpQty = NULL;
        }

        $aDataPkgList = array(
            'FTPkgStaLimitType' => $nStaLimitType,
            'FTPkgStaLimitBy' => $nStaLimitBy,
            'FNPkgLimitQty' => $nLimitQty,
            'FDPkgStartSale' => $dPkgStartSale,
            'FDPkgStopSale' => $dPkgStopSale,
            'FDPkgStartChkIn' => $dPkgStartChkIn,
            'FDPkgStopChkIn' => $dPkgStopChkIn,
            'FNTcgID' => $nPkgTchGroup,
            'FNPkgMaxPark' => $nPkgMaxPark,
            'FNPkgMaxChkIn' => $nPkgMaxChkIn,
            'FNPkgMinGrpQty' => $nPkgMinGrpQty,
            'FNPkgMaxGrpQty' => $nPkgMaxGrpQty,
            'FTPkgType' => $nPkgType,
            'FTPkgStaActive' => $nPkgStaActive,
            //'FTPkgStaFreeGuide' => $nPkgStaFreeGuide, //ยกเว้นค่าบริการไกด์
            'FTPkgStaFreeGuide' => 1, //ยกเว้นค่าบริการไกด์
            'FNPkgMinQtyByBill' => $this->input->post('oetFNPkgMinQtyByBill'),
            'FNPkgMaxQtyByBill' => $this->input->post('oetFNPkgMaxQtyByBill'),
            'FNEvnID' => $nEvnID,
            'FTWhoIns' => $this->session->userdata("username"),
            'FDDateIns' => date('Y-m-d'),
            'FTTimeIns' => date('h:i:s')
        );

        $aDataPkgList_L = array(
            'FTPkgName' => $tPkgName,
            'FTPkgDesc1' => $tPkgDesc1,
            'FTPkgDesc2' => $tPkgDesc2,
            'FTPkgDesc3' => $tPkgDesc3,
            'FTPkgDesc4' => $tPkgDesc4,
            'FTPkgDesc5' => $tPkgDesc5
        );
        $nAddPackage = $this->oPackage->FSxMPKGAddPackage($aDataPkgList, $aDataPkgList_L);
        $tPkgID = $nAddPackage;
        if ($this->input->post('ohdPkgImg')) {
            $tImg = $this->input->post('ohdPkgImg');
            // FSaHAddImgObj($tPkgID, 1, 'TTKMImgPdt', 4, 'main', $tImg, 'package');
            $aImageUplode = array(
                'tModuleName'       => 'ticket', 
                'tImgFolder'        => 'ticketpackage',
                'tImgRefID'         => $tPkgID,
                'tImgObj'           => $tImg,
                'tImgTable'         => 'TTKTPkgList',
                'tTableInsert'      => 'TCNMImgObj',
                'tImgKey'           => 'main',
                'dDateTimeOn'       => date('Y-m-d H:i:s'),
                'tWhoBy'            => $this->session->userdata('tSesUsername'),
                'nStaDelBeforeEdit' => 1
            );
            $aResAddImgObj = FCNnHAddImgObj($aImageUplode);

        }
        echo $nAddPackage;
    }

    /**
     * ลบรูป package
     */
    public function FSxCPKGDelImg() {
        if ($this->input->post('nPkgID')) {
            $tIdPkg = $this->input->post('nPkgID');
            $aDeleteImage = array(
                'tModuleName'  => 'ticket', 
                'tImgFolder'   => 'ticketpackage',
                'tImgRefID'    => $tIdPkg,
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TTKTPkgList'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }
    }

    public function FSxCPKGCallPageEditPkg() {
        $nPkgID = $this->input->post('nPkgID');

        // เข้ามาแบบ Edit
        $oPckEdit = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);

        $nPkgIDNull = '';
        $oTchGroupList = $this->oPackage->FSxMPKGGetTchGroupList($nPkgIDNull);

        $dDateNow = date("Y-m-d H:i");
        $oEvnList = $this->oPackage->FSxMPKGGetEvenList($dDateNow);
        $oAuthen = FCNaHCheckAlwFunc('EticketPackage');
        $this->load->view('ticket/package/wPackagePageEdit', array(
            'oAuthen' => $oAuthen,
            'oPckEdit' => $oPckEdit,
            'oTchGroupList' => $oTchGroupList,
            'oEvnList' => $oEvnList
        ));
    }

    public function FSxCPKGCallPageAddPkg() {

        // เข้ามาแบบ Edit
        $nPkgID = '';
        $oTchGroupList = $this->oPackage->FSxMPKGGetTchGroupList($nPkgID);

        $dDateNow = date("Y-m-d H:i");
        $oEvnList = $this->oPackage->FSxMPKGGetEvenList($dDateNow);

        $this->load->view('ticket/package/wPackagePageAdd', array(
            'oTchGroupList' => $oTchGroupList,
            'oEvnList' => $oEvnList
        ));
    }

    public function FSxCPKGDelPkgNoPdt() {
        if ($this->input->post('nPkgID')) {
            $ocbListItem = $this->input->post('nPkgID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $nPkgID = $oValue;

                $oPckEdit = $this->oPackage->FSxMPKGCallPageEditPkg($nPkgID);
                $nStaPrcDoc = $oPckEdit [0]->FTPkgStaPrcDoc;

                $aDeleteImage = array(
                    'tModuleName'  => 'ticket', 
                    'tImgFolder'   => 'ticketpackage',
                    'tImgRefID'    => $nPkgID,
                    'tTableDel'    => 'TCNMImgObj',
                    'tImgTable'    => 'TTKTPkgList'
                );

                // ถ้า Pkg == ว่าง จะลบได้เลย ถ้า ไม่ว่างคือมีการ Approve แล้วจะต้อง Check Date
                if ($nStaPrcDoc != '') {
                    $dDateNow = date("Y-m-d H:i");
                    $oChkDateDelPkg = $this->oPackage->FSnMPKGCheckDateDelPkg($nPkgID, $dDateNow);
                    $nChkDateDelPkg = $oChkDateDelPkg [0]->counts;

                    if ($nChkDateDelPkg == 0) {

                        $oPkgPdtID = $this->oPackage->FSnMPKGGetPkgPdtID($nPkgID);

                        if (isset($oPkgPdtID [0]->FNPkgPdtID)) {
                            foreach ($oPkgPdtID as $aValue) {
                                $nDelTTKTPkgGrpPri = $this->oPackage->FSxMPKGDelAllFNPkgPdtID($aValue->FNPkgPdtID);
                            }
                        }

                        $nPckSttDel = $this->oPackage->FSxMPKGDelPkgNoPdt($nPkgID);
                        $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                        if($nStaDelImgInDB == 1){
                            FSnHDeleteImageFiles($aDeleteImage);
                        }

                        $nStt = $nPckSttDel;
                        $tMsg = language('ticket/package/package', 'tPkg_DelSuccessMSG');
                        echo $nStt . "," . $tMsg;
                    } else {
                        $nStt = 0;
                        $tMsg = language('ticket/package/package', 'tPkg_DelFailPkgOnUseMSG');
                        echo $nStt . "," . $tMsg;
                    }
                } else {
                    // ยังไม่ Approve จะลบได้เลย

                    $oPkgPdtID = $this->oPackage->FSnMPKGGetPkgPdtID($nPkgID);

                    if (isset($oPkgPdtID [0]->FNPkgPdtID)) {
                        foreach ($oPkgPdtID as $aValue) {
                            $nDelTTKTPkgGrpPri = $this->oPackage->FSxMPKGDelAllFNPkgPdtID($aValue->FNPkgPdtID);
                        }
                    }

                    $nPckSttDel = $this->oPackage->FSxMPKGDelPkgNoPdt($nPkgID);
                    $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                    if($nStaDelImgInDB == 1){
                        FSnHDeleteImageFiles($aDeleteImage);
                    }
                    $nStt = $nPckSttDel;
                    $tMsg = language('ticket/package/package', 'tPkg_DelSuccessMSG');
                    echo $nStt . "," . $tMsg;
                }
            }
        }
    }

    public function FSxCPKGGETPageDialogPkgNoPdt() {
        $oPkgNoPdtList = $this->oPackage->FSxMPKGGetPkgNoPdtList();

        $this->load->view('ticket/package/wPackageDialogNoPdt', array(
            'oPkgNoPdtList' => $oPkgNoPdtList
        ));
    }

    public function FSxCPKGCountCheckPkgNoPdt() {
        $oPkgCheck = $this->oPackage->FSxMPKGCountCheckPkgNoPdt();
        $nPkgCheck = $oPkgCheck [0]->counts;
        echo $nPkgCheck;
    }

    // นับจำนวนสาขา
    public function FStCPKGCount() {
        $tFTPkgName = $this->input->post('tFTPkgName');
        $tFTPkgPmoID = $this->input->post('tFTPkgPmoID');
        $tFTPkgStaPrcDoc = $this->input->post('tFTPkgStaPrcDoc');

        $oPackageCntSh = $this->oPackage->FSaMPKGSearchCount($tFTPkgName, $tFTPkgPmoID, $tFTPkgStaPrcDoc);
        $tPackageCount = $oPackageCntSh [0]->counts;
        echo $tPackageCount;
    }

    // โหลดรายการ Package List
    public function FSxCPKGList() {
        $tFTPkgPmoID = $this->input->post('tFTPkgPmoID');
        $tFTPkgName = $this->input->post('tFTPkgName');
        $tFTPkgStaPrcDoc = $this->input->post('tFTPkgStaPrcDoc');

        $nPageNo = $this->input->post('nPageNo');
        $nRow = $this->input->post('nRow');

        if ($nPageNo == '') {
            $nPageActive = 1;
        } else {
            $nPageActive = $nPageNo;
        }

        $oPkgList = $this->oPackage->FSaMPKGList($tFTPkgPmoID, $tFTPkgName, $tFTPkgStaPrcDoc, $nPageActive, $nRow);
        $oAuthen = FCNaHCheckAlwFunc('EticketPackage');
        $this->load->view('ticket/package/wPackageList', array(
            'oAuthen'   => $oAuthen,
            'oPkgList'  => $oPkgList,
            'nPageNo'   => $nPageNo
        ));
    }

    // ค้นหา และ โหลด รายการ Produnc ใน Modal Add Package
    public function FSxCPKGPdtListSearch() {
        $tTchGroupName = $this->input->post('tTchGroupName');
        $tSchPdtName = $this->input->post('tSchPdtName');

        $oPdtList = $this->oPackage->FSxMPKGPdtListSearch($tTchGroupName, $tSchPdtName);

        $this->load->view('ticket/package/wSchPdtListPanal', array(
            'oPdtList' => $oPdtList
        ));
    }

    // โหลดรายการ Package List
    public function FSxCPKGPdtSelectedList() {
        $oValues = $this->input->post('ptValues');
        // echo var_dump($oValues);
        // echo $oValues[0];
        $this->load->view('ticket/package/wSchPdtSelectedListPanal', array(
            'oValues' => $oValues
        ));
    }

    /**
     * FS ลบ Package
     */
    public function FSxCPKGDelete() {
        $nPkgId = $this->input->get('pnPkgId');
        $nResult = $this->oPackage->FSxMPKGDelete($nPkgId);
        if ($nResult == 1) {
            // FSaDelImg($nPkgId, 'TTKMImgPdt', 4, 'main', 'package');
            $aDeleteImage = array(
                'tModuleName'  => 'ticket', 
                'tImgFolder'   => 'ticketpackage',
                'tImgRefID'    => $nPkgId,
                'tTableDel'    => 'TTKTPkgList',
                'tImgTable'    => 'TCNMImgObj'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    // @natt CheckMaxPark
    public function FSxCPKGCheckMaxPark() {
        if ($this->input->post('FNPkgID')) {
            $nPkgID = $this->input->post('FNPkgID');
            $oResult = $this->oPackage->FSxMPKGCheckMaxPark($nPkgID);
            if ($oResult [0]->FTZneBookingType == '3') {
                echo 1;
            } else {
                
            }
        }
    }

    public function FSxCPKGCheckPkgZone() {
        if ($this->input->post('FNPkgID')) {
            $nPkgID = $this->input->post('FNPkgID');
            $oType = $this->oPackage->FSxMPKGCheckTypePkg($nPkgID);
            $oZone = $this->oPackage->FSxMPKGCheckZonePkg($nPkgID);
            $aJson = array(
                'FTPkgStaLimitBy' => $oType [0]->FTPkgStaLimitBy,
                'FTZneBookingType' => $oZone [0]->FTZneBookingType
            );
            echo json_encode($aJson);
        }
    }

}
