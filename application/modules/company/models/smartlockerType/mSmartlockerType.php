<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSmartlockerType extends MX_Controller {
    
    //List
    public function FSaMSmartLockerTypeDataList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tShpCode       = $paData['tShpCode'];
            $tBchCode       = $paData['tBchCode'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FTBchCode ASC) AS rtRowID,* FROM
                                    ( SELECT 	
                                    SMT.FTBchCode,
                                    SMT.FTShpCode,
                                    SMT.FTShtType,
                                    SMTL.FTShtName,
                                    SMTL.FTShtRemark
                                FROM [TRTMShopType] SMT
                                LEFT JOIN [TRTMShopType_L]  SMTL ON SMT.FTShpCode = SMTL.FTShpCode AND SMT.FTBchCode = SMTL.FTBchCode   AND SMTL.FNLngID = $tFNLngID  
                                WHERE 1=1 AND SMT.FTShpCode = '$tShpCode' AND SMT.FTBchCode='$tBchCode' ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSaMSmartLockerTypeGetPageAll($tSearchList,$paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'tSQL'          => $tSQL
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found'
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Count 
    public function FSaMSmartLockerTypeGetPageAll($ptSearchList,$paData){
        try{
            $tShpCode       = $paData['tShpCode'];
            $tBchCode       = $paData['tBchCode'];
            $tSQL = "SELECT COUNT (SMT.FTBchCode) AS counts
                    FROM [TRTMShopType] SMT
                    WHERE 1=1 AND SMT.FTShpCode = '$tShpCode' AND SMT.FTBchCode='$tBchCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Get Shop Data 
    public function FSnMSmartLockerTypeGetNameShop($ptData){
        $FTShpCode = $ptData['FTShpCode'];
        $FTBchCode = $ptData['FTBchCode'];
        $tFNLngID  = $ptData['nLangEdit'];

                $tSQL = "   SELECT 	
                SHPL.FTBchCode,
                SHPL.FTShpName

                FROM [TCNMShop_L] SHPL
                WHERE 1=1 
                AND SHPL.FTBchCode = $FTBchCode 
                AND SHPL.FTShpCode = $FTShpCode ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
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


    //Get Data Edit
    public function FSnMSmartLockerTypeEventGetData($ptData){

        $FTShpCode = $ptData['FTShpCode'];
        $FTBchCode = $ptData['FTBchCode'];
        $tFNLngID  = $ptData['nLangEdit'];
        $tSQL = "   SELECT 	
                    SMT.FTBchCode,
                    SMT.FTShpCode,
                    SMT.FTShtType,
                    SHPL.FTShpName,
                    SMTL.FTShtName,
                    SMTL.FTShtRemark
                    FROM [TRTMShopType] SMT
                    LEFT JOIN [TRTMShopType_L]  SMTL ON SMT.FTShpCode = SMTL.FTShpCode AND  SMT.FTBchCode  = SMTL.FTBchCode   AND SMTL.FNLngID = $tFNLngID 
                    LEFT JOIN [TCNMShop_L]      SHPL ON SMT.FTShpCode = SHPL.FTShpCode AND SMT.FTBchCode = SHPL.FTBchCode  AND  SHPL.FNLngID = $tFNLngID 
                    WHERE SMT.FTBchCode = '$FTBchCode' AND SMT.FTShpCode = $FTShpCode ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
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

    //Check BCH ห้ามซ้ำ
    public function FSnMSmartLockerCheckBch($ptData){
        $FTBchCode	=  $ptData['FTBchCode'];
        $FTShpCode	=  $ptData['FTShpCode'];
        $tSQL = "   SELECT 	
                    SMT.FTBchCode
                    FROM [TRTMShopType] SMT
                    WHERE SMT.FTBchCode = '$FTBchCode' AND SMT.FTShpCode = $FTShpCode ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }
    
    //Insert 
    public function FSnMSmartLockerTypeAddData($ptData){
		$nShpcode	=  $ptData['FTShpCode'];
		$nBrhcode   =  $ptData['FTBchCode'];
		$tShptType  =  $ptData['FTShtType'];
        $tShptName  =  $ptData['FTShtName'];
        $nLangID    =  $ptData['FNLngID'];
		$tShptRemark=  $ptData['FTShtRemark'];
        $FDCreateOn	=  date('Y-m-d h:i:s');
        $tLastUpdOn =  date('Y-m-d h:i:s');
 		$FTCreateBy	=  $this->session->userdata('tSesUsername');

		$tSQL ="INSERT INTO TRTMShopType (FTBchCode, FTShpCode, FTShtType, FDCreateOn, FTCreateBy, FDLastUpdOn)
			VALUES ('$nBrhcode', '$nShpcode', '$tShptType', '$FDCreateOn', '$FTCreateBy', '$tLastUpdOn')";
        $oQuery = $this->db->query($tSQL);
        
		$tSQLL ="INSERT INTO TRTMShopType_L (FTBchCode, FTShpCode, FTShtType, FNLngID, FTShtName, FTShtRemark )
			VALUES ('$nBrhcode', '$nShpcode', '$tShptType', '$nLangID', '$tShptName', '$tShptRemark')";
        $oQuery = $this->db->query($tSQLL);
        
		if ($oQuery > 0) {
			return true;
		} else {
			return false;
		}	
    }

    //Update
    public function FSnMSmartLockerTypeEditData($paData){
        try{
			$FDLastUpdOn	=  date('Y-m-d');
            $FTLastUpdBy	=  $this->session->userdata('tSesUsername');
        
            //ตาราง main
			$this->db->set('FTShtType', $paData['FTShtType']);
			$this->db->set('FDLastUpdOn', $FDLastUpdOn);
            $this->db->set('FTLastUpdBy', $FTLastUpdBy);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->update('TRTMShopType');
            
            //ตาราง L 
            $this->db->set('FTShtName', $paData['FTShtName']);
            $this->db->set('FTShtType', $paData['FTShtType']);
            $this->db->set('FTShtRemark', $paData['FTShtRemark']);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
			$this->db->update('TRTMShopType_L');

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
    
    //Delete
    public function FSnMSmartLockerTypeEventDelete($ptData){
        $this->db->where_in('FTBchCode', $ptData['FTBchCode']);
        $this->db->where_in('FTShpCode', $ptData['FTShpCode']);
        $this->db->where_in('FTShtType', $ptData['FTShtType']);
        $this->db->delete('TRTMShopType');
        
        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTShpCode', $ptData['FTShpCode']);
        $this->db->where_in('FTShtType', $ptData['FTShtType']);
        $this->db->delete('TRTMShopType_L');
        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

}