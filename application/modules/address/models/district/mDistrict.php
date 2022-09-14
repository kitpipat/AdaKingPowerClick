<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mDistrict extends CI_Model {
	
	//Functionality : Get District PostCode
	//Parameters : function parameters
	//Creator : 23/05/2018 Krit(Copter)
	//Return : data
	//Return Type : Array
	public function FSnMDSTGetPostCode($ptDstCode){
		
		$tSQL       = "SELECT   DST.FTDstPost  AS rtDstPost
								FROM [TCNMDistrict] DST
					   WHERE 1=1 ";
		
		if(@$ptDstCode != ""){
			$tSQL .= "AND DST.FTDstCode = $ptDstCode ";
		}
		
		$oQuery = $this->db->query($tSQL);
		if ($oQuery->num_rows() > 0){
			$oDetail = $oQuery->result();
			$aResult = array(
					'raItems'   => $oDetail[0],
					'rtCode'    => '1',
					'rtDesc'    => 'success',
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

    //Functionality : Search District By ID
    //Parameters : function parameters
    //Creator : 15/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMDSTSearchByID($ptAPIReq,$ptMethodReq,$paData){
        $tDstCode   = $paData['FTDstCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            DST.FTDstCode   AS rtDstCode,
                            DSTL.FTDstName  AS rtDstName,
                            DST.FTDstPost   AS rtDstPost,
                            PVNL.FTPvnCode  AS rtPvnCode,
                            PVNL.FTPvnName  AS rtPvnName
                       FROM [TCNMDistrict] DST
                       LEFT JOIN [TCNMDistrict_L]  DSTL ON DST.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                       LEFT JOIN [TCNMProvince_L]  PVNL ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                       WHERE 1=1 ";
        if($tDstCode!= ""){
            $tSQL .= "AND DST.FTDstCode = '$tDstCode'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
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
    
    //Functionality : list District
    //Parameters : function parameters
    //Creator :  15/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMDSTList($ptAPIReq,$ptMethodReq,$paData){
    	
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY rtDstCode ASC) AS rtRowID,* FROM
                                (SELECT DISTINCT
                                    DST.FTDstCode   AS rtDstCode,
                                    DSTL.FTDstName  AS rtDstName,
                                    DST.FTDstPost   AS rtDstPost,
                                    PVNL.FTPvnCode  AS rtPvnCode,
                                    PVNL.FTPvnName  AS rtPvnName
                                FROM [TCNMDistrict] DST
                                LEFT JOIN [TCNMDistrict_L]  DSTL ON DST.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                                LEFT JOIN [TCNMProvince_L]  PVNL ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                                WHERE 1=1 ";
        
        @$tWhereCode = $paData['tWhereCode'];
        if(@$tWhereCode != ''){
        	$tSQL .= " AND (DST.FTPvnCode = '$tWhereCode')";
        }
        
        $tSearchList = $paData['tSearchAll'];
        if($tSearchList != ''){
            $tSQL .= " AND (DST.FTDstCode LIKE '%$tSearchList%'";
            $tSQL .= " OR DSTL.FTDstName  LIKE '%$tSearchList%'";
            $tSQL .= " OR PVNL.FTPvnName  LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMDSTGetPageAll($tWhereCode,$tSearchList,$nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    //Functionality : All Page Of District
    //Parameters : function parameters
    //Creator :  15/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMDSTGetPageAll($ptWhereCode,$ptSearchList,$ptLngID){
        $tSQL = "SELECT COUNT (DST.FTDstCode) AS counts
                 FROM [TCNMDistrict] DST
                 LEFT JOIN [TCNMDistrict_L]  DSTL ON DST.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $ptLngID
                 LEFT JOIN [TCNMProvince_L]  PVNL ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if(@$ptWhereCode != ''){
        	$tSQL .= " AND (DST.FTPvnCode = '$ptWhereCode')";
        }
        
        if($ptSearchList != ''){
            $tSQL .= " AND (DST.FTDstCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR DSTL.FTDstName  LIKE '%$ptSearchList%'";
            $tSQL .= " OR PVNL.FTPvnName  LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }
    
    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMDSTCheckDuplicate($ptDstCode){
        $tSQL = "SELECT COUNT(FTDstCode)AS counts
                 FROM TCNMDistrict
                 WHERE FTDstCode = '$ptDstCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
    
    //Functionality : Update District
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMDSTAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTDstPost' , $paData['FTDstPost']);
            $this->db->set('FTPvnCode' , $paData['FTPvnCode']);

            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

            $this->db->where('FTDstCode', $paData['FTDstCode']);
            $this->db->update('TCNMDistrict');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TCNMDistrict',array(
                    'FTDstCode'     => $paData['FTDstCode'],
                    'FTDstPost'     => $paData['FTDstPost'],
                    'FTPvnCode'     => $paData['FTPvnCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
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
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    //Functionality : Update Lang District
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSaMDSTAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTDstName', $paData['FTDstName']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTDstCode', $paData['FTDstCode']);
            $this->db->update('TCNMDistrict_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TCNMDistrict_L',array(
                    'FTDstCode' => $paData['FTDstCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTDstName' => $paData['FTDstName']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    //Functionality : Delete District
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Return : response
    //Return Type : array
    public function FSnMDSTDel($paData){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTDstCode', $paData['FTDstCode']);
            $this->db->delete('TCNMDistrict');
            
            $this->db->where_in('FTDstCode', $paData['FTDstCode']);
            $this->db->delete('TCNMDistrict_L');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Delete Unsuccess.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }

    }
    

  //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMDistrict";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }  


}