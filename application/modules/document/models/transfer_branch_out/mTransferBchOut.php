<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mTransferBchOut extends CI_Model
{

    /**
     * Functionality : HD List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD List
     * Return Type : Array
     */
    public function FSaMHDList($paParams = [])
    {
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $nLngID = $paParams['FNLngID'];

        $tSQL1 = "  SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM ( ";
        $tSQL2 = "      SELECT DISTINCT
                            HD.*,
                            BCHL.FTBchName,
                            USRL.FTUsrName AS FTCreateByName,
                            USRLAPV.FTUsrName AS FTXthApvName,
                            CASE WHEN ISNULL(HD_DocRef.FTXthDocNo,'') = '' THEN '1' ELSE '2' END AS FTRefAlwDel
                        FROM TCNTPdtTboHD HD WITH (NOLOCK)
                        LEFT JOIN (SELECT DISTINCT FTXthDocNo FROM TCNTPdtTboHDDocRef WITH (NOLOCK) WHERE FTXthRefType = '2') HD_DocRef ON HD_DocRef.FTXthDocNo = HD.FTXthDocNo 
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode
                        LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
                        LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON HD.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                        WHERE 1=1 ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL2 .= " AND HD.FTBchCode IN ($tBchCode) ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];

        $tSearchList = $aAdvanceSearch['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL2 .= " AND ((HD.FTXthDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL2 .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL2 .= " AND ((HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if( !empty($tSearchStaDoc) ){
            if ( $tSearchStaDoc == 'D1' ) { // รออนุมัติ
                $tSQL2 .= " AND ( ";
                $tSQL2 .= "          (ISNULL(HD.FTXthStaApv,'') = '' AND ISNULL(HD.FTXthStaPrcDoc,'') = '' AND HD.FTXthStaDoc = '1') ";  // รออนุมัติ กรณีไม่สร้างใบจัด
                $tSQL2 .= "          OR ";
                $tSQL2 .= "          (ISNULL(HD.FTXthStaApv,'') = '' AND FTXthStaPrcDoc = '4' AND HD.FTXthStaDoc = '1') ";               // รออนุมัติ กรณีสร้างใบจัด
                $tSQL2 .= " ) ";
            } elseif ( $tSearchStaDoc == 'D2' ) { // อนุมัติแล้ว
                $tSQL2 .= " AND ( ";
                $tSQL2 .= "          (HD.FTXthStaApv = '1' AND ISNULL(HD.FTXthStaPrcDoc,'') = '' AND HD.FTXthStaDoc = '1') ";            // อนุมัติแล้ว กรณีไม่สร้างใบจัด
                $tSQL2 .= "          OR ";
                $tSQL2 .= "          (HD.FTXthStaApv = '1' AND FTXthStaPrcDoc = '5' AND HD.FTXthStaDoc = '1') ";                         // อนุมัติแล้ว กรณีสร้างใบจัด
                $tSQL2 .= " ) ";
            } elseif ( $tSearchStaDoc == 'D3' ) {
                $tSQL2 .= " AND HD.FTXthStaDoc = '3' ";
            } elseif ( $tSearchStaDoc == 'D4' ) {
                $tSQL2 .= " AND HD.FTXthStaDoc = '1' AND FTXthStaPrcDoc = '1' ";
            } elseif ( $tSearchStaDoc == 'D5' ) {
                $tSQL2 .= " AND HD.FTXthStaDoc = '1' AND FTXthStaPrcDoc = '2' ";
            } elseif ( $tSearchStaDoc == 'D6' ) {
                $tSQL2 .= " AND HD.FTXthStaDoc = '1' AND FTXthStaPrcDoc = '3' ";
            }
        }

        // ค้นหาสถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL2 .= " AND (HD.FTXthStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(HD.FTXthStaPrcStk,'') = '') ";
            } else {
                $tSQL2 .= " AND HD.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL2 .= " AND HD.FNXthStaDocAct = 1 ";
            } else {
                $tSQL2 .= " AND HD.FNXthStaDocAct = 0 ";
            }
        }

        $tSQL3 = " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";

        $tSQLMain = $tSQL1.$tSQL2.$tSQL3;
        $oQuery = $this->db->query($tSQLMain);
        if ( $oQuery->num_rows() > 0 ) {
            // $nFoundRow = $this->FSnMHDListGetPageAll($paParams);
            $oQueryPage = $this->db->query($tSQL2);
            $nFoundRow  = $oQueryPage->num_rows();
            $nPageAll   = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oQuery->result(),
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
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
        $tSQL = "
            SELECT
                HD.FTXthDocNo
            FROM TCNTPdtTboHD HD WITH (NOLOCK)
            WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND HD.FTBchCode IN ($tBchCode)
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
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
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
            if ($tSearchStaDoc == 2) {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc' OR HD.FTXthStaDoc = ''";
            } else {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc'";
            }
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
            LEFT JOIN TCNMShop      SHP WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode
            LEFT JOIN TCNMMerchant_L  MCHL WITH (NOLOCK) ON SHP.FTMerCode = MCHL.FTMerCode AND  MCHL.FNLngID = '" . $nLngID . "'
            LEFT JOIN TCNMShop_L    SHPL WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = '" . $nLngID . "'
            LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode
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
     * Functionality : Get HD Detail
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Detail
     * Return Type : Array
     */
    public function FSaMGetHD($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];

        $tSQL = "
            SELECT
                HD.*,
                HDREF.*,
                SHIPVIAL.FTViaName,
                BCHL.FTBchName,
                CONVERT(CHAR(5), HD.FDXthDocDate, 108)  AS FTXthDocTime,
                USRAPV.FTUsrName AS FTXthApvName,
                USRL.FTUsrName AS FTCreateByName,
                RSNL.FTRsnName,
                /*HDREFDOC.FTXthRefDocNo AS FTXthRefInt,
                HDREFDOCEX.FTXthRefDocNo AS FTXthRefExt,
                HDREFDOC.FDXthRefDocDate AS FDXthRefIntDate,
                HDREFDOCEX.FDXthRefDocDate AS FDXthRefExtDate,
                CONVERT(CHAR(5), HDREFDOC.FDXthRefDocDate,108) AS FDXthRefIntTime,*/
                /*===== From ===========*/
                BCHLF.FTBchName AS FTXthBchFrmName,
                MCHLF.FTMerName AS FTXthMerchantFrmName,
                SHPLF.FTShpName AS FTXthShopFrmName,
                WAHLF.FTWahName AS FTXthWhFrmName,
                /*===== To =============*/
                BCHLT.FTBchName AS FTXthBchToName,
                WAHLT.FTWahName AS FTXthWhToName
            FROM TCNTPdtTboHD HD WITH (NOLOCK)

            LEFT JOIN TCNTPdtTboHDRef HDREF WITH (NOLOCK) ON HDREF.FTXthDocNo = HD.FTXthDocNo AND HDREF.FTBchCode = HD.FTBchCode
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMShipVia_L SHIPVIAL WITH (NOLOCK) ON SHIPVIAL.FTViaCode = HDREF.FTViaCode AND SHIPVIAL.FNLngID = $nLngID

            LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRAPV WITH (NOLOCK) ON USRAPV.FTUsrCode = HD.FTXthApvCode AND USRAPV.FNLngID = $nLngID

            LEFT JOIN TCNMRsn_L RSNL WITH (NOLOCK) ON RSNL.FTRsnCode = HD.FTRsnCode AND RSNL.FNLngID = $nLngID
            /*LEFT JOIN TCNTPdtTboHDDocRef    HDREFDOC WITH (NOLOCK) ON HDREFDOC.FTXthDocNo  = HD.FTXthDocNo AND HDREFDOC.FTXthRefType = '1'
            LEFT JOIN TCNTPdtTboHDDocRef    HDREFDOCEX WITH (NOLOCK) ON HDREFDOCEX.FTXthDocNo  = HD.FTXthDocNo AND HDREFDOCEX.FTXthRefType = '3'*/

            /*===== From =========================================*/
            LEFT JOIN TCNMBranch_L BCHLF WITH (NOLOCK) ON BCHLF.FTBchCode = HD.FTXthBchFrm AND BCHLF.FNLngID = $nLngID
            LEFT JOIN TCNMMerchant_L MCHLF WITH (NOLOCK) ON MCHLF.FTMerCode = HD.FTXthMerchantFrm AND MCHLF.FNLngID = $nLngID
            LEFT JOIN TCNMShop_L SHPLF WITH (NOLOCK) ON SHPLF.FTShpCode = HD.FTXthShopFrm AND SHPLF.FTBchCode = HD.FTXthBchFrm AND SHPLF.FNLngID = $nLngID
            LEFT JOIN TCNMWaHouse_L WAHLF WITH (NOLOCK) ON  WAHLF.FTWahCode = HD.FTXthWhFrm AND WAHLF.FTBchCode = HD.FTXthBchFrm AND WAHLF.FNLngID = $nLngID
            /*===== To ===========================================*/
            LEFT JOIN TCNMBranch_L BCHLT WITH (NOLOCK) ON BCHLT.FTBchCode = HD.FTXthBchTo AND BCHLT.FNLngID = $nLngID
            LEFT JOIN TCNMWaHouse_L WAHLT WITH (NOLOCK) ON  WAHLT.FTWahCode = HD.FTXthWhTo AND WAHLT.FTBchCode = HD.FTXthBchTo AND WAHLT.FNLngID = $nLngID
            WHERE 1=1
        ";

        if ($tDocNo != "") {
            $tSQL .= " AND HD.FTXthDocNo = '$tDocNo'";
        }

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
     * Functionality : Insert DT to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMDTToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo']; // เลขที่เอกสาร
        $tDocKey = $paParams['tDocKey']; // ชื่อตาราง HD
        $tBchCode = $paParams['tBchCode']; // สาขาที่ทำรายการ
        // $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $nLngID = $paParams['nLngID'];

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        $this->db->where('FTXthDocKey', $tDocKey);
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL = "
            INSERT TCNTDocDTTmp
                (FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FTPdtCode,
                FTXtdPdtName,
                FTPunCode,
                FTPunName,
                FCXtdFactor,
                FTXtdBarCode,
                FTXtdVatType,
                FTVatCode,
                FCXtdVatRate,
                FCXtdQty,
                FCXtdQtyAll,
                FCXtdSetPrice,
                FCXtdAmt,
                FCXtdVat,
                FCXtdVatable,
                FCXtdNet,
                FCXtdCostIn,
                FCXtdCostEx,
                FTXtdStaPrcStk,
                FNXtdPdtLevel,
                FTXtdPdtParent,
                FCXtdQtySet,
                FTXtdPdtStaSet,
                FTXtdRmk,
                FDLastUpdOn,
                FTLastUpdBy,
                FDCreateOn,
                FTCreateBy,

                FTXthDocKey,
                FTSessionID)
        ";

        $tSQL .= "
            SELECT
                DT.FTBchCode,
                'TBODOCTEMP' AS FTXthDocNo,
                DT.FNXtdSeqNo,
                DT.FTPdtCode,
                DT.FTXtdPdtName,
                DT.FTPunCode,
                DT.FTPunName,
                DT.FCXtdFactor,
                DT.FTXtdBarCode,
                DT.FTXtdVatType,
                DT.FTVatCode,
                DT.FCXtdVatRate,
                DT.FCXtdQty,
                DT.FCXtdQtyAll,
                DT.FCXtdSetPrice,
                DT.FCXtdAmt,
                DT.FCXtdVat,
                DT.FCXtdVatable,
                DT.FCXtdNet,
                DT.FCXtdCostIn,
                DT.FCXtdCostEx,
                DT.FTXtdStaPrcStk,
                DT.FNXtdPdtLevel,
                DT.FTXtdPdtParent,
                DT.FCXtdQtySet,
                DT.FTXtdPdtStaSet,
                DT.FTXtdRmk,
                DT.FDLastUpdOn,
                DT.FTLastUpdBy,
                DT.FDCreateOn,
                DT.FTCreateBy,

                '$tDocKey' AS FTXthDocKey,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtTboDT DT WITH(NOLOCK)
            WHERE DT.FTBchCode = '$tBchCode'
            AND DT.FTXthDocNo = '$tDocNo'
            ORDER BY DT.FNXtdSeqNo ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert Temp to DT
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToDT($paParams = [])
    {
        $tDocNo = $paParams['tDocNo']; // เลขที่เอกสาร
        $tDocKey = $paParams['tDocKey']; // ชื่อตาราง HD
        $tBchCode = $paParams['tBchCode']; // สาขา
        // $tShpCode = $paParams['tShpCode']; // ร้านค้า
        // $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserLoginCode = $paParams['tUserLoginCode']; // User Login Code
        // $nLngID = $paParams['nLngID'];

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboDT');

        $tSQL = "
            INSERT TCNTPdtTboDT
                (FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FTPdtCode,
                FTXtdPdtName,
                FTPunCode,
                FTPunName,
                FCXtdFactor,
                FTXtdBarCode,
                FTXtdVatType,
                FTVatCode,
                FCXtdVatRate,
                FCXtdQty,
                FCXtdQtyAll,
                FCXtdSetPrice,
                FCXtdAmt,
                FCXtdVat,
                FCXtdVatable,
                FCXtdNet,
                FCXtdCostIn,
                FCXtdCostEx,
                FTXtdStaPrcStk,
                FNXtdPdtLevel,
                FTXtdPdtParent,
                FCXtdQtySet,
                FTXtdPdtStaSet,
                FTXtdRmk,
                FDLastUpdOn,
                FTLastUpdBy,
                FDCreateOn,
                FTCreateBy)
        ";

        $tSQL .= "
            SELECT
                TMP.FTBchCode,
                TMP.FTXthDocNo,
                ROW_NUMBER() OVER(ORDER BY TMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                TMP.FTPdtCode,
                TMP.FTXtdPdtName,
                TMP.FTPunCode,
                TMP.FTPunName,
                TMP.FCXtdFactor,
                TMP.FTXtdBarCode,
                TMP.FTXtdVatType,
                TMP.FTVatCode,
                TMP.FCXtdVatRate,
                TMP.FCXtdQty,
                TMP.FCXtdQtyAll,
                TMP.FCXtdSetPrice,
                TMP.FCXtdAmt,
                TMP.FCXtdVat,
                TMP.FCXtdVatable,
                TMP.FCXtdNet,
                TMP.FCXtdCostIn,
                TMP.FCXtdCostEx,
                TMP.FTXtdStaPrcStk,
                TMP.FNXtdPdtLevel,
                TMP.FTXtdPdtParent,
                TMP.FCXtdQtySet,
                TMP.FTXtdPdtStaSet,
                TMP.FTXtdRmk,
                GETDATE() AS FDLastUpdOn,
                '$tUserLoginCode' AS FTLastUpdBy,
                GETDATE() AS FDCreateOn,
                '$tUserLoginCode' AS FTCreateBy
            FROM TCNTDocDTTmp TMP WITH(NOLOCK)
            WHERE TMP.FTBchCode = '$tBchCode'
            AND TMP.FTXthDocKey = '$tDocKey'
            AND TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FNXtdSeqNo ASC
        ";

        $this->db->query($tSQL);

        // ทำการลบ ใน DT Temp หลังการย้าย DT Temp ไป DT
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');
    }

    /**
     * Functionality : ล้างข้อมูลในตาราง tmp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMClearInTmp($aParams = [])
    {
        $tUserSessionID = $aParams['tUserSessionID'];
        $tDocKey        = $aParams['tDocKey'];

        // $tSQL = "
        //     DELETE FROM TCNTDocDTTmp
        //     WHERE FTSessionID = '$tUserSessionID'
        //     AND FTXthDocKey = '$tDocKey'
        // ";
        $this->db->where_in('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');

        $this->db->where_in('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocHDRefTmp');

        // $this->db->query($tSQL);
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
            FROM TCNTPdtTboHD
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
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdateHD($paParams = [])
    {
        // Update Master
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->set('FDXthDocDate', $paParams['FDXthDocDate']);
        $this->db->set('FTXthVATInOrEx', $paParams['FTXthVATInOrEx']);
        $this->db->set('FTDptCode', $paParams['FTDptCode']);
        $this->db->set('FTXthBchFrm', $paParams['FTXthBchFrm']);
        $this->db->set('FTXthBchTo', $paParams['FTXthBchTo']);
        $this->db->set('FTXthMerchantFrm', $paParams['FTXthMerchantFrm']);
        $this->db->set('FTXthMerchantTo', $paParams['FTXthMerchantTo']);
        $this->db->set('FTXthShopFrm', $paParams['FTXthShopFrm']);
        $this->db->set('FTXthShopTo', $paParams['FTXthShopTo']);
        $this->db->set('FTXthWhFrm', $paParams['FTXthWhFrm']);
        $this->db->set('FTXthWhTo', $paParams['FTXthWhTo']);
        $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
        $this->db->set('FTSpnCode', $paParams['FTSpnCode']);
        $this->db->set('FTXthApvCode', $paParams['FTXthApvCode']);
        $this->db->set('FNXthDocPrint', $paParams['FNXthDocPrint']);
        $this->db->set('FCXthTotal', $paParams['FCXthTotal']);
        $this->db->set('FCXthVat', $paParams['FCXthVat']);
        $this->db->set('FCXthVatable', $paParams['FCXthVatable']);
        $this->db->set('FTXthRmk', $paParams['FTXthRmk']);
        $this->db->set('FTXthStaDoc', $paParams['FTXthStaDoc']);
        $this->db->set('FTXthStaApv', $paParams['FTXthStaApv']);
        $this->db->set('FTXthStaPrcStk', $paParams['FTXthStaPrcStk']);
        $this->db->set('FTXthStaDelMQ', $paParams['FTXthStaDelMQ']);
        $this->db->set('FNXthStaDocAct', $paParams['FNXthStaDocAct']);
        $this->db->set('FNXthStaRef', $paParams['FNXthStaRef']);
        $this->db->set('FTRsnCode', $paParams['FTRsnCode']);
        $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
        $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->update('TCNTPdtTboHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {


            // ตรวจสอบคลัง สถานะอนุญาต ใช้ใบจัดจากใบจ่ายโอน 1:อนุญาต 2:ไม่อนุญาต
            $tSQL = "   SELECT ISNULL(FTWahStaAlwPLFrmTBO,'2') AS FTWahStaAlwPLFrmTBO
                        FROM TCNMWaHouse WITH(NOLOCK)
                        WHERE FTBchCode = '".$paParams['FTXthBchFrm']."' AND FTWahCode = '".$paParams['FTXthWhFrm']."' ";
            $oQuery = $this->db->query($tSQL);
            if( $oQuery->num_rows() > 0 ){
                $tStaAlwPL = $oQuery->row_array()['FTWahStaAlwPLFrmTBO'];
            }else{
                $tStaAlwPL = '2';
            }

            if( $tStaAlwPL == '1' ){       // อนุญาตใช้ใบจัดสินค้า
                $tStaPrcDoc = '1';
            }else{                         // ไม่อนุญาตใช้ใบจัดสินค้า
                $tStaPrcDoc = NULL;
            }

            // Add Master
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->set('FDXthDocDate', $paParams['FDXthDocDate']);
            $this->db->set('FTXthVATInOrEx', $paParams['FTXthVATInOrEx']);
            $this->db->set('FTDptCode', $paParams['FTDptCode']);
            $this->db->set('FTXthBchFrm', $paParams['FTXthBchFrm']);
            $this->db->set('FTXthBchTo', $paParams['FTXthBchTo']);
            $this->db->set('FTXthMerchantFrm', $paParams['FTXthMerchantFrm']);
            $this->db->set('FTXthMerchantTo', $paParams['FTXthMerchantTo']);
            $this->db->set('FTXthShopFrm', $paParams['FTXthShopFrm']);
            $this->db->set('FTXthShopTo', $paParams['FTXthShopTo']);
            $this->db->set('FTXthWhFrm', $paParams['FTXthWhFrm']);
            $this->db->set('FTXthWhTo', $paParams['FTXthWhTo']);
            $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
            $this->db->set('FTSpnCode', $paParams['FTSpnCode']);
            $this->db->set('FTXthApvCode', $paParams['FTXthApvCode']);
            $this->db->set('FNXthDocPrint', $paParams['FNXthDocPrint']);
            $this->db->set('FCXthTotal', $paParams['FCXthTotal']);
            $this->db->set('FCXthVat', $paParams['FCXthVat']);
            $this->db->set('FCXthVatable', $paParams['FCXthVatable']);
            $this->db->set('FTXthRmk', $paParams['FTXthRmk']);
            $this->db->set('FTXthStaDoc', $paParams['FTXthStaDoc']);
            $this->db->set('FTXthStaApv', $paParams['FTXthStaApv']);
            $this->db->set('FTXthStaPrcStk', $paParams['FTXthStaPrcStk']);
            $this->db->set('FTXthStaDelMQ', $paParams['FTXthStaDelMQ']);
            $this->db->set('FNXthStaDocAct', $paParams['FNXthStaDocAct']);
            $this->db->set('FNXthStaRef', $paParams['FNXthStaRef']);
            $this->db->set('FTRsnCode', $paParams['FTRsnCode']);
            $this->db->set('FTXthStaPrcDoc', $tStaPrcDoc);
            $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
            $this->db->set('FDCreateOn', $paParams['FDCreateOn']);
            $this->db->set('FTCreateBy', $paParams['FTCreateBy']);
            $this->db->insert('TCNTPdtTboHD');
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
     * Functionality : Add or Update HDRef
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdateHDRef($paParams = [])
    {
        // Update TCNTPdtTboHDRef
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->set('FTXthCtrName', $paParams['FTXthCtrName']);
        $this->db->set('FDXthTnfDate', $paParams['FDXthTnfDate']);
        $this->db->set('FTXthRefTnfID', $paParams['FTXthRefTnfID']);
        $this->db->set('FTXthRefVehID', $paParams['FTXthRefVehID']);
        $this->db->set('FTXthQtyAndTypeUnit', $paParams['FTXthQtyAndTypeUnit']);
        $this->db->set('FNXthShipAdd', $paParams['FNXthShipAdd']);
        $this->db->set('FTViaCode', $paParams['FTViaCode']);
        $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->update('TCNTPdtTboHDRef');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update AddUpdateHDRef Success',
            );
        } else {
            // Add TCNTPdtTboHDRef
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->set('FTXthCtrName', $paParams['FTXthCtrName']);
            $this->db->set('FDXthTnfDate', $paParams['FDXthTnfDate']);
            $this->db->set('FTXthRefTnfID', $paParams['FTXthRefTnfID']);
            $this->db->set('FTXthRefVehID', $paParams['FTXthRefVehID']);
            $this->db->set('FTXthQtyAndTypeUnit', $paParams['FTXthQtyAndTypeUnit']);
            $this->db->set('FNXthShipAdd', $paParams['FNXthShipAdd']);
            $this->db->set('FTViaCode', $paParams['FTViaCode']);
            $this->db->insert('TCNTPdtTboHDRef');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add AddUpdateHDRef Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit AddUpdateHDRef.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Update DocNo in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMUpdateDocNoInTmp($paParams = [])
    {
        $this->db->set('FTXthDocNo', $paParams['tDocNo']);
        $this->db->where('FTXthDocNo', 'TBODOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocKey', $paParams['tDocKey']);
        $this->db->update('TCNTDocDTTmp');

        $this->db->set('FTXthDocNo', $paParams['tDocNo']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocKey', $paParams['tDocKey']);
        $this->db->update('TCNTDocHDRefTmp');
        // echo $this->db->last_query();

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
     * Functionality : Cancel Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxMDocCancel($paParams = [])
    {
        $this->db->set('FTXthStaDoc', '3');
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);
        $this->db->update('TCNTPdtTboHD');

        // BS Ref
        $this->db->where_in('FTXthDocNo',$paParams['tDocNo']);
        $this->db->delete('TCNTPdtTboHDDocRef');

        // TR Ref
        $this->db->where('FTXthRefKey','TBO');
        $this->db->where('FTXthRefType','2');
        $this->db->where_in('FTXthRefDocNo',$paParams['tDocNo']);
        $this->db->delete('TCNTPdtReqBchHDDocRef');


    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSxMTBODocApprove($paParams = [])
    {
        $this->db->set('FTXthStaApv', '2');
        $this->db->set('FTXthApvCode', $paParams['tApvCode']);
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);
        $this->db->update('TCNTPdtTboHD');

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
        $tDocNo = $paParams['tDocNo'];

        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboHD');

        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboDT');

        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboHDRef');

        // BS Ref
        $this->db->where_in('FTXthDocNo',$tDocNo);
        $this->db->delete('TCNTPdtTboHDDocRef');

        // TR Ref
        $this->db->where_in('FTXthRefDocNo',$tDocNo);
        $this->db->delete('TCNTPdtReqBchHDDocRef');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'DelMaster Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'DelMaster Fail',
            );
        }
        return $aStatus;
    }



     //อัพเดทหมายเหตุถ้าเอกสารอนุมัติแล้ว
     public function FSaMHDUpdateRmk($paDataUpdate){
        $dLastUpdOn = date('Y-m-d H:i:s');
        $tLastUpdBy = $this->session->userdata('tSesUsername');

        $this->db->set('FDLastUpdOn',$dLastUpdOn);
        $this->db->set('FTLastUpdBy',$tLastUpdBy);
        $this->db->set('FTXthRmk',$paDataUpdate['FTXthRmk']);
        $this->db->set('FNXthStaDocAct',$paDataUpdate['FNXthStaDocAct']);

        $this->db->where('FTBchCode',$paDataUpdate['FTBchCode']);
        $this->db->where('FTXthDocNo',$paDataUpdate['FTXthDocNo']);
        $this->db->update('TCNTPdtTboHD');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Updated Status Document Cancel Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Not Update Status Document.',
            );
        }
        return $aStatus;
    }


    //อัพเดท เอกสาร TR ว่าห้ามใช้งานอีก
    public function FSxMBSUpdateRef($ptTableName , $paParam){
        $nChkDataDocRef  = $this->FSaMBSChkRefDupicate($ptTableName , $paParam);
        $tTableRef       = $ptTableName;
        if(isset($nChkDataDocRef['rtCode']) && $nChkDataDocRef['rtCode'] == 1){ //หากพบว่าซ้ำ
            //ลบ
                $this->db->where_in('FTAgnCode',$paParam['FTAgnCode']);
                $this->db->where_in('FTBchCode',$paParam['FTBchCode']);
                $this->db->where_in('FTXthDocNo',$paParam['FTXshDocNo']);
                $this->db->where_in('FTXthRefType',$paParam['FTXshRefType']);
                $this->db->where_in('FTXthRefKey',$paParam['FTXshRefKey']);

            $this->db->delete($tTableRef);

            //เพิ่มใหม่
            $this->db->insert($tTableRef,$paParam);
        }else{ //หากพบว่าไม่ซ้ำ
            $this->db->insert($tTableRef,$paParam);
        }
        return;
    }

    //เช็คข้อมูล Insert ว่าซ้ำหรือไม่ ถ้าซ้ำให้ลบและค่อยเพิ่มใหม่
    public function FSaMBSChkRefDupicate($ptTableName , $paParam){
        try{
            $tAgnCode       = $paParam['FTAgnCode'];
            $tBchCode       = $paParam['FTBchCode'];
            $tDocNo         = $paParam['FTXshDocNo'];
            $tRefDocType    = $paParam['FTXshRefType'];
            $tRefDocNo      = $paParam['FTXshDocNo'];
            $tRefKey        = $paParam['FTXshRefKey'];

                $tSQL = "   SELECT
                            FTBchCode
                        FROM $ptTableName
                        WHERE 1=1
                        AND FTAgnCode     = '$tAgnCode'
                        AND FTBchCode     = '$tBchCode'
                        AND FTXthRefType  = '$tRefDocType' ";

                if($tRefDocType == 1 || $tRefDocType == 3){
                    $tSQL .= " AND FTXthDocNo  = '$tDocNo' " ;
                }else{
                    $tSQL .= " AND FTXthDocNo  = '$tRefDocNo' ";
                }

            $oQueryHD = $this->db->query($tSQL);
            if ($oQueryHD->num_rows() > 0){
                $aResult    = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult    = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found.',
                );
            }
            return $aResult;
        }catch (Exception $Error) {
            echo $Error;
        }
    }

    // แท็บ อ้างอิงเอกสาร - โหลด
    public function FSaMTBOGetDataHDRefTmp($paData){

        $tTableTmpHDRef = $paData['tTableTmpHDRef'];
        $FTXthDocNo     = $paData['FTXthDocNo'];
        $FTXthDocKey    = $paData['FTXthDocKey'];
        $FTSessionID    = $paData['FTSessionID'];

        $tSQL = "   SELECT TMP.FTXthDocNo, TMP.FTXthRefDocNo, TMP.FTXthRefType, TMP.FTXthRefKey, TMP.FDXthRefDocDate
                    FROM $tTableTmpHDRef TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo  = '$FTXthDocNo'
                      AND TMP.FTXthDocKey = '$FTXthDocKey'
                      AND TMP.FTSessionID = '$FTSessionID'
                    ORDER BY TMP.FDCreateOn DESC
                 ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        if ( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'found data',
            );
        }else{
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found.',
            );
        }
        return $aResult;

    }

    // แท็บค่าอ้างอิงเอกสาร - เพิ่ม
    public function FSaMTBOAddEditHDRefTmp($paDataWhere,$paDataAddEdit){

        $tRefDocNo = ( empty($paDataWhere['tRefDocNoOld']) ? $paDataAddEdit['FTXthRefDocNo'] : $paDataWhere['tRefDocNoOld'] );

        if( $paDataAddEdit['FTXthRefType'] == '1' ){
            $this->db->where('FTXthRefType','1');
            $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->where('FTXthDocKey',$paDataWhere['FTXthDocKey']);
            $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
            $this->db->delete('TCNTDocHDRefTmp');
        }

        $tSQL = " SELECT FTXthRefDocNo FROM TCNTDocHDRefTmp
                  WHERE FTXthDocNo    = '".$paDataWhere['FTXthDocNo']."'
                    AND FTXthDocKey   = '".$paDataWhere['FTXthDocKey']."'
                    AND FTSessionID   = '".$paDataWhere['FTSessionID']."'
                    AND FTXthRefDocNo = '".$tRefDocNo."' ";
        $oQuery = $this->db->query($tSQL);
        $this->db->trans_begin();
        if ( $oQuery->num_rows() > 0 ){
            $this->db->where('FTXthRefDocNo',$tRefDocNo);
            $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->where('FTXthDocKey',$paDataWhere['FTXthDocKey']);
            $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
            $this->db->update('TCNTDocHDRefTmp',$paDataAddEdit);
        }else{
            $aDataAdd = array_merge($paDataAddEdit,array(
                'FTXthDocNo'  => $paDataWhere['FTXthDocNo'],
                'FTXthDocKey' => $paDataWhere['FTXthDocKey'],
                'FTSessionID' => $paDataWhere['FTSessionID'],
                'FDCreateOn'  => $paDataWhere['FDCreateOn'],
            ));
            $this->db->insert('TCNTDocHDRefTmp',$aDataAdd);
        }

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => 'Add/Edit HDDocRef Error'
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Add/Edit HDDocRef Success'
            );
        }
        return $aResult;
    }

    // แท็บ อ้างอิงเอกสาร - ลบ
    public function FSaMTBOEventDelHDDocRef($paData){
        $tDocNo       = $paData['FTXthDocNo'];
        $tRefDocNo    = $paData['FTXthRefDocNo'];
        $tDocKey      = $paData['FTXthDocKey'];
        $tSessionID   = $paData['FTSessionID'];

        $this->db->where('FTSessionID',$tSessionID);
        $this->db->where('FTXthDocKey',$tDocKey);
        $this->db->where('FTXthRefDocNo',$tRefDocNo);
        $this->db->where('FTXthDocNo',$tDocNo);
        $this->db->delete('TCNTDocHDRefTmp');

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => 'Delete HD Doc Ref Error'
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Delete HD Doc Ref Success'
            );
        }
        return $aResult;
    }

    //ย้ายข้อมูลจาก TempHDDocRef => ตารางจริง
    public function FSxMTBOMoveHDRefTmpToHDRef($paDataWhere){
        $tBchCode     = $paDataWhere['FTBchCode'];
        $tDocNo       = $paDataWhere['FTXthDocNo'];
        $tSessionID   = $this->session->userdata('tSesSessionID');

        if(isset($tDocNo) && !empty($tDocNo)){
            $this->db->where('FTBchCode',$tBchCode);
            $this->db->where('FTXthDocNo',$tDocNo);
            $this->db->delete('TCNTPdtTboHDDocRef');
        }

        $tSQL   =   "   INSERT INTO TCNTPdtTboHDDocRef (FTAgnCode, FTBchCode, FTXthDocNo, FTXthRefType, FTXthRefDocNo, FTXthRefKey, FDXthRefDocDate) ";
        $tSQL   .=  "   SELECT
                            ''          AS FTAgnCode,
                            '$tBchCode' AS FTBchCode,
                            FTXthDocNo,
                            FTXthRefType,
                            FTXthRefDocNo,
                            FTXthRefKey,
                            FDXthRefDocDate
                        FROM TCNTDocHDRefTmp WITH (NOLOCK)
                        WHERE FTXthDocNo  = '$tDocNo'
                          AND FTXthDocKey = 'TCNTPdtTboHD'
                          AND FTSessionID = '$tSessionID' ";
        $this->db->query($tSQL);

        // Insert ตารางใบขอโอน - สาขา
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->where('FTXthRefDocNo',$tDocNo);
        $this->db->delete('TCNTPdtReqBchHDDocRef');
        // echo $this->db->last_query();
        // echo "<br>";

        $tSQL   =   "   INSERT INTO TCNTPdtReqBchHDDocRef (FTAgnCode, FTBchCode, FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate) ";
        $tSQL   .=  "   SELECT
                            ''              AS FTAgnCode,
                            '$tBchCode'     AS FTBchCode,
                            FTXthRefDocNo   AS FTXthDocNo,
                            FTXthDocNo      AS FTXthRefDocNo,
                            2               AS FTXthRefType,
                            'TBO'           AS FTXthRefKey,
                            FDXthRefDocDate
                        FROM TCNTDocHDRefTmp WITH (NOLOCK)
                        WHERE FTXthDocNo  = '$tDocNo'
                          AND FTXthDocKey = 'TCNTPdtTboHD'
                          AND FTSessionID = '$tSessionID'
                          AND FTXthRefKey = 'TRB' ";
        $this->db->query($tSQL);
        // echo $this->db->last_query();
        // echo "<br>";

    }

    //ข้อมูล HDDocRef
    public function FSxMTBOMoveHDRefToHDRefTemp($paData){

        $tDocNo         = $paData['tDocNo'];
        $tSessionID     = $this->session->userdata('tSesSessionID');

        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocKey','TCNTPdtTboHD');
        $this->db->where('FTSessionID',$tSessionID);
        $this->db->delete('TCNTDocHDRefTmp');

        $tSQL = "   INSERT INTO TCNTDocHDRefTmp (FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate, FTXthDocKey, FTSessionID , FDCreateOn)";
        $tSQL .= "  SELECT
                        FTXthDocNo,
                        FTXthRefDocNo,
                        FTXthRefType,
                        FTXthRefKey,
                        FDXthRefDocDate,
                        'TCNTPdtTboHD' AS FTXthDocKey,
                        '$tSessionID'  AS FTSessionID,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn
                    FROM TCNTPdtTboHDDocRef WITH(NOLOCK)
                    WHERE FTXthDocNo = '$tDocNo' ";
        $this->db->query($tSQL);
    }


    // ตรวจสอบ จำนวนจัดสินค้าไม่เท่ากับจำนวนสั่งสินค้า
    public function FSaMTBOChkQtyOnPack($ptDocNo){
        $tSQL = "   SELECT
                        A.FTPdtCode
                    FROM (
                        SELECT
                            TBODT.FTPdtCode						AS FTPdtCode
                            ,SUM(ISNULL(ORDDT.FCXtdQtyOrd,0))	AS FCXtdQtyOrd
                            ,SUM(ISNULL(PICK.FCXtdQty,0))		AS FCXtdQtyPick
                        FROM TCNTPdtTboHDDocRef TBO WITH(NOLOCK)
                        INNER JOIN TCNTPdtTboDT TBODT WITH(NOLOCK) ON TBO.FTXthDocNo = TBODT.FTXthDocNo
                        LEFT JOIN (
                            SELECT PICKHD.FTXthDocNo, PICKDT.FTPdtCode, SUM(ISNULL(PICKDT.FCXtdQty,0)) AS FCXtdQty
                            FROM TCNTPdtPickHD PICKHD WITH(NOLOCK)
                            LEFT JOIN TCNTPdtPickDT PICKDT WITH(NOLOCK) ON PICKHD.FTXthDocNo = PICKDT.FTXthDocNo
                            WHERE PICKHD.FTXthStaApv = '1'
                            GROUP BY PICKHD.FTXthDocNo, PICKDT.FTPdtCode
                        ) PICK ON TBO.FTXthRefDocNo = PICK.FTXthDocNo AND TBODT.FTPdtCode = PICK.FTPdtCode
                        LEFT JOIN (
                            SELECT FTXthDocNo,FTPdtCode, SUM(ISNULL(FCXtdQtyOrd,0)) AS FCXtdQtyOrd
                            FROM TCNTPdtPickDT WITH(NOLOCK)
                            GROUP BY FTXthDocNo, FTPdtCode
                        ) ORDDT ON TBO.FTXthRefDocNo = ORDDT.FTXthDocNo AND TBODT.FTPdtCode = ORDDT.FTPdtCode
                        WHERE TBO.FTXthDocNo	= '$ptDocNo'
                          AND TBO.FTXthRefType	= '2'
                          AND TBO.FTXthRefKey	= 'PdtPick'
                        GROUP BY TBODT.FTPdtCode
                    ) A
                    WHERE A.FCXtdQtyOrd <> A.FCXtdQtyPick
                 ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'tCode'    => '1',
                'tDesc'    => 'found data',
            );
        }else{
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 12/01/2022
    // ดึง Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSaMTBOGetConfigGenDocPack(){
        $tSQL = "   SELECT
                        FTSysSeq,
                        CASE WHEN ISNULL(FTSysStaUsrValue,'') = '' THEN FTSysStaDefValue ELSE FTSysStaUsrValue END AS FTValue
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE FTSysCode = 'bCN_CondSplitDoc'
                      AND FTSysApp = 'CN'
                      AND FTSysKey = 'TCNTPdtPickHD' ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'found config',
            );
        }else{
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'config not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 12/01/2022
    // บันทึก Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSaMTBOSaveConfigGenDocPack($ptCondWhereIn){
        $this->db->trans_begin();
        if( !empty($ptCondWhereIn) ){
            // อัพเดท 1 ตัวที่เลือกบนหน้าจอ
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '1'
                        WHERE FTSysCode = 'bCN_CondSplitDoc'
                          AND FTSysApp  = 'CN'
                          AND FTSysKey  = 'TCNTPdtPickHD'
                          AND FTSysSeq  IN ($ptCondWhereIn) ";
            $this->db->query($tSQL);

            // อัพเดท 2 ตัวที่ไม่เลือกบนหน้าจอ
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '2'
                        WHERE FTSysCode = 'bCN_CondSplitDoc'
                          AND FTSysApp  = 'CN'
                          AND FTSysKey  = 'TCNTPdtPickHD'
                          AND FTSysSeq  NOT IN ($ptCondWhereIn) ";
            $this->db->query($tSQL);
        }else{
            // กรณีไม่เลือกบนหน้าจอ ทุกรายการ ให้อัพเดท 2 ทั้งหมด
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '2'
                        WHERE FTSysCode = 'bCN_CondSplitDoc'
                          AND FTSysApp  = 'CN'
                          AND FTSysKey  = 'TCNTPdtPickHD' ";
            $this->db->query($tSQL);
        }

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => $this->db->error()['message']
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Update Config Success'
            );
        }
        return $aResult;

    }

    // Create By : Napat(Jame) 24/01/2022
    // ตรวจสอบว่าเอกสารใบจ่ายโอน-สาขา ถูกอ้างอิงไปแล้วหรือไม่ ?
    // ถ้าถูกอ้างอิงไปแล้ว จะลบไม่ได้ ต้องไปลบเอกสารอ้างอิงก่อน
    public function FSaMTBOChkAlwCancel($ptDocNo){
        $tSQL   = " SELECT FTXthRefKey FROM TCNTPdtTboHDDocRef WITH(NOLOCK) WHERE FTXthDocNo = '$ptDocNo' AND FTXthRefType = '2' ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'ไม่สามารถยกเลิกได้ เนื่องจากเอกสารนี้ ถูกอ้างอิงอยู่',
            );
        }else{
            $aResult    = array(
                'tCode'    => '1',
                'tDesc'    => 'สามารถยกเลิกได้',
            );
        }
        return $aResult;
    }




}
