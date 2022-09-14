<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCardcoupon extends CI_Model {
    
    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCCLSearchByID($paData){

        $tCclCode   = $paData['tCclCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT 
                CPNL.FTCclCode  AS rtCclCode ,
                CPNL.FCCclAmt    	 AS rtCclAmt  ,
                CPNL.FDCclStartDate  AS rdCclStartDate,
                CPNL.FDCclEndDate    AS rdCclEndDate,
                CPNL.FTCclStaUse     AS rtCclStaUse,
                CPNLL.FTCclName      AS rtCclName ,
                CPNLL.FTCclPrnCond   AS rtCclPrnCond

                FROM [TFNMCrdCpnList] CPNL
                LEFT JOIN [TFNMCrdCpnList_L] CPNLL ON CPNL.FTCclCode = CPNLL.FTCclCode AND CPNLL.FNLngID = $nLngID
                WHERE 1=1 ";
        
        if($tCclCode!= ""){
            $tSQL .= "AND CPNL.FTCclCode = '$tCclCode'";
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
    //Creator :  11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCCLList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY rtCclCode ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                CPNL.FTCclCode       AS rtCclCode ,
                                CPNL.FCCclAmt    	 AS rtCclAmt ,
                                CPNL.FDCclStartDate  AS rdCclStartDate,
                                CPNL.FDCclEndDate    AS rdCclEndDate,
                                CPNL.FTCclStaUse     AS rtCclStaUse,
                                CPNLL.FTCclName      AS rtCclName ,
                                CPNLL.FTCclPrnCond   AS rtCclPrnCond

                            FROM [TFNMCrdCpnList] CPNL
                            LEFT JOIN [TFNMCrdCpnList_L] CPNLL ON CPNL.FTCclCode = CPNLL.FTCclCode AND CPNLL.FNLngID = $nLngID
                            WHERE 1=1 ";
        
        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (CPNL.FTCclCode LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPNLL.FTCclName LIKE '%$tSearchList%')";
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
   
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCCLGetPageAll($tSearchList,$nLngID);
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
    
    //Functionality : Update Creditcard
    //Parameters : function parameters
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMCCLAddUpdateMaster($paData){
   
        try{
            //Update Master
            $this->db->set('FTCclCode' , $paData['FTCclCode']);
            $this->db->set('FCCclAmt' , $paData['FCCclAmt']);
            $this->db->set('FDCclStartDate' , $paData['FDCclStartDate']);
            $this->db->set('FDCclEndDate' , $paData['FDCclEndDate']);
            $this->db->set('FTCclStaUse' , $paData['FTCclStaUse']);
            $this->db->set('FDCreateOn' , $paData['FDCreateOn']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTCreateBy' , $paData['FTCreateBy']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

            $this->db->where('FTCclCode', $paData['FTCclCode']);
            $this->db->update('TFNMCrdCpnList');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TFNMCrdCpnList',array(
                    'FTCclCode'      => $paData['FTCclCode'],
                    'FCCclAmt'       => $paData['FCCclAmt'],
                    'FDCclStartDate' => $paData['FDCclStartDate'],
                    'FDCclEndDate'   => $paData['FDCclEndDate'],
                    'FTCclStaUse'    => $paData['FTCclStaUse'],
                    'FDCreateOn'     => $paData['FDCreateOn'],
                    'FDLastUpdOn'    => $paData['FDLastUpdOn'],
                    'FTCreateBy'     => $paData['FTCreateBy'],
                    'FTLastUpdBy'    => $paData['FTLastUpdBy']
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
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSaMCCLAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTCclName', $paData['FTCclName']);
            $this->db->set('FTCclPrnCond', $paData['FTCclPrnCond']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCclCode', $paData['FTCclCode']);
            $this->db->update('TFNMCrdCpnList_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TFNMCrdCpnList_L',array(
                    'FTCclCode' => $paData['FTCclCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCclName' => $paData['FTCclName'],
                    'FTCclPrnCond' => $paData['FTCclPrnCond']
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
    //Creator :  11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMCCLGetPageAll($ptSearchList,$ptLngID){
        
        $tSQL = "SELECT COUNT (CPNL.FTCclCode) AS counts
                 FROM TFNMCrdCpnList CPNL
                 LEFT JOIN [TFNMCrdCpnList_L] CPNLL ON CPNL.FTCclCode = CPNLL.FTCclCode AND CPNLL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CPNL.FTCclCode LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPNLL.FTCclName LIKE '%$ptSearchList%')";
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
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMCPNCheckDuplicate($ptCclCode){
        $tSQL = "SELECT COUNT(FTCclCode)AS counts
                 FROM TFNMCrdCpnList
                 WHERE FTCclCode = '$ptCclCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
    
    //Functionality : Delete Coupon
    //Parameters : function parameters
    //Creator : 14/05/2018 wasin
    //Return : response
    //Return Type : array
    public function FSnMCCLDel($paData){
        $this->db->where_in('FTCclCode', $paData['FTCclCode']);
        $this->db->delete('TFNMCrdCpnList');
        
        $this->db->where_in('FTCclCode', $paData['FTCclCode']);
        $this->db->delete('TFNMCrdCpnList_L');
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
