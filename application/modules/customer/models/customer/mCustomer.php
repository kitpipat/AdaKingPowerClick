<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomer extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCSTSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCstCode   = $paData['FTCstCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            CST.FTCstCode               AS rtCstCode,
                            CST.FTCstCardID             AS rtCstCardID,
                            CST.FDCstDob                AS rtCstDob,
                            CST.FTCstSex                AS rtCstSex,
                            CST.FTCstBusiness           AS rtCstBusiness,
                            CST.FTCstTaxNo              AS rtCstTaxNo,
                            CST.FTCstStaActive          AS rtCstStaActive,
                            CST.FTCstEmail              AS rtCstEmail,
                            CST.FTCstTel                AS rtCstTel,
                            CSTL.FTCstName              AS rtCstName,
                            CSTL.FTCstRmk               AS rtCstRmk,
                            CST.FTCgpCode               AS rtCstCgpCode,
                            CSTGL.FTCgpName             AS rtCstCgpName,
                            CST.FTCtyCode               AS rtCstCtyCode,
                            CSTTL.FTCtyName             AS rtCstCtyName,
                            CST.FTClvCode               AS rtCstClvCode,
                            CSTLevL.FTClvName           AS rtCstClvName,
                            CST.FTOcpCode               AS rtCstOcpCode,
                            CSTOL.FTOcpName             AS rtCstOcpName,
                            CST.FTPplCodeRet            AS rtCstPplCodeRet,
                            CST.FTPplCodeWhs            AS rtCstPplCodeWhs,
                            PDTPriLWhs.FTPplName        AS rtCstPplNameWhs,
                            CST.FTPplCodenNet           AS rtPplCodeNet,
                            PDTPriLNet.FTPplName        AS rtPplNameNet,
                            PDTPriL.FTPplName           AS rtCstPplNameRet,
                            CST.FTPmgCode               AS rtCstPmgCode,
                            PDTPmtGL.FTPmgName          AS rtCstPmgName,
                            CST.FTCstDiscRet            AS rtCstDiscRet,
                            CST.FTCstDiscWhs            AS rtCstDiscWhs,
                            CST.FTCstBchHQ              AS rtCstBchHQ,
                            CST.FTCstBchCode            AS rtCstBchCode,
                            BCHL.FTBchName              AS rtCstBchName,
                            CST.FTCstStaAlwPosCalSo     AS rtCstStaAlwPosCalSo,
                            IMGP.FTImgObj               AS rtImgObj,
                            AGN_L.FTAgnCode             AS FTAgnCode,
                            AGN_L.FTAgnName             AS FTAgnName
                        FROM [TCNMCst] CST WITH(NOLOCK)
                        LEFT JOIN [TCNMAgency_L] AGN_L WITH(NOLOCK) ON CST.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                        LEFT JOIN [TCNMCst_L]  CSTL WITH(NOLOCK) ON CST.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstGrp_L] CSTGL WITH(NOLOCK) ON CSTGL.FTCgpCode = CST.FTCgpCode AND CSTGL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstType_L] CSTTL WITH(NOLOCK) ON CSTTL.FTCtyCode = CST.FTCtyCode AND CSTTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstLev_L] CSTLevL WITH(NOLOCK) ON CSTLevL.FTClvCode = CST.FTClvCode AND CSTLevL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstOcp_L] CSTOL WITH(NOLOCK) ON CSTOL.FTOcpCode = CST.FTOcpCode AND CSTOL.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPriList_L] PDTPriL WITH(NOLOCK) ON PDTPriL.FTPplCode = CST.FTPplCodeRet AND PDTPriL.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPriList_L] PDTPriLWhs WITH(NOLOCK) ON PDTPriLWhs.FTPplCode = CST.FTPplCodeWhs AND PDTPriLWhs.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPriList_L] PDTPriLNet WITH(NOLOCK) ON PDTPriLNet.FTPplCode = CST.FTPplCodenNet AND PDTPriLNet.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPmtGrp_L] PDTPmtGL WITH(NOLOCK) ON PDTPmtGL.FTPmgCode = CST.FTPmgCode AND PDTPmtGL.FNLngID = $nLngID
                        LEFT JOIN [TCNMBranch_L]  BCHL WITH(NOLOCK) ON CST.FTCstBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON IMGP.FTImgRefID = CST.FTCstCode AND IMGP.FNImgSeq = 1
                        WHERE 1=1
        ";
        if($tCstCode!= ""){
            $tSQL .= "AND CST.FTCstCode = '$tCstCode'";
        }
        $oQuery = $this->db->query($tSQL);

        // Address
        $tAddressSQL  = "SELECT DISTINCT
                            AD.FTAddV1No        AS rtAddV1No,
                            AD.FTAddV1Soi       AS rtAddV1Soi,
                            AD.FTAddV1Village   AS rtAddV1Village,
                            AD.FTAddV1Road      AS rtAddV1Road,
                            AD.FTAddWebsite     AS rtAddWebsite,
                            AD.FTAddRmk         AS rtAddRmk,
                            AD.FTAddLongitude   AS rtAddLongitude,
                            AD.FTAddLatitude    AS rtAddLatitude,
                            AD.FTAddCountry     AS rtAddCountry,
                            AD.FTZneCode        AS rtAddZoneCode,
                            AD.FTAreCode        AS rtAddAreCode,
                            AD.FTAddV1PvnCode   AS  rtAddProvinceCode,
                            AD.FTAddV1DstCode   AS rtAddDistrictCode,
                            AD.FTAddV1SubDist   AS  rtAddSubDistrictCode,
                            AD.FTAddV1PostCode  AS rtAddPostCode,
                            AD.FTAddRefNo       AS rtAddRefNo,
                            AD.FNAddSeqNo       AS rtAddSeqNo,
                            AD.FTAddV2Desc1     AS rtAddDesc1,
                            AD.FTAddV2Desc2     AS rtAddDesc2,
                            PVNL.FTPvnName      AS rtAddProvinceName,
                            DSTL.FTDstName      AS rtAddDistrictName,
                            SDSTL.FTSudName     AS rtAddSubDistrictName,
                            ZNEL.FTZneName      AS rtAddZoneName
                        FROM [TCNMCstAddress_L] AD
                        LEFT JOIN [TCNMProvince_L] PVNL ON PVNL.FTPvnCode = AD.FTAddV1PvnCode AND PVNL.FNLngID = $nLngID
                        LEFT JOIN [TCNMDistrict_L] DSTL ON DSTL.FTDstCode = AD.FTAddV1DstCode AND DSTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMSubDistrict_L] SDSTL ON SDSTL.FTSudCode = AD.FTAddV1SubDist AND SDSTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMZone_L] ZNEL ON ZNEL.FTZneCode = AD.FTZneCode AND ZNEL.FNLngID = $nLngID
                        WHERE AD.FTCstCode = '$tCstCode'
                        AND AD.FTAddRefNo = ''
                        AND AD.FTAddGrpType = '1'
                        AND AD.FNLngID = $nLngID";
        $oAddressQuery = $this->db->query($tAddressSQL);

        // Contact
        $tContactSQL = "SELECT DISTINCT
                            CTRL.FTCstCode      AS rtCstCode,
                            CTRL.FTCtrName      AS rtCtrName,
                            CTRL.FTCtrTel       AS rtCtrTel,
                            CTRL.FTCtrFax       AS rtCtrFax,
                            CTRL.FTCtrEmail     AS rtCtrEmail,
                            CTRL.FTCtrRmk       AS rtCtrRmk,
                            CTRL.FNCtrSeq       AS rtCtrSeq,
                            CTRL.FDCreateOn     AS rtCtrCreateOn,
                            ADL.FTAddV1No       AS rtAddV1No,
                            ADL.FTAddV1Soi      AS rtAddV1Soi,
                            ADL.FTAddV1Village  AS rtAddV1Village,
                            ADL.FTAddV1Road     AS rtAddV1Road,
                            ADL.FTAddWebsite    AS rtAddWebsite,
                            ADL.FTAddRmk        AS rtAddRmk,
                            ADL.FTAddLongitude  AS rtAddLongitude,
                            ADL.FTAddLatitude   AS rtAddLatitude,
                            ADL.FTAddCountry    AS rtAddCountry,
                            ADL.FTZneCode       AS rtAddZoneCode,
                            ADL.FTAddV1PvnCode  AS  rtAddProvinceCode,
                            ADL.FTAddV1DstCode  AS rtAddDistrictCode,
                            ADL.FTAddV1SubDist  AS  rtAddSubDistrictCode,
                            ADL.FTAddV1PostCode AS rtAddPostCode
                        FROM [TCNMCstContact_L] CTRL
                        LEFT JOIN [TCNMCstAddress_L] ADL
                        ON ADL.FTCstCode = CTRL.FTCstCode
                        AND ADL.FTAddRefNo = CTRL.FNCtrSeq
                        AND ADL.FTAddGrpType = 2
                        AND ADL.FNLngID = $nLngID
                        WHERE CTRL.FTCstCode = '$tCstCode' AND CTRL.FNLngID = $nLngID";
        $oContactQuery = $this->db->query($tContactSQL);

        // CardInfo
        $tCardInfoSQL = "SELECT DISTINCT
                            CRDINFO.FTCstCrdNo      AS rtCstCrdNo,
                            CRDINFO.FDCstApply      AS rtCstApply,
                            CRDINFO.FDCstCrdIssue   AS rtCstCrdIssue,
                            CRDINFO.FDCstCrdExpire  AS rtCstCrdExpire,
                            CRDINFO.FTBchCode       AS rtBchCode,
                            CRDINFO.FTCstStaAge     AS rtCstStaAge,
                            BCHL.FTBchName          AS rtBchName
                        FROM [TCNMCstCard] CRDINFO
                        LEFT JOIN [TCNMBranch_L] BCHL ON BCHL.FTBchCode = CRDINFO.FTBchCode AND BCHL.FNLngID = $nLngID
                        WHERE CRDINFO.FTCstCode = '$tCstCode'";
        $oCardInfoQuery = $this->db->query($tCardInfoSQL);

        // Credit
        $tCreditSQL  =  "SELECT DISTINCT
                            CRD.FNCstCrTerm         AS rtCstCrTerm,
                            CRD.FCCstCrLimit        AS rtCstCrLimit,
                            CRD.FTCstStaAlwOrdMon   AS rtCstStaAlwOrdMon,
                            CRD.FTCstStaAlwOrdTue   AS rtCstStaAlwOrdTue,
                            CRD.FTCstStaAlwOrdWed   AS rtCstStaAlwOrdWed,
                            CRD.FTCstStaAlwOrdThu   AS rtCstStaAlwOrdThu,
                            CRD.FTCstStaAlwOrdFri   AS rtCstStaAlwOrdFri,
                            CRD.FTCstStaAlwOrdSat   AS rtCstStaAlwOrdSat,
                            CRD.FTCstStaAlwOrdSun   AS rtCstStaAlwOrdSun,
                            CRD.FTCstPayRmk         AS rtCstPayRmk,
                            CRD.FTCstBillRmk        AS rtCstBillRmk,
                            CRD.FTCstViaRmk         AS rtCstViaRmk,
                            CRD.FNCstViaTime        AS rtCstViaTime,
                            CRD.FTViaCode           AS rtViaCode,
                            CRD.FTCstTspPaid        AS rtCstTspPaid,
                            CRD.FTCstStaApv         AS rtCstStaApv,
                            VIAL.FTViaName          AS rtViaName
                        FROM [TCNMCstCredit] CRD
                        LEFT JOIN [TCNMShipVia_L] VIAL ON VIAL.FTViaCode = CRD.FTViaCode AND VIAL.FNLngID = $nLngID
                        WHERE CRD.FTCstCode = '$tCstCode'";
        $oCreditQuery = $this->db->query($tCreditSQL);

        // RFID
        $tRfidSQL = "SELECT DISTINCT
                        RFID.FTCstCode              AS rtCstCode,
                        RFID.FTCstID                AS rtCstID,
                        RFID.FTCrfName              AS rtCrfName
                    FROM [TCNMCstRFID_L] RFID
                    WHERE RFID.FTCstCode = '$tCstCode'
                    AND RFID.FNLngID = $nLngID";
        $oRfidQuery = $this->db->query($tRfidSQL);

        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $oCreditDetail = $oCreditQuery->result();
            $oCardInfoDetail = $oCardInfoQuery->result();
            $oRfidDetail = $oRfidQuery->result();
            $oContactDetail = $oContactQuery->result();
            $oAddressDetail = $oAddressQuery->result();
            $aResult = array(
                'raItems'       => @$oDetail[0],
                'raAddress'     => @$oAddressDetail[0],
                'raContact'     => [],
                'raCardInfo'    => @$oCardInfoDetail[0],
                'raCredit'      => @$oCreditDetail[0],
                'raRfid'        => @$oRfidDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
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


    /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCSTList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL     = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, rtCstCode ASC) AS rtRowID,*
                        FROM
                        (SELECT DISTINCT
                            CST.FTCstCode AS rtCstCode,
                            CST.FTCstEmail AS rtCstEmail,
                            CST.FTCstTel AS rtCstTel,
                            CSTL.FTCstName AS rtCstName,
                            CSTL.FTCstRmk AS rtCstRmk,
                            CSTGL.FTCgpName AS rtCgpName,
                            IMGP.FTImgObj AS rtImgObj,
                            CST.FDCreateOn
                        FROM [TCNMCst] CST
                        LEFT JOIN [TCNMCst_L]  CSTL ON CST.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstGrp] CSTG ON CSTG.FTCgpCode = CST.FTCgpCode
                        LEFT JOIN [TCNMCstGrp_L] CSTGL ON CSTGL.FTCgpCode = CST.FTCgpCode AND CSTGL.FNLngID = $nLngID
                        LEFT JOIN [TCNMImgPerson] IMGP ON IMGP.FTImgRefID = CST.FTCstCode
                        WHERE 1=1";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (CST.FTCstCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CSTL.FTCstName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CSTGL.FTCgpName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTCstCardID COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTPplCodeRet COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTPplCodeWhs COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTCstTel COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTCstEmail COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        //ค้นหาตัวแทนขายของตัวเอง
        $tAgnCode = $this->session->userdata("tSesUsrAgnCode");
        if($tAgnCode != ""){
            $tSQL .= " AND ( CST.FTAgnCode = '$tAgnCode'";
        }
        if(!empty($tAgnCode)){
            $aDataCgp = $this->FScMCSTGetInfoMemberConFigSpc($tAgnCode,1);
            if($aDataCgp['rtCode']=='1'){
                    $tCgpCode = $aDataCgp['raItem']['FTCfgStaUsrValue'];
                    $tSQL .= " OR CST.FTCgpCode = '$tCgpCode'";
            }
        }

        if($tAgnCode != ""){
            $tSQL .= " )";
             }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCSTGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID);
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
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCSTGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID){
        $tSQL = "SELECT COUNT (CST.FTCstCode) AS counts
                FROM [TCNMCst] CST
                LEFT JOIN [TCNMCst_L]  CSTL ON CST.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $ptLngID
                LEFT JOIN [TCNMCstGrp] CSTG ON CSTG.FTCgpCode = CST.FTCgpCode
                LEFT JOIN [TCNMCstGrp_L] CSTGL ON CSTGL.FTCgpCode = CST.FTCgpCode AND CSTGL.FNLngID = $ptLngID
                LEFT JOIN [TCNMImgPerson] IMGP ON IMGP.FTImgRefID = CST.FTCstCode
                WHERE 1=1 ";

        if($ptSearchList != ''){
            $tSQL .= " AND (CST.FTCstCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CSTL.FTCstName COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CSTGL.FTCgpName COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTCstCardID COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTPplCodeRet COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTPplCodeWhs COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTCstTel COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTCstEmail COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        }

        //ค้นหาตัวแทนขายของตัวเอง
        $tAgnCode = $this->session->userdata("tSesUsrAgnCode");
        if($tAgnCode != ""){
            $tSQL .= " AND ( CST.FTAgnCode = '$tAgnCode'";
        }
        if(!empty($tAgnCode)){
            $aDataCgp = $this->FScMCSTGetInfoMemberConFigSpc($tAgnCode,1);
            if($aDataCgp['rtCode']=='1'){
                    $tCgpCode = $aDataCgp['raItem']['FTCfgStaUsrValue'];
                    $tSQL .= " OR CST.FTCgpCode = '$tCgpCode'";
            }
        }
        if($tAgnCode != ""){
        $tSQL .= " )";
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
     * Parameters : $ptDstCode
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCSTCheckDuplicate($ptCstCode){
        $tSQL = "SELECT COUNT(FTCstCode) AS counts
                 FROM TCNMCst
                 WHERE FTCstCode = '$ptCstCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Update Sale Person
     * Parameters : $paData is data
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateMaster($paData){

        try{
            // Update Master
            $this->db->set('FTCstTel', $paData['FTCstTel']);
            $this->db->set('FTCstEmail', $paData['FTCstEmail']);
            $this->db->set('FTCstCardID', $paData['FTCstCardID']);
            $this->db->set('FDCstDob', $paData['FDCstDob']);
            $this->db->set('FTCstSex', $paData['FTCstSex']);
            $this->db->set('FTCstBusiness', $paData['FTCstBusiness']);
            $this->db->set('FTCstTaxNo', $paData['FTCstTaxNo']);
            $this->db->set('FTCstStaActive', $paData['FTCstStaActive']);
            $this->db->set('FTCstStaAlwPosCalSo', $paData['FTCstStaAlwPosCalSo']);
            $this->db->set('FTCgpCode', $paData['FTCgpCode']);
            $this->db->set('FTCtyCode', $paData['FTCtyCode']);
            $this->db->set('FTClvCode', $paData['FTClvCode']);
            $this->db->set('FTOcpCode', $paData['FTOcpCode']);
            $this->db->set('FTPplCodeRet', $paData['FTPplCodeRet']);
            $this->db->set('FTPplCodeWhs', $paData['FTPplCodeWhs']);   // รหัสกลุ่มราคา สำหรับ ขายส่ง
            $this->db->set('FTPplCodenNet', $paData['FTPplCodenNet']); // รหัสกลุ่มราคา สำหรับ ขายผ่าน Web
            $this->db->set('FTPmgCode', $paData['FTPmgCode']);
            $this->db->set('FTCstDiscRet', $paData['FTCstDiscRet']);
            $this->db->set('FTCstDiscWhs', $paData['FTCstDiscWhs']);
            $this->db->set('FTCstBchHQ', $paData['FTCstBchHQ']);
            $this->db->set('FTCstBchCode', $paData['FTCstBchCode']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode' , $paData['FTAgnCode']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCst');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMCst',array(
                    'FTCstCode'             => $paData['FTCstCode'],
                    'FTCstTel'              => $paData['FTCstTel'],
                    'FTCstEmail'            => $paData['FTCstEmail'],
                    'FTCstCardID'           => $paData['FTCstCardID'],
                    'FDCstDob'              => $paData['FDCstDob'],
                    'FTCstSex'              => $paData['FTCstSex'],
                    'FTCstBusiness'         => $paData['FTCstBusiness'],
                    'FTCstTaxNo'            => $paData['FTCstTaxNo'],
                    'FTCstStaActive'        => $paData['FTCstStaActive'],
                    'FTCstStaAlwPosCalSo'   => $paData['FTCstStaAlwPosCalSo'],
                    'FTCgpCode'             => $paData['FTCgpCode'],
                    'FTCtyCode'             => $paData['FTCtyCode'],
                    'FTClvCode'             => $paData['FTClvCode'],
                    'FTOcpCode'             => $paData['FTOcpCode'],
                    'FTPplCodeRet'          => $paData['FTPplCodeRet'],
                    'FTPplCodeWhs'          => $paData['FTPplCodeWhs'],   // รหัสกลุ่มราคา สำหรับ ขายส่ง
                    'FTPplCodenNet'         => $paData['FTPplCodenNet'], // รหัสกลุ่มราคา สำหรับ ขายผ่าน Web
                    'FTPmgCode'             => $paData['FTPmgCode'],
                    'FTCstDiscRet'          => $paData['FTCstDiscRet'],
                    'FTCstDiscWhs'          => $paData['FTCstDiscWhs'],
                    'FTCstBchHQ'            => $paData['FTCstBchHQ'],
                    'FTCstBchCode'          => $paData['FTCstBchCode'],
                    'FTAgnCode'             => $paData['FTAgnCode'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy']
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
     * Functionality : Update Lang Sale Person
     * Parameters : $paData is data for update
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTCstName', $paData['FTCstName']);
            $this->db->set('FTCstRmk', $paData['FTCstRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCst_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMCst_L',array(
                    'FTCstCode' => $paData['FTCstCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCstName' => $paData['FTCstName'],
                    'FTCstRmk'  => $paData['FTCstRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Add or Update Customer Address
     * Parameters : $paData is data
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateAddress($paData){
        try{
            // Update Address
            if($paData['AddressMode'] == "1"){
                $this->db->set('FTAddGrpType', $paData['FTAddGrpType']);
                $this->db->set('FTAddVersion', "1"); // Split Field
                $this->db->set('FTAddV1No', $paData['FTAddV1No']);
                $this->db->set('FTAddV1Soi', $paData['FTAddV1Soi']);
                $this->db->set('FTAddV1Village', $paData['FTAddV1Village']);
                $this->db->set('FTAddV1Road', $paData['FTAddV1Road']);
                $this->db->set('FTAddCountry', $paData['FTAddCountry']);
                $this->db->set('FTAddV1PvnCode', $paData['FTAddV1PvnCode']);
                $this->db->set('FTAddV1DstCode', $paData['FTAddV1DstCode']);
                $this->db->set('FTAddV1SubDist', $paData['FTAddV1SubDist']);
                $this->db->set('FTAddV1PostCode', $paData['FTAddV1PostCode']);
                $this->db->set('FTAddRmk', $paData['FTAddRmk']);
            }

            if($paData['AddressMode'] == "2"){
                $this->db->set('FTAddVersion', "2"); // Combine Field
                $this->db->set('FTAddV2Desc1', $paData['FTAddV2Desc1']);
                $this->db->set('FTAddV2Desc2', $paData['FTAddV2Desc2']);
            }

            $this->db->set('FTAreCode', $paData['FTAreCode']);
            $this->db->set('FTZneCode', $paData['FTZneCode']);
            $this->db->set('FTAddWebsite', $paData['FTAddWebsite']);
            $this->db->set('FTAddLongitude', $paData['FTAddLongitude']);
            $this->db->set('FTAddLatitude', $paData['FTAddLatitude']);

            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            if ($paData['FTAddGrpType'] == "2"){ // Contact
                $this->db->where('FTAddRefNo', $paData['FTAddRefNo']);
                $this->db->where('FTAddGrpType', '2');
            }
            if ($paData['FTAddGrpType'] == "1"){ // Customer
                $this->db->where('FTAddRefNo', "");
                $this->db->where('FTAddGrpType', '1');
            }

            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCstAddress_L');

            if($this->db->affected_rows() > 0){
                if ($paData['FTAddGrpType'] == "1"){ // Customer
                    $this->FSaMCSTUpdateDateMaster($paData);
                }
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Address Success',
                );

            }else{
                // Add Address
                $aMergeField = [];
                $aAddressField = [
                    'FTAddGrpType' => $paData['FTAddGrpType'],
                    'FTCstCode' => $paData['FTCstCode'],
                    'FTAddWebsite' => $paData['FTAddWebsite'],
                    'FTAddLongitude' => $paData['FTAddLongitude'],
                    'FTAddLatitude' => $paData['FTAddLatitude'],
                    'FNLngID' => $paData['FNLngID'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FTCreateBy'  => $paData['FTCreateBy'],

                    'FTAddRefNo' => $paData['FTAddRefNo'],
                    'FTAreCode' => $paData['FTAreCode'],
                    'FTZneCode' => $paData['FTZneCode']
                ];

                if($paData['AddressMode'] == "1"){
                    $aAddressFieldModel_1 = [
                        'FTAddVersion' => "1", // Split Field
                        'FTAddV1No' => $paData['FTAddV1No'],
                        'FTAddV1Soi' => $paData['FTAddV1Soi'],
                        'FTAddV1Village' => $paData['FTAddV1Village'],
                        'FTAddV1Road' => $paData['FTAddV1Road'],
                        'FTAddCountry' => $paData['FTAddCountry'],
                        'FTAddV1PvnCode' => $paData['FTAddV1PvnCode'],
                        'FTAddV1DstCode' => $paData['FTAddV1DstCode'],
                        'FTAddV1SubDist' => $paData['FTAddV1SubDist'],
                        'FTAddV1PostCode' => $paData['FTAddV1PostCode'],
                        'FTAddRmk' => $paData['FTAddRmk'],
                    ];
                    $aMergeField = array_merge($aAddressField, $aAddressFieldModel_1);
                }

                if($paData['AddressMode'] == "2"){
                    $aAddressFieldModel_2 = [
                        'FTAddVersion' => "2", // Combine Field
                        'FTAddV2Desc1' => $paData['FTAddV2Desc1'],
                        'FTAddV2Desc2' => $paData['FTAddV2Desc2'],
                    ];
                    $aMergeField = array_merge($aAddressField, $aAddressFieldModel_2);
                }
                $this->db->insert('TCNMCstAddress_L', $aMergeField);

                if($this->db->affected_rows() > 0){

                    if($paData['FTAddGrpType'] == "1"){ // Customer
                        $this->FSaMCSTUpdateDateMaster($paData);
                    }
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Address Success',
                    );

                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Address.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Add or Update Customer Contact
     * Parameters : $paData is data
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateContact($paData){
        try{
            // Update Master
            $this->db->set('FTCtrName', $paData['FTCtrName']);
            $this->db->set('FTCtrEmail' , $paData['FTCtrEmail']);
            $this->db->set('FTCtrTel' , $paData['FTCtrTel']);
            $this->db->set('FTCtrFax' , $paData['FTCtrFax']);
            $this->db->set('FTCtrRmk' , $paData['FTCtrRmk']);

            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->where('FNCtrSeq', $paData['FNCtrSeq']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->update('TCNMCstContact_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtRefId' => 0,
                    'rtCode' => '1',
                    'rtDesc' => 'Update Contact Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMCstContact_L',array(
                    'FTCtrName' => $paData['FTCtrName'],
                    'FTCtrEmail' => $paData['FTCtrEmail'],
                    'FTCtrTel' => $paData['FTCtrTel'],
                    'FTCtrFax' => $paData['FTCtrFax'],
                    'FTCtrRmk' => $paData['FTCtrRmk'],

                    'FTCstCode' => $paData['FTCstCode'],
                    'FNLngID' => $paData['FNLngID'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FTCreateBy' => $paData['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtRefId' => $this->db->insert_id(),
                        'rtCode' => '1',
                        'rtDesc' => 'Add Contact Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Contact.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : List Customer Contact
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 28/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCSTContactList($ptAPIReq, $ptMethodReq, $paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tCstCode = $paData['FTCstCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL     = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY rtCtrSeq DESC) AS rtRowID,*
                        FROM
                        (SELECT DISTINCT
                            CTRL.FTCstCode AS rtCstCode,
                            CTRL.FTCtrName AS rtCtrName,
                            CTRL.FTCtrTel AS rtCtrTel,
                            CTRL.FTCtrFax AS rtCtrFax,
                            CTRL.FTCtrEmail AS rtCtrEmail,
                            CTRL.FTCtrRmk AS rtCtrRmk,
                            CTRL.FNCtrSeq AS rtCtrSeq,
                            CTRL.FDCreateOn AS rtCtrCreateOn,
                            ADL.FNAddSeqNo AS rtCtrAddSeqNo,
                            ADL.FTAddV1No AS rtCtrAddV1No,
                            ADL.FTAddV1Soi AS rtCtrAddV1Soi,
                            ADL.FTAddV1Village AS rtCtrAddV1Village,
                            ADL.FTAddV1Road AS rtCtrAddV1Road,
                            ADL.FTAddWebsite AS rtCtrAddWebsite,
                            ADL.FTAddRmk AS rtCtrAddRmk,
                            ADL.FTAddLongitude AS rtCtrAddLongitude,
                            ADL.FTAddLatitude AS rtCtrAddLatitude,
                            ADL.FTAddCountry AS rtCtrAddCountry,
                            ADL.FTZneCode AS rtCtrAddZoneCode,
                            ADL.FTAreCode AS rtCtrAddAreaCode,
                            ADL.FTAddV1PvnCode AS  rtCtrAddProvinceCode,
                            ADL.FTAddV1DstCode AS rtCtrAddDistrictCode,
                            ADL.FTAddV1SubDist AS  rtCtrAddSubDistrictCode,
                            ADL.FTAddV1PostCode AS rtCtrAddPostCode,
                            ADL.FTAddV2Desc1 AS rtCtrAddV2Desc1,
                            ADL.FTAddV2Desc2 AS rtCtrAddV2Desc2,
                            ZNEL.FTZneName AS rtCtrAddZoneName,
                            PVNL.FTPvnName AS rtCtrAddProvinceName,
                            DSTL.FTDstName AS rtCtrAddDistrictName,
                            SDSTL.FTSudName AS rtCtrAddSubDistrictName
                        FROM [TCNMCstContact_L] CTRL

                        LEFT JOIN [TCNMCstAddress_L] ADL
                        ON ADL.FTCstCode = CTRL.FTCstCode
                        AND ADL.FTAddRefNo = CTRL.FNCtrSeq
                        AND ADL.FTAddGrpType = 2
                        AND ADL.FNLngID = $nLngID

                        LEFT JOIN [TCNMZone_L] ZNEL
                        ON ZNEL.FTZneCode = ADL.FTZneCode
                        AND ZNEL.FNLngID = $nLngID

                        LEFT JOIN [TCNMProvince_L] PVNL
                        ON PVNL.FTPvnCode = ADL.FTAddV1PvnCode
                        AND PVNL.FNLngID = $nLngID

                        LEFT JOIN [TCNMDistrict_L] DSTL
                        ON DSTL.FTDstCode = ADL.FTAddV1DstCode
                        AND DSTL.FNLngID = $nLngID

                        LEFT JOIN [TCNMSubDistrict_L] SDSTL
                        ON SDSTL.FTSudCode = ADL.FTAddV1SubDist
                        AND SDSTL.FNLngID = $nLngID

                        WHERE CTRL.FTCstCode = '$tCstCode' AND CTRL.FNLngID = $nLngID";

        // LEFT JOIN [TCNMImgPerson] IMGP ON IMGP.FTImgRefID = CTCL.FTCstCode
        // IMGP.FTImgObj AS rtImgObj

        /*$tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (CST.FTCstCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CSTL.FTCstName LIKE '%$tSearchList%'";
            $tSQL .= " OR CSTGL.FTCgpName LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTCstTel LIKE '%$tSearchList%')";
        }*/
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCSTContactGetPageAll($tCstCode, '', $nLngID);
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
     * Functionality : All Page Of Customer Contact
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 28/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCSTContactGetPageAll($ptCstCode, $ptSearchList = '', $ptLngID){
        $tSQL = "SELECT COUNT (CTCL.FTCstCode) AS counts
                FROM [TCNMCstContact_L] CTCL
                WHERE CTCL.FTCstCode = '$ptCstCode' AND CTCL.FNLngID = $ptLngID";

        // LEFT JOIN [TCNMImgPerson] IMGP ON IMGP.FTImgRefID = CTCL.FTCstCode
        /*if($ptSearchList != ''){
            $tSQL .= " AND (CST.FTCstCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CSTL.FTCstName LIKE '%$ptSearchList%'";
            $tSQL .= " OR CSTGL.FTCgpName LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTCstTel LIKE '%$ptSearchList%')";
        }*/

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

     /**
     * Functionality : Delete Customer
     * Parameters : $paData
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSnMCSTContactDel($paData){
        $this->db->where('FTCstCode', $paData['FTCstCode']);
        $this->db->where('FTAddRefNo', $paData['FTAddRefNo']);
        $this->db->delete('TCNMCstAddress_L');

        $this->db->where('FTCstCode', $paData['FTCstCode']);
        $this->db->where('FNCtrSeq', $paData['FNCtrSeq']);
        $this->db->delete('TCNMCstContact_L');

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
     * Functionality : Add or Update Customer Card Info
     * Parameters : $paData is data
     * Creator : 25/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateCardInfo($paData){
        try{
            // Update Card Info
            $this->db->set('FTCstCrdNo', $paData['FTCstCrdNo']);
            $this->db->set('FDCstApply', $paData['FDCstApply']);
            $this->db->set('FDCstCrdIssue', $paData['FDCstCrdIssue']);
            $this->db->set('FDCstCrdExpire', $paData['FDCstCrdExpire']);
            $this->db->set('FTBchCode', $paData['FTBchCode']);
            $this->db->set('FTCstStaAge', $paData['FTCstStaAge']);
            $this->db->set('FTCgpCode', $paData['FTCgpCode']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCstCard');

            if($this->db->affected_rows() > 0){

                $this->FSaMCSTUpdateDateMaster($paData);
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Card Info Success',
                );

            }else{
                // Add Card Info
                $this->db->insert('TCNMCstCard', array(
                    'FTCstCode' => $paData['FTCstCode'],
                    'FTCstCrdNo' => $paData['FTCstCrdNo'],
                    'FDCstApply' => $paData['FDCstApply'],
                    'FDCstCrdIssue' => $paData['FDCstCrdIssue'],
                    'FDCstCrdExpire' => $paData['FDCstCrdExpire'],
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTCgpCode' => $paData['FTCgpCode'],
                    'FTCstStaAge' => $paData['FTCstStaAge'],
                ));

                if($this->db->affected_rows() > 0){

                    $this->FSaMCSTUpdateDateMaster($paData);
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Card Info Success',
                    );

                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Card Info.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Add or Update Customer Address
     * Parameters : $paData is data
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateCredit($paData){
        try{
            // Update Credit
            $this->db->set('FNCstCrTerm', $paData['FNCstCrTerm']);
            $this->db->set('FCCstCrLimit', $paData['FCCstCrLimit']);
            $this->db->set('FTCstStaAlwOrdMon', $paData['FTCstStaAlwOrdMon']);
            $this->db->set('FTCstStaAlwOrdTue', $paData['FTCstStaAlwOrdTue']);
            $this->db->set('FTCstStaAlwOrdWed', $paData['FTCstStaAlwOrdWed']);
            $this->db->set('FTCstStaAlwOrdThu', $paData['FTCstStaAlwOrdThu']);
            $this->db->set('FTCstStaAlwOrdFri', $paData['FTCstStaAlwOrdFri']);
            $this->db->set('FTCstStaAlwOrdSat', $paData['FTCstStaAlwOrdSat']);
            $this->db->set('FTCstStaAlwOrdSun', $paData['FTCstStaAlwOrdSun']);
            $this->db->set('FTCstPayRmk', $paData['FTCstPayRmk']);
            $this->db->set('FTCstBillRmk', $paData['FTCstBillRmk']);
            $this->db->set('FTCstViaRmk', $paData['FTCstViaRmk']);
            $this->db->set('FNCstViaTime', $paData['FNCstViaTime']);
            $this->db->set('FTViaCode', $paData['FTViaCode']);
            $this->db->set('FTCstTspPaid', $paData['FTCstTspPaid']);
            $this->db->set('FTCstStaApv', $paData['FTCstStaApv']);

            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCstCredit');

            if($this->db->affected_rows() > 0){

                $this->FSaMCSTUpdateDateMaster($paData);
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Credit Success',
                );

            }else{
                // Add Credit
                $this->db->insert('TCNMCstCredit', array(
                    'FTCstCode' => $paData['FTCstCode'],
                    'FNCstCrTerm' => $paData['FNCstCrTerm'],
                    'FCCstCrLimit' => $paData['FCCstCrLimit'],
                    'FTCstStaAlwOrdMon' => $paData['FTCstStaAlwOrdMon'],
                    'FTCstStaAlwOrdTue' => $paData['FTCstStaAlwOrdTue'],
                    'FTCstStaAlwOrdWed' => $paData['FTCstStaAlwOrdWed'],
                    'FTCstStaAlwOrdThu' => $paData['FTCstStaAlwOrdThu'],
                    'FTCstStaAlwOrdFri' => $paData['FTCstStaAlwOrdFri'],
                    'FTCstStaAlwOrdSat' => $paData['FTCstStaAlwOrdSat'],
                    'FTCstStaAlwOrdSun' => $paData['FTCstStaAlwOrdSun'],
                    'FTCstPayRmk' => $paData['FTCstPayRmk'],
                    'FTCstBillRmk' => $paData['FTCstBillRmk'],
                    'FTCstViaRmk' => $paData['FTCstViaRmk'],
                    'FNCstViaTime' => $paData['FNCstViaTime'],
                    'FTViaCode' => $paData['FTViaCode'],
                    'FTCstTspPaid' => $paData['FTCstTspPaid'],
                    'FTCstStaApv' => $paData['FTCstStaApv'],
                ));

                if($this->db->affected_rows() > 0){

                    $this->FSaMCSTUpdateDateMaster($paData);
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Credit Success',
                    );

                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Credit.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Add or Update Customer RFID
     * Parameters : $paData is data
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateRfid($paData){
        try{
            $this->db->insert('TCNMCstRFID_L',array(
                'FTCstCode'     => $paData['FTCstCode'],
                'FTCstID'       => $paData['FTCstID'],
                'FTCrfName'     => $paData['FTCrfName'],
                'FNLngID'       => $paData['FNLngID']
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
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    public function FSaMCSTUpdateRfid($paData){
        try{
            $this->db->set('FTCstID' , $paData['tEditCstID']);
            $this->db->set('FTCrfName' , $paData['tEditCrfName']);
            $this->db->where('FTCstID', $paData['FTCstID']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCstRFID_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Date Master Success',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
        // try{
        //     $this->db->insert('TCNMCstRFID_L',array(
        //         'FTCstCode'     => $paData['FTCstCode'],
        //         'FTCstID'       => $paData['FTCstID'],
        //         'FTCrfName'     => $paData['FTCrfName'],
        //         'FNLngID'       => $paData['FNLngID']
        //     ));
        //     if($this->db->affected_rows() > 0){
        //         $aStatus = array(
        //             'rtCode' => '1',
        //             'rtDesc' => 'Add Master Success',
        //         );
        //     }else{
        //         $aStatus = array(
        //             'rtCode' => '905',
        //             'rtDesc' => 'Error Cannot Add/Edit Master.',
        //         );
        //     }
        //     return $aStatus;
        // }catch(Exception $Error){
        //     return $Error;
        // }
    }

        /**
     * Functionality : Delete Customer
     * Parameters : $paData
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSnMCSTDeleteRfid($paData){
        $this->db->where('FTCstCode', $paData['FTCstCode']);
        $this->db->where('FTCstID', $paData['FTCstID']);
        $this->db->delete('TCNMCstRFID_L');

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
     * Functionality : Update Customer Master
     * Parameters : $paData is data
     * Creator : 25/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTUpdateDateMaster($paData){
        try{
            // Update Master
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCst');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Date Master Success',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Delete Customer
     * Parameters : $paData
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSnMCSTDel($paData){
        $this->db->where_in('FTImgRefID', $paData['FTCstCode']);
        $this->db->delete('TCNMImgPerson');

        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->delete('TCNMCstCredit');

        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->delete('TCNMCstCard');

        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->delete('TCNMCstContact_L');

        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->delete('TCNMCstRFID_L');

        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->delete('TCNMCstAddress_L');

        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->delete('TCNMCst_L');

        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->delete('TCNMCst');

        //ลบ IMG ในตาราง TCNMImgObj
        $this->db->where_in('FTImgRefID', $paData['FTCstCode']);
        $this->db->delete('TCNMImgObj');

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


    public function FSaMCSTRfidDataTable($paData){
        $tCstCode   = $paData['FTCstCode'];
        $nLngID     = $paData['FNLngID'];

        // RFID
        $tRfidSQL = "SELECT DISTINCT
                        RFID.FTCstCode  AS rtCstCode,
                        RFID.FTCstID    AS rtCstID,
                        RFID.FTCrfName  AS rtCrfName
                    FROM TCNMCstRFID_L RFID
                    WHERE RFID.FTCstCode = '$tCstCode'
                    AND RFID.FNLngID = $nLngID";
        $oRfidQuery = $this->db->query($tRfidSQL);

        if ($oRfidQuery->num_rows() > 0){
            //Found
            $oRfidDetail = $oRfidQuery->result();
            $aResult = array(
                'raRfid'    => $oRfidDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $oResult = json_encode($aResult);
        $aResult = json_decode($oResult, true);
        return $aResult;

    }

  /**
     * Functionality : FSaMCSTGetMasterLang4MQ
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMCSTGetMasterLang4MQ($ptCgpCode,$ptCstCode){
        $tSqlCstL="  SELECT '$ptCgpCode' AS FTCgpCode,
        CSTL.FTCstCode AS FTMemCode,
        CSTL.FNLngID AS FNLngID,
        CSTL.FTCstName AS FTMemName,
        CSTL.FTCstNameOth AS FTMemNameOth,
        CSTL.FTCstRmk AS FTMemRmk
        FROM TCNMCst_L CSTL WITH (NOLOCK)
        WHERE CSTL.FTCstCode='$ptCstCode' ";
        $oQuery = $this->db->query($tSqlCstL);
        $aCstMaster_L = $oQuery->result_array();

        return $aCstMaster_L;
    }

    /**
     * Functionality : FSaMCSTGetAddress4MQ
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMCSTGetAddress4MQ($ptCgpCode,$ptCstCode){

        $tSqlCstAdd = "SELECT
        '$ptCgpCode' AS FTCgpCode,
        CSTADL.FTCstCode AS FTMemCode,
        CSTADL.FNLngID AS FNLngID,
        CSTADL.FTAddGrpType AS FTAddGrpType,
        CSTADL.FNAddSeqNo AS FNAddSeqNo,
        CSTADL.FTAddRefNo AS FTAddRefNo,
        CSTADL.FTAddName AS FTAddName,
        CSTADL.FTAddRmk AS FTAddRmk,
        CSTADL.FTAddCountry AS FTAddCountry ,
        CSTADL.FTAreCode AS FTAreCode,
        CSTADL.FTZneCode AS FTZneCode,
        CSTADL.FTAddVersion AS FTAddVersion,
        CSTADL.FTAddV1No AS FTAddV1No,
        CSTADL.FTAddV1Soi AS FTAddV1Soi,
        CSTADL.FTAddV1Village AS FTAddV1Village,
        CSTADL.FTAddV1Road AS FTAddV1Road,
        CSTADL.FTAddV1SubDist AS FTAddV1SubDist,
        CSTADL.FTAddV1DstCode AS FTAddV1DstCode,
        CSTADL.FTAddV1PvnCode AS FTAddV1PvnCode,
        CSTADL.FTAddV1PostCode AS FTAddV1PostCode,
        CSTADL.FTAddV2Desc1 AS FTAddV2Desc1,
        CSTADL.FTAddV2Desc2 AS FTAddV2Desc2,
        CSTADL.FTAddWebsite AS FTAddWebsite,
        CSTADL.FTAddLongitude AS FTAddLongitude,
        CSTADL.FTAddLatitude AS FTAddLatitude,
        CSTADL.FDLastUpdOn AS FDLastUpdOn,
        CSTADL.FTLastUpdBy AS FTLastUpdBy,
        CSTADL.FDCreateOn AS FDCreateOn,
        CSTADL.FTCreateBy AS FTCreateBy
        FROM TCNMCstAddress_L CSTADL WITH (NOLOCK)
        WHERE CSTADL.FTCstCode='$ptCstCode'
        ";
        $oQuery = $this->db->query($tSqlCstAdd);
        $aCstMaster_L = $oQuery->result_array();
        return $aCstMaster_L;
    }

      /**
     * Functionality : FSnMCSTGetAmtActive
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FScMCSTGetAmtActive($ptCstCode){
        $aCstMaster =  $this->db->where('FTCstCode',$ptCstCode)->get('TCNMCst')->row_array();
        ///กรณีลูกค้าใช้ระบบ Member จะมี กลุ่มบัตรใน TsysConfig ใช้ส่งใน MQ
        $tCgpCode   = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',1)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
        if(!empty($aCstMaster['FTAgnCode'])){
        $aDataCgp = $this->FScMCSTGetInfoMemberConFigSpc($aCstMaster['FTAgnCode'],1);
            if($aDataCgp['rtCode']=='1'){
                    $tCgpCode = $aDataCgp['raItem']['FTCfgStaUsrValue'];
            }
        }


      $cTxnBuyTotal = $this->db->where('FTCgpCode',$tCgpCode)->where('FTMemCode',$ptCstCode)->get('TCNTMemAmtActive')->row_array()['FCTxnBuyTotal'];
      return $cTxnBuyTotal;
    }

    /**
     * Functionality : FSnMCSTGetAmtActive
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FScMCSTGetPntActive($ptCstCode){
        $aCstMaster =  $this->db->where('FTCstCode',$ptCstCode)->get('TCNMCst')->row_array();
        ///กรณีลูกค้าใช้ระบบ Member จะมี กลุ่มบัตรใน TsysConfig ใช้ส่งใน MQ
        $tCgpCode   = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',1)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
        if(!empty($aCstMaster['FTAgnCode'])){
        $aDataCgp = $this->FScMCSTGetInfoMemberConFigSpc($aCstMaster['FTAgnCode'],1);
            if($aDataCgp['rtCode']=='1'){
                    $tCgpCode = $aDataCgp['raItem']['FTCfgStaUsrValue'];
            }
        }
        $cTxnPntQty = $this->db->where('FTCgpCode',$tCgpCode)->where('FTMemCode',$ptCstCode)->get('TCNTMemPntActive')->row_array()['FCTxnPntQty'];
        return $cTxnPntQty;
      }

          /**
     * Functionality : FScMCSTGetPntExp
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FScMCSTGetPntExp($ptCstCode){
        $aCstMaster = $this->db->where('FTCstCode',$ptCstCode)->get('TCNMCst')->row_array();
        ///กรณีลูกค้าใช้ระบบ Member จะมี กลุ่มบัตรใน TsysConfig ใช้ส่งใน MQ
        $tCgpCode   = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',1)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
        if(!empty($aCstMaster['FTAgnCode'])){
            $aDataCgp = $this->FScMCSTGetInfoMemberConFigSpc($aCstMaster['FTAgnCode'],1);
            if($aDataCgp['rtCode']=='1'){
                $tCgpCode = $aDataCgp['raItem']['FTCfgStaUsrValue'];
            }
        }
        $cTxnPnt2ExpYear = $this->db->where('FTCgpCode',$tCgpCode)->where('FTMemCode',$ptCstCode)->get('TCNTMemPntActive')->row_array()['FCTxnPnt2ExpYear'];
        return $cTxnPnt2ExpYear;
      }




      /**
     * Functionality : FScMCSTGetPntExp
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FScMCSTGetInfoMemberConFigSpc($ptAgnCode,$nSeq){

        $tSQL =" SELECT
        CONSPC.FTSysCode,
        CONSPC.FTSysApp,
        CONSPC.FTSysKey,
        CONSPC.FTSysSeq,
        CONSPC.FTAgnCode,
        CONSPC.FTSysStaDataType,
        CONSPC.FTCfgStaUsrValue,
        CONSPC.FTCfgStaUsrRef
        FROM TCNTConfigSpc CONSPC WITH (NOLOCK)
        WHERE FTSysCode = 'AMQMember' AND FTSysApp = 'MB'
        AND FTSysKey = 'Member' AND FTSysSeq IN ('$nSeq')
        AND FTAgnCode ='$ptAgnCode' ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            //Found
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItem'    => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $oResult = json_encode($aResult);
        $aResult = json_decode($oResult, true);
        return $aResult;

      }


}
