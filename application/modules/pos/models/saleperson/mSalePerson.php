<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSalePerson extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMSPNSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tDstCode   = $paData['FTSpnCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            SPN.FTSpnCode AS rtSpnCode,
                            SPN.FTSpnEmail AS rtSpnEmail,
                            SPN.FTSpnTel AS rtSpnTel,
                            SPNL.FTSpnName AS rtSpnName,
                            SPNL.FTSpnRmk AS rtSpnRmk,
                            SPNG.FTBchCode AS rtBchCode,
                            SPNG.FTShpCode AS rtShpCode,
                            BCHL.FTBchName AS rtBchName,
                            SHPL.FTShpName AS rtShpName,
                            IMGP.FTImgObj AS rtImgObj
                       FROM [TCNMSpn] SPN WITH(NOLOCK)
                       LEFT JOIN [TCNMSpn_L]  SPNL WITH(NOLOCK) ON SPN.FTSpnCode = SPNL.FTSpnCode AND SPNL.FNLngID = $nLngID
                       LEFT JOIN [TCNTSpnGroup] SPNG WITH(NOLOCK) ON SPN.FTSpnCode = SPNG.FTSpnCode 
                       LEFT JOIN [TCNMBranch] BCH WITH(NOLOCK) ON BCH.FTBchCode = SPNG.FTBchCode
                       LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON BCHL.FTBchCode = SPNG.FTBchCode AND BCHL.FNLngID = $nLngID
                       LEFT JOIN [TCNMShop] SHP WITH(NOLOCK) ON SHP.FTShpCode = SPNG.FTShpCode AND SHP.FTBchCode = BCH.FTBchCode 
                       LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON SHPL.FTShpCode = SPNG.FTShpCode AND SHP.FTBchCode = BCH.FTBchCode AND SHPL.FNLngID = $nLngID
                       LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON IMGP.FTImgRefID = SPN.FTSpnCode AND IMGP.FNImgSeq = 1
                       WHERE 1=1 ";

        if($tDstCode!= ""){
            $tSQL .= "AND SPN.FTSpnCode = '$tDstCode'";
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
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 30/08/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSPNList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY rtSpnCode ASC) AS rtRowID,* FROM(
                            SELECT DISTINCT
                                SPN.FTSpnCode   AS rtSpnCode,
                                SPN.FTSpnEmail  AS rtSpnEmail,
                                SPN.FTSpnTel    AS rtSpnTel,
                                SPNL.FTSpnName  AS rtSpnName,
                                SPNL.FTSpnRmk   AS rtSpnRmk,
                                SPNG.FTBchCode  AS rtBchCode,
                                SPNG.FTShpCode  AS rtShpCode,
                                BCHL.FTBchName  AS rtBchName,
                                SHPL.FTShpName  AS rtShpName,
                                IMGP.FTImgObj   AS rtImgObj
                            FROM [TCNMSpn] SPN WITH(NOLOCK)
                            LEFT JOIN [TCNMSpn_L]  SPNL WITH(NOLOCK) ON SPN.FTSpnCode = SPNL.FTSpnCode AND SPNL.FNLngID = $nLngID
                            LEFT JOIN [TCNTSpnGroup] SPNG WITH(NOLOCK) ON SPN.FTSpnCode = SPNG.FTSpnCode
                            LEFT JOIN [TCNMBranch] BCH WITH(NOLOCK) ON BCH.FTBchCode = SPNG.FTBchCode
                            LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON BCHL.FTBchCode = SPNG.FTBchCode AND BCHL.FNLngID = $nLngID
                            LEFT JOIN [TCNMShop] SHP WITH(NOLOCK) ON SHP.FTShpCode = SPNG.FTShpCode
                            LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON SHPL.FTShpCode = SPNG.FTShpCode AND SHPL.FNLngID = $nLngID
                            LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON IMGP.FTImgRefID = SPN.FTSpnCode AND IMGP.FNImgSeq = 1
                            WHERE 1=1
        ";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (SPN.FTSpnCode LIKE '%$tSearchList%'";
            $tSQL .= " OR SPNL.FTSpnName LIKE '%$tSearchList%'";
            $tSQL .= " OR BCHL.FTBchName LIKE '%$tSearchList%'";
            $tSQL .= " OR SPN.FTSpnTel LIKE '%$tSearchList%'";
            $tSQL .= " OR SHPL.FTShpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMSPNGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID);
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
     * Functionality : All Page Of SalePerson
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSPNGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID){
        $tSQL = "SELECT
                    COUNT (SPN.FTSpnCode) AS counts
                 FROM [TCNMSpn] SPN WITH(NOLOCK)
                 LEFT JOIN [TCNMSpn_L]  SPNL WITH(NOLOCK) ON SPN.FTSpnCode = SPNL.FTSpnCode AND SPNL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (SPN.FTSpnCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR SPNL.FTSpnName  LIKE '%$ptSearchList%')";
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
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMSPNCheckDuplicate($ptDstCode){
        $tSQL = "SELECT COUNT(FTSpnCode) AS counts
                 FROM TCNMSpn
                 WHERE FTSpnCode = '$ptDstCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Update Sale Person
     * Parameters : $paData is data
     * Creator : 04/09/2018 piya
     * Last Modified : 25/05/2020 Napat(Jame)
     * Return : response
     * Return Type : array
     */
    public function FSaMSPNAddUpdateMaster($paData){
        try{
            // Update Master
            $this->db->set('FTSpnTel', $paData['FTSpnTel']);
            $this->db->set('FTSpnEmail', $paData['FTSpnEmail']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTSpnCode', $paData['FTSpnCode']);
            $this->db->update('TCNMSpn');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMSpn',array(
                    'FTSpnTel'      => $paData['FTSpnTel'],
                    'FTSpnEmail'    => $paData['FTSpnEmail'],
                    'FTSpnCode'     => $paData['FTSpnCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
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
     * Functionality : Update Lang Sale Person
     * Parameters : $paData is data for update
     * Creator : 05/08/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSPNAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTSpnName', $paData['FTSpnName']);
            $this->db->set('FTSpnRmk' , $paData['FTSpnRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTSpnCode', $paData['FTSpnCode']);
            $this->db->update('TCNMSpn_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMSpn_L',array(
                    'FTSpnCode' => $paData['FTSpnCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTSpnName' => $paData['FTSpnName'],
                    'FTSpnRmk'  => $paData['FTSpnRmk']
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
     * Functionality : Function Add Update Group
     * Parameters : $paData is data for update or add
     * Creator : 04/08/2018 piya
     * Last Modified : -
     * Return : Status Add Update Group
     * Return Type : array
     */
    public function FSaMSPNAddUpdateGroup($paData){
        try{
            // Update Group
            $this->db->set('FTBchCode',$paData['FTBchCode']);
            $this->db->set('FTSpnStaShop',$paData['FTSpnStaShop']);
            $this->db->set('FTShpCode',$paData['FTShpCode']);
            $this->db->set('FDSpnStart',$paData['FDSpnStart']);
            $this->db->set('FDSpnStop',$paData['FDSpnStop']);
            $this->db->where('FTSpnCode',$paData['FTSpnCode']);
            $this->db->update('TCNTSpnGroup');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                // Add Group
                $this->db->insert('TCNTSpnGroup',array(
                    'FTSpnCode'     => $paData['FTSpnCode'],
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTSpnStaShop'  => $paData['FTSpnStaShop'],
                    'FTShpCode'     => $paData['FTShpCode'],
                    'FDSpnStart'    => $paData['FDSpnStart'],
                    'FDSpnStop'     => $paData['FDSpnStop']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    // Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Group.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Delete SalePerson
     * Parameters : $paData
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSnMSPNDel($paData){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTSpnCode', $paData['FTSpnCode']);
            $this->db->delete('TCNMSpn');

            $this->db->where_in('FTSpnCode', $paData['FTSpnCode']);
            $this->db->delete('TCNMSpn_L');

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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMSpn";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }  

}
