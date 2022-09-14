<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mReportAnalysis_wat extends CI_Model {

    //รายงานสรุปยอดเงินคงเหลือบัตรไม่ได้แลกคืน[5] : data source
    public function FSaMRptUnExchangeBalance($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $tSQL = "   SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                                ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC) AS rtRowID,
                                TMP.FTCrdCode    AS rtCrdCode,
                                TMP.FTCrdName    AS rtCrdName,
                                TMP.FTCtyName    AS rtCtyName,
                                ISNULL(CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121),'-') AS rtCrdExpireDate,
                                (
                                    CASE WHEN
                                        CONVERT(VARCHAR(10),GETDATE(),121) > CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121)
                                    THEN
                                        DATEDIFF(DAY,CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121),CONVERT(VARCHAR(10),GETDATE(),121))
                                    ELSE 0 END
                                ) AS rtCrdExpireDateQty,
                                SUM(CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE  0 END) AS rcCrdExpiredValue,
                                SUM(CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE  0 END) AS rcCrdReturnValue
                        FROM TFCTRptCrdAnalysisTmp TMP
                        WHERE 1=1 AND TMP.FTComName = '$tComName' 
                        AND (TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 5)";
            $tSQL   .=  " GROUP BY
                            TMP.FTCrdCode,
                            TMP.FTCrdName,
                            TMP.FTCtyName,
                            TMP.FDCrdExpireDate ) AS RPT";
            $tSQL .= "  WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= "  ORDER BY RPT.rtCrdCode ASC";
            
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRptUnExchangeBalanceCount($paFilterReport);
                // var_dump($nFoundRow);
                $nPageAll = ceil($nFoundRow / $paFilterReport['nRow']);

                $aReturnData = array(
                    'raItems'       => $aDataReturn,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paFilterReport['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                $aReturnData = '';
            }
            return $aReturnData;
            
        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRptAnsRptSaleShopByDate) =>'.$Error;
        }
    }

    //รายงานสรุปยอดเงินคงเหลือบัตรไม่ได้แลกคืน[5] : count
    public function FSaMRptUnExchangeBalanceCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tSQL = "   SELECT
                            ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC) AS rtRowID,
                            TMP.FTCrdCode,
                            TMP.FTCrdName,
                            TMP.FTCtyName,
                            TMP.FDCrdExpireDate
                        FROM TFCTRptCrdAnalysisTmp TMP
                        WHERE FTComName = '$tComName' AND (TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 5)
                        GROUP BY 
                            TMP.FTCrdCode,
                            TMP.FTCrdName,
                            TMP.FTCtyName,
                            TMP.FDCrdExpireDate";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->num_rows();
        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRptAnsRptSaleShopByDateCount) =>'.$Error;
        }
    }

    //รายงานสรุปยอดเงินคงเหลือบัตรไม่ได้แลกคืน[5] : ผลรวม
    public function FSaMRptUnExchangeBalanceSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tSQL = "   SELECT 
                        SUM(CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE  0 END) AS rcCrdExpiredValue,
                        SUM(CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE  0 END) AS rcCrdReturnValue,
                        SUM((CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE  0 END) - (CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE  0 END)) AS rcTotalValue
                    FROM TFCTRptCrdAnalysisTmp TMP   
                    WHERE FTComName = '$tComName' AND (TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 5) ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //--------------------------------START--------------------------------// 

    //รายงานการเคลื่อนไหวบัตร-แบบละเอียด[4] : data source
    public function FSaMRptCardActiveDetail($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $tSQL = "   SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                                ROW_NUMBER() OVER(ORDER BY TMP.FTBchName ASC , TMP.FTCrdCode ASC , TMP.FDTxnDocDate ASC) AS rtRowID,
                                TMP.FTBchCode                                AS rtBchCode,
                                ISNULL(TMP.FTBchName,'N/A')                  AS rtBchName,
                                TMP.FTCrdCode                                AS rtCrdCode,
                                TMP.FTCrdName                                AS rtCrdName,
                                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)    AS rtTxnDocDate,
                                CONVERT(TIME(0),TMP.FDTxnDocDate)            AS rtTxnDocTime,
                                TMP.FDTxnDocDate                             AS rtAllDateTime,
                                TMP.FTTxnDocTypeName                         AS rtTxnDocTypeName,
                                TMP.FTCrdHolderID                            AS rtCrdHolderID,
                                TMP.FTTxnPosCode                             AS rtTxnPosCode,
                                TMP.FCTxnCrdValue                            AS rtTxnCrdValue,
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
                                TMP.FNLngID                                  AS rnLngID,
                                (SELECT SUM(ISNULL(
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
                                    END,0)) 
                            FROM TFCTRptCrdAnalysisTmp TMP ) AS rtTotalTxnValue
                        
                        FROM TFCTRptCrdAnalysisTmp TMP
                        WHERE 1=1 AND TMP.FTComName = '$tComName' ";
            $tSQL .= "  ) AS RPT ";
            $tSQL .= "  WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= "  ORDER BY RPT.rtBchName ASC , RPT.rtCrdCode ASC , RPT.rtAllDateTime ASC ";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRptCardActiveDetailCount($paFilterReport);
                // var_dump($nFoundRow);
                $nPageAll = ceil($nFoundRow / $paFilterReport['nRow']);

                $aReturnData = array(
                    'raItems'       => $aDataReturn,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paFilterReport['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                $aReturnData = '';
            }
            return $aReturnData;
        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRptCardActiveDetail) =>'.$Error;
        }
    }

    //รายงานการเคลื่อนไหวบัตร-แบบละเอียด[4] : count
    public function FSaMRptCardActiveDetailCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tSQL   = " SELECT FTComName 
                        FROM TFCTRptCrdAnalysisTmp TMP WHERE FTComName = '$tComName' ";
           $oQuery = $this->db->query($tSQL);
           return $oQuery->num_rows();
       }catch(Exception $Error){
           echo 'Error mReportAnalysis Function(FSaMRptCardActiveDetailCount) =>'.$Error;
       }
    }

    //รายงานการเคลื่อนไหวบัตร-แบบละเอียด[4] : ผลรวม
    public function FSaMRptCardActiveDetailSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tSQL = "   SELECT 
                        SUM(FCTxnValue) AS rtTxnValue
                    FROM TFCTRptCrdAnalysisTmp TMP   
                    WHERE FTComName = '$tComName' ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
}