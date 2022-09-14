<?php
function FSaHDeCodeUrlParameter($ptInfor,$paParamiterMap){
    //===========frist decode=============
    $tFristDecodeInfor = base64_decode($ptInfor);
    $aFristDecodeInfor = explode("&",$tFristDecodeInfor);
    //===========end frist decode=============
    $tRuleCompareUpper = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    $tRuleCompareLower = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    $aResult = array();
    $aKeyResult = array();
    //===========secound decode=============
    for($nI = 0;$nI<count($aFristDecodeInfor);$nI++){
        $aFristDecodeMemmer = explode("=",$aFristDecodeInfor[$nI]);
        $tKey = $aFristDecodeMemmer[0];
        $tKeyChar = str_split($tKey);
        $tVldSecoundKey = "";
        for($nJ = 0;$nJ<count($tKeyChar);$nJ++){
            $letters = "/^[a-zA-Z]+$/";
            if(preg_match($letters,$tKeyChar[$nJ])){
                if($tKeyChar[$nJ]==strtoupper($tKeyChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareUpper);$nZ++){
                        if($tKeyChar[$nJ]==$tRuleCompareUpper[$nZ]){
                            if(($nZ+5)>count($tRuleCompareUpper)){
                                $nDifLoop = ($nZ+5)-count($tRuleCompareUpper);
                            }else{
                                $nDifLoop = $nZ+5;
                            }
                            break;
                        }
                    }
                    $tKeyChar[$nJ] = $tRuleCompareUpper[$nDifLoop];
                }else if($tKeyChar[$nJ]==strtolower($tKeyChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareLower);$nZ++){
                        if($tKeyChar[$nJ]==$tRuleCompareLower[$nZ]){
                            if(($nZ+5)>count($tRuleCompareLower)){
                                $nDifLoop = ($nZ+5)-count($tRuleCompareLower);
                            }else{
                                $nDifLoop = $nZ+5;
                            }
                            break;
                        }
                    }
                    $tKeyChar[$nJ] = $tRuleCompareLower[$nDifLoop];
                }
            }
            $tVldSecoundKey .= $tKeyChar[$nJ];
        }
        $tValue = $aFristDecodeMemmer[1];
        $tValueChar = str_split($tValue);
        $tVldSecoundValue = "";
        for($nJ = 0;$nJ<count($tValueChar);$nJ++){
            $letters = "/^[a-zA-Z]+$/";
            if(preg_match($letters,$tValueChar[$nJ])){
                if($tValueChar[$nJ]==strtoupper($tValueChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareUpper);$nZ++){
                        if($tValueChar[$nJ]==$tRuleCompareUpper[$nZ]){
                            if(($nZ+5)>count($tRuleCompareUpper)){
                                $nDifLoop = ($nZ+5)-count($tRuleCompareUpper);
                            }else{
                                $nDifLoop = $nZ+5;
                            }
                            break;
                        }
                    }
                    $tValueChar[$nJ] = $tRuleCompareUpper[$nDifLoop];
                }else if($tValueChar[$nJ]==strtolower($tValueChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareLower);$nZ++){
                        if($tValueChar[$nJ]==$tRuleCompareLower[$nZ]){
                            if(($nZ+5)>count($tRuleCompareLower)){
                                $nDifLoop = ($nZ+5)-count($tRuleCompareLower);
                            }else{
                                $nDifLoop = $nZ+5;
                            }
                            break;
                        }
                    }
                    $tValueChar[$nJ] = $tRuleCompareLower[$nDifLoop];
                }
            }
            $tVldSecoundValue .= $tValueChar[$nJ];
        }
        //===========end secound decode=============
        //===========third decode=============
        $tKey = $tVldSecoundKey;
        $tKeyChar = str_split($tKey);
        $tVldThirdKey = "";
        for($nJ = 0;$nJ<count($tKeyChar);$nJ++){
            $letters = "/^[a-zA-Z]+$/";
            if(preg_match($letters,$tKeyChar[$nJ])){
                if($tKeyChar[$nJ]==strtoupper($tKeyChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareUpper);$nZ++){
                        if($tKeyChar[$nJ]==$tRuleCompareUpper[$nZ]){
                            if(($nZ+5)>count($tRuleCompareUpper)){
                                $nDifLoop = ($nZ-2)+count($tRuleCompareUpper);
                            }else{
                                $nDifLoop = $nZ-2;
                            }
                            break;
                        }
                    }
                    $tKeyChar[$nJ] = $tRuleCompareUpper[$nDifLoop];
                }else if($tKeyChar[$nJ]==strtolower($tKeyChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareLower);$nZ++){
                        if($tKeyChar[$nJ]==$tRuleCompareLower[$nZ]){
                            if(($nZ+5)>count($tRuleCompareLower)){
                                $nDifLoop = ($nZ-2)+count($tRuleCompareUpper);
                            }else{
                                $nDifLoop = $nZ-2;
                            }
                            break;
                        }
                    }
                    $tKeyChar[$nJ] = $tRuleCompareLower[$nDifLoop];
                }
            }
            $tVldThirdKey .= $tKeyChar[$nJ];
        }
        $tValue = $tVldSecoundValue;
        $tValueChar = str_split($tValue);
        $tVldThirdValue = "";
        for($nJ = 0;$nJ<count($tValueChar);$nJ++){
            $letters = "/^[a-zA-Z]+$/";
            if(preg_match($letters,$tValueChar[$nJ])){
                if($tValueChar[$nJ]==strtoupper($tValueChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareUpper);$nZ++){
                        if($tValueChar[$nJ]==$tRuleCompareUpper[$nZ]){
                            if(($nZ-2)<0){
                                $nDifLoop = ($nZ-2)+count($tRuleCompareUpper);
                            }else{
                                $nDifLoop = $nZ-2;
                            }
                            break;
                        }
                    }
                    $tValueChar[$nJ] = $tRuleCompareUpper[$nDifLoop];
                }else if($tValueChar[$nJ]==strtolower($tValueChar[$nJ])){
                    $nDifLoop = 0;
                    for($nZ = 0;$nZ<count($tRuleCompareLower);$nZ++){
                        if($tValueChar[$nJ]==$tRuleCompareLower[$nZ]){
                            if(($nZ+5)>count($tRuleCompareLower)){
                                $nDifLoop = ($nZ-2)+count($tRuleCompareLower);
                            }else{
                                $nDifLoop = $nZ-2;
                            }
                            break;
                        }
                    }
                    $tValueChar[$nJ] = $tRuleCompareLower[$nDifLoop];
                }
            }
            $tVldThirdValue .= $tValueChar[$nJ];
        }
        //===========end third decode=============
        array_push($aResult,array($tVldThirdKey=>$tVldThirdValue));
        array_push($aKeyResult,$tVldThirdKey);
    }
    $aKeyUnique = array_unique($aKeyResult);
    if(count($aKeyUnique)==count($paParamiterMap)){
        $bCheckKeyVld = false;
        for($nI=0;$nI<count($aResult);$nI++){
            foreach($aResult[$nI] as $key => $value) {
                for($nJ=0;$nJ<count($paParamiterMap);$nJ++){
                    if($key==$paParamiterMap[$nJ]){
                        $bCheckKeyVld = true;
                        break;
                    }
                }
            }
            if($bCheckKeyVld==false){
                break;
            }
        }
        if($bCheckKeyVld){
            $aSendInfor = array();
            for($nI=0;$nI<count($aResult);$nI++){
                foreach($aResult[$nI] as $key => $value) {
                    $aSendInfor[$key] = $value;
                }
            }
            return $aSendInfor;
        }else{
            return false;
        }
    }else{
        return false;
    }
}