<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSalePaymentSummary extends CI_Model {

    //Functionality: Run Stored Procedure
    //Parameters:  Function Parameter
    //Creator: 04/04/2019 Witsarut(Bell)
    //Last Modified : - 
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreCReport($paDataFilter){

        $tCallStore = "{ CALL SP_RPTxPaymentSum2001002(?,?,?,?,?,?,?,?,?,?,?,?,?) }";

        $aDataStore = array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],   
            'ptRptCode'         => $paDataFilter['tRptCode'],
            'ptUsrSession'      => $paDataFilter['tSessionID'],
            'ptRcvF'            => $paDataFilter['tRcvCodeFrom'],
            'ptRcvT'            => $paDataFilter['tRcvCodeTo'],
            'ptBchF'            => $paDataFilter['tBchCodeFrom'],
            'ptBchT'            => $paDataFilter['tBchCodeTo'], 
            'ptShpF'            => $paDataFilter['tShpCodeFrom'],
            'ptShpT'            => $paDataFilter['tShpCodeTo'],    
            'ptDocDateF'        => $paDataFilter['tDateFrom'],
            'ptDocDateT'        => $paDataFilter['tDateTo'],
            'FNResult'          => 0,
        );

        $oQuery = $this->db->query($tCallStore,$aDataStore);
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }

    //Functionality: Calcurate Pagination
    //Parameters:  Function Parameter
    //Creator: 25/09/2019 Wasin(Yoshi)
    //Last Modified : -
    //Return : Call Store Proce
    //Return Type: Array
    public function FSaMRPTPagination($paDataWhere){
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           = " SELECT
                                COUNT(VDSALRC_Tmp.FTRptCode) AS rnCountPage
                            FROM TRPTVDSalRCTmp VDSALRC_Tmp WITH(NOLOCK)
                            WHERE 1=1
                            AND VDSALRC_Tmp.FTComName       = '$tCompName'
                            AND VDSALRC_Tmp.FTRptCode       = '$tRptCode'
                            AND VDSALRC_Tmp.FTUsrSession    = '$tUsrSession'
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

        $aRptMemberDet  = [
            "nTotalRecord"  => $nRptAllRecord,
            "nTotalPage"    => $nTotalPage,
            "nDisplayPage"  => $paDataWhere['nPage'],
            "nRowIDStart"   => $nRowIDStart,
            "nRowIDEnd"     => $nRowIDEnd,
            "nPrevPage"     => $nPrevPage,
            "nNextPage"     => $nNextPage
        ];
        unset($tCompName);
        unset($tRptCode);
        unset($tUsrSession);
        unset($tSQL);
        unset($oQuery);
        unset($nRptAllRecord);
        unset($nPage);
        unset($nPerPage);
        unset($nPrevPage);
        unset($nNextPage);
        unset($nRowIDStart);
        unset($nTotalPage);
        unset($nRowIDEnd);
        return $aRptMemberDet;
    }

    //Functionality: Set Priority Group
    //Parameters:  Function Parameter
    //Creator: 25/09/2019 Wasin(Yoshi)
    //Last Modified : -
    //Return : Call Store Proce
    //Return Type: Array
    public function FSxMRPTSetPriorityGroup($ptCompName,$ptRptCode,$ptUsrSession) {
        $tSQL   = " UPDATE TRPTVDSalRCTmp
                    SET FNRowPartID = B.PartID
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER(PARTITION BY FTRcvCode ORDER BY FTRcvCode ASC) AS PartID,
                            FTRptRowSeq
                        FROM TRPTVDSalRCTmp WITH(NOLOCK)
                        WHERE 1=1
                        AND TRPTVDSalRCTmp.FTComName    = '$ptCompName' 
                        AND TRPTVDSalRCTmp.FTRptCode    = '$ptRptCode'
                        AND TRPTVDSalRCTmp.FTUsrSession = '$ptUsrSession'
                    ) B
                    WHERE 1=1
                    AND TRPTVDSalRCTmp.FTRptRowSeq  = B.FTRptRowSeq 
                    AND TRPTVDSalRCTmp.FTComName    = '$ptCompName' 
                    AND TRPTVDSalRCTmp.FTRptCode    = '$ptRptCode'
                    AND TRPTVDSalRCTmp.FTUsrSession = '$ptUsrSession'
        ";
        $oQuery = $this->db->query($tSQL);
        unset($tSQL);
        unset($oQuery);
        return;
    }

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 04/04/2019 Witsarut(Bell)
    // LastModified: 25/09/2019 Wasin(Yoshi)
    // Return: Get Data Rpt Temp
    // ReturnType: Array
    public function FSaMGetDataReport($paDataWhere){

        $nPage          = $paDataWhere['nPage'];
        $aPagination    = $this->FSaMRPTPagination($paDataWhere);
        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $this->FSxMRPTSetPriorityGroup($tCompName,$tRptCode,$tUsrSession);
        if($nPage == $nTotalPage) {
            $tJoinFoooter   = " SELECT
                                    FTUsrSession    AS FTUsrSession_Footer,
                                    SUM(FCXrcNet)   AS FCXrcNet_Footer
                                FROM TRPTVDSalRCTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName       = '$tCompName'
                                AND FTRptCode       = '$tRptCode'
                                AND FTUsrSession    = '$tUsrSession'
                                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tJoinFoooter   = " SELECT
                                    '$tUsrSession'  AS FTUsrSession_Footer,
                                    0               AS FCXrcNet_Footer
                                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCXrcNet_Footer
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FTRcvCode) AS RowID,
                            A.*,
                            S.FNRptGroupMember,
                            S.FCXrcNet_SubTotal
                        FROM TRPTVDSalRCTmp A WITH(NOLOCK)
                        -- Calculate Misures
                        LEFT JOIN (
                            SELECT
                                FTRcvCode           AS FTRcvCode_SUM,
                                COUNT(FTRcvCode)    AS FNRptGroupMember,
                                SUM(FCXrcNet)       AS FCXrcNet_SubTotal
                            FROM TRPTVDSalRCTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tCompName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tUsrSession'
                            GROUP BY FTRcvCode
                        ) AS S ON A.FTRcvCode = S.FTRcvCode_SUM
                        WHERE A.FTComName       = '$tCompName'
                        AND   A.FTRptCode       = '$tRptCode'
                        AND   A.FTUsrSession    = '$tUsrSession'
                        -- End Calculate Misures
                    ) AS L
                    LEFT JOIN (
                        " . $tJoinFoooter . "
        ";

        // WHERE เงื่อนไข Page
        $tSQL   .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTRcvCode ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData  = $oQuery->result_array();
        } else {
            $aData  = NULL;
        }

        $aErrorList = [
            "nErrInvalidPage" => ""
        ];

        $aResualt = [
            'rtCode'        => '1',
            "aPagination"   => $aPagination,
            "nTotalPage"    => $nTotalPage,
            "aRptData"      => $aData,
            "aError"        => $aErrorList
        ];
        unset($nPage);
        unset($aPagination);
        unset($nRowIDStart);
        unset($nRowIDEnd);
        unset($nTotalPage);
        unset($tCompName);
        unset($tRptCode);
        unset($tUsrSession);
        unset($tJoinFoooter);
        unset($tSQL);
        unset($oQuery);
        unset($aData);
        unset($aErrorList);
        return $aResualt;
    }

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Witsarut(Bell)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMCountDataReportAll($paDataWhere){
        $tSessionID = $paDataWhere['tSessionID'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       = " SELECT 
                            COUNT(FTRptCode) AS rnCountPage
                        FROM TRPTVDSalRCTmp WITH(NOLOCK)
                        WHERE 1 = 1
                        AND FTUsrSession = '$tSessionID' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'
        ";
        $oQuery     = $this->db->query($tSQL);
        $aCountData = $oQuery->row_array();
        unset($tSessionID);
        unset($tCompName);
        unset($tRptCode);
        unset($tSQL);
        unset($oQuery);
        return $aCountData['rnCountPage'];
    }

}