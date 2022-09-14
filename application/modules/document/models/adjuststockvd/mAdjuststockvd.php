<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAdjuststockvd extends CI_Model {

    //List
    public function FSaMADJVDList($paData){
        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID         = $paData['FNLngID'];
        $oAdvanceSearch = $paData['oAdvanceSearch'];
        @$tSearchList   = $oAdvanceSearch['tSearchAll'];

        $tWhereSearch = '';
        if ($tSearchList != '') {
            $tWhereSearch .= " AND ((TFW.FTAjhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // Check User Level
        $tWhereBch = '';
        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tWhereBch = "AND TFW.FTBchCode IN($tBchCode)";
        }

        // Check User Level
        $tWhereShp = '';
        if ($this->session->userdata('tSesUsrLevel') == "SHP") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่ร้านค้าที่ login 
            $tShpCode = $this->session->userdata('tSesUsrShpCodeMulti');
            $tWhereShp = "AND TFW.FTAjhShopTo IN($tShpCode)";
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
            if ($tSearchStaDoc == 3) {
                $tWhereStaDoc = " AND TFW.FTAjhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tWhereStaDoc = " AND ISNULL(TFW.FTAjhStaApv,'') = '' AND TFW.FTAjhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tWhereStaDoc = " AND TFW.FTAjhStaApv = '$tSearchStaDoc'";
            }
        }

        
        // ค้นหาสถานะประมวลผล
        $tSearchStaPrcStk   = $oAdvanceSearch['tSearchStaPrcStk'];
        $tWhereStaPrcStk   = "";
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tWhereStaPrcStk = " AND (TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(TFW.FTAjhStaPrcStk,'') = '') ";
            } else {
                $tWhereStaPrcStk = " AND TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaAct = $oAdvanceSearch['tSearchStaAct'];
        $tWhereStaAct   = "";
        if (!empty($tSearchStaAct) && ($tSearchStaAct != "0")) {
            if ($tSearchStaAct == 1) {
                $tWhereStaAct = " AND TFW.FNAjhStaDocAct = 1";
            } else {
                $tWhereStaAct = " AND TFW.FNAjhStaDocAct = 0";
            }
        }
        $tSQL   = " SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTXthDocNo DESC) AS FNRowID,* FROM(
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
                                    USRLAPV.FTUsrName   AS FTXthApvName,
                                    TFW.FDCreateOn
                                FROM TCNTPdtAdjStkHD  TFW       WITH (NOLOCK)
                                LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON TFW.FTBchCode      = BCHL.FTBchCode        AND BCHL.FNLngID    = $nLngID 
                                LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON TFW.FTCreateBy     = USRL.FTUsrCode        AND USRL.FNLngID    = $nLngID 
                                LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON TFW.FTAjhApvCode   = USRLAPV.FTUsrCode     AND USRLAPV.FNLngID = $nLngID
                                WHERE 1=1 AND TFW.FTAjhDocType = '3'
                                ".$tWhereSearch."
                                ".$tWhereBch."
                                ".$tWhereShp."
                                ".$tWhereBchFrmTo."
                                ".$tWhereDateFrmTo."
                                ".$tWhereStaDoc."
                                ".$tWhereStaPrcStk."
                                ".$tWhereStaAct."
                            ) HD
                            INNER JOIN (SELECT DISTINCT FTAjhDocNo FROM TCNTPdtAdjStkDT WHERE FNCabSeq >= 0 ) DT ON HD.FTXthDocNo = DT.FTAjhDocNo
                        ) Base ) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSnMADJVDGetPageAll($paData);
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

    //Number Page
    public function FSnMADJVDGetPageAll($paData){
        $nLngID         = $paData['FNLngID'];
        $oAdvanceSearch = $paData['oAdvanceSearch'];
        @$tSearchList   = $oAdvanceSearch['tSearchAll'];

        $tWhereSearch = '';
        if ($tSearchList != '') {
            $tWhereSearch .= " AND ((TFW.FTAjhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // Check User Level
        $tWhereBch = '';
        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tWhereBch = "AND TFW.FTBchCode IN($tBchCode)";
        }

        // Check User Level
        $tWhereShp = '';
        if ($this->session->userdata('tSesUsrLevel') == "SHP") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่ร้านค้าที่ login 
            $tShpCode = $this->session->userdata('tSesUsrShpCodeMulti');
            $tWhereShp = "AND TFW.FTAjhShopTo IN($tShpCode)";
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
            if ($tSearchStaDoc == 3) {
                $tWhereStaDoc = " AND TFW.FTAjhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tWhereStaDoc = " AND ISNULL(TFW.FTAjhStaApv,'') = '' AND TFW.FTAjhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tWhereStaDoc = " AND TFW.FTAjhStaApv = '$tSearchStaDoc'";
            }
        }

        
        // ค้นหาสถานะประมวลผล
        $tSearchStaPrcStk   = $oAdvanceSearch['tSearchStaPrcStk'];
        $tWhereStaPrcStk   = "";
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tWhereStaPrcStk = " AND (TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(TFW.FTAjhStaPrcStk,'') = '') ";
            } else {
                $tWhereStaPrcStk = " AND TFW.FTAjhStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaAct = $oAdvanceSearch['tSearchStaAct'];
        $tWhereStaAct   = "";
        if (!empty($tSearchStaAct) && ($tSearchStaAct != "0")) {
            if ($tSearchStaAct == 1) {
                $tWhereStaAct = " AND TFW.FNAjhStaDocAct = 1";
            } else {
                $tWhereStaAct = " AND TFW.FNAjhStaDocAct = 0";
            }
        }

        $tSQL = "   SELECT COUNT (TFW.FTAjhDocNo) AS counts
                    FROM [TCNTPdtAdjStkHD]  TFW WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L  BCHL     WITH (NOLOCK) ON TFW.FTBchCode      = BCHL.FTBchCode        AND BCHL.FNLngID    = $nLngID 
                    LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON TFW.FTCreateBy     = USRL.FTUsrCode        AND USRL.FNLngID    = $nLngID 
                    LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON TFW.FTAjhApvCode   = USRLAPV.FTUsrCode     AND USRLAPV.FNLngID = $nLngID
                    INNER JOIN (SELECT DISTINCT FTAjhDocNo FROM TCNTPdtAdjStkDT WHERE FNCabSeq >= 0 ) DT ON TFW.FTAjhDocNo = DT.FTAjhDocNo
                    WHERE 1=1 
                    AND TFW.FTAjhDocType = '3'
                    ".$tWhereSearch."
                    ".$tWhereBch."
                    ".$tWhereShp."
                    ".$tWhereBchFrmTo."
                    ".$tWhereDateFrmTo."
                    ".$tWhereStaDoc."
                    ".$tWhereStaPrcStk."
                    ".$tWhereStaAct."
                ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //ลบข้อมูลใน Tmp
    public function FSxMClearPdtInTmp(){
        $tSQL = "DELETE FROM TCNTDocDTTmp WHERE FTSessionID = '".$this->session->userdata('tSesSessionID')."' AND FTXthDocKey = 'TCNTPdtAdjStkHD'";
        $this->db->query($tSQL);
    }

    //ลบข้อมูลใน Tmp
    public function FSxMDeleteDoctemForNewEvent($paInfor){
        $tSQL = "DELETE FROM TCNTDocDTTmp WHERE
                FTBchCode = '".$paInfor["tBchCode"]."' AND
                FTSessionID = '".$this->session->userdata('tSesSessionID')."' AND
                FTXthDocKey = '".$paInfor["FTXthDocKey"]."'";
        $this->db->query($tSQL);
    }

    //เช็คข้อมูลจาก Temp
    public function FSaMADJVDGetPdtLayoutToTem($paInfoWhere){
        $tSQL = "SELECT PDT.FTPdtCode,
                    PDTL.FTPdtName,
                    PDTLYO.FNLayRow,
                    PDTLYO.FNLayCol,
                    PDTLYO.FCLayColQtyMax, 
                    PDTLYO.FNCabSeq,
                    PDTLYO.FTBchCode,
                    PDTLYO.FTShpCode,
                    ISNULL( 
                        (SELECT FCStkQty FROM TVDTPdtStkBal WHERE FTWahCode = '".$paInfoWhere["tWahCode"]."' 
                        AND FTBchCode = '".$paInfoWhere["tBchCode"]."'
                        AND FNCabSeq = PDTLYO.FNCabSeq
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

    //ถ้าใน Tmp มีข้อมูลจะเอาไป insert อีกรอบ
    public function FSxMADJVDUpdateDocTmpPdtFromDT($aDataInsert){

        if($aDataInsert["FCDateTimeInputForADJSTKVD"] == NULL){
            $tADJDate = 'NULL';
        }else{
            $tADJDate = $aDataInsert['FCDateTimeInputForADJSTKVD'];
            $tADJDate = "'".$tADJDate."'";
        }

        $tSQL = "INSERT INTO TCNTDocDTTmp(
                    FTBchCode,
                    FTXtdShpTo,
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
                    FCAjdWahB4Adj,
                    FTSessionID
                ) 
                 VALUES(
                     '".$aDataInsert["FTBchCode"]."',
                     '".$aDataInsert["FTShpCode"]."',
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
                     $tADJDate,
                     '".$aDataInsert["FNCabSeq"]."',
                     '".$aDataInsert["FCAjdWahB4Adj"]."',
                     '".$this->session->userdata('tSesSessionID')."'
                 )";    

        $this->db->query($tSQL);
    }

    //ดึงข้อมูลจาก Temp
    public function FSaMADJVDGetPdtLayoutFRomTem($paInfoWhere){
        $aRowLen  = FCNaHCallLenData($paInfoWhere['nRow'],$paInfoWhere['nPage']);
        $tSQL = "SELECT C.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FNCabSeqForTWXVD,FNLayRowForADJSTKVD,FNLayColForADJSTKVD) AS FNRowID,* FROM
                        (
                            SELECT 
                                TMP.FNXtdSeqNo,
                                TMP.FTPdtCode,
                                TMP.FTXtdPdtName AS FTPdtName,
                                TMP.FNLayRowForADJSTKVD,
                                TMP.FNLayColForADJSTKVD,
                                TMP.FCLayColQtyMaxForADJSTKVD, 
                                TMP.FCStkQty,
                                TMP.FCUserInPutForADJSTKVD,
                                TMP.FCDateTimeInputForADJSTKVD,
                                TMP.FNCabSeqForTWXVD,
                                TMP.FCAjdWahB4Adj,
                                CABL.FTCabName
                            FROM TCNTDocDTTmp TMP
                            LEFT JOIN TVDMShopCabinet_L CABL ON TMP.FNCabSeqForTWXVD = CABL.FNCabSeq AND TMP.FTBchCode = CABL.FTBchCode AND FNLngID = 1
                            AND CABL.FTShpCode = TMP.FTXtdShpTo
                            WHERE TMP.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                            AND TMP.FTXthDocNo = '".$paInfoWhere["tXthDocNo"]."'
                            AND TMP.FTXthDocKey = '".$paInfoWhere["FTXthDocKey"]."'
                            AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                        ) AS TVDTPdtPlanel
                ) AS C ";
        $tSQL .= " WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aFoundRow  = $this->FSnMADJVDGetPageAllInTemp($paInfoWhere);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paInfoWhere['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oQuery->result_array(),
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paInfoWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paInfoWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาจำนวนทั้งหมดใน Temp
    public function FSnMADJVDGetPageAllInTemp($paInfoWhere){
        $tSQL = "SELECT COUNT (TMP.FTXthDocNo) AS counts FROM TCNTDocDTTmp TMP
                LEFT JOIN TVDMShopCabinet_L CABL ON TMP.FNCabSeqForTWXVD = CABL.FNCabSeq AND TMP.FTBchCode = CABL.FTBchCode AND CABL.FTShpCode = TMP.FTXtdShpTo AND FNLngID = 1
                WHERE TMP.FTBchCode = '".$paInfoWhere["tBchCode"]."'
                AND TMP.FTXthDocNo = '".$paInfoWhere["tXthDocNo"]."'
                AND TMP.FTXthDocKey = '".$paInfoWhere["FTXthDocKey"]."'
                AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //อัพเดท จำนวนที่นับได้
    public function FSnMADJVDUpdateInlineDTTemp($aDataUpd,$aDataWhere){
        try{
            $this->db->where('FTSessionID', $this->session->userdata('tSesSessionID'));
            $this->db->where('FTXthDocNo', $aDataWhere['FTXthDocNo']);
            $this->db->where('FTBchCode', $aDataWhere['FTBchCode']);
            $this->db->where('FTXtdShpTo', $aDataWhere['FTShpCode']);
            $this->db->where('FNCabSeqForTWXVD', $aDataWhere['FNCabSeqForTWXVD']);
            $this->db->where('FNXtdSeqNo', $aDataWhere['FNXtdSeqNo']);
            $this->db->where('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->update('TCNTDocDTTmp',$aDataUpd);

            // echo $this->db->last_query();
            // die;

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

    //กดบึนทึกต้อง เช็คก่อนว่ามีใน Temp ไหม
    public function FSnMADJVDCheckPdtTemp($tDocNo){
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

    //บันทึก HD
    public function FSaMADJVDAddUpdateHD($paData){
        try{
            //Update Master
            $this->db->set('FTBchCode'              , $paData['FTBchCode']);
            $this->db->set('FNAjhDocType'           , '11');
            $this->db->set('FTAjhDocType'           , '3');
            $this->db->set('FTAjhApvSeqChk'         , '1');
            $this->db->set('FDAjhDocDate'           , $paData['FDAjhDocDate']);
            $this->db->set('FTAjhBchTo'             , $paData['FTAjhBchTo']);
            $this->db->set('FTAjhMerchantTo'        , $paData['FTAjhMerchantTo']);
            $this->db->set('FTAjhShopTo'            , $paData['FTAjhShopTo']);
            $this->db->set('FTAjhPosTo'             , $paData['FTAjhPosTo']);
            $this->db->set('FTAjhWhTo'              , $paData['FTAjhWhTo']);
            $this->db->set('FTAjhPlcCode'           , $paData['FTAjhPlcCode']);
            $this->db->set('FTDptCode'              , $paData['FTDptCode']);
            $this->db->set('FTUsrCode'              , $paData['FTUsrCode']);
            $this->db->set('FTRsnCode'              , $paData['FTRsnCode']);
            $this->db->set('FTAjhRmk'               , $paData['FTAjhRmk']);
            $this->db->set('FNAjhDocPrint'          , $paData['FNAjhDocPrint']);
            $this->db->set('FTAjhApvCode'           , $paData['FTAjhApvCode']);
            $this->db->set('FTAjhStaApv'            , $paData['FTAjhStaApv']);
            $this->db->set('FTAjhStaPrcStk'         , $paData['FTAjhStaPrcStk']);
            $this->db->set('FTAjhStaDoc'            , $paData['FTAjhStaDoc']);
            $this->db->set('FNAjhStaDocAct'         , $paData['FNAjhStaDocAct']);
            $this->db->set('FTAjhDocRef'            , $paData['FTAjhDocRef']);
            $this->db->set('FTAjhStaDelMQ'          , $paData['FTAjhStaDelMQ']);
            $this->db->set('FDLastUpdOn'            , $paData['FDLastUpdOn']);
            $this->db->set('FDCreateOn'             , $paData['FDCreateOn']);
            $this->db->set('FTCreateBy'             , $paData['FTCreateBy']);
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
                    'FTAjhDocNo'            => $paData['FTAjhDocNo'],
                    'FNAjhDocType'          => '11',
                    'FTAjhDocType'          => '3',
                    'FTAjhApvSeqChk'        => '1',
                    'FTBchCode'             => $paData['FTBchCode'],
                    'FDAjhDocDate'          => $paData['FDAjhDocDate'],
                    'FTAjhBchTo'            => $paData['FTAjhBchTo'],
                    'FTAjhMerchantTo'       => $paData['FTAjhMerchantTo'],
                    'FTAjhShopTo'           => $paData['FTAjhShopTo'],
                    'FTAjhPosTo'            => $paData['FTAjhPosTo'],
                    'FTAjhWhTo'             => $paData['FTAjhWhTo'],
                    'FTAjhPlcCode'          => $paData['FTAjhPlcCode'],
                    'FTDptCode'             => $paData['FTDptCode'],
                    'FTUsrCode'             => $paData['FTUsrCode'],
                    'FTRsnCode'             => $paData['FTRsnCode'],
                    'FTAjhRmk'              => $paData['FTAjhRmk'],
                    'FNAjhDocPrint'         => $paData['FNAjhDocPrint'],
                    'FTAjhApvCode'          => $paData['FTAjhApvCode'],
                    'FTAjhStaApv'           => $paData['FTAjhStaApv'],
                    'FTAjhStaPrcStk'        => $paData['FTAjhStaPrcStk'],
                    'FTAjhStaDoc'           => $paData['FTAjhStaDoc'],
                    'FNAjhStaDocAct'        => $paData['FNAjhStaDocAct'],
                    'FTAjhDocRef'           => $paData['FTAjhDocRef'],
                    'FTAjhStaDelMQ'         => $paData['FTAjhStaDelMQ'],
                    'FDLastUpdOn'           => $paData['FDLastUpdOn'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy'],
                    'FTLastUpdBy'           => $paData['FTLastUpdBy']
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

    //อัพเดทเลขที่เอกสารใน Temp ให้มี รหัส
    public function FSaMADJVDAddUpdateDocNoInDocTemp($aDataWhere){
        $tSQL = "UPDATE TCNTDocDTTmp SET FTXthDocNo = '".$aDataWhere['FTXthDocNo']."'
                WHERE FTBchCode = '".$aDataWhere['FTBchCode']."'
                AND FTXthDocNo = ''
                AND FTXthDocKey = '".$aDataWhere['FTXthDocKey']."'
                AND FTXtdShpTo = '".$aDataWhere['FTXtdShpTo']."'
                AND FTSessionID = '".$this->session->userdata('tSesSessionID')."'";
        $this->db->query($tSQL);
    }

    //Move จาก Temp To DT
    public function FSaMADJVDInsertTmpToDT($paDataWhere){
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
            $oResult    = $oQuery->result_array();
            $tSQL       = "DELETE FROM TCNTPdtAdjStkDT WHERE FTAjhDocNo = '".$paDataWhere["FTXthDocNo"]."'";
            $this->db->query($tSQL); 

            for($nI=0;$nI<FCNnHSizeOf($oResult);$nI++){
                if($oResult[$nI]["FCDateTimeInputForADJSTKVD"] != ""){
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
                            FNCabSeq,
                            FDAjdDateTimeC1,
                            FCAjdUnitQtyC1,
                            FCAjdQtyAllC1
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
                            '".date('Y-m-d H:i:s')."',
                            '".$this->session->userdata('tSesUsername')."',
                            '".date('Y-m-d H:i:s')."',
                            '".$this->session->userdata('tSesUsername')."',
                            '".$oResult[$nI]["FNCabSeqForTWXVD"]."',
                            '".$tDate."',
                            '".$oResult[$nI]["FCUserInPutForADJSTKVD"]."',
                            '".($oResult[$nI]["FCUserInPutForADJSTKVD"]*1)."'
                        )";
                $this->db->query($tSQL);
            }
        }    
    }

    //โหลดข้อมูล HD ของเอกสารเข้าแบบหน้าแก้ไข
    public function FSaMADJVDGetHD($paData){
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
                    Pos_L.FTPosName AS FTPosComNameF,
                    TWXVD.FTAjhWhTo AS FTXthWhFrm,
                    WAH_L.FTWahName AS FTXthWhNameFrm,
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
                    USRL.FTUsrName AS FTCreateBy,
                    USRAPV.FTUsrName AS FTUsrNameApv
                    FROM TCNTPdtAdjStkHD TWXVD
                    LEFT JOIN TCNMRsn_L        RSN_L ON TWXVD.FTRsnCode = RSN_L.FTRsnCode AND RSN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L     BCHL WITH (NOLOCK)   ON TWXVD.FTBchCode   = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMMerchant_L   MCHL WITH (NOLOCK)   ON TWXVD.FTAjhMerchantTo = MCHL.FTMerCode AND MCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMShop         FSHP WITH (NOLOCK)   ON TWXVD.FTAjhShopTo = FSHP.FTShpCode AND TWXVD.FTBchCode = FSHP.FTBchCode
                    LEFT JOIN TCNMShop_L       FSHPL WITH (NOLOCK)  ON TWXVD.FTAjhShopTo = FSHPL.FTShpCode AND TWXVD.FTBchCode = FSHPL.FTBchCode AND FSHPL.FNLngID = $nLngID
                    LEFT JOIN TCNMPos_L        Pos_L WITH (NOLOCK)  ON TWXVD.FTBchCode   = Pos_L.FTBchCode AND Pos_L.FTPosCode = TWXVD.FTAjhPosTo AND Pos_L.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L       USRL WITH (NOLOCK)   ON TWXVD.FTCreateBy   = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L       USRAPV WITH (NOLOCK) ON TWXVD.FTAjhApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                    LEFT JOIN TCNMUsrDepart_L  DPTL WITH (NOLOCK)   ON TWXVD.FTDptCode = DPTL.FTDptCode AND DPTL.FNLngID = $nLngID
                    LEFT JOIN TCNMWaHouse_L    WAH_L WITH(NOLOCK)   ON TWXVD.FTAjhWhTo = WAH_L.FTWahCode AND TWXVD.FTBchCode = WAH_L.FTBchCode AND WAH_L.FNLngID = $nLngID 
                    WHERE 1=1
                ";

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

    //เอาข้อมูลขาก DT
    public function FSaMADJVDGetDT($paWhere){
        $tXthDocNo = $paWhere['FTXthDocNo'];
        $tSQL   = "SELECT DISTINCT
                        DT.FTBchCode,
                        DT.FTAjhDocNo,
                        DT.FNAjdSeqNo,
                        DT.FTPdtCode,
                        DT.FTPdtName,
                        DT.FNAjdLayRow,
                        DT.FNAjdLayCol,
                        DT.FCAjdUnitQty,
                        DT.FDAjdDateTime,
                        DT.FNCabSeq,
                        PDTLYO.FCLayColQtyMax, 
                        DT.FCAjdQtyAllDiff,
                        DT.FCAjdWahB4Adj,
                        ISNULL( 
                        (SELECT FCStkQty FROM TVDTPdtStkBal WHERE FTWahCode = '".$paWhere["tWahCode"]."' 
                            AND FTBchCode = '".$paWhere["tBchCode"]."'
                            AND FNCabSeq = PDTLYO.FNCabSeq
                            AND FNLayRow = PDTLYO.FNLayRow
                            AND FNLayCol = PDTLYO.FNLayCol
                            AND FTPdtCode = PDTLYO.FTPdtCode),0
                        ) AS FCStkQty
                    FROM TCNTPdtAdjStkDT DT
                    LEFT JOIN TVDMPdtLayout PDTLYO ON PDTLYO.FTPdtCode = DT.FTPdtCode 
                        AND DT.FNCabSeq = PDTLYO.FNCabSeq 
                        AND DT.FTBchCode = PDTLYO.FTBchCode
                        AND DT.FNAjdLayRow = PDTLYO.FNLayRow
                        AND DT.FNAjdLayCol = PDTLYO.FNLayCol
                    WHERE DT.FTAjhDocNo = '$tXthDocNo' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'rtCode'    => '1',
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

    //ยกเลิกเอกสาร
    public function FSvMADJCancel($paDataUpdate){
        try{
            $this->db->set('FTAjhStaDoc' , 3);
            $this->db->where('FTAjhDocNo', $paDataUpdate['FTAjhDocNo']);
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
    
    //ลบข้อมูล
    public function FSnMADJVDDel($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTAjhDocNo', $paData['FTAjhDocNo']);
            $this->db->delete('TCNTPdtAdjStkHD');

            $this->db->where_in('FTAjhDocNo', $paData['FTAjhDocNo']);
            $this->db->delete('TCNTPdtAdjStkDT');

            $this->db->where_in('FTXthDocNo', $paData['FTAjhDocNo']);
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

    //อนุมัติเอกสาร
    public function FSvMADJVDApprove($paDataUpdate){
        try{
            $this->db->set('FTAjhStaPrcStk' , 2);
            $this->db->set('FTAjhStaApv' , 2);
            $this->db->set('FTAjhApvCode' , $paDataUpdate['FTXthApvCode']);
            $this->db->where('FTAjhDocNo', $paDataUpdate['FTAjhDocNo']);
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

    //อัพเดท FCAjdWahB4Adj ก่อนจะอนุมัติ
    public function FSxMADJVDUpdateBalToDT($pInfo,$aDataWhere){
        for($nI=0;$nI<FCNnHSizeOf($pInfo);$nI++){
            $tSQL = "UPDATE TCNTPdtAdjStkDT SET FCAjdWahB4Adj = '".$pInfo[$nI]["FCStkQty"]."'
                     WHERE FTBchCode = '".$aDataWhere["tBchCode"]."'
                     AND FTAjhDocNo = '".$aDataWhere["FTXthDocNo"]."'
                     AND FNCabSeq = '".$pInfo[$nI]["FNCabSeq"]."'
                     AND FNAjdLayRow = '".$pInfo[$nI]["FNLayRow"]."'
                     AND FNAjdLayCol = '".$pInfo[$nI]["FNLayCol"]."'";
            $this->db->query($tSQL);
        }
    }

    //เช็คว่ารหัสซ้ำไหมในระบบ
    public function FSaMADJVDCheckDocumentNumber($ptDocumentNumber){
        $tSQL   = "SELECT FTBchCode FROM TCNTPdtAdjStkHD WHERE FTAjhDocNo = '$ptDocumentNumber' AND FNAjhDocType = '11' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = array(
                'rtCode'    => '1',
                'raItems'   => 'Found',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'Not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //ลบข้อมูลใน Temp
    public function FSnMADJVDDeleteInlineDTTemp($aDataWhere){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTXthDocNo', $aDataWhere['FTXthDocNo']);
            $this->db->where_in('FNXtdSeqNo', $aDataWhere['FNXtdSeqNo']);
            $this->db->where_in('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->where_in('FTPdtCode', $aDataWhere['FTPdtCode']);
            $this->db->where_in('FTBchCode', $aDataWhere['FTBchCode']);
            $this->db->where_in('FTXtdShpTo', $aDataWhere['FTShpCode']);
            $this->db->where_in('FNCabSeqForTWXVD', $aDataWhere['FNCabSeqForTWXVD']);
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


    //ลบข้อมูลใน Temp แบบ Multi
    public function FSnMADJVDDeleteMultiDTTemp($aDataWhere){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTXthDocNo', $aDataWhere['FTXthDocNo']);
            $this->db->where_in('FNXtdSeqNo', $aDataWhere['FNXtdSeqNo']);
            $this->db->where_in('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->where_in('FTPdtCode', $aDataWhere['FTPdtCode']);
            $this->db->where_in('FTBchCode', $aDataWhere['FTBchCode']);
            $this->db->where_in('FTXtdShpTo', $aDataWhere['FTShpCode']);
            $this->db->where_in('FNCabSeqForTWXVD', $aDataWhere['FNCabSeqForTWXVD']);
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

    //ลบข้อมูลใน Temp ทั้งหมด
    public function FSnMADJVDDeleteItemAllInTemp($aDataWhere){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTXthDocNo', $aDataWhere['FTXthDocNo']);
            $this->db->where_in('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->where_in('FTSessionID' , $this->session->userdata('tSesSessionID'));
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

    //ลบข้อมูลใน Temp By Session
    public function FSnMADJVDDeleteItemAllInTempBySession(){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTXthDocKey', 'TCNTPdtAdjStkHD');
            $this->db->where_in('FTSessionID' , $this->session->userdata('tSesSessionID'));
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
}

