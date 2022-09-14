<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCreditNoteRefPIModal extends CI_Model {

    /**
     * Functionality: Get Data Purchase Invoice HD List
     * Parameters: function parameters
     * Creator:  21/06/2019 Piya
     * Last Modified: -
     * Return: Data Array
     * Return Type: Array
     */
    public function FSaMCreditNoteGetPIHDList($paDataCondition){
        $aRowLen            = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID             = $paDataCondition['FNLngID'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList        = ''; // $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = ''; // $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = ''; // $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = ''; // $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = ''; // $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaPrcStk   = ''; // $aAdvanceSearch['tSearchStaPrcStk'];
        
        $tSearchStaDoc      = $paDataCondition['tStaDoc'];
        $tSearchStaApprove  = $paDataCondition['tStaApv'];
        $tSearchStaDocAct   = $paDataCondition['tStaDocAct'];
        $tSearchStaRef      = $paDataCondition['tStaRef'];
        $tBranch            = $paDataCondition['tBranch'];

        $tSQL = "   
            SELECT 
                c.* 
            FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTXphDocNo DESC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        PIHD.FTBchCode,
                        PIHD.FTSplCode,
                        PIHD.FTShpCode,
                        PIHD.FTWahCode,
                        BCHL.FTBchName,
                        PIHD.FTXphDocNo,
                        PIHD.FTXphVATInOrEx,
                        CONVERT(CHAR(10),PIHD.FDXphDocDate,103) AS FDXphDocDate,
                        CONVERT(CHAR(5), PIHD.FDXphDocDate,108) AS FTXphDocTime,
                        PIHD.FTXphStaDoc,
                        PIHD.FTXphStaApv,
                        PIHD.FTXphStaPrcStk,
                        PIHD.FTCreateBy,
                        PIHD.FDCreateOn,
                        USRL.FTUsrName AS FTCreateByName,
                        PIHD.FTXphApvCode,
                        SPLL.FTSplName,
                        SHPL.FTShpName,
                        WAHL.FTWahName,
                        USRLAPV.FTUsrName   AS FTXphApvName
                    FROM TAPTPiHD           PIHD    WITH (NOLOCK)
                    LEFT JOIN TCNMSpl_L SPLL WITH (NOLOCK) ON PIHD.FTSplCode = SPLL.FTSplCode AND SPLL.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L  BCHL    WITH (NOLOCK) ON PIHD.FTBchCode = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID 
                    LEFT JOIN TCNMUser_L    USRL    WITH (NOLOCK) ON PIHD.FTCreateBy = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                    LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON PIHD.FTXphApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                    LEFT JOIN TCNMShop_L    SHPL WITH (NOLOCK) ON PIHD.FTShpCode = SHPL.FTShpCode AND PIHD.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                    LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON PIHD.FTWahCode = WAHL.FTWahCode AND PIHD.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $nLngID
                    WHERE 1=1
        ";

        // ค้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((PIHD.FTXphDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),PIHD.FDXphDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((PIHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (PIHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((PIHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (PIHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะประมวลผล
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND PIHD.FTXphStaPrcStk = '$tSearchStaPrcStk' OR PIHD.FTXphStaPrcStk = '' ";
            }else{
                $tSQL .= " AND PIHD.FTXphStaPrcStk = '$tSearchStaPrcStk'";
            }
        }
        
        // ค้นหาสถานะเอกสาร
        if($tSearchStaDoc != 0){
            if($tSearchStaDoc == 1){ // สมบูรณ์
                $tSQL .= " AND PIHD.FTXphStaDoc = '1'";
            }
            if($tSearchStaDoc == 2){ // ไม่สมบูรณ์
                $tSQL .= " AND PIHD.FTXphStaDoc = '2'";
            }
            if($tSearchStaDoc == 3){ // ยกเลิก
                $tSQL .= " AND PIHD.FTXphStaDoc = '3'";
            }
        }

        // ค้นหาสถานะอนุมัติ
        if($tSearchStaApprove != 0){
            if($tSearchStaApprove == 1){ // อนุมัติ
                $tSQL .= " AND PIHD.FTXphStaApv = '1'";
            }
            if($tSearchStaApprove == 2){ // ยังไม่อนุมัติ
                $tSQL .= " AND PIHD.FTXphStaApv = ''";
            }
        }

        // ค้นหาสถานะอ้างอิง
        if($tSearchStaRef != 0){
            if($tSearchStaRef == 1){ // ไม่เคยอ้างอิง
                $tSQL .= " AND PIHD.FNXphStaRef = '0'";
            }
            if($tSearchStaRef == 2){ // อ้างอิงบางส่วน
                $tSQL .= " AND PIHD.FNXphStaRef = '1'";
            }
            if($tSearchStaRef == 3){ // อ้างอิงหมดแล้ว
                $tSQL .= " AND PIHD.FNXphStaRef = '2'";
            }
        }
        
        // ค้นหาสถานะเคลื่อนไหว
        if($tSearchStaDocAct != 0){
            if($tSearchStaDocAct == 1){ // เคลื่อนไหว
                $tSQL .= " AND PIHD.FNXphStaDocAct = '1'";
            }
            if($tSearchStaDocAct == 2){ // ไม่เคลื่อนไหว
                $tSQL .= " AND PIHD.FNXphStaDocAct = '0'";
            }
        }

        //ค้นหาตามสาขา
        if(!empty($tBranch)){
            $tSQL .= " AND PIHD.FTBchCode = '$tBranch' ";
        }
        
        $tSQL   .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMPICountPageHDDocListAll($paDataCondition);
            $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1')? $aDataCountAllRow['rtCountData'] : 0;
            $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $oDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }
    
    /**
     * Functionality: Data Get Data Page All
     * Parameters: function parameters
     * Creator:  21/06/2019 Piya
     * Last Modified: -
     * Return: Data Array
     * Return Type: Array
     */
    public function FSnMPICountPageHDDocListAll($paDataCondition){
        $nLngID             = $paDataCondition['FNLngID'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];
        $tBranch            = $paDataCondition['tBranch'];

        $tSearchStaDoc      = $paDataCondition['tStaDoc'];
        $tSearchStaApprove  = $paDataCondition['tStaApv'];
        $tSearchStaDocAct   = $paDataCondition['tStaDocAct'];
        $tSearchStaRef      = $paDataCondition['tStaRef'];
        $tBranch            = $paDataCondition['tBranch'];

        // Advance Search
        $tSearchList        = ''; // $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = ''; // $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = ''; // $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = ''; // $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = ''; // $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = ''; // $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove  = ''; // $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrcStk   = ''; // $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   =   "   SELECT COUNT (PIHD.FTXphDocNo) AS counts
                        FROM TAPTPiHD PIHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON PIHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        WHERE 1=1
                    ";
        
        // นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((PIHD.FTXphDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),PIHD.FDXphDocDate,103) LIKE '%$tSearchList%'))";
        }
        
        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((PIHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (PIHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((PIHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (PIHD.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND PIHD.FTXphStaDoc = '$tSearchStaDoc' OR PIHD.FTXphStaDoc = ''";
            }else{
                $tSQL .= " AND PIHD.FTXphStaDoc = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะอนุมัติ
        if(isset($tSearchStaApprove) && !empty($tSearchStaApprove)){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND PIHD.FTXphStaApv = '$tSearchStaApprove' OR PIHD.FTXphStaApv = '' ";
            }else{
                $tSQL .= " AND PIHD.FTXphStaApv = '$tSearchStaApprove'";
            }
        }

        // ค้นหาสถานะประมวลผล
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND PIHD.FTXphStaPrcStk = '$tSearchStaPrcStk' OR PIHD.FTXphStaPrcStk = '' ";
            }else{
                $tSQL .= " AND PIHD.FTXphStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

         // ค้นหาสถานะเอกสาร
         if($tSearchStaDoc != 0){
            if($tSearchStaDoc == 1){ // สมบูรณ์
                $tSQL .= " AND PIHD.FTXphStaDoc = '1'";
            }
            if($tSearchStaDoc == 2){ // ไม่สมบูรณ์
                $tSQL .= " AND PIHD.FTXphStaDoc = '2'";
            }
            if($tSearchStaDoc == 3){ // ยกเลิก
                $tSQL .= " AND PIHD.FTXphStaDoc = '3'";
            }
        }

        // ค้นหาสถานะอนุมัติ
        if($tSearchStaApprove != 0){
            if($tSearchStaApprove == 1){ // อนุมัติ
                $tSQL .= " AND PIHD.FTXphStaApv = '1'";
            }
            if($tSearchStaApprove == 2){ // ยังไม่อนุมัติ
                $tSQL .= " AND PIHD.FTXphStaApv = ''";
            }
        }

        // ค้นหาสถานะอ้างอิง
        if($tSearchStaRef != 0){
            if($tSearchStaRef == 1){ // ไม่เคยอ้างอิง
                $tSQL .= " AND PIHD.FNXphStaRef = '0'";
            }
            if($tSearchStaRef == 2){ // อ้างอิงบางส่วน
                $tSQL .= " AND PIHD.FNXphStaRef = '1'";
            }
            if($tSearchStaRef == 3){ // อ้างอิงหมดแล้ว
                $tSQL .= " AND PIHD.FNXphStaRef = '2'";
            }
        }
        
        // ค้นหาสถานะเคลื่อนไหว
        if($tSearchStaDocAct != 0){
            if($tSearchStaDocAct == 1){ // เคลื่อนไหว
                $tSQL .= " AND PIHD.FNXphStaDocAct = '1'";
            }
            if($tSearchStaDocAct == 2){ // ไม่เคลื่อนไหว
                $tSQL .= " AND PIHD.FNXphStaDocAct = '0'";
            }
        }

        //ค้นหาตามสาขา
        if(!empty($tBranch)){
            $tSQL .= " AND PIHD.FTBchCode = '$tBranch' ";
        }
        
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }
    
    /**
     * Functionality: Get Data Purchase Invoice HD List
     * Parameters: function parameters
     * Creator:  21/06/2019 Piya
     * Last Modified: -
     * Return: Data Array
     * Return Type: Array
     */
    public function FSaMCreditNoteGetPIDTList($paDataCondition){
        $aRowLen = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID = $paDataCondition['FNLngID'];
        $tDocNo = $paDataCondition['tDocNo'];

        $tSQL = "   SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER(ORDER BY FTXphDocNo DESC) AS FNRowID,* 
                        FROM
                            (SELECT DISTINCT
                                PIDT.FTXphDocNo,
                                PIDT.FTPdtCode,
                                PIDT.FTXpdBarCode,
                                PIDT.FTXpdPdtName,
                                PIDT.FTPunName,
                                PIDT.FTPunCode,
                                PIDT.FCXpdQty,
                                PIDT.FCXpdSetPrice,
                                PIDT.FCXpdNet,
                                PIDT.FTXpdDisChgTxt,
                                PIDT.FTVatCode,
                                PIDT.FCXpdVatRate
                            FROM TAPTPiDT PIDT WITH (NOLOCK)
                            WHERE FTXphDocNo = '$tDocNo')" ;
        $tSQL .=  " Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMPICountPageDTDocListAll($paDataCondition);
            $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1')? $aDataCountAllRow['rtCountData'] : 0;
            $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $oDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }
    
    /**
     * Functionality: Data Get Data Page All
     * Parameters: function parameters
     * Creator:  21/06/2019 Piya
     * Last Modified: -
     * Return: Data Array
     * Return Type: Array
     */
    public function FSnMPICountPageDTDocListAll($paDataCondition){

        $nLngID = $paDataCondition['FNLngID'];
        $tDocNo = $paDataCondition['tDocNo'];

        $tSQL = "   
            SELECT 
                PIDT.FTXphDocNo
            FROM TAPTPiDT PIDT WITH (NOLOCK)
            WHERE FTXphDocNo = '$tDocNo'
        ";
        
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->num_rows();
            $aDataReturn =  array(
                'rtCountData' => $aDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aDataReturn  =  array(
                'rtCode' => '800',
                'rtDesc' => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }
}
