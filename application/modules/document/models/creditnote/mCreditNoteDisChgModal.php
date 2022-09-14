<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCreditNoteDisChgModal extends CI_Model {

    /**
     * Functionality: Get Data HDDis List
     * Parameters: function parameters
     * Creator:  21/06/2019 Piya
     * Last Modified: -
     * Return: Data Array
     * Return Type: Array
     */
    public function FSaMCreditNoteGetDisChgHDList($paDataCondition){
        $aRowLen            = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID             = $paDataCondition['FNLngID'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];
        $tDocNo = $paDataCondition['tDocNo'];
        $tBchCode = $paDataCondition['tBchCode'];
        $tSessionID = $paDataCondition['tSessionID'];
        // Advance Search
        $tSearchList        = ''; // $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = ''; // $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = ''; // $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = ''; // $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = ''; // $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaPrcStk   = ''; // $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY /*CONVERT(CHAR(10),FDXtdDateIns,103)*/ FTSessionID ASC) AS FNRowID,* FROM
                                (   SELECT DISTINCT
                                        HDDISTMP.FTBchCode,
                                        HDDISTMP.FTXthDocNo,
                                        FDXtdDateIns,
                                        HDDISTMP.FTXtdDisChgTxt,
                                        HDDISTMP.FTXtdDisChgType,
                                        HDDISTMP.FCXtdTotalAfDisChg,
                                        HDDISTMP.FCXtdTotalB4DisChg,
                                        HDDISTMP.FCXtdDisChg,
                                        HDDISTMP.FCXtdAmt,
                                        HDDISTMP.FTSessionID,
                                        HDDISTMP.FTLastUpdBy,
                                        HDDISTMP.FTCreateBy,
                                        CONVERT(CHAR(5), HDDISTMP.FDLastUpdOn,108) AS FDLastUpdOn,
                                        CONVERT(CHAR(5), HDDISTMP.FDCreateOn,108) AS FDCreateOn
                                    FROM TCNTDocHDDisTmp HDDISTMP WITH (NOLOCK)
                                    WHERE HDDISTMP.FTSessionID = '$tSessionID'
                                    AND HDDISTMP.FTBchCode = '$tBchCode'
                                    AND HDDISTMP.FTXthDocNo = '$tDocNo' " ;
        
        $tSQL   .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMDisChgCountPageHDDocListAll($paDataCondition);
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
    public function FSnMDisChgCountPageHDDocListAll($paDataCondition){
        $nLngID             = $paDataCondition['FNLngID'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];
        $tDocNo = $paDataCondition['tDocNo'];
        $tBchCode = $paDataCondition['tBchCode'];
        $tSessionID = $paDataCondition['tSessionID'];
        // Advance Search
        $tSearchList        = ''; // $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = ''; // $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = ''; // $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = ''; // $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = ''; // $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = ''; // $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove  = ''; // $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrcStk   = ''; // $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   =   "   SELECT COUNT (HDDISTMP.FTXthDocNo) AS counts
                        FROM TCNTDocHDDisTmp HDDISTMP WITH (NOLOCK)
                        WHERE HDDISTMP.FTSessionID = '$tSessionID'
                        AND HDDISTMP.FTBchCode = '$tBchCode'
                        AND HDDISTMP.FTXthDocNo = '$tDocNo'
                    ";
        
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
     * Functionality: Get Data DTDis List
     * Parameters: function parameters
     * Creator:  21/06/2019 Piya
     * Last Modified: -
     * Return: Data Array
     * Return Type: Array
     */
    public function FSaMCreditNoteGetDisChgDTList($paDataCondition){
        $aRowLen = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID = $paDataCondition['FNLngID'];
        $tDocNo = $paDataCondition['tDocNo'];
        $nSeqNo = $paDataCondition['nSeqNo'];
        $tBchCode = $paDataCondition['tBchCode'];
        $tSessionID = $paDataCondition['tSessionID'];

        $tSQL = "   SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER(ORDER BY /*CONVERT(CHAR(10), FDXtdDateIns,103)*/ FTSessionID ASC) AS FNRowID,* 
                        FROM
                            (SELECT DISTINCT
                                DTDISTMP.FTBchCode,
                                DTDISTMP.FTXthDocNo,
                                DTDISTMP.FNXtdSeqNo,
                                DTDISTMP.FTSessionID,
                                DTDISTMP.FDXtdDateIns,
                                DTDISTMP.FNXtdStaDis,
                                DTDISTMP.FTXtdDisChgType,
                                DTDISTMP.FCXtdNet,
                                DTDISTMP.FCXtdValue,
                                DTDISTMP.FTLastUpdBy,
                                DTDISTMP.FTCreateBy,
                                DTDISTMP.FDLastUpdOn,
                                DTDISTMP.FDCreateOn,
                                DTDISTMP.FTXtdDisChgTxt
                            FROM TCNTDocDTDisTmp DTDISTMP WITH (NOLOCK)
                            WHERE DTDISTMP.FNXtdStaDis = 1
                            AND DTDISTMP.FTSessionID = '$tSessionID'
                            AND DTDISTMP.FNXtdSeqNo = $nSeqNo    
                            AND DTDISTMP.FTBchCode = '$tBchCode'
                            AND DTDISTMP.FTXthDocNo = '$tDocNo'    
                            )" ;
        $tSQL .=  " Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMDisChgCountPageDTDocListAll($paDataCondition);
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
    public function FSnMDisChgCountPageDTDocListAll($paDataCondition){
        $nLngID = $paDataCondition['FNLngID'];
        $tDocNo = $paDataCondition['tDocNo'];
        $tBchCode = $paDataCondition['tBchCode'];
        $tSessionID = $paDataCondition['tSessionID'];

        $tSQL = "   SELECT COUNT (DTDISTMP.FTXthDocNo) AS counts
                        FROM TCNTDocDTDisTmp DTDISTMP WITH (NOLOCK)
                        WHERE DTDISTMP.FTSessionID = '$tSessionID'
                        AND DTDISTMP.FTBchCode = '$tBchCode'
                        AND DTDISTMP.FTXthDocNo = '$tDocNo'   
                    ";
        
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
     * Functionality : Function Add Edit HDDis in Temp
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteAddEditHDDisTemp($paParams, $paDisChgItems) {
        $tDocNo = $paParams['tDocNo'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        
        $aDisChgSummary = $paParams['aDisChgSummary'];
        
        // เพิ่ม
        $this->db->insert('TCNTDocHDDisTmp', array(
            'FTBchCode' => $tBchCode,
            'FTXthDocNo' => $tDocNo,
            'FDXtdDateIns' => $paDisChgItems['tCreatedAt'],
            'FTXtdDisChgTxt' => $paDisChgItems['tDisChgTxt'],
            'FTXtdDisChgType' => $paDisChgItems['nDisChgType'],
            'FCXtdTotalAfDisChg' => $paDisChgItems['cAfterDisChg'],
            'FCXtdTotalB4DisChg' => $paDisChgItems['cBeforeDisChg'], // $aDisChgSummary['cBeforeDisChgSum'],
            'FCXtdDisChg' => $paDisChgItems['cDisChgNum'],
            'FCXtdAmt' => $paDisChgItems['cDisChgValue'], // $paDisChgItems['cAfterDisChg'],
            'FTSessionID' => $tSessionID,

            'FDLastUpdOn' => date('Y-m-d h:i:s'),
            'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
            'FDCreateOn' => date('Y-m-d h:i:s'),
            'FTCreateBy' => $this->session->userdata('tSesUsername')
        ));

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Remove HDDis in Temp by SessionID
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteDeleteHDDisTemp($paParams) {
        
        $tDocNo = $paParams['tDocNo'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        
        // ลบ ใน Temp
        $this->db->where_in('FTSessionID', $tSessionID);
        // $this->db->where_in('FTBchCode', $tBchCode);
        // $this->db->where_in('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTDocHDDisTmp');
        
        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Get HDDis in Temp by SessionID
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteGetHDDisTemp($paParams) {
        
        $tDocNo = $paParams['tDocNo'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        
        $tSQL = "   SELECT
                        HDDISTMP.*
                    FROM TCNTDocHDDisTmp HDDISTMP 
                    WHERE FTSessionID = '$tSessionID' 
                    AND FTBchCode = '$tBchCode'    
                    AND FTXthDocNo = '$tDocNo'
                    ORDER BY HDDISTMP.FDXtdDateIns ASC";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result_array();
        }else{
            return [];
        }
        
    }
    
    /**
     * Functionality : Function Update HDDis in Temp by SessionID
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteUpdateHDDisTemp($paParams, $paDataUpd){
        
        $this->db->set('FTXtdDisChgTxt', $paDataUpd['FTXtdDisChgTxt']);
        $this->db->set('FCXtdTotalAfDisChg', $paDataUpd['FCXtdTotalAfDisChg']);
        $this->db->set('FCXtdTotalB4DisChg', $paDataUpd['FCXtdTotalB4DisChg']);
        $this->db->set('FCXtdAmt', $paDataUpd['FCXtdAmt']);
        $this->db->set('FDLastUpdOn', $paDataUpd['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paDataUpd['FTLastUpdBy']);
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FDXtdDateIns', $paParams['tDateIns']);
        $this->db->where('FTSessionID', $paParams['tSessionID']);
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);
        $this->db->update('TCNTDocHDDisTmp');

        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Update Fail',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Add Edit DTDis in Temp
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteAddEditDTDisTemp($paParams, $paDisChgItems) {
        $tDocNo = $paParams['tDocNo'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        
        $aDisChgSummary = $paParams['aDisChgSummary'];

        // เพิ่ม
        $this->db->insert('TCNTDocDTDisTmp', array(
            'FTBchCode' => $tBchCode,
            'FTXthDocNo' => $tDocNo,
            'FNXtdSeqNo' => $paDisChgItems['nSeqNo'],
            'FDXtdDateIns' => $paDisChgItems['tCreatedAt'],
            'FTXtdDisChgTxt' => $paDisChgItems['tDisChgTxt'],
            'FNXtdStaDis' => $paDisChgItems['tStaDis'],
            'FTXtdDisChgType' => $paDisChgItems['nDisChgType'],
            'FCXtdNet' => $paDisChgItems['cAfterDisChg'],
            'FCXtdValue' => $paDisChgItems['cDisChgValue'],
            // 'FCXtdDisChg' => $paDisChgItems['cDisChgNum'],
            // 'FCXtdAmt' => $aDisChgSummary['cAfterDisChgSum'],
            'FTSessionID' => $tSessionID,

            'FDLastUpdOn' => date('Y-m-d h:i:s'),
            'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
            'FDCreateOn' => date('Y-m-d h:i:s'),
            'FTCreateBy' => $this->session->userdata('tSesUsername')
        ));

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add.',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Remove DTDis in Temp by SessionID
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteDeleteDTDisTemp($paParams) {
        
        $tDocNo = $paParams['tDocNo'];
        $nSeqNo = $paParams['nSeqNo'];
        $tBchCode = $paParams['tBchCode'];
        $nStaDis = $paParams['nStaDis'];
        $tSessionID = $paParams['tSessionID'];
        
        // ลบ ใน Temp
        $this->db->where_in('FTSessionID', $tSessionID);
        
        if(!empty($nSeqNo)){
            $this->db->where_in('FNXtdSeqNo', $nSeqNo);
        }
        
        // $this->db->where_in('FTBchCode', $tBchCode);
        // $this->db->where_in('FTXthDocNo', $tDocNo);
        
        if(!empty($nStaDis)){
            $this->db->where_in('FNXtdStaDis', $nStaDis);
        }
        
        $this->db->delete('TCNTDocDTDisTmp');
        
        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Function Clear DisChgTxt DT in Temp by SessionID
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteClearDisChgTxtDTTemp($paParams) {
        
        $tDocNo = $paParams['tDocNo'];
        $nSeqNo = $paParams['nSeqNo'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        
        // ลบ ใน Temp
        $this->db->set('FTXtdDisChgTxt', '');
        $this->db->where_in('FTSessionID', $tSessionID);
        
        if(!empty($nSeqNo)){ // แก้ไขทั้งหมดถ้า $nSeqNo เป็นค่าว่าง
            $this->db->where_in('FNXtdSeqNo', $nSeqNo);
        }
        
        $this->db->where_in('FTBchCode', $tBchCode);
        $this->db->where_in('FTXthDocNo', $tDocNo);
        $this->db->update('TCNTDocDTTmp');
        
    }
    
    /**
     * Functionality : Function Get DTDis in Temp by SessionID
     * Parameters : function parameters
     * Creator : 27/06/2019 Piya
     * Last Modified : -
     * Return : Status Add Edit
     * Return Type : array
     */
    public function FSaMCreditNoteGetDTDisTemp($paParams) {
        
        $tDocNo = $paParams['tDocNo'];
        $nSeqNo = $paParams['nSeqNo'];
        $tBchCode = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        
        $tSQL = "   SELECT
                        DTDISTMP.*
                    FROM TCNTDocDTDisTmp DTDISTMP 
                    WHERE FNXtdSeqNo = $nSeqNo 
                    AND FTSessionID = '$tSessionID'
                    AND FTBchCode = '$tBchCode'    
                    AND FTXthDocNo = '$tDocNo'
                    ORDER BY DTDISTMP.FDXtdDateIns ASC";    
                    
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return 0;
        }
        
    }

    //เปิดมาหน้า ADD จะต้อง ลบสินค้าตัวเดิม where session
    public function FSaMCENDeletePDTInTmp($paParams){
        $tSessionID = $this->session->userdata('tSesSessionID');
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocDTTmp');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;
    }

    //หาราคาล่าสุด
    public function FSaMCENGetPriceAlwDiscount($paParams){
        $tSQL = "   SELECT SUM(FCXtdAmt) AS Total FROM TCNTDocDTTmp 
                    WHERE 
                        TCNTDocDTTmp.FTSessionID    = '".$paParams['tSessionID']."'
                    AND TCNTDocDTTmp.FTBchCode      = '".$paParams['tBCHCode']."'
                    AND TCNTDocDTTmp.FTXthDocNo     = '".$paParams['tDocno']."' AND FTXtdStaAlwDis = '1'  ";    
                
        $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return 0;
        }
    }

    //อัพเดท Text ส่วนลดให้
    public function FSaMPCUpdateDTDisInTemp($paDataInsert){
        $tPCDocNo       = $paDataInsert[0]['FTXthDocNo'];
        $nPCSeqNo       = $paDataInsert[0]['FNXtdSeqNo'];
        $tPCBchCode     = $paDataInsert[0]['FTBchCode'];
        $tPCSessionID   = $paDataInsert[0]['FTSessionID'];
        $tDisChgTxt     = '';

        for($i=0; $i<FCNnHSizeOf($paDataInsert); $i++){
            $tDisChgTxt  .= $paDataInsert[$i]['FTXtdDisChgTxt'] . ',';

            //ถ้าเป็นตัวท้ายให้ลบ comma ออก
            if($i == FCNnHSizeOf($paDataInsert) - 1 ){
                $tDisChgTxt = substr($tDisChgTxt,0,-1);
            }
        }

        $this->db->set('FTXtdDisChgTxt', $tDisChgTxt);
        $this->db->where_in('FTSessionID',$tPCSessionID);
        $this->db->where_in('FNXtdSeqNo',$nPCSeqNo);
        $this->db->where_in('FTBchCode',$tPCBchCode);
        $this->db->where_in('FTXthDocNo',$tPCDocNo);
        $this->db->update('TCNTDocDTTmp');
        return;
    }
}
