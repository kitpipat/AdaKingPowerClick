<?php
defined('BASEPATH') or exit('No direct script access allowed');

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class mCommon extends CI_Model
{
    //Functionality : Function Update Password User Login
    //Parameters : usrlogin , oldpass , newpass
    //Creator : 13/05/2020 Napat(Jame)
    // Last Update : 16/11/2020 Napat(Jame) เพิ่มการตรวจสอบ Error Message
    //Last Modified : -
    //Return : Status Update Password
    //Return Type : Array
    public function FCNaMCMMChangePassword($paPackData)
    {
        try {


            $tSQL = "   SELECT TOP 1
                            A.*,
                            CASE 
                                WHEN ISNULL(B.FTUsrLogin,'')     = '' THEN '999'  /*ไม่พบชื่อผู้ใช้*/
                                WHEN ISNULL(C.FTUsrLoginPwd,'')  = '' THEN '998'  /*รหัสผ่านเดิมไม่ถูกต้อง*/
                                WHEN ISNULL(B.FTUsrStaActive,'') = '2' THEN '997' /*สถานะไม่ใช้งาน ไม่สามารถเปลี่ยนรหัสผ่าน*/
                                WHEN CONVERT(VARCHAR(10),GETDATE(),121) > CONVERT(VARCHAR(10),B.FDUsrPwdExpired,121) THEN '996' /*หมดอายุไม่สามารถเปลี่ยนรหัสผ่าน*/
                                ELSE '0'
                            END AS FTErrMsg 
                        FROM (
                            SELECT '1' AS Seq
                        ) A
                        LEFT JOIN TCNMUsrLogin B WITH(NOLOCK) ON B.FTUsrLogin = '" . $paPackData['FTUsrLogin'] . "' AND B.FTUsrLogType  = '" . $paPackData['tStaLogType'] . "'
                        LEFT JOIN TCNMUsrLogin C WITH(NOLOCK) ON C.FTUsrLogin = '" . $paPackData['FTUsrLogin'] . "' AND C.FTUsrLoginPwd = '" . $paPackData['tPasswordOld'] . "'
                    ";

            $oQuery     = $this->db->query($tSQL);
            $aListData  = $oQuery->result_array();

            if ($aListData[0]['FTErrMsg'] == '0') {
                // ถ้าส่ง parameters UsrStaActive = 3 คือ เปลี่ยนรหัสผ่าน ครั้งแรก
                // ให้ปรับสถานะ = 1 เพื่อเริ่มใช้งาน
                if ($paPackData['nChkUsrSta'] == 3) {
                    $this->db->set('FTUsrStaActive', '1');
                }

                $this->db->set('FTUsrLoginPwd', $paPackData['tPasswordNew']);
                $this->db->where('FTUsrLogin', $paPackData['FTUsrLogin']);
                $this->db->where('FTUsrLoginPwd', $paPackData['tPasswordOld']);
                $this->db->update('TCNMUsrLogin');

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'nCode'     => 1,
                        'tDesc'     => 'Update Password Success',
                    );
                } else {
                    $aStatus = array(
                        'nCode'     => 905,
                        'tDesc'     => 'Error Cannot Update Password.',
                    );
                }
            } else {
                $aStatus = array(
                    'nCode'     => $aListData[0]['FTErrMsg'],
                    'tDesc'     => 'Data false',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Delete
    public function FCNaMCMMDeleteTmpExcelCasePDT($paPackData)
    {
        try {
            $aWhere = array('TCNMPdt', 'TCNMPdtUnit', 'TCNMPdtBrand', 'TCNMPdtTouchGrp', 'TCNMPdtType', 'TCNMPdtModel', 'TCNMPdtGrp', 'TCNMPdtSpcBch');
            $this->db->where_in('FTTmpTableKey', $aWhere);
            $this->db->where_in('FTSessionID', $paPackData['tSessionID']);
            $this->db->delete($paPackData['tTableNameTmp']);
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Import Excel To Temp
    public function FCNaMCMMImportExcelToTmp($paPackData, $poIns)
    {
        try {

            $tTableNameTmp      = $paPackData['tTableNameTmp'];
            $tNameModule        = $paPackData['tNameModule'];
            $tTypeModule        = $paPackData['tTypeModule'];
            $tFlagClearTmp      = $paPackData['tFlagClearTmp'];
            $tTableRefPK        = $paPackData['tTableRefPK'];

            //ลบข้อมูลทั้งหมดก่อน
            if ($tTypeModule == 'document' && $tFlagClearTmp == 1) {
                //ลบช้อมูลของ document
                if ($tTableNameTmp == 'TCNTPrnLabelTmp') {
                    $tIP = $this->input->ip_address();
                    $tFullHost = gethostbyaddr($tIP);
                    $this->db->where_in('FTComName', $tFullHost);
                    $this->db->delete($tTableNameTmp);
                } else {
                    $this->db->where_in('FTXthDocKey', $tTableRefPK);
                    $this->db->where_in('FTSessionID', $paPackData['tSessionID']);
                    $this->db->delete($tTableNameTmp);
                }
            } else if ($tTypeModule == 'master' && $tFlagClearTmp == 1) {
                //ลบข้อมูลของ master
                if ($tNameModule != 'product') {
                    $this->db->where_in('FTTmpTableKey', $tTableRefPK);
                    $this->db->where_in('FTSessionID', $paPackData['tSessionID']);
                    $this->db->delete($tTableNameTmp);
                }
            }

            //เพิ่มข้อมูล
            // echo "<pre>"; print_r($poIns); echo "</pre>";
            if( FCNnHSizeOf($poIns) > 0 ){
                $this->db->insert_batch($tTableNameTmp, $poIns);
            }

            // $tTableNameTmp, $poIns
            // echo "<pre>"; print_r($tTableNameTmp); print_r($poIns); echo "</pre>";

            /*เพิ่มข้อมูล
             $tNameProject   = explode('/', $_SERVER['REQUEST_URI'])[1];
             $tPathFileBulk  = $_SERVER['DOCUMENT_ROOT'].'/'.$tNameProject.'/application/modules/common/assets/writeFileImport/FileImport_Branch.txt';
             $tSQL = "BULK INSERT dbo.TCNTImpMasTmp FROM '".$tPathFileBulk."'
                     WITH
                     (
                         FIELDTERMINATOR=',',
                         ROWTERMINATOR = '\n'
            )";*/
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Import Excel To Temp
    public function FCNaMCMMImportExcelToFhnTmp($paPackData, $poIns)
    {
        try {

            $tTableFhnNameTmp   = $paPackData['tTableFhnNameTmp'];
            $tNameModule        = $paPackData['tNameModule'];
            $tTypeModule        = $paPackData['tTypeModule'];
            $tFlagClearTmp      = $paPackData['tFlagClearTmp'];
            $tTableRefPK        = $paPackData['tTableRefPK'];

            //ลบช้อมูลของ document
            $this->db->where_in('FTXthDocKey', $tTableRefPK);
            $this->db->where_in('FTSessionID', $paPackData['tSessionID']);
            $this->db->delete($tTableFhnNameTmp);


            //เพิ่มข้อมูล
            $this->db->insert_batch($tTableFhnNameTmp, $poIns);
        } catch (Exception $Error) {
            return $Error;
        }
    }


    // $aImportParams
    public function FCNaMCMMListDataPrintBarCode($paPackData, $paImportParams)  //$pnLangPrint
    {
        // settings parameters
        $aImportParams          = json_decode($paImportParams);
        $tBarCode               = $paPackData[0];
        $nQty                   = $paPackData[1];
        $tStaImport             = $paPackData[2];
        $tImpDesc               = $paPackData[3];

        // echo "<pre>"; print_r($aImportParams); exit;
        $tLblCode               = $aImportParams->tLblCode;
        $tPrnBarSheet           = $aImportParams->tPriType;
        $nPrnBarStaStartDate    = $aImportParams->nPrnBarStaStartDate;
        $tPrnBarEffectiveDate   = $aImportParams->tPrnBarEffectiveDate;
        $tVerGroup              = $aImportParams->tVerGroup;

        $tIP                = $this->input->ip_address();
        $tFullHost          = gethostbyaddr($tIP);
        $nLngID             = $this->session->userdata("tLangEdit");
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        if( $tVerGroup == 'KPC' ){
            // Fix ภาษาเนื่องจาก KPC Import Master เข้ามา
            if ($tLblCode == 'L003') {
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
        if( $tLblCode == 'L015' ){
            $tSQL = " SELECT TOP 1 FTSysStaUsrValue FROM TSysConfig WITH(NOLOCK) WHERE FTSysCode = 'tCN_PlbUrl' AND FTSysApp = 'CN' AND FTSysKey = 'Company' ";
            $tUrl = $this->db->query($tSQL)->row_array()['FTSysStaUsrValue'];
            $tSesUsrBchCodeDefault = $this->session->userdata("tSesUsrBchCodeDefault");

            $tUrl = str_replace("{FTPdtCode}", "'+CONVERT(VARCHAR,Pdt.FTPdtCode)+'", $tUrl);
            $tUrl = str_replace("{FTBchCode}", "'+CONVERT(VARCHAR,'".$tSesUsrBchCodeDefault."')+'", $tUrl);
            $tUrl = str_replace("{FTPgpCode}", "'+CONVERT(VARCHAR,ISNULL(PGP.FTPgpCode,''))+'", $tUrl);
            
            // https://firster.com/product/{FTPdtCode}/?branch={FTBchCode}&bu={FTPgpCode}
            $tPlbUrl = "'".$tUrl."'";
        }else{
            $tPlbUrl = "''";
        }

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
        // $tSQLSelect = "";

        $tSQLSelect = "     INSERT INTO TCNTPrnLabelTmp (FTComName,FTPdtCode,FTPdtName,FTBarCode,FCPdtPrice,FTPlcCode,FDPrnDate,
                                FTPdtContentUnit,FTPlbCode,FNPlbQty,FTPbnDesc,FTPdtTime,FTPdtMfg,FTPdtImporter,FTPdtRefNo,FTPdtValue,
                                FTPlbStaSelect,FTPlbStaImport,FTPlbImpDesc,FTPlbPriType,FTPlbUrl
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
                                '$nQty' AS FNPlbQty,
                                ISNULL(PBNL.FTPbnName,'N/A') AS FTPbnDesc,
                                'ดูที่ผลิตภัณฑ์' AS FTPdtTime, 
                                'ดูที่ผลิตภัณฑ์' AS FTPdtMfg,
                                'บริษัท คิง เพาเวอร์ คลิก จำกัด' AS FTPdtImporter,
                                PDG.FTPdgRegNo AS FTPdtRefNo,
                                ISNULL(PSZ.FTPszName,'N/A') AS FTPdtValue,
                                '1' AS FTPlbStaSelect,
                                '$tStaImport' AS FTPlbStaImport,
                                '$tImpDesc' AS FTPlbImpDesc,
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
                            ) PRI ON PRI.FTPdtCode = PDT.FTPdtCode AND BAR.FTPunCode = PRI.FTPunCode
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
                            WHERE AdpHD.FTXphStaApv = '1' AND BAR.FTBarCode = '$tBarCode' "; 

        switch($tPrnBarSheet){
            case 'Normal':
                $tSQLSelect .= " AND AdpHD.FTXphDocType = '1' ";
                break;
            case 'Promotion':
                $tSQLSelect .= " AND AdpHD.FTXphDocType = '2' ";
                break;                            
        }

//         $tSQLSelect = " SELECT 
//         PDT.FTPdtCode,
//                             PDTL.FTPdtName FTPdtName, 
//                             ISNULL(PRI.FCPgdPriceRet,0) FCPdtPrice,
//                             '' FTPlcCode,
//                             GETDATE() FDPrnDate,
//                             ISNULL(PCL.FTClrName,'') + ' ' + ISNULL(PSZ.FTPszName,'') FTPdtContentUnit,
//                             '' AS FTPlbCode, 
//                             ISNULL(PBNL.FTPbnName,'') FTPbnDesc,
//                             'ดูที่ผลิตภัณฑ์' FTPdtTime, 
//                             'ดูที่ผลิตภัณฑ์' FTPdtMfg,
//                             'บริษัท คิง เพาเวอร์ คลิก จำกัด' FTPdtImporter,
//                             PDG.FTPdgRegNo FTPdtRefNo,
//                             PSZ.FTPszName FTPdtValue,
//                             1 FTPlbStaSelect
//         FROM TCNMPdt PDT with(nolock)
//                     INNER JOIN TCNMPdtPackSize PPS with(nolock) ON PPS.FTPdtCode = PDT.FTPdtCode
//                     LEFT JOIN TCNMPdtUnit_L PUL WITH(NOLOCK) ON PUL.FTPunCode = PPS.FTPunCode AND PUL.FNLngID = $pnLangPrint
//                     LEFT JOIN TCNMPdtBar BAR with(nolock) ON BAR.FTPdtCode = PPS.FTPdtCode AND BAR.FTPunCode = PPS.FTPunCode
//                     LEFT JOIN TCNMPdt_L PDTL with(nolock) ON PDTL.FTPdtCode = PDT.FTPdtCode AND PDTL.FNLngID = $pnLangPrint
//                     LEFT JOIN (SELECT PRI.FTPdtCode,PRI.FTPunCode,PRI.FCPgdPriceRet FROM TCNTPdtPrice4PDT PRI with(nolock) 
//                                 INNER JOIN (SELECT FTPdtCode,FTPunCode,MAX(FTPghDocNo) FTPghDocNo
//                                 FROM TCNTPdtPrice4PDT with(nolock)
//                                 WHERE CONVERT(VARCHAR(10),GETDATE(),121) BETWEEN FDPghDStart AND FDPghDStop
//                                 AND FTPghDocType = '1' 
//                                 GROUP BY FTPdtCode,FTPunCode) PRI2 ON PRI2.FTPdtCode = PRI.FTPdtCode AND PRI2.FTPunCode = PRI.FTPunCode 
//                                 AND PRI2.FTPghDocNo = PRI.FTPghDocNo) PRI ON PRI.FTPdtCode = PDT.FTPdtCode AND BAR.FTPunCode = PRI.FTPunCode
//                                 LEFT JOIN
// (
// SELECT PRI.FTPdtCode, 
//        PRI.FTPunCode, 
//        PRI.FCPgdPriceRet
// FROM TCNTPdtPrice4PDT PRI WITH(NOLOCK)
//      INNER JOIN
// (
//     SELECT FTPdtCode, 
//            FTPunCode, 
//            MAX(FTPghDocNo) FTPghDocNo
//     FROM TCNTPdtPrice4PDT WITH(NOLOCK)
//     WHERE CONVERT(VARCHAR(10), GETDATE(), 121) BETWEEN FDPghDStart AND FDPghDStop
//           AND FTPghDocType = '2'
//     GROUP BY FTPdtCode, 
//              FTPunCode
// ) PRI2 ON PRI2.FTPdtCode = PRI.FTPdtCode
//           AND PRI2.FTPunCode = PRI.FTPunCode
//           AND PRI2.FTPghDocNo = PRI.FTPghDocNo
// ) PRIPRO ON PRIPRO.FTPdtCode = PDT.FTPdtCode
//         AND BAR.FTPunCode = PRIPRO.FTPunCode
//                     LEFT JOIN TCNMPdtBrand_L PBNL with(nolock) ON PBNL.FTPbnCode = PDT.FTPbnCode AND PBNL.FNLngID = $pnLangPrint
//                     LEFT JOIN TCNMPdtDrug PDG with(nolock) ON PDG.FTPdtCode = PDT.FTPdtCode
//                     LEFT JOIN TCNMPdtSize_L PSZ with(nolock) ON PSZ.FTPszCode = PPS.FTPszCode AND PSZ.FNLngID =   $pnLangPrint
//                     LEFT JOIN TCNMPdtColor_L PCL with(nolock) ON PCL.FTClrCode = PPS.FTClrCode AND PCL.FNLngID =   $pnLangPrint
//                     LEFT JOIN TCNMPdtCategory CAT WITH(NOLOCK) ON PDT.FTPdtCode = CAT.FTPdtCode
//                     WHERE 1 = 1 AND BAR.FTBarCode = '$ptBarCode' ";


        $this->db->query($tSQLSelect);
        // $oQuerySelect = $this->db->query($tSQLSelect);

        // if ($oQuerySelect->num_rows() > 0) {
        //     $oResult = $oQuerySelect->result_array();
        // } else {
        //     $oResult = array();
        // }

        // return  $oResult;
    }



    public function FCNaMCMMListDataPrintBarCodeCheckValidate()
    {
        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);

        $tSQL = "UPDATE TCNTPrnLabelTmp
        SET FTPlbStaImport = 2,FTPlbStaSelect = null,FTPlbImpDesc =  '[2]ไม่พบสินค้า'
        WHERE FTPdtCode  IS NULL AND FTComName = '$tFullHost' ";

        $oQuerySelect = $this->db->query($tSQL);

        // if ($oQuerySelect->num_rows() > 0) {
        //     $oResult = $oQuerySelect->result_array();
        // } else {
        //     $oResult = array();
        // }

        // return  $oResult;
    }

    // Create By : Napat(Jame) 22/06/2022
    public function FCNaMWahChkStk($paParams){
        $tBchCode   = $paParams['tBchCode'];
        $tWahCode   = $paParams['tWahCode'];

        $tSQL = " SELECT 1 FROM TCNMWaHouse WHERE FTBchCode = '".$tBchCode."' AND FTWahCode = '".$tWahCode."' AND FTWahStaChkStk IN ('2','3') ";
        $oQuery = $this->db->query($tSQL);

        if( $oQuery->num_rows() > 0 ){
            $aStatus = array(
                'nCode'     => 1,
                'tDesc'     => 'Wahouse is check stock'
            );
        }else{
            $aStatus = array(
                'nCode'     => 800,
                'tDesc'     => 'Wahouse is not check stock',
            );
        }
        return $aStatus;
    }

    // Create By : Napat(Jame) 22/06/2022
    // Last Update : Napat(Jame) 29/06/2022 เพิ่มแสดงเอกสารรออนุมัติ เฉพาะเอกสารที่มีสินค้าตรงกัน อย่างน้อย 1 รายการ
    // ค้นหาเอกสารการโอน รออนุมัติ
    public function FCNaMGetDocInvPendingApv($paParams){
        $tBchCode   = $paParams['tBchCode'];
        $tWahCode   = $paParams['tWahCode'];
        $nLangEdit  = $this->session->userdata("tLangEdit");

        $tTableDT   = $paParams['tTableDT'];
        $tDocNo     = $paParams['tDocNo'];
        $tDocDT     = " INNER JOIN ".$tTableDT." DOCDT WITH(NOLOCK) ON DOCDT.FTXthDocNo = '".$tDocNo."' AND DT.FTPdtCode = DOCDT.FTPdtCode ";

        $tSQL = "   SELECT DOC.FTXthDocType,DOC.FDXthDocDate,DOC.FTXthDocNo,USRL.FTUsrName 
                    FROM (
                        SELECT DISTINCT 'ใบรับโอน-สาขา' AS FTXthDocType,HD.FDXthDocDate,HD.FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtTbiHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtTbiDT DT WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo
                        ".$tDocDT."
                        WHERE HD.FTXthBchTo = '".$tBchCode."' AND HD.FTXthWhTo = '".$tWahCode."'
                            AND HD.FTXthStaDoc = '1' 
                            AND ISNULL(HD.FTXthStaApv,'') = ''

                        UNION ALL
                    
                        SELECT DISTINCT
                            CASE WHEN HD.FNXthDocType = 1 THEN 'ใบรับเข้า-คลังสินค้า' 
                            ELSE 'ใบรับโอน - คลังสินค้า' END AS FTXthDocType,
                            HD.FDXthDocDate,HD.FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtTwiHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtTwiDT DT WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo
                        ".$tDocDT."
                        WHERE HD.FTBchCode = '".$tBchCode."' AND HD.FTXthWhTo = '".$tWahCode."'
                            AND HD.FTXthStaDoc = '1' 
                            AND ISNULL(HD.FTXthStaApv,'') = ''
                    
                        UNION ALL
                    
                        SELECT DISTINCT 'ใบโอนสินค้าระหว่างคลัง'AS FTXthDocType,HD.FDXthDocDate,HD.FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtTwxHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtTwxDT DT WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo
                        ".$tDocDT."
                        WHERE HD.FTBchCode = '".$tBchCode."' AND HD.FTXthWhFrm = '".$tWahCode."'
                            AND HD.FTXthStaDoc = '1' 
                            AND ISNULL(HD.FTXthStaApv,'') = ''
                    
                        UNION ALL
                    
                        SELECT DISTINCT 'ใบตรวจนับ - ยืนยันสินค้าคงคลัง'AS FTXthDocType,HD.FDAjhDocDate AS FDXthDocDate,HD.FTAjhDocNo AS FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtAdjStkHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtAdjStkDT DT WITH(NOLOCK) ON HD.FTAjhDocNo = DT.FTAjhDocNo
                        ".$tDocDT."
                        WHERE HD.FTAjhBchTo = '".$tBchCode."' AND HD.FTAjhWhTo = '".$tWahCode."'
                            AND HD.FTAjhStaDoc = '1' 
                            AND ISNULL(HD.FTAjhStaApv,'') = ''
                            AND HD.FTAjhDocType = '3'

                        UNION ALL

                        SELECT DISTINCT 'ใบเบิกออก - คลังสินค้า'AS FTXthDocType,HD.FDXthDocDate,HD.FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtTwoHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtTwoDT DT WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo
                        ".$tDocDT."
                        WHERE HD.FTBchCode = '".$tBchCode."' AND HD.FTXthWhFrm = '".$tWahCode."'
                            AND HD.FTXthStaDoc = '1' 
                            AND ISNULL(HD.FTXthStaApv,'') = ''

                        UNION ALL

                        SELECT DISTINCT 'ใบจ่ายโอน - สาขา'AS FTXthDocType,HD.FDXthDocDate,HD.FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtTboHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtTboDT DT WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo
                        ".$tDocDT."
                        WHERE HD.FTXthBchFrm = '".$tBchCode."' AND HD.FTXthWhFrm = '".$tWahCode."'
                            AND HD.FTXthStaDoc = '1' 
                            AND ISNULL(HD.FTXthStaApv,'') = ''

                        UNION ALL

                        SELECT DISTINCT 'ใบจ่ายโอน - คลังสินค้า'AS FTXthDocType,HD.FDXthDocDate,HD.FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtTwoHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtTwoDT DT WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo
                        ".$tDocDT."
                        WHERE HD.FTBchCode = '".$tBchCode."' AND HD.FTXthWhFrm = '".$tWahCode."'
                            AND HD.FTXthStaDoc = '1' 
                            AND ISNULL(HD.FTXthStaApv,'') = ''
                            AND HD.FNXthDocType = '4'

                        UNION ALL

                        SELECT DISTINCT 'ใบโอนสินค้าระหว่างสาขา'AS FTXthDocType,HD.FDXthDocDate,HD.FTXthDocNo,HD.FTCreateBy
                        FROM TCNTPdtTbxHD HD WITH(NOLOCK) 
                        INNER JOIN TCNTPdtTbxDT DT WITH(NOLOCK) ON HD.FTXthDocNo = DT.FTXthDocNo
                        ".$tDocDT."
                        WHERE HD.FTXthBchFrm = '".$tBchCode."' AND HD.FTXthWhFrm = '".$tWahCode."'
                            AND HD.FTXthStaDoc = '1' 
                            AND ISNULL(HD.FTXthStaApv,'') = ''
                    ) DOC
                    LEFT JOIN TCNMUser_L USRL WITH(NOLOCK) ON USRL.FTUsrCode = DOC.FTCreateBy AND USRL.FNLngID = ".$nLangEdit."
                    WHERE DOC.FTXthDocNo != '$tDocNo' ";
                    

        // TCNTPdtTbiHD ใบรับโอน - สาขา (อนุมัติสต๊อกปลายทางเพิ่ม)
        // TCNTPdtTwiHD FNXthDocType = 1 ใบรับเข้า - คลังสินค้า (อนุมัติสตีอกเพิ่ม)
        // TCNTPdtTwiHD FNXthDocType = 5 ใบรับโอน - คลังสินค้า (อนุมัติสต๊อกปลายทางเพิ่ม)
        // TCNTPdtTwxHD ใบโอนสินค้าระหว่างคลัง (อนุมัติสต๊อกปลายทางเพิ่ม)
        // TCNTPdtAdjStkHD FTAjhDocType = 3 ใบตรวจนับ - ยืนยันสินค้าคงคลัง (อนุมัติ ปรับปรุงสต๊อก)
        // TCNTPdtTwoHD FNXthDocType = 2 ใบเบิกออก - คลังสินค้า (อนุมัติ สต๊อกลด)

        // TCNTPdtTbxHD ใบโอนสินค้าระหว่างสาขา (อนุมัติสต๊อกปลายทางเพิ่ม) แต่ต้นทางต้องเป็นคนอนุมัติ ปลายทางไม่เห็นเอกสาร
        // TCNTPdtTwoHD FNXthDocType = 4 ใบจ่ายโอน - คลังสินค้า (อนุมัติสต๊อกปลายทางไม่เพิ่ม) ต้องไปทำใบรับโอน - คลังสินค้า

        $oQuery = $this->db->query($tSQL);

        if( $oQuery->num_rows() > 0 ){
            $aStatus = array(
                'nCode'     => 1,
                'tDesc'     => 'Found Document Pending Approve',
                'aItems'    => $oQuery->result_array()
            );
        }else{
            $aStatus = array(
                'nCode'     => 800,
                'tDesc'     => 'Not Found Document Pending Approve',
            );
        }
        return $aStatus;
    }

    // Create By : Napat(Jame) 22/06/2022
    public function FCNaMGetNotEnoughQty($paParams){
        $tBchCode   = $paParams['tBchCode'];
        $tWahCode   = $paParams['tWahCode'];
        $tDocNo     = $paParams['tDocNo'];
        $tTableDT   = $paParams['tTableDT'];
        $nLangEdit  = $this->session->userdata("tLangEdit");

        $tSQL = "   SELECT 
                        DT.FTBchCode,
                        DT.FTWahCode,
                        DT.FTPdtCode,
                        PDTL.FTPdtName,
                        ISNULL(STK.FCStkQty,0) AS FCStkQty,
                        DT.FCDTQty,
                        (ISNULL(STK.FCStkQty,0) - ISNULL(DT.FCDTQty,0)) AS FCQtyDiff,
                        (ISNULL(STK.FCStkQty,0) - ISNULL(DT.FCDTQty,0)) * (-1) AS FCQtyDiff2
                    FROM (
                        SELECT
                            '".$tBchCode."' AS FTBchCode,
                            '".$tWahCode."' AS FTWahCode,
                            FTPdtCode,
                            SUM(FCXtdQtyAll) AS FCDTQty 
                        FROM ".$tTableDT." WITH(NOLOCK) 
                        WHERE FTXthDocNo = '".$tDocNo."' 
                        GROUP BY FTPdtCode
                    ) DT
                    LEFT JOIN TCNTPdtStkBal STK WITH(NOLOCK) ON STK.FTPdtCode = DT.FTPdtCode AND STK.FTBchCode = DT.FTBchCode AND STK.FTWahCode = DT.FTWahCode
                    LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = ".$nLangEdit."
                    WHERE (ISNULL(STK.FCStkQty,0) - ISNULL(DT.FCDTQty,0)) < 0
                    ORDER BY DT.FTPdtCode ASC ";
        $oQuery = $this->db->query($tSQL);

        if( $oQuery->num_rows() > 0 ){
            $aStatus = array(
                'nCode'     => 1,
                'tDesc'     => 'พบสินค้าบางรายการ สต๊อกไม่เพียงพอ.',
                'aItems'    => $oQuery->result_array()
            );
        }else{
            $aStatus = array(
                'nCode'     => 800,
                'tDesc'     => 'สินค้าทุกรายการ มีสต๊อก',
            );
        }
        return $aStatus;
    }

    // Claer Import Excel In Temp
    // Create By : Napat(Jame) 04/07/2022
    public function FCNaMCMMClearImportExcelInTmp($paPackData){
        try {

            $tTableNameTmp      = $paPackData['tTableNameTmp'];
            // $tNameModule        = $paPackData['tNameModule'];
            // $tTypeModule        = $paPackData['tTypeModule'];
            // $tFlagClearTmp      = $paPackData['tFlagClearTmp'];
            $tTableRefPK        = $paPackData['tTableRefPK'];

            //ลบข้อมูลของ master
            $this->db->where_in('FTTmpTableKey', $tTableRefPK);
            $this->db->where_in('FTSessionID', $paPackData['tSessionID']);
            $this->db->delete($tTableNameTmp);
            
        } catch (Exception $Error) {
            return $Error;
        }
    }
}
