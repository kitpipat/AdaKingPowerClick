<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mDeposit extends CI_Model
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

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTBdhDocNo DESC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        HD.*,
                        BCHL.FTBchName,
                        USRL.FTUsrName AS FTCreateByName,
                        USRLAPV.FTUsrName AS FTXthApvName
                    FROM TFNTBnkDplHD HD WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode
                    LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON HD.FTBdhUsrApv = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                    WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            // $tBchCode = $this->session->userdata('tSesUsrBchCode');
            // $tSQL .= "
            //     AND HD.FTBchCode = '$tBchCode'
            // ";
            $tBchCode =   $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= "
                 AND HD.FTBchCode IN ($tBchCode)
            ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];

        $tSearchList = $aAdvanceSearch['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTBdhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
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
            $tSQL .= " AND ((HD.FDBdhDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDBdhDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            // if ($tSearchStaDoc == 2) {
            //     $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc' OR HD.FTBdhStaDoc = ''";
            // } else {
            //     $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc'";
            // }

            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(HD.FTBdhStaApv,'') = '' AND HD.FTBdhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaDoc'";
            }
        }

            // ค้นหาสถานะเคลื่อนไหว
            $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
            if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
                if ($tSearchStaDocAct == 1) {
                    $tSQL .= " AND HD.FNBdhStaDocAct = 1";
                } else {
                    $tSQL .= " AND HD.FNBdhStaDocAct = 0";
                }
            }


        // // สถานะอนุมัติ
        // $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        // if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
        //     if ($tSearchStaApprove == 2) {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaApprove'";
        //     } else {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaApprove'";
        //     }
        // }

        // สถานะประมวลผล
        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {

        //     if ($tSearchStaPrcStk == 3) {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaPrcStk' OR HD.FTBdhStaApv = '' ";
        //     } else {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaPrcStk'";
        //     }
        // }

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
        $tSQL = "
            SELECT 
                HD.FTBdhDocNo
            FROM TFNTBnkDplHD HD WITH (NOLOCK)
            WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            // $tBchCode = $this->session->userdata('tSesUsrBchCode');
            // $tSQL .= "
            //     AND HD.FTBchCode = '$tBchCode'
            // ";
            $tBchCode =   $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= "
                 AND HD.FTBchCode IN ($tBchCode)
            ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];

        $tSearchList = $aAdvanceSearch['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTBdhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
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
            $tSQL .= " AND ((HD.FDBdhDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDBdhDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            // if ($tSearchStaDoc == 2) {
            //     $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc' OR HD.FTBdhStaDoc = ''";
            // } else {
            //     $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc'";
            // }

            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(HD.FTBdhStaApv,'') = '' AND HD.FTBdhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaDoc'";
            }
        }

            // ค้นหาสถานะเคลื่อนไหว
            $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
            if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
                if ($tSearchStaDocAct == 1) {
                    $tSQL .= " AND HD.FNBdhStaDocAct = 1";
                } else {
                    $tSQL .= " AND HD.FNBdhStaDocAct = 0";
                }
            }


        // // สถานะอนุมัติ
        // $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        // if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
        //     if ($tSearchStaApprove == 2) {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaApprove'";
        //     } else {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaApprove'";
        //     }
        // }

        // สถานะประมวลผล
        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {

        //     if ($tSearchStaPrcStk == 3) {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaPrcStk' OR HD.FTBdhStaApv = '' ";
        //     } else {
        //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaPrcStk'";
        //     }
        // }

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
                BCHL.FTBchName,
                CONVERT(CHAR(5), HD.FDBdhDate, 108)  AS FTXthDocTime,
                MCHL.FTMerName,
                SHP.FTShpType,
                SHPL.FTShpName,
                DPTL.FTBdtName,
                USRAPV.FTUsrName AS FTUsrNameApv,
                USRL.FTUsrName AS FTCreateByName,
                BBKL.FTBbkName,
                BBK.FTBbkType,
                BNKL.FTBnkName,
                BBK_BCHL.FTBchName AS FTBbkBchName,
                BBK.FTBbkAccNo
            FROM TFNTBnkDplHD HD WITH (NOLOCK)

            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMMerchant_L MCHL WITH (NOLOCK) ON HD.FTMerCode = MCHL.FTMerCode AND MCHL.FNLngID = $nLngID
            LEFT JOIN TFNMBnkDepType_L DPTL WITH(NOLOCK) ON DPTL.FTBdtCode = HD.FTBdtCode AND DPTL.FNLngID = $nLngID

            LEFT JOIN TCNMShop SHP WITH (NOLOCK) ON HD.FTShpCode = SHP.FTShpCode AND HD.FTBchCode = SHP.FTBchCode
            LEFT JOIN TCNMShop_L SHPL WITH (NOLOCK) ON HD.FTShpCode = SHPL.FTShpCode AND HD.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
            
            LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON HD.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRAPV WITH (NOLOCK) ON HD.FTBdhUsrApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
            
            LEFT JOIN TFNMBookBank BBK WITH(NOLOCK) ON BBK.FTBbkCode = HD.FTBbkCode
            LEFT JOIN TFNMBookBank_L BBKL WITH(NOLOCK) ON BBKL.FTBbkCode = HD.FTBbkCode AND BBKL.FNLngID = $nLngID
            LEFT JOIN TCNMBranch_L BBK_BCHL WITH (NOLOCK) ON BBK.FTBchCode = BBK_BCHL.FTBchCode AND BBK_BCHL.FNLngID = $nLngID

            LEFT JOIN TFNMBank_L BNKL WITH(NOLOCK) ON BNKL.FTBnkCode = BBK.FTBnkCode AND BNKL.FNLngID = $nLngID
            WHERE 1=1
        ";

        if ($tDocNo != "") {
            $tSQL .= " AND HD.FTBdhDocNo = '$tDocNo'";
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

    public function FSxMDeleteDoctemForNewEvent($paParams = [])
    {
        $tSQL = "
            DELETE FROM TCNTDocDTTmp 
            WHERE FTBchCode = '" . $paParams["tBchCode"] . "' 
            AND FTSessionID = '" . $this->session->userdata('tSesSessionID') . "' 
            AND FTXthDocKey = '" . $paParams["FTXthDocKey"] . "'
        ";
        $this->db->query($tSQL);
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
        $tBchCode = $paParams['tBchCode']; // สาขาที่เลือก
        // $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $nLngID = $paParams['nLngID'];

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL = "   
            INSERT TCNTDocDTTmp
                (FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FTXthDocKey,
                FTBddTypeForDeposit,
                FTBddRefNoForDeposit,
                FDBddRefDateForDeposit,
                FCBddRefAmtForDeposit,
                FTBddRefBnkNameForDeposit,
                FDLastUpdOn,
                FTLastUpdBy,
                FDCreateOn,
                FTCreateBy,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
                DT.FTBchCode,
                DT.FTBdhDocNo AS FTXthDocNo,
                DT.FNBddSeq AS FNXtdSeqNo,
                '$tDocKey' AS FTXthDocKey,
                DT.FTBddType AS FTBddTypeForDeposit,
                DT.FTBddRefNo AS FTBddRefNoForDeposit,
                DT.FDBddRefDate AS FDBddRefDateForDeposit,
                DT.FCBddRefAmt AS FCBddRefAmtForDeposit,
                BNKL.FTBnkName AS FTBddRefBnkNameForDeposit,
                DT.FDLastUpdOn,
                DT.FTLastUpdBy,
                DT.FDCreateOn,
                DT.FTCreateBy,
                '$tUserSessionID' AS FTSessionID
            FROM TFNTBnkDplDT DT WITH(NOLOCK)
            LEFT JOIN TFNTBnkDplHD HD WITH(NOLOCK) ON HD.FTBdhDocNo = DT.FTBdhDocNo
            LEFT JOIN TFNMBookCheque BC WITH(NOLOCK) On BC.FTChqCode = DT.FTBddRefNo
            LEFT JOIN TFNMBank_L BNKL WITH(NOLOCK) ON BNKL.FTBnkCode = BC.FTBbkCode AND BNKL.FNLngID = $nLngID
            WHERE DT.FTBchCode = '$tBchCode'
            AND DT.FTBdhDocNo = '$tDocNo'
            ORDER BY DT.FNBddSeq ASC
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
        $this->db->where('FTBdhDocNo', $tDocNo);
        $this->db->delete('TFNTBnkDplDT');

        $tSQL = "   
            INSERT TFNTBnkDplDT 
                (FTBchCode,
                FTBdhDocNo,
                FNBddSeq,
                FTBddType,
                FTBddRefNo,
                FDBddRefDate,
                FCBddRefAmt,
                FDLastUpdOn,
                FTLastUpdBy,
                FDCreateOn,
                FTCreateBy)
        ";

        $tSQL .= "  
            SELECT
                TMP.FTBchCode,
                TMP.FTXthDocNo AS FTBdhDocNo,
                TMP.FNXtdSeqNo AS FNBddSeq,
                TMP.FTBddTypeForDeposit AS FTBddType,
                ISNULL(TMP.FTBddRefNoForDeposit, '') AS FTBddRefNo,
                TMP.FDBddRefDateForDeposit AS FDBddRefDate,
                TMP.FCBddRefAmtForDeposit AS FCBddRefAmt,
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
                FTBdhDocNo
            FROM TFNTBnkDplHD
            WHERE FTBdhDocNo = '$ptDocNo'
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
        try {
            // Update Master
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FDBdhDate', $paParams['FDBdhDate']);
            $this->db->set('FTBdtCode', $paParams['FTBdtCode']);
            $this->db->set('FTMerCode', $paParams['FTMerCode']);
            $this->db->set('FTShpCode', $paParams['FTShpCode']);
            $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
            $this->db->set('FTBdhUsrSender', $paParams['FTBdhUsrSender']);
            $this->db->set('FTBdhUsrApv', $paParams['FTBdhUsrApv']);
            $this->db->set('FTBbkCode', $paParams['FTBbkCode']);
            $this->db->set('FTBdhRefExt', $paParams['FTBdhRefExt']);
            $this->db->set('FDBdhRefExtDate', $paParams['FDBdhRefExtDate']);
            $this->db->set('FCBdhTotCash', $paParams['FCBdhTotCash']);
            $this->db->set('FCBdhTotCheque', $paParams['FCBdhTotCheque']);
            $this->db->set('FCBdhTotChqChg', $paParams['FCBdhTotChqChg']);
            $this->db->set('FCBdhTotChqVat', $paParams['FCBdhTotChqVat']);
            $this->db->set('FCBdhTotal', $paParams['FCBdhTotal']);
            $this->db->set('FTBdhRmk', $paParams['FTBdhRmk']);
            $this->db->set('FTBdhStaDoc', $paParams['FTBdhStaDoc']);
            $this->db->set('FTBdhStaApv', $paParams['FTBdhStaApv']);
            $this->db->set('FNBdhStaDocAct', $paParams['FNBdhStaDocAct']);
            $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
            $this->db->where('FTBdhDocNo', $paParams['FTBdhDocNo']);
            $this->db->update('TFNTBnkDplHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TFNTBnkDplHD', array(
                    'FTBchCode' => $paParams['FTBchCode'],
                    'FTBdhDocNo' => $paParams['FTBdhDocNo'],
                    'FTBdtCode' => $paParams['FTBdtCode'],
                    'FDBdhDate' => $paParams['FDBdhDate'],
                    'FTMerCode' => $paParams['FTMerCode'],
                    'FTShpCode' => $paParams['FTShpCode'],
                    'FTUsrCode' => $paParams['FTUsrCode'],
                    'FTBdhUsrSender' => $paParams['FTBdhUsrSender'],
                    'FTBdhUsrApv' => $paParams['FTBdhUsrApv'],
                    'FTBbkCode' => $paParams['FTBbkCode'],
                    'FTBdhRefExt' => $paParams['FTBdhRefExt'],
                    'FDBdhRefExtDate' => $paParams['FDBdhRefExtDate'],
                    'FCBdhTotCash' => $paParams['FCBdhTotCash'],
                    'FCBdhTotCheque' => $paParams['FCBdhTotCheque'],
                    'FCBdhTotChqChg' => $paParams['FCBdhTotChqChg'],
                    'FCBdhTotChqVat' => $paParams['FCBdhTotChqVat'],
                    'FCBdhTotal' => $paParams['FCBdhTotal'],
                    'FTBdhRmk' => $paParams['FTBdhRmk'],
                    'FTBdhStaDoc' => $paParams['FTBdhStaDoc'],
                    'FTBdhStaApv' => $paParams['FTBdhStaApv'],
                    'FNBdhStaDocAct' => $paParams['FNBdhStaDocAct'],
                    'FDLastUpdOn' => $paParams['FDLastUpdOn'],
                    'FDCreateOn' => $paParams['FDCreateOn'],
                    'FTCreateBy' => $paParams['FTCreateBy'],
                    'FTLastUpdBy' => $paParams['FTLastUpdBy']
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
        // $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->where('FTXthDocNo', 'DPLDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocKey', $paParams['tDocKey']);
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
     * Functionality : Cancel Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMDocCancel($paParams = [])
    {
        try {
            // TFNTBnkDplHD
            $this->db->set('FTBdhStaDoc', '3');
            $this->db->where('FTBdhDocNo', $paParams['tDocNo']);
            $this->db->update('TFNTBnkDplHD');
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

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSaMDocApprove($paParams = [])
    {
        try {
            // TFNTBnkDplHD
            $this->db->set('FTBdhStaApv', '1');
            $this->db->set('FTBdhUsrApv', $paParams['tApvCode']);
            $this->db->where('FTBdhDocNo', $paParams['tDocNo']);

            $this->db->update('TFNTBnkDplHD');
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

            $this->db->where('FTBdhDocNo', $tDocNo);
            $this->db->delete('TFNTBnkDplHD');

            $this->db->where('FTBdhDocNo', $tDocNo);
            $this->db->delete('TFNTBnkDplDT');
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : คำนวณใน DT Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMCalInTmp($aParams = [])
    {
        $tUserSessionID = $aParams['tUserSessionID'];
        $tDocKey = $aParams['tDocKey'];

        $tSQL = "
            SELECT
                SUM(CASE 
                    WHEN TMP.FTBddTypeForDeposit = '1' THEN ISNULL(TMP.FCBddRefAmtForDeposit, 0)
                    ELSE 0
                END) AS FCBddRefAmtCashTotal,
                SUM(CASE 
                    WHEN TMP.FTBddTypeForDeposit = '2' THEN ISNULL(TMP.FCBddRefAmtForDeposit, 0)
                    ELSE 0
                END) AS FCBddRefAmtChequeTotal,
                SUM(ISNULL(TMP.FCBddRefAmtForDeposit, 0)) AS FCBddRefAmtTotal
            FROM TCNTDocDTTmp TMP WITH(NOLOCK)
            WHERE FTSessionID = '$tUserSessionID' AND FTXthDocKey = '$tDocKey'
            GROUP BY TMP.FTSessionID
        ";

        $oQuery = $this->db->query($tSQL);

        $aData = [
            'FCBddRefAmtCashTotal' => 0,
            'FCBddRefAmtChequeTotal' => 0,
            'FCBddRefAmtTotal' => 0
        ];

        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->row_array();
        }

        return $aData;
    }
}
