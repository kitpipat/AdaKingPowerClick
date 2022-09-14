<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class managecoupon_model extends CI_Model {

    public function FSaMMCPGetDataTableList($paDataCondition){
        $aRowLen                = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                 = $paDataCondition['FNLngID'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        $aExpireConfig          = $paDataCondition['aExpireConfig'];

        // Advance Search
        $tSearchList         = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCode      = $aAdvanceSearch['tSearchBchCode'];
        $tSearchDocDateFrom  = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo    = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc       = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaDocType   = $aAdvanceSearch['tSearchStaDocType'];
        $tAddDateType        = $aExpireConfig['tAddDateType'];
        $nValueExpire        = $aExpireConfig['nValueExpire'];

        $tSQL1 =   " SELECT c.* FROM ( SELECT ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID, * FROM ( ";
        $tSQL2 =   "    SELECT
                            HD.FTBchCode,
                            BCHL.FTBchName,
                            SALE.FTXshDocNo AS FTDocNo,
                            CONVERT(VARCHAR(10),SALE.FDXshDocDate,121) AS FDDocDate,
                            HD.FTBkpType AS FNCouponType,
                            HD.FTBkpRef2 AS FTRefCode,
                            CONVERT(VARCHAR,HD.FDBkpDate,120) AS FDStartDate,
                            HD.FTBkpStatus AS FNStaUse,
                            HD.FDCreateOn
                        FROM TCNTBookingPrc      HD WITH(NOLOCK)
                        LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        INNER JOIN TPSTSalHD   SALE WITH(NOLOCK) ON SALE.FTXshDocNo = HD.FTBkpRef1 AND SALE.FTBchCode = HD.FTBchCode
                        WHERE 1=1 
                    ";

        $tSesUsrLevel           = $this->session->userdata("tSesUsrLevel");
        $tSesUsrBchCodeMulti    = $this->session->userdata("tSesUsrBchCodeMulti");
        if( $tSesUsrLevel != "HQ" ){
            $tSQL2   .= " AND HD.FTBchCode IN ($tSesUsrBchCodeMulti) ";
        }

        // ค้นหา สาขา
        if( isset($tSearchBchCode) && !empty($tSearchBchCode) ){
            $tSQL2   .= " AND HD.FTBchCode = '$tSearchBchCode' ";
        }

        // ต้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if( isset($tSearchList) && !empty($tSearchList) ){
            $tSQL2 .=  " AND ((SALE.FTXshDocNo  LIKE '%$tSearchList%') OR
                              (BCHL.FTBchName   LIKE '%$tSearchList%') OR
                              (HD.FTBkpRef2     LIKE '%$tSearchList%')) ";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if( !empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo) ){
            $tSQL2   .= " AND (CONVERT(VARCHAR(10),SALE.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) OR
                               CONVERT(VARCHAR(10),SALE.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121)) ";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            
            // กำหนดเอง : 1:ชั่วโมง 2:วัน
            if( $tAddDateType == '1' ){
                $tDateType      = "HOUR";
                // ถ้า options เป็นชั่วโมง เอาทั้งวันที่และเวลา
                $tSQLDate1      = " GETDATE() ";
                $tSQLDate2      = " HD.FDBkpDate ";
            }else{
                $tDateType      = "DAY";
                $nValueExpire   = $nValueExpire - 1;
                // ถ้า options เป็นวัน ต้อง convert เอาเฉพาะวันที่ ไม่เอาเวลา
                $tSQLDate1      = " CONVERT(DATE,GETDATE(),121) ";
                $tSQLDate2      = " CONVERT(DATE,HD.FDBkpDate,121) ";
            }

            switch($tSearchStaDoc){
                case '1':
                    $tSQL2 .= " AND HD.FTBkpStatus = '1' AND $tSQLDate1 <= DATEADD($tDateType,$nValueExpire, $tSQLDate2) "; // จอง
                    break;
                case '2':
                    $tSQL2 .= " AND HD.FTBkpStatus = '2' AND $tSQLDate1 <= DATEADD($tDateType,$nValueExpire, $tSQLDate2) "; // รับบางส่วน
                    break;
                case '3':
                    $tSQL2 .= " AND HD.FTBkpStatus = '3' "; // รับทั้งหมด
                    break;
                case '4':
                    $tSQL2 .= " AND HD.FTBkpStatus = '4' "; // ยกเลิก
                    break;
                case 'EXP':
                    $tSQL2 .= " AND HD.FTBkpStatus = '1' AND $tSQLDate1 > DATEADD($tDateType,$nValueExpire, $tSQLDate2) "; // หมดอายุ
                    break;
            }
        }

        // ค้นหาประเภท
        if( isset($tSearchStaDocType) && !empty($tSearchStaDocType) ){
            if( $tSearchStaDocType != 0 ){
                $tSQL2 .= " AND HD.FTBkpType = '$tSearchStaDocType' ";
            }
        }

        $tSQL3 = ") Base ) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        
        $tSQL   = $tSQL1.$tSQL2.$tSQL3;
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        if( $oQuery->num_rows() > 0 ){

            $tSQLRow            = $tSQL2;
            $oQueryRow          = $this->db->query($tSQLRow);
            $nFoundRow          = $oQueryRow->num_rows();
            $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'aItems'       => $oQuery->result_array(),
                'nAllRow'      => $nFoundRow,
                'nCurrentPage' => $paDataCondition['nPage'],
                'nAllPage'     => $nPageAll,
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'nAllRow'      => 0,
                'nCurrentPage' => $paDataCondition['nPage'],
                "nAllPage"     => 0,
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    public function FSaMMCPGetDetailList($paDataCondition){

        $nLngID     = $paDataCondition['FNLngID'];
        $tBchCode   = $paDataCondition['tBchCode'];
        $tDocNo     = $paDataCondition['tDocNo'];
        $tType      = $paDataCondition['tType'];

        $tSQL   = " SELECT
                        DT.FTBkpRef1,
                        DT.FNBkdSeq,
                        DT.FTPdtCode,
                        PDTL.FTPdtName,
                        DT.FCBkdQty,
                        DT.FCBkdQtyRcv,
                        DT.FTPosCode,
                        POSL.FTPosName,
                        DT.FTBkdDocRef
                    FROM TCNTBookingPrcDT DT	WITH(NOLOCK)
                    INNER JOIN TCNMPdt_L  PDTL	WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
                    LEFT JOIN TCNMPos_L   POSL  WITH(NOLOCK) ON DT.FTBchCode = POSL.FTBchCode AND DT.FTPosCode = POSL.FTPosCode AND POSL.FNLngID = $nLngID
                    WHERE DT.FTBchCode = '$tBchCode'
                      AND DT.FTBkpRef1 = '$tDocNo'
                      AND DT.FTBkpType = '$tType'
                    ORDER BY FNBkdSeq ASC ";
        
        // echo $tSQL;
        // exit();
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 03/02/2022
    public function FSaMMCPAdjustStatus($paDataCondition){

        $tDocNoMulti    = $paDataCondition['tDocNoMulti'];
        $tEventAction   = $paDataCondition['tEventAction'];
        
        if( $tEventAction == '1' ){
            $tBkpStatus = '4';
        }else{
            $tBkpStatus = '1';
        }

        $this->db->trans_begin();
        $tSQL = " UPDATE TCNTBookingPrc SET FTBkpStatus = '$tBkpStatus' WHERE FTBkpRef1 IN ('$tDocNoMulti') ";
        $this->db->query($tSQL);

        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aResult = array(
                'tCode'        => '800',
                'tDesc'        => $this->db->error()['message'],
            );
        }else{
            $this->db->trans_commit();
            $aResult = array(
                'tCode'        => '1',
                'tDesc'        => 'Adjust Status Success.',
            );
        }
        return $aResult;
    }


}