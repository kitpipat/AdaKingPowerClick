<?php

//Functionality: Get Address
//Parameters:  Function Parameter
//Creator: 26/02/2018 kitpipat P'รันต์
//Last Modified :
//Return : 
//Return Type: Array
function FCNxHADDGetAddress($tBchCode){

	$ci = &get_instance();
    $ci->load->database();

    $nAddressType = FCNxHADDGenViewAddressType('TCNMBranch');

    $nLangEdit = $_SESSION ['tLangEdit'];

    $aData = array(
        'FNLngID' => $nLangEdit,
        'FTAddGrpType' => '1',
        'FTAddVersion' => $nAddressType,
        'FTAddRefCode' => $tBchCode
            
    );

    $aCnfAddEdit = FCNxHADDGetAddressData($aData);
    if(is_array($aCnfAddEdit)){
        //แยก
        if($nAddressType == 1){
            // [FTAddVersion] => 1 [FTAddV1No] => 959-5 [FTAddV1Soi] => - [FTAddV1Village] => - [FTAddV1Road] => - [FTAddV1SubDist] => 300116 [FTAddV1DstCode] => 3001 [FTDstName] => อ. เมืองนครราชสีมา [FTSudName] => ต. จอหอ [FTAddV1PvnCode] => 30 [FTPvnName] => จ. นครราชสีมา [FTAddV1PostCode] => 33270 [FTAddV2Desc1] => [FTAddV2Desc2] => [FTAreCode] => 001 [FTAreName] => ภาคกลาง [FTZneCode] => 00054 [FTZneName] => ภาคกลาง
            $tAddressLine1 = $aCnfAddEdit[0]['FTAddV1No']." ".$aCnfAddEdit[0]['FTAddV1Soi']." ".$aCnfAddEdit[0]['FTAddV1Village']." ".$aCnfAddEdit[0]['FTAddV1Road']." ".$aCnfAddEdit[0]['FTDstName'];
            $tAddressLine2 = $aCnfAddEdit[0]['FTSudName']." ".$aCnfAddEdit[0]['FTPvnName']." ".$aCnfAddEdit[0]['FTAddV1PostCode'];

        }else{
        //รวม
            $tAddressLine1 = $aCnfAddEdit[0]['FTAddV2Desc1'];
            $tAddressLine2 = $aCnfAddEdit[0]['FTAddV2Desc2'];
        }

        $aDataAddress = array(
            'tAddressLine1' => $tAddressLine1,
            'tAddressLine2' => $tAddressLine2
        );

    }else{
        //No data 
        $aDataAddress = array(
            'tAddressLine1' => '',
            'tAddressLine2' => ''
        );

    }

    return $aDataAddress;

}


//Functionality : หา ประเภท ของ ที่อยู่
//Parameters : function parameters
//Creator : 27/11/2018 Krit(Copter)
//Last Modified : -
//Return : data
//Return Type : Array
function FCNxHADDGenViewAddressType($ptMasterName){

    $ci = &get_instance();
    $ci->load->database();

    $tSQL ="SELECT  FTSysStaDefValue,
                    FTSysStaUsrValue
            FROM TSysConfig 
            WHERE FTSysCode = 'tCN_AddressType' 
            AND FTSysKey = '$ptMasterName'
            ";
    
    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
    
        $aCnfAddVersion = $oQuery->result();

        $nSysStaDefValue = $aCnfAddVersion[0]->FTSysStaDefValue;
		$nSysStaUsrValue = $aCnfAddVersion[0]->FTSysStaUsrValue;
		
		if($nSysStaUsrValue != ''){
			$nCnfAddVersion = $nSysStaUsrValue; //ถ้า Sys User มีค่าจะใช้ค่าของ UserValue
		}else{
			$nCnfAddVersion = $nSysStaDefValue; //ถ้า Sys User ไม่มีค่าจะใช้ค่าของ DefValue
		}
    
    } else {
        //No Data
        $nCnfAddVersion = 1;
    }

    return $nCnfAddVersion;
    
}

//Address Format
//12/11/2018 Phisan
function FCNaHAddressFormat($tTableName = ''){
    $ci = &get_instance();
    $ci->load->database();
    $tSQL = "SELECT 
                FTSysStaDefValue,
                FTSysStaUsrValue
            FROM TSysConfig 
            WHERE FTSysCode = 'tCN_AddressType' 
            AND FTSysKey = '$tTableName' ";

    $oQuery = $ci->db->query($tSQL);
    $aFormat = $oQuery->result();
    $tStaUsrValue = $aFormat[0]->FTSysStaUsrValue;
    $tStaDefValue = $aFormat[0]->FTSysStaDefValue;
    if($tStaUsrValue != '' || $tStaUsrValue != null){
        $tStaValue = $tStaUsrValue;
    }else{
        $tStaValue = $tStaDefValue;
    }

    if($tTableName == ''){
            //default
            return 1;
    }else{
            return $tStaValue;//1 ที่อยู่ แบบแยก  ,2  แบบรวม
    }
}
   

//Functionality : ดึงข้อมูล ของ ที่อยู่
//Parameters : function parameters
//Creator : 10/05/2018 Krit(Copter)
//Last Modified : -
//Return : data
//Return Type : Array
function FCNxHADDGetAddressData($ptData){
    

    $ci = &get_instance();
    $ci->load->database();
    
    $tAddRefCode = $ptData['FTAddRefCode'];
    $tAddGrpType = $ptData['FTAddGrpType'];
    
    $nLngID = $ptData['FNLngID'];
    

    $tSQL ="SELECT  FTAddVersion,
                    FTAddV1No,
                    FTAddV1Soi,			
                    FTAddV1Village,
                    FTAddV1Road,
                    FTAddV1SubDist,
                    FTAddV1DstCode,
                    DSTL.FTDstName,
                    SUBDSTL.FTSudName,
                    ADDL.FTAddV1PvnCode,
                    PVNL.FTPvnName,
                    FTAddV1PostCode,
                    FTAddV2Desc1,
                    FTAddV2Desc2,
                    
                    ADDL.FTAreCode,
                    AREL.FTAreName,
                    ADDL.FTZneCode,
                    ZNEL.FTZneName
                    
                    
            FROM TCNMAddress_L ADDL
            LEFT JOIN TCNMArea_L AREL ON ADDL.FTAreCode = AREL.FTAreCode AND AREL.FNLngID = $nLngID
            LEFT JOIN TCNMZone_L ZNEL ON ADDL.FTZneCode = ZNEL.FTZneCode AND ZNEL.FNLngID = $nLngID
            LEFT JOIN TCNMProvince_L PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
            LEFT JOIN TCNMDistrict_L DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
            LEFT JOIN TCNMSubDistrict_L SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
            
            WHERE ADDL.FTAddRefCode = '$tAddRefCode'
            AND ADDL.FTAddGrpType = '$tAddGrpType'
            AND ADDL.FNLngID = '$nLngID'
            ";

    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
    
        return $oQuery->result_array();
    
    } else {
        //No Data
        return false;
    }

}

// Project : KPC
// Create By: Napat(Jame) 27/08/2021
function FCNtHAddConvertFormat($paDataAddr){
    $tAddress   = '';

    if( $paDataAddr['tAddVersion'] == '1' ){

        $tLabelAddV1No = language('common/main/main','tAddV1No');
        $tLabelAddV1Village = language('common/main/main','tAddV1Village');
        $tLabelAddV1Soi = language('common/main/main','tAddV1Soi');
        $tLabelAddV1Road = language('common/main/main','tAddV1Road');

        if( $paDataAddr['tPvnCode'] == '10' ){                                          // ถ้าไม่ใช่ กรุงเทพ จะใช้คำว่า ตำบล / อำเภอ 
            $tLabelAddV1SubDist = language('common/main/main','tAddV1SubDist2');
            $tLabelAddV1Dst = language('common/main/main','tAddV1Dst2');
        }else{
            $tLabelAddV1SubDist = language('common/main/main','tAddV1SubDist1');
            $tLabelAddV1Dst = language('common/main/main','tAddV1Dst1');
        }

        $tLabelAddV1Pvn = language('common/main/main','tAddV1Pvn');
        $tLabelAddV1Post = language('common/main/main','tAddV1Post');
        

        if( !empty($paDataAddr['tAddV1No']) ){ 
            $tAddress .= $tLabelAddV1No . ' ' . $paDataAddr['tAddV1No'];
        }
        if( !empty($paDataAddr['tAddV1Village']) ){ 
            $tAddress .= ' ' . $tLabelAddV1Village . ' ' . $paDataAddr['tAddV1Village']; 
        }
        if( !empty($paDataAddr['tAddV1Road']) ){ 
            $tAddress .= ' ' . $tLabelAddV1Road . ' ' . $paDataAddr['tAddV1Road']; 
        }
        if( !empty($paDataAddr['tAddV1Soi']) ){
            $tAddress .= ' ' . $tLabelAddV1Soi . ' ' . $paDataAddr['tAddV1Soi']; 
        }
        if( !empty($paDataAddr['tSudName']) ){ 
            $tAddress .= ' ' . $tLabelAddV1SubDist . ' ' . $paDataAddr['tSudName']; 
        }
        if( !empty($paDataAddr['tDstName']) ){ 
            $tAddress .= ' ' . $tLabelAddV1Dst . ' ' . $paDataAddr['tDstName']; 
        }
        if( !empty($paDataAddr['tPvnName']) ){ 
            $tAddress .= ' ' . $tLabelAddV1Pvn . ' ' . $paDataAddr['tPvnName']; 
        }
        if( !empty($paDataAddr['tAddV1PostCode']) ){ 
            $tAddress .= ' ' . $tLabelAddV1Post . ' ' . $paDataAddr['tAddV1PostCode']; 
        }

    }else{
        $tAddress = $paDataAddr['tAddV2Desc1'] . ' ' . $paDataAddr['tAddV2Desc2'];
    }
    return $tAddress;
}


?>