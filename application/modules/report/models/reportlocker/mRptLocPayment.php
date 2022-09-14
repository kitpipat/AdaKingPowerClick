<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptLocPayment extends CI_Model {

    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 04/04/2019 Wasin(Yoshi)
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $tCallStore = "{ CALL SP_RPTxRentalPayment3001005(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'          => $paDataFilter['nLangID'],
            'pnComName'        => $paDataFilter['tCompName'],
            'ptRptCode'        => $paDataFilter['tRptCode'],
            'ptUsrSession'     => $paDataFilter['tUserSession'],
            'ptBchF'           => $paDataFilter['tBchCodeFrom'],
            'ptBchT'           => $paDataFilter['tBchCodeTo'],
            'ptShpF'           => $paDataFilter['tShopCodeFrom'],
            'ptShpT'           => $paDataFilter['tShopCodeTo'],
            'ptPosCodeF'       => $paDataFilter['tPosCodeFrom'],
            'ptPosCodeT'       => $paDataFilter['tPosCodeTo'],
            'ptReciveTypeF'    => $paDataFilter['tRcvCodeFrom'],
            'ptReciveTypeT'    => $paDataFilter['tRcvCodeTo'],
            'ptDocDateF'       => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'       => $paDataFilter['tDocDateTo'],
            'FNResult'         => 0,
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

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 04/04/2019 Wasin(Yoshi)
    // Last Modified : 11/04/2019 Wasin(Yoshi)
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere,$paDataFilter){
        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);


        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSession'];

        // $tCompName  = 'ADA-DEV';
        // $tRptCode   = '003001005';
        //TRPTSalRCTmp ตารางเก่า
       $tSQL = "SELECT
                    FTRcvCode,
                    FTRcvName,
                    SUM(FCXrcNet) AS NET
                FROM TRPTRTSalRCTmp
                WHERE FTComName = '".$tCompName."'
                 AND FTRptCode = '".$tRptCode."' 
                 AND FTUsrSession = '".$tSessionID."' ";
 
        $tSQL .= " GROUP BY FTRcvCode,FTRcvName ORDER BY FTRcvCode";
               
        $oQuery = $this->db->query($tSQL);   
        if($oQuery->num_rows() > 0){

            $aDataRpt       = $oQuery->result_array();
            // echo $nAllNet;exit();
            $oCountRowRpt   = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow      = $oCountRowRpt;
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

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Wasin(Yoshi)
    // Last Modified: 14/08/2019 Saharat(Golf)
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMCountDataReportAll($paDataWhere){
        $tSessionID = $paDataWhere['tUserSession'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
     
        $tSQL       = " SELECT *
                        FROM TRPTRTSalRCTmp 
                        WHERE 1 = 1
                        AND FTUsrSession = '$tSessionID' 
                        AND FTComName = '$tCompName' 
                        AND FTRptCode = '$tRptCode' ";
        $oQuery     = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    // Functionality: Sum All Value Data Report All
    // Parameters: Function Parameter
    // Creator: 24/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMSumDataReportAll($paDataWhere){
        $tUserCode  = $paDataWhere['tSessionID'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
    }

    public function FSaMCMPAddress($paData){
       
        try{
            $tRefCode   = $paData['tAddRef']; 
            $nLngID     = $paData['nLangID'];
            $tSQL = "SELECT
                        ADDL.FTAddRefCode       AS rtAddRefCode,
                        ADDL.FTAddTaxNo         AS rtAddTaxNo,
                        ADDL.FTAddVersion       AS rtAddVersion,
                        ADDL.FTAddV1No          AS rtAddV1No,
                        ADDL.FTAddV1Soi         AS rtAddV1Soi,
                        ADDL.FTAddV1Village     AS rtAddV1Village,
                        ADDL.FTAddV1Road        AS rtAddV1Road,
                        ADDL.FTAddV1SubDist     AS rtAddV1SubDist,
                        SUBDSTL.FTSudName       AS rtAddV1SudName,
                        ADDL.FTAddV1DstCode     AS rtAddV1DstCode,
                        DSTL.FTDstName          AS rtAddV1DstName,
                        ADDL.FTAddV1PvnCode     AS rtAddV1PvnCode,
                        PVNL.FTPvnName          AS rtAddV1PvnName,
                        ADDL.FTAddCountry       AS rtAddV1CntName,
                        ADDL.FTAddV1PostCode    AS rtAddV1PostCode,
                        ADDL.FTAddV2Desc1       AS rtAddV2Desc1,
                        ADDL.FTAddV2Desc2       AS rtAddV2Desc2,
                        ADDL.FTAddWebsite       AS rtAddWebsite,
                        ADDL.FTAddLongitude     AS rtAddLongitude,
                        ADDL.FTAddLatitude      AS rtAddLatitude

                    FROM [TCNMAddress_L] ADDL
                    LEFT JOIN [TCNMSubDistrict_L] SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
                    LEFT JOIN [TCNMDistrict_L] DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                    LEFT JOIN [TCNMProvince_L] PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                    WHERE 1=1  AND ADDL.FNLngID = $nLngID AND ADDL.FTAddRefCode = '$tRefCode' 
                    "; 
                    // echo $tSQL; exit;
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $oList = $oQuery->result();
                $aResult = array(
                    'raItems'   => $oList[0],
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //No Data
                $aResult = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found'
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        }
    }
     // Functionality: To Get data SumFootReport
    // Parameters: Function Parameter
    // Creator: 13/08/2019 Sarun
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMGetDataSumFootReport($paDataWhere,$paDataFilter){

        $aRowLen        = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);         
        $tSessionID     = $paDataWhere['tUserSession'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        $tSQL = "  SELECT
                        ISNULL(SUM(FCXrcNet),0)   AS FCSumFooter
                    FROM TRPTRTSalRCTmp
                    WHERE 1 = 1 
                    AND FTUsrSession = '$tSessionID' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return array();
        }
    }
}
