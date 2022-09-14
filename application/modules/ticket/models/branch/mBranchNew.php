<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mBranchNew extends CI_Model {
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
		$tSQL = "SELECT COUNT(TCNMBranch.FTBchCode) AS counts 
				 FROM TCNMBranch 
				 LEFT JOIN TCNMBranch_L ON TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE 1=1
				";
		if ($tFTPmoName != '') {
			$tSQL .= " AND (TCNMBranch_L.FTBchName LIKE '%$tFTPmoName%')";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	// ดึงข้อมูล Agency
	//Edit : 03-01-2018 Copter
	public function FSaMPRKList($tFTPmoName, $nPageNo = 1) {
		$aRowLen = $this->FCNaMPRKCallLenData ( 8, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSQL = "SELECT c.* FROM(
			SELECT ROW_NUMBER() OVER(ORDER BY BCH.FTBchCode DESC) AS RowID,
			BCH.FTBchCode AS FNPmoID,
			IMGO.FTImgObj,
			IMGO.FTImgTable AS FTImgType,
			BCHL.FTBchName AS FTPmoName,
			BCHL.FNLngID AS FNLngID
			FROM TCNMBranch BCH
			LEFT JOIN TCNMImgObj IMGO ON BCH.FTBchCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TCNMBranch'
			LEFT JOIN TCNMBranch_L BCHL ON BCHL.FTBchCode = BCH.FTBchCode AND BCHL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
					";
		if ($tFTPmoName != '') {
			$tSQL .= " WHERE (BCHL.FTBchName LIKE '%$tFTPmoName%')";
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

	//Functionality : delete Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Return : response
	//Return Type : array
	public function FSnMBCHDel($nIDCode) {

        $tSQL = "SELECT COUNT(FTBchCode) AS count
        FROM TCNMBranch
        WHERE FTBchCode = '$nIDCode'";
        $query = $this->db->query($tSQL);
		$oResult = $query->result();
        if ($oResult [0]->count != 0) {
	
			$this->db->where_in('FTBchCode', $nIDCode);
			$this->db->delete('TCNMBranch');
		
			$this->db->where_in('FTBchCode', $nIDCode);
			$this->db->delete('TCNMBranch_L');

            return 1;
        } else {
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
				WHERE TTKMLocation.FNPmoID = '$tDataID' ";
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

	//Functionality : Add Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : Array
	public function FSaMBCHAdd($ptAPIReq,$ptMethodReq,$paData){
		$tStaDup = $this->FSnMBCHCheckduplicate($paData['FTBchCode']); //ส่งค่าไปหา duplicate
		$nStaDup = $tStaDup[0]->counts;
		if($nStaDup == 0){
			// print_r($paData);
			$this->db->insert('TCNMBranch',array(

					'FTBchCode'      => $paData['FTBchCode'],
					'FTBchType'      => $paData['FTBchType'],
					'FTBchPriority'  => $paData['FTBchPriority'],
					'FTBchRegNo'     => $paData['FTBchRegNo'],
					'FTBchRefID'     => $paData['FTBchRefID'],
					'FDBchStart'     => $paData['FDBchStart'],
					'FDBchStart'     => $paData['FDBchStart'],
					'FDBchStop'      => $paData['FDBchStop'],
					'FDBchSaleStart' => $paData['FDBchSaleStart'],
					'FDBchSaleStop'  => $paData['FDBchSaleStop'],
					'FTBchStaActive' => $paData['FTBchStaActive'],
					'FDCreateOn'	 => $paData['FDCreateOn'],
					'FTCreateBy' 	 => $paData['FTCreateBy']
			
			));
			
			if($this->db->affected_rows() > 0) {
				$nBchID = $this->db->insert_id();
					
				$StaAddLang = $this->FSnMBchAddLang($paData); // Add Language
					
				if($StaAddLang != '1'){
					//Ploblem
					$aStatus = array(
							'rtCode' => '905',
							'rtDesc' => 'cannot insert database.',
					);
					$jStatus = json_encode($aStatus);
					$aStatus = json_decode($jStatus, true);
					
				}else{
					//Success
					$aStatus = array(
							'rtCode'       => '1',
							'rtDesc'       => 'success',
							'nStaCallBack' => $paData['FTBchCode']
 					);
					$jStatus = json_encode($aStatus);
					$aStatus = json_decode($jStatus, true);
					
				}
					
			} else {
				return 0;
			}
			
		}else{
			//Duplicate
			$aStatus = array(
					'rtCode' => '801',
					'rtDesc' => 'data is duplicate.',
			);
			$jStatus = json_encode($aStatus);
			$aStatus = json_decode($jStatus, true);
		
		}
		
		return $aStatus;

	}

	//Functionality : Checkduplicate
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMBCHCheckduplicate($ptBchCode){
	
		$tSQL = "SELECT COUNT(FTBchCode)AS counts
		FROM TCNMBranch
		WHERE FTBchCode = '$ptBchCode' ";
			
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			return $oQuery->result();
		} else {
			return false;
		}
	
	}

	//Functionality : Add Lang Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : num
	public function FSnMBchAddLang($paData){
		
		$this->db->insert('TCNMBranch_L',array(
				'FTBchCode'=>$paData['FTBchCode'],	
				'FNLngID'=>$paData['FNLngID'],
				'FTBchName'=>$paData['FTBchName'],		
		));
		
		if($this->db->affected_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
		
	}

	//Functionality : Update Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : Array
	public function FSaMBCHUpdateAddress($paData){
		$this->db->set('FTAddV1No' , $paData['FTAddV1No']);
		$this->db->set('FTAddV1Soi' , $paData['FTAddV1Soi']);
		$this->db->set('FTAddV1Village' , $paData['FTAddV1Village']);
		$this->db->set('FTAddV1Road' , $paData['FTAddV1Road']);
		$this->db->set('FTAddV1SubDist' , $paData['FTAddV1SubDist']);
		$this->db->set('FTAddV1DstCode' , $paData['FTAddV1DstCode']);
		$this->db->set('FTAddV1PvnCode' , $paData['FTAddV1PvnCode']);
		$this->db->set('FTAddV1PostCode' , $paData['FTAddV1PostCode']);
		$this->db->set('FTAddV2Desc1' , $paData['FTAddV2Desc1']);
		$this->db->set('FTAddV2Desc2' , $paData['FTAddV2Desc2']);

	
		$this->db->where('FTAddGrpType', $paData['FTAddGrpType']);
		$this->db->where('FTAddRefCode', $paData['FTAddRefCode']);
		$this->db->where('FNLngID', $paData['FNLngID']);
		$this->db->update('TCNMAddress_L');
		
	
	
		if($this->db->affected_rows() > 0) {
			//Success
			$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'success',
			);
		} else {
			
			$this->db->insert('TCNMAddress_L',array(
						
					'FTAddV1No' => $paData['FTAddV1No'],
					'FTAddV1Soi' => $paData['FTAddV1Soi'],
					'FTAddV1Village' => $paData['FTAddV1Village'],
					'FTAddV1Road' => $paData['FTAddV1Road'],
					'FTAddV1SubDist' => $paData['FTAddV1SubDist'],
					'FTAddV1DstCode' => $paData['FTAddV1DstCode'],
					'FTAddV1PvnCode' => $paData['FTAddV1PvnCode'],
					'FTAddV1PostCode' => $paData['FTAddV1PostCode'],
					'FTAddV2Desc1' => $paData['FTAddV2Desc1'],
					'FTAddV2Desc2' => $paData['FTAddV2Desc2'],
					'FTAddGrpType' => $paData['FTAddGrpType'],
					'FTAddVersion' => $paData['FTAddVersion'],
					'FTAddRefCode' => $paData['FTAddRefCode'],
					'FNLngID' => $paData['FNLngID'],
					
			));
			
			if($this->db->affected_rows() > 0) {
				//Success
				$aStatus = array(
						'rtCode' => '1',
						'rtDesc' => 'success',
				);
			} else {
				//Ploblem
				$aStatus = array(
					'rtCode' => '905',
					'rtDesc' => 'cannot Insert database.',
				);
			}
			
		}
		
		$jStatus = json_encode($aStatus);
		$aStatus = json_decode($jStatus, true);
		return $aStatus;
	
	}

	//Functionality : Search Branch By ID
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSaMBchSearchByID($paData){
		$tBchCode = $paData['FTBchCode'];
		$nLngID = $paData['FNLngID'];
		
	
		if(@$tBchCode){
	
			$tSQL = "SELECT
			BCH.FTBchCode AS rtBchCode,
			BCH.FTBchType AS rtBchType,

			BCH.FTBchPriority AS rtBchPriority,
			BCH.FTBchRegNo AS rtBchRegNo,
			BCH.FTBchRefID AS rtBchRefID,
			CONVERT(CHAR(10),BCH.FDBchStart,120) AS rdBchStart,
			CONVERT(CHAR(10),BCH.FDBchStop,120) AS rdBchStop,
			BCH.FDBchSaleStart AS rdBchSaleStart,
			BCH.FDBchSaleStop AS rdBchSaleStop,
			BCH.FTBchStaActive AS rtBchStaActive,
			BCHL.FTBchName AS rtBchName,
			BCHL.FTBchRmk AS rtBchRmk,

			IMGO.FTImgObj AS rtImgObj 
	
			FROM [TCNMBranch] BCH
			LEFT JOIN [TCNMBranch_L] BCHL ON BCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = 1
			LEFT JOIN [TCNMImgObj] IMGO ON BCH.FTBchCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TCNMBranch'
";

			if ($tBchCode != '') {
				$tSQL .= " WHERE BCH.FTBchCode = '$tBchCode'";
			}
			$oQuery = $this->db->query($tSQL);
			if ($oQuery->num_rows() > 0) {
	
				$aDetail = $oQuery->result();
			} else {
				//No Data
				$aDetail = '';
			}
	
		}
	
		if(@$aDetail){
	
			$aResult = array(
					'roItem' => $aDetail[0],
					'rtCode' => '1',
					'rtDesc' => 'success',
			);
		}else{
			//Not Found
			$aResult = array(
					'rtCode' => '800',
					'rtDesc' => 'data not found.',
			);
		}
		$jResult = json_encode($aResult);
		$aResult = json_decode($jResult, true);
			
		return $aResult;
	}
	
	//Functionality : ดึงข้อมูล ของ ที่อยู่
	//Parameters : function parameters
	//Creator : 10/05/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSvMBCHGetAddress($ptData){
		
		$tAddRefCode = $ptData['FTAddRefCode'];
		$tAddGrpType = $ptData['FTAddGrpType'];
		
		$nLngID = $ptData['FNLngID'];
		
		$tSQL ="SELECT  FTAddVersion,
						FTAddV1No,
						FTAddV1Soi,			
						FTAddV1Village,
						FTAddV1Road,
						FTAddV1SubDist,
						FTAddV1DstCode,
						DSTL.FTDstName,
						SUBDSTL.FTSudName,
						ADDL.FTAddV1PvnCode,
						PVNL.FTPvnName,
						FTAddV1PostCode,
						FTAddV2Desc1,
						FTAddV2Desc2

						
						
				FROM TCNMAddress_L ADDL
				LEFT JOIN TCNMProvince_L PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
				LEFT JOIN TCNMDistrict_L DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
				LEFT JOIN TCNMSubDistrict_L SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
				
				WHERE ADDL.FTAddRefCode = '$tAddRefCode'
				AND ADDL.FTAddGrpType = '$tAddGrpType'
				AND ADDL.FNLngID = '$nLngID'
				";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
		
			return $oQuery->result();
		
		} else {
			//No Data
			return false;
		}
		
	}

	//Functionality : Update Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : Array
	public function FSaMBCHUpdate($paData){

		$this->db->set('FTBchType' , $paData['FTBchType']);
		$this->db->set('FTBchPriority' , $paData['FTBchPriority']);
		$this->db->set('FTBchRegNo' , $paData['FTBchRegNo']);
		$this->db->set('FTBchRefID' , $paData['FTBchRefID']);
		$this->db->set('FDBchStart' , $paData['FDBchStart']);
		$this->db->set('FDBchStop' , $paData['FDBchStop']);
		$this->db->set('FDBchSaleStart' , $paData['FDBchSaleStart']);
		$this->db->set('FDBchSaleStop' , $paData['FDBchSaleStop']);
		$this->db->set('FTBchStaActive' , $paData['FTBchStaActive']);
		
		$this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
		$this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
			
		$this->db->where('FTBchCode', $paData['FTBchCode']);
		$this->db->update('TCNMBranch');
			
		if($this->db->affected_rows() > 0) {

			$StaUpdLang = $this->FSnMBCHUpdateLang($paData); // Add Language
			if($StaUpdLang != 1){ //หาภาษาที่จะแก้ไขไม่เจอ
				
				$StaAddLang = $this->FSnMBchAddLang($paData);
				if($StaAddLang != 1){
					$aStatus = array(
							'rtCode' => '905',
							'rtDesc' => 'cannot update database.',
					);
				}else{
					$aStatus = array(
							'rtCode' => '1',
							'rtDesc' => 'success',
					);
				}
				
			}else{
				//Success
				$aStatus = array(
						'rtCode' => '1',
						'rtDesc' => 'success',
				);
			}
		} else {
			//Ploblem
			$aStatus = array(
					'rtCode' => '905',
					'rtDesc' => 'cannot update database',
			);
		}

		$jStatus = json_encode($aStatus);
		$aStatus = json_decode($jStatus, true);
		return $aStatus;
	
	}

	//Functionality : Update Lang Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : num
	public function FSnMBCHUpdateLang($paData){
	
		$this->db->set('FTBchName', $paData['FTBchName']);
		$this->db->set('FTBchRmk', $paData['FTBchRmk']);
		
		$this->db->where('FNLngID', $paData['FNLngID']);
		$this->db->where('FTBchCode', $paData['FTBchCode']);
		$this->db->update('TCNMBranch_L');
	
		if($this->db->affected_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	
	}
	

}
