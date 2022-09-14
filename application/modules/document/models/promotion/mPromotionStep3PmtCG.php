<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep3PmtCG extends CI_Model
{
    /**
     * Functionality : Get PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtCG
     * Return Type : Array
     */
    public function FSaMGetPmtCGInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTPmdGrpName ASC, FNPgtSeq ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmhDocNo,
                        TMP.FNPgtSeq,
                        TMP.FTPmdGrpName,
                        TMP.FTPgtStaGetEffect,
                        TMP.FTPgtStaGetType,
                        TMP.FTPgtStaGetPdt,
                        TMP.FTRolCode,
                        TMP.FCPgtGetvalue,
                        TMP.FTPplCode,
                        TMP.FTPplName,
                        TMP.FCPgtGetQty,
                        TMP.FCPgtPerAvgDis,
                        TMP.FTPgtStaPoint,
                        TMP.FTPgtStaPntCalType,
                        TMP.FTPgtStaPdtDT,
                        TMP.FNPgtPntGet,
                        TMP.FNPgtPntBuy,
                        TMP.FTPgtStaCoupon,
                        TMP.FTPgtCpnText,
                        TMP.FTCphDocNo,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND (TMP.FTPmdGrpName IS NOT NULL OR TMP.FTPmdGrpName <> '')
                    /* AND TMP.FTPgtStaPoint = '1'
                    AND TMP.FTPgtStaCoupon = '1' */
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPmtCGInTmpPageAll($paParams);
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
     * Functionality : Count PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtCG
     * Return Type : Number
     */
    public function FSnMTFWGetPmtCGInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (TMP.FTPmdGrpName IS NOT NULL OR TMP.FTPmdGrpName <> '')
            /* AND TMP.FTPgtStaPoint = '1'
            AND TMP.FTPgtStaCoupon = '1' */
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert PmtCG to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPmtCGToTemp($paParams = [])
    {
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];
        $tGroupNameInGet = empty($paParams['tGroupNameInGet'])?"'NOTFOUND'":$paParams['tGroupNameInGet'];
        $tPbyStaBuyCond = $paParams['tPbyStaBuyCond']; // เงื่อนไขการซื้อ
        $bConditionBuyIsRange = $paParams['bConditionBuyIsRange'];
        $bStaGrpPriorityIsPriceGroup = $paParams['bStaGrpPriorityIsPriceGroup'];
        $bIsAlwPmtDisAvg = $paParams['bIsAlwPmtDisAvg'];
        // $bStaSpcGrpDisIsDisSomeGroup = $paParams['bStaSpcGrpDisIsDisSomeGroup'];

        $tPgtStaGetType = "1"; // Default 1:ลดบาท (1:ลดบาท 2:ลด% 3:ปรับราคา 4:.ใช้กลุ่มราคา 5:แถม(Free) 6:ไม่กำหนด)
        if($bStaGrpPriorityIsPriceGroup){ // เลือกกลุ่มคำนวนโปรโมชั่น เป็น 0 (0.Price Group  1.The Best  2.Forced)
            $tPgtStaGetType = "4"; // 4: ใช้กลุ่มราคา
        }

        $nPercentDis = 0;
        if($bIsAlwPmtDisAvg){
            $nPercentDis = 100;
        }
        /* if($bStaSpcGrpDisIsDisSomeGroup){ // สถานะการให้ส่วนลดเฉพาะกลุ่มทีได้รับ  (1=ให้ส่วนลดเฉพาะกลุ่ม 2=ให้ทั้งหมด รวมไม่เกิน 100%)
            $nPercentDis = 0;
        } */

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
                ) AS FCPgtPerAvgDis,

                '1' AS FTPgtStaPoint,
                0 AS FTPgtStaPntCalType,
                PMTDT.FTPmdStaListType AS FTPgtStaPdtDT,
                0 AS FNPgtPntGet,
                0 AS FNPgtPntBuy,
                '1' AS FTPgtStaCoupon,
                '' AS FTPgtCpnText,
                '' AS FTCphDocNo,

                /*'$tPbyStaBuyCond' AS FTPbyStaBuyCond,
                PMTDT.FTPmdStaListType AS FTPbyStaPdtDT,*/
                '$tUserSessionDate' AS FDCreateOn,            
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtDT_Tmp PMTDT WITH(NOLOCK)
            WHERE PMTDT.FTPmdGrpName = '$tGroupNameInGet'
        ";

        $this->db->query($tSQL);

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert PmtCG Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert PmtCG Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update PmtCG Value in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtCGInTmpBySeq($paParams = [])
    {
        $this->db->set('FTPgtStaGetType', $paParams['tPgtStaGetType']);
        $this->db->set('FCPgtGetvalue', $paParams['tPgtGetvalue']);
        $this->db->set('FCPgtPerAvgDis', $paParams['tPgtPerAvgDisCG']);
        $this->db->set('FCPgtGetQty', $paParams['tPgtGetQty']);
        $this->db->set('FTPplCode', $paParams['tPriceGroupCode']);
        $this->db->set('FTPplName', $paParams['tPriceGroupName']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where("FTPmdGrpName IS NOT NULL");
        $this->db->where("FTPmdGrpName <> ''");
        $this->db->where('FNPgtSeq', $paParams['nSeqNo']);
        $this->db->update('TCNTPdtPmtCG_Tmp');

        $tUserSessionID = $paParams['tUserSessionID'];
        $tFieldName = $paParams['tFieldName'];
        $tFormatType = $paParams['tFormatType'];
        $nSeqNo = $paParams['nSeqNo'];
        $tFieldValue = "";
        
        if (!empty($tFieldName)) {
            $tSQL = "
                SELECT 
                    $tFieldName
                FROM TCNTPdtPmtCG_Tmp WITH(NOLOCK) 
                WHERE FTSessionID = '$tUserSessionID'
                AND FNPgtSeq = $nSeqNo
                AND FTPmdGrpName IS NOT NULL
                AND FTPmdGrpName <> ''
            ";
            $oQuery = $this->db->query($tSQL);

            $tFieldValue = $oQuery->row()->$tFieldName;

            switch($tFormatType){
                case "N" : {
                    $tFieldValue = number_format($tFieldValue, 0);
                    break;
                }
                case "C" : {
                    $tFieldValue = number_format($tFieldValue, $paParams["nOptDecimalShow"]);
                    break;
                }
            }
        }
        return $tFieldValue;
    }

    /**
     * Functionality : Update PmtCG PgtStaGetType Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtCGPgtStaGetTypeInTmp($paParams = [])
    {
        $this->db->set('FTPgtStaGetType', $paParams['tPgtStaGetType']);
        $this->db->set('FCPgtGetQty', 0);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where("FTPmdGrpName IS NOT NULL");
        $this->db->where("FTPmdGrpName <> ''");
        $this->db->update('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
    
    /**
     * Functionality : Update PmtCG Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtCGInTmp($paParams = [])
    {
        $this->db->set('FTPmdGrpName', $paParams['tPmtGroupNameTmp']);
        $this->db->where('FTPmdGrpName', $paParams['tPmtGroupNameTmpOld']);
        $this->db->where("FTPmdGrpName IS NOT NULL");
        $this->db->where("FTPmdGrpName <> ''");
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PmtCG in Temp by Group Name
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePmtCGInTmpByGroupName($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where("FTPmdGrpName IS NOT NULL");
        $this->db->where("FTPmdGrpName <> ''");
        $this->db->where('FTPmdGrpName', $paParams['tGroupNameInGet']);
        $this->db->delete('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear PmtCG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPmtCGInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where("FTPmdGrpName IS NOT NULL");
        $this->db->where("FTPmdGrpName <> ''");
        $this->db->delete('TCNTPdtPmtCG_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Get PmtCB With PmtCG PgtPerAvgDis On CG in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Sum PmtCB With PmtCG PgtPerAvgDis
     * Return Type : float
     */
    public function FScMGetPmtCBAndPmtCGPgtPerAvgDisOnCGInTmp($paParams = [])
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
        return floatval($cPgtPerAvgDisCB) + floatval($cPgtPerAvgDisCG);
    }
}
