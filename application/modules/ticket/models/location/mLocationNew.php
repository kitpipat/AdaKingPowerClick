<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mLocationNew extends CI_Model {

    private $ZneID;

    private function FCNaMLOCCallLenData($pnPerPage, $pnPage) {
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


    //TCNMImgObj.FTImgType ,
    public function FSaMLOCList($tFTLocName, $tParkId, $nPageNo = 1) {
        $aRowLen = $this->FCNaMLOCCallLenData(2, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSqlLocName = '';
        if ($tFTLocName != '') {
            $tSqlLocName = " AND TTKMLocation_L.FTLocName LIKE '%$tFTLocName%'";
        }
        $tSQL = "SELECT c.*  
                    FROM( SELECT ROW_NUMBER() OVER(ORDER BY TTKMLocation.FNLocID DESC) AS RowID, 
                    TTKMLocation.*, 
                    TTKMLocation_L.FTLocName, 
                    TCNMImgObj.FTImgObj, 
                    TCNMImgObj.FNImgID, 
                    TCNMImgObj.FTImgTable ,
                    REPLACE(REPLACE(P.FNPvnName , '<FTPvnName>',''),'</FTPvnName>','') AS FNPvnName2  
                    FROM TTKMLocation LEFT JOIN TTKMLocation_L ON TTKMLocation.FNLocID = TTKMLocation_L.FNLocID AND TTKMLocation_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "' 
                                LEFT JOIN TCNMImgObj ON TCNMImgObj.FTImgRefID = CONVERT(VARCHAR(5),TTKMLocation.FNLocID) AND TCNMImgObj.FTImgTable = 'TTKMLocation' AND FTImgKey = 'main'
                   
							    LEFT JOIN(
								SELECT FNLocID ,  FNPvnName = STUFF(
								(SELECT  CAST(PVL.FTPvnName AS nvarchar(100)) + ' - '+ CAST(DTSL.FTDstName AS nvarchar(100))+ ', ' as FTPvnName
										
								FROM TTKMLocProvince PVN
								INNER JOIN TCNMProvince_L PVL
								ON (PVL.FTPvnCode = PVN.FNPvnID AND PVL.FNLngID = '" . $this->session->userdata("tLangEdit") . "')
								INNER JOIN TCNMDistrict DTS ON DTS.FTDstCode = PVN.FNDstID
								INNER JOIN TCNMDistrict_L DTSL ON  (DTS.FTDstCode = DTSL.FTDstCode AND  DTSL.FNLngID = '" . $this->session->userdata("tLangEdit") . "')
								WHERE PVN.FNLocID = t2.FNLocID
								FOR XML PATH ('')), 1, 1, '<')  FROM TTKMLocProvince t2
								GROUP BY FNLocID) P ON TTKMLocation.FNLocID = P.FNLocID
								WHERE TTKMLocation.FNPmoID = '" . $tParkId . "' $tSqlLocName ) AS c ";

        $tSQL .= "WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSaMLOCSearchCount($tFTLocName, $nParkId) {
        if ($tFTLocName != '') {
            $tFTLocName = " AND TTKMLocation_L.FTLocName LIKE '%$tFTLocName%'";
        } else {
            $tFTLocName = '';
        }
        $tSQL = "SELECT COUNT(TTKMLocation.FNLocID) AS counts 
				 FROM TTKMLocation 
				 LEFT JOIN TTKMLocation_L ON TTKMLocation_L.FNLocID = TTKMLocation.FNLocID AND TTKMLocation_L.FNLngID = '" . $this->session->userdata("tLangID") . "'
                 WHERE TTKMLocation.FNPmoID = '$nParkId' $tFTLocName ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSaMLocLocationCodeRef() {
        $tSQL = "SELECT FTLocCodeRef FROM TTKMLocation WHERE FTLocCodeRef IS NOT NULL ORDER BY FNLocID DESC";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMLocSaveLoc($aData) {
        // TTKMLocation
        $this->db->insert('TTKMLocation', array(
            'FNPmoID' => $aData ['FNPmoID'],
            'FNLocLimit' => $aData ['FNLocLimit'],
            'FTLocCodeRef' => $aData ['FTLocCodeRef'],
            'FTLocTimeOpening' => $aData ['FTLocTimeOpening'],
            'FTLocTimeClosing' => $aData ['FTLocTimeClosing'],
            'FTWhoIns' => $this->session->userdata("tSesUsername"),
            'FDDateIns' => date('Y-m-d h:i:s'),
            'FTTimeIns' => date('h:i:s')
        ));
        $LocID = $this->LocID = $this->db->insert_id();
        // TTKMLocation_L
        $this->db->insert('TTKMLocation_L', array(
            'FNLocID' => $LocID ,
            'FTLocName' => $aData ['FTLocName'],
            'FNLngID' => $this->session->userdata("tLangEdit")
        ));
        // ZONE
        $this->db->insert('TTKMLocZone', array(
            'FNLocID' => $LocID,
            'FTZneBookingType' => '3',
            'FTWhoIns' => $this->session->userdata("tSesUsername"),
            'FDDateIns' => date('Y-m-d h:i:s'),
            'FTTimeIns' => date('h:i:s')
        ));
        $this->nZneID = $this->db->insert_id();
        $this->db->insert('TTKMLocZone_L', array(
            'FNZneID' => $this->nZneID,
            'FNLngID' => $this->session->userdata("tLangEdit"),
            'FTZneName' => $aData ['FTLocName']
        ));
        return $LocID;
    }

    // เพิ่ม Province ตอนเพิ่ม สถานที่
    public function FSxMLocAddAre($aData) {
        $this->db->insert('TTKMLocProvince', array(
            'FNLocID' => $this->LocID,
            'FNAreID' => $aData ['FTAreCode'],
            'FNPvnID' => $aData ['FTPvnCode'],
            'FNDstID' => $aData ['FTDstCode']
        ));
    }

    // เพิ่ม Province ตอนแก้ไข สถานที่
    public function FSxMLocAddAre2($aData) {
        $this->db->insert('TTKMLocProvince', array(
            'FNLocID' => $aData ['FNLocID'],
            'FNAreID' => $aData ['FTAreCode'],
            'FNPvnID' => $aData ['FTPvnCode'],
            'FNDstID' => $aData ['FTDstCode']
        ));
    }

    public function FSxMLocEditLoc($aData) {
        // TTKMLocation
        $this->db->where('FNLocID', $aData ['FNLocID']);
        $this->db->update('TTKMLocation', array(
            'FNLocLimit' => $aData ['FNLocLimit'],
            'FTLocTimeOpening' => $aData ['FTLocTimeOpening'],
            'FTLocTimeClosing' => $aData ['FTLocTimeClosing'],
            'FTWhoUpd' => $this->session->userdata("tSesUsername"),
            'FDDateUpd' => date('Y-m-d h:i:s'),
            'FTTimeUpd' => date('h:i:s')
        ));
        $nChk = FSnCheckUpdateLang('TTKMLocation_L', 'FNLocID', $aData ['FNLocID']);
        if ($nChk [0]->counts == 0) {
            $this->db->insert('TTKMLocation_L', array(
                'FNLocID' => $aData ['FNLocID'],
                'FTLocName' => $aData ['FTLocName'],
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        } else {
            // TTKMLocation_L
            $this->db->where('FNLocID', $aData ['FNLocID']);
            $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
            $this->db->update('TTKMLocation_L', array(
                'FTLocName' => $aData ['FTLocName']
            ));
        }
    }

    public function FSxMLocEditLocImg($aData) {
        $oImg = FSnCheckImg('TTKMImgObj', 'FTImgRefID', $aData ['FNLocID'], '2');
        if ($oImg [0]->counts == 0) {
            $this->db->insert('TTKMImgObj', array(
                'FTImgRefID' => $aData ['FNLocID'],
                'FTImgObj' => $aData ['FTImgObj'],
                'FTImgType' => '2',
                'FNImgSeq' => 1
            ));
        } else {
            $this->db->where('FTImgRefID', $aData ['FNLocID']);
            $this->db->where('FTImgType', '2');
            $this->db->where('FNImgSeq', '1');
            $this->db->update('TTKMImgObj', array(
                'FTImgObj' => $aData ['FTImgObj']
            ));
        }
    }

    public function FSxMLocDelLoc($tIdLoc) {
        $tSQL = "SELECT COUNT(ST.FNLocID) AS count1, COUNT(ZNE.FNZneID) AS count2
				 FROM TTKMLocation AS LOC			
				 LEFT JOIN TTKTShowTime AS ST ON LOC.FNLocID = ST.FNLocID	
				 LEFT JOIN TTKMLocZone AS ZNE ON ZNE.FNLocID = ST.FNLocID	
				 WHERE LOC.FNLocID = '$tIdLoc'
		";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count1 >= 1 || $oResult [0]->count2 >= 1) {
            return 1;
        } else {
            $this->db->where('FNLocID', $tIdLoc);
            $this->db->delete('TTKMLocation');

            $this->db->where('FNLocID', $tIdLoc);
            $this->db->delete('TTKMLocation_L');

            $this->db->where('FTImgRefID', $tIdLoc);
            $this->db->where('FTImgType', '2');
            $this->db->delete('TTKMImgObj');

            $this->db->where('FNLocID', $tIdLoc);
            $this->db->delete('TTKMLocProvince');

            // Del Level
            $tSQL1 = "DELETE FROM TTKMLocLevel_L WHERE FNLevID IN(
			SELECT DISTINCT FNLevID FROM TTKMLocLevel WHERE FNLocID = '$tIdLoc'
			)";
            $this->db->query($tSQL1);
            $this->db->where('FNLocID', $tIdLoc);
            $this->db->delete('TTKMLocLevel');

            // Del Zone
            $tSQL2 = "DELETE FROM TTKMLocZone_L WHERE FNZneID IN(
			SELECT DISTINCT FNZneID FROM TTKMLocZone WHERE FNLocID = '$tIdLoc'
			)";
            $this->db->query($tSQL2);
            $this->db->where('FNLocID', $tIdLoc);
            $this->db->delete('TTKMLocZone');

            // Del Gate
            $tSQL3 = "DELETE FROM TTKMLocGate_L WHERE FNGteID IN(
			SELECT DISTINCT GTE.FNGteID
			FROM TTKMLocZone AS ZNE
			INNER JOIN TTKMLocGate AS GTE ON GTE.FNZneID = ZNE.FNZneID
			WHERE ZNE.FNLocID = '$tIdLoc'
			)";
            $this->db->query($tSQL3);
            $tSQL4 = "DELETE FROM TTKMLocGate WHERE FNZneID IN(
			SELECT DISTINCT FNZneID FROM TTKMLocZone WHERE FNLocID = '$tIdLoc'
			)";
            $this->db->query($tSQL4);

            // Del Room
            $tSQL5 = "DELETE FROM TTKMLocRoom_L WHERE FNRomID IN(
			SELECT DISTINCT FNRomID FROM TTKMLocRoom WHERE FNLocID = '$tIdLoc'
			)";
            $this->db->query($tSQL5);
            $this->db->where('FNLocID', $tIdLoc);
            $this->db->delete('TTKMLocRoom');

            // Day Off Location
            $tSQL6 = "DELETE FROM TTKMLocDayOff_L WHERE FNLdoID IN(
			SELECT DISTINCT FNLdoID FROM TTKMLocDayOff WHERE FNLocID = '$tIdLoc'
			)";
            $this->db->query($tSQL6);
            $this->db->where('FNLocID', $tIdLoc);
            $this->db->delete('TTKMLocDayOff');

            return 0;
        }
    }

    public function FSxMLOCDelAre($tID) {
        $this->db->where('FNLpvID', $tID);
        $this->db->delete('TTKMLocProvince');
    }

    public function FSxMLOCLoadZoneSlc($tID) {
        $this->db->select('Zone.*, ZoneL.*');
        $this->db->from('TTKMLocZone AS Zone');
        $this->db->join('TTKMLocZone_L AS ZoneL', 'ZoneL.FNZneID = Zone.FNZneID', 'LEFT');
        $this->db->where('FNLocID', $tID);
        $this->db->where('ZoneL.FNLngID', $this->session->userdata("tLangEdit"));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMLOCLoadArea($nId) {
        $tSQL = "SELECT TTKMLocProvince.*, TCNMProvince_L.FTPvnName, TCNMArea_L.FTAreName, TCNMDistrict_L.FTDstName
				 FROM TTKMLocProvince 				 
				 LEFT JOIN TCNMProvince_L ON TCNMProvince_L.FTPvnCode = TTKMLocProvince.FNPvnID AND TCNMProvince_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 LEFT JOIN TCNMArea_L ON TCNMArea_L.FTAreCode = TTKMLocProvince.FNAreID AND TCNMArea_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'	 
				 LEFT JOIN TCNMDistrict_L ON TCNMDistrict_L.FTDstCode = TTKMLocProvince.FNDstID AND TCNMDistrict_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'			 
                 WHERE TTKMLocProvince.FNLocID = $nId";
    
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMLOCDelImg($aData) {
        $this->db->where('FNImgID', $aData ['FNImgID']);
        $this->db->delete('TTKMImgObj');
    }

    public function FSxMLOCDelImgPrk($aData) {
        $this->db->where('FTImgRefID', $aData ['FNPmoID']);
        $this->db->where('FTImgType', '1');
        $this->db->delete('TTKMImgPdt');
    }

    public function FSxMLOCCheck($tData) {
        $tSQL = "
    			SELECT COUNT(TTKMLocation.FNLocID) AS counts
				FROM TTKMLocation
				LEFT JOIN TTKMLocation_L ON TTKMLocation_L.FNLocID = TTKMLocation.FNLocID
				AND TTKMLocation_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				WHERE TTKMLocation.FNPmoID = '" . $tData ['FNPmoID'] . "' AND TTKMLocation_L.FTLocName = '" . $tData ['FTLocName'] . "'
    			";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMLocPrkDetail($nPmoID) {
        $tSQL = "SELECT TOP 1 TTKMLocation.FNPmoID, TTKMLocation.FNLocLimit, TTKMLocation.FTLocTimeOpening, TTKMLocation.FTLocTimeClosing, TTKMLocation_L.*,TTKMLocProvince.FNLpvID, TTKMLocProvince.FNAreID, TTKMLocProvince.FNPvnID, TTKMLocProvince.FNDstID, TCNMProvince_L.FTPvnName, TCNMDistrict_L.FTDstName, TCNMArea_L.FTAreName
				 FROM TTKMLocation
    			 LEFT JOIN TTKMLocation_L ON TTKMLocation_L.FNLocID = TTKMLocation.FNLocID AND TTKMLocation_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
    			 LEFT JOIN TTKMLocProvince ON TTKMLocProvince.FNLocID = TTKMLocation_L.FNLocID
    			 LEFT JOIN TCNMProvince_L ON TCNMProvince_L.FTPvnCode = TTKMLocProvince.FNPvnID AND TCNMProvince_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
    			 LEFT JOIN TCNMDistrict_L ON TCNMDistrict_L.FTDstCode = TTKMLocProvince.FNDstID AND TCNMDistrict_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
    			 LEFT JOIN TCNMArea_L ON TCNMArea_L.FTAreCode = TTKMLocProvince.FNAreID AND TCNMArea_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 WHERE TTKMLocation.FNPmoID ='$nPmoID' ORDER BY TTKMLocation.FNLocID DESC";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMLocPrkDetailArea($nPmoID) {
        $tSQL = "SELECT DISTINCT TCNMProvince_L.FTPvnName, TCNMDistrict_L.FTDstName
				 FROM TTKMLocation
    			 LEFT JOIN TTKMLocProvince ON TTKMLocProvince.FNLocID = TTKMLocation.FNLocID
    			 LEFT JOIN TCNMProvince_L ON TCNMProvince_L.FTPvnCode = TTKMLocProvince.FNPvnID AND TCNMProvince_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
    			 LEFT JOIN TCNMDistrict_L ON TCNMDistrict_L.FTDstCode = TTKMLocProvince.FNDstID AND TCNMDistrict_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
    			 WHERE TTKMLocation.FNPmoID ='$nPmoID'";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMLocArea() {
        $tSQL = "SELECT TCNMArea.*, TCNMArea_L.*
		FROM TCNMArea
		LEFT JOIN TCNMArea_L ON TCNMArea_L.FTAreCode = TCNMArea.FTAreCode
		AND TCNMArea_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMLocProvince() {
        $tSQL = "SELECT TCNMProvince.*, TCNMProvince_L.*
				 FROM TCNMProvince
				 LEFT JOIN TCNMProvince_L ON TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode
				 AND TCNMProvince_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'	
		";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMLocDistrict() {
        $tSQL = "SELECT TCNMDistrict.*, TCNMDistrict_L.FTDstName
				 FROM TCNMDistrict
				 LEFT JOIN TCNMDistrict_L ON TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode
				 AND TCNMDistrict_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 WHERE FTPvnCode = '001'";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSxMLocModel() {
        $this->db->select('BCH.*,BCH.FTBchCode AS FNPmoID, BCHL.*,BCHL.FTBchName AS FTPmoName');
        $this->db->from('TCNMBranch AS BCH');
        $this->db->join('TCNMBranch_L AS BCHL', 'BCHL.FTBchCode = BCH.FTBchCode', 'LEFT');
        $this->db->where('BCHL.FNLngID', $this->session->userdata("tLangEdit"));
        $oQuery = $this->db->get();
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }


    //Functionality : Get Img Model
    //Parameters : Id Branch
    //Creator : P'Nut
    //Last Modified : 03/01/2019 Krit(Copter) ปรับไป Select ตาราง Branch
    //Return : Array
    //Return Type : array
    public function FSxMLocModelImg($nID) {
        $tSQL = "SELECT BCH.*,BCH.FTBchCode AS FNPmoID , BCHL.FTBchName AS FTPmoName, IMGO.FTImgObj
		FROM TCNMBranch BCH	
		LEFT JOIN TCNMBranch_L AS BCHL ON BCHL.FTBchCode = BCH.FTBchCode AND BCHL.FNLngID =  '" . $this->session->userdata("tLangEdit") . "'	
        LEFT JOIN TCNMImgObj IMGO ON BCH.FTBchCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TCNMBranch'
		WHERE BCH.FTBchCode = '$nID'";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function FSxMLocShowEdit($nID) {
        $tSQL = "SELECT LOC.*, LOCL.FTLocName, Img.FTImgObj, Img.FNImgID   
		FROM TTKMLocation AS LOC
		LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = LOC.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
    	LEFT JOIN TCNMImgObj AS Img ON Img.FTImgRefID = LOC.FNLocID AND Img.FTImgTable = 'TTKMLocation'
    	WHERE LOC.FNLocID = '$nID'";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?>
