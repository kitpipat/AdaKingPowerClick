
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptDailySalesTax extends CI_Model {

    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Nonpaiwch(petch)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
      
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];
        $tTypeSelect  = $paDataFilter['nFilterType'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{CALL SP_RPTxPSSDailyVat1001006(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $tTypeSelect, 
            
            //--สาขา    
            // 'ptBchL'        => '00001',
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            
            //กลุ่มธุระกิจ
            // 'ptMerL'   =>    '00001',
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],
         
            //ร้านค้า
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
            
            //จุดขาย
            'ptPosCodeL'         => $tPosCodeSelect,
            'ptPosCodeF'        => $paDataFilter['tPosCodeTo'],
            'ptPosCodeT'        => $paDataFilter['tPosCodeSelect'],

           //ประเภทชำระ
              'ptPayF'        => $paDataFilter['tRcvCodeFrom'],
              'ptPayT'        => $paDataFilter['tRcvCodeTo'],

            //วันที่
                'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            //เดือน
            //'ptMonth'        => $paDataFilter['tMonth'],
           
            //ปี
            //'ptYear'        => $paDataFilter['tYear'],
            
            'FNResult'      => 0
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

    // Functionality: Get Data Report In Table Temp
    // Parameters:  Function Parameter
    // Creator: 
    // Last Modified : -
    // Return : Array Data report
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){

        $nPage    = $paDataWhere['nPage'];

        // Call Data Pagination
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tAppType       = $paDataWhere['aDataFilter']['tPosType'];
     
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   SELECT
                    FTUsrSession          AS FTUsrSession_Footer,
                    SUM(FCXsdVatable)     AS FCXsdVatable_Footer,
                    SUM(FCXsdVat)         AS FCXsdVat_Footer
                FROM TRPTPSTaxDailyTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName       = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'";
            if($tAppType != ""){
                $tJoinFoooter .= "  AND FNAppType    = '$tAppType'";
            }
            $tJoinFoooter .= " 
                                GROUP BY FTUsrSession
                                ) T ON L.FTUsrSession = T.FTUsrSession_Footer";
        }else{
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "   SELECT
                                    '$tUsrSession'  AS FTUsrSession_Footer,  
                                    0   AS FCXsdVatable_Footer, 
                                    0   AS FCXsdVat_Footer
                                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   SELECT
                        L.*,
                        T.*
                        FROM (
                            SELECT
                                ROW_NUMBER() OVER(ORDER BY FDXshDocDate ASC,FTFmtCode ASC) AS RowID ,
                                A.*,
                                S.FTFmtCode_SUM,
                                S.FNRptGroupMember,
                                S.FCXsdVatable_SubTotal,
                                S.FCXsdVat_SubTotal
                            FROM TRPTPSTaxDailyTmp A WITH(NOLOCK)
                            
                        /* Calculate Misures */
                        LEFT JOIN (
                            SELECT
                            FDXshDocDate               AS FDXshDocDate_SUM,
                            FTFmtCode                  AS FTFmtCode_SUM,
                            COUNT(FDXshDocDate)        AS FNRptGroupMember,
                            SUM(FCXsdVatable)       AS FCXsdVatable_SubTotal,
                            SUM(FCXsdVat)           AS FCXsdVat_SubTotal
                        FROM TRPTPSTaxDailyTmp WITH(NOLOCK)
                        WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tUsrSession'
                            
            ";
            if($tAppType != ""){
                $tSQL .= "       AND FNAppType       = '$tAppType'";
            }
            $tSQL .= "
                            GROUP BY FDXshDocDate , FTFmtCode 
                        ) AS S ON A.FDXshDocDate = S.FDXshDocDate_SUM  AND ISNULL(A.FTFmtCode,'') = ISNULL(S.FTFmtCode_SUM,'')
                        WHERE 1=1
                        AND A.FTComName     = '$tComName'
                        AND A.FTRptCode     = '$tRptCode'
                        AND A.FTUsrSession  = '$tUsrSession'
                    
                        ";

         
            /* End Calculate Misures */
            $tSQL .= "      ) AS L
                            LEFT JOIN (
                                " . $tJoinFoooter . "
            ";
            // WHERE เงื่อนไข Page
            $tSQL .= "   WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

            if($tAppType != ""){
                $tSQL .= " AND L.FNAppType = '$tAppType'";
            }

            // สั่ง Order by ตามข้อมูลหลัก
            $tSQL .= "   ORDER BY L.FDXshDocDate ASC , L.FTFmtCode ASC";
            // echo $tSQL;
            // exit;
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
    // Creator: 19/12/2019 Nonpaiwch(petch)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){
            $tComName       = $paDataWhere['tCompName'];
            $tRptCode       = $paDataWhere['tRptCode'];
            $tUsrSession    = $paDataWhere['tUsrSessionID'];
            $tAppType       = $paDataWhere['aDataFilter']['tPosType'];

            $tSQL = "   SELECT
                COUNT(DTTMP.FTRptCode) AS rnCountPage
            FROM TRPTPSTaxDailyTmp AS DTTMP WITH(NOLOCK)
            WHERE 1=1
            AND DTTMP.FTComName    = '$tComName'
            AND DTTMP.FTRptCode    = '$tRptCode'
            AND DTTMP.FTUsrSession = '$tUsrSession'";

        if($tAppType != ""){
            $tSQL .= " AND DTTMP.FNAppType = '$tAppType'";
        }

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage);
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


    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Nonpaiwch(petch)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMxMRPTSetPriorityGroup($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tAppType       = $paDataWhere['aDataFilter']['tPosType'];

        $tSQL = " 
            UPDATE DATAUPD SET 
                DATAUPD.FNRowPartID = B.PartID
            FROM TRPTPSTaxDailyTmp AS DATAUPD WITH(NOLOCK)
            INNER JOIN(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FDXshDocDate ASC , FTFmtCode ASC) AS PartID,
                    FTRptRowSeq
                FROM TRPTPSTaxDailyTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName     = '$tComName'
                AND TMP.FTRptCode       = '$tRptCode'
                AND TMP.FTUsrSession    = '$tUsrSession'";

            if($tAppType != ""){
                $tSQL .= " AND TMP.FNAppType = '$tAppType'";
            }
            // $tSQL .= " ORDER BY TMP.FDXshDocDate , TMP.FTFmtCode ";
        $tSQL .= "
            ) AS B
                ON DATAUPD.FTRptRowSeq = B.FTRptRowSeq
                AND DATAUPD.FTComName       = '$tComName'
                AND DATAUPD.FTRptCode       = '$tRptCode'
                AND DATAUPD.FTUsrSession    = '$tUsrSession'";
        if($tAppType != ""){
            $tSQL .= " AND DATAUPD.FNAppType = '$tAppType'";
        }
      
        $this->db->query($tSQL);
    }

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Saharat(Golf)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountRowInTemp($paDataWhere) {
        $tUserSession   = $paDataWhere['tUserSession'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tPosType       = $paDataWhere['aDataFilter']['tPosType'];
        $tSQL = "   SELECT 
                             COUNT(TTDT.FTRptCode) AS rnCountPage
                         FROM TRPTPSTaxDailyTmp AS TTDT WITH(NOLOCK)
                         WHERE 1 = 1
                         AND FTUsrSession    = '$tUserSession'
                         AND FTComName       = '$tCompName'
                         AND FTRptCode       = '$tRptCode'";
        if($tPosType != ''){
            $tSQL .= "   AND FNAppType       = '$tPosType'";
        }

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }

   
}


