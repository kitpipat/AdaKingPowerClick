<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mLogin extends CI_Model {

    public function FSaMLOGChkLogin($ptUsername,$ptPassword) {

        $tLang = $this->session->userdata("tLangID");

        $tSQL = "
            SELECT 
                AUT.FTUsrStaActive,
                AUT.FTUsrLogType,
                AUT.FTStaError,
                USR.* 
            FROM (
                SELECT 
                    FTUsrLogType,
                    FTUsrCode,
                    FTUsrStaActive,
                    CASE 
                        WHEN FTUsrLoginPwd != '$ptPassword' THEN '1' /*PASS FAIL*/
                        WHEN CONVERT(VARCHAR(10),GETDATE(),121) > CONVERT(VARCHAR(10),FDUsrPwdExpired,121) THEN '2' /*EXPIRED*/
                        WHEN CONVERT(VARCHAR(10),GETDATE(),121) < CONVERT(VARCHAR(10),FDUsrPwdStart,121) THEN '3' /*Not Started*/
                        WHEN FTUsrStaActive = '2' THEN '4' /*NOT ACTIVE*/
                        ELSE '0'
                    END AS FTStaError
                FROM TCNMUsrLogin 
                WHERE FTUsrLogin = '$ptUsername'
                /*AND FTUsrLoginPwd = '$ptPassword'
                  AND CONVERT(VARCHAR(10),FDUsrPwdStart,121) <= CONVERT(VARCHAR(10),GETDATE(),121) 
                  AND CONVERT(VARCHAR(10),FDUsrPwdExpired,121) >= CONVERT(VARCHAR(10),GETDATE(),121) 
                  AND FTUsrStaActive IN ('1','3')*/
            ) AUT
            INNER JOIN (
                SELECT 
                    TCNMUser.FTUsrCode, 
                    TCNMUser_L.FTUsrName,
                    TCNMUser.FTDptCode, 
                    TCNMUsrDepart_L.FTDptName, 
                    TCNMImgPerson.FTImgObj
                FROM TCNMUser 
                LEFT JOIN TCNMUser_L ON TCNMUser.FTUsrCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = $tLang 
                LEFT JOIN TCNMUsrDepart_L ON TCNMUsrDepart_L.FTDptCode = TCNMUser.FTDptCode AND TCNMUsrDepart_L.FNLngID = $tLang
                LEFT JOIN TCNMImgPerson ON TCNMUser.FTUsrCode = TCNMImgPerson.FTImgRefID AND TCNMImgPerson.FTImgTable = 'TCNMUser'
            ) USR ON AUT.FTUsrCode = USR.FTUsrCode
        ";
        // print_r($tSQL);exit;

        // $tSQL = "SELECT USR.* FROM (
        //             SELECT FTUsrCode 
        //             FROM  TCNMUsrLogin 
        //             WHERE FTUsrLogin    = '$ptUsername'
        //             AND   FTUsrLoginPwd = '$ptPassword'
        //             AND   CONVERT(VARCHAR(10),FDUsrPwdStart,121) <= CONVERT(VARCHAR(10),GETDATE(),121) 
        //             AND   CONVERT(VARCHAR(10),FDUsrPwdExpired,121) >= CONVERT(VARCHAR(10),GETDATE(),121) ) AUT
        //             INNER JOIN (
        //             SELECT TCNMUser.FTUsrCode, 
        //                 TCNMUser.FTDptCode, TCNMUsrDepart_L.FTDptName, 
        //                 TCNMUser.FTRolCode, TCNTUsrGroup.FTBchCode, 
        //                 TCNTUsrGroup.FTShpCode, TCNMBranch_L.FTBchName, TCNMImgPerson.FTImgObj ,
        //                 TCNMUser_L.FTUsrName, TCNMShop.FTMerCode, TCNMBranch.FTWahCode, TCNMWaHouse_L.FTWahName, TCNMMerchant_L.FTMerName, TCNMShop_L.FTShpName 
        //             FROM TCNMUser 
        //             LEFT JOIN TCNMUsrDepart_L ON TCNMUsrDepart_L.FTDptCode = TCNMUser.FTDptCode AND TCNMUsrDepart_L.FNLngID = $tLang 
        //             LEFT JOIN TCNTUsrGroup ON TCNTUsrGroup.FTUsrCode = TCNMUser.FTUsrCode 
        //             LEFT JOIN TCNMUser_L ON TCNMUser.FTUsrCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = $tLang 
        //             LEFT JOIN TCNMShop ON TCNTUsrGroup.FTShpCode = TCNMShop.FTShpCode AND TCNTUsrGroup.FTBchCode = TCNMShop.FTBchCode 
        //             LEFT JOIN TCNMShop_L ON TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode 
        //             LEFT JOIN TCNMBranch_L ON TCNTUsrGroup.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = $tLang 
        //             LEFT JOIN TCNMMerchant_L ON TCNMMerchant_L.FTMerCode = TCNMShop.FTMerCode AND TCNMMerchant_L.FNLngID = $tLang 
        //             --LEFT JOIN TCNMWaHouse_L ON TCNMWaHouse_L.FTWahCode = TCNMShop.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShop.FTBchCode AND TCNMWaHouse_L.FNLngID = 1 
        //             LEFT JOIN TCNMImgPerson ON TCNMUser.FTUsrCode = TCNMImgPerson.FTImgRefID AND TCNMImgPerson.FTImgTable = 'TCNMUser'
        //             LEFT JOIN TCNMBranch ON TCNTUsrGroup.FTBchCode = TCNMBranch.FTBchCode
	    //             LEFT JOIN TCNMWaHouse_L ON TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = $tLang
        //             ) USR ON AUT.FTUsrCode = USR.FTUsrCode
        // ";

        // print_r($tSQL);
        // exit();
        $oQuery = $this->db->query($tSQL);
        $oList = $oQuery->result_array();
        return $oList;
    }

    // Create By : Napat(Jame) 17/03/63
    // Last Update By : Napat(12/05/2020) เพิ่มการ join shop
    // เพิ่มการ left join เพื่อไปเอาชื่อสาขา
    public function FSaMLOGGetBch(){
        $tLang = $this->session->userdata("tLangID");
        $tSQL           = " SELECT TOP 1 
                                CMP.FTBchCode,
                                BCH_L.FTBchName,
                                SHP_L.FTShpCode,
                                SHP_L.FTShpName,
                                WAH_L.FTWahCode,
	                            WAH_L.FTWahName
                            FROM TCNMComp CMP WITH(NOLOCK)
                            LEFT JOIN TCNMBranch        BCH     ON CMP.FTBchcode = BCH.FTBchCode
                            LEFT JOIN TCNMBranch_L      BCH_L   ON CMP.FTBchcode = BCH_L.FTBchCode AND BCH_L.FNLngID = $tLang
                            LEFT JOIN TCNMShop_L        SHP_L   ON CMP.FTBchcode = SHP_L.FTBchCode AND SHP_L.FNLngID = $tLang
                            LEFT JOIN TCNMWaHouse_L     WAH_L   ON BCH.FTWahCode = WAH_L.FTWahCode AND CMP.FTBchCode = WAH_L.FTBchCode AND WAH_L.FNLngID = $tLang 
                          ";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }


    //Nattakit Nale 23/04/63
    //ดึงสาขาของผู้ใช้
    public function FSaMLOGGetUsrBch($ptUserCode){
        $tLang = $this->session->userdata("tLangID");
        $tSQL           = " SELECT DISTINCT
                                UBCH.FTUsrCode,
                                UBCH.FTBchCode,
                                BCHL.FTBchName
                            FROM
                                TCNTUsrBch UBCH
                            LEFT JOIN TCNMBranch_L BCHL ON UBCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $tLang
                            WHERE UBCH.FTUsrCode = '$ptUserCode'
                                
                          ";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }

    //Nattakit Nale 23/04/63
    //จัดสตริงจากอาเรย์
    public function FStMLOGMakeArrayToStringUsrBch($paUsrBch,$nType){

        $tUsrBchCode = '';
        $tUsrBchName = '';
            if(!empty($paUsrBch)){
                  $nSumRowsUsrBch = FCNnHSizeOf($paUsrBch);
                  $nNo = 1;
                  $tUsrBchCode.="'";
                  foreach($paUsrBch as $bK => $aVal){
                            $tUsrBchCode.=$aVal['FTBchCode'];
                            $tUsrBchName.=$aVal['FTBchName'];
                            if($nSumRowsUsrBch!=$nNo){
                                $tUsrBchCode.="','";  
                                $tUsrBchName.=",";
                            }
                            $nNo++;
                  }
                  $tUsrBchCode.="'";
            }

            if($nType==1){
                $aResult = $tUsrBchCode;
            }else{
                $aResult = $tUsrBchName;
            }

            return $aResult;
    }


    //Witsarut  27/04/63
    //ดึงร้านค้าของผู้ใช้
    // public function FSaMLOGGetUsrBchShp($ptUserCode){
    //     $tLang = $this->session->userdata("tLangID");
    //     $tSQL           = " SELECT DISTINCT
    //                             UBCH.FTUsrCode,
    //                             UBCH.FTShpCode,
    //                             SHPL.FTShpName
    //                         FROM
    //                             TCNTUsrBch UBCH
    //                             LEFT JOIN TCNMShop_L SHPL ON UBCH.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID=$tLang
    //                             WHERE UBCH.FTUsrCode = '$ptUserCode'
                                
    //                       ";
    //     $oQuery         = $this->db->query($tSQL);
    //     $oList          = $oQuery->result_array();
    //     return $oList;

    // }

    //Witsarut  27/04/63
    //จัดสตริงจากอาเรย์
    public function FStMLOGMakeArrayToStringUsrBchShp($paUsrShp,$nType){
        $tUsrShpCode = '';
        $tUsrShpName = '';
            if(!empty($paUsrShp)){
                    $nSumRowsUsrShp = FCNnHSizeOf($paUsrShp);
                    $nNo = 1;
                    $tUsrShpCode.="'";
                    foreach($paUsrShp as $bK => $aVal){
                            $tUsrShpCode.=$aVal['FTShpCode'];
                            $tUsrShpName.=$aVal['FTShpName'];
                            if($nSumRowsUsrShp!=$nNo){
                                $tUsrShpCode.="','";  
                                $tUsrShpName.=",";
                            }
                            $nNo++;
                    }
                    $tUsrShpCode.="'";
            }
        if($nType==1){
            $aResult = $tUsrShpCode;
        }else{
            $aResult = $tUsrShpName;
        }

        return $aResult;
    }

    // Last Update : Napat(Jame) 17/08/2020 ดึงสาขามาจาก Agn ทั้งหมด
    // Last Update : Napat(Jame) 02/11/2020 เพิ่ม FTUsrLevel เพื่อนำไปใช้หน้าจอ ผู้ใช้
    public function FSaMLOGGetDataUserLoginGroup($ptUsrCode){
        $tLang = $this->session->userdata("tLangID");
        $tSQL  = "  SELECT DISTINCT
                        USG.FTUsrCode       AS FTUsrCode,
                        USG.FTAgnCode       AS FTAgnCode,
                        AGNL.FTAgnName      AS FTAgnName,
                        -- CASE 
                        --     WHEN ISNULL(BCH.FTBchCode,'') = '' AND ISNULL(USG.FTAgnCode, '') != '' THEN 'PHP99' 
                        --     ELSE BCH.FTBchCode 
                        -- END AS FTBchCode,
                        -- CASE 
                        --     WHEN ISNULL(BCHL.FTBchName,'') = '' AND ISNULL(USG.FTAgnCode, '') != '' THEN '' 
                        --     ELSE BCHL.FTBchName
                        -- END AS FTBchName,
                        BCH.FTBchCode       AS FTBchCode,
                        BCHL.FTBchName      AS FTBchName,
                        USG.FTShpCode       AS FTShpCode,
                        SHPL.FTShpName      AS FTShpName,
                        USG.FTMerCode       AS FTMerCode,
                        MERL.FTMerName      AS FTMerName,
                        WAHL.FTWahCode      AS FTWahCode,
                        WAHL.FTWahName      AS FTWahName,
                        CASE 
                            WHEN ISNULL(USG.FTAgnCode,'') != '' AND ISNULL(USG.FTBchCode,'')  = '' AND ISNULL(USG.FTMerCode,'')  = '' AND ISNULL(USG.FTShpCode,'')  = '' THEN 'AGN'
                            WHEN ISNULL(USG.FTBchCode,'') != '' AND ISNULL(USG.FTMerCode,'')  = '' AND ISNULL(USG.FTShpCode,'')  = '' THEN 'BCH' 
                            WHEN ISNULL(USG.FTBchCode,'') != '' AND ISNULL(USG.FTMerCode,'') != '' AND ISNULL(USG.FTShpCode,'')  = '' THEN 'MER'
                            WHEN ISNULL(USG.FTBchCode,'') != '' AND ISNULL(USG.FTMerCode,'') != '' AND ISNULL(USG.FTShpCode,'') != '' THEN 'SHP'
                            ELSE 'HQ'
                        END AS FTLoginLevel,
                        CASE 
                            WHEN ISNULL(USG.FTAgnCode,'') != '' THEN '1'
                            ELSE '0'
                        END AS FTStaLoginAgn
                    FROM TCNTUsrGroup USG WITH(NOLOCK)
                    /* 
                       ถ้าเป็น User AD ให้ Where ด้วย FTAgnCode (จะดึงสาขาทั้งหมดภายใต้ AD)
                       ถ้าเป็น User AD Bch ให้ Where ด้วย FTBchCode (จะดึงเฉพาะสาขาที่กำหนดในหน้าจอผู้ใช้)
                       ถ้าเป็น User Bch ให้ Where ด้วย FTBchCode (จะดึงเฉพาะสาขาที่กำหนดในหน้าจอผู้ใช้)
                    */
                    LEFT JOIN TCNMBranch		BCH  WITH(NOLOCK) ON 
                        CASE 
                            WHEN ISNULL(USG.FTAgnCode,'') != '' AND ISNULL(USG.FTBchCode,'') != '' THEN USG.FTBchCode 
                            WHEN ISNULL(USG.FTAgnCode,'') != '' AND ISNULL(USG.FTBchCode,'')  = '' THEN USG.FTAgnCode 
                            ELSE USG.FTBchCode
                        END 
                            = 
                        CASE 
                            WHEN ISNULL(USG.FTAgnCode,'') != '' AND ISNULL(USG.FTBchCode,'') != '' THEN BCH.FTBchCode 
                            WHEN ISNULL(USG.FTAgnCode,'') != '' AND ISNULL(USG.FTBchCode,'')  = '' THEN BCH.FTAgnCode 
                            ELSE BCH.FTBchCode
                        END
                    LEFT JOIN TCNMBranch_L      BCHL WITH(NOLOCK) ON BCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $tLang
                    LEFT JOIN TCNMAgency_L      AGNL WITH(NOLOCK) ON USG.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $tLang
                    LEFT JOIN TCNMShop_L        SHPL WITH(NOLOCK) ON USG.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = $tLang
                    LEFT JOIN TCNMMerchant_L    MERL WITH(NOLOCK) ON USG.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $tLang
                    LEFT JOIN TCNMWaHouse_L     WAHL WITH(NOLOCK) ON BCH.FTWahCode = WAHL.FTWahCode AND BCH.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $tLang
                    WHERE USG.FTUsrCode = '$ptUsrCode'
                    ORDER BY FTMerCode ASC, FTBchCode ASC, FTShpCode ASC
                 ";
        // $tSQL  = "   SELECT
        //                 USG.FTUsrCode       AS FTUsrCode,
        //                 USG.FTAgnCode       AS FTAgnCode,
        //                 AGNL.FTAgnName      AS FTAgnName,
        //                 USG.FTBchCode       AS FTBchCode,
        //                 BCHL.FTBchName      AS FTBchName,
        //                 USG.FTShpCode       AS FTShpCode,
        //                 SHPL.FTShpName      AS FTShpName,
        //                 USG.FTMerCode       AS FTMerCode,
        //                 MERL.FTMerName      AS FTMerName,
        //                 WAHL.FTWahCode      AS FTWahCode,
        //                 WAHL.FTWahName      AS FTWahName
        //             FROM TCNTUsrGroup USG WITH(NOLOCK)
        //             LEFT JOIN TCNMBranch        BCH  ON USG.FTBchCode = BCH.FTBchCode
        //             LEFT JOIN TCNMBranch_L      BCHL ON USG.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $tLang
        //             LEFT JOIN TCNMShop_L        SHPL ON USG.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = $tLang
        //             LEFT JOIN TCNMMerchant_L    MERL ON USG.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $tLang
        //             LEFT JOIN TCNMAgency_L      AGNL ON USG.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $tLang
        //             LEFT JOIN TCNMWaHouse_L     WAHL ON BCH.FTWahCode = WAHL.FTWahCode AND USG.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $tLang
        //             WHERE USG.FTUsrCode = '$ptUsrCode'
        //             ORDER BY FTMerCode ASC, FTBchCode ASC, FTShpCode ASC
        //          ";
        // echo $tSQL;exit;
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    public function FStMLOGMakeArrayToString($paDataUsr,$ptField,$ptType){
        $nCountData     = 0;
        $tData          = '';
        if(!empty($paDataUsr)){
            $tData      .= "'";
            for($i=0;$i < FCNnHSizeOf($paDataUsr);$i++){
                if(!empty($paDataUsr[$i][$ptField])){
                    if(strpos($tData, $paDataUsr[$i][$ptField]) !== 1){
                        if($i != 0){
                            $tData .= "','";
                        }
                        $tData .= $paDataUsr[$i][$ptField];
                        $nCountData++;
                    }
                }
            }
            $tData .= "'";

            if($nCountData == 0){
                $tData = "";   
            }
        }
        
        if($ptType == 'counts'){
            return $nCountData;
        }else{
            return $tData;
        }
    }

    // Create By Napat(Jame) 11/06/2020
    // Get Data User Role
    public function FSaMLOGGetUserRole($ptUsrCode){
        $tLang = $this->session->userdata("tLangID");
        $tSQL  = "   SELECT 
                        FTRolCode,
                        FTUsrCode 
                    FROM TCNMUsrActRole WITH(NOLOCK) 
                    WHERE FTUsrCode = '$ptUsrCode'
                 ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    // Create By : Napat(Jame) 29/07/2020
    public function FSaMLOGExecuteScript($ptSQL){
        try{
            $oQuery = $this->db->query($ptSQL);
            $aDataReturn = array(
                'tSQL'          => $ptSQL,
                'nStaQuery'     => 1,
                'tStaMessage'   => $this->db->error()
            );
        }catch(Exception $e) {
            $aDataReturn = array(
                'nStaQuery'	    => 500,
                'tStaMessage'	=> $e
            );
        }
        return $aDataReturn;
    }

    // Create By Napat(Jame) 13/08/2020
    // Get Data User Role Level
    public function FSaMLOGGetUserRoleLevel($ptUsrRoleMulti){
        $tLang = $this->session->userdata("tLangID");
        $tSQL  = "   SELECT
                        MAX(FNRolLevel) AS FNRolLevel
                    FROM TCNMUsrRole WITH(NOLOCK)
                    WHERE FTRolCode IN ($ptUsrRoleMulti)
                 ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array()[0]['FNRolLevel'];
    }

    public function FSaMLOGGetUserName($ptTextFilter){
        $tLang = $this->session->userdata("tLangID");
        $tSQL  = "SELECT TOP 8 USR.FTUsrCode,USRL.FTUsrName,IMG.FTImgObj from TCNMUser USR
                    LEFT JOIN TCNMUser_L USRL ON  USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $tLang
                    LEFT JOIN TCNMImgPerson IMG ON  USR.FTUsrCode = IMG.FTImgRefID AND IMG.FTImgTable = 'TCNMUser'
                    WHERE 1 = 1
                ";
        if($ptTextFilter != ''){
        $tSQL .= "AND USR.FTUsrCode = '$ptTextFilter'
                  OR USRL.FTUsrName like '%$ptTextFilter%'";
        }
    
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }

    public function FSaMLOGGetUsrLogin($ptUsrCode,$ptPassword){
        $tSQL   = " SELECT USRLOG.FTUsrCode, 
                           USRLOG.FTUsrLogType, 
                           USRLOG.FTUsrLogin
                    FROM TCNMUsrLogin USRLOG WITH(NOLOCK)
                    WHERE USRLOG.FTUsrLogType = 2
                    AND USRLOG.FTUsrCode = '$ptUsrCode'
                    AND USRLOG.FTUsrLoginPwd = '$ptPassword'";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aListData  = $oQuery->result_array();
            $aResult = array(
                'raItems'       => $aListData,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        return $aResult;
    }


    public function FSaMLOGGetUsrNameAndImg($ptUsrCode){
        $tLang = $this->session->userdata("tLangID");
        $tSQL   = "SELECT USR.FTUsrCode,USRL.FTUsrName,IMG.FTImgObj from TCNMUser USR
                    LEFT JOIN TCNMUser_L USRL ON  USR.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $tLang
                    LEFT JOIN TCNMImgPerson IMG ON  USR.FTUsrCode = IMG.FTImgRefID AND IMG.FTImgTable = 'TCNMUser'
                    WHERE USR.FTUsrCode = '$ptUsrCode'";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aListData  = $oQuery->result_array();
            $aResult = array(
                'raItems'       => $aListData,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    // Create By Napat(Jame) 07/01/2020
    // Get Data User Role Chain
    public function FSaMLOGGetUserRoleChain($paData){

        $tUsrRoleMulti  = $paData['tUsrRoleMulti'];
        $tWhere         = "";
        $tWhereUnion    = "";

        if( $paData['tLoginLevel'] != "HQ" ){
            $tAgnCode = $paData['tAgnCode'];
            $tBchCode = $paData['tBchCodeMulti'];
            if( $paData['tLoginLevel'] == "AGN" ){
                $tWhere         = " AND ( RSPC.FTAgnCode = '$tAgnCode' OR RSPC.FTRolCode IS NULL ) ";
                $tWhereUnion    = " AND FTAgnCode = '$tAgnCode' ";
            }else if( $paData['tLoginLevel'] == "BCH" ){
                $tWhere         = " AND ( RSPC.FTAgnCode = '$tAgnCode' AND ( ISNULL(RSPC.FTBchCode,'') = '' OR RSPC.FTBchCode IN ($tBchCode) ) OR RSPC.FTRolCode IS NULL )";
                $tWhereUnion    = " AND FTAgnCode = '$tAgnCode' AND FTBchCode IN ($tBchCode) ";
            }
        }

        // สิทธิ์ที่ได้รับ + สิทธิ์ที่อยู่ภายใต้ตนเอง
        $tSQL  = "  SELECT DISTINCT
                        RCH.FTRolCode
                    FROM TCNMUsrRoleChain       RCH  WITH(NOLOCK)
                    LEFT JOIN TCNMUsrRoleSpc    RSPC WITH(NOLOCK) ON RCH.FTRolCode = RSPC.FTRolCode
                    WHERE RCH.FTRolChain IN ($tUsrRoleMulti)
                      AND RCH.FNRolType = 2
                      $tWhere
                 ";

        $tSQL .= " UNION ";

        // สิทธิ์ Spc Ad , Bch ของตนเอง
        $tSQL .= " SELECT DISTINCT
                        FTRolCode 
                    FROM TCNMUsrRoleSpc WITH(NOLOCK) 
                    WHERE 1=1 
                        $tWhereUnion
                 ";

        // echo $tSQL; exit;
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

}





