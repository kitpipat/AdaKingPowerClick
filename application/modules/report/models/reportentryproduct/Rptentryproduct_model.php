
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rptentryproduct_model extends CI_Model {
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
        if ($paDataFilter['tPdtRptPdtType']=="0") {
          $tPdtRptPdtType = NULL;
        }else {
          $tPdtRptPdtType = $paDataFilter['tPdtRptPdtType'];
        }
        if ($paDataFilter['tPdtRptPdtType']=="0") {
          $tPdtRptPdtType = NULL;
        }else {
          $tPdtRptPdtType = $paDataFilter['tPdtRptPdtType'];
        }
        if ($paDataFilter['tPdtRptStaVat']=="0") {
          $tPdtRptStaVat = NULL;
        }else {
          $tPdtRptStaVat = $paDataFilter['tPdtRptStaVat'];
        }

        // 	@pnLngID int ,
        // 	@pnComName Varchar(100),
        // 	@ptRptCode Varchar(100),
        // 	@ptUsrSession Varchar(255),
        // 	@pnFilterType int, --1 BETWEEN 2 IN
        //
        // --Agency
        // 	@ptAgnL Varchar(8000), --Agency Condition IN
        //
        //
        // --สาขา
        // 	@ptBchL Varchar(8000), --สาขา Condition IN
        //
        //
        // --Merchant
        // 	@ptMerL Varchar(8000), --เจ้าของธุรกิจ Condition IN
        //
        //
        // --Shop
        // 	@ptShpL Varchar(8000),
        //
        //
        // --รหัสสินค้า --FTPdtCode --รหัสสินค้า
        // 	@ptPdtF Varchar(20)
        //   @ptPdtT Varchar(20),
        //
        // --กลุ่มสินค้า --FTPgpChain
        // 	@ptPgpF Varchar(30)
        //   @ptPgpT Varchar(30),
        //
        // --FTPtyCode --ประเภทสินค้า
        // 	@ptPtyF Varchar(5)
        //   @ptPtyT Varchar(5),
        //
        // --FTPbnCode --ยี่ห้อ
        // 	@ptPbnF Varchar(5)
        //   @ptPbnT Varchar(5),
        //
        // --FTPmoCode --รุ่น
        // 	@ptPmoF Varchar(5)
        //   @ptPmoT Varchar(5),
        //
        // 	@ptSaleType	 Varchar(1),--FTPdtType  --ใช้ราคาขาย 1:บังคับ, 2:แก้ไข, 3:เครื่องชั่ง, 4:น้ำหนัก 6:สินค้ารายการซ่อม
        // 	@ptPdtActive Varchar(1),--FTPdtStaActive --สถานะ เคลื่อนไหว 1:ใช่, 2:ไม่ใช่
        // 	@PdtStaVat Varchar(1),--FTPdtStaVat --สถานะภาษีขาย 1:มี 2:ไม่มี
        //
        // --FTPdtCode --รหัสสินค้า
        // --FTPgpChain --กลุ่มสินค้า
        // --FTPtyCode --ประเภทสินค้า
        // --FTPbnCode --ยี่ห้อ
        // --FTPmoCode --รุ่น
        // --FTPdtSaleType  --ใช้ราคาขาย 1:บังคับ, 2:แก้ไข, 3:เครื่องชั่ง, 4:น้ำหนัก 6:สินค้ารายการซ่อม
        // --FTPdtStaActive --สถานะ เคลื่อนไหว 1:ใช่, 2:ไม่ใช่
        // --FTPdtStaVat --สถานะภาษีขาย 1:มี 2:ไม่มี
        //
        // 	@FNResult INT OUTPUT


        $tCallStore = "{CALL SP_RPTxPdtEntry(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
          'pnLngID'=> $nLangID,
          'pnComName'=> $tComName,
          'ptRptCode'=> $tRptCode,
          'ptUsrSession'=> $tUserSession,
          'pnFilterType'=> $paDataFilter['tTypeSelect'],
          'ptAgnL'=> $paDataFilter['tAgnCode'],
          'ptBchL'=> $tBchCodeSelect,
          'ptMerL'=> $paDataFilter['tFilterMerCode'],
          'ptShpL'=> $tShpCodeSelect,
          'ptPdtF'=> $paDataFilter['tPdtCodeFrom'],
          'ptPdtT'=> $paDataFilter['tPdtCodeTo'],
          'ptPgpF'=> $paDataFilter['tPdtGrpCodeFrom'],
          'ptPgpT'=> $paDataFilter['tPdtGrpCodeTo'],
          'ptPtyF'=> $paDataFilter['tPdtTypeCodeFrom'],
          'ptPtyT'=> $paDataFilter['tPdtTypeCodeTo'],
          'ptPbnF'=> $paDataFilter['tPdtBrandCodeFrom'],
          'ptPbnT'=> $paDataFilter['tPdtBrandCodeTo'],
          'ptPmoF'=> $paDataFilter['tPdtModelCodeFrom'],
          'ptPmoT'=> $paDataFilter['tPdtModelCodeTo'],
          'ptSaleType'=> $tPdtRptPdtType,
          'ptPdtActive'=> $paDataFilter['tPdtStaActive'],
          'PdtStaVat'=> $tPdtRptStaVat,
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
            FROM TRPTPdtEntryTmp TMP WITH(NOLOCK)
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
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา




        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "SELECT C.*
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(ORDER BY A.FNRowPartID ASC) AS rtRowID,
                        A.*
                    FROM(
                        SELECT
                            *
                        FROM TRPTPdtEntryTmp
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
            FROM TRPTPdtEntryTmp TSPT WITH(NOLOCK)
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
            UPDATE TRPTPdtEntryTmp
                SET TRPTPdtEntryTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(ORDER BY FNRowPartID ASC) AS PartID ,TMP.FTRptRowSeq

                    FROM TRPTPdtEntryTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTComName = '$tComName'
                    AND TMP.FTRptCode = '$tRptCode'
                    AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $tSQL .= "
            ) AS B
            WHERE 1=1
            AND TRPTPdtEntryTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTPdtEntryTmp.FTComName = '$tComName'
            AND TRPTPdtEntryTmp.FTRptCode = '$tRptCode'
            AND TRPTPdtEntryTmp.FTUsrSession = '$tUsrSession'
        ";
        $this->db->query($tSQL);
    }

}
