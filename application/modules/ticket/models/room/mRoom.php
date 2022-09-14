<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mRoom extends CI_Model {
	public $nRomID;
	public $nProductID;
	private function FCNaMROMCallLenData($pnPerPage, $pnPage) {
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
	public function FSxMROM($tFTRomName, $tLocID, $tZneID, $nPageNo = 1) {
		$aRowLen = $this->FCNaMROMCallLenData ( 5, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSqlRomName = '';
		if ($tFTRomName != '') {
			$tSqlRomName = " AND TTKMLocRoom_L.FTRomName LIKE '%$tFTRomName%'";
		}
		$tSQL = "SELECT c.* FROM(
					SELECT ROW_NUMBER() OVER(ORDER BY TTKMLocRoom.FNRomID DESC) AS RowID,					
					TTKMLocRoom.*, 
					TTKMLocRoom_L.FTRomName, 
					TTKMLocRoom_L.FTRomFacility,
					TTKMLocRoom_L.FTRomRemark,
					TTKMImgObj.FTImgObj, 
					TTKMImgObj.FTImgType,
					TTKMLocLevel_L.FTLevName
					FROM TTKMLocRoom
					LEFT JOIN TTKMLocRoom_L ON TTKMLocRoom_L.FNRomID = TTKMLocRoom.FNRomID AND TTKMLocRoom_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "' 	
					LEFT JOIN TTKMLocLevel_L ON TTKMLocLevel_L.FNLevID = TTKMLocRoom.FNLevID AND TTKMLocLevel_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
					LEFT JOIN TTKMImgObj ON TTKMImgObj.FNImgRefID = TTKMLocRoom.FNRomID AND TTKMImgObj.FTImgType = '6' 			
					WHERE TTKMLocRoom.FNLocID = '" . $tLocID . "' AND TTKMLocRoom.FNZneID = '" . $tZneID . "' $tSqlRomName";
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMROMCount($tFTRomName, $tLocID, $tZneID) {
		$tSqlRomName = '';
		if ($tFTRomName != '') {
			$tSqlRomName = "  AND TTKMLocRoom_L.FTRomName LIKE '%$tFTRomName%'";
		}
		$tSQL = "SELECT COUNT(TTKMLocRoom.FNRomID) AS counts 
				 FROM TTKMLocRoom 
				 LEFT JOIN TTKMLocRoom_L ON TTKMLocRoom_L.FNRomID = TTKMLocRoom.FNRomID AND TTKMLocRoom_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE TTKMLocRoom.FNLocID = '" . $tLocID . "' AND TTKMLocRoom.FNZneID = '" . $tZneID . "' $tSqlRomName";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	
	/**
	 * Add Room
	 */
	public function FSxMROMAdd($aData) {
		$this->db->insert ( 'TTKMPdt', array (
				'FTPdtCode' => $aData ['FTPdtCode'],
				'FNTcgID' => $aData ['FNTcgID'],
				'FTPdtType' => '1',
				'FNPdtOthSystem' => '4',
				'FTPdtStaActive' => ($aData ['FTRomStaAlw'] == "1" ? "1" : "2"),
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$this->nProductID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMPdt_L', array (
				'FNPdtID' => $this->nProductID,
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FTPdtName' => $aData ['FTRomName'],
				'FTPdtNameOth' => $aData ['FTRomName'] 
		) );
		$this->db->insert ( 'TTKMLocRoom', array (
				'FNLocID' => $aData ['FNLocID'],
				'FNLevID' => $aData ['FNLevID'],
				'FNZneID' => $aData ['FNZneID'],
				'FNPdtID' => $this->nProductID,
				'FTRomSeqNo' => $aData ['FTRomSeqNo'],
				'FNRomQtyBRoom' => $aData ['FNRomQtyBRoom'],
				'FNRomQtyTRoom' => $aData ['FNRomQtyTRoom'],
				'FNRomMaxPerson' => $aData ['FNRomMaxPerson'],
				'FNRomDayBooking' => $aData ['FNRomDayBooking'],
				'FNRomDayPreBooking' => $aData ['FNRomDayPreBooking'],
				'FNRomMinDayBook' => $aData ['FNRomMinDayBook'],
				'FTRomStaAlw' => $aData ['FTRomStaAlw'],
				'FTRomStaAir' => $aData ['FTRomStaAir'],
				'FTRomStaFan' => $aData ['FTRomStaFan'],
				'FTRomStaHeater' => $aData ['FTRomStaHeater'],
				'FTRomStaWifi' => $aData ['FTRomStaWifi'],
				'FTRomStaBreakfast' => $aData ['FTRomStaBreakfast'],
				'FTRomStaAlwAddBed' => $aData ['FTRomStaAlwAddBed'],
				'FTRomLatitude' => $aData ['FTRomLatitude'],
				'FTRomLongitude' => $aData ['FTRomLongitude'] 
		) );
		$this->nRomID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMLocRoom_L', array (
				'FNRomID' => $this->nRomID,
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FTRomName' => $aData ['FTRomName'],
				'FTRomFacility' => $aData ['FTRomFacility'],
				'FTRomRemark' => $aData ['FTRomRemark'] 
		) );
	}
	public function FSxMROMAddImg($aData) {
		$this->db->insert ( 'TTKMImgObj', array (
				'FNImgRefID' => $this->nRomID,
				'FTImgType' => '6',
				'FNImgSeq' => '1',
				'FTImgObj' => $aData ['FTImgObj'] 
		) );
		$this->db->insert ( 'TTKMImgPdt', array (
				'FNImgRefID' => $this->nProductID,
				'FTImgType' => '5',
				'FNImgSeq' => '1',
				'FTImgObj' => $aData ['FTImgObj'] 
		) );
	}
	public function FSxMROMEdit($aData) {
		// TTKMLocRoom
		$this->db->where ( 'FNRomID', $aData ['FNRomID'] );
		$this->db->update ( 'TTKMLocRoom', array (
				'FNLevID' => $aData ['FNLevID'],
				'FTRomSeqNo' => $aData ['FTRomSeqNo'],
				'FTRomLatitude' => $aData ['FTRomLatitude'],
				'FTRomLongitude' => $aData ['FTRomLongitude'],
				'FNRomQtyBRoom' => $aData ['FNRomQtyBRoom'],
				'FNRomQtyTRoom' => $aData ['FNRomQtyTRoom'],
				'FNRomMaxPerson' => $aData ['FNRomMaxPerson'],
				'FNRomMinDayBook' => $aData ['FNRomMinDayBook'],
				'FNRomDayBooking' => $aData ['FNRomDayBooking'],
				'FNRomDayPreBooking' => $aData ['FNRomDayPreBooking'],
				'FTRomStaAlw' => $aData ['FTRomStaAlw'],
				'FTRomStaAir' => $aData ['FTRomStaAir'],
				'FTRomStaFan' => $aData ['FTRomStaFan'],
				'FTRomStaAir' => $aData ['FTRomStaAir'],
				'FTRomStaFan' => $aData ['FTRomStaFan'],
				'FTRomStaHeater' => $aData ['FTRomStaHeater'],
				'FTRomStaWifi' => $aData ['FTRomStaWifi'],
				'FTRomStaBreakfast' => $aData ['FTRomStaBreakfast'],
				'FTRomStaAlwAddBed' => $aData ['FTRomStaAlwAddBed'] 
		) );
		$nChk = FSnCheckUpdateLang ( 'TTKMLocRoom_L', 'FNRomID', $aData ['FNRomID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMLocRoom_L', array (
					'FNRomID' => $aData ['FNRomID'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ),
					'FTRomName' => $aData ['FTRomName'],
					'FTRomFacility' => $aData ['FTRomFacility'],
					'FTRomRemark' => $aData ['FTRomRemark'] 
			) );
		} else {
			$this->db->where ( 'FNRomID', $aData ['FNRomID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMLocRoom_L', array (
					'FTRomFacility' => $aData ['FTRomFacility'],
					'FTRomRemark' => $aData ['FTRomRemark'],
					'FTRomName' => $aData ['FTRomName'] 
			) );
		}
		
		$this->db->where ( 'FNPdtID', $aData ['FNPdtID'] );
		$this->db->update ( 'TTKMPdt', array (
				'FTPdtStaActive' => ($aData ['FTRomStaAlw'] == "1" ? "1" : "2"),
				'FNTcgID' => $aData ['FNTcgID'],
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$nChk = FSnCheckUpdateLang ( 'TTKMPdt_L', 'FNPdtID', $aData ['FNPdtID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMPdt_L', array (
					'FNPdtID' => $aData ['FNPdtID'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ),
					'FTPdtName' => $aData ['FTRomName'],
					'FTPdtNameOth' => $aData ['FTRomName'] 
			) );
		} else {
			$this->db->where ( 'FNPdtID', $aData ['FNPdtID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMPdt_L', array (
					'FTPdtName' => $aData ['FTRomName'],
					'FTPdtNameOth' => $aData ['FTRomName'] 
			) );
		}
	}
	public function FSxMROMImgEdit($aData) {
		$oImg = FSnCheckImg ( 'TTKMImgObj', 'FNImgRefID', $aData ['FNRomID'], '6' );
		if ($oImg [0]->counts == 0) {
			$this->db->insert ( 'TTKMImgObj', array (
					'FNImgRefID' => $aData ['FNRomID'],
					'FTImgObj' => $aData ['FTImgObj'],
					'FNImgSeq' => '1',
					'FTImgType' => '6' 
			) );
		} else {
			$this->db->where ( 'FNImgRefID', $aData ['FNRomID'] );
			$this->db->where ( 'FTImgType', '6' );
			$this->db->where ( 'FNImgSeq', '1' );
			$this->db->update ( 'TTKMImgObj', array (
					'FTImgObj' => $aData ['FTImgObj'] 
			) );
		}
		
		$oImg2 = FSnCheckImg ( 'TTKMImgPdt', 'FNImgRefID', $aData ['FNPdtID'], '5' );
		if ($oImg2 [0]->counts == 0) {
			$this->db->insert ( 'TTKMImgPdt', array (
					'FNImgRefID' => $aData ['FNPdtID'],
					'FTImgObj' => $aData ['FTImgObj'],
					'FNImgSeq' => '1',
					'FTImgType' => '5' 
			) );
		} else {
			$this->db->where ( 'FNImgRefID', $aData ['FNPdtID'] );
			$this->db->where ( 'FTImgType', '5' );
			$this->db->where ( 'FNImgSeq', '1' );
			$this->db->update ( 'TTKMImgPdt', array (
					'FTImgObj' => $aData ['FTImgObj'] 
			) );
		}
	}
	public function FSxMROMDel($nRomID, $nPdtID) {
		$this->db->where ( array (
				'FNRomID' => $nRomID 
		) );
		$this->db->delete ( 'TTKMLocRoom' );
		
		$this->db->where ( array (
				'FNRomID' => $nRomID 
		) );
		$this->db->delete ( 'TTKMLocRoom_L' );
		$this->db->where ( array (
				'FTImgType' => '6',
				'FNImgRefID' => $nRomID 
		) );
		$this->db->delete ( 'TTKMImgObj' );
		$this->db->where ( array (
				'FNPdtID' => $nPdtID 
		) );
		$this->db->delete ( 'TTKMPdt' );
		$this->db->where ( array (
				'FNPdtID' => $nPdtID 
		) );
		$this->db->delete ( 'TTKMPdt_L' );
		$this->db->where ( array (
				'FTImgType' => '5',
				'FNImgRefID' => $nPdtID 
		) );
		$this->db->delete ( 'TTKMImgPdt' );
	}
	public function FSxMROMHeader($nLocID) {
		$tSQL = "SELECT LOC.*, LOCL.FTLocName, MODL.FTPmoName, OBJ.FTImgObj
				 FROM TTKMLocation AS LOC
				 LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = LOC.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 LEFT JOIN TTKMPdtModel_L AS MODL ON MODL.FNPmoID = LOC.FNPmoID AND MODL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FNImgRefID = LOC.FNLocID AND OBJ.FTImgType = '2'
				 WHERE LOC.FNLocID = '$nLocID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}

	//Functionality : Get Data Province And District Where Location Id
    //Parameters : Event Chang Filter 
	//Creator : P'Nut
	//Edit : 04/01/2019 Krit(Copter)
    //Return : View Data 
    //Return Type : String
	public function FSxMROMArea($nLocID) {
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
	public function FSxMROMShowEdit($nRomID) {
		$tSQL = "SELECT ROM.*, ROML.FTRomName, 
				 ROML.FTRomFacility, 
				 ROML.FTRomRemark, 
				 OBJ.FNImgID, 
				 OBJ.FTImgObj,
				 PDT.FNTcgID				
				 FROM TTKMLocRoom AS ROM
    			 LEFT JOIN TTKMLocRoom_L AS ROML ON ROML.FNRomID = ROM.FNRomID AND ROML.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
    			 LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FNImgRefID = ROM.FNRomID AND OBJ.FTImgType = '6'		 
				 LEFT JOIN TTKMPdt AS PDT ON PDT.FNPdtID = ROM.FNPdtID	
				 WHERE ROM.FNRomID = '$nRomID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMROMLev($nLocID) {
		$tSQL = "SELECT LEV.*, LEVL.FTLevName
				 FROM TTKMLocLevel AS LEV
    			 LEFT JOIN TTKMLocLevel_L AS LEVL ON LEVL.FNLevID = LEV.FNLevID AND LEVL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
 	    		 WHERE LEV.FNLocID = '$nLocID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMROMPdtTcg() {
		$tSQL = "SELECT TOP 1 FNPdtID, FNTcgID
				 FROM TTKMPdt ORDER BY FNPdtID DESC";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMROMTcg($nLocID) {
		$tSQL = "SELECT TCH.*, TCHL.FTTcgName
				 FROM TTKMLocation AS LOC
				 LEFT JOIN TTKMTchGroup AS TCH ON TCH.FNPmoID = LOC.FNPmoID 
				 OR TCH.FNPmoID IS NULL 
				 AND TCH.FTTcgStaShow = '1'  
				 INNER JOIN TTKMTchGroup_L AS TCHL ON TCHL.FNTcgID = TCH.FNTcgID AND TCHL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE LOC.FNLocID = '$nLocID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMROMPdtCode() {
		$tSQL = "SELECT FTPdtCode FROM TTKMPdt ORDER BY FNPdtID DESC";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	
	public function FSxMROMZone($nZneID) {
		$tSQL = "SELECT ZNE.*, ZNEL.FTZneName
				 FROM TTKMLocZone AS ZNE				
    			 LEFT JOIN TTKMLocZone_L AS ZNEL ON ZNEL.FNZneID = ZNE.FNZneID AND ZNEL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
 	    		 WHERE ZNE.FNZneID = '$nZneID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMROMAuthen() {
		$tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '5' AND FNGahID = '".$this->session->userdata ( "FNGahID")."'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
}
