<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCardShiftReturn extends CI_Model
{

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftReturnSearchByID($ptAPIReq, $ptMethodReq, $paData)
    {
        $tCardShiftReturnDocNo = $paData['FTXshDocNo'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                CRDHD.FTXshDocNo AS rtCardShiftReturnDocNo,
                CRDHD.FTBchCode AS rtCardShiftReturnBchCode,
                CRDHD.FNXshDocType AS rtCardShiftReturnDocType,
                CRDHD.FDXshDocDate AS rtCardShiftReturnDocDate,
                CRDHD.FTUsrCode AS rtCardShiftReturnUsrCode,
                CRDHD.FTXshApvCode AS rtCardShiftReturnApvCode,
                CRDHD.FNXshCardQty AS rtCardShiftReturnCardQty,
                CRDHD.FTXshStaApv AS rtCardShiftReturnStaPrcDoc,
                CRDHD.FTXshStaDoc AS rtCardShiftReturnStaDoc,
                CRDHD.FTXshStaDelMQ AS rtCardShiftReturnStaDelMQ,
                BCHL.FTBchCode,
                BCHL.FTBchName
            FROM [TFNTCrdShiftHD] CRDHD
            LEFT JOIN TCNMBranch_L BCHL ON CRDHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '$nLngID'
            WHERE 1=1
        ";

        $tSQL .= " AND CRDHD.FTXshDocNo = '$tCardShiftReturnDocNo'";
        $tSQL .= " AND CRDHD.FNXshDocType = 2";

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

    /**
     * Functionality : List Card Shift HD
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnList($ptAPIReq, $ptMethodReq, $paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tUserLevel = $paData['tUserLevel'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT 
                c.* 
            FROM(
                SELECT 
                    ROW_NUMBER() OVER(ORDER BY rtFDCreateOn DESC) AS rtRowID,*
                FROM
                    (SELECT DISTINCT
                        CRDHD.FTBchCode AS rtCardShiftReturnBchCode,
                        CRDHD.FTXshDocNo AS rtCardShiftReturnDocNo,
                        CRDHD.FDXshDocDate AS rtCardShiftReturnDocDate,
                        CRDHD.FNXshCardQty AS rtCardShiftReturnCshCardQty,
                        CRDHD.FTXshStaDoc AS rtCardShiftReturnCshStaDoc,
                        CRDHD.FTXshStaApv AS rtCardShiftReturnCshStaApv,
                        CRDHD.FTXshStaPrcDoc AS rtCardShiftReturnCshStaPrcDoc,
                        CRDHD.FDCreateOn AS rtFDCreateOn
                        
                    FROM [TFNTCrdShiftHD] CRDHD
                    WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= " AND CRDHD.FNXshDocType = 2";

        $tSearchList = $paData['tSearchAll'];
        $oAdvanceSearch = $paData['tAdvanceSearch'];

        // วันที่เอกสาร
        if (!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)) {
            $tSQL .= " AND ((CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }

        // สถานะเอกสาร
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
        $tSearchStaPrcDoc = $oAdvanceSearch->tSearchStaPrcDoc;
        if (isset($tSearchStaPrcDoc) && !empty($tSearchStaPrcDoc)) {
            if ($tSearchStaPrcDoc == 3) {
                $tSQL .= " AND (CRDHD.FTXshStaPrcDoc = '$tSearchStaPrcDoc' OR ISNULL(CRDHD.FTXshStaPrcDoc,'') = '') ";
            } else {
                $tSQL .= " AND CRDHD.FTXshStaPrcDoc = '$tSearchStaPrcDoc'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $oAdvanceSearch->tSearchStaDocAct;
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND CRDHD.FNXshStaDocAct = 1";
            } else {
                $tSQL .= " AND CRDHD.FNXshStaDocAct = 0";
            }
        }


        // Search All
        if ($tSearchList != '') {
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CRDHD.FTXshDocNo LIKE '%$tSearchList%')";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCardShiftReturnGetPageAll($tSearchList, $paData);
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
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnDataSourceList($paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tStaShift = $paData['FTCrdStaShift'];
        $tStaType = $paData['tStaType'];

        $tSQL = "
            SELECT 
                c.* 
            FROM(
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY rtCrdCode ASC) AS rtRowID,*
                FROM(
                    SELECT DISTINCT
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
                        CONVERT(VARCHAR(10),CRD.FDCrdLastTopup,121) AS rtCrdLastTopup
                FROM [TFNMCard] CRD WITH (NOLOCK)
                LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
                LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $nLngID
                WHERE 1=1 
                AND CRD.FTCrdStaActive = '1'
                AND CRDT.FTCtyStaShift = '1'
        ";

        if ($tStaType == "1") { // Approved return
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if ($tStaType == "3") { // Out
            $tSQL .= " AND CRD.FTCrdStaShift = 2";
        }
        if ($tStaType == "4") { // Pending return
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if ($tStaType == "2") { // Cancel type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
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
            // $tSQL .= " AND (CardShiftReturn.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CardShiftReturnL.FTCgpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSaMCardShiftReturnDataSourceGetPageAll($tSearchList, $nLngID, $paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
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
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnDataSourceGetPageAll($ptSearchList, $ptLngID, $paData)
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
            // $tSQL .= " AND (CardShiftReturn.FTCgpCode LIKE '%$ptSearchList%'";
            // $tSQL .= " OR CardShiftReturnL.FTCgpName LIKE '%$ptSearchList%')";
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
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCardShiftReturnGetPageAll($ptSearchList, $paData)
    {
        $tSQL = "SELECT COUNT (CRDHD.FTBchCode) AS counts
                FROM [TFNTCrdShiftHD] CRDHD
                WHERE 1=1";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= "AND CRDHD.FNXshDocType = 2";

        $oAdvanceSearch = $paData['tAdvanceSearch'];

        if (!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)) {
            $tSQL .= " AND ((CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if (!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")) {
            $tSQL .= " AND CRDHD.FTXshStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if (!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")) {

            if ($oAdvanceSearch->tSearchStaApprove == "1") { // Approved
                $tSQL .= " AND CRDHD.FTXshStaApv = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "2") { // Approved
                $tSQL .= " AND CRDHD.FTXshStaApv = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "3") { // Pending approved
                $tSQL .= " AND (CRDHD.FTXshStaApv IS NULL OR CRDHD.FTXshStaApv = '') AND CRDHD.FTXshStaDoc != 3";
            }
            if ($oAdvanceSearch->tSearchStaApprove == "4") { // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTXshStaApv IS NULL OR CRDHD.FTXshStaApv = '') AND CRDHD.FTXshStaDoc = 3";
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
     * Parameters : $ptCardShiftReturnCode
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftReturnCheckDuplicate($ptCardShiftReturnCode)
    {
        $tSQL = "SELECT COUNT(FTXshDocNo) AS counts
                    FROM TFNTCrdShiftHD
                    WHERE FTXshDocNo = '$ptCardShiftReturnCode' ";
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
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnAddUpdateHD($paData)
    {
        try {
            // Update HD
            $this->db->set('FDXshDocDate', $paData['FDXshDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            $this->db->set('FTXshApvCode', $paData['FTXshApvCode']);
            $this->db->set('FNXshCardQty', $paData['FNXshCardQty']);
            $this->db->set('FTBchCode', $paData['FTBchCode']);

            $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
            $this->db->set('FNXshStaDocAct', $paData['FNXshStaDocAct']);

            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            if ($paData['FTXshStaApv'] == "1") {
                $this->db->set('FTXshStaApv', $paData['FTXshStaApv']);
            }
            if (!empty($paData['FTXshStaDoc'])) {
                $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
            }

            $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
            $this->db->where('FNXshDocType', $paData['FNXshDocType']);
            $this->db->update('TFNTCrdShiftHD');

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add HD
                $this->db->insert('TFNTCrdShiftHD', array(
                    'FTXshDocNo' => $paData['FTXshDocNo'],
                    'FDXshDocDate' => $paData['FDXshDocDate'],
                    'FNXshDocType'  => $paData['FNXshDocType'],
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTUsrCode' => $paData['FTUsrCode'],
                    'FNXshCardQty'  => $paData['FNXshCardQty'],
                    'FTXshStaDoc'  => $paData['FTXshStaDoc'],
                    'FNXshStaDocAct'  => $paData['FNXshStaDocAct'],
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
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnUpdateApvDocAndCancelDocHD($paData)
    {
        try {
            // Update HD
            // $this->db->set('FDXshDocDate' , $paData['FDXshDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTXshApvCode' , $paData['FTXshApvCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FNXshCardQty' , $paData['FNXshCardQty']);

            // $this->db->set('FTXshStaDoc' , $paData['FTXshStaDoc']);
            // $this->db->set('FNXshStaDocAct' , $paData['FNXshStaDocAct']);

            if ($paData['FTXshStaApv'] == "2" && $paData['FTXshStaDoc'] == "1") {
                $this->db->set('FTXshStaApv', $paData['FTXshStaApv']);
                $this->db->set('FTXshApvCode', $paData['FTXshApvCode']);
            }

            if (!empty($paData['FTXshStaDoc']) && empty($paData['FTXshStaApv'])) {
                $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            }

            $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
            $this->db->where('FNXshDocType', $paData['FNXshDocType']);
            $this->db->update('TFNTCrdShiftHD');

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
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnAddUpdateDT($paData)
    {
        try {
            // Add DT
            $this->db->insert('TFNTCrdShiftDT', array(
                'FTBchCode' => $paData['FTBchCode'],
                'FTXshDocNo' => $paData['FTXshDocNo'],
                'FNXsdSeqNo'  => $paData['FNXsdSeqNo'],

                'FCXsdCardBal'  => $paData['FCXsdCardBal'],
                // 'FTXsdStaCrd'  => $paData['FTXsdStaCrd'],
                'FTXsdStaPrc'  => $paData['FTXsdStaPrc'],

                'FTCrdCode' => $paData['FTCrdCode'],
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
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Update Card Table
     * Parameters : $paData is data for update
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnUpdateCard($paData)
    {
        try {
            // Update Card
            $this->db->join('TFNMCardType', 'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode');
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
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftReturnDel($paData)
    {
        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdShiftDT');

        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FNXshDocType', $paData['FNXshDocType']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdShiftHD');

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
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftReturnDelDT($paData)
    {
        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdShiftDT');

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
    public function FSaMCardShiftReturnGetDTByDocNo($paData)
    {
        $tCardShiftReturnDocNo = $paData['FTXshDocNo'];
        $tCardShiftReturnBchCode = $paData['FTBchCode'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT
                CRDDT.FTXshDocNo AS rtCardShiftReturnDocNo,
                CRDDT.FTBchCode AS rtCardShiftReturnBchCode,
                CRDDT.FTCrdCode AS rtCardShiftReturnCrdCode,
                CRDDT.FCXsdCardBal AS rtCardShiftReturnCardBal,
                CRDDT.FNXsdSeqNo AS rtCardShiftReturnSeqNo,
                /*CRDDT.FTXsdStaCrd AS rtCardShiftReturnStaCrd,*/
                CRDDT.FTXsdRmk AS rtCardShiftReturnRmk,
                CRD.FTCrdStaShift AS rtCardShiftReturnCrdStaShift,
                CRD.FTCrdStaActive AS rtCardShiftReturnCrdStaActive,
                CRD.FDCrdExpireDate AS rtCardShiftRetutnCrdExpireDate,
                CRDL.FTCrdName AS rtCardShiftReturnCrdName
            FROM [TFNTCrdShiftDT] CRDDT WITH (NOLOCK)
            LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CRDDT.FTCrdCode 
            LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRDL.FTCrdCode = CRDDT.FTCrdCode AND CRDL.FNLngID = $nLngID 
            WHERE 1=1 
            AND CRDDT.FTBchCode = '$tCardShiftReturnBchCode'
            AND CRDDT.FTXshDocNo = '$tCardShiftReturnDocNo'
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
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Get Card Shift DT
     * Parameters : $paData Filter by DocNo and BchCode
     * Creator : 12/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnGetCardOnHD($paData)
    {
        $tSQL = "SELECT
                    CRDDT.FTXshDocNo AS rtCardShiftReturnDocNo,
                    CRDDT.FTBchCode AS rtCardShiftReturnBchCode,
                    CRDDT.FTXshDocNo AS rtCardShiftReturnDocNo,
                    CRDDT.FTCrdCode AS rtCardShiftReturnCrdCode,
                    CRDDT.FCXsdCardBal AS rtCardShiftReturnCardBal,
                    CRDDT.FNXsdSeqNo AS rtCardShiftReturnSeqNo
                FROM [TFNTCrdShiftHD] CRDHD
                RIGHT JOIN [TFNTCrdShiftDT] CRDDT 
                    ON CRDDT.FTXshDocNo = CRDHD.FTXshDocNo 
                WHERE CRDHD.FNXshDocType = 2 
                AND CRDHD.FTXshStaApv IS NOT NULL
                AND CRDDT.FTXshDocNo IS NOT NULL";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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


    // Create By Witsarut 23-11-2020
    // function Delete Siggle
    public function FSnMCardShifReturnDelDocument($paDataDel){
        
        $this->db->trans_begin();

        $this->db->where_in('FTXshDocNo',$paDataDel['FTXshDocNo']);
        $this->db->where('FTBchCode', $paDataDel['FTBchCode']);
        $this->db->delete('TFNTCrdShiftDT');

        $this->db->where_in('FTXshDocNo',$paDataDel['FTXshDocNo']);
        $this->db->where('FTBchCode', $paDataDel['FTBchCode']);
        $this->db->delete('TFNTCrdShiftHD');

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aStaDelDoc     = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Cannot Delete Item.',
            );
        }else{
            $this->db->trans_commit();
            $aStaDelDoc     = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }

        return $aStaDelDoc;
    }


    // Create By Witsarut 23-11-2020
    // function Delete Multi
    public function FSaMDelMultiMaster($paParams = []){
        try{
            $tDocNo = $paParams['tDocNo'];
            
            $this->db->where_in('FTXshDocNo', $tDocNo);
            $this->db->delete('TFNTCrdShiftDT');

            $this->db->where_in('FTXshDocNo', $tDocNo);
            $this->db->delete('TFNTCrdShiftHD');

        }catch(Exception $Error){
            return $Error;
        }
    }

    //Function Scanner สามารถไปเอามาจาก JS Browse ได้
    public function FSaMCardShiftReturnListScanner($paData){
        $tAgnCode   = $paData['tAgnCode'];
        $tCrdCode   = $paData['tCrdCode'];
        $tLangID    = $paData['tLangID'];
        $tSessionID = $this->session->userdata("tSesSessionID");

        //เช็คก่อนว่าบัตรใบนี้เคยเพิ่มลง Temp หรือยัง ถ้ายังจะค้นหาได้ แต่ถ้าเคยมีเเล้ว จะจบทันที่
        $tSQL       = " SELECT FTCrdCode FROM TFNTCrdShiftTmp WHERE FTCrdCode = '$tCrdCode' AND FTSessionID = '$tSessionID' ";
        $oQuery     = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = array(
                'raItems'     => [],
                'rtCode'      => '801',
                'rtDesc'      => 'data duplicate',
            );
        }else{
            $tSQL   = "SELECT 
                            TFNMCard.FTCrdCode,
                            TFNMCard_L.FTCrdName
                        FROM
                            TFNMCard
                        LEFT JOIN TFNMCard_L ON TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '$tLangID'
                        LEFT JOIN TFNMCardType ON TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode
                        WHERE TFNMCard.FTCrdCode = '$tCrdCode'
                        AND (((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '2')))
                        AND TFNMCard.FTAgnCode = '$tAgnCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result();
                $aResult = array(
                    'raItems'     => $oDetail,
                    'rtCode'      => '1',
                    'nCountNumber'=> $paData['nCountNumber'],
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



