<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCardShiftTopUp extends CI_Model
{
    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftTopUpSearchByID($ptAPIReq, $ptMethodReq, $paData)
    {
        $tCardShiftTopUpDocNo = $paData['FTXshDocNo'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                CRDHD.FTXshDocNo AS rtCardShiftTopUpDocNo,
                CRDHD.FTBchCode AS rtCardShiftTopUpBchCode,
                CRDHD.FNXshDocType AS rtCardShiftTopUpDocType,
                CRDHD.FDXshDocDate AS rtCardShiftTopUpDocDate,
                CRDHD.FTUsrCode AS rtCardShiftTopUpUsrCode,
                CRDHD.FTXshApvCode AS rtCardShiftTopUpApvCode,
                CRDHD.FNXshCardQty AS rtCardShiftTopUpCardQty,
                CRDHD.FCXshTotal AS rtCardShiftTopUpTotalTP,
                CRDHD.FTXshStaPrcDoc AS rtCardShiftTopUpStaPrcDoc,
                CRDHD.FTXshStaDoc AS rtCardShiftTopUpStaDoc,
                CRDHD.FTXshStaDelMQ AS rtCardShiftTopUpStaDelMQ,
                CRDHD.FTXshStaApv,
                BCHL.FTBchCode,
                BCHL.FTBchName
            FROM [TFNTCrdTopUpHD] CRDHD WITH(NOLOCK)
            LEFT JOIN TCNMBranch_L BCHL ON CRDHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '$nLngID'
            WHERE 1=1
        ";
        $tSQL .= " AND CRDHD.FTXshDocNo = '$tCardShiftTopUpDocNo'";
        $tSQL .= " AND CRDHD.FNXshDocType = '3'"; /* 3: Top Up */

        /*if($tCardShiftTopUpDocNo != ""){
            $tSQL .= "AND CRDHD.FTXshDocNo = '$tCardShiftTopUpDocNo'";
        }*/

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems' => $oDetail[0],
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
     * Functionality : List Card Shift HD
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftTopUpList($ptAPIReq, $ptMethodReq, $paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tUserLevel = $paData['tUserLevel'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT ROW_NUMBER() OVER(ORDER BY rtFDCreateOn DESC) AS rtRowID,*
                FROM
                    (SELECT DISTINCT
                        CRDHD.FTBchCode AS rtCardShiftTopUpBchCode,
                        CRDHD.FTXshDocNo AS rtCardShiftTopUpDocNo,
                        CRDHD.FDXshDocDate AS rtCardShiftTopUpDocDate,
                        CRDHD.FNXshCardQty AS rtCardShiftTopUpCthCardQty,
                        CRDHD.FTXshStaDoc AS rtCardShiftTopUpCthStaDoc,
                        CRDHD.FTXshStaApv AS rtCardShiftTopUpCthStaApv,
                        CRDHD.FTXshStaPrcDoc AS rtCardShiftTopUpCthStaPrcDoc,
                        CRDHD.FDCreateOn AS rtFDCreateOn
                    FROM [TFNTCrdTopUpHD] CRDHD
                    WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= " AND CRDHD.FNXshDocType = '3'"; // 1: Top up

        $tSearchList = $paData['tSearchAll'];
        $oAdvanceSearch = $paData['tAdvanceSearch'];

        if (!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)) {
            $tSQL .= " AND ((CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }

        $tSearchStaDoc = $oAdvanceSearch->tSearchStaDoc;
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND CRDHD.FTXshStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(CRDHD.FTXshStaApv,'') = '' AND CRDHD.FTXshStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND CRDHD.FTXshStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        // $tSearchStaPrc = $oAdvanceSearch->tSearchStaPrc;
        // if (isset($tSearchStaPrc) && !empty($tSearchStaPrc)) {
        //     if ($tSearchStaPrc == 3) {
        //         $tSQL .= " AND (CRDHD.FTXshStaPrcDoc = '$tSearchStaPrc' OR ISNULL(CRDHD.FTXshStaPrcDoc,'') = '') ";
        //     } else {
        //         $tSQL .= " AND CRDHD.FTXshStaPrcDoc = '$tSearchStaPrc'";
        //     }
        // }


        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $oAdvanceSearch->tSearchStaDocAct;
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND CRDHD.FNXshStaDocAct = 1";
            } else {
                $tSQL .= " AND CRDHD.FNXshStaDocAct = 0";
            }
        }



        if ($tSearchList != '') {
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CRDHD.FTXshDocNo LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCardShiftTopUpGetPageAll($tSearchList, $paData);
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
     * Functionality : List Card
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftTopUpDataSourceList($paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tStaShift = $paData['FTCrdStaShift'];
        $tStaType = $paData['tStaType'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY rtCrdCode ASC) AS rtRowID,*
                FROM
                (SELECT DISTINCT
                    CRD.FTCrdCode AS rtCrdCode,
                    CRDL.FTCrdName AS rtCrdName,
                    CRD.FTCrdHolderID AS rtCrdHolderID,
                    CRDT.FTCtyCode AS rtCtyCode,
                    CRDT.FCCtyTopupAuto AS rtCtyTopupAuto,
                    CRDTL.FTCtyName AS rtCtyName,
                    CONVERT(VARCHAR(10),CRD.FDCrdStartDate,121) AS rtCrdStartDate,
                    CONVERT(VARCHAR(10),CRD.FDCrdExpireDate,121) AS rtCrdExpireDate,
                    CRD.FCCrdValue AS rtCrdValue,
                    CRD.FCCrdDeposit AS rtCrdDeposit,
                    CRD.FTCrdStaShift AS rtCrdStaShift,
                    CRD.FTCrdStaActive AS rtCrdStaActive,
                    CRDT.FTCtyStaShift AS rtCrdStaType,
                    CONVERT(VARCHAR(10),CRD.FDCrdLastTopup,121) AS rtCrdLastTopup
                FROM [TFNMCard] CRD WITH (NOLOCK)
                LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
                LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $nLngID
                WHERE 1=1
                AND CRD.FTCrdStaActive = '1'
                AND (CRDT.FTCtyStaShift = '1' OR CRDT.FTCtyStaShift = '2')
        ";

        if ($tStaType == "1") { // Approved type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if ($tStaType == "2") { // Cancel type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if ($tStaType == "3") { // Pending type
            $tSQL .= " AND CRD.FTCrdStaShift = $tStaShift";
        }

        if (FCNnHSizeOf($paData['aCardNumber']) > 0) {
            $tCardNumber = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode IN ($tCardNumber))";
        }

        if (FCNnHSizeOf($paData['aCardTypeRange']) == 2) {
            $tCardTypeRange = $paData['aCardTypeRange'];
            $tSQL .= " AND ((CRDT.FTCtyCode BETWEEN '$tCardTypeRange[0]' AND '$tCardTypeRange[1]') OR (CRDT.FTCtyCode BETWEEN '$tCardTypeRange[1]' AND '$tCardTypeRange[0]'))";
        }

        if (FCNnHSizeOf($paData['aCardNumberRange']) == 2) {
            $tCardNumberRange = $paData['aCardNumberRange'];
            $tSQL .= " AND ((CRD.FTCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]') OR (CRD.FTCrdCode BETWEEN '$tCardNumberRange[1]' AND '$tCardNumberRange[0]'))";
        }

        if (FCNnHSizeOf($paData['aNotInCardNumber']) > 0) {
            $tNotInCardNumber = implode(',', $paData['aNotInCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode NOT IN ($tNotInCardNumber))";
        }
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            // $tSQL .= " AND (CardShiftTopUp.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CardShiftTopUpL.FTCgpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSaMCardShiftTopUpDataSourceGetPageAll($tSearchList, $nLngID, $paData);
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
            //No Data
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
     * Functionality : All Page Of Card
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftTopUpDataSourceGetPageAll($ptSearchList, $ptLngID, $paData)
    {
        $tStaShift = $paData['FTCrdStaShift'];

        $tSQL = "
            SELECT
                COUNT (CRD.FTCrdCode) AS counts
            FROM [TFNMCard] CRD WITH (NOLOCK)
            LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $$ptLngID
            LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
            LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $ptLngID
            WHERE 1=1
            AND CRD.FTCrdStaActive = '1'
            AND CRDT.FTCtyStaShift = '1'
            AND CRD.FTCrdStaShift = '$tStaShift'
        ";

        if (FCNnHSizeOf($paData['aCardNumber']) > 0) {
            $tCardNumbers = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode IN ($tCardNumbers))";
        }

        if (FCNnHSizeOf($paData['aCardTypeRange']) == 2) {
            $tCardTypeRange = $paData['aCardTypeRange'];
            $tSQL .= " AND (CRDT.FTCtyCode BETWEEN '$tCardTypeRange[0]' AND '$tCardTypeRange[1]')";
            if (FCNnHSizeOf($paData['aNotInCardNumber']) > 0) {
                $tNotInCardNumber = implode(',', $paData['aNotInCardNumber']);
                $tSQL .= " AND (CRDT.FTCtyCode NOT IN ($tNotInCardNumber))";
            }
        }

        if (FCNnHSizeOf($paData['aCardNumberRange']) == 2) {
            $tCardNumberRange = $paData['aCardNumberRange'];
            $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]')";
        }

        if ($ptSearchList != '') {
            // $tSQL .= " AND (CardShiftTopUp.FTCgpCode LIKE '%$ptSearchList%'";
            // $tSQL .= " OR CardShiftTopUpL.FTCgpName LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    /**
     * Functionality : All Page Of Card Shift HD
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCardShiftTopUpGetPageAll($ptSearchList, $paData)
    {
        $tSQL = "
            SELECT
                COUNT (CRDHD.FTBchCode) AS counts
            FROM [TFNTCrdTopUpHD] CRDHD
            WHERE 1=1
        ";

        // BchCode is empty = HQ(use all)
        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        // BchCode is empty = HQ(use all)
        $tSQL .= " AND CRDHD.FNXshDocType = '3'"; // 1: Top up

        $oAdvanceSearch = $paData['tAdvanceSearch'];

        if (!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)) {
            $tSQL .= " AND ((CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if (!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")) {
            $tSQL .= " AND CRDHD.FTXshStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if (!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")) {

            if ($oAdvanceSearch->tSearchStaApprove == "1") { // Approved
                $tSQL .= " AND CRDHD.FTXshStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "2") { // Approved
                $tSQL .= " AND CRDHD.FTXshStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "3") { // Pending approved
                $tSQL .= " AND (CRDHD.FTXshStaPrcDoc IS NULL OR CRDHD.FTXshStaPrcDoc = '') AND CRDHD.FTXshStaDoc != 3";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "4") { // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTXshStaPrcDoc IS NULL OR CRDHD.FTXshStaPrcDoc = '') AND CRDHD.FTXshStaDoc = 3";
            }
        }
        if ($ptSearchList != '') {
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CRDHD.FTXshDocNo LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptCardShiftTopUpCode
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftTopUpCheckDuplicate($ptCardShiftTopUpCode)
    {
        $tSQL = "
            SELECT
                COUNT(FTXshDocNo) AS counts
            FROM TFNTCrdTopUpHD WITH (NOLOCK)
            WHERE FTXshDocNo = '$ptCardShiftTopUpCode'
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftTopUpAddUpdateHD($paData)
    {
        // Update HD
        $this->db->set('FDXshDocDate', $paData['FDXshDocDate']);
        $this->db->set('FTXshApvCode', $paData['FTXshApvCode']);
        $this->db->set('FNXshCardQty', $paData['FNXshCardQty']);
        $this->db->set('FTBchCode', $paData['FTBchCode']);
        $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
        $this->db->set('FNXshStaDocAct', $paData['FNXshStaDocAct']);

        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

        if ($paData['FTXshStaPrcDoc'] == "1") {
            $this->db->set('FTXshStaPrcDoc', $paData['FTXshStaPrcDoc']);
        }
        if (!empty($paData['FTXshStaDoc'])) {
            $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
        }
        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FNXshDocType', $paData['FNXshDocType']);
        $this->db->update('TFNTCrdTopUpHD');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            // Add HD
            $this->db->insert('TFNTCrdTopUpHD', array(
                'FTXshDocNo' => $paData['FTXshDocNo'],
                'FDXshDocDate' => $paData['FDXshDocDate'],
                'FNXshDocType' => $paData['FNXshDocType'],
                'FTBchCode' => $paData['FTBchCode'],
                'FTUsrCode' => $paData['FTUsrCode'],
                'FNXshCardQty' => $paData['FNXshCardQty'],
                // 'FCXshTotal' => $paData['FCXshTotal'],
                'FTXshStaDoc' => $paData['FTXshStaDoc'],
                'FNXshStaDocAct' => $paData['FNXshStaDocAct'],
                'FDCreateOn' => $paData['FDCreateOn'],
                'FTCreateBy' => $paData['FTCreateBy']
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
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftTopUpUpdateApvDocAndCancelDocHD($paData)
    {
        // Update HD
        // $this->db->set('FDXshDocDate' , $paData['FDXshDocDate']);
        // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
        // $this->db->set('FTXshApvCode' , $paData['FTXshApvCode']);
        // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
        // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
        // $this->db->set('FNXshCardQty' , $paData['FNXshCardQty']);

        // $this->db->set('FTXshStaDoc' , $paData['FTXshStaDoc']);
        // $this->db->set('FNXshStaDocAct' , $paData['FNXshStaDocAct']);

        if ($paData['FTXshStaPrcDoc'] == "2" && $paData['FTXshStaDoc'] == "1") {
            $this->db->set('FTXshStaPrcDoc', $paData['FTXshStaPrcDoc']);
            $this->db->set('FTXshApvCode', $paData['FTXshApvCode']);
        }

        if (!empty($paData['FTXshStaDoc']) && empty($paData['FTXshStaPrcDoc'])) {
            $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        }

        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FNXshDocType', $paData['FNXshDocType']);
        $this->db->update('TFNTCrdTopUpHD');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }
        return $aStatus;
    }

    /**
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftTopUpAddUpdateDT($paData)
    {
        // Add DT
        $this->db->insert('TFNTCrdTopUpDT', array(
            'FTBchCode' => $paData['FTBchCode'],
            'FTXshDocNo' => $paData['FTXshDocNo'],
            'FNXsdSeqNo'  => $paData['FNXsdSeqNo'],
            'FTCrdCode' => $paData['FTCrdCode'],
            'FCXsdAmt' => $paData['FCXsdAmt'],
            'FTXsdStaPrc'  => $paData['FTXsdStaPrc'],
            'FTXsdRmk' => $paData['FTXsdRmk'],
            'FDCreateOn' => $paData['FDCreateOn'],
            'FTCreateBy'  => $paData['FTCreateBy'],
            'FDLastUpdOn' => $paData['FDLastUpdOn'],
            'FTLastUpdBy'  => $paData['FTLastUpdBy']
        ));

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }
        return $aStatus;
    }

    /**
     * Functionality : Update Card Table
     * Parameters : $paData is data for update
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftTopUpUpdateCard($paData)
    {
        // Update Card
        $this->db->join('TFNMCardType', 'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode');
        $this->db->set('FCCrdValue', $paData['FCCrdValue']);
        $this->db->set('FDCrdLastTopup', $paData['FDCrdLastTopup']);
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        $this->db->where('FTCrdCode', $paData['FTCrdCode']);
        $this->db->where('TFNMCardType.FTCtyStaShift', $paData['FTCrdStaType']);
        $this->db->where('FTCrdStaShift', 3); // Out only
        $this->db->update('TFNMCard');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Card',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Update Card.',
            );
        }
        return $aStatus;
    }

    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftTopUpDel($paData)
    {
        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpDT');

        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FNXshDocType', $paData['FNXshDocType']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpHD');

        /*if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;*/

        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }

    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftTopUpDelDT($paData)
    {
        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpDT');

        /*if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;*/

        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }

    /**
     * Functionality : Get Card Shift DT
     * Parameters : $paData Filter by DocNo and BchCode
     * Creator : 12/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftTopUpGetDTByDocNo($paData)
    {
        $tCardShiftTopUpDocNo = $paData['FTXshDocNo'];
        $tCardShiftTopUpBchCode = $paData['FTBchCode'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                CRDDT.FTXshDocNo AS rtCardShiftTopUpDocNo,
                CRDDT.FTBchCode AS rtCardShiftTopUpBchCode,
                CRDDT.FTCrdCode AS rtCardShiftTopUpCrdCode,
                CRDDT.FNXsdSeqNo AS rtCardShiftTopUpSeqNo,
                CRDDT.FCXsdAmt AS rtCardShiftTopUpCrdTP,
                ((CARDB.CashIn + CARDB.Promotion) - CARDB.Payment) AS rtCardShiftTopUpCrdBal,
                CRDDT.FCXsdAmtPmt AS rtCardShiftTopUpAmtPmt,
                CRDDT.FTXsdRmk AS rtCardShiftTopUpRmk,
                CRD.FTCrdStaShift AS rtCardShiftTopUpCrdStaShift,
                CRD.FTCrdStaActive AS rtCardShiftTopUpCrdStaActive,
                CRD.FDCrdExpireDate AS rtCardShiftTopUpCrdExpireDate,
                CRDL.FTCrdName AS rtCardShiftTopUpCrdName,
                CRDT.FTCtyStaShift AS rtCardShiftTopUpCtyStaShift,
                CRDT.FTCtyStaPay AS rtCardShiftTopUpCtyStaPay
            FROM [TFNTCrdTopUpDT] CRDDT WITH (NOLOCK)
            LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CRDDT.FTCrdCode
            LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRDL.FTCrdCode = CRDDT.FTCrdCode AND CRDL.FNLngID = $nLngID
            LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
            LEFT JOIN
            (
                SELECT
                    CRD.FTCrdCode,
                    SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                    THEN ISNULL(CRDB.FCCrdValue,0)
                    ELSE 0
                    END) CashIn ,
                    SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                    THEN ISNULL(CRDB.FCCrdValue,0)
                    ELSE 0
                    END) Promotion ,
                    SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                    THEN ISNULL(CRDB.FCCrdValue,0)
                    ELSE 0
                    END) DepositCrd ,
                    SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                    THEN ISNULL(CRDB.FCCrdValue,0)
                    ELSE 0
                    END) DepositPdt ,
                    SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                    THEN ISNULL(CRDB.FCCrdValue,0)
                    ELSE 0
                    END) NotReturn ,
                    SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                    THEN ISNULL(CRDB.FCCrdValue,0)
                    ELSE 0
                    END) Payment
                FROM TFNMCard CRD WITH (NOLOCK)
                LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                GROUP BY CRD.FTCrdCode
            ) CARDB ON CARDB.FTCrdCode = CRDDT.FTCrdCode

            WHERE 1=1
            AND CRDDT.FTBchCode = '$tCardShiftTopUpBchCode'
            AND CRDDT.FTXshDocNo = '$tCardShiftTopUpDocNo'
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
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
     * Functionality : Get Card Shift
     * Parameters : $paData Filter by DocNo and BchCode
     * Creator : 12/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftTopUpGetCardById($paData)
    {
        $tCardShiftTopUpCardCode = $paData['FTCrdCode'];

        $tSQL = "
            SELECT
                CRD.FTCrdCode AS rtCardShiftTopUpCrdCode,
                CRD.FDCrdLastTopup AS rtCardShiftTopUpLastTopup,
                CRD.FCCrdValue AS rtCardShiftTopUpCrdValue,
                CRD.FTCtyStaShift AS rtCardShiftTopUpStaType,
                CRD.FTCrdStaShift AS rtCardShiftTopUpStaShift,
                CRD.FTCrdStaActive AS rtCardShiftTopUpStaActive
            FROM [TFNMCard] CRD WITH (NOLOCK)
            LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
            WHERE 1=1
            AND CRD.FTCrdStaActive = '1'
            AND CRDT.FTCtyStaShift = '1'
            AND CRD.FTCrdCode = '$tCardShiftTopUpCardCode'
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems' => $oDetail[0],
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


    // Create BY Witsarut 25-11-2020
    // function Delete for siggle
    public function FSnMCardShiftTopUpDeldata($paDataDel){
        $this->db->trans_begin();

        $this->db->where_in('FTXshDocNo', $paDataDel['FTXshDocNo']);
        $this->db->where('FTBchCode', $paDataDel['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpDT');

        $this->db->where_in('FTXshDocNo', $paDataDel['FTXshDocNo']);
        $this->db->where('FTBchCode', $paDataDel['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpHD');

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aStaDelete = array(
                'rtCode'      => '905',
                'reDesc'      => 'Cannot Delete Item',
            );
        }else{
            $this->db->trans_commit();
            $aStaDelete = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }
        return $aStaDelete;
    }

    // Create By Witsarut 23-11-2020
    // function Delete Multi
    public function FSaMDelMultiMaster($paParams = []){
        try{
            $tDocNo = $paParams['tDocNo'];

            $this->db->where_in('FTXshDocNo', $tDocNo);
            $this->db->delete('TFNTCrdTopUpDT');

            $this->db->where_in('FTXshDocNo', $tDocNo);
            $this->db->delete('TFNTCrdTopUpHD');

        }catch(Exception $Error){
            return $Error;
        }

    }

    //Function Scanner สามารถไปเอามาจาก JS Browse ได้
    public function FSaMCardShiftTopUpListScanner($paData){

        $tAgnCode   = $paData['tAgnCode'];
        $tCrdCode   = $paData['tCrdCode'];
        $tLangID    = $paData['tLangID'];
        $tSessionID = $this->session->userdata("tSesSessionID");

        //เช็คก่อนว่าบัตรใบนี้เคยเพิ่มลง Temp หรือยัง ถ้ายังจะค้นหาได้ แต่ถ้าเคยมีเเล้ว จะจบทันที่
        $tSQL       = " SELECT FTCrdCode FROM TFNTCrdTopUpTmp WHERE FTCrdCode = '$tCrdCode' AND FTSessionID = '$tSessionID' ";
        $oQuery     = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = array(
                'raItems'     => [],
                'rtCode'      => '801',
                'rtDesc'      => 'data duplicate',
            );
        }else{
            $tSQL    = "SELECT TFNMCard.FTCrdCode,TFNMCard_L.FTCrdName
                        FROM TFNMCard
                        LEFT JOIN TFNMCard_L ON TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '$tLangID'
                        LEFT JOIN TFNMCardType ON TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode
                        WHERE TFNMCard.FTCrdStaActive = '1' AND TFNMCardType.FTCtyStaPay = '1' AND TFNMCard.FTCrdCode ='$tCrdCode'
                        AND ((TFNMCard.FTCrdStaShift = '2' AND TFNMCardType.FTCtyStaShift = '1') OR TFNMCardType.FTCtyStaShift = '2')
                        AND (CONVERT (DATE,TFNMCard.FDCrdExpireDate) > CONVERT (DATE, GETDATE()))
                        AND TFNMCard.FTAgnCode = '$tAgnCode'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result();
                $aResult = array(
                    'raItems'     => $oDetail,
                    'rtCode'      => '1',
                    'rtDesc'      => 'success',
                );
            }else{
                $aResult = array(
                    'raItems'     => [],
                    'rtCode'      => '800',
                    'rtDesc'      => 'data not found.',
                );
            }
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
}
