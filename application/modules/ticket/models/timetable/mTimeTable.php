<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mTimetable extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private function FCNaMTTBCallLenData($pnPerPage, $pnPage) {
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

    public function FSxMTTBAuthen($nGadRefID) {
        $tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '$nGadRefID' AND FNGahID = '" . $this->session->userdata("FNGahID") . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMTTBAjaxList($tFTTmhName, $nPageNo = 1) {
        $aRowLen = $this->FCNaMTTBCallLenData(8, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQL = "SELECT c.* FROM(
				 SELECT ROW_NUMBER() OVER(ORDER BY HD.FNTmhID DESC) AS RowID,
						HD.*,
	        			HDL.FTTmhName	
				FROM TTKMTimeTableHD AS HD
        		LEFT JOIN TTKMTimeTableHD_L AS HDL ON HDL.FNTmhID = HD.FNTmhID AND HDL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        		";
        if ($tFTTmhName != '') {
            $tSQL .= " WHERE HDL.FTTmhName LIKE '%$tFTTmhName%'";
        }
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMTTBDT($nFNTmhID) {
        $tSQL = "SELECT *
				 FROM TTKMTimeTableDT
				 WHERE FNTmhID = '$nFNTmhID'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FStMTTBCount($tFTTmhName) {
        $tSQL = "SELECT COUNT(HD.FNTmhID) AS counts
				 FROM TTKMTimeTableHD AS HD
        		 LEFT JOIN TTKMTimeTableHD_L AS HDL ON HDL.FNTmhID = HD.FNTmhID AND HDL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        		";
        if ($tFTTmhName != '') {
            $tSQL .= " WHERE HDL.FTTmhName LIKE '%$tFTTmhName%'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMTTBDelete($nFNTmhID) {
        $tSQL = "SELECT COUNT(TME.FNTmhID) AS count1, COUNT(DOW.FNTmhID) AS count2, COUNT(HLD.FNTmhID) AS count3
				 FROM TTKMTimeTableHD AS HD
				 LEFT JOIN TTKTShowTime AS TME ON HD.FNTmhID = TME.FNTmhID		
				 LEFT JOIN TTKTShowTimeDOW AS DOW ON HD.FNTmhID = DOW.FNTmhID
				 LEFT JOIN TTKTShowTimeHoliday AS HLD ON HD.FNTmhID = HLD.FNTmhID
				 WHERE HD.FNTmhID = '$nFNTmhID'
		";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count1 >= 1 || $oResult [0]->count2 >= 1 || $oResult [0]->count3 >= 1) {
            return 1;
        } else {
            $this->db->where('FNTmhID', $nFNTmhID);
            $this->db->delete('TTKMTimeTableHD');
            $this->db->where('FNTmhID', $nFNTmhID);
            $this->db->delete('TTKMTimeTableHD_L');
            $tSQL = "DELETE FROM TTKMTimeTableDT_L WHERE FNTmdID IN(
						SELECT DISTINCT FNTmdID FROM TTKMTimeTableDT WHERE FNTmhID = '$nFNTmhID'
					 )";
            $this->db->query($tSQL);
            $this->db->where('FNTmhID', $nFNTmhID);
            $this->db->delete('TTKMTimeTableDT');
            return 0;
        }
    }

    /**
     * *******
     */
    public function FSxMTTBAddAjax($aData) {
        $this->db->insert('TTKMTimeTableHD', array(
            'FTTmhStaActive' => $aData ['FTTmhStaActive'],
            'FTWhoUpd' => $this->session->userdata("tSesUsername"),
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s')
        ));
        $nFNTmhID = $this->db->insert_id();
        $this->db->insert('TTKMTimeTableHD_L', array(
            'FNTmhID' => $nFNTmhID,
            'FTTmhName' => $aData ['FTTmhName'],
            'FTTmhRmk' => $aData ['FTTmhRmk'],
            'FNLngID' => $this->session->userdata("tLangEdit")
        ));
        return $nFNTmhID;
    }

    public function FSxMTTBEditAjax($aData) {
        $nChk = FSnCheckUpdateLang('TTKMTimeTableHD_L', 'FNTmhID', $aData ['FNTmhID']);
        $this->db->where('FNTmhID', $aData ['FNTmhID']);
        $this->db->update('TTKMTimeTableHD', array(
            'FTTmhStaActive' => $aData ['FTTmhStaActive'],
            'FTWhoUpd' => $this->session->userdata("tSesUsername"),
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s')
        ));
        if ($nChk [0]->counts == 0) {
            $this->db->insert('TTKMTimeTableHD_L', array(
                'FNTmhID' => $aData ['FNTmhID'],
                'FTTmhName' => $aData ['FTTmhName'],
                'FTTmhRmk' => $aData ['FTTmhRmk'],
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        } else {
            $this->db->where('FNTmhID', $aData ['FNTmhID']);
            $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
            $this->db->update('TTKMTimeTableHD_L', array(
                'FTTmhName' => $aData ['FTTmhName'],
                'FTTmhRmk' => $aData ['FTTmhRmk'],
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        }
    }

    public function FSxMTTBEdit($nFNTmhID) {
        $tSQL = "SELECT HD.*, HDL.FTTmhName, HDL.FTTmhRmk
				 FROM TTKMTimeTableHD AS HD 
        		 LEFT JOIN TTKMTimeTableHD_L AS HDL ON HDL.FNTmhID = HD.FNTmhID AND HDL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 WHERE HD.FNTmhID = '$nFNTmhID'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // รอบการแสดง
    public function FSxMTTBDtAjaxList($tFTTmdName, $nFNTmhID, $nPageNo = 1) {
        $aRowLen = $this->FCNaMTTBCallLenData(8, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQL = "SELECT c.* FROM(
				 SELECT ROW_NUMBER() OVER(ORDER BY DT.FNTmdID DESC) AS RowID,
						DT.*,
	        			DTL.FTTmdName
				FROM TTKMTimeTableDT AS DT
        		LEFT JOIN TTKMTimeTableDT_L AS DTL ON DTL.FNTmdID = DT.FNTmdID AND DTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        		WHERE DT.FNTmhID = '$nFNTmhID'";
        if ($tFTTmdName != '') {
            $tSQL .= "  AND DTL.FTTmdName LIKE '%$tFTTmdName%'";
        }
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FStMTTBDtCount($tFTTmdName, $nFNTmhID) {
        $tSQL = "SELECT COUNT(DT.FNTmdID) AS counts
				 FROM TTKMTimeTableDT AS DT
        		 LEFT JOIN TTKMTimeTableDT_L AS DTL ON DTL.FNTmdID = DT.FNTmdID AND DTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        		 WHERE DT.FNTmhID = '$nFNTmhID'
        		";
        if ($tFTTmdName != '') {
            $tSQL .= " AND DTL.FTTmdName LIKE '%$tFTTmdName%'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMTTBDtDelete($nFNTmdID) {
        $this->db->where('FNTmdID', $nFNTmdID);
        $this->db->delete('TTKMTimeTableDT');
        $this->db->where('FNTmdID', $nFNTmdID);
        $this->db->delete('TTKMTimeTableDT_L');
    }

    /**
     * *******
     */
    public function FSxMTTBDtAddAjax($aData) {
        $this->db->insert('TTKMTimeTableDT', array(
            'FNTmhID' => $aData ['FNTmhID'],
            'FTTmdStartTime' => $aData ['FTTmdStartTime'],
            'FTTmdEndTime' => $aData ['FTTmdEndTime'],
            'FTWhoUpd' => $this->session->userdata("tSesUsername"),
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s')
        ));
        $nFNTmdID = $this->db->insert_id();
        $this->db->insert('TTKMTimeTableDT_L', array(
            'FNTmdID' => $nFNTmdID,
            'FTTmdName' => $aData ['FTTmdName'],
            'FNLngID' => $this->session->userdata("tLangEdit")
        ));
        return $nFNTmdID;
    }

    public function FSxMTTBDtEditAjax($aData) {
        $nChk = FSnCheckUpdateLang('TTKMTimeTableDT_L', 'FNTmdID', $aData ['FNTmdID']);
        $this->db->where('FNTmdID', $aData ['FNTmdID']);
        $this->db->update('TTKMTimeTableDT', array(
            'FTTmdStartTime' => $aData ['FTTmdStartTime'],
            'FTTmdEndTime' => $aData ['FTTmdEndTime'],
            'FTWhoUpd' => $this->session->userdata("tSesUsername"),
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s')
        ));
        if ($nChk [0]->counts == 0) {
            $this->db->insert('TTKMTimeTableDT', array(
                'FNTmdID' => $aData ['FNTmdID'],
                'FTTmdName' => $aData ['FTTmdName'],
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        } else {
            $this->db->where('FNTmdID', $aData ['FNTmdID']);
            $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
            $this->db->update('TTKMTimeTableDT_L', array(
                'FTTmdName' => $aData ['FTTmdName']
            ));
        }
    }

    public function FSxMTTBDtEdit($nFNTmdID) {
        $tSQL = "SELECT DT.*, DTL.FTTmdName
				 FROM TTKMTimeTableDT AS DT
        		 LEFT JOIN TTKMTimeTableDT_L AS DTL ON DTL.FNTmdID = DT.FNTmdID AND DTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
	        	 WHERE DT.FNTmdID = '$nFNTmdID'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMTTBDtCheckTime($aData) {
        $tSQL = "SELECT B.FNTmdID FROM (
                SELECT * FROM TTKMTimeTableDT
                WHERE DATEPART(HH, FTTmdStartTime) = '".date('H', strtotime($aData['FTTmdStartTime']))."' OR DATEPART(HH, FTTmdEndTime) = '".date('H', strtotime($aData['FTTmdEndTime']))."' 
                OR DATEPART(HH, FTTmdEndTime) = '".date('H', strtotime($aData['FTTmdEndTime']))."' OR DATEPART(HH, FTTmdStartTime) = '".date('H', strtotime($aData['FTTmdStartTime']))."' 
                AND FNTmhID = '" . $aData ['FNTmhID'] . "' ) A
                RIGHT JOIN(
                select FNTmdID  from TTKMTimeTableDT where CONVERT( TIME, FTTmdEndTime ) >= '".date('H:i', strtotime($aData['FTTmdEndTime']))."' and FNTmhID = '" . $aData ['FNTmhID'] . "') B
                ON A.FNTmdID = B.FNTmdID
                ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

}
