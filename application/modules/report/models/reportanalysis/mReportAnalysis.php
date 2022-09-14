<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mReportAnalysis extends CI_Model {

    //Functionality: Get Data Menu List Report Analysis
    //Parameters:  Function Parameter
    //Creator: 11/12/2018 Wasin(Yoshi)
    //Last Modified :
    //Return : Array Data Menu List Report
    //Return Type: Array
    public function FSaMRPAGetMenuReportAnalysis($paWhereData){
        $tUsrRoleCode   = $paWhereData['tUsrRoleCode'];
        $nLngID         = $paWhereData['nLngID'];
        $tSQL = "SELECT
                    M.FTMnuCode,
                    M.FNMnuSeq,
                    ML.FTMnuName,
                    M.FTMnuCtlName
                FROM TCNTUsrMenu USERMENU WITH (NOLOCK)
                INNER JOIN TSysMenuList M WITH (NOLOCK) ON USERMENU.FTMnuCode = M.FTMnuCode 
                LEFT JOIN TSysMenuList_L ML WITH (NOLOCK) ON M.FTMnuCode = ML.FTMnuCode AND ML.FNLngID = $nLngID
                WHERE FTGmnModCode = 'RPTANS'  AND USERMENU.FTRolCode = '$tUsrRoleCode' 
                AND USERMENU.FTAutStaRead = '1'
                ORDER BY M.FNMnuSeq ASC ";
        // print_r($tSQL);
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDataReturn = $oQuery->result_array();
        }else{
            $aDataReturn = '';
        }
        return $aDataReturn;
    }

    //Functionality: Get หมายเลขประจำตัวเสียภาษี
    //Parameters:  Function Parameter
    //Creator: 19/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPAGetAddTaxNo($ptBchCode){
        try{
            if(!empty($ptBchCode)){
                $tWhereBranch = " AND (FTAddRefCode = '".$ptBchCode."')";
            }else{
                $tWhereBranch = "";
            }
            $tSQL =  "SELECT TOP 1 FTAddTaxNo FROM TCNMAddress_L";
            $tSQL .= " WHERE 1 = 1";
            $tSQL .= " $tWhereBranch";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aData = $oQuery->result_array();
                $tAddTaxNo = $aData[0]['FTAddTaxNo'];
                if($tAddTaxNo == ''){
                    $tAddTaxNo = '-';
                }
            }else{
                $tAddTaxNo = '-';
            }
            return $tAddTaxNo;
        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRPTCRDGetAddTaxNo) =>'.$Error;
        }
    }
    
    /**
     * Functionality: Get Data Report SaleShopByDate
     * Parameters:  Function Parameter
     * Creator: 12/12/2018 Wasin(Yoshi)
     * Last Modified :
     * Return : Array Data Report SaleShopByDate
     * Return Type: Array
     */
    public function FSaMRptAnsRptSaleShopByDate($paFilterReport, $pnStaOverLimit){
        try{

            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $tSQL = "   SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                                ROW_NUMBER() OVER(ORDER BY TMP.FTBchCode ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTShpCode ASC) AS rtRowID,
                                TMP.FTBchCode AS rtBchCode, 
                                ISNULL(TMP.FTBchName, 'N/A') AS rtBchName,
                                TMP.FTShpCode AS rtShpCode,
                                TMP.FTShpName AS rtShpName,
                                TMP.FTTxnDocType AS rtTxnDocType,
                                TMP.FNLngID AS rnLngID,
                                CONVERT(VARCHAR(10), TMP.FDTxnDocDate, 121) AS rtTxnDocDate,
                                SUM(CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnSaleVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnCancelSaleVal
                            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                            WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
                            GROUP BY 
                                TMP.FTBchCode,
                                TMP.FTBchName,
                                TMP.FTShpCode,
                                TMP.FTShpName,
                                TMP.FTTxnDocType,
                                TMP.FNLngID,
                                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)    
                        ) AS RPT ";
            $tSQL .= "  WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= "  ORDER BY RPT.rtBchCode ASC, CONVERT(VARCHAR(10),RPT.rtTxnDocDate,121) ASC, RPT.rtShpCode ASC";

            //echo $tSQL;

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRptAnsRptSaleShopByDateCount($paFilterReport);
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

    //Functionality: Get Data Report SaleShopByDate Count
    //Parameters:  Function Parameter
    //Creator: 12/12/2018 Wasin(Yoshi)
    //Last Modified : 05/04/2019 Wasin(Yoshi)
    //Return : Array Data Report SaleShopByDate
    //Return Type: Array
    public function FSaMRptAnsRptSaleShopByDateCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT
                            ROW_NUMBER() OVER(ORDER BY TMP.FTBchCode ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTShpCode ASC) AS rtRowID
                        FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                        GROUP BY 
                            TMP.FTBchCode,
                            TMP.FTBchName,
                            TMP.FTShpCode,
                            TMP.FTShpName,
                            TMP.FTTxnDocType,
                            TMP.FNLngID,
                            CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->num_rows();
        
        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRptAnsRptSaleShopByDateCount) =>'.$Error;
        }
    }
    
    /**
     * Functionality: Summary Data Report SaleShopByDate
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Piya
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRptAnsRptSaleShopByDateSum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnSaleVal,
                        SUM(CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnCancelSaleVal,
                        SUM( (CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE  0 END) - (CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE  0 END) ) AS rcTotalSale
                    FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)  
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //Functionality: Get Data Report SaleShopByShop
    //Parameters:  Function Parameter
    //Creator: 13/12/2018 Wasin(Yoshi)
    //Last Modified :
    //Return : Array Data Report SaleShopByShop
    //Return Type: Array
    public function FSaMRptSaleShopByShop($paFilterReport, $pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $tSQL = "   SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                                ROW_NUMBER() OVER(ORDER BY TMP.FTBchCode ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTShpCode ASC) AS rtRowID,
                                TMP.FTBchCode AS rtBchCode,
                                ISNULL(TMP.FTBchName, 'N/A') AS rtBchName,
                                TMP.FTShpCode AS rtShpCode,
                                TMP.FTShpName AS rtShpName,
                                TMP.FNLngID AS rnLngID,
                                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)    AS rtTxnDocDate,
                                SUM(CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnSaleVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnCancelSaleVal
                            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                            WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
                            AND (TMP.FTTxnDocType = 3 OR TMP.FTTxnDocType = 4)    
                            GROUP BY 
                                TMP.FTBchCode,
                                TMP.FTBchName,
                                TMP.FTShpCode,
                                TMP.FTShpName,
                                TMP.FNLngID,
                                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)
                        ) AS RPT ";
            $tSQL .= "  WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= "  ORDER BY RPT.rtBchCode ASC, CONVERT(VARCHAR(10),RPT.rtTxnDocDate,121) ASC, RPT.rtShpCode ASC";

            //echo $tSQL;

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRptSaleShopByShopCount($paFilterReport);
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
            echo 'Error mReportAnalysis Function(FSaMRptSaleShopByShop) =>'.$Error;
        }
    }

    //Functionality: Get Data Report SaleShopByShop Count
    //Parameters:  Function Parameter
    //Creator: 12/12/2018 Wasin(Yoshi)
    //Last Modified : 05/04/2019 Wasin(Yoshi)
    //Return : Array Data Report SaleShopByDate
    //Return Type: Array
    public function FSaMRptSaleShopByShopCount($paFilterReport){
        try{
            
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT
                            ROW_NUMBER() OVER(ORDER BY TMP.FTBchCode ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTShpCode ASC) AS rtRowID
                        FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                        AND (TMP.FTTxnDocType = 3 OR TMP.FTTxnDocType = 4)
                        GROUP BY 
                            TMP.FTBchCode,
                            TMP.FTBchName,
                            TMP.FTShpCode,
                            TMP.FTShpName,
                            TMP.FNLngID,
                            CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->num_rows();
            
        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRptSaleShopByShop) =>'.$Error;
        }
    }
    
    /**
     * Functionality: Summary Data Report SaleShopByShop
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Piya
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRptSaleShopByShopSum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnSaleVal,
                        SUM(CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnCancelSaleVal,
                        SUM( (CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE  0 END) - (CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE  0 END) ) AS rcTotalSale
                    FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)  
                    WHERE FTComName = '$tComName' AND FTRptName ='$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
    
    //Functionality: Get Data Report Card Active Summary
    //Parameters:  Function Parameter
    //Creator: 14/12/2018 Wasin(Yoshi)
    //Last Modified :
    //Return : Array Data Report Card Active Summary
    //Return Type: Array
    public function FSaMRptCardActiveSummary($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $tSQL = "   SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                                ROW_NUMBER() OVER(ORDER BY TMP.FTBchName ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTCrdCode ASC) AS rtRowID,
                                TMP.FTBchCode AS rtBchCode,
                                ISNULL(TMP.FTBchName,'N/A') AS rtBchName,
                                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) AS rtTxnDocDate,
                                TMP.FTCrdCode AS rtCrdCode,
                                TMP.FTCrdName AS rtCrdName,
                                /*TMP.FCTxnCrdValue AS rcTxnCrdVal,*/
                                TMP.FCCrdValue AS rcTxnCrdVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 0 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnRemainVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 9 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnTranferInVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnTopUpVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 2 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnCancelTopUpVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnSalePayMentVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnCancelSalePayMentVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnReturnValueVal,
                                SUM(CASE WHEN TMP.FTTxnDocType = 8 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnTranferOutVal
                            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                            WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
                            AND (TMP.FTTxnDocType = 0 OR TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 2
                            OR TMP.FTTxnDocType = 3 OR TMP.FTTxnDocType = 4 OR TMP.FTTxnDocType = 5 OR TMP.FTTxnDocType = 8 OR TMP.FTTxnDocType = 9)
                            GROUP BY 
                                TMP.FTBchCode,
                                TMP.FTBchName,
                                TMP.FTCrdCode,
                                TMP.FTCrdName,
                                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121),
                                TMP.FCCrdValue
                        ) AS RPT ";
            $tSQL .= "  WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= "  ORDER BY RPT.rtBchName ASC, CONVERT(VARCHAR(10),RPT.rtTxnDocDate,121) ASC, RPT.rtCrdCode ASC";

            //echo $tSQL;

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRptCardActiveSummaryCount($paFilterReport);
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
            echo 'Error mReportAnalysis Function(FSaMRptCardActiveSummary) =>'.$Error;
        }
    }
    
    //Functionality: Get Data Report Card Active Summary Count
    //Parameters:  Function Parameter
    //Creator: 14/12/2018 Wasin(Yoshi)
    //Last Modified :
    //Return : Array Data Report Card Active Summary
    //Return Type: Array
    public function FSaMRptCardActiveSummaryCount($paFilterReport){
        try{

            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL =     "   SELECT
                                ROW_NUMBER() OVER(ORDER BY TMP.FTBchName ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTCrdCode ASC) AS rtRowID
                            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                            WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                            AND (TMP.FTTxnDocType = 0 OR TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 2
                            OR TMP.FTTxnDocType = 3 OR TMP.FTTxnDocType = 4 OR TMP.FTTxnDocType = 5 OR TMP.FTTxnDocType = 8 OR TMP.FTTxnDocType = 9)
                            GROUP BY 
                                TMP.FTBchCode,
                                TMP.FTBchName,
                                TMP.FTCrdCode,
                                TMP.FTCrdName,
                                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121),
                                TMP.FCCrdValue
                        ";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->num_rows();

        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRptCardActiveSummary) =>'.$Error;
        }
    }

    /**
     * Functionality: Summary Data Report SaleShopByShop
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Piya
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRptCardActiveSummarySum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(A.rcTxnRemainVal) AS rcTxnRemainVal,
                        SUM(A.rcTxnTranferInVal) AS rcTxnTranferInVal,
                        SUM(A.rcTxnTopUpVal) AS rcTxnTopUpVal,
                        SUM(A.rcTxnCancelTopUpVal) AS rcTxnCancelTopUpVal,
                        SUM(A.rcTxnSalePayMentVal) AS rcTxnSalePayMentVal,
                        SUM(A.rcTxnCancelSalePayMentVal) AS rcTxnCancelSalePayMentVal,
                        SUM(A.rcTxnReturnValueVal) AS rcTxnReturnValueVal,
                        SUM(A.rcTxnTranferOutVal) AS rcTxnTranferOutVal,
                        SUM(A.rcTotalBalance) AS rcTotalBalance
                    FROM (
                        SELECT
                            SUM(CASE WHEN TMP.FTTxnDocType = 0 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnRemainVal,
                            SUM(CASE WHEN TMP.FTTxnDocType = 9 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnTranferInVal,
                            SUM(CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnTopUpVal,
                            SUM(CASE WHEN TMP.FTTxnDocType = 2 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnCancelTopUpVal,
                            SUM(CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnSalePayMentVal,
                            SUM(CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE 0 END) AS rcTxnCancelSalePayMentVal,
                            SUM(CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnReturnValueVal,
                            SUM(CASE WHEN TMP.FTTxnDocType = 8 THEN TMP.FCTxnValue ELSE 0 END) * -1 AS rcTxnTranferOutVal,

                            SUM( 
                                (CASE WHEN TMP.FTTxnDocType = 0 THEN TMP.FCTxnValue ELSE 0 END) +
                                (CASE WHEN TMP.FTTxnDocType = 9 THEN TMP.FCTxnValue ELSE 0 END) +
                                (CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE 0 END) +
                                (CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE 0 END) -
                                (CASE WHEN TMP.FTTxnDocType = 2 THEN TMP.FCTxnValue ELSE 0 END) -
                                (CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE 0 END) -
                                (CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE 0 END) -
                                (CASE WHEN TMP.FTTxnDocType = 8 THEN TMP.FCTxnValue ELSE 0 END)
                            ) AS rcTotalBalance
                        FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)  
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                        AND (TMP.FTTxnDocType = 0 OR TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 2
                        OR TMP.FTTxnDocType = 3 OR TMP.FTTxnDocType = 4 OR TMP.FTTxnDocType = 5 OR TMP.FTTxnDocType = 8 OR TMP.FTTxnDocType = 9)
                        GROUP BY 
                            TMP.FTBchCode,
                            TMP.FTBchName,
                            TMP.FTCrdCode,
                            TMP.FTCrdName,
                            CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121),
                            TMP.FCCrdValue
                        --ORDER BY TMP.FTBchName ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTCrdCode ASC    
                    ) A";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //Functionality: Get Data Report Card Active Detail
    //Parameters:  Function Parameter
    //Creator: 14/12/2018 Wasin(Yoshi)
    //Last Modified :
    //Return : Array Data Report Card Active Detail
    //Return Type: Array
    //รายงานการเคลื่อนไหวบัตร-แบบละเอียด[4] : data source
    public function FSaMRptCardActiveDetail($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

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
                                TMP.FTTxnDocType                             AS rtTxnDocType,   
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
                                TMP.FNLngID AS rnLngID
                        
                        FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                        WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'";
            $tSQL .= "  ) AS RPT ";
            $tSQL .= "  WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= "  ORDER BY RPT.rtBchName ASC , RPT.rtCrdCode ASC , RPT.rtAllDateTime ASC";

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
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL   = " SELECT FTComName 
                        FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
           $oQuery = $this->db->query($tSQL);
           return $oQuery->num_rows();
       }catch(Exception $Error){
           echo 'Error mReportAnalysis Function(FSaMRptCardActiveDetailCount) =>'.$Error;
       }
    }

    //รายงานการเคลื่อนไหวบัตร-แบบละเอียด[4] : ผลรวม
    public function FSaMRptCardActiveDetailSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                            SUM(A.FCTxnValue) AS rtTxnValue
                        FROM(
                            SELECT
                                (CASE 
                                    WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue 
                                    WHEN TMP.FTTxnDocType = 2 THEN (TMP.FCTxnValue * -1)
                                    WHEN TMP.FTTxnDocType = 3 THEN (TMP.FCTxnValue * -1) 
                                    WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue
                                    WHEN TMP.FTTxnDocType = 5 THEN (TMP.FCTxnValue * -1)
                                    WHEN TMP.FTTxnDocType = 8 THEN (TMP.FCTxnValue * -1)
                                    WHEN TMP.FTTxnDocType = 9 THEN TMP.FCTxnValue
                                    WHEN TMP.FTTxnDocType = 10 THEN (TMP.FCTxnValue * -1)
                                    ELSE 0 
                                END) AS FCTxnValue

                            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                            WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                            --ORDER BY FTBchName ASC , FTCrdCode ASC , FDTxnDocDate ASC
                        ) A
                    ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //รายงานสรุปยอดเงินคงเหลือบัตรไม่ได้แลกคืน[5] : data source
    public function FSaMRptUnExchangeBalance($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

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
                        FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                        WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
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
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT
                            ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC) AS rtRowID,
                            TMP.FTCrdCode,
                            TMP.FTCrdName,
                            TMP.FTCtyName,
                            TMP.FDCrdExpireDate
                        FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                        WHERE TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName' AND (TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 5)
                        GROUP BY 
                            TMP.FTCrdCode,
                            TMP.FTCrdName,
                            TMP.FTCtyName,
                            TMP.FDCrdExpireDate";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->num_rows();
        }catch(Exception $Error){
            echo 'Error mReportAnalysis Function(FSaMRptUnExchangeBalanceCount) =>'.$Error;
        }
    }

    //รายงานสรุปยอดเงินคงเหลือบัตรไม่ได้แลกคืน[5] : ผลรวม
    public function FSaMRptUnExchangeBalanceSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE  0 END) AS rcCrdExpiredValue,
                        SUM(CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE  0 END) AS rcCrdReturnValue,
                        SUM((CASE WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue ELSE  0 END) - (CASE WHEN TMP.FTTxnDocType = 5 THEN TMP.FCTxnValue ELSE  0 END)) AS rcTotalValue
                    FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)  
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName' AND (TMP.FTTxnDocType = 1 OR TMP.FTTxnDocType = 5) ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

}
