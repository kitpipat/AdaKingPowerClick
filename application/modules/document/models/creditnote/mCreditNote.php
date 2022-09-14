<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCreditNote extends CI_Model {

    /**
     * Functionality : Data List Product Adjust Stock HD
     * Parameters : function parameters
     * Creator :  22/05/2019 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSaMCreditNoteList($paData = []){
        $aDataUserInfo  = $this->session->userdata("tSesUsrInfo");
        $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID         = $paData['FNLngID'];
        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTXphDocNo DESC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        CDN.FTBchCode,
                        BCHL.FTBchName,
                        CDN.FTXphDocNo,
                        CONVERT(CHAR(10), CDN.FDXphDocDate, 103) AS FDXphDocDate,
                        CONVERT(CHAR(5), CDN.FDXphDocDate, 108)  AS FTXphDocTime,
                        CDN.FTXphStaDoc,
                        CDN.FTXphStaApv,
                        CDN.FTXphStaPrcStk,
                        CDN.FTCreateBy,
                        CDN.FDCreateOn,
                        USRL.FTUsrName AS FTCreateByName,
                        CDN.FTXphApvCode,
                        USRLAPV.FTUsrName AS FTXphApvName
                    FROM TAPTPcHD CDN WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON CDN.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                    LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON CDN.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                    LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON CDN.FTXphApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                    WHERE 1=1
        ";

        if($this->session->userdata('tSesUsrLevel') != "HQ"){ // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND CDN.FTBchCode IN (".$tBchMulti.") ";
        }
        
        $aAdvanceSearch = $paData['aAdvanceSearch'];
        
        @$tSearchList = $aAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND ((CDN.FTXphDocNo  COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName  COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName  COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName  COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        if($this->session->userdata("tSesUsrLevel") != "HQ"){
            $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND CDN.FTBchCode IN (".$tBchMulti.") ";
            if($this->session->userdata("tSesUsrLevel")=="SHP"){
                $tSQL .= " AND CDN.FTShpCode = '".$aDataUserInfo['FTShpCode']."'";
            }
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)){
            $tSQL .= " AND ((CDN.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (CDN.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];

        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((CDN.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (CDN.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND CDN.FTXphStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(CDN.FTXphStaApv,'') = '' AND CDN.FTXphStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND CDN.FTXphStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (CDN.FTXphStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(CDN.FTXphStaPrcStk,'') = '') ";
            } else {
                $tSQL .= " AND CDN.FTXphStaPrcStk = '$tSearchStaPrcStk'";
            }
        }
        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND CDN.FNXphStaDocAct = 1";
            } else {
                $tSQL .= " AND CDN.FNXphStaDocAct = 0";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
       
        // echo $tSQL;
        // exit();
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCreditNoteGetPageAll($paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            // No Data
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
    
    /**
     * Functionality : All Page Of Product Adjust Stock HD
     * Parameters : function parameters
     * Creator :  12/06/2018 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSnMCreditNoteGetPageAll($paData = []){
        $aDataUserInfo  = $this->session->userdata("tSesUsrInfo");
        $nLngID         = $paData['FNLngID'];
        $tSQL           = " SELECT 
                                COUNT (CDN.FTXphDocNo) AS counts
                            FROM TAPTPcHD CDN WITH (NOLOCK)
                            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON CDN.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON CDN.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON CDN.FTXphApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                            WHERE 1=1
        ";
        
        if($this->session->userdata("tSesUsrLevel") != "HQ"){
            $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND  CDN.FTBchCode IN (".$tBchMulti.")  ";
            if($this->session->userdata("tSesUsrLevel")=="SHP"){
                $tSQL .= " AND CDN.FTShpCode = '".$aDataUserInfo['FTShpCode']."'";
            }
        }

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList = $aAdvanceSearch['tSearchAll'];
        
        if(@$tSearchList != ''){
            $tSQL .= " AND ((CDN.FTXphDocNo  COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName  COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName  COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName  COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)){
            $tSQL .= " AND ((CDN.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (CDN.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];

        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((CDN.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (CDN.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND CDN.FTXphStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(CDN.FTXphStaApv,'') = '' AND CDN.FTXphStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND CDN.FTXphStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (CDN.FTXphStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(CDN.FTXphStaPrcStk,'') = '') ";
            } else {
                $tSQL .= " AND CDN.FTXphStaPrcStk = '$tSearchStaPrcStk'";
            }
        }
        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND CDN.FNXphStaDocAct = 1";
            } else {
                $tSQL .= " AND CDN.FNXphStaDocAct = 0";
            }
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            // No Data
            return false;
        }
    }
    
    /**
     * Functionality : Function Get Count From Temp
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteGetCountDTTemp($paDataWhere = []){
        
            $tSQL = "
                SELECT 
                    COUNT(DOCTMP.FTXthDocNo) AS counts
                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                WHERE 1 = 1
            ";

            $tDocNo = $paDataWhere['tDocNo'];
            $tDocKey = $paDataWhere['tDocKey'];
            $tSesSessionID = $this->session->userdata('tSesSessionID');    

            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tDocNo'";

            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result_array();
                $aResult = $oDetail[0]['counts'];
            }else{
                $aResult = 0;
            }

        return $aResult;

    }
    
    /**
     * Functionality : Function Get Max Seq From Temp
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteGetMaxSeqDTTemp($paDataWhere){
        
            $tSQL = "
                SELECT 
                    MAX(DOCTMP.FNXtdSeqNo) AS maxSeqNo
                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                WHERE 1 = 1
            ";

            $tDocNo = $paDataWhere['tDocNo'];
            $tDocKey = $paDataWhere['tDocKey'];
            $tSesSessionID = $this->session->userdata('tSesSessionID');    

            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tDocNo'";

            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result_array();
                $aResult = $oDetail[0]['maxSeqNo'];
            }else{
                $aResult = 0;
            }

        return empty($aResult) ? 0 : $aResult;

    }

    /**
     * Functionality : Function Add DT Temp To DT
     * Parameters : function parameters
     * Creator : 29/05/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMCreditNoteInsertTmpToDT($paDataWhere){
        $tDocNo = $paDataWhere['tDocNo'];
        $tDocKey = $paDataWhere['tDocKey'];
        $tSessionID = $paDataWhere['tSessionID']; 
        
        // ทำการลบ ใน DT ก่อนการย้าย DT Temp ไป DT
        $this->db->where('FTXphDocNo', $tDocNo);
        $this->db->delete('TAPTPcDT');
        
        $tWhereDocNo = '';
        if($paDataWhere['tIsUpdatePage'] == '1'){
            $tWhereDocNo = $tDocNo;
        }
        
        $tSQL = "   
            INSERT TAPTPcDT 
                (FTBchCode, FTXphDocNo, FNXpdSeqNo, FTPdtCode, FTXpdPdtName, FTPunCode, FTPunName, FCXpdFactor,
                FTXpdBarCode, FTSrnCode, FTXpdVatType, FTVatCode, FCXpdVatRate, FTXpdSaleType, FCXpdSalePrice,
                FCXpdQty, FCXpdQtyAll, FCXpdSetPrice, FCXpdAmtB4DisChg, FTXpdDisChgTxt, FCXpdDis, FCXpdChg,
                FCXpdNet, FCXpdNetAfHD, FCXpdVat, FCXpdVatable, FCXpdWhtAmt, FTXpdWhtCode, FCXpdWhtRate, FCXpdCostIn,
                FCXpdCostEx, FCXpdQtyLef, FCXpdQtyRfn, FTXpdStaPrcStk, FTXpdStaAlwDis, FNXpdPdtLevel, FTXpdPdtParent,
                FCXpdQtySet, FTPdtStaSet, FTXpdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
        ";

        $tSQL .= "  
            SELECT 
                DOCTMP.FTBchCode,
                '$tDocNo' AS FTXphDocNo,
                DOCTMP.FNXtdSeqNo AS FNXpdSeqNo,
                DOCTMP.FTPdtCode,
                DOCTMP.FTXtdPdtName,
                DOCTMP.FTPunCode,
                DOCTMP.FTPunName,
                DOCTMP.FCXtdFactor,
                DOCTMP.FTXtdBarCode,
                DOCTMP.FTSrnCode,
                DOCTMP.FTXtdVatType,
                DOCTMP.FTVatCode,
                DOCTMP.FCXtdVatRate,
                DOCTMP.FTXtdSaleType,
                DOCTMP.FCXtdSalePrice,
                DOCTMP.FCXtdQty,
                DOCTMP.FCXtdQtyAll,
                DOCTMP.FCXtdSetPrice,
                DOCTMP.FCXtdAmtB4DisChg,
                DOCTMP.FTXtdDisChgTxt,
                DOCTMP.FCXtdDis,
                DOCTMP.FCXtdChg,
                DOCTMP.FCXtdNet,
                DOCTMP.FCXtdNetAfHD,
                DOCTMP.FCXtdVat,
                DOCTMP.FCXtdVatable,
                DOCTMP.FCXtdWhtAmt,
                DOCTMP.FTXtdWhtCode,
                DOCTMP.FCXtdWhtRate,
                DOCTMP.FCXtdCostIn,
                DOCTMP.FCXtdCostEx,
                DOCTMP.FCXtdQtyLef,
                DOCTMP.FCXtdQtyRfn,
                DOCTMP.FTXtdStaPrcStk,
                DOCTMP.FTXtdStaAlwDis,
                DOCTMP.FNXtdPdtLevel,
                DOCTMP.FTXtdPdtParent,
                DOCTMP.FCXtdQtySet,
                DOCTMP.FTXtdPdtStaSet,
                DOCTMP.FTXtdRmk,
                DOCTMP.FDLastUpdOn,
                DOCTMP.FTLastUpdBy,
                DOCTMP.FDCreateOn,
                DOCTMP.FTCreateBy

            FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
            WHERE DOCTMP.FTSessionID = '$tSessionID'
            AND DOCTMP.FTXthDocKey = '$tDocKey'
            AND DOCTMP.FTXthDocNo = '$tWhereDocNo'
            ORDER BY DOCTMP.FNXtdSeqNo ASC
        ";
        
        //echo $tSQL;
        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
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
        return $aStatus;
    }
 
    /**
     * Functionality : Function Add DT To DT Temp
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMCreditNoteInsertDTToTemp($paDataWhere = []){
        $tDocNo = $paDataWhere['tDocNo'];
        $tDocKey = $paDataWhere['tDocKey'];
        $tSessionID = $paDataWhere['tSessionID']; 
        
        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        // $this->db->where('FTXthDocKey', $tDocKey);
        $this->db->where('FTSessionID', $tSessionID);
        // $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL = "   
            INSERT TCNTDocDTTmp 
                (FTBchCode, FTXthDocNo, FNXtdSeqNo, FTPdtCode, FTXtdPdtName, FTPunCode, FTPunName, FCXtdFactor,
                FTXtdBarCode, FTSrnCode, FTXtdVatType, FTVatCode, FCXtdVatRate, FTXtdSaleType, FCXtdSalePrice,
                FCXtdQty, FCXtdQtyAll, FCXtdSetPrice, FCXtdAmtB4DisChg, FTXtdDisChgTxt, FCXtdDis, FCXtdChg,
                FCXtdNet, FCXtdNetAfHD, FCXtdVat, FCXtdVatable, FCXtdWhtAmt, FTXtdWhtCode, FCXtdWhtRate, FCXtdCostIn,
                FCXtdCostEx, FCXtdQtyLef, FCXtdQtyRfn, FTXtdStaPrcStk, FTXtdStaAlwDis, FNXtdPdtLevel, FTXtdPdtParent,
                FCXtdQtySet, FTXtdPdtStaSet, FTXtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTXthDocKey, FTSessionID)
        ";

        $tSQL .= "  
            SELECT 
                DT.FTBchCode,
                DT.FTXphDocNo AS FTXthDocNo,
                DT.FNXpdSeqNo AS FNXtdSeqNo,
                DT.FTPdtCode,
                DT.FTXpdPdtName,
                DT.FTPunCode,
                DT.FTPunName,
                DT.FCXpdFactor,
                DT.FTXpdBarCode,
                DT.FTSrnCode,
                DT.FTXpdVatType,
                DT.FTVatCode,
                DT.FCXpdVatRate,
                DT.FTXpdSaleType,
                DT.FCXpdSalePrice,
                DT.FCXpdQty,
                DT.FCXpdQtyAll,
                DT.FCXpdSetPrice,
                DT.FCXpdAmtB4DisChg,
                DT.FTXpdDisChgTxt,
                DT.FCXpdDis,
                DT.FCXpdChg,
                DT.FCXpdNet,
                DT.FCXpdNetAfHD,
                DT.FCXpdVat,
                DT.FCXpdVatable,
                DT.FCXpdWhtAmt,
                DT.FTXpdWhtCode,
                DT.FCXpdWhtRate,
                DT.FCXpdCostIn,
                DT.FCXpdCostEx,
                DT.FCXpdQtyLef,
                DT.FCXpdQtyRfn,
                DT.FTXpdStaPrcStk,
                DT.FTXpdStaAlwDis,
                DT.FNXpdPdtLevel,
                DT.FTXpdPdtParent,
                DT.FCXpdQtySet,
                DT.FTPdtStaSet AS FTXpdPdtStaSet,
                DT.FTXpdRmk,
                DT.FDLastUpdOn,
                DT.FTLastUpdBy,
                DT.FDCreateOn,
                DT.FTCreateBy,
                '$tDocKey' AS FTXthDocKey,
                '$tSessionID' AS FTSessionID

            FROM TAPTPcDT DT WITH (NOLOCK)
            WHERE DT.FTXphDocNo = '$tDocNo'
            ORDER BY DT.FNXpdSeqNo ASC
        ";
       
        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
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
        return $aStatus;
    }

    /**
     * Functionality : Function Add DTDis Temp To DTDis
     * Parameters : function parameters
     * Creator : 29/05/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMCreditNoteInsertTmpToDTDis($paDataWhere = []){
        $tDocNo = $paDataWhere['tDocNo'];
        $tSessionID = $paDataWhere['tSessionID']; 
        
        // ทำการลบ ใน DTDis ก่อนการย้าย DTDis Temp ไป DTDis
        $this->db->where('FTXphDocNo', $tDocNo);
        $this->db->delete('TAPTPcDTDis');
        
        $tWhereDocNo = '';
        if($paDataWhere['tIsUpdatePage'] == '1'){
            $tWhereDocNo = $tDocNo;
        }
        
        $tSQL = "   
            INSERT TAPTPcDTDis 
                (FTBchCode, FTXphDocNo, FNXpdSeqNo, FDXpdDateIns, FNXpdStaDis, FTXpdDisChgTxt, FTXpdDisChgType, FCXpdNet, FCXpdValue)
        ";

        $tSQL .= "  
            SELECT 
                DTDISTMP.FTBchCode,
                '$tDocNo' AS FTXphDocNo,
                DTDISTMP.FNXtdSeqNo AS FNXpdSeqNo,
                DTDISTMP.FDXtdDateIns,
                DTDISTMP.FNXtdStaDis,
                DTDISTMP.FTXtdDisChgTxt,
                DTDISTMP.FTXtdDisChgType,
                DTDISTMP.FCXtdNet,
                DTDISTMP.FCXtdValue

            FROM TCNTDocDTDisTmp DTDISTMP WITH (NOLOCK)
            WHERE DTDISTMP.FTSessionID = '$tSessionID'
            AND DTDISTMP.FTXthDocNo = '$tWhereDocNo'
            ORDER BY DTDISTMP.FNXtdSeqNo ASC
        ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add TAPTPcDTDis Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add TAPTPcDTDis',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Add DTDis To DTDis Temp
     * Parameters : function parameters
     * Creator : 29/05/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMCreditNoteInsertDTDisToTmp($paDataWhere = []){
        $tDocNo = $paDataWhere['tDocNo'];
        $tSessionID = $paDataWhere['tSessionID']; 
        
        // ทำการลบ ใน DTDis Temp ก่อนการย้าย DTDis ไป DTDis Temp
        $this->db->where('FTSessionID', $tSessionID);
        // $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTDocDTDisTmp');
        
        $tSQL = "   
            INSERT TCNTDocDTDisTmp
                (FTBchCode, FTXthDocNo, FNXtdSeqNo, FDXtdDateIns, FNXtdStaDis, FTXtdDisChgTxt, FTXtdDisChgType, FCXtdNet, FCXtdValue, FTSessionID)
        ";

        $tSQL .= "  
            SELECT 
                DTDIS.FTBchCode,
                DTDIS.FTXphDocNo AS FTXthDocNo,
                DTDIS.FNXpdSeqNo AS FNXpdSeqNo,
                DTDIS.FDXpdDateIns,
                DTDIS.FNXpdStaDis,
                DTDIS.FTXpdDisChgTxt,
                DTDIS.FTXpdDisChgType,
                DTDIS.FCXpdNet,
                DTDIS.FCXpdValue,
                '$tSessionID' AS FTSessionID

            FROM TAPTPcDTDis DTDIS WITH (NOLOCK)
            WHERE DTDIS.FTXphDocNo = '$tDocNo'
            ORDER BY DTDIS.FNXpdSeqNo ASC
        ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add TCNTDocDTDisTmp Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add TCNTDocDTDisTmp',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Add HDDis To HDDis Temp
     * Parameters : function parameters
     * Creator : 29/05/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMCreditNoteInsertHDDisToTmp($paDataWhere = []){
        $tDocNo = $paDataWhere['tDocNo'];
        $tSessionID = $paDataWhere['tSessionID']; 
        
        // ทำการลบ ใน HDDis Temp ก่อนการย้าย HDDis ไป HDDis Temp
        $this->db->where('FTSessionID', $tSessionID);
        // $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTDocHDDisTmp');

        $tSQL = "   
            INSERT TCNTDocHDDisTmp
                (FTBchCode, FTXthDocNo, FDXtdDateIns, FTXtdDisChgTxt, FTXtdDisChgType, FCXtdTotalAfDisChg, FCXtdTotalB4DisChg, 
                FCXtdDisChg, FCXtdAmt, FDLastUpdOn, FDCreateOn, FTLastUpdBy, FTCreateBy, FTSessionID)
        ";

        $tSQL .= "  
            SELECT 
                HDDIS.FTBchCode, 
                HDDIS.FTXphDocNo AS FTXthDocNo,
                HDDIS.FDXphDateIns AS FDXtdDateIns,
                HDDIS.FTXphDisChgTxt AS FTXtdDisChgTxt,
                HDDIS.FTXphDisChgType AS FTXtdDisChgType,
                HDDIS.FCXphTotalAfDisChg AS FCXtdTotalAfDisChg,
                0 AS FCXtdTotalB4DisChg,
                HDDIS.FCXphDisChg AS FCXtdDisChg,
                HDDIS.FCXphAmt AS FCXtdAmt,
                '' AS FDLastUpdOn,
                '' AS FDCreateOn,
                '' AS FTLastUpdBy,
                '' AS FTCreateBy,
                '$tSessionID' AS FTSessionID

            FROM TAPTPcHDDis HDDIS WITH (NOLOCK)
            WHERE HDDIS.FTXphDocNo = '$tDocNo'
            ORDER BY HDDIS.FDXphDateIns ASC
        ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add TCNTDocHDDisTmp Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add TCNTDocHDDisTmp',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Add HDDis Temp To HDDis
     * Parameters : function parameters
     * Creator : 29/05/2019 Piya
     * Last Modified : -
     * Return : Status Add
     * Return Type : array
     */
    public function FSaMCreditNoteInsertTmpToHDDis($paDataWhere = []){
        $tDocNo = $paDataWhere['tDocNo'];
        $tSessionID = $paDataWhere['tSessionID']; 
        
        // ทำการลบ ใน DTDis ก่อนการย้าย DTDis Temp ไป DTDis
        $this->db->where('FTXphDocNo', $tDocNo);
        $this->db->delete('TAPTPcHDDis');
        
        $tWhereDocNo = '';
        if($paDataWhere['tIsUpdatePage'] == '1'){
            $tWhereDocNo = $tDocNo;
        }
        
        $tSQL = "   
            INSERT TAPTPcHDDis
                (FTBchCode, FTXphDocNo, FDXphDateIns, FTXphDisChgTxt, FTXphDisChgType, FCXphTotalAfDisChg, 
                FCXphDisChg, FCXphAmt)
        ";

        $tSQL .= "  
            SELECT 
                HDDISTMP.FTBchCode,
                '$tDocNo' AS FTXphDocNo,
                HDDISTMP.FDXtdDateIns AS FDXphDateIns,
                HDDISTMP.FTXtdDisChgTxt AS FTXphDisChgTxt,
                HDDISTMP.FTXtdDisChgType AS FTXphDisChgType,
                HDDISTMP.FCXtdTotalAfDisChg AS FCXphTotalAfDisChg,
                HDDISTMP.FCXtdDisChg AS FCXphDisChg,
                HDDISTMP.FCXtdAmt AS FCXphAmt

            FROM TCNTDocHDDisTmp HDDISTMP WITH (NOLOCK)
            WHERE HDDISTMP.FTXthDocNo = '$tWhereDocNo'
            ORDER BY HDDISTMP.FDXtdDateIns ASC
        ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add TCNTDocHDDisTmp Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add TCNTDocHDDisTmp',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Get Pdt From Temp
     * Parameters : function parameters
     * Creator : 22/05/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteGetDTTempListPage($paData = []){

        try{
            $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $tSQL = "
                SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM
                        (SELECT DOCTMP.FTBchCode,
                                DOCTMP.FTXthDocNo,
                                /*ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,*/
                                DOCTMP.FNXtdSeqNo,
                                DOCTMP.FTXthDocKey,
                                DOCTMP.FTPdtCode,
                                DOCTMP.FTXtdPdtName,
                                DOCTMP.FTPunName,
                                DOCTMP.FTXtdBarCode,
                                DOCTMP.FTPunCode,
                                DOCTMP.FCXtdFactor,
                                DOCTMP.FCXtdQty,
                                DOCTMP.FCXtdSetPrice,
                                DOCTMP.FTXtdDisChgTxt,
                                DOCTMP.FCXtdNet,
                                DOCTMP.FTXtdStaAlwDis,
                                DOCTMP.FDLastUpdOn,
                                DOCTMP.FDCreateOn,
                                DOCTMP.FTLastUpdBy,
                                DOCTMP.FTCreateBy

                            FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                            WHERE 1 = 1
            ";

            $tDocNo = $paData['tDocNo'];
            $tDocKey = $paData['tDocKey'];
            $tSesSessionID = $this->session->userdata('tSesSessionID');    
           
            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tDocNo'";
            
            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
            
            $tSearchList = $paData['tSearchAll'];
            
            if ($tSearchList != '') {
                $tSQL .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchList%'";
                $tSQL .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchList%' ";
                $tSQL .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchList%' )";
            }
            
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aList          = $oQuery->result_array();
                $oFoundRow      = $this->FSoMCreditNoteGetDTTempListPageAll($paData);
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
    
    /**
     * Functionality : All Page Of Product Size
     * Parameters : function parameters
     * Creator :  25/06/2019 Piya
     * Return : Object Count All Product Model
     * Return Type : Object
     */
    public function FSoMCreditNoteGetDTTempListPageAll($paData = []){
        try{

            $tSQL = "
                SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP
                    WHERE 1 = 1
            ";

            $tDocNo = $paData['tDocNo'];
            $tDocKey = $paData['tDocKey'];
            $tSesSessionID = $this->session->userdata('tSesSessionID');    

            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tDocNo'";
            
            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
            
            $tSearchList = $paData['tSearchAll'];
            
            if ($tSearchList != '') {
                $tSQL .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchList%'";
                $tSQL .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchList%' ";
                $tSQL .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchList%' )";
            }
            
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

    /**
     * Functionality : Function Get Data Pdt
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteGetPunCodeByBarCode($paParams = []){
        
        $tBarCode = $paParams['tBarCode'];
        $tSplCode = $paParams['tSplCode'];
        // config tCN_Cost	1 ต้นทุนเฉลี่ย ,2 ต้นทุนสุดท้าย ,3 ต้นทุนมาตรฐาน ,4 ต้นทุน FIFO	
        // TCNMPdtCostAvg
        $aConfigParams = [
            "tSysCode" => "tCN_Cost",
            "tSysApp" => "ALL",
            "tSysKey" => "Company",
            "tSysSeq" => "1",
            "tGmnCode" => "COMP"
        ];
        $aSysConfig = FCNaGetSysConfig($aConfigParams);

        $tCN_Cost_Config = "1,2,3,4"; // Defualt Config

        if(!empty($aSysConfig['raItems'])) {
            $tUsrConfigValue = $aSysConfig['raItems']['FTSysStaUsrValue']; // Set by User
            $tDefConfigValue = $aSysConfig['raItems']['FTSysStaDefValue']; // Set by System
            $tCN_Cost_Config = !empty($tUsrConfigValue) ? $tUsrConfigValue : $tDefConfigValue; // Config by User or Default    
        }

        $aCN_Cost_Config = explode(',', $tCN_Cost_Config);
        
        $tCost = ''; $tComma = '';
        
        /*===== เรียงลำดับ การหาต้นทุน ============================================*/
        if(isset($aCN_Cost_Config) && FCNnHSizeOf($aCN_Cost_Config) > 0) {
            
            $tComma = ',';
            $tCost = " (CASE";

            foreach($aCN_Cost_Config as $key => $costConfig) {
                switch($costConfig) {
                    case '1' : {
                        $tCost .= ' WHEN COSTAVG.FCPdtCostAmt IS NOT NULL THEN COSTAVG.FCPdtCostAmt';
                        break;
                    }
                    case '2' : {
                        $tCost .= ' WHEN PDTSPL.FCSplLastPrice IS NOT NULL THEN PDTSPL.FCSplLastPrice';
                        break;
                    }
                    case '3' : {
                        $tCost .= ' WHEN PDT.FCPdtCostStd IS NOT NULL THEN PDT.FCPdtCostStd';
                        break;
                    }
                    case '4' : {
                        $tCost .= ' WHEN COSTFIFO.FCPdtCostAmt IS NOT NULL THEN COSTFIFO.FCPdtCostAmt';
                        break;
                    }
                }
            }
            $tCost .= " ELSE 0 END) AS cCost ";
        }
        
        $tSQL = "
                    SELECT
                        BAR.FTBarCode,
                        BAR.FTPdtCode,
                        BAR.FTPunCode,
                        PACKSIZE.FCPdtUnitFact$tComma
                        $tCost
                    FROM TCNMPdtBar BAR WITH (NOLOCK)
                    LEFT JOIN TCNMSpl SPL WITH (NOLOCK) ON SPL.FTSplCode = '$tSplCode'
                    LEFT JOIN TCNMPdtPackSize PACKSIZE WITH (NOLOCK) ON PACKSIZE.FTPdtCode = BAR.FTPdtCode AND PACKSIZE.FTPunCode = BAR.FTPunCode
                    LEFT JOIN TCNMPdtCostAvg COSTAVG WITH (NOLOCK) ON COSTAVG.FTPdtCode = BAR.FTPdtCode
                    LEFT JOIN TCNMPdtSpl PDTSPL WITH (NOLOCK) ON PDTSPL.FTPdtCode = BAR.FTPdtCode AND PDTSPL.FTBarCode = BAR.FTBarCode
                    LEFT JOIN TCNMPdt PDT WITH (NOLOCK) ON PDT.FTPdtCode = BAR.FTPdtCode
                    LEFT JOIN TCNMPdtCostFIFO COSTFIFO WITH (NOLOCK) ON COSTFIFO.FTPdtCode = BAR.FTPdtCode
                    WHERE BAR.FTBarCode = '$tBarCode'
                    AND PDTSPL.FTSplCode = '$tSplCode'
        ";
        
        // echo $tSQL;
        
        $oQuery = $this->db->query($tSQL);
            
        if ($oQuery->num_rows() > 0){
            $aData = $oQuery->row_array();
            $aResult = array(
                'raItem'   => $aData,
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
    
    /**
     * Functionality : Function Get Data Pdt
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteGetDataPdt($paData = []){

        $tPdtCode = $paData['tPdtCode'];
        $FTPunCode = $paData['tPunCode'];
        $FTBarCode = $paData['tBarCode'];
        $FTSplCode = $paData['tSplCode'];
        $nLngID = $paData['nLngID'];

        $tSQL = "
            SELECT
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
                ISNULL(PRI4PDT.FCPgdPriceRet,0) AS FTPdtSalePrice,
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
                BAR.FTPlcCode,
                PDTLOCL.FTPlcName,
                PDTSRL.FTSrnCode,
                PDT.FCPdtCostStd,
                CAVG.FCPdtCostEx,
                CAVG.FCPdtCostIn,
                SPL.FCSplLastPrice
            FROM TCNMPdt PDT WITH (NOLOCK)
            LEFT JOIN TCNMPdt_L PDTL        WITH (NOLOCK)   ON PDT.FTPdtCode      = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLngID
            LEFT JOIN TCNMPdtPackSize  PKS  WITH (NOLOCK)   ON PDT.FTPdtCode      = PKS.FTPdtCode     AND PKS.FTPunCode   = '$FTPunCode'
            LEFT JOIN TCNMPdtUnit_L UNTL    WITH (NOLOCK)   ON UNTL.FTPunCode     = '$FTPunCode'      AND UNTL.FNLngID    = $nLngID
            LEFT JOIN TCNMPdtBar BAR        WITH (NOLOCK)   ON PKS.FTPdtCode      = BAR.FTPdtCode     AND BAR.FTPunCode   = '$FTPunCode'
            LEFT JOIN TCNMPdtLoc_L PDTLOCL  WITH (NOLOCK)   ON PDTLOCL.FTPlcCode  = BAR.FTPlcCode     AND PDTLOCL.FNLngID = $nLngID
            LEFT JOIN (
                SELECT DISTINCT
                    FTVatCode,
                    FCVatRate,
                    FDVatStart
                FROM TCNMVatRate WITH (NOLOCK)
                WHERE CONVERT(VARCHAR(19),GETDATE(),121) > FDVatStart ) VAT
            ON PDT.FTVatCode = VAT.FTVatCode
            LEFT JOIN TCNTPdtSerial PDTSRL  WITH (NOLOCK)   ON PDT.FTPdtCode    = PDTSRL.FTPdtCode
            LEFT JOIN TCNMPdtSpl SPL        WITH (NOLOCK)   ON PDT.FTPdtCode    = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode
            LEFT JOIN TCNMPdtCostAvg CAVG   WITH (NOLOCK)   ON PDT.FTPdtCode    = CAVG.FTPdtCode
            LEFT JOIN (
                SELECT DISTINCT
                    P4PDT.FTPdtCode,
                    P4PDT.FTPunCode,
                    P4PDT.FDPghDStart,
                    P4PDT.FTPghTStart,
                    P4PDT.FCPgdPriceRet,
                    P4PDT.FCPgdPriceWhs,
                    P4PDT.FCPgdPriceNet
                FROM TCNTPdtPrice4PDT P4PDT WITH (NOLOCK)
                WHERE 1=1
                AND (CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121))
                AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121))
            ) AS PRI4PDT
            ON PDT.FTPdtCode = PRI4PDT.FTPdtCode AND PRI4PDT.FTPunCode = PKS.FTPunCode
            WHERE 1 = 1
        ";
        
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

    /**
     * Functionality : Update DT Temp by Seq
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    function FSaMCreditNoteUpdateInlineDTTemp($aDataUpd = [], $aDataWhere = []){
        try{
            $this->db->set($aDataUpd['tFieldName'], $aDataUpd['tValue']);
            $this->db->where('FTSessionID', $this->session->userdata('tSesSessionID'));
            $this->db->where('FTXthDocNo', $aDataWhere['tDocNo']);
            $this->db->where('FNXtdSeqNo', $aDataWhere['nSeqNo']);
            $this->db->where('FTXthDocKey', $aDataWhere['tDocKey']);
            $this->db->update('TCNTDocDTTmp');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Update Fail',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Function insert DT to Temp
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : Status insert
     * Return Type : array
     */
    public function FSaMCreditNoteInsertPDTToTemp($paData = [], $paDataWhere = []){
        
        $paData = $paData['raItem'];
        if($paDataWhere['nCreditNoteOptionAddPdt'] == 1){
            // นำสินค้าเพิ่มจำนวนในแถวแรก
            $tSQL = "   
                SELECT 
                    FNXtdSeqNo, 
                    FCXtdQty 
                FROM TCNTDocDTTmp 
                WHERE FTBchCode = '".$paDataWhere['tBchCode']."' 
                AND FTXthDocNo = '".$paDataWhere['tDocNo']."'
                AND FTXthDocKey = '".$paDataWhere['tDocKey']."'
                AND FTSessionID = '".$paDataWhere['tSessionID']."'
                AND FTPdtCode = '".$paData["FTPdtCode"]."' 
                AND FTXtdBarCode = '".$paData["FTBarCode"]."'
                ORDER BY FNXtdSeqNo
            ";
            
            $oQuery = $this->db->query($tSQL);
            
            if($oQuery->num_rows() > 0){ // เพิ่มจำนวนให้รายการที่มีอยู่แล้ว
                $aResult = $oQuery->row_array();
                $tSQL = "
                    UPDATE TCNTDocDTTmp SET
                        FCXtdQty = '".($aResult["FCXtdQty"] + 1 )."'
                    WHERE FTBchCode = '".$paDataWhere['tBchCode']."' 
                    AND FTXthDocNo  = '".$paDataWhere['tDocNo']."' 
                    AND FNXtdSeqNo = '".$aResult["FNXtdSeqNo"]."' 
                    AND FTXthDocKey = '".$paDataWhere['tDocKey']."' 
                    AND FTSessionID = '".$paDataWhere['tSessionID']."' 
                    AND FTPdtCode = '".$paData["FTPdtCode"]."' 
                    AND FTXtdBarCode = '".$paData["FTBarCode"]."'";
                
                $this->db->query($tSQL);
                
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            }else{

                $nQty = ($paDataWhere['nQty'] == '') ? 1 : $paDataWhere['nQty'];

                // เพิ่มรายการใหม่
                $this->db->set('FTPdtCode'      , $paData['FTPdtCode']);
                $this->db->set('FTXtdPdtName'   , $paData['FTPdtName']);
                $this->db->set('FCXtdFactor'    , $paData['FCPdtUnitFact']);
                $this->db->set('FCPdtUnitFact'  , $paData['FCPdtUnitFact']);
                $this->db->set('FTPunCode'      , $paData['FTPunCode']);
                $this->db->set('FTPunName'      , $paData['FTPunName']);
                $this->db->set('FTXtdVatType'   , $paData['FTPdtStaVatBuy']);
                $this->db->set('FTVatCode'      , ($paDataWhere['tVatcode'] == '') ? $paData['FTVatCode'] : $paDataWhere['tVatcode']);
                $this->db->set('FCXtdVatRate'   , ($paDataWhere['tVatrate'] == '') ? $paData['FCVatRate'] : $paDataWhere['tVatrate']);
                $this->db->set('FCXtdNet'       , $paData['FTPdtPoint'] * $paData['FCPdtCostStd']);
                $this->db->set('FTXtdStaAlwDis' , $paData['FTPdtStaAlwDis']);
                $this->db->set('FCXtdQty'       , $nQty ); 
                $this->db->set('FCXtdQtyAll'    , $nQty * $paData['FCPdtUnitFact']); // จากสูตร qty * fector
                $this->db->set('FCXtdSalePrice' , $paData['FTPdtSalePrice']);
                $this->db->set('FTBchCode'      , $paDataWhere['tBchCode']);
                $this->db->set('FTXthDocNo'     , $paDataWhere['tDocNo']);
                $this->db->set('FNXtdSeqNo'     , $paDataWhere['nMaxSeqNo']);
                $this->db->set('FTXthDocKey'    , $paDataWhere['tDocKey']);
                $this->db->set('FTXtdBarCode'   , $paDataWhere['tBarCode']);
                $this->db->set('FCXtdSetPrice'  , $paDataWhere['pcPrice'] * 1); // pcPrice มาจากข้อมูลใน modal คือ (ต้อทุนต่อหน่วยเล็กสุด * fector) จะได้จากสูตร  pcPrice * rate  (rate ต้องนำมาจากสกุลเงินของ company)
                $this->db->set('FTSessionID'    , $paDataWhere['tSessionID']);
                $this->db->set('FDLastUpdOn'    , date('Y-m-d h:i:s'));
                $this->db->set('FTLastUpdBy'    , $this->session->userdata('tSesUsername'));
                $this->db->set('FDCreateOn'     , date('Y-m-d h:i:s'));
                $this->db->set('FTCreateBy'     , $this->session->userdata('tSesUsername'));
                $this->db->insert('TCNTDocDTTmp');

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
            // เพิ่มแถวใหม่
            $this->db->set('FTPdtCode', $paData['FTPdtCode']);
            $this->db->set('FTXtdPdtName', $paData['FTPdtName']);
            $this->db->set('FCXtdFactor', $paData['FCPdtUnitFact']);
            $this->db->set('FCPdtUnitFact', $paData['FCPdtUnitFact']);
            $this->db->set('FTPunCode', $paData['FTPunCode']);
            $this->db->set('FTPunName', $paData['FTPunName']);
            $this->db->set('FTXtdVatType', $paData['FTPdtStaVatBuy']);
            $this->db->set('FTVatCode', $paData['FTVatCode']);
            $this->db->set('FCXtdVatRate', $paData['FCVatRate']);
            $this->db->set('FCXtdNet', $paData['FTPdtPoint'] * $paData['FCPdtCostStd']);
            $this->db->set('FTXtdStaAlwDis', $paData['FTPdtStaAlwDis']);
            $this->db->set('FCXtdQty', 1);  // เพิ่มสินค้าใหม่
            $this->db->set('FCXtdQtyAll', 1*$paData['FCPdtUnitFact']); // จากสูตร qty * fector
            $this->db->set('FCXtdSalePrice', $paData['FTPdtSalePrice']);

            $this->db->set('FTBchCode', $paDataWhere['tBchCode']);
            $this->db->set('FTXthDocNo', $paDataWhere['tDocNo']);
            $this->db->set('FNXtdSeqNo', $paDataWhere['nMaxSeqNo']);
            $this->db->set('FTXthDocKey', $paDataWhere['tDocKey']);
            $this->db->set('FTXtdBarCode', $paDataWhere['tBarCode']);
            $this->db->set('FCXtdSetPrice', $paDataWhere['pcPrice'] * 1); // pcPrice มาจากข้อมูลใน modal คือ (ต้อทุนต่อหน่วยเล็กสุด * fector) จะได้จากสูตร  pcPrice * rate  (rate ต้องนำมาจากสกุลเงินของ company)
            $this->db->set('FTSessionID', $paDataWhere['tSessionID']);
            $this->db->set('FDLastUpdOn', date('Y-m-d h:i:s'));
            $this->db->set('FTLastUpdBy', $this->session->userdata('tSesUsername'));
            $this->db->set('FDCreateOn', date('Y-m-d h:i:s'));
            $this->db->set('FTCreateBy', $this->session->userdata('tSesUsername'));
                    
            $this->db->insert('TCNTDocDTTmp');

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
        
        return $aStatus;
        
    }

    /**
     * Functionality : Update DocNo in DT Temp
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : Status insert
     * Return Type : array
     */
    function FSaMCreditNoteAddUpdateDocNoInDocTemp($aDataWhere = []){

        try{

            $this->db->set('FTXthDocNo' , $aDataWhere['tDocNo']);    
            $this->db->set('FTBchCode'  , $aDataWhere['tBchCode']);    
            $this->db->where('FTXthDocNo', '');
            $this->db->where('FTSessionID', $$aDataWhere['tSessionID']);
            $this->db->where('FTXthDocKey', $aDataWhere['tDocKey']);
            $this->db->update('TCNTDocDTTmp');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update DocNo Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Update DocNo Fail',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Cancel Doc
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : Status update
     * Return Type : array
     */
    public function FSaMCreditNoteCancel($paDataUpdate = []){
        try{
            // TAPTPcHD
            $this->db->set('FTXphStaDoc' , '3');
            $this->db->where('FTXphDocNo', $paDataUpdate['tDocNo']);
            $this->db->update('TAPTPcHD');
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

    /**
     * Functionality : Approve Doc
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : Status update
     * Return Type : array
     */
    public function FSaMCreditNoteHavePdtApprove($paDataUpdate = []){
        try{
            // TAPTPcHD
            $this->db->set('FTXphStaPrcStk' , '2');
            $this->db->set('FTXphStaApv' , '2');
            $this->db->set('FTXphApvCode' , $paDataUpdate['tApvCode']);
            $this->db->where('FTXphDocNo', $paDataUpdate['tDocNo']);

            $this->db->update('TAPTPcHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Approve Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Approve Fail',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Approve Doc
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : Status update
     * Return Type : array
     */
    public function FSaMCreditNoteNonePdtApprove($paDataUpdate = []){
        try{
            // TAPTPcHD
            $this->db->set('FTXphStaPrcStk' , '1');
            $this->db->set('FTXphStaApv' , '1');
            $this->db->set('FTXphApvCode' , $paDataUpdate['tApvCode']);
            $this->db->where('FTXphDocNo', $paDataUpdate['tDocNo']);

            $this->db->update('TAPTPcHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Approve Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Approve Fail',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Function Get Sum From Temp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteSumDTTemp($paDataWhere = []){

        $tDocNo = $paDataWhere['tDocNo'];
        $tDocKey = $paDataWhere['tDocKey'];
        $tSesSessionID = $this->session->userdata('tSesSessionID');   

        $tSQL = "   SELECT 
                        SUM(FCXtdAmt) AS FCXtdAmt
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1
                ";
             
            $tSQL .= " AND DOCTMP.FTXthDocNo = '$tDocNo'";

            $tSQL .= " AND DOCTMP.FTXthDocKey = '$tDocKey'";

            $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $oResult = $oQuery->result_array();
            }else{
                $oResult = '';
            }


        return $oResult;

    }

    /**
     * Functionality : Function Get Cal From HDDis Temp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piyas
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteCalInHDDisTemp($paParams = []){

        $tDocNo = $paParams['tDocNo'];
        $tDocKey = $paParams['tDocKey'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID']; 
        
        $tSQL = "
                    SELECT
                        /* ข้อความมูลค่าลดชาร์จ ==============================================================*/
                        STUFF((
                            SELECT  ',' + DOCCONCAT.FTXtdDisChgTxt
                            FROM TCNTDocHDDisTmp DOCCONCAT
                            WHERE  1=1 
                            AND DOCCONCAT.FTBchCode 		= '$tBchCode'
                            AND DOCCONCAT.FTXthDocNo		= '$tDocNo'
                            AND DOCCONCAT.FTSessionID		= '$tSessionID'
                        FOR XML PATH('')), 1, 1, '') AS FTXphDisChgTxt,
                        
                        /* มูลค่ารวมส่วนลด ==============================================================*/
                        SUM( 
                            CASE 
                                WHEN HDDISTMP.FTXtdDisChgType = 1 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                WHEN HDDISTMP.FTXtdDisChgType = 2 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                ELSE 0 
                            END
                        ) AS FCXphDis,
                        
                        /* มูลค่ารวมส่วนชาร์จ ==============================================================*/
                        SUM( 
                            CASE 
                                WHEN HDDISTMP.FTXtdDisChgType = 3 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                WHEN HDDISTMP.FTXtdDisChgType = 4 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                ELSE 0 
                            END
                        ) AS FCXphChg
                        
                    FROM TCNTDocHDDisTmp HDDISTMP    
                    
                    WHERE HDDISTMP.FTXthDocNo   = '$tDocNo' 
                    AND HDDISTMP.FTSessionID    = '$tSessionID'
                    AND HDDISTMP.FTBchCode      = '$tBchCode'

                    GROUP BY HDDISTMP.FTSessionID
                ";
        
        $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $aResult = $oQuery->result_array()[0];
            }else{
                $aResult = [];
            }


        return $aResult;
    }
    
    /**
     * Functionality : Function Get Cal From DT Temp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteGetSplVatCode($paParams = []){
        $tSplCode = $paParams['tSplCode'];
        
        $tSQL = "   SELECT 
                        *
                    FROM TCNMSpl WITH (NOLOCK)
                    WHERE FTSplCode = '$tSplCode'
                ";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $aResult = $oQuery->row_array();
            }else{
                $aResult = '';
            }


        return $aResult;
        
    }
    
    /**
     * Functionality : Function Get Cal From DT Temp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteGetHDSpl($paParams = []){
        $tDocNo = $paParams['tDocNo'];
        
        $tSQL = "   SELECT 
                        *
                    FROM TAPTPcHDSpl WITH (NOLOCK)
                    WHERE FTXphDocNo = '$tDocNo'
                ";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $aResult = $oQuery->row_array();
            }else{
                $aResult = '';
            }


        return $aResult;
        
    }
    
    /**
     * Functionality : Function Get Cal From DT Temp
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSaMCreditNoteCalInDTTemp($paParams = []){

        $tDocNo = $paParams['tDocNo'];
        $tDocKey = $paParams['tDocKey'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];   

        $tSQL = "   SELECT 
                        /* ยอดรวม ==============================================================*/
                        SUM(ISNULL(DTTMP.FCXtdNet, 0)) AS FCXphTotal,

                        /* ยอดรวมสินค้าไม่มีภาษี ==============================================================*/
                        SUM(
                            CASE
                                WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                ELSE 0
                            END
                        ) AS FCXphTotalNV,

                        /* ยอดรวมสินค้าห้ามลด ==============================================================*/
                        SUM(
                            CASE
                                WHEN DTTMP.FTXtdStaAlwDis = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                ELSE 0
                            END
                        ) AS FCXphTotalNoDis,

                        /* ยอมรวมสินค้าลดได้ และมีภาษี ==============================================================*/
                        SUM(
                            CASE
                                WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                ELSE 0
                            END
                        ) AS FCXphTotalB4DisChgV,

                        /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                        SUM(
                            CASE
                                WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                ELSE 0
                            END
                        ) AS FCXphTotalB4DisChgNV,

                        /* ยอดรวมหลังลด และมีภาษี ==============================================================*/
                        SUM(
                            CASE
                                WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                ELSE 0
                            END
                        ) AS FCXphTotalAfDisChgV,

                        /* ยอดรวมหลังลด และไม่มีภาษี ==============================================================*/
                        SUM(
                            CASE
                                WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                ELSE 0
                            END
                        ) AS FCXphTotalAfDisChgNV,

                        /* ยอดรวมเฉพาะภาษี ==============================================================*/
                        (
                            (
                                /* ยอดรวม */
                                SUM(DTTMP.FCXtdNet)
                                - 
                                /* ยอดรวมสินค้าไม่มีภาษี */
                                SUM(
                                    CASE
                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                        ELSE 0
                                    END
                                )
                            )
                            -
                            (
                                /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                SUM(
                                    CASE
                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                        ELSE 0
                                    END
                                )
                                -
                                /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                SUM(
                                    CASE
                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                        ELSE 0
                                    END
                                )
                            )
                        ) AS FCXphAmtV,

                        /* ยอดรวมเฉพาะไม่มีภาษี ==============================================================*/
                        (
                            (
                                /* ยอดรวมสินค้าไม่มีภาษี */
                                SUM(
                                    CASE
                                        WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                        ELSE 0
                                    END
                                )
                            )
                            -
                            (
                                /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                SUM(
                                    CASE
                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                        ELSE 0
                                    END
                                )
                                -
                                /* ยอดรวมหลังลด และไม่มีภาษี */
                                SUM(
                                    CASE
                                        WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                        ELSE 0
                                    END
                                )
                            )
                        ) AS FCXphAmtNV,

                        /* ยอดภาษี ==============================================================*/
                        SUM(ISNULL(DTTMP.FCXtdVat, 0)) AS FCXphVat,

                        /* ยอดแยกภาษี ==============================================================*/
                        (
                            (
                                /* ยอดรวมเฉพาะภาษี */
                                (
                                    (
                                        /* ยอดรวม */
                                        SUM(DTTMP.FCXtdNet)
                                        - 
                                        /* ยอดรวมสินค้าไม่มีภาษี */
                                        SUM(
                                            CASE
                                                WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                ELSE 0
                                            END
                                        )
                                    )
                                    -
                                    (
                                        /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                        SUM(
                                            CASE
                                                WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                ELSE 0
                                            END
                                        )
                                        -
                                        /* ยอดรวมหลังลด และมีภาษี */
                                        SUM(
                                            CASE
                                                WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                ELSE 0
                                            END
                                        )
                                    )
                                )
                                -
                                /* ยอดภาษี */
                                SUM(ISNULL(DTTMP.FCXtdVat, 0))	
                            )
                            +
                            (
                                /* ยอดรวมเฉพาะไม่มีภาษี */
                                (
                                    (
                                        /* ยอดรวมสินค้าไม่มีภาษี */
                                        SUM(
                                            CASE
                                                WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                ELSE 0
                                            END
                                        )
                                    )
                                    -
                                    (
                                        /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                        SUM(
                                            CASE
                                                WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                ELSE 0
                                            END
                                        )
                                        -
                                        /* ยอดรวมหลังลด และไม่มีภาษี */
                                        SUM(
                                            CASE
                                                WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                ELSE 0
                                            END
                                        )
                                    )
                                )
                            )
                        ) AS FCXphVatable,

                        /* รหัสอัตราภาษี ณ ที่จ่าย ==============================================================*/
                        STUFF((
                            SELECT  ',' + DOCCONCAT.FTXtdWhtCode
                            FROM TCNTDocDTTmp DOCCONCAT
                            WHERE  1=1 
                            AND DOCCONCAT.FTBchCode = '$tBchCode'
                            AND DOCCONCAT.FTXthDocNo = '$tDocNo'
                            AND DOCCONCAT.FTSessionID = '$tSessionID'
                        FOR XML PATH('')), 1, 1, '') AS FTXphWpCode,

                        /* ภาษีหัก ณ ที่จ่าย ==============================================================*/
                        SUM(ISNULL(DTTMP.FCXtdWhtAmt, 0)) AS FCXphWpTax

                        FROM TCNTDocDTTmp DTTMP 
                        WHERE DTTMP.FTXthDocNo = '$tDocNo' 
                        AND DTTMP.FTXthDocKey = '$tDocKey' 
                        AND DTTMP.FTSessionID = '$tSessionID'
                        AND DTTMP.FTBchCode = '$tBchCode'

                        GROUP BY DTTMP.FTSessionID
                ";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
                $aResult = $oQuery->result_array();
            }else{
                $aResult = [];
            }


        return $aResult;

    }

    /**
     * Functionality : Get User Login
     * Parameters : function parameters
     * Creator : 22/05/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : Array
     */
    public function FStCreditNoteGetUsrByCode($paParams = []){

        $nLngID = $paParams['FNLngID'];
        $tUsrLogin = $paParams['FTUsrCode'];
        
        if($this->session->userdata('tSesUsrLevel') == "HQ"){
            $tBchCode = "'" . FCNtGetBchInComp() . "'";
        }else{
            $tBchCode = "UGP.FTBchCode";
        }
        $tSQL = "SELECT BCH.FTBchCode,
                        BCHL.FTBchName,
                        MCHL.FTMerCode,
                        MCHL.FTMerName,
                        UGP.FTShpCode,
                        SHPL.FTShpName,
                        SHP.FTShpType,
                        USR.FTUsrCode,
                        USRL.FTUsrName,
                        USR.FTDptCode,
                        DPTL.FTDptName,
                        WAH.FTWahCode AS FTWahCode,
			WAHL.FTWahName AS FTWahName
                        /*  BCH.FTWahCode AS FTWahCode_Bch,  */
                        /*  BWAHL.FTWahName AS FTWahName_Bch  */

                FROM TCNMUser USR
                LEFT JOIN TCNMUser_L USRL ON USRL.FTUsrCode = USR.FTUsrCode AND USRL.FNLngID = $nLngID
                LEFT JOIN TCNTUsrGroup UGP ON UGP.FTUsrCode = USR.FTUsrCode
                LEFT JOIN TCNMBranch BCH ON $tBchCode = BCH.FTBchCode 
                LEFT JOIN TCNMBranch_L BCHL ON $tBchCode = BCHL.FTBchCode 
                LEFT JOIN TCNMShop SHP ON UGP.FTShpCode = SHP.FTShpCode
                LEFT JOIN TCNMShop_L SHPL ON UGP.FTShpCode = SHPL.FTShpCode AND UGP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                LEFT JOIN TCNMWaHouse WAH ON ($tBchCode = WAH.FTWahRefCode OR SHP.FTShpCode = WAH.FTWahRefCode)
                LEFT JOIN TCNMWaHouse_L WAHL ON WAH.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                LEFT JOIN TCNMMerchant_L MCHL ON SHP.FTMerCode = MCHL.FTMerCode AND  MCHL.FNLngID = $nLngID  
                LEFT JOIN TCNMUsrDepart_L DPTL ON DPTL.FTDptCode = USR.FTDptCode AND DPTL.FNLngID = $nLngID    
                WHERE USR.FTUsrCode ='".$tUsrLogin."'";
        $oQuery = $this->db->query($tSQL);
       
        if ($oQuery->num_rows() > 0){
            $oRes  = $oQuery->row_array();
            $tDataShp = $oRes;
        }else{
            $tDataShp = '';
        }

        return $tDataShp;
    }

    /**
     * Functionality : Search CreditNote By ID
     * Parameters : function parameters
     * Creator : 22/05/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : Array
     */
    public function FSaMCreditNoteGetHD($paData = []){

        $tDocNo  = $paData['FTXphDocNo'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT
                    HD.FTBchCode,
                    HD.FTXphDocNo,
                    HD.FNXphDocType,
                    CONVERT(CHAR(5), HD.FDXphDocDate, 108) AS FTXphDocTime,
                    HD.FDXphDocDate,
                    HD.FTShpCode,
                    HD.FTXphCshOrCrd,
                    HD.FTXphVATInOrEx,
                    HD.FTDptCode,
                    HD.FTWahCode,
                    HD.FTUsrCode,
                    HD.FTXphApvCode,
                    HD.FTSplCode,
                    HD.FTXphRefExt,
                    HD.FDXphRefExtDate,
                    HD.FTXphRefInt,
                    HD.FDXphRefIntDate,
                    HD.FTXphRefAE,
                    HD.FNXphDocPrint,
                    HD.FTRteCode,
                    HD.FCXphRteFac,
                    HD.FCXphTotal,
                    HD.FCXphTotalNV,
                    HD.FCXphTotalNoDis,
                    HD.FTXphStaDelMQ,
                    HD.FCXphTotalB4DisChgV,
                    HD.FCXphTotalB4DisChgNV,
                    HD.FTXphDisChgTxt,
                    HD.FCXphDis,
                    HD.FCXphChg,
                    HD.FCXphTotalAfDisChgV,
                    HD.FCXphTotalAfDisChgNV,
                    HD.FCXphRefAEAmt,
                    HD.FCXphAmtV,
                    HD.FCXphAmtNV,
                    HD.FCXphVat,
                    HD.FCXphVatable,
                    HD.FTXphWpCode,
                    HD.FCXphWpTax,
                    HD.FCXphGrand,
                    HD.FCXphRnd,
                    HD.FTXphGndText,
                    HD.FCXphPaid,
                    HD.FCXphLeft,
                    HD.FTXphRmk,
                    HD.FTXphStaRefund,
                    HD.FTXphStaDoc,
                    HD.FTXphStaApv,
                    HD.FTXphStaPrcStk,
                    HD.FTXphStaPaid,
                    HD.FNXphStaDocAct,
                    HD.FNXphStaRef,
                    HD.FDCreateOn,
                    HD.FTCreateBy,
                    HD.FDLastUpdOn,
                    HD.FTLastUpdBy,
                    
                    
                    BCHLDOC.FTBchName,
                    DPTL.FTDptName,
                    SHPL.FTShpName,
                    WAHL.FTWahName,
                    SPLL.FTSplName
                    /*USRLCREATE.FTUsrName AS FTCreateByName,
                    USRLKEY.FTUsrName AS FTUsrName,
                    USRAPV.FTUsrName AS FTXphStaApvName,
                    SHPLTO.FTShpName AS FTXphShopNameTo,
                    WAHLTO.FTWahName AS FTXphWhNameTo,
                    POSVDTO.FTPosComName AS FTXphPosNameTo*/
                    
                FROM [TAPTPcHD] HD

                LEFT JOIN TCNMBranch_L      BCHLDOC ON HD.FTBchCode = BCHLDOC.FTBchCode AND BCHLDOC.FNLngID = $nLngID
                /*LEFT JOIN TCNMBranch_L      BCHLTO ON HD.FTXphBchTo = BCHLTO.FTBchCode AND BCHLTO.FNLngID = $nLngID  
                LEFT JOIN TCNMMerchant_L    MCHLTO ON HD.FFXphMerchantTo = MCHLTO.FTMerCode AND MCHLTO.FNLngID = $nLngID    
                LEFT JOIN TCNMUser_L        USRLCREATE ON HD.FTCreateBy = USRLCREATE.FTUsrCode AND USRLCREATE.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L        USRLKEY ON HD.FTUsrCode = USRLKEY.FTUsrCode AND USRLKEY.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L        USRAPV ON HD.FTXphApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID*/
                LEFT JOIN TCNMSpl_L SPLL ON HD.FTSplCode = SPLL.FTSplCode AND SPLL.FNLngID = $nLngID    
                LEFT JOIN TCNMUsrDepart_L   DPTL ON HD.FTDptCode = DPTL.FTDptCode AND DPTL.FNLngID = $nLngID
                LEFT JOIN TCNMShop_L        SHPL ON HD.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = $nLngID
                LEFT JOIN TCNMWaHouse_L     WAHL ON HD.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                /*LEFT JOIN TCNMPosLastNo     POSVDTO WITH (NOLOCK) ON HD.FTXphPosTo = POSVDTO.FTPosCode*/   
                 
                WHERE 1=1 ";
      
        if($tDocNo != ""){
            $tSQL .= "AND HD.FTXphDocNo = '$tDocNo'";
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

    /**
     * Functionality : Function Add/Update Master สำหรับใบลดหนี้มีสินค้า
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : Status Add/Update Master
     * Return Type : array
     */
    public function FSaMCreditNoteAddUpdateHDHavePdt($paData = []){
        
        try{
            // Update Master
            $this->db->set('FTBchCode', $paData['FTBchCode']);
            $this->db->set('FDXphDocDate', $paData['FDXphDocDate']);
            $this->db->set('FTShpCode', $paData['FTShpCode']);
            $this->db->set('FTXphCshOrCrd', $paData['FTXphCshOrCrd']);
            $this->db->set('FTXphVATInOrEx', $paData['FTXphVATInOrEx']);
            $this->db->set('FTWahCode', $paData['FTWahCode']);
            $this->db->set('FTSplCode', $paData['FTSplCode']);
            $this->db->set('FTXphRefExt', $paData['FTXphRefExt']);
            $this->db->set('FDXphRefExtDate', $paData['FDXphRefExtDate']);
            $this->db->set('FTXphRefInt', $paData['FTXphRefInt']);
            $this->db->set('FDXphRefIntDate', $paData['FDXphRefIntDate']);
            $this->db->set('FCXphTotal', $paData['FCXphTotal']);
            $this->db->set('FCXphTotalNV', $paData['FCXphTotalNV']);
            $this->db->set('FCXphTotalNoDis', $paData['FCXphTotalNoDis']);
            $this->db->set('FCXphTotalB4DisChgV', $paData['FCXphTotalB4DisChgV']);
            $this->db->set('FCXphTotalB4DisChgNV', $paData['FCXphTotalB4DisChgNV']);
            $this->db->set('FTXphDisChgTxt', $paData['FTXphDisChgTxt']);
            $this->db->set('FCXphDis', $paData['FCXphDis']);
            $this->db->set('FCXphChg', $paData['FCXphChg']);
            $this->db->set('FCXphTotalAfDisChgV', $paData['FCXphTotalAfDisChgV']);
            $this->db->set('FCXphTotalAfDisChgNV', $paData['FCXphTotalAfDisChgNV']);
            $this->db->set('FCXphAmtV', $paData['FCXphAmtV']);
            $this->db->set('FCXphAmtNV', $paData['FCXphAmtNV']);
            $this->db->set('FCXphVat', $paData['FCXphVat']);
            $this->db->set('FCXphVatable', $paData['FCXphVatable']);
            $this->db->set('FTXphWpCode', $paData['FTXphWpCode']);
            $this->db->set('FCXphWpTax', $paData['FCXphWpTax']);
            $this->db->set('FCXphGrand', $paData['FCXphGrand']);
            $this->db->set('FCXphRnd', $paData['FCXphRnd']);
            $this->db->set('FTXphGndText', $paData['FTXphGndText']);
            $this->db->set('FTXphRmk', $paData['FTXphRmk']);
            $this->db->set('FNXphStaDocAct', $paData['FNXphStaDocAct']);
            $this->db->set('FNXphStaRef', $paData['FNXphStaRef']);
            
            $this->db->set('FDLastUpdOn', 'GETDATE()', false);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            $this->db->where('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->update('TAPTPcHD');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->set('FTBchCode', $paData['FTBchCode']);
                $this->db->set('FTXphDocNo', $paData['FTXphDocNo']);
                $this->db->set('FNXphDocType', $paData['FNXphDocType']);
                $this->db->set('FDXphDocDate', $paData['FDXphDocDate']);
                $this->db->set('FTShpCode', $paData['FTShpCode']);
                $this->db->set('FTXphCshOrCrd', $paData['FTXphCshOrCrd']);
                $this->db->set('FTXphVATInOrEx', $paData['FTXphVATInOrEx']);
                $this->db->set('FTDptCode', $paData['FTDptCode']);
                $this->db->set('FTWahCode', $paData['FTWahCode']);
                $this->db->set('FTUsrCode', $paData['FTUsrCode']);
                $this->db->set('FTXphApvCode', $paData['FTXphApvCode']);
                $this->db->set('FTSplCode', $paData['FTSplCode']);
                $this->db->set('FTXphRefExt', $paData['FTXphRefExt']);
                $this->db->set('FDXphRefExtDate', $paData['FDXphRefExtDate']);
                $this->db->set('FTXphRefInt', $paData['FTXphRefInt']);
                $this->db->set('FDXphRefIntDate', $paData['FDXphRefIntDate']);
                $this->db->set('FTXphRefAE', $paData['FTXphRefAE']);
                $this->db->set('FNXphDocPrint', $paData['FNXphDocPrint']);
                $this->db->set('FTRteCode', $paData['FTRteCode']);
                $this->db->set('FCXphRteFac', $paData['FCXphRteFac']);
                $this->db->set('FCXphTotal', $paData['FCXphTotal']);
                $this->db->set('FCXphTotalNV', $paData['FCXphTotalNV']);
                $this->db->set('FCXphTotalNoDis', $paData['FCXphTotalNoDis']);
                $this->db->set('FCXphTotalB4DisChgV', $paData['FCXphTotalB4DisChgV']);
                $this->db->set('FCXphTotalB4DisChgNV', $paData['FCXphTotalB4DisChgNV']);
                $this->db->set('FTXphDisChgTxt', $paData['FTXphDisChgTxt']);
                $this->db->set('FCXphDis', $paData['FCXphDis']);
                $this->db->set('FCXphChg', $paData['FCXphChg']);
                $this->db->set('FCXphTotalAfDisChgV', $paData['FCXphTotalAfDisChgV']);
                $this->db->set('FCXphTotalAfDisChgNV', $paData['FCXphTotalAfDisChgNV']);
                $this->db->set('FCXphRefAEAmt', $paData['FCXphRefAEAmt']);
                $this->db->set('FCXphAmtV', $paData['FCXphAmtV']);
                $this->db->set('FCXphAmtNV', $paData['FCXphAmtNV']);
                $this->db->set('FCXphVat', $paData['FCXphVat']);
                $this->db->set('FCXphVatable', $paData['FCXphVatable']);
                $this->db->set('FTXphWpCode', $paData['FTXphWpCode']);
                $this->db->set('FCXphWpTax', $paData['FCXphWpTax']);
                $this->db->set('FCXphGrand', $paData['FCXphGrand']);
                $this->db->set('FCXphRnd', $paData['FCXphRnd']);
                $this->db->set('FTXphGndText', $paData['FTXphGndText']);
                $this->db->set('FCXphPaid', $paData['FCXphPaid']);
                $this->db->set('FCXphLeft', $paData['FCXphLeft']);
                $this->db->set('FTXphRmk', $paData['FTXphRmk']);
                $this->db->set('FTXphStaRefund', $paData['FTXphStaRefund']);
                $this->db->set('FTXphStaDoc', $paData['FTXphStaDoc']);
                $this->db->set('FTXphStaApv', $paData['FTXphStaApv']);
                $this->db->set('FTXphStaPrcStk', $paData['FTXphStaPrcStk']);
                $this->db->set('FTXphStaPaid', $paData['FTXphStaPaid']);
                $this->db->set('FNXphStaDocAct', $paData['FNXphStaDocAct']);
                $this->db->set('FNXphStaRef', $paData['FNXphStaRef']);

                $this->db->set('FDCreateOn', 'GETDATE()', false);
                $this->db->set('FTCreateBy', $paData['FTCreateBy']);
                $this->db->set('FDLastUpdOn', 'GETDATE()', false);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

                $this->db->insert('TAPTPcHD');
                    
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
    
    /**
     * Functionality : Function Add/Update Master สำหรับใบลดหนี้ไม่มีสินค้า
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : Status Add/Update Master
     * Return Type : array
     */
    public function FSaMCreditNoteAddUpdateHDNonePdt($paData = []){
        
        try{
            // Update Master
            $this->db->set('FTBchCode', $paData['FTBchCode']);
            $this->db->set('FDXphDocDate', $paData['FDXphDocDate']);
            $this->db->set('FTShpCode', $paData['FTShpCode']);
            $this->db->set('FTXphCshOrCrd', $paData['FTXphCshOrCrd']);
            $this->db->set('FTXphVATInOrEx', $paData['FTXphVATInOrEx']);
            $this->db->set('FTWahCode', $paData['FTWahCode']);
            $this->db->set('FTSplCode', $paData['FTSplCode']);
            $this->db->set('FTXphRefExt', $paData['FTXphRefExt']);
            $this->db->set('FDXphRefExtDate', $paData['FDXphRefExtDate']);
            $this->db->set('FTXphRefInt', $paData['FTXphRefInt']);
            $this->db->set('FDXphRefIntDate', $paData['FDXphRefIntDate']);
            $this->db->set('FCXphTotal', $paData['FCXphTotal']);
            $this->db->set('FCXphTotalNV', $paData['FCXphTotalNV']);
            $this->db->set('FCXphTotalNoDis', $paData['FCXphTotalNoDis']);
            $this->db->set('FCXphTotalB4DisChgV', $paData['FCXphTotalB4DisChgV']);
            $this->db->set('FCXphTotalB4DisChgNV', $paData['FCXphTotalB4DisChgNV']);
            $this->db->set('FTXphDisChgTxt', $paData['FTXphDisChgTxt']);
            $this->db->set('FCXphDis', $paData['FCXphDis']);
            $this->db->set('FCXphChg', $paData['FCXphChg']);
            $this->db->set('FCXphTotalAfDisChgV', $paData['FCXphTotalAfDisChgV']);
            $this->db->set('FCXphTotalAfDisChgNV', $paData['FCXphTotalAfDisChgNV']);
            $this->db->set('FCXphAmtV', $paData['FCXphAmtV']);
            $this->db->set('FCXphAmtNV', $paData['FCXphAmtNV']);
            $this->db->set('FCXphVat', $paData['FCXphVat']);
            $this->db->set('FCXphVatable', $paData['FCXphVatable']);
            $this->db->set('FTXphWpCode', $paData['FTXphWpCode']);
            $this->db->set('FCXphWpTax', $paData['FCXphWpTax']);
            $this->db->set('FCXphGrand', $paData['FCXphGrand']);
            $this->db->set('FCXphRnd', $paData['FCXphRnd']);
            $this->db->set('FTXphGndText', $paData['FTXphGndText']);
            $this->db->set('FTXphRmk', $paData['FTXphRmk']);
            $this->db->set('FNXphStaDocAct', $paData['FNXphStaDocAct']);
            $this->db->set('FNXphStaRef', $paData['FNXphStaRef']);
            
            $this->db->set('FDLastUpdOn', 'GETDATE()', false);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            $this->db->where('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->update('TAPTPcHD');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->set('FTBchCode', $paData['FTBchCode']);
                $this->db->set('FTXphDocNo', $paData['FTXphDocNo']);
                $this->db->set('FNXphDocType', $paData['FNXphDocType']);
                $this->db->set('FDXphDocDate', $paData['FDXphDocDate']);
                $this->db->set('FTShpCode', $paData['FTShpCode']);
                $this->db->set('FTXphCshOrCrd', $paData['FTXphCshOrCrd']);
                $this->db->set('FTXphVATInOrEx', $paData['FTXphVATInOrEx']);
                $this->db->set('FTDptCode', $paData['FTDptCode']);
                $this->db->set('FTWahCode', $paData['FTWahCode']);
                $this->db->set('FTUsrCode', $paData['FTUsrCode']);
                $this->db->set('FTXphApvCode', $paData['FTXphApvCode']);
                $this->db->set('FTSplCode', $paData['FTSplCode']);
                $this->db->set('FTXphRefExt', $paData['FTXphRefExt']);
                $this->db->set('FDXphRefExtDate', $paData['FDXphRefExtDate']);
                $this->db->set('FTXphRefInt', $paData['FTXphRefInt']);
                $this->db->set('FDXphRefIntDate', $paData['FDXphRefIntDate']);
                $this->db->set('FTXphRefAE', $paData['FTXphRefAE']);
                $this->db->set('FNXphDocPrint', $paData['FNXphDocPrint']);
                $this->db->set('FTRteCode', $paData['FTRteCode']);
                $this->db->set('FCXphRteFac', $paData['FCXphRteFac']);
                $this->db->set('FCXphTotal', $paData['FCXphTotal']);
                $this->db->set('FCXphTotalNV', $paData['FCXphTotalNV']);
                $this->db->set('FCXphTotalNoDis', $paData['FCXphTotalNoDis']);
                $this->db->set('FCXphTotalB4DisChgV', $paData['FCXphTotalB4DisChgV']);
                $this->db->set('FCXphTotalB4DisChgNV', $paData['FCXphTotalB4DisChgNV']);
                $this->db->set('FTXphDisChgTxt', $paData['FTXphDisChgTxt']);
                $this->db->set('FCXphDis', $paData['FCXphDis']);
                $this->db->set('FCXphChg', $paData['FCXphChg']);
                $this->db->set('FCXphTotalAfDisChgV', $paData['FCXphTotalAfDisChgV']);
                $this->db->set('FCXphTotalAfDisChgNV', $paData['FCXphTotalAfDisChgNV']);
                $this->db->set('FCXphRefAEAmt', $paData['FCXphRefAEAmt']);
                $this->db->set('FCXphAmtV', $paData['FCXphAmtV']);
                $this->db->set('FCXphAmtNV', $paData['FCXphAmtNV']);
                $this->db->set('FCXphVat', $paData['FCXphVat']);
                $this->db->set('FCXphVatable', $paData['FCXphVatable']);
                $this->db->set('FTXphWpCode', $paData['FTXphWpCode']);
                $this->db->set('FCXphWpTax', $paData['FCXphWpTax']);
                $this->db->set('FCXphGrand', $paData['FCXphGrand']);
                $this->db->set('FCXphRnd', $paData['FCXphRnd']);
                $this->db->set('FTXphGndText', $paData['FTXphGndText']);
                $this->db->set('FCXphPaid', $paData['FCXphPaid']);
                $this->db->set('FCXphLeft', $paData['FCXphLeft']);
                $this->db->set('FTXphRmk', $paData['FTXphRmk']);
                $this->db->set('FTXphStaRefund', $paData['FTXphStaRefund']);
                $this->db->set('FTXphStaDoc', $paData['FTXphStaDoc']);
                $this->db->set('FTXphStaApv', $paData['FTXphStaApv']);
                $this->db->set('FTXphStaPrcStk', $paData['FTXphStaPrcStk']);
                $this->db->set('FTXphStaPaid', $paData['FTXphStaPaid']);
                $this->db->set('FNXphStaDocAct', $paData['FNXphStaDocAct']);
                $this->db->set('FNXphStaRef', $paData['FNXphStaRef']);
                
                $this->db->set('FDCreateOn', 'GETDATE()', false);
                $this->db->set('FTCreateBy', $paData['FTCreateBy']);
                $this->db->set('FDLastUpdOn', 'GETDATE()', false);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->insert('TAPTPcHD');
                
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

    /**
     * Functionality : Function Add/Update Master สำหรับใบลดหนี้ไม่มีสินค้า
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : Status Add/Update Master
     * Return Type : array
     */
    public function FSaMCreditNoteAddUpdateDTNonePdt($paData = []){
        try{
            // Update Master
            $this->db->set('FTBchCode', $paData['FTBchCode']);
            $this->db->set('FTPdtCode', $paData['FTPdtCode']);
            $this->db->set('FTXpdPdtName', $paData['FTXpdPdtName']);
            $this->db->set('FTXpdVatType', $paData['FTXpdVatType']);
            $this->db->set('FTVatCode', $paData['FTVatCode']);
            $this->db->set('FCXpdVatRate', $paData['FCXpdVatRate']);
            $this->db->set('FCXpdSetPrice', $paData['FCXpdSetPrice']);
            $this->db->set('FCXpdAmtB4DisChg', $paData['FCXpdAmtB4DisChg']);
            $this->db->set('FCXpdNet', $paData['FCXpdNet']);
            $this->db->set('FCXpdNetAfHD', $paData['FCXpdNetAfHD']);
            $this->db->set('FCXpdVat', $paData['FCXpdVat']);
            $this->db->set('FCXpdVatable', $paData['FCXpdVatable']);
            $this->db->set('FCXpdCostIn', $paData['FCXpdCostIn']);
            $this->db->set('FCXpdCostEx', $paData['FCXpdCostEx']);
            
            $this->db->set('FDLastUpdOn', 'GETDATE()', false);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            $this->db->where('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->update('TAPTPcDT');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->set('FTBchCode', $paData['FTBchCode']);
                $this->db->set('FTXphDocNo', $paData['FTXphDocNo']);
                $this->db->set('FNXpdSeqNo', $paData['FNXpdSeqNo']);
                $this->db->set('FTPdtCode', $paData['FTPdtCode']);
                $this->db->set('FTXpdPdtName', $paData['FTXpdPdtName']);
                $this->db->set('FCXpdFactor', $paData['FCXpdFactor']);
                $this->db->set('FTXpdVatType', $paData['FTXpdVatType']);
                $this->db->set('FTVatCode', $paData['FTVatCode']);
                $this->db->set('FCXpdVatRate', $paData['FCXpdVatRate']);
                $this->db->set('FCXpdQty', $paData['FCXpdQty']);
                $this->db->set('FCXpdQtyAll', $paData['FCXpdQtyAll']);
                $this->db->set('FCXpdSetPrice', $paData['FCXpdSetPrice']);
                $this->db->set('FCXpdAmtB4DisChg', $paData['FCXpdAmtB4DisChg']);
                $this->db->set('FCXpdNet', $paData['FCXpdNet']);
                $this->db->set('FCXpdNetAfHD', $paData['FCXpdNetAfHD']);
                $this->db->set('FCXpdVat', $paData['FCXpdVat']);
                $this->db->set('FCXpdVatable', $paData['FCXpdVatable']);
                $this->db->set('FCXpdCostIn', $paData['FCXpdCostIn']);
                $this->db->set('FCXpdCostEx', $paData['FCXpdCostEx']);
                $this->db->set('FTXpdRmk', $paData['FTXpdRmk']);

                $this->db->set('FDCreateOn', 'GETDATE()', false);
                $this->db->set('FTCreateBy', $paData['FTCreateBy']);
                $this->db->set('FDLastUpdOn', 'GETDATE()', false);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->insert('TAPTPcDT');
                
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add DT Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit DT.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }   
    }

    /**
     * Functionality : Data DT สำหรับใบลดหนี้ไม่มีสินค้า
     * Parameters : function parameters
     * Creator :  22/06/2019 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSaMCreditNoteGetDTNonePdt($paParams = []){
        $tDocNo = $paParams['tDocNo'];
        $tSQL   = " SELECT PCDT.* FROM [TAPTPcDT] PCDT WHERE PCDT.FTXphDocNo = '$tDocNo' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){ 
            $aItems = $oQuery->row_array();
        }else{ 
            $aItems = [];
        }
        return $aItems;
    }
    
    /**
     * Functionality : Function Add/Update TAPTPcHDSpl
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : Status Add/Update Master
     * Return Type : array
     */
    public function FSaMCreditNoteAddUpdatePCHDSpl($paData = []){
        
        try{
            // Update TAPTPcHDSpl
            $this->db->set('FTBchCode', $paData['FTBchCode']);
            $this->db->set('FTXphDstPaid', $paData['FTXphDstPaid']);
            $this->db->set('FNXphCrTerm', $paData['FNXphCrTerm']);
            $this->db->set('FDXphDueDate', $paData['FDXphDueDate']);
            $this->db->set('FDXphBillDue', $paData['FDXphBillDue']);
            $this->db->set('FTXphCtrName', $paData['FTXphCtrName']);
            $this->db->set('FDXphTnfDate', $paData['FDXphTnfDate']);
            $this->db->set('FTXphRefTnfID', $paData['FTXphRefTnfID']);
            $this->db->set('FTXphRefVehID', $paData['FTXphRefVehID']);
            $this->db->set('FTXphRefInvNo', $paData['FTXphRefInvNo']);
            $this->db->set('FTXphQtyAndTypeUnit', $paData['FTXphQtyAndTypeUnit']);
            $this->db->set('FNXphShipAdd', $paData['FNXphShipAdd']);
            $this->db->set('FNXphTaxAdd', $paData['FNXphTaxAdd']);

            $this->db->where('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->update('TAPTPcHDSpl');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update TAPTPcHDSpl Success',
                );
            }else{
                // Add TAPTPcHDSpl
                $this->db->insert('TAPTPcHDSpl',array(
                    
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTXphDocNo' => $paData['FTXphDocNo'],
                    'FTXphDstPaid' => $paData['FTXphDstPaid'],
                    'FNXphCrTerm' => $paData['FNXphCrTerm'],
                    'FDXphDueDate' => $paData['FDXphDueDate'],
                    'FDXphBillDue' => $paData['FDXphBillDue'],
                    'FTXphCtrName' => $paData['FTXphCtrName'],
                    'FDXphTnfDate' => $paData['FDXphTnfDate'],
                    'FTXphRefTnfID' => $paData['FTXphRefTnfID'],
                    'FTXphRefVehID' => $paData['FTXphRefVehID'],
                    'FTXphRefInvNo' => $paData['FTXphRefInvNo'],
                    'FTXphQtyAndTypeUnit' => $paData['FTXphQtyAndTypeUnit'],
                    'FNXphShipAdd' => $paData['FNXphShipAdd'],
                    'FNXphTaxAdd' => $paData['FNXphTaxAdd']

                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add TAPTPcHDSpl Success',
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
    
    /**
     * Functionality : Function Delete TCNTDocDTTmp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMClearPdtInTmp(){
        $tSQL = "DELETE FROM TCNTDocDTTmp WHERE FTSessionID = '" . $this->session->userdata('tSesSessionID') . "' AND FTXthDocKey = 'TAPTPcHD'";
        $this->db->query($tSQL);
    }
    
    /**
     * Functionality : Function Delete TCNTDocDTTmp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMClearDTDisTmp(){
        $tSQL = "DELETE FROM TCNTDocDTDisTmp WHERE FTSessionID = '" . $this->session->userdata('tSesSessionID') . "'";
        $this->db->query($tSQL);
    }
    
    /**
     * Functionality : Function Delete TCNTDocDTTmp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMClearHDDisTmp(){
        $tSQL = "DELETE FROM TCNTDocHDDisTmp WHERE FTSessionID = '" . $this->session->userdata('tSesSessionID') . "'";
        $this->db->query($tSQL);
    }

    /**
     * Functionality : Delete Inline From DT Temp
     * Parameters : function parameters
     * Creator : 25/06/2019 Piya
     * Last Modified : -
     * Return : Array Status Delete
     * Return Type : array
     */
    public function FSnMCreditNoteDelDTTmp($paData = []){
        try{
            $this->db->trans_begin();
            var_dump($paData);
            // $this->db->where_in('FTXthDocNo', $paData['tDocNo']);
            $this->db->where_in('FNXtdSeqNo', $paData['nSeqNo']);
            // $this->db->where_in('FTPdtCode',  $paData['tPdtCode']);
            $this->db->where_in('FTSessionID', $paData['tSessionID']);
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

    /**
     * Functionality : Multi Pdt Del Temp
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Return : Status Delete
     * Return Type : array
     */
    public function FSaMCreditNotePdtTmpMultiDel($paData = []){
        try{
            $this->db->trans_begin();

            // Del DTTmp
            $this->db->where('FTXthDocNo', $paData['tDocNo']);
            $this->db->where('FNXtdSeqNo', $paData['nSeqNo']);
            $this->db->where('FTXthDocKey', $paData['tDocKey']);
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


    public function FSnMCreditNoteGetDocType($ptTableName){

        $tSQL = "   SELECT
                        FNSdtDocType 
                    FROM TSysDocType 
                    WHERE FTSdtTblName='$ptTableName'
                ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $nDetail = $oDetail[0]->FNSdtDocType;
          
        }else{
            $nDetail = '';
        }

        return $nDetail;
       
    }
    
    public function FSxMCreditNoteClearDocTemForChngCdt($pInforData){
        $tSQL = "   DELETE FROM TCNTDocDTTmp 
                    WHERE FTBchCode = '".$pInforData["tbrachCode"]."' AND
                    FTXthDocNo = '".$pInforData["tFTXthDocNo"]."' AND
                    FTXthDocKey = '".$pInforData["tDockey"]."' AND
                    FTSessionID = '".$pInforData["tSession"]."'
                ";
        $this->db->query($tSQL);
    }
    
    /**
     * Functionality : ตรวจสอบเลขที่เอกสารว่ามีการใช้ไปแล้วหรือไม่
     * Parameters : function parameters
     * Creator : 28/0ุ/2019 Piya
     * Last Modified : -
     * Return : data
     * Return Type : Array
     */
    public function FSnMCreditNoteCheckDuplicate($ptCode){
        $tSQL = "   SELECT COUNT(FTXphDocNo)AS counts
                    FROM TAPTPcHD
                    WHERE FTXphDocNo = '$ptCode'
                ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
    
    /**
     * Functionality : Del Document by DocNo
     * Parameters : function parameters
     * Creator : 22/06/2019 Piya
     * Return : Status Delete
     * Return Type : array
     */
    public function FSaMCreditNoteDelMaster($paParams){
        try{
            $tDocNo = $paParams['tDocNo'];

            $this->db->where('FTXphDocNo', $tDocNo);
            $this->db->delete('TAPTPcHD');
            
            $this->db->where('FTXphDocNo', $tDocNo);
            $this->db->delete('TAPTPcDT');
            
            $this->db->where('FTXphDocNo', $tDocNo);
            $this->db->delete('TAPTPcHDDis');
            
            $this->db->where('FTXphDocNo', $tDocNo);
            $this->db->delete('TAPTPcDTDis');
            
            $this->db->where('FTXphDocNo', $tDocNo);
            $this->db->delete('TAPTPcHDSpl');
            
        }catch(Exception $Error){
            return $Error;
        }
    }    

    //ทุกครั้งที่เปลี่ยน SPL จะส่งผล ให้เกิดการคำนวณ VAT ใหม่
    public function FSaMCNChangeSPLAffectNewVAT($paData){
        $this->db->set('FTVatCode', $paData['FTVatCode']);
        $this->db->set('FCXtdVatRate', $paData['FCXtdVatRate']);
        $this->db->where('FTSessionID',$paData['tSessionID']);
        $this->db->where('FTXthDocKey',$paData['tDocKey']);
        $this->db->where('FTBchCode',$paData['tBCHCode']);
        $this->db->update('TCNTDocDTTmp');
    }

}




