<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mBranch extends CI_Model {
	public $PdtModelID;
	public $tLocID;
	private function FCNaMPRKCallLenData($pnPerPage, $pnPage) {
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
	public function FSaMPRKCount() {
		$tSQL = "SELECT COUNT(FNPmoID) AS counts FROM TTKMPdtModel";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSaMPRKSearchCount($tFTPmoName) {
		$tSQL = "SELECT COUNT(TTKMPdtModel.FNPmoID) AS counts 
				 FROM TTKMPdtModel 
				 LEFT JOIN TTKMPdtModel_L ON TTKMPdtModel_L.FNPmoID = TTKMPdtModel.FNPmoID AND TTKMPdtModel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE 1=1
				";
		if ($tFTPmoName != '') {
			$tSQL .= " AND (TTKMPdtModel_L.FTPmoName LIKE '%$tFTPmoName%')";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	// ดึงข้อมูล Agency
	public function FSaMPRKList($tFTPmoName, $nPageNo = 1) {
		$aRowLen = $this->FCNaMPRKCallLenData ( 8, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSQL = "SELECT c.* FROM(
					SELECT ROW_NUMBER() OVER(ORDER BY TTKMPdtModel.FNPmoID DESC) AS RowID,
					TTKMPdtModel.FNPmoID,
					TTKMImgPdt.FTImgObj,
					TTKMImgPdt.FTImgType,
					TTKMPdtModel_L.FTPmoName,
					TTKMPdtModel_L.FNLngID
					FROM TTKMPdtModel
					LEFT JOIN TTKMImgPdt ON TTKMImgPdt.FNImgRefID = TTKMPdtModel.FNPmoID AND TTKMImgPdt.FTImgType = '1'
					LEFT JOIN TTKMPdtModel_L ON TTKMPdtModel_L.FNPmoID = TTKMPdtModel.FNPmoID AND TTKMPdtModel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
					";
		if ($tFTPmoName != '') {
			$tSQL .= " WHERE (TTKMPdtModel_L.FTPmoName LIKE '%$tFTPmoName%')";
		}
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKModel() {
		$this->db->select ( 'Model.*, ModelL.*' );
		$this->db->from ( 'TTKMPdtModel AS Model' );
		$this->db->join ( 'TTKMPdtModel_L AS ModelL', 'ModelL.FNPmoID = Model.FNPmoID', 'LEFT' );
		$this->db->where ( 'ModelL.FNLngID', $this->session->userdata ( "tLangEdit" ) );
		$oQuery = $this->db->get ();
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKSave($paParkData) {
		$tDB = $this->db->insert ( 'TTKMPdtModel', $paParkData );
		$this->PdtModelID = $this->db->insert_id ();
		return $this->PdtModelID;
	}
	public function FSxMPRKSaveModelL($aData) {
		$tDB = $this->db->insert ( 'TTKMPdtModel_L', array (
				'FNPmoID' => $this->PdtModelID,
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FTPmoName' => $aData ['FTPmoName'],
				'FTPmoNameOth' => $aData ['FTPmoNameOth'] 
		) );
	}
	public function FSxMPRKEdit($paParkData) {
		$this->db->where ( 'FNPmoID', $paParkData ['FNPmoID'] );
		$this->db->update ( 'TTKMPdtModel', array (
				'FTWhoUpd' => $paParkData ['FTWhoUpd'],
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		/*
		 * //** TTKMLocation
		 * $tSQL = "UPDATE LocL
		 * SET LocL.FTLocName = '" . $paParkData['FTPmoName'] . "'
		 * FROM TTKMLocation AS Loc
		 * INNER JOIN TTKMLocation_L AS LocL ON LocL.FNLocID = Loc.FNLocID AND LocL.FNLngID = " . $this->session->userdata("tLangEdit") . "
		 * WHERE Loc.FNLocID = '" . $paParkData['FNLocID'] . "';
		 *
		 * UPDATE TTKMLocation
		 * SET FTWhoUpd = '" . $paParkData['FTWhoUpd'] . "', FDDateUpd = '" . date('Y-m-d') . "', FTTimeUpd = '" . date('h:i:s') . "'
		 * WHERE FNLocID = '" . $paParkData['FNLocID'] . "';";
		 * $oQuery = $this->db->query($tSQL);
		 */
	}
	public function FSxMPRKEditModelL($aData) {
		$nChk = FSnCheckUpdateLang ( 'TTKMPdtModel_L', 'FNPmoID', $aData ['FNPmoID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMPdtModel_L', array (
					'FNPmoID' => $aData ['FNPmoID'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ),
					'FTPmoName' => $aData ['FTPmoName'],
					'FTPmoNameOth' => $aData ['FTPmoNameOth'] 
			) );
		} else {
			$this->db->where ( 'FNPmoID', $aData ['FNPmoID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMPdtModel_L', array (
					'FTPmoName' => $aData ['FTPmoName'],
					'FTPmoNameOth' => $aData ['FTPmoNameOth'] 
			) );
		}
	}
	public function FSxMPRKEditImg($paParkData) {
		$oImg = FSnCheckImg ( 'TTKMImgPdt', 'FNImgRefID', $paParkData ['FNImgRefID'], '1' );
		if ($oImg [0]->counts == 0) {
			$aData = array (
					'FNImgRefID' => $paParkData ['FNImgRefID'],
					'FTImgType' => '1',
					'FNImgSeq' => '1',
					'FTImgObj' => $paParkData ['FTImgObj'] 
			);
			$this->db->insert ( 'TTKMImgPdt', $aData );
		} else {
			$this->db->where ( 'FNImgRefID', $paParkData ['FNImgRefID'] );
			$this->db->where ( 'FTImgType', '1' );
			$this->db->where ( 'FNImgSeq', '1' );
			$tDB = $this->db->update ( 'TTKMImgPdt', array (
					'FTImgObj' => $paParkData ['FTImgObj'] 
			) );
		}
	}
	/*
	 * public function FSxMPRKEditImg2($aData) {
	 * $this->db->where('FNImgRefID', $aData['FNLocID']);
	 * $tDB = $this->db->update('TTKMImgObj', array(
	 * 'FTImgObj' => $aData['FTImgObj'],
	 * 'FTImgType' => '2',
	 * ));
	 * if($this->db->affected_rows() > 0) {
	 *
	 * } else {
	 * $this->db->insert('TTKMImgObj', array(
	 * 'FNImgRefID' => $aData['FNLocID'],
	 * 'FTImgType' => '2',
	 * 'FTImgObj' => $aData['FTImgObj']
	 * ));
	 * }
	 * }
	 */
	public function FSxMPRKDelete($ptParkId) {
		$tSQL = "SELECT COUNT(PKG.FNPpkID) AS count1 
				 FROM TTKMPdtModel AS MOD 
				 LEFT JOIN TTKTPkgPark AS PKG ON MOD.FNPmoID = PKG.FNPmoID		
				 WHERE MOD.FNPmoID = $ptParkId";
		$query = $this->db->query ( $tSQL );
		$oResult = $query->result ();
		if ($oResult [0]->count1 >= 1) {
			return 1;
		} else {
			// TchGroup
			$tSQL = "DELETE FROM TTKMTchGroup_L WHERE FNTcgID IN(
			SELECT DISTINCT FNTcgID FROM TTKMTchGroup WHERE FNPmoID = '$ptParkId'
			)";
			$this->db->query ( $tSQL );
			$this->db->where ( 'FNPmoID', $ptParkId );
			$this->db->delete ( 'TTKMTchGroup' );
			
			// Location
			$tSQL = "DELETE FROM TTKMLocation_L WHERE FNLocID IN(
			SELECT DISTINCT FNLocID FROM TTKMLocation WHERE FNPmoID = '$ptParkId'
			)";
			$this->db->query ( $tSQL );
			$this->db->where ( 'FNPmoID', $ptParkId );
			$this->db->delete ( 'TTKMLocation' );
			
			// Model
			$this->db->where ( 'FNPmoID', $ptParkId );
			$this->db->delete ( 'TTKMPdtModel' );
			
			$this->db->where ( 'FNPmoID', $ptParkId );
			$this->db->delete ( 'TTKMPdtModel_L' );
			
			$this->db->where ( 'FNImgRefID', $ptParkId );
			$this->db->where ( 'FTImgType', '1' );
			$this->db->delete ( 'TTKMImgPdt' );
			return 0;
		}
	}
	public function FSxMPRKDetail($aData) {
		$tSQL = "SELECT TTKMPdtModel.*, 
				TTKMPdtModel_L.*, 
				TTKMImgPdt.FTImgObj, TTKMImgPdt.FTImgType,
			    UserL1.FTUsrName AS NameAdd, 
				UserL2.FTUsrName AS NameEdit
				FROM TTKMPdtModel
				LEFT JOIN TTKMPdtModel_L ON TTKMPdtModel_L.FNPmoID = TTKMPdtModel.FNPmoID AND TTKMPdtModel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				LEFT JOIN TTKMImgPdt ON TTKMImgPdt.FNImgRefID = TTKMPdtModel.FNPmoID AND TTKMImgPdt.FTImgType = '1'
				LEFT JOIN TTKMUser AS User1 ON User1.FNUsrID = TTKMPdtModel.FTWhoIns	
				LEFT JOIN TTKMUser_L AS UserL1 ON UserL1.FNUsrID = User1.FNUsrID
				LEFT JOIN TTKMUser AS User2 ON User2.FNUsrID = TTKMPdtModel.FTWhoUpd
				LEFT JOIN TTKMUser_L AS UserL2 ON UserL2.FNUsrID = User2.FNUsrID
				WHERE TTKMPdtModel.FNPmoID = '" . $aData ['tParkId'] . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKLoc($aData) {
		$tSQL = "SELECT TTKMLocation.*, TTKMLocation_L.FTLocName, TTKMImgPdt.FTImgObj, TTKMImgPdt.FTImgType
				FROM TTKMLocation
				LEFT JOIN TTKMLocation_L ON TTKMLocation.FNLocID = TTKMLocation_L.FNLocID  AND TTKMLocation_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'				
				LEFT JOIN TTKMImgPdt ON TTKMImgPdt.FNImgRefID = TTKMLocation.FNLocID AND TTKMImgPdt.FTImgType = '4'
				WHERE TTKMLocation.FNPmoID = '" . $aData ['tParkId'] . "'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKLocGetID($tDataID) {
		$tSQL = "SELECT *
				FROM TTKMLocation
				WHERE TTKMLocation.FNPmoID = $tDataID";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKArea() {
		$tSQL = "SELECT TCNMArea.*, TCNMArea_L.*
		FROM TCNMArea
		LEFT JOIN TCNMArea_L ON TCNMArea_L.FTAreCode = TCNMArea.FTAreCode
		AND TCNMArea_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKProvince() {
		$tSQL = "SELECT TCNMProvince.*, TCNMProvince_L.FTPvnName
				 FROM TCNMProvince
				 LEFT JOIN TCNMProvince_L ON TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode
				 AND TCNMProvince_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'	 	
		";

		//$tSQL .= " WHERE FTAreCode = '001'"; 
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKDistrict() {
		$tSQL = "SELECT TCNMDistrict.*, TCNMDistrict_L.FTDstName
				 FROM TCNMDistrict
				 LEFT JOIN TCNMDistrict_L ON TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode
				 AND TCNMDistrict_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "' 
				 WHERE FTPvnCode = '10'
				 ";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKDistrictAjax($tID) {
		$tSQL = "SELECT TCNMDistrict.*, TCNMDistrict_L.FTDstName
        		FROM TCNMDistrict
				INNER JOIN TCNMDistrict_L ON TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				WHERE TCNMDistrict.FTPvnCode = $tID";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKProvinceAjax($tID) {
		$tSQL = "SELECT PVN.*, PVNL.FTPvnName
                         FROM TCNMZone AS ZNE
                         INNER JOIN TCNMProvince AS PVN ON ZNE.FTZneCode = PVN.FTZneCode
                         INNER JOIN TCNMProvince_L AS PVNL ON PVN.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
                         WHERE ZNE.FTAreCode = '$tID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKSaveLoc($aData) {
		$this->db->insert ( 'TTKMLocation', array (
				'FNPmoID' => $this->PdtModelID,
				'FNLocLimit' => '0',
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ),
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$this->tLocID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMLocation_L', array (
				'FNLocID' => $this->tLocID,
				'FTLocName' => $aData ['FTPmoName'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
		) );		
		$this->db->insert ( 'TTKMLocZone', array (
				'FNLocID' => $this->tLocID,
				'FTZneBookingType' => '3',
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ),
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$FNZneID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMLocZone_L', array (
				'FNZneID' => $FNZneID,
				'FTZneName' => 'โซน' . $aData ['FTPmoName'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
		) );
		return $this->tLocID;
	}
	public function FSxMPRKSaveImg($paParkDataImg) {
		$this->db->insert ( 'TTKMImgPdt', array (
				'FNImgRefID' => $this->PdtModelID,
				'FTImgType' => '1',
				'FNImgSeq' => '1',
				'FTImgObj' => $paParkDataImg ['FTImgObj'] 
		) );
	}
	public function FSxMPRKAddAre($aData) {
		$this->db->insert ( 'TTKMLocProvince', array (
				'FNLocID' => $this->tLocID,
				'FNAreID' => $aData ['FTAreCode'],
				'FNPvnID' => $aData ['FTPvnCode'],
				'FNDstID' => $aData ['FTDstCode'] 
		) );
	}
	public function FSxMPRKAddAre2($aData) {
		$this->db->insert ( 'TTKMLocProvince', array (
				'FNLocID' => $aData ['FNLocID'],
				'FNAreID' => $aData ['FTAreCode'],
				'FNPvnID' => $aData ['FTPvnCode'],
				'FNDstID' => $aData ['FTDstCode'] 
		) );
	}
	public function FSxMPRKDelImgPrk($aData) {
		$this->db->where ( 'FNImgRefID', $aData ['FNPmoID'] );
		$this->db->where ( 'FTImgType', '1' );
		$this->db->delete ( 'TTKMImgPdt' );
	}
	public function FSxMPRKCheck($tData) {
		$tSQL = "
    			SELECT COUNT(TTKMPdtModel.FNPmoID) AS counts
				FROM TTKMPdtModel
				LEFT JOIN TTKMPdtModel_L ON TTKMPdtModel_L.FNPmoID = TTKMPdtModel.FNPmoID
				AND TTKMPdtModel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				WHERE TTKMPdtModel_L.FTPmoName = '" . $tData ['FTPmoName'] . "'
    			";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKEdits($nID) {
		$tSQL = "SELECT TTKMPdtModel.*, TTKMPdtModel_L.FTPmoName, TTKMPdtModel_L.FTPmoNameOth, TTKMImgPdt.FNImgID, TTKMImgPdt.FTImgObj
				FROM TTKMPdtModel    			
				LEFT JOIN TTKMPdtModel_L ON TTKMPdtModel.FNPmoID = TTKMPdtModel_L.FNPmoID  AND TTKMPdtModel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'			
				LEFT JOIN TTKMImgPdt ON TTKMImgPdt.FNImgRefID = TTKMPdtModel.FNPmoID AND TTKMImgPdt.FTImgType = '1'
				WHERE TTKMPdtModel.FNPmoID = '" . $nID . "'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMPRKLocL($tName) {
		$tSQL = "SELECT TTKMLocation_L.*,TTKMLocProvince.FNLpvID, TTKMLocProvince.FNAreID, TTKMLocProvince.FNPvnID, TTKMLocProvince.FNDstID, TCNMProvince_L.FTPvnName, TCNMDistrict_L.FTDstName, TCNMArea_L.FTAreName
				 FROM TTKMLocation_L    
    			 LEFT JOIN TTKMLocProvince ON TTKMLocProvince.FNLocID = TTKMLocation_L.FNLocID     			    			
    			 LEFT JOIN TCNMProvince_L ON TCNMProvince_L.FTPvnCode = TTKMLocProvince.FNPvnID AND TCNMProvince_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'    			
    			 LEFT JOIN TCNMDistrict_L ON TCNMDistrict_L.FTDstCode = TTKMLocProvince.FNDstID AND TCNMDistrict_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'    			
    			 LEFT JOIN TCNMArea_L ON TCNMArea_L.FTAreCode = TTKMLocProvince.FNAreID AND TCNMArea_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'    			
				 WHERE .TTKMLocation_L.FTLocName = '" . urldecode ( $tName ) . "' AND TTKMLocation_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}

	

}


