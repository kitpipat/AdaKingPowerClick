<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerLevel extends CI_Model {

    /**
     * Functionality : Search Customer Type By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCstLevSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCstLevCode   = $paData['FTCstLevCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            CstLev.FTClvCode   AS rtCstLevCode,
                            CstLev.FCLevRtePntAge AS rtCstLevRtePntAge,
                            CstLev.FTLevStaAlwPnt AS rtCstLevStaAlwPnt,
                            CstLev.FCLevRtePntAmt AS rtCstLevRtePntAmt,
                            CstLev.FCLevRtePntQty AS rtCstLevRtePntQty,
                            CstLev.FTPplCode AS rtCstLevPplCode,
                            PLL.FTPplName   AS rtCstLevPplName,
                            CstLevL.FTClvName  AS rtCstLevName,
                            CstLevL.FTClvRmk   AS rtCstLevRmk,
                            CstLev.FTAgnCode   AS rtAgnCode,
                            AGNL.FTAgnName  AS rtAgnName
                        FROM [TCNMCstLev] CstLev
                        LEFT JOIN [TCNMCstLev_L]  CstLevL ON CstLev.FTClvCode = CstLevL.FTClvCode AND CstLevL.FNLngID = $nLngID
                        LEFT JOIN TCNMAgency_L AGNL ON  CstLev.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                        LEFT JOIN TCNMPdtPriList_L PLL ON CstLev.FTPplCode = PLL.FTPplCode AND PLL.FNLngID  = $nLngID
                        ";
        if($tCstLevCode!= ""){
            $tSQL .= "WHERE CstLev.FTClvCode = '$tCstLevCode'";
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
    public function FSaMCstLevList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];

        $tSesAgnCode = $paData['tSesAgnCode'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtCstLevCode DESC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                                CstLev.FTClvCode   AS rtCstLevCode,
                                CstLevL.FTClvName  AS rtCstLevName,
                                CstLev.FDCreateOn
                        FROM [TCNMCstLev] CstLev
                        LEFT JOIN [TCNMCstLev_L] CstLevL ON CstLevL.FTClvCode = CstLev.FTClvCode AND CstLevL.FNLngID = $nLngID
                        WHERE 1=1";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            // $tSQL .= " AND (CstLev.FTClvCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CstLevL.FTClvName LIKE '%$tSearchList%')";
            $tSQL .= " AND CstLev.FTClvCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR CstLevL.FTClvName COLLATE THAI_BIN LIKE '%$tSearchList%'";

        }

        if ($tSesAgnCode != '') {
            $tSQL .= " AND CstLev.FTAgnCode = $tSesAgnCode";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCstLevGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID,$tSesAgnCode);
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
    public function FSnMCstLevGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID,$tSesAgnCode){
        $tSQL = "SELECT COUNT (CstLev.FTClvCode) AS counts
                FROM [TCNMCstLev] CstLev
                LEFT JOIN [TCNMCstLev_L] CstLevL ON CstLevL.FTClvCode = CstLev.FTClvCode AND CstLevL.FNLngID = $ptLngID
                WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CstLev.FTClvCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CstLevL.FTClvName LIKE '%$ptSearchList%')";
        }

        
        if ($tSesAgnCode != '') {
            $tSQL .= " AND CstLev.FTAgnCode = $tSesAgnCode";
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
     * Parameters : $ptCstLevCode
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCstLevCheckDuplicate($ptCstLevCode){
        $tSQL = "SELECT COUNT(FTClvCode) AS counts
                 FROM TCNMCstLev
                 WHERE FTClvCode = '$ptCstLevCode' ";
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
    public function FSaMCstLevAddUpdateMaster($paData){
        try{
            // Update Master
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTPplCode' , $paData['FTPplCode']);
            $this->db->set('FCLevRtePntAmt' , $paData['FCLevRtePntAmt']);
            $this->db->set('FCLevRtePntQty' , $paData['FCLevRtePntQty']);
            $this->db->set('FTLevStaAlwPnt' , $paData['FTLevStaAlwPnt']);
            $this->db->set('FCLevRtePntAge' , $paData['FCLevRtePntAge']);
            $this->db->set('FTAgnCode' , $paData['FTAgnCode']);
            $this->db->where('FTClvCode', $paData['FTCstLevCode']);
            $this->db->update('TCNMCstLev');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMCstLev',array(
                    'FTClvCode'     => $paData['FTCstLevCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTAgnCode'     => $paData['FTAgnCode'],
                    'FCLevRtePntAge' => $paData['FCLevRtePntAge'],
                    'FCLevRtePntAmt' => $paData['FCLevRtePntAmt'],
                    'FCLevRtePntQty' => $paData['FCLevRtePntQty'],
                    'FTLevStaAlwPnt' => $paData['FTLevStaAlwPnt'],
                    'FCLevRtePntAge' => $paData['FCLevRtePntAge'],
                    'FTPplCode'      => $paData['FTPplCode']
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
    public function FSaMCstLevAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTClvName', $paData['FTCstLevName']);
            $this->db->set('FTClvRmk' , $paData['FTCstLevRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTClvCode', $paData['FTCstLevCode']);
            $this->db->update('TCNMCstLev_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMCstLev_L',array(
                    'FTClvCode' => $paData['FTCstLevCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTClvName' => $paData['FTCstLevName'],
                    'FTClvRmk'  => $paData['FTCstLevRmk']
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
    public function FSnMCstLevDel($paData){
        $this->db->where('FTClvCode', $paData['FTCstLevCode']);
        $this->db->delete('TCNMCstLev');
        
        $this->db->where_in('FTClvCode', $paData['FTCstLevCode']);
        $this->db->delete('TCNMCstLev_L');
        
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
