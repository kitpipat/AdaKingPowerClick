<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mCustomer extends CI_Model {
	public $nFNCstID;
	private function FCNaMCSTCallLenData($pnPerPage, $pnPage) {
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
	public function FSxMCSTAuthen($nGadRefID) {
		$tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '$nGadRefID' AND FNGahID = '" . $this->session->userdata ( "FNGahID" ) . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMCSTList($tCstName, $tCardID, $tPhone, $nPageNo = 1) {
		$aRowLen = $this->FCNaMCSTCallLenData ( 8, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSQL = "SELECT c.* FROM(
				 SELECT ROW_NUMBER() OVER(ORDER BY CST.FNCstID  DESC) AS RowID,
						CST.*,
						IMG.FTImgTable, 
	        			CSTL.FTCstName,   
						IMG.FTImgObj,
						IMG.FNImgID
				FROM TTKMCst AS CST
        		LEFT JOIN TTKMCst_L AS CSTL ON CSTL.FNCstID = CST.FNCstID AND CSTL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        		LEFT JOIN TCNMImgPerson AS IMG ON IMG.FTImgRefID = CST.FNCstID AND IMG.FTImgTable = 'TTKMCustomer' AND IMG.FNImgSeq = '1'	
        		WHERE 1 = 1 
        	    ";
		if ($tCardID != '') {
			$tSQL .= " AND CST.FTCstCardID LIKE '%$tCardID%'";
		}
		if ($tPhone != '') {
			$tSQL .= " AND CST.FTCstMo LIKE '%$tPhone%'";
		}
		if ($tCstName != '') {
			$tSQL .= " AND CSTL.FTCstName LIKE '%$tCstName%'";
		}
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMCSTCount($tCstName, $tCardID, $tPhone) {
		$tSQL = "SELECT COUNT(CST.FNCstID) AS counts
				 FROM TTKMCst AS CST
        		 LEFT JOIN TTKMCst_L AS CSTL ON CSTL.FNCstID = CST.FNCstID AND CSTL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        		  WHERE 1=1 
        		";
		if ($tCardID != '') {
			$tSQL .= " AND CST.FTCstCardID LIKE '%$tCardID%'";
		}
		if ($tPhone != '') {
			$tSQL .= " AND CST.FTCstMo LIKE '%$tPhone%'";
		}
		if ($tCstName != '') {
			$tSQL .= " AND CSTL.FTCstName LIKE '%$tCstName%'";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}

	// public function FSxMCSTDel($nFNCstID) {
	// 	$this->db->where ( 'FNCstID', $nFNCstID );
	// 	$this->db->delete ( 'TTKMCst' );
	// 	$this->db->where ( 'FNCstID', $nFNCstID );
	// 	$this->db->delete ( 'TTKMCst_L' );
	// }

	public function FSxMCSTDel($nFNCstID) {
        $tSQL = "SELECT COUNT(FNCstID) AS count
		FROM TTKMCst
		WHERE FNCstID = '$nFNCstID'";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count != 0) {
			$this->db->where ( 'FNCstID', $nFNCstID );
			$this->db->delete ( 'TTKMCst' );
			$this->db->where ( 'FNCstID', $nFNCstID );
			$this->db->delete ( 'TTKMCst_L' );
            return 1;
        } else {
            return 0;
        }
	}
	

	public function FSxMCSTGRP() {
		// $tSQL = "SELECT GRP.*, GRPL.FTCgpName
		// 	     FROM TTKMCstGrp AS GRP
        // 	     LEFT JOIN TTKMCstGrp_L AS GRPL ON GRPL.FNCgpID = GRP.FNCgpID AND GRPL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
		// 	    ";
		$tSQL = "SELECT GRP.*, GRPL.FTCgpName
			     FROM TTKMCstGrp AS GRP
        	     LEFT JOIN TTKMCstGrp_L AS GRPL ON GRPL.FTCgpCode = GRP.FTCgpCode AND GRPL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        	    ";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMCSTTYPE() {
		// $tSQL = "SELECT TYE.*, TYEL.FTCtyName
		// 	     FROM TTKMCstType AS TYE
        // 	     LEFT JOIN TTKMCstType_L AS TYEL ON TYEL.FNCtyID = TYE.FNCtyID AND TYEL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
		// 	    ";
		$tSQL = "SELECT TYE.*, TYEL.FTCtyName
			     FROM TTKMCstType AS TYE
        	     LEFT JOIN TTKMCstType_L AS TYEL ON TYEL.FTCtyCode = TYE.FTCtyCode AND TYEL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        	    ";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMCSTShow($nCstID) {
		$tSQL = "SELECT CST.*, 
				 CSTL.FTCstName,
				 IMG.FTImgObj,
				 IMG.FNImgID,
				 IMG.FTImgRefID
			     FROM TTKMCst AS CST
        	     LEFT JOIN TTKMCst_L AS CSTL ON CSTL.FNCstID = CST.FNCstID AND CSTL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        	     LEFT JOIN TCNMImgPerson AS IMG ON IMG.FTImgRefID = CST.FNCstID AND IMG.FTImgTable = 'TTKMCustomer' AND IMG.FNImgSeq = '1'
        	     WHERE CST.FNCstID = '$nCstID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMCSTAdd($aData) {
		$this->db->insert ( 'TTKMCst', array (
				'FTCstCardID' => $aData ['FTCstCardID'],
				'FTCstTel' => $aData ['FTCstTel'],
				'FTCstFax' => $aData ['FTCstFax'],
				'FTCstMo' => $aData ['FTCstMo'],
				'FTCstEmail' => $aData ['FTCstEmail'],
				'FTCstPwd' => $aData ['FTCstPwd'],
				'FTCstTaxNo' => $aData ['FTCstTaxNo'],
				'FDCstDob' => $aData ['FDCstDob'],
				'FTCstCareer' => $aData ['FTCstCareer'],
				'FTCstCrdNo' => $aData ['FTCstCrdNo'],
				'FDCstApply' => $aData ['FDCstApply'],
				'FDCstCrdIssue' => $aData ['FDCstCrdIssue'],
				'FDCstCrdExpire' => $aData ['FDCstCrdExpire'],
				'FTCstSex' => $aData ['FTCstSex'],
				'FTCstStaLocal' => $aData ['FTCstStaLocal'],
				'FTCstBusiness' => $aData ['FTCstBusiness'],
				'FTCstStaAge' => $aData ['FTCstStaAge'],
				'FTCstStaActive' => $aData ['FTCstStaActive'],
				'FNCtyID' => $aData ['FNCtyID'],
				'FNCgpID' => $aData ['FNCgpID'],
				'FTCstStaApv' => 1,
				'FTBchCode' => $this->session->userdata ( "PmoCode" ),
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		
		$this->nFNCstID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMCst_L', array (
				'FNCstID' => $this->nFNCstID,
				'FTCstName' => $aData ['FTCstName'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
		) );
		return $this->nFNCstID;
	}
	public function FSxMCSTAddImg($aData) {
		$this->db->insert ( 'TCNMImgPerson', array (
				'FNImgRefID' => $this->nFNCstID,
				'FTImgObj' => $aData ['FTImgObj'],
				'FTImgType' => '1',
				'FNImgSeq' => '1' 
		) );
	}
	public function FSxMCSTEdit($aData) {
		$nChk = FSnCheckUpdateLang ( 'TTKMCst_L', 'FNCstID', $aData ['FNCstID'] );
		$this->db->where ( 'FNCstID', $aData ['FNCstID'] );
		$this->db->update ( 'TTKMCst', array (
				'FTCstCardID' => $aData ['FTCstCardID'],
				'FTCstTel' => $aData ['FTCstTel'],
				'FTCstFax' => $aData ['FTCstFax'],
				'FTCstMo' => $aData ['FTCstMo'],
				//'FTCstEmail' => $aData ['FTCstEmail'],
				//'FTCstPwd' => $aData ['FTCstPwd'],
				'FTCstTaxNo' => $aData ['FTCstTaxNo'],
				'FDCstDob' => $aData ['FDCstDob'],
				'FTCstCareer' => $aData ['FTCstCareer'],
				'FTCstCrdNo' => $aData ['FTCstCrdNo'],
				'FDCstApply' => $aData ['FDCstApply'],
				'FDCstCrdIssue' => $aData ['FDCstCrdIssue'],
				'FDCstCrdExpire' => $aData ['FDCstCrdExpire'],
				'FTCstSex' => $aData ['FTCstSex'],
				'FTCstStaLocal' => $aData ['FTCstStaLocal'],
				'FTCstBusiness' => $aData ['FTCstBusiness'],
				'FTCstStaAge' => $aData ['FTCstStaAge'],
				'FTCstStaActive' => $aData ['FTCstStaActive'],
				'FNCtyID' => $aData ['FNCtyID'],
				'FNCgpID' => $aData ['FNCgpID'],
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMCst_L', array (
					'FNCstID' => $aData ['FNCstID'],
					'FTCstName' => $aData ['FTCstName'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
			) );
		} else {
			$this->db->where ( 'FNCstID', $aData ['FNCstID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMCst_L', array (
					'FTCstName' => $aData ['FTCstName'] 
			) );
		}
	}
	
	public function FSxMCSTEditPwd($aData) {
		$this->db->where ( 'FNCstID', $aData ['FNCstID'] );
		$this->db->update ( 'TTKMCst', array (
				'FTCstPwd' => $aData ['FTCstPwd']
		) );
	}
	
	public function FSxMCSTEditImg($aData) {
		$oImg = FSnCheckImg ( 'TCNMImgPerson', 'FNImgRefID', $aData ['FNCstID'], '1' );
		if ($oImg [0]->counts == 0) {
			$this->db->insert ( 'TCNMImgPerson', array (
					'FNImgRefID' => $aData ['FNCstID'],
					'FTImgObj' => $aData ['FTImgObj'],
					'FTImgType' => '1',
					'FNImgSeq' => '1' 
			) );
		} else {
			$this->db->where ( 'FNImgRefID', $aData ['FNCstID'] );
			$this->db->where ( 'FTImgType', '1' );
			$this->db->where ( 'FNImgSeq', '1' );
			$this->db->update ( 'TCNMImgPerson', array (
					'FTImgObj' => $aData ['FTImgObj'] 
			) );
		}
	}
	public function FSxMCSTCheckEmail($tEmail) {
		$this->db->select ( 'FTCstEmail' );
		$this->db->from ( 'TTKMCst' );
		$this->db->where ( 'FTCstEmail', $tEmail );
		$query = $this->db->get ();
		if ($query->num_rows () > 0) {
			return 'false';
		} else {
			return 'true';
		}
	}
	
	/**
	 * * ประเภทลูกค้า **
	 */
	public function FSxMCSTCategoryAjaxList($tFTCtyName, $nPageNo = 1) {
		$aRowLen = $this->FCNaMCSTCallLenData ( 8, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSQL = "SELECT c.FNCtyID, c.FTCtyName, c.RowID FROM(
				 SELECT ROW_NUMBER() OVER(ORDER BY CTY.FNCtyID  DESC) AS RowID,
						CTY.*,
	        			CTYL.FTCtyName
				FROM TTKMCstType AS CTY
        		LEFT JOIN TTKMCstType_L AS CTYL ON CTYL.FNCtyID = CTY.FNCtyID AND CTYL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        	    ";
		if ($tFTCtyName != '') {
			$tSQL .= " WHERE CTYL.FTCtyName LIKE '%$tFTCtyName%'";
		}
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1] ORDER BY c.FNCtyID  DESC";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMCSTCategoryCount($tFTCtyName) {
		$tSQL = "SELECT COUNT(CTY.FNCtyID) AS counts
				 FROM TTKMCstType AS CTY
        		 LEFT JOIN TTKMCstType_L AS CTYL ON CTYL.FNCtyID = CTY.FNCtyID AND CTYL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        		";
		if ($tFTCtyName != '') {
			$tSQL .= " WHERE CTYL.FTCtyName LIKE '%$tFTCtyName%'";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMCSTCategoryDelete($nFNCtyID) {
		$tSQL = "SELECT COUNT(FNCstID) AS count
		FROM TTKMCst
		WHERE FNCtyID = '$nFNCtyID'";
		$query = $this->db->query ( $tSQL );
		$oResult = $query->result ();
		if ($oResult [0]->count == 0) {
			$this->db->where ( 'FNCtyID', $nFNCtyID );
			$this->db->delete ( 'TTKMCstType' );
			
			$this->db->where ( 'FNCtyID', $nFNCtyID );
			$this->db->delete ( 'TTKMCstType_L' );
			return 1;
		} else {
			return 0;
		}
	}
	public function FSxMCSTCategoryAddAjax($aData) {
		$this->db->insert ( 'TTKMCstType', array (
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$nFNCtyID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMCstType_L', array (
				'FNCtyID' => $nFNCtyID,
				'FTCtyName' => $aData ['FTCtyName'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
		) );
		return $nFNCtyID;
	}
	public function FSxMCSTCategoryEditAjax($aData) {
		$nChk = FSnCheckUpdateLang ( 'TTKMCstType_L', 'FNCtyID', $aData ['FNCtyID'] );
		$this->db->where ( 'FNCtyID', $aData ['FNCtyID'] );
		$this->db->update ( 'TTKMCstType', array (
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMCstType_L', array (
					'FNCtyID' => $aData ['FNCtyID'],
					'FTCtyName' => $aData ['FTCtyName'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
			) );
		} else {			
			$this->db->where ( 'FNCtyID', $aData ['FNCtyID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMCstType_L', array (
					'FTCtyName' => $aData ['FTCtyName'] 
			) );
		}
	}
	public function FSxMCSTCategoryEdit($nFNCtyID) {
		$tSQL = "SELECT CTY.*, CTYL.FTCtyName
				 FROM TTKMCstType AS CTY
        		 LEFT JOIN TTKMCstType_L AS CTYL ON CTYL.FNCtyID = CTY.FNCtyID AND CTYL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
	        	 WHERE CTY.FNCtyID = '$nFNCtyID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	
	/**
	 * * กลุ่มลูกค้า **
	 */
	public function FSxMCSTGroupAjaxList($tFTCgpName, $nPageNo = 1) {
		$aRowLen = $this->FCNaMCSTCallLenData ( 8, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSQL = "SELECT c.FNCgpID, c.FTCgpName, c.RowID FROM(
				 SELECT ROW_NUMBER() OVER(ORDER BY GRP.FNCgpID DESC) AS RowID,
						GRP.*,
	        			GRPL.FTCgpName
				FROM TTKMCstGrp AS GRP
        		LEFT JOIN TTKMCstGrp_L AS GRPL ON GRPL.FNCgpID = GRP.FNCgpID AND GRPL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        		     				
        		";
		if ($tFTCgpName != '') {
			$tSQL .= " WHERE GRPL.FTCgpName LIKE '%$tFTCgpName%'";
		}
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1] ORDER BY c.FNCgpID DESC";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMCSTGroupCount($tFTCgpName) {
		$tSQL = "SELECT COUNT(GRP.FNCgpID) AS counts
				 FROM TTKMCstGrp AS GRP
        		 LEFT JOIN TTKMCstGrp_L AS GRPL ON GRPL.FNCgpID = GRP.FNCgpID AND GRPL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
        		";
		if ($tFTCgpName != '') {
			$tSQL .= " WHERE GRPL.FTCgpName LIKE '%$tFTCgpName%'";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMCSTGroupDelete($nFNCgpID) {
		$tSQL = "SELECT COUNT(FNCstID) AS count
		FROM TTKMCst
		WHERE FNCgpID = '$nFNCgpID'";
		$query = $this->db->query ( $tSQL );
		$oResult = $query->result ();
		if ($oResult [0]->count == 0) {
			$this->db->where ( 'FNCgpID', $nFNCgpID );
			$this->db->delete ( 'TTKMCstGrp' );
			
			$this->db->where ( 'FNCgpID', $nFNCgpID );
			$this->db->delete ( 'TTKMCstGrp_L' );
			return 1;
		} else {
			return 0;
		}
	}
	public function FSxMCSTGroupAddAjax($aData) {
		$this->db->insert ( 'TTKMCstGrp', array (
				'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
				'FDDateIns' => date ( 'Y-m-d' ),
				'FTTimeIns' => date ( 'h:i:s' ) 
		) );
		$nFNCgpID = $this->db->insert_id ();
		$this->db->insert ( 'TTKMCstGrp_L', array (
				'FNCgpID' => $nFNCgpID,
				'FTCgpName' => $aData ['FTCgpName'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
		) );
		return $nFNCgpID;
	}
	public function FSxMCSTGroupEditAjax($aData) {
		$nChk = FSnCheckUpdateLang ( 'TTKMCstGrp_L', 'FNCgpID', $aData ['FNCgpID'] );
		$this->db->where ( 'FNCgpID', $aData ['FNCgpID'] );
		$this->db->update ( 'TTKMCstGrp', array (
				'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
				'FDDateUpd' => date ( 'Y-m-d' ),
				'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TTKMCstGrp_L', array (
					'FNCgpID' => $aData ['FNCgpID'],
					'FTCgpName' => $aData ['FTCgpName'],
					'FNLngID' => $this->session->userdata ( "tLangEdit" ) 
			) );
		} else {
			
			$this->db->where ( 'FNCgpID', $aData ['FNCgpID'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TTKMCstGrp_L', array (
					'FTCgpName' => $aData ['FTCgpName'] 
			) );
		}
	}
	public function FSxMCSTGroupEdit($nFNCgpID) {
		$tSQL = "SELECT GRP.*, GRPL.FTCgpName
				 FROM TTKMCstGrp AS GRP
        		 LEFT JOIN TTKMCstGrp_L AS GRPL ON GRPL.FNCgpID = GRP.FNCgpID AND GRPL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
	        	 WHERE GRP.FNCgpID = '$nFNCgpID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
}

?>
