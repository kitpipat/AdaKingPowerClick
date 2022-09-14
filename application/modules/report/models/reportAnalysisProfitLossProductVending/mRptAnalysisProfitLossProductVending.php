<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


class mRptAnalysisProfitLossProductVending extends CI_Model {
   
    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 01/10/2019 Witsarut(Bell)
    //Last Modified : - 
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreCReport($paDataFilter){

        $tCallStore = "{ CALL SP_RPTxVDSalByProfitByLoss(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore     = array(
            'pnLngID'        => $paDataFilter['nLangID'],
            'pnComName'      => $paDataFilter['tCompName'],
            'ptRptCode'      => $paDataFilter['tRptCode'],
            'ptUsrSession'   => $paDataFilter['tUserSession'],
            'ptBchF'         => $paDataFilter['tBchCodeFrom'],
            'ptBchT'         => $paDataFilter['tBchCodeTo'],
            'ptShpF'         => $paDataFilter['tShpCodeFrom'],
            'ptShpT'         => $paDataFilter['tShpCodeTo'],
            'ptPosCodeF'     => $paDataFilter['tPosCodeFrom'],
            'ptPosCodeT'     => $paDataFilter['tPosCodeTo'],
            'ptChainCodeF'   => $paDataFilter['tPdtGrpCodeFrom'],
            'ptChainCodeT'   => $paDataFilter['tPdtGrpCodeTo'],
            'ptProductCodeF' => $paDataFilter['tPdtCodeFrom'],
            'ptProductCodeT' => $paDataFilter['tPdtCodeTo'],
            'ptDocDateF'     => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'     => $paDataFilter['tDocDateTo'],
            'FNResult'       => 0,
        );
        $oQuery  =  $this->db->query($tCallStore,$aDataStore);
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1 ;                
        }else{
            unset($oQuery);
            return 0;
        } 
    }

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 01/10/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere,$paDataFilter){

        $aRowLen        = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);
        $tUserSession   = $paDataWhere['tUserSession'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        
        $tSQL = " SELECT c. * FROM(
            SELECT  ROW_NUMBER() OVER(ORDER BY rtRptCode ASC) AS rtRowID,* FROM (
                SELECT TOP 100 PERCENT
                    FTPdtCode       AS rtPdtCode,
                    FTPdtName       AS rtPdtName,
                    FTChainName     AS rtChainName,
                    FCXsdSaleQty    AS rtSaleQty,
                    FCPdtCost       AS rtPdtCost,
                    FCXshGrand      AS rtGrand,
                    FCXsdProfit     AS rtProfit,
                    FCXsdProfitPercent  AS rtProfitPercent,
                    FCXsdSalePercent    AS rtSalePercent,
                    FTComName       AS rtComname,
                    FTRptCode       AS rtRptCode,
                    FTUsrSession    AS rtUsrSession
            FROM TRPTVDTSaleProfitTmp 
            WHERE 1 = 1
            AND FTUsrSession = '$tUserSession' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'
            ORDER BY 
            FTPdtCode ASC
            ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $aDataRpt       = $oQuery->result_array();
            $nCountRowRpt   = $this->FSnMCountDataReportAll($paDataWhere);
            $nFoundRow      = $nCountRowRpt;
            $nPageAll       = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData    = array(
                'raItems'       => $aDataRpt,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aReturnData    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );

        }
        unset($oQuery);
        unset($oCountRowRpt);
        unset($nFoundRow);
        unset($nPageAll);
        return $aReturnData;
    }
    
    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 01/10/2019 Witsarut(Bell)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountDataReportAll($paDataWhere){
        $tUserSession    = $paDataWhere['tUserSession'];
        $tCompName       = $paDataWhere['tCompName'];
        $tRptCode        = $paDataWhere['tRptCode'];

        $tSQL    =   "   SELECT 
                            COUNT(PFTMP.FTRptCode) AS rnCountPage
                        FROM TRPTVDTSaleProfitTmp AS PFTMP WITH(NOLOCK)
                        WHERE 1 = 1
                        AND FTUsrSession    = '$tUserSession'
                        AND FTComName       = '$tCompName'
                        AND FTRptCode       = '$tRptCode'
        ";
        $oQuery         = $this->db->query($tSQL);
        $nRptAllRecord  = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }

    // Functionality: To Get data SumFootReport
    // Parameters: Function Parameter
    // Creator: 01/10/2019 Witsarut(Bell)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMGetDataSumFootReport($paDataWhere,$paDataFilter){
        $aRowLen        = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']); 
        $tUserSession   = $paDataWhere['tUserSession'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        $tSQL = "  SELECT
                        
                        NULLIF(SUM(FCXsdSaleQty),0)         AS FCXsdSaleQty_SumFooter,
                        NULLIF(SUM(FCPdtCost),0) 	        AS FCPdtCost_SumFooter,
                        NULLIF(SUM(FCXshGrand),0) 	        AS FCXshGrand_SumFooter,
                        NULLIF(SUM(FCXsdProfit),0)          AS FCXsdProfit_SumFooter,

                        -- NULLIF(SUM(FCXsdProfitPercent),0)  AS FCXsdProfitPercent_SumFooter,
                        -- NULLIF(SUM(FCXsdSalePercent),0)  AS FCXsdSalePercent_SumFooter,

                        ((NULLIF(SUM(FCXsdProfit),0)  /  NULLIF(SUM(FCPdtCost),0)) * 100)  AS  FCXsdProfitPercent_SumFooter,
                        ((NULLIF(SUM(FCXsdProfit),0) / NULLIF(SUM(FCXshGrand),0)) * 100) AS FCXsdSalePercent_SumFooter

                    FROM TRPTVDTSaleProfitTmp AS PFTMP WITH(NOLOCK)
                    WHERE 1 = 1 
                    AND FTUsrSession = '$tUserSession' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return array();
        }

    }
}


