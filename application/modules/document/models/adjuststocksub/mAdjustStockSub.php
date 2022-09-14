<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mAdjustStockSub extends CI_Model
{
    /**
     * Functionality : Data List Product Adjust Stock HD
     * Parameters : function parameters
     * Creator :  22/05/2019 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSaMAdjStkSubList($paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        ADJSTK.FTBchCode,
                        BCHL.FTBchName,
                        ADJSTK.FTAjhDocNo,
                        CONVERT(CHAR(10), ADJSTK.FDAjhDocDate, 103) AS FDAjhDocDate,
                        CONVERT(CHAR(5), ADJSTK.FDAjhDocDate, 108) AS FTAjhDocTime,
                        ADJSTK.FTAjhStaDoc,
                        ADJSTK.FTAjhStaApv,
                        ADJSTK.FTAjhStaPrcStk,
                        ADJSTK.FTCreateBy,
                        USRL.FTUsrName AS FTCreateByName,
                        ADJSTK.FTAjhApvCode,
                        USRLAPV.FTUsrName AS FTAjhApvName,
                        ADJSTK.FDCreateOn

                    FROM [TCNTPdtAdjStkHD] ADJSTK WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON ADJSTK.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON ADJSTK.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON ADJSTK.FTAjhApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID

                    WHERE 1=1
                    AND ADJSTK.FTAjhDocType = '1'
        ";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {
            $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND ADJSTK.FTBchCode IN ($tBchMulti)";
        }

        $aAdvanceSearch = $paData['oAdvanceSearch'];

        $tSearchList = isset($aAdvanceSearch['tSearchAll'])?$aAdvanceSearch['tSearchAll']:'';
        if (!empty($tSearchList)) {
            $tSQL .= " AND ((ADJSTK.FTAjhDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),ADJSTK.FDAjhDocDate,103) LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((ADJSTK.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (ADJSTK.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((ADJSTK.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (ADJSTK.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            switch($tSearchStaDoc){
                case "1": {
                    $tSQL .= " AND (ADJSTK.FTAjhStaDoc <> '3' AND ADJSTK.FTAjhStaApv = '1')";
                    break;
                }
                case "2": {
                    $tSQL .= " AND (ADJSTK.FTAjhStaDoc <> '3' AND ISNULL(ADJSTK.FTAjhStaApv,'') = '')";
                    break;
                }
                case "3": {
                    $tSQL .= " AND ADJSTK.FTAjhStaDoc = '3'";
                    break;
                }
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if(!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")){
            if($tSearchStaDocAct == 1){
                $tSQL .= " AND ADJSTK.FNAjhStaDocAct = 1";
            }else{
                $tSQL .= " AND ADJSTK.FNAjhStaDocAct = 0";
            }
        }

        // สถานะอนุมัติ
        // $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        // if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
        //     if ($tSearchStaApprove == 2) {
        //         $tSQL .= " AND ADJSTK.FTAjhStaApv = '$tSearchStaApprove' OR ADJSTK.FTAjhStaApv = '' ";
        //     } else {
        //         $tSQL .= " AND ADJSTK.FTAjhStaApv = '$tSearchStaApprove'";
        //     }
        // }

        //สถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND ADJSTK.FTAjhStaPrcStk = '$tSearchStaPrcStk' OR ADJSTK.FTAjhStaPrcStk = '' ";
            }else{
                $tSQL .= " AND ADJSTK.FTAjhStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMAdjStkSubGetPageAll($paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : All Page Of Product Adjust Stock HD
     * Parameters : function parameters
     * Creator :  12/06/2018 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSnMAdjStkSubGetPageAll($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                COUNT (ADJSTK.FTAjhDocNo) AS counts
            FROM [TCNTPdtAdjStkHD] ADJSTK WITH (NOLOCK)
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON ADJSTK.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
            WHERE 1=1
            AND FTAjhDocType = '1'
        ";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {
            $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND ADJSTK.FTBchCode IN ($tBchMulti)";
        }

        $aAdvanceSearch = $paData['oAdvanceSearch'];

        $tSearchList = isset($aAdvanceSearch['tSearchAll'])?$aAdvanceSearch['tSearchAll']:'';
        if (!empty($tSearchList)) {
            $tSQL .= " AND ((ADJSTK.FTAjhDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),ADJSTK.FDAjhDocDate,103) LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((ADJSTK.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (ADJSTK.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((ADJSTK.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (ADJSTK.FDAjhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            switch($tSearchStaDoc){
                case "1": {
                    $tSQL .= " AND (ADJSTK.FTAjhStaDoc <> '3' AND ADJSTK.FTAjhStaApv = '1')";
                    break;
                }
                case "2": {
                    $tSQL .= " AND (ADJSTK.FTAjhStaDoc <> '3' AND ISNULL(ADJSTK.FTAjhStaApv,'') = '')";
                    break;
                }
                case "3": {
                    $tSQL .= " AND ADJSTK.FTAjhStaDoc = '3'";
                    break;
                }
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if(!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")){
            if($tSearchStaDocAct == 1){
                $tSQL .= " AND ADJSTK.FNAjhStaDocAct = 1";
            }else{
                $tSQL .= " AND ADJSTK.FNAjhStaDocAct = 0";
            }
        }

        // สถานะอนุมัติ
        // $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        // if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
        //     if ($tSearchStaApprove == 2) {
        //         $tSQL .= " AND ADJSTK.FTAjhStaApv = '$tSearchStaApprove' OR ADJSTK.FTAjhStaApv = '' ";
        //     } else {
        //         $tSQL .= " AND ADJSTK.FTAjhStaApv = '$tSearchStaApprove'";
        //     }
        // }

        // สถานะประมวลผล
        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
        //     if($tSearchStaPrcStk == 3){
        //         $tSQL .= " AND ADJSTK.FTAjhStaPrcStk = '$tSearchStaPrcStk' OR ADJSTK.FTAjhStaPrcStk = '' ";
        //     }else{
        //         $tSQL .= " AND ADJSTK.FTAjhStaPrcStk = '$tSearchStaPrcStk'";
        //     }
        // }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else { // No Data
            return false;
        }
    }

    //Functionality : Function Get Count From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMAdjStkSubGetCountDTTemp($paDataWhere)
    {
        $tSQL = "SELECT
                        COUNT(DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1
                    ";

        $tAjhDocNo      = $paDataWhere['FTAjhDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tAjhDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result_array();
            $aResult = $oDetail[0]['counts'];
        } else {
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
    public function FSaMAdjStkSubSumDTTemp($paDataWhere)
    {

        $tAjhDocNo      = $paDataWhere['FTAjhDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "SELECT SUM(FCXtdAmt) AS FCXtdAmt
                 FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                 WHERE 1 = 1
                ";

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tAjhDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oResult = $oQuery->result_array();
        } else {
            $oResult = '';
        }


        return $oResult;
    }

    /**
     * Functionality : Function Add DT To Temp
     * Parameters : function parameters
     * Creator : 29/05/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMAdjStkSubInsertTmpToDT($paDataWhere)
    {

        // ทำการลบ ใน DT ก่อนการย้าย Tmp ไป DT
        if ($paDataWhere['FTAjhDocNo'] != '') {
            $this->db->where_in('FTAjhDocNo', $paDataWhere['FTAjhDocNo']);
            $this->db->delete('TCNTPdtAdjStkDT');
        }

        $tSQL = "INSERT TCNTPdtAdjStkDT
                            (FTBchCode, FTAjhDocNo, FNAjdSeqNo, FTPdtCode, FTPdtName, FTPunName, FTAjdBarcode, FTPunCode,
                            FCPdtUnitFact, FTPgpChain, FTAjdPlcCode, FNAjdLayRow, FNAjdLayCol, FCAjdWahB4Adj, /*FCAjdSaleB4AdjC1,*/
                            FDAjdDateTimeC1, FCAjdUnitQtyC1, FCAjdQtyAllC1, /*FCAjdSaleB4AdjC2,*/ FDAjdDateTimeC2, FCAjdUnitQtyC2, FCAjdQtyAllC2, FCAjdUnitQty,
                            FCAjdQtyAll/*, FCAjdQtyAllDiff*/, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy) ";

        $tSQL .= "SELECT
                            DOCTMP.FTBchCode,
                            DOCTMP.FTXthDocNo AS FTAjhDocNo,
                            -- ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNAjdSeqNo,
                            DOCTMP.FNXtdSeqNo,
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTPunName,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FTPunCode,
                            DOCTMP.FCPdtUnitFact,
                            DOCTMP.FTPgpChain,
                            DOCTMP.FTAjdPlcCode,
                            0,
                            0,
                            DOCTMP.FCAjdWahB4Adj,
                            /*DOCTMP.FCAjdSaleB4AdjC1,*/
                            DOCTMP.FDAjdDateTimeC1,
                            DOCTMP.FCAjdUnitQtyC1,
                            (DOCTMP.FCAjdUnitQtyC1*DOCTMP.FCPdtUnitFact) AS FCAjdQtyAllC1,
                            /*DOCTMP.FCAjdSaleB4AdjC2,*/
                            DOCTMP.FDAjdDateTimeC2,
                            DOCTMP.FCAjdUnitQtyC2,
                            (DOCTMP.FCAjdUnitQtyC2*DOCTMP.FCPdtUnitFact) AS FCAjdQtyAllC2,
                            DOCTMP.FCAjdUnitQty,
                            DOCTMP.FCAjdQtyAll,
                            /*DOCTMP.FCAjdQtyAllDiff,*/
                            DOCTMP.FDLastUpdOn,
                            DOCTMP.FTLastUpdBy,
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTCreateBy

                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1
                    ";

        $tAjhDocNo      = $paDataWhere['FTAjhDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $paDataWhere['FTSessionID'];


        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tAjhDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " ORDER BY DOCTMP.FNXtdSeqNo ASC";


        $oQuery = $this->db->query($tSQL);

        if ($oQuery > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }
        return $aStatus;
    }


        /**
     * Functionality : Function Add DT To Temp
     * Parameters : function parameters
     * Creator : 29/05/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMAdjStkSubInsertTmpToDTFhn($paDataWhere)
    {

        // ทำการลบ ใน DT ก่อนการย้าย Tmp ไป DT
        if ($paDataWhere['FTAjhDocNo'] != '') {
            $this->db->where_in('FTAjhDocNo', $paDataWhere['FTAjhDocNo']);
            $this->db->delete('TCNTPdtAdjStkDTFhn');
        }

        $tSQL = "INSERT TCNTPdtAdjStkDTFhn
                            (FTBchCode, FTAjhDocNo, FNAjdSeqNo, FTPdtCode,FTFhnRefCode, FTPdtName, FTAjdBarcode,FTAjdPlcCode,
                            FDAjdDateTimeC1, FCAjdQtyC1,  FDAjdDateTimeC2, FCAjdQtyC2,
                            FCAjdQtyAll, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy) ";

        $tSQL .= "SELECT
                            DOCTMP.FTBchCode,
                            DOCTMP.FTXshDocNo AS FTAjhDocNo,
                            DOCTMP.FNXsdSeqNo AS FNAjdSeqNo,
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTFhnRefCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTXtdBarCode,
                            (SELECT TOP 1 FTAjdPlcCode FROM TCNTPdtAdjStkDT STKDT WITH (NOLOCK) WHERE STKDT.FTBchCode =DOCTMP.FTBchCode AND STKDT.FTAjhDocNo = DOCTMP.FTXshDocNo AND STKDT.FTPdtCode = DOCTMP.FTPdtCode)  AS FTAjdPlcCode,
                            DOCTMP.FDAjdDateTimeC1,
                            DOCTMP.FCAjdUnitQtyC1,
                        
                            DOCTMP.FDAjdDateTimeC2,
                            DOCTMP.FCAjdUnitQtyC2,

                            DOCTMP.FCAjdQtyAll,
                      
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTCreateBy,
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTCreateBy

                    FROM TCNTDocDTFhnTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1
                    ";

        $tAjhDocNo      = $paDataWhere['FTAjhDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $paDataWhere['FTSessionID'];


        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $tSQL .= " AND DOCTMP.FTXshDocNo = '$tAjhDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " ORDER BY DOCTMP.FNXsdSeqNo ASC";


        $oQuery = $this->db->query($tSQL);
  
        if ($oQuery > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }
        return $aStatus;
    }



    //Functionality: Get available column for showing in grid table
    //Parameters:  Function Parameter
    //Creator: 
    //Last Modified : 20/1/2020 เนลว์  
    //Return : 
    //Return Type: Array
    public function FSaMAdjGetBarCodeByRefCodePdtFhn($ptDataPdtFhn){
        $tPdtCode =  $ptDataPdtFhn['FTPdtCode']; 
        $tFhnRefCode =  $ptDataPdtFhn['FTFhnRefCode'];
        $nFhnSeq =  $ptDataPdtFhn['FNFhnSeq'];
        
        $tBarCodeQuery = $this->db->where('FTPdtCode',$tPdtCode)->where('FTFhnRefCode',$tFhnRefCode)->where('FNBarRefSeq',$nFhnSeq)->order_by('FDCreateOn','ASC')->limit(1)->get('TCNMPdtBar');
        if($tBarCodeQuery->num_rows()>0){
            $tBarCode = $tBarCodeQuery->row_array()['FTBarCode'];
        }else{
            $tBarCode = '';
        }
        return $tBarCode;
    }


    /**
     * Functionality : Function Get Pdt From Temp
     * Parameters : function parameters
     * Creator : 22/05/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMAdjStkSubGetDTTempListPage($paData)
    {
        try {
            $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $tSQL = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM
                            (SELECT DOCTMP.FTBchCode,
                                    DOCTMP.FTXthDocNo,
                                    DOCTMP.FNXtdSeqNo,
                                    DOCTMP.FTXthDocKey,
                                    DOCTMP.FTTmpStatus,
                                    DOCTMP.FTPdtCode,
                                    DOCTMP.FTXtdPdtName,
                                    DOCTMP.FTPunName,
                                    DOCTMP.FTXtdBarCode,
                                    DOCTMP.FTPunCode,
                                    DOCTMP.FCPdtUnitFact,
                                    DOCTMP.FTPgpChain,
                                    DOCTMP.FTAjdPlcCode,
                                    DOCTMP.FCAjdWahB4Adj,
                                    DOCTMP.FCAjdSaleB4AdjC1,
                                    DOCTMP.FCAjdSaleB4AdjC2,

                                    CONVERT(VARCHAR(10),DOCTMP.FDAjdDateTimeC1,121) AS FTAjdUnitDateC1,
                                    CONVERT(VARCHAR(8),DOCTMP.FDAjdDateTimeC1,108) AS FTAjdUnitTimeC1,
                                    DOCTMP.FCAjdUnitQtyC1,
                                    DOCTMP.FCAjdQtyAllC1,

                                    CONVERT(VARCHAR(10),DOCTMP.FDAjdDateTimeC2,121) AS FTAjdUnitDateC2,
                                    CONVERT(VARCHAR(8),DOCTMP.FDAjdDateTimeC2,108) AS FTAjdUnitTimeC2,
                                    DOCTMP.FCAjdUnitQtyC2,
                                    DOCTMP.FCAjdQtyAllC2,

                                    DOCTMP.FCAjdUnitQty,
                                    DOCTMP.FCAjdQtyAll,
                                    DOCTMP.FCAjdQtyAllDiff,

                                    DOCTMP.FDLastUpdOn,
                                    DOCTMP.FDCreateOn,
                                    DOCTMP.FTLastUpdBy,
                                    DOCTMP.FTCreateBy

                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1";

            $tAjhDocNo      = $paData['FTAjhDocNo'];
            $tXthDocKey     = $paData['FTXthDocKey'];
            $tSesSessionID  = $paData['FTSessionID'];

            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tAjhDocNo'";

            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

            $tSearchList = $paData['tSearchAll'];

            if ($tSearchList != '') {
                $tSQL .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchList%'";
                $tSQL .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchList%' ";
                $tSQL .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchList%' ";
                $tSQL .= " OR DOCTMP.FTAjdPlcCode LIKE '%$tSearchList%' )";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aList          = $oQuery->result_array();
                $oFoundRow      = $this->FSoMAdjStkSubGetDTTempListPageAll($paData);
                $nFoundRow      = $oFoundRow[0]->counts;
                $nPageAll       = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult        = array(
                    'raItems'           => $aList,
                    'rnAllRow'          => $nFoundRow,
                    'rnCurrentPage'     => $paData['nPage'],
                    'rnAllPage'         => $nPageAll,
                    'rtCode'            => '1',
                    'rtDesc'            => 'success',
                );
            } else {
                //No Data
                $aResult = array(
                    'raItems'           => array(),
                    'rnAllRow'          => 0,
                    'rnCurrentPage'     => $paData['nPage'],
                    "rnAllPage"         => 0,
                    'rtCode'            => '800',
                    'rtDesc'            => 'data not found',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : All Page Of Product Size
    //Parameters : function parameters
    //Creator :  25/02/2019 Napat(Jame)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMAdjStkSubGetDTTempListPageAll($paData)
    {
        try {

            $tSQL = "SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                     FROM TCNTDocDTTmp DOCTMP
                     WHERE 1 = 1";

            $tAjhDocNo      = $paData['FTAjhDocNo'];
            $tXthDocKey     = $paData['FTXthDocKey'];
            $tSesSessionID  = $paData['FTSessionID'];

            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tAjhDocNo'";

            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

            $tSearchList = $paData['tSearchAll'];

            if ($tSearchList != '') {
                $tSQL .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchList%'";
                $tSQL .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchList%' ";
                $tSQL .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchList%' ";
                $tSQL .= " OR DOCTMP.FTAjdPlcCode LIKE '%$tSearchList%' )";
            }

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMAdjStkSubGetDTTemp($paDataWhere)
    {

        $tSQL = "SELECT

                    DOCTMP.FTBchCode,
                    DOCTMP.FTXthDocNo,
                    ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                    DOCTMP.FTXthDocKey,
                    DOCTMP.FTPdtCode,
                    DOCTMP.FTXtdPdtName,
                    DOCTMP.FTXtdStkCode,
                    /*DOCTMP.FCXtdStkFac,*/
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

        $tXthDocNo      = $paDataWhere['FTAjhDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');


        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " ORDER BY DOCTMP.FNXtdSeqNo ASC";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        return $aResult;
    }

    function FSaMAdjStkSubAddUpdateDocNoInDocTemp($aDataWhere)
    {
        try {
       
            $this->db->set('FTXthDocNo', $aDataWhere['FTAjhDocNo']);
            // $this->db->set('FTBchCode'  , $aDataWhere['FTBchCode']);
            $this->db->where('FTXthDocNo', '');
            $this->db->where('FTSessionID', $this->session->userdata('tSesSessionID'));
            $this->db->where('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->update('TCNTDocDTTmp');

            $this->db->set('FTXshDocNo', $aDataWhere['FTAjhDocNo']);
            // $this->db->set('FTBchCode'  , $aDataWhere['FTBchCode']);
            $this->db->where('FTXshDocNo', '');
            $this->db->where('FTSessionID', $this->session->userdata('tSesSessionID'));
            $this->db->where('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->update('TCNTDocDTFhnTmp');

           
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Function : Cancel Doc
    //Last Update By : Napat(Jame) 2020/07/20
    public function FSvMAdjStkSubCancel($paDataUpdate)
    {
        try {
            $this->db->set('FTAjhStaDoc', 3);
            $this->db->where('FTAjhDocNo', $paDataUpdate['FTAjhDocNo']);
            $this->db->update('TCNTPdtAdjStkHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Function : Approve Doc
    //Last Update By : Napat(Jame) 2020/07/20
    public function FSaMAdjStkSubApprove($paDataUpdate)
    {
        try {
            $this->db->set('FTAjhStaPrcStk' , $paDataUpdate['FTAjhStaPrcStk']);
            $this->db->set('FTAjhStaApv', $paDataUpdate['FTAjhStaApv']);
            $this->db->set('FTAjhApvCode', $paDataUpdate['FTAjhApvCode']);
            $this->db->set('FDLastUpdOn', $paDataUpdate['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paDataUpdate['FTLastUpdBy']);

            $this->db->where('FTAjhDocNo', $paDataUpdate['FTAjhDocNo']);
            $this->db->update('TCNTPdtAdjStkHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'tCode' => '903',
                    'tDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Search AdjStkSub By ID
     * Parameters : function parameters
     * Creator : 22/05/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : Array
     */
    public function FSaMAdjStkSubGetHD($paData)
    {

        $tAjhDocNo  = $paData['FTAjhDocNo'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT
                    ADJSTK.FTBchCode,
                    ADJSTK.FTAjhDocNo,
                    ADJSTK.FTAjhDocType,
                    CONVERT(CHAR(5), ADJSTK.FDAjhDocDate, 108) AS FTAjhDocTime,
                    ADJSTK.FDAjhDocDate,
                    ADJSTK.FTAjhBchTo,
                    ADJSTK.FTAjhMerchantTo,
                    ADJSTK.FTAjhShopTo,
                    ADJSTK.FTAjhPosTo,
                    ADJSTK.FTAjhWhTo,
                    ADJSTK.FTAjhPlcCode,
                    ADJSTK.FTDptCode,
                    ADJSTK.FTUsrCode,
                    ADJSTK.FTRsnCode,
                    ADJSTK.FTAjhRmk,
                    ADJSTK.FNAjhDocPrint,
                    ADJSTK.FTAjhApvSeqChk,
                    ADJSTK.FTAjhApvCode,
                    ADJSTK.FTAjhStaApv,
                    ADJSTK.FTAjhStaPrcStk,
                    ADJSTK.FTAjhStaDoc,
                    ADJSTK.FNAjhStaDocAct,
                    ADJSTK.FTAjhDocRef,

                    ADJSTK.FDLastUpdOn,
                    ADJSTK.FTLastUpdBy,
                    ADJSTK.FDCreateOn,
                    ADJSTK.FTCreateBy,

                    BCHLDOC.FTBchName,
                    BCHLTO.FTBchName        AS FTAjhBchNameTo,
                    USRLCREATE.FTUsrName    AS FTCreateByName,
                    USRLKEY.FTUsrName       AS FTUsrName,
                    USRAPV.FTUsrName        AS FTAjhApvName,
                    DPTL.FTDptName,
                    WAHLTO.FTWahName        AS FTAjhWhNameTo,

                    ADJSTK.FTRsnCode,
                    RSN_L.FTRsnName

                FROM [TCNTPdtAdjStkHD] ADJSTK WITH(NOLOCK)
                LEFT JOIN TCNMBranch_L      BCHLDOC     ON ADJSTK.FTBchCode = BCHLDOC.FTBchCode AND BCHLDOC.FNLngID = $nLngID
                LEFT JOIN TCNMBranch_L      BCHLTO      ON ADJSTK.FTAjhBchTo = BCHLTO.FTBchCode AND BCHLTO.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L        USRLCREATE  ON ADJSTK.FTCreateBy = USRLCREATE.FTUsrCode AND USRLCREATE.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L        USRLKEY     ON ADJSTK.FTUsrCode = USRLKEY.FTUsrCode AND USRLKEY.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L        USRAPV      ON ADJSTK.FTAjhApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                LEFT JOIN TCNMUsrDepart_L   DPTL        ON ADJSTK.FTDptCode = DPTL.FTDptCode AND DPTL.FNLngID = $nLngID
                LEFT JOIN TCNMWaHouse_L     WAHLTO      ON ADJSTK.FTBchCode = WAHLTO.FTBchCode  AND ADJSTK.FTAjhWhTo = WAHLTO.FTWahCode AND WAHLTO.FNLngID = $nLngID
                LEFT JOIN TCNMRsn_L         RSN_L       ON ADJSTK.FTRsnCode = RSN_L.FTRsnCode AND RSN_L.FNLngID = $nLngID
                WHERE 1=1 ";

        if ($tAjhDocNo != "") {
            $tSQL .= "AND ADJSTK.FTAjhDocNo = '$tAjhDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();

            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            // Not Found
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
    public function FSaMAdjStkSubGetDT($paData)
    {

        $tXthDocNo = $paData['FTAjhDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTAjhDocNo ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT

                                    TWFDT.FTBchCode,
                                    TWFDT.FTAjhDocNo,
                                    TWFDT.FNXtdSeqNo,
                                    TWFDT.FTPdtCode,
                                    TWFDT.FTXtdPdtName,
                                    TWFDT.FTXtdStkCode,
                                    /*TWFDT.FCXtdStkFac,*/
                                    TWFDT.FTPunCode,
                                    TWFDT.FTPunName,
                                    TWFDT.FCXtdFactor,
                                    TWFDT.FTXtdBarCode,
                                    TWFDT.FTXtdVatType,
                                    TWFDT.FTVatCode,
                                    TWFDT.FCXtdVatRate,
                                    TWFDT.FCXtdQty,
                                    TWFDT.FCXtdQtyAll,
                                    TWFDT.FCXtdSetPrice,
                                    TWFDT.FCXtdAmt,
                                    TWFDT.FCXtdVat,
                                    TWFDT.FCXtdVatable,
                                    TWFDT.FCXtdNet,
                                    TWFDT.FCXtdCostIn,
                                    TWFDT.FCXtdCostEx,
                                    TWFDT.FTXtdStaPrcStk,
                                    TWFDT.FNXtdPdtLevel,
                                    TWFDT.FTXtdPdtParent,
                                    TWFDT.FCXtdQtySet,
                                    TWFDT.FTXtdPdtStaSet,
                                    TWFDT.FTXtdRmk,
                                    TWFDT.FDLastUpdOn,
                                    TWFDT.FTLastUpdBy,
                                    TWFDT.FDCreateOn,
                                    TWFDT.FTCreateBy

                            FROM [TCNTPdtAdjStkDT] TWFDT
                            ";


        if (@$tXthDocNo != '') {
            $tSQL .= " WHERE (TWFDT.FTAjhDocNo = '$tXthDocNo')";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'rtCode' => '1',
                'raItems'   => $oDetail,
            );
        } else {
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
    public function FSaMAdjStkSubInsertDTToTemp($paDataWhere)
    {

        $tDocNo     = $paDataWhere['FTAjhDocNo'];
        $tDocKey    = $paDataWhere['FTXthDocKey'];
        $tSessionID = $paDataWhere['FTSessionID'];

        //ลบ ใน Temp
        $this->db->where_in('FTXthDocNo', $tDocNo);
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocDTTmp');


        $tSQL = "   INSERT INTO TCNTDocDTTmp (
                            FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode
                        ,FTXtdPdtName,FTPunCode,FTPunName,FTXtdBarCode

                        ,FCPdtUnitFact,FTPgpChain,FTAjdPlcCode

                        ,FDAjdDateTimeC1,FCAjdUnitQtyC1,FCAjdQtyAllC1
                        ,FDAjdDateTimeC2,FCAjdUnitQtyC2,FCAjdQtyAllC2
                        ,FTTmpStatus
                        ,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
                    )
                    SELECT
                            DT.FTBchCode
                        ,DT.FTAjhDocNo
                        ,DT.FNAjdSeqNo
                        ,'$tDocKey'         AS FTXthDocKey
                        ,DT.FTPdtCode
                        ,DT.FTPdtName
                        ,DT.FTPunCode
                        ,DT.FTPunName
                        ,DT.FTAjdBarcode

                        ,DT.FCPdtUnitFact
                        ,DT.FTPgpChain
                        ,DT.FTAjdPlcCode

                        ,DT.FDAjdDateTimeC1
                        ,DT.FCAjdUnitQtyC1
                        ,DT.FCAjdQtyAllC1
                        ,DT.FDAjdDateTimeC2
                        ,DT.FCAjdUnitQtyC2
                        ,DT.FCAjdQtyAllC2

                        ,PDT.FTPdtForSystem
                        ,'$tSessionID'		AS FTSessionID
                        ,DT.FDLastUpdOn
                        ,DT.FDCreateOn
                        ,DT.FTLastUpdBy
                        ,DT.FTCreateBy
                    FROM TCNTPdtAdjStkDT DT WITH(NOLOCK)
                    LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                    WHERE 1=1
                    AND DT.FTAjhDocNo = '$tDocNo'
        ";
        $this->db->query($tSQL);
        // echo $this->db->last_query();
        // die();
        if ($this->db->trans_status() === FALSE) {
            $aStatus = array(
                'tCode' => '905',
                'tDesc' => $this->db->error()
            );
        } else {
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'Insert Success.'
            );
        }
        return $aStatus;
    }


    //Functionality : Function Add DT To Temp
    //Parameters : function parameters
    //Creator : 03/04/2019 Krit(Copter)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMAdjStkSubInsertDTFhnToTemp($paDataWhere)
    {

        $tDocNo     = $paDataWhere['FTAjhDocNo'];
        $tDocKey    = $paDataWhere['FTXthDocKey'];
        $tSessionID = $paDataWhere['FTSessionID'];

        //ลบ ใน Temp
        $this->db->where_in('FTXshDocNo', $tDocNo);
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocDTFhnTmp');


        $tSQL = "   INSERT INTO TCNTDocDTFhnTmp (
                         FTBchCode,FTXshDocNo,FNXsdSeqNo,FTXthDocKey,FTPdtCode
                        ,FTXtdPdtName,FCXtdQty,FTFhnRefCode,FTXtdBarCode,FTAjdPlcCode

                        ,FDAjdDateTimeC1,FCAjdUnitQtyC1,FCAjdQtyAllC1
                        ,FDAjdDateTimeC2,FCAjdUnitQtyC2,FCAjdQtyAllC2
         
                        ,FTSessionID,FDCreateOn,FTCreateBy
                    )
                    SELECT
                         DT.FTBchCode
                        ,DT.FTAjhDocNo
                        ,DT.FNAjdSeqNo
                        ,'$tDocKey'         AS FTXthDocKey
                        ,DT.FTPdtCode
                        ,DT.FTPdtName
                        ,0 AS FCXtdQty
                        ,DT.FTFhnRefCode
                        ,DT.FTAjdBarcode
                        ,DT.FTAjdPlcCode 

                        ,DT.FDAjdDateTimeC1
                        ,DT.FCAjdQtyC1 AS FCAjdUnitQtyC1
                        ,DT.FCAjdQtyC1 AS FCAjdQtyAllC1

                        ,DT.FDAjdDateTimeC2
                        ,DT.FCAjdQtyC2 AS FCAjdUnitQtyC2
                        ,DT.FCAjdQtyC2 AS FCAjdQtyAllC2
                        

              
                        ,'$tSessionID'		AS FTSessionID
                        ,DT.FDCreateOn
                        ,DT.FTCreateBy
                    FROM TCNTPdtAdjStkDTFhn DT WITH(NOLOCK)

                    WHERE 1=1
                    AND DT.FTAjhDocNo = '$tDocNo'
        ";
        $this->db->query($tSQL);
        if ($this->db->trans_status() === FALSE) {
            $aStatus = array(
                'tCode' => '905',
                'tDesc' => $this->db->error()
            );
        } else {
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'Insert Success.'
            );
        }
        return $aStatus;
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : 20/07/2020 Napat(Jame)
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMAdjStkSubAddUpdateHD($paData)
    {

        try {
            // Update Master
            $this->db->set('FTAjhPlcCode', $paData['FTAjhPlcCode']);
            $this->db->set('FDAjhDocDate', $paData['FDAjhDocDate']);
            $this->db->set('FTAjhBchTo', $paData['FTAjhBchTo']);
            $this->db->set('FTAjhWhTo', $paData['FTAjhWhTo']);
            $this->db->set('FTRsnCode', $paData['FTRsnCode']);
            $this->db->set('FTAjhRmk', $paData['FTAjhRmk']);
            // $this->db->set('FTAjhApvSeqChk', $paData['FTAjhApvSeqChk']);
            $this->db->set('FNAjhStaDocAct', $paData['FNAjhStaDocAct']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            $this->db->where('FTAjhDocNo', $paData['FTAjhDocNo']);
            $this->db->update('TCNTPdtAdjStkHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TCNTPdtAdjStkHD', $paData);

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Create By Napat(Jame) 2020/07/13
    // Parameter : SessionLogin, DocKey, DocNo ,
    //             TypeDelete 1 = clear temp , 2 delete by id
    public function FSxMAdjStkSubClearDTTmp($paDataWhere)
    {

        $this->db->where_in('FTSessionID', $paDataWhere['FTSessionID']);
        $this->db->where_in('FTXthDocKey', $paDataWhere['FTXthDocKey']);

        // กรณีเคลียร์ temp ให้ลบทุกเลขที่เอกสาร
        // กรณีลบบางรายการให้ where ด้วยเลขที่เอกสาร และ Seq
        if ($paDataWhere['tDeleteType'] != '1') {
            $this->db->where_in('FTXthDocNo', $paDataWhere['FTAjhDocNo']);
            $this->db->where_in('FNXtdSeqNo', $paDataWhere['FNXtdSeqNo']);
        }

        $this->db->delete('TCNTDocDTTmp');
    }

    // Create By Nattakit(Nale) 2021/05/13
    // Parameter : SessionLogin, DocKey, DocNo ,
    //   TypeDelete 1 = clear temp , 2 delete by id
    public function FSxMAdjStkSubClearDTFhnTmp($paDataWhere)
    {

        $this->db->where_in('FTSessionID', $paDataWhere['FTSessionID']);
        // $this->db->where_in('FTXthDocKey', $paDataWhere['FTXthDocKey']);

        // กรณีเคลียร์ temp ให้ลบทุกเลขที่เอกสาร
        // กรณีลบบางรายการให้ where ด้วยเลขที่เอกสาร และ Seq
        if ($paDataWhere['tDeleteType'] != '1') {
            $this->db->where_in('FTXshDocNo', $paDataWhere['FTAjhDocNo']);
            $this->db->where_in('FNXsdSeqNo', $paDataWhere['FNXtdSeqNo']);
        }

        $this->db->delete('TCNTDocDTFhnTmp');
    }


    //Functionality : Delete PurchaseOrder
    //Parameters : function parameters
    //Creator : 29/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSnMAdjStkSubDel($paData)
    {
        try {
            $this->db->trans_begin();

            $this->db->where_in('FTAjhDocNo', $paData['FTAjhDocNo']);
            $this->db->delete('TCNTPdtAdjStkHD');

            $this->db->where_in('FTAjhDocNo', $paData['FTAjhDocNo']);
            $this->db->delete('TCNTPdtAdjStkDT');

            $this->db->where_in('FTAjhDocNo', $paData['FTAjhDocNo']);
            $this->db->delete('TCNTPdtAdjStkDTFhn');

            $this->db->where_in('FTXthDocNo', $paData['FTAjhDocNo']);
            $this->db->delete('TCNTDocDTTmp');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Functionality : Delete PurchaseOrder
    //Parameters : function parameters
    //Creator : 04/04/2019 Krit(Copter)
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSnMAdjStkSubDelDTTmp($paData)
    {
        try {
            $this->db->trans_begin();

            $this->db->where_in('FTXthDocNo', $paData['FTAjhDocNo']);
            $this->db->where_in('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            // $this->db->where_in('FTPdtCode',  $paData['FTPdtCode']);
            $this->db->where_in('FTSessionID', $paData['FTSessionID']);
            $this->db->where_in('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->delete('TCNTDocDTTmp');


            $this->db->where_in('FTXshDocNo', $paData['FTAjhDocNo']);
            $this->db->where_in('FNXsdSeqNo', $paData['FNXtdSeqNo']);
            // $this->db->where_in('FTPdtCode',  $paData['FTPdtCode']);
            $this->db->where_in('FTSessionID', $paData['FTSessionID']);
            $this->db->where_in('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->delete('TCNTDocDTFhnTmp');
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Multi Pdt Del Temp
    //Parameters : function parameters
    //Creator : 25/03/2019 Krit(Copter)
    //Return : Status Delete
    //Return Type : array
    public function FSaMAdjStkSubPdtTmpMultiDel($paData)
    {
        try {
            $this->db->trans_begin();

            //Del DTTmp
            $this->db->where('FTXthDocNo', $paData['FTAjhDocNo']);
            $this->db->where('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            $this->db->where('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->where('FTSessionID', $paData['FTSessionID']);
            $this->db->delete('TCNTDocDTTmp');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : function parameters
     * Creator : 28/05/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : Array
     */
    public function FSnMAdjStkSubCheckDuplicate($ptCode)
    {
        $tSQL = "SELECT COUNT(FTAjhDocNo)AS counts
                 FROM TCNTPdtAdjStkHD
                 WHERE FTAjhDocNo = '$ptCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        } else {
            return false;
        }
    }

    // Create By : Napat(Jame) 2020/07/14
    public function FSaMAdjStkSubGetLocation($aPackData)
    {
        $nLngID = $this->session->userdata("tLangEdit");

        $tSelect    = "";
        $tLeftJoin  = "";

        // ขา edit เช็คเงื่อนไขว่าสินค้าใน DT มี location ไหนบ้าง ให้ไปติ๊ก checkbox บนหน้าจอ
        if (isset($aPackData['FTAjhDocNo']) && !empty($aPackData['FTAjhDocNo'])) {
            $tSelect = " ,CASE
                            WHEN ADJ.FTAjdPlcCode IS NULL THEN '0'
                            ELSE '1'
                          END AS FTPlcStaActive
                       ";
            $tLeftJoin = " LEFT JOIN (
                                SELECT DISTINCT
                                    FTAjdPlcCode
                                FROM TCNTPdtAdjStkDT WITH(NOLOCK)
                                WHERE FTAjhDocNo = '$aPackData[FTAjhDocNo]'
                            ) ADJ ON LOC.FTPlcCode = ADJ.FTAjdPlcCode
                         ";
        }

        $tSQL   = "     SELECT
                            LOC.FTPlcCode,
                            LOC_L.FTPlcName
                            $tSelect
                        FROM TCNMPdtLoc LOC WITH(NOLOCK)
                        LEFT JOIN TCNMPdtLoc_L LOC_L WITH(NOLOCK) ON LOC.FTPlcCode = LOC_L.FTPlcCode AND LOC_L.FNLngID = $nLngID
                        $tLeftJoin
                        ORDER BY LOC.FDCreateOn DESC
                  ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aReturn = array(
                'aResult'   => $oQuery->result_array(),
                'tCode'     => '1',
                'tDesc'     => 'Found Data'
            );
        } else {
            $aReturn = array(
                'aResult'   => array(),
                'tCode'     => '99',
                'tDesc'     => 'Not Found Data'
            );
        }
        return $aReturn;
    }

    // Create By : Napat(Jame) 2020/07/15
    public function FSaMASTEventAddProducts($paDataCondition, $paDataInsert)
    {

        // Get Parameters
        $tBchCode   = $paDataInsert['FTBchCode'];
        $tDocNo     = $paDataInsert['FTXthDocNo'];
        $tDocKey    = $paDataInsert['FTXthDocKey'];
        $tSession   = $paDataInsert['FTSessionID'];
        $tUser      = $paDataInsert['tUser'];
        $tPdtLoc    = $paDataInsert['FTAjdPlcCode'];

        // Get Last Seq
        $tSQL   = "     SELECT TOP 1
                            COUNT(FNXtdSeqNo) AS FNXtdLastSeq
                        FROM TCNTDocDTTmp WITH(NOLOCK)
                        WHERE   FTBchCode   = '$tBchCode'
                            AND FTXthDocNo  = '$tDocNo'
                            AND FTXthDocKey = '$tDocKey'
                            AND FTSessionID = '$tSession'
                  ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $nLastSeq = $oQuery->result_array()[0]['FNXtdLastSeq'];
        } else {
            $nLastSeq = 0;
        }

        // Setings
        $tCondition         = "";
        $tQueryJoin         = "";

        // Condition Product
        if (isset($paDataCondition['oetASTFilterPdtCodeFrom']) && $paDataCondition['oetASTFilterPdtCodeFrom'] != "" && isset($paDataCondition['oetASTFilterPdtCodeTo']) && $paDataCondition['oetASTFilterPdtCodeTo'] != "") {
            $tCondition .= " AND PDT.FTPdtCode BETWEEN '" . $paDataCondition['oetASTFilterPdtCodeFrom'] . "' AND '" . $paDataCondition['oetASTFilterPdtCodeTo'] . "' ";
        }

        // Condition Spuplier
        if (isset($paDataCondition['oetASTFilterSplCodeFrom']) && $paDataCondition['oetASTFilterSplCodeFrom'] != "" && isset($paDataCondition['oetASTFilterSplCodeTo']) && $paDataCondition['oetASTFilterSplCodeTo'] != "") {
            $tQueryJoin  .= " INNER JOIN TCNMPdtSpl PDLSPL WITH(NOLOCK) ON PDLSPL.FTPdtCode = PDT.FTPdtCode ";
            $tCondition .= " AND PDLSPL.FTSplCode BETWEEN '" . $paDataCondition['oetASTFilterSplCodeFrom'] . "' AND '" . $paDataCondition['oetASTFilterSplCodeTo'] . "' ";
        }

        // Condition Product Group
        if (isset($paDataCondition['oetASTFilterPgpCode']) && !empty($paDataCondition['oetASTFilterPgpCode'])) {
            $tQueryJoin  .= " INNER JOIN TCNMPdtGrp GRP WITH(NOLOCK) ON GRP.FTPgpChain = PDT.FTPgpChain ";
            $tCondition .= " AND GRP.FTPgpChain = '" . $paDataCondition['oetASTFilterPgpCode'] . "' ";
        }

        // Condition Product Location
        if (isset($paDataCondition['oetASTFilterPlcCode']) && !empty($paDataCondition['oetASTFilterPlcCode'])) {
            $tQueryJoin  .= " INNER JOIN TCNMPdtBar BAR WITH(NOLOCK) ON BAR.FTPdtCode = PDT.FTPdtCode ";
            $tCondition .= " AND BAR.FTPlcCode = '" . $paDataCondition['oetASTFilterPlcCode'] . "' ";

            if (isset($paDataCondition['ocbASTPdtLocChkSeq']) && !empty($paDataCondition['ocbASTPdtLocChkSeq'])) {
                $tQueryJoin  .= " INNER JOIN TCNTPdtLocSeq LOC WITH(NOLOCK) ON BAR.FTPlcCode = LOC.FTPlcCode ";
            }

            $tPdtLoc = $paDataCondition['oetASTFilterPlcCode'];
        }

        // Condition Product Stock Card
        if (isset($paDataCondition['ocbASTUsePdtStkCard']) && !empty($paDataCondition['ocbASTUsePdtStkCard'])) {
            if (isset($paDataCondition['orbASTPdtStkCard']) && !empty($paDataCondition['orbASTPdtStkCard'])) {
                if ($paDataCondition['orbASTPdtStkCard'] == '1') {
                    $tQueryJoin .= " LEFT JOIN TCNTPdtStkCrd PSK WITH(NOLOCK) ON PDT.FTPdtCode = PSK.FTPdtCode AND PSK.FTBchCode = '$tBchCode' ";
                    $tCondition .= " AND PSK.FDStkDate IS NULL ";
                } else {
                    if (isset($paDataCondition['onbASTPdtStkCardBack']) && !empty($paDataCondition['onbASTPdtStkCardBack'])) {
                        $nStkBack = intval($paDataCondition['onbASTPdtStkCardBack']);
                        $tQueryJoin .= " INNER JOIN (
                                            SELECT
                                                FTBchCode,
                                                FTPdtCode
                                            FROM TCNTPdtStkCrd WITH(NOLOCK)
                                            WHERE CONVERT(VARCHAR(10),FDStkDate,121) BETWEEN CONVERT(VARCHAR(10),DATEADD(MONTH, -$nStkBack, GETDATE()),121) AND CONVERT(VARCHAR(10),GETDATE(),121)
                                            GROUP BY FTBchCode,FTPdtCode
                                         ) PSK ON PSK.FTPdtCode = PDT.FTPdtCode AND PSK.FTBchCode = '$tBchCode'
                                       ";
                    }
                }
            }
        }

        // Insert Production
        $tSQL = "   INSERT INTO TCNTDocDTTmp (
                        FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTXtdBchRef,FTTmpStatus,FTPdtCode,
                        FTXtdPdtName,FTPunCode,FTPunName,FTXtdBarCode,FCPdtUnitFact,
                        FTPgpChain,FTAjdPlcCode,
                        FCAjdUnitQtyC1,FCAjdQtyAllC1,
                        FCAjdUnitQtyC2,FCAjdQtyAllC2,
                        FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
                    )
                ";
        $tSQLCallPDt = "  SELECT
                        '$tBchCode'		    AS FTBchCode,
                        '$tDocNo'			AS FTXthDocNo,
                        ROW_NUMBER() OVER(ORDER BY PDT.FTPdtCode ASC) + $nLastSeq AS FNRowID,
                        '$tDocKey'	        AS FTXthDocKey,
                        CASE WHEN PDT.FTPdtForSystem = 5 THEN 'FH' ELSE 'GN' END AS PDTSpc ,
                        PDT.FTPdtForSystem,
                        PDT.FTPdtCode,
                        PDT_L.FTPdtName,
                        PPS.FTPunCode,
                        PUN_L.FTPunName,
                        --PBAR.FTBarCode,
                        '' AS FTBarCode,
                        PPS.FCPdtUnitFact,
                        PDT.FTPgpChain,
                        '$tPdtLoc'		    AS FTAjdPlcCode,
                        0					AS FCAjdUnitQtyC1,
                        0					AS FCAjdQtyAllC1,
                        0					AS FCAjdUnitQtyC2,
                        0					AS FCAjdQtyAllC2,
                        '$tSession'			AS FTSessionID,
                        GETDATE()			AS FDLastUpdOn,
                        GETDATE()			AS FDCreateOn,
                        '$tUser'			AS FTLastUpdBy,
                        '$tUser'			AS FTCreateBy
                    FROM TCNMPdt PDT WITH(NOLOCK)
                        LEFT JOIN TCNMPdt_L PDT_L WITH(NOLOCK) ON PDT.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = 1
                        LEFT JOIN TCNMPdtPackSize PPS WITH(NOLOCK) ON PDT.FTPdtCode = PPS.FTPdtCode
                        LEFT JOIN TCNMPdtUnit_L PUN_L WITH(NOLOCK) ON PPS.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = 1
                        --LEFT JOIN TCNMPdtBar PBAR WITH(NOLOCK) ON PDT.FTPdtCode = PBAR.FTPdtCode AND PPS.FTPunCode = PBAR.FTPunCode AND PBAR.FTBarStaUse = 1
                        $tQueryJoin
                    WHERE 1 = 1
                    $tCondition
                 ";

        $tSQL .= $tSQLCallPDt;

        $this->db->query($tSQL);
        if ($this->db->trans_status() === FALSE) {
            $aReturn = array(
                'tSQL'      => $tSQL,
                'aPDtList' => array(),
                'tCode'     => '99',
                'tDesc'     => $this->db->error()
            );
        } else {
            if ($this->db->affected_rows() > 0) {
                if (isset($paDataCondition['oetASTFilterPlcCode']) && !empty($paDataCondition['oetASTFilterPlcCode'])) {
                    $aReturn = array(
                        'tSQL'      => $tSQL,
                        'aPDtList' => $this->db->query($tSQLCallPDt)->result_array(),
                        'tCode'     => '2',
                        'tDesc'     => 'Success and change location',
                        'tPlcCode'  => $paDataCondition['oetASTFilterPlcCode']
                    );
                } else {
                    $aReturn = array(
                        'tSQL'      => $tSQL,
                        'aPDtList' => $this->db->query($tSQLCallPDt)->result_array(),
                        'tCode'     => '1',
                        'tDesc'     => 'Success'
                    );
                }
            } else {
                $aReturn = array(
                    'tSQL'      => $tSQL,
                    'aPDtList' => array(),
                    'tCode'     => '905',
                    'tDesc'     => 'Not Found Data'
                );
            }
        }
        return $aReturn;
    }

    public function FSaMASTEditInLine($paData)
    {
        $tSQL  = "  UPDATE
                        TCNTDocDTTmp WITH(ROWLOCK)
                    SET
                 ";

        if (strpos($paData['tField'], 'C1') !== false) {
            $tSQL .= "
                        FCAjdUnitQtyC1     = $paData[tValue],
                        FCAjdQtyAllC1      = ($paData[tValue] * FCPdtUnitFact)
                     ";
            if ($paData['tChkDateTime'] == "") {
                $tSQL .= " ,FDAjdDateTimeC1    = NULL ";
            } else {
                $tSQL .= " ,FDAjdDateTimeC1    = '$paData[tChkDateTime]' ";
            }
        } else {
            $tSQL .= "
                        FCAjdUnitQtyC2     = $paData[tValue],
                        FCAjdQtyAllC2      = ($paData[tValue] * FCPdtUnitFact)
                     ";
            if ($paData['tChkDateTime'] == "") {
                $tSQL .= " ,FDAjdDateTimeC2    = NULL ";
            } else {
                $tSQL .= " ,FDAjdDateTimeC2    = '$paData[tChkDateTime]' ";
            }
        }

        $tSQL .= "  WHERE 1=1
                        AND FTXthDocNo     = '$paData[FTIuhDocNo]'
                        AND FNXtdSeqNo     = '$paData[nSeq]'
                        AND FTXthDocKey    = '$paData[FTXthDocKey]'
                        AND FTSessionID    = '$paData[FTSessionID]'
                 ";

        $this->db->query($tSQL);
        if ($this->db->trans_status() === FALSE) {
            $aDataResult = array(
                'tSQL'          => $tSQL,
                'nStaQuery'     => 99,
                'tStaMessage'   => $this->db->error(),
            );
        } else {
            $aDataResult = array(
                'tSQL'          => $tSQL,
                'nStaQuery'     => 1,
                'tStaMessage'   => 'Update Success',
            );
        }
        return $aDataResult;
    }

    // Create By Napat(Jame) 2020/07/23
    // ตรวจสอบวันที่-เวลาใน Tmp DT
    public function FSnMASTCheckDateTimeTmpDT()
    {
        $tSession = $this->session->userdata('tSesSessionID');
        $tSQL = "   SELECT
                        COUNT(FTPdtCode) AS count_pdt
                    FROM TCNTDocDTTmp WITH(NOLOCK)
                    WHERE FDAjdDateTimeC1 IS NULL
                        AND FTXthDocNo     = ''
                        AND FTXthDocKey    = 'TCNTPdtAdjStkDT'
                        AND FTSessionID    = '$tSession'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $nCount = $oQuery->result_array()[0]['count_pdt'];
        } else {
            $nCount = 0;
        }
        return $nCount;
    }

    // Create By Napat(Jame) 2020/07/23
    // ตรวจสอบวันที่-เวลาใน Tmp DT
    public function FSaMASTUpdateDateTime()
    {
        $tSession = $this->session->userdata('tSesSessionID');
        $tSQL = "   UPDATE TCNTDocDTTmp WITH(ROWLOCK)
                    SET FDAjdDateTimeC1 = CONVERT(VARCHAR(19),GETDATE(),121)
                    WHERE FDAjdDateTimeC1 IS NULL
                        AND FTXthDocNo     = ''
                        AND FTXthDocKey    = 'TCNTPdtAdjStkDT'
                        AND FTSessionID    = '$tSession'
        ";
        $this->db->query($tSQL);
        if ($this->db->trans_status() === FALSE) {
            $aDataResult = array(
                'tSQL'          => $tSQL,
                'nStaQuery'     => 99,
                'tStaMessage'   => $this->db->error(),
            );
        } else {
            $aDataResult = array(
                'tSQL'          => $tSQL,
                'nStaQuery'     => 1,
                'tStaMessage'   => 'Update Success',
            );
        }
        return $aDataResult;
    }


    // Create By Nattakit(Nale) 2021/05/13
    // Insert PdtFhn To DTfhnTemp
    public function FSaMASTEventAddProductsFashion($paInsertData){
        try {
            // Update Master
            $this->db->where('FTBchCode', $paInsertData['FTBchCode']);
            $this->db->where('FTXshDocNo', $paInsertData['FTXshDocNo']);
            $this->db->where('FTXthDocKey', $paInsertData['FTXthDocKey']);
            $this->db->where('FTPdtCode', $paInsertData['FTPdtCode']);
            $this->db->where('FNXsdSeqNo', $paInsertData['FNXsdSeqNo']);
            $this->db->where('FTFhnRefCode', $paInsertData['FTFhnRefCode']);
            $this->db->where('FTSessionID', $paInsertData['FTSessionID']);
            $this->db->update('TCNTDocDTFhnTmp',$paInsertData);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TCNTDocDTFhnTmp', $paInsertData);

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }



    }


    // Create By Nattakit(Nale) 2021/05/13
    // Insert PdtFhn To DTfhnTemp
    public function FSnMASTGetSeqDTTemp($paInsertData){
        $FTBchCode = $paInsertData['FTBchCode'];
        $FTXthDocNo = $paInsertData['FTXshDocNo'];
        $FTXthDocKey = $paInsertData['FTXthDocKey']; 
        $FTPdtCode = $paInsertData['FTPdtCode']; 
        $FTXtdBarCode = $paInsertData['FTXtdBarCode']; 
        $FTPunCode = $paInsertData['FTPunCode']; 
        $FTSessionID = $paInsertData['FTSessionID'];    
        $tSQL = "   SELECT
                        FNXtdSeqNo
                    FROM TCNTDocDTTmp WITH(NOLOCK)
                    WHERE 
                            FTBchCode     = '$FTBchCode'
                        AND FTXthDocKey    = 'TCNTPdtAdjStkDT'
                        AND FTXthDocNo     = '$FTXthDocNo'
                        AND FTPdtCode     = '$FTPdtCode'
                        AND ISNULL(FTXtdBarCode,'')   = '$FTXtdBarCode'
                        AND FTPunCode     = '$FTPunCode'
                        AND FTSessionID    = '$FTSessionID'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $nXtdSeqNo = $oQuery->result_array()[0]['FNXtdSeqNo'];
        } else {
            $nXtdSeqNo = 1;
        }
        return $nXtdSeqNo;
    }

    // Create By Nattakit(Nale) 2021/05/13
    // Insert PdtFhn To DTfhnTemp
    public function FSnMASTGetPdtUnitFactDTTemp($paInsertData){
        $FTBchCode = $paInsertData['FTBchCode'];
        $FTXthDocNo = $paInsertData['FTXshDocNo'];
        $FTXthDocKey = $paInsertData['FTXthDocKey']; 
        $FTPdtCode = $paInsertData['FTPdtCode']; 
        $FTXtdBarCode = $paInsertData['FTXtdBarCode']; 
        $FTPunCode = $paInsertData['FTPunCode']; 
        $FTSessionID = $paInsertData['FTSessionID'];    
        $tSQL = "   SELECT
                        FCPdtUnitFact
                    FROM TCNTDocDTTmp WITH(NOLOCK)
                    WHERE 
                            FTBchCode     = '$FTBchCode'
                        AND FTXthDocKey    = 'TCNTPdtAdjStkDT'
                        AND FTXthDocNo     = '$FTXthDocNo'
                        AND FTPdtCode     = '$FTPdtCode'
                        AND FTXtdBarCode   = '$FTXtdBarCode'
                        AND FTPunCode     = '$FTPunCode'
                        AND FTSessionID    = '$FTSessionID'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $nXtdFact = $oQuery->result_array()[0]['FCPdtUnitFact'];
        } else {
            $nXtdFact = 1;
        }
        return $nXtdFact;
    }

    // Create By Nattakit(Nale) 2021/05/13
    // Insert PdtFhn To DTfhnTemp
    public function FSaMASTEventUpdateDTTmp($paInsertData){

        try {
            // Update Master
            $this->db->where('FTBchCode', $paInsertData['FTBchCode']);
            $this->db->where('FTXthDocNo', $paInsertData['FTXthDocNo']);
            $this->db->where('FTXthDocKey', $paInsertData['FTXthDocKey']);
            $this->db->where('FNXtdSeqNo', $paInsertData['FNXtdSeqNo']);
            $this->db->where('FTSessionID', $paInsertData['FTSessionID']);
            $this->db->update('TCNTDocDTTmp',$paInsertData);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TCNTDocDTTmp', $paInsertData);

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }



}

