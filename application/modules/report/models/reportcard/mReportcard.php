<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
set_time_limit(0);
ini_set('memory_limit', '-1');

class mReportcard extends CI_Model {
    
    public function FSaMRPCGetDataReportcardList($pnLngID,$pnRoleCode){
        $tSQL = "   SELECT 
                        M.FTMnuCode,
                        M.FNMnuSeq,
                        ML.FTMnuName,
                        M.FTMnuCtlName
                    FROM TCNTUsrMenu USERMENU WITH (NOLOCK)
                    INNER JOIN TSysMenuList M ON USERMENU.FTMnuCode = M.FTMnuCode 
                    LEFT JOIN TSysMenuList_L ML ON M.FTMnuCode = ML.FTMnuCode AND ML.FNLngID = $pnLngID
                    WHERE FTGmnModCode = 'RPTCRD'  AND USERMENU.FTRolCode = '$pnRoleCode' 
                    AND USERMENU.FTAutStaRead = '1'
                    ORDER BY M.FNMnuSeq ASC ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $tData = $oQuery->result_array();
        }else{
        $tData = '';
        }
        return $tData;
    }

    //Functionality: Get data Year LIst รายงานรายการต้นงวดบัตรและเงินสด
    //Parameters:  Function Parameter
    //Creator: 16/01/2019 (Bell)
    //Last Modified :
    //Return : 
    //Return Type: Array
    Public function FSaMRPGetdataYearList(){
        $tSQL = "SELECT DISTINCT 
                            VCNP.FTTxnYear  AS rtSelected
                FROM VCN_TFCTCrdPrinciple VCNP WITH (NOLOCK)
                WHERE 1=1 AND VCNP.FNCtyLngID = 1";

        $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $tData = $oQuery->result_array();
            }else{
        $tData = '';
        }
        return $tData;
    }

    //Functionality: Get หมายเลขประจำตัวเสียภาษี
    //Parameters:  Function Parameter
    //Creator: 19/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPTCRDGetAddTaxNo($ptBchCode){
        if(!empty($ptBchCode)){
            $tWhereBranch = " AND (FTAddRefCode = '".$ptBchCode."')";
        }else{
            $tWhereBranch = "";
        }

        try{

            $tSQL =  "SELECT TOP 1 FTAddTaxNo FROM TCNMAddress_L WITH (NOLOCK)";
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
                $tAddTaxNo = 'xxx';
            }
            return $tAddTaxNo;

        }catch(Exception $Error){
            echo $Error;
        }
    }

    /**
     * Functionality: Get ที่อยู่บริษัท
     * Parameters:  Function Parameter
     * Creator: 27/11/2018 Krit(Copter)
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetCompAddress($ptBchCode){

        if(!empty($ptBchCode)){
            $tWhereBranch = " AND (FTAddRefCode = '".$ptBchCode."')";
        }else{
            $tWhereBranch = "";
        }

        try{

            $tSQL =  "SELECT TOP 1 FTAddTaxNo FROM TCNMAddress_L WITH (NOLOCK)";
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
                $tAddTaxNo = 'xxx';
            }
            return $tAddTaxNo;

        }catch(Exception $Error){
            echo $Error;
        }

    }

    /**
     * Functionality: Get Data Report รายงานข้อมูลการใช้บัตร/1
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Krit(Copter)
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptUseCard1($paFilterReport, $pnStaOverLimit){
        $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        if(!empty($pnStaOverLimit)){
            $tTopLimit  = "TOP($pnStaOverLimit)";
        }
        
        $tSQL = "   SELECT $tTopLimit
                        RPT.* 
                    FROM( 
                        SELECT 
                            ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FTCrdName ASC, TMP.FDTxnDocDate ASC) AS rtRowID,
                            TMP.FTTxndocType, 
                            TMP.FTCrdCode AS rtCrdCode, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTCrdName) AS rtCrdName, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTShpCode) AS rtShpCode, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTShpName) AS rtShpName, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTTxnPosCode) AS rtTxnPosCode, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTPosType) AS rtTxnPosType, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocRefNo) AS rtTxnDocNoRef, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocNoRef) AS rtTxnDocNo, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocTypeName) AS rtTxnDocTypeName, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTDocCreateBy) AS rtTxnDocCreateBy, 
                            TMP.FDTxnDocDate AS rtTxnDocDate, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FCCrdBalance) AS rtCrdBalance,
                            TMP.FNLngID, 
                                CASE
                                    WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue 
                                    WHEN TMP.FTTxnDocType = 2 THEN (TMP.FCTxnValue * -1) 
                                    WHEN TMP.FTTxnDocType = 3 THEN (TMP.FCTxnValue * -1) 
                                    WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue 
                                    WHEN TMP.FTTxnDocType = 5 THEN (TMP.FCTxnValue * -1) 
                                    WHEN TMP.FTTxnDocType = 8 THEN (TMP.FCTxnValue * -1) 
                                    WHEN TMP.FTTxnDocType = 9 THEN TMP.FCTxnValue 
                                    WHEN TMP.FTTxnDocType = 10 THEN (TMP.FCTxnValue * -1) 
                                ELSE '0' 
                            END AS rtTxnValue 
                        FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                        WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName' 	
                    ) AS RPT ";
        $tSQL .= " WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
        $tSQL .= " ORDER BY RPT.rtCrdCode ASC, RPT.rtCrdName ASC, RPT.rtTxnDocDate ASC";
				
		// echo $tSQL;
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDataReturn = $oQuery->result_array();
            $nFoundRow = $this->FSaMRPTCRDGetDataRptUseCard1Count($paFilterReport);
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
		
    }

    /**
     * Functionality: Count Data Report รายงานข้อมูลการใช้บัตร/1
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Krit(Copter)
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptUseCard1Count($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        $tSQL = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array()[0]["FTComName"];
    }
    
    /**
     * Functionality: Summary Data Report รายงานข้อมูลการใช้บัตร/1
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Piya
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptUseCard1Sum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        $tSQL = "   SELECT 
                        SUM( 
                            CASE 
                                WHEN FTTxnDocType = 1 THEN FCTxnValue 
                                WHEN FTTxnDocType = 2 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 3 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 4 THEN FCTxnValue 
                                WHEN FTTxnDocType = 5 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 8 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 9 THEN FCTxnValue 
                                WHEN FTTxnDocType = 10 THEN (FCTxnValue * -1) 
                                ELSE '0' 
                            END
                        ) AS FCTxnValueSum
                    FROM TFCTRptCrdTmp WITH (NOLOCK)   
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    /**
     * Functionality: Get Data Report รายงานตรวจสอบสถานะบัตร
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Krit(Copter)
     * Last Modified : 25/1/2019 Piya Add card status filter
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptCheckStatusCard($paFilterReport, $pnStaOverLimit){
        $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        if(!empty($pnStaOverLimit)){
            $tTopLimit  = "TOP($pnStaOverLimit)";
        }
        
        try{

            $tSQL  = "  SELECT $tTopLimit
                            RPT.*
                            FROM(
                                SELECT
                                    ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FDTxnDocDate ASC) AS rtRowID, TMP.* 
                                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                                WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
                            ) AS RPT        
                        WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
                        ORDER BY RPT.FTCrdCode ASC, RPT.FDTxnDocDate ASC";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRPTCRDGetDataRptCheckStatusCardCount($paFilterReport);
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
            echo $Error;
        }

    }

    /**
     * Functionality: Get Data Report รายงานตรวจสอบสถานะบัตร
     * Parameters:  Function Parameter
     * Creator: 10/06/2019 Piya
     * Last Modified : -
     * Return :
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptCheckStatusCardCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];

        }catch(Exception $Error){
            echo $Error;
        }

    }

    /**
     * Functionality: Summary Data Report รายงานตรวจสอบสถานะบัตร
     * Parameters:  Function Parameter
     * Creator: 11/06/2019 Piya
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptCheckStatusCardSum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(ISNULL(FCCrdValue,0)) AS FCCrdValueSum
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    /**
     * Functionality: Get Data Report รายงานโอนข้อมูลบัตร
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Krit(Copter)
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptTransferCardInfo($paFilterReport, $pnStaOverLimit){
        $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        if(!empty($pnStaOverLimit)){
            $tTopLimit  = "TOP($pnStaOverLimit)";
        }
        
        try{
            $tSQL  = "  SELECT $tTopLimit
                            RPT.*
                            FROM(
                                SELECT
                                    ROW_NUMBER() OVER(ORDER BY TMP.FDDocDate ASC) AS rtRowID, TMP.* 
                                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                                WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
                                /*AND (TMP.FTCvhDocType = 2 AND TMP.FTCvhStaPrcDoc = 1 AND TMP.FTCvhStaDoc = 1 AND TMP.FTCvdStaCrd = 1)*/    
                            ) AS RPT        
                        WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
                        ORDER BY RPT.FDDocDate ASC";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRPTCRDGetDataRptTransferCardInfoCount($paFilterReport);
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
            echo $Error;
        }

    }

    /**
     * Functionality: Get Data Report รายงานโอนข้อมูลบัตร
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Krit(Copter)
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptTransferCardInfoCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT 
                            COUNT(FTComName) AS FTComName 
                        FROM TFCTRptCrdTmp WITH (NOLOCK)
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                        /*AND (TMP.FTCvhDocType = 2 AND TMP.FTCvhStaPrcDoc = 1 AND TMP.FTCvhStaDoc = 1 AND TMP.FTCvdStaCrd = 1)*/";
            
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];

        }catch(Exception $Error){
            echo $Error;
        }

    }

    /**
     * Functionality: Get Data Report รายงานการปรับมูลค่าเงินสดในบัตร
     * Parameters:  Function Parameter
     * Creator: 20/11/2018 Krit(Copter)
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptAdjustCashInCard($paFilterReport, $pnStaOverLimit){
        $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        if(!empty($pnStaOverLimit)){
            $tTopLimit  = "TOP($pnStaOverLimit)";
        }
        
        try{

            $tSQL  = "  SELECT $tTopLimit
                            RPT.*
                            FROM(
                                SELECT
                                    ROW_NUMBER() OVER(ORDER BY TMP.FDDocDate ASC) AS rtRowID, TMP.* 
                                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                                WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
                                /*AND FTTxnDocType = 1*/   
                            ) AS RPT        
                        WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
                        ORDER BY RPT.FTTxnPosCode ASC, RPT.FDTxnDocDate";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRPTCRDGetDataRptTransferCardInfoCount($paFilterReport);
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
            echo $Error;
        }

    }

    /**
     * Functionality: Get Data Report รายงานการปรับมูลค่าเงินสดในบัตร
     * Parameters:  Function Parameter
     * Creator: 20/11/2018 Krit(Copter)
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptAdjustCashInCardCount($paFilterReport){
        try{

            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT 
                            COUNT(FTComName) AS FTComName 
                        FROM TFCTRptCrdTmp WITH (NOLOCK)
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                        /*AND FTTxnDocType = 1*/";
            
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];

        }catch(Exception $Error){
            echo $Error;
        }

    }

    /**
     * Functionality: Summary Data Report รายงานการปรับมูลค่าเงินสดในบัตร
     * Parameters:  Function Parameter
     * Creator: 11/06/2019 Piya
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptAdjustCashInCardSum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(ISNULL(FCTxnValue,0)) AS FCTxnValueSum
                    FROM TFCTRptCrdTmp WITH (NOLOCK)   
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //Functionality: Get Data Report รายงานการล้างมูลค่าบัตรเพื่อกลับมาใช้งานใหม่
    //Parameters:  Function Parameter
    //Creator: 21/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPTCRDGetDataRptClearCardValueForReuse($paFilterReport,$pnStaOverLimit){
        $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        if(!empty($pnStaOverLimit)){
            $tTopLimit  = "TOP($pnStaOverLimit)";
        }

        try{
            $tSQL  = "  SELECT $tTopLimit
                            RPT.*
                            FROM(
                                SELECT
                                    ROW_NUMBER() OVER(ORDER BY TMP.FTTxnPosCode ASC, TMP.FDTxnDocDate ASC) AS rtRowID, TMP.* 
                                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                                WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName'
                                /*AND FTTxnDocType = 10*/   
                            ) AS RPT        
                        WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
                        ORDER BY RPT.FTTxnPosCode ASC, RPT.FDTxnDocDate";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRPTCRDGetDataRptTransferCardInfoCount($paFilterReport);
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
            echo $Error;
        }

    }

    //Functionality: Get Data Report รายงานการล้างมูลค่าบัตรเพื่อกลับมาใช้งานใหม่
    //Parameters:  Function Parameter
    //Creator: 21/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPTCRDGetDataRptClearCardValueForReuseCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT 
                            COUNT(FTComName) AS FTComName 
                        FROM TFCTRptCrdTmp WITH (NOLOCK)
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
                        /*AND FTTxnDocType = 10*/";
            
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];

        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality: Get Data Report รายงานข้อมูลบัตรที่ไม่ใช้งาน
    //Parameters:  Function Parameter
    //Creator: 21/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPTCRDGetDataRptCardNoActive($paFilterReport, $pnStaOverLimit){
        $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        if(!empty($pnStaOverLimit)){
            $tTopLimit  = "TOP($pnStaOverLimit)";
        }
        
        try{
            $tSQL  = "  SELECT $tTopLimit
                            RPT.*
                            FROM(
                                SELECT
                                    ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FTCtyCode ASC, TMP.FDCrdStartDate ASC) AS rtRowID, TMP.* 
                                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                                WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName' 
                            ) AS RPT        
                        WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
                        ORDER BY RPT.FTCrdCode ASC, RPT.FTCtyCode ASC, RPT.FDCrdStartDate ASC";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRPTCRDGetDataRptCardNoActiveCount($paFilterReport);
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
            echo $Error;
        }
    }
    
    //Functionality: Get Data Report รายงานข้อมูลบัตรที่ไม่ใช้งาน
    //Parameters:  Function Parameter
    //Creator: 21/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPTCRDGetDataRptCardNoActiveCount($paFilterReport){

        try{
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT 
                            COUNT(FTComName) AS FTComName 
                        FROM TFCTRptCrdTmp WITH (NOLOCK)
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];

        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality: Get Data Report รายงานจำนวนรอบการใช้บัตร
    //Parameters:  Function Parameter
    //Creator: 21/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPTCRDGetDataRptCardTimesUsed($paFilterReport, $pnStaOverLimit){
        $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        try{
            
            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }
       
            $tSQL  = "  SELECT $tTopLimit
                            RPT.*
                            FROM(
                                SELECT
                                    ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FTCtyCode ASC) AS rtRowID, TMP.* 
                                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                                WHERE 1=1 AND TMP.FTComName = '$tComName' AND TMP.FTRptName = '$tRptName' 
                            ) AS RPT        
                        WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
                        ORDER BY RPT.FTCrdCode ASC, RPT.FTCtyCode ASC";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRPTCRDGetDataRptCardNoActiveCount($paFilterReport);
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
            echo $Error;
        }

    }

    //Functionality: Get Data Report รายงานจำนวนรอบการใช้บัตร
    //Parameters:  Function Parameter
    //Creator: 21/11/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    public function FSaMRPTCRDGetDataRptCardTimesUsedCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   SELECT 
                            COUNT(FTComName) AS FTComName 
                        FROM TFCTRptCrdTmp WITH (NOLOCK)
                        WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];

        }catch(Exception $Error){
            echo $Error;
        }

    }
        
    //รายงานบัตรคงเหลือ[8] : data source 
    public function FSaMRPTCRDGetDataRptCardBalance($paFilterReport, $pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit = "TOP($pnStaOverLimit)";
            }

            $FNLngID = $paFilterReport['FNLngID'];
            $tFTComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tStaActiveText = 'FTCrdStaActiveTH ';
            if($FNLngID == 1){$tStaActiveText = 'FTCrdStaActiveTH ';}
            if($FNLngID == 2){$tStaActiveText = 'FTCrdStaActiveEN ';}
            
            $tSQL = "
                SELECT $tTopLimit
                    RPT.* 
                FROM( 
                    SELECT 
                        ROW_NUMBER() OVER(ORDER BY TMP.FTCrdStaActive ASC) AS rtRowID,
                        $tStaActiveText AS FTCrdStaActiveText,
                        FNCrdBalanceQty, /*จำนวนคงเหลือปัจจุบัน*/
                        FCCrdBalanceValue, /*มูลค่าคงเหลือปัจจุบัน*/
                        FNCrdInOutAdjQty, /*จำนวน ยอดเข้า/ออก/ปรับปรุง*/
                        FCCrdInOutAdjValue, /*มูลคา ยอดเข้า/ออก/ปรับปรุง*/
                        FNCrdSaleQty, /*จำนวนขาย*/
                        FCCrdSaleValue, /*มูลค่าขาย*/
                        FNCrdRetQty, /*จำนวนคืน*/
                        FNCrdRetValue, /*มูลค่าคืน*/
                        FNCrdSpendQty, /*จำนวนการใช้จ่าย*/
                        FCCrdSpendValue, /*มูลค่าการใช้จ่าย*/ 
                        FNCrdExpireQty, /*จำนวนหมดอายุ*/
                        FCCrdExpireValue /*มูลค่าหมดอายุ*/
                    FROM TFCTRptBalCrdTemp TMP WITH (NOLOCK)
                    WHERE TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName'
                ) AS RPT
            ";
            
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptCardBalanceCount($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }
    }

    //รายงานบัตรคงเหลือ[8] : count
    public function FSaMRPTCRDGetDataRptCardBalanceCount($paFilterReport){
        try{
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL = "   
                SELECT
                    ROW_NUMBER() OVER(ORDER BY TMP.FTComName ASC)  AS rtRowID 
                FROM TFCTRptBalCrdTemp TMP WITH (NOLOCK)
                WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
            ";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->num_rows();
        }catch(Exception $Error){
            echo $Error;
        }
    }
   
    //รายงานบัตรคงเหลือ[8] : ผลรวม
    public function FSaMRPTCRDGetDataRptCardBalanceSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   
            SELECT 
                SUM(ISNULL(FNCrdBalanceQty,0)) AS FNCrdBalanceQtySum, /*จำนวนคงเหลือปัจจุบัน*/
                SUM(ISNULL(FCCrdBalanceValue,0)) AS FCCrdBalanceValueSum, /*มูลค่าคงเหลือปัจจุบัน*/
                SUM(ISNULL(FNCrdInOutAdjQty,0)) AS FNCrdInOutAdjQtySum, /*จำนวน ยอดเข้า/ออก/ปรับปรุง*/
                SUM(ISNULL(FCCrdInOutAdjValue,0)) AS FCCrdInOutAdjValueSum, /*มูลคา ยอดเข้า/ออก/ปรับปรุง*/
                SUM(ISNULL(FNCrdSaleQty,0)) AS FNCrdSaleQtySum, /*จำนวนขาย*/
                SUM(ISNULL(FCCrdSaleValue,0)) AS FCCrdSaleValueSum, /*มูลค่าขาย*/
                SUM(ISNULL(FNCrdRetQty,0)) AS FNCrdRetQtySum, /*จำนวนคืน*/
                SUM(ISNULL(FNCrdRetValue,0)) AS FNCrdRetValueSum, /*มูลค่าคืน*/
                SUM(ISNULL(FNCrdSpendQty,0)) AS FNCrdSpendQtySum, /*จำนวนการใช้จ่าย*/
                SUM(ISNULL(FCCrdSpendValue,0)) AS FCCrdSpendValueSum, /*มูลค่าการใช้จ่าย*/ 
                SUM(ISNULL(FNCrdExpireQty,0)) AS FNCrdExpireQtySum, /*จำนวนหมดอายุ*/
                SUM(ISNULL(FCCrdExpireValue,0)) AS FCCrdExpireValueSum /*มูลค่าหมดอายุ*/
            FROM TFCTRptBalCrdTemp WITH (NOLOCK)   
            WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //รายงานยอดสะสมบัตรหมดอายุ[9] : data source 
    public function FSaMRPTCRDGetDataRptCollectExpireCard($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $FNLngID        = $paFilterReport['FNLngID'];
            $tFTComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tSQL = "SELECT $tTopLimit
                        RPT.* 
                    FROM( 
                        SELECT 
                        ROW_NUMBER() OVER(ORDER BY CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121) ASC)   AS rtRowID,
                        CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121)	AS rtCrdExpireDate,
                        COUNT(TMP.FTCrdCode)                            AS rtCrdCodeExpQty,
                        SUM(ISNULL(TMP.FCCrdValue,0))                   AS rtCrdValue
                        FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                        WHERE 1=1 AND TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName' AND TMP.FTCrdStaActive != '3' ";
            $tSQL  .= " GROUP BY CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121)  ) AS RPT ";
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptCollectExpireCardCount($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }
    }

    //รายงานยอดสะสมบัตรหมดอายุ[9] : count 
    public function FSaMRPTCRDGetDataRptCollectExpireCardCount($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(A.FTCrdCode) AS FTComName  FROM (

                                    SELECT COUNT(FTCrdCode) AS FTCrdCode  
                                    FROM TFCTRptCrdTmp WITH (NOLOCK)
                                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName' AND FTCrdStaActive != '3' 
                                    GROUP BY CONVERT(VARCHAR(10),FDCrdExpireDate,121)
                                
                               ) A ";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานยอดสะสมบัตรหมดอายุ[9] : ผลรวม 
    public function FSaMRPTCRDGetDataRptCollectExpireCardSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        COUNT(FTCrdCode) AS FTCrdCode,
                        SUM(FCCrdValue) AS FCCrdValue 
                    FROM TFCTRptCrdTmp WITH (NOLOCK)   
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
    
    //รายงานรายการต้นงวดบัตรและเงินสด[10] : data source
    public function FSaMRPTCRDGetDataRptCardPrinciple($paFilterReport,$pnStaOverLimit){
        try{

            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $FNLngID        = $paFilterReport['FNLngID'];
            $tFTComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tSQL = "SELECT $tTopLimit
                        RPT.* 
                    FROM( 
                        SELECT 
                        ROW_NUMBER() OVER(ORDER BY TMP.FTTxnYear ASC)  AS rtRowID,
                        TMP.FTTxnYear, 
                        TMP.FTCtyName, 
                        TMP.FNTxnCountCard, 
                        TMP.FCCrdValue 
                        FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                        WHERE 1=1 AND TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName'
                        ) AS RPT ";
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= " ORDER BY RPT.FTTxnYear ASC";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptCardPrincipleCount($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }
    }

    //รายงานรายการต้นงวดบัตรและเงินสด[10] : count
    public function FSaMRPTCRDGetDataRptCardPrincipleCount($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานรายการต้นงวดบัตรและเงินสด[10] : ผลรวม
    public function FSaMRPTCRDGetDataRptCardPrincipleSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(FNTxnCountCard) AS FNTxnCountCard,
                        SUM(FCCrdValue ) AS FCCrdValue 
                    FROM TFCTRptCrdTmp WITH (NOLOCK)   
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //รายงานข้อมูลบัตร[11] : data source
    public function FSaMRPTCRDGetDataRptCardDetail($paFilterReport,$pnStaOverLimit){
        try{

            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $FNLngID        = $paFilterReport['FNLngID'];
            $tFTComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tSQL = "SELECT $tTopLimit
                        RPT.* 
                    FROM( 
                        SELECT 
                        ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FDTxnDocDate ASC)  AS rtRowID,
                        TMP.FTCrdCode,
                        TMP.FTCrdName,
                        TMP.FTCrdHolderID,
                        TMP.FTCtyName,
                        TMP.FCCrdValue,
                        TMP.FTCrdStaType,
                        TMP.FTCrdStaActive,
                        CASE WHEN CONVERT(VARCHAR(10),FDCrdExpireDate,121) < CONVERT(VARCHAR(10),GETDATE(),121) THEN 1 ELSE 2 END AS FNCrdStaExpr,
                        CONVERT(VARCHAR(10),TMP.FDCrdStartDate,121) AS FDCrdStartDate,
                        CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121) AS FDCrdExpireDate,
                        ISNULL(TMP.FNLngID,1)  AS FNLngID
                        FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                            WHERE 1=1 AND TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName'
                        ) AS RPT ";
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= " ORDER BY RPT.FTCrdCode ASC";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptCardDetailCount($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }
    }

    //รายงานข้อมูลบัตร[11] : count
    public function FSaMRPTCRDGetDataRptCardDetailCount($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานข้อมูลบัตร[11] : ผลรวม
    public function FSaMRPTCRDGetDataRptCardDetailSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(FCCrdValue) AS FCCrdValue
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //รายงานตรวจสอบการเติมเงิน[12] : data source
    public function FSaMRPTCRDGetDataRptCheckPrepaid($paFilterReport,$pnStaOverLimit){
        try{

            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $FNLngID        = $paFilterReport['FNLngID'];
            $tFTComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
           
            $tSQL = "SELECT $tTopLimit
                        RPT.* 
                    FROM( 
                        SELECT 
                        ROW_NUMBER() OVER(ORDER BY TMP.FTTxnPosCode ASC, TMP.FDTxnDocDate ASC)  AS rtRowID,
                        TMP.FTTxnPosCode                                                        AS FTTxnPosCode,
                        TMP.FDTxnDocDate                                                        AS FDTxnDocDate,
                        TMP.FTTxnDocType                                                        AS FTTxnDocType,
                        TMP.FTCrdCode                                                           AS FTCrdCode,
                        TMP.FTCrdName                                                           AS FTCrdName,
                        TMP.FTUsrName                                                           AS FTUsrName,
                        TMP.FCTxnValue                                                          AS FCTxnValue,
                        TMP.FTCdtRmk                                                            AS FTCdtRmk,
                        TMP.FNLngID
                        FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                            WHERE 1=1 AND TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName'
                        ) AS RPT ";
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= " ORDER BY RPT.FTTxnPosCode, RPT.FDTxnDocDate ASC";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptCheckPrepaidCount($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }

    }

    //รายงานตรวจสอบการเติมเงิน[12] : count
    public function FSaMRPTCRDGetDataRptCheckPrepaidCount($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานตรวจสอบการเติมเงิน[12] : ผลรวม
    public function FSaMRPTCRDGetDataRptCheckPrepaidSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(FCTxnCrdValue) AS FCTxnCrdValue,
                        SUM(FCTxnValue) AS FCTxnValue,
                        SUM(FCTxnValAftTrans) AS FCTxnValAftTrans
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //รายงานตรวจสอบข้อมูลการใช้บัตร[13] : data source
    public function FSaMRPTCRDGetDataRptCheckCardUseInfo($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $FNLngID        = $paFilterReport['FNLngID'];
            $tFTComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tSQL = "SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                            ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FDTxnDocDate ASC) AS rtRowID,
                            TMP.FTCrdCode                                                       AS rtCrdCode,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTCtyName)                             AS rtCtyName,
                            CONCAT(TMP.FTCrdCode,';',CASE WHEN(TMP.FTCrdHolderID IS NULL OR TMP.FTCrdHolderID = '') THEN 'N/A' ELSE TMP.FTCrdHolderID END) AS rtCrdHolderID,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTCrdName)                             AS rtCrdName,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTCrdStaActive)  	                    AS rtCrdStaActive,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTDptName)                             AS rtDptName,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTDocCreateBy)                         AS rtTxnDocCreateBy,
                            CONCAT(TMP.FTCrdCode,';',CASE WHEN(TMP.FTTxnPosCode IS NULL OR TMP.FTTxnPosCode = '') THEN TMP.FTPosType ELSE TMP.FTTxnPosCode END) AS rtTxnPosCode,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocNoRef)                         AS rtTxnDocNoRef,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocTypeName)	                    AS rtTxnDocTypeName,
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
                            
                            CONCAT(TMP.FTCrdCode,';',TMP.FCTxnCrdAftTrans)	            AS rtCrdAftTrans,
                            CONCAT(TMP.FTCrdCode,';',TMP.FCCrdBalance)		            AS rtCrdBalance,
                            
                            TMP.FNLngID
                            FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                            WHERE 1=1 AND TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName'
                            ) AS RPT ";
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= " ORDER BY RPT.rtCrdCode, RPT.rtTxnDocDate ASC";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptCheckCardUseInfoCount($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }
    }

    //รายงานตรวจสอบข้อมูลการใช้บัตร[13] : count
    public function FSaMRPTCRDGetDataRptCheckCardUseInfoCount($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานตรวจสอบข้อมูลการใช้บัตร[13] : ผลรวม
    public function FSaMRPTCRDGetDataRptCheckCardUseInfoSum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM( 
                            CASE 
                                WHEN FTTxnDocType = 1 THEN FCTxnValue 
                                WHEN FTTxnDocType = 2 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 3 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 4 THEN FCTxnValue 
                                WHEN FTTxnDocType = 5 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 8 THEN (FCTxnValue * -1) 
                                WHEN FTTxnDocType = 9 THEN FCTxnValue 
                                WHEN FTTxnDocType = 10 THEN (FCTxnValue * -1) 
                                ELSE '0' 
                            END
                        ) AS  FCTxnValueSum
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //รายงานการเติมเงิน[14] : data source
    public function FSaMRPTCRDGetDataRptTopUp($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $FNLngID        = $paFilterReport['FNLngID'];
            $tFTComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tSQL = "SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                            ROW_NUMBER() OVER(ORDER BY TMP.FTTxnPosCode ASC, TMP.FDTxnDocDate ASC) AS rtRowID,
                            TMP.FTTxnPosCode,
                            TMP.FDTxnDocDate,
                            TMP.FTTxnDocType,
                            TMP.FTTxnDocNoRef,
                            TMP.FTCrdCode,
                            TMP.FDCrdExpireDate,
                            TMP.FCTxnValue,
                            TMP.FTCdtRmk,
                            TMP.FTCrdName,
                            TMP.FTCrdStaActive,
                            /*TMP.FTCrdHolderID,*/
                            TMP.FTUsrName,
                            TMP.FCTxnCrdValue,
                            TMP.FCTxnValAftTrans,
                            TMP.FNLngID,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTCrdHolderID) AS FTCrdHolderID,
                            CONCAT(TMP.FTCrdCode,';',TMP.FTCtyName) AS FTCtyName, 
                            CONCAT(TMP.FTCrdCode,';',TMP.FTDptName) AS FTDptName
                        FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                        WHERE 1=1 AND TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName'
                    ) AS RPT ";
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= " ORDER BY RPT.FTTxnPosCode ASC, RPT.FDTxnDocDate ASC ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptTopUpCount($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }
    }

    //รายงานการเติมเงิน[14] : count
    public function FSaMRPTCRDGetDataRptTopUpCount($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานการเติมเงิน[14] : ผลรวม
    public function FSaMRPTCRDGetDataRptTopUpSum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];
        
        $tSQL = "   SELECT 
                        SUM(FCTxnCrdValue) AS FCTxnCrdValue,
                        SUM(FCTxnValue) AS FCTxnValue,
                        SUM(FCTxnValAftTrans) AS FCTxnValAftTrans
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    //เอกสารรายงานการใช้ข้อมูลบัตร (ระเอียด)[15] : data source
    public function FSaMRPTCRDGetDataRptUseCard2($paFilterReport,$pnStaOverLimit){
        try{
            $aRowLen = FCNaHCallLenData($paFilterReport['nRow'],$paFilterReport['nPage']);

            if(!empty($pnStaOverLimit)){
                $tTopLimit  = "TOP($pnStaOverLimit)";
            }

            $FNLngID        = $paFilterReport['FNLngID'];
            $tFTComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tSQL = "SELECT $tTopLimit
                            RPT.* 
                        FROM( 
                            SELECT 
                            ROW_NUMBER() OVER(ORDER BY TMP.FTBchName ASC, TMP.FTCrdCode ASC , TMP.FDTxnDocDate ASC) AS rtRowID,
                            TMP.FTBchCode                                                               AS rtBchCode,
                            CONCAT(TMP.FTBchCode,';',TMP.FTBchName)                                     AS rtBchName,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode)                                     AS rtCrdCode,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTCrdName)                   AS rtCrdName,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTCtyName)                   AS rtCtyName,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',CASE WHEN(TMP.FTCrdHolderID IS NULL OR TMP.FTCrdHolderID = '') THEN 'N/A' ELSE TMP.FTCrdHolderID END)  AS rtCrdHolderID,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTDptName)                   AS rtDptName,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTCrdStaActive)              AS rtCrdStaActive,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTTxnDocTypeName)            AS rtTxnDocTypeName,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FCTxnValue)                  AS rcTxnValue,
                            CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FCCrdBalance)                AS rcCrdBalance,
                            TMP.FDTxnDocDate                                                            AS rdTxnDocDate,
                            TMP.FNLngID
                        FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                        WHERE 1=1 AND TMP.FTComName = '$tFTComName' AND TMP.FTRptName = '$tRptName'
                    ) AS RPT ";
            $tSQL .= " WHERE 1=1 ";
            $tSQL .= " AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
            $tSQL .= " ORDER BY RPT.rtBchName ASC, RPT.rtCrdCode ASC , RPT.rdTxnDocDate ASC";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->result_array();
                $nFoundRow   = $this->FSaMRPTCRDGetDataRptUseCard2Count($paFilterReport);
                $nPageAll       = ceil($nFoundRow / $paFilterReport['nRow']);
                $aReturnData    = array(
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
            echo $Error;
        }
    }

    //เอกสารรายงานการใช้ข้อมูลบัตร (ระเอียด)[15] : count
    public function FSaMRPTCRDGetDataRptUseCard2Count($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

}












