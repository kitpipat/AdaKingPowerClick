<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mMenu extends CI_Model {

    //Function : Get Menu Module
    //creater : Krit(Copter)
    //edit : 19/03/2019 Krit(Copter)
    public function FSaMMENUGetMenuGrpModulesName($tUsrID,$pnLngID){

        if( $this->session->userdata("bSesAlwNews") === TRUE || $this->session->userdata("bSesAlwNoti") === TRUE ){
            $tAlwGrpName = ",'NEW'";
        }else{
            $tAlwGrpName = "";
        }

        $tSQL   = " SELECT
                        TSM.FTGmnModCode,
                        TSM.FNGmnModShwSeq,
                        TSM.FTGmnModStaUse,
                        TSM.FTGmmModPathIcon,
                        TSM.FTGmmModColorBtn,
                        TSM_L.FTGmnModName
                    FROM TSysMenuGrpModule TSM
                    LEFT JOIN TSysMenuGrpModule_L TSM_L ON TSM.FTGmnModCode = TSM_L.FTGmnModCode AND TSM_L.FNLngID = $pnLngID 
                    INNER JOIN (	
                        SELECT MENULIST.FTGmnModCode FROM TCNTUsrMenu MENU
                        INNER JOIN TCNMUsrActRole ACT ON MENU.FTRolCode = ACT.FTRolCode
                        INNER JOIN TSysMenuList MENULIST ON MENU.FTGmnCode = MENULIST.FTGmnCode
                                                        AND MENU.FTMnuParent = MENULIST.FTMnuParent
                                                        AND MENU.FTMnuCode = MENULIST.FTMnuCode
                                                        AND MENULIST.FTMnuStaUse = 1
                        WHERE ACT.FTUsrCode = '$tUsrID' AND MENU.FTAutStaRead = 1
                        GROUP BY MENULIST.FTGmnModCode ) MENUROLE ON MENUROLE.FTGmnModCode = TSM.FTGmnModCode
                    WHERE TSM.FTGmmModPathIcon != '' AND FTGmnModStaUse = 1

                    UNION ALL

                    SELECT 
                        TSM.FTGmnModCode, 
                        TSM.FNGmnModShwSeq, 
                        TSM.FTGmnModStaUse, 
                        TSM.FTGmmModPathIcon, 
                        TSM.FTGmmModColorBtn, 
                        TSM_L.FTGmnModName
                    FROM TSysMenuGrpModule TSM
                    LEFT JOIN TSysMenuGrpModule_L TSM_L ON TSM.FTGmnModCode = TSM_L.FTGmnModCode AND TSM_L.FNLngID = 1
                    WHERE TSM.FTGmmModPathIcon != '' AND TSM.FTGmnModStaUse = 1 AND TSM.FTGmnModCode IN ('FAV'$tAlwGrpName) 

                    ORDER BY TSM.FNGmnModShwSeq ASC ";
        // echo $tSQL;exit;
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        }else{
            return false;
        }
    }       

    // Function : GetDataMenu
    public function FSoMMENUGetMenuList($tUsrID,$pnLngID,$ptCstKey){

        $tOpenKey  = " OPEN SYMMETRIC KEY AdaLicProtectSmtKey DECRYPTION BY CERTIFICATE AdaLicProtectCer ";
        $tCloseKey = " CLOSE SYMMETRIC KEY AdaLicProtectSmtKey ";

        // ตรวจสอบว่ามี รายงานพิเศษไหม
        $bStaRptSpc         = false;
        $tUsrLoginLevel     = $this->session->userdata("tSesUsrLoginLevel");
        $bIsHaveAgn         = $this->session->userdata("bIsHaveAgn");
        $tUsrAgnCode        = $this->session->userdata("tSesUsrAgnCode");
        $tUsrBchCodeMulti   = $this->session->userdata("tSesUsrBchCodeMulti");
        $tUsrMerCode        = $this->session->userdata("tSesUsrMerCode");
        $tUsrShpCodeMulti   = $this->session->userdata("tSesUsrShpCodeMulti");
        $tSQLChkRptSpc = "  SELECT TOP 1 RSPC.FTRptCode 
                            FROM TCNSRptSpc RSPC WITH(NOLOCK)
                            WHERE 1=1 AND RSPC.FTRptStaActive = '1' AND ISNULL(RSPC.FTRolCode,'') = ''
                         ";
                         
        if( $tUsrLoginLevel != "HQ" ){
            if( $bIsHaveAgn ){ 
                $tSQLChkRptSpc .= " AND RSPC.FTAgnCode = '$tUsrAgnCode' ";
            }else{
                $tSQLChkRptSpc .= " AND ISNULL(RSPC.FTAgnCode,'') = '' ";
            }

            if( $tUsrLoginLevel == "BCH" || $tUsrLoginLevel == "SHP" ){
                $tSQLChkRptSpc .= " AND ( RSPC.FTBchCode IN ($tUsrBchCodeMulti) OR ( ISNULL(RSPC.FTBchCode,'') = '' ) ) ";
            }

            if( $tUsrMerCode != "" ){
                $tSQLChkRptSpc .= " AND ( RSPC.FTMerCode = '$tUsrMerCode' OR ( ISNULL(RSPC.FTMerCode,'') = '' ) ) ";
            }

            if( $tUsrLoginLevel == "SHP" ){
                $tSQLChkRptSpc .= " AND ( RSPC.FTShpCode IN ($tUsrShpCodeMulti) OR ( ISNULL(RSPC.FTShpCode,'') = '' ) ) ";
            }
        }

        $oQueryChkRptSpc = $this->db->query($tSQLChkRptSpc);
        if ( $oQueryChkRptSpc->num_rows() > 0 ){
            // ตรวจสอบวันหมดอายุของแพ็คเพจหลัก
            $bStaRptSpc  = true;
        }

        $tSQLChkExpPkg  = $tOpenKey;
        $tSQLChkExpPkg .= " SELECT 
                                PARSENAME( REPLACE(CONVERT(VARCHAR(MAX), DecryptByKey(FTKeyByPdt)),';','.'),1) AS FTLicStartFinish
                            FROM TRGTCstKey WITH(NOLOCK)
                            WHERE FTCstKey = '$ptCstKey'
                            AND FNLicUUIDSeq = 0
                            AND LEFT(FTKeyRefPdt,3) = 'PKG'
                            ";
        $tSQLChkExpPkg .= $tCloseKey;
        $oQueryChkExpPkg = $this->db->query($tSQLChkExpPkg);
        // echo $this->db->last_query();exit;
        if ( $oQueryChkExpPkg->num_rows() > 0 ){
            $dDateExpPkg = $oQueryChkExpPkg->result_array()[0]['FTLicStartFinish'];
        }else{
            $dDateExpPkg = date('Y-m-d');
        }
       
        $tRoleCode = $this->session->userdata("tSesUsrRoleCodeMulti");
        $tSQL  = "";
        $tSQL .= $tOpenKey;
        $tSQL .= "  SELECT  
                        MenuGrpModule.FNGmnModShwSeq,
                        MENUGRP.FNGmnShwSeq,
                        USR.FTUsrCode, 
                        MENULIST.FTGmnModCode, 
                        MenuGrpModule_L.FTGmnModName, 
                        USRMENU.FTGmnCode, 
                        MENUGRP_L.FTGmnName, 
                        USRMENU.FTMnuParent, 
                        USRMENU.FTMnuCode, 
                        MENULIST_L.FTMnuName, 
                        MENULIST.FNMnuSeq, 
                        MENULIST.FNMnuLevel, 
                        MENULIST.FTMnuCtlName, 
                        MAC.FNCounts,
                        USRMENU.FTAutStaFull, 
                        USRMENU.FTAutStaRead,
                        ML.FTLicStartFinish
                    FROM TCNMUser USR WITH(NOLOCK)
                    LEFT JOIN ( 
                        SELECT DISTINCT 
                            USRMENUSUB.FTGmnCode, 
                            USRMENUSUB.FTMnuParent, 
                            USRMENUSUB.FTMnuCode,
                            MAX(USRMENUSUB.FTAutStaFull) AS FTAutStaFull, 
			                MAX(USRMENUSUB.FTAutStaRead) AS FTAutStaRead,  
                            '$tUsrID' AS UsrCode  
                        FROM TCNTUsrMenu USRMENUSUB WITH(NOLOCK)
                        WHERE USRMENUSUB.FTRolCode IN($tRoleCode)
                        GROUP BY USRMENUSUB.FTGmnCode,USRMENUSUB.FTMnuParent,USRMENUSUB.FTMnuCode
                    ) USRMENU ON USRMENU.UsrCode = USR.FTUsrCode
                    INNER JOIN TSysMenuList MENULIST WITH(NOLOCK) ON USRMENU.FTGmnCode = MENULIST.FTGmnCode
                        AND USRMENU.FTMnuParent = MENULIST.FTMnuParent
                        AND USRMENU.FTMnuCode = MENULIST.FTMnuCode
                        AND MENULIST.FTMnuStaUse = 1
                    LEFT JOIN TSysMenuList_L MENULIST_L WITH(NOLOCK) ON MENULIST.FTMnuCode = MENULIST_L.FTMnuCode AND MENULIST_L.FNLngID = $pnLngID
                    LEFT JOIN TSysMenuGrpModule MenuGrpModule WITH(NOLOCK) ON MENULIST.FTGmnModCode = MenuGrpModule.FTGmnModCode
                    LEFT JOIN TSysMenuGrpModule_L MenuGrpModule_L WITH(NOLOCK) ON MenuGrpModule.FTGmnModCode = MenuGrpModule_L.FTGmnModCode AND MenuGrpModule_L.FNLngID = $pnLngID
                    LEFT JOIN TSysMenuGrp MENUGRP WITH(NOLOCK) ON USRMENU.FTGmnCode = MENUGRP.FTGmnCode AND MenuGrpModule_L.FTGmnModCode = MENUGRP.FTGmnModCode
                    LEFT JOIN TSysMenuGrp_L MENUGRP_L WITH(NOLOCK) ON MENUGRP.FTGmnCode = MENUGRP_L.FTGmnCode AND MENUGRP_L.FNLngID = $pnLngID
                    LEFT JOIN (
                        SELECT MEU.FTMnuParent, 
                                COUNT(DT.FTAutStaRead) AS FNCounts
                        FROM TCNTUsrMenu DT WITH(NOLOCK)
                        LEFT JOIN TSysMenuList MEU WITH(NOLOCK) ON DT.FTMnuCode = MEU.FTMnuCode AND (DT.FTAutStaRead = '1' OR DT.FTAutStaFull = 1)
                        GROUP BY MEU.FTMnuParent
                    ) AS MAC ON USRMENU.FTMnuCode = MAC.FTMnuParent
                    LEFT JOIN (
                        /* เมนู */
                        SELECT DISTINCT
                            MAX(MNU.FTCstKey) AS FTCstKey,
                            MNU.FTMnuCode,
                            MAX(MNU.FTLicStartFinish) AS FTLicStartFinish 
                        FROM (
                            SELECT DISTINCT
                                (SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),4) ) AS FTCstKey,
                                (SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),3) ) AS FTMnuCode,
                                (SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),1) ) AS FTLicStartFinish
                            FROM TRGSMenuLic WITH(NOLOCK)
                            WHERE (SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),4) ) = '$ptCstKey'
                                AND LEFT((SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),3) ),3) != 'RPT'
                        ) MNU
                        GROUP BY MNU.FTMnuCode

                        UNION
                        /* รายงาน */
                        SELECT DISTINCT
                            MAX(RPT.FTCstKey) AS FTCstKey,
                            RPT.FTMnuCode,
                            MAX(RPT.FTLicStartFinish) AS FTLicStartFinish 
                        FROM (
                            SELECT DISTINCT
                                (SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),4) ) AS FTCstKey,
                                'RPT' + LEFT(FTLicPdtCode,3) AS FTMnuCode,
                                (SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),1) ) AS FTLicStartFinish
                            FROM TRGSFuncDTLic WITH(NOLOCK) 
                            WHERE (SELECT PARSENAME( REPLACE(CONVERT(varchar(MAX), DecryptByKey(FTLicStartFinish)),';','.'),4) ) = '$ptCstKey'
                        ) RPT
                        GROUP BY RPT.FTMnuCode
                    ) ML ON ML.FTMnuCode = MENULIST.FTLicPdtCode
                    WHERE 1 = 1
                        AND (USRMENU.FTAutStaRead = '1' OR USRMENU.FTAutStaFull = '1') 
                 ";

        if(isset($tUsrID) && !empty($tUsrID)) {
            $tSQL .= " AND USR.FTUsrCode = '$tUsrID' ";
        }
    
        if( isset($bStaRptSpc) && !empty($bStaRptSpc) && $bStaRptSpc ){

            if($this->session->userdata("tLangID") == 1){
                $tLangReportSPC = 'รายงานพิเศษ';
            }else if($this->session->userdata("tLangID") == 2){
                $tLangReportSPC = 'Report Special';
            }else{
                $tLangReportSPC = 'รายงานพิเศษ';
            }

            $tSQL .= " UNION SELECT 10,NULL,'$tUsrID','RPT','รายงาน','RPT',NULL,'RPT','RPTSPC','$tLangReportSPC','99','0','rptReport/SPC/0/0',NULL,'1','1','$dDateExpPkg' ";
        }

        if($this->session->userdata("bSesAlwNoti")){
            $tSQL .= " UNION SELECT 13,NULL,'$tUsrID','NEW','การจัดการข่าวสาร','NEW',NULL,'NEW','NEW002','ประวัติการแจ้งเตือน','2','0','mntDocSta/2',NULL,'1','1','9999-01-01' ";
        }

        if($this->session->userdata("bSesAlwNews")){
            $tSQL .= " UNION SELECT 13,NULL,'$tUsrID','NEW','การจัดการข่าวสาร','NEW',NULL,'NEW','NEW001','การจัดการข่าวสาร','1','0','news/0/0',NULL,'1','1','9999-01-01' ";
            $tSQL .= " UNION SELECT 13,NULL,'$tUsrID','NEW','การจัดการข่าวสาร','NEW',NULL,'NEW','NEW003','ประวัติข่าวสาร','3','0','mntNewSta/2',NULL,'1','1','9999-01-01' ";
        }

        $tSQL .= "  ORDER BY
                    MenuGrpModule.FNGmnModShwSeq ASC, 
                    MENUGRP.FNGmnShwSeq ASC,  
                    MENULIST.FNMnuSeq ASC ";

        $tSQL .= $tCloseKey;

        // print_r('<pre>');
        // print_r($tSQL);
        // print_r('</pre>'); 
        // exit;        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
                //No Data
            return false;
        }
    }

    //Function : Get HQ Branch ตามโครงสร้าง User
    //creater : 11/01/2021 Napat(Jame)
    public function FStMMENUGetBranchHQ(){

        $tSesUserCode = $this->session->userdata("tSesUserCode");
        $tSesUsrLevel = $this->session->userdata("tSesUsrLevel");

        // ถ้าเป็น HQ ให้ใช้สาขา HQ จาก Company ได้เลย
        if( $tSesUsrLevel != "HQ" ){
            // หา CstKey ของ User HQ
            $tSQLHQ = " SELECT DISTINCT FTUsrCode,FTUsrRefInt 
                        FROM TCNMUser WITH(NOLOCK)
                        WHERE FTUsrCode IN (
                                SELECT FTUsrCode FROM TCNTUsrGroup WITH(NOLOCK)
                                WHERE ISNULL(FTAgnCode,'') = '' AND ISNULL(FTBchCode,'') = '' AND ISNULL(FTShpCode,'') = '' AND ISNULL(FTMerCode,'') = ''
                            )
                            AND ISNULL(FTUsrRefInt,'') != ''
                    ";
            $oQueryHQ   = $this->db->query($tSQLHQ);
            // echo $this->db->last_query();
            $aResultHQ  = $oQueryHQ->result_array();
            //เนล เพิ่ม Check ว่าง
            if(!empty($aResultHQ)){
                $tUsrRefInt = $aResultHQ[0]['FTUsrRefInt'];
            }else{
                $tUsrRefInt = '';
            }
            // หา CstKey ของ User Login
            $tSQLLogIn = "  SELECT DISTINCT FTUsrCode,FTUsrRefInt 
                            FROM TCNMUser WITH(NOLOCK)
                            WHERE FTUsrCode = '$tSesUserCode'
                        ";
            $oQueryLogIn    = $this->db->query($tSQLLogIn);
            // echo $this->db->last_query();
            $aResultLogIn   = $oQueryLogIn->result_array();

            // ตรวจสอบ CstKey Login กับ CstKey HQ ตรงกันไหม ?
            // - ถ้าตรงกันให้ใช้ สาขา HQ ของ Comp
            // - ถ้าไม่ตรงกันใช้ สาขา HQ ของ AD
            
            if( $aResultLogIn[0]['FTUsrRefInt'] == $tUsrRefInt  ){
                $tWhere     = " AND HQBCH.FTBchType <> '4' ";
            }else{
                $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");
                $tWhere     = " AND HQBCH.FTAgnCode = '$tAgnCode' AND HQBCH.FTBchType = '4' ";
            }
        }else{
            $tWhere     = " AND HQBCH.FTBchType <> '4' ";
        }

        $tSQL   = " SELECT TOP 1 HQBCH.FTBchCode 
                    FROM TCNMBranch HQBCH WITH(NOLOCK) 
                    WHERE HQBCH.FTBchStaHQ = '1'
                    $tWhere
                  ";
        // echo $tSQL; exit;
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        if( $oQuery->num_rows() > 0 ){
            $tResult = $oQuery->result_array()[0]['FTBchCode'];
        }else{
            // ถ้าหาสาขาสำนักงานใหญ่ไม่เจอให้ดึง สาขา Default ไปใช้งานแทน
            $tResult = $this->session->userdata("tSesUsrBchCodeDefault");
        }
        // echo $tResult;exit;
        return $tResult;
    }  

    //Function : เอาสาขา HQBch มาตรวจสอบTRGTLicKey
    //creater : 12/01/2021 Napat(Jame)
    public function FSaMMENUCheckLicense($ptHQBch){
        $tSQL  = "";
        $tSQL .= "  OPEN SYMMETRIC KEY AdaLicProtectSmtKey ";
        $tSQL .= "  DECRYPTION BY CERTIFICATE AdaLicProtectCer ";
        $tSQL .= "  SELECT DISTINCT
                        LK.FTCstKey
                    FROM TRGTLicKey LK WITH(NOLOCK)
                    WHERE CONVERT(VARCHAR(MAX), DecryptByKey(LK.FTRlkBchCode)) = '$ptHQBch' /* HQBch */
                ";
        $tSQL .= "  CLOSE SYMMETRIC KEY AdaLicProtectSmtKey ";
        // echo $tSQL;exit;
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems'        => $oQuery->result_array(),
                'tCode'         => '1'
            );
        }else{
            $aResult = array(
                'aItems'        => array(),
                'tCode'         => '99'
            );
        }
        return $aResult;
    }

    //Function : ตรวจสอบว่า ซื้อ Package หรือยัง
    //creater : 22/03/2021 Napat(Jame)
    public function FSaMMENUCheckBuyPackage($ptCstKey){
        $tSQL = "  SELECT TOP 1 1 FROM TRGTCstKey WITH(NOLOCK) WHERE FTCstKey = '$ptCstKey' ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aResult = array(
                // 'aItems'        => $oQuery->result_array(),
                'tCode'         => '1'
            );
        }else{
            $aResult = array(
                // 'aItems'        => array(),
                'tCode'         => '99'
            );
        }
        return $aResult;
    }
    

}




