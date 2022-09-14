<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mLayout extends CI_Model {
	public function FSxMLOTHeader($nLocID) {
		$tSQL = "SELECT LOC.*, LOCL.FTLocName, MODL.FTBchName, OBJ.FTImgObj
				 FROM TTKMLocation AS LOC
				 LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = LOC.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 LEFT JOIN TCNMBranch_L AS MODL ON MODL.FTBchCode = LOC.FNPmoID AND MODL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
<<<<<<< HEAD
    			 LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = LOC.FNLocID AND OBJ.FTImgType = '2' AND OBJ.FTImgKey = 'main'
=======
				 LEFT JOIN TCNMImgObj AS OBJ ON OBJ.FTImgRefID = CONVERT(VARCHAR(5),LOC.FNLocID)  AND OBJ.FTImgKey = 'main'  
>>>>>>> 81bf17ac4472cccb47e9b8a7fad9daddc4181c76
    			 WHERE LOC.FNLocID = '$nLocID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMLOTArea($nLocID) {
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


	public function FSxMLOTLayoutImg($nLocID) {
		$tSQL = "SELECT * FROM TCNMImgObj WHERE FTImgRefID = '$nLocID' AND FTImgTable = 'TTKMLocLayout' ";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}


	public function FSxMLOTAuthen() {
		$tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '5' AND FNGahID = '".$this->session->userdata ( "FNGahID")."'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
}