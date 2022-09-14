<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mLevel extends CI_Model {
	private function FCNaMLVLCallLenData($pnPerPage, $pnPage) {
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
	public function FSaMLVLList($tFTLvlName, $nLocID, $nPageNo = 1) {
		$aRowLen = $this->FCNaMLVLCallLenData ( 5, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSqlLvlName = '';
		if ($tFTLvlName != '') {
			$tSqlLvlName = " AND TTKMLocLevel_L.FTLevName LIKE '%$tFTLvlName%'";
		}
		$tSQL = "SELECT c.* FROM(
					SELECT ROW_NUMBER() OVER(ORDER BY TTKMLocLevel.FNLevID DESC) AS RowID,	
					TTKMLocLevel.*, 
					TTKMLocLevel_L.FTLevName					
					FROM TTKMLocLevel
					LEFT JOIN TTKMLocLevel_L ON TTKMLocLevel_L.FNLevID = TTKMLocLevel.FNLevID 
					AND TTKMLocLevel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "' 
					
					WHERE TTKMLocLevel.FNLocID = '" . $nLocID . "' $tSqlLvlName";
		
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMLVLCount($tFTLvlName, $nLocID) {
		$tSQL = "SELECT COUNT(TTKMLocLevel.FNLevID) AS counts 
				 FROM TTKMLocLevel 
				 LEFT JOIN TTKMLocLevel_L ON TTKMLocLevel_L.FNLevID = TTKMLocLevel.FNLevID 				 
				 AND TTKMLocLevel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "' 				 
				 WHERE TTKMLocLevel.FNLocID = $nLocID";
		
		if ($tFTLvlName != '') {
			$tSQL .= " AND TTKMLocLevel_L.FTLevName LIKE '%$tFTLvlName%'";
		}
		
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMLVLAdd($tData) {
		// TTKMLocLevel
		$tDB = $this->db->insert ( 'TTKMLocLevel', array (
				'FNLocID' => $tData ['FNLocID'],
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$tLvlID = $this->db->insert_id ();
		
		// TTKMLocLevel_L
		$this->db->insert ( 'TTKMLocLevel_L', array (
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FNLevID' => $tLvlID,
				'FTLevName' => $tData ['FTLevName'] 
		) );
		return $tLvlID;
		
	}
	public function FSxMLVLEdit($aData) {
		// TTKMLocLevel
		$this->db->where ( 'FNLevID', $aData ['FNLevID'] );
		$this->db->update ( 'TTKMLocLevel', array (
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		$nChk = FSnCheckUpdateLang ( 'TTKMLocLevel_L', 'FNLevID', $aData ['FNLevID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMLocLevel_L', array (
					'FNLngID' => $this->session->userdata ( "tLangEdit" ),
					'FNLevID' => $aData ['FNLevID'],
					'FTLevName' => $aData ['FTLevName'] 
			) );
		} else {
			$this->db->where ( 'FNLevID', $aData ['FNLevID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMLocLevel_L', array (
					'FTLevName' => $aData ['FTLevName'] 
			) );
		}
	}
	public function FSxMLVLDel($aData) {
		$tSQL = "SELECT COUNT(ZNE.FNZneID) AS count1, COUNT(ROM.FNRomID) AS count2
				 FROM TTKMLocLevel AS LEV
			     LEFT JOIN TTKMLocZone AS ZNE ON LEV.FNLevID = ZNE.FNLevID		
			     LEFT JOIN TTKMLocRoom AS ROM ON LEV.FNLevID = ROM.FNLevID
				 WHERE LEV.FNLevID = '" . $aData ['FNLevID'] . "'
		        ";
		$query = $this->db->query ( $tSQL );
		$oResult = $query->result ();
		if ($oResult [0]->count1 >= 1 || $oResult [0]->count2 >= 1) {
			return 1;
		} else {
			$this->db->where ( 'FNLevID', $aData ['FNLevID'] );
			$this->db->delete ( 'TTKMLocLevel' );
			$this->db->where ( 'FNLevID', $aData ['FNLevID'] );
			$this->db->delete ( 'TTKMLocLevel_L' );
			return 0;			
		}
	}
	public function FStMLvlCheck($tData) {
		$tSQL = "SELECT COUNT(TTKMLocLevel.FNLevID) AS counts
				 FROM TTKMLocLevel
				 LEFT JOIN TTKMLocLevel_L ON TTKMLocLevel_L.FNLevID = TTKMLocLevel.FNLevID
				 AND TTKMLocLevel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
    			 WHERE TTKMLocLevel.FNLocID = '" . $tData ['FNLocID'] . "' AND TTKMLocLevel_L.FTLevName = '" . $tData ['FTLevName'] . "'";		
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMLVLHeader($nLocID) {
		$tSQL = "SELECT LOC.*, LOCL.FTLocName, MODL.FTBchName, OBJ.FTImgObj    			
				 FROM TTKMLocation AS LOC
				 LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = LOC.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 LEFT JOIN TCNMBranch_L AS MODL ON MODL.FTBchCode = LOC.FNPmoID AND MODL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
<<<<<<< HEAD
    			 LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FNImgRefID = LOC.FNLocID AND OBJ.FTImgType = '2' AND OBJ.FTImgKey = 'main'   	
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
	public function FSxMLVLArea($nLocID) {
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
	public function FSxMLVLShowEdit($nLvlID) {
		$tSQL = "SELECT *
				 FROM TTKMLocLevel_L    			
    			 WHERE FNLevID = '$nLvlID' AND FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
    			";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
}

?>
