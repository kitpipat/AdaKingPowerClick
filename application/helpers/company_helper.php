<?php
/**
 * 
 * @param type $paParams
 * @return type
 */
function FCNaGetCompanyInfo($paParams = []){
    $ci = &get_instance();
    $ci->load->model('company/company/mCompany');

    $aCompParams = [
        'nLngID' => $paParams['nLngID'],
        'tBchCode' => $paParams['tBchCode']
    ];
    
    return $ci->mCompany->FSaMCMPGetCompanyInfo($aCompParams);
}

/**
 * 
 * @param type $paParams
 * @return type
 */
function FCNaGetBranchInfo($paParams = []){
    $ci = &get_instance();
    $ci->load->model('company/branch/mBranch');

     $aBchParams = [
        'nLngID' => $paParams['nLngID'],
        'tBchCode' => $paParams['tBchCode']
    ];
    
    return $ci->mBranch->FSaMCMPGetBchInfo($aBchParams);
}

/**
 * 
 * @param type $paParams
 * @return type
 */
function FCNtGetCompanyCode(){
    $ci = &get_instance();
    $ci->load->model('company/company/mCompany');
    $aCompany = $ci->mCompany->FSaMCMPGetCompanyCode();
    
    $tCompanyCode = "Company Code Not Found.";
    if($aCompany['rtCode'] == '1') {
        $tCompanyCode = $aCompany['raItems']['FTCmpCode'];
    }
    return $tCompanyCode;
}



/**
 * 
 * @param type $paParams
 * @return type
 */
function FCNaGetCompanyForDocument(){
    $ci = &get_instance();
    $ci->load->model('company/company/mCompany');
    $ci->load->model('payment/rate/mRate');
    $nLangEdit = $ci->session->userdata("tLangEdit");
    $aDataReturn = array();

    if(!empty($ci->session->userdata('tSesUsrAgnCode'))){
        $tSesUsrAgnCode = $ci->session->userdata('tSesUsrAgnCode');
        $tSQL ="SELECT
                    AGN.FTAgnCode,
                    AGN.FTBchCode,
                    AGNSPC.FTCmpVatInOrEx,
                    AGNSPC.FTRteCode,
                    AGNSPC.FTVatCode
                FROM
                    TCNMAgency AGN WITH(NOLOCK)
                LEFT OUTER JOIN TCNMAgencySpc AGNSPC WITH(NOLOCK) ON AGN.FTAgnCode = AGNSPC.FTAgnCode
                WHERE
                    AGN.FTAgnCode = '$tSesUsrAgnCode'
        ";
         $oQuery = $ci->db->query($tSQL);
         if ($oQuery->num_rows() > 0) {
            $oRes  = $oQuery->row_array();
            $aDataReturn['tBchCode'] = $oRes['FTBchCode'];
            $aDataReturn['tCmpRteCode'] = $oRes['FTRteCode'];
            $aDataReturn['tVatCode'] = $oRes['FTVatCode'];
            $aDataReturn['tCmpRetInOrEx'] = $oRes['FTCmpVatInOrEx'];
        } else {
            $oRes = NULL;
            $aDataReturn['tBchCode'] = FCNtGetBchInComp();
            $aDataReturn['tCmpRteCode'] = '';
            $aDataReturn['tVatCode'] = '';
            $aDataReturn['tCmpRetInOrEx'] = '1';
        }
    }else{
            $aDataWhere = array(
                'FNLngID' => $nLangEdit
            );
            $tAPOReq = "";
            $tMethodReq = "GET";
            $aCompData = $ci->mCompany->FSaMCMPList($tAPOReq, $tMethodReq, $aDataWhere);
            $aDataReturn['tBchCode'] = $aCompData['raItems']['rtCmpBchCode'];
            $aDataReturn['tCmpRteCode'] = $aCompData['raItems']['rtCmpRteCode'];
            $aDataReturn['tVatCode'] = $aCompData['raItems']['rtVatCodeUse'];
            $aDataReturn['tCmpRetInOrEx'] = $aCompData['raItems']['rtCmpRetInOrEx'];

    }

    $aVatRate = FCNoHCallVatlist($aDataReturn['tVatCode']);
    if (isset($aVatRate) && !empty($aVatRate)) {
        $aDataReturn['cVatRate'] = $aVatRate['FCVatRate'][0];
    } else {
        $aDataReturn['cVatRate'] = "";
    }
    $aDataRate = array(
        'FTRteCode' => $aDataReturn['tCmpRteCode'],
        'FNLngID' => $nLangEdit
    );
    $aResultRte = $ci->mRate->FSaMRTESearchByID($aDataRate);
    if (isset($aResultRte) && $aResultRte['rtCode']) {
        $aDataReturn['cXthRteFac'] = $aResultRte['raItems']['rcRteRate'];
    } else {
        $aDataReturn['cXthRteFac'] = "";
    }
 
    return $aDataReturn;
}