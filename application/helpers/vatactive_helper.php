<?php

//Functionality: Function Call VatList
//Parameters:  Function Parameter
//Creator: 01/06/2018 wasin(yoshi)
//Customize : 30/08/2018 Krit(Copter)
//Return : 
//Return Type: Array
function FCNoHCallVatlist($ptVatCode = ''){
    
    $ci = &get_instance();

    $aVatCodes = FCNoHVATList($ptVatCode);
    $aVatRate = array();
    $i = 0;
    if($aVatCodes){
        foreach($aVatCodes as $key=>$aVatCode):
            $tVatCode   = $aVatCode->FTVatCode;
            $aVatActive = FCNoHVatActiveList($tVatCode);
            $aVatRate['FTVatCode'][$i]  = $tVatCode;
            $aVatRate['FCVatRate'][$i]  = $aVatActive->FCVatRate;
            $aVatRate['FDVatStart'][$i] = $aVatActive->FDVatStart;
        $i++;
        endforeach;
    }
    
    return $aVatRate;
}

//Functionality: Function Get VatCode in DataBase
//Parameters:  Function Parameter
//Creator: 01/06/2018 wasin(yoshi)
//Return : object VetCode
//Return Type: object
function FCNoHVATList($ptVatCode){

    $ci = &get_instance();
    $ci->load->database();

        $tSQL   = "SELECT DISTINCT (FTVatCode) AS FTVatCode  FROM TCNMVatRate";
    if($ptVatCode != ''){
        $tSQL   .= " WHERE FTVatCode = '$ptVatCode'";
    }
    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0):
        return $oQuery->result();
    else: 
        return false;
    endif;
}

//Functionality: Function Get Vat Active Date List
//Parameters:  Function Parameter
//Creator: 01/06/2018 wasin(yoshi)
//Return : object VetCode
//Return Type: object
function FCNoHVatActiveList($ptVatCode){
    $ci = &get_instance();
    $ci->load->database();
    $tSQL = "SELECT Top 1 FCVatRate,CONVERT(varchar(10),FDVatStart,121) AS FDVatStart
                         FROM  TCNMVatRate 
                         WHERE CONVERT(varchar(10),FDVatStart,121) <= CONVERT(varchar(10),GETDATE(),121) 
                         AND FTVatCode = '$ptVatCode' ORDER BY FDVatStart DESC";
    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0):
        return $oQuery->row();
    else: 
        return FCNoHVATNextActiveList($ptVatCode);
    endif;
}

//Functionality: Function Get Vat Active Date List
//Parameters:  Function Parameter
//Creator: 01/06/2018 wasin(yoshi)
//Return : object VetCode
//Return Type: object
function FCNoHVATNextActiveList($ptVatCode){
    $ci = &get_instance();
    $ci->load->database();
    $tSQL = "SELECT Top 1 FCVatRate,CONVERT(varchar(10),FDVatStart,121) AS FDVatStart
             FROM  TCNMVatRate 
             WHERE FTVatCode = '$ptVatCode' ORDER BY FDVatStart DESC";
    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0):
        return $oQuery->row();
     else: 
        return null;
     endif;
}

/**
 * Functionality : Get active active vat in company
 * Parameters : -
 * Creator : 30/04/2019 piya
 * Last Modified : -
 * Return : Active vat data
 * Return Type : array
 */
function FCNaHVATGetActiveVatCompany(){
    $ci = &get_instance();
    $ci->load->database();
    
    $tSQL = "   SELECT Top 1 FTVatCode
                FROM  TCNMComp"; 
    $oQuery = $ci->db->query($tSQL);
    
    if($oQuery->num_rows() > 0) {
        
        $oVatCodeInCompany = $oQuery->row();
        $vatActiveInCompany = [
            'vatCode' => $oVatCodeInCompany->FTVatCode,
            'value' => FCNoHVatActiveList($oVatCodeInCompany->FTVatCode)->FCVatRate, // Get vatrate
            'dateStart' => FCNoHVatActiveList($oVatCodeInCompany->FTVatCode)->FDVatStart // Get vat date start
        ];
        
        return $vatActiveInCompany;
    } else {
        return [];
    }
}

/**
 * Functionality : Check active vat start
 * Parameters : $paVatRate is vat rate by vat code
 * Creator : 30/08/2018 piya
 * Last Modified : -
 * Return : Active vat start
 * Return Type : array
 */
function FCNaHVATDateActive(array $paVatRate = []) {
    $unexpired = [];
    $expired = [];
    foreach ($paVatRate['raItems'] as $item) {
        if ( strtotime($item['rtVatStart']) >= strtotime(date('Y-m-d')) ) {
            $unexpired[] = $item;
        }
        if ( strtotime($item['rtVatStart']) <= strtotime(date('Y-m-d'))) {
            $expired[] = $item;
        }
    }
    if(FCNnHSizeOf($expired) > 0){
        return end($expired);
    }else{
        return [];
    }
}









