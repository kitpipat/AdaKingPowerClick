<?php


//Functionality: Clear File
//Parameters:  Function Parameter
//Creator: 7/02/2019 kitpipat Krit
//Last Modified :
//Return : 
//Return Type: Array
function FCNxClearDataInFile($tDocNo){

    $filename = file_exists(APPPATH."modules\document\document\\".$tDocNo."-".$_SESSION['tSesUsername'].".txt");
    if (file_exists($filename)) {
        $fp = fopen(APPPATH."modules\document\document\\".$tDocNo."-".$_SESSION['tSesUsername'].".txt", "r+");
        // // clear content to 0 bits
        ftruncate($fp, 0);
        // //close file
        fclose($fp);
    } else {
        $myfile = fopen(APPPATH."modules\document\document\\".$tDocNo."-".$_SESSION['tSesUsername'].".txt", "w");
    }

}

//Functionality: Get column for showing in grid table
//Parameters:  Function Parameter
//Creator: 26/02/2018 kitpipat P'รันต์
//Last Modified :
//Return : 
//Return Type: Array
function FCNaDCLGetAllColumn($ptTable = ''){

	$tLangActive =$_SESSION['tLangEdit'];
	$ci = &get_instance();
    $ci->load->database();
    $tSQL = "SELECT SDT.*
             FROM  TSysShwDT SDT 
             WHERE SDT.FTShwTblDT = '$ptTable'
             ORDER BY SDT.FTShwTblDT , SDT.FNShwSeq";

    $oQuery = $ci->db->query($tSQL);
    $aDataResult = $oQuery->result();
    //print_r($aDataResult);
    return $aDataResult;
}

//Functionality: Get column for showing in grid table
//Parameters:  Function Parameter
//Creator: 26/02/2018 kitpipat P'รันต์
//Last Modified : 17/03/2020 nonpawich (petch)
//Return : 
//Return Type: Array
function FCNaDCLGetColumnShow($ptTable = ''){

	$tLangActive =$_SESSION['tLangEdit'];
	$ci = &get_instance();
    $ci->load->database();
    $tSQL = "SELECT SDT.* ,SDTL.FTShwNameUsr 
             FROM  TSysShwDT SDT 
             LEFT JOIN  TSysShwDT_L SDTL ON SDT.FTShwTblDT = SDTL.FTShwTblDT 
             AND SDT.FTShwFedShw = SDTL.FTShwFedShw  
             AND SDTL.FNLngID = '$tLangActive'
             WHERE SDT.FTShwTblDT = '$ptTable'
             AND SDT.FTShwFedStaUsed = 1
             AND SDT.FTShwFedSetByUsr = 1
             ORDER BY SDT.FTShwTblDT , SDT.FNShwSeq";

    $oQuery = $ci->db->query($tSQL);
    $aDataResult = $oQuery->result();
    
    return $aDataResult;
}

//Functionality: Get available column for showing in grid table
//Parameters:  Function Parameter
//Creator: 26/02/2018 kitpipat P'รันต์
//Last Modified : 20/1/2020 เนลว์    (แก้ไขให้แสดงแค่ภาษาที่เก็บ session)
//Return : 
//Return Type: Array
function FCNaDCLAvailableColumn($ptTable = ''){
    $tLangActive =$_SESSION['tLangEdit'];
	$ci = &get_instance();
    $ci->load->database();
    $tSQL = " SELECT SDT.* ,SDTL.FTShwNameUsr 
              FROM  TSysShwDT SDT 
              LEFT JOIN  TSysShwDT_L SDTL ON SDT.FTShwTblDT = SDTL.FTShwTblDT 
              AND SDT.FTShwFedShw = SDTL.FTShwFedShw  
              AND SDTL.FNLngID = '$tLangActive'
              WHERE SDT.FTShwTblDT = '$ptTable'
              AND SDT.FTShwFedStaUsed = 1
              ORDER BY SDT.FTShwTblDT , SDT.FNShwSeq";

    $oQuery = $ci->db->query($tSQL);
    $aDataResult = $oQuery->result();
    //print_r($aDataResult);
    return $aDataResult;
}

function FCNaDCLSetShowCol($ptTable = '',$ptShwFedSetByUsr='' ,$ptShwFedShw = ''){
	
	$ci = &get_instance();
    $ci->load->database();
    $tSQL = " UPDATE TSysShwDT
              SET FTShwFedSetByUsr = '$ptShwFedSetByUsr'
              WHERE FTShwTblDT = '$ptTable'
              AND FTShwFedStaUsed = 1";
    if($ptShwFedShw !=""){
        $tSQL.=" AND FTShwFedShw='$ptShwFedShw' ";
    }

    $oQuery = $ci->db->query($tSQL);
    
}
function FCNaDCLUpdateSeq($ptTable = '' ,$ptShwFedShw = '',$pnShwSeq='' , $ptColLabelName=''){
	
	$ci = &get_instance();
    $ci->load->database();
    $tSQL = " UPDATE TSysShwDT
              SET FNShwSeq = '$pnShwSeq'
              WHERE FTShwTblDT = '$ptTable'
              AND FTShwFedStaUsed = 1";
    if($ptShwFedShw !=""){
        $tSQL.=" AND FTShwFedShw='$ptShwFedShw' ";
    }

    $oQuery = $ci->db->query($tSQL);

    $tLangActive =$_SESSION['tLangEdit'];
    //Update Column Lang Label
    $tSQL_Lang = " UPDATE TSysShwDT_L
              SET FTShwNameUsr = '$ptColLabelName'
              WHERE FTShwTblDT = '$ptTable'
              AND   FTShwFedShw = '$ptShwFedShw' 
              AND   FNLngID = '$tLangActive' ";

              $ci->db->query($tSQL_Lang);


}

function FCNaDCLSetDefShowCol($ptTable = ''){
	
	$ci = &get_instance();
    $ci->load->database();
    $tSQL = " UPDATE TSysShwDT
              SET FTShwFedSetByUsr = FTShwFedSetByDef
              WHERE FTShwTblDT = '$ptTable'
              AND FTShwFedStaUsed = 1";
  

    $oQuery = $ci->db->query($tSQL);
    
}
?>