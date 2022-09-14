<?php
defined('BASEPATH') or exit('No direct script access allowed');

class chkstadoctransfer_model extends CI_Model
{
    public function FSoMMONGetData($paData)
    {
        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $aAdvanceSearch     = $paData['aAdvanceSearch'];
        $tBchCode           = $aAdvanceSearch['tBchCode'];
        $tBchCodeFrm        = $aAdvanceSearch['tBchCodeFrm'];
        $tBchCodeTo         = $aAdvanceSearch['tBchCodeTo'];
        $tDocType           = $aAdvanceSearch['tDocType'];
        $tStaDoc            = $aAdvanceSearch['tStaDoc'];
        $tStaDocTBI         = $aAdvanceSearch['tStaDocTBI'];
        $tDocNo             = $aAdvanceSearch['tDocNo'];
        $tDocDateForm       = $aAdvanceSearch['tDocDateForm'];
        $tDocDateTo         = $aAdvanceSearch['tDocDateTo'];
        $tDBJoin            = "";
        $tDBSelect          = "";

        if (!empty($tDocType) && $tDocType != '') {
            if($tDocType == '0'){ //ใบขอโอน-สาขา
                $tDBJoin = "";
                $tDBSelect = 'HD.FTAgnCode, HD.FTBchCode, HD.FDXthDocDate, HD.FTXthDocNo AS FTXthDocNo, HD.FTXthStaDoc, HD.FTXthStaApv, HD.FDCreateOn AS FDCreateOn, TRBCHL.FTBchName,';
                $tDBJoinBch = "LEFT JOIN TCNMBranch_L TRBCHL WITH(NOLOCK) ON HD.FTBchCode = TRBCHL.FTBchCode AND TRBCHL.FNLngID = '$nLngID'";
                $tDBJoinBchFrm = "LEFT JOIN TCNMBranch_L BCHL_F WITH(NOLOCK) ON HD.FTXthBchFrm = BCHL_F.FTBchCode AND BCHL_F.FNLngID = '$nLngID'";
                $tDBJoinBchTo  = "LEFT JOIN TCNMBranch_L BCHL_T WITH(NOLOCK) ON HD.FTXthBchTo = BCHL_T.FTBchCode AND BCHL_T.FNLngID = '$nLngID'";
            }elseif ($tDocType == '1') { //ใบจ่ายโอน-สาขา
                $tDBSelect = "TboHD.FTBchCode, TboHD.FDXthDocDate, TboHD.FTXthDocNo AS FTXthDocNo, TboHD.FTXthStaDoc, TboHD.FTXthStaApv, TboHD.FDCreateOn AS FDCreateOn, TBOBCHL.FTBchName,";
                $tDBJoinBch = "LEFT JOIN TCNMBranch_L TBOBCHL WITH(NOLOCK) ON TboHD.FTBchCode = TBOBCHL.FTBchCode AND TBOBCHL.FNLngID = '$nLngID'";
                $tDBJoin = "INNER JOIN TCNTPdtTboHD TboHD WITH(NOLOCK) ON TRRef.FTXthRefDocNo = TboHD.FTXthDocNo";
                $tDBJoinBchFrm = "LEFT JOIN TCNMBranch_L BCHL_F WITH(NOLOCK) ON TboHD.FTXthBchFrm = BCHL_F.FTBchCode AND BCHL_F.FNLngID = '$nLngID'";
                $tDBJoinBchTo  = "LEFT JOIN TCNMBranch_L BCHL_T WITH(NOLOCK) ON TboHD.FTXthBchTo = BCHL_T.FTBchCode AND BCHL_T.FNLngID = '$nLngID'";
            }elseif ($tDocType == '2'){ //ใบรับโอน - สาขา
                $tDBJoin = "INNER JOIN TCNTPdtTbiHD TbiHD WITH(NOLOCK) ON TRBRef.FTXthRefDocNo = TbiHD.FTXthDocNo";
                $tDBJoinBch = "LEFT JOIN TCNMBranch_L TRBBCHL WITH(NOLOCK) ON TbiHD.FTBchCode = TRBBCHL.FTBchCode AND TRBBCHL.FNLngID = '$nLngID'";
                $tDBJoinBchFrm = "LEFT JOIN TCNMBranch_L BCHL_F WITH(NOLOCK) ON TbiHD.FTXthBchFrm = BCHL_F.FTBchCode AND BCHL_F.FNLngID = '$nLngID'";
                $tDBJoinBchTo  = "LEFT JOIN TCNMBranch_L BCHL_T WITH(NOLOCK) ON TbiHD.FTXthBchTo = BCHL_T.FTBchCode AND BCHL_T.FNLngID = '$nLngID'";
                $tDBSelect = "TbiHD.FTBchCode, TbiHD.FDXthDocDate, TbiHD.FTXthDocNo AS FTXthDocNo, TbiHD.FTXthStaDoc, TbiHD.FTXthStaApv, TbiHD.FDCreateOn AS FDCreateOn, TRBBCHL.FTBchName,";
            }
        }else{
            $tDBJoin = "";
            $tDBJoinBch = "LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '$nLngID'";
            $tDBJoinBchFrm = "LEFT JOIN TCNMBranch_L BCHL_F WITH(NOLOCK) ON HD.FTXthBchFrm = BCHL_F.FTBchCode AND BCHL_F.FNLngID = '$nLngID'";
            $tDBJoinBchTo  = "LEFT JOIN TCNMBranch_L BCHL_T WITH(NOLOCK) ON HD.FTXthBchTo = BCHL_T.FTBchCode AND BCHL_T.FNLngID = '$nLngID'";
            $tDBSelect = 'HD.FTAgnCode, HD.FTBchCode, BCHL.FTBchName, HD.FDXthDocDate, HD.FTXthDocNo AS FTXthDocNo, HD.FTXthStaDoc, HD.FTXthStaApv, HD.FDCreateOn AS FDCreateOn,';
        }

        try{

            $tSQL1 = "  SELECT 
                            ROW_NUMBER () OVER ( PARTITION BY c.FTXthDocNo ORDER BY c.FDXthDocDate DESC ) AS PARTITION_HDDocNo,
                            SUM(1) OVER ( PARTITION BY c.FTXthDocNo ORDER BY c.FDXthDocDate DESC ) AS MAX_HDDocNo,
                            ROW_NUMBER () OVER (ORDER BY c.rtRowID ASC) AS ORDERBY,
                            c.* 
                        FROM (
                            SELECT  
                                ROW_NUMBER ( ) OVER ( ORDER BY FDXthDocDate DESC ) AS rtRowID,
                                DENSE_RANK() OVER(ORDER BY FDXthDocDate DESC,FTXthDocNo DESC) AS FTRowSeq, *
                            FROM ( ";
            $tSQL2 = "          SELECT DISTINCT
                                    $tDBSelect
                                    BCHL_F.FTBchName        AS FTBchNameFrm,
                                    BCHL_T.FTBchName        AS FTBchNameTo,
                                    HD.FTXthDocNo           AS TR,   /*ใบขอโอน-สาขา*/
                                    TRRef.FTXthRefDocNo     AS TBO,   /*ใบจ่ายโอน-สาขา*/
                                    TBORef.FTXthRefDocNo    AS PdtPick,  /*ใบจัดสินค้า*/
                                    TRBRef.FTXthRefDocNo    AS TBI /*ใบรับโอน-สาขา*/
                                    ,HD.FTBchCode           AS FTBchCodeTR
                                    ,TBO.FTBchCode          AS FTBchCodeTBO
                                    ,PICK.FTBchCode         AS FTBchCodePdtPick
                                    ,TBI.FTBchCode          AS FTBchCodeTBI
                                    ,''                     AS FTAgnCodeTR
                                    ,''                     AS FTAgnCodeTBO
                                    ,PICK.FTAgnCode         AS FTAgnCodePdtPick
                                    ,''                     AS FTAgnCodeTBI
                                FROM TCNTPdtReqBchHD HD WITH(NOLOCK)
                                LEFT JOIN TCNTPdtReqBchHDDocRef TRDraft WITH(NOLOCK) ON HD.FTXthDocNo = TRDraft.FTXthDocNo AND TRDraft.FTXthRefKey IN ('DocNum','DocEntry') AND TRDraft.FTXthRefType = '3' 
                                LEFT JOIN TCNTPdtReqBchHDDocRef TRRef WITH(NOLOCK) ON HD.FTXthDocNo = TRRef.FTXthDocNo AND TRRef.FTXthRefKey = 'TBO' AND TRRef.FTXthRefType = '2' 
                                LEFT JOIN TCNTPdtTboHDDocRef TBORef WITH(NOLOCK) ON TRRef.FTXthRefDocNo = TBORef.FTXthDocNo AND TBORef.FTXthRefKey = 'PdtPick' AND TBORef.FTXthRefType = '2'
                                LEFT JOIN TCNTPdtTboHDDocRef TRBRef WITH(NOLOCK) ON TRRef.FTXthRefDocNo = TRBRef.FTXthDocNo AND TRBRef.FTXthRefKey = 'TBI' AND TRBRef.FTXthRefType = '2'
                                
                                LEFT JOIN TCNTPdtTboHD TBO WITH(NOLOCK) ON TBO.FTXthDocNo = TRRef.FTXthRefDocNo
                                LEFT JOIN TCNTPdtPickHD PICK WITH(NOLOCK) ON PICK.FTXthDocNo = TBORef.FTXthRefDocNo
                                LEFT JOIN TCNTPdtTbiHD TBI WITH(NOLOCK) ON TBI.FTXthDocNo = TRBRef.FTXthRefDocNo

                                $tDBJoin
                                $tDBJoinBch
                                $tDBJoinBchFrm
                                $tDBJoinBchTo
                                WHERE HD.FTXthStaDoc <> ''
                    ";

            if (!empty($tDocNo) && $tDocNo != '') {
                if($tDocType == '0'){
                    $tSQL2 .= "AND (HD.FTXthDocNo LIKE '%$tDocNo%' OR TRDraft.FTXthRefDocNo LIKE '%$tDocNo%')";
                }elseif ($tDocType == '1') {
                    $tSQL2 .= "AND (TboHD.FTXthDocNo LIKE '%$tDocNo%' OR TRDraft.FTXthRefDocNo LIKE '%$tDocNo%')";
                }elseif ($tDocType == '2'){
                    $tSQL2 .= "AND (TbiHD.FTXthDocNo LIKE '%$tDocNo%' OR TRDraft.FTXthRefDocNo LIKE '%$tDocNo%')";
                }
            }

            // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            if ($this->session->userdata('tSesUsrLevel') != "HQ") { 
                $tSessBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
                if($tDocType == '0'){
                    $tSQL2 .= "AND (HD.FTXthBchFrm IN ($tSessBchCode) OR HD.FTXthBchTo IN ($tSessBchCode))";
                }elseif ($tDocType == '1') {
                    $tSQL2 .= "AND (TboHD.FTXthBchFrm IN ($tSessBchCode) OR TboHD.FTXthBchTo IN ($tSessBchCode))";
                }elseif ($tDocType == '2'){
                    $tSQL2 .= "AND (TbiHD.FTXthBchFrm IN ($tSessBchCode) OR TbiHD.FTXthBchFrm IN ($tSessBchCode))";
                }else{
                    $tSQL2 .= "AND (HD.FTXthBchFrm IN ($tSessBchCode) OR HD.FTXthBchTo IN ($tSessBchCode))";
                }
            }

            //โอนจากสาขา - ถึงสาขา
            if (!empty($tBchCodeFrm) && $tBchCodeFrm != '' && empty($tBchCodeTo) && $tBchCodeTo == '') {
                if($tDocType == '0'){
                    $tSQL2 .= "AND HD.FTXthBchFrm = '$tBchCodeFrm'";
                }elseif ($tDocType == '1') {
                    $tSQL2 .= "AND TboHD.FTXthBchFrm = '$tBchCodeFrm'";
                }elseif ($tDocType == '2'){
                    $tSQL2 .= "AND TbiHD.FTXthBchFrm = '$tBchCodeFrm'";
                }else{
                    $tSQL2 .= "AND HD.FTXthBchFrm = '$tBchCodeFrm'";
                }
            }elseif (empty($tBchCodeFrm) && $tBchCodeFrm == '' && !empty($tBchCodeTo) && $tBchCodeTo != '') {
                if($tDocType == '0'){
                    $tSQL2 .= "AND HD.FTXthBchTo = '$tBchCodeTo'";
                }elseif ($tDocType == '1') {
                    $tSQL2 .= "AND TboHD.FTXthBchTo = '$tBchCodeTo'";
                }elseif ($tDocType == '2'){
                    $tSQL2 .= "AND TbiHD.FTXthBchTo = '$tBchCodeTo'";
                }else{
                    $tSQL2 .= "AND HD.FTXthBchTo = '$tBchCodeTo'";
                }
            }elseif (!empty($tBchCodeFrm) && $tBchCodeFrm != '' && !empty($tBchCodeTo) && $tBchCodeTo != ''){
                if($tDocType == '0'){
                    $tSQL2 .= "AND (HD.FTXthBchFrm = '$tBchCodeFrm' OR HD.FTXthBchTo = '$tBchCodeTo')";
                }elseif ($tDocType == '1') {
                    $tSQL2 .= "AND (TboHD.FTXthBchFrm = '$tBchCodeFrm' OR TboHD.FTXthBchTo = '$tBchCodeTo')";
                }elseif ($tDocType == '2'){
                    $tSQL2 .= "AND (TbiHD.FTXthBchFrm = '$tBchCodeFrm' OR TbiHD.FTXthBchTo = '$tBchCodeTo')";
                }else{
                    $tSQL2 .= "AND (HD.FTXthBchFrm = '$tBchCodeFrm' OR HD.FTXthBchTo = '$tBchCodeTo')";
                }
            }else{
                $tSQL2 .= "";
            }
            
            if ($tStaDoc != '') {
                if($tDocType == '0'){
                    switch ($tStaDoc) {
                        case '1':
                            $tSQL2 .= " AND HD.FTXthStaDoc = '1' AND HD.FTXthStaApv IS NULL ";
                            break;
    
                        case '2':
                            $tSQL2 .= " AND HD.FTXthStaDoc = '1' AND HD.FTXthStaApv = '1' ";
                            break;
    
                        case '3':
                            $tSQL2 .= " AND HD.FTXthStaDoc = '3' ";
                            break;
                        
                        default:
                            $tSQL2 .= "";
                            break;
                    }
                }elseif ($tDocType == '1') {
                    switch ($tStaDoc) {
                        case '1':
                            $tSQL2 .= " AND TboHD.FTXthStaDoc = '1' AND TboHD.FTXthStaApv <> '1' ";
                            break;
    
                        case '2':
                            $tSQL2 .= " AND TboHD.FTXthStaDoc = '1' AND TboHD.FTXthStaApv = '1' ";
                            break;
    
                        case '3':
                            $tSQL2 .= " AND TboHD.FTXthStaDoc = '3' ";
                            break;
                        
                        default:
                            $tSQL2 .= "";
                            break;
                    }
                }elseif ($tDocType == '2'){
                    switch ($tStaDoc) {
                        case '1':
                            $tSQL2 .= " AND TbiHD.FTXthStaDoc = '1' AND TbiHD.FTXthStaApv <> '1' ";
                            break;
    
                        case '2':
                            $tSQL2 .= " AND TbiHD.FTXthStaDoc = '1' AND TbiHD.FTXthStaApv = '1' ";
                            break;
    
                        case '3':
                            $tSQL2 .= " AND TbiHD.FTXthStaDoc = '3' ";
                            break;
                        
                        default:
                            $tSQL2 .= "";
                            break;
                    }
                }
            }

            // จากวันที่เอกสาร - ถึงวันที่เอกสาร
            if(!empty($tDocDateForm) && !empty($tDocDateTo)){
                if($tDocType == '0'){
                    $tSQL2 .= " AND ((CONVERT(VARCHAR(10),HD.FDXthDocDate,121) BETWEEN '$tDocDateForm' AND '$tDocDateTo') OR (CONVERT(VARCHAR(10),HD.FDXthDocDate,121) BETWEEN '$tDocDateTo' AND '$tDocDateForm'))";
                }elseif ($tDocType == '1') {
                    $tSQL2 .= " AND ((CONVERT(VARCHAR(10),TboHD.FDXthDocDate,121) BETWEEN '$tDocDateForm' AND '$tDocDateTo') OR (CONVERT(VARCHAR(10),TboHD.FDXthDocDate,121) BETWEEN '$tDocDateTo' AND '$tDocDateForm'))";
                }elseif ($tDocType == '2'){
                    $tSQL2 .= " AND ((CONVERT(VARCHAR(10),TbiHD.FDXthDocDate,121) BETWEEN '$tDocDateForm' AND '$tDocDateTo') OR (CONVERT(VARCHAR(10),TbiHD.FDXthDocDate,121) BETWEEN '$tDocDateTo' AND '$tDocDateForm'))";
                }else{
                    $tSQL2 .= " AND ((CONVERT(VARCHAR(10),HD.FDXthDocDate,121) BETWEEN '$tDocDateForm' AND '$tDocDateTo') OR (CONVERT(VARCHAR(10),HD.FDXthDocDate,121) BETWEEN '$tDocDateTo' AND '$tDocDateForm'))";
                }
            }

            // สถานะใบรับโอน
            if( !empty($tStaDocTBI) && isset($tStaDocTBI) ){
                if( $tStaDocTBI == '1' ){
                    $tSQL2 .= " AND TRBRef.FTXthRefDocNo IS NOT NULL ";
                }else if( $tStaDocTBI == '2' ){
                    $tSQL2 .= " AND TRBRef.FTXthRefDocNo IS NULL ";
                }
            }

            $tSQL3 = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";

            $tMainSQL = $tSQL1.$tSQL2.$tSQL3;
            $oQuery = $this->db->query($tMainSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail    = $oQuery->result_array();
                // $aFoundRow = $this->FSnMSDTGetPageAll($paData, $nLngID);
                // $nFoundRow = $aFoundRow[0]->counts;

                $oPageQuery = $this->db->query($tSQL2);
                $nFoundRow  = $oPageQuery->num_rows();

                $nPageAll   = ceil($nFoundRow/$paData['nRow']);
                $aResult = array(
                    'aItems'   => $aDetail,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'tCode'    => '1',
                    'tDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rnAllRow' => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"=> 0,
                    'tCode' => '800',
                    'tDesc' => 'Data not found.',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

}