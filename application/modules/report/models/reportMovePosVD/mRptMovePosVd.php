<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptMovePosVd extends CI_Model
{


    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 16/08/2019 Saharat(Golf)
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paDataFilter)
    {
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{ CALL SP_RPTxStockMovent1002002(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptCode'         => $paDataFilter['tRptCode'],
            'ptUsrSession'      => $paDataFilter['tUserSession'],
            'pnFilterType'      => $paDataFilter['tTypeSelect'],
            'ptBchL'            => $tBchCodeSelect,
            'ptBchF'            => $paDataFilter['tBchCodeFrom'],
            'ptBchT'            => $paDataFilter['tBchCodeTo'],
            'ptPdtF'            => $paDataFilter['tPdtCodeFrom'],
            'ptPdtT'            => $paDataFilter['tPdtCodeTo'],
            'ptWahF'            => $paDataFilter['tWahCodeFrom'],
            'ptWahT'            => $paDataFilter['tWahCodeTo'],
            'ptMonth'           => ltrim($paDataFilter['tMonth'],0),
            'ptYear'            => $paDataFilter['tYear'],
            'ptPdtStaActive'    => $paDataFilter['tPdtStaActive'],
            'FNResult'          => 0,
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);
        if ($oQuery !== FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 10/07/2019 Saharat(Golf)
    // Last Modified : 19/11/2019 wasin(Yoshi)
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere)
    {

        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $aPagination    = $this->FMaMRPTPagination($paDataWhere);
            $nRowIDStart    = $aPagination["nRowIDStart"];
            $nRowIDEnd      = $aPagination["nRowIDEnd"];
            $nTotalPage     = $aPagination["nTotalPage"];
        }else{
            $aPagination  = array();
            $nTotalPage   = 1;
        }

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tSession       = $paDataWhere['tUsrSessionID'];

        //Set Priority
        $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);
        $this->FMxMRPTAjdStkBal($tComName, $tRptCode, $tSession);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter   =   "   SELECT
                                        FTUsrSession                                    AS FTUsrSession_Footer,
                                        CONVERT(FLOAT,SUM(FCStkQtyMonEnd))              AS FCStkQtyMonEnd_Footer,
                                        CONVERT(FLOAT,SUM(FCStkQtyIn))                  AS FCStkQtyIn_Footer,
                                        CONVERT(FLOAT,SUM(FCStkQtyOut))                 AS FCStkQtyOut_Footer,
                                        CONVERT(FLOAT,SUM(FCStkQtySaleDN - FCStkQtyCN)) AS FCStkQtySale_Footer,
                                        CONVERT(FLOAT,SUM(FCStkQtyAdj))                 AS FCStkQtyAdj_Footer,
                                        CONVERT(FLOAT,SUM(FCStkQtyBal))                 AS FCStkQtyBal_Footer
                                    FROM TRPTPdtStkCrdTmp WITH(NOLOCK)
                                    WHERE FTComName     = '$tComName'
                                    AND FTRptCode       = '$tRptCode'
                                    AND FTUsrSession    = '$tSession'
                                    GROUP BY FTUsrSession
                                    ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter  =   "   SELECT
                                        '$tSession' AS FTUsrSession_Footer,
                                        '0'           AS FCStkQtyMonEnd_Footer,
                                        '0'           AS FCStkQtyIn_Footer,
                                        '0'           AS FCStkQtyOut_Footer,
                                        '0'           AS FCStkQtySale_Footer,
                                        '0'           AS FCStkQtyAdj_Footer,
                                        '0'           AS FCStkQtyBal_Footer
                                    ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        $tSQL   = " SELECT
                        L.*,
                        T.*
                    FROM (
                        SELECT DISTINCT
                        ROW_NUMBER() OVER(ORDER BY DATASTKCRD.FTBchCode ASC,DATASTKCRD.FTWahCode ASC,DATASTKCRD.FTPdtCode ASC,DATASTKCRD.FDStkDate ASC, DATASTKCRD.FTRptRowSeq ASC) AS RowID,
                            DATASTKCRD.*,
                            DATASUBPDT.*,
                            DATASUBWAH.*,
                            DATASUBBCH.*
                        FROM TRPTPdtStkCrdTmp DATASTKCRD WITH(NOLOCK)
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTBchCode	        AS FTBchCode_SUBPDT,
                                FTWahCode	        AS FTWahCode_SUBPDT,
                                FTPdtCode	        AS FTPdtCode_SUBPDT,
                                COUNT(FTPdtCode)	AS FNRptGroupMember_SUBPDT,
                                CONVERT(FLOAT,SUM(FCStkQtyMonEnd))  AS FCStkQtyMonEnd_SUBPDT,
                                CONVERT(FLOAT,SUM(FCStkQtyIn))      AS FCStkQtyIn_SUBPDT,
                                CONVERT(FLOAT,SUM(FCStkQtyOut))     AS FCStkQtyOut_SUBPDT,
                                CONVERT(FLOAT,SUM(FCStkQtySaleDN - FCStkQtyCN)) AS FCStkQtySale_SUBPDT,
                                CONVERT(FLOAT,SUM(FCStkQtyAdj))     AS FCStkQtyAdj_SUBPDT,
                                CONVERT(FLOAT,SUM(FCStkQtyBal))     AS FCStkQtyBal_SUBPDT
                            FROM TRPTPdtStkCrdTmp WITH(NOLOCK)
                            WHERE FTComName     = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tSession'
                            GROUP BY FTBchCode,FTWahCode,FTPdtCode
                        ) DATASUBPDT ON DATASTKCRD.FTBchCode = DATASUBPDT.FTBchCode_SUBPDT AND DATASTKCRD.FTWahCode = DATASUBPDT.FTWahCode_SUBPDT AND DATASTKCRD.FTPdtCode = DATASUBPDT.FTPdtCode_SUBPDT
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTBchCode	        AS FTBchCode_SUBWAH,
                                FTWahCode	        AS FTWahCode_SUBWAH,
                                COUNT(FTWahCode)	AS FNRptGroupMember_SUBWAH,
                                CONVERT(FLOAT,SUM(FCStkQtyMonEnd))	AS FCStkQtyMonEnd_SUBWAH,
                                CONVERT(FLOAT,SUM(FCStkQtyIn))      AS FCStkQtyIn_SUBWAH,
                                CONVERT(FLOAT,SUM(FCStkQtyOut))     AS FCStkQtyOut_SUBWAH,
                                CONVERT(FLOAT,SUM(FCStkQtySaleDN - FCStkQtyCN)) AS FCStkQtySale_SUBWAH,
                                CONVERT(FLOAT,SUM(FCStkQtyAdj))     AS FCStkQtyAdj_SUBWAH,
                                (CONVERT(FLOAT,SUM(FCStkQtyMonEnd)) + CONVERT(FLOAT,SUM(FCStkQtyIn)) - CONVERT(FLOAT,SUM(FCStkQtyOut)) + CONVERT(FLOAT,SUM(FCStkQtyAdj)) - CONVERT(FLOAT,SUM(FCStkQtySaleDN - FCStkQtyCN))) AS FCStkQtyBal_SUBWAH
                            FROM TRPTPdtStkCrdTmp WITH(NOLOCK)
                            WHERE FTComName     = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tSession'
                            GROUP BY FTBchCode,FTWahCode
                        ) DATASUBWAH ON DATASTKCRD.FTBchCode	= DATASUBWAH.FTBchCode_SUBWAH AND DATASTKCRD.FTWahCode = DATASUBWAH.FTWahCode_SUBWAH
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTBchCode                           AS FTBchCode_SUBBCH,
                                COUNT(FTBchCode)                    AS FNRptGroupMember_SUBBCH,
                                CONVERT(FLOAT,SUM(FCStkQtyMonEnd))	AS FCStkQtyMonEnd_SUBBCH,
                                CONVERT(FLOAT,SUM(FCStkQtyIn))      AS FCStkQtyIn_SUBBCH,
                                CONVERT(FLOAT,SUM(FCStkQtyOut))     AS FCStkQtyOut_SUBBCH,
                                CONVERT(FLOAT,SUM(FCStkQtySaleDN - FCStkQtyCN)) AS FCStkQtySale_SUBBCH,
                                CONVERT(FLOAT,SUM(FCStkQtyAdj))     AS FCStkQtyAdj_SUBBCH,
                                (CONVERT(FLOAT,SUM(FCStkQtyMonEnd)) + CONVERT(FLOAT,SUM(FCStkQtyIn)) - CONVERT(FLOAT,SUM(FCStkQtyOut)) + CONVERT(FLOAT,SUM(FCStkQtyAdj)) - CONVERT(FLOAT,SUM(FCStkQtySaleDN - FCStkQtyCN))) AS FCStkQtyBal_SUBBCH
                            FROM TRPTPdtStkCrdTmp WITH(NOLOCK)
                            WHERE FTComName     = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tSession'
                            GROUP BY FTBchCode
                        ) DATASUBBCH ON DATASTKCRD.FTBchCode = DATASUBBCH.FTBchCode_SUBBCH
                        WHERE DATASTKCRD.FTComName		= '$tComName'
                        AND DATASTKCRD.FTRptCode		= '$tRptCode'
                        AND DATASTKCRD.FTUsrSession	    = '$tSession'
                    ) L
                    LEFT JOIN (
                        " . $tJoinFoooter . "
        ";
        // WHERE เงื่อนไข Page
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $tSQL   .=  "   WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        }

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  "   ORDER BY L.FTBchCode,L.FTWahCode ,L.FTPdtCode,L.FDStkDate,L.FTRptRowSeq,L.FNRowPartID";

        // echo $tSQL;
        // exit();
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData  = $oQuery->result_array();
        } else {
            $aData  = NULL;
        }
        $aErrorList =   array(
            "nErrInvalidPage"   =>  ""
        );
        $aResualt = array(
            "aPagination"   =>  $aPagination,
            "aRptData"      =>  $aData,
            "aError"        =>  $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return  $aResualt;
    }


    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 22/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array    
    public function FSaMCountDataReportAll($paDataWhere)
    {
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tUserSession  = $paDataWhere['tUserSession'];
        $tSQL       = " SELECT 
                            FTRcvName  AS rtRcvName,
                            FTXshDocNo AS rtRcvDocNo,
                            FDCreateOn AS rtRcvCreateOn,
                            FCXrcNet   AS rtRcvrcNet 
                    FROM TRPTVDSalRCTmp  
                    WHERE 1 = 1 AND 
                    FTUsrSession = '$tUserSession' 
                    AND FTComName = '$tCompName' 
                    AND FTRptCode = '$tRptCode'";
        $oQuery     = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    public function FMaMRPTPagination($paDataWhere)
    {

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           =   "   SELECT
                                    COUNT(STK.FTWahCode) AS rnCountPage
                                FROM TRPTPdtStkCrdTmp STK WITH(NOLOCK)
                                WHERE 1=1
                                AND STK.FTComName    = '$tComName'
                                AND STK.FTRptCode    = '$tRptCode'
                                AND STK.FTUsrSession = '$tUsrSession'
                                
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
            "nTotalRecord"  =>  $nRptAllRecord,
            "nTotalPage"    =>  $nTotalPage,
            "nDisplayPage"  =>  $paDataWhere['nPage'],
            "nRowIDStart"   =>  $nRowIDStart,
            "nRowIDEnd"     =>  $nRowIDEnd,
            "nPrevPage"     =>  $nPrevPage,
            "nNextPage"     =>  $nNextPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession)
    {
        $tSQLUPD   = "  UPDATE DATAUPD
                        SET
                            DATAUPD.FNRowPartID     = DATASLT.PartIDPdt,
                            DATAUPD.FNRowPartIDWah	= DATASLT.PartIDWah,
                            DATAUPD.FNRowPartIDBch	= DATASLT.PartIDBch
                        FROM TRPTPdtStkCrdTmp DATAUPD
                        RIGHT JOIN (
                            SELECT 
                                ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTWahCode,FTPdtCode ORDER BY FTBchCode ASC,FTWahCode ASC,FTPdtCode ASC,FDStkDate ASC,FTRptRowSeq ASC) AS PartIDPdt,
                                ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTWahCode ORDER BY FTBchCode ASC,FTWahCode ASC) AS PartIDWah,
                                ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FTBchCode ASC) AS PartIDBch,
                                FTRptRowSeq,
                                FTBchCode,
                                FTWahCode,
                                FTPdtCode,
                                FTComName,
                                FTRptCode,
                                FTUsrSession
                            FROM TRPTPdtStkCrdTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$ptComName'
                            AND FTRptCode       = '$ptRptCode'
                            AND FTUsrSession    = '$ptUsrSession'
                        ) DATASLT ON 1=1
                        AND DATASLT.FTRptRowSeq     = DATAUPD.FTRptRowSeq
                        AND DATASLT.FTBchCode       = DATAUPD.FTBchCode
                        AND DATASLT.FTWahCode       = DATAUPD.FTWahCode
                        AND DATASLT.FTPdtCode       = DATAUPD.FTPdtCode
                        AND DATASLT.FTComName       = DATAUPD.FTComName
                        AND DATASLT.FTRptCode       = DATAUPD.FTRptCode
                        AND DATASLT.FTUsrSession	= DATAUPD.FTUsrSession
        ";
        $this->db->query($tSQLUPD);
    }

    //set AjdStkBal
    private function FMxMRPTAjdStkBal($ptComName, $ptRptCode, $ptUsrSession)
    {
        // --Adjust stock balance in temp  
        $tSQL   = " UPDATE STK
                        SET STK.FCStkQtyBal =  STKAJB.FCStkBal
                    FROM TRPTPdtStkCrdTmp STK 
                    -- join this statement with main state key must refer by : FTWahCode,FTPdtCode,FTStkDocNo
                    LEFT JOIN (
                        SELECT STKB.* , 
                            --calculate running total partition by warehouse by products (use this column for show balance)
                            SUM(STKB.FCStkSumTrans) OVER ( PARTITION  BY STKB.FTWahCode+STKB.FTPdtCode ORDER BY STKB.FTBchCode,STKB.FDStkDate  , STKB.FTRptRowSeq) AS FCStkBal
                        FROM (
                            SELECT
                                FTBchCode,FTRptRowSeq, FTWahCode,FTPdtCode,FTStkDocNo,FDStkDate,
                                --get row number for order by sequence because sub query can not use order by
                                ROW_NUMBER() OVER(PARTITION by FTPdtCode ORDER BY FTWahCode,FTPdtCode,FTStkDocNo) AS FNStkRowGroupNo,
                                -- calculate stock (all transactions) 
                                SUM(FCStkQtyMonEnd + FCStkQtyIn - FCStkQtyOut + FCStkQtyAdj - (FCStkQtySaleDN - FCStkQtyCN) ) AS FCStkSumTrans
                            FROM TRPTPdtStkCrdTmp
                            WHERE 1 = 1
                            AND FTComName       = '$ptComName' 
                            AND FTRptCode       = '$ptRptCode'
                            AND FTUsrSession    = '$ptUsrSession'
                            --gropping data 
                            GROUP BY FTBchCode,FTRptRowSeq,FTWahCode,FTPdtCode,FTStkDocNo ,FDStkDate
                    ) STKB ) STKAJB ON STK.FTBchCode = STKAJB.FTBchCode AND STK.FTWahCode = STKAJB.FTWahCode AND STK.FTPdtCode = STKAJB.FTPdtCode AND STK.FTStkDocNo = STKAJB.FTStkDocNo";

        $this->db->query($tSQL);
    }

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 21/08/2019 Saharat(Golf)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountDataReportAll($paDataWhere)
    {
        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT 
                DTTMP.FTRptCode
            FROM TRPTPdtStkCrdTmp AS DTTMP WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSession'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }
}
