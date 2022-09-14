<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mSmartLockerAdjustStatus extends CI_Model {
    
    /**
     * Functionality : List TRTTAdminHis Table
     * Parameters : $paParms is data for select filter
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSMLKAdjStaAdminHisList($paParams){
        
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tPosCode = $paParams['tPosCode'];
        $tRackCode = $paParams['tRackCode'];
        $tDate = $paParams['tDate'];
        $nLngID = $paParams['nLngID'];
        
        $tSQL = "   SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER(ORDER BY FDHisDateTime DESC) AS rtRowID, *
                        FROM
                        (
                        SELECT DISTINCT
                            ADHIS.FTBchCode,
                            BCHL.FTBchName,
                            ADHIS.FTShpCode,
                            ADHIS.FTPosCode,
                            SHPL.FTShpName,
                            SHPLAY.FTRakCode,
                            SHPRACK.FTRakName,
                            ADHIS.FDHisDateTime,
                            ADHIS.FTLayStaUse,
                            ADHIS.FTHisUsrCode,
                            USRL.FTUsrName AS FTHisUsrName

                        FROM TRTTAdminHis ADHIS WITH (NOLOCK)
                        LEFT JOIN TRTMShopLayout SHPLAY WITH (NOLOCK) ON ADHIS.FNHisLayNo = SHPLAY.FNLayNo AND SHPLAY.FTBchCode = ADHIS.FTBchCode AND SHPLAY.FTShpCode = ADHIS.FTShpCode
                        /*LEFT JOIN TRTTLockerStatus LKSTA WITH (NOLOCK) ON ADHIS.FNHisLayNo = LKSTA.FNLayNo AND LKSTA.FTBchCode = ADHIS.FTBchCode AND LKSTA.FTPosCode = ADHIS.FTPosCode*/
                        LEFT JOIN TRTMShopRack_L SHPRACK WITH (NOLOCK) ON SHPLAY.FTRakCode = SHPRACK.FTRakCode AND SHPRACK.FNLngID = $nLngID
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON ADHIS.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop_L SHPL WITH (NOLOCK) ON ADHIS.FTShpCode = SHPL.FTShpCode AND ADHIS.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON ADHIS.FTHisUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID    

                        WHERE ADHIS.FTHisType = '2'
                        AND ADHIS.FTBchCode IN ($tBchCode)
                        AND ADHIS.FTShpCode = '$tShpCode' 
                        AND ADHIS.FTPosCode = '$tPosCode'    
                ";
        
        if(!empty($tRackCode)){
            $tSQL .= " AND SHPLAY.FTRakCode = '$tRackCode'";
        }else{
            $tSQL .=    "   AND SHPLAY.FTRakCode IN (
                                SELECT DISTINCT
                                    SP.FTRakCode
                                FROM TRTMShopLayout SP WITH (NOLOCK)
                                LEFT JOIN TRTMShopRack_L RL ON SP.FTRakCode = RL.FTRakCode 
                                WHERE SP.FTBchCode IN ($tBchCode) AND SP.FTShpCode = '$tShpCode'
                            )
                        ";
        }
        
        if(!empty($tDate)){
            $tSQL .=    "   AND ADHIS.FDHisDateTime BETWEEN CONVERT(datetime,'$tDate 00:00:00') AND CONVERT(datetime,'$tDate 23:59:59')";
        }
        
        $tSQL .= " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMSMLKAdjStaGetAdminHisPageAll($paParams);
            $nFoundRow = FCNnHSizeOf($aFoundRow);
            $nPageAll = ceil($nFoundRow/$paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
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
     * Functionality : All Page Of TRTTAdminHis Table
     * Parameters : $ptSearchList, $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaGetAdminHisPageAll($paParams){
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tPosCode = $paParams['tPosCode'];
        $tRackCode = $paParams['tRackCode'];
        $tDate = $paParams['tDate'];
        
        $tSQL = "   SELECT DISTINCT
                        ADHIS.FTBchCode,
                        ADHIS.FTShpCode,
                        SHPLAY.FTRakCode,
                        ADHIS.FDHisDateTime
                    FROM TRTTAdminHis ADHIS
                    LEFT JOIN TRTMShopLayout SHPLAY WITH (NOLOCK) ON ADHIS.FNHisLayNo = SHPLAY.FNLayNo AND SHPLAY.FTBchCode = ADHIS.FTBchCode AND SHPLAY.FTShpCode = ADHIS.FTShpCode
                    WHERE ADHIS.FTHisType = '2'
                    AND ADHIS.FTBchCode IN ($tBchCode)
                    AND ADHIS.FTShpCode = '$tShpCode'   
                    AND ADHIS.FTPosCode = '$tPosCode'    
                ";    
        
        if(!empty($tRackCode)){
            $tSQL .=    "   AND SHPLAY.FTRakCode = '$tRackCode'";
        }else{
            $tSQL .=    "   AND SHPLAY.FTRakCode IN (
                                SELECT DISTINCT
                                    SP.FTRakCode
                                FROM TRTMShopLayout SP WITH (NOLOCK)
                                LEFT JOIN TRTMShopRack_L RL ON SP.FTRakCode = RL.FTRakCode 
                                WHERE 1=1 AND SP.FTBchCode IN ($tBchCode) AND SP.FTShpCode = '$tShpCode'
                            )
                        ";
        }
        
        if(!empty($tDate)){
            $tSQL .=    "   AND ADHIS.FDHisDateTime = '$tDate'";
        }
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        }else{
            // No Data
            return false;
        }
    }

    /**
     * Functionality : List Rack Channel
     * Parameters : $paParms is data for select filter
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSMLKAdjStaRackChannelList($paParams){
        
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tPosCode = $paParams['tPosCode'];
        $tRackCode = $paParams['tRackCode'];
        $tSessionID = $paParams['tSessionID'];
        $nLngID = $paParams['nLngID'];
        
        $tSQL = "   SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER(ORDER BY FNLayNo ASC) AS rtRowID, *
                        FROM
                        (
                        SELECT DISTINCT
                            SLY.FTBchCode,
                            SLY.FTMerCode,
                            SLY.FTShpCode,
                            SLY.FNLayNo,
                            SLY.FNLayScaleX,
                            SLY.FNLayScaleY,
                            SLY.FNLayRow,
                            SLY.FNLayCol,
                            SLY.FTPzeCode,
                            SLY.FTRakCode,
                            LKSTA.FTLayStaUse,
                            SRL.FTRakName,
                            BCL.FTBchName,
                            SPL.FTPosCode,
                            SLYL.FTLayName
                        
                        FROM TRTMShopLayout SLY WITH (NOLOCK)
                        LEFT JOIN TRTMShopLayout_L SLYL WITH (NOLOCK) ON SLY.FNLayNo = SLYL.FNLayNo AND SLY.FTShpCode = SLYL.FTShpCode AND SLYL.FNLngID = $nLngID
                        LEFT JOIN TCNMBranch_L BCL WITH (NOLOCK) ON SLY.FTBchCode = BCL.FTBchCode AND BCL.FNLngID = $nLngID
                        LEFT JOIN TRTMShopRack_L SRL WITH (NOLOCK) ON SLY.FTRakCode = SRL.FTRakCode AND SRL.FNLngID = $nLngID
                        LEFT JOIN TRTMShopPosLayout SPL WITH (NOLOCK) ON SLY.FNLayNo = SPL.FNLayNo AND SLY.FTBchCode = SPL.FTBchCode AND SLY.FTShpCode = SPL.FTShpCode AND SPL.FTPosCode = '$tPosCode'
                        LEFT JOIN TRTTLockerStatus LKSTA WITH (NOLOCK) ON SLY.FNLayNo = LKSTA.FNLayNo AND LKSTA.FTBchCode IN ($tBchCode) AND LKSTA.FTPosCode = '$tPosCode'
                        
                        WHERE SLY.FTBchCode IN ($tBchCode)
                        AND SLY.FTShpCode = '$tShpCode' 
                        AND SLY.FTRakCode = '$tRackCode'
                            
                        AND SLY.FNLayNo NOT IN (
                            SELECT
                                TMP.FNLayNo
                            FROM TsysMasTmp TMP
                            WHERE TMP.FTBchCode IN ($tBchCode)
                            AND TMP.FTShpCode = '$tShpCode' 
                            AND TMP.FTRakCode = '$tRackCode'
                            AND TMP.FTMttSessionID = '$tSessionID'    
                        )    
                ";
        
        $tSQL .= " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMSMLKAdjStaGetRackChannelPageAll($paParams);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
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
     * Functionality : All Page Of Rack Channel
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaGetRackChannelPageAll($paParams){
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tRackCode = $paParams['tRackCode'];
        $tSessionID = $paParams['tSessionID'];
        $nLngID = $paParams['nLngID'];
        
        $tSQL = "   SELECT 
                        COUNT (SLY.FNLayNo) AS counts
                    FROM TRTMShopLayout SLY
                    
                    WHERE SLY.FTBchCode IN ($tBchCode)
                    AND SLY.FTShpCode = '$tShpCode' 
                    AND SLY.FTRakCode = '$tRackCode' 
                        
                    AND SLY.FNLayNo NOT IN (
                        SELECT
                            TMP.FNLayNo
                        FROM TsysMasTmp TMP
                        WHERE TMP.FTBchCode IN ($tBchCode)
                        AND TMP.FTShpCode = '$tShpCode' 
                        AND TMP.FTRakCode = '$tRackCode'
                        AND TMP.FTMttSessionID = '$tSessionID'    
                    )     
                ";
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            // No Data
            return false;
        }
    }
    
    /**
     * Functionality : List TRTTAdminHis Table
     * Parameters : $paParms is data for select filter
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSMLKAdjStaTempList($paParams){
        
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tRackCode = $paParams['tRackCode'];
        $tSessionID = $paParams['tSessionID'];
        $tTableKey = $paParams['tTableKey'];
        $nLngID = $paParams['nLngID'];
        
        $tSQL = "   SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER(ORDER BY FNLayNo ASC) AS rtRowID, *
                        FROM
                        (
                        SELECT DISTINCT
                            TMP.FTBchCode,
                            TMP.FTMerCode,
                            TMP.FTShpCode,
                            TMP.FTRakCode,
                            TMP.FNLayNo,
                            TMP.FNLayRow,
                            TMP.FNLayCol,
                            TMP.FTLayStaUse,
                            TMP.FTPosCode
                            
                        FROM TsysMasTmp TMP WITH (NOLOCK)

                        WHERE TMP.FTBchCode IN ($tBchCode)
                        AND TMP.FTShpCode = '$tShpCode'
                        AND TMP.FTMttSessionID = '$tSessionID'  
                        AND TMP.FTMttTableKey = '$tTableKey'     
                ";
        
        if(!empty($tRackCode)){
            $tSQL .= " AND TMP.FTRakCode = '$tRackCode'";
        }
        
        $tSQL .= " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMSMLKAdjStaGetTempPageAll($paParams);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
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
     * Functionality : All Page Of TRTTAdminHis Table
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaGetTempPageAll($paParams){
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tRackCode = $paParams['tRackCode'];
        $tSessionID = $paParams['tSessionID'];
        $tTableKey = $paParams['tTableKey'];
        
        $tSQL = "   SELECT 
                        COUNT (TMP.FTBchCode) AS counts
                    FROM TsysMasTmp TMP
                    WHERE TMP.FTBchCode IN ($tBchCode)
                    AND TMP.FTShpCode = '$tShpCode'  
                    AND TMP.FTMttSessionID = '$tSessionID'   
                    AND TMP.FTMttTableKey = '$tTableKey'
                ";    
        
        if(!empty($tRackCode)){
            $tSQL .= " AND TMP.FTRakCode = '$tRackCode'";
        }
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            // No Data
            return false;
        }
    }
    
    /**
     * Functionality : เพิ่มหมายเลขช่อง ของตู้ ไปยัง Temp
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaRackChannelToTemp($paParams){
        
        $paData = $paParams['aData'];
        $tAdjChannelStatus = $paParams['tAdjChannelStatus'];
        
        $this->db->insert('TsysMasTmp', array(
            
            'FTMttTableKey' => $paData['FTMttTableKey'],
            'FTBchCode' => $paData['FTBchCode'],
            'FTMerCode' => $paData['FTMerCode'],
            'FTShpCode' => $paData['FTShpCode'],
            'FTPosCode' => $paData['FTPosCode'],
            'FTRakCode' => $paData['FTRakCode'],
            'FNLayNo' => $paData['FNLayNo'],
            'FNLayRow' => $paData['FNLayRow'],
            'FNLayCol' => $paData['FNLayCol'],
            'FTLayStaUse' => $tAdjChannelStatus,
            'FTMttSessionID' => $paData['FTMttSessionID'],
            
            'FDCreateOn' => $paData['FDCreateOn'],
            'FTCreateBy' => $paData['FTCreateBy'],
            'FDLastUpdOn' => $paData['FDCreateOn'],
            'FTLastUpdBy' => $paData['FTCreateBy']
        ));
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add POS SHOP Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit POS SHOP',
            );
        }
        
    }
    
    /**
     * Functionality : เพิ่มหมายเลขช่อง ของตู้ จาก TRTTAdminHis ไปยัง Temp
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaAdminHisToTemp($paParams){
        
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tPosCode = $paParams['tPosCode'];
        $tRackCode = $paParams['tRackCode'];
        $tHisDate = $paParams['tHisDate'];
        $tTableKey = $paParams['tTableKey'];
        $tSessionID = $paParams['tSessionID'];
        $nLngID = $paParams['nLngID'];
        
        
        $tSQL =     "   INSERT TsysMasTmp 
                        (FTBchCode, FTShpCode, FTPosCode, FTRakCode, FNLayNo, FNLayRow, FNLayCol, FTLayStaUse, FTMttTableKey, FTMttSessionID)
                    ";

        $tSQL .=    "   SELECT DISTINCT
                            ADHIS.FTBchCode, 
                            ADHIS.FTShpCode, 
                            ADHIS.FTPosCode, 
                            SHPLAY.FTRakCode,  
                            ADHIS.FNHisLayNo AS FNLayNo,
                            SHPLAY.FNLayRow,
                            SHPLAY.FNLayCol,
                            ADHIS.FTLayStaUse,
                            '$tTableKey' AS FTMttTableKey,
                            '$tSessionID' AS FTMttSessionID
                        FROM TRTTAdminHis ADHIS WITH (NOLOCK) 

                        LEFT JOIN TRTMShopLayout SHPLAY WITH (NOLOCK) ON ADHIS.FNHisLayNo = SHPLAY.FNLayNo AND SHPLAY.FTBchCode IN ($tBchCode) AND SHPLAY.FTShpCode = '$tShpCode'
                        LEFT JOIN TRTMShopRack_L SHPRACK WITH (NOLOCK) ON SHPLAY.FTRakCode = SHPRACK.FTRakCode AND SHPRACK.FNLngID = $nLngID 
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON ADHIS.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                        LEFT JOIN TCNMShop_L SHPL WITH (NOLOCK) ON ADHIS.FTShpCode = SHPL.FTShpCode AND ADHIS.FTBchCode = SHPL.FTBchCode  AND SHPL.FNLngID = $nLngID 

                        WHERE ADHIS.FTBchCode IN ($tBchCode) 
                        AND ADHIS.FTShpCode = '$tShpCode' 
                        AND ADHIS.FTPosCode = '$tPosCode'
                        AND SHPLAY.FTRakCode = '$tRackCode'
                        AND ADHIS.FDHisDateTime = '$tHisDate'
                    ";
        
        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }
        return $aStatus;
        
    }
    
    /**
     * Functionality : ลบหมายเลขช่อง ของตู้ ใน Temp
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaDelRackChannelInTemp($paParams){
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tRackCode = $paParams['tRackCode'];
        $nLayNo = $paParams['nLayNo'];
        $nLayRow = $paParams['nLayRow'];
        $nLayCol = $paParams['nLayCol'];
        $tSessionID = $paParams['tSessionID'];
        $tTableKey = $paParams['tTableKey'];
        
        $this->db->where_in('FTBchCode', $tBchCode);
        $this->db->where('FTShpCode', $tShpCode);
        $this->db->where('FTRakCode', $tRackCode);
        $this->db->where('FNLayNo', $nLayNo);
        $this->db->where('FNLayRow', $nLayRow);
        $this->db->where('FNLayCol', $nLayCol);
        $this->db->where('FTMttSessionID', $tSessionID);
        $this->db->where('FTMttTableKey', $tTableKey);
        $this->db->delete('TsysMasTmp');
    }
    
    /**
     * Functionality : ล้างหมายเลขช่อง ของตู้ ใน Temp
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaClearRackChannelInTemp($paParams){
        $tSessionID = $paParams['tSessionID'];
        $tTableKey = $paParams['tTableKey'];
        
        $this->db->where('FTMttSessionID', $tSessionID);
        $this->db->where('FTMttTableKey', $tTableKey);
        $this->db->delete('TsysMasTmp');
    }
    
    /**
     * Functionality : ปรับปรุง สถานะการใช้ ใน Temp
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMSMLKAdjStaUpdateStaUseInTemp($paParams){
        $tSessionID = $paParams['tSessionID'];
        $tTableKey = $paParams['tTableKey'];
        $tAdjStaUse = $paParams['tAdjStaUse'];
        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tRackCode = $paParams['tRackCode'];
        
        $this->db->set('FTLayStaUse', $tAdjStaUse);
        $this->db->where('FTMttSessionID', $tSessionID);
        $this->db->where('FTMttTableKey', $tTableKey);
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->where('FTShpCode', $tShpCode);
        $this->db->where('FTRakCode', $tRackCode);
        $this->db->update('TsysMasTmp');

        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Update Fail',
            );
        }
        return $aStatus;
        
    }
    
    /**
     * Functionality : Get Rack Channel In Temp
     * Parameters : $paParams
     * Creator : 11/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSMLKAdjStatusGetRackChannelInTemp($paParams) {

        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];
        $tRackCode = $paParams['tRackCode'];
        $tSessionID = $paParams['tSessionID'];
        $tTableKey = $paParams['tTableKey'];
        $nLngID = $paParams['nLngID'];

        $tSQL = "   SELECT
                        TMP.FTBchCode,
                            TMP.FTMerCode,
                            TMP.FTShpCode,
                            TMP.FTRakCode,
                            TMP.FNLayNo,
                            TMP.FNLayRow,
                            TMP.FNLayCol,
                            TMP.FTLayStaUse,
                            TMP.FTPosCode
                            
                        FROM TsysMasTmp TMP WITH (NOLOCK)

                        WHERE TMP.FTBchCode IN ($tBchCode)
                        AND TMP.FTShpCode = '$tShpCode'
                        AND TMP.FTMttSessionID = '$tSessionID'  
                        AND TMP.FTMttTableKey = '$tTableKey'
                ";
        
        if(!empty($tRackCode)){
            $tSQL .= " AND TMP.FTRakCode = '$tRackCode'";
        }
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) {
            $aDataReturn = array(
                'aItems' => $oQuery->result_array(),
                'rtCode' => '1',
                'rtDesc' => 'Data Found',
            );
        } else {
            $aDataReturn = array(
                'rtCode' => '800',
                'rtDesc' => 'Not Found',
            );
        }
        return $aDataReturn;
    }
    
    /**
     * Functionality : Insert Or Update TRTTLockerStatus
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : Status insert or update
     * Return Type : array
     */
    public function FSaMCreditNoteInsertOrUpdateToLockerStatus($paData, $paParams){
        
        $tSQL = "   SELECT 
                        LKSTA.FTBchCode,
                        LKSTA.FTPosCode,
                        LKSTA.FNLayNo,
                        LKSTA.FTLayStaUse
                    FROM TRTTLockerStatus LKSTA WITH (NOLOCK)
                    
                    WHERE LKSTA.FTBchCode = '".$paData['FTBchCode']."' 
                    AND LKSTA.FTPosCode = '".$paData['FTPosCode']."'
                    AND LKSTA.FNLayNo = '".$paData['FNLayNo']."'   
                ";
            
        $oQuery = $this->db->query($tSQL);
            
        if($oQuery->num_rows() > 0){ // ปรับปรุงรายการที่มีอยู่แล้ว

            $aResult = $oQuery->row_array();

            $tSQL = "   UPDATE TRTTLockerStatus
                        SET
                            FTLayStaUse = '".$paParams['tAdjChannelStatus']."',
                            FDLastUpdOn = '".$paParams['dLastUpdOn']."',    
                            FTLastUpdBy = '".$paParams['dLastUpdBy']."'  
                                
                        WHERE FTBchCode = '".$aResult['FTBchCode']."' 
                        AND FTPosCode = '".$aResult['FTPosCode']."'
                        AND FNLayNo = '".$aResult['FNLayNo']."'
                    ";

            $this->db->query($tSQL);
            
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success.',
            );

        }else{

            // เพิ่มรายการใหม่
            $this->db->insert('TRTTLockerStatus', array(
                'FTBchCode' => $paData['FTBchCode'],
                'FTPosCode' => $paData['FTPosCode'],
                'FNLayNo' => $paData['FNLayNo'],
                'FTLayStaUse' => $paParams['tAdjChannelStatus'],
                
                'FDLastUpdOn' => $paParams['dLastUpdOn'],
                'FTLastUpdBy' => $paParams['dLastUpdBy'],
                'FDCreateOn' => $paParams['dCreateOn'],
                'FTCreateBy' => $paParams['dCreateBy']
            ));

            $this->db->last_query();  

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add.',
                );
            }
        }
        return $aStatus;

    }
    
    /**
     * Functionality : Insert to TRTTAdminHis
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : Status insert or update
     * Return Type : array
     */
    public function FSaMCreditNoteInsertToAdminHis($paData, $paParams){
        
        $this->db->insert('TRTTAdminHis', array(
            'FTBchCode' => $paData['FTBchCode'],
            'FTShpCode' => $paData['FTShpCode'],
            'FTPosCode' => $paData['FTPosCode'],
            'FNHisLayNo' => $paData['FNLayNo'],
            'FTLayStaUse' => $paParams['tAdjChannelStatus'],
            'FTHisUsrCode' => $paParams['dCreateBy'],
            'FDHisDateTime' => $paParams['dCreateOn'],
            'FTHisCstTel' => '',
            'FTHisType' => '2', // ประเภท transaction : 1 เปิด 2 ปรับสถานะ
            'FDLastUpdOn' => $paParams['dLastUpdOn'],
            'FTLastUpdBy' => $paParams['dLastUpdBy'],
            'FDCreateOn' => $paParams['dCreateOn'],
            'FTCreateBy' => $paParams['dCreateBy']
        ));

        $this->db->last_query();  

        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }
        return $aStatus;
        
    }
    
    /**
     * Functionality : เรียกข้อมูลสาขาด้วย BchCode
     * Parameters : $paParams
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMLKAdjStaGetBchByCode($paParams){
        $tBchCode = $paParams['tBchCode'];
        $nLngID = $paParams['nLngID'];
        
        $tSQL = "   SELECT 
                        BCH.FTBchCode,
                        BCHL.FTBchName
                    FROM TCNMBranch BCH WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    WHERE BCH.FTBchCode = '$tBchCode'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
        }else{
            $aDetail = [];
        }

        return $aDetail;
    }
    
    /**
     * Functionality : Get Rack
     * Parameters : $paParams
     * Creator : 11/07/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSMLKAdjStatusGetRack($paParams) {

        $tBchCode = $paParams['tBchCode'];
        $tShpCode = $paParams['tShpCode'];

        $tSQL = "   SELECT DISTINCT
                        SP.FTRakCode, 
                        RL.FTRakName 
                    FROM TRTMShopLayout SP WITH (NOLOCK)
                    LEFT JOIN TRTMShopRack_L RL ON SP.FTRakCode = RL.FTRakCode 
                    WHERE 1=1 AND SP.FTBchCode IN ($tBchCode) AND SP.FTShpCode = '$tShpCode'
                ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn = array(
                'aItems' => $oQuery->result_array(),
                'rtCode' => '1',
                'rtDesc' => 'Data Found',
            );
        } else {
            $aDataReturn = array(
                'rtCode' => '800',
                'rtDesc' => 'Not Found',
            );
        }
        return $aDataReturn;
    }

}







