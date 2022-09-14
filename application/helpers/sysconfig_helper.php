<?php

/**
 * Functionality : Get System Configuration
 * Parameters : $paAppCode, $paConfigGroupCode
 * Creator : 5/3/2019 piya
 * Last Modified : -
 * Return : Configuration List
 * Return Type : array
 */
function FCNaGetSysConfigByGroup($paSysApp, $paGmnCode)
{

    $tSysApp = implode(",", $paSysApp);
    $tGmnCode = implode(",", $paGmnCode);

    $ci = &get_instance();
    $ci->load->database();
    $nLangEdit = $ci->session->userdata("tLangEdit");

    $tSQL = "   SELECT * 
                FROM [TSysConfig] SYSC WITH (NOLOCK)
                LEFT JOIN [TSysConfig_L] SYSCL WITH (NOLOCK)
                    ON SYSCL.FTSysCode = SYSC.FTSysCode 
                    AND SYSCL.FTSysApp = SYSC.FTSysApp 
                    AND SYSCL.FTSysKey = SYSC.FTSysKey 
                    AND SYSCL.FNLngID = $nLangEdit
                WHERE SYSC.FTSysApp IN ($tSysApp) AND SYSC.FTGmnCode IN ($tGmnCode)
                ORDER BY SYSC.FTSysSeq";

    $oQuery = $ci->db->query($tSQL);

    if ($oQuery->num_rows() > 0) { // Found Data

        $aList = $oQuery->result();

        $aResult = array(
            'raItems' => $aList,
            'rnAllRow' => $oQuery->num_rows(),
            'rtCode' => '1',
            'rtDesc' => 'success'
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
    } else { // No Data
        $aResult = array(
            'rtCode' => '800',
            'rtDesc' => 'data not found'
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
    }
    return $aResult;
}

/**
 * Functionality : Update System Configuration
 * Parameters : $paAppCode, $paConfigGroupCode
 * Creator : 5/3/2019 piya
 * Last Modified : -
 * Return : Update status
 * Return Type : array
 */
function FCNaUpdateSysConfig($paSysKey, $paData)
{

    $ci = &get_instance();
    $ci->load->database();
    $nLangEdit = $ci->session->userdata("tLangEdit");

    // $ci->db->set('FTSysStaDefValue' , $paData['FTSysStaDefValue']);
    $ci->db->set('FTSysStaUsrValue', $paData['FTSysStaUsrValue']);

    $ci->db->where('FTSysCode', $paSysKey['FTSysCode']);
    $ci->db->where('FTSysApp', $paSysKey['FTSysApp']);
    $ci->db->where('FTSysKey', $paSysKey['FTSysKey']);
    $ci->db->where('FTSysSeq', $paSysKey['FTSysSeq']);
    $ci->db->where('FTGmnCode', $paSysKey['FTGmnCode']);
    $ci->db->update('TSysConfig');

    if ($ci->db->affected_rows() > 0) {
        $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'Update Master Success',
        );
    } else {
        $aStatus = array(
            'rtCode' => '905',
            'rtDesc' => 'Error Cannot Add/Edit Master.',
        );
    }
    return $aStatus;
}

/**
 * Functionality : Get System Configuration
 * Parameters : $paParams
 * Creator : 8/10/2019 piya
 * Last Modified : -
 * Return : Configuration List
 * Return Type : array
 */
function FCNaGetSysConfig($paParams = [])
{

    $ci = &get_instance();
    $ci->load->database();
    $nLangEdit = $ci->session->userdata("tLangEdit");

    $tSysCode = isset($paParams['tSysCode']) ? $paParams['tSysCode'] : "";
    $tSysApp = isset($paParams['tSysApp']) ? $paParams['tSysApp'] : "";
    $tSysKey = isset($paParams['tSysKey']) ? $paParams['tSysKey'] : "";
    $tSysSeq = isset($paParams['tSysSeq']) ? $paParams['tSysSeq'] : "";
    $tGmnCode = isset($paParams['tGmnCode']) ? $paParams['tGmnCode'] : "";

    $tSQL = "   
        SELECT 
            * 
        FROM [TSysConfig] SYSC WITH (NOLOCK)
        LEFT JOIN [TSysConfig_L] SYSCL WITH (NOLOCK)
            ON SYSCL.FTSysCode = SYSC.FTSysCode 
            AND SYSCL.FTSysApp = SYSC.FTSysApp 
            AND SYSCL.FTSysKey = SYSC.FTSysKey 
            AND SYSCL.FTSysSeq = SYSC.FTSysSeq
            AND SYSCL.FNLngID = $nLangEdit
        WHERE SYSC.FTSysCode = '$tSysCode'
        AND SYSC.FTSysApp = '$tSysApp'
        AND SYSC.FTSysKey = '$tSysKey'
        AND SYSC.FTSysSeq = '$tSysSeq'
        AND SYSC.FTGmnCode = '$tGmnCode'
    ";

    $oQuery = $ci->db->query($tSQL);

    if ($oQuery->num_rows() > 0) { // Found Data

        $oList = $oQuery->row();

        $aResult = array(
            'raItems' => $oList,
            'rtCode' => '1',
            'rtDesc' => 'success'
        );
        $tResult = json_encode($aResult);
        $aResult = json_decode($tResult, true);
    } else { // No Data
        $aResult = array(
            'raItems' => [],
            'rtCode' => '800',
            'rtDesc' => 'data not found'
        );
        $tResult = json_encode($aResult);
        $aResult = json_decode($tResult, true);
    }
    return $aResult;
}

// Create By : Napat(Jame) 14/08/2021
function FCNaGetUrlObjectLogin($ptUolKey){
    $ci = &get_instance();
    $ci->load->database();
    $nLangEdit = $ci->session->userdata("tLangEdit");

    $tSQL = " SELECT TOP 1 * FROM TCNTUrlObjectLogin WITH(NOLOCK) WHERE FTUolKey = '$ptUolKey' AND FTUolStaActive = '1' ";
    $oQuery = $ci->db->query($tSQL);

    if( $oQuery->num_rows() > 0 ){
        $aResult = array(
            'aItems'    => $oQuery->row_array(),
            'tCode'     => '1',
            'tDesc'     => 'success'
        );
    }else{
        $aResult = array(
            'tCode'     => '800',
            'tDesc'     => 'data not found'
        );
    }
    return $aResult;
}
