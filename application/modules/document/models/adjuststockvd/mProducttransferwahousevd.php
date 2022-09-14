<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mProducttransferwahousevd extends CI_Model {

    //Functionality : Data List Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTFWList($paData){
        $aDataUserInfo  = $this->session->userdata("tSesUsrInfo");
        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID         = $paData['FNLngID'];
        $oAdvanceSearch = $paData['oAdvanceSearch'];
        @$tSearchList   = $oAdvanceSearch['tSearchAll'];

        // Search All On Input
        $tWhereSearchAll    = "";
        if(@$tSearchList != ''){
            $tWhereSearchAll    = " AND ((TFW.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TFW.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }

        // Check User Level Branch HQ OR Bch Or Shop
        $tUserLevel = $this->session->userdata("tSesUsrLevel");
        $tWhereBch  = "";
        $tWhereShp  = "";
        if(isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH"){
            // Check User Level BCH
            $tWhereBch  =   " AND TFW.FTBchCode = '".$aDataUserInfo['FTBchCode']."'";
        }
        if(isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "SHP"){
            // Check User Level SHP
            $tWhereShp  =   " AND TFW.FTAjhShopTo = '".$aDataUserInfo['FTShpCode']."'";
        }
        
        // Check Branch From - To (จากสาขา - ถึงสาขา)
        $tSearchBchCodeFrom = $oAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $oAdvanceSearch['tSearchBchCodeTo'];
        $tWhereBchFrmTo     = "";
        if((isset($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) && (isset($tSearchBchCodeTo) && !empty($tSearchBchCodeTo))){
            $tWhereBchFrmTo = " AND ((TFW.FTBchCode BETWEEN '$tSearchBchCodeFrom' AND '$tSearchBchCodeTo') OR (TFW.FTBchCode BETWEEN '$tSearchBchCodeTo' AND '$tSearchBchCodeFrom'))";
        }

        // Check Date From - To (จากวันที่ - ถึงวันที่)
        $tSearchDocDateFrom = $oAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $oAdvanceSearch['tSearchDocDateTo'];
        $tWhereDateFrmTo     = "";
        if((isset($tSearchDocDateFrom) && !empty($tSearchDocDateFrom)) && (isset($tSearchDocDateTo) && !empty($tSearchDocDateTo))){
            $tWhereDateFrmTo    = " AND ((TFW.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TFW.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // Check Status Doccument สถานะเอกสาร
        $tSearchStaDoc  = $oAdvanceSearch['tSearchStaDoc'];
        $tWhereStaDoc   = "";
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            if($tSearchStaDoc == 2){
                $tWhereStaDoc   = " AND TFW.FTAjhStaDoc = '$tSearchStaDoc' OR TFW.FTAjhStaDoc = ''";
            }else{
                $tWhereStaDoc   = " AND TFW.FTAjhStaDoc = '$tSearchStaDoc'";
            }
        }

        // Check Status Appove สถานะอนุมัติ
        $tSearchStaApprove  = $oAdvanceSearch['tSearchStaApprove'];
        $tWhereStaApv       = "";
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tWhereStaApv   = " AND TFW.FTAjhStaApv = '$tSearchStaApprove' OR TFW.FTAjhStaApv = '' ";
            }else{
                $tWhereStaApv   = " AND TFW.FTAjhStaApv = '$tSearchStaApprove'";
            }
        } 

        // Check Status Appove สถานะประมวลผล
        $tSearchStaPrcStk   = $oAdvanceSearch['tSearchStaPrcStk'];
        $tWhereStaPrcStk    = "";
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tWhereStaPrcStk    = " AND TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk' OR TFW.FTAjhStaPrcStk = '' ";
            }else{
                $tWhereStaPrcStk    = " AND TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $tSQL   = " SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXthDocNo DESC) AS FNRowID,* FROM(
                            SELECT HD.* FROM (
                                SELECT  DISTINCT 
                                    TFW.FTBchCode,
                                    BCHL.FTBchName,
                                    TFW.FTAjhDocNo  AS FTXthDocNo,
                                    CONVERT(CHAR(10),TFW.FDAjhDocDate,103)  AS FDXthDocDate,
                                    convert(CHAR(5), TFW.FDAjhDocDate, 108) AS FTXthDocTime,
                                    TFW.FTAjhStaDoc     AS FTXthStaDoc,
                                    TFW.FTAjhStaApv     AS FTXthStaApv,
                                    TFW.FTAjhStaPrcStk  AS FTXthStaPrcStk,
                                    TFW.FTCreateBy,
                                    USRL.FTUsrName      AS FTCreateByName,
                                    TFW.FTAjhApvCode    AS FTXthApvCode,
                                    USRLAPV.FTUsrName   AS FTXthApvName
                                FROM TCNTPdtAdjStkHD  TFW       WITH (NOLOCK)
                                LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON TFW.FTBchCode      = BCHL.FTBchCode        AND BCHL.FNLngID    = $nLngID 
                                LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON TFW.FTCreateBy     = USRL.FTUsrCode        AND USRL.FNLngID    = $nLngID 
                                LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON TFW.FTAjhApvCode   = USRLAPV.FTUsrCode     AND USRLAPV.FNLngID = $nLngID
                                WHERE 1=1 AND TFW.FTAjhDocType = '3'
                                ".$tWhereBch."
                                ".$tWhereShp."
                                ".$tWhereBchFrmTo."
                                ".$tWhereDateFrmTo."
                                ".$tWhereStaDoc."
                                ".$tWhereStaApv."
                                ".$tWhereStaPrcStk."
                            ) HD
                            INNER JOIN (SELECT DISTINCT FTAjhDocNo  FROM TCNTPdtAdjStkDT WHERE FNAjdLayRow <> 0 AND FNAjdLayCol <> 0) DT
                            ON HD.FTXthDocNo = DT.FTAjhDocNo
                        ) Base ) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSnMTFWGetPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Function Get Count From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTFWGetCountDTTemp($paDataWhere){


            $tSQL = "SELECT 
                        COUNT(DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1
                    ";

            $tXthBchCode    = $paDataWhere['FTXthBchCode'];
            $tXthDocNo      = $paDataWhere['FTXthDocNo'];
            $tXthDocKey     = $paDataWhere['FTXthDocKey'];
            $tSesSessionID  = $this->session->userdata('tSesSessionID');    

            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo' ";

            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey' ";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID' ";

            $tSQL .= " AND DOCTMP.FTBchCode = '$tXthBchCode' ";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result_array();
                $aResult = $oDetail[0]['counts'];
            }else{
                $aResult = 0;
            }

        return $aResult;

    }

    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    // public function FSaMTFWSumDTTemp($paDataWhere){

    //     $tXthDocNo      = $paDataWhere['FTXthDocNo'];
    //     $tXthDocKey     = $paDataWhere['FTXthDocKey'];
    //     $tSesSessionID  = $this->session->userdata('tSesSessionID');   

    //     $tSQL = "SELECT SUM(FCXtdAmt) AS FCXtdAmt
    //              FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
    //              WHERE 1 = 1
    //             ";
             
    //         $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";

    //         $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

    //         $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
            
    //         $oQuery = $this->db->query($tSQL);
            
    //         if ($oQuery->num_rows() > 0){
    //             $oResult = $oQuery->result_array();
    //         }else{
    //             $oResult = '';
    //         }


    //     return $oResult;

    // }


    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 04/04/2019 Krit(Copter)
    //Return : array
    //Return Type : array
    public function FSaMTFWGetVatDTTemp($paDataWhere){

        $tXthDocNo      = $paDataWhere['FTXthDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];

        $tSQL = "SELECT DISTINCT FCXtdVatRate, 
                                 SUM(FCXtdVat) AS FCXtdVat,
                                 SUM(FCXtdVatable) AS FCXtdVatable
                FROM TCNTDocDTTmp WITH (NOLOCK)
                WHERE 1 = 1";

            $tSesSessionID = $this->session->userdata('tSesSessionID');    
            $tSQL .= " AND FTSessionID = '$tSesSessionID'";

            $tSQL .= " AND FTXthDocNo = '$tXthDocNo'";

            $tSQL .= " AND FTXthDocKey = '$tXthDocKey'";

            $tSQL .= " GROUP BY FCXtdVatRate ORDER BY FCXtdVatRate ASC";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $oResult = $oQuery->result_array();
            }else{
                $oResult = '';
            }

        return $oResult;

    }


    //Functionality : Function Add DT To Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMTFWInsertTmpToDT($paDataWhere){
        $tSQL = "SELECT TCNTDocDTTmp.FTBchCode,
                        TCNTDocDTTmp.FTXthDocNo,
                        TCNTDocDTTmp.FNXtdSeqNo,
                        TCNTDocDTTmp.FNLayRowForADJSTKVD,
                        TCNTDocDTTmp.FNLayColForADJSTKVD,
                        TCNTDocDTTmp.FTPdtCode,
                        TCNMPdt_L.FTPdtName,
                        TCNMPdt.FTPgpChain,
                        TCNTDocDTTmp.FCUserInPutForADJSTKVD,
                        TCNTDocDTTmp.FCDateTimeInputForADJSTKVD,
                        TCNTDocDTTmp.FNCabSeqForTWXVD
                FROM TCNTDocDTTmp 
                LEFT JOIN TCNMPdt ON TCNTDocDTTmp.FTPdtCode = TCNMPdt.FTPdtCode
                LEFT JOIN TCNMPdt_L ON TCNTDocDTTmp.FTPdtCode = TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID = '".$paDataWhere["nLangID"]."'
                WHERE FTXthDocKey='".$paDataWhere["FTXthDocKey"]."'
                AND FTXthDocNo='".$paDataWhere["FTXthDocNo"]."'
                AND FTSessionID='".$this->session->userdata('tSesSessionID')."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oResult = $oQuery->result_array();
            $tSQL = "DELETE FROM TCNTPdtAdjStkDT 
                WHERE FTBchCode = '".$paDataWhere["FTBchCode"]."'
                AND FTAjhDocNo =  '".$paDataWhere["FTXthDocNo"]."'";
            $this->db->query($tSQL); 
            for($nI=0;$nI<FCNnHSizeOf($oResult);$nI++){
                
                if($oResult[$nI]["FCDateTimeInputForADJSTKVD"]!=""){
                    $tDate = $oResult[$nI]["FCDateTimeInputForADJSTKVD"];
                }else{
                    $tDate = date("Y-m-d H:i:s");
                }
                $tSQL = "INSERT INTO TCNTPdtAdjStkDT(
                            FTBchCode,
                            FTAjhDocNo,
                            FNAjdSeqNo,
                            FNAjdLayRow,
                            FNAjdLayCol,
                            FTPdtCode,
                            FTPdtName,
                            FCPdtUnitFact,
                            FTPgpChain,
                            FDAjdDateTime,
                            FCAjdUnitQty,
                            FCAjdQtyAll,
                            FDLastUpdOn,
                            FTLastUpdBy,
                            FDCreateOn,
                            FTCreateBy,
                            FNCabSeq
                        ) 
                        VALUES(
                            '".$oResult[$nI]["FTBchCode"]."',
                            '".$oResult[$nI]["FTXthDocNo"]."',
                            ".$oResult[$nI]["FNXtdSeqNo"].",
                            ".$oResult[$nI]["FNLayRowForADJSTKVD"].",
                            ".$oResult[$nI]["FNLayColForADJSTKVD"].",
                            '".$oResult[$nI]["FTPdtCode"]."',
                            '".$oResult[$nI]["FTPdtName"]."',
                            '1',
                            '".$oResult[$nI]["FTPgpChain"]."',
                            '".$tDate."',
                            '".$oResult[$nI]["FCUserInPutForADJSTKVD"]."',
                            '".($oResult[$nI]["FCUserInPutForADJSTKVD"]*1)."',
                            '".date('Y-m-d h:i:sa')."',
                            '".$this->session->userdata('tSesUsername')."',
                            '".date('Y-m-d h:i:sa')."',
                            '".$this->session->userdata('tSesUsername')."',
                            '".$oResult[$nI]["FNCabSeqForTWXVD"]."'
                        )";
                $this->db->query($tSQL);
            }
        }    
    }


    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 03/04/2019 Krit(Copter)
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTFWGetDTTempListPage($paData){

        try{
            $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM
                                    (SELECT DOCTMP.FTBchCode,
                                            DOCTMP.FTXthDocNo,
                                            ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                                            DOCTMP.FTXthDocKey,
                                            DOCTMP.FTPdtCode,
                                            DOCTMP.FTXtdPdtName,
                                            DOCTMP.FTPunCode,
                                            DOCTMP.FTPunName,
                                            DOCTMP.FCXtdFactor,
                                            DOCTMP.FTXtdBarCode,
                                            DOCTMP.FTXtdVatType,
                                            DOCTMP.FTVatCode,
                                            DOCTMP.FCXtdVatRate,
                                            DOCTMP.FCXtdQty,
                                            DOCTMP.FCXtdQtyAll,
                                            DOCTMP.FCXtdSetPrice,
                                            DOCTMP.FCXtdAmt,
                                            DOCTMP.FCXtdVat,
                                            DOCTMP.FCXtdVatable,
                                            DOCTMP.FCXtdNet,
                                            DOCTMP.FCXtdCostIn,
                                            DOCTMP.FCXtdCostEx,
                                            DOCTMP.FTXtdStaPrcStk,
                                            DOCTMP.FNXtdPdtLevel,
                                            DOCTMP.FTXtdPdtParent,
                                            DOCTMP.FCXtdQtySet,
                                            DOCTMP.FTXtdPdtStaSet,
                                            DOCTMP.FTXtdRmk,
                                            DOCTMP.FTSessionID,
                                            DOCTMP.FNCabSeqForTWXVD,

                                            DOCTMP.FDLastUpdOn,
                                            DOCTMP.FDCreateOn,
                                            DOCTMP.FTLastUpdBy,
                                            DOCTMP.FTCreateBy

                                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                        WHERE 1 = 1";

            $tXthDocNo      = $paData['FTXthDocNo'];
            $tXthDocKey     = $paData['FTXthDocKey'];
            $tSesSessionID  = $this->session->userdata('tSesSessionID');    
           
            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";
            
            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
            
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aList          = $oQuery->result_array();
                $oFoundRow      = $this->FSoMTFWGetDTTempListPageAll($paData);
                $nFoundRow      = $oFoundRow[0]->counts;
                $nPageAll       = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult        = array(
                    'raItems'           => $aList,
                    'rnAllRow'          => $nFoundRow,
                    'rnCurrentPage'     => $paData['nPage'],
                    'rnAllPage'         => $nPageAll,
                    'rtCode'            => '1',
                    'rtDesc'            => 'success',
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow' => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"=> 0,
                    'rtCode' => '800',
                    'rtDesc' => 'data not found',
                );
            }

            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : All Page Of Product Size
    //Parameters : function parameters
    //Creator :  25/02/2019 Napat(Jame)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMTFWGetDTTempListPageAll($paData){
        try{

            $tSQL = "SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                     FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                     WHERE 1 = 1";

            $tXthDocNo      = $paData['FTXthDocNo'];
            $tXthDocKey     = $paData['FTXthDocKey'];
            $tSesSessionID  = $this->session->userdata('tSesSessionID');    

            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";
            
            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function Get Data Pdt
    //Parameters : function parameters
    //Creator : 02/04/2019 Krit(Copter)
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTFWGetDataPdt($paData){

        $tPdtCode       = $paData['FTPdtCode'];
        $FTPunCode      = $paData['FTPunCode'];
        $FTBarCode      = $paData['FTBarCode'];
        $nLngID         = $paData['FNLngID'];

        $tSQL = "SELECT

                    PDT.FTPdtCode,
                    PDT.FTPdtStkCode,
                    PDT.FTPdtStkControl,
                    PDT.FTPdtGrpControl,
                    PDT.FTPdtForSystem,
                    PDT.FCPdtQtyOrdBuy,
                    PDT.FCPdtCostDef,
                    PDT.FCPdtCostOth,
                    PDT.FCPdtCostStd,
                    PDT.FCPdtMin,
                    PDT.FCPdtMax,
                    PDT.FTPdtPoint,
                    PDT.FCPdtPointTime,
                    PDT.FTPdtType,
                    PDT.FTPdtSaleType,
                    PDT.FTPdtSetOrSN,
                    PDT.FTPdtStaSetPri,
                    PDT.FTPdtStaSetShwDT,
                    PDT.FTPdtStaAlwDis,
                    PDT.FTPdtStaAlwReturn,
                    PDT.FTPdtStaVatBuy,
                    PDT.FTPdtStaVat,
                    PDT.FTPdtStaActive,
                    PDT.FTPdtStaAlwReCalOpt,
                    PDT.FTPdtStaCsm,
                    PDT.FTTcgCode,
                    PDT.FTPtyCode,
                    PDT.FTPbnCode,
                    PDT.FTPmoCode,
                    PDT.FTVatCode,
                    /*PDT.FTEvnCode,*/
                    PDT.FDPdtSaleStart,
                    PDT.FDPdtSaleStop,

                    PDTL.FTPdtName,
                    PDTL.FTPdtNameOth,
                    PDTL.FTPdtNameABB,
                    PDTL.FTPdtRmk,

                    PKS.FTPunCode,
                    PKS.FCPdtUnitFact,

                    VAT.FCVatRate,
                    
                    UNTL.FTPunName,
                    
                    BAR.FTBarCode,

                    PDTSRL.FTSrnCode,

                    PDT.FCPdtCostStd,
                    CAVG.FCPdtCostEx,
                    CAVG.FCPdtCostIn,
                    SPL.FCSplLastPrice
         
                    
                FROM TCNMPdt PDT WITH (NOLOCK)
                LEFT JOIN TCNMPdt_L PDTL WITH (NOLOCK)               ON PDT.FTPdtCode = PDTL.FTPdtCode   AND PDTL.FNLngID = '$nLngID'
                LEFT JOIN TCNMPdtPackSize  PKS  WITH (NOLOCK)        ON PDT.FTPdtCode = PKS.FTPdtCode    AND PKS.FTPunCode = '$FTPunCode'
                LEFT JOIN TCNMPdtUnit_L UNTL WITH (NOLOCK)           ON UNTL.FTPunCode = '$FTPunCode'    AND UNTL.FNLngID = '$nLngID'
                LEFT JOIN TCNMPdtBar BAR  WITH (NOLOCK)              ON PKS.FTPdtCode = BAR.FTPdtCode    AND BAR.FTPunCode = '$FTPunCode' 
                LEFT JOIN (SELECT FTVatCode,FCVatRate,FDVatStart   
                           FROM TCNMVatRate WITH (NOLOCK) WHERE GETdate()> FDVatStart) VAT
                           ON PDT.FTVatCode=VAT.FTVatCode 
                LEFT JOIN TCNTPdtSerial PDTSRL WITH (NOLOCK)         ON PDT.FTPdtCode = PDTSRL.FTPdtCode
                LEFT JOIN TCNMPdtSpl SPL WITH (NOLOCK)               ON PDT.FTPdtCode = SPL.FTPdtCode  AND BAR.FTBarCode = SPL.FTBarCode
                LEFT JOIN TCNMPdtCostAvg CAVG  WITH (NOLOCK)         ON PDT.FTPdtCode = CAVG.FTPdtCode
                WHERE 1 = 1 ";

            if($tPdtCode!= ""){
                $tSQL .= "AND PDT.FTPdtCode = '$tPdtCode'";
            }

            if($FTBarCode!= ""){
                $tSQL .= "AND BAR.FTBarCode = '$FTBarCode'";
            }

            $tSQL .= " ORDER BY FDVatStart DESC";

            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result();
                $aResult = array(
                    'raItem'   => $oDetail[0],
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;

    }


    function FSnMTFWUpdateInlineDTTemp($aDataUpd,$aDataWhere){

        try{

            $this->db->where('FTSessionID', $this->session->userdata('tSesSessionID'));
            $this->db->where('FTXthDocNo', $aDataWhere['FTXthDocNo']);
            $this->db->where('FNXtdSeqNo', $aDataWhere['FNXtdSeqNo']);
            $this->db->where('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->update('TCNTDocDTTmp',$aDataUpd);

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }


    //Functionality : Function Add DT To Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMTFWInsertPDTToTemp($paData,$paDataWhere){

        if($paDataWhere['nTFWOptionAddPdt']==1){
            // นำสินค้าเพิ่มจำนวนในแถวแรก
            $tSQL = "SELECT FNXtdSeqNo,FCXtdQty FROM TCNTDocDTTmp WITH (NOLOCK)
                     WHERE FTBchCode = '".$paDataWhere['FTBchCode']."' 
                     AND FTXthDocNo = '".$paDataWhere['FTXthDocNo']."'
                     AND FTXthDocKey = '".$paDataWhere['FTXthDocKey']."'
                     AND FTSessionID = '".$paDataWhere['FTSessionID']."'
                     AND FTPdtCode = '".$paData["raItem"]["FTPdtCode"]."' 
                     AND FTXtdBarCode = '".$paData["raItem"]["FTBarCode"]."' ORDER BY FNXtdSeqNo";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aResult = $oQuery->row_array();
                $tSQL = "UPDATE TCNTDocDTTmp SET
                        FCXtdQty = '".($aResult["FCXtdQty"]+1)."'
                        WHERE 
                        FTBchCode = '".$paDataWhere['FTBchCode']."' AND
                        FTXthDocNo  = '".$paDataWhere['FTXthDocNo']."' AND
                        FNXtdSeqNo = '".$aResult["FNXtdSeqNo"]."' AND
                        FTXthDocKey = '".$paDataWhere['FTXthDocKey']."' AND
                        FTSessionID = '".$paDataWhere['FTSessionID']."' AND
                        FTPdtCode = '".$paData["raItem"]["FTPdtCode"]."' AND 
                        FTXtdBarCode = '".$paData["raItem"]["FTBarCode"]."'";
                $this->db->query($tSQL);
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            }else{
                $paData = $paData['raItem'];

                //เพิ่ม
                $this->db->insert('TCNTDocDTTmp',array(
                
                    'FTBchCode'         => $paDataWhere['FTBchCode'],
                    'FTXthDocNo'        => $paDataWhere['FTXthDocNo'],
                    'FNXtdSeqNo'        => $paDataWhere['nCounts'],
                    'FTXthDocKey'       => $paDataWhere['FTXthDocKey'],
                    'FTPdtCode'         => $paData['FTPdtCode'],
                    'FTXtdPdtName'      => $paData['FTPdtName'],
                    'FTPunCode'         => $paData['FTPunCode'],
                    'FTPunName'         => $paData['FTPunName'],
                    'FCXtdFactor'       => $paData['FCPdtUnitFact'],
                    'FTXtdBarCode'      => $paDataWhere['FTBarCode'],
                    'FTXtdVatType'      => $paData['FTPdtStaVatBuy'],
                    'FTVatCode'         => $paData['FTVatCode'],
                    'FCXtdVatRate'      => $paData['FCVatRate'],
                    'FCXtdQty'          => 1,  //เพิ่มสินค้าใหม่
                    'FCXtdQtyAll'       => 1*$paData['FCPdtUnitFact'], // จากสูตร qty * fector
                    'FCXtdSetPrice'     => $paDataWhere['pcPrice']*1, // pcPrice มาจากข้อมูลใน modal คือ (ต้อทุนต่อหน่วยเล็กสุด * fector) จะได้จากสูตร  pcPrice * rate  (rate ต้องนำมาจากสกุลเงินของ company)
                    'FTSessionID'       => $paDataWhere['FTSessionID'],
                    'FDLastUpdOn'       => date('Y-m-d h:i:sa'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => date('Y-m-d h:i:sa'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                ));

                $this->db->last_query();  

                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add.',
                    );
                }
            }
        }else{
            //เพิ่มแถวใหม่
            $paData = $paData['raItem'];

            //เพิ่ม
            $this->db->insert('TCNTDocDTTmp',array(
            
                'FTBchCode'         => $paDataWhere['FTBchCode'],
                'FTXthDocNo'        => $paDataWhere['FTXthDocNo'],
                'FNXtdSeqNo'        => $paDataWhere['nCounts'],
                'FTXthDocKey'       => $paDataWhere['FTXthDocKey'],
                'FTPdtCode'         => $paData['FTPdtCode'],
                'FTXtdPdtName'      => $paData['FTPdtName'],
                'FTPunCode'         => $paData['FTPunCode'],
                'FTPunName'         => $paData['FTPunName'],
                'FCXtdFactor'       => $paData['FCPdtUnitFact'],
                'FTXtdBarCode'      => $paDataWhere['FTBarCode'],
                'FTXtdVatType'      => $paData['FTPdtStaVatBuy'],
                'FTVatCode'         => $paData['FTVatCode'],
                'FCXtdVatRate'      => $paData['FCVatRate'],
                'FCXtdQty'          => 1,  //เพิ่มสินค้าใหม่
                'FCXtdQtyAll'       => 1*$paData['FCPdtUnitFact'], // จากสูตร qty * fector
                'FCXtdSetPrice'     => $paDataWhere['pcPrice']*1, // pcPrice มาจากข้อมูลใน modal คือ (ต้อทุนต่อหน่วยเล็กสุด * fector) จะได้จากสูตร  pcPrice * rate  (rate ต้องนำมาจากสกุลเงินของ company)
                'FTSessionID'       => $paDataWhere['FTSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:sa'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d h:i:sa'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            ));

            $this->db->last_query();  

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add.',
                );
            }
        }
        

    }


    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTFWGetDTTemp($paDataWhere){

        $tSQL = "SELECT

                    DOCTMP.FTBchCode,
                    DOCTMP.FTXthDocNo,
                    ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                    DOCTMP.FTXthDocKey,
                    DOCTMP.FTPdtCode,
                    DOCTMP.FTXtdPdtName,
                    DOCTMP.FTPunCode,
                    DOCTMP.FTPunName,
                    DOCTMP.FCXtdFactor,
                    DOCTMP.FTXtdBarCode,
                    DOCTMP.FTXtdVatType,
                    DOCTMP.FTVatCode,
                    DOCTMP.FCXtdVatRate,
                    DOCTMP.FCXtdQty,
                    DOCTMP.FCXtdQtyAll,
                    DOCTMP.FCXtdSetPrice,
                    DOCTMP.FCXtdAmt,
                    DOCTMP.FCXtdVat,
                    DOCTMP.FCXtdVatable,
                    DOCTMP.FCXtdNet,
                    DOCTMP.FCXtdCostIn,
                    DOCTMP.FCXtdCostEx,
                    DOCTMP.FTXtdStaPrcStk,
                    DOCTMP.FNXtdPdtLevel,
                    DOCTMP.FTXtdPdtParent,
                    DOCTMP.FCXtdQtySet,
                    DOCTMP.FTXtdPdtStaSet,
                    DOCTMP.FTXtdRmk,
                    DOCTMP.FTSessionID,

                    DOCTMP.FDLastUpdOn,
                    DOCTMP.FDCreateOn,
                    DOCTMP.FTLastUpdBy,
                    DOCTMP.FTCreateBy


                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                WHERE 1 = 1
            ";

            $tXthDocNo      = $paDataWhere['FTXthDocNo'];
            $tXthDocKey     = $paDataWhere['FTXthDocKey'];
            $tSesSessionID  = $this->session->userdata('tSesSessionID');    

           
            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
           
            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";
            
            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";
            
            $tSQL .= " ORDER BY DOCTMP.FNXtdSeqNo ASC";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }

        return $aResult;

    }

    function FSnMTFWCheckPdtTempForTransfer($tDocNo){
        $tSQL = "SELECT COUNT(FNXtdSeqNo) AS nSeqNo FROM TCNTDocDTTmp WITH (NOLOCK) 
        WHERE FTXthDocKey = 'TCNTPdtAdjStkHD' AND FTXthDocNo = '".$tDocNo."' 
        AND FTSessionID = '".$this->session->userdata('tSesSessionID')."'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array()["nSeqNo"];
        }else{
            return 0;
        }
    }

    function FSnMTFWCheckHaveProductInDT($ptDocNo,$ptBchCode){
        $tSQL = "SELECT COUNT(FNXtdSeqNo) AS nSeqNo FROM TVDTPdtTwxDT WITH (NOLOCK) WHERE FTXthDocNo = '".$ptDocNo."' AND FTBchCode = '".$ptBchCode."'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array()["nSeqNo"];
        }else{
            return 0;
        }
    }

    function FSaMTFWAddUpdateDocNoInDocTemp($aDataWhere){




        $tSQL = "UPDATE TCNTDocDTTmp SET
                FTXthDocNo = '".$aDataWhere['FTXthDocNo']."'
                WHERE FTBchCode = '".$aDataWhere['FTBchCode']."'
                AND FTXthDocNo = ''
                AND FTXthDocKey = '".$aDataWhere['FTXthDocKey']."'
                AND FTSessionID = '".$this->session->userdata('tSesSessionID')."'";
        $this->db->query($tSQL);
    }


    //Function : Update หลังจาก คำนวน DT เอายอดรวม มา Upd
    function FSaMTFWUpdateHDFCXthTotal($paDataUpdHD,$ptXthDocNo){

        try{
            //DT Dis
            $this->db->where('FTXthDocNo', $ptXthDocNo);
            $this->db->update('TCNTPdtAdjStkHD',$paDataUpdHD);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }

    }

    /*Function : Update DTTmp หลังจาก Edit In line
    Parameters : function parameters
    Creator : 02/04/2019 Krit(Copter)
    Last Modified : -
    Return : array
    Return Type : array
    */
    function FSnMWTOUpdateDTTemp($aDataUpd,$paDataWhere){

        try{

            if(is_array($aDataUpd) == 1){

                //ลบ ใน Temp
                $this->db->where_in('FTSessionID', $this->session->userdata('tSesSessionID'));
                $this->db->where_in('FTXthDocKey', $paDataWhere['FTXthDocKey']);
                $this->db->where_in('FTXthDocNo', $paDataWhere['FTXthDocNo']);
                $this->db->delete('TCNTDocDTTmp');
    
                foreach($aDataUpd as $key=>$val){
                    //เพิ่ม
                    $this->db->insert('TCNTDocDTTmp',$aDataUpd[$key]);
                    if($this->db->affected_rows() > 0){
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Add Success.',
                        );
                    }else{
                        $aStatus = array(
                            'rtCode' => '905',
                            'rtDesc' => 'Error Cannot Add.',
                        );
                    }
                }

                return $aStatus;
    
            }

        }catch(Exception $Error){
            return $Error;
        }
    }


    //Function : Cancel Doc
    public function FSvMTFWCancel($paDataUpdate){
        try{
            //DT Dis
            $this->db->set('FTAjhStaDoc' , 3);
            $this->db->where('FTAjhDocNo', $paDataUpdate['FTXthDocNo']);
            $this->db->update('TCNTPdtAdjStkHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }


    //Function : Approve Doc
    public function FSvMTFWApprove($paDataUpdate){
        try{
            //DT Dis
            $this->db->set('FTAjhStaPrcStk' , 2);
            $this->db->set('FTAjhStaApv' , 2);
            $this->db->set('FTAjhApvCode' , $paDataUpdate['FTXthApvCode']);
            $this->db->where('FTAjhDocNo', $paDataUpdate['FTXthDocNo']);

            $this->db->update('TCNTPdtAdjStkHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }

    public function FSxMUpdateBalToDT($pInfo,$aDataWhere){
        for($nI=0;$nI<FCNnHSizeOf($pInfo);$nI++){
            $tSQL = "UPDATE TCNTPdtAdjStkDT SET 
                     FCAjdWahB4Adj = '".$pInfo[$nI]["FCStkQty"]."'
                     WHERE 
                     FTBchCode = '".$aDataWhere["tBchCode"]."'
                     AND FTAjhDocNo = '".$aDataWhere["FTXthDocNo"]."'
                     AND FNAjdLayRow = '".$pInfo[$nI]["FNLayRow"]."'
                     AND FNAjdLayCol = '".$pInfo[$nI]["FNLayCol"]."'";
            $this->db->query($tSQL);
        }
        
    }

    public function FStTFWGetShpCodeForUsrLogin($paDataShp){

        $nLngID     = $paDataShp['FNLngID'];
        $tUsrLogin  = $paDataShp['tUsrLogin'];

        $tSQL = "SELECT UGP.FTBchCode,
                        BCHL.FTBchName,
                        MCHL.FTMerCode,
                        MCHL.FTMerName,
                        UGP.FTShpCode,
                        SHPL.FTShpName,
                        SHP.FTShpType,
                        SHP.FTWahCode AS FTWahCode,
			            WAHL.FTWahName AS FTWahName
                    /*  BCH.FTWahCode AS FTWahCode_Bch,  */
                    /*  BWAHL.FTWahName AS FTWahName_Bch  */
                        
                FROM TCNTUsrGroup UGP WITH (NOLOCK)
                LEFT JOIN TCNMBranch  BCH WITH (NOLOCK) ON UGP.FTBchCode = BCH.FTBchCode 
                LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON UGP.FTBchCode = BCHL.FTBchCode 
            /*  LEFT JOIN TCNMWaHouse_L BWAHL ON BCH.FTWahCode = BWAHL.FTWahCode */
                LEFT JOIN TCNMShop      SHP WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode
                LEFT JOIN TCNMMerchant_L  MCHL WITH (NOLOCK) ON SHP.FTMerCode = MCHL.FTMerCode AND  MCHL.FNLngID = '".$nLngID."'
                LEFT JOIN TCNMShop_L    SHPL WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = '".$nLngID."'
                LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode 
                WHERE FTUsrCode ='".$tUsrLogin."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oRes  = $oQuery->row_array();
            $tDataShp = $oRes;
        }else{
            $tDataShp = '';
        }

        return $tDataShp;
    }

    public function FSaMTFWGetDefOptionTFW($paData){

        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT CON.FTSysStaUsrValue,WAHL.FTWahName
                FROM TSysConfig CON WITH (NOLOCK)
                LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON CON.FTSysStaUsrValue = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                WHERE FTSysCode='tCN_WahTFW' AND FTSysSeq='1'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oRes  = $oQuery->result();
        $tData = $oRes[0];
        }else{
        $tData = '';
        }

        return $tData;

    }

    //Get Vat rate ของ DocNo
    public function FSaMTFWGetAddress($ptBchCode,$ptXthShipAdd,$nLngID){
    
        $tSQL = "SELECT FTAddV1No,
                        FTAddV1Soi,
                        FTAddV1Village,
                        FTAddV1Road,
                        FTAddV1SubDist,
                        FTAddV1DstCode,
                        FTAddV1PvnCode,
                        FTAddV1PostCode,
                        PVNL.FTPvnName,
                        DSTL.FTDstName,
                        SUBDSTL.FTSudName
        
                FROM TCNMAddress_L ADDL WITH (NOLOCK)

                LEFT JOIN TCNMProvince_L   PVNL WITH (NOLOCK) ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                LEFT JOIN TCNMDistrict_L   DSTL WITH (NOLOCK) ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                LEFT JOIN TCNMSubDistrict_L SUBDSTL WITH (NOLOCK) ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
                WHERE FTAddGrpType = 1
                ";

        if($ptBchCode!= ""){
            $tSQL .= " AND FTAddRefCode = '$ptBchCode'";
        }

        if($ptXthShipAdd!= ""){
            $tSQL .= " AND FNAddSeqNo = '$ptXthShipAdd'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oData    = $oQuery->result();
        }else{
            $oData = 0;
        }

        return $oData;
    }

    //Get Vat rate ของ DocNo
    public function FScMTFWGetVatRateFromDoc($ptXthDocNo){
        
        $tSQL = "SELECT ISNULL(FCXthVATRate,0) AS FCXthVATRate    
                FROM TAPTOrdHD WITH (NOLOCK)";

        if($ptXthDocNo!= ""){
            $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthVATRate = $oData[0]->FCXthVATRate;
        }else{
        $cXthVATRate = 0;
        }

        return $cXthVATRate;
    }

    public function FSaMTFWGetHDFCXthWpTax($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdWhtAmt),0) AS FCXthWpTax  
                 FROM TAPTOrdDT WITH (NOLOCK)";

        if($ptXthDocNo!= ""){
        $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthWpTax = $oData[0]->FCXthWpTax;
        }else{
        $cXthWpTax = 0;
        }

        return $cXthWpTax;

    }

    public function FSaMTFWGetHDFCXthNoVatAfDisChg($ptXthDocNo){

        $tSQL = "SELECT ISNULL(HDis.FCXthNoVatDisChgAvi-SUM(HDis.FCXthDisNoVat-HDis.FCXthChgNoVat),0) AS FCXthNoVatAfDisChg
                 FROM TAPTOrdHDDis HDis WITH (NOLOCK)";

        if($ptXthDocNo != ""){
            $tSQL .= " WHERE HDis.FTXthDocNo = '$ptXthDocNo'";
        }

        $tSQL .= " GROUP BY HDis.FCXthNoVatDisChgAvi";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthNoVatAfDisChg = $oData[0]->FCXthNoVatAfDisChg;
        }else{
        $cXthNoVatAfDisChg = 0;
        }

        return $cXthNoVatAfDisChg;

    }

    public function FSaMTFWGetFCXthRefAEAmt($ptXthDocNo){

        $tSQL = "SELECT FCXthRefAEAmt
                 FROM TAPTOrdHD HD WITH (NOLOCK)";

        if($ptXthDocNo != ""){
            $tSQL .= " WHERE HD.FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthRefAEAmt = $oData[0]->FCXthRefAEAmt;
        }else{
        $cXthRefAEAmt = 0;
        }

        return $cXthRefAEAmt;

    }
    
    public function FSaMTFWGetSUMFCXddDisVatMinusFCXddChgVat($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXthDisVat - FCXthChgVat),0) AS  FCXthDisRes
                 FROM TAPTOrdHDDis HDis WITH (NOLOCK) ";

        if($ptXthDocNo != ""){
            $tSQL .= "WHERE HDis.FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthDisRes = $oData[0]->FCXthDisRes;
        }else{
        $cXthDisRes = 0;
        }

        return $cXthDisRes;

    }

    public function FSaMTFWGetHDFCXthChg($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(HDis.FCXthChgVat+HDis.FCXthChgNoVat),0) AS FCXthChg
                 FROM TAPTOrdHDDis HDis WITH (NOLOCK) ";

        if($ptXthDocNo != ""){
            $tSQL .= "WHERE HDis.FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXpdChg = $oData[0]->FCXthChg;
        }else{
        $cXpdChg = 0;
        }

        return $cXpdChg;

    }

    public function FSaMTFWGetHDFCXthDis($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(HDis.FCXthDisVat+HDis.FCXthDisNoVat),0) AS FCXthDis
                 FROM TAPTOrdHDDis HDis WITH (NOLOCK) ";

        if($ptXthDocNo != ""){
            $tSQL .= "WHERE HDis.FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthDis = $oData[0]->FCXthDis;
        }else{
        $cXthDis = 0;
        }

        return $cXthDis;

    }

    public function FSaMTFWGetHDFCXthNoVatDisChgAvi($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0) AS FCXthNoVatDisChgAvi  
                 FROM TAPTOrdDT WITH (NOLOCK) ";

        if($ptXthDocNo!= ""){
        $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'
                  AND FTXpdStaAlwDis='1' 
                  AND FTXpdVatType ='2'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthTotal = $oData[0]->FCXthNoVatDisChgAvi;
        }else{
        $cXthTotal = 0;
        }

        return $cXthTotal;

    }

    public function FSaMTFWGetHDFTXthDisChgTxt($ptXthDocNo){

        $tSQL = "SELECT FTXthDisChgTxt 
                 FROM TAPTOrdHDDis WITH (NOLOCK) ";

        if($ptXthDocNo!= ""){
        $tSQL .= " WHERE FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthTotal = $oData;
        }else{
        $cXthTotal = 0;
        }

        return $cXthTotal;

    }

    public function FSaMTFWGetHDFCXthVatDisChgAvi($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0) AS FCXthVatDisChgAvi  
                 FROM TAPTOrdDT WITH (NOLOCK) ";

        if($ptXthDocNo!= ""){
        $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'
                  AND FTXpdStaAlwDis = '1' 
                  AND FTXpdVatType ='1'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthTotal = $oData[0]->FCXthVatDisChgAvi;
        }else{
        $cXthTotal = 0;
        }

        return $cXthTotal;

    }

    public function FSaMTFWGetHDFCXthNoVatNoDisChg($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0)AS FCXthNoVatNoDisChg  
                 FROM TAPTOrdDT WITH (NOLOCK) ";

        if($ptXthDocNo!= ""){
        $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'
                    AND FTXpdStaAlwDis='2' 
                    AND FTXpdVatType ='2'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthTotal = $oData[0]->FCXthNoVatNoDisChg;
        }else{
        $cXthTotal = 0;
        }

        return $cXthTotal;

    }

    public function FSaMTFWGetHDFCXthVatNoDisChg($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0)AS FCXthVatNoDisChg  
                 FROM TAPTOrdDT WITH (NOLOCK) ";

        if($ptXthDocNo!= ""){
        $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'
                  AND FTXpdStaAlwDis='2'
                  AND FTXpdVatType ='1' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXthTotal = $oData[0]->FCXthVatNoDisChg;
        }else{
        $cXthTotal = 0;
        }

        return $cXthTotal;

    }

    public function FSaMTFWGetHDFCXthTotal($ptXthDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0) AS FCXthTotal
                 FROM TAPTOrdDT  WITH (NOLOCK)
                ";

        if($ptXthDocNo!= ""){
            $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oData    = $oQuery->result();
            $cXthTotal = $oData[0]->FCXthTotal;
        }else{
            $cXthTotal = 0;
        }

        return $cXthTotal;

    }

    public function FCNxTFWGetvatInOrEx($ptXthDocNo){

        $tSQL = "SELECT FTXthVATInOrEx
                 FROM TAPTOrdHD WITH (NOLOCK)
                ";

        if($ptXthDocNo!= ""){
            $tSQL .= "WHERE FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $tXthVATInOrEx = $oDetail[0]->FTXthVATInOrEx;
        }else{
            $tXthVATInOrEx = '';
        }

        return $tXthVATInOrEx;
    }


    public function FSaMTFWGetRteFacHD($ptXthDocNo){

        $tSQL = "SELECT FCXthRteFac
                 FROM TAPTOrdHD ORDHD WITH (NOLOCK)
                 WHERE 1 = 1
                ";

        if($ptXthDocNo!= ""){
            $tSQL .= "AND ORDHD.FTXthDocNo = '$ptXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $cXthRteFac = $oDetail[0]->FCXthRteFac;
        }else{
            $cXthRteFac = '';
        }

        return $cXthRteFac;

    }

    public function FSaMTFWGetPdtIntoTableDT($paData){

        $tPdtCode   = $paData['FTPdtCode'];
        $FTPunCode   = $paData['FTPunCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT

                    PDT.FTPdtCode,
                    PDT.FTPdtStkControl,
                    PDT.FTPdtGrpControl,
                    PDT.FTPdtForSystem,
                    PDT.FCPdtQtyOrdBuy,
                    PDT.FCPdtCostDef,
                    PDT.FCPdtCostOth,
                    PDT.FCPdtCostStd,
                    PDT.FCPdtMin,
                    PDT.FCPdtMax,
                    PDT.FTPdtPoint,
                    PDT.FCPdtPointTime,
                    PDT.FTPdtType,
                    PDT.FTPdtSaleType,
                    PDT.FTPdtSetOrSN,
                    PDT.FTPdtStaSetPri,
                    PDT.FTPdtStaSetShwDT,
                    PDT.FTPdtStaAlwDis,
                    PDT.FTPdtStaAlwReturn,
                    PDT.FTPdtStaVat,
                    PDT.FTPdtStaActive,
                    PDT.FTPdtStaAlwReCalOpt,
                    PDT.FTPdtStaCsm,
                    /*PDT.FTShpCode,*/
                    PDT.FTPdtRefShop,
                    PDT.FTTcgCode,
                    PDT.FTPtyCode,
                    PDT.FTPbnCode,
                    PDT.FTPmoCode,
                    PDT.FTVatCode,
                    /*PDT.FTEvnCode,*/
                    PDT.FDPdtSaleStart,
                    PDT.FDPdtSaleStop,

                    PDTL.FTPdtName,
                    PDTL.FTPdtNameOth,
                    PDTL.FTPdtNameABB,
                    PDTL.FTPdtRmk,

                    PKS.FTPunCode,
                    PKS.FCPdtUnitFact,

                    VAT.FCVatRate,
                    
                    UNTL.FTPunName,
                    
                    BAR.FTBarCode,

                    PDTSRL.FTSrnCode,

                    PDT.FCPdtCostStd,
                    CAVG.FCPdtCostEx,
                    CAVG.FCPdtCostIn,
                    SPL.FCSplLastPrice
         
                    
                FROM TCNMPdt PDT WITH (NOLOCK)
                LEFT JOIN TCNMPdt_L PDTL  WITH (NOLOCK)               ON PDT.FTPdtCode = PDTL.FTPdtCode   AND PDTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtPackSize  PKS WITH (NOLOCK)         ON PDT.FTPdtCode = PKS.FTPdtCode    AND PKS.FTPunCode = $FTPunCode
                LEFT JOIN TCNMPdtUnit_L UNTL  WITH (NOLOCK)          ON UNTL.FTPunCode = $FTPunCode      AND UNTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtBar BAR  WITH (NOLOCK)              ON PKS.FTPdtCode = BAR.FTPdtCode    AND BAR.FTPunCode = $FTPunCode
                LEFT JOIN (SELECT FTVatCode,FCVatRate,FDVatStart   
                           FROM TCNMVatRate WITH (NOLOCK) WHERE GETdate()> FDVatStart) VAT
                           ON PDT.FTVatCode=VAT.FTVatCode 
                LEFT JOIN TCNTPdtSerial PDTSRL WITH (NOLOCK)         ON PDT.FTPdtCode = PDTSRL.FTPdtCode
                LEFT JOIN TCNMPdtSpl SPL WITH (NOLOCK)               ON PDT.FTPdtCode = SPL.FTPdtCode  AND BAR.FTBarCode = SPL.FTBarCode
                LEFT JOIN TCNMPdtCostAvg CAVG  WITH (NOLOCK)         ON PDT.FTPdtCode = CAVG.FTPdtCode

                WHERE PDT.FTPdtForSystem = '1'
                AND PDT.FTPdtType IN('1','2','4')
                AND PDT.FTPdtStaActive = '1'
                AND SPL.FTSplStaAlwTFW = '1'
                -- AND '2018/08/06' Between SPL.FDPdtAlwOrdStart AND SPL.FDPdtAlwOrdStop
                -- AND SPL.FTPdtStaAlwOrdSun='1'
                ";


            if($tPdtCode!= ""){
            $tSQL .= " AND PDT.FTPdtCode = '$tPdtCode'";
            }

            $tSQL .= " ORDER BY FDVatStart DESC";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItem'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
            }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;

    }

    public function FSaMTFWGetPdtDetail($paData){

        $tPdtCode   = $paData['FTPdtCode'];
        $FTPunCode   = $paData['FTPunCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT

                    PDT.FTPdtCode,
                    PDT.FTPdtStkControl,
                    PDT.FTPdtGrpControl,
                    PDT.FTPdtForSystem,
                    PDT.FCPdtQtyOrdBuy,
                    PDT.FCPdtCostDef,
                    PDT.FCPdtCostOth,
                    PDT.FCPdtCostStd,
                    PDT.FCPdtMin,
                    PDT.FCPdtMax,
                    PDT.FTPdtPoint,
                    PDT.FCPdtPointTime,
                    PDT.FTPdtType,
                    PDT.FTPdtSaleType,
                    PDT.FTPdtSetOrSN,
                    PDT.FTPdtStaSetPri,
                    PDT.FTPdtStaSetShwDT,
                    PDT.FTPdtStaAlwDis,
                    PDT.FTPdtStaAlwReturn,
                    PDT.FTPdtStaVat,
                    PDT.FTPdtStaActive,
                    PDT.FTPdtStaAlwReCalOpt,
                    PDT.FTPdtStaCsm,
                    /*PDT.FTShpCode,*/
                    PDT.FTPdtRefShop,
                    PDT.FTTcgCode,
                    PDT.FTPtyCode,
                    PDT.FTPbnCode,
                    PDT.FTPmoCode,
                    PDT.FTVatCode,
                    /*PDT.FTEvnCode,*/
                    PDT.FDPdtSaleStart,
                    PDT.FDPdtSaleStop,

                    PDTL.FTPdtName,
                    PDTL.FTPdtNameOth,
                    PDTL.FTPdtNameABB,
                    PDTL.FTPdtRmk,

                    PDTPCKSZE.FCPdtUnitFact,

                    UNTL.FTPunName,

                    BAR.FTBarCode,

                    PDTSRL.FTSrnCode
                    
                FROM TCNMPdt PDT WITH (NOLOCK)
                LEFT JOIN TCNMPdt_L PDTL  WITH (NOLOCK)               ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtPackSize  PDTPCKSZE WITH (NOLOCK)   ON PDT.FTPdtCode = PDTPCKSZE.FTPdtCode AND PDTPCKSZE.FTPunCode = $FTPunCode
                LEFT JOIN TCNMPdtUnit_L UNTL WITH (NOLOCK)           ON UNTL.FTPunCode = $FTPunCode
                LEFT JOIN TCNMPdtBar BAR  WITH (NOLOCK)              ON PDT.FTPdtCode = BAR.FTPdtCode AND BAR.FTPunCode = $FTPunCode
                LEFT JOIN TCNTPdtSerial PDTSRL WITH (NOLOCK)         ON PDT.FTPdtCode = PDTSRL.FTPdtCode 
                WHERE 1=1 ";

            if($tPdtCode!= ""){
            $tSQL .= "AND PDT.FTPdtCode = '$tPdtCode'";
            }

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItem'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
            }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;

    }

    //Functionality : Search Subdistrict By ID
    //Parameters : function parameters
    //Creator : 12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMSDTSearchByID($paData){

        $tSudCode   = $paData['FTSudCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    SDT.FTSudCode       AS rtSudCode,
                    SDT.FTDstCode       AS rtDstCode,
                    DSTL.FTDstName      AS rtDstName,
                    SDT.FTSudLatitude   AS rtSudLatitude,
                    SDT.FTSudLongitude  AS rtSudLongitude,
                    SDTL.FTSudName      AS rtSudName,
                    PVNL.FTPvnCode      AS rtPvnCode,
                    PVNL.FTPvnName      AS rtPvnName
                FROM TCNMSubDistrict SDT WITH (NOLOCK)
                LEFT JOIN TCNMSubDistrict_L SDTL WITH (NOLOCK) ON SDT.FTSudCode = SDTL.FTSudCode AND SDTL.FNLngID = $nLngID
                LEFT JOIN TCNMDistrict  DST WITH (NOLOCK) ON SDT.FTDstCode = DST.FTDstCode
                LEFT JOIN TCNMDistrict_L DSTL WITH (NOLOCK) ON SDT.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                LEFT JOIN TCNMProvince_L PVNL WITH (NOLOCK) ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                WHERE 1=1 ";

        if($tSudCode!= ""){
            $tSQL .= "AND SDT.FTSudCode = '$tSudCode'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }




    //Functionality : Search TFW By ID
    //Parameters : function parameters
    //Creator : 07/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMTFWGetHD($paData){

        $tXthDocNo  = $paData['FTXthDocNo'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT
                    TWXVD.FTBchCode,
                    BCHL.FTBchName,
                    TWXVD.FTAjhDocNo AS FTXthDocNo,
                    TWXVD.FDAjhDocDate AS FDXthDocDate,
                    convert(CHAR(5), TWXVD.FDAjhDocDate, 108)  AS FTXthDocTime,
                    TWXVD.FTDptCode,
                    DPTL.FTDptName,
                    TWXVD.FTAjhMerchantTo AS FTXthMerCode,
                    MCHL.FTMerName,
                    TWXVD.FTAjhShopTo AS FTXthShopFrm,
                    FSHP.FTShpType AS FTShpTypeFrm,
                    FSHPL.FTShpName AS FTShpNameFrm,
                    TWXVD.FTAjhPosTo AS FTXthPosFrm,
                    TWXVD.FTAjhPosTo AS FTPosComNameF,
                    TWXVD.FTAjhWhTo AS FTXthWhFrm,
                    
                    WAH_L.FTWahName AS FTXthWhNameFrm, --Napat(jame) 16/03/63

                    TWXVD.FTUsrCode,
                    TWXVD.FTAjhApvCode AS FTXthApvCode,
                    TWXVD.FNAjhDocPrint AS FNXthDocPrint,
                    TWXVD.FTAjhRmk AS FTXthRmk,
                    TWXVD.FTAjhStaDoc AS FTXthStaDoc,
                    TWXVD.FTAjhStaApv AS FTXthStaApv,
                    TWXVD.FTAjhStaPrcStk AS FTXthStaPrcStk,
                    TWXVD.FTAjhStaDelMQ AS FTXthStaDelMQ,
                    TWXVD.FNAjhStaDocAct AS FNXthStaDocAct,
                    TWXVD.FTRsnCode,
                    RSN_L.FTRsnName,
                    TWXVD.FDLastUpdOn,
                    TWXVD.FTLastUpdBy,
                    TWXVD.FDCreateOn,
                    TWXVD.FTCreateBy,
                    USRAPV.FTUsrName AS FTUsrNameApv
                    FROM TCNTPdtAdjStkHD TWXVD
                    LEFT JOIN TCNMRsn_L RSN_L ON TWXVD.FTRsnCode = RSN_L.FTRsnCode AND RSN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L     BCHL WITH (NOLOCK)   ON TWXVD.FTBchCode   = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMMerchant_L   MCHL WITH (NOLOCK)   ON TWXVD.FTAjhMerchantTo = MCHL.FTMerCode AND MCHL.FNLngID = $nLngID
                    /*ต้นทาง*/
                    LEFT JOIN TCNMShop         FSHP WITH (NOLOCK)   ON TWXVD.FTAjhShopTo = FSHP.FTShpCode AND TWXVD.FTBchCode = FSHP.FTBchCode
                    LEFT JOIN TCNMShop_L       FSHPL WITH (NOLOCK)  ON TWXVD.FTAjhShopTo = FSHPL.FTShpCode AND TWXVD.FTBchCode = FSHPL.FTBchCode AND FSHPL.FNLngID = $nLngID
                    LEFT JOIN TVDMPosShop      PSHPLF WITH (NOLOCK) ON TWXVD.FTAjhShopTo = PSHPLF.FTShpCode AND TWXVD.FTBchCode = PSHPLF.FTBchCode
                    
                    LEFT JOIN TCNMUser_L       USRL WITH (NOLOCK)   ON TWXVD.FTCreateBy   = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L       USRAPV WITH (NOLOCK) ON TWXVD.FTAjhApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                    LEFT JOIN TCNMUsrDepart_L  DPTL WITH (NOLOCK)   ON TWXVD.FTDptCode = DPTL.FTDptCode AND DPTL.FNLngID = $nLngID
                    LEFT JOIN TCNMWaHouse_L WAH_L WITH(NOLOCK) ON TWXVD.FTAjhWhTo = WAH_L.FTWahCode AND TWXVD.FTBchCode = WAH_L.FTBchCode AND WAH_L.FNLngID = $nLngID --Napat(jame) 16/03/63
                    WHERE 1=1
                ";

        /*(SELECT TCNMWaHouse_L.FTWahName FROM TCNMWaHouse
                        LEFT JOIN TCNMWaHouse_L ON TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode
                        WHERE TCNMWaHouse.FTWahStaType=6 AND TCNMWaHouse.FTWahCode = TWXVD.FTAjhWhTo 
                        AND FNLngID = $nLngID) AS FTXthWhNameFrm,*/            

        if($tXthDocNo != ""){
            $tSQL .= " AND TWXVD.FTAjhDocNo = '$tXthDocNo' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }



    //Functionality : Data List Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTFWGetDT($paData,$paDataInfor){

        $tXthDocNo = $paData['FTXthDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTAjhDocNo ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                FTBchCode,
                                FTAjhDocNo,
                                FNAjdSeqNo,
                                FTPdtCode,
                                FTPdtName,
                                FNAjdLayRow,
                                FNAjdLayCol,
                                FCAjdUnitQty,
                                FDAjdDateTime,
                                FNCabSeq
                            FROM TCNTPdtAdjStkDT WITH (NOLOCK) ";
        
        if(@$tXthDocNo != ''){
            $tSQL .= " WHERE FTAjhDocNo = '$tXthDocNo'";
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            for($nI=0;$nI<FCNnHSizeOf($oDetail);$nI++){
                for($nJ=0;$nJ<FCNnHSizeOf($paDataInfor);$nJ++){
                    if($oDetail[$nI]["FNAjdLayRow"]==$paDataInfor[$nJ]["FNLayRow"] &&
                       $oDetail[$nI]["FNAjdLayCol"]==$paDataInfor[$nJ]["FNLayCol"]){
                        $oDetail[$nI]["FCLayColQtyMax"] = $paDataInfor[$nJ]["FCLayColQtyMax"];
                        $oDetail[$nI]["FCStkQty"] = $paDataInfor[$nJ]["FCStkQty"];
                        break;
                    }
                }
            }
            $aResult = array(
                'rtCode' => '1',
                'raItems'   => $oDetail,
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }


    //Functionality : Function Add DT To Temp
    //Parameters : function parameters
    //Creator : 03/04/2019 Krit(Copter)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMTFWInsertDTToTemp($aDataInsert){
        for($nI=0;$nI<FCNnHSizeOf($aDataInsert);$nI++){
            $tSQL = "INSERT INTO TCNTDocDTTmp(
                FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FTXthDocKey,
                FTPdtCode,
                FTXtdPdtName,
                FCStkQty,
                FNLayRowForADJSTKVD,
                FNLayColForADJSTKVD,
                FCLayColQtyMaxForADJSTKVD,
                FCUserInPutForADJSTKVD,
                FCDateTimeInputForADJSTKVD,
                FTSessionID,
                FNCabSeqForTWXVD
            ) 
            VALUES(
                '".$aDataInsert[$nI]["FTBchCode"]."',
                '".$aDataInsert[$nI]["FTAjhDocNo"]."',
                ".$aDataInsert[$nI]["FNAjdSeqNo"].",
                'TCNTPdtAdjStkHD',
                '".$aDataInsert[$nI]["FTPdtCode"]."',
                '".$aDataInsert[$nI]["FTPdtName"]."',
                ".$aDataInsert[$nI]["FCStkQty"].",
                ".$aDataInsert[$nI]["FNAjdLayRow"].",
                ".$aDataInsert[$nI]["FNAjdLayCol"].",
                ".$aDataInsert[$nI]["FCLayColQtyMax"].",
                ".$aDataInsert[$nI]["FCAjdUnitQty"].",
                '".$aDataInsert[$nI]["FDAjdDateTime"]."',
                '".$this->session->userdata('tSesSessionID')."',
                '".$aDataInsert[$nI]["FNCabSeq"]."'
            )";
            $this->db->query($tSQL);
        }
        

        

    }


    //Functionality : Data List DT Dis
    //Parameters : function parameters
    //Creator :  03/09/2018 Krit(Copter)
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTFWGetHDRef($paData){

        $tXthDocNo = $paData['FTXthDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tSQL   = "SELECT
                    TFWR.FTBchCode,
                    TFWR.FTXthDocNo,
                    TFWR.FTXthCtrName,
                    TFWR.FDXthTnfDate,
                    TFWR.FTXthRefTnfID,
                    TFWR.FTXthRefVehID,
                    TFWR.FTXthQtyAndTypeUnit,
                    TFWR.FNXthShipAdd,
                    TFWR.FTViaCode,
                    TADD.FNAddSeqNo,
                    TADD.FTAddV1No,
                    TADD.FTAddV1Soi,
                    TADD.FTAddV1Village,
                    TADD.FTAddV1Road,
                    TSUD.FTSudName,
                    TDST.FTDstName,
                    TPVC.FTPvnName,
                    TADD.FTAddV1PostCode,
                    TSPVL.FTViaName
                    FROM [TCNTPdtAdjStkHDRef] TFWR WITH (NOLOCK)
                    LEFT JOIN TCNMAddress_L TADD WITH (NOLOCK) ON TFWR.FNXthShipAdd = TADD.FNAddSeqNo
                    LEFT JOIN TCNMSubDistrict_L TSUD WITH (NOLOCK) ON TADD.FTAddV1SubDist = TSUD.FTSudCode
                    LEFT JOIN TCNMDistrict_L TDST WITH (NOLOCK) ON TADD.FTAddV1DstCode = TDST.FTDstCode
                    LEFT JOIN TCNMProvince_L TPVC WITH (NOLOCK) ON TADD.FTAddV1PvnCode = TPVC.FTPvnCode
                    LEFT JOIN TCNMShipVia_L  TSPVL WITH (NOLOCK) ON TFWR.FTViaCode = TSPVL.FTViaCode
                    ";
        
       
        if(@$tXthDocNo != ''){
            $tSQL .= " WHERE (TFWR.FTXthDocNo = '$tXthDocNo')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode' => '1',
                'rtDesc' => 'OK.',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }


    //Functionality : Data List DT Dis
    //Parameters : function parameters
    //Creator :  03/09/2018 Krit(Copter)
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTFWGetTfwDTDis($paData){

        $tXthDocNo = $paData['FTXthDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tSQL   = "SELECT
                        DTD.FTBchCode,
                        DTD.FTXthDocNo,
                        DTD.FNXpdSeqNo,
                        DTD.FDXddDateIns,
                        DTD.FNXpdStaDis,
                        DTD.FCXddDisChgAvi,
                        DTD.FTXddDisChgTxt,
                        DTD.FCXddDis,
                        DTD.FCXddChg,
                        DTD.FTXddUsrApv
                FROM [TAPTOrdDTDis] DTD WITH (NOLOCK)
                ";
        
       
        if(@$tXthDocNo != ''){
            $tSQL .= " WHERE (DTD.FTXthDocNo = '$tXthDocNo')";
        }

        $tSQL .= " ORDER BY FDXddDateIns ASC";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }



    //Functionality : All Page Of Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSnMTFWGetPageAll($paData){
        $nLngID         = $paData['FNLngID'];
        $aDataUserInfo  = $this->session->userdata("tSesUsrInfo");
        $oAdvanceSearch = $paData['oAdvanceSearch'];
        @$tSearchList   = $oAdvanceSearch['tSearchAll'];

        // Search All On Input
        $tWhereSearchAll    = "";
        if(@$tSearchList != ''){
            $tWhereSearchAll    = " AND ((TFW.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TFW.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }

        // Check User Level Branch HQ OR Bch Or Shop
        $tUserLevel = $this->session->userdata("tSesUsrLevel");
        $tWhereBch  = "";
        $tWhereShp  = "";
        if(isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH"){
            // Check User Level BCH
            $tWhereBch  =   " AND TFW.FTBchCode = '".$aDataUserInfo['FTBchCode']."'";
        }
        if(isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "SHP"){
            // Check User Level SHP
            $tWhereShp  =   " AND TFW.FTAjhShopTo = '".$aDataUserInfo['FTShpCode']."'";
        }
        
        // Check Branch From - To (จากสาขา - ถึงสาขา)
        $tSearchBchCodeFrom = $oAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $oAdvanceSearch['tSearchBchCodeTo'];
        $tWhereBchFrmTo     = "";
        if((isset($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) && (isset($tSearchBchCodeTo) && !empty($tSearchBchCodeTo))){
            $tWhereBchFrmTo = " AND ((TFW.FTBchCode BETWEEN '$tSearchBchCodeFrom' AND '$tSearchBchCodeTo') OR (TFW.FTBchCode BETWEEN '$tSearchBchCodeTo' AND '$tSearchBchCodeFrom'))";
        }

        // Check Date From - To (จากวันที่ - ถึงวันที่)
        $tSearchDocDateFrom = $oAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $oAdvanceSearch['tSearchDocDateTo'];
        $tWhereDateFrmTo     = "";
        if((isset($tSearchDocDateFrom) && !empty($tSearchDocDateFrom)) && (isset($tSearchDocDateTo) && !empty($tSearchDocDateTo))){
            $tWhereDateFrmTo    = " AND ((TFW.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TFW.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // Check Status Doccument สถานะเอกสาร
        $tSearchStaDoc  = $oAdvanceSearch['tSearchStaDoc'];
        $tWhereStaDoc   = "";
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            if($tSearchStaDoc == 2){
                $tWhereStaDoc   = " AND TFW.FTAjhStaDoc = '$tSearchStaDoc' OR TFW.FTAjhStaDoc = ''";
            }else{
                $tWhereStaDoc   = " AND TFW.FTAjhStaDoc = '$tSearchStaDoc'";
            }
        }

        // Check Status Appove สถานะอนุมัติ
        $tSearchStaApprove  = $oAdvanceSearch['tSearchStaApprove'];
        $tWhereStaApv       = "";
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tWhereStaApv   = " AND TFW.FTAjhStaApv = '$tSearchStaApprove' OR TFW.FTAjhStaApv = '' ";
            }else{
                $tWhereStaApv   = " AND TFW.FTAjhStaApv = '$tSearchStaApprove'";
            }
        } 

        // Check Status Appove สถานะประมวลผล
        $tSearchStaPrcStk   = $oAdvanceSearch['tSearchStaPrcStk'];
        $tWhereStaPrcStk    = "";
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tWhereStaPrcStk    = " AND TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk' OR TFW.FTAjhStaPrcStk = '' ";
            }else{
                $tWhereStaPrcStk    = " AND TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $tSQL = "   SELECT COUNT (TFW.FTAjhDocNo) AS counts
                    FROM [TCNTPdtAdjStkHD] TFW WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON TFW.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                    INNER JOIN (SELECT DISTINCT FTAjhDocNo  FROM TCNTPdtAdjStkDT WHERE FNAjdLayRow <> 0 AND FNAjdLayCol <> 0) DT ON TFW.FTAjhDocNo = DT.FTAjhDocNo
                    WHERE 1=1 
                    AND TFW.FTAjhDocType = '3'
                    ".$tWhereBch."
                    ".$tWhereShp."
                    ".$tWhereBchFrmTo."
                    ".$tWhereDateFrmTo."
                    ".$tWhereStaDoc."
                    ".$tWhereStaApv."
                    ".$tWhereStaPrcStk."
                ";
                            

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : Chack Data Code Duplicate
    //Parameters : function parameters
    //Creator : 15/02/2019 Krit
    //Last Modified : -
    //Return : Array Count Data
    //Return Type : Array
    public function FSnMTFWCheckDuplicate($ptCode){
        $tSQL = "SELECT COUNT(FTXthDocNo) AS counts
                 FROM TCNTPdtAdjStkHD WITH (NOLOCK)
                 WHERE FTXthDocNo = '$ptCode' 
                ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTFWAddUpdateHD($paData){
        
        try{
            //Update Master
            $this->db->set('FTBchCode'              , $paData['FTBchCode']);
            $this->db->set('FNAjhDocType'              , '11');
            $this->db->set('FTAjhDocType'              , '3');
            $this->db->set('FTAjhApvSeqChk'              , '3');
            $this->db->set('FDAjhDocDate'           , $paData['FDAjhDocDate']);
            $this->db->set('FTAjhBchTo'              , $paData['FTAjhBchTo']);
            $this->db->set('FTAjhMerchantTo'           , $paData['FTAjhMerchantTo']);
            $this->db->set('FTAjhShopTo'           , $paData['FTAjhShopTo']);
            $this->db->set('FTAjhPosTo'            , $paData['FTAjhPosTo']);
            $this->db->set('FTAjhWhTo'             , $paData['FTAjhWhTo']);
            $this->db->set('FTAjhPlcCode'              , $paData['FTAjhPlcCode']);
            $this->db->set('FTDptCode'             , $paData['FTDptCode']);
            $this->db->set('FTUsrCode'              , $paData['FTUsrCode']);
            $this->db->set('FTRsnCode'              , $paData['FTRsnCode']);
            $this->db->set('FTAjhRmk'            , $paData['FTAjhRmk']);
            $this->db->set('FNAjhDocPrint'        , $paData['FNAjhDocPrint']);
            $this->db->set('FTAjhApvSeqChk'            , $paData['FTAjhApvSeqChk']);
            $this->db->set('FTAjhApvCode'        , $paData['FTAjhApvCode']);
            $this->db->set('FTAjhStaApv'          , $paData['FTAjhStaApv']);
            $this->db->set('FTAjhStaPrcStk'             , $paData['FTAjhStaPrcStk']);
            $this->db->set('FTAjhStaDoc'               , $paData['FTAjhStaDoc']);
            $this->db->set('FNAjhStaDocAct'            , $paData['FNAjhStaDocAct']);
            $this->db->set('FTAjhDocRef'            , $paData['FTAjhDocRef']);
            $this->db->set('FTAjhStaDelMQ'         , $paData['FTAjhStaDelMQ']);
            $this->db->set('FDLastUpdOn'         , $paData['FDLastUpdOn']);
            $this->db->set('FDCreateOn'            , $paData['FDCreateOn']);
            $this->db->set('FTCreateBy'              , $paData['FTCreateBy']);
            $this->db->set('FTLastUpdBy'            , $paData['FTLastUpdBy']);
            $this->db->where('FTAjhDocNo'           , $paData['FTAjhDocNo']);
            $this->db->update('TCNTPdtAdjStkHD');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TCNTPdtAdjStkHD',array(
                    'FTAjhDocNo'           => $paData['FTAjhDocNo'],
                    'FNAjhDocType'              => '11',
                    'FTAjhDocType'              => '3',
                    'FTAjhApvSeqChk'              => '3',
                    'FTBchCode'              => $paData['FTBchCode'],
                    'FDAjhDocDate'           => $paData['FDAjhDocDate'],
                    'FTAjhBchTo'              => $paData['FTAjhBchTo'],
                    'FTAjhMerchantTo'           => $paData['FTAjhMerchantTo'],
                    'FTAjhShopTo'           => $paData['FTAjhShopTo'],
                    'FTAjhPosTo'            => $paData['FTAjhPosTo'],
                    'FTAjhWhTo'             => $paData['FTAjhWhTo'],
                    'FTAjhPlcCode'              => $paData['FTAjhPlcCode'],
                    'FTDptCode'             => $paData['FTDptCode'],
                    'FTUsrCode'              => $paData['FTUsrCode'],
                    'FTRsnCode'              => $paData['FTRsnCode'],
                    'FTAjhRmk'            => $paData['FTAjhRmk'],
                    'FNAjhDocPrint'        => $paData['FNAjhDocPrint'],
                    'FTAjhApvSeqChk'            => $paData['FTAjhApvSeqChk'],
                    'FTAjhApvCode'        => $paData['FTAjhApvCode'],
                    'FTAjhStaApv'          => $paData['FTAjhStaApv'],
                    'FTAjhStaPrcStk'             => $paData['FTAjhStaPrcStk'],
                    'FTAjhStaDoc'               => $paData['FTAjhStaDoc'],
                    'FNAjhStaDocAct'            => $paData['FNAjhStaDocAct'],
                    'FTAjhDocRef'            => $paData['FTAjhDocRef'],
                    'FTAjhStaDelMQ'         => $paData['FTAjhStaDelMQ'],
                    'FDLastUpdOn'         => $paData['FDLastUpdOn'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'              => $paData['FTCreateBy'],
                    'FTLastUpdBy'            => $paData['FTLastUpdBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    //Update HD After process  
    public function FSaMTFWUpdateOrdHD($paData,$paWhere){

        try{
            //DT Dis
            $this->db->set('FCXthTotal' , $paData['FCXthTotal']);
            $this->db->set('FCXthVatNoDisChg' , $paData['FCXthVatNoDisChg']);
            $this->db->set('FCXthNoVatNoDisChg' , $paData['FCXthNoVatNoDisChg']);
            $this->db->set('FCXthVatDisChgAvi' , $paData['FCXthVatDisChgAvi']);
            $this->db->set('FCXthNoVatDisChgAvi' , $paData['FCXthNoVatDisChgAvi']);
            $this->db->set('FTXthDisChgTxt' , $paData['FTXthDisChgTxt']);
            $this->db->set('FCXthDis' , $paData['FCXthDis']);
            $this->db->set('FCXthChg' , $paData['FCXthChg']);
            $this->db->set('FCXthRefAEAmt' , $paData['FCXthRefAEAmt']);
            $this->db->set('FCXthVatAfDisChg' , $paData['FCXthVatAfDisChg']);
            $this->db->set('FCXthNoVatAfDisChg' , $paData['FCXthNoVatAfDisChg']);
            $this->db->set('FCXthAfDisChgAE' , $paData['FCXthAfDisChgAE']);
            $this->db->set('FTXthWpCode' , $paData['FTXthWpCode']);
            $this->db->set('FCXthVat' , $paData['FCXthVat']);
            $this->db->set('FCXthVatable' , $paData['FCXthVatable']);
            $this->db->set('FCXthGrandB4Wht' , $paData['FCXthGrandB4Wht']);
            // $this->db->set('FCXthWpTax' , $paData['FCXthWpTax']);
            $this->db->set('FCXthGrand' , $paData['FCXthGrand']);
            $this->db->set('FTXthGndText' , $paData['FTXthGndText']);
            $this->db->set('FCXthLeft' , $paData['FCXthLeft']);

            $this->db->where('FTXthDocNo', $paWhere['FTXthDocNo']);
            $this->db->update('TAPTOrdHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update HD.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update HD.',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }

    }


    //Functionality : Function Add/Update OrdHDSpl
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTFWAddUpdateHDRef($paData){

        try{
            //Update Master
            $this->db->set('FTBchCode'              , $paData['FTBchCode']);
            $this->db->set('FTXthDocNo'             , $paData['FTXthDocNo']);
            $this->db->set('FTXthCtrName'           , $paData['FTXthCtrName']);
            $this->db->set('FDXthTnfDate'           , $paData['FDXthTnfDate']);
            $this->db->set('FTXthRefTnfID'          , $paData['FTXthRefTnfID']);
            $this->db->set('FTXthRefVehID'          , $paData['FTXthRefVehID']);
            $this->db->set('FTXthQtyAndTypeUnit'    , $paData['FTXthQtyAndTypeUnit']);
            $this->db->set('FNXthShipAdd'           , $paData['FNXthShipAdd']);
            $this->db->set('FTViaCode'              , $paData['FTViaCode']);

            $this->db->where('FTXthDocNo'           , $paData['FTXthDocNo']);
            $this->db->update('TCNTPdtAdjStkHDRef');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TCNTPdtAdjStkHDRef',array(

                    'FTBchCode'             => $paData['FTBchCode'],
                    'FTXthDocNo'            => $paData['FTXthDocNo'],
                    'FTXthCtrName'          => $paData['FTXthCtrName'],
                    'FDXthTnfDate'          => $paData['FDXthTnfDate'],
                    'FTXthRefTnfID'         => $paData['FTXthRefTnfID'],
                    'FTXthRefVehID'         => $paData['FTXthRefVehID'],
                    'FTXthQtyAndTypeUnit'   => $paData['FTXthQtyAndTypeUnit'],
                    'FNXthShipAdd'          => $paData['FNXthShipAdd'],
                    'FTViaCode'             => $paData['FTViaCode']

                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    public function FSxMClearPdtInTmp(){
        $tSQL = "DELETE FROM TCNTDocDTTmp WHERE FTSessionID = '".$this->session->userdata('tSesSessionID')."' AND FTXthDocKey = 'TCNTPdtAdjStkHD'";
        $this->db->query($tSQL);
    }

    //Functionality : Function Add/Update OrdHDDis
    //Parameters : function parameters
    //Creator : 12/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTFWAddUpdateHDDis($paData){

        //Add Master
        $this->db->insert('TAPTOrdHDDis',array(

            'FTBchCode'             => $paData['FTBchCode'],
            'FTXthDocNo'            => $paData['FTXthDocNo'],
            'FDXthDateIns'          => $paData['FDXthDateIns'],
            'FTXthDisChgTxt'        => $paData['FTXthDisChgTxt'],
            'FNXthStaDis'           => $paData['FNXthStaDis'],
            'FCXthVatDisChgAvi'     => $paData['FCXthVatDisChgAvi'],
            'FCXthNoVatDisChgAvi'   => $paData['FCXthNoVatDisChgAvi'],
            'FCXthDis'              => $paData['FCXthDis'],
            'FCXthChg'              => $paData['FCXthChg'],
            'FCXthDisVat'           => $paData['FCXthDisVat'],
            'FCXthDisNoVat'         => $paData['FCXthDisNoVat'],
            'FCXthChgVat'           => $paData['FCXthChgVat'],
            'FCXthChgNoVat'         => $paData['FCXthChgNoVat'],
            'FTXthUsrApv'           => $paData['FTXthUsrApv'],

        ));
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Master Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }

}

    //Functionality : Function Add/Update OrdDT
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTFWAddUpdateOrdDT($paData){

        //Add Master
        $this->db->insert('TVDTPdtTwxDT',array(

            'FTBchCode'             => $paData['FTBchCode'],
            'FTXthDocNo'            => $paData['FTXthDocNo'],
            'FNXpdSeqNo'            => $paData['FNXpdSeqNo'],
            'FTPdtCode'             => $paData['FTPdtCode'],
            'FTXpdPdtName'          => $paData['FTXpdPdtName'],
            'FTXpdStkCode'          => $paData['FTXpdStkCode'],
            'FCXpdStkFac'           => $paData['FCXpdStkFac'],
            'FTPunCode'             => $paData['FTPunCode'],
            'FTPunName'             => $paData['FTPunName'],
            'FCXpdFactor'           => $paData['FCXpdFactor'],
            'FTXpdBarCode'          => $paData['FTXpdBarCode'],
            'FTSrnCode'             => $paData['FTSrnCode'],
            'FTXpdVatType'          => $paData['FTXpdVatType'],
            'FTVatCode'             => $paData['FTVatCode'],
            'FCXpdVatRate'          => $paData['FCXpdVatRate'],
            'FTXpdSaleType'         => $paData['FTXpdSaleType'],
            'FCXpdSalePrice'        => $paData['FCXpdSalePrice'],
            'FCXpdQty'              => $paData['FCXpdQty'],
            'FCXpdQtyAll'           => $paData['FCXpdQtyAll'],
            'FCXpdSetPrice'         => $paData['FCXpdSetPrice'],
            'FCXpdAmt'              => $paData['FCXpdAmt'],
            'FCXpdDisChgAvi'        => $paData['FCXpdDisChgAvi'],
            'FTXpdDisChgTxt'        => $paData['FTXpdDisChgTxt'],
            'FCXpdDis'              => $paData['FCXpdDis'],
            'FCXpdChg'              => $paData['FCXpdChg'],
            'FCXpdNet'              => $paData['FCXpdNet'],
            'FCXpdNetAfHD'          => $paData['FCXpdNetAfHD'],
            'FCXpdNetEx'            => $paData['FCXpdNetEx'],
            'FCXpdVat'              => $paData['FCXpdVat'],
            'FCXpdVatable'          => $paData['FCXpdVatable'],
            'FCXpdWhtAmt'           => $paData['FCXpdWhtAmt'],
            'FTXpdWhtCode'          => $paData['FTXpdWhtCode'],
            'FCXpdWhtRate'          => $paData['FCXpdWhtRate'],
            'FCXpdCostIn'           => $paData['FCXpdCostIn'],
            'FCXpdCostEx'           => $paData['FCXpdCostEx'],
            'FTXpdStaPdt'           => $paData['FTXpdStaPdt'],
            'FCXpdQtyLef'           => $paData['FCXpdQtyLef'],
            'FCXpdQtyRfn'           => $paData['FCXpdQtyRfn'],
            'FTXpdStaPrcStk'        => $paData['FTXpdStaPrcStk'],
            'FTXpdStaAlwDis'        => $paData['FTXpdStaAlwDis'],
            'FNXpdPdtLevel'         => $paData['FNXpdPdtLevel'],
            'FTXpdPdtParent'        => $paData['FTXpdPdtParent'],
            'FCXpdQtySet'           => $paData['FCXpdQtySet'],
            'FTPdtStaSet'           => $paData['FTPdtStaSet'],
            'FTXpdRmk'              => $paData['FTXpdRmk'],
            'FDLastUpdOn'           => $paData['FDLastUpdOn'],
            'FTLastUpdBy'           => $paData['FTLastUpdBy'],
            'FDCreateOn'            => $paData['FDCreateOn'],
            'FTCreateBy'            => $paData['FTCreateBy']


        ));
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Master Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }

    }


    //Functionality : Function Update OrdDT DisChgTxt,Dis,Chg
    //Parameters : function parameters
    //Creator : 05/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Update Master
    //Return Type : array
    public function FSaMTFWUpdateOrdDT($paData,$paWhere){

            try{
                //DT Dis
                $this->db->set('FTXpdDisChgTxt' , $paData['FTXpdDisChgTxt']);
                $this->db->set('FCXpdDis' , $paData['FCXpdDis']);
                $this->db->set('FCXpdChg' , $paData['FCXpdChg']);
                $this->db->set('FCXpdNet' , $paData['FCXpdNet']);
                $this->db->set('FCXpdNetAfHD' , $paData['FCXpdNetAfHD']);
                $this->db->set('FCXpdVat' , $paData['FCXpdVat']);
                $this->db->set('FCXpdVatable' , $paData['FCXpdVatable']);
                $this->db->set('FCXpdWhtAmt' , $paData['FCXpdWhtAmt']);
                $this->db->set('FCXpdCostIn' , $paData['FCXpdCostIn']);
                $this->db->set('FCXpdCostEx' , $paData['FCXpdCostEx']);
                $this->db->set('FCXpdQtyLef' , $paData['FCXpdQtyLef']);
                $this->db->set('FCXpdNetEx' , $paData['FCXpdNetEx']);

                $this->db->where('FTXthDocNo', $paWhere['FTXthDocNo']);
                $this->db->where('FNXpdSeqNo', $paWhere['FNXpdSeqNo']);
                $this->db->update('TAPTOrdDT');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update DT.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '903',
                        'rtDesc' => 'Not Update DT.',
                    );
                }
                return $aStatus;
            }catch(Exception $Error){
                return $Error;
            }

    }


    //Functionality : Function Add/Update TAPTOrdDTDis
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTFWAddUpdateOrdDTDis($paData){

            //Add Master
            $this->db->insert('TAPTOrdDTDis',array(

                'FTBchCode'             => $paData['FTBchCode'],
                'FTXthDocNo'            => $paData['FTXthDocNo'],
                'FNXpdSeqNo'            => $paData['FNXpdSeqNo'],
                'FDXddDateIns'          => $paData['FDXddDateIns'],
                'FNXpdStaDis'           => $paData['FNXpdStaDis'],
                'FCXddDisChgAvi'        => $paData['FCXddDisChgAvi'],
                'FTXddDisChgTxt'        => $paData['FTXddDisChgTxt'],
                'FCXddDis'              => $paData['FCXddDis'],
                'FCXddChg'              => $paData['FCXddChg'],
                'FTXddUsrApv'           => $paData['FTXddUsrApv']

            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }

    }


    //Functionality : Delete DT
    //Parameters : function parameters
    //Creator : 17/07/2018 Krit
    //Return : response
    //Return Type : array
    public function FSnMPMTDelPcoDT($ptXthDocNo){

        $this->db->where_in('FTXthDocNo', $ptXthDocNo);
        $this->db->delete('TAPTOrdDT');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }


    //Functionality : Delete DT Dis
    //Parameters : function parameters
    //Creator : 17/07/2018 Krit
    //Return : response
    //Return Type : array
    public function FSnMPMTDelPcoDTDis($ptXthDocNo){

        $this->db->where_in('FTXthDocNo', $ptXthDocNo);
        $this->db->delete('TAPTOrdDTDis');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }


    //Functionality : Delete DT Dis
    //Parameters : function parameters
    //Creator : 17/07/2018 Krit
    //Return : response
    //Return Type : array
    public function FSnMPMTDelPcoHDDis($ptXthDocNo){

        $this->db->where_in('FTXthDocNo', $ptXthDocNo);
        $this->db->delete('TAPTOrdHDDis');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }


    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMSDTAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTSudName' , $paData['FTSudName']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTSudCode', $paData['FTSudCode']);
            $this->db->update('TCNMSubDistrict_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                //Add Lang
                $this->db->insert('TCNMSubDistrict_L',array(
                    'FTSudCode' => $paData['FTSudCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTSudName' => $paData['FTSudName']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Delete PurchaseOrder
    //Parameters : function parameters
    //Creator : 29/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSnMTFWDel($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->delete('TCNTPdtAdjStkHD');

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->delete('TCNTPdtAdjStkHDRef');

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->delete('TVDTPdtTwxDT');

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->delete('TCNTDocDTTmp');
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Delete PurchaseOrder
    //Parameters : function parameters
    //Creator : 04/04/2019 Krit(Copter)
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSnMTFWDelDTTmp($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->where_in('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            $this->db->where_in('FTPdtCode',  $paData['FTPdtCode']);
            $this->db->where_in('FTSessionID',$paData['FTSessionID']);
            $this->db->delete('TCNTDocDTTmp');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    //Functionality : Multi Pdt Del Temp
    //Parameters : function parameters
    //Creator : 25/03/2019 Krit(Copter)
    //Return : Status Delete
    //Return Type : array
    public function FSaMTFWPdtTmpMultiDel($paData){
        try{
            $this->db->trans_begin();

            //Del DTTmp
            $this->db->where('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->where('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            $this->db->where('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->delete('TCNTDocDTTmp');

            //Del DTDisTmp
            $this->db->where('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->where('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            $this->db->delete('TCNTDocDTDisTmp');
              
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    public function FSnMTFWGetDocType($ptTableName){

        $tSQL = "SELECT FNSdtDocType FROM TSysDocType WITH (NOLOCK) WHERE FTSdtTblName='$ptTableName'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $nDetail = $oDetail[0]->FNSdtDocType;
          
        }else{
            $nDetail = '';
        }

        return $nDetail;
       
    }


    // public function FSaMTWFGeTInforTwxHD($ptDocNo){
    //     $tSQL = "SELECT * FROM TCNTPdtAdjStkHD WHERE FTXthDocNo = '".$ptDocNo."'";
    //     $oQuery = $this->db->query($tSQL);
    //     if($oQuery->num_rows() > 0){
    //         return $oQuery->row_array();
    //     }else{
    //         return false;
    //     }
    // }

    // public function FSaMTWFGeTInforTwxHDRef($ptDocNo){
    //     $tSQL = "SELECT * FROM TCNTPdtAdjStkHDRef WHERE FTXthDocNo = '".$ptDocNo."'";
    //     $oQuery = $this->db->query($tSQL);
    //     if($oQuery->num_rows() > 0){
    //         return $oQuery->row_array();
    //     }else{
    //         return false;
    //     }
    // }

    // public function FSaMTWFGeTInforTwxDT($ptDocNo){
    //     $tSQL = "SELECT * FROM TVDTPdtTwxDT WHERE FTXthDocNo = '".$ptDocNo."'";
    //     $oQuery = $this->db->query($tSQL);
    //     if($oQuery->num_rows() > 0){
    //         return $oQuery->result_array();
    //     }else{
    //         return false;
    //     }
    // }

    
    public function FSxMTFXClearDocTemForChngCdt($pInforData){
        $tSQL = "DELETE FROM TCNTDocDTTmp 
                 WHERE FTBchCode = '".$pInforData["tbrachCode"]."' AND
                       FTXthDocNo = '".$pInforData["tFTXthDocNo"]."' AND
                       FTXthDocKey = '".$pInforData["tDockey"]."' AND
                       FTSessionID = '".$pInforData["tSession"]."'
                ";
        $this->db->query($tSQL);
    }

    public function FSxMTWXCheckViaCodeForApv($ptDocNo){
        $tSQL = "SELECT FTViaCode FROM TCNTPdtAdjStkHDRef WITH (NOLOCK) WHERE FTXthDocNo = '".$ptDocNo."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
        }else{
            $aDetail = false;
        }
        return $aDetail;
    }

    public function FSaMTWXVDGetPdtLayout($paInfoWhere){
        $tSQL = "SELECT TVDTPdtPlanelRow.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FNLayRow,FNLayCol) AS FNRowID,* FROM
                        (
                            SELECT 
                                PDT.FTPdtCode,
                                PDTL.FTPdtName,
                                PDTLYO.FNLayRow,
                                PDTLYO.FNLayCol,
                                PDTLYO.FCLayColQtyMax, 
                                PDTLYO.FNCabSeq,
                                (SELECT FCStkQty FROM TVDTPdtStkBal WHERE FTWahCode = '".$paInfoWhere["tWahCode"]."' 
                                AND FTBchCode = '".$paInfoWhere["tBchCode"]."'
                                AND FNLayRow = PDTLYO.FNLayRow
                                AND FNLayCol = PDTLYO.FNLayCol
                                AND FTPdtCode = PDTLYO.FTPdtCode) AS FCStkQty
                            FROM TVDMPdtLayout PDTLYO LEFT JOIN TCNMPdt PDT ON PDTLYO.FTPdtCode = PDT.FTPdtCode
                            LEFT JOIN TCNMPdt_L PDTL ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '".$paInfoWhere["nLangID"]."'
                            WHERE PDTLYO.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                            AND PDTLYO.FTShpCode = '".$paInfoWhere["tShpCode"]."'
                        ) AS TVDTPdtPlanel
                ) AS TVDTPdtPlanelRow WHERE FNRowID>=".((($paInfoWhere["nPage"]-1)*5)+1)." AND 
                FNRowID<=".($paInfoWhere["nPage"]*5);
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->result_array();
            $tSQL = "SELECT COUNT(PDT.FTPdtCode) AS FNCountRow
                        FROM TVDMPdtLayout PDTLYO
                        LEFT JOIN TCNMPdt PDT
                        ON PDTLYO.FTPdtCode = PDT.FTPdtCode
                        LEFT JOIN TCNMPdt_L PDTL
                        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '".$paInfoWhere["nLangID"]."'
                        WHERE PDTLYO.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                        AND PDTLYO.FTShpCode = '".$paInfoWhere["tShpCode"]."'";
            $oQuery = $this->db->query($tSQL);
            $aDetailRow = $oQuery->row_array()["FNCountRow"];
        }else{
            $aDetail = false;
            $aDetailRow = 0;
        }
        return array("aDetail"=>$aDetail,"aDetailRow"=>$aDetailRow);

    }

    public function FSaMTWXVDGetPdtLayoutFRomTem($paInfoWhere){
        $tSQL = "SELECT TVDTPdtPlanelRow.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FNCabSeqForTWXVD,FNLayRowForADJSTKVD,FNLayColForADJSTKVD) AS FNRowID,* FROM
                        (
                            SELECT 
                                TMP.FTPdtCode,
                                TMP.FTXtdPdtName AS FTPdtName,
                                TMP.FNLayRowForADJSTKVD,
                                TMP.FNLayColForADJSTKVD,
                                TMP.FCLayColQtyMaxForADJSTKVD, 
                                TMP.FCStkQty,
                                TMP.FCUserInPutForADJSTKVD,
                                TMP.FCDateTimeInputForADJSTKVD,
                                TMP.FNCabSeqForTWXVD,
                                CABL.FTCabName
                            FROM TCNTDocDTTmp TMP
                            LEFT JOIN TVDMShopCabinet_L CABL ON TMP.FNCabSeqForTWXVD = CABL.FNCabSeq AND TMP.FTBchCode = CABL.FTBchCode AND FNLngID = 1
                            WHERE TMP.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                            AND TMP.FTXthDocNo = '".$paInfoWhere["tXthDocNo"]."'
                            AND TMP.FTXthDocKey = '".$paInfoWhere["FTXthDocKey"]."'
                            AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                        ) AS TVDTPdtPlanel
                ) AS TVDTPdtPlanelRow WHERE TVDTPdtPlanelRow.FNRowID>=".((($paInfoWhere["nPage"]-1)*10)+1)." AND 
                TVDTPdtPlanelRow.FNRowID<=".($paInfoWhere["nPage"]*10);
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->result_array();
            // $tSQL = "SELECT 
            //             COUNT(TMP.FTPdtCode) AS FNCountRow
            //         FROM TCNTDocDTTmp TMP
            //         WHERE TMP.FTBchCode = '".$paInfoWhere["tBchCode"]."'
            //         AND TMP.FTXthDocNo = '".$paInfoWhere["tXthDocNo"]."'
            //         AND TMP.FTXthDocKey = '".$paInfoWhere["FTXthDocKey"]."'
            //         AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'";
            // echo $tSQL;
            // exit;
            // $oQuery = $this->db->query($tSQL);
            // $aDetailRow = $oQuery->row_array()["FNCountRow"];
            $aDetailRow = $oQuery->num_rows();
        }else{
            $aDetail = false;
            $aDetailRow = 0;
        }
        return array("aDetail"=>$aDetail,"aDetailRow"=>$aDetailRow);

    }

    public function FSaMTWXVDGetPdtLayoutToTem($paInfoWhere){
        $tSQL = "SELECT PDT.FTPdtCode,
                                PDTL.FTPdtName,
                                PDTLYO.FNLayRow,
                                PDTLYO.FNLayCol,
                                PDTLYO.FCLayColQtyMax, 
                                PDTLYO.FNCabSeq,
                                ISNULL( 
                                    (SELECT FCStkQty FROM TVDTPdtStkBal WHERE FTWahCode = '".$paInfoWhere["tWahCode"]."' 
                                    AND FTBchCode = '".$paInfoWhere["tBchCode"]."'
                                    AND FNLayRow = PDTLYO.FNLayRow
                                    AND FNLayCol = PDTLYO.FNLayCol
                                    AND FTPdtCode = PDTLYO.FTPdtCode),0
                                ) AS FCStkQty
                            FROM TVDMPdtLayout PDTLYO LEFT JOIN TCNMPdt PDT ON PDTLYO.FTPdtCode = PDT.FTPdtCode
                            LEFT JOIN TCNMPdt_L PDTL ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '".$paInfoWhere["nLangID"]."'
                            WHERE PDTLYO.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                            AND PDTLYO.FTShpCode = '".$paInfoWhere["tShpCode"]."'  
                            AND PDTLYO.FTPdtCode != '' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->result_array();
        }else{
            $aDetail = false;
        }
        return $aDetail;

    }

    public function FSxMUpdateDocTmpPdtFromDT($aDataInsert){
        $tSQL = "INSERT INTO TCNTDocDTTmp(
                    FTBchCode,
                    FTXthDocNo,
                    FNXtdSeqNo,
                    FTXthDocKey,
                    FTPdtCode,
                    FTXtdPdtName,
                    FCStkQty,
                    FNLayRowForADJSTKVD,
                    FNLayColForADJSTKVD,
                    FCLayColQtyMaxForADJSTKVD,
                    FCUserInPutForADJSTKVD,
                    FCDateTimeInputForADJSTKVD,
                    FNCabSeqForTWXVD,
                    FTSessionID
                ) 
                 VALUES(
                     '".$aDataInsert["FTBchCode"]."',
                     '".$aDataInsert["FTXthDocNo"]."',
                     ".$aDataInsert["FNXtdSeqNo"].",
                     '".$aDataInsert["FTXthDocKey"]."',
                     '".$aDataInsert["FTPdtCode"]."',
                     '".$aDataInsert["FTXtdPdtName"]."',
                     ".$aDataInsert["FCStkQty"].",
                     ".$aDataInsert["FNLayRowForADJSTKVD"].",
                     ".$aDataInsert["FNLayColForADJSTKVD"].",
                     ".$aDataInsert["FCLayColQtyMaxForADJSTKVD"].",
                     ".$aDataInsert["FCUserInPutForADJSTKVD"].",
                     NULL,
                     '".$aDataInsert["FNCabSeq"]."',
                     '".$this->session->userdata('tSesSessionID')."'
                 )";
        $this->db->query($tSQL);
    }

    public function FSxMDeleteDoctemForNewEvent($paInfor){
        $tSQL = "DELETE FROM TCNTDocDTTmp WHERE
                FTBchCode = '".$paInfor["tBchCode"]."' AND
                FTSessionID = '".$this->session->userdata('tSesSessionID')."' AND
                FTXthDocKey = '".$paInfor["FTXthDocKey"]."'";
        $this->db->query($tSQL);
    }

    public function FSxMGetDataFromDtToTmp($paInfor){
        $tSQL = "SELECT FNLayRow,FNLayCol,FCXtdQty FROM TVDTPdtTwxDT
                WHERE FTBchCode = '".$paInfor["tBchCode"]."'
                AND   FTXthDocNo = '".$paInfor["tXthDocNo"]."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
           $aDetail = $oQuery->result_array();
        }else{
           $aDetail = false;
        }
        return $aDetail;
    }

    public function FSnMGetStkPdt($paInfoWhere){
        $tSQL = "SELECT FCStkQty FROM TCNTPdtStkBal 
                 WHERE TCNTPdtStkBal.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                 AND TCNTPdtStkBal.FTWahCode = '".$paInfoWhere["tWahCode"]."'
                 AND TCNTPdtStkBal.FTPdtCode = '".$paInfoWhere["tPdtCode"]."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array()["FCStkQty"];
        }else{
            $aDetail = 0;
        }
        return $aDetail;
    }

    public function FSaMTWXVDGetRealTransferPosStart($paInfoWhere){
        $tSQL = "SELECT PDT.FTPdtCode,
                        PDTL.FTPdtName,
                        PDTLYO.FNLayRow,
                        PDTLYO.FNLayCol,
                        PDTLYO.FCLayColQtyMax, 
                        PDTLYO.FNCabSeq,
                        ISNULL(
                            (SELECT FCStkQty FROM TVDTPdtStkBal WHERE FTWahCode = '".$paInfoWhere["tWahCodeStart"]."' 
                        AND FTBchCode = '".$paInfoWhere["tBchCode"]."'
                        AND FNLayRow = PDTLYO.FNLayRow
                        AND FNLayCol = PDTLYO.FNLayCol
                        AND FTPdtCode = PDTLYO.FTPdtCode),0) AS FCStkQty
                FROM TVDMPdtLayout PDTLYO
                LEFT JOIN TCNMPdt PDT
                ON PDTLYO.FTPdtCode = PDT.FTPdtCode
                LEFT JOIN TCNMPdt_L PDTL
                ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '".$paInfoWhere["nLangID"]."'
                WHERE PDTLYO.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                AND PDTLYO.FTShpCode = '".$paInfoWhere["tSchCodeStart"]."'
                AND PDTLYO.FNLayRow = '".$paInfoWhere["aData"]["FNLayRow"]."'
                AND PDTLYO.FNLayCol = '".$paInfoWhere["aData"]["FNLayCol"]."'
                AND PDTLYO.FTPdtCode = '".$paInfoWhere["aData"]["FTPdtCode"]."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
        }else{
            $aDetail = false;
        }
        return $aDetail;
    }

    public function FSxMUpdateTmpMaxTransfer($aData){
        $tSQL = "UPDATE TCNTDocDTTmp SET
                FCUserInPutForADJSTKVD = ".$aData["FCUserInPutForADJSTKVD"].",
                FCDateTimeInputForADJSTKVD = '".$aData["FCDateTimeInputForADJSTKVD"]."'
                WHERE FTBchCode = '".$aData["FTBchCode"]."'
                AND FTXthDocNo = '".$aData["FTXthDocNo"]."'
                AND FNLayRowForADJSTKVD = ".$aData["FNLayRowForADJSTKVD"]."
                AND FNLayColForADJSTKVD = ".$aData["FNLayColForADJSTKVD"]."
                AND FTXthDocKey = '".$aData["FTXthDocKey"]."'
                AND FTSessionID = '".$aData["FTSessionID"]."'
                AND FNCabSeqForTWXVD = '".$aData["FNCabSeqForTWXVD"]."' ";
        $this->db->query($tSQL);
    }


}

