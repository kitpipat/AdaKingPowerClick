<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mGate extends CI_Model {
	/**
	 * Gate
	 */
	private function FCNaMGTECallLenData($pnPerPage, $pnPage) {
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
	public function FSxMGTE($tFTGateName, $nLocID, $nPageNo = 1) {
		$aRowLen = $this->FCNaMGTECallLenData ( 5, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSqlGateName = '';
		if ($tFTGateName != '') {
			$tSqlGateName = " AND GateL.FTGteName LIKE '%$tFTGateName%'";
		}
		$tSQL = "SELECT c.* FROM(
					SELECT ROW_NUMBER() OVER(ORDER BY Gate.FNGteID DESC) AS RowID,						
					Gate.*, 
					Zone.FNLocID,  
					ZoneL.FTZneName,  
					GateL.FTGteName						
					FROM TTKMLocGate AS Gate
					LEFT JOIN TTKMLocGate_L AS GateL ON GateL.FNGteID = Gate.FNGteID AND GateL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'					
					LEFT JOIN TTKMLocZone AS Zone ON Zone.FNZneID = Gate.FNZneID 					
					LEFT JOIN TTKMLocZone_L AS ZoneL ON ZoneL.FNZneID = Zone.FNZneID AND ZoneL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'					
					WHERE Zone.FNLocID = '" . $nLocID . "' $tSqlGateName";
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMGTECount($tFTGateName, $nLocID) {
		$tSqlGateName = '';
		if ($tFTGateName != '') {
			$tSqlGateName = "TTKMLocGate_L.FTGteName LIKE '%$tFTGateName%' AND ";
		}
		$tSQL = "SELECT COUNT(TTKMLocGate.FNGteID) AS counts 
				 FROM TTKMLocGate 
				 LEFT JOIN TTKMLocGate_L ON TTKMLocGate_L.FNGteID = TTKMLocGate.FNGteID AND TTKMLocGate_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 LEFT JOIN TTKMLocZone ON TTKMLocZone.FNZneID = TTKMLocGate.FNZneID
				 WHERE $tSqlGateName TTKMLocZone.FNLocID = $nLocID";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMGTEAdd($tData) {
		$this->db->insert ( 'TTKMLocGate', array (
				'FNZneID' => $tData ['FNZneID'],
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$tGteID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMLocGate_L', array (
				'FNGteID' => $tGteID,
				'FTGteName' => $tData ['FTGteName'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
		) );
		return $tGteID;
	}
	public function FSxMGTEEdit($aData) {
		$this->db->where ( 'FNGteID', $aData ['FNGteID'] );
		$this->db->update ( 'TTKMLocGate', array (
				'FNZneID' => $aData ['FNZneID'],
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		
		$nChk = FSnCheckUpdateLang ( 'TTKMLocGate_L', 'FNGteID', $aData ['FNGteID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMLocGate_L', array (
					'FNGteID' => $aData ['FNGteID'],
					'FTGteName' => $aData ['FTGteName'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" )
			) );		
		} else {
			$this->db->where ( 'FNGteID', $aData ['FNGteID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMLocGate_L', array (
					'FTGteName' => $aData ['FTGteName'] 
			) );
		}
	}
	public function FSxMGTEDel($tData) {
		$this->db->where ( 'FNGteID', $tData ['FNGteID'] );
		$this->db->delete ( 'TTKMLocGate' );
		$this->db->where ( 'FNGteID', $tData ['FNGteID'] );
		$this->db->delete ( 'TTKMLocGate_L' );
	}
	public function FSnMGTECheck($tData) {
		$tSQL = "
    			SELECT COUNT(TTKMLocGate.FNGteID) AS counts
				FROM TTKMLocGate
				LEFT JOIN TTKMLocGate_L ON TTKMLocGate_L.FNGteID = TTKMLocGate.FNGteID
				AND TTKMLocGate_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				WHERE TTKMLocGate.FNZneID = '" . $tData ['FNZneID'] . "' AND TTKMLocGate_L.FTGteName = '" . $tData ['FTGteName'] . "'
    			";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMGTEHeader($nLocID) {
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
	public function FSxMGTEArea($nLocID) {
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
	public function FSxMGTESlcZone($nLocID) {
		$this->db->select ( 'Zone.*, ZoneL.*' );
		$this->db->from ( 'TTKMLocZone AS Zone' );
		$this->db->join ( 'TTKMLocZone_L AS ZoneL', 'ZoneL.FNZneID = Zone.FNZneID', 'LEFT' );
		$this->db->where ( 'FNLocID', $nLocID );
		$this->db->where ( 'ZoneL.FNLngID', $this->session->userdata ( "tLangEdit" ) );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMGTEShowEdit($nGteID) {
		$tSQL = "SELECT GTE.*, GTL.FTGteName
				 FROM TTKMLocGate AS GTE
    			 LEFT JOIN TTKMLocGate_L AS GTL ON GTL.FNGteID = GTE.FNGteID AND GTL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        		 WHERE GTE.FNGteID = '$nGteID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMGTEAuthen() {
		$tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '5' AND FNGahID = '".$this->session->userdata ( "FNGahID")."'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
}
?>
