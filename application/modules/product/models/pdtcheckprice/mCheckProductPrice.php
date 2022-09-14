<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCheckProductPrice extends CI_Model
{

    public function FSaMCPPGetPriList($paData)
    {
        $nLngID   = $paData['FNLngID'];
        $tSQL ="SELECT P.FTPplCode, 
                        PL.FTPplName
                FROM TCNMPdtPriList P
                    LEFT JOIN TCNMPdtPriList_L PL ON P.FTPplCode = PL.FTPplCode
                WHERE PL.FNLngID = $nLngID
                ORDER BY P.FDCreateOn DESC";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aList          = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $aList,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found',
                );
            }
            unset($nLngID);
            unset($tSQL);
            unset($oQuery);
            unset($aList);
            return $aResult;
    }

    // Functionality : เรียกข้อมูลตรวจสอบราคาสินค้า
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMCPPGetListData($paData){
        $nLngID         = $paData['FNLngID'];
        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $oAdvanceSearch = $paData['oAdvanceSearch'];
        $tWhere         = "";

        if( $paData['tDisplayType'] == '1' ){
            $tOrderBy1 = " ADJP_DT.FTPdtCode ASC, ADJP_DT.FTPunCode ASC, ADJP_HD.FDXphDStart ASC ";
            // $tOrderBy2 = " ORDER BY B.FTXphTStart DESC,B.FTPdtCode DESC,B.FTPunCode DESC ";
        }else{
            $tOrderBy1 = " ADJP_HD.FTPplCode ASC, ADJP_DT.FTPdtCode ASC, ADJP_DT.FTPunCode ASC, ADJP_HD.FDXphDStart ASC ";
            // $tOrderBy2 = " ORDER BY B.FTPplCode DESC, B.FTPdtCode ASC,B.FTPunCode ASC,B.FTXphDocNo ASC ";
        }
        
        @$tSearchList = $oAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tWhere .= " AND ((ADJP_DT.FTPdtCode LIKE '%$tSearchList%') OR (PDTL.FTPdtName LIKE '%$tSearchList%') OR (PUNL.FTPunName LIKE '%$tSearchList%') OR (ADJP_HD.FTXphDocNo LIKE '%$tSearchList%') OR (CONVERT(VARCHAR(10),ADJP_HD.FDXphDStart,121) LIKE '%$tSearchList%') OR '%$tSearchList%' BETWEEN CONVERT(VARCHAR(10),ADJP_HD.FDXphDStart,121) AND CONVERT(VARCHAR(10),ADJP_HD.FDXphDStop,121))";
        }

        // จากสินค้า - ถึงสินค้า
        $tPdtCodeFrom = $oAdvanceSearch['tPdtCodeFrom'];
        $tPdtCodeTo   = $oAdvanceSearch['tPdtCodeTo'];
        if(!empty($tPdtCodeFrom) && !empty($tPdtCodeTo)){
            $tWhere .= " AND ((ADJP_DT.FTPdtCode BETWEEN '$tPdtCodeFrom' AND '$tPdtCodeTo') OR (ADJP_DT.FTPdtCode BETWEEN '$tPdtCodeTo' AND '$tPdtCodeFrom'))";
        }

        // จากวันที่เอกสาร - ถึงวันที่เอกสาร
        $tSearchDocDateFrom = $oAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $oAdvanceSearch['tSearchDocDateTo'];
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tWhere .= " AND ((CONVERT(VARCHAR(10),ADJP_HD.FDXphDStart,121) BETWEEN '$tSearchDocDateFrom' AND '$tSearchDocDateTo') OR (CONVERT(VARCHAR(10),ADJP_HD.FDXphDStart,121) BETWEEN '$tSearchDocDateTo' AND '$tSearchDocDateFrom'))";
        }

        // หน่วยสินค้า
        $tPunCodeFrom   = $oAdvanceSearch['tPunCodeFrom'];
        $tPunCodeTo     = $oAdvanceSearch['tPunCodeTo'];
        if(!empty($tPunCodeFrom) && !empty($tPunCodeTo)){
            $tWhere .= " AND ((ADJP_DT.FTPunCode BETWEEN '$tPunCodeFrom' AND '$tPunCodeTo') OR (ADJP_DT.FTPunCode BETWEEN '$tPunCodeTo' AND '$tPunCodeFrom'))";
        }
                            
        // วันที่มีผล
        $tWhere .= " AND ( CONVERT(VARCHAR(10),GETDATE(),121) BETWEEN CONVERT(VARCHAR(10), ADJP_HD.FDXphDStart, 121) AND CONVERT(VARCHAR(10), ADJP_HD.FDXphDStop, 121) ) ";
        $tWhere .= " AND ( CONVERT(VARCHAR(5),GETDATE(),114) BETWEEN ADJP_HD.FTXphTStart AND ADJP_HD.FTXphTStop ) ";

        // กลุ่มราคาที่มีผล
        $tPplCodeFrom   = $oAdvanceSearch['tPplCodeFrom'];
        $tPplCodeTo     = $oAdvanceSearch['tPplCodeTo'];
        if(!empty($tPplCodeFrom) && !empty($tPplCodeTo)){
            if( $tPplCodeFrom == 'NA' && $tPplCodeTo != 'NA' ){
                $tWhere .= " AND (ADJP_HD.FTPplCode = '' OR ADJP_HD.FTPplCode IS NULL) ";
                $tWhere .= " AND ADJP_HD.FTPplCode = '$tPplCodeTo' ";
            }

            if( $tPplCodeFrom != 'NA' && $tPplCodeTo == 'NA' ){
                $tWhere .= " AND (ADJP_HD.FTPplCode = '' OR ADJP_HD.FTPplCode IS NULL) ";
                $tWhere .= " AND ADJP_HD.FTPplCode = '$tPplCodeFrom' ";
            }

            if( $tPplCodeFrom != 'NA' && $tPplCodeTo != 'NA' ){
                $tWhere .= " AND ((ADJP_HD.FTPplCode BETWEEN '$tPplCodeFrom' AND '$tPplCodeTo') OR (ADJP_HD.FTPplCode BETWEEN '$tPplCodeTo' AND '$tPplCodeFrom')) ";
            }

            if( $tPplCodeFrom == 'NA' && $tPplCodeTo == 'NA' ){
                $tWhere .= " AND (ADJP_HD.FTPplCode = '' OR ADJP_HD.FTPplCode IS NULL) ";
            }
        }

        if( $this->session->userdata("tSesUsrLevel") != "HQ" ){
            $tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
            $tWhere .= " AND ADJP_HD.FTBchCode IN ($tBchCodeMulti) ";

            //ถ้ามี Mer ต้อง Where Mer เพิ่ม
            if($this->session->userdata("tSesUsrMerCode") != ''){
                $tMerCode = $this->session->userdata("tSesUsrMerCode");
                $tWhere .= " AND PDTSPC.FTMerCode IN ($tMerCode) ";
            }
        }

        $tSQLMain = "   SELECT ROW_NUMBER () OVER ( ORDER BY $tOrderBy1 ) FNRowID,
                        ADJP_DT.FTPdtCode,
                        PDTL.FTPdtName,
                        ADJP_DT.FTPunCode,
                        PUNL.FTPunName,
                        CONVERT(VARCHAR(10),ADJP_HD.FDXphDStart,121) AS FDXphDStart,
                        CASE WHEN ADJP_HD.FTXphDocType = '2' THEN CONVERT(VARCHAR(10),ADJP_HD.FDXphDStop,121) ELSE '-' END AS FDXphDStop,
                        ADJP_HD.FTXphTStart,
                        ADJP_HD.FTXphTStop,
                        ADJP_DT.FCXpdPriceRet,
                        ADJP_HD.FTPplCode,
                        PL.FTPplName,
                        ADJP_HD.FTXphDocNo,
                        ADJP_HD.FTXphDocType,
                        CONVERT(VARCHAR(10),ADJP_HD.FDXphDocDate,121) AS FDXphDocDate ";

        $tSQLCount = " SELECT COUNT(ADJP_HD.FTXphDocNo) AS FNCountData ";

        $tSQL1 = "  SELECT B.* FROM ( ";  
        $tSQL2 = "  FROM TCNTPdtAdjPriHD ADJP_HD WITH (NOLOCK)
                    INNER JOIN TCNTPdtAdjPriDT ADJP_DT WITH (NOLOCK) ON ADJP_DT.FTXphDocNo = ADJP_HD.FTXphDocNo AND ADJP_DT.FTBchCode = ADJP_HD.FTBchCode
                    LEFT JOIN TCNMPdtUnit_L PUNL WITH (NOLOCK)   ON ADJP_DT.FTPunCode = PUNL.FTPunCode AND PUNL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdt_L PDTL WITH (NOLOCK) ON ADJP_DT.FTPdtCode = PDTL.FTPdtCode  AND PDTL.FNLngID    = $nLngID
                    LEFT JOIN TCNMPdtPriList_L PL WITH (NOLOCK) ON ADJP_HD.FTPplCode = PL.FTPplCode AND PL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtSpcBch PDTSPC WITH (NOLOCK) ON PDTSPC.FTPdtCode = PDTL.FTPdtCode 
                    WHERE ADJP_DT.FTPdtCode != ''
                    $tWhere
                ";
        $tSQL3 = " ) B WHERE B.FNRowID > $aRowLen[0] AND B.FNRowID <= $aRowLen[1] ";
        
        // Data
        $tFinalDataQuery = $tSQL1.$tSQLMain.$tSQL2.$tSQL3;
        $oQueryData = $this->db->query($tFinalDataQuery);

        // Count Data
        $tFinalCountQuery = $tSQLCount.$tSQL2;
        $oQueryCount = $this->db->query($tFinalCountQuery);

    //    echo  $tFinalDataQuery; 
    //    echo  $tFinalCountQuery; 
    //    die(); 
        
        if ($oQueryData->num_rows() > 0) {
            $aList          = $oQueryData->result_array();
            $aCount         = $oQueryCount->result_array();
            if($paData['nPage'] == 1){
                $nFoundRow      = $aCount[0]['FNCountData'] ;
            }else{
                $nFoundRow      = $paData['nPagePDTAll'];
            }
            $nPageAll       = ceil($nFoundRow/$paData['nRow']);
            $aResult = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($aList);
        return $aResult;
    }
}