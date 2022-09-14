<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBookBank extends CI_Model {
    
    //Functionality : list Data BookBank
    //Parameters : function parameters
    //Creator :  31/01/2020 Saharat(Golf)
    //Last Modified : 15/02/2021 Napat(Jame) ปรับ Query ให้ดึงจำนวนรายการ จาก Query เดียวกัน
    //Return : data
    //Return Type : Array
    public function FSaMBBKList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID  = $paData['FNLngID'];

        $tSQLHeader = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtBbkCode DESC) AS FNRowID,* FROM ( ";
        $tSQL       = "     SELECT DISTINCT
                                BBK.FTBbkCode       AS rtBbkCode,
                                BBK.FTBbkAccNo      AS rtBbkAccNo,
                                BBK.FTBnkCode       AS rtBnkCode,
                                BBK.FTBbkType       AS rtBbkType,
                                BBK.FCBbkBalance    AS rtBbkBalance,
                                BBK.FTBbkStaActive  AS rtBbkStaActive,
                                BBKL.FTBbkName      AS rtBbkName,
                                BBKL.FTBbkBranch    AS rtBbkBranch,
                                BNKL.FTBnkName      AS rtBnkName,
                                BCHL.FTBchCode      AS rtBchCode,
                                BCHL.FTBchName      AS rtBchName,
                                BBK.FDCreateOn
                            FROM [TFNMBookBank] BBK WITH(NOLOCK)
                            LEFT JOIN [TFNMBookBank_L] BBKL WITH(NOLOCK)
                                ON BBK.FTBbkCode = BBKL.FTBbkCode AND BBK.FTBchCode = BBKL.FTBchCode AND BBK.FTBchCode = BBKL.FTBchCode AND BBKL.FNLngID = $nLngID
                            LEFT JOIN [TFNMBank_L] BNKL WITH(NOLOCK) ON BBK.FTBnkCode = BNKL.FTBnkCode AND BNKL.FNLngID = $nLngID
                            LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON BBK.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                            WHERE 1=1 ";
        
        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (BBK.FTBbkCode LIKE '%$tSearchList%'";
            $tSQL .= "      OR BBK.FTBbkAccNo LIKE '%$tSearchList%'";
            $tSQL .= "      OR BNKL.FTBnkName LIKE '%$tSearchList%'";
            $tSQL .= "      OR BCHL.FTBchName LIKE '%$tSearchList%'";
            $tSQL .= "      OR BBKL.FTBbkName LIKE '%$tSearchList%')";
        }


        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND BBK.FTBchCode IN ($tBchCode) ";
        }


        $tSQLFooter = " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";
   
        $tSQLMain = $tSQLHeader.$tSQL.$tSQLFooter;
        $tSQLSub  = $tSQL;

        $oQuery = $this->db->query($tSQLMain);
        if( $oQuery->num_rows() > 0 ){
            $oQuerySub  = $this->db->query($tSQLSub);
            $oList      = $oQuery->result();
            // $aFoundRow  = $this->FSnMBBKGetPageAll($tSearchList,$nLngID);
            // $nFoundRow  = $aFoundRow[0]->counts;
            $nFoundRow  = $oQuerySub->num_rows();
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
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
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMBBKSearchByID($paData){

        $tCrdCode   = $paData['FTBbkCode'];
        $tBchCode   = $paData['FTBchCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT DISTINCT
                    BBK.FTBbkCode       AS rtBbkCode,
                    BBK.FTBbkAccNo      AS rtBbkAccNo,
                    BBK.FTBnkCode       AS rtBnkCode,
                    BBK.FTBbkType       AS rtBbkType,
                    BBK.FCBbkBalance    AS rtBbkBalance,
                    BBK.FTBbkStaActive  AS rtBbkStaActive,
                    BBK.FDBbkUpd        AS rtBbkUpd,
                    BBKL.FTBbkName      AS rtBbkName,
                    BBKL.FTBbkBranch    AS rtBbkBranch,
                    BBKL.FTBbkRmk       AS rtBbkRmk,
                    BNKL.FTBnkName      AS rtBnkName,
                    BBK.FDBbkOpen       AS rtBbkOpen,
                    BCHL.FTBchCode      AS rtBchCode,
                    BCHL.FTBchName      AS rtBchName,
                    MCTL.FTMerCode      AS rtMerCode,
                    MCTL.FTMerName      AS rtMerName
                FROM [TFNMBookBank] BBK
                LEFT JOIN [TFNMBookBank_L] BBKL ON BBK.FTBbkCode = BBKL.FTBbkCode AND BBK.FTBchCode = BBKL.FTBchCode AND BBKL.FNLngID = $nLngID 
                LEFT JOIN [TFNMBank_L] BNKL ON BBK.FTBnkCode = BNKL.FTBnkCode AND BNKL.FNLngID = $nLngID
                LEFT JOIN [TCNMBranch_L] BCHL ON BBK.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                LEFT JOIN [TCNMMerchant_L] MCTL ON BBK.FTMerCode = MCTL.FTMerCode AND MCTL.FNLngID = $nLngID
                WHERE 1=1 
                AND BBK.FTBbkCode = '$tCrdCode' 
                AND BBK.FTBchCode = '$tBchCode' ";
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
    
    //Functionality : Update Creditcard
    //Parameters : function parameters
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : 28/01/2020 Saharat(Golf)
    //Return : response
    //Return Type : Array
    public function FSaMBBKAddUpdateMaster($paData){
        try{
            if(!empty($paData['tOldBbkCode']) && !empty($paData['tOldBchCode'])){
                $this->db->set('FTBchCode' ,        $paData['FTBchCode']);
                $this->db->set('FTMerCode' ,        $paData['FTMerCode']);
                $this->db->set('FTBbkCode' ,        $paData['FTBbkCode']);
                $this->db->set('FTBbkAccNo' ,       $paData['FTBbkAccNo']);
                $this->db->set('FTBnkCode' ,        $paData['FTBnkCode']);
                $this->db->set('FTBbkType' ,        $paData['FTBbkType']);
                $this->db->set('FDBbkOpen' ,        $paData['FDBbkOpen']);
                $this->db->set('FTBbkStaActive' ,   $paData['FTBbkStaActive']);
                $this->db->set('FDLastUpdOn' ,      $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' ,      $paData['FTLastUpdBy']);
                $this->db->where('FTBbkCode',       $paData['tOldBbkCode']);
                $this->db->where('FTBchCode',       $paData['tOldBchCode']);
                $this->db->update('TFNMBookBank');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Edit Master.',
                    );
                }
            } else {
                $this->db->insert('TFNMBookBank',array(
                    'FTBchCode'         => $paData['FTBchCode'],
                    'FTMerCode'         => $paData['FTMerCode'],
                    'FTBbkCode'         => $paData['FTBbkCode'],
                    'FTBbkAccNo'        => $paData['FTBbkAccNo'],
                    'FTBnkCode'         => $paData['FTBnkCode'],
                    'FTBbkType'         => $paData['FTBbkType'],
                    'FDBbkOpen'         => $paData['FDBbkOpen'],
                    'FTBbkStaActive'    => $paData['FTBbkStaActive'],
                    'FDCreateOn'        => $paData['FDCreateOn'],
                    'FTCreateBy'        => $paData['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Master.',
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
    //Creator : 04/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMBBKAddUpdateLang($paData){
        try{
            if(!empty($paData['tOldBbkCode']) && !empty($paData['tOldBchCode'])){
                //Update Lang
                $this->db->set('FTBbkCode' , $paData['FTBbkCode']);
                $this->db->set('FTBchCode' , $paData['FTBchCode']);
                $this->db->set('FTBbkName', $paData['FTBbkName']);
                $this->db->set('FTBbkBranch', $paData['FTBbkBranch']);
                $this->db->set('FTBbkRmk', $paData['FTBbkRmk']);
                $this->db->where('FNLngID', $paData['FNLngID']);
                // $this->db->where('FTBbkCode', $paData['FTBbkCode']);
                $this->db->where('FTBbkCode',       $paData['tOldBbkCode']);
                $this->db->where('FTBchCode',       $paData['tOldBchCode']);
                $this->db->update('TFNMBookBank_L');
                if($this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Lang Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Edit Lang.',
                    );
                }
            } else {
                $this->db->insert('TFNMBookBank_L',array(
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTBbkCode'     => $paData['FTBbkCode'],
                    'FNLngID'       => $paData['FNLngID'],
                    'FTBbkName'     => $paData['FTBbkName'],
                    'FTBbkBranch'   => $paData['FTBbkBranch'],
                    'FTBbkRmk'      => $paData['FTBbkRmk'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Lang.',
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
    //Creator :  31/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    // public function FSnMBBKGetPageAll($ptSearchList,$ptLngID){
        
    //     $tSQL = "SELECT COUNT (BBK.FTBbkCode) AS counts
    //              FROM   [TFNMBookBank] BBK
    //                     LEFT JOIN [TFNMBookBank_L] BBKL 
    //                         ON BBK.FTBbkCode = BBKL.FTBbkCode AND BBK.FTBchCode = BBKL.FTBchCode AND BBKL.FNLngID = $ptLngID
    //                     LEFT JOIN [TFNMBank_L] BNKL ON BBK.FTBnkCode = BNKL.FTBnkCode AND BNKL.FNLngID = $ptLngID
    //                     LEFT JOIN [TCNMBranch_L] BCHL ON BBK.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $ptLngID
    //              WHERE 1=1 ";
        
    //     if($ptSearchList != ''){
    //         // $tSQL .= " AND (BBK.FTBbkCode LIKE '%$ptSearchList%'";
    //         // $tSQL .= " OR BBKL.FTBbkName LIKE '%$ptSearchList%')";
    //         $tSQL .= " AND (BBK.FTBbkCode LIKE '%$ptSearchList%'";
    //         $tSQL .= "      OR BBK.FTBbkAccNo LIKE '%$ptSearchList%'";
    //         $tSQL .= "      OR BNKL.FTBnkName LIKE '%$ptSearchList%'";
    //         $tSQL .= "      OR BCHL.FTBchName LIKE '%$ptSearchList%'";
    //         $tSQL .= "      OR BBKL.FTBbkName LIKE '%$ptSearchList%')";
    //     }

    //     $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
    //     if($tStaUsrLevel == 'HQ'){
    //         $tSQL   .= "";
    //     }else if($tStaUsrLevel == 'BCH'){
    //         $tBCH    = $this->session->userdata("tSesUsrBchCom");
    //         $tSQL   .= " AND BBK.FTBchCode = '$tBCH'";
    //     }
        
    //     $oQuery = $this->db->query($tSQL);
    //     if ($oQuery->num_rows() > 0) {
    //         return $oQuery->result();
    //     }else{
    //         //No Data
    //         return false;
    //     }
    // }
    
    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 04/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMBbkCheckDuplicate($ptBbkCode, $ptBchCode){
        $tSQL = "SELECT COUNT(FTBbkCode)AS counts
                 FROM TFNMBookBank
                 WHERE FTBbkCode = '$ptBbkCode' AND FTBchCode = '$ptBchCode'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            // return $oQuery->result();
            $oCountDup = $oQuery->result();
            $nStaDup    = $oCountDup[0]->counts;
            return $nStaDup > 0 ? true : false ;
        }else{
            return false;
        }
    }
    
    //Functionality : Delete Recive
    //Parameters : function parameters
    //Creator : 04/02/2020 Saharat(Golf)
    //Return : response
    //Return Type : array
    public function FSnMBBKDel($paData){
        $this->db->trans_begin();
        $tTargetBchCodeAndBbkCodeSQLConditionList = [];
        foreach($paData as $aBchCodeAndBbkCodeRow){
            $tTargetBchCodeAndBbkCodeSQLConditionList[] = "(FTBbkCode = '{$aBchCodeAndBbkCodeRow['FTBbkCode']}' AND FTBchCode = '{$aBchCodeAndBbkCodeRow['FTBchCode']}')";
        }

        $tSQLDeleteCondition = '';
        if(FCNnHSizeOf($tTargetBchCodeAndBbkCodeSQLConditionList) > 0){
            $tSQLDeleteCondition = ' WHERE ';
            $tSQLDeleteCondition .= implode(' OR ', $tTargetBchCodeAndBbkCodeSQLConditionList);
        }

        $tSQL = "DELETE FROM TFNMBookBank $tSQLDeleteCondition";
        $oQuery = $this->db->query($tSQL);

        $tSQL = "DELETE FROM TFNMBookBank_L $tSQLDeleteCondition"; 
        $oQuery = $this->db->query($tSQL);

        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $this->db->trans_rollback();
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.'
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : get all row 
    //Parameters : -
    //Creator : 04/04/2020 Saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMBBKGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMBookBank";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
