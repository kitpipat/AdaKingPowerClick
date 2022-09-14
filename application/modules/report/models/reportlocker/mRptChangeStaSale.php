<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptChangeStaSale extends CI_Model {

    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 04/04/2019 Wasin(Yoshi)
    //Last Modified : 12/12/2019 Napat(Jame)
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
         //เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];
        //กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];
        
        $tCallStore  =  "{ CALL SP_RPTxHisChgStaLocker003001001(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore  =  array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptCode'         => $paDataFilter['tRptCode'],
            'ptUsrSession'      => $paDataFilter['tUserSession'],
            
            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],

            'ptDocDateF'        => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'        => $paDataFilter['tDocDateTo'],
            'FNResult'          => 0
        );
        
        $oQuery   = $this->db->query($tCallStore,$aDataStore);
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }

    
    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 04/04/2019 Wasin(Yoshi)
    // Last Modified : 12/12/2019 Napat(Jame)
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere, $paDataFilter){

        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSession'];

        //Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   =   "   
            SELECT
                L.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTBchCode, FTShpCode, FTPosCode, FDXshActionDate, FTXshActionTime ASC) AS RowID,
                    A.*
                FROM TRPTRTHisChgStaLockerTmp A WITH(NOLOCK)
                WHERE A.FTComName    = '$tCompName'
                  AND A.FTRptCode    = '$tRptCode'
                  AND A.FTUsrSession = '$tSessionID'
            ) AS L
        ";

        // WHERE เงื่อนไข Page
        $tSQL .=  " WHERE L.RowID > $aRowLen[0] AND L.RowID <= $aRowLen[1] ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .=  " ORDER BY L.FTBchCode ASC, L.FTShpCode ,L.FTPosCode, FDXshActionDate, FTXshActionTime ASC ";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataRpt       = $oQuery->result_array();
            $oCountRowRpt   = $this->FSnMCountRowInTemp($paDataWhere);
            $nFoundRow      = $oCountRowRpt;
            $nPageAll       = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData    = array(
                'raItems'       => $aDataRpt,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aReturnData    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($oCountRowRpt);
        unset($nFoundRow);
        unset($nPageAll);
        return $aReturnData; 
    }

    /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 11/12/2019 Napat(Jame)
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere) {

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUserSession'];

        $tSQL = "   
            UPDATE TRPTRTHisChgStaLockerTmp SET 
                FNRowPartID = B.PartID
            FROM(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode,FTPosCode ORDER BY FTBchCode, FTShpCode, FTPosCode, FDXshActionDate, FTXshActionTime ASC ) AS PartID,
                    FTRptRowSeq
                FROM TRPTRTHisChgStaLockerTmp TDPT WITH(NOLOCK)
                WHERE TDPT.FTComName = '$tComName' 
                AND TDPT.FTRptCode = '$tRptCode'
                AND TDPT.FTUsrSession = '$tUsrSession'
            ) AS B
            WHERE TRPTRTHisChgStaLockerTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTRTHisChgStaLockerTmp.FTComName = '$tComName' 
            AND TRPTRTHisChgStaLockerTmp.FTRptCode = '$tRptCode'
            AND TRPTRTHisChgStaLockerTmp.FTUsrSession = '$tUsrSession'
        ";
        
        $this->db->query($tSQL);
    }
   

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 12/12/2019 Napat(Jame)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    // public function FSaMCountDataReportAll($paDataWhere){
    public function FSnMCountRowInTemp($paParams){
        $tComName    = $paParams['tCompName'];
        $tRptCode    = $paParams['tRptCode'];
        $tUsrSession = $paParams['tUserSession'];
        
        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTRTHisChgStaLockerTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName       = '$tComName'
            AND TMP.FTRptCode       = '$tRptCode'
            AND TMP.FTUsrSession    = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
    }

}
