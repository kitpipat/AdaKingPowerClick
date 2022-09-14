<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mUser extends CI_Model {

    //Functionality : Search User By ID
    //Parameters : function parameters
    //Creator : 01/06/2018 Wasin
    //Last Modified : 07/05/2020 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMUSRSearchByID ($ptAPIReq,$ptMethodReq,$paData){
        $tUsrCode   = $paData['FTUsrCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = " SELECT
                            IMGP.FTImgObj       AS rtUsrImage,
                            USR.FTUsrCode       AS rtUsrCode,
                            USR.FTUsrTel        AS rtUsrTel,
                            USR.FTUsrEmail      AS rtUsrEmail,
                            -- USR.FTUsrPwd        AS rtUsrPwd,
                            USRL.FTUsrName      AS rtUsrName,
                            USRL.FTUsrRmk       AS rtUsrRmk,
                            UDPT.FTDptCode      AS rtDptCode,
                            UDPT.FTDptName      AS rtDptName,
                            USRG.FTMerCode		AS FTMerCode,
                            MERL.FTMerName		AS FTMerName,
                            BCHL.FTBchCode      AS FTBchCode,
                            BCHL.FTBchName      AS FTBchName,
                            SHPL.FTShpCode      AS FTShpCode,
                            SHPL.FTShpName      AS FTShpName
                        FROM [TCNMUser] USR WITH(NOLOCK)
                        LEFT JOIN [TCNMUser_L] USRL WITH(NOLOCK) ON USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                        LEFT JOIN [TCNMUsrDepart_L] UDPT WITH(NOLOCK) ON USR.FTDptCode = UDPT.FTDptCode AND UDPT.FNLngID = $nLngID
                        -- LEFT JOIN [TCNMUsrRole_L] UROL WITH(NOLOCK) ON USR.FTRolCode = UROL.FTRolCode AND UROL.FNLngID = $nLngID
                        LEFT JOIN [TCNTUsrGroup] USRG WITH(NOLOCK) ON USR.FTUsrCode   = USRG.FTUsrCode
                        LEFT JOIN [TCNMMerchant_L] MERL WITH(NOLOCK) ON USRG.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                        LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON USRG.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON USRG.FTShpCode = SHPL.FTShpCode AND USRG.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON USR.FTUsrCode = IMGP.FTImgRefID AND IMGP.FTImgTable = 'TCNMUser' AND IMGP.FNImgSeq = $nLngID
                        WHERE 1=1 AND USR.FTUsrCode = '$tUsrCode'
                    ";
        // $tSQL       = " SELECT
        //                     IMGP.FTImgObj       AS rtUsrImage,
        //                     USR.FTUsrCode       AS rtUsrCode,
        //                     USR.FTUsrTel        AS rtUsrTel,
        //                     USR.FTUsrEmail      AS rtUsrEmail,
        //                     USR.FTUsrPwd        AS rtUsrPwd,
        //                     USRL.FTUsrName      AS rtUsrName,
        //                     USRL.FTUsrRmk       AS rtUsrRmk,
        //                     UDPT.FTDptCode      AS rtDptCode,
        //                     UDPT.FTDptName      AS rtDptName,
        //                     BCHL.FTBchCode      AS rtBchCode,
        //                     BCHL.FTBchName      AS rtBchName,
        //                     SHPL.FTShpCode      AS rtShpCode,
        //                     SHPL.FTShpName      AS rtShpName,
        //                     USRG.FDUsrStart     AS rtUsrStartDate,
        //                     USRG.FDUsrStop      AS rtUsrEndDate
        //                 FROM [TCNMUser] USR WITH(NOLOCK)
        //                 LEFT JOIN [TCNMUser_L] USRL WITH(NOLOCK) ON USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
        //                 LEFT JOIN [TCNMUsrDepart_L] UDPT WITH(NOLOCK) ON USR.FTDptCode = UDPT.FTDptCode AND UDPT.FNLngID = $nLngID
        //                 LEFT JOIN [TCNMUsrRole_L] UROL WITH(NOLOCK) ON USR.FTRolCode = UROL.FTRolCode AND UROL.FNLngID = $nLngID
        //                 LEFT JOIN [TCNTUsrGroup] USRG WITH(NOLOCK) ON USR.FTUsrCode = USRG.FTUsrCode
        //                 LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON USRG.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
        //                 LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON USRG.FTShpCode = SHPL.FTShpCode AND USRG.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
        //                 LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON USR.FTUsrCode = IMGP.FTImgRefID AND IMGP.FTImgTable = 'TCNMUser' AND IMGP.FNImgSeq = 1
        //                 WHERE 1=1  AND USR.FTUsrCode = '$tUsrCode'
        // ";
    
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Search TCNTUsrBch
    //Parameters : function parameters
    //Creator : 23/04/2018 Witsarut
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMUsrBchByID($ptAPIReq,$ptMethodReq,$paData){

        $tUsrCode   = $paData['FTUsrCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "   SELECT  DISTINCT
                        USRBCH.FTUsrCode,
                        USRBCH.FTMerCode,
                        MERL.FTMerName,
                        USRBCH.FTBchCode,
                        BCHL.FTBchName,
                        ISNULL(USRBCH.FTShpCode,'')		AS FTShpCode,
                        ISNULL(SHPL.FTShpName,'')		AS FTShpName,
                        ISNULL(USRBCH.FTAgnCode,'')     AS FTAgnCode,
                        ISNULL(AGNL.FTAgnName,'')       AS FTAgnName
                    FROM [TCNTUsrGroup] USRBCH WITH(NOLOCK)
                    LEFT JOIN [TCNMUser] USR WITH(NOLOCK) ON USR.FTUsrCode = USRBCH.FTUsrCode
                    LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON USRBCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON USRBCH.FTShpCode = SHPL.FTShpCode AND  USRBCH.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                    LEFT JOIN [TCNMMerchant_L] MERL WITH(NOLOCK) ON USRBCH.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                    LEFT JOIN [TCNMAgency_L] AGNL WITH(NOLOCK) ON USRBCH.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    WHERE 1 = 1
        ";
        // $tSQL       = " SELECT  DISTINCT
        //                     USRBCH.FTUsrCode,
        //                     USRBCH.FTBchCode,
        //                     BCHL.FTBchName
        //                 FROM [TCNTUsrGroup] USRBCH WITH(NOLOCK)
        //                 LEFT JOIN [TCNMUser] USR WITH(NOLOCK) ON USR.FTUsrCode = USRBCH.FTUsrCode
        //                 LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON BCHL.FTBchCode = USRBCH.FTBchCode AND BCHL.FNLngID = $nLngID
        //                 WHERE 1 = 1
        //             ";
        if($tUsrCode != ""){
            $tSQL .= " AND USR.FTUsrCode = '$tUsrCode' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Search TCNTUsrBch FTShpCode
    //Parameters : function parameters
    //Creator : 23/04/2018 Witsarut
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMUsrShpByID($ptAPIReq,$ptMethodReq,$paData){

        $tUsrCode   = $paData['FTUsrCode'];
        $nLngID     = $paData['FNLngID'];

        $aUsrBch    = $this->mLogin->FSaMLOGGetUsrBch($tUsrCode);
        $tBchCode   = $aUsrBch[0]['FTBchCode'];
      


        $tSQL       = " SELECT  DISTINCT
                            USRBCH.FTUsrCode,
                            USRBCH.FTBchCode,
                            SHPL.FTShpCode,
                            SHPL.FTShpName
                        FROM [TCNTUsrGroup] USRBCH WITH(NOLOCK)
                        LEFT JOIN [TCNMUser] USR WITH(NOLOCK) ON USR.FTUsrCode = USRBCH.FTUsrCode
                        LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON SHPL.FTShpCode = USRBCH.FTShpCode AND USRBCH.FTBchCode =  SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        WHERE 1 = 1 
                        AND USR.FTUsrCode       = '$tUsrCode'
                        AND USRBCH.FTBchCode    = '$tBchCode'
                    ";
                    $oQuery = $this->db->query($tSQL);

                    if ($oQuery->num_rows() > 0){
                        $oDetail = $oQuery->result_array();
                        $aResult = array(
                            'raItems'   => $oDetail,
                            'rtCode'    => '1',
                            'rtDesc'    => 'success',
                        );
                    }else{
                        //Not Found
                        $aResult = array(
                            'rtCode' => '800',
                            'rtDesc' => 'data not found.',
                        );
                    }
                    $jResult = json_encode($aResult);
                    $aResult = json_decode($jResult, true);
                    return $aResult;

    }


    //Functionality : Search ActRoleCode Join เอา USerCode
    //Parameters : function parameters
    //Creator : 01/06/2018 Witsarut
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMActRoleByID ($ptAPIReq,$ptMethodReq,$paData){
        $tUsrCode   = $paData['FTUsrCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL      = " SELECT 
                            USRACT.FTRolCode,
                            UROL.FTRolName, 
                            USRACT.FTUsrCode
                      FROM [TCNMUsrActRole] USRACT WITH(NOLOCK)
                      LEFT JOIN [TCNMUser] USR WITH(NOLOCK) ON USR.FTUsrCode = USRACT.FTUsrCode
                      LEFT JOIN [TCNMUsrRole_L] UROL WITH(NOLOCK) ON UROL.FTRolCode = USRACT.FTRolCode AND UROL.FNLngID = $nLngID
                      WHERE 1=1
             ";
            if($tUsrCode!= ""){
                $tSQL .= "AND USR.FTUsrCode = '$tUsrCode'";
            }
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //Not Found
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;


    }


    //Functionality : list User
    //Parameters : function parameters
    //Creator :  01/06/2018 Wasin
    //Last Modified : 12/03/2020 Saharat(Golf)
    //Last Modified : 07/05/2020 Napat(Jame)
    //Last Modified : 02/11/2020 Napat(Jame)
    //Last Modified : 26/11/2020 Napat(Jame) ปรับ performance ตอนดึงจำนวนข้อมูลทั้งหมด
    //Return : data User List
    //Return Type : Array
    public function FSaMUSRList($ptAPIReq,$ptMethodReq,$paData){

        $tWhere            = "";
        $tWhereCentrallize = "";
        $nSesUsrRoleLevel  = $this->session->userdata("nSesUsrRoleLevel");

        if( !empty($paData['tStaUsrLevel']) && $paData['tStaUsrLevel'] != "HQ" && $nSesUsrRoleLevel < 99 ){
            $tWhereCentrallize = " AND ( ";
            $nCountCon = 0;

            if(!empty($paData['tUsrAgnCode'])){
                $tUsrAgnCode = $paData['tUsrAgnCode'];
                if ( $nCountCon == 0 ){ $tStringOR = '';$nCountCon++; }else{ $tStringOR = 'OR'; }
                $tWhereCentrallize .=  " $tStringOR USRG.FTAgnCode = '$tUsrAgnCode' ";
            }

            if(!empty($paData['tUsrBchCode'])){
                $tUsrBchCode = $paData['tUsrBchCode'];
                if ( $nCountCon == 0 ){ $tStringOR = '';$nCountCon++; }else{ $tStringOR = 'OR'; }
                $tWhereCentrallize .=  " $tStringOR USRG.FTBchCode IN ($tUsrBchCode) ";
            }

            if(!empty($paData['tUsrShpCode'])){
                $tUsrShpCode = $paData['tUsrShpCode'];
                if ( $nCountCon == 0 ){ $tStringOR = '';$nCountCon++; }else{ $tStringOR = 'OR'; }
                $tWhereCentrallize .=  " $tStringOR USRG.FTShpCode IN ($tUsrShpCode) ";
            }

            if(!empty($paData['tUsrMerCode'])){
                $tUsrMerCode = $paData['tUsrMerCode'];
                if ( $nCountCon == 0 ){ $tStringOR = '';$nCountCon++; }else{ $tStringOR = 'OR'; }
                $tWhereCentrallize .=  " $tStringOR USRG.FTMerCode = '$tUsrMerCode' ";
            }

            $tWhereCentrallize .= " ) ";
        }

        $tSearchList    = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tWhere .= " AND (USR.FTUsrCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tWhere .= " OR USRL.FTUsrName  COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tWhere .= " OR BCHL.FTBchName  COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tWhere .= " OR SHPL.FTShpName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID         = $paData['FNLngID'];

        $tMainQuery     = " SELECT
                                ROW_NUMBER() OVER(ORDER BY A.FDCreateOn DESC, A.rtUsrCode DESC, A.rtBchCode DESC, A.rtShpCode DESC) AS rtRowID, 
                                A.*
                            FROM (
                                SELECT
                                    ROW_NUMBER() OVER(PARTITION BY USR.FTUsrCode ORDER BY USR.FDCreateOn DESC, USR.FTUsrCode DESC, BCHL.FTBchCode DESC, SHPL.FTShpCode DESC) AS DupUsrCode, 
                                    IMGP.FTImgObj       AS rtUsrImage,
                                    USR.FTUsrCode       AS rtUsrCode,
                                    USRL.FTUsrName      AS rtUsrName,
                                    UDPT.FTDptCode      AS rtDptCode,
                                    UDPT.FTDptName      AS rtDptName,
                                    BCHL.FTBchCode      AS rtBchCode,
                                    BCHL.FTBchName      AS rtBchName,
                                    SHPL.FTShpCode      AS rtShpCode,
                                    SHPL.FTShpName      AS rtShpName,
                                    USR.FDCreateOn      AS FDCreateOn 
                          ";

        $tCountQuery    = " SELECT ROW_NUMBER() OVER(ORDER BY A.DupUsrCode ASC) AS rtRowID
                            FROM ( SELECT ROW_NUMBER() OVER(PARTITION BY USR.FTUsrCode
                                    ORDER BY USR.FDCreateOn DESC, USR.FTUsrCode DESC, 
                                             BCHL.FTBchCode DESC, SHPL.FTShpCode DESC ) AS DupUsrCode 
                          ";

        $tSubQuery      = "     FROM [TCNMUser] USR WITH(NOLOCK)
                                LEFT JOIN [TCNTUsrGroup] USRG WITH(NOLOCK) ON USR.FTUsrCode = USRG.FTUsrCode
                                LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON USRG.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                                LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON USRG.FTShpCode = SHPL.FTShpCode AND USRG.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                                LEFT JOIN [TCNMUser_L] USRL WITH(NOLOCK) ON USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                                LEFT JOIN [TCNMUsrDepart_L] UDPT WITH(NOLOCK) ON USR.FTDptCode = UDPT.FTDptCode AND UDPT.FNLngID = $nLngID
                                LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON USR.FTUsrCode = IMGP.FTImgRefID AND IMGP.FTImgTable = 'TCNMUser' AND IMGP.FNImgSeq = $nLngID
                                LEFT JOIN (
                                    SELECT A.FTUsrCode,ISNULL(R.FNRolLevel,0) AS FNRolLevel,A.FTRolCode FROM TCNMUsrActRole A WITH(NOLOCK)
                                    LEFT JOIN TCNMUsrRole R WITH(NOLOCK) ON A.FTRolCode = R.FTRolCode
                                ) UAR ON USR.FTUsrCode = UAR.FTUsrCode
                                WHERE 1=1 AND UAR.FNRolLevel <= $nSesUsrRoleLevel
                                $tWhere
                                $tWhereCentrallize
                            ) A
                            WHERE A.DupUsrCode = 1 
                          ";

        $tSQL           = " SELECT c.* FROM (
                                $tMainQuery $tSubQuery
                            ) C
                            WHERE 1=1 AND C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]
                        ";

        $oQuery         = $this->db->query($tSQL);
        // echo $this->db->last_query();
        // echo "<br><br>";

        $tCountQuery = $tCountQuery.$tSubQuery;
        $nQueryNumRows  = $this->db->query($tCountQuery)->num_rows();
        // echo $this->db->last_query();
        // exit;
        // echo $tSQL."<br>";
        // echo $tSubQuery;
        // exit;
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            // $nFoundRow  = $this->FSnMUSRGetPageAll($tSearchList,$nLngID,$paData);
            // $nFoundRow  = $nFoundRow; //$aFoundRow[0]->counts
            $nFoundRow  = $nQueryNumRows;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => $nPageAll, 
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );

        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : All Page Of User
    //Parameters : function parameters
    //Creator :  04/06/2018 Wasin
    //Last Modified : 07/05/2020 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSnMUSRGetPageAll($ptSearchList,$ptLngID,$paData){
        
        $tWhere = "";
        if(!empty($paData['tStaUsrLevel']) && $paData['tStaUsrLevel'] != "HQ"){
            if(!empty($paData['tUsrBchCode'])){
                $tUsrBchCode = $paData['tUsrBchCode'];
                $tWhere .=  " AND USRG.FTBchCode IN ($tUsrBchCode) ";
            }

            if(!empty($paData['tUsrShpCode'])){
                $tUsrShpCode = $paData['tUsrShpCode'];
                $tWhere .=  " AND USRG.FTShpCode IN ($tUsrShpCode) ";
            }

            if(!empty($paData['tUsrMerCode'])){
                $tUsrMerCode = $paData['tUsrMerCode'];
                $tWhere .=  " AND USRG.FTMerCode = '$tUsrMerCode' ";
            }
        }

        if($ptSearchList != ''){
            $tWhere .= " AND (USR.FTUsrCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tWhere .= " OR USRL.FTUsrName  COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tWhere .= " OR BCHL.FTBchName  COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tWhere .= " OR SHPL.FTShpName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        }

        $tSQL   =   "   SELECT
                            ROW_NUMBER() OVER(ORDER BY A.FDCreateOn DESC, A.rtUsrCode DESC, A.rtBchCode DESC, A.rtShpCode DESC) AS rtRowID, 
                            A.*
                        FROM (
                            SELECT
                                ROW_NUMBER() OVER(PARTITION BY USR.FTUsrCode ORDER BY USR.FDCreateOn DESC, USR.FTUsrCode DESC, BCHL.FTBchCode DESC, SHPL.FTShpCode DESC) AS DupUsrCode, 
                                IMGP.FTImgObj       AS rtUsrImage,
                                USR.FTUsrCode       AS rtUsrCode,
                                USRL.FTUsrName      AS rtUsrName,
                                UDPT.FTDptCode      AS rtDptCode,
                                UDPT.FTDptName      AS rtDptName,
                                -- UROL.FTRolCode      AS rtRolCode,
                                -- UROL.FTRolName      AS rtRolName,
                                BCHL.FTBchCode      AS rtBchCode,
                                BCHL.FTBchName      AS rtBchName,
                                SHPL.FTShpCode      AS rtShpCode,
                                SHPL.FTShpName      AS rtShpName,
                                USR.FDCreateOn      AS FDCreateOn
                            FROM [TCNMUser] USR WITH(NOLOCK)
                            LEFT JOIN [TCNTUsrGroup] USRG WITH(NOLOCK) ON USR.FTUsrCode = USRG.FTUsrCode
                            LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON USRG.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = 1
                            LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON USRG.FTShpCode = SHPL.FTShpCode AND USRG.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = 1
                            LEFT JOIN [TCNMUser_L] USRL WITH(NOLOCK) ON USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = 1
                            LEFT JOIN [TCNMUsrDepart_L] UDPT WITH(NOLOCK) ON USR.FTDptCode = UDPT.FTDptCode AND UDPT.FNLngID = 1
                            /*LEFT JOIN [TCNMUsrRole_L] UROL WITH(NOLOCK) ON USR.FTRolCode = UROL.FTRolCode AND UROL.FNLngID = 1*/
                            LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON USR.FTUsrCode = IMGP.FTImgRefID AND IMGP.FTImgTable = 'TCNMUser' AND IMGP.FNImgSeq = 1
                            WHERE 1=1
                            $tWhere
                        ) A
                        WHERE A.DupUsrCode = 1
        ";
        // if($ptSearchList != ''){
        //     $tSQL .= " AND (USR.FTUsrCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
        //     $tSQL .= " OR USRL.FTUsrName  COLLATE THAI_BIN LIKE '%$ptSearchList%'";
        //     $tSQL .= " OR BCHL.FTBchName  COLLATE THAI_BIN LIKE '%$ptSearchList%'";
        //     $tSQL .= " OR SHPL.FTShpName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        // }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            // return $oQuery->result();
            return $oQuery->num_rows();
        }else{
            //No Data
            return 0;
        }
    }

    //Functionality : Checkduplicate Data 
    //Parameters : function parameters
    //Creator : 07/06/2018 Wasin
    //Last Modified : -
    //Return : data Count Duplicate
    //Return Type : object
    public function FSoMUSRCheckDuplicate($ptUsrCode){
        $tSQL   = "SELECT COUNT(FTUsrCode)AS counts
                   FROM TCNMUser
                   WHERE FTUsrCode = '$ptUsrCode' ";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add Update Master
    //Parameters : function parameters
    //Creator : 11/06/2018 Wasin
    //Last Modified : 07/05/2020 Napat(Jame)
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMUSRAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTDptCode' , $paData['FTDptCode']);
            // $this->db->set('FTRolCode' , $paData['FTRolCode']);
            $this->db->set('FTUsrTel' , $paData['FTUsrTel']);
            // $this->db->set('FTUsrPwd' , $paData['FTUsrPwd']);
            $this->db->set('FTUsrEmail' , $paData['FTUsrEmail']);

            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

            $this->db->where('FTUsrCode',$paData['FTUsrCode']);
            $this->db->update('TCNMUser');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                //Add Master
                $this->db->insert('TCNMUser',array(
                    'FTUsrCode'     => $paData['FTUsrCode'],
                    'FTDptCode'     => $paData['FTDptCode'],
                    // 'FTRolCode'     => $paData['FTRolCode'],
                    'FTUsrTel'      => $paData['FTUsrTel'],
                    // 'FTUsrPwd'      => $paData['FTUsrPwd'],
                    'FTUsrEmail'    => $paData['FTUsrEmail'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTUsrRefInt'   => $paData['FTUsrRefInt'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    //Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    // Delete USerActRole ก่อน แล้วจึง loop
    // Create By Witsarut 24/02/2020
    public function FSaMDelActRoleCode($paData){
        try{
            $this->db->where_in('FTUsrCode',$paData['FTUsrCode']);
            $this->db->delete('TCNMUsrActRole');
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Update table TCNMUsrActRole  (Bell)
    // Create By Witsarut 24/02/2020
    public function FSaMUpdateMasterActRole($paRoleCode,$paData){

        try{
            $aResult    = array(
                'FTRolCode'     => $paRoleCode,
                'FTUsrCode'     => $paData['FTUsrCode'],
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                'FDCreateOn'    => $paData['FDCreateOn'],
                'FTCreateBy'    => $paData['FTCreateBy']                
            );
            $this->db->insert('TCNMUsrActRole',$aResult);
        }catch(Exception $Error){
            return $Error;
        }     
    }

    //Functionality : Function Add Update Master ActRole
    //Parameters : function parameters
    //Creator : 11/06/2018 witsarut (bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMUSRAddUpdateMasterActRole($paRoleCode,$paData){
        try{
            $aResult = array(
                'FTRolCode'     => $paRoleCode,
                'FTUsrCode'     => $paData['FTUsrCode'],
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                'FDCreateOn'    => $paData['FDCreateOn'],
                'FTCreateBy'    => $paData['FTCreateBy']
            );

            $this->db->insert('TCNMUsrActRole',$aResult);
        }catch(Exception $Error){
            return $Error;
        }
    }


    // Delete USerBch ก่อน แล้วจึง loop
    // Create By Witsarut 24/02/2020
    public function FSaMDelUsrBchCode($paData){
        try{
            $this->db->where_in('FTUsrCode',$paData['FTUsrCode']);
            $this->db->delete('TCNTUsrGroup');
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Add Update Master TCNTUsrGroup
    //Parameters : function parameters
    //Creator : 24/04/2020 witsarut (bell)
    //Last Modified : 07/05/2020 Napat(Jame)
    //Last Modified : 11/05/2020 Napat(Jame)
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMUSRAddUpdateMasterUsrBch($paBchCode,$paData){
        try{
            $aResult  = array(
                'FTUsrCode'     => $paData['FTUsrCode'],
                'FTAgnCode'     => $paData['FTAgnCode'],
                'FTMerCode'     => $paData['FTMerCode'],
                'FTBchCode'     => $paBchCode,
                'FTShpCode'     => '',
                'FDCreateOn'    => $paData['FDCreateOn'],
                'FTCreateBy'    => $paData['FTCreateBy'],
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy']
            );
            $this->db->insert('TCNTUsrGroup' ,$aResult);
            // //Update Master
            // $this->db->set('FTMerCode' , $paDataInsert['FTMerCode']);
            // $this->db->set('FTBchCode' , $paDataInsert['FTBchCode']);
            // $this->db->set('FTShpCode' , $paDataInsert['FTShpCode']);
            // $this->db->set('FDLastUpdOn' , $paDataInsert['FDLastUpdOn']);
            // $this->db->set('FTLastUpdBy' , $paDataInsert['FTLastUpdBy']);
            // $this->db->where('FTUsrCode',$paDataInsert['FTUsrCode']);
            // $this->db->update('TCNTUsrGroup');
            // if($this->db->affected_rows() > 0){
            //     $aStatus = array(
            //         'rtCode' => '1',
            //         'rtDesc' => 'Update Success',
            //     );
            // }else{
            //     //Add TCNTUsrGroup
            //     $this->db->insert('TCNTUsrGroup' ,$paDataInsert);
            //     if($this->db->affected_rows() > 0){
            //         $aStatus = array(
            //             'rtCode' => '1',
            //             'rtDesc' => 'Add Success',
            //         );
            //     }else{
            //         //Error 
            //         $aStatus = array(
            //             'rtCode' => '905',
            //             'rtDesc' => 'Error Cannot Add/Edit Master.',
            //         );
            //     }
            // }
            // return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Function Add Update Master TCNTUsrBch ShpCode
    //Parameters : function parameters
    //Creator : 24/04/2020 witsarut (bell)
    //Last Modified : 11/05/2020 Napat(Jame)
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMUSRAddUpdateMasterUsrShp($paBchShpCode, $paBchCode, $paData){


        try{
            $aResult  = array(
                'FTUsrCode'     => $paData['FTUsrCode'],
                'FTBchCode'     => $paBchCode,
                'FTShpCode'     => $paBchShpCode,
                'FTMerCode'     => $paData['FTMerCode'],
                'FTAgnCode'     => $paData['FTAgnCode'],
                'FDCreateOn'    => $paData['FDCreateOn'],
                'FTCreateBy'    => $paData['FTCreateBy'],
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy']
            );
            $this->db->insert('TCNTUsrGroup' ,$aResult);
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Update table TCNTUsrBch  (Bell)
    // Create By Witsarut 23/04/2020
    // public function FSaMUpdateMasterUsrBch($paBranchCode,$paData){
    //     try{
    //         $aResult  = array(
    //             'FTUsrCode'     => $paData['FTUsrCode'],
    //             'FTBchCode'     => $paBranchCode,
    //             'FTShpCode'     => '',
    //             'FDCreateOn'    => $paData['FDCreateOn'],
    //             'FTCreateBy'    => $paData['FTCreateBy'],
    //             'FDLastUpdOn'   => $paData['FDLastUpdOn'],
    //             'FTLastUpdBy'   => $paData['FTLastUpdBy']
    //         );
    //         $this->db->insert('TCNTUsrBch' ,$aResult);
    //     }catch(Exception $Error){
    //         return $Error;
    //     }
    // }

    //Update table TCNTUsrBch  (Bell)
    // Create By Witsarut 23/04/2020 (Feild Shp)
    // public function FSaMUSRUpdateUsrShp($paBchShpCode, $paBchCode, $paData){
    //     try{
    //         $aResult  = array(
    //             'FTUsrCode'     => $paData['FTUsrCode'],
    //             'FTBchCode'     => $paBchCode,
    //             'FTShpCode'     => $paBchShpCode,
    //             'FDCreateOn'    => $paData['FDCreateOn'],
    //             'FTCreateBy'    => $paData['FTCreateBy'],
    //             'FDLastUpdOn'   => $paData['FDLastUpdOn'],
    //             'FTLastUpdBy'   => $paData['FTLastUpdBy']
    //         );
    //         $this->db->insert('TCNTUsrBch', $aResult);
    //     }catch(Exception $Error){
    //         return $Error;
    //     }
    // }


    //Functionality : Function Add Update Lang
    //Parameters : function parameters
    //Creator : 11/06/2018 Wasin
    //Last Modified : -
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMUSRAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTUsrName',$paData['FTUsrName']);
            $this->db->set('FTUsrRmk',$paData['FTUsrRmk']);
            $this->db->where('FTUsrCode',$paData['FTUsrCode']);
            $this->db->where('FNLngID',$paData['FNLngID']);
            $this->db->update('TCNMUser_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                //Add Lang
                $this->db->insert('TCNMUser_L',array(
                    'FTUsrCode' => $paData['FTUsrCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTUsrName' => $paData['FTUsrName'],
                    'FTUsrRmk'  => $paData['FTUsrRmk'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    //Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Function Add Update Group
    //Parameters : function parameters
    //Creator : 11/06/2018 Wasin
    //Last Modified : -
    //Return : Status Add Update Group
    //Return Type : Array
    public function FSaMUSRAddUpdateGroup($paData){
        try{
            //Update Group
            $this->db->set('FTBchCode',$paData['FTBchCode']);
            $this->db->set('FTUsrStaShop',$paData['FTUsrStaShop']);
            $this->db->set('FTShpCode',$paData['FTShpCode']);
            // $this->db->set('FDUsrStart',$paData['FDUsrStart']);
            // $this->db->set('FDUsrStop',$paData['FDUsrStop']);
            // $this->db->where('FTBchCode',$paData['FTBchCode']);
            $this->db->where('FTUsrCode',$paData['FTUsrCode']);
            $this->db->update('TCNTUsrGroup');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                //Add Group
                $this->db->insert('TCNTUsrGroup',array(
                    'FTUsrCode'     => $paData['FTUsrCode'],
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTUsrStaShop'  => $paData['FTUsrStaShop'],
                    'FTShpCode'     => $paData['FTShpCode'],
                    // 'FDUsrStart'    => $paData['FDUsrStart'],
                    // 'FDUsrStop'     => $paData['FDUsrStop']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    //Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Group.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Delete User
    //Parameters : function parameters
    //Creator : 08/06/2018 Wasin
    //Return : Status Delete 
    //Return Type : array
    public function FSnMUSRDel($paData){
        try{
            $this->db->where_in('FTUsrCode', $paData['FTUsrCode']);
            $this->db->delete('TCNMUser');
        
            $this->db->where_in('FTUsrCode', $paData['FTUsrCode']);
            $this->db->delete('TCNMUser_L');

            $this->db->where_in('FTUsrCode', $paData['FTUsrCode']);
            $this->db->delete('TCNTUsrGroup');

            $this->db->where_in('FTUsrCode', $paData['FTUsrCode']);
            $this->db->delete('TCNMUsrLogin');
            
            // Create By Witsarut 21/02/2020
            $this->db->where_in('FTUsrCode' ,$paData['FTUsrCode']);
            $this->db->delete('TCNMUsrActRole');

            // Create By Witsarut 23/02/2020
            // $this->db->where_in('FTUsrCode' ,$paData['FTUsrCode']);
            // $this->db->delete('TCNTUsrBch');

            if($this->db->affected_rows() > 0){
                //Success
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            }else{
                //Ploblem
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    } 
    
    /**
     * Functionality : Query User Full By ID
     * Parameters : function parameters
     * Creator : 03/10/2018 piya
     * Last Modified : 17/10/2018 piya
     * Return : data
     * Return Type : array
     */
    public function FSaMUSRByID($paData){
        $tUsrCode   = $paData['FTUsrCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    IMGP.FTImgObj       AS rtUsrImage,
                    USR.FTUsrCode       AS rtUsrCode,
                    USR.FTUsrTel        AS rtUsrTel,
                    USR.FTUsrEmail      AS rtUsrEmail,
                    -- USR.FTUsrPwd        AS rtUsrPassword,
                    USRL.FTUsrName      AS rtUsrName,
                    USRL.FTUsrRmk       AS rtUsrRmk,
                    UDPT.FTDptCode      AS rtDptCode,
                    UDPT.FTDptName      AS rtDptName
                    -- UROL.FTRolCode      AS rtRolCode,
                    -- UROL.FTRolName      AS rtRolName
                    -- BCHL.FTBchCode      AS rtBchCode,
                    -- BCHL.FTBchName      AS rtBchName,
                    -- SHPL.FTShpCode      AS rtShpCode,
                    -- SHPL.FTShpName      AS rtShpName
                 FROM [TCNMUser] USR
                 LEFT JOIN [TCNMUser_L] USRL ON USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                 LEFT JOIN [TCNMUsrDepart_L] UDPT ON USR.FTDptCode = UDPT.FTDptCode AND UDPT.FNLngID = $nLngID
                --  LEFT JOIN [TCNMUsrRole_L] UROL ON USR.FTRolCode = UROL.FTRolCode AND UROL.FNLngID = $nLngID
                 --LEFT JOIN [TCNTUsrGroup] USRG ON USR.FTUsrCode = USRG.FTUsrCode
                --  LEFT JOIN [TCNMBranch_L] BCHL ON USRG.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                --  LEFT JOIN [TCNMShop_L] SHPL ON USRG.FTShpCode = SHPL.FTShpCode AND USRG.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                 LEFT JOIN [TCNMImgPerson] IMGP ON USR.FTUsrCode = IMGP.FTImgRefID AND IMGP.FTImgTable = 'TCNMUser'
                 WHERE 1=1
                 AND USR.FTUsrCode = '$tUsrCode'";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }



   //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMUser";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }  
    
    //Functionality : Get Shop From Merchant
    //Parameters : ptMerCode
    //Creator : 19/05/2020 Napat(Jame)
    //Return : array result from db
    //Return Type : array
    public function FSaMUSRGetShpFromMerCode($ptMerCode){

        $nLngID      = $this->session->userdata("tLangEdit");

        $tSQL = "   SELECT
                        FTShpCode
                    FROM TCNMShop WITH(NOLOCK)
                    WHERE FTMerCode = '$ptMerCode'
                ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = array(
                'aItems'    => $oQuery->result_array(),
                'nStaQuery' => 1,
                'tMsg'      => 'Success'
            );
        }else{
            $aResult = array(
                'aItems'    => array(),
                'nStaQuery' => 800,
                'tMsg'      => 'data not found'
            );
        }
        return $aResult;
    }

    //Functionality : Get Branch From Agency
    //Parameters : FTAgnCode
    //Creator : 19/05/2020 Napat(Jame)
    //Return : array result from db
    //Return Type : array
    public function FSaMUSRGetBchFromAgnCode($ptAgnCode){
        $tSQL = "   SELECT
                        FTBchCode
                    FROM TCNMBranch WITH(NOLOCK)
                    WHERE FTAgnCode = '$ptAgnCode'
                ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = array(
                'aItems'    => $oQuery->result_array(),
                'nStaQuery' => 1,
                'tMsg'      => 'Success'
            );
        }else{
            $aResult = array(
                'aItems'    => array(),
                'nStaQuery' => 800,
                'tMsg'      => 'data not found'
            );
        }
        return $aResult;
    }

    //Functionality : Get UsrRoleSpc
    //Parameters : 
    //Creator : 19/06/2020 Nattakit(Nale)
    //Return : array result from db
    //Return Type : array
    public function FStUSERGetRoleSpcWhereBrows($paBchCode){

        // echo $this->session->userdata('tSesUsrLevelAD').'xx';
        $tSesUsrAgnCode       = $this->session->userdata('tSesUsrAgnCode'); 
        $tSesUserCode = $this->session->userdata('tSesUserCode');
        $tUsrAd = $this->db->where('FTUsrCode',$tSesUserCode)->get('TCNTUsrGroup')->row_array()['FTBchCode'];
        if(!empty($paBchCode)){
            $tSesUsrBchCodeMulti  = "'".str_replace(",","','",$paBchCode)."'"; 
        }else{
            $tSesUsrBchCodeMulti  = $this->session->userdata('tSesUsrBchCodeMulti'); 
        }
        $tSQL = "   SELECT DISTINCT URSP.FTRolCode
                    FROM TCNMUsrRoleSpc URSP WITH(NOLOCK)
                    WHERE 1 = 1
                    AND ( 
                ";
        if( $tUsrAd == '' ){
            $tSQL .= " ( URSP.FTAgnCode = '$tSesUsrAgnCode' ) OR ( ISNULL(URSP.FTAgnCode,'')='' AND ISNULL(URSP.FTBchCode,'')=''  ) ";
        }else{
            $tSQL .= " ( URSP.FTBchCode IN ($tSesUsrBchCodeMulti) )  OR ( ISNULL(URSP.FTAgnCode,'')='$tSesUsrAgnCode' AND ISNULL(URSP.FTBchCode,'')='' ) ";
        }
                        
        $tSQL .= "  ) ";

        // echo  $tSQL;die();
        $oQuery = $this->db->query($tSQL);  
        if($oQuery->num_rows() > 0){
            $aResult = array(
                'aItems'    => $oQuery->result_array(),
                'nStaQuery' => 1,
                'tMsg'      => 'Success'
            );
        }else{
            $aResult = array(
                'aItems'    => array(),
                'nStaQuery' => 800,
                'tMsg'      => 'data not found'
            );
        }
        return $aResult;
    }   

    ////////////////////// IMPORT /////////////////////////

    //ข้อมูลใน Temp
    public function FSaMUSRGetTempData($paDataSearch){
        $nLngID         = $paDataSearch['nLangEdit'];
        $tTableKey      = $paDataSearch['tTableKey'];
        $tSessionID     = $paDataSearch['tSessionID'];
        $tTextSearch    = $paDataSearch['tTextSearch'];

        $tSQL   = " SELECT 
                        IMP.FNTmpSeq,
                        IMP.FTBchCode,
                        IMP.FTUsrCode,
                        IMP.FTUsrName,
                        IMP.FTBchCode,
                        BCH_L.FTBchName,
                        IMP.FTRolCode,
                        RLE_L.FTRolName,
                        IMP.FTAgnCode,
                        AGN_L.FTAgnName,
                        IMP.FTMerCode,
                        MER_L.FTMerName,
                        IMP.FTShpCode,
                        SHP_L.FTShpName,
                        IMP.FTDptCode,
                        DEP_L.FTDptName,
                        IMP.FTUsrTel,
                        IMP.FTUsrEmail,
                        IMP.FTTmpRemark,
                        IMP.FTTmpStatus
                    FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                    LEFT JOIN TCNMBranch_L BCH_L WITH(NOLOCK) ON IMP.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                    LEFT JOIN TCNMUsrRole_L RLE_L WITH(NOLOCK) ON IMP.FTRolCode = RLE_L.FTRolCode AND RLE_L.FNLngID = $nLngID
                    LEFT JOIN TCNMAgency_L	AGN_L WITH(NOLOCK) ON IMP.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMMerchant_L MER_L WITH(NOLOCK) ON IMP.FTMerCode = MER_L.FTMerCode AND MER_L.FNLngID = $nLngID
                    LEFT JOIN TCNMShop_L SHP_L WITH(NOLOCK) ON IMP.FTShpCode = SHP_L.FTShpCode AND SHP_L.FNLngID = $nLngID
                    LEFT JOIN TCNMUsrDepart_L DEP_L WITH(NOLOCK) ON IMP.FTDptCode = DEP_L.FTDptCode AND DEP_L.FNLngID = $nLngID
                    WHERE 1=1
                        AND IMP.FTSessionID     = '$tSessionID'
                        AND FTTmpTableKey       = '$tTableKey'
        ";

        if($tTextSearch != '' || $tTextSearch != null){
            $tSQL .= " AND (IMP.FTBchCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTUsrCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTUsrName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTBchCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTRolCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTAgnCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTMerCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTShpCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTDptCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTUsrTel LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTRolCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTUsrEmail LIKE '%$tTextSearch%' ";
            $tSQL .= " OR RLE_L.FTRolName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR MER_L.FTMerName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR AGN_L.FTAgnName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR DEP_L.FTDptName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR BCH_L.FTBchName LIKE '%$tTextSearch%' ";
            $tSQL .= " )";
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aStatus = array(
                'tCode'     => '1',
                'tDesc'     => 'success',
                'aResult'   => $oQuery->result_array(),
                'numrow'    => $oQuery->num_rows()
            );
        }else{
            $aStatus = array(
                'tCode'     => '99',
                'tDesc'     => 'Error',
                'aResult'   => array(),
                'numrow'    => 0
            );
        }
        return $aStatus;
    }

    //ลบข้อมูลใน Temp 
    public function FSaMUSRImportDelete($paParamMaster) {
        try{
            $this->db->where_in('FNTmpSeq', $paParamMaster['FNTmpSeq']);
            $this->db->delete('TCNTImpMasTmp');

            if($this->db->trans_status() === FALSE){
                $aStatus = array(
                    'tCode' => '905',
                    'tDesc' => 'Cannot Delete Item.',
                );
            }else{
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //move temp to ตารางจริง
    public function FSaMUSRImportMove2Master($paDataSearch){
        try{
            $nLngID          = $paDataSearch['nLangEdit'];
            $tTableKey       = $paDataSearch['tTableKey'];
            $tSessionID      = $paDataSearch['tSessionID'];
            $dDateOn         = $paDataSearch['dDateOn'];
            $tUserBy         = $paDataSearch['tUserBy'];
            $dUserDateStart  = $paDataSearch['dUserDateStart'];
            $dUserDateStop   = $paDataSearch['dUserDateStop'];

            $tSQLTmp = "SELECT 
                IMP.FTUsrCode,
                IMP.FTTmpRemark
            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
            WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $oQuery = $this->db->query($tSQLTmp); 
            $oDetail = $oQuery->result();

            //เพิ่มข้อมูลลงตาราง USER
            $tSQL   = " INSERT INTO TCNMUser (
                            FTUsrCode,FTDptCode,FTUsrTel,FTUsrEmail,
                            FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy
                        )
                        SELECT 
                            IMP.FTUsrCode,
                            IMP.FTDptCode,
                            IMP.FTUsrTel,
                            IMP.FTUsrEmail,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง USER_L
            $tSQL   = " INSERT INTO TCNMUser_L (FTUsrCode,FNLngID,FTUsrName,FTUsrRmk)
                        SELECT 
                            IMP.FTUsrCode,
                            $nLngID,
                            IMP.FTUsrName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลตารางสิทธิ์ TCNMUsrActRole
            $tSQL   = " INSERT INTO TCNMUsrActRole (FTRolCode,FTUsrCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                        CASE
                            WHEN ISNULL(IMP.FTRolCode,'') = '' THEN (
                                    SELECT TOP 1 
                                        CASE 
                                            WHEN ISNULL(FTCfgStaUsrValue,'') = '' THEN FTCfgStaDefValue
                                            ELSE FTCfgStaUsrValue
                                        END AS FTRolCode
                                    FROM TLKMConfig 
                                    WHERE FTCfgCode = 'tLK_ImportDefRole'
                                )
                                ELSE IMP.FTRolCode
                            END AS FTRolCode,
                            IMP.FTUsrCode,
                            '$dDateOn' AS FDLastUpdOn,
                            '$tUserBy' AS FTLastUpdBy,
                            '$dDateOn' AS FDCreateOn,
                            '$tUserBy' AS FTCreateBy
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลตารางความสัมพันธ business TCNTUsrGroup
            $tSQL   = " INSERT INTO TCNTUsrGroup (
                            FTUsrCode , FTBchCode , FTShpCode , 
                            FTMerCode ,FTAgnCode , FDCreateOn , 
                            FTCreateBy , FDLastUpdOn , FTLastUpdBy
                        )
                        SELECT 
                            IMP.FTUsrCode,
                            IMP.FTBchCode,
                            IMP.FTShpCode,
                            IMP.FTMerCode,
                            IMP.FTAgnCode, 
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = '$tTableKey'
                        AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง user login
            // (SELECT TOP 1 
            //                     CASE WHEN ISNULL(FTCfgStaUsrValue,'') = '' THEN FTCfgStaDefValue
            //                     ELSE FTCfgStaUsrValue
            //                     END AS FDUsrPwdStart
            //                 FROM TLKMConfig WHERE FTCfgCode = 'tLK_ImportDefPwd') AS FTUsrLoginPwd,
            $tSQL   = " INSERT INTO TCNMUsrLogin (
                            FTUsrCode , FTUsrLogType , FDUsrPwdStart , FDUsrPwdExpired ,
                            FTUsrLogin , FTUsrLoginPwd , FTUsrStaActive , FTUsrRmk
                        )
                        SELECT 
                            IMP.FTUsrCode,
                            1 AS FTUsrLogType,
                            '$dUserDateStart' AS FDUsrPwdStart,
                            '$dUserDateStop' AS FDUsrPwdExpired,
                            IMP.FTUsrCode,
                            'L2lAf14Fp/jQlypugDBNoA==' AS FTUsrLoginPwd,
                            3 AS FTUsrStaActive,
                            'IMPORT' AS FTUsrRmk
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = '$tTableKey'
                        AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

        
            foreach($oDetail as $nKey => $aValue){
                if($aValue->FTTmpRemark == 'AutoGen'){
                    $aStoreParam = array(
                        "tTblName"    => 'TCNMUser',                           
                        "tDocType"    => 0,                                          
                        "tBchCode"    => "",                                 
                        "tShpCode"    => "",                               
                        "tPosCode"    => "",                     
                        "dDocDate"    => date("Y-m-d")       
                    );
                    $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                    $tUsrCode   = $aAutogen[0]["FTXxhDocNo"];

                    //อัพเดทตาราง user
                    $tSQL   = " UPDATE
                                    TCNMUser
                                SET
                                    TCNMUser.FTUsrCode  = '$tUsrCode'
                                WHERE
                                    TCNMUser.FTUsrCode = '$aValue->FTUsrCode' 
                    ";
                    $this->db->query($tSQL);

                    //อัพเดทรายการ_L
                    $tSQL   = " UPDATE
                                    TCNMUser_L
                                SET
                                    TCNMUser_L.FTUsrCode  = '$tUsrCode'
                                WHERE
                                    TCNMUser_L.FTUsrCode = '$aValue->FTUsrCode' 
                    ";
                    $this->db->query($tSQL);

                    //อัพเดทรายการ Role
                    $tSQL   = " UPDATE
                                    TCNMUsrActRole
                                SET
                                    TCNMUsrActRole.FTUsrCode = '$tUsrCode'
                                WHERE
                                    TCNMUsrActRole.FTUsrCode = '$aValue->FTUsrCode' 
                    ";
                    $this->db->query($tSQL);
                    
                    //อัพเดทรายการ TCNTUsrGroup
                    $tSQL   = " UPDATE
                                    TCNTUsrGroup
                                SET
                                    TCNTUsrGroup.FTUsrCode = '$tUsrCode'
                                WHERE
                                    TCNTUsrGroup.FTUsrCode = '$aValue->FTUsrCode' 
                    ";
                    $this->db->query($tSQL);

                    //อัพเดทรายการ TCNMUsrLogin
                    $tSQL   = " UPDATE
                                    TCNMUsrLogin
                                SET
                                    TCNMUsrLogin.FTUsrCode = '$tUsrCode',
                                    TCNMUsrLogin.FTUsrLogin = '$tUsrCode'
                                WHERE
                                    TCNMUsrLogin.FTUsrCode = '$aValue->FTUsrCode' 
                    ";
                    $this->db->query($tSQL);
                }
            }
            

            if($this->db->trans_status() === FALSE){
                $aStatus = array(
                    'tCode'     => '99',
                    'tDesc'     => 'Error'
                );
            }else{
                $aStatus = array(
                    'tCode'     => '1',
                    'tDesc'     => 'success'
                );
            }
            return $aStatus;
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //move temp 
    public function FSaMUSRImportMove2MasterAndReplaceOrInsert($paDataSearch){
        try{
            $tTypeCaseDuplicate = $paDataSearch['tTypeCaseDuplicate'];
            $nLngID             = $paDataSearch['nLangEdit'];
            $tTableKey          = $paDataSearch['tTableKey'];
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $dUserDateStart     = $paDataSearch['dUserDateStart'];
            $dUserDateStop      = $paDataSearch['dUserDateStop'];
            
            if($tTypeCaseDuplicate == 2){
                //อัพเดทรายการเดิม

                //อัพเดทตาราง user
                $tSQL   = " UPDATE
                                TCNMUser
                            SET
                                TCNMUser.FTDptCode  = TCNTImpMasTmp.FTDptCode,
                                TCNMUser.FTUsrTel   = TCNTImpMasTmp.FTUsrTel,
                                TCNMUser.FTUsrEmail = TCNTImpMasTmp.FTUsrEmail,
                                TCNMUser.FDLastUpdOn = '$dDateOn',
                                TCNMUser.FTLastUpdBy = '$tUserBy'
                            FROM
                                TCNMUser
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMUser.FTUsrCode = TCNTImpMasTmp.FTUsrCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMUser'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ_L
                $tSQL   = " UPDATE
                                TCNMUser_L
                            SET
                                TCNMUser_L.FTUsrName  = TCNTImpMasTmp.FTUsrName
                            FROM
                                TCNMUser_L
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMUser_L.FTUsrCode = TCNTImpMasTmp.FTUsrCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMUser'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ Role
                $tSQL   = " UPDATE
                                TCNMUsrActRole
                            SET
                                TCNMUsrActRole.FTRolCode = (	CASE WHEN ISNULL(TCNTImpMasTmp.FTRolCode,'') = '' THEN ( SELECT TOP 1 
                                                                    CASE 
                                                                        WHEN ISNULL(FTCfgStaUsrValue,'') = '' THEN FTCfgStaDefValue
                                                                        ELSE FTCfgStaUsrValue
                                                                    END AS FTRolCode
                                                                FROM TLKMConfig 
                                                                WHERE FTCfgCode = 'tLK_ImportDefRole') Else TCNTImpMasTmp.FTRolCode END )
                            FROM
                                TCNMUsrActRole
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMUsrActRole.FTUsrCode = TCNTImpMasTmp.FTUsrCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMUser'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);
                
                //อัพเดทรายการ TCNTUsrGroup
                $tSQL   = " UPDATE
                                TCNTUsrGroup
                            SET
                                TCNTUsrGroup.FTBchCode = TCNTImpMasTmp.FTBchCode, 
                                TCNTUsrGroup.FTShpCode = TCNTImpMasTmp.FTShpCode, 
                                TCNTUsrGroup.FTMerCode = TCNTImpMasTmp.FTMerCode,
                                TCNTUsrGroup.FTAgnCode = TCNTImpMasTmp.FTAgnCode,
                                TCNTUsrGroup.FDLastUpdOn = '$dDateOn',
                                TCNTUsrGroup.FTLastUpdBy = '$tUserBy'
                            FROM
                                TCNTUsrGroup
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNTUsrGroup.FTUsrCode = TCNTImpMasTmp.FTUsrCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMUser'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);
            }else if($tTypeCaseDuplicate == 1){
                //ใช้รายการใหม่

                //-------------------------ลบข้อมูลก่อน 

                //ลบข้อมูลในตาราง L
                $tSQLDelete = "DELETE FROM TCNMUser WHERE FTUsrCode IN (
                                    SELECT FTUsrCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMUser'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตารางจริง
                $tSQLDelete = "DELETE FROM TCNMUser_L WHERE FTUsrCode IN (
                                    SELECT FTUsrCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMUser'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง Role
                $tSQLDelete = "DELETE FROM TCNMUsrActRole WHERE FTUsrCode IN (
                                    SELECT FTUsrCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMUser'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง Role
                $tSQLDelete = "DELETE FROM TCNTUsrGroup WHERE FTUsrCode IN (
                                    SELECT FTUsrCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMUser'
                                )";
                $this->db->query($tSQLDelete);

                //-------------------------เพิ่มข้อมูลใหม่

                //เพิ่มข้อมูลลงตาราง USER
                $tSQL   = " INSERT INTO TCNMUser (
                                FTUsrCode,FTDptCode,FTUsrTel,FTUsrEmail,
                                FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy
                            )
                            SELECT 
                                IMP.FTUsrCode,
                                IMP.FTDptCode,
                                IMP.FTUsrTel,
                                IMP.FTUsrEmail,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง USER_L
                $tSQL   = " INSERT INTO TCNMUser_L (FTUsrCode,FNLngID,FTUsrName,FTUsrRmk)
                            SELECT 
                                IMP.FTUsrCode,
                                $nLngID,
                                IMP.FTUsrName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลตารางสิทธิ์ TCNMUsrActRole
                $tSQL   = " INSERT INTO TCNMUsrActRole (FTRolCode,FTUsrCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                            CASE
                                WHEN ISNULL(IMP.FTRolCode,'') = '' THEN (
                                        SELECT TOP 1 
                                            CASE 
                                                WHEN ISNULL(FTCfgStaUsrValue,'') = '' THEN FTCfgStaDefValue
                                                ELSE FTCfgStaUsrValue
                                            END AS FTRolCode
                                        FROM TLKMConfig 
                                        WHERE FTCfgCode = 'tLK_ImportDefRole'
                                    )
                                    ELSE IMP.FTRolCode
                                END AS FTRolCode,
                                IMP.FTUsrCode,
                                '$dDateOn' AS FDLastUpdOn,
                                '$tUserBy' AS FTLastUpdBy,
                                '$dDateOn' AS FDCreateOn,
                                '$tUserBy' AS FTCreateBy
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลตารางความสัมพันธ business TCNTUsrGroup
                $tSQL   = " INSERT INTO TCNTUsrGroup (
                                FTUsrCode , FTBchCode , FTShpCode , 
                                FTMerCode ,FTAgnCode , FDCreateOn , 
                                FTCreateBy , FDLastUpdOn , FTLastUpdBy
                            )
                            SELECT 
                                IMP.FTUsrCode,
                                IMP.FTBchCode,
                                IMP.FTShpCode,
                                IMP.FTMerCode,
                                IMP.FTAgnCode, 
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);
            }
            
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //ลบข้อมูลใน Temp หลังจาก move เสร็จแล้ว
    public function FSaMUSRImportMove2MasterDeleteTemp($paDataSearch){
        try{
            $tSessionID     = $paDataSearch['tSessionID'];
            $tTableKey      = $paDataSearch['tTableKey'];

            // ลบรายการใน Temp
            $this->db->where('FTSessionID', $tSessionID);
            $this->db->where('FTTmpTableKey', $tTableKey);
            $this->db->delete('TCNTImpMasTmp');
        }catch(Exception $Error) {
            return $Error;
        }
    }

    public function FSaMUSRGetTempDataAtAll(){
        try{
            $tSesSessionID = $this->session->userdata("tSesSessionID");
            $tSQL   = "SELECT TOP 1
                        (SELECT COUNT(FTTmpTableKey) AS TYPESIX FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMUser'
                        AND IMP.FTTmpStatus       = '6') AS TYPESIX ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMUser'
                        AND IMP.FTTmpStatus       = '1') AS TYPEONE ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMUser'
                        ) AS ITEMALL
                    FROM TCNTImpMasTmp ";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }catch(Exception $Error) {
            return $Error;
        }
    }





    //Functionality : Get User Login
    //Parameters : Get User Login
    //Creator : 27/08/2021 Off
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMUSRGetUserLoginDetail ($paDataSearch){
        $nLngID             = $paDataSearch['FNLngID'];
        $tWhere             = "";
        $tSearchDocDateFrom = $paDataSearch['dDateFrm'];
        $tSearchDocDateTo   = $paDataSearch['dDateTo'];

        if(!empty($paDataSearch['tUsrAgnCode'])){
            $tUsrAgnCode = $paDataSearch['tUsrAgnCode'];
            $tWhere     .=  " AND USRBCH.FTAgnCode = '$tUsrAgnCode' ";
        }
        if(!empty($paDataSearch['tUsrBchCode'])){
            $tUsrBchCode = $paDataSearch['tUsrBchCode'];
            $tWhere     .=  " AND USRBCH.FTBchCode = '$tUsrBchCode' ";
        }
        if(!empty($paDataSearch['tUsrShpCode'])){
            $tUsrShpCode = $paDataSearch['tUsrShpCode'];
            $tWhere     .=  " AND USRBCH.FTShpCode = '$tUsrShpCode' ";
        }
        if(!empty($paDataSearch['tUsrMerCode'])){
            $tUsrMerCode = $paDataSearch['tUsrMerCode'];
            $tWhere     .=  " AND USRBCH.FTMerCode = '$tUsrMerCode' ";
        }
        
        if(!empty($paDataSearch['dDateFrm']) && !empty($paDataSearch['dDateTo'])){
            $tWhere     .= " AND ((USR.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (USR.FDCreateOn BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        $tSQL      = " SELECT USRL.FTUsrName,
                              CASE WHEN USR.FTUsrEmail IS NULL THEN '-' WHEN USR.FTUsrEmail = '' THEN '-' ELSE USR.FTUsrEmail END AS FTUsrEmail,
                              CASE WHEN USR.FTUsrTel IS NULL THEN '-' WHEN USR.FTUsrTel = '' THEN '-' ELSE USR.FTUsrTel END AS FTUsrTel,
                              USR.FTUsrCode,
                              CASE WHEN AGNL.FTAgnName IS NULL THEN '-' ELSE AGNL.FTAgnName END AS FTAgnName,
                              CASE WHEN BCHL.FTBchName IS NULL THEN '-' ELSE BCHL.FTBchName END AS FTBchName,
                              UAR.FTRolCode,
                              RLE_L.FTRolName,
                              CASE WHEN MERL.FTMerName IS NULL THEN '-' ELSE MERL.FTMerName END AS FTMerName,
                              CASE WHEN SHPL.FTShpName IS NULL THEN '-' ELSE SHPL.FTShpName END AS FTShpName,
                              USR.FDCreateOn,
                              CASE WHEN DEP_L.FTDptName IS NULL THEN '-' ELSE DEP_L.FTDptName END AS FTDptName
                      FROM [TCNTUsrGroup] USRBCH WITH(NOLOCK)
                    LEFT JOIN [TCNMUser] USR WITH(NOLOCK) ON USR.FTUsrCode = USRBCH.FTUsrCode
                    LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON USRBCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON USRBCH.FTShpCode = SHPL.FTShpCode AND  USRBCH.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                    LEFT JOIN [TCNMMerchant_L] MERL WITH(NOLOCK) ON USRBCH.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                    LEFT JOIN [TCNMAgency_L] AGNL WITH(NOLOCK) ON USRBCH.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    LEFT JOIN [TCNMUser_L] USRL WITH(NOLOCK) ON USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    LEFT JOIN (
                                    SELECT A.FTUsrCode,ISNULL(R.FNRolLevel,0) AS FNRolLevel,A.FTRolCode FROM TCNMUsrActRole A WITH(NOLOCK)
                                    LEFT JOIN TCNMUsrRole R WITH(NOLOCK) ON A.FTRolCode = R.FTRolCode
                                ) UAR ON USR.FTUsrCode = UAR.FTUsrCode
                    LEFT JOIN TCNMUsrRole_L RLE_L WITH(NOLOCK) ON UAR.FTRolCode = RLE_L.FTRolCode AND RLE_L.FNLngID = $nLngID
                    LEFT JOIN TCNMUsrDepart_L DEP_L WITH(NOLOCK) ON USR.FTDptCode = DEP_L.FTDptCode AND DEP_L.FNLngID = $nLngID
                    WHERE 1=1
                    $tWhere
             ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail         = $oQuery->result_array();
                $tUsrDetailWhere = " AND USRLOG.FTUsrCode IN (";
                $aDetailList     = array();
                foreach($oDetail as $nKey => $aValue){
                    $aDetailList[$nKey] = $aValue['FTUsrCode'];
                }
                $tUsrDetailWhere .= implode(",",$aDetailList).")";

                $tSQLDetail      = " SELECT USRLOG.FTUsrCode,
                              USRL.FTUsrName,
                              USRLOG.FTUsrLogin,
                              USRLOG.FTUsrLoginPwd,
                              USRLOG.FDUsrPwdStart,
                              USRLOG.FDUsrPwdExpired,
                              CASE WHEN USRLOG.FTUsrLogType = '1' THEN 'Password' WHEN USRLOG.FTUsrLogType = '2' THEN 'Pin' WHEN USRLOG.FTUsrLogType = '3' THEN 'RFID' ELSE 'QR' END AS FTUsrLogType,
                              CASE WHEN USRLOG.FTUsrStaActive = '1' THEN 'ใช้งาน' WHEN USRLOG.FTUsrStaActive = '2' THEN 'ไม่ใช้งาน' ELSE 'เปลี่นรหัสผ่าน' END AS FTUsrStaActive
                      FROM [TCNMUsrLogin] USRLOG WITH(NOLOCK)
                    LEFT JOIN [TCNMUser_L] USRL WITH(NOLOCK) ON USRL.FTUsrCode = USRLOG.FTUsrCode AND USRL.FNLngID = $nLngID
                    WHERE 1=1
                    $tUsrDetailWhere
                ";

                $oQueryDetail   = $this->db->query($tSQLDetail);
                $oDetailUser    = $oQueryDetail->result_array();
                $aResult        = array(
                    'raItems'   => $oDetail,
                    'raItemsDetail'   => $oDetailUser,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //Not Found
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
    }

}





