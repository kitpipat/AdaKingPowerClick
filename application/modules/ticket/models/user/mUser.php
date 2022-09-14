<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 */
class mUser extends CI_Model {
	public $nUsrID;
	private function FCNaMUSRCallLenData($pnPerPage, $pnPage) {
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
	public function FSxMUSRShow($tFTName, $nPageNo = 1) {
		$aRowLen = $this->FCNaMUSRCallLenData ( 8, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSQL = "SELECT c.* FROM(
					SELECT ROW_NUMBER() OVER(ORDER BY USR.FNUsrID DESC) AS RowID,
					USR.*, 
        			USRL.FTUsrName,   
					HD.FTGahName, 
					HD.FTGahNameOth,
					IMG.FTImgObj,
					IMG.FNImgID
					FROM TTKMUser AS USR	
        			LEFT JOIN TTKMUser_L AS USRL ON USRL.FNUsrID = USR.FNUsrID AND USRL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				    LEFT JOIN TTKMImgPerson AS IMG ON IMG.FNImgRefID = USR.FNUsrID AND IMG.FTImgType = '3' AND IMG.FNImgSeq = '1'        			
					LEFT JOIN TTKMGrpAlwHD AS HD ON HD.FNGahID = USR.FNGahID";
		if ($tFTName != '') {
			$tSQL .= " WHERE USRL.FTUsrName LIKE '%$tFTName%'";
		}
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMUSRCount($tFTUserName) {
		$tSQL = "SELECT COUNT(USR.FNUsrID) AS counts 
				 FROM TTKMUser AS USR
        		 LEFT JOIN TTKMUser_L AS USRL ON USRL.FNUsrID = USR.FNUsrID AND USRL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        		";
		if ($tFTUserName != '') {
			$tSQL .= " WHERE USRL.FTUsrName LIKE '%$tFTUserName%'";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRAdd($aData) {
		$this->db->insert ( 'TTKMUser', array (
				'FTUsrEmail' => $aData ['FTUsrEmail'],
				'FTUsrPwd' => $aData ['FTUsrPwd'],
				'FTUsrTel' => $aData ['FTUsrTel'],
				'FTUsrAddrNo' => $aData ['FTUsrAddrNo'],
				'FTUsrRoad' => $aData ['FTUsrRoad'],
				'FTUsrVillage' => $aData ['FTUsrVillage'],
				'FTUsrSoi' => $aData ['FTUsrSoi'],
				'FTUsrSubDist' => $aData ['FTUsrSubDist'],
				'FTDstCode' => $aData ['FTDstCode'],
				'FTPvnCode' => $aData ['FTPvnCode'],
				'FTUsrPostCode' => $aData ['FTUsrPostCode'],
				'FDUsrDateExp' => $aData ['FDUsrDateExp'],
				'FTPmoCode' => $aData ['FTPmoCode'],
				'FNGahID' => $aData ['FNGahID'],
				'FTWhoIns' => $aData ['FTWhoIns'],
				'FDDateIns' => $aData ['FDDateIns'],
				'FTTimeIns' => $aData ['FTTimeIns'] 
		) );
		$this->nUsrID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMUser_L', array (
				'FNUsrID' => $this->nUsrID,
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FTUsrName' => $aData ['FTUsrName'] 
		) );
		return $this->nUsrID;
	}
	public function FSxMUSRPhotoAdd($aData) {
		$this->db->insert ( 'TTKMImgPerson', array (
				'FNImgRefID' => $this->nUsrID,
				'FTImgObj' => $aData ['FTImgObj'],
				'FTImgType' => '3',
				'FNImgSeq' => '1' 
		) );
	}
	public function FSxMUSREdit($aData) {
		$this->db->where ( 'FNUsrID', $aData ['FNUsrID'] );
		$this->db->update ( 'TTKMUser', array (
				'FTUsrEmail' => $aData ['FTUsrEmail'],
				'FTUsrTel' => $aData ['FTUsrTel'],
				'FTUsrAddrNo' => $aData ['FTUsrAddrNo'],
				'FTUsrRoad' => $aData ['FTUsrRoad'],
				'FTUsrVillage' => $aData ['FTUsrVillage'],
				'FTUsrSoi' => $aData ['FTUsrSoi'],
				'FTUsrSubDist' => $aData ['FTUsrSubDist'],
				'FTDstCode' => $aData ['FTDstCode'],
				'FTPvnCode' => $aData ['FTPvnCode'],
				'FTUsrPostCode' => $aData ['FTUsrPostCode'],
				'FDUsrDateExp' => $aData ['FDUsrDateExp'],
				'FNGahID' => $aData ['FNGahID'],
				'FTPmoCode' => $aData ['FTPmoCode'],
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		$nChk = FSnCheckUpdateLang ( 'TTKMUser_L', 'FNUsrID', $aData ['FNUsrID'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMUser_L', array (
					'FNUsrID' => $aData ['FNUsrID'],
					'FTUsrName' => $aData ['FTUsrName'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
			) );
		} else {
			$this->db->where ( 'FNUsrID', $aData ['FNUsrID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMUser_L', array (
					'FTUsrName' => $aData ['FTUsrName'] 
			) );
		}
	}
	public function FSxMUSRPassEdit($aData) {
		$this->db->where ( 'FNUsrID', $aData ['FNUsrID'] );
		$this->db->update ( 'TTKMUser', array (
				'FTUsrPwd' => $aData ['FTUsrPwd'] 
		) );
	}
	public function FSxMUSRPhotoEdit($aData) {
		$oImg = FSnCheckImg ( 'TTKMImgPerson', 'FNImgRefID', $aData ['FNUsrID'], '3' );
		if ($oImg [0]->counts == 0) {
			$this->db->insert ( 'TTKMImgPerson', array (
					'FNImgRefID' => $aData ['FNUsrID'],
					'FTImgObj' => $aData ['FTImgObj'],
					'FTImgType' => '3',
					'FNImgSeq' => '1' 
			) );
		} else {
			$this->db->where ( 'FNImgRefID', $aData ['FNUsrID'] );
			$this->db->where ( 'FTImgType', '3' );
			$this->db->where ( 'FNImgSeq', '1' );
			$this->db->update ( 'TTKMImgPerson', array (
					'FTImgObj' => $aData ['FTImgObj'] 
			) );
		}
	}
	public function FSxMUSRDelete($id) {
		$this->db->where ( 'FNUsrID', $id );
		$this->db->delete ( 'TTKMUser' );
		
		$this->db->where ( 'FNUsrID', $id );
		$this->db->delete ( 'TTKMUser_L' );
	}
	public function FSxMUSRShowEdit($nID) {
		$tSQL = "SELECT USR.*,
        			USRL.FTUsrName,
					HD.FTGahName,
					HD.FTGahNameOth,
					IMG.FTImgObj,
					IMG.FNImgID
					FROM TTKMUser AS USR
        			LEFT JOIN TTKMUser_L AS USRL ON USRL.FNUsrID = USR.FNUsrID AND USRL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				    LEFT JOIN TTKMImgPerson AS IMG ON IMG.FNImgRefID = USR.FNUsrID AND IMG.FTImgType = '3' AND IMG.FNImgSeq = '1'
					LEFT JOIN TTKMGrpAlwHD AS HD ON HD.FNGahID = USR.FNGahID
        		WHERE USR.FNUsrID = '$nID'		
        		";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRCheckUser($tuser) {
		$this->db->select ( 'FTUsrEmail' );
		$this->db->from ( 'TTKMUser' );
		$this->db->where ( 'FTUsrEmail', $tuser );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return 'false';
		} else {
			return 'true';
		}
	}
	public function FSxMUSRCheckPass($tpass) {
		$this->db->select ( 'FNUsrID, FTUsrPwd' );
		$this->db->from ( 'TTKMUser' );
		$this->db->where ( 'FNUsrID', $this->session->userdata ( "tSesUsername" ) );
		$this->db->where ( 'FTUsrPwd', md5 ( $tpass ) );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return 'true';
		} else {
			return 'false';
		}
	}
	public function FSxMUSRSavePass($tdata) {
		$this->db->where ( 'FNUsrID', $this->session->userdata ( "tSesUsername" ) );
		$this->db->update ( 'TTKMUser', array (
				'	FTUsrPwd' => $tdata 
		) );
	}
	public function FSxMUSRPvlHD() {
		$this->db->select ( '*' );
		$this->db->from ( 'TTKMGrpAlwHD' );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRGrpMenus() {
		$this->db->select ( '*' );
		$this->db->from ( 'TTKMGrpAlwDT' );
		$this->db->where ( 'FNGadRefID', '34' );
		$this->db->where ( 'FTGadType', '1' );
		$this->db->where ( 'FNGahID', $this->session->userdata ( "FTUsrGrpAlw" ) );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRProvince() {
		$tSQL = "SELECT TTKMProvince.*, TTKMProvince_L.*
		FROM TTKMProvince
		LEFT JOIN TTKMProvince_L ON TTKMProvince_L.FNPvnID = TTKMProvince.FNPvnID
		AND TTKMProvince_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRDistrict($nID) {
		$tSQL = "SELECT TTKMDistrict.*, TTKMDistrict_L.FTDstName
        		 FROM TTKMDistrict
				 INNER JOIN TTKMDistrict_L ON TTKMDistrict_L.FNDstID = TTKMDistrict.FNDstID AND TTKMDistrict_L.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE TTKMDistrict.FNPvnID = '$nID'";
		$query = $this->db->query ( $tSQL );
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRModel() {
		$this->db->select ( '*' );
		$this->db->from ( 'TTKMPdtModel' );
		$this->db->join ( 'TTKMPdtModel_L', 'TTKMPdtModel_L.FNPmoID = TTKMPdtModel.FNPmoID', 'LEFT' );
		$this->db->where ( 'TTKMPdtModel_L.FNLngID', $this->session->userdata ( "tLangEdit" ) );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRView($nID) {
		$tSQL = "SELECT USR.*,
        			USRL.FTUsrName,
					HD.FTGahName,
					HD.FTGahNameOth,
					IMG.FTImgObj,
					IMG.FNImgID,
					MODL.FTPmoName,
					DISL.FTDstName,
					PRVL.FTPvnName
					FROM TTKMUser AS USR
        			LEFT JOIN TTKMUser_L AS USRL ON USRL.FNUsrID = USR.FNUsrID AND USRL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        			LEFT JOIN TTKMDistrict_L AS DISL ON DISL.FNDstID = USR.FTDstCode AND DISL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
	        		
	        		LEFT JOIN TTKMProvince_L AS PRVL ON PRVL.FNPvnID = USR.FTPvnCode AND PRVL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
	        		LEFT JOIN TTKMPdtModel_L AS MODL ON MODL.FNPmoID = USR.FTPmoCode AND MODL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
	        		
	        		LEFT JOIN TTKMImgPerson AS IMG ON IMG.FNImgRefID = USR.FNUsrID AND IMG.FTImgType = '3' AND IMG.FNImgSeq = '1'
	        		LEFT JOIN TTKMGrpAlwHD AS HD ON HD.FNGahID = USR.FNGahID
	        		WHERE USR.FNUsrID = '$nID'
	        			";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMUSRAuthen() {
		$tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '11' AND FNGahID = '" . $this->session->userdata ( "FNGahID" ) . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	
}
