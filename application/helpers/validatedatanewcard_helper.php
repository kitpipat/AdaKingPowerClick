<?php

/**
 * Functionality: (เอกสารบัตรใหม่) ฟังก์ชั่นเช็ครหัสบัตร/หมายเลขหลังบัตร ซ้ำในระบบ
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 26/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 1 = พบรหัสบัตร/หมายเลขหลังบัตรซ้ำในระบบ , 0 = ไม่พบรหัสบัตร/หมายเลขหลังบัตรซ้ำในระบบ
 * Return Type: Numeric
*/
function FSnHNewCrdChkCrdCodeDup($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];
    
    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tRmkLang   =   language('document/card/docvalidate','tNewCardDup'); 
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tRmkLang."'
                WHERE  FTCidCrdCode
                IN(
                    SELECT  ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM TFNTCrdImpTmp CIT
                    LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CIT.FTCidCrdCode = CRD.FTCrdCode
                    WHERE 1 = 1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCidStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // กรณีมีการ Duplicate Card Code
    }else{
        return 0;   // กรณีไม่มีการ Duplicate Card Code
    }
}

/**
 * Functionality: (เอกสารบัตรใหม่) ฟังก์ชั่นตรวจสอบประเภทบัตรว่ามีอยู่จริงหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 26/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHNewCrdChkCardTypeInDB($paParams){
    $ci = &get_instance();
    $ci->load->database();
    
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCardTypeRmk  = language('document/card/docvalidate','tErrorCardType');  // Add document validate (Bell) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorCardTypeRmk."'
                WHERE  FTCtycode 
                NOT IN(
                    SELECT  DISTINCT C1.FTCtycode FROM TFNTCrdImpTmp C1
                    INNER JOIN
                    (
                        SELECT  ISNULL(CTY.FTCtycode,CTY.FTCtycode) AS FTCtycode
                        FROM TFNTCrdImpTmp CIT
                        LEFT JOIN  TFNMCardType CTY WITH (NOLOCK) ON CIT.FTCtyCode = CTY.FTCtyCode
                        WHERE CIT.FTSessionID = '".$tSessionID."'
                    ) C2 ON C1.FTCtycode = C2.FTCtycode
                    ".$tWhereSltSeqNo."
                ) ";

    $tSQL  .= $tWhereUpdSeqNo;
    $tSQL  .= " AND FTCidStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";
    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบรหัสประเภทบัตรในระบบ
    }else{
        return 0;   // พบรหัสประเภทบัตรในระบบ
    }
}

/**
 * Functionality: (เอกสารบัตรใหม่) ฟังก์ชั่นตรวจสอบแผนกว่ามีอยู่จริงหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 26/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHNewCrdChkDepartInDB($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];
    

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }
    $tErrorUsrDepartRmk  = language('document/card/docvalidate','tErrorUsrDepart');  // Add document validate (Bell) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorUsrDepartRmk."'
                WHERE  FTCidCrdDepart
                NOT IN(
                    SELECT  DISTINCT C1.FTCidCrdDepart FROM TFNTCrdImpTmp C1
                    INNER JOIN(
                        SELECT ISNULL(DEP.FTDptName,DEP.FTDptName) AS FTDptName
                        FROM TFNTCrdImpTmp CIT
                        LEFT JOIN  TCNMUsrDepart_L DEP ON CIT.FTCidCrdDepart = DEP.FTDptName
                        WHERE CIT.FTSessionID = '".$tSessionID."'
                    ) C2 ON C1.FTCidCrdDepart = C2.FTDptName
                    ".$tWhereSltSeqNo."  
                ) ";

    $tSQL  .= $tWhereUpdSeqNo;
    $tSQL  .= " AND FTCidStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบข้อมูลแผนกในระบบ
    }else{
        return 0;   // พบข้อมูลแผนกในระบบ
    }
}

/**
 * Functionality: (เอกสารบัตรใหม่) ฟังก์ชั่นตรวจสอบว่าบัตรในตาราง Temp ซ้ำกันหรือไม่ถ้าซ้ำจะไม่ถูก Process
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 26/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHNewCrdChkCrdCodeNotDupTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCrdTmpDup  = language('document/card/docvalidate','tErrorCrdTmpDup');  // Add document validate (Bell) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk =  '".$tErrorCrdTmpDup."'
                WHERE  FTCidCrdCode 
                IN(
                    SELECT DISTINCT C1.FTCidCrdCode FROM TFNTCrdImpTmp C1
                    INNER JOIN(
                        SELECT FTCidCrdCode , COUNT(FTCidCrdCode)  AS FNCidCrdCount
                        FROM TFNTCrdImpTmp
                        WHERE FTSessionID = '".$tSessionID."'
                        GROUP BY FTCidCrdCode
                    ) C2 ON C1.FTCidCrdCode = C2.FTCidCrdCode
                    AND C1.FTSessionID = '".$tSessionID."'
                    AND C2.FNCidCrdCount > 1 
                    ".$tWhereSltSeqNo."
                ) ";
    $tSQL  .= $tWhereUpdSeqNo;
    $tSQL  .= " AND (FTCidStaCrd = 1 AND FTSessionID = '".$tSessionID."')";
    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }else{
        return 0;   // ไม่พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }
}

/**
 * Functionality: (เอกสารบัตรใหม่) ฟังก์ชั่นตรวจสอบชื่อพนักงานหรือชื่อบัตรต้องมีการกรอกข้อมูลมาในระบบ
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 07/01/2019 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHNewCrdChkCrdNameNotEmpty($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCrdNameNotEmpty = language('document/card/docvalidate','tErrorCrdNameNotEmpty');  // Add document validate (Bell) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorCrdNameNotEmpty."'
                WHERE FTCidCrdCode
                IN (
                    SELECT CTT.FTCidCrdCode
                    FROM TFNTCrdImpTmp CTT
                    WHERE 1=1
                    AND (CTT.FTCidCrdName IS NULL OR CTT.FTCidCrdName = '')
                    AND (CTT.FTSessionID = '".$tSessionID."')
                    ".$tWhereSltSeqNo."
                ) ";

    $tSQL  .= $tWhereUpdSeqNo;
    $tSQL  .= " AND (FTCidStaCrd = 1 AND FTSessionID = '".$tSessionID."')";

    $oQuery = $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ชื่อพนักงานหรือชื่อบัตรมีค่าเท่ากับว่าง
    }else{
        return 0;   // ชื่อพนักงานหรือชื่อบัตรมีค่าไม่เท่ากับว่าง
    }

}



?>
