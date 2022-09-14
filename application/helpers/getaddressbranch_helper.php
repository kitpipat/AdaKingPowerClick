<?php

/**
 * Functionality    : หาว่าสาขาที่โยนมา มี ADDL ไหม ถ้าไม่มีให้เอาสาขาของ Com โยนกลับไป
 * Parameters       : -
 * Creator          : 24/02/2021 Supawat
 * Last Modified    : -
 * Return           : bch
 * Return Type      : text
 */

function FCNtGetAddressBranch($ptBranchCode = '') {
    $ci = &get_instance();
    $ci->load->database();
    
    $tSQL   = "SELECT TOP 1 FTAddRefCode FROM TCNMAddress_L WHERE FTAddRefCode = '$ptBranchCode' ";
    $oQuery = $ci->db->query($tSQL);
    if(!empty($oQuery->result_array())){
        $tBranchCode = $ptBranchCode;
    }else{
        $tSQLBranchCom  = "SELECT TOP 1 FTBchCode FROM TCNMComp ";
        $oQueryComp     = $ci->db->query($tSQLBranchCom);
        $aResult        = $oQueryComp->result_array();
        if(!empty($aResult)){
            $tBranchCode = $aResult[0]['FTBchCode'];
        }else{
            $tBranchCode = '00001';
        }
    }
    return $tBranchCode;
}