<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mShowTime extends CI_Model {
	private function FCNaMSHTCallLenData($pnPerPage, $pnPage) {
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
	public function FSaMSHTLocList($tFTLocName, $nEventID, $nPageNo = 1) {
		$aRowLen = $this->FCNaMSHTCallLenData ( 5, $nPageNo ); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
		$tSqlLocName = "";
		if ($tFTLocName != '') {
			$tSqlLocName = " AND LOCL.FTLocName LIKE '%$tFTLocName%'";
		}

		$tSQL = "
				SELECT 
				DISTINCT 
				c.FNEvnID, 
				c.FNLocID, 
				c.FNLocLimit,				
				c.FTLocName,
				c.FTPmoName,
				c.FTImgObj,
				b.FNCountTimeSet
				FROM(
				SELECT ROW_NUMBER() OVER(ORDER BY SHT.FNEvnID DESC) AS RowID,
				SHT.FNEvnID, 
				SHT.FNLocID, 
				LOC.FNLocLimit,				
				LOCL.FTLocName,
				MODL.FTPmoName,
				OBJ.FTImgObj			
				
				FROM TTKTShowTime AS SHT				
				INNER JOIN TTKMLocation AS LOC ON LOC.FNLocID = SHT.FNLocID
				LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = SHT.FNLocID AND LOCL.FNLngID = '1'
				LEFT JOIN TTKMPdtModel_L AS MODL ON MODL.FNPmoID = LOC.FNPmoID AND MODL.FNLngID = '1'			
				LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = LOC.FNLocID AND OBJ.FTImgTable = 'TTKMLocation'	AND FTImgKey = 'main' 		 		
				WHERE SHT.FNEvnID = '" . $nEventID . "' $tSqlLocName 
				) AS c LEFT JOIN (SELECT FNLocID, sum(CASE FNTmhID  WHEN 0 THEN 0  ELSE 1 END ) as FNCountTimeSet FROM TTKTShowTime where FNEvnID = '$nEventID' group by FNLocID) b	ON c.FNLocID = b.FNLocID WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSaMSHTLocCount($tFTLocName, $nEventID) {
		$tSqlLocName = "";
		if ($tFTLocName != '') {
			$tSqlLocName = " AND LOCL.FTLocName LIKE '%$tFTLocName%'";
		}
		$tSQL = "SELECT COUNT(DISTINCT SHT.FNLocID) AS counts
				 FROM TTKTShowTime AS SHT
				 LEFT JOIN TTKMLocation_L AS LOCL ON LOCL.FNLocID = SHT.FNLocID AND LOCL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE SHT.FNEvnID = '" . $nEventID . "' $tSqlLocName";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMSHTEventInfo($nEvnID) {
		$tSQL = "SELECT EVT.*,				
					EVTL.FTEvnName,
					EVTL.FTEvnDesc1,
					EVTL.FTEvnDesc2,
					EVTL.FTEvnDesc3,
					EVTL.FTEvnDesc4,
					EVTL.FTEvnDesc5,
					EVTL.FTEvnRemark,
					OBJ.FTImgObj,
					OBJ.FNImgID
				 	FROM TTKMEvent AS EVT
						LEFT JOIN TTKMEvent_L AS EVTL ON EVTL.FNEvnID = EVT.FNEvnID AND EVTL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				    	LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = EVT.FNEvnID AND OBJ.FTImgTable = 'TTKMEvent'
					WHERE EVT.FNEvnID = '$nEvnID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	
	public function FSxMSHTShowPrk($nEvnID) {
		$tSQL = "   SELECT MODL.FTPmoName, MODL.FNPmoID
					FROM TTKMEvent AS EVT
					LEFT JOIN TTKMTchGroup AS TCH ON TCH.FNTcgID = EVT.FNTcgID
					LEFT JOIN TTKMPdtModel_L AS MODL ON MODL.FNPmoID = TCH.FNPmoID AND MODL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "' 
					WHERE EVT.FNEvnID = '$nEvnID'		 			
				";

		$oQuery = $this->db->query ( $tSQL );		
		$oResult = $oQuery->result ();		
		// ถ้า TTKMTchGroup FNPmoID = null จะแสดงสาขาทั้งหมด
		if ($oResult[0]->FNPmoID == "") {
				$tSQL2 = " SELECT MODL.FTBchName AS FTPmoName, MOD.FTBchCode AS FNPmoID 
					FROM TCNMBranch AS MOD
					LEFT JOIN TCNMBranch_L AS MODL ON MODL.FTBchCode = MOD.FTBchCode AND MODL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
					WHERE FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
					";
				$oQuery2 = $this->db->query ( $tSQL2 );
				return $oQuery2->result ();
		} else {
			return $oResult;
		}
	}
	
	public function FSxMSHTLocList($aData) {

		$tSqlLocName = '';
		if ($aData ['FTLocName'] != "") {
			$tSqlLocName = " WHERE LQ.FTLocName = '" . $aData ['FTLocName'] . "'";
		}
		$tSQL = "SELECT L.*,LQ.FTLocName, OBJ.FTImgObj FROM( SELECT * FROM TTKMLocation LOC 
				              WHERE LOC.FNPmoID = '" . $aData ['FNPmoID'] . "'
				              AND LOC.FNLocID NOT IN(SELECT LOC.FNLocID  FROM  TTKTShowTime SHT 
							  INNER JOIN TTKMLocation LOC ON SHT.FNLocID = LOC.FNLocID AND LOC.FNPmoID = '" . $aData ['FNPmoID'] . "'
							  WHERE SHT.FNEvnID = '" . $aData ['FNEvnID'] . "'))  AS L
				 	  INNER JOIN (SELECT DISTINCT(ZNE.FNLocID) AS FNLocID  
            	 	  FROM TTKTPkgList PKG 
				 			  INNER JOIN TTKTPkgPark PRK ON PKG.FNPkgID = PRK.FNPkgID AND PRK.FNPmoID = '" . $aData ['FNPmoID'] . "' AND PRK.FTPpkType = 1
				 			  INNER JOIN TTKMLocZone ZNE  ON PRK.FNZneID =  ZNE.FNZneID) AS P ON L.FNLocID = P.FNLocID				 			
				 			  LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = L.FNLocID AND OBJ.FTImgTable = 'TTKMLocation' 				 			
				 			  LEFT JOIN TTKMLocation_L LQ ON L.FNLocID = LQ.FNLocID AND FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
					 $tSqlLocName";

		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMSHTPkgList($nLocID) {
		$tSQL = "SELECT DISTINCT PKGL.FNPkgID ,PKGL.FTPkgName
				 FROM TTKMLocZone AS ZNE 
			     	INNER JOIN TTKTPkgPark AS PGP ON PGP.FNZneID = ZNE.FNZneID AND PGP.FTPpkType = '1'
				 	INNER JOIN TTKTPkgList AS PKG ON PKG.FNPkgID = PGP.FNPkgID AND PKG.FNEvnID IS NULL
			     	INNER JOIN TTKTPkgList_L AS PKGL ON PKGL.FNPkgID = PKG.FNPkgID AND PKGL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE ZNE.FNLocID = '" . $nLocID . "'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMSHTUpdatePkg($aData) {
		$this->db->where ( 'FNPkgID', $aData ['FNPkgID'] );
		$this->db->update ( 'TTKTPkgList', array (
				'FNEvnID' => $aData ['FNEvnID'] 
		) );
	}
	public function FSxMSHTAddLoc($aData) {
		$this->db->insert ( 'TTKTShowTime', array (
				'FNEvnID' => $aData ['FNEvnID'],
				'FNLocID' => $aData ['FNLocID'],
				'FDShwStartDate' => date('Y-m-d H:i'),
				'FNTmhID' => '',
		) );
	}
	public function FSxMSHTDelShowTime($aData) {
		$this->db->where ( 'FNEvnID', $aData ['FNEvnID'] );
		$this->db->where ( 'FNLocID', $aData ['FNLocID'] );
		$this->db->delete ( 'TTKTShowTime' );
	}
	public function FSxMSHTCheckLocList($nEventID) {
		$tSQL = "
			     SELECT *
				 FROM TTKTShowTime
				 WHERE FNEvnID = '$nEventID'
				 ";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMSHTChkPkg($nLocID) {
		$tSQL = "SELECT ZNE.FNZneID, PKG.FNPkgID			     
				 FROM TTKMLocZone AS ZNE	
				 LEFT JOIN TTKTPkgPark AS PKG ON PKG.FNZneID = ZNE.FNZneID
				 WHERE ZNE.FNLocID = '$nLocID'
				 ";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
	public function FSxMSHTDelPkg($aData) {
		$this->db->where ( 'FNEvnID', $aData ['FNEvnID'] );
		$this->db->where ( 'FNPkgID', $aData ['FNPkgID'] );
		$this->db->update ( 'TTKTPkgList', array (
				'FNEvnID' => NULL 
		) );
	}
	public function FSxMSHTPackageList($nLocID, $nEvnID) {
		$tSQL = "SELECT DISTINCT PKG.FNPkgID, PKGL.FTPkgName
				 FROM TTKMLocZone AS ZNE
				 LEFT JOIN TTKTPkgPark AS PGP ON PGP.FNZneID = ZNE.FNZneID
				 INNER JOIN TTKTPkgList AS PKG ON PKG.FNPkgID = PGP.FNPkgID AND PKG.FNEvnID = '$nEvnID'
				 LEFT JOIN TTKTPkgList_L AS PKGL ON PKGL.FNPkgID = PKG.FNPkgID AND PKGL.FNLngID = '" . $this->session->userdata ( "tLangEdit" ) . "'
				 WHERE ZNE.FNLocID = '$nLocID'";
		$oQuery = $this->db->query ( $tSQL );
		if ($oQuery->num_rows () > 0) {
			return $oQuery->result ();
		} else {
			return false;
		}
	}
}
?>
