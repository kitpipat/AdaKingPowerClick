<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalesMonthProduct extends CI_Model {

    
    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 19/03/2020 nonpawich (petch)
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paDataFilter) {
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

         // สาขา
         $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
         // ร้านค้า
         $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
         // ประเภทเครื่องจุดขาย
         $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
        
        $tCallStore = "{ CALL SP_RPTxSalMthQtyByPdtTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'ptComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUserSession' => $tUserSession,

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            //สาขา
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
             //ร้านค้า
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
          
            //pos
            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],

            //แคชเชีย
            'ptUsrL'        => '',
            'ptUsrF'        => $paDataFilter['tCashierCodeFrom'],
            'ptUsrT'        => $paDataFilter['tCashierCodeTo'],
            //pdt
            'ptPdtF'        => $paDataFilter['tRptPdtCodeFrom'],
            'ptPdtT'        => $paDataFilter['tRptPdtCodeTo'],
            //year
            'ptYear'        => $paDataFilter['tYear'],
            'FNResult'      => 0
        );
        // print_r($aDataStore);exit;
        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if ($oQuery != FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }
    
    
    public function FSaMGetDataReport($paDataWhere) {

        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tSession       = $paDataWhere['tUsrSessionID'];
    
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);

         // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
         if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   SELECT
                                        FTUsrSession    AS FTUsrSession_Footer,
                                        SUM(FCXsdQty01) AS FCXsdQty01_Footer,
                                        SUM(FCXsdQty02) AS FCXsdQty02_Footer,
                                        SUM(FCXsdQty03) AS FCXsdQty03_Footer,
                                        SUM(FCXsdQty04) AS FCXsdQty04_Footer,
                                        SUM(FCXsdQty05) AS FCXsdQty05_Footer,
                                        SUM(FCXsdQty06) AS FCXsdQty06_Footer,
                                        SUM(FCXsdQty07) AS FCXsdQty07_Footer,
                                        SUM(FCXsdQty08) AS FCXsdQty08_Footer,
                                        SUM(FCXsdQty09) AS FCXsdQty09_Footer,
                                        SUM(FCXsdQty10) AS FCXsdQty10_Footer,
                                        SUM(FCXsdQty11) AS FCXsdQty11_Footer,
                                        SUM(FCXsdQty12) AS FCXsdQty12_Footer,
                                        SUM(FCXsdQtyTotal) AS FCXsdQtyTotal_Footer
                                                                             
                                    FROM TRPTSalMthQtyByPdtTmp WITH(NOLOCK)
                                    WHERE 1=1
                                    AND FTComName       = '$tComName'
                                    AND FTRptCode       = '$tRptCode'
                                    AND FTUsrSession    = '$tSession'";
          
            $tJoinFoooter .= " 
                                    GROUP BY FTUsrSession
                                    ) T ON L.FTUsrSession = T.FTUsrSession_Footer";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "   SELECT
                                        '$tSession'  AS FTUsrSession_Footer,
                                  
                                        0   AS FCXsdQtyTotal_Footer
                                    ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

     
           
        
        
        //     ";

            $tSQL = "
                SELECT
                    L.*,
                    T.*
                FROM (
                    SELECT
                        ROW_NUMBER () OVER ( ORDER BY FTPdtCode ASC ) AS RowID,
                        A.* 
                    FROM TRPTSalMthQtyByPdtTmp A WITH ( NOLOCK )
                    WHERE 1=1
                    AND A.FTComName     = '$tComName'
                    AND A.FTRptCode     = '$tRptCode'
                    AND A.FTUsrSession  = '$tSession' ";



            $tSQL .= "      ) AS L
            LEFT JOIN (
                " . $tJoinFoooter . "
";        
        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // echo $tSQL ;
        // exit;
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTPdtCode ASC ";

        // echo  $tSQL; die();
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
            "aPagination"   => $aPagination,
            "aRptData"      => $aData,
            "aError"        => $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }
    
    public function FMaMRPTPagination($paDataWhere) {

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                A.FNRowPartID
            FROM TRPTSalMthQtyByPdtTmp A WITH(NOLOCK)
            WHERE A.FTComName   = '$tComName'
            AND A.FTRptCode     = '$tRptCode'
            AND A.FTUsrSession  = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();

        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage); // RowId Start
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

    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession) {

        $tSQL = "   UPDATE TRPTSalMthQtyByPdtTmp SET 
                        FNRowPartID = B.PartID
                    FROM( 
                        SELECT 
                            ROW_NUMBER() OVER(PARTITION BY FTPdtCode ORDER BY FTPdtCode ASC) AS PartID,
                            FTRptRowSeq
                        FROM TRPTSalMthQtyByPdtTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName		= '$ptComName' 
                        AND TMP.FTRptCode		= '$ptRptCode'
                        AND TMP.FTUsrSession	= '$ptUsrSession' 
                    ) AS B
                    WHERE TRPTSalMthQtyByPdtTmp.FTRptRowSeq	= B.FTRptRowSeq 
                    AND TRPTSalMthQtyByPdtTmp.FTComName		= '$ptComName' 
                    AND TRPTSalMthQtyByPdtTmp.FTRptCode		= '$ptRptCode'
                    AND TRPTSalMthQtyByPdtTmp.FTUsrSession	= '$ptUsrSession'
        ";
        $this->db->query($tSQL);

    }

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 18/3/2020 nonpawich 
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountDataReportAll($paDataWhere) {
        $tUsrSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSQL = "   SELECT 
                             COUNT(DTTMP.FTRptCode) AS rnCountPage
                         FROM TRPTSalMthQtyByPdtTmp AS DTTMP WITH(NOLOCK)
                         WHERE 1 = 1
                         AND FTUsrSession    = '$tUsrSession'
                         AND FTComName       = '$tCompName'
                         AND FTRptCode       = '$tRptCode'
         ";
        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }

}