<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPurchaseInvoiceDisChgModal extends CI_Model {


    // Functionality: Get Data HD Dis List
    // Parameters: function parameters
    // Creator:  02/07/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMPIGetDisChgHDList($paDataCondition){
        $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID         = $paDataCondition['FNLngID'];
        $aAdvanceSearch = $paDataCondition['aAdvanceSearch'];
        $tDocNo         = $paDataCondition['tDocNo'];
        $tBchCode       = $paDataCondition['tBchCode'];
        $tSessionID     = $paDataCondition['tSessionID'];
        
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
                                        HDDISTMP.FDXtdDateIns,
                                        HDDISTMP.FTXtdDisChgTxt,
                                        HDDISTMP.FTXtdDisChgType,
                                        HDDISTMP.FCXtdTotalAfDisChg,
                                        HDDISTMP.FCXtdTotalB4DisChg,
                                        HDDISTMP.FCXtdDisChg,
                                        HDDISTMP.FCXtdAmt,
                                        HDDISTMP.FTSessionID,
                                        HDDISTMP.FTLastUpdBy,
                                        HDDISTMP.FTCreateBy,
                                        CONVERT(CHAR(5), HDDISTMP.FDLastUpdOn,108)  AS FDLastUpdOn,
                                        CONVERT(CHAR(5), HDDISTMP.FDCreateOn,108)   AS FDCreateOn
                                    FROM TCNTDocHDDisTmp HDDISTMP WITH (NOLOCK)
                                    WHERE 1=1 
                                    AND HDDISTMP.FTSessionID    = '$tSessionID'
                                    AND HDDISTMP.FTBchCode      = '$tBchCode'
                                    AND HDDISTMP.FTXthDocNo     = '$tDocNo' " ;
        $tSQL   .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMPIDisChgCountPageHDDocListAll($paDataCondition);
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


    // Functionality: Data Get Data HD Dis List All
    // Parameters: function parameters
    // Creator:  02/07/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSnMPIDisChgCountPageHDDocListAll($paDataCondition){
        $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID         = $paDataCondition['FNLngID'];
        $aAdvanceSearch = $paDataCondition['aAdvanceSearch'];
        $tDocNo         = $paDataCondition['tDocNo'];
        $tBchCode       = $paDataCondition['tBchCode'];
        $tSessionID     = $paDataCondition['tSessionID'];
        // Advance Search
        $tSearchList        = ''; // $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = ''; // $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = ''; // $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = ''; // $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = ''; // $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaPrcStk   = ''; // $aAdvanceSearch['tSearchStaPrcStk'];
        
        $tSQL   =   "   SELECT
                            COUNT (HDDISTMP.FTXthDocNo) AS counts
                        FROM TCNTDocHDDisTmp HDDISTMP WITH (NOLOCK)
                        WHERE 1=1 
                        AND HDDISTMP.FTSessionID    = '$tSessionID'
                        AND HDDISTMP.FTBchCode      = '$tBchCode'
                        AND HDDISTMP.FTXthDocNo     = '$tDocNo'
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

    
    // Functionality: Get Data DT Dis List
    // Parameters: function parameters
    // Creator: 02/07/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMPIGetDisChgDTList($paDataCondition){
        $aRowLen    = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID     = $paDataCondition['FNLngID'];
        $tDocNo     = $paDataCondition['tDocNo'];
        $nSeqNo     = $paDataCondition['nSeqNo'];
        $tBchCode   = $paDataCondition['tBchCode'];
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
                            AND DTDISTMP.FTSessionID    = '$tSessionID'
                            AND DTDISTMP.FNXtdSeqNo     = $nSeqNo    
                            AND DTDISTMP.FTBchCode      = '$tBchCode'
                            AND DTDISTMP.FTXthDocNo     = '$tDocNo'
                            )" ;
        $tSQL .=  " Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMPIDisChgCountPageDTDocListAll($paDataCondition);
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

    
    // Functionality: Data Get Data DT Dis Page All
    // Parameters: function parameters
    // Creator:  02/07/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSnMPIDisChgCountPageDTDocListAll($paDataCondition){
        $nLngID     = $paDataCondition['FNLngID'];
        $tDocNo     = $paDataCondition['tDocNo'];
        $tBchCode   = $paDataCondition['tBchCode'];
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

    
    // Functionality : Function Remove DT Dis in Temp by SessionID
    // Parameters : function parameters
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Add Edit
    // Return Type : array
    public function FSaMPIDeleteDTDisTemp($paParams){
        $tPIDocNo       = $paParams['tPIDocNo'];
        $nPISeqNo       = $paParams['nPISeqNo'];
        $tPIBchCode     = $paParams['tPIBchCode'];
        $nPIStaDis      = $paParams['nPIStaDis'];
        $tPISessionID   = $paParams['tPISessionID'];
        $this->db->where_in('FTSessionID',$tPISessionID);
        if(isset($nPISeqNo) && !empty($nPISeqNo)){
            $this->db->where_in('FNXtdSeqNo',$nPISeqNo);
        }
        $this->db->where_in('FTBchCode',$tPIBchCode);
        $this->db->where_in('FTXthDocNo',$tPIDocNo);
        if(isset($nPIStaDis) && !empty($nStaDis)){
            $this->db->where_in('FNXtdStaDis',$tPIDocNo);
        }
        $this->db->delete('TCNTDocDTDisTmp');
        return;
    }

    // Functionality : Function Clear DisChgTxt DT in Temp by SessionID
    // Parameters : function parameters
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Add Edit
    // Return Type : array
    public function FSaMPIClearDisChgTxtDTTemp($paParams){
        $tPIDocNo       = $paParams['tPIDocNo'];
        $nPISeqNo       = $paParams['nPISeqNo'];
        $tPIBchCode     = $paParams['tPIBchCode'];
        $tPISessionID   = $paParams['tPISessionID'];
        
        // ลบ ใน Temp
        $this->db->set('FTXtdDisChgTxt', '');
        $this->db->where_in('FTSessionID',$tPISessionID);
        $this->db->where_in('FNXtdSeqNo',$nPISeqNo);
        $this->db->where_in('FTBchCode',$tPIBchCode);
        $this->db->where_in('FTXthDocNo',$tPIDocNo);
        $this->db->update('TCNTDocDTTmp');
        return;
    }

    // Functionality : Function Add Edit DT Dis in Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Add Edit
    // Return Type : array
    public function FSaMPIAddEditDTDisTemp($paDataInsert){
        // เพิ่ม
        $this->db->insert_batch('TCNTDocDTDisTmp',$paDataInsert);
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
                'rtDesc' => 'Error Not Insert DT Dis Temp.',
            );
        }
        return $aStatus;
    }

    //อัพเดท Text ส่วนลดให้
    public function FSaMPIUpdateDTDisInTemp($paDataInsert){
        $tPIDocNo       = $paDataInsert[0]['FTXthDocNo'];
        $nPISeqNo       = $paDataInsert[0]['FNXtdSeqNo'];
        $tPIBchCode     = $paDataInsert[0]['FTBchCode'];
        $tPISessionID   = $paDataInsert[0]['FTSessionID'];
        $tDisChgTxt     = '';

        for($i=0; $i<FCNnHSizeOf($paDataInsert); $i++){
            $tDisChgTxt  .= $paDataInsert[$i]['FTXtdDisChgTxt'] . ',';

            //ถ้าเป็นตัวท้ายให้ลบ comma ออก
            if($i == FCNnHSizeOf($paDataInsert) - 1 ){
                $tDisChgTxt = substr($tDisChgTxt,0,-1);
            }
        }

        // $this->db->set('FTXtdDisChgTxt', 'CONCAT(FTXtdDisChgTxt,\',\',\''.$tDisChgTxt.'\')', FALSE);
        $this->db->set('FTXtdDisChgTxt', $tDisChgTxt);
        $this->db->where_in('FTSessionID',$tPISessionID);
        $this->db->where_in('FNXtdSeqNo',$nPISeqNo);
        $this->db->where_in('FTBchCode',$tPIBchCode);
        $this->db->where_in('FTXthDocNo',$tPIDocNo);
        $this->db->update('TCNTDocDTTmp');
        return;
    }
    
    // Functionality : Function Remove HD Dis in Temp by SessionID
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Add Edit
    // Return Type : array
    public function FSaMPIDeleteHDDisTemp($paParams){
        $tPIDocNo       = $paParams['tPIDocNo'];
        $tPIBchCode     = $paParams['tPIBchCode'];
        $tPISessionID   = $paParams['tPISessionID'];

        // ลบ ข้อมูล HD Dis Temp
        $this->db->where('FTSessionID',$tPISessionID);
        $this->db->where('FTXthDocNo',$tPIDocNo);
        $this->db->where('FTBchCode',$tPIBchCode);
        $this->db->delete('TCNTDocHDDisTmp');

        // ลบข้อมูล DT Dis Temp
        $this->db->where('FNXtdStaDis',2);
        $this->db->where('FTSessionID',$tPISessionID);
        $this->db->where('FTXthDocNo',$tPIDocNo);
        $this->db->where('FTBchCode',$tPIBchCode);
        $this->db->delete('TCNTDocDTDisTmp');
        return;
    }

    // Functionality : Function Add Edit DT Dis in Temp
    // Parameters : function parameters
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Add Edit
    // Return Type : array
    public function FSaMPIAddEditHDDisTemp($paDataInsert){
        // เพิ่ม
        $this->db->insert_batch('TCNTDocHDDisTmp',$paDataInsert);
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
                'rtDesc' => 'Error Not Insert HD Dis Temp.',
            );
        }
        return $aStatus;
    }



















}
