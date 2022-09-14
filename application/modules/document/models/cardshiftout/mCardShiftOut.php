<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCardShiftOut extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftOutSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCardShiftOutDocNo = $paData['FTXshDocNo'];
        $nLngID = $paData['FNLngID'];
        $tSQL = "
            SELECT
                CRDHD.FTXshDocNo AS rtCardShiftOutDocNo,
                CRDHD.FTBchCode AS rtCardShiftOutBchCode,
                CRDHD.FNXshDocType AS rtCardShiftOutDocType,
                CRDHD.FDXshDocDate AS rtCardShiftOutDocDate,
                CRDHD.FTUsrCode AS rtCardShiftOutUsrCode,
                CRDHD.FTXshApvCode AS rtCardShiftOutApvCode,
                CRDHD.FNXshCardQty AS rtCardShiftOutCardQty,
                CRDHD.FTXshStaApv AS rtCardShiftOutStaPrcDoc,
                CRDHD.FTXshStaDoc AS rtCardShiftOutStaDoc,
                CRDHD.FTXshStaDelMQ AS rtCardShiftOutStaDelMQ,
                BCHL.FTBchCode,
                BCHL.FTBchName
            FROM [TFNTCrdShiftHD] CRDHD
            LEFT JOIN TCNMBranch_L BCHL ON CRDHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '$nLngID'
            WHERE 1=1
        ";

        $tSQL .= " AND CRDHD.FTXshDocNo = '$tCardShiftOutDocNo'";
        $tSQL .= " AND CRDHD.FNXshDocType = 1";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems' => $oDetail[0],
                'rtCode' => '1',
                'rtDesc' => 'success',
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
     * Functionality : List Card Shift HD
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftOutList($ptAPIReq, $ptMethodReq, $paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tUserLevel = $paData['tUserLevel'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT ROW_NUMBER() OVER(ORDER BY rtFDCreateOn DESC) AS rtRowID,*
                FROM
                    (SELECT DISTINCT
                        CRDHD.FTBchCode AS rtCardShiftOutBchCode,
                        CRDHD.FTXshDocNo AS rtCardShiftOutDocNo,
                        CRDHD.FDXshDocDate AS rtCardShiftOutDocDate,
                        CRDHD.FNXshCardQty AS rtCardShiftOutCshCardQty,
                        CRDHD.FTXshStaDoc AS rtCardShiftOutCshStaDoc,
                        CRDHD.FTXshStaApv AS rtCardShiftOutCshStaPrcDoc,
                        CRDHD.FDCreateOn AS rtFDCreateOn
                        FROM [TFNTCrdShiftHD] CRDHD
                        WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= " AND CRDHD.FNXshDocType = 1";
        $tSearchList = $paData['tSearchAll'];
        $oAdvanceSearch = $paData['tAdvanceSearch'];

        // วันที่เอกสาร
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }

        // สถานะเอกสาร
        if(!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")){
            $tSQL .= " AND CRDHD.FTXshStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }

        // สถานะอนุมัติ
        if(!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")){

            if($oAdvanceSearch->tSearchStaApprove == "1"){ // Approved
                $tSQL .= " AND CRDHD.FTXshStaApv = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "2"){ // Approved
                $tSQL .= " AND CRDHD.FTXshStaApv = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "3"){ // Pending approved
                $tSQL .= " AND (CRDHD.FTXshStaApv IS NULL OR CRDHD.FTXshStaApv = '') AND CRDHD.FTXshStaDoc != 3";
            }
            if($oAdvanceSearch->tSearchStaApprove == "4"){ // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTXshStaApv IS NULL OR CRDHD.FTXshStaApv = '') AND CRDHD.FTXshStaDoc = 3";
            }

        }

        // Search All
        if ($tSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CRDHD.FTXshDocNo LIKE '%$tSearchList%')";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCardShiftOutGetPageAll($tSearchList, $paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
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
     * Functionality : List Card
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftOutDataSourceList($paData){
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

        if($tStaType == "1"){ // Approved type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if($tStaType == "2"){ // Cancel type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if($tStaType == "3"){ // Pending type
            $tSQL .= " AND CRD.FTCrdStaShift = $tStaShift";
        }

        if(FCNnHSizeOf($paData['aCardNumber']) > 0){
            $tCardNumber = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode IN ($tCardNumber))";
        }

        if(FCNnHSizeOf($paData['aCardTypeRange']) == 2){
            $tCardTypeRange = $paData['aCardTypeRange'];
            $tSQL .= " AND ((CRDT.FTCtyCode BETWEEN '$tCardTypeRange[0]' AND '$tCardTypeRange[1]') OR (CRDT.FTCtyCode BETWEEN '$tCardTypeRange[1]' AND '$tCardTypeRange[0]'))";
        }

        if(FCNnHSizeOf($paData['aCardNumberRange']) == 2){
            $tCardNumberRange = $paData['aCardNumberRange'];
            $tSQL .= " AND ((CRD.FTCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]') OR (CRD.FTCrdCode BETWEEN '$tCardNumberRange[1]' AND '$tCardNumberRange[0]'))";
        }

        if(FCNnHSizeOf($paData['aNotInCardNumber']) > 0){
            $tNotInCardNumber = implode(',', $paData['aNotInCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode NOT IN ($tNotInCardNumber))";
        }
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            // $tSQL .= " AND (CardShiftOut.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CardShiftOutL.FTCgpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSaMCardShoftOutDataSourceGetPageAll($tSearchList, $nLngID, $paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
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

    /**
     * Functionality : All Page Of Card
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShoftOutDataSourceGetPageAll($ptSearchList, $ptLngID, $paData){
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

        if(FCNnHSizeOf($paData['aCardNumber']) > 0){
            $tCardNumbers = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode IN ($tCardNumbers))";
        }

        if(FCNnHSizeOf($paData['aCardTypeRange']) == 2){
            $tCardTypeRange = $paData['aCardTypeRange'];
            $tSQL .= " AND (CRDT.FTCtyCode BETWEEN '$tCardTypeRange[0]' AND '$tCardTypeRange[1]')";
            if(FCNnHSizeOf($paData['aNotInCardNumber']) > 0){
                $tNotInCardNumber = implode(',', $paData['aNotInCardNumber']);
                $tSQL .= " AND (CRDT.FTCtyCode NOT IN ($tNotInCardNumber))";
            }
        }

        if(FCNnHSizeOf($paData['aCardNumberRange']) == 2){
            $tCardNumberRange = $paData['aCardNumberRange'];
            $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]')";
        }

        if($ptSearchList != ''){
            // $tSQL .= " AND (CardShiftOut.FTCgpCode LIKE '%$ptSearchList%'";
            // $tSQL .= " OR CardShiftOutL.FTCgpName LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
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
    public function FSnMCardShiftOutGetPageAll($ptSearchList, $paData){
        $tSQL = "SELECT COUNT (CRDHD.FTBchCode) AS counts
                FROM [TFNTCrdShiftHD] CRDHD
                WHERE 1=1";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= " AND CRDHD.FNXshDocType = 1";

        $oAdvanceSearch = $paData['tAdvanceSearch'];
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if(!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")){
            $tSQL .= " AND CRDHD.FTXshStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if(!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")){

            if($oAdvanceSearch->tSearchStaApprove == "1"){ // Approved
                $tSQL .= " AND CRDHD.FTXshStaApv = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "2"){ // Approved
                $tSQL .= " AND CRDHD.FTXshStaApv = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "3"){ // Pending approved
                $tSQL .= " AND (CRDHD.FTXshStaApv IS NULL OR CRDHD.FTXshStaApv = '') AND CRDHD.FTXshStaDoc != 3";
            }
            if($oAdvanceSearch->tSearchStaApprove == "4"){ // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTXshStaApv IS NULL OR CRDHD.FTXshStaApv = '') AND CRDHD.FTXshStaDoc = 3";
            }

        }
        if($ptSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CRDHD.FTXshDocNo LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptCardShiftOutCode
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftOutCheckDuplicate($ptCardShiftOutCode){
        $tSQL = "
            SELECT
                COUNT(FTXshDocNo) AS counts
            FROM TFNTCrdShiftHD
            WHERE FTXshDocNo = '$ptCardShiftOutCode'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
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
    public function FSaMCardShiftOutAddUpdateHD($paData){
        try{
            // Update HD
            $this->db->set('FDXshDocDate' , $paData['FDXshDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            $this->db->set('FTXshApvCode' , $paData['FTXshApvCode']);
            $this->db->set('FNXshCardQty' , $paData['FNXshCardQty']);

            $this->db->set('FTXshStaDoc' , $paData['FTXshStaDoc']);
            $this->db->set('FNXshStaDocAct' , $paData['FNXshStaDocAct']);

            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

            if($paData['FTXshStaApv'] == "1"){
                $this->db->set('FTXshStaApv', $paData['FTXshStaApv']);
            }
            if(!empty($paData['FTXshStaDoc'])){
                $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
            }
            $this->db->where('FTXshDocNo' , $paData['FTXshDocNo']);
            $this->db->where('FNXshDocType' , $paData['FNXshDocType']);
            $this->db->update('TFNTCrdShiftHD');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add HD
                $this->db->insert('TFNTCrdShiftHD', array(
                    'FTXshDocNo' => $paData['FTXshDocNo'],
                    'FDXshDocDate' => $paData['FDXshDocDate'],
                    'FNXshDocType' => $paData['FNXshDocType'],
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTUsrCode' => $paData['FTUsrCode'],
                    'FNXshCardQty' => $paData['FNXshCardQty'],
                    'FTXshStaDoc' => $paData['FTXshStaDoc'],
                    'FNXshStaDocAct' => $paData['FNXshStaDocAct'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FTCreateBy' => $paData['FTCreateBy']
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

    /**
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftOutUpdateApvDocAndCancelDocHD($paData){
        try{
            // Update HD
            // $this->db->set('FDXshDocDate' , $paData['FDXshDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTXshApvCode' , $paData['FTXshApvCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FNXshCardQty' , $paData['FNXshCardQty']);

            // $this->db->set('FTXshStaDoc' , $paData['FTXshStaDoc']);
            // $this->db->set('FNXshStaDocAct' , $paData['FNXshStaDocAct']);

            if($paData['FTXshStaApv'] == "2" && $paData['FTXshStaDoc'] == "1"){
                $this->db->set('FTXshStaApv', $paData['FTXshStaApv']);
                $this->db->set('FTXshApvCode', $paData['FTXshApvCode']);
            }

            if(!empty($paData['FTXshStaDoc']) && empty($paData['FTXshStaApv'])){
                $this->db->set('FTXshStaDoc', $paData['FTXshStaDoc']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            }

            $this->db->where('FTXshDocNo' , $paData['FTXshDocNo']);
            $this->db->where('FNXshDocType' , $paData['FNXshDocType']);
            $this->db->update('TFNTCrdShiftHD');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
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
    public function FSaMCardShiftOutAddUpdateDT($paData){
        try{
            // Add DT
            $this->db->insert('TFNTCrdShiftDT', array(
                'FTBchCode' => $paData['FTBchCode'],
                'FTXshDocNo' => $paData['FTXshDocNo'],
                'FNXsdSeqNo' => $paData['FNXsdSeqNo'],

                'FCXsdCardBal' => $paData['FCXsdCardBal'],
                // 'FTXsdStaCrd' => $paData['FTXsdStaCrd'],
                'FTXsdStaPrc' => $paData['FTXsdStaPrc'],

                'FTCrdCode' => $paData['FTCrdCode'],
                'FTXsdRmk' => $paData['FTXsdRmk'],
                'FDCreateOn' => $paData['FDCreateOn'],
                'FTCreateBy' => $paData['FTCreateBy'],
                'FDLastUpdOn' => $paData['FDLastUpdOn'],
                'FTLastUpdBy' => $paData['FTLastUpdBy']
            ));

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update DT Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit DT',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
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
    public function FSaMCardShiftOutAddUpdateDTBySeq($paData){
        try{
            // Update Card
            $this->db->set('FTXsdStaPrc', $paData['FTXsdStaPrc']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->where('FNXsdSeqNo', $paData['FNXsdSeqNo']);
            $this->db->update('TFNTCrdShiftDT');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Card',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update DT',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
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
    public function FSaMCardShiftOutUpdateCard($paData){
        try{
            // Update Card
            $this->db->join('TFNMCardType', 'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode');
            $this->db->set('FTCrdStaShift', $paData['FTCrdStaShift']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->where('FTCrdCode', $paData['FTCrdCode']);
            $this->db->where('TFNMCardType.FTCtyStaShift', $paData['FTCrdStaType']);
            $this->db->update('TFNMCard');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Card',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update Card.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftOutDel(array $paParams = []){
        $this->db->where('FTXshDocNo', $paParams['tDocNo']);
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->delete('TFNTCrdShiftDT');

        $this->db->where('FTXshDocNo', $paParams['tDocNo']);
        $this->db->where('FNXshDocType', $paParams['tDocType']);
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->delete('TFNTCrdShiftHD');

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
    public function FSnMCardShiftOutDelDT($paData){
        $this->db->where('FTXshDocNo', $paData['FTXshDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdShiftDT');

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
    public function FSaMCardShiftOutGetDTByDocNo($paData){
        $tCardShiftOutDocNo = $paData['FTXshDocNo'];
        $tCardShiftOutBchCode = $paData['FTBchCode'];
        $nLngID = $paData['FNLngID'];
        $tSQL = "
            SELECT
                CRDDT.FTXshDocNo AS rtCardShiftOutDocNo,
                CRDDT.FTBchCode AS rtCardShiftOutBchCode,
                CRDDT.FTXshDocNo AS rtCardShiftOutDocNo,
                CRDDT.FTCrdCode AS rtCardShiftOutCrdCode,
                CRDDT.FCXsdCardBal AS rtCardShiftOutCardBal,
                CRDDT.FNXsdSeqNo AS rtCardShiftOutSeqNo,
                /*CRDDT.FTXsdStaCrd AS rtCardShiftOutStaCrd,*/
                CRDDT.FTXsdRmk AS rtCardShiftOutRmk,
                CRD.FTCrdStaShift AS rtCardShiftOutCrdStaShift,
                CRD.FTCrdStaActive AS rtCardShiftOutCrdStaActive,
                CRD.FDCrdExpireDate AS rtCardShiftOutCrdExpireDate,
                CRDL.FTCrdName AS rtCardShiftOutCrdName
            FROM [TFNTCrdShiftDT] CRDDT WITH(NOLOCK)
            LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CRDDT.FTCrdCode
            LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRDL.FTCrdCode = CRDDT.FTCrdCode AND CRDL.FNLngID = $nLngID
            WHERE 1=1
            AND CRDDT.FTBchCode = '$tCardShiftOutBchCode'
            AND CRDDT.FTXshDocNo = '$tCardShiftOutDocNo'
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems' => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
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

    //Function Scanner สามารถไปเอามาจาก JS Browse ได้
    public function FSaMCardShiftOutListScanner($paData){
      $tAgnCode     = $paData['tAgnCode'];
      $tCrdCode     = $paData['tCrdCode'];
      $tLangID      = $paData['tLangID'];
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
        $tSQL         = "SELECT
                            TFNMCard.FTCrdCode,
                            TFNMCard_L.FTCrdName
                        FROM
                            TFNMCard
                        LEFT JOIN TFNMCard_L ON TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '$tLangID'
                        LEFT JOIN TFNMCardType ON TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode
                        WHERE TFNMCard.FTCrdCode ='$tCrdCode'
                        AND TFNMCardType.FTCtyStaShift = '1'
                        AND TFNMCard.FTCrdStaShift = '1'
                        AND TFNMCard.FTCrdStaActive = '1'
                        AND CONVERT (DATE,TFNMCard.FDCrdExpireDate) > CONVERT (DATE, GETDATE())
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
