<?php

function FSxCGENAssignRandValue($num) {
    // accepts 1 - 36
    switch ($num) {
        case "1" :
            $rand_value = "a";
            break;
        case "2" :
            $rand_value = "b";
            break;
        case "3" :
            $rand_value = "c";
            break;
        case "4" :
            $rand_value = "d";
            break;
        case "5" :
            $rand_value = "e";
            break;
        case "6" :
            $rand_value = "f";
            break;
        case "7" :
            $rand_value = "g";
            break;
        case "8" :
            $rand_value = "h";
            break;
        case "9" :
            $rand_value = "i";
            break;
        case "10" :
            $rand_value = "j";
            break;
        case "11" :
            $rand_value = "k";
            break;
        case "12" :
            $rand_value = "l";
            break;
        case "13" :
            $rand_value = "m";
            break;
        case "14" :
            $rand_value = "n";
            break;
        case "15" :
            $rand_value = "o";
            break;
        case "16" :
            $rand_value = "p";
            break;
        case "17" :
            $rand_value = "q";
            break;
        case "18" :
            $rand_value = "r";
            break;
        case "19" :
            $rand_value = "s";
            break;
        case "20" :
            $rand_value = "t";
            break;
        case "21" :
            $rand_value = "u";
            break;
        case "22" :
            $rand_value = "v";
            break;
        case "23" :
            $rand_value = "w";
            break;
        case "24" :
            $rand_value = "x";
            break;
        case "25" :
            $rand_value = "y";
            break;
        case "26" :
            $rand_value = "z";
            break;
        case "27" :
            $rand_value = "0";
            break;
        case "28" :
            $rand_value = "1";
            break;
        case "29" :
            $rand_value = "2";
            break;
        case "30" :
            $rand_value = "3";
            break;
        case "31" :
            $rand_value = "4";
            break;
        case "32" :
            $rand_value = "5";
            break;
        case "33" :
            $rand_value = "6";
            break;
        case "34" :
            $rand_value = "7";
            break;
        case "35" :
            $rand_value = "8";
            break;
        case "36" :
            $rand_value = "9";
            break;
    }
    return $rand_value;
}

function FSxCGENGetRandAlphanumeric($length) {
    if ($length > 0) {
        $rand_id = "";
        for ($i = 1; $i <= $length; $i ++) {
            mt_srand((double) microtime() * 1000000);
            $num = mt_rand(1, 36);
            $rand_id .= FSxCGENAssignRandValue($num);
        }
    }
    return $rand_id;
}

// /**
//  * Fs set language
//  */
// function language($file, $string, $sprintf = '') {
//     $obj = & get_instance();
//     if (@$_SESSION ['lang'] == '' || @$_SESSION ['lang'] == 'th') {
//         @$_SESSION ['lang'] = 'th';
//         @$_SESSION ['tLangID'] = 1;
//         $lang = 'th';
//     } else {
//         $lang = $_SESSION ['lang'];
//         @$_SESSION ['tLangID'] = 2;
//     }
//     $obj->lang->load($file, $lang);
//     $rs = sprintf($obj->lang->line($string), $sprintf);
//     // echo $rs;
//     // exit;
//     if ($rs) {
//         return $rs;
//     } else {
//         return $string;
//     }
// }

/**
 * Fs set language
 */
function language($file, $string, $sprintf = '') {
    $obj = & get_instance();
    if (@$_SESSION ['lang'] == '' || @$_SESSION ['lang'] == 'th') {
        @$_SESSION ['lang'] = 'th';
        @$_SESSION ['tLangID'] = 1;
        $lang = 'th';
    } else {
        $lang = $_SESSION ['lang'];
    }
    $obj->lang->load($file, $lang);
    $rs = sprintf($obj->lang->line($string), $sprintf);
    
    if ($rs) {
        return $rs;
    } else {
        return $string;
    }
}

// เช็คเรื่องภาษา ตาราง L
// $tTatle_L : ชื่อ Table L
// $nFieldIDName : ชื่อ Field ที่ใช้ในการ Where
// $nID : ID ที่ใช้ Where
function FSnCheckUpdateLang($tTatle_L, $nFieldIDName, $nID) {
    $ci = & get_instance();
    $ci->load->database();

    $tSQL = "SELECT COUNT (FNLngID) AS counts
	FROM $tTatle_L
	WHERE $nFieldIDName = '$nID'
	AND FNLngID = " . @$_SESSION ['tLangEdit'] . " ";

    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
        return $oQuery->result();
    } else {
        return false;
    }
}

function GenSignName($pnSingNo) {
    $aSeatSign = array(
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z'
    );
    if ($pnSingNo > 25 and $pnSingNo < 52) {
        $sign = $pnSingNo - 26;
        $signNo = $aSeatSign [$sign] . '1';
    } else if ($pnSingNo >= 52 and $pnSingNo < 78) {
        $sign = $pnSingNo - 52;
        $signNo = $aSeatSign [$sign] . '2';
    } else if ($pnSingNo >= 78 and $pnSingNo < 104) {
        $sign = $pnSingNo - 78;
        $signNo = $aSeatSign [$sign] . '3';
    } elseif ($pnSingNo >= 104 and $pnSingNo < 130) {
        $sign = $pnSingNo - 104;
        $signNo = $aSeatSign [$sign] . '4';
    } elseif ($pnSingNo >= 130 and $pnSingNo < 156) {
        $sign = $pnSingNo - 130;
        $signNo = $aSeatSign [$sign] . '5';
    } elseif ($pnSingNo >= 156 and $pnSingNo < 182) {
        $sign = $pnSingNo - 156;
        $signNo = $aSeatSign [$sign] . '6';
    } elseif ($pnSingNo >= 182 and $pnSingNo < 217) {
        $sign = $pnSingNo - 182;
        $signNo = $aSeatSign [$sign] . '7';
    } else {
        $signNo = $aSeatSign [$pnSingNo];
    }
    return $signNo;
}

/**
 * Fs check Remember
 */
function FSxRemember() {
    if (@!$_SESSION ['username']) {
        if (isset($_COOKIE ['auth'])) {
            parse_str($_COOKIE ['auth']);
            $_SESSION ['username'] = $username;
            $_SESSION ['FNGahID'] = $FNGahID;
            $_SESSION ['langnum'] = $langnum;
            $_SESSION ['lang'] = $lang;
        } else {
            
        }
    } else {
        
    }
}

function Encode($string, $key = null) {
    if ($key == null) {
        $key = Hash::create('md5', 'ticket_to_haven', HASH_PASSWORD_KEY);
    } else {
        $key = Hash::create('md5', $key, HASH_PASSWORD_KEY);
    }
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = strlen($key);
    $hash;
    for ($i = 0; $i < $strLen; $i ++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j ++;
        @$hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function Decode($string, $key = null) {
    if ($key == null) {
        $key = Hash::create('md5', 'ticket_to_haven', HASH_PASSWORD_KEY);
    } else {
        $key = Hash::create('md5', $key, HASH_PASSWORD_KEY);
    }
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = strlen($key);
    $hash;
    for ($i = 0; $i < $strLen; $i += 2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j ++;
        @$hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function FSnCheckImg($tTatle, $nFieldIDName, $nID, $nImgType) {
    $ci = & get_instance();
    $ci->load->database();
    $tSQL = "SELECT COUNT (FNImgID) AS counts
	FROM $tTatle
	WHERE $nFieldIDName = '$nID' AND FNImgSeq = '1' AND FTImgType = '$nImgType'";
    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
        return $oQuery->result();
    } else {
        return false;
    }
}

function FsxDateTime($tDataTime) {
    if ($tDataTime != '') {
        $aExplode = explode('-', $tDataTime);
        $aExplode2 = explode(' ', $aExplode [2]);
        return $aExplode2[0] . '-' . $aExplode[1] . '-' . $aExplode[0] . ' ' . $aExplode2[1];
    } else {
        return NULL;
    }
}

function FsxDate($tDate) {
    if ($tDate != '') {
        $aExplode = explode('-', $tDate);
        return $aExplode [2] . '-' . $aExplode [1] . '-' . $aExplode [0];
    } else {
        return NULL;
    }
}

function FsxCheckTime($tTimeFrom, $tTimeTo) {
    $A = date("A", strtotime($tTimeFrom));
    $B = date("A", strtotime($tTimeTo));
    $D1 = date("H:i:s", strtotime($tTimeFrom));
    $MID = date("H:i:s", strtotime('24:00'));
    $tTime = $A . $B;
    switch ($tTime) {
        case 'AMAM' :
            if ($D1 < $MID) {
                return 1;
            } else {
                return 2;
            }
            break;
        case 'AMPM' :
            return 1;
            break;
        case 'PMAM' :
            return 2;
            break;
        case 'PMPM' :
            return 1;
            break;
    }
}

function FsxInput($tMsg) {
    return htmlentities($tMsg, ENT_QUOTES | ENT_IGNORE, 'UTF-8');
}

function FsxCodeID($tField, $tTable, $nAmount) {
    $ci = & get_instance();
    $ci->load->database();
    $tSQL = "SELECT TOP 1 $tField FROM $tTable ORDER BY $tField DESC";
    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
        $oRow = $oQuery->result();
        return str_pad($oRow[0]->$tField + 1, $nAmount, '0', STR_PAD_LEFT);
    } else {
        return str_pad(0 + 1, $nAmount, '0', STR_PAD_LEFT);
    }
}

function FSaCVFNCall($ptURLAPI, $ptMethod, $oParamet = '') {
    $ci = &get_instance();
    $tCurlEx = curl_init($ci->config->item('URLAPI') . $ptURLAPI);
    curl_setopt($tCurlEx, CURLOPT_CUSTOMREQUEST, "$ptMethod");
    curl_setopt($tCurlEx, CURLOPT_POSTFIELDS, $oParamet);
    curl_setopt($tCurlEx, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($tCurlEx, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'X-API-KEY : ' . $ci->config->item('APIAuthKey') . '',
        'Content-Length: ' . strlen($oParamet)
    ));
    curl_setopt($tCurlEx, CURLOPT_TIMEOUT, 360);
    curl_setopt($tCurlEx, CURLOPT_CONNECTTIMEOUT, 360);
    // execute post
    $oResult = curl_exec($tCurlEx);
    try {
        if ($oResult === false) {
            return 'Curl error: ' . curl_error($tCurlEx);
        } else {
            return json_decode($oResult, true);
        }
    } catch (Exception $e) {
        return 'Service down.';
    }
}

function FSaConfigReport() {
    $ci = &get_instance();
    $ci->load->database();
    return array(
        "assets" => array(
            "path" => "application/assets/koolreport",
            "url" => base_url()."application/assets/koolreport",
        ),
        "dataSources" => array(
            "sqlserver" => array(
                'host' => $ci->db->hostname,
                'username' => $ci->db->username,
                'password' => $ci->db->password,
                'dbname' => $ci->db->database,
                'charset' => $ci->db->char_set,
                'class' => "\koolreport\datasources\SQLSRVDataSource"
            )
        )
    );
}

// Functionality: Function Remove Tag Dom PHP
// Parameters: Text Html
// Creator: 05/04/2019 Wasin(Yoshi)
// Last Modified:
// Return: html String
// Return Type: string
function FCNtRemoveDomHtml($ptHtml,$ptRemoveTag){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $oDom   = new DOMDocument();
    libxml_use_internal_errors(true);
    $tEncodeDomUTF = mb_convert_encoding($ptHtml, 'HTML-ENTITIES', 'UTF-8');
    $oDom->loadHTML($tEncodeDomUTF);
    $tags_to_remove = array($ptRemoveTag);
    foreach($tags_to_remove as $tag){
        $element = $oDom->getElementsByTagName($tag);
        foreach($element  as $item){
            $item->parentNode->removeChild($item);
        }
    }
    $tReturnHtml = $oDom->saveHTML();
    return $tReturnHtml;
}

/**
 * Random String with EN Only
 * Parameters: $pnLength = ความยาวชุดอักษร, $pnQty = จำนวนชุดอักษร
 * Creator: 25/12/2019 Piya
 * Last Modified: -
 * Return: Random String Set
 * Return Type: array
 */
function FCNaGetRandomENString($pnLength = 10, $pnQty = 0){

    $tCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nCharactersLength = strlen($tCharacters);
    $tRandomString = '';
    $aRandomStringSet = [];

    $nLoopLimit = FCNnFactorial($pnLength);
    if($pnQty > $nLoopLimit){
        echo "Qty Limit ($nLoopLimit)";
        return;
    }
    
    for ($nLoopQty = 0; $nLoopQty < $pnQty; $nLoopQty++) {
        random:
        for ($nLoopStr = 0; $nLoopStr < $pnLength; $nLoopStr++) {
            $tRandomString .= $tCharacters[rand(0, $nCharactersLength - 1)];
        }

        if(in_array($tRandomString, $aRandomStringSet)){
            $tRandomString = '';
            goto random;       
        }else{
            $aRandomStringSet[] = $tRandomString;
            $tRandomString = '';
        }
    }

    return $aRandomStringSet;
}


function FCNnFactorial($pnNum){ 
    if($pnNum <= 1){   
        return 1;   
    }   
    else{   
        return $pnNum * FCNnFactorial($pnNum - 1);   
    }   
}