<?php

/*===== Begin Temp Validate in TCNTDocDTTmp ============================================*/
/**
* Functionality:ตรวจสอบรหัสว่ามีอยู่จริงหรือไม่
* Parameters: Array เงื่อนไขการเช็คค่า [paParams]
* [tUserSessionID => '', tFieldName => '', tTableName => '', tErrMsg => '']
* Creator: 02/07/2020 Piya
* Last Modified: -
* Return: -
* Return Type: Number
*/
function FCNnDocTmpChkCodeInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName']) 
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];
    $tTablename = $paParams['tTableName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = isset($paParams['tErrMsg'])?$paParams['tErrMsg']:language('common/main/main','ข้อมูลอ้างอิงไม่ถูกต้อง');
    $tFieldNameTmp = $tFieldName."Temp";

    $tSQL = " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '2', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName
        NOT IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT TMP.$tFieldName AS $tFieldNameTmp, ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
                FROM TCNTDocDTTmp TMP
                LEFT JOIN $tTablename MAS WITH (NOLOCK) ON TMP.$tFieldName = MAS.$tFieldName
                WHERE 1=1
                AND TMP.FTTmpStatus = '1'
                AND TMP.FTSessionID = '$tUserSessionID'
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            $tWhereSltSeqNo
        ) 
    ";
    
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID') AND ($tFieldName <> '' AND $tFieldName IS NOT NULL)";
    
    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1; // ไม่พบข้อมูลในระบบ
    }else{
        return 0; // พบข้อมูลในระบบ
    }
}

/**
* Functionality:ตรวจสอบรหัสว่ามีอยู่จริงหรือไม่ (Multiple Field)
* Parameters: Array เงื่อนไขการเช็คค่า [paParams]
* [tUserSessionID => '', tTableName => '', aFieldName = ['field_name1', 'field_name2, ...], tErrMsg => '']
* Creator: 02/07/2020 Piya
* Last Modified: -
* Return: -
* Return Type: Number
*/
function FCNnDocTmpChkCodeMultiInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName'])
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName = $paParams['aFieldName'];
    $tTablename = $paParams['tTableName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = isset($paParams['tErrMsg'])?$paParams['tErrMsg']:language('common/main/main','ข้อมูลอ้างอิงไม่ถูกต้อง');

    $tFieldOn1 = "";
    $tFieldOn2 = "";

    $tSelect = "";
    
    foreach($aFieldName as $nIndex => $tFieldName) {
        if($nIndex == 0){
            $tFieldOn1 .= " ON TMP.$tFieldName = MAS.$tFieldName";
            $tFieldOn2 .= " ON TMP1.$tFieldName = TMP2.$tFieldName";
        }else{
            $tFieldOn1 .= " AND TMP.$tFieldName = MAS.$tFieldName";
            $tFieldOn2 .= " AND TMP1.$tFieldName = TMP2.$tFieldName";
        }

        if ($nIndex == FCNnHSizeOf($aFieldName)-1) {
            $tSelect .= " ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName";
        }else{
            $tSelect .= " ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName,";
        }
    }

    $tSQL = " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '2', FTTmpRemark = '$tErrMsg'
    ";

    foreach ($aFieldName as $nIndex => $tFieldName) {
        if ($nIndex == 0) {
            $tSQL .= "
                WHERE $tFieldName
                NOT IN(
                    SELECT DISTINCT TMP1.$tFieldName FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
                    INNER JOIN(
                        SELECT $tSelect
                        FROM TCNTDocDTTmp TMP
                        LEFT JOIN $tTablename MAS WITH (NOLOCK) $tFieldOn1
                        WHERE 1=1
                        AND TMP.FTTmpStatus = '1'
                        AND TMP.FTSessionID = '$tUserSessionID'
                    ) TMP2 $tFieldOn2
                    $tWhereSltSeqNo
                ) 
            ";
        }else{
            $tSQL .= "
                OR $tFieldName
                NOT IN(
                    SELECT DISTINCT TMP1.$tFieldName FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
                    INNER JOIN(
                        SELECT $tSelect
                        FROM TCNTDocDTTmp TMP
                        LEFT JOIN $tTablename MAS WITH (NOLOCK) $tFieldOn1
                        WHERE 1=1
                        AND TMP.FTTmpStatus = '1'
                        AND TMP.FTSessionID = '$tUserSessionID'
                    ) TMP2 $tFieldOn2
                    $tWhereSltSeqNo
                ) 
            ";
        }
    }

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";
    
    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1; // ไม่พบข้อมูลในระบบ
    }else{
        return 0; // พบข้อมูลในระบบ
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tTableName => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Statuss
 * Return Type: Number
*/
function FCNnDocTmpChkCodeDupInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName']) 
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];
    $tTableName = $paParams['tTableName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = language('common/main/main','มีข้อมูลนี้อยู่แล้วในระบบ'); 

    $tSQL = " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '6', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName
        IN(
            SELECT ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
            FROM TCNTDocDTTmp TMP WITH (NOLOCK)
            LEFT JOIN $tTableName MAS WITH (NOLOCK) ON TMP.$tFieldName = MAS.$tFieldName
            WHERE 1=1
            AND TMP.FTTmpStatus = '1' 
    ";
    $tSQL .= $tWhereSltSeqNo;
    $tSQL .= " ) ";

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // กรณีมีการ Duplicate Code
    }else{
        return 0; // กรณีไม่มีการ Duplicate Code
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำหรือไม่ (Multiple Field)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tTableName => '', aFieldName = ['field_name1', 'field_name2, ...]]
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Statuss
 * Return Type: Number
*/
function FCNnDocTmpChkCodeMultiDupInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName'])
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName = $paParams['aFieldName'];
    $tTableName = $paParams['tTableName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = language('common/main/main','มีข้อมูลนี้อยู่แล้วในระบบ');

    $tSQL = " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '6', FTTmpRemark = '$tErrMsg'
        WHERE 1=1 
    ";

    $tFieldOn = "";

    foreach($aFieldName as $nIndex => $tFieldName) {
        if($nIndex == 0){
            $tFieldOn .= " ON TMP.$tFieldName = MAS.$tFieldName";
        }else{
            $tFieldOn .= " AND TMP.$tFieldName = MAS.$tFieldName";
        }
    }

    foreach($aFieldName as $tFieldName) {
        $tSQL .= "
            AND $tFieldName IN(
                SELECT ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
            FROM TCNTDocDTTmp TMP WITH (NOLOCK)
            LEFT JOIN $tTableName MAS WITH (NOLOCK) $tFieldOn
            WHERE 1=1 
            AND TMP.FTTmpStatus = '1' 
        ";

        $tSQL .= $tWhereSltSeqNo;
        $tSQL .= " ) ";
    }

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // กรณีมีการ Duplicate Code
    }else{
        return 0; // กรณีไม่มีการ Duplicate Code
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Statuss
 * Return Type: Number
*/
function FCNnDocTmpChkCodeDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL = " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName , COUNT($tFieldName) AS FNCount
                FROM TCNTDocDTTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND FTTmpStatus = '1'
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTTmpStatus = '1'
            AND TMP1.FTSessionID = '$tUserSessionID'
            AND TMP2.FNCount > 1 
            $tWhereSltSeqNo
        ) 
    ";

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (Multiple Field)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', aFieldName = ['field_name1', 'field_name2, ...]]
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Statuss
 * Return Type: Number
*/
function FCNnDocTmpChkCodeMultiDupInTemp(array $paParams = [],$paCondition)
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName']) 
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName     = $paParams['aFieldName'];
    $tTableNameTmp  = $paCondition['tTableNameTmp'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    
    $tSQL = " 
        UPDATE ".$tTableNameTmp." SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE 1=1 
    ";

    $tFieldMulti = implode(", ", $aFieldName);
    $tFieldOn = "";

    foreach($aFieldName as $nIndex => $tFieldName) {
        if($nIndex == 0){
            $tFieldOn .= " ON TMP1.$tFieldName = TMP2.$tFieldName";
        }else{
            $tFieldOn .= " AND TMP1.$tFieldName = TMP2.$tFieldName";
        }
    }

    foreach($aFieldName as $tFieldName) {
        $tSQL .= "
            AND $tFieldName IN(
                SELECT DISTINCT TMP1.$tFieldName FROM ".$tTableNameTmp." TMP1 WITH (NOLOCK)
                INNER JOIN(
                    SELECT $tFieldMulti, COUNT(*) AS FNCount
                    FROM ".$tTableNameTmp." WITH (NOLOCK)
                    WHERE FTSessionID = '$tUserSessionID'
                    AND FTTmpStatus = '1'
                    AND FTTmpTableKey <> 'TCNMPdtSpcBch'
                    GROUP BY $tFieldMulti
                ) TMP2 $tFieldOn
                AND TMP1.FTTmpStatus = '1'
                AND TMP1.FTSessionID = '$tUserSessionID'
                AND TMP2.FNCount > 1 
                $tWhereSltSeqNo
            ) 
        ";
    }

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (Edit Inline)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tFieldValue => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Statuss
 * Return Type: Number
*/
function FCNnDocTmpChkInlineCodeDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName'])
        || !isset($paParams['tFieldValue']) || empty($paParams['tFieldValue'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];

    $tFieldValue = $paParams['tFieldValue'];
    if (substr($paParams['tFieldName'],1,1) == "T") {
        $tFieldValue = "'".$paParams['tFieldValue']."'";
    }

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tSQL = " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = 1, FTTmpRemark = ''
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName /*, COUNT($tFieldName) AS FNCount*/
                FROM TCNTDocDTTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND $tFieldName = $tFieldValue
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTSessionID = '$tUserSessionID'
            /*AND TMP2.FNCount > 1*/ 
            $tWhereSltSeqNo
            AND TMP1.$tFieldName = $tFieldValue
        ) 
    ";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus <> '1' AND FTSessionID = '$tUserSessionID')";

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL .= " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName , COUNT($tFieldName) AS FNCount
                FROM TCNTDocDTTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND FTTmpStatus = '1'
                AND $tFieldName = $tFieldValue
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTTmpStatus = '1'
            AND TMP1.FTSessionID = '$tUserSessionID'
            AND TMP2.FNCount > 1 
            $tWhereSltSeqNo
            AND TMP1.$tFieldName = $tFieldValue
        ) 
    ";

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (Multiple Field and Edit Inline)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', aFieldName = [['field_name1', 'value1'], ['field_name2', 'value2'], [...]]
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Statuss
 * Return Type: Number
*/
function FCNnDocTmpChkInlineCodeMultiDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName']) 
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName = $paParams['aFieldName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNXtdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNXtdSeqNo = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tFieldMulti = "";
    $tFieldOn = "";
    $tFieldWhere = "";
    $tFieldWhereTmp2 = "";

    foreach($aFieldName as $nIndex => $tField) {
        /**
         * tField[0] : fieldname, 
         * tField[1] : fieldvalue
         */
        if($nIndex == 0){
            $tFieldOn .= " ON TMP1.$tField[0] = TMP2.$tField[0]";
        }else{
            $tFieldOn .= " AND TMP1.$tField[0] = TMP2.$tField[0]";
        }

        $tFieldWhere .= " AND $tField[0] = '$tField[1]'";
        $tFieldWhereTmp2 .= " AND TMP2.$tField[0] = '$tField[1]'";

        if($nIndex == FCNnHSizeOf($aFieldName)-1){
            $tFieldMulti .= "$tField[0] ";
        }else{
            $tFieldMulti .= "$tField[0], ";
        }
        
    }

    $tSQL = " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '1', FTTmpRemark = ''
        WHERE 1=1 
    ";
    
    foreach($aFieldName as $nIndex => $tField) {
        /**
         * tField[0] : fieldname, 
         * tField[1] : fieldvalue
         */
        $tSQL .= "
            AND $tField[0] IN(
                SELECT DISTINCT TMP1.$tField[0] FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
                INNER JOIN(
                    SELECT $tFieldMulti/*, COUNT(*) AS FNCount*/
                    FROM TCNTDocDTTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tUserSessionID'
                    GROUP BY $tFieldMulti
                ) TMP2 $tFieldOn
                AND TMP1.FTSessionID = '$tUserSessionID'
                /*AND TMP2.FNCount > 1*/ 
                $tWhereSltSeqNo
                $tFieldWhereTmp2
            ) 
        ";
    }

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= $tFieldWhere;
    $tSQL .= " AND (FTTmpStatus <> '1' AND FTSessionID = '$tUserSessionID')";


    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL .= " 
        UPDATE TCNTDocDTTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE 1=1 
    ";

    foreach($aFieldName as $nIndex => $tField) {
        /**
         * tField[0] : fieldname, 
         * tField[1] : fieldvalue
         */
        $tSQL .= "
            AND $tField[0] IN(
                SELECT DISTINCT TMP1.$tField[0] FROM TCNTDocDTTmp TMP1 WITH (NOLOCK)
                INNER JOIN(
                    SELECT $tFieldMulti, COUNT(*) AS FNCount
                    FROM TCNTDocDTTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tUserSessionID'
                    AND FTTmpStatus = '1'
                    GROUP BY $tFieldMulti
                ) TMP2 $tFieldOn
                AND TMP1.FTTmpStatus = '1'
                AND TMP1.FTSessionID = '$tUserSessionID'
                AND TMP2.FNCount > 1 
                $tWhereSltSeqNo
                $tFieldWhereTmp2
            ) 
        ";
    }

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= $tFieldWhere;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}
/*===== End Temp Validate in TCNTDocDTTmp ==============================================*/