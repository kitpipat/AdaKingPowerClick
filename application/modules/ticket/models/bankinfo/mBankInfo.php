<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mBankInfo extends CI_Model {
	private function FCNaMBIFCallLenData($pnPerPage, $pnPage) {
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
	public function FSxMBIFList($tFTBIFName, $nPageNo = 1) {
		$aRowLen = $this->FCNaMBIFCallLenData ( 8, $nPageNo );	
		$tSQL = "SELECT c.* FROM(
		SELECT ROW_NUMBER() OVER(ORDER BY BBK.FTBbkCode DESC) AS RowID,	
		BBK.*, 
		BKL.FTBbkName,
		BKL.FTBbkBranch,				
		BKL.FTBbkRmk,
		IMG.FTImgObj,
		MBKL.FTBnkName	
		FROM TFNMBookBank BBK
		LEFT JOIN TFNMBookBank_L BKL ON BKL.FTBbkCode = BBK.FTBbkCode AND BKL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
		INNER JOIN TFNMBank_L MBKL ON MBKL.FTBnkCode = BBK.FTBnkCode AND MBKL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
		LEFT JOIN TCNMImgObj IMG ON IMG.FTImgRefID = BBK.FTBbkCode AND FTImgTable = 'TFNMBookBank'";
		if ($tFTBIFName != '') {
			$tSQL .= " WHERE MBKL.FTBnkName LIKE '%$tFTBIFName%'";
		}		
		$tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";                
                
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FStMBIFCount($tFTBIFName) {
		$tSQL = "SELECT COUNT(BBK.FTBbkCode) AS counts
		FROM TFNMBookBank BBK
		LEFT JOIN TFNMBookBank_L BKL ON BKL.FTBbkCode = BBK.FTBbkCode AND BKL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'";
		if ($tFTBIFName != '') {
			$tSQL .= " WHERE BKL.FTBbkName LIKE '%$tFTBIFName%'";
		}
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxCBIFView($tBkCode) {
		$tSQL = "
		SELECT
		BBK.*, 
		BKL.FTBbkName,
		BKL.FTBbkBranch,				
		BKL.FTBbkRmk,
		IMG.FTImgObj,		
		IMG.FNImgID		
		FROM TFNMBookBank BBK
		LEFT JOIN TFNMBookBank_L BKL ON BKL.FTBbkCode = BBK.FTBbkCode AND BKL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
		LEFT JOIN TCNMImgObj IMG ON IMG.FTImgRefID = BBK.FTBbkCode AND FTImgTable = 'TFNMBookBank'		
		WHERE BBK.FTBbkCode = '$tBkCode'";	
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxCBIFBnkMaster() {
		$tSQL = "SELECT * FROM TFNMBank_L BBKL WHERE FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'";	
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMBIFAdd($aData) {
		$this->db->insert ( 'TFNMBookBank', array (
			'FTBbkCode'    => $aData ['FTBbkCode'],
			'FTBnkCode'    => $aData ['FTBnkCode'],
			'FTBbkAccNo'   => $aData ['FTBbkAccNo'],
			// 'FTBnkCode'    => $aData ['FTBnkCode'],
			'FTBbkType'    => $aData ['FTBbkType'],
			'FDBbkOpen'    => $aData ['FDBbkOpen'],
			'FCBbkBalance' => $aData ['FCBbkBalance'],
			'FTBbkStaActive' => $aData ['FTBbkStaActive'],
			'FTWhoIns' => $this->session->userdata ( "tSesUsername" ),
			'FDDateIns' => date ( "Y-m-d h:i:s" ),
			'FTTimeIns' => date ( "h:i:s" ) 
		) );
		$this->db->insert ( 'TFNMBookBank_L', array (
			'FTBbkCode' => $aData ['FTBbkCode'],
			'FNLngID' => $this->session->userdata ( "tLangEdit" ),
			'FTBbkName' => $aData ['FTBbkName'],
			'FTBbkRmk' => $aData ['FTBbkRmk'],
			'FTBbkBranch' => $aData ['FTBbkBranch'] 
		) );
	}	
	public function FSxMBIFEdit($aData) {
		$this->db->where ( 'FTBbkCode', $aData ['FTBbkCode'] );
		$this->db->update ( 'TFNMBookBank', array (
			'FTBbkAccNo' => $aData ['FTBbkAccNo'],
			'FTBnkCode' => $aData ['FTBnkCode'],
			'FTBbkType' => $aData ['FTBbkType'],
			'FDBbkOpen' => $aData ['FDBbkOpen'],
			'FCBbkBalance' => $aData ['FCBbkBalance'],
			'FTBbkStaActive' => $aData ['FTBbkStaActive'],
			'FTWhoUpd' => $this->session->userdata ( "tSesUsername" ),
			'FDDateUpd' => date ( 'Y-m-d h:i:s' ),
			'FTTimeUpd' => date ( 'h:i:s' ) 
		) );
		$nChk = FSnCheckUpdateLang ( 'TFNMBookBank_L', 'FTBbkCode', $aData ['FTBbkCode'] );
		if ($nChk [0]->counts == 0) {
			$this->db->insert ( 'TFNMBookBank_L', array (
				'FTBbkCode' => $aData ['FTBbkCode'],
				'FNLngID' => $this->session->userdata ( "tLangEdit" ),
				'FTBbkName' => $aData ['FTBbkName'],
				'FTBbkRmk' => $aData ['FTBbkRmk'],
				'FTBbkBranch' => $aData ['FTBbkBranch'] 
			) );
		} else {
			$this->db->where ( 'FTBbkCode', $aData ['FTBbkCode'] );
			$this->db->where ( 'FNLngID', $this->session->userdata ( "tLangEdit" ) );
			$this->db->update ( 'TFNMBookBank_L', array (
				'FTBbkName' => $aData ['FTBbkName'],
				'FTBbkRmk' => $aData ['FTBbkRmk'],
				'FTBbkBranch' => $aData ['FTBbkBranch'] 
			) );
		}
	}


	public function FSxMBIFDel($nBifId) {
        $tSQL = "SELECT COUNT(FTBbkCode) AS count
        FROM TFNMBookBank
        WHERE FTBbkCode = '$nBifId'";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count != 0) {
			$this->db->where ( 'FTBbkCode', $nBifId );
			$this->db->delete ( 'TFNMBookBank' );			
			$this->db->where ( 'FTBbkCode', $nBifId );
			$this->db->delete ( 'TFNMBookBank_L' );
            return 1;
        } else {
            return 0;
        }

    }

	public function FSxMBIFAuthen() {
		$tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '5' AND FNGahID = '" . $this->session->userdata ( "FNGahID" ) . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
}
?>

