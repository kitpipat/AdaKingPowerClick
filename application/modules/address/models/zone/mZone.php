<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mZone extends CI_Model {
	
	public function FSaMZNEUpdateChangeZneL($tChainNameOld,$tChainNameNew,$nlen,$tZneChain){
		
		$tSQL2 = "UPDATE TCNMZone_L SET
							FTZneChainName = REPLACE(FTZneChainName, '$tChainNameOld', '$tChainNameNew')
							";
		$oQuery2 = $this->db->query($tSQL2);
		echo "เข้าเปลี่ยนภาษา L";
	
	}

	public function FSaMZNECheckLangAdded($nZneCode,$nLangEdit){
 
		$tSQL = "SELECT COUNT(FTZneCode) AS counts
				 FROM TCNMZone_L
				 WHERE FTZneCode = '$nZneCode' 
				 AND FNLngID = $nLangEdit";
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
		return $oQuery->result();
		} else {
		//No Data
		return false;
		}

	}

	
	public function FSaMZNEUpdateZneNameAndFTZneChainNameMaster($aDataMaster){

		$oetZneChainOld = $aDataMaster['oetZneChainOld']; 
		$oetZneChainCurrent = $aDataMaster['oetZneChainCurrent']; 
		$nLenChainCurrent = $aDataMaster['nLenChainCurrent']; 
		$oetZneParent = $aDataMaster['oetZneParent']; 
		$tZneCode = $aDataMaster['FTZneCode']; 
		$oetZneNameOld = $aDataMaster['oetZneNameOld']; 
		$tZneName = $aDataMaster['FTZneName']; 
		$oetZneParentNameOld = $aDataMaster['oetZneParentNameOld']; 
		$oetZneParentName = $aDataMaster['oetZneParentName']; 
		$FTZneRmk =   $aDataMaster['FTZneRmk']; 
		$tZneChainName = $aDataMaster['FTZneChainName'];
		$tLastUpdBy    = $aDataMaster['FTLastUpdBy'];
		$tLastUpdOn    = $aDataMaster['FDLastUpdOn'];
		
		$tSQL1 = 	"UPDATE TCNMZone SET
						 	FTZneChain = REPLACE(FTZneChain, '$oetZneChainOld', '$oetZneChainCurrent')
					WHERE FTZneCode IN(
					SELECT ZNE.FTZneCode FROM TCNMZone ZNE LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode
					WHERE LEFT(ZNE.FTZneChain , $nLenChainCurrent) = '$oetZneChainOld'
					AND LEN(ZNE.FTZneChain) > $nLenChainCurrent)";
		$oQuery1 = $this->db->query($tSQL1);

		$tSQL2 = 	"UPDATE TCNMZone SET
						  FTZneChain = REPLACE(FTZneChain, '$oetZneChainOld', '$oetZneChainCurrent'),
						  FTZneParent = '$oetZneParent',
						  FTLastUpdBy = '$tLastUpdBy',
						  FDLastUpdOn = '$tLastUpdOn '
				 	WHERE FTZneCode = '$tZneCode' ";
		$oQuery2 = $this->db->query($tSQL2);


		$tSQL3 = "UPDATE TCNMZone SET
					FTZneChain = REPLACE(FTZneChain, '$oetZneChainOld', '$oetZneChainCurrent')
					WHERE FTZneCode IN(
					SELECT ZNE.FTZneCode FROM TCNMZone ZNE LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode
					WHERE LEFT(ZNE.FTZneChain , $nLenChainCurrent) = '$oetZneChainOld'
					AND LEN(ZNE.FTZneChain) > $nLenChainCurrent)";
		$oQuery3 = $this->db->query($tSQL3);


		$tSQL4 = "UPDATE TCNMZone_L SET
				    -- FTZneName = REPLACE(FTZneName, '$oetZneNameOld', '$tZneName') ,
					FTZneName =  '$tZneName',
					FTZneRmk  =  '$FTZneRmk',
					FTZneChainName = '$tZneChainName'
					WHERE FTZneCode = $tZneCode";
		$oQuery4 = $this->db->query($tSQL4);


		$nLenn = strlen($oetZneChainCurrent);
		
		if($oetZneParentNameOld != ''){
			$old = $oetZneParentNameOld.'>'.$oetZneNameOld;
		}else{
			$old = $oetZneNameOld;
		}

		if($oetZneParentName != ''){
			$new = $oetZneParentName.'>'.$tZneName;
		}else{
			$new = $tZneName;
		}

		$tSQL5 = "UPDATE TCNMZone_L SET
		FTZneChainName = REPLACE(FTZneChainName, '$old', '$new')
		WHERE FTZneCode IN(
		SELECT ZNE.FTZneCode FROM TCNMZone ZNE LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode
		WHERE LEFT(ZNE.FTZneChain , $nLenn) = '$oetZneChainCurrent'
		OR ZNEL.FTZneCode = $tZneCode
		AND LEN(ZNE.FTZneChain) > $nLenn 
		)";
		$oQuery5 = $this->db->query($tSQL5);


		return $oQuery5;
	}
	
	
	
	public function FSaMZNEUpdateZneNameAndFTZneChainName($tZneCode,$oetZneNameOld,$oetZneName,$nlen,$tZneChain){

		$tSQL2 = "UPDATE TCNMZone_L SET
		FTZneChainName = REPLACE(FTZneChainName, '$oetZneNameOld>', '$oetZneName>')
		WHERE FTZneCode IN(
		SELECT ZNE.FTZneCode FROM TCNMZone ZNE LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode
		WHERE LEFT(ZNE.FTZneChain , $nlen) = '$tZneChain'
		AND LEN(ZNE.FTZneChain) > $nlen)";
	
		$oQuery2 = $this->db->query($tSQL2);
	
	}
	
	
	
	//Function : หา ZoneChain Name ของ Zone Parent ที่เลือก
	//Create : 23-05-2018 Krit(Copter)
	public function FSaMZNEGetZneSelectZneChainName($ptZneCodeSelet){
		$tSQL = "SELECT FTZneChainName
				 FROM TCNMZone_L
				 WHERE FTZneCode = '$ptZneCodeSelet' ";
	
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			return $oQuery->result();
		} else {
			//No Data
			return false;
		}
	}
	
	public function FSaMZNEGetZneLevelANDZneChain($ptZneCodeSelet){

		$tSQL = "SELECT FNZneLevel,FTZneParent,FTZneChain
				 FROM TCNMZone 
				 WHERE FTZneCode = '$ptZneCodeSelet' ";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
		
			return $oQuery->result();
		
		} else {
			//No Data
			return false;
		}
		
	}
	
	
	//Functionality : delete Warehouse
	//Parameters : function parameters
	//Creator : 14/05/2018 Krit(Copter)
	//Return : response
	//Return Type : array
	public function FSnMZNEDel($paParamMaster){
	
		$this->db->where_in('FTZneCode', $paParamMaster['FTZneCode']);
		$this->db->delete('TCNMZone');
	
		$this->db->where_in('FTZneCode', $paParamMaster['FTZneCode']);
		$this->db->delete('TCNMZone_L');

		
		if($this->db->affected_rows() > 0) {
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
	

	
	
	//Functionality : Search Branch By ID
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSaMZNESearchByID($paData){

		$tCode = $paData['FTZneCode'];
		$nLngID = $paData['FNLngID'];
		
		
	
		if(@$tCode){
	
			$tSQL = "SELECT
							ZNE.FTZneCode 				AS rtZneCode,
							ZNE.FNZneLevel 				AS rnZneLevel,
							ZNE.FTZneParent 			AS rtZneParent,
							ZNE.FTZneChain 				AS rtZneChain,
							ZNE.FTAreCode 				AS rtAreCode,
							
							ZNEL.FTZneName 				AS rtZneName,
							ZNEL.FTZneRmk 				AS rtZneRemark,
							ZNEPARENT.FTZneName 		AS rtZneParentName,
							ZNEPARENT.FTZneChainName 	AS rtZneChainName,
							AREL.FTAreName 				AS rtAreName
							
							FROM [TCNMZone] ZNE
							LEFT JOIN [TCNMZone_L] ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode AND ZNEL.FNLngID = $nLngID
							LEFT JOIN [TCNMZone_L] ZNEPARENT ON ZNE.FTZneParent = ZNEPARENT.FTZneCode AND ZNEPARENT.FNLngID = $nLngID
							LEFT JOIN [TCNMArea_L] AREL ON ZNE.FTAreCode = AREL.FTAreCode AND AREL.FNLngID = $nLngID
								
					";
	
			if ($tCode != '') {
				$tSQL .= " WHERE ZNE.FTZneCode = '$tCode'";
			}
			
			$oQuery = $this->db->query($tSQL);
			if ($oQuery->num_rows() > 0) {
				$aDetail = $oQuery->result();
			} else {
				//No Data
				$aDetail = '';
			}
	
		}
	
		if(@$aDetail){
	
			$aResult = array(
					'roItem' => $aDetail[0],
					'rtCode' => '1',
					'rtDesc' => 'success',
			);
		}else{
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
	
	
	
	//Functionality : list Zone
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMZNEList($paData){

		$aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$nLngID = $paData['FNLngID'];
		
		$tSQL = "SELECT c.* FROM(
					SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtZneCode DESC) AS rtRowID,* FROM
						(SELECT DISTINCT
										  ZNE.FTZneCode 		AS rtZneCode,
										  ZNE.FNZneLevel 		AS rnZneLevel,
										  ZNE.FTZneParent 		AS rtZneParent,
										  ZNE.FTZneChain 		AS rtZneChain,
										  ZNE.FTAreCode 		AS rtAreCode,
										  
										  ZNEL.FTZneName 		AS rtZneName,
										  ZNEL.FTZneChainName 	AS rtZneChainName,
										  ZNEL.FTZneRmk 		AS rtZneRemark	,
										  ZNE.FDCreateOn			 
										  
    					FROM TCNMZone ZNE
						LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode AND ZNEL.FNLngID = $nLngID
						WHERE 1 = 1
						";
		
		@$tWhereCode = $paData['tWhereCode'];
		if (@$tWhereCode != '') {
			$tSQL .= " AND (ZNE.FTAreCode = '$tWhereCode')";
		}
		
		$tSearchList = $paData['tSearchAll'];
		if ($tSearchList != '') {
			$tSQL .= " AND (ZNE.FTZneCode COLLATE THAI_BIN LIKE  '%$tSearchList%'";
			$tSQL .= " OR ZNEL.FTZneName COLLATE THAI_BIN LIKE  '%$tSearchList%')";
		}
		
		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			
			$aList = $oQuery->result();
			$aFoundRow = $this->JSnMZNEGetPageAll($tWhereCode,$tSearchList,$nLngID);
			$nFoundRow = $aFoundRow[0]->counts;
			$nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

			$aResult = array(
					'raItems' => $aList,
					'rnAllRow' => $nFoundRow,
					'rnCurrentPage' => $paData['nPage'],
					"rnAllPage"=> $nPageAll, 
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
					"rnAllPage"=> 0,
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
	//Last Modified : -
	//Return : data
	//Return Type : Array
	function JSnMZNEGetPageAll($ptWhereCode,$ptSearchList,$ptLngID){
		
		$tSQL = "SELECT COUNT (ZNE.FTZneCode) AS counts
				
		    					FROM TCNMZone ZNE
								LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode AND ZNEL.FNLngID = $ptLngID
								WHERE 1 = 1";
		if(@$ptWhereCode != ''){
			$tSQL .= " AND (ZNE.FTAreCode = '$ptWhereCode')";
		}
		
		if ($ptSearchList != '') {
			$tSQL .= " AND (ZNE.FTZneCode LIKE '%$ptSearchList%'";
			$tSQL .= " OR ZNEL.FTZneName LIKE '%$ptSearchList%')";
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
	public function FSaMZNEAdd($paData){
		$tStaDup = $this->FSnMZNECheckduplicate($paData['FTZneCode']); //ส่งค่าไปหา duplicate
		$nStaDup = $tStaDup[0]->counts;
		
		if($nStaDup == 0){
			try{
				//Update Master
		
				$this->db->set('FNZneLevel',  	$paData['FNZneLevel']);
				$this->db->set('FTZneParent',   $paData['FTZneParent']);
				$this->db->set('FTZneChain',  	$paData['FTZneChain']);
				$this->db->set('FTAreCode',  	$paData['FTAreCode']);

				$this->db->set('FDLastUpdOn',   $paData['FDLastUpdOn']);
				$this->db->set('FTLastUpdBy',   $paData['FTLastUpdBy']);
				$this->db->where('FTZneCode',   $paData['FTZneCode']);
				$this->db->update('TCNMZone');
				if($this->db->affected_rows() > 0){
					$aStatus = array(
						'rtCode' => '1',
						'rtDesc' => 'Update Master Success',
					);
				}else{
					//Add Master
				
					$this->db->insert('TCNMZone',array(
						'FTZneCode'       => $paData['FTZneCode'],
						'FNZneLevel'      => $paData['FNZneLevel'],
						'FTZneParent'     => $paData['FTZneParent'],
						'FTZneChain'      => $paData['FTZneChain'],
						'FTAreCode'		  => $paData['FTAreCode'],

						'FDLastUpdOn'    => $paData['FDLastUpdOn'],
						'FDCreateOn'   	 => $paData['FDCreateOn'],
						'FTLastUpdBy'    => $paData['FTLastUpdBy'],
						'FTCreateBy'     => $paData['FTCreateBy'],
	
					));
					if($this->db->affected_rows() > 0){
						$aStatus = array(
							'rtCode' => '1',
							'rtDesc' => 'Add Master Success',
						);
					}else{
						$aStatus = array(
							'rtCode' => '905',
							'rtDesc' => 'Error Cannot Add/Edit Master.',
						);
					}
				}
				return $aStatus;
			}catch(Exception $Error){
				return $Error;
			}
	}
}
	
	
	//Functionality : Add Lang Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : num
	public function FSnMZNEAddLang($paData){
		try{
			//Update Master

			$this->db->set('FTZneChain',  	$paData['FTZneChain']);
			$this->db->set('FTZneCode',   $paData['FTZneCode']);
			$this->db->set('FTZneChainName',   $paData['FTZneChainName']);
			$this->db->set('FNLngID',   $paData['FNLngID']);
			$this->db->set('FTZneName',  	$paData['FTZneName']);
			$this->db->set('FTZneRmk',  	$paData['FTZneRmk']);

			$this->db->where('FTZneCode',   $paData['FTZneCode']);
			$this->db->update('TCNMZone_L');
			if($this->db->affected_rows() > 0){
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Update Master Success',
				);
			}else{
				//Add Master
			
				$this->db->insert('TCNMZone_L',array(
					'FTZneChain'       	=> $paData['FTZneChain'],
					'FTZneCode'      	=> $paData['FTZneCode'],
					'FTZneCode'      	=> $paData['FTZneCode'],
					'FTZneName'      	=> $paData['FTZneName'],
					'FNLngID'    	 	=> $paData['FNLngID'],
					'FTZneChainName'	=> $paData['FTZneChainName'],
					'FTZneRmk'		  	=> $paData['FTZneRmk'],

				));
				if($this->db->affected_rows() > 0){
					$aStatus = array(
						'rtCode' => '1',
						'rtDesc' => 'Add Master Success',
					);
				}else{
					$aStatus = array(
						'rtCode' => '905',
						'rtDesc' => 'Error Cannot Add/Edit Master.',
					);
				}
			}
			return $aStatus;
		}catch(Exception $Error){
			return $Error;
		}
		
	}
	
	
	//Functionality : Checkduplicate
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMZNECheckduplicate($ptCode){
	
		$tSQL = "SELECT COUNT(FTZneCode)AS counts
		FROM TCNMZone
		WHERE FTZneCode = '$ptCode' ";
			
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			return $oQuery->result();
		} else {
			return false;
		}
	
	}
	
	
	
	//Functionality : Update Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : response
	//Return Type : Array
	public function FSaMZNEUpdateArea($paData){
		
		$this->db->set('FTAreCode',	$paData['FTAreCode']);
		
		// $this->db->set('FDDateUpd',		$paData['FDDateUpd']);
		// $this->db->set('FTTimeUpd',		$paData['FTTimeUpd']);
		// $this->db->set('FTWhoUpd',		$paData['FTWhoUpd']);
			
		$this->db->where('FTZneCode', $paData['FTZneCode']);
		$this->db->update('TCNMZone');
			
		if($this->db->affected_rows() > 0) {
			//Success
			$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'success',
			);
		} else {
			//Ploblem
			$aStatus = array(
					'rtCode' => '905',
					'rtDesc' => 'cannot update database.',
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
	public function FSnMZNEUpdateLang($paData){
	
		$this->db->set('FTZneName', $paData['FTZneName']);
		$this->db->set('FTZneChainName', $paData['FTZneChainName']);
		$this->db->set('FTZneRmk', $paData['FTZneRmk']);
		$this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
		$this->db->Set('FTLastUpdBy',$paData['FTLastUpdBy']);
		
		$this->db->where('FNLngID', $paData['FNLngID']);
		$this->db->where('FTZneCode', $paData['FTZneCode']);
		$this->db->update('TCNMZone_L');
	
		if($this->db->affected_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	
	}
	
	
    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMZone";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }   


    //Functionality: Get data  TCNMZoneObj
    //Parameters:  Function Parameter
    //Creator: 23/01/2019 (Bell)
    //Last Modified :
    //Return : 
	//Return Type: Array
	public function FSaMZNEGetdataZneobj(){
		$tSQL = "SELECT DISTINCT 
					FTZneRefID AS rtSelected
				 FROM TCNMZoneObj
				 WHERE 1=1";

		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$tData = $oQuery->result_array();
		}else{
			$tData = '';
		}
		return $tData;
	}


	
    //Functionality : Update Zone
    //Parameters : function parameters
    //Creator : 14/06/2016 saharat(Golf)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMZNEAddUpdateMaster($paData){
        try{
			//Add Master
			$this->db->insert('TCNMZoneObj',array(
				'FTZneTable'      => $paData['FTZneTable'],
				'FTZneKey'        => $paData['FTZneKey'],
				'FTZneChain'      => $paData['FTZneChain'],
				'FTZneRefCode'    => $paData['FTZneRefCode'],

				'FDLastUpdOn'   => $paData['FDLastUpdOn'],
				'FDCreateOn'    => $paData['FDCreateOn'],
				'FTLastUpdBy'   => $paData['FTLastUpdBy'],
				'FTCreateBy'    => $paData['FTCreateBy']
			));

			if($this->db->affected_rows() > 0){
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Add Master Success',
				);
			}else{
				$aStatus = array(
					'rtCode' => '905',
					'rtDesc' => 'Error Cannot Add/Edit Master.',
				);
			}
		return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
	}
	
	//Functionality : list Branch
	//Parameters : function parameters
	//Creator : 09/03/2018 Krit(Copter)
	//Last Modified : -
	//Return : data
	//Return Type : Array
	public function FSnMZNEObjList($paData){

		$aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$nLngID   = $paData['FNLngID'];
		$nZenCode = $paData['nZenCode'];
		$tSQL = "SELECT c.* FROM(
					SELECT  ROW_NUMBER() OVER(ORDER BY rtZneCode ASC) AS rtRowID,* FROM
						(SELECT DISTINCT
							ZNE.FTZneCode        AS rtZneCode,
							ZNE.FNZneLevel     	 AS rnZneLevel,
							ZNE.FTZneParent   	 AS rtZneParent,
							ZNE.FTZneChain  	 AS rtZneChain,
							ZNE.FTAreCode   	 AS rtAreCode,
							
							ZNEL.FTZneName   	 AS rtZneName,
							ZNEL.FTZneChainName  AS rtZneChainName,
							ZNEL.FTZneRmk   	 AS rtZneRemark,
							ZNEO.FTZneTable 	 AS rtZneTable,
							ZNEO.FTZneKey        AS rtZneKey,
							ZNEO.FTZneRefCode    AS rtZneRefCode,
							ZNEO.FNZneID         AS rtZneID,
							CASE 
								WHEN ZNEO.FTZneTable = 'TCNMUser'   THEN USRL.FTUsrName
								WHEN ZNEO.FTZneTable = 'TCNMBranch' THEN BCHL.FTBchName 
								WHEN ZNEO.FTZneTable = 'TCNMSpn'    THEN SPNL.FTSpnName 
								WHEN ZNEO.FTZneTable = 'TCNMShop'   THEN SHPL.FTShpName 
								WHEN ZNEO.FTZneTable = 'TCNMPos'    THEN PLN.FTPosComName 
								ELSE NULL 
							END 
							AS rtZneRefName    
        FROM TCNMZone ZNE
      	LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode AND ZNEL.FNLngID = $nLngID
      	LEFT JOIN TCNMZoneObj ZNEO ON ZNEL.FTZneChain = ZNEO.FTZneChain
   		LEFT JOIN TCNMUser_L USRL ON USRL.FTUsrCode   = CASE WHEN ZNEO.FTZneTable = 'TCNMUser'   THEN ZNEO.FTZneRefCode ELSE NULL END AND USRL.FNLngID = $nLngID
   		LEFT JOIN TCNMBranch_L BCHL ON BCHL.FTBchCode = CASE WHEN ZNEO.FTZneTable = 'TCNMBranch' THEN ZNEO.FTZneRefCode ELSE NULL END AND BCHL.FNLngID = $nLngID
		LEFT JOIN TCNMSpn_L SPNL ON SPNL.FTSpnCode    = CASE WHEN ZNEO.FTZneTable = 'TCNMSpn'    THEN ZNEO.FTZneRefCode ELSE NULL END AND SPNL.FNLngID = $nLngID
		LEFT JOIN TCNMShop_L SHPL ON SHPL.FTShpCode   = CASE WHEN ZNEO.FTZneTable = 'TCNMShop'   THEN ZNEO.FTZneRefCode ELSE NULL END AND SHPL.FNLngID = $nLngID
		LEFT JOIN TCNMPosLastNo PLN ON PLN.FTPosCode  = CASE WHEN ZNEO.FTZneTable = 'TCNMPos'    THEN ZNEO.FTZneRefCode ELSE NULL END 
      	WHERE 1 = 1  AND ZNEO.FTZneChain = '$nZenCode' ";
		
		@$tWhereCode = $paData['nZenCode'];
		$tSearchList = $paData['tSearchAll'];
		if ($tSearchList != '') {
			$tSQL .= " AND (ZNE.FTZneCode LIKE '%$tSearchList%'";
			$tSQL .= " OR ZNEL.FTZneName LIKE '%$tSearchList%')";
		}
		
		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
			
			$aList = $oQuery->result();
			$aFoundRow = $this->JSnMZNEReferGetPageAll($tWhereCode,$tSearchList,$nLngID);
			$nFoundRow = $aFoundRow[0]->counts;
			$nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

			$aResult = array(
					'raItems' => $aList,
					'rnAllRow' => $nFoundRow,
					'rnCurrentPage' => $paData['nPage'],
					"rnAllPage"=> $nPageAll, 
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
					"rnAllPage"=> 0,
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
	//Last Modified : -
	//Return : data
	//Return Type : Array
	function JSnMZNEReferGetPageAll($ptWhereCode,$ptSearchList,$ptLngID){
		
		$tSQL = "SELECT COUNT (ZNE.FTZneCode) AS counts
				
		    					FROM TCNMZone ZNE
								LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneCode = ZNEL.FTZneCode AND ZNEL.FNLngID = $ptLngID
								LEFT JOIN TCNMZoneObj ZNEO ON ZNEL.FTZneChain = ZNEO.FTZneChain 
								WHERE 1 = 1";
		if(@$ptWhereCode != ''){
			$tSQL .= " AND (ZNEO.FTZneChain = '$ptWhereCode')";
		}
		
		if ($ptSearchList != '') {
			$tSQL .= " AND (ZNE.FTZneCode LIKE '%$ptSearchList%'";
			$tSQL .= " OR ZNEL.FTZneName LIKE '%$ptSearchList%')";
		}
		
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0) {
		
			return $oQuery->result();
				
		} else {
			//No Data
			return false;
		}
	}


	//Functionality : Delete ZoneObj
    //Parameters : function parameters
    //Creator : 18/06/2019 Saharat(Golf)
    //Return : text
    //Return Type : text
    public function FSnMZENOJBDel($ptZneRefCode) {
		$tZneRefCode =  $ptZneRefCode['FTZneRefCode'];
		$tZneTable   =  $ptZneRefCode['FTZneTable'];
		$tZneChain   =  $ptZneRefCode['tZneChain'];
        $tSQL = "SELECT COUNT(FTZneRefCode) AS count
        FROM TCNMZoneObj
        WHERE FTZneChain = '$tZneChain' ";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count != 0) {
			$this->db->where('FNZneID', $tZneRefCode);
			$this->db->where('FTZneTable', $tZneTable);
			$this->db->delete('TCNMZoneObj');
			$aStatus = array(
				'rtCode' => '1',
				'rtDesc' => 'Add Master Success',
			);
            return $aStatus;
        } else {
			$aStatus = array(
				'rtCode' => '905',
				'rtDesc' => 'Error Cannot Add/Edit Master.',
			);
			return $aStatus;
        }

	}
	
	//Functionality : get all row  ZoneObj
    //Parameters : -
    //Creator : 18/06/2019 Saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMZENOGetAllNumRow($ptZneRefCode){
		$tZneRefCode =  $ptZneRefCode['tZneChain'];
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMZoneObj WHERE FTZneChain = '$tZneRefCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

		
    //Functionality : Update ZoneRefer
    //Parameters : function parameters
    //Creator : 14/06/2016 saharat(Golf)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMZNEReferUpdateMaster($paData){
		$tZneTable   = $paData['FTZneTable'];
		$tZneRefCode = $paData['FTZneRefCode'];
		$tZneKey = $paData['FTZneKey'];
	try{
		if($tZneTable != '' && $tZneRefCode == ''){
			$this->db->set('FTZneKey', $paData['FTZneKey']);
			$this->db->set('FDLastUpdOn' ,  $paData['FDLastUpdOn']);
			$this->db->set('FTLastUpdBy',  $paData['FTLastUpdBy']);
			$this->db->where('FNZneID', $paData['FNZneID']);
			$this->db->update('TCNMZoneObj');
		}
		if($tZneTable == '' && $tZneRefCode == ''){
			$this->db->set('FTZneKey', $paData['FTZneKey']);
			$this->db->set('FDLastUpdOn' ,  $paData['FDLastUpdOn']);
			$this->db->set('FTLastUpdBy',  $paData['FTLastUpdBy']);
			$this->db->where('FNZneID', $paData['FNZneID']);
			$this->db->update('TCNMZoneObj');
		}		

		if($tZneTable != '' && $tZneRefCode != '' && $tZneKey != '' ){
			$this->db->set('FTZneTable' , $paData['FTZneTable']);
			$this->db->set('FTZneKey', $paData['FTZneKey']);
			$this->db->set('FTZneRefCode' ,  $paData['FTZneRefCode']);
			$this->db->set('FDLastUpdOn' ,  $paData['FDLastUpdOn']);
			$this->db->set('FTLastUpdBy',  $paData['FTLastUpdBy']);
			$this->db->where('FNZneID', $paData['FNZneID']);
			$this->db->update('TCNMZoneObj');
		}

        //Update Master
        if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
		}else{
				$aStatus = array(
					'rtCode' => '905',
					'rtDesc' => 'Error Cannot Update Master.',
				);
			}
		return $aStatus;
        }catch(Exception $Error){
		return $Error;
        }
	}

	//Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 10/06/2016 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMZENCheckDuplicate($ptCpnCode){
        $tSQL = "SELECT COUNT(FTZneCode)AS counts
                 FROM TCNMZone
                 WHERE FTZneCode = '$ptCpnCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
	

}
