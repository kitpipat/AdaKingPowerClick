<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerType extends CI_Model {

    /**
     * Functionality : Search Customer Type By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCstTypeSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCstTypeCode   = $paData['FTCstTypeCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            CstType.FTCtyCode   AS rtCstTypeCode,
                            CstTypeL.FTCtyName  AS rtCstTypeName,
                            CstTypeL.FTCtyRmk   AS rtCstTypeRmk,
                            CstType.FTAgnCode   AS rtAgnCode,
                            AGNL.FTAgnName  AS rtAgnName
                       FROM [TCNMCstType] CstType
                       LEFT JOIN [TCNMCstType_L]  CstTypeL ON CstType.FTCtyCode = CstTypeL.FTCtyCode AND CstTypeL.FNLngID = $nLngID
                       LEFT JOIN TCNMAgency_L AGNL ON  CstType.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                       WHERE 1=1 ";
        if($tCstTypeCode!= ""){
            $tSQL .= "AND CstType.FTCtyCode = '$tCstTypeCode'";
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
    
    /**
     * Functionality : List Customer Group
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCstTypeList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];

        $tSesAgnCode = $paData['tSesAgnCode'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtCstTypeCode DESC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                                CstType.FTCtyCode   AS rtCstTypeCode,
                                CstTypeL.FTCtyName  AS rtCstTypeName,
                                CstType.FDCreateOn
                        FROM [TCNMCstType] CstType
                        LEFT JOIN [TCNMCstType_L] CstTypeL ON CstTypeL.FTCtyCode = CstType.FTCtyCode AND CstTypeL.FNLngID = $nLngID
                        WHERE 1=1";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND CstType.FTCtyCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR CstTypeL.FTCtyName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            // $tSQL .= " OR CstTypeL.FTCtyName LIKE '%$tSearchList%')";
            
        }

        if ($tSesAgnCode != '') {
            $tSQL .= " AND CstType.FTAgnCode = $tSesAgnCode";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        // echo $tSQL; exit();
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCstTypeGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID,$tSesAgnCode);
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
     * Functionality : All Page Of Customer Group
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCstTypeGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID, $tSesAgnCode){
        $tSQL = "SELECT COUNT (CstType.FTCtyCode) AS counts
                FROM [TCNMCstType] CstType
                LEFT JOIN [TCNMCstType_L] CstTypeL ON CstTypeL.FTCtyCode = CstType.FTCtyCode AND CstTypeL.FNLngID = $ptLngID
                WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CstType.FTCtyCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CstTypeL.FTCtyName LIKE '%$ptSearchList%')";
        }

        if ($tSesAgnCode != '') {
            $tSQL .= " AND CstType.FTAgnCode = $tSesAgnCode";
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
     * Parameters : $ptCstTypeCode
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCstTypeCheckDuplicate($ptCstTypeCode){
        $tSQL = "SELECT COUNT(FTCtyCode) AS counts
                 FROM TCNMCstType
                 WHERE FTCtyCode = '$ptCstTypeCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Update Customer Group
     * Parameters : $paData is data for update
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCstTypeAddUpdateMaster($paData){
        try{
            // Update Master
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode' , $paData['FTAgnCode']);
            $this->db->where('FTCtyCode', $paData['FTCstTypeCode']);
            $this->db->update('TCNMCstType');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMCstType',array(
                    'FTCtyCode'     => $paData['FTCstTypeCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTAgnCode'     => $paData['FTAgnCode'],
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

    /**
     * Functionality : Update Lang Customer Group
     * Parameters : $paData is data for update
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCstTypeAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTCtyName', $paData['FTCstTypeName']);
            $this->db->set('FTCtyRmk' , $paData['FTCstTypeRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCtyCode', $paData['FTCstTypeCode']);
            $this->db->update('TCNMCstType_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMCstType_L',array(
                    'FTCtyCode' => $paData['FTCstTypeCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCtyName' => $paData['FTCstTypeName'],
                    'FTCtyRmk'  => $paData['FTCstTypeRmk']
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

    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCstTypeDel($paData){
        $sql=$this->db->where('FTCtyCode', $paData['FTCstTypeCode']);
        $sql.=$this->db->delete('TCNMCstType');
        echo $sql;
        $this->db->where_in('FTCtyCode', $paData['FTCstTypeCode']);
        $this->db->delete('TCNMCstType_L');
        
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
