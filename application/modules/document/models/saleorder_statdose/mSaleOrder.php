<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSaleOrder extends CI_Model {

    // Functionality: Get Data Purchase Invoice HD List
    // Parameters: function parameters
    // Creator:  19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMSOGetDataTableList($paDataCondition){
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
        // $tSearchStaApprove  = $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrc      = $aAdvanceSearch['tSearchStaPrc'];
        $tSearchStaDocAct   = $aAdvanceSearch['tSearchStaDocAct'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FTBchCode,FTXshDocNo DESC) AS FNRowID,* FROM
                                (   SELECT DISTINCT
                                        SOHD.FTBchCode,
                                        BCHL.FTBchName,
                                        SOHD.FTXshDocNo,
                                        CONVERT(CHAR(10),SOHD.FDXshDocDate,103) AS FDXshDocDate,
                                        CONVERT(CHAR(5), SOHD.FDXshDocDate,108) AS FTXshDocTime,
                                        SOHD.FTXshStaDoc,
                                        SOHD.FTXshStaApv,
                                        SOHD.FTXshStaPrcDoc,
                                        SOHD.FTCreateBy,
                                        USRL.FTUsrName      AS FTCreateByName,
                                        SOHD.FTXshApvCode,
                                        USRLAPV.FTUsrName   AS FTXshApvName
                                    FROM TARTSoHD           SOHD    WITH (NOLOCK)
                                    LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON SOHD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON SOHD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                                    LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON SOHD.FTXshApvCode  = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                                WHERE 1=1
        ";

        // Check User Login Branch
        // if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
        //     $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
        //     $tSQL   .= " AND SOHD.FTBchCode = '$tUserLoginBchCode' ";
        // }

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND SOHD.FTBchCode IN ($tBchCode)
            ";
        }

        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .= " AND SOHD.FTShpCode = '$tUserLoginShpCode' ";
        }

        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((SOHD.FTXshDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),SOHD.FDXshDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((SOHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (SOHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((SOHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (SOHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND SOHD.FTXshStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND (ISNULL(SOHD.FTXshStaApv,'') = '' OR SOHD.FTXshStaApv = '$tSearchStaDoc') AND SOHD.FTXshStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND SOHD.FTXshStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        if(isset($tSearchStaPrc) && !empty($tSearchStaPrc)){
            if ($tSearchStaPrc == 3) {
                $tSQL .= " AND (SOHD.FTXshStaPrcDoc = '$tSearchStaPrc' OR ISNULL(SOHD.FTXshStaPrcDoc,'') = '') ";
            } else {
                $tSQL .= " AND SOHD.FTXshStaPrcDoc = '$tSearchStaPrc'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        if (isset($tSearchStaDocAct) && !empty($tSearchStaDocAct)) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND SOHD.FNXshStaDocAct = 1";
            } else {
                $tSQL .= " AND SOHD.FNXshStaDocAct = 0";
            }
        }
        $tSQL   .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        // echo $tSQL;
        // exit();
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMSOCountPageDocListAll($paDataCondition);
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
    public function FSnMSOCountPageDocListAll($paDataCondition){
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
        // $tSearchStaApprove  = $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrc      = $aAdvanceSearch['tSearchStaPrc'];
        $tSearchStaDocAct   = $aAdvanceSearch['tSearchStaDocAct'];

        $tSQL   =   "   SELECT COUNT (SOHD.FTXshDocNo) AS counts
                        FROM TARTSoHD SOHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON SOHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        WHERE 1=1
                    ";

        // Check User Login Branch
        // if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
        //     $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
        //     $tSQL   .= " AND SOHD.FTBchCode = '$tUserLoginBchCode' ";
        // }

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND SOHD.FTBchCode IN ($tBchCode)
            ";
        }
        
        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .= " AND SOHD.FTShpCode = '$tUserLoginShpCode' ";
        }
        
        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((SOHD.FTXshDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),SOHD.FDXshDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((SOHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (SOHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((SOHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (SOHD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND SOHD.FTXshStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND (ISNULL(SOHD.FTXshStaApv,'') = '' OR SOHD.FTXshStaApv = '$tSearchStaDoc') AND SOHD.FTXshStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND SOHD.FTXshStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        if(isset($tSearchStaPrc) && !empty($tSearchStaPrc)){
            if ($tSearchStaPrc == 3) {
                $tSQL .= " AND (SOHD.FTXshStaPrcDoc = '$tSearchStaPrc' OR ISNULL(SOHD.FTXshStaPrcDoc,'') = '') ";
            } else {
                $tSQL .= " AND SOHD.FTXshStaPrcDoc = '$tSearchStaPrc'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        if (isset($tSearchStaDocAct) && !empty($tSearchStaDocAct)) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND SOHD.FNXshStaDocAct = 1";
            } else {
                $tSQL .= " AND SOHD.FNXshStaDocAct = 0";
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
    public function FSnMSODelDocument($paDataDoc){
        $tDataDocNo = $paDataDoc['tDataDocNo'];
        $this->db->trans_begin();

        // Document HD
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TARTSoHD');

        // Document HD Cst
       $this->db->where_in('FTXshDocNo',$tDataDocNo);
       $this->db->delete('TARTSoHDCst');

        // Document HD Discount
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TARTSoHDDis');
        
        // Document DT
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TARTSoDT');

        // Document DT Discount
        $this->db->where_in('FTXshDocNo',$tDataDocNo);
        $this->db->delete('TARTSoDTDis');


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
    public function FSxMSOClearDataInDocTemp($paWhereClearTemp){
        $tSODocNo       = $paWhereClearTemp['FTXthDocNo'];
        $tSODocKey      = $paWhereClearTemp['FTXthDocKey'];
        $tSOSessionID   = $paWhereClearTemp['FTSessionID'];

        // Query Delete DocTemp
        $tClearDocTemp  =   "   DELETE FROM TCNTDocDTTmp 
                                WHERE 1=1 
                                AND TCNTDocDTTmp.FTXthDocNo     = '$tSODocNo'
                                AND TCNTDocDTTmp.FTXthDocKey    = '$tSODocKey'
                                AND TCNTDocDTTmp.FTSessionID    = '$tSOSessionID'
        ";
        $this->db->query($tClearDocTemp);


        // Query Delete Doc HD Discount Temp
        $tClearDocHDDisTemp =   "   DELETE FROM TCNTDocHDDisTmp
                                    WHERE 1=1
                                    AND TCNTDocHDDisTmp.FTXthDocNo  = '$tSODocNo'
                                    AND TCNTDocHDDisTmp.FTSessionID = '$tSOSessionID'
        ";
        $this->db->query($tClearDocHDDisTemp);

        // Query Delete Doc DT Discount Temp
        $tClearDocDTDisTemp =   "   DELETE FROM TCNTDocDTDisTmp
                                    WHERE 1=1
                                    AND TCNTDocDTDisTmp.FTXthDocNo  = '$tSODocNo'
                                    AND TCNTDocDTDisTmp.FTSessionID = '$tSOSessionID'
        ";
        $this->db->query($tClearDocDTDisTemp);
    
    }

    // Functionality: Get ShopCode From User Login
    // Parameters: function parameters
    // Creator: 24/06/2018 wasin (Yoshi AKA: Mr.JW)
    // Last Modified: -
    // Return: Array Data Shop For User Login
    // ReturnType: array
    public function FSaMSOGetShpCodeForUsrLogin($paDataShp){
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
                        LEFT JOIN TCNMShop          SHP     WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode  AND UGP.FTBchCode = SHP.FTBchCode
                        LEFT JOIN TCNMShop_L        SHPL    WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMMerchant		MER		WITH (NOLOCK) ON SHP.FTMerCode = MER.FTMerCode
                        LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK) ON SHP.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAHL    WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode AND SHP.FTBchCode = WAHL.FTBchCode
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
    public function FSaMSOGetDefOptionConfigWah($paConfigSys){
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
                        AND SYSCON.FTSysSeq     = $nSysSeq";
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

    //Get Data In Doc DT Temp
    public function FSaMSOGetDocDTTempListPage($paDataWhere){
        $tSODocNo           = $paDataWhere['FTXthDocNo'];
        $tSODocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tWahCode           = @$paDataWhere['tWahCode'];
        $tSOSesSessionID    = $this->session->userdata('tSesSessionID');
        $aRowLen            = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tSQL               = '';

        //มีคลัง
        if($tWahCode != '' || $tWahCode != null){
            $tSQL .= " SELECT S.* FROM ( ";
        }

        $tSQL   .= " SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM ( 
                            SELECT ";
        //มีคลัง
        if($tWahCode != '' || $tWahCode != null){
            $tSQL .= "  row_number() OVER(PARTITION BY LPDT.FTPdtCode order by  LPDT.FTPdtCode ASC) AS GroupPDT,
                        LPDT.FTWahCode , ";
        }

        $tSQL   .= "    DOCTMP.FTXtdStaPrcStk as FTXsdStaPrcStk,
                            DOCTMP.FTBchCode,
                            DOCTMP.FTXthDocNo,
                            DOCTMP.FNXtdSeqNo,
                            DOCTMP.FTXthDocKey,
                            DOCTMP.FTPdtCode,
                            IMGPDT.FTImgObj,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTPunName,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FTPunCode,
                            DOCTMP.FCXtdFactor,
                            DOCTMP.FCXtdQty,
                            DOCTMP.FCXtdSetPrice,
                            DOCTMP.FCXtdAmtB4DisChg,
                            DISTMP.FTXtdDisChgTxt,
                            DOCTMP.FCXtdNet,
                            DOCTMP.FCXtdNetAfHD,
                            DOCTMP.FTXtdStaAlwDis,
                            DOCTMP.FDLastUpdOn,
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTLastUpdBy,
                            DOCTMP.FTCreateBy,
                            DOCTMP.FCXtdVatRate,
                            DOCTMP.FTXtdVatType
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        LEFT JOIN TCNMImgPdt IMGPDT on DOCTMP.FTPdtCode = IMGPDT.FTImgRefID AND IMGPDT.FTImgTable='TCNMPdt' 
                        LEFT JOIN (
                            SELECT 
                                Main.FNXtdSeqNo,
                                LEFT(Main.FTXtdDisChgTxt,Len(Main.FTXtdDisChgTxt)-1) As FTXtdDisChgTxt
                            FROM
                                (
                                    SELECT DISTINCT ST2.FNXtdSeqNo, 
                                        (
                                            SELECT ST1.FTXtdDisChgTxt + ',' AS [text()]
                                            FROM TCNTDocDTDisTmp ST1
                                            WHERE ST1.FNXtdSeqNo = ST2.FNXtdSeqNo
                                            AND ST1.FTXthDocNo  = '$tSODocNo'
                                            AND ST1.FTSessionID = '$tSOSesSessionID'
                                            FOR XML PATH ('')
                                        ) [FTXtdDisChgTxt]
                                    FROM TCNTDocDTDisTmp ST2
                                    WHERE 1 = 1
                                    AND ST2.FTXthDocNo  = '$tSODocNo'
                                    AND ST2.FTSessionID = '$tSOSesSessionID'
                                ) [Main]
                        ) DISTMP ON DOCTMP.FNXtdSeqNo = DISTMP.FNXtdSeqNo
                   ";

        //มีคลัง
        if($tWahCode != '' || $tWahCode != null){
            $tSQL .= "  LEFT JOIN TARTSoHD HD on HD.FTXshDocNo = DOCTMP.FTXthDocNo 
                        LEFT JOIN TVDMPdtLayout LPDT on DOCTMP.FTPdtCode = LPDT.FTPdtCode
                        AND DOCTMP.FTBchCode = LPDT.FTBchCode 
                        AND HD.FTShpCode = LPDT.FTShpCode ";
        }
        $tSQL .= " WHERE 1 = 1
                                AND DOCTMP.FTXthDocNo  = '$tSODocNo'
                                AND DOCTMP.FTXthDocKey = '$tSODocKey'
                                AND DOCTMP.FTSessionID = '$tSOSesSessionID' ";
                                
        if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
            $tSQL   .=  "AND (
                        DOCTMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                        OR DOCTMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                        OR DOCTMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                        OR DOCTMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%' ) ";
            
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        //มีคลัง
        if($tWahCode != '' || $tWahCode != null){
            $tSQL .= "  ) S WHERE S.GroupPDT = 1 AND S.FTWahCode = '$tWahCode' ";
        }

        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMSOGetDocDTTempListPageAll($paDataWhere);
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
    public function FSaMSOGetDocDTTempListPageAll($paDataWhere){
        $tSODocNo           = $paDataWhere['FTXthDocNo'];
        $tSODocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tSOSesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP
                    WHERE 1 = 1 ";
        
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tSODocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tSODocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tSOSesSessionID' ";

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
    public function FSaMSOSumDocDTTemp($paDataWhere){
        $tSODocNo           = $paDataWhere['FTXthDocNo'];
        $tSODocKey          = $paDataWhere['FTXthDocKey'];
        $tSOSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL               = " SELECT
                                    SUM(FCXtdNetAfHD)       AS FCXtdSumNetAfHD,
                                    SUM(FCXtdAmtB4DisChg)   AS FCXtdSumAmtB4DisChg
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tSODocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tSODocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tSOSesSessionID' ";
        
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
    public function FSaMSOGetMaxSeqDocDTTemp($paDataWhere){
        $tSOBchCode         = $paDataWhere['FTBchCode'];
        $tSODocNo           = $paDataWhere['FTXthDocNo'];
        $tSODocKey          = $paDataWhere['FTXthDocKey'];
        $tSOSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL   =   "   SELECT 
                            MAX(DOCTMP.FNXtdSeqNo) AS rnMaxSeqNo
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTBchCode   = '$tSOBchCode'";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tSODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tSODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tSOSesSessionID'";
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
    public function FSaMSOGetDataPdt($paDataPdtParams){
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
                            ISNULL(PRI4PDT.FCPgdPriceRet,0) AS FTPdtSalePrice,
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
                        LEFT JOIN (
                            SELECT DISTINCT
                                P4PDT.FTPdtCode,
                                P4PDT.FTPunCode,
                                P4PDT.FDPghDStart,
                                P4PDT.FTPghTStart,
                                P4PDT.FCPgdPriceRet
                            FROM TCNTPdtPrice4PDT P4PDT WITH (NOLOCK)
                            WHERE 1=1
                            AND (CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121))
                            AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121))
                        ) AS PRI4PDT
                        ON PDT.FTPdtCode = PRI4PDT.FTPdtCode AND PRI4PDT.FTPunCode = PKS.FTPunCode
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
    public function FSaMSOInsertPDTToTemp($paDataPdtMaster,$paDataPdtParams){
        $paPIDataPdt    = $paDataPdtMaster['raItem'];
        if($paDataPdtParams['tSOOptionAddPdt'] == 1){
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
                            ORDER BY FNXtdSeqNo";
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
                                    AND FTXtdBarCode    = '".$paPIDataPdt["FTBarCode"]."' ";
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
                    'FTVatCode'         => $paPIDataPdt['FTVatCode'],
                    'FCXtdVatRate'      => $paPIDataPdt['FCVatRate'],
                    'FTXtdStaAlwDis'    => $paPIDataPdt['FTPdtStaAlwDis'],
                    'FTXtdSaleType'     => $paPIDataPdt['FTPdtSaleType'],
                    'FCXtdSalePrice'    => $paPIDataPdt['FTPdtSalePrice'],
                    'FCXtdQty'          => 1,
                    'FCXtdQtyAll'       => 1*$paPIDataPdt['FCPdtUnitFact'],
                    'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                    'FTSessionID'       => $paDataPdtParams['tSessionID'],
                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                );
                $this->db->insert('TCNTDocDTTmp',$aDataInsert);

                $this->db->last_query();  
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
                'FTVatCode'         => $paPIDataPdt['FTVatCode'],
                'FCXtdVatRate'      => $paPIDataPdt['FCVatRate'],
                'FTXtdStaAlwDis'    => $paPIDataPdt['FTPdtStaAlwDis'],
                'FTXtdSaleType'     => $paPIDataPdt['FTPdtSaleType'],
                'FCXtdSalePrice'    => $paPIDataPdt['FTPdtSalePrice'],
                'FCXtdQty'          => 1,
                'FCXtdQtyAll'       => 1*$paPIDataPdt['FCPdtUnitFact'],
                'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                'FTSessionID'       => $paDataPdtParams['tSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            );
            $this->db->insert('TCNTDocDTTmp',$aDataInsert);
            $this->db->last_query();  
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
    public function FSaMSOUpdateInlineDTTemp($paDataUpdateDT,$paDataWhere){
        $this->db->set('FCXtdQty', $paDataUpdateDT['FCXtdQty']);
        $this->db->set('FCXtdSetPrice', $paDataUpdateDT['FCXtdSetPrice']);
        $this->db->set('FCXtdNet', $paDataUpdateDT['FCXtdNet']);

        $this->db->where('FTSessionID',$paDataWhere['tSOSessionID']);
        $this->db->where('FTXthDocKey',$paDataWhere['tDocKey']);
        $this->db->where('FNXtdSeqNo',$paDataWhere['nSOSeqNo']);
        $this->db->where('FTXthDocNo',$paDataWhere['tSODocNo']);
        $this->db->where('FTBchCode',$paDataWhere['tSOBchCode']);
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
            // $this->db->set($paDataUpdateDT['tSOFieldName'], $paDataUpdateDT['tSOValue']);
            // $this->db->where('FTSessionID',$paDataWhere['tSOSessionID']);
            // $this->db->where('FTXthDocKey',$paDataWhere['tDocKey']);
            // $this->db->where('FNXtdSeqNo',$paDataWhere['nSOSeqNo']);
            // $this->db->where('FTXthDocNo',$paDataWhere['tSODocNo']);
            // $this->db->where('FTBchCode',$paDataWhere['tSOBchCode']);
            // $this->db->update('TCNTDocDTTmp');
            // if($this->db->affected_rows() > 0){
            //     $aStatus = array(
            //         'rtCode'    => '1',
            //         'rtDesc'    => 'Update Success',
            //     );
            // }else{
            //     $aStatus = array(
            //         'rtCode'    => '903',
            //         'rtDesc'    => 'Update Fail',
            //     );
            // }
            // return $aStatus;
    }

    // Functionality : Count Check Data Product In Doc DT Temp Before Save
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Count
    // Return Type : array
    public function FSnMSOChkPdtInDocDTTemp($paDataWhere){
        $tSODocNo       = $paDataWhere['FTXthDocNo'];
        $tSODocKey      = $paDataWhere['FTXthDocKey'];
        $tSOSessionID   = $paDataWhere['FTSessionID'];
        $tSQL           = " SELECT
                                COUNT(FNXtdSeqNo) AS nCountPdt
                            FROM TCNTDocDTTmp DocDT
                            WHERE 1=1
                            AND DocDT.FTXthDocNo    = '$tSODocNo'
                            AND DocDT.FTXthDocKey   = '$tSODocKey'
                            AND DocDT.FTSessionID   = '$tSOSessionID' ";                            
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
    public function FSnMSODelPdtInDTTmp($paDataWhere){
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
    public function FSnMSODelMultiPdtInDTTmp($paDataWhere){
        $tSessionID = $this->session->userdata('tSesSessionID');

        // Delete Doc DT Temp
        $this->db->where_in('FTSessionID',$tSessionID);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['aDataSeqNo']);
        $this->db->where_in('FTPunCode',$paDataWhere['aDataPunCode']);
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
    public function FSaMSOCalInDTTemp($paParams){
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
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
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
                                    /* ยอดรวมเฉพาะภาษี */
                                    (
                                        (
                                            /* ยอดรวม */
                                            SUM(DTTMP.FCXtdNet)
                                            - 
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
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
                                            /* ยอดรวมหลังลด และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                    -
                                    /* ยอดภาษี */
                                    SUM(ISNULL(DTTMP.FCXtdVat, 0))	
                                )
                                +
                                (
                                    /* ยอดรวมเฉพาะไม่มีภาษี */
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
    public function FSaMSOCalInHDDisTemp($paParams){
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
    public function FSxMSOAddUpdateHD($paDataMaster,$paDataWhere,$paTableAddUpdate){

        // Get Data
        $aDataGetDataHD     =   $this->FSaMSOGetDataDocHD(array(
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
        // Delete PI HD
        $this->db->where_in('FTBchCode',$aDataAddUpdateHD['FTBchCode']);
        $this->db->where_in('FTXshDocNo',$aDataAddUpdateHD['FTXshDocNo']);
        $this->db->delete($paTableAddUpdate['tTableHD']);

        // Insert PI HD Dis
        $this->db->insert($paTableAddUpdate['tTableHD'],$aDataAddUpdateHD);

        return;
    }

    // Functionality : Add/Update Data HD Cst
    // Parameters : function parameters
    // Creator : 21/01/2020 nattakit(Nale)
    // Last Modified : -
    // Return : Array Status Add/Update Document HD Cst
    // Return Type : array
    public function FSxMSOAddUpdateHDCst($paDataMaster,$paDataWhere,$paTableAddUpdate){
        // Get Data SO HD
        $aDataGetDataHD     =   $this->FSaMSOGetDataDocHD(array(
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
                'FTXshCstTel'   => $paDataMaster['FTXshCstTel'],

            );
        }else{
            $aDataAddUpdateHD   = array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
                'FTXshCardID'   => $paDataMaster['FTXshCardID'],
                'FTXshCstName'   => $paDataMaster['FTXshCstName'],
                'FTXshCstTel'   => $paDataMaster['FTXshCstTel'],
            );
        }
        // Delete SO HD
        $this->db->where_in('FTBchCode',$aDataAddUpdateHD['FTBchCode']);
        $this->db->where_in('FTXshDocNo',$aDataAddUpdateHD['FTXshDocNo']);
        $this->db->delete($paTableAddUpdate['tTableHDCst']);

        // Insert SO HD Cst
        $this->db->insert($paTableAddUpdate['tTableHDCst'],$aDataAddUpdateHD);
        return;
    }

    // Functionality : Add/Update Data HD Supplier
    // Parameters : Controller function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Add/Update Document Supplier
    // Return Type : array
    public function FSxMSOAddUpdateHDSpl($paDataHDSpl,$paDataWhere,$paTableAddUpdate){
        // Get Data PI HD
        $aDataGetDataSpl    =   $this->FSaMSOGetDataDocHDSpl(array(
            'FTXthDocNo'    => $paDataWhere['FTXshDocNo'],
            'FNLngID'       => $this->session->userdata("tLangEdit")
        ));

        $aDataAddUpdateHDSpl    = array();
        if(isset($aDataAddUpdateHDSpl['rtCode']) && $aDataAddUpdateHDSpl['rtCode'] == 1){
            $aDataHDSplOld  = $aDataGetDataSpl['raItems'];
            $aDataAddUpdateHDSpl    = array_merge($paDataHDSpl,array(
                'FTBchCode'     => $aDataGetDataSpl['FTBchCode'],
                'FTXshDocNo'    => $aDataGetDataSpl['FTXshDocNo'],
            ));
        }else{
            $aDataAddUpdateHDSpl    = array_merge($paDataHDSpl,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshDocNo'    => $paDataWhere['FTXshDocNo'],
            ));
        }

        // Delete PI HD Spl
        $this->db->where_in('FTBchCode',$aDataAddUpdateHDSpl['FTBchCode']);
        $this->db->where_in('FTXshDocNo',$aDataAddUpdateHDSpl['FTXshDocNo']);
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
    public function FSxMSOAddUpdateDocNoToTemp($paDataWhere,$paTableAddUpdate){
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
    public function FSaMSOMoveHdDisTempToHdDis($paDataWhere,$paTableAddUpdate){
        $tSODocNo       = $paDataWhere['FTXshDocNo'];
        $tSOBchCode     = $paDataWhere['FTBchCode'];
        $tSOSessionID   = $this->session->userdata('tSesSessionID');
        if(isset($tSODocNo) && !empty($tSODocNo)){
            $this->db->where_in('FTXshDocNo',$tSODocNo);
            $this->db->where_in('FTBchCode',$tSOBchCode);
            $this->db->delete($paTableAddUpdate['tTableHDDis']);
        }
        $tSQL   =   "   INSERT INTO ".$paTableAddUpdate['tTableHDDis']." (
                            FTBchCode,FTXshDocNo,FDXhdDateIns,FTXhdDisChgTxt,FTXhdDisChgType,
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
                        AND HDDISTEMP.FTBchCode     = '$tSOBchCode'
                        AND HDDISTEMP.FTXthDocNo    = '$tSODocNo'
                        AND HDDISTEMP.FTSessionID   = '$tSOSessionID'
                    ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    //Move DTTemp To DT
    public function FSaMSOMoveDtTmpToDt($paDataWhere,$paTableAddUpdate){
        $tSOBchCode     = $paDataWhere['FTBchCode'];
        $tSODocNo       = $paDataWhere['FTXshDocNo'];
        $tSODocKey      = $paTableAddUpdate['tTableHD'];
        $tSOSessionID   = $this->session->userdata('tSesSessionID');
        
        if(isset($tSODocNo) && !empty($tSODocNo)){
            $this->db->where_in('FTXshDocNo',$tSODocNo);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO ".$paTableAddUpdate['tTableDT']." (
                        FTBchCode,FTXshDocNo,FNXsdSeqNo,FTPdtCode,FTXsdPdtName,FTPunCode,FTPunName,FCXsdFactor,FTXsdBarCode,FTXsdVatType,FTVatCode,FCXsdVatRate,
                        FTXsdSaleType,FCXsdSalePrice,FCXsdQty,FCXsdQtyAll,FCXsdSetPrice,FCXsdAmtB4DisChg,FTXsdDisChgTxt,FCXsdDis,FCXsdChg,FCXsdNet,FCXsdNetAfHD,
                        FCXsdVat,FCXsdVatable,FCXsdWhtAmt,FTXsdWhtCode,FCXsdWhtRate,FCXsdCostIn,FCXsdCostEx,FCXsdQtyLef,FCXsdQtyRfn,FTXsdStaPrcStk,FTXsdStaAlwDis,
                        FNXsdPdtLevel,FTXsdPdtParent,FCXsdQtySet,FTPdtStaSet,FTXsdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy ) ";
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
                        AND DOCTMP.FTBchCode    = '$tSOBchCode'
                        AND DOCTMP.FTXthDocNo   = '$tSODocNo'
                        AND DOCTMP.FTXthDocKey  = '$tSODocKey'
                        AND DOCTMP.FTSessionID  = '$tSOSessionID'
                        ORDER BY DOCTMP.FNXtdSeqNo ASC";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality : Move Document DTDisTemp To Document DTDis
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Tempt To DT
    // Return Type : array
    public function FSaMSOMoveDtDisTempToDtDis($paDataWhere,$paTableAddUpdate){
        $tSOBchCode     = $paDataWhere['FTBchCode'];
        $tSODocNo       = $paDataWhere['FTXshDocNo'];
        $tSOSessionID   = $this->session->userdata('tSesSessionID');
        
        if(isset($tSODocNo) && !empty($tSODocNo)){
            $this->db->where_in('FTXshDocNo',$tSODocNo);
            $this->db->where_in('FTBchCode',$tSOBchCode);
            $this->db->delete($paTableAddUpdate['tTableDTDis']);
        }

        $tSQL   =   "   INSERT INTO ".$paTableAddUpdate['tTableDTDis']." (FTBchCode,FTXshDocNo,FNXsdSeqNo,FDXddDateIns,FNXddStaDis,FTXddDisChgTxt,FTXddDisChgType,FCXddNet,FCXddValue) ";
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
                        AND DOCDISTMP.FTBchCode     = '$tSOBchCode'
                        AND DOCDISTMP.FTXthDocNo    = '$tSODocNo'
                        AND DOCDISTMP.FTSessionID   = '$tSOSessionID' 
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
    public function FSaMSOGetDataDocHD($paDataWhere){
        $tSODocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID     = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            DOCHD.FTBchCode,
                            BCHL.FTBchName,
                            SHP.FTMerCode,
                            MERL.FTMerName,
                            SHP.FTShpType,
                            SHP.FTShpCode,
                            SHPL.FTShpName,
                            POS.FTWahRefCode,
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
                            DOCHD.FTXshStaPaid,
                            DOCHD.FNXshStaDocAct,
                            DOCHD.FNXshStaRef,
                            DOCHD.FTPosCode,
                            DOCHD.FTCstCode,
                            HDCST.FTXshCardID,
                            HDCST.FTXshCstName,
                            HDCST.FTXshCstTel,
                            (
                            SELECT
                            MAX (FNDatApvSeq)
                            FROM
                            TARTDocApvTxn
                            WHERE
                            TARTDocApvTxn.FTBchCode = DOCHD.FTBchCode
                            AND TARTDocApvTxn.FTDatRefCode = DOCHD.FTXshDocNo
                            AND TARTDocApvTxn.FTDatUsrApv IS NOT NULL
                            GROUP BY
                            TARTDocApvTxn.FTDatRefCode
                            ) AS LastSeq,
                            IMGOBJ.FTImgObj,
                            DOCHD.FDLastUpdOn,
                            DOCHD.FTLastUpdBy,
                            DOCHD.FDCreateOn,
                            DOCHD.FTCreateBy
                            
                        FROM TARTSoHD DOCHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK)   ON DOCHD.FTBchCode      = BCHL.FTBchCode    AND BCHL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMShop          SHP     WITH (NOLOCK)   ON DOCHD.FTShpCode      = SHP.FTShpCode     AND DOCHD.FTBchCode     = SHP.FTBchCode
                        LEFT JOIN TCNMShop_L        SHPL    WITH (NOLOCK)   ON DOCHD.FTShpCode      = SHPL.FTShpCode	AND SHP.FTBchCode       = SHPL.FTBchCode    AND SHPL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK)   ON SHP.FTMerCode        = MERL.FTMerCode	AND MERL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAHL    WITH (NOLOCK)   ON DOCHD.FTWahCode      = WAHL.FTWahCode    AND DOCHD.FTBchCode     = WAHL.FTBchCode	AND WAHL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMWaHouse       POS     WITH (NOLOCK)   ON DOCHD.FTWahCode      = POS.FTWahCode		AND DOCHD.FTBchCode     = POS.FTBchCode     AND POS.FTWahStaType    = '6'
                        LEFT JOIN TCNMPos_L		    POSL    WITH (NOLOCK)   ON POS.FTWahRefCode     = POSL.FTPosCode    AND DOCHD.FTBchCode     = POSL.FTBchCode    AND POSL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMUsrDepart_L	DPTL    WITH (NOLOCK)   ON DOCHD.FTDptCode      = DPTL.FTDptCode	AND DPTL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK)   ON DOCHD.FTUsrCode      = USRL.FTUsrCode	AND USRL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK)   ON DOCHD.FTXshApvCode	= USRL.FTUsrCode	AND USRL.FNLngID	    = $nLngID
                        LEFT JOIN TARTSoHDCst       HDCST   WITH (NOLOCK)   ON DOCHD.FTXshDocNo     = HDCST.FTXshDocNo
                        LEFT JOIN TCNMImgObj        IMGOBJ  WITH (NOLOCK)   ON DOCHD.FTXshDocNo     = IMGOBJ.FTImgRefID  AND IMGOBJ.FTImgTable='TARTSoHD'
                        WHERE 1=1 AND DOCHD.FTXshDocNo = '$tSODocNo' ";
                        
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
    public function FSaMSOGetDataDocHDSpl($paDataWhere){
        $tSODocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID     = $paDataWhere['FNLngID'];
        $tSQL       = " SELECT
                            HDSPL.FTBchCode,
                            HDSPL.FTXshDocNo,
                            HDSPL.FTXshDstPaid,
                            HDSPL.FNXshCrTerm,
                            HDSPL.FDXshDueDate,
                            HDSPL.FDXshBillDue,
                            HDSPL.FTXshCtrName,
                            HDSPL.FDXshTnfDate,
                            HDSPL.FTXshRefTnfID,
                            HDSPL.FTXshRefVehID,
                            HDSPL.FTXshRefInvNo,
                            HDSPL.FTXshQtyAndTypeUnit,
                            HDSPL.FNXshShipAdd,
                            SHIP_Add.FTAddV1No              AS FTXshShipAddNo,
                            SHIP_Add.FTAddV1Soi				AS FTXshShipAddSoi,
                            SHIP_Add.FTAddV1Village         AS FTXshShipAddVillage,
                            SHIP_Add.FTAddV1Road			AS FTXshShipAddRoad,
                            SHIP_SUDIS.FTSudName			AS FTXshShipSubDistrict,
                            SHIP_DIS.FTDstName				AS FTXshShipDistrict,
                            SHIP_PVN.FTPvnName				AS FTXshShipProvince,
                            SHIP_Add.FTAddV1PostCode	    AS FTXshShipPosCode,
                            HDSPL.FNXshTaxAdd,
                            TAX_Add.FTAddV1No               AS FTXshTaxAddNo,
                            TAX_Add.FTAddV1Soi				AS FTXshTaxAddSoi,
                            TAX_Add.FTAddV1Village		    AS FTXshTaxAddVillage,
                            TAX_Add.FTAddV1Road				AS FTXshTaxAddRoad,
                            TAX_SUDIS.FTSudName				AS FTXshTaxSubDistrict,
                            TAX_DIS.FTDstName               AS FTXshTaxDistrict,
                            TAX_PVN.FTPvnName               AS FTXshTaxProvince,
                            TAX_Add.FTAddV1PostCode		    AS FTXshTaxPosCode
                        FROM TARTSoHDSpl HDSPL  WITH (NOLOCK)
                        LEFT JOIN TCNMAddress_L			SHIP_Add    WITH (NOLOCK)   ON HDSPL.FNXshShipAdd       = SHIP_Add.FNAddSeqNo	AND SHIP_Add.FNLngID    = $nLngID
                        LEFT JOIN TCNMSubDistrict_L     SHIP_SUDIS 	WITH (NOLOCK)	ON SHIP_Add.FTAddV1SubDist	= SHIP_SUDIS.FTSudCode	AND SHIP_SUDIS.FNLngID  = $nLngID
                        LEFT JOIN TCNMDistrict_L        SHIP_DIS    WITH (NOLOCK)	ON SHIP_Add.FTAddV1DstCode	= SHIP_DIS.FTDstCode    AND SHIP_DIS.FNLngID    = $nLngID
                        LEFT JOIN TCNMProvince_L        SHIP_PVN    WITH (NOLOCK)	ON SHIP_Add.FTAddV1PvnCode	= SHIP_PVN.FTPvnCode    AND SHIP_PVN.FNLngID    = $nLngID
                        LEFT JOIN TCNMAddress_L			TAX_Add     WITH (NOLOCK)   ON HDSPL.FNXshTaxAdd        = TAX_Add.FNAddSeqNo	AND TAX_Add.FNLngID		= $nLngID
                        LEFT JOIN TCNMSubDistrict_L     TAX_SUDIS 	WITH (NOLOCK)	ON TAX_Add.FTAddV1SubDist   = TAX_SUDIS.FTSudCode	AND TAX_SUDIS.FNLngID	= $nLngID
                        LEFT JOIN TCNMDistrict_L        TAX_DIS     WITH (NOLOCK)	ON TAX_Add.FTAddV1DstCode   = TAX_DIS.FTDstCode     AND TAX_DIS.FNLngID     = $nLngID
                        LEFT JOIN TCNMProvince_L        TAX_PVN     WITH (NOLOCK)	ON TAX_Add.FTAddV1PvnCode   = TAX_PVN.FTPvnCode		AND TAX_PVN.FNLngID     = $nLngID
                        WHERE 1=1 AND HDSPL.FTXshDocNo = '$tSODocNo'
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
    public function FSxMSOMoveHDDisToTemp($paDataWhere){
        $tSODocNo       = $paDataWhere['FTXthDocNo'];
        // Delect Document HD DisTemp By Doc No
        $this->db->where('FTXthDocNo',$tSODocNo);
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
                            SOHDDis.FTBchCode,
                            SOHDDis.FTXshDocNo,
                            SOHDDis.FDXhdDateIns,
                            SOHDDis.FTXhdDisChgTxt,
                            SOHDDis.FTXhdDisChgType,
                            SOHDDis.FCXhdTotalAfDisChg,
                            (ISNULL(NULL,0)) AS FCXtdTotalB4DisChg,
                            SOHDDis.FCXhdDisChg,
                            SOHDDis.FCXhdAmt,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."')    AS FTSessionID,
                            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                        FROM TARTSoHDDis SOHDDis WITH (NOLOCK)
                        WHERE 1=1 AND SOHDDis.FTXshDocNo = '$tSODocNo'
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
    public function FSxMSOMoveDTToDTTemp($paDataWhere){
        $tSODocNo       = $paDataWhere['FTXthDocNo'];
        $tSODocKey      = $paDataWhere['FTXthDocKey'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTSessionID',$this->session->userdata('tSesSessionID'));
        $this->db->delete('TCNTDocDTTmp');

        $this->db->where('FTSessionID',$this->session->userdata('tSesSessionID'));
        $this->db->delete('TCNTDocDTDisTmp');

        $tSQL   = " INSERT INTO TCNTDocDTTmp (
                        FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
                        FTXtdVatType,FTVatCode,FCXtdVatRate,FTXtdSaleType,FCXtdSalePrice,FCXtdQty,FCXtdQtyAll,FCXtdSetPrice,
                        FCXtdAmtB4DisChg,FTXtdDisChgTxt,FCXtdDis,FCXtdChg,FCXtdNet,FCXtdNetAfHD,FCXtdVat,FCXtdVatable,FCXtdWhtAmt,
                        FTXtdWhtCode,FCXtdWhtRate,FCXtdCostIn,FCXtdCostEx,FCXtdQtyLef,FCXtdQtyRfn,FTXtdStaPrcStk,FTXtdStaAlwDis,
                        FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,FTXtdPdtStaSet,FTXtdRmk,
                        FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy)
                    SELECT
                        SODT.FTBchCode,
                        SODT.FTXshDocNo,
                        SODT.FNXsdSeqNo,
                        CONVERT(VARCHAR,'".$tSODocKey."') AS FTXthDocKey,
                        SODT.FTPdtCode,
                        SODT.FTXsdPdtName,
                        SODT.FTPunCode,
                        SODT.FTPunName,
                        SODT.FCXsdFactor,
                        SODT.FTXsdBarCode,
                        SODT.FTXsdVatType,
                        SODT.FTVatCode,
                        SODT.FCXsdVatRate,
                        SODT.FTXsdSaleType,
                        SODT.FCXsdSalePrice,
                        SODT.FCXsdQty,
                        SODT.FCXsdQtyAll,
                        SODT.FCXsdSetPrice,
                        SODT.FCXsdAmtB4DisChg,
                        SODT.FTXsdDisChgTxt,
                        SODT.FCXsdDis,
                        SODT.FCXsdChg,
                        SODT.FCXsdNet,
                        SODT.FCXsdNetAfHD,
                        SODT.FCXsdVat,
                        SODT.FCXsdVatable,
                        SODT.FCXsdWhtAmt,
                        SODT.FTXsdWhtCode,
                        SODT.FCXsdWhtRate,
                        SODT.FCXsdCostIn,
                        SODT.FCXsdCostEx,
                        SODT.FCXsdQtyLef,
                        SODT.FCXsdQtyRfn,
                        SODT.FTXsdStaPrcStk,
                        SODT.FTXsdStaAlwDis,
                        SODT.FNXsdPdtLevel,
                        SODT.FTXsdPdtParent,
                        SODT.FCXsdQtySet,
                        SODT.FTPdtStaSet,
                        SODT.FTXsdRmk,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                    FROM TARTSoDT AS SODT WITH (NOLOCK)
                    WHERE 1=1 AND SODT.FTXshDocNo = '$tSODocNo'
                    ORDER BY SODT.FNXsdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        return;
    }


    // Functionality : Move Data DT Dis To DT Dis Temp
    // Parameters : function parameters
    // Creator : 04/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    public function FSxMSOMoveDTDisToDTDisTemp($paDataWhere){
        $tSODocNo       = $paDataWhere['FTXthDocNo'];
        
        // Delect Document DTDisTemp By Doc No
        $this->db->where('FTXthDocNo',$tSODocNo);
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
                        SODTDis.FTBchCode,
                        SODTDis.FTXshDocNo,
                        SODTDis.FNXsdSeqNo,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."')    AS FTSessionID,
                        SODTDis.FDXddDateIns,
                        SODTDis.FNXddStaDis,
                        SODTDis.FTXddDisChgType,
                        SODTDis.FCXddNet,
                        SODTDis.FCXddValue,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy,
                        SODTDis.FTXddDisChgTxt
                    FROM TARTSoDTDis SODTDis
                    WHERE 1=1 AND SODTDis.FTXshDocNo = '$tSODocNo'
                    ORDER BY SODTDis.FNXsdSeqNo ASC
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
    public function FSaMSOCancelDocument($paDataUpdate){
        // TARTSoHD
        $this->db->trans_begin();
        $this->db->set('FTXshStaDoc' , '3');
        $this->db->where('FTXshDocNo', $paDataUpdate['tDocNo']);
        $this->db->update('TARTSoHD');

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

    //Approve Document Data
    public function FSaMSOApproveDocument($paDataUpdate){
        // TARTSoHD
        $this->db->trans_begin();
        $dLastUpdOn = date('Y-m-d H:i:s');
        $tLastUpdBy = $this->session->userdata('tSesUsername');
        $this->db->set('FDLastUpdOn',$dLastUpdOn);
        $this->db->set('FTLastUpdBy',$tLastUpdBy);
        $this->db->set('FTXshStaApv',$paDataUpdate['nStaApv']);
        $this->db->set('FTXshApvCode',$paDataUpdate['tApvCode']);
        $this->db->where('FTXshDocNo',$paDataUpdate['tDocNo']);
        $this->db->update('TARTSoHD');
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
        $tSODataSearchAndAdd    = $paDataChkINDB['tSODataSearchAndAdd'];
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
                    AND (PDTBAR.FTPdtCode = '$tSODataSearchAndAdd' OR PDTBAR.FTBarCode = '$tSODataSearchAndAdd')
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
    public function FSnMSOCheckLevelApr($paData){

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

                      $aResult =  $this->FSnMSODMoveRoleToTrns($aDataParam);

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

    public function FSnMSODMoveRoleToTrns($paDataInsert){
        
        $tTableDocHD = $paDataInsert['tTableDocHD'];
        $tCreateBy   = $paDataInsert['tCreateBy'];
        $tDocNo      = $paDataInsert['tDocNo'];
        $dDocDate    = $paDataInsert['dDocDate'];
        $tBchCode    = $paDataInsert['tBchCode'];

         $nCountrow = $this->FSnMSONumRowTnxTable($paDataInsert);
        
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


    public function FSnMSONumRowTnxTable($paDataInsert){

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

public function FSnMSOUpdateTableMutiAprve($paData){

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




public function FSnMSOAInsertForMultiAprve($paData){
        // TARTSoHD

    $nCheckPerAprv = $this->FSnMSOUpdateTableMutiAprve($paData);//ตรวจสอบลำดับที่จะอนุมัติ
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

    public function FSnMSOGetDocType(){
        $tSql = " SELECT
            TSysDocType.FNSdtDocType
            FROM [dbo].[TSysDocType]
            WHERE 
            TSysDocType.FTSdtTblName='TARTSoHD' ";
        $oQuery = $this->db->query($tSql);
        return $oQuery->row_array();
    }

    public function FSaMSOUpdateStrPrcLastUpdate($paData){
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

    public function FSnMSOCheckStrPrcLastUpdate($paData){
        $FTDatRefCode = $paData['FTDatRefCode'];
        $tBchCode = $paData['tBchCode'];
        $FNDatApvSeq = $paData['FNDatApvSeq'];
        $dDataNow = date('Y-m-d H:i:s');
        $tUserCode      = $this->session->userdata('tSesUsername');
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
            OR 
            ( TXN.FTLastUpdBy = '$tUserCode' AND  TXN.FTDatStaPrc = 2 )
        )
                ";
        $oQuery = $this->db->query($tSql);
        $reustl =  $oQuery->row_array();

        return  $reustl['StrCheck'];
    }

    public function FSnMSOGetTimeCountDown($paData){

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
        $reustl =  $oQuery->row_array();
    
        return  $reustl['rSecondTime'];


    }

    public function FSaMSORejectDocument($paData){

        $this->db->set('FTDatUsrApv', NULL);
        $this->db->set('FDDatDateApv', NULL);
        $this->db->set('FTDatStaPrc', NULL);
        $this->db->set('FDLastUpdOn', $paData['dLastUpdate']);
        $this->db->set('FTLastUpdBy', $paData['tUpdateBy']);
        $this->db->where('FNDatApvSeq >=',$paData['nLastSeq']);
        $this->db->where('FTDatRefCode',$paData['tSODocNo']);
        $this->db->update('TARTDocApvTxn');
        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Not Insert HD Dis Temp.',
            );
        }
        return $aStatus;

    }
  

    //--------------------------------------------------------------------------------------------------------------------------

    //auto รหัส
    public function FSaMSOGenCodeAutoDocument($paData) {

      $tTableName =  $paData['tTableName'];
      $tXshDocNo  =  $paData['tXshDocNo'];
      $nDocType   =  $paData['nDocType'];
      $dDate      =  $paData['dDate'];
      $tPosCode   =  $paData['tPosCode'];
      $tShpCode   =  $paData['tShpCode'];

        $tSql ="
                DECLARE @FTResult varchar(30)

                EXECUTE [STP_GETtAutoGen]
                '$tTableName'
                ,'$tXshDocNo'
                ,$nDocType
                ,'$dDate'
                ,'$tPosCode'
                ,'$tShpCode'
                ,@FTResult OUTPUT
                
                SELECT 'ColumnName' = @FTResult
        ";

        $oQuery = $this->db->query($tSql);
        
        if ($oQuery != FALSE) {
            // unset($oQuery);
            return $oQuery->row_array()['ColumnName'];
        } else {
            unset($oQuery);
            return 0;
        }
    }

    //วิ่งไปหา Customer Code & Deparment Code
    public function FSaMSOGetCustomerDptCode($tSOBchCode,$tSODocNo) {
        $tSql = " SELECT FTDptCode , FTCstCode , FNXshStaDocAct , FTXshStaDoc FROM TARTSoHD
                    WHERE FTXshDocNo = '$tSODocNo' AND FTBchCode = '$tSOBchCode' ";
        $oQuery = $this->db->query($tSql);
        $reustl =  $oQuery->row_array();
        return  $reustl;
    }

    //ไปเอา Tsysconfig ในระบบว่าใช้รูปแบบไหน
    public function FSaMSOGetDefOptionConfigSystem($paConfigSys){
        $tFTSysCode       = $paConfigSys['FTSysCode'];
        $tFTSysKey        = $paConfigSys['FTSysKey'];
        $tFTSysApp        = $paConfigSys['FTSysApp'];
        $aDataReturn      = array();

        $tSQLUsrVal = " SELECT
                            SYSCON.FTSysStaUsrValue AS FTSysWahCode
                        FROM TSysConfig SYSCON          WITH(NOLOCK)
                        WHERE 1=1
                        AND SYSCON.FTSysCode    = '$tFTSysCode'
                        AND SYSCON.FTSysKey     = '$tFTSysKey' 
                        AND SYSCON.FTSysApp     = '$tFTSysApp' ";
        $oQuery1    = $this->db->query($tSQLUsrVal);
        if($oQuery1->num_rows() > 0){
            $aDataReturn    = $oQuery1->row_array();
        }else{
            $tSQLUsrDef = " SELECT
                                SYSCON.FTSysStaDefValue AS FTSysWahCode
                        FROM TSysConfig SYSCON          WITH(NOLOCK)
                        WHERE 1=1
                        AND SYSCON.FTSysCode    = '$tFTSysCode'
                        AND SYSCON.FTSysKey     = '$tFTSysKey' 
                        AND SYSCON.FTSysApp     = '$tFTSysApp' ";
            $oQuery2    = $this->db->query($tSQLUsrDef);
            if($oQuery2->num_rows() > 0){
                $aDataReturn    = $oQuery2->row_array();
            }else{
                $aDataReturn    = '';
            }
        }

        unset($oQuery1);
        unset($oQuery2);
        return $aDataReturn;
    }

    //หาราคา Price จากสินค้า
    public function FSaMSOGetPriceBYPDT($ptCode){
        $tSQL           = "SELECT TOP 1 FTCmpWhsInOrEx FROM TCNMComp";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        $nVat           = $oList[0]['FTCmpWhsInOrEx'];

        $FNLngID        = $this->session->userdata("tLangEdit");
        $FTPdtCode      = $ptCode;
        $tVatInorEx     = $nVat;

        $tSQL =  "SELECT P.*,PUNL.FTPunName,";
                if( $tVatInorEx == 1){
        $tSQL .= " ISNULL(CAVG.FCPdtCostEx    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
                }else if( $tVatInorEx == 2){
        $tSQL .= " ISNULL(CAVG.FCPdtCostIn    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
                }
        $tSQL .= " ISNULL(PSPL.FCSplLastPrice * ISNULL(P.FCPdtUnitFact,1),NULL) as PDTCostLastPrice,
                ISNULL(PCFF.FCPdtCostEx       *	ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostFiFo			
                FROM(
                SELECT 
                        PDT.FTPdtCode,	
                        PBCH.FTShpCode,
                        PDT_L.FTPdtName,
                        PBCH.FTBchCode,			
                        BAR.FTBarCode,
                        BAR.FTPunCode,
                        PPS.FCPdtUnitFact,
                        PDT.FCPdtCostStd *  ISNULL(PPS.FCPdtUnitFact,1)	as PDTCostSTD,
                        PDTIMG.FTImgObj,
                        LOGSEQ.FTPlcCode
                            
                FROM TCNMPdt PDT
                LEFT JOIN TCNMPdtSpcBch PBCH  ON PDT.FTPdtCode = PBCH.FTPdtCode  
                LEFT JOIN TCNMPdtBar BAR ON BAR.FTPdtCode = PDT.FTPdtCode
                LEFT JOIN  TCNTPdtLocSeq  LOGSEQ  ON BAR.FTBarCode   = LOGSEQ.FTBarCode
                LEFT JOIN TCNMPdt_L PDT_L ON PDT.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = '$FNLngID'
                INNER JOIN TCNMPdtPackSize PPS ON PDT.FTPdtCode = PPS.FTPdtCode AND BAR.FTPunCode = PPS.FTPunCode 
                LEFT JOIN TCNMImgPdt PDTIMG ON PDT.FTPdtCode = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                WHERE PDT.FTPdtCode = '$FTPdtCode'
                ) P
                LEFT JOIN TCNMPdtUnit_L PUNL ON P.FTPunCode = PUNL.FTPunCode  AND PUNL.FNLngID = '$FNLngID'
                LEFT JOIN  TCNMPdtCostAvg CAVG	ON CAVG.FTPdtCode = P.FTPdtCode
                LEFT JOIN  TCNMPdtSpl PSPL	ON PSPL.FTPdtCode = P.FTPdtCode AND PSPL.FTBarCode = P.FTBarCode
                LEFT JOIN  TCNMPdtCostFiFo PCFF	ON PCFF.FTPdtCode = P.FTPdtCode";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }


    public function FSaMSOGetPrice4Pdt($paData){
                  $FTBchCode =  $paData['FTBchCode'];
                  $FTPdtCode =  $paData['FTPdtCode'];
                  $FTPunCode =  $paData['FTPunCode'];
                  $FTPplCode =  $paData['FTPplCode'];

                  $tSql ="SELECT 
                  TOP 1 PPDT.FCPgdPriceRet 
                  FROM TCNTPdtPrice4PDT PPDT
                  WHERE PPDT.FTPdtCode = '$FTPdtCode'
                  AND PPDT.FTPunCode ='$FTPunCode'
                  AND PPDT.FTPplCode = '$FTPplCode'
                  AND PPDT.FDPghDStart <= CONVERT (VARCHAR(10), GETDATE(), 121)
                  AND PPDT.FDPghDStop >= CONVERT (VARCHAR(10), GETDATE(), 121)
                  ORDER BY PPDT.FDPghDStart DESC ";

                    // echo  $tSql ;
                    // die();
                $oQuery = $this->db->query($tSql);
                if ($oQuery->num_rows() > 0) {
                    return $oQuery->row_array();
                }else{
                    return false;
                }
    }


    //อัพเดทเหตุผล
    public function FSaMSOUpdateReasonInDT($paData){
        $this->db->set('FTXtdRmk', $paData['FTXtdRmk']);
        $this->db->where('FNXtdSeqNo',$paData['FNXtdSeqNo']);
        $this->db->where('FTPdtCode',$paData['FTPdtCode']);
        $this->db->where('FTXthDocKey',$paData['FTXthDocKey']);
        $this->db->where('FTSessionID',$paData['FTSessionID']);
        $this->db->update('TCNTDocDTTmp');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Not Insert HD Dis Temp.',
            );
        }
        return $aStatus;
    }

    //ดึงค่าเหตุผล
    public function FSaMSOGetReasonInDT($paData){
        $FNXtdSeqNo     = $paData['FNXtdSeqNo']; 
        $FTPdtCode      = $paData['FTPdtCode'];
        $FTXthDocKey    = $paData['FTXthDocKey']; 
        $FTSessionID    = $paData['FTSessionID'];
        $tSQL = " SELECT FTXtdRmk
            FROM TCNTDocDTTmp          WITH(NOLOCK)
            WHERE 1=1
            AND FNXtdSeqNo = '$FNXtdSeqNo'
            AND FTPdtCode = '$FTPdtCode' 
            AND FTXthDocKey = '$FTXthDocKey'
            AND FTSessionID =  '$FTSessionID' ";
        $oQuery      =  $this->db->query($tSQL);
        $aResult     =  $oQuery->row_array();
        return $aResult;
    }

    //สินค้าที่ไม่ผ่านการอนุมัติ
    public function FSxMSONotAproveItem($paData){
        foreach($paData['tSOtiemNotApr'] as $nK => $aData){
            if(strval($aData['nVal']) == 2){
                $aDataInserDelObj = array(
                    'FTBchCode'         => $paData['tBchCode'],
                    'FTXshDocNo'        => $paData['tDocNo'] ,
                    'FNXsdSeqNo'        => strval($aData['nseq']),
                    'FTXsdRmk'          => strval($aData['reason']),
                    'FDCreateOn'        => date('Y-m-d H:i:s') ,
                    'FTCreateBy'        => $paData['tSesUsername'] ,
                ); 
                $this->db->insert('TVDTDTCN',$aDataInserDelObj);
            }
        }
    }

    //อัพเดทสินค้า กรณีผ่าน
    public function FSxMSOUpdatePDTInSO($paData){
        $tSQL   =   "   UPDATE TARTSoDT
                        SET FTXsdStaPrcStk = '".$paData['FTXsdStaPrcStk']."' 
                        WHERE 1=1
                        AND FTBchCode       = '".$paData['FTBchCode']."'
                        AND FTXshDocNo      = '".$paData['FTXshDocNo']."'
                        AND FNXsdSeqNo      = '".$paData["FNXsdSeqNo"]."'
                        AND FTPdtCode       = '".$paData['FTPdtCode']."' ";
        $this->db->query($tSQL);
    }

    //อัพเดทสินค้า กรณีปฎิเสธ
    public function FSaMSORejectPDTToBasic($tSOBchCode,$tSODocNo){
        //ปรับสถานะกลับมาเป็นเหมือนเดิม
        $tSQL   =   "   UPDATE TARTSoDT
                SET FTXsdStaPrcStk = null 
                WHERE 1=1
                AND FTBchCode       = '".$tSOBchCode."'
                AND FTXshDocNo      = '".$tSODocNo."' ";
        $this->db->query($tSQL);

        //ลบใน CN ออก
        $this->db->where_in('FTXshDocNo',$tSODocNo);
        $this->db->delete('TVDTDTCN');
    }

    //หาคลังสินค้าในตาราง pdt layout
    function FSnMSOGetWahouseinLayout($ptDocument){
        $tDocument = trim($ptDocument);
        $tSQL   =   "   SELECT S.* FROM(
                        SELECT 
                            PDT.FTPdtCode ,
                            PDT.FTWahCode ,
                            row_number() OVER(PARTITION BY PDT.FTPdtCode order by  PDT.FTPdtCode ASC) AS GroupPDT,
                            HD.FTShpCode,
                            DT.FTBchCode,
                            HD.FTXshDocNo,
                            WAH.FTWahName
                        FROM TARTSoDT DT
                        LEFT JOIN TARTSoHD HD ON DT.FTXshDocNo = HD.FTXshDocNo
                        INNER JOIN TVDMPdtLayout PDT ON DT.FTPdtCode = PDT.FTPdtCode AND DT.FTBchCode = PDT.FTBchCode AND HD.FTShpCode = PDT.FTShpCode
                        LEFT JOIN TCNMWaHouse_L WAH ON WAH.FTWahCode = PDT.FTWahCode AND PDT.FTBchCode = WAH.FTBchCode
                        WHERE HD.FTXshDocNo = '$tDocument' ) S WHERE S.GroupPDT = 1 ";
        $oQuery = $this->db->query($tSQL);
        $reustl =  $oQuery->result_array();
        return $reustl;
    }

}