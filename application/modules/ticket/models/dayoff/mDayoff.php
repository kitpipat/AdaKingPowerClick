<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mDayoff extends CI_Model {
	private function FCNaMDOFCallLenData($pnPerPage, $pnPage) {
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
	public function FSaMDOFList($tFDLdoDateFrm, $nLocID, $nPageNo = 1) {
		$aRowLen = $this->FCNaMDOFCallLenData ( 5, $nPageNo );
		$tSqlFDLdoDateFrm = '';
		if ($tFDLdoDateFrm != '') {
			$tSqlFDLdoDateFrm = " AND CONVERT(varchar(10),TTKMLocDayOff.FDLdoDateFrm,121) LIKE '%$tFDLdoDateFrm%'";
		}				
		$tSQL = "SELECT c.* FROM(
					SELECT ROW_NUMBER() OVER(ORDER BY TTKMLocDayOff.FNLdoID DESC) AS RowID,	
					TTKMLocDayOff.*, 
					TTKMLocDayOff_L.FTLdoRmk					
					FROM TTKMLocDayOff
					LEFT JOIN TTKMLocDayOff_L ON TTKMLocDayOff_L.FNLdoID = TTKMLocDayOff.FNLdoID 
					AND TTKMLocDayOff_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
					WHERE TTKMLocDayOff.FNLocID = '" . $nLocID . "' $tSqlFDLdoDateFrm";
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMDOFCount($tFDLdoDateFrm, $nLocID) {
		$tSqlFDLdoDateFrm = '';
		if ($tFDLdoDateFrm != '') {
			$tSqlFDLdoDateFrm = " AND CONVERT(varchar(10),TTKMLocDayOff.FDLdoDateFrm,121) LIKE '%$tFDLdoDateFrm%'";
		} 		
		$tSQL = "SELECT COUNT(TTKMLocDayOff.FNLdoID) AS counts 
				 FROM TTKMLocDayOff 
				 LEFT JOIN TTKMLocDayOff_L ON TTKMLocDayOff_L.FNLdoID = TTKMLocDayOff.FNLdoID 				 
				 AND TTKMLocDayOff_L.FNLdoID = '" . $this->session->userdata ( "tLangEdit" ) . "' 				 
				 WHERE TTKMLocDayOff.FNLocID = $nLocID $tSqlFDLdoDateFrm";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMDOFAdd($aData) {
		$this->db->insert ( 'TTKMLocDayOff', array (
				'FNLocID' => $aData ['FNLocID'],
				'FDLdoDateFrm' => $aData ['FDLdoDateFrm'],
				'FDLdoDateTo' => $aData ['FDLdoDateTo'] 
		) );
		$nLdoID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMLocDayOff_L', array (
				'FNLdoID' => $nLdoID,
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FTLdoRmk' => $aData ['FTLdoRmk'] 
		) );
		return $nLdoID;
	}
	public function FSxMDOFEdit($aData) {
		$this->db->where ( 'FNLdoID', $aData ['FNLdoID'] );
		$this->db->update ( 'TTKMLocDayOff', array (
				'FDLdoDateFrm' => $aData ['FDLdoDateFrm'],
				'FDLdoDateTo' => $aData ['FDLdoDateTo'],
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		$nChk = FSnCheckUpdateLang ( 'TTKMLocDayOff_L', 'FNLdoID', $aData ['FNLdoID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMLocDayOff_L', array (
					'FNLdoID' => $aData ['FNLdoID'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ),
					'FTLdoRmk' => $aData ['FTLdoRmk'] 
			) );
		} else {
			$this->db->where ( 'FNLdoID', $aData ['FNLdoID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMLocDayOff_L', array (
					'FTLdoRmk' => $aData ['FTLdoRmk'] 
			) );
		}
	}
	public function FSxMDOFDel($aData) {
		$this->db->where ( 'FNLdoID', $aData ['FNLdoID'] );
		$this->db->delete ( 'TTKMLocDayOff' );		
		$this->db->where ( 'FNLdoID', $aData ['FNLdoID'] );
		$this->db->delete ( 'TTKMLocDayOff_L' );
	}
	public function FSxMDOFHeader($nLocID) {

		$tSQL = "SELECT LOC.*, LOCL.FTLocName, MODL.FTBchName, OBJ.FTImgObj    			
				 FROM TTKMLocation AS LOC
				 LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = LOC.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 LEFT JOIN TCNMBranch_L AS MODL ON MODL.FTBchCode = LOC.FNPmoID AND MODL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
    			 LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = LOC.FNLocID AND OBJ.FTImgType = '2' AND OBJ.FTImgKey = 'main' 	
				 WHERE LOC.FNLocID = '$nLocID' ";
			
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}

	}
	public function FSxMDOFArea($nLocID) {
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
	public function FSxMDOFShowEdit($nDOFID) {
		$tSQL = "SELECT TTKMLocDayOff.*, TTKMLocDayOff_L.FTLdoRmk
				 FROM TTKMLocDayOff  
				 LEFT JOIN TTKMLocDayOff_L ON TTKMLocDayOff_L.FNLdoID = TTKMLocDayOff.FNLdoID AND TTKMLocDayOff_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
    			 WHERE TTKMLocDayOff.FNLdoID = '$nDOFID'
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
