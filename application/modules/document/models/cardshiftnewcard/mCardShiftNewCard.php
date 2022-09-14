<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCardShiftNewCard extends CI_Model {


    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftNewCardSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCardShiftNewCardDocNo = $paData['FTCihDocNo'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                        CRDHD.FTCihDocNo AS rtCardShiftNewCardDocNo,
                        CRDHD.FTBchCode AS rtCardShiftNewCardBchCode,
                        CRDHD.FTCihDocType AS rtCardShiftNewCardDocType,
                        CRDHD.FDCihDocDate AS rtCardShiftNewCardDocDate,
                        CRDHD.FTUsrCode AS rtCardShiftNewCardUsrCode,
                        CRDHD.FTCihApvCode AS rtCardShiftNewCardApvCode,
                        CRDHD.FDCihApvDate AS rtCardShiftNewCardApvDate,
                        (SELECT COUNT(*) 
                            FROM [TFNTCrdImpDT] CRDDT
                            WHERE CRDDT.FTBchCode = CRDHD.FTBchCode AND CRDDT.FTCihDocNo = CRDHD.FTCihDocNo
                        ) AS rtCardShiftNewCardQty,
                        CRDHD.FTCihStaPrcDoc AS rtCardShiftNewCardStaPrcDoc,
                        CRDHD.FTCihStaDoc AS rtCardShiftNewCardStaDoc,
                        CRDHD.FTCihStaDelMQ AS rtCardShiftNewCardStaDelMQ,
                        BCHL.FTBchCode,
                        BCHL.FTBchName
                    FROM [TFNTCrdImpHD] CRDHD
                    LEFT JOIN TCNMBranch_L BCHL ON CRDHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '$nLngID'
                    WHERE 1=1";
        $tSQL .= " AND CRDHD.FTCihDocNo = '$tCardShiftNewCardDocNo'";
        $tSQL .= " AND CRDHD.FTCihDocType = '7'";

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
     * Functionality : List New Card HD
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftNewCardList($ptAPIReq, $ptMethodReq, $paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tUserLevel = $paData['tUserLevel'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER(ORDER BY rtCardShiftNewCardDocDate DESC) AS rtRowID,*
                        FROM
                            (SELECT DISTINCT
                                CRDHD.FTBchCode             AS rtCardShiftNewCardBchCode,
                                CRDHD.FTCihDocNo            AS rtCardShiftNewCardDocNo,
                                CRDHD.FDCihDocDate          AS rtCardShiftNewCardDocDate,
                                CRDHD.FTCihStaDoc           AS rtCardShiftNewCardCshStaDoc,
                                CRDHD.FTCihApvCode          AS rtCardShiftNewCardApvCode,
                                CRDHD.FTCihStaPrcDoc        AS rtCardShiftNewCardCshStaPrcDoc,
                                (SELECT COUNT(*) 
                                    FROM [TFNTCrdImpDT] CRDDT
                                    WHERE CRDDT.FTBchCode = CRDHD.FTBchCode AND CRDDT.FTCihDocNo = CRDHD.FTCihDocNo
                                ) AS rtCardShiftNewCardCshCardQty
                            FROM [TFNTCrdImpHD] CRDHD
                            WHERE 1=1";
        
        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }
                
        $tSQL .= " AND CRDHD.FTCihDocType = '7'";    
        $tSearchList = $paData['tSearchAll'];
        $oAdvanceSearch = $paData['tAdvanceSearch'];

        
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDCihDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCihDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }

        $tSearchStaDoc = $oAdvanceSearch->tSearchStaDoc;
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {

            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND CRDHD.FTCihStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(CRDHD.FTCihApvCode,'') = '' AND CRDHD.FTCihStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND CRDHD.FTCihApvCode IS NOT NULL";
            }
        }

                // // สถานะเอกสาร
                // $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
                // if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
                //     // if ($tSearchStaDoc == 2) {
                //     //     $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc' OR HD.FTBdhStaDoc = ''";
                //     // } else {
                //     //     $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc'";
                //     // }
        
                //     if ($tSearchStaDoc == 3) {
                //         $tSQL .= " AND HD.FTBdhStaDoc = '$tSearchStaDoc'";
                //     } elseif ($tSearchStaDoc == 2) {
                //         $tSQL .= " AND ISNULL(HD.FTBdhStaApv,'') = '' AND HD.FTBdhStaDoc != '3'";
                //     } elseif ($tSearchStaDoc == 1) {
                //         $tSQL .= " AND HD.FTBdhStaApv = '$tSearchStaDoc'";
                //     }
                // }

        // // ค้นหาสถานะประมวลผล
        // $tSearchStaPrc = $oAdvanceSearch->tSearchStaPrc;
        // if (isset($tSearchStaPrc) && !empty($tSearchStaPrc)) {
        //     if ($tSearchStaPrc == 3) {
        //         $tSQL .= " AND (CRDHD.FTCihStaPrcDoc = '$tSearchStaPrc' OR ISNULL(CRDHD.FTCihStaPrcDoc,'') = '') ";
        //     } else {
        //         $tSQL .= " AND CRDHD.FTCihStaPrcDoc = '$tSearchStaPrc'";
        //     }
        // }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $oAdvanceSearch->tSearchStaAct;
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND CRDHD.FNCihStaDocAct = 1";
            } else {
                $tSQL .= " AND CRDHD.FNCihStaDocAct = 0";
            }
        }

        if ($tSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CRDHD.FTCihDocNo LIKE '%$tSearchList%')";
        }
        
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCardShiftNewCardGetPageAll($tSearchList, $nLngID , $paData);
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
     * Functionality : List Card
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftNewCardDataSourceList($paData){
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
                        CRD.FTCidCrdCode AS rtCrdCode,
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
                LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCidCrdCode = CRDL.FTCidCrdCode AND CRDL.FNLngID = $nLngID
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
        
        /*if(FCNnHSizeOf($paData['aCardNumber']) > 0){
            $tCardNumber = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCidCrdCode IN ($tCardNumber))";
        }
        
        if(FCNnHSizeOf($paData['aCardTypeRange']) == 2){
            $tCardTypeRange = $paData['aCardTypeRange'];
            $tSQL .= " AND ((CRDT.FTCtyCode BETWEEN '$tCardTypeRange[0]' AND '$tCardTypeRange[1]') OR (CRDT.FTCtyCode BETWEEN '$tCardTypeRange[1]' AND '$tCardTypeRange[0]'))";
        }
        
        if(FCNnHSizeOf($paData['aCardNumberRange']) == 2){
            $tCardNumberRange = $paData['aCardNumberRange'];
            $tSQL .= " AND ((CRD.FTCidCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]') OR (CRD.FTCidCrdCode BETWEEN '$tCardNumberRange[1]' AND '$tCardNumberRange[0]'))";
        }*/
        
        if(FCNnHSizeOf($paData['aNotInCardNumber']) > 0){
            $tNotInCardNumber = implode(',', $paData['aNotInCardNumber']);
            $tSQL .= " AND (CRD.FTCidCrdCode NOT IN ($tNotInCardNumber))";
        }
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            // $tSQL .= " AND (CardShiftNewCard.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CardShiftNewCardL.FTCgpName LIKE '%$tSearchList%')";
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
                COUNT (CRD.FTCidCrdCode) AS counts
            FROM [TFNMCard] CRD WITH (NOLOCK)
            LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCidCrdCode = CRDL.FTCidCrdCode AND CRDL.FNLngID = $$ptLngID
            LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
            LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $ptLngID
            WHERE 1=1 
            AND CRD.FTCrdStaActive = '1'
            AND CRDT.FTCtyStaShift = '1'
            AND CRD.FTCrdStaShift = '$tStaShift'
        ";
        
        /*if(FCNnHSizeOf($paData['aCardNumber']) > 0){
            $tCardNumbers = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCidCrdCode IN ($tCardNumbers))";
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
            $tSQL .= " AND (CRD.FTCidCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]')";
        }*/
        
        if($ptSearchList != ''){
            // $tSQL .= " AND (CardShiftNewCard.FTCgpCode LIKE '%$ptSearchList%'";
            // $tSQL .= " OR CardShiftNewCardL.FTCgpName LIKE '%$ptSearchList%')";
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
     * Functionality : All Page Of New Card HD
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCardShiftNewCardGetPageAll($ptSearchList, $ptLngID , $paData){
        $tSQL = "SELECT COUNT (CRDHD.FTCihDocNo) AS counts
                FROM [TFNTCrdImpHD] CRDHD
                WHERE 1=1";
        
        // BchCode is empty = HQ(use all)
        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CRDHD.FTBchCode IN ($tBchCode) ";
        }

        $tSQL .= " AND CRDHD.FTCihDocType = '7'";

        $oAdvanceSearch = $paData['tAdvanceSearch'];       
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDCihDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCihDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if(!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")){
            $tSQL .= " AND CRDHD.FTCihStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if(!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")){
            
            if($oAdvanceSearch->tSearchStaApprove == "1"){ // Approved
                $tSQL .= " AND CRDHD.FTCihStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "2"){ // Approved
                $tSQL .= " AND CRDHD.FTCihStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "3"){ // Pending approved
                $tSQL .= " AND (CRDHD.FTCihStaPrcDoc IS NULL OR CRDHD.FTCihStaPrcDoc = '') AND CRDHD.FTCihStaDoc != 3";
            }
            if($oAdvanceSearch->tSearchStaApprove == "4"){ // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTCihStaPrcDoc IS NULL OR CRDHD.FTCihStaPrcDoc = '') AND CRDHD.FTCihStaDoc = 3";
            }
        }

        if ($ptSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CRDHD.FTCihDocNo LIKE '%$ptSearchList%')";
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
     * Parameters : $ptCardShiftNewCardCode
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftNewCardCheckDuplicate($ptCardShiftNewCardCode){
        $tSQL = "SELECT COUNT(FTCihDocNo) AS counts
                    FROM TFNTCrdImpHD
                    WHERE FTCihDocNo = '$ptCardShiftNewCardCode'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Update New Card HD
     * Parameters : $paData is data for update
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftNewCardAddUpdateHD($paData){
        try{
            // Update HD
            $this->db->set('FDCihDocDate' , $paData['FDCihDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            $this->db->set('FTCihApvCode' , $paData['FTCihApvCode']);
            
            $this->db->set('FTCihStaDoc' , $paData['FTCihStaDoc']);
            $this->db->set('FNCihStaDocAct' , $paData['FNCihStaDocAct']);
            
            // $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            // $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            
            if($paData['FTCihStaPrcDoc'] == "1"){
                $this->db->set('FTCihStaPrcDoc', $paData['FTCihStaPrcDoc']);
            }
            if(!empty($paData['FTCihStaDoc'])){
                $this->db->set('FTCihStaDoc', $paData['FTCihStaDoc']);
            }
            $this->db->where('FTCihDocNo' , $paData['FTCihDocNo']);
            $this->db->where('FTCihDocType' , $paData['FTCihDocType']);
            $this->db->update('TFNTCrdImpHD');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add HD
                $this->db->insert('TFNTCrdImpHD', array(
                    'FTCihDocNo' => $paData['FTCihDocNo'],
                    'FDCihDocDate' => $paData['FDCihDocDate'],
                    'FTCihDocType' => $paData['FTCihDocType'],
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTUsrCode' => $paData['FTUsrCode'],
                    'FNCihStaDocAct' => $paData['FNCihStaDocAct'],
                    'FTCihStaDoc' => $paData['FTCihStaDoc'],
                    'FNCihStaDocAct' => $paData['FNCihStaDocAct'],
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
     * Functionality : Update New Card HD
     * Parameters : $paData is data for update
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftNewCardUpdateApvDocAndCancelDocHD($paData){
        try{
            // Update HD
            // $this->db->set('FDCihDocDate' , $paData['FDCihDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTCihApvCode' , $paData['FTCihApvCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FNCshCardQty' , $paData['FNCshCardQty']);
            
            // $this->db->set('FTCihStaDoc' , $paData['FTCihStaDoc']);
            // $this->db->set('FNCihStaDocAct' , $paData['FNCihStaDocAct']);
            
            if($paData['FTCihStaPrcDoc'] == "2" && $paData['FTCihStaDoc'] == "1"){
                $this->db->set('FTCihStaPrcDoc', $paData['FTCihStaPrcDoc']);
                $this->db->set('FTCihApvCode', $paData['FTCihApvCode']);
                $this->db->set('FDCihApvDate', $paData['FDCihApvDate']);
            }
            
            if(!empty($paData['FTCihStaDoc']) && empty($paData['FTCihStaPrcDoc'])){
                $this->db->set('FTCihStaDoc', $paData['FTCihStaDoc']);
                // $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                // $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            }
            
            $this->db->where('FTCihDocNo' , $paData['FTCihDocNo']);
            $this->db->where('FTCihDocType' , $paData['FTCihDocType']);
            $this->db->update('TFNTCrdImpHD');
            
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
     * Functionality : Update New Card HD
     * Parameters : $paData is data for update
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftNewCardAddUpdateDT($paData){
        try{
            // Add DT
            $this->db->insert('TFNTCrdImpDT', array(
                'FTBchCode'         => $paData['FTBchCode'],
                'FTCihDocNo'        => $paData['FTCihDocNo'],
                'FNCidSeqNo'        => $paData['FNCidSeqNo'],
                'FTCtyCode'         => $paData['FTCtyCode'],
                'FTCidCrdName'      => $paData['FTCidCrdName'],
                'FTCidCrdDepart'    => $paData['FTCidCrdDepart'],
                'FCCvdOldBal'       => $paData['FCCvdOldBal'],
                'FTCidStaCrd'       => $paData['FTCidStaCrd'],
                'FTCidStaPrc'       => $paData['FTCidStaPrc'],
                'FTCidCrdCode'      => $paData['FTCidCrdCode'],
                'FTCidRmk'          => $paData['FTCidRmk'],
                'FDCreateOn'        => $paData['FDCreateOn'],
                'FTCreateBy'        => $paData['FTCreateBy']
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
    public function FSaMCardShiftNewCardAddUpdateDTBySeq($paData){
        try{
            // Update Card
            $this->db->set('FTCidStaPrc' , $paData['FTCidStaPrc']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FNCidSeqNo' , $paData['FNCidSeqNo']);
            $this->db->update('TFNTCrdImpDT');
            
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
    public function FSaMCardShiftNewCardUpdateCard($paData){
        try{
            // Update Card
            $this->db->join('TFNMCardType', 'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode');
            $this->db->set('FTCrdStaShift' , $paData['FTCrdStaShift']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTCidCrdCode' , $paData['FTCidCrdCode']);
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
    public function FSnMCardShiftNewCardDel($paData){
        $this->db->where('FTCihDocNo', $paData['FTCihDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdImpDT');
        
        $this->db->where('FTCihDocNo', $paData['FTCihDocNo']);
        $this->db->where('FTCihDocType', $paData['FTCihDocType']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdImpHD');
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
    public function FSnMCardShiftNewCardDelDT($paData){
        $this->db->where('FTCihDocNo', $paData['FTCihDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdImpDT');
        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }
    
    /**
     * Functionality : Get New Card DT
     * Parameters : $paData Filter by DocNo and BchCode
     * Creator : 12/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftNewCardGetDTByDocNo($paData){
        $tCardShiftNewCardDocNo = $paData['FTCihDocNo'];
        $tCardShiftNewCardBchCode = $paData['FTBchCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    CRDDT.FTCihDocNo AS rtCardShiftNewCardDocNo,
                    CRDDT.FTBchCode AS rtCardShiftNewCardBchCode,
                    CRDDT.FTCihDocNo AS rtCardShiftNewCardDocNo,
                    CRDDT.FTCidCrdCode AS rtCardShiftNewCardCrdCode,
                    CRDDT.FCCvdOldBal AS rtCardShiftNewCardCardBal,
                    CRDDT.FNCidSeqNo AS rtCardShiftNewCardSeqNo,
                    CRDDT.FTCidStaCrd AS rtCardShiftNewCardStaCrd,
                    CRDDT.FTCidRmk AS rtCardShiftNewCardRmk,
                    CRDDT.FTCtyCode AS rtCardShiftNewCardCtyCode,
                    CTYL.FTCtyName AS rtCardShiftNewCardCtyName,
                    CRDDT.FTCidCrdName AS rtCardShiftNewCardCrdName,
                    CRDDT.FTCidCrdRef AS rtCardShiftNewCardCrdRef,
                    CRDDT.FTCidCrdDepart AS rtCardShiftNewCardCrdDepartCode,
                    DPTL.FTDptName AS rtCardShiftNewCardCrdDepartName,
                    CRDDT.FTCidStaPrc AS rtCardShiftNewCardStaPrc,
                    CRDDT.FTCidCrdHolderID AS rtCardShiftNewCardCrdHolderID
                FROM [TFNTCrdImpDT] CRDDT
                LEFT JOIN [TCNMUsrDepart_L] DPTL ON DPTL.FTDptCode = CRDDT.FTCidCrdDepart AND DPTL.FNLngID = $nLngID
                LEFT JOIN [TFNMCardType_L] CTYL ON CTYL.FTCtyCode = CRDDT.FTCtyCode AND CTYL.FNLngID = $nLngID
                WHERE 1=1 
                AND CRDDT.FTBchCode = '$tCardShiftNewCardBchCode'
                AND CRDDT.FTCihDocNo = '$tCardShiftNewCardDocNo'";
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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
     * Functionality: Check Card Code In DB
     * Parameters: Function Parameter
     * Creator: 06/12/2018 Wasin()
     * Last Modified: -
     * Return: data
     * ReturnType: array
    */
    public function FSaMCheckDataCardInDB($ptCrdCode){
        try{
            $tSQL = "SELECT COUNT(CRD.FTCrdCode) AS counts
                     FROM TFNMCard CRD WITH (NOLOCK)
                     WHERE CRD.FTCrdCode    = '$ptCrdCode' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->row_array();
            }else{
                return FALSE;
            }
        }catch(Exception $Error){
            echo "Error FN.FSaMCheckDataCardInDB =>".$Error;
        }
    }

    /**
     * Functionality: Check Card Type Code In DB
     * Parameters: Function Parameter
     * Creator: 06/12/2018 Wasin()
     * Last Modified: -
     * Return: data
     * ReturnType: array
    */
    public function FSaMCheckDataCardTypeInDB($ptCtyCode){
        try{
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMCard_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $tSQL = "SELECT 
                        CTY.FTCtyCode   AS rtCtyCode,
                        CTYL.FTCtyName  AS rtCtyName
                     FROM TFNMCardType CTY
                     LEFT JOIN TFNMCardType_L CTYL ON CTY.FTCtyCode = CTYL.FTCtyCode AND CTYL.FNLngID = $nLangEdit
                     WHERE CTY.FTCtyCode    = '$ptCtyCode' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->row_array();
            }else{
                return FALSE;
            }
        }catch(Exception $Error){
            echo "Error FN.FSaMCheckDataCardTypeInDB =>".$Error;
        }
    }

    /**
     * Functionality: Check Deapart Name In DB
     * Parameters: Function Parameter
     * Creator: 06/12/2018 Wasin()
     * Last Modified: -
     * Return: data
     * ReturnType: array
    */
    public function FSaMCheckDataDepartInDB($ptDptName){
        try{
            $tSQL = "SELECT 
                        DPT.FTDptCode       AS rtDptCode,
                        DPT_L.FTDptName     AS rtDptName
            
                     FROM TCNMUsrDepart DPT
                     LEFT JOIN TCNMUsrDepart_L DPT_L ON DPT.FTDptCode = DPT_L.FTDptCode
                     WHERE DPT_L.FTDptName = '$ptDptName'";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->row_array();
            }else{
                return FALSE;
            }
        }catch(Exception $Error){
            echo "Error FN.FSaMCheckDataDepartInDB =>".$Error;
        }
    }


    // Create By Witsarut 23-11-2020
    // function Delete Siggle
    public function FSnMCardShifNewCardDelDocument($paDataDel){

        $this->db->trans_begin();

        $this->db->where_in('FTCihDocNo',$paDataDel['FTCihDocNo']);
        $this->db->where('FTBchCode', $paDataDel['FTBchCode']);
        $this->db->delete('TFNTCrdImpDT');

        $this->db->where_in('FTCihDocNo',$paDataDel['FTCihDocNo']);
        $this->db->where('FTBchCode', $paDataDel['FTBchCode']);
        $this->db->delete('TFNTCrdImpHD');

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
            $this->db->where_in('FTCihDocNo',$tDocNo);
            $this->db->delete('TFNTCrdImpDT');

            $this->db->where_in('FTCihDocNo',$tDocNo);
            $this->db->delete('TFNTCrdImpHD');
            
        }catch(Exception $Error){
            return $Error;
        }
    }


    /**
     * Functionality: FindAgencyByBranch
     * Parameters: Function Parameter
     * Creator: 07/01/64  Nale
     * Last Modified: -
     * Return: data
     * ReturnType: array
    */
    public function FSaMCardShiftFindAgencyByBranch($ptBchCode){
        try{
    
              $tAgnCode =  $this->db->where('FTBchCode',$ptBchCode)->select('FTAgnCode')->get('TCNMBranch')->row_array()['FTAgnCode'];
              return $tAgnCode;

        }catch(Exception $Error){
            return $Error;
        }
    }

}


