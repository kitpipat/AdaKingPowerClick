<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cTimeList extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/timelist/mTimeList', 'mTimeList');
        $this->load->library("session");
    }

    public function FSxCTLTHD($nEvnID, $nLocID) {
        $oEvent = $this->mTimeList->FSxMTLTEvent($nEvnID);
        $oLoc = $this->mTimeList->FSxMTLTLoc($nLocID);
        $oHD = $this->mTimeList->FSxMTLTHD();
        $oAuthen = FCNaHCheckAlwFunc('EticketEvent');
        $this->load->view('ticket/timelist/wTimeList', array(
            'oAuthen' => $oAuthen,
            'nEvnID' => $nEvnID,
            'nLocID' => $nLocID,
            'oEvent' => $oEvent,
            'oLoc' => $oLoc,
            'oHD' => $oHD
        ));
    }

    public function FSxCTLTPickList() {
        if ($this->input->post('orbFNTmhID')) {
            $nFNTmhID = $this->input->post('orbFNTmhID');
            $oPickList = $this->mTimeList->FSxMTLTPickList($nFNTmhID);
            if (@$oPickList [0]->FNTmdID != "") {
                echo '<p style="font-size: 18px;">' . language('ticket/event/event', 'tEventInformation') . '</p>';
                foreach (@$oPickList as $key => $oValue) {
                    echo '<div style="padding-top: 5px; padding-bottom: 5px;">' . $oValue->FTTmdName . ' &nbsp; ' . $oValue->FTTmdStartTime . ' - ' . $oValue->FTTmdEndTime . '</div>';
                }
            } else {
                echo '';
            }
        }
    }

    // รอบปกติ
    public function FSxCTLTTimeTableSTAjaxList() {
        $tFTTmhName = $this->input->post('tFTTmhName');
        $nEventId = $this->input->post('nEventId');
        $nLocId = $this->input->post('nLocId');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oList = $this->mTimeList->FSxMTLTTimeTableSTAjaxList($tFTTmhName, $nEventId, $nLocId, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketEvent');
        $this->load->view('ticket/timelist/wTimeTableList', array(
            'oAuthen' => $oAuthen,
            'oList' => $oList
        ));
    }

    public function FStCTLTTimeTableSTCount() {
        $tFTTmhName = $this->input->post('tFTTmhName');
        $nEventId = $this->input->post('nEventId');
        $nLocId = $this->input->post('nLocId');
        $oCnt = $this->mTimeList->FStMTLTTimeTableSTCount($tFTTmhName, $nEventId, $nLocId);
        $tCount = $oCnt [0]->counts;
        echo $tCount;
    }

    public function FSxCTLTTimeTableSTAdd($nEvnID, $nLocID) {
        $oEvent = $this->mTimeList->FSxMTLTEvent($nEvnID);
        $oLoc = $this->mTimeList->FSxMTLTLoc($nLocID);
        $oHD = $this->mTimeList->FSxMTLTHD();
        $this->load->view('ticket/timelist/wAddST', array(
            'nEvnID' => $nEvnID,
            'nLocID' => $nLocID,
            'oEvent' => $oEvent,
            'oHD' => $oHD,
            'oLoc' => $oLoc
        ));
    }

    public function FSxCTLTTimeTableSTAddAjax() {
        if ($this->input->post('ocmFNTmhID')) {
            $nFNTmhID = $this->input->post('ocmFNTmhID');
            $ohdGetEventId = $this->input->post('ohdEventId');
            $ohdGetLocId = $this->input->post('ohdLocId');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->mTimeList->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->mTimeList->FSxMTLTTimeTableDT($nFNTmhID);
            $oTimeTable = $this->mTimeList->FSxMTLTTimeTable($ohdGetEventId, $ohdGetLocId);
            $oShowTimes = $this->mTimeList->FSxMTLTCheckShowTime($ohdGetEventId, $ohdGetLocId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration,
                'FTTmdStartTime' => $oTimeTableDT [0]->FTTmdStartTime,
                'FTTmdEndTime' => $oTimeTableDT [0]->FTTmdEndTime,
                'FDShwStartDate' => FsxDate($this->input->post('oetFDShwStartDate')),
                'FDShwEndDate' => FsxDate($this->input->post('oetFDShwEndDate'))
            );
            if ($oShowTimes [0]->FDShwEndDate == '') {
                $this->mTimeList->FSxMTLTUpdateShowTime($aData);
            } else {
                $this->mTimeList->FSxMTLTAddShowTime($aData);
            }
        }
    }

    public function FSxCTLTTimeTableSTEdit($nEvnID, $nLocID, $nFNTmhID) {
        $oEvent = $this->mTimeList->FSxMTLTEvent($nEvnID);
        $oLoc = $this->mTimeList->FSxMTLTLoc($nLocID);
        $oHD = $this->mTimeList->FSxMTLTHD();
        $oView = $this->mTimeList->FSxMTLTSTViewShowTime($nEvnID, $nLocID, $nFNTmhID);
        $this->load->view('ticket/timelist/wEditST', array(
            'nEvnID' => $nEvnID,
            'nLocID' => $nLocID,
            'oEvent' => $oEvent,
            'oView' => $oView,
            'oHD' => $oHD,
            'oLoc' => $oLoc
        ));
    }

    public function FSxCTLTTimeTableSTEditAjax() {
        if ($this->input->post('ocmFNTmhID')) {
            $nFNTmhID = $this->input->post('ocmFNTmhID');
            $ohdGetEventId = $this->input->post('ohdEventId');
            $ohdGetLocId = $this->input->post('ohdLocId');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->mTimeList->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->mTimeList->FSxMTLTTimeTableDT($nFNTmhID);
            $oTimeTable = $this->mTimeList->FSxMTLTTimeTable($ohdGetEventId, $ohdGetLocId);
            $oShowTimes = $this->mTimeList->FSxMTLTCheckShowTime($ohdGetEventId, $ohdGetLocId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration,
                'FTTmdStartTime' => $oTimeTableDT [0]->FTTmdStartTime,
                'FTTmdEndTime' => $oTimeTableDT [0]->FTTmdEndTime,
                'FDShwStartDate' => FsxDate($this->input->post('oetFDShwStartDate')),
                'FDShwEndDate' => FsxDate($this->input->post('oetFDShwEndDate')),
                'FNTmhIDOld' => $this->input->post('ohdFNTmhIDOld')
            );
            $this->mTimeList->FSxMTLTUpdateShowTime2($aData);
        }
    }

    public function FSxCTLTSTPickList() {
        if ($this->input->post('nFNTmhID')) {
            $nFNTmhID = $this->input->post('nFNTmhID');
            $oPickList = $this->mTimeList->FSxMTLTPickList($nFNTmhID);
            if (@$oPickList [0]->FNTmdID != "") {
                $TimeTableDT = $this->mTimeList->FSxMTLTTimeTableDT($nFNTmhID);
                $o = FsxCheckTime($TimeTableDT[0]->FTTmdStartTime, $TimeTableDT[0]->FTTmdEndTime);
                echo '<input type="hidden" id="oCheckTime" value="' . $o . '">';
                echo '<table class="table table-responsive table-bordered" style="margin-bottom: 15px;">
					  <thead>
                          <tr>
                          <th style="width: 50px;">' . language('ticket/zone/zone', 'tNo') . '</th>
                          <th>' . language('ticket/zone/zone', 'Name') . '</th>
                          <th>' . language('ticket/event/event', 'tFromTime') . '</th>
                          <th>' . language('ticket/event/event', 'tToTime') . '</th>
                          </tr>
                          </thead>
                          <tbody>
						';
                foreach (@$oPickList as $key => $oValue) {
                    $n = $key + 1;
                    echo '
						  <tr>
	                        <td scope="row">' . $n . '</td>
	                        <td>' . $oValue->FTTmdName . '</td>
	                        <td class="xWTimeFrom">' . $oValue->FTTmdStartTime . '</td>
	                        <td class="xWTimeTo">' . $oValue->FTTmdEndTime . '</td>
	                      </tr>	
                          ';
                }
                echo '</tbody></table>';
            } else {
                echo '';
            }
        }
    }

    public function FSxCTLTTimeTableSTDel() {
        if ($this->input->post('nFNEvnID')) {
            $aData = array(
                'FNTmhID' => $this->input->post('nFNTmhID'),
                'FNEvnID' => $this->input->post('nFNEvnID'),
                'FNLocID' => $this->input->post('nFNLocID'),
                'FDShwStartDate' => $this->input->post('tDateStart'),
                'FDShwEndDate' => $this->input->post('tDateEnd'),
            );
            $this->mTimeList->FSxMTLTTimeTableSTDel($aData);
        }
    }

    // -------------------------------------------------------------//
    // รอบตามวัน / สัปดาห์
    public function FSxCTLTTimeDOWAddList() {
        if ($this->input->post('orbFNTmhID')) {
            $nFNTmhID = $this->input->post('orbFNTmhID');
            $ohdGetEventId = $this->input->post('ohdGetEventId');
            $ohdGetLocId = $this->input->post('ohdGetLocId');
            $ohdFNTmeDayOfWeek = $this->input->post('ohdFNTmeDayOfWeek');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->mTimeList->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->mTimeList->FSxMTLTTimeTableDT($nFNTmhID);
            $oEvent = $this->mTimeList->FSxMTLTEvent($ohdGetEventId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FNStdDayOfWeek' => $ohdFNTmeDayOfWeek,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration
            );
            $oPickList = $this->mTimeList->FSxMTLTTimeDOWAddList($aData);
        }
    }

    public function FSxCTLTDelTimeDOW() {
        if ($this->input->post('nFNEvnID')) {
            $aData = array(
                'FNEvnID' => $this->input->post('nFNEvnID'),
                'FNLocID' => $this->input->post('nFNLocID'),
                'FNStdDayOfWeek' => $this->input->post('nDayOfWeek')
            );
            $oPickList = $this->mTimeList->FSxMTLTDelTimeDOW($aData);
        }
    }

    // ------------------------------------------------------------//
    // รอบตามวันหยุด
    public function FSxCTLTTimeHolidayAddList() {
        if ($this->input->post('orbFNTmhID')) {
            $nFNTmhID = $this->input->post('orbFNTmhID');
            $ohdGetEventId = $this->input->post('ohdGetEventId');
            $ohdGetLocId = $this->input->post('ohdGetLocId');
            $ohdFDSthCheckIn = $this->input->post('ohdFDSthCheckIn');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->mTimeList->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->mTimeList->FSxMTLTTimeTableDT($nFNTmhID);
            $oEvent = $this->mTimeList->FSxMTLTEvent($ohdGetEventId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FDSthCheckIn' => $ohdFDSthCheckIn,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration
            );
            $this->mTimeList->FSxMTLTTimeHolidayAddList($aData);
        }
    }

    public function FSxCTLTFullCalendarEvent() {
        if ($this->input->post('nEvnID')) {
            $nEvnID = $this->input->post('nEvnID');
            $nLocID = $this->input->post('nLocID');
            $oHoliday = $this->mTimeList->FSxMTLTHoliday($nEvnID, $nLocID);
            if (@$oHoliday [0]->FDSthCheckIn != "") {
                $aEvents = array();
                foreach ($oHoliday as $tValue) {
                    $a = array();
                    $a ['id'] = $tValue->FNTmhID;
                    $a ['datetime'] = $tValue->FDSthCheckIn;
                    $a ['title'] = language('ticket/event/event', 'tShowTime') . date("d-m-Y", strtotime($tValue->FDSthCheckIn));
                    $a ['start'] = date("Y-m-d", strtotime($tValue->FDSthCheckIn));
                    // $e['end'] = $row['end'];
                    $a ['color'] = "#087380";
                    $a ['textColor'] = "#FFFFFF";
                    array_push($aEvents, $a);
                }

                echo json_encode($aEvents);
            }
        }
    }

    public function FSxCTLTFullCalendarEventList() {
        if ($this->input->post('nFNTmhID')) {
            $nFNTmhID = $this->input->post('nFNTmhID');
            $nFNEvnID = $this->input->post('nFNEvnID');
            $nFNLocID = $this->input->post('nFNLocID');
            $tDate = $this->input->post('tDate');
            $oPickList = $this->mTimeList->FSxMTLTPickList($nFNTmhID);
            if (@$oPickList [0]->FNTmdID != "") {
                echo '<p style="font-size: 18px;">' . language('ticket/event/event', 'tShowTime') . '     <a style="color: #000; float: right;" onclick="JSxTLTDelTimeHoliday(\'' . $nFNEvnID . '\', \'' . $nFNLocID . '\', \'' . $nFNTmhID . '\', \'' . $tDate . '\');"><i class="fa fa-remove"></i></a></p>';
                foreach (@$oPickList as $key => $oValue) {
                    echo '<div style="padding-top: 5px; padding-bottom: 5px;">' . $oValue->FTTmdStartTime . ' - ' . $oValue->FTTmdEndTime . '</div>';
                }
            } else {
                echo '';
            }
        }
    }

    public function FSxCTLTDelTimeHoliday() {
        if ($this->input->post('nFNEvnID')) {
            $aData = array(
                'FNEvnID' => $this->input->post('nFNEvnID'),
                'FNLocID' => $this->input->post('nFNLocID'),
                'FNTmhID' => $this->input->post('nFNTmhID'),
                'FDSthCheckIn' => $this->input->post('tDate')
            );
            $oPickList = $this->mTimeList->FSxMTLTDelTimeHoliday($aData);
        }
    }

}
