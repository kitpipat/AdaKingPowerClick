<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class productarrangement_model extends CI_Model {

    // ดึงข้อมูลมาแสดงบนตาราางหน้า List
    public function FSaMPAMGetDataTableList($paDataCondition){
        $aRowLen                = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                 = $paDataCondition['FNLngID'];
        $aDatSessionUserLogIn   = $paDataCondition['aDatSessionUserLogIn'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        
        $tSearchList        = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCode     = $aAdvanceSearch['tSearchBchCode'];
        $tSearchPlcCode     = $aAdvanceSearch['tSearchPlcCode'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchPackType    = $aAdvanceSearch['tSearchPackType'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrm'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];

        $tSearchCat1Code    = $aAdvanceSearch['tSearchCat1Code'];
        $tSearchCat2Code    = $aAdvanceSearch['tSearchCat2Code'];
        $tSearchCat3Code    = $aAdvanceSearch['tSearchCat3Code'];
        $tSearchCat4Code    = $aAdvanceSearch['tSearchCat4Code'];
        $tSearchCat5Code    = $aAdvanceSearch['tSearchCat5Code'];
        
        
        // $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        // $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        // $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        // $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        // $tSearchStaDocAct   = $aAdvanceSearch['tSearchStaDocAct'];

        $tSQL1  = "  SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC ) AS FNRowID,* FROM ( ";
        $tSQL2  = "  SELECT
                        HD.FTBchCode,
                        BCHL.FTBchName,
                        HD.FTXthDocNo,
                        CONVERT(CHAR(10),HD.FDXthDocDate,103) AS FDXthDocDate,
                        CONVERT(CHAR(5), HD.FDXthDocDate,108) AS FTXthDocTime,
                        HD.FTXthStaDoc,
                        HD.FTXthStaApv,
                        HD.FTCreateBy,
                        HD.FDCreateOn,
                        HD.FNXthStaDocAct,
                        USRL.FTUsrName          AS FTCreateByName,
                        HDREF.FTXthRefDocNo		AS FTXthRefInt
                    FROM TCNTPdtPickHD	            HD      WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L          BCHL    WITH (NOLOCK) ON HD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID          = $nLngID
                    LEFT JOIN TCNMUser_L            USRL    WITH (NOLOCK) ON HD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID          = $nLngID
                    LEFT JOIN TCNTPdtPickHDDocRef   HDREF   WITH (NOLOCK) ON HD.FTXthDocNo    = HDREF.FTXthDocNo  AND HDREF.FTXthRefType    = '1'

                    WHERE 1=1
        ";

        // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
        if ( $this->session->userdata('tSesUsrLevel') != "HQ" ) { 
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL2 .= " AND HD.FTBchCode IN ($tBchCode) ";
        }

        // สาขาที่สร้าง
        if( !empty($tSearchBchCode) ){
            $tSQL2 .= " AND HD.FTBchCode = '".$tSearchBchCode."' ";
        }

        // ที่เก็บสินค้า
        if( !empty($tSearchPlcCode) ){
            $tSQL2 .= " AND HD.FTPlcCode = '".$tSearchPlcCode."' ";
        }

        // หมวดสินค้า 1
        if( !empty($tSearchCat1Code) ){
            $tSQL2 .= " AND HD.FTXthCat1 = '".$tSearchCat1Code."' ";
        }

        // หมวดสินค้า 2
        if( !empty($tSearchCat2Code) ){
            $tSQL2 .= " AND HD.FTXthCat2 = '".$tSearchCat2Code."' ";
        }

        // หมวดสินค้า 3
        if( !empty($tSearchCat3Code) ){
            $tSQL2 .= " AND HD.FTXthCat3 = '".$tSearchCat3Code."' ";
        }

        // หมวดสินค้า 4
        if( !empty($tSearchCat4Code) ){
            $tSQL2 .= " AND HD.FTXthCat4 = '".$tSearchCat4Code."' ";
        }

        // หมวดสินค้า 5
        if( !empty($tSearchCat5Code) ){
            $tSQL2 .= " AND HD.FTXthCat5 = '".$tSearchCat5Code."' ";
        }
        
        // Check User Login Shop
        // if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
        //     $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
        //     $tSQL   .= " AND PAMHD.FTShpCode = '$tUserLoginShpCode' ";
        // }

        // ค้นหาเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL2 .= " AND ((HD.FTXthDocNo LIKE '%$tSearchList%') 
                          OR (BCHL.FTBchName LIKE '%$tSearchList%') 
                          OR (CONVERT(CHAR(10),HD.FDXthDocDate,103) LIKE '%$tSearchList%')
                          OR (HDREF.FTXthRefDocNo LIKE '%$tSearchList%')) ";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        // if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
        //     $tSQL2 .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        // }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL2 .= " AND ((HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == '3') {
                $tSQL2 .= " AND HD.FTXthStaDoc = '3' ";
            } elseif ($tSearchStaDoc == '2') {
                $tSQL2 .= " AND ISNULL(HD.FTXthStaApv,'') = '' AND HD.FTXthStaDoc != '3' ";
            } elseif ($tSearchStaDoc == '1') {
                $tSQL2 .= " AND HD.FTXthStaApv = '1' ";
            }
        }

        // ประเภทใบจัด
        if(isset($tSearchPackType) && !empty($tSearchPackType)){
            if ($tSearchPackType == '1') {
                $tSQL2 .= " AND HD.FNXthDocType = 1 ";
            } else {
                $tSQL2 .= " AND HD.FNXthDocType = 2 ";
            }
        }

        // ค้นหาสถานะอนุมัติ
        // if(isset($tSearchStaApprove) && !empty($tSearchStaApprove)){
        //     if($tSearchStaApprove == 2){
        //         $tSQL2 .= " AND HD.FTXthStaApv = '$tSearchStaApprove' OR HD.FTXthStaApv = '' ";
        //     }else{
        //         $tSQL2 .= " AND HD.FTXthStaApv = '$tSearchStaApprove'";
        //     }
        // }

        // ค้นหาสถานะเคลื่อนไหว
        // $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        // if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
        //     if ($tSearchStaDocAct == 1) {
        //         $tSQL2 .= " AND HD.FNXthStaDocAct = 1";
        //     } else {
        //         $tSQL2 .= " AND HD.FNXthStaDocAct = 0";
        //     }
        // }

        $tSQL3 =  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        
        $tSQLMain   = $tSQL1.$tSQL2.$tSQL3;
        $oQueryMain = $this->db->query($tSQLMain);
        if( $oQueryMain->num_rows() > 0 ){
            $oDataList          = $oQueryMain->result_array();
            // $aDataCountAllRow   = $this->FSnMPAMCountPageDocListAll($paDataCondition);
            // $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1')? $aDataCountAllRow['rtCountData'] : 0;
            $tSQLPage           = $tSQL2;
            $oQueryPage         = $this->db->query($tSQLPage);
            $nFoundRow          = $oQueryPage->num_rows();
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
        unset($oQueryMain);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Paginations
    public function FSnMPAMCountPageDocListAll($paDataCondition){
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
        $tSearchStaDocAct   = $aAdvanceSearch['tSearchStaDocAct'];
    
        $tSQL   =   "   SELECT COUNT (PAMHD.FTXphDocNo) AS counts
                        FROM TAPTDoHD PAMHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON PAMHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        WHERE 1=1
                    ";
    
        // Check User Login Branch
        if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
            $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
            $tSQL   .= " AND PAMHD.FTBchCode = '$tUserLoginBchCode' ";
        }
    
        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .= " AND PAMHD.FTShpCode = '$tUserLoginShpCode' ";
        }
        
        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((PAMHD.FTXphDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),PAMHD.FDXphDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((PAMHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (PAMHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }
    
        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((PAMHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (PAMHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }
        // ค้นหาสถานะอนุมัติ
        if(isset($tSearchStaApprove) && !empty($tSearchStaApprove)){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND PAMHD.FTXphStaApv = '$tSearchStaApprove' OR PAMHD.FTXphStaApv = '' ";
            }else{
                $tSQL .= " AND PAMHD.FTXphStaApv = '$tSearchStaApprove'";
            }
        }
    
        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND PAMHD.FNXphStaDocAct = 1";
            } else {
                $tSQL .= " AND PAMHD.FNXphStaDocAct = 0";
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

    public function FSaMPAMGetDetailUserBranch($paBchCode){
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

    // เปิดมาหน้า ADD จะต้อง ลบสินค้าตัวเดิม ใน DTTemp โดย where session
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

    // Delete Delivery Order Document
    public function FSxMPAMClearDataInDocTemp($paWhereClearTemp){
        $tPAMDocNo       = $paWhereClearTemp['FTXthDocNo'];
        $tPAMDocKey      = $paWhereClearTemp['FTXthDocKey'];
        $tPAMSessionID   = $paWhereClearTemp['FTSessionID'];

        $this->db->where('FTXthDocKey', $tPAMDocKey);
        $this->db->where('FTSessionID', $tPAMSessionID);
        $this->db->delete('TCNTDocDTTmp');

        $this->db->where('FTXthDocKey', $tPAMDocKey);
        $this->db->where('FTSessionID', $tPAMSessionID);
        $this->db->delete('TCNTDocHDRefTmp');

        // Query Delete DocTemp
        // $tClearDocTemp  =   "   DELETE FROM TCNTDocDTTmp 
        //                         WHERE 1=1 
        //                         AND TCNTDocDTTmp.FTXthDocNo     = '$tPAMDocNo'
        //                         AND TCNTDocDTTmp.FTXthDocKey    = '$tPAMDocKey'
        //                         AND TCNTDocDTTmp.FTSessionID    = '$tPAMSessionID'
        // ";
        // $this->db->query($tClearDocTemp);


        // Query Delete Doc HD Discount Temp
        // $tClearDocHDDisTemp =   "   DELETE FROM TCNTDocHDDisTmp
        //                             WHERE 1=1
        //                             AND TCNTDocHDDisTmp.FTXthDocNo  = '$tPAMDocNo'
        //                             AND TCNTDocHDDisTmp.FTSessionID = '$tPAMSessionID'
        // ";
        // $this->db->query($tClearDocHDDisTemp);

        // Query Delete Doc DT Discount Temp
        // $tClearDocDTDisTemp =   "   DELETE FROM TCNTDocDTDisTmp
        //                             WHERE 1=1
        //                             AND TCNTDocDTDisTmp.FTXthDocNo  = '$tPAMDocNo'
        //                             AND TCNTDocDTDisTmp.FTSessionID = '$tPAMSessionID'
        // ";
        // $this->db->query($tClearDocDTDisTemp);
    
    }

    // Functionality : Delete Delivery Order Document
    public function FSxMPAMClearDataInDocTempForImp($paWhereClearTemp){
        $tPAMDocNo       = $paWhereClearTemp['FTXthDocNo'];
        $tPAMDocKey      = $paWhereClearTemp['FTXthDocKey'];
        $tPAMSessionID   = $paWhereClearTemp['FTSessionID'];

        // Query Delete DocTemp
        $tClearDocTemp  =   "   DELETE FROM TCNTDocDTTmp 
                                WHERE 1=1 
                                AND TCNTDocDTTmp.FTXthDocNo     = '$tPAMDocNo'
                                AND TCNTDocDTTmp.FTXthDocKey    = '$tPAMDocKey'
                                AND TCNTDocDTTmp.FTSessionID    = '$tPAMSessionID'
                                AND TCNTDocDTTmp.FTSrnCode <> 1
        ";
        $this->db->query($tClearDocTemp);
    }

    // Function: Get ShopCode From User Login
    public function FSaMPAMGetShpCodeForUsrLogin($paDataShp){
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

    // Get Data Config WareHouse TSysConfig
    public function FSaMPAMGetDefOptionConfigWah($paConfigSys){
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
    
    // Function : Get Data In Doc DT Temp
    public function FSaMPAMGetDocDTTempListPage($paDataWhere){
        $tPAMDocNo           = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tPAMSesSessionID    = $this->session->userdata('tSesSessionID');

        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tSQL       = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM (
                                SELECT
                                    PAMCTMP.FTBchCode,
                                    PAMCTMP.FTXthDocNo,
                                    PAMCTMP.FNXtdSeqNo,
                                    PAMCTMP.FTXthDocKey,
                                    PAMCTMP.FTPdtCode,
                                    PAMCTMP.FTXtdPdtName,
                                    PAMCTMP.FTPunName,
                                    PAMCTMP.FTXtdBarCode,
                                    PAMCTMP.FTPunCode,
                                    PAMCTMP.FCXtdFactor,
                                    PAMCTMP.FCXtdQty,
                                    PAMCTMP.FCXtdSetPrice,
                                    PAMCTMP.FCXtdAmtB4DisChg,
                                    PAMCTMP.FTXtdDisChgTxt,
                                    PAMCTMP.FCXtdNet,
                                    PAMCTMP.FCXtdNetAfHD,
                                    PAMCTMP.FTXtdStaAlwDis,
                                    PAMCTMP.FTTmpRemark,
                                    PAMCTMP.FCXtdVatRate,
                                    PAMCTMP.FTXtdVatType,
                                    PAMCTMP.FTSrnCode,
                                    PAMCTMP.FDLastUpdOn,
                                    PAMCTMP.FDCreateOn,
                                    PAMCTMP.FTLastUpdBy,
                                    PAMCTMP.FTCreateBy,
                                    PAMCTMP.FTXtdPdtSetOrSN,
                                    PAMCTMP.FCXtdQtyOrd,
                                    PAMCTMP.FTXtdRmk
                                FROM TCNTDocDTTmp PAMCTMP WITH (NOLOCK)
                                WHERE PAMCTMP.FTXthDocKey = '$tPAMDocKey'
                                  AND PAMCTMP.FTSessionID = '$tPAMSesSessionID' ";
        if(isset($tPAMDocNo) && !empty($tPAMDocNo)){
            $tSQL   .=  " AND ISNULL(PAMCTMP.FTXthDocNo,'')  = '$tPAMDocNo' ";
        }

        if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
            $tSQL   .=  "   AND ( PAMCTMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR PAMCTMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR PAMCTMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR PAMCTMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%' )
                        ";
            
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMPAMGetDocDTTempListPageAll($paDataWhere);
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

    // Function : Count All Document DT Temp
    public function FSaMPAMGetDocDTTempListPageAll($paDataWhere){
        $tPAMDocNo           = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tPAMSesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT COUNT (PAMCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp PAMCTMP
                    WHERE 1 = 1 ";
        
        $tSQL   .= " AND PAMCTMP.FTXthDocNo  = '$tPAMDocNo' ";
        $tSQL   .= " AND PAMCTMP.FTXthDocKey = '$tPAMDocKey' ";
        $tSQL   .= " AND PAMCTMP.FTSessionID = '$tPAMSesSessionID' ";
        
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

    //Get Data Pdt
    public function FSaMPAMGetDataPdt($paDataPdtParams){
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
    public function FSaMPAMInsertPDTToTemp($paDataPdtMaster,$paDataPdtParams){
        $paPIDataPdt    = $paDataPdtMaster['raItem'];
        if ($paDataPdtParams['tPAMOptionAddPdt'] == 1) {
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
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
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
                        'FTLastUpdBy'       => $paDataPdtParams['tPAMUsrCode'],
                        'FDCreateOn'        => date('Y-m-d h:i:s'),
                        'FTCreateBy'        => $paDataPdtParams['tPAMUsrCode'],
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
                'FTLastUpdBy'       => $paDataPdtParams['tPAMUsrCode'],
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $paDataPdtParams['tPAMUsrCode'],
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

    //Delete Product Single Item In Doc DT Temp
    public function FSnMPAMDelPdtInDTTmp($paDataWhere){
        // Delete Doc DT Temp
        $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tPAMDocNo']);
        $this->db->where_in('FTXthDocKey',$paDataWhere['tDocKey']);
        $this->db->where_in('FTPdtCode',$paDataWhere['tPdtCode']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->delete('TCNTDocDTTmp');
        return ;
    }

    //Delete Product Multiple Items In Doc DT Temp
    public function FSnMPAMDelMultiPdtInDTTmp($paDataWhere){
        // Delete Doc DT Temp
        $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tPAMDocNo']);
        $this->db->where_in('FTXthDocKey',$paDataWhere['tDocKey']);
        $this->db->where_in('FTPdtCode',$paDataWhere['tPdtCode']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->delete('TCNTDocDTTmp');
        return ;
    }

    // Update Document DT Temp by Seq
    public function FSaMPAMUpdateInlineDTTemp($paDataUpdateDT,$paDataWhere){
        $this->db->where_in('FTSessionID',$paDataWhere['tPAMSessionID']);
        $this->db->where_in('FTXthDocKey',$paDataWhere['tDocKey']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nPAMSeqNo']);

        if ($paDataWhere['tPAMDocNo'] != '' && $paDataWhere['tPAMBchCode'] != '') {
            $this->db->where_in('FTXthDocNo',$paDataWhere['tPAMDocNo']);
            $this->db->where_in('FTBchCode',$paDataWhere['tPAMBchCode']);
        }
        
        $this->db->update('TCNTDocDTTmp', $paDataUpdateDT);
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

    // Function : Count Check Data Product In Doc DT Temp Before Save
    public function FSnMPAMChkPdtInDocDTTemp($paDataWhere){
        $tPAMDocNo       = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey      = $paDataWhere['FTXthDocKey'];
        $tPAMSessionID   = $paDataWhere['FTSessionID'];
        $tSQL           = " SELECT
                                COUNT(FNXtdSeqNo) AS nCountPdt
                            FROM TCNTDocDTTmp DocDT WITH(NOLOCK)
                            WHERE DocDT.FTXthDocKey   = '$tPAMDocKey'
                              AND DocDT.FTSessionID   = '$tPAMSessionID' ";
        if(isset($tPAMDocNo) && !empty($tPAMDocNo)){
            $tSQL   .=  " AND ISNULL(DocDT.FTXthDocNo,'')  = '$tPAMDocNo' ";
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->row_array();
            return $aDataQuery['nCountPdt'];
        }else{
            return 0;
        }
    }

    // Function: Get Data PAM HD List
    public function FSoMPAMCallRefIntDocDataTable($paDataCondition){
        $aRowLen                = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                 = $paDataCondition['FNLngID'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tPAMRefIntBchCode        = $aAdvanceSearch['tPAMRefIntBchCode'];
        $tPAMRefIntDocNo          = $aAdvanceSearch['tPAMRefIntDocNo'];
        $tPAMRefIntDocDateFrm     = $aAdvanceSearch['tPAMRefIntDocDateFrm'];
        $tPAMRefIntDocDateTo      = $aAdvanceSearch['tPAMRefIntDocDateTo'];
        $tPAMRefIntStaDoc         = $aAdvanceSearch['tPAMRefIntStaDoc'];

        $tSQLMain = "   SELECT
                                POHD.FTBchCode,
                                BCHL.FTBchName,
                                POHD.FTXphDocNo,
                                CONVERT(CHAR(10),POHD.FDXphDocDate,121) AS FDXphDocDate,
                                CONVERT(CHAR(5), POHD.FDXphDocDate,108) AS FTXshDocTime,
                                POHD.FTXphStaDoc,
                                POHD.FTXphStaApv,
                                POHD.FNXphStaRef,
                                POHD.FTSplCode,
                                SPL_L.FTSplName,
                                POHD.FTXphVATInOrEx,
                                SPL.FNXphCrTerm,
                                POHD.FTCreateBy,
                                POHD.FDCreateOn,
                                POHD.FNXphStaDocAct,
                                USRL.FTUsrName      AS FTCreateByName,
                                POHD.FTXphApvCode,
                                WAH_L.FTWahCode,
                                WAH_L.FTWahName,
                                BCHLTO.FTBchName AS BCHNameTo ,
                                A.SumA
                            FROM TAPTPoHD           POHD    WITH (NOLOCK)
                            LEFT JOIN   (   select
                                                FTXphDocNo,
                                                SUM(FCXpdQtyLef) AS SumA
                                                from TAPTPoDT
                                                group by FTXphDocNo 
                                        ) A ON A.FTXphDocNo = POHD.FTXphDocNo
                            LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON POHD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID 
                            LEFT JOIN TCNMBranch_L  BCHLTO  WITH (NOLOCK) ON POHD.FTXphBchTo    = BCHLTO.FTBchCode  AND BCHLTO.FNLngID    = $nLngID 
                            LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON POHD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                            LEFT JOIN TCNMSpl_L     SPL_L   WITH (NOLOCK) ON POHD.FTSplCode     = SPL_L.FTSplCode   AND SPL_L.FNLngID    = $nLngID
                            LEFT JOIN TCNMWaHouse_L WAH_L   WITH (NOLOCK) ON POHD.FTBchCode     = WAH_L.FTBchCode   AND POHD.FTWahCode = WAH_L.FTWahCode AND WAH_L.FNLngID	= $nLngID
                            INNER JOIN TAPTPoHDSpl  SPL     WITH (NOLOCK) ON POHD.FTXphDocNo    = SPL.FTXphDocNo
                    ";

        if(isset($tPAMRefIntBchCode) && !empty($tPAMRefIntBchCode)){
            $tSQLMain .= " AND (POHD.FTBchCode = '$tPAMRefIntBchCode' OR POHD.FTXphBchTo = '$tPAMRefIntBchCode')";
        }

        if(isset($tPAMRefIntDocNo) && !empty($tPAMRefIntDocNo)){
            $tSQLMain .= " AND (POHD.FTXphDocNo LIKE '%$tPAMRefIntDocNo%')";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tPAMRefIntDocDateFrm) && !empty($tPAMRefIntDocDateTo)){
            $tSQLMain .= " AND ((POHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tPAMRefIntDocDateFrm 00:00:00') AND CONVERT(datetime,'$tPAMRefIntDocDateTo 23:59:59')) OR (POHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tPAMRefIntDocDateTo 23:00:00') AND CONVERT(datetime,'$tPAMRefIntDocDateFrm 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tPAMRefIntStaDoc) && !empty($tPAMRefIntStaDoc)){
            if ($tPAMRefIntStaDoc == 3) {
                $tSQLMain .= " AND POHD.FTXphStaDoc = '$tPAMRefIntStaDoc'";
            } elseif ($tPAMRefIntStaDoc == 2) {
                $tSQLMain .= " AND ISNULL(POHD.FTXphStaApv,'') = '' AND POHD.FTXphStaDoc != '3'";
            } elseif ($tPAMRefIntStaDoc == 1) {
                $tSQLMain .= " AND POHD.FTXphStaApv = '$tPAMRefIntStaDoc'";
            }
        }

        $tSQL   =   "       SELECT c.* FROM(
                              SELECT  ROW_NUMBER() OVER(ORDER BY FDXphDocDate DESC ,FTXphDocNo DESC ) AS FNRowID,* FROM
                                (  $tSQLMain
                                ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]  AND c.SumA != 0
        ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $oQueryMain         = $this->db->query($tSQLMain);
            $aDataCountAllRow   = $oQueryMain->num_rows();
            $nFoundRow          = $aDataCountAllRow;
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

    // Functionality: Get Data Purchase Order HD List
    public function FSoMPAMCallRefIntDocDTDataTable($paData){

        $nLngID   =  $paData['FNLngID'];
        $tBchCode  =  $paData['tBchCode'];
        $tDocNo    =  $paData['tDocNo'];
        
        $tSQL   = "
            SELECT
                DT.FTBchCode,
                DT.FTXphDocNo,
                DT.FNXpdSeqNo,
                DT.FTPdtCode,
                DT.FTXpdPdtName,
                DT.FTPunCode,
                DT.FTPunName,
                DT.FCXpdFactor,
                DT.FTXpdBarCode,
                DT.FCXpdQtyLef AS FCXpdQty,
                DT.FCXpdQtyAll,
                DT.FTXpdRmk,
                DT.FDLastUpdOn,
                DT.FTLastUpdBy,
                DT.FDCreateOn,
                DT.FTCreateBy
                FROM TAPTPoDT DT WITH(NOLOCK)
            WHERE   DT.FTBchCode = '$tBchCode' AND  DT.FTXphDocNo ='$tDocNo'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aResult = array(
                'raItems'       => $oDataList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        return $aResult;
    }

    // Function : Add/Update Data HD
    public function FSxMPAMAddUpdateHD($paDataMaster,$paDataWhere,$paTableAddUpdate){
        $aDataGetDataHD     =   $this->FSaMPAMGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FNLngID'       => $this->input->post("ohdPAMLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            // $aDataHPAMld         = $aDataGetDataHD['raItems'];
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                // 'FTBchCode'     => $paDataWhere['FTBchCode'],
                // 'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
            ));
            
            // update HD
            $this->db->where('FTBchCode',$paDataWhere['FTBchCode']);
            $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->update($paTableAddUpdate['tTableHD'], $aDataAddUpdateHD);
        }else{
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
            // Insert HD
            $this->db->insert($paTableAddUpdate['tTableHD'],$aDataAddUpdateHD);
        }

        return;
    }

    // Function : Add/Update Data HD Supplier
    // public function FSxMPAMAddUpdateHDSpl($paDataHDSpl,$paDataWhere,$paTableAddUpdate){
    //     // Get Data PI HD
    //     $aDataGetDataSpl    =   $this->FSaMPAMGetDataDocHDSpl(array(
    //         'FTXphDocNo'    => $paDataWhere['FTXphDocNo'],
    //         'FNLngID'       => $this->input->post("ohdPAMLangEdit")
    //     ));
    //     $aDataAddUpdateHDSpl    = array();
    //     if(isset($aDataGetDataSpl['rtCode']) && $aDataGetDataSpl['rtCode'] == 1){
    //         $aDataHDSplOld  = $aDataGetDataSpl['raItems'];
    //         $aDataAddUpdateHDSpl    = array_merge($paDataHDSpl,array(
    //             'FTBchCode'     => $aDataHDSplOld['FTBchCode'],
    //             'FTXphDocNo'    => $aDataHDSplOld['FTXphDocNo'],
    //         ));
    //     }else{
    //         $aDataAddUpdateHDSpl    = array_merge($paDataHDSpl,array(
    //             'FTBchCode'     => $paDataWhere['FTBchCode'],
    //             'FTXphDocNo'    => $paDataWhere['FTXphDocNo'],
    //         ));
    //     }
        
    //     // Delete PI HD Spl
    //     $this->db->where_in('FTBchCode',$aDataAddUpdateHDSpl['FTBchCode']);
    //     $this->db->where_in('FTXphDocNo',$aDataAddUpdateHDSpl['FTXphDocNo']);
    //     $this->db->delete($paTableAddUpdate['tTableHDSpl']);

    //     // Insert PI HD Dis
    //     $this->db->insert($paTableAddUpdate['tTableHDSpl'],$aDataAddUpdateHDSpl);

    //     return;
    // }

    //อัพเดทเลขที่เอกสาร  TCNTDocDTTmp , TCNTDocHDDisTmp , TCNTDocDTDisTmp
    public function FSxMPAMAddUpdateDocNoToTemp($paDataWhere,$paTableAddUpdate){
        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableDT']);
        $this->db->update('TCNTDocDTTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableDTSN']);
        $this->db->update('TCNTDocDTSNTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        return;
    }

    // Function Move Document DTTemp To Document DT
    public function FSaMPAMMoveDtTmpToDt($paDataWhere,$paTableAddUpdate){
        $tPAMBchCode     = $paDataWhere['FTBchCode'];
        $tPAMDocNo       = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey      = $paTableAddUpdate['tTableDT'];
        $tPAMSessionID   = $paDataWhere['FTSessionID'];
        
        if(isset($tPAMDocNo) && !empty($tPAMDocNo)){
            $this->db->where_in('FTXthDocNo',$tPAMDocNo);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO ".$paTableAddUpdate['tTableDT']." ( FTAgnCode,FTBchCode,FTXthDocNo,FNXtdSeqNo,FTPdtCode,
                        FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,FCXtdQty,FCXtdQtyAll/*,FCXtdQtyLef,
                        FCXtdQtyRfn*/,FTXtdStaPrcStk,FTXtdStaAlwDis,/*FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,*/FTPdtStaSet,
                        FTXtdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FCXtdQtyOrd ) ";
        $tSQL   .=  "   SELECT
                            '' AS FTAgnCode,
                            PAMCTMP.FTBchCode,
                            PAMCTMP.FTXthDocNo,
                            ROW_NUMBER() OVER(ORDER BY PAMCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo, 
                            PAMCTMP.FTPdtCode,
                            PAMCTMP.FTXtdPdtName,
                            PAMCTMP.FTPunCode,
                            PAMCTMP.FTPunName,
                            PAMCTMP.FCXtdFactor,
                            PAMCTMP.FTXtdBarCode,
                            PAMCTMP.FCXtdQty,
                            PAMCTMP.FCXtdQtyAll,
                            /*PAMCTMP.FCXtdQtyLef,
                            PAMCTMP.FCXtdQtyRfn,*/
                            PAMCTMP.FTXtdStaPrcStk,
                            PAMCTMP.FTXtdStaAlwDis,
                            /*PAMCTMP.FNXtdPdtLevel,
                            PAMCTMP.FTXtdPdtParent,
                            PAMCTMP.FCXtdQtySet,*/
                            PAMCTMP.FTXtdPdtStaSet,
                            PAMCTMP.FTXtdRmk,
                            PAMCTMP.FDLastUpdOn,
                            PAMCTMP.FTLastUpdBy,
                            PAMCTMP.FDCreateOn,
                            PAMCTMP.FTCreateBy,
                            PAMCTMP.FCXtdQtyOrd
                        FROM TCNTDocDTTmp PAMCTMP WITH (NOLOCK)
                        WHERE PAMCTMP.FTBchCode    = '$tPAMBchCode'
                          AND PAMCTMP.FTXthDocNo   = '$tPAMDocNo'
                          AND PAMCTMP.FTXthDocKey  = '$tPAMDocKey'
                          AND PAMCTMP.FTSessionID  = '$tPAMSessionID'
                        ORDER BY PAMCTMP.FNXtdSeqNo ASC
        ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    //---------------------------------------------------------------------------------------

    //ข้อมูล HD
    public function FSaMPAMGetDataDocHD($paDataWhere){
        $tPAMDocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID     = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            PAMCHD.FTXthDocNo,
                            PAMCHD.FDXthDocDate,
                            PAMCHD.FTXthStaDoc,
                            PAMCHD.FTXthStaApv,
                            PAMCHD.FTDptCode,
                            PAMCHD.FTXthApvCode,
                            /*PAMCHD.FTXthRefInt,
                            PAMCHD.FDXthRefIntDate,
                            PAMCHD.FTXthRefExt,
                            PAMCHD.FDXthRefExtDate,*/
                            PAMCHD.FNXthStaRef,
                            PAMCHD.FTWahCode,
                            PAMCHD.FNXthStaDocAct,
                            PAMCHD.FNXthDocPrint,
                            PAMCHD.FTXthRmk,
                            /*PAMCHD.FTRteCode,
                            PAMCHD.FTXthVATInOrEx,
                            PAMCHD.FTXthCshOrCrd,*/
                            PAMCHD.FNXthStaDocAct,
                            PAMCHD.FDCreateOn AS DateOn,
                            PAMCHD.FTCreateBy AS CreateBy,
                            PAMCHD.FTBchCode,
                            BCHL.FTBchName,
                            DPTL.FTDptName,
                            USRL.FTUsrName,
                            /*RTE_L.FTRteName,*/
                            USRAPV.FTUsrName	AS FTXthApvName,
                            /*PAMSPL.FNXphCrTerm,
                            PAMSPL.FTXphCtrName,
                            PAMSPL.FDXphTnfDate,
                            PAMSPL.FTXphRefTnfID,
                            PAMSPL.FTXphRefVehID,
                            PAMSPL.FTXphRefInvNo,*/
                            SPL.FTCreateBy,
                            SPL.FTSplCode,
                            SPL_L.FTSplName,
                            /*POHD.FTBchCode AS rtPOBchCode,
                            POBCHL.FTBchName AS rtPOBchName ,*/
                            AGN.FTAgnCode       AS rtAgnCode,
                            AGN.FTAgnName       AS rtAgnName,
                            WAH_L.FTWahCode     AS rtWahCode,
                            WAH_L.FTWahName     AS rtWahName,
                            PAMCHD.FTPlcCode,
                            PLC_L.FTPlcName,
                            ISNULL(PAMCHD.FTXthStaDocAuto,'1') AS FTXthStaDocAuto,

                            PAMCHD.FTXthCat1 AS FTCat1Code,
                            CAT1_L.FTCatName AS FTCat1Name,
                            PAMCHD.FTXthCat2 AS FTCat2Code,
                            CAT2_L.FTCatName AS FTCat2Name,
                            PAMCHD.FTXthCat3 AS FTCat3Code,
                            CAT3_L.FTCatName AS FTCat3Name,
                            PAMCHD.FTXthCat4 AS FTCat4Code,
                            CAT4_L.FTCatName AS FTCat4Name,
                            PAMCHD.FTXthCat5 AS FTCat5Code,
                            CAT5_L.FTCatName AS FTCat5Name,

                            PAMCHD.FNXthDocType
                        FROM TCNTPdtPickHD          PAMCHD  WITH (NOLOCK)
                        /*INNER JOIN TCNMBranch       BCH     WITH (NOLOCK)   ON PAMCHD.FTBchCode      = BCH.FTBchCode*/   
                        /*LEFT JOIN TAPTDoHDSpl       PAMSPL   WITH (NOLOCK)   ON PAMCHD.FTXphDocNo     = PAMSPL.FTXphDocNo*/
                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK)   ON PAMCHD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID	= $nLngID
                        LEFT JOIN TCNMAgency_L      AGN     WITH (NOLOCK)   ON PAMCHD.FTAgnCode     = AGN.FTAgnCode     AND AGN.FNLngID	    = $nLngID
                        LEFT JOIN TCNMUsrDepart_L	DPTL    WITH (NOLOCK)   ON PAMCHD.FTDptCode     = DPTL.FTDptCode	AND DPTL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK)   ON PAMCHD.FTUsrCode     = USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK)   ON PAMCHD.FTXthApvCode	= USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMSpl           SPL     WITH (NOLOCK)   ON PAMCHD.FTSplCode		= SPL.FTSplCode
                        LEFT JOIN TCNMSpl_L         SPL_L   WITH (NOLOCK)   ON PAMCHD.FTSplCode		= SPL_L.FTSplCode   AND SPL_L.FNLngID	= $nLngID
                        /*LEFT JOIN TFNMRate_L        RTE_L   WITH (NOLOCK)   ON PAMCHD.FTRteCode      = RTE_L.FTRteCode   AND RTE_L.FNLngID	= $nLngID*/
                        LEFT JOIN TCNMWaHouse_L     WAH_L   WITH (NOLOCK)   ON PAMCHD.FTBchCode      = WAH_L.FTBchCode   AND PAMCHD.FTWahCode = WAH_L.FTWahCode AND WAH_L.FNLngID	= $nLngID
                        /*LEFT JOIN TAPTPoHD          POHD   WITH (NOLOCK)    ON PAMCHD.FTXphRefInt    = POHD.FTXphDocNo
                        LEFT JOIN TCNMBranch_L      POBCHL   WITH (NOLOCK)   ON POHD.FTBchCode     = POBCHL.FTBchCode   AND POBCHL.FNLngID	= $nLngID*/
                        LEFT JOIN TCNMPdtLoc_L      PLC_L   WITH (NOLOCK)   ON PAMCHD.FTPlcCode     = PLC_L.FTPlcCode   AND PLC_L.FNLngID	= $nLngID
                        
                        LEFT JOIN TCNMPdtCatInfo_L  CAT1_L  WITH (NOLOCK)   ON PAMCHD.FTXthCat1 = CAT1_L.FTCatCode AND CAT1_L.FNCatLevel = 1 AND CAT1_L.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtCatInfo_L  CAT2_L  WITH (NOLOCK)   ON PAMCHD.FTXthCat2 = CAT2_L.FTCatCode AND CAT2_L.FNCatLevel = 2 AND CAT2_L.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtCatInfo_L  CAT3_L  WITH (NOLOCK)   ON PAMCHD.FTXthCat3 = CAT3_L.FTCatCode AND CAT3_L.FNCatLevel = 3 AND CAT3_L.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtCatInfo_L  CAT4_L  WITH (NOLOCK)   ON PAMCHD.FTXthCat4 = CAT4_L.FTCatCode AND CAT4_L.FNCatLevel = 4 AND CAT4_L.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtCatInfo_L  CAT5_L  WITH (NOLOCK)   ON PAMCHD.FTXthCat5 = CAT5_L.FTCatCode AND CAT5_L.FNCatLevel = 5 AND CAT5_L.FNLngID = $nLngID

                        WHERE PAMCHD.FTXthDocNo = '$tPAMDocNo' ";

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

    // Function : Get Data Document HD Spl
    public function FSaMPAMGetDataDocHDSpl($paDataWhere){
        $tPAMDocNo   = $paDataWhere['FTXphDocNo'];
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
                        FROM TAPTDoHDSpl HDSPL  WITH (NOLOCK)
                        LEFT JOIN TCNMAddress_L			SHIP_Add    WITH (NOLOCK)   ON HDSPL.FNXphShipAdd       = SHIP_Add.FNAddSeqNo	AND SHIP_Add.FNLngID    = $nLngID
                        LEFT JOIN TCNMSubDistrict_L     SHIP_SUDIS 	WITH (NOLOCK)	ON SHIP_Add.FTAddV1SubDist	= SHIP_SUDIS.FTSudCode	AND SHIP_SUDIS.FNLngID  = $nLngID
                        LEFT JOIN TCNMDistrict_L        SHIP_DIS    WITH (NOLOCK)	ON SHIP_Add.FTAddV1DstCode	= SHIP_DIS.FTDstCode    AND SHIP_DIS.FNLngID    = $nLngID
                        LEFT JOIN TCNMProvince_L        SHIP_PVN    WITH (NOLOCK)	ON SHIP_Add.FTAddV1PvnCode	= SHIP_PVN.FTPvnCode    AND SHIP_PVN.FNLngID    = $nLngID
                        LEFT JOIN TCNMAddress_L			TAX_Add     WITH (NOLOCK)   ON HDSPL.FNXphTaxAdd        = TAX_Add.FNAddSeqNo	AND TAX_Add.FNLngID		= $nLngID
                        LEFT JOIN TCNMSubDistrict_L     TAX_SUDIS 	WITH (NOLOCK)	ON TAX_Add.FTAddV1SubDist   = TAX_SUDIS.FTSudCode	AND TAX_SUDIS.FNLngID	= $nLngID
                        LEFT JOIN TCNMDistrict_L        TAX_DIS     WITH (NOLOCK)	ON TAX_Add.FTAddV1DstCode   = TAX_DIS.FTDstCode     AND TAX_DIS.FNLngID     = $nLngID
                        LEFT JOIN TCNMProvince_L        TAX_PVN     WITH (NOLOCK)	ON TAX_Add.FTAddV1PvnCode   = TAX_PVN.FTPvnCode		AND TAX_PVN.FNLngID     = $nLngID
                        WHERE 1=1 AND HDSPL.FTXphDocNo = '$tPAMDocNo'
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

    //ลบข้อมูลใน Temp
    public function FSnMPAMDelALLTmp($paData){
        try {
            $this->db->trans_begin();

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

    //ย้ายจาก DT To Temp
    public function FSxMPAMMoveDTToDTTemp($paDataWhere){
        $tPAMDocNo       = $paDataWhere['FTXthDocNo'];
        $tDocKey        = $paDataWhere['FTXthDocKey'];
        
        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocNo',$tPAMDocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL   = " INSERT INTO TCNTDocDTTmp (
            FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
            FCXtdQty,FCXtdQtyAll/*,FCXtdQtyLef,FCXtdQtyRfn*/,FTXtdStaPrcStk,FTXtdStaAlwDis/*,FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet*/,
            FTXtdPdtStaSet,FTXtdRmk,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy,FTXtdPdtSetOrSN,FCXtdQtyOrd )
        SELECT
            DT.FTBchCode,
            DT.FTXthDocNo,
            DT.FNXtdSeqNo,
            CONVERT(VARCHAR,'".$tDocKey."') AS FTXthDocKey,
            DT.FTPdtCode,
            DT.FTXtdPdtName,
            DT.FTPunCode,
            DT.FTPunName,
            DT.FCXtdFactor,
            DT.FTXtdBarCode,
            DT.FCXtdQty,
            DT.FCXtdQtyAll,
            /*DT.FCXtdQtyLef,
            DT.FCXtdQtyRfn,*/
            DT.FTXtdStaPrcStk,
            DT.FTXtdStaAlwDis,
            /*DT.FNXtdPdtLevel,
            DT.FTXtdPdtParent,
            DT.FCXtdQtySet,*/
            DT.FTPdtStaSet,
            DT.FTXtdRmk,
            CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
            CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
            CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy,
            ISNULL(PDT.FTPdtSetOrSN,'1') AS FTPdtSetOrSN,
            DT.FCXtdQtyOrd
        FROM TCNTPdtPickDT DT WITH(NOLOCK)
        LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        WHERE DT.FTXthDocNo = '$tPAMDocNo'
        ORDER BY DT.FNXtdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // นำข้อมูลจาก Browse ลง DTTemp
    public function FSoMPAMCallRefIntDocInsertDTToTemp($paData){

        $tPAMDocNo        = $paData['tPAMDocNo'];
        $tPAMFrmBchCode   = $paData['tPAMFrmBchCode'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTBchCode',$tPAMFrmBchCode);
        $this->db->where('FTXthDocNo',$tPAMDocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tRefIntDocNo   = $paData['tRefIntDocNo'];
        $tRefIntBchCode = $paData['tRefIntBchCode'];
        $aSeqNo         = '(' . implode(',', $paData['aSeqNo']) .')';

       $tSQL= "INSERT INTO TCNTDocDTTmp (
                FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
                FCXtdQty,FCXtdQtyAll,FCXtdQtyLef,FCXtdQtyRfn,FTXtdStaPrcStk,FTXtdStaAlwDis,FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,
                FTXtdPdtStaSet,FTXtdRmk,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy )
                SELECT
                    '$tPAMFrmBchCode' as FTBchCode,
                    '$tPAMDocNo' as FTXphDocNo,
                    DT.FNXpdSeqNo,
                    'TAPTDoDT' AS FTXthDocKey,
                    DT.FTPdtCode,
                    DT.FTXpdPdtName,
                    DT.FTPunCode,
                    DT.FTPunName,
                    DT.FCXpdFactor,
                    DT.FTXpdBarCode,
                    DT.FCXpdQtyLef AS FCXtdQty,
                    DT.FCXpdQtyLef AS FCXtdQtyAll,
                    0 as FCXpdQtyLef,
                    0 as FCXpdQtyRfn,
                    '' as FTXpdStaPrcStk,
                    PDT.FTPdtStaAlwDis,
                    0 as FNXpdPdtLevel,
                    '' as FTXpdPdtParent,
                    0 as FCXpdQtySet,
                    '' as FTPdtStaSet,
                    '' as FTXpdRmk,   
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
                    CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                    CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                FROM
                    TAPTPoDT DT WITH (NOLOCK)
                    LEFT JOIN TCNMPdt PDT WITH (NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                WHERE  DT.FTBchCode = '$tRefIntBchCode' AND  DT.FTXphDocNo ='$tRefIntDocNo' AND DT.FNXpdSeqNo IN $aSeqNo
                ";
    
        $oQuery = $this->db->query($tSQL);
        if($this->db->affected_rows() > 0){
            $aResult = array(
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        return $aResult;

    }

    // Function: Delete Purchase Invoice Document
    public function FSnMPAMDelDocument($paDataDoc){
        $tDataDocNo = $paDataDoc['tDataDocNo'];
        $tBchCode   = $paDataDoc['tBchCode'];
        $this->db->trans_begin();

        // Document HD
        $this->db->where('FTXthDocNo',$tDataDocNo);
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->delete('TCNTPdtPickHD');
        
        // Document DT
        $this->db->where('FTXthDocNo',$tDataDocNo);
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->delete('TCNTPdtPickDT');

        $this->db->where('FTXthDocNo',$tDataDocNo);
        $this->db->delete('TCNTPdtPickHDDocRef');

        // ลบอ้างอิง ใบจ่ายโอนสินค้า-สาขา
        $this->db->where('FTXthRefDocNo',$tDataDocNo);
        $this->db->delete('TCNTPdtTboHDDocRef');

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

    // Function : Cancel Document Data
    public function FSxMPAMCancelDocument($paDataUpdate){
        // TCNTPdtPickHD
        $this->db->set('FTXthStaDoc', '3');
        $this->db->set('FTXthApvCode', '');
        $this->db->set('FTXthStaApv', '');
        $this->db->where('FTXthDocNo', $paDataUpdate['tDocNo']);
        $this->db->update('TCNTPdtPickHD');

        $this->db->where('FTXthDocNo', $paDataUpdate['tDocNo']);
        $this->db->delete('TCNTPdtPickHDDocRef');

        if( $paDataUpdate['tDocType'] == '1' ){
            $this->db->where('FTXthRefDocNo', $paDataUpdate['tDocNo']);
            $this->db->delete('TCNTPdtTboHDDocRef');
        }else{
            // ใบขาย ยังไม่มี HDDocRef
        }
    }

    //อนุมัตเอกสาร
    public function FSxMPAMApproveDocument($paDataUpdate){
        // $dLastUpdOn = date('Y-m-d H:i:s');
        // $tLastUpdBy = $this->session->userdata('tSesUsername');

        $this->db->set('FDLastUpdOn',$paDataUpdate['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy',$paDataUpdate['FTXthUsrApv']);
        $this->db->set('FTXthStaApv',$paDataUpdate['FTXthStaApv']);
        $this->db->set('FTXthApvCode',$paDataUpdate['FTXthUsrApv']);
        $this->db->where('FTBchCode',$paDataUpdate['FTBchCode']);
        $this->db->where('FTXthDocNo',$paDataUpdate['FTXthDocNo']);
        $this->db->update('TCNTPdtPickHD');
    }

    public function FSaMPAMUpdatePOStaPrcDoc($ptRefInDocNo)
    {
        $nStaPrcDoc = 1;
        $this->db->set('FTXphStaPrcDoc',$nStaPrcDoc);
        $this->db->where('FTXphDocNo',$ptRefInDocNo);
        $this->db->update('TAPTPoHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Updated Status Document Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Not Update Status Document.',
            );
        }
        return $aStatus;
    }

    public function FSaMPAMUpdatePOStaRef($ptRefInDocNo, $pnStaRef)
    {
        $this->db->set('FNXphStaRef',$pnStaRef);
        $this->db->where('FTXphDocNo',$ptRefInDocNo);
        $this->db->update('TAPTPoHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Updated Status Document Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Not Update Status Document.',
            );
        }
        return $aStatus;
    }

    public function FSaMPAMQaAddUpdateRefDocHD($aDataWhere, $aTableAddUpdate, $aDataWhereDocRefPAM, $aDataWhereDocRefPO, $aDataWhereDocRefPAMExt)
    {
        try { 
            $tTableRefPAM     = $aTableAddUpdate['tTableRefPAM'];
            $tTableRefPO  = $aTableAddUpdate['tTableRefPO'];

            if ($aDataWhereDocRefPAM != '') {
                $nChhkDataDocRefPAM  = $this->FSaMPAMChkRefDupicate($aDataWhere, $tTableRefPAM, $aDataWhereDocRefPAM);

                //หากพบว่าซ้ำ
                if(isset($nChhkDataDocRefPAM['rtCode']) && $nChhkDataDocRefPAM['rtCode'] == 1){
                    //ลบ

                    $this->db->where_in('FTAgnCode',$aDataWhereDocRefPAM['FTAgnCode']);
                    $this->db->where_in('FTBchCode',$aDataWhereDocRefPAM['FTBchCode']);
                    $this->db->where_in('FTXthDocNo',$aDataWhereDocRefPAM['FTXshDocNo']);
                    $this->db->where_in('FTXthRefType',$aDataWhereDocRefPAM['FTXshRefType']);
                    $this->db->where_in('FTXthRefDocNo',$aDataWhereDocRefPAM['FTXshRefDocNo']);
                    $this->db->delete($tTableRefPAM);
    
                    $this->db->last_query();
    
                    //เพิ่มใหม่
                    $this->db->insert($tTableRefPAM,$aDataWhereDocRefPAM);
                //หากพบว่าไม่ซ้ำ
                }else{
                    $this->db->insert($tTableRefPAM,$aDataWhereDocRefPAM);
                }    
            }

            if ($aDataWhereDocRefPO != '') {
                $nChhkDataDocRefPO  = $this->FSaMPAMChkRefDupicate($aDataWhere, $tTableRefPO, $aDataWhereDocRefPO);
                
                //หากพบว่าซ้ำ
                if(isset($nChhkDataDocRefPO['rtCode']) && $nChhkDataDocRefPO['rtCode'] == 1){
                    //ลบ
                    $this->db->where_in('FTAgnCode',$aDataWhereDocRefPO['FTAgnCode']);
                    $this->db->where_in('FTBchCode',$aDataWhereDocRefPO['FTBchCode']);
                    $this->db->where_in('FTXthDocNo',$aDataWhereDocRefPO['FTXshDocNo']);
                    $this->db->where_in('FTXthRefType',$aDataWhereDocRefPO['FTXshRefType']);
                    $this->db->where_in('FTXthRefDocNo',$aDataWhereDocRefPO['FTXshRefDocNo']);
                    $this->db->delete($tTableRefPO);
    
                    //เพิ่มใหม่
                    $this->db->insert($tTableRefPO,$aDataWhereDocRefPO);
                //หากพบว่าไม่ซ้ำ
                }else{
                    $this->db->insert($tTableRefPO,$aDataWhereDocRefPO);
                }    
            }
           
            if ($aDataWhereDocRefPAMExt != '') {
                $nChhkDataDocRefExt  = $this->FSaMPAMChkRefDupicate($aDataWhere, $tTableRefPAM, $aDataWhereDocRefPAMExt);

                //หากพบว่าซ้ำ
                if(isset($nChhkDataDocRefExt['rtCode']) && $nChhkDataDocRefExt['rtCode'] == 1){
                    //ลบ
                    $this->db->where_in('FTAgnCode',$aDataWhereDocRefPAMExt['FTAgnCode']);
                    $this->db->where_in('FTBchCode',$aDataWhereDocRefPAMExt['FTBchCode']);
                    $this->db->where_in('FTXthDocNo',$aDataWhereDocRefPAMExt['FTXshDocNo']);
                    $this->db->where_in('FTXthRefType',$aDataWhereDocRefPAMExt['FTXshRefType']);
                    $this->db->where_in('FTXthRefDocNo',$aDataWhereDocRefPAMExt['FTXshRefDocNo']);
                    $this->db->delete($tTableRefPAM);

                    //เพิ่มใหม่
                    $this->db->insert($tTableRefPAM,$aDataWhereDocRefPAMExt);
                //หากพบว่าไม่ซ้ำ
                }else{
                    $this->db->insert($tTableRefPAM,$aDataWhereDocRefPAMExt);
                }
            }

            $aReturnData = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'insert DocRef success'
            );
            
        }catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }

        return $aReturnData;
    }
    
    //เช็คข้อมูล Insert ว่าซ้ำหรือไม่ ถ้าซ้ำให้ลบและค่อยเพิ่มใหม่
    public function FSaMPAMChkRefDupicate($aDataWhere, $tTableRef, $aDataWhereDocRef)
    {
        try{

            $tAgnCode = $aDataWhereDocRef['FTAgnCode'];
            $tBchCode = $aDataWhereDocRef['FTBchCode'];
            $tDocNo   = $aDataWhereDocRef['FTXshDocNo'];
            $tRefDocType   = $aDataWhereDocRef['FTXshRefType'];
            $tRefDocNo   = $aDataWhereDocRef['FTXshRefDocNo'];

            $tSQL = "   SELECT 
                            FTAgnCode,
                            FTBchCode,
                            FTXthDocNo
                        FROM $tTableRef
                        WHERE 1=1
                        AND FTAgnCode     = '$tAgnCode'
                        AND FTBchCode     = '$tBchCode'
                        AND FTXthDocNo    = '$tDocNo'
                        AND FTXthRefType  = '$tRefDocType'
                        AND FTXthRefDocNo = '$tRefDocNo'
                    ";
            $oQueryHD = $this->db->query($tSQL);
            if ($oQueryHD->num_rows() > 0){
                $aDetail = $oQueryHD->row_array();
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
            
        }catch (Exception $Error) {
            echo $Error;
        }
    }
    /* End of file deliveryorder_model.php */    

    public function FSaMPAMUpdatePOFNStaRef($ptBchCode,$ptRefInDocNo){
        $tSQL   = "
            UPDATE POHD
            SET POHD.FNXphStaRef = PODT.FNXphStaRef
            FROM TAPTPoHD POHD
            INNER JOIN (
                SELECT
                    CHKDTPO.FTBchCode,
                    CHKDTPO.FTXphDocNo,
                    CASE WHEN CHKDTPO.FNSumQtyLef = '0' THEN '2' ELSE '1' END AS FNXphStaRef
                FROM (
                    SELECT
                        PODT.FTBchCode,
                        PODT.FTXphDocNo,
                        SUM(PODT.FCXpdQtyLef) AS FNSumQtyLef
                    FROM TAPTPoDT PODT WITH(NOLOCK)
                    WHERE PODT.FTBchCode = '".$ptBchCode."' AND PODT.FTXphDocNo = '".$ptRefInDocNo."'
                    GROUP BY PODT.FTBchCode,PODT.FTXphDocNo
                ) CHKDTPO
            ) PODT ON POHD.FTBchCode = PODT.FTBchCode AND POHD.FTXphDocNo = PODT.FTXphDocNo
        ";
        
        $oQuery = $this->db->query($tSQL);
    }

    // Create By : Napat(Jame) 21/12/2021
    // อัพเดทสถานะ จัดสินค้าเสร็จแล้ว เมื่อใบจัดสินค้าอนุมัติครบทุกใบแล้ว
    public function FSxMPAMCheckDocRef($paData){
        $tDocNo     = $paData['FTXthDocNo'];
        $tUsrCode   = $paData['FTXthUsrApv'];
        $dDate      = $paData['FDLastUpdOn'];
        $tDocType   = $paData['FNXthDocType'];

        if( $tDocType == '1' ){ // กรณีใบจัดสินค้าที่เกิดจากใบจ่ายโอน-สาขา
            // ค้นหาใบจัดสินค้าที่เกิดจากใบจ่ายโอน-สาขา ที่ยังไม่อนุมัติ
            $tSQL = "   SELECT PCKAPV.FTXthDocNo,PCKAPV.FTXthStaApv,PCK.FTXthRefDocNo
                        FROM TCNTPdtPickHDDocRef       PCK     WITH(NOLOCK)
                        INNER JOIN TCNTPdtTboHDDocRef  TBO     WITH(NOLOCK) ON PCK.FTXthRefDocNo = TBO.FTXthDocNo AND TBO.FTXthRefKey = 'PdtPick'
                        LEFT JOIN TCNTPdtPickHD	       PCKAPV  WITH(NOLOCK) ON TBO.FTXthRefDocNo = PCKAPV.FTXthDocNo
                        WHERE PCK.FTXthDocNo = '$tDocNo'
                        AND PCK.FTXthRefType = '1' 
                        AND (PCK.FTXthRefKey = 'PdtTbo' OR PCK.FTXthRefKey = 'TBO')
                        AND ISNULL(PCKAPV.FTXthStaApv,'') <> '1' ";
            $oQuery = $this->db->query($tSQL);
            if ( $oQuery->num_rows() == 0 ){ 
                // ใบจัดสินค้าที่เกิดจากใบจ่ายโอน-สาขา อนุมัติครบทุกใบแล้ว 
                // ปรับสถานะ StaPrcDoc = 4(รออนุมัติ) เอกสารใบจ่ายโอน-สาขา
                $tSQL1 = "  SELECT TOP 1 PCK.FTXthRefDocNo
                            FROM TCNTPdtPickHDDocRef PCK WITH(NOLOCK)
                            WHERE PCK.FTXthDocNo = '$tDocNo'
                            AND PCK.FTXthRefType = '1'
                            AND (PCK.FTXthRefKey = 'PdtTbo' OR PCK.FTXthRefKey = 'TBO') ";
                $oQuery1 = $this->db->query($tSQL1);
                if ( $oQuery1->num_rows() > 0 ){
                    $tDocNoTBO  = $oQuery1->row_array()['FTXthRefDocNo'];
                    $this->db->set('FDLastUpdOn',$dDate);
                    $this->db->set('FTLastUpdBy',$tUsrCode);
                    $this->db->set('FTXthStaPrcDoc','4');
                    $this->db->where('FTXthDocNo',$tDocNoTBO);
                    $this->db->update('TCNTPdtTboHD');
                }
            }
        }else{ // กรณีใบจัดสินค้าที่เกิดจากใบขาย
            // ค้นหาใบจัดสินค้าที่เกิดจากใบขาย ที่ยังไม่อนุมัติ
            $tSQL = "   SELECT HD.FTXthDocNo,HD.FTXthStaApv,REF.FTXthRefDocNo
                        FROM TCNTPdtPickHDDocRef REF WITH(NOLOCK)
                        INNER JOIN TCNTPdtPickHD HD WITH(NOLOCK) ON REF.FTXthDocNo = HD.FTXthDocNo
                        WHERE REF.FTXthRefKey   = 'SALE'
                        AND REF.FTXthRefType    = '1'
                        AND REF.FTXthDocNo      = '$tDocNo'
                        AND ISNULL(HD.FTXthStaApv,'') <> '1' ";
            $oQuery = $this->db->query($tSQL);
            if ( $oQuery->num_rows() == 0 ){ 
                // ใบจัดสินค้าที่เกิดจากใบขาย อนุมัติครบทุกใบแล้ว
                // ปรับสถานะ StaPrcDoc = 3(รอจัดส่ง) เอกสารใบขาย
                $tSQL1 = "  SELECT TOP 1 REF.FTXthRefDocNo
                            FROM TCNTPdtPickHDDocRef REF WITH(NOLOCK)
                            WHERE REF.FTXthRefKey   = 'SALE'
                            AND REF.FTXthRefType    = '1'
                            AND REF.FTXthDocNo      = '$tDocNo' ";
                $oQuery1 = $this->db->query($tSQL1);
                if( $oQuery1->num_rows() > 0 ){
                    $tDocNoSale = $oQuery1->result_array()[0]['FTXthRefDocNo'];
                    $this->db->set('FDLastUpdOn',$dDate);
                    $this->db->set('FTLastUpdBy',$tUsrCode);
                    $this->db->set('FTXshStaPrcDoc','7');
                    $this->db->where('FTXshDocNo',$tDocNoSale);
                    $this->db->update('TPSTSalHD');
                }
            }
        }
    }

    // Create By : Napat(Jame) 21/12/2021
    // อัพเดทสถานะ ใบจ่ายโอน-สาขา FTXthStaPrcDoc = '3'(กำลังจัดสินค้า)
    public function FSxMPAMUpdStaPackingTBO($paData){
        $tDocNo     = $paData['FTXthDocNo'];
        $tUsrCode   = $paData['FTLastUpdBy'];
        $dDate      = $paData['FDLastUpdOn'];

        $tSQL = "   UPDATE TCNTPdtTboHD
                    SET TCNTPdtTboHD.FTXthStaPrcDoc = '3',
                        TCNTPdtTboHD.FDLastUpdOn = '$dDate',
                        TCNTPdtTboHD.FTLastUpdBy = '$tUsrCode'
                    FROM TCNTPdtPickHDDocRef PCK WITH(NOLOCK)
                    WHERE PCK.FTXthDocNo = '$tDocNo'
                      AND PCK.FTXthRefType = '1'
                      AND (PCK.FTXthRefKey = 'PdtTbo' OR PCK.FTXthRefKey = 'TBO')
                      AND TCNTPdtTboHD.FTXthDocNo = PCK.FTXthRefDocNo
                      AND TCNTPdtTboHD.FTXthStaPrcDoc = '2' ";
        $this->db->query($tSQL);
    }

    // Create By : Napat(Jame) 21/12/2021
    // กรณี ลบหรือยกเลิกเอกสารใบจัดสินค้าครบทุกใบ จะต้อง
    // ปรับสถานะ ใบจ่ายโอน-สาขา FTXthStaPrcDoc = '1'(รอสร้างใบจัด)
    public function FSxMPAMUpdTboOnCancelOrDelete($paData){
        $tDocNo     = $paData['tDocNo'];
        $tUsrCode   = $paData['FTLastUpdBy'];
        $dDate      = $paData['FDLastUpdOn'];

        $tSQL = "   SELECT TBOREF.FTXthRefDocNo
                    FROM TCNTPdtPickHDDocRef      PICKREF WITH(NOLOCK)
                    INNER JOIN TCNTPdtTboHDDocRef TBOREF  WITH(NOLOCK) ON PICKREF.FTXthRefDocNo = TBOREF.FTXthDocNo
                    WHERE PICKREF.FTXthDocNo = '$tDocNo'
                      AND TBOREF.FTXthRefType = '2'
                      AND TBOREF.FTXthRefKey = 'PdtPick' 
                      AND TBOREF.FTXthRefDocNo <> '$tDocNo' ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() == 0 ){
            $tSQL1 = "  SELECT PICKREF.FTXthRefDocNo
                        FROM TCNTPdtPickHDDocRef PICKREF WITH(NOLOCK)
                        WHERE PICKREF.FTXthDocNo = '$tDocNo'
                        AND PICKREF.FTXthRefType = '1'
                        AND PICKREF.FTXthRefKey IN ('PdtTbo','TBO') ";
            $oQuery1 = $this->db->query($tSQL1);
            if ( $oQuery1->num_rows() > 0 ){
                $tDocNoTBO  = $oQuery1->row_array()['FTXthRefDocNo'];
                $this->db->set('FDLastUpdOn',$dDate);
                $this->db->set('FTLastUpdBy',$tUsrCode);
                $this->db->set('FTXthStaPrcDoc','1');
                $this->db->where('FTXthDocNo',$tDocNoTBO);
                $this->db->update('TCNTPdtTboHD');
            }
        }
    }

    // Create By : Napat(Jame) 17/01/2022
    // กรณี ลบหรือยกเลิกเอกสารใบจัดสินค้าครบทุกใบ จะต้อง
    // ปรับสถานะ ใบขาย FTXthStaPrcDoc = '1'(รอสร้างใบจัด)
    public function FSxMPAMUpdSaleOnCancelOrDelete($paData){
        $tDocNo     = $paData['tDocNo'];
        $tUsrCode   = $paData['FTLastUpdBy'];
        $dDate      = $paData['FDLastUpdOn'];

        // เอาเลขที่บิลขายไปค้นหาใน ตารางอ้างอิงของใบจัดสินค้า 
        // ที่ไม่ใช่ใบจัดสินค้าใบที่ทำรายการ ยกเลิก/ลบ
        $tSQL = "   SELECT SALE.FTXthRefDocNo
                    FROM TCNTPdtPickHDDocRef      PICK WITH(NOLOCK)
                    INNER JOIN TCNTPdtPickHDDocRef SALE WITH(NOLOCK) ON PICK.FTXthRefDocNo = SALE.FTXthRefDocNo AND PICK.FTXthDocNo <> SALE.FTXthDocNo
                    WHERE PICK.FTXthDocNo = '$tDocNo'
                    AND PICK.FTXthRefType = '1'
                    AND PICK.FTXthRefKey IN ('SALE') ";
        $oQuery = $this->db->query($tSQL);
        // echo $tSQL;
        if ( $oQuery->num_rows() == 0 ){
                // ดึงเลขที่บิลขายมา เพื่อไป where
                $tSQL1 = "  SELECT TOP 1 SALE.FTXthRefDocNo
                            FROM TCNTPdtPickHDDocRef      PICK WITH(NOLOCK)
                            INNER JOIN TCNTPdtPickHDDocRef SALE WITH(NOLOCK) ON PICK.FTXthRefDocNo = SALE.FTXthRefDocNo
                            WHERE PICK.FTXthDocNo = '$tDocNo'
                            AND PICK.FTXthRefType = '1'
                            AND PICK.FTXthRefKey IN ('SALE') ";
                $oQuery1 = $this->db->query($tSQL1);
                // echo $tSQL1;
                if ( $oQuery1->num_rows() > 0 ){
                    // ปรับสถานะ ใบขาย FTXthStaPrcDoc = '1'(รอสร้างใบจัด)
                    $tDocNoSale = $oQuery1->row_array()['FTXthRefDocNo'];
                    $this->db->set('FDLastUpdOn',$dDate);
                    $this->db->set('FTLastUpdBy',$tUsrCode);
                    $this->db->set('FTXshStaPrcDoc','1');
                    $this->db->where('FTXshDocNo',$tDocNoSale);
                    $this->db->update('TPSTSalHD');
                    // echo $this->db->last_query();
                }
        }
    }

    //ข้อมูล HDDocRef
    public function FSxMPAMMoveHDRefToHDRefTemp($paData){

        $tDocNo         = $paData['FTXthDocNo'];
        $tSessionID     = $this->session->userdata('tSesSessionID');

        $this->db->where('FTXthDocKey','TCNTPdtPickHD');
        $this->db->where('FTSessionID',$tSessionID);
        $this->db->delete('TCNTDocHDRefTmp');

        $tSQL = "   INSERT INTO TCNTDocHDRefTmp (FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate, FTXthDocKey, FTSessionID , FDCreateOn)";
        $tSQL .= "  SELECT
                        FTXthDocNo,
                        FTXthRefDocNo,
                        FTXthRefType,
                        FTXthRefKey,
                        FDXthRefDocDate,
                        'TCNTPdtPickHD' AS FTXthDocKey,
                        '$tSessionID'  AS FTSessionID,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn
                    FROM TCNTPdtPickHDDocRef WITH(NOLOCK)
                    WHERE FTXthDocNo = '$tDocNo' ";
        $this->db->query($tSQL);
    }

    // แท็บ อ้างอิงเอกสาร - โหลด
    public function FSaMPAMGetDataHDRefTmp($paData){

        $tTableTmpHDRef = $paData['tTableTmpHDRef'];
        $FTXthDocNo     = $paData['FTXthDocNo'];
        $FTXthDocKey    = $paData['FTXthDocKey'];
        $FTSessionID    = $paData['FTSessionID'];

        $tSQL = "   SELECT TMP.FTXthDocNo, TMP.FTXthRefDocNo, TMP.FTXthRefType, TMP.FTXthRefKey, TMP.FDXthRefDocDate
                    FROM $tTableTmpHDRef TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo  = '$FTXthDocNo'
                      AND TMP.FTXthDocKey = '$FTXthDocKey'
                      AND TMP.FTSessionID = '$FTSessionID'
                    ORDER BY TMP.FDCreateOn DESC
                 ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        if ( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'found data',
            );
        }else{
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found.',
            );
        }
        return $aResult;

    }

    // Create By: Napat(Jame) 23/12/2021
    public function FSaMPAMGetDataSNByPdt($paData){
        $tDocNo         = $paData['tDocNo'];
        $nSeqNo         = $paData['nSeqNo'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "   SELECT 
                        SNTMP.FNXtdSeqNo,
                        SNTMP.FTPdtSerial,
                        DTTMP.FTPdtCode,
                        DTTMP.FTXtdPdtName AS FTPdtName,
                        DTTMP.FTXtdBarCode AS FTBarCode
                    FROM TCNTDocDTSNTmp SNTMP WITH(NOLOCK)
                    INNER JOIN TCNTDocDTTmp DTTMP WITH(NOLOCK) ON SNTMP.FTXthDocNo = DTTMP.FTXthDocNo AND SNTMP.FNXtdSeqNo = DTTMP.FNXtdSeqNo
                    WHERE SNTMP.FTXthDocNo = '$tDocNo'
                      AND SNTMP.FTXthDocKey = 'TCNTPdtPickDT'
                      AND SNTMP.FTSessionID = '$tSesSessionID'
                      AND SNTMP.FNXtdSeqNo = $nSeqNo
                    ORDER BY SNTMP.FTPdtSerial ASC
                ";

        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'           => $oQuery->result_array(),
                'tCode'            => '1',
                'tDesc'            => 'success'
            );
        } else {
            $aResult = array(
                'aItems'            => array(),
                'tCode'             => '800',
                'tDesc'             => 'data not found'
            );
        }
        return $aResult;
    }

    // Create By: Napat(Jame) 23/12/2021
    public function FSxMPAMMoveDTSNToDTSNTemp($paDataWhere){
        $tPAMDocNo          = $paDataWhere['FTXthDocNo'];
        $tDocKey            = $paDataWhere['FTXthDocKey'];
        $tSesSessionID      = $this->session->userdata('tSesSessionID');
        
        // Delect Document DTTemp By Doc No
        $this->db->where('FTSessionID',$tSesSessionID);
        $this->db->delete('TCNTDocDTSNTmp');

        $tSQL   = " INSERT INTO TCNTDocDTSNTmp ( FTAgnCode, FTBchCode, FTXthDocNo, FNXtdSeqNo, FTPdtSerial, FTXtdStaRet, 
                    FTPdtBatchID, FDLastUpdOn, FDCreateOn, FTLastUpdBy, FTCreateBy, FTXthDocKey, FTSessionID )
                    SELECT 
                        DTSN.FTAgnCode, DTSN.FTBchCode, DTSN.FTXthDocNo, DTSN.FNXtdSeqNo, DTSN.FTPdtSerial, DTSN.FTXtdStaRet, DTSN.FTPdtBatchID, 

                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."')                         AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."')                         AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."')     AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."')     AS FTCreateBy,

                        CONVERT(VARCHAR,'".$tDocKey."')                                     AS FTXthDocKey, 
                        CONVERT(VARCHAR,'".$tSesSessionID."')                               AS FTSessionID
                        
                    FROM TCNTPdtPickDTSN DTSN WITH(NOLOCK)
                    WHERE DTSN.FTXthDocNo = '$tPAMDocNo' ";
        $this->db->query($tSQL);
    }

    // Create By: Napat(Jame) 23/12/2021
    public function FSxMPAMEventAddPdtSN($paInsertData){
        $this->db->insert('TCNTDocDTSNTmp',$paInsertData);
    }

    // Create By: Napat(Jame) 10/01/2022
    public function FSxMPAMEventUpdDTQtyFromDTSN($paData){
        $tSQL = "   UPDATE TCNTDocDTTmp
                    SET TCNTDocDTTmp.FCXtdQty = CASE WHEN A.FNCountPdtSN IS NULL THEN 0 ELSE A.FNCountPdtSN END,
                    TCNTDocDTTmp.FCXtdQtyAll = DT.FCXtdFactor * CASE WHEN A.FNCountPdtSN IS NULL THEN 0 ELSE A.FNCountPdtSN END
                    FROM TCNTDocDTTmp DT WITH(NOLOCK)
                    LEFT JOIN (
                        SELECT
                            DTSN.FNXtdSeqNo,
                            COUNT(ISNULL(DTSN.FNXtdSeqNo,0)) AS FNCountPdtSN
                        FROM TCNTDocDTSNTmp DTSN WITH(NOLOCK)
                        WHERE DTSN.FTXthDocKey = '".$paData['FTXthDocKey']."' 
                        AND DTSN.FTSessionID = '".$paData['FTSessionID']."' 
                        AND DTSN.FTXthDocNo = '".$paData['FTXthDocNo']."'
                        AND DTSN.FNXtdSeqNo = ".$paData['FNXtdSeqNo']."
                        GROUP BY DTSN.FNXtdSeqNo
                    ) A ON DT.FNXtdSeqNo = A.FNXtdSeqNo
                    WHERE DT.FTXthDocKey = '".$paData['FTXthDocKey']."'
                    AND DT.FTSessionID = '".$paData['FTSessionID']."' 
                    AND DT.FTXthDocNo = '".$paData['FTXthDocNo']."'
                    AND DT.FNXtdSeqNo = ".$paData['FNXtdSeqNo']."
                    AND DT.FTXtdPdtSetOrSN IN ('3','4') ";
        $this->db->query($tSQL);
    }

    // Create By: Napat(Jame) 24/12/2021
    public function FSbMPAMEventChkPdtSNDup($paData){
        $tDocNo         = $paData['FTXthDocNo'];
        $nSeqNo         = $paData['FNXtdSeqNo'];
        $tPdtSerial     = $paData['FTPdtSerial'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "   SELECT 
                        SNTMP.FNXtdSeqNo,
                        SNTMP.FTPdtSerial
                    FROM TCNTDocDTSNTmp SNTMP WITH(NOLOCK)
                    WHERE SNTMP.FTXthDocNo = '$tDocNo'
                      AND SNTMP.FNXtdSeqNo = $nSeqNo
                      AND SNTMP.FTPdtSerial = '$tPdtSerial'
                      AND SNTMP.FTXthDocKey = 'TCNTPdtPickDT'
                      AND SNTMP.FTSessionID = '$tSesSessionID'
                ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ( $oQuery->num_rows() > 0 ){
            return true;
        } else {
            return false;
        }
    }

    // Create By: Napat(Jame) 24/12/2021
    public function FSxMPAMEventDeletePdtSN($paData){
        $tAgnCode       = $paData['FTAgnCode'];
        $tBchCode       = $paData['FTBchCode'];
        $tDocNo         = $paData['FTXthDocNo'];
        $nSeqNo         = $paData['FNXtdSeqNo'];
        $tPdtSerial     = $paData['FTPdtSerial'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $this->db->where('FTAgnCode',$tAgnCode);
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->where('FTXthDocNo',$tDocNo);
        $this->db->where('FNXtdSeqNo',$nSeqNo);
        $this->db->where('FTPdtSerial',$tPdtSerial);
        $this->db->where('FTXthDocKey','TCNTPdtPickDT');
        $this->db->where('FTSessionID',$tSesSessionID);
        $this->db->delete('TCNTDocDTSNTmp');
    }

    // Function Move DTSNTemp To DTSN
    public function FSxMPAMMoveDTSNTmpToDTSN($paDataWhere,$paTableAddUpdate){
        $tPAMBchCode     = $paDataWhere['FTBchCode'];
        $tPAMDocNo       = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey      = $paTableAddUpdate['tTableDT'];
        $tPAMDocDTSN     = $paTableAddUpdate['tTableDTSN'];
        $tPAMSessionID   = $paDataWhere['FTSessionID'];
        
        if( isset($tPAMDocNo) && !empty($tPAMDocNo) ){
            $this->db->where_in('FTXthDocNo',$tPAMDocNo);
            $this->db->delete($tPAMDocDTSN);
        }

        $tSQL   = "     INSERT INTO ".$tPAMDocDTSN." ( FTAgnCode, FTBchCode, FTXthDocNo, FNXtdSeqNo, FTPdtSerial, FTXtdStaRet, FTPdtBatchID ) ";
        $tSQL   .=  "   SELECT
                            FTAgnCode, FTBchCode, FTXthDocNo, FNXtdSeqNo, FTPdtSerial, FTXtdStaRet, FTPdtBatchID
                        FROM TCNTDocDTSNTmp WITH (NOLOCK)
                        WHERE FTBchCode    = '$tPAMBchCode'
                          AND FTXthDocNo   = '$tPAMDocNo'
                          AND FTXthDocKey  = '$tPAMDocKey'
                          AND FTSessionID  = '$tPAMSessionID'
        ";
        $this->db->query($tSQL);
    }

    // Create By: Napat(Jame) 27/12/2021
    public function FSbMPAMChkQtyPdt($paDataWhere){
        // $tSQL = "   SELECT 
        //                 DT.FTPdtCode,
        //                 CONVERT(INT,ISNULL(DT.FCXtdQty,0))      AS FCXtdQty,
        //                 CONVERT(INT,ISNULL(DTSN.FTCountSN,0))   AS FTCountSN
        //             FROM TCNTPdtPickDT DT   WITH(NOLOCK)
        //             INNER JOIN TCNMPdt PDT  WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //             LEFT JOIN (
        //                 SELECT FTXthDocNo,FNXtdSeqNo,COUNT(FTPdtSerial) AS FTCountSN 
        //                 FROM TCNTPdtPickDTSN WITH(NOLOCK)
        //                 WHERE FTXthDocNo  = '".$paDataWhere['FTXthDocNo']."'  
        //                 GROUP BY FTXthDocNo,FNXtdSeqNo
        //             ) DTSN ON DT.FTXthDocNo = DTSN.FTXthDocNo AND DT.FNXtdSeqNo = DTSN.FNXtdSeqNo
        //             WHERE PDT.FTPdtSetOrSN IN ('3','4')
        //               AND DT.FTXthDocNo  = '".$paDataWhere['FTXthDocNo']."' 
        //               AND CONVERT(INT,ISNULL(DT.FCXtdQty,0)) <> CONVERT(INT,ISNULL(DTSN.FTCountSN,0))
        //         ";
        $tSQL = "   SELECT FCXtdQty,FCXtdQtyOrd 
                    FROM TCNTPdtPickDT WITH(NOLOCK) 
                    WHERE FTXthDocNo = '".$paDataWhere['FTXthDocNo']."'
                    AND FCXtdQty <> FCXtdQtyOrd ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ( $oQuery->num_rows() > 0 ){
            return true;
        } else {
            return false;
        }
    }

    // Create By: Napat(Jame) 05/01/2021
    public function FSaMPAMEventUpdateDoc($paDataWhere){

        // เช็คใบจ่ายโอน-สาขา อนุมัติหรือยัง ?
        $tSQL = "   SELECT TBO.FTXthStaApv 
                    FROM TCNTPdtPickHDDocRef HDREF WITH(NOLOCK)
                    INNER JOIN TCNTPdtTboHD  TBO   WITH(NOLOCK) ON HDREF.FTXthRefDocNo = TBO.FTXthDocNo
                    WHERE HDREF.FTXthDocNo = '".$paDataWhere['FTXthDocNo']."'
                      AND HDREF.FTBchCode = '".$paDataWhere['FTBchCode']."'
                      AND HDREF.FTXthRefKey = 'PdtTbo'
                      AND HDREF.FTXthRefType = '1'
                      AND TBO.FTXthStaApv <> '1' ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            // ยังไม่ อนุมัติ ปรับปรุงข้อมูลได้
            $this->db->trans_begin();

            $this->db->set('FDLastUpdOn',$paDataWhere['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy',$paDataWhere['FTUsrCode']);

            $this->db->set('FTXthStaApv','');
            $this->db->set('FTXthApvCode','');

            $this->db->where('FTBchCode',$paDataWhere['FTBchCode']);
            $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->update('TCNTPdtPickHD');

            if( $this->db->trans_status() === FALSE ){
                $this->db->trans_rollback();
                $aResult     = array(
                    'tCode'         => '905',
                    'tDesc'         => $this->db->error()['message'],
                );
            }else{
                $this->db->trans_commit();
                $aResult     = array(
                    'tCode'         => '1',
                    'tDesc'         => 'ยกเลิกอนุมัติเอกสาร สำเร็จ',
                );
            }
        }else{
            // อนุมัติ แล้ว ปรับปรุงข้อมูลไม่ได้
            $aResult = array(
                'tCode'             => '800',
                'tDesc'             => 'ใบจ่ายโอน-สาขา อนุมัติแล้วไม่สามารถปรับปรุงข้อมูลได้'
            );
        }
        return $aResult;
    }

    // Create By: Napat(Jame) 13/01/2021
    // อนุญาต รับ S/N ในใบจัด
    public function FSaMPAMChkAlwEnterSN($paDataWhere){

        if( $paDataWhere['FNXthDocType'] == '1' ){
            // ตรวจสอบ Option Wahouse รับ S/N ?
            $tSQL = "   SELECT 
                            ISNULL(WAH.FTWahStaAlwSNPL,'2') AS FTStaAlwEnterSN
                        FROM TCNTPdtPickHDDocRef PICK WITH(NOLOCK)
                        INNER JOIN TCNTPdtTboHD TBO WITH(NOLOCK) ON PICK.FTXthRefDocNo = TBO.FTXthDocNo
                        INNER JOIN TCNMWaHouse WAH WITH(NOLOCK) ON WAH.FTBchCode = TBO.FTXthBchFrm AND WAH.FTWahCode = TBO.FTXthWhFrm
                        WHERE PICK.FTXthDocNo   = '".$paDataWhere['FTXthDocNo']."' 
                          AND PICK.FTXthRefType = '1'
                          AND PICK.FTXthRefKey  = 'PdtTbo'
                          AND ISNULL(WAH.FTWahStaAlwSNPL,'2') = '1' ";
        }else{
            // ตรวจสอบ Option Channels รับ S/N ?
            $tSQL = "   SELECT 
                            ISNULL(CHN.FTChnStaAlwSNPL,'2') AS FTStaAlwEnterSN
                        FROM TCNTPdtPickHDDocRef	PICK WITH(NOLOCK)
                        INNER JOIN TPSTSalHD		SAL  WITH(NOLOCK) ON PICK.FTXthRefDocNo = SAL.FTXshDocNo
                        INNER JOIN TCNMChannel		CHN  WITH(NOLOCK) ON SAL.FTChnCode = CHN.FTChnCode
                        WHERE PICK.FTXthDocNo   = '".$paDataWhere['FTXthDocNo']."'
                        AND PICK.FTXthRefType   = '1'
                        AND PICK.FTXthRefKey    = 'SALE'
                        AND ISNULL(CHN.FTChnStaAlwSNPL,'2') = '1' ";
        }
        $oQuery = $this->db->query($tSQL);

        if ( $oQuery->num_rows() > 0 ){
            return true;
        } else {
            return false;
        }
    }

    // Create By: Napat(Jame) 17/01/2022
    public function FSbMPAMChkDocRefAlwCancel($paData){
        $tDocNo     = $paData['tDocNo'];
        $tDocType   = $paData['tDocType'];
        $tUsrCode   = $paData['FTLastUpdBy'];
        $dDate      = $paData['FDLastUpdOn'];

        if( $tDocType == '1' ){
            // ใบจ่ายโอน - สาขา
            $aResult     = array(
                'bAlwCancel'    => true,
                'tDesc'         => 'สามารถลบได้',
            );
        }else{
            // ใบขาย

            // ค้นหา Channels ของบิลขาย
            $tSQL = "   SELECT SALE.FTXshDocNo, SALE.FTChnCode, CHN.FTChnRefCode
                        FROM TCNTPdtPickHDDocRef	PICK WITH(NOLOCK)
                        INNER JOIN TPSTSalHD		SALE WITH(NOLOCK) ON PICK.FTXthRefDocNo = SALE.FTXshDocNo
                        INNER JOIN TCNMChannel       CHN WITH(NOLOCK) ON SALE.FTChnCode = CHN.FTChnCode
                        WHERE PICK.FTXthDocNo   = '$tDocNo'
                          AND PICK.FTXthRefType = '1'
                          AND PICK.FTXthRefKey  = 'SALE' ";
            $oQuery = $this->db->query($tSQL);
            if ( $oQuery->num_rows() > 0 ){
                $nMapSeqNo   = $oQuery->row_array()['FTChnRefCode'];

                // $aChannel = FCNaGetChnDelivery($tSaleChnCode);
                // if( $aChannel['tCode'] == '1' ){
                    // $tChnMapSeqNo = $aChannel['aItems'][0]['FNMapSeqNo'];
                    // 0	Online (DC จัดส่ง)
                    // 1	Online(รับที่ Store)
                    // 3	Offline(Store จัดส่ง)
                    // 4    Fast Delivery
                if( $nMapSeqNo == '1' || $nMapSeqNo == '4' ){
                    $tAlwDelStaPrcDoc = " AND ((SALE.FTXshStaPrcDoc = '7' AND ISNULL(SALE.FTXshStaApv,'') = '') OR SALE.FTXshStaPrcDoc = '2') ";
                }else if( $nMapSeqNo == '3' ){
                    $tAlwDelStaPrcDoc = " AND ((SALE.FTXshStaPrcDoc = '7' AND ISNULL(SALE.FTXshStaApv,'') = '1') OR SALE.FTXshStaPrcDoc = '2') ";
                }else{
                    $tAlwDelStaPrcDoc = " AND SALE.FTXshStaPrcDoc = '2' ";
                }

                $tSQLAlwDel = $tSQL.$tAlwDelStaPrcDoc;
                $oQueryAlwDel = $this->db->query($tSQLAlwDel);
                if ( $oQueryAlwDel->num_rows() > 0 ){
                    $aResult     = array(
                        'bAlwCancel'    => true,
                        'tDesc'         => 'สามารถลบได้',
                    );
                }else{
                    $aResult     = array(
                        'bAlwCancel'    => false,
                        'tDesc'         => 'ไม่สามารถยกเลิกได้ ใบขายอนุมัติแล้ว',
                    );
                }
                // }else{
                //     $aResult     = array(
                //         'bAlwCancel'    => false,
                //         'tDesc'         => 'ไม่พบ Config Mapping Channels กรุณาติดต่อผู้ดูแล',
                //     );
                // }
            } else {
                $aResult     = array(
                    'bAlwCancel'    => false,
                    'tDesc'         => 'ไม่พบใบขายที่ถูกอ้างอิง',
                );
            }
        }
        return $aResult;
        
    }

    

}

