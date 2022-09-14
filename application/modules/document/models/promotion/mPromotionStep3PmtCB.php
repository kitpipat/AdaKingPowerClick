<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep3PmtCB extends CI_Model
{
    /**
     * Functionality : Get PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtCB
     * Return Type : Array
     */
    public function FSaMGetPmtCBInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTPmdGrpName ASC, FNPbySeq ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmhDocNo,
                        TMP.FNPbySeq,
                        TMP.FTPmdGrpName,
                        TMP.FTPbyStaCalSum,
                        TMP.FTPbyStaBuyCond,
                        TMP.FTPbyStaPdtDT,
                        TMP.FCPbyPerAvgDis,
                        TMP.FCPbyMinSetPri,
                        TMP.FCPbyMinValue,
                        TMP.FCPbyMaxValue,
                        TMP.FTPbyMinTime,
                        TMP.FTPbyMaxTime,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtCB_Tmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPmtCBInTmpPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Count PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtCB
     * Return Type : Number
     */
    public function FSnMTFWGetPmtCBInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTPdtPmtCB_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert PmtCB to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPmtCBToTemp($paParams = [])
    {
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];
        $tGroupNameInBuy = empty($paParams['tGroupNameInBuy']) ? "'NOTFOUND'" : $paParams['tGroupNameInBuy'];
        $tPbyStaBuyCond = $paParams['tPbyStaBuyCond']; // เงื่อนไขการซื้อ
        $bIsAlwPmtDisAvg = $paParams['bIsAlwPmtDisAvg'];
        // $bStaSpcGrpDisIsDisSomeGroup = $paParams['bStaSpcGrpDisIsDisSomeGroup'];

        $nPercentDis = 0;
        if($bIsAlwPmtDisAvg){
            $nPercentDis = 100;
        }
        /* if($bStaSpcGrpDisIsDisSomeGroup){ // สถานะการให้ส่วนลดเฉพาะกลุ่มทีได้รับ  (1=ให้ส่วนลดเฉพาะกลุ่ม 2=ให้ทั้งหมด รวมไม่เกิน 100%)
            $nPercentDis = 0;
        } */

        $tSQL = "   
            INSERT TCNTPdtPmtCB_Tmp
                (FTBchCode,
                FTPmhDocNo,
                FNPbySeq,
                FTPmdGrpName,
                FTPbyStaCalSum,
                FTPbyStaBuyCond,
                FTPbyStaPdtDT,
                FCPbyPerAvgDis,
                FCPbyMinSetPri,
                FCPbyMinValue,
                FCPbyMaxValue,
                FTPbyMinTime,
                FTPbyMaxTime,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT TOP 1
                PMTDT.FTBchCode,
                PMTDT.FTPmhDocNo,
                (SELECT (ISNULL(MAX(FNPbySeq), 0) + 1) AS FNPbySeq FROM TCNTPdtPmtCB_Tmp WITH(NOLOCK) WHERE FTSessionID = '$tUserSessionID' AND FTBchCode = '$tBchCodeLogin') AS FNPbySeq,
                PMTDT.FTPmdGrpName,
                '' AS FTPbyStaCalSum,
                '$tPbyStaBuyCond' AS FTPbyStaBuyCond,
                PMTDT.FTPmdStaListType AS FTPbyStaPdtDT,
                
                (
                CASE 
                    WHEN
                        (
                            (SELECT 
                                ISNULL(SUM(FCPbyPerAvgDis),0)
                            FROM TCNTPdtPmtCB_Tmp WITH(NOLOCK) 
                            WHERE FTSessionID = '$tUserSessionID'
                            )
                            +
                            (SELECT
                                ISNULL(SUM(FCPgtPerAvgDis),0)
                            FROM TCNTPdtPmtCG_Tmp WITH(NOLOCK) 
                            WHERE FTSessionID = '$tUserSessionID'
                            AND FTPmdGrpName IS NOT NULL 
                            AND FTPmdGrpName <> ''
                            )
                        ) = 0
                    THEN $nPercentDis
                    ELSE 0 
                END      
                ) AS FCPbyPerAvgDis,

                0 AS FCPbyMinSetPri,
                0 AS FCPbyMinValue,
                0 AS FCPbyMaxValue,
                '' AS FTPbyMinTime,
                '' AS FTPbyMaxTime,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtDT_Tmp PMTDT WITH(NOLOCK)
            WHERE PMTDT.FTPmdGrpName = '$tGroupNameInBuy'
        ";

        $this->db->query($tSQL);

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert PmtCB Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert PmtCB Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update PmtCB Value in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtCBInTmpBySeq($paParams = [])
    {
        $this->db->set('FCPbyMinValue', $paParams['tPbyMinValue']);
        $this->db->set('FCPbyMaxValue', $paParams['tPbyMaxValue']);
        $this->db->set('FCPbyMinSetPri', $paParams['tPbyMinSetPri']);
        $this->db->set('FCPbyPerAvgDis', $paParams['tPgtPerAvgDisCB']);
        $this->db->set('FTPbyMinTime', $paParams['tPbyMinTime']);
        $this->db->set('FTPbyMaxTime', $paParams['tPbyPbyMaxTime']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNPbySeq', $paParams['nSeqNo']);
        $this->db->update('TCNTPdtPmtCB_Tmp');

        $tUserSessionID = $paParams['tUserSessionID'];
        $tFieldName = $paParams['tFieldName'];
        $tFormatType = $paParams['tFormatType'];
        $nSeqNo = $paParams['nSeqNo'];
        $tFieldValue = "";
        $aFieldValue = [];

        if($tFormatType == "D"){
            $tFieldName = "FTPbyMinTime, FTPbyMaxTime";
        }

        if (!empty($tFieldName)) {
            $tSQL = "
                SELECT 
                    $tFieldName
                FROM TCNTPdtPmtCB_Tmp WITH(NOLOCK) 
                WHERE FTSessionID = '$tUserSessionID'
                AND FNPbySeq = $nSeqNo
            ";
            $oQuery = $this->db->query($tSQL);
            
            if($tFormatType != "D"){
                $tFieldValue = $oQuery->row()->$tFieldName;
            }

            switch ($tFormatType) {
                case "N": {
                    $tFieldValue = number_format($tFieldValue, 0);
                    break;
                }
                case "C": {
                    $tFieldValue = number_format($tFieldValue, $paParams["nOptDecimalShow"]);
                    break;
                }
                case "D": {
                    $aTime = explode(':', $oQuery->row()->FTPbyMinTime);
                    $tHr = isset($aTime[0]) && !empty($aTime[0])?$aTime[0]:"";
                    $tMin = isset($aTime[1]) && !empty($aTime[0])?$aTime[1]:"";
                    $aFieldValue['timeForm']['tHr'] = $tHr;
                    $aFieldValue['timeForm']['tMin'] = $tMin;

                    $aTime = explode(':', $oQuery->row()->FTPbyMaxTime);
                    $tHr = isset($aTime[0]) && !empty($aTime[0])?$aTime[0]:"";
                    $tMin = isset($aTime[1]) && !empty($aTime[0])?$aTime[1]:"";
                    $aFieldValue['timeTo']['tHr'] = $tHr;
                    $aFieldValue['timeTo']['tMin'] = $tMin;
                    break;
                }
            }
        }
        return ($tFormatType == "D")? $aFieldValue : $tFieldValue;
    }

    /**
     * Functionality : Update PmtCB Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtCBInTmp($paParams = [])
    {
        $this->db->set('FTPmdGrpName', $paParams['tPmtGroupNameTmp']);
        $this->db->where('FTPmdGrpName', $paParams['tPmtGroupNameTmpOld']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtCB_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PmtCB in Temp by Group Name
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePmtCBInTmpByGroupName($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTPmdGrpName', $paParams['tGroupNameInBuy']);
        $this->db->delete('TCNTPdtPmtCB_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PmtCB in Temp by Seq
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePmtCBAndCGInTmpBySeq($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNPbySeq', $paParams['tCbSeqNo']);
        $this->db->delete('TCNTPdtPmtCB_Tmp');

        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNPgtSeq', $paParams['tCgSeqNo']);
        $this->db->delete('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPmtCBInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtCB_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Get PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtCB
     * Return Type : Array
     */
    public function FSaMGetPmtCBWithPmtCGInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $nLngID = $paParams['FNLngID'];

        $this->FMxMRPTSetPriorityGroup($paParams);

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTPmdGrpName ASC, FNPbySeq ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        CBTMP.FTBchCode,
                        CBTMP.FTPmhDocNo,
                        CBTMP.FNPbySeq,
                        CBTMP.FTPmdGrpName,
                        CBTMP.FTPbyStaCalSum,
                        CBTMP.FTPbyStaBuyCond,
                        CBTMP.FTPbyStaPdtDT,
                        CBTMP.FCPbyPerAvgDis,
                        CBTMP.FCPbyMinSetPri,
                        CBTMP.FCPbyMinValue,
                        CBTMP.FCPbyMaxValue,
                        CBTMP.FTPbyMinTime,
                        CBTMP.FTPbyMaxTime,
                        CBTMP.FTSessionID,
                        CBTMP.FNRowPartID,
                        CGTMP.FNPgtSeq,
                        CGTMP.FTPplCode,
                        PPLL.FTPplName,
                        CGTMP.FTPgtStaGetType,
                        CGTMP.FCPgtGetvalue,
                        CGTMP.FCPgtPerAvgDis,
                        CGTMP.FCPgtGetQty,
                        COUNTGN.FNCountGroupName
                    FROM TCNTPdtPmtCB_Tmp CBTMP WITH(NOLOCK)
                    LEFT JOIN TCNTPdtPmtCG_Tmp CGTMP WITH(NOLOCK) ON CGTMP.FNPgtSeq = CBTMP.FNPbySeq AND CGTMP.FTPmdGrpName = CBTMP.FTPmdGrpName AND CGTMP.FTSessionID = CBTMP.FTSessionID
                    LEFT JOIN TCNMPdtPriList_L PPLL WITH(NOLOCK) ON PPLL.FTPplCode = CGTMP.FTPplCode AND PPLL.FNLngID = $nLngID
                    LEFT JOIN(
                        SELECT
                            COUNT(FTPmdGrpName) AS FNCountGroupName,
                            FTPmdGrpName
                        FROM TCNTPdtPmtCB_Tmp WITH(NOLOCK)
                        WHERE FTSessionID = '$tUserSessionID'
                        GROUP BY FTPmdGrpName   
                    ) AS COUNTGN ON COUNTGN.FTPmdGrpName = CBTMP.FTPmdGrpName
                    WHERE CBTMP.FTSessionID = '$tUserSessionID'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPmtCBInTmpPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality: Set Priority Group
     * Parameters:  Function Parameter
     * Creator: 26/02/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = " 
            UPDATE DATAUPD SET 
                DATAUPD.FNRowPartID = B.PartID
            FROM TCNTPdtPmtCB_Tmp AS DATAUPD WITH(NOLOCK)
            INNER JOIN(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTPmdGrpName ORDER BY FTPmdGrpName ASC, FNPbySeq ASC) AS PartID,
                    FNPbySeq
                FROM TCNTPdtPmtCB_Tmp WITH(NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
            ) AS B
            ON DATAUPD.FNPbySeq = B.FNPbySeq
            WHERE DATAUPD.FTSessionID = '$tUserSessionID'
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Count PmtCB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtCB
     * Return Type : Number
     */
    public function FSnMTFWGetPmtCBWithPmtCGInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                CBTMP.FTSessionID
            FROM TCNTPdtPmtCB_Tmp CBTMP WITH(NOLOCK) 
            LEFT JOIN TCNTPdtPmtCG_Tmp CGTMP WITH(NOLOCK) ON CGTMP.FTPmdGrpName = CBTMP.FTPmdGrpName AND CGTMP.FTSessionID = CBTMP.FTSessionID
            WHERE CBTMP.FTSessionID = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert PmtCB to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPmtCBWithPmtCGPmtCBToTemp($paParams = [])
    {
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];
        $tGroupName = $paParams['tGroupName'];
        $tPbyStaBuyCond = $paParams['tPbyStaBuyCond']; // เงื่อนไขการซื้อ
        $tPbyMaxValueLastRow = str_replace(",","",$paParams['tPbyMaxValueLastRow']);
        $nOptDecimalShow = $paParams['nOptDecimalShow'];

        $cPbyMinValue = 0;
        if(in_array($tPbyStaBuyCond, ["3","4"]) && !empty($tPbyMaxValueLastRow)){ // หากเป็น 3:ช่วงจำนวน หรือ 4:ช่วงมูลค่า
            $tAddVal = '0.'.str_pad(0, $nOptDecimalShow-1, '0', STR_PAD_RIGHT).'1';
            $cPbyMinValue = floatval($tPbyMaxValueLastRow) + floatval($tAddVal);
        }

        $tSQL = "   
            INSERT TCNTPdtPmtCB_Tmp
                (FTBchCode,
                FTPmhDocNo,
                FNPbySeq,
                FTPmdGrpName,
                FTPbyStaCalSum,
                FTPbyStaBuyCond,
                FTPbyStaPdtDT,
                FCPbyPerAvgDis,
                FCPbyMinSetPri,
                FCPbyMinValue,
                FCPbyMaxValue,
                FTPbyMinTime,
                FTPbyMaxTime,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT TOP 1
                PMTDT.FTBchCode,
                PMTDT.FTPmhDocNo,
                (SELECT (ISNULL(MAX(FNPbySeq), 0) + 1) AS FNPbySeq FROM TCNTPdtPmtCB_Tmp WITH(NOLOCK) WHERE FTSessionID = '$tUserSessionID') AS FNPbySeq,
                PMTDT.FTPmdGrpName,
                '' AS FTPbyStaCalSum,
                '$tPbyStaBuyCond' AS FTPbyStaBuyCond,
                PMTDT.FTPmdStaListType AS FTPbyStaPdtDT,

                /*(
                CASE 
                    WHEN
                        (
                            (SELECT 
                                ISNULL(SUM(FCPbyPerAvgDis),0)
                            FROM TCNTPdtPmtCB_Tmp WITH(NOLOCK) 
                            WHERE FTSessionID = '$tUserSessionID'
                            )
                        ) = 0
                    THEN 50
                    ELSE 0 
                END      
                ) AS FCPbyPerAvgDis,*/

                0 AS FCPbyPerAvgDis,            
                0 AS FCPbyMinSetPri,
                $cPbyMinValue AS FCPbyMinValue,
                0 AS FCPbyMaxValue,
                '' AS FTPbyMinTime,
                '' AS FTPbyMaxTime,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtDT_Tmp PMTDT WITH(NOLOCK)
            WHERE PMTDT.FTPmdGrpName = '$tGroupName'
        ";

        $this->db->query($tSQL);

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert PmtCB Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert PmtCB Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Insert PmtCG to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPmtCBWithPmtCGPmtCGToTemp($paParams = [])
    {
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];
        $tGroupName = $paParams['tGroupName'];
        $tPbyStaBuyCond = $paParams['tPbyStaBuyCond']; // เงื่อนไขการซื้อ
        $bStaGrpPriorityIsPriceGroup = $paParams['bStaGrpPriorityIsPriceGroup'];
        $bIsAlwPmtDisAvg = $paParams['bIsAlwPmtDisAvg'];

        $tPgtStaGetType = "1"; // Default 1:ลดบาท (1:ลดบาท 2:ลด% 3:ปรับราคา 4:.ใช้กลุ่มราคา 5:แถม(Free) 6:ไม่กำหนด)
        if($bStaGrpPriorityIsPriceGroup){ // เลือกกลุ่มคำนวนโปรโมชั่น เป็น 0 (0.Price Group  1.The Best  2.Forced)
            $tPgtStaGetType = "4"; // 4: ใช้กลุ่มราคา
        }

        $nPercentDis = 0;
        if($bIsAlwPmtDisAvg){
            $nPercentDis = 100;
        }

        $tSQL = "   
            INSERT TCNTPdtPmtCG_Tmp
                (FTBchCode,
                FTPmhDocNo,
                FNPgtSeq,
                FTPmdGrpName,
                FTPgtStaGetEffect,
                FTPgtStaGetType,
                FTPgtStaGetPdt,
                FTRolCode,
                FCPgtGetvalue,
                FTPplCode,
                FCPgtGetQty,
                FCPgtPerAvgDis,
                FTPgtStaPoint,
                FTPgtStaPntCalType,
                FTPgtStaPdtDT,
                FNPgtPntGet,
                FNPgtPntBuy,
                FTPgtStaCoupon,
                FTPgtCpnText,
                FTCphDocNo,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT TOP 1
                PMTDT.FTBchCode,
                PMTDT.FTPmhDocNo,
                
                (SELECT 
                    (
                    CASE
                        WHEN ISNULL(MAX(FNPgtSeq), 0) < 0 THEN 0
                        ELSE ISNULL(MAX(FNPgtSeq), 0)
                    END 
                    + 1
                    ) AS FNPgtSeq 
                FROM TCNTPdtPmtCG_Tmp WITH(NOLOCK) 
                WHERE FTSessionID = '$tUserSessionID'
                ) AS FNPgtSeq,

                PMTDT.FTPmdGrpName,
                '' AS FTPgtStaGetEffect,
                '$tPgtStaGetType' AS FTPgtStaGetType,
                '' AS FTPgtStaGetPdt,
                '' AS FTRolCode,
                0 AS FCPgtGetvalue,
                '' AS FTPplCode,
                0 AS FCPgtGetQty,

                /*(
                CASE 
                    WHEN
                        (
                            (SELECT
                                ISNULL(SUM(FCPgtPerAvgDis),0)
                            FROM TCNTPdtPmtCG_Tmp WITH(NOLOCK) 
                            WHERE FTSessionID = '$tUserSessionID'
                            AND FTPmdGrpName IS NOT NULL 
                            AND FTPmdGrpName <> ''
                            )
                        ) = 0
                    THEN 50
                    ELSE 0 
                END      
                ) AS FCPgtPerAvgDis,*/

                $nPercentDis AS FCPgtPerAvgDis,            
                '' AS FTPgtStaPoint,
                0 AS FTPgtStaPntCalType,
                PMTDT.FTPmdStaListType AS FTPgtStaPdtDT,
                0 AS FNPgtPntGet,
                0 AS FNPgtPntBuy,
                '' AS FTPgtStaCoupon,
                '' AS FTPgtCpnText,
                '' AS FTCphDocNo,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtDT_Tmp PMTDT WITH(NOLOCK)
            WHERE PMTDT.FTPmdGrpName = '$tGroupName'
        ";

        $this->db->query($tSQL);

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert PmtCB Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert PmtCB Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Get PmtCB With PmtCG PgtPerAvgDis On CB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Sum PmtCB With PmtCG PgtPerAvgDis
     * Return Type : float
     */
    public function FScMGetPmtCBAndPmtCGPgtPerAvgDisOnCBInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nSeqNo = $paParams['nSeqNo'];
        $cPgtPerAvgDisCB = 0.00;
        $cPgtPerAvgDisCG = 0.00;

        // PgtPerAvgDisCB
        $tSQL = "
            SELECT 
                ISNULL(SUM(FCPbyPerAvgDis),0) AS FCPgtPerAvgDisCB
            FROM TCNTPdtPmtCB_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FNPbySeq NOT IN($nSeqNo)
        ";

        $oQuery = $this->db->query($tSQL);
        $cPgtPerAvgDisCB = $oQuery->row()->FCPgtPerAvgDisCB;

        // PgtPerAvgDisCG
        $tSQL = "
            SELECT 
                ISNULL(SUM(FCPgtPerAvgDis),0) AS FCPgtPerAvgDisCG
            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdGrpName IS NOT NULL 
            AND TMP.FTPmdGrpName <> ''
        ";

        $oQuery = $this->db->query($tSQL);
        $cPgtPerAvgDisCG = $oQuery->row()->FCPgtPerAvgDisCG;
        return floatval($cPgtPerAvgDisCB) + floatval($cPgtPerAvgDisCG);
    }

    /**
     * Functionality : Get PmtCB With PmtCG PgtPerAvgDis On CB in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Sum PmtCB With PmtCG PgtPerAvgDis
     * Return Type : float
     */
    public function FScMGetPmtCBAndPmtCGPgtPerAvgDisInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nSeqNo = $paParams['nSeqNo'];
        $cPgtPerAvgDisCB = 0.00;
        $cPgtPerAvgDisCG = 0.00;

        // PgtPerAvgDisCB
        $tSQL = "
            SELECT 
                ISNULL(SUM(FCPbyPerAvgDis),0) AS FCPgtPerAvgDisCB
            FROM TCNTPdtPmtCB_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FNPbySeq NOT IN($nSeqNo)
        ";

        $oQuery = $this->db->query($tSQL);
        $cPgtPerAvgDisCB = $oQuery->row()->FCPgtPerAvgDisCB;

        // PgtPerAvgDisCG
        $tSQL = "
            SELECT 
                ISNULL(SUM(FCPgtPerAvgDis),0) AS FCPgtPerAvgDisCG
            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdGrpName IS NOT NULL 
            AND TMP.FTPmdGrpName <> ''
            AND TMP.FNPgtSeq NOT IN($nSeqNo)
        ";

        $oQuery = $this->db->query($tSQL);
        $cPgtPerAvgDisCG = $oQuery->row()->FCPgtPerAvgDisCG;

        // echo 'cPgtPerAvgDisCB: '.$cPgtPerAvgDisCB;
        // echo 'cPgtPerAvgDisCG: '.$cPgtPerAvgDisCG;

        return floatval($cPgtPerAvgDisCB) + floatval($cPgtPerAvgDisCG);
    }

    /**
     * Functionality : Update PmtCG(FCPgtPerAvgDis) and PmtCB(FCPbyPerAvgDis) in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdateCGAndCBPerAvgDisInTmp($paParams = [])
    {
        $bStatus = false;

        $this->db->set('FCPbyPerAvgDis', $paParams['tCBPerAvgDis']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtCB_Tmp');

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }else{
            $bStatus = false;
        }

        $this->db->set('FCPgtPerAvgDis', $paParams['tCGPerAvgDis']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where("FTPmdGrpName IS NOT NULL");
        $this->db->where("FTPmdGrpName <> ''");
        $this->db->update('TCNTPdtPmtCG_Tmp');

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }else{
            $bStatus = false;
        }

        return $bStatus;
    }
}
