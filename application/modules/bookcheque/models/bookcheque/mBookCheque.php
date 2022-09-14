<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBookCheque extends CI_Model {
    
    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 11/05/2018 Wasin
    //Last Modified : 09/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSaMBCQSearchByID($paData){

        // $tBchCode   = $paData['FTBchCode'];
        $tChqCode   = $paData['FTChqCode'];
        $tBchCode   = $paData['FTBchCode'];
        $nLngID     = $paData['FNLngID'];
        // เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการ join TFNMBookCheque `และ TFNMBookCheque_L ด้วย 09/04/2020
        $tSQL = "SELECT
        
                            Chq.FTChqCode AS   rtChqCode ,
                            Chq.FTBchCode AS   rtBchCode ,
                            Chq.FTChqStaPrcDoc AS rtChqStaPrcDoc,
                            Chq.FNChqMin AS   rtChqMin, 
                            Chq.FNChqMax AS   rtChqMax,
                            ChqL.FTChqName AS  rtChqName,
                            ChqL.FTChqRmk  AS  rtChqRmk,
                            BL.FTBnkCode AS  rtBnkCode ,
                            BL.FTBnkName AS   rtBnkName ,
                            BCHL.FTBchName AS  rtBchName,
                            Chq.FTChqStaAct AS rtChqStaAct,
                            BBL.FTBbkCode AS rtBbkCode,
                            BBL.FTBbkName AS rtBbkName
            FROM TFNMBookCheque Chq
            LEFT JOIN TFNMBookCheque_L ChqL ON ChqL.FTChqCode = Chq.FTChqCode AND ChqL.FNLngID = '$nLngID' AND Chq.FTBchCode = ChqL.FTBchCode
            LEFT JOIN TFNMBookBank BB ON Chq.FTBbkCode = BB.FTBbkCode AND Chq.FTBchCode = BB.FTBchCode
            LEFT JOIN TFNMBookBank_L BBL ON BBL.FTBbkCode = BB.FTBbkCode AND BBL.FTBchCode = BB.FTBchCode
            LEFT JOIN TFNMBank_L BL ON Chq.FTBbkCode = BL.FTBnkCode   AND BL.FNLngID = '$nLngID'
            LEFT JOIN TCNMBranch_L  BCHL ON Chq.FTBchCode = BCHL.FTBchCode 
            AND BCHL.FNLngID = '$nLngID'  

      
                 WHERE 1=1 "; 
        //end เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการ join TFNMBookCheque `และ TFNMBookCheque_L ด้วย 09/04/2020
        if($tChqCode!= ""){
            $tSQL .= "AND Chq.FTChqCode = '$tChqCode' AND Chq.FTBchCode = '$tBchCode'";
        }
        // echo $tSQL ;
        // exit; 
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

    

    //Functionality : list 
    //Parameters : function parameters
    //Creator :  
    //Last Modified : 09/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSaMBCQList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        // เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการ join TFNMBookCheque `และ TFNMBookCheque_L ด้วย 09/04/2020
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTChqCode DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                        
                            Chq.FTChqCode AS   FTChqCode ,
                            Chq.FTBchCode AS   FTBchCode ,
                            Chq.FTChqStaPrcDoc AS FTChqStaPrcDoc,
                            Chq.FNChqMin AS   FNChqMin, 
                            Chq.FNChqMax AS   FNChqMax,
                            ChqL.FTChqName AS  FTChqName,
                            ChqL.FTChqRmk  AS  FTChqRmk,
                            BL.FTBnkName AS   FTBnkName ,
                            BCHL.FTBchName AS  FTBchName,
                            BBL.FTBbkCode AS FTBbkCode,
                            BBL.FTBbkName AS FTBbkName,
                            Chq.FDCreateOn

            FROM TFNMBookCheque Chq
            LEFT JOIN TFNMBookCheque_L ChqL ON ChqL.FTChqCode = Chq.FTChqCode AND ChqL.FNLngID = 1 AND Chq.FTBchCode = ChqL.FTBchCode
            LEFT JOIN TFNMBookBank BB ON Chq.FTBbkCode = BB.FTBbkCode AND Chq.FTBchCode = BB.FTBchCode
            LEFT JOIN TFNMBookBank_L BBL ON BBL.FTBbkCode = BB.FTBbkCode AND BBL.FTBchCode = BB.FTBchCode
            LEFT JOIN TFNMBank_L BL ON Chq.FTBbkCode = BL.FTBnkCode   AND BL.FNLngID = 1
            LEFT JOIN TCNMBranch_L  BCHL ON Chq.FTBchCode = BCHL.FTBchCode 
            AND BCHL.FNLngID =1  

                            WHERE 1=1 ";
        //end เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการ join TFNMBookCheque `และ TFNMBookCheque_L ด้วย 09/04/2020
       
        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (Chq.FTChqCode LIKE '%$tSearchList%'";
            $tSQL .= " OR ChqL.FTChqName LIKE '%$tSearchList%'";
            $tSQL .= " OR BBL.FTBbkName LIKE '%$tSearchList%'";
            $tSQL .= " OR BL.FTBnkName LIKE '%$tSearchList%'";
            $tSQL .= " OR BCHL.FTBchName LIKE '%$tSearchList%'";
            $tSQL .= " OR Chq.FNChqMin LIKE '%$tSearchList%'";
            $tSQL .= " OR Chq.FNChqMax LIKE '%$tSearchList%'";
            $tSQL .= " OR Chq.FTChqStaPrcDoc LIKE '%$tSearchList%')";
        }
        
        // $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
        // if($tStaUsrLevel == 'HQ'){
        //     $tSQL   .= "";
        // }else if($tStaUsrLevel == 'BCH'){
        //     $tBCH    = $this->session->userdata("tSesUsrBchCom");
        //     $tSQL   .= " AND Chq.FTBchCode = '$tBCH'";
        // }

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND Chq.FTBchCode IN ($tBchCode)
            ";
        }


        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";
        // echo $tSQL ;
        // exit;
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMBCQGetPageAll($tSearchList,$nLngID);
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
    
    //Functionality : Update 
    //Parameters : function parameters
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : 09/04/2020 surawat
    //Return : response
    //Return Type : Array
    public function FSaMBCQAddUpdateMaster($paData){
        try{
            //Update Master
            if(!empty($paData['tOldChqCode']) && !empty($paData['tOldBchCode'])){ // ถ้ามีการส่ง cheque code และ branch code เดิมมา แปลว่ากำลังแก้ไข cheque  08/04/2020 surawat
                $this->db->set('FTChqCode' , $paData['FTChqCode']);
                $this->db->set('FTBbkCode' , $paData['FTBbkCode']);
                $this->db->set('FTBchCode' , $paData['FTBchCode']);
                $this->db->set('FNChqMin' , $paData['FNChqMin']);
                $this->db->set('FNChqMax' , $paData['FNChqMax']);
                $this->db->set('FTChqStaAct', $paData['FTChqStaAct']);
                $this->db->set('FTChqStaPrcDoc' , $paData['FTChqStaPrcDoc']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FDCreateOn' , $paData['FDCreateOn']);
                $this->db->where('FTChqCode', $paData['tOldChqCode']); // Cheque code ที่กำลังจะแก้ไข. 08/04/2020 surawat
                $this->db->where('FTBchCode', $paData['tOldBchCode']); // Branch code ที่กำลังจะแก้ไข. 08/04/2020 surawat
                $this->db->update('TFNMBookCheque');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update Master.',
                    );
                }
            } else { //ถ้าไม่ส่ง cheque code และ branch code เดิมมา ถือเป็นการ add 08/04/2020 surawat
                //Add Master
                $this->db->insert('TFNMBookCheque',array(
                    
                    'FTChqCode' => $paData['FTChqCode'],
                    'FTBbkCode' => $paData['FTBbkCode'],
                    'FTBchCode' => $paData['FTBchCode'],
                    'FNChqMin' => $paData['FNChqMin'],
                    'FNChqMax' => $paData['FNChqMax'],
                    'FTChqStaAct' => $paData['FTChqStaAct'],
                    'FTChqStaPrcDoc' => $paData['FTChqStaPrcDoc'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FDLastUpdOn' => $paData['FDLastUpdOn']
                  
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
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : 09/04/2020 surawat
    //Return : response
    //Return Type : num
    public function FSaMBCQAddUpdateLang($paData){
        try{
            //Update Lang
            if(!empty($paData['tOldChqCode']) && !empty($paData['tOldBchCode'])){ // ถ้ามีการส่ง cheque code และ branch code เดิมมา แปลว่ากำลังแก้ไข cheque  08/04/2020 surawat
                // $this->db->where('FTChqCode', $paData['FTChqCode']);
                $this->db->set('FTChqCode' , $paData['FTChqCode']);
                $this->db->set('FTBchCode' , $paData['FTBchCode']);
                $this->db->set('FTChqName', $paData['FTChqName']);
                $this->db->set('FTChqRmk', $paData['FTChqRmk']);
                $this->db->where('FNLngID', $paData['FNLngID']);
                $this->db->where('FTChqCode', $paData['tOldChqCode']); // Cheque code ที่กำลังจะแก้ไข. 08/04/2020 surawat
                $this->db->where('FTBchCode', $paData['tOldBchCode']); // Branch code ที่กำลังจะแก้ไข. 08/04/2020 surawat
                $this->db->update('TFNMBookCheque_L');
                if($this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Lang Success.',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update Lang.',
                    );
                }
            } else { //ถ้าไม่ส่ง cheque code และ branch code เดิมมา ถือเป็นการ add 08/04/2020 surawat
                $this->db->insert('TFNMBookCheque_L',array(
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTChqCode' => $paData['FTChqCode'],
                    'FTChqName' => $paData['FTChqName'],
                    'FTChqRmk'  => $paData['FTChqRmk'],
                    'FNLngID'   => $paData['FNLngID']
                    
                   
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
    //Creator :  11/05/2018 Wasin
    //Last Modified : 09/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSnMBCQGetPageAll($ptSearchList,$ptLngID){
        
        //เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการ join TFNMBookCheque `และ TFNMBookCheque_L ด้วย 09/04/2020
        $tSQL = "SELECT COUNT (Chq.FTChqCode) AS counts
                 FROM   TFNMBookCheque Chq
                        LEFT JOIN TFNMBookCheque_L ChqL ON ChqL.FTChqCode = Chq.FTChqCode AND ChqL.FNLngID = $ptLngID AND Chq.FTBchCode = ChqL.FTBchCode
                        LEFT JOIN TFNMBookBank BB ON Chq.FTBbkCode = BB.FTBbkCode AND Chq.FTBchCode = BB.FTBchCode
                        LEFT JOIN TFNMBookBank_L BBL ON BBL.FTBbkCode = BB.FTBbkCode AND BBL.FTBchCode = BB.FTBchCode
                        LEFT JOIN TFNMBank_L BL ON Chq.FTBbkCode = BL.FTBnkCode   AND BL.FNLngID = $ptLngID
                        LEFT JOIN TCNMBranch_L  BCHL ON Chq.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $ptLngID  
                 WHERE 1=1 ";
        //end เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการ join TFNMBookCheque `และ TFNMBookCheque_L ด้วย 09/04/2020
        
        if($ptSearchList != ''){
            $tSQL .= " AND (Chq.FTChqCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR ChqL.FTChqName LIKE '%$ptSearchList%'";
            $tSQL .= " OR BBL.FTBbkName LIKE '%$ptSearchList%'";
            $tSQL .= " OR BL.FTBnkName LIKE '%$ptSearchList%'";
            $tSQL .= " OR BCHL.FTBchName LIKE '%$ptSearchList%'";
            $tSQL .= " OR Chq.FNChqMin LIKE '%$ptSearchList%'";
            $tSQL .= " OR Chq.FNChqMax LIKE '%$ptSearchList%'";
            $tSQL .= " OR Chq.FTChqStaPrcDoc LIKE '%$ptSearchList%')";
        }

        // $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
        // if($tStaUsrLevel == 'HQ'){
        //     $tSQL   .= "";
        // }else if($tStaUsrLevel == 'BCH'){
        //     $tBCH    = $this->session->userdata("tSesUsrBchCom");
        //     $tSQL   .= " AND Chq.FTBchCode = '$tBCH'";
        // }

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND Chq.FTBchCode IN ($tBchCode) ";
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
    //Creator : 15/05/2018 wasin
    //Last Modified : 08/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSoMBCQCheckDuplicate($ptBCHCode, $ptBCQCode){
        //เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการตรวจสอบ chque ซ้ำ 08/04/2020 surawat
        $tSQL = "SELECT COUNT(FTChqCode)   AS counts
                 FROM TFNMBookCheque
                 WHERE FTBchCode = '$ptBCHCode' AND FTChqCode = '$ptBCQCode' ";
        $oQuery = $this->db->query($tSQL);
        //end เปลี่ยนมาใช้ Branch Code และ Cheque Code ในการตรวจสอบ chque ซ้ำ 08/04/2020 surawat
        if($oQuery->num_rows() > 0){
            $oCountDup = $oQuery->result(); 
            $nStaDup    = $oCountDup[0]->counts;
            return $nStaDup  > 0 ? true : false;
        }else{
            return false;
        }
    }
    
    //Functionality : Delete Recive
    //Parameters : function parameters
    //Creator : 14/05/2018 wasin
    //Last Modified : 08/04/2020 surawat
    //Return : response
    //Return Type : array
    public function FSnMBCQDel($paData){

        $this->db->trans_begin();
        //สร้างเงื่อนไขในการค้นหาเชคแต่ละรายการ
        $tTargetBchCodeAndChqCodeSQLConditionList = [];
        foreach($paData as $aBchCodeAndChqCodeRow){
            $tTargetBchCodeAndChqCodeSQLConditionList[] = "(FTChqCode = '{$aBchCodeAndChqCodeRow['FTChqCode']}' AND FTBchCode = '{$aBchCodeAndChqCodeRow['FTBchCode']}')";
        }
        //end สร้างเงื่อนไขในการค้นหาเชคแต่ละรายการ
        //นำเงื่อนไขเช็คแต่ละก้อนมาต่อกัน เป็นเงื่อนไข ยาวๆ อันเดียว
        $tSQLDeleteCondition = '';
        if(FCNnHSizeOf($tTargetBchCodeAndChqCodeSQLConditionList) > 0){
            $tSQLDeleteCondition = ' WHERE ';
            $tSQLDeleteCondition .= implode(' OR ', $tTargetBchCodeAndChqCodeSQLConditionList);
        }
        //end นำเงื่อนไขเช็คแต่ละก้อนมาต่อกัน เป็นเงื่อนไข ยาวๆ อันเดียว
        $tSQL = "DELETE FROM TFNMBookCheque $tSQLDeleteCondition";
        $oQuery = $this->db->query($tSQL);

        $tSQL = "DELETE FROM TFNMBookCheque_L $tSQLDeleteCondition"; 
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
}


