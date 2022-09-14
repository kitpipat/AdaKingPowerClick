<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptPdtSalePromotion extends CI_Model {

    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/01/2021 
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter) {

        // สาขา
        $tBchCodeSelect =   FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 

        // ร้านค้า
        $tShpCodeSelect =   FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect =   FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect =   FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore     = "{ CALL SP_RPTxPSByPdtPmt(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        
        $aDataStore = array(
            'pnLngID'         => $paDataFilter['nLangID'],
            'pnComName'       => $paDataFilter['tCompName'],
            'ptRptCode'       => $paDataFilter['tRptCode'],
            'ptUsrSession'    => $paDataFilter['tSessionID'],
            'pnFilterType'    => $paDataFilter['tTypeSelect'],

            'ptBchL'          => $tBchCodeSelect,
            'ptBchF'          => $paDataFilter['tBchCodeFrom'],
            'ptBchT'          => $paDataFilter['tBchCodeTo'],

            'ptMerL'          => $tMerCodeSelect,
            'ptMerF'          => $paDataFilter['tMerCodeFrom'],
            'ptMerT'          => $paDataFilter['tMerCodeTo'],

            'ptShpL'          => $tShpCodeSelect,
            'ptShpF'          => $paDataFilter['tShpCodeFrom'],
            'ptShpT'          => $paDataFilter['tShpCodeTo'],

            'ptPosL'          => $tPosCodeSelect,
            'ptPosF'          => $paDataFilter['tPosCodeFrom'],
            'ptPosT'          => $paDataFilter['tPosCodeTo'],

            'ptSplF'          => $paDataFilter['tSupplierCodeFrom'],
            'ptSplT'          => $paDataFilter['tSupplierCodeTo'],

            'ptDocDateF'      => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'      => $paDataFilter['tDocDateTo'],

            'FNResult'        => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        echo $this->db->last_query();

        if ($oQuery !== FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }


    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/08/2021 Witsarut(Bell)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){
        
        $nPage  =  $paDataWhere['nPage'];

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
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   
                SELECT
                    FTUsrSession            AS FTUsrSession_Footer,
                    SUM(FCXsdQty)           AS FCXsdQty_Footer,    
                    SUM(FCXsdNet)           AS FCXsdNet_Footer,
                    SUM(FCXpdDis)           AS FCXpdDis_Footer,
                    SUM(FCXsdNetPmt)        AS FCXsdNetPmt_Footer
                FROM TRPTPSByPdtPmtTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName       = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "   
                SELECT
                    '$tUsrSession'  AS FTUsrSession_Footer,
                    '0'             AS FCXsdQty_Footer,
                    '0'             AS FCXsdNet_Footer,
                    '0'             AS FCXpdDis_Footer,
                    '0'             AS FCXsdNetPmt_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCXsdQty_Footer,
                        T.FCXsdNet_Footer,
                        T.FCXpdDis_Footer,
                        T.FCXsdNetPmt_Footer
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FTPmhDocNo ASC) AS RowID ,
                            A.*,
                            S.FNRptGroupMember,
                            S.FCXsdQty_SubTotal,
                            S.FCXsdNet_SubTotal,
                            S.FCXpdDis_SubTotal,
                            S.FCXsdNetPmt_SubTotal
                        FROM TRPTPSByPdtPmtTmp A WITH(NOLOCK)
                        /* Calculate Misures */
                        LEFT JOIN (
                            SELECT
                                FTPmhDocNo          AS FTPmhDocNo_SUM,
                                FTXpdGetType        AS FTXpdGetType_SUM,
                                COUNT(FTPmhDocNo)   AS FNRptGroupMember,
                                SUM(FCXsdQty)       AS FCXsdQty_SubTotal,
                                SUM(FCXsdNet)       AS FCXsdNet_SubTotal,
                                SUM(FCXpdDis)       AS FCXpdDis_SubTotal,
                                SUM(FCXsdNetPmt)    AS FCXsdNetPmt_SubTotal
                            FROM TRPTPSByPdtPmtTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tUsrSession'
                            GROUP BY FTPmhDocNo,FTXpdGetType
                        ) AS S ON A.FTPmhDocNo  = S.FTPmhDocNo_SUM
                        AND A.FTXpdGetType      = S.FTXpdGetType_SUM
                        WHERE A.FTComName       = '$tComName'
                        AND   A.FTRptCode       = '$tRptCode'
                        AND   A.FTUsrSession    = '$tUsrSession'
                        /* End Calculate Misures */
                    ) AS L
                    LEFT JOIN (
                    " . $tJoinFoooter . "
                ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";   

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTPmhDocNo";

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


    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 19/01/2021 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMxMRPTSetPriorityGroup($paDataWhere){

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL   = " UPDATE TRPTPSByPdtPmtTmp
                        SET FNRowPartID = B.PartID
                    FROM(
                        SELECT
                            ROW_NUMBER() OVER(PARTITION BY FTPmhDocNo,FTXpdGetType ORDER BY FTPmhDocNo DESC) AS PartID,
                            FTRptRowSeq
                        FROM TRPTPSByPdtPmtTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName     = '$tComName' 
                        AND TMP.FTRptCode       = '$tRptCode'
                        AND TMP.FTUsrSession    = '$tUsrSession'
                    ) AS B
                    WHERE TRPTPSByPdtPmtTmp.FTRptRowSeq = B.FTRptRowSeq
                    AND TRPTPSByPdtPmtTmp.FTComName      = '$tComName'
                    AND TRPTPSByPdtPmtTmp.FTRptCode      = '$tRptCode'
                    AND TRPTPSByPdtPmtTmp.FTUsrSession   = '$tUsrSession'
                ";

        $this->db->query($tSQL);
    }


    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 19/01/2021 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){

        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(TMP.FTPmhDocNo) AS rnCountPage
            FROM TRPTPSByPdtPmtTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName    = '$tComName'
            AND TMP.FTRptCode    = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery         = $this->db->query($tSQL);
        $nRptAllRecord  = $oQuery->row_array()['rnCountPage'];
        $nPage          = $paDataWhere['nPage'];
        $nPerPage       = $paDataWhere['nPerPage'];
        $nPrevPage      = $nPage - 1;
        $nNextPage      = $nPage + 1;
        $nRowIDStart    = (($nPerPage * $nPage) - $nPerPage); //RowId Start
        if ($nRptAllRecord <= $nPerPage) {
            $nTotalPage = 1;
        } else if (($nRptAllRecord % $nPerPage) == 0) {
            $nTotalPage = ($nRptAllRecord / $nPerPage);
        } else {
            $nTotalPage = ($nRptAllRecord / $nPerPage) + 1;
            $nTotalPage = (int) $nTotalPage;
        }

        // get rowid end
        $nRowIDEnd = $nPerPage * $nPage;
        if ($nRowIDEnd > $nRptAllRecord) {
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord"  => $nRptAllRecord,
            "nTotalPage"    => $nTotalPage,
            "nDisplayPage"  => $paDataWhere['nPage'],
            "nRowIDStart"   => $nRowIDStart,
            "nRowIDEnd"     => $nRowIDEnd,
            "nPrevPage"     => $nPrevPage,
            "nNextPage"     => $nNextPage
        );

        unset($oQuery);
        return $aRptMemberDet;
    }
   
        
}



