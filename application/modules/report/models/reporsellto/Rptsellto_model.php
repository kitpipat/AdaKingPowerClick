
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rptsellto_model extends CI_Model {
    /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID = $paDataFilter['nLangID'];
        $tComName = $paDataFilter['tCompName'];
        $tRptCode = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);

        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // --	1 @pnLngID int ,
        // --	2 @pnComName Varchar(100),
        // --	3 @ptRptCode Varchar(100),
        // --	4 @ptUsrSession Varchar(255),
        // --	5 @pnFilterType int, --1 BETWEEN 2 IN
        //
        // ----Agency
        // --	6 @ptAgnL Varchar(8000), --Agency Condition IN
        // --	--@ptPosF Varchar(10), @ptPosT Varchar(10),
        //
        // ----สาขา
        // --	7 @ptBchL Varchar(8000), --สาขา Condition IN
        // --	--@ptBchF Varchar(5),	@ptBchT Varchar(5),
        //
        // ----Merchant
        // --	8 @ptMerL Varchar(8000), --เจ้าของธุรกิจ Condition IN
        // --	--@ptUsrF Varchar(10), @ptUsrT Varchar(10),
        //
        // ----Shop
        // --	9 @ptShpL Varchar(8000),
        // --	--@ptShpF Varchar(5),@ptShpT Varchar(5),
        //
        // ----FTFhnRefCode -- รหัสควบคุมสต็อกสินค้า Def :  (SEASON+MODEL+COLOR+SIZE)
        // --	10 @ptRefF Varchar(30),
        // --  11 @ptRefT Varchar(30),
        //
        // ----รหัสสินค้า --FTPdtCode --รหัสสินค้า
        // --	12 @ptPdtF Varchar(20),
        // --  13 @ptPdtT Varchar(20),
        //
        // ----ต้องการแสดงรายงานถึงวันที่ รายจะแสดงจากวันที่ 1 ถึง @ptDocDateT ของเดือนนั้น
        // ----Condition วันเดียวพอ
        // --	14 @ptDocDateT Varchar(10),
        //
        // --	15 @FNResult INT OUTPUT 6
        $tCallStore = "{CALL SP_RPTxSellThru(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
          'pnLngID'=> $nLangID,
          'pnComName'=> $tComName,
          'ptRptCode'=> $tRptCode,
          'ptUsrSession'=> $tUserSession,
          'pnFilterType'=> $paDataFilter['tTypeSelect'],
          'ptAgnL'=> $paDataFilter['tAgnCode'],
          'ptBchL'=> $tBchCodeSelect,
          'ptMerL'=> $tMerCodeSelect,
          'ptShpL'=> $tShpCodeSelect,
          'ptRefF'=> $paDataFilter['tRefCodeFrom'],
          'ptRefT'=> $paDataFilter['tRefCodeTo'],
          'ptPdtF'=> $paDataFilter['tPdtCodeFrom'],
          'ptPdtT'=> $paDataFilter['tPdtCodeTo'],
          'ptSeaF'=> $paDataFilter['tSeaCodeFrom'],
          'ptSeaT'=> $paDataFilter['tSeaCodeTo'],
          'ptFabF'=> $paDataFilter['tFabCodeFrom'],
          'ptFabT'=> $paDataFilter['tFabCodeTo'],
          'ptClrF'=> $paDataFilter['tClrCodeFrom'],
          'ptClrT'=> $paDataFilter['tClrCodeTo'],
          'ptPszF'=> $paDataFilter['tPszCodeFrom'],
          'ptPszT'=> $paDataFilter['tPszCodeTo'],
          'ptDocDateT'=> $paDataFilter['tDocDateFrom'],
          'FNResult'=> 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo $this->db->last_query();
        // exit();
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }

    /**
     * Functionality: Count Row in Temp
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){

        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tSessionID'];

        $tSQL = "
            SELECT
                TMP.FTRptCode
            FROM TRPTSellThruTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){
        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // Set Priority
        //$this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา




        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "SELECT C.*
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(ORDER BY A.FTPdtCode,A.FTFhnRefCode ASC) AS rtRowID,
                        A.*
                    FROM(
                        SELECT
                            *
                        FROM TRPTSellThruTmp
                        WHERE 1=1
                        AND FTComName       = '" . $tComName . "'
                        AND FTRptCode       = '" . $tRptCode . "'
                        AND FTUsrSession    = '" . $tUsrSession . "'
                    ) AS A
                ) AS C
            WHERE C.rtRowID > $nRowIDStart AND C.rtRowID <= $nRowIDEnd";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aData = $oQuery->result_array();
        }else{
            $aData = NULL;
        }

        $aErrorList = [
            "nErrInvalidPage" => ""
        ];

        $aResualt= [
            "aPagination" => $aPagination,
            "aRptData" => $aData,
            "aError" => $aErrorList
        ];
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }

    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "
            SELECT
                TSPT.FTRptCode
            FROM TRPTSellThruTmp TSPT WITH(NOLOCK)
            WHERE TSPT.FTComName = '$tComName'
            AND TSPT.FTRptCode = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
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

    /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "
            UPDATE TRPTSellThruTmp
                SET TRPTSellThruTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(ORDER BY FNRowPartID ASC) AS PartID ,TMP.FTRptRowSeq

                    FROM TRPTSellThruTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTComName = '$tComName'
                    AND TMP.FTRptCode = '$tRptCode'
                    AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $tSQL .= "
            ) AS B
            WHERE 1=1
            AND TRPTSellThruTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTSellThruTmp.FTComName = '$tComName'
            AND TRPTSellThruTmp.FTRptCode = '$tRptCode'
            AND TRPTSellThruTmp.FTUsrSession = '$tUsrSession'
        ";
        $this->db->query($tSQL);
    }

}
