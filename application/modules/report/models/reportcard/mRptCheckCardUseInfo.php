<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptCheckCardUseInfo extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
    
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);

        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);

        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);


        $tCallStore = "{CALL SP_RPTxTopUp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";

        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
            'ptRptName'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tUserSession'],
            'pnFilterType'  => $paDataFilter['tTypeSelect'] ,

            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],

            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],

            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],

            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],

            'ptCrdF'        => $paDataFilter['tRptCardCode'],
            'ptCrdT'        => $paDataFilter['tRptCardCodeTo'],

            'ptUserIdF'     => $paDataFilter['tRptEmpCode'],
            'ptUserIdT'     => $paDataFilter['tRptEmpCodeTo'],

            'ptCrdStaActiveF'   => $paDataFilter['ocmRptStaCardFrom'],
            'ptCrdStaActiveT'   => $paDataFilter['ocmRptStaCardTo'],

            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],

            'FNResult'      => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo $this->db->last_query();
        // exit;
        if (false !== $oQuery) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }


    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator: 31/10/2019 Saharat(GolF)
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere) {

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSession'];

        $tSQL = "
            SELECT
                c.*
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY rtCrdCode ASC,rtTxnDocDate ASC) AS rtRowID, *
                FROM(
                    SELECT TOP 100 PERCENT
                    TMP.FTCrdCode                                                       AS rtCrdCode,
                    CONCAT(TMP.FTCrdCode,';',TMP.FTCtyName)                             AS rtCtyName,
                    CONCAT(TMP.FTCrdCode,';',CASE WHEN(TMP.FTCrdHolderID IS NULL OR TMP.FTCrdHolderID = '') THEN 'N/A' ELSE TMP.FTCrdHolderID END) AS rtCrdHolderID,
                    CONCAT(TMP.FTCrdCode,';',TMP.FTCrdName)                             AS rtCrdName,
                    CONCAT(TMP.FTCrdCode,';',TMP.FTCrdStaActive)  	                    AS rtCrdStaActive,
                    CONCAT(TMP.FTCrdCode,';',TMP.FTDptName)                             AS rtDptName,
                    /*CONCAT(TMP.FTCrdCode,';',TMP.FTDocCreateBy)                         AS rtTxnDocCreateBy,*/
                    FTUsrName,
                    CONCAT(TMP.FTCrdCode,';',CASE WHEN(TMP.FTTxnPosCode IS NULL OR TMP.FTTxnPosCode = '') THEN TMP.FTPosType ELSE TMP.FTTxnPosCode END) AS rtTxnPosCode,
                    CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocNoRef)                         AS rtTxnDocNoRef,
                    /*CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocTypeName)	                    AS rtTxnDocTypeName,*/
                    FTTxnDocType,
                    TMP.FDTxnDocDate	                                                AS rtTxnDocDate,
                    
                    ISNULL(
                        CASE 
                            WHEN TMP.FTTxnDocType = 1 THEN FCTxnValue 
                            WHEN TMP.FTTxnDocType = 2 THEN (FCTxnValue * -1)
                            WHEN TMP.FTTxnDocType = 3 THEN (FCTxnValue * -1) 
                            WHEN TMP.FTTxnDocType = 4 THEN FCTxnValue
                            WHEN TMP.FTTxnDocType = 5 THEN (FCTxnValue * -1)
                            WHEN TMP.FTTxnDocType = 8 THEN (FCTxnValue * -1)
                            WHEN TMP.FTTxnDocType = 9 THEN FCTxnValue
                            WHEN TMP.FTTxnDocType = 10 THEN (FCTxnValue * -1)
                            ELSE 0 
                        END,
                    0) AS rtTxnValue,
                    
                    CONCAT(TMP.FTCrdCode,';',TMP.FCTxnValAftTrans)	            AS rtCrdAftTrans,
                    CONCAT(TMP.FTCrdCode,';',TMP.FCTxnCrdValue)		            AS rtCrdBalance,
                    
                    TMP.FNLngID
                    FROM TFCTRptCrdTmp TMP WITH (NOLOCK)

                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
                ORDER BY
                TMP.FTTxnPosCode ASC,
                TMP.FDTxnDocDate ASC

            ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]


        ";    
   
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataRpt = $oQuery->result_array();

            $oCountRowRpt = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow = $oCountRowRpt;
            $nPageAll = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData = array(
                'raItems'   => $aDataRpt,
                'rnAllRow'  => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aReturnData = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($oQuery);
        unset($oCountRowRpt);
        unset($nFoundRow);
        unset($nPageAll);
        return $aReturnData;
    }

    
    //รายงานตรวจสอบข้อมูลการใช้บัตร[13] : ผลรวม
    public function FSaMRPTCRDGetDataRptCheckCardUseInfoSum($paDataWhere){
        
        $tComName     = $paDataWhere['tCompName'];
        $tRptName     = $paDataWhere['tRptCode'];
        
        $tSQL = "   SELECT 
                        -- SUM( 
                        --     CASE 
                        --         WHEN FTTxnDocType = 1 THEN FCTxnValue 
                        --         WHEN FTTxnDocType = 2 THEN (FCTxnValue * -1) 
                        --         WHEN FTTxnDocType = 3 THEN (FCTxnValue * -1) 
                        --         WHEN FTTxnDocType = 4 THEN FCTxnValue 
                        --         WHEN FTTxnDocType = 5 THEN (FCTxnValue * -1) 
                        --         WHEN FTTxnDocType = 8 THEN (FCTxnValue * -1) 
                        --         WHEN FTTxnDocType = 9 THEN FCTxnValue 
                        --         WHEN FTTxnDocType = 10 THEN (FCTxnValue * -1) 
                        --         ELSE '0' 
                        --     END
                        -- ) AS  FCTxnValueSum
                        SUM(ISNULL(FCTxnValAftTrans,0)) AS FCTxnValAftTrans
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }




    //รายงานตรวจสอบข้อมูลการใช้บัตร[13] : count
    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 10/10/2019 Saharat(GolF)
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tSessionID = $paDataWhere['tUserSession'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL = " SELECT FTRptName 
            FROM TFCTRptCrdTmp WITH (NOLOCK) 
            WHERE FTComName = '$tCompName' 
            AND FTRptName = '$tRptCode'    
        ";

        $oQuery = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }


}
