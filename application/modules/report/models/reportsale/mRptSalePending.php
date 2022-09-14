<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalePending extends CI_Model {


    /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 01/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){

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


        $tCallStore = "{CALL SP_RPTxPSWaitPay(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";

        $aDataStore = array(
            
            'pnLngID'           => $nLangID, 
            'pnComName'         => $tComName,
            'ptRptCode'         => $tRptCode,
            'ptUsrSession'      => $tUserSession,
            'pnFilterType'      => $paDataFilter['tTypeSelect'],
            'ptBchL'            => $tBchCodeSelect,
            'ptMerL'            => $tMerCodeSelect,
            'ptShpL'            => $tShpCodeSelect,
            'ptPosL'            => $tPosCodeSelect,
            'ptCstF'            => $paDataFilter['tCstCodeFrom'],
            'ptCstT'            => $paDataFilter['tCstCodeTo'],
            'ptDocDateF'        => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'        => $paDataFilter['tDocDateTo'],
            'FTResult'          => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($$oQuery);
            return 0;
        }
    }   


    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 01/10/2019 Sahaart(Golf)
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){
            
        $nPage  = $paDataWhere['nPage'];


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


        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT   
                    FTUsrSession AS FTUsrSession_Footer,    
                    SUM( 
                        ISNULL(FCXshGrand, 0)
                    ) AS FCXshGrand_Footer
                FROM TRPTPSWaitPayTmp WITH(NOLOCK)
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
                    0 AS FCXshGrand_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCXshGrand_Footer
                    FROM (
                        SELECT 
                        ROW_NUMBER() OVER(ORDER BY FTXshDocNo ASC) AS RowID ,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCXshGrand_SubTotal
                    FROM TRPTPSWaitPayTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                    LEFT JOIN (
                        SELECT 
                            FTXshDocNo      AS FTXshDocNo_SUM,
                            COUNT(FTXshDocNo)     AS FNRptGroupMember,
                            SUM(FCXshGrand)  AS FCXshGrand_SubTotal
                    FROM TRPTPSWaitPayTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTXshDocNo
                    ) AS S ON A.FTXshDocNo  = S.FTXshDocNo_SUM
                    WHERE A.FTComName       = '$tComName'
                    AND   A.FTRptCode       = '$tRptCode'
                    AND   A.FTUsrSession    = '$tUsrSession'
                ) AS L
                LEFT JOIN (
                    " . $tRptJoinFooter . "
                ";

            // WHERE เงื่อนไข Page
            $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";  

            //สั่ง Order by ตามข้อมูลหลัก
            $tSQL .= " ORDER BY L.FTXshDocNo";

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
    public function FMaMRPTPagination($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTPSWaitPayTmp TMP WITH(NOLOCK)
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
            UPDATE TRPTPSWaitPayTmp SET 
                FNRowPartID = B.PartID
            FROM(
                SELECT 
                    ROW_NUMBER() OVER(PARTITION BY FTXshDocNo ORDER BY FTXshDocNo ASC) AS PartID,
                    FTRptRowSeq 
                FROM TRPTPSWaitPayTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$tComName' 
                AND TMP.FTRptCode   = '$tRptCode'
                AND TMP.FTUsrSession = '$tUsrSession'";
                
            $tSQL .= "
                ) AS B
                WHERE TRPTPSWaitPayTmp.FTRptRowSeq = B.FTRptRowSeq 
                AND TRPTPSWaitPayTmp.FTComName = '$tComName' 
                AND TRPTPSWaitPayTmp.FTRptCode = '$tRptCode'
                AND TRPTPSWaitPayTmp.FTUsrSession = '$tUsrSession'";
        $this->db->query($tSQL);
    }

    



 

}


