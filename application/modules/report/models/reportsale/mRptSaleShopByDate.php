<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSaleShopByDate extends CI_Model {

    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 04/04/2019 Wasin(Yoshi)
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $tCallStore = "{ CALL STP_RPTTTmpTPSTSalHD(?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'ptUserCode'        => $paDataFilter['tUserCode'],
            'ptCompName'        => $paDataFilter['tCompName'],
            'ptRptCode'         => $paDataFilter['tCode'],
            'ptBchCodeFrom'     => $paDataFilter['tBchCodeFrom'],
            'ptBchCodeTo'       => $paDataFilter['tBchCodeTo'],
            'ptShopCodeFrom'    => $paDataFilter['tShopCodeFrom'],
            'ptShopCodeTo'      => $paDataFilter['tShopCodeTo'],
            'ptXshDocDateFrom'  => $paDataFilter['tDocDateFrom'],
            'ptXshDocDateTo'    => $paDataFilter['tDocDateTo'],
            'pnLngID'           => $paDataFilter['nLangID'],
            'FNResult'          => 0,
            'tErr'              => 0,
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

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 04/04/2019 Wasin(Yoshi)
    // Last Modified : 11/04/2019 Wasin(Yoshi)
    // Return : Get Data Rpt Temp
    // Return Type: Array
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
                                    TTSALEHD.FDXshDocDate           AS rtXshDocDate,
                                    TTSALEHD.FTShpCode              AS rtShpCode,
                                    TTSALEHD.FTShpName              AS rtShpName,
                                    TTSALEHD.FNXshDocType           AS rtXshDocType,
                                    ISNULL(TTSALEHD.FCXshGrand,0)   AS rtXshGrand,
                                    TTSALEHD.FTRptUserCode          AS rtRptUserCode,
                                    TTSALEHD.FTRptCompName          AS rtRptCompName,
                                    TTSALEHD.FTRptCode              AS rtRptCode
                                FROM TTmpTPSTSalHD TTSALEHD
                                WHERE 1 = 1
                                AND TTSALEHD.FTRptUserCode = '$tUserCode' AND TTSALEHD.FTRptCompName = '$tCompName' AND TTSALEHD.FTRptCode = '$tRptCode'
                        ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataRpt       = $oQuery->result_array();
            $oCountRowRpt   = $this->FSaMCountDataReportAll($paDataWhere);
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

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMCountDataReportAll($paDataWhere){
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       = " SELECT
                            TTSALEHD.FTBchCode              AS rtBchCode,
                            TTSALEHD.FTBchName              AS rtBchName,
                            TTSALEHD.FDXshDocDate           AS rtXshDocDate,
                            TTSALEHD.FTShpCode              AS rtShpCode,
                            TTSALEHD.FTShpName              AS rtShpName,
                            TTSALEHD.FNXshDocType           AS rtXshDocType,
                            ISNULL(TTSALEHD.FCXshGrand,0)   AS rtXshGrand,
                            TTSALEHD.FTRptUserCode          AS rtRptUserCode,
                            TTSALEHD.FTRptCompName          AS rtRptCompName,
                            TTSALEHD.FTRptCode              AS rtRptCode
                        FROM TTmpTPSTSalHD TTSALEHD
                        WHERE 1 = 1
                        AND TTSALEHD.FTRptUserCode = '$tUserCode' AND TTSALEHD.FTRptCompName = '$tCompName' AND TTSALEHD.FTRptCode = '$tRptCode' ";
        $oQuery     = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    // Functionality: Sum All Value Data Report All
    // Parameters: Function Parameter
    // Creator: 24/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMSumDataReportAll($paDataWhere){
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
            



    }

}
