<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mTransferVendingOut extends CI_Model
{

    /**
     * Functionality : HD List
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : HD List
     * Return Type : Array
     */
    public function FSaMTVOHDList($paParams = []){
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        HD.*,
                        BCHL.FTBchName,
                        USRL.FTUsrName AS FTCreateByName,
                        USRLAPV.FTUsrName AS FTXthApvName
                    FROM TVDTPdtTwxHD HD WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON HD.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                    WHERE 1=1 AND FTXthDocType='2'
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND HD.FTBchCode IN($tBchCode)
            ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];

        $tSearchList = $aAdvanceSearch['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTXthDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
            $tSQL .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }


        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(HD.FTXthStaApv,'') = '' AND HD.FTXthStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND HD.FTXthStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (HD.FTXthStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(HD.FTXthStaPrcStk,'') = '') ";
            } else {
                $tSQL .= " AND HD.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND HD.FNXthStaDocAct = 1";
            } else {
                $tSQL .= " AND HD.FNXthStaDocAct = 0";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMHDListGetPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
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
     * Functionality : Count HD Row
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count Row
     * Return Type : Number
     */
    public function FSnMHDListGetPageAll($paParams = [])
    {
        $nLngID = $paParams['FNLngID'];
        $tSQL = "
            SELECT 
                HD.FTXthDocNo
            FROM TVDTPdtTwxHD HD WITH (NOLOCK)
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON HD.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
            WHERE 1=1 AND FTXthDocType='2'
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND HD.FTBchCode IN($tBchCode)
            ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];

        $tSearchList = $aAdvanceSearch['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTXthDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
            $tSQL .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(HD.FTXthStaApv,'') = '' AND HD.FTXthStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND HD.FTXthStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (HD.FTXthStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(HD.FTXthStaPrcStk,'') = '') ";
            } else {
                $tSQL .= " AND HD.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND HD.FNXthStaDocAct = 1";
            } else {
                $tSQL .= " AND HD.FNXthStaDocAct = 0";
            }
        }

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    // ข้อมูลของริษัท
    public function FStTFWGetShpCodeForUsrLogin($paParams = [])
    {
        $nLngID     = $paParams['FNLngID'];
        $tUsrLogin  = $paParams['tUsrLogin'];

        $tSQL = "
            SELECT UGP.FTBchCode,
                BCHL.FTBchName,
                MCHL.FTMerCode,
                MCHL.FTMerName,
                UGP.FTShpCode,
                SHPL.FTShpName,
                SHP.FTShpType,
                SHP.FTWahCode AS FTWahCode,
                WAHL.FTWahName AS FTWahName
                /* BCH.FTWahCode AS FTWahCode_Bch, 
                BWAHL.FTWahName AS FTWahName_Bch  */
                        
            FROM TCNTUsrGroup UGP WITH (NOLOCK)
            LEFT JOIN TCNMBranch  BCH WITH (NOLOCK) ON UGP.FTBchCode = BCH.FTBchCode 
            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON UGP.FTBchCode = BCHL.FTBchCode 
            /* LEFT JOIN TCNMWaHouse_L BWAHL ON BCH.FTWahCode = BWAHL.FTWahCode */
            LEFT JOIN TCNMShop      SHP WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode AND BCH.FTBchCode = SHP.FTBchCode
            LEFT JOIN TCNMMerchant_L  MCHL WITH (NOLOCK) ON SHP.FTMerCode = MCHL.FTMerCode AND  MCHL.FNLngID = '" . $nLngID . "'
            LEFT JOIN TCNMShop_L    SHPL WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = '" . $nLngID . "'
            LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode AND BCH.FTBchCode = WAHL.FTBchCode
            WHERE FTUsrCode = '$tUsrLogin'
        ";

        $aResult = [];

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array();
        }

        return $aResult;
    }

    /**
     * Functionality : Get PDT Layout in Temp
     * Parameters : -
     * Creator : 08/09/2020 Napat(Jame)
     * Last Modified : 17/12/2020 Napat(Jame)
     * Return : Data List Product Layout
     * Return Type : Array
     */
    public function FSaMTVOGetPdtLayoutInTmp($paParams){
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID         = $paParams['FNLngID'];
        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCabSeqForTWXVD ASC, FNLayRowForTWXVD ASC, FNLayColForTWXVD ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTXthDocNo,
                        TMP.FNXtdSeqNo,
                        TMP.FTXthDocKey,
                        TMP.FTPdtCode,
                        TMP.FTXtdPdtName,
                        TMP.FNCabSeqForTWXVD,
                        TMP.FTCabNameForTWXVD,
                        TMP.FNLayRowForTWXVD,
                        TMP.FNLayColForTWXVD,
                        TMP.FTXthWhToForTWXVD,
                        WAHL.FTWahName,
                        TMP.FCStkQty,
                        TMP.FCXtdQty,
                        TMP.FCLayColQtyMaxForTWXVD,
                        TMP.FTSessionID
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    LEFT JOIN TCNMWaHouse_L WAHL ON TMP.FTBchCode = WAHL.FTBchCode AND TMP.FTXthWhToForTWXVD = WAHL.FTWahCode AND FNLngID = $nLngID
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND TMP.FTXthDocKey = 'TVDTPdtTwxHD'
        ";

        //FCStkQty = คงเหลือล่าสุด	
        //FCXtdQty = จำนวนเติม
        if($paParams['tTypePage'] == 'docTVOEventAdd'){
            //แสดงเฉพาะสินค้าที่มีในสต็อก
            if($paParams['tStaShwPdtInStk'] == 'true'){
                $tSQL .= " AND TMP.FCStkQty != 0 ";
            }
        }

        $tSearchList = $paParams['tSearchAll'];

        if ($tSearchList != '') {
            $tSQL .= " AND ((TMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTCabNameForTWXVD COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        $tSQL .= ") Base) AS c ";
        $oQuery = $this->db->query($tSQL);

        // echo $tSQL;
        // exit;

        // Create By : Napat(Jame) 17/12/2020
        $tSQLAllPdt = " SELECT DISTINCT FTPdtCode 
                        FROM TCNTDocDTTmp TMP WITH(NOLOCK) 
                        WHERE TMP.FTSessionID = '$tUserSessionID'
                          AND TMP.FTXthDocKey = 'TVDTPdtTwxHD'
                      ";
        $oQueryAllPdt = $this->db->query($tSQLAllPdt);

        
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'tSQL'          => $tSQL,
                'raItems'       => $oQuery->result(),
                'aAllItemsInDB' => $oQueryAllPdt->result(), // Create By : Napat(Jame) 17/12/2020
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'tSQL'          => $tSQL,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Get HD Detail
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Detail
     * Return Type : Array
     */
    public function FSaMTVOGetHD($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];

        $tSQL = "
            SELECT
                TWXVD.FTBchCode,
                BCHL.FTBchName,
                TWXVD.FTXthDocNo,
                TWXVD.FDXthDocDate,
                convert(CHAR(5), TWXVD.FDXthDocDate, 108)  AS FTXthDocTime,
                TWXVD.FTDptCode,
                DPTL.FTDptName,
                TWXVD.FTXthMerCode,
                MCHL.FTMerName,
                TWXVD.FTXthShopFrm,
                FSHP.FTShpType AS FTShpTypeFrm,
                FSHPL.FTShpName AS FTShpNameFrm,
                TWXVD.FTXthPosFrm,
                POSL.FTPosName AS FTPosComNameF,
                TWXVD.FTXthShopTo,
                TSHP.FTShpType AS FTShpTypeTo,
                TSHPL.FTShpName AS FTShpNameTo,
                TWXVD.FTXthPosTo,
                POSL.FTPosName AS FTPosComNameT,
                WAH.FTWahCode   AS FTWahCodeFrm,
                WAHL.FTWahName  AS FTWahNameFrm,
                TWXVD.FTUsrCode,
                TWXVD.FTSpnCode,
                TWXVD.FTXthApvCode,
                TWXVD.FTXthRefExt,
                TWXVD.FDXthRefExtDate,
                TWXVD.FTXthRefInt,
                TWXVD.FDXthRefIntDate,
                TWXVD.FNXthDocPrint,
                TWXVD.FCXthTotal,
                TWXVD.FTXthRmk,
                TWXVD.FTXthStaDoc,
                TWXVD.FTXthStaApv,
                TWXVD.FTXthStaPrcStk,
                TWXVD.FTXthStaDelMQ,
                TWXVD.FNXthStaDocAct,
                TWXVD.FNXthStaRef,
                TWXVD.FTRsnCode,
                TWXVD.FDLastUpdOn,
                TWXVD.FTLastUpdBy,
                TWXVD.FDCreateOn,
                TWXVD.FTCreateBy,
                USRL.FTUsrName,
                USRAPV.FTUsrName AS FTUsrNameApv
            FROM TVDTPdtTwxHD TWXVD WITH (NOLOCK)

            LEFT JOIN TCNMWaHouse       WAH WITH (NOLOCK)   ON TWXVD.FTBchCode = WAH.FTBchCode AND TWXVD.FTXthPosFrm = WAH.FTWahRefCode AND WAH.FTWahStaType = '6'
            LEFT JOIN TCNMWaHouse_L    WAHL WITH (NOLOCK)   ON TWXVD.FTBchCode = WAHL.FTBchCode AND WAH.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
            LEFT JOIN TCNMBranch_L     BCHL WITH (NOLOCK)   ON TWXVD.FTBchCode   = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMMerchant_L   MCHL WITH (NOLOCK)   ON TWXVD.FTXthMerCode = MCHL.FTMerCode AND MCHL.FNLngID = $nLngID
            LEFT JOIN TCNMPos_L        POSL WITH (NOLOCK)   ON TWXVD.FTXthPosTo  = POSL.FTPosCode AND POSL.FTBchCode = TWXVD.FTBchCode  AND POSL.FNLngID = $nLngID

            /* ต้นทาง */
            LEFT JOIN TCNMShop         FSHP WITH (NOLOCK)   ON TWXVD.FTXthShopFrm = FSHP.FTShpCode AND TWXVD.FTBchCode = FSHP.FTBchCode
            LEFT JOIN TCNMShop_L       FSHPL WITH (NOLOCK)  ON TWXVD.FTXthShopFrm = FSHPL.FTShpCode AND TWXVD.FTBchCode = FSHPL.FTBchCode AND FSHPL.FNLngID = $nLngID
            LEFT JOIN TVDMPosShop      PSHPLF WITH (NOLOCK) ON TWXVD.FTXthShopFrm = PSHPLF.FTShpCode AND TWXVD.FTBchCode = PSHPLF.FTBchCode

            /* ปลายทาง */
            LEFT JOIN TCNMShop         TSHP WITH (NOLOCK)   ON TWXVD.FTXthShopTo = TSHP.FTShpCode AND TWXVD.FTBchCode = TSHP.FTBchCode
            LEFT JOIN TCNMShop_L       TSHPL WITH (NOLOCK)  ON TWXVD.FTXthShopTo = TSHPL.FTShpCode AND TWXVD.FTBchCode = TSHPL.FTBchCode AND TSHPL.FNLngID = $nLngID
            LEFT JOIN TVDMPosShop      PSHPLT WITH (NOLOCK) ON TWXVD.FTXthShopTo = PSHPLT.FTShpCode AND TWXVD.FTBchCode = PSHPLT.FTBchCode
            
            LEFT JOIN TCNMUser_L       USRL WITH (NOLOCK)   ON TWXVD.FTCreateBy   = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L       USRAPV WITH (NOLOCK) ON TWXVD.FTXthApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
            LEFT JOIN TCNMUsrDepart_L  DPTL WITH (NOLOCK)   ON TWXVD.FTDptCode = DPTL.FTDptCode AND DPTL.FNLngID = $nLngID
            WHERE 1=1
        ";

        if ($tDocNo != "") {
            $tSQL .= " AND TWXVD.FTXthDocNo = '$tDocNo' ";
        }

        // echo $tSQL;exit;
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItems' => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
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

    /**
     * Functionality : Get WahCode by RefCode
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : WahCode
     * Return Type : String
     */
    public function FStMGetWahCodeByRefCode($paParams = [])
    {
        $tRefCode = $paParams['tRefCode'];
        $tBCHCode = $paParams['tBCHCode'];

        $tSQL = "
            SELECT
                FTWahCode
            FROM TCNMWaHouse WITH(NOLOCK)   
            WHERE FTWahRefCode = '$tRefCode' AND FTBchCode = '$tBCHCode' AND FTWahStaType = '6'
        ";

        $oQuery = $this->db->query($tSQL);
        $oRow = $oQuery->row();

        $tResult = '';

        if (isset($oRow)) {
            $tResult = $oRow->FTWahCode;
        }

        return $tResult;
    }

    /**
     * Functionality : Get Wah by RefCode
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Wah Data
     * Return Type : Array
     */
    public function FSaMGetWahByRefCode($paParams = [])
    {
        $tRefCode = $paParams['tRefCode'];
        $tBchCode = $paParams['tBchCode'];

        $tSQL = "
            SELECT
                WAH.FTWahCode,
                WAHL.FTWahName
            FROM TCNMWaHouse WAH WITH(NOLOCK)   
            LEFT JOIN TCNMWaHouse_L WAHL WITH(NOLOCK) ON WAHL.FTWahCode = WAH.FTWahCode AND WAH.FTBchCode = WAHL.FTBchCode
            WHERE WAH.FTWahRefCode = '$tRefCode' 
            AND WAH.FTBchCode = '$tBchCode'
            AND WAH.FTWahStaType = '4'
        ";

        $oQuery = $this->db->query($tSQL);

        $aResult = [];

        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->result_array();
        }

        return $aResult;
    }

    /**
     * Functionality : Get Wah in DT
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Wah Data
     * Return Type : Array
     */
    public function FSaMGetWahInDT($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $tBchCode = $paParams['tBchCode'];

        $tSQL = "
            SELECT DISTINCT
                DT.FTXthWhFrm AS FTWahCode,
                WAHL.FTWahName
            FROM TVDTPdtTwxDT DT WITH(NOLOCK) 
            LEFT JOIN TCNMWaHouse_L WAHL WITH(NOLOCK) ON WAHL.FTWahCode = DT.FTXthWhFrm AND DT.FTBchCode = WAHL.FTBchCode  
            WHERE DT.FTBchCode = '$tBchCode' 
            AND DT.FTXthDocNo = '$tDocNo'
        ";

        $oQuery = $this->db->query($tSQL);

        $aResult = [];

        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->result_array();
        }

        return $aResult;
    }

    /**
     * Functionality : Insert PDT Layout to Temp
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : 17/12/2020 Napat(Jame)
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTVOInsertPdtLayoutToTemp($paParams){
        $tDocNo             = empty($paParams['tDocNo']) ? 'TVODocTemp' : $paParams['tDocNo']; // เลขที่เอกสาร
        $tDocKey            = $paParams['tDocKey']; // ชื่อตาราง HD
        $tBchCode           = $paParams['tBchCode']; // สาขาที่เลือก
        $tMerCode           = $paParams['tMerCode']; // กลุ่มร้านค้า
        $tShpCode           = $paParams['tShpCode']; // ร้านค้าที่เลือก
        $tWahCodeFrom       = $paParams['tWahCodeFrom']; // คลังสินค้าของ ตู้ขายที่เลือก
        $tUserSessionID     = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate   = $paParams['tUserSessionDate'];
        $nLngID             = $paParams['nLngID'];
        $tPackDataPdt       = $paParams['tPackDataPdt'];

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        // $this->db->where('FTXthDocKey', $tDocKey);
        // $this->db->where('FTSessionID', $tUserSessionID);
        // $this->db->delete('TCNTDocDTTmp');

        // Create By : Napat(Jame) 17/12/2020
        $tSQLGetSeq = " SELECT FNXtdSeqNo 
                        FROM TCNTDocDTTmp WITH(NOLOCK) 
                        WHERE FTSessionID = '$tUserSessionID' 
                        AND FTXthDocNo  = '$tDocNo'
                        AND FTXthDocKey = '$tDocKey'
                        ORDER BY FNXtdSeqNo DESC
        ";
        $oQuery = $this->db->query($tSQLGetSeq);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->result_array();
            $nLastSeq = $aResult[0]['FNXtdSeqNo'];
        }else{
            $nLastSeq = 0;
        }

        $tSQL = "   
            INSERT TCNTDocDTTmp ( FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,
                FTPdtCode,FTXtdPdtName,FNCabSeqForTWXVD,FTCabNameForTWXVD,
                FNLayRowForTWXVD,FNLayColForTWXVD,FCStkQty,FCLayColQtyMaxForTWXVD,
                FTXthWhToForTWXVD,FTXthWhFrmForTWXVD,FCXtdQty,FDCreateOn,FTSessionID )
        ";
        $tSQL .= "  
            SELECT 
                '$tBchCode'         AS FTBchCode,
                '$tDocNo'           AS FTXthDocNo,
                $nLastSeq + ROW_NUMBER() OVER(ORDER BY PDTLAY.FTPdtCode ASC)  AS FNXtdSeqNo,
                '$tDocKey'          AS FTXthDocKey,
                PDT.FTPdtCode,
                PDTL.FTPdtName      AS FTXtdPdtName,
                PDTLAY.FNCabSeq     AS FNCabSeqForTWXVD,
                SHPCABL.FTCabName   AS FTCabNameForTWXVD,
                PDTLAY.FNLayRow AS FNLayRowForTWXVD,
                PDTLAY.FNLayCol AS FNLayColForTWXVD,
                ISNULL(
                    (SELECT 
                        FCStkQty 
                    FROM TVDTPdtStkBal WITH(NOLOCK) 
                    WHERE FTWahCode = '$tWahCodeFrom'
                    AND FTBchCode = '$tBchCode'
                    AND FNLayRow = PDTLAY.FNLayRow
                    AND FNLayCol = PDTLAY.FNLayCol
                    AND FNCabSeq = PDTLAY.FNCabSeq
                    AND FTPdtCode = PDTLAY.FTPdtCode)
                ,0) AS FCStkQty,
                PDTLAY.FCLayDim AS FCLayColQtyMaxForTWXVD, 
                PDTLAY.FTWahCode AS FTXthWhToForTWXVD,
                '$tWahCodeFrom' AS FTXthWhFrmForTWXVD,
                0 AS FCXtdQty,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TVDMPdtLayout PDTLAY WITH(NOLOCK)
            LEFT JOIN TVDMShopCabinet_L SHPCABL WITH(NOLOCK) ON SHPCABL.FTBchCode = PDTLAY.FTBchCode AND SHPCABL.FNCabSeq = PDTLAY.FNCabSeq AND SHPCABL.FTShpCode = PDTLAY.FTShpCode AND SHPCABL.FNLngID = $nLngID
            LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON PDTLAY.FTPdtCode = PDT.FTPdtCode
            LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
            WHERE PDTLAY.FDCreateOn <> '' AND PDTLAY.FTPdtCode <> ''
        ";

        if(isset($tBchCode) && !empty($tBCHCode)){
            $tSQL   .= " AND PDTLAY.FTBchCode   = ".$this->db->escape($tBchCode)." ";
        }

        if(isset($tMerCode) && !empty($tMerCode)){
            $tSQL   .= "AND PDTLAY.FTMerCode    = ".$this->db->escape($tMerCode)." ";
        }

        if(isset($tShpCode) && !empty($tShpCode)){
            $tSQL   .= " AND PDTLAY.FTShpCode   = ".$this->db->escape($tShpCode)." "; 
        }
            
        if(isset($tPackDataPdt) && !empty($tPackDataPdt)){
            $tSQL   .= " AND PDTLAY.FTPdtCode IN ($tPackDataPdt) ";
        }

        $tSQL   .= " ORDER BY PDTLAY.FNCabSeq ASC, PDTLAY.FNLayRow ASC, PDTLAY.FNLayCol ASC ";

        $this->db->query($tSQL);

        if ($this->db->trans_status() === FALSE) {
            $aReturn = array(
                'tSQL'  => $tSQL,
                'tCode' => '99',
                'tDesc' => $this->db->error(),
            );
        } else {
            $aReturn = array(
                'tSQL'  => $tSQL,
                'tCode' => '1',
                'tDesc' => 'success',
            );
        }
        return $aReturn;
    }

    /**
     * Functionality : Insert DT to Temp
     * Parameters : -
     * Creator : 10/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTVODTToTemp($paParams){
        $tDocNo             = $paParams['tDocNo']; // เลขที่เอกสาร
        $tDocKey            = $paParams['tDocKey']; // ชื่อตาราง HD
        $tBchCode           = $paParams['tBchCode']; // สาขาที่เลือก
        $tUserSessionID     = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate   = $paParams['tUserSessionDate'];
        $nLngID             = $paParams['nLngID'];

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL = "   
            INSERT TCNTDocDTTmp
                (FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FTXthDocKey,
                FTPdtCode,
                FTXtdPdtName,
                FNCabSeqForTWXVD,
                FTCabNameForTWXVD,
                FNLayRowForTWXVD,
                FNLayColForTWXVD,
                FCStkQty,
                FCLayColQtyMaxForTWXVD,
                FTXthWhFrmForTWXVD,
                FTXthWhToForTWXVD,
                FCXtdQty,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
                DT.FTBchCode,
                'TVODocTemp' AS FTXthDocNo,
                DT.FNXtdSeqNo,
                '$tDocKey' AS FTXthDocKey,
                DT.FTPdtCode,
                PDTL.FTPdtName AS FTXtdPdtName,
                DT.FNCabSeq AS FNCabSeqForTWXVD,
                SHPCABL.FTCabName AS FTCabNameForTWXVD,
                DT.FNLayRow AS FNLayRowForTWXVD,
                DT.FNLayCol AS FNLayColForTWXVD,
                ISNULL( 
                    (SELECT 
                        FCStkQty 
                    FROM TVDTPdtStkBal WITH(NOLOCK) 
                    WHERE FTWahCode = DT.FTXthWhFrm 
                    AND FTBchCode = DT.FTBchCode
                    AND FNLayRow = DT.FNLayRow
                    AND FNLayCol = DT.FNLayCol
                    AND FNCabSeq = DT.FNCabSeq
                    AND FTPdtCode = DT.FTPdtCode)
                ,0) AS FCStkQty,
                PDTLAY.FCLayDim AS FCLayColQtyMaxForTWXVD,
                DT.FTXthWhFrm AS FTXthWhFrmForTWXVD,
                DT.FTXthWhTo AS FTXthWhToForTWXVD,
                DT.FCXtdQty,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TVDTPdtTwxDT DT WITH(NOLOCK)
            LEFT JOIN TVDTPdtTwxHD HD WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo 
            AND HD.FTBchCode = DT.FTBchCode   

            LEFT JOIN TVDMPdtLayout PDTLAY WITH(NOLOCK) ON PDTLAY.FTBchCode = DT.FTBchCode 
            AND PDTLAY.FTShpCode = HD.FTXthShopTo AND PDTLAY.FNCabSeq = DT.FNCabSeq
            AND PDTLAY.FNLayRow = DT.FNLayRow AND PDTLAY.FNLayCol = DT.FNLayCol

            LEFT JOIN TVDMShopCabinet_L SHPCABL WITH(NOLOCK) ON SHPCABL.FNCabSeq = PDTLAY.FNCabSeq AND SHPCABL.FTBchCode = PDTLAY.FTBchCode
            AND SHPCABL.FTShpCode = PDTLAY.FTShpCode AND SHPCABL.FNLngID = $nLngID

            LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDTL.FTPdtCode = DT.FTPdtCode AND PDTL.FNLngID = $nLngID
            
            WHERE DT.FTBchCode = '$tBchCode'
            AND DT.FTXthDocNo = '$tDocNo'
            ORDER BY DT.FNCabSeq ASC, DT.FNLayRow ASC, DT.FNLayCol ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert Temp to DT
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTVOMoveTempToDT($paParams){
        $tDocNo         = $paParams['tDocNo']; // เลขที่เอกสาร
        $tDocKey        = $paParams['tDocKey']; // ชื่อตาราง HD
        $tBchCode       = $paParams['tBchCode']; // สาขาที่เลือก
        $tUserSessionID = $paParams['tUserSessionID']; // User Session

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TVDTPdtTwxDT');

        $tSQL = "   
            INSERT TVDTPdtTwxDT 
                (FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FNCabSeq,
                FNLayRow,
                FNLayCol,
                FTPdtCode,
                FCXtdQty,
                FTXthWhFrm,
                FTXthWhTo)
        ";

        $tSQL .= "  
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXthDocNo,
                        TMP.FNXtdSeqNo,
                        FNCabSeqForTWXVD AS FNCabSeq,
                        FNLayRowForTWXVD AS FNLayRow,
                        FNLayColForTWXVD AS FNLayCol,
                        TMP.FTPdtCode,
                        FCXtdQty,
                        TMP.FTXthWhFrmForTWXVD AS FTXthWhFrm,
                        TMP.FTXthWhToForTWXVD AS FTXthWhTo
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTBchCode = '$tBchCode'
                    AND TMP.FTXthDocKey = '$tDocKey'
                    AND TMP.FTSessionID = '$tUserSessionID'
                ";
                
        if( $paParams['tPageControl'] == 'Add' ){
            //แสดงเฉพาะสินค้าที่มีในสต็อก
            if($paParams['tStaShwPdtInStk'] == 'true'){
                $tSQL .= " AND TMP.FCStkQty != 0 ";
            }
        }
        // else{
        //     //หน้า Edit
        //     $tSQL .= " AND TMP.FCXtdQty != 0 ";
        // }

        $tSQL .= " ORDER BY TMP.FNCabSeqForTWXVD ASC, TMP.FNLayRowForTWXVD ASC, TMP.FNLayColForTWXVD ASC ";

        $this->db->query($tSQL);

        if ($this->db->affected_rows() > 0) {
        // ทำการลบ ใน DT Temp หลังการย้าย DT Temp ไป DT
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');
        }

    }

    // public function FSxMDeleteDoctemForNewEvent($paInfor)
    // {
    //     $tSQL = "
    //         DELETE FROM TCNTDocDTTmp 
    //         WHERE FTBchCode = '" . $paInfor["tBchCode"] . "' 
    //         AND FTSessionID = '" . $this->session->userdata('tSesSessionID') . "' 
    //         AND FTXthDocKey = '" . $paInfor["FTXthDocKey"] . "'
    //     ";
    //     $this->db->query($tSQL);
    // }

    /**
     * Functionality : ล้างข้อมูลในตาราง tmp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMTVOClearPdtLayoutInTmp($aParams = [])
    {
        $tUserSessionID = $aParams['tUserSessionID'];
        $tDocKey = $aParams['tDocKey'];

        $tSQL = "
            DELETE FROM TCNTDocDTTmp 
            WHERE FTSessionID = '$tUserSessionID' AND FTXthDocKey = '$tDocKey'
        ";
        $this->db->query($tSQL);
    }

    /**
     * Functionality : Check DocNo is Duplicate
     * Parameters : DocNo
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Boolean
     */
    public function FSbMCheckDuplicate($ptDocNo = '')
    {
        $tSQL = "   
            SELECT 
                FTXthDocNo
            FROM TVDTPdtTwxHD
            WHERE FTXthDocNo = '$ptDocNo'
        ";

        $bStatus = false;
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Add or Update HD
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTVOAddUpdateHD($paParams){
        try {
            // Update Master
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FDXthDocDate', $paParams['FDXthDocDate']);
            $this->db->set('FTDptCode', $paParams['FTDptCode']);
            $this->db->set('FTXthMerCode', $paParams['FTXthMerCode']);
            $this->db->set('FTXthShopFrm', $paParams['FTXthShopFrm']);
            $this->db->set('FTXthShopTo', $paParams['FTXthShopTo']);
            $this->db->set('FTXthPosFrm', $paParams['FTXthPosFrm']);
            $this->db->set('FTXthPosTo', $paParams['FTXthPosTo']);
            $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
            $this->db->set('FTXthRefExt', $paParams['FTXthRefExt']);
            $this->db->set('FDXthRefExtDate', $paParams['FDXthRefExtDate']);
            $this->db->set('FTXthRefInt', $paParams['FTXthRefInt']);
            $this->db->set('FDXthRefIntDate', $paParams['FDXthRefIntDate']);
            $this->db->set('FNXthDocPrint', $paParams['FNXthDocPrint']);
            $this->db->set('FCXthTotal', $paParams['FCXthTotal']);
            $this->db->set('FTXthRmk', $paParams['FTXthRmk']);
            $this->db->set('FTXthStaDoc', $paParams['FTXthStaDoc']);
            $this->db->set('FTXthStaApv', $paParams['FTXthStaApv']);
            $this->db->set('FTXthStaPrcStk', $paParams['FTXthStaPrcStk']);
            $this->db->set('FNXthStaDocAct', $paParams['FNXthStaDocAct']);
            $this->db->set('FNXthStaRef', $paParams['FNXthStaRef']);
            $this->db->set('FTRsnCode', $paParams['FTRsnCode']);
            $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
            $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->update('TVDTPdtTwxHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TVDTPdtTwxHD', array(
                    'FTBchCode'             => $paParams['FTBchCode'],
                    'FTXthDocNo'            => $paParams['FTXthDocNo'],
                    'FTXthDocType'          => $paParams['FTXthDocType'],
                    'FDXthDocDate'          => $paParams['FDXthDocDate'],
                    'FTDptCode'             => $paParams['FTDptCode'],
                    'FTXthMerCode'          => $paParams['FTXthMerCode'],
                    'FTXthShopFrm'          => $paParams['FTXthShopFrm'],
                    'FTXthShopTo'           => $paParams['FTXthShopTo'],
                    'FTXthPosFrm'           => $paParams['FTXthPosFrm'],
                    'FTXthPosTo'            => $paParams['FTXthPosTo'],
                    'FTUsrCode'             => $paParams['FTUsrCode'],
                    'FTXthRefExt'           => $paParams['FTXthRefExt'],
                    'FDXthRefExtDate'       => $paParams['FDXthRefExtDate'],
                    'FTXthRefInt'           => $paParams['FTXthRefInt'],
                    'FDXthRefIntDate'       => $paParams['FDXthRefIntDate'],
                    'FNXthDocPrint'         => $paParams['FNXthDocPrint'],
                    'FCXthTotal'            => $paParams['FCXthTotal'],
                    'FTXthRmk'              => $paParams['FTXthRmk'],
                    'FTXthStaDoc'           => $paParams['FTXthStaDoc'],
                    'FTXthStaApv'           => $paParams['FTXthStaApv'],
                    'FTXthStaPrcStk'        => $paParams['FTXthStaPrcStk'],
                    'FNXthStaDocAct'        => $paParams['FNXthStaDocAct'],
                    'FNXthStaRef'           => $paParams['FNXthStaRef'],
                    'FTRsnCode'             => $paParams['FTRsnCode'],
                    'FDLastUpdOn'           => $paParams['FDLastUpdOn'],
                    'FDCreateOn'            => $paParams['FDCreateOn'],
                    'FTCreateBy'            => $paParams['FTCreateBy'],
                    'FTLastUpdBy'           => $paParams['FTLastUpdBy']
                ));
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

    /**
     * Functionality : Add or Update HDRef
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTVOAddUpdateHDRef($paParams){
        // Update Master
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->set('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->set('FTXthCtrName', $paParams['FTXthCtrName']);
        $this->db->set('FDXthTnfDate', $paParams['FDXthTnfDate']);
        $this->db->set('FTXthRefTnfID', $paParams['FTXthRefTnfID']);
        $this->db->set('FTXthRefVehID', $paParams['FTXthRefVehID']);
        $this->db->set('FTXthQtyAndTypeUnit', $paParams['FTXthQtyAndTypeUnit']);
        $this->db->set('FNXthShipAdd', $paParams['FNXthShipAdd']);
        $this->db->set('FTViaCode', $paParams['FTViaCode']);
        $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->update('TVDTPdtTwxHDRef');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            // Add Master
            $this->db->insert('TVDTPdtTwxHDRef', array(
                'FTBchCode'             => $paParams['FTBchCode'],
                'FTXthDocNo'            => $paParams['FTXthDocNo'],
                'FTXthCtrName'          => $paParams['FTXthCtrName'],
                'FDXthTnfDate'          => $paParams['FDXthTnfDate'],
                'FTXthRefTnfID'         => $paParams['FTXthRefTnfID'],
                'FTXthRefVehID'         => $paParams['FTXthRefVehID'],
                'FTXthQtyAndTypeUnit'   => $paParams['FTXthQtyAndTypeUnit'],
                'FNXthShipAdd'          => $paParams['FNXthShipAdd'],
                'FTViaCode'             => $paParams['FTViaCode']
            ));
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
    }

    /**
     * Functionality : Get HDRef
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HDRef Data
     * Return Type : Array
     */
    public function FSaMGetHDRef($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];

        $tSQL = "
            SELECT
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
            FROM [TVDTPdtTwxHDRef] TFWR WITH (NOLOCK)
            LEFT JOIN TCNMAddress_L TADD WITH (NOLOCK) ON TFWR.FNXthShipAdd = TADD.FNAddSeqNo
            LEFT JOIN TCNMSubDistrict_L TSUD WITH (NOLOCK) ON TADD.FTAddV1SubDist = TSUD.FTSudCode
            LEFT JOIN TCNMDistrict_L TDST WITH (NOLOCK) ON TADD.FTAddV1DstCode = TDST.FTDstCode
            LEFT JOIN TCNMProvince_L TPVC WITH (NOLOCK) ON TADD.FTAddV1PvnCode = TPVC.FTPvnCode
            LEFT JOIN TCNMShipVia_L  TSPVL WITH (NOLOCK) ON TFWR.FTViaCode = TSPVL.FTViaCode
        ";

        if ($tDocNo != '') {
            $tSQL .= " WHERE (TFWR.FTXthDocNo = '$tDocNo')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode' => '1',
                'rtDesc' => 'Get HDRef Sucess',
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'HDRef Not Found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Update DocNo in Temp
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTVOUpdateDocNoInTmp($paParams){
        $this->db->set('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->where('FTXthDocNo', 'TVODocTemp');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocKey', $paParams['FTXthDocKey']);
        $this->db->update('TCNTDocDTTmp');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update DocNo Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Update DocNo Fail',
            );
        }
        return $aStatus;
    }

    /**
     * Functionality : Update Refill Qty in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdateQtyInTmpBySeq($paParams = [])
    {
        $this->db->set('FCXtdQty', $paParams['cQty']);
        $this->db->set('FDLastUpdOn', 'GETDATE()', false);
        $this->db->set('FTLastUpdBy', $paParams['tUserLoginCode']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->update('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete Refill Qty in Temp by SeqNo
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbTVOEventDeleteInTmpBySeq($paParams = []){
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where_in('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->delete('TCNTDocDTTmp');
        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }else{
            $bStatus = false;
        }
        return $bStatus;
    }

    /**
     * Functionality : Get PDT Stock Balance with Check in Temp
     * ดึงข้อมูลจาก FCStkQty in TCNTPdtStkBal 
     * เปรียบเทียบกับ FCStkQty in TCNTDocDTTmp ว่ามีการเติมไปแล้วเท่าไหร่
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Stock Balance
     * Return Type : Number
     */
    public function FSnGetPdtStkBalWithCheckInTmp($paParams = [])
    {
        $tWahCode = $paParams['tWahCode']; // คลังสินค้าต้นทาง เพื่อใช้ในการเติมให้กับ คลังตู้สินค้า
        $tBchCode = $paParams['tBchCode'];
        $tPdtCode = $paParams['tPdtCode'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tNotInSeqNo = isset($paParams['nNotInSelfSeqNo']) ? " AND TMP.FNXtdSeqNo NOT IN (" . $paParams['nNotInSelfSeqNo'] . ")" : "";

        $tPdtStkBalSQL = "
            SELECT 
                SUM(ISNULL(FCStkQty, 0)) AS FCStkQty 
            FROM TCNTPdtStkBal WITH(NOLOCK) 
            WHERE FTWahCode IN ($tWahCode)
            AND FTBchCode = '$tBchCode'
            AND FTPdtCode = '$tPdtCode'
            GROUP BY FTPdtCode
        ";

        $oPdtStkBal = $this->db->query($tPdtStkBalSQL);
        $oPdtStkBalRow = $oPdtStkBal->row();

        $tQtyInTempSQL = "
            SELECT DISTINCT
                SUM(ISNULL(TMP.FCXtdQty, 0)) AS FCXtdQty
            FROM TCNTDocDTTmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTBchCode = '$tBchCode'
            AND TMP.FTPdtCode = '$tPdtCode'
            $tNotInSeqNo
            GROUP BY TMP.FTPdtCode
        ";
        $oQtyInTemp = $this->db->query($tQtyInTempSQL);
        $oQtyInTempRow = $oQtyInTemp->row();

        $nResult = (empty($oPdtStkBalRow->FCStkQty) ? 0 : $oPdtStkBalRow->FCStkQty) - (empty($oQtyInTempRow->FCXtdQty) ? 0 : $oQtyInTempRow->FCXtdQty);
        return $nResult;
    }

 
    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 10/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSaMTVOEventApprove($paParams){
        try {
            // TVDTPdtTwxHD
            $this->db->set('FTXthStaPrcStk', '2');
            $this->db->set('FTXthStaApv', '2');
            $this->db->set('FTXthApvCode', $paParams['tApvCode']);
            $this->db->where('FTXthDocNo', $paParams['tDocNo']);
            $this->db->update('TVDTPdtTwxHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Approve Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Approve Fail',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Del Document by DocNo
     * Parameters : function parameters
     * Creator : 04/02/2020 Piya
     * Return : Status Delete
     * Return Type : array
     */
    public function FSaMDelMaster($paParams = [])
    {
        try {
            $tDocNo = $paParams['tDocNo'];

            $this->db->where('FTXthDocNo', $tDocNo);
            $this->db->delete('TVDTPdtTwxHD');

            $this->db->where('FTXthDocNo', $tDocNo);
            $this->db->delete('TVDTPdtTwxDT');

            $this->db->where('FTXthDocNo', $tDocNo);
            $this->db->delete('TVDTPdtTwxHDRef');
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Move DT From Ref Int
     * Parameters : เลขที่เอกสารใบเติม
     * Creator : 08/09/2020 Piya
     * Return : Status
     * Return Type : array
     */
    public function FSaMTVOMoveDTFromRefInt($paParams){
        try {
            $tDocNo         = empty($paParams['tDocNo']) ? 'TVODocTemp' : $paParams['tDocNo'];
            $tDocNoRefInt   = $paParams['tDocNoRefInt'];
            $tBchCode       = $paParams['tBchCode'];
            $tSessionID     = $paParams['tSessionID'];
            $tDocKey        = $paParams['tDocKey'];
            $nLangEdit      = $paParams['nLangEdit'];

            // ลบสินค้าปัจจุบันออกก่อน
            $this->db->where('FTXthDocNo', $tDocNo);
            $this->db->delete('TCNTDocDTTmp');

            // เพิ่มสินค้าจาก เอกสารอ้างอิงใบเติม
            $tSQL = "   INSERT INTO TCNTDocDTTmp ( FTBchCode,FTXthDocNo,FNXtdSeqNo,
                            FNCabSeqForTWXVD,FTCabNameForTWXVD,FNLayRowForTWXVD,FNLayColForTWXVD,
                            FTPdtCode,FTXtdPdtName,FCXtdQty,FCStkQty,FTXthWhFrmForTWXVD,FTXthWhToForTWXVD,
                            FTSessionID,FTXthDocKey )
                        SELECT 
                            '$tBchCode'     AS FTBchCode,
                            '$tDocNo'       AS FTXthDocNo,
                            DT.FNXtdSeqNo,
                            DT.FNCabSeq,
                            SCNL.FTCabName	AS FTCabName,
                            DT.FNLayRow,
                            DT.FNLayCol,
                            DT.FTPdtCode,
                            PDTL.FTPdtName	AS FTPdtName,
                            0               AS FCXtdQty,
                            ISNULL((SELECT 
                                        FCStkQty 
                                    FROM TVDTPdtStkBal WITH(NOLOCK) 
                                    WHERE FTWahCode = DT.FTXthWhTo
                                    AND FTBchCode = '$tBchCode'
                                    AND FNLayRow = DT.FNLayRow
                                    AND FNLayCol = DT.FNLayCol
                                    AND FNCabSeq = DT.FNCabSeq
                                    AND FTPdtCode = DT.FTPdtCode)
                            ,0) AS FCStkQty,
                            DT.FTXthWhTo AS FTXthWhFrmForTWXVD,
	                        DT.FTXthWhFrm AS FTXthWhToForTWXVD,
                            '$tSessionID'   AS FTSessionID,
                            '$tDocKey'      AS FTXthDocKey
                        FROM TVDTPdtTwxDT DT
                        LEFT JOIN TVDTPdtTwxHD HD ON DT.FTXthDocNo = HD.FTXthDocNo
                        LEFT JOIN TVDMShopCabinet_L SCNL ON DT.FTBchCode = SCNL.FTBchCode AND DT.FNCabSeq = SCNL.FNCabSeq 
                                                            AND SCNL.FTShpCode = HD.FTXthShopFrm AND SCNL.FNLngID = $nLangEdit
                        LEFT JOIN TCNMPdt_L PDTL ON DT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLangEdit
                        WHERE DT.FTXthDocNo = '$tDocNoRefInt'
                    ";
            $this->db->query($tSQL);
            // echo $this->db->last_query();exit;

            if ($this->db->trans_status() === FALSE) {
                $aReturn = array(
                    'tCode' => '99',
                    'tDesc' => $this->db->error(),
                );
            } else {
                $aReturn = array(
                    'tCode' => '1',
                    'tDesc' => 'success',
                );
            }
            return $aReturn;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Create By : 10/09/2020 Napat(Jame)
    public function FSaMTVOEventEditInLine($paDataUpdInline,$paDataWhere){
        try {
            $this->db->set($paDataUpdInline['tField'], $paDataUpdInline['tValue'], FALSE);
            $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->where('FTXthDocKey',$paDataWhere['FTXthDocKey']);
            $this->db->where('FNXtdSeqNo',$paDataWhere['FNXtdSeqNo']);
            $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
            $this->db->update('TCNTDocDTTmp');

            // echo $this->db->last_query(); exit;

            if($this->db->affected_rows() > 0){
                $aDataReturn = array(
                    'nStaQuery' => 1,
                    'tStaMeg'   => 'Update Success.',
                );
            }else{
                $aDataReturn = array(
                    'nStaQuery' => 905,
                    'tStaMeg'   => $this->db->error(),
                );
            }
            return $aDataReturn;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //ยกเลิก
    public function FSaMTVOEventDocCancel($paParams){
        try {
            $this->db->set('FTXthStaDoc', '3');
            $this->db->where('FTXthDocNo', $paParams['tDocNo']);
            $this->db->update('TVDTPdtTwxHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Cancel Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Cancel Fail',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    // ลบข้อมูลรายการสินค้า DTTemp
    public function FSxMTVDDelDTTempAll($paParams){
        $this->db->where('FTSessionID', $paParams['FTSessionID']);
        $this->db->where('FTXthDocKey', $paParams['FTXthDocKey']);
        $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->delete('TCNTDocDTTmp');
        if($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete DT Success',
            );
        }else{
            $aStatus = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Error Cannot Delete DT.',
            );
        }
        return $aStatus;
    }





}
