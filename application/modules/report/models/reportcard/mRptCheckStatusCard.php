<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptCheckStatusCard extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 01/11/2019 Piya
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {

        $nLngID     = $paDataFilter['nLngID'];
        $tCompName  = $paDataFilter['tCompName'];
        $tRptCode   = $paDataFilter['tRptCode'];

        // ประเภทบัตร
        $tCrdTypeFrom   = empty($paDataFilter['tCardTypeCodeFrom']) ? '' : $paDataFilter['tCardTypeCodeFrom']; 
        $tCrdTypeTo     = empty($paDataFilter['tCardTypeCodeTo']) ? '' : $paDataFilter['tCardTypeCodeTo']; 
        // สถานะบัตร
        $tCrdStaActiveFrom  = empty($paDataFilter['tStaCardFrom']) ? '' : $paDataFilter['tStaCardFrom']; 
        $tCrdStaActiveTo    = empty($paDataFilter['tStaCardTo']) ? '' : $paDataFilter['tStaCardTo']; 
        // วันที่เริ่มใช้งาน
        $tStartDateFrom = empty($paDataFilter['tDateStartFrom']) ? '' : $paDataFilter['tDateStartFrom']; 
        $tStartDateTo   = empty($paDataFilter['tDateStartTo']) ? '' : $paDataFilter['tDateStartTo']; 
        // วันหมดอายุ
        $tExpDateFrom   = empty($paDataFilter['tDateExpireFrom']) ? '' : $paDataFilter['tDateExpireFrom']; 
        $tExpDateTo     = empty($paDataFilter['tDateExpireTo']) ? '' : $paDataFilter['tDateExpireTo']; 
        // รหัสเลขหลังบัตร
        $tCardCodeFrom  = empty($paDataFilter['tCardCodeFrom']) ? '' : $paDataFilter['tCardCodeFrom']; 
        $tCardCodeTo    = empty($paDataFilter['tCardCodeTo']) ? '' : $paDataFilter['tCardCodeTo']; 
        // วันที่สร้างเอกสาร
        $tDocDateFrom   = empty($paDataFilter['tDocDateFrom']) ? '' : $paDataFilter['tDocDateFrom']; 
        $tDocDateTo     = empty($paDataFilter['tDocDateTo']) ? '' : $paDataFilter['tDocDateTo']; 

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tAgnCodeSelect  = $paDataFilter['tAgnCodeSelect'];
            

        $tCallStore = "{CALL SP_RPTxCheckStatusCard(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLngID,
            'pnComName'         => $tCompName,
            'ptRptName'         => $tRptCode,
            'ptUsrSession'      => $paDataFilter['tUserSessionID'],
            'pnFilterType'      => $paDataFilter['tTypeSelect'],
            'ptAgnL'            => $tAgnCodeSelect,
            'ptBchL'            => '',
            'ptBchF'            => '',
            'ptBchT'            => '',
            'ptMerL'            => $tMerCodeSelect,
            'ptMerF'            => $paDataFilter['tMerCodeFrom'],
            'ptMerT'            => $paDataFilter['tMerCodeTo'],
            'ptShpL'            => $tShpCodeSelect,
            'ptShpF'            => $paDataFilter['tShpCodeFrom'],
            'ptShpT'            => $paDataFilter['tShpCodeTo'],
            'ptPosL'            => $tPosCodeSelect,
            'ptPosF'            => $paDataFilter['tPosCodeFrom'],
            'ptPosT'            => $paDataFilter['tPosCodeTo'],
            'ptCrdTypeF'        => $tCrdTypeFrom,
            'ptCrdTypeT'        => $tCrdTypeTo,
            'ptCrdStaActiveF'   => $tCrdStaActiveFrom,
            'ptCrdStaActiveT'   => $tCrdStaActiveTo,
            'ptStartDateF'      => $tStartDateFrom,
            'ptStartDateT'      => $tStartDateTo,
            'ptExpDateF'        => $tExpDateFrom,
            'ptExpDateT'        => $tExpDateTo,
            'ptCrdF'            => $tCardCodeFrom,
            'ptCrdT'            => $tCardCodeTo,
            'ptDocDateF'        => $tDocDateFrom,
            'ptDocDateT'        => $tDocDateTo,
            'FNResult'          => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if (false !== $oQuery) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator: 01/11/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere, $paDataFilter) {

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tUserCode = $paDataWhere['tUserCode'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSessionID = $paDataWhere['tUserSessionID'];

        $tSQL  = "  
            SELECT
                RPT.*
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FDTxnDocDate ASC) AS rtRowID, TMP.* 
                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
            ) AS RPT        
            WHERE RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
            ORDER BY RPT.FTCrdCode ASC, RPT.FDTxnDocDate ASC
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataRpt = $oQuery->result_array();

            $oCountRowRpt = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow = $oCountRowRpt;
            $nPageAll = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData = array(
                'raItems' => $aDataRpt,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aReturnData = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($oQuery);
        unset($oCountRowRpt);
        unset($nFoundRow);
        unset($nPageAll);
        return $aReturnData;
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 01/11/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tUserSessionID = $paDataWhere['tUserSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "
            SELECT 
                FTComName
            FROM TFCTRptCrdTmp WITH (NOLOCK) 
            WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);

        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    /**
     * Functionality: Summary Data Report รายงานตรวจสอบสถานะบัตร
     * Parameters:  Function Parameter
     * Creator: 01/11/2019 Piya
     * Last Modified :
     * Return : Sum Query
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptCheckStatusCardSum($paFilterReport){
		$tCompName = $paFilterReport['tCompName'];
        $tRptCode = $paFilterReport['tRptCode'];
        
        $tSQL = "   
            SELECT 
                SUM(ISNULL(FCCrdValue,0)) AS FCCrdValueSum
            FROM TFCTRptCrdTmp WITH (NOLOCK)    
            WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'
        ";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
}
