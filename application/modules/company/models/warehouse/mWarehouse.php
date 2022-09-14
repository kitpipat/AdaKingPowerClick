<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mWarehouse extends CI_Model
{
	//Functionality : delete Warehouse
	//Parameters : function parameters
	//Creator : 14/05/2018 Krit(Copter)
	//Return : response
	//Return Type : array
	public function FSnMWAHDel($paParamMaster)
	{
		$this->db->where_in('FTWahCode', $paParamMaster['FTWahCode']);
		$this->db->where('FTBchCode', $paParamMaster['FTBchCode']);
		$this->db->delete('TCNMWaHouse');

		$this->db->where_in('FTWahCode', $paParamMaster['FTWahCode']);
		$this->db->where('FTBchCode', $paParamMaster['FTBchCode']);
		$this->db->delete('TCNMWaHouse_L');


		if ($this->db->affected_rows() > 0) {
			//Success
			$aStatus = array(
				'rtCode' => '1',
				'rtDesc' => 'success',
			);
			$jStatus = json_encode($aStatus);
			$aStatus = json_decode($jStatus, true);
		} else {
			//Ploblem
			$aStatus = array(
				'rtCode' => '905',
				'rtDesc' => 'cannot Delete Item.',
			);
			$jStatus = json_encode($aStatus);
			$aStatus = json_decode($jStatus, true);
		}

		return $aStatus;
	}

	//Functionality : ดึงข้อมูล ของ ที่อยู่
	//Parameters : function parameters
	//Creator : 10/05/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSvMBCHGetAddress($ptData)
	{

		$tAddRefCode = $ptData['FTAddRefCode'];
		$tAddGrpType = $ptData['FTAddGrpType'];
		$tAddVersion = $ptData['FTAddVersion'];

		$nLngID = $ptData['FNLngID'];


		$tSQL = "SELECT  FTAddVersion,
						FTAddV1No,
						FTAddV1Soi,			
						FTAddV1Village,
						FTAddV1Road,
						FTAddV1SubDist,
						FTAddV1DstCode,
						FTCstV1PvnCode,
						FTCstV1PostCode,
						FTAddV2Desc1,
						FTAddV2Desc2
						
				FROM TCNMAddress_L
				WHERE FTAddRefCode = $tAddRefCode
				AND FTAddGrpType = $tAddGrpType
				AND FTAddVersion = $tAddVersion
				AND FNLngID = $nLngID
				";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {

			return $oQuery->result();
		} else {
			//No Data
			return false;
		}
	}

	//Functionality : หา ประเภท ของ ที่อยู่
	//Parameters : function parameters
	//Creator : 09/05/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSvMBCHGenViewAddress()
	{

		$tSQL = "
			SELECT  FTSysStaDefValue,
				FTSysStaUsrValue
			FROM TSysConfig WITH (NOLOCK)
			WHERE FTSysCode = 'tCN_AddressType' 
			AND FTSysKey = 'TCNMBranch'
		";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {

			return $oQuery->result();
		} else {
			//No Data
			return false;
		}
	}

	//Functionality : Search Branch By ID
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSaMWAHSearchByID($paData)
	{
		$tWahCode = $paData['FTWahCode'];
		$tBchCode = $paData['FTBchCode'];
		$nLngID = $paData['FNLngID'];

		if (@$tWahCode) {
			$tSQL = "
				SELECT DISTINCT
					WAH.FTBchCode   	AS rtBchCode,
					BCHL.FTBchName		AS rtBchName,
					WAH.FTWahCode   	AS rtWahCode,
					WAH.FTWahStaType 	AS rtWahStaType,
					WAH.FTWahRefCode 	AS rtWahRefCode,
					WAH.FTWahStaChkStk 	AS rtWahStaChkStk,
					WAH.FTWahStaPrcStk 	AS rtWahStaPrcStk,
					WAH.FTWahStaAlwPLFrmTBO 	AS rtWahStaAlwPLFrmTBO,
					WAH.FTWahStaAlwPLFrmSale 	AS rtWahStaAlwPLFrmSale,
					WAH.FTWahStaAlwCntStk 	AS rtWahStaAlwCntStk,
					WAH.FTWahStaAlwCostAmt 	AS rtWahStaAlwCostAmt,
					WAH.FTWahStaAlwSNPL 	AS rtWahStaAlwSNPL,
					WAHL.FTWahName  	AS rtWahName,

					BCHLR.FTBchCode  	AS rtBchCodeRef,
					BCHLR.FTBchName  	AS rtBchNameRef,
					SHPLR.FTShpCode		AS rtShpCodeRef,
					SHPLR.FTShpName  	AS rtShpNameRef,
					SPNLR.FTSpnCode		AS rtSpnCodeRef,
					SPNLR.FTSpnName  	AS rtSpnNameRef,
					POSLR.FTPosCode		AS rtPosCodeRef,
					POSLR.FTPosName		AS rtPosNameRef
				FROM [TCNMWaHouse] WAH WITH (NOLOCK)
				LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON WAH.FTWahCode   = WAHL.FTWahCode AND WAH.FTBchCode = WAHL.FTBchCode  AND WAHL.FNLngID = '$nLngID'
				LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON WAH.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = '$nLngID'
				LEFT JOIN TCNMBranch_L BCHLR WITH (NOLOCK) ON WAH.FTWahRefCode = BCHLR.FTBchCode  AND BCHLR.FNLngID = '$nLngID'
				LEFT JOIN TCNMShop_L SHPLR WITH (NOLOCK) ON WAH.FTWahRefCode = SHPLR.FTShpCode AND  WAH.FTBchCode = SHPLR.FTBchCode  AND SHPLR.FNLngID = '$nLngID'
				LEFT JOIN TCNMSpn_L SPNLR WITH (NOLOCK) ON WAH.FTWahRefCode = SPNLR.FTSpnCode  AND SPNLR.FNLngID = '$nLngID'
				LEFT JOIN TCNMPos_L POSLR WITH (NOLOCK) ON WAH.FTWahRefCode = POSLR.FTPosCode AND WAH.FTBchCode  = POSLR.FTBchCode 
				WHERE WAH.FTWahCode = '$tWahCode' AND WAH.FTBchCode='$tBchCode'  
			";

			$oQuery = $this->db->query($tSQL);

			if ($oQuery->num_rows() > 0) {
				$aDetail = $oQuery->result();
			} else {
				//No Data
				$aDetail = '';
			}
		}

		if (@$aDetail) {

			$aResult = array(
				'roItem' => $aDetail[0],
				'rtCode' => '1',
				'rtDesc' => 'success',
			);
		} else {
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

	//Functionality : list Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMWAHList($paData)
	{
		$aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
		$nLngID = $paData['FNLngID'];

		$tSQL = "
			SELECT 
				c.* 
			FROM(
				SELECT  
					ROW_NUMBER() OVER(ORDER BY rtCreateOn DESC , rtWahCode Desc) AS rtRowID,* 
				FROM
					(SELECT DISTINCT
						WAH.FTWahCode AS rtWahCode,
						WAH.FTBchCode AS rtBchCode,
						WAH.FTWahStaType AS rtWahStaType,
						WAH.FTWahRefCode AS rtWahRefCode,
						WAHL.FTWahName AS rtWahName,
						BCHL.FTBchName AS rtBchName,
						WAH.FDCreateOn AS rtCreateOn
					FROM TCNMWaHouse WAH WITH (NOLOCK)
					LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON WAH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
					LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON WAH.FTWahCode = WAHL.FTWahCode AND WAH.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $nLngID	
				WHERE 1 = 1
		";

		if ($this->session->userdata("tSesUsrLevel") != "HQ") {
			$tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
			$tSQL .= " AND WAH.FTBchCode IN($tBchCodeMulti)";
		}

		// User BCH Level ของ เก่า
		// if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
		// 	$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
		// 	$tSQL .= " AND WAH.FTBchCode IN($tBchCodeMulti) AND WAH.FTWahRefCode IN ($tBchCodeMulti) AND WAH.FTWahStaType IN ('1','2') ";
		// }

		// // User SHP Level ของ เก่า
		// if ($this->session->userdata('tSesUsrLevel') == "SHP") { // ผู้ใช้ระดับ SHP ดูได้แค่สาขาที่มีสิทธิ์
		// 	$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
		// 	$tSQL .= " AND WAH.FTBchCode IN($tBchCodeMulti)";
		// }


		$tSearchList = $paData['tSearchAll'];
		if ($tSearchList != '') {
			$tSQL .= " AND (WAH.FTWahCode COLLATE THAI_BIN LIKE  '%" . $tSearchList . "%' ";
			$tSQL .= " OR WAHL.FTWahName  COLLATE THAI_BIN LIKE  '%" . $tSearchList . "%' ";
			$tSQL .= " OR BCHL.FTBchName  COLLATE THAI_BIN LIKE  '%" . $tSearchList . "%')";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
		$oQuery = $this->db->query($tSQL);

		// echo $tSQL;
		// die;

		if ($oQuery->num_rows() > 0) {

			$aList = $oQuery->result();
			$aFoundRow = $this->JSnMWAHGetPageAll($paData, $nLngID);
			$nFoundRow = $aFoundRow[0]->counts;
			$nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

			$aResult = array(
				'raItems' => $aList,
				'rnAllRow' => $nFoundRow,
				'rnCurrentPage' => $paData['nPage'],
				"rnAllPage" => $nPageAll,
				'rtCode' => '1',
				'rtDesc' => 'success',
			);
			$jResult = json_encode($aResult);
			$aResult = json_decode($jResult, true);
		} else {
			//No Data
			$aResult = array(
				'rnAllRow' => 0,
				'rnCurrentPage' => $paData['nPage'],
				"rnAllPage" => 0,
				'rtCode' => '800',
				'rtDesc' => 'data not found',
			);
			$jResult = json_encode($aResult);
			$aResult = json_decode($jResult, true);
		}

		return $aResult;
	}

	//Functionality : All Page Of Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : 13/08/2019 Saharat(Golf)
	//Return : data
	//Return Type : Array
	function JSnMWAHGetPageAll($paData, $ptLngID)
	{
		$tSQL = "
			SELECT 
				COUNT (WAH.FTWahCode) AS counts
		    FROM TCNMWaHouse WAH WITH (NOLOCK)
			LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON WAH.FTWahCode = WAHL.FTWahCode AND WAH.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $ptLngID
			LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON  WAH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $ptLngID
			WHERE 1=1
		";

		if ($this->session->userdata("tSesUsrLevel") != "HQ") {
			$tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
			$tSQL .= " AND WAH.FTBchCode IN($tBchCodeMulti)";
		}

		// User BCH Level ของ เก่า
		// if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
		// 	$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
		// 	$tSQL .= " AND WAH.FTBchCode IN($tBchCodeMulti) AND WAH.FTWahRefCode IN ($tBchCodeMulti) AND WAH.FTWahStaType IN ('1','2') ";
		// }

		// // User SHP Level ของ เก่า
		// if ($this->session->userdata('tSesUsrLevel') == "SHP") { // ผู้ใช้ระดับ SHP ดูได้แค่สาขาที่มีสิทธิ์
		// 	$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
		// 	$tSQL .= " AND WAH.FTBchCode IN($tBchCodeMulti)";
		// }


		$tSearchList = $paData['tSearchAll'];
		if ($tSearchList != '') {
			$tSQL .= " AND (WAH.FTWahCode COLLATE THAI_BIN LIKE  '%" . $tSearchList . "%' ";
			$tSQL .= " OR WAHL.FTWahName  COLLATE THAI_BIN LIKE  '%" . $tSearchList . "%' ";
			$tSQL .= " OR BCHL.FTBchName  COLLATE THAI_BIN LIKE  '%" . $tSearchList . "%')";
		}

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {

			return $oQuery->result();
		} else {
			//No Data
			return false;
		}
	}

	//Functionality : Add Warehouse
	//Parameters : function parameters
	//Creator : 15/05/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : Array
	public function FSaMWAHAdd($paData)
	{
		$tStaDup = $this->FSnMBCHCheckduplicate($paData['FTWahCode'], $paData['FTBchCode']); //ส่งค่าไปหา duplicate
		$nStaDup = $tStaDup[0]->counts;

		if ($nStaDup == 0) {

			$this->db->insert('TCNMWaHouse', array(

				'FTWahCode' 			=> $paData['FTWahCode'],
				'FTWahStaType' 			=> $paData['FTWahStaType'],
				'FTWahRefCode' 			=> $paData['FTWahRefCode'],
				'FTBchCode' 			=> $paData['FTBchCode'],
				'FTWahStaChkStk' 		=> $paData['FTWahStaChkStk'],
				'FTWahStaPrcStk' 		=> $paData['FTWahStaPrcStk'],
				'FTWahStaAlwPLFrmTBO'  	=> $paData['FTWahStaAlwPLFrmTBO'],
				'FTWahStaAlwPLFrmSale' 	=> $paData['FTWahStaAlwPLFrmSale'],
				'FTWahStaAlwCntStk'		=> $paData['FTWahStaAlwCntStk'],
				'FTWahStaAlwCostAmt'	=> $paData['FTWahStaAlwCostAmt'],
				'FTWahStaAlwSNPL' 		=> $paData['FTWahStaAlwSNPL'],
				'FDCreateOn' 			=> $paData['FDCreateOn'],
				'FTCreateBy' 			=> $paData['FTCreateBy'],
				'FDLastUpdOn'			=> $paData['FDLastUpdOn'],
				'FTLastUpdBy'			=> $paData['FTLastUpdBy'],
			));

			if ($this->db->affected_rows() > 0) {
				$nID = $this->db->insert_id();

				$StaAddLang = $this->FSnMWahAddLang($paData); // Add Language

				if ($StaAddLang != '1') {
					//Ploblem
					$aStatus = array(
						'rtCode' => '905',
						'rtDesc' => 'cannot insert database.',
					);
					$jStatus = json_encode($aStatus);
					$aStatus = json_decode($jStatus, true);
				} else {
					//Success
					$aStatus = array(
						'rtCode' => '1',
						'rtDesc' => 'success',
					);
					$jStatus = json_encode($aStatus);
					$aStatus = json_decode($jStatus, true);
				}
			} else {
				$aStatus = array(
					'rtCode' => '905',
					'rtDesc' => 'cannot insert database.',
				);
			}
		} else {
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

	//Functionality : Add Lang Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : num
	public function FSnMWahAddLang($paData)
	{
		$this->db->insert('TCNMWaHouse_L', array(
			'FTWahCode'	=> $paData['FTWahCode'],
			'FTBchCode'	=> $paData['FTBchCode'],
			'FNLngID'	=> $paData['FNLngID'],
			'FTWahName'	=> $paData['FTWahName'],
		));

		if ($this->db->affected_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	//Functionality : Checkduplicate
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMBCHCheckduplicate($ptCode, $ptBchCode)
	{
		$tSQL = "SELECT COUNT(FTWahCode)AS counts
		FROM TCNMWaHouse
		WHERE FTWahCode = '$ptCode' 
		AND FTBchCode = '$ptBchCode'
		";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			return $oQuery->result();
		} else {
			return false;
		}
	}

	//Functionality : Update Warehouse
	//Parameters : function parameters
	//Creator : 15/05/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : Array
	public function FSaMBCHUpdateAddress($paData)
	{
		$this->db->set('FTAddV1No', $paData['FTAddV1No']);
		$this->db->set('FTAddV1Soi', $paData['FTAddV1Soi']);
		$this->db->set('FTAddV1Village', $paData['FTAddV1Village']);
		$this->db->set('FTAddV1Road', $paData['FTAddV1Road']);
		$this->db->set('FTAddV1SubDist', $paData['FTAddV1SubDist']);
		$this->db->set('FTAddV1DstCode', $paData['FTAddV1DstCode']);
		$this->db->set('FTAddV2Desc1', $paData['FTAddV2Desc1']);
		$this->db->set('FTAddV2Desc2', $paData['FTAddV2Desc2']);
		$this->db->where('FTAddGrpType', $paData['FTAddGrpType']);
		$this->db->where('FTAddVersion', $paData['FTAddVersion']);
		$this->db->where('FTAddRefCode', $paData['FTAddRefCode']);
		$this->db->where('FNLngID', $paData['FNLngID']);

		$this->db->update('TCNMAddress_L');

		if ($this->db->affected_rows() > 0) {
			//Success
			$aStatus = array(
				'rtCode' => '1',
				'rtDesc' => 'success',
			);
		} else {

			$this->db->insert('TCNMAddress_L', array(

				'FTAddV1No' 		=> $paData['FTAddV1No'],
				'FTAddV1Soi' 		=> $paData['FTAddV1Soi'],
				'FTAddV1Village' 	=> $paData['FTAddV1Village'],
				'FTAddV1Road' 		=> $paData['FTAddV1Road'],
				'FTAddV1SubDist' 	=> $paData['FTAddV1SubDist'],
				'FTAddV1DstCode'	=> $paData['FTAddV1DstCode'],
				'FTAddV2Desc1' 		=> $paData['FTAddV2Desc1'],
				'FTAddV2Desc2' 		=> $paData['FTAddV2Desc2'],
				'FTAddGrpType' 		=> $paData['FTAddGrpType'],
				'FTAddVersion' 		=> $paData['FTAddVersion'],
				'FTAddRefCode' 		=> $paData['FTAddRefCode'],
				'FNLngID' 			=> $paData['FNLngID'],
				'FTAreCode' 		=> '',
				'FTZneCode' 		=> '',
			));

			if ($this->db->affected_rows() > 0) {
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

	//Functionality : Update Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : Array
	public function FSaMWAHUpdate($paData)
	{
		$tStaDup = $this->FSnMBCHCheckduplicate($paData['FTWahCode'], $paData['FTBchCode']);
		$nStaDup = $tStaDup[0]->counts;

		if ($paData['FTBchCode'] == $paData['FTBchCodeOld']) {
			$nStaDup = 0;
		}
		if ($nStaDup == 0) {
			$this->db->where('FTWahCode', $paData['FTWahCode']);
			$this->db->where('FTBchCode', $paData['FTBchCodeOld']);
			$this->db->update('TCNMWaHouse', array(
				'FTWahStaType' 			=> $paData['FTWahStaType'],
				'FTWahRefCode' 			=> $paData['FTWahRefCode'],
				// 'FTBchCode' => $paData['FTBchCode'],
				'FTWahStaChkStk' 		=> $paData['FTWahStaChkStk'],
				'FTWahStaPrcStk' 		=> $paData['FTWahStaPrcStk'],
				'FTWahStaAlwPLFrmTBO'  	=> $paData['FTWahStaAlwPLFrmTBO'],
				'FTWahStaAlwPLFrmSale' 	=> $paData['FTWahStaAlwPLFrmSale'],
				'FTWahStaAlwCntStk' 	=> $paData['FTWahStaAlwCntStk'],
				'FTWahStaAlwCostAmt' 	=> $paData['FTWahStaAlwCostAmt'],
				'FTWahStaAlwSNPL' 		=> $paData['FTWahStaAlwSNPL'],
				'FDLastUpdOn' 			=> $paData['FDLastUpdOn'],
				'FTLastUpdBy' 			=> $paData['FTLastUpdBy']
			));

			if ($this->db->affected_rows() > 0) {

				$StaUpdLang = $this->FSnMWAHUpdateLang($paData); // Add Language

				if ($StaUpdLang != 1) { // หาภาษาที่จะแก้ไขไม่เจอ

					$StaAddLang = $this->FSnMWahAddLang($paData);
					if ($StaAddLang != 1) {
						$aStatus = array(
							'rtCode' => '905',
							'rtDesc' => 'cannot update database.',
						);
					} else {
						$aStatus = array(
							'rtCode' => '1',
							'rtDesc' => 'success',
						);
					}
				} else {
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
					'rtDesc' => 'cannot update database.',
				);
			}
		} else {
			$aStatus = array(
				'rtCode' => '905',
				'rtDesc' => 'cannot update database duplicate.',
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
	public function FSnMWAHUpdateLang($paData)
	{

		$this->db->set('FTWahName', $paData['FTWahName']);
		// $this->db->set('FTBchCode', $paData['FTBchCode']);
		$this->db->where('FTBchCode', $paData['FTBchCodeOld']);
		$this->db->where('FNLngID', $paData['FNLngID']);
		$this->db->where('FTWahCode', $paData['FTWahCode']);
		$this->db->update('TCNMWaHouse_L');

		if ($this->db->affected_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	//Save Imgage
	public function FSaMBCHAddImgObj($ptImgRefID, $pnImgType, $ptImgObj)
	{
		$this->db->set('FTImgObj', $ptImgObj);
		$this->db->where('FNImgRefID', $ptImgRefID);
		$this->db->where('FNImgType', $pnImgType);
		$this->db->update('TCNMImgObj');

		if ($this->db->affected_rows() > 0) {
			return 1;
		} else {
			$this->db->insert('TCNMImgObj', array(
				'FNImgRefID' => $ptImgRefID,
				'FNImgSeq' => '1',
				'FNImgType' => $pnImgType,
				'FTImgObj' => $ptImgObj,
			));

			if ($this->db->affected_rows() > 0) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	//Functionality : get all row data from pdt location
	//Parameters : -
	//Creator : 1/04/2019 Pap
	//Return : array result from db
	//Return Type : array

	public function FSnMLOCGetAllNumRow()
	{
		$tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMWaHouse";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$aResult = $oQuery->row_array()["FNAllNumRow"];
		} else {
			$aResult = false;
		}
		return $aResult;
	}
}
