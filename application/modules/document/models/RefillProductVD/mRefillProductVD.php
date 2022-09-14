<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mRefillProductVD extends CI_Model {

    //Data List
    public function FSaMRVDHDList($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];

        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTXthDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                BCHL.FTBchName,
                                TWS.FTBchCode,
                                TWS.FTXthDocNo,
                                CONVERT(CHAR(10),TWS.FDXthDocDate,103)   AS FDXthDocDate,
                                TWS.FTXthStaDoc,
                                TWS.FTXthStaApv,
                                TWS.FTXthStaPrcStk,
                                TWS.FTCreateBy,
                                TWS.FDCreateOn,
                                TWS.FTXthApvCode,
                                USRL.FTUsrName AS FTCreateByName,
                                USRLAPV.FTUsrName AS FTXthApvName
                            FROM [TCNTPdtTwsHD] TWS WITH (NOLOCK)
                            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON TWS.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRL WITH (NOLOCK) ON TWS.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON TWS.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID 
                            WHERE 1=1 ";

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND ((TWS.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TWS.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }

        if($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP'){
            $tBCH = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND  TWS.FTBchCode IN ($tBCH) ";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((TWS.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TWS.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((TWS.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TWS.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND TWS.FTXthStaDoc = '$tSearchStaDoc' OR TWS.FTXthStaDoc = ''";
            }else{
                $tSQL .= " AND TWS.FTXthStaDoc = '$tSearchStaDoc'";
            }
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND TWS.FTXthStaApv = '$tSearchStaApprove' OR TWS.FTXthStaApv = '' ";
            }else{
                $tSQL .= " AND TWS.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND TWS.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TWS.FTXthStaPrcStk = '' ";
            }else{
                $tSQL .= " AND TWS.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMRVDGetPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']);
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Count Page
    public function FSnMRVDGetPageAll($paData){
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT COUNT (TWS.FTXthDocNo) AS counts
                        FROM [TCNTPdtTwsHD] TWS WITH (NOLOCK) 
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON TWS.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                        WHERE 1=1 ";

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND ((TWS.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (TWS.FDXthDocDate LIKE '%$tSearchList%'))";
        }

        if($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP'){
            $tBCH = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND  TWS.FTBchCode IN ($tBCH) ";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((TWS.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TWS.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((TWS.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TWS.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            $tSQL .= " AND TWS.FTXthStaDoc = '$tSearchStaDoc'";
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND TWS.FTXthStaApv = '$tSearchStaApprove' OR TWS.FTXthStaApv = '' ";
            }else{
                $tSQL .= " AND TWS.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND TWS.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TWS.FTXthStaPrcStk = '' ";
            }else{
                $tSQL .= " AND TWS.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Clear Tmp
    public function FSxMRVDClearPdtInTmp(){
        $tSessionID     = $this->session->userdata('tSesSessionID');
        $aWhere = array('TCNTPdtTwsHD','TCNTPdtTwsDT','PDT_QTY','REFILLPDTSET-VD','TCNTPdtTwsHD_Wahouse','PDT_QTY_PRORATE');
        $this->db->where_in('FTXthDocKey', $aWhere);
        $this->db->where_in('FTSessionID',$tSessionID);
        $this->db->delete('TCNTDocDTTmp');
    }

    //ค้นหาข้อมูลตาม ID
    public function FSaMRVDDocumentByID($ptDocumentDocument){
        $nLngID     = $this->session->userdata("tLangEdit");
        $tDocument  = $ptDocumentDocument;
        $tSQL = "SELECT
                        HD.FTBchCode, HD.FTXthDocNo, HD.FDXthDocDate, HD.FTXthDocType,
                        HD.FTDptCode, HD.FTUsrCode, HD.FTXthApvCode, HD.FTXthShipWhTo,
                        HD.FTXthRefExt, HD.FDXthRefExtDate, HD.FTXthRefInt, HD.FDXthRefIntDate,
                        HD.FNXthDocPrint,  HD.FTXthRmk, HD.FTXthStaDoc, HD.FTXthStaApv,
                        HD.FTXthStaPrcStk, HD.FTXthStaDelMQ, HD.FNXthStaDocAct, HD.FNXthStaRef,
                        HD.FNXthStaClsSft, HD.FTRsnCode, HD.FTXthCtrName, HD.FDXthTnfDate,
                        HD.FTXthStaChkBal,
                        HD.FNXthShipAdd, HD.FTViaCode, HD.FDLastUpdOn, HD.FTLastUpdBy, HD.FDCreateOn, HD.FTCreateBy ,
                        USRL.FTUsrName, USRAPV.FTUsrName AS FTUsrNameApv,  WAHL.FTWahName AS FTWahName ,
                        USRKEY.FTUsrName AS NameKey ,SHPVIA.FTViaName AS FTViaName , BCHL.FTBchName , RSN.FTRsnName AS FTRsnName
                    FROM TCNTPdtTwsHD HD WITH (NOLOCK)
                    LEFT JOIN TCNMWaHouse_L    WAHL WITH (NOLOCK)   ON HD.FTBchCode = WAHL.FTBchCode AND HD.FTXthShipWhTo = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L     BCHL WITH (NOLOCK)   ON HD.FTBchCode   = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L       USRL WITH (NOLOCK)   ON HD.FTCreateBy   = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L       USRAPV WITH (NOLOCK) ON HD.FTXthApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L       USRKEY WITH (NOLOCK) ON HD.FTUsrCode = USRKEY.FTUsrCode AND USRKEY.FNLngID = $nLngID 
                    LEFT JOIN TCNMShipVia_L    SHPVIA WITH (NOLOCK) ON HD.FTViaCode = SHPVIA.FTViaCode AND SHPVIA.FNLngID = $nLngID 
                    LEFT JOIN TCNMRsn_L        RSN WITH (NOLOCK) ON HD.FTRsnCode = RSN.FTRsnCode AND RSN.FNLngID = $nLngID 
                    WHERE 1=1 AND HD.FTXthDocNo = '$tDocument' ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItems' => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Move DT To Temp
    public function FSaMRVDMoveDTToTemp($ptDocumentDocument){
        $nLngID = $this->session->userdata("tLangEdit");

        //ข้อมูลใบโอน
        //Insert ข้อมูล หลัก
        $tSQLHD     = " SELECT 
                        DISTINCT
                        HDBch.FTXthBchTo , 
                        HDBch.FTXthShopTo ,
                        HDBch.FTXthDocNo , 
                        HDBch.FTXthRefInt , 
                        LAY.FTMerCode ,
                        POS.FTPosCode
                        FROM TCNTPdtTwsHDBch HDBch 
                        INNER JOIN TCNMShop LAY ON HDBch.FTXthBchTo = LAY.FTBchCode AND HDBch.FTXthShopTo = LAY.FTShpCode
                        LEFT JOIN TVDMPosShop POS ON LAY.FTBchCode = POS.FTBchCode AND LAY.FTShpCode = POS.FTShpCode 
                        WHERE HDBch.FTXthDocNo = '$ptDocumentDocument' AND HDBch.FTXthStaTnf = 1 ";
        $oQuery     = $this->db->query($tSQLHD);
        $oListHD    = $oQuery->result_array();
        $nSeq       = 0;
        for($i=0; $i<FCNnHSizeOf($oListHD); $i++){
            $nSeq = $nSeq + 1;
            $tSQL = "INSERT INTO TCNTDocDTTmp ( 
                        FTBchCode,
                        FTXthDocNo,
                        FNXtdSeqNo,
                        FTXthDocKey,
                        FTMerCodeForADJPL,
                        FTShpCodeForADJPL,
                        FTPzeCodeForADJPL,
                        FTXthWhFrmForTWXVD,
                        FTSessionID
                    )VALUES(
                        '".$oListHD[$i]['FTXthBchTo']."',
                        '$ptDocumentDocument',
                        '".$nSeq."',
                        'TCNTPdtTwsHD',
                        '".$oListHD[$i]['FTMerCode']."',
                        '".$oListHD[$i]['FTXthShopTo']."',
                        '".$oListHD[$i]['FTPosCode']."',
                        '-',
                        '".$this->session->userdata('tSesSessionID')."'
                    ) ";
            $this->db->query($tSQL);
        }

        //Insert ข้อมูล Wahouse
        $tSQLWahSel = " SELECT 
                        HDBch.* , 
                        LAY.FTMerCode ,
                        POS.FTPosCode 
                        FROM TCNTPdtTwsHDBch HDBch 
                        INNER JOIN TCNMShop LAY ON HDBch.FTXthBchTo = LAY.FTBchCode AND HDBch.FTXthShopTo = LAY.FTShpCode
                        LEFT JOIN TVDMPosShop POS ON LAY.FTBchCode = POS.FTBchCode AND LAY.FTShpCode = POS.FTShpCode

                        WHERE HDBch.FTXthDocNo = '$ptDocumentDocument' AND HDBch.FTXthStaTnf = 1 ";
        $oQuery     = $this->db->query($tSQLWahSel);
        $oListWAH   = $oQuery->result_array();
        $nSeq       = 0;
        for($i=0; $i<FCNnHSizeOf($oListWAH); $i++){
            $nSeq       = $nSeq + 1;
            $tSQLWah    = "INSERT INTO TCNTDocDTTmp ( 
                                FTBchCode,
                                FTXthDocNo,
                                FNXtdSeqNo,
                                FTXthDocKey,
                                FTMerCodeForADJPL,
                                FTShpCodeForADJPL,
                                FTPzeCodeForADJPL,
                                FTXthWhFrmForTWXVD,
                                FTSessionID
                            )VALUES(
                                '".$oListWAH[$i]['FTXthBchTo']."',
                                '$ptDocumentDocument',
                                '".$nSeq."',
                                'TCNTPdtTwsHD_Wahouse',
                                '".$oListWAH[$i]['FTMerCode']."',
                                '".$oListWAH[$i]['FTXthShopTo']."',
                                '".$oListWAH[$i]['FTPosCode']."',
                                '".$oListWAH[$i]['FTXthWahFrm']."',
                                '".$this->session->userdata('tSesSessionID')."'
                            ) ";
            $this->db->query($tSQLWah);
        }

        //Insert ข้อมูล DT
        $tSQL  = "  SELECT DISTINCT FTBchCode , '' AS FTMerCodeForADJPL , '' AS FTShpCodeForADJPL FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                      AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                      AND TMP.FTXthDocNo = '$ptDocumentDocument'
                    UNION ALL
                    SELECT DISTINCT '' AS FTBchCode , FTMerCodeForADJPL , '' AS FTShpCodeForADJPL FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                      AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                      AND TMP.FTXthDocNo = '$ptDocumentDocument'
                    UNION ALL
                    SELECT DISTINCT '' AS FTBchCode , '' AS FTMerCodeForADJPL , FTShpCodeForADJPL FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                      AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                      AND TMP.FTXthDocNo = '$ptDocumentDocument' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();

            $tBCHCode = "";
            $tMERCode = "";
            $tSHPCode = "";
            for($i=0; $i<FCNnHSizeOf($oList); $i++){
                if($oList[$i]->FTBchCode != '' ||  $oList[$i]->FTBchCode != null){
                    $tBCHCode .= "'".$oList[$i]->FTBchCode."',";
                }

                if($oList[$i]->FTMerCodeForADJPL != '' ||  $oList[$i]->FTMerCodeForADJPL != null){
                    $tMERCode .= "'".$oList[$i]->FTMerCodeForADJPL."',";
                }

                if($oList[$i]->FTShpCodeForADJPL != '' ||  $oList[$i]->FTShpCodeForADJPL != null){
                    $tSHPCode .= "'".$oList[$i]->FTShpCodeForADJPL."',";
                }
                
                if($i == FCNnHSizeOf($oList) - 1){
                    $tBCHCode = substr($tBCHCode,0,-2);
                    $tBCHCode .= "'";

                    $tMERCode = substr($tMERCode,0,-2);
                    $tMERCode .= "'";

                    $tSHPCode = substr($tSHPCode,0,-2);
                    $tSHPCode .= "'";
                }
            }

            $tSQLInsert  = "INSERT INTO TCNTDocDTTmp(
                                FTBchCode,
                                FTShpCodeForADJPL,
                                FTXthDocNo,
                                FNXtdSeqNo,
                                FTXthDocKey,
                                FTPdtCode,
                                FTXtdPdtName,
                                --จำนวนเติมสูงสุด
                                FCLayColQtyMaxForTWXVD,
                                --ยอดเหลือใน VD
                                FCXtdAmt,
                                --ยอดเหลือใน STK WAHOUSE
                                FCXtdQty,
                                --จำนวนเติมสำรอง
                                FCStkQty,
                                FTSessionID,
                                --คลัง
                                FTXthWhFrmForTWXVD
                            )";
            $tSQLInsert  .= "SELECT 
                            FULLRVD.FTBchCode               AS FTBchCode,
                            FULLRVD.FTShpCode               AS FTShpCode,
                            FULLRVD.FTXthDocNo              AS FTXthDocNo,
                            row_number () OVER (ORDER BY FULLRVD.FTPdtCode) AS FNXtdSeqNo,
                            FULLRVD.FTXthDocKey             AS FTXthDocKey,
                            FULLRVD.FTPdtCode               AS FTPdtCode,
                            FULLRVD.FTXtdPdtName            AS FTXtdPdtName,
                            SUM(FULLRVD.FCLayColQtyMaxForTWXVD)  AS FCLayColQtyMaxForTWXVD,
                            FULLRVD.FCXtdAmt                AS FCXtdAmt,
                            SUM(FCXtdQty)                   AS FCXtdQty ,
                            FULLRVD.FCStkQty                AS FCStkQty,
                            FULLRVD.FTSessionID             AS FTSessionID,
                            '-'                             AS FTXthWhFrmForTWXVD
                            FROM (";
            $tSQLInsert  .= "SELECT 
                            REFILL.FTBchCode AS FTBchCode ,
                            REFILL.FTShpCode AS FTShpCode ,
                            '$ptDocumentDocument' AS FTXthDocNo ,
                            'TCNTPdtTwsDT' AS FTXthDocKey , 
                            REFILL.FTPdtCode , 
                            REFILL.FTPdtName AS FTXtdPdtName ,
                            --จำนวนเติมสูงสุด
                            SUM(REFILL.FCLayColQtyMax) AS FCLayColQtyMaxForTWXVD , 
                            --ยอดเหลือใน VD
                            SUM(REFILL.FCStkQty) AS FCXtdAmt ,  
                            --ยอดเหลือใน STK WAHOUSE
                            ISNULL(BAL.FCStkQty,0) AS FCXtdQty ,
                            --จำนวนเติมสำรอง
                            0 AS FCStkQty , 
                            '".$this->session->userdata('tSesSessionID')."' AS FTSessionID ,
                            REFILL.WahShop AS FTXthWhFrmForTWXVD
                        FROM (
                            SELECT 
                                PDT.FTBchCode , 
                                PDT.FTShpCode , 
                                PDT.FNLayRow , 
                                PDT.FNLayCol , 
                                PDT.FTPdtCode , 
                                PDTL.FTPdtName , 
                                PDT.FTWahCode AS WahShop , 
                                FCLayColQtyMax * CountPOS.CountPOS AS FCLayColQtyMax ,
                                ISNULL(STKBal.FCStkQty,0) AS FCStkQty
                            FROM TVDMPdtLayout PDT
                        INNER JOIN TCNMPdt_L 	PDTL 		ON PDTL.FTPdtCode = PDT.FTPdtCode AND PDTL.FNLngID = '$nLngID'
                        
                        -- หาจำนวนคงเหลือ
                        LEFT JOIN (
                                SELECT SUM(FCSTKQty) AS FCSTKQty , FNLayRow , FNLayCol , FTPdtCode FROM TVDTPdtStkBal WHERE 
                                FTWahCode IN (
                                        SELECT WAH.FTWahCode FROM TVDMPosShop POS 
                                        LEFT JOIN TCNMWaHouse WAH ON POS.FTBchCode = WAH.FTBchCode AND POS.FTPosCode = WAH.FTWahRefCode AND WAH.FTWahStaType = '6'
                                        WHERE  POS.FTShpCode IN($tSHPCode) AND POS.FTBchCode IN($tBCHCode)
                                ) 
                                GROUP BY FNLayRow , FNLayCol , FTPdtCode , FNCabSeq
                        ) AS STKBAL ON PDT.FNLayRow = STKBAL.FNLayRow AND PDT.FNLayCol = STKBAL.FNLayCol AND PDT.FTPdtCode = STKBAL.FTPdtCode    
                        
                        --  หาจำนวนต่อ POS
                        LEFT JOIN (
                                SELECT COUNT(FTShpCode) AS CountPOS , FTShpCode  FROM TVDMPosShop 
                                WHERE FTShpCode IN($tSHPCode) AND FTBchCode IN($tBCHCode)
                                GROUP BY FTShpCode
                        ) AS CountPOS ON PDT.FTShpCode = COUNTPOS.FTShpCode
                            
                        WHERE PDT.FTBchCode IN($tBCHCode) ";

            if( strlen($tMERCode) > 1 ){
                $tSQLInsert  .= " AND PDT.FTMerCode IN($tMERCode) ";
            }

            $tSQLInsert  .= " AND PDT.FTShpCode IN($tSHPCode) AND PDT.FTPdtCode != ''
                    ) AS REFILL
                    LEFT JOIN TCNTPdtStkBal BAL ON BAL.FTWahCode = REFILL.WahShop AND BAL.FTPdtCode = REFILL.FTPdtCode AND BAL.FTBchCode = REFILL.FTBchCode
                    --จำนวน 0 ไม่ต้องเติม
                    GROUP BY REFILL.FTPdtCode ,  REFILL.FTShpCode , REFILL.FTPdtName , REFILL.FTBchCode , BAL.FCStkQty , REFILL.WahShop";
            $tSQLInsert  .= " ) AS FULLRVD
                        GROUP BY 
                            FULLRVD.FTBchCode,
                            FULLRVD.FTShpCode,
                            FULLRVD.FTXthDocNo,
                            FULLRVD.FTXthDocKey,
                            FULLRVD.FTPdtCode,
                            FULLRVD.FTXtdPdtName,
                            FULLRVD.FCLayColQtyMaxForTWXVD,
                            FULLRVD.FCStkQty,
                            FULLRVD.FCXtdAmt,
                            FULLRVD.FTSessionID ORDER BY FULLRVD.FTPdtCode ASC ";
            $this->db->query($tSQLInsert);
            // echo $this->db->last_query();exit;
        }

        //Insert ข้อมูล DTPos Prorate
        $tSQLDTPosSel = " SELECT DTPos.* 
                        FROM TCNTPdtTwsDTPos DTPos 
                        WHERE DTPos.FTXthDocNo = '$ptDocumentDocument' ";
        $oQuery     = $this->db->query($tSQLDTPosSel);
        $oListDTPos = $oQuery->result_array();
        $nSeq       = 0;
        for($i=0; $i<FCNnHSizeOf($oListDTPos); $i++){
            $nSeq           = $nSeq + 1;
            $tSQLProrate    = "INSERT INTO TCNTDocDTTmp ( 
                                FTBchCode,
                                FTXthDocNo,
                                FTPdtCode,
                                FNXtdSeqNo,
                                FCXtdQty,
                                FNCabSeqForTWXVD,
                                FNLayRowForTWXVD,
                                FNLayColForTWXVD,
                                FTPzeCodeForADJPL,
                                FTXthDocKey,
                                FTSessionID
                            )VALUES(
                                '".$oListDTPos[$i]['FTBchCode']."',
                                '$ptDocumentDocument',
                                '".$oListDTPos[$i]['FTPdtCode']."',
                                '".$nSeq."',
                                '".$oListDTPos[$i]['FCXtdQty']."',
                                '".$oListDTPos[$i]['FNCabSeq']."',
                                '".$oListDTPos[$i]['FNLayRow']."',
                                '".$oListDTPos[$i]['FNLayCol']."',
                                '".$oListDTPos[$i]['FTPosCode']."',
                                'PDT_QTY_PRORATE',
                                '".$this->session->userdata('tSesSessionID')."'
                            ) ";
            $this->db->query($tSQLProrate);
        }
    }

    //-------------------------------------------------------------------------------------------------------//

    //โหลดข้อมูลของ STEP1
    public function FSaMRVDDTListStep1($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $nLngID             = $paData['FNLngID'];
        $tSQL               = "SELECT 
                                    TMP.FTBchCode,
                                    TMP.FTXthDocNo,
                                    TMP.FNXtdSeqNo,
                                    TMP.FTXthDocKey,
                                    TMP.FTMerCodeForADJPL,
                                    TMP.FTShpCodeForADJPL,
                                    TMP.FTPzeCodeForADJPL,
                                    TMP.FTSessionID,
                                    BCH.FTBchName,
                                    SHP.FTShpName,
                                    POS.FTPosName
                            FROM TCNTDocDTTmp TMP
                            INNER JOIN TCNMBranch_L BCH ON TMP.FTBchCode = BCH.FTBchCode 
                            INNER JOIN TCNMShop_L SHP ON TMP.FTBchCode = SHP.FTBchCode AND TMP.FTShpCodeForADJPL = SHP.FTShpCode AND SHP.FNLngID = $nLngID
                            INNER JOIN TCNMPos_L POS ON TMP.FTBchCode = POS.FTBchCode AND POS.FTPosCode = TMP.FTPzeCodeForADJPL  AND POS.FNLngID = $nLngID ";
        $tSQL .= " WHERE FTSessionID = '".$this->session->userdata('tSesSessionID')."' ";
        $tSQL .= " AND FTXthDocKey = 'TCNTPdtTwsHD' ";
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tSQL .= " AND FTXthDocNo = 'REFILLPDTSET-VD' ";
        }else{
            $tSQL .= " AND FTXthDocNo = '$tDocumentNumber' ";
        }

        $tSQL .= " ORDER BY TMP.FTShpCodeForADJPL";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Find Step1 - มองระดับ POS
    public function FSaMRVDFindStep1($paData){
        $tBCHCode = $paData['tBCHCode'];
        $tMERCode = $paData['tMERCode'];
        $tSHPCode = $paData['tSHPCode'];
        $tPOSCode = $paData['tPOSCode'];
        $tSQL = " SELECT DISTINCT LAY.FTBchCode , LAY.FTMerCode , LAY.FTShpCode , POS.FTPosCode , '' AS FTWahCode  FROM TVDMPdtLayout LAY ";
        $tSQL .= " LEFT JOIN TVDMPosShop POS ON LAY.FTBchCode = POS.FTBchCode AND LAY.FTShpCode = POS.FTShpCode ";
        $tSQL .= " LEFT JOIN TCNMWaHouse WAH ON LAY.FTBchCode = WAH.FTBchCode AND POS.FTPosCode = WAH.FTWahRefCode AND FTWahStaType IN (6) ";
        $tSQL .= " WHERE ISNULL(FTPosCode,'') != '' AND LAY.FTPdtCode != '' ";
        if($tBCHCode != '' || $tBCHCode != null){
            $tSQL .= " AND LAY.FTBchCode = '$tBCHCode' ";
        }

        if($tMERCode != '' || $tMERCode != null){
            $tSQL .= " AND LAY.FTMerCode = '$tMERCode' ";
        }

        if($tSHPCode != '' || $tSHPCode != null){
            $tSQL .= " AND LAY.FTShpCode = '$tSHPCode' ";
        }

        if($tPOSCode != '' || $tPOSCode != null){
            $tSQL .= " AND POS.FTPosCode = '$tPOSCode' ";
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        return $aResult;
    }

    //Find Step1 - มองระดับ Wahouse
    public function FSaMRVDFindStep1_Wahouse($paData){
        $tBCHCode = $paData['tBCHCode'];
        $tMERCode = $paData['tMERCode'];
        $tSHPCode = $paData['tSHPCode'];
        $tPOSCode = $paData['tPOSCode'];
        $tSQL = " SELECT DISTINCT LAY.FTBchCode , LAY.FTMerCode , LAY.FTShpCode , POS.FTPosCode , LAY.FTWahCode FROM TVDMPdtLayout LAY ";
        $tSQL .= " LEFT JOIN TVDMPosShop POS ON LAY.FTBchCode = POS.FTBchCode AND LAY.FTShpCode = POS.FTShpCode ";
        $tSQL .= " LEFT JOIN TCNMWaHouse WAH ON LAY.FTBchCode = WAH.FTBchCode AND POS.FTPosCode = WAH.FTWahRefCode AND FTWahStaType IN (6) ";
        $tSQL .= " WHERE ISNULL(FTPosCode,'') != '' AND LAY.FTPdtCode != '' ";
        if($tBCHCode != '' || $tBCHCode != null){
            $tSQL .= " AND LAY.FTBchCode = '$tBCHCode' ";
        }

        if($tMERCode != '' || $tMERCode != null){
            $tSQL .= " AND LAY.FTMerCode = '$tMERCode' ";
        }

        if($tSHPCode != '' || $tSHPCode != null){
            $tSQL .= " AND LAY.FTShpCode = '$tSHPCode' ";
        }

        if($tPOSCode != '' || $tPOSCode != null){
            $tSQL .= " AND POS.FTPosCode = '$tPOSCode' ";
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        return $aResult;
    }

    //Insert Step1 - มองระดับ POS
    public function FSaMRVDInsertStep1($paData,$nKey,$tDocumentNumber){
        $tBCHCode = $paData->FTBchCode;
        $tMERCode = $paData->FTMerCode;
        $tSHPCode = $paData->FTShpCode;
        $tPOSCode = $paData->FTPosCode;
        $tWahCode = $paData->FTWahCode;
        $nSeqNo   = $nKey;

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $tDocumentNumber;
        }

        //ถ้าเป็นตัวเเรก จะต้องลบ
        if($nKey == 1){
            $aWhere = array('TCNTPdtTwsHD','TCNTPdtTwsDT','PDT_QTY','TCNTPdtTwsHD_Wahouse');
            $this->db->where_in('FTBchCode',  $tBCHCode);
            $this->db->where_in('FTXthDocKey', $aWhere);
            $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
            $this->db->delete('TCNTDocDTTmp');
        }

        //เพิ่มข้อมูลลง Temp มองตาม POS
        $tSQL   = " INSERT INTO TCNTDocDTTmp(
                        FTBchCode,
                        FTXthDocNo,
                        FNXtdSeqNo,
                        FTXthDocKey,
                        FTMerCodeForADJPL,
                        FTShpCodeForADJPL,
                        FTPzeCodeForADJPL,
                        FTXthWhFrmForTWXVD,
                        FTSessionID
                    )VALUES(
                        '".$tBCHCode."',
                        '$tDocumentNumber',
                        '".$nSeqNo."',
                        'TCNTPdtTwsHD',
                        '".$tMERCode."',
                        '".$tSHPCode."',
                        '".$tPOSCode."',
                        '-',
                        '".$this->session->userdata('tSesSessionID')."'
                    )";    
        $this->db->query($tSQL);

        //เพิ่มข้อมูลลง Temp มองตาม WAH
        // $tSQLWah   = " INSERT INTO TCNTDocDTTmp(
        //                 FTBchCode,
        //                 FTXthDocNo,
        //                 FNXtdSeqNo,
        //                 FTXthDocKey,
        //                 FTMerCodeForADJPL,
        //                 FTShpCodeForADJPL,
        //                 FTPzeCodeForADJPL,
        //                 FTXthWhFrmForTWXVD,
        //                 FTSessionID
        //             )VALUES(
        //                 '".$tBCHCode."',
        //                 '$tDocumentNumber',
        //                 '".$nSeqNo."',
        //                 'TCNTPdtTwsHD_Wahouse',
        //                 '".$tMERCode."',
        //                 '".$tSHPCode."',
        //                 '".$tPOSCode."',
        //                 '".$tWahCode."',
        //                 '".$this->session->userdata('tSesSessionID')."'
        //             )";    
        // $this->db->query($tSQLWah);
    }

    //Insert Step1 - มองระดับ Wahouse
    public function FSaMRVDInsertStep1_Wahouse($paData,$nKey,$tDocumentNumber){
        $tBCHCode = $paData->FTBchCode;
        $tMERCode = $paData->FTMerCode;
        $tSHPCode = $paData->FTShpCode;
        $tPOSCode = $paData->FTPosCode;
        $tWahCode = $paData->FTWahCode;
        $nSeqNo   = $nKey;

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $tDocumentNumber;
        }

        //เพิ่มข้อมูลลง Temp มองตาม WAH
        $tSQLWah   = " INSERT INTO TCNTDocDTTmp(
                        FTBchCode,
                        FTXthDocNo,
                        FNXtdSeqNo,
                        FTXthDocKey,
                        FTMerCodeForADJPL,
                        FTShpCodeForADJPL,
                        FTPzeCodeForADJPL,
                        FTXthWhFrmForTWXVD,
                        FTSessionID
                    )VALUES(
                        '".$tBCHCode."',
                        '$tDocumentNumber',
                        '".$nSeqNo."',
                        'TCNTPdtTwsHD_Wahouse',
                        '".$tMERCode."',
                        '".$tSHPCode."',
                        '".$tPOSCode."',
                        '".$tWahCode."',
                        '".$this->session->userdata('tSesSessionID')."'
                    )";    
        $this->db->query($tSQLWah);
    }

    //Delete Step1
    public function FSaMRVDDeleteRecordStep1($paData){
        $tDocumentNumber       = $paData['tDocumentNumber'];
        $nSeq                  = $paData['nSeq'];
        $tBCHCode              = $paData['tBCHCode'];

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $this->db->where_in('FTXthDocNo','REFILLPDTSET-VD');
        }else{
            $this->db->where_in('FTXthDocNo',$tDocumentNumber);
        }
        $this->db->where_in('FTBchCode',$tBCHCode);
        $this->db->where_in('FNXtdSeqNo',$nSeq);
        $this->db->where_in('FTXthDocKey','TCNTPdtTwsHD');
        $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
        $this->db->delete('TCNTDocDTTmp');

        //เรียง seq ใหม่ กรณีลบข้อมูลทิ้ง
        $tSQL = "UPDATE TCNTDocDTTmp WITH(ROWLOCK)
                    SET FNXtdSeqNo = x.NewSeq 
                FROM TCNTDocDTTmp DT 
                INNER JOIN (
                SELECT 
                    ROW_NUMBER() OVER (ORDER BY FNXtdSeqNo) AS NewSeq,
                    FNXtdSeqNo AS FNXtdSeqNo_x
                FROM TCNTDocDTTmp AS y
                ) x
                ON DT.FNXtdSeqNo = x.FNXtdSeqNo_x
                WHERE FTBchCode = '$tBCHCode' AND FTXthDocKey = 'TCNTPdtTwsHD' AND FTSessionID = '".$this->session->userdata('tSesSessionID')."' ";
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tSQL .= " AND FTXthDocNo = 'REFILLPDTSET-VD' ";
        }else{
            $tSQL .= " AND FTXthDocNo = '$tDocumentNumber' ";
        }     
        $this->db->query($tSQL);
    }

    //-------------------------------------------------------------------------------------------------------//

    //โหลดข้อมูลของ STEP2
    public function FSaMRVDDTListStep2($paData){
        $tDocumentNumber        = $paData['tDocumentNumber'];
        $nLngID                 = $paData['FNLngID'];
        $tTypepage              = $paData['tTypepage'];
        $tTypeClickPDT          = $paData['tTypeClickPDT'];
        $tTypeFlagCheckSTKBal   = $paData['tTypeFlagCheckSTKBal']; 

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $tDocumentNumber;
        }

        $tWhere = " WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                    AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                    AND TMP.FTXthDocNo = '$tDocumentNumber' 
                  ";
        $tSQL  = "  SELECT DISTINCT FTBchCode , '' AS FTMerCodeForADJPL , '' AS FTShpCodeForADJPL , '' AS FTPzeCodeForADJPL FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    $tWhere
                    UNION ALL
                    SELECT DISTINCT '' AS FTBchCode , FTMerCodeForADJPL , '' AS FTShpCodeForADJPL , '' AS FTPzeCodeForADJPL FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    $tWhere
                    UNION ALL
                    SELECT DISTINCT '' AS FTBchCode , '' AS FTMerCodeForADJPL , FTShpCodeForADJPL , '' AS FTPzeCodeForADJPL FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    $tWhere
                    UNION ALL
                    SELECT DISTINCT '' AS FTBchCode, '' AS FTMerCodeForADJPL, '' AS FTShpCodeForADJPL , FTPzeCodeForADJPL FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    $tWhere
                  ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();

            $tBCHCode = "";
            $tMERCode = "";
            $tSHPCode = "";
            $tPosCode = "";
            for($i=0; $i<FCNnHSizeOf($oList); $i++){
                if($oList[$i]->FTBchCode != '' ||  $oList[$i]->FTBchCode != null){
                    $tBCHCode .= "'".$oList[$i]->FTBchCode."',";
                }
                // echo "<pre>";
                // echo var_dump($oList[$i]->FTMerCodeForADJPL)."<br>";
                if($oList[$i]->FTMerCodeForADJPL != '' ||  $oList[$i]->FTMerCodeForADJPL != null){
                    $tMERCode .= "'".$oList[$i]->FTMerCodeForADJPL."',";
                }

                if($oList[$i]->FTShpCodeForADJPL != '' ||  $oList[$i]->FTShpCodeForADJPL != null){
                    $tSHPCode .= "'".$oList[$i]->FTShpCodeForADJPL."',";
                }

                if($oList[$i]->FTPzeCodeForADJPL != '' ||  $oList[$i]->FTPzeCodeForADJPL != null){
                    $tPosCode .= "'".$oList[$i]->FTPzeCodeForADJPL."',";
                }
                
                if($i == FCNnHSizeOf($oList) - 1){
                    $tBCHCode = substr($tBCHCode,0,-2);
                    $tBCHCode .= "'";

                    $tMERCode = substr($tMERCode,0,-2);
                    $tMERCode .= "'";

                    $tSHPCode = substr($tSHPCode,0,-2);
                    $tSHPCode .= "'";

                    $tPosCode = substr($tPosCode,0,-2);
                    $tPosCode .= "'";
                }
                // echo var_dump($tMERCode)."<br>";
            }

            //Delete ก่อน
            $this->db->where_in('FTXthDocKey','TCNTPdtTwsDT');
            $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
            $this->db->delete('TCNTDocDTTmp');
            
            $tSQLInsert  = "INSERT INTO TCNTDocDTTmp(
                        FTBchCode,
                        FTShpCodeForADJPL,
                        FTXthDocNo,
                        FNXtdSeqNo,
                        FTXthDocKey,
                        FTPdtCode,
                        FTXtdPdtName,
                        /*จำนวนเติมสูงสุด*/
                        FCLayColQtyMaxForTWXVD,
                        /*ยอดเหลือใน VD*/
                        FCXtdAmt,
                        /*ยอดเหลือใน STK WAHOUSE*/
                        FCXtdQty,
                        /*จำนวนเติมสำรอง*/
                        FCStkQty,
                        FTSessionID,
                        /*คลัง*/
                        FTXthWhFrmForTWXVD
                    )";


            $tSQLInsert  .= "SELECT 
                            FULLRVD.FTBchCode               AS FTBchCode,
                            FULLRVD.FTShpCode               AS FTShpCode,
                            FULLRVD.FTXthDocNo              AS FTXthDocNo,
                            row_number () OVER (ORDER BY FULLRVD.FTPdtCode) AS FNXtdSeqNo,
                            FULLRVD.FTXthDocKey             AS FTXthDocKey,
                            FULLRVD.FTPdtCode               AS FTPdtCode,
                            FULLRVD.FTXtdPdtName            AS FTXtdPdtName,
                            SUM(FULLRVD.FCLayColQtyMaxForTWXVD)  AS FCLayColQtyMaxForTWXVD,
                            FULLRVD.FCXtdAmt                AS FCXtdAmt,
                            SUM(FCXtdQty)                   AS FCXtdQty ,
                            FULLRVD.FCStkQty                AS FCStkQty,
                            FULLRVD.FTSessionID             AS FTSessionID,
                            '-'                             AS FTXthWhFrmForTWXVD
                            FROM (";
            $tSQLInsert  .= "SELECT 
                                REFILL.FTBchCode AS FTBchCode ,
                                REFILL.FTShpCode AS FTShpCode ,
                                '$tDocumentNumber' AS FTXthDocNo ,
                                'TCNTPdtTwsDT' AS FTXthDocKey , 
                                REFILL.FTPdtCode , 
                                REFILL.FTPdtName AS FTXtdPdtName ,
                                /*จำนวนเติมสูงสุด*/
                                SUM(REFILL.FCLayColQtyMax) AS FCLayColQtyMaxForTWXVD , 
                                /*ยอดเหลือใน VD*/
                                SUM(REFILL.FCStkQty) AS FCXtdAmt ,  
                                /*ยอดเหลือใน STK WAHOUSE*/
                                ISNULL(BAL.FCStkQty,0) AS FCXtdQty ,
                                /*จำนวนเติมสำรอง*/
                                0 AS FCStkQty , 
                                '".$this->session->userdata('tSesSessionID')."' AS FTSessionID ,
                                REFILL.WahShop AS FTXthWhFrmForTWXVD
                            FROM (
                                SELECT 
                                    PDT.FTBchCode , 
                                    PDT.FTShpCode , 
                                    PDT.FNLayRow , 
                                    PDT.FNLayCol , 
                                    PDT.FTPdtCode , 
                                    PDTL.FTPdtName , 
                                    PDT.FTWahCode AS WahShop , 
                                    FCLayColQtyMax * CountPOS.CountPOS AS FCLayColQtyMax ,
                                    ISNULL(STKBal.FCStkQty,0) AS FCStkQty
                                FROM TVDMPdtLayout PDT
                                INNER JOIN TCNMPdt_L 	PDTL 		ON PDTL.FTPdtCode = PDT.FTPdtCode AND PDTL.FNLngID = '$nLngID'
                                
                                /*หาจำนวนคงเหลือ*/
                                LEFT JOIN (
                                        SELECT SUM(FCSTKQty) AS FCSTKQty , FNLayRow , FNLayCol , FTPdtCode FROM TVDTPdtStkBal WHERE 
                                        FTWahCode IN (
                                                SELECT WAH.FTWahCode FROM TVDMPosShop POS 
                                                LEFT JOIN TCNMWaHouse WAH ON POS.FTBchCode = WAH.FTBchCode AND POS.FTPosCode = WAH.FTWahRefCode AND WAH.FTWahStaType = '6'
                                                WHERE  POS.FTShpCode IN($tSHPCode) AND POS.FTBchCode IN($tBCHCode) AND POS.FTPosCode IN($tPosCode)
                                        ) 
                                        GROUP BY FNLayRow , FNLayCol , FTPdtCode , FNCabSeq
                                ) AS STKBAL ON PDT.FNLayRow = STKBAL.FNLayRow AND PDT.FNLayCol = STKBAL.FNLayCol AND PDT.FTPdtCode = STKBAL.FTPdtCode    
                                
                                /*หาจำนวนต่อ POS*/
                                LEFT JOIN (
                                        SELECT COUNT(FTShpCode) AS CountPOS , FTShpCode  FROM TVDMPosShop 
                                        WHERE FTShpCode IN($tSHPCode) AND FTBchCode IN($tBCHCode) AND FTPosCode IN($tPosCode)
                                        GROUP BY FTShpCode
                                ) AS CountPOS ON PDT.FTShpCode = COUNTPOS.FTShpCode
                                    
                                WHERE PDT.FTBchCode IN($tBCHCode) 
            ";

            if( strlen($tMERCode) > 1 ){
                $tSQLInsert  .= "   AND PDT.FTMerCode IN($tMERCode) ";
            }

            $tSQLInsert  .= "   AND PDT.FTShpCode IN($tSHPCode) 
                                AND PDT.FTPdtCode != ''
                            ) AS REFILL
                            LEFT JOIN TCNTPdtStkBal BAL ON BAL.FTWahCode = REFILL.WahShop AND BAL.FTPdtCode = REFILL.FTPdtCode AND BAL.FTBchCode = REFILL.FTBchCode
                            /*จำนวน 0 ไม่ต้องเติม*/
                            GROUP BY REFILL.FTPdtCode ,  REFILL.FTShpCode , REFILL.FTPdtName , REFILL.FTBchCode , BAL.FCStkQty , REFILL.WahShop ";
            $tSQLInsert  .= " ) AS FULLRVD
                        GROUP BY 
                            FULLRVD.FTBchCode,
                            FULLRVD.FTShpCode,
                            FULLRVD.FTXthDocNo,
                            FULLRVD.FTXthDocKey,
                            FULLRVD.FTPdtCode,
                            FULLRVD.FTXtdPdtName,
                            FULLRVD.FCLayColQtyMaxForTWXVD,
                            FULLRVD.FCStkQty,
                            FULLRVD.FCXtdAmt,
                            FULLRVD.FTSessionID ORDER BY FULLRVD.FTPdtCode ASC ";
            $this->db->query($tSQLInsert);
            // echo $tSQLInsert;exit;

            //เข้ามาแบบแก้ไข และยังไม่มีการเปลี่ยนแปลงสินค้า จะต้องเอาใน Temp Join กับ DT
            if($tTypepage == 'PAGEEDIT' && $tTypeClickPDT == 0){
                $this->FSaMRVDDTShowOnlyDTAndTemp($paData);
            }

            //Select
            $tSQLSelete     = "SELECT
                                    TMP.FTBchCode,
                                    TMP.FTXthDocNo,
                                    TMP.FNXtdSeqNo,
                                    TMP.FTXthDocKey,
                                    TMP.FTPdtCode,
                                    TMP.FTXtdPdtName,
                                    --จำนวนเติมสูงสุด
                                    TMP.FCLayColQtyMaxForTWXVD,
                                    --ยอดเหลือใน VD
                                    TMP.FCXtdAmt,
                                    --ยอดเหลือใน STK WAHOUSE
                                    TMP.FCXtdQty,
                                    --จำนวนเติมสำรอง
                                    TMP.FCStkQty,
                                    TMP.FTSessionID
                                FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                                WHERE TMP.FTXthDocKey = 'TCNTPdtTwsDT'
                                  AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."' ";
            $tSQLSelete      .= " AND TMP.FTXthDocNo = '$tDocumentNumber' ";
            $oQuerySelete    = $this->db->query($tSQLSelete);
            // echo $this->db->last_query();
            $oListResult     = $oQuerySelete->result();
            if($oQuerySelete->num_rows() > 0){
                $aResult = array(
                    'raItems'       => $oListResult,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
            }else{
                $aResult = array(
                    'raItems'       => '',
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found'
                );
            }
        }else{
            $aResult = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //โชว์เฉพาะสินค้าที่เอามาใน DT 
    public function FSaMRVDDTShowOnlyDTAndTemp($paData){
        $tDocumentNumber        = $paData['tDocumentNumber'];
        $nLngID                 = $paData['FNLngID'];
        $tTypepage              = $paData['tTypepage'];

        //อัพเดทจำนวนเติมสำรองกรณีเข้ามาเป็นแบบแก้ไข
        $tSQLUpdate = "UPDATE
                            TCNTDocDTTmp
                        SET
                            TCNTDocDTTmp.FCStkQty = TCNTPdtTwsDT.FCXtdQtySpc
                        FROM
                            TCNTDocDTTmp AS TCNTDocDTTmp
                            INNER JOIN TCNTPdtTwsDT AS TCNTPdtTwsDT ON TCNTDocDTTmp.FTXthDocNo = TCNTPdtTwsDT.FTXthDocNo 
                            AND TCNTDocDTTmp.FTPdtCode = TCNTPdtTwsDT.FTPdtCode
                        WHERE
                            TCNTDocDTTmp.FTXthDocNo = '$tDocumentNumber' ";
        $this->db->query($tSQLUpdate);

        //ลบข้อมูลสินค้าที่ไม่ถูกต้อง เอาเฉพาะใน DT
        $tSQLDelete = "DELETE FROM TCNTDocDTTmp
                        WHERE FTPdtCode NOT IN 
                        ( SELECT FTPdtCode FROM TCNTPdtTwsDT WHERE FTXthDocNo = '$tDocumentNumber' ) ";
        $this->db->query($tSQLDelete);

        //ถ้าเอกสารอนุมัติเเล้ว จะโชว์ จำนวนเติมเท่ากับ DT ของเอกสารใบเติม
        $tSQL           = "SELECT FTXthStaApv , HDBch.FTXthRefInt FROM TCNTPdtTwsHD HD 
                            LEFT JOIN TCNTPdtTwsHDBch HDBch ON HDBch.FTXthDocNo = HD.FTXthDocNo AND HDBch.FTXthStaTnf = 2
                            WHERE HD.FTXthDocNo = '$tDocumentNumber' ";
        $oQuery         = $this->db->query($tSQL);
        $oListResult    = $oQuery->result_array();
        if($oListResult[0]['FTXthStaApv'] == 1){
            $tTextTwxTopup = '';
            for($i=0; $i<FCNnHSizeOf($oListResult); $i++){
                $tTextTwxTopup .= "'".$oListResult[$i]['FTXthRefInt']."'" . ',';
                if($i == FCNnHSizeOf($oListResult)-1){
                    $tTextTwxTopup = substr($tTextTwxTopup,0,-1);
                }
            }

            $tSession   = $this->session->userdata('tSesSessionID');
            $tSQLUpdate = " UPDATE
                                TCNTDocDTTmp
                            SET
                                TCNTDocDTTmp.FCXtdQty = DT.FCXtdQty
                            FROM
                                TCNTDocDTTmp AS TCNTDocDTTmp
                                INNER JOIN (
                                    SELECT SUM(FCXtdQty) AS FCXtdQty , FTPdtCode from TVDTPdtTwxDT 
                                    WHERE FTXthDocNo IN ($tTextTwxTopup)
                                    GROUP BY FTPdtCode
                                ) DT ON TCNTDocDTTmp.FTPdtCode = DT.FTPdtCode
                            WHERE
                                TCNTDocDTTmp.FTXthDocNo = '$tDocumentNumber' AND TCNTDocDTTmp.FTXthDocKey = 'TCNTPdtTwsDT' 
                                AND TCNTDocDTTmp.FTSessionID = '$tSession' ";
            $this->db->query($tSQLUpdate);
        }
    }

    //อัพเดทข้อมูล step2
    public function FSaMRVDDTUpdateStep2($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $nLngID             = $paData['FNLngID'];

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $tDocumentNumber;
        }

        $this->db->set('FCStkQty', $paData['nQty']);
        $this->db->where('FTSessionID',$this->session->userdata('tSesSessionID'));
        $this->db->where('FTXthDocKey','TCNTPdtTwsDT');
        $this->db->where('FNXtdSeqNo',$paData['nSeqNo']);
        $this->db->where('FTXthDocNo',$tDocumentNumber);
        $this->db->where('FTPdtCode',$paData['tPdtCode']);
        $this->db->update('TCNTDocDTTmp');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Update Success',
            );
        }else{
            $aStatus = array(
                'rtCode'    => '903',
                'rtDesc'    => 'Update Fail',
            );
        }
        return $aStatus;
    }

    //Delete Step2
    public function FSaMRVDDeleteRecordStep2($paData){
        $tDocumentNumber       = $paData['tDocumentNumber'];
        $nSeq                  = $paData['nSeq'];
        $tPDTCode              = $paData['tPDTCode'];

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $this->db->where_in('FTXthDocNo','REFILLPDTSET-VD');
        }else{
            $this->db->where_in('FTXthDocNo',$tDocumentNumber);
        }
        $this->db->where_in('FTPdtCode',$tPDTCode);
        $this->db->where_in('FNXtdSeqNo',$nSeq);
        $this->db->where_in('FTXthDocKey','TCNTPdtTwsDT');
        $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
        $this->db->delete('TCNTDocDTTmp');
    }

    //Delete Multi Step2
    public function FSaMRVDDeleteRecordMultiStep2($paData){
        $tDocumentNumber       = $paData['tDocumentNumber'];
        $nSeq                  = $paData['nSeq'];

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $this->db->where_in('FTXthDocNo','REFILLPDTSET-VD');
        }else{
            $this->db->where_in('FTXthDocNo',$tDocumentNumber);
        }
        $this->db->where_in('FNXtdSeqNo',$nSeq);
        $this->db->where_in('FTXthDocKey','TCNTPdtTwsDT');
        $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
        $this->db->delete('TCNTDocDTTmp');
    }

    //Prorate
    public function FSaMRVDProrateStep2($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $nLngID             = $paData['FNLngID'];
        $tPdtCode           = $paData['tPdtCode'];

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $tDocumentNumber;
        }

        $tSQL  = "  SELECT 
                        Tmp.FTBchCode,
                        SHP.FTShpName,
                        POSL.FTPosName,
                        POSL.FTPosCode,
                        PDT.FNLayRow , 
                        PDT.FNLayCol ,
                        PDT.FCLayColQtyMax ,
                        ISNULL(STKBal.FCStkQty,0) AS FCStkQty ,
                        PDT.FCLayColQtyMax - ISNULL(STKBal.FCStkQty,0) AS AVGQTY ,
                        HAVEPro.FCXtdQty
                    FROM TCNTDocDTTmp Tmp
                    LEFT JOIN TCNTPdtTwsHDBch HDBch ON Tmp.FTBchCode = HDBch.FTBchCode AND Tmp.FTShpCodeForADJPL = HDBch.FTXthShopTo 
                        AND Tmp.FTPzeCodeForADJPL = HDBch.FTXthPosTo  AND Tmp.FTXthDocNo = HDBch.FTXthDocNo  AND HDBch.FTXthStaTnf = '2'
                    INNER JOIN TCNMShop_L SHP ON Tmp.FTBchCode = SHP.FTBchCode AND Tmp.FTShpCodeForADJPL = SHP.FTShpCode AND SHP.FNLngID = $nLngID 
                    INNER JOIN TCNMPos_L POSL ON Tmp.FTBchCode = POSL.FTBchCode AND Tmp.FTPzeCodeForADJPL = POSL.FTPosCode AND POSL.FNLngID = $nLngID 
                    INNER JOIN TCNMWaHouse WAH ON Tmp.FTBchCode = WAH.FTBchCode AND POSL.FTPosCode = WAH.FTWahRefCode AND WAH.FTWahStaType = '6'
                    INNER JOIN TVDMPdtLayout PDT ON Tmp.FTBchCode = PDT.FTBchCode AND Tmp.FTShpCodeForADJPL = PDT.FTShpCode
                    LEFT JOIN TVDTPdtStkBal STKBal ON PDT.FTBchCode = STKBal.FTBchCode AND PDT.FNCabSeq = STKBal.FNCabSeq AND
                        PDT.FNLayRow = STKBal.FNLayRow AND PDT.FNLayCol = STKBal.FNLayCol AND PDT.FTPdtCode	= STKBal.FTPdtCode AND 
                        WAH.FTWahCode = STKBal.FTWahCode 
                    LEFT JOIN TCNTDocDTTmp HAVEPro ON POSL.FTPosCode = HAVEPro.FTPzeCodeForADJPL AND Tmp.FTBchCode = HAVEPro.FTBchCode AND
                        Tmp.FTXthDocNo = HAVEPro.FTXthDocNo AND PDT.FTPdtCode = HAVEPro.FTPdtCode AND PDT.FNLayRow = HAVEPro.FNLayRowForTWXVD AND
                        PDT.FNLayCol = HAVEPro.FNLayColForTWXVD AND HAVEPro.FTXthDocKey = 'PDT_QTY_PRORATE' 
                    WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                      AND PDT.FTPdtCode = '$tPdtCode'
                      AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                      AND TMP.FTXthDocNo = '$tDocumentNumber' 
                    ORDER BY FTPosCode ";
        $oQuery = $this->db->query($tSQL);
        // echo $tSQL;exit;

        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Insert Prorate To Temp
    public function FSaMRVDInsertProrateToStep2($index,$paData){
        //ถ้าไม่มีเลขที่เอกสาร
        if($paData['DOC'] == '' || $paData['DOC'] == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $paData['DOC'];
        }

        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        //ลบข้อมูลก่อน
        if($index == 0){
            $this->db->where_in('FTBchCode', $paData['BCH']);
            $this->db->where_in('FTXthDocNo',  $tDocumentNumber);
            $this->db->where_in('FTXthDocKey',  'PDT_QTY_PRORATE');
            $this->db->where_in('FTPdtCode', $paData['PDT']);
            $this->db->delete('TCNTDocDTTmp');
        }

        //เอาจำนวนทั้งหมดใน DT ไปฝากไว้ใน Temp ก่อน
        $this->db->insert('TCNTDocDTTmp', array(
            'FNXtdSeqNo'        => $paData['SEQ'] + 1,
            'FTBchCode'         => $paData['BCH'],
            'FTXthDocNo'        => $tDocumentNumber,
            'FTXthDocKey'       => 'PDT_QTY_PRORATE',
            'FTPdtCode'         => $paData['PDT'],
            'FNLayRowForTWXVD'  => $paData['ROW'],
            'FNLayColForTWXVD'  => $paData['COL'],
            'FTPzeCodeForADJPL' => $paData['POS'],
            'FCXtdQty'          => $paData['QTY'],
            'FTSessionID'       => $tSesSessionID
        ));
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot',
            );
        }
    }

    //-------------------------------------------------------------------------------------------------------//

    //โหลดข้อมูลของ STEP3
    public function FSaMRVDDTListStep3($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $nLngID             = $paData['FNLngID'];

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $tDocumentNumber;
        }

        $tSQL  = "SELECT Tmp.* FROM TCNTDocDTTmp Tmp
                    WHERE TMP.FTXthDocKey = 'TCNTPdtTwsDT'
                    AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                    AND TMP.FTXthDocNo = '$tDocumentNumber' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //-------------------------------------------------------------------------------------------------------//

    //โหลดข้อมูลของ STEP4
    public function FSaMRVDDTListStep4($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $nLngID             = $paData['FNLngID'];

        //ถ้าไม่มีเลขที่เอกสาร
        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $tDocumentNumber = 'REFILLPDTSET-VD';
        }else{
            $tDocumentNumber = $tDocumentNumber;
        }

        //HD
        $tSQLHD  = " SELECT 
                        Tmp.FTBchCode ,
                        BCHL.FTBchName ,
                        WAH.FTWahName ,
                        WAH.FTXthWhFrmForTWXVD ,
                        HDBch.FTXthRefInt
                    FROM TCNTDocDTTmp Tmp
                    LEFT JOIN TCNTPdtTwsHDBch HDBch ON Tmp.FTBchCode = HDBch.FTBchCode AND Tmp.FTShpCodeForADJPL = HDBch.FTXthShopTo AND Tmp.FTXthDocNo = HDBch.FTXthDocNo AND HDBch.FTXthStaTnf = 1
                    INNER JOIN TCNMBranch_L BCHL ON Tmp.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                    LEFT JOIN (
                        SELECT DISTINCT WAHSHP.FTXthWhFrmForTWXVD , WAHL.FTWahName , WAHSHP.FTBchCode FROM TCNTDocDTTmp WAHSHP 
		                INNER JOIN TCNMWaHouse_L WAHL ON WAHSHP.FTXthWhFrmForTWXVD = WAHL.FTWahCode AND WAHSHP.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $nLngID 
                        WHERE WAHSHP.FTXthDocKey = 'TCNTPdtTwsHD_Wahouse'
                        AND WAHSHP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                        AND WAHSHP.FTXthDocNo = '$tDocumentNumber' 
                    ) AS WAH ON WAH.FTBchCode = Tmp.FTBchCode
                    WHERE TMP.FTXthDocKey = 'TCNTPdtTwsDT'
                    AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                    AND TMP.FTXthDocNo = '$tDocumentNumber' 
                    GROUP BY WAH.FTXthWhFrmForTWXVD 
                    , Tmp.FTBchCode 
                    , BCHL.FTBchName 
                    , WAH.FTWahName 
                    , HDBch.FTXthRefInt  ORDER BY Tmp.FTBchCode";
        $oQueryHD = $this->db->query($tSQLHD);
        // echo $this->db->last_query();


        //DT
        $tSQLDT  = " SELECT 
                        DISTINCT
                        Tmp.FTBchCode ,
                        SHP.FTShpName ,
                        POSL.FTPosName ,
                        POSL.FTPosCode ,
                        HDBch.FTXthRefInt
                    FROM TCNTDocDTTmp Tmp
                    LEFT JOIN TCNTPdtTwsHDBch HDBch ON Tmp.FTBchCode = HDBch.FTBchCode AND Tmp.FTShpCodeForADJPL = HDBch.FTXthShopTo 
                    AND Tmp.FTPzeCodeForADJPL = HDBch.FTXthPosTo 
                    AND Tmp.FTXthDocNo = HDBch.FTXthDocNo 
                    AND HDBch.FTXthStaTnf = 2
                    INNER JOIN TCNMShop_L SHP ON Tmp.FTBchCode = SHP.FTBchCode AND Tmp.FTShpCodeForADJPL = SHP.FTShpCode AND SHP.FNLngID = $nLngID 
                    INNER JOIN TCNMPos_L POSL ON Tmp.FTBchCode = POSL.FTBchCode AND Tmp.FTPzeCodeForADJPL = POSL.FTPosCode AND POSL.FNLngID = $nLngID 
                    WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                    AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                    AND TMP.FTXthDocNo = '$tDocumentNumber' ORDER BY FTBchCode ";
        $oQueryDT = $this->db->query($tSQLDT);
        // echo $this->db->last_query();
        // exit;

        if($oQueryHD->num_rows() > 0){
            $oListHD     = $oQueryHD->result();
            $oListDT     = $oQueryDT->result();
            $aResult     = array(
                'raItemsHD'     => $oListHD,
                'raItemsDT'     => $oListDT,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //-------------------------------------------------------------------------------------------------------//

    //เช็คเลขที่เอกสารซ้ำ
    public function FSnMRVDCheckDuplicate($tDocumentnumber){
        $tSQL = " SELECT 
                    COUNT(PPH.FTXthDocNo) AS counts
                    FROM TCNTPdtTwsHD PPH 
                    WHERE PPH.FTXthDocNo = '$tDocumentnumber' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return FALSE;
        }
    }

    //Insert HD
    public function FSaMRVDAddInsertAndUpdateHD($paParams){
        try {
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FDXthDocDate', $paParams['FDXthDocDate']);
            $this->db->set('FTXthDocType', $paParams['FTXthDocType']);
            $this->db->set('FTDptCode', $paParams['FTDptCode']);
            $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
            $this->db->set('FTXthApvCode', $paParams['FTXthApvCode']);
            $this->db->set('FTXthShipWhTo', $paParams['FTXthShipWhTo']);
            $this->db->set('FTXthRefExt', $paParams['FTXthRefExt']);
            $this->db->set('FDXthRefExtDate', $paParams['FDXthRefExtDate']);
            $this->db->set('FTXthRefInt', $paParams['FTXthRefInt']);
            $this->db->set('FDXthRefIntDate', $paParams['FDXthRefIntDate']);
            $this->db->set('FNXthDocPrint', $paParams['FNXthDocPrint']);
            $this->db->set('FTXthRmk', $paParams['FTXthRmk']);
            $this->db->set('FTXthStaDoc', $paParams['FTXthStaDoc']);
            $this->db->set('FTXthStaApv', $paParams['FTXthStaApv']);
            $this->db->set('FTXthStaPrcStk', $paParams['FTXthStaPrcStk']);
            $this->db->set('FTXthStaDelMQ', $paParams['FTXthStaDelMQ']);
            $this->db->set('FNXthStaDocAct', $paParams['FNXthStaDocAct']);
            $this->db->set('FNXthStaRef', $paParams['FNXthStaRef']);
            $this->db->set('FNXthStaClsSft', $paParams['FNXthStaClsSft']);
            $this->db->set('FTRsnCode', $paParams['FTRsnCode']);
            $this->db->set('FTXthCtrName', $paParams['FTXthCtrName']);
            $this->db->set('FDXthTnfDate', $paParams['FDXthTnfDate']);
            $this->db->set('FNXthShipAdd', $paParams['FNXthShipAdd']);
            $this->db->set('FTViaCode', $paParams['FTViaCode']);
            $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
            $this->db->set('FTXthStaChkBal', $paParams['FTXthStaChkBal']);
            $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->update('TCNTPdtTwsHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $this->db->insert('TCNTPdtTwsHD', array(
                    'FTBchCode'         =>  $paParams['FTBchCode'],
                    'FTXthDocNo'        =>  $paParams['FTXthDocNo'],
                    'FDXthDocDate'      =>  $paParams['FDXthDocDate'],
                    'FTXthDocType'      =>  $paParams['FTXthDocType'],
                    'FTDptCode'         =>  $paParams['FTDptCode'],
                    'FTUsrCode'         =>  $paParams['FTUsrCode'],
                    'FTXthApvCode'      =>  $paParams['FTXthApvCode'],
                    'FTXthShipWhTo'     =>  $paParams['FTXthShipWhTo'],
                    'FTXthRefExt'       =>  $paParams['FTXthRefExt'],
                    'FDXthRefExtDate'   =>  $paParams['FDXthRefExtDate'],
                    'FTXthRefInt'       =>  $paParams['FTXthRefInt'],
                    'FDXthRefIntDate'   =>  $paParams['FDXthRefIntDate'],
                    'FNXthDocPrint'     =>  $paParams['FNXthDocPrint'],
                    'FTXthRmk'          =>  $paParams['FTXthRmk'],
                    'FTXthStaDoc'       =>  $paParams['FTXthStaDoc'],
                    'FTXthStaApv'       =>  $paParams['FTXthStaApv'],
                    'FTXthStaPrcStk'    =>  $paParams['FTXthStaPrcStk'],
                    'FTXthStaDelMQ'     =>  $paParams['FTXthStaDelMQ'],
                    'FNXthStaDocAct'    =>  $paParams['FNXthStaDocAct'],
                    'FNXthStaRef'       =>  $paParams['FNXthStaRef'],
                    'FNXthStaClsSft'    =>  $paParams['FNXthStaClsSft'],
                    'FTRsnCode'         =>  $paParams['FTRsnCode'],
                    'FTXthCtrName'      =>  $paParams['FTXthCtrName'],
                    'FDXthTnfDate'      =>  $paParams['FDXthTnfDate'],
                    'FNXthShipAdd'      =>  $paParams['FNXthShipAdd'],
                    'FTViaCode'         =>  $paParams['FTViaCode'],
                    'FDLastUpdOn'       =>  $paParams['FDLastUpdOn'],
                    'FTLastUpdBy'       =>  $paParams['FTLastUpdBy'],
                    'FDCreateOn'        =>  $paParams['FDCreateOn'],
                    'FTCreateBy'        =>  $paParams['FTCreateBy'],
                    'FTXthStaChkBal'    =>  $paParams['FTXthStaChkBal']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add HD Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit HD.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Delete DT
    public function FSaMRVDDeleteDT($paParams){
        $tDocumentNumber        = $paParams['FTXthDocNo'];
        $tBchCode               = $paParams['FTBchCode'];

        $this->db->where_in('FTBchCode', $tBchCode);
        $this->db->where_in('FTXthDocNo', $tDocumentNumber);
        $this->db->delete('TCNTPdtTwsDT');
    }

    //Insert DT
    public function FSaMRVDAddInsertAndUpdateDT($paParams){
        $tDocumentNumber        = $paParams['FTXthDocNo'];
        $tBchCode               = $paParams['FTBchCode'];
        $tStaChkBal             = $paParams['FTXthStaChkBal'];
        $tSesSessionID          = $this->session->userdata('tSesSessionID');

        $tSQL = "INSERT INTO TCNTPdtTwsDT 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FNXtdSeqNo,
                    FTPdtCode,
                    FCXtdQty,
                    FCXtdQtySpc
                ) 
                SELECT 
                    '$tBchCode',
                    '$tDocumentNumber' AS FTXthDocNo,
                    FNXtdSeqNo,
                    FTPdtCode,
                    CASE
                        WHEN '$tStaChkBal' = 0 THEN FCLayColQtyMaxForTWXVD
                        WHEN FCLayColQtyMaxForTWXVD - FCXtdAmt <= FCXtdQty THEN FCLayColQtyMaxForTWXVD - FCXtdAmt
                        ELSE FCXtdQty
                    END AS FCXtdQty,
                    FCStkQty AS FCXtdQtySpc
                FROM TCNTDocDTTmp Tmp
                WHERE TMP.FTXthDocKey = 'TCNTPdtTwsDT'
                AND TMP.FCXtdQty != 0
                AND TMP.FTSessionID = '". $tSesSessionID."'
                AND TMP.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber') ";
        $this->db->query($tSQL);
    }

    //Insert HDBch
    public function FSaMRVDAddInsertAndUpdateHDBch($paParams){
        $tDocumentNumber        = $paParams['FTXthDocNo'];
        $tWahTo                 = $paParams['FTXthShipWhTo'];
        $tBchCode               = $paParams['FTBchCode'];
        $tSesSessionID          = $this->session->userdata('tSesSessionID');

        //Insert ข้อมูลที่เกี่ยวกับใบโอน (จากคลังสินค้า -> คลังหน่วยรถ)
        $tSQL = "INSERT INTO TCNTPdtTwsHDBch 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FTXthBchTo,
                    FTXthShopTo,
                    FTXthPosTo,
                    FTXthStaTnf,
                    FTXthRefInt,
                    FTXthWahFrm,
                    FTXthWahTo
                ) 
                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocumentNumber' AS FTXthDocNo,
                    Tmp.FTBchCode AS FTXthBchTo,
                    Tmp.FTShpCodeForADJPL AS FTXthShopTo,
                    '' AS FTXthPosTo,
                    1 AS FTXthStaTnf,
                    'WAIT-APPROVED' AS FTXthRefInt,
                    LAY.FTWahCode AS FTXthWahFrm,
                    '$tWahTo' AS FTXthWahTo
                FROM TCNTDocDTTmp Tmp
                LEFT JOIN TVDMPdtLayout LAY ON Tmp.FTBchCode = LAY.FTBchCode AND Tmp.FTShpCodeForADJPL = LAY.FTShpCode AND Tmp.FTPdtCode = LAY.FTPdtCode
                WHERE TMP.FTXthDocKey = 'TCNTPdtTwsDT'
                AND TMP.FTSessionID = '".$tSesSessionID."'
                AND TMP.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber') 
                GROUP BY LAY.FTWahCode , Tmp.FTBchCode , Tmp.FTShpCodeForADJPL ORDER BY Tmp.FTBchCode";
        $this->db->query($tSQL);

        //Insert ข้อมูลที่เกี่ยวกับใบเติม (คลังหน่วยรถ -> คลังจุดขาย)
        $tSQL = "INSERT INTO TCNTPdtTwsHDBch 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FTXthBchTo,
                    FTXthShopTo,
                    FTXthPosTo,
                    FTXthStaTnf,
                    FTXthRefInt,
                    FTXthWahFrm,
                    FTXthWahTo
                ) 
                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocumentNumber' AS FTXthDocNo,
                    Tmp.FTBchCode AS FTXthBchTo,
                    Tmp.FTShpCodeForADJPL AS FTXthShopTo,
                    Tmp.FTPzeCodeForADJPL AS FTXthPosTo,
                    2 AS FTXthStaTnf,
                    'WAIT-APPROVED' AS FTXthRefInt,
                    '$tWahTo' AS FTXthWahFrm,
                    WAH.FTWahCode AS FTXthWahTo
                FROM TCNTDocDTTmp Tmp
                INNER JOIN TCNMWaHouse WAH ON Tmp.FTPzeCodeForADJPL = WAH.FTWahRefCode AND Tmp.FTBchCode = WAH.FTBchCode AND FTWahStaType IN (6) 
                WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                AND TMP.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber') ORDER BY FTBchCode ";
        $this->db->query($tSQL);
    }

    //Get Pos
    public function FSaMRVDGetPosHDBch($paParams){
        $tDocumentNumber        = $paParams['FTXthDocNo'];

        //หาว่ามีกี่ pos
        $tSQL = "SELECT FTBchCode FROM TCNTPdtTwsHDBch HDBch
                WHERE HDBch.FTXthStaTnf = 2 AND HDBch.FTXthRefInt = 'WAIT-APPROVED' AND
                HDBch.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber')";
        $oQuery  = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult     = array(
                'nCount'        => $oQuery->num_rows()
            );
        }else{
            $aResult    = array(
                'nCount'        => '0'
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Delete HDBch
    public function FSaMRVDDeleteHDBch($paParams){
        $tDocumentNumber        = $paParams['FTXthDocNo'];
        $tBchCode               = $paParams['FTBchCode'];

        $this->db->where_in('FTBchCode', $tBchCode);
        $this->db->where_in('FTXthDocNo', $tDocumentNumber);
        $this->db->delete('TCNTPdtTwsHDBch');
    }

    //Delete DTPos
    public function FSaMRVDDeleteDTPos($paParams){
        $tDocumentNumber        = $paParams['FTXthDocNo'];
        $tBchCode               = $paParams['FTBchCode'];

        $this->db->where_in('FTBchCode', $tBchCode);
        $this->db->where_in('FTXthDocNo', $tDocumentNumber);
        $this->db->delete('TCNTPdtTwsDTPos');
    }

    //Insert PDT By Pos Prorate
    public function FSaMRVDInsertPDTProrateByPos($paParams){
        $tDocumentNumber        = $paParams['FTXthDocNo'];
        $tWahTo                 = $paParams['FTXthShipWhTo'];
        $tBchCode               = $paParams['FTBchCode'];
        $tSesSessionID          = $this->session->userdata('tSesSessionID');

        //หาสินค้าที่ยังไม่มีการ prorate
        $tSQL = "SELECT * FROM TCNTPdtTwsDT DT
                 WHERE DT.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber') 
                 AND DT.FTPdtCode NOT IN (
                        SELECT 
                            DISTINCT
                            Tmp.FTPdtCode AS FTPdtCode
                        FROM TCNTDocDTTmp Tmp
                        WHERE TMP.FTXthDocKey = 'PDT_QTY_PRORATE'
                        AND TMP.FTSessionID = '".$tSesSessionID."'
                        AND TMP.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber') )";
        $oQuery = $this->db->query($tSQL);

        $aCountPOS = $this->FSaMRVDGetPosHDBch($paParams);
        $nCountPOS = $aCountPOS['nCount'];
        if ($oQuery->num_rows() > 0) {

            //มีสินค้าที่ยังไม่เคย prorate ต้อง prorate
            $tPDTCodeIN = '';
            $aPDTRefill = [];
            $aItem    = $oQuery->result_array();
            for($i=0; $i<FCNnHSizeOf($oQuery->result_array()); $i++){
                $tPDTCodeIN .= "'".$aItem[$i]['FTPdtCode']."'" . ',';
                if($i == FCNnHSizeOf($oQuery->result_array()) - 1){
                    $tPDTCodeIN = substr($tPDTCodeIN,0,-1);
                }

                array_push($aPDTRefill,array('PDT' => $aItem[$i]['FTPdtCode'] , 'QTY' => $aItem[$i]['FCXtdQty']));
            }

            $nLngID = $this->session->userdata("tLangEdit");
            $tSQL   = "  SELECT A.* , SUM(A.AVGQTY) OVER (PARTITION BY A.FTPdtCode) AS FULLMAX FROM 
                        ( SELECT 
                            PDT.FTPdtCode,
                            Tmp.FTBchCode,
                            POSL.FTPosName,
                            POSL.FTPosCode,
                            PDT.FNLayRow , 
                            PDT.FNLayCol ,
                            PDT.FCLayColQtyMax ,
                            ISNULL(STKBal.FCStkQty,0) AS FCStkQty ,
                            PDT.FCLayColQtyMax - ISNULL(STKBal.FCStkQty,0) AS AVGQTY
                        FROM TCNTDocDTTmp Tmp
                        INNER JOIN TCNMPos_L POSL ON Tmp.FTBchCode = POSL.FTBchCode AND Tmp.FTPzeCodeForADJPL = POSL.FTPosCode AND POSL.FNLngID = $nLngID 
                        INNER JOIN TCNMWaHouse WAH ON Tmp.FTBchCode = WAH.FTBchCode AND POSL.FTPosCode = WAH.FTWahRefCode AND WAH.FTWahStaType = 6
                        INNER JOIN TVDMPdtLayout PDT ON Tmp.FTBchCode = PDT.FTBchCode 
                        LEFT JOIN TVDTPdtStkBal STKBal ON 
                            PDT.FTBchCode = STKBal.FTBchCode AND 
                            PDT.FNCabSeq = STKBal.FNCabSeq AND
                            PDT.FNLayRow = STKBal.FNLayRow AND
                            PDT.FNLayCol = STKBal.FNLayCol AND
                            PDT.FTPdtCode	= STKBal.FTPdtCode AND 
                            WAH.FTWahCode = STKBal.FTWahCode 
                        WHERE TMP.FTXthDocKey = 'TCNTPdtTwsHD'
                        AND PDT.FTPdtCode IN ($tPDTCodeIN)
                        AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                        AND TMP.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber') 
                        ) AS A ORDER BY A.FTPdtCode , A.FTPosCode ";
            $oQueryProrate  = $this->db->query($tSQL);
            $aItemProrate   = $oQueryProrate->result_array();
            $tPosCode       = ''; 
            $aQTYByPos      = [];
            $nAVGCode       = 0;

            //Loop หาจำนวน pos , qty รวม
            for($j=0; $j<FCNnHSizeOf($oQueryProrate->result_array()); $j++){

                if($j == 0){
                    $tPosCode       = $aItemProrate[$j]['FTPosCode'];
                    $tPDTCode       = $aItemProrate[$j]['FTPdtCode'];
                    $FULLMAX        = $aItemProrate[$j]['FULLMAX'];
                }

                //หาจำนวนที่เติมจริง
                for($l=0; $l<FCNnHSizeOf($aPDTRefill); $l++){
                    if($tPDTCode == $aPDTRefill[$l]['PDT']){
                        $nFULLREFILL = $aPDTRefill[$l]['QTY'];
                    }
                }

                //หาจำนวนต่อ pos
                if($aItemProrate[$j]['FTPosCode'] == $tPosCode){
                    $nAVGCode  = intval($nAVGCode) + intval($aItemProrate[$j]['AVGQTY']);
                }else{
                    //ถ้าขึ้นรอบใหม่ให้ push
                    array_push($aQTYByPos,array('POS' => $tPosCode , 'PDT' =>  $tPDTCode , 'QTYAll' => $nAVGCode , 'FULL' =>  $FULLMAX , 'QTYINDT' => $nFULLREFILL));
                    $tPDTCode   = $aItemProrate[$j]['FTPdtCode'];
                    $tPosCode   = $aItemProrate[$j]['FTPosCode'];
                    $nAVGCode   = $aItemProrate[$j]['AVGQTY'];
                    $FULLMAX    = $aItemProrate[$j]['FULLMAX'];
                }

                //ถ้ารอบสุดท้าย
                if($j == FCNnHSizeOf($oQueryProrate->result_array()) - 1){
                    array_push($aQTYByPos,array('POS' => $tPosCode , 'PDT' =>  $tPDTCode , 'QTYAll' => $nAVGCode , 'FULL' =>  $FULLMAX , 'QTYINDT' => $nFULLREFILL));
                }
            }

            //หาเป็น percent
            $aProratePrecent = [];
            $tPDTCodeOld     = '';
            $nSumPercent     = 0;
            $nNumPercent     = 0;
            for($i=0; $i<FCNnHSizeOf($aQTYByPos); $i++){
                $nQtyPDT        = $aQTYByPos[$i]['QTYAll'];
                $nCountPDTFull  = $aQTYByPos[$i]['FULL'];
                $tPDTCode       = $aQTYByPos[$i]['PDT'];

                if($i == 0){ $tPDTCodeOld = $tPDTCode; }

                //ถ้ารอบสุดท้าย
                if($i == (FCNnHSizeOf($aQTYByPos) - 1)){
                    $nSumPercent = 0;
                    for( $k=0; $k<FCNnHSizeOf($aProratePrecent); $k++){
                        if($aProratePrecent[$k]['PDT'] == $tPDTCode){
                            $nSumPercent = $nSumPercent + $aProratePrecent[$k]['PERCENT'];
                        }
                    }
                    $nResultProrate = 100 - $nSumPercent;
                    array_push($aProratePrecent,array('PDT' => $tPDTCode , 'PERCENT' => round($nResultProrate) , 'REMARK' => 'ใช้สูตรตัวสุดท้าย ของ LOOP' ));
                }else{ //ถ้าไม่ใช่รอบสุดท้าย
                    $tNextPDT    = $aQTYByPos[$nNumPercent+1]['PDT'];
                    $tPDTCodeOld = $tNextPDT;

                    //ถ้าเป็นรอบสุดท้ายของ PDT ตัวนั้น
                    if($tPDTCode != $tPDTCodeOld){
                        for( $k=0; $k<FCNnHSizeOf($aProratePrecent); $k++){
                            if($aProratePrecent[$k]['PDT'] == $tPDTCode){
                                $nSumPercent = $nSumPercent + $aProratePrecent[$k]['PERCENT'];
                            }
                        }
                        $nResultProrate = 100 - $nSumPercent;
                        array_push($aProratePrecent,array('PDT' => $tPDTCode , 'PERCENT' => round($nResultProrate) , 'REMARK' => 'ใช้สูตรตัวสุดท้าย ของ PDT' ));
                    }else{ //PDT ตัวเดิม
                        if($nCountPDTFull == 0 || $nCountPDTFull == null){
                            $nResultProrate = 0;
                        }else{
                            $nResultProrate = $nQtyPDT * 100 / $nCountPDTFull;
                        }
                        array_push($aProratePrecent,array('PDT' => $tPDTCode , 'PERCENT' => round($nResultProrate) , 'REMARK' => 'สูตรปกติ' ));
                    }
                }
                $nNumPercent++;
            }

            //หาเป็นจำนวนชิ้น
            $aProrateUnit   = [];
            $tPDTCodeOld    = '';
            $nSumUnit       = 0;
            $nNumUnit       = 0;
            for($u=0; $u<FCNnHSizeOf($aProratePrecent); $u++){
                $tPosCode        = $aQTYByPos[$u]['POS'];
                $nQTY            = $aQTYByPos[$u]['QTYINDT'];
                $nQTYPDTPercent  = $aProratePrecent[$u]['PERCENT'];
                $tPDTCode        = $aProratePrecent[$u]['PDT'];

                if($u == 0){ $tPDTCodeOld = $tPDTCode; }

                //ถ้ารอบสุดท้าย    
                if($u == (FCNnHSizeOf($aProratePrecent) - 1)){
                    $nSumUnit = 0;
                    for( $k=0; $k<FCNnHSizeOf($aProrateUnit); $k++){
                        if($aProrateUnit[$k]['PDT'] == $tPDTCode){
                            $nSumUnit = $nSumUnit + $aProrateUnit[$k]['UNIT'];
                        }
                    }
                    $nResultProrate = $nQTY - $nSumUnit;
                    array_push($aProrateUnit,array('POS' => $tPosCode , 'PDT' => $tPDTCode , 'UNIT' => round($nResultProrate) , 'REMARK' => 'ใช้สูตรตัวสุดท้าย ของ LOOP' ));
                }else{ //ถ้าไม่ใช่รอบสุดท้าย
                    $tNextPDT    = $aProratePrecent[$nNumUnit+1]['PDT'];
                    $tPDTCodeOld = $tNextPDT;

                    //ถ้าเป็นรอบสุดท้ายของ PDT ตัวนั้น
                    if($tPDTCode != $tPDTCodeOld){
                        for( $m=0; $m<FCNnHSizeOf($aProrateUnit); $m++){
                            if($aProrateUnit[$m]['PDT'] == $tPDTCode){
                                $nSumUnit = $nSumUnit + $aProrateUnit[$m]['UNIT'];
                            }
                        }
                        $nResultProrate = $nQTY - $nSumUnit;
                        array_push($aProrateUnit,array('POS' => $tPosCode , 'PDT' => $tPDTCode , 'UNIT' => round($nResultProrate) , 'REMARK' => 'ใช้สูตรตัวสุดท้าย ของ PDT' ));
                    }else{ //PDT ตัวเดิม
                        $nResultProrate = $nQTYPDTPercent * $nQTY / 100;
                        array_push($aProrateUnit,array('POS' => $tPosCode , 'PDT' => $tPDTCode , 'UNIT' => round($nResultProrate) , 'REMARK' => 'สูตรปกติ' ));
                    }
                }
                $nNumUnit++;
            }

            //เอาไป Insert
            $nQTYUse        = 0;
            for($i=0; $i<FCNnHSizeOf($aProrateUnit); $i++){
                for($w=0; $w<FCNnHSizeOf($aItemProrate); $w++){
                    $POSTmp   = $aItemProrate[$w]['FTPosCode'];
                    $PDTTmp   = $aItemProrate[$w]['FTPdtCode'];
                    $MaxTmp   = $aItemProrate[$w]['FCLayColQtyMax'];
                    $STKTmp   = $aItemProrate[$w]['FCStkQty'];
                    if($POSTmp == $aProrateUnit[$i]['POS'] && $PDTTmp == $aProrateUnit[$i]['PDT']){
                       
                        $nQTYUse = $aProrateUnit[$i]['UNIT'] - $nQTYUse;
                        $nRefill = $MaxTmp - $STKTmp;
                        if($nRefill > $nQTYUse){
                            $nQTYUse = $nQTYUse;
                        }else{
                            $nQTYUse = $nRefill;
                        }

                        $this->db->insert('TCNTPdtTwsDTPos', array(
                            'FTBchCode'     => $tBchCode,
                            'FTXthDocNo'    => $tDocumentNumber,
                            'FTPdtCode'     => $aProrateUnit[$i]['PDT'],
                            'FNXtdSeqNo'    => $w,
                            'FCXtdQty'      => $nQTYUse,
                            'FNCabSeq'      => 0,
                            'FNLayRow'      => $aItemProrate[$w]['FNLayRow'],
                            'FNLayCol'      => $aItemProrate[$w]['FNLayCol'],
                            'FTPosCode'     => $aProrateUnit[$i]['POS']
                        ));

                    }else{
                        $nQTYUse = 0;
                    }
                }
            }
        }

        //Insert Prorate ข้อมูลสินค้ารายตัว กรณีถ้าเค้า custome เเล้ว
        $tSQL = "INSERT INTO TCNTPdtTwsDTPos 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FTPdtCode,
                    FNXtdSeqNo,
                    FCXtdQty,
                    FNCabSeq,
                    FNLayRow,
                    FNLayCol,
                    FTPosCode
                ) 
                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocumentNumber' AS FTXthDocNo,
                    Tmp.FTPdtCode AS FTPdtCode,
                    Tmp.FNXtdSeqNo AS FNXtdSeqNo,
                    Tmp.FCXtdQty AS FCXtdQty,
                    '0'          AS FNCabSeq,
                    Tmp.FNLayRowForTWXVD AS FNLayRow,
                    Tmp.FNLayColForTWXVD AS FNLayCol,
                    Tmp.FTPzeCodeForADJPL AS FTPosCode
                FROM TCNTDocDTTmp Tmp
                WHERE TMP.FTXthDocKey = 'PDT_QTY_PRORATE'
                AND TMP.FTSessionID = '".$tSesSessionID."'
                AND TMP.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber') ORDER BY FTPzeCodeForADJPL ";
        $this->db->query($tSQL);
    }

    //Delete Temp
    public function FSaMRVDDeleteTemp($paParams){
        $aWhere = array('TCNTPdtTwsHD','TCNTPdtTwsDT','PDT_QTY','REFILLPDTSET-VD','PDT_QTY_PRORATE');
        $this->db->where_in('FTXthDocKey', $aWhere);
        $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
        $this->db->delete('TCNTDocDTTmp');
    }

    //ยกเลิกเอกสาร
    public function FSvMRVDCancel($paParams){
        try{
            $this->db->set('FTXthStaDoc', 3);
            $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->update('TCNTPdtTwsHD');
        }catch(Exception $Error){
            return $Error;
        }
    }

    //ลบเอกสาร HD DT HDBch
    public function FSaMRVDDeleteDocument($paParams){
        try{
            $this->db->trans_begin();

            //Delete HD
            $this->db->where_in('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->delete('TCNTPdtTwsHD');

            //Delete DT
            $this->db->where_in('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->delete('TCNTPdtTwsDT');

            //Delete HDBch
            $this->db->where_in('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->delete('TCNTPdtTwsHDBch');

            //Delete DTPos
            $this->db->where_in('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->delete('TCNTPdtTwsDTPos');

            //Delete Temp
            $this->db->where_in('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
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
        }catch(Exception $Error){
            return $Error;
        }
    }

    //อัพเดทเอกสารใบเติมสินค้าชุดว่าอนุมัติเเล้ว 
    public function FSaMRVDApproveHD($tDocumentNumber){
        $tApvCode = $this->session->userdata('tSesUsername');
        $this->db->set('FTXthStaApv', 1);
        $this->db->set('FTXthApvCode', $tApvCode);
        $this->db->where('FTXthDocNo',$tDocumentNumber);
        $this->db->update('TCNTPdtTwsHD');
    }

    //-------------------------------------------------------------------------------------------------------//

    //หาว่ามีกี่เอกสารที่ต้อง split ออกมาเป็นใบโอน
    public function FSaMRVDFind_document_tranferwahouseHD($tDocumentnumber){
        $tSQL = " SELECT HDBch.* , HD.* FROM TCNTPdtTwsHDBch HDBch  
                INNER JOIN TCNTPdtTwsHD HD ON HDBch.FTXthDocNo = HD.FTXthDocNo AND HD.FTBchCode = HDBch.FTBchCode
                WHERE HDBch.FTXthDocNo = '$tDocumentnumber'
                AND HDBch.FTXthStaTnf = 1
                AND HDBch.FTXthRefInt = 'WAIT-APPROVED' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult     = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //สร้างใบโอนสินค้าระหว่างคลัง HD
    public function FSaMRVDInsert_wahouseHD($tDocumentnumber){
        $dDate  = date('Y-m-d H:i:s' , strtotime('+ 1 minute'));
        $tSQL   = "INSERT INTO TCNTPdtTwxHD 
                ( 
                    FTXthDocNo ,           
                    FDXthDocDate ,         
                    FTBchCode ,           
                    FTXthMerCode ,        
                    FTXthShopFrm ,        
                    FTXthShopTo ,        
                    FTXthVATInOrEx ,       
                    FTDptCode ,            
                    FTXthWhFrm ,       
                    FTXthWhTo ,        
                    FTUsrCode ,            
                    FTXthRefExt ,         
                    FDXthRefExtDate ,     
                    FTXthRefInt ,     
                    FDXthRefIntDate ,      
                    FNXthDocPrint ,     
                    FCXthTotal ,        
                    FCXthVat ,     
                    FCXthVatable ,        
                    FTXthRmk ,            
                    FTXthStaDoc ,        
                    FTXthStaApv ,        
                    FTXthStaPrcStk ,      
                    FNXthStaDocAct ,      
                    FNXthStaRef ,          
                    FTRsnCode ,           
                    FDLastUpdOn ,         
                    FDCreateOn ,          
                    FTCreateBy ,          
                    FTLastUpdBy       
                ) 
                SELECT 
                    DISTINCT
                    'WAIT-' + HDBch.FTXthWahFrm AS FTXthDocNo , 
                    '$dDate' AS FDXthDocDate , 
                    HDBch.FTBchCode AS FTBchCode ,
                    '' AS FTXthMerCode ,        
                    '' AS FTXthShopFrm ,        
                    '' AS FTXthShopTo ,        
                    1 AS FTXthVATInOrEx ,       
                    '' AS FTDptCode ,            
                    HDBch.FTXthWahFrm AS FTXthWhFrm ,       
                    HDBch.FTXthWahTo AS FTXthWhTo ,        
                    HD.FTUsrCode AS FTUsrCode ,            
                    NULL AS FTXthRefExt ,         
                    NULL AS FDXthRefExtDate ,     
                    HD.FTXthDocNo AS FTXthRefInt ,     
                    HD.FDXthDocDate AS FDXthRefIntDate ,      
                    0 AS FNXthDocPrint ,     
                    0 AS FCXthTotal ,        
                    0 AS FCXthVat ,     
                    0 AS FCXthVatable ,        
                    HD.FTXthRmk AS FTXthRmk ,            
                    1 AS FTXthStaDoc ,        
                    '' AS FTXthStaApv ,        
                    '' AS FTXthStaPrcStk ,      
                    1 AS FNXthStaDocAct ,      
                    '' AS FNXthStaRef ,          
                    HD.FTRsnCode AS FTRsnCode ,           
                    '$dDate' AS FDLastUpdOn ,         
                    '$dDate' AS FDCreateOn ,          
                    FTCreateBy ,          
                    FTLastUpdBy 
                FROM TCNTPdtTwsHDBch HDBch  
                INNER JOIN TCNTPdtTwsHD HD ON HDBch.FTXthDocNo = HD.FTXthDocNo AND HD.FTBchCode = HDBch.FTBchCode
                WHERE HDBch.FTXthDocNo = '$tDocumentnumber'
                AND HDBch.FTXthStaTnf = 1
                AND HDBch.FTXthRefInt = 'WAIT-APPROVED' ";
        $this->db->query($tSQL);
    }

    //สร้างใบโอนสินค้าระหว่างคลัง DT 
    public function FSaMRVDInsert_wahouseDT($tDocumentnumber){
        $nLngID = $this->session->userdata("tLangEdit");
        $tUser  = $this->session->userdata('tSesUsername');
        $dDate  = date('Y-m-d H:i:s' , strtotime('+ 1 minute'));
        $tSQL   = "INSERT INTO TCNTPdtTwxDT 
                ( 
                    FTBchCode ,
                    FTXthDocNo ,
                    FNXtdSeqNo ,
                    FTPdtCode ,
                    FTXtdPdtName ,
                    FTPunCode ,
                    FTPunName ,
                    FCXtdFactor ,
                    FTXtdBarCode ,
                    FTXtdVatType ,
                    FTVatCode ,
                    FCXtdVatRate ,
                    FCXtdQty ,
                    FCXtdQtyAll ,
                    FCXtdSetPrice ,
                    FCXtdAmt ,
                    FCXtdVat ,
                    FCXtdVatable ,
                    FCXtdNet ,
                    FCXtdCostIn ,
                    FCXtdCostEx ,
                    FTXtdStaPrcStk ,
                    FNXtdPdtLevel ,
                    FTXtdPdtParent ,
                    FCXtdQtySet ,
                    FTXtdPdtStaSet ,
                    FTXtdRmk ,
                    FDLastUpdOn ,
                    FTLastUpdBy ,
                    FDCreateOn ,
                    FTCreateBy
                ) 
                SELECT DISTINCT
                    DT.FTBchCode AS FTBchCode ,
                    'WAIT-' + HDBch.FTXthWahFrm AS FTXthDocNo ,
                    DT.FNXtdSeqNo AS FNXtdSeqNo ,
                    PDT.FTPdtCode AS FTPdtCode ,
                    PDTL.FTPdtName AS FTXtdPdtName ,
                    PDTBar.FTPunCode AS FTPunCode , 
                    UNIT.FTPunName AS FTPunName ,
                    PACK.FCPdtUnitFact AS FCXtdFactor ,
                    PDTBar.FTBarCode AS FTXtdBarCode ,
                    1 AS FTXtdVatType ,
                    0 AS FTVatCode ,
                    0 AS FCXtdVatRate ,
                    FCXtdQty + FCXtdQtySpc AS FCXtdQty ,
                    FCXtdQty + FCXtdQtySpc AS FCXtdQtyAll ,
                    0 AS FCXtdSetPrice ,
                    0 AS FCXtdAmt ,
                    0 AS FCXtdVat ,
                    0 AS FCXtdVatable ,
                    0 AS FCXtdNet ,
                    0 AS FCXtdCostIn ,
                    0 AS FCXtdCostEx ,
                    null AS FTXtdStaPrcStk ,
                    null AS FNXtdPdtLevel ,
                    null AS FTXtdPdtParent ,
                    null AS FCXtdQtySet ,
                    null AS FTXtdPdtStaSet ,
                    null AS FTXtdRmk ,
                    '$dDate' AS FDLastUpdOn ,
                    '$tUser' AS FTLastUpdBy ,
                    '$dDate' AS FDCreateOn ,
                    '$tUser' AS FTCreateBy
                FROM TCNTPdtTwsHDBch HDBch WITH(NOLOCK)
                LEFT JOIN TVDMPdtLayout PDTLay WITH(NOLOCK) ON HDBch.FTXthShopTo = PDTLay.FTShpCode AND HDBch.FTXthWahFrm = PDTLay.FTWahCode AND PDTLay.FTPdtCode != ''
                LEFT JOIN TCNTPdtTwsDT DT WITH(NOLOCK) ON HDBch.FTXthDocNo = DT.FTXthDocNo AND HDBch.FTBchCode = DT.FTBchCode AND PDTLay.FTPdtCode = DT.FTPdtCode
                INNER JOIN TCNMPdt PDT WITH(NOLOCK) ON PDT.FTPdtCode = DT.FTPdtCode
                INNER JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
                INNER JOIN TCNMPdtBar PDTBar WITH(NOLOCK) ON PDT.FTPdtCode = PDTBar.FTPdtCode
                INNER JOIN TCNMPdtUnit_L UNIT WITH(NOLOCK) ON PDTBar.FTPunCode = UNIT.FTPunCode AND UNIT.FNLngID = $nLngID
                INNER JOIN TCNMPdtPackSize PACK WITH(NOLOCK) ON PACK.FTPdtCode = PDT.FTPdtCode AND UNIT.FTPunCode = PACK.FTPunCode
                WHERE HDBch.FTXthDocNo = '$tDocumentnumber'
                  AND HDBch.FTXthStaTnf = '1' ";
        $this->db->query($tSQL);
    }

    //สร้างใบโอนสินค้าระหว่างคลัง HDRef
    public function FSaMRVDInsert_wahouseHDRef($tDocumentnumber){
        $nLngID = $this->session->userdata("tLangEdit");
        $tUser  = $this->session->userdata('tSesUsername');
        $dDate  = date('Y-m-d H:i:s' , strtotime('+ 1 minute'));

        $tSQL   = "INSERT INTO TCNTPdtTwxHDRef 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FTXthCtrName,
                    FDXthTnfDate,
                    FTXthRefTnfID,
                    FTXthRefVehID,
                    FTXthQtyAndTypeUnit,
                    FNXthShipAdd,
                    FTViaCode
                ) 
                SELECT 
                    DISTINCT
                    HDBch.FTXthBchTo AS FTBchCode,
                    'WAIT-' + HDBch.FTXthWahFrm AS FTXthDocNo,
                    HD.FTXthCtrName AS FTXthCtrName,
                    HD.FDXthTnfDate AS FDXthTnfDate,
                    HD.FTXthRefInt AS FTXthRefTnfID,
                    HD.FTXthRefExt AS FTXthRefVehID,
                    0 AS FTXthQtyAndTypeUnit,
                    0 AS FNXthShipAdd,
                    HD.FTViaCode AS FTViaCode
                FROM TCNTPdtTwsHDBch HDBch WITH(NOLOCK)
                INNER JOIN TCNTPdtTwsHD HD WITH(NOLOCK) ON HDBch.FTXthDocNo = HD.FTXthDocNo AND HD.FTBchCode = HDBch.FTBchCode
                WHERE HDBch.FTXthDocNo = '$tDocumentnumber'
                  AND HDBch.FTXthStaTnf = '1'
                  AND HDBch.FTXthRefInt = 'WAIT-APPROVED' ";
        $this->db->query($tSQL);
    }
    
    //อัพเดทเลขที่เอกสารของใบโอนสินค้าระหว่างคลัง
    public function FSaMRVDUpdateDocument_wahouseHD($tOldDocumentHD,$tOldDocumentDT,$tNewDocument,$tWahouseFrm){
        //Update HD
        $this->db->set('FTXthDocNo', $tNewDocument);
        $this->db->where('FTXthDocNo',$tOldDocumentHD);
        $this->db->update('TCNTPdtTwxHD');

        //Update DT
        $this->db->set('FTXthDocNo', $tNewDocument);
        $this->db->where('FTXthDocNo',$tOldDocumentDT);
        $this->db->update('TCNTPdtTwxDT');

        //Update HDRef
        $this->db->set('FTXthDocNo', $tNewDocument);
        $this->db->where('FTXthDocNo',$tOldDocumentHD);
        $this->db->update('TCNTPdtTwxHDRef');

        //Update เอกสารใบเติมสินค้าชุด HDRef
        $this->db->set('FTXthRefInt', $tNewDocument);
        $this->db->where('FTXthRefInt','WAIT-APPROVED');
        $this->db->where('FTXthStaTnf','1');
        $this->db->where('FTXthWahFrm', $tWahouseFrm);
        $this->db->update('TCNTPdtTwsHDBch');
    }

    //-------------------------------------------------------------------------------------------------------//

    //หาว่ามีกี่เอกสารที่ต้อง split ออกมาเป็นใบเติม
    public function FSaMRVDFind_document_topupvendingHD($tDocumentnumber){
        $tSQL = " SELECT HDBch.* , HD.* FROM TCNTPdtTwsHDBch HDBch  
                INNER JOIN TCNTPdtTwsHD HD ON HDBch.FTXthDocNo = HD.FTXthDocNo AND HD.FTBchCode = HDBch.FTBchCode
                WHERE HDBch.FTXthDocNo = '$tDocumentnumber'
                AND HDBch.FTXthStaTnf = 2
                AND HDBch.FTXthRefInt = 'WAIT-APPROVED' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult     = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //สร้างใบเติมสินค้า HD
    public function FSaMRVDInsert_topupvendingHD($tDocumentnumber){
        $dDate  = date('Y-m-d H:i:s' , strtotime('+ 2 minute'));
        $tSQL   = "INSERT INTO TVDTPdtTwxHD 
                (
                    FTBchCode ,
                    FTXthDocNo ,
                    FDXthDocDate ,
                    FTXthDocType ,
                    FTXthVATInOrEx ,
                    FTDptCode ,
                    FTXthMerCode ,
                    FTXthShopFrm ,
                    FTXthShopTo ,
                    FTXthPosFrm ,
                    FTXthPosTo ,
                    FTUsrCode ,
                    FTSpnCode ,
                    FTXthApvCode ,
                    FTXthRefExt ,
                    FDXthRefExtDate ,
                    FTXthRefInt ,
                    FDXthRefIntDate ,
                    FNXthDocPrint , 
                    FCXthTotal ,
                    FCXthVat ,
                    FCXthVatable ,
                    FTXthRmk ,
                    FTXthStaDoc ,
                    FTXthStaApv ,
                    FTXthStaPrcStk ,
                    FTXthStaDelMQ ,
                    FNXthStaDocAct ,
                    FNXthStaRef ,
                    FTRsnCode ,
                    FDLastUpdOn ,
                    FTLastUpdBy ,
                    FDCreateOn ,
                    FTCreateBy
                ) 
                SELECT 
                    HDBch.FTXthBchTo AS FTBchCode ,
                    'WAIT-' + HDBch.FTXthShopTo + HDBch.FTXthWahTo AS FTXthDocNo ,
                    '$dDate' AS FDXthDocDate ,
                    1 AS FTXthDocType ,
                    '' AS FTXthVATInOrEx ,
                    '' AS FTDptCode ,
                    SHP.FTMerCode AS FTXthMerCode ,
                    HDBch.FTXthShopTo AS FTXthShopFrm ,
                    HDBch.FTXthShopTo AS FTXthShopTo ,
                    HDBch.FTXthPosTo AS FTXthPosFrm ,
                    HDBch.FTXthPosTo AS FTXthPosTo ,
                    HD.FTUsrCode AS FTUsrCode ,
                    '' AS FTSpnCode ,
                    '' AS FTXthApvCode ,
                    NULL AS FTXthRefExt ,
                    NULL AS FDXthRefExtDate ,
                    '$tDocumentnumber' AS FTXthRefInt ,
                    '$dDate' AS FDXthRefIntDate ,
                    0 AS FNXthDocPrint , 
                    0 AS FCXthTotal ,
                    0 AS FCXthVat ,
                    0 AS FCXthVatable ,
                    'สร้างเอกสารจากใบเติมสินค้าแบบชุด' AS FTXthRmk ,
                    1 AS FTXthStaDoc ,
                    '' AS FTXthStaApv ,
                    '' AS FTXthStaPrcStk ,
                    '' AS FTXthStaDelMQ ,
                    1 AS FNXthStaDocAct ,
                    0 AS FNXthStaRef ,
                    HD.FTRsnCode AS FTRsnCode ,
                    '$dDate' AS FDLastUpdOn ,
                    HD.FTLastUpdBy AS FTLastUpdBy ,
                    '$dDate' AS FDCreateOn ,
                    HD.FTCreateBy AS FTCreateBy
                FROM TCNTPdtTwsHDBch HDBch WITH(NOLOCK)
                INNER JOIN TCNTPdtTwsHD HD WITH(NOLOCK) ON HDBch.FTXthDocNo = HD.FTXthDocNo AND HD.FTBchCode = HDBch.FTBchCode
                LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HDBch.FTXthBchTo = SHP.FTBchCode AND SHP.FTShpCode = HDBch.FTXthShopTo AND SHP.FTShpType = '4'
                WHERE HDBch.FTXthDocNo = '$tDocumentnumber'
                  AND HDBch.FTXthStaTnf = '2'
                  AND HDBch.FTXthRefInt = 'WAIT-APPROVED' ";
        $this->db->query($tSQL);
    }

    //สร้างใบเติมสินค้า DT
    public function FSaMRVDInsert_topupvendingDT($tDocumentnumber){
        $nLngID = $this->session->userdata("tLangEdit");
        $tSesSessionID  = $this->session->userdata('tSesSessionID');
        $dDate  = date('Y-m-d H:i:s' , strtotime('+ 2 minute'));

        //เอาจำนวนทั้งหมดใน DT ไปฝากไว้ใน Temp ก่อน
        $tSQL   = "INSERT INTO TCNTDocDTTmp 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FTPdtCode,
                    FCXtdQty,
                    FTSessionID
                ) 
                SELECT 
                    DT.FTBchCode        AS FTBchCode,
                    'PDT_QTY'           AS FTXthDocNo,
                    DT.FTPdtCode        AS FTPdtCode,
                    DT.FCXtdQty         AS FCXtdQty,
                    '$tSesSessionID'    AS FTSessionID
                FROM TCNTPdtTwsDT DT  
                WHERE DT.FTXthDocNo = '$tDocumentnumber' ";
        $this->db->query($tSQL);

        //ต้องทำใบเติมสินค้า โดยชั้น และช่องนั้น ต้องยังไม่เต็มด้วยถึงจะเติมได้
        $tSQL   = "INSERT INTO TVDTPdtTwxDT 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FNXtdSeqNo,
                    FNCabSeq,
                    FNLayRow,
                    FNLayCol,
                    FTPdtCode,
                    FCXtdQty,
                    FTXthWhFrm,
                    FTXthWhTo
                ) 
                SELECT 
                        HDBch.FTXthBchTo AS FTBchCode,
                        'WAIT-' + HDBch.FTXthShopTo + HDBch.FTXthWahTo AS FTXthDocNo,
                        LTRIM(LAYOUT.FNLayRow) + LTRIM(LAYOUT.FNLayCol) AS FNXtdSeqNo,
                        LAYOUT.FNCabSeq AS FNCabSeq,
                        LAYOUT.FNLayRow AS FNLayRow,
                        LAYOUT.FNLayCol AS FNLayCol,
                        DT.FTPdtCode AS FTPdtCode,
                        DT.FCXtdQty AS FCXtdQty,
                        HDBch.FTXthWahFrm AS FTXthWhFrm,
                        HDBch.FTXthWahTo AS FTXthWhTo 
                FROM TCNTPdtTwsDT DT  
                LEFT JOIN TCNTPdtTwsHDBch HDBch ON DT.FTXthDocNo = HDBch.FTXthDocNo AND FTXthStaTnf = 2 AND FTXthRefInt = 'WAIT-APPROVED'
                INNER JOIN TCNMShop SHP  ON HDBch.FTXthBchTo = SHP.FTBchCode AND SHP.FTShpCode = HDBch.FTXthShopTo AND SHP.FTShpType = 4
                LEFT JOIN TVDMPdtLayout LAYOUT ON HDBch.FTXthBchTo = LAYOUT.FTBchCode AND HDBch.FTXthShopTo = LAYOUT.FTShpCode AND DT.FTPdtCode = LAYOUT.FTPdtCode AND LAYOUT.FTPdtCode != ''
                INNER JOIN TCNMPdt PDT ON PDT.FTPdtCode = DT.FTPdtCode
                WHERE DT.FTXthDocNo = '$tDocumentnumber' AND LAYOUT.FNLayRow != '' 
                AND DT.FCXtdQty != 0 ";
        $this->db->query($tSQL);
    }

    //สร้างใบเติมสินค้า HDRef
    public function FSaMRVDInsert_topupvendingHDRef($tDocumentnumber){
        $nLngID = $this->session->userdata("tLangEdit");
        $tUser  = $this->session->userdata('tSesUsername');
        $dDate  = date('Y-m-d H:i:s' , strtotime('+ 2 minute'));

        //ต้องทำใบเติมสินค้า โดยชั้น และช่องนั้น ต้องยังไม่เต็มด้วยถึงจะเติมได้
        $tSQL   = "INSERT INTO TVDTPdtTwxHDRef 
                ( 
                    FTBchCode,
                    FTXthDocNo,
                    FTXthCtrName,
                    FDXthTnfDate,
                    FTXthRefTnfID,
                    FTXthRefVehID,
                    FTXthQtyAndTypeUnit,
                    FNXthShipAdd,
                    FTViaCode
                ) 
                SELECT 
                    HDBch.FTXthBchTo AS FTBchCode,
                    'WAIT-' + HDBch.FTXthShopTo + HDBch.FTXthWahTo AS FTXthDocNo,
                    HD.FTXthCtrName AS FTXthCtrName,
                    HD.FDXthTnfDate AS FDXthTnfDate,
                    HD.FTXthRefInt AS FTXthRefTnfID,
                    HD.FTXthRefExt AS FTXthRefVehID,
                    0 AS FTXthQtyAndTypeUnit,
                    0 AS FNXthShipAdd,
                    HD.FTViaCode AS FTViaCode
                FROM TCNTPdtTwsHDBch HDBch  
                INNER JOIN TCNTPdtTwsHD HD ON HDBch.FTXthDocNo = HD.FTXthDocNo AND HD.FTBchCode = HDBch.FTBchCode
                WHERE HDBch.FTXthDocNo = '$tDocumentnumber'
                AND HDBch.FTXthStaTnf = 2
                AND HDBch.FTXthRefInt = 'WAIT-APPROVED' ";
        $this->db->query($tSQL);
    }

    //อัพเดทเลขที่เอกสารของใบเติมสินค้า
    public function FSaMRVDUpdateDocument_topupvendingHD($tOldDocumentHD,$tOldDocumentDT,$tNewDocument,$tWahouseTo,$dDateRealTime){
        $tUser  = $this->session->userdata('tSesUsername');
        
        //Update HD
        $this->db->set('FDCreateOn', $dDateRealTime);
        $this->db->set('FTXthDocNo', $tNewDocument);
        $this->db->where('FTXthDocNo',$tOldDocumentHD);
        $this->db->update('TVDTPdtTwxHD');

        //Update DT
        $this->db->set('FTXthDocNo', $tNewDocument);
        $this->db->where('FTXthDocNo',$tOldDocumentDT);
        $this->db->update('TVDTPdtTwxDT');

        //อัพเดท Seq ใหม่ที่เอกสารใบเติม DT
        $tSQLSel   = "SELECT * FROM TVDTPdtTwxDT DT WHERE DT.FTXthDocNo = '$tNewDocument' ";
        $oQuery    = $this->db->query($tSQLSel);
        if ($oQuery->num_rows() > 0) {
            $oList  = $oQuery->result_array();
            $nSeq   = 1;
            for($j=0; $j<FCNnHSizeOf($oList); $j++){
                $nSeqOld = $oList[$j]['FNLayRow'] . $oList[$j]['FNLayCol'];
                $this->db->set('FNXtdSeqNo', $nSeq);
                $this->db->where('FTXthDocNo', $tNewDocument);
                $this->db->where('FNXtdSeqNo', $nSeqOld);
                $this->db->update('TVDTPdtTwxDT');
                $nSeq++;
            }
        }

        //Update HDRef
        $this->db->set('FTXthDocNo', $tNewDocument);
        $this->db->where('FTXthDocNo',$tOldDocumentHD);
        $this->db->update('TVDTPdtTwxHDRef');

        //Update เอกสารใบเติมสินค้าชุด HDRef
        $this->db->set('FTXthRefInt', $tNewDocument);
        $this->db->where('FTXthRefInt','WAIT-APPROVED');
        $this->db->where('FTXthStaTnf','2');
        $this->db->where('FTXthWahTo', $tWahouseTo);
        $this->db->update('TCNTPdtTwsHDBch');
    }

    //อัพเดท QTY ให้ล่าสุด - ของเอกสารใบโอนสินค้าระหว่างคลัง
    public function FSaMRVDUpdateQTYIn_tranferwahouseDT($tDocTranferwahouseFull){

        //หาข้อมูลใน DT
        $tSQLSel    = "SELECT PDT.FCLayColQtyMax , HD.FTXthDocNo , HD.FTXthWhFrm , DT.FNXtdSeqNo  , DT.FTPdtCode , DT.FCXtdQty , DT.FCXtdQtyAll  
                        FROM TCNTPdtTwxDT DT 
                        LEFT JOIN TCNTPdtTwxHD 	HD ON DT.FTXthDocNo = HD.FTXthDocNo AND DT.FTBchCode = HD.FTBchCode
                        LEFT JOIN TVDMPdtLayout PDT ON PDT.FTPdtCode = DT.FTPdtCode AND PDT.FTBchCode = HD.FTBchCode AND PDT.FTWahCode = HD.FTXthWhFrm
                        WHERE DT.FTXthDocNo IN($tDocTranferwahouseFull) ORDER BY DT.FTXthDocNo , DT.FTPdtCode ASC ";
        $oQuery     = $this->db->query($tSQLSel);
        $oList      = $oQuery->result_array();
        if ($oQuery->num_rows() > 0) {
            for($j=0; $j<FCNnHSizeOf($oList); $j++){
                $nQty           = $oList[$j]['FCLayColQtyMax'];
                $tDocNo         = $oList[$j]['FTXthDocNo'];
                $tPDTCode       = $oList[$j]['FTPdtCode'];
                $nSeq           = $oList[$j]['FNXtdSeqNo'];

                //Update QTY
                $this->db->set('FCXtdQty', $nQty);
                $this->db->set('FCXtdQtyAll', $nQty);
                $this->db->where('FTXthDocNo', $tDocNo);
                $this->db->where('FTPdtCode', $tPDTCode);
                $this->db->where('FNXtdSeqNo', $nSeq);
                $this->db->update('TCNTPdtTwxDT'); 
            }
        }
    }

    //เช็คสถานะ การเติม ว่าต้องเช็คกับสต๊อกไหม
    public function FSaMRVDCheck_flagSTK($tDocument){
        $tSQL       = "SELECT FTXthStaChkBal FROM TCNTPdtTwsHD HD WHERE HD.FTXthDocNo = '$tDocument' ";
        $oQuery     = $this->db->query($tSQL);
        $oList      = $oQuery->result_array();
        return $oList;
    }

    //ตรวจสอบสต๊อกว่า เลือกสต๊อกพอไหม
    public function FSaMRVDCheckSTKWhenAPV($tDocumentNumber){
        $tSQL       = "SELECT 
                        Tmp.FTPdtCode ,
                        CASE
                            WHEN Tmp.FCXtdQty < Tmp.FCXtdAmt THEN 'PRORATE'
                            ELSE 'FULL' 
                        END AS FCXtdQty 
                        FROM TCNTDocDTTmp Tmp 
                        INNER JOIN TCNTPdtTwsDT DT ON Tmp.FTPdtCode = DT.FTPdtCode AND Tmp.FTBchCode = DT.FTBchCode AND Tmp.FTXthDocNo  = DT.FTXthDocNo 
                        WHERE Tmp.FTXthDocKey = 'TCNTPdtTwsDT'
                        AND Tmp.FTXthDocNo IN ('REFILLPDTSET-VD','$tDocumentNumber')
                        AND Tmp.FTSessionID = '".$this->session->userdata('tSesSessionID')."' ";
        $oQuery     = $this->db->query($tSQL);
        $oList      = $oQuery->result_array();
        return $oList;
    }

    function findObjectById($id){
        $array = array();
        foreach ( $array as $element ) {
            if ( $id == $element->PDT ) {
                return $element;
            }
        }
        return false;
    }

    //อัพเดท QTY ให้ล่าสุด - ของใบเติม
    public function FSaMRVDUpdateQTYIn_topupvendingDT($tDocTopUpFull,$tFlagSTKAVG,$tDocumentNumber){
        $nQty      = 0;
        if($tFlagSTKAVG == 'PASS'){ //เช็คสต๊อก
            //Move จากใน DTPos ไปที่ DT ของใบเติม
            $tUPD = "UPDATE
                        TVDTPdtTwxDT
                    SET
                        TVDTPdtTwxDT.FCXtdQty = TCNTPdtTwsDTPos.FCXtdQty
                    FROM
                        TVDTPdtTwxDT AS TVDTPdtTwxDT
                        INNER JOIN TCNTPdtTwsDTPos AS TCNTPdtTwsDTPos 
                            ON  TVDTPdtTwxDT.FTBchCode = TCNTPdtTwsDTPos.FTBchCode
                            AND TVDTPdtTwxDT.FTPdtCode = TCNTPdtTwsDTPos.FTPdtCode
                            AND TVDTPdtTwxDT.FNLayRow = TCNTPdtTwsDTPos.FNLayRow
                            AND TVDTPdtTwxDT.FNLayCol = TCNTPdtTwsDTPos.FNLayCol
                            AND TCNTPdtTwsDTPos.FTXthDocNo = '$tDocumentNumber'
                        INNER JOIN TCNMWaHouse AS TCNMWaHouse
                            ON TCNTPdtTwsDTPos.FTPosCode = TCNMWaHouse.FTWahRefCode 
                            AND TCNTPdtTwsDTPos.FTBchCode = TCNMWaHouse.FTBchCode
                            AND TVDTPdtTwxDT.FTXthWhTo = TCNMWaHouse.FTWahCode
                            AND TCNMWaHouse.FTWahStaType = 6
                    WHERE
                        TVDTPdtTwxDT.FTXthDocNo IN($tDocTopUpFull) ";
            $this->db->query($tUPD);

            // ลบข้อมูลใน Temp
            $this->db->where_in('FTXthDocNo', 'PDT_QTY');
            $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
            $this->db->delete('TCNTDocDTTmp');

        }else{ //ไม่ต้องเช็คสต๊อก insert ลงได้เลย
            $tSQL = "   UPDATE TVDTPdtTwxDT
                        SET TVDTPdtTwxDT.FCXtdQty = (LAY.FCLayColQtyMax - ISNULL(STKBAL.FCStkQty,0))
                        --SELECT 
                        --	DT.FTXthDocNo,
                        --	DT.FTPdtCode,
                        --	TMP.FCXtdQty,
                        --	LAY.FCLayColQtyMax, 
                        --	STKBAL.FCStkQty,
                        --	(LAY.FCLayColQtyMax - ISNULL(STKBAL.FCStkQty,0)) AS FCRefill
                        FROM TVDTPdtTwxDT DT 
                        INNER JOIN TVDTPdtTwxHD HD ON DT.FTXthDocNo = HD.FTXthDocNo AND DT.FTBchCode = HD.FTBchCode
                        LEFT JOIN TCNTDocDTTmp TMP ON TMP.FTXthDocNo = 'PDT_QTY' AND DT.FTPdtCode = TMP.FTPdtCode AND TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                        LEFT JOIN TVDMPdtLayout LAY ON LAY.FTBchCode = DT.FTBchCode AND LAY.FTShpCode = HD.FTXthShopFrm 
                            AND LAY.FNCabSeq = DT.FNCabSeq AND LAY.FNLayRow = DT.FNLayRow 
                            AND LAY.FNLayCol = DT.FNLayCol AND LAY.FTPdtCode = DT.FTPdtCode
                        LEFT JOIN TVDTPdtStkBal STKBAL ON STKBAL.FTBchCode = LAY.FTBchCode AND STKBAL.FNCabSeq = LAY.FNCabSeq 
                            AND STKBAL.FNLayRow = LAY.FNLayRow AND STKBAL.FNLayCol = LAY.FNLayCol  
                            AND STKBAL.FTPdtCode = LAY.FTPdtCode AND DT.FTXthWhTo = STKBAL.FTWahCode   
                        WHERE DT.FTXthDocNo IN ($tDocTopUpFull)  ";
            $this->db->query($tSQL);
            //หาข้อมูลใน DT
            // $tSQLSel   = "  SELECT 
            //                     DT.*, 
            //                     LAY.FCLayColQtyMax, 
            //                     STKBAL.FCStkQty 
            //                 FROM TVDTPdtTwxDT       DT  WITH(NOLOCK)
            //                 INNER JOIN TVDTPdtTwxHD HD  WITH(NOLOCK) ON DT.FTXthDocNo = HD.FTXthDocNo AND DT.FTBchCode = HD.FTBchCode
            //                 LEFT JOIN TVDMPdtLayout LAY WITH(NOLOCK) ON LAY.FTBchCode = DT.FTBchCode 
            //                     AND LAY.FNCabSeq = DT.FNCabSeq 
            //                     AND LAY.FNLayRow = DT.FNLayRow 
            //                     AND LAY.FNLayCol = DT.FNLayCol
            //                     AND LAY.FTPdtCode = DT.FTPdtCode
            //                 LEFT JOIN TVDTPdtStkBal STKBAL WITH(NOLOCK) ON STKBAL.FTBchCode = LAY.FTBchCode 
            //                     AND STKBAL.FNCabSeq = LAY.FNCabSeq 
            //                     AND STKBAL.FNLayRow = LAY.FNLayRow  
            //                     AND STKBAL.FNLayCol = LAY.FNLayCol  
            //                     AND STKBAL.FTPdtCode = LAY.FTPdtCode   
            //                     AND DT.FTXthWhTo = STKBAL.FTWahCode   
            //                 WHERE DT.FTXthDocNo IN($tDocTopUpFull) 
            //                 ORDER BY DT.FTXthDocNo , DT.FTPdtCode ASC ";
            // // echo "<pre>";
            // // echo $tSQLSel."<br>";
            // $oQuery    = $this->db->query($tSQLSel);
            // if ($oQuery->num_rows() > 0) {
            //     //หาข้อมูลใน Temp
            //     $tSQLTemp       = "SELECT * FROM TCNTDocDTTmp Temp WITH(NOLOCK) WHERE Temp.FTXthDocNo = 'PDT_QTY' ORDER BY Temp.FTPdtCode ASC";
            //     // echo $tSQLTemp."<br>";
            //     $oQueryTemp     = $this->db->query($tSQLTemp);
            //     $oListTemp      = $oQueryTemp->result_array();
            //     $oList          = $oQuery->result_array();
            //     // print_r($oListTemp);
            //     // print_r($oList);
    
            //     for($j=0; $j<FCNnHSizeOf($oList); $j++){
            //         $tDT_PDTCode    = $oList[$j]['FTPdtCode'];
            //         $tDT_DocNo      = $oList[$j]['FTXthDocNo'];
            //         $tDT_Seq        = $oList[$j]['FNXtdSeqNo'];
            //         $tDT_MaxQty     = intval($oList[$j]['FCLayColQtyMax']) - intval($oList[$j]['FCStkQty']);
    
            //         for($h=0; $h<FCNnHSizeOf($oListTemp); $h++){
            //             $tTemp_PDTCode  = $oListTemp[$h]['FTPdtCode'];
    
            //             // echo 'DT : ' . $tDT_PDTCode. ' - TMP : ' . $tTemp_PDTCode;
            //             //วนลูปจนได้สินค้าตัวเดียวกัน
            //             if($tDT_PDTCode == $tTemp_PDTCode){
            //                 //เช็คจำนวนเติมสูงสุด
            //                 if( $oListTemp[$h]['FCXtdQty']  > $tDT_MaxQty){
            //                     $nQty  = $tDT_MaxQty;
            //                 }else{
            //                     $nQty  = $oListTemp[$h]['FCXtdQty'];
            //                 }
            //                 $this->db->set('FCXtdQty', $nQty);
            //                 $this->db->where('FTXthDocNo', $tDT_DocNo);
            //                 $this->db->where('FNXtdSeqNo', $tDT_Seq);
            //                 $this->db->update('TVDTPdtTwxDT'); 
            //                 echo $this->db->last_query()."<br><br>";
            //                 // echo  ' เติมได้สูงสุด : ' . $tDT_MaxQty  . ' เติมไป : ' .  $nQty . ' ชิ้น ' . "\n";
            //                 $oListTemp[$h]['FCXtdQty'] = $oListTemp[$h]['FCXtdQty'] - $nQty;
            //             }else{
            //                 // echo "\n";
            //                 $nQty = 0;
            //             }
            //         };
            //         // echo "\n";
            //     }
            // }
    
            // ลบข้อมูลใน Temp
            $this->db->where_in('FTXthDocNo', 'PDT_QTY');
            $this->db->where_in('FTSessionID',$this->session->userdata('tSesSessionID'));
            $this->db->delete('TCNTDocDTTmp');
        }
    }

    // เช็คว่าถ้าเอกสารไหน มีการเติมเป็น 0 ทั้งเอกสาร จะต้องลบ TVDTPdtTwxDT TVDTPdtTwxHD TVDTPdtTwxHDRef และ TCNTPdtTwsHDBch
    public function FSaMRVDCheckQtyIn_topupvendingDT($tDocTopUpFull){
        $tDocument = str_replace("'"," ",$tDocTopUpFull);
        $aDocument = explode(',',$tDocument);
        $nDocument = FCNnHSizeOf($aDocument);
        if($nDocument == 1){

        }else{
            for($i=0; $i<$nDocument; $i++){
                $tDocumentFull  = trim($aDocument[$i]);

                //ถ้าเอกสารนั้นเป็น 0 ทั้งเอกสาร
                $tSQL           = "SELECT SUM(FCXtdQty) AS FCXtdQty , FTXthDocNo FROM TVDTPdtTwxDT DT WHERE DT.FTXthDocNo = '$tDocumentFull' GROUP BY FTXthDocNo ";
                $oQuery         = $this->db->query($tSQL);
                $oList          = $oQuery->result_array();
                if($oList[0]['FCXtdQty'] == 0){

                    $tDocumentFull = $oList[0]['FTXthDocNo'];

                    //TVDTPdtTwxDT
                    $this->db->where_in('FTXthDocNo',$tDocumentFull);
                    $this->db->delete('TVDTPdtTwxDT');

                    //TVDTPdtTwxHD
                    $this->db->where_in('FTXthDocNo',$tDocumentFull);
                    $this->db->delete('TVDTPdtTwxHD');

                    //TVDTPdtTwxHDRef
                    $this->db->where_in('FTXthDocNo',$tDocumentFull);
                    $this->db->delete('TVDTPdtTwxHDRef');

                    //TCNTPdtTwsHDBch
                    $this->db->where_in('FTXthRefInt',$tDocumentFull);
                    $this->db->where_in('FTXthStaTnf',2);
                    $this->db->delete('TCNTPdtTwsHDBch');
                }else{
                    // ลบรายการสินค้าที่มีจำนวนการเติม = 0 ในใบเติมสินค้า (ตู้สินค้า)
                    $this->db->where('FCXtdQty',0);
                    $this->db->where('FTXthDocNo',$tDocumentFull);
                    $this->db->delete('TVDTPdtTwxDT');

                    // เรียง Seq ใหม่ ในใบเติมสินค้า (ตู้สินค้า)
                    $tSQLUpd = "UPDATE TVDTPdtTwxDT WITH(ROWLOCK)
                                    SET FNXtdSeqNo = x.NewSeq 
                                FROM TVDTPdtTwxDT DT 
                                INNER JOIN (
                                SELECT 
                                    ROW_NUMBER() OVER (ORDER BY FNXtdSeqNo) AS NewSeq,
                                    FNXtdSeqNo AS FNXtdSeqNo_x
                                    FROM TVDTPdtTwxDT AS y
                                    WHERE FTXthDocNo = '$tDocumentFull'
                                ) x ON DT.FNXtdSeqNo = x.FNXtdSeqNo_x
                                WHERE FTXthDocNo = '$tDocumentFull' ";
                    $this->db->query($tSQLUpd);
                }
            }
        }
    }
}

