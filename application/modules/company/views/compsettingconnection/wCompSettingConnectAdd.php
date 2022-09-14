<?php
if ($aResult['rtCode'] == 1) {

    $tImgObjAll =  $aResult['raItems'][0]['FTUrlLogo'];


    $tUrlID               = '';
    $tUrlAddress           = '';
    $tUrlPort           = '';
    $tUrlKey            = '';
    $tUrlType           = '';

    $tUolVhost          = '';
    $tUolUser           = '';
    $tUolPassword       = '';
    $tUolKey            = '';
    $tRemark            = '';
    $tUsrStaActive      = '';

    $tUolVhost1         = '';
    $tUolUser1          = '';
    $tUolPassword1      = '';
    $tUolKey1           = '';
    $tRemark1           = '';
    $tUsrStaActive1     = '';

    $tUolVhost2         = '';
    $tUolUser2          = '';
    $tUolPassword2      = '';
    $tUolKey2           = '';
    $tRemark2           = '';
    $tUsrStaActive2     = '';

    $tUolVhost3         = '';
    $tUolUser3          = '';
    $tUolPassword3      = '';
    $tUolKey3           = '';
    $tRemark3           = '';
    $tUsrStaActive3     = '';

    $tUolVhost4         = '';
    $tUolUser4          = '';
    $tUolPassword4      = '';
    $tUolKey4           = '';
    $tRemark4           = '';
    $tUsrStaActive4     = '';

    // Type 1 URL
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "1") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 2 URL + Author
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "2") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            // $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4     = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 3 URL+MQ
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {


        // TCNTUrlObject
        $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
        $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
        $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
        $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
        $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

        //TCNTUrlObjectLogin
        $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
        $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
        $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
        $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
        $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
        $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

        if ($aResult['raItems'][$nI]["FTUolKey"] == "MQMain") {
            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
        if ($aResult['raItems'][$nI]["FTUolKey"] == "MQDocument") {
            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
        if ($aResult['raItems'][$nI]["FTUolKey"] == "MQSale") {
            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
        if ($aResult['raItems'][$nI]["FTUolKey"] == "MQWallet") {
            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 4 API2PSMaster
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "4") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 5  API2PSSale
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "5") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 6  API2RTMaster
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "6") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 7  API2RTSale
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "7") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 8  API2FNWallet
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "8") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 9  API2CNMember
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "9") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];
        }
    }

    // Type 10 API2RDFace
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "10") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];
        }
    }

    // Type 11 API2RDFaceRegis
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "11") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];
        }
    }


    // Type 12  API2FNWallet
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "12") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 13  API2FNWallet
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "13") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];
            if ($aResult['raItems'][$nI]["FTUolKey"] == "MQMember") {
                $tUolVhost1          = $aResult['raItems'][$nI]['FTUolVhost'];
                $tUolUser1           = $aResult['raItems'][$nI]['FTUolUser'];
                $tUolPassword1       = $aResult['raItems'][$nI]['FTUolPassword'];
                $tUolKey1            = $aResult['raItems'][$nI]['FTUolKey'];
                $tRemark1            = $aResult['raItems'][$nI]['FTUolgRmk'];
                $tUsrStaActive1      = $aResult['raItems'][$nI]['FTUolStaActive'];
            }
            $tUolVhost2          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4      = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }


    // Type 14 URL + Author (API2PSStock)
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "14") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            // $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4     = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 14 URL + Author (API2RTStock)
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "15") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            // $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4     = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 16 MQAI
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "16") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            // $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4     = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    // Type 17 MQ
    for ($nI = 0; $nI < FCNnHSizeOf($aResult['raItems']); $nI++) {
        if ($aResult['raItems'][$nI]["FNUrlType"] == "17") {
            $tUrlID               = $aResult['raItems'][$nI]['FNUrlID'];
            $tUrlAddress           = $aResult['raItems'][$nI]['rtAddressUrlobj'];
            $tUrlPort           = $aResult['raItems'][$nI]['FTUrlPort'];
            $tUrlKey            = $aResult['raItems'][$nI]['FTUrlKey'];
            $tUrlType           = $aResult['raItems'][$nI]['FNUrlType'];

            // $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolVhost          = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser           = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword       = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey            = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark            = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive      = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost1         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser1          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword1      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey1           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark1           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive1     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost2         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser2          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword2      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey2           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark2           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive2     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost3         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser3          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword3      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey3           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark3           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive3     = $aResult['raItems'][$nI]['FTUolStaActive'];

            $tUolVhost4         = $aResult['raItems'][$nI]['FTUolVhost'];
            $tUolUser4          = $aResult['raItems'][$nI]['FTUolUser'];
            $tUolPassword4      = $aResult['raItems'][$nI]['FTUolPassword'];
            $tUolKey4           = $aResult['raItems'][$nI]['FTUolKey'];
            $tRemark4           = $aResult['raItems'][$nI]['FTUolgRmk'];
            $tUsrStaActive4     = $aResult['raItems'][$nI]['FTUolStaActive'];
        }
    }

    $tWhere = $tUrlAddress . ',' . $tUolVhost . ',' . $tUolUser . ',' . $tUolKey;

    $tEventpage  = "Edit";
    $tRoute      = "CompSettingConEventEdit";
} else {

    $tUrlID              = "";

    // TCNTUrlObject
    $tUrlAddress         = "";
    $tUrlPort            = "";
    $tUrlKey             = "";
    $tUrlType            = "";


    //TCNTUrlObjectLogin
    $tUolVhost           = "";
    $tUolUser            = "";
    $tUolPassword        = "";
    $tUolKey             = "";
    $tRemark             = "";
    $tUsrStaActive       = "";

    $tUolVhost1          = "";
    $tUolUser1           = "";
    $tUolPassword1       = "";
    $tUolKey1            = "";
    $tRemark1            = "";
    $tUsrStaActive1      = "";

    $tUolVhost2          = "";
    $tUolUser2           = "";
    $tUolPassword2       = "";
    $tUolKey2            = "";
    $tRemark2            = "";
    $tUsrStaActive2      = "";

    $tUolVhost3          = "";
    $tUolUser3           = "";
    $tUolPassword3       = "";
    $tUolKey3            = "";
    $tRemark3            = "";
    $tUsrStaActive3      = "";

    $tUolVhost4          = "";
    $tUolUser4           = "";
    $tUolPassword4       = "";
    $tUolKey4            = "";
    $tRemark4            = "";
    $tUsrStaActive4      = "";



    $tImgObjAll         = "";

    $tWhere     = "";
    $tRoute     = "CompSettingConEventAdd";
    $tEventpage = "Add";
}
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditCompSettingConnect">
    <input type="hidden" id="ohdTRoute" value="<?php echo $tRoute; ?>">
    <input type="hidden" id="ohdUrlId" name="ohdUrlId" value="<?php echo $tUrlID; ?>">
    <input type="hidden" id="ohdWhere" name="ohdWhere" value="<?php echo $tWhere; ?>">

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxCompSettingConnect();"><?php echo language('company/compsettingconnect/compsettingconnect', 'tDetailSettingConnect') ?></label>
            <label class="xCNLabelFrm">
                <?php
                if ($tEventpage == "Edit") { ?>
                    <label class="xCNLabelFrm xWPageEdit" style="color: #aba9a9 !important;"> / <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompSettingEdit') ?> </label>
                <?php } else if ($tEventpage == "Add") { ?>
                    <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompAddSetConnect') ?> </label>
                <?php }
                ?>
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxCompSettingConnect();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel') ?>
            </button>
            <?php if ($aAlwEventCompSettingCon['tAutStaFull'] == 1 || ($aAlwEventCompSettingCon['tAutStaAdd'] == 1 || $aAlwEventCompSettingCon['tAutStaEdit'] == 1)) : ?>
                <input id="ohdTypeResendData" type="hidden" value="normal">
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtBchSettingConnectSave" onclick="JSxCompSettingConnectSaveAddEdit('<?= $tRoute ?>')"> <?php echo  language('common/main/main', 'tSave') ?></button>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <!-- id="odvPanelUrl" -->
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('company/compsettingconnect/compsettingconnect', 'tCompSettingURL'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataCompSettingCon" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>

                <div id="odvDataCompSettingCon" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">
                        <!-- UploadImg CompSettingConnection -->
                        <!-- <div class="col-lg-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <div class="odvCompLogo">
                                        <?php
                                        if (isset($tImgObjAll) && !empty($tImgObjAll)) {

                                            $tImgPath  = explode("/application/modules/", $tImgObjAll);

                                            $tFullPatch = './application/modules/' . $tImgPath[1];



                                            if (file_exists($tFullPatch)) {
                                                $tPatchImg = base_url() . '/application/modules/' . $tImgPath[1];
                                            } else {
                                                $tPatchImg = base_url() . 'application/modules/common/assets/images/300x60.png';
                                            }
                                        } else {
                                            $tPatchImg = base_url() . 'application/modules/common/assets/images/300x60.png';
                                        }
                                        ?>
                                        <img class="img-responsive xCNImgCenter" id="oimImgMasterCompSetCon" src="<?php echo @$tPatchImg; ?>">
                                    </div>
                                    <div class="xCNUplodeImage">
                                        <input type="text" class="xCNHide" id="oetImgInputCompSetConOld" name="oetImgInputCompSetConOld"  value="<?php echo @$tImgName; ?>">
                                        <input type="text" class="xCNHide" id="oetImgInputCompSetCon" 	name="oetImgInputCompSetCon" 	value="<?php echo @$tImgName; ?>">
                                        <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','CompSetCon')">
                                            <i class="fa fa-picture-o xCNImgButton"></i> <?php echo  language('common/main/main', 'tSelectPic') ?>
                                        </button>
                                    </div>
                                </div>
                            </div> -->

                        <!-- ประเภทการเข้าใช้งาน -->
                        <!-- <div class="col-lg-6 col-md-6 col-xs-6"> -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/compsettingconnect/compsettingconnect', 'tCompSettingType'); ?></label>
                            <?php
                            if (isset($tUrlType) && !empty($tUrlType)) {
                            ?>
                                <input type="hidden" id="ohdTypeAddUrlType" name="ohdTypeAddUrlType" value="1">
                                <input type="hidden" id="ohdTypeAddUrlTypeVal" name="ohdTypeAddUrlTypeVal" value="<?php echo $tUrlType; ?>">
                                <select class="selectpicker form-control" id="ocmUrlConnecttype" name="ocmUrlConnecttype" onchange="JSxCompSettingConTypeUsed('insert')" <? //= "disabled"
                                                                                                                                                                            ?>>
                                    <option value="1" <?= (!empty($tUrlType) && $tUrlType == '1') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchUrlType'); ?>
                                    </option>
                                    <option value="2" <?= (!empty($tUrlType) && $tUrlType == '2') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAuthorized'); ?>
                                    </option>
                                    <option value="3" <?= (!empty($tUrlType) && $tUrlType == '3') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLMQURL'); ?>
                                    </option>
                                    <option value="4" <?= (!empty($tUrlType) && $tUrlType == '4') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2PSMaster'); ?>
                                    </option>
                                    <option value="5" <?= (!empty($tUrlType) && $tUrlType == '5') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2PSSale'); ?>
                                    </option>
                                    <option value="6" <?= (!empty($tUrlType) && $tUrlType == '6') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2RTMaster'); ?>
                                    </option>
                                    <option value="7" <?= (!empty($tUrlType) && $tUrlType == '7') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2RTSale'); ?>
                                    </option>
                                    <option value="8" <?= (!empty($tUrlType) && $tUrlType == '8') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2FNWallet'); ?>
                                    </option>
                                    <option value="9" <?= (!empty($tUrlType) && $tUrlType == '9') ? "selected" : "" ?>>
                                        <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompURLAPI2CNMember'); ?>
                                    </option>
                                    <option value="10" <?= (!empty($tUrlType) && $tUrlType == '10') ? "selected" : "" ?>>
                                        <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompURLAPI2RDFace'); ?>
                                    </option>
                                    <option value="11" <?= (!empty($tUrlType) && $tUrlType == '11') ? "selected" : "" ?>>
                                        <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompURLAPI2RDFaceRegis'); ?>
                                    </option>
                                    <option value="12" <?= (!empty($tUrlType) && $tUrlType == '12') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2API2ARDoc​'); ?>
                                    </option>
                                    <option value="13" <?= (!empty($tUrlType) && $tUrlType == '13') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2MQMember'); ?>
                                    </option>
                                    <option value="14" <?= (!empty($tUrlType) && $tUrlType == '14') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tCompURLAPI2PSStock'); ?>
                                    </option>
                                    <option value="15" <?= (!empty($tUrlType) && $tUrlType == '15') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'tCompURLAPI2RTStock'); ?>
                                    </option>
                                    <option value="16" <?= (!empty($tUrlType) && $tUrlType == '16') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'MQAI'); ?>
                                    </option>
                                    <option value="17" <?= (!empty($tUrlType) && $tUrlType == '17') ? "selected" : "" ?>>
                                        <?php echo language('company/settingconnection/settingconnection', 'MQ'); ?>
                                    </option>
                                </select>
                                <input type="hidden" id="ocmUrlConnecttype" name="ocmUrlConnecttype" value="<?php echo $tUrlType; ?>">
                            <?php
                            } else {
                            ?>
                                <input type="hidden" id="ohdTypeAddUrlType" name="ohdTypeAddUrlType" value="0">
                                <select class="selectpicker form-control" id="ocmUrlConnecttype" name="ocmUrlConnecttype" onchange="JSxCompSettingConTypeUsed('insert')">
                                    <option value="1">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchUrlType'); ?>
                                    </option>
                                    <option value="2">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAuthorized'); ?>
                                    </option>
                                    <option value="3">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLMQURL'); ?>
                                    </option>
                                    <option value="4">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2PSMaster'); ?>
                                    </option>
                                    <option value="5">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2PSSale'); ?>
                                    </option>
                                    <option value="6">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2RTMaster'); ?>
                                    </option>
                                    <option value="7">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2RTSale'); ?>
                                    </option>
                                    <option value="8">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2FNWallet'); ?>
                                    </option>
                                    <option value="9">
                                        <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompURLAPI2CNMember'); ?>
                                    </option>
                                    <option value="10">
                                        <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompURLAPI2RDFace'); ?>
                                    </option>
                                    <option value="11">
                                        <?php echo language('company/compsettingconnect/compsettingconnect', 'tCompURLAPI2RDFaceRegis'); ?>
                                    </option>
                                    <option value="12">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2API2ARDoc​'); ?>
                                    </option>
                                    <option value="13">
                                        <?php echo language('company/settingconnection/settingconnection', 'tBchURLAPI2MQMember'); ?>
                                    </option>
                                    <option value="14">
                                        <?php echo language('company/settingconnection/settingconnection', 'tCompURLAPI2PSStock'); ?>
                                    </option>
                                    <option value="15">
                                        <?php echo language('company/settingconnection/settingconnection', 'tCompURLAPI2RTStock'); ?>
                                    </option>
                                    <option value="16">
                                        <?php echo language('company/settingconnection/settingconnection', 'MQAI'); ?>
                                    </option>
                                    <option value="17">
                                        <?php echo language('company/settingconnection/settingconnection', 'MQ'); ?>
                                    </option>
                                </select>

                            <?php
                            }
                            ?>
                        </div>

                        <input type="hidden" name="oetCompServeripOld" id="oetCompServeripOld" value="<?php echo $tUrlAddress; ?>">
                        <!-- เซิฟเวอร์ URL/IP -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('company/compsettingconnect/compsettingconnect', 'tCompSettingServerIp') ?></label>
                            <input type="text" id="oetCompServerip" name="oetCompServerip" value="<?php echo $tUrlAddress; ?>" data-validate-required="<?php echo language('company/compsettingconnect/compsettingconnect', 'tValiSettingServerIp') ?>" placeholder="<?php echo language('company/compsettingconnect/compsettingconnect', 'tCompSettingServerIp') ?>">
                            <input type="hidden" name="ohdKeyUrl" id="ohdKeyUrl" value="<?php echo $tUrlAddress; ?>">
                            <input type="hidden" name="ohdurltype" id="ohdurltype" value="<?php echo $tUrlType; ?>">
                        </div>

                        <!-- Port สำหรับการเชื่อมต่อ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/compsettingconnect/compsettingconnect', 'tCompSettingPortConnect') ?></label>
                            <input type="text" id="oetCompPortConnect" name="oetCompPortConnect" value="<?php echo $tUrlPort; ?>" placeholder="<?php echo language('company/compsettingconnect/compsettingconnect', 'tCompSettingPortConnect') ?>">
                        </div>

                        <!-- URL Key -->
                        <div class="form-group">
                            <label class="xCNLabelFrm xWCompUrlKey"><?= language('company/compsettingconnect/compsettingconnect', 'tCompSettingUrlKey') ?></label>
                            <input type="text" maxlength="20" id="oetCompUrlKey" name="oetCompUrlKey" value="<?php echo $tUrlKey; ?>" placeholder="<?php echo language('company/compsettingconnect/compsettingconnect', 'tCompSettingUrlKey') ?>">
                        </div>
                        <!-- </div>    -->


                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!--Tab UserAccount -->
            <div id="odvPanelUserAccount" class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('company/settingconnection/settingconnection', 'tBchUserDetail'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataUserAccount" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>

                <div id="odvDataUserAccount" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">
                        <!-- VirtualHost -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?></label>
                            <input type="text" id="oetCompVulHost" name="oetCompVulHost" value="<?php echo $tUolVhost; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?>">
                        </div>

                        <!-- ผู้เข้าใช้งาน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchUSerAccount') ?></label>
                            <input type="text" id="oetCompUsrAccount" name="oetCompUsrAccount" value="<?php echo $tUolUser; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserAccount') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchUSerAccount') ?>">
                        </div>

                        <!-- รหัสผ่าน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?></label>
                            <input type="password" id="oetCompPassword" name="oetCompPassword" value="<?php echo $tUolPassword; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserPassword') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?>">
                        </div>

                        <!-- ล็อกอินคีย์ -->
                        <div class="form-group xCNHide">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?></label>
                            <input type="text" id="oetComploginKey" name="oetComploginKey" value="<?php echo $tUolKey; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?>">
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingConRemark'); ?></label>
                            <textarea class="form-group" rows="4" maxlength="100" id="oetCompRemark" name="oetCompRemark" autocomplete="off" placeholder="<?php echo language('authen/user/user', 'tUSRLRemark') ?>"><?php echo $tRemark; ?></textarea>
                        </div>

                        <!-- สถานะการใช้งาน -->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="ocbStaUse" <?php
                                                                        if ($tRoute == "CompSettingConEventAdd") {
                                                                            echo "checked";
                                                                        } else {
                                                                            echo ($tUsrStaActive == '1') ? "checked" : '';
                                                                        }
                                                                        ?> value="1">
                                <span> <?php echo language('company/settingconnection/settingconnection', 'tBchActive'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!--Tab MQ ข้อมูลหลัก -->
            <div id="odvPanelMQMain" class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('company/settingconnection/settingconnection', 'tBchMQDetailMain'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDatatCompMQDetailMain" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <input type="hidden" name="oetCompMQMainVulHostOld" id="oetCompMQMainVulHostOld" value="<?php echo $tUolVhost1; ?>">
                <div id="odvDatatCompMQDetailMain" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">
                        <!-- VirtualHost -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?></label>
                            <input type="text" id="oetCompMQMainVulHost" name="oetCompMQMainVulHost" value="<?php echo $tUolVhost1; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?>">
                        </div>
                        <input type="hidden" name="oetCompMQMainUsrAccountOld" id="oetCompMQMainUsrAccountOld" value="<?php echo $tUolUser1; ?>">
                        <!-- ชื่อเข้าใช้งาน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?></label>
                            <input type="text" id="oetCompMQMainUsrAccount" name="oetCompMQMainUsrAccount" value="<?php echo $tUolUser1; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserAccountMQ') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?>">
                        </div>

                        <!-- รหัสผ่าน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?></label>
                            <input type="password" id="oetCompMQMainPassword" name="oetCompMQMainPassword" value="<?php echo $tUolPassword1; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserPasswordMQ') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?>">
                        </div>

                        <!-- ล็อกอินคีย์ -->
                        <div class="form-group xCNHide">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?></label>
                            <input type="text" id="oetCompMQMainKey" name="oetCompMQMainKey" value="<?php echo $tUolKey1; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?>">
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingConRemark'); ?></label>
                            <textarea class="form-group" rows="4" maxlength="100" id="oetCompMQMainRemark" name="oetCompMQMainRemark" autocomplete="off" placeholder="<?php echo language('authen/user/user', 'tUSRLRemark') ?>"><?php echo $tRemark1; ?></textarea>
                        </div>

                        <!-- สถานะการใช้งาน -->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="ocbMQMainStaUse" <?php
                                                                                if ($tRoute == "CompSettingConEventAdd") {
                                                                                    echo "checked";
                                                                                } else {
                                                                                    echo ($tUsrStaActive1 == '1') ? "checked" : '';
                                                                                }
                                                                                ?> value="1">
                                <span> <?php echo language('company/settingconnection/settingconnection', 'tBchActive'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!--Tab MQ เอกสาร -->
            <div id="odvPanelMQDocument" class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('company/settingconnection/settingconnection', 'tBchMQDetailDoc'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDatatCompMQDocument" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>

                <div id="odvDatatCompMQDocument" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">

                        <!-- VirtualHost -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?></label>
                            <input type="text" id="oetCompMQDocVulHost" name="oetCompMQDocVulHost" value="<?php echo $tUolVhost2; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?>">
                        </div>

                        <!-- ชื่อเข้าใช้งาน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?></label>
                            <input type="text" id="oetCompMQDocUsrAccount" name="oetCompMQDocUsrAccount" value="<?php echo $tUolUser2; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserAccountDoc') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?>">
                        </div>

                        <!-- รหัสผ่าน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?></label>
                            <input type="password" id="oetCompMQDocPassword" name="oetCompMQDocPassword" value="<?php echo $tUolPassword2; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserPassworDoc') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?>">
                        </div>

                        <!-- ล็อกอินคีย์ -->
                        <div class="form-group xCNHide">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?></label>
                            <input type="text" id="oetCompMQDocKey" name="oetCompMQDocKey" value="<?php echo $tUolKey2; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?>">
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingConRemark'); ?></label>
                            <textarea class="form-group" rows="4" maxlength="100" id="oetCompMQDocRemark" name="oetCompMQDocRemark" autocomplete="off" placeholder="<?php echo language('authen/user/user', 'tUSRLRemark') ?>"><?php echo $tRemark2; ?></textarea>
                        </div>

                        <!-- สถานะการใช้งาน -->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="ocbMQDocStaUse" <?php
                                                                                if ($tRoute == "CompSettingConEventAdd") {
                                                                                    echo "checked";
                                                                                } else {
                                                                                    echo ($tUsrStaActive2 == '1') ? "checked" : '';
                                                                                }
                                                                                ?> value="1">
                                <span> <?php echo language('company/settingconnection/settingconnection', 'tBchActive'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tab MQ การขาย -->
            <div id="odvPanelMQSale" class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('company/settingconnection/settingconnection', 'tBchMQDetailSale'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDatatCompMQSale" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>

                <div id="odvDatatCompMQSale" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">

                        <!-- VirtualHost -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?></label>
                            <input type="text" id="oetCompMQSaleVulHost" name="oetCompMQSaleVulHost" value="<?php echo $tUolVhost3; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?>">
                        </div>

                        <!-- ชื่อเข้าใช้งาน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?></label>
                            <input type="text" id="oetCompMQSaleUsrAccount" name="oetCompMQSaleUsrAccount" value="<?php echo $tUolUser3; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserAccountSale') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?>">
                        </div>

                        <!-- รหัสผ่าน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?></label>
                            <input type="password" id="oetCompMQSalePassword" name="oetCompMQSalePassword" value="<?php echo $tUolPassword3; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserPassworSale') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?>">
                        </div>

                        <!-- ล็อกอินคีย์ -->
                        <div class="form-group xCNHide">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?></label>
                            <input type="text" id="oetCompMQSaleKey" name="oetCompMQSaleKey" value="<?php echo $tUolKey3; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?>">
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingConRemark'); ?></label>
                            <textarea class="form-group" rows="4" maxlength="100" id="oetCompMQSaleRemark" name="oetCompMQSaleRemark" autocomplete="off" placeholder="<?php echo language('authen/user/user', 'tUSRLRemark') ?>"><?php echo $tRemark3; ?></textarea>
                        </div>

                        <!-- สถานะการใช้งาน -->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="ocbMQSaleStaUse" <?php
                                                                                if ($tRoute == "CompSettingConEventAdd") {
                                                                                    echo "checked";
                                                                                } else {
                                                                                    echo ($tUsrStaActive3 == '1') ? "checked" : '';
                                                                                }
                                                                                ?> value="1">
                                <span> <?php echo language('company/settingconnection/settingconnection', 'tBchActive'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tab MQ รายงาน -->
            <div id="odvPanelReport" class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('company/settingconnection/settingconnection', 'tBchMQDetailWallet'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#tCompMQDetailReport" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>

                <div id="tCompMQDetailReport" class="panel-collapse collapse in" role="tabpanel" style="margin-top:10px;">
                    <div class="panel-body xCNPDModlue">

                        <!-- VirtualHost -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?></label>
                            <input type="text" id="oetCompMQWalletVulHost" name="oetCompMQWalletVulHost" value="<?php echo $tUolVhost4; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingvirtualHost') ?>">
                        </div>

                        <!-- ชื่อเข้าใช้งาน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?></label>
                            <input type="text" id="oetCompMQWalletUsrAccount" name="oetCompMQWalletUsrAccount" value="<?php echo $tUolUser4; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserAccountReport') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingUsrlogin') ?>">
                        </div>

                        <!-- รหัสผ่าน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?></label>
                            <input type="password" id="oetCompMQWalletPassword" name="oetCompMQWalletPassword" value="<?php echo $tUolPassword4; ?>" data-validate-required="<?php echo language('company/settingconnection/settingconnection', 'tValiSettingUserPassworReport') ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingPassword') ?>">
                        </div>

                        <!-- ล็อกอินคีย์ -->
                        <div class="form-group xCNHide">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?></label>
                            <input type="text" id="oetCompMQReportKey" name="oetCompMQReportKey" value="<?php echo $tUolKey4; ?>" placeholder="<?php echo language('company/settingconnection/settingconnection', 'tBchSettingloginKey') ?>">
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/settingconnection/settingconnection', 'tBchSettingConRemark'); ?></label>
                            <textarea class="form-group" rows="4" maxlength="100" id="oetCompMQWalletRemark" name="oetCompMQWalletRemark" autocomplete="off" placeholder="<?php echo language('authen/user/user', 'tUSRLRemark') ?>"><?php echo $tRemark4; ?></textarea>
                        </div>

                        <!-- สถานะการใช้งาน -->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="ocbMQWalletStaUse" <?php
                                                                                if ($tRoute == "CompSettingConEventAdd") {
                                                                                    echo "checked";
                                                                                } else {
                                                                                    echo ($tUsrStaActive4 == '1') ? "checked" : '';
                                                                                }
                                                                                ?> value="1">
                                <span> <?php echo language('company/settingconnection/settingconnection', 'tBchActive'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    $tCompCode  =  $aCompCodeSetAuthen['tCompCode'];
    ?>
    <input type="hidden" id="ohdCompCode" name="ohdCompCode" value="<?php echo $tCompCode; ?>">
    <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0"><!-- 0 คือ ไม่เกิด validate  และ 1 เกิด validate -->

</form>



<?php include "script/jCompSettingConnectMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css') ?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>