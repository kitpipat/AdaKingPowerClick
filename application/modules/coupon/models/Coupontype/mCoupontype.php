<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCoupontype extends CI_Model {
    
    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCPTSearchByID($paData){

        $tCptCode   = $paData['FTCptCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT
                        CPT.FTCptCode        AS rtCptCode,
                        CPT.FTCptStaUse      AS rtCptStaUse,
                        CPT.FTCptType        AS rtCptType,
                        CPT.FTCptStaChk      AS rtCptStaChk,
                        CPT.FTCptStaChkHQ    AS rtCptStaChkHQ,
                        CPTL.FTCptName       AS rtCptName,
                        CPTL.FTCptRemark     AS rtCptRemark,
                        CPT.FTAgnCode        AS rtAgnCode,
                        AGN_L.FTAgnName      AS rtAgnName

                FROM [TFNMCouponType] CPT
                LEFT JOIN TCNMAgency_L AGN_L ON CPT.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                LEFT JOIN [TFNMCouponType_L] CPTL ON CPT.FTCptCode = CPTL.FTCptCode AND CPTL.FNLngID = $nLngID
                WHERE 1=1 ";
        
        if($tCptCode!= ""){
            $tSQL .= "AND CPT.FTCptCode = '$tCptCode'";
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
    
    //Functionality : list Recive
    //Parameters : function parameters
    //Creator :   19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCPTList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");

        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTCptCode DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                CPT.FTCptCode,
                                CPT.FTCptStaUse,
                                CPT.FDCreateOn,
                                CPTL.FTCptName,
                                CPT.FTCptType,
                                CPT.FTCptStaChk,
                                CPT.FTCptStaChkHQ,
                                CPTL.FTCptRemark
                            FROM [TFNMCouponType] CPT
                            LEFT JOIN [TFNMCouponType_L] CPTL ON CPT.FTCptCode = CPTL.FTCptCode AND CPTL.FNLngID = $nLngID
                            WHERE 1=1  ";
        if($tAgnCode != ''){
            $tSQL .= "AND CPT.FTAgnCode = '$tAgnCode' OR ISNULL(CPT.FTAgnCode,'') = ''";
        }
        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (CPT.FTCptCode LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPTL.FTCptName LIKE '%$tSearchList%')";
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
   
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCPTGetPageAll($tSearchList,$nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']);
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> $nPageAll, 
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }else{
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
    
    //Functionality : Update Creditcard
    //Parameters : function parameters
    //Creator :  19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMCPTAddUpdateMaster($paData){

        try{
            //Update Master
            $this->db->set('FTCptCode' , $paData['FTCptCode']);
            $this->db->set('FTCptStaUse' , $paData['FTCptStaUse']);
            $this->db->set('FTCptType' , $paData['FTCptType']);
            $this->db->set('FTCptStaChk',$paData['FTCptStaChk']);
            $this->db->set('FTCptStaChkHQ',$paData['FTCptStaChkHQ']);
            $this->db->set('FDCreateOn' , $paData['FDCreateOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTCreateBy' , $paData['FTCreateBy']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTCptCode', $paData['FTCptCode']);
            $this->db->update('TFNMCouponType');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TFNMCouponType',array(
                    'FTCptCode'     => $paData['FTCptCode'],
                    'FTCptStaUse'   => $paData['FTCptStaUse'],
                    'FTCptType'     => $paData['FTCptType'],
                    'FTCptStaChk'   => $paData['FTCptStaChk'],
                    'FTCptStaChkHQ' => $paData['FTCptStaChkHQ'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
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


    //Functionality : Update Lang Bank
    //Parameters : function parameters
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSaMCPTAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTCptName', $paData['FTCptName']);
            $this->db->set('FTCptRemark', $paData['FTCptRemark']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCptCode', $paData['FTCptCode']);
            $this->db->update('TFNMCouponType_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TFNMCouponType_L',array(
                    'FTCptCode' => $paData['FTCptCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCptName' => $paData['FTCptName'],
                    'FTCptRemark' => $paData['FTCptRemark'],
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



    //Functionality : All Page Of Recive
    //Parameters : function parameters
    //Creator :  19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMCPTGetPageAll($ptSearchList,$ptLngID){
        $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");
        $tSQL = "SELECT COUNT (CPT.FTCptCode) AS counts
                 FROM TFNMCouponType CPT
                 LEFT JOIN [TFNMCouponType_L] CPTL ON CPT.FTCptCode = CPTL.FTCptCode AND CPTL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if($tAgnCode != ''){
            $tSQL .= "AND CPT.FTAgnCode = '$tAgnCode' OR ISNULL(CPT.FTAgnCode,'') = ''";
        }

        if($ptSearchList != ''){
            $tSQL .= " AND (CPT.FTCptCode LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPTL.FTCptName LIKE '%$ptSearchList%')";
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
    //Creator : 19/12/2019 Witsarut (Bell) 
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMCPTCheckDuplicate($ptCptCode){
        $tSQL = "SELECT COUNT(FTCptCode)AS counts
                 FROM TFNMCouponType
                 WHERE FTCptCode = '$ptCptCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
    
    //Functionality : Delete Voucher
    //Parameters : function parameters
    //Creator : 19/12/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCPTDel($paData){
        $this->db->where_in('FTCptCode', $paData['FTCptCode']);
        $this->db->delete('TFNMCouponType');
        
        $this->db->where_in('FTCptCode', $paData['FTCptCode']);
        $this->db->delete('TFNMCouponType_L');
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

    //Functionality : get all row data from pos
    //Parameters : -
    //Creator : 20/12/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMCouponType";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }
    
}
