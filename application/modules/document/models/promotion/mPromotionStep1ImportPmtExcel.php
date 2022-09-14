<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep1ImportPmtExcel extends CI_Model
{
    /**
     * Functionality : Get Pdt Data
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Pdt Data
     * Return Type : array
     */
    public function FSaMGetDataPdt($paParams = []){

        $tPdtCode = $paParams['tPdtCode'];
        $tPunCode = $paParams['tPunCode'];
        $tBarCode = $paParams['tBarCode'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tPmtGroupNameTmpOld = $paParams['tPmtGroupNameTmpOld'];

        $tSQL = "   SELECT
                        PDT.FTPdtCode,
                        PDTL.FTPdtName,
                        PKS.FTPunCode,
                        UNTL.FTPunName,
                        BAR.FTBarCode
                    FROM TCNMPdt PDT WITH(NOLOCK)
                    LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
                    INNER JOIN TCNMPdtPackSize PKS WITH(NOLOCK) ON PDT.FTPdtCode = PKS.FTPdtCode AND PKS.FTPunCode = '$tPunCode'
                    LEFT JOIN TCNMPdtUnit_L UNTL WITH(NOLOCK) ON UNTL.FTPunCode = '$tPunCode' AND UNTL.FNLngID = $nLngID
                    INNER JOIN TCNMPdtBar BAR WITH(NOLOCK) ON PDT.FTPdtCode = BAR.FTPdtCode AND BAR.FTPunCode = '$tPunCode' 
                    WHERE PDT.FTPdtCode NOT IN ( 
                            SELECT FTPmdRefCode 
                            FROM TCNTPdtPmtDT_Tmp WITH(NOLOCK) 
                            WHERE FTPmdRefCode = '$tPdtCode' 
                              AND FTPmdSubRef = '$tPunCode' 
                              AND FTPmdBarCode = '$tBarCode' 
                              AND FTPmdGrpName = '$tPmtGroupNameTmpOld' 
                              AND FTSessionID = '$tUserSessionID'
                        ) ";
        
        if($tPdtCode!= ""){
            $tSQL .= "AND PDT.FTPdtCode = '$tPdtCode'";
        }

        if($tBarCode!= ""){
            $tSQL .= "AND BAR.FTBarCode = '$tBarCode'";
        }
        
        $tSQL .= " ORDER BY FTPdtCode ASC";
        
        $oQuery = $this->db->query($tSQL);

        return $oQuery->row_array();
    }

    /**
     * Functionality : Get Brand Data
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Brand Data
     * Return Type : array
     */
    public function FSaMGetDataBrand($paParams = []){
        $tBrandCode = $paParams['tBrandCode'];
        $tModelCode = $paParams['tModelCode'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tPmtGroupNameTmpOld = $paParams['tPmtGroupNameTmpOld'];
        // $tPmtGroupTypeTmp = $paParams['tPmtGroupTypeTmp'];

        $tSQL = "   SELECT
                        BRDL.FTPbnCode,
                        BRDL.FTPbnName
                    FROM TCNMPdtBrand_L BRDL WITH (NOLOCK)
                    WHERE BRDL.FTPbnCode = '$tBrandCode'
                      AND BRDL.FNLngID = $nLngID
                      AND BRDL.FTPbnCode NOT IN (
                        SELECT FTPmdRefCode 
                        FROM TCNTPdtPmtDT_Tmp WITH(NOLOCK) 
                        WHERE FTPmdRefCode = '$tBrandCode' 
                          AND FTPmdGrpName = '$tPmtGroupNameTmpOld'
                          AND FTSessionID = '$tUserSessionID'
              )
        ";
        
        $oQuery = $this->db->query($tSQL);
        $aBrand = $oQuery->row_array();

        $tSQL = "   SELECT
                        MODL.FTPmoCode,
                        MODL.FTPmoName
                    FROM TCNMPdtModel_L MODL WITH(NOLOCK)
                    WHERE MODL.FTPmoCode = '$tModelCode'
                      AND MODL.FNLngID = $nLngID
                      AND MODL.FTPmoCode NOT IN (
                        SELECT FTPmdSubRef 
                        FROM TCNTPdtPmtDT_Tmp WITH(NOLOCK) 
                        WHERE FTPmdRefCode = '$tBrandCode' 
                          AND FTPmdSubRef = '$tModelCode'
                          AND FTPmdGrpName = '$tPmtGroupNameTmpOld'
                          AND FTSessionID = '$tUserSessionID'
              )
        ";
        // echo $tSQL;exit;
        $oQuery = $this->db->query($tSQL);
        $aModel = $oQuery->row_array();

        return array_merge(empty($aBrand)?[]:$aBrand, empty($aModel)?[]:$aModel);
    }

    /*===== Begin Create Promotion By Import ========================================== */

    /**
     * Functionality : Import Excel to Temp
     * Parameters : $paParams
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMImportExcelToTmp(array $paParams = []){
        $tUserBchCodeDef = $paParams['tUserBchCodeDef'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLangID = $paParams['nLangID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];

        /*===== Begin TCNTPdtPmtHD, TCNTPdtPmtHD_L ==================================== */
            $aDataHD = isset($paParams['aPackData']['aJSONDataHD'][1])?$paParams['aPackData']['aJSONDataHD'][1]:[];
            // echo '<pre>';
            // var_dump($aDataHD);
            if(!empty($aDataHD)){
                $FTPmhName = $aDataHD[0];
                $FDPmhDStart = str_replace("/","-",$aDataHD[1]);
                $FDPmhDStop = str_replace("/","-",$aDataHD[2]);
                $FDPmhTStart = !empty($aDataHD[3])?$aDataHD[3]:'00:00:00';
                $FDPmhTStop = !empty($aDataHD[4])?$aDataHD[4]:'23:59:59';
                $FTPmhStaLimitCst = isset($aDataHD[5])?$aDataHD[5]:'1';
                $FTPbyStaBuyCond = isset($aDataHD[6])?$aDataHD[6]:'1';
                $FTPmhStaGrpPriority = isset($aDataHD[7])?$aDataHD[7]:'1';
                $FTPmhStaGetPdt = isset($aDataHD[8])?$aDataHD[8]:'1';
                $FTPmhStaChkQuota = isset($aDataHD[9])?$aDataHD[9]:'2';
                $FTPmhStaGetPri = isset($aDataHD[10])?$aDataHD[10]:'1';
                $FTPmhStaChkCst = isset($aDataHD[11])?$aDataHD[11]:'2';

                $tSpmStaLimitCst = '';
                $nSpmMemAgeLT = 0;
                $tMemAge = $aDataHD[12];
                $aMemberAge = explode(",", $tMemAge);
                if (isset($aMemberAge[0]) && isset($aMemberAge[1]) && is_array($aMemberAge)) {
                    $tOperator = $aMemberAge[0];
                    $nSpmMemAgeLT = $aMemberAge[1];
                }

                switch ($tOperator) {
                    case '>': { // 5
                        $tSpmStaLimitCst = '5';
                        break;
                    }
                    case '>=': { // 4
                        $tSpmStaLimitCst = '4';
                        break;
                    }
                    case '<': { // 1
                        $tSpmStaLimitCst = '1';
                        break;
                    }
                    case '<=': { // 2
                        $tSpmStaLimitCst = '2';
                        break;
                    }
                    case '=': { // 3
                        $tSpmStaLimitCst = '3';
                        break;
                    }
                }

                $FTSpmStaLimitCst = $tSpmStaLimitCst;
                $FNSpmMemAgeLT = $nSpmMemAgeLT;

                $tSpmStaChkCstDOB = '';
                $nPmhCstDobPrev = 0;
                $nPmhCstDobNext = 0;
                $tMemDOB = $aDataHD[13];
                $aMemberDOB = explode(",", $tMemDOB);
                if (isset($aMemberDOB[0]) && isset($aMemberDOB[1]) && isset($aMemberDOB[2]) && is_array($aMemberDOB)) {
                    $nPmhCstDobNext = $aMemberDOB[0];
                    if ($aMemberDOB[1] == "Y") {
                        $tSpmStaChkCstDOB = '1';
                    }
                    if ($aMemberDOB[1] == "N") {
                        $tSpmStaChkCstDOB = '2';
                    }
                    $nPmhCstDobPrev = $aMemberDOB[2];
                }

                $FTSpmStaChkCstDOB = $tSpmStaChkCstDOB;
                $FNPmhCstDobPrev = $nPmhCstDobPrev;
                $FNPmhCstDobNext = $nPmhCstDobNext;

                if(in_array($FTPbyStaBuyCond, ['1','2'])) {
                    $FTPbyStaCalSum = isset($aDataHD[14])?$aDataHD[14]:'1';
                    $FTPgtStaGetEffect = isset($aDataHD[15])?$aDataHD[15]:'1';
                }

                if(in_array($FTPbyStaBuyCond, ['3','4','5','6'])) {
                    $FTPgtStaGetEffect = '3';
                    $FTPbyStaCalSum = '1';
                }
                

                $FTTmpStatus = isset($aDataHD[16])?$aDataHD[16]:'';
                $FTTmpRemark = isset($aDataHD[17])?$aDataHD[17]:'';
            }

            $tSQL = "
                INSERT INTO TCNTImpMasTmp 
                (FTPmhName, FDPmhDStart, FDPmhDStop, FDPmhTStart, FDPmhTStop, FTPmhStaLimitCst, 
                FTPbyStaBuyCond, FTPmhStaGrpPriority, FTPmhStaGetPdt, FTPmhStaChkQuota, FTPmhStaGetPri, FTPmhStaChkCst, 
                FTSpmStaLimitCst, FNSpmMemAgeLT, FTSpmStaChkCstDOB, FNPmhCstDobPrev, FNPmhCstDobNext, FTPbyStaCalSum, 
                FTSpmMemAge, FTSpmMemDOB, FTPgtStaGetEffect, 
                FTTmpStatus, FTTmpRemark, FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID)

                VALUES 
                ('$FTPmhName', '$FDPmhDStart', '$FDPmhDStop', '$FDPmhTStart', '$FDPmhTStop', $FTPmhStaLimitCst, 
                '$FTPbyStaBuyCond', '$FTPmhStaGrpPriority', '$FTPmhStaGetPdt', '$FTPmhStaChkQuota', '$FTPmhStaGetPri', '$FTPmhStaChkCst', 
                '$FTSpmStaLimitCst', $FNSpmMemAgeLT, '$FTSpmStaChkCstDOB', $FNPmhCstDobPrev, $FNPmhCstDobNext, '$FTPbyStaCalSum',
                '$tMemAge', '$tMemDOB', '$FTPgtStaGetEffect',
                '$FTTmpStatus', '$FTTmpRemark', 1, '$tUserBchCodeDef', '$tUserSessionDate', 'PMT_HD', '$tUserSessionID');
            ";
        /*===== End TCNTPdtPmtHD, TCNTPdtPmtHD_L ====================================== */
        
        /*===== Begin TCNTPdtPmtDT ==================================================== */
            $aDataPdtGroup = isset($paParams['aPackData']['aJSONDataPdtGroup'])?$paParams['aPackData']['aJSONDataPdtGroup']:[];

            foreach($aDataPdtGroup as $nIndex => $aPdtGroup) {
                if($nIndex == 0){continue;}

                $FTPmdStaType = $aPdtGroup[0];
                $FTPmdGrpName = $aPdtGroup[1];
                $FTPmdBarCode = $aPdtGroup[2];
                $FTPmdSubRef = $aPdtGroup[3];
                $FTTmpStatus = $aPdtGroup[4];
                $FTTmpRemark = $aPdtGroup[5];

                $tSQL .= "
                    INSERT INTO TCNTImpMasTmp 
                    (FTPmdStaType, FTPmdGrpName, FTBarCode, FTPunCode, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID)

                    VALUES 
                    ('$FTPmdStaType', '$FTPmdGrpName', '$FTPmdBarCode', '$FTPmdSubRef', '$FTTmpStatus', '$FTTmpRemark', 
                    $nIndex, '$tUserBchCodeDef', '$tUserSessionDate', 'PMT_DT', '$tUserSessionID');
                ";
            }
        /*===== End TCNTPdtPmtDT ====================================================== */

        /*===== Begin TCNTPdtPmtCB ==================================================== */
            $aDataPmtCB = isset($paParams['aPackData']['aJSONDataBuyGroup'])?$paParams['aPackData']['aJSONDataBuyGroup']:[];

            $bPbyPerAvgDisNotSet = true;
            foreach($aDataPmtCB as $nIndex => $aPmtCB) {
                if($nIndex == 0){continue;}

                $FTPmdGrpName = $aPmtCB[0];
                $FTPbyStaBuyCond = $aPmtCB[1];
                $FCPbyMinValue = empty($aPmtCB[2])?0:$aPmtCB[2];
                $FCPbyMaxValue = empty($aPmtCB[3])?0:$aPmtCB[3];
                $FCPbyMinSetPri = empty($aPmtCB[4])?0:$aPmtCB[4];
                $FTTmpStatus = $aPmtCB[5];
                $FTTmpRemark = $aPmtCB[6];

                if($nIndex > 0 && $FTTmpStatus == "1" && $bPbyPerAvgDisNotSet){
                    $nPbyPerAvgDis = 100;
                    $bPbyPerAvgDisNotSet = false;
                }else{
                    $nPbyPerAvgDis = 0;
                }

                $tSQL .= "
                    INSERT INTO TCNTImpMasTmp 
                    (FTPmdGrpName, FTPbyStaBuyCond, FCPbyMinValue, FCPbyMaxValue, FCPbyMinSetPri, FCPbyPerAvgDis, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID)

                    VALUES 
                    ('$FTPmdGrpName', '$FTPbyStaBuyCond', $FCPbyMinValue, $FCPbyMaxValue, $FCPbyMinSetPri, $nPbyPerAvgDis, '$FTTmpStatus', '$FTTmpRemark', 
                    $nIndex, '$tUserBchCodeDef', '$tUserSessionDate', 'PMT_CB', '$tUserSessionID');
                ";
            }
        /*===== End TCNTPdtPmtCB ====================================================== */

        /*===== Begin TCNTPdtPmtCG ==================================================== */
            $aDataPmtCG = isset($paParams['aPackData']['aJSONDataGetGroup'])?$paParams['aPackData']['aJSONDataGetGroup']:[];

            foreach($aDataPmtCG as $nIndex => $aPmtCG) {
                if($nIndex == 0){continue;}

                $FTPmdGrpName = $aPmtCG[0];
                $FTPgtStaGetType = $aPmtCG[1];
                $FCPgtGetvalue = empty($aPmtCG[2])?0:$aPmtCG[2];
                $FCPgtGetQty = empty($aPmtCG[3])?0:$aPmtCG[3];
                $FTTmpStatus = $aPmtCG[4];
                $FTTmpRemark = $aPmtCG[5];

                $tSQL .= "
                    INSERT INTO TCNTImpMasTmp 
                    (FTPmdGrpName, FTPgtStaGetType, FCPgtGetvalue, FCPgtGetQty, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID)

                    VALUES 
                    ('$FTPmdGrpName', '$FTPgtStaGetType', $FCPgtGetvalue, $FCPgtGetQty, '$FTTmpStatus', '$FTTmpRemark', 
                    $nIndex, '$tUserBchCodeDef', '$tUserSessionDate', 'PMT_CG', '$tUserSessionID');
                ";
            }
        /*===== End TCNTPdtPmtCG ====================================================== */

        /*===== Begin TCNTPdtPmtCG(Coupon) ============================================ */
            $aDataPmtCoupon = isset($paParams['aPackData']['aJSONDataGetCoupon'])?$paParams['aPackData']['aJSONDataGetCoupon']:[];

            foreach($aDataPmtCoupon as $nIndex => $aPmtCoupon) {
                if($nIndex == 0){continue;}

                $FTPgtStaCoupon = $aPmtCoupon[0];
                $FTCphDocNo = $aPmtCoupon[1];
                $FTPgtCpnText = $aPmtCoupon[2];
                $FTTmpStatus = $aPmtCoupon[3];
                $FTTmpRemark = $aPmtCoupon[4];

                $tSQL .= "
                    INSERT INTO TCNTImpMasTmp 
                    (FTPgtStaCoupon, FTCphDocNo, FTPgtCpnText, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID)

                    VALUES 
                    ('$FTPgtStaCoupon', '$FTCphDocNo', '$FTPgtCpnText', '$FTTmpStatus', '$FTTmpRemark', 
                    $nIndex, '$tUserBchCodeDef', '$tUserSessionDate', 'PMT_COUPON', '$tUserSessionID');
                ";
            }
        /*===== End TCNTPdtPmtCG(Coupon) ============================================== */

        /*===== Begin TCNTPdtPmtCG(Point) ============================================= */
            $aDataPmtPoint = isset($paParams['aPackData']['aJSONDataGetPoint'])?$paParams['aPackData']['aJSONDataGetPoint']:[];

            foreach($aDataPmtPoint as $nIndex => $aPmtPoint) {
                if($nIndex == 0){continue;}

                $FTPgtStaPoint = $aPmtPoint[0];
                $FTPgtStaPntCalType = $aPmtPoint[1];
                $FNPgtPntGet = empty($aPmtPoint[2])?0:$aPmtPoint[2];
                $FNPgtPntBuy = empty($aPmtPoint[3])?0:$aPmtPoint[3];
                $FTTmpStatus = $aPmtPoint[4];
                $FTTmpRemark = $aPmtPoint[5];

                $tSQL .= "
                    INSERT INTO TCNTImpMasTmp 
                    (FTPgtStaPoint, FTPgtStaPntCalType, FNPgtPntGet, FNPgtPntBuy, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID)

                    VALUES 
                    ('$FTPgtStaPoint', '$FTPgtStaPntCalType', $FNPgtPntGet, $FNPgtPntBuy, '$FTTmpStatus', '$FTTmpRemark', 
                    $nIndex, '$tUserBchCodeDef', '$tUserSessionDate', 'PMT_POINT', '$tUserSessionID');
                ";
            }
        /*===== End TCNTPdtPmtCG(Point) =============================================== */

        $this->db->query($tSQL);

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Import Data Temp to Master
     * Parameters : $paParams
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMImportTempToMaster(array $paParams = []){
        $nLngID = $paParams['nLangEdit'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tCreatedOn = $paParams['tCreatedOn'];
        $tCreatedBy = $paParams['tCreatedBy'];
        $tDocNo = $paParams['tDocNo'];

        $tSQL = "
            SELECT TOP 1
                FTPgtStaGetEffect,
                FTPbyStaCalSum,
                FTPmhStaGetPdt,
                FTPmhStaChkCst,
                FTPmhStaLimitCst,
                FTTmpStatus
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTTmpTableKey = 'PMT_HD'
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oResult = $oQuery->result()[0];
            $tPgtStaGetEffect = $oResult->FTPgtStaGetEffect;
            $tPbyStaCalSum = $oResult->FTPbyStaCalSum;
            $tPmhStaGetPdt = $oResult->FTPmhStaGetPdt;
            $tPmhStaChkCst = $oResult->FTPmhStaChkCst;
            $tPmhStaLimitCst = $oResult->FTPmhStaLimitCst;
            $tTmpStatus = $oResult->FTTmpStatus;
        } else {
            $tPgtStaGetEffect = '';
            $tPbyStaCalSum = '';
            $tPmhStaGetPdt = '';
            $tPmhStaGetPdt = '';
            $tPmhStaChkCst = '';
            $tPmhStaLimitCst = '';
            $tTmpStatus = '';
        }

        /*===== Begin TCNTPdtPmtHD, TCNTPdtPmtHD_L ==================================== */
        $tSQL = " 
            INSERT INTO TCNTPdtPmtHD 
            (
                FTBchCode,
                FTPmhDocNo,
                FDPmhDStart,
                FDPmhDStop,
                FDPmhTStart,
                FDPmhTStop,
                FTPmhStaLimitCst,
                FTPmhStaGrpPriority,
                FTPmhStaGetPdt,
                FTPmhStaChkQuota,
                FTPmhStaGetPri,
                FTPmhStaChkCst,
                FTPmhStaClosed,
                FTPmhStaDoc,
                FNPmhStaDocAct,
                FTPmhStaOnTopPmt,
                FTPmhStaAlwCalPntStd,
                FTPmhStaRcvFree,
                FTPmhStaLimitGet,
                FTPmhStaPdtExc,
                FTPmhStaOnTopDis,
                FTUsrCode,
                FDLastUpdOn,
                FTLastUpdBy,
                FDCreateOn,
                FTCreateBy
            )
            SELECT TOP 1
                TMP.FTBchCode,
                '$tDocNo' AS FTPmhDocNo,
                TMP.FDPmhDStart,
                TMP.FDPmhDStop,
                TMP.FDPmhTStart,
                TMP.FDPmhTStop,
                TMP.FTPmhStaLimitCst,
                TMP.FTPmhStaGrpPriority,
                TMP.FTPmhStaGetPdt,
                TMP.FTPmhStaChkQuota,
                TMP.FTPmhStaGetPri,
                TMP.FTPmhStaChkCst,
                '0' AS FTPmhStaClosed,
                '1' AS FTPmhStaDoc,
                1 AS FNPmhStaDocAct,
                '1' AS FTPmhStaOnTopPmt,
                '1' AS FTPmhStaAlwCalPntStd,
                '1' AS FTPmhStaRcvFree,
                '2' AS FTPmhStaLimitGet,
                '1' AS FTPmhStaPdtExc,
                '1' AS FTPmhStaOnTopDis,
                '$tCreatedBy' AS FTUsrCode,
                '$tCreatedOn' AS FDLastUpdOn,
                '$tCreatedBy' AS FTLastUpdBy,
                '$tCreatedOn' AS FDCreateOn,
                '$tCreatedBy' AS FTCreateBy
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTTmpTableKey = 'PMT_HD'
            AND TMP.FTTmpStatus = '1'
        ";

        $tSQL .= " 
            INSERT INTO TCNTPdtPmtHD_L 
            (
                FTBchCode,
                FTPmhDocNo,
                FTPmhName,
                FNLngID
            )
            SELECT TOP 1
                TMP.FTBchCode,
                '$tDocNo' AS FTPmhDocNo,
                TMP.FTPmhName,
                $nLngID AS FNLngID
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTTmpTableKey = 'PMT_HD'
            AND TMP.FTTmpStatus = '1'
        ";
        /*===== End TCNTPdtPmtHD, TCNTPdtPmtHD_L ====================================== */

        /*===== Begin TCNTPdtPmtHDCst ================================================= */
        $tCstValue = "";
        $tCstField = "";
        if($tPmhStaChkCst == "1"){
            $tCstValue = "
                ,
                TMP.FTSpmStaLimitCst,
                TMP.FNSpmMemAgeLT,
                TMP.FTSpmStaChkCstDOB,
                TMP.FNPmhCstDobPrev,
                TMP.FNPmhCstDobNext
            ";
            $tCstField = "
                ,
                FTSpmStaLimitCst,
                FNSpmMemAgeLT,
                FTSpmStaChkCstDOB,
                FNPmhCstDobPrev,
                FNPmhCstDobNext
            ";
        }

        $tSQL .= "
            INSERT INTO TCNTPdtPmtHDCst 
            (
                FTBchCode,
                FTPmhDocNo
                $tCstField
            )
            SELECT TOP 1
                TMP.FTBchCode,
                '$tDocNo' AS FTPmhDocNo
                $tCstValue
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTTmpTableKey = 'PMT_HD'
            AND TMP.FTTmpStatus = '1'
        ";
        /*===== End TCNTPdtPmtHDCst =================================================== */

        /*===== Begin TCNTPdtPmtDT ==================================================== */
        $tSQL .= "
            INSERT INTO TCNTPdtPmtDT 
            (
                FTBchCode,
                FTPmhDocNo,
                FNPmdSeq,
                FTPmdStaType,
                FTPmdGrpName,
                FTPmdRefCode,
                FTPmdSubRef,
                FTPmdBarCode
            )
            SELECT DISTINCT
                TMP.FTBchCode,
                '$tDocNo' AS FTPmhDocNo,
                ROW_NUMBER() OVER(ORDER BY TMP.FTPmdGrpName ASC) AS FNPmdSeq,
                (CASE
                    WHEN (TMP.FTPmdStaType = '1' OR TMP.FTPmdStaType = '2') THEN '1'
                    WHEN (TMP.FTPmdStaType = '3') THEN '2'
                END) AS FTPmdStaType,
                TMP.FTPmdGrpName,
                (CASE
                    WHEN (TMP.FTBarCode = '*') THEN NULL
                    ELSE BAR.FTPdtCode
                END) AS FTPmdRefCode,
                (CASE
                    WHEN (TMP.FTBarCode = '*') THEN NULL
                    ELSE BAR.FTPunCode
                END) AS FTPmdSubRef,
                (CASE
                    WHEN (TMP.FTBarCode = '*') THEN NULL
                    ELSE TMP.FTBarCode
                END) AS FTPmdBarCode
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            LEFT JOIN TCNMPdtBar BAR WITH(NOLOCK) ON TMP.FTBarCode = BAR.FTBarCode
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdGrpName IN
			(
				SELECT DISTINCT
                    FTPmdGrpName
                FROM TCNTImpMasTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey IN ('PMT_CB','PMT_CG')
			)
            AND TMP.FTTmpTableKey = 'PMT_DT'
            AND TMP.FTTmpStatus = '1'
            OR (TMP.FTPmdStaType = '3' AND TMP.FTTmpStatus = '1')
        ";
        /*===== End TCNTPdtPmtDT ====================================================== */

        /*===== Begin TCNTPdtPmtCB ==================================================== */
        $tSQL .= "
            INSERT INTO TCNTPdtPmtCB 
            (
                FTBchCode,
                FTPmhDocNo,
                FNPbySeq,
                FTPmdGrpName,
                FTPbyStaBuyCond,
                FCPbyMinValue,
                FCPbyMaxValue,
                FCPbyMinSetPri,
                FTPbyStaCalSum,
                FTPbyStaPdtDT,
                FCPbyPerAvgDis,
                FTPbyMinTime,
                FTPbyMaxTime
            )
            SELECT 
                TMP.FTBchCode,
                '$tDocNo' AS FTPmhDocNo,
                ROW_NUMBER() OVER(ORDER BY TMP.FTPmdGrpName ASC) AS FNPbySeq,
                TMP.FTPmdGrpName,
                TMP.FTPbyStaBuyCond,
                TMP.FCPbyMinValue,
                TMP.FCPbyMaxValue,
                TMP.FCPbyMinSetPri,
                '$tPbyStaCalSum' AS FTPbyStaCalSum,
                '1' AS FTPbyStaPdtDT,
                TMP.FCPbyPerAvgDis,
                '' AS FTPbyMinTime,
                '' AS FTPbyMaxTime
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTTmpTableKey = 'PMT_CB'
            AND TMP.FTTmpStatus = '1'
        ";
        /*===== End TCNTPdtPmtCB ====================================================== */

        /*===== Begin TCNTPdtPmtCG ==================================================== */
        $tSQL .= "
            INSERT INTO TCNTPdtPmtCG 
            (
                FTBchCode,
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
                FTCphDocNo
            )
            SELECT 
                TMP.FTBchCode,
                '$tDocNo' AS FTPmhDocNo,
                ROW_NUMBER() OVER(ORDER BY TMP.FTPmdGrpName ASC) AS FNPgtSeq,
                TMP.FTPmdGrpName,
                '$tPgtStaGetEffect' AS FTPgtStaGetEffect,
                TMP.FTPgtStaGetType,
                '$tPmhStaGetPdt' AS FTPgtStaGetPdt,
                '' AS FTRolCode,
                TMP.FCPgtGetvalue,
                '' AS FTPplCode,
                TMP.FCPgtGetQty,
                0 AS FCPgtPerAvgDis,
                '2' AS FTPgtStaPoint,
                '1' AS FTPgtStaPntCalType,
                '1' AS FTPgtStaPdtDT,
                0 AS FNPgtPntGet,
                0 AS FNPgtPntBuy,
                '2' AS FTPgtStaCoupon,
                '' AS FTPgtCpnText,
                '' AS FTCphDocNo
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTTmpTableKey = 'PMT_CG'
            AND TMP.FTTmpStatus = '1'
        ";
        /*===== End TCNTPdtPmtCG ====================================================== */

        /*===== Begin TCNTPdtPmtCG(Coupon) ============================================ */
        $tSQL .= "
            INSERT INTO TCNTPdtPmtCG 
            (
                FTBchCode,
                FTPmhDocNo,
                FNPgtSeq,
                --FTPmdGrpName,
                --FTPgtStaGetEffect,
                FTPgtStaGetType,
                --FTPgtStaGetPdt,
                --FTRolCode,
                --FCPgtGetvalue,
                --FTPplCode,
                FCPgtGetQty,
                --FCPgtPerAvgDis,
                --FTPgtStaPoint,
                --FTPgtStaPntCalType,
                --FTPgtStaPdtDT,
                --FNPgtPntGet,
                --FNPgtPntBuy,
                FTPgtStaCoupon,
                FTPgtCpnText,
                FTCphDocNo
            )
            SELECT TOP 1
                TMP.FTBchCode,
                '$tDocNo' AS FTPmhDocNo,
                -1 AS FNPgtSeq,
                --'' AS FTPmdGrpName,
                --'' AS FTPgtStaGetEffect,
                '6' AS FTPgtStaGetType,
                --'' AS FTPgtStaGetPdt,
                --'' AS FTRolCode,
                --0 AS FCPgtGetvalue,
                --'' AS FTPplCode,
                TMP.FCPgtGetQty,
                --0 AS FCPgtPerAvgDis,
                --'1' AS FTPgtStaPoint,
                --'1' AS FTPgtStaPntCalType,
                --'' AS FTPgtStaPdtDT,
                --0 AS FNPgtPntGet,
                --0 AS FNPgtPntBuy,
                TMP.FTPgtStaCoupon,
                (CASE
                    WHEN (TMP.FTPgtStaCoupon = '1' OR TMP.FTPgtStaCoupon = '2') THEN NULL
                    WHEN (TMP.FTPgtStaCoupon = '3') THEN TMP.FTPgtCpnText
                    ELSE NULL
                END) AS FTPgtCpnText,
                (CASE
                    WHEN (TMP.FTPgtStaCoupon = '1' OR TMP.FTPgtStaCoupon = '3') THEN NULL
                    WHEN (TMP.FTPgtStaCoupon = '2') THEN TMP.FTCphDocNo
                    ELSE NULL
                END) AS FTCphDocNo
            FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTTmpTableKey = 'PMT_COUPON'
            AND TMP.FTTmpStatus = '1'
        ";
        /*===== End TCNTPdtPmtCG(Coupon) ============================================== */

        /*===== Begin TCNTPdtPmtCG(Point) ============================================= */
        if ($tPmhStaLimitCst == "2") { // ใช้งานได้เฉพาะ คิดทั้งหมด/คิดต่อสมาชิก เป็นต่อสมาชิกเท่านั้น
            $tSQL .= "
                INSERT INTO TCNTPdtPmtCG 
                (
                    FTBchCode,
                    FTPmhDocNo,
                    FNPgtSeq,
                    --FTPmdGrpName,
                    --FTPgtStaGetEffect,
                    FTPgtStaGetType,
                    --FTPgtStaGetPdt,
                    --FTRolCode,
                    FCPgtGetvalue,
                    --FTPplCode,
                    FCPgtGetQty,
                    --FCPgtPerAvgDis,
                    FTPgtStaPoint,
                    FTPgtStaPntCalType,
                    --FTPgtStaPdtDT,
                    FNPgtPntGet,
                    FNPgtPntBuy
                    --FTPgtStaCoupon,
                    --FTPgtCpnText,
                    --FTCphDocNo
                )
                SELECT TOP 1
                    TMP.FTBchCode,
                    '$tDocNo' AS FTPmhDocNo,
                    -2 AS FNPgtSeq,
                    --TMP.FTPmdGrpName,
                    --'' AS FTPgtStaGetEffect,
                    '6' AS FTPgtStaGetType,
                    --'' AS FTPgtStaGetPdt,
                    --'' AS FTRolCode,
                    TMP.FCPgtGetvalue,
                    --'' AS FTPplCode,
                    TMP.FCPgtGetQty,
                    --0 AS FCPgtPerAvgDis,
                    TMP.FTPgtStaPoint,
                    TMP.FTPgtStaPntCalType,
                    --'' AS FTPgtStaPdtDT,
                    TMP.FNPgtPntGet,
                    TMP.FNPgtPntBuy
                    --'1' AS FTPgtStaCoupon,
                    --'' AS FTPgtCpnText,
                    --'' AS FTCphDocNo
                FROM TCNTImpMasTmp TMP WITH(NOLOCK)
                WHERE TMP.FTSessionID = '$tUserSessionID'
                AND TMP.FTTmpTableKey = 'PMT_POINT'
                AND TMP.FTTmpStatus = '1'
            ";
        }
        /*===== End TCNTPdtPmtCG(Point) =============================================== */
        
        if($tTmpStatus == "1"){
            $this->db->query($tSQL);
        }
    }

    /**
     * Functionality : Clear Import in Temp
     * Parameters : $paParams
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMImportExcelDeleteAllInTmp(array $paParams = []){
        $tUserSessionID = $paParams['tUserSessionID'];

        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->where_in('FTTmpTableKey', ["PMT_HD","PMT_DT","PMT_CB","PMT_CG","PMT_COUPON","PMT_POINT"]);
        $this->db->delete('TCNTImpMasTmp');
    }

    /*===== Begin Summary HD =======================================================*/
        /**
         * Functionality : Get Import Data in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportGetHDDataInTmp(array $paParams = []){
            $tUserSessionID = $paParams['tUserSessionID'];

            $tSQL = " 
                SELECT 
                    FTPmhName, FDPmhDStart, FDPmhDStop, CONVERT(CHAR(8), FDPmhTStart, 108)  AS FDPmhTStart, CONVERT(CHAR(8), FDPmhTStop, 108)  AS FDPmhTStop, FTPmhStaLimitCst, 
                    FTPbyStaBuyCond, FTPmhStaGrpPriority, FTPmhStaGetPdt, FTPmhStaChkQuota, FTPmhStaGetPri, FTPmhStaChkCst, 
                    FTSpmStaLimitCst, FNSpmMemAgeLT, FTSpmStaChkCstDOB, FNPmhCstDobPrev, FNPmhCstDobNext, FTPbyStaCalSum, FTSpmMemAge, FTSpmMemDOB, 
                    FTPgtStaGetEffect, FTTmpStatus, FTTmpRemark, FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID
                FROM TCNTImpMasTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey = 'PMT_HD'
            ";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'success',
                    'aResult' => $oQuery->result_array(),
                    'nNumrow' => $oQuery->num_rows()
                );
            }else{
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                    'aResult' => array(),
                    'nNumrow' => 0
                );
            }
            return $aStatus;
        }
    /*===== End Summary HD =========================================================*/

    /*===== Begin Product Group ====================================================*/
        /**
         * Functionality : Get Import Data in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportGetPdtGroupDataInTmp(array $paParams = []){
            $tTableKey = $paParams['tTableKey'];
            $tUserSessionID = $paParams['tUserSessionID'];
            $tTextSearch = $paParams['tTextSearch'];

            $tSQL = " 
                SELECT 
                    FTPmdStaType, FTPmdGrpName, FTBarCode AS FTPmdBarCode, FTPunCode AS FTPmdSubRef, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID
                FROM TCNTImpMasTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey = 'PMT_DT'
            ";

            if($tTextSearch != '' || $tTextSearch != null){
                $tSQL .= " 
                    AND (
                        FTPmdGrpName LIKE '%$tTextSearch%'
                        OR FTPmdBarCode LIKE '%$tTextSearch%'
                        OR FTPmdSubRef LIKE '%$tTextSearch%'
                    )
                ";
            }

            $tSQL .= " ORDER BY FNTmpSeq";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'success',
                    'aResult' => $oQuery->result_array(),
                    'nNumrow' => $oQuery->num_rows()
                );
            }else{
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                    'aResult' => array(),
                    'nNumrow' => 0
                );
            }
            return $aStatus;
        }

        /**
         * Functionality : Delete Data in Temp by SeqNo
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportDeletePdtGroupInTempBySeq(array $paParams = []) {
            try{
                $this->db->where_in('FNTmpSeq', $paParams['aSeqNo']);
                $this->db->where('FTTmpTableKey', "PMT_DT");
                $this->db->where('FTSessionID', $paParams['tUserSessionID']);
                $this->db->delete('TCNTImpMasTmp');

                if($this->db->trans_status() === FALSE){
                    $aStatus = array(
                        'tCode' => '905',
                        'tDesc' => 'Delete Fail',
                    );
                }else{
                    $aStatus = array(
                        'tCode' => '1',
                        'tDesc' => 'Delete Success.',
                    );
                }
                return $aStatus;
            } catch (Exception $Error) {
                return $Error;
            }
        }

        /**
         * Functionality : Get Status in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Status
         * Return Type : array
         */
        public function FSaMImportGetStaPdtGroupInTemp(array $paParams = []){
            $tUserSessionID = $paParams['tUserSessionID'];

            $tSQL = "
                SELECT TOP 1
                    (SELECT COUNT(FTTmpTableKey) AS TYPESIX 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_DT'
                    AND IMP.FTTmpStatus = '6') AS nStaNewOrUpdate,

                    (SELECT COUNT(FTTmpTableKey) 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_DT'
                    AND IMP.FTTmpStatus = '1') AS nStaSuccess,

                    (SELECT COUNT(FTTmpTableKey) AS TYPEONE 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_DT'
                    ) AS nRecordTotal
                FROM TCNTImpMasTmp 
            ";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }
    /*===== End Product Group ======================================================*/

    /*===== Begin Condition กลุ่มซื้อ =================================================*/
        /**
         * Functionality : Get Import Data in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportGetCBDataInTmp(array $paParams = []){
            $tTableKey = $paParams['tTableKey'];
            $tUserSessionID = $paParams['tUserSessionID'];
            $tTextSearch = $paParams['tTextSearch'];

            $tSQL = " 
                SELECT 
                    FTPmdGrpName, FTPbyStaBuyCond, FCPbyMinValue, FCPbyMaxValue, FCPbyMinSetPri, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID
                FROM TCNTImpMasTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey = 'PMT_CB'
            ";

            if($tTextSearch != '' || $tTextSearch != null){
                $tSQL .= " 
                    AND (
                        FTPmdGrpName LIKE '%$tTextSearch%'
                    )
                ";
            }

            $tSQL .= " ORDER BY FNTmpSeq";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'success',
                    'aResult' => $oQuery->result_array(),
                    'nNumrow' => $oQuery->num_rows()
                );
            }else{
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                    'aResult' => array(),
                    'nNumrow' => 0
                );
            }
            return $aStatus;
        }

        /**
         * Functionality : Delete Data in Temp by SeqNo
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportDeleteCBInTempBySeq(array $paParams = []) {
            try{
                $this->db->where_in('FNTmpSeq', $paParams['aSeqNo']);
                $this->db->where('FTTmpTableKey', "PMT_CB");
                $this->db->where('FTSessionID', $paParams['tUserSessionID']);
                $this->db->delete('TCNTImpMasTmp');

                if($this->db->trans_status() === FALSE){
                    $aStatus = array(
                        'tCode' => '905',
                        'tDesc' => 'Delete Fail',
                    );
                }else{
                    $aStatus = array(
                        'tCode' => '1',
                        'tDesc' => 'Delete Success.',
                    );
                }
                return $aStatus;
            } catch (Exception $Error) {
                return $Error;
            }
        }

        /**
         * Functionality : Get Status in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Status
         * Return Type : array
         */
        public function FSaMImportGetStaCBInTemp(array $paParams = []){
            $tUserSessionID = $paParams['tUserSessionID'];

            $tSQL = "
                SELECT TOP 1
                    (SELECT COUNT(FTTmpTableKey) AS TYPESIX 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_CB'
                    AND IMP.FTTmpStatus = '6') AS nStaNewOrUpdate,

                    (SELECT COUNT(FTTmpTableKey) 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_CB'
                    AND IMP.FTTmpStatus = '1') AS nStaSuccess,

                    (SELECT COUNT(FTTmpTableKey) AS TYPEONE 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_CB'
                    ) AS nRecordTotal
                FROM TCNTImpMasTmp 
            ";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }
    /*===== End Condition กลุ่มซื้อ ===================================================*/

    /*===== Begin Option1-กลุ่มรับ(กรณีส่วนลด) =========================================*/
        /**
         * Functionality : Get Import Data in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportGetCGDataInTmp(array $paParams = []){
            $tTableKey = $paParams['tTableKey'];
            $tUserSessionID = $paParams['tUserSessionID'];
            $tTextSearch = $paParams['tTextSearch'];

            $tSQL = " 
                SELECT 
                    FTPmdGrpName, FTPgtStaGetType, FCPgtGetvalue, FCPgtGetQty, FTTmpStatus, FTTmpRemark, 
                    FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID
                FROM TCNTImpMasTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey = 'PMT_CG'
            ";

            if($tTextSearch != '' || $tTextSearch != null){
                $tSQL .= " 
                    AND (
                        FTPmdGrpName LIKE '%$tTextSearch%'
                    )
                ";
            }

            $tSQL .= " ORDER BY FNTmpSeq";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'success',
                    'aResult' => $oQuery->result_array(),
                    'nNumrow' => $oQuery->num_rows()
                );
            }else{
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                    'aResult' => array(),
                    'nNumrow' => 0
                );
            }
            return $aStatus;
        }

        /**
         * Functionality : Delete Data in Temp by SeqNo
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportDeleteCGInTempBySeq(array $paParams = []) {
            try{
                $this->db->where_in('FNTmpSeq', $paParams['aSeqNo']);
                $this->db->where('FTTmpTableKey', "PMT_CG");
                $this->db->where('FTSessionID', $paParams['tUserSessionID']);
                $this->db->delete('TCNTImpMasTmp');

                if($this->db->trans_status() === FALSE){
                    $aStatus = array(
                        'tCode' => '905',
                        'tDesc' => 'Delete Fail',
                    );
                }else{
                    $aStatus = array(
                        'tCode' => '1',
                        'tDesc' => 'Delete Success.',
                    );
                }
                return $aStatus;
            } catch (Exception $Error) {
                return $Error;
            }
        }

        /**
         * Functionality : Get Status in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Status
         * Return Type : array
         */
        public function FSaMImportGetStaCGInTemp(array $paParams = []){
            $tUserSessionID = $paParams['tUserSessionID'];

            $tSQL = "
                SELECT TOP 1
                    (SELECT COUNT(FTTmpTableKey) AS TYPESIX 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_CG'
                    AND IMP.FTTmpStatus = '6') AS nStaNewOrUpdate,

                    (SELECT COUNT(FTTmpTableKey) 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_CG'
                    AND IMP.FTTmpStatus = '1') AS nStaSuccess,

                    (SELECT COUNT(FTTmpTableKey) AS TYPEONE 
                    FROM TCNTImpMasTmp IMP  
                    WHERE IMP.FTSessionID = '$tUserSessionID'
                    AND IMP.FTTmpTableKey = 'PMT_CG'
                    ) AS nRecordTotal
                FROM TCNTImpMasTmp 
            ";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }
    /*===== End Option1-กลุ่มรับ(กรณีส่วนลด) ===========================================*/

    /*===== Begin Option2-กลุ่มรับ(กรณีcoupon) ========================================*/
        /**
         * Functionality : Get Import Data in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportGetCouponDataInTmp(array $paParams = []){
            $tUserSessionID = $paParams['tUserSessionID'];

            $tSQL = " 
                SELECT 
                    FTPgtStaCoupon, FTCphDocNo, FTPgtCpnText, 
                    FTTmpStatus, FTTmpRemark, FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID
                FROM TCNTImpMasTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey = 'PMT_COUPON'
            ";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'success',
                    'aResult' => $oQuery->result_array(),
                    'nNumrow' => $oQuery->num_rows()
                );
            }else{
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                    'aResult' => array(),
                    'nNumrow' => 0
                );
            }
            return $aStatus;
        }
    /*===== End Option2-กลุ่มรับ(กรณีcoupon) ==========================================*/

    /*===== Begin Option3-กลุ่มรับ(กรณีแต้ม) ===========================================*/
        /**
         * Functionality : Get Import Data in Temp
         * Parameters : $paParams
         * Creator : 04/08/2020 Piya
         * Last Modified : -
         * Return : Data in Temp
         * Return Type : array
         */
        public function FSaMImportGetPointDataInTmp(array $paParams = []){
            $tUserSessionID = $paParams['tUserSessionID'];

            $tSQL = " 
                SELECT 
                    FTPgtStaPoint, FTPgtStaPntCalType, FNPgtPntGet, FNPgtPntBuy, 
                    FTTmpStatus, FTTmpRemark, FNTmpSeq, FTBchCode, FDCreateOn, FTTmpTableKey, FTSessionID
                FROM TCNTImpMasTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey = 'PMT_POINT'
            ";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'success',
                    'aResult' => $oQuery->result_array(),
                    'nNumrow' => $oQuery->num_rows()
                );
            }else{
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                    'aResult' => array(),
                    'nNumrow' => 0
                );
            }
            return $aStatus;
        }
    /*===== End Option3-กลุ่มรับ(กรณีแต้ม) =============================================*/

    /*===== End Create Promotion By Import ============================================ */
}
