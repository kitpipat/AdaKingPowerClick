<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mInterfaceHistory extends CI_Model
{
    //Functionality : list Recive
    //Parameters : function parameters
    //Creator :  11/05/2018 Wasin
    //Last Modified : Napat(Jame) 03/04/63
    //Return : data
    //Return Type : Array
    public function FSaMIFHList($paData)
    {

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tLangEdit = $this->session->userdata("tLangEdit");
        
        $tSubQuery = "  SELECT
                            HIS.FTLogTask,
                            HIS.FTLogType,
                            HIS.FTLogStaSend,
                            HIS.FTLogTaskRef,
                            HIS.FTLogStaPrc,HIS.FNLogQtyAll,HIS.FNLogQtyDone,
                            LOGAPI.FTLogErrMsg AS FTErrDesc,
                            LOGAPI.FTLogRefNo,
                            /*LOGAPI.FDCreateOn AS FDLogCreate,
                            HIS.FDCreateOn AS FDLogCreateIm,*/
                            CASE WHEN HIS.FTLogType = '1' THEN HIS.FDCreateOn ELSE LOGAPI.FDCreateOn END AS FDCreateLog
                        FROM TLKTLogHis HIS WITH (NOLOCK)
                        INNER JOIN TCNMTxnAPI API WITH (NOLOCK) ON HIS.FTApiCode = API.FTApiCode
                        LEFT JOIN TCNMTxnAPI_L API_L WITH (NOLOCK) ON API.FTApiCode =  API_L.FTApiCode AND API_L.FNLngID = $tLangEdit
                        LEFT JOIN (
                            SELECT
                                B.FTXshDocNo,B.FTLogErrMsg,B.FTLogRefNo,B.FDCreateOn
                            FROM (
                                SELECT FTXshDocNo, MAX(FDLogDate) AS FDLogDate 
                                FROM TLKTLogAPI WITH(NOLOCK) 
                                GROUP BY FTXshDocNo
                            ) A
                            LEFT JOIN TLKTLogAPI B WITH(NOLOCK) ON A.FTXshDocNo = B.FTXshDocNo AND A.FDLogDate = B.FDLogDate
                        ) LOGAPI ON HIS.FTlogTaskRef = LOGAPI.FTXshDocNo
                        WHERE (API.FTApiTxnType = '4' OR API.FTApiTxnType = '1') AND API.FTApiStaDisPlay = '1' ";

        $tSearchList = $paData['aPackDataSearch']['tIFHSearchAll'];
        if (!empty($tSearchList)) {
            $tSubQuery .= " AND ( HIS.FTLogTask LIKE '%$tSearchList%' OR HIS.FTLogTaskRef LIKE '%$tSearchList%' ) ";
        }

        $tStatusIFH = $paData['aPackDataSearch']['tIFHStatus'];
        if (!empty($tStatusIFH)) {
            $tSubQuery .= " AND HIS.FTLogStaPrc = '$tStatusIFH'";
        }

        $nIFHType =  $paData['aPackDataSearch']['tIFHType'];
        if (!empty($nIFHType)) {
            $tSubQuery .= " AND HIS.FTLogType = '$nIFHType'";
        }

        $tIFHInfCode = $paData['aPackDataSearch']['tIFHInfCode'];
        if (!empty($tIFHInfCode)) {
            $tSubQuery .= " AND API_L.FTApiCode = '$tIFHInfCode'";
        }

        $tIFHDateFrom = $paData['aPackDataSearch']['tIFHDateFrom'];
        $tIFHDateTo = $paData['aPackDataSearch']['tIFHDateTo'];
        if (!empty($tIFHDateFrom) && !empty($tIFHDateTo)) {
            $tSubQuery .= " AND ( CASE WHEN HIS.FTLogType = '1' THEN HIS.FDCreateOn ELSE LOGAPI.FDCreateOn END BETWEEN CONVERT(datetime,'$tIFHDateFrom 00:00:00') AND CONVERT(datetime,'$tIFHDateTo 23:59:59') 
				           OR CASE WHEN HIS.FTLogType = '1' THEN HIS.FDCreateOn ELSE LOGAPI.FDCreateOn END BETWEEN CONVERT(datetime,'$tIFHDateTo 23:00:00') AND CONVERT(datetime,'$tIFHDateFrom 00:00:00') ) ";
        //   if (isset($nIFHType) && $nIFHType=='1') {
        //     $tSubQuery .= " AND ((HIS.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateFrom 00:00:00') AND CONVERT(datetime,'$tIFHDateTo 23:59:59')) ";
        //     $tSubQuery .= " OR (HIS.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateTo 23:00:00') AND CONVERT(datetime,'$tIFHDateFrom 00:00:00'))) ";
        //   }elseif (isset($nIFHType) && $nIFHType=='2') {
        //     $tSubQuery .= " AND ((LOGAPI.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateFrom 00:00:00') AND CONVERT(datetime,'$tIFHDateTo 23:59:59')) ";
        //     $tSubQuery .= " OR (LOGAPI.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateTo 23:00:00') AND CONVERT(datetime,'$tIFHDateFrom 00:00:00'))) ";
        //   }else {
        //     $tSubQuery .= " AND (((HIS.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateFrom 00:00:00') AND CONVERT(datetime,'$tIFHDateTo 23:59:59')) ";
        //     $tSubQuery .= " OR (HIS.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateTo 23:00:00') AND CONVERT(datetime,'$tIFHDateFrom 00:00:00'))) ";
        //     $tSubQuery .= " OR ((LOGAPI.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateFrom 00:00:00') AND CONVERT(datetime,'$tIFHDateTo 23:59:59')) ";
        //     $tSubQuery .= " OR (LOGAPI.FDCreateOn BETWEEN CONVERT(datetime,'$tIFHDateTo 23:00:00') AND CONVERT(datetime,'$tIFHDateFrom 00:00:00')))) ";
        //   }

        }

        $oSubQuery = $this->db->query($tSubQuery);

        $tSQL = "
            SELECT
                c.*
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FDCreateLog DESC) AS FNRowID,*
                FROM (
                    $tSubQuery
            ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]
        ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            // $aFoundRow = $this->FSnMIFHGetPageAll($paData);
            $nFoundRow = $oSubQuery->num_rows(); //$aFoundRow[0]->counts
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else { // No Data
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

    //Functionality : All Page Of Recive
    //Parameters : function parameters
    //Creator :  11/05/2018 Wasin
    //Last Modified : Napat(Jame) 03/04/63
    //Return : data
    //Return Type : Array
    // public function FSnMIFHGetPageAll($paData){
    //     $tLangEdit                   = $this->session->userdata("tLangEdit");
    //     // $tSQL = "SELECT COUNT (TLK.FTInfCode) AS counts
    //     //          FROM TLKTHistory TLK WITH(NOLOCK)
    //     //          LEFT JOIN [TSysLnk] TLKHD ON TLK.FTInfCode = TLKHD.FTInfCode
    //     //          LEFT JOIN [TSysLnk_L] LNK_L ON TLKHD.FTInfCode = LNK_L.FTInfCode AND LNK_L.FNLngID = $tLangEdit
    //     //          WHERE 1=1 ";

    //     $tSQL = "   SELECT COUNT(HIS.FNLogID) AS counts
    //                 FROM TLKTLogHis HIS WITH(NOLOCK)
    //                 LEFT JOIN TCNMTxnAPI_L API_L on HIS.FTLogTask =  API_L.FTApiName
    //                 WHERE 1=1
    //             ";

    //     $tSearchList = $paData['aPackDataSearch']['tIFHSearchAll'];
    //     if(!empty($tSearchList)){
    //         $tSQL .= " AND HIS.FTLogTask LIKE '%$tSearchList%'";
    //     }

    //     $tStatusIFH = $paData['aPackDataSearch']['tIFHStatus'];
    //     if(!empty($tStatusIFH)){
    //         $tSQL .= " AND HIS.FTLogStaPrc = '$tStatusIFH' ";
    //     }

    //     $nIFHType =  $paData['aPackDataSearch']['tIFHType'];
    //     if(!empty($nIFHType)){
    //         $tSQL .= " AND HIS.FTLogType = '$nIFHType' ";
    //     }

    //     $tIFHInfCode = $paData['aPackDataSearch']['tIFHInfCode'];
    //     if(!empty($tIFHInfCode)){
    //         $tSQL .= " AND API_L.FTApiCode = '$tIFHInfCode' ";
    //     }

    //     // $tSearchList = $paData['aPackDataSearch']['tIFHSearchAll'];
    //     // if(!empty($tSearchList)){
    //     //     $tSQL .= " AND (LNK_L.FTInfName LIKE '%$tSearchList%'";
    //     //     $tSQL .= " OR  TLKHD.FTInfCode LIKE '%$tSearchList%')";
    //     // }

    //     // $tStatusIFH = $paData['aPackDataSearch']['tIFHStatus'];
    //     // if(!empty($tStatusIFH)){
    //     //     $tSQL .= " AND TLK.FTStaDone = '$tStatusIFH' ";
    //     // }

    //     // $nIFHType =  $paData['aPackDataSearch']['tIFHType'];
    //     // if(!empty($nIFHType)){
    //     //     $tSQL .= " AND TLKHD.FTInfTypeDoc = '$nIFHType' ";
    //     // }

    //     // $tIFHInfCode = $paData['aPackDataSearch']['tIFHInfCode'];
    //     // if(!empty($tIFHInfCode)){
    //     //     $tSQL .= " AND TLKHD.FTInfCode = '$tIFHInfCode' ";
    //     // }

    //     // $tIFHDateFrom   = $paData['aPackDataSearch']['tIFHDateFrom'];
    //     // $tIFHDateTo     = $paData['aPackDataSearch']['tIFHDateTo'];
    //     // if(!empty($tIFHDateFrom) && !empty($tIFHDateTo)){
    //     //     $tSQL .= " AND ((TLK.FDHisDate BETWEEN CONVERT(datetime,'$tIFHDateFrom 00:00:00') AND CONVERT(datetime,'$tIFHDateTo 23:59:59')) ";
    //     //     $tSQL .= " OR (TLK.FDHisDate BETWEEN CONVERT(datetime,'$tIFHDateTo 23:00:00') AND CONVERT(datetime,'$tIFHDateFrom 00:00:00'))) ";
    //     // }

    //     $oQuery = $this->db->query($tSQL);
    //     if ($oQuery->num_rows() > 0) {
    //         return $oQuery->result();
    //     }else{
    //         //No Data
    //         return false;
    //     }
    // }

    //Functionality : Get All Data From Table [TSysLnk]
    //Parameters : lang
    //Creator :  30/03/2020 Napat(Jame)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMIFHGetLnkAll()
    {
        $tLangEdit = $this->session->userdata("tLangEdit");

        $tSQL = "
            SELECT
                API.FTApiTxnType AS FTApiTxnType,
                API.FTApiCode AS FTApiCode,
                API_L.FTApiName AS FTApiName
            FROM TCNMTxnAPI API WITH (NOLOCK)
            LEFT JOIN TCNMTxnAPI_L API_L WITH (NOLOCK) ON API.FTApiCode = API_L.FTApiCode AND API_L.FNLngID = $tLangEdit
            WHERE ((API.FTApiTxnType = '4' AND API.FTApiStaDisPlay = '1') OR API.FTApiTxnType = '1')
            ORDER BY FTApiTxnType ASC
        ";
        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array();
    }

    public function FStMIFHGetPathLoadFile()
    {
        $tSQL = "
            SELECT TOP 1
                CASE
                    WHEN ISNULL(FTCfgStaUsrValue,'') = '' THEN FTCfgStaDefValue
                    ELSE FTCfgStaUsrValue
                END AS FTCfgStaValue
            FROM TLKMConfig WITH(NOLOCK)
            WHERE FTCfgCode='tLK_BackupPath'
            AND FTCfgApp = 'LINK'
            AND FTCfgKey = 'Center'
            AND FTCfgSeq = '1'
        ";
        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array()[0]['FTCfgStaValue'];
    }

    public function FStMIFHGetPathRefLoadFile()
    {
        $tSQL = "
            SELECT TOP 1
                CASE
                    WHEN ISNULL(FTCfgStaUsrRef,'') = '' THEN FTCfgStaDefRef
                    ELSE FTCfgStaUsrRef
                END AS FTCfgStaRef
            FROM TLKMConfig WITH(NOLOCK)
            WHERE FTCfgCode='tLK_BackupPath'
            AND FTCfgApp = 'LINK'
            AND FTCfgKey = 'Center'
            AND FTCfgSeq = '1'
        ";
        $oQuery = $this->db->query($tSQL);

        return $oQuery->result_array()[0]['FTCfgStaRef'];
    }
}
