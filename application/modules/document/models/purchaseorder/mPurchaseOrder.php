<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPurchaseOrder extends CI_Model {

    // Functionality: Get Data Purchase Invoice HD List
    // Parameters: function parameters
    // Creator:  19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMPOGetDataTableList($paDataCondition){
        $aRowLen                = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                 = $paDataCondition['FNLngID'];
        $aDatSessionUserLogIn   = $paDataCondition['aDatSessionUserLogIn'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList        = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove  = $aAdvanceSearch['tSearchStaApprove'];
        // $tSearchStaPrcStk   = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC ,FTXphDocNo DESC ) AS FNRowID,* FROM
                                (   SELECT DISTINCT
                                        POHD.FTBchCode,
                                        BCHL.FTBchName,
                                        POHD.FTXphDocNo,
                                        CONVERT(CHAR(10),POHD.FDXphDocDate,103) AS FDXphDocDate,
                                        CONVERT(CHAR(5), POHD.FDXphDocDate,108) AS FTXphDocTime,
                                        POHD.FTXphStaDoc,
                                        POHD.FTXphStaApv,
                                        -- POHD.FTXpdStaPrcStk,
                                        POHD.FNXphStaRef,
                                        POHD.FTCreateBy,
                                        POHD.FDCreateOn,
                                        USRL.FTUsrName      AS FTCreateByName,
                                        POHD.FTXphApvCode,
                                        USRLAPV.FTUsrName   AS FTXphApvName
                                    FROM TAPTPoHD           POHD    WITH (NOLOCK)
                                    LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON POHD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON POHD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON POHD.FTXphApvCode  = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                                WHERE 1=1
        ";

        // Check User Login Branch
        // if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
        //     $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
        //     $tSQL   .= " AND POHD.FTBchCode = '$tUserLoginBchCode' ";
        // }

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND POHD.FTBchCode IN ($tBchCode)
            ";
        }
        
        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .= " AND POHD.FTShpCode = '$tUserLoginShpCode' ";
        }

        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((POHD.FTXphDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),POHD.FDXphDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((POHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (POHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((POHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (POHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND POHD.FTXphStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(POHD.FTXphStaApv,'') = '' AND POHD.FTXphStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND POHD.FTXphStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะอนุมัติ
        if(isset($tSearchStaApprove) && !empty($tSearchStaApprove)){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND POHD.FTXphStaApv = '$tSearchStaApprove' OR POHD.FTXphStaApv = '' ";
            }else{
                $tSQL .= " AND POHD.FTXphStaApv = '$tSearchStaApprove'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND POHD.FNXphStaDocAct = 1";
            } else {
                $tSQL .= " AND POHD.FNXphStaDocAct = 0";
            }
        }


        $tSQL   .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMPOCountPageDocListAll($paDataCondition);
            $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1')? $aDataCountAllRow['rtCountData'] : 0;
            $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $oDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality: Data Get Data Page All
    // Parameters: function parameters
    // Creator:  19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSnMPOCountPageDocListAll($paDataCondition){
        $nLngID                 = $paDataCondition['FNLngID'];
        $aDatSessionUserLogIn   = $paDataCondition['aDatSessionUserLogIn'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList        = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove  = $aAdvanceSearch['tSearchStaApprove'];
        // $tSearchStaPrcStk   = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   =   "   SELECT COUNT (POHD.FTXphDocNo) AS counts
                        FROM TAPTPoHD POHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON POHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        WHERE 1=1
                    ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND POHD.FTBchCode IN ($tBchCode)
            ";
        }

        // Check User Login Branch
        if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
            $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
            $tSQL   .= " AND POHD.FTBchCode = '$tUserLoginBchCode' ";
        }

        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .= " AND POHD.FTShpCode = '$tUserLoginShpCode' ";
        }
        
        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((POHD.FTXphDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),POHD.FDXphDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((POHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (POHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((POHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (POHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }
        // ค้นหาสถานะอนุมัติ
        if(isset($tSearchStaApprove) && !empty($tSearchStaApprove)){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND POHD.FTXphStaApv = '$tSearchStaApprove' OR POHD.FTXphStaApv = '' ";
            }else{
                $tSQL .= " AND POHD.FTXphStaApv = '$tSearchStaApprove'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND POHD.FNXphStaDocAct = 1";
            } else {
                $tSQL .= " AND POHD.FNXphStaDocAct = 0";
            }
        }
  
        
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Delete Purchase Invoice Document
    // Parameters : function parameters
    // Creator : 19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSnMPODelDocument($paDataDoc){
        $tDataDocNo = $paDataDoc['tDataDocNo'];
        $this->db->trans_begin();

        // Document HD
        $this->db->where_in('FTXphDocNo',$tDataDocNo);
        $this->db->delete('TAPTPoHD');


        // Document HD Discount
        $this->db->where_in('FTXphDocNo',$tDataDocNo);
        $this->db->delete('TAPTPoHDDis');
        
        // Document DT
        $this->db->where_in('FTXphDocNo',$tDataDocNo);
        $this->db->delete('TAPTPoDT');

        // Document DT Discount
        $this->db->where_in('FTXphDocNo',$tDataDocNo);
        $this->db->delete('TAPTPoDTDis');
        
        // Document HD
        $this->db->where_in('FTXphDocNo',$tDataDocNo);
        $this->db->delete('TAPTPoHDSpl');
        

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

    // Functionality : Delete Purchase Invoice Document
    // Parameters : function parameters
    // Creator : 24/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSxMPOClearDataInDocTemp($paWhereClearTemp){
        $tPODocNo       = $paWhereClearTemp['FTXthDocNo'];
        $tPODocKey      = $paWhereClearTemp['FTXthDocKey'];
        $tPOSessionID   = $paWhereClearTemp['FTSessionID'];

        // Query Delete DocTemp
        $tClearDocTemp  =   "   DELETE FROM TCNTDocDTTmp 
                                WHERE 1=1 
                                AND TCNTDocDTTmp.FTXthDocNo     = '$tPODocNo'
                                AND TCNTDocDTTmp.FTXthDocKey    = '$tPODocKey'
                                AND TCNTDocDTTmp.FTSessionID    = '$tPOSessionID'
        ";
        $this->db->query($tClearDocTemp);


        // Query Delete Doc HD Discount Temp
        $tClearDocHDDisTemp =   "   DELETE FROM TCNTDocHDDisTmp
                                    WHERE 1=1
                                    AND TCNTDocHDDisTmp.FTXthDocNo  = '$tPODocNo'
                                    AND TCNTDocHDDisTmp.FTSessionID = '$tPOSessionID'
        ";
        $this->db->query($tClearDocHDDisTemp);

        // Query Delete Doc DT Discount Temp
        $tClearDocDTDisTemp =   "   DELETE FROM TCNTDocDTDisTmp
                                    WHERE 1=1
                                    AND TCNTDocDTDisTmp.FTXthDocNo  = '$tPODocNo'
                                    AND TCNTDocDTDisTmp.FTSessionID = '$tPOSessionID'
        ";
        $this->db->query($tClearDocDTDisTemp);
    
    }

    // Functionality: Get ShopCode From User Login
    // Parameters: function parameters
    // Creator: 24/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Array Data Shop For User Login
    // ReturnType: array
    public function FSaMPOGetShpCodeForUsrLogin($paDataShp){
        $nLngID     = $paDataShp['FNLngID'];
        $tUsrLogin  = $paDataShp['tUsrLogin'];
        $tSQL       = " SELECT
                            UGP.FTBchCode,
                            BCHL.FTBchName,
                            MER.FTMerCode,
                            MERL.FTMerName,
                            UGP.FTShpCode,
                            SHPL.FTShpName,
                            SHP.FTShpType,
                            SHP.FTWahCode   AS FTWahCode,
                            WAHL.FTWahName  AS FTWahName
                        FROM TCNTUsrGroup           UGP     WITH (NOLOCK)
                        LEFT JOIN TCNMBranch        BCH     WITH (NOLOCK) ON UGP.FTBchCode = BCH.FTBchCode 
                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK) ON UGP.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop          SHP     WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode
                        LEFT JOIN TCNMShop_L        SHPL    WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMMerchant		MER		WITH (NOLOCK)	ON SHP.FTMerCode	= MER.FTMerCode
                        LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK) ON SHP.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAHL    WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode
                        WHERE UGP.FTUsrCode = '$tUsrLogin' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = "";
        }
        unset($oQuery);
        return $aResult;
    }

    // Functionality: Get Data Config WareHouse TSysConfig
    // Parameters: function parameters
    // Creator: 25/07/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Array Data Default Config WareHouse
    // ReturnType: array
    public function FSaMPOGetDefOptionConfigWah($paConfigSys){
        $tSysCode       = $paConfigSys['FTSysCode'];
        $nSysSeq        = $paConfigSys['FTSysSeq'];
        $nLngID         = $paConfigSys['FNLngID'];
        $aDataReturn    = array();

        $tSQLUsrVal = " SELECT
                            SYSCON.FTSysStaUsrValue AS FTSysWahCode,
                            WAHL.FTWahName          AS FTSysWahName
                        FROM TSysConfig SYSCON          WITH(NOLOCK)
                        LEFT JOIN TCNMWaHouse   WAH     WITH(NOLOCK)    ON SYSCON.FTSysStaUsrValue  = WAH.FTWahCode     AND WAH.FTWahStaType = 1
                        LEFT JOIN TCNMWaHouse_L WAHL    WITH(NOLOCK)    ON WAH.FTWahCode            = WAHL.FTWahCode    AND WAHL.FNLngID = $nLngID
                        WHERE 1=1
                        AND SYSCON.FTSysCode    = '$tSysCode'
                        AND SYSCON.FTSysSeq     = $nSysSeq
        ";
        $oQuery1    = $this->db->query($tSQLUsrVal);
        if($oQuery1->num_rows() > 0){
            $aDataReturn    = $oQuery1->row_array();
        }else{
            $tSQLUsrDef =   "   SELECT
                                    SYSCON.FTSysStaDefValue AS FTSysWahCode,
                                    WAHL.FTWahName          AS FTSysWahName
                        FROM TSysConfig SYSCON          WITH(NOLOCK)
                        LEFT JOIN TCNMWaHouse   WAH     WITH(NOLOCK)    ON SYSCON.FTSysStaDefValue  = WAH.FTWahCode     AND WAH.FTWahStaType = 1
                        LEFT JOIN TCNMWaHouse_L WAHL    WITH(NOLOCK)    ON WAH.FTWahCode            = WAHL.FTWahCode    AND WAHL.FNLngID = $nLngID
                        WHERE 1=1
                        AND SYSCON.FTSysCode    = '$tSysCode'
                        AND SYSCON.FTSysSeq     = $nSysSeq
            ";
            $oQuery2    = $this->db->query($tSQLUsrDef);
            if($oQuery2->num_rows() > 0){
                $aDataReturn    = $oQuery2->row_array();
            }
        }
        unset($oQuery1);
        unset($oQuery2);
        return $aDataReturn;
    }

    // Functionality: Get Data In Doc DT Temp
    // Parameters: function parameters
    // Creator: 01/07/2019 wasin (Yoshi)
    // Last Modified: -
    // Return: Array Data Doc DT Temp
    // ReturnType: array
    public function FSaMPOGetDocDTTempListPage($paDataWhere){
        $tPODocNo           = $paDataWhere['FTXthDocNo'];
        $tPODocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tPOSesSessionID    = $this->session->userdata('tSesSessionID');

        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tSQL       = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM (
                                SELECT
                                    DOCTMP.FTBchCode,
                                    DOCTMP.FTXthDocNo,
                                    DOCTMP.FNXtdSeqNo,
                                    DOCTMP.FTXthDocKey,
                                    DOCTMP.FTPdtCode,
                                    -- IMGPDT.FTImgObj,
                                    DOCTMP.FTXtdPdtName,
                                    DOCTMP.FTPunName,
                                    DOCTMP.FTXtdBarCode,
                                    DOCTMP.FTPunCode,
                                    DOCTMP.FCXtdFactor,
                                    DOCTMP.FCXtdQty,
                                    DOCTMP.FCXtdSetPrice,
                                    DOCTMP.FCXtdAmtB4DisChg,
                                    DOCTMP.FTXtdDisChgTxt,
                                    DOCTMP.FCXtdNet,
                                    DOCTMP.FCXtdNetAfHD,
                                    DOCTMP.FTXtdStaAlwDis,
                                    DOCTMP.FTTmpRemark,
                                    DOCTMP.FCXtdVatRate,
                                    DOCTMP.FTXtdVatType,
                                    DOCTMP.FTSrnCode,
                                    DOCTMP.FDLastUpdOn,
                                    DOCTMP.FDCreateOn,
                                    DOCTMP.FTLastUpdBy,
                                    DOCTMP.FTCreateBy
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                -- LEFT JOIN TCNMImgPdt IMGPDT on DOCTMP.FTPdtCode = IMGPDT.FTImgRefID AND IMGPDT.FTImgTable='TCNMPdt'
                                WHERE 1 = 1
                                AND ISNULL(DOCTMP.FTXthDocNo,'')  = '$tPODocNo'
                                AND DOCTMP.FTXthDocKey = '$tPODocKey'
                                AND DOCTMP.FTSessionID = '$tPOSesSessionID' ";
                                
        if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
            $tSQL   .=  "   AND (
                                DOCTMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%' )
                        ";
            
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";


        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMPOGetDocDTTempListPageAll($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }   

    // Functionality : Count All Documeny DT Temp
    // Parameters : function parameters
    // Creator : 01/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array Data Count All Data
    // Return Type : array
    public function FSaMPOGetDocDTTempListPageAll($paDataWhere){
        $tPODocNo           = $paDataWhere['FTXthDocNo'];
        $tPODocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tPOSesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP
                    WHERE 1 = 1 ";
        
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tPODocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tPODocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tPOSesSessionID' ";

        // if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
        //     $tSQL   .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchPdtAdvTable%' ";
        //     $tSQL   .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchPdtAdvTable%' ";
        //     $tSQL   .= " OR DOCTMP.FTPunName    LIKE '%$tSearchPdtAdvTable%' ";
        //     $tSQL   .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchPdtAdvTable%' ";
        // }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Function Sum Amount DT Temp
    // Parameters : function parameters
    // Creator : 01/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMPOSumDocDTTemp($paDataWhere){
        $tPODocNo           = $paDataWhere['FTXthDocNo'];
        $tPODocKey          = $paDataWhere['FTXthDocKey'];
        $tPOSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL               = " SELECT
                                    SUM(FCXtdNetAfHD)       AS FCXtdSumNetAfHD,
                                    SUM(FCXtdAmtB4DisChg)   AS FCXtdSumAmtB4DisChg
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tPODocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tPODocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tPOSesSessionID' ";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
            $aDataReturn    =  array(
                'raDataSum' => $aResult,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Sum Empty',
            );
        }
        unset($oQuery);
        unset($aResult);
        return $aDataReturn;
    }

    // Functionality : Function Get Max Seq From Doc DT Temp
    // Parameters : function parameters
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMPOGetMaxSeqDocDTTemp($paDataWhere){
        $tPOBchCode         = $paDataWhere['FTBchCode'];
        $tPODocNo           = $paDataWhere['FTXthDocNo'];
        $tPODocKey          = $paDataWhere['FTXthDocKey'];
        $tPOSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL   =   "   SELECT 
                            MAX(DOCTMP.FNXtdSeqNo) AS rnMaxSeqNo
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTBchCode   = '$tPOBchCode'";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tPODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tPODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tPOSesSessionID'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $nResult    = $aDetail['rnMaxSeqNo'];
        }else{
            $nResult    = 0;
        }
        return empty($nResult)? 0 : $nResult;
    }

    // Functionality : Get Data Pdt
    // Parameters : function parameters
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMPOGetDataPdt($paDataPdtParams){
        $tPdtCode   = $paDataPdtParams['tPdtCode'];
        $FTPunCode  = $paDataPdtParams['tPunCode'];
        $FTBarCode  = $paDataPdtParams['tBarCode'];
        $nLngID     = $paDataPdtParams['nLngID'];
        $tSQL       = " SELECT
                            PDT.FTPdtCode,
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
                            0 AS FTPdtSalePrice,
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
                            BAR.FTPlcCode,
                            PDTLOCL.FTPlcName,
                            PDTSRL.FTSrnCode,
                            PDT.FCPdtCostStd,
                            CAVG.FCPdtCostEx,
                            CAVG.FCPdtCostIn,
                            SPL.FCSplLastPrice
                        FROM TCNMPdt PDT WITH (NOLOCK)
                        LEFT JOIN TCNMPdt_L PDTL        WITH (NOLOCK)   ON PDT.FTPdtCode      = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtPackSize  PKS  WITH (NOLOCK)   ON PDT.FTPdtCode      = PKS.FTPdtCode     AND PKS.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtUnit_L UNTL    WITH (NOLOCK)   ON UNTL.FTPunCode     = '$FTPunCode'      AND UNTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtBar BAR        WITH (NOLOCK)   ON PKS.FTPdtCode      = BAR.FTPdtCode     AND BAR.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtLoc_L PDTLOCL  WITH (NOLOCK)   ON PDTLOCL.FTPlcCode  = BAR.FTPlcCode     AND PDTLOCL.FNLngID = $nLngID
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTVatCode,
                                FCVatRate,
                                FDVatStart
                            FROM TCNMVatRate WITH (NOLOCK)
                            WHERE CONVERT(VARCHAR(19),GETDATE(),121) > FDVatStart ) VAT
                        ON PDT.FTVatCode = VAT.FTVatCode
                        LEFT JOIN TCNTPdtSerial PDTSRL  WITH (NOLOCK)   ON PDT.FTPdtCode    = PDTSRL.FTPdtCode
                        LEFT JOIN TCNMPdtSpl SPL        WITH (NOLOCK)   ON PDT.FTPdtCode    = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode
                        LEFT JOIN TCNMPdtCostAvg CAVG   WITH (NOLOCK)   ON PDT.FTPdtCode    = CAVG.FTPdtCode
                        WHERE 1 = 1 ";
    
        if(isset($tPdtCode) && !empty($tPdtCode)){
            $tSQL   .= " AND PDT.FTPdtCode   = '$tPdtCode'";
        }

        if(isset($FTBarCode) && !empty($FTBarCode)){
            $tSQL   .= " AND BAR.FTBarCode = '$FTBarCode'";
        }

        $tSQL   .= " ORDER BY FDVatStart DESC";
        $oQuery = $this->db->query($tSQL);
   
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $aResult    = array(
                'raItem'    => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aResult;
    }

    // Functionality : Insert Pdt To Doc DT Temp
    // Parameters : function parameters
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMPOInsertPDTToTemp($paDataPdtMaster,$paDataPdtParams){
        $paPIDataPdt    = $paDataPdtMaster['raItem'];
        if($paDataPdtParams['tPOOptionAddPdt'] == 1){
            // นำสินค้าเพิ่มจำนวนในแถวแรก
            $tSQL   =   "   SELECT
                                FNXtdSeqNo, 
                                FCXtdQty
                            FROM TCNTDocDTTmp
                            WHERE 1=1 
                            AND FTXthDocNo      = '".$paDataPdtParams['tDocNo']."'
                            AND FTBchCode       = '".$paDataPdtParams['tBchCode']."'
                            AND FTXthDocKey     = '".$paDataPdtParams['tDocKey']."'
                            AND FTSessionID     = '".$paDataPdtParams['tSessionID']."'
                            AND FTPdtCode       = '".$paPIDataPdt["FTPdtCode"]."'
                            AND FTXtdBarCode    = '".$paPIDataPdt["FTBarCode"]."'
                            ORDER BY FNXtdSeqNo
                        ";
                        // echo $tSQL.'<br>';
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                // เพิ่มจำนวนให้รายการที่มีอยู่แล้ว
                $aResult    = $oQuery->row_array();
                $tSQL       =   "   UPDATE TCNTDocDTTmp
                                    SET FCXtdQty = '".($aResult["FCXtdQty"] + 1 )."'
                                    WHERE 1=1
                                    AND FTBchCode       = '".$paDataPdtParams['tBchCode']."'
                                    AND FTXthDocNo      = '".$paDataPdtParams['tDocNo']."'
                                    AND FNXtdSeqNo      = '".$aResult["FNXtdSeqNo"]."'
                                    AND FTXthDocKey     = '".$paDataPdtParams['tDocKey']."'
                                    AND FTSessionID     = '".$paDataPdtParams['tSessionID']."'
                                    AND FTPdtCode       = '".$paPIDataPdt["FTPdtCode"]."'
                                    AND FTXtdBarCode    = '".$paPIDataPdt["FTBarCode"]."'
                                ";
                $this->db->query($tSQL);
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            }else{
                // เพิ่มรายการใหม่
                $aDataInsert    = array(
                    'FTBchCode'         => $paDataPdtParams['tBchCode'],
                    'FTXthDocNo'        => $paDataPdtParams['tDocNo'],
                    'FNXtdSeqNo'        => $paDataPdtParams['nMaxSeqNo'],
                    'FTXthDocKey'       => $paDataPdtParams['tDocKey'],
                    'FTPdtCode'         => $paPIDataPdt['FTPdtCode'],
                    'FTXtdPdtName'      => $paPIDataPdt['FTPdtName'],
                    'FCXtdFactor'       => $paPIDataPdt['FCPdtUnitFact'],
                    'FTPunCode'         => $paPIDataPdt['FTPunCode'],
                    'FTPunName'         => $paPIDataPdt['FTPunName'],
                    'FTXtdBarCode'      => $paDataPdtParams['tBarCode'],
                    'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVatBuy'],
                    // 'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVat'],
                    'FTVatCode'         => $paDataPdtParams['nVatCode'],
                    'FCXtdVatRate'      => $paDataPdtParams['nVatRate'],
                    'FTXtdStaAlwDis'    => $paPIDataPdt['FTPdtStaAlwDis'],
                    'FTXtdSaleType'     => $paPIDataPdt['FTPdtSaleType'],
                    'FCXtdSalePrice'    => $paDataPdtParams['cPrice'],
                    'FCXtdQty'          => 1,
                    'FCXtdQtyAll'       => 1*$paPIDataPdt['FCPdtUnitFact'],
                    'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                    'FCXtdNet'          => $paDataPdtParams['cPrice'] * 1,
                    // 'FCXtdNetAfHD'      => $paDataPdtParams['cPrice'] * 1,
                    'FTSessionID'       => $paDataPdtParams['tSessionID'],
                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                    'FTLastUpdBy'       => $paDataPdtParams['tPOUsrCode'],
                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                    'FTCreateBy'        => $paDataPdtParams['tPOUsrCode'],
                );
                $this->db->insert('TCNTDocDTTmp',$aDataInsert);

                // $this->db->last_query();  
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'Add Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Add.',
                    );
                }
            }   
        }else{
            // เพิ่มแถวใหม่
            $aDataInsert    = array(
                'FTBchCode'         => $paDataPdtParams['tBchCode'],
                'FTXthDocNo'        => $paDataPdtParams['tDocNo'],
                'FNXtdSeqNo'        => $paDataPdtParams['nMaxSeqNo'],
                'FTXthDocKey'       => $paDataPdtParams['tDocKey'],
                'FTPdtCode'         => $paPIDataPdt['FTPdtCode'],
                'FTXtdPdtName'      => $paPIDataPdt['FTPdtName'],
                'FCXtdFactor'       => $paPIDataPdt['FCPdtUnitFact'],
                'FTPunCode'         => $paPIDataPdt['FTPunCode'],
                'FTPunName'         => $paPIDataPdt['FTPunName'],
                'FTXtdBarCode'      => $paDataPdtParams['tBarCode'],
                'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVatBuy'],
                // 'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVat'],
                'FTVatCode'         => $paDataPdtParams['nVatCode'],
                'FCXtdVatRate'      => $paDataPdtParams['nVatRate'],
                'FTXtdStaAlwDis'    => $paPIDataPdt['FTPdtStaAlwDis'],
                'FTXtdSaleType'     => $paPIDataPdt['FTPdtSaleType'],
                'FCXtdSalePrice'    => $paDataPdtParams['cPrice'],
                'FCXtdQty'          => 1,
                'FCXtdQtyAll'       => 1*$paPIDataPdt['FCPdtUnitFact'],
                'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                'FCXtdNet'          => $paDataPdtParams['cPrice'] * 1,
                // 'FCXtdNetAfHD'      => $paDataPdtParams['cPrice'] * 1,
                'FTSessionID'       => $paDataPdtParams['tSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $paDataPdtParams['tPOUsrCode'],
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $paDataPdtParams['tPOUsrCode'],
            );
            $this->db->insert('TCNTDocDTTmp',$aDataInsert);
            // $this->db->last_query();  
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
        }
        return $aStatus;
    }

    // Functionality : Update Document DT Temp by Seq
    // Parameters : function parameters
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMPOUpdateInlineDTTemp($paDataUpdateDT,$paDataWhere){

            // $this->db->set($paDataUpdateDT['tPOFieldName'], $paDataUpdateDT['tPOValue']);

            $this->db->set('FCXtdQty', $paDataUpdateDT['FCXtdQty']);
            $this->db->set('FCXtdSetPrice', $paDataUpdateDT['FCXtdSetPrice']);
            $this->db->set('FCXtdNet', $paDataUpdateDT['FCXtdNet']);

            $this->db->where('FTSessionID',$paDataWhere['tPOSessionID']);
            $this->db->where('FTXthDocKey',$paDataWhere['tDocKey']);
            $this->db->where('FNXtdSeqNo',$paDataWhere['nPOSeqNo']);
            $this->db->where('FTXthDocNo',$paDataWhere['tPODocNo']);
            $this->db->where('FTBchCode',$paDataWhere['tPOBchCode']);
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

    
    // Functionality : Count Check Data Product In Doc DT Temp Before Save
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Count
    // Return Type : array
    public function FSnMPOChkPdtInDocDTTemp($paDataWhere){
        $tPODocNo       = $paDataWhere['FTXthDocNo'];
        $tPODocKey      = $paDataWhere['FTXthDocKey'];
        $tPOSessionID   = $paDataWhere['FTSessionID'];
        $tSQL           = " SELECT
                                COUNT(FNXtdSeqNo) AS nCountPdt
                            FROM TCNTDocDTTmp DocDT
                            WHERE 1=1
                            AND DocDT.FTXthDocNo    = '$tPODocNo'
                            AND DocDT.FTXthDocKey   = '$tPODocKey'
                            AND DocDT.FTSessionID   = '$tPOSessionID' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->row_array();
            return $aDataQuery['nCountPdt'];
        }else{
            return 0;
        }
    }

    // Functionality :  Delete Product Single Item In Doc DT Temp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSnMPODelPdtInDTTmp($paDataWhere){
        // Delete Doc DT Temp
        $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        $this->db->where_in('FTPdtCode',$paDataWhere['tPdtCode']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->delete('TCNTDocDTTmp');

        // Delete Doc DT Temp
        $this->db->where_in('FNXtdStaDis',1);
        $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->delete('TCNTDocDTDisTmp');
        return ;
    }

    // Functionality : Delete Product Multiple Items In Doc DT Temp
    // Parameters : function parameters
    // Creator : 30/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSnMPODelMultiPdtInDTTmp($paDataWhere){
        $tSessionID = $this->session->userdata('tSesSessionID');

        // Delete Doc DT Temp
        $this->db->where_in('FTSessionID',$tSessionID);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['aDataSeqNo']);
        // $this->db->where_in('FTPunCode',$paDataWhere['aDataPunCode']);
        $this->db->where_in('FTPdtCode',$paDataWhere['aDataPdtCode']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->delete('TCNTDocDTTmp');

        // Delete Doc DT Temp
        $this->db->where_in('FNXtdStaDis',1);
        $this->db->where_in('FTSessionID',$tSessionID);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['aDataSeqNo']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->delete('TCNTDocDTDisTmp');
        return ;
    }


    // ============================================================================== Calcurate HD Document =============================================================================

    // Functionality    : Function Get Cal From DT Temp
    // Parameters       : function parameters
    // Creator          : 04/07/2019 Wasin(Yoshi)
    // Last Modified    : 24/02/2021 supawat
    // Return           : array
    // Return Type      : array
    public function FSaMPOCalInDTTemp($paParams){
        $tDocNo         = $paParams['tDocNo'];
        $tDocKey        = $paParams['tDocKey'];
        $tBchCode       = $paParams['tBchCode'];
        $tSessionID     = $paParams['tSessionID'];
        $tDataVatInOrEx = $paParams['tDataVatInOrEx'];
        
        $tSQL       = " SELECT
                            /* ยอดรวม ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdNet, 0)) AS FCXphTotal,

                            /* ยอดรวมสินค้าไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalNV,

                            /* ยอดรวมสินค้าห้ามลด ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalNoDis,

                            /* ยอมรวมสินค้าลดได้ และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalB4DisChgV,

                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalB4DisChgNV,

                            /* ยอดรวมหลังลด และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXphTotalAfDisChgV,

                            /* ยอดรวมหลังลด และไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXphTotalAfDisChgNV,

                            /* ยอดรวมเฉพาะภาษี ==============================================================*/
                            (
                                CASE 
                                    WHEN $tDataVatInOrEx = 1 THEN --รวมใน
                                        (
                                            /* ยอดรวม */
                                            SUM(DTTMP.FCXtdNet)
                                            - 
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี FCXphTotalAfDisChgV */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    WHEN $tDataVatInOrEx = 2 THEN --แยกนอก
                                        (
                                            /* ยอดรวม */
                                            SUM(DTTMP.FCXtdNet)
                                            - 
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี FCXphTotalAfDisChgV */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN 
                                                        ISNULL(DTTMP.FCXtdNetAfHD, 0) + ISNULL(DTTMP.FCXtdVat, 0) 
                                                    ELSE 0
                                                END
                                            )
                                        )
                                ELSE 0 END
                            ) AS FCXphAmtV,

                            /* ยอดรวมเฉพาะไม่มีภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวมสินค้าไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                                -
                                (
                                    /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                            ELSE 0
                                        END
                                    )
                                    -
                                    /* ยอดรวมหลังลด และไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                            ) AS FCXphAmtNV,

                            /* ยอดภาษี ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdVat, 0)) AS FCXphVat,

                            /* ยอดแยกภาษี ==============================================================*/
                            (
                                CASE  
                                    WHEN $tDataVatInOrEx = 1 THEN --รวมใน
                                        (
                                            (
                                                /* ยอดรวม */
                                                SUM(DTTMP.FCXtdNet)
                                                - 
                                                /* ยอดรวมสินค้าไม่มีภาษี */
                                                SUM(
                                                    CASE
                                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                        ELSE 0
                                                    END
                                                )
                                            )
                                            -
                                            (
                                                /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                                SUM(
                                                    CASE
                                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                        ELSE 0
                                                    END
                                                )
                                                -
                                                /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                                SUM(
                                                    CASE
                                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                        ELSE 0
                                                    END
                                                )
                                            )
                                            -
                                            SUM(ISNULL(DTTMP.FCXtdVat, 0))
                                        )
                                        +
                                        (
                                            (
                                                /* ยอดรวมสินค้าไม่มีภาษี */
                                                SUM(
                                                    CASE
                                                        WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                        ELSE 0
                                                    END
                                                )
                                            )
                                            -
                                            (
                                                /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                                SUM(
                                                    CASE
                                                        WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                        ELSE 0
                                                    END
                                                )
                                                -
                                                /* ยอดรวมหลังลด และไม่มีภาษี */
                                                SUM(
                                                    CASE
                                                        WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                        ELSE 0
                                                    END
                                                )
                                            )
                                        )
                                    WHEN $tDataVatInOrEx = 2 THEN --แยกนอก
                                    (
                                        (
                                            /* ยอดรวม */
                                            SUM(DTTMP.FCXtdNet)
                                            - 
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN 
                                                    ISNULL(DTTMP.FCXtdNetAfHD, 0) + ISNULL(DTTMP.FCXtdVat, 0) 
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        SUM(ISNULL(DTTMP.FCXtdVat, 0))
                                    )
                                    +
                                    (
                                        (
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอดรวมหลังลด และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                ELSE 0 END
                            ) AS FCXphVatable,

                            /* รหัสอัตราภาษี ณ ที่จ่าย ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXtdWhtCode
                                FROM TCNTDocDTTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode = '$tBchCode'
                                AND DOCCONCAT.FTXthDocNo = '$tDocNo'
                                AND DOCCONCAT.FTSessionID = '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXphWpCode,

                            /* ภาษีหัก ณ ที่จ่าย ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdWhtAmt, 0)) AS FCXphWpTax

                        FROM TCNTDocDTTmp DTTMP
                        WHERE DTTMP.FTXthDocNo  = '$tDocNo' 
                        AND DTTMP.FTXthDocKey   = '$tDocKey' 
                        AND DTTMP.FTSessionID   = '$tSessionID'
                        AND DTTMP.FTBchCode     = '$tBchCode'
                        GROUP BY DTTMP.FTSessionID ";

                        // echo $tSQL;
                        // die();
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->result_array();
        }else{
            $aResult    = [];
        }
        return $aResult;
    }

    
    // Functionality : Function Get Cal From HDDis Temp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMPOCalInHDDisTemp($paParams){
        $tDocNo     = $paParams['tDocNo'];
        $tDocKey    = $paParams['tDocKey'];
        $tBchCode   = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID']; 
        $tSQL       = " SELECT
                            /* ข้อความมูลค่าลดชาร์จ ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXtdDisChgTxt
                                FROM TCNTDocHDDisTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode 		= '$tBchCode'
                                AND DOCCONCAT.FTXthDocNo		= '$tDocNo'
                                AND DOCCONCAT.FTSessionID		= '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXphDisChgTxt,
                            /* มูลค่ารวมส่วนลด ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 1 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 2 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXphDis,
                            /* มูลค่ารวมส่วนชาร์จ ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 3 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 4 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXphChg
                        FROM TCNTDocHDDisTmp HDDISTMP
                        WHERE 1=1 
                        AND HDDISTMP.FTXthDocNo     = '$tDocNo' 
                        AND HDDISTMP.FTSessionID    = '$tSessionID'
                        AND HDDISTMP.FTBchCode      = '$tBchCode'
                        GROUP BY HDDISTMP.FTSessionID ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = [];
        }
        return $aResult;
    }
    
    // ============================================================================= Add/Edit Event Document =============================================================================

    // Functionality : Add/Update Data HD
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Add/Update Document HD
    // Return Type : array
    public function FSxMPOAddUpdateHD($paDataMaster,$paDataWhere,$paTableAddUpdate){
        // Get Data PI HD
        $aDataGetDataHD     =   $this->FSaMPOGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXphDocNo'],
            'FNLngID'       => $this->input->post("ohdPOLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            $aDataHDOld         = $aDataGetDataHD['raItems'];
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXphDocNo'    => $paDataWhere['FTXphDocNo'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
                'FDCreateOn'    => $aDataHDOld['FDCreateOn'],
                'FTCreateBy'    => $aDataHDOld['FTCreateBy']
            ));
        }else{
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXphDocNo'    => $paDataWhere['FTXphDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
        }
        // Delete PI HD
        $this->db->where_in('FTBchCode',$aDataAddUpdateHD['FTBchCode']);
        $this->db->where_in('FTXphDocNo',$aDataAddUpdateHD['FTXphDocNo']);
        $this->db->delete($paTableAddUpdate['tTableHD']);

        // Insert PI HD Dis
        $this->db->insert($paTableAddUpdate['tTableHD'],$aDataAddUpdateHD);

        return;
    }




    // Functionality : Add/Update Data HD Supplier
    // Parameters : Controller function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Add/Update Document Supplier
    // Return Type : array
    public function FSxMPOAddUpdateHDSpl($paDataHDSpl,$paDataWhere,$paTableAddUpdate){
        // Get Data PI HD
        $aDataGetDataSpl    =   $this->FSaMPOGetDataDocHDSpl(array(
            'FTXthDocNo'    => $paDataWhere['FTXphDocNo'],
            'FNLngID'       => $this->input->post("ohdPOLangEdit")
        ));
        $aDataAddUpdateHDSpl    = array();
        if(isset($aDataGetDataSpl['rtCode']) && $aDataGetDataSpl['rtCode'] == 1){
            $aDataHDSplOld  = $aDataGetDataSpl['raItems'];
            $aDataAddUpdateHDSpl    = array_merge($paDataHDSpl,array(
                'FTBchCode'     => $aDataHDSplOld['FTBchCode'],
                'FTXphDocNo'    => $aDataHDSplOld['FTXphDocNo'],
            ));
        }else{
            $aDataAddUpdateHDSpl    = array_merge($paDataHDSpl,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXphDocNo'    => $paDataWhere['FTXphDocNo'],
            ));
        }

        // Delete PI HD Spl
        $this->db->where_in('FTBchCode',$aDataAddUpdateHDSpl['FTBchCode']);
        $this->db->where_in('FTXphDocNo',$aDataAddUpdateHDSpl['FTXphDocNo']);
        $this->db->delete($paTableAddUpdate['tTableHDSpl']);

        // Insert PI HD Dis
        $this->db->insert($paTableAddUpdate['tTableHDSpl'],$aDataAddUpdateHDSpl);

        return;
    }

    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSxMPOAddUpdateDocNoToTemp($paDataWhere,$paTableAddUpdate){
        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableHD']);
        $this->db->update('TCNTDocDTTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXphDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into HDDisTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->update('TCNTDocHDDisTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXphDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into DTDisTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->update('TCNTDocDTDisTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXphDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));
        return;
    }

    // Functionality : Move Document HDDisTemp To Document HDDis
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Tempt To DT
    // Return Type : array
    public function FSaMPOMoveHdDisTempToHdDis($paDataWhere,$paTableAddUpdate){
        $tPODocNo       = $paDataWhere['FTXphDocNo'];
        $tPOBchCode     = $paDataWhere['FTBchCode'];
        $tPOSessionID   = $this->input->post('ohdSesSessionID');
        if(isset($tPODocNo) && !empty($tPODocNo)){
            $this->db->where_in('FTXphDocNo',$tPODocNo);
            $this->db->where_in('FTBchCode',$tPOBchCode);
            $this->db->delete($paTableAddUpdate['tTableHDDis']);
        }
        $tSQL   =   "   INSERT INTO ".$paTableAddUpdate['tTableHDDis']." (
                            FTBchCode,FTXphDocNo,FDXhdDateIns,FTXhdDisChgTxt,FTXhdDisChgType,
                            FCXhdTotalAfDisChg,FCXhdDisChg,FCXhdAmt )
                    ";
        $tSQL   .=  "   SELECT
                            HDDISTEMP.FTBchCode,
                            HDDISTEMP.FTXthDocNo,
                            HDDISTEMP.FDXtdDateIns,
                            HDDISTEMP.FTXtdDisChgTxt,
                            HDDISTEMP.FTXtdDisChgType,
                            HDDISTEMP.FCXtdTotalAfDisChg,
                            HDDISTEMP.FCXtdDisChg,
                            HDDISTEMP.FCXtdAmt
                        FROM TCNTDocHDDisTmp AS HDDISTEMP WITH (NOLOCK)
                        WHERE 1 = 1
                        AND HDDISTEMP.FTBchCode     = '$tPOBchCode'
                        AND HDDISTEMP.FTXthDocNo    = '$tPODocNo'
                        AND HDDISTEMP.FTSessionID   = '$tPOSessionID'
                    ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality : Move Document DTTemp To Document DT
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Tempt To DT
    // Return Type : array
    public function FSaMPOMoveDtTmpToDt($paDataWhere,$paTableAddUpdate){
        $tPOBchCode     = $paDataWhere['FTBchCode'];
        $tPODocNo       = $paDataWhere['FTXphDocNo'];
        $tPODocKey      = $paTableAddUpdate['tTableHD'];
        $tPOSessionID   = $this->input->post('ohdSesSessionID');
        
        if(isset($tPODocNo) && !empty($tPODocNo)){
            $this->db->where_in('FTXphDocNo',$tPODocNo);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO ".$paTableAddUpdate['tTableDT']." (
                        FTBchCode,FTXphDocNo,FNXpdSeqNo,FTPdtCode,FTXpdPdtName,FTPunCode,FTPunName,FCXpdFactor,FTXpdBarCode,FTXpdVatType,FTVatCode,FCXpdVatRate,
                        FTXpdSaleType,FCXpdSalePrice,FCXpdQty,FCXpdQtyAll,FCXpdSetPrice,FCXpdAmtB4DisChg,FTXpdDisChgTxt,FCXpdDis,FCXpdChg,FCXpdNet,FCXpdNetAfHD,
                        FCXpdVat,FCXpdVatable,FCXpdWhtAmt,FTXpdWhtCode,FCXpdWhtRate,FCXpdCostIn,FCXpdCostEx,FCXpdQtyLef,FCXpdQtyRfn,FTXpdStaPrcStk,FTXpdStaAlwDis,
                        FNXpdPdtLevel,FTXpdPdtParent,FCXpdQtySet,FTPdtStaSet,FTXpdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy ) ";
        $tSQL   .=  "   SELECT
                            DOCTMP.FTBchCode,
                            DOCTMP.FTXthDocNo,
                            ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTPunCode,
                            DOCTMP.FTPunName,
                            DOCTMP.FCXtdFactor,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FTXtdVatType,
                            DOCTMP.FTVatCode,
                            DOCTMP.FCXtdVatRate,
                            DOCTMP.FTXtdSaleType,
                            DOCTMP.FCXtdSalePrice,
                            DOCTMP.FCXtdQty,
                            DOCTMP.FCXtdQtyAll,
                            DOCTMP.FCXtdSetPrice,
                            DOCTMP.FCXtdAmtB4DisChg,
                            DOCTMP.FTXtdDisChgTxt,
                            DOCTMP.FCXtdDis,
                            DOCTMP.FCXtdChg,
                            DOCTMP.FCXtdNet,
                            DOCTMP.FCXtdNetAfHD,
                            DOCTMP.FCXtdVat,
                            DOCTMP.FCXtdVatable,
                            DOCTMP.FCXtdWhtAmt,
                            DOCTMP.FTXtdWhtCode,
                            DOCTMP.FCXtdWhtRate,
                            DOCTMP.FCXtdCostIn,
                            DOCTMP.FCXtdCostEx,
                            DOCTMP.FCXtdQtyLef,
                            DOCTMP.FCXtdQtyRfn,
                            DOCTMP.FTXtdStaPrcStk,
                            DOCTMP.FTXtdStaAlwDis,
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
                        AND DOCTMP.FTBchCode    = '$tPOBchCode'
                        AND DOCTMP.FTXthDocNo   = '$tPODocNo'
                        AND DOCTMP.FTXthDocKey  = '$tPODocKey'
                        AND DOCTMP.FTSessionID  = '$tPOSessionID'
                        ORDER BY DOCTMP.FNXtdSeqNo ASC
        ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality : Move Document DTDisTemp To Document DTDis
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Tempt To DT
    // Return Type : array
    public function FSaMPOMoveDtDisTempToDtDis($paDataWhere,$paTableAddUpdate){
        $tPOBchCode     = $paDataWhere['FTBchCode'];
        $tPODocNo       = $paDataWhere['FTXphDocNo'];
        $tPOSessionID   = $this->input->post('ohdSesSessionID');
        
        if(isset($tPODocNo) && !empty($tPODocNo)){
            $this->db->where_in('FTXphDocNo',$tPODocNo);
            $this->db->where_in('FTBchCode',$tPOBchCode);
            $this->db->delete($paTableAddUpdate['tTableDTDis']);
        }

        $tSQL   =   "   INSERT INTO ".$paTableAddUpdate['tTableDTDis']." (FTBchCode,FTXphDocNo,FNXpdSeqNo,FDXpdDateIns,FNXpdStaDis,FTXpdDisChgTxt,FTXpdDisChgType,FCXpdNet,FCXpdValue) ";
        $tSQL   .=  "   SELECT
                            DOCDISTMP.FTBchCode,
                            DOCDISTMP.FTXthDocNo,
                            DOCDISTMP.FNXtdSeqNo,
                            DOCDISTMP.FDXtdDateIns,
                            DOCDISTMP.FNXtdStaDis,
                            DOCDISTMP.FTXtdDisChgTxt,
                            DOCDISTMP.FTXtdDisChgType,
                            DOCDISTMP.FCXtdNet,
                            DOCDISTMP.FCXtdValue
                        FROM TCNTDocDTDisTmp DOCDISTMP WITH (NOLOCK)
                        WHERE 1=1
                        AND DOCDISTMP.FTBchCode     = '$tPOBchCode'
                        AND DOCDISTMP.FTXthDocNo    = '$tPODocNo'
                        AND DOCDISTMP.FTSessionID   = '$tPOSessionID' 
                        ORDER BY DOCDISTMP.FNXtdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // ============================================================================ Edit Page Query ============================================================================

    // Functionality : Get Data Document HD
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Document HD
    // Return Type : array
    public function FSaMPOGetDataDocHD($paDataWhere){
        $tPODocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID     = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            DOCHD.FTBchCode,
                            BCHL.FTBchName,
                            SHP.FTMerCode,
                            MERL.FTMerName,
                            SHP.FTShpType,
                            SHP.FTShpCode,
                            SHPL.FTShpName,
                            DOCHD.FTWahCode,
                            WAHL.FTWahName,
                            DOCHD.FTXphDocNo,
                            DOCHD.FNXphDocType,
                            DOCHD.FDXphDocDate,
                            DOCHD.FTXphCshOrCrd,
                            DOCHD.FTXphVATInOrEx,
                            DOCHD.FTDptCode,
                            DPTL.FTDptName,
                            DOCHD.FTUsrCode,
                            USRL.FTUsrName,
                            DOCHD.FTXphApvCode,
                            USRAPV.FTUsrName	AS FTXphApvName,
                            DOCHD.FTSplCode,
                            SPLL.FTSplName,
                            DOCHD.FTXphRefExt,
                            DOCHD.FDXphRefExtDate,
                            DOCHD.FTXphRefInt,
                            DOCHD.FDXphRefIntDate,
                            DOCHD.FTXphRefAE,
                            DOCHD.FNXphDocPrint,
                            DOCHD.FTRteCode,
                            DOCHD.FCXphRteFac,
                            DOCHD.FTXphRmk,
                            DOCHD.FTXphStaRefund,
                            DOCHD.FTXphStaDoc,
                            DOCHD.FTXphStaApv,
                            DOCHD.FTXphStaPaid,
                            DOCHD.FNXphStaDocAct,
                            DOCHD.FNXphStaRef,
                            DOCHD.FDLastUpdOn,
                            DOCHD.FTLastUpdBy,
                            DOCHD.FDCreateOn,
                            DOCHD.FTCreateBy
                            
                        FROM TAPTPoHD DOCHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK)   ON DOCHD.FTBchCode      = BCHL.FTBchCode    AND BCHL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMShop          SHP     WITH (NOLOCK)   ON DOCHD.FTShpCode      = SHP.FTShpCode     AND BCHL.FTBchCode = 	SHP.FTBchCode  
                        LEFT JOIN TCNMShop_L        SHPL    WITH (NOLOCK)   ON DOCHD.FTShpCode      = SHPL.FTShpCode	AND BCHL.FTBchCode = 	SHPL.FTBchCode   AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK)   ON SHP.FTMerCode        = MERL.FTMerCode	AND MERL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAHL    WITH (NOLOCK)   ON DOCHD.FTWahCode      = WAHL.FTWahCode    AND BCHL.FTBchCode = 	WAHL.FTBchCode AND WAHL.FNLngID = $nLngID
                        LEFT JOIN TCNMUsrDepart_L	DPTL    WITH (NOLOCK)   ON DOCHD.FTDptCode      = DPTL.FTDptCode	AND DPTL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK)   ON DOCHD.FTUsrCode      = USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK)   ON DOCHD.FTXphApvCode	= USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMSpl_L         SPLL    WITH (NOLOCK)   ON DOCHD.FTSplCode		= SPLL.FTSplCode	AND SPLL.FNLngID	= $nLngID
                        WHERE 1=1 AND DOCHD.FTXphDocNo = '$tPODocNo' ";
                        
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
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
    }

    // Functionality : Get Data Document HD Spl
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Document HD Ref
    // Return Type : array
    public function FSaMPOGetDataDocHDSpl($paDataWhere){
        $tPODocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID     = $paDataWhere['FNLngID'];
        $tSQL       = " SELECT
                            HDSPL.FTBchCode,
                            HDSPL.FTXphDocNo,
                            HDSPL.FTXphDstPaid,
                            HDSPL.FNXphCrTerm,
                            HDSPL.FDXphDueDate,
                            HDSPL.FDXphBillDue,
                            HDSPL.FTXphCtrName,
                            HDSPL.FDXphTnfDate,
                            HDSPL.FTXphRefTnfID,
                            HDSPL.FTXphRefVehID,
                            HDSPL.FTXphRefInvNo,
                            HDSPL.FTXphQtyAndTypeUnit,
                            HDSPL.FNXphShipAdd,
                            SHIP_Add.FTAddV1No              AS FTXphShipAddNo,
                            SHIP_Add.FTAddV1Soi				AS FTXphShipAddPoi,
                            SHIP_Add.FTAddV1Village         AS FTXphShipAddVillage,
                            SHIP_Add.FTAddV1Road			AS FTXphShipAddRoad,
                            SHIP_SUDIS.FTSudName			AS FTXphShipSubDistrict,
                            SHIP_DIS.FTDstName				AS FTXphShipDistrict,
                            SHIP_PVN.FTPvnName				AS FTXphShipProvince,
                            SHIP_Add.FTAddV1PostCode	    AS FTXphShipPosCode,
                            HDSPL.FNXphTaxAdd,
                            TAX_Add.FTAddV1No               AS FTXphTaxAddNo,
                            TAX_Add.FTAddV1Soi				AS FTXphTaxAddPoi,
                            TAX_Add.FTAddV1Village		    AS FTXphTaxAddVillage,
                            TAX_Add.FTAddV1Road				AS FTXphTaxAddRoad,
                            TAX_SUDIS.FTSudName				AS FTXphTaxSubDistrict,
                            TAX_DIS.FTDstName               AS FTXphTaxDistrict,
                            TAX_PVN.FTPvnName               AS FTXphTaxProvince,
                            TAX_Add.FTAddV1PostCode		    AS FTXphTaxPosCode
                        FROM TAPTPoHDSpl HDSPL  WITH (NOLOCK)
                        LEFT JOIN TCNMAddress_L			SHIP_Add    WITH (NOLOCK)   ON HDSPL.FNXphShipAdd       = SHIP_Add.FNAddSeqNo	AND SHIP_Add.FNLngID    = $nLngID
                        LEFT JOIN TCNMSubDistrict_L     SHIP_SUDIS 	WITH (NOLOCK)	ON SHIP_Add.FTAddV1SubDist	= SHIP_SUDIS.FTSudCode	AND SHIP_SUDIS.FNLngID  = $nLngID
                        LEFT JOIN TCNMDistrict_L        SHIP_DIS    WITH (NOLOCK)	ON SHIP_Add.FTAddV1DstCode	= SHIP_DIS.FTDstCode    AND SHIP_DIS.FNLngID    = $nLngID
                        LEFT JOIN TCNMProvince_L        SHIP_PVN    WITH (NOLOCK)	ON SHIP_Add.FTAddV1PvnCode	= SHIP_PVN.FTPvnCode    AND SHIP_PVN.FNLngID    = $nLngID
                        LEFT JOIN TCNMAddress_L			TAX_Add     WITH (NOLOCK)   ON HDSPL.FNXphTaxAdd        = TAX_Add.FNAddSeqNo	AND TAX_Add.FNLngID		= $nLngID
                        LEFT JOIN TCNMSubDistrict_L     TAX_SUDIS 	WITH (NOLOCK)	ON TAX_Add.FTAddV1SubDist   = TAX_SUDIS.FTSudCode	AND TAX_SUDIS.FNLngID	= $nLngID
                        LEFT JOIN TCNMDistrict_L        TAX_DIS     WITH (NOLOCK)	ON TAX_Add.FTAddV1DstCode   = TAX_DIS.FTDstCode     AND TAX_DIS.FNLngID     = $nLngID
                        LEFT JOIN TCNMProvince_L        TAX_PVN     WITH (NOLOCK)	ON TAX_Add.FTAddV1PvnCode   = TAX_PVN.FTPvnCode		AND TAX_PVN.FNLngID     = $nLngID
                        WHERE 1=1 AND HDSPL.FTXphDocNo = '$tPODocNo'
        ";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
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

    }

    // Functionality : Move Data HD Dis To Temp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    public function FSxMPOMoveHDDisToTemp($paDataWhere){
        $tPODocNo       = $paDataWhere['FTXthDocNo'];
        // Delect Document HD DisTemp By Doc No
        $this->db->where('FTXthDocNo',$tPODocNo);
        $this->db->delete('TCNTDocHDDisTmp');

        // echo $this->db->last_query();
        // die();
        
        $tSQL       = " INSERT INTO TCNTDocHDDisTmp (
                            FTBchCode,
                            FTXthDocNo,
                            FDXtdDateIns,
                            FTXtdDisChgTxt,
                            FTXtdDisChgType,
                            FCXtdTotalAfDisChg,
                            FCXtdTotalB4DisChg,
                            FCXtdDisChg,
                            FCXtdAmt,
                            FTSessionID,
                            FDLastUpdOn,
                            FDCreateOn,
                            FTLastUpdBy,
                            FTCreateBy
                        )
                        SELECT 
                            POHDDis.FTBchCode,
                            POHDDis.FTXphDocNo,
                            POHDDis.FDXhdDateIns,
                            POHDDis.FTXhdDisChgTxt,
                            POHDDis.FTXhdDisChgType,
                            POHDDis.FCXhdTotalAfDisChg,
                            (ISNULL(NULL,0)) AS FCXtdTotalB4DisChg,
                            POHDDis.FCXhdDisChg,
                            POHDDis.FCXhdAmt,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."')    AS FTSessionID,
                            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                        FROM TAPTPoHDDis POHDDis WITH (NOLOCK)
                        WHERE 1=1 AND POHDDis.FTXphDocNo = '$tPODocNo'
        ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality : Move Data DT To DTTemp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    public function FSxMPOMoveDTToDTTemp($paDataWhere){
        $tPODocNo       = $paDataWhere['FTXthDocNo'];
        $tPODocKey      = $paDataWhere['FTXthDocKey'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocNo',$tPODocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL   = " INSERT INTO TCNTDocDTTmp (
                        FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
                        FTXtdVatType,FTVatCode,FCXtdVatRate,FTXtdSaleType,FCXtdSalePrice,FCXtdQty,FCXtdQtyAll,FCXtdSetPrice,
                        FCXtdAmtB4DisChg,FTXtdDisChgTxt,FCXtdDis,FCXtdChg,FCXtdNet,FCXtdNetAfHD,FCXtdVat,FCXtdVatable,FCXtdWhtAmt,
                        FTXtdWhtCode,FCXtdWhtRate,FCXtdCostIn,FCXtdCostEx,FCXtdQtyLef,FCXtdQtyRfn,FTXtdStaPrcStk,FTXtdStaAlwDis,
                        FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,FTXtdPdtStaSet,FTXtdRmk,
                        FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy )
                    SELECT
                        PODT.FTBchCode,
                        PODT.FTXphDocNo,
                        PODT.FNXpdSeqNo,
                        CONVERT(VARCHAR,'".$tPODocKey."') AS FTXthDocKey,
                        PODT.FTPdtCode,
                        PODT.FTXpdPdtName,
                        PODT.FTPunCode,
                        PODT.FTPunName,
                        PODT.FCXpdFactor,
                        PODT.FTXpdBarCode,
                        PODT.FTXpdVatType,
                        PODT.FTVatCode,
                        PODT.FCXpdVatRate,
                        PODT.FTXpdSaleType,
                        PODT.FCXpdSalePrice,
                        PODT.FCXpdQty,
                        PODT.FCXpdQtyAll,
                        PODT.FCXpdSetPrice,
                        PODT.FCXpdAmtB4DisChg,
                        PODT.FTXpdDisChgTxt,
                        PODT.FCXpdDis,
                        PODT.FCXpdChg,
                        PODT.FCXpdNet,
                        PODT.FCXpdNetAfHD,
                        PODT.FCXpdVat,
                        PODT.FCXpdVatable,
                        PODT.FCXpdWhtAmt,
                        PODT.FTXpdWhtCode,
                        PODT.FCXpdWhtRate,
                        PODT.FCXpdCostIn,
                        PODT.FCXpdCostEx,
                        PODT.FCXpdQtyLef,
                        PODT.FCXpdQtyRfn,
                        PODT.FTXpdStaPrcStk,
                        PODT.FTXpdStaAlwDis,
                        PODT.FNXpdPdtLevel,
                        PODT.FTXpdPdtParent,
                        PODT.FCXpdQtySet,
                        PODT.FTPdtStaSet,
                        PODT.FTXpdRmk,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                    FROM TAPTPoDT AS PODT WITH (NOLOCK)
                    WHERE 1=1 AND PODT.FTXphDocNo = '$tPODocNo'
                    ORDER BY PODT.FNXpdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        return;
    }


    // Functionality : Move Data DT Dis To DT Dis Temp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    public function FSxMPOMoveDTDisToDTDisTemp($paDataWhere){
        $tPODocNo       = $paDataWhere['FTXthDocNo'];
        
        // Delect Document DTDisTemp By Doc No
        $this->db->where('FTXthDocNo',$tPODocNo);
        $this->db->delete('TCNTDocDTDisTmp');

        $tSQL   = " INSERT INTO TCNTDocDTDisTmp (
                        FTBchCode,
                        FTXthDocNo,
                        FNXtdSeqNo,
                        FTSessionID,
                        FDXtdDateIns,
                        FNXtdStaDis,
                        FTXtdDisChgType,
                        FCXtdNet,
                        FCXtdValue,
                        FDLastUpdOn,
                        FDCreateOn,
                        FTLastUpdBy,
                        FTCreateBy,
                        FTXtdDisChgTxt
                    )
                    SELECT
                        PODTDis.FTBchCode,
                        PODTDis.FTXphDocNo,
                        PODTDis.FNXpdSeqNo,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."')    AS FTSessionID,
                        PODTDis.FDXpdDateIns,
                        PODTDis.FNXpdStaDis,
                        PODTDis.FTXpdDisChgType,
                        PODTDis.FCXpdNet,
                        PODTDis.FCXpdValue,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy,
                        PODTDis.FTXpdDisChgTxt
                    FROM TAPTPoDTDis PODTDis
                    WHERE 1=1 AND PODTDis.FTXphDocNo = '$tPODocNo'
                    ORDER BY PODTDis.FNXpdSeqNo ASC
            ";
        $oQuery = $this->db->query($tSQL);
        return;
    }
    
    // ============================================================================ Edit Page Query ============================================================================

    // Functionality : Cancel Document Data
    // Parameters : function parameters
    // Creator : 09/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    public function FSaMPOCancelDocument($paDataUpdate){
        // TAPTPoHD
        $this->db->trans_begin();
        $this->db->set('FTXphStaDoc' , '3');
        $this->db->where('FTXphDocNo', $paDataUpdate['tDocNo']);
        $this->db->update('TAPTPoHD');

        $this->db->where('FTDatRefCode',$paDataUpdate['tDocNo'])->delete('TARTDocApvTxn');

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aDatRetrun = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Error Cannot Update Status Cancel Document."
            );
        }else{
            $this->db->trans_commit();
            $aDatRetrun = array(
                'nStaEvent' => '1',
                'tStaMessg' => "Update Status Document Cancel Success."
            );
        }
        return $aDatRetrun;
    }

    // Functionality : Approve Document Data
    // Parameters : function parameters
    // Creator : 09/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    public function FSaMPOApproveDocument($paDataUpdate){
        // TAPTPoHD
        $this->db->trans_begin();
        $dLastUpdOn = date('Y-m-d H:i:s');
        $tLastUpdBy = $this->session->userdata('tSesUsername');


        $this->db->set('FDLastUpdOn',$dLastUpdOn);
        $this->db->set('FTLastUpdBy',$tLastUpdBy);
        // $this->db->set('FTXpdStaPrcStk',2);
        $this->db->set('FTXphStaApv',$paDataUpdate['nStaApv']);
        $this->db->set('FTXphApvCode',$paDataUpdate['tApvCode']);
        $this->db->where('FTXphDocNo',$paDataUpdate['tDocNo']);


        $this->db->update('TAPTPoHD');
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aDatRetrun = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Error Cannot Update Status Approve Document."
            );
        }else{
            $this->db->trans_commit();
            $aDatRetrun = array(
                'nStaEvent' => '1',
                'tStaMessg' => "Update Status Document Approve Success."
            );
        }
        return $aDatRetrun;
    }

    // ================================================================== Search And Add Product In DT Temp ====================================================================

    // Functionality : Count Product Bar
    // Parameters : function parameters
    // Creator : 30/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Find Product
    // Return Type : Array
    public function FSaCPICountPdtBarInTablePdtBar($paDataChkINDB){
        $tPODataSearchAndAdd    = $paDataChkINDB['tPODataSearchAndAdd'];
        $nLangEdit              = $paDataChkINDB['nLangEdit'];

        $tSQL   = " SELECT 
                        PDTBAR.FTPdtCode,
                        PDT_L.FTPdtName,
                        PDTBAR.FTBarCode,
                        PDTBAR.FTPunCode,
                        PUN_L.FTPunName
                    FROM TCNMPdtBar         PDTBAR  WITH(NOLOCK)
                    LEFT JOIN TCNMPdt		PDT     WITH(NOLOCK)	ON PDTBAR.FTPdtCode = PDT.FTPdtCode
                    LEFT JOIN TCNMPdt_L	    PDT_L   WITH(NOLOCK)	ON PDT.FTPdtCode	= PDT_L.FTPdtCode   AND PDT_L.FNLngID   = $nLangEdit
                    LEFT JOIN TCNMPdtUnit   PUN     WITH(NOLOCK)	ON PDTBAR.FTPunCode	= PUN.FTPunCode
                    LEFT JOIN TCNMPdtUnit_L	PUN_L   WITH(NOLOCK)	ON PUN.FTPunCode    = PUN_L.FTPunCode   AND PUN_L.FNLngID   = $nLangEdit
                    WHERE 1=1
                    AND PDTBAR.FTBarStaUse 	= 1
                    AND (PDTBAR.FTPdtCode = '$tPODataSearchAndAdd' OR PDTBAR.FTBarCode = '$tPODataSearchAndAdd')
        ";
        $oQuery         = $this->db->query($tSQL);
        $aDataReturn    = $oQuery->result_array();
        unset($oQuery);
        return $aDataReturn;
    }





    // Function: Check Approve Document And Load Format User Aprove From Roles To Trns
    // Parameters: tTableDocHD tApvCode tDocNo tBchCodes
    // Creator: 22/01/2020 Nattakit(Nale)
    // LastUpdate: -
    // Return: tReturnCode = 200 (success), tReturnMsg  (Dexcription)
    // ReturnType: Array
    public function FSnMPOCheckLevelApr($paData){

        $tTableDocHD = $paData['tTableDocHD'];
        $tCreateBy   = $paData['tApvCode'];
        $tDocNo      = $paData['tDocNo'];
        $tBchCode    = $paData['tBchCode'];
        $dDocDate    = date('Y-m-d H:i:s');

        if(!empty($tTableDocHD)){

            $tSqlDocApr = "   SELECT
                            dbo.TCNMDocApvRole.FNDarApvSeq,
                            dbo.TCNMDocApvRole.FTDarUsrRole,
                            dbo.TCNMDocApvRole.FTDarRefType,
                            dbo.TSysDocApv.FTDapName,
                            dbo.TSysDocApv.FTDapNameOth
                        FROM
                            dbo.TCNMDocApvRole
                        INNER JOIN dbo.TSysDocApv ON dbo.TCNMDocApvRole.FNDarApvSeq = dbo.TSysDocApv.FNDapSeq
                        AND dbo.TCNMDocApvRole.FTDarTable = dbo.TSysDocApv.FTDapTable
                        WHERE
                            dbo.TCNMDocApvRole.FTDarTable = '$tTableDocHD'
                    ";

                   $oQuery = $this->db->query($tSqlDocApr);
                   $nNumrows = $oQuery->num_rows();

                if($nNumrows>0){

                    $aDataParam=array(
                        'tTableDocHD' => $tTableDocHD,
                        'tCreateBy'   => $tCreateBy,
                        'tDocNo'      => $tDocNo ,
                        'dDocDate'    => $dDocDate,
                        'tBchCode'    => $tBchCode
                    );

                    if(!empty($aDataParam)){

                      $aResult =  $this->FSnMPODMoveRoleToTrns($aDataParam);

                      if($aResult==1){

                        $aReturn['tReturnCode'] = '200';
                        $aReturn['tReturnMsg'] = 'Success Function Insert Level Apr';
                        return $aReturn;

                      }else{

                        $aReturn['tReturnCode'] = '500';
                        $aReturn['tReturnMsg'] = 'This function error!';
                        return $aReturn;

                      }

                    }else{

                        $aReturn['tReturnCode'] = '202';
                        $aReturn['tReturnMsg'] = 'Doc Approve Only User';
                        return $aReturn;

                    }

                }else{
                    $aReturn['tReturnCode'] = '202';
                    $aReturn['tReturnMsg'] = 'Doc Approve Only User';
                    return $aReturn;
                }

        }else{

            $aReturn['tReturnCode'] = '404';
            $aReturn['tReturnMsg'] = 'Table Is Empty !';
            return $aReturn;
        }
    }


    // Function: Clone From table Role To Trns For Document.
    // Parameters: tTableDocHD tApvCode tDocNo dDocDate tBchCodes
    // Creator: 22/01/2020 Nattakit(Nale)
    // LastUpdate: -
    // Return: 1,2
    // ReturnType: number

    public function FSnMPODMoveRoleToTrns($paDataInsert){
        
        $tTableDocHD = $paDataInsert['tTableDocHD'];
        $tCreateBy   = $paDataInsert['tCreateBy'];
        $tDocNo      = $paDataInsert['tDocNo'];
        $dDocDate    = $paDataInsert['dDocDate'];
        $tBchCode    = $paDataInsert['tBchCode'];

         $nCountrow = $this->FSnMPONumRowTnxTable($paDataInsert);
        
        if($nCountrow<0){
        $tSql ="
                INSERT INTO TARTDocApvTxn (
                    FTBchCode,
                    FTDatRefCode,
                    FTDatRefType,
                    FNDatApvSeq,
                    FDCreateOn,
                    FTCreateBy
                ) SELECT
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTDatRefCode,
                    dbo.TCNMDocApvRole.FTDarRefType,
                    dbo.TCNMDocApvRole.FNDarApvSeq,
                    GETDATE() AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy
                FROM
                    dbo.TCNMDocApvRole
                WHERE
                    dbo.TCNMDocApvRole.FTDarTable = '$tTableDocHD'
        ";

        $oQuery = $this->db->query($tSql);
        
        if($oQuery){
            $nReustl = 1;
        }else{
            $nReustl = 2;
        }
    }else{
        $nReustl = 1;
    }
        return $nReustl;

    }


    public function FSnMPONumRowTnxTable($paDataInsert){

        $tTableDocHD = $paDataInsert['tTableDocHD'];
        $tCreateBy   = $paDataInsert['tCreateBy'];
        $tDocNo      = $paDataInsert['tDocNo'];
        $dDocDate    = $paDataInsert['dDocDate'];
        $tBchCode    = $paDataInsert['tBchCode'];

        $tSqlCount = "
            SELECT COUNT(*) AS nNums FROM [dbo].[TARTDocApvTxn]
             WHERE FTBchCode='$tBchCode'
             AND FTDatRefCode = '$tDocNo';
              ";
       
       $oQuery = $this->db->query($tSqlCount);
      $aRes = $oQuery->row_array();
       return $aRes['nNums'];

    }

    public function FSnMPOUpdateTableMutiAprve($paData){

        $tRoleCode   = $paData['tRoleCode'];
        $tDatRefCode = $paData['FTDatRefCode'];
        $tBchCode    = $paData['FTBchCode'];
        $tTableDocHD    = $paData['tTableDocHD'];
        
            $tSql="
                        SELECT
                            TOP 1
                            dbo.TARTDocApvTxn.FNDatApvSeq,
                            dbo.TARTDocApvTxn.FTDatRefType,
                            dbo.TARTDocApvTxn.FTDatRefCode,
                            dbo.TARTDocApvTxn.FTBchCode,
                            dbo.TARTDocApvTxn.FTDatUsrApv,
                            dbo.TARTDocApvTxn.FDDatDateApv,
                            dbo.TCNMDocApvRole.FTDarTable,
                            dbo.TCNMDocApvRole.FTDarUsrRole,
                            dbo.TCNMDocApvRole.FNDarApvSeq
                        FROM
                        dbo.TARTDocApvTxn
                        INNER JOIN dbo.TCNMDocApvRole ON dbo.TARTDocApvTxn.FNDatApvSeq = dbo.TCNMDocApvRole.FNDarApvSeq AND dbo.TCNMDocApvRole.FTDarTable='$tTableDocHD'
                        WHERE
                            dbo.TARTDocApvTxn.FTBchCode='$tBchCode'
                            AND dbo.TARTDocApvTxn.FTDatRefCode='$tDatRefCode'
                            AND dbo.TARTDocApvTxn.FDDatDateApv IS NULL
                            AND dbo.TARTDocApvTxn.FTDatUsrApv IS NULL
            ";

            $oQuery = $this->db->query($tSql);
            $aTnx = $oQuery->row_array();

            if(!empty($aTnx)){

                if($aTnx['FTDarUsrRole']=='' || $aTnx['FTDarUsrRole']==$tRoleCode){
                    $aResult =  array(
                                        'nReturnCode' => 1 ,
                                        'FNDatApvSeq' => $aTnx['FNDatApvSeq']
                                        );
                }else{
                    $aResult = array(
                        'nReturnCode' => 2,
                        'FNDatApvSeq' => ''
                        );
                }

            }else{
                $aResult = array(
                    'nReturnCode' => 2 ,
                    'FNDatApvSeq' => ''
                    );
            }

            return $aResult;


    }

    public function FSnMPOAInsertForMultiAprve($paData){
            // TAPTPoHD

        $nCheckPerAprv = $this->FSnMPOUpdateTableMutiAprve($paData);//ตรวจสอบลำดับที่จะอนุมัติ
        // echo '<pre>';
        //     print_r($nCheckPerAprv);
        // echo '</pre>';
        // die();
        if($nCheckPerAprv['nReturnCode']==1){

            $this->db->trans_begin();
            $tRoleCode = $paData['tRoleCode'];
            $tDatRefCode = $paData['FTDatRefCode'];
            $tBchCode = $paData['FTBchCode'];
            $nDatApvSeq = $nCheckPerAprv['FNDatApvSeq'];

            $dLastUpdOn = date('Y-m-d H:i:s');
            $tLastUpdBy = $this->session->userdata('tSesUsername');
            $tDatUsrApv = $paData['FTDatUsrApv'];
            $dDatDateApv = $paData['FDDatDateApv'];
            $tDatRmk = $paData['FTDatRmk'];

            $this->db->set('FDLastUpdOn',$dLastUpdOn);
            $this->db->set('FTLastUpdBy',$tLastUpdBy);
            $this->db->set('FTDatUsrApv',$tDatUsrApv);
            $this->db->set('FDDatDateApv',$dDatDateApv);
            $this->db->set('FTDatRmk',$tDatRmk);
            $this->db->where('FTDatRefCode',$tDatRefCode);
            $this->db->where('FTBchCode',$tBchCode);
            $this->db->where('FNDatApvSeq',$nDatApvSeq);

            $this->db->update('TARTDocApvTxn');

            // echo '<pre>';
            // print_r($nCheckPerAprv);
            // echo '</pre>';
            // echo $this->db->last_query();
            // die();
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aDatRetrun = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Cannot Update Status Approve Document."
                );
            }else{
                $this->db->trans_commit();
                $aDatRetrun = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Update Status Document Approve Success."
                );
            }

        }else{
            $aDatRetrun = array(
                'nStaEvent' => '990',
                'tStaMessg' => "You don't have permission to approve document."
            );
        }
            return $aDatRetrun;
        


    }




    public function FSnMPOGetDocType(){

        $tSql = "
        SELECT
            TSysDocType.FNSdtDocType
            FROM [dbo].[TSysDocType]
            WHERE 
            TSysDocType.FTSdtTblName='TAPTPoHD'
        ";
        $oQuery = $this->db->query($tSql);
        return $oQuery->row_array();
    }


    public function FSaMPOUpdateStrPrcLastUpdate($paData){
        $this->db->trans_begin();
        $this->db->set('FTDatStaPrc',2);
        $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
        $this->db->where('FTDatRefCode',$paData['FTDatRefCode']);
        $this->db->where('FTBchCode',$paData['tBchCode']);
        $this->db->where('FNDatApvSeq',$paData['FNDatApvSeq']);
        $this->db->update('TARTDocApvTxn');

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aDatRetrun = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Error Cannot Update Status Document."
            );
        }else{
            $this->db->trans_commit();
            $aDatRetrun = array(
                'nStaEvent' => '1',
                'tStaMessg' => "Update Status Document Success."
            );
        
        }
        return $aDatRetrun;
    }



    public function FSnMPOCheckStrPrcLastUpdate($paData){
        $FTDatRefCode = $paData['FTDatRefCode'];
        $tBchCode = $paData['tBchCode'];
        $FNDatApvSeq = $paData['FNDatApvSeq'];
        $dDataNow = date('Y-m-d H:i:s');
            $tSql = " SELECT
            count(*) AS StrCheck
            FROM
                TARTDocApvTxn TXN
                LEFT OUTER JOIN TSysConfig TCF ON TCF.FTSysCode='tVD_DocApprove'
            WHERE
                TXN.FTDatRefCode = '$FTDatRefCode'
            AND TXN.FTBchCode = '$tBchCode'
            AND TXN.FNDatApvSeq = '$FNDatApvSeq'
            AND ( 
                ( TXN.FTDatStaPrc IS NULL AND TXN.FTDatUsrApv IS NULL ) 
                OR 
                ( TXN.FTDatStaPrc = 2 AND DATEADD(MINUTE,CONVERT(INT,TCF.FTSysStaUsrValue),TXN.FDLastUpdOn) <= '$dDataNow' )
            )
                    ";
            $oQuery = $this->db->query($tSql);
            $reustl =  $oQuery->row_array();

            return  $reustl['StrCheck'];
    }


    public function FSnMPOGetTimeCountDown($paData){

        $FTDatRefCode = $paData['FTDatRefCode'];
        $tBchCode = $paData['tBchCode'];
        $FNDatApvSeq = $paData['FNDatApvSeq'];
        $dDataNow = date('Y-m-d H:i:s');
        $tSql = " SELECT
                    TCF.FTSysStaUsrValue,
                    TXN.FDLastUpdOn,
                    DATEADD(MINUTE,CONVERT(INT,TCF.FTSysStaUsrValue),TXN.FDLastUpdOn) AS rDateExp,
                    GETDATE() AS dateget,
                    DATEDIFF(SECOND,'$dDataNow',DATEADD(MINUTE,CONVERT(INT,TCF.FTSysStaUsrValue),TXN.FDLastUpdOn)) AS rSecondTime
                    FROM
                        TARTDocApvTxn TXN
                        LEFT OUTER JOIN TSysConfig TCF ON TCF.FTSysCode='tVD_DocApprove'
                    WHERE
                        TXN.FTDatRefCode = '$FTDatRefCode'
                    AND TXN.FTBchCode = '$tBchCode'
                    AND TXN.FNDatApvSeq = '$FNDatApvSeq'
                ";

                
        $oQuery = $this->db->query($tSql);
        $aReustl =  $oQuery->row_array();
    
        return  $aReustl['rSecondTime'];


    }


    public function FSaMPOGetDetailUserBranch($paBchCode){
        if(!empty($paBchCode)){
        $aReustl = $this->db->where('FTBchCode',$paBchCode)->get('TCNMBranch')->row_array();
        //   $oQuery = $this->db->query($oSql);
        //   $aReustl =  $oQuery->row_array();
        $aReulst['item'] = $aReustl;
        $aReulst['code'] = 1;
        $aReulst['msg'] = 'Success !';
        }else{
        $aReulst['code'] = 2;
        $aReulst['msg'] = 'Error !';
        }
    return $aReulst;
    }

    public function FScMPOGetPrice4Pdt($paData){
        $tPOPplCodeBch = $paData['tPOPplCodeBch'];
        $tPOPplCodeCst = $paData['tPOPplCodeCst'];
        $tPOPdtCode    = $paData['tPOPdtCode'];
        $tPOPunCode    = $paData['tPOPunCode'];
        
    }

public function FSaMPOGetPrice4Pdt($paData,$pNPrice){
    $tPOPplCodeBch = $paData['tPOPplCodeBch'];
    $tPOPplCodeCst = $paData['tPOPplCodeCst'];
    $tPOPdtCode    = $paData['tPOPdtCode'];
    $tPOPunCode    = $paData['tPOPunCode'];
    if($pNPrice==1){
        $tConditionPOPplCode=" AND TCNTPdtPrice4PDT.FTPplCode='$tPOPplCodeCst' ";
    }else if($pNPrice==2){
        $tConditionPOPplCode=" AND TCNTPdtPrice4PDT.FTPplCode='$tPOPplCodeBch' ";
    }else if($pNPrice==3){
        $tConditionPOPplCode =" AND ( TCNTPdtPrice4PDT.FTPplCode IS NULL OR  TCNTPdtPrice4PDT.FTPplCode ='' ) ";
    }
    $dDate = date('Y-m-d');
    $tTime = date('H:i:s');
    $tSql ="SELECT
            TCNTPdtPrice4PDT.FTPplCode,
            TCNTPdtPrice4PDT.FTPdtCode,
            TCNTPdtPrice4PDT.FTPunCode,
            TCNTPdtPrice4PDT.FDPghDStart,
            TCNTPdtPrice4PDT.FTPghTStart,
            TCNTPdtPrice4PDT.FDPghDStop,
            TCNTPdtPrice4PDT.FTPghTStop,
            TCNTPdtPrice4PDT.FCPgdPriceRet,
            TCNTPdtPrice4PDT.FCPgdPriceNet,
            TCNTPdtPrice4PDT.FCPgdPriceWhs
            FROM
            TCNTPdtPrice4PDT
            WHERE 1=1
            $tConditionPOPplCode
            AND TCNTPdtPrice4PDT.FTPdtCode='$tPOPdtCode'
            AND TCNTPdtPrice4PDT.FTPunCode='$tPOPunCode'
            AND TCNTPdtPrice4PDT.FDPghDStart<='$dDate' AND TCNTPdtPrice4PDT.FTPghTStart<='$tTime'
            AND TCNTPdtPrice4PDT.FDPghDStop>='$dDate' AND TCNTPdtPrice4PDT.FTPghTStop>='$tTime'
";

   $oQuery =  $this->db->query($tSql);
   $nRows = $oQuery->num_rows();
   if($nRows>0){
      $aDataPrice  = $oQuery->row_array();  
      $aResult['code'] = 1; 
      $aResult['price'] = $aDataPrice['FCPgdPriceRet']; 
   }else{
      $aResult['code'] = 2; 
      $aResult['price'] = 0;
   }

   return $aResult;
    
}

public function FScMPOGetPricePdt4CstOrPdtBYPplCode($paData){
       $tPOPplCodeBch = $paData['tPOPplCodeBch'];
       $tPOPplCodeCst = $paData['tPOPplCodeCst'];
       $tPOPdtCode    = $paData['tPOPdtCode'];
       $tPOPunCode    = $paData['tPOPunCode'];
    //    FDPghDStart วันที่เริ่ม
    //    FTPghTStart เวลาเริ่ม
    //    FDPghDStop วันที่หมดอายุ
    //    FTPghTStop เวลาหมดอายุ
    //    FCPgdPriceRet ราคาขายปลีก
    $PriceReturn = 0;
    if(!empty($tPOPplCodeCst)){
       $aResultCst = $this->FSaMPOGetPrice4Pdt($paData,1);
       if($aResultCst['code']==1){
                $PriceReturn = $aResultCst['price'];
                //End
       }else{
               $aResultBch = $this->FSaMPOGetPrice4Pdt($paData,2);
               if($aResultBch['code']==1){
                     $PriceReturn = $aResultBch['price'];
                       //End
               }else{
                     $aResultBch = $this->FSaMPOGetPrice4Pdt($paData,3);
                     $PriceReturn = $aResultBch['price'];
                      //End
               }
       }
    }else{
        $aResultBch = $this->FSaMPOGetPrice4Pdt($paData,2);
        if($aResultBch['code']==1){
              $PriceReturn = $aResultBch['price'];
                //End
        }else{
              $aResultBch = $this->FSaMPOGetPrice4Pdt($paData,3);
              $PriceReturn = $aResultBch['price'];
               //End
        }
    }

    return $PriceReturn;
}

    //เปิดมาหน้า ADD จะต้อง ลบสินค้าตัวเดิม where session
    public function FSaMCENDeletePDTInTmp($paParams){
        $tSessionID = $this->session->userdata('tSesSessionID');
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocDTTmp');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;
    }


   //คำนวณ Vat เฉลี่ยให้ แถวสุดท้าย
   public function FSaMPOCalVatLastDT($paData){
                    $tDocNo         = $paData['tDocNo'];
                    $tBchCode       = $paData['tBchCode'];
                    $tSessionID     = $paData['tSessionID'];
                    $tDataVatInOrEx = $paData['tDataVatInOrEx'];

                    $cSumFCXtdVat = " SELECT
                        SUM (ISNULL(DOCTMP.FCXtdVat, 0)) AS FCXtdVat
                        FROM
                            TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE
                            1 = 1
                        AND DOCTMP.FTSessionID = '$tSessionID'
                        AND DOCTMP.FTXthDocKey = 'TAPTPoHD'
                        AND DOCTMP.FTXthDocNo = '$tDocNo'
                        --AND DOCTMP.FTXtdVatType = 1
                        AND DOCTMP.FCXtdVatRate > 0  ";

                    $tSql ="UPDATE TCNTDocDTTmp
                            SET FCXtdVat = (
                                ($cSumFCXtdVat) - (
                                    SELECT
                                        SUM (DTTMP.FCXtdVat) AS FCXtdVat
                                    FROM
                                        TCNTDocDTTmp DTTMP
                                    WHERE
                                        DTTMP.FTSessionID = '$tSessionID'
                                    AND DTTMP.FTXthDocNo = '$tDocNo'
                                    AND DTTMP.FTXtdVatType = 1
                                    AND DTTMP.FNXtdSeqNo != (
                                        SELECT
                                            TOP 1 SUBDTTMP.FNXtdSeqNo
                                        FROM
                                            TCNTDocDTTmp SUBDTTMP
                                        WHERE
                                            SUBDTTMP.FTSessionID = '$tSessionID'
                                        AND SUBDTTMP.FTXthDocNo = '$tDocNo'
                                        AND SUBDTTMP.FTXtdVatType = 1
                                        ORDER BY
                                            SUBDTTMP.FNXtdSeqNo DESC
                                    )
                                )
                            ),
                            FCXtdVatable = (
                                CASE
                                    WHEN $tDataVatInOrEx  = 1 --รวมใน 
                                    THEN FCXtdNet - (
                                        ($cSumFCXtdVat) - (
                                            SELECT
                                                SUM (DTTMP.FCXtdVat) AS FCXtdVat
                                            FROM
                                                TCNTDocDTTmp DTTMP
                                            WHERE
                                                DTTMP.FTSessionID = '$tSessionID'
                                            AND DTTMP.FTXthDocNo = '$tDocNo'
                                            AND DTTMP.FTXtdVatType = 1
                                            AND DTTMP.FNXtdSeqNo != (
                                                SELECT
                                                    TOP 1 SUBDTTMP.FNXtdSeqNo
                                                FROM
                                                    TCNTDocDTTmp SUBDTTMP
                                                WHERE
                                                    SUBDTTMP.FTSessionID = '$tSessionID'
                                                AND SUBDTTMP.FTXthDocNo = '$tDocNo'
                                                AND SUBDTTMP.FTXtdVatType = 1
                                                ORDER BY
                                                    SUBDTTMP.FNXtdSeqNo DESC
                                            )
                                        )
                                    )
                                    WHEN $tDataVatInOrEx  = 2 --แยกนอก
                                    THEN FCXtdNetAfHD
                                ELSE 0 END 
                            )
                            WHERE
                                FTSessionID = '$tSessionID'
                            AND FTXthDocNo = '$tDocNo'
                            AND FNXtdSeqNo = (
                                SELECT
                                    TOP 1 FNXtdSeqNo
                                FROM
                                    TCNTDocDTTmp WHDTTMP
                                WHERE
                                    WHDTTMP.FTSessionID = '$tSessionID'
                                AND WHDTTMP.FTXthDocNo = '$tDocNo'
                                AND WHDTTMP.FTXtdVatType = 1
                                ORDER BY
                                    WHDTTMP.FNXtdSeqNo DESC
                            )";

                    $nRSCounDT =  $this->db->where('FTSessionID',$tSessionID)->where('FTXthDocNo',$tDocNo)->where('FTXtdVatType','1')->get('TCNTDocDTTmp')->num_rows();
                    
                    if($nRSCounDT>1){
                        $this->db->query($tSql);
                        if($this->db->affected_rows() > 0){
                            $aStatus = array(
                                'rtCode' => '1',
                                'rtDesc' => 'success',
                            );
                        }else{
                            $aStatus = array(
                                'rtCode' => '905',
                                'rtDesc' => 'cannot Delete Item.',
                            );
                        }
                    }else{
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'success',
                        );
                    }
                    return $aStatus;
        }   


        // Functionality : Delete Purchase Invoice Document
    // Parameters : function parameters
    // Creator : 24/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSxMPOClearDataInDocTempForImp($paWhereClearTemp){
        $tPODocNo       = $paWhereClearTemp['FTXthDocNo'];
        $tPODocKey      = $paWhereClearTemp['FTXthDocKey'];
        $tPOSessionID   = $paWhereClearTemp['FTSessionID'];

        // Query Delete DocTemp
        $tClearDocTemp  =   "   DELETE FROM TCNTDocDTTmp 
                                WHERE 1=1 
                                AND TCNTDocDTTmp.FTXthDocNo     = '$tPODocNo'
                                AND TCNTDocDTTmp.FTXthDocKey    = '$tPODocKey'
                                AND TCNTDocDTTmp.FTSessionID    = '$tPOSessionID'
                                AND TCNTDocDTTmp.FTSrnCode <> 1
        ";
        $this->db->query($tClearDocTemp);

    
    }



        //หาว่าผู้จำหน่ายนี้ใช้ Vat อะไร
        public function FSxMPOFindDetailSPL($paDataWhere){
            $tPoDocNo   = $paDataWhere['FTXthDocNo'];
            $tSQL   = " SELECT TOP 1 FTVatCode , FCXpdVatRate FROM TAPTPoDT WHERE FTXphDocNo = '$tPoDocNo' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aDataReturn = $oQuery->row_array();
            }else{
                $aDataReturn = array();
            }
            return $aDataReturn;
        }
    
        //ทุกครั้งที่เปลี่ยน SPL จะส่งผล ให้เกิดการคำนวณ VAT ใหม่
        public function FSaMPOChangeSPLAffectNewVAT($paData){
            $this->db->set('FTVatCode', $paData['FTVatCode']);
            $this->db->set('FCXtdVatRate', $paData['FCXtdVatRate']);
            $this->db->where('FTSessionID',$paData['tSessionID']);
            $this->db->where('FTXthDocKey',$paData['tDocKey']);
            $this->db->where('FTXthDocNo',$paData['tPODocNo']);
            $this->db->where('FTBchCode',$paData['tBCHCode']);
            $this->db->update('TCNTDocDTTmp');
        }


}