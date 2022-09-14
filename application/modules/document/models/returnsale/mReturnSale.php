<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mReturnsale extends CI_Model {

    // Functionality: Get Data Purchase Invoice HD List
    // Parameters: function parameters
    // Creator:  19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMRSGetDataTableList($paDataCondition){
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
                            SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC ,FTXshDocNo DESC ) AS FNRowID,* FROM
                                (   SELECT DISTINCT
                                        VDHD.FTBchCode,
                                        BCHL.FTBchName,
                                        VDHD.FTXshDocNo,
                                        CONVERT(CHAR(10),VDHD.FDXshDocDate,103) AS FDXshDocDate,
                                        CONVERT(CHAR(5), VDHD.FDXshDocDate,108) AS FTXshDocTime,
                                        VDHD.FTXshStaDoc,
                                        VDHD.FTXshStaApv,
                                        VDHD.FTXshStaPrcStk,
                                        VDHD.FNXshStaRef,
                                        VDHD.FTCreateBy,
                                        VDHD.FDCreateOn,
                                        USRL.FTUsrName      AS FTCreateByName,
                                        VDHD.FTXshApvCode,
                                        USRLAPV.FTUsrName   AS FTXshApvName
                                    FROM TVDTSalHD           VDHD    WITH (NOLOCK)
                                    LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON VDHD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON VDHD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON VDHD.FTXshApvCode  = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                                WHERE 1=1 AND VDHD.FNXshDocType = 9
        ";

        // Check User Login Branch
        // if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
        //     $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
        //     $tSQL   .= " AND SOHD.FTBchCode = '$tUserLoginBchCode' ";
        // }

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND VDHD.FTBchCode IN ($tBchCode)
            ";
        }
        
        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .= " AND VDHD.FTShpCode = '$tUserLoginShpCode' ";
        }

        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((VDHD.FTXshDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),VDHD.FDXshDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((VDHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (VDHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((VDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (VDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND VDHD.FTXshStaDoc = '$tSearchStaDoc' OR VDHD.FTXshStaDoc = ''";
            }else{
                $tSQL .= " AND VDHD.FTXshStaDoc = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะอนุมัติ
        if(isset($tSearchStaApprove) && !empty($tSearchStaApprove)){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND VDHD.FTXshStaApv = '$tSearchStaApprove' OR VDHD.FTXshStaApv = '' ";
            }else{
                $tSQL .= " AND VDHD.FTXshStaApv = '$tSearchStaApprove'";
            }
        }

        // ค้นหาสถานะประมวลผล
        // if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
        //     if($tSearchStaPrcStk == 3){
        //         $tSQL .= " AND VDHD.FTXsdStaPrcStk = '$tSearchStaPrcStk' OR VDHD.FTXsdStaPrcStk = '' ";
        //     }else{
        //         $tSQL .= " AND VDHD.FTXsdStaPrcStk = '$tSearchStaPrcStk'";
        //     }
        // }

        $tSQL   .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMRSCountPageDocListAll($paDataCondition);
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
    public function FSnMRSCountPageDocListAll($paDataCondition){
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

        $tSQL   =   "   SELECT COUNT (VDHD.FTXshDocNo) AS counts
                        FROM TVDTSalHD VDHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON VDHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        WHERE 1=1 AND VDHD.FNXshDocType = 9
                    ";

        // Check User Login Branch
        if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
            $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
            $tSQL   .= " AND VDHD.FTBchCode = '$tUserLoginBchCode' ";
        }

        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .= " AND VDHD.FTShpCode = '$tUserLoginShpCode' ";
        }
        
        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((VDHD.FTXshDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),VDHD.FDXshDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((VDHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (VDHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((VDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (VDHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND VDHD.FTXshStaDoc = '$tSearchStaDoc' OR VDHD.FTXshStaDoc = ''";
            }else{
                $tSQL .= " AND VDHD.FTXshStaDoc = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะอนุมัติ
        if(isset($tSearchStaApprove) && !empty($tSearchStaApprove)){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND VDHD.FTXshStaApv = '$tSearchStaApprove' OR VDHD.FTXshStaApv = '' ";
            }else{
                $tSQL .= " AND VDHD.FTXshStaApv = '$tSearchStaApprove'";
            }
        }

        // ค้นหาสถานะประมวลผล
        // if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
        //     if($tSearchStaPrcStk == 3){
        //         $tSQL .= " AND VDHD.FTXsdStaPrcStk = '$tSearchStaPrcStk' OR VDHD.FTXsdStaPrcStk = '' ";
        //     }else{
        //         $tSQL .= " AND VDHD.FTXsdStaPrcStk = '$tSearchStaPrcStk'";
        //     }
        // }
        
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
    public function FSnMRSDelDocument($paDataDoc){
        $tDataDocNo = $paDataDoc['tDataDocNo'];
        $this->db->trans_begin();

        // Document HD
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TVDTSalHD');

        // Document HD Cst
       $this->db->where_in('FTXshDocNo',$tDataDocNo);
       $this->db->delete('TVDTSalHDCst');

        // Document HD Discount
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TVDTSalHDDis');
        
        // Document DT
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TVDTSalDT');

        // Document DT Discount
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TVDTSalDTDis');


        $this->db->where_in('FTDatRefCode',$tDataDocNo);
        $this->db->delete('TARTDocApvTxn');
        

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
    public function FSxMRSClearDataInDocTemp($paWhereClearTemp){
        $tRSDocNo       = $paWhereClearTemp['FTXthDocNo'];
        $tRSDocKey      = $paWhereClearTemp['FTXthDocKey'];
        $tRSSessionID   = $paWhereClearTemp['FTSessionID'];

        // Query Delete DocTemp
        $tClearDocTemp  =   "   DELETE FROM TCNTDocDTTmp 
                                WHERE 1=1 
                                AND TCNTDocDTTmp.FTXthDocNo     = '$tRSDocNo'
                                AND TCNTDocDTTmp.FTXthDocKey    = '$tRSDocKey'
                                AND TCNTDocDTTmp.FTSessionID    = '$tRSSessionID'
        ";
        $this->db->query($tClearDocTemp);


        // Query Delete Doc HD Discount Temp
        $tClearDocHDDisTemp =   "   DELETE FROM TCNTDocHDDisTmp
                                    WHERE 1=1
                                    AND TCNTDocHDDisTmp.FTXthDocNo  = '$tRSDocNo'
                                    AND TCNTDocHDDisTmp.FTSessionID = '$tRSSessionID'
        ";
        $this->db->query($tClearDocHDDisTemp);

        // Query Delete Doc DT Discount Temp
        $tClearDocDTDisTemp =   "   DELETE FROM TCNTDocDTDisTmp
                                    WHERE 1=1
                                    AND TCNTDocDTDisTmp.FTXthDocNo  = '$tRSDocNo'
                                    AND TCNTDocDTDisTmp.FTSessionID = '$tRSSessionID'
        ";
        $this->db->query($tClearDocDTDisTemp);
    
    }

    // Functionality: Get ShopCode From User Login
    // Parameters: function parameters
    // Creator: 24/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Array Data Shop For User Login
    // ReturnType: array
    public function FSaMRSGetShpCodeForUsrLogin($paDataShp){
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
    public function FSaMRSGetDefOptionConfigWah($paConfigSys){
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
    public function FSaMRSGetDocDTTempListPage($paDataWhere){
        $tRSDocNo           = $paDataWhere['FTXthDocNo'];
        $tRSDocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tRSSesSessionID    = $this->session->userdata('tSesSessionID');

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
                                    DOCTMP.FCXtdVatRate,
                                    DOCTMP.FTXtdVatType,
                                    DOCTMP.FDLastUpdOn,
                                    DOCTMP.FDCreateOn,
                                    DOCTMP.FTLastUpdBy,
                                    DOCTMP.FTCreateBy
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                -- LEFT JOIN TCNMImgPdt IMGPDT on DOCTMP.FTPdtCode = IMGPDT.FTImgRefID AND IMGPDT.FTImgTable='TCNMPdt'
                                WHERE 1 = 1
                                AND DOCTMP.FTXthDocNo  = '$tRSDocNo'
                                AND DOCTMP.FTXthDocKey = '$tRSDocKey'
                                AND DOCTMP.FTSessionID = '$tRSSesSessionID' ";
                                
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
            $aFoundRow  = $this->FSaMRSGetDocDTTempListPageAll($paDataWhere);
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
    public function FSaMRSGetDocDTTempListPageAll($paDataWhere){
        $tRSDocNo           = $paDataWhere['FTXthDocNo'];
        $tRSDocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tRSSesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP
                    WHERE 1 = 1 ";
        
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tRSDocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tRSDocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tRSSesSessionID' ";

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
    public function FSaMRSSumDocDTTemp($paDataWhere){
        $tRSDocNo           = $paDataWhere['FTXthDocNo'];
        $tRSDocKey          = $paDataWhere['FTXthDocKey'];
        $tRSSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL               = " SELECT
                                    SUM(FCXtdNetAfHD)       AS FCXtdSumNetAfHD,
                                    SUM(FCXtdAmtB4DisChg)   AS FCXtdSumAmtB4DisChg
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tRSDocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tRSDocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tRSSesSessionID' ";
        
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
    public function FSaMRSGetMaxSeqDocDTTemp($paDataWhere){
        $tRSBchCode         = $paDataWhere['FTBchCode'];
        $tRSDocNo           = $paDataWhere['FTXthDocNo'];
        $tRSDocKey          = $paDataWhere['FTXthDocKey'];
        $tRSSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL   =   "   SELECT 
                            MAX(DOCTMP.FNXtdSeqNo) AS rnMaxSeqNo
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTBchCode   = '$tRSBchCode'";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tRSDocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tRSDocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tRSSesSessionID'";
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
    public function FSaMRSGetDataPdt($paDataPdtParams){
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
    public function FSaMRSInsertPDTToTemp($paDataPdtMaster,$paDataPdtParams){
        $paPIDataPdt    = $paDataPdtMaster['raItem'];
        if($paDataPdtParams['tRSOptionAddPdt'] == 1){
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
                    'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVat'],
                    'FTVatCode'         => $paPIDataPdt['FTVatCode'],
                    'FCXtdVatRate'      => $paPIDataPdt['FCVatRate'],
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
                    'FTLastUpdBy'       => $paDataPdtParams['tRSUsrCode'],
                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                    'FTCreateBy'        => $paDataPdtParams['tRSUsrCode'],
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
                // 'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVatBuy'],
                'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVat'],
                'FTVatCode'         => $paPIDataPdt['FTVatCode'],
                'FCXtdVatRate'      => $paPIDataPdt['FCVatRate'],
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
                'FTLastUpdBy'       => $paDataPdtParams['tRSUsrCode'],
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $paDataPdtParams['tRSUsrCode'],
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
    public function FSaMRSUpdateInlineDTTemp($paDataUpdateDT,$paDataWhere){

            // $this->db->set($paDataUpdateDT['tSOFieldName'], $paDataUpdateDT['tSOValue']);
             $tRSSessionID = $paDataWhere['tRSSessionID'];
             $tRSDocNo = $paDataWhere['tRSDocNo'];
             $tRSBchCode = $paDataWhere['tRSBchCode'];
             $nRSSeqNo = $paDataWhere['nRSSeqNo'];

            $tSQL ="SELECT
                        ISNULL(PKS.FCPdtUnitFact,0) AS FCPdtUnitFact
                    FROM
                        TCNTDocDTTmp DTTEMP
                    LEFT OUTER JOIN TCNMPdtPackSize PKS WITH (NOLOCK) ON DTTEMP.FTPdtCode = PKS.FTPdtCode AND DTTEMP.FTPunCode = PKS.FTPunCode
                    WHERE
                        FTSessionID = '$tRSSessionID'
                        AND FTBchCode = '$tRSBchCode'
                        AND FTXthDocNo = '$tRSDocNo'
                        AND FNXtdSeqNo = $nRSSeqNo
                        ";
            $cPdtUnitFact = $this->db->query($tSQL)->row_array()['FCPdtUnitFact'];
            if($cPdtUnitFact>0){ 
                $cPdtUnitFact = $cPdtUnitFact;
             }else{
                $cPdtUnitFact = 1;
             }
                    
            $this->db->set('FCXtdQty', $paDataUpdateDT['FCXtdQty']);
            $this->db->set('FCXtdQtyAll', $paDataUpdateDT['FCXtdQty']*$cPdtUnitFact);
            $this->db->set('FCXtdSetPrice', $paDataUpdateDT['FCXtdSetPrice']);
            $this->db->set('FCXtdNet', $paDataUpdateDT['FCXtdNet']);

            $this->db->where('FTSessionID',$paDataWhere['tRSSessionID']);
            $this->db->where('FTXthDocKey',$paDataWhere['tDocKey']);
            $this->db->where('FNXtdSeqNo',$paDataWhere['nRSSeqNo']);
            $this->db->where('FTXthDocNo',$paDataWhere['tRSDocNo']);
            $this->db->where('FTBchCode',$paDataWhere['tRSBchCode']);
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
    public function FSnMRSChkPdtInDocDTTemp($paDataWhere){
        $tRSDocNo       = $paDataWhere['FTXthDocNo'];
        $tRSDocKey      = $paDataWhere['FTXthDocKey'];
        $tRSSessionID   = $paDataWhere['FTSessionID'];
        $tSQL           = " SELECT
                                COUNT(FNXtdSeqNo) AS nCountPdt
                            FROM TCNTDocDTTmp DocDT
                            WHERE 1=1
                            AND DocDT.FTXthDocNo    = '$tRSDocNo'
                            AND DocDT.FTXthDocKey   = '$tRSDocKey'
                            AND DocDT.FTSessionID   = '$tRSSessionID' ";
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
    public function FSnMRSDelPdtInDTTmp($paDataWhere){
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
    public function FSnMRSDelMultiPdtInDTTmp($paDataWhere){
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

    // Functionality : Function Get Cal From DT Temp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMRSCalInDTTemp($paParams){
        $tDocNo     = $paParams['tDocNo'];
        $tDocKey    = $paParams['tDocKey'];
        $tBchCode   = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        $tSQL       = " SELECT
                            /* ยอดรวม ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdNet, 0)) AS FCXshTotal,

                            /* ยอดรวมสินค้าไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXshTotalNV,

                            /* ยอดรวมสินค้าห้ามลด ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXshTotalNoDis,

                            /* ยอมรวมสินค้าลดได้ และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0) ELSE 0 END) AS FCXshTotalB4DisChgV,

                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0) ELSE 0 END) AS FCXshTotalB4DisChgNV,

                            /* ยอดรวมหลังลด และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXshTotalAfDisChgV,

                            /* ยอดรวมหลังลด และไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXshTotalAfDisChgNV,

                            /* ยอดรวมเฉพาะภาษี ==============================================================*/
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
                            ) AS FCXshAmtV,

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
                            ) AS FCXshAmtNV,

                            /* ยอดภาษี ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdVat, 0)) AS FCXshVat,

                            /* ยอดแยกภาษี ==============================================================*/
                            (
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


                            ) AS FCXshVatable,

                            /* รหัสอัตราภาษี ณ ที่จ่าย ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXtdWhtCode
                                FROM TCNTDocDTTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode = '$tBchCode'
                                AND DOCCONCAT.FTXthDocNo = '$tDocNo'
                                AND DOCCONCAT.FTSessionID = '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXshWpCode,

                            /* ภาษีหัก ณ ที่จ่าย ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdWhtAmt, 0)) AS FCXshWpTax

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
    public function FSaMRSCalInHDDisTemp($paParams){
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
                            FOR XML PATH('')), 1, 1, '') AS FTXshDisChgTxt,
                            /* มูลค่ารวมส่วนลด ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 1 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 2 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXshDis,
                            /* มูลค่ารวมส่วนชาร์จ ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 3 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 4 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXshChg
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
    public function FSxMRSAddUpdateHD($paDataMaster,$paDataWhere){
        
                // Get Data PI HD
                $aDataGetDataHD     =   $this->FSaMRSGetDataDocHD(array(
                    'FTXthDocNo'    => $paDataWhere['FTXshDocNo'],
                    'FNLngID'       => $this->session->userdata("tLangEdit")
                ));
        
                $aDataAddUpdateHD   = array();
                if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
                    $aDataHDOld         = $aDataGetDataHD['raItems'];
                    $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                        'FTBchCode'     => $paDataWhere['FTBchCode'],
                        'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
                        'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                        'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
                        'FDCreateOn'    => $aDataHDOld['FDCreateOn'],
                        'FTCreateBy'    => $aDataHDOld['FTCreateBy']
                    ));
                }else{
                    $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                        'FTBchCode'     => $paDataWhere['FTBchCode'],
                        'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
                        'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                        'FTCreateBy'    => $paDataWhere['FTCreateBy'],
                    ));
                }
                // Delete VD HD
                $this->db->where_in('FTBchCode',$aDataAddUpdateHD['FTBchCode']);
                $this->db->where_in('FTXshDocNo',$aDataAddUpdateHD['FTXshDocNo']);
                $this->db->delete('TVDTSalHD');
        
                // Insert VD HD Dis
                $this->db->insert('TVDTSalHD',$aDataAddUpdateHD);
    

        return;
    }


    // Functionality : Add/Update Data HD Cst
    // Parameters : function parameters
    // Creator : 21/01/2020 nattakit(Nale)
    // Last Modified : -
    // Return : Array Status Add/Update Document HD Cst
    // Return Type : array
    public function FSxMRSAddUpdateHDCst($paDataMaster,$paDataWhere){
   

                // Get Data VD HD
        $aDataGetDataHD     =   $this->FSaMRSGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXshDocNo'],
            'FNLngID'       => $this->session->userdata("tLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            $aDataHDOld         = $aDataGetDataHD['raItems'];
            $aDataAddUpdateHD   = array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
                'FTXshCardID'   => $paDataMaster['FTXshCardID'],
                'FTXshCstName'   => $paDataMaster['FTXshCstName'],
                'FTXshCstTel'   => $paDataMaster['FTXshCstTel']

            );
        }else{
            $aDataAddUpdateHD   = array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
                'FTXshCardID'   => $paDataMaster['FTXshCardID'],
                'FTXshCstName'   => $paDataMaster['FTXshCstName'],
                'FTXshCstTel'   => $paDataMaster['FTXshCstTel']
            );
        }
        // Delete VD HD
        $this->db->where_in('FTBchCode',$aDataAddUpdateHD['FTBchCode']);
        $this->db->where_in('FTXshDocNo',$aDataAddUpdateHD['FTXshDocNo']);
        $this->db->delete('TVDTSalHDCst');

        // Insert VD HD Cst
        $this->db->insert('TVDTSalHDCst',$aDataAddUpdateHD);

        return;
    }


    
    // Functionality : Add/Update Data HD
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Add/Update Document HD
    // Return Type : array
    public function FSxMRSAddUpdateRC($paDataSalRC,$paDataWhere){
        
        // Get Data PI HD
        $aDataGetDataHD     =   $this->FSaMRSGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXshDocNo'],
            'FNLngID'       => $this->session->userdata("tLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            $aDataHDOld         = $aDataGetDataHD['raItems'];
            $aDataAddUpdateHD   = array_merge($paDataSalRC,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
                'FDCreateOn'    => $aDataHDOld['FDCreateOn'],
                'FTCreateBy'    => $aDataHDOld['FTCreateBy']
            ));
        }else{
            $aDataAddUpdateHD   = array_merge($paDataSalRC,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
        }
        // Delete VD HD
        $this->db->where_in('FTBchCode',$aDataAddUpdateHD['FTBchCode']);
        $this->db->where_in('FTXshDocNo',$aDataAddUpdateHD['FTXshDocNo']);
        $this->db->delete('TVDTSalRC');

        // Insert VD HD Dis
        $this->db->insert('TVDTSalRC',$aDataAddUpdateHD);


        return;
    }


    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSxMRSAddUpdateDocNoToTemp($paDataWhere,$paTableAddUpdate){
        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableHD']);
        $this->db->update('TCNTDocDTTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXshDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into HDDisTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->update('TCNTDocHDDisTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXshDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into DTDisTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->update('TCNTDocDTDisTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXshDocNo'],
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
    public function FSaMRSMoveHdDisTempToHdDis($paDataWhere,$paTableAddUpdate){
        $tRSDocNo       = $paDataWhere['FTXshDocNo'];
        $tRSBchCode     = $paDataWhere['FTBchCode'];
        $tRSSessionID   = $this->input->post('ohdSesSessionID');
        if(isset($tRSDocNo) && !empty($tRSDocNo)){
            $this->db->where_in('FTXshDocNo',$tRSDocNo);
            $this->db->where_in('FTBchCode',$tRSBchCode);
            $this->db->delete($paTableAddUpdate['tTableHDDis']);
        }
        $tSQL   =   "   INSERT INTO ".$paTableAddUpdate['tTableHDDis']." (
                            FTBchCode,FTXshDocNo,FDXhdDateIns,FTXhdDisChgTxt,FTXhdDisChgType,
                            FCXhdTotalAfDisChg,FCXhdDisChg,FCXhdAmt,FTDisCode,FTRsnCode )
                    ";
        $tSQL   .=  "   SELECT
                            HDDISTEMP.FTBchCode,
                            HDDISTEMP.FTXthDocNo,
                            HDDISTEMP.FDXtdDateIns,
                            HDDISTEMP.FTXtdDisChgTxt,
                            HDDISTEMP.FTXtdDisChgType,
                            HDDISTEMP.FCXtdTotalAfDisChg,
                            HDDISTEMP.FCXtdDisChg,
                            HDDISTEMP.FCXtdAmt,
                            HDDISTEMP.FTDisCode,
                            HDDISTEMP.FTRsnCode
                        FROM TCNTDocHDDisTmp AS HDDISTEMP WITH (NOLOCK)
                        WHERE 1 = 1
                        AND HDDISTEMP.FTBchCode     = '$tRSBchCode'
                        AND HDDISTEMP.FTXthDocNo    = '$tRSDocNo'
                        AND HDDISTEMP.FTSessionID   = '$tRSSessionID'
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
    public function FSaMRSMoveDtTmpToDt($paDataWhere,$paTableAddUpdate){
        $tRSBchCode     = $paDataWhere['FTBchCode'];
        $tRSDocNo       = $paDataWhere['FTXshDocNo'];
        $tRSDocKey      = $paTableAddUpdate['tTableHD'];
        $tRSSessionID   = $this->input->post('ohdSesSessionID');
        $dLastUpdOn    = $paDataWhere['FDLastUpdOn'];
        $dCreateOn     = $paDataWhere['FDCreateOn'];
        $tCreateBy     = $paDataWhere['FTCreateBy'];
        $tLastUpdBy    = $paDataWhere['FTLastUpdBy'];


        if(isset($tRSDocNo) && !empty($tRSDocNo)){
            $this->db->where_in('FTXshDocNo',$tRSDocNo);
            $this->db->delete('TVDTSalDT');
        }
        $tSQL   =  "  INSERT INTO TVDTSalDT (FTBchCode,FTXshDocNo,FNXsdSeqNo,FTPdtCode,FTXsdPdtName,FTPunCode,FTPunName,FCXsdFactor,FTXsdBarCode,
                        FTXsdVatType,FTVatCode,FCXsdVatRate,FTXsdSaleType,FCXsdSalePrice,FCXsdQty,FCXsdQtyAll,FCXsdSetPrice,
                        FCXsdAmtB4DisChg,FTXsdDisChgTxt,FCXsdDis,FCXsdChg,FCXsdNet,FCXsdNetAfHD,FCXsdVat,
                        FCXsdVatable,FCXsdWhtAmt,FTXsdWhtCode,FCXsdWhtRate,FCXsdCostIn,FCXsdCostEx,FCXsdQtyLef,
                        FCXsdQtyRfn,FTXsdStaPrcStk,FTXsdStaAlwDis,FNXsdPdtLevel,FTXsdPdtParent,FCXsdQtySet,FTPdtStaSet,
                        FTXsdRmk,FTSrnCode,FTXsdStaPdt,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                    ) 
                    SELECT
                        DTTMP.FTBchCode,
                        DTTMP.FTXthDocNo,
                        ROW_NUMBER() OVER(ORDER BY DTTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                        DTTMP.FTPdtCode,
                        DTTMP.FTXtdPdtName,
                        DTTMP.FTPunCode,
                        DTTMP.FTPunName,
                        DTTMP.FCXtdFactor,
                        DTTMP.FTXtdBarCode,
                        DTTMP.FTXtdVatType,
                        DTTMP.FTVatCode,
                        DTTMP.FCXtdVatRate,
                        DTTMP.FTXtdSaleType,
                        DTTMP.FCXtdSalePrice,
                        DTTMP.FCXtdQty,
                        DTTMP.FCXtdQtyAll,
                        DTTMP.FCXtdSetPrice,
                        DTTMP.FCXtdAmtB4DisChg,
                        DTTMP.FTXtdDisChgTxt,
                        DTTMP.FCXtdDis,
                        DTTMP.FCXtdChg,
                        DTTMP.FCXtdNet,
                        DTTMP.FCXtdNetAfHD,
                        DTTMP.FCXtdVat,
                        DTTMP.FCXtdVatable,
                        DTTMP.FCXtdWhtAmt,
                        DTTMP.FTXtdWhtCode,
                        DTTMP.FCXtdWhtRate,
                        DTTMP.FCXtdCostIn,
                        DTTMP.FCXtdCostEx,
                        DTTMP.FCXtdQtyLef,
                        DTTMP.FCXtdQtyRfn,
                        '2' AS FTXtdStaPrcStk,
                        DTTMP.FTXtdStaAlwDis,
                        DTTMP.FNXtdPdtLevel,
                        DTTMP.FTXtdPdtParent,
                        DTTMP.FCXtdQtySet,
                        DTTMP.FTXtdPdtStaSet,
                        DTTMP.FTXtdRmk,
                        DTTMP.FTSrnCode,
                        '2' AS FTXsdStaPdt,
                        '$dLastUpdOn' AS FDLastUpdOn,
                        '$tLastUpdBy' AS FTLastUpdBy,
                        '$dCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy
                    FROM 
                    TCNTDocDTTmp DTTMP WITH (NOLOCK)
                    WHERE 1=1
                        AND DTTMP.FTBchCode    = '$tRSBchCode'
                        AND DTTMP.FTXthDocNo   = '$tRSDocNo'
                        AND DTTMP.FTXthDocKey  = '$tRSDocKey'
                        AND DTTMP.FTSessionID  = '$tRSSessionID'
                        ORDER BY DTTMP.FNXtdSeqNo ASC
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
    public function FSaMRSMoveDtTmpToDtVD($paDataWhere,$paTableAddUpdate){
        $tRSBchCode     = $paDataWhere['FTBchCode'];
        $tRSDocNo       = $paDataWhere['FTXshDocNo'];
        $tWahCode       = $paDataWhere['FTWahCode'];
        $tRSDocKey      = $paTableAddUpdate['tTableHD'];
        $tRSSessionID   = $this->input->post('ohdSesSessionID');
        $dLastUpdOn    = $paDataWhere['FDLastUpdOn'];
        $dCreateOn     = $paDataWhere['FDCreateOn'];
        $tCreateBy     = $paDataWhere['FTCreateBy'];
        $tLastUpdBy    = $paDataWhere['FTLastUpdBy'];


        if(isset($tRSDocNo) && !empty($tRSDocNo)){
            $this->db->where_in('FTXshDocNo',$tRSDocNo);
            $this->db->delete('TVDTSalDTVD');
        }
        $tSQL   =  "  INSERT INTO TVDTSalDTVD (FTBchCode,FTXshDocNo,FNXsdSeqNo,FNCabSeq,FTXsdBarcode,FTPdtCode,FNLayRow,FNLayCol,FTXsvStaPayItem,FTWahCode  ) 
                    SELECT
                        DTTMP.FTBchCode,
                        DTTMP.FTXthDocNo,
                        ROW_NUMBER() OVER(ORDER BY DTTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                        0 AS FNCabSeq,
                        '' AS FTXtdBarCode,
                        '' AS FTPdtCode,
                        '' AS FNLayRow,
                        '' AS FNLayCol,
                        '1' AS FTXsvStaPayItem,
                        '$tWahCode' AS FTWahCode
                    FROM 
                    TCNTDocDTTmp DTTMP WITH (NOLOCK)
                    WHERE 1=1
                        AND DTTMP.FTBchCode    = '$tRSBchCode'
                        AND DTTMP.FTXthDocNo   = '$tRSDocNo'
                        AND DTTMP.FTXthDocKey  = '$tRSDocKey'
                        AND DTTMP.FTSessionID  = '$tRSSessionID'
                        ORDER BY DTTMP.FNXtdSeqNo ASC
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
    public function FSaMRSMoveDtDisTempToDtDis($paDataWhere,$paTableAddUpdate){
        $tRSBchCode     = $paDataWhere['FTBchCode'];
        $tRSDocNo       = $paDataWhere['FTXshDocNo'];
        $tRSSessionID   = $this->input->post('ohdSesSessionID');
        
        if(isset($tRSDocNo) && !empty($tRSDocNo)){
            $this->db->where_in('FTXshDocNo',$tRSDocNo);
            $this->db->where_in('FTBchCode',$tRSBchCode);
            $this->db->delete($paTableAddUpdate['tTableDTDis']);
        }

        $tSQL   =   "   INSERT INTO ".$paTableAddUpdate['tTableDTDis']." (FTBchCode,FTXshDocNo,FNXsdSeqNo,FDXddDateIns,FNXddStaDis,FTXddDisChgTxt,FTXddDisChgType,FCXddNet,FCXddValue,FTDisCode,FTRsnCode) ";
        $tSQL   .=  "   SELECT
                            DOCDISTMP.FTBchCode,
                            DOCDISTMP.FTXthDocNo,
                            DOCDISTMP.FNXtdSeqNo,
                            DOCDISTMP.FDXtdDateIns,
                            DOCDISTMP.FNXtdStaDis,
                            DOCDISTMP.FTXtdDisChgTxt,
                            DOCDISTMP.FTXtdDisChgType,
                            DOCDISTMP.FCXtdNet,
                            DOCDISTMP.FCXtdValue,
                            DOCDISTMP.FTDisCode,
                            DOCDISTMP.FTRsnCode
                        FROM TCNTDocDTDisTmp DOCDISTMP WITH (NOLOCK)
                        WHERE 1=1
                        AND DOCDISTMP.FTBchCode     = '$tRSBchCode'
                        AND DOCDISTMP.FTXthDocNo    = '$tRSDocNo'
                        AND DOCDISTMP.FTSessionID   = '$tRSSessionID' 
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
    public function FSaMRSGetDataDocHD($paDataWhere){
        $tRSDocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID     = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            DOCHD.FTBchCode,
                            BCHL.FTBchName,
                            SHP.FTMerCode,
                            MERL.FTMerName,
                            SHP.FTShpType,
                            SHP.FTShpCode,
                            SHPL.FTShpName,
                            DOCHD.FTPosCode,
                            POSL.FTPosName,
                            DOCHD.FTWahCode,
                            WAHL.FTWahName,

                            DOCHD.FTXshDocNo,
                            DOCHD.FNXshDocType,
                            DOCHD.FDXshDocDate,
                            DOCHD.FTXshCshOrCrd,
                            DOCHD.FTXshVATInOrEx,
                            DOCHD.FTDptCode,
                            DPTL.FTDptName,
                            DOCHD.FTUsrCode,
                            USRL.FTUsrName,
                            DOCHD.FTXshApvCode,
                            USRAPV.FTUsrName	AS FTXshApvName,
                            -- DOCHD.FTSplCode,
                            -- SPLL.FTSplName,
                            DOCHD.FTXshRefExt,
                            DOCHD.FDXshRefExtDate,
                            DOCHD.FTXshRefInt,
                            DOCHD.FDXshRefIntDate,
                            DOCHD.FTXshRefAE,
                            DOCHD.FNXshDocPrint,
                            DOCHD.FTRteCode,
                            DOCHD.FCXshRteFac,
                            DOCHD.FTXshRmk,

                            DOCHD.FTXshStaRefund,
                            DOCHD.FTXshStaDoc,
                            DOCHD.FTXshStaApv,
                            -- DOCHD.FTXshStaDelMQ,
                            -- DOCHD.FTXsdStaPrcStk,
                            DOCHD.FTXshStaPaid,
                            SPN.FTUsrName AS rtSpnName,
                            DOCHD.FNXshStaDocAct,
                            DOCHD.FNXshStaRef,
                            DOCHD.FTPosCode,
                            DOCHD.FTCstCode,
                            DOCHD.FTRsnCode,
                            RSN.FTRsnName,
                            HDCST.FTXshCardID,
                            HDCST.FTXshCstName,
                            HDCST.FTXshCstTel,
                            CST.FTPplCodeRet,
                            CST.FTCstDiscRet,
                            IMGOBJ.FTImgObj,
                            HDRC.FTRcvCode,
                            HDRC.FTRcvName,
                            DOCHD.FDLastUpdOn,
                            DOCHD.FTLastUpdBy,
                            DOCHD.FDCreateOn,
                            DOCHD.FTCreateBy
                            
                        FROM TVDTSalHD DOCHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK)   ON DOCHD.FTBchCode      = BCHL.FTBchCode    AND BCHL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMShop          SHP     WITH (NOLOCK)   ON DOCHD.FTShpCode      = SHP.FTShpCode     AND DOCHD.FTBchCode  = 	SHP.FTBchCode 
                        LEFT JOIN TCNMShop_L        SHPL    WITH (NOLOCK)   ON DOCHD.FTShpCode      = SHPL.FTShpCode    AND DOCHD.FTBchCode  = 	SHPL.FTBchCode  	AND SHPL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK)   ON SHP.FTMerCode        = MERL.FTMerCode	AND MERL.FNLngID	    = $nLngID

                        LEFT JOIN TCNMWaHouse_L     WAHL    WITH (NOLOCK)   ON DOCHD.FTWahCode      = WAHL.FTWahCode    AND BCHL.FTBchCode = 	WAHL.FTBchCode AND WAHL.FNLngID	    = $nLngID
                        
                        LEFT JOIN TCNMPos_L		    POSL    WITH (NOLOCK)   ON DOCHD.FTPosCode        = POSL.FTPosCode   AND DOCHD.FTBchCode  = 	POSL.FTBchCode    AND POSL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUsrDepart_L	DPTL    WITH (NOLOCK)   ON DOCHD.FTDptCode      = DPTL.FTDptCode	AND DPTL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK)   ON DOCHD.FTUsrCode      = USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK)   ON DOCHD.FTXshApvCode	= USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        SPN    WITH (NOLOCK)    ON DOCHD.FTSpnCode      = SPN.FTUsrCode	    AND SPN.FNLngID	    = $nLngID
                        LEFT JOIN TCNMRsn_L          RSN    WITH (NOLOCK)    ON DOCHD.FTRsnCode      = RSN.FTRsnCode	    AND RSN.FNLngID	    = $nLngID
                        LEFT JOIN TVDTSalHDCst       HDCST   WITH (NOLOCK)   ON DOCHD.FTXshDocNo     = HDCST.FTXshDocNo
                        LEFT JOIN TCNMCst           CST     WITH (NOLOCK)   ON DOCHD.FTCstCode      = CST.FTCstCode
                        LEFT JOIN TCNMImgObj        IMGOBJ  WITH (NOLOCK)   ON DOCHD.FTXshDocNo     = IMGOBJ.FTImgRefID  AND IMGOBJ.FTImgTable='TVDTSalHD'
                        LEFT OUTER JOIN ( SELECT  RC.FTBchCode,RC.FTXshDocNo, RC.FNXrcSeqNo,RC.FTRcvCode,RC.FTRcvName FROM TVDTSalRC RC  ) HDRC ON DOCHD.FTBchCode =  HDRC.FTBchCode AND  DOCHD.FTXshDocNo =  HDRC.FTXshDocNo AND HDRC.FNXrcSeqNo = 1
                        -- LEFT JOIN TCNMSpl_L         SPLL    WITH (NOLOCK)   ON DOCHD.FTSplCode		= SPLL.FTSplCode	AND SPLL.FNLngID	= $nLngID
                        WHERE 1=1 AND DOCHD.FTXshDocNo = '$tRSDocNo' ";
                        
        $oQuery = $this->db->query($tSQL);

        // echo $this->db->last_query();
        // die();
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
    public function FSxMRSMoveHDDisToTemp($paDataWhere){
        $tRSDocNo       = $paDataWhere['FTXthDocNo'];
        // Delect Document HD DisTemp By Doc No
        $this->db->where('FTXthDocNo',$tRSDocNo);
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
                            FTDisCode,
                            FTRsnCode,
                            FTSessionID,
                            FDLastUpdOn,
                            FDCreateOn,
                            FTLastUpdBy,
                            FTCreateBy
                        )
                        SELECT 
                            VDHDDis.FTBchCode,
                            VDHDDis.FTXshDocNo,
                            VDHDDis.FDXhdDateIns,
                            VDHDDis.FTXhdDisChgTxt,
                            VDHDDis.FTXhdDisChgType,
                            VDHDDis.FCXhdTotalAfDisChg,
                            (ISNULL(NULL,0)) AS FCXtdTotalB4DisChg,
                            VDHDDis.FCXhdDisChg,
                            VDHDDis.FCXhdAmt,
                            VDHDDis.FTDisCode,
                            VDHDDis.FTRsnCode,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."')    AS FTSessionID,
                            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                        FROM TVDTSalHDDis VDHDDis WITH (NOLOCK)
                        WHERE 1=1 AND VDHDDis.FTXshDocNo = '$tRSDocNo'
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
    public function FSxMRSMoveDTToDTTemp($paDataWhere){
        $tRSDocNo       = $paDataWhere['FTXthDocNo'];
        $tRSDocKey      = $paDataWhere['FTXthDocKey'];


        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocNo',$tRSDocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL = "INSERT INTO TCNTDocDTTmp (
            FTBchCode,FTXthDocNo,FNXtdSeqNo,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,FTXtdVatType,FTVatCode,FCXtdVatRate,FTXtdSaleType,FCXtdSalePrice,FCXtdQty,FCXtdQtyAll,FCXtdSetPrice,FCXtdAmtB4DisChg,
              FTXtdDisChgTxt,FCXtdDis,FCXtdChg,FCXtdNet,FCXtdNetAfHD,FCXtdVat,FCXtdVatable,FCXtdWhtAmt,FTXtdWhtCode,FCXtdWhtRate,FCXtdCostIn,FCXtdCostEx,FCXtdQtyLef,FCXtdQtyRfn,FTXtdStaPrcStk,FTXtdStaAlwDis,
              FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,FTXtdPdtStaSet,FTXtdRmk,FTSrnCode,FTXthDocKey,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
          )
          SELECT
          DT.FTBchCode,
          DT.FTXshDocNo,
          DT.FNXsdSeqNo,
          DT.FTPdtCode,
          DT.FTXsdPdtName,
          DT.FTPunCode,
          DT.FTPunName,
          DT.FCXsdFactor,
          DT.FTXsdBarCode,
          DT.FTXsdVatType,
          DT.FTVatCode,
          DT.FCXsdVatRate,
          DT.FTXsdSaleType,
          DT.FCXsdSalePrice,
          DT.FCXsdQty,
          DT.FCXsdQtyAll,
          DT.FCXsdSetPrice,
          DT.FCXsdAmtB4DisChg,
          DT.FTXsdDisChgTxt,
          DT.FCXsdDis,
          DT.FCXsdChg,
          DT.FCXsdNet,
          DT.FCXsdNetAfHD,
          DT.FCXsdVat,
          DT.FCXsdVatable,
          DT.FCXsdWhtAmt,
          DT.FTXsdWhtCode,
          DT.FCXsdWhtRate,
          DT.FCXsdCostIn,
          DT.FCXsdCostEx,
          DT.FCXsdQtyLef,
          DT.FCXsdQtyRfn,
          DT.FTXsdStaPrcStk,
          DT.FTXsdStaAlwDis,
          DT.FNXsdPdtLevel,
          DT.FTXsdPdtParent,
          DT.FCXsdQtySet,
          DT.FTPdtStaSet,
          DT.FTXsdRmk,
          DT.FTSrnCode,
          CONVERT(VARCHAR,'".$tRSDocKey."') AS FTXthDocKey,
          CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
          CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
          CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
          CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
          CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
          FROM
              TVDTSalDT DT WITH (NOLOCK)
              WHERE 1=1 AND DT.FTXshDocNo = '$tRSDocNo'
                ORDER BY DT.FNXsdSeqNo ASC
          ";


        $oQuery = $this->db->query($tSQL);
        return;
    }


    // Functionality : Move Data DT Dis To DT Dis Temp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    public function FSxMRSMoveDTDisToDTDisTemp($paDataWhere){
        $tRSDocNo       = $paDataWhere['FTXthDocNo'];
        
        // Delect Document DTDisTemp By Doc No
        $this->db->where('FTXthDocNo',$tRSDocNo);
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
                        FTDisCode,
                        FTRsnCode,
                        FDLastUpdOn,
                        FDCreateOn,
                        FTLastUpdBy,
                        FTCreateBy,
                        FTXtdDisChgTxt
                    )
                    SELECT
                        VDDTDis.FTBchCode,
                        VDDTDis.FTXshDocNo,
                        VDDTDis.FNXsdSeqNo,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."')    AS FTSessionID,
                        VDDTDis.FDXddDateIns,
                        VDDTDis.FNXddStaDis,
                        VDDTDis.FTXddDisChgType,
                        VDDTDis.FCXddNet,
                        VDDTDis.FCXddValue,
                        VDDTDis.FTDisCode,
                        VDDTDis.FTRsnCode,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy,
                        VDDTDis.FTXddDisChgTxt
                    FROM TVDTSalDTDis VDDTDis
                    WHERE 1=1 AND VDDTDis.FTXshDocNo = '$tRSDocNo'
                    ORDER BY VDDTDis.FNXsdSeqNo ASC
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
    public function FSaMRSCancelDocument($paDataUpdate){
        // TVDTSalHD
        $this->db->trans_begin();
        $this->db->set('FTXshStaDoc' , '3');
        $this->db->where('FTXshDocNo', $paDataUpdate['tDocNo']);
        $this->db->update('TVDTSalHD');


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
    public function FSaMRSApproveDocument($paDataUpdate){
        // TVDTSalHD
        $this->db->trans_begin();
        $dLastUpdOn = date('Y-m-d H:i:s');
        $tLastUpdBy = $this->session->userdata('tSesUsername');


        $this->db->set('FDLastUpdOn',$dLastUpdOn);
        $this->db->set('FTLastUpdBy',$tLastUpdBy);
        $this->db->set('FTXshStaPrcStk',2);
        $this->db->set('FTXshStaApv',$paDataUpdate['nStaApv']);
        $this->db->set('FTXshApvCode',$paDataUpdate['tApvCode']);
        $this->db->where('FTXshDocNo',$paDataUpdate['tDocNo']);


        $this->db->update('TVDTSalHD');
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
        $tRSDataSearchAndAdd    = $paDataChkINDB['tSODataSearchAndAdd'];
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
                    AND (PDTBAR.FTPdtCode = '$tRSDataSearchAndAdd' OR PDTBAR.FTBarCode = '$tRSDataSearchAndAdd')
        ";
        $oQuery         = $this->db->query($tSQL);
        $aDataReturn    = $oQuery->result_array();
        unset($oQuery);
        return $aDataReturn;
    }





    // Function: Clone From table Role To Trns For Document.
    // Parameters: tTableDocHD tApvCode tDocNo dDocDate tBchCodes
    // Creator: 22/01/2020 Nattakit(Nale)
    // LastUpdate: -
    // Return: 1,2
    // ReturnType: number
    public function FSnMRSGetDocType(){

        $tSql = "
        SELECT
            TSysDocType.FNSdtDocType
            FROM [dbo].[TSysDocType]
            WHERE 
            TSysDocType.FTSdtTblName='TVDTSalHD'
        ";
        $oQuery = $this->db->query($tSql);
        return $oQuery->row_array();
    }




    // Function: Clone From table Role To Trns For Document.
    // Parameters: tTableDocHD tApvCode tDocNo dDocDate tBchCodes
    // Creator: 22/01/2020 Nattakit(Nale)
    // LastUpdate: -
    // Return: 1,2
    // ReturnType: number
    public function FSaMRSGetDetailUserBranch($paBchCode){
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



    // Function: Clone From table Role To Trns For Document.
    // Parameters: tTableDocHD tApvCode tDocNo dDocDate tBchCodes
    // Creator: 22/01/2020 Nattakit(Nale)
    // LastUpdate: -
    // Return: 1,2
    // ReturnType: number
    public function FSaMRSCalVatLastDT($paData){

        $tDocNo = $paData['tDocNo'];
        $tBchCode = $paData['tBchCode'];
        $tSessionID = $paData['tSessionID'];

        $cSumFCXtdVat = " SELECT
                                SUM (ISNULL(DOCTMP.FCXtdVat, 0)) AS FCXtdVat
                            FROM
                                TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                            WHERE
                                1 = 1
                            AND DOCTMP.FTSessionID = '$tSessionID'
                            AND DOCTMP.FTXthDocKey = 'TVDTSalHD'
                            AND DOCTMP.FTXthDocNo = '$tDocNo'
                            AND DOCTMP.FTXtdVatType = 1
                            AND DOCTMP.FCXtdVatRate > 0  ";


        $tSql ="
                    UPDATE TCNTDocDTTmp
                            SET FCXtdVat = (
                                ($cSumFCXtdVat) - ( 
                                        SELECT ISNULL(DTTSeq.FCXtdVat,0) FROM (
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
                                        ) DTTSeq

                                )
                                    ),
                             FCXtdVatable = (FCXtdNet - (
                                ($cSumFCXtdVat) - (
                                      SELECT ISNULL(SUBDTTSeq.FCXtdVat,0) FROM (
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
                                                ) SUBDTTSeq

                                        )
                                    ))
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
                            )

        ";
        // echo $tSql;
        // die();
         $nRSCounDT =  $this->db->where('FTSessionID',$tSessionID)->where('FTXthDocNo',$tDocNo)->get('TCNTDocDTTmp')->num_rows();
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



    // Function: Clone From table Role To Trns For Document.
    // Parameters: tTableDocHD tApvCode tDocNo dDocDate tBchCodes
    // Creator: 22/01/2020 Nattakit(Nale)
    // LastUpdate: -
    // Return: 1,2
    // ReturnType: number
    public function FSaMRSFindBillSaleVDDocNo($paDataParamFilter){

        $tRSFrmBchCode = $paDataParamFilter['tRSFrmBchCode'];
        $tRSFrmShpCode = $paDataParamFilter['tRSFrmShpCode'];
        $tRSFrmPosCode = $paDataParamFilter['tRSFrmPosCode'];
        $tRSRefDocDate = $paDataParamFilter['tRSRefDocDate'];
        $tRSRefDocNo   = $paDataParamFilter['tRSRefDocNo'];
        $tRSSearchDocument = $paDataParamFilter['tRSSearchDocument'];
        $nLangEdit   = $paDataParamFilter['nLangEdit'];

        $tSqlWhere = " 1=1 AND HD.FNXshDocType = 1  AND ISNULL(HD.FTXshStaRefund,'') <> '2' ";

    if($tRSRefDocNo==''){

        if($tRSRefDocDate!=''){
            $tSqlWhere .= " AND CONVERT(VARCHAR(10),HD.FDXshDocDate,121) = '$tRSRefDocDate' "; 
        }

        if($tRSFrmBchCode!=''){
            $tSqlWhere .= " AND HD.FTBchCode= '$tRSFrmBchCode' "; 
        }

        if($tRSFrmShpCode!=''){
            $tSqlWhere .= " AND HD.FTShpCode= '$tRSFrmShpCode' "; 
        }

        
        if($tRSFrmPosCode!=''){
            $tSqlWhere .= " AND HD.FTPosCode= '$tRSFrmPosCode' "; 
        }

        if($tRSSearchDocument!=''){
            $tSqlWhere .= " AND ( HD.FTBchCode LIKE '%$tRSSearchDocument%' OR BCH_L.FTBchName LIKE '%$tRSSearchDocument%' OR POS_L.FTPosName LIKE '%$tRSSearchDocument%' OR HD.FTXshDocNo LIKE '%$tRSSearchDocument%' OR Cst_L.FTCstName LIKE '%$tRSSearchDocument%' ) "; 
        }
    
    }else{

        $tSqlWhere .= " AND HD.FTXshDocNo= '$tRSRefDocNo' "; 
    }

        $tSQL = "SELECT
                    HD.FTBchCode,
                    BCH_L.FTBchName,
                    HD.FTPosCode,
                    POS_L.FTPosName,
                    HD.FTShpCode,
                    SHP_L.FTShpName,
                    HD.FTXshDocNo,
                    HD.FDXshDocDate,	
                    HD.FTCstCode,
                    Cst_L.FTCstName,
                    HDRC.FTRteCode,
                    HDRC.FCXrcRteFac,
                    HDRC.FTRcvCode,
                    HDRC.FTRcvName
                FROM
                    TVDTSalHD HD WITH (NOLOCK)
                LEFT OUTER JOIN TCNMBranch_L BCH_L WITH (NOLOCK) ON HD.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLangEdit
                LEFT OUTER JOIN TCNMShop_L SHP_L WITH (NOLOCK) ON HD.FTBchCode = SHP_L.FTBchCode AND HD.FTShpCode = SHP_L.FTShpCode AND SHP_L.FNLngID = $nLangEdit
                LEFT OUTER JOIN TCNMPos_L POS_L WITH (NOLOCK) ON HD.FTBchCode = POS_L.FTBchCode AND HD.FTPosCode = POS_L.FTPosCode AND POS_L.FNLngID = $nLangEdit
                LEFT OUTER JOIN TCNMCst_L Cst_L WITH (NOLOCK) ON HD.FTCstCode = Cst_L.FTCstCode AND Cst_L.FNLngID = $nLangEdit
                LEFT OUTER JOIN ( SELECT  RC.FTBchCode,RC.FTXshDocNo, RC.FNXrcSeqNo,RC.FTRcvCode,RC.FTRcvName,RC.FTRteCode,RC.FCXrcRteFac FROM TVDTSalRC RC  ) HDRC ON HD.FTBchCode =  HDRC.FTBchCode AND  HD.FTXshDocNo =  HDRC.FTXshDocNo AND HDRC.FNXrcSeqNo = 1
                WHERE
                $tSqlWhere
                ";

                $oQuery = $this->db->query($tSQL);
                if($oQuery->num_rows() > 0){
                    $oDataList          = $oQuery->result_array();
                    $aDataReturn = array(
                        'tCode' => '1',
                        'aItems' => $oDataList ,
                    );
                }else{
                    $aDataReturn = array(
                        'tCode' => '2',
                        'aItems' => '' ,
                    );
                }

                return $aDataReturn;
    
    }


    public function FSaMRSFindBillSaleVDDetail($paDataParamFilter){

        $tRSRefDocNo   = $paDataParamFilter['tRSRefDocNo'];

        $tSQL = "     SELECT
                            DT.FTBchCode,
                            DT.FTXshDocNo,
                            DT.FNXsdSeqNo,
                            DT.FTPdtCode,
                            DT.FTXsdPdtName,
                            DT.FTPunCode,
                            PDTUNT_L.FTPunName,
                            DT.FCXsdQty,
                            DT.FCXsdAmtB4DisChg,
                            DT.FCXsdSetPrice,
                            DTDIS.FCXddValue,
                        DT.FCXsdNetAfHD
                        FROM
                            TVDTSalDT DT WITH (NOLOCK)
                        LEFT OUTER JOIN TCNMPdtUnit_L PDTUNT_L WITH (NOLOCK) ON DT.FTPunCode = PDTUNT_L.FTPunCode
                        AND PDTUNT_L.FNLngID = 1
                        LEFT OUTER JOIN (
                            SELECT
                                DTDis.FTBchCode,
                                DTDis.FTXshDocNo,
                                DTDis.FNXsdSeqNo,
                                SUM (
                                    CASE
                                    WHEN DTDis.FTXddDisChgType = 3
                                    OR DTDis.FTXddDisChgType = 4 THEN
                                        DTDis.FCXddValue * - 1
                                    ELSE
                                        DTDis.FCXddValue
                                    END
                                ) AS FCXddValue
                            FROM
                                TVDTSalDTDis DTDis
                            GROUP BY
                                DTDis.FTBchCode,
                                DTDis.FTXshDocNo,
                                DTDis.FNXsdSeqNo
                        ) DTDIS ON DT.FTBchCode = DTDis.FTBchCode
                        AND DT.FTXshDocNo = DTDis.FTXshDocNo
                        AND DT.FNXsdSeqNo = DTDis.FNXsdSeqNo
                        WHERE
                            DT.FTXshDocNo = '$tRSRefDocNo'
                        ORDER BY
                            DT.FNXsdSeqNo ASC
            ";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $oDataList          = $oQuery->result_array();
                $aDataReturn = array(
                    'tCode' => '1',
                    'aItems' => $oDataList ,
                );
            }else{
                $aDataReturn = array(
                    'tCode' => '2',
                    'aItems' => '' ,
                );
            }

            return $aDataReturn;

    }

    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSoMRSInsertDTBillToTemp($paParams){


        $tXthDocNo = $paParams['FTXthDocNo'];
        $tXthDocKey = $paParams['FTXthDocKey'];
        $tSessionID = $paParams['FTSessionID'];
        $tRSBchCode = $paParams['tRSBchCode'];
        $tRSRefDocNo = $paParams['tRSRefDocNo'];
        $tRSSelectPdt = $paParams['tRSSelectPdt'];
        $nLangEdit   = $paParams['nLangEdit'];

        $this->db->where('FTSessionID',$tSessionID)->where('FTXthDocNo',$tXthDocNo)->where('FTXthDocKey',$tXthDocKey)->delete('TCNTDocDTTmp');
            $tSQL = "INSERT INTO TCNTDocDTTmp (
                FTBchCode,FTXthDocNo,FNXtdSeqNo,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,FTXtdVatType,FTVatCode,FCXtdVatRate,FTXtdSaleType,FCXtdSalePrice,FCXtdQty,FCXtdQtyAll,FCXtdSetPrice,FCXtdAmtB4DisChg,
                  FTXtdDisChgTxt,FCXtdDis,FCXtdChg,FCXtdNet,FCXtdNetAfHD,FCXtdVat,FCXtdVatable,FCXtdWhtAmt,FTXtdWhtCode,FCXtdWhtRate,FCXtdCostIn,FCXtdCostEx,FCXtdQtyLef,FCXtdQtyRfn,FTXtdStaPrcStk,FTXtdStaAlwDis,
                  FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,FTXtdPdtStaSet,FTXtdRmk,FTSrnCode,FTXthDocKey,FTSessionID
              )
              SELECT
              DT.FTBchCode,
              '$tXthDocNo' AS FTXshDocNo,
              DT.FNXsdSeqNo,
              DT.FTPdtCode,
              DT.FTXsdPdtName,
              DT.FTPunCode,
              UNT_L.FTPunName,
              DT.FCXsdFactor,
              DT.FTXsdBarCode,
              DT.FTXsdVatType,
              DT.FTVatCode,
              DT.FCXsdVatRate,
              DT.FTXsdSaleType,
              DT.FCXsdSalePrice,
              DT.FCXsdQty,
              DT.FCXsdQtyAll,
              DT.FCXsdSetPrice,
              DT.FCXsdAmtB4DisChg,
              DT.FTXsdDisChgTxt,
              DT.FCXsdDis,
              DT.FCXsdChg,
              DT.FCXsdNet,
              DT.FCXsdNetAfHD,
              DT.FCXsdVat,
              DT.FCXsdVatable,
              DT.FCXsdWhtAmt,
              DT.FTXsdWhtCode,
              DT.FCXsdWhtRate,
              DT.FCXsdCostIn,
              DT.FCXsdCostEx,
              DT.FCXsdQtyLef,
              DT.FCXsdQtyRfn,
              DT.FTXsdStaPrcStk,
              DT.FTXsdStaAlwDis,
              DT.FNXsdPdtLevel,
              DT.FTXsdPdtParent,
              DT.FCXsdQtySet,
              DT.FTPdtStaSet,
              DT.FTXsdRmk,
              DT.FTSrnCode,
              '$tXthDocKey' AS FTXthDocKey,
              '$tSessionID' AS FTSessionID
              FROM
                  TVDTSalDT DT WITH (NOLOCK)
              LEFT JOIN TCNMPdtUnit_L UNT_L WITH (NOLOCK) ON DT.FTPunCode = UNT_L.FTPunCode AND UNT_L.FNLngID = $nLangEdit
              WHERE DT.FTBchCode = '$tRSBchCode' 
              AND DT.FTXshDocNo = '$tRSRefDocNo'
              AND DT.FNXsdSeqNo IN ('$tRSSelectPdt')
              ";

    //    echo $tSQL;
    //     die();
            $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'cannot Insert Item.',
                );
            }
            return $aStatus;


    }


    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSoMRSInsertDTDisBillToTemp($paParams){



        $tXthDocNo = $paParams['FTXthDocNo'];
        $tXthDocKey = $paParams['FTXthDocKey'];
        $tSessionID = $paParams['FTSessionID'];
        $tRSBchCode = $paParams['tRSBchCode'];
        $tRSRefDocNo = $paParams['tRSRefDocNo'];
        $tRSSelectPdt = $paParams['tRSSelectPdt'];

            $this->db->where('FTSessionID',$tSessionID)->delete('TCNTDocDTDisTmp');
            $tSQL = "INSERT INTO TCNTDocDTDisTmp (
                FTBchCode,FTXthDocNo,FNXtdSeqNo,FDXtdDateIns,FNXtdStaDis,FTXtdDisChgTxt,FTXtdDisChgType,
                FCXtdNet,FCXtdValue,FTDisCode,FTRsnCode,FTSessionID
              )
              SELECT
                DTDis.FTBchCode,
                '$tXthDocNo' AS FTXshDocNo,
                DTDis.FNXsdSeqNo,
                DTDis.FDXddDateIns,
                DTDis.FNXddStaDis,
                DTDis.FTXddDisChgTxt,
                DTDis.FTXddDisChgType,
                DTDis.FCXddNet,
                DTDis.FCXddValue,
                DTDis.FTDisCode,
                DTDis.FTRsnCode,
                '$tSessionID' AS FTSessionID
                FROM TVDTSalDTDis DTDis WITH (NOLOCK)
                WHERE DTDis.FTBchCode = '$tRSBchCode' 
                AND DTDis.FTXshDocNo = '$tRSRefDocNo'
                AND DTDis.FNXsdSeqNo IN ('$tRSSelectPdt')
              ";


            $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'cannot Insert Item.',
                );
            }
            return $aStatus;

    }


    
    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSoMRSInsertHDDisBillToTemp($paParams){



        $tXthDocNo = $paParams['FTXthDocNo'];
        $tXthDocKey = $paParams['FTXthDocKey'];
        $tSessionID = $paParams['FTSessionID'];
        $tRSBchCode = $paParams['tRSBchCode'];
        $tRSRefDocNo = $paParams['tRSRefDocNo'];
        $tRSSelectPdt = $paParams['tRSSelectPdt'];

            $this->db->where('FTSessionID',$tSessionID)->delete('TCNTDocHDDisTmp');
            $tSQL = "INSERT INTO TCNTDocHDDisTmp (
                FTBchCode,FTXthDocNo,FDXtdDateIns,FTXtdDisChgTxt,FTXtdDisChgType,FCXtdTotalAfDisChg,
                FCXtdDisChg,FCXtdAmt,FTDisCode,FTRsnCode,FTSessionID
              )
              SELECT
                HDDis.FTBchCode,
                '$tXthDocNo' AS FTXshDocNo,
                HDDis.FDXhdDateIns,
                HDDis.FTXhdDisChgTxt,
                HDDis.FTXhdDisChgType,
                HDDis.FCXhdTotalAfDisChg,
                HDDis.FCXhdDisChg,
                HDDis.FCXhdAmt,
                HDDis.FTDisCode,
                HDDis.FTRsnCode,
                '$tSessionID' AS FTSessionID
                FROM TVDTSalHDDis HDDis WITH (NOLOCK)
                WHERE HDDis.FTBchCode = '$tRSBchCode' 
                AND HDDis.FTXshDocNo = '$tRSRefDocNo'
              ";

    //    echo $tSQL;
    //     die();
            $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'cannot Insert Item.',
                );
            }
            return $aStatus;

    }

    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSaMRSFindWahouseDefaultByShop($paParam){

        $tRSBchCode = $paParam['tRSBchCode'];
        $tRSShpCode = $paParam['tRSShpCode'];

                $tSQL ="SELECT
                            TOP 1 SHPWAH.FTWahCode,
                            WHAL.FTWahName
                        FROM
                            TCNMShpWah SHPWAH WITH (NOLOCK)
                        LEFT OUTER JOIN TCNMWaHouse_L WHAL WITH (NOLOCK) ON SHPWAH.FTBchCode = WHAL.FTBchCode
                        AND SHPWAH.FTWahCode = WHAL.FTWahCode
                        AND WHAL.FNLngID = 1
                        WHERE
                            SHPWAH.FTBchCode = '$tRSBchCode'
                        AND SHPWAH.FTShpCode = '$tRSShpCode'
                        ORDER BY
                            SHPWAH.FTWahCode ASC";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->row_array();
            $aDataReturn = array(
                'tCode' => '1',
                'aItems' => $oDataList ,
            );
        }else{
            $aDataReturn = array(
                'tCode' => '2',
                'aItems' => '' ,
            );
        }

        return $aDataReturn;

    }

    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSaMRSGetDataRefDocHD($paDataParam){

        $tXshBchCode = $paDataParam['tXshBchCode'];
        $tXshRefInt = $paDataParam['tXshRefInt'];

        $tSQL ="SELECT
                        HD.FTBchCode,
                        HD.FTXshDocNo,
                        HD.FTShpCode,
                        HD.FNXshDocType,
                        HD.FDXshDocDate,
                        HD.FTXshCshOrCrd,
                        HD.FTXshVATInOrEx,
                        HD.FTDptCode,
                        HD.FTWahCode,
                        HD.FTPosCode,
                        HD.FTShfCode,
                        HD.FNSdtSeqNo,
                        HD.FTUsrCode,
                        HD.FTSpnCode,
                        HD.FTXshApvCode,
                        HD.FTCstCode,
                        HD.FTXshDocVatFull,
                        HD.FTXshRefExt,
                        HD.FDXshRefExtDate,
                        HD.FTXshRefInt,
                        HD.FDXshRefIntDate,
                        HD.FTXshRefAE,
                        HD.FNXshDocPrint,
                        HD.FTRteCode,
                        HD.FCXshRteFac,
                        HD.FCXshTotal,
                        HD.FCXshTotalNV,
                        HD.FCXshTotalNoDis,
                        HD.FCXshTotalB4DisChgV,
                        HD.FCXshTotalB4DisChgNV,
                        HD.FTXshDisChgTxt,
                        HD.FCXshDis,
                        HD.FCXshChg,
                        HD.FCXshTotalAfDisChgV,
                        HD.FCXshTotalAfDisChgNV,
                        HD.FCXshRefAEAmt,
                        HD.FCXshAmtV,
                        HD.FCXshAmtNV,
                        HD.FCXshVat,
                        HD.FCXshVatable,
                        HD.FTXshWpCode,
                        HD.FCXshWpTax,
                        HD.FCXshGrand,
                        HD.FCXshRnd,
                        HD.FTXshGndText,
                        HD.FCXshPaid,
                        HD.FCXshLeft,
                        HD.FTXshRmk,
                        HD.FTXshStaRefund,
                        HD.FTXshStaDoc,
                        HD.FTXshStaApv,
                        HD.FTXshStaPrcStk,
                        HD.FTXshStaPaid,
                        HD.FNXshStaDocAct,
                        HD.FNXshStaRef,
                        HD.FTRsnCode,
                        HD.FTXshAppVer
                        FROM TVDTSalHD HD
                        WHERE HD.FTBchCode = '$tXshBchCode'
                        AND HD.FTXshDocNo = '$tXshRefInt' ";

         $oQuery =$this->db->query($tSQL);


            if($oQuery->num_rows() > 0){
                $oDataList          = $oQuery->row_array();
                $aDataReturn = array(
                    'tCode' => '1',
                    'aItems' => $oDataList ,
                );
            }else{
                $aDataReturn = array(
                    'tCode' => '2',
                    'aItems' => '' ,
                );
            }
    
            return $aDataReturn;

    }


    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSaMRSGetDataRefDocHDCst($paDataParam){
        
        $tXshBchCode = $paDataParam['tXshBchCode'];
        $tXshRefInt = $paDataParam['tXshRefInt'];

        $tSQL = "SELECT
        HDCst.FTBchCode,
        HDCst.FTXshDocNo,
        HDCst.FTXshCardID,
        HDCst.FTXshCstTel,
        HDCst.FTXshCstName,
        HDCst.FTXshCardNo,
        HDCst.FNXshCrTerm,
        HDCst.FDXshDueDate,
        HDCst.FDXshBillDue,
        HDCst.FTXshCtrName,
        HDCst.FDXshTnfDate,
        HDCst.FTXshRefTnfID,
        HDCst.FNXshAddrShip,
        HDCst.FNXshAddrTax
        FROM TVDTSalHDCst HDCst
        WHERE HDCst.FTBchCode = '$tXshBchCode'
        AND HDCst.FTXshDocNo = '$tXshRefInt' ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->row_array();
            $aDataReturn = array(
                'tCode' => '1',
                'aItems' => $oDataList ,
            );
        }else{
            $aDataReturn = array(
                'tCode' => '2',
                'aItems' => '' ,
            );
        }

        return $aDataReturn;

    }



    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSaMRSGetDataRefDocDT($paDataParam){
        
        $tXshBchCode = $paDataParam['tXshBchCode'];
        $tXshRefInt = $paDataParam['tXshRefInt'];
        $nXsdSeqNo = $paDataParam['nXsdSeqNo'];

        $tSQL = "SELECT
        DT.FTBchCode,
        DT.FTXshDocNo,
        DT.FNXsdSeqNo,
        DT.FTPdtCode,
        DT.FTXsdPdtName,
        DT.FTPunCode,
        DT.FTPunName,
        DT.FCXsdFactor,
        DT.FTXsdBarCode,
        DT.FTSrnCode,
        DT.FTXsdVatType,
        DT.FTVatCode,
        DT.FCXsdVatRate,
        DT.FTXsdSaleType,
        DT.FCXsdSalePrice,
        DT.FCXsdQty,
        DT.FCXsdQtyAll,
        DT.FCXsdSetPrice,
        DT.FCXsdAmtB4DisChg,
        DT.FTXsdDisChgTxt,
        DT.FCXsdDis,
        DT.FCXsdChg,
        DT.FCXsdNet,
        DT.FCXsdNetAfHD,
        DT.FCXsdVat,
        DT.FCXsdVatable,
        DT.FCXsdWhtAmt,
        DT.FTXsdWhtCode,
        DT.FCXsdWhtRate,
        DT.FCXsdCostIn,
        DT.FCXsdCostEx,
        DT.FTXsdStaPdt,
        DT.FCXsdQtyLef,
        DT.FCXsdQtyRfn,
        DT.FTXsdStaPrcStk,
        DT.FTXsdStaAlwDis,
        DT.FNXsdPdtLevel,
        DT.FTXsdPdtParent,
        DT.FCXsdQtySet,
        DT.FTPdtStaSet,
        DT.FTXsdRmk,
        DT.FDLastUpdOn,
        DT.FTLastUpdBy,
        DT.FDCreateOn,
        DT.FTCreateBy
        FROM TVDTSalDT DT
        WHERE DT.FTBchCode = '$tXshBchCode'
        AND DT.FTXshDocNo = '$tXshRefInt'
        AND DT.FNXsdSeqNo = '$nXsdSeqNo' ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->row_array();
            $aDataReturn = array(
                'tCode' => '1',
                'aItems' => $oDataList ,
            );
        }else{
            $aDataReturn = array(
                'tCode' => '2',
                'aItems' => '' ,
            );
        }

        return $aDataReturn;

    }

    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSaMRSGetDataForMQReturnSale($paData){

       $tXshDocNo =  $paData['FTXshDocNo'];
       $tBchCode =  $paData['FTBchCode'];

       $aoTVDTSalHD =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalHD')->result_array();
       $aoTVDTSalHDCst =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalHDCst')->result_array();
       $aoTVDTSalHDDis =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalHDDis')->result_array();
       $aoTVDTSalDT =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalDT')->result_array();
       $aoTVDTSalDTDis =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalDTDis')->result_array();
       $aoTVDTSalDTVD =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalDTVD')->result_array();
       $aoTVDTSalRC =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalRC')->result_array();
       $aoTVDTSalHDPatient =  $this->db->where('FTBchCode',$tBchCode)->where('FTXshDocNo',$tXshDocNo)->get('TVDTSalHDPatient')->result_array();

       $aDataReturn = array(
           'aoTVDTSalHD' => $aoTVDTSalHD,
           'aoTVDTSalHDCst' => $aoTVDTSalHDCst,
           'aoTVDTSalHDDis' => $aoTVDTSalHDDis,
           'aoTVDTSalDT' => $aoTVDTSalDT,
           'aoTVDTSalDTDis' => $aoTVDTSalDTDis,
           'aoTVDTSalDTVD' => $aoTVDTSalDTVD,
           'aoTVDTSalRC' => $aoTVDTSalRC,
           'aoTVDTSalHDPatient' => $aoTVDTSalHDPatient,
       );
       return $aDataReturn;

    }

    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSaMRSGetDataWahHouse($paParam){

        $tBchCode = $paParam['tBchCode'];
        $tWahCode = $paParam['tWahCode'];

         $aDataWahouse =  $this->db->where('FTBchCode',$tBchCode)->where('FTWahCode',$tWahCode)->get('TCNMWaHouse')->row_array();

         return $aDataWahouse;
    }


    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSxMRSUpdateRefIntToHD($ptXshRefInt){
        // TVDTSalHD
        $dLastUpdOn = date('Y-m-d H:i:s');
        $tLastUpdBy = $this->session->userdata('tSesUsername');

        $this->db->set('FDLastUpdOn',$dLastUpdOn);
        $this->db->set('FTLastUpdBy',$tLastUpdBy);
        $this->db->set('FTXshStaRefund','2');
        $this->db->where('FTXshDocNo',$ptXshRefInt);
        $this->db->update('TVDTSalHD');
    }
}