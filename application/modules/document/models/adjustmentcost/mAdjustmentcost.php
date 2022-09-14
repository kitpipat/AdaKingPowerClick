<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mAdjustmentcost extends CI_Model
{


    // Functionality: Data List
    // Parameters: function parameters
    // Creator:  03/03/2021 Sooksanti(Nont)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMADCGetDataTable($paDataCondition)
    {
        $aDataUserInfo      = $this->session->userdata("tSesUsrInfo");
        $aRowLen            = FCNaHCallLenData($paDataCondition['nRow'], $paDataCondition['nPage']);
        $nLngID             = $paDataCondition['FNLngID'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];
        @$tSearchList        = $aAdvanceSearch['tSearchAll'];

        // Advance Search
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];

        $tUsrBchCode        = $this->session->userdata("tSesUsrBchCodeMulti");

        /** ค้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร */
        $tWhereSearchAll    = "";
        if (@$tSearchList != '') {
            $tWhereSearchAll = " AND ((ADC.FTXchDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),ADC.FDXchDocDate,103) LIKE '%$tSearchList%'))";
        }

        // Check User Level Branch HQ OR Bch Or Shop
        $tUserLevel = $this->session->userdata("tSesUsrLevel");
        $tWhereBch  = "";
        $tWhereShp  = "";
        if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH") {
            // Check User Level BCH
            $tWhereBch  =   " AND ADC.FTBchCode IN (" . $tUsrBchCode . ") ";
        }

        $tWhereBchFrmTo     = "";
        if ($this->session->userdata("tSesUsrLevel") == "HQ" || $this->session->userdata("nSesUsrBchCount") >1) {
            /* ค้นหาจากสาขา - ถึงสาขา */
            $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
            $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];

            if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
                $tWhereBchFrmTo = " AND ((ADC.FTBchCode BETWEEN '$tSearchBchCodeFrom' AND '$tSearchBchCodeTo') OR (ADC.FTBchCode BETWEEN '$tSearchBchCodeTo' AND '$tSearchBchCodeFrom'))";
            }
        } else {
            $tWhereBchFrmTo .= " AND ADC.FTBchCode IN (" . $tUsrBchCode . ")";
        }

        /** ค้นหาจากวันที่ - ถึงวันที่ */
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tWhereDateFrmTo    = "";
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tWhereDateFrmTo = " AND ((ADC.FDXchDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (ADC.FDXchDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /** ค้นหาสถานะเอกสาร */
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        $tWhereStaDoc   = "";
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tWhereStaDoc .= " AND ADC.FTXchStaDoc = '$tSearchStaDoc'";
            } else if ($tSearchStaDoc == 2) {
                $tWhereStaDoc .= " AND ISNULL(ADC.FTXchStaApv,'') = '' AND ADC.FTXchStaDoc != '3'";
            } else if ($tSearchStaDoc == 1) {
                $tWhereStaDoc .= " AND ADC.FTXchStaApv = '$tSearchStaDoc'";
            }
        }

        $tSQL   = " SELECT c.* 
                            FROM( SELECT ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTXchDocNo DESC) AS FNRowID,* 
                                FROM (         
                                    SELECT HD.* FROM (  
                                        SELECT  DISTINCT 
                                            ADC.FTBchCode, 
                                            BCHL.FTBchName, 
                                            ADC.FTXchDocNo, 
                                            CONVERT(CHAR(10),ADC.FDXchDocDate,103)   AS FDXchDocDate,
                                            CONVERT(CHAR(5), ADC.FTXchDocTime, 108)  AS FTXchDocTime,
                                            ADC.FTXchStaDoc,
                                            ADC.FTXchStaApv,
                                            ADC.FTXchStaPrcDoc,
                                            ADC.FTCreateBy,
                                            ADC.FDCreateOn,
                                            USRL.FTUsrName  AS FTCreateByName,
                                            ADC.FTXchApvCode,
                                            USRLAPV.FTUsrName   AS FTXchApvName
                                    FROM [TCNTPdtAdjCostHD] ADC WITH (NOLOCK) 
                                    LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON ADC.FTBchCode      = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON ADC.FTCreateBy     = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON ADC.FTXchApvCode   = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                                    WHERE 1=1 AND ADC.FNXchDocType = '10' 
                                        " . $tWhereSearchAll . "
                                        " . $tWhereBch . "
                                        " . $tWhereBchFrmTo . "
                                        " . $tWhereDateFrmTo . "
                                        " . $tWhereStaDoc . "
                                    ) HD
                                    INNER JOIN (SELECT DISTINCT FTXchDocNo  FROM TCNTPdtAdjCostDT)DT
                                    ON HD.FTXchDocNo = DT.FTXchDocNo
                            ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSnMADCGetPageAll($paDataCondition);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1') ? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow / $paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($oDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality: Count Data All HD
    // Parameters: function parameters
    // Creator:  03/03/2021 Sooksanti
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSnMADCGetPageAll($paDataCondition)
    {
        $aDataUserInfo      = $this->session->userdata("tSesUsrInfo");

        $nLngID             = $paDataCondition['FNLngID'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];
        @$tSearchList        = $aAdvanceSearch['tSearchAll'];

        // Advance Search
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];

        $tUsrBchCode        = $this->session->userdata("tSesUsrBchCodeMulti");

        /** ค้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร */
        $tWhereSearchAll    = "";
        if (@$tSearchList != '') {
            $tWhereSearchAll = " AND ((ADC.FTXchDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),ADC.FDXchDocDate,103) LIKE '%$tSearchList%'))";
        }

        // Check User Level Branch HQ OR Bch Or Shop
        $tUserLevel = $this->session->userdata("tSesUsrLevel");
        $tWhereBch  = "";
        $tWhereShp  = "";
        if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH") {
            // Check User Level BCH
            $tWhereBch  =   " AND ADC.FTBchCode IN (" . $tUsrBchCode . ") ";
        }


        $tWhereBchFrmTo     = "";
        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
            $tWhereBchFrmTo .= " AND ((ADC.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (ADC.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // if ($this->session->userdata("tSesUsrLevel") == "HQ") {
        //     /* ค้นหาจากสาขา - ถึงสาขา */
        //     $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        //     $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        //     if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
        //         $tWhereBchFrmTo = " AND ((ADC.FTBchCode BETWEEN '$tSearchBchCodeFrom' AND '$tSearchBchCodeTo') OR (ADC.FTBchCode BETWEEN '$tSearchBchCodeTo' AND '$tSearchBchCodeFrom'))";
        //     }
        // } else {
        //     $tWhereBchFrmTo .= " AND ADC.FTBchCode IN (" . $tUsrBchCode . ")";
        // }

        /** ค้นหาจากวันที่ - ถึงวันที่ */
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tWhereDateFrmTo    = "";
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tWhereDateFrmTo = " AND ((ADC.FDXchDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (ADC.FDXchDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /** ค้นหาสถานะเอกสาร */
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        $tWhereStaDoc   = "";
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tWhereStaDoc .= " AND ADC.FTXchStaDoc = '$tSearchStaDoc'";
            } else if ($tSearchStaDoc == 2) {
                $tWhereStaDoc .= " AND ISNULL(ADC.FTXchStaApv,'') = '' AND ADC.FTXchStaDoc != '3'";
            } else if ($tSearchStaDoc == 1) {
                $tWhereStaDoc .= " AND ADC.FTXchStaApv = '$tSearchStaDoc'";
            }
        }

        /*สถานะความคลื่อนไหว*/
        // $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        // $tWhereStaDcoAct   = "";
        // if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
        //     if ($tSearchStaDocAct == 2) {
        //         $tWhereStaDcoAct .= " AND AST.FNAjhStaDocAct <> '1' OR AST.FNAjhStaDocAct = NULL";
        //     } else if ($tSearchStaDocAct == 1) {
        //         $tWhereStaDcoAct .= " AND AST.FNAjhStaDocAct = '$tSearchStaDocAct'";
        //     }
        // }

        $tSQL   = " SELECT
                        COUNT (ADC.FTXchDocNo) AS counts
                    FROM TCNTPdtAdjCostHD    ADC WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON ADC.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    INNER JOIN
                    (
                        SELECT DISTINCT 
                        FTXchDocNo
                        FROM TCNTPdtAdjCostDT
                    ) DT ON ADC.FTXchDocNo = DT.FTXchDocNo
                    WHERE 1=1 
                    AND ADC.FNXchDocType = 10 
                    " . $tWhereBch . "
                    " . $tWhereShp . "
                    " . $tWhereBchFrmTo . "
                    " . $tWhereDateFrmTo . "
                    " . $tWhereStaDoc . "
                  ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }

        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Function Get Pdt From Doc
    // Parameters : Function Parameter
    // Creator : 25/02/2021
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCGetPdtFromDoc($paData)
    {
        $nLngID = $paData['FNLngID'];
        $tTable = $paData['tTable'];
        $tDocNo = $paData['tDocNo'];
        $tPdtCodeDup = $paData['tPdtCodeDup'];
        $aPdtCodeDup = (explode(",",$tPdtCodeDup));

        if($tTable == 'TCNTPdtTwiDT'){
            $tPdtField = 'TCNTPdtTwiDT.FTXtdPdtName';
            $tDocNoField = 'TCNTPdtTwiDT.FTXthDocNo';
            $tFactor    = 'TCNTPdtTwiDT.FCXtdFactor';
        }else{
            $tPdtField = 'TAPTPiDT.FTXpdPdtName';
            $tDocNoField = 'TAPTPiDT.FTXphDocNo';
            $tFactor    = 'TAPTPiDT.FCXpdFactor';
        }

        $this->db->select('"'.$tTable.'".FTPdtCode,"'.$tPdtField.'" AS FTPdtName,"'.$tTable.'".FTPunName,TCNMPdtCostAvg.FCPdtCostEx,TCNMPdtUnit_L.FTPunCode,"'.$tFactor.'" AS FCXcdFactor,TCNMPdtBar.FTBarCode AS FTXcdBarScan,0 AS FCXcdDiff,0 AS FCXcdCostNew');
        $this->db->from($tTable);
        $this->db->join('TCNMPdtBar', 'TCNMPdtBar.FTPdtCode = "'.$tTable.'".FTPdtCode','left');
        $this->db->join('TCNMPdtCostAvg', 'TCNMPdtCostAvg.FTPdtCode = "'.$tTable.'".FTPdtCode','left');
        $this->db->join('TCNMPdtPackSize', 'TCNMPdtPackSize.FTPdtCode = "'.$tTable.'".FTPdtCode','left');
        $this->db->join('TCNMPdtUnit_L', 'TCNMPdtUnit_L.FTPunCode = TCNMPdtPackSize.FTPunCode','left');
        if($tPdtCodeDup != ''){
            $this->db->where_not_in('"'.$tTable.'".FTPdtCode',$aPdtCodeDup);
        }
        $this->db->where('"'.$tDocNoField.'"', $tDocNo);
        $oQuery = $this->db->get();

        // echo $this->db->last_query();
        // exit();
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }


    //Functionality : Get HD
    //Parameters : function parameters
    //Creator : 02/03/2021 Sooksanti
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMADCGetHD($paData)
    {

        $tXchDocNo  = $paData['FTXchDocNo'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = " SELECT ADC.FTBchCode,
        BCHLDOC.FTBchName,
        ADC.FTXchDocNo, 
        ADC.FNXchDocType, 
        CONVERT(CHAR(10), ADC.FDXchDocDate, 121) AS FDXchDocDate, 
        CONVERT(CHAR(5), ADC.FTXchDocTime, 108) AS FTXchDocTime, 
        CONVERT(CHAR(10), ADC.FDXchAffect, 121) AS FDXchAffect,
        ADC.FTDptCode, 
        DPTL.FTDptName, 
        ADC.FTXchRefInt, 
        CONVERT(CHAR(10), ADC.FDXchRefIntDate, 121) AS FDXchRefIntDate, 
        ADC.FTXchRmk, 
        ADC.FTXchStaDoc, 
        ADC.FTXchStaApv, 
        ADC.FTCreateBy, 
        USRLCREATE.FTUsrName AS FTUsrNameCreate, 
        ADC.FTXchApvCode, 
        USRAPV.FTUsrName AS FTUsrNameApv
 FROM TCNTPdtAdjCostHD ADC
      LEFT JOIN TCNMBranch_L BCHLDOC WITH(NOLOCK) ON ADC.FTBchCode = BCHLDOC.FTBchCode
                                                     AND BCHLDOC.FNLngID = $nLngID
      LEFT JOIN TCNMBranch_L BCHLTO WITH(NOLOCK) ON ADC.FTXchDocNo = BCHLTO.FTBchCode
                                                    AND BCHLTO.FNLngID = $nLngID
      LEFT JOIN TCNMUser_L USRLKEY WITH(NOLOCK) ON ADC.FTUsrCode = USRLKEY.FTUsrCode
                                                   AND USRLKEY.FNLngID = $nLngID
      LEFT JOIN TCNMUser_L USRLCREATE WITH(NOLOCK) ON ADC.FTCreateBy = USRLCREATE.FTUsrCode
                                                      AND USRLCREATE.FNLngID = $nLngID
      LEFT JOIN TCNMUser_L USRAPV WITH(NOLOCK) ON ADC.FTXchApvCode = USRAPV.FTUsrCode
                                                  AND USRAPV.FNLngID = $nLngID
      LEFT JOIN TCNMUsrDepart_L DPTL WITH(NOLOCK) ON ADC.FTDptCode = DPTL.FTDptCode
                                                     AND DPTL.FNLngID = $nLngID

        WHERE 1=1 AND ADC.FNXchDocType = '10' ";
        if ($tXchDocNo != "") {
            $tSQL .= "AND ADC.FTXchDocNo = '$tXchDocNo'";
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

    // Functionality : Function Get Pdt From Filter
    // Parameters : Function Parameter
    // Creator : 25/02/2021
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCGetPdtFromFilter($paData)
    {
        $tUserLevel = $this->session->userdata("tSesUsrLevel");
        $tAgnCode  = $this->session->userdata("tSesUsrAgnCode");
        $nLngID = $paData['FNLngID'];
        $tPdtCodeFrom = $paData['tPdtCodeFrom'];
        $tPdtCodeTo = $paData['tPdtCodeTo'];
        $tBarCodeFrom = $paData['tBarCodeFrom'];
        $tBarCodeCodeTo = $paData['tBarCodeCodeTo'];
        $tPdtCodeDup = FCNtAddSingleQuote($paData['tPdtCodeDup']);
        $tBchCode    = $paData['tBchCode'];
        
        $tSQL = "
        SELECT * FROM
        (
                    SELECT 
                        ROW_NUMBER() OVER(PARTITION BY PDT.FTPdtCode ORDER BY PDT.FTPdtCode DESC) FNRowID,
                        RANK() OVER(PARTITION BY PDT.FTPdtCode ORDER BY PPCZ.FCPdtUnitFact ASC) FNUnitFactRank,
                        PDT.FTPdtCode, 
                        PDTL.FTPdtName, 
                        PUNL.FTPunName, 
                        COST.FCPdtCostEx,
                        PPCZ.FTPunCode,
                        PPCZ.FCPdtUnitFact AS FCXcdFactor,
                        PBAR.FTBarCode AS FTXcdBarScan,
                        '' AS FCXcdDiff,
                        '' AS FCXcdCostNew,
                        ISNULL(PBAR.FTBarCode, PDT.FTPdtCode) AS FTBarCode
                FROM TCNMPdt PDT
                    LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDT.FTPdtCode = PDTL.FTPdtCode
                                                            AND PDTL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtCostAvg COST WITH(NOLOCK) ON PDT.FTPdtCode = COST.FTPdtCode
                    LEFT JOIN TCNMPdtPackSize PPCZ WITH(NOLOCK) ON PDT.FTPdtCode = PPCZ.FTPdtCode
                    LEFT JOIN TCNMPdtUnit_L PUNL WITH(NOLOCK) ON PPCZ.FTPunCode = PUNL.FTPunCode
                                                                AND PUNL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtBar PBAR WITH (NOLOCK)  ON PDT.FTPdtCode = PBAR.FTPdtCode AND PPCZ.FTPunCode = PBAR.FTPunCode
                    LEFT JOIN TCNMPdtSpcBch SPC WITH (NOLOCK) ON PDT.FTPdtCode = SPC.FTPdtCode
                WHERE 1 = 1
                ";
        
        if($tPdtCodeDup != ''){
            $tSQL .= "AND PDT.FTPdtCode NOT IN($tPdtCodeDup)";
        }

        $tSQL .= " AND ((PDT.FTPdtCode BETWEEN '$tPdtCodeFrom' AND '$tPdtCodeTo'
        OR PDT.FTPdtCode BETWEEN '$tPdtCodeTo' AND '$tPdtCodeFrom')
       OR (PBAR.FTBarCode BETWEEN '$tBarCodeFrom' AND '$tBarCodeCodeTo'
           OR PBAR.FTBarCode BETWEEN '$tBarCodeCodeTo' AND '$tBarCodeFrom'))";


        if($tUserLevel != 'HQ'){
        
            $tSQL  .=" AND ((SPC.FTAgnCode = '$tAgnCode')	OR SPC.FTBchCode = '$tBchCode'
                        OR (ISNULL(SPC.FTBchCode,'') = '' AND SPC.FTAgnCode = '$tAgnCode')
                        OR ISNULL(SPC.FTAgnCode,'') = '' )";
            
        }

        $tSQL .= ") A WHERE A.FNRowID = 1 AND FNUnitFactRank = 1 ORDER BY A.FTPdtCode DESC";


        // echo $tSQL;
        // exit();
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }


        // Functionality : Function Get Pdt From Filter
    // Parameters : Function Parameter
    // Creator : 25/02/2021
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCGetPdtFromImportExcel($paData)
    {
        $nLngID = $paData['FNLngID'];
        $tPdtCodeDup = FCNtAddSingleQuote($paData['tPdtCodeDup']);
        $tFTSessionID  = $paData['FTSessionID'];
        $tSQL = "SELECT DOCTMP.FTPdtCode, 
                        PDTL.FTPdtName, 
                        PUNL.FTPunName, 
                        COST.FCPdtCostEx,
                        PPCZ.FTPunCode,
                        PPCZ.FCPdtUnitFact AS FCXcdFactor,
                        PBAR.FTBarCode AS FTXcdBarScan,
                        (DOCTMP.FCXtdCostEx - COST.FCPdtCostEx) AS FCXcdDiff,
                        DOCTMP.FCXtdCostEx AS FCXcdCostNew,
                        DOCTMP.FTTmpStatus,
                        DOCTMP.FTTmpRemark
                FROM TCNTDocDTTmp DOCTMP
                    LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON DOCTMP.FTPdtCode = PDTL.FTPdtCode
                                                            AND PDTL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtCostAvg COST WITH(NOLOCK) ON DOCTMP.FTPdtCode = COST.FTPdtCode
                    LEFT JOIN TCNMPdtPackSize PPCZ WITH(NOLOCK) ON DOCTMP.FTPdtCode = PPCZ.FTPdtCode
                    LEFT JOIN TCNMPdtUnit_L PUNL WITH(NOLOCK) ON PPCZ.FTPunCode = PUNL.FTPunCode
                                                                AND PUNL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtBar PBAR WITH (NOLOCK)  ON DOCTMP.FTPdtCode = PBAR.FTPdtCode
                    LEFT JOIN TCNMPdtSpcBch SPC WITH (NOLOCK) ON DOCTMP.FTPdtCode = SPC.FTPdtCode
                WHERE 1 = 1
                AND DOCTMP.FTXthDocKey = 'TCNTPdtAdjCostHD' 
                AND DOCTMP.FTSessionID = '$tFTSessionID'
                ";
        
        if($tPdtCodeDup != ''){
            $tSQL .= "AND DOCTMP.FTPdtCode NOT IN($tPdtCodeDup)";
        }
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Functionality : INSERT DT
    // Parameters : Function Parameter
    // Creator : 25/02/2021 Sooksanti(Nont)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCEventAddDT($paData)
    {
            $this->db->insert('TCNTPdtAdjCostDT', $paData);
            if ($this->db->affected_rows() > 0) {
                $aResult = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode' => '99',
                    'rtDesc' => 'data not found',
                );
            }
    }


    // Functionality : Clear DT
    // Parameters : Function Parameter
    // Creator : 25/02/2021 Sooksanti(Nont)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCClearDT($paData)
    {
        $this->db->where_in('FTXchDocNo', $paData['FTXchDocNo']);
        $this->db->delete('TCNTPdtAdjCostDT');
    }



    // Functionality : INSERT HD
    // Parameters : Function Parameter
    // Creator : 25/02/2021
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCEventAddHD($paData)
    {
        if($paData['FDXchRefIntDate'] == ''){
            $FDXchRefIntDate = NULL;
        }else{
            $FDXchRefIntDate = $paData['FDXchRefIntDate'];
        }
        $this->db->insert('TCNTPdtAdjCostHD', array(
            'FTBchCode'         => $paData['FTBchCode'],
            'FTXchDocNo'        => $paData['FTXchDocNo'],
            'FNXchDocType'      => $paData['FNXchDocType'],
            'FDXchDocDate'      => $paData['FDXchDocDate'],
            'FTXchDocTime'         => $paData['FTXchDocTime'],
            'FDXchAffect'      => $paData['FDXchAffect'],
            'FTXchRefInt'      => $paData['FTXchRefInt'],
            'FDXchRefIntDate'       => $FDXchRefIntDate,
            'FTUsrCode'         => $paData['FTUsrCode'],
            'FTXchStaDoc'         => $paData['FTXchStaDoc'],
            'FTXchRmk'      => $paData['FTXchRmk'],
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUserCode'),
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $this->session->userdata('tSesUserCode')
        ));

        if ($this->db->affected_rows() > 0) {
            $aResult = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        return $aResult;
    }

    // Functionality : Edit HD
    // Parameters : Function Parameter
    // Creator : 25/02/2021 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCEventEditHD($paData)
    {
        if($paData['FDXchRefIntDate'] == ''){
            $FDXchRefIntDate = NULL;
        }else{
            $FDXchRefIntDate = $paData['FDXchRefIntDate'];
        }
        $this->db->set('FTBchCode', $paData['FTBchCode']);
        $this->db->set('FDXchDocDate', $paData['FDXchDocDate']);
        $this->db->set('FTXchDocTime', $paData['FTXchDocTime']);
        $this->db->set('FDXchAffect', $paData['FDXchAffect']);
        $this->db->set('FTXchRefInt', $paData['FTXchRefInt']);
        $this->db->set('FDXchRefIntDate', $FDXchRefIntDate);
        $this->db->set('FTUsrCode', $paData['FTUsrCode']);
        $this->db->set('FTXchRmk', $paData['FTXchRmk']);
        $this->db->set('FDLastUpdOn', date('Y-m-d h:i:sa'));
        $this->db->set('FTLastUpdBy', $this->session->userdata('tSesUserCode'));
        $this->db->where('FTXchDocNo', $paData['FTXchDocNo']);
        $this->db->update('TCNTPdtAdjCostHD');

        if ($this->db->affected_rows() > 0) {
            $aResult = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        return $aResult;
    }


    // Functionality : Function Get Pdt From DT
    // Parameters : Function Parameter
    // Creator : 25/02/2021 Sooksanti (Nont)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMADCGetPdtFromDT($paData)
    {
        $tDocNo = $paData['tDocNo'];
        $nLngID = $this->session->userdata("tLangEdit");
        
        $tSQL = "SELECT ADCDT.FTPdtCode, 
                        ADCDT.FTPdtName, 
                        PUNL.FTPunName,
                        ADCDT.FCXcdCostOld AS FCPdtCostEx,
                        ADCDT.FCXcdDiff,
                        ADCDT.FCXcdCostNew,
                        ADCDT.FTPunCode,
                        ADCDT.FCXcdFactor,
                        ADCDT.FTXcdBarScan
                FROM TCNTPdtAdjCostDT ADCDT
                    LEFT JOIN TCNMPdtUnit_L PUNL WITH(NOLOCK) ON ADCDT.FTPunCode = PUNL.FTPunCode
                WHERE 1 = 1
                ";
    

        if($tDocNo != ''){
            $tSQL .= "AND ADCDT.FTXchDocNo = '$tDocNo'";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }


    //Functionality : Function Cancel Doc
    //Parameters : function parameters
    //Creator : 03/03/2021
    //Last Modified : -
    //Return : Status Cancel
    //Return Type : array
    public function FSaMADCCancel($paDataUpdate)
    {
        try {
            $this->db->set('FTXchStaDoc', 3);
            $this->db->where('FTXchDocNo', $paDataUpdate['FTXchDocNo']);
            $this->db->update('TCNTPdtAdjCostHD');
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

    // Functionality : Delete HD/DT Document Adjust Cost
    // Parameters : function parameters
    // Creator : 03/03/2021 Sooksanti
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSnMADCDelDocument($paDataDoc)
    {
        $tADCDocNo  = $paDataDoc['tADCDocNo'];

        $this->db->trans_begin();

        // Document HD 
        $this->db->where_in('FTXchDocNo', $tADCDocNo);
        $this->db->delete('TCNTPdtAdjCostHD');

        // Document DT
        $this->db->where_in('FTXchDocNo', $tADCDocNo);
        $this->db->delete('TCNTPdtAdjCostDT');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStaDeleteDoc  = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStaDeleteDoc  = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }
        return $aStaDeleteDoc;
    }


    //Functionality : Function Approve Doc
    //Parameters : function parameters
    //Creator : Sooksanti
    //Last Modified : 
    //Return : Status Approve
    //Return Type : array
    public function FSvMADCApprove($paDataUpdate)
    {
        try {
            $dLastUpdOn = date('Y-m-d H:i:s');
            $tLastUpdBy = $this->session->userdata('tSesUsername');
            $this->db->set('FDLastUpdOn', $dLastUpdOn);
            $this->db->set('FTLastUpdBy', $tLastUpdBy);

            $this->db->set('FTXchStaApv', 2);
            $this->db->set('FTXchStaPrcDoc', 2);
            $this->db->set('FTXchApvCode', $paDataUpdate['FTXchApvCode']);
            $this->db->where('FTXchDocNo', $paDataUpdate['FTXchDocNo']);

            $this->db->update('TCNTPdtAdjCostHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode'  => '1',
                    'rtDesc'  => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode'  => '903',
                    'rtDesc'  => 'Not Approve',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }
}
