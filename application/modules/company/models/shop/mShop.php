<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mShop extends CI_Model{

	//Functionality : Update Shop
	//Parameters : function parameters
	//Creator : 18/06/2018 Krit(Copter)
	//Return : response
	//Return Type : Array
	public function FSaMSHPAddUpdateMaster($ptType,$paData){
		//return $paData['FTBchCode'];
		try {

			//delete TCNMShpWah ถ้าเกิดมีการ เปลี่ยนสาขา
			$this->db->where('FTShpCode', $paData['FTShpCode']);
			$this->db->where('FTBchCode', $paData['FTBchCodeOld']);
			$this->db->delete('TCNMShpWah');

			//Update Master
			$this->db->set('FTBchCode', $paData['FTBchCode']);
			$this->db->set('FTMerCode', $paData['FTMerCode']);
			$this->db->set('FTShpType', $paData['FTShpType']);
			$this->db->set('FTShpRegNo', $paData['FTShpRegNo']);
			$this->db->set('FTShpRefID', $paData['FTShpRefID']);
			$this->db->set('FDShpStart', $paData['FDShpStart']);
			$this->db->set('FDShpStop', $paData['FDShpStop']);
			$this->db->set('FTShpStaShwPrice', $paData['FTShpStaShwPrice']);
			$this->db->set('FDShpSaleStart', $paData['FDShpSaleStart']);
			$this->db->set('FDShpSaleStop', $paData['FDShpSaleStop']);
			$this->db->set('FTShpStaActive', $paData['FTShpStaActive']);
			$this->db->set('FTShpStaClose', $paData['FTShpStaClose']);
			$this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
			$this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
			$this->db->set('FTPplCode', $paData['FTPplCode']);
			$this->db->where('FTShpCode', $paData['FTShpCode']);
			$this->db->where('FTBchCode', $paData['FTBchCodeOld']);
			$this->db->update('TCNMShop');

			if ($this->db->affected_rows() > 0) {
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Update Master Success',
				);
			} else {
				//Add Master
				if($ptType == 'ADD'){
					$this->db->insert('TCNMShop', array(
						'FTShpCode' 		=> $paData['FTShpCode'],
						'FTBchCode' 		=> $paData['FTBchCode'],
						'FTWahCode' 		=> '',
						'FTMerCode' 		=> $paData['FTMerCode'],
						'FTShpType' 		=> $paData['FTShpType'],
						'FTShpRegNo' 		=> $paData['FTShpRegNo'],
						'FTShpRefID' 		=> $paData['FTShpRefID'],
						'FDShpStart' 		=> $paData['FDShpStart'],
						'FDShpStop'	 		=> $paData['FDShpStop'],
						'FTShpStaShwPrice'	=> $paData['FTShpStaShwPrice'],
						'FDShpSaleStart' 	=> $paData['FDShpSaleStart'],
						'FDShpSaleStop' 	=> $paData['FDShpSaleStop'],
						'FTShpStaActive' 	=> $paData['FTShpStaActive'],
						'FTShpStaClose' 	=> $paData['FTShpStaClose'],
						'FDLastUpdOn'		=> $paData['FDLastUpdOn'],
						'FTLastUpdBy'		=> $paData['FTLastUpdBy'],
						'FDCreateOn' 		=> $paData['FDCreateOn'],
						'FTCreateBy' 		=> $paData['FTCreateBy'],
						'FTPplCode'			=> $paData['FTPplCode']
					));
				}else if($ptType == 'EDIT'){
					$this->db->set('FTBchCode', $paData['FTBchCode']);
					$this->db->set('FTMerCode', $paData['FTMerCode']);
					$this->db->set('FTShpType', $paData['FTShpType']);
					$this->db->set('FTShpRegNo', $paData['FTShpRegNo']);
					$this->db->set('FTShpRefID', $paData['FTShpRefID']);
					$this->db->set('FDShpStart', $paData['FDShpStart']);
					$this->db->set('FDShpStop', $paData['FDShpStop']);
					$this->db->set('FTShpStaShwPrice', $paData['FTShpStaShwPrice']);
					$this->db->set('FDShpSaleStart', $paData['FDShpSaleStart']);
					$this->db->set('FDShpSaleStop', $paData['FDShpSaleStop']);
					$this->db->set('FTShpStaActive', $paData['FTShpStaActive']);
					$this->db->set('FTShpStaClose', $paData['FTShpStaClose']);
					$this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
					$this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
					$this->db->set('FTPplCode', $paData['FTPplCode']);
					$this->db->where('FTShpCode', $paData['FTShpCode']);
					$this->db->where('FTBchCode', $paData['FTBchCodeOld']);
					$this->db->update('TCNMShop');
				}

				if ($this->db->affected_rows() > 0) {
					$aStatus = array(
						'rtCode' => '1',
						'rtDesc' => 'Update Master Success',
					);
				} else {
					$aStatus = array(
						'rtCode' => '905',
						'rtDesc' => 'Error Cannot Add/Edit Master.',
					);
				}
			}
			return $aStatus;
		} catch (Exception $Error) {
			return $Error;
		}
	}


	//Functionality : Update Lang Shop
	//Parameters 	: function parameters
	//Creator 		: 15/05/2018 Krit(Copter)
	//Last Modified : -
	//Return 		: response
	//Return Type 	: num
	public function FSaMSHPAddUpdateLang($paData)
	{
		try {
			//Update Lang
			$this->db->set('FTShpName', $paData['FTShpName']);
			$this->db->set('FTBchCode', $paData['FTBchCode']);
			$this->db->where('FNLngID', $paData['FNLngID']);
			$this->db->where('FTShpCode', $paData['FTShpCode']);
			$this->db->where('FTBchCode', $paData['FTBchCode']);
			$this->db->update('TCNMShop_L');
			if ($this->db->affected_rows() > 0) {
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Update Lang Success.',
				);
			} else {
				$this->db->insert('TCNMShop_L', array(
					'FTShpCode' => $paData['FTShpCode'],
					'FTBchCode' => $paData['FTBchCode'],
					'FNLngID'   => $paData['FNLngID'],
					'FTShpName' => $paData['FTShpName']
				));
				if ($this->db->affected_rows() > 0) {
					$aStatus = array(
						'rtCode' => '1',
						'rtDesc' => 'Add Lang Success',
					);
				} else {
					$aStatus = array(
						'rtCode' => '905',
						'rtDesc' => 'Error Cannot Add/Edit Lang.',
					);
				}
			}
			return $aStatus;
		} catch (Exception $Error) {
			return $Error;
		}
	}

	//Functionality : Search Branch By ID
	//Parameters 	: function parameters
	//Creator 		: 12/03/2020 supawat
	//Last Modified : -
	//Return 		: data
	//Return Type 	: Array
	public function FSaMSHPSearchByID($paData){
		$tCode	= $paData['FTShpCode'];
		$tBch	= $paData['FTBchCode'];
		$nLngID = $paData['FNLngID'];
		if (@$tCode) {
			$tSQL = "SELECT A.* FROM
				(
					SELECT ROW_NUMBER() OVER(
						ORDER BY X.FTShpCode DESC) AS rtRowID, 
						x.*
					FROM
					(
						SELECT C.*
						FROM
						(
							SELECT SHP.FTShpCode, 
								SHPL.FTShpName, 
								BCHL.FTBchCode, 
								BCHL.FTBchName, 
								SHP.FTShpCode AS rtShpCode, 
								BCHL.FTBchCode AS rtBchCode, 
								SHP.FTWahCode AS rtWahCode, 
								SHP.FTMerCode AS rtMerCode, 
								SHP.FTShpType AS rtShpType, 
								SHP.FTShpRegNo AS rtShpRegNo, 
								SHP.FTShpRefID AS rtShpRefID, 
								SHP.FDShpStart AS rdShpStart, 
								SHP.FDShpStop AS rdShpStop, 
								SHP.FDShpSaleStart AS rdShpSaleStart, 
								SHP.FDShpSaleStop AS rdShpSaleStop, 
								SHP.FTShpStaActive AS rtShpStaActive, 
								SHP.FTShpStaClose AS rtShpStaClose, 
								SHP.FTShpStaShwPrice AS rtShpStaShwPrice, 
								IMGO.FTImgObj AS rtImgObj, 
								SHPL.FTShpName AS rtShpName, 
								BCHL.FTBchName AS rtBchName, 
								WAHL.FTWahName AS rtWahName, 
								MCT.FTMerName AS rtMerName,
								PPL.FTPplCode AS rtPplCode,
								PPL.FTPplName AS rtPplName
							FROM TCNMShop SHP 
							LEFT JOIN TCNMShop_L SHPL ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
							LEFT JOIN TCNMPdtPriList_L PPL ON SHP.FTPplCode = PPL.FTPplCode AND PPL.FNLngID = $nLngID
							LEFT JOIN TCNMImgObj IMGO WITH(NOLOCK) ON SHP.FTShpCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TCNMShop' AND IMGO.FNImgSeq = $nLngID
							LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON SHP.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
							LEFT JOIN TCNMWaHouse_L WAHL WITH(NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode AND SHP.FTBchCode = WAHL.FTBchCode  AND WAHL.FNLngID = $nLngID
							LEFT JOIN TCNMMerchant_L MCT WITH(NOLOCK) ON SHP.FTMerCode = MCT.FTMerCode AND MCT.FNLngID = $nLngID
						) C
					) X
				) A ";

			if ($tCode != '') {
				$tSQL .= " WHERE A.FTShpCode = '$tCode' AND A.FTBchCode = '$tBch' ";
			}

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
				'raItem'	=> $aDetail[0],
				'rtCode' 	=> '1',
				'rtDesc' 	=> 'success',
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

	//Functionality 	: list Branch
	//Parameters 		: function parameters
	//Creator 			: 12/03/2020 supawat
	//Last Modified 	: -
	//Return 			: data
	//Return Type 		: Array
	public function FSaMSHPList($paData){
		$aRowLen	= FCNaHCallLenData($paData['nRow'], $paData['nPage']);
		$nLngID 	= $paData['FNLngID'];
		$tSearchAll = $paData['tSearchAll'];
		$tSQL		= "	SELECT A.*
						FROM (
							SELECT 
								ROW_NUMBER() OVER(ORDER BY x.FDCreateOn DESC , X.FTBchCode DESC, X.FTShpCode DESC) AS rtRowID,x.*
							FROM(
								SELECT C.*
									FROM
									(
										SELECT 
											SHP.FTBchCode,
											SHP.FTShpCode, 
											SHP.FDCreateOn,
											SHPL.FTShpName, 
											BCHL.FTBchCode as rtBchCode, 
											BCHL.FTBchName as rtBchName, 
											SHP.FTShpCode AS rtShpCode, 
											SHP.FTShpType AS rtShpType, 
											SHPL.FTShpName AS rtShpName, 
											null AS rtImgObj";

		//ถ้าเป็น layout จะต้อง select stkbal ออกมาด้วยจะได้รู้ว่ามีการใช้งานอยู่จะลบไม่ได้
		if(isset($paData['tNameMenuGroup'])){
			if($paData['tNameMenuGroup'] == 'LAYOUT'){
				$tSQL .= " , STKBAL.SUMSTK AS SUMSTK ";
			}
		}
		
		$tSQL .= 						" FROM TCNMShop SHP ";
		$tSQL .=						" LEFT JOIN TCNMShop_L SHPL ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID";

		//ถ้าเป็น layout จะต้อง select stkbal ออกมาด้วยจะได้รู้ว่ามีการใช้งานอยู่จะลบไม่ได้
		if(isset($paData['tNameMenuGroup'])){
			if($paData['tNameMenuGroup'] == 'LAYOUT'){
				$tSQL .= " LEFT JOIN (
							SELECT 
								DISTINCT 
								PDTLay.FTBchCode, 
								PDTLay.FTShpCode, 
								SUM(FCSTKQty) AS SUMSTK
							FROM TVDMPdtLayout PDTLay
							LEFT JOIN TVDMPosShop POS ON POS.FTBchCode = PDTLay.FTBchCode AND POS.FTShpCode = PDTLay.FTShpCode
							LEFT JOIN TCNMWaHouse WAH ON POS.FTBchCode = WAH.FTBchCode AND POS.FTPosCode = WAH.FTWahRefCode AND FTWahStaType = 6
							LEFT JOIN TVDTPdtStkBal STKBal ON WAH.FTWahCode = STKBal.FTWahCode AND WAH.FTBchCode = STKBal.FTBchCode
							WHERE PDTLay.FTPdtCode != ''
							GROUP BY 
								PDTLay.FTBchCode, 
								PDTLay.FTShpCode
							) STKBAL ON STKBAL.FTShpCode = SHP.FTShpCode AND STKBAL.FTBchCode = SHP.FTBchCode ";
			}
		}
		$tSQL		.= " LEFT JOIN TCNMBranch_L BCHL ON SHP.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID WHERE 1=1 ";

		//ค้นหาตามประเภทเมนูที่เข้ามา
		if(isset($paData['tNameMenuGroup'])){
			if($paData['tNameMenuGroup'] == 'POS'){
				$tSQL .= " AND (SHP.FTShpType IN ('1')) ";
			}else if($paData['tNameMenuGroup'] == 'LAYOUT'){
				$tSQL .= " AND (SHP.FTShpType IN ('4','6')) "; // Last Update : Napat(Jame) 11/02/2021 เพิ่ม Type 6 StatDose
			}else if($paData['tNameMenuGroup'] == 'LOCKER'){
				$tSQL .= " AND (SHP.FTShpType IN ('5')) ";
			}
		}
		
		$tLevel = $this->session->userdata("tSesUsrLevel");
		if($tLevel != 'HQ'){
			@$tBchCode = $paData['FTBchCode'];
			if (@$tBchCode != '') {
				$tSQL .= " AND (SHP.FTBchCode IN ($tBchCode)) ";
			}
	
			@$tShpCode = $paData['FTShpCode'];
			if (@$tShpCode != '') {
				$tSQL .= " AND (SHP.FTShpCode IN ($tShpCode)) ";
			}
		}

		$tSQL .= " ) C ) X ) A WHERE A.rtRowID > $aRowLen[0] AND A.rtRowID <= $aRowLen[1]";

		if ($tSearchAll != '') {
			$tSQL .= " AND (A.FTShpCode COLLATE THAI_BIN LIKE '%$tSearchAll%'";
			$tSQL .= " OR A.FTShpName COLLATE THAI_BIN LIKE '%$tSearchAll%')";
		}
		
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {

			$aList = $oQuery->result();
			$aFoundRow = $this->JSnMSHPGetPageAll($paData, $nLngID);
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
		} else {
			//No Data
			$aResult = array(
				'rnAllRow' => 0,
				'rnCurrentPage' => $paData['nPage'],
				"rnAllPage" => 0,
				'rtCode' => '800',
				'rtDesc' => 'data not found',
			);
		}
		$jResult = json_encode($aResult);
		$aResult = json_decode($jResult, true);

		return $aResult;
	}


	//Functionality : All Page Of Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : - 
	//Return : data
	//Return Type : Array
	function JSnMSHPGetPageAll($paData, $ptLngID)
	{

		$tSearchAll = $paData['tSearchAll'];
		$tBchCode = $paData['FTBchCode'];
		$tShpCode = $paData['FTShpCode'];

		$tSQL = "SELECT COUNT (SHP.FTShpCode) AS counts
    					FROM TCNMShop SHP
						LEFT JOIN TCNMShop_L SHPL ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $ptLngID
						WHERE 1 = 1";	

		//ค้นหาตามประเภทเมนูที่เข้ามา
		if(isset($paData['tNameMenuGroup'])){
			if($paData['tNameMenuGroup'] == 'POS'){
				$tSQL .= " AND (SHP.FTShpType IN ('1')) ";
			}else if($paData['tNameMenuGroup'] == 'LAYOUT'){
				$tSQL .= " AND (SHP.FTShpType IN ('4')) ";
			}else if($paData['tNameMenuGroup'] == 'LOCKER'){
				$tSQL .= " AND (SHP.FTShpType IN ('5')) ";
			}
		}

		$tLevel = $this->session->userdata("tSesUsrLevel");
		if($tLevel != 'HQ'){
			@$tBchCode = $paData['FTBchCode'];
			if (@$tBchCode != '') {
				$tSQL .= " AND (SHP.FTBchCode IN ($tBchCode)) ";
			}

			@$tShpCode = $paData['FTShpCode'];
			if (@$tShpCode != '') {
				$tSQL .= " AND (SHP.FTShpCode IN ($tShpCode)) ";
			}
		}
		
		if ($tSearchAll != '') {
			$tSQL .= " AND (SHP.FTShpCode LIKE '%$tSearchAll%'";
			$tSQL .= " OR SHPL.FTShpName LIKE '%$tSearchAll%')";
		}

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {

			return $oQuery->result();
		} else {
			//No Data
			return false;
		}
	}


	//Functionality : Add Lang Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : num
	public function FSnMSHPAddLang($paData)
	{

		$this->db->insert('TCNMShop_L', array(
			'FTBchCode' => $paData['FTBchCode'],
			'FTShpCode' => $paData['FTShpCode'],
			'FNLngID' => $paData['FNLngID'],
			'FTShpName' => $paData['FTShpName'],
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
	public function FSnMSHPCheckduplicate($ptBrn, $ptCode)
	{

		$tSQL = "SELECT COUNT(FTShpCode)AS counts
				FROM TCNMShop
				WHERE FTShpCode = '$ptCode' AND FTBchCode = '$ptBrn' ";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			return $oQuery->result();
		} else {
			return false;
		}
	}


	//Functionality : Update Lang Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : num
	public function FSnMSHPUpdateLang($paData)
	{

		$this->db->set('FTShpName', $paData['FTShpName']);

		$this->db->where('FNLngID', $paData['FNLngID']);
		$this->db->where('FTBchCode', $paData['FTBchCode']);
		$this->db->where('FTShpCode', $paData['FTShpCode']);
		$this->db->update('TCNMShop_L');

		if ($this->db->affected_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}



	//Functionality : delete Branch
	//Parameters 	: function parameters
	//Creator 		: 12/03/2020 wat
	//Return 		: response
	//Return Type 	: array
	public function FSnMSHPDel($paParamMaster)
	{
		try {
			$this->db->trans_begin();

			$this->db->where_in('FTShpCode', $paParamMaster['FTShpCode']);
			$this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
			$this->db->delete('TCNMShop');

			$this->db->where_in('FTShpCode', $paParamMaster['FTShpCode']);
			$this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
			$this->db->delete('TCNMShop_L');

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$aStatus = array(
					'rtCode' => '500',
					'rtDesc' => 'Error Cannot Delete Product.',
				);
			} else {
				$this->db->trans_commit();
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Delete Product Success.',
				);
			}
		} catch (Exception $Error) {
			$aStatus = array(
				'rtCode' => '500',
				'rtDesc' => $Error->getMessage()
			);
		}
		return $aStatus;
	}


	//Functionality : Select Data Reason Group
	//Parameters : function parameters
	//Creator :  09/05/2018 Wasin
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSaMSHPSysGroup($ptAPIReq, $ptMethodReq, $paData)
	{
		$nLngID = $paData['FNLngID'];
		$tSQL = "SELECT
                    SHP.FTShpCode AS rtShpCode,
                    SHP.FTShpName AS rtShpName,
                    SHP.FTShpRmk  AS rtShpRmk
                 FROM [TCNMShop_L] SHP
                 WHERE SHP.FNLngID = $nLngID
        ";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			$oList = $oQuery->result();
			$aResult = array(
				'raItems'   => $oList,
				'rtCode'    => '1',
				'rtDesc'    => 'success',
			);
		} else {
			//No Data
			$aResult = array(
				'rtCode' => '800',
				'rtDesc' => 'data not found',
			);
		}
		$jResult = json_encode($aResult);
		$aResult = json_decode($jResult, true);
		return $aResult;
	}


	//remove before insert
	public function FSaMSHPRemoveBeforeInsert($paParamMaster)
	{
		$this->db->where_in('FTShpCode', $paParamMaster['FTShpCode']);
		$this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
		$this->db->delete('TCNMShop');

		$this->db->where_in('FTShpCode', $paParamMaster['FTShpCode']);
		$this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
		$this->db->delete('TCNMShop_L');

		$this->db->where_in('FTImgRefID', $paParamMaster['FTShpCode']);
		$this->db->where_in('FTImgTable', 'TCNMShop');
		$this->db->delete('TCNMImgObj');
	}

	//remove before insert
	public function FSaMSHPRemoveB4Insert($ptShpCode)
	{
		$this->db->where_in('FTShpCode', $ptShpCode);
		$this->db->delete('TCNMShop');

		$this->db->where_in('FTShpCode', $ptShpCode);
		$this->db->delete('TCNMShop_L');
	}

	//Functionality : Select Data Reason Group
	//Parameters : function parameters
	//Creator :  09/05/2018 Wasin
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSaMSHPChkTypeGPInDB($paData)
	{
		$tBchCode	=	$paData['FTBchCode'];
		$tShpCode	=	$paData['FTShpCode'];
		$tSQL		= "	SELECT DISTINCT	
							SHPGP.FTBchCode,
							SHPGP.FTShpCode,
							SHPGP.FTPdtCode,
							SHPGP.FDSgpStart
					FROM TCNMShopGP SHPGP
					WHERE 1=1 AND SHPGP.FTBchCode = '$tBchCode' AND SHPGP.FTShpCode = '$tShpCode'
					ORDER BY SHPGP.FDSgpStart DESC ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->first_row('array');
	}

	//Functionality : Select LocType Data
	//Parameters : function parameters
	//Creator : 03/07/2019 Sarun
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMSHPLocTypeData($pnShpCode){

		$tSQL = "SELECT *
				FROM TRTMShopType_L
				WHERE FTShpCode = '$pnShpCode'";
		// echo $tSQL; exit();
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			return $oQuery->result();
		} else {
			return false;
		}
	}

	//Functionality : Insert Shop Type Data
	//Parameters : function parameters
	//Creator : 03/07/2019 Sarun
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMSHPLocTypeAddData($ptData){
		$nShpcode	=  $ptData['nShpcode'];
		$nBrhcode   =  $ptData['nBrhcode'];
		$tShptType  =  $ptData['tShptType'];
		$tShptName  =  $ptData['tShptName'];
		$tShptRemark=  $ptData['tShptRemark'];
		$FDCreateOn	=  date('Y-m-d h:i:s');
		$FTCreateBy	=  $this->session->userdata('tSesUsername');

		$tSQL ="INSERT INTO TRTMShopType (FTBchCode, FTShpCode, FTShtType, FDCreateOn, FTCreateBy )
			VALUES ('$nBrhcode', '$nShpcode', '$tShptType', '$FDCreateOn', '$FTCreateBy')";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery > 0) {
			return true;
		} else {
			return false;
		}
	
		
			
	}

	//Functionality : Insert Shop Type Data
	//Parameters : function parameters
	//Creator : 03/07/2019 Sarun
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMSHPLocTypeAddData_L($ptData){
		$nBrhcode   =  $ptData['nBrhcode'];
		$nShpcode	=  $ptData['nShpcode'];
		$tShptType  =  $ptData['tShptType'];
		$nLangID    =  $ptData['nLangID'];
		$tShptName  =  $ptData['tShptName'];
		$tShptRemark=  $ptData['tShptRemark'];
		$FDCreateOn	=  date('Y-m-d h:i:s');
		$FTCreateBy	=  $this->session->userdata('tSesUsername');

		$tSQL ="INSERT INTO TRTMShopType_L (FTBchCode, FTShpCode, FTShtType, FNLngID, FTShtName, FTShtRemark )
			VALUES ('$nBrhcode', '$nShpcode', '$tShptType', '$nLangID', '$tShptName', '$tShptRemark')";
		$oQuery = $this->db->query($tSQL);

		if ($oQuery > 0) {
			return true;
		} else {
			return false;
		}
	
		
			
	}



	//Functionality : Edit Shop Type Data
	//Parameters : function parameters
	//Creator : 03/07/2019 Sarun
	//Return : data
	//Return Type : Array
	public function FSnMSHPLocTypeEditData($paData){
		
		//Update Master
		try{
			$this->db->set('FTBchCode', $paData['FTBchCode']);
			$this->db->set('FTShtType', $paData['FTShtType']);
			$this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
			$this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
			$this->db->where('FTShpCode', $paData['FTShpCode']);
			$this->db->update('TRTMShopType');


			if ($this->db->affected_rows() > 0) {
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Update Master Success',
				);
			}
		}catch (Exception $Error) {
			$aStatus = array(
				'rtCode' => '500',
				'rtDesc' => 'Error'
			);
		}
		return $aStatus;
	}

	//Functionality : Edit Shop Type Data_L
	//Parameters : function parameters
	//Creator : 03/07/2019 Sarun
	//Return : data
	//Return Type : Array
	public function FSnMSHPLocTypeEditDataL($paData){
		
		//Update Master
		try{
			$this->db->set('FTBchCode', $paData['FTBchCode']);
			$this->db->set('FTShtType', $paData['FTShtType']);
			$this->db->set('FNLngID', $paData['FNLngID']);
			$this->db->set('FTShtName', $paData['FTShtName']);
			$this->db->set('FTShtRemark', $paData['FTShtRemark']);
			$this->db->where('FTShpCode', $paData['FTShpCode']);
			$this->db->update('TRTMShopType_L');


			if ($this->db->affected_rows() > 0) {
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Update Success',
				);
			}
		}catch (Exception $Error) {
			$aStatus = array(
				'rtCode' => '500',
				'rtDesc' => 'Error'
			);
		}
		return $aStatus;
	}

	//Functionality : Get Data Shop Address
	//Parameters : function parameters
	//Creator : 12/07/2019 Wasin(Yoshi)
	//Return : data
	//Return Type : Array
	public function FSaMGetDataShopAddress($paDataWhere){
		$tShopCode	= $paDataWhere['FTShpCode'];
		$nLngID		= $paDataWhere['FNLngID'];

		$tSQL	= "	SELECT
						SHPADDR.FNLngID,
						SHPADDR.FTAddGrpType,
						SHPADDR.FTAddRefCode,
						SHPADDR.FNAddSeqNo,
						SHPADDR.FTAddRefNo,
						SHPADDR.FTAddVersion,
						SHPADDR.FTAddCountry,
						SHPADDR.FTAddV1No,
						SHPADDR.FTAddV1Soi,
						SHPADDR.FTAddV1Village,
						SHPADDR.FTAddV1Road,
						SHPADDR.FTAddV1SubDist,
						SUBDST_L.FTSudName,
						SHPADDR.FTAddV1DstCode,
						DST_L.FTDstName,
						SHPADDR.FTAddV1PvnCode,
						PVN_L.FTPvnName,
						SHPADDR.FTAddV1PostCode,
						SHPADDR.FTAddV2Desc1,
						SHPADDR.FTAddV2Desc2,
						SHPADDR.FTAddLongitude,
						SHPADDR.FTAddLatitude
					FROM TCNMAddress_L 			SHPADDR 	WITH (NOLOCK)
					LEFT JOIN TCNMSubDistrict_L SUBDST_L	WITH (NOLOCK)	ON SHPADDR.FTAddV1SubDist 	= SUBDST_L.FTSudCode	AND SUBDST_L.FNLngID 	= $nLngID
					LEFT JOIN TCNMDistrict_L	DST_L		WITH (NOLOCK)	ON SHPADDR.FTAddV1DstCode	= DST_L.FTDstCode		AND DST_L.FNLngID 		= $nLngID
					LEFT JOIN TCNMProvince_L	PVN_L		WITH (NOLOCK)	ON SHPADDR.FTAddV1PvnCode	= PVN_L.FTPvnCode		AND PVN_L.FNLngID		= $nLngID
					WHERE 1=1
					AND SHPADDR.FNLngID			= $nLngID
					AND SHPADDR.FTAddGrpType	= 4
					AND SHPADDR.FTAddRefCode	= '$tShopCode'
		";
		$oQuery	= $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0){
			$aDetail	= $oQuery->row_array();
            $aResult    = array(
                'raItem'    => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
		}else{
			$aResult	= array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found.',
            );
		}
		return $aResult;
	}


	//ลบคลังสินค้าที่เคยผูกกับ ร้านค้า
	public function FSnMDeleteWahouseInShop($ptData){
		$FTShpCode = $ptData['FTShpCode'];
		$FTBchCode = $ptData['FTBchCode'];

		$this->db->where_in('FTShpCode', $FTShpCode);
		$this->db->where_in('FTBchCode', $FTBchCode);
		$this->db->delete('TCNMShpWah');
	}

	//ลบจุดขายที่ผูกกับ ร้านค้า
	public function FSnMDeletePOSInShop($ptData){
		$FTShpCode = $ptData['FTShpCode'];
		$FTBchCode = $ptData['FTBchCode'];

		$this->db->where_in('FTShpCode', $FTShpCode);
		$this->db->where_in('FTBchCode', $FTBchCode);
		$this->db->delete('TVDMPosShop');
	}








}