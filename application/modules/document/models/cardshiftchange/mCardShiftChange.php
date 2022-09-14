<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCardShiftChange extends CI_Model
{

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftChangeSearchByID($ptAPIReq, $ptMethodReq, $paData)
    {
        $tCardShiftChangeDocNo = $paData['FTCvhDocNo'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                CRDHD.FTCvhDocNo AS rtCardShiftChangeDocNo,
                CRDHD.FTBchCode AS rtCardShiftChangeBchCode,
                CRDHD.FTCvhDocType AS rtCardShiftChangeDocType,
                CRDHD.FDCvhDocDate AS rtCardShiftChangeDocDate,
                CRDHD.FTUsrCode AS rtCardShiftChangeUsrCode,
                CRDHD.FTCvhApvCode AS rtCardShiftChangeApvCode,
                CRDHD.FDCvhApvDate AS rtCardShiftChangeApvDate,
                CRDHD.FTCvhStaPrcDoc AS rtCardShiftChangeStaPrcDoc,
                CRDHD.FTCvhStaCrdActive AS rtCardShiftStaCrdActive,
                CRDHD.FNCvhCardQty AS rtCardShiftChangeCardQty,
                CRDHD.FTCvhStaDoc AS rtCardShiftChangeStaDoc,
                CRDHD.FTCvhStaDelMQ AS rtCardShiftChangeStaDelMQ,
                BCHL.FTBchCode,
                BCHL.FTBchName
            FROM [TFNTCrdVoidHD] CRDHD
            LEFT JOIN TCNMBranch_L BCHL ON CRDHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '$nLngID'
            WHERE 1=1
        ";
        $tSQL .= " AND CRDHD.FTCvhDocNo = '$tCardShiftChangeDocNo'";
        $tSQL .= " AND CRDHD.FTCvhDocType = '6'";

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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftChangeList($ptAPIReq, $ptMethodReq, $paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tUserLevel = $paData['tUserLevel'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT c.* 
            FROM(
                SELECT 
                    ROW_NUMBER() OVER(ORDER BY rtCardShiftChangeCreateOn DESC) AS rtRowID,*
                FROM(
                    SELECT DISTINCT
                        CRDHD.FTBchCode AS rtCardShiftChangeBchCode,
                        CRDHD.FTCvhDocNo AS rtCardShiftChangeDocNo,
                        CRDHD.FDCvhDocDate AS rtCardShiftChangeDocDate,
                        CRDHD.FNCvhCardQty AS rtCardShiftChangeCvhCardQty,
                        CRDHD.FTCvhStaDoc AS rtCardShiftChangeCvhStaDoc,
                        CRDHD.FTCvhApvCode AS rtCardShiftChangeCvhApvCode,
                        CRDHD.FTCvhStaPrcDoc AS rtCardShiftChangeCvhStaPrcDoc,
                        CRDHD.FDCreateOn AS rtCardShiftChangeCreateOn
                    FROM [TFNTCrdVoidHD] CRDHD
                    WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= " AND CRDHD.FTCvhDocType = '6'";

        $tSearchList = $paData['tSearchAll'];
        $oAdvanceSearch = $paData['tAdvanceSearch'];

        $tSearchStaDoc = $oAdvanceSearch->tSearchStaDoc;
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND CRDHD.FTCvhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(CRDHD.FTCvhApvCode,'') = '' AND CRDHD.FTCvhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND CRDHD.FTCvhApvCode IS NOT NULL";
            }
        }

        // ค้นหาสถานะประมวลผล
        // $tSearchStaPrc = $oAdvanceSearch->tSearchStaPrc;
        // if (isset($tSearchStaPrc) && !empty($tSearchStaPrc)) {
        //     if ($tSearchStaPrc == 3) {
        //         $tSQL .= " AND (CRDHD.FTCvhStaPrcDoc = '$tSearchStaPrc' OR ISNULL(CRDHD.FTCvhStaPrcDoc,'') = '') ";
        //     } else {
        //         $tSQL .= " AND CRDHD.FTCvhStaPrcDoc = '$tSearchStaPrc'";
        //     }
        // }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $oAdvanceSearch->tSearchStaAct;
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND CRDHD.FNCvhStaDocAct = 1";
            } else {
                $tSQL .= " AND CRDHD.FNCvhStaDocAct = 0";
            }
        }
        // if (!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)) {
        //     $tSQL .= " AND ((CRDHD.FDCvhDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCvhDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        // }
        // if (!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")) {
        //     $tSQL .= " AND CRDHD.FTCvhStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        // }
        // if (!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")) {

        //     if ($oAdvanceSearch->tSearchStaApprove == "1") { // Approved
        //         $tSQL .= " AND CRDHD.FTCvhStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
        //     }
        //     if ($oAdvanceSearch->tSearchStaApprove == "2") { // Approved
        //         $tSQL .= " AND CRDHD.FTCvhStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
        //     }
        //     if ($oAdvanceSearch->tSearchStaApprove == "3") { // Pending approved
        //         $tSQL .= " AND (CRDHD.FTCvhStaPrcDoc IS NULL OR CRDHD.FTCvhStaPrcDoc = '') AND CRDHD.FTCvhStaDoc != 3";
        //     }
        //     if ($oAdvanceSearch->tSearchStaApprove == "4") { // N/A Doc status(cancel)
        //         $tSQL .= " AND (CRDHD.FTCvhStaPrcDoc IS NULL OR CRDHD.FTCvhStaPrcDoc = '') AND CRDHD.FTCvhStaDoc = 3";
        //     }
        // }
        if ($tSearchList != '') {
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CRDHD.FTCvhDocNo LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCardShiftChangeGetPageAll($tSearchList, $paData);
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftChangeDataSourceList($paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tStaShift = $paData['FTCrdStaShift'];
        $tStaType = $paData['tStaType'];
        $tSQL = "
            SELECT c.* FROM(
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY rtCrdCode ASC) AS rtRowID,*
                FROM(
                    SELECT DISTINCT
                        CRD.FTCrdCode AS rtCrdCode,
                        CRDL.FTCrdName AS rtCrdName,
                        CRD.FTCrdHolderID AS rtCrdHolderID,
                        CRDT.FTCtyCode AS rtCtyCode,
                        CRDTL.FTCtyName AS rtCtyName,
                        CONVERT(VARCHAR(10),CRD.FDCrdStartDate,121) AS rtCrdStartDate,
                        CONVERT(VARCHAR(10),CRD.FDCrdExpireDate,121) AS rtCrdExpireDate,
                        CRD.FTCrdStaShift AS rtCrdStaShift,
                        CRDT.FTCtyStaShift AS rtCrdStaType,
                        CRDT.FTCtyStaPay AS rtCtyStaPay
                    FROM [TFNMCard] CRD WITH (NOLOCK)
                    LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                    LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
                    LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $nLngID
                    WHERE 1=1 
        ";

        $tSQL .= " AND (CRD.FTCrdStaShift = '2') AND (CRD.FTCrdStaActive = '1') AND (CONVERT(date, CRD.FDCrdExpireDate) > CONVERT(date, GETDATE())) ";

        /*if($tStaType == "1"){ // Approved type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if($tStaType == "2"){ // Cancel type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if($tStaType == "3"){ // Pending type
            $tSQL .= " AND CRD.FTCrdStaShift = $tStaShift";
        }*/

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
            // $tSQL .= " AND (CardShiftChange.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CardShiftChangeL.FTCgpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSaMCardShiftChangeDataSourceGetPageAll($tSearchList, $nLngID, $paData);
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftChangeDataSourceGetPageAll($ptSearchList, $ptLngID, $paData)
    {
        $tStaShift = $paData['FTCrdStaShift'];
        $tSQL = "
            SELECT 
                COUNT (CRD.FTCrdCode) AS counts
            FROM [TFNMCard] CRD WITH (NOLOCK)
            LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $ptLngID
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
            // $tSQL .= " AND (CardShiftChange.FTCgpCode LIKE '%$ptSearchList%'";
            // $tSQL .= " OR CardShiftChangeL.FTCgpName LIKE '%$ptSearchList%')";
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCardShiftChangeGetPageAll($ptSearchList, $paData)
    {
        $tSQL = "
            SELECT 
                COUNT (CRDHD.FTBchCode) AS counts
            FROM [TFNTCrdVoidHD] CRDHD
            WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= " AND CRDHD.FTCvhDocType = '6'";

        $oAdvanceSearch = $paData['tAdvanceSearch'];
        if (!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)) {
            $tSQL .= " AND ((CRDHD.FDCvhDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCvhDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if (!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")) {
            $tSQL .= " AND CRDHD.FTCvhStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if (!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")) {

            if ($oAdvanceSearch->tSearchStaApprove == "1") { // Approved
                $tSQL .= " AND CRDHD.FTCvhStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "2") { // Approved
                $tSQL .= " AND CRDHD.FTCvhStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "3") { // Pending approved
                $tSQL .= " AND (CRDHD.FTCvhStaPrcDoc IS NULL OR CRDHD.FTCvhStaPrcDoc = '') AND CRDHD.FTCvhStaDoc != 3";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "4") { // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTCvhStaPrcDoc IS NULL OR CRDHD.FTCvhStaPrcDoc = '') AND CRDHD.FTCvhStaDoc = 3";
            }
        }
        if ($ptSearchList != '') {
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CRDHD.FTCvhDocNo LIKE '%$ptSearchList%')";
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
     * Parameters : $ptCardShiftChangeCode
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftChangeCheckDuplicate($ptCardShiftChangeCode)
    {
        $tSQL = "
            SELECT 
                COUNT(FTCvhDocNo) AS counts
            FROM TFNTCrdVoidHD
            WHERE FTCvhDocNo = '$ptCardShiftChangeCode'
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate Card
     * Parameters : $ptCardShiftChangeCardCode
     * Creator : 15/11/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftChangeCheckCardDuplicate($ptCardShiftChangeCardCode)
    {
        $tSQL = "
            SELECT 
                COUNT(FTCrdCode) AS counts
            FROM TFNMCard WITH (NOLOCK)
            WHERE FTCrdCode = '$ptCardShiftChangeCardCode'
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate Card
     * Parameters : $ptCardShiftChangeCardCode
     * Creator : 15/11/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftChangeCheckCardDuplicateInDT($ptCardShiftChangeCardCode)
    {
        $tSQL = "
            SELECT 
                COUNT(HD.FTCvhDocNo) AS counts
            FROM TFNTCrdVoidHD HD
        ";

        $tSQL .= " RIGHT JOIN TFNTCrdVoidDT DT ON DT.FTCvhDocNo = HD.FTCvhDocNo AND DT.FTCvdNewCode = '$ptCardShiftChangeCardCode'";
        $tSQL .= " WHERE HD.FTCvhStaDoc = 1";
        $tSQL .= " AND HD.FTCvhStaPrcDoc IS NULL";
        $tSQL .= " AND HD.FTCvhDocType = '6'";

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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftChangeAddUpdateHD($paData)
    {
        // Update HD
        $this->db->set('FDCvhDocDate', $paData['FDCvhDocDate']);
        // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);

        $this->db->set('FNCvhCardQty', $paData['FNCvhCardQty']);

        $this->db->set('FTCvhStaDoc', $paData['FTCvhStaDoc']);
        $this->db->set('FNCvhStaDocAct', $paData['FNCvhStaDocAct']);

        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

        if ($paData['FTCvhStaPrcDoc'] == "1") {
            $this->db->set('FTCvhApvCode', $paData['FTCvhApvCode']);
            $this->db->set('FTCvhStaPrcDoc', $paData['FTCvhStaPrcDoc']);
        }
        if (!empty($paData['FTCvhStaDoc'])) {
            $this->db->set('FTCvhStaDoc', $paData['FTCvhStaDoc']);
        }
        $this->db->where('FTCvhDocNo', $paData['FTCvhDocNo']);
        $this->db->where('FTCvhDocType', $paData['FTCvhDocType']);
        $this->db->update('TFNTCrdVoidHD');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            // Add HD
            $this->db->insert('TFNTCrdVoidHD', array(
                'FTCvhDocNo' => $paData['FTCvhDocNo'],
                'FDCvhDocDate' => $paData['FDCvhDocDate'],
                'FTCvhDocType'  => $paData['FTCvhDocType'],
                'FTBchCode' => $paData['FTBchCode'],
                'FTUsrCode' => $paData['FTUsrCode'],
                'FNCvhCardQty'  => $paData['FNCvhCardQty'],
                'FTCvhStaDoc'  => $paData['FTCvhStaDoc'],
                'FNCvhStaDocAct'  => $paData['FNCvhStaDocAct'],
                'FDLastUpdOn' => $paData['FDLastUpdOn'],
                'FTLastUpdBy' => $paData['FTLastUpdBy'],
                'FDCreateOn' => $paData['FDCreateOn'],
                'FTCreateBy'  => $paData['FTCreateBy']
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftChangeUpdateApvDocAndCancelDocHD($paData)
    {
        // Update HD
        // $this->db->set('FDCvhDocDate' , $paData['FDCvhDocDate']);
        // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
        // $this->db->set('FTCvhApvCode' , $paData['FTCvhApvCode']);
        // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
        // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
        // $this->db->set('FNCvhCardQty' , $paData['FNCvhCardQty']);

        // $this->db->set('FTCvhStaDoc' , $paData['FTCvhStaDoc']);
        // $this->db->set('FNCvhStaDocAct' , $paData['FNCvhStaDocAct']);

        if ($paData['FTCvhStaPrcDoc'] == "2" && $paData['FTCvhStaDoc'] == "1") {
            $this->db->set('FTCvhStaPrcDoc', $paData['FTCvhStaPrcDoc']);
            $this->db->set('FTCvhApvCode', $paData['FTCvhApvCode']);
            $this->db->set('FDCvhApvDate', $paData['FDCvhApvDate']);
        }

        if (!empty($paData['FTCvhStaDoc']) && empty($paData['FTCvhStaPrcDoc'])) {
            $this->db->set('FTCvhStaDoc', $paData['FTCvhStaDoc']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        }

        $this->db->where('FTCvhDocNo', $paData['FTCvhDocNo']);
        $this->db->where('FTCvhDocType', $paData['FTCvhDocType']);
        $this->db->update('TFNTCrdVoidHD');

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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftChangeAddUpdateDT($paData)
    {
        try {
            // Add DT
            $this->db->insert('TFNTCrdVoidDT', array(
                'FTBchCode' => $paData['FTBchCode'],
                'FTCvhDocNo' => $paData['FTCvhDocNo'],
                'FNCvdSeqNo'  => $paData['FNCvdSeqNo'],
                'FTCvdStaCrd' => $paData['FTCvdStaCrd'],
                'FTCvdStaPrc' => $paData['FTCvdStaPrc'],
                'FTCvdOldCode' => $paData['FTCrdCode'],
                'FCCvdOldBal' => $paData['FCCvdOldBal'],
                'FTCvdNewCode' => $paData['FTCvdNewCode'],
                'FTRsnCode' => $paData['FTRsnCode'],
                'FTCvdRmk' => $paData['FTCvdRmk'],
                'FDCreateOn' => $paData['FDCreateOn'],
                'FTCreateBy' => $paData['FTCreateBy'],
                'FDLastUpdOn' => $paData['FDLastUpdOn'],
                'FTLastUpdBy' => $paData['FTLastUpdBy']
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
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Update Card Table
     * Parameters : $paData is data for update
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftChangeUpdateCard($paData)
    {
        // Update Card
        $this->db->join('TFNMCardType', 'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode');
        if ($paData['FTCvhStaPrcDoc'] == "1" && $paData['FTCvhStaDoc'] == "1") { // Approv
            $this->db->set('FTCrdStaActive', $paData['FTCrdStaActive']);
        }

        $this->db->set('FTCrdStaShift', $paData['FTCrdStaShift']);
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        $this->db->where('FTCrdCode', $paData['FTCrdCode']);
        $this->db->where('TFNMCardType.FTCtyStaShift', $paData['FTCrdStaType']);
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
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftChangeDel($paData)
    {
        $this->db->where('FTCvhDocNo', $paData['tDocNo']);
        $this->db->where('FTBchCode', $paData['tBchCode']);
        $this->db->delete('TFNTCrdVoidDT');

        $this->db->where('FTCvhDocNo', $paData['tDocNo']);
        $this->db->where('FTCvhDocType', $paData['tDocType']);
        $this->db->where('FTBchCode', $paData['tBchCode']);
        $this->db->delete('TFNTCrdVoidHD');

        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }

    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftChangeDelDT($paData)
    {
        $this->db->where('FTCvhDocNo', $paData['FTCvhDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdVoidDT');

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
    public function FSaMCardShiftChangeGetDTByDocNo($paData)
    {
        $tCardShiftChangeDocNo = $paData['FTCvhDocNo'];
        $tCardShiftChangeBchCode = $paData['FTBchCode'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                CRDDT.FTCvhDocNo AS rtCardShiftChangeDocNo,
                CRDDT.FTBchCode AS rtCardShiftChangeBchCode,
                CRDDT.FTCvhDocNo AS rtCardShiftChangeDocNo,
                CRDDT.FTCvdOldCode AS rtCardShiftChangeCrdCode,
                CRDDT.FTCvdNewCode AS rtCardShiftChangeNewCrdCode,
                CRDDT.FCCvdOldBal AS rtCardShiftChangeCardBal,
                CRDDT.FTRsnCode AS rtCardShiftChangeRsnCode,
                RSNL.FTRsnName AS rtCardShiftChangeRsnName,
                CRDDT.FNCvdSeqNo AS rtCardShiftChangeSeqNo,
                CRDDT.FTCvdStaCrd AS rtCardShiftChangeStaCrd,
                CRDDT.FTCvdStaPrc AS rtCardShiftChangeStaPrc,
                CRDDT.FTCvdRmk AS rtCardShiftChangeRmk,
                CRD.FTCrdStaShift AS rtCardShiftChangeCrdStaShift,
                CRD.FTCrdStaActive AS rtCardShiftChangeCrdStaActive,
                CRDT.FTCtyStaShift AS rtCardShiftChangeCrdStaType,
                CRD.FDCrdExpireDate AS rtCardShiftChangeCrdExpireDate,
                CRDL.FTCrdName AS rtCardShiftChangeCrdName
            FROM [TFNTCrdVoidDT] CRDDT
            LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CRDDT.FTCvdOldCode
            LEFT JOIN TFNMCardType CRDT WITH(NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
            LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRDL.FTCrdCode = CRDDT.FTCvdOldCode AND CRDL.FNLngID = $nLngID 
            LEFT JOIN TCNMRsn_L RSNL ON RSNL.FTRsnCode = CRDDT.FTRsnCode AND RSNL.FNLngID = $nLngID     
            WHERE 1=1 
            AND CRDDT.FTBchCode = '$tCardShiftChangeBchCode'
            AND CRDDT.FTCvhDocNo = '$tCardShiftChangeDocNo'
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
     * Functionality : Search Reason By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 19/11/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftChangeGetReasonByID($paData)
    {
        $tReasonCode = $paData['FTRsnCode'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                RSNL.FTRsnCode AS rtRsnCode,
                RSNL.FTRsnName AS rtRsnName
            FROM [TCNMRsn_L] RSNL
            WHERE 1=1
        ";

        $tSQL .= " AND RSNL.FTRsnCode = '$tReasonCode'";
        $tSQL .= " AND RSNL.FNLngID = '$nLngID'";

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
}
