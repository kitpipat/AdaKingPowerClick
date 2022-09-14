<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSaleByShopByPosOnDaily extends CI_Model {

    public function getData(){
        $tSQL = "select top 50 FTShpCode, FTPosCode, FTXshDocNo, FDXshDocDate, sum(FCXshGrand) as XshGrand, sum(FCXshDis) as XshDis, sum(FCXshChg) as XshChg from TTmpTPSTSalHD group by FTShpCode, FTPosCode, FTXshDocNo, FDXshDocDate";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 3/04/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSnMExecStoreReport($paDataReport){
        $tCallStore = "{CALL STP_RPTxSaleByShpByPosByDate(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'ptUserCode'        => $paDataReport['tUserCode'],
            'ptBchCodeFrom'     => $paDataReport['tBchCodeFrom'],
            'ptBchCodeTo'       => $paDataReport['tBchCodeTo'],
            'ptShopCodeFrom'    => $paDataReport['tShopCodeFrom'],
            'ptShopCodeTo'      => $paDataReport['tShopCodeTo'],
            'ptCompName'        => $paDataReport['tCompName'],
            'ptRptCode'         => $paDataReport['tCode'],
            'ptXshDocDateFrom'  => $paDataReport['tDocDateFrom'],
            'ptXshDocDateTo'    => $paDataReport['tDocDateTo'],
            'pnLngID'           => $paDataReport['nLangID'],
            'tSql'              => null,
            'FNResult'          => 1,
            'tErr'              => ''
        );
        
        $oQuery = $this->db->query($tCallStore,$aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 3/04/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSaMGetDataReport($paDataWhere){
        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY rtRptCode ASC) AS rtRowID,* FROM (
                                SELECT
                                    TTSALEHD.FTBchCode              AS rtBchCode,
                                    TTSALEHD.FTBchName              AS rtBchName,
                                    TTSALEHD.FTXshDocNo             AS rtXshDocNo,
                                    TTSALEHD.FTXshRefAE             AS rtXshRefAE,
                                    TTSALEHD.FDXshDocDate           AS rtXshDocDate,
                                    TTSALEHD.FTShpCode              AS rtShpCode,
                                    TTSALEHD.FTShpName              AS rtShpName,
                                    TTSALEHD.FTPosCode              AS rtPosCode,
                                    TTSALEHD.FNXshDocType           AS rtXshDocType,
                                    ISNULL(TTSALEHD.FCXshGrand,0)   AS rtXshGrand,
                                    TTSALEHD.FTRptUserCode          AS rtRptUserCode,
                                    TTSALEHD.FTRptCompName          AS rtRptCompName,
                                    TTSALEHD.FTRptCode              AS rtRptCode,
                                    TTSALEHD.FCXshChg               AS rtRptXshChg,
                                    TTSALEHD.FCXshDis               AS rtRptXshDis
                                FROM TTmpTPSTSalHD TTSALEHD
                                WHERE 1 = 1
                                AND TTSALEHD.FTRptUserCode = '$tUserCode' AND TTSALEHD.FTRptCompName = '$tCompName' AND TTSALEHD.FTRptCode = '$tRptCode'
                        ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataRpt       = $oQuery->result_array();
            $oCountRowRpt   = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow      = $oCountRowRpt[0]->rtCountRpt;
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
     * Functionality : 
     * Parameters : 
     * Creator : 3/04/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSaMCountDataReportAll($paDataWhere){
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       = " SELECT COUNT(TTSALEHD.FTRptSeqID) AS rtCountRpt
                        FROM TTmpTPSTSalHD TTSALEHD
                        WHERE 1 = 1
                        AND TTSALEHD.FTRptUserCode = '$tUserCode' AND TTSALEHD.FTRptCompName = '$tCompName' AND TTSALEHD.FTRptCode = '$tRptCode' ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result();
    }
    
    
    
    
    
    function genCode($tPrefixCode, $tBeginCode, $tAdd){
        $tPrefix = $tPrefixCode;
        $nBeginNumber = intval($tBeginCode);
        $nBeginNumberLength = strlen($tBeginCode);
        
        $nPreZero = str_pad($tAdd, $nBeginNumberLength, "0", STR_PAD_LEFT);
        $tCode = $tPrefix . $nPreZero;
        
        return $tCode;
    }
    
    function insertData(){
        $tSQL = "";
        
        $tPrefixBchCode = "B";
        $tBeginBchCode = "0001";
        $tPrefixDocNo = "S2019030000-";
        $tBeginDocNo = "00001";
        $tPrefixShopCode = "S";
        $nBeginShopCode = "0001";
        
        $tDocDate = "2019-04-04 15:46:43";
        $tUsrCode = "009";
        for($i=1; $i<=1000; $i++){
            $nLoop = $i;
            $tPosCode = "0000" . rand(1,5);
            $tBchCode = "B000" . rand(1,2);// $this->genCode($tPrefixBchCode, $tBeginBchCode, $nLoop);
            $tDocNo = $this->genCode($tPrefixDocNo, $tBeginDocNo, $nLoop);
            $tShopCode = "S000" . rand(1,2);// $this->genCode($tPrefixShopCode, $nBeginShopCode, $nLoop);
            $nGrand = rand(100, 1000);
            // $nTotalNV = rand('100');
            $nDis = 50; // rand(50, 100);
            $nChg = 20; // rand('10', 50);
            $nChgDis = $nChg - $nDis;
            $nTotal = $nGrand - $nChgDis; // Total - Dis
            $nDocType = 1;
            $tSQL .= "INSERT INTO [TPSTSalHD] VALUES ('$tBchCode', '$tDocNo', '$tShopCode', $nDocType, '$tDocDate', NULL, NULL, NULL, NULL, '$tPosCode', NULL, NULL, '$tUsrCode', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $nTotal.00, NULL, NULL, NULL, NULL, NULL, $nDis.00, $nChg.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $nGrand.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
            
        }
        $this->db->query($tSQL);
        echo $tSQL;
        
    }
}




























































































