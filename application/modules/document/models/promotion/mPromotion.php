<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotion extends CI_Model
{

    /**
     * Functionality : HD List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD List
     * Return Type : Array
     */
    public function FSaMHDList($paParams = [])
    {
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        (CASE
                            WHEN 
                                HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '1' 
                                AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                                AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)  
                            THEN '1'
                            
                            WHEN 
                                HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '0' 
                                AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                                AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120) 
                            THEN '2'

                            WHEN  
                                HD.FTPmhStaDoc <> '3' 
                                AND CONVERT(CHAR(10),HD.FDPmhDStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                            THEN '3'

                            WHEN 
                                HD.FTPmhStaDoc <> '3' 
                                AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                            THEN '4'

                            WHEN 
                                HD.FTPmhStaDoc = '3'
                            THEN '5'
                            
                            ELSE '6'
                        END) AS UsedStatus, 
                        HD.*,
                        HDL.FTPmhName,
                        BCHL.FTBchName,
                        USRL.FTUsrName AS FTCreateByName,
                        USRLAPV.FTUsrName AS FTXthApvName
                    FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                    LEFT JOIN TCNTPdtPmtHD_L HDL WITH (NOLOCK) ON HDL.FTPmhDocNo = HD.FTPmhDocNo AND HDL.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON HD.FTPmhUsrApv = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                    WHERE 1=1
        ";

        $aAdvanceSearch = $paParams['aAdvanceSearch'];
        $tSearchList = $aAdvanceSearch['tSearchAll'];
        $tSQLSearchAll = '';
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTPmhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (HDL.FTPmhName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
            $tSQLSearchAll = " AND ((HD.FTPmhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (HDL.FTPmhName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSQLSearchBch = '';
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
            $tSQLSearchBch = " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];
        $tSQLSearchDocDate = '';
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
            $tSQLSearchDocDate = " AND ((HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // ค้นหาสถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND HD.FTPmhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(HD.FTPmhStaApv,'') = '' AND HD.FTPmhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND HD.FTPmhStaApv = '$tSearchStaDoc'";
            }
        }

        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // ค้นหาสถานะประมวลผล
        // if(isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)){
        //     if ($tSearchStaPrcStk == 3) {
        //         $tSQL .= " AND (HD.FTPmhStaPrcDoc = '$tSearchStaPrcStk' OR ISNULL(HD.FTPmhStaPrcDoc,'') = '') ";
        //     } else {
        //         $tSQL .= " AND HD.FTPmhStaPrcDoc = '$tSearchStaPrcStk'";
        //     }
        // }

        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        // ค้นหาสถานะเคลื่อนไหว
        if (isset($tSearchStaDocAct) && !empty($tSearchStaDocAct)) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND HD.FNPmhStaDocAct = 1";
            } else {
                $tSQL .= " AND HD.FNPmhStaDocAct = 0";
            }
        }

        // สถานะการใช้งาน
        $tSearchUsedStatus = $aAdvanceSearch['tSearchUsedStatus'];
        $tSQLSearchUsedStatus = "";
        switch($tSearchUsedStatus){
            case '1' : { // หยุดการใช้งาน
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120) 
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '2' : { // ใช้งาน
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '0' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '0' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '3' : { // ยังไม่เริ่ม
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONVERT(CHAR(10),HD.FDPmhDStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONVERT(CHAR(10),HD.FDPmhDStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '4' : { // หมดอายุ
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '5' : { // ยกเลิก
                $tSQL .= "
                    AND HD.FTPmhStaDoc = '3'
                ";
                $tSQLSearchUsedStatus = "
                    AND HD.FTPmhStaDoc = '3'
                ";
                break;
            }
            default : {}
        }

        // สถานะประมวลผล
        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // $tSQLSearchStaPrcStk = "";
        // if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {
        //     if ($tSearchStaPrcStk == 3) {
        //         $tSQL .= " AND (HD.FTPmhStaApv = '$tSearchStaPrcStk' OR HD.FTPmhStaApv = '') ";
        //         $tSQLSearchStaPrcStk = " AND (HD.FTPmhStaApv = '$tSearchStaPrcStk' OR HD.FTPmhStaApv = '' )";
        //     } else {
        //         $tSQL .= " AND HD.FTPmhStaApv = '$tSearchStaPrcStk'";
        //         $tSQLSearchStaPrcStk = " AND HD.FTPmhStaApv = '$tSearchStaPrcStk'";
        //     }
        // }

        if ($this->session->userdata('tSesUsrLevel') == "BCH" || $this->session->userdata('bIsHaveAgn')) { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
            $tSQL .= "
                AND HD.FTBchCode IN ($tBchCode)
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') = ''
                        AND HD.FTPmhStaApv = '1'
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '1'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo NOT IN ($tBchCode)
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '1'
                        AND BCH.FTPmhAgnTo = '$tSesUsrAgnCode'
                        AND BCH.FTPmhBchTo = 'N/A'
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                AND(
                    HD.FTPmhDocNo NOT IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
            ";
        }

        /* if ($this->session->userdata('tSesUsrLevel') == "SHP") { // ผู้ใช้ระดับ SHP ดูได้แค่ร้านค้าที่มีสิทธิ์
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tShpCode = $this->session->userdata('tSesUsrShpCodeMulti');
            $tSQL .= "
                AND HD.FTBchCode IN ($tBchCode)
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') = ''
                        AND HD.FTPmhStaApv = '1'
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                         WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '1'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        AND BCH.FTPmhShpTo IN ($tShpCode)
                  )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo NOT IN ($tBchCode)
                        AND BCH.FTPmhShpTo NOT IN ($tShpCode)
                  )
                )
                AND(
                    HD.FTPmhDocNo NOT IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        AND BCH.FTPmhShpTo IN ($tShpCode)
                  )
                )
            ";
        } */

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMHDListGetPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Count HD Row
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count Row
     * Return Type : Number
     */
    public function FSnMHDListGetPageAll($paParams = [])
    {
        $nLngID = $paParams['FNLngID'];
        
        $tSQL = "
            SELECT DISTINCT
                HD.FTPmhDocNo
            FROM TCNTPdtPmtHD HD WITH (NOLOCK)
            LEFT JOIN TCNTPdtPmtHD_L HDL WITH (NOLOCK) ON HDL.FTPmhDocNo = HD.FTPmhDocNo AND HDL.FNLngID = $nLngID
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON HD.FTPmhUsrApv = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
            WHERE 1=1
        ";

        $aAdvanceSearch = $paParams['aAdvanceSearch'];
        $tSearchList = $aAdvanceSearch['tSearchAll'];
        $tSQLSearchAll = '';
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTPmhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (HDL.FTPmhName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
            $tSQLSearchAll = " AND ((HD.FTPmhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (HDL.FTPmhName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSQLSearchBch = '';
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
            $tSQLSearchBch = " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];
        $tSQLSearchDocDate = '';
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
            $tSQLSearchDocDate = " AND ((HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // ค้นหาสถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND HD.FTPmhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(HD.FTPmhStaApv,'') = '' AND HD.FTPmhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND HD.FTPmhStaApv = '$tSearchStaDoc'";
            }
        }

        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // // ค้นหาสถานะประมวลผล
        // if(isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)){
        //     if ($tSearchStaPrcStk == 3) {
        //         $tSQL .= " AND (HD.FTPmhStaPrcDoc = '$tSearchStaPrcStk' OR ISNULL(HD.FTPmhStaPrcDoc,'') = '') ";
        //     } else {
        //         $tSQL .= " AND HD.FTPmhStaPrcDoc = '$tSearchStaPrcStk'";
        //     }
        // }

        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        // ค้นหาสถานะเคลื่อนไหว
        if (isset($tSearchStaDocAct) && !empty($tSearchStaDocAct)) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND HD.FNPmhStaDocAct = 1";
            } else {
                $tSQL .= " AND HD.FNPmhStaDocAct = 0";
            }
        }


        // สถานะการใช้งาน
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchUsedStatus'];
        $tSQLSearchUsedStatus = "";
        switch($tSearchStaPrcStk){
            case '1' : { // หยุดการใช้งาน
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120) 
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '2' : { // ใช้งาน
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '0' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' AND HD.FTPmhStaClosed = '0' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStart,120),' ',CONVERT(CHAR(8), HD.FDPmhTStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '3' : { // ยังไม่เริ่ม
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONVERT(CHAR(10),HD.FDPmhDStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONVERT(CHAR(10),HD.FDPmhDStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '4' : { // หมดอายุ
                $tSQL .= "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        HD.FTPmhStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),HD.FDPmhDStop,120),' ',CONVERT(CHAR(8), HD.FDPmhTStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '5' : { // ยกเลิก
                $tSQL .= "
                    AND HD.FTPmhStaDoc = '3'
                ";
                $tSQLSearchUsedStatus = "
                ";
                break;
            }
            default : {}
        }

        // สถานะประมวลผล
        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // $tSQLSearchStaPrcStk = "";
        // if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {
        //     if ($tSearchStaPrcStk == 3) {
        //         $tSQL .= " AND (HD.FTPmhStaApv = '$tSearchStaPrcStk' OR HD.FTPmhStaApv = '') ";
        //         $tSQLSearchStaPrcStk = " AND (HD.FTPmhStaApv = '$tSearchStaPrcStk' OR HD.FTPmhStaApv = '' )";
        //     } else {
        //         $tSQL .= " AND HD.FTPmhStaApv = '$tSearchStaPrcStk'";
        //         $tSQLSearchStaPrcStk = " AND HD.FTPmhStaApv = '$tSearchStaPrcStk'";
        //     }
        // }

        if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
            $tSQL .= "
                AND HD.FTBchCode IN ($tBchCode)
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') = ''
                        AND HD.FTPmhStaApv = '1'
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '1'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo NOT IN ($tBchCode)
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '1'
                        AND BCH.FTPmhAgnTo = '$tSesUsrAgnCode'
                        AND BCH.FTPmhBchTo = 'N/A'
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
                AND(
                    HD.FTPmhDocNo NOT IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        $tSQLSearchAll
                        $tSQLSearchBch
                        $tSQLSearchDocDate
                        $tSQLSearchUsedStatus
                    )
                )
            ";
        }

        /* if ($this->session->userdata('tSesUsrLevel') == "SHP") { // ผู้ใช้ระดับ SHP ดูได้แค่ร้านค้าที่มีสิทธิ์
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tShpCode = $this->session->userdata('tSesUsrShpCodeMulti');
            $tSQL .= "
                AND HD.FTBchCode IN ($tBchCode)
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') = ''
                        AND HD.FTPmhStaApv = '1'
                    )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                         WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '1'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        AND BCH.FTPmhShpTo IN ($tShpCode)
                  )
                )
                OR(
                    HD.FTPmhDocNo IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo NOT IN ($tBchCode)
                        AND BCH.FTPmhShpTo NOT IN ($tShpCode)
                  )
                )
                AND(
                    HD.FTPmhDocNo NOT IN (
                        SELECT HD.FTPmhDocNo FROM TCNTPdtPmtHD HD WITH (NOLOCK)
                        LEFT JOIN TCNTPdtPmtHDBch BCH WITH (NOLOCK) ON HD.FTPmhDocNo = BCH.FTPmhDocNo
                        WHERE ISNULL(BCH.FTPmhDocNo,'') <> ''
                        AND HD.FTPmhStaApv = '1'
                        AND BCH.FTPmhStaType = '2'
                        AND BCH.FTPmhBchTo IN ($tBchCode)
                        AND BCH.FTPmhShpTo IN ($tShpCode)
                  )
                )
            ";
        } */

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Get HD Detail
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Detail
     * Return Type : Array
     */
    public function FSaMGetHD($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];

        $tSQL = "
            SELECT
                HD.*,
                HDL.*,
                BCHL.FTBchName,
                CONVERT(CHAR(5), HD.FDCreateOn, 108)  AS FTPmhDocTime,
                CONVERT(CHAR(5), HD.FDPmhTStart, 108)  AS FTPmhTStartTime,
                CONVERT(CHAR(5), HD.FDPmhTStop, 108)  AS FTPmhTStopTime,
                USRAPV.FTUsrName AS FTUsrNameApv,
                USRL.FTUsrName AS FTCreateByName,
                ROLL.FTRolName,
                CB.FTPbyStaBuyCond
            FROM TCNTPdtPmtHD HD WITH (NOLOCK)
            LEFT JOIN TCNTPdtPmtCB CB WITH (NOLOCK) ON CB.FTPmhDocNo = HD.FTPmhDocNo

            LEFT JOIN TCNTPdtPmtHD_L HDL WITH (NOLOCK) ON HDL.FTPmhDocNo = HD.FTPmhDocNo AND HDL.FNLngID = $nLngID
            LEFT JOIN TCNMUsrRole_L ROLL WITH (NOLOCK) ON ROLL.FTRolCode = HD.FTRolCode AND ROLL.FNLngID = $nLngID
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON HD.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRAPV WITH (NOLOCK) ON HD.FTPmhUsrApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
            WHERE 1=1
        ";

        if ($tDocNo != "") {
            $tSQL .= " AND HD.FTPmhDocNo = '$tDocNo'";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItems' => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // Not Found
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
     * Functionality : Get PdtPmtHDCst
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : PdtPmtHDCst Detail
     * Return Type : Array
     */
    public function FSaMGetPdtPmtHDCst($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];

        $tSQL = "
            SELECT
                HDCST.*
            FROM TCNTPdtPmtHDCst HDCST WITH (NOLOCK)
            WHERE 1=1
        ";

        if ($tDocNo != "") {
            $tSQL .= " AND HDCST.FTPmhDocNo = '$tDocNo'";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItems' => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // Not Found
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
     * Functionality : Insert Temp to PdtPmtDT
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToPdtPmtDT($paParams = [])
    {

        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tBchCode = $paParams['tBchCode'];

        // ทำการลบ ใน TCNTPdtPmtDT ก่อนการย้าย Temp ไป TCNTPdtPmtDT
        $this->db->where('FTPmhDocNo', $tDocNo);
        $this->db->delete('TCNTPdtPmtDT');

        $tSQL = "   
            INSERT TCNTPdtPmtDT 
                (FTBchCode,
                FTPmhDocNo,
                FNPmdSeq,
                FTPmdStaType,
                FTPmdGrpName,
                FTPmdRefCode,
                FTPmdSubRef,
                FTPmdBarCode)
        ";

        $tSQL .= "  
            SELECT
                '$tBchCode' AS FTBchCode,
                TMP.FTPmhDocNo,
                ROW_NUMBER() OVER(ORDER BY TMP.FTPmdGrpName ASC, TMP.FNPmdSeq ASC) AS FNPmdSeq,
                TMP.FTPmdStaType,
                TMP.FTPmdGrpName,
                TMP.FTPmdRefCode,
                TMP.FTPmdSubRef,
                TMP.FTPmdBarCode
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND (
                TMP.FTPmdGrpName IN
                (
                    SELECT DISTINCT CB.FTPmdGrpName FROM TCNTPdtPmtCB_Tmp CB WITH (NOLOCK)
                    WHERE CB.FTSessionID = '$tUserSessionID'
                )
                OR
                TMP.FTPmdGrpName IN
                (
                    SELECT DISTINCT CG.FTPmdGrpName FROM TCNTPdtPmtCG_Tmp CG WITH (NOLOCK)
                    WHERE CG.FTSessionID = '$tUserSessionID'
                )
            )
			OR (TMP.FTPmdStaType = '2' AND TMP.FTSessionID = '$tUserSessionID')
            ORDER BY TMP.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert Temp to PdtPmtCB
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToPdtPmtCB($paParams = [])
    {

        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tBchCode = $paParams['tBchCode'];

        // ทำการลบ ใน TCNTPdtPmtCB ก่อนการย้าย Temp ไป TCNTPdtPmtCB
        $this->db->where('FTPmhDocNo', $tDocNo);
        $this->db->delete('TCNTPdtPmtCB');

        $tSQL = "   
            INSERT TCNTPdtPmtCB 
                (FTBchCode,
                FTPmhDocNo,
                FNPbySeq,
                FTPmdGrpName,
                FTPbyStaCalSum,
                FTPbyStaBuyCond,
                FTPbyStaPdtDT,
                FCPbyPerAvgDis,
                FCPbyMinSetPri,
                FCPbyMinValue,
                FCPbyMaxValue,
                FTPbyMinTime,
                FTPbyMaxTime)
        ";

        $tSQL .= "  
            SELECT
                '$tBchCode' AS FTBchCode,
                TMP.FTPmhDocNo,
                ROW_NUMBER() OVER(ORDER BY TMP.FTPmdGrpName ASC, TMP.FNPbySeq ASC) AS FNPbySeq,
                TMP.FTPmdGrpName,
                TMP.FTPbyStaCalSum,
                TMP.FTPbyStaBuyCond,
                TMP.FTPbyStaPdtDT,
                TMP.FCPbyPerAvgDis,
                TMP.FCPbyMinSetPri,
                TMP.FCPbyMinValue,
                TMP.FCPbyMaxValue,
                TMP.FTPbyMinTime,
                TMP.FTPbyMaxTime
            FROM TCNTPdtPmtCB_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert Temp to PdtPmtCG
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToPdtPmtCG ($paParams = [])
    {

        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tBchCode = $paParams['tBchCode'];

        // ทำการลบ ใน TCNTPdtPmtCG ก่อนการย้าย Temp ไป TCNTPdtPmtCG
        $this->db->where('FTPmhDocNo', $tDocNo);
        $this->db->delete('TCNTPdtPmtCG');

        $tSQL = "   
            INSERT TCNTPdtPmtCG 
                (
                    FTBchCode,
                    FTPmhDocNo,
                    FNPgtSeq,
                    FTPmdGrpName,
                    FTPgtStaGetEffect,
                    FTPgtStaGetType,
                    FTPgtStaGetPdt,
                    FTRolCode,
                    FCPgtGetvalue,
                    FTPplCode,
                    FCPgtGetQty,
                    FCPgtPerAvgDis,
                    FTPgtStaPoint,
                    FTPgtStaPntCalType,
                    FTPgtStaPdtDT,
                    FNPgtPntGet,
                    FNPgtPntBuy,
                    FTPgtStaCoupon,
                    FTPgtCpnText,
                    FTCphDocNo,
                    FTSplCode,
                    FDPgtPntStart,
                    FDPgtPntExpired
                )
        ";

        $tSQL .= "  
            SELECT
                '$tBchCode' AS FTBchCode,
                TMP.FTPmhDocNo,
                (CASE
                    WHEN (TMP.FTPmdGrpName IS NULL OR TMP.FTPmdGrpName = '') AND (TMP.FTPgtStaCoupon IS NOT NULL OR TMP.FTPgtStaCoupon <> '') THEN -1
                    WHEN (TMP.FTPmdGrpName IS NULL OR TMP.FTPmdGrpName = '') AND (TMP.FTPgtStaPoint IS NOT NULL OR TMP.FTPgtStaPoint <> '') THEN -2
                    ELSE ROW_NUMBER() OVER(ORDER BY TMP.FTPmdGrpName ASC, TMP.FNPgtSeq ASC) - (SELECT COUNT(FTPmhDocNo) FROM TCNTPdtPmtCG_Tmp WHERE FTSessionID = '$tUserSessionID' AND (FTPmdGrpName IS NULL OR FTPmdGrpName = ''))
                END) AS FNPgtSeq,
                TMP.FTPmdGrpName,
                TMP.FTPgtStaGetEffect,
                TMP.FTPgtStaGetType,
                TMP.FTPgtStaGetPdt,
                TMP.FTRolCode,
                TMP.FCPgtGetvalue,
                TMP.FTPplCode,
                TMP.FCPgtGetQty,
                TMP.FCPgtPerAvgDis,
                TMP.FTPgtStaPoint,
                TMP.FTPgtStaPntCalType,
                TMP.FTPgtStaPdtDT,
                TMP.FNPgtPntGet,
                TMP.FNPgtPntBuy,
                TMP.FTPgtStaCoupon,
                TMP.FTPgtCpnText,
                TMP.FTCphDocNo,
                TMP.FTSplCode,
                TMP.FDPgtPntStart,
                TMP.FDPgtPntExpired

            FROM TCNTPdtPmtCG_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert Temp to PdtPmtHDBch
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToPdtPmtHDBch($paParams = [])
    {

        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tBchCode = $paParams['tBchCode'];

        // ทำการลบ ใน TCNTPdtPmtHDBch ก่อนการย้าย Temp ไป TCNTPdtPmtHDBch
        $this->db->where('FTPmhDocNo', $tDocNo);
        $this->db->delete('TCNTPdtPmtHDBch');

        $tSQL = "   
            INSERT TCNTPdtPmtHDBch 
                (FTBchCode,
                FTPmhDocNo,
                FTPmhAgnTo,
                FTPmhBchTo,
                FTPmhMerTo,
                FTPmhShpTo,
                FTPmhStaType)
        ";

        $tSQL .= "  
            SELECT
                '$tBchCode' AS FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTPmhAgnTo,
                TMP.FTPmhBchTo,
                TMP.FTPmhMerTo,
                TMP.FTPmhShpTo,
                TMP.FTPmhStaType
            FROM TCNTPdtPmtHDBch_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhDocNo ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert Temp to PdtPmtHDCstPri
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToPdtPmtHDCstPri($paParams = [])
    {

        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tBchCode = $paParams['tBchCode'];

        // ทำการลบ ใน TCNTPdtPmtHDCstPri ก่อนการย้าย Temp ไป TCNTPdtPmtHDCstPri
        $this->db->where('FTPmhDocNo', $tDocNo);
        $this->db->delete('TCNTPdtPmtHDCstPri');

        $tSQL = "   
            INSERT TCNTPdtPmtHDCstPri 
                (FTBchCode,
                FTPmhDocNo,
                FTPplCode,
                FTPmhStaType)
        ";

        $tSQL .= "  
            SELECT
                '$tBchCode' AS FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTPplCode,
                TMP.FTPmhStaType
            FROM TCNTPdtPmtHDCstPri_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhDocNo ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert PdtPmtDT to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : 31/08/2022 Napat(Jame) ปรับการหา ประเภทรายการร่วม
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtDTToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate = $paParams['tUserSessionDate']; // User Session Date

        // ทำการลบ ใน Temp ก่อนการย้าย TCNTPdtPmtCB ไป Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtDT_Tmp');

        $tSQL = "   INSERT TCNTPdtPmtDT_Tmp (FTBchCode,FTPmhDocNo,FNPmdSeq,FTPmdStaType,FTPmdStaListType,
                    FTPmdGrpName,FTPmdRefCode,FTPmdSubRef,FTPmdBarCode,FTPmdRefName,FTPmdSubRefName,FDCreateOn,FTSessionID) ";

        // $tSQL .= "  SELECT DISTINCT
        //                 TMP.FTBchCode,
        //                 TMP.FTPmhDocNo,
        //                 TMP.FNPmdSeq,
        //                 TMP.FTPmdStaType,
        //                 TMP.FTPmdStaListType,
        //                 TMP.FTPmdGrpName,
        //                 TMP.FTPmdRefCode,
        //                 TMP.FTPmdSubRef,
        //                 TMP.FTPmdBarCode,
        //                 CASE
        //                     WHEN TMP.FTPmdStaListType = '1' THEN TMP.FTPdtName
        //                     WHEN TMP.FTPmdStaListType = '2' THEN TMP.FTPbnName
        //                 END AS FTPmdRefName,
        //                 CASE
        //                     WHEN TMP.FTPmdStaListType = '1' THEN TMP.FTPunName
        //                     WHEN TMP.FTPmdStaListType = '2' THEN TMP.FTPmoName
        //                 END AS FTPmdSubRefName,
        //                 '$tUserSessionDate' AS FDCreateOn,
        //                 '$tUserSessionID' AS FTSessionID
        //             FROM (
        //                 SELECT DISTINCT
        //                     DT.FTBchCode,
        //                     DT.FTPmhDocNo,
        //                     DT.FNPmdSeq,
        //                     DT.FTPmdStaType,
        //                     CASE 
        //                         WHEN ISNULL(PDTL.FTPdtName,'') <> '' THEN '1'
        //                         WHEN ISNULL(PBNL.FTPbnName,'') <> '' THEN '2'
        //                     END AS FTPmdStaListType,
        //                     DT.FTPmdGrpName,
        //                     DT.FTPmdRefCode,
        //                     DT.FTPmdSubRef,
        //                     DT.FTPmdBarCode,
        //                     PDTL.FTPdtName,
        //                     UNITL.FTPunName,
        //                     PBNL.FTPbnName,
        //                     PMOL.FTPmoName
        //                 FROM TCNTPdtPmtDT DT WITH(NOLOCK)
        //                 LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDTL.FTPdtCode = DT.FTPmdRefCode AND PDTL.FNLngID = $nLngID
        //                 LEFT JOIN TCNMPdtUnit_L UNITL WITH(NOLOCK) ON UNITL.FTPunCode = DT.FTPmdSubRef AND UNITL.FNLngID = $nLngID
        //                 LEFT JOIN TCNMPdtBrand_L PBNL WITH(NOLOCK) ON PBNL.FTPbnCode = DT.FTPmdRefCode AND PBNL.FNLngID = $nLngID
        //                 LEFT JOIN TCNMPdtModel_L PMOL WITH(NOLOCK) ON PMOL.FTPmoCode = DT.FTPmdSubRef AND PMOL.FNLngID = $nLngID
        //                 WHERE DT.FTPmhDocNo = '$tDocNo'
        //             ) TMP
        //             ORDER BY TMP.FNPmdSeq, TMP.FTPmdGrpName ASC ";
        $tSQL .= "  
            SELECT DISTINCT 
                A.FTBchCode,
                A.FTPmhDocNo,
                A.FNPmdSeq,
                A.FTPmdStaType,
                A.FTPmdStaListType,
                A.FTPmdGrpName,
                A.FTPmdRefCode,
                A.FTPmdSubRef,
                A.FTPmdBarCode,
                CASE
                    WHEN A.FTPmdStaListType = '1' THEN PDTL.FTPdtName
                    WHEN A.FTPmdStaListType = '2' THEN PBNL.FTPbnName
                END AS FTPmdRefName,
                CASE
                    WHEN A.FTPmdStaListType = '1' THEN UNITL.FTPunName
                    WHEN A.FTPmdStaListType = '2' THEN PMOL.FTPmoName
                END AS FTPmdSubRefName,
                '$tUserSessionDate' AS FDCreateOn,
                A.FTSessionID
            FROM (
                SELECT DISTINCT
                    PDTPMTDT.FTBchCode,
                    'PMTDOCTEMP' AS FTPmhDocNo,
                    PDTPMTDT.FNPmdSeq,
                    PDTPMTDT.FTPmdStaType,
                    PDTPMTDT.FTPmdGrpName,
                    PDTPMTDT.FTPmdRefCode,
                    PDTPMTDT.FTPmdSubRef,
                    PDTPMTDT.FTPmdBarCode,
                    CBCG.FTStaPdtDT AS FTPmdStaListType,
                    '$tUserSessionID' AS FTSessionID
                FROM TCNTPdtPmtDT PDTPMTDT WITH(NOLOCK)
                LEFT JOIN 
                (
                    SELECT 
                        BG.* 
                    FROM 
                    (
                        (
                        SELECT DISTINCT
                            FTPmdGrpName,
                            FTPbyStaPdtDT AS  FTStaPdtDT
                        FROM TCNTPdtPmtCB  
                        WHERE FTPmhDocNo = '$tDocNo'
                        )
                        UNION
                        (
                        SELECT DISTINCT
                            FTPmdGrpName, 
                            FTPgtStaPdtDT AS  FTStaPdtDT
                        FROM TCNTPdtPmtCG 
                        WHERE FTPmhDocNo = '$tDocNo'
                        )
                        UNION
                        (
                        SELECT DISTINCT
                            DT.FTPmdGrpName, 
                            HD.FTPmhStaPdtExc AS  FTStaPdtDT
                        FROM TCNTPdtPmtHD HD
                        LEFT JOIN TCNTPdtPmtDT DT ON DT.FTPmhDocNo = HD.FTPmhDocNo AND DT.FTPmdStaType = '2'
                        WHERE HD.FTPmhDocNo = '$tDocNo'
                        )
                    ) BG
                ) CBCG ON CBCG.FTPmdGrpName = PDTPMTDT.FTPmdGrpName
            
                WHERE PDTPMTDT.FTPmhDocNo = '$tDocNo'
            ) A
            LEFT JOIN TCNMPdt_L PDTL ON PDTL.FTPdtCode = A.FTPmdRefCode AND PDTL.FNLngID = $nLngID
            LEFT JOIN TCNMPdtUnit_L UNITL ON UNITL.FTPunCode = A.FTPmdSubRef AND UNITL.FNLngID = $nLngID
            LEFT JOIN TCNMPdtBrand_L PBNL ON PBNL.FTPbnCode = A.FTPmdRefCode AND PBNL.FNLngID = $nLngID
            LEFT JOIN TCNMPdtModel_L PMOL ON PMOL.FTPmoCode = A.FTPmdSubRef AND PMOL.FNLngID = $nLngID
            ORDER BY A.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert PdtPmtCB to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtCBToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate = $paParams['tUserSessionDate']; // User Session Date

        // ทำการลบ ใน Temp ก่อนการย้าย TCNTPdtPmtCB ไป Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtCB_Tmp');

        $tSQL = "  
            INSERT TCNTPdtPmtCB_Tmp
                (FTBchCode,
                FTPmhDocNo,
                FNPbySeq,
                FTPmdGrpName,
                FTPbyStaCalSum,
                FTPbyStaBuyCond,
                FTPbyStaPdtDT,
                FCPbyPerAvgDis,
                FCPbyMinSetPri,
                FCPbyMinValue,
                FCPbyMaxValue,
                FTPbyMinTime,
                FTPbyMaxTime,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
                CB.FTBchCode,
                'PMTDOCTEMP' AS FTPmhDocNo,
                CB.FNPbySeq,
                CB.FTPmdGrpName,
                CB.FTPbyStaCalSum,
                CB.FTPbyStaBuyCond,
                CB.FTPbyStaPdtDT,
                CB.FCPbyPerAvgDis,
                CB.FCPbyMinSetPri,
                CB.FCPbyMinValue,
                CB.FCPbyMaxValue,
                CB.FTPbyMinTime,
                CB.FTPbyMaxTime,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtCB CB WITH(NOLOCK)
            WHERE CB.FTPmhDocNo = '$tDocNo'
            ORDER BY CB.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);
    }

          /**
     * Functionality : Insert Temp to PdtPmtHDCstLev
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToPdtPmtHDCstLev($paParams = [])
    {

        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tBchCode = $paParams['tBchCode'];

        // ทำการลบ ใน TCNTPdtPmtHDCstLev ก่อนการย้าย Temp ไป TCNTPdtPmtHDCstLev
        $this->db->where('FTPmhDocNo', $tDocNo);
        $this->db->delete('TCNTPdtPmtHDCstLev');

        $tSQL = "   
            INSERT TCNTPdtPmtHDCstLev 
                (FTBchCode,
                FTPmhDocNo,
                FTClvCode,
                FTPmhStaType)
        ";

        $tSQL .= "  
            SELECT
                '$tBchCode' AS FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTClvCode,
                TMP.FTPmhStaType
            FROM TCNTPdtPmtHDCstLev_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhDocNo ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert PdtPmtCG to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtCGToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate = $paParams['tUserSessionDate']; // User Session Date

        // ทำการลบ ใน Temp ก่อนการย้าย TCNTPdtPmtCG ไป Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtCG_Tmp');

        $tSQL = "   
            INSERT TCNTPdtPmtCG_Tmp 
                (FTBchCode,
                FTPmhDocNo,
                FNPgtSeq,
                FTPmdGrpName,
                FTPgtStaGetEffect,
                FTPgtStaGetType,
                FTPgtStaGetPdt,
                FTRolCode,
                FCPgtGetvalue,
                FTPplCode,
                FTPplName,
                FCPgtGetQty,
                FCPgtPerAvgDis,
                FTPgtStaPoint,
                FTPgtStaPntCalType,
                FTPgtStaPdtDT,
                FNPgtPntGet,
                FNPgtPntBuy,
                FTPgtStaCoupon,
                FTPgtCpnText,
                FTCphDocNo,
                FTCphDocName,
                FDCreateOn,
                FTSessionID,
                FTSplCode,
                FDPgtPntStart,
                FDPgtPntExpired)
        ";

        $tSQL .= "  
            SELECT
                CG.FTBchCode,
                'PMTDOCTEMP' AS FTPmhDocNo,
                (CASE
                    WHEN (CG.FTPmdGrpName IS NULL OR CG.FTPmdGrpName = '') AND (CG.FTPgtStaCoupon IS NOT NULL OR CG.FTPgtStaCoupon <> '') THEN -1
                    WHEN (CG.FTPmdGrpName IS NULL OR CG.FTPmdGrpName = '') AND (CG.FTPgtStaPoint IS NOT NULL OR CG.FTPgtStaPoint <> '') THEN -2
                    ELSE ROW_NUMBER() OVER(ORDER BY CG.FTPmdGrpName ASC, CG.FNPgtSeq ASC) - (SELECT COUNT(FTPmhDocNo) FROM TCNTPdtPmtCG WHERE FTPmhDocNo = '$tDocNo' AND (FTPmdGrpName IS NULL OR FTPmdGrpName = ''))
                END) AS FNPgtSeq,
                CG.FTPmdGrpName,
                CG.FTPgtStaGetEffect,
                CG.FTPgtStaGetType,
                CG.FTPgtStaGetPdt,
                CG.FTRolCode,
                CG.FCPgtGetvalue,
                CG.FTPplCode,
                PPLL.FTPplName AS FTPplName,
                CG.FCPgtGetQty,
                CG.FCPgtPerAvgDis,
                CG.FTPgtStaPoint,
                CG.FTPgtStaPntCalType,
                CG.FTPgtStaPdtDT,
                CG.FNPgtPntGet,
                CG.FNPgtPntBuy,
                CG.FTPgtStaCoupon,
                CG.FTPgtCpnText,
                CG.FTCphDocNo,
                CPHL.FTCpnName,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID,
                CG.FTSplCode,
                CG.FDPgtPntStart,
                CG.FDPgtPntExpired

            FROM TCNTPdtPmtCG CG WITH(NOLOCK)
            LEFT JOIN TFNTCouponHD_L CPHL WITH(NOLOCK) ON CPHL.FTCphDocNo = CG.FTCphDocNo AND CPHL.FNLngID = $nLngID
            LEFT JOIN TCNMPdtPriList_L PPLL WITH(NOLOCK) ON PPLL.FTPplCode = CG.FTPplCode AND PPLL.FNLngID = $nLngID
            WHERE CG.FTPmhDocNo = '$tDocNo'
            ORDER BY CG.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert PdtPmtHDBch to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtHDBchToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate = $paParams['tUserSessionDate']; // User Session Date

        // ทำการลบ ใน Temp ก่อนการย้าย TCNTPdtPmtHDBch ไป Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtHDBch_Tmp');

        $tSQL = "   
            INSERT TCNTPdtPmtHDBch_Tmp 
                (FTBchCode,
                FTPmhDocNo,
                FTPmhAgnTo,
                FTPmhBchTo,
                FTPmhMerTo,
                FTPmhShpTo,
                FTPmhStaType,
                FTPmhAgnToName,
                FTPmhBchToName,
                FTPmhMerToName,
                FTPmhShpToName,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
                HDBCH.FTBchCode,
                'PMTDOCTEMP' AS FTPmhDocNo,
                HDBCH.FTPmhAgnTo,
                HDBCH.FTPmhBchTo,
                HDBCH.FTPmhMerTo,
                HDBCH.FTPmhShpTo,
                HDBCH.FTPmhStaType,
                AGNL.FTAgnName AS FTPmhAgnToName,
                BCHL.FTBchName AS FTPmhBchToName,
                MERL.FTMerName AS FTPmhMerToName,
                SHPL.FTShpName AS FTPmhShpToName,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtHDBch HDBCH WITH(NOLOCK)
            LEFT JOIN TCNMAgency_L AGNL ON AGNL.FTAgnCode = HDBCH.FTPmhAgnTo AND AGNL.FNLngID = $nLngID
            LEFT JOIN TCNMBranch_L BCHL ON BCHL.FTBchCode = HDBCH.FTPmhBchTo AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMMerchant_L MERL ON MERL.FTMerCode = HDBCH.FTPmhMerTo AND MERL.FNLngID = $nLngID
            LEFT JOIN TCNMShop_L SHPL ON SHPL.FTBchCode = HDBCH.FTPmhBchTo AND SHPL.FTShpCode = HDBCH.FTPmhShpTo AND SHPL.FNLngID = $nLngID
            WHERE HDBCH.FTPmhDocNo = '$tDocNo'
            ORDER BY BCHL.FTBchName ASC, MERL.FTMerName ASC, SHPL.FTShpName ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert PdtPmtHDCstPri to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtHDCstPriToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate = $paParams['tUserSessionDate']; // User Session Date

        // ทำการลบ ใน Temp ก่อนการย้าย TCNTPdtPmtHDCstPri ไป Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtHDCstPri_Tmp');

        $tSQL = "   
            INSERT TCNTPdtPmtHDCstPri_Tmp 
                (FTBchCode,
                FTPmhDocNo,
                FTPplCode,
                FTPplName,
                FTPmhStaType,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
                HDCSTPRI.FTBchCode,
                'PMTDOCTEMP' AS FTPmhDocNo,
                HDCSTPRI.FTPplCode,
                PPLL.FTPplName AS FTPplName,
                HDCSTPRI.FTPmhStaType,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtHDCstPri HDCSTPRI WITH(NOLOCK)
            LEFT JOIN TCNMPdtPriList_L PPLL ON PPLL.FTPplCode = HDCSTPRI.FTPplCode AND PPLL.FNLngID = $nLngID
            WHERE HDCSTPRI.FTPmhDocNo = '$tDocNo'
            ORDER BY PPLL.FTPplName ASC
        ";

        $this->db->query($tSQL);
    }

            /**
     * Functionality : Insert PdtPmtHDCstLev to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtHDCstLevToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate = $paParams['tUserSessionDate']; // User Session Date

        // ทำการลบ ใน Temp ก่อนการย้าย TCNTPdtPmtHDCstLev ไป Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtHDCstLev_Tmp');

        $tSQL = "   
            INSERT TCNTPdtPmtHDCstLev_Tmp 
                (FTBchCode,
                FTPmhDocNo,
                FTClvCode,
                FTClvName,
                FTPmhStaType,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
                HDCstLev.FTBchCode,
                'PMTDOCTEMP' AS FTPmhDocNo,
                HDCstLev.FTClvCode,
                PPLL.FTClvName AS FTClvName,
                HDCstLev.FTPmhStaType,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtHDCstLev HDCstLev WITH(NOLOCK)
            LEFT JOIN TCNMCstLev_L PPLL ON PPLL.FTClvCode = HDCstLev.FTClvCode AND PPLL.FNLngID = $nLngID
            WHERE HDCstLev.FTPmhDocNo = '$tDocNo'
            ORDER BY PPLL.FTClvName ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : ล้างข้อมูลในตาราง tmp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMClearInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtDT_Tmp');

        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtCB_Tmp');

        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtCG_Tmp');

        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDBch_Tmp');

        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDCstPri_Tmp');

        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDChn_Tmp');

        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDCstLev_Tmp');
    }

    /**
     * Functionality : Check DocNo is Duplicate
     * Parameters : DocNo
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Boolean
     */
    public function FSbMCheckDuplicate($ptDocNo = '')
    {
        $tSQL = "   
            SELECT 
                FTPmhDocNo
            FROM TCNTPdtPmtHD
            WHERE FTPmhDocNo = '$ptDocNo'
        ";

        $bStatus = false;
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Add or Update HD
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdateHD($paParams = [])
    {
        // Update Master
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->set('FDPmhDStart', $paParams['FDPmhDStart']);
        $this->db->set('FDPmhDStop', $paParams['FDPmhDStop']);
        $this->db->set('FDPmhTStart', $paParams['FDPmhTStart']);
        $this->db->set('FDPmhTStop', $paParams['FDPmhTStop']);
        $this->db->set('FTPmhStaLimitCst', $paParams['FTPmhStaLimitCst']);
        $this->db->set('FTPmhStaClosed', $paParams['FTPmhStaClosed']);
        $this->db->set('FTPmhStaDoc', $paParams['FTPmhStaDoc']);
        $this->db->set('FTPmhStaApv', $paParams['FTPmhStaApv']);
        $this->db->set('FTPmhStaPrcDoc', $paParams['FTPmhStaPrcDoc']);
        $this->db->set('FNPmhStaDocAct', $paParams['FNPmhStaDocAct']);
        $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
        $this->db->set('FTPmhUsrApv', $paParams['FTPmhUsrApv']);

        $this->db->set('FTPmhStaGrpPriority', $paParams['FTPmhStaGrpPriority']);
        $this->db->set('FTPmhStaGetPri', $paParams['FTPmhStaGetPri']);
        $this->db->set('FTPmhStaChkQuota', $paParams['FTPmhStaChkQuota']);
        $this->db->set('FTPmhStaOnTopDis', $paParams['FTPmhStaOnTopDis']);
        $this->db->set('FTPmhStaOnTopPmt', $paParams['FTPmhStaOnTopPmt']);
        // $this->db->set('FTPmhStaSpcGrpDis', $paParams['FTPmhStaSpcGrpDis']);

        $this->db->set('FTPmhStaAlwCalPntStd', $paParams['FTPmhStaAlwCalPntStd']);
        $this->db->set('FTPmhStaRcvFree', $paParams['FTPmhStaRcvFree']);
        $this->db->set('FTPmhStaLimitGet', $paParams['FTPmhStaLimitGet']);
        $this->db->set('FTPmhStaLimitTime', $paParams['FTPmhStaLimitTime']);
        $this->db->set('FTPmhStaGetPdt', $paParams['FTPmhStaGetPdt']);
        $this->db->set('FTPmhRefAccCode', $paParams['FTPmhRefAccCode']);
        $this->db->set('FTRolCode', $paParams['FTRolCode']);
        $this->db->set('FNPmhLimitQty', $paParams['FNPmhLimitQty']);
        $this->db->set('FTPmhStaChkLimit', $paParams['FTPmhStaChkLimit']);
        $this->db->set('FTPmhStaChkCst', $paParams['FTPmhStaChkCst']);
        $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
        $this->db->where('FTPmhDocNo', $paParams['FTPmhDocNo']);
        $this->db->update('TCNTPdtPmtHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            // Add Master
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FTPmhDocNo', $paParams['FTPmhDocNo']);
            $this->db->set('FDPmhDStart', $paParams['FDPmhDStart']);
            $this->db->set('FDPmhDStop', $paParams['FDPmhDStop']);
            $this->db->set('FDPmhTStart', $paParams['FDPmhTStart']);
            $this->db->set('FDPmhTStop', $paParams['FDPmhTStop']);
            $this->db->set('FTPmhStaLimitCst', $paParams['FTPmhStaLimitCst']);
            $this->db->set('FTPmhStaClosed', $paParams['FTPmhStaClosed']);
            $this->db->set('FTPmhStaDoc', $paParams['FTPmhStaDoc']);
            $this->db->set('FTPmhStaApv', $paParams['FTPmhStaApv']);
            $this->db->set('FTPmhStaPrcDoc', $paParams['FTPmhStaPrcDoc']);
            $this->db->set('FNPmhStaDocAct', $paParams['FNPmhStaDocAct']);
            $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
            $this->db->set('FTPmhUsrApv', $paParams['FTPmhUsrApv']);

            $this->db->set('FTPmhStaGrpPriority', $paParams['FTPmhStaGrpPriority']);
            $this->db->set('FTPmhStaGetPri', $paParams['FTPmhStaGetPri']);
            $this->db->set('FTPmhStaChkQuota', $paParams['FTPmhStaChkQuota']);
            $this->db->set('FTPmhStaOnTopDis', $paParams['FTPmhStaOnTopDis']);
            $this->db->set('FTPmhStaOnTopPmt', $paParams['FTPmhStaOnTopPmt']);
            // $this->db->set('FTPmhStaSpcGrpDis', $paParams['FTPmhStaSpcGrpDis']);
            
            $this->db->set('FTPmhStaAlwCalPntStd', $paParams['FTPmhStaAlwCalPntStd']);
            $this->db->set('FTPmhStaRcvFree', $paParams['FTPmhStaRcvFree']);
            $this->db->set('FTPmhStaLimitGet', $paParams['FTPmhStaLimitGet']);
            $this->db->set('FTPmhStaLimitTime', $paParams['FTPmhStaLimitTime']);
            $this->db->set('FTPmhStaGetPdt', $paParams['FTPmhStaGetPdt']);
            $this->db->set('FTPmhRefAccCode', $paParams['FTPmhRefAccCode']);
            $this->db->set('FTRolCode', $paParams['FTRolCode']);
            $this->db->set('FNPmhLimitQty', $paParams['FNPmhLimitQty']);
            $this->db->set('FTPmhStaChkLimit', $paParams['FTPmhStaChkLimit']);
            $this->db->set('FTPmhStaChkCst', $paParams['FTPmhStaChkCst']);
            $this->db->set('FDCreateOn', $paParams['FDCreateOn']);
            $this->db->set('FTCreateBy', $paParams['FTCreateBy']);
            $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
            $this->db->insert('TCNTPdtPmtHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Add or Update HDL
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdateHDL($paParams = [])
    {
        // Update Master L
        $this->db->set('FTPmhName', $paParams['FTPmhName']);
        $this->db->set('FTPmhNameSlip', $paParams['FTPmhNameSlip']);
        $this->db->set('FTPmhRmk', $paParams['FTPmhRmk']);
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->where('FNLngID', $paParams['FNLngID']);
        $this->db->where('FTPmhDocNo', $paParams['FTPmhDocNo']);
        $this->db->update('TCNTPdtPmtHD_L');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            // Add Master L
            $this->db->insert('TCNTPdtPmtHD_L', array(
                'FTBchCode' => $paParams['FTBchCode'],
                'FTPmhDocNo' => $paParams['FTPmhDocNo'],
                'FTPmhName' => $paParams['FTPmhName'],
                'FTPmhNameSlip' => $paParams['FTPmhNameSlip'],
                'FTPmhRmk' => $paParams['FTPmhRmk'],
                'FNLngID' => $paParams['FNLngID']
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Update FTPmhStaClosed in HD
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbMAddUpdatePmhStaClosedHD($paParams = [])
    {
        $this->db->set('FTPmhStaClosed', $paParams['FTPmhStaClosed']);
        $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
        $this->db->where('FTPmhDocNo', $paParams['FTPmhDocNo']);
        $this->db->update('TCNTPdtPmtHD');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Add or Update PdtPmtHDCst
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdatePdtPmtHDCst($paParams = [])
    {
        // Update PdtPmtHDCstPri
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->set('FTSpmStaLimitCst', $paParams['FTSpmStaLimitCst']);
        $this->db->set('FNSpmMemAgeLT', $paParams['FNSpmMemAgeLT']);
        $this->db->set('FTSpmStaChkCstDOB', $paParams['FTSpmStaChkCstDOB']);
        $this->db->set('FNPmhCstDobPrev', $paParams['FNPmhCstDobPrev']);
        $this->db->set('FNPmhCstDobNext', $paParams['FNPmhCstDobNext']);
        $this->db->where('FTPmhDocNo', $paParams['FTPmhDocNo']);
        $this->db->update('TCNTPdtPmtHDCst');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update PdtPmtHDCstPri Success',
            );
        } else {
            // Add PdtPmtHDCstPri
            $this->db->insert('TCNTPdtPmtHDCst', array(
                'FTBchCode' => $paParams['FTBchCode'],
                'FTPmhDocNo' => $paParams['FTPmhDocNo'],
                'FTSpmStaLimitCst' => $paParams['FTSpmStaLimitCst'],
                'FNSpmMemAgeLT' => $paParams['FNSpmMemAgeLT'],
                'FTSpmStaChkCstDOB' => $paParams['FTSpmStaChkCstDOB'],
                'FNPmhCstDobPrev' => $paParams['FNPmhCstDobPrev'],
                'FNPmhCstDobNext' => $paParams['FNPmhCstDobNext']
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add PdtPmtHDCstPri Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit PdtPmtHDCstPri.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Update DocNo in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMUpdateDocNoInTmp($paParams = [])
    {
        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtDT_Tmp');

        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtCB_Tmp');

        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtCG_Tmp');

        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtHDBch_Tmp');

        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtHDCstPri_Tmp');

        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtHDChn_Tmp');

        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtHDCstLev_Tmp');
    }

    /**
     * Functionality : Update FTPgtStaGetPdt in Temp from FTPmhStaGetPdt HD
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMUpdatePgtStaGetPdtInTmpFromHD($paParams = [])
    {
        $this->db->set('FTPgtStaGetPdt', $paParams['tStaGetPdt']);
        $this->db->where('FTPmhDocNo', 'PMTDOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where("FTPmdGrpName IS NOT NULL");
        $this->db->where("FTPmdGrpName <> ''");
        $this->db->update('TCNTPdtPmtCG_Tmp');
    }

    /**
     * Functionality : Update FTPmhStaPdtExc in HD
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmhStaPdtExcInHD($paParams = [])
    {
        $this->db->set('FTPmhStaPdtExc', $paParams['tPmhStaPdtExc']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->update('TCNTPdtPmtHD');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Cancel Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMDocCancel($paParams = [])
    {
        try {
            // TFNTBnkDplHD
            $this->db->set('FTPmhStaDoc', '3');
            $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
            $this->db->update('TCNTPdtPmtHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Cancel Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Cancel Fail',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSaMDocApprove($paParams = [])
    {
        try {
            // TFNTBnkDplHD
            $this->db->set('FTPmhStaApv', '1');
            $this->db->set('FTPmhUsrApv', $paParams['tApvCode']);
            $this->db->where('FTPmhDocNo', $paParams['tDocNo']);

            $this->db->update('TCNTPdtPmtHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Approve Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Approve Fail',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Del Document by DocNo
     * Parameters : function parameters
     * Creator : 04/02/2020 Piya
     * Return : Status Delete
     * Return Type : array
     */
    public function FSaMDelMaster($paParams = [])
    {
        try {
            $tDocNo = $paParams['tDocNo'];

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtHD');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtHD_L');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtCB');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtCG');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtDT');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtHDBch');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtHDCst');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtHDCstLev');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtHDCstPri');

            $this->db->where('FTPmhDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPmtHDChn');

        } catch (Exception $Error) {
            return $Error;
        }
    }

        /**
     * Functionality : Insert Temp to PdtPmtHDChn
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToPdtPmtHDChn($paParams = [])
    {

        $tDocNo = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tBchCode = $paParams['tBchCode'];

        // ทำการลบ ใน TCNTPdtPmtHDChn ก่อนการย้าย Temp ไป TCNTPdtPmtHDChn
        $this->db->where('FTPmhDocNo', $tDocNo);
        $this->db->delete('TCNTPdtPmtHDChn');

        $tSQL = "   
            INSERT TCNTPdtPmtHDChn 
                (FTBchCode,
                FTPmhDocNo,
                FTChnCode,
                FTPmhStaType)
        ";

        $tSQL .= "  
            SELECT
                '$tBchCode' AS FTBchCode,
                TMP.FTPmhDocNo,
                TMP.FTChnCode,
                TMP.FTPmhStaType
            FROM TCNTPdtPmtHDChn_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FTPmhDocNo ASC
        ";

        $this->db->query($tSQL);
    }

       /**
     * Functionality : Insert PdtPmtHDChn to Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtHDChnToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserSessionDate = $paParams['tUserSessionDate']; // User Session Date

        // ทำการลบ ใน Temp ก่อนการย้าย TCNTPdtPmtHDChn ไป Temp
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtHDChn_Tmp');

        $tSQL = "   
            INSERT TCNTPdtPmtHDChn_Tmp 
                (FTBchCode,
                FTPmhDocNo,
                FTChnCode,
                FTChnName,
                FTPmhStaType,
                FDCreateOn,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
            HDCSTCHN.FTBchCode,
                'PMTDOCTEMP' AS FTPmhDocNo,
                HDCSTCHN.FTChnCode,
                CHNL.FTChnName AS FTChnName,
                HDCSTCHN.FTPmhStaType,
                '$tUserSessionDate' AS FDCreateOn,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtPmtHDChn HDCSTCHN WITH(NOLOCK)
            LEFT JOIN TCNMChannel_L CHNL ON CHNL.FTChnCode = HDCSTCHN.FTChnCode  AND CHNL.FNLngID = $nLngID
            WHERE HDCSTCHN.FTPmhDocNo = '$tDocNo'
            ORDER BY CHNL.FTChnName ASC
        ";

        // print_r($tSQL); die();

        $this->db->query($tSQL);
    }

    //Functionality : Copy Promotion Document
    //Parameters : function parameters
    //Creator : 17/03/2022 Off
    //LastUpdate: 23/05/2022 Napat(Jame)
    public function FSaMPromotionCopyHD($ptDocumentNumber,$ptPromotionDocNo){

        $tSesUserCode = $this->session->userdata("tSesUserCode");

        //Copy TCNTPdtPmtHD
        $tSQLInsert = " INSERT TCNTPdtPmtHD (FTBchCode,FTPmhDocNo,FDPmhDStart,FDPmhDStop,FDPmhTStart,
                        FDPmhTStop,FTPmhStaLimitCst,FTPmhStaClosed,FTPmhStaDoc,FTPmhStaApv,FTPmhStaPrcDoc,
                        FNPmhStaDocAct,FTUsrCode,FTPmhUsrApv,FTPmhStaOnTopPmt,FTPmhStaAlwCalPntStd,FTPmhStaRcvFree,
                        FTPmhStaLimitGet,FTPmhStaLimitTime,FTPmhStaGetPdt,FTPmhRefAccCode,FTPmhStaPdtExc,FTRolCode,
                        FNPmhLimitQty,FTPmhStaChkLimit,FTPmhStaChkCst,FTPmhStaGrpPriority,FTPmhStaChkQuota,
                        FTPmhStaGetPri,FTPmhStaOnTopDis,FTPmhStaSpcGrpDis,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            FTBchCode,".$this->db->escape($ptPromotionDocNo).",FDPmhDStart,FDPmhDStop,FDPmhTStart,
                            FDPmhTStop,FTPmhStaLimitCst,'0' AS FTPmhStaClosed,'1' AS FTPmhStaDoc,'' AS FTPmhStaApv,FTPmhStaPrcDoc,
                            '1' AS FNPmhStaDocAct,FTUsrCode,'' AS FTPmhUsrApv,FTPmhStaOnTopPmt,FTPmhStaAlwCalPntStd,FTPmhStaRcvFree,
                            FTPmhStaLimitGet,FTPmhStaLimitTime,FTPmhStaGetPdt,FTPmhRefAccCode,FTPmhStaPdtExc,FTRolCode,
                            FNPmhLimitQty,FTPmhStaChkLimit,FTPmhStaChkCst,FTPmhStaGrpPriority,FTPmhStaChkQuota,
                            FTPmhStaGetPri,FTPmhStaOnTopDis,FTPmhStaSpcGrpDis,
                            GETDATE(),".$this->db->escape($tSesUserCode).",GETDATE(),".$this->db->escape($tSesUserCode)."
                        FROM TCNTPdtPmtHD WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        //Copy TCNTPdtPmtHD_L
        $tSQLInsert = " INSERT TCNTPdtPmtHD_L (FTBchCode,FTPmhDocNo,FTPmhName,FTPmhNameSlip,FTPmhRmk,FNLngID)
                        SELECT 
                            FTBchCode,
                            ".$this->db->escape($ptPromotionDocNo).",
                            FTPmhName,
                            FTPmhNameSlip,
                            FTPmhRmk,
                            FNLngID
                        FROM TCNTPdtPmtHD_L WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        //Copy TCNTPdtPmtHDCst
        $tSQLInsert = " INSERT TCNTPdtPmtHDCst (FTBchCode,FTPmhDocNo,FTSpmStaLimitCst,FNSpmMemAgeLT,FTSpmStaChkCstDOB,FNPmhCstDobPrev,FNPmhCstDobNext)
                        SELECT 
                            FTBchCode,
                            ".$this->db->escape($ptPromotionDocNo).",
                            FTSpmStaLimitCst,
                            FNSpmMemAgeLT,
                            FTSpmStaChkCstDOB,
                            FNPmhCstDobPrev,
                            FNPmhCstDobNext
                        FROM TCNTPdtPmtHDCst WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        //Copy TCNTPdtPmtDT
        $tSQLInsert = " INSERT TCNTPdtPmtDT (FTBchCode,FTPmhDocNo,FNPmdSeq,FTPmdStaType,FTPmdGrpName,FTPmdRefCode,FTPmdSubRef,FTPmdBarCode)
                        SELECT 
                            FTBchCode,
                            ".$this->db->escape($ptPromotionDocNo).",
                            FNPmdSeq,
                            FTPmdStaType,
                            FTPmdGrpName,
                            FTPmdRefCode,
                            FTPmdSubRef,
                            FTPmdBarCode
                        FROM TCNTPdtPmtDT WITH(NOLOCK)
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        ////Copy TCNTPdtPmtCB
        $tSQLInsert = " INSERT INTO TCNTPdtPmtCB (FTBchCode,FTPmhDocNo,FNPbySeq,FTPmdGrpName,FTPbyStaCalSum,
                        FTPbyStaBuyCond,FTPbyStaPdtDT,FCPbyPerAvgDis,FCPbyMinSetPri,FCPbyMinValue,FCPbyMaxValue,FTPbyMinTime,FTPbyMaxTime)
                        SELECT
                            FTBchCode,".$this->db->escape($ptPromotionDocNo).",FNPbySeq,FTPmdGrpName,FTPbyStaCalSum,FTPbyStaBuyCond,
                            FTPbyStaPdtDT,FCPbyPerAvgDis,FCPbyMinSetPri,FCPbyMinValue,FCPbyMaxValue,FTPbyMinTime,FTPbyMaxTime
                        FROM TCNTPdtPmtCB WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        ////Copy TCNTPdtPmtCG
        $tSQLInsert = " INSERT INTO TCNTPdtPmtCG (FTBchCode,FTPmhDocNo,FNPgtSeq,FTPmdGrpName,FTPgtStaGetEffect,FTPgtStaGetType,
                        FTPgtStaGetPdt,FTRolCode,FCPgtGetvalue,FTPplCode,FCPgtGetQty,FCPgtPerAvgDis,FTPgtStaPoint,FTPgtStaPntCalType,
                        FTPgtStaPdtDT,FNPgtPntGet,FNPgtPntBuy,FTPgtStaCoupon,FTPgtCpnText,FTCphDocNo,FTSplCode,FDPgtPntStart,FDPgtPntExpired) 
                        SELECT
                            FTBchCode,".$this->db->escape($ptPromotionDocNo).",FNPgtSeq,FTPmdGrpName,FTPgtStaGetEffect,FTPgtStaGetType,
                            FTPgtStaGetPdt,FTRolCode,FCPgtGetvalue,FTPplCode,FCPgtGetQty,FCPgtPerAvgDis,FTPgtStaPoint,FTPgtStaPntCalType,
                            FTPgtStaPdtDT,FNPgtPntGet,FNPgtPntBuy,FTPgtStaCoupon,FTPgtCpnText,FTCphDocNo,FTSplCode,FDPgtPntStart,FDPgtPntExpired
                        FROM TCNTPdtPmtCG WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        ////Copy TCNTPdtPmtHDBch
        $tSQLInsert = " INSERT INTO TCNTPdtPmtHDBch (FTBchCode,FTPmhDocNo,FTPmhAgnTo,FTPmhBchTo,FTPmhMerTo,FTPmhShpTo,FTPmhStaType)
                        SELECT
                            FTBchCode,
                            ".$this->db->escape($ptPromotionDocNo).",
                            FTPmhAgnTo,
                            FTPmhBchTo,
                            FTPmhMerTo,
                            FTPmhShpTo,
                            FTPmhStaType
                        FROM TCNTPdtPmtHDBch WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        ////Copy TCNTPdtPmtHDCstPri
        $tSQLInsert = " INSERT INTO TCNTPdtPmtHDCstPri (FTBchCode,FTPmhDocNo,FTPplCode,FTPmhStaType)
                        SELECT
                            FTBchCode,
                            ".$this->db->escape($ptPromotionDocNo).",
                            FTPplCode,
                            FTPmhStaType
                        FROM TCNTPdtPmtHDCstPri WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        ////Copy TCNTPdtPmtHDChn
        $tSQLInsert = " INSERT INTO TCNTPdtPmtHDChn (FTBchCode,FTPmhDocNo,FTChnCode,FTPmhStaType)
                        SELECT
                            FTBchCode,
                            ".$this->db->escape($ptPromotionDocNo).",
                            FTChnCode,
                            FTPmhStaType
                        FROM TCNTPdtPmtHDChn WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        ////Copy TCNTPdtPmtHDPay
        $tSQLInsert = " INSERT INTO TCNTPdtPmtHDPay (FTBchCode,FTPmhDocNo,FTRcvCode,FTPmhStaType)
                        SELECT
                            FTBchCode,
                            ".$this->db->escape($ptPromotionDocNo).",
                            FTRcvCode,
                            FTPmhStaType
                        FROM TCNTPdtPmtHDPay WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);

        ////Copy TCNTPdtPmtHDCstLev
        $tSQLInsert = " INSERT INTO TCNTPdtPmtHDCstLev (FTBchCode,FTPmhDocNo,FTClvCode,FTPmhStaType)
                        SELECT FTBchCode,".$this->db->escape($ptPromotionDocNo).",FTClvCode,FTPmhStaType
                        FROM TCNTPdtPmtHDCstLev WITH(NOLOCK) 
                        WHERE FTPmhDocNo = ".$this->db->escape($ptDocumentNumber);
        $oQuery = $this->db->query($tSQLInsert);


        return;
    }

}
