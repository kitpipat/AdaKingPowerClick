<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mTaxinvoice extends CI_Model{

    //ข้อมูลใบกำกับภาษีอย่างย่อ แบบเลือก
    public function FSaMTAXGetListABB($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                TaxHD.FTXshDocNo,
                                TaxHD.FNXshDocType,
                                TaxHD.FTBchCode,
                                BCHL.FTBchName,
                                TaxHD.FDXshDocDate,
                                TaxHD.FTPosCode,
                                /*HDCst.FTXshCstName,
                                HDCst.FTXshCstName AS FTAddName,*/
                                AddHD.FTAddName,
                                ISNULL(USRL.FTUsrName,TaxHD.FTCreateBy) AS FTCreateBy,
                                TaxHD.FTXshETaxStatus,
                                TaxHD.FDCreateOn,
                                TaxHD.FTXshStaDoc,
                                SalHD.FTXshRefExt
                            FROM TPSTTaxHD         TaxHD WITH(NOLOCK)
                            INNER JOIN TPSTSalHD   SalHD WITH(NOLOCK) ON TaxHD.FTXshRefExt = SalHD.FTXshDocNo AND TaxHD.FTBchCode = SalHD.FTBchCode
                            INNER JOIN TPSTTaxHDAddress AddHD WITH(NOLOCK) ON TaxHD.FTXshDocNo = AddHD.FTXshDocNo AND TaxHD.FTBchCode = AddHD.FTBchCode
                            /*LEFT JOIN TPSTTaxHDCst HDCst WITH(NOLOCK) ON TaxHD.FTXshDocNo = HDCst.FTXshDocNo AND TaxHD.FTBchCode = HDCst.FTBchCode*/
                            LEFT JOIN TCNMBranch_L  BCHL WITH(NOLOCK) ON TaxHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                            LEFT JOIN TCNMUser_L    USRL WITH(NOLOCK) ON TaxHD.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                            WHERE ISNULL(TaxHD.FTXshDocVatFull,'') <> ''
                      "; 

        $tSesUsrBchCodeMulti    = $this->session->userdata("tSesUsrBchCodeMulti");
        $tSesUsrLevel           = $this->session->userdata("tSesUsrLevel");
        if( $tSesUsrLevel != "HQ" ){
            $tSQL .= " AND TaxHD.FTBchCode IN ($tSesUsrBchCodeMulti) ";
        }

        $tTXIBchCode = $paData['aDataSearch']['tTXIBchCode'];
        if( !empty($tTXIBchCode) ){
            $tSQL .= " AND TaxHD.FTBchCode = '$tTXIBchCode' ";
        }

        $tTXIDocType = $paData['aDataSearch']['tTXIDocType'];
        if( !empty($tTXIDocType) ){
            $tSQL .= " AND TaxHD.FNXshDocType = '$tTXIDocType' ";
        }

        $tTXIDocNo = $paData['aDataSearch']['tTXIDocNo'];
        if( !empty($tTXIDocNo) ){
            $tSQL .= " AND ( TaxHD.FTXshDocNo = '$tTXIDocNo' OR SalHD.FTXshRefExt = '$tTXIDocNo' ) ";
        }

        $tTAXStaDoc = $paData['aDataSearch']['tTAXStaDoc'];
        if( !empty($tTAXStaDoc) ){
            $tTAXStaDoc = str_replace(",","','",$tTAXStaDoc);
            $tSQL .= " AND TaxHD.FTXshStaDoc IN ('$tTAXStaDoc') ";
        }

        $tTXIFromDocDate = (empty($paData['aDataSearch']['tTXIFromDocDate']) ? $paData['aDataSearch']['tTXIToDocDate'] : $paData['aDataSearch']['tTXIFromDocDate']);
        $tTXIToDocDate   = (empty($paData['aDataSearch']['tTXIToDocDate']) ? $paData['aDataSearch']['tTXIFromDocDate'] : $paData['aDataSearch']['tTXIToDocDate']);
        if( !empty($tTXIFromDocDate) || !empty($tTXIToDocDate) ){
            $tSQL .= " AND (
                        CONVERT(VARCHAR(10),TaxHD.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tTXIFromDocDate',121) AND CONVERT(VARCHAR(10),'$tTXIToDocDate',121)
                        OR
                        CONVERT(VARCHAR(10),TaxHD.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tTXIToDocDate',121) AND CONVERT(VARCHAR(10),'$tTXIFromDocDate',121)
                       ) ";
        }

        // if($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP'){
        //     $tBCH = $this->session->userdata("tSesUsrBchCom");
        //     $tSQL .= " AND  TaxHD.FTBchCode = '$tBCH' ";
        // }

        // if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
        //     $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
        //     $tSQL .= "
        //         AND TaxHD.FTBchCode IN ($tBchCode)
        //     ";
        // }

        //ค้นหาแบบพิเศษ
        // @$tSearchList = $paData['tSearchAll'];
        // $tSQL .= "  AND (
        //                 (TaxHD.FTXshDocNo LIKE '%$tSearchList%')
        //                 OR (TaxHD.FDXshDocDate LIKE '%$tSearchList%')
        //                 OR (TaxHD.FTPosCode LIKE '%$tSearchList%')
        //                 OR (HDCst.FTXshCstName LIKE '%$tSearchList%')
        //                 OR (CONVERT(CHAR(10),TaxHD.FDXshDocDate,120) = '$tSearchList')
        //             )";


        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();

        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTAXGetListABBPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //จำนวนใบกำกับภาษีอย่างย่อ แบบเลือก
    public function FSnMTAXGetListABBPageAll($paData){

        $nLngID = $paData['FNLngID'];
        $tSQL   = " SELECT COUNT (TaxHD.FTXshDocNo) AS counts
                    FROM TPSTTaxHD         TaxHD WITH(NOLOCK)
                    INNER JOIN TPSTSalHD   SalHD WITH(NOLOCK) ON TaxHD.FTXshRefExt = SalHD.FTXshDocNo AND TaxHD.FTBchCode = SalHD.FTBchCode
                    LEFT JOIN TPSTTaxHDCst HDCst WITH(NOLOCK) ON TaxHD.FTXshDocno = HDCst.FTXshDocno AND TaxHD.FTBchCode = HDCst.FTBchCode
                    WHERE 1=1 AND ISNULL(TaxHD.FTXshDocVatFull,'') <> ''  ";

        $tSesUsrBchCodeMulti    = $this->session->userdata("tSesUsrBchCodeMulti");
        $tSesUsrLevel           = $this->session->userdata("tSesUsrLevel");
        if( $tSesUsrLevel != "HQ" ){
            $tSQL .= " AND TaxHD.FTBchCode IN ($tSesUsrBchCodeMulti) ";
        }

        $tTXIBchCode = $paData['aDataSearch']['tTXIBchCode'];
        if( !empty($tTXIBchCode) ){
            $tSQL .= " AND TaxHD.FTBchCode = '$tTXIBchCode' ";
        }

        $tTXIDocType = $paData['aDataSearch']['tTXIDocType'];
        if( !empty($tTXIDocType) ){
            $tSQL .= " AND TaxHD.FNXshDocType = '$tTXIDocType' ";
        }

        $tTXIDocNo = $paData['aDataSearch']['tTXIDocNo'];
        if( !empty($tTXIDocNo) ){
            $tSQL .= " AND ( TaxHD.FTXshDocNo = '$tTXIDocNo' OR SalHD.FTXshRefExt = '$tTXIDocNo' ) ";
        }

        $tTAXStaDoc = $paData['aDataSearch']['tTAXStaDoc'];
        if( !empty($tTAXStaDoc) ){
            $tTAXStaDoc = str_replace(",","','",$tTAXStaDoc);
            $tSQL .= " AND TaxHD.FTXshStaDoc IN ('$tTAXStaDoc') ";
        }

        $tTXIFromDocDate = (empty($paData['aDataSearch']['tTXIFromDocDate']) ? $paData['aDataSearch']['tTXIToDocDate'] : $paData['aDataSearch']['tTXIFromDocDate']);
        $tTXIToDocDate   = (empty($paData['aDataSearch']['tTXIToDocDate']) ? $paData['aDataSearch']['tTXIFromDocDate'] : $paData['aDataSearch']['tTXIToDocDate']);
        if( !empty($tTXIFromDocDate) || !empty($tTXIToDocDate) ){
            $tSQL .= " AND (
                        CONVERT(VARCHAR(10),TaxHD.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tTXIFromDocDate',121) AND CONVERT(VARCHAR(10),'$tTXIToDocDate',121)
                        OR
                        CONVERT(VARCHAR(10),TaxHD.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tTXIToDocDate',121) AND CONVERT(VARCHAR(10),'$tTXIFromDocDate',121)
                    ) ";
        }

        // if($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP'){
        //     $tBCH = $this->session->userdata("tSesUsrBchCom");
        //     $tSQL .= " AND  TaxHD.FTBchCode = '$tBCH' ";
        // }
        // if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
        //     $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
        //     $tSQL .= "
        //         AND TaxHD.FTBchCode IN ($tBchCode)
        //     ";
        // }
        //ค้นหาแบบพิเศษ
        // @$tSearchList = $paData['tSearchAll'];
        // $tSQL .= "  AND (
        //                 (TaxHD.FTXshDocNo LIKE '%$tSearchList%')
        //                 OR (TaxHD.FDXshDocDate LIKE '%$tSearchList%')
        //                 OR (TaxHD.FTPosCode LIKE '%$tSearchList%')
        //                 OR (HDCst.FTXshCstName LIKE '%$tSearchList%')
        //                 OR (CONVERT(CHAR(10),TaxHD.FDXshDocDate,120) = '$tSearchList')
        //             )";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //ข้อมูลใบกำกับภาษีอย่างย่อ แบบเลือก
    public function FSaMTAXListABB($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL1      = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FTXshDocNo DESC) AS FNRowID,* FROM ( ";
        $tSQL2      = "     SELECT DISTINCT
                                BCHL.FTBchName,
                                SALHD.FTXshDocNo,
                                SALHD.FNXshDocType,
                                SALHD.FDXshDocDate,
                                SALHD.FTXshCshOrCrd,
                                SALHD.FTWahCode,
                                SALHD.FTPosCode,
                                USRL.FTUsrName,
                                SALHD.FCXshGrand,
                                SALHD.FTCstCode,
                                CST.FTCstName,
                                SALHD.FTXshRefExt
                            FROM TPSTSalHD         SALHD WITH (NOLOCK)
                            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON SALHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                            LEFT JOIN TCNMUser_L    USRL WITH (NOLOCK) ON SALHD.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                            LEFT JOIN TCNMCst_L      CST WITH (NOLOCK) ON SALHD.FTCstCode = CST.FTCstCode AND CST.FNLngID = $nLngID
                            WHERE ISNULL(SALHD.FTXshDocVatFull,'') = ''  
                              AND ( (SALHD.FTXshStaETax = '1' AND SALHD.FTXshETaxStatus = '1') OR ISNULL(SALHD.FTXshStaETax,'2') = '2' )
                      ";

        //ค้นหาตามสาขา
        @$tBCH       = $paData['tBCH'];
        if($tBCH != '' || $tBCH != null){
            $tSQL2 .= "  AND SALHD.FTBchCode = '$tBCH' ";
        }

        //ค้นหาแบบพิเศษ
        @$tFilter       = $paData['tFilter'];
        $tSearchList   = trim($paData['tSearchABB']);
        if( $tSearchList != "" ){
            switch ($tFilter) {
                case "2": //ทั้งหมด
                    $tSQL2 .= "  AND (
                                    (SALHD.FTXshDocNo LIKE '%$tSearchList%')
                                    OR (SALHD.FTXshRefExt LIKE '%$tSearchList%')
                                    OR (BCHL.FTBchCode LIKE '%$tSearchList%')
                                    OR (USRL.FTUsrName LIKE '%$tSearchList%')
                                    OR (SALHD.FTPosCode LIKE '%$tSearchList%')
                                    OR (CONVERT(CHAR(10),SALHD.FDXshDocDate,120) = '$tSearchList')
                                )";
                    break;
                case "3": //เลขที่
                    $tSQL2 .= "  AND SALHD.FTXshDocNo = '$tSearchList' ";
                    break;
                default:
            }
        }

        $tTextDateABB   = trim($paData['tTextDateABB']);
        $tSQL2 .= "  AND ( (CONVERT(CHAR(10),SALHD.FDXshDocDate,120) = '$tTextDateABB') ) ";

        $tSQL3 = " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";

        $tMainQuery = $tSQL1.$tSQL2.$tSQL3;
        $oQuery = $this->db->query($tMainQuery);
        // echo "<pre>"; echo $this->db->last_query();
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            // $aFoundRow  = $this->FSnMTAXGetPageAll($paData);
            // $nFoundRow  = $aFoundRow[0]->counts;

            $tPageQuery = $tSQL2;
            $oPageQuery = $this->db->query($tPageQuery);
            $nFoundRow  = $oPageQuery->num_rows();
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
                'tSQL'          => $tMainQuery
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
                'tSQL'          => $tMainQuery
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //จำนวนใบกำกับภาษีอย่างย่อ แบบเลือก
    public function FSnMTAXGetPageAll($paData){

        $nLngID = $paData['FNLngID'];
        $tSQL   = " SELECT COUNT (SALHD.FTXshDocNo) AS counts
                    FROM TPSTSalHD SALHD WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON SALHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L    USRL WITH (NOLOCK) ON SALHD.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    WHERE 1=1 AND ISNULL(FTXshDocVatFull,'') = ''  ";

        //ค้นหาตามสาขา
        @$tBCH       = $paData['tBCH'];
        if($tBCH != '' || $tBCH != null){
            $tSQL .= "  AND (( SALHD.FTBchCode = '$tBCH')) ";
        }

        //ค้นหาแบบพิเศษ
        @$tFilter       = $paData['tFilter'];
        @$tSearchList   = trim($paData['tSearchABB']);
        switch ($tFilter) {
            case "2": //ทั้งหมด
                $tSQL .= "  AND (
                                (SALHD.FTXshDocNo LIKE '%$tSearchList%')
                                OR (BCHL.FTBchCode LIKE '%$tSearchList%')
                                OR (USRL.FTUsrName LIKE '%$tSearchList%')
                                OR (SALHD.FTPosCode LIKE '%$tSearchList%')
                                OR (CONVERT(CHAR(10),SALHD.FDXshDocDate,120) = '$tSearchList')
                            )";
                break;
            case "3": //เลขที่
                $tSQL .= "  AND (SALHD.FTXshDocNo = '$tSearchList')";
                break;
            default:
        }

        $tTextDateABB   = trim($paData['tTextDateABB']);
        $tSQL .= "  AND ( (CONVERT(CHAR(10),SALHD.FDXshDocDate,120) = '$tTextDateABB') )";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //ค้นหารหัสใบกำกับภาษีอย่างย่อ แบบคีย์
    public function FSaMTAXCheckABBNumber($ptDocumentnumber,$tBCH){
        $nLngID = $this->session->userdata("tLangEdit");
        $tSQL   = " SELECT 
                        ISNULL(SALHD.FTCstCode,'') AS FTCstCode, 
                        ISNULL(CSL.FTCstName,'') AS FTCstName 
                    FROM TPSTSalHD SALHD WITH(NOLOCK)
                    LEFT JOIN TCNMCst_L CSL WITH(NOLOCK) ON SALHD.FTCstCode = CSL.FTCstCode AND CSL.FNLngID = $nLngID
                    WHERE SALHD.FTXshDocNo = '$ptDocumentnumber' 
                      AND ISNULL(SALHD.FTXshDocVatFull,'') = '' ";

        //ค้นหาตามสาขา
        if( isset($tBCH) && !empty($tBCH) ){
            $tSQL .= "  AND (SALHD.FTBchCode = '$tBCH') ";
        }

        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'aItems'       => $oQuery->row_array(),
                'tCode'        => '1',
                'tDesc'        => 'found data'
            );
        }else{
            $aResult = array(
                'tCode'        => '800',
                'tDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
        // if ($oQuery->num_rows() > 0) {
        //     return $oQuery->row_array();
        // }else{
        //     return false;
        // }
    }

    //ข้อมูลการขาย DT
    public function FSaMTAXGetDT($paData){
        $aRowLen            = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $tBrowseBchCode    = $paData['tBrowseBchCode'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXshDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                    DTDis.DISPMT , SALDT.FTBchCode , SALDT.FTXshDocNo , SALDT.FNXsdSeqNo , FTPdtCode , FTXsdPdtName ,
                                    FTPunCode , FTPunName , FCXsdFactor , FTXsdBarCode , FTSrnCode ,
                                    FTXsdVatType , FTVatCode , FTPplCode , FCXsdVatRate , FTXsdSaleType ,
                                    FCXsdSalePrice , FCXsdQty , FCXsdQtyAll , FCXsdSetPrice , FCXsdAmtB4DisChg ,
                                    FTXsdDisChgTxt , FCXsdDis , FCXsdChg , FCXsdNet , FCXsdNetAfHD ,
                                    FCXsdVat , FCXsdVatable , FCXsdWhtAmt , FTXsdWhtCode , FCXsdWhtRate ,
                                    FCXsdCostIn , FCXsdCostEx , FTXsdStaPdt , FCXsdQtyLef , FCXsdQtyRfn ,
                                    FTXsdStaPrcStk , FTXsdStaAlwDis , FNXsdPdtLevel , FTXsdPdtParent , FCXsdQtySet ,
                                    FTPdtStaSet , FTXsdRmk , FDLastUpdOn , FTLastUpdBy , FDCreateOn , FTCreateBy
                            FROM TPSTSalDT SALDT WITH (NOLOCK)
                            LEFT JOIN ( SELECT SUM(FCXddValue) as DISPMT , FNXsdSeqNo , FTBchCode FROM TPSTSalDTDis
                                        WHERE (FNXddStaDis = 2 OR FNXddStaDis = 0) AND FTXddDisChgType IN ('1','2') AND ISNULL(FTXddRefCode,'') <> ''
                                        AND TPSTSalDTDis.FTXshDocNo = '$tDocumentNumber'
                                        AND TPSTSalDTDis.FTBchCode = '$tBrowseBchCode'
                                        GROUP BY FNXsdSeqNo , FTBchCode
                                    ) DTDis ON DTDis.FNXsdSeqNo = SALDT.FNXsdSeqNo AND DTDis.FTBchCode = SALDT.FTBchCode
                            WHERE 1=1 AND SALDT.FTXshDocNo = '$tDocumentNumber' AND  SALDT.FTBchCode = '$tBrowseBchCode' ";

        //ค้นหาแบบพิเศษ
        @$tSearchPDT   = $paData['tSearchPDT'];
        $tSQL .= "  AND ((SALDT.FTXshDocNo LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPdtCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdPdtName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPunName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdBarCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdQty LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdSetPrice LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdNetAfHD LIKE '%$tSearchPDT%')
                        OR (SALDT.FTBchCode LIKE '%$tSearchPDT%')
                    )";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTAXGetDTPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']);
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาจำนวนการขาย DT
    public function FSnMTAXGetDTPageAll($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $tBrowseBchCode    = $paData['tBrowseBchCode'];
        $tSQL   = " SELECT COUNT (SALDT.FTXshDocNo) AS counts FROM TPSTSalDT SALDT WITH (NOLOCK) WHERE 1=1 AND FTXshDocNo = '$tDocumentNumber' AND FTBchCode ='$tBrowseBchCode' ";

        //ค้นหาแบบพิเศษ
        @$tSearchPDT   = $paData['tSearchPDT'];
        $tSQL   .= "  AND ((SALDT.FTXshDocNo LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPdtCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdPdtName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPunName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdBarCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdQty LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdSetPrice LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdNetAfHD LIKE '%$tSearchPDT%')
                        OR (SALDT.FTBchCode LIKE '%$tSearchPDT%')
                    )";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //ข้อมูลการขาย HD
    public function FSaMTAXGetHD($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $tBrowseBchCode    = $paData['tBrowseBchCode'];
        $tSQL               = "SELECT
                                SALHD.FTBchCode, SALHD.FTXshDocNo, SALHD.FTShpCode, SALHD.FNXshDocType, SALHD.FDXshDocDate, SALHD.FTXshCshOrCrd, 
                                SALHD.FTXshVATInOrEx, SALHD.FTDptCode, SALHD.FTWahCode, SALHD.FTPosCode, SALHD.FTShfCode, 
                                SALHD.FNSdtSeqNo, SALHD.FTUsrCode, SALHD.FTSpnCode, SALHD.FTXshApvCode, SALHD.FTCstCode, 
                                ISNULL(SALHD.FTXshDocVatFull, '') AS FTXshDocVatFull, SALHD.FTXshRefExt, SALHD.FDXshRefExtDate, 
                                SALHD.FTXshRefInt, SALHD.FDXshRefIntDate, SALHD.FTXshRefAE, SALHD.FNXshDocPrint, SALHD.FTRteCode, 
                                SALHD.FCXshRteFac, SALHD.FCXshTotal, SALHD.FCXshTotalNV, SALHD.FCXshTotalNoDis, SALHD.FCXshTotalB4DisChgV, 
                                SALHD.FCXshTotalB4DisChgNV, SALHD.FTXshDisChgTxt, SALHD.FCXshDis, SALHD.FCXshChg, SALHD.FCXshTotalAfDisChgV,
                                SALHD.FCXshTotalAfDisChgNV,SALHD.FCXshRefAEAmt, SALHD.FCXshAmtV, SALHD.FCXshAmtNV, SALHD.FCXshVat, 
                                SALHD.FCXshVatable, SALHD.FTXshWpCode, SALHD.FCXshWpTax, SALHD.FCXshGrand, SALHD.FCXshRnd, SALHD.FTXshGndText, 
                                SALHD.FCXshPaid, SALHD.FCXshLeft, SALHD.FTXshRmk, SALHD.FTXshStaRefund, SALHD.FTXshStaDoc, SALHD.FTXshStaApv, 
                                SALHD.FTXshStaPrcStk, SALHD.FTXshStaPaid, SALHD.FNXshStaDocAct, SALHD.FNXshStaRef, SALHD.FDLastUpdOn, 
                                SALHD.FTLastUpdBy, SALHD.FDCreateOn, SALHD.FTCreateBy, HCST.FTXshCstEmail, HCST.FTXshCstTel, SALHD.FTXshStaETax
                            FROM TPSTSalHD SALHD WITH(NOLOCK)
                            LEFT JOIN TPSTSalHDCst  HCST WITH(NOLOCK) ON SALHD.FTXshDocNo = HCST.FTXshDocNo AND SALHD.FTBchCode = HCST.FTBchCode
                            WHERE 1=1 
                            AND SALHD.FTXshDocNo = '$tDocumentNumber'
                            AND SALHD.FTBchCode = '$tBrowseBchCode'
                            --AND ISNULL(SALHD.FTXshDocVatFull,'') = '' 
                            ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาที่อยู่ ที่ตาราง TCNMTaxAddress_L
    public function FSaMTAXFindAddress($ptCuscode){
        $nLngID = $this->session->userdata("tLangEdit");
        // $tSQL   = " SELECT ADDL.* , CSTL.FTCstName , CST.FTCstTaxNo FROM TCNMTaxAddress_L ADDL WITH (NOLOCK)
        //             LEFT JOIN TCNMCst_L CSTL ON CSTL.FTCstCode = ADDL.FTCstCode
        //             LEFT JOIN TCNMCst CST  ON CST.FTCstCode = ADDL.FTCstCode
        //             WHERE 1=1 AND ADDL.FTCstCode = '$ptCuscode'";
        $tSQL = "   SELECT 
                        ADDL.*, 
                        CSTL.FTCstName, 
                        CST.FTCstTaxNo,
                        PVN_L.FTPvnCode,
                        PVN_L.FTPvnName,
                        DST_L.FTDstCode,
                        DST_L.FTDstName,
                        SUD_L.FTSudCode,
                        SUD_L.FTSudName
                    FROM TCNMTaxAddress_L ADDL WITH(NOLOCK)
                    LEFT JOIN TCNMCst				CST WITH(NOLOCK) ON CST.FTCstCode = ADDL.FTCstCode
                    LEFT JOIN TCNMCst_L			   CSTL WITH(NOLOCK) ON CSTL.FTCstCode = ADDL.FTCstCode AND CSTL.FNLngID = $nLngID
                    LEFT JOIN TCNMProvince_L      PVN_L WITH(NOLOCK) ON ADDL.FTAddV1PvnCode = PVN_L.FTPvnCode AND PVN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMDistrict_L      DST_L WITH(NOLOCK) ON ADDL.FTAddV1DstCode = DST_L.FTDstCode AND DST_L.FNLngID = $nLngID
                    LEFT JOIN TCNMSubDistrict_L   SUD_L WITH(NOLOCK) ON ADDL.FTAddV1SubDist = SUD_L.FTSudCode AND SUD_L.FNLngID = $nLngID
                    WHERE 1 = 1
                    AND ADDL.FTCstCode = '$ptCuscode' ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //หาที่อยู่ ที่ตาราง TCNMCstAddress_L
    public function FSaMTAXFindAddressCst($ptCutomerCode,$pnSeq){
        $tSQL   = " SELECT ADDL.*  , CSTL.FTCstName , CST.FTCstTaxNo AS FTAddTaxNo FROM TCNMCstAddress_L ADDL WITH (NOLOCK)
                    LEFT JOIN TCNMCst_L CSTL ON CSTL.FTCstCode = ADDL.FTCstCode
                    LEFT JOIN TCNMCst CST  ON CST.FTCstCode = ADDL.FTCstCode
                    WHERE 1=1 AND ADDL.FTCstCode = '$ptCutomerCode' ";

        // if(isset($pnSeq)){
        //     $tSQL   .= "AND ADDL.FNAddSeqNo = '$pnSeq' ";
        // }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //ค้นหาเลขที่ประจำตัวผู้เสียภาษี แบบคีย์
    public function FSaMTAXCheckTaxno($ptTaxno , $pnSeq){
        $nLngID = $this->session->userdata("tLangEdit");
        $tSQL   = " SELECT 
                        ADDL.*,
                        PVN_L.FTPvnCode,
                        PVN_L.FTPvnName,
                        DST_L.FTDstCode,
                        DST_L.FTDstName,
                        SUD_L.FTSudCode,
                        SUD_L.FTSudName
                    FROM  TCNMTaxAddress_L ADDL WITH (NOLOCK) 
                    /*LEFT JOIN TCNMCst_L ON TCNMCst_L.FTCstCode = Tax.FTCstCode*/
                    LEFT JOIN TCNMProvince_L      PVN_L WITH(NOLOCK) ON ADDL.FTAddV1PvnCode = PVN_L.FTPvnCode AND PVN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMDistrict_L      DST_L WITH(NOLOCK) ON ADDL.FTAddV1DstCode = DST_L.FTDstCode AND DST_L.FNLngID = $nLngID
                    LEFT JOIN TCNMSubDistrict_L   SUD_L WITH(NOLOCK) ON ADDL.FTAddV1SubDist = SUD_L.FTSudCode AND SUD_L.FNLngID = $nLngID
                    WHERE 1=1 AND ADDL.FTAddTaxNo = '$ptTaxno' 
                  ";
        // if(isset($pnSeq)){
        //     $tSQL   .= "AND FNAddSeqNo = '$pnSeq' ";
        // }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //ค้นหาเลขที่ประจำตัวผู้เสียภาษี แบบเลือก
    public function FSaMTAXListTaxno($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTAddTaxNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                FTAddTaxNo , FNLngID /*, FNAddSeqNo*/ , FTCstCode ,
                                FTAddName , FTAddRmk , FTAddCountry , FTAreCode ,
                                FTZneCode , FTAddVersion , FTAddV1No , FTAddV1Soi ,
                                FTAddV1Village , FTAddV1Road , FTAddV1SubDist , FTAddV1DstCode ,
                                FTAddV1PvnCode , FTAddV1PostCode , FTAddV2Desc1 , FTAddV2Desc2 ,
                                FTAddWebsite , FTAddLongitude , FTAddLatitude , FTAddStaBusiness ,
                                FTAddStaHQ , FTAddStaBchCode , FTAddTel , FTAddFax
                            FROM TCNMTaxAddress_L ADDL WITH (NOLOCK)
                            WHERE 1=1 AND FNLngID = '$nLngID' ";

        //ค้นหาแบบพิเศษ
        @$tSearchList  = trim($paData['tSearchTaxno']);
        if($tSearchList != '' || $tSearchList != null){
            $tSQL .= "  AND (
                (ADDL.FTAddTaxNo LIKE '%$tSearchList%')
                OR (ADDL.FTCstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddName LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1No LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1Soi LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1Village LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1Road LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1SubDist LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1DstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PvnCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PostCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc1 LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc2 LIKE '%$tSearchList%')
                OR (ADDL.FTAddStaBusiness LIKE '%$tSearchList%')
                OR (ADDL.FTAddTel LIKE '%$tSearchList%')
                OR (ADDL.FTAddFax LIKE '%$tSearchList%')
            )";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTAXGetTaxnoPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //จำนวนเลขที่ประจำตัวผู้เสียภาษี แบบเลือก
    public function FSnMTAXGetTaxnoPageAll($paData){
        $nLngID     = $paData['FNLngID'];
        $tSQL       = " SELECT COUNT (ADDL.FTAddTaxNo) AS counts FROM TCNMTaxAddress_L ADDL WITH (NOLOCK) WHERE 1=1 AND FNLngID = '$nLngID' ";

        //ค้นหาแบบพิเศษ
        @$tSearchList  = trim($paData['tSearchTaxno']);
        if($tSearchList != '' || $tSearchList != null){
            $tSQL .= "  AND (
                (ADDL.FTAddTaxNo LIKE '%$tSearchList%')
                OR (ADDL.FTCstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddName LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1No LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1Soi LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1Village LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1Road LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1SubDist LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1DstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PvnCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PostCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc1 LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc2 LIKE '%$tSearchList%')
                OR (ADDL.FTAddStaBusiness LIKE '%$tSearchList%')
                OR (ADDL.FTAddTel LIKE '%$tSearchList%')
                OR (ADDL.FTAddFax LIKE '%$tSearchList%')
            )";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //ค้นหาที่อยู่ของลูกค้า
    public function FSaMTAXListCustomerAddress($paData){
        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID         = $paData['FNLngID'];
        $tCustomerCode  = $paData['tCustomerCode'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTCstCode DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                ADDL.FTCstCode , FTAddGrpType , FNAddSeqNo ,
                                FTAddRefNo , FTAddName , FTAddRmk ,  FTAddCountry , FTAreCode ,
                                FTZneCode , FTAddVersion , FTAddV1No ,
                                FTAddV1Soi , FTAddV1Village , FTAddV1Road , FTAddV1SubDist ,
                                FTAddV1DstCode , FTAddV1PvnCode , FTAddV1PostCode , FTAddV2Desc1 ,
                                FTAddV2Desc2 , FTAddWebsite , FTAddLongitude , FTAddLatitude , CST.FTCstName
                            FROM TCNMCstAddress_L ADDL WITH (NOLOCK)
                            LEFT JOIN TCNMCst_L CST ON ADDL.FTCstCode = CST.FTCstCode
                            WHERE 1=1 AND ADDL.FNLngID = '$nLngID' AND CST.FNLngID = '$nLngID' ";

        if($tCustomerCode != ''){
            $tSQL       .= "AND ADDL.FTCstCode = '$tCustomerCode' ";
        }

        //ค้นหาแบบพิเศษ
        @$tSearchList  = trim($paData['tSearchAddress']);
        if($tSearchList != '' || $tSearchList != null){
            $tSQL .= "  AND (
                (CST.FTCstName LIKE '%$tSearchList%')
                OR (ADDL.FTCstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddGrpType LIKE '%$tSearchList%')
                OR (ADDL.FTAddRefNo LIKE '%$tSearchList%')
                OR (ADDL.FTAddName LIKE '%$tSearchList%')
                OR (ADDL.FTAddRmk LIKE '%$tSearchList%')
                OR (ADDL.FTAddCountry LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1SubDist LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1DstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PvnCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PostCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc1 LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc2 LIKE '%$tSearchList%')
            )";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTAXGetCustomerAddressPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //จำนวนที่อยู่ของลูกค้า
    public function FSnMTAXGetCustomerAddressPageAll($paData){
        $nLngID         = $paData['FNLngID'];
        $tCustomerCode  = $paData['tCustomerCode'];
        $tSQL       = " SELECT COUNT (ADDL.FTCstCode) AS counts FROM TCNMCstAddress_L ADDL
                        LEFT JOIN TCNMCst_L CST ON ADDL.FTCstCode = CST.FTCstCode
                        WHERE 1=1 AND ADDL.FNLngID = '$nLngID' AND CST.FNLngID = '$nLngID' ";

        if($tCustomerCode != ''){
            $tSQL       .= "AND ADDL.FTCstCode = '$tCustomerCode' ";
        }

        //ค้นหาแบบพิเศษ
        @$tSearchList  = trim($paData['tSearchAddress']);
        if($tSearchList != '' || $tSearchList != null){
            $tSQL .= "  AND (
                (CST.FTCstName LIKE '%$tSearchList%')
                OR (ADDL.FTCstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddGrpType LIKE '%$tSearchList%')
                OR (ADDL.FTAddRefNo LIKE '%$tSearchList%')
                OR (ADDL.FTAddName LIKE '%$tSearchList%')
                OR (ADDL.FTAddRmk LIKE '%$tSearchList%')
                OR (ADDL.FTAddCountry LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1SubDist LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1DstCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PvnCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV1PostCode LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc1 LIKE '%$tSearchList%')
                OR (ADDL.FTAddV2Desc2 LIKE '%$tSearchList%')
            )";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //////////////////////////////////// MOVE DATA ////////////////////////////////

    // TPSTSalHD -> TPSTTaxHD
    public function  FSaMTAXMoveSalHD_TaxHD($aPackData){
        $tABB               = $aPackData['tDocABB'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tStaETax           = $aPackData['tStaETax'];

        //เพิ่มเติม
        $dDateCurrent       = date('Y-m-d H:i:s');
        $tNameTask          = $this->session->userdata('tSesUsername');
        $dDocDateTime       = $aPackData['dDocDate'] .' '. $aPackData['dDocTime'];
        $tRemark            = $aPackData['tRemark'];
        $tReason            = $aPackData['tReason'];

        $tSQL       = " INSERT INTO TPSTTaxHD (
                            FTBchCode,FTXshDocNo,FTShpCode,FNXshDocType,FDXshDocDate,
                            FTXshCshOrCrd,FTXshVATInOrEx,FTDptCode,FTWahCode,
                            FTPosCode,FTShfCode,FNSdtSeqNo,FTUsrCode,FTSpnCode,
                            FTXshApvCode,FTCstCode,FTXshDocVatFull,FTXshRefExt,
                            FDXshRefExtDate,FTXshRefInt,FDXshRefIntDate,FTXshRefAE,
                            FNXshDocPrint,FTRteCode,FCXshRteFac,FCXshTotal,FCXshTotalNV,FCXshTotalNoDis,
                            FCXshTotalB4DisChgV,FCXshTotalB4DisChgNV,FTXshDisChgTxt,FCXshDis,
                            FCXshChg,FCXshTotalAfDisChgV,FCXshTotalAfDisChgNV,FCXshRefAEAmt,
                            FCXshAmtV,FCXshAmtNV,FCXshVat,FCXshVatable,FTXshWpCode,FCXshWpTax,
                            FCXshGrand,FCXshRnd,FTXshGndText,FCXshPaid,FCXshLeft,FTXshRmk,
                            FTXshStaRefund,FTXshStaDoc,FTXshStaApv,FTXshStaPrcStk,
                            FTXshStaPaid,FNXshStaDocAct,FNXshStaRef,FDLastUpdOn,
                            FTLastUpdBy,FDCreateOn,FTCreateBy,FTXshStaETax,FTRsnCode
                        ) SELECT
                            FTBchCode,'$tTaxNumberFull',FTShpCode,
                            CASE
                                WHEN FNXshDocType = 9 THEN 5
                                WHEN FNXshDocType = 1 THEN 4
                                ELSE 0
                            END AS FNXshDocType,
                            '$dDocDateTime',
                            FTXshCshOrCrd,FTXshVATInOrEx,FTDptCode,FTWahCode,
                            FTPosCode,FTShfCode,FNSdtSeqNo,FTUsrCode,FTSpnCode,
                            '$tNameTask',FTCstCode,FTXshDocVatFull,
                            '$tABB' AS FTXshRefExt,
                            FDXshRefExtDate,FTXshRefInt,FDXshRefIntDate,FTXshRefAE,
                            FNXshDocPrint,FTRteCode,FCXshRteFac,FCXshTotal,FCXshTotalNV,FCXshTotalNoDis,
                            FCXshTotalB4DisChgV,FCXshTotalB4DisChgNV,FTXshDisChgTxt,FCXshDis,
                            FCXshChg,FCXshTotalAfDisChgV,FCXshTotalAfDisChgNV,FCXshRefAEAmt,
                            FCXshAmtV,FCXshAmtNV,FCXshVat,FCXshVatable,FTXshWpCode,FCXshWpTax,
                            FCXshGrand,FCXshRnd,FTXshGndText,FCXshPaid,FCXshLeft,'$tRemark',
                            FTXshStaRefund,FTXshStaDoc,1 AS FTXshStaApv,FTXshStaPrcStk,
                            FTXshStaPaid,FNXshStaDocAct,FNXshStaRef,FDLastUpdOn,
                            FTLastUpdBy,'$dDateCurrent','$tNameTask','$tStaETax','$tReason'
                        FROM TPSTSalHD WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
        $this->db->query($tSQL);
    }

    // TPSTSalHDDis -> TPSTTaxHDDis
    public function FSaMTAXMoveSalHDDis_TaxHDDis($aPackData){
        $tABB               = $aPackData['tDocABB'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];

        $tSQL       = " INSERT INTO TPSTTaxHDDis (
                            FTBchCode,FTXshDocNo,FDXhdDateIns,FTXhdDisChgTxt,FTXhdDisChgType,FCXhdTotalAfDisChg,FCXhdDisChg,FCXhdAmt,FTXhdRefCode
                        ) SELECT
                            FTBchCode,'$tTaxNumberFull',FDXhdDateIns,FTXhdDisChgTxt,FTXhdDisChgType,FCXhdTotalAfDisChg,FCXhdDisChg,FCXhdAmt,FTXhdRefCode
                        FROM TPSTSalHDDis WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
        $this->db->query($tSQL);
    }

    // TPSTSalDT -> TPSTTaxDT
    public function FSaMTAXMoveSalDT_TaxDT($aPackData){
        $tABB               = $aPackData['tDocABB'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];

        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tSQL       = " INSERT INTO TPSTTaxDT (
                            FTBchCode,FTXshDocNo,FNXsdSeqNo,FTPdtCode,FTXsdPdtName,
                            FTPunCode,FTPunName,FTPplCode,FCXsdFactor,FTXsdBarCode,
                            FTSrnCode,FTXsdVatType,FTVatCode,FCXsdVatRate,FTXsdSaleType,
                            FCXsdSalePrice,FCXsdQty,FCXsdQtyAll,FCXsdSetPrice,FCXsdAmtB4DisChg,FTXsdDisChgTxt,
                            FCXsdDis,FCXsdChg,FCXsdNet,FCXsdNetAfHD,
                            FCXsdVat,FCXsdVatable,FCXsdWhtAmt,FTXsdWhtCode,
                            FCXsdWhtRate,FCXsdCostIn,FCXsdCostEx,FTXsdStaPdt,
                            FCXsdQtyLef,FCXsdQtyRfn,FTXsdStaPrcStk,FTXsdStaAlwDis,
                            FNXsdPdtLevel,FTXsdPdtParent,FCXsdQtySet,FTPdtStaSet,
                            FTXsdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                        ) SELECT
                            FTBchCode,'$tTaxNumberFull',FNXsdSeqNo,FTPdtCode,FTXsdPdtName,
                            FTPunCode,FTPunName,FTPplCode,FCXsdFactor,FTXsdBarCode,
                            FTSrnCode,FTXsdVatType,FTVatCode,FCXsdVatRate,FTXsdSaleType,
                            FCXsdSalePrice,FCXsdQty,FCXsdQtyAll,FCXsdSetPrice,FCXsdAmtB4DisChg,FTXsdDisChgTxt,
                            FCXsdDis,FCXsdChg,FCXsdNet,FCXsdNetAfHD,
                            FCXsdVat,FCXsdVatable,FCXsdWhtAmt,FTXsdWhtCode,
                            FCXsdWhtRate,FCXsdCostIn,FCXsdCostEx,FTXsdStaPdt,
                            FCXsdQtyLef,FCXsdQtyRfn,FTXsdStaPrcStk,FTXsdStaAlwDis,
                            FNXsdPdtLevel,FTXsdPdtParent,FCXsdQtySet,FTPdtStaSet,
                            FTXsdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                        FROM TPSTSalDT WITH(NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
        $this->db->query($tSQL);
    }

    // TPSTSalDTDis -> TPSTTaxDTDis
    public function FSaMTAXMoveSalDTDis_TaxDTDis($aPackData){
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];

        $tABB       = $aPackData['tDocABB'];
        $tSQL       = " INSERT INTO TPSTTaxDTDis (
                            FTBchCode,FTXshDocNo,FNXsdSeqNo,FDXddDateIns,FNXddStaDis,
                            FTXddDisChgTxt,FTXddDisChgType,FCXddNet,FCXddValue,FTXddRefCode
                        ) SELECT
                            FTBchCode,'$tTaxNumberFull',FNXsdSeqNo,FDXddDateIns,FNXddStaDis,
                            FTXddDisChgTxt,FTXddDisChgType,FCXddNet,FCXddValue,FTXddRefCode
                        FROM TPSTSalDTDis WITH(NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
        $this->db->query($tSQL);
    }

    // TPSTSalHDCst -> TPSTTaxHDCst
    public function FSaMTAXMoveSalHDCst_TaxHDCst($aPackData){
        $tABB               = $aPackData['tDocABB'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tTel               = $aPackData['tTel'];
        $tEmail             = $aPackData['tEmail'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];

        //ถ้าไปเจอลูกค้า จะ move ลงตาราง Tax เลย
        $tSQL       = "SELECT ISNULL(FTCstCode,'') AS FTCstCode FROM TPSTSalHD SAL WITH (NOLOCK)  WHERE FTXshDocNo = '$tABB'";
        $oQuery     = $this->db->query($tSQL);
        $aResult    = $oQuery->result();
        $tCstCode   = $aResult[0]->FTCstCode;
        if($tCstCode == '' || $tCstCode == null){

            $tCusCodeForm   = $aPackData['tCstCode'];
            $tCstName       = $aPackData['tCstName'];
            if( $tCusCodeForm == '' ||  $tCusCodeForm == null){
                //ไม่มีการเลือกลูกค้า และ ไม่มีลูกค้าอยู่ใน ABB
                $tSQL       = " INSERT INTO TPSTTaxHDCst (
                                    FTBchCode,
                                    FTXshDocNo,
                                    FTXshCstName,
                                    FTXshCstTel,
                                    FTXshCstEmail
                                ) SELECT
                                    (SELECT FTBchCode FROM TPSTSalHD SAL WITH (NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ) AS FTBchCode,
                                    '$tTaxNumberFull',
                                    'ลูกค้าทั่วไป',
                                    '$tTel',
                                    '$tEmail' 
                             ";
            }else{
                //ในหน้าจอมีการเลือกลูกค้า
                $tSQL       = " INSERT INTO TPSTTaxHDCst (
                                    FTBchCode,
                                    FTXshDocNo,
                                    FTXshCstName,
                                    FTXshCstTel,
                                    FTXshCstEmail
                                ) SELECT
                                    (SELECT FTBchCode FROM TPSTSalHD SAL WITH (NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ) AS FTBchCode,
                                    '$tTaxNumberFull',
                                    '$tCstName',
                                    '$tTel',
                                    '$tEmail' 
                              ";
            }
            $this->db->query($tSQL);
        }else{
            $tCstName   = $aPackData['tCstName'];
            $tSQL       = " INSERT INTO TPSTTaxHDCst (
                                FTBchCode,FTXshDocNo,FTXshCardID,FTXshCardNo,FNXshCrTerm,FDXshDueDate,
                                FDXshBillDue,FTXshCtrName,FDXshTnfDate,FTXshRefTnfID,FNXshAddrShip,FTXshAddrTax,
                                FTXshCstName,FTXshCstTel,FTXshCstEmail
                            ) SELECT
                                FTBchCode,'$tTaxNumberFull',FTXshCardID,FTXshCardNo,FNXshCrTerm,FDXshDueDate,
                                FDXshBillDue,FTXshCtrName,FDXshTnfDate,FTXshRefTnfID,FNXshAddrShip,FTXshAddrTax,
                                '$tCstName','$tTel','$tEmail'
                            FROM TPSTSalHDCst WITH(NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
            $this->db->query($tSQL);
        }
    }

    // TPSTSalPD -> TPSTTaxPD
    public function FSaMTAXMoveSalPD_TaxPD($aPackData){
        $tABB               = $aPackData['tDocABB'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];

        $tSQL       = " INSERT INTO TPSTTaxPD (
                            FTBchCode,FTXshDocNo,FTPmhDocNo,FNXsdSeqNo,
                            FTPmdGrpName,FTPdtCode,FTPunCode,FCXsdQty,FCXsdQtyAll,
                            FCXsdSetPrice,FCXsdNet,FCXpdGetQtyDiv,FTXpdGetType,FCXpdGetValue,
                            FCXpdDis,FCXpdPerDisAvg,FCXpdDisAvg,FCXpdPoint,FTXpdStaRcv,FTPplCode,
                            FTXpdCpnText,FTCpdBarCpn
                        ) SELECT
                            FTBchCode,'$tTaxNumberFull',FTPmhDocNo,FNXsdSeqNo,
                            FTPmdGrpName,FTPdtCode,FTPunCode,FCXsdQty,FCXsdQtyAll,
                            FCXsdSetPrice,FCXsdNet,FCXpdGetQtyDiv,FTXpdGetType,FCXpdGetValue,
                            FCXpdDis,FCXpdPerDisAvg,FCXpdDisAvg,FCXpdPoint,FTXpdStaRcv,FTPplCode,
                            FTXpdCpnText,FTCpdBarCpn
                        FROM TPSTSalPD WITH(NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
        $this->db->query($tSQL);
    }

    // TPSTSalRC -> TPSTTaxRC
    public function FSaMTAXMoveSalRC_TaxRC($aPackData){
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tABB               = $aPackData['tDocABB'];

        //เพิ่มเติม
        $dDateCurrent       = date('Y-m-d H:i:s');
        $tNameTask          = $this->session->userdata('tSesUsername');
        $dDocDateTime       = $aPackData['dDocDate'] .' '. $aPackData['dDocTime'];
        $tRemark            = $aPackData['tRemark'];

        $tSQL       = " INSERT INTO TPSTTaxRC (
                            FTBchCode,FTXshDocNo,FNXrcSeqNo,FTRcvCode,FTRcvName,
                            FTXrcRefNo1,FTXrcRefNo2,FDXrcRefDate,FTXrcRefDesc,FTBnkCode,
                            FTRteCode,FCXrcRteFac,FCXrcFrmLeftAmt,FCXrcUsrPayAmt,FCXrcDep,
                            FCXrcNet,FCXrcChg,FTXrcRmk,FTPhwCode,FTXrcRetDocRef,
                            FTXrcStaPayOffline,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                        ) SELECT
                            FTBchCode,'$tTaxNumberFull',FNXrcSeqNo,FTRcvCode,FTRcvName,
                            FTXrcRefNo1,FTXrcRefNo2,FDXrcRefDate,FTXrcRefDesc,FTBnkCode,
                            FTRteCode,FCXrcRteFac,FCXrcFrmLeftAmt,FCXrcUsrPayAmt,FCXrcDep,
                            FCXrcNet,FCXrcChg,FTXrcRmk,FTPhwCode,FTXrcRetDocRef,
                            FTXrcStaPayOffline,FDLastUpdOn,FTLastUpdBy,'$dDateCurrent','$tNameTask'
                        FROM TPSTSalRC WITH(NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
        $this->db->query($tSQL);
    }

    // TPSTSalRD -> TPSTTaxRD
    public function FSaMTAXMoveSalRD_TaxRD($aPackData){
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tABB               = $aPackData['tDocABB'];
        $tSQL       = " INSERT INTO TPSTTaxRD (
                            FTBchCode,FTXshDocNo,FNXrdSeqNo,FTRdhDocType,FNXrdRefSeq,FTXrdRefCode,FCXrdPdtQty,FNXrdPntUse
                        ) SELECT
                            FTBchCode,'$tTaxNumberFull',FNXrdSeqNo,FTRdhDocType,FNXrdRefSeq,FTXrdRefCode,FCXrdPdtQty,FNXrdPntUse
                        FROM TPSTSalRD WITH(NOLOCK) WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBrowseBchCode' ";
        $this->db->query($tSQL);
    }

    //อัพเดท ว่าเอกสารนี้ถูกใช้งานเเล้ว
    public function FSaMTAXUpdateDocVatFull($aPackData){
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tABB               = $aPackData['tDocABB'];
        $dDocDate           = $aPackData['dDocDate'];
        $dDocTime           = $aPackData['dDocTime'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $dDateCurrent       = date('Y-m-d H:i:s');
        $tNameTask          = $this->session->userdata('tSesUsername');

        $tSQL       = " UPDATE TPSTSalHD SET FTXshDocVatFull = '$tTaxNumberFull' , FDLastUpdOn = '$dDateCurrent' , FTLastUpdBy = '$tNameTask' WHERE FTXshDocNo = '$tABB' ";
        $this->db->query($tSQL);

        $tSQL       = " UPDATE TPSTTaxHD SET
                            FTXshDocVatFull = '$tTaxNumberFull' ,
                            FDLastUpdOn = '$dDateCurrent' ,
                            FTLastUpdBy = '$tNameTask'
                        WHERE FTXshDocNo = '$tTaxNumberFull' ";
        $this->db->query($tSQL);
    }

    //เพิ่มข้อมูลที่อยู่ใหม่
    public function FSaMTAXInsertTaxAddress($aPackData){
        $nLngID             = $this->session->userdata("tLangEdit");
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $FTAddTaxNo         = $aPackData['tTaxnumber'];
        $FTCstCode          = $aPackData['tCstCode'];
        $FTAddName          = $aPackData['tCstNameABB'];
        // $FTAddVersion       = $aPackData['tAddVersion'];;
        $FTAddV2Desc1       = $aPackData['tAddress1'];
        $FTAddV2Desc2       = $aPackData['tAddress2'];
        $FTAddStaBusiness   = $aPackData['tTypeBusiness'];
        $FTAddStaHQ         = $aPackData['tBusiness'];
        $FTAddStaBchCode    = $aPackData['tBranch'];
        $FTAddTel           = $aPackData['tTel'];
        $FTAddFax           = $aPackData['tFax'];
        // $FNAddSeqNo         = $aPackData['tSeqAddress'];
        $FDLastUpdOn        = date('Y-m-d H:i:s');
        $FTLastUpdBy        = $this->session->userdata('tSesUsername');
        $FDCreateOn         = date('Y-m-d H:i:s');
        $FTCreateBy         = $this->session->userdata('tSesUsername');

        // $FTAddV1No          = $aPackData['tAddV1No'];
        // $FTAddV1Soi         = $aPackData['tAddV1Soi'];
        // $FTAddV1Village     = $aPackData['tAddV1Village'];
        // $FTAddV1Road        = $aPackData['tAddV1Road'];
        $FTAddV1SubDist     = $aPackData['tAddV1SubDistCode'];
        $FTAddV1DstCode     = $aPackData['tAddV1DstCode'];
        $FTAddV1PvnCode     = $aPackData['tAddV1PvnCode'];
        $FTAddV1PostCode    = $aPackData['tAddV1PostCode'];


        //วิ่งเข้าไปเช็ค 3 Key ว่า ตรงไหม FTAddTaxNo / FNAddSeqNo / FTAddStaBchCode
        $tSQL   = "SELECT Tax.FTAddTaxNo FROM  TCNMTaxAddress_L Tax WITH (NOLOCK) WHERE 1=1
                  AND Tax.FTAddTaxNo = '$FTAddTaxNo'
                  AND Tax.FNLngID = $nLngID ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $tStatusFound = 'Found'; //found -> update address
        }else{
            $tStatusFound = 'NotFound'; //not found -> insert address
        }

        $aPackData = array(
            'FTCstCode' => $FTCstCode,
            'FTAddName' => $FTAddName,
            'FTAddVersion' => '2',
            'FTAddStaBusiness' => $FTAddStaBusiness,
            'FTAddTel' => $FTAddTel,
            'FTAddFax' => $FTAddFax,
            'FDLastUpdOn' => $FDLastUpdOn,
            'FTLastUpdBy' => $FTLastUpdBy,
            'FTAddStaBchCode' => '',
            'FTAddStaHQ' => '',
            'FTAddV1SubDist' => $FTAddV1SubDist,
            'FTAddV1DstCode' => $FTAddV1DstCode,
            'FTAddV1PvnCode' => $FTAddV1PvnCode,
            'FTAddV1PostCode' => $FTAddV1PostCode,
            'FTAddV2Desc1' => $FTAddV2Desc1,
            'FTAddV2Desc2' => $FTAddV2Desc2
        );

        // $this->db->set('FTCstCode',$FTCstCode);
        // $this->db->set('FTAddName',$FTAddName);
        // $this->db->set('FTAddVersion','2');

        // $this->db->set('FTAddStaBusiness',$FTAddStaBusiness);
        if( $FTAddStaBusiness == '1' ){
            $aPackData['FTAddStaBchCode'] = $FTAddStaBchCode;
            $aPackData['FTAddStaHQ'] = $FTAddStaHQ;
            // $this->db->set('FTAddStaBchCode',$FTAddStaBchCode);
            // $this->db->set('FTAddStaHQ',$FTAddStaHQ);
        }
        // else{
            // $this->db->set('FTAddStaBchCode','');
            // $this->db->set('FTAddStaHQ','');
        // }

        // $this->db->set('FTAddTel',$FTAddTel);
        // $this->db->set('FTAddFax',$FTAddFax);
        // $this->db->set('FDLastUpdOn',$FDLastUpdOn);
        // $this->db->set('FTLastUpdBy',$FTLastUpdBy);

        // if( $FTAddVersion == '1' ){
            // $this->db->set('FTAddV1No',$FTAddV1No);
            // $this->db->set('FTAddV1Soi',$FTAddV1Soi);
            // $this->db->set('FTAddV1Village',$FTAddV1Village);
            // $this->db->set('FTAddV1Road',$FTAddV1Road);
            // $this->db->set('FTAddV1SubDist',$FTAddV1SubDist);
            // $this->db->set('FTAddV1DstCode',$FTAddV1DstCode);
            // $this->db->set('FTAddV1PvnCode',$FTAddV1PvnCode);
            // $this->db->set('FTAddV1PostCode',$FTAddV1PostCode);
        // }else{
            // $this->db->set('FTAddV2Desc1',$FTAddV2Desc1);
            // $this->db->set('FTAddV2Desc2',$FTAddV2Desc2);
        // }

        if($tStatusFound == 'Found'){
            // // Update
            // if( $FTAddVersion == '1' ){
            //     $this->db->set('FTAddV2Desc1','');
            //     $this->db->set('FTAddV2Desc2','');
            // }else{
            //     $this->db->set('FTAddV1No','');
            //     $this->db->set('FTAddV1Soi','');
            //     $this->db->set('FTAddV1Village','');
            //     $this->db->set('FTAddV1Road','');
            //     $this->db->set('FTAddV1SubDist','');
            //     $this->db->set('FTAddV1DstCode','');
            //     $this->db->set('FTAddV1PvnCode','');
            //     $this->db->set('FTAddV1PostCode','');
            // }

            $this->db->where('FTAddTaxNo',$FTAddTaxNo);
            $this->db->where('FNLngID',$nLngID);
            $this->db->update('TCNMTaxAddress_L',$aPackData);
        }else{
            //Insert
            $aPackData['FNLngID'] = $nLngID;
            $aPackData['FTAddTaxNo'] = $FTAddTaxNo;
            $aPackData['FDCreateOn'] = $FDCreateOn;
            $aPackData['FTCreateBy'] = $FTCreateBy;

            // $this->db->set('FNLngID',$nLngID);
            // $this->db->set('FTAddTaxNo',$FTAddTaxNo);
            // $this->db->set('FDCreateOn',$FDCreateOn);
            // $this->db->set('FTCreateBy',$FTCreateBy);
            $this->db->insert('TCNMTaxAddress_L',$aPackData);

            //หาข้อมูลว่า SEQ ที่เพิ่มเข้าไปใช้อะไร
            // $tSQL       = "SELECT TOP 1 FNAddSeqNo FROM TCNMTaxAddress_L WHERE FTAddTaxNo = '$FTAddTaxNo' ORDER BY FNAddSeqNo DESC";
            // $oQuery     = $this->db->query($tSQL);
            // $aResult    = $oQuery->result();
            // $nSeqLast   = $aResult[0]->FNAddSeqNo;
        }

        // Insert Address
        unset($aPackData['FNLngID']);
        unset($aPackData['FTCstCode']);

        $aPackData['FTBchCode']  = $tBrowseBchCode;
        $aPackData['FTXshDocNo'] = $tTaxNumberFull;
        $aPackData['FTAddTaxNo'] = $FTAddTaxNo;
        $aPackData['FDCreateOn'] = $FDCreateOn;
        $aPackData['FTCreateBy'] = $FTCreateBy;
        // $this->db->set('FTBchCode',$tBrowseBchCode);
        // $this->db->set('FTXshDocNo',$tTaxNumberFull);
        $this->db->insert('TPSTTaxHDAddress',$aPackData);

        //อัพเดทข้อมูล SEQ -> TPSTTaxHDCst
        $tSQL       = "UPDATE TPSTTaxHDCst SET FTXshAddrTax = '$FTAddTaxNo' WHERE FTXshDocNo = '$tTaxNumberFull' ";
        $this->db->query($tSQL);
    }

    ///////////////////////////////////// PREVIEW /////////////////////////////////////

    //หาเอกสารที่ HD ถูกอนุมัติเเล้ว
    public function FSaMTAXGetHDTax($ptData){
        $tDocumentNumber = $ptData['tDocumentNumber'];
        $tBrowseBchCode = $ptData['tBrowseBchCode'];
        $tSQL   = " SELECT 
                        Tax.* , 
                        HD.FTXshDocNo AS DocABB, 
                        ISNULL(Tax.FTXshStaETax,'') AS FTXshStaETax, 
                        RSNL.FTRsnName,
                        USRL.FTUsrName AS FTCreateName
                    FROM TPSTTaxHD           Tax WITH (NOLOCK)
                    LEFT JOIN TPSTSalHD       HD WITH(NOLOCK) ON Tax.FTXshDocVatFull = HD.FTXshDocVatFull AND Tax.FTBchCode = HD.FTBchCode
                    LEFT JOIN TCNMRsn_L     RSNL WITH(NOLOCK) ON Tax.FTRsnCode = RSNL.FTRsnCode AND RSNL.FNLngID = ".$ptData['FNLngID']."
                    LEFT JOIN TCNMUser_L    USRL WITH(NOLOCK) ON Tax.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = ".$ptData['FNLngID']."
                    WHERE Tax.FTXshDocNo = '$tDocumentNumber' AND Tax.FTBchCode = '$tBrowseBchCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาเอกสารที่ DT ถูกอนุมัติเเล้ว
    public function FSaMTAXGetDTTax($ptDocument){
        $tSQL   = "SELECT * FROM  TPSTTaxDT Tax WITH (NOLOCK) WHERE 1=1 AND Tax.FTXshDocNo = '$ptDocument' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //หาเอกสารที่ ADDRESS ถูกอนุมัติเเล้ว
    public function FSaMTAXGetAddressTax($ptData){
        $tDocumentNumber = $ptData['tDocumentNumber'];
        $tBrowseBchCode = $ptData['tBrowseBchCode'];
        $nFNLngID = $ptData['FNLngID'];

        // $tSQL   = "SELECT TaxAdd.* , HDCst.FTXshCstName FROM  TPSTTaxHDCst HDCst WITH (NOLOCK)
        //            /*LEFT JOIN TCNMTaxAddress_L TaxAdd ON HDCst.FNXshAddrTax = TaxAdd.FNAddSeqNo*/
        //            LEFT JOIN TCNMTaxAddress_L TaxAdd WITH (NOLOCK) ON HDCst.FTXshAddrTax = TaxAdd.FTAddTaxNo
        //            WHERE 1=1 AND HDCst.FTXshDocNo = '$tDocumentNumber' AND HDCst.FTBchCode = '$tBrowseBchCode' ";

        // $tSQL = "   SELECT 
        //                 PVN_L.FTPvnCode,
        //                 PVN_L.FTPvnName,
        //                 DST_L.FTDstCode,
        //                 DST_L.FTDstName,
        //                 SUD_L.FTSudCode,
        //                 SUD_L.FTSudName,
        //                 HDCst.FTXshAddrTax,
        //                 HDCst.FTXshCstTel,
        //                 HDCst.FTXshFax,
        //                 HDCst.FTXshPostCode,
        //                 HDCst.FTXshDesc1,
        //                 HDCst.FTXshDesc2, 
        //                 HDCst.FTXshCstName,
        //                 HDCst.FTXshCstEmail
        //             FROM TPSTTaxHDCst HDCst WITH(NOLOCK)
        //             LEFT JOIN TCNMProvince_L      PVN_L WITH(NOLOCK) ON HDCst.FTXshPvnCode = PVN_L.FTPvnCode AND PVN_L.FNLngID = $nFNLngID
        //             LEFT JOIN TCNMDistrict_L      DST_L WITH(NOLOCK) ON HDCst.FTXshDstCode = DST_L.FTDstCode AND DST_L.FNLngID = $nFNLngID
        //             LEFT JOIN TCNMSubDistrict_L   SUD_L WITH(NOLOCK) ON HDCst.FTXshSubDist = SUD_L.FTSudCode AND SUD_L.FNLngID = $nFNLngID
        //             WHERE 1 = 1
        //                 AND HDCst.FTXshDocNo = '$tDocumentNumber'
        //                 AND HDCst.FTBchCode = '$tBrowseBchCode' ";

        $tSQL = "   SELECT 
                        PVN_L.FTPvnCode,
                        PVN_L.FTPvnName,
                        DST_L.FTDstCode,
                        DST_L.FTDstName,
                        SUD_L.FTSudCode,
                        SUD_L.FTSudName,
                        HDADR.FTAddTaxNo        AS FTXshAddrTax,
                        HDADR.FTAddTel          AS FTXshCstTel,
                        HDADR.FTAddFax          AS FTXshFax,
                        HDADR.FTAddV1PostCode   AS FTXshPostCode,
                        HDADR.FTAddV2Desc1      AS FTXshDesc1,
                        HDADR.FTAddV2Desc2      AS FTXshDesc2, 
                        HD.FTCstCode            AS FTXshCstCode,
                        HDADR.FTAddName         AS FTXshCstName,
                        HDCST.FTXshCstEmail,
                        HDADR.FTAddStaBusiness,
                        HDADR.FTAddStaHQ,
                        HDADR.FTAddStaBchCode
                    FROM TPSTTaxHDAddress         HDADR WITH(NOLOCK)
                    INNER JOIN TPSTTaxHD             HD WITH(NOLOCK) ON HDADR.FTBchCode = HD.FTBchCode AND HDADR.FTXshDocNo = HD.FTXshDocNo
                    LEFT JOIN TPSTTaxHDCst        HDCST WITH(NOLOCK) ON HDADR.FTBchCode = HDCST.FTBchCode AND HDADR.FTXshDocNo = HDCST.FTXshDocNo
                    LEFT JOIN TCNMProvince_L      PVN_L WITH(NOLOCK) ON HDADR.FTAddV1PvnCode = PVN_L.FTPvnCode AND PVN_L.FNLngID = $nFNLngID
                    LEFT JOIN TCNMDistrict_L      DST_L WITH(NOLOCK) ON HDADR.FTAddV1DstCode = DST_L.FTDstCode AND DST_L.FNLngID = $nFNLngID
                    LEFT JOIN TCNMSubDistrict_L   SUD_L WITH(NOLOCK) ON HDADR.FTAddV1SubDist = SUD_L.FTSudCode AND SUD_L.FNLngID = $nFNLngID
                    WHERE 1 = 1
                        AND HDADR.FTXshDocNo = '$tDocumentNumber'
                        AND HDADR.FTBchCode  = '$tBrowseBchCode' 
                ";

        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //อนุญาติว่า ปริ้น from ได้กี่ใบ
    public function FSaMTAXGetConfig(){
        $tSQL   = "SELECT FTSysStaUsrValue , FTSysStaUsrRef FROM TSysConfig WHERE FTSysCode = 'nPS_PrnTax' AND FTSysKEY = 'Tax'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    public function FSaMTAXUpdateWhenApprove($aWhere,$aSet,$ptType){
        $FTAddName          = $aSet['FTAddName'];
        $FTAddTel           = $aSet['FTAddTel'];
        $FTAddFax           = $aSet['FTAddFax'];
        $FTAddV2Desc1       = $aSet['FTAddV2Desc1'];
        $FTAddV2Desc2       = $aSet['FTAddV2Desc2'];
        $dDateCurrent       = date('Y-m-d H:i:s');
        $tNameTask          = $this->session->userdata('tSesUsername');
        $FNAddSeqNo         = $aWhere['FNAddSeqNo'];
        $tDocumentNo        = $aSet['tDocumentNo'];
        $tBrowseBchCode        = $aSet['tBrowseBchCode'];
        $nLngID             = $this->session->userdata("tLangEdit");


        if($ptType == 'UPDATEADDRESS'){
            // $tSQL   = " UPDATE TCNMTaxAddress_L
            //         SET FTAddName = '$FTAddName' ,
            //             FTAddTel = '$FTAddTel' ,
            //             FTAddFax  = '$FTAddFax' ,
            //             FTAddV2Desc1 = '$FTAddV2Desc1',
            //             FTAddV2Desc2 = '$FTAddV2Desc2',
            //             FDLastUpdOn = '$dDateCurrent' ,
            //             FTLastUpdBy = '$tNameTask'
            //         WHERE FNAddSeqNo = '$FNAddSeqNo' ";
        }else{

            $tNumberTax             = $aSet['tNumberTax'];
            $tNumberTaxNew          = $aSet['tNumberTaxNew'];
            $tTypeBusiness          = $aSet['tTypeBusiness'];
            $tBusiness              = $aSet['tBusiness'];
            $tBchCode               = $aSet['tBchCode'];
            $tCstCode               = $aSet['tCstCode'];
            $tCstName               = $aSet['tCstName'];

            $tSQLFind   = "SELECT TOP 1 FTAddTaxNo FROM TCNMTaxAddress_L WHERE FTAddTaxNo = '$tNumberTax' ";
            $oQuery     = $this->db->query($tSQLFind);
            if ($oQuery->num_rows() > 0) {
                $tFindAddress   = 1;
                // $aResult        = $oQuery->result();
                // $nSeqLast       = $aResult[0]->FNAddSeqNo;
            }else{
                $tFindAddress   = 0;
            }

            if($tFindAddress == 1){

                if($tCstCode == '' || $tCstCode == null){
                    $tSQL       = " UPDATE TPSTTaxHDCst SET FTXshAddrTax = '$tNumberTax' WHERE FTXshDocNo = '$tDocumentNo' AND FTBchCode = '$tBrowseBchCode' ";
                }else{
                    $tSQL       = " UPDATE TPSTTaxHDCst SET FTXshAddrTax = '$tNumberTax' , FTXshCstName  = '$tCstName' WHERE FTXshDocNo = '$tDocumentNo' AND FTBchCode = '$tBrowseBchCode' ";
                }

                $tSQLADD    = " UPDATE TCNMTaxAddress_L
                                SET FTAddName = '$FTAddName' ,
                                    FTAddTel = '$FTAddTel' ,
                                    FTAddFax  = '$FTAddFax' ,
                                    FTAddV2Desc1 = '$FTAddV2Desc1',
                                    FTAddV2Desc2 = '$FTAddV2Desc2',
                                    FDLastUpdOn = '$dDateCurrent' ,
                                    FTAddStaHQ = '$tBusiness',
                                    FTAddStaBchCode = '$tBchCode',
                                    FTAddStaBusiness =  '$tTypeBusiness',
                                    FTLastUpdBy = '$tNameTask'
                                WHERE FTAddTaxNo = '$tNumberTax' ";
                $this->db->query($tSQLADD);
            }else{
                //Insert
                $tSQLIns = "INSERT INTO TCNMTaxAddress_L (
                    FTAddTaxNo , FNLngID ,
                    FTCstCode , FTAddName , FTAddVersion ,
                    FTAddV2Desc1 , FTAddV2Desc2 , FTAddStaBusiness ,
                    FTAddStaHQ , FTAddStaBchCode , FTAddTel , FTAddFax ,
                    FDLastUpdOn , FTLastUpdBy , FDCreateOn , FTCreateBy
                )
                VALUES (
                    '$tNumberTax' , '$nLngID' ,
                    '$tCstCode' , '$FTAddName' , '2' ,
                    '$FTAddV2Desc1' , '$FTAddV2Desc2' , '$tTypeBusiness' ,
                    '$tBusiness' , '$tBchCode' , '$FTAddTel' , '$FTAddFax' ,
                    '$dDateCurrent' , '$tNameTask' , '$dDateCurrent' , '$tNameTask'
                )";
                $this->db->query($tSQLIns);

                //หาข้อมูลว่า SEQ ที่เพิ่มเข้าไปใช้อะไร
                // $tSQL       = "SELECT TOP 1 FNAddSeqNo FROM TCNMTaxAddress_L WHERE FTAddTaxNo = '$tNumberTax' ORDER BY FNAddSeqNo DESC";
                // $oQuery     = $this->db->query($tSQL);
                // $aResult    = $oQuery->result();
                // $nSeqLast   = $aResult[0]->FNAddSeqNo;

                if($tCstCode == '' || $tCstCode == null){
                    $tSQL       = " UPDATE TPSTTaxHDCst SET FTXshAddrTax = '$tNumberTax' WHERE FTXshDocNo = '$tDocumentNo' ";
                }else{
                    $tSQL       = " UPDATE TPSTTaxHDCst SET FTXshAddrTax = '$tNumberTax' , FTXshCstName  = '$tCstName' WHERE FTXshDocNo = '$tDocumentNo' ";
                }
            }
        }
        $this->db->query($tSQL);
    }

    //ข้อมูลการขาย DT
    public function FSaMTAXGetDTInTax($paData){
        $aRowLen            = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $tBrowseBchCode    = $paData['tBrowseBchCode'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXshDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                    /*DTDis.DISPMT ,*/ SALDT.FTBchCode , SALDT.FTXshDocNo , SALDT.FNXsdSeqNo , FTPdtCode , FTXsdPdtName ,
                                    FTPunCode , FTPunName , FCXsdFactor , FTXsdBarCode , FTSrnCode ,
                                    FTXsdVatType , FTVatCode , FTPplCode , FCXsdVatRate , FTXsdSaleType ,
                                    FCXsdSalePrice , FCXsdQty , FCXsdQtyAll , FCXsdSetPrice , FCXsdAmtB4DisChg ,
                                    FTXsdDisChgTxt , FCXsdDis , FCXsdChg , FCXsdNet , FCXsdNetAfHD ,
                                    FCXsdVat , FCXsdVatable , FCXsdWhtAmt , FTXsdWhtCode , FCXsdWhtRate ,
                                    FCXsdCostIn , FCXsdCostEx , FTXsdStaPdt , FCXsdQtyLef , FCXsdQtyRfn ,
                                    FTXsdStaPrcStk , FTXsdStaAlwDis , FNXsdPdtLevel , FTXsdPdtParent , FCXsdQtySet ,
                                    FTPdtStaSet , FTXsdRmk , FDLastUpdOn , FTLastUpdBy , FDCreateOn , FTCreateBy
                            FROM TPSTTaxDT SALDT WITH (NOLOCK)
                            /*LEFT JOIN ( SELECT SUM(FCXddValue) as DISPMT , FNXsdSeqNo FROM TPSTTaxDTDis
                                        WHERE (FNXddStaDis = 2 OR FNXddStaDis = 0) AND FTXddDisChgType IN ('1','2') AND ISNULL(FTXddRefCode,'') <> ''
                                        AND TPSTTaxDTDis.FTXshDocNo = '$tDocumentNumber'
                                        AND TPSTTaxDTDis.FTBchCode = '$tBrowseBchCode'
                                        GROUP BY FNXsdSeqNo
                                    ) DTDis ON DTDis.FNXsdSeqNo = SALDT.FNXsdSeqNo*/
                            WHERE SALDT.FTXshDocNo = '$tDocumentNumber'  AND SALDT.FTBchCode = '$tBrowseBchCode' ";

        //ค้นหาแบบพิเศษ
        @$tSearchPDT   = $paData['tSearchPDT'];
        $tSQL .= "  AND ((SALDT.FTXshDocNo LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPdtCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdPdtName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPunName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdBarCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdQty LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdSetPrice LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdNetAfHD LIKE '%$tSearchPDT%')
                        OR (SALDT.FTBchCode LIKE '%$tSearchPDT%')
                    )";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTAXGetDTPageAllInTax($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']);
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาจำนวนการขาย DT
    public function FSnMTAXGetDTPageAllInTax($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $tBrowseBchCode    = $paData['tBrowseBchCode'];
        $tSQL   = " SELECT COUNT (SALDT.FTXshDocNo) AS counts FROM TPSTTaxDT SALDT WITH (NOLOCK) WHERE 1=1 AND FTXshDocNo = '$tDocumentNumber' AND FTBchCode = '$tBrowseBchCode' ";

        //ค้นหาแบบพิเศษ
        @$tSearchPDT   = $paData['tSearchPDT'];
        $tSQL   .= "  AND ((SALDT.FTXshDocNo LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPdtCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdPdtName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTPunName LIKE '%$tSearchPDT%')
                        OR (SALDT.FTXsdBarCode LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdQty LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdSetPrice LIKE '%$tSearchPDT%')
                        OR (SALDT.FCXsdNetAfHD LIKE '%$tSearchPDT%')
                        OR (SALDT.FTBchCode LIKE '%$tSearchPDT%')
                    )";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }


    //กรณีไม่สารถ GetMassage ได้จาก Stomp ให้ไปหาเองจาก TPSTTaxNo ล่าสุด
    public function FSaMTAXCallTaxNoLastDoc($paData){

        $tBchCode    = $paData['tBchCode'];
        $nDocType    = $paData['nDocType'];
        $tDocABB    = $paData['tDocABB'];


        $tXshDocNo = $this->db->select('FTXshDocNo')->where('FTBchCode',$tBchCode)->where('FNXshDocType',$nDocType)->get('TPSTTaxNo')->row_array()['FTXshDocNo'];

        return $tXshDocNo;

    }

    //ตรวจสอบเลข TaxNo ว่ามีการนำไปออกใบกำกับไปแล้วหรือยัง  if > 0 = มีแล้ว
    public function FSnMTAXCheckDuplicationOnTaxHD($ptXshDocNo,$ptBCHCode){

        if($ptXshDocNo!='false' && $ptXshDocNo!='end' && $ptXshDocNo!=''){
            $nRowsDoc = $this->db->where('FTXshDocNo',$ptXshDocNo)->where('FTBchCode',$ptBCHCode)->get('TPSTTaxHD')->num_rows();
        }else{
            $nRowsDoc = 1;
        }
          if($nRowsDoc> 0 ){
            return 1;
          }else{
            return 0;
          }
    }

    //หาที่อยู่ของใบกำกับภาษีในสาขา
    public function FSaMTAXGetBchHD($aPackData){
        $tDocumentNumber = $aPackData['tDocumentNumber'];
        $tSQL            = "SELECT FTBchCode FROM  TPSTSalHD Tax WITH (NOLOCK) WHERE 1=1 AND Tax.FTXshDocNo = '$tDocumentNumber' ";
        $oQuery          = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    // TPSTSalDTSN -> TPSTTaxDTSN
    public function FSaMTAXMoveSalDTSN_TaxDTSN($aPackData){
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tABB               = $aPackData['tDocABB'];
        $tBranch            = $aPackData['tBrowseBchCode'];

        $tSQL       = " INSERT INTO TPSTTaxDTSN ( FTBchCode,FTXshDocNo,FNXsdSeqNo,FTPdtSerial,FTXsdStaRet,FTPdtBatchID )
                        SELECT '$tBranch','$tTaxNumberFull',FNXsdSeqNo,FTPdtSerial,FTXsdStaRet,FTPdtBatchID
                        FROM TPSTSalDTSN WITH(NOLOCK) 
                        WHERE FTXshDocNo = '$tABB' AND FTBchCode = '$tBranch' ";
        $this->db->query($tSQL);
    }

    public function FSaMTAXUpdAddrTaxHDCst($aPackData){
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        // $FTAddTaxNo         = $aPackData['tTaxnumber'];
        // $FTCstCode          = $aPackData['tCstCode'];
        $FTAddName          = $aPackData['tCstNameABB'];
        // $FTAddVersion       = $aPackData['tAddVersion'];;
        $FTAddV2Desc1       = $aPackData['tAddress1'];
        $FTAddV2Desc2       = $aPackData['tAddress2'];
        // $FTAddStaBusiness   = $aPackData['tTypeBusiness'];
        // $FTAddStaHQ         = $aPackData['tBusiness'];
        // $FTAddStaBchCode    = $aPackData['tBranch'];
        $FTAddTel           = $aPackData['tTel'];
        $FTAddFax           = $aPackData['tFax'];
        $FNAddSeqNo         = $aPackData['tSeqAddress'];

        $FTAddV1SubDist     = $aPackData['tAddV1SubDistCode'];
        $FTAddV1DstCode     = $aPackData['tAddV1DstCode'];
        $FTAddV1PvnCode     = $aPackData['tAddV1PvnCode'];
        $FTAddV1PostCode    = $aPackData['tAddV1PostCode'];

        $this->db->set('FTXshCstName',$FTAddName);
        $this->db->set('FTXshCstTel',$FTAddTel);
        $this->db->set('FTXshFax',$FTAddFax);
        $this->db->set('FTXshSubDist',$FTAddV1SubDist);
        $this->db->set('FTXshDstCode',$FTAddV1DstCode);
        $this->db->set('FTXshPvnCode',$FTAddV1PvnCode);
        $this->db->set('FTXshPostCode',$FTAddV1PostCode);
        $this->db->set('FTXshDesc1',$FTAddV2Desc1);
        $this->db->set('FTXshDesc2',$FTAddV2Desc2);

        $this->db->where('FTXshDocNo',$tTaxNumberFull);
        $this->db->insert('TPSTTaxHDCst');

    }

    public function FSxMTAXUpdateReference($aPackData){
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tCurretTaxDocNo    = $aPackData['tCurretTaxDocNo'];
        $tOriginTaxDocNo    = $aPackData['tOriginTaxDocNo'];
        $dDocDateTime       = $aPackData['dDocDate'] .' '. $aPackData['dDocTime'];

        if( $tOriginTaxDocNo == "" ){
            $tOriginTaxDocNo = $tCurretTaxDocNo;
        }

        // ปรับสถานะเอกสาร Full Tax ต้นฉบับ เป็น 5
        $this->db->set('FTXshStaDoc','5');
        $this->db->where('FTBchCode',$tBrowseBchCode);
        $this->db->where('FTXshDocNo',$tOriginTaxDocNo);
        $this->db->update('TPSTTaxHD');

        // ปรับสถานะเอกสารของ Full Tax ที่ยกเลิก
        if( $tCurretTaxDocNo != $tOriginTaxDocNo ){
            $this->db->set('FTXshStaDoc','3');
            // $this->db->where('FTXshDocNo',$tCurretTaxDocNo);
            $this->db->where('FTXshRefAE',$tOriginTaxDocNo);
            $this->db->update('TPSTTaxHD');
        }
        
        // อัพเดท Reference
        $this->db->set('FTXshStaDoc','4');
        $this->db->set('FTXshRefAE',$tOriginTaxDocNo);  // อ้างอิงเอกสาร Full Tax ต้นฉบับ
        $this->db->set('FTXshRefInt',$tCurretTaxDocNo); // อ้างอิงเอกสาร Full Tax ที่ยกเลิก
        $this->db->set('FDXshRefIntDate',$dDocDateTime);
        $this->db->where('FTXshDocNo',$tTaxNumberFull);
        $this->db->update('TPSTTaxHD');
    }

    public function FSxMTAXUpdAddrCNFullTax($aPackData){
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tCurretTaxDocNo    = $aPackData['tCurretTaxDocNo'];
        $tOriginTaxDocNo    = $aPackData['tOriginTaxDocNo'];
        $dDocDateTime       = $aPackData['dDocDate'] .' '. $aPackData['dDocTime'];
        $bStaInsert         = false;

        // // เช็คว่าเป็นการยกเลิกครั้งที่ 1 หรือไม่ ?
        // $tSQL = " SELECT FTXshRefInt FROM TPSTTaxHD WITH(NOLOCK) WHERE FTXshDocNo = '$tCurretTaxDocNo' AND FTXshStaDoc = '1' ";
        // $oQuery = $this->db->query($tSQL);
        // if( $oQuery->num_rows() > 0 ){
        //     $tXshRefInt = $oQuery->row_array()['FTXshRefInt']; // ถ้าเป็นการยกเลิกครั้งที่ 1 ให้ดึงเลขที่ ABB Full Tax จาก RefInt ได้เลย
        //     $tSQLDocNoEdit = "      SELECT HD.FTXshDocNo
        //                             FROM TPSTTaxHD HD WITH(NOLOCK)
        //                             WHERE HD.FTXshStaDoc = '4'
        //                             /*AND HD.FTXshRefAE = '$tXshRefInt'*/
        //                             AND ( HD.FTXshRefAE = '$tXshRefInt' OR HD.FTXshRefInt = '$tXshRefInt' )
        //                             AND HD.FTBchCode = '$tBrowseBchCode' 
        //                      ";
        // }else{
        //     // ถ้าไม่ใช่การยกเลิกครั้งที่ 1 เอาเลขที่ใบลดหนี้ต้นฉบับ(FTXshRefAE) ไปหาเลขที่ใบ ABB Full Tax ที่แก้ไขล่าสุด
        //     $tSQLDocNoEdit = "      SELECT HD.FTXshDocNo
        //                             FROM TPSTTaxHD CN WITH(NOLOCK)
        //                             INNER JOIN TPSTTaxHD HD WITH(NOLOCK) ON /*HD.FTXshRefAE = CN.FTXshRefInt*/ ( HD.FTXshRefAE = CN.FTXshRefInt OR HD.FTXshRefInt = CN.FTXshRefInt ) AND HD.FTBchCode = CN.FTBchCode
        //                             WHERE HD.FTXshStaDoc = '4'
        //                             AND CN.FTXshDocNo = '$tOriginTaxDocNo'
        //                             AND CN.FTBchCode = '$tBrowseBchCode'
        //                      ";
        // }

        $tSQL = "   SELECT
                        CNTAX.FTXshRefExt,
                        CNABB.FTXshRefInt,
                        ABB.FTXshDocVatFull
                    FROM TPSTTaxHD			CNTAX WITH(NOLOCK)
                    INNER JOIN TPSTSalHD	CNABB WITH(NOLOCK) ON CNTAX.FTXshRefExt = CNABB.FTXshDocNo AND CNTAX.FTBchCode = CNABB.FTBchCode
                    INNER JOIN TPSTSalHD	  ABB WITH(NOLOCK) ON CNABB.FTXshRefInt = ABB.FTXshDocNo AND CNABB.FTBchCode = ABB.FTBchCode
                    WHERE CNTAX.FTXshDocNo = '$tCurretTaxDocNo'
                      AND CNTAX.FTBchCode  = '$tBrowseBchCode' 
                ";

        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $bStaInsert = true;
            $tXshDocNoFullTax = $oQuery->row_array()['FTXshDocVatFull'];
        }

        if( $bStaInsert ){

            $tUserCode = $this->session->userdata("tSesUserCode");
            $nFNLngID  = $this->session->userdata("tLangEdit");

            $this->db->where('FTBchCode',$tBrowseBchCode);
            $this->db->where('FTXshDocNo',$tTaxNumberFull);
            $this->db->delete('TPSTTaxHDAddress');

            $tSQL = "   INSERT INTO TPSTTaxHDAddress ( FTBchCode, FTXshDocNo, FTAddTaxNo, FTAddName, 
                        FTAddRmk, FTAddCountry, FTAreCode, FTZneCode, FTAddVersion, FTAddV1No, FTAddV1Soi, 
                        FTAddV1Village, FTAddV1Road, FTAddV1SubDist, FTAddV1DstCode, FTAddV1PvnCode, 
                        FTAddV1PostCode, FTAddV2Desc1, FTAddV2Desc2, FTAddWebsite, FTAddLongitude, FTAddLatitude, 
                        FTAddStaBusiness, FTAddStaHQ, FTAddStaBchCode, FTAddTel, FTAddFax, FTAddRefNo, FDLastUpdOn, 
                        FTLastUpdBy, FDCreateOn, FTCreateBy ) 

                        SELECT FTBchCode, '$tTaxNumberFull', FTAddTaxNo, FTAddName, 
                        FTAddRmk, FTAddCountry, FTAreCode, FTZneCode, FTAddVersion, FTAddV1No, FTAddV1Soi, 
                        FTAddV1Village, FTAddV1Road, FTAddV1SubDist, FTAddV1DstCode, FTAddV1PvnCode, 
                        FTAddV1PostCode, FTAddV2Desc1, FTAddV2Desc2, FTAddWebsite, FTAddLongitude, FTAddLatitude, 
                        FTAddStaBusiness, FTAddStaHQ, FTAddStaBchCode, FTAddTel, FTAddFax, FTAddRefNo, '$dDocDateTime', 
                        FTLastUpdBy, '$dDocDateTime', FTCreateBy 
                        FROM TPSTTaxHDAddress WITH(NOLOCK)
                        WHERE FTXshDocNo = '$tXshDocNoFullTax'
                          AND FTBchCode = '$tBrowseBchCode'
                    ";
            $this->db->query($tSQL);

            // เอาที่อยู่ล่าสุดของ abb-fulltax ไปอัพเดที่ master tax address
            $tSQL = "   UPDATE TADRL
                        SET TADRL.FTAddName         = FULLTAX.FTAddName,
                            TADRL.FTAddV1SubDist    = FULLTAX.FTAddV1SubDist,
                            TADRL.FTAddV1DstCode    = FULLTAX.FTAddV1DstCode,
                            TADRL.FTAddV1PvnCode    = FULLTAX.FTAddV1PvnCode,
                            TADRL.FTAddV1PostCode   = FULLTAX.FTAddV1PostCode,
                            TADRL.FTAddV2Desc1      = FULLTAX.FTAddV2Desc1,
                            TADRL.FTAddV2Desc2      = FULLTAX.FTAddV2Desc2,
                            TADRL.FDLastUpdOn       = '$dDocDateTime',
                            TADRL.FTLastUpdBy       = '$tUserCode'
                        FROM TCNMTaxAddress_L TADRL
                        INNER JOIN TPSTTaxHDAddress FULLTAX ON TADRL.FTAddTaxNo = FULLTAX.FTAddTaxNo
                        WHERE FULLTAX.FTBchCode  = '$tBrowseBchCode'
                          AND FULLTAX.FTXshDocNo = '$tXshDocNoFullTax' 
                          AND TADRL.FNLngID      = $nFNLngID ";
            $this->db->query($tSQL);

            // อัพเดทชื่อลูกค้า จากที่อยู่ล่าสุดของ abb-fulltax
            $tSQL = "   UPDATE CNCST
                        SET CNCST.FTXshCstName = FULLCST.FTXshCstName
                        FROM TPSTTaxHDCst CNCST
                        INNER JOIN TPSTTaxHDCst FULLCST ON FULLCST.FTXshDocNo = '$tXshDocNoFullTax' AND CNCST.FTBchCode = FULLCST.FTBchCode
                        WHERE CNCST.FTBchCode   = '$tBrowseBchCode'
                          AND CNCST.FTXshDocNo  = '$tTaxNumberFull' 
                    ";
            $this->db->query($tSQL);

        }
    }

    // Create By : Napat(Jame) 16/09/2021
    // อัพเดทกรณีอนุมัติส่ง iNet ไม่สำเร็จ และ User เข้ามาแก้ไขข้อมูล Address
    public function FSxMTAXUpdAddrAndCst($paDataHDAddress,$paDataHDCst,$paWhereCondition){

        // Update HD Address
        $this->db->where($paWhereCondition);
        $this->db->update('TPSTTaxHDAddress',$paDataHDAddress);

        // Update HD Cst
        $this->db->where($paWhereCondition);
        $this->db->update('TPSTTaxHDCst',$paDataHDCst);

    }

    // Create By : Napat(Jame) 16/09/2021
    // เช็คสถานะส่งไป iNet ของ ABB ถ้าไม่สมบูรณ์ ให้ส่งใหม่อีกครั้ง
    public function FSbMTAXChkStaABBETaxApv($paWhereABB){
        $tSQL = "   SELECT HD.FTXshETaxStatus FROM TPSTSalHD HD WITH(NOLOCK) 
                    WHERE HD.FTXshDocNo = '".$paWhereABB['FTXshDocNo']."'
                      AND HD.FTBchCode = '".$paWhereABB['FTBchCode']."'
                      AND ISNULL(HD.FTXshETaxStatus,'3') = '3'
                ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if( $oQuery->num_rows() > 0 ){
            $bReturn = true;
        }else{
            $bReturn = false;
        }
        return $bReturn;
    }
    
    public function FSxMTAXUpdAddrABBFullTax($aPackData){
        $tTaxNumberFull     = $aPackData['tTaxNumberFull'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $dDocDateTime       = $aPackData['dDocDate'] .' '. $aPackData['dDocTime'];
        $tUserCode          = $this->session->userdata("tSesUserCode");
        $nFNLngID           = $this->session->userdata("tLangEdit");

        // เอาที่อยู่ล่าสุดของ abb-fulltax ไปอัพเดที่ master tax address
        $tSQL = "   UPDATE TADRL
                    SET TADRL.FTAddName         = FULLTAX.FTAddName,
                        TADRL.FTAddV1SubDist    = FULLTAX.FTAddV1SubDist,
                        TADRL.FTAddV1DstCode    = FULLTAX.FTAddV1DstCode,
                        TADRL.FTAddV1PvnCode    = FULLTAX.FTAddV1PvnCode,
                        TADRL.FTAddV1PostCode   = FULLTAX.FTAddV1PostCode,
                        TADRL.FTAddV2Desc1      = FULLTAX.FTAddV2Desc1,
                        TADRL.FTAddV2Desc2      = FULLTAX.FTAddV2Desc2,
                        TADRL.FDLastUpdOn       = '$dDocDateTime',
                        TADRL.FTLastUpdBy       = '$tUserCode'
                    FROM TCNMTaxAddress_L TADRL
                    INNER JOIN TPSTTaxHDAddress FULLTAX ON TADRL.FTAddTaxNo = FULLTAX.FTAddTaxNo
                    WHERE FULLTAX.FTBchCode  = '$tBrowseBchCode'
                      AND FULLTAX.FTXshDocNo = '$tTaxNumberFull' 
                      AND TADRL.FNLngID      = $nFNLngID ";
        $this->db->query($tSQL);
    }

    // Create By : Napat(Jame) 01/03/2022
    public function FSaMTAXEventGetDataDisPromotions($paData, $ptType){
        $nLngID = $paData['FNLngID'];
        $tDocNo = $paData['tDocumentNumber'];

        if( $ptType == 'ABB' ){
            $tTable = "TPSTSalPD";
        }else{
            $tTable = "TPSTTaxPD";
        }

        // $tSQL   = " SELECT
        //                 PMTL.FTPmhName,
        //                 DIS.FCXddValue,
        //                 SUMV.FCXddSumValue
        //             FROM $tTable DIS WITH(NOLOCK)
        //             LEFT JOIN TCNTPdtPmtHD_L PMTL WITH(NOLOCK) ON DIS.FTXddRefCode = PMTL.FTPmhDocNo AND PMTL.FNLngID = $nLngID
        //             INNER JOIN (
        //                 SELECT FTXshDocNo,FNXddStaDis,SUM(FCXddValue) AS FCXddSumValue FROM $tTable WITH(NOLOCK) GROUP BY FTXshDocNo,FNXddStaDis
        //             ) SUMV ON SUMV.FTXshDocNo = DIS.FTXshDocNo AND SUMV.FNXddStaDis = DIS.FNXddStaDis
        //             WHERE DIS.FTXshDocNo = '$tDocNo' 
        //               AND DIS.FNXddStaDis = 0
        //             ORDER BY DIS.FNXsdSeqNo ASC ";

        $tSQL = "   SELECT DISTINCT
                        PMTL.FTPmhName AS FTPmhName,
                        DIS.FCXpdDis   AS FCXddValue,
                        (SELECT SUM(FCXpdDisAvg) FROM $tTable WHERE FTXshDocNo = DIS.FTXshDocNo) AS FCXddSumValue
                    FROM $tTable DIS WITH(NOLOCK)
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

    // ดึงข้อมูล vat ตามรายการสินค้า
    // Create By : Napat(Jame) 01/03/2022
    public function FSaMTAXEventGetDataEndBillVat($paData, $ptType){
        $tDocNo = $paData['tDocumentNumber'];

        if( $ptType == 'ABB' ){
            $tTable = "TPSTSalDT";
        }else{
            $tTable = "TPSTTaxDT";
        }

        $tSQL = "   SELECT 
                        ISNULL(DT.FCXsdVatRate,0) AS FCXtdVatRate,
                        SUM(ISNULL(DT.FCXsdVat,0)) AS FCXtdVat
                    FROM $tTable DT WITH(NOLOCK) 
                    WHERE DT.FTXshDocNo = '$tDocNo'
                      AND DT.FTXsdVatType = '1'
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

    
    // ดึงข้อมูลการชำระเงิน
    // Create By: Napat(Jame) 02/03/2021
    public function FSaMTAXGetRCTax($paData, $ptType){
        $tDocNo = $paData['tDocumentNumber'];

        if( $ptType == 'ABB' ){
            $tTable = "TPSTSalRC";
        }else{
            $tTable = "TPSTTaxRC";
        }

        $tSQL = "   SELECT 
                        RC.FTRcvCode,
                        RC.FTRcvName,
                        ISNULL(RC.FTXrcRefNo1,'') AS FTXrcRefNo1,
                        RC.FCXrcNet
                    FROM $tTable RC WITH(NOLOCK) 
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

}
