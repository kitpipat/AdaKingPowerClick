<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mZone extends CI_Model {
	public $nZneID;
	private function FCNaMZNECallLenData($pnPerPage, $pnPage) {
		$nPerPage = $pnPerPage;
		if (isset ( $pnPage )) {
			$nPage = $pnPage;
		} else {
			$nPage = 1;
		}
		$nRowStart = (($nPerPage * $nPage) - $nPerPage);
		$nRowEnd = $nPerPage * $nPage;
		$aLenData = array (
				$nRowStart,
				$nRowEnd 
		);
		return $aLenData;
	}
	
	/**
	 * Zone
	 */
	public function FSxCZNEList($tFTZneName, $nLocID, $nPageNo = 1) {
		$aRowLen = $this->FCNaMZNECallLenData ( 5, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSqlZneName = '';
		if ($tFTZneName != '') {
			$tSqlZneName = " AND TTKMLocZone_L.FTZneName LIKE '%$tFTZneName%'";
		}
		$tSQL = "SELECT c.*,s.FNZneID AS FNStaSeat
				 FROM( SELECT ROW_NUMBER() OVER(ORDER BY TTKMLocZone.FNZneID DESC) AS RowID, 
							TTKMLocZone.*, 
							TTKMLocZone_L.FTZneName, 
							TTKMLocLevel_L.FTLevName, 
							Img.FTImgObj, 
							Img.FNImgID							
							FROM TTKMLocZone 
							LEFT JOIN TTKMLocZone_L ON TTKMLocZone_L.FNZneID = TTKMLocZone.FNZneID AND TTKMLocZone_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "' 
							LEFT JOIN TTKMLocLevel ON TTKMLocLevel.FNLevID = TTKMLocZone.FNLevID AND TTKMLocLevel.FNLocID = '$nLocID'
							LEFT JOIN TTKMLocLevel_L ON TTKMLocLevel_L.FNLevID = TTKMLocLevel.FNLevID AND TTKMLocLevel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "' 
							LEFT JOIN TCNMImgObj AS Img ON Img.FTImgRefID = TTKMLocZone.FNZneID AND Img.FTImgTable= 'TTKMLocZone' AND Img.FNImgSeq = 1
							WHERE TTKMLocZone.FNLocID = '$nLocID' $tSqlZneName) AS c 
				      LEFT JOIN(SELECT DISTINCT FNZneID FROM TTKMLocSeat WHERE FNLocID = '" . $nLocID . "') as s
				      ON c.FNZneID = s.FNZneID
				 WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMZNECount($tFTZneName, $nLocID) {
		$tSQL = "SELECT COUNT(TTKMLocZone.FNZneID) AS counts
				 FROM TTKMLocZone
				 LEFT JOIN TTKMLocZone_L ON TTKMLocZone_L.FNZneID = TTKMLocZone.FNZneID
				 AND TTKMLocZone_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE TTKMLocZone.FNLocID = $nLocID";
		if ($tFTZneName != '') {
			$tSQL .= " AND TTKMLocZone_L.FTZneName LIKE '%$tFTZneName%'";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	
	/**
	 * Add Zone
	 */
	public function FSxMZNEAdd($tData) {
		$this->db->insert ( 'TTKMLocZone', array (
				'FNLevID' => $tData ['FNLevID'],
				'FNLocID' => $tData ['FNLocID'],
				'FTZneBookingType' => $tData ['FTZneBookingType'],
				'FNZneRow' => $tData ['FNZneRow'],
				'FNZneCol' => $tData ['FNZneCol'],
				'FNZneRowStart' => $tData ['FNZneRowStart'],
				'FNZneColStart' => $tData ['FNZneColStart'],
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$this->nZneID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMLocZone_L', array (
				'FNZneID' => $this->nZneID,
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FTZneName' => $tData ['FTZneName'],
				'FTZneRmk' => $tData ['FTZneRmk'] 
		) );

		return $this->nZneID;
	}
	
	/**
	 * Add Seat
	 */
	public function FSxMZNEAddSeat($tData) {
		$this->db->insert ( 'TTKMLocSeat', array (
				'FNZneID' => $tData ['FNZneID'],
				'FNLevID' => $tData ['FNLevID'],
				'FNLocID' => $tData ['FNLocID'],
				'FTSetRowChr' => $tData ['FTSetRowChr'],
				'FNSetRowSeq' => $tData ['FNSetRowSeq'],
				'FTSetColChr' => $tData ['FTSetColChr'],
				'FNSetColSeq' => $tData ['FNSetColSeq'],
				'FTSetStaAlw' => $tData ['FTSetStaAlw'] 
		) );
		$nSetID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMLocSeat_L', array (
				'FNSetID' => $nSetID,
				'FTSetName' => $tData ['FTSetName'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
		) );
	}
	public function FSxMZneEdit($aData) {
		$this->db->where ( 'FNZneID', $aData ['FNZneID'] );
		$tDB = $this->db->update ( 'TTKMLocZone', array (
				'FNLevID' => $aData ['FNLevID'],
				'FNZneRow' => $aData ['FNZneRow'],
				'FNZneCol' => $aData ['FNZneCol'],
				'FNZneRowStart' => $aData ['FNZneRowStart'],
				'FNZneColStart' => $aData ['FNZneColStart'],
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		$nChk = FSnCheckUpdateLang ( 'TTKMLocZone_L', 'FNZneID', $aData ['FNZneID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMLocZone_L', array (
					'FNZneID' => $aData ['FNZneID'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ),
					'FTZneName' => $aData ['FTZneName'],
					'FTZneRmk' => $aData ['FTZneRmk'] 
			) );
		} else {
			$this->db->where ( 'FNZneID', $aData ['FNZneID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMLocZone_L', array (
					'FTZneName' => $aData ['FTZneName'],
					'FTZneRmk' => $aData ['FTZneRmk'] 
			) );
		}
	}
	public function FSxMZNEEditSeat($tData) {
		$this->db->where ( 'FNSetID', $tData ['FNSetID'] );
		$tDB = $this->db->update ( 'TTKMLocSeat', array (
				'FTSetStaAlw' => $tData ['FTSetStaAlw'] 
		) );
		/*
		 * $this->db->where('FNSetID', $tData ['FNSetID']);
		 * $tDB = $this->db->update('TTKMLocSeat_L', array(
		 * 'FTSetName' => $tData ['FTSetName'],
		 * 'FNLngID' => '1'
		 * ));
		 */
	}
	public function FSxMZNEEditRowChr($aData) {
		$this->db->where ( 'FTSetRowChr', $aData ['ohdFTSetRowChr'] );
		$this->db->where ( 'FNLocID', $aData ['FNLocID'] );
		$this->db->where ( 'FNLevID', $aData ['FNLevID'] );
		$this->db->where ( 'FNZneID', $aData ['FNZneID'] );
		$this->db->where ( 'FNSetID', $aData ['FNSetID'] );
		$this->db->update ( 'TTKMLocSeat', array (
				'FTSetRowChr' => $aData ['FTSetRowChr'] 
		) );
		
		$this->db->where ( 'FNSetID', $aData ['FNSetID'] );
		$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
		$this->db->update ( 'TTKMLocSeat_L', array (
				'FTSetName' => $aData ['FTSetName'] 
		) );
	}
	public function FSxMZNEEditColChr($tData) {
		$this->db->where ( 'FNSetColSeq', $tData ['FNSetColSeq'] );
		$this->db->where ( 'FNLocID', $tData ['FNLocID'] );
		$this->db->where ( 'FNLevID', $tData ['FNLevID'] );
		$this->db->where ( 'FNZneID', $tData ['FNZneID'] );
		$this->db->update ( 'TTKMLocSeat', array (
				'FTSetColChr' => $tData ['FTSetColChr'] 
		) );
	}
	public function FSxMZneDel($aData) {
		$tSQL = "SELECT COUNT(GTE.FNGteID) AS count1, COUNT(PKG.FNPpkID) AS count2, COUNT(ROM.FNRomID) AS count3
				 FROM TTKMLocZone AS ZNE				
				 LEFT JOIN TTKMLocGate AS GTE ON ZNE.FNZneID = GTE.FNZneID	
				 LEFT JOIN TTKTPkgPark AS PKG ON ZNE.FNZneID = PKG.FNZneID				
				 LEFT JOIN TTKMLocRoom AS ROM ON ZNE.FNZneID = ROM.FNZneID					
		         WHERE ZNE.FNZneID = '" . $aData ['FNZneID'] . "'
		        ";
		$query = $this->db->query ( $tSQL );
		$oResult = $query->result ();		
		if ($oResult [0]->count1 >= 1 || $oResult [0]->count2 >= 1 || $oResult [0]->count3 >= 1) {
			return 1;
		} else {
			$this->db->where ( 'FNZneID', $aData ['FNZneID'] );
			$this->db->delete ( 'TTKMLocZone' );			
			$this->db->where ( 'FNZneID', $aData ['FNZneID'] );
			$this->db->delete ( 'TTKMLocZone_L' );
			$tSQL = "DELETE FROM TTKMLocSeat_L WHERE FNSetID IN(
							SELECT FNSetID FROM TTKMLocSeat WHERE FNZneID = '".$aData ['FNZneID']."'
			        )";			
			$this->db->query ( $tSQL );		
			$this->db->where ( 'FNZneID', $aData ['FNZneID'] );
			$this->db->delete ( 'TTKMLocSeat' );			
			return 0;
		}
	}
	
	// หน้าโซน โหลดชั้น id
	public function FSxMZNELoadLev($tID) {
		$tSQL = "SELECT TTKMLocLevel.*,TTKMLocLevel_L.FTLevName 
		FROM TTKMLocLevel 
		LEFT JOIN TTKMLocLevel_L ON TTKMLocLevel_L.FNLevID = TTKMLocLevel.FNLevID AND TTKMLocLevel_L.FNLngID = " . $this->session->userdata ( "tLangEdit" ) . " 	
		WHERE TTKMLocLevel.FNLocID = $tID		
		";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNEShow($aData) {
		$tSQL = "SELECT DISTINCT FTSetColChr, FNSetColSeq
				 FROM TTKMLocSeat
				 WHERE FNLocID = " . $aData ['FNLocID'] . " AND FNLevID = " . $aData ['FNLevID'] . " AND FNZneID = " . $aData ['FNZneID'] . " order by FNSetColSeq asc";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNESeat($aData) {
		$tSQL = "SELECT DISTINCT FNSetRowSeq, FTSetRowChr, FNLocID, FNLevID, FNZneID
				 FROM TTKMLocSeat
				 WHERE TTKMLocSeat.FNLocID = " . $aData ['FNLocID'] . " AND TTKMLocSeat.FNZneID = " . $aData ['FNZneID'] . "";
		
		if ($aData ['FNLevID'] != 0) {
			$tSQL .= " AND TTKMLocSeat.FNLevID = " . $aData ['FNLevID'] . "";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNEShowSeat($tFNSetRowSeq, $tFTSetRowChr, $tFNLocID, $tFNLevID, $tFNZneID) {
		$tSQL = "SELECT TTKMLocSeat.*, TTKMLocSeat_L.FTSetName
				 FROM TTKMLocSeat				 
				 LEFT JOIN TTKMLocSeat_L ON TTKMLocSeat_L.FNSetID = TTKMLocSeat.FNSetID AND TTKMLocSeat_L.FNLngID = " . $this->session->userdata ( "tLangEdit" ) . "				 
				 WHERE TTKMLocSeat.FNSetRowSeq = " . $tFNSetRowSeq . " 
				 AND TTKMLocSeat.FTSetRowChr = '" . $tFTSetRowChr . "' 
				 AND TTKMLocSeat.FNLocID = " . $tFNLocID . " 
				 AND TTKMLocSeat.FNLevID = " . $tFNLevID . " 
				 AND TTKMLocSeat.FNZneID = " . $tFNZneID . "";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSnMZNECheck($tData) {
		if ($tData ['FNLevID'] == '0') {
			$tFNLevID = "";
		} else {
			$tFNLevID = "(TTKMLocZone.FNLevID = '" . $tData ['FNLevID'] . "') AND";
		}
		
		$tSQL = "SELECT COUNT(TTKMLocZone.FNZneID) AS counts
		FROM TTKMLocZone
		LEFT JOIN TTKMLocZone_L ON TTKMLocZone_L.FNZneID = TTKMLocZone.FNZneID
		AND TTKMLocZone_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
		WHERE $tFNLevID TTKMLocZone.FNLocID = '" . $tData ['FNLocID'] . "' AND TTKMLocZone_L.FTZneName = '" . $tData ['FTZneName'] . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNEViewSet($aData) {
		$tSQL = "SELECT *
		FROM TTKMLocSeat
		WHERE FNSetID = " . $aData ['FNSetID'] . "";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMZNECheckSeat($tData) {
		$tSQL = "SELECT COUNT(TTKMLocSeat.FNSetID) AS counts
				FROM TTKMLocSeat
    			WHERE FNLocID = " . $tData ['FNLocID'] . " AND FNLevID = " . $tData ['FNLevID'] . " AND FNZneID = " . $tData ['FNZneID'] . " AND FTSetRowChr = '" . $tData ['FTSetRowChr'] . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMZNECheckEdtSeat($tData) {
		$tSQL = "SELECT COUNT(TTKMLocSeat.FNSetID) AS counts
		FROM TTKMLocSeat
		LEFT JOIN TTKMLocSeat_L ON TTKMLocSeat_L.FNSetID = TTKMLocSeat.FNSetID    	
		AND TTKMLocSeat_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'		
		WHERE TTKMLocSeat.FNLocID = '" . $tData ['FNLocID'] . "' AND TTKMLocSeat.FNLevID = '" . $tData ['FNLevID'] . "' AND TTKMLocSeat.FNZneID = '" . $tData ['FNZneID'] . "' AND TTKMLocSeat_L.FTSetName = '" . $tData ['FTSetName'] . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNEHeader($nLocID) {
		$tSQL = "SELECT LOC.*, LOCL.FTLocName, MODL.FTBchName, OBJ.FTImgObj 
				 FROM TTKMLocation AS LOC 
				 LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = LOC.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 LEFT JOIN TCNMBranch_L AS MODL ON MODL.FTBchCode = LOC.FNPmoID AND MODL.FNLngID= '" . $this->session->userdata ( "tLangEdit" ) . "'
<<<<<<< HEAD
    			 LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = LOC.FNLocID AND OBJ.FTImgTable = 'TTKMLocZone' AND OBJ.FTImgKey = 'main'
=======
    			 LEFT JOIN TCNMImgObj AS OBJ ON OBJ.FTImgRefID = LOC.FNLocID AND OBJ.FTImgTable = 'TTKMLocation' AND OBJ.FTImgKey = 'main' 
>>>>>>> 81bf17ac4472cccb47e9b8a7fad9daddc4181c76
    			 WHERE LOC.FNLocID = '$nLocID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNEArea($nLocID) {
		$tSQL = "SELECT LPV.*, PVL.FTPvnName, DTL.FTDstName
				 FROM TTKMLocProvince AS LPV
    			 LEFT JOIN TCNMProvince_L AS PVL ON PVL.FTPvnCode = LPV.FNPvnID AND PVL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
    			 LEFT JOIN TCNMDistrict_L AS DTL ON DTL.FTDstCode = LPV.FNDstID AND DTL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        			 WHERE LPV.FNLocID = '$nLocID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNEShowEdit($nZneID) {
		$tSQL = "SELECT ZNE.*, ZEL.FTZneName,ZEL.FTZneRmk, Img.FTImgObj, Img.FNImgID
				 FROM TTKMLocZone AS ZNE
    			 LEFT JOIN TTKMLocZone_L AS ZEL ON ZEL.FNZneID = ZNE.FNZneID AND ZEL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'    			 
    			 LEFT JOIN TCNMImgObj AS Img ON Img.FTImgRefID = ZNE.FNZneID AND Img.FTImgTable = 'TTKMLocZone' AND Img.FNImgSeq = 1	 
				 WHERE ZNE.FNZneID = '$nZneID'";
		
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function FSxMZNEUpdateImg($aData) {
		$oImg = FSnCheckImg ( 'TCNMImgObj', 'FTImgRefID', $aData ['FNZneID'], '3' );
		if ($oImg [0]->counts == 0) {
			$this->db->insert ( 'TCNMImgObj', array (
					'FTImgRefID' => $aData ['FNZneID'],
					'FTImgObj' => $aData ['FTImgObj'],
					'FTImgType' => '3',
					'FNImgSeq' => 1 
			) );
		} else {
			$this->db->where ( 'FTImgRefID', $aData ['FNZneID'] );
			$this->db->where ( 'FTImgType', '3' );
			$this->db->where ( 'FNImgSeq', '1' );
			$this->db->update ( 'TTKMImgObj', array (
					'FTImgObj' => $aData ['FTImgObj'] 
			) );
		}
	}
	public function FSxMZNEAddImg($aData) {
		$this->db->insert ( 'TTKMImgObj', array (
				'FTImgRefID' => $this->nZneID,
				'FTImgObj' => $aData ['FTImgObj'],
				'FTImgType' => '3',
				'FNImgSeq' => 1 
		) );
	}
	public function FSxMZNECheckAmountSeat($aData) {
		$tSQL = "SELECT FNSetID, FNSetRowSeq
				 FROM TTKMLocSeat
				 WHERE FNLocID = '" . $aData ['FNLocID'] . "' AND FNLevID = '" . $aData ['FNLevID'] . "' AND FNZneID = '" . $aData ['FNZneID'] . "' AND FTSetRowChr  = '" . $aData ['FNSetRowChr'] . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMZNEColStart($aData) {
		$tSQL = "SELECT *
				 FROM TTKMLocZone
				 WHERE FNLocID = '" . $aData ['FNLocID'] . "' AND FNLevID = '" . $aData ['FNLevID'] . "' AND FNZneID = '" . $aData ['FNZneID'] . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
}
?>

