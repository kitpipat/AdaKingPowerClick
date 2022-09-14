<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mTimeList extends CI_Model {

    private function FCNaMTLTCallLenData($pnPerPage, $pnPage) {
        $nPerPage = $pnPerPage;
        if (isset($pnPage)) {
            $nPage = $pnPage;
        } else {
            $nPage = 1;
        }

        $nRowStart = (($nPerPage * $nPage) - $nPerPage);

        $nRowEnd = $nPerPage * $nPage;

        $aLenData = array(
            $nRowStart,
            $nRowEnd
        );
        return $aLenData;
    }

    public function FSxMTLTEvent($nEvnID) {
        $tSQL = "SELECT EVT.*,
					EVTL.FTEvnName,
					EVTL.FTEvnDesc1,
					EVTL.FTEvnDesc2,
					EVTL.FTEvnDesc3,
					EVTL.FTEvnDesc4,
					EVTL.FTEvnDesc5,
					EVTL.FTEvnRemark,
					OBJ.FTImgObj,
					OBJ.FNImgID
				 	FROM TTKMEvent AS EVT
					LEFT JOIN TTKMEvent_L AS EVTL ON EVTL.FNEvnID = EVT.FNEvnID AND EVTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
					LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FNImgRefID = EVT.FNEvnID AND OBJ.FTImgType = '8'
					WHERE EVT.FNEvnID = '$nEvnID'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTLoc($nLocID) {
        $tSQL = "SELECT LOC.*, LOCL.FTLocName, Img.FTImgObj, Img.FNImgID   
					FROM TTKMLocation AS LOC
					LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = LOC.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
    				LEFT JOIN TTKMImgObj AS Img ON Img.FNImgRefID = LOC.FNLocID AND Img.FTImgType	= '2'
    			 WHERE LOC.FNLocID = '$nLocID'";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTHD() {
        $tSQL = "SELECT HD.*, HDL.FTTmhName  
					FROM TTKMTimeTableHD AS HD
					LEFT JOIN TTKMTimeTableHD_L AS HDL ON HDL.FNTmhID = HD.FNTmhID AND HDL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTShowTimeDOW($nEvnID, $nLocID, $nStdDayOfWeek) {
        $tSQL = "SELECT DOW.*, DT.FTTmdStartTime, DT.FTTmdEndTime, DTL.FTTmdName 
				 FROM TTKTShowTimeDOW AS DOW
				 LEFT JOIN TTKMTimeTableDT AS DT ON DT.FNTmhID = DOW.FNTmhID		 
				 LEFT JOIN TTKMTimeTableDT_L AS DTL ON DTL.FNTmdID = DT.FNTmdID AND DTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 WHERE DOW.FNEvnID = '$nEvnID' AND DOW.FNLocID = '$nLocID' AND DOW.FNStdDayOfWeek = '$nStdDayOfWeek'			
				";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTPickList($nFNTmhID) {
        $tSQL = "SELECT DT.*, DTL.FTTmdName
					FROM TTKMTimeTableDT AS DT 					
					LEFT JOIN TTKMTimeTableDT_L AS DTL ON DTL.FNTmdID = DT.FNTmdID AND DTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'					
					WHERE DT.FNTmhID = '$nFNTmhID'
				";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTTimeTableDT($nFNTmhID) {
        $tSQL = "SELECT MAX(DT.FTTmdEndTime) AS FTTmdEndTime , MIN(DT.FTTmdStartTime) AS FTTmdStartTime
				 FROM TTKMTimeTableDT AS DT	 
				 WHERE DT.FNTmhID = '$nFNTmhID'
				";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTTimeTableDTList($nFNTmhID) {
        $tSQL = "SELECT *
		FROM TTKMTimeTableDT
		WHERE FNTmhID = '$nFNTmhID'
		";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTHoliday($nEvnID, $nLocID) {
        $tSQL = "SELECT *
				 FROM TTKTShowTimeHoliday
				 WHERE FNEvnID = '$nEvnID' AND FNLocID = '$nLocID'
				 ";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTUpdateShowTime($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->where('FNLocID', $aData ['FNLocID']);
        $this->db->update('TTKTShowTime', array(
            'FNTmhID' => $aData ['FNTmhID'],
            'FTShwStartTime' => $aData ['FTTmdStartTime'],
            'FTShwEndTime' => $aData ['FTTmdEndTime'],
            'FDShwStartDate' => $aData ['FDShwStartDate'],
            'FDShwEndDate' => $aData ['FDShwEndDate'],
            'FNShwCallB4Start' => $aData ['FNShwCallB4Start'],
            'FNShwDuration' => $aData ['FNShwDuration']
        ));
    }

    public function FSxMTLTUpdateShowTime2($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->where('FNLocID', $aData ['FNLocID']);
        $this->db->where('FNTmhID', $aData ['FNTmhIDOld']);
        $this->db->update('TTKTShowTime', array(
            'FNTmhID' => $aData ['FNTmhID'],
            'FTShwStartTime' => $aData ['FTTmdStartTime'],
            'FTShwEndTime' => $aData ['FTTmdEndTime'],
            'FDShwStartDate' => $aData ['FDShwStartDate'],
            'FDShwEndDate' => $aData ['FDShwEndDate'],
            'FNShwCallB4Start' => $aData ['FNShwCallB4Start'],
            'FNShwDuration' => $aData ['FNShwDuration']
        ));
    }

    public function FSxMTLTAddShowTime($aData) {
        $this->db->insert('TTKTShowTime', array(
            'FNEvnID' => $aData ['FNEvnID'],
            'FNLocID' => $aData ['FNLocID'],
            'FNTmhID' => $aData ['FNTmhID'],
            'FTShwStartTime' => $aData ['FTTmdStartTime'],
            'FTShwEndTime' => $aData ['FTTmdEndTime'],
            'FDShwStartDate' => $aData ['FDShwStartDate'],
            'FDShwEndDate' => $aData ['FDShwEndDate'],
            'FNShwCallB4Start' => $aData ['FNShwCallB4Start'],
            'FNShwDuration' => $aData ['FNShwDuration']
        ));
    }

    public function FSxMTLTTimeDOWAddList($aData) {
        $tSQL = "
    			SELECT COUNT(DOW.FNTmhID) AS counts
				FROM TTKTShowTimeDOW AS DOW				
				WHERE DOW.FNLocID = '" . $aData ['FNLocID'] . "' AND DOW.FNEvnID = '" . $aData ['FNEvnID'] . "' AND DOW.FNStdDayOfWeek = '" . $aData ['FNStdDayOfWeek'] . "'
    			";
        $oQuery = $this->db->query($tSQL);
        $oResult = $oQuery->result();
        if ($oResult [0]->counts == 0) {
            $this->db->insert('TTKTShowTimeDOW', array(
                'FNEvnID' => $aData ['FNEvnID'],
                'FNLocID' => $aData ['FNLocID'],
                'FNStdDayOfWeek' => $aData ['FNStdDayOfWeek'],
                'FNTmhID' => $aData ['FNTmhID'],
                'FNStdCallB4Start' => $aData ['FNShwCallB4Start'],
                'FNStdDuration' => $aData ['FNShwDuration']
            ));
        } else {
            $this->db->where('FNEvnID', $aData ['FNEvnID']);
            $this->db->where('FNLocID', $aData ['FNLocID']);
            $this->db->where('FNStdDayOfWeek', $aData ['FNStdDayOfWeek']);
            $this->db->update('TTKTShowTimeDOW', array(
                'FNTmhID' => $aData ['FNTmhID'],
                'FNStdCallB4Start' => $aData ['FNShwCallB4Start'],
                'FNStdDuration' => $aData ['FNShwDuration']
            ));
        }
    }

    public function FSxMTLTTimeHolidayAddList($aData) {
        $this->db->insert('TTKTShowTimeHoliday', array(
            'FNEvnID' => $aData ['FNEvnID'],
            'FNLocID' => $aData ['FNLocID'],
            'FDSthCheckIn' => $aData ['FDSthCheckIn'],
            'FNTmhID' => $aData ['FNTmhID'],
            'FNSthCallB4Start' => $aData ['FNShwCallB4Start'],
            'FNSthDuration' => $aData ['FNShwDuration']
        ));
    }

    public function FSxMTLTDelTimeDOW($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->where('FNLocID', $aData ['FNLocID']);
        $this->db->where('FNStdDayOfWeek', $aData ['FNStdDayOfWeek']);
        $this->db->delete('TTKTShowTimeDOW');
    }

    public function FSxMTLTDelTimeHoliday($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->where('FNLocID', $aData ['FNLocID']);
        $this->db->where('FNTmhID', $aData ['FNTmhID']);
        $this->db->where('FDSthCheckIn', $aData ['FDSthCheckIn']);
        $this->db->delete('TTKTShowTimeHoliday');
    }

    public function FSxMTLTTimeTable($ohdGetEventId, $ohdGetLocId) {
        $tSQL = "SELECT FDShwStartDate, FDShwEndDate
				 FROM TTKTShowTime
				 WHERE FNEvnID = '$ohdGetEventId' AND FNLocID = '$ohdGetLocId'
		";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTCheckShowTime($ohdGetEventId, $ohdGetLocId) {
        $tSQL = "SELECT *
				 FROM TTKTShowTime
				 WHERE FNEvnID = '$ohdGetEventId' AND FNLocID = '$ohdGetLocId'
		";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // รอบปกติ
    public function FSxMTLTTimeTableSTAjaxList($tFTTmhName, $nEventId, $nLocId, $nPageNo = 1) {
        $aRowLen = $this->FCNaMTLTCallLenData(5, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQL = "SELECT c.* FROM(
					SELECT ROW_NUMBER() OVER(ORDER BY STM.FNTmhID DESC) AS RowID,
					STM.*, HDL.FTTmhName
				 	FROM TTKTShowTime AS STM
				 	LEFT JOIN TTKMTimeTableHD_L AS HDL ON HDL.FNTmhID = STM.FNTmhID AND HDL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 	WHERE (STM.FNTmhID != 0 OR STM.FNTmhID IS NULL) AND STM.FNEvnID = '$nEventId' AND STM.FNLocID = '$nLocId'
				";
        if ($tFTTmhName != '') {
            $tSQL .= " AND HDL.FTTmhName LIKE '%$tFTTmhName%'";
        }
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FStMTLTTimeTableSTCount($tFTTmhName, $nEventId, $nLocId) {
        $tSQL = "SELECT COUNT(STM.FNTmhID) AS counts
				 FROM TTKTShowTime AS STM
				 LEFT JOIN TTKMTimeTableHD_L AS HDL ON HDL.FNTmhID = STM.FNTmhID AND HDL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 WHERE (STM.FNTmhID != 0 OR STM.FNTmhID IS NULL) AND STM.FNEvnID = '$nEventId' AND STM.FNLocID = '$nLocId'";
        if ($tFTTmhName != '') {
            $tSQL .= " AND HDL.FTTmhName LIKE '%$tFTTmhName%'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMTLTTimeTableSTDel($aData) {
        $tSQL = "
    			SELECT COUNT(FNTmhID) AS counts
				FROM TTKTShowTime
				WHERE FNLocID = '" . $aData ['FNLocID'] . "' AND FNEvnID = '" . $aData ['FNEvnID'] . "'
    			";
        $oQuery = $this->db->query($tSQL);
        $oResult = $oQuery->result();
        if ($oResult [0]->counts == '1') {
            $this->db->where('FNEvnID', $aData ['FNEvnID']);
            $this->db->where('FNLocID', $aData ['FNLocID']);
            $this->db->where('FNTmhID', $aData ['FNTmhID']);
            $this->db->update('TTKTShowTime', array(
                'FNTmhID' => '',
                'FDShwEndDate' => NULL
            ));
        } else {
//            $this->db->where('FNEvnID', $aData ['FNEvnID']);
//            $this->db->where('FNLocID', $aData ['FNLocID']);
//            $this->db->where('FNTmhID', $aData ['FNTmhID']);
//            $this->db->where('FDShwStartDate', $aData ['FDShwStartDate'] . ' 00:00:00.000');
//            if ($aData ['FDShwEndDate'] != '') {
//                $this->db->where('FDShwEndDate', $aData ['FDShwEndDate'] . ' 00:00:00.000');
//            } else {
//                $this->db->where('FDShwEndDate', NULL);
//            }
//            $this->db->delete('TTKTShowTime');
            $tSQL = "   DELETE FROM TTKTShowTime WHERE FNEvnID = '" . $aData ['FNEvnID'] . "' 
                        AND FNLocID = '" . $aData ['FNLocID'] . "' 
                        AND FNTmhID = '" . $aData ['FNTmhID'] . "'
                        AND FDShwStartDate = '" . $aData ['FDShwStartDate'] . " 00:00:00.000'
    			";

            if ($aData ['FDShwEndDate'] == '1970-01-01') {
                $tSQL .= "   AND FDShwEndDate IS NULL";
            } else {
                if ($aData ['FDShwEndDate'] != '') {
                    $tSQL .= "   AND FDShwEndDate = '" . $aData ['FDShwEndDate'] . " 00:00:00.000'";
                }
            }
            $oQuery = $this->db->query($tSQL);
        }
    }

    public function FSxMTLTSTViewShowTime($nEventId, $nLocId, $nTmhID) {
        $tSQL = "SELECT *
		FROM TTKTShowTime
		WHERE FNEvnID = '$nEventId' AND FNLocID = '$nLocId' AND FNTmhID = '$nTmhID'
		";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?>
