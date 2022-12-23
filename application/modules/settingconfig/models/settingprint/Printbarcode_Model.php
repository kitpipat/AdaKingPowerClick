<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Last Update : Napat(Jame) 25/11/2022 เปลี่ยนการดึง session เป็น cookies

class Printbarcode_Model extends CI_Model
{
    function FSxMPriBarMoveDataIntoTable($paData)
    {
        // $tIP            = $this->input->ip_address();
        // $tFullHost      = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        // return null;
        // $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        // $bSeleteImport  = $paData['bSeleteImport'];

        // $tSearchAllDocumentPrint      = $this->input->post('tSearchAllDocumentPrint');
        $tPrnBarSheet                       = $paData['aDataWhere']['tPrnBarSheet'];
        $tPrnBarXthDocDateFrom              = $paData['aDataWhere']['tPrnBarXthDocDateFrom'];
        $tPrnBarXthDocDateTo                = $paData['aDataWhere']['tPrnBarXthDocDateTo'];
        $tPrnBarBrowseRptNoFromCode         = $paData['aDataWhere']['tPrnBarBrowseRptNoFromCode'];
        $tPrnBarBrowseRptNoToCode           = $paData['aDataWhere']['tPrnBarBrowseRptNoToCode'];
        $tPrnBarBrowsePdtFromCode           = $paData['aDataWhere']['tPrnBarBrowsePdtFromCode'];
        $tPrnBarBrowsePdtToCode             = $paData['aDataWhere']['tPrnBarBrowsePdtToCode'];
        $tPrnBarBrowsePdtGrpFromCode        = $paData['aDataWhere']['tPrnBarBrowsePdtGrpFromCode'];
        $tPrnBarBrowsePdtGrpToCode          = $paData['aDataWhere']['tPrnBarBrowsePdtGrpToCode'];
        $tPrnBarBrowsePdtTypeFromCode       = $paData['aDataWhere']['tPrnBarBrowsePdtTypeFromCode'];
        $tPrnBarBrowsePdtTypeToCode         = $paData['aDataWhere']['tPrnBarBrowsePdtTypeToCode'];
        $tPrnBarBrowsePdtBrandFromCode      = $paData['aDataWhere']['tPrnBarBrowsePdtBrandFromCode'];
        $tPrnBarBrowsePdtBrandToCode        = $paData['aDataWhere']['tPrnBarBrowsePdtBrandToCode'];
        $tPrnBarBrowsePdtModelFromCode      = $paData['aDataWhere']['tPrnBarBrowsePdtModelFromCode'];
        $tPrnBarBrowsePdtModelToCode        = $paData['aDataWhere']['tPrnBarBrowsePdtModelToCode'];
        $tPrnBarPdtDepartCode               = $paData['aDataWhere']['tPrnBarPdtDepartCode'];
        $tPrnBarPdtClassCode                = $paData['aDataWhere']['tPrnBarPdtClassCode'];
        $tPrnBarPdtSubClassCode             = $paData['aDataWhere']['tPrnBarPdtSubClassCode'];
        $tPrnBarPdtGroupCode                = $paData['aDataWhere']['tPrnBarPdtGroupCode'];
        $tPrnBarPdtComLinesCode             = $paData['aDataWhere']['tPrnBarPdtComLinesCode'];
        $tPrnBarTotalPrint                  = $paData['aDataWhere']['tPrnBarTotalPrint'];
        $tPrnBarPlbCode                     = $paData['aDataWhere']['tPrnBarPlbCode'];

        $nPrnBarStaStartDate                = $paData['aDataWhere']['nPrnBarStaStartDate'];
        $tPrnBarEffectiveDate               = $paData['aDataWhere']['tPrnBarEffectiveDate'];
        $tPRNLblVerGroup                    = $paData['aDataWhere']['tPRNLblVerGroup']; // แยกกลุ่มระหว่าง STD กับโปรเจคอื่น
        $tPRNLblCode                        = $paData['aDataWhere']['tPRNLblCode'];

        if( $tPRNLblVerGroup == 'KPC' ){
            // Fix ภาษาเนื่องจาก KPC Import Master เข้ามา
            if ($tPRNLblCode == 'L003') {
                $nLangPdtName = 2;
            } else {
                $nLangPdtName = 1;
            }
            $nLangUnit      = 1;
            $nLangBrand     = 2;
        }else{
            // STD ใช้ภาษาตามที่ User Login
            $nLangPdtName   = $nLngID;
            $nLangUnit      = $nLngID;
            $nLangBrand     = $nLngID;
        }

        // กรณี KPC รหัส L015 ให้ส่ง Url ไปสร้าง QR Code
        if( $tPRNLblCode == 'L015' ){
            $tSQL = " SELECT TOP 1 FTSysStaUsrValue FROM TSysConfig WITH(NOLOCK) WHERE FTSysCode = 'tCN_PlbUrl' AND FTSysApp = 'CN' AND FTSysKey = 'Company' ";
            $tUrl = $this->db->query($tSQL)->row_array()['FTSysStaUsrValue'];
            $tSesUsrBchCodeDefault = FCNoGetCookieVal("tSesUsrBchCodeDefault");

            $tUrl = str_replace("{FTPdtCode}", "'+CONVERT(VARCHAR,Pdt.FTPdtCode)+'", $tUrl);
            $tUrl = str_replace("{FTBchCode}", "'+CONVERT(VARCHAR,'".$tSesUsrBchCodeDefault."')+'", $tUrl);
            $tUrl = str_replace("{FTPgpCode}", "'+CONVERT(VARCHAR,ISNULL(PGP.FTPgpCode,''))+'", $tUrl);
            
            // https://firster.com/product/{FTPdtCode}/?branch={FTBchCode}&bu={FTPgpCode}
            $tPlbUrl = "'".$tUrl."'";
        }else{
            $tPlbUrl = "''";
        }
        

        // if (
        //     $tPrnBarSheet != '' || $tPrnBarXthDocDateFrom  != '' || $tPrnBarXthDocDateTo  != '' || $tPrnBarBrowseRptNoFromCode  != '' || $tPrnBarBrowseRptNoToCode  != ''
        //     || $tPrnBarBrowsePdtFromCode  != '' || $tPrnBarBrowsePdtToCode  != '' || $tPrnBarBrowsePdtGrpFromCode  != '' || $tPrnBarBrowsePdtGrpToCode  != ''
        //     || $tPrnBarBrowsePdtTypeFromCode  != '' || $tPrnBarBrowsePdtTypeToCode  != '' || $tPrnBarBrowsePdtBrandFromCode  != '' || $tPrnBarBrowsePdtBrandToCode  != ''
        //     || $tPrnBarBrowsePdtModelFromCode  != '' || $tPrnBarBrowsePdtModelToCode  != '' || $tPrnBarPdtDepartCode  != '' || $tPrnBarPdtClassCode  != ''
        //     || $tPrnBarPdtSubClassCode  != '' || $tPrnBarPdtGroupCode  != '' || $tPrnBarPdtComLinesCode  != ''
        // ) {
        //     $nWhereST  = 1;
        // } else {
        //     $nWhereST  = 0;
        // }

        // if ($bSeleteImport == 0) {
            $this->db->where('FTComName', $tFullHost);
            $this->db->delete('TCNTPrnLabelTmp');

            $this->db->where('FTComName', $tFullHost);
            $this->db->delete('TCNTPrnLabelHDTmp');


            switch($tPrnBarSheet){
                case 'Normal':
                    $tPriType = "1";
                    break;
                case 'Promotion':
                    $tPriType = "2";
                    break;
                default:
                    $tPriType = "ALL";                           
            }

            $tWherePri = "";
            $tPri4PDT  = "";

            // ติ๊กเลือก checkbox
            if( $nPrnBarStaStartDate == 1 ){   
                if( $tPrnBarEffectiveDate != "" ){         
                    // เลือกวันที่ที่มีผล
                    $tWherePri .= " AND CONVERT(DATETIME, FDPghDStart) = CONVERT(DATETIME, '".$tPrnBarEffectiveDate."') ";   
                }else{
                    // ไม่เลือกวันที่ที่มีผล
                    $tWherePri .= " AND GETDATE() BETWEEN CONVERT(DATETIME, FDPghDStart) AND CONVERT(DATETIME, FDPghDStop) ";
                }                   
            }else{
                // ไม่ติ๊ก checkbox
                if( $tPrnBarEffectiveDate == "" ){
                    // ไม่เลือกวันที่ที่มีผล
                    $tWherePri .= " AND GETDATE() BETWEEN CONVERT(DATETIME, FDPghDStart) AND CONVERT(DATETIME, FDPghDStop) ";
                }else{                                  
                    // เลือกวันที่ที่มีผล
                    $tWherePri .= " AND CONVERT(DATETIME, '".$tPrnBarEffectiveDate."') BETWEEN CONVERT(DATETIME, FDPghDStart) AND CONVERT(DATETIME, FDPghDStop) ";
                }
            }

            if( $tPriType == "ALL" ){
                $tPri4PDT = "   SELECT FTPdtCode,FTPunCode,MAX(FTPghDocNo) AS FTPghDocNo FROM TCNTPdtPrice4PDT WITH(NOLOCK)
                                WHERE FTPghDocType = '1' ".$tWherePri."
                                GROUP BY FTPdtCode,FTPunCode

                                UNION

                                SELECT FTPdtCode,FTPunCode,MAX(FTPghDocNo) AS FTPghDocNo FROM TCNTPdtPrice4PDT WITH(NOLOCK)
                                WHERE FTPghDocType = '2' ".$tWherePri."
                                GROUP BY FTPdtCode,FTPunCode ";
            }else{
                $tPri4PDT = "   SELECT FTPdtCode,FTPunCode,MAX(FTPghDocNo) AS FTPghDocNo
                                FROM TCNTPdtPrice4PDT WITH(NOLOCK)
                                WHERE FTPghDocType = '".$tPriType."' ".$tWherePri."
                                GROUP BY FTPdtCode,FTPunCode ";
            }

            
            $tSQLSelect = "     INSERT INTO TCNTPrnLabelTmp (FTComName,FTPdtCode,FTPdtName,FTBarCode,FCPdtPrice,FTPlcCode,FDPrnDate,
                                FTPdtContentUnit,FTPlbCode,FNPlbQty,FTPbnDesc,FTPdtTime,FTPdtMfg,FTPdtImporter,FTPdtRefNo,FTPdtValue,
                                FTPlbStaSelect,FTPlbStaImport,FTPlbPriType,FTPlbUrl
                                ,FTPdtNameOth,FTPlbSubDept,FTPlbSellingUnit,FCPdtOldPrice,FTPlbCapFree,FTPlbPdtChain,FTPlbClrName,FTPlbPszName,FDPlbPmtDStart,FDPlbPmtDStop,FTPlbPriPerUnit) ";
            $tSQLSelect .= "    SELECT DISTINCT
                                    '$tFullHost' AS FTComName,
                                    PDT.FTPdtCode,
                                    ISNULL(PDTL.FTPdtName,'N/A') AS FTPdtName, 
                                    BAR.FTBarCode,
                                    ISNULL(PRI.FCPgdPriceRet,0) AS FCPdtPrice,
                                    '' AS FTPlcCode,
                                    GETDATE() AS FDPrnDate,
                                    ISNULL(PCL.FTClrName,'') + ' ' + ISNULL(PSZ.FTPszName,'') AS FTPdtContentUnit,
                                    '' AS FTPlbCode, 
                                    ".$tPrnBarTotalPrint." AS FNPlbQty,
                                    ISNULL(PBNL.FTPbnName,'N/A') AS FTPbnDesc,
                                    'ดูที่ผลิตภัณฑ์' AS FTPdtTime, 
                                    'ดูที่ผลิตภัณฑ์' AS FTPdtMfg,
                                    'บริษัท คิง เพาเวอร์ คลิก จำกัด' AS FTPdtImporter,
                                    PDG.FTPdgRegNo AS FTPdtRefNo,
                                    ISNULL(PSZ.FTPszName,'N/A') AS FTPdtValue,
                                    '1' AS FTPlbStaSelect,
                                    '1' AS FTPlbStaImport,
                                    PRI.FTPghDocType AS FTPlbPriType,
                                    ".$tPlbUrl." AS FTPlbUrl,

                                    /* CASE STD */
                                    ISNULL(PDTL.FTPdtNameOth,'N/A') AS FTPdtNameOth,
                                    ISNULL((SELECT TOP 1 CINF.FTCatName 
                                            FROM TCNMPdtCategory CAT WITH(NOLOCK)
                                            INNER JOIN TCNMPdtCatInfo_L CINF WITH(NOLOCK) ON CAT.FTPdtCat3 = CINF.FTCatCode AND CINF.FNCatLevel = 3 AND CINF.FNLngID = ".$nLngID."
                                            WHERE CAT.FTPdtCode = Pdt.FTPdtCode),'') AS FTPlbSubDept,
                                    ISNULL(PUL.FTPunName,'N/A') AS FTPlbSellingUnit,
                                    ISNULL(BPRI.FCPgdPriceRet,0) AS FCPdtOldPrice,
                                    CONVERT(VARCHAR(25),(CASE WHEN ISNULL(PRI.FTPghDocNo,'') <> '' AND ISNULL(PRI.FTPghDocType,'1') = '2' THEN 'Price Off' ELSE '' END)) AS FTPlbCapFree,
                                    ISNULL(Pdt.FTPgpChain,'N/A') AS FTPlbPdtChain,
                                    ISNULL(PCL.FTClrName,'N/A') AS FTPlbClrName,
                                    ISNULL(PSZ.FTPszName,'N/A') AS FTPlbPszName,
                                    PRI.FDPghDStart AS FDPlbPmtDStart,
                                    PRI.FDPghDStop AS FDPlbPmtDStop,
                                    ISNULL((SELECT TOP 1 CONVERT(VARCHAR,CAST(PRI.FCPgdPriceRet AS NUMERIC(18,".$nOptDecimalShow."))) + '/' + CONVERT(VARCHAR,CAST(PPS.FCPdtUnitFact AS NUMERIC(18,".$nOptDecimalShow."))) + ' ' + PUN.FTPunName 
                                            FROM TCNMPdtPackSize PPS WITH(NOLOCK)
                                            INNER JOIN TCNMPdtUnit_L PUN WITH(NOLOCK) ON PPS.FTPunCode = PUN.FTPunCode AND PPS.FCPdtUnitFact = 1 AND PUN.FNLngID = ".$nLngID."
                                            INNER JOIN TCNTPdtPrice4PDT PRI WITH(NOLOCK) ON PPS.FTPdtCode = PRI.FTPdtCode AND PPS.FTPunCode = PRI.FTPunCode AND PRI.FTPghDocType = '1'
                                            WHERE PPS.FTPdtCode = PDT.FTPdtCode),'') AS FTPlbPriPerUnit
                                    /* END CASE STD */

                                FROM TCNTPdtAdjPriHD AdpHD WITH(NOLOCK) 
                                INNER JOIN TCNTPdtAdjPriDT AdpDT WITH(NOLOCK) ON AdpHD.FTXphDocNo = AdpDT.FTXphDocNo
                                INNER JOIN TCNMPdt Pdt WITH(NOLOCK) ON  PDT.FTPdtCode = AdpDT.FTPdtCode
                                INNER JOIN TCNMPdtPackSize PPS WITH(NOLOCK) ON PPS.FTPdtCode = PDT.FTPdtCode
                                INNER JOIN TCNMPdtBar BAR WITH(NOLOCK) ON BAR.FTPdtCode = PPS.FTPdtCode AND BAR.FTPunCode = PPS.FTPunCode
                                LEFT JOIN TCNMPdtUnit_L PUL WITH(NOLOCK) ON PUL.FTPunCode = PPS.FTPunCode AND PUL.FNLngID = ".$nLangUnit."
                                LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDTL.FTPdtCode = PDT.FTPdtCode AND PDTL.FNLngID = ".$nLangPdtName."
                                INNER JOIN ( 
                                    SELECT PRI.FTPdtCode,PRI.FTPunCode,PRI.FCPgdPriceRet,PRI.FTPghDocType,PRI.FTPghDocNo,PRI.FDPghDStart,PRI.FDPghDStop
                                    FROM TCNTPdtPrice4PDT PRI WITH(NOLOCK)
                                    INNER JOIN ( 
                                        ".$tPri4PDT." 
                                    ) PRI2 ON PRI2.FTPdtCode = PRI.FTPdtCode AND PRI2.FTPunCode = PRI.FTPunCode AND PRI2.FTPghDocNo = PRI.FTPghDocNo
                                ) PRI ON PRI.FTPdtCode = PDT.FTPdtCode AND BAR.FTPunCode = PRI.FTPunCode AND PRI.FTPghDocNo = AdpHD.FTXphDocNo
                                LEFT JOIN ( 
                                    SELECT PRI.FTPdtCode,PRI.FTPunCode,PRI.FCPgdPriceRet,PRI.FTPghDocType,PRI.FTPghDocNo,PRI.FDPghDStart,PRI.FDPghDStop
                                    FROM TCNTPdtPrice4PDT PRI WITH(NOLOCK)
                                    INNER JOIN ( 
                                        SELECT FTPdtCode,FTPunCode,MAX(FTPghDocNo) AS FTPghDocNo FROM TCNTPdtPrice4PDT WITH(NOLOCK)
                                        WHERE FTPghDocType = '1' 
                                        GROUP BY FTPdtCode,FTPunCode
                                    ) PRI2 ON PRI2.FTPdtCode = PRI.FTPdtCode AND PRI2.FTPunCode = PRI.FTPunCode AND PRI2.FTPghDocNo = PRI.FTPghDocNo
                                ) BPRI ON BPRI.FTPdtCode = PDT.FTPdtCode AND BAR.FTPunCode = BPRI.FTPunCode
                                LEFT JOIN TCNMPdtBrand_L PBNL WITH(NOLOCK) ON PBNL.FTPbnCode = PDT.FTPbnCode AND PBNL.FNLngID = ".$nLangBrand."
                                LEFT JOIN TCNMPdtDrug PDG WITH(NOLOCK) ON PDG.FTPdtCode = PDT.FTPdtCode
                                LEFT JOIN TCNMPdtSize_L PSZ WITH(NOLOCK) ON PSZ.FTPszCode = PPS.FTPszCode AND PSZ.FNLngID = ".$nLangPdtName."
                                LEFT JOIN TCNMPdtColor_L PCL WITH(NOLOCK) ON PCL.FTClrCode = PPS.FTClrCode AND PCL.FNLngID = ".$nLangPdtName."
                                LEFT JOIN TCNMPdtGrp  PGP WITH(NOLOCK) ON PGP.FTPgpChain = PDT.FTPgpChain
                                LEFT JOIN TCNMPdtGrp_L PGPL WITH(NOLOCK) ON PGPL.FTPgpChain = PDT.FTPgpChain AND PGPL.FNLngID = ".$nLngID."
                                WHERE AdpHD.FTXphStaApv = '1' AND BAR.FTBarStaUse = '1' AND Pdt.FTPdtStaActive = '1' "; 
                                //1 = $nWhereST AND
                                //LEFT JOIN TCNMPdtCategory CAT WITH(NOLOCK) ON PDT.FTPdtCode = CAT.FTPdtCode

            if ($tPrnBarXthDocDateFrom != '' && $tPrnBarXthDocDateTo != '') {
                $tSQLSelect .= " AND (AdpHD.FDXphDocDate BETWEEN '$tPrnBarXthDocDateFrom 00:00:00.000' AND '$tPrnBarXthDocDateTo 23:59:59.000' OR AdpHD.FDXphDocDate BETWEEN '$tPrnBarXthDocDateTo 00:00:00.000' AND '$tPrnBarXthDocDateFrom 23:59:59.000') ";
            }

            if ($tPrnBarBrowseRptNoFromCode != '' && $tPrnBarBrowseRptNoToCode != '') {
                $tSQLSelect .= " AND (AdpDT.FTXphDocNo BETWEEN '$tPrnBarBrowseRptNoFromCode' AND '$tPrnBarBrowseRptNoToCode' OR AdpDT.FTXphDocNo BETWEEN '$tPrnBarBrowseRptNoToCode' AND '$tPrnBarBrowseRptNoFromCode') ";
            }

            switch($tPrnBarSheet){
                case 'Normal':
                    $tSQLSelect .= " AND AdpHD.FTXphDocType = '1' ";
                    break;
                case 'Promotion':
                    $tSQLSelect .= " AND AdpHD.FTXphDocType = '2' ";
                    break;                            
            }

            //กรองสินค้า
            if ($tPrnBarBrowsePdtFromCode != '' && $tPrnBarBrowsePdtToCode != '') {
                $tSQLSelect .= " AND (Pdt.FTPdtCode Between  '$tPrnBarBrowsePdtFromCode' AND '$tPrnBarBrowsePdtToCode' OR Pdt.FTPdtCode Between  '$tPrnBarBrowsePdtToCode' AND '$tPrnBarBrowsePdtFromCode') ";
            }

            //กรองกลุ่มสินค้า
            if ($tPrnBarBrowsePdtGrpFromCode != '' && $tPrnBarBrowsePdtGrpToCode != '') {
                $tSQLSelect .= " AND (Pdt.FTPgpChain Between  '$tPrnBarBrowsePdtGrpFromCode' AND '$tPrnBarBrowsePdtGrpToCode' OR Pdt.FTPgpChain Between  '$tPrnBarBrowsePdtGrpToCode' AND '$tPrnBarBrowsePdtGrpFromCode') ";
            }

            //กรองประเภทสินค้า
            if ($tPrnBarBrowsePdtTypeFromCode != '' && $tPrnBarBrowsePdtTypeToCode != '') {
                $tSQLSelect .= " AND (Pdt.FTPtyCode Between  '$tPrnBarBrowsePdtTypeFromCode' AND '$tPrnBarBrowsePdtTypeToCode' OR Pdt.FTPtyCode Between  '$tPrnBarBrowsePdtTypeToCode' AND '$tPrnBarBrowsePdtTypeFromCode') ";
            }

            //กรองยี่ห้อ
            if ($tPrnBarBrowsePdtBrandFromCode != '' && $tPrnBarBrowsePdtBrandToCode != '') {
                $tSQLSelect .= " AND (Pdt.FTPbnCode Between  '$tPrnBarBrowsePdtBrandFromCode' AND '$tPrnBarBrowsePdtBrandToCode' OR Pdt.FTPbnCode Between  '$tPrnBarBrowsePdtBrandToCode' AND '$tPrnBarBrowsePdtBrandFromCode') ";
            }

            //กรองรุ่น
            if ($tPrnBarBrowsePdtModelFromCode != '' && $tPrnBarBrowsePdtModelToCode != '') {
                $tSQLSelect .= " AND (Pdt.FTPmoCode Between  '$tPrnBarBrowsePdtModelFromCode' AND '$tPrnBarBrowsePdtModelToCode' OR Pdt.FTPmoCode Between  '$tPrnBarBrowsePdtModelToCode' AND '$tPrnBarBrowsePdtModelFromCode') ";
            }

            //กรองหมวด 1
            if ($tPrnBarPdtDepartCode != '') {
                $tSQLSelect .= " AND Cat.FTPdtCat1 = '$tPrnBarPdtDepartCode' ";
            }

            //กรองหมวด 2
            if ($tPrnBarPdtClassCode != '') {
                $tSQLSelect .= " AND Cat.FTPdtCat2 = '$tPrnBarPdtClassCode' ";
            }

            //กรองหมวด 3
            if ($tPrnBarPdtSubClassCode != '') {
                $tSQLSelect .= " AND Cat.FTPdtCat3 = '$tPrnBarPdtSubClassCode' ";
            }

            //กรองหมวด 4
            if ($tPrnBarPdtGroupCode != '') {
                $tSQLSelect .= " AND Cat.FTPdtCat4 = '$tPrnBarPdtGroupCode' ";
            }

            //กรองหมวด 5
            if ($tPrnBarPdtComLinesCode != '') {
                $tSQLSelect .= " AND Cat.FTPdtCat5 = '$tPrnBarPdtComLinesCode' ";
            }

            $this->db->query($tSQLSelect);
        // }

        // $tSQL = "   SELECT c.* FROM ( SELECT ROW_NUMBER() OVER( ORDER BY rtPrnBarImpDesc DESC,rtPrnBarCode ASC) AS rtRowID, * FROM (
        //                 SELECT  
        //                     FTPdtCode AS rtPrnBarCode, 
        //                     FTPdtName AS rtPrnBarName, 
        //                     FTPdtContentUnit AS rtPrnBarContentUnit, 
        //                     FTBarCode AS rtPrnBarBarCode,
        //                     FTPdtRefNo AS  rtPrnBarPriceType,
        //                     FCPdtPrice AS  rtPrnBarPrice,
        //                     FNPlbQty As  rtPrnBarQTY,
        //                     FTPlbStaSelect AS  rtPrnBarStaSelect,
        //                     FTPlbStaImport   AS     rtPrnBarStaImport, 
        //                     FTPlbImpDesc   AS    rtPrnBarImpDesc,
        //                     FTPbnDesc AS rtPrnBarPbnDesc
        //                     --    FTPlbSellingUnit AS rtPrnBarSellingUnit,
        //                     --    FTPlbType AS rtPrnBarPlbType
        //                 FROM TCNTPrnLabelTmp PLT WITH(NOLOCK)
        //                 WHERE FTComName = '$tFullHost' ";
        // $tSearchList = $paData['tSearchAll'];

        // $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        // print_r($tSQL);
        // $oQuery = $this->db->query($tSQL);
        // if ($oQuery->num_rows() > 0) {
        //     $oList = $oQuery->result();
        //     $aFoundRow = $this->FSnMPriBarGetPageAll(/*$tWhereCode,*/$tSearchList, $nLngID);
        //     $nFoundRow = $aFoundRow[0]->counts;
        //     $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
        //     $aResult = array(
        //         'raItems'       => $oList,
        //         'rnAllRow'      => $nFoundRow,
        //         'rnCurrentPage' => $paData['nPage'],
        //         'rnAllPage'     => $nPageAll,
        //         'rtCode'        => '1',
        //         'rtDesc'        => 'success',
        //     );
        // } else {
        //     //No Data
        //     $aResult = array(
        //         'rnAllRow' => 0,
        //         'rnCurrentPage' => $paData['nPage'],
        //         "rnAllPage" => 0,
        //         'rtCode' => '800',
        //         'rtDesc' => 'data not found',
        //     );
        // }

        // $jResult = json_encode($aResult);
        // $aResult = json_decode($jResult, true);
        // return $aResult;
    }

    function FSaMPriBarListSearch($paData)
    {
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        // return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSortBy    = $paData['tSortBy'];

        $tSesAgnCode = $paData['tSesAgnCode'];
        $tSQL = "   SELECT c.* FROM ( 
                        SELECT 
                            ROW_NUMBER() OVER(ORDER BY $tSortBy) AS rtRowID, * 
                        FROM (
                            SELECT  
                                PLT.FTPdtCode, 
                                PLT.FTPdtName, 
                                PLT.FTPdtContentUnit, 
                                PLT.FTBarCode,
                                PLT.FTPdtRefNo,
                                PLT.FCPdtPrice,
                                PLT.FNPlbQty,
                                PLT.FTPlbStaSelect,
                                PLT.FTPlbStaImport, 
                                PLT.FTPlbImpDesc,
                                PLT.FTPbnDesc,
                                PLT.FTPlbPriType,
                                PDT.FTPgpChain,
                                PDT.FTPtyCode,
                                PDT.FTPbnCode,
                                PDT.FTPmoCode,
                                CAT.FTPdtCat1,
                                CAT.FTPdtCat2,
                                CAT.FTPdtCat3,
                                CAT.FTPdtCat4,
                                CAT.FTPdtCat5
                            FROM TCNTPrnLabelTmp PLT WITH(NOLOCK) 
                            INNER JOIN TCNMPdt PDT WITH(NOLOCK) ON PDT.FTPdtCode = PLT.FTPdtCode
                            LEFT JOIN TCNMPdtCategory CAT WITH(NOLOCK) ON CAT.FTPdtCode = PDT.FTPdtCode
                            WHERE PLT.FTComName =  '$tFullHost' ";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND (PLT.FTPdtCode LIKE '%$tSearchList%'";
            $tSQL .= " OR PLT.FTPdtName LIKE '%$tSearchList%')";
        }
        $tSQL .= " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMPriBarGetPageAllSearch(/*$tWhereCode,*/$tSearchList, $nLngID);
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

    public function FSnMPriBarGetPageAllSearch($ptSearchList, $ptLngID)
    {

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        $tSQL = "   SELECT COUNT (FTBarCode) AS counts
                    FROM TCNTPrnLabelTmp PLT WITH(NOLOCK)
                    WHERE FTComName =  '$tFullHost'";

        if ($ptSearchList != '') {
            $tSQL .= " AND (FTPdtCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR FTPdtName LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }




    /**
     * Functionality : All Page Of Printer BarCode
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMPriBarGetPageAll($ptSearchList, $ptLngID)
    {

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        $tSQL = "SELECT COUNT (FTBarCode) AS counts
          FROM [TCNTPrnLabelTmp] PLT 
            WHERE 1=1 AND FTComName =  '$tFullHost'";


        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }



    function FSaMPriBarUpdateEditInLine($nValue, $tPdtCode, $tPdtBarCode, $tPriType)
    {
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        $this->db->set('FNPlbQty', $nValue);
        $this->db->where('FTPdtCode', $tPdtCode);
        $this->db->where('FTBarCode',  $tPdtBarCode);
        $this->db->where('FTPlbPriType', $tPriType);
        $this->db->where('FTComName', $tFullHost);
        $this->db->update('TCNTPrnLabelTmp');
    }

    function FSaMPriBarUpdateCheckedAll($bCheckedAll)
    {
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');


        if ($bCheckedAll == 'true') {
            $bCheckedAllUp = 1;
        } else {
            $bCheckedAllUp = NULL;
        }
        $this->db->set('FTPlbStaSelect', $bCheckedAllUp);
        $this->db->where('FTComName', $tFullHost);
        $this->db->where('FTPlbStaImport', 1);
        $this->db->update('TCNTPrnLabelTmp');
    }

    // Last Update: Napat(Jame) 27/07/2022 Where PriType เพิ่ม
    function FSaMPriBarUpdateChecked($tValueChecked, $tPdtCode, $tBarCode, $ptPriType)
    {
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        if ($tValueChecked == 'true') {
            $bCheckedUp = 1;
        } else {
            $bCheckedUp = NULL;
        }

        $this->db->set('FTPlbStaSelect', $bCheckedUp);
        $this->db->where('FTComName', $tFullHost);
        $this->db->where('FTPlbPriType', $ptPriType);
        $this->db->where('FTPdtCode', $tPdtCode);
        $this->db->where('FTBarCode', $tBarCode);
        $this->db->update('TCNTPrnLabelTmp');
    }


    function FSaMPriBarUpdateLableCode($tPrnBarPrnLableCode)
    {

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        $this->db->set('FTPlbCode', $tPrnBarPrnLableCode);
        $this->db->where('FTComName', $tFullHost);
        $this->db->update('TCNTPrnLabelTmp');
    }


    function FSaMPriBarListDataMQ($ptPriType,$pnPageReq){
        try {

            // $tIP = $this->input->ip_address();
            // $tFullHost = gethostbyaddr($tIP);
            $tFullHost      = FCNoGetCookieVal('tSesSessionID');

            $tSQLDT     = " SELECT 
                                FTComName,FTPdtCode,FTPdtName,FTBarCode,FTPlcCode,GETDATE() AS FDPrnDate,FTPdtContentUnit,FTPlbCode,FNPlbQty,
                                FTPdtTime,FTPdtMfg,FTPdtImporter,FTPdtRefNo,FTPdtValue,FTPbnDesc,FTPdtNameOth,FTPlbSubDept,FTPlbRepleType,
                                FTPlbPriStatus,FTPlbSellingUnit,FCPdtPrice,FCPdtOldPrice,FTPlbPhasing,FTPlbPriPerUnit,FTPlbCapFree,
                                FTPlbPdtChain,FTPlbCapNamePmt,FTPlbPmtInterval,FCPlbPmtGetCond,FCPlbPmtGetValue,FDPlbPmtDStart,FDPlbPmtDStop,
                                FTPlbPmtCode,FCPlbPmtBuyQty,FTPlbClrName,FTPlbPszName,FTPlbPriType,FTPlbStaImport,FTPlbImpDesc,FTPlbUrl,FTPlbStaSelect 
                            FROM TCNTPrnLabelTmp WITH(NOLOCK) 
                            WHERE FTComName = '$tFullHost' AND FTPlbPriType = '$ptPriType' AND  FTPlbStaSelect = '1'
                            AND FTBarCode IN (SELECT FTBarCode FROM TCNTPrnLabelHDTmp WITH(NOLOCK) WHERE FTComName = '$tFullHost' AND FTPlbPriType = '$ptPriType' AND FNPage = $pnPageReq AND  FTPlbStaSelect = '1') ";
            $oQueryDT   = $this->db->query($tSQLDT);

            $tSQLHD     = " SELECT FTComName,FTPlbPriType,FNPage,FNSeq,FTBarCode,FTPdtName,FTPdtContentUnit,FNPlbQty,FTPlbStaSelect
                            FROM TCNTPrnLabelHDTmp WITH(NOLOCK) WHERE FTComName = '$tFullHost' AND FTPlbPriType = '$ptPriType' AND FNPage = $pnPageReq AND  FTPlbStaSelect = '1' ";
            $oQueryHD   = $this->db->query($tSQLHD);

            if( $oQueryDT->num_rows() > 0 && $oQueryHD->num_rows() > 0 ){
                // $oDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'       => array(
                        'raTCNTPrnLabelTmp'     => $oQueryDT->result_array(),
                        'raTCNTPrnLabelHDTmp'   => $oQueryHD->result_array(),
                    ),
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
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }



    function FSaMPriBarClearDataMQ()
    {
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        $this->db->where('FTComName', $tFullHost);
        $this->db->delete('TCNTPrnLabelTmp');
    }



    public function FSaMPRIGetTempData($paDataSearch)
    {
        $nLngID             = $paDataSearch['nLangEdit'];
        $tTableKey          = $paDataSearch['tTableKey'];
        $tSessionID         = $paDataSearch['tSessionID'];
        $tTextSearch        = $paDataSearch['tTextSearch'];

        $tSQL   = " SELECT
                        IMP.FNTmpSeq,
                        IMP.FTBchCode,
                        IMP.FTBchName,
                        IMP.FTAgnCode,
                        AGN_L.FTAgnName,
                        IMP.FTPplCode,
                        PRI_L.FTPplName,
                        IMP.FTTmpStatus,
                        IMP.FTTmpRemark
                    FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                    LEFT JOIN TCNMAgency_L		AGN_L WITH(NOLOCK) ON IMP.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtPriList_L	PRI_L WITH(NOLOCK) ON IMP.FTPplCode = PRI_L.FTPplCode AND PRI_L.FNLngID = $nLngID
                    WHERE IMP.FTSessionID = '$tSessionID' AND FTTmpTableKey = '$tTableKey'
        ";

        if ($tTextSearch != '' || $tTextSearch != null) {
            $tSQL .= " AND (IMP.FTBchCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTBchName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTAgnCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR AGN_L.FTAgnName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTPplCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR PRI_L.FTPplName LIKE '%$tTextSearch%' ";
            $tSQL .= " )";
        }

        $tSQL .= " ORDER BY IMP.FTBchCode";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aStatus = array(
                'tCode'     => '1',
                'tDesc'     => 'success',
                'aResult'   => $oQuery->result_array(),
                'numrow'    => $oQuery->num_rows()
            );
        } else {
            $aStatus = array(
                'tCode'     => '99',
                'tDesc'     => 'Error',
                'aResult'   => array(),
                'numrow'    => 0
            );
        }
        return $aStatus;
    }

    //Functionality : Delete Import Branch
    //Parameters : function parameters
    //Create By : 09/07/2020 Napat(Jame)
    //Return : response
    //Return Type : array
    public function FSaMPRIImportDelete($paParamMaster)
    {
        try {
            $this->db->where_in('FNTmpSeq', $paParamMaster['FNTmpSeq']);
            $this->db->delete('TCNTImpMasTmp');

            if ($this->db->trans_status() === FALSE) {
                $aStatus = array(
                    'tCode' => '905',
                    'tDesc' => 'Cannot Delete Item.',
                );
            } else {
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    public function FSaMPRIImportMove2Master($paDataSearch)
    {
        try {
            $nLngID         = $paDataSearch['nLangEdit'];
            $tTableKey      = $paDataSearch['tTableKey'];
            $tSessionID     = $paDataSearch['tSessionID'];
            $dDateOn        = $paDataSearch['dDateOn'];
            $tUserBy        = $paDataSearch['tUserBy'];

            $dBchDateStart  = $paDataSearch['dBchDateStart'];
            $dBchDateStop  = $paDataSearch['dBchDateStop'];

            $tSQL   = " INSERT INTO TCNMBranch (
                            FTBchCode,FTAgnCode,FTPplCode,FTWahCode,FTBchType,FTBchPriority,FTBchStaActive,
                            FDBchStart,FDBchStop,FDBchSaleStart,FDBchSaleStop,
                            FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                        )
                        SELECT
                            IMP.FTBchCode,
                            IMP.FTAgnCode,
                            IMP.FTPplCode,
                            '00001',
                            CASE WHEN ISNULL(IMP.FTAgnCode,'') = '' THEN '1' ELSE '4' END AS FTBchType,
                            '1',
                            '1',
                            '$dBchDateStart',
                            '$dBchDateStop',
                            '$dBchDateStart',
                            '$dBchDateStop',
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            $tSQL   = " INSERT INTO TCNMBranch_L (FTBchCode,FNLngID,FTBchName)
                        SELECT
                            IMP.FTBchCode,
                            $nLngID,
                            IMP.FTBchName
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            if ($this->db->trans_status() === FALSE) {
                $aStatus = array(
                    'tCode'     => '99',
                    'tDesc'     => 'Error'
                );
            } else {
                $aStatus = array(
                    'tCode'     => '1',
                    'tDesc'     => 'success'
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //เพิ่มคลังกรณี import file สาขา
    public function FSaMPRIImportMove2MasterAndInsWah($paDataSearch)
    {
        try {
            $tSessionID     = $paDataSearch['tSessionID'];
            $dDateOn        = $paDataSearch['dDateOn'];
            $tUserBy        = $paDataSearch['tUserBy'];
            $tTableKey      = $paDataSearch['tTableKey'];

            //Insert ลงตาราง TCNMWaHouse
            $tSQL   = " INSERT INTO TCNMWaHouse (FTBchCode,FTWahCode,FTWahStaType,FTWahRefCode,FTWahStaChkStk,FTWahStaPrcStk,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                        SELECT PACKDATA.*
                        FROM TCNTImpMasTmp Tmp
                        CROSS APPLY (
                            VALUES
                                (FTBchCode,'00001',1,FTBchCode,'1','2','$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                        ) PACKDATA (FTBchCode,FTWahCode,FTWahStaType,FTWahRefCode,FTWahStaChkStk,FTWahStaPrcStk,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                        WHERE Tmp.FTSessionID = '$tSessionID' AND Tmp.FTTmpStatus = '1' ";
            /*
                        , (FTBchCode,'00002',1,FTBchCode,'$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                        , (FTBchCode,'00003',1,FTBchCode,'$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                        */
            $this->db->query($tSQL);

            //Insert ลงตาราง TCNMWaHouse_L
            $tSQL   = " INSERT INTO TCNMWaHouse_L (FTBchCode,FTWahCode,FNLngID,FTWahName)
                        SELECT PACKDATA.*
                        FROM TCNTImpMasTmp Tmp
                        CROSS APPLY (
                            VALUES
                                (FTBchCode,'00001','1','คลังขาย'),
                                (FTBchCode,'00001','2','Sales Warehouse')
                        ) PACKDATA (FTBchCode,FTWahCode,FNLngID,FTWahName)
                        WHERE Tmp.FTSessionID = '$tSessionID' AND Tmp.FTTmpStatus = '1' ";
            /*
                        , (FTBchCode,'00002','1','คลังของเสีย')
                        , (FTBchCode,'00003','1','คลังของแถม')
                        , (FTBchCode,'00002','2','Waste warehouse')
                        , (FTBchCode,'00003','2','Free inventory')
                        */
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //เช็คกรณีข้อมูลซ้ำ
    public function FSaMPRIImportMove2MasterAndReplaceOrInsert($paDataSearch)
    {
        try {
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $tTableKey          = $paDataSearch['tTableKey'];
            $tTypeCaseDuplicate = $paDataSearch['tTypeCaseDuplicate'];
            $nLngID             = $paDataSearch['nLangEdit'];
            $dBchDateStart      = $paDataSearch['dBchDateStart'];
            $dBchDateStop       = $paDataSearch['dBchDateStop'];

            if ($tTypeCaseDuplicate == 2) {
                //อัพเดทรายการเดิม

                //อัพเดทชื่อที่ตาราง L
                $tSQLUpdate_L = "UPDATE
                                    TCNMBranch_L
                                SET
                                    TCNMBranch_L.FTBchName = TCNTImpMasTmp.FTBchName
                                FROM
                                    TCNMBranch_L
                                INNER JOIN
                                    TCNTImpMasTmp
                                ON
                                    TCNMBranch_L.FTBchCode = TCNTImpMasTmp.FTBchCode
                                WHERE
                                    TCNTImpMasTmp.FTSessionID = '$tSessionID'
                                AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMBranch'
                                AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQLUpdate_L);

                //อัพเดทตัวแทนขาย กับ กลุ่มราคา
                $tSQLUpdate = "UPDATE
                                    TCNMBranch
                                SET
                                    TCNMBranch.FTPplCode = TCNTImpMasTmp.FTPplCode,
                                    TCNMBranch.FTAgnCode = TCNTImpMasTmp.FTAgnCode,
                                    TCNMBranch.FDLastUpdOn = '$dDateOn',
                                    TCNMBranch.FTLastUpdBy = '$tUserBy'
                                FROM
                                    TCNMBranch
                                INNER JOIN
                                    TCNTImpMasTmp
                                ON
                                    TCNMBranch.FTBchCode = TCNTImpMasTmp.FTBchCode
                                WHERE
                                    TCNTImpMasTmp.FTSessionID = '$tSessionID'
                                AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMBranch'
                                AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQLUpdate);
            } else if ($tTypeCaseDuplicate == 1) {
                //ใช้รายการใหม่

                //ลบข้อมูลในตาราง L
                $tSQLDeleteBch_L = "DELETE FROM TCNMBranch_L WHERE FTBchCode IN (
                                    SELECT FTBchCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMBranch'
                                )";
                $this->db->query($tSQLDeleteBch_L);

                //ลบข้อมูลในตารางจริง
                $tSQLDeleteBch = "DELETE FROM TCNMBranch WHERE FTBchCode IN (
                                        SELECT FTBchCode
                                        FROM TCNTImpMasTmp
                                        WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMBranch'
                                    )";
                $this->db->query($tSQLDeleteBch);



                //เพิ่มข้อมูลที่เป็น BCH Type 6
                $tSQL   = " INSERT INTO TCNMBranch (
                                FTBchCode,FTAgnCode,FTPplCode,FTWahCode,
                                FDBchStart,FDBchStop,FDBchSaleStart,FDBchSaleStop,
                                FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                            )
                            SELECT
                                IMP.FTBchCode,
                                IMP.FTAgnCode,
                                IMP.FTPplCode,
                                '',
                                '$dBchDateStart',
                                '$dBchDateStop',
                                '$dBchDateStart',
                                '$dBchDateStop',
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลที่เป็น BCH_L Type 6
                $tSQL   = " INSERT INTO TCNMBranch_L (FTBchCode,FNLngID,FTBchName)
                            SELECT
                                IMP.FTBchCode,
                                $nLngID,
                                IMP.FTBchName
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID       = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);
            }
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //ลบข้อมูลใน Temp
    public function FSaMPRIImportMove2MasterDeleteTemp($paDataSearch)
    {
        try {
            $tSessionID     = $paDataSearch['tSessionID'];
            $dDateOn        = $paDataSearch['dDateOn'];
            $tUserBy        = $paDataSearch['tUserBy'];
            $tTableKey      = $paDataSearch['tTableKey'];

            // ลบรายการใน Temp
            $this->db->where('FTSessionID', $tSessionID);
            $this->db->where('FTTmpTableKey', $tTableKey);
            $this->db->delete('TCNTImpMasTmp');
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Get ข้อมูลใน Temp ทั้งหมด
    public function FSaMPRIGetTempDataAtAll()
    {
        try {
            $tSesSessionID = FCNoGetCookieVal("tSesSessionID");
            $tSQL   = "SELECT TOP 1
                        (SELECT COUNT(FTTmpTableKey) AS TYPESIX FROM TCNTImpMasTmp IMP
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMBranch'
                        AND IMP.FTTmpStatus       = '6') AS TYPESIX ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMBranch'
                        AND IMP.FTTmpStatus       = '1') AS TYPEONE ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMBranch'
                        ) AS ITEMALL
                    FROM TCNTImpMasTmp ";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Create By: Napat(Jame) 26/07/2022
    public function FSaMPRNGetAllData($pnPrnType){

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');
        $oSortBy        = get_cookie('AdaBarPrintSort');
        if( $oSortBy === NULL ){
            $tSortBy = "FTPdtCode ASC";
        }else{
            $aSortBy = json_decode($oSortBy, TRUE);
            $tSortBy = $aSortBy['tSortCode'];
        }

        $tSortBy = str_replace("FTPdtCode","PDT.FTPdtCode",$tSortBy);
        $tSortBy = str_replace("FTPgpChain","PDT.FTPgpChain",$tSortBy);
        $tSortBy = str_replace("FTPtyCode","PDT.FTPtyCode",$tSortBy);
        $tSortBy = str_replace("FTPbnCode","PDT.FTPbnCode",$tSortBy);
        $tSortBy = str_replace("FTPmoCode","PDT.FTPmoCode",$tSortBy);

        $tSortBy = str_replace("FTPdtCat1","CAT.FTPdtCat1",$tSortBy);
        $tSortBy = str_replace("FTPdtCat2","CAT.FTPdtCat2",$tSortBy);
        $tSortBy = str_replace("FTPdtCat3","CAT.FTPdtCat3",$tSortBy);
        $tSortBy = str_replace("FTPdtCat4","CAT.FTPdtCat4",$tSortBy);
        $tSortBy = str_replace("FTPdtCat5","CAT.FTPdtCat5",$tSortBy);

        // เคลียร์ tmp ก่อน insert
        $this->db->where('FTPlbPriType', $pnPrnType);
        $this->db->where('FTComName', $tFullHost);
        $this->db->delete('TCNTPrnLabelHDTmp');

        $tSQL = "   SELECT 
                        PLT.FTComName,PLT.FTPlbPriType,0 AS FNPage,0 AS FNSeq,
                        PLT.FTBarCode,PLT.FTPdtName,PLT.FTPdtContentUnit,PLT.FNPlbQty,'1' AS FTPlbStaSelect
                    FROM TCNTPrnLabelTmp PLT WITH(NOLOCK)
                    INNER JOIN TCNMPdt PDT WITH(NOLOCK) ON PDT.FTPdtCode = PLT.FTPdtCode
                    LEFT JOIN TCNMPdtCategory CAT WITH(NOLOCK) ON CAT.FTPdtCode = PDT.FTPdtCode
                    WHERE PLT.FTComName =  '$tFullHost' 
                      AND PLT.FTPlbPriType = '".$pnPrnType."' 
                      AND PLT.FTPlbStaSelect = '1'
                    ORDER BY $tSortBy
                ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        } else {
            return array();
        }
    }

    // Create By: Napat(Jame) 27/07/2022
    public function FSxMPRNEventGenHD($paData){

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        // insert
        $this->db->insert_batch('TCNTPrnLabelHDTmp', $paData['aNewData']); 
    }

    // Create By: Napat(Jame) 27/07/2022
    public function FSaMPRNGetDataHDTmp($pnPrnType){

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        $tSQL = "   SELECT 
                        ROW_NUMBER() OVER(PARTITION BY FNPage ORDER BY FNPage, FNSeq) AS FNGroupPage,
	                    SUM(1) OVER(PARTITION BY FNPage) AS FNGroupPageMax,
                        FTPlbPriType,FNPage,FNSeq,FTBarCode,FTPdtName,
                        FTPdtContentUnit,FNPlbQty,FTPlbStaSelect
                    FROM TCNTPrnLabelHDTmp WITH(NOLOCK)
                    WHERE FTComName = '".$tFullHost."' AND FTPlbPriType = '".$pnPrnType."' 
                    ORDER BY FNSeq ASC
                ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'found data',
            );
        } else {
            $aResult = array(
                'tCode'        => '800',
                'tDesc'        => 'not found data',
            );
        }
        return $aResult;
    }

    
    // Create By: Napat(Jame) 27/07/2022
    public function FSaMPRNGetSummaryHDTmp($pnPrnType){

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        $tSQL = "   SELECT DISTINCT
                        ISNULL(QTY.FNSumQty,0) AS FNSumQty,
                        -- ISNULL(PDT.FNSumPdt,0) AS FNSumPdt,
                        ISNULL(PALL.FNPageAll,0) AS FNPageAll,
                        ISNULL(PSEL.FNPageSel,0) AS FNPageSel
                    FROM TCNTPrnLabelHDTmp HD WITH(NOLOCK)
                    LEFT JOIN (
                        SELECT FTComName,FTPlbPriType,SUM(FNPlbQty) AS FNSumQty
                        FROM TCNTPrnLabelHDTmp WITH(NOLOCK)
                        WHERE FTPlbStaSelect = '1'
                        GROUP BY FTComName,FTPlbPriType
                    ) QTY ON HD.FTComName = QTY.FTComName AND HD.FTPlbPriType = QTY.FTPlbPriType
                    -- LEFT JOIN (
                    --     SELECT DISTINCT FTComName,FTPlbPriType,SUM(1) OVER(PARTITION BY FTComName,FTPlbPriType) AS FNSumPdt
                    --     FROM TCNTPrnLabelHDTmp WITH(NOLOCK)
                    --     WHERE FTPlbStaSelect = '1'
                    --     GROUP BY FTComName,FTPlbPriType,FTBarCode
                    -- ) PDT ON HD.FTComName = PDT.FTComName AND HD.FTPlbPriType = PDT.FTPlbPriType
                    LEFT JOIN (
                        SELECT DISTINCT FTComName,FTPlbPriType,SUM(1) OVER(PARTITION BY FTComName,FTPlbPriType) AS FNPageAll
                        FROM TCNTPrnLabelHDTmp WITH(NOLOCK)
                        GROUP BY FTComName,FTPlbPriType,FNPage
                    ) PALL ON HD.FTComName = PALL.FTComName AND HD.FTPlbPriType = PALL.FTPlbPriType
                    LEFT JOIN (
                        SELECT DISTINCT FTComName,FTPlbPriType,SUM(1) OVER(PARTITION BY FTComName,FTPlbPriType) AS FNPageSel
                        FROM TCNTPrnLabelHDTmp WITH(NOLOCK)
                        WHERE FTPlbStaSelect = '1'
                        GROUP BY FTComName,FTPlbPriType,FNPage
                    ) PSEL ON HD.FTComName = PSEL.FTComName AND HD.FTPlbPriType = PSEL.FTPlbPriType
                    WHERE HD.FTComName = '".$tFullHost."' AND HD.FTPlbPriType = '".$pnPrnType."' AND HD.FTPlbStaSelect = '1'
                ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'aItems'       => $oQuery->row_array(),
                'tCode'        => '1',
                'tDesc'        => 'found data',
            );
        } else {
            $aResult = array(
                'tCode'        => '800',
                'tDesc'        => 'not found data',
            );
        }
        return $aResult;
    }

    // Create By: Napat(Jame) 27/07/2022
    public function FSxMPRNUpdStaSelHDTmp($paData){
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        if( $paData['tValueChecked'] == 'true' ){
            $bCheckedUp = 1;
        } else {
            $bCheckedUp = NULL;
        }

        $this->db->set('FTPlbStaSelect', $bCheckedUp);
        $this->db->where('FTComName', $tFullHost);
        $this->db->where('FTPlbPriType', $paData['tPriType']);
        if( $paData['tSelType'] == 'One' ){
            $this->db->where('FNPage', $paData['nPage']);
        }
        $this->db->update('TCNTPrnLabelHDTmp');
    }

    // Create By: Napat(Jame) 08/08/2022
    public function FSaMPRNGetPageInPriType(){
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost      = FCNoGetCookieVal('tSesSessionID');

        // $tSQL = " SELECT FTPlbPriType,MAX(FNPage) AS FNMaxPage FROM TCNTPrnLabelHDTmp WITH(NOLOCK) WHERE FTComName = '".$tFullHost."' AND FTPlbStaSelect = '1' GROUP BY FTPlbPriType ";
        $tSQL = " SELECT FTPlbPriType,ROW_NUMBER() OVER(PARTITION BY FTPlbPriType ORDER BY FNPage ASC) AS FNSeqSend,FNPage,SUM(1) OVER(PARTITION BY FTPlbPriType) AS FNMaxPage FROM TCNTPrnLabelHDTmp WITH(NOLOCK) WHERE FTComName = '".$tFullHost."' AND FTPlbStaSelect = '1' GROUP BY FTPlbPriType,FNPage ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'found data',
            );
        } else {
            $aResult = array(
                'tCode'        => '800',
                'tDesc'        => 'not found data',
            );
        }
        return $aResult;
    }

    // Create By: Napat(Jame) 01/12/2022
    // กรณี KPC รหัส L015 ให้ส่ง Url ไปสร้าง QR Code
    public function FSxMPRNUpdPlbUrl(){
        $tSQL = " SELECT TOP 1 FTSysStaUsrValue FROM TSysConfig WITH(NOLOCK) WHERE FTSysCode = 'tCN_PlbUrl' AND FTSysApp = 'CN' AND FTSysKey = 'Company' ";
        $tUrl = $this->db->query($tSQL)->row_array()['FTSysStaUsrValue'];
        $tSesUsrBchCodeDefault = FCNoGetCookieVal("tSesUsrBchCodeDefault");

        $tUrl = str_replace("{FTPdtCode}", "'+CONVERT(VARCHAR,Pdt.FTPdtCode)+'", $tUrl);
        $tUrl = str_replace("{FTBchCode}", "'+CONVERT(VARCHAR,'".$tSesUsrBchCodeDefault."')+'", $tUrl);
        $tUrl = str_replace("{FTPgpCode}", "'+CONVERT(VARCHAR,ISNULL(PGP.FTPgpCode,''))+'", $tUrl);
        
        // https://firster.com/product/{FTPdtCode}/?branch={FTBchCode}&bu={FTPgpCode}
        
        $tFullHost  = FCNoGetCookieVal('tSesSessionID');
        $tSQL2      = " UPDATE TCNTPrnLabelTmp
                        SET TCNTPrnLabelTmp.FTPlbUrl = '".$tUrl."'
                        FROM TCNTPrnLabelTmp TMP WITH(NOLOCK)
                        INNER JOIN TCNMPdt PDT WITH(NOLOCK) ON  PDT.FTPdtCode = TMP.FTPdtCode
                        LEFT JOIN TCNMPdtGrp  PGP WITH(NOLOCK) ON PGP.FTPgpChain = PDT.FTPgpChain
                        WHERE TMP.FTComName = '$tFullHost' ";
        $this->db->query($tSQL2);
    }

}
