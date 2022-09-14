<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptBestSaleVending extends CI_Model {

    // Functionality: Delete Temp Report
    // Parameters:  Function Parameter
    // Creator: 04/04/2019 Witsarut(Bell)
    // LastModified: 26/09/2019 Wasin(Yoshi)
    // Return: Call Store Proce
    // ReturnType: Array
    public function FSnMExecStoreCReport($paDataFilter){
        $tCallStore = "{ CALL SP_RPTxVDDailyByPdtBstQty2001004(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],   
            'ptRptCode'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tSessionID'],
            'pnTop'         => $paDataFilter['tPriority'],
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            'ptMerF'        => $paDataFilter['tMerCodeFrom'], 
            'ptMerT'        => $paDataFilter['tMerCodeTo'],
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],    
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],
            'ptPdtCodeF'    => $paDataFilter['tPdtCodeFrom'],
            'ptPdtCodeT'    => $paDataFilter['tPdtCodeTo'],
            'ptPdtChanF'    => $paDataFilter['tPdtGrpCodeFrom'],
            'ptPdtChanT'    => $paDataFilter['tPdtGrpCodeTo'],
            'ptPdtTypeF'    => $paDataFilter['tPdtTypeCodeFrom'],
            'ptPdtTypeT'    => $paDataFilter['tPdtTypeCodeTo'],
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0,
        );
        $oQuery = $this->db->query($tCallStore,$aDataStore);
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Witsarut(Bell)
    // LastModified: 26/09/2019 Wasin(Yoshi)
    // Return: Count Data Report All
    // ReturnType: Array
    public function FSaMCountDataReportAll($paDataWhere){
        $tSessionID = $paDataWhere['tSessionID'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       = " SELECT
                            COUNT(FTRptCode) AS COUNTDATA
                        FROM TRPTVDTopSaleTmp WITH(NOLOCK)
                        WHERE 1 = 1
                        AND FTUsrSession = '$tSessionID' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'
        ";
        $oQuery     = $this->db->query($tSQL);
        $aCountData = $oQuery->row_array();
        unset($tSessionID);
        unset($tCompName);
        unset($tRptCode);
        unset($tSQL);
        unset($oQuery);
        return $aCountData['COUNTDATA'];
    }

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 04/04/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){
        $aRowLen        = FCNaHCallLenData($paDataWhere['nPerPage'],$paDataWhere['nPage']);
        $tSessionID         = $paDataWhere['tSessionID'];
        $tCompName          = $paDataWhere['tCompName'];
        $tRptCode           = $paDataWhere['tRptCode'];
        $tSQL = " SELECT c. * FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY rtRptCode ASC) AS rtRowID,* FROM (
                    SELECT TOP 100 PERCENT
                        FTPdtCode       AS rtPdtCode,
                        FTPdtName       AS rtPdtName,
                        FTPdtChainName  AS rtPdtChainName,
                        FCXsdQty        AS rtQty,
                        FCXsdNet        AS rtNet,
                        FCXsdDisChg     AS rtDisChg,
                        FCXsdGrandTotal AS rtGrandTotal,
                        FTUsrSession    AS rtUsrSession,
                        FTComName       AS rtComname,
                        FTRptCode       AS rtRptCode
                FROM TRPTVDTopSaleTmp 
                WHERE 1 = 1
                AND FTUsrSession = '$tSessionID' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'
                ORDER BY 
                FTPdtCode ASC
                ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $aDataRpt       = $oQuery->result_array();
            $oCountRowRpt   = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow      = $oCountRowRpt;
            $nPageAll       = ceil($nFoundRow / $paDataWhere['nPerPage']);
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
                'raItems'       => array(),
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
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

    // Functionality: To Get data SumFootReport
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Witsarut(Bell)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMGetDataSumFootReport($paDataWhere){
        $aRowLen    = FCNaHCallLenData($paDataWhere['nPerPage'],$paDataWhere['nPage']);
        $tSessionID = $paDataWhere['tSessionID'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       =   "   SELECT
                                ISNULL(SUM(FCXsdQty),0) 		AS FCXsdQty_SumFooter,
                                ISNULL(SUM(FCXsdNet),0) 		AS FCXsdNet_SumFooter,
                                ISNULL(SUM(FCXsdDisChg),0) 	    AS FCXsdDisChg_SumFooter,
                                ISNULL(SUM(FCXsdGrandTotal),0) 	AS FCXsdGrandTotal_SumFooter
                            FROM TRPTVDTopSaleTmp
                            WHERE 1 = 1 
                            AND FTComName = '".$tCompName."' AND FTRptCode = '".$tRptCode."' AND FTUsrSession = '".$tSessionID."'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return array();
        }
    }


}