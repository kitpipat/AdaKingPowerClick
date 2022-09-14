<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerOcp extends CI_Model {

    /**
     * Functionality : Search Customer Type By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCstOcpSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCstOcpCode   = $paData['FTCstOcpCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            CstOcp.FTOcpCode   AS rtCstOcpCode,
                            CstOcpL.FTOcpName  AS rtCstOcpName,
                            CstOcpL.FTOcpRmk   AS rtCstOcpRmk
                       FROM [TCNMCstOcp] CstOcp
                       LEFT JOIN [TCNMCstOcp_L]  CstOcpL ON CstOcp.FTOcpCode = CstOcpL.FTOcpCode AND CstOcpL.FNLngID = $nLngID
                       WHERE 1=1 ";
        if($tCstOcpCode!= ""){
            $tSQL .= "AND CstOcp.FTOcpCode = '$tCstOcpCode'";
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
    public function FSaMCstOcpList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY rtCstOcpCode ASC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                                CstOcp.FTOcpCode   AS rtCstOcpCode,
                                CstOcpL.FTOcpName  AS rtCstOcpName
                        FROM [TCNMCstOcp] CstOcp
                        LEFT JOIN [TCNMCstOcp_L] CstOcpL ON CstOcpL.FTOcpCode = CstOcp.FTOcpCode AND CstOcpL.FNLngID = $nLngID
                        WHERE 1=1";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (CstOcp.FTOcpCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CstOcpL.FTOcpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCstOcpGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID);
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
    public function FSnMCstOcpGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID){
        $tSQL = "SELECT COUNT (CstOcp.FTOcpCode) AS counts
                FROM [TCNMCstOcp] CstOcp
                LEFT JOIN [TCNMCstOcp_L] CstOcpL ON CstOcpL.FTOcpCode = CstOcp.FTOcpCode AND CstOcpL.FNLngID = $ptLngID
                WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CstOcp.FTOcpCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CstOcpL.FTOcpName LIKE '%$ptSearchList%')";
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
     * Parameters : $ptCstOcpCode
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCstOcpCheckDuplicate($ptCstOcpCode){
        $tSQL = "SELECT COUNT(FTOcpCode) AS counts
                 FROM TCNMCstOcp
                 WHERE FTOcpCode = '$ptCstOcpCode' ";
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
    public function FSaMCstOcpAddUpdateMaster($paData){
        try{
            // Update Master
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTOcpCode', $paData['FTCstOcpCode']);
            $this->db->update('TCNMCstOcp');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMCstOcp',array(
                    'FTOcpCode' => $paData['FTCstOcpCode'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FTCreateBy'  => $paData['FTCreateBy']
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
    public function FSaMCstOcpAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTOcpName', $paData['FTCstOcpName']);
            $this->db->set('FTOcpRmk' , $paData['FTCstOcpRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTOcpCode', $paData['FTCstOcpCode']);
            $this->db->update('TCNMCstOcp_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMCstOcp_L',array(
                    'FTOcpCode' => $paData['FTCstOcpCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTOcpName' => $paData['FTCstOcpName'],
                    'FTOcpRmk'  => $paData['FTCstOcpRmk']
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
    public function FSnMCstOcpDel($paData){
        $this->db->where('FTOcpCode', $paData['FTCstOcpCode']);
        $this->db->delete('TCNMCstOcp');
        
        $this->db->where_in('FTOcpCode', $paData['FTCstOcpCode']);
        $this->db->delete('TCNMCstOcp_L');
        
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
