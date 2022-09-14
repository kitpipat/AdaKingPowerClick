<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerGroup extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCstGrpSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCstGrpCode   = $paData['FTCstGrpCode'];
        $nLngID     = $paData['FNLngID'];

       
        $tSQL       = "SELECT
                            CstGrp.FTCgpCode   AS rtCstGrpCode,
                            CstGrpL.FTCgpName  AS rtCstGrpName,
                            CstGrpL.FTCgpRmk   AS rtCstGrpRmk,
                            CstGrp.FTAgnCode   AS rtAgnCode,
                            AGNL.FTAgnName  AS rtAgnName
                       FROM [TCNMCstGrp] CstGrp
                       LEFT JOIN [TCNMCstGrp_L]  CstGrpL ON CstGrp.FTCgpCode = CstGrpL.FTCgpCode AND CstGrpL.FNLngID = $nLngID
                       LEFT JOIN TCNMAgency_L AGNL ON  CstGrp.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                       WHERE 1=1 ";
        if($tCstGrpCode!= ""){
            $tSQL .= "AND CstGrp.FTCgpCode = '$tCstGrpCode'";
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
    public function FSaMCstGrpList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];

        $tSesAgnCode = $paData['tSesAgnCode'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtCstGrpCode DESC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                                CstGrp.FTCgpCode   AS rtCstGrpCode,
                                CstGrpL.FTCgpName  AS rtCstGrpName,
                                CstGrp.FDCreateOn
                        FROM [TCNMCstGrp] CstGrp
                        LEFT JOIN [TCNMCstGrp_L] CstGrpL ON CstGrpL.FTCgpCode = CstGrp.FTCgpCode AND CstGrpL.FNLngID = $nLngID
                        WHERE 1=1";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            // $tSQL .= " AND (CstGrp.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CstGrpL.FTCgpName LIKE '%$tSearchList%')"; 
            $tSQL .= " AND CstGrp.FTCgpCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR CstGrpL.FTCgpName COLLATE THAI_BIN LIKE '%$tSearchList%'";
        }
        if ($tSesAgnCode != '') {
            $tSQL .= " AND CstGrp.FTAgnCode = $tSesAgnCode";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCstGrpGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID,$tSesAgnCode);
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
    public function FSnMCstGrpGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID, $tSesAgnCode){
        $tSQL = "SELECT COUNT (CstGrp.FTCgpCode) AS counts
                FROM [TCNMCstGrp] CstGrp
                LEFT JOIN [TCNMCstGrp_L] CstGrpL ON CstGrpL.FTCgpCode = CstGrp.FTCgpCode AND CstGrpL.FNLngID = $ptLngID
                WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CstGrp.FTCgpCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CstGrpL.FTCgpName LIKE '%$ptSearchList%')";
            
        }

        if ($tSesAgnCode != '') {
            $tSQL .= " AND CstGrp.FTAgnCode = $tSesAgnCode";
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
     * Parameters : $ptCstGrpCode
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCstGrpCheckDuplicate($ptCstGrpCode){
        $tSQL = "SELECT COUNT(FTCgpCode) AS counts
                 FROM TCNMCstGrp
                 WHERE FTCgpCode = '$ptCstGrpCode' ";
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
    public function FSaMCstGrpAddUpdateMaster($paData){

        try{
            // Update Master
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode' , $paData['FTAgnCode']);
            $this->db->where('FTCgpCode', $paData['FTCstGrpCode']);
            $this->db->update('TCNMCstGrp');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMCstGrp',array(
                    'FTCgpCode'     => $paData['FTCstGrpCode'],
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
    public function FSaMCstGrpAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTCgpName', $paData['FTCstGrpName']);
            $this->db->set('FTCgpRmk' , $paData['FTCstGrpRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCgpCode', $paData['FTCstGrpCode']);
            $this->db->update('TCNMCstGrp_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMCstGrp_L',array(
                    'FTCgpCode' => $paData['FTCstGrpCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCgpName' => $paData['FTCstGrpName'],
                    'FTCgpRmk'  => $paData['FTCstGrpRmk']
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
    public function FSnMCstGrpDel($paData){
        $this->db->where('FTCgpCode', $paData['FTCstGrpCode']);
        $this->db->delete('TCNMCstGrp');
        
        $this->db->where_in('FTCgpCode', $paData['FTCstGrpCode']);
        $this->db->delete('TCNMCstGrp_L');
        
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
