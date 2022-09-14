<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mTransferreceipt extends CI_Model
{

    public function FSaMTWIUpdRvtRefTableInsToNULL($paDataWhere){

        $this->db->set('FTXtdRvtRef', $paDataWhere['tSesUsername']);
        $this->db->where('FTPdtCode', $paDataWhere['FTPdtCode']);
        $this->db->where('FTPunCode', $paDataWhere['FTPunCode']);
        $this->db->where('FTXtdBarCode', $paDataWhere['FTBarCode']);

        if($paDataWhere['FTBrowDocNo'] != ""){
            $this->db->where('FTXthDocNo', $paDataWhere['FTBrowDocNo']);
        }

        $this->db->update('TCNTPdtIntDT');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'OK',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Not Cancel',
            );
        }

    }

    public function FSaMTWIUpdRvtRefTableIns($paDataWhere){

        $this->db->set('FTXtdRvtRef', $paDataWhere['tSesUsername']);
        $this->db->where('FTPdtCode', $paDataWhere['FTPdtCode']);
        $this->db->where('FTPunCode', $paDataWhere['FTPunCode']);
        $this->db->where('FTXtdBarCode', $paDataWhere['FTBarCode']);
        $this->db->where('FTXthDocNo', $paDataWhere['FTBrowDocNo']);

        $this->db->update('TCNTPdtIntDT');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'OK',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Not Cancel',
            );
        }

    }
    

    //Functionality : Get Pdt In Modal 
    //Parameters : function parameters
    //Creator :  24/05/2019 Krit
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSnMTXIModalGetProduct($paData){

        try{

            $tSesSessionID = $paData['tSesSessionID'];
            $tSesUsername = $paData['tSesUsername'];
            $FTXthDocKey = $paData['FTXthDocKey'];

            $tBCH       = $paData['tBCH'];
            $tRefInt    = $paData['tRefInt'];

            $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nLngID     = $paData['FNLngID'];


            $tSQLViaCode = "";
            $tViaCode   = $paData['tViaCode'];
            if($tViaCode != ''){
                $tSQLViaCode = "AND WOR.FTViaCode = '$tViaCode'";
            }

            $tSQL   = "SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FTXthDocNo DESC,FNXtdSeqNo ASC) AS FNRowID,* FROM
                                (
                                SELECT DISTINCT ISNULL(CONVERT(INT,(INS.FCXtdQty - INS.FCXtdQtyRcv) - ISNULL(TMP.FCXtdQtyTmp,0)), 0) AS FNXtdQtyBlcXX,
                                    CONVERT(INT,(INS.FCXtdQty - INS.FCXtdQtyRcv)) AS FNXtdQtyBlc,
                                    TMP.FCXtdQtyTmp,
                                    INS.*, TWO.FTXthMerCode,TWO.FTXthShopTo,TWO.FTSplCode,TWODT.FCXtdAmt
                                FROM (
                                SELECT * FROM TCNTPdtIntDT WITH (NOLOCK)
                                WHERE FTXthDocNo IN(
                                    --หาข้อเลขเอกสาร
                                    SELECT A.* FROM (
                                    SELECT TWO.FTXthDocNo
                                    FROM TCNTPdtTwoHD TWO
                                    LEFT JOIN TCNTPdtTwoHDRef WOR ON WOR.FTXthDocNo = TWO.FTXthDocNo 
                                    WHERE TWO.FNXthStaRef = 1
                                    AND   TWO.FTXthStaApv = 1
                                    AND TWO.FTXthDocNo <> '$tRefInt'
                                    AND TWO.FTBchCode = '$tBCH'
                                    --AND TWO.FTXthShopTo = '00232'
                                    --กรณีมีการโอนข้อมูลไปยังร้านค้าหรือ vending
                                    --AND WOR.FTViaCode = '00002'
                                    $tSQLViaCode
                                ) A 
                                )
                                )INS 
                                LEFT JOIN TCNTPdtTwoHD TWO ON INS.FTXthDocNo = TWO.FTXthDocNo
                                LEFT JOIN (SELECT SUM(FCXtdQty) AS FCXtdQtyTmp,FTPdtCode,FTXtdBarCode
                                    FROM TCNTDocDTTmp WITH (NOLOCK)
                                    WHERE FTSessionID = '$tSesSessionID'
                                    AND FTXthDocKey = '$FTXthDocKey'
                                    GROUP BY FTPdtCode,FTXtdBarCode
                                    )TMP ON TMP.FTPdtCode = INS.FTPdtCode AND TMP.FTXtdBarCode = INS.FTXtdBarCode
                                LEFT JOIN TCNTPdtTwoDT TWODT WITH (NOLOCK) ON TWODT.FTPdtCode = INS.FTPdtCode AND TWODT.FTXthDocNo = TWO.FTXthDocNo
                                WHERE ISNULL(CONVERT(INT,(INS.FCXtdQty - INS.FCXtdQtyRcv) - ISNULL(TMP.FCXtdQtyTmp,0)), 0) > 0
                                AND (ISNULL(INS.FTXtdRvtRef,'') = '' OR INS.FTXtdRvtRef = '$tSesUsername')
                                ";
                                // --AND TWO.FTBchCode    BETWEEN '00000' AND '00000'
                                // --AND TWO.FTXthMerCode BETWEEN '001' AND '001'
                                // --AND TWO.FTXthShopTo  BETWEEN '00232' AND '00232'
                                // --AND INS.FTPdtCode    BETWEEN '00034' AND '00034'
                                // --AND INS.FTXtdPdtName LIKE '%โทรศัพท์ของวัฒน์%'
                                // --AND INS.FTXtdBarCode BETWEEN 'WAT00001' AND 'WAT00004'
                                // --AND INS.FTPunCode    BETWEEN '00003' AND '00003'

            $tBCH = $paData['tBCH'];
            if (!empty($tBCH)) {
                $tSQL .= " AND TWO.FTBchCode =   '$tBCH'";
            }

            $tMerchant = $paData['tMerchant'];
            if (!empty($tMerchant)) {
                $tSQL .= " AND TWO.FTXthMerCode = '$tMerchant'";
            }

            //ร้านค้า
            $tSHPFrom   = $paData['aSHP'][0]; 
            $tSHPTo     = $paData['aSHP'][1]; 
            if(!empty($tSHPFrom) || !empty($tSHPTo)){
                $tSQL .= " AND (TWO.FTXthShopTo BETWEEN '$tSHPFrom' AND '$tSHPTo')";
            }

            $FTPdtCode = $paData['tCodePDT'];
            if (!empty($FTPdtCode)) {
                $tSQL .= " AND INS.FTPdtCode LIKE '%$FTPdtCode%'";
            }

            $FTXtdPdtName = $paData['tNamePDT'];
            if (!empty($FTXtdPdtName)) {
                $tSQL .= " AND INS.FTXtdPdtName LIKE '%$FTXtdPdtName%'";
            }

            $FTXtdBarCode = $paData['tBarcode'];
            if (!empty($FTXtdBarCode)) {
                $tSQL .= " AND INS.FTXtdBarCode LIKE '%$FTXtdBarCode%'";
            }

            $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSnMTXIModalPdtGetPageAll($paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'sql'           => $tSQL
                );
            }else{
                //No Data
                $aResult    = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found',
                    'sql'           => $tSQL
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    public function FSnMTXIModalPdtGetPageAll($paData){

        $tSesSessionID  = $paData['tSesSessionID'];
        $tSesUsername   = $paData['tSesUsername'];
        $FTXthDocKey    = $paData['FTXthDocKey'];
        $tBCH           = $paData['tBCH'];
        $tRefInt        = $paData['tRefInt'];
        $nLngID         = $paData['FNLngID'];

        
        $tSQL   = "SELECT COUNT(INS.FTPdtCode) AS counts
                        FROM (
                        SELECT * FROM TCNTPdtIntDT 
                        WHERE FTXthDocNo IN(
                            --หาข้อเลขเอกสาร
                            SELECT A.* FROM (
                            SELECT TWO.FTXthDocNo
                            FROM TCNTPdtTwoHD TWO
                            LEFT JOIN TCNTPdtTwoHDRef WOR ON WOR.FTXthDocNo = TWO.FTXthDocNo 
                            WHERE TWO.FNXthStaRef = 1
                            AND   TWO.FTXthStaApv = 1
                            AND TWO.FTXthDocNo <> '$tRefInt'
                            AND TWO.FTBchCode = '$tBCH'
                        --AND TWO.FTXthShopTo = '00232'
                        --กรณีมีการโอนข้อมูลไปยังร้านค้าหรือ vending
                        --AND WOR.FTViaCode = '00002'
                        ) A 
                        )
                        )INS 
                        LEFT JOIN TCNTPdtTwoHD TWO ON INS.FTXthDocNo = TWO.FTXthDocNo
                        LEFT JOIN (SELECT SUM(FCXtdQty) AS FCXtdQtyTmp,FTPdtCode,FTXtdBarCode
                            FROM TCNTDocDTTmp
                            WHERE FTSessionID = '$tSesSessionID'
                            AND FTXthDocKey = '$FTXthDocKey'
                            GROUP BY FTPdtCode,FTXtdBarCode
                            )TMP ON TMP.FTPdtCode = INS.FTPdtCode AND TMP.FTXtdBarCode = INS.FTXtdBarCode
                        WHERE ISNULL(CONVERT(INT,(INS.FCXtdQty - INS.FCXtdQtyRcv) - ISNULL(TMP.FCXtdQtyTmp,0)), 0) > 0
                        AND (ISNULL(INS.FTXtdRvtRef,'') = '' OR INS.FTXtdRvtRef = '$tSesUsername')
                    ";

            $tBCH = $paData['tBCH'];
            if (!empty($tBCH)) {
                $tSQL .= " AND TWO.FTBchCode =   '$tBCH'";
            }

            $tMerchant = $paData['tMerchant'];
            if (!empty($tMerchant)) {
                $tSQL .= " AND TWO.FTXthMerCode = '$tMerchant'";
            }

            //ร้านค้า
            $tSHPFrom   = $paData['aSHP'][0]; 
            $tSHPTo     = $paData['aSHP'][1]; 
            if(!empty($tSHPFrom) || !empty($tSHPTo)){
                $tSQL .= " AND (TWO.FTXthShopTo BETWEEN '$tSHPFrom' AND '$tSHPTo')";
            }

            $FTPdtCode = $paData['tCodePDT'];
            if (!empty($FTPdtCode)) {
                $tSQL .= " AND INS.FTPdtCode LIKE '%$FTPdtCode%'";
            }

            $FTXtdPdtName = $paData['tNamePDT'];
            if (!empty($FTXtdPdtName)) {
                $tSQL .= " AND INS.FTXtdPdtName LIKE '%$FTXtdPdtName%'";
            }

            $FTXtdBarCode = $paData['tBarcode'];
            if (!empty($FTXtdBarCode)) {
                $tSQL .= " AND INS.FTXtdBarCode LIKE '%$FTXtdBarCode%'";
            }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }

    }

    //Functionality : Data List Subdistrict
    //Parameters : function parameters
    //Creator :  12/03/2019 Krit
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTWIList($paData)
    {

        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $tTblSelectData     = $paData['tTblSelectData'];
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXthDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT

                                TWI.FTBchCode,
                                BCHL.FTBchName,
                                TWI.FTXthDocNo,
                                CONVERT(CHAR(10),TWI.FDXthDocDate,103)   AS FDXthDocDate,
                                TWI.FTXthStaDoc,
                                TWI.FTXthStaApv,
                                TWI.FTXthStaPrcStk,
                                TWI.FTCreateBy,
                                USRL.FTUsrName AS FTCreateByName,
                                TWI.FTXthApvCode,
                                USRLAPV.FTUsrName AS FTXthApvName

                            FROM " . $tTblSelectData . "HD TWI WITH (NOLOCK)
                            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON TWI.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRL WITH (NOLOCK) ON TWI.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON TWI.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID 
                            
                            WHERE 1=1 ";

        $oAdvanceSearch = $paData['oAdvanceSearch'];

        @$tSearchList = $oAdvanceSearch['tSearchAll'];
        if (@$tSearchList != '') {
            $tSQL .= " AND ((TWI.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TWI.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $oAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $oAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((TWI.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TWI.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $oAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $oAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((TWI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TWI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $oAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 2) {
                $tSQL .= " AND TWI.FTXthStaDoc = '$tSearchStaDoc' OR TWI.FTXthStaDoc = ''";
            } else {
                $tSQL .= " AND TWI.FTXthStaDoc = '$tSearchStaDoc'";
            }
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $oAdvanceSearch['tSearchStaApprove'];
        if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
            if ($tSearchStaApprove == 2) {
                $tSQL .= " AND TWI.FTXthStaApv = '$tSearchStaApprove' OR TWI.FTXthStaApv = '' ";
            } else {
                $tSQL .= " AND TWI.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $oAdvanceSearch['tSearchStaPrcStk'];
        if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {

            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND TWI.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TWI.FTXthStaPrcStk = '' ";
            } else {
                $tSQL .= " AND TWI.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        /* Session UserLogin : Branch */
        $tSesUsrBchCode = $paData['tSesUsrBchCode'];
        if (@$tSesUsrBchCode != '') {
            $tSQL .= " AND (TWI.FTBchCode = '$tSesUsrBchCode')";
        }

        /* Session UserLogin : Shop */
        $tSesUsrShpCode = $paData['tSesUsrShpCode'];
        if (@$tSesUsrShpCode != '') {
            $tSQL .= " AND (TWI.FTXthShopFrm = '$tSesUsrShpCode')";
        }


        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        // print_r($tSQL);

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMTWIGetPageAll($paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
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


    //Functionality : All Page Of Subdistrict
    //Parameters : function parameters
    //Creator :  12/03/2019 Krit
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSnMTWIGetPageAll($paData)
    {

        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT COUNT (TWI.FTXthDocNo) AS counts
                FROM [TCNTPdtTwiHD] TWI WITH (NOLOCK) 
                LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON TWI.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                WHERE 1=1 ";

        $oAdvanceSearch = $paData['oAdvanceSearch'];

        @$tSearchList   = $oAdvanceSearch['tSearchAll'];
        if (@$tSearchList != '') {
            $tSQL .= " AND ((TWI.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (TWI.FDXthDocDate LIKE '%$tSearchList%'))";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $oAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $oAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((TWI.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TWI.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $oAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $oAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((TWI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TWI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $oAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            $tSQL .= " AND TWI.FTXthStaDoc = '$tSearchStaDoc'";
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $oAdvanceSearch['tSearchStaApprove'];
        if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
            if ($tSearchStaApprove == 2) {
                $tSQL .= " AND TWI.FTXthStaApv = '$tSearchStaApprove' OR TWI.FTXthStaApv = '' ";
            } else {
                $tSQL .= " AND TWI.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $oAdvanceSearch['tSearchStaPrcStk'];
        if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {

            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND TWI.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TWI.FTXthStaPrcStk = '' ";
            } else {
                $tSQL .= " AND TWI.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        /* Session UserLogin : Branch */
        $tSesUsrBchCode = $paData['tSesUsrBchCode'];
        if (@$tSesUsrBchCode != '') {
            $tSQL .= " AND (TWI.FTBchCode = '$tSesUsrBchCode')";
        }

        /* Session UserLogin : Shop */
        $tSesUsrShpCode = $paData['tSesUsrShpCode'];
        if (@$tSesUsrShpCode != '') {
            $tSQL .= " AND (TWI.FTXthShopFrm = '$tSesUsrShpCode')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }


    //Functionality : Function Get Data Ref Int FROM TWO
    //Parameters : function parameters
    //Creator : 14/05/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTWIGetDataRefInt($paDataWhere)
    {

        $tTblSelectData = $paDataWhere['tTblSelectData'];
        $tTXODocNo      = $paDataWhere['tTXODocNo'];
        $nLngID      = $paDataWhere['FNLngID'];


        $tSelectFirld = "";

        $tSQL = "SELECT
                    -- TWO
                    TXO.FTXthDocNo,

                    TXO.FTBchCode,
                    BCHL.FTBchName,

                    TXO.FTXthMerCode,
                    MERL.FTMerName,


                    TXO.FTXthShopFrm,
                    SHPLFRM.FTShpName AS FTShpNameFrm,

                    TXO.FTXthShopTo,
                    SHPLTO.FTShpName AS FTShpNameTo,


                    POSLFRM.FTPosCode AS FTPosCodeFrm,
                    POSLFRM.FTPosComName AS FTPosNameFrm,

                    POSLTO.FTPosCode AS FTPosCodeTo,
                    POSLTO.FTPosComName AS FTPosNameTo,


                    TXO.FTXthWhFrm,
                    WAHLF.FTWahName AS FTWahNameFrm,
                    
                    TXO.FTXthWhTo,
                    WAHLT.FTWahName AS FTWahNameTo

                FROM $tTblSelectData TXO WITH (NOLOCK)

                    LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK) ON TXO.FTBchCode = BCHL.FTBchCode AND  BCHL.FNLngID = $nLngID

                    LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK) ON TXO.FTXthMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID

                    LEFT JOIN TCNMShop_L       SHPLFRM WITH (NOLOCK) ON TXO.FTXthShopFrm = SHPLFRM.FTShpCode AND SHPLFRM.FNLngID = $nLngID
                    LEFT JOIN TCNMShop_L       SHPLTO  WITH (NOLOCK) ON TXO.FTXthShopTo = SHPLTO.FTShpCode AND SHPLTO.FNLngID = $nLngID

                    LEFT JOIN TCNMWaHouse      WAHF    WITH (NOLOCK) ON TXO.FTXthWhFrm = WAHF.FTWahCode AND WAHF.FTWahStaType = '6'
                    LEFT JOIN TCNMPosLastNo    POSLFRM   WITH (NOLOCK) ON WAHF.FTWahRefCode = POSLFRM.FTPosCode

                    LEFT JOIN TCNMWaHouse      WAHTO    WITH (NOLOCK) ON TXO.FTXthWhTo = WAHTO.FTWahCode AND WAHTO.FTWahStaType = '6'
                    LEFT JOIN TCNMPosLastNo    POSLTO   WITH (NOLOCK) ON WAHTO.FTWahRefCode = POSLTO.FTPosCode

                    LEFT JOIN TCNMWaHouse_L    WAHLF   WITH (NOLOCK) ON TXO.FTXthWhFrm = WAHLF.FTWahCode AND WAHLF.FNLngID = $nLngID
                    LEFT JOIN TCNMWaHouse_L    WAHLT   WITH (NOLOCK) ON TXO.FTXthWhTo = WAHLT.FTWahCode AND WAHLT.FNLngID = $nLngID
                WHERE 1 = 1
            ";

        $tSQL .= " AND TXO.FTXthDocNo = '$tTXODocNo'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        return $aResult;
    }

    public function FSaMTWIGetTWODataIntDTInDTTmp($paDataWhere)
    {

        $tTblSelectData = $paDataWhere['tTblSelectData'];
        $tXthDocNo      = $paDataWhere['tXthDocNo'];
        $tTXODocNo      = $paDataWhere['tTXODocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        //ลบ ใน Temp
        if ($tXthDocNo != '') {
            $this->db->where_in('FTXthDocNo', $tXthDocNo);
            $this->db->where_in('FTXthDocKey', $tXthDocKey);
            $this->db->where_in('FTSessionID', $tSesSessionID);
            $this->db->delete('TCNTDocDTTmp');
        }

        $tSQL = "INSERT     TCNTDocDTTmp
                            (FTBchCode,
                            FTXthDocNo,
                            FNXtdSeqNo,
                            FTXthDocKey,
                            FTPdtCode,
                            FTXtdPdtName,
                            FTXtdStkCode,
                            FTPunCode,
                            FTPunName,
                            FCXtdFactor,
                            FTXtdBarCode,
                            FCXtdQty,
                            FCXtdQtyAll,
                            FTXtdVatType,
                            FTVatCode,
                            FCXtdVatRate,
                            
                            FCXtdSetPrice,
                            FCXtdAmt,
                            FCXtdVat,
                            FCXtdVatable,
                            FCXtdNet,
                            FCXtdCostIn,
                            FCXtdCostEx,
                            FNXtdPdtLevel,
                            FTXtdPdtParent,
                            FCXtdQtySet,
                            FTXtdPdtStaSet,
                            FTXtdRmk,
                            -- FDLastUpdOn,
                            -- FTLastUpdBy,
                            -- FDCreateOn,
                            -- FTCreateBy
                            FTSessionID
                            ) ";

        $tSQL .= "SELECT DISTINCT
                        INTDT.FTBchCode,
                        '$tXthDocNo' AS FTXthDocNo,
                        INTDT.FNXtdSeqNo,
                        '$tXthDocKey' AS FTXthDocKey,
                        INTDT.FTPdtCode,
                        INTDT.FTXtdPdtName, 
                        INTDT.FTXtdStkCode,
                        INTDT.FTPunCode,
                        INTDT.FTPunName,
                        INTDT.FCXtdFactor,
                        INTDT.FTXtdBarCode,
                        INTDT.FCXtdQty,
                        -- INTDT.FCXtdQtyRcv,
                        INTDT.FCXtdQtyAll,

                        TWODT.FTXtdVatType,
                        TWODT.FTVatCode,
                        TWODT.FCXtdVatRate,
                        TWODT.FCXtdSetPrice,
                        TWODT.FCXtdAmt,
                        TWODT.FCXtdVat,
                        TWODT.FCXtdVatable,
                        TWODT.FCXtdNet,
                        TWODT.FCXtdCostIn,
                        TWODT.FCXtdCostEx,
                        TWODT.FNXtdPdtLevel,
                        TWODT.FTXtdPdtParent,
                        TWODT.FCXtdQtySet,
                        TWODT.FTXtdPdtStaSet,
                        TWODT.FTXtdRmk,
                        '$tSesSessionID' AS FTSessionID

                    FROM TCNTPdtIntDT INTDT WITH (NOLOCK)
                    LEFT JOIN TCNTPdtTwoDT TWODT ON INTDT.FTXthDocNo = TWODT.FTXthDocNo
                    WHERE 1 = 1";

        $tSQL .= " AND (INTDT.FCXtdQty-INTDT.FCXtdQtyRcv) > 0";
        $tSQL .= " AND INTDT.FTXthDocNo = '$tTXODocNo' ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }

        return $aStatus;
    }


    public function FSaMTWIGetDataPdt($paData)
    {

        $tPdtCode       = $paData['FTPdtCode'];
        $FTPunCode      = $paData['FTPunCode'];
        $nLngID         = $paData['FNLngID'];

        $tSQL = "SELECT

                    PDT.FTPdtCode,
                    PDT.FTPdtStkCode,
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
                    PDT.FTEvnCode,
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
                    PDTSRL.FTSrnCode,
                    PDT.FCPdtCostStd,
                    CAVG.FCPdtCostEx,
                    CAVG.FCPdtCostIn
         
                    
                FROM TCNMPdt PDT
                LEFT JOIN TCNMPdt_L PDTL                ON PDT.FTPdtCode = PDTL.FTPdtCode   AND PDTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtPackSize  PKS          ON PDT.FTPdtCode = PKS.FTPdtCode    AND PKS.FTPunCode = $FTPunCode
                LEFT JOIN TCNMPdtUnit_L UNTL            ON UNTL.FTPunCode = $FTPunCode      AND UNTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtBar BAR                ON PKS.FTPdtCode = BAR.FTPdtCode    AND BAR.FTPunCode = $FTPunCode
                LEFT JOIN (SELECT FTVatCode,FCVatRate,FDVatStart   
                           FROM TCNMVatRate WHERE GETdate()> FDVatStart) VAT
                           ON PDT.FTVatCode=VAT.FTVatCode 
                LEFT JOIN TCNTPdtSerial PDTSRL          ON PDT.FTPdtCode = PDTSRL.FTPdtCode
                LEFT JOIN TCNMPdtCostAvg CAVG           ON PDT.FTPdtCode = CAVG.FTPdtCode
                WHERE 1 = 1 ";


        if ($tPdtCode != "") {
            $tSQL .= "AND PDT.FTPdtCode = '$tPdtCode'";
        }

        $tSQL .= " ORDER BY FDVatStart DESC";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItem'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
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


    function FSnMWTOUpdateInlineDTTemp($aDataUpd, $aDataWhere)
    {

        try {

            $FTXthDocKey = $aDataWhere['FTXthDocKey'];

            $this->db->where('FTXthDocKey', $FTXthDocKey);
            $this->db->where('FTSessionID', $this->session->userdata('tSesSessionID'));
            $this->db->where('FTXthDocNo', $aDataWhere['FTXthDocNo']);
            $this->db->where('FNXtdSeqNo', $aDataWhere['FNXtdSeqNo']);
            $this->db->update('TCNTDocDTTmp', $aDataUpd);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    function FSaMTWIAddUpdateDocNoInDocTemp($aDataWhere)
    {

        try {

            $this->db->set('FTXthDocNo', $aDataWhere['FTXthDocNo']);
            $this->db->set('FTBchCode', $aDataWhere['FTBchCode']);
            $this->db->where('FTXthDocNo', '');
            $this->db->where('FTSessionID', $this->session->userdata('tSesSessionID'));
            $this->db->where('FTXthDocKey', $aDataWhere['FTXthDocKey']);
            $this->db->update('TCNTDocDTTmp');

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }



    //Function : Update หลังจาก คำนวน DT เอายอดรวม มา Upd
    function FSaMTWIUpdateHDFCXthTotal($paDataUpdHD, $paDataWhere)
    {

        $tTblSelectData = $paDataWhere['tTblSelectData'];
        $ptXthDocNo     = $paDataWhere['FTXthDocNo'];
        try {
            //DT Dis
            $this->db->where('FTXthDocNo', $ptXthDocNo);
            $this->db->update($tTblSelectData . 'HD', $paDataUpdHD);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Function : Update DTTmp หลังจาก Edit In line
    function FSnMWTOUpdateDTTemp($aDataUpd, $paDataWhere)
    {

        try {

            if (is_array($aDataUpd) == 1) {

                //ลบ ใน Temp
                $this->db->where_in('FTSessionID', $this->session->userdata('tSesSessionID'));
                $this->db->where_in('FTXthDocKey', $paDataWhere['FTXthDocKey']);
                $this->db->where_in('FTXthDocNo', $paDataWhere['FTXthDocNo']);
                $this->db->delete('TCNTDocDTTmp');

                foreach ($aDataUpd as $key => $val) {
                    //เพิ่ม
                    $this->db->insert('TCNTDocDTTmp', $aDataUpd[$key]);
                    if ($this->db->affected_rows() > 0) {
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Add Success.',
                        );
                    } else {
                        $aStatus = array(
                            'rtCode' => '905',
                            'rtDesc' => 'Error Cannot Add.',
                        );
                    }
                }

                return $aStatus;
            }
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTXIGetDTTemp($paDataWhere)
    {

        $tSQL = "SELECT

                    DOCTMP.FTBchCode,
                    DOCTMP.FTXthDocNo,
                    DOCTMP.FNXtdSeqNo,
                    DOCTMP.FTXthDocKey,
                    DOCTMP.FTPdtCode,
                    DOCTMP.FTXtdPdtName,
                    DOCTMP.FTXtdStkCode,
                    DOCTMP.FTPunCode,
                    DOCTMP.FTPunName,
                    DOCTMP.FCXtdFactor,
                    DOCTMP.FTXtdBarCode,
                    DOCTMP.FTXtdVatType,
                    DOCTMP.FTVatCode,
                    DOCTMP.FCXtdVatRate,
                    DOCTMP.FCXtdQty,
                    DOCTMP.FCXtdQtyAll,
                    DOCTMP.FCXtdSetPrice,
                    DOCTMP.FCXtdAmt,
                    DOCTMP.FCXtdVat,
                    DOCTMP.FCXtdVatable,
                    DOCTMP.FCXtdNet,
                    DOCTMP.FCXtdCostIn,
                    DOCTMP.FCXtdCostEx,
                    DOCTMP.FTXtdStaPrcStk,
                    DOCTMP.FNXtdPdtLevel,
                    DOCTMP.FTXtdPdtParent,
                    DOCTMP.FCXtdQtySet,
                    DOCTMP.FTXtdPdtStaSet,
                    DOCTMP.FTXtdRmk,
                    DOCTMP.FTSessionID,

                    DOCTMP.FDLastUpdOn,
                    DOCTMP.FDCreateOn,
                    DOCTMP.FTLastUpdBy,
                    DOCTMP.FTCreateBy


                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                WHERE 1 = 1
            ";

        $tXthDocNo      = $paDataWhere['FTXthDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');


        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " ORDER BY DOCTMP.FNXtdSeqNo ASC";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        return $aResult;
    }


    //Functionality : Function Get Count From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTWIGetCountDTTemp($paDataWhere)
    {

        $tXthDocNo      = $paDataWhere['FTXthDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "SELECT 
                    COUNT(DOCTMP.FTXthDocNo) AS counts
                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                WHERE 1 = 1
                ";



        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result_array();
            $aResult = $oDetail[0]['counts'];
        } else {
            $aResult = 0;
        }

        return $aResult;
    }



    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTWISumDTTemp($paDataWhere)
    {


        $tXthDocNo      = $paDataWhere['FTXthDocNo'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "SELECT SUM(FCXtdAmt) AS FCXtdAmt
                 FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                 WHERE 1 = 1
                ";

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oResult = $oQuery->result_array();
        } else {
            $oResult = '';
        }


        return $oResult;
    }


    //Functionality : Function Get Pdt From Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTWIGetVatDTTemp($tXthDocNo)
    {

        $tSQL = "SELECT DISTINCT FCXtdVatRate, 
                                 SUM(FCXtdVat) AS FCXtdVat,
                                 SUM(FCXtdVatable) AS FCXtdVatable
                FROM TCNTDocDTTmp WITH (NOLOCK)
                WHERE 1 = 1";

        $tSesSessionID = $this->session->userdata('tSesSessionID');
        $tSQL .= " AND FTSessionID = '$tSesSessionID'";

        $tSQL .= " AND FTXthDocNo = '$tXthDocNo'";

        $tSQL .= " AND FTXthDocKey = 'TCNTPdtTwiHD'";

        $tSQL .= " GROUP BY FCXtdVatRate ORDER BY FCXtdVatRate ASC";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oResult = $oQuery->result_array();
        } else {
            $oResult = '';
        }

        return $oResult;
    }


    //Functionality : Function Add DT To Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMTWIInsertTmpToDT($paDataWhere)
    {

        $tXthDocNo      = $paDataWhere['FTXthDocNo'];
        $tTblSelectData = $paDataWhere['tTblSelectData'];
        $tXthDocKey     = $paDataWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        //ลบ ใน Temp
        if ($paDataWhere['FTXthDocNo'] != '') {
            $this->db->where_in('FTXthDocNo', $paDataWhere['FTXthDocNo']);
            $this->db->delete($tTblSelectData . 'DT');
        }

        $tSQL = "INSERT " . $tTblSelectData . 'DT' . " 
                            (FTBchCode,FTXthDocNo,FNXtdSeqNo,FTPdtCode,FTXtdPdtName,FTXtdStkCode,FTPunCode,FTPunName,
                            FCXtdFactor,FTXtdBarCode,FTXtdVatType,FTVatCode,FCXtdVatRate,FCXtdQty,FCXtdQtyAll,
                            FCXtdSetPrice,FCXtdAmt,FCXtdVat,FCXtdVatable,FCXtdNet,FCXtdCostIn,FCXtdCostEx,FTXtdStaPrcStk,
                            FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,FTXtdPdtStaSet,FTXtdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy) ";

        $tSQL .= "SELECT DOCTMP.FTBchCode,
                            DOCTMP.FTXthDocNo,
                            ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTXtdStkCode,
                            DOCTMP.FTPunCode,
                            DOCTMP.FTPunName,
                            DOCTMP.FCXtdFactor,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FTXtdVatType,
                            DOCTMP.FTVatCode,
                            DOCTMP.FCXtdVatRate,
                            DOCTMP.FCXtdQty,
                            DOCTMP.FCXtdQtyAll,
                            DOCTMP.FCXtdSetPrice,
                            DOCTMP.FCXtdAmt,
                            DOCTMP.FCXtdVat,
                            DOCTMP.FCXtdVatable,
                            DOCTMP.FCXtdNet,
                            DOCTMP.FCXtdCostIn,
                            DOCTMP.FCXtdCostEx,
                            DOCTMP.FTXtdStaPrcStk,
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
                    WHERE 1 = 1
                    ";

        $tSQL .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tXthDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tXthDocKey'";

        $tSQL .= " ORDER BY DOCTMP.FNXtdSeqNo ASC";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }
    }


    //Functionality : Function Delete Pdt in DocTemp
    //Parameters : function parameters
    //Creator : 13/15/2019 Krit
    //Last Modified : -
    public function FSxMTXIClearPdtInTmp($ptTblSelectData, $ptXthDocNo)
    {

        $this->db->where_in('FTXthDocKey', $ptTblSelectData . 'HD');
        if ($ptXthDocNo != "") {
            $this->db->where_in('FTXthDocNo', $ptXthDocNo);
        }

        $this->db->where_in('FTSessionID', $this->session->userdata('tSesSessionID'));
        $this->db->delete('TCNTDocDTTmp');
    }


    //Functionality : Function Add DT To Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMTWIInsertDTToTemp($paData, $paDataWhere)
    {

        if ($paData['rtCode'] == 1) {

            $paData = $paData['raItems'];

            //ลบ ใน Temp
            if ($paData[0]['FTXthDocNo'] != '') {

                $this->db->where_in('FTXthDocNo', $paData[0]['FTXthDocNo']);
                $this->db->where_in('FTSessionID', $this->session->userdata('tSesSessionID'));
                $this->db->delete('TCNTDocDTTmp');
            }

            foreach ($paData as $key => $val) {

                //เพิ่ม
                $this->db->insert('TCNTDocDTTmp', array(

                    'FTBchCode'         => $val['FTBchCode'],
                    'FTXthDocNo'        => $val['FTXthDocNo'],
                    'FNXtdSeqNo'        => $val['FNXtdSeqNo'],
                    'FTXthDocKey'       => $paDataWhere['FTXthDocKey'],
                    'FTPdtCode'         => $val['FTPdtCode'],
                    'FTXtdPdtName'      => $val['FTXtdPdtName'],
                    'FTXtdStkCode'      => $val['FTXtdStkCode'],
                    'FTPunCode'         => $val['FTPunCode'],
                    'FTPunName'         => $val['FTPunName'],
                    'FCXtdFactor'       => $val['FCXtdFactor'],
                    'FTXtdBarCode'      => $val['FTXtdBarCode'],
                    'FTXtdVatType'      => $val['FTXtdVatType'],
                    'FTVatCode'         => $val['FTVatCode'],
                    'FCXtdVatRate'      => $val['FCXtdVatRate'],
                    'FCXtdQty'          => $val['FCXtdQty'],
                    'FCXtdQtyAll'       => $val['FCXtdQtyAll'],
                    'FCXtdSetPrice'     => $val['FCXtdSetPrice'],
                    'FCXtdAmt'          => $val['FCXtdAmt'],
                    'FCXtdVat'          => $val['FCXtdVat'],
                    'FCXtdVatable'      => $val['FCXtdVatable'],
                    'FCXtdNet'          => $val['FCXtdNet'],
                    'FCXtdCostIn'       => $val['FCXtdCostIn'],
                    'FCXtdCostEx'       => $val['FCXtdCostEx'],
                    'FTXtdStaPrcStk'    => $val['FTXtdStaPrcStk'],
                    'FNXtdPdtLevel'     => $val['FNXtdPdtLevel'],
                    'FTXtdPdtParent'    => $val['FTXtdPdtParent'],
                    'FCXtdQtySet'       => $val['FCXtdQtySet'],
                    'FTXtdPdtStaSet'    => $val['FTXtdPdtStaSet'],
                    'FTXtdRmk'          => $val['FTXtdRmk'],
                    'FTSessionID'       => $this->session->userdata('tSesSessionID'),

                    'FDLastUpdOn'       => date('Y-m-d'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => date('Y-m-d'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')

                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success.',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add.',
                    );
                }
            }
        }
    }


    //Functionality : Function Add DT To Temp
    //Parameters : function parameters
    //Creator : 25/01/2019 Krit
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMTWIInsertPDTToTemp($paData, $paDataWhere)
    {

        $paData = $paData['raItem'];

        if ($paDataWhere['tOptionAddPdt'] == 1) {

            $tSQL = "SELECT FNXtdSeqNo,FCXtdQty 
                     FROM TCNTDocDTTmp 
                     WHERE FTBchCode = '" . $paDataWhere['FTBchCode'] . "' 
                     AND FTPdtCode = '" . $paDataWhere["FTPdtCode"] . "'
                     AND FTPunCode = '" . $paDataWhere["FTPunCode"] . "'
                     AND FTXtdBarCode = '" . $paDataWhere["FTBarCode"] . "'
                     AND FTXthDocNo = '" . $paDataWhere['FTXthDocNo'] . "'
                     AND FTXthDocKey = '" . $paDataWhere['FTXthDocKey'] . "'
                     AND FTSessionID = '" . $paDataWhere['FTSessionID'] . "' ORDER BY FNXtdSeqNo";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {

                $aResult = $oQuery->row_array();

                $this->db->set('FCXtdQty', $aResult['FCXtdQty'] + 1);
                $this->db->where('FNXtdSeqNo', $aResult['FNXtdSeqNo']);
                $this->db->where('FTPdtCode', $paDataWhere['FTPdtCode']);
                $this->db->where('FTPunCode', $paDataWhere['FTPunCode']);
                $this->db->where('FTXtdBarCode', $paDataWhere['FTBarCode']);
                $this->db->where('FTXthDocKey', $paDataWhere['FTXthDocKey']);
                $this->db->where('FTXthDocNo', $paDataWhere['FTXthDocNo']);
                $this->db->update('TCNTDocDTTmp');
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'OK',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '903',
                        'rtDesc' => 'Not Cancel',
                    );
                }
            } else {
                //เพิ่ม
                $this->db->insert('TCNTDocDTTmp', array(

                    'FTBchCode'         => $paDataWhere['FTBchCode'],
                    'FTXthDocNo'        => $paDataWhere['FTXthDocNo'],
                    'FNXtdSeqNo'        => $paDataWhere['nCounts'],
                    'FTXthDocKey'       => $paDataWhere['FTXthDocKey'],
                    'FTPdtCode'         => $paData['FTPdtCode'],
                    'FTXtdPdtName'      => $paData['FTPdtName'],
                    'FTXtdStkCode'      => $paData['FTPdtStkCode'],
                    'FTPunCode'         => $paData['FTPunCode'],
                    'FTPunName'         => $paData['FTPunName'],
                    'FCXtdFactor'       => $paData['FCPdtUnitFact'],
                    'FTXtdBarCode'      => $paDataWhere['FTBarCode'],
                    'FTXtdVatType'      => $paData['FTPdtStaVatBuy'],
                    'FTVatCode'         => $paData['FTVatCode'],
                    'FCXtdVatRate'      => $paData['FCVatRate'],
                    'FCXtdQty'          => 1,
                    'FCXtdQtyAll'       => $paData['FCPdtUnitFact'],
                    'FCXtdSetPrice'     => $paDataWhere['FCXtdSetPrice'],
                    'FTXtdRmk'          => $paData['FTPdtRmk'],
                    'FTSessionID'       => $paDataWhere['FTSessionID'],

                    'FDLastUpdOn'       => date('Y-m-d h:i:sa'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => date('Y-m-d h:i:sa'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ));

                $this->db->last_query();

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success.',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add.',
                    );
                }
            }
        } else {
            //เพิ่ม
            $this->db->insert('TCNTDocDTTmp', array(

                'FTBchCode'         => $paDataWhere['FTBchCode'],
                'FTXthDocNo'        => $paDataWhere['FTXthDocNo'],
                'FNXtdSeqNo'        => $paDataWhere['nCounts'],
                'FTXthDocKey'       => $paDataWhere['FTXthDocKey'],
                'FTPdtCode'         => $paData['FTPdtCode'],
                'FTXtdPdtName'      => $paData['FTPdtName'],
                'FTXtdStkCode'      => $paData['FTPdtStkCode'],
                'FTPunCode'         => $paData['FTPunCode'],
                'FTPunName'         => $paData['FTPunName'],
                'FCXtdFactor'       => $paData['FCPdtUnitFact'],
                'FTXtdBarCode'      => $paDataWhere['FTBarCode'],
                'FTXtdVatType'      => $paData['FTPdtStaVatBuy'],
                'FTVatCode'         => $paData['FTVatCode'],
                'FCXtdVatRate'      => $paData['FCVatRate'],
                'FCXtdQty'          => 1,
                'FCXtdQtyAll'       => $paData['FCPdtUnitFact'],
                'FCXtdSetPrice'     => $paDataWhere['FCXtdSetPrice'],
                'FTXtdRmk'          => $paData['FTPdtRmk'],
                'FTSessionID'       => $paDataWhere['FTSessionID'],

                'FDLastUpdOn'       => date('Y-m-d h:i:sa'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d h:i:sa'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            ));

            $this->db->last_query();

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add.',
                );
            }
        }

        return $aStatus;
    }


    //Function : Cancel Doc
    public function FSvMTWICancel($paDataUpdate)
    {
        try {
            //DT Dis
            $this->db->set('FTXthStaDoc', 3);
            $this->db->where('FTXthDocNo', $paDataUpdate['FTXthDocNo']);
            $this->db->update('TCNTPdtTwiHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Cancel',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Function : Approve Doc
    public function FSvMTWIApprove($paDataUpdate)
    {
        try {
            //DT Dis
            $this->db->set('FTXthStaPrcStk', 2);
            $this->db->set('FTXthStaApv', 2);
            $this->db->set('FTXthApvCode', $paDataUpdate['FTXthApvCode']);
            $this->db->where('FTXthDocNo', $paDataUpdate['FTXthDocNo']);
            $this->db->update('TCNTPdtTwiHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    public function FStTWIGetShpCodeForUsrLogin($paDataShp)
    {

        $nLngID     = $paDataShp['FNLngID'];
        $tUsrLogin  = $paDataShp['tUsrLogin'];

        $tSQL = "SELECT UGP.FTBchCode,
                        BCHL.FTBchName,
                        UGP.FTShpCode,
                        SHPL.FTShpName,
                        SHP.FTWahCode,
                        SHP.FTShpType,
                        SHP.FTMerCode,
                        MERL.FTMerName,
			            WAHL.FTWahName
                FROM TCNTUsrGroup UGP WITH (NOLOCK)  
                LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK)  ON UGP.FTBchCode = BCHL.FTBchCode
                LEFT JOIN TCNMShop      SHP WITH (NOLOCK)   ON UGP.FTShpCode = SHP.FTShpCode
                LEFT JOIN TCNMShop_L    SHPL WITH (NOLOCK)  ON SHP.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = $nLngID
                LEFT JOIN TCNMMerchant_L MERL WITH (NOLOCK)  ON SHP.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK)  ON SHP.FTWahCode = WAHL.FTWahCode 
                WHERE FTUsrCode ='$tUsrLogin' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oRes  = $oQuery->result();
            $tDataShp = $oRes[0];
        } else {
            $tDataShp = '';
        }

        return $tDataShp;
    }

    public function FSaMTWIGetDefOptionTWI($paData)
    {

        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT CON.FTSysStaUsrValue,WAHL.FTWahName
                FROM TSysConfig CON WITH (NOLOCK)
                LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON CON.FTSysStaUsrValue = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                WHERE FTSysCode='tCN_WahTWI' AND FTSysSeq='1'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oRes  = $oQuery->result();
            $tData = $oRes[0];
        } else {
            $tData = '';
        }

        return $tData;
    }

    //Get Vat rate ของ DocNo
    public function FSaMTWIGetAddress($FTAddRefCode, $ptXthShipAdd, $nLngID)
    {

        $tSQL = "SELECT FTAddV1No,
                        FTAddV1Soi,
                        FTAddV1Village,
                        FTAddV1Road,
                        FTAddV1SubDist,
                        FTAddV1DstCode,
                        FTAddV1PvnCode,
                        FTAddV1PostCode,
                        PVNL.FTPvnName,
                        DSTL.FTDstName,
                        SUBDSTL.FTSudName
        
                FROM TCNMAddress_L ADDL WITH (NOLOCK)

                LEFT JOIN TCNMProvince_L   PVNL WITH (NOLOCK) ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                LEFT JOIN TCNMDistrict_L   DSTL WITH (NOLOCK) ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                LEFT JOIN TCNMSubDistrict_L SUBDSTL WITH (NOLOCK) ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
                WHERE 1 = 1
                ";

        if ($FTAddRefCode != "") {
            $tSQL .= " AND FTAddRefCode = '$FTAddRefCode'";
        }

        if ($ptXthShipAdd != "") {
            $tSQL .= " AND FNAddSeqNo = '$ptXthShipAdd'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oData    = $oQuery->result();
        } else {
            $oData = 0;
        }

        return $oData;
    }


    //Functionality : Search TWI By ID
    //Parameters : function parameters
    //Creator : 07/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMTXIGetHD($paData)
    {

        $tTblSelectData = $paData['tTblSelectData'];
        $tXthDocNo      = $paData['FTXthDocNo'];
        $nLngID         = $paData['FNLngID'];

        if ($tTblSelectData == 'TCNTPdtTwi') {

            $tSQLField = "TXI.FTXthMerCode,
                          MERL.FTMerName,

                          TXI.FTXthShopFrm, 
                          SHPLFRM.FTShpName AS FTShpNameFrm,
                          SHPFRM.FTShpType AS FTShpTypeFrm,

                          TXI.FTXthShopTo, 
                          SHPLTO.FTShpName AS FTShpNameTo,
                          SHPTO.FTShpType AS FTShpTypeTo,

                          POSLFRM.FTPosCode AS FTPosCodeFrm,
                          POSLFRM.FTPosComName AS FTPosNameFrm,

                          POSLTO.FTPosCode AS FTPosCodeTo,
                          POSLTO.FTPosComName AS FTPosNameTo,

                          TXI.FTXthWhFrm,
                          WAHLF.FTWahName AS FTWahNameFrm,
                          TXI.FTXthWhTo,
                          WAHLT.FTWahName AS FTWahNameTo,
                          ";
            $tSQLjoin   =   "LEFT JOIN TCNMShop         SHPFRM  WITH (NOLOCK) ON TXI.FTXthShopFrm = SHPFRM.FTShpCode
                             LEFT JOIN TCNMShop_L       SHPLFRM WITH (NOLOCK) ON TXI.FTXthShopFrm = SHPLFRM.FTShpCode AND SHPLFRM.FNLngID = $nLngID

                             LEFT JOIN TCNMShop         SHPTO   WITH (NOLOCK) ON TXI.FTXthShopTo = SHPTO.FTShpCode
                             LEFT JOIN TCNMShop_L       SHPLTO  WITH (NOLOCK) ON TXI.FTXthShopTo = SHPLTO.FTShpCode AND SHPLTO.FNLngID = $nLngID
                             
                             LEFT JOIN TCNMMerchant_L   MERL    WITH (NOLOCK) ON TXI.FTXthMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID

                             LEFT JOIN TCNMWaHouse      WAHF    WITH (NOLOCK) ON TXI.FTXthWhFrm = WAHF.FTWahCode AND WAHF.FTWahStaType = '6'
                             LEFT JOIN TCNMPosLastNo    POSLFRM   WITH (NOLOCK) ON WAHF.FTWahRefCode = POSLFRM.FTPosCode

                             LEFT JOIN TCNMWaHouse      WAHTO    WITH (NOLOCK) ON TXI.FTXthWhTo = WAHTO.FTWahCode AND WAHTO.FTWahStaType = '6'
                             LEFT JOIN TCNMPosLastNo    POSLTO   WITH (NOLOCK) ON WAHTO.FTWahRefCode = POSLTO.FTPosCode

                             LEFT JOIN TCNMWaHouse_L    WAHLF   WITH (NOLOCK) ON TXI.FTXthWhFrm = WAHLF.FTWahCode AND WAHLF.FNLngID = $nLngID
                             LEFT JOIN TCNMWaHouse_L    WAHLT   WITH (NOLOCK) ON TXI.FTXthWhTo = WAHLT.FTWahCode AND WAHLT.FNLngID = $nLngID";
        } else {
            $tSQLField  = "";
            $tSQLjoin   = "";
        }

        $tSQL = "SELECT
                    --TCNTPdtTwiHD
                    TXI.FTBchCode,
                    TXI.FTXthDocNo,
                    TXI.FDXthDocDate,
                    TXI.FTXthVATInOrEx,
                    TXI.FTDptCode,
                    TXI.FTUsrCode,
                    TXI.FTSpnCode,
                    TXI.FTXthApvCode,
                    TXI.FTXthRefExt,
                    TXI.FDXthRefExtDate,
                    TXI.FTXthRefInt,
                    TXI.FDXthRefIntDate,
                    TXI.FNXthDocPrint,
                    TXI.FCXthTotal,
                    TXI.FCXthVat,
                    TXI.FCXthVatable,
                    TXI.FTXthRmk,
                    TXI.FTXthStaDoc,
                    TXI.FTXthStaApv,
                    TXI.FTXthStaPrcStk,
                    TXI.FTXthStaDelMQ,
                    TXI.FNXthStaDocAct,
                    TXI.FNXthStaRef,
                    TXI.FTRsnCode,
                    RSNL.FTRsnName,
                    TXI.FDLastUpdOn,
                    TXI.FTLastUpdBy,
                    TXI.FDCreateOn,
                    TXI.FTCreateBy,
                    " . $tSQLField . "
                    BCHL.FTBchName,

                    --TCNMUsrDepart_L
                    DPTL.FTDptName,

                  

                    --TCNMWaHouse_L
                    
                    
                    --TCNMSpl_L
                    -- SPLL.FTSplName,

                    --TCNTPdtTwiHDRef
                    TXIHDREF.FTXthCtrName,
                    TXIHDREF.FDXthTnfDate,
                    TXIHDREF.FTXthRefTnfID,
                    TXIHDREF.FTXthRefVehID,
                    TXIHDREF.FTXthQtyAndTypeUnit,
                    TXIHDREF.FNXthShipAdd,
                    TXIHDREF.FTViaCode,
                    VIAL.FTViaName,

                    -- -- TCNMUser_L
                    USRL.FTUsrName,
                    USRAPV.FTUsrName AS FTUsrNameApv

                FROM " . $tTblSelectData . "HD TXI WITH (NOLOCK)
             
                LEFT JOIN TCNMBranch_L     BCHL    WITH (NOLOCK) ON TXI.FTBchCode   = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L       USRL    WITH (NOLOCK) ON TXI.FTCreateBy   = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L       USRAPV  WITH (NOLOCK) ON TXI.FTXthApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                LEFT JOIN TCNMUsrDepart_L  DPTL    WITH (NOLOCK) ON TXI.FTDptCode = DPTL.FTDptCode AND DPTL.FNLngID = $nLngID
                " . $tSQLjoin . "
                LEFT JOIN TCNMRsn_L        RSNL    WITH (NOLOCK) ON TXI.FTRsnCode = RSNL.FTRsnCode AND RSNL.FNLngID = $nLngID
                LEFT JOIN TCNTPdtTwiHDRef TXIHDREF WITH (NOLOCK) ON TXI.FTXthDocNo = TXIHDREF.FTXthDocNo
                LEFT JOIN TCNMShipVia_L    VIAL    WITH (NOLOCK) ON TXIHDREF.FTViaCode = VIAL.FTViaCode AND VIAL.FNLngID = $nLngID
                
                WHERE 1=1 ";

        if ($tXthDocNo != "") {
            $tSQL .= "AND TXI.FTXthDocNo = '$tXthDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }



    //Functionality : Data List Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTWIGetDT($paData)
    {

        $tTblSelectData = $paData['tTblSelectData'];

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXthDocNo ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT

                                TXIDT.FTBchCode,
                                TXIDT.FTXthDocNo,
                                TXIDT.FNXtdSeqNo,
                                TXIDT.FTPdtCode,
                                TXIDT.FTXtdPdtName,
                                TXIDT.FTXtdStkCode,
                                TXIDT.FTPunCode,
                                TXIDT.FTPunName,
                                TXIDT.FCXtdFactor,
                                TXIDT.FTXtdBarCode,
                                TXIDT.FTXtdVatType,
                                TXIDT.FTVatCode,
                                TXIDT.FCXtdVatRate,
                                TXIDT.FCXtdQty,
                                TXIDT.FCXtdQtyAll,
                                TXIDT.FCXtdSetPrice,
                                TXIDT.FCXtdAmt,
                                TXIDT.FCXtdVat,
                                TXIDT.FCXtdVatable,
                                TXIDT.FCXtdNet,
                                TXIDT.FCXtdCostIn,
                                TXIDT.FCXtdCostEx,
                                TXIDT.FTXtdStaPrcStk,
                                TXIDT.FNXtdPdtLevel,
                                TXIDT.FTXtdPdtParent,
                                TXIDT.FCXtdQtySet,
                                TXIDT.FTXtdPdtStaSet,
                                TXIDT.FTXtdRmk,
                                TXIDT.FDLastUpdOn,
                                TXIDT.FTLastUpdBy,
                                TXIDT.FDCreateOn,
                                TXIDT.FTCreateBy

                            FROM " . $tTblSelectData . "DT TXIDT WITH (NOLOCK) 
                            ";


        $tXthDocNo = $paData['FTXthDocNo'];
        if ($tXthDocNo != '') {
            $tSQL .= " WHERE (TXIDT.FTXthDocNo = '$tXthDocNo')";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'rtCode' => '1',
                'raItems'   => $oDetail,
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Data List DT Dis
    //Parameters : function parameters
    //Creator :  03/09/2018 Krit(Copter)
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTXIGetHDRef($paData)
    {

        $tTblSelectData = $paData['tTblSelectData'];
        $tXthDocNo      = $paData['FTXthDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tSQL   = "SELECT
                    TXIR.FTBchCode,
                    TXIR.FTXthDocNo,
                    TXIR.FTXthCtrName,
                    TXIR.FDXthTnfDate,
                    TXIR.FTXthRefTnfID,
                    TXIR.FTXthRefVehID,
                    TXIR.FTXthQtyAndTypeUnit,
                    TXIR.FNXthShipAdd,
                    TXIR.FTViaCode

                FROM " . $tTblSelectData . "HDRef TXIR WITH (NOLOCK) 
                ";


        if (@$tXthDocNo != '') {
            $tSQL .= " WHERE (TXIR.FTXthDocNo = '$tXthDocNo')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'OK.',
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Data List DT Dis
    //Parameters : function parameters
    //Creator :  03/09/2018 Krit(Copter)
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMTWIGetDTDis($paData)
    {


        $tXthDocNo = $paData['FTXthDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tSQL   = "SELECT
                        DTD.FTBchCode,
                        DTD.FTXthDocNo,
                        DTD.FNXpdSeqNo,
                        DTD.FDXddDateIns,
                        DTD.FNXpdStaDis,
                        DTD.FCXddDisChgAvi,
                        DTD.FTXddDisChgTxt,
                        DTD.FCXddDis,
                        DTD.FCXddChg,
                        DTD.FTXddUsrApv
                FROM [TAPTOrdDTDis] DTD WITH (NOLOCK) 
                ";


        if (@$tXthDocNo != '') {
            $tSQL .= " WHERE (DTD.FTXthDocNo = '$tXthDocNo')";
        }

        $tSQL .= " ORDER BY FDXddDateIns ASC";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Chack Data Code Duplicate
    //Parameters : function parameters
    //Creator : 15/02/2019 Krit
    //Last Modified : -
    //Return : Array Count Data
    //Return Type : Array
    public function FSnMTWICheckDuplicate($ptCode, $paDataWhere)
    {

        $tTblSelectData = $paDataWhere['tTblSelectData'];

        $tSQL = "SELECT COUNT(FTXthDocNo)AS counts
                 FROM " . $tTblSelectData . "HD WITH (NOLOCK) 
                 WHERE FTXthDocNo = '$ptCode' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTWIAddUpdateHD($paData, $paDataWhere)
    {

        try {

            $tTblSelectData = $paDataWhere['tTblSelectData'];

            //Update Master
            $this->db->set('FDXthDocDate', $paData['FDXthDocDate']);
            $this->db->set('FTBchCode', $paData['FTBchCode']);
            $this->db->set('FTXthVATInOrEx', $paData['FTXthVATInOrEx']);
            $this->db->set('FTDptCode', $paData['FTDptCode']);
            $this->db->set('FTXthWhFrm', $paData['FTXthWhFrm']);
            $this->db->set('FTXthWhTo', $paData['FTXthWhTo']);
            $this->db->set('FTUsrCode', $paData['FTUsrCode']);
            $this->db->set('FTXthRefExt', $paData['FTXthRefExt']);
            $this->db->set('FDXthRefExtDate', $paData['FDXthRefExtDate']);
            $this->db->set('FTXthRefInt', $paData['FTXthRefInt']);
            $this->db->set('FDXthRefIntDate', $paData['FDXthRefIntDate']);
            $this->db->set('FCXthTotal', $paData['FCXthTotal']);
            $this->db->set('FCXthVat', $paData['FCXthVat']);
            $this->db->set('FCXthVatable', $paData['FCXthVatable']);
            $this->db->set('FTXthRmk', $paData['FTXthRmk']);
            $this->db->set('FTXthStaDoc', $paData['FTXthStaDoc']);
            $this->db->set('FTXthStaApv', $paData['FTXthStaApv']);
            $this->db->set('FTXthStaPrcStk', $paData['FTXthStaPrcStk']);
            $this->db->set('FNXthStaDocAct', $paData['FNXthStaDocAct']);
            $this->db->set('FNXthStaRef', $paData['FNXthStaRef']);
            $this->db->set('FTRsnCode', $paData['FTRsnCode']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            /* WAH */
            if ($tTblSelectData == 'TCNTPdtTwi') {

                $this->db->set('FTXthMerCode', $paData['FTXthMerCode']);

                $this->db->set('FTXthShopFrm', $paData['FTXthShopFrm']);
                $this->db->set('FTXthShopTo', $paData['FTXthShopTo']);

                $this->db->set('FTXthWhFrm', $paData['FTXthWhFrm']);
                $this->db->set('FTXthWhTo', $paData['FTXthWhTo']);
            } else { }

            $this->db->where('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->update($tTblSelectData . 'HD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                //Add Master

                $aDataInsert = array(
                    'FTXthDocNo'            => $paData['FTXthDocNo'],
                    'FDXthDocDate'          => $paData['FDXthDocDate'],
                    'FTBchCode'             => $paData['FTBchCode'],
                    'FTXthVATInOrEx'        => $paData['FTXthVATInOrEx'],
                    'FTDptCode'             => $paData['FTDptCode'],
                    'FTXthWhFrm'            => $paData['FTXthWhFrm'],
                    'FTXthWhTo'             => $paData['FTXthWhTo'],
                    'FTUsrCode'             => $paData['FTUsrCode'],
                    'FTXthRefExt'           => $paData['FTXthRefExt'],
                    'FDXthRefExtDate'       => $paData['FDXthRefExtDate'],
                    'FTXthRefInt'           => $paData['FTXthRefInt'],
                    'FDXthRefIntDate'       => $paData['FDXthRefIntDate'],
                    'FNXthDocPrint'         => $paData['FNXthDocPrint'],
                    'FCXthTotal'            => $paData['FCXthTotal'],
                    'FCXthVat'              => $paData['FCXthVat'],
                    'FCXthVatable'          => $paData['FCXthVatable'],
                    'FTXthRmk'              => $paData['FTXthRmk'],
                    'FTXthStaDoc'           => $paData['FTXthStaDoc'],
                    'FTXthStaApv'           => $paData['FTXthStaApv'],
                    'FTXthStaPrcStk'        => $paData['FTXthStaPrcStk'],
                    'FNXthStaDocAct'        => $paData['FNXthStaDocAct'],
                    'FNXthStaRef'           => $paData['FNXthStaRef'],
                    'FTRsnCode'             => $paData['FTRsnCode'],
                    'FDLastUpdOn'           => $paData['FDLastUpdOn'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy'],
                    'FTLastUpdBy'           => $paData['FTLastUpdBy']
                );

                /* WAH */
                if ($tTblSelectData == 'TCNTPdtTwi') {

                    $aDataInsert['FTXthMerCode']    = $paData['FTXthMerCode'];

                    $aDataInsert['FTXthShopFrm']    = $paData['FTXthShopFrm'];
                    $aDataInsert['FTXthShopTo']     = $paData['FTXthShopTo'];

                    $aDataInsert['FTXthWhFrm']    = $paData['FTXthWhFrm'];
                    $aDataInsert['FTXthWhTo']     = $paData['FTXthWhTo'];
                } else { }

                // print_r($aDataInsert);
                // exit();

                $this->db->insert($tTblSelectData . 'HD', $aDataInsert);
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


    //Update HD After process  
    public function FSnMPMTDelPcoHDDis($paData, $paWhere)
    {

        try {
            //DT Dis
            $this->db->set('FCXthTotal', $paData['FCXthTotal']);
            $this->db->set('FCXthVatNoDisChg', $paData['FCXthVatNoDisChg']);
            $this->db->set('FCXthNoVatNoDisChg', $paData['FCXthNoVatNoDisChg']);
            $this->db->set('FCXthVatDisChgAvi', $paData['FCXthVatDisChgAvi']);
            $this->db->set('FCXthNoVatDisChgAvi', $paData['FCXthNoVatDisChgAvi']);
            $this->db->set('FTXthDisChgTxt', $paData['FTXthDisChgTxt']);
            $this->db->set('FCXthDis', $paData['FCXthDis']);
            $this->db->set('FCXthChg', $paData['FCXthChg']);
            $this->db->set('FCXthRefAEAmt', $paData['FCXthRefAEAmt']);
            $this->db->set('FCXthVatAfDisChg', $paData['FCXthVatAfDisChg']);
            $this->db->set('FCXthNoVatAfDisChg', $paData['FCXthNoVatAfDisChg']);
            $this->db->set('FCXthAfDisChgAE', $paData['FCXthAfDisChgAE']);
            $this->db->set('FTXthWpCode', $paData['FTXthWpCode']);
            $this->db->set('FCXthVat', $paData['FCXthVat']);
            $this->db->set('FCXthVatable', $paData['FCXthVatable']);
            $this->db->set('FCXthGrandB4Wht', $paData['FCXthGrandB4Wht']);
            // $this->db->set('FCXthWpTax' , $paData['FCXthWpTax']);
            $this->db->set('FCXthGrand', $paData['FCXthGrand']);
            $this->db->set('FTXthGndText', $paData['FTXthGndText']);
            $this->db->set('FCXthLeft', $paData['FCXthLeft']);

            $this->db->where('FTXthDocNo', $paWhere['FTXthDocNo']);
            $this->db->update('TAPTOrdHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update HD.',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update HD.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Function Add/Update OrdHDSpl
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTWIAddUpdateHDRef($paData, $paDataWhere)
    {

        try {

            $tTblSelectData = $paDataWhere['tTblSelectData'];

            //Update Master
            $this->db->set('FTBchCode', $paData['FTBchCode']);
            $this->db->set('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->set('FTXthCtrName', $paData['FTXthCtrName']);
            $this->db->set('FDXthTnfDate', $paData['FDXthTnfDate']);
            $this->db->set('FTXthRefTnfID', $paData['FTXthRefTnfID']);
            $this->db->set('FTXthRefVehID', $paData['FTXthRefVehID']);
            $this->db->set('FTXthQtyAndTypeUnit', $paData['FTXthQtyAndTypeUnit']);
            $this->db->set('FNXthShipAdd', $paData['FNXthShipAdd']);
            $this->db->set('FTViaCode', $paData['FTViaCode']);

            $this->db->where('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->update($tTblSelectData . 'HDRef');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                //Add Master
                $this->db->insert($tTblSelectData . 'HDRef', array(

                    'FTBchCode'             => $paData['FTBchCode'],
                    'FTXthDocNo'            => $paData['FTXthDocNo'],
                    'FTXthCtrName'          => $paData['FTXthCtrName'],
                    'FDXthTnfDate'          => $paData['FDXthTnfDate'],
                    'FTXthRefTnfID'         => $paData['FTXthRefTnfID'],
                    'FTXthRefVehID'         => $paData['FTXthRefVehID'],
                    'FTXthQtyAndTypeUnit'   => $paData['FTXthQtyAndTypeUnit'],
                    'FNXthShipAdd'          => $paData['FNXthShipAdd'],
                    'FTViaCode'             => $paData['FTViaCode']

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


    //Functionality : Function Add/Update OrdDT
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTWIAddUpdateOrdDT($paData)
    {

        //Add Master
        $this->db->insert('TCNTPdtTWIDT', array(

            'FTBchCode'             => $paData['FTBchCode'],
            'FTXthDocNo'            => $paData['FTXthDocNo'],
            'FNXpdSeqNo'            => $paData['FNXpdSeqNo'],
            'FTPdtCode'             => $paData['FTPdtCode'],
            'FTXpdPdtName'          => $paData['FTXpdPdtName'],
            'FTXpdStkCode'          => $paData['FTXpdStkCode'],
            'FCXpdStkFac'           => $paData['FCXpdStkFac'],
            'FTPunCode'             => $paData['FTPunCode'],
            'FTPunName'             => $paData['FTPunName'],
            'FCXpdFactor'           => $paData['FCXpdFactor'],
            'FTXpdBarCode'          => $paData['FTXpdBarCode'],
            'FTSrnCode'             => $paData['FTSrnCode'],
            'FTXpdVatType'          => $paData['FTXpdVatType'],
            'FTVatCode'             => $paData['FTVatCode'],
            'FCXpdVatRate'          => $paData['FCXpdVatRate'],
            'FTXpdSaleType'         => $paData['FTXpdSaleType'],
            'FCXpdSalePrice'        => $paData['FCXpdSalePrice'],
            'FCXpdQty'              => $paData['FCXpdQty'],
            'FCXpdQtyAll'           => $paData['FCXpdQtyAll'],
            'FCXpdSetPrice'         => $paData['FCXpdSetPrice'],
            'FCXpdAmt'              => $paData['FCXpdAmt'],
            'FCXpdDisChgAvi'        => $paData['FCXpdDisChgAvi'],
            'FTXpdDisChgTxt'        => $paData['FTXpdDisChgTxt'],
            'FCXpdDis'              => $paData['FCXpdDis'],
            'FCXpdChg'              => $paData['FCXpdChg'],
            'FCXpdNet'              => $paData['FCXpdNet'],
            'FCXpdNetAfHD'          => $paData['FCXpdNetAfHD'],
            'FCXpdNetEx'            => $paData['FCXpdNetEx'],
            'FCXpdVat'              => $paData['FCXpdVat'],
            'FCXpdVatable'          => $paData['FCXpdVatable'],
            'FCXpdWhtAmt'           => $paData['FCXpdWhtAmt'],
            'FTXpdWhtCode'          => $paData['FTXpdWhtCode'],
            'FCXpdWhtRate'          => $paData['FCXpdWhtRate'],
            'FCXpdCostIn'           => $paData['FCXpdCostIn'],
            'FCXpdCostEx'           => $paData['FCXpdCostEx'],
            'FTXpdStaPdt'           => $paData['FTXpdStaPdt'],
            'FCXpdQtyLef'           => $paData['FCXpdQtyLef'],
            'FCXpdQtyRfn'           => $paData['FCXpdQtyRfn'],
            'FTXpdStaPrcStk'        => $paData['FTXpdStaPrcStk'],
            'FTXpdStaAlwDis'        => $paData['FTXpdStaAlwDis'],
            'FNXpdPdtLevel'         => $paData['FNXpdPdtLevel'],
            'FTXpdPdtParent'        => $paData['FTXpdPdtParent'],
            'FCXpdQtySet'           => $paData['FCXpdQtySet'],
            'FTPdtStaSet'           => $paData['FTPdtStaSet'],
            'FTXpdRmk'              => $paData['FTXpdRmk'],
            'FDLastUpdOn'           => $paData['FDLastUpdOn'],
            'FTLastUpdBy'           => $paData['FTLastUpdBy'],
            'FDCreateOn'            => $paData['FDCreateOn'],
            'FTCreateBy'            => $paData['FTCreateBy']


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


    //Functionality : Function Update OrdDT DisChgTxt,Dis,Chg
    //Parameters : function parameters
    //Creator : 05/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Update Master
    //Return Type : array
    public function FSaMTWIUpdateOrdDT($paData, $paWhere)
    {

        try {
            //DT Dis
            $this->db->set('FTXpdDisChgTxt', $paData['FTXpdDisChgTxt']);
            $this->db->set('FCXpdDis', $paData['FCXpdDis']);
            $this->db->set('FCXpdChg', $paData['FCXpdChg']);
            $this->db->set('FCXpdNet', $paData['FCXpdNet']);
            $this->db->set('FCXpdNetAfHD', $paData['FCXpdNetAfHD']);
            $this->db->set('FCXpdVat', $paData['FCXpdVat']);
            $this->db->set('FCXpdVatable', $paData['FCXpdVatable']);
            $this->db->set('FCXpdWhtAmt', $paData['FCXpdWhtAmt']);
            $this->db->set('FCXpdCostIn', $paData['FCXpdCostIn']);
            $this->db->set('FCXpdCostEx', $paData['FCXpdCostEx']);
            $this->db->set('FCXpdQtyLef', $paData['FCXpdQtyLef']);
            $this->db->set('FCXpdNetEx', $paData['FCXpdNetEx']);

            $this->db->where('FTXthDocNo', $paWhere['FTXthDocNo']);
            $this->db->where('FNXpdSeqNo', $paWhere['FNXpdSeqNo']);
            $this->db->update('TAPTOrdDT');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update DT.',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update DT.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Function Add/Update TAPTOrdDTDis
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMTWIAddUpdateOrdDTDis($paData)
    {

        //Add Master
        $this->db->insert('TAPTOrdDTDis', array(

            'FTBchCode'             => $paData['FTBchCode'],
            'FTXthDocNo'            => $paData['FTXthDocNo'],
            'FNXpdSeqNo'            => $paData['FNXpdSeqNo'],
            'FDXddDateIns'          => $paData['FDXddDateIns'],
            'FNXpdStaDis'           => $paData['FNXpdStaDis'],
            'FCXddDisChgAvi'        => $paData['FCXddDisChgAvi'],
            'FTXddDisChgTxt'        => $paData['FTXddDisChgTxt'],
            'FCXddDis'              => $paData['FCXddDis'],
            'FCXddChg'              => $paData['FCXddChg'],
            'FTXddUsrApv'           => $paData['FTXddUsrApv']

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



    //Functionality : Delete DT Dis
    //Parameters : function parameters
    //Creator : 17/07/2018 Krit
    //Return : response
    //Return Type : array
    public function FSnMPMTDelPcoDTDis($ptXthDocNo)
    {

        $this->db->where_in('FTXthDocNo', $ptXthDocNo);
        $this->db->delete('TAPTOrdDTDis');

        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }




    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMSDTAddUpdateLang($paData)
    {
        try {
            //Update Lang
            $this->db->set('FTSudName', $paData['FTSudName']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTSudCode', $paData['FTSudCode']);
            $this->db->update('TCNMSubDistrict_L');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            } else {
                //Add Lang
                $this->db->insert('TCNMSubDistrict_L', array(
                    'FTSudCode' => $paData['FTSudCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTSudName' => $paData['FTSudName']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Functionality : Delete PurchaseOrder
    //Parameters : function parameters
    //Creator : 29/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSnMTWIDel($paData)
    {
        try {
            $this->db->trans_begin();

            $tTblSelectData = $paData['tTblSelectData'];

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->delete($tTblSelectData . 'HD');

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->delete($tTblSelectData . 'HDRef');

            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->delete($tTblSelectData . 'DT');


            //Del Temp
            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->where_in('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->delete('TCNTDocDTTmp');

            //Del Temp
            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            // $this->db->where_in('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->delete('TCNTDocHDDisTmp');

            //Del Temp
            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            // $this->db->where_in('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->delete('TCNTDocDTDisTmp');


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
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Delete PurchaseOrder
    //Parameters : function parameters
    //Creator : 29/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSnMTWIDelDTTmp($paData)
    {
        try {
            $this->db->trans_begin();

            $this->db->where_in('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->where_in('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->where_in('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            $this->db->where_in('FTPdtCode',  $paData['FTPdtCode']);
            $this->db->where_in('FTSessionID', $paData['FTSessionID']);
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
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Multi Pdt Del Temp
    //Parameters : function parameters
    //Creator : 25/03/2019 Krit(Copter)
    //Return : Status Delete
    //Return Type : array
    public function FSaMTXIPdtTmpMultiDel($paData)
    {
        try {

            $this->db->trans_begin();

            //Del DTTmp
            $this->db->where('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->where('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            $this->db->where('FTXthDocKey', $paData['FTXthDocKey']);
            $this->db->delete('TCNTDocDTTmp');

            //Del DTDisTmp
            $this->db->where('FTXthDocNo', $paData['FTXthDocNo']);
            $this->db->where('FNXtdSeqNo', $paData['FNXtdSeqNo']);
            $this->db->delete('TCNTDocDTDisTmp');

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
        } catch (Exception $Error) {
            return $Error;
        }
    }


    public function FSnMTWIGetDocType($ptTableName)
    {

        $tSQL = "SELECT FNSdtDocType FROM TSysDocType WITH (NOLOCK)  
                WHERE FTSdtTblName='$ptTableName'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $nDetail = $oDetail[0]->FNSdtDocType;
        } else {
            $nDetail = '';
        }

        return $nDetail;
    }
}
