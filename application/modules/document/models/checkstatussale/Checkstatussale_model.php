<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkstatussale_model extends CI_Model {

    // Data List
    // Create By: Napat(Jame) 02/07/2021
    public function FSaMCSSDataList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQLPage1  = " SELECT c.* FROM( SELECT ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM ( ";
        $tSQLSelect = " SELECT BCHL.FTBchCode,BCHL.FTBchName,APPL.FTAppCode,APPL.FTAppName,HD.FTXshDocNo,CONVERT(VARCHAR(10),HD.FDXshDocDate,121) AS FDXshDocDate,
                               CSTL.FTCstCode,CSTL.FTCstName,CHN.FTChnCode,MAP.FTMapName AS FTChnName,HD.FTXshStaApv,HD.FTXshApvCode,USRL.FTUsrName AS FTXshApvName,HD.FDCreateOn,
                               HD.FNXshStaDocAct, HD.FTXshStaPrcDoc, HD.FTXshETaxStatus, HD.FTXshRefExt "; //CHNL.FTChnName
        $tSQLCount  = " SELECT COUNT(HD.FTXshDocNo) AS FNXshRowAll ";
        $tSQLFrom   = " FROM TPSTSalHD          HD   WITH(NOLOCK) 
                        INNER JOIN TCNMBranch   BCH  WITH(NOLOCK) ON HD.FTBchCode = BCH.FTBchCode
                        LEFT JOIN TCNMBranch_L  BCHL WITH(NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMCst_L     CSTL WITH(NOLOCK) ON HD.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $nLngID
                        LEFT JOIN TSysApp_L     APPL WITH(NOLOCK) ON HD.FTAppCode = APPL.FTAppCode AND APPL.FNLngID = $nLngID
                        LEFT JOIN TCNMUser_L    USRL WITH(NOLOCK) ON HD.FTXshApvCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                        INNER JOIN TCNMChannel  CHN  WITH(NOLOCK) ON HD.FTChnCode = CHN.FTChnCode
                        LEFT JOIN TLKMMapping   MAP  WITH(NOLOCK) ON MAP.FNMapSeqNo = CHN.FTChnRefCode AND MAP.FTMapCode = 'tChnDelivery'
                        WHERE CHN.FTChnRefCode <> '2' ";
                        //LEFT JOIN TCNMChannel_L CHNL WITH(NOLOCK) ON HD.FTChnCode = CHNL.FTChnCode AND CHNL.FNLngID = $nLngID
                        /*INNER JOIN (
                            SELECT 
                                MAP.FNMapSeqNo,
                                CASE WHEN ISNULL(MAP.FTMapUsrValue,'') = '' THEN MAP.FTMapDefValue ELSE MAP.FTMapUsrValue END AS FTChnCode
                            FROM TLKMMapping MAP WITH(NOLOCK)
                            WHERE MAP.FTMapCode = 'tChnDelivery'
                              AND MAP.FNMapSeqNo IN ('0','1','3')
                        ) ALWCHN ON HD.FTChnCode = ALWCHN.FTChnCode*/

        // Parameters Search
        $tAgnCode = $paData['aSearchList']['tAgnCode'];
        if( $tAgnCode != "" ){
            $tSQLFrom .= " AND BCH.FTAgnCode = '".$tAgnCode."' ";
        }

        $tBchCode = $paData['aSearchList']['tBchCode'];
        if( $tBchCode != "" ){
            $tSQLFrom .= " AND BCH.FTBchCode = '".$tBchCode."' ";
        }

        $tDocNo = $paData['aSearchList']['tDocNo'];
        if( $tDocNo != "" ){
            $tSQLFrom .= " AND ( HD.FTXshDocNo LIKE '%".$tDocNo."%' OR HD.FTXshRefExt LIKE '%".$tDocNo."%' ) ";
        }

        $nDocType = intval($paData['aSearchList']['tDocType']);
        if( $nDocType != "" ){
            $tSQLFrom .= " AND HD.FNXshDocType = ".$nDocType." ";
        }

        $tChnCode = $paData['aSearchList']['tChnCode'];
        if( $tChnCode != "" ){
            // $tSQLFrom .= " AND CHNL.FTChnCode = '".$tChnCode."' ";
            $tSQLFrom .= " AND CHN.FTChnRefCode = '".$tChnCode."' ";
        }

        $dDocDate = $paData['aSearchList']['dDocDate'];
        if( $dDocDate != "" ){
            $tSQLFrom .= " AND CONVERT(VARCHAR(10),HD.FDXshDocDate,121) = '".$dDocDate."' ";
        }

        $tStaPrcDoc = $paData['aSearchList']['tStaPrcDoc'];
        if( $tStaPrcDoc != "" ){
            $tSQLFrom .= " AND HD.FTXshStaPrcDoc = '".$tStaPrcDoc."' ";
        }

        $tSQLPage2  = " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";

        $tSQLData = $tSQLPage1.$tSQLSelect.$tSQLFrom.$tSQLPage2;

        $oQuery = $this->db->query($tSQLData);
        // echo $this->db->last_query();
        if ( $oQuery->num_rows() > 0 ){
            $tSQLRowAll     = $tSQLCount.$tSQLFrom;
            $oQueryRowAll   = $this->db->query($tSQLRowAll);
            $nFoundRow      = $oQueryRowAll->result_array()[0]['FNXshRowAll'];
            $nPageAll       = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'aItems'           => $oQuery->result_array(),
                'nAllRow'          => $nFoundRow,
                'nCurrentPage'     => $paData['nPage'],
                'nAllPage'         => $nPageAll,
                'tCode'            => '1',
                'tDesc'            => 'success'
            );
        } else {
            $aResult = array(
                'nAllRow'           => 0,
                'nCurrentPage'      => $paData['nPage'],
                "nAllPage"          => 0,
                'tCode'             => '800',
                'tDesc'             => 'data not found'
            );
        }
        return $aResult;
    }

    // ดึงข้อมูล HD เอกสารการขาย
    // Create By: Napat(Jame) 05/07/2021
    public function FSaMCSSEventGetDataDocHD($paData){
        $tDocNo = $paData['tDocNo'];
        $nLngID = $paData['nLngID'];

        $tSQL = "   SELECT
                        /* HD INFO */
                        HD.FTXshDocNo,
                        APPL.FTAppName,
                        HD.FNXshStaDocAct,
                        CONVERT(VARCHAR(10),HD.FDXshDocDate,121) AS FDXshDocDate,
                        CONVERT(VARCHAR(8),HD.FDXshDocDate,114) AS FTXshDocTime,
                        HD.FTXshStaApv,
                        HD.FTCreateBy,
                        APVL.FTUsrName      AS FTApvName,
                        AGNL.FTAgnCode,
                        AGNL.FTAgnName,
                        BCH.FTBchCode,
                        BCHL.FTBchName,
                        ISNULL(HD.FTXshDocVatFull,'') AS FTXshDocVatFull,
                        HD.FTXshVATInOrEx,
                        HD.FTXshStaPrcDoc,
                        HD.FTWahCode,
                        HD.FTPosCode,
                        HD.FTChnCode,
                        MAP.FTMapName AS FTChnName,
                        MAP.FNMapSeqNo,
                        HD.FTXshETaxStatus,
                        HD.FTUsrCode        AS FTUsrCreateCode,
                        USRL.FTUsrName      AS FTUsrCreateName,
                        HD.FNXshDocType,
                        HD.FTXshStaDelMQ,

                        /* CST INFO */
                        HD.FTCstCode,
	                    HCST.FTXshCstName   AS FTCstName,
                        /*CADR.FTAddVersion,CADR.FTAddV1No,CADR.FTAddV1Village,CADR.FTAddV1Road,CADR.FTAddV1Soi,CADR.FTAddV1PostCode,
                        PVN_L.FTPvnCode,
                        PVN_L.FTPvnName,
                        DST_L.FTDstName,
                        SUD_L.FTSudName,
                        CADR.FTAddV2Desc1,CADR.FTAddV2Desc2,
                        HCST.FTXshAddrTax   AS FTCstTaxNo,*/
                        HCST.FTXshCstTel    AS FTCstTel,
                        HCST.FTXshCstEmail  AS FTCstEmail,

                        /* DOC REF INFO */
                        HD.FTXshRefInt,
                        CONVERT(VARCHAR(10),HD.FDXshRefIntDate,121) AS FDXshRefIntDate,
                        HD.FTXshRefExt,
                        CONVERT(VARCHAR(10),HD.FDXshRefExtDate,121) AS FDXshRefExtDate,

                        HD.FTXshRmk,
                        ISNULL(HD.FTXshRefTax,'')  AS FTXshRefTax,
                        ISNULL(HD.FTXshStaETax,'') AS FTXshStaETax,

                        /* TAX HD */
                        ISNULL(TAXHD.FTXshETaxStatus,'')    AS FTXshETaxStatusFullTax,
                        ISNULL(TAXHD.FTXshRefTax,'')        AS FTXshRefTaxFullTax,
                        ISNULL(TAXHD.FTXshStaETax,'')       AS FTXshStaETaxFullTax,

                        ISNULL(WAH.FTWahStaAlwPLFrmSale,'2')    AS FTWahStaAlwPLFrmSale, /* อนุญาตสร้างใบจัดจากใบขาย */
                        ISNULL(CHN.FTChnStaUseDO,'2')           AS FTChnStaUseDO,        /* อนุญาตสร้างใบส่งของ */

                        HD.FDXshDocDate AS FDTxnDocDate

                    FROM TPSTSalHD              HD   WITH(NOLOCK) 
                    INNER JOIN TCNMBranch       BCH  WITH(NOLOCK) ON HD.FTBchCode = BCH.FTBchCode
                    LEFT JOIN TCNMBranch_L      BCHL WITH(NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMAgency_L      AGNL WITH(NOLOCK) ON BCH.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    LEFT JOIN TPSTSalHDCst      HCST WITH(NOLOCK) ON HD.FTXshDocNo = HCST.FTXshDocNo
                    /*LEFT JOIN TCNMCstAddress_L  CADR WITH(NOLOCK) ON HD.FTCstCode = CADR.FTCstCode AND HCST.FNXshAddrShip = CADR.FNAddSeqNo
                    LEFT JOIN TCNMProvince_L    PVN_L WITH(NOLOCK) ON CADR.FTAddV1PvnCode = PVN_L.FTPvnCode AND PVN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMDistrict_L    DST_L WITH(NOLOCK) ON CADR.FTAddV1DstCode = DST_L.FTDstCode AND DST_L.FNLngID = $nLngID
                    LEFT JOIN TCNMSubDistrict_L SUD_L WITH(NOLOCK) ON CADR.FTAddV1SubDist = SUD_L.FTSudCode AND SUD_L.FNLngID = $nLngID
                    LEFT JOIN TCNMTaxAddress_L  TADR WITH(NOLOCK) ON HD.FTCstCode = TADR.FTCstCode AND TADR.FTAddStaBusiness = '2' AND TADR.FNLngID = $nLngID
                    LEFT JOIN TCNMCst           CST  WITH(NOLOCK) ON HD.FTCstCode = CST.FTCstCode*/
                    LEFT JOIN TSysApp_L         APPL WITH(NOLOCK) ON HD.FTAppCode = APPL.FTAppCode AND APPL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L        APVL WITH(NOLOCK) ON HD.FTXshApvCode = APVL.FTUsrCode AND APVL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L        USRL WITH(NOLOCK) ON HD.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    LEFT JOIN TPSTTaxHD        TAXHD WITH(NOLOCK) ON HD.FTXshDocVatFull = TAXHD.FTXshDocNo
                    INNER JOIN TCNMWaHouse      WAH  WITH(NOLOCK) ON HD.FTBchCode = WAH.FTBchCode AND HD.FTWahCode = WAH.FTWahCode
                    INNER JOIN TCNMChannel      CHN  WITH(NOLOCK) ON HD.FTChnCode = CHN.FTChnCode
                    LEFT JOIN TLKMMapping       MAP  WITH(NOLOCK) ON MAP.FNMapSeqNo = CHN.FTChnRefCode AND MAP.FTMapCode = 'tChnDelivery'
                    WHERE HD.FTXshDocNo = '".$tDocNo."' ";
                    //CHNL.FTChnName,
                    //LEFT JOIN TCNMChannel_L     CHNL WITH(NOLOCK) ON HD.FTChnCode = CHNL.FTChnCode AND CHNL.FNLngID = $nLngID

        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'           => $oQuery->row_array(),
                'tCode'            => '1',
                'tDesc'            => 'success'
            );
        } else {
            $aResult = array(
                'tCode'             => '800',
                'tDesc'             => 'data not found'
            );
        }
        return $aResult;
    }

    // ดึงข้อมูล RC เอกสารการขาย
    // Create By: Napat(Jame) 06/07/2021
    public function FSaMCSSEventGetDataDocRC($paData){
        $tDocNo = $paData['tDocNo'];

        $tSQL = "   SELECT 
                        RC.FTRcvCode,
                        RC.FTRcvName,
                        ISNULL(RC.FTXrcRefNo1,'') AS FTXrcRefNo1,
                        RC.FCXrcNet
                    FROM TPSTSalRC RC WITH(NOLOCK) 
                    WHERE RC.FTXshDocNo = '$tDocNo'
                    ORDER BY FNXrcSeqNo ASC ";

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

    // ดึงข้อมูลรายการสินค้า จากเอกสารการขาย
    // Create By: Napat(Jame) 05/07/2021
    // public function FSaMCSSEventGetDataDocDT($paData){
    //     $tDocNo         = $paData['tDocNo'];
    //     $tSearch        = $paData['tSearch'];
    //     $nLngID         = $paData['nLngID'];
    //     $tSesSessionID  = $this->session->userdata('tSesSessionID');

    //     $tSQL = "   SELECT 
    //                     MAX(ALLDT.FNPartition) OVER (PARTITION BY ALLDT.FTPdtCode) AS FNMaxSeqNo,
    //                     ALLDT.* 
    //                 FROM (
    //                     SELECT 
    //                         ROW_NUMBER() OVER(PARTITION BY DT.FTPdtCode ORDER BY DT.FTPdtCode ASC) AS FNPartition,
    //                         DT.FNXsdSeqNo,
    //                         DT.FTPdtCode,
    //                         PDTL.FTPdtName,
    //                         DT.FTXsdBarCode,
    //                         DT.FTPunCode,
    //                         PUNL.FTPunName,
    //                         DT.FCXsdQty,
    //                         DT.FCXsdSetPrice,
    //                         DT.FTXsdDisChgTxt,
    //                         DT.FCXsdNet,
    //                         SN.FTPdtSerial
    //                     FROM TPSTSalDT DT WITH(NOLOCK) 
    //                     LEFT JOIN (
    //                         SELECT 
    //                             DT.FTXshDocNo,
    //                             DT.FTPdtCode,
    //                             DTSN.FTPdtSerial AS FTPdtSerial
    //                         FROM TPSTSalDT DT WITH(NOLOCK) 
    //                         INNER JOIN TPSTSalDTSN DTSN WITH(NOLOCK) ON DT.FTXshDocNo = DTSN.FTXshDocNo AND DT.FNXsdSeqNo = DTSN.FNXsdSeqNo
    //                         WHERE DT.FTXshDocNo = '$tDocNo' 
                    
    //                         UNION ALL
                    
    //                         SELECT
    //                             DT.FTXshDocNo,
    //                             DT.FTPdtCode,
    //                             TMP.FTSrnCode AS FTPdtSerial
    //                         FROM TPSTSalDT DT WITH(NOLOCK) 
    //                         INNER JOIN TCNTDocDTTmp TMP WITH(NOLOCK) ON DT.FTXshDocNo = TMP.FTXthDocNo AND DT.FTPdtCode = TMP.FTPdtCode AND TMP.FTXthDocKey = 'TPSTSalHD' AND TMP.FTSessionID = '$tSesSessionID'
    //                         WHERE DT.FTXshDocNo = '$tDocNo'
    //                     ) SN ON DT.FTXshDocNo = SN.FTXshDocNo AND DT.FTPdtCode = SN.FTPdtCode
    //                     INNER JOIN TCNMPdt_L 	    PDTL WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
    //                     INNER JOIN TCNMPdtUnit_L 	PUNL WITH(NOLOCK) ON DT.FTPunCode = PUNL.FTPunCode AND PUNL.FNLngID = $nLngID
    //                     WHERE DT.FTXshDocNo = '$tDocNo' 
    //                 ) ALLDT ";

    //     // $tSQL = "   SELECT 
    //     //                 ROW_NUMBER() OVER(PARTITION BY DT.FTPdtCode ORDER BY DT.FTPdtCode ASC) AS FNPartition,
    //     //                 B.FNMaxSeqNo,
    //     //                 DT.FNXsdSeqNo,
    //     //                 DT.FTPdtCode,
    //     //                 PDTL.FTPdtName,
    //     //                 DT.FTXsdBarCode,
    //     //                 CASE WHEN ISNULL(TMP.FTSrnCode,'') = '' THEN DT.FTSrnCode ELSE TMP.FTSrnCode END AS FTSrnCode,
    //     //                 DT.FTPunCode,
    //     //                 PUNL.FTPunName,
    //     //                 DT.FCXsdQty,
    //     //                 DT.FCXsdSetPrice,
    //     //                 DT.FTXsdDisChgTxt,
    //     //                 DT.FCXsdNet,
    //     //                 DTSN.FTPdtSerial
    //     //             FROM TPSTSalDT                DT WITH(NOLOCK)
    //     //             INNER JOIN TCNMPdt_L 	    PDTL WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
    //     //             INNER JOIN TCNMPdtUnit_L 	PUNL WITH(NOLOCK) ON DT.FTPunCode = PUNL.FTPunCode AND PUNL.FNLngID = $nLngID 
    //     //             LEFT JOIN TCNTDocDTTmp       TMP WITH(NOLOCK) ON DT.FTPdtCode = TMP.FTPdtCode AND TMP.FTXthDocKey = 'TPSTSalHD' AND TMP.FTSessionID = '$tSesSessionID' AND  DT.FTXshDocNo = TMP.FTXthDocNo
    //     //             LEFT JOIN TPSTSalDTSN       DTSN WITH(NOLOCK) ON DT.FTXshDocNo = DTSN.FTXshDocNo AND DT.FNXsdSeqNo = DTSN.FNXsdSeqNo
    //     //             LEFT JOIN (
    //     //                 SELECT 
    //     //                     FTXshDocNo,
    //     //                     FNXsdSeqNo,
    //     //                     COUNT(FNXsdSeqNo) AS FNMaxSeqNo
    //     //                 FROM TPSTSalDTSN WITH(NOLOCK)
    //     //                 GROUP BY FTXshDocNo,FNXsdSeqNo
    //     //             ) B ON	DT.FTXshDocNo = B.FTXshDocNo AND DT.FNXsdSeqNo = B.FNXsdSeqNo
    //     //             WHERE DT.FTXshDocNo = '$tDocNo' 
    //     //             ";

    //     if( !empty($tSearch) && isset($tSearch) ){
    //         $tSQL .= " AND ( DT.FTPdtCode LIKE '%$tSearch%'
    //                       OR PDTL.FTPdtName LIKE '%$tSearch%' 
    //                       OR DT.FTXsdBarCode LIKE '%$tSearch%'
    //                       OR DT.FTPunCode LIKE '%$tSearch%' 
    //                       OR PUNL.FTPunName LIKE '%$tSearch%' 
    //                         )";
    //     }

    //     $oQuery = $this->db->query($tSQL);
    //     // echo $this->db->last_query();exit;
    //     if ( $oQuery->num_rows() > 0 ){
    //         $aResult = array(
    //             'aItems'           => $oQuery->result_array(),
    //             'tCode'            => '1',
    //             'tDesc'            => 'success'
    //         );
    //     } else {
    //         $aResult = array(
    //             'aItems'            => array(),
    //             'tCode'             => '800',
    //             'tDesc'             => 'data not found'
    //         );
    //     }
    //     return $aResult;
    // }

    // ดึงข้อมูลรายการท้ายบิล
    // Create By: Napat(Jame) 06/07/2021
    public function FSaMCSSEventGetDataEndBill($paData){
        $tDocNo = $paData['tDocNo'];

        $tSQL = "   SELECT 
                        HD.FCXshTotal,
                        HD.FTXshDisChgTxt,
                        HD.FCXshDis,
                        HD.FCXshChg,
                        (HD.FCXshToTalAfDisChgV + HD.FCXshToTalAfDisChgNV) AS FCXshNetAfHD,
                        HD.FCXshVat,
                        HD.FCXshGrand,
                        HD.FTXshGndText,
                        HD.FCXshRnd
                    FROM TPSTSalHD HD WITH(NOLOCK)
                    WHERE HD.FTXshDocNo = '$tDocNo' ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'           => $oQuery->row_array(),
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

    // ดึงข้อมูล vat ตามรายการสินค้า
    // Create By: Napat(Jame) 06/07/2021
    public function FSaMCSSEventGetDataEndBillVat($paData){
        $tDocNo = $paData['tDocNo'];

        $tSQL = "   SELECT 
                        ISNULL(DT.FCXsdVatRate,0) AS FCXtdVatRate,
                        SUM(ISNULL(DT.FCXsdVat,0)) AS FCXtdVat
                    FROM TPSTSalDT DT WITH(NOLOCK) 
                    WHERE DT.FTXshDocNo = '$tDocNo'
                        AND DT.FTXsdVatType = '1' 
                        /*AND DT.FCXsdVatRate > 0*/
                    GROUP BY DT.FCXsdVatRate
                    ORDER BY DT.FCXsdVatRate ASC ";
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

    // ตรวจสอบ Serial ที่ยังไม่ได้ระบุ
    // Create By: Napat(Jame) 06/07/2021
    public function FSnMCSSEventCountSerial($paData){
        $tDocNo         = $paData['tDocNo'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        // $tSQL = "   SELECT 
        //                 COUNT(DT.FTPdtCode) AS FNSrnCount
        //             FROM TPSTSalDT DT WITH(NOLOCK)
        //             LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //             LEFT JOIN TCNTDocDTTmp TMP WITH(NOLOCK) ON DT.FTPdtCode = TMP.FTPdtCode AND TMP.FTXthDocKey = 'TPSTSalHD' AND TMP.FTSessionID = '$tSesSessionID' AND DT.FTXshDocNo = TMP.FTXthDocNo
        //             WHERE DT.FTXshDocNo = '$tDocNo'
        //                 AND ( TMP.FTSrnCode IS NULL AND DT.FTSrnCode = '' )
        //                 AND PDT.FTPdtSetOrSN IN ('3','4')";
        // $tSQL = "   SELECT 
        //                 A.FTPdtCode,
        //                 A.FNReq,
        //                 (A.FNDTSNCur + A.FNTmpCur) AS FNCurrent
        //             FROM (
        //                 SELECT 
        //                         DT.FTPdtCode,
        //                         DT.FCXsdQty AS FNReq,
        //                         ISNULL(DTSN.FNCurrent,0) AS FNDTSNCur,
        //                         ISNULL(TMP.FNCurrent,0) AS FNTmpCur
        //                 FROM TPSTSalDT DT WITH(NOLOCK)
        //                 LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //                 LEFT JOIN (
        //                     SELECT
        //                         FTXshDocNo,FNXsdSeqNo,COUNT(FNXsdSeqNo) AS FNCurrent
        //                     FROM TPSTSalDTSN WITH(NOLOCK)
        //                     GROUP BY FTXshDocNo,FNXsdSeqNo
        //                 ) DTSN ON DT.FTXshDocNo = DTSN.FTXshDocNo AND DT.FNXsdSeqNo = DTSN.FNXsdSeqNo
        //                 LEFT JOIN (
        //                     SELECT 
        //                         FTXthDocNo,FTPdtCode,COUNT(FTPdtCode) AS FNCurrent
        //                     FROM TCNTDocDTTmp WITH(NOLOCK) 
        //                     WHERE FTXthDocKey = 'TPSTSalHD' 
        //                       AND FTSessionID = '$tSesSessionID'
        //                     GROUP BY FTXthDocNo,FTPdtCode
        //                 ) TMP ON DT.FTXshDocNo = TMP.FTXthDocNo AND DT.FTPdtCode = TMP.FTPdtCode
        //                 WHERE DT.FTXshDocNo = '$tDocNo'
        //                         AND PDT.FTPdtSetOrSN IN ('3','4')
        //             ) A
        //             WHERE A.FNReq <> (A.FNDTSNCur + A.FNTmpCur) ";
        $tSQL = "   SELECT
                        TMP.FTPdtCode,
                        TMP.FTXtdPdtName,
                        TMP.FTXtdBarCode
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo = '$tDocNo'
                      AND TMP.FTXthDocKey = 'TPSTSalHD' 
                      AND TMP.FTSessionID = '$tSesSessionID'
                      AND TMP.FTXtdStaPrcStk IN ('3','4')
                      AND ISNULL(TMP.FTSrnCode,'') = ''  ";
        $oQuery = $this->db->query($tSQL); 
        // echo $this->db->last_query();
        return $oQuery->num_rows()/*$oQuery->row_array()['FNSrnCount']*/;
    }

    // ดึงข้อมูลสินค้าที่ต้องระบุหมายเลขซีเรียล
    // Create By: Napat(Jame) 07/07/2021
    public function FSaMCSSEventGetDataPdtSN($paData){
        $tDocNo         = $paData['tDocNo'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        // $tSQL = "   SELECT 
        //                 DT.FTXsdBarCode,
        //                 DT.FTPdtCode,
        //                 DT.FTXsdPdtName
        //             FROM TPSTSalDT      DT WITH(NOLOCK)
        //             INNER JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //             LEFT JOIN TCNTDocDTTmp TMP WITH(NOLOCK) ON DT.FTPdtCode = TMP.FTPdtCode AND TMP.FTXthDocKey = 'TPSTSalHD' AND TMP.FTSessionID = '$tSesSessionID' AND DT.FTXshDocNo = TMP.FTXthDocNo
        //             WHERE DT.FTXshDocNo = '$tDocNo'
        //             AND ( TMP.FTSrnCode IS NULL AND DT.FTSrnCode = '' )
        //                 AND PDT.FTPdtSetOrSN IN ('3','4') ";
        // $tSQL = "   SELECT 
        //                 A.FTPdtCode,
        //                 A.FTXsdPdtName,
        //                 A.FTXsdBarCode,
        //                 A.FNReq,
        //                 A.FNSerialCount
        //             FROM (
        //                 SELECT 
        //                         DT.FTPdtCode,
        //                         DT.FTXsdPdtName,
        //                         DT.FTXsdBarCode,
        //                         DT.FCXsdQty AS FNReq,
        //                         ISNULL(DTSN.FNCurrent,0) AS FNDTSNCur,
        //                         ISNULL(TMP.FNCurrent,0) AS FNTmpCur,
        //                         DTCount.FNSerialCount
        //                 FROM TPSTSalDT DT WITH(NOLOCK)
        //                 LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //                 LEFT JOIN (
        //                     SELECT
        //                         FTXshDocNo,FNXsdSeqNo,COUNT(FNXsdSeqNo) AS FNCurrent
        //                     FROM TPSTSalDTSN WITH(NOLOCK)
        //                     GROUP BY FTXshDocNo,FNXsdSeqNo
        //                 ) DTSN ON DT.FTXshDocNo = DTSN.FTXshDocNo AND DT.FNXsdSeqNo = DTSN.FNXsdSeqNo
        //                 LEFT JOIN (
        //                     SELECT 
        //                         FTXthDocNo,FTPdtCode,COUNT(FTPdtCode) AS FNCurrent
        //                     FROM TCNTDocDTTmp WITH(NOLOCK) 
        //                     WHERE FTXthDocKey = 'TPSTSalHD' 
        //                       AND FTSessionID = '$tSesSessionID'
        //                     GROUP BY FTXthDocNo,FTPdtCode
        //                 ) TMP ON DT.FTXshDocNo = TMP.FTXthDocNo AND DT.FTPdtCode = TMP.FTPdtCode
        //                 LEFT JOIN (
        //                     SELECT 
        //                         SUM(FCXsdQty) AS FNSerialCount,
        //                         FTXshDocNo 
        //                     FROM TPSTSalDT WITH(NOLOCK)
        //                     GROUP BY FTXshDocNo
        //                 ) DTCount ON DT.FTXshDocNo = DTCount.FTXshDocNo
        //                 WHERE DT.FTXshDocNo = '$tDocNo'
        //                         AND PDT.FTPdtSetOrSN IN ('3','4')
        //             ) A
        //             WHERE A.FNReq <> (A.FNDTSNCur + A.FNTmpCur) ";

        // $tSQL = "   SELECT 
        //                 A.FTPdtCode,
        //                 A.FTXsdPdtName,
        //                 A.FTXsdBarCode,
        //                 A.FNReq,
        //                 A.FNReq - (A.FNDTSNCur + A.FNTmpCur) AS FNReqCur
        //             FROM (
        //                 SELECT 
        //                         DT.FTPdtCode,
        //                         DT.FTXsdPdtName,
        //                         DT.FTXsdBarCode,
        //                         DT.FCXsdQty AS FNReq,
        //                         ISNULL(DTSN.FNCurrent,0) AS FNDTSNCur,
        //                         ISNULL(TMP.FNCurrent,0) AS FNTmpCur
        //                 FROM TPSTSalDT DT WITH(NOLOCK)
        //                 LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //                 LEFT JOIN (
        //                     SELECT
        //                         FTXshDocNo,FNXsdSeqNo,COUNT(FNXsdSeqNo) AS FNCurrent
        //                     FROM TPSTSalDTSN WITH(NOLOCK)
        //                     GROUP BY FTXshDocNo,FNXsdSeqNo
        //                 ) DTSN ON DT.FTXshDocNo = DTSN.FTXshDocNo AND DT.FNXsdSeqNo = DTSN.FNXsdSeqNo
        //                 LEFT JOIN (
        //                     SELECT 
        //                         FTXthDocNo,FTPdtCode,COUNT(FTPdtCode) AS FNCurrent
        //                     FROM TCNTDocDTTmp WITH(NOLOCK) 
        //                     WHERE FTXthDocKey = 'TPSTSalHD' 
        //                       AND FTSessionID = '$tSesSessionID'
        //                     GROUP BY FTXthDocNo,FTPdtCode
        //                 ) TMP ON DT.FTXshDocNo = TMP.FTXthDocNo AND DT.FTPdtCode = TMP.FTPdtCode
        //                 WHERE DT.FTXshDocNo = '$tDocNo'
        //                   AND PDT.FTPdtSetOrSN IN ('3','4')
        //             ) A
        //             WHERE A.FNReq <> (A.FNDTSNCur + A.FNTmpCur) ";
        $tSQL = "   SELECT
                        TMP.FNXtdSeqNo   AS FNXsdSeqNo,
                        TMP.FTPdtCode,
                        TMP.FTXtdPdtName AS FTXsdPdtName,
                        TMP.FTXtdBarCode AS FTXsdBarCode,
                        '' AS tOldPdtSN,
                        '' AS tPdtSN
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo = '$tDocNo'
                    AND TMP.FTXthDocKey = 'TPSTSalHD' 
                    AND TMP.FTSessionID = '$tSesSessionID'
                    AND TMP.FTXtdStaPrcStk IN ('3','4')
                    AND ISNULL(TMP.FTSrnCode,'') = '' ";

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

    // อัพเดทหมายเลขซีเรียล
    // Create By: Napat(Jame) 07/07/2021
    public function FSaMCSSEventUpdatePdtSNTmp($paData){

        $tOldPdtSN = "";
        if( !empty($paData['tOldPdtSN']) ){
            $tOldPdtSN = $paData['tOldPdtSN'];
        }

        // $tSQL = "   SELECT TMP.FTSrnCode FROM TCNTDocDTTmp TMP WITH(NOLOCK)
        //             WHERE TMP.FTXthDocNo    = '".$paData['tDocNo']."'
        //             AND TMP.FTPdtCode       = '".$paData['tPdtCode']."'
        //             AND TMP.FTSrnCode       = '".$tChkPdtSN."'
        //             AND TMP.FTSessionID     = '".$paData['FTSessionID']."'
        //             AND TMP.FTXthDocKey     = '".$paData['tDocKey']."' ";
        // $oQuery = $this->db->query($tSQL);
        // if( $oQuery->num_rows() > 0 ){
            // Update
            // $this->db->set('FTSrnCode',$paData['tSerialNo']);
            // $this->db->where('FTXthDocNo',$paData['tDocNo']);
            // $this->db->where('FTPdtCode',$paData['tPdtCode']);
            // $this->db->where('FTSrnCode','');
            // $this->db->where('FTSessionID',$paData['FTSessionID']);
            // $this->db->where('FTXthDocKey',$paData['tDocKey']);
            // $this->db->update('TCNTDocDTTmp');

            if( $tOldPdtSN == "" ){
                // หา Seq ของ S/N ที่ยังไม่ได้กรอก
                $tSQL = "   SELECT TOP 1 FTXtdPdtParent 
                            FROM TCNTDocDTTmp WITH(NOLOCK) 
                            WHERE FTXthDocNo = '".$paData['tDocNo']."'
                            /*AND FTPdtCode = '".$paData['tPdtCode']."'*/
                            AND FNXtdSeqNo = '".$paData['nSeqNo']."'
                            AND FTSessionID = '".$paData['FTSessionID']."'
                            AND FTXthDocKey = '".$paData['tDocKey']."'
                            AND ISNULL(FTSrnCode,'') = '' ";
                $oQuery = $this->db->query($tSQL);
                $tPdtParent = $oQuery->row_array()['FTXtdPdtParent'];

                $tSQL = "   UPDATE TCNTDocDTTmp 
                            SET FTSrnCode = '".$paData['tSerialNo']."' 
                            WHERE FTXthDocNo = '".$paData['tDocNo']."'
                            /*AND FTPdtCode = '".$paData['tPdtCode']."'*/
                            AND FNXtdSeqNo = '".$paData['nSeqNo']."'
                            AND FTSessionID = '".$paData['FTSessionID']."'
                            AND FTXthDocKey = '".$paData['tDocKey']."'
                            AND ISNULL(FTSrnCode,'') = ''
                            AND FTXtdPdtParent = '$tPdtParent'
                        ";
                $this->db->query($tSQL);
            }else{
                $tSQL = "   UPDATE TCNTDocDTTmp 
                            SET FTSrnCode = '".$paData['tSerialNo']."' 
                            WHERE FTXthDocNo = '".$paData['tDocNo']."'
                            /*AND FTPdtCode = '".$paData['tPdtCode']."'*/
                            AND FNXtdSeqNo = '".$paData['nSeqNo']."'
                            AND FTSessionID = '".$paData['FTSessionID']."'
                            AND FTXthDocKey = '".$paData['tDocKey']."'
                            AND ( FTXtdRmk = '".$tOldPdtSN."' OR FTSrnCode = '".$tOldPdtSN."' )
                        ";
                $this->db->query($tSQL);
            }
            if( $this->db->affected_rows() > 0 ){
                $aResult = array(
                    'tCode'            => '1',
                    'tDesc'            => 'Update Serial '.$paData['tPdtCode'].' To '.$paData['tSerialNo'].' Success.'
                );
            }else{
                $aResult = array(
                    'tCode'             => '800',
                    'tDesc'             => 'Update Serial '.$paData['tPdtCode'].' To '.$paData['tSerialNo'].' Fail.'
                );
            }
        // }else{
            // Insert
            // $tSQL = "   INSERT INTO TCNTDocDTTmp (FTBchCode,FTXthDocNo,FNXtdSeqNo,FTPdtCode,FTSrnCode,FTXtdRmk,FTXthDocKey,FTSessionID)
            //             SELECT 
            //                 DT.FTBchCode,
            //                 DT.FTXshDocNo,
            //                 DT.FNXsdSeqNo,
            //                 DT.FTPdtCode,
            //                 '".$paData['tSerialNo']."'      AS FTSrnCode,
            //                 '".$tOldPdtSN."'                AS FTOldPdtSN, 
            //                 '".$paData['tDocKey']."'        AS FTXthDocKey,
            //                 '".$paData['FTSessionID']."'    AS FTSessionID
            //             FROM TPSTSalDT DT WITH(NOLOCK)
            //             WHERE DT.FTXshDocNo = '".$paData['tDocNo']."'
            //             AND DT.FTPdtCode = '".$paData['tPdtCode']."' 
            //         ";
            // $this->db->query($tSQL);
            // if( $this->db->affected_rows() > 0 ){
            //     $aResult = array(
            //         'tCode'            => '1',
            //         'tDesc'            => 'Insert Product: '.$paData['tPdtCode'].' Serial: '.$paData['tSerialNo'].' Success.'
            //     );
            // }else{
            //     $aResult = array(
            //         'tCode'             => '800',
            //         'tDesc'             => 'Insert Product: '.$paData['tPdtCode'].' Serial: '.$paData['tSerialNo'].' Fail.'
            //     );
            // }
        // }
        return $aResult;
    }

    // เคลียร์ tmp
    // Create By: Napat(Jame) 07/07/2021
    public function FSaMCSSEventClearPdtSNTmp($paData){
        $this->db->delete('TCNTDocDTTmp', array(
            'FTXthDocKey' => $paData['tDocKey'],
            'FTSessionID' => $paData['FTSessionID'],
        ));
    }

    // ย้ายจาก Temp ไปตารางจริง
    // Create By: Napat(Jame) 07/07/2021
    public function FSaMCSSEventMoveTmpToDT($paData){
        $tDocNo         = $paData['tDocNo'];
        $tDocVatFull    = $paData['tDocVatFull'];
        $tSesSessionID  = $paData['FTSessionID'];
        $tDocKey        = $paData['tDocKey'];

        $this->db->where('FTXshDocNo',$tDocNo);
        $this->db->delete('TPSTSalDTSN');

        $tSQL = "   INSERT INTO TPSTSalDTSN (FTBchCode,FTXshDocNo,FNXsdSeqNo,FTPdtSerial,FTXsdStaRet)
                    SELECT 
                        TMP.FTBchCode,
                        TMP.FTXthDocNo,
                        TMP.FNXtdSeqNo,
                        TMP.FTSrnCode AS FTPdtSerial,
                        '1' AS FTXsdStaRet 
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK) 
                    WHERE TMP.FTXthDocNo  = '$tDocNo'
                      AND TMP.FTXthDocKey = '$tDocKey' 
                      AND TMP.FTSessionID = '$tSesSessionID' 
                      AND TMP.FTSrnCode IS NOT NULL
                      AND FTXtdStaPrcStk IN ('3','4')
                ";
        $this->db->query($tSQL);
        if ( $this->db->affected_rows() > 0 ) {
            if( !empty($tDocVatFull) ){

                $this->db->where('FTXshDocNo',$tDocVatFull);
                $this->db->delete('TPSTTaxDTSN');

                $tSQL = "   INSERT INTO TPSTTaxDTSN (FTBchCode,FTXshDocNo,FNXsdSeqNo,FTPdtSerial,FTXsdStaRet)
                            SELECT 
                                TMP.FTBchCode,
                                '$tDocVatFull' AS FTXthDocNo,
                                TMP.FNXtdSeqNo,
                                TMP.FTSrnCode AS FTPdtSerial,
                                '1' AS FTXsdStaRet 
                            FROM TCNTDocDTTmp TMP WITH(NOLOCK) 
                            WHERE TMP.FTXthDocNo  = '$tDocNo'
                            AND TMP.FTXthDocKey = '$tDocKey' 
                            AND TMP.FTSessionID = '$tSesSessionID' 
                            AND TMP.FTSrnCode IS NOT NULL
                            AND FTXtdStaPrcStk IN ('3','4')
                        ";
                $this->db->query($tSQL);
                if ( $this->db->affected_rows() > 0 ) {
                    $aResult = array(
                        'tCode'            => '1',
                        'tDesc'            => 'Insert TPSTSalDTSN and TPSTTaxDTSN Success'
                    );
                }else{
                    $aResult = array(
                        'tCode'            => '800',
                        'tDesc'            => 'Insert TPSTSalDTSN and TPSTTaxDTSN Fail'
                    );
                }
            }else{
                $aResult = array(
                    'tCode'            => '1',
                    'tDesc'            => 'Insert TPSTSalDTSN Success'
                );
            }
        }else{
            $aResult = array(
                'tCode'            => '800',
                'tDesc'            => 'Insert TPSTSalDTSN Fail'
            );
        }
        return $aResult;
        
    }

    // ตรวจสอบ Config TSysFormatAPI_L ฟิวส์ FTApiFmtCode = '00006'
    // Create By: Napat(Jame) 12/07/2021
    // public function FSaMCSSEventChkFormatAPI(){
    //     $tSQL = " SELECT FTApiFmtCode FROM TSysFormatAPI_L WITH(NOLOCK) WHERE FTApiFmtCode = '00006' ";
    //     $oQuery = $this->db->query($tSQL);
    //     if ( $oQuery->num_rows() > 0 ){
    //         $aResult = array(
    //             'tCode'            => '1',
    //             'tDesc'            => 'FOUND FORMAT API'
    //         );
    //     } else {
    //         $aResult = array(
    //             'tCode'             => '800',
    //             'tDesc'             => 'NOT FOUND FORMAT API'
    //         );
    //     }
    //     return $aResult;
    // }

    // ตรวจสอบก่อนว่า บิลขายมี FullTax ไหม (เลขที่ใบกำกับภาษีอย่างเต็ม)
    // Create By: Napat(Jame) 12/07/2021
    public function FSaMCSSEventChkFullTax($paData){
        $tSQL = "   SELECT TAX.FTXshDocNo
                    FROM TPSTSalHD        HD WITH(NOLOCK) 
                    INNER JOIN TPSTTaxHD TAX WITH(NOLOCK) ON HD.FTXshDocVatFull = TAX.FTXshDocNo AND HD.FTBchCode = TAX.FTBchCode
                    WHERE HD.FTXshDocNo = '".$paData['tDocNo']."'
                      AND HD.FTXshDocVatFull IS NOT NULL 
                      AND ISNULL(HD.FTXshETaxStatus,'3') = '3'
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'tDocVatFull'      => $oQuery->row_array()['FTXshDocNo'],
                'tCode'            => '1',
                'tDesc'            => 'found full tax'
            );
        } else {
            $aResult = array(
                'tCode'             => '800',
                'tDesc'             => 'not found full tax'
            );
        }
        return $aResult;
    }

    // ดึงข้อมูล MQ Config Interface
    // Create By: Napat(Jame) 12/07/2021
    // public function FSaMCSSEventGetConfigMQ(){
    //     $tSQL = "   SELECT *
    //                 FROM TLKMConfig WITH(NOLOCK)
    //                 WHERE TLKMConfig.FTCfgKey = 'Noti'
    //                 AND TLKMConfig.FTCfgSeq = '4' ";
    //     $oQuery = $this->db->query($tSQL);
    //     if ( $oQuery->num_rows() > 0 ){
    //         $aResult = array(
    //             'aItems'           => $oQuery->result_array(),
    //             'tCode'            => '1',
    //             'tDesc'            => 'found full tax'
    //         );
    //     } else {
    //         $aResult = array(
    //             'aItems'            => array(),
    //             'tCode'             => '800',
    //             'tDesc'             => 'not found full tax'
    //         );
    //     }
    //     return $aResult;
    // }

    // ปรับสถานะเอกสารใบขาย
    // 0	Online (DC จัดส่ง)
    // 1	Online(รับที่ Store)
    // 3	Offline(Store จัดส่ง)
    // 4    Fast Delivery
    // Create By: Napat(Jame) 12/07/2021
    public function FSaMCSSEventApproved($paData,$ptStaETax){
        if( $ptStaETax != '' ){
            $this->db->set('FTXshStaDelMQ','2');
            if( $paData['tChnMapSeqNo'] == '1' || $paData['tChnMapSeqNo'] == '4' ){ // เคส Online(รับที่ Store) + Fast Delivery
                $this->db->set('FTXshStaApv', '1');
                $this->db->set('FTXshApvCode', $paData['tSesUserCode']);
            }
        }else{
            $this->db->set('FTXshStaPrcDoc', '5');
            $this->db->set('FTXshStaApv', '1');
        }

        $this->db->set('FTLastUpdBy', $paData['tSesUserCode']);
        $this->db->set('FDLastUpdOn', $paData['dLastUpdOn']);
        
        $this->db->where('FTXshDocNo', $paData['tDocNo']);
        $this->db->update('TPSTSalHD');
        // echo $this->db->last_query();
    }

    // ตรวจสอบการอนุญาติกดปุ่ม
    // Create By: Napat(Jame) 16/07/2021
    public function FSaMCSSEventControlButton($paData){
        $tDocNo         = $paData['tDocNo'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "   SELECT 
                        ISNULL(SUM(A.FNStaAlwSave),0) AS FNStaAlwSave,
                        ISNULL(SUM(A.FNStaAlwApv),0) AS FNStaAlwApv
                    FROM (
                        SELECT 
                            CASE 
                                WHEN TMP.FTXtdRmk <> TMP.FTSrnCode OR (TMP.FTXtdRmk IS NULL AND TMP.FTSrnCode IS NOT NULL ) THEN 1
                                ELSE 0
                            END AS FNStaAlwSave,
                            CASE 
                                WHEN ISNULL(TMP.FTXtdRmk,'') <> ISNULL(TMP.FTSrnCode,'') THEN 1
                                ELSE 0
                            END AS FNStaAlwApv
                        FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTXthDocNo = '$tDocNo' 
                        AND TMP.FTXthDocKey = 'TPSTSalHD' 
                        AND TMP.FTSessionID = '$tSesSessionID'
                        AND TMP.FTXtdStaPrcStk IN ('3','4')
                    ) A  
                ";
        // $tSQL = "   SELECT 
        //                 ISNULL(SUM(A.FNStaAlwSave),0) AS FNStaAlwSave,
        //                 ISNULL(SUM(A.FNStaAlwApv),0) AS FNStaAlwApv
        //             FROM (
        //                 SELECT 
        //                         CASE 
        //                             WHEN TMP.FTSrnCode IS NULL THEN 0
        //                             ELSE 1
        //                         END AS FNStaAlwSave,
        //                         CASE 
        //                             WHEN ISNULL(DTSN.FTPdtSerial,'') = '' THEN 1
        //                             ELSE 0
        //                         END AS FNStaAlwApv
        //                 FROM TPSTSalDT DT WITH(NOLOCK)
        //                 LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //                 LEFT JOIN TPSTSalDTSN DTSN WITH(NOLOCK) ON DT.FTXshDocNo = DTSN.FTXshDocNo AND DT.FNXsdSeqNo = DTSN.FNXsdSeqNo
        //                 LEFT JOIN TCNTDocDTTmp TMP WITH(NOLOCK) ON DT.FTPdtCode = TMP.FTPdtCode AND TMP.FTXthDocKey = 'TPSTSalHD' AND TMP.FTSessionID = '$tSesSessionID' AND DT.FTXshDocNo = TMP.FTXthDocNo
        //                 WHERE 1=1 
        //                     AND DT.FTXshDocNo = '$tDocNo'
        //                     AND PDT.FTPdtSetOrSN IN ('3','4')
        //             ) A 
        //         ";
        // $tSQL = "   SELECT 
        //                 SUM(A.FNStaAlwSave) AS FNStaAlwSave,
        //                 SUM(A.FNStaAlwApv) AS FNStaAlwApv 
        //             FROM (
        //                 SELECT 
        //                         CASE 
        //                             WHEN TMP.FTSrnCode IS NULL THEN 0
        //                             ELSE 1
        //                         END AS FNStaAlwSave,
        //                         CASE 
        //                             WHEN ISNULL(DT.FTSrnCode,'') = '' THEN 1
        //                             ELSE 0
        //                         END AS FNStaAlwApv
        //                 FROM TPSTSalDT DT WITH(NOLOCK)
        //                 LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
        //                 LEFT JOIN TCNTDocDTTmp TMP WITH(NOLOCK) ON DT.FTPdtCode = TMP.FTPdtCode AND TMP.FTXthDocKey = 'TPSTSalHD' AND TMP.FTSessionID = '$tSesSessionID' AND DT.FTXshDocNo = TMP.FTXthDocNo
        //                 WHERE 1=1 
        //                     AND DT.FTXshDocNo = '$tDocNo'
        //                     AND PDT.FTPdtSetOrSN IN ('3','4')
        //             ) A
        //         ";
        $oQuery = $this->db->query($tSQL);        
        return $oQuery->row_array();
    }

    public function FSaMCSSEventGetDocDT($paData){
        $tDocNo         = $paData['tDocNo'];
        $nLngID         = $paData['nLngID'];
        $tSessionID     = $this->session->userdata('tSesSessionID');

        $tSQL = "   SELECT 
                        DT.FTBchCode,
                        DT.FTXshDocNo AS FTXthDocNo,
                        DT.FNXsdSeqNo AS FNXtdSeqNo,
                        'TPSTSalHD' AS FTXthDocKey,
                        DT.FTPdtCode,
                        PDTL.FTPdtName AS FTXtdPdtName,
                        DT.FTXsdBarCode AS FTXtdBarCode,
                        DT.FTPunCode,
                        PUNL.FTPunName,
                        DT.FCXsdQty AS FCXtdQty,
                        CONVERT(INT,DT.FCXsdQty) AS FTXtdPdtParent,
                        DT.FCXsdSetPrice AS FCXtdSetPrice,
                        '' AS FTXtdDisChgTxt,
                        DT.FCXsdNet AS FCXtdNet,
                        '$tSessionID' AS FTSessionID,
                        PDT.FTPdtSetOrSN AS FTXtdStaPrcStk
                    FROM TPSTSalDT                DT WITH(NOLOCK) 
                    INNER JOIN TCNMPdt 	         PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                    INNER JOIN TCNMPdt_L 	    PDTL WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
                    INNER JOIN TCNMPdtUnit_L 	PUNL WITH(NOLOCK) ON DT.FTPunCode = PUNL.FTPunCode AND PUNL.FNLngID = $nLngID
                    WHERE DT.FTXshDocNo = '$tDocNo' 
                    ORDER BY DT.FNXsdSeqNo ASC
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

    public function FSaMCSSEventInsertToTmp($aDataDTTmp){
        // $this->db->insert('TCNTDocDTTmp',$aDataDTTmp);
        $this->db->insert_batch('TCNTDocDTTmp', $aDataDTTmp);
    }

    public function FSaMCSSEventGetDataDocDTTmp($paData){
        $tDocNo         = $paData['tDocNo'];
        $tSearch        = $paData['tSearch'];
        // $nLngID         = $paData['nLngID'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "   SELECT DISTINCT
                        TMP.FNXtdSeqNo AS FNXsdSeqNo,
                        TMP.FTPdtCode,
                        TMP.FTXtdPdtName AS FTPdtName,
                        TMP.FTXtdBarCode AS FTXsdBarCode,
                        TMP.FTPunCode,
                        TMP.FTPunName,
                        TMP.FCXtdQty AS FCXsdQty,
                        TMP.FCXtdSetPrice AS FCXsdSetPrice,
                        TMP.FTXtdDisChgTxt AS FTXsdDisChgTxt,
                        TMP.FCXtdNet AS FCXsdNet,
                        TMP.FTXtdStaPrcStk
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo = '$tDocNo'
                        AND TMP.FTXthDocKey = 'TPSTSalHD'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";

        if( !empty($tSearch) && isset($tSearch) ){
            $tSQL .= " AND ( TMP.FTPdtCode LIKE '%$tSearch%'
                          OR TMP.FTXtdPdtName LIKE '%$tSearch%' 
                          OR TMP.FTXtdBarCode LIKE '%$tSearch%'
                          OR TMP.FTPunCode LIKE '%$tSearch%' 
                          OR TMP.FTPunName LIKE '%$tSearch%' 
                            )";
        }

        // $tSQL = "   SELECT 
        //                 MAX(ALLDT.FNPartition) OVER (PARTITION BY ALLDT.FNXsdSeqNo) AS FNMaxSeqNo,
        //                 ALLDT.*
        //             FROM (
        //                 SELECT 
        //                     ROW_NUMBER() OVER(PARTITION BY TMP.FNXtdSeqNo ORDER BY TMP.FNXtdSeqNo ASC) AS FNPartition,
        //                     TMP.FNXtdSeqNo AS FNXsdSeqNo,
        //                     TMP.FTPdtCode,
        //                     TMP.FTXtdPdtName AS FTPdtName,
        //                     TMP.FTXtdBarCode AS FTXsdBarCode,
        //                     TMP.FTPunCode,
        //                     TMP.FTPunName,
        //                     TMP.FCXtdQty AS FCXsdQty,
        //                     TMP.FCXtdSetPrice AS FCXsdSetPrice,
        //                     TMP.FTXtdDisChgTxt AS FTXsdDisChgTxt,
        //                     TMP.FCXtdNet AS FCXsdNet,
        //                     TMP.FTSrnCode AS FTPdtSerial,
        //                     TMP.FTXtdRmk
        //                 FROM TCNTDocDTTmp TMP WITH(NOLOCK)
        //                 WHERE TMP.FTXthDocNo = '$tDocNo'
        //                   AND TMP.FTXthDocKey = 'TPSTSalHD'
        //                   AND TMP.FTSessionID = '$tSesSessionID'
        //             ) ALLDT ";

        // if( !empty($tSearch) && isset($tSearch) ){
        //     $tSQL .= " AND ( TMP.FTPdtCode LIKE '%$tSearch%'
        //                   OR TMP.FTPdtName LIKE '%$tSearch%' 
        //                   OR TMP.FTXsdBarCode LIKE '%$tSearch%'
        //                   OR TMP.FTPunCode LIKE '%$tSearch%' 
        //                   OR TMP.FTPunName LIKE '%$tSearch%' 
        //                     )";
        // }

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

    public function FSaMCSSEventUpdPdtSNTmp($paData,$paWhereTemp){
        $tDocNo         = $paData['tDocNo'];
        $tDocKey        = $paWhereTemp['tDocKey'];
        $tSessionID     = $paWhereTemp['FTSessionID'];

        $tSQL = "   UPDATE TMP
                    SET 
                        TMP.FTSrnCode = DTSN.FTPdtSerial,
                        TMP.FTXtdRmk  = DTSN.FTPdtSerial, /* เก็บ Old S/N */
                        TMP.FTXtdDocNoRef = DTSN.FTPdtBatchID
                    FROM TCNTDocDTTmp TMP
                    INNER JOIN (
                        SELECT 
                            ROW_NUMBER() OVER( PARTITION BY FNXsdSeqNo ORDER BY FNXsdSeqNo ASC ) AS FTPdtParent,
                            FTXshDocNo,
                            FNXsdSeqNo,
                            FTPdtSerial,
                            FTPdtBatchID
                        FROM TPSTSalDTSN WITH(NOLOCK) 
                        WHERE FTXshDocNo = '$tDocNo'
                    ) DTSN ON DTSN.FNXsdSeqNo = TMP.FNXtdSeqNo AND CONVERT(varchar, DTSN.FTPdtParent) = CONVERT(varchar, TMP.FTXtdPdtParent)
                    WHERE TMP.FTXthDocNo = '$tDocNo'
                      AND TMP.FTXthDocKey = '$tDocKey'
                      AND TMP.FTSessionID = '$tSessionID'
                ";
        $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
    }

    public function FSaMCSSGetDataSNByPdt($paData){
        $tDocNo         = $paData['tTaxDocNo'];
        $nSeqNo         = $paData['nSeqNo'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL = "   SELECT 
                        TMP.FNXtdSeqNo AS FNXsdSeqNo,
                        TMP.FTPdtCode,
                        TMP.FTXtdPdtName AS FTPdtName,
                        TMP.FTXtdBarCode AS FTXsdBarCode,
                        TMP.FTPunCode,
                        TMP.FTPunName,
                        TMP.FCXtdQty AS FCXsdQty,
                        TMP.FCXtdSetPrice AS FCXsdSetPrice,
                        TMP.FTXtdDisChgTxt AS FTXsdDisChgTxt,
                        TMP.FCXtdNet AS FCXsdNet,
                        TMP.FTSrnCode AS FTPdtSerial,
                        TMP.FTXtdRmk,
                        TMP.FTXtdDocNoRef AS FTPdtBatchID
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo = '$tDocNo'
                        AND TMP.FTXthDocKey = 'TPSTSalHD'
                        AND TMP.FTSessionID = '$tSesSessionID'
                        AND TMP.FNXtdSeqNo = '$nSeqNo'
                        AND ISNULL(TMP.FTSrnCode,'') != ''
                    ORDER BY TMP.FTSrnCode ASC
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

    // เช็ค S/N ซ้ำใน temp / dtsn
    public function FSaMCSSEventChkDupPdtSN($paData){
        $tSQL = "   SELECT DTSN.FTPdtSerial AS FTPdtSerial
                    FROM TPSTSalDTSN DTSN WITH(NOLOCK)
                    WHERE 1=1
                      AND DTSN.FTXshDocNo = '".$paData['tDocNo']."'
                      AND DTSN.FNXsdSeqNo = ".$paData['nSeqNo']."
                      AND DTSN.FTPdtSerial = '".$paData['tSerialNo']."'
                    
                    UNION
                    
                    SELECT TMP.FTSrnCode AS FTPdtSerial
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK) 
                    WHERE 1=1
                      AND TMP.FTXthDocNo = '".$paData['tDocNo']."'
                      AND TMP.FNXtdSeqNo = ".$paData['nSeqNo']."
                      AND TMP.FTSrnCode = '".$paData['tSerialNo']."' 
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'tCode'            => '800',
                'tDesc'            => 'หมายเลขซีเรียลนี้ซ้ำ กรุณาตรวจสอบอีกครั้ง'
            );
        } else {
            $aResult = array(
                'tCode'             => '1',
                'tDesc'             => 'หมายเลขซีเรียลไม่ซ้ำสามารถบันทึกข้อมูลได้'
            );
        }
        return $aResult;
    }

    // ตรวจสอบสถานะบิลขายก่อนว่าเป็น ลูกค้าแจ้งยกเลิก หรือไม่ ?
    public function FStMCSSEventChkStaPrcDoc($paData){
        $tSQL = "   SELECT HD.FTXshStaPrcDoc
                    FROM TPSTSalHD HD WITH(NOLOCK)
                    WHERE HD.FTXshDocNo = '".$paData['tDocNo']."' 
                ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->row_array()['FTXshStaPrcDoc'];
    }

    public function FSaMCSSEventGetDocDTDis($paData){
        $tDocNo         = $paData['tDocNo'];
        $nLngID         = $paData['nLngID'];
        $tSQL = "   SELECT 
                        FTXshDocNo,FNXsdSeqNo,
                        (CASE FTXddDisChgType
                            WHEN '1' THEN ISNULL(FCXddValue,0)*-1
                            WHEN '2' THEN ISNULL(FCXddValue,0)*-1
                            WHEN '3' THEN ISNULL(FCXddValue,0)
                            WHEN '4' THEN ISNULL(FCXddValue,0)
                            END
                        ) AS FCXddValue
                    FROM TPSTSalDTDis  WITH (NoLock) 
                    WHERE FTXshDocNo = '$tDocNo'
                    AND FNXddStaDis = 1
                    ORDER BY FDXddDateIns ASC ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'           => $oQuery->result_array(),
                'tCode'            => '1',
                'tDesc'            => 'found'
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

    // Create By : Napat(Jame) 12/01/2022
    // ดึง Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSaMCSSGetConfigGenDocPack(){
        $tSQL = "   SELECT 
                        FTSysSeq,
                        CASE WHEN ISNULL(FTSysStaUsrValue,'') = '' THEN FTSysStaDefValue ELSE FTSysStaUsrValue END AS FTValue
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE FTSysCode = 'bCN_CondSplitDoc' 
                      AND FTSysApp = 'CN' 
                      AND FTSysKey = 'TCNTPdtPickHD' ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'found config',
            );
        }else{
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'config not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 13/01/2022
    // บันทึก Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSaMCSSSaveConfigGenDocPack($ptCondWhereIn){
        $this->db->trans_begin();
        if( !empty($ptCondWhereIn) ){
            // อัพเดท 1 ตัวที่เลือกบนหน้าจอ
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '1'
                        WHERE FTSysCode = 'bCN_CondSplitDoc' 
                          AND FTSysApp  = 'CN' 
                          AND FTSysKey  = 'TCNTPdtPickHD' 
                          AND FTSysSeq  IN ($ptCondWhereIn) ";
            $this->db->query($tSQL);

            // อัพเดท 2 ตัวที่ไม่เลือกบนหน้าจอ
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '2'
                        WHERE FTSysCode = 'bCN_CondSplitDoc' 
                          AND FTSysApp  = 'CN' 
                          AND FTSysKey  = 'TCNTPdtPickHD' 
                          AND FTSysSeq  NOT IN ($ptCondWhereIn) ";
            $this->db->query($tSQL);
        }else{
            // กรณีไม่เลือกบนหน้าจอ ทุกรายการ ให้อัพเดท 2 ทั้งหมด
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '2'
                        WHERE FTSysCode = 'bCN_CondSplitDoc' 
                          AND FTSysApp  = 'CN' 
                          AND FTSysKey  = 'TCNTPdtPickHD' ";
            $this->db->query($tSQL);
        }

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => $this->db->error()['message']
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Update Config Success'
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 16/01/2022
    // หลังอนุมัติใบขาย Move S/N จากใบจัดสินค้า to ใบขาย
    public function FSxMCSSEventMoveDTSNFromPackToSale($paData){
        $tSQL = "   INSERT INTO TPSTSalDTSN (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTPdtSerial, FTXsdStaRet, FTPdtBatchID)
                    SELECT 
                        SN.FTBchCode, 
                        '".$paData['tDocNo']."' AS FTXshDocNo, 
                        SN.FNXtdSeqNo, 
                        SN.FTPdtSerial, 
                        SN.FTXtdStaRet, 
                        SN.FTPdtBatchID
                    FROM TCNTPdtPickHDDocRef REF WITH(NOLOCK)
                    INNER JOIN TCNTPdtPickDTSN SN WITH(NOLOCK) ON REF.FTXthDocNo = SN.FTXthDocNo
                    WHERE REF.FTXthRefDocNo = '".$paData['tDocNo']."'
                      AND REF.FTXthRefType  = '1'
                      AND REF.FTXthRefKey   = 'SALE' ";
        $this->db->query($tSQL);
    }

    // Create By : Napat(Jame) 01/03/2022
    public function FSaMCSSEventGetDataDisPromotions($paData){
        $nLngID = $paData['nLngID'];
        $tDocNo = $paData['tDocNo'];

        // $tSQL   = " SELECT
        //                 PMTL.FTPmhName,
        //                 DIS.FCXddValue,
        //                 SUMV.FCXddSumValue
        //             FROM TPSTSalDTDis DIS WITH(NOLOCK)
        //             LEFT JOIN TCNTPdtPmtHD_L PMTL WITH(NOLOCK) ON DIS.FTXddRefCode = PMTL.FTPmhDocNo AND PMTL.FNLngID = $nLngID
        //             INNER JOIN (
        //                 SELECT FTXshDocNo,FNXddStaDis,SUM(FCXddValue) AS FCXddSumValue FROM TPSTSalDTDis WITH(NOLOCK) GROUP BY FTXshDocNo,FNXddStaDis
        //             ) SUMV ON SUMV.FTXshDocNo = DIS.FTXshDocNo AND SUMV.FNXddStaDis = DIS.FNXddStaDis
        //             WHERE DIS.FTXshDocNo = '$tDocNo' 
        //               AND DIS.FNXddStaDis = 0
        //             ORDER BY DIS.FNXsdSeqNo ASC ";

        $tSQL = "   SELECT DISTINCT
                        PMTL.FTPmhName AS FTPmhName,
                        DIS.FCXpdDis   AS FCXddValue,
                        (SELECT SUM(FCXpdDisAvg) FROM TPSTSalPD WHERE FTXshDocNo = DIS.FTXshDocNo) AS FCXddSumValue
                    FROM TPSTSalPD DIS WITH(NOLOCK)
                    LEFT JOIN TCNTPdtPmtHD_L PMTL WITH(NOLOCK) ON DIS.FTPmhDocNo = PMTL.FTPmhDocNo AND PMTL.FNLngID = $nLngID
                    WHERE DIS.FTXshDocNo = '$tDocNo' ";
                    
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'           => $oQuery->result_array(),
                'tCode'            => '1',
                'tDesc'            => 'found'
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

    // Create By : Napat(Jame) 01/03/2022
    public function FSaMCSSEventGetDataPoints($paData){
        $nLngID         = $paData['nLngID'];
        $tDocNo         = $paData['tDocNo'];
        // $tCstCode       = $paData['tCstCode'];
        // $tDocType       = $paData['tDocType'];
        // $tRefInt        = $paData['tRefInt'];
        // $tDocDate       = $paData['tDocDate'];

        $tSQL           = " SELECT FNXshDocType,FDXshDocDate,FTCstCode,FTXshRefInt FROM TPSTSalHD WITH(NOLOCK) WHERE FTXshDocNo = '$tDocNo' ";
        $oQuery         = $this->db->query($tSQL);
        $aResult        = $oQuery->row_array();

        $tCstCode       = $aResult['FTCstCode'];
        $tDocType       = $aResult['FNXshDocType'];
        $tRefInt        = $aResult['FTXshRefInt'];
        $tDocDate       = $aResult['FDXshDocDate'];
        
        $tWhereTxnSale  = "";

        if( $tDocType == '1' ){
            $tWhereTxnSale = " AND MEM.FTTxnRefDoc = '$tDocNo' ";
        }else{
            $tWhereTxnSale  = " AND MEM.FTTxnRefInt = '$tRefInt' ";
            $tWhereTxnSale .= " AND CONVERT(DATETIME,MEM.FDTxnRefDate,121) = CONVERT(DATETIME,'$tDocDate',121) ";
        }

        /* ได้รับแต้ม */
        $tSQL1   = "    SELECT 
                            ISNULL(MEM.FCTxnPntB4Bill,0) AS FCTxnPntB4Bill,/*แต้มก่อนหน้า*/
                            ISNULL(MEM.FCTxnPntBillQty,0) AS FCTxnPntBillQty, /*แต้มที่ได้รับ*/
                            (ISNULL(MEM.FCTxnPntB4Bill,0) + ISNULL(MEM.FCTxnPntBillQty,0)) AS FCTxnPntBal /*แต้มคงเหลือ*/
                        FROM TCNTMemTxnSale MEM WITH(NOLOCK)
                        WHERE ISNULL(MEM.FTTxnRefSpl,'') = '' 
                          AND MEM.FTMemCode = '$tCstCode' ";
        $tSQL1  .= $tWhereTxnSale;
        $oQuery1 = $this->db->query($tSQL1);

        /* ใช้แต้ม */
        $tSQL2   = "    SELECT 
                            ISNULL(RED.FCRedPntB4Bill,0) AS FCRedPntB4Bill,   /*แต้มก่อนหน้า*/
                            (ISNULL(RED.FCRedPntBillQty,0) * -1) AS FCRedPntBillQty, /*แต้มที่ใช้*/
                            (ISNULL(RED.FCRedPntB4Bill,0) - ISNULL(RED.FCRedPntBillQty,0)) AS FCRedPntBal /*แต้มคงเหลือ*/
                        FROM TCNTMemTxnRedeem RED WITH(NOLOCK)
                        WHERE RED.FTRedRefDoc = '$tDocNo' 
                          AND RED.FTMemCode = '$tCstCode' ";
        $oQuery2 = $this->db->query($tSQL2);

        /* ได้รับแต้ม ผู้จำหน่าย */
        $tSQL3   = "    SELECT 
                            SPL.FTSplName,
                            ISNULL(MEM.FCTxnPntBillQty,0) AS FCTxnPntBillQty, /*แต้มที่ได้รับ*/
                            CONVERT(VARCHAR(10),FDTxnPntStart,121) AS FDTxnPntStart,
                            CONVERT(VARCHAR(10),FDTxnPntExpired,121) AS FDTxnPntExpired
                        FROM TCNTMemTxnSale MEM WITH(NOLOCK)
                        INNER JOIN TCNMSpl_L SPL WITH(NOLOCK) ON MEM.FTTxnRefSpl = SPL.FTSplCode AND SPL.FNLngID = $nLngID
                        WHERE ISNULL(MEM.FTTxnRefSpl,'') <> '' ";
        $tSQL3  .= $tWhereTxnSale;
        $oQuery3 = $this->db->query($tSQL3);

        $aResult = array(
            'aCstEarnPoints'    => ( $oQuery1->num_rows() > 0 ? $oQuery1->result_array() : array() ),
            'aCstBurnPoints'    => ( $oQuery2->num_rows() > 0 ? $oQuery2->result_array() : array() ),
            'aSplEarnPoints'    => ( $oQuery3->num_rows() > 0 ? $oQuery3->result_array() : array() )
        );

        return $aResult;
    }

    // Create By : Napat (Jame) 22/08/2022
    public function FSaMCSSAlwChnShw(){
        // $nLngID = $this->session->userdata("tLangEdit");
        $tSQL = "   SELECT 
                        MAP.FNMapSeqNo,
                        MAP.FTMapName
                    FROM TLKMMapping MAP WITH(NOLOCK)
                    WHERE MAP.FTMapCode = 'tChnDelivery'
                      AND MAP.FNMapSeqNo <> 2
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'           => $oQuery->result_array(),
                'tCode'            => '1',
                'tDesc'            => 'found'
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

    // Create By : Napat (Jame) 03/10/2022
    public function FSaMCSSChkGenPick($paData){
        
        $tDocNo = $paData['tDocNo'];

        $tSQL = "   SELECT FTXthDocNo FROM TCNTPdtPickHDDocRef WITH(NOLOCK) 
                    WHERE FTXthRefDocNo = '".$tDocNo."' 
                    AND FTXthRefType = '1' AND FTXthRefKey = 'SALE' ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'tCode'            => '1',
                'tDesc'            => 'พบเอกสารใบจัดสินค้า'
            );
        } else {
            $aResult = array(
                'tCode'             => '800',
                'tDesc'             => 'ไม่พบเอกสารใบจัดสินค้า'
            );
        }
        return $aResult;
    }

}