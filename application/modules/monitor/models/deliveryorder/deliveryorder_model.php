<?php
defined('BASEPATH') or exit('No direct script access allowed');

class deliveryorder_model extends CI_Model{

    public function FSoMMONGetData($paData){
        $aRowLen            = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $aAdvanceSearch     = $paData['aAdvanceSearch'];
        // $tBchCode           = $aAdvanceSearch['tBchCode'];
        // $tStaDoc            = $aAdvanceSearch['tStaDoc'];
        $tDODocNo           = $aAdvanceSearch['tDODocNo'];
        $tDocDateForm       = $aAdvanceSearch['tDODocDateForm'];
        $tDocDateTo         = $aAdvanceSearch['tDODocDateTo'];
        
        $tSQL1  = "SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM ( ";
        $tSQL2  = " SELECT DISTINCT
                        HD.FTBchCode,
                        HD.FTXshDocNo, 
                        CONVERT(CHAR(10),HD.FDXshDocDate,120) AS FDXshDocDate,
                        USRL.FTUsrName,
                        HD.FTCreateBy,
                        HD.FTXshStaDoc,
                        HD.FTXshStaApv,
                        CONVERT(CHAR(10),HDCST.FDXshTnfDate,120) AS FDXshTnfDate,
                        HD.FDCreateOn,
                        HD.FTXshBchFrm, 
                        FrmBCH.FTBchName    AS FTXshBchFrmName,
                        HD.FTXshBchTo,
                        ToBCH.FTBchName     AS FTXshBchToName
                    FROM TARTDoHD               HD      WITH(NOLOCK)
                    LEFT JOIN TARTDoHDCst       HDCST   WITH(NOLOCK) ON HD.FTXshDocNo = HDCST.FTXshDocNo
                    LEFT JOIN TARTDoHDDocRef    HDREF   WITH(NOLOCK) ON HD.FTXshDocNo = HDREF.FTXshDocNo
                    LEFT JOIN TPSTSalHD         SALE    WITH(NOLOCK) ON HDREF.FTXshRefDocNo = SALE.FTXshDocNo
                    LEFT JOIN TCNMBranch_L      FrmBCH  WITH(NOLOCK) ON HD.FTXshBchFrm = FrmBCH.FTBchCode AND FrmBCH.FNLngID  = ".$this->db->escape($nLngID)."
                    LEFT JOIN TCNMBranch_L      ToBCH   WITH(NOLOCK) ON HD.FTXshBchTo = ToBCH.FTBchCode AND ToBCH.FNLngID  = ".$this->db->escape($nLngID)."
                    LEFT JOIN TCNMUser_L        USRL    WITH(NOLOCK) ON HD.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID   = ".$this->db->escape($nLngID)."
                    WHERE 1=1
        ";

        // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
        if ( $this->session->userdata('tSesUsrLevel') != "HQ" ) { 
            $tSessBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL2 .= " AND ( HD.FTXshBchFrm IN ($tSessBchCode) OR HD.FTXshBchTo IN ($tSessBchCode) OR HD.FTBchCode IN ($tSessBchCode) ) ";
            // $tSQL2 .= " AND HD.FTXshBchTo IN ($tSessBchCode) ";
        }

        // จากสาขา
        $tDOFrmBchCode = $aAdvanceSearch['tDOFrmBchCode'];
        $tDOToBchCode  = $aAdvanceSearch['tDOToBchCode'];
        if( !empty($tDOFrmBchCode) && empty($tDOToBchCode) ){
            $tSQL2 .= " AND HD.FTXshBchFrm = '$tDOFrmBchCode' ";
        }else if( empty($tDOFrmBchCode) && !empty($tDOToBchCode) ){
            $tSQL2 .= " AND HD.FTXshBchTo = '$tDOToBchCode' ";
        }else if( !empty($tDOFrmBchCode) && !empty($tDOToBchCode) ){
            $tSQL2 .= " AND (HD.FTXshBchFrm = '$tDOFrmBchCode' OR HD.FTXshBchTo = '$tDOToBchCode') ";
        }

        $tDOStaDoc = $aAdvanceSearch['tDOStaDoc'];
        switch ($tDOStaDoc) {
            case '1':
                $tSQL2 .= " AND HD.FTXshStaDoc = '1' AND ISNULL(HD.FTXshStaApv,'') != '1' ";
                break;
            case '2':
                $tSQL2 .= " AND HD.FTXshStaDoc = '1' AND HD.FTXshStaApv = '1' ";
                break;
            case '3':
                $tSQL2 .= " AND HD.FTXshStaDoc = '3' ";
                break;
            default:
                $tSQL2 .= "";
                break;
        }

        if ( !empty($tDODocNo) ) {
            $tSQL2 .= " AND ( HD.FTXshDocNo LIKE '%$tDODocNo%'
                             OR HDREF.FTXshRefDocNo LIKE '%$tDODocNo%' 
                             OR SALE.FTXshRefExt LIKE '%$tDODocNo%' 
                        ) ";
        }

        // จากวันที่เอกสาร - ถึงวันที่เอกสาร
        if(!empty($tDocDateForm) && !empty($tDocDateTo)){
            $tSQL2   .= " AND ((CONVERT(VARCHAR(10),HD.FDXshDocDate,121) BETWEEN ".$this->db->escape($tDocDateForm)." AND ".$this->db->escape($tDocDateTo).")
                            OR (CONVERT(VARCHAR(10),HD.FDXshDocDate,121) BETWEEN ".$this->db->escape($tDocDateTo)." AND ".$this->db->escape($tDocDateForm).")) ";
        }

        $tSQL3 =  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        
        $tSQLMain   = $tSQL1.$tSQL2.$tSQL3;
        $oQueryMain = $this->db->query($tSQLMain);
        // echo $this->db->last_query();
        if( $oQueryMain->num_rows() > 0 ){
            $aDetail        = $oQueryMain->result_array();
            $tSQLPage       = $tSQL2;
            $oQueryPage     = $this->db->query($tSQLPage);
            $nFoundRow      = $oQueryPage->num_rows();
            $nPageAll       = ceil($nFoundRow/$paData['nRow']);

            $aResult = array(
                'aItems'        => $aDetail,
                'nAllRow'       => $nFoundRow,
                'nCurrentPage'  => $paData['nPage'],
                'nAllPage'      => $nPageAll,
                'tCode'         => '1',
                'tDesc'         => 'success',
            );
        }else{
            $aResult = array(
                'nAllRow'       => 0,
                'nCurrentPage'  => $paData['nPage'],
                "nAllPage"      => 0,
                'tCode'         => '800',
                'tDesc'         => 'Data not found.',
            );
        }
        return $aResult;
    }

    // ลบข้อมูลใน Temp
    public function FSnMDODelALLTmp($paData){
        $this->db->trans_begin();

        $this->db->where_in('FTXthDockey', $paData['FTXthDockey']);
        $this->db->where_in('FTSessionID', $paData['FTSessionID']);
        $this->db->delete('TCNTDocDTTmp');

        $this->db->where('FTXthDocKey', $paData['FTXthDockey']);
        $this->db->where('FTSessionID', $paData['FTSessionID']);
        $this->db->delete('TCNTDocHDRefTmp');

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
    }

    //ข้อมูล HD
    public function FSaMDOGetDataDocHD($paDataWhere){
        $tDocNo     = $paDataWhere['FTXthDocNo'];
        $nLngID     = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            
                            USRL.FTUsrName,
                            USRAPV.FTUsrName	AS FTXshApvName,
                            BCHL.FTBchName,
                            WAH_L.FTWahName,

                            FrmBCH.FTBchName    AS FTXshBchFrmName,
                            ToBCH.FTBchName     AS FTXshBchToName,

                            DOHD.*,
                            DOCST.FDXshTnfDate,

                            Cst.FTCstCode,
                            CstL.FTCstName,
                            Cst.FTCstTel,
                            Cst.FTCstEmail,

                            DOCST.FNXshAddrShip,
                            CstAdr.FNAddSeqNo,
                            CstAdr.FTAddV1Soi,
                            CstAdr.FTAddV1Village,
                            CstAdr.FTAddV1Road,
                            SDST.FTSudName,
                            DST.FTDstName,
                            PVN.FTPvnName,
                            CstAdr.FTAddV1PostCode,
                            CstAdr.FTAddV2Desc1,
                            CstAdr.FTAddV2Desc2

                        FROM TARTDoHD               DOHD    WITH (NOLOCK)
                        LEFT JOIN TARTDoHDCst       DOCST   WITH (NOLOCK) ON DOHD.FTXshDocNo    = DOCST.FTXshDocNo
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK) ON DOHD.FTUsrCode     = USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK) ON DOHD.FTXshApvCode  = USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK) ON DOHD.FTBchCode     = BCHL.FTBchCode  AND BCHL.FNLngID	= $nLngID
                        LEFT JOIN TCNMAgency_L      AGN     WITH (NOLOCK) ON DOHD.FTAgnCode     = AGN.FTAgnCode   AND AGN.FNLngID	    = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAH_L   WITH (NOLOCK) ON DOHD.FTBchCode     = WAH_L.FTBchCode AND DOHD.FTWahCode = WAH_L.FTWahCode AND WAH_L.FNLngID	= $nLngID

                        LEFT JOIN TCNMBranch_L      FrmBCH  WITH (NOLOCK) ON DOHD.FTXshBchFrm = FrmBCH.FTBchCode AND FrmBCH.FNLngID = $nLngID
                        LEFT JOIN TCNMBranch_L      ToBCH   WITH (NOLOCK) ON DOHD.FTXshBchTo = ToBCH.FTBchCode AND ToBCH.FNLngID = $nLngID
                        
                        LEFT JOIN TCNMCstAddress_L  CstAdr  WITH (NOLOCK) ON DOCST.FNXshAddrShip = CstAdr.FNAddSeqNo /*AND CstAdr.FNLngID = $nLngID*/ 
                        LEFT JOIN TCNMCst           Cst     WITH (NOLOCK) ON DOHD.FTCstCode = Cst.FTCstCode
                        LEFT JOIN TCNMCst_L         CstL    WITH (NOLOCK) ON DOHD.FTCstCode = CstL.FTCstCode AND CstL.FNLngID = $nLngID

                        LEFT JOIN TCNMProvince_L    PVN     WITH (NOLOCK) ON CstAdr.FTAddV1PvnCode = PVN.FTPvnCode AND PVN.FNLngID = $nLngID
                        LEFT JOIN TCNMDistrict_L    DST     WITH (NOLOCK) ON CstAdr.FTAddV1DstCode = DST.FTDstCode AND DST.FNLngID = $nLngID
                        LEFT JOIN TCNMSubDistrict_L SDST    WITH (NOLOCK) ON CstAdr.FTAddV1SubDist = SDST.FTSudCode AND SDST.FNLngID = $nLngID

                        WHERE DOHD.FTXshDocNo = '$tDocNo' ";

        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ($oQuery->num_rows() > 0){
            $aResult    = array(
                'raItems'   => $oQuery->row_array(),
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

    //ย้ายจาก DT To Temp
    public function FSxMDOMoveDTToDTTemp($paDataWhere){
        $tDocNo          = $paDataWhere['FTXthDocNo'];
        $tDocKey         = $paDataWhere['FTXthDocKey'];

        $tSQL   = " INSERT INTO TCNTDocDTTmp (
                        FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
                        FCXtdQty,FCXtdQtyAll,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy )
                    SELECT
                        DT.FTBchCode,
                        DT.FTXshDocNo,
                        DT.FNXsdSeqNo,
                        CONVERT(VARCHAR,'".$tDocKey."') AS FTXthDocKey,
                        DT.FTPdtCode,
                        DT.FTXsdPdtName,
                        DT.FTPunCode,
                        DT.FTPunName,
                        DT.FCXsdFactor,
                        DT.FTXsdBarCode,
                        DT.FCXsdQty,
                        DT.FCXsdQtyAll,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                    FROM TARTDoDT DT WITH(NOLOCK)
                    WHERE DT.FTXshDocNo = '$tDocNo'
                    ORDER BY DT.FNXsdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    //ข้อมูล HDDocRef
    public function FSxMDOMoveHDRefToHDRefTemp($paData){

        $tDocNo         = $paData['FTXthDocNo'];
        $tSessionID     = $this->session->userdata('tSesSessionID');

        $tSQL = "   INSERT INTO TCNTDocHDRefTmp (FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate, FTXthDocKey, FTSessionID , FDCreateOn)";
        $tSQL .= "  SELECT
                        FTXshDocNo,
                        FTXshRefDocNo,
                        FTXshRefType,
                        FTXshRefKey,
                        FDXshRefDocDate,
                        'TARTDoHD'      AS FTXthDocKey,
                        '$tSessionID'   AS FTSessionID,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn
                    FROM TARTDoHDDocRef WITH(NOLOCK)
                    WHERE FTXshDocNo = '$tDocNo' ";
        $this->db->query($tSQL);
    }

    // Function : Get Data In Doc DT Temp
    public function FSaMDOGetDocDTTempListPage($paDataWhere){
        $tDODocNo           = $paDataWhere['FTXthDocNo'];
        $tDODocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable  = $paDataWhere['tSearchPdtAdvTable'];
        $tDOSesSessionID    = $this->session->userdata('tSesSessionID');

        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tSQL       = " SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM (
                                SELECT
                                    DOCTMP.FTBchCode,
                                    DOCTMP.FTXthDocNo,
                                    DOCTMP.FNXtdSeqNo,
                                    DOCTMP.FTXthDocKey,
                                    DOCTMP.FTPdtCode,
                                    DOCTMP.FTXtdPdtName,
                                    DOCTMP.FTPunName,
                                    DOCTMP.FTXtdBarCode,
                                    DOCTMP.FTPunCode,
                                    DOCTMP.FCXtdFactor,
                                    DOCTMP.FCXtdQty,
                                    DOCTMP.FCXtdSetPrice,
                                    DOCTMP.FCXtdNet,
                                    DOCTMP.FCXtdNetAfHD,
                                    DOCTMP.FDLastUpdOn,
                                    DOCTMP.FDCreateOn,
                                    DOCTMP.FTLastUpdBy,
                                    DOCTMP.FTCreateBy
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE DOCTMP.FTXthDocKey = '$tDODocKey'
                                  AND DOCTMP.FTSessionID = '$tDOSesSessionID' ";
        if(isset($tDODocNo) && !empty($tDODocNo)){
            $tSQL   .=  " AND ISNULL(DOCTMP.FTXthDocNo,'')  = '$tDODocNo' ";
        }

        if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
            $tSQL   .=  "   AND ( DOCTMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%' )
                        ";
            
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            // $aFoundRow  = $this->FSaMPAMGetDocDTTempListPageAll($paDataWhere);
            // $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nFoundRow  = 100;
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

    // แท็บ อ้างอิงเอกสาร - โหลด
    public function FSaMDOGetDataHDRefTmp($paData){

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

    // Function : Count Check Data Product In Doc DT Temp Before Save
    public function FSnMDOChkPdtInDocDTTemp($paDataWhere){
        $tDODocNo       = $paDataWhere['FTXthDocNo'];
        $tDODocKey      = $paDataWhere['FTXthDocKey'];
        $tDOSessionID   = $paDataWhere['FTSessionID'];
        $tSQL           = " SELECT
                                COUNT(FNXtdSeqNo) AS nCountPdt
                            FROM TCNTDocDTTmp DocDT WITH(NOLOCK)
                            WHERE DocDT.FTXthDocKey   = '$tDODocKey'
                              AND DocDT.FTSessionID   = '$tDOSessionID' ";
        if(isset($tDODocNo) && !empty($tDODocNo)){
            $tSQL   .=  " AND ISNULL(DocDT.FTXthDocNo,'')  = '$tDODocNo' ";
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->row_array();
            return $aDataQuery['nCountPdt'];
        }else{
            return 0;
        }
    }

    // Function : Add/Update Data HD
    public function FSxMDOAddUpdateHD($paDataMaster,$paDataWhere,$paTableAddUpdate){
        $aDataGetDataHD     =   $this->FSaMDOGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FNLngID'       => $this->session->userdata("tLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            // $aDataHDOld         = $aDataGetDataHD['raItems'];
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                // 'FTBchCode'     => $paDataWhere['FTBchCode'],
                // 'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
            ));
            
            // update HD
            $this->db->where('FTBchCode',$paDataWhere['FTBchCode']);
            $this->db->where('FTXshDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->update($paTableAddUpdate['tTableHD'], $aDataAddUpdateHD);
        }else{
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));

            // Insert HD
            $this->db->insert($paTableAddUpdate['tTableHD'],$aDataAddUpdateHD);
        }
    }

    // Function : Add/Update Data HD
    public function FSxMDOAddUpdateHDCst($paDataMaster,$paDataWhere,$paTableAddUpdate){
        // $aDataGetDataHD     =   $this->FSaMDOGetDataDocHD(array(
        //     'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
        //     'FNLngID'       => $this->session->userdata("tLangEdit")
        // ));

        // $aDataAddUpdateHD   = array();
        // if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            // $aDataAddUpdateHD   = array_merge($paDataMaster,array(
            //     'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
            //     'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
            // ));
            
            // Update HD Cst
            $this->db->where('FTBchCode',$paDataWhere['FTBchCode']);
            $this->db->where('FTXshDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->update($paTableAddUpdate['tTableHDCst'], $paDataMaster);
        // }else{
        //     $aDataAddUpdateHD   = array_merge($paDataMaster,array(
        //         'FTBchCode'     => $paDataWhere['FTBchCode'],
        //         'FTXshDocNo'    => $paDataWhere['FTXthDocNo'],
        //         'FDCreateOn'    => $paDataWhere['FDCreateOn'],
        //         'FTCreateBy'    => $paDataWhere['FTCreateBy'],
        //     ));

        //     // Insert HD
        //     $this->db->insert($paTableAddUpdate['tTableHD'],$aDataAddUpdateHD);
        // }
    }

    //อัพเดทเลขที่เอกสาร  TCNTDocDTTmp , TCNTDocHDDisTmp , TCNTDocDTDisTmp
    public function FSxMDOAddUpdateDocNoToTemp($paDataWhere,$paTableAddUpdate){
        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableHD']);
        $this->db->update('TCNTDocDTTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));
    }

    // Function Move Document DTTemp To Document DT
    public function FSxMDOMoveDtTmpToDt($paDataWhere,$paTableAddUpdate){
        $tDOBchCode     = $paDataWhere['FTBchCode'];
        $tDODocNo       = $paDataWhere['FTXthDocNo'];
        $tDODocKey      = $paTableAddUpdate['tTableHD'];
        $tDOSessionID   = $paDataWhere['FTSessionID'];
        
        if(isset($tDODocNo) && !empty($tDODocNo)){
            $this->db->where_in('FTXshDocNo',$tDODocNo);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO ".$paTableAddUpdate['tTableDT']." ( FTAgnCode,FTBchCode,FTXshDocNo,FNXsdSeqNo,FTPdtCode,
                        FTXsdPdtName,FTPunCode,FTPunName,FCXsdFactor,FTXsdBarCode,FCXsdQty,FCXsdQtyAll,
                        FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy ) ";
        $tSQL   .=  "   SELECT
                            '' AS FTAgnCode,
                            DOCTMP.FTBchCode,
                            DOCTMP.FTXthDocNo,
                            ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo, 
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTPunCode,
                            DOCTMP.FTPunName,
                            DOCTMP.FCXtdFactor,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FCXtdQty,
                            DOCTMP.FCXtdQtyAll,
                            DOCTMP.FDLastUpdOn,
                            DOCTMP.FTLastUpdBy,
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTCreateBy
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE DOCTMP.FTBchCode    = '$tDOBchCode'
                          AND DOCTMP.FTXthDocNo   = '$tDODocNo'
                          AND DOCTMP.FTXthDocKey  = '$tDODocKey'
                          AND DOCTMP.FTSessionID  = '$tDOSessionID'
                        ORDER BY DOCTMP.FNXtdSeqNo ASC
        ";
        $oQuery = $this->db->query($tSQL);
    }

    //อนุมัตเอกสาร
    public function FSxMDOApproveDocument($paDataUpdate){
        
        $this->db->where('FTBchCode',$paDataUpdate['FTBchCode']);
        $this->db->where('FTXshDocNo',$paDataUpdate['FTXshDocNo']);
        $this->db->update('TARTDoHD', $paDataUpdate);

    }

    // Function : Cancel Document Data
    public function FSxMDOCancelDocument($paDataUpdate){
        $this->db->set('FTXshStaDoc', '3');
        $this->db->where('FTXshDocNo', $paDataUpdate['tDocNo']);
        $this->db->update('TARTDoHD');

        $this->db->where('FTXshDocNo', $paDataUpdate['tDocNo']);
        $this->db->delete('TARTDoHDDocRef');
    }

    
    // Create By : Napat(Jame) 16/01/2021
    // ตรวจสอบว่ามีอ้างอิงใบขายไหม ?
    // ถ้าใบส่งของ สร้างมาจากใบขาย ปรับสถานะเอกสารใบขาย เป็น StaPrcDoc=7 (รอสร้างใบส่งของ)
    public function FSxMDOUpdSaleOnCancelOrDelete($paData){
        $tDocNo     = $paData['tDocNo'];
        $tUsrCode   = $paData['FTLastUpdBy'];
        $dDate      = $paData['FDLastUpdOn'];

        $tSQL = "   UPDATE TPSTSalHD
                    SET TPSTSalHD.FTXshStaPrcDoc = '7'
                       ,TPSTSalHD.FTLastUpdBy = '$tUsrCode'
                       ,TPSTSalHD.FDLastUpdOn = '$dDate'
                    FROM TARTDoHDDocRef REF WITH(NOLOCK)
                    WHERE REF.FTXshDocNo = '$tDocNo'
                      AND REF.FTXshRefType = '1'
                      AND REF.FTXshRefKey = 'SALE'
                      AND TPSTSalHD.FTXshDocNo = REF.FTXshRefDocNo ";
        $this->db->query($tSQL);
    }

    
    // Create By : Napat(Jame) 17/01/2021
    // อัพเดทวันที่ส่งของ กรณีอนุมัติหลายเอกสาร
    public function FSxMDOUpdTnfDate($paData){
        $tDocNoWhere    = $paData['tDocNoWhere'];
        $dDateTranfer   = $paData['dDateTranfer'];

        $tSQL = " UPDATE TARTDoHDCst SET FDXshTnfDate = '$dDateTranfer' WHERE FTXshDocNo IN ($tDocNoWhere) ";
        $this->db->query($tSQL);
    }

    
}