<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mHisBuyLicense extends CI_Model {

    //List
    public function FSaMBuyLicenseList($paData){
        try {
            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $aAdvanceSearch = $paData['aAdvanceSearch'];
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        HD.FTXshDocNo       AS FTXshDocNo,
                                        HD.FDXshDocDate     as FDXshDocDate,
                                        HD.FDCreateOn       AS FDCreateOn,
                                        HD.FTXshStaPaid     AS FTXshStaPaid,
                                        HD.FNXshDocType     AS FNXshDocType,
                                        CST.FTCstName       AS FTCstName,
                                        HD.FCXshTotal       AS FCXshTotal,    
                                        HD.FCXshDis         AS FCXshDis,
                                        HD.FCXshVat         AS FCXshVat,
                                        HD.FCXshGrand       AS FCXshGrand
                                    FROM TPSTSalHD HD
                                    LEFT JOIN TCNMCst_L CST ON HD.FTCstCode = CST.FTCstCode
                                    WHERE 1=1 ";
            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND HD.FTXshDocNo COLLATE THAI_BIN LIKE '%$tSearchList%' ";
            }

            /*ลูกค้า*/
            $tSearchCustomer = $aAdvanceSearch['tSearchCustomer'];
            if(!empty($tSearchCustomer)){
                $tSQL .= " AND HD.FTCstCode = '$tSearchCustomer' ";
            }

            /*จากวันที่ - ถึงวันที่*/
            $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
            $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
            if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
                $tSQL .= " AND ((HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
            }

            /*สถานะประเภทเอกสาร*/
            $tSearchStaTypeDoc = $aAdvanceSearch['tSearchStaTypeDoc'];
            if(!empty($tSearchStaTypeDoc) && ($tSearchStaTypeDoc != "0")){
                $tSQL .= " AND HD.FNXshDocType = '$tSearchStaTypeDoc' ";
            }

            /*สถานะการจ่ายเงิน*/
            $tSearchStaPayment = $aAdvanceSearch['tSearchStaPayment'];
            if(!empty($tSearchStaPayment) && ($tSearchStaPayment != "0")){
                $tSQL .= " AND HD.FTXshStaPaid = '$tSearchStaPayment' ";
            }
            
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMBuyLicenseGetPageAll($paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
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
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Count Page
    public function FSoMBuyLicenseGetPageAll($paData){
        try {
            $tSearchList    = $paData['tSearchAll'];
            $aAdvanceSearch = $paData['aAdvanceSearch'];

            $tSQL = "SELECT COUNT (HD.FTXshDocNo) AS counts
                     FROM [TPSTSalHD] HD
                     WHERE 1=1 ";
            if (isset($ptSearchList) && !empty($ptSearchList)) {
                $tSQL .= " AND (HD.FTXshDocNo LIKE '%$ptSearchList%' )";
            }

            /*ลูกค้า*/
            $tSearchCustomer = $aAdvanceSearch['tSearchCustomer'];
            if(!empty($tSearchCustomer)){
                $tSQL .= " AND HD.FTCstCode = '$tSearchCustomer' ";
            }

            /*จากวันที่ - ถึงวันที่*/
            $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
            $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
            if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
                $tSQL .= " AND ((HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
            }

            /*สถานะประเภทเอกสาร*/
            $tSearchStaTypeDoc = $aAdvanceSearch['tSearchStaTypeDoc'];
            if(!empty($tSearchStaTypeDoc) && ($tSearchStaTypeDoc != "0")){
                $tSQL .= " AND HD.FNXshDocType = '$tSearchStaTypeDoc' ";
            }

            /*สถานะการจ่ายเงิน*/
            $tSearchStaPayment = $aAdvanceSearch['tSearchStaPayment'];
            if(!empty($tSearchStaPayment) && ($tSearchStaPayment != "0")){
                $tSQL .= " AND HD.FTXshStaPaid = '$tSearchStaPayment' ";
            }

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Sum Footer
    public function FSaMBuyLicenseListSumFooter($paData){
        try {
            $tSearchList    = $paData['tSearchAll'];
            $aAdvanceSearch = $paData['aAdvanceSearch'];

            $tSQL = "SELECT 
                        SUM (
                            CASE 
                                WHEN HD.FNXshDocType = 1 
                                    THEN HD.FCXshGrand 
                                ELSE HD.FCXshGrand*-1 
                            END
                        ) AS Sumtotal
                    FROM TPSTSalHD HD WHERE 1=1 ";

            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND (HD.FTXshDocNo LIKE '%$tSearchList%' )";
            }

            /*ลูกค้า*/
            $tSearchCustomer = $aAdvanceSearch['tSearchCustomer'];
            if(!empty($tSearchCustomer)){
                $tSQL .= " AND HD.FTCstCode = '$tSearchCustomer' ";
            }

            /*จากวันที่ - ถึงวันที่*/
            $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
            $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
            if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
                $tSQL .= " AND ((HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
            }

            /*สถานะประเภทเอกสาร*/
            $tSearchStaTypeDoc = $aAdvanceSearch['tSearchStaTypeDoc'];
            if(!empty($tSearchStaTypeDoc) && ($tSearchStaTypeDoc != "0")){
                $tSQL .= " AND HD.FNXshDocType = '$tSearchStaTypeDoc' ";
            }

            /*สถานะการจ่ายเงิน*/
            $tSearchStaPayment = $aAdvanceSearch['tSearchStaPayment'];
            if(!empty($tSearchStaPayment) && ($tSearchStaPayment != "0")){
                $tSQL .= " AND HD.FTXshStaPaid = '$tSearchStaPayment' ";
            }
            
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Data By ID
    public function FSaMBuyLicenseDatabyID($paData){
        $tDocumentNumber   = $paData['tDocumentNumber'];
        $nLngID            = $paData['FNLngID'];
        $tSQL              = "SELECT
                                ROW_NUMBER() OVER (PARTITION BY PDTTP.FTPtyCode ORDER BY PDTTP.FTPtyCode) row_num,
                                ISNULL(Footer_pdtType.LastPdtPty,1) AS LastPdtPty,
                                DT.FTXsdPdtName             AS FTXsdPdtName,
                                DT.FCXsdNetAfHD             AS FCXsdNetAfHD,    
                                DT.FTPunCode                AS FTPunCode,
                                DT.FTPunName                AS FTPunName,
                                ISNULL(PDTTP.FTPtyCode, '') AS FTPtyCode,
                                CASE 
                                    WHEN ISNULL(PDTTP.FTPtyCode,'') = '' THEN 'General Product'
                                    ELSE PDTTP.FTPtyName
                                END AS FTPtyName
                            FROM [TPSTSalHD] HD
                            LEFT JOIN [TPSTSalDT] DT ON HD.FTXshDocNo = DT.FTXshDocNo 
                            LEFT JOIN [TCNMPdt] PDT WITH (NOLOCK) ON DT.FTPdtCode  = PDT.FTPdtCode
                            LEFT JOIN [TCNMPdtType_L] PDTTP WITH (NOLOCK) ON PDT.FTPtyCode = PDTTP.FTPtyCode AND PDTTP.FNLngID = $nLngID
                            LEFT JOIN (
                                SELECT
                                    COUNT (*) AS LastPdtPty,
                                    TPSTSalDT.FTBchCode,
                                    TPSTSalDT.FTXshDocNo,
                                    ISNULL(TCNMPdt.FTPtyCode,'') AS FTPtyCode
                                FROM
                                    TPSTSalDT
                                LEFT JOIN TCNMPdt ON TPSTSalDT.FTPdtCode = TCNMPdt.FTPdtCode
                                GROUP BY
                                    TPSTSalDT.FTBchCode,
                                    TPSTSalDT.FTXshDocNo,
                                    ISNULL(TCNMPdt.FTPtyCode,'')
                            ) Footer_pdtType ON HD.FTBchCode = Footer_pdtType.FTBchCode
                            AND HD.FTXshDocNo = Footer_pdtType.FTXshDocNo
                            AND ISNULL(PdtTp.FTPtyCode,'') = Footer_pdtType.FTPtyCode
                            WHERE 1=1 AND HD.FTXshDocNo = '$tDocumentNumber' ";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
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
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Sum Footer By ID
    public function FSxMBUYSelectSumFooterTemp($paData){
        $tDocumentNumber = $paData['tDocumentNumber'];

        $tSQL       = "SELECT 
                        CASE
                            WHEN FTXshVATInOrEx = 1 THEN FCXshVat
                            WHEN FTXshVATInOrEx = 2 THEN FCXshVatable
                            ELSE FCXshVat
                        END AS nVat , FCXshTotal , FCXshGrand FROM TPSTSalHD 
                        WHERE FTXshDocNo = '$tDocumentNumber' ";

        $oQuery     = $this->db->query($tSQL);
        $oList      = $oQuery->result();
        $jResult    = json_encode($oList);
        $aResult    = json_decode($jResult, true);
        return $aResult;
    }
       
}
