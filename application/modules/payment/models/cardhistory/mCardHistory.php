<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCardHistory extends CI_Model{
    /**
     * Functionality : Get Card History Table
     * Parameters : -
     * Creator : 05/01/2021 Witsarut
     * Last Modified : -
     * Return : Card His Data
     * Return Type : array
     */
    public function FSaMCRDGetHisDataTable(array $paParams = []){

        $tBchCode    = $paParams['tBchCode'];
        $tHisDate    = $paParams['tHisDate'];
        $tCrdHisCode = $paParams['tCrdHisCode'];
        $tCrdTypeHis = $paParams['tCrdTypeHis'];
        $nLngID      = $paParams['nLngID'];


        $tSQL = "EXEC STP_GEToCrdHistory 100,'$tBchCode','$tCrdHisCode','$tHisDate',$nLngID";
        $oResult = $this->db->query($tSQL);
     
        $aResult = $oResult->result_array();

        if (FCNnHSizeOf($aResult) > 0) {
            $aStatus = array(
                'raItems' => $aResult,
                'rtCode' => '1',
                'rtDesc' => 'Data found',
            );
        } else {
            $aStatus = array(
                'raItems' => [],
                'rtCode' => '905',
                'rtDesc' => 'Data not found',
            );
        }
        return $aStatus;

    }


}
