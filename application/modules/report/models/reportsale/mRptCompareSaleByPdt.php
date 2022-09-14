<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptCompareSaleByPdt extends CI_Model {

    /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){

        $nLangID        = $paDataFilter['nLangID'];
        $tComName       = $paDataFilter['tCompName'];
        $tRptCode       = $paDataFilter['tRptCode'];
        $tUserSession   = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);


        $tChkRptGroup  = $paDataFilter['tGroupReport'];

        switch ($tChkRptGroup) {
            case '01' : //สาขา
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
            break;
            case '02' : // ตัวแทนขาย
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
            break;
            case '03' : // ร้านค้า
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
            break;
            case '04' : // สินค้า
                $tPdtCodeFrom = $paDataFilter['tPdtCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtCodeTo'];
            break;
            case '05' : // ประเภทสินค้า
                $tPdtCodeFrom = $paDataFilter['tPdtTypeCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtTypeCodeTo'];
            break;
            case '06' : // กลุ่มสินค้า
                $tPdtCodeFrom = $paDataFilter['tPdtGrpCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtGrpCodeTo'];
            break;
            case '07' :  // ยี่ห้อ
                $tPdtCodeFrom = $paDataFilter['tPdtBrandCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtBrandCodeTo'];
            break;
            case '08' :   // รุ่น
                $tPdtCodeFrom = $paDataFilter['tPdtModelCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtModelCodeTo'];
            break;
        }

        $tCallStore     =   "{CALL SP_RPTxPSCompareMTD(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        
        $aDataStore  =  array(
            'pnLngID'       => $nLangID , 
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            
            'ptRptGrp'      => $paDataFilter['tGroupReport'],
            'ptAgnL'        => $paDataFilter['tAgnCodeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptMerL'        => $tMerCodeSelect,
            'ptShpL'        => $tShpCodeSelect,
            'ptPosCodeL'    => $tPosCodeSelect,
            'ptCodeF'       => $tPdtCodeFrom,
            'ptCodeT'       => $tPdtCodeTo,
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'FTResult' => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }

    }


    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){

        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LM_LY, 0)
                    ) AS FCRptQtyMTD_LM_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LY, 0)
                    ) AS FCRptQtyMTD_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyDiff_LY, 0)
                    ) AS FCRptQtyDiff_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercen_LY, 0)
                    ) AS FCRptQtyPercen_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LM, 0)
                    ) AS FCRptQtyMTD_LM_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD, 0)
                    ) AS FCRptQtyMTD_Footer,
                    SUM( 
                        ISNULL(FCRptQtyDiff, 0)
                    ) AS FCRptQtyDiff_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercen, 0)
                    ) AS FCRptQtyPercen_Footer,
                    SUM( 
                        ISNULL(FCRptQtyCmp, 0)
                    ) AS FCRptQtyCmp_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercenCmp, 0)
                    ) AS FCRptQtyPercenCmp_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LM_LY, 0)
                    ) AS FCRptAmtMTD_LM_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LY, 0)
                    ) AS FCRptAmtMTD_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtvDiff_LY, 0)
                    ) AS FCRptAmtvDiff_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercen_LY, 0)
                    ) AS FCRptAmtPercen_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LM, 0)
                    ) AS FCRptAmtMTD_LM_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD, 0)
                    ) AS FCRptAmtMTD_Footer,
                    SUM( 
                        ISNULL(FCRptAmtDiff, 0)
                    ) AS FCRptAmtDiff_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercen, 0)
                    ) AS FCRptAmtPercen_Footer,
                    SUM( 
                        ISNULL(FCRptAmtCmp, 0)
                    ) AS FCRptAmtCmp_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercenCmp, 0)
                    ) AS FCRptAmtPercenCmp_Footer
                FROM TRPTPSCompareMTDTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCRptQtyMTD_LM_LY_Footer,
                    0 AS FCRptQtyMTD_LY_Footer,
                    0 AS FCRptQtyDiff_LY_Footer,
                    0 AS FCRptQtyPercen_LY_Footer,
                    0 AS FCRptQtyMTD_LM_Footer,
                    0 AS FCRptQtyMTD_Footer,
                    0 AS FCRptQtyDiff_Footer,
                    0 AS FCRptQtyPercen_Footer,
                    0 AS FCRptQtyCmp_Footer,
                    0 AS FCRptQtyPercenCmp_Footer,
                    0 AS FCRptAmtMTD_LM_LY_Footer,
                    0 AS FCRptAmtMTD_LY_Footer,
                    0 AS FCRptAmtvDiff_LY_Footer,
                    0 AS FCRptAmtPercen_LY_Footer,
                    0 AS FCRptAmtMTD_LM_Footer,
                    0 AS FCRptAmtMTD_Footer,
                    0 AS FCRptAmtDiff_Footer,
                    0 AS FCRptAmtPercen_Footer,
                    0 AS FCRptAmtCmp_Footer,
                    0 AS FCRptAmtPercenCmp_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCRptQtyMTD_LM_LY_Footer,
                        T.FCRptQtyMTD_LY_Footer,
                        T.FCRptQtyDiff_LY_Footer,
                        T.FCRptQtyPercen_LY_Footer,
                        T.FCRptQtyMTD_LM_Footer,
                        T.FCRptQtyMTD_Footer,
                        T.FCRptQtyDiff_Footer,
                        T.FCRptQtyPercen_Footer,
                        T.FCRptQtyCmp_Footer,
                        T.FCRptQtyPercenCmp_Footer,
                        T.FCRptAmtMTD_LM_LY_Footer,
                        T.FCRptAmtMTD_LY_Footer,
                        T.FCRptAmtvDiff_LY_Footer,
                        T.FCRptAmtPercen_LY_Footer,
                        T.FCRptAmtMTD_LM_Footer,
                        T.FCRptAmtMTD_Footer,
                        T.FCRptAmtDiff_Footer,
                        T.FCRptAmtPercen_Footer,
                        T.FCRptAmtCmp_Footer,
                        T.FCRptAmtPercenCmp_Footer
                    FROM (
                        SELECT
                        ROW_NUMBER() OVER(ORDER BY FTRptGrpCode ASC) AS RowID ,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCRptQtyMTD_LM_LY_SubTotal,
                        S.FCRptQtyMTD_LY_SubTotal,
                        S.FCRptQtyDiff_LY_SubTotal,
                        S.FCRptQtyPercen_LY_SubTotal,
                        S.FCRptQtyMTD_LM_SubTotal,
                        S.FCRptQtyMTD_SubTotal,
                        S.FCRptQtyDiff_SubTotal,
                        S.FCRptQtyPercen_SubTotal,
                        S.FCRptQtyCmp_SubTotal,
                        S.FCRptQtyPercenCmp_SubTotal,
                        S.FCRptAmtMTD_LM_LY_SubTotal,
                        S.FCRptAmtMTD_LY_SubTotal,
                        S.FCRptAmtvDiff_LY_SubTotal,
                        S.FCRptAmtPercen_LY_SubTotal,
                        S.FCRptAmtMTD_LM_SubTotal,
                        S.FCRptAmtMTD_SubTotal,
                        S.FCRptAmtDiff_SubTotal,
                        S.FCRptAmtPercen_SubTotal,
                        S.FCRptAmtCmp_SubTotal,
                        S.FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareMTDTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                    LEFT JOIN (
                        SELECT
                        FTRptGrpCode            AS FTRptGrpCode_SUM,
                        COUNT(FTRptGrpCode)     AS FNRptGroupMember,
                        SUM(FCRptQtyMTD_LM_LY)  AS FCRptQtyMTD_LM_LY_SubTotal,
                        SUM(FCRptQtyMTD_LY)     AS FCRptQtyMTD_LY_SubTotal,
                        SUM(FCRptQtyDiff_LY)    AS FCRptQtyDiff_LY_SubTotal,
                        SUM(FCRptQtyPercen_LY)  AS FCRptQtyPercen_LY_SubTotal,
                        SUM(FCRptQtyMTD_LM)     AS FCRptQtyMTD_LM_SubTotal,
                        SUM(FCRptQtyMTD)        AS FCRptQtyMTD_SubTotal,
                        SUM(FCRptQtyDiff)       AS FCRptQtyDiff_SubTotal,
                        SUM(FCRptQtyPercen)     AS FCRptQtyPercen_SubTotal,
                        SUM(FCRptQtyCmp)        AS FCRptQtyCmp_SubTotal,
                        SUM(FCRptQtyPercenCmp)  AS FCRptQtyPercenCmp_SubTotal,
                        SUM(FCRptAmtMTD_LM_LY)  AS FCRptAmtMTD_LM_LY_SubTotal,
                        SUM(FCRptAmtMTD_LY)     AS FCRptAmtMTD_LY_SubTotal,
                        SUM(FCRptAmtvDiff_LY)   AS FCRptAmtvDiff_LY_SubTotal,
                        SUM(FCRptAmtPercen_LY)  AS FCRptAmtPercen_LY_SubTotal,
                        SUM(FCRptAmtMTD_LM)     AS FCRptAmtMTD_LM_SubTotal,
                        SUM(FCRptAmtMTD)        AS FCRptAmtMTD_SubTotal,
                        SUM(FCRptAmtDiff)       AS FCRptAmtDiff_SubTotal,
                        SUM(FCRptAmtPercen)     AS FCRptAmtPercen_SubTotal,
                        SUM(FCRptAmtCmp)        AS FCRptAmtCmp_SubTotal,
                        SUM(FCRptAmtPercenCmp)  AS FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareMTDTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTRptGrpCode
                    ) AS S ON A.FTRptGrpCode  = S.FTRptGrpCode_SUM
                    WHERE A.FTComName       = '$tComName'
                    AND   A.FTRptCode       = '$tRptCode'
                    AND   A.FTUsrSession    = '$tUsrSession'
                    /* End Calculate Misures */
                ) AS L
                LEFT JOIN (
                    " . $tRptJoinFooter . "
                ";

            // WHERE เงื่อนไข Page
            $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";  

            //สั่ง Order by ตามข้อมูลหลัก
            $tSQL .= " ORDER BY L.FTRptGrpCode";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aData = $oQuery->result_array();
            } else {
                $aData = NULL;
            }
    
            $aErrorList = array(
                "nErrInvalidPage" => ""
            );
    
            $aResualt = array(
                "aPagination" => $aPagination,
                "aRptData" => $aData,
                "aError" => $aErrorList
            );
            unset($oQuery);
            unset($aData);
        return $aResualt;
    }



     /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            UPDATE TRPTPSCompareMTDTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT  
                    ROW_NUMBER() OVER(PARTITION BY FTRptGrpCode ORDER BY FTRptGrpCode ASC) AS PartID,
                    FTRptRowSeq  
                FROM TRPTPSCompareMTDTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$tComName' 
                AND TMP.FTRptCode   = '$tRptCode'
                AND TMP.FTUsrSession = '$tUsrSession'";

            $tSQL .= "
                ) AS B
                WHERE TRPTPSCompareMTDTmp.FTRptRowSeq = B.FTRptRowSeq 
                AND TRPTPSCompareMTDTmp.FTComName = '$tComName' 
                AND TRPTPSCompareMTDTmp.FTRptCode = '$tRptCode'
                AND TRPTPSCompareMTDTmp.FTUsrSession = '$tUsrSession'";
              
        $this->db->query($tSQL);
    }


    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];


        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTPSCompareMTDTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'";

            $oQuery = $this->db->query($tSQL);
            $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
            $nPage = $paDataWhere['nPage'];
        
        $nPerPage = $paDataWhere['nPerPage'];
        
        $nPrevPage = $nPage-1;
        $nNextPage = $nPage+1;
        $nRowIDStart = (($nPerPage*$nPage)-$nPerPage); //RowId Start
        if($nRptAllRecord<=$nPerPage){
            $nTotalPage = 1;
        }else if(($nRptAllRecord % $nPerPage)==0){
            $nTotalPage = ($nRptAllRecord/$nPerPage) ;
        }else{
            $nTotalPage = ($nRptAllRecord/$nPerPage)+1;
            $nTotalPage = (int)$nTotalPage;
        }

        // get rowid end
        $nRowIDEnd = $nPerPage * $nPage;
        if($nRowIDEnd > $nRptAllRecord){
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord" => $nRptAllRecord,
            "nTotalPage" => $nTotalPage,
            "nDisplayPage" => $paDataWhere['nPage'],
            "nRowIDStart" => $nRowIDStart,
            "nRowIDEnd" => $nRowIDEnd,
            "nPrevPage" => $nPrevPage,
            "nNextPage" => $nNextPage,
            "nPerPage" => $nPerPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }



    // funation  get data chat
    // Create By Witsarut 05/02/2021
    public function FSaMGetDataReportChat($paDataWhere){
        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LM_LY, 0)
                    ) AS FCRptQtyMTD_LM_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LY, 0)
                    ) AS FCRptQtyMTD_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyDiff_LY, 0)
                    ) AS FCRptQtyDiff_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercen_LY, 0)
                    ) AS FCRptQtyPercen_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LM, 0)
                    ) AS FCRptQtyMTD_LM_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD, 0)
                    ) AS FCRptQtyMTD_Footer,
                    SUM( 
                        ISNULL(FCRptQtyDiff, 0)
                    ) AS FCRptQtyDiff_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercen, 0)
                    ) AS FCRptQtyPercen_Footer,
                    SUM( 
                        ISNULL(FCRptQtyCmp, 0)
                    ) AS FCRptQtyCmp_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercenCmp, 0)
                    ) AS FCRptQtyPercenCmp_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LM_LY, 0)
                    ) AS FCRptAmtMTD_LM_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LY, 0)
                    ) AS FCRptAmtMTD_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtvDiff_LY, 0)
                    ) AS FCRptAmtvDiff_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercen_LY, 0)
                    ) AS FCRptAmtPercen_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LM, 0)
                    ) AS FCRptAmtMTD_LM_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD, 0)
                    ) AS FCRptAmtMTD_Footer,
                    SUM( 
                        ISNULL(FCRptAmtDiff, 0)
                    ) AS FCRptAmtDiff_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercen, 0)
                    ) AS FCRptAmtPercen_Footer,
                    SUM( 
                        ISNULL(FCRptAmtCmp, 0)
                    ) AS FCRptAmtCmp_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercenCmp, 0)
                    ) AS FCRptAmtPercenCmp_Footer
                FROM TRPTPSCompareMTDTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCRptQtyMTD_LM_LY_Footer,
                    0 AS FCRptQtyMTD_LY_Footer,
                    0 AS FCRptQtyDiff_LY_Footer,
                    0 AS FCRptQtyPercen_LY_Footer,
                    0 AS FCRptQtyMTD_LM_Footer,
                    0 AS FCRptQtyMTD_Footer,
                    0 AS FCRptQtyDiff_Footer,
                    0 AS FCRptQtyPercen_Footer,
                    0 AS FCRptQtyCmp_Footer,
                    0 AS FCRptQtyPercenCmp_Footer,
                    0 AS FCRptAmtMTD_LM_LY_Footer,
                    0 AS FCRptAmtMTD_LY_Footer,
                    0 AS FCRptAmtvDiff_LY_Footer,
                    0 AS FCRptAmtPercen_LY_Footer,
                    0 AS FCRptAmtMTD_LM_Footer,
                    0 AS FCRptAmtMTD_Footer,
                    0 AS FCRptAmtDiff_Footer,
                    0 AS FCRptAmtPercen_Footer,
                    0 AS FCRptAmtCmp_Footer,
                    0 AS FCRptAmtPercenCmp_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCRptQtyMTD_LM_LY_Footer,
                        T.FCRptQtyMTD_LY_Footer,
                        T.FCRptQtyDiff_LY_Footer,
                        T.FCRptQtyPercen_LY_Footer,
                        T.FCRptQtyMTD_LM_Footer,
                        T.FCRptQtyMTD_Footer,
                        T.FCRptQtyDiff_Footer,
                        T.FCRptQtyPercen_Footer,
                        T.FCRptQtyCmp_Footer,
                        T.FCRptQtyPercenCmp_Footer,
                        T.FCRptAmtMTD_LM_LY_Footer,
                        T.FCRptAmtMTD_LY_Footer,
                        T.FCRptAmtvDiff_LY_Footer,
                        T.FCRptAmtPercen_LY_Footer,
                        T.FCRptAmtMTD_LM_Footer,
                        T.FCRptAmtMTD_Footer,
                        T.FCRptAmtDiff_Footer,
                        T.FCRptAmtPercen_Footer,
                        T.FCRptAmtCmp_Footer,
                        T.FCRptAmtPercenCmp_Footer
                    FROM (
                        SELECT
                        ROW_NUMBER() OVER(ORDER BY FTRptGrpCode ASC) AS RowID ,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCRptQtyMTD_LM_LY_SubTotal,
                        S.FCRptQtyMTD_LY_SubTotal,
                        S.FCRptQtyDiff_LY_SubTotal,
                        S.FCRptQtyPercen_LY_SubTotal,
                        S.FCRptQtyMTD_LM_SubTotal,
                        S.FCRptQtyMTD_SubTotal,
                        S.FCRptQtyDiff_SubTotal,
                        S.FCRptQtyPercen_SubTotal,
                        S.FCRptQtyCmp_SubTotal,
                        S.FCRptQtyPercenCmp_SubTotal,
                        S.FCRptAmtMTD_LM_LY_SubTotal,
                        S.FCRptAmtMTD_LY_SubTotal,
                        S.FCRptAmtvDiff_LY_SubTotal,
                        S.FCRptAmtPercen_LY_SubTotal,
                        S.FCRptAmtMTD_LM_SubTotal,
                        S.FCRptAmtMTD_SubTotal,
                        S.FCRptAmtDiff_SubTotal,
                        S.FCRptAmtPercen_SubTotal,
                        S.FCRptAmtCmp_SubTotal,
                        S.FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareMTDTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                    LEFT JOIN (
                        SELECT
                        FTRptGrpCode            AS FTRptGrpCode_SUM,
                        COUNT(FTRptGrpCode)     AS FNRptGroupMember,
                        SUM(FCRptQtyMTD_LM_LY)  AS FCRptQtyMTD_LM_LY_SubTotal,
                        SUM(FCRptQtyMTD_LY)     AS FCRptQtyMTD_LY_SubTotal,
                        SUM(FCRptQtyDiff_LY)    AS FCRptQtyDiff_LY_SubTotal,
                        SUM(FCRptQtyPercen_LY)  AS FCRptQtyPercen_LY_SubTotal,
                        SUM(FCRptQtyMTD_LM)     AS FCRptQtyMTD_LM_SubTotal,
                        SUM(FCRptQtyMTD)        AS FCRptQtyMTD_SubTotal,
                        SUM(FCRptQtyDiff)       AS FCRptQtyDiff_SubTotal,
                        SUM(FCRptQtyPercen)     AS FCRptQtyPercen_SubTotal,
                        SUM(FCRptQtyCmp)        AS FCRptQtyCmp_SubTotal,
                        SUM(FCRptQtyPercenCmp)  AS FCRptQtyPercenCmp_SubTotal,
                        SUM(FCRptAmtMTD_LM_LY)  AS FCRptAmtMTD_LM_LY_SubTotal,
                        SUM(FCRptAmtMTD_LY)     AS FCRptAmtMTD_LY_SubTotal,
                        SUM(FCRptAmtvDiff_LY)   AS FCRptAmtvDiff_LY_SubTotal,
                        SUM(FCRptAmtPercen_LY)  AS FCRptAmtPercen_LY_SubTotal,
                        SUM(FCRptAmtMTD_LM)     AS FCRptAmtMTD_LM_SubTotal,
                        SUM(FCRptAmtMTD)        AS FCRptAmtMTD_SubTotal,
                        SUM(FCRptAmtDiff)       AS FCRptAmtDiff_SubTotal,
                        SUM(FCRptAmtPercen)     AS FCRptAmtPercen_SubTotal,
                        SUM(FCRptAmtCmp)        AS FCRptAmtCmp_SubTotal,
                        SUM(FCRptAmtPercenCmp)  AS FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareMTDTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTRptGrpCode
                    ) AS S ON A.FTRptGrpCode  = S.FTRptGrpCode_SUM
                    WHERE A.FTComName       = '$tComName'
                    AND   A.FTRptCode       = '$tRptCode'
                    AND   A.FTUsrSession    = '$tUsrSession'
                    /* End Calculate Misures */
                ) AS L
                LEFT JOIN (
                    " . $tRptJoinFooter . "
                ";

            // WHERE เงื่อนไข Page
            $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";  

            //สั่ง Order by ตามข้อมูลหลัก
            $tSQL .= " ORDER BY L.FTRptGrpCode";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aData = $oQuery->result_array();
            } else {
                // $aData = NULL;
                $aData = array(array("FTRptGrpName" => "", "FCRptAmtMTD_LY" => "0", "FCRptAmtMTD" => "0"));
            }
    
            $aErrorList = array(
                "nErrInvalidPage" => ""
            );
    
            $aResualt = array(
                "aPagination" => $aPagination,
                "aRptData" => $aData,
                "aError" => $aErrorList
            );
            unset($oQuery);
            unset($aData);
        return $aResualt;
    }


    // funation  get data chat
    // Create By Witsarut 05/02/2021
    public function FSaMGetDataReportChatQty($paDataWhere){

        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LM_LY, 0)
                    ) AS FCRptQtyMTD_LM_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LY, 0)
                    ) AS FCRptQtyMTD_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyDiff_LY, 0)
                    ) AS FCRptQtyDiff_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercen_LY, 0)
                    ) AS FCRptQtyPercen_LY_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD_LM, 0)
                    ) AS FCRptQtyMTD_LM_Footer,
                    SUM( 
                        ISNULL(FCRptQtyMTD, 0)
                    ) AS FCRptQtyMTD_Footer,
                    SUM( 
                        ISNULL(FCRptQtyDiff, 0)
                    ) AS FCRptQtyDiff_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercen, 0)
                    ) AS FCRptQtyPercen_Footer,
                    SUM( 
                        ISNULL(FCRptQtyCmp, 0)
                    ) AS FCRptQtyCmp_Footer,
                    SUM( 
                        ISNULL(FCRptQtyPercenCmp, 0)
                    ) AS FCRptQtyPercenCmp_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LM_LY, 0)
                    ) AS FCRptAmtMTD_LM_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LY, 0)
                    ) AS FCRptAmtMTD_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtvDiff_LY, 0)
                    ) AS FCRptAmtvDiff_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercen_LY, 0)
                    ) AS FCRptAmtPercen_LY_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD_LM, 0)
                    ) AS FCRptAmtMTD_LM_Footer,
                    SUM( 
                        ISNULL(FCRptAmtMTD, 0)
                    ) AS FCRptAmtMTD_Footer,
                    SUM( 
                        ISNULL(FCRptAmtDiff, 0)
                    ) AS FCRptAmtDiff_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercen, 0)
                    ) AS FCRptAmtPercen_Footer,
                    SUM( 
                        ISNULL(FCRptAmtCmp, 0)
                    ) AS FCRptAmtCmp_Footer,
                    SUM( 
                        ISNULL(FCRptAmtPercenCmp, 0)
                    ) AS FCRptAmtPercenCmp_Footer
                FROM TRPTPSCompareMTDTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCRptQtyMTD_LM_LY_Footer,
                    0 AS FCRptQtyMTD_LY_Footer,
                    0 AS FCRptQtyDiff_LY_Footer,
                    0 AS FCRptQtyPercen_LY_Footer,
                    0 AS FCRptQtyMTD_LM_Footer,
                    0 AS FCRptQtyMTD_Footer,
                    0 AS FCRptQtyDiff_Footer,
                    0 AS FCRptQtyPercen_Footer,
                    0 AS FCRptQtyCmp_Footer,
                    0 AS FCRptQtyPercenCmp_Footer,
                    0 AS FCRptAmtMTD_LM_LY_Footer,
                    0 AS FCRptAmtMTD_LY_Footer,
                    0 AS FCRptAmtvDiff_LY_Footer,
                    0 AS FCRptAmtPercen_LY_Footer,
                    0 AS FCRptAmtMTD_LM_Footer,
                    0 AS FCRptAmtMTD_Footer,
                    0 AS FCRptAmtDiff_Footer,
                    0 AS FCRptAmtPercen_Footer,
                    0 AS FCRptAmtCmp_Footer,
                    0 AS FCRptAmtPercenCmp_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCRptQtyMTD_LM_LY_Footer,
                        T.FCRptQtyMTD_LY_Footer,
                        T.FCRptQtyDiff_LY_Footer,
                        T.FCRptQtyPercen_LY_Footer,
                        T.FCRptQtyMTD_LM_Footer,
                        T.FCRptQtyMTD_Footer,
                        T.FCRptQtyDiff_Footer,
                        T.FCRptQtyPercen_Footer,
                        T.FCRptQtyCmp_Footer,
                        T.FCRptQtyPercenCmp_Footer,
                        T.FCRptAmtMTD_LM_LY_Footer,
                        T.FCRptAmtMTD_LY_Footer,
                        T.FCRptAmtvDiff_LY_Footer,
                        T.FCRptAmtPercen_LY_Footer,
                        T.FCRptAmtMTD_LM_Footer,
                        T.FCRptAmtMTD_Footer,
                        T.FCRptAmtDiff_Footer,
                        T.FCRptAmtPercen_Footer,
                        T.FCRptAmtCmp_Footer,
                        T.FCRptAmtPercenCmp_Footer
                    FROM (
                        SELECT
                        ROW_NUMBER() OVER(ORDER BY FTRptGrpCode ASC) AS RowID ,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCRptQtyMTD_LM_LY_SubTotal,
                        S.FCRptQtyMTD_LY_SubTotal,
                        S.FCRptQtyDiff_LY_SubTotal,
                        S.FCRptQtyPercen_LY_SubTotal,
                        S.FCRptQtyMTD_LM_SubTotal,
                        S.FCRptQtyMTD_SubTotal,
                        S.FCRptQtyDiff_SubTotal,
                        S.FCRptQtyPercen_SubTotal,
                        S.FCRptQtyCmp_SubTotal,
                        S.FCRptQtyPercenCmp_SubTotal,
                        S.FCRptAmtMTD_LM_LY_SubTotal,
                        S.FCRptAmtMTD_LY_SubTotal,
                        S.FCRptAmtvDiff_LY_SubTotal,
                        S.FCRptAmtPercen_LY_SubTotal,
                        S.FCRptAmtMTD_LM_SubTotal,
                        S.FCRptAmtMTD_SubTotal,
                        S.FCRptAmtDiff_SubTotal,
                        S.FCRptAmtPercen_SubTotal,
                        S.FCRptAmtCmp_SubTotal,
                        S.FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareMTDTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                    LEFT JOIN (
                        SELECT
                        FTRptGrpCode            AS FTRptGrpCode_SUM,
                        COUNT(FTRptGrpCode)     AS FNRptGroupMember,
                        SUM(FCRptQtyMTD_LM_LY)  AS FCRptQtyMTD_LM_LY_SubTotal,
                        SUM(FCRptQtyMTD_LY)     AS FCRptQtyMTD_LY_SubTotal,
                        SUM(FCRptQtyDiff_LY)    AS FCRptQtyDiff_LY_SubTotal,
                        SUM(FCRptQtyPercen_LY)  AS FCRptQtyPercen_LY_SubTotal,
                        SUM(FCRptQtyMTD_LM)     AS FCRptQtyMTD_LM_SubTotal,
                        SUM(FCRptQtyMTD)        AS FCRptQtyMTD_SubTotal,
                        SUM(FCRptQtyDiff)       AS FCRptQtyDiff_SubTotal,
                        SUM(FCRptQtyPercen)     AS FCRptQtyPercen_SubTotal,
                        SUM(FCRptQtyCmp)        AS FCRptQtyCmp_SubTotal,
                        SUM(FCRptQtyPercenCmp)  AS FCRptQtyPercenCmp_SubTotal,
                        SUM(FCRptAmtMTD_LM_LY)  AS FCRptAmtMTD_LM_LY_SubTotal,
                        SUM(FCRptAmtMTD_LY)     AS FCRptAmtMTD_LY_SubTotal,
                        SUM(FCRptAmtvDiff_LY)   AS FCRptAmtvDiff_LY_SubTotal,
                        SUM(FCRptAmtPercen_LY)  AS FCRptAmtPercen_LY_SubTotal,
                        SUM(FCRptAmtMTD_LM)     AS FCRptAmtMTD_LM_SubTotal,
                        SUM(FCRptAmtMTD)        AS FCRptAmtMTD_SubTotal,
                        SUM(FCRptAmtDiff)       AS FCRptAmtDiff_SubTotal,
                        SUM(FCRptAmtPercen)     AS FCRptAmtPercen_SubTotal,
                        SUM(FCRptAmtCmp)        AS FCRptAmtCmp_SubTotal,
                        SUM(FCRptAmtPercenCmp)  AS FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareMTDTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTRptGrpCode
                    ) AS S ON A.FTRptGrpCode  = S.FTRptGrpCode_SUM
                    WHERE A.FTComName       = '$tComName'
                    AND   A.FTRptCode       = '$tRptCode'
                    AND   A.FTUsrSession    = '$tUsrSession'
                    /* End Calculate Misures */
                ) AS L
                LEFT JOIN (
                    " . $tRptJoinFooter . "
                ";

            // WHERE เงื่อนไข Page
            $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";  

            //สั่ง Order by ตามข้อมูลหลัก
            $tSQL .= " ORDER BY L.FTRptGrpCode";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aData = $oQuery->result_array();
            } else {
                $aData = array(array("FTRptGrpName" => "", "FCRptQtyMTD_LY" => "0", "FCRptQtyMTD" => "0"));
            }
    
            $aErrorList = array(
                "nErrInvalidPage" => ""
            );
    
            $aResualt = array(
                "aPagination" => $aPagination,
                "aRptData" => $aData,
                "aError" => $aErrorList
            );
            unset($oQuery);
            unset($aData);
        return $aResualt;
    }




        // Functionality: Get Data Top 10 Best Seller By Value  Qty
    // Parameters: function parameters
    // Creator:  17/07/2020 Worakorn
    // Last Update: 09/02/2022 Witsarut(Bell)
    // Return: Data Array
    // Return Type: Array
    public function FSaMGetDataReportQty($paDataWhere)
    {
        try {

            $tRptCode    = $paDataWhere['tRptCode'];
            $tUsrSession = $paDataWhere['tUsrSessionID'];
            $tComName    = $paDataWhere['tCompName'];
            $tWhere = '';
            if (!empty($paDataWhere['tCode'])) {
                $tWhere = " AND FTRptGrpCode " . $paDataWhere['tCode'] . " ";
            }

            $tSQL = " SELECT TOP 10 FTRptGrp,FTRptGrpName,FCRptQtyMTD_LY,FCRptQtyMTD
                        FROM TRPTPSCompareMTDTmp
                        WHERE 1 = 1
                    AND FTComName    = '$tComName'
                    AND FTRptCode    = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    $tWhere
                    -- AND FTRptGrpName != ''
                    ORDER BY FTRptGrpCode
            ";

            $oQuery  = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aData = $oQuery->result_array();
            } else {
                $aData = array(array("FTRptGrpName" => "N/A", "FCRptQtyMTD_LY" => "0", "FCRptQtyMTD" => "0","FTRptGrp" => ''));
            }

            $aResult = array(
                "aRptData" => $aData,
            );

            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    // Functionality: Get Data Top 10 Best Seller By Value Amt
    // Parameters: function parameters
    // Creator:  17/07/2020 Worakorn
    // Last Update: 09/02/2022 Witsarut(Bell)
    // Return: Data Array
    // Return Type: Array
    public function FSaMGetDataReportAmt($paDataWhere)
    {
        try {
            $tRptCode    = $paDataWhere['tRptCode'];
            $tUsrSession = $paDataWhere['tUsrSessionID'];
            $tComName    = $paDataWhere['tCompName'];
            $tWhere = '';
            if (!empty($paDataWhere['tCode'])) {
                $tWhere = " AND FTRptGrpCode " . $paDataWhere['tCode'] . " ";
            }

            $tSQL = " SELECT TOP 10  FTRptGrp,FTRptGrpName,FCRptAmtMTD_LY,FCRptAmtMTD
                        FROM TRPTPSCompareMTDTmp
                        WHERE 1 = 1
                    AND FTComName    = '$tComName'
                    AND FTRptCode    = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    $tWhere
                    -- AND FTRptGrpName != ''
                    ORDER BY FTRptGrpCode
            ";

            $oQuery  = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aData = $oQuery->result_array();
            } else {
                $aData = array(array("FTRptGrpName" => "N/A", "FCRptAmtMTD_LY" => "0", "FCRptAmtMTD" => "0","FTRptGrp" => ''));
            }

            $aResult = array(
                "aRptData" => $aData,
            );

            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

        
}



