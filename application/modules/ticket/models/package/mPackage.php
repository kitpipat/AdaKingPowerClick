<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mPackage extends CI_Model {

    public function FSnMPKGAddPkgSpcPriHLD($aData) {
        $oCheckHave = $this->FSxMPKGCheckHavePkgSpcPriHLD($aData ['FNPpkID'], $aData ['FDPphCheckIn']);
        $nHLDHave = $oCheckHave [0]->counts;

        if ($nHLDHave == 0) {
            $this->db->insert('TTKMPkgPriHoliday', $aData);

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            Return 500;
        }
    }

    public function FSxMPKGCheckHavePkgSpcPriHLD($nPpkID, $dPphCheckIn) {
        $tSQL = "SELECT COUNT (FNPpkID) AS counts
		FROM TTKMPkgPriHoliday
		WHERE FNPpkID  = '$nPpkID'
		AND FDPphCheckIn = '$dPphCheckIn'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGDelPkgSpcPriHLD($nPpkID, $dPphCheckIn) {
        $this->db->where('FNPpkID', $nPpkID);
        $this->db->where('FDPphCheckIn', $dPphCheckIn);
        $this->db->delete('TTKMPkgPriHoliday');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSoMPKGGetPkgFullCalendar($nPpkID) {
        $tSQL = "SELECT FNPpkID ,
                        FDPphCheckIn,
                        FNPphSign,
                        FTPphAdjType,
                        CONVERT(DECIMAL(20,2),FCPphValue) AS FCPphValue,
                        FCPphPrice
                        FROM TTKMPkgPriHoliday
                        WHERE FNPpkID = '$nPpkID'";

        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetPkgFullCalendarList($nPpkID, $dPphCheckIn) {
        $tSQL = "SELECT FNPpkID,
                CONVERT(varchar(10),FDPphCheckIn,121) AS FDPphCheckIn,
                FNPphSign,
                FTPphAdjType,
                CONVERT(DECIMAL(20,2),FCPphValue) AS FCPphValue,
                FCPphPrice
                FROM TTKMPkgPriHoliday
                WHERE FNPpkID = '$nPpkID'
                AND FDPphCheckIn = '$dPphCheckIn'";

        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGAddGrpSpcPriHLD($aData) {
        $oCheckHave = $this->FSxMPKGCheckHaveGrpSpcPriHLD($aData ['FNPgpGrpID'], $aData ['FDGphCheckIn']);
        $nHLDHave = $oCheckHave [0]->counts;

        if ($nHLDHave == 0) {
            $this->db->insert('TTKMGrpPriHoliday', $aData);

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            Return 500;
        }
    }

    public function FSxMPKGCheckHaveGrpSpcPriHLD($nPgpGrpID, $dGphCheckIn) {
        $tSQL = "SELECT COUNT (FNPgpGrpID) AS counts
                FROM TTKMGrpPriHoliday
                WHERE FNPgpGrpID  = '$nPgpGrpID'
                AND FDGphCheckIn = '$dGphCheckIn'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGAddPdtSpcPriHLD($aData) {
        $oCheckHave = $this->FSxMPKGCheckHavePdtSpcPriHLD($aData ['FNPkgPdtID'], $aData ['FDPphCheckIn']);
        $nHLDHave = $oCheckHave [0]->counts;

        if ($nHLDHave == 0) {
            $this->db->insert('TTKMPdtPriHoliday', $aData);

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            Return 500;
        }
    }

    public function FSnMPKGDelGrpSpcPriHLD($nPgpGrpID, $dGphCheckIn) {
        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->where('FDGphCheckIn', $dGphCheckIn);
        $this->db->delete('TTKMGrpPriHoliday');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSnMPKGDelPdtSpcPriHLD($nPkgPdtID, $dPphCheckIn) {
        $this->db->where('FNPkgPdtID', $nPkgPdtID);
        $this->db->where('FDPphCheckIn', $dPphCheckIn);
        $this->db->delete('TTKMPdtPriHoliday');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGCheckHavePdtSpcPriHLD($nPkgPdtID, $dPphCheckIn) {
        $tSQL = "SELECT COUNT (FNPkgPdtID) AS counts
                FROM TTKMPdtPriHoliday
                WHERE FNPkgPdtID  = '$nPkgPdtID'
                AND FDPphCheckIn = '$dPphCheckIn'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetGrpFullCalendar($nPgpGrpID) {
        $tSQL = "SELECT FNPgpGrpID,
                FDGphCheckIn,
                FNGphSign,
                FTGphAdjType,
                CONVERT(DECIMAL(20,2),FCGphValue) AS FCGphValue,
                FCGphPrice
                FROM TTKMGrpPriHoliday
                WHERE FNPgpGrpID = '$nPgpGrpID'";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetGrpFullCalendarList($nPgpGrpID, $dGphCheckIn) {
        $tSQL = "SELECT FNPgpGrpID,
				CONVERT(varchar(10),FDGphCheckIn,121) AS FDGphCheckIn,
				FNGphSign,
				FTGphAdjType,
				CONVERT(DECIMAL(20,2),FCGphValue) AS FCGphValue,
				FCGphPrice
				FROM TTKMGrpPriHoliday
				WHERE FNPgpGrpID = '$nPgpGrpID'
				AND FDGphCheckIn = '$dGphCheckIn' ";

        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetPdtFullCalendar($nPkgPdtID) {
        $tSQL = "SELECT FNPkgPdtID,
						FDPphCheckIn,
						FNPphSign,
						FTPphAdjType,
						CONVERT(DECIMAL(20,2),FCPphValue) AS FCPphValue,
						FCPphPrice
				FROM TTKMPdtPriHoliday
				WHERE FNPkgPdtID = '$nPkgPdtID' ";
        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetPdtFullCalendarList($nPkgPdtID, $dPphCheckIn) {
        $tSQL = "SELECT FNPkgPdtID,
				 CONVERT(varchar(10),FDPphCheckIn,121) AS FDPphCheckIn,
			 	 FNPphSign,
		 		 FTPphAdjType,
				 CONVERT(DECIMAL(20,2),FCPphValue) AS FCPphValue,
				 FCPphPrice
				 FROM TTKMPdtPriHoliday
				 WHERE FNPkgPdtID = '$nPkgPdtID'
				 AND FDPphCheckIn = '$dPphCheckIn' ";

        $query = $this->db->query($tSQL);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGCallPagePkgPriByDOWPanal($nPpkID) {
        $oCheckHave = $this->FSxMPKGCheckHavePkgPriByDOWPanal($nPpkID);
        $nDOWHave = $oCheckHave [0]->counts;

        if ($nDOWHave == 0) {

            for ($i = 0; $i < 7; $i ++) {

                $this->db->insert('TTKMPkgPriDOW', array(
                    'FNPpkID' => $nPpkID,
                    'FNPpdDayOfWeek' => $i,
                    'FCPpdPrice' => '0',
                    'FDDateUpd' => date('Y-m-d'),
                    'FTTimeUpd' => date('h:i:s'),
                    'FTWhoUpd' => $this->session->userdata("tSesUsername")
                ));
            }

            $tSQL = "SELECT FNPpkID,FNPpdDayOfWeek
						   ,CONVERT(DECIMAL(20,2),FCPpdPrice) AS FCPpdPrice
					 FROM TTKMPkgPriDOW
					 WHERE FNPpkID = '$nPpkID'";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } else {

            $tSQL = "SELECT FNPpkID,FNPpdDayOfWeek
					 ,CONVERT(DECIMAL(20,2),FCPpdPrice) AS FCPpdPrice
					 FROM TTKMPkgPriDOW
					 WHERE FNPpkID = '$nPpkID'";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        }
    }

    public function FSxMPKGClearModelCustomer($tPkgID, $nPkgType, $nPkgTypeOld) {
        if ($nPkgType == 1) {
            if ($nPkgType != $nPkgTypeOld) {
//                $this->db->where('FNPkgID', $tPkgID);
//                $this->db->delete('TTKTPkgPdtPri');
            }

            $this->db->where('FNPkgID', $tPkgID);
            $this->db->where('FCPpkPrice IS NOT NULL');
            $this->db->where('FTPpkType', 1);
            $this->db->delete('TTKTPkgPark');

            return 1;
        } else if ($nPkgType == 2) {
            if ($nPkgType != $nPkgTypeOld) {
//                $this->db->where('FNPkgID', $tPkgID);
//                $this->db->delete('TTKTPkgPdtPri');
            }

            $this->db->where('FNPkgID', $tPkgID);
            $this->db->where('FCPpkPrice IS NULL');
            $this->db->where('FTPpkType', 1);
            $this->db->delete('TTKTPkgPark');
            return 1;
        }
    }

    public function FSxMPKGClearDataOfPpkIDAllTable($nPpkID) {
        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKMPkgPriBooking');

        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKMPkgPriDOW');

        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKMPkgPriHoliday');

        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKTPkgGrpPri');

        return 1;
    }

    public function FSxMPKGGetPpkID($nPkgID) {
        $tSQL = "SELECT FNPpkID 
				 FROM TTKTPkgPark
				 WHERE FNPkgID = '$nPkgID'
				 AND FTPpkType = 1";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckHavePkgPriByDOWPanal($nPkgID) {
        $tSQL = "SELECT COUNT (FNPpkID) AS counts
				 FROM TTKMPkgPriDOW
				 WHERE FNPpkID = '$nPkgID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGAddLocShowTime($aData, $dDateNow) {
        $oCheckHave = $this->FSxMPKGCheckHaveLocShowTime($aData ['FNEvnID'], $aData ['FNLocID'], $aData ['FNTmhID']);
        $nShwTimeHave = $oCheckHave [0]->counts;

        // ถ้าไม่มี ให้ Insert
        if ($nShwTimeHave == 0) {

            $this->db->insert('TTKTShowTime', $aData);

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {

            $oChkDateBefAdd = $this->FSxMPKGCheckDateExpireBeforeAddLocShowTime($aData ['FNEvnID'], $aData ['FNLocID'], $aData ['FNTmhID'], $dDateNow);

            $nChkDateBefAddHave = $oChkDateBefAdd [0]->counts;

            // ถ้าเป็น 0 จะอยู่ในระหว่างใช้งานอยู่จะไม่สามารถแอดได้
            if ($nChkDateBefAddHave == 0) {
                return 500;
            } else {
                // ถ้่ไม่ใช่ 0 จะแอดได้
                // $this->db->insert('TTKTShowTime',$aData);
                // if($this->db->affected_rows() > 0) {
                // Return 1;
                // } else {
                // Return 0;
                // }

                $this->db->where('FNEvnID', $aData ['FNEvnID']);
                $this->db->where('FNLocID', $aData ['FNLocID']);
                $this->db->where('FNTmhID', $aData ['FNTmhID']);

                $tDB = $this->db->update('TTKTShowTime', $aData);

                if ($this->db->affected_rows() > 0) {
                    Return 1;
                } else {
                    Return 0;
                }
            }
        }
    }

    public function FSxMPKGCheckDateExpireBeforeAddLocShowTime($nEvnID, $nLocID, $nTmhID, $dDateNow) {
        $tSQL = "SELECT COUNT (FNLocID) AS counts FROM TTKTShowTime
				 WHERE FNEvnID  = '$nEvnID'
				 AND FNLocID = '$nLocID'
				 AND FNTmhID = '$nTmhID'
				 AND  CONVERT(varchar(10),FDShwEndDate,121) < '$dDateNow'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckHaveLocShowTime($nEvnID, $nLocID, $nTmhID) {
        $tSQL = "SELECT COUNT (FNLocID) AS counts 
				 FROM TTKTShowTime
				 WHERE FNEvnID  = '$nEvnID'
				 AND FNLocID = '$nLocID'
				 AND FNTmhID = '$nTmhID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckHaveLocShowTimeBeforeAddZone($nLocID, $nEvnID) {
        $tSQL = "SELECT COUNT (FNLocID) AS counts
				 FROM TTKTShowTime
				 WHERE FNEvnID  = '$nEvnID'
				 AND FNLocID = '$nLocID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGGetTimeMaxAndMinTimeTableDT($nTmhID) {
        $tSQL = "SELECT MIN (FTTmdStartTime) AS MinStartTime,MAX (FTTmdEndTime) AS MaxEndTime 
				 FROM TTKMTimeTableDT
				 WHERE FNTmhID = $nTmhID";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGGetDateEvnStartAndFinish($nEvnID) {
        $tSQL = "SELECT FNEvnID
				,CONVERT(varchar(10),FDEvnStart,121) AS FDEvnStart
				,CONVERT(varchar(10),FDEvnFinish,121) AS FDEvnFinish
				FROM  TTKMEvent
				WHERE FNEvnID = $nEvnID";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetZneBookingType($nZneID) {
        $tSQL = "SELECT FTZneBookingType FROM TTKMLocZone
				 WHERE FNZneID = '$nZneID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckPdtHaveStaPdtAdj1($nPkgID) {
        $tSQL = "SELECT COUNT (P.FNPdtOthSystem) AS counts
				 FROM TTKTPkgPdtPri PPP
				 INNER JOIN TCNMPdtTicket P ON P.FNPdtID = PPP.FNPdtID
				 WHERE FNPkgID = '$nPkgID'
				 AND P.FNPdtOthSystem = '1'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckPdtHaveStaPackage3($nPkgID) {
        $tSQL = "SELECT COUNT (P.FNPdtOthSystem) AS counts
				 FROM TTKTPkgPdtPri PPP
				 INNER JOIN TCNMPdtTicket P ON P.FNPdtID = PPP.FNPdtID
				 WHERE FNPkgID = '$nPkgID'
				 AND P.FNPdtOthSystem = '3'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckPdtHaveStaRoom4($nPkgID) {
        $tSQL = "SELECT COUNT (P.FNPdtOthSystem) AS counts
		FROM TTKTPkgPdtPri PPP
		INNER JOIN TCNMPdtTicket P ON P.FNPdtID = PPP.FNPdtID
		WHERE FNPkgID = '$nPkgID'
		AND P.FNPdtOthSystem = '4'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckPdtHaveStaSeat5($nPkgID) {
        $tSQL = "SELECT COUNT (P.FNPdtOthSystem) AS counts
				 FROM TTKTPkgPdtPri PPP
				 INNER JOIN TCNMPdtTicket P ON P.FNPdtID = PPP.FNPdtID
				 WHERE FNPkgID = '$nPkgID'
				 AND P.FNPdtOthSystem = '5'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGAddPkgPpbPriBKG($aData) {
        $oCheckHave = $this->FSxMPKGCheckHavePkgPpbPriBKG($aData ['FNPkgPdtID'], $aData ['FNPpbDayFrm'], $aData ['FNPpbDayTo']);
        $nBKGHave = $oCheckHave [0]->counts;

        if ($nBKGHave == 0) {
            $this->db->insert('TTKMPdtPriBooking', $aData);
            return 1;
        } else {
            return 0;
        }
    }

    public function FSxMPKGCheckHavePkgPpbPriBKG($nPkgPdtID, $nPpbDayFrm, $nPpbDayTo) {
        $tSQL = "SELECT COUNT (FNPkgPdtID) AS counts
				 FROM TTKMPdtPriBooking
				 WHERE FNPkgPdtID = '$nPkgPdtID'
				 AND FNPpbDayFrm = '$nPpbDayFrm'
				 AND FNPpbDayTo = '$nPpbDayTo'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetPdtPriSpcPriByBKG($nPkgPdtID) {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY FNPkgPdtID DESC) AS RowID
				,FNPkgPdtID
				,FNPpbDayFrm
				,FNPpbDayTo
				,FNPpbSign
				,FTPpbAdjType
				,CONVERT(DECIMAL(20,2),FCPpbValue) AS FCPpbValue
				,FCPpbPrice
				FROM TTKMPdtPriBooking
				WHERE FNPkgPdtID = '$nPkgPdtID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGDelPkgLocShowTime($nEvnID, $nLocID, $nTmhID) {
        $this->db->where('FNEvnID', $nEvnID);
        $this->db->where('FNLocID', $nLocID);
        $this->db->where('FNTmhID', $nTmhID);
        $this->db->delete('TTKTShowTime');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGDelPkgPriBKG($nPpkID, $nPpbDayFrm, $nPpbDayTo) {
        $this->db->where('FNPpkID', $nPpkID);
        $this->db->where('FNPpbDayFrm', $nPpbDayFrm);
        $this->db->where('FNPpbDayTo', $nPpbDayTo);
        $this->db->delete('TTKMPkgPriBooking');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGDelPkgPdtPriBKG($nPkgPdtID, $nPdtDayFrm, $nPdtDayTo) {
        $this->db->where('FNPkgPdtID', $nPkgPdtID);
        $this->db->where('FNPpbDayFrm', $nPdtDayFrm);
        $this->db->where('FNPpbDayTo', $nPdtDayTo);
        $this->db->delete('TTKMPdtPriBooking');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGDelPkgGrpPriBKG($nPgpGrpID, $nGpbDayFrm, $nGpbDayTo) {
        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->where('FNGpbDayFrm', $nGpbDayFrm);
        $this->db->where('FNGpbDayTo', $nGpbDayTo);
        $this->db->delete('TTKMGrpPriBooking');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGGetGrpPriSpcPriByBKG($nPgpGrpID) {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY FNPgpGrpID DESC) AS RowID
						,FNPgpGrpID
						,FNGpbDayFrm
						,FNGpbDayTo
						,FNGpbSign
						,FTGpbAdjType
						,CONVERT(DECIMAL(20,2),FCGpbValue) AS FCGpbValue
						,FCGpbPrice
				FROM TTKMGrpPriBooking 
				WHERE FNPgpGrpID = '$nPgpGrpID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetPkgPriByBKG($nPpkID) {
        $tSQL = "  SELECT ROW_NUMBER() OVER(ORDER BY FNPpkID DESC) AS RowID
				   ,FNPpkID
				   ,FNPpbDayFrm
				   ,FNPpbDayTo
				   ,FNPpbSign
				   ,FTPpbAdjType
				   ,CONVERT(DECIMAL(20,2),FCPpbValue) AS FCPpbValue
				   ,FCPpbPrice
				   FROM TTKMPkgPriBooking
				   WHERE FNPpkID = '$nPpkID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGEditPkgPdtPriBKG($aData) {
        $this->db->where('FNPpbDayFrm', $aData ['FNPpbDayFrm']);
        $this->db->where('FNPpbDayTo', $aData ['FNPpbDayTo']);

        $tDB = $this->db->update('TTKMPdtPriBooking', array(
            'FTPpbAdjType' => $aData ['FTPpbAdjType'],
            'FCPpbValue' => $aData ['FCPpbValue']
                ));

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGEditPkgGrpPriBKG($aData) {
        $this->db->where('FNGpbDayFrm', $aData ['FNGpbDayFrm']);
        $this->db->where('FNGpbDayTo', $aData ['FNGpbDayTo']);

        $tDB = $this->db->update('TTKMGrpPriBooking', array(
            'FTGpbAdjType' => $aData ['FTGpbAdjType'],
            'FCGpbValue' => $aData ['FCGpbValue']
                ));

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGEditPkgPriBKG($aData) {
        $this->db->where('FNPpbDayFrm', $aData ['FNPpbDayFrm']);
        $this->db->where('FNPpbDayTo', $aData ['FNPpbDayTo']);

        $tDB = $this->db->update('TTKMPkgPriBooking', array(
            'FTPpbAdjType' => $aData ['FTPpbAdjType'],
            'FCPpbValue' => $aData ['FCPpbValue']
                ));

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSnMPKGAddPkgGrpPriBKG($aData) {
        $oCheckHave = $this->FSxMPKGCheckHavePkgGrpPriBKG($aData ['FNPgpGrpID'], $aData ['FNGpbDayFrm'], $aData ['FNGpbDayTo']);
        $nBKGHave = $oCheckHave [0]->counts;

        if ($nBKGHave == 0) {
            $this->db->insert('TTKMGrpPriBooking', $aData);

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            return 0;
        }
    }

    public function FSxMPKGCheckHavePkgGrpPriBKG($nPgpGrpID, $nGpbDayFrm, $nGpbDayTo) {
        $tSQL = "SELECT COUNT (FNPgpGrpID) AS counts
				 FROM TTKMGrpPriBooking
				 WHERE FNPgpGrpID = '$nPgpGrpID'
				 AND FNGpbDayFrm = '$nGpbDayFrm'
				 AND FNGpbDayTo = '$nGpbDayTo' ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGAddPkgPriBKG($aData) {
        $oCheckHave = $this->FSxMPKGCheckHavePkgPriBKG($aData ['FNPpkID'], $aData ['FNPpbDayFrm'], $aData ['FNPpbDayTo']);
        $nBKGHave = $oCheckHave [0]->counts;

        if ($nBKGHave == 0) {
            $this->db->insert('TTKMPkgPriBooking', $aData);

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            return 500;
        }
    }

    public function FSxMPKGCheckHavePkgPriBKG($nPpkID, $nPpbDayFrm, $nPpbDayTo) {
        $tSQL = "SELECT COUNT (FNPpkID) AS counts
				 FROM TTKMPkgPriBooking
				 WHERE FNPpkID = '$nPpkID'
				 AND FNPpbDayFrm = '$nPpbDayFrm'
				 AND FNPpbDayTo = '$nPpbDayTo' ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGEditImg($aImgData) {
        $this->db->where('FNImgRefID', $aImgData ['FNImgRefID']);
        $this->db->where('FTImgType', $aImgData ['FTImgType']);
        $tDB = $this->db->update('TCNMImgObj', array(
            'FTImgObj' => $aImgData ['FTImgObj'],
            'FNImgSeq' => $aImgData ['FNImgSeq']
                ));

        if ($this->db->affected_rows() > 0) {
            
        } else {

            $aData = array(
                'FNImgRefID' => $aImgData ['FNImgRefID'],
                'FTImgType' => $aImgData ['FTImgType'],
                'FTImgObj' => $aImgData ['FTImgObj'],
                'FNImgSeq' => $aImgData ['FNImgSeq']
            );
            $this->db->insert('TCNMImgObj', $aData);
        }
    }

    public function FSxMPKGGetPdtPriSpcPriByDOWPanal($nPkgID, $nPkgPdtID) {
        $oCheckHave = $this->FSxMPKGCheckHavePdtPriSpcPriByDOWPanal($nPkgPdtID);
        $nDOWHave = $oCheckHave [0]->counts;

        if ($nDOWHave == 0) {

            for ($i = 0; $i < 7; $i ++) {

                $this->db->insert('TTKMPdtPriDOW', array(
                    'FNPkgPdtID' => $nPkgPdtID,
                    'FNPpdDayOfWeek' => $i,
                    'FCPpdPrice' => '0'
                ));
            }

            $tSQL = "SELECT PPD.FNPkgPdtID,P.FNPdtID,PL.FTPdtName,PPD.FNPpdDayOfWeek
							,CONVERT(DECIMAL(20,2),PPD.FCPpdPrice) AS FCPpdPrice
					 FROM TTKMPdtPriDOW PPD
					 INNER JOIN TTKTPkgPdtPri PPP ON PPP.FNPkgPdtID = PPD.FNPkgPdtID
					 INNER JOIN TCNMPdtTicket P ON P.FNPdtID = PPP.FNPdtID
					 INNER JOIN TCNMPdt_L PL ON PL.FTPdtCode = P.FTPdtCode AND PL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					 WHERE PPD.FNPkgPdtID = '$nPkgPdtID'";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } else {

            $tSQL = "SELECT PPD.FNPkgPdtID,P.FNPdtID,PL.FTPdtName,PPD.FNPpdDayOfWeek
							,CONVERT(DECIMAL(20,2),PPD.FCPpdPrice) AS FCPpdPrice
					 FROM TTKMPdtPriDOW PPD
					 INNER JOIN TTKTPkgPdtPri PPP ON PPP.FNPkgPdtID = PPD.FNPkgPdtID
					 INNER JOIN TCNMPdtTicket P ON P.FNPdtID = PPP.FNPdtID
					 INNER JOIN TCNMPdt_L PL ON PL.FTPdtCode = P.FTPdtCode AND PL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					 WHERE PPD.FNPkgPdtID = '$nPkgPdtID'";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        }
    }

    public function FSnMPKGEditPkgPriSpcPriByDOW($nPpkID, $nPpdDayOfWeek, $aData) {
        $this->db->where('FNPpkID', $nPpkID);
        $this->db->where('FNPpdDayOfWeek', $nPpdDayOfWeek);
        $this->db->update('TTKMPkgPriDOW', $aData);

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSnMPKGEditGrpPriSpcPriByDOW($nPgpGrpID, $nGpdDayOfWeek, $aData) {
        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->where('FNGpdDayOfWeek', $nGpdDayOfWeek);
        $this->db->update('TTKMGrpPriDOW', $aData);

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSnMPKGEditPdtPriSpcPriByDOW($nPkgPdtID, $nPpdDayOfWeek, $aData) {
        $this->db->where('FNPkgPdtID', $nPkgPdtID);
        $this->db->where('FNPpdDayOfWeek', $nPpdDayOfWeek);
        $this->db->update('TTKMPdtPriDOW', $aData);

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FStMPKGGetGrpPriSpcPriByDOWPanal($nPkgID, $nPgpGrpID) {
        $oCheckHave = $this->FSxMPKGCheckHaveGrpPriSpcPriByDOWPanal($nPgpGrpID);
        $nDOWHave = $oCheckHave [0]->counts;

        if ($nDOWHave == 0) {
            for ($i = 0; $i < 7; $i ++) {
                $this->db->insert('TTKMGrpPriDOW', array(
                    'FNPgpGrpID' => $nPgpGrpID,
                    'FNGpdDayOfWeek' => $i,
                    'FCGpdPrice' => '0'
                ));
            }

            $tSQL = "SELECT GPD.FNPgpGrpID,GPD.FNGpdDayOfWeek
							,CONVERT(DECIMAL(20,2),GPD.FCGpdPrice) AS FCGpdPrice 
					 FROM TTKMGrpPriDOW GPD
					 INNER JOIN TTKTPkgGrpPri PGP ON PGP.FNPgpGrpID = GPD.FNPgpGrpID
					 WHERE PGP.FNPgpGrpID = '$nPgpGrpID'";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } else {

            $tSQL = "SELECT GPD.FNPgpGrpID,GPD.FNGpdDayOfWeek
							,CONVERT(DECIMAL(20,2),GPD.FCGpdPrice) AS FCGpdPrice 
			 		 FROM TTKMGrpPriDOW GPD
			 		 INNER JOIN TTKTPkgGrpPri PGP ON PGP.FNPgpGrpID = GPD.FNPgpGrpID
			 		 WHERE PGP.FNPgpGrpID = '$nPgpGrpID'";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        }
    }

    public function FSxMPKGCheckHaveGrpPriSpcPriByDOWPanal($nPgpGrpID) {
        $tSQL = "SELECT COUNT (FNPgpGrpID) AS counts
				 FROM TTKMGrpPriDOW
				 WHERE FNPgpGrpID = '$nPgpGrpID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckHavePdtPriSpcPriByDOWPanal($nPkgPdtID) {
        $tSQL = "SELECT COUNT (FNPkgPdtID) AS counts
				 FROM TTKMPdtPriDOW
				 WHERE FNPkgPdtID = '$nPkgPdtID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGAddPkgModelZone($pnZneID, $pnPkgLocID, $pnPckID, $pnPmoID, $nPpkPrice) {

        // เช็คว่ามีอยู่ในระบบ หรือไม่
        $nCountRow = $this->FSxMPKGCheckModelPpkType($pnPckID, 1, $pnPmoID, $pnZneID);
        $nSttHave = $nCountRow [0]->counts;

        // 0 ยังไม่มี ใน Base ,1 มีใน Base แล้ว
        if ($nSttHave == '0') {

            // เช็คว่ามีสินค้า
            $aCountRow = $this->FSxMPKGCheckPkgHaveProduct($pnPckID);
            $nPdtHave = $aCountRow [0]->counts;

            if ($nPdtHave >= 0) {

                $oSttDel = $this->FSxMPKGDelProductMoreThan1Mol($pnPckID);

                if ($oSttDel == 1) {

                    $this->db->insert('TTKTPkgPark', array(
                        'FNPkgID' => $pnPckID,
                        'FTPpkType' => '1',
                        'FNPmoID' => $pnPmoID,
                        'FNZneID' => $pnZneID,
                        'FCPpkPrice' => $nPpkPrice
                    ));

                    return 1;
                } else {
                    return "error ตอนลบ Pdt ที่ไม่ NUll";
                }
            } else {

                $this->db->insert('TTKTPkgPark', array(
                    'FNPkgID' => $pnPckID,
                    'FTPpkType' => '1',
                    'FNPmoID' => $pnPmoID,
                    'FNZneID' => $pnZneID,
                    'FCPpkPrice' => $nPpkPrice
                ));

                return 1;
            }
        } else {
            // บันทึกมีใน Base
            return 0;
        }
    }

    // เช็คว่ามีสินค้าไหน ที่เป็นสินค้าเฉพราะของ Pkg นั้นๆ
    public function FSxMPKGCheckPdtSpecific($pnPckID) {
        $tSQL = "SELECT COUNT(TG.FNPmoID)AS counts 
				 FROM TTKTPkgPdtPri PPP
				 INNER JOIN TCNMPdtTicket PT ON PT.FNPdtID = PPP.FNPdtID
				 INNER JOIN TTKMTchGroup TG ON TG.FNTcgID = PT.FNTcgID
				 WHERE PPP.FNPkgID = '$pnPckID'
			     AND TG.FNPmoID IS NOT NULL";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // เช็คว่ามีสินค้าไหน ที่เป็นสินค้าเฉพราะของ Pkg นั้นๆ
    public function FSxMPKGCheckPdtSpecific1($pnPckID) {
        $tSQL = "SELECT COUNT(TG.FNPmoID)AS counts 
				FROM TTKTPkgPdtPri PPP
				INNER JOIN TCNMPdtTicket PT ON PT.FNPdtID = PPP.FNPdtID
				INNER JOIN TTKMTchGroup TG ON TG.FNTcgID = PT.FNTcgID
				WHERE PPP.FNPkgID = '$pnPckID'
				AND TG.FNPmoID IS NOT NULL";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGDelProductMoreThan1Mol($pnPckID) {
        $tSQL = "DELETE PPP FROM TTKTPkgPdtPri PPP
				 INNER JOIN TCNMPdtTicket PT ON PT.FNPdtID = PPP.FNPdtID
				 INNER JOIN TTKMTchGroup TG ON TG.FNTcgID = PT.FNTcgID
				 WHERE PPP.FNPkgID = '$pnPckID'
				 AND TG.FNPmoID IS NOT NULL";

        $oQuery = $this->db->query($tSQL);

        return $oQuery;
    }

    public function JSnPKGCheckZneBookingType($nZneID) {
        $tSQL = "SELECT FTZneBookingType 
				 FROM TTKMLocZone
				 WHERE FNZneID = $nZneID";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckPkgModelZoneMore2($pnZneID, $pnPkgLocID, $pnPckID, $pnPmoID) {
        $nCountRow = $this->FSxMPKGCheckModelPpkType($pnPckID, 1, $pnPmoID, $pnZneID);
        $nSttHave = $nCountRow [0]->counts;

        // 0 ยังไม่มี ใน Base ,1 มีใน Base แล้ว
        if ($nSttHave == '0') {

            $More1Place = $this->JSxMPKGCheckPkgHaveModelCstMore1Place($pnPckID);
            $nNumModel = $More1Place [0]->counts;

            return $nNumModel;
        } else {

            return "Have Zone";
        }
    }

    public function FSxMPKGCheckPkgHaveProduct($nPkgID) {
        $tSQL = "SELECT COUNT(FNPkgID) AS counts
				 FROM TTKTPkgPdtPri
				 WHERE FNPkgID = '$nPkgID'
				 ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // Check วันที่ปัจจุบันเพื่ออนุมัติ แพ็คเกจ
    public function FSxMPKGCheckApvDateStartChkIn($nPkgID, $dDateNow) {
        $tSQL = "SELECT COUNT (PL.FNPkgID)AS counts
				 FROM TTKTPkgList PL
				 LEFT JOIN TCNMImgObj IP ON IP.FTImgRefID = PL.FNPkgID AND IP.FTImgTable = 'TTKTPkgList'
				 LEFT JOIN TTKTPkgList_L PLL ON PLL.FNPkgID = PL.FNPkgID AND PLL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 LEFT JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = PL.FNTcgID AND TGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE PL.FNPkgID =  '$nPkgID'
				 AND FDPkgStartChkIn >= '$dDateNow'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGCheckDateDelPkg($nPkgID, $dDateNow) {
        $tSQL = "SELECT COUNT (FDPkgStartChkIn) AS counts
				 FROM TTKTPkgList PL
				 LEFT JOIN TCNMImgObj IP ON IP.FTImgRefID = PL.FNPkgID AND IP.FTImgTable = 'TTKTPkgList'
				 LEFT JOIN TTKTPkgList_L PLL ON PLL.FNPkgID = PL.FNPkgID AND PLL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 LEFT JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = PL.FNTcgID AND TGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE PL.FNPkgID =  '$nPkgID'
				 AND '$dDateNow' BETWEEN FDPkgStartChkIn AND FDPkgStopChkIn";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetZoneList($nLocId, $nPkgID) {
        $nPkgHave = $this->FSnMPKGCheckPkgHaveZone($nPkgID);
        if (isset($nPkgHave [0]->FTZneBookingType)) {
            $nBookingType = $nPkgHave [0]->FTZneBookingType;
        } else {
            $nBookingType = '';
        }

        if ($nBookingType != '') {

            $tSQL = "SELECT Z.FNLocID,Z.FNZneID,ZL.FTZneName,Z.FTZneBookingType
						FROM TTKMLocZone Z
						INNER JOIN TTKMLocZone_L ZL ON ZL.FNZneID = Z.FNZneID AND ZL.FNLngID = " . $this->session->userdata("tLangEdit") . "
						INNER JOIN TTKMLocation L ON L.FNLocID = Z.FNLocID
						WHERE Z.FNLocID ='$nLocId'
						AND Z.FTZneBookingType = '$nBookingType'";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } else {

            $tSQL = "SELECT Z.FNLocID,Z.FNZneID,ZL.FTZneName,FTZneBookingType
						 FROM TTKMLocZone Z
						 INNER JOIN TTKMLocZone_L ZL ON ZL.FNZneID = Z.FNZneID AND ZL.FNLngID = " . $this->session->userdata("tLangEdit") . "
						 INNER JOIN TTKMLocation L ON L.FNLocID = Z.FNLocID
						 WHERE Z.FNLocID ='$nLocId'";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        }
    }

    // AND CONVERT(varchar(10),GETDATE(),121) <= CONVERT(varchar(10),FDShwEndDate,121)
    public function FSxMPKGGetLocShowTimeList($nLocId, $nEvnID) {
        $tSQL = "SELECT FNEvnID,FNLocID,TDT.FNTmhID,THDL.FTTmhName
							,CONVERT(CHAR(10),FDShwStartDate,121) AS FDShwStartDate
							,FTShwStartTime
							,CONVERT(CHAR(10),FDShwEndDate,121) AS FDShwEndDate 
							,FTShwEndTime  
					 FROM TTKTShowTime TDT
					 LEFT JOIN TTKMTimeTableHD_L THDL ON THDL.FNTmhID = TDT.FNTmhID  AND THDL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					 WHERE FNEvnID = '$nEvnID'
					 AND FNLocID = '$nLocId'
			";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetLocTimeTableHDList() {
        $tSQL = "SELECT TBH.FNTmhID,TBH.FTTmhStaActive,TBHL.FTTmhName 
				 FROM TTKMTimeTableHD TBH
				 LEFT JOIN TTKMTimeTableHD_L TBHL ON TBH.FNTmhID = TBHL.FNTmhID AND TBHL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE TBH.FTTmhStaActive = 1";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetDetailTimeTableDT($nLocId) {
        $tSQL = "SELECT FNTmdID,TDT.FNTmhID,THDL.FTTmhName,FTTmdStartTime,FTTmdEndTime
				 FROM TTKMTimeTableDT TDT
				 LEFT JOIN TTKMTimeTableHD_L  THDL ON THDL.FNTmhID = TDT.FNTmhID AND THDL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE TDT.FNTmhID = '$nLocId' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGCheckPkgHaveZone($nPkgID) {
        $tSQL = "SELECT DISTINCT LZ.FTZneBookingType
				 FROM TTKTPkgPark PP
				 INNER JOIN TTKMLocZone LZ ON LZ.FNZneID = PP.FNZneID
				 WHERE FNPkgID = '$nPkgID'
				 AND FTPpkType = '1'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // SELECT L.FNLocID,L.FNPmoID,LL.FTLocName,MDL.FTPmoName
	// 			 FROM TTKMLocation L
	// 			 INNER JOIN TTKMLocation_L LL ON LL.FNLocID = L.FNLocID AND LL.FNLngID = " . $this->session->userdata("tLangEdit") . "
	// 			 INNER JOIN TTKMPdtModel_L MDL ON MDL.FNPmoID = L.FNPmoID AND MDL.FNLngID = " . $this->session->userdata("tLangEdit") . "
	// 			 WHERE L.FNPmoID = '$pnPmoID'";
    public function FSxMPKGGetLocationList($pnPmoID) {
        $tSQL = "SELECT L.FNLocID,L.FNPmoID,LL.FTLocName,MBL.FTBchName
				 FROM TTKMLocation L
				 INNER JOIN TTKMLocation_L LL ON LL.FNLocID = L.FNLocID AND LL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 INNER JOIN TCNMBranch_L MBL ON MBL.FTBchCode = L.FNPmoID AND MBL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE L.FNPmoID = '$pnPmoID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGDelPkgModelCustomer($nPpkID) {
        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKTPkgPark');

        // Delete 3 ตาราง
        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKMPkgPriDOW');

        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKMPkgPriBooking');

        $this->db->where('FNPpkID', $nPpkID);
        $this->db->delete('TTKMPkgPriHoliday');

        return 1;
    }

    public function FSxMPKGDelPkgProduct($nPkgPdtID, $nPkgID) {

        // Check ว่ามีสินค้าหรือไม่ถ้ามี == 1 จะไม่สามารถลบสินค้าชิ้นนั้นออกได้
        $PdtHave = $this->FSxMPKGCheckPkgHaveProduct($nPkgID);
        $nHave = $PdtHave [0]->counts;

        // <2 หรือ 1,0 จะไม่สามารถลบได้
        if ($nHave < 2) {
            return 0;
        } else {
            $this->db->where('FNPkgPdtID', $nPkgPdtID);
            $this->db->delete('TTKTPkgPdtPri');

            $this->db->where('FNPkgPdtID', $nPkgPdtID);
            $this->db->delete('TTKTPkgGrpPri');

            $this->db->where('FNPkgPdtID', $nPkgPdtID);
            $this->db->delete('TTKMPdtPriDOW');

            $this->db->where('FNPkgPdtID', $nPkgPdtID);
            $this->db->delete('TTKMPdtPriBooking');

            $this->db->where('FNPkgPdtID', $nPkgPdtID);
            $this->db->delete('TTKMPdtPriHoliday');

            // $this->db->where('FNPkgPdtID', $nPkgPdtID);
            // $this->db->delete('TTKMPdtPriDOW');

            return 1;
        }
    }

    // ลบ กลุ่มพิเศษในแพ็คเกจ
    public function FSnMPKGDelPkgSpcGrpPri($nPgpGrpID, $nPkgID) {
        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->delete('TTKTPkgGrpPri');

        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->delete('TTKMGrpPriDOW');

        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->delete('TTKMGrpPriHoliday');

        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->delete('TTKMGrpPriBooking');

        return 1;
    }

    // ลบ กลุ่มพิเศษของสินค้าในแพ็คเกจ
    public function FSnMPKGDelPkgPdtGrpPri($nPgpGrpID, $nPkgID) {
        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->delete('TTKTPkgGrpPri');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGDelPkgModelAdmin($pnPkgID, $pnPmoID) {
        $this->db->where('FNPkgID', $pnPkgID);
        $this->db->where('FNPmoID', $pnPmoID);
        $this->db->where('FTPpkType', '2');
        $this->db->delete('TTKTPkgPark');

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }


    public function FSxMPKGGetPkgModelForAdminList($pnPkgID) {
        $tSQL = "SELECT PP.FNPkgID,PP.FTPpkType,PP.FNPmoID,MBL.FTBchName
				 FROM TTKTPkgPark PP
				 LEFT JOIN TCNMBranch_L MBL ON MBL.FTBchCode = PP.FNPmoID AND MBL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE FNPkgID = '$pnPkgID'
				 AND FTPpkType = '2'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }


    public function FSxMPKGGetPkgModelForCustomerListSelectBox($pnPkgID) {
        $tSQL = "SELECT DISTINCT PP.FNPkgID,PP.FNPmoID,MBL.FTBchName
				 FROM TTKTPkgPark PP
				 INNER JOIN TCNMBranch_L MBL ON MBL.FTBchCode = PP.FNPmoID AND MBL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 INNER JOIN TTKMLocZone LZ ON LZ.FNZneID = PP.FNZneID
				 INNER JOIN TTKMLocZone_L LZL ON LZL.FNZneID = PP.FNZneID AND LZL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 INNER JOIN TTKMLocation_L LL ON LL.FNLocID = LZ.FNLocID AND LL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					
				 WHERE FNPkgID = '$pnPkgID'
				 AND FTPpkType = '1'
				 ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetPkgModelForCustomerList($pnPkgID) {
        $tSQL = "SELECT PP.FNPpkID,PP.FNPkgID,PP.FNPmoID,MBL.FTBchName,LZ.FNLocID,LL.FTLocName,PP.FNZneID,LZL.FTZneName,LZ.FTZneBookingType,PP.FCPpkPrice
				 FROM TTKTPkgPark PP
					
				 INNER JOIN TCNMBranch_L MBL ON MBL.FTBchCode = PP.FNPmoID AND MBL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 INNER JOIN TTKMLocZone LZ ON LZ.FNZneID = PP.FNZneID
				 INNER JOIN TTKMLocZone_L LZL ON LZL.FNZneID = PP.FNZneID AND LZL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 INNER JOIN TTKMLocation_L LL ON LL.FNLocID = LZ.FNLocID AND LL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					
				 WHERE FNPkgID = '$pnPkgID'
				 AND FTPpkType = '1' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }


    // Get สาขาที่ อนูญาติเข้า
    public function FSxMPKGGetPkgModelForCustomerListCount($pnPkgID) {
        $tSQL = "SELECT COUNT(PP.FNPkgID) AS count
		FROM TTKTPkgPark PP
		
		INNER JOIN TCNMBranch_L MBL ON MBL.FTBchCode  = PP.FNPmoID AND MBL.FNLngID = " . $this->session->userdata("tLangEdit") . "
		INNER JOIN TTKMLocZone LZ ON LZ.FNZneID = PP.FNZneID
		INNER JOIN TTKMLocZone_L LZL ON LZL.FNZneID = PP.FNZneID AND LZL.FNLngID = " . $this->session->userdata("tLangEdit") . "
		INNER JOIN TTKMLocation_L LL ON LL.FNLocID = LZ.FNLocID AND LL.FNLngID = " . $this->session->userdata("tLangEdit") . "
			
		WHERE FNPkgID = '$pnPkgID'
		AND FTPpkType = '1'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetPkgMaxPark($pnPkgID) {
        $tSQL = "SELECT 
				 PL.FNPkgMaxPark
				 FROM TTKTPkgList PL
				 WHERE PL.FNPkgID =  $pnPkgID ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckModelPpkType($pnPkgID, $pnPpkType, $pnPmoID, $pnZneID) {
        $tSQL = "SELECT COUNT(FNPkgID) AS counts  
				 FROM TTKTPkgPark
				 WHERE 1 = 1";

        if ($pnPkgID != '') {
            $tSQL .= "AND FNPkgID = '$pnPkgID' ";
        }

        if ($pnPpkType != '') {
            $tSQL .= "AND FTPpkType = '$pnPpkType'";
        }

        if ($pnPmoID != '') {
            $tSQL .= "AND FNPmoID = '$pnPmoID'";
        }

        if ($pnZneID != '') {
            $tSQL .= "AND FNZneID = '$pnZneID'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckPkgProduct($pnPkgID, $pnPdtID) {
        $tSQL = "SELECT COUNT(FNPkgID) AS counts
				 FROM TTKTPkgPdtPri
				 WHERE FNPkgID = '$pnPkgID'
				 AND FNPdtID = '$pnPdtID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGAddPkgModel($aData) {
        $pnZneID = '';
        $nCountRow = $this->FSxMPKGCheckModelPpkType($aData ['FNPkgID'], $aData ['FTPpkType'], $aData ['FNPmoID'], $pnZneID);
        print_r( $nCountRow );
        // exit;
        $nSttHave = $nCountRow [0]->counts;
        // TTKMImgObj

        if ($nSttHave == '0') {
            $this->db->insert('TTKTPkgPark', array(
                'FNPkgID' => $aData ['FNPkgID'],
                'FTPpkType' => $aData ['FTPpkType'],
                'FNPmoID' => $aData ['FNPmoID']
            ));

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            return 500;
        }
    }

    public function FSxMPKGAddPkgModelProduct($aData) {
        $nCountRow = $this->FSxMPKGCheckPkgProduct($aData ['FNPkgID'], $aData ['FNPdtID']);
        $nSttHave = $nCountRow [0]->counts;

        if ($nSttHave == '0') {

            $this->db->insert('TTKTPkgPdtPri', array(
                'FNPkgID' => $aData ['FNPkgID'],
                'FNPdtID' => $aData ['FNPdtID'],
                'FCPdtPrice' => $aData ['FCPdtPrice'],
                'FNPdtMaxPerson' => $aData ['FNPdtMaxPerson']
            ));

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            return 500;
        }
    }

    public function FSnMPKGAddSpcPkgGrpPri($aData) {
        $nCountRow = $this->FSnMPKGCheckSpcPkgGrpPri($aData ['FNPpkID'], $aData ['FTPgpType'], $aData ['FNPgpRefID']);
        $nSttHave = $nCountRow [0]->counts;

        if ($nSttHave == '0') {

            $this->db->insert('TTKTPkgGrpPri', array(
                'FNPpkID' => $aData ['FNPpkID'],
                'FTPgpType' => $aData ['FTPgpType'],
                'FNPgpRefID' => $aData ['FNPgpRefID'],
                'FCPgpPdtPrice' => $aData ['FCPgpPdtPrice']
            ));

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            return 500;
        }
    }

    public function FSnMPKGAddPkgPdtGrpPri($aData) {
        $nCountRow = $this->FSnMPKGCheckPkgPdtGrpPri($aData ['FNPpkID'], $aData ['FTPgpType'], $aData ['FNPgpRefID'], $aData ['FNPkgPdtID']);
        $nSttHave = $nCountRow [0]->counts;

        if ($nSttHave == '0') {

            $this->db->insert('TTKTPkgGrpPri', array(
                'FNPpkID' => $aData ['FNPpkID'],
                'FTPgpType' => $aData ['FTPgpType'],
                'FNPgpRefID' => $aData ['FNPgpRefID'],
                'FCPgpPdtPrice' => $aData ['FCPgpPdtPrice'],
                'FNPkgPdtID' => $aData ['FNPkgPdtID']
            ));

            if ($this->db->affected_rows() > 0) {
                Return 1;
            } else {
                Return 0;
            }
        } else {
            return 500;
        }
    }

    public function FSnMPKGCheckSpcPkgGrpPri($pnPkgID, $pnPgpType, $pnPgpRefID) {
        $tSQL = "SELECT COUNT(FNPpkID) AS counts
				 FROM TTKTPkgGrpPri
				 WHERE FNPpkID = '$pnPkgID'
				 AND FTPgpType = '$pnPgpType'
			 	 AND FNPgpRefID = '$pnPgpRefID'
				 AND FNPkgPdtID IS NULL";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSnMPKGCheckPkgPdtGrpPri($pnPkgID, $pnPgpType, $pnPgpRefID, $pnPkgPdtID) {
        $tSQL = "SELECT COUNT(FNPpkID) AS counts
				 FROM TTKTPkgGrpPri
				 WHERE FNPpkID = '$pnPkgID'
				 AND FTPgpType = '$pnPgpType'
				 AND FNPgpRefID = '$pnPgpRefID'
				 AND FNPkgPdtID = '$pnPkgPdtID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCallPageEditPkg($pnPkgID) {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY PL.FNPkgID ASC) AS RowID,
					PL.FNPkgID,
					PLL.FTPkgName,
					PL.FNTcgID,
					TGL.FTTcgName,
    				PL.FNPkgMaxChkIn,
    				PL.FNPkgMaxPark,
    				PL.FTPkgType,
    				PL.FNPkgMinGrpQty,
    				PL.FNPkgMaxGrpQty,
    				PL.FTPkgStaPrcDoc,
    				CAST(PP.FCPpkPrice AS DECIMAL(20,2)) AS FCPpkPrice,
					PL.FTPkgStaLimitType,
					PL.FTPkgStaActive,
					PL.FTPkgStaFreeGuide,
					PL.FNEvnID,
					CONVERT(CHAR(16),PL.FDPkgStartSale,126) AS FDPkgStartSale,
					CONVERT(CHAR(16),PL.FDPkgStopSale,126) AS FDPkgStopSale,
					CONVERT(CHAR(16),PL.FDPkgStartChkIn,126) AS FDPkgStartChkIn,
					CONVERT(CHAR(16),PL.FDPkgStopChkIn,126) AS FDPkgStopChkIn,
					IP.FNImgID,
					IP.FTImgObj,
					PLL.FTPkgDesc1,
					PLL.FTPkgDesc2,
					PLL.FTPkgDesc3,
					PLL.FTPkgDesc4,
					PLL.FTPkgDesc5,
					PL.FTPkgStaLimitBy,
				    PL.FNPkgLimitQty,
				    PL.FNPkgMinQtyByBill,
				    PL.FNPkgMaxQtyByBill,
					EVNL.FTEvnName
					FROM TTKTPkgList PL
					LEFT JOIN TTKTPkgPark PP ON PP.FNPkgID = PL.FNPkgID
					LEFT JOIN TCNMImgObj IP ON IP.FTImgRefID = PL.FNPkgID AND IP.FTImgTable = 'TTKTPkgList'
					LEFT JOIN TTKTPkgList_L PLL ON PLL.FNPkgID = PL.FNPkgID AND PLL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					LEFT JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = PL.FNTcgID AND TGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					LEFT JOIN TTKMEvent_L EVNL ON EVNL.FNEvnID = PL.FNEvnID AND EVNL.FNLngID = " . $this->session->userdata("tLangEdit") . "
                    WHERE PL.FNPkgID =  $pnPkgID ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetPkgNoPdtList() {
        $tSQL = "SELECT 				
				PL.FNPkgID,
				PLL.FTPkgName
				FROM TTKTPkgList PL
				LEFT JOIN TTKTPkgList_L PLL ON PLL.FNPkgID = PL.FNPkgID AND PLL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				WHERE PL.FNPkgID NOT IN (SELECT DISTINCT FNPkgID FROM TTKTPkgPdtPri WHERE FNPkgID IS NOT NULL)";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCountCheckPkgNoPdt() {
        $tSQL = "SELECT COUNT(FNPkgID)AS counts
				 FROM TTKTPkgList 
				 WHERE FNPkgID NOT IN (SELECT DISTINCT FNPkgID FROM TTKTPkgPdtPri WHERE FNPkgID IS NOT NULL)";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGAddPkgPdtPri($aDataPdt) {
        // TTKTPkgList
        $this->db->insert('TTKTPkgPdtPri', array(
            'FNPkgID' => $aDataPdt ['FNPkgID'],
            'FNPdtID' => $aDataPdt ['FNPdtID'],
            'FNPdtMaxPerson' => $aDataPdt ['FNPdtMaxPerson'],
            'FCPdtPrice' => $aDataPdt ['FCPdtPrice']
        ));

        $this->PkgPdtID = $this->db->insert_id();

        // TTKMLocation_L
        $this->db->insert('TTKTPkgList_L', array(
            'FNPkgID' => $this->PkgID,
            'FNLngID' => $this->session->userdata("tLangEdit"),
            'FTPkgName' => $aData ['FTPkgName'],
            'FTPkgDesc1' => $aData ['FTPkgDesc1'],
            'FTPkgDesc2' => $aData ['FTPkgDesc2'],
            'FTPkgDesc3' => $aData ['FTPkgDesc3'],
            'FTPkgDesc4' => $aData ['FTPkgDesc4'],
            'FTPkgDesc5' => $aData ['FTPkgDesc5']
        ));

        // TTKMImgObj
        $this->db->insert('TCNMImgObj', array(
            'FNImgRefID' => $this->PkgID,
            'FTImgObj' => $aData ['FTPkgName'],
            'FTImgType' => '4'
        ));

        return $this->PkgID;
    }

    public function FSxMPKGEditPackage($tPkgID, $aDataPkgList, $aDataPkgList_L) {
        $this->db->where('FNPkgID', $tPkgID);
        $this->db->update('TTKTPkgList', $aDataPkgList);

        if ($this->db->affected_rows() > 0) {

            $tTatle_L = 'TTKTPkgList_L';
            $nFieldIDName = 'FNPkgID';
            $oHave = FSnCheckUpdateLang($tTatle_L, $nFieldIDName, $tPkgID);
            $nHave = $oHave [0]->counts;
            $ntLangEdit = $this->session->userdata("tLangEdit");

            if ($nHave == 0) {

                $this->db->insert('TTKTPkgList_L', array(
                    'FNPkgID' => $tPkgID,
                    'FNLngID' => $this->session->userdata("tLangEdit"),
                    'FTPkgName' => $aDataPkgList_L ['FTPkgName'],
                    'FTPkgDesc1' => $aDataPkgList_L ['FTPkgDesc1'],
                    'FTPkgDesc2' => $aDataPkgList_L ['FTPkgDesc2'],
                    'FTPkgDesc3' => $aDataPkgList_L ['FTPkgDesc3'],
                    'FTPkgDesc4' => $aDataPkgList_L ['FTPkgDesc4'],
                    'FTPkgDesc5' => $aDataPkgList_L ['FTPkgDesc5']
                ));

                if ($this->db->affected_rows() > 0) {
                    return 1;
                } else {
                    return 0;
                }
            } else {

                $this->db->where('FNPkgID', $tPkgID);
                $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
                $this->db->update('TTKTPkgList_L', $aDataPkgList_L);

                if ($this->db->affected_rows() > 0) {
                    return 1;
                } else {
                    return 0;
                }
            }
        } else {
            return 0;
        }
    }

    public function FSxMPKGEditPkgProduct($nPkgPdtID, $aData) {
        $this->db->where('FNPkgPdtID', $nPkgPdtID);
        $this->db->update('TTKTPkgPdtPri', $aData);

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSnMPKGEditPkgSpcGrpPri($nPgpGrpID, $aData) {
        $this->db->where('FNPgpGrpID', $nPgpGrpID);
        $this->db->update('TTKTPkgGrpPri', $aData);

        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSxMPKGAddPackage($aDataPkgList, $aDataPkgList_L) {

        // TTKTPkgList
        $this->db->insert('TTKTPkgList', $aDataPkgList);

        $this->PkgID = $this->db->insert_id();

        // TTKMLocation_L
        $this->db->insert('TTKTPkgList_L', array(
            'FNPkgID' => $this->PkgID,
            'FNLngID' => $this->session->userdata("tLangEdit"),
            'FTPkgName' => $aDataPkgList_L ['FTPkgName'],
            'FTPkgDesc1' => $aDataPkgList_L ['FTPkgDesc1'],
            'FTPkgDesc2' => $aDataPkgList_L ['FTPkgDesc2'],
            'FTPkgDesc3' => $aDataPkgList_L ['FTPkgDesc3'],
            'FTPkgDesc4' => $aDataPkgList_L ['FTPkgDesc4'],
            'FTPkgDesc5' => $aDataPkgList_L ['FTPkgDesc5']
        ));

        return $this->PkgID;
    }

    // Create : Krit
    // ดึงข้อมูล Package List
    public function FSxMPKGPdtListSearch($ptTchGroupName, $ptSchPdtName) {
        $tSQL = "SELECT 
							PDT.FTPdtCode,
							TGL.FTTcgName,
							PDTL.FTPdtName,
							PDT.FNPdtOthSystem				
				 FROM TCNMPdtTicket PDT
				 LEFT JOIN TCNMPdt_L PDTL ON PDTL.FTPdtCode = PDT.FTPdtCode AND PDTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 LEFT JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = PDT.FNTcgID AND TGL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
				 WHERE PDT.FNPdtOthSystem IN ('2','4')
				";

        if ($ptTchGroupName != '') {
            $tSQL .= "AND (TGL.FTTcgName LIKE '%$ptTchGroupName%')";
        } else if ($ptSchPdtName != '') {
            $tSQL .= "AND ($ptTchGroupName LIKE '%$ptSchPdtName%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSaMPRKCount() {
        $tSQL = "SELECT COUNT(FNPmoID) AS counts FROM TTKMPdtModel";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSaMPKGSearchCount($tFTPkgName, $tFTPkgPmoID, $tFTPkgStaPrcDoc) {
        // $tSQL = "SELECT COUNT(TTKTPkgList.FNPkgID) AS counts
        // FROM TTKTPkgList
        // LEFT JOIN TTKTPkgList_L ON TTKTPkgList_L.FNPkgID = TTKTPkgList.FNPkgID AND TTKTPkgList_L.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        // WHERE 1=1
        // ";
        $tSQL = "SELECT  COUNT (DISTINCT PL.FNPkgID) AS counts
		    	FROM TTKTPkgList PL
				LEFT JOIN TTKTPkgPark PP ON PP.FNPkgID = PL.FNPkgID
		    	LEFT JOIN TTKTPkgList_L PLL ON PLL.FNPkgID = PL.FNPkgID AND PLL.FNLngID = " . $this->session->userdata("tLangEdit") . "
    			LEFT JOIN TCNMImgObj IP ON IP.FTImgRefID = PL.FNPkgID AND IP.FTImgTable = 'TTKTPkgList'
    			LEFT JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = PL.FNTcgID AND TGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
    			WHERE 1=1";

        if ($tFTPkgPmoID != '') {
            $tSQL .= " AND (PP.FNPmoID = '$tFTPkgPmoID')";
        }

        if ($tFTPkgName != '') {
            $tSQL .= " AND (PLL.FTPkgName LIKE '%$tFTPkgName%')";
        }

        if ($tFTPkgStaPrcDoc != '') {
            $tSQL .= " AND (PL.FTPkgStaPrcDoc = '$tFTPkgStaPrcDoc')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // ดึงข้อมูล Package List
    public function FSaMPKGList($tFTPkgPmoID, $tFTPkgName, $tFTPkgStaPrcDoc, $nPageNo, $nRow) {
        $aRowLen = $this->FCNaMPRKCallLenData($nRow, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า

        $tSQLtFTPkgPmoID = '';
        $tSQLtFTPkgName = '';
        $tSQLtFTPkgStaPrcDoc = '';

        if ($tFTPkgPmoID != '') {
            $tSQLtFTPkgPmoID = " AND (PP.FNPmoID = '$tFTPkgPmoID')";
        }

        if ($tFTPkgName != '') {
            $tSQLtFTPkgName = " AND (PLL.FTPkgName LIKE '%$tFTPkgName%')";
        } else {
            
        }

        if ($tFTPkgStaPrcDoc != '') {
            if ($tFTPkgStaPrcDoc == 0) {
                $tSQLtFTPkgStaPrcDoc = " AND (PL.FTPkgStaPrcDoc IS NULL )";
            } else {
                $tSQLtFTPkgStaPrcDoc = " AND (PL.FTPkgStaPrcDoc = '$tFTPkgStaPrcDoc')";
            }
        }

        $tSQL = "SELECT c.* FROM(
					SELECT  ROW_NUMBER() OVER(ORDER BY FNPkgID DESC) AS RowID,* FROM 
					    (SELECT DISTINCT   
										PL.FNPkgID,
										PLL.FTPkgName,
										PL.FNTcgID,
										TGL.FTTcgName,
					    				PL.FNPkgMaxChkIn,
					    				PL.FNPkgMaxPark,
					    				PL.FTPkgType,
    			
										CASE PL.FTPkgStaLimitType
										  WHEN 1 THEN 'รายวัน'
										  WHEN 2 THEN 'รายเดือน'
										  WHEN 3 THEN 'รายปี'
										  ELSE 'ไม่ระบุ'
										END as FTPkgStaLimitType ,
										CONVERT(CHAR(10),PL.FDPkgStartChkIn,121) AS FDPkgStartChkIn,
										CONVERT(CHAR(8),PL.FDPkgStartChkIn, 108) As FTPkgStartChkIn,
										CONVERT(CHAR(10),PL.FDPkgStopChkIn,121) AS FDPkgStopChkIn,
										CONVERT(CHAR(8),PL.FDPkgStopChkIn, 108) As FTPkgStopChkIn,
										IP.FTImgObj,
					    				PL.FTPkgStaPrcDoc,
    									(SELECT COUNT (DISTINCT PL.FNPkgID) AS c FROM TTKTPkgList PL
	    									LEFT JOIN TTKTPkgPark PP ON PP.FNPkgID = PL.FNPkgID
											LEFT JOIN TTKTPkgList_L PLL ON PLL.FNPkgID = PL.FNPkgID AND PLL.FNLngID = " . $this->session->userdata("tLangEdit") . "
											LEFT JOIN TCNMImgObj IP ON IP.FTImgRefID = PL.FNPkgID AND IP.FTImgTable = 'TTKTPkgList'
											LEFT JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = PL.FNTcgID AND TGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
	    									WHERE 1 = 1 $tSQLtFTPkgPmoID $tSQLtFTPkgName $tSQLtFTPkgStaPrcDoc
    									) AS counts
					    			
					FROM TTKTPkgList PL
					LEFT JOIN TTKTPkgPark PP ON PP.FNPkgID = PL.FNPkgID
					LEFT JOIN TTKTPkgList_L PLL ON PLL.FNPkgID = PL.FNPkgID AND PLL.FNLngID = " . $this->session->userdata("tLangEdit") . "
					LEFT JOIN TCNMImgObj IP ON IP.FTImgRefID = PL.FNPkgID AND IP.FTImgTable = 'TTKTPkgList'
					LEFT JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = PL.FNTcgID AND TGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
    	
					WHERE 1 = 1";

        if ($tFTPkgPmoID != '') {
            $tSQL .= " AND (PP.FNPmoID = '$tFTPkgPmoID')";
        }

        if ($tFTPkgName != '') {
            $tSQL .= " AND (PLL.FTPkgName LIKE '%$tFTPkgName%')";
        }

        if ($tFTPkgStaPrcDoc != '') {

            if ($tFTPkgStaPrcDoc == 0) {
                $tSQL .= " AND (PL.FTPkgStaPrcDoc IS NULL )";
            } else {
                $tSQL .= " AND (PL.FTPkgStaPrcDoc = '$tFTPkgStaPrcDoc')";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }


       
    public function FSxMPKGGetModelList() {
        $tSQL = "SELECT BM.FTBchCode,MBL.FTBchName FROM
                TCNMBranch BM
                INNER JOIN TCNMBranch_L MBL ON MBL.FTBchCode = BM.FTBchCode AND MBL.FNLngID = '" . $this->session->userdata("tLangEdit") . "' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetProvinceList() {
        $tSQL = "SELECT P.FTPvnCode,PL.FTPvnName, * FROM TCNMProvince P
				 INNER JOIN TCNMProvince_L PL ON PL.FTPvnCode = P.FTPvnCode AND PL.FNLngID  = '" . $this->session->userdata("tLangEdit") . "'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetPkgProductList($nPkgID) {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY PPP.FNPkgID ASC) AS RowID,P.FNTcgID
    			 ,CASE 
					WHEN TG.FNPmoID IS NULL THEN '0' 
					ELSE '1' 
				  END as FNPmoID
    			 ,PPP.FNPkgPdtID
    			 ,PPP.FNPkgID
    			 ,PPP.FNPdtID
    			 ,PL.FTPdtName
    			 ,CONVERT(DECIMAL(20,2),PPP.FCPdtPrice) AS FCPdtPrice
    			 ,PPP.FNPdtMaxPerson 
    			 ,P.FNPdtOthSystem
				 FROM TTKTPkgPdtPri PPP
				 INNER JOIN TCNMPdtTicket P ON P.FNPdtID = PPP.FNPdtID 
				 INNER JOIN TCNMPdt_L PL ON PL.FTPdtCode = P.FTPdtCode AND PL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 INNER JOIN TTKMTchGroup TG ON TG.FNTcgID = P.FNTcgID
				 WHERE FNPkgID = '$nPkgID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetPkgGrpPriList($nPpkID) {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY FNPgpGrpID ASC) AS RowID,c.* FROM (
				 SELECT  PGP.FNPgpGrpID
					    ,PGP.FTPgpType
					    ,PGP.FNPgpRefID
					    ,AGL.FTAggName AS FTGrpName
					    ,CONVERT(DECIMAL(20,2),PGP.FCPgpPdtPrice) AS FCPgpPdtPrice 
				 FROM TTKTPkgGrpPri PGP
				 LEFT JOIN TCNMAgencyGrp_L AGL ON AGL.FTAggCode = PGP.FNPgpRefID AND AGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE FNPpkID = '$nPpkID'
				 AND PGP.FTPgpType = '1'
				 AND PGP.FNPkgPdtID IS NULL
				 UNION ALL
				 SELECT  PGP.FNPgpGrpID
					    ,PGP.FTPgpType
					    ,PGP.FNPgpRefID
					    ,CGL.FTCgpName AS FTGrpName
					    ,CONVERT(DECIMAL(20,2),PGP.FCPgpPdtPrice) AS FCPgpPdtPrice
				 FROM TTKTPkgGrpPri PGP
				 LEFT JOIN TTKMCstGrp_L CGL ON CGL.FNCgpID = PGP.FNPgpRefID AND CGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
				 WHERE FNPpkID = '$nPpkID'
				 AND PGP.FTPgpType = '2'
    			 AND PGP.FNPkgPdtID IS NULL) AS c";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetPkgPdtPriByGrpList($nPkgID, $nPkgPdtID) {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY FNPgpGrpID ASC) AS RowID,c.* FROM (
			    	SELECT  PGP.FNPgpGrpID
			    	,PGP.FTPgpType
			    	,PGP.FNPgpRefID
			    	,AGL.FTAggName AS FTGrpName
			    	,CONVERT(DECIMAL(20,2),PGP.FCPgpPdtPrice) AS FCPgpPdtPrice
			    	,PGP.FNPkgPdtID 
		    	FROM TTKTPkgGrpPri PGP
			    	LEFT JOIN TCNMAgencyGrp_L AGL ON AGL.FTAggCode = PGP.FNPgpRefID AND AGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
			    	WHERE FNPpkID = '$nPkgID'
			    	AND PGP.FTPgpType = '1'
			    	AND PGP.FNPkgPdtID = '$nPkgPdtID'
		    	UNION ALL
			    	SELECT  PGP.FNPgpGrpID
			    	,PGP.FTPgpType
			    	,PGP.FNPgpRefID
			    	,CGL.FTCgpName AS FTGrpName
			    	,CONVERT(DECIMAL(20,2),PGP.FCPgpPdtPrice) AS FCPgpPdtPrice
			    	,PGP.FNPkgPdtID 
		    	FROM TTKTPkgGrpPri PGP
			    	LEFT JOIN TTKMCstGrp_L CGL ON CGL.FNCgpID = PGP.FNPgpRefID AND CGL.FNLngID = " . $this->session->userdata("tLangEdit") . "
			    	WHERE FNPpkID = '$nPkgID'
			    	AND PGP.FTPgpType = '2'
			    	AND PGP.FNPkgPdtID = '$nPkgPdtID') AS c";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }


    public function FSxMPKGGetProductList() {
        $tSQL = "SELECT MB.FTBchCode,MBL.FTBchName FROM
			     TCNMBranch MB
			     INNER JOIN TCNMBranch_L MBL ON MBL.FTBchCode = MB.FTBchCode AND MBL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // FS Get ค่า TchGroup ออกมาเพื่อนำไปใช้ใน DropDown List
    public function FSxMPKGGetTchGroupList($nPkgID) {
        if ($nPkgID != '') {

            $More1Place = $this->JSxMPKGCheckPkgHaveModelCstMore1Place($nPkgID);
            $nNum = $More1Place [0]->counts;

            if ($nNum == '1') {
                $nMolID = $this->JSxPKGGetModelID($nPkgID);

                $nPmolID = $nMolID [0]->FNPmoID;

                $tSQL = "SELECT TG.FNTcgID,TGL.FTTcgName
	    			     FROM TTKMTchGroup TG
	    			 	 INNER JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = TG.FNTcgID AND TGL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
	    			 	 WHERE TG.FNPmoID IS NULL
						 OR TG.FNPmoID = '$nPmolID' ";
            } else {
                $tSQL = "SELECT TG.FNTcgID,TGL.FTTcgName
	    			     FROM TTKMTchGroup TG
	    			 	 INNER JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = TG.FNTcgID AND TGL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
	    			 	 WHERE TG.FNPmoID IS NULL";
            }
        } else {

            $tSQL = "SELECT TG.FNTcgID,TGL.FTTcgName,TG.FNPmoID,PDTML.FTPmoName
	    			     FROM TTKMTchGroup TG
	    			 	 INNER JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = TG.FNTcgID AND TGL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
	    				 LEFT JOIN TTKMPdtModel PDTM ON PDTM.FNPmoID = TG.FNPmoID 
						 LEFT JOIN TTKMPdtModel_L PDTML ON PDTML.FNPmoID = PDTM.FNPmoID AND PDTML.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
						 ORDER BY FNPmoID ASC";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // FS Get ข้อมูล Even
    public function FSxMPKGGetEvenList($dDateNow) {
        $tSQL = "SELECT EVN.FNEvnID,EVNL.FTEvnName 
					 FROM TTKMEvent EVN
					 LEFT JOIN TTKMEvent_L EVNL ON EVNL.FNEvnID = EVN.FNEvnID AND EVNL.FNLngID = 1
					 WHERE '$dDateNow' <= FDEvnFinish
    				 OR FTEvnStaExpire = 2";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // FS Get ค่า TchGroup ออกมาเพื่อนำไปใช้ใน DropDown List
    public function FSxMPKGGetTchGroupListPagePdt($nPmoID, $nPkgID) {
        if ($nPmoID != '') {
            $tSQL = "SELECT TG.FNTcgID,TGL.FTTcgName,TG.FNPmoID
	    			 FROM TTKMTchGroup TG
	    			 INNER JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = TG.FNTcgID AND TGL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
	    			 WHERE TG.FNPmoID = '$nPmoID' OR TG.FNPmoID IS NULL
    				 ORDER BY TG.FNPmoID";
        } else {
            $tSQL = "SELECT TG.FNTcgID,TGL.FTTcgName,TG.FNPmoID
	    			 FROM TTKMTchGroup TG
	    			 INNER JOIN TTKMTchGroup_L TGL ON TGL.FNTcgID = TG.FNTcgID AND TGL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
	    			 WHERE TG.FNPmoID IS NULL";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function JSxPKGGetModelID($nPkgID) {
        $tSQL = "SELECT FNPmoID
			     FROM TTKTPkgPark
			     WHERE FNPkgID = '$nPkgID'
			     AND FTPpkType = '1'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function JSxMPKGCheckPkgHaveModelCstMore1Place($pnPkgID) {
        $tSQL = "SELECT COUNT(DISTINCT FNPmoID) AS counts
			     FROM TTKTPkgPark
			     WHERE FNPkgID = '$pnPkgID'
			     AND FTPpkType = '1'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function JSxMPKGGetFNPkgMaxPark($pnPkgID) {
        $tSQL = "SELECT FNPkgMaxPark FROM TTKTPkgList
				 WHERE FNPkgID = '$pnPkgID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGApprovePkgSave($nPkgID, $aDataStaApv) {
        $this->db->where('FNPkgID', $nPkgID);
        $tDB = $this->db->update('TTKTPkgList', array(
            'FTPkgStaPrcDoc' => $aDataStaApv ['FTPkgStaPrcDoc']
                ));

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
            ;
        }
    }

    public function FSxMPKGGetSelectPdtHTML($pnTchID, $nPkgID, $nPkgType) {

        // หา BookingType ของ Zone ที่มีใน Pkg
        $oBookingType = $this->FSnMPKGCheckPkgHaveZone($nPkgID);

        if (isset($oBookingType [0]->FTZneBookingType)) {
            $nBookingType = $oBookingType [0]->FTZneBookingType;
        } else {
            $nBookingType = '';
        }

        // ถ้าเป็น Type เท่ากับ 1 = Seat เป็นที่นั่งจะไม่มีสินค้าประเภท Room
        if ($nBookingType == '1') {

            $tSQL = "SELECT P.FNPdtID,P.FTPdtCode,PL.FTPdtName,PL.FTPdtNameOth,P.FNPdtOthSystem
		    	 	 FROM TCNMPdtTicket P
		    	 	 INNER JOIN TCNMPdt_L PL ON PL.FTPdtCode = P.FTPdtCode
		    		 WHERE P.FNTcgID = '$pnTchID'
		    		 AND PL.FNLngID = " . $this->session->userdata("tLangEdit") . "
    				 AND P.FNPdtOthSystem NOT IN ('1','3','4')";

            // ถ้าเป็น Type 1 : ใช้ราคาตามสินค้า จะไม่แสดง สินค้าทั่วไป type : 0
            if ($nPkgType == '1') {
                $tSQL .= "AND P.FNPdtOthSystem NOT IN ('0')";
            }
        } else if ($nBookingType == '2') {

            $tSQL = "SELECT P.FNPdtID,P.FTPdtCode,PL.FTPdtName,PL.FTPdtNameOth,P.FNPdtOthSystem
		    		 FROM TCNMPdtTicket P
		    		 INNER JOIN TCNMPdt_L PL ON PL.FTPdtCode = P.FTPdtCode
		    		 WHERE P.FNTcgID = '$pnTchID'
		    		 AND PL.FNLngID = " . $this->session->userdata("tLangEdit") . "
		    		 AND P.FNPdtOthSystem NOT IN ('1','3','5')";

            // ถ้าเป็น Type 1 : ใช้ราคาตามสินค้า จะไม่แสดง สินค้าทั่วไป type : 0
            if ($nPkgType == '1') {
                $tSQL .= "AND P.FNPdtOthSystem NOT IN ('0')";
            }
        } else if ($nBookingType == '3') {

            $tSQL = "SELECT P.FNPdtID,P.FTPdtCode,PL.FTPdtName,PL.FTPdtNameOth,P.FNPdtOthSystem
		    		 FROM TCNMPdtTicket P
		    		 INNER JOIN TCNMPdt_L PL ON PL.FTPdtCode = P.FTPdtCode
		    		 WHERE P.FNTcgID = '$pnTchID'
		    		 AND PL.FNLngID = " . $this->session->userdata("tLangEdit") . "
		    		 AND P.FNPdtOthSystem NOT IN ('1','3','4','5')";

            // ถ้าเป็น Type 1 : ใช้ราคาตามสินค้า จะไม่แสดง สินค้าทั่วไป type : 0
            if ($nPkgType == '1') {
                $tSQL .= "AND P.FNPdtOthSystem NOT IN ('0')";
            }
        } else {

            $tSQL = "SELECT P.FNPdtID,P.FTPdtCode,PL.FTPdtName,PL.FTPdtNameOth,P.FNPdtOthSystem
		    		 FROM TCNMPdtTicket P
		    		 INNER JOIN TCNMPdt_L PL ON PL.FTPdtCode = P.FTPdtCode
		    		 WHERE P.FNTcgID = '$pnTchID'
		    		 AND PL.FNLngID = " . $this->session->userdata("tLangEdit") . "";

            // ถ้าเป็น Type 1 : ใช้ราคาตามสินค้า จะไม่แสดง สินค้าทั่วไป type : 0
            if ($nPkgType == '1') {
                $tSQL .= "AND P.FNPdtOthSystem NOT IN ('0')";
            }
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetSelectPkgGrpPriAgencyHTML() {
        $tSQL = "SELECT AG.FTAggCode
					   ,AGL.FTAggName 
				 FROM TCNMAgencyGrp AG
				 INNER JOIN TCNMAgencyGrp_L AGL ON AGL.FTAggCode = AG.FTAggCode AND AGL.FNLngID = " . $this->session->userdata("tLangEdit") . "";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSoMPKGGetSelectPkgGrpPriCustomerHTML() {
        $tSQL = "SELECT CG.FNCgpID
			    	   ,CSTL.FTCgpName,* 
				 FROM  TTKMCstGrp CG
		 		 INNER JOIN TTKMCstGrp_L CSTL ON CSTL.FNCgpID = CG.FNCgpID AND CSTL.FNLngID = " . $this->session->userdata("tLangEdit") . "";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGGetSelectProvinceHTML($nPvnID) {
        $tSQL = "SELECT DISTINCT LOC.FNPmoID,PML.FTBchName FROM TTKMLocProvince LPV  
				 INNER JOIN TTKMLocation LOC ON LPV.FNLocID = LOC.FNLocID
				 INNER JOIN TCNMBranch PM ON PM.FTBchCode = LOC.FNPmoID
				 INNER JOIN TCNMBranch_L PML ON PML.FTBchCode = PM.FTBchCode AND PML.FNLngID = " . $this->session->userdata("tLangEdit") . "
			     WHERE LPV.FNPvnID = '$nPvnID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGDelete($pnPkgId) {
        $this->db->where('FNPkgID', $pnPkgId);
        $this->db->delete('TTKTPkgList');

        $this->db->where('FNPkgID', $pnPkgId);
        $this->db->delete('TTKTPkgList_L');

        $this->db->where('FNImgRefID', $pnPkgId);
        $this->db->where('FTImgType', '4');
        $this->db->delete('TCNMImgObj');

        $this->db->where('FNPkgID', $pnPkgId);
        $this->db->delete('TTKTPkgPark');

        return 1;
    }

    public function FSxMPKGDelPkgNoPdt($pnPkgId) {
        $this->db->where('FNPkgID', $pnPkgId);
        $this->db->delete('TTKTPkgList');

        $this->db->where('FNPkgID', $pnPkgId);
        $this->db->delete('TTKTPkgList_L');

        $this->db->where('FTImgRefID', $pnPkgId);
        $this->db->where('FTImgTable', 'TTKTPkgList');
        $this->db->delete('TCNMImgObj');

        return 1;
    }

    public function FSxMPKGDelAllFNPkgPdtID($pnPkgPdtID) {
        $this->db->where('FNPkgPdtID', $pnPkgPdtID);
        $this->db->delete('TTKTPkgGrpPri');

        $this->db->where('FNPkgPdtID', $pnPkgPdtID);
        $this->db->delete('TTKMPdtPriDOW');

        $this->db->where('FNPkgPdtID', $nPkgPdtID);
        $this->db->delete('TTKMPdtPriBooking');

        $this->db->where('FNPkgPdtID', $nPkgPdtID);
        $this->db->delete('TTKMPdtPriHoliday');

        return 1;
    }

    public function FSnMPKGGetPkgPdtID($nPkgID) {
        $tSQL = "SELECT DISTINCT FNPkgPdtID FROM TTKTPkgGrpPri
		    	 WHERE FNPpkID = '$nPkgID'
		    	 AND FNPkgPdtID IS NOT NULL";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    private function FCNaMPRKCallLenData($pnPerPage, $pnPage) {
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

    public function FSxMPKGAuthen() {
        $tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '7' AND FNGahID = '" . $this->session->userdata("FNGahID") . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckMaxPark($nPkgID) {
        $tSQL = "SELECT ZNE.FTZneBookingType 
					  FROM TTKTPkgPark AS PRK				 
					  LEFT JOIN TTKMLocZone AS ZNE ON ZNE.FNZneID = PRK.FNZneID					
					  WHERE PRK.FNPkgID = '$nPkgID' AND PRK.FNZneID IS NOT NULL";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckTypePkg($nPkgID) {
        $tSQL = "SELECT FTPkgStaLimitBy
		FROM TTKTPkgList
		WHERE FNPkgID = '$nPkgID'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMPKGCheckZonePkg($nPkgID) {
        $tSQL = "SELECT ZNE.FTZneBookingType
				 FROM TTKTPkgPark AS PRK
				 LEFT JOIN TTKMLocZone AS ZNE ON ZNE.FNZneID = PRK.FNZneID
				 WHERE PRK.FNPkgID = '$nPkgID' AND PRK.FNZneID IS NOT NULL";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // @Natt Add Function
    public function FSxMPKGUpdateMaxPark($nPkgID) {
        $this->db->where('FNPkgID', $nPkgID);
        $this->db->update('TTKTPkgList', array(
            'FNPkgMaxPark' => '1'
        ));
    }

    public function FSxCPKGCheckZoneType($nPkgID) {
        $tSQL = "SELECT ZNE.FTZneBookingType
				 FROM TTKTPkgPark AS PRK
			     LEFT JOIN TTKMLocZone AS ZNE ON ZNE.FNZneID = PRK.FNZneID
				 WHERE PRK.FNPkgID = '$nPkgID' AND PRK.FNZneID IS NOT NULL";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

}
