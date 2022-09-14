<?php

//Functionality: Gencode
//Parameters:  Function Parameter
//Creator: 26/02/2018 Phisan(Arm)
//Last Modified : (16:33)26/02/2018 Phisan(Arm) -- แก้ FTAhmFmtAll
//Last Modified : (11:23)03/03/2018 Phisan(Arm) -- เพิ่ม $_SESSION['tSesUsername']
//Return : Code each table
//Return Type: Array
function FCNaHGencode($ptTable = ''){

	$ci = &get_instance();
	$ci->load->database();

	$tSQLAuto = "SELECT [FTSatTblName] ,[FTSatFedCode] ,[FTSatDefChar] ,[FTSatDefYear] ,[FTSatDefMonth]
    			,[FTSatDefDay] ,[FTSatDefNum] ,[FTSatDefFmtAll] ,[FTSatUsrChar],[FTSatUsrYear] ,[FTSatUsrMonth]
    			,[FTSatUsrDay] ,[FTSatUsrNum],[FTSatUsrFmtAll] ,[FTSatStaReset]
    			FROM TCNTAuto WITH(NOLOCK) WHERE FTSatTblName = '".$ptTable."' AND FTSatStaDocType = '0'
    			";
	$oQueryAuto = $ci->db->query($tSQLAuto);
	$aAuto = $oQueryAuto->result_array();

	foreach($aAuto as $tValAuto){
		$tAutoTblName = $tValAuto['FTSatTblName'];
		$tAutoFedCode = $tValAuto['FTSatFedCode'];

		$tUsrFmtChar = $tValAuto['FTSatUsrChar'];
		$tDefChar = $tValAuto['FTSatDefChar'];


		$tUsrFmtYear = $tValAuto['FTSatUsrYear'];
		$tDefYear = $tValAuto['FTSatDefYear'];

		$tUsrFmtMonth = $tValAuto['FTSatUsrMonth'];
		$tDefMonth = $tValAuto['FTSatDefMonth'];

		$tUsrFmtDay = $tValAuto['FTSatUsrDay'];
		$tDefDay = $tValAuto['FTSatDefDay'];

		$tUsrFmtNum = $tValAuto['FTSatUsrNum'];
		$tDefNum = $tValAuto['FTSatDefNum'];

		$tUsrFmtAll = $tValAuto['FTSatUsrFmtAll'];
		$tDefAll = $tValAuto['FTSatDefFmtAll'];


		if($tUsrFmtChar != '' || $tUsrFmtChar != NULL){
			$tAutoChar = $tUsrFmtChar;
		}else{
			$tAutoChar = $tDefChar;
		}
		if($tUsrFmtYear == '1' || $tUsrFmtYear == '2'){
			if($tUsrFmtYear == '1'){
				$tAutoYear = date('y');
				$tGenAllYear = 'YY';
			}else{
				$tAutoYear = date('Y');
				$tGenAllYear = 'YYYY';
			}
		}elseif($tDefYear == '1' || $tDefYear == '2'){
			if($tDefYear == '1'){
				$tAutoYear = date('y');
				$tGenAllYear = 'YY';
			}else{
				$tAutoYear = date('Y');
				$tGenAllYear = 'YYYY';
			}
		}else{
			$tAutoYear = '';
			$tGenAllYear = '';
		}
		if($tUsrFmtMonth == '1'){
			$tAutoMonth = date('m');
			$tGenAllMonth = 'MM';
		}elseif($tDefMonth == '1'){
			$tAutoMonth = date('m');
			$tGenAllMonth = 'MM';
		}else{
			$tAutoMonth = '';
			$tGenAllMonth = '';
		}
		if($tUsrFmtDay == '1'){
			$tAutoDay = date('d');
			$tGenAllDay = 'DD';
		}elseif($tDefDay == '1'){
			$tAutoDay = date('d');
			$tGenAllDay = 'DD';
		}else{
			$tAutoDay = '';
			$tGenAllDay = '';
		}
		if($tUsrFmtNum != '' || $tUsrFmtNum != NULL){
			$tAutoNum = $tUsrFmtNum;
		}else{
			$tAutoNum = $tDefNum;
		}
		if($tUsrFmtAll != '' || $tUsrFmtAll != NULL){
			$tAutoAll = $tUsrFmtAll;
		}else{
			$tAutoAll = $tDefAll;
		}

		$tGenDate = trim($tAutoYear).trim($tAutoMonth).trim($tAutoDay);//Gen วันที่

		$nAutoChar = strlen($tAutoChar);//ยังไม่ได้ใช้
		$nAutoNum = strlen($tAutoNum);
		$nAutoAll = strlen($tAutoAll);
	}

	$tSQLHisMas	= "	SELECT
						[FTAhmTblName] ,[FTAhmFedCode] ,[FTAhmFmtAll] ,[FTAhmFmtChar] ,[FTAhmFmtNum] ,[FNAhmLastNum]
				  	FROM [TCNTAutoHisMas]
    				where FTAhmTblName = '".$tAutoTblName."' AND FTAhmFedCode = '".$tAutoFedCode."'
    				AND FTAhmFmtAll = '".$tAutoAll."'
    				";

	$oQueryHisMas = $ci->db->query($tSQLHisMas);
	$nRowHisMas = $oQueryHisMas->num_rows();
	$aHisMas = $oQueryHisMas->result_array();


	$tGenAll = trim($tAutoChar).trim($tGenAllYear).trim($tGenAllMonth).trim($tGenAllDay).trim($tAutoNum);

	if($nRowHisMas > 0){
		$tHisMasAll = $aHisMas[0]['FTAhmFmtAll'];
		$tHisMasNum = $aHisMas[0]['FTAhmFmtNum'];
		$tHisMasChar = $aHisMas[0]['FTAhmFmtChar'];//ไม่ได้ใช้
		$tHisMasTblName = $aHisMas[0]['FTAhmTblName'];//ไม่ได้ใช้
		$tHisMasFedCode = $aHisMas[0]['FTAhmFedCode'];//ไม่ได้ใช้
		$tHisMasLastNum = $aHisMas[0]['FNAhmLastNum']+1;

		if(strlen($tHisMasAll) == $nAutoAll AND strlen($tHisMasNum) == $nAutoNum) {
			$tGenLastNum = $tHisMasLastNum;
			$tSqlActHisMas = "UPDATE TCNTAutoHisMas SET FNAhmLastNum = '".$tHisMasLastNum."' , FDLastUpdOn = '".date('Y-m-d H:i:s')."',
	    						FTLastUpdBy = '".$_SESSION['tSesUsername']."'
	    						WHERE FTAhmTblName = '".$tAutoTblName."' AND FTAhmFmtAll = '".$tAutoAll."'
	    						AND FTAhmFedCode = '".$tAutoFedCode."'
	    						";
		} else {
			$tGenLastNum = 1;
			$tSqlActHisMas = "INSERT INTO TCNTAutoHisMas
	    				([FTAhmTblName],[FTAhmFedCode],[FTAhmFmtAll],[FTAhmFmtChar],[FTAhmFmtNum],[FNAhmLastNum],[FDCreateOn],[FTCreateBy])
	    				VALUES ('".$tAutoTblName."','".$tAutoFedCode."','".$tGenAll."','".$tAutoChar."','".$tAutoNum."','1','".date('Y-m-d H:i:d')."','".$_SESSION['tSesUsername']."')
	    				";
		}

	}else{
		$tGenLastNum = 1;
		$tSqlActHisMas = "INSERT INTO TCNTAutoHisMas
	    				([FTAhmTblName],[FTAhmFedCode],[FTAhmFmtAll],[FTAhmFmtChar],[FTAhmFmtNum],[FNAhmLastNum],[FDCreateOn],[FTCreateBy])
	    				VALUES ('".$tAutoTblName."','".$tAutoFedCode."','".$tGenAll."','".$tAutoChar."','".$tAutoNum."','1','".date('Y-m-d H:i:d')."','".$_SESSION['tSesUsername']."')
	    				";
	}

	$tCodeSuccess = '1';
	$tCodeError = '802';
	$tDescSuccess = 'success.';
	$tDescError = 'can not generate code.';
	$tGenNum = str_pad($tGenLastNum, $nAutoNum, "0", STR_PAD_LEFT);

	if(strlen($tGenNum) == $nAutoNum){
		$tGenCode = trim($tAutoChar).trim($tGenDate).$tGenNum;
		if($nAutoAll == strlen($tGenCode)){
			$rtCode = $tCodeSuccess;
			$rtDesc = $tDescSuccess;
		}else{
			$tGenCode = null;
			$rtCode = $tCodeError;
			$rtDesc = $tDescError;
		}
	}else{
		$tGenCode = null;
		$rtCode = $tCodeError;
		$rtDesc = $tDescError;
	}

	$rtGenCode = 'rt'.substr($tAutoFedCode,2);
	$raGenCode = array(
			$rtGenCode => $tGenCode,
			'rtCode' => $rtCode,
			'rtDesc' => $rtDesc
	);

	
	$oActHisMas = $ci->db->query($tSqlActHisMas);
	if ($oActHisMas) {
		return $raGenCode;
	} else {
		return array(
				$rtGenCode => null,
				'rtCode' => '905',
				'rtDesc' => 'cannot connect database.'
		);
	}

}



//Get ค่าภาษาที่มีอยู๋ในตาราง L ของเรื่องนั้นๆ โดยส่งชื่อ Table
//10/04/2018 Krit(Copter)
function FCNaHCheckInputGenCode($ptTable = '',$ptField = '',$ptCode = '', $ptFiledBch = ''){

	$ci = &get_instance();
	$ci->load->database();

	$tSQL = "SELECT COUNT ($ptField) AS nNum
			 FROM $ptTable
			 WHERE $ptField = '$ptCode' ";
				 
	//supawat 13-04-2020 เพิ่ม $ptFiledBch เพราะมันต้องเช็ค bch
	if($ptFiledBch != '' || $ptFiledBch != null){
		$tBchCode = $ci->session->userdata("tSesUsrBchCode");
		$tSQL .= " AND $ptFiledBch = '$tBchCode' ";
	}
	
	$oQuery = $ci->db->query($tSQL);
	if ($oQuery->num_rows() > 0) {
		return $oQuery->result();
	} else {
		//No Data
		return false;
	}

}

//Get ค่าภาษาที่มีอยู๋ในตาราง L ของเรื่องนั้นๆ โดยส่งชื่อ Table
//10/04/2018 Krit(Copter)
function FCNaHGetAllLangByTable($ptTable = ''){

	$ci = &get_instance();
	$ci->load->database();

	$tSQL = "SELECT DISTINCT (FNLngID) AS nLangList
			 FROM $ptTable ";

	$oQuery = $ci->db->query($tSQL);
	if ($oQuery->num_rows() > 0) {
		return $oQuery->result();
	} else {
		//No Data
		return false;
	}

}
//Get ค่าภาษาที่มีอยู๋ในระบบ จากตาราง tSys
//10/04/2018 Krit(Copter)
function FCNaHGetAllLangInSystem(){

	$ci = &get_instance();
	$ci->load->database();

	$tSQL = "SELECT FNLngID,FTLngName,FTLngNameEng AS nLangList
			 FROM TSysLanguage  WHERE FTLngStaUse = 1 ";

	$oQuery = $ci->db->query($tSQL);
	if ($oQuery->num_rows() > 0) {
		return $oQuery->result();
	} else {
		//No Data
		return false;
	}

}


//Functionality: Gencode POS V.5
//Parameters:  Function Parameter - ptTable = ชื่อตาราง , ptStaDocType = FTSatStaDocType 
//Creator: 20/02/2019 Phisan(Arm)
//Last Modified : 17/01/2019 Wasin (แกไขมีการรันรหัสตามสาขา)
//Return : Code each table
//Return Type: Array
function FCNaHGenCodeV5($ptTable = '',$ptStaDocType = '0',$ptBchCode = ''){
	$ci	= &get_instance();
	$ci->load->database();
	$tSQLAuto	= "	SELECT
						FTSatTblName,
						FTSatFedCode,
						FTSatStaDocType,
						FTSatGroup,
						FTSatDocTypeName,
						FNSatMaxFedSize,
						FTSatDefChar,
						FTSatDefYear,
						FTSatDefMonth,
						FTSatDefDay,
						FTSatDefNum,
						FTSatDefFmtAll,
						FTSatStaDefUsage,
						FTSatUsrChar,
						FTSatUsrBch,
						FTSatUsrPosShp,
						FTSatUsrYear,
						FTSatUsrMonth,
						FTSatUsrDay,
						FTSatUsrNum,
						FTSatUsrFmtAll,
						FTSatStaReset,
						FTSatDefBch,
						FTSatDefPosShp,
						FTSatStaRunBch
    				FROM TCNTAuto WITH(NOLOCK)
					WHERE 1=1
					AND FTSatTblName	= '".$ptTable."'
					AND FTSatStaDocType	= '".$ptStaDocType."'
	";
	$oQueryAuto	= $ci->db->query($tSQLAuto);
	$aAuto 		= $oQueryAuto->row_array();

	// Set Parameter Auto Gen
	$tAutoTblName	= $aAuto['FTSatTblName'];
	$tAutoFedCode 	= $aAuto['FTSatFedCode'];
	$tUsrFmtChar 	= $aAuto['FTSatUsrChar'];
	$tDefChar 		= $aAuto['FTSatDefChar'];
	$tUsrFmtYear 	= $aAuto['FTSatUsrYear'];
	$tDefYear 		= $aAuto['FTSatDefYear'];
	$tUsrFmtMonth 	= $aAuto['FTSatUsrMonth'];
	$tDefMonth 		= $aAuto['FTSatDefMonth'];
	$tUsrFmtDay 	= $aAuto['FTSatUsrDay'];
	$tDefDay 		= $aAuto['FTSatDefDay'];
	$tUsrFmtNum 	= $aAuto['FTSatUsrNum'];
	$tDefNum 		= $aAuto['FTSatDefNum'];
	$tUsrFmtAll 	= $aAuto['FTSatUsrFmtAll'];
	$tDefAll 		= $aAuto['FTSatDefFmtAll'];
	$tUsrStaBch 	= $aAuto['FTSatUsrBch'];
	$tDefStaBch 	= $aAuto['FTSatDefBch'];
	$tUsrStaPos 	= $aAuto['FTSatUsrPosShp'];
	$tDefStaPos 	= $aAuto['FTSatDefPosShp'];
	$tStaResetBill 	= $aAuto['FTSatStaReset'];
	$tSatStaRunBch	= $aAuto['FTSatStaRunBch'];

	// Check Format Prefix
	if(isset($tUsrFmtChar) && !empty($tUsrFmtChar)){
		$tAutoChar	= $tUsrFmtChar;
	}else{
		$tAutoChar	= $tDefChar;
	}

	// Check Format Year
	if(isset($tUsrFmtYear) && !empty($tUsrFmtYear)){
		if($tUsrFmtYear == '1'){
			$tAutoYear		= date('y');
			$tGenAllYear	= 'YY';
		}else{
			$tAutoYear 		= '';
			$tGenAllYear 	= '';
		}
	}else{
		if($tDefYear == '1'){
			$tAutoYear		= date('y');
			$tGenAllYear	= 'YY';
		}else{
			$tAutoYear 		= '';
			$tGenAllYear 	= '';
		}
	}

	//  Check Format Month
	if(isset($tUsrFmtMonth) && !empty($tUsrFmtMonth)){
		if($tUsrFmtMonth == '1'){
			$tAutoMonth 	= date('m');
			$tGenAllMonth 	= 'MM';
		}else{
			$tAutoMonth 	= '';
			$tGenAllMonth 	= '';
		}
	}else{
		if($tDefMonth == '1'){
			$tAutoMonth 	= date('m');
			$tGenAllMonth 	= 'MM';
		}else{
			$tAutoMonth 	= '';
			$tGenAllMonth 	= '';
		}
	}
	
	// Check Format Month
	if(isset($tUsrFmtDay) && !empty($tUsrFmtDay)){
		if($tUsrFmtDay == '1'){
			$tAutoDay 	= date('d');
			$tGenAllDay = 'DD';
		}else{
			$tAutoDay 	= '';
			$tGenAllDay = '';
		}
	}else{
		if($tDefDay == '1'){
			$tAutoDay 	= date('d');
			$tGenAllDay = 'DD';
		}else{
			$tAutoDay 	= '';
			$tGenAllDay = '';
		}
	}

	// Check User Login Branch
	if(isset($ptBchCode) && !empty($ptBchCode)){
		$tSesUsrBchCode	= $ptBchCode;
		$tSatStaRunBch	= 1;
	}else{
		$tSesUsrBchCode	= $_SESSION["tSesUsrBchCode"];
		if($tSesUsrBchCode == ''){
			$tSQLComp		= "SELECT FTBchcode FROM TCNMComp ";
			$oQueryComp 	= $ci->db->query($tSQLComp);
			$aComp			= $oQueryComp->result_array();
			$tSesUsrBchCode = $aComp[0]['FTBchcode'];
		}
	}
		
	// Check Status Branch
	if(isset($tUsrStaBch) && !empty($tUsrStaBch)){
		$tAutoStaBch	= $tUsrStaBch;
	}else{
		$tAutoStaBch	= $tDefStaBch;
	}

	if($tAutoStaBch == '1'){
		$tAutoBch 	= $tSesUsrBchCode;
		$tGenBch	= 'BCH';
	}else{
		$tAutoBch	= '';
		$tGenBch	= '';
	}

	// Check User Login Shop
	$tSesUsrShpCode	= $_SESSION["tSesUsrShpCode"];
	if($tUsrStaPos != '' || $tUsrStaPos != NULL){
		$tAutoStaShp	= $tUsrStaPos;
	}else{
		$tAutoStaShp	= $tDefStaPos;
	}

	if($tAutoStaShp == '1'){
		$tAutoShp	= $tSesUsrShpCode;
		$tGenShp 	= 'SHP';
	}else{
		$tAutoShp	= '';
		$tGenShp 	= '';
	}

	// Check User Format Num
	if(isset($tUsrFmtNum) && !empty($tUsrFmtNum)){
		$tAutoNum	= $tUsrFmtNum;
	}else{
		$tAutoNum	= $tDefNum;
	}

	// Check User Format Num
	if(isset($tUsrFmtAll) && !empty($tUsrFmtAll)){
		$tAutoAll	= $tUsrFmtAll;
	}else{
		$tAutoAll	= $tDefAll;
	}

	// Gen วันที่
	$tGenDate 	= trim($tAutoYear).trim($tAutoMonth).trim($tAutoDay);
	$nAutoChar	= strlen($tAutoChar);
	$nAutoNum 	= strlen($tAutoNum);
	$nAutoAll 	= strlen($tAutoAll);

	// Check Status Where Branch
	if(isset($tSatStaRunBch) && $tSatStaRunBch == 1){
		$tWhereRunBranch	= " AND FTBchCode = '$tSesUsrBchCode' ";
	}else{
		$tWhereRunBranch	= " AND FTBchCode = '' ";
	}
	
	$tSQLHisMas	= "	SELECT
						FTAhmTblName,
						FTAhmFedCode,
						FTAhmFmtAll,
						FTAhmFmtChar,
						FTAhmFmtNum,
						FNAhmLastNum,
						CONVERT(VARCHAR(4),FDCreateOn,20) 	AS FDCreateOn,
						CONVERT(VARCHAR(4),FDLastUpdOn,20) AS FDLastUpdOn
					FROM TCNTAutoHisMas WITH(NOLOCK)
					WHERE 1=1
					AND FTAhmTblName = '".$tAutoTblName."'
					AND FTAhmFedCode = '".$tAutoFedCode."'
					AND FTAhmFmtAll = '".$tAutoAll."'
					$tWhereRunBranch
	";

	$oQueryHisMas	= $ci->db->query($tSQLHisMas);
	$nRowHisMas 	= $oQueryHisMas->num_rows();
	$aHisMas 		= $oQueryHisMas->result_array();

	// เปลี่ยนเพราะพี่เอ็มทำ FmtAll กับ FmtNum ไม่เหมือนกัน
	$tGenAll		= $tAutoAll;

	if($nRowHisMas > 0){
		// พบข้อมูลเก่าในตาราง TCNTAutoHisMas
		$tHisMasAll 	= $aHisMas[0]['FTAhmFmtAll'];
		$tHisMasNum 	= $aHisMas[0]['FTAhmFmtNum'];
		$tLastUpdHisMas = $aHisMas[0]['FDLastUpdOn'];
		$tCreateHisMas 	= $aHisMas[0]['FDCreateOn'];
		$tHisMasChar 	= $aHisMas[0]['FTAhmFmtChar'];//ไม่ได้ใช้
		$tHisMasTblName = $aHisMas[0]['FTAhmTblName'];//ไม่ได้ใช้
		$tHisMasFedCode = $aHisMas[0]['FTAhmFedCode'];//ไม่ได้ใช้
		$tHisMasLastNum = $aHisMas[0]['FNAhmLastNum']+1;
		
		if($tLastUpdHisMas == NULL){
			$tLastUpdHisMas	= $tCreateHisMas;
		}else{
			$tLastUpdHisMas	= $tLastUpdHisMas;
		}

		if($tStaResetBill == '1'){
			$tSQLDateCreateDoc		= " SELECT TOP 1 CONVERT(VARCHAR(4),FDCreateOn,20) as FDCreateOn FROM $ptTable ORDER BY FDCreateOn DESC ";
			$oQueryDateCreateDoc	= $ci->db->query($tSQLDateCreateDoc);
			$nDateCreateDoc 		= $oQueryDateCreateDoc->num_rows();
			$aDateCreateDoc 		= $oQueryDateCreateDoc->result_array();
			if($nDateCreateDoc > 0){
				$tDateCreateDoc = $aDateCreateDoc[0]['FDCreateOn'];
				if((date('Y') > $tDateCreateDoc ) && $tLastUpdHisMas < date('Y')){
					$tHisMasLastNum = 1;
				}
			}else{
				$tHisMasLastNum = 1;
			}
		}

		if(strlen($tHisMasAll) == $nAutoAll AND strlen($tHisMasNum) == $nAutoNum) {
			$tGenLastNum 	= $tHisMasLastNum;
			// Check Status Where Branch
			if(isset($tSatStaRunBch) && $tSatStaRunBch == 1){
				$tSqlActHisMas	= "	UPDATE TCNTAutoHisMas
									SET
										FNAhmLastNum 	= '".$tHisMasLastNum."',
										FDLastUpdOn 	= GETDATE(),
										FTLastUpdBy 	= '".$_SESSION['tSesUsername']."'
									WHERE 1=1
									AND FTAhmTblName = '".$tAutoTblName."'
									AND FTAhmFmtAll = '".$tAutoAll."'
									AND FTAhmFedCode = '".$tAutoFedCode."'
									AND FTBchCode = '$tSesUsrBchCode'
				";
			}else{
				$tSqlActHisMas	= "	UPDATE TCNTAutoHisMas
									SET
										FNAhmLastNum 	= '".$tHisMasLastNum."',
										FDLastUpdOn 	= GETDATE(),
										FTLastUpdBy 	= '".$_SESSION['tSesUsername']."'
									WHERE 1=1
									AND FTAhmTblName = '".$tAutoTblName."'
									AND FTAhmFmtAll = '".$tAutoAll."'
									AND FTAhmFedCode = '".$tAutoFedCode."'
									AND FTBchCode = ' '
				";
			}
		} else {
			$tGenLastNum	= 1;
			// Check Status Where Branch
			if(isset($tSatStaRunBch) && $tSatStaRunBch == 1){
				$tSqlActHisMas	= "	INSERT INTO TCNTAutoHisMas (FTBchCode,FTAhmTblName,FTAhmFedCode,FTAhmFmtAll,FTAhmFmtChar,FTAhmFmtNum,FNAhmLastNum,FDCreateOn,FTCreateBy)
									VALUES (
										'".$tSesUsrBchCode."',
										'".$tAutoTblName."',
										'".$tAutoFedCode."',
										'".$tGenAll."',
										'".$tAutoChar."',
										'".$tAutoNum."',
										'1',
										GETDATE(),
										'".$_SESSION['tSesUsername']."'
									)
				";
			}else{
				$tSqlActHisMas	= "	INSERT INTO TCNTAutoHisMas (FTBchCode,FTAhmTblName,FTAhmFedCode,FTAhmFmtAll,FTAhmFmtChar,FTAhmFmtNum,FNAhmLastNum,FDCreateOn,FTCreateBy)
									VALUES (
										' ',
										'".$tAutoTblName."',
										'".$tAutoFedCode."',
										'".$tGenAll."',
										'".$tAutoChar."',
										'".$tAutoNum."',
										'1',
										GETDATE(),
										'".$_SESSION['tSesUsername']."'
									)
				";
			}
		}
	}else{
		// ไม่พบข้อมูลในตาราง TCNTAutoHisMas
		$tGenLastNum	= 1;
		// Check Status Where Branch
		if(isset($tSatStaRunBch) && $tSatStaRunBch == 1){
			$tSqlActHisMas	= "	INSERT INTO TCNTAutoHisMas (FTBchCode,FTAhmTblName,FTAhmFedCode,FTAhmFmtAll,FTAhmFmtChar,FTAhmFmtNum,FNAhmLastNum,FDCreateOn,FTCreateBy)
								VALUES (
									'".$tSesUsrBchCode."',
									'".$tAutoTblName."',
									'".$tAutoFedCode."',
									'".$tGenAll."',
									'".$tAutoChar."',
									'".$tAutoNum."',
									'1',
									GETDATE(),
									'".$_SESSION['tSesUsername']."'
								)
			";
		}else{
			$tSqlActHisMas	= "	INSERT INTO TCNTAutoHisMas (FTBchCode,FTAhmTblName,FTAhmFedCode,FTAhmFmtAll,FTAhmFmtChar,FTAhmFmtNum,FNAhmLastNum,FDCreateOn,FTCreateBy)
								VALUES (
									' ',
									'".$tAutoTblName."',
									'".$tAutoFedCode."',
									'".$tGenAll."',
									'".$tAutoChar."',
									'".$tAutoNum."',
									'1',
									GETDATE(),
									'".$_SESSION['tSesUsername']."'
								)
			";
		}
	}
	$tCodeSuccess 	= '1';
	$tCodeError		= '802';
	$tDescSuccess	= 'success.';
	$tDescError		= 'can not generate code.';
	$tGenNum		= str_pad($tGenLastNum, $nAutoNum, "0", STR_PAD_LEFT);
	if(strlen($tGenNum) == $nAutoNum){
		$aDefFmtAll	= explode("-",$tDefAll);
		if(FCNnHSizeOf($aDefFmtAll) > 1){
			$tGenCode	= trim($tAutoChar).trim($tAutoBch).trim($tAutoShp).trim($tGenDate).'-'.$tGenNum;
		}else{
			$tGenCode	= trim($tAutoChar).trim($tAutoBch).trim($tAutoShp).trim($tGenDate).$tGenNum;
		}
		$rtCode 	= $tCodeSuccess;
		$rtDesc 	= $tDescSuccess;
		$oActHisMas = $ci->db->query($tSqlActHisMas);
	}else{
		// Format Generate Not Compare Auto Format Number
		$tGenCode	= null;
		$rtCode 	= $tCodeError;
		$rtDesc 	= $tDescError;
	}

	$rtGenCode = 'rt'.substr($tAutoFedCode,2);
	$raGenCode = array(
		$rtGenCode 	=> $tGenCode,
		'rtCode' 	=> $rtCode,
		'rtDesc' 	=> $rtDesc
	);


	$tCheckDup = FCNaHCheckDup($ptTable,$tGenCode,$tAutoFedCode,$tSatStaRunBch,$tSesUsrBchCode);
		
	if($tCheckDup == 0){
		if ($oActHisMas) {
			return $raGenCode;

			unset($tSQLAuto);
			unset($oQueryAuto);
			unset($aAuto);
			unset($tAutoTblName);
			unset($tAutoFedCode);
			unset($tUsrFmtChar);
			unset($tDefChar);
			unset($tUsrFmtYear);
			unset($tDefYear);
			unset($tUsrFmtMonth);
			unset($tDefMonth);
			unset($tUsrFmtDay);
			unset($tDefDay);
			unset($tUsrFmtNum);
			unset($tDefNum);
			unset($tUsrFmtAll);
			unset($tDefAll);
			unset($tUsrStaBch);
			unset($tDefStaBch);
			unset($tUsrStaPos);
			unset($tDefStaPos);
			unset($tStaResetBill);
			unset($tSatStaRunBch);
			unset($tAutoChar);
			unset($tAutoYear);
			unset($tGenAllYear);
			unset($tAutoMonth);
			unset($tGenAllMonth);
			unset($tAutoDay);
			unset($tGenAllDay);
			unset($tSesUsrBchCode);
			unset($tSQLComp);
			unset($oQueryComp);
			unset($aComp);
			unset($tAutoStaBch);
			unset($tAutoBch);
			unset($tGenBch);
			unset($tSesUsrShpCode);
			unset($tAutoStaShp);
			unset($tAutoShp);
			unset($tGenShp);
			unset($tAutoNum);
			unset($tAutoAll);
			unset($tGenDate);
			unset($nAutoChar);
			unset($nAutoNum);
			unset($nAutoAll);
			unset($tWhereRunBranch);
			unset($tSQLHisMas);
			unset($oQueryHisMas);
			unset($nRowHisMas);
			unset($aHisMas);
			unset($tGenAll);
			unset($tHisMasAll);
			unset($tHisMasNum);
			unset($tLastUpdHisMas);
			unset($tCreateHisMas);
			unset($tHisMasChar);
			unset($tHisMasTblName);
			unset($tHisMasFedCode);
			unset($tHisMasLastNum);
			unset($tSQLDateCreateDoc);
			unset($oQueryDateCreateDoc);
			unset($nDateCreateDoc);
			unset($aDateCreateDoc);
			unset($tDateCreateDoc);
			unset($tHisMasLastNum);
			unset($tGenLastNum);
			unset($tSqlActHisMas);
			unset($tCodeSuccess);
			unset($tCodeError);
			unset($tDescSuccess);
			unset($tDescError);
			unset($aDefFmtAll);
			unset($tGenCode);
			unset($rtCode);
			unset($rtDesc);
			unset($oActHisMas);
			unset($rtGenCode);

			
		} else {
			return array(
					$rtGenCode => null,
					'rtCode' => '905',
					'rtDesc' => 'cannot connect database.'	
			);
		}
		// exit();
	}else{
		return FCNaHGenCodeV5($ptTable,'0',$ptBchCode);
		// return array(
		// 	$rtGenCode => null,
		// 	'rtCode' => '905',
		// 	'rtDesc' => 'Data Duplicate'	
		// );
	}


	// return $raGenCode;
}
	
//nale 8-04-2020
function FCNaHCheckDup($ptTable,$tGenCode,$tAutoFedCode,$ptSatStaRunBch,$ptSesUsrBchCode){
	$ci = &get_instance();
	$ci->load->database();
	$tCode		= $tGenCode;
	if(isset($ptSatStaRunBch) && $ptSatStaRunBch == 1){
	$tSQLHisMas	= "	SELECT FNAhmLastNum
					FROM TCNTAutoHisMas
					WHERE FTAhmTblName = '".$ptTable."'
					AND FTBchCode = '$ptSesUsrBchCode'
	";
	}else{
	$tSQLHisMas	= "	SELECT FNAhmLastNum
					FROM TCNTAutoHisMas
					WHERE FTAhmTblName = '".$ptTable."'
					AND FTBchCode = ' '
					";
	}
	$oActHisMas	= $ci->db->query($tSQLHisMas);
	$aAuto		= $oActHisMas->result_array();

	$tSQLLastDoc = " SELECT $tAutoFedCode
						FROM $ptTable
						WHERE $tAutoFedCode = '$tCode' 
	";
	if(isset($ptSatStaRunBch) && $ptSatStaRunBch == 1){
		$tSQLLastDoc .= " AND FTBchCode = '$ptSesUsrBchCode' ";
	}

	$oActLastDoc = $ci->db->query($tSQLLastDoc);
	$aLastDoc = $oActLastDoc->result_array();
	if(isset($aLastDoc[0][$tAutoFedCode])){
		if($aLastDoc[0][$tAutoFedCode]!='' || $aLastDoc[0][$tAutoFedCode] !=NULL){
			return 1 ;
		}else{
			return 0 ;
		}
	}else{
		return 0 ;
	}
}


		

