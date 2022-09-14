<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCoupon extends CI_Model {
    
    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCPNSearchByID($paData){

        $tCpnCode   = $paData['FTCpnCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT
                    CPN.FTCpnCode       AS rtCpnCode,
                    CPN.FTCpnBarCode    AS rtCpnBarCode,
                    CPN.FDCpnExpired    AS rdCpnExpired,
                    CPN.FTCptCode       AS rtCptCode,
                    CPTL.FTCptName      AS rtCptName,
                    CPN.FCCpnValue      AS rcCpnValue,
                    CPN.FCCpnSalePri    AS rcCpnSalePri,
                    CPN.FCCpnBalance    AS rcCpnBalance,
                    CPN.FTCpnComBook    AS rtCpnComBook,
                    CPN.FTCpnStaBook    AS rtCpnStaBook,
                    CPN.FTCpnStaSale    AS rtCpnStaSale,
                    CPN.FTCpnStaUse     AS rtCpnStaUse,
                    CPNL.FTCpnName      AS rtCpnName,
                    CPNL.FTCpnRemark    AS rtCpnRemark

                 FROM [TFNMCoupon] CPN
                 LEFT JOIN [TFNMCoupon_L] CPNL ON CPN.FTCpnCode = CPNL.FTCpnCode AND CPNL.FNLngID = $nLngID
                 LEFT JOIN [TFNMCouponType_L] CPTL ON CPN.FTCptCode = CPTL.FTCptCode AND CPTL.FNLngID = $nLngID
                 WHERE 1=1 ";
        
        if($tCpnCode!= ""){
            $tSQL .= "AND CPN.FTCpnCode = '$tCpnCode'";
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
    public function FSaMCPNList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTCpnCode ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                CPN.FTCpnCode,
                                CPN.FTCpnBarCode,
                                CPN.FDCpnExpired,
                                CPN.FTCptCode,
                                CPN.FCCpnValue,
                                CPN.FCCpnSalePri,
                                CPN.FCCpnBalance,
                                CPN.FTCpnComBook,
                                CPN.FTCpnStaBook,
                                CPN.FTCpnStaSale,
                                CPN.FTCpnStaUse,

                                CPNL.FTCpnName,
                                CPNL.FTCpnRemark,
                                CPTL.FTCptName

                            FROM [TFNMCoupon] CPN
                            LEFT JOIN [TFNMCoupon_L] CPNL ON CPN.FTCpnCode = CPNL.FTCpnCode AND CPNL.FNLngID = $nLngID
                            LEFT JOIN [TFNMCouponType_L] CPTL ON CPN.FTCptCode = CPTL.FTCptCode AND CPTL.FNLngID = $nLngID
                            WHERE 1=1 ";
        
        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (CPN.FTCpnCode LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPN.FTCptCode LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPN.FCCpnValue LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPN.FCCpnSalePri LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPN.FCCpnBalance LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPN.FTCpnComBook LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPN.FTCpnStaBook LIKE '%$tSearchList%'";
            $tSQL .= "      OR CPNL.FTCpnName LIKE '%$tSearchList%')";
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
   
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCPNGetPageAll($tSearchList,$nLngID);
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
    public function FSaMCPNAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTCpnBarCode' , $paData['FTCpnBarCode']);
            $this->db->set('FDCpnExpired' , $paData['FDCpnExpired']);
            // $this->db->set('FTCptCode' , $paData['FTCptCode']);
            $this->db->set('FCCpnValue' , $paData['FCCpnValue']);
            $this->db->set('FCCpnSalePri' , $paData['FCCpnSalePri']);
            $this->db->set('FCCpnBalance' , $paData['FCCpnBalance']);
            $this->db->set('FTCpnComBook' , $paData['FTCpnComBook']);
            $this->db->set('FTCpnStaBook' , $paData['FTCpnStaBook']);
            $this->db->set('FTCpnStaSale' , $paData['FTCpnStaSale']);
            $this->db->set('FTCpnStaUse' , $paData['FTCpnStaUse']);

            // $this->db->set('FDDateUpd' , $paData['FDDateUpd']);
            // $this->db->set('FTTimeUpd' , $paData['FTTimeUpd']);
            // $this->db->set('FTWhoUpd' , $paData['FTWhoUpd']);
            $this->db->where('FTCpnCode', $paData['FTCpnCode']);
            $this->db->update('TFNMCoupon');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TFNMCoupon',array(
                    'FTCpnCode'     => $paData['FTCpnCode'],
                    'FTCpnBarCode'  => $paData['FTCpnBarCode'],
                    'FDCpnExpired'  => $paData['FDCpnExpired'],
                    // 'FTCptCode'     => $paData['FTCptCode'],
                    'FCCpnValue'    => $paData['FCCpnValue'],
                    'FCCpnSalePri'  => $paData['FCCpnSalePri'],
                    'FCCpnBalance'  => $paData['FCCpnBalance'],
                    'FTCpnComBook'  => $paData['FTCpnComBook'],
                    'FTCpnStaBook'  => $paData['FTCpnStaBook'],
                    'FTCpnStaSale'  => $paData['FTCpnStaSale'],
                    'FTCpnStaUse'   => $paData['FTCpnStaUse']

                    // 'FDDateIns' => $paData['FDDateIns'],
                    // 'FTTimeIns' => $paData['FTTimeIns'],
                    // 'FTWhoIns'  => $paData['FTWhoIns']
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
    public function FSaMCPNAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTCpnName', $paData['FTCpnName']);
            $this->db->set('FTCpnRemark', $paData['FTCpnRemark']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCpnCode', $paData['FTCpnCode']);
            $this->db->update('TFNMCoupon_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TFNMCoupon_L',array(
                    'FTCpnCode' => $paData['FTCpnCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCpnName' => $paData['FTCpnName'],
                    'FTCpnRemark' => $paData['FTCpnRemark'],
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
    public function FSnMCPNGetPageAll($ptSearchList,$ptLngID){
        
        $tSQL = "SELECT COUNT (CPN.FTCpnCode) AS counts
                 FROM TFNMCoupon CPN
                 LEFT JOIN [TFNMCoupon_L] CPNL ON CPN.FTCpnCode = CPNL.FTCpnCode AND CPNL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CPN.FTCpnCode LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPN.FTCptCode LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPN.FCCpnValue LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPN.FCCpnSalePri LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPN.FCCpnBalance LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPN.FTCpnComBook LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPN.FTCpnStaBook LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CPNL.FTCpnName LIKE '%$ptSearchList%')";
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
    public function FSnMCPNCheckDuplicate($ptCpnCode){
        $tSQL = "SELECT COUNT(FTCpnCode)AS counts
                 FROM TFNMCoupon
                 WHERE FTCpnCode = '$ptCpnCode' ";
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
    public function FSnMCPNDel($paData){
        $this->db->where_in('FTCpnCode', $paData['FTCpnCode']);
        $this->db->delete('TFNMCoupon');
        
        $this->db->where_in('FTCpnCode', $paData['FTCpnCode']);
        $this->db->delete('TFNMCoupon_L');
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
