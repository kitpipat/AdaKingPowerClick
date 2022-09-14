<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAdMessage extends CI_Model {

    /**
     * Functionality : Search Ad Message By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMADVSearchByID($ptAPIReq, $ptMethodReq, $paData){
        
        $tDstCode = $paData['FTAdvCode'];
        $nLngID = $paData['FNLngID'];
        
        // Ad message query
        $tMSQL =   "SELECT
                        ADV.FTAdvCode AS rtAdvCode,
                        ADV.FTAdvType AS rtAdvType,
                        ADV.FNAdvSeqNo AS rtAdvSeqNo,
                        ADV.FTAdvStaUse AS rtAdvStaUse,
                        ADV.FDAdvStart AS rtAdvStart,
                        ADV.FDAdvStop AS rtAdvStop,
                        ADVL.FTAdvName AS rtAdvName,
                        ADVL.FTAdvMsg AS rtAdvMsg,
                        ADVL.FTAdvRmk AS rtAdvRmk,
                        ADV.FTAgnCode AS rtAgnCode,
                        AGNL.FTAgnName   AS rtAgnName
                    FROM [TCNMAdMsg] ADV
                    LEFT JOIN [TCNMAdMsg_L] ADVL ON ADVL.FTAdvCode = ADV.FTAdvCode AND ADVL.FNLngID = $nLngID
                    LEFT JOIN [TCNMAgency_L] AGNL ON ADV.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    WHERE 1=1 
                    AND ADV.FTAdvCode = '$tDstCode'";
        $oMQuery = $this->db->query($tMSQL);

        // Head of receipt and End of receipt query
        $tMediaSQL =   "SELECT
                        MDO.*
                    FROM [TCNMMediaObj] MDO
                    WHERE 1=1 
                    AND MDO.FTMedRefID = '$tDstCode' ORDER BY MDO.FNMedSeq";
        $oMediaQuery = $this->db->query($tMediaSQL);

        $tImageSQL =   "SELECT
                            IMG.*
                        FROM TCNMImgObj IMG
                        WHERE 1=1 
                        AND IMG.FTImgRefID = '$tDstCode'
                        AND IMG.FTImgTable = 'TCNMAdMsg'
                        ORDER BY IMG.FNImgSeq";
        $oImageQuery = $this->db->query($tImageSQL);
        
        if ($oMQuery->num_rows() > 0){ // Have ad
            
            $oMDetail = $oMQuery->result();
            $oMediaDetail = $oMediaQuery->result();
            $oImageDetail = $oImageQuery->result();
            
            // Found
            $aResult = array(
                'raItems'       => $oMDetail[0],
                'raMediaItems'  => $oMediaDetail,
                'raImageItems'  => $oImageDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
            
        }else{
            // Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    /**
     * Functionality : List ad message
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMADVList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen     = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID      = $paData['FNLngID'];
        $tSesAgnCode = $paData['tSesAgnCode'];
        
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtAdvCode DESC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                                ADV.FTAdvCode       AS rtAdvCode,
                                ADVL.FTAdvName      AS rtAdvName,
                                ADVL.FTAdvMsg       AS rtAdvMsg,
                                ADV.FTAdvType       AS rtAdvType,
                                ADV.FDAdvStart      AS rdAdvStart,
                                ADV.FDAdvStop       AS rdAdvStop,
                                ADV.FTAdvStaUse     AS rtAdvStaUse,
                                ADV.FDCreateOn,
                                ADV.FTAgnCode       AS rtAgnCode,
                                AGNL.FTAgnName       AS rtAgnName
                            FROM [TCNMAdMsg] ADV
                            LEFT JOIN [TCNMAdMsg_L] ADVL ON ADVL.FTAdvCode = ADV.FTAdvCode AND ADVL.FNLngID = $nLngID
                            LEFT JOIN [TCNMAgency_L] AGNL ON ADV.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1=1";

        if($tSesAgnCode != ''){
          $tSQL .= "AND ADV.FTAgnCode = $tSesAgnCode";     
        }
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (ADV.FTAdvCode LIKE '%$tSearchList%'";
            $tSQL .= " OR ADVL.FTAdvName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMADVGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID, $tSesAgnCode);
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
    
    /**
     * Functionality : All Page Of Slip Message
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMADVGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID, $tSesAgnCode){
        $tSQL = "SELECT COUNT (ADV.FTAdvCode) AS counts
                FROM [TCNMAdMsg] ADV
                LEFT JOIN [TCNMAdMsg_L] ADVL ON ADVL.FTAdvCode = ADV.FTAdvCode AND ADVL.FNLngID = $ptLngID
                LEFT JOIN [TCNMAgency_L] AGNL ON ADV.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $ptLngID
                WHERE 1=1";

        if($tSesAgnCode != ''){
            $tSQL .= "AND ADV.FTAgnCode = $tSesAgnCode";     
        }
        
        if($ptSearchList != ''){
            $tSQL .= " AND (ADV.FTAdvCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR ADVL.FTAdvName  LIKE '%$ptSearchList%')";
        }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptDstCode
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMADVCheckDuplicate($ptAdvCode){
        $tSQL = "SELECT COUNT(FTAdvCode) AS counts
                 FROM TCNMAdMsg
                 WHERE FTAdvCode = '$ptAdvCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate by Media path
     * Parameters : $ptMediaPath
     * Creator : 13/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMADVCheckMediaFileNameDuplicate($paData){
        $tPath = $paData['tFileName'];
        $tAdvCode = $paData['tAdvCode'];
        $tSQL = "SELECT COUNT(FTMedPath) AS counts
                 FROM TCNMMediaObj
                 WHERE FTMedRefID = '$tAdvCode' AND FTMedPath = '$tPath' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
    
    /**
     * Functionality : Update Ad Message
     * Parameters : $paData is data for update
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMADVAddUpdateMaster($paData){
        try{
            // Update Master
            // $this->db->set('FNAdvSeqNo', "(SELECT TOP 1 (FNAdvSeqNo + 1) FROM TCNMAdMsg WHERE FNAdvSeqNo IS NOT NULL ORDER BY FNAdvSeqNo DESC)", FALSE);
            $this->db->set('FTAdvStaUse', $paData['FTAdvStaUse']);
            $this->db->set('FDAdvStart' , $paData['FDAdvStart']);
            $this->db->set('FDAdvStop'  , $paData['FDAdvStop']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTAdvCode', $paData['FTAdvCode']);
            $this->db->update('TCNMAdMsg');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->set('FNAdvSeqNo', "(SELECT CASE WHEN (SELECT TOP 1 (FNAdvSeqNo + 1) FROM TCNMAdMsg WHERE FNAdvSeqNo IS NOT NULL ORDER BY FNAdvSeqNo DESC) IS NULL THEN 1 ELSE (SELECT TOP 1 (FNAdvSeqNo + 1) as MM FROM TCNMAdMsg WHERE FNAdvSeqNo IS NOT NULL ORDER BY FNAdvSeqNo DESC) END AS SeqNo )", FALSE);
                $this->db->set('FTAdvCode', $paData['FTAdvCode']);
                $this->db->set('FTAdvType', $paData['FTAdvType']);
                $this->db->set('FTAdvStaUse', $paData['FTAdvStaUse']);
                $this->db->set('FDAdvStart', $paData['FDAdvStart']);
                $this->db->set('FDAdvStop', $paData['FDAdvStop']);
                $this->db->set('FDCreateOn', $paData['FDCreateOn']);
                $this->db->set('FTCreateBy', $paData['FTCreateBy']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTAgnCode', $paData['FTAgnCode']);
                $this->db->insert('TCNMAdMsg');
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

    /**
     * Functionality : Update Lang Ad Message
     * Parameters : $paData is data for update
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMADVAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTAdvName', $paData['FTAdvName']);
            $this->db->set('FTAdvMsg', $paData['FTAdvMsg']);
            $this->db->set('FTAdvRmk', $paData['FTAdvRmk']);
            $this->db->where('FTAdvCode', $paData['FTAdvCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->update('TCNMAdMsg_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Lang
                $this->db->insert('TCNMAdMsg_L', array(
                    'FTAdvCode' => $paData['FTAdvCode'],
                    'FTAdvName' => $paData['FTAdvName'],
                    'FTAdvMsg' => $paData['FTAdvMsg'],
                    'FTAdvRmk' => $paData['FTAdvRmk'],
                    'FNLngID'   => $paData['FNLngID'],
                ));
            }
            // Set Response status
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
            
            // Response status
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Add Media
     * Parameters : $paData is data for insert
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMADVAddMedia($paData){
        try{
            // Add Media
            $this->db->insert('TCNMMediaObj',array(
                'FTMedRefID'    => $paData['FTAdvCode'],
                'FNMedSeq'      => $paData['FNMedSeq'],
                'FNMedType'     => $paData['FNMedType'],
                'FTMedFileType' => $paData['FTMedFileType'],
                'FTMedPath'     => $paData['FTMedPath'],
                'FTMedTable'    => $paData['FTMedTable'],
                'FTMedKey'      => $paData['FTMedKey'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTCreateBy'    => $paData['FTCreateBy'],
                'FDCreateOn'    => $paData['FDCreateOn'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Media Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Media.',
                );
            }
            
            // Response status
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Update Lang Slip Message
     * Parameters : $paData is data for update
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMADVUpdateMedia($paData){
        try{
            // Update Lang
            $this->db->set('FNMedSeq', $paData['FNMedSeq']);
            // $this->db->set('FDDateUpd', $paData['FDDateUpd']);
            // $this->db->set('FTTimeUpd', $paData['FTTimeUpd']);
            // $this->db->set('FTWhoUpd', $paData['FTWhoUpd']);
            $this->db->where('FNMedID', $paData['FNMedID']);
            $this->db->update('TCNMMediaObj');
            // Set Response status
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Media Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update Media.',
                );
            }
            
            // Response status
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Search Media By AdCode
     * Parameters : $paData
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMADVSearchMediaByAdCode($paData){
        
        $tDstCode   = $paData['FTAdvCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tMediaSQL =   "SELECT
                        MDO.*
                    FROM [TCNMMediaObj] MDO
                    WHERE 1=1 
                    AND MDO.FTMedRefID = '$tDstCode' ORDER BY MDO.FNMedSeq";
        $oMediaQuery = $this->db->query($tMediaSQL);
        
        if ($oMediaQuery->num_rows() > 0){ // Have ad
            
            $oMediaDetail = $oMediaQuery->result();
            
            // Found
            $aResult = array(
                'raItems'   => $oMediaDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
            
        }else{
            // Not Found
            $aResult = array(
                'raItems'   => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    /**
     * Functionality : Search Media By ID
     * Parameters : $nMedID, $paData
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMADVSearchMediaByID($nMedID, $paData){
        
        $tDstCode = $paData['FTAdvCode'];
        $nLngID = $paData['FNLngID'];
        
        $tMediaSQL =   "SELECT
                        MDO.*
                    FROM [TCNMMediaObj] MDO
                    WHERE 1=1 
                    AND MDO.FNMedID = $nMedID
                    AND MDO.FTMedRefID = '$tDstCode' ORDER BY MDO.FNMedSeq";
        $oMediaQuery = $this->db->query($tMediaSQL);
        
        if ($oMediaQuery->num_rows() > 0){ // Have ad
            
            $oMediaDetail = $oMediaQuery->result();
            
            // Found
            $aResult = array(
                'raItems'   => $oMediaDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
            
        }else{
            // Not Found
            $aResult = array(
                'raItems'   => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    /**
     * Functionality : Search Media By Not In
     * Parameters : $paIDs, $paData
     * Creator : 14/09/2018 piya
     * Last Modified : -
     * Return : Media record
     * Return Type : array
     */
    function FSaMADVSearchMediaNotIn($paIDs, $paData){
        $this->db->select('*');
        $this->db->from('TCNMMediaObj');
        $this->db->where('FTMedRefID', $paData['FTAdvCode']);
        $this->db->where_not_in('FNMedID', $paIDs);
        return $this->db->get()->result();
    }
    
    /**
     * Functionality : Search Media By In
     * Parameters : $paIDs, $paData
     * Creator : 14/09/2018 piya
     * Last Modified : -
     * Return : Media record
     * Return Type : array
     */
    function FSaMADVSearchMediaIn($paIDs, $paData){
        $this->db->select('*');
        $this->db->from('TCNMMediaObj');
        $this->db->where('FTMedRefID', $paData['FTAdvCode']);
        $this->db->where_in('FNMedID', $paIDs);
        return $this->db->get()->result();
    }
    
    /**
     * Functionality : Delete Ad Message
     * Parameters : $paData
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMADVDelMaster($paData){
        $this->db->where_in('FTAdvCode', $paData['FTAdvCode']);
        $this->db->delete('TCNMAdMsg');
        
        $this->db->where_in('FTAdvCode', $paData['FTAdvCode']);
        $this->db->delete('TCNMAdMsg_L');

        //ถ้าลบให้เรียง SeqNo ใหม่ Cr.Napat(Jame) 2019-09-17
        $tSQL = "UPDATE TCNMAdMsg WITH(ROWLOCK)
                    SET FNAdvSeqNo = x.NewSeq 
                FROM TCNMAdMsg DT 
                INNER JOIN (
                SELECT 
                    ROW_NUMBER() OVER (ORDER BY FNAdvSeqNo) AS NewSeq,
                    FNAdvSeqNo AS FNAdvSeqNo_x
                FROM TCNMAdMsg AS y
                ) x
                ON DT.FNAdvSeqNo = x.FNAdvSeqNo_x";
        $this->db->query($tSQL);
        
        if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
        
        // return $aStatus = array(
        //     'rtCode' => '1',
        //     'rtDesc' => 'success',
        // );
    }
    
    /**
     * Functionality : Delete Media of Ad message code
     * Parameters : $paData
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMADVDelMedia($paData){
        // $this->db->where_in('FTMedRefID', $paData['FTAdvCode']);
        $this->db->where_in('FTMedTable', $paData['FTMedTable']);
        $this->db->delete('TCNMMediaObj');
        
        /*if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;*/
        
        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }
    
    /**
     * Functionality : Delete Media of Ad message code
     * Parameters : $pnID, $paData
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMADVDelMediaByID($pnID, $paData){
        
        $this->db->where('FTMedRefID', $paData['FTAdvCode']);
        $this->db->where('FNMedID', $pnID);
        $this->db->delete('TCNMMediaObj');
        
        /*if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;*/
        
        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }
    
    /**
     * Functionality : Delete Media of Ad message code
     * Parameters : $paData
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMADVDelMediaNotIn($paIDs, $paData){
        
        $this->db->where('FTMedRefID', $paData['FTAdvCode']);
        $this->db->where_not_in('FNMedID', $paIDs);
        $this->db->delete('TCNMMediaObj');
        
        /*if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;*/
        
        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }
       
}
