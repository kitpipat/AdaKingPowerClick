<?php
//Move File Image From system/temp To Folder destination
//10/04/2018 Krit(Copter)
function FCNnHAddImgObj($paImgData){
	// print_r($paImgData);
	$ci = &get_instance();
	$ci->load->database();
	if(is_array($paImgData) && isset($paImgData)){
		if(!empty($paImgData['tImgObj'])){

			// $aReturn = array(
			// 	'nStaEvent'   => 1,
			// 	'tStaMessg'   => 'Upload Images Success'
			// );


			if( $_SESSION["bIsHaveAgn"] ){
				$tRefID = $_SESSION["tSesUsrAgnCode"]; // AD
			}else{
				$tRefID = '00001'; // Comp Code
			}

			// เช็ค Folder System
			// if(!is_dir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg')){
			// 	mkdir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg');
			// }

			//เช็ค ไฟล์ Folder Image 
			// if(!is_dir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder'])){
			// 	mkdir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']);
			// }

			//เช็ค ไฟล์ Folder Image Ref ID
			// if(!is_dir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']."/".$paImgData['tImgRefID'])){
			// 	mkdir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']."/".$paImgData['tImgRefID']);
			// }

			// if(!empty($paImgData['nStaDelBeforeEdit']) && $paImgData['nStaDelBeforeEdit'] == 1){
				
			// }

			$tSQL       = "SELECT TOP 1 FTUrlAddress FROM TCNTUrlObject WITH(NOLOCK) WHERE FTUrlKey = 'FILE' AND FTUrlTable = 'TCNMComp' AND FTUrlRefID = 'CENTER' ORDER BY FNUrlSeq ASC";
			$oQuery     = $ci->db->query($tSQL);
			if($oQuery->num_rows() > 0){
				$oList      = $oQuery->result_array();
				$tUrlAddr   = $oList[0]['FTUrlAddress'];
			}else{
				$aReturn = array(
					'nStaEvent'    => 900,
					'tStaMessg'    => 'เกิดข้อผิดพลาด ไม่พบ API ในการเชื่อมต่อ'
				);
				return $aReturn;
			}

			$tUrlApi    = $tUrlAddr.'/Upload/Image';
			$aAPIKey    = array(
				'tKey'      => 'X-API-KEY',
				'tValue'    => '12345678-1111-1111-1111-123456789410'
			);

			if(isset($paImgData['nStaImageMulti']) && $paImgData['nStaImageMulti'] == 1){
				// ******* Image Multiple
				$ci->db->trans_begin();
				$aImgData = $paImgData['tImgObj'];
				// echo "<pre>";
				// print_r($paImgData['tImgObj']);
				// var_dump($paImgData['tImgObj']);
				// print_r($aImgData);

				$aImgDataNew = [];
				foreach( $aImgData as $aValue ){
					if( !strpos($aValue,"base64") ){
						array_push($aImgDataNew,$aValue);
					}
				}
				// print_r($aImgDataNew);
				// exit;
				
				if( FCNnHSizeOf($aImgDataNew) > 0 ){
					// ตรวจสอบว่ารูปภาพที่ส่งมาเคยอัพโหลดไปหรือยัง ?
					$ci->db->select('FTImgObj');
					$ci->db->from($paImgData['tTableInsert']);
					$ci->db->where_in('FTImgObj',$aImgDataNew);
					$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
					$ci->db->where('FTImgTable',$paImgData['tImgTable']);
					$ci->db->where('FTImgKey',$paImgData['tImgKey']);
					$oQuery = $ci->db->get()->result_array();
				}else{
					$oQuery = array();
				}
				// print_r($oQuery);

				// พบรูปภาพที่อยู่ในเบส
				if( FCNnHSizeOf($oQuery) > 0 ){
					// ตรวจสอบรูปภาพที่ยังไม่ได้อัพโหลด
					$aDataDiff = [];
					foreach( $oQuery as $aValue ){
						array_push($aDataDiff,$aValue['FTImgObj']);
					}
					// print_r($aDataDiff);
					$aResultDiff = array_diff($aImgData,$aDataDiff);
					// print_r($aResultDiff);
					// exit;

					$aDataInsert = [];
					if( FCNnHSizeOf($aResultDiff) > 0 ){// มีรูปภาพใหม่ ที่ยังไม่ได้อัพโหลด
						foreach( $aDataDiff as $aValue ){				// ไม่ต้องอัพโหลดรูปภาพ (มีข้อมูลในเบสแล้ว)
							$aPackData = [
								'tStaUpload' => '2',
								'tImgObj'	 => $aValue
							];
							array_push($aDataInsert,$aPackData);
						}
						foreach( $aResultDiff as $aValue ){				// ต้องอัพโหลดรูปภาพ (ยังไม่มีข้อมูลในเบส)
							$aPackData = [
								'tStaUpload' => '1',
								'tImgObj'	 => $aValue
							];
							array_push($aDataInsert,$aPackData);
						}
					}else{												
						$ci->db->select('FTImgObj');
						$ci->db->from($paImgData['tTableInsert']);
						$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
						$ci->db->where('FTImgTable',$paImgData['tImgTable']);
						$ci->db->where('FTImgKey',$paImgData['tImgKey']);
						$oQueryAll = $ci->db->get()->result_array();

						if( FCNnHSizeOf($oQueryAll) != FCNnHSizeOf($aImgData) ){	// ลบรูปภาพ และไม่ได้เพิ่มรูปภาพใหม่
							foreach( $aImgData as $aValue ){
								$aPackData = [
									'tStaUpload' => '2',
									'tImgObj'	 => $aValue
								];
								array_push($aDataInsert,$aPackData);
							}
						}else{														// ไม่มีรูปภาพใหม่ ที่ต้องอัพโหลด
							$ci->db->trans_commit();											
							return false;
						}
					}

					// Delete Image Obj
					$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
					$ci->db->where('FTImgTable',$paImgData['tImgTable']);
					$ci->db->where('FTImgKey',$paImgData['tImgKey']);
					$ci->db->delete($paImgData['tTableInsert']);

					for ($i = 0; $i < FCNnHSizeOf($aDataInsert); $i++){
						if( $aDataInsert[$i]['tStaUpload'] == '1' ){
							$tbase64          = $aDataInsert[$i]['tImgObj'];
							// $tPath          = $aDataInsert[$i]['tImgObj'];
							// $tType          = pathinfo($tPath,PATHINFO_EXTENSION);
							// $tDataimg       = file_get_contents($tPath);
							// $tbase64        = 'data:image/' . $tType . ';base64,' . base64_encode($tDataimg);
							$aParam     = array(
								'ptImgBase64'   => $tbase64,
								'ptRef1'        => $tRefID,						//รหัส ad, comp
								'ptRef2'        => $paImgData['tImgFolder']		//ชื่อหน้าจอ
							);
							$oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);
							if( $oReuslt['rtCode'] != "001" ){
								$aReturn = array(
									'nStaEvent'    => $oReuslt['rtCode'],
									'tStaMessg'    => $oReuslt['rtDesc']
								);
								return $aReturn;
							}
							$tImgObj = $oReuslt['rtData'];
						}else{
							$aReturn = array(
								'nStaEvent'   => 1,
								'tStaMessg'   => 'Delete Image Only'
							);
							$tImgObj = $aDataInsert[$i]['tImgObj'];
						}
	
						$ci->db->insert($paImgData['tTableInsert'],array(
							'FTImgRefID' 	=> $paImgData['tImgRefID'],
							'FNImgSeq'		=> $i+1,
							'FTImgTable'	=> $paImgData['tImgTable'],
							'FTImgKey'		=> $paImgData['tImgKey'],
							'FTImgObj'		=> $tImgObj,
							'FDLastUpdOn'	=> $paImgData['dDateTimeOn'],
							'FDCreateOn'	=> $paImgData['dDateTimeOn'],
							'FTLastUpdBy'	=> $paImgData['tWhoBy'],
							'FTCreateBy'	=> $paImgData['tWhoBy'],
						));
					}
					
				}else{
					// ถ้าไม่มีรูปภาพที่เคยอัพโหลด ให้ลบข้อมูลทั้งหมด และอัพโหลด
					// Delete Image Obj
					$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
					$ci->db->where('FTImgTable',$paImgData['tImgTable']);
					$ci->db->where('FTImgKey',$paImgData['tImgKey']);
					$ci->db->delete($paImgData['tTableInsert']);
					for ($i = 0; $i < FCNnHSizeOf($aImgData); $i++){
						// print_r($aImgData);exit;
						$tbase64		= $aImgData[$i];
						// $tPath          = $aImgData[$i];
						// $tType          = pathinfo($tPath,PATHINFO_EXTENSION);
						// $tDataimg       = file_get_contents($tPath);
						// $tbase64        = 'data:image/' . $tType . ';base64,' . base64_encode($tDataimg);
						$aParam     = array(
							'ptImgBase64'   => $tbase64,
							'ptRef1'        => $tRefID,						//รหัส ad, comp
							'ptRef2'        => $paImgData['tImgFolder']		//ชื่อหน้าจอ
						);
						// print_r($aParam);exit;
						$oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);
						if( $oReuslt['rtCode'] != "001" ){
							$aReturn = array(
								'nStaEvent'    => $oReuslt['rtCode'],
								'tStaMessg'    => $oReuslt['rtDesc']
							);
							return $aReturn;
						}

						$tImgObj = $oReuslt['rtData'];
						$ci->db->insert($paImgData['tTableInsert'],array(
							'FTImgRefID' 	=> $paImgData['tImgRefID'],
							'FNImgSeq'		=> $i+1,
							'FTImgTable'	=> $paImgData['tImgTable'],
							'FTImgKey'		=> $paImgData['tImgKey'],
							'FTImgObj'		=> $tImgObj,
							'FDLastUpdOn'	=> $paImgData['dDateTimeOn'],
							'FDCreateOn'	=> $paImgData['dDateTimeOn'],
							'FTLastUpdBy'	=> $paImgData['tWhoBy'],
							'FTCreateBy'	=> $paImgData['tWhoBy'],
						));
					}

				}

			}else{
				// ******* Single  Image
				// Delete Data Image Obj
				$ci->db->trans_begin();

				if(isset($paImgData['nStaNotDelete']) && $paImgData['nStaNotDelete'] == 1){
					$nSeq = $paImgData['nSeq'];
				}else{
					$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
					$ci->db->where('FTImgTable',$paImgData['tImgTable']);
					$ci->db->where('FTImgKey',$paImgData['tImgKey']);
					$ci->db->delete($paImgData['tTableInsert']);
					$nSeq = 1;
				}

				if( $paImgData['tImgObj'] != 'NoPic.png' ){

					$tbase64          = $paImgData['tImgObj'];
					// $tPath          = $paImgData['tImgObj'];
					// $tType          = pathinfo($tPath,PATHINFO_EXTENSION);
					// $tDataimg       = file_get_contents($tPath);
					// $tbase64        = 'data:image/' . $tType . ';base64,' . base64_encode($tDataimg);
					
					$aParam     = array(
						'ptImgBase64'   => $tbase64,
						'ptRef1'        => $tRefID,						//รหัส ad, comp
						'ptRef2'        => $paImgData['tImgFolder']		//ชื่อหน้าจอ
					);
					$oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);
					if( $oReuslt['rtCode'] != "001" ){
						$aReturn = array(
							'nStaEvent'    => $oReuslt['rtCode'],
							'tStaMessg'    => $oReuslt['rtDesc']
						);
						return $aReturn;
					}

					$tImgObj = $oReuslt['rtData'];
					$ci->db->insert($paImgData['tTableInsert'],array(
						'FTImgRefID' 	=> $paImgData['tImgRefID'],
						'FNImgSeq'		=> $nSeq,
						'FTImgTable'	=> $paImgData['tImgTable'],
						'FTImgKey'		=> $paImgData['tImgKey'],
						'FTImgObj'		=> $tImgObj,
						'FDLastUpdOn'	=> $paImgData['dDateTimeOn'],
						'FDCreateOn'	=> $paImgData['dDateTimeOn'],
						'FTLastUpdBy'	=> $paImgData['tWhoBy'],
						'FTCreateBy'	=> $paImgData['tWhoBy'],
					));

				}

			}

			// $aGetFile = glob("application/modules/common/assets/system/systemimage/".$_SESSION['tSesUserCode']."/*"); // get all file names
			// foreach($aGetFile as $tPathFile){ // iterate files
			// 	if( is_file($tPathFile) ){
			// 		unlink($tPathFile); // delete file
			// 	}
			// }

			if( $ci->db->trans_status() === false ){
				$ci->db->trans_rollback();
			}else{
				$ci->db->trans_commit();
			}

			if( !isset($aReturn) || empty($aReturn) ){
				$aReturn = array(
					'nStaEvent'    => $oReuslt['rtCode'],
					'tStaMessg'    => $oReuslt['rtDesc'],
					'oSuccessApiReturn' => $oReuslt
				);
			}

		}else{
			if(isset($paImgData['nStaImageMulti']) && $paImgData['nStaImageMulti'] == 1){
				// Delete Image Obj
				$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
				$ci->db->where('FTImgTable',$paImgData['tImgTable']);
				$ci->db->where('FTImgKey',$paImgData['tImgKey']);
				$ci->db->delete($paImgData['tTableInsert']);
			}
			$aReturn = array(
				'nStaEvent'   => 1,
				'tStaMessg'   => 'No Upload Images'
			);
		}
		
		return $aReturn;

	}
}

// Delete In Folder
function FSnHDeleteImageFiles($paImgDel){
	$ci	= &get_instance();
	$ci->load->database();
	if(is_array($paImgDel) && isset($paImgDel)){
		if(isset($paImgDel['tImgRefID']) && is_array($paImgDel['tImgRefID'])){
			foreach($paImgDel['tImgRefID'] AS $tKeyRefID){
				if(is_dir('./application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tKeyRefID)){
					$nNum = FCNnHSizeOf($paImgDel['tImgRefID']);
					if($nNum > 1){ /*ลบหลาย Row*/
						
						for($i = 0; $i < $nNum; $i++){
							$tIDCode = preg_replace('/\s+/', '', $paImgDel['tImgRefID'][$i]); /* ลบ ช่องว่าง */
							$files = glob('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode.'/*'); //get all file names
							foreach($files as $file){
								if(is_file($file))
									unlink($file); //delete file
							}
							if (!is_dir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode)) {
								mkdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode);
							}
							rmdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode);
						}
					}else{ /*ลบ 1 Row*/
						
						$files = glob('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] .'/*'); //get all file names
						foreach($files as $file){
							if(is_file($file))
								unlink($file); //delete file
						}
						if (!is_dir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] )) {
							mkdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
						}
						rmdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
					}
				}
			}
		}else{
			
			if(is_dir('./application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'])){
				$files = glob('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] .'/*'); //get all file names
				foreach($files as $file){
					if(is_file($file))
						unlink($file); //delete file
				}
				if (!is_dir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] )) {
					mkdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
				}
				rmdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
			}else{
				
			}
		}
	}else{}
}

// Delete In DB
function FSnHDelectImageInDB($paImgDel){
	$ci	= &get_instance();
	$ci->load->database();

	$tTableDel	= $paImgDel['tTableDel'];
	$tImgRefID  = $paImgDel['tImgRefID'];
	$tImgTable  = $paImgDel['tImgTable'];

	$ci->db->trans_begin();
	if(!is_array($tImgRefID)){
		$tQueryGroup =	"	DELETE FROM $tTableDel
							WHERE FTImgRefID	= '$tImgRefID' 
							AND FTImgTable		= '$tImgTable'
		";
		$oQuery = $ci->db->query($tQueryGroup);
	}else{
		for($i=0; $i<FCNnHSizeOf($tImgRefID); $i++){
			$tQueryGroup	= 	"	DELETE FROM $tTableDel
									WHERE FTImgRefID 	= '$tImgRefID[$i]' 
									AND FTImgTable		= '$tImgTable'
			";
			$oQuery = $ci->db->query($tQueryGroup);
		}
	}
	if ($ci->db->trans_status() === FALSE){
		$ci->db->trans_rollback();
		return 0;
	}else{
		$ci->db->trans_commit();
		return 1;
	}
}

// Create By : Napat(Jame) 03/12/2020
function FCNxHAddColorObj($paData){
	$ci = &get_instance();
	$ci->load->database();
	$ci->db->where_in('FTImgTable', $paData['tImgTable']);
	$ci->db->where_in('FTImgRefID', $paData['tImgRefID']);
	$ci->db->delete($paData['tTableInsert']);
	// if ($ci->db->affected_rows() > 0) {
	// 	if (file_exists('application/modules/' . $paData['tModuleName'] . '/assets/systemimg/' . $paData['tImgFolder'])) {
	// 		$files    = glob('application/modules/' . $paData['tModuleName'] . '/assets/systemimg/' . $paData['tImgFolder'] . "/" . $paData['tImgRefID'] . "/*"); // get all file names
	// 		foreach ($files as $file) { // iterate files
	// 			if (is_file($file))
	// 				unlink($file); // delete file
	// 		}
	// 	}
	// }
	//Add Master
	$ci->db->insert($paData['tTableInsert'], array(
		'FTImgRefID'        => $paData['tImgRefID'],
		'FTImgTable'        => $paData['tImgTable'],
		'FTImgObj'          => $paData['tImgObj'],
		'FNImgSeq'          => 1,
		'FTImgKey'          => $paData['tImgKey'],
		'FDLastUpdOn'		=> $paData['dDateTimeOn'],
		'FDCreateOn'		=> $paData['dDateTimeOn'],
		'FTLastUpdBy'		=> $paData['tWhoBy'],
		'FTCreateBy'		=> $paData['tWhoBy'],
	));
}





// //Delete Image in database - normal
// function FSnHDeleteImageInDatabase($paImgDel){
// 	$ci = &get_instance();
// 	$ci->load->database();

// 	$ptImgTable = 'TCNMImgObj';
// 	$tImgRefID  = $paImgDel['tImgRefID'];
// 	$tImgTable  = $paImgDel['tImgTable'];

// 	if(FCNnHSizeOf($tImgRefID) == 1 ){
// 		$tQueryGroup = "DELETE FROM TCNMImgObj
// 						WHERE FTImgRefID = '".$tImgRefID."' 
// 						AND FTImgTable = '".$tImgTable."' ";
// 		$oQuery = $ci->db->query($tQueryGroup);
// 	}else{
// 		for($i=0; $i<FCNnHSizeOf($tImgRefID); $i++){
// 			$tQueryGroup = "DELETE FROM TCNMImgObj
// 							WHERE FTImgRefID = '".$tImgRefID[$i]."' 
// 							AND FTImgTable = '".$tImgTable."' ";
// 			$oQuery = $ci->db->query($tQueryGroup);
// 		}
// 	}
// }

// //Delete Image in database - person
// function FSnHDeleteImageInDatabasePerson($paImgDel){
// 	$ci = &get_instance();
// 	$ci->load->database();

// 	$tImgRefID  = $paImgDel['tImgRefID'];
// 	$tImgTable  = $paImgDel['tImgTable'];

// 	if(FCNnHSizeOf($tImgRefID) == 1 ){
// 		$tQueryGroup = "DELETE FROM TCNMImgPerson
// 						WHERE FTImgRefID = '".$tImgRefID."' 
// 						AND FTImgTable = '".$tImgTable."' ";
// 		$oQuery = $ci->db->query($tQueryGroup);
// 	}else{
// 		for($i=0; $i<FCNnHSizeOf($tImgRefID); $i++){
// 			$tQueryGroup = "DELETE FROM TCNMImgPerson
// 							WHERE FTImgRefID = '".$tImgRefID[$i]."' 
// 							AND FTImgTable = '".$tImgTable."' ";
// 			$oQuery = $ci->db->query($tQueryGroup);
// 		}
// 	}
// }

// /**
// * Natt add
// **/

// function FSaHAddImgObj($ptImgRefID, $ptImgSeq, $ptImgTable, $ptImgType, $ptImgKey, $ptNameImg, $ptPathImg) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->insert($ptImgTable,array(
// 		'FNImgRefID' => $ptImgRefID,
// 		'FTImgType' => $ptImgType,
// 		'FNImgSeq' => $ptImgSeq,
// 		'FTImgKey' => $ptImgKey,
// 		'FTImgObj' => 'application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 	));	
// 	if (!file_exists('application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}	
// 	copy('application/modules/common/assets/images/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }


function FSaHUpdateImgObj($ptImgRefID, $ptImgTable, $ptImgType, $ptImgKey, $ptNameImg, $ptPathImg) {	
	$ci = &get_instance();
	$ci->load->database();
	$ci->db->select('FNImgRefID');
	$ci->db->where('FNImgRefID', $ptImgRefID);
	$ci->db->where('FTImgType', $ptImgType);
	$ci->db->where('FNImgSeq', 1);
	$ci->db->where('FTImgKey', 'main');
	$ci->db->from($ptImgTable);
	$oQ = $ci->db->get();
	$count = $oQ->result();
	if (@FCNnHSizeOf($count) >= 1) {
		$ci->db->where ( 'FNImgRefID', $ptImgRefID );
		$ci->db->where ( 'FTImgType', $ptImgType);
		$ci->db->where ( 'FTImgKey', 'main');
		$ci->db->update ( $ptImgTable, array (
			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
		) );
	} else {
		$ci->db->insert($ptImgTable,array(
			'FNImgRefID' => $ptImgRefID,
			'FTImgType' => $ptImgType,
			'FNImgSeq' => 1,
			'FTImgKey' => 'main',
			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
		));	
	}
	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
	}
	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
	foreach($files as $file){
		if(is_file($file))
	    unlink($file); //delete file
}
copy('application/assets/system/systemimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
}

// function FSaHUpdateImg($ptImgRefID, $nSeq, $ptImgTable, $ptImgType, $ptImgKey, $ptNameImg, $ptPathImg) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->select('FNImgRefID');
// 	$ci->db->where('FNImgRefID', $ptImgRefID);
// 	$ci->db->where('FTImgType', $ptImgType);
// 	$ci->db->where('FNImgSeq', $nSeq);
// 	$ci->db->where('FTImgKey', $ptImgKey);
// 	$ci->db->from($ptImgTable);
// 	$oQ = $ci->db->get();
// 	$count = $oQ->result();
// 	if (@FCNnHSizeOf($count) >= 1) {
// 		$ci->db->where ( 'FNImgRefID', $ptImgRefID );
// 		$ci->db->where ( 'FTImgType', $ptImgType);
// 		$ci->db->where ( 'FNImgSeq', $nSeq);
// 		$ci->db->where ( 'FTImgKey', $ptImgKey);
// 		$ci->db->update ( $ptImgTable, array (
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
// 		) );
// 	} else {
// 		$ci->db->insert($ptImgTable,array(
// 			'FNImgRefID' => $ptImgRefID,
// 			'FTImgType' => $ptImgType,
// 			'FNImgSeq' => $nSeq,
// 			'FTImgKey' => $ptImgKey,
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 		));
// 	}
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}
// 	//unlink('application/assets/system/'.$ptPathImg.'/'.$ptImgRefID.'/'.$count[0]->FTImgObj);
// 	copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }

function FSaHDelImgObj($ptImgID, $ptTableDel, $ptNameImg, $ptImgTable) {	
	$ci = &get_instance();
	$ci->load->database();
	$ci->db->delete($ptTableDel, array(
		'FTImgRefID' => $ptImgID,
		'FTImgTable' => $ptImgTable,
	));	
	// unlink($ptNameImg);
}

// function FSaDelImg($ptImgRefID, $ptImgTable, $ptImgType, $ptImgKey, $ptPathImg) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->where ( 'FNImgRefID', $ptImgRefID);
// 	$ci->db->where ( 'FTImgType', $ptImgType);
// 	$ci->db->where ( 'FTImgKey', $ptImgKey);
// 	$ci->db->delete ($ptImgTable);
// 	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// }
// @rmdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID);
// }
// /********************************************************************************************/
// function FSxCNAddImgObj($ptImgRefID, $ptImgSeq, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->insert($ptImgTable,array(
// 		'FTImgRefID' => $ptImgRefID,
// 		'FNImgSeq' => $ptImgSeq,
// 		'FTImgKey' => $ptImgKey,
// 		'FTImgTable' => $ptFImgTable,
// 		'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 	));	
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}	
// 	copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }
// function FSxCNUpdateImgObj($ptImgRefID, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->select('FTImgRefID');
// 	$ci->db->where('FTImgRefID', $ptImgRefID);
// 	$ci->db->where('FNImgSeq', 1);
// 	$ci->db->where('FTImgKey', 'main');
// 	$ci->db->where('FTImgTable', $ptFImgTable);
// 	$ci->db->from($ptImgTable);
// 	$oQ = $ci->db->get();
// 	$count = $oQ->result();
// 	if (@FCNnHSizeOf($count) >= 1) {
// 		$ci->db->where ( 'FTImgRefID', $ptImgRefID );
// 		$ci->db->where ( 'FTImgKey', 'main');
// 		$ci->db->where('FTImgTable', $ptFImgTable);
// 		$ci->db->update ( $ptImgTable, array (
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
// 		) );
// 	} else {
// 		$ci->db->insert($ptImgTable,array(
// 			'FTImgRefID' => $ptImgRefID,
// 			'FNImgSeq' => 1,
// 			'FTImgKey' => 'main',
// 			'FTImgTable' => $ptFImgTable,
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 		));	
// 	}
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}
// 	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// }
// copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }

// function FSxCNUpdateImg($ptImgRefID, $nSeq, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->select('FTImgRefID');
// 	$ci->db->where('FTImgRefID', $ptImgRefID);
// 	$ci->db->where('FNImgSeq', $nSeq);
// 	$ci->db->where('FTImgKey', $ptImgKey);
// 	$ci->db->where('FTImgTable', $ptFImgTable);
// 	$ci->db->from($ptImgTable);
// 	$oQ = $ci->db->get();
// 	$count = $oQ->result();
// 	if (@FCNnHSizeOf($count) >= 1) {
// 		$ci->db->where ( 'FTImgRefID', $ptImgRefID );
// 		$ci->db->where ( 'FNImgSeq', $nSeq);
// 		$ci->db->where ( 'FTImgKey', $ptImgKey);
// 		$ci->db->where('FTImgTable', $ptFImgTable);
// 		$ci->db->update ( $ptImgTable, array (
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
// 		) );
// 	} else {
// 		$ci->db->insert($ptImgTable,array(
// 			'FTImgRefID' => $ptImgRefID,
// 			'FNImgSeq' => $nSeq,
// 			'FTImgKey' => $ptImgKey,
// 			'FTImgTable' => $ptFImgTable,
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 		));
// 	}
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}
// 	//unlink('application/assets/system/'.$ptPathImg.'/'.$ptImgRefID.'/'.$count[0]->FTImgObj);
// 	copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }

// function FSxCNDelImg($ptImgRefID, $ptImgTable, $ptImgKey, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->where ( 'FTImgRefID', $ptImgRefID);
// 	$ci->db->where ( 'FTImgKey', $ptImgKey);
// 	$ci->db->where ( 'FTImgTable', $ptFImgTable);
// 	$ci->db->delete ($ptImgTable);
// 	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// 	}
// 	@rmdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID);
// }


// function FSxAddtextOn($text, $file, $out) { 
//   list($width, $height) = getimagesize($file);
//   $image_p = imagecreatetruecolor($width, $height);
//   $image = imagecreatefromjpeg($file);
//   imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
//   $text_color = imagecolorallocate($image_p, 0, 0, 0);
//   $bg_color = imagecolorallocate($image_p, 255, 255, 255);
//   $font = FCPATH.'application/libraries/image/ubuntu.ttf';
//   $tFontText = 12;
//   $dims = imagettfbbox($tFontText, 0, $font, $text);
//   $oImgHeight = (int)$height - (int)$tFontText;
//   imagefilledrectangle($image_p, (int)$width - 190, $height, $width, (int)$height - 40, $bg_color);
//   imagettftext($image_p, $tFontText, 0, (int)$width - 150, $oImgHeight, $text_color, $font, $text);
//   imagejpeg($image_p, $out, 100); 
//   imagedestroy($image); 
//   imagedestroy($image_p); 
// }

// function FSxPMTAddImg($ptImgRefID, $ptImgSeq, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable, $ptFTPmhCode) {
// 	require 'application/libraries/image/vendor/autoload.php';

// 	@header('Content-type: image/jpeg');
// 	require 'application/libraries/image/vendor/autoload.php';	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	@$ci->db->where ('FNImgRefID', $ptImgRefID);
// 	@$ci->db->where ('FNImgSeq', $ptImgSeq);
// 	@$ci->db->where ('FTImgKey', $ptImgKey);
// 	@$ci->db->where ('FTImgTable', $ptFImgTable);
// 	@$ci->db->delete ($ptImgTable);
// 	$files = glob('application/assets/system/eticket/promotion/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// 	}
// 	$ci->db->insert($ptImgTable,array(
// 		'FNImgRefID' => $ptImgRefID,
// 		'FNImgSeq' => $ptImgSeq,
// 		'FTImgKey' => $ptImgKey,
// 		'FTImgTable' => $ptFImgTable,
// 		'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 	)); 
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		@mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);     
// 	}
// 	$image = new \NMC\ImageWithText\Image('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg);
// 	$text1 = new \NMC\ImageWithText\Text('', 3, 25);
// 	//$text1 = new \NMC\ImageWithText\Text($ptFTPmhCode, 3, 25);
// 	$text1->align = 'right';
// 	$text1->color = 'FFFFFF';
// 	$text1->font = FCPATH.'application/libraries/image/ubuntu.ttf';
// 	$text1->lineHeight = 36;
// 	$text1->size = 24;
// 	$text1->startX = 5;
// 	$text1->startY = 110;
// 	$image->addText($text1);
// 	$image->render('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
//     FSxAddtextOn($ptFTPmhCode, 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg, 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }

// Create By : Napat(Jame) 16/02/2021
// ตรวจสอบว่าเป็น รูปภาพ หรือ สี และ return obj ออกไปแสดงผล
function FCNtHChkImgColor($poImage){
	$tPatchImg = 'img';
	if( isset($poImage) && !empty($poImage) ){
		$tImgObj = substr($poImage,0,1);
		if($tImgObj != '#'){
			$tPatchImg = $poImage;
		}else{  
			$tPatchImg = "0";
		}
	}
	return $tPatchImg;
}

// Create By : Napat(Jame) 16/02/2021
function FCNtHGetImagePageList($poImage,$ptWidth = '100%',$ptImgDefault = 'default', $ptAddClass = ''){
	$tPatchImg = FCNtHChkImgColor($poImage);
	if( $tPatchImg == '0' ){ // แสดง background color
		$tReturnObj = '<div class="text-center"><span style="height:40px;width:'.$ptWidth.';background-color:'.$poImage.';display:inline-block;line-height:2.3;"></span></div>';
	}else{					 // แสดงรูปภาพ
		if( $ptImgDefault == 'user' || $ptImgDefault == 'customer' ){
			// $tImgDefault = 'application/modules/common/assets/images/icons/Customer.png';
			$tImgDefault = 'application/modules/common/assets/images/NoPhoto.png';
		}else if( $ptImgDefault == 'logo' ){
			$tImgDefault = 'application/modules/common/assets/images/logo/AdaPos5_Logo.png';
		}else{
			$tImgDefault = 'application/modules/common/assets/images/Noimage.png';
		}
		$tReturnObj = '<img src="'.$poImage.'" class="img img-respornsive '.$ptAddClass.' " style="width:'.$ptWidth.'" onerror="this.onerror=null;this.src=\''.$tImgDefault.'\';" >';
	}
	return $tReturnObj;
}

// Create By : Napat(Jame) 16/02/2021
// $ptBrowseType 1 = Single Image , 2 = Multi Image + Color , 3 = เฉพาะหน้าจอ AdMessage
function FCNtHGetContentUploadImage($poImage,$ptMasterName,$ptBrowseType = '1',$ptRetion = '0'){
	$tPatchImg  = FCNtHChkImgColor($poImage);
	$tReturnObj = '';
	
	if( $tPatchImg != '0' ){
		$tSrc 		= 'src="'.$poImage.'"';
		$tColorObj 	= '';
		$tValueObj  = $poImage;
	}else{
		$tSrc		= '';
		$tColorObj 	= '#';
		$tValueObj  = $poImage;
	}

	if( isset($poImage) && !empty($poImage) ){
		$tImageName  = basename($poImage);
	}else{
		$tImageName  = '';
	}
	$tReturnObj  = "";
	if( $ptBrowseType != "3" ){
		$tReturnObj .= '<div class="upload-img" id="oImgUpload">';
		$tReturnObj .= '	<img id="oimImgMaster'.$ptMasterName.'" class="img-responsive xCNImgCenter" style="width: 100%;" '.$tSrc.' onerror="this.onerror=null;this.src=\'application/modules/common/assets/images/Noimage.png\';" > ';
		$tReturnObj .= '</div>';
	}

	$tReturnObj .= '<input type="hidden" id="ohdImgObj" name="ohdImgObj" data-color="'.$tColorObj.'" value="'.$tValueObj.'">';
	$tReturnObj .= '<input type="hidden" id="ohdImgObjOld" name="ohdImgObjOld" value="">';

	$tReturnObj .= '<div class="xCNUplodeImage">';
	$tReturnObj .= '	<input type="text" class="xCNHide" id="ohdRetionCropper"  name="ohdRetionCropper" value="'.$ptRetion.'"> ';
	$tReturnObj .= '	<input type="text" class="xCNHide" id="oetImgInput'.$ptMasterName.'Old"  name="oetImgInput'.$ptMasterName.'Old" value="'.$tImageName.'"> ';
	$tReturnObj .= '	<input type="text" class="xCNHide" id="oetImgInput'.$ptMasterName.'" name="oetImgInput'.$ptMasterName.'" value="'.$tImageName.'"> ';
	$tReturnObj .= '	<input style="display:none;" type="file" id="oetInputUplode'.$ptMasterName.'" onchange="JSxImageUplodeResizeNEW(this,\'\',\''.$ptMasterName.'\',\''.$ptBrowseType.'\')" accept="image/png, image/jpeg"> ';
	$tReturnObj .= '	<button class="btn xCNBTNDefult" type="button" onclick="$(\'#oetInputUplode'.$ptMasterName.'\').click()"><i class="fa fa-picture-o xCNImgButton"></i> '.language('common/main/main', 'tSelectPic').'</button> ';
	$tReturnObj .= '</div>';
	// $tReturnObj .= '<div id="odvModalCrop'.$ptMasterName.'"></div>';
	
	return $tReturnObj;
}

function FCNtHGetContentTumblrImage($poImage,$ptMasterName){
	$tReturnObj  = '';
	$tReturnObj .= '<div id="odvImageTumblr" style="padding-top:10px;overflow-x:auto;" class="table-responsive">';
	$tReturnObj .= '	<table id="otbImageList'.$ptMasterName.'">';
	$tReturnObj .= '		<tr>';
							if ( isset($poImage) && FCNnHSizeOf($poImage) > 0 ){
								// ตรวจสอบถ้าไม่ใช่สี
								$tPatchImg = FCNtHChkImgColor($poImage[0]['FTImgObj']);
								if( $tPatchImg != '0' ){
									foreach ( $poImage as $nKey => $aValueImg ){
										if ( isset($aValueImg['FTImgObj']) && !empty($aValueImg['FTImgObj']) ){
											// $tPatchImg = FCNtHChkImgColor($aValueImg['FTImgObj']);
											$tImageName = basename($aValueImg['FTImgObj']);

											$tReturnObj .= '<td id="otdTumblr'.$ptMasterName.$nKey.'" class="xWTDImgDataItem">';
											$tReturnObj .= '<img id="oimTumblr'.$ptMasterName.$nKey.'" ';
											$tReturnObj .= '	 src="'.$aValueImg['FTImgObj'].'" ';
											$tReturnObj .= '	 data-tumblr="'.$nKey.'" ';
											$tReturnObj .= '	 class="xCNImgTumblr img img-respornsive" ';
											$tReturnObj .= '	 style="z-index:100;width:80px;height:80px;" ';
											$tReturnObj .= '	 onerror="this.onerror=null;this.src=\'application/modules/common/assets/images/Noimage.png\';" ';
											$tReturnObj .= '> ';
											$tReturnObj .= '<div class="xCNImgDelIcon" id="odvImgDelBnt'.$ptMasterName.$nKey.'" data-id="'.$nKey.'" onclick=\'JCNxRemoveImgTumblrNEW(this, "'.$ptMasterName.'")\'> ';
											$tReturnObj .= '	<i class="fa fa-times" aria-hidden="true"></i> '.language('common/main/main', 'tRemoveImage');
											$tReturnObj .= '</div>';
											$tReturnObj .= '<script type="text/javascript">';
											$tReturnObj .= '$("#oimTumblr'.$ptMasterName.$nKey.'").click(function() {';
											$tReturnObj .= '	$("#oimImgMaster'.$ptMasterName.'").attr("src", $(this).attr("src")); ';
											$tReturnObj .= '	return false;';
											$tReturnObj .= '});';
											$tReturnObj .= '$("#oimTumblr'.$ptMasterName.$nKey.'").hover(function() {';
											$tReturnObj .= '	$("#odvImgDelBnt'.$ptMasterName.$nKey.'").show();';
											$tReturnObj .= '});';
											$tReturnObj .= '$("#oimTumblr'.$ptMasterName.$nKey.'").mouseleave(function() {';
											$tReturnObj .= '	$("#odvImgDelBnt'.$ptMasterName.$nKey.'").hide();';
											$tReturnObj .= '});';
											$tReturnObj .= '$("#odvImgDelBnt'.$ptMasterName.$nKey.'").hover(function() {';
											$tReturnObj .= '	$(this).show();';
											$tReturnObj .= '	$("#'.$nKey.'").addClass("xCNImgHover");';
											$tReturnObj .= '});';
											$tReturnObj .= '$("#odvImgDelBnt'.$ptMasterName.$nKey.'").mouseleave(function() {';
											$tReturnObj .= '	$(this).hide();';
											$tReturnObj .= '});';
											// $tReturnObj .= '$("#odvImgDelBnt'.$ptMasterName.$nKey.'").click(function() {';
											// $tReturnObj .= '	JCNxRemoveImgTumblrNEW(this, "slipMessage");';
											// $tReturnObj .= '});';
											$tReturnObj .= '</script>';
											$tReturnObj .= '</td>';
										}
									}
								}
							}
	$tReturnObj .= '		</tr>';
	$tReturnObj .= '	</table>';
	$tReturnObj .= '</div>';
	return $tReturnObj;
}

function FCNtHGetContentChooseColor($poImage,$ptMasterName){
	$tReturnObj  = '';
	$tReturnObj .= '<div class="col-xs-12 col-sm-12" style="margin-top:10%;">';
	$tReturnObj .= '	<label class="xCNLabelFrm"><span class="text-danger">*</span>'.language('common/main/main', 'tChooseColor').'</label>';
	$tReturnObj .= '	<div class="xCNCustomRadios">';

	$aColorStarter = array(
		'01' => [ 'RGB' => '#2184c7', 'Title' => 'Blue Light' ],
		'02' => [ 'RGB' => '#2f499e', 'Title' => 'Blue' ],
		'03' => [ 'RGB' => '#9d4c2e', 'Title' => 'Brown' ],
		'04' => [ 'RGB' => '#319845', 'Title' => 'Green' ],
		'05' => [ 'RGB' => '#e45b25', 'Title' => 'Orange' ],
		'06' => [ 'RGB' => '#582979', 'Title' => 'Purple' ],
		'07' => [ 'RGB' => '#ee2d24', 'Title' => 'Red' ],
		'08' => [ 'RGB' => '#000000', 'Title' => 'Black' ]
	);
	foreach($aColorStarter as $nKey => $tValue){
		$tReturnObj .= '<div title="'.$tValue['Title'].'">';
		$tReturnObj .= '	<input type="radio" id="orbChecked'.$nKey.'" class="xCNCheckedORB" name="orbChecked" value="'.$tValue['RGB'].'" data-name="'.$tValue['RGB'].'">';
		$tReturnObj .= '	<label for="orbChecked'.$nKey.'">';
		$tReturnObj .= '		<span style="background-color: '.$tValue['RGB'].';">';
		$tReturnObj .= '			<img src="'.base_url().'application/modules/common/assets/images/icons/check.png'.'" alt="Checked Icon" height="20" width="20" />';
		$tReturnObj .= '		</span>';
		$tReturnObj .= '	</label>';
		$tReturnObj .= '</div>';
	}

	$tReturnObj .= '	</div>';
    $tReturnObj .= '</div>';

	$tPatchImg  = FCNtHChkImgColor($poImage);
	$tItemsColor = Array('#BCDDBE','#FF9AA2','#FFB7B2','#FFDAC1','#E2F0CB','#B5EAD7','#C7CEEA','#64E987','#92F294','#C0F9FA','#88CEFB','');
	$tRandIndex = array_rand($tItemsColor);
	$tColor     = $tItemsColor[$tRandIndex];
	if( $tPatchImg == '0' ){
		$tColor = $poImage;
	}

	$tReturnObj .= '<div class="col-xs-12 col-sm-12" style="margin-top:1%;">';
	$tReturnObj .= '	<div class="input-group colorpicker-component xCNSltColor">';
	$tReturnObj .= '		<input class="form-control" type="hidden" id="oetImgColor'.$ptMasterName.'" name="oetImgColor'.$ptMasterName.'" maxlength="7" value="'.$tColor.'">';
	$tReturnObj .= '		<span class="input-group-addon xCNChooseColor" id="ospColor"></span>';
	$tReturnObj .= '		<label class="xCNLabelFrm" style="margin-left: 10px;">'.language('common/main/main', 'tChooseColorCustom').'</label>';
	$tReturnObj .= '	</div>';
	$tReturnObj .= '</div>';

	$tReturnObj .= '<script src="'.base_url('application/modules/common/assets/js/bootstrap-colorpicker.min.js').'"></script>';
	$tReturnObj .= '<script type="text/javascript">';
	$tReturnObj .= '	JCNxImgLoadScript("'.$ptMasterName.'");'; //jTempImage,js
	$tReturnObj .= '</script>';

	return $tReturnObj;

}

// Create By : Napat(Jame) 19/02/2021
function FCNaHUploadMedia($paMediaData){
	$ci = &get_instance();
	$ci->load->database();
	try {
		if(is_array($paMediaData) && isset($paMediaData)){
			$tSesUserCode 				= $_SESSION["tSesUserCode"];
			// $config['upload_path']      = './application/modules/common/assets/system/systemimage/'.$tSesUserCode;
			// $config['allowed_types']    = 'mp3|mp4|avi|wav|mpeg';

			if( $_SESSION["bIsHaveAgn"] ){
				$tRefID = $_SESSION["tSesUsrAgnCode"]; // AD
			}else{
				$tRefID = '00001'; // Comp Code
			}

			// if(!is_dir($config['upload_path'])){
			// 	mkdir($config['upload_path']);// make folder
			// }

			$ci->db->trans_begin();

			// $aUrlPathServer 		= explode('/index.php',$_SERVER['SCRIPT_FILENAME']);
			// $tPathFullComputer		= str_replace('\\', "/", $aUrlPathServer[0]. "/application/modules/common/assets/system/systemimage");
			$nIndex 				= 0;
			$nSeq 					= 1;

			// print_r($paMediaData['oMediaObj']);exit;

			$tSQL       = "SELECT TOP 1 FTUrlAddress FROM TCNTUrlObject WITH(NOLOCK) WHERE FTUrlKey = 'FILE' AND FTUrlTable = 'TCNMComp' AND FTUrlRefID = 'CENTER' ORDER BY FNUrlSeq ASC";
			$oQuery     = $ci->db->query($tSQL);
			if($oQuery->num_rows() > 0){
				$oList      = $oQuery->result_array();
				$tUrlAddr   = $oList[0]['FTUrlAddress'];
			}else{
				$aReturn = array(
					'nStaEvent'    => 900,
					'tStaMessg'    => 'เกิดข้อผิดพลาด ไม่พบ API ในการเชื่อมต่อ'
				);
				return $aReturn;
			}

			$tUrlApi    = $tUrlAddr.'/Upload/Media';
			$aAPIKey    = array(
				'tKey'      => 'X-Api-Key',
				'tValue'    => '12345678-1111-1111-1111-123456789410'
			);

			foreach ($paMediaData['oMediaObj'] as $tKey => $aFile){
				// $tFilename 					= 'Media'.date('YmdHis');
				// $config['file_name']        = $tFilename;

				// $ci->upload->initialize($config);
				// $ci->upload->do_upload($tKey);

				// $tFileType					= strtoupper(explode('.', $aFile['name'])[1]);
				$tFileType					= strtoupper(substr(explode('/', $aFile['type'])[1],0,3));
				// $tFullPathMedia				= $tPathFullComputer."/".$tSesUserCode."/".$tFilename.".".strtolower($tFileType);

				$aParam     = array(
					// 'ptContent'     => new CURLFILE($tFullPathMedia),
					'ptContent'		=> new CURLFILE($aFile['tmp_name'],$aFile['type'],$aFile['name']),
					'ptRef1'        => $tRefID,
					'ptRef2'        => 'admessage'
				);
				// print_r($aParam);exit;
				$oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey,'video');
				if( $oReuslt['rtCode'] != "99" ){

					if( isset($paMediaData['aMediaSeq']) && !empty($paMediaData['aMediaSeq']) ){
						$nMediaSeq = $paMediaData['aMediaSeq'][$nIndex];
					}else{
						$nMediaSeq = $nSeq;
					}

					$ci->db->insert($paMediaData['tTableInsert'],array(
						'FTMedRefID' 	=> $paMediaData['tMediaRefID'],
						'FNMedSeq'		=> $nMediaSeq,
						'FNMedType'		=> $paMediaData['tMediaType'],
						'FTMedFileType'	=> $tFileType,
						'FTMedTable'	=> $paMediaData['tMediaTable'],
						'FTMedKey'		=> $paMediaData['aMediaKey'][$nIndex],
						'FTMedPath'		=> $oReuslt['rtData'],
						'FDLastUpdOn'	=> $paMediaData['dDateTimeOn'],
						'FDCreateOn'	=> $paMediaData['dDateTimeOn'],
						'FTLastUpdBy'	=> $paMediaData['tWhoBy'],
						'FTCreateBy'	=> $paMediaData['tWhoBy'],
					));
					
					$aReturn = array(
						'nStaEvent'    => $oReuslt['rtCode'],
						'tStaMessg'    => $oReuslt['rtDesc']
					);
				}else{
					$ci->db->trans_rollback();
					$aReturn = array(
						'nStaEvent'    => $oReuslt['rtCode'],
						'tStaMessg'    => $oReuslt['rtDesc']
					);
					return $aReturn;
				}
				$nIndex++;
				$nSeq++;
			}

			// Delete Tmp Media
			// $aGetFile = glob("application/modules/common/assets/system/systemimage/".$tSesUserCode."/*"); // get all file names
			// foreach($aGetFile as $tPathFile){ // iterate files
			// 	if( is_file($tPathFile) ){
			// 		unlink($tPathFile); // delete file
			// 	}
			// }

			
			$ci->db->trans_commit();
		}else{
			$aReturn = array(
				'nStaEvent'    => 600,
				'tStaMessg'    => 'Not Found Media Data In Paramaters'
			);
		}
	} catch (ErrorException $Error) {
		$aReturn = array(
			'nStaEvent' => 500,
			'tStaMessg' => $Error->getMessage()
		);
	}

	return $aReturn;
}