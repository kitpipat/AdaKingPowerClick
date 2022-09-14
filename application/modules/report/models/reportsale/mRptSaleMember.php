<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSaleMember extends CI_Model {


     /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Wasin(Yoshi)
     * Last Modified : 23/09/2019 Piya
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

         // สาขา
         $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
         // ร้านค้า
         $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
         // กลุ่มธุรกิจ
         $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
         // ประเภทเครื่องจุดขาย
         $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{ CALL SP_RPTxSalByCst(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'      => $nLangID,
            'pnComName'    => $tComName,
            'ptRptCode'    => $tRptCode,
            'ptUsrSession' => $tUserSession,
            'pnFilterType'  => $paDataFilter['tTypeSelect'],

            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],

            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tRptPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tRptPosCodeTo'],

            'ptCstCodeF'   => $paDataFilter['tCstCodeFrom'],
            'ptCstCodeT'   => $paDataFilter['tCstCodeTo'],

            'ptDocDateF'   => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'   => $paDataFilter['tDocDateTo'],
            'FNResult'     => 0,
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
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 22/07/2020 Witsarut(Bell)
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        // Call Data Pagination
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tPosType       = $paDataWhere['aDataFilter']['tPosType'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check All Type
        $tWhereAppType          = "";
        $tWhereAppTypeFooter    = "";
        if(isset($tPosType) && !empty($tPosType)){
            $tWhereAppType          = " AND DATA.FNAppType = '".$tPosType."'";
            $tWhereAppTypeFooter    = " AND FNAppType = '".$tPosType."'";
        }

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " SELECT
                                    FTUsrSession                AS FTUsrSession_Footer,
                                    CONVERT(FLOAT,SUM(FCXshTotal))	AS FCXshTotal_Footer,
                                    CONVERT(FLOAT,SUM(FCXshDis))    AS FCXshDis_Footer,
                                    CONVERT(FLOAT,SUM(FCXshGrand))	AS FCXshGrand_Footer
                                FROM TRPTSalByCstTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName			= '$tComName'
                                AND FTRptCode			= '$tRptCode'
                                AND FTUsrSession        = '$tUsrSession'
                                ".$tWhereAppTypeFooter."
                                GROUP BY FTUsrSession
            ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = "
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXshTotal_Footer,
                    0 AS FCXshDis_Footer,
                    0 AS FCXshGrand_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   =   "   SELECT
                            L.*,
                            T.*
                        FROM (
                            SELECT
                                ROW_NUMBER() OVER(ORDER BY DATA.FNAppType,DATA.FTCstCode) AS RowID,
                                DATA.*,
                                DTSUMGRP.*
                            FROM TRPTSalByCstTmp DATA WITH(NOLOCK)
                            LEFT JOIN (
                                SELECT
                                    FNAppType AS FNAppType_SUBAPP,
                                    COUNT(FNAppType)				AS FNRptGroupMember_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCXshTotal))	AS FCXshTotal_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCXshDis))	AS FCXshDis_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCXshGrand))	AS FCXshGrand_SUBAPP
                            FROM TRPTSalByCstTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName			= '$tComName'
                            AND FTRptCode			= '$tRptCode'
                            AND FTUsrSession        = '$tUsrSession'
                            GROUP BY FNAppType
                            ) DTSUMGRP ON DATA.FNAppType = DTSUMGRP.FNAppType_SUBAPP
                            WHERE 1=1
                            AND DATA.FTComName 			= '$tComName'
                            AND DATA.FTRptCode			= '$tRptCode'
                            AND DATA.FTUsrSession		= '$tUsrSession'
                            ".$tWhereAppType."
                        ) L
                        LEFT JOIN (
                            ".$tRptJoinFooter."
                    ";
                    // WHERE เงื่อนไข Page
                    $tSQL   .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

                    if(!empty($tPosType)){
                        $tSQL .= " AND L.FNAppType = '$tPosType'";
                    }

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  " ORDER BY L.FTCstCode ASC";

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
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 01/09/2019 witsarut(Bell)
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tPosType       = $paDataWhere['aDataFilter']['tPosType'];

        $tSQL = "
                UPDATE TRPTSalByCstTmp
                SET TRPTSalByCstTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TSPT.FTCstCode ORDER BY TSPT.FTCstCode ASC) AS PartID ,
                        TSPT.FTRptRowSeq
                    FROM TRPTSalByCstTmp TSPT WITH(NOLOCK)
                    WHERE TSPT.FTComName = '$tComName'
                    AND TSPT.FTRptCode = '$tRptCode'
                    AND TSPT.FTUsrSession = '$tUsrSession'";

                if(!empty($tPosType)){
                    $tSQL .= " AND FNAppType = '" . $tPosType . "'";
                }
            $tSQL  .= "
                ) AS B
            WHERE 1=1
            AND TRPTSalByCstTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTSalByCstTmp.FTComName = '$tComName'
            AND TRPTSalByCstTmp.FTRptCode = '$tRptCode'
            AND TRPTSalByCstTmp.FTUsrSession = '$tUsrSession' ";

        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '" . $tPosType . "'";
        }

        $this->db->query($tSQL);
    }

    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 22/07/2020 witsarut(Bell)
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere){

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        $tPosType    = $paDataWhere['aDataFilter']['tPosType'];

        $tSQL = " SELECT
                    TSPT.FTRptCode
            FROM TRPTSalByCstTmp TSPT WITH(NOLOCK)
            WHERE TSPT.FTComName  = '$tComName'
            AND TSPT.FTRptCode    = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'";

            if(!empty($tPosType)){
                $tSQL .= " AND FNAppType = '" . $tPosType . "'";
            }

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
     * Functionality: Count Row in Temp
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Witsarut(Bell)
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){

        $tComName       = $paParams['tCompName'];
        $tRptCode       = $paParams['tRptCode'];
        $tUsrSession    = $paParams['tUsrSessionID'];
        $tPosType       = $paParams['aDataFilter']['tPosType'];

        $tSQL = " SELECT
                TSPT.FTRptCode
            FROM TRPTSalByCstTmp TSPT WITH(NOLOCK)
            WHERE 1=1
            AND TSPT.FTComName = '$tComName'
            AND TSPT.FTRptCode = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'
        ";

        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '" . $tPosType . "'";
        }
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->num_rows();
    }


    // Functionality: To Get data SumFootReport
    // Parameters: Function Parameter
    // Creator: 10/10/2019 Witsarut R
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMGetDataSumFootReport($paDataWhere){

        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSessionID  = $paDataWhere['tUsrSessionID'];
        $tPosType       = $paDataWhere['aDataFilter']['tPosType'];

        $tSQL = "
            SELECT
                ISNULL(SUM(FCXshTotal),0) AS FCXshTotalSum,
                ISNULL(SUM(FCXshDis),0) AS FCXshDisSum,
                ISNULL(SUM(FCXshGrand),0) AS FCXshGrandSum
            FROM TRPTSalByCstTmp
            WHERE FTUsrSession = '$tUsrSessionID'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'";
            if(!empty($tPosType)){
                $tSQL .= " AND FNAppType = '" . $tPosType . "'";
            }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }
}
