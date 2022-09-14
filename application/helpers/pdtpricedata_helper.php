<?php

// Functionality: Function Product Price 4 PDT
// Parameters:  Ajax Send Event Post
// Creator: 26/02/2018 Wasin(Yoshi)
// LastModified: -
// Return: Array Data Price 4 Product
// ReturnType: Array
function FCNaHGetDataPrice4Pdt($paCondition){
    $ci = &get_instance();
    $ci->load->database();
    
    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];

    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];

    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    // $tBchCode       = $paCondition['ptBchCode'];
    // $tShpCode       = $paCondition['ptShpCode'];

    $dPghDStart     = $paCondition['pdPghDStart'];
    
    $tSQL   = " SELECT C.* FROM (
                    SELECT  ROW_NUMBER() OVER(ORDER BY rdPghDStart DESC) AS rtRowID,* FROM(
                        SELECT DISTINCT
                            PRI4PDT.FTPghDocNo              AS rtPghDocNo,
                            PRI4PDT.FTPghDocType            AS rtPghDocType,
                            PRI4PDT.FTPdtCode               AS rtPdtCode,
                            PDTL.FTPdtName                  AS rtPdtName,
                            PRI4PDT.FTPunCode               AS rtPunCode,
                            PUNL.FTPunName                  AS rtPunName,
                            PPSZ.FCPdtUnitFact              AS rtUnitFact,
                            -- PDT.FTBchCode                   AS rtBchCode,
                            -- BCHL.FTBchName                  AS rtBchName,
                            -- PDT.FTPdtRefShop                AS rtShpCode,
                            -- SHPL.FTShpName                  AS rtShpName,
                            PRI4PDT.FDPghDStart             AS rdPghDStart,
                            PRI4PDT.FTPghTStart             AS rdPghTStart,
                            PRI4PDT.FDPghDStop              AS rdPghDStop,
                            PRI4PDT.FTPghTStop              AS rdPghTStop,
                            ISNULL(PRI4PDT.FCPgdPriceRet,0) AS rcPgdPriceRet,
                            ISNULL(PRI4PDT.FCPgdPriceWhs,0)	AS rcPgdPriceWhs,
                            ISNULL(PRI4PDT.FCPgdPriceNet,0)	AS rcPgdPriceNet
                        FROM TCNTPdtPrice4PDT PRI4PDT
                        LEFT JOIN TCNMPdt           PDT     ON PRI4PDT.FTPdtCode    = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4PDT.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4PDT.FTPunCode = PPSZ.FTPunCode
                        LEFT JOIN TCNMPdt_L         PDTL    ON PRI4PDT.FTPdtCode    = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLangID
                        LEFT JOIN TCNMPdtUnit_L		PUNL    ON PRI4PDT.FTPunCode    = PUNL.FTPunCode	AND PUNL.FNLngID	= $nLangID
                        -- LEFT JOIN TCNMBranch_L		BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode	AND BCHL.FNLngID	= $nLangID
                        -- LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop		= SHPL.FTShpCode	AND SHPL.FNLngID	= $nLangID
                        WHERE 1 = 1 ";

    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL .= " AND PRI4PDT.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL .= " AND PRI4PDT.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL .= " AND PRI4PDT.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Bch Code
    // if(isset($tBchCode) && !empty($tBchCode)){
    //     $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    // }

    // Condition Check Shp Code
    // if(isset($tShpCode) && !empty($tShpCode)){
    //     $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    // }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4PDT.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4PDT.FDPghDStop,121)))";
    }
    
    $tSQL   .= ") BASE) AS C WHERE C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]";
    $tSQL   .= " ORDER BY C.rdPghDStart DESC ";
    $oQuery =   $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDataQuery = $oQuery->result_array();
        $aFoundRow      = FCNaHGetDataPrice4PdtAll($paCondition);
        $nFoundRow      = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
        // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
        $nPageAll       = ceil($nFoundRow/$nRow);
        $aDataReturn    = array(
            'raItems'       => $aDataQuery,
            'rnAllRow'      => $nFoundRow,
            'rnCurrentPage' => $nPage,
            'rnAllPage'     => $nPageAll,
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rnAllRow'      => 0,
            'rnCurrentPage' => 1,
            "rnAllPage"     => 1,
            'rtCode'        => '800',
            'rtDesc'        => 'data not found'
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 PDT Count All Data
// Parameters:  Ajax Send Event Post
// Creator: 26/02/2018 Wasin(Yoshi)
// LastModified: -
// Return: Data Count All Pricr 4 Product
// ReturnType: Array
function FCNaHGetDataPrice4PdtAll($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    // $tBchCode       = $paCondition['ptBchCode'];
    // $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];

    $tSQL           = " SELECT TOP 1
                            COUNT (PRI4PDT.FTPdtCode) AS counts
                        FROM TCNTPdtPrice4PDT PRI4PDT
                        LEFT JOIN TCNMPdt           PDT     ON PRI4PDT.FTPdtCode    = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4PDT.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4PDT.FTPunCode = PPSZ.FTPunCode
                        LEFT JOIN TCNMPdt_L         PDTL    ON PRI4PDT.FTPdtCode    = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLangID
                        LEFT JOIN TCNMPdtUnit_L		PUNL    ON PRI4PDT.FTPunCode    = PUNL.FTPunCode	AND PUNL.FNLngID	= $nLangID
                        -- LEFT JOIN TCNMBranch_L		BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode	AND BCHL.FNLngID	= $nLangID
                        -- LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop		= SHPL.FTShpCode	AND SHPL.FNLngID	= $nLangID
                        WHERE 1 = 1 ";

    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL .= " AND PRI4PDT.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL .= " AND PRI4PDT.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL .= " AND PRI4PDT.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Bch Code
    // if(isset($tBchCode) && !empty($tBchCode)){
    //     $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    // }

    // Condition Check Shp Code
    // if(isset($tShpCode) && !empty($tShpCode)){
    //     $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    // }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4PDT.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4PDT.FDPghDStop,121)))";
    }
    
    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDetail = $oQuery->row_array();
        $aDataReturn    =  array(
            'rtCountData'   => $aDetail['counts'],
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rtCode'        => '800',
            'rtDesc'        => 'Data Not Found',
        );
    }
    return $aDataReturn;
}


// Functionality: Function Product Price 4 CST
// Parameters:  Ajax Send Event Post
// Creator: 26/02/2018 Wasin(Yoshi)
// LastModified: -
// Return: Array Data Price 4 Customer
// ReturnType: Array
function FCNaHGetDataPrice4CST($paCondition){
    $ci = &get_instance();
    $ci->load->database();
    
    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tCstGrpCode    = $paCondition['pCstGrpCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];

    $tSQL   = " SELECT C.* FROM (
                    SELECT  ROW_NUMBER() OVER(ORDER BY rdPghDStart DESC) AS rtRowID,* FROM(
                        SELECT DISTINCT
                            PRI4CST.FTPghDocNo              AS rtPghDocNo,
                            PRI4CST.FTPghDocType            AS rtPghDocType,
                            PRI4CST.FTPdtCode               AS rtPdtCode,
                            PDTL.FTPdtName                  AS rtPdtName,
                            PRI4CST.FTPunCode               AS rtPunCode,
                            PUNL.FTPunName                  AS rtPunName,
                            PPSZ.FCPdtUnitFact              AS rtUnitFact,
                            PDT.FTBchCode                   AS rtBchCode,
                            BCHL.FTBchName                  AS rtBchName,
                            PDT.FTPdtRefShop                AS rtShpCode,
                            SHPL.FTShpName                  AS rtShpName,
                            PRI4CST.FTPplCode               AS rtCstGrpCode,
                            CSGL.FTCgpName                  AS rtCstGrpName,
                            PRI4CST.FDPghDStart             AS rdPghDStart,
                            PRI4CST.FTPghTStart             AS rdPghTStart,
                            PRI4CST.FDPghDStop              AS rdPghDStop,
                            PRI4CST.FTPghTStop              AS rdPghTStop,
                            ISNULL(PRI4CST.FCPgdPriceRet,0) AS rcPgdPriceRet,
                            ISNULL(PRI4CST.FCPgdPriceWhs,0)	AS rcPgdPriceWhs,
                            ISNULL(PRI4CST.FCPgdPriceNet,0)	AS rcPgdPriceNet
                        FROM TCNTPdtPrice4CST PRI4CST
                        LEFT JOIN TCNMPdt           PDT     ON PRI4CST.FTPdtCode    = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4CST.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4CST.FTPunCode = PPSZ.FTPunCode
                        LEFT JOIN TCNMPdt_L         PDTL    ON PRI4CST.FTPdtCode    = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLangID
                        LEFT JOIN TCNMCstGrp_L      CSGL    ON PRI4CST.FTPplCode    = CSGL.FTCgpCode    AND CSGL.FNLngID    = $nLangID
                        LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4CST.FTPunCode    = PUNL.FTPunCode	AND PUNL.FNLngID	= $nLangID
                        LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode	AND BCHL.FNLngID	= $nLangID
                        LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop		= SHPL.FTShpCode	AND SHPL.FNLngID	= $nLangID
                        WHERE 1 = 1 ";

    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL .= " AND PRI4CST.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL .= " AND PRI4CST.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL .= " AND PRI4CST.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Unit Code
    if(isset($tCstGrpCode) && !empty($tCstGrpCode)){
        $tSQL .= " AND PRI4CST.FTPplCode = '$tCstGrpCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4CST.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4CST.FDPghDStop,121)))";
    }

    $tSQL   .= ") BASE) AS C WHERE C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]";
    $tSQL   .= " ORDER BY C.rdPghDStart DESC ";
    $oQuery =   $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDataQuery     = $oQuery->result_array();
        $aFoundRow      = FCNaHGetDataPrice4CSTAll($paCondition);
        $nFoundRow      = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
        // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
        $nPageAll       = ceil($nFoundRow/$nRow);
        $aDataReturn    = array(
            'raItems'       => $aDataQuery,
            'rnAllRow'      => $nFoundRow,
            'rnCurrentPage' => $nPage,
            'rnAllPage'     => $nPageAll,
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rnAllRow'      => 0,
            'rnCurrentPage' => 1,
            "rnAllPage"     => 1,
            'rtCode'        => '800',
            'rtDesc'        => 'data not found'
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 CST Count All Data
// Parameters:  Ajax Send Event Post
// Creator: 26/02/2018 Wasin(Yoshi)
// LastModified: -
// Return: Data Count All Pricr 4 Product
// ReturnType: Array
function FCNaHGetDataPrice4CSTAll($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];
    $tCstGrpCode    = $paCondition['pCstGrpCode'];

    $tSQL           = " SELECT TOP 1
                            COUNT (PRI4CST.FTPdtCode) AS counts
                        FROM TCNTPdtPrice4CST PRI4CST
                        LEFT JOIN TCNMPdt           PDT     ON PRI4CST.FTPdtCode    = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4CST.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4CST.FTPunCode = PPSZ.FTPunCode
                        LEFT JOIN TCNMPdt_L         PDTL    ON PRI4CST.FTPdtCode    = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLangID
                        LEFT JOIN TCNMCstGrp_L      CSGL    ON PRI4CST.FTPplCode    = CSGL.FTCgpCode    AND CSGL.FNLngID    = $nLangID
                        LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4CST.FTPunCode    = PUNL.FTPunCode	AND PUNL.FNLngID	= $nLangID
                        LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode	AND BCHL.FNLngID	= $nLangID
                        LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop		= SHPL.FTShpCode	AND SHPL.FNLngID	= $nLangID
                        WHERE 1 = 1 ";

    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL .= " AND PRI4CST.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL .= " AND PRI4CST.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL .= " AND PRI4CST.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Customer Group
    if(isset($tCstGrpCode) && !empty($tCstGrpCode)){
        $tSQL .= " AND PRI4CST.FTPplCode = '$tCstGrpCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4CST.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4CST.FDPghDStop,121)))";
    }

    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDetail = $oQuery->row_array();
        $aDataReturn    =  array(
            'rtCountData'   => $aDetail['counts'],
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rtCode'        => '800',
            'rtDesc'        => 'Data Not Found',
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 ZNE
// Parameters:  Ajax Send Event Post
// Creator: 06/03/2018 Wasin(Yoshi)
// LastModified: -
// Return: Array Data Price 4 Zone
// ReturnType: Array
function FCNaHGetDataPrice4ZNE($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];
    $tZneCode       = $paCondition['ptZneChain'];

    $tSQL           = " SELECT C.* FROM (
                            SELECT  ROW_NUMBER() OVER(ORDER BY rdPghDStart DESC) AS rtRowID,* FROM(
                                SELECT DISTINCT
                                    PRI4ZNE.FTPghDocNo              AS rtPghDocNo,
                                    PRI4ZNE.FTPghDocType            AS rtPghDocType,
                                    PRI4ZNE.FTPdtCode               AS rtPdtCode,
                                    PDTL.FTPdtName                  AS rtPdtName,
                                    PRI4ZNE.FTPunCode               AS rtPunCode,
                                    PUNL.FTPunName                  AS rtPunName,
                                    PPSZ.FCPdtUnitFact              AS rtUnitFact,
                                    PRI4ZNE.FTPghZneTo              AS rtZneCode,
                                    ZNEL.FTZneChainName             AS rtZneChainName,
                                    PDT.FTBchCode                   AS rtBchCode,
                                    BCHL.FTBchName                  AS rtBchName,
                                    PDT.FTPdtRefShop                AS rtShpCode,
                                    SHPL.FTShpName                  AS rtShpName,
                                    PRI4ZNE.FDPghDStart             AS rdPghDStart,
                                    PRI4ZNE.FTPghTStart             AS rdPghTStart,
                                    PRI4ZNE.FDPghDStop              AS rdPghDStop,
                                    PRI4ZNE.FTPghTStop              AS rdPghTStop,
                                    ISNULL(PRI4ZNE.FCPgdPriceRet,0) AS rcPgdPriceRet,
                                    ISNULL(PRI4ZNE.FCPgdPriceWhs,0)	AS rcPgdPriceWhs,
                                    ISNULL(PRI4ZNE.FCPgdPriceNet,0)	AS rcPgdPriceNet
                                FROM TCNTPdtPrice4ZNE PRI4ZNE
                                LEFT JOIN TCNMPdt           PDT     ON PRI4ZNE.FTPdtCode    = PDT.FTPdtCode
                                LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4ZNE.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4ZNE.FTPunCode = PPSZ.FTPunCode
                                LEFT JOIN TCNMPdt_L         PDTL    ON PRI4ZNE.FTPdtCode 	= PDTL.FTPdtCode	AND PDTL.FNLngID = $nLangID
                                LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4ZNE.FTPunCode 	= PUNL.FTPunCode	AND PUNL.FNLngID = $nLangID
                                LEFT JOIN TCNMZone_L        ZNEL    ON PRI4ZNE.FTPghZneTo   = ZNEL.FTZneChain   AND ZNEL.FNLngID = $nLangID
                                LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode    AND BCHL.FNLngID = $nLangID
                                LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop     = SHPL.FTShpCode    AND SHPL.FNLngID = $nLangID
                                WHERE 1 = 1 ";
    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL   .= " AND PRI4ZNE.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL   .= " AND PRI4ZNE.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL   .= " AND PRI4ZNE.FTPunCode = '$tPunCode' ";
    }
    
    // Condition Check Zone Code
    if(isset($tZneCode) && !empty($tZneCode)){
        $tSQL   .= " AND PRI4ZNE.FTPghZneTo = '$tZneCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4ZNE.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4ZNE.FDPghDStop,121)))";
    }

    $tSQL   .= ") BASE) AS C WHERE C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]";
    $tSQL   .= " ORDER BY C.rdPghDStart DESC ";
    $oQuery =   $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDataQuery = $oQuery->result_array();
        $aFoundRow  = FCNaHGetDataPrice4ZNEAll($paCondition);
        $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
        // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
        $nPageAll       = ceil($nFoundRow/$nRow);
        $aDataReturn    = array(
            'raItems'       => $aDataQuery,
            'rnAllRow'      => $nFoundRow,
            'rnCurrentPage' => $nPage,
            'rnAllPage'     => $nPageAll,
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rnAllRow'      => 0,
            'rnCurrentPage' => 1,
            "rnAllPage"     => 1,
            'rtCode'        => '800',
            'rtDesc'        => 'data not found'
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 ZNE Count All Data
// Parameters:  Ajax Send Event Post
// Creator: 06/03/2018 Wasin(Yoshi)
// LastModified: -
// Return: Data Count All Pricr 4 Zone
// ReturnType: Array
function FCNaHGetDataPrice4ZNEAll($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];
    $tZneCode       = $paCondition['ptZneChain'];

    $tSQL           = " SELECT TOP 1
                            COUNT (PRI4ZNE.FTPdtCode) AS counts
                        FROM TCNTPdtPrice4ZNE PRI4ZNE
                        LEFT JOIN TCNMPdt           PDT     ON PRI4ZNE.FTPdtCode    = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4ZNE.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4ZNE.FTPunCode = PPSZ.FTPunCode
                        LEFT JOIN TCNMPdt_L         PDTL    ON PRI4ZNE.FTPdtCode 	= PDTL.FTPdtCode	AND PDTL.FNLngID = $nLangID
                        LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4ZNE.FTPunCode 	= PUNL.FTPunCode	AND PUNL.FNLngID = $nLangID
                        LEFT JOIN TCNMZone_L        ZNEL    ON PRI4ZNE.FTPghZneTo   = ZNEL.FTZneChain   AND ZNEL.FNLngID = $nLangID
                        LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode    AND BCHL.FNLngID = $nLangID
                        LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop     = SHPL.FTShpCode    AND SHPL.FNLngID = $nLangID
                        WHERE 1 = 1 ";
     // Condition Check Product Code
     if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL   .= " AND PRI4ZNE.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL   .= " AND PRI4ZNE.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL   .= " AND PRI4ZNE.FTPunCode = '$tPunCode' ";
    }
    
    // Condition Check Zone Code
    if(isset($tZneCode) && !empty($tZneCode)){
        $tSQL   .= " AND PRI4ZNE.FTPghZneTo = '$tZneCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4ZNE.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4ZNE.FDPghDStop,121)))";
    }

    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDetail = $oQuery->row_array();
        $aDataReturn    =  array(
            'rtCountData'   => $aDetail['counts'],
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rtCode'        => '800',
            'rtDesc'        => 'Data Not Found',
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 BCH
// Parameters:  Ajax Send Event Post
// Creator: 06/03/2018 Wasin(Yoshi)
// LastModified: -
// Return: Array Data Price 4 BCH
// ReturnType: Array
function FCNaHGetDataPrice4BCH($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];
    $tPghBchTo      = $paCondition['ptPghBchTo'];

    $tSQL           = " SELECT C.* FROM (
                            SELECT  ROW_NUMBER() OVER(ORDER BY rdPghDStart DESC) AS rtRowID,* FROM(
                                SELECT DISTINCT
                                    PRI4BCH.FTPghDocNo              AS rtPghDocNo,
                                    PRI4BCH.FTPghDocType            AS rtPghDocType,
                                    PRI4BCH.FTPdtCode               AS rtPdtCode,
                                    PDTL.FTPdtName                  AS rtPdtName,
                                    PRI4BCH.FTPunCode               AS rtPunCode,
                                    PUNL.FTPunName                  AS rtPunName,
                                    PPSZ.FCPdtUnitFact              AS rtUnitFact,
                                    PRI4BCH.FTPghBchTo              AS rtPriceBchCode,
                                    PBCH.FTBchName                  AS rtPriceBchName,
                                    PDT.FTBchCode                   AS rtBchCode,
                                    BCHL.FTBchName                  AS rtBchName,
                                    PDT.FTPdtRefShop                AS rtShpCode,
                                    SHPL.FTShpName                  AS rtShpName,
                                    PRI4BCH.FDPghDStart             AS rdPghDStart,
                                    PRI4BCH.FTPghTStart             AS rdPghTStart,
                                    PRI4BCH.FDPghDStop              AS rdPghDStop,
                                    PRI4BCH.FTPghTStop              AS rdPghTStop,
                                    ISNULL(PRI4BCH.FCPgdPriceRet,0) AS rcPgdPriceRet,
                                    ISNULL(PRI4BCH.FCPgdPriceWhs,0)	AS rcPgdPriceWhs,
                                    ISNULL(PRI4BCH.FCPgdPriceNet,0)	AS rcPgdPriceNet
                                FROM TCNTPdtPrice4BCH PRI4BCH
                                LEFT JOIN TCNMPdt           PDT     ON PRI4BCH.FTPdtCode    = PDT.FTPdtCode
                                LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4BCH.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4BCH.FTPunCode = PPSZ.FTPunCode
                                LEFT JOIN TCNMPdt_L         PDTL    ON PRI4BCH.FTPdtCode 	= PDTL.FTPdtCode	AND PDTL.FNLngID = $nLangID
                                LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4BCH.FTPunCode 	= PUNL.FTPunCode	AND PUNL.FNLngID = $nLangID
                                LEFT JOIN TCNMBranch_L      PBCH    ON PRI4BCH.FTPghBchTo   = PBCH.FTBchCode    AND PBCH.FNLngID = $nLangID
                                LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode    AND BCHL.FNLngID = $nLangID
                                LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop     = SHPL.FTShpCode    AND SHPL.FNLngID = $nLangID
                                WHERE 1=1 ";
    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL   .= " AND PRI4BCH.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL   .= " AND PRI4BCH.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Brach To
    if(isset($tPghBchTo) && !empty($tPghBchTo)){
        $tSQL   .= " AND PRI4BCH.FTPghBchTo = '$tPghBchTo' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL   .= " AND PRI4BCH.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4BCH.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4BCH.FDPghDStop,121)))";
    }

    $tSQL   .= ") BASE) AS C WHERE C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]";
    $tSQL   .= " ORDER BY C.rdPghDStart DESC ";
    
    $oQuery =   $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDataQuery = $oQuery->result_array();
        $aFoundRow  = FCNaHGetDataPrice4BCHAll($paCondition);
        $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
        // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
        $nPageAll       = ceil($nFoundRow/$nRow);
        $aDataReturn    = array(
            'raItems'       => $aDataQuery,
            'rnAllRow'      => $nFoundRow,
            'rnCurrentPage' => $nPage,
            'rnAllPage'     => $nPageAll,
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rnAllRow'      => 0,
            'rnCurrentPage' => 1,
            "rnAllPage"     => 1,
            'rtCode'        => '800',
            'rtDesc'        => 'data not found'
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 BCH Count All Data
// Parameters:  Ajax Send Event Post
// Creator: 06/03/2018 Wasin(Yoshi)
// LastModified: -
// Return: Data Count All Pricr 4 Branch
// ReturnType: Array
function FCNaHGetDataPrice4BCHAll($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];
    $tPghBchTo      = $paCondition['ptPghBchTo'];

    $tSQL           = " SELECT TOP 1
                            COUNT (PRI4BCH.FTPdtCode) AS counts
                        FROM TCNTPdtPrice4BCH PRI4BCH
                        LEFT JOIN TCNMPdt           PDT     ON PRI4BCH.FTPdtCode    = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4BCH.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4BCH.FTPunCode = PPSZ.FTPunCode
                        LEFT JOIN TCNMPdt_L         PDTL    ON PRI4BCH.FTPdtCode 	= PDTL.FTPdtCode	AND PDTL.FNLngID = $nLangID
                        LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4BCH.FTPunCode 	= PUNL.FTPunCode	AND PUNL.FNLngID = $nLangID
                        LEFT JOIN TCNMBranch_L      PBCH    ON PRI4BCH.FTPghBchTo   = PBCH.FTBchCode    AND PBCH.FNLngID = $nLangID
                        LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode    AND BCHL.FNLngID = $nLangID
                        LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop     = SHPL.FTShpCode    AND SHPL.FNLngID = $nLangID
                        WHERE 1=1 ";
     // Condition Check Product Code
     if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL   .= " AND PRI4BCH.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL   .= " AND PRI4BCH.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Brach To
    if(isset($tPghBchTo) && !empty($tPghBchTo)){
        $tSQL   .= " AND PRI4BCH.FTPghBchTo = '$tPghBchTo' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL   .= " AND PRI4BCH.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4BCH.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4BCH.FDPghDStop,121)))";
    }

    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDetail = $oQuery->row_array();
        $aDataReturn    =  array(
            'rtCountData'   => $aDetail['counts'],
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rtCode'        => '800',
            'rtDesc'        => 'Data Not Found',
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 AGG
// Parameters:  Ajax Send Event Post
// Creator: 06/03/2018 Wasin(Yoshi)
// LastModified: -
// Return: Array Data Price 4 AGG
// ReturnType: Array
function FCNaHGetDataPrice4AGG($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];
    $tAggCode       = $paCondition['ptAggCode'];

    $tSQL           = " SELECT C.* FROM (
                            SELECT  ROW_NUMBER() OVER(ORDER BY rdPghDStart DESC) AS rtRowID,* FROM(
                                SELECT DISTINCT
                                    PRI4AGG.FTPghDocNo              AS rtPghDocNo,
                                    PRI4AGG.FTPghDocType            AS rtPghDocType,
                                    PRI4AGG.FTPdtCode               AS rtPdtCode,
                                    PDTL.FTPdtName                  AS rtPdtName,
                                    PRI4AGG.FTPunCode               AS rtPunCode,
                                    PUNL.FTPunName                  AS rtPunName,
                                    PPSZ.FCPdtUnitFact              AS rtUnitFact,
                                    PRI4AGG.FTAggCode               AS rtAggCode,
                                    AGGL.FTAgnName                  AS rtAggName,
                                    PDT.FTBchCode                   AS rtBchCode,
                                    BCHL.FTBchName                  AS rtBchName,
                                    PDT.FTPdtRefShop                AS rtShpCode,
                                    SHPL.FTShpName                  AS rtShpName,
                                    PRI4AGG.FDPghDStart             AS rdPghDStart,
                                    PRI4AGG.FTPghTStart             AS rdPghTStart,
                                    PRI4AGG.FDPghDStop              AS rdPghDStop,
                                    PRI4AGG.FTPghTStop              AS rdPghTStop,
                                    ISNULL(PRI4AGG.FCPgdPriceRet,0) AS rcPgdPriceRet,
                                    ISNULL(PRI4AGG.FCPgdPriceWhs,0)	AS rcPgdPriceWhs,
                                    ISNULL(PRI4AGG.FCPgdPriceNet,0)	AS rcPgdPriceNet
                                FROM TCNTPdtPrice4AGG PRI4AGG
                                LEFT JOIN TCNMPdt           PDT     ON PRI4AGG.FTPdtCode    = PDT.FTPdtCode
                                LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4AGG.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4AGG.FTPunCode = PPSZ.FTPunCode
                                LEFT JOIN TCNMPdt_L         PDTL    ON PRI4AGG.FTPdtCode 	= PDTL.FTPdtCode	AND PDTL.FNLngID    = $nLangID
                                LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4AGG.FTPunCode 	= PUNL.FTPunCode	AND PUNL.FNLngID    = $nLangID
                                LEFT JOIN TCNMAgency_L      AGGL    ON PRI4AGG.FTAggCode    = AGGL.FTAgnCode    AND AGGL.FNLngID    = $nLangID
                                LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLangID
                                LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop     = SHPL.FTShpCode    AND SHPL.FNLngID    = $nLangID
                                WHERE 1=1 ";

    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL   .= " AND PRI4AGG.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL   .= " AND PRI4AGG.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Agency
    if(isset($tAggCode) && !empty($tAggCode)){
        $tSQL   .= " AND PRI4AGG.FTAggCode = '$tAggCode' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL   .= " AND PRI4AGG.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4AGG.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4AGG.FDPghDStop,121)))";
    }

    $tSQL   .= ") BASE) AS C WHERE C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]";
    $tSQL   .= " ORDER BY C.rdPghDStart DESC ";
    
    $oQuery =   $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDataQuery = $oQuery->result_array();
        $aFoundRow  = FCNaHGetDataPrice4AGGAll($paCondition);
        $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
        // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
        $nPageAll       = ceil($nFoundRow/$nRow);
        $aDataReturn    = array(
            'raItems'       => $aDataQuery,
            'rnAllRow'      => $nFoundRow,
            'rnCurrentPage' => $nPage,
            'rnAllPage'     => $nPageAll,
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rnAllRow'      => 0,
            'rnCurrentPage' => 1,
            "rnAllPage"     => 1,
            'rtCode'        => '800',
            'rtDesc'        => 'data not found'
        );
    }
    return $aDataReturn;
}

// Functionality: Function Product Price 4 AGG Count All Data
// Parameters:  Ajax Send Event Post
// Creator: 06/03/2018 Wasin(Yoshi)
// LastModified: -
// Return: Data Count All Pricr 4 Agency
// ReturnType: Array
function FCNaHGetDataPrice4AGGAll($paCondition){
    $ci = &get_instance();
    $ci->load->database();

    // Lang Data
    $nPage          = $paCondition['pnPage'];
    $nRow           = $paCondition['pnRow'];
    $nLangID        = $paCondition['pnLngID'];
    $aRowLen        = FCNaHCallLenData($nRow,$nPage);

    // Data Where Condition
    $tPdtCode       = $paCondition['ptPdtCode'];
    $tPghDocType    = $paCondition['ptPghDocType'];
    $tPunCode       = $paCondition['ptPunCode'];
    $tBchCode       = $paCondition['ptBchCode'];
    $tShpCode       = $paCondition['ptShpCode'];
    $dPghDStart     = $paCondition['pdPghDStart'];
    $tAggCode       = $paCondition['ptAggCode'];

    $tSQL           = " SELECT TOP 1
                            COUNT (PRI4AGG.FTPdtCode) AS counts
                        FROM TCNTPdtPrice4AGG PRI4AGG
                        LEFT JOIN TCNMPdt           PDT     ON PRI4AGG.FTPdtCode    = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtPackSize   PPSZ    ON PRI4AGG.FTPdtCode    = PPSZ.FTPdtCode    AND PRI4AGG.FTPunCode = PPSZ.FTPunCode
                        LEFT JOIN TCNMPdt_L         PDTL    ON PRI4AGG.FTPdtCode 	= PDTL.FTPdtCode	AND PDTL.FNLngID    = $nLangID
                        LEFT JOIN TCNMPdtUnit_L     PUNL    ON PRI4AGG.FTPunCode 	= PUNL.FTPunCode	AND PUNL.FNLngID    = $nLangID
                        LEFT JOIN TCNMAgency_L      AGGL    ON PRI4AGG.FTAggCode    = AGGL.FTAgnCode    AND AGGL.FNLngID    = $nLangID
                        LEFT JOIN TCNMBranch_L      BCHL    ON PDT.FTBchCode        = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLangID
                        LEFT JOIN TCNMShop_L        SHPL    ON PDT.FTPdtRefShop     = SHPL.FTShpCode    AND SHPL.FNLngID    = $nLangID
                        WHERE 1 = 1 ";

    // Condition Check Product Code
    if(isset($tPdtCode) && !empty($tPdtCode)){
        $tSQL   .= " AND PRI4AGG.FTPdtCode = '$tPdtCode' ";
    }

    // Condition Check DocType
    if(isset($tPghDocType) && !empty($tPghDocType)){
        $tSQL   .= " AND PRI4AGG.FTPghDocType = '$tPghDocType' ";
    }

    // Condition Check Agency
    if(isset($tAggCode) && !empty($tAggCode)){
        $tSQL   .= " AND PRI4AGG.FTAggCode = '$tAggCode' ";
    }

    // Condition Check Unit Code
    if(isset($tPunCode) && !empty($tPunCode)){
        $tSQL   .= " AND PRI4AGG.FTPunCode = '$tPunCode' ";
    }

    // Condition Check Bch Code
    if(isset($tBchCode) && !empty($tBchCode)){
        $tSQL .= " AND PDT.FTBchCode = '$tBchCode' ";
    }

    // Condition Check Shp Code
    if(isset($tShpCode) && !empty($tShpCode)){
        $tSQL .= " AND PDT.FTPdtRefShop = '$tShpCode' ";
    }

    // Condition Check Date Start Active
    if(isset($dPghDStart) && !empty($dPghDStart)){
        $tSQL .= " AND ((CONVERT(VARCHAR(10),'$dPghDStart',121) >= CONVERT(VARCHAR(10),PRI4AGG.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),'$dPghDStart',121) <= CONVERT(VARCHAR(10),PRI4AGG.FDPghDStop,121)))";
    }

    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDetail = $oQuery->row_array();
        $aDataReturn    =  array(
            'rtCountData'   => $aDetail['counts'],
            'rtCode'        => '1',
            'rtDesc'        => 'success',
        );
    }else{
        $aDataReturn    =  array(
            'rtCode'        => '800',
            'rtDesc'        => 'Data Not Found',
        );
    }
    return $aDataReturn;
}