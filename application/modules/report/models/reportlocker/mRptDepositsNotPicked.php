<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptDepositsNotPicked extends CI_Model {

    /**
     * Functionality: Call Store Report
     * Parameters: function parameters
     * Creator:  02/11/2019 Saharat(Golf)
     * Last Modified: -
     * Return: Numeric Status Run Stored Procedure
     * Return Type: Numeric
     */
    public function FSnMExecStoreCReport($paParams) {
        // สาขา
        $tBchCodeSelect = ($paParams['bBchStaSelectAll']) ? '' : $paParams['tBchCodeSelect']; 

        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paParams['bMerStaSelectAll']) ? '' : $paParams['tMerCodeSelect'];

        // ร้านค้า
        $tShpCodeSelect = ($paParams['bShpStaSelectAll']) ? '' : $paParams['tShpCodeSelect'];
        
        //เครื่องจุดขาย
        $tPosCodeSelect = ($paParams['bPosStaSelectAll']) ? '' : $paParams['tPosCodeSelect'];
        
        
        $tCallStore = "{ CALL SP_RPTxDepositsNotPicked003001013(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'      => $paParams['nLangID'],
            'ptComName'    => $paParams['tCompName'],
            'ptRptCode'    => $paParams['tRptCode'],
            'ptUsrSession' => $paParams['tUserSession'],
            
            'pnFilterType'  => $paParams['tTypeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paParams['tBchCodeFrom'],
            'ptBchT'        => $paParams['tBchCodeTo'],
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paParams['tMerCodeFrom'],
            'ptMerT'        => $paParams['tMerCodeTo'],
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paParams['tShpCodeFrom'],
            'ptShpT'        => $paParams['tShpCodeTo'],
            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paParams['tPosCodeFrom'],
            'ptPosT'        => $paParams['tPosCodeTo'],

            'ptLayNoF'     => $paParams['tLockerChanelFrom'],
            'ptLayNoT'     => $paParams['tLockerChanelTo'],
            'ptDocDateF'   => $paParams['tDocDateFrom'],
            'ptDocDateT'   => $paParams['tDocDateTo'],
            'FNResult'     => 0
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
    
    /**
     * Functionality: Count Data Rows All In DB Temp
     * Parameters: function parameters
     * Creator:  02/11/2019 Saharat(Golf)
     * Last Modified: -
     * Return: Count Data All Temp
     * Return Type: Numeric
     */
    public function FSnMCountRowInTemp($paParams) {

        $tComName    = $paParams['tCompName'];
        $tRptCode    = $paParams['tRptCode'];
        $tUsrSession = $paParams['tUserSession'];
        
        $tSQL = "   
            SELECT
                COUNT(TDPT.FTRptCode) AS rnCountPage
            FROM TRPTRTDepositsNotPickedTmp TDPT WITH(NOLOCK)
            WHERE 1=1
            AND TDPT.FTComName       = '$tComName'
            AND TDPT.FTRptCode       = '$tRptCode'
            AND TDPT.FTUsrSession    = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
    }

    /**
     * Functionality: Data Address Merchant
     * Parameters: function parameters
     * Creator:  02/11/2019 Saharat(Golf)
     * Last Modified: -
     * Return: Data Array
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere) {
         
        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd   = $aPagination["nRowIDEnd"];
        $nTotalPage  = $aPagination["nTotalPage"];
        
        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        
        //Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*
            FROM (
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY FTBchCode) AS RowID ,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTRTDepositsNotPickedTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTBchCode          AS FTBchCode_SUM,
                        COUNT(FTBchCode)   AS FNRptGroupMember
                    FROM TRPTRTDepositsNotPickedTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTBchCode
                ) AS S ON A.FTBchCode   = S.FTBchCode_SUM
                WHERE A.FTComName       = '$tComName'
                AND   A.FTRptCode       = '$tRptCode'
                AND   A.FTUsrSession    = '$tUsrSession'
                /* End Calculate Misures */
            ) AS L  ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTBchCode ASC, L.FTShpCode ASC, L.FTPosCode ASC ";
 
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
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 02/12/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere) {
        
        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        
        $tSQL = "   
            SELECT
                COUNT(DepositsNotPickedTmp.FTRptCode) AS rnCountPage
            FROM TRPTRTDepositsNotPickedTmp DepositsNotPickedTmp WITH(NOLOCK)
            WHERE 1=1
            AND DepositsNotPickedTmp.FTComName      = '$tComName'
            AND DepositsNotPickedTmp.FTRptCode      = '$tRptCode'
            AND DepositsNotPickedTmp.FTUsrSession   = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage); //RowId Start
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
            "nTotalRecord" => $nRptAllRecord,
            "nTotalPage" => $nTotalPage,
            "nDisplayPage" => $paDataWhere['nPage'],
            "nRowIDStart" => $nRowIDStart,
            "nRowIDEnd" => $nRowIDEnd,
            "nPrevPage" => $nPrevPage,
            "nNextPage" => $nNextPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 02/11/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere) {

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            UPDATE TRPTRTDepositsNotPickedTmp SET 
                FNRowPartID = B.PartID
            FROM(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode,FTPosCode ORDER BY FTBchCode ASC, FTShpCode ASC, FTPosCode ASC ) AS PartID,
                    FTRptRowSeq
                FROM TRPTRTDepositsNotPickedTmp TDT WITH(NOLOCK)
                WHERE TDT.FTComName = '$tComName' 
                AND TDT.FTRptCode = '$tRptCode'
                AND TDT.FTUsrSession = '$tUsrSession'
            ) AS B
            WHERE TRPTRTDepositsNotPickedTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTRTDepositsNotPickedTmp.FTComName = '$tComName' 
            AND TRPTRTDepositsNotPickedTmp.FTRptCode = '$tRptCode'
            AND TRPTRTDepositsNotPickedTmp.FTUsrSession = '$tUsrSession'
        ";
        
        $this->db->query($tSQL);
    }
 
}






















