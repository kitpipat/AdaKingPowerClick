<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mRole extends CI_Model
{

    // Functionality : list Role
    // Parameters : Function Parameter
    // Creator :  05/06/2019 Saharat(Golf)
    // Last Modified : 13/08/2019 Wasin(Yoshi)
    // Last Update By : Napat(Jame) 18/12/2020 สิทธิ์การใช้งานต้องเห็นเฉพาะสิทธิ์ที่ตัวเองได้รับมา และสิทธิ์ที่ตัวเองสร้าง
    // Return : Data User List
    // Return Type : Array
    public function FSaMGetDataRoleList($paDataWhere)
    {
        $aRowLen                    = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);
        $nLngID                     = $paDataWhere['FNLngID'];
        $tSearchList                = $paDataWhere['tSearchAll'];
        $tSesUsrRoleCodeMulti       = $paDataWhere['tSesUsrRoleCodeMulti'];
        $nSesUsrRoleLevel           = $this->session->userdata('nSesUsrRoleLevel');
        $tSesUsrCode                = $paDataWhere['tSesUsrCode'];
        $tSesUsrRoleSpcCodeMulti    = $this->session->userdata("tSesUsrRoleSpcCodeMulti");

        $tSubQuery = "  SELECT DISTINCT
                            USRR.FTRolCode,
                            USRRL.FTRolName,
                            USRR.FNRolLevel,
                            USRRL.FTRolRmk,
                            IMG.FTImgObj,
                            USRR.FDCreateOn
                        FROM TCNMUsrRole        USRR WITH(NOLOCK)
                        LEFT JOIN TCNMUsrRole_L USRRL WITH(NOLOCK) ON USRR.FTRolCode = USRRL.FTRolCode AND USRRL.FNLngID  = $nLngID
                        LEFT JOIN TCNMImgObj    IMG   WITH(NOLOCK) ON IMG.FTImgRefID = USRR.FTRolCode  AND IMG.FTImgTable = 'TCNMUsrRole'
                        WHERE 1=1
        ";

        if( $this->session->userdata('tSesUsrLevel') != "HQ" ){
            if ( isset($tSesUsrRoleSpcCodeMulti) && !empty($tSesUsrRoleSpcCodeMulti) ) {
                $tSubQuery .= " AND USRR.FTRolCode IN ($tSesUsrRoleSpcCodeMulti) ";
            } else {
                // เคสนี้ดักในกรณีที่พึ่งเปลี่ยน process ใหม่ และหน้าจอผู้ใช้ ยังไม่ได้อัพเดท process ใหม่ จึงทำให้ session return เป็นค่าว่าง
                $tSubQuery .= " AND USRR.FTRolCode = 'FAIL' ";
            }
            // $tSubQuery .= " AND ( USRR.FTRolCode IN ($tSesUsrRoleCodeMulti) ";
            // $tSubQuery .= "       OR USRR.FTCreateBy IN ( SELECT FTUsrCode FROM TCNMUsrActRole WITH(NOLOCK) WHERE FTRolCode IN ($tSesUsrRoleCodeMulti) ) ";
            // $tSubQuery .= "     ) ";
        }
        
        if (isset($tSearchList) && !empty($tSearchList)) {
            $tSubQuery   .= " AND (USRR.FTRolCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSubQuery   .= " OR USRRL.FTRolName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        // if( $this->session->userdata('nSesUsrBchCount') != 0 ){
        //     $tSubQuery .= " UNION
        //                     SELECT
        //                         URO.FTRolCode,
        //                         USRRL.FTRolName,
        //                         USRRL.FTRolRmk,
        //                         IMG.FTImgObj,
        //                         URO.FDCreateOn
        //                     FROM TCNMUsrRole URO WITH(NOLOCK)
        //                     LEFT JOIN TCNMUsrRoleSpc URS   WITH(NOLOCK) ON URO.FTRolCode  = URS.FTRolCode
        //                     LEFT JOIN TCNMUsrRole_L  USRRL WITH(NOLOCK) ON URO.FTRolCode  = USRRL.FTRolCode AND USRRL.FNLngID  = $nLngID
        //                     LEFT JOIN TCNMImgObj     IMG   WITH(NOLOCK) ON IMG.FTImgRefID = URO.FTRolCode   AND IMG.FTImgTable = 'TCNMUsrRole'
        //                     WHERE URO.FNRolLevel <= $nSesUsrRoleLevel
        //                         AND ISNULL(URS.FTAgnCode,'') = ''
        //                         AND ISNULL(URS.FTBchCode,'') = ''
        //                     ";
        // }


        $nQuery =  $this->db->query($tSubQuery)->num_rows();


        $tSQL           = " SELECT c.* FROM (
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTRolCode DESC) AS rtRowID,* FROM (
        ";

        
        $tSQL   .=  $tSubQuery;

        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);



        if ($oQuery->num_rows() > 0) {
            $aListData  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMGetDataRoleListAll($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1') ? $nQuery : 0;
            $nPageAll   = ceil($nFoundRow / $paDataWhere['nRow']);
            $aResult = array(
                'raItems'       => $aListData,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aListData);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality : Count Data All Role List
    // Parameters : Function Parameter
    // Creator :  05/06/2019 Saharat(Golf)
    // Last Modified : 13/08/2019 Wasin(Yoshi)
    // Return : data
    // Return Type : Array
    public function FSaMGetDataRoleListAll($paDataWhere)
    {
        $nLngID         = $paDataWhere['FNLngID'];
        $tSearchList    = $paDataWhere['tSearchAll'];
        $tSesUsrRoleCodeMulti    = $paDataWhere['tSesUsrRoleCodeMulti'];
        $tSQL           = " SELECT
                                COUNT (USRR.FTRolCode) AS counts
                            FROM [TCNMUsrRole]          USRR    WITH(NOLOCK)
                            LEFT JOIN [TCNMUsrRole_L]   USRRL   WITH(NOLOCK)    ON USRR.FTRolCode = USRRL.FTRolCode AND USRRL.FNLngID = $nLngID
                            WHERE 1 = 1
        ";

            if($this->session->userdata('nSesUsrBchCount')!=0){
                $tSQL .= " AND  USRR.FTRolCode IN($tSesUsrRoleCodeMulti)"; 
            }


        if (isset($tSearchList) && !empty($tSearchList)) {
            $tSQL   .= " AND (USRR.FTRolCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR USRRL.FTRolName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }
        

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Function List Data Menu
    // Parameters : Function Parameter
    // Creator : 05/06/2019 Saharat(Golf)
    // Last Modified : 27/08/2019 Wasin(Yoshi)
    // Return : array
    // Return Type : array
    public function FSaMRoleMenuList($paData)
    {
        $nLngID = $paData['FNLngID'];
        $tSesUsrRoleCodeMulti = $paData['tSesUsrRoleCodeMulti'];

        // echo $tSesUsrRoleCodeMulti.'XXXXX';
        // if( $this->session->userdata('tSesUserCode') != '00001' || $this->session->userdata('tSesUserLogin') != '009' ){
        if( $this->session->userdata('nSesUsrRoleLevel') != '99' ){
            $tSQL   = " SELECT DISTINCT
                            MENU.FTGmnModCode,
                            MOD_L.FTGmnModName,
                            MOD.FNGmnModShwSeq,
                            MOD.FTGmnModCode AS FTGmnCode,
                            MOD_L.FTGmnModName AS FTGmnName,
                            '0' AS FNGmnShwSeq,
                            MENU.FTMnuCode,
                            MNU_L.FTMnuName,
                            MENU.FNMnuSeq,
                            MENU.FNMnuLevel,
                            ISNULL(USRM.FTAutStaRead, 1) AS FTAutStaRead,
                            ISNULL(USRM.FTAutStaAdd, 1) AS FTAutStaAdd,
                            ISNULL(USRM.FTAutStaDelete, 1) AS FTAutStaDelete,
                            ISNULL(USRM.FTAutStaEdit, 1) AS FTAutStaEdit,
                            ISNULL(USRM.FTAutStaCancel, 1) AS FTAutStaCancel,
                            ISNULL(USRM.FTAutStaAppv, 1) AS FTAutStaAppv,
                            ISNULL(USRM.FTAutStaPrint, 1) AS FTAutStaPrint,
                            ISNULL(USRM.FTAutStaPrintMore, 1) AS FTAutStaPrintMore
                        FROM TCNTUsrMenu                USRM    WITH(NOLOCK)
                        LEFT JOIN TSysMenuGrp           MGP     WITH(NOLOCK) ON USRM.FTGmnCode = MGP.FTGmnCode
                        LEFT JOIN TSysMenuGrp_L         MGPL    WITH(NOLOCK) ON USRM.FTGmnCode = MGPL.FTGmnCode AND MGPL.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList          MENU    WITH(NOLOCK) ON USRM.FTMnuCode = MENU.FTMnuCode
                        LEFT JOIN TSysMenuList_L        MNU_L   WITH(NOLOCK) ON USRM.FTMnuCode = MNU_L.FTMnuCode AND MNU_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrpModule     MOD     WITH(NOLOCK) ON MENU.FTGmnModCode = MOD.FTGmnModCode
                        LEFT JOIN TSysMenuGrpModule_L   MOD_L   WITH(NOLOCK) ON MOD.FTGmnModCode = MOD_L.FTGmnModCode AND MOD_L.FNLngID = $nLngID
                        INNER JOIN TSysMenuAlbAct       MNUALB  WITH(NOLOCK) ON USRM.FTMnuCode = MNUALB.FTMnuCode
                        WHERE 1=1 AND MENU.FTGmnModCode NOT IN ('RPT') ";
            // if($this->session->userdata('nSesUsrBchCount')!=0){
                if(!empty($tSesUsrRoleCodeMulti)){
                   $tSQL   .= " AND USRM.FTRolCode IN ($tSesUsrRoleCodeMulti) ";
                }
            // }
                $tSQL   .= " AND MENU.FNMnuLevel = 0
                    AND MENU.FTMnuStaUse = 1
                    AND MOD.FTGmnModStaUse = 1
                    UNION
                    SELECT DISTINCT
                        MENU.FTGmnModCode,
                        MOD_L.FTGmnModName,
                        MOD.FNGmnModShwSeq,
                        MGP.FTGmnCode,
                        MGPL.FTGmnName,
                        MGP.FNGmnShwSeq,
                        MENU.FTMnuCode,
                        MNU_L.FTMnuName,
                        MENU.FNMnuSeq,
                        MENU.FNMnuLevel,
                        ISNULL(USRM.FTAutStaRead, 1) AS FTAutStaRead,
                        ISNULL(USRM.FTAutStaAdd, 1) AS FTAutStaAdd,
                        ISNULL(USRM.FTAutStaDelete, 1) AS FTAutStaDelete,
                        ISNULL(USRM.FTAutStaEdit, 1) AS FTAutStaEdit,
                        ISNULL(USRM.FTAutStaCancel, 1) AS FTAutStaCancel,
                        ISNULL(USRM.FTAutStaAppv, 1) AS FTAutStaAppv,
                        ISNULL(USRM.FTAutStaPrint, 1) AS FTAutStaPrint,
                        ISNULL(USRM.FTAutStaPrintMore, 1) AS FTAutStaPrintMore
                    FROM TCNTUsrMenu                USRM    WITH(NOLOCK)
                    LEFT JOIN TSysMenuGrp           MGP     WITH(NOLOCK) ON USRM.FTGmnCode = MGP.FTGmnCode
                    LEFT JOIN TSysMenuGrp_L         MGPL    WITH(NOLOCK) ON USRM.FTGmnCode = MGPL.FTGmnCode AND MGPL.FNLngID = $nLngID
                    LEFT JOIN TSysMenuList          MENU    WITH(NOLOCK) ON USRM.FTMnuCode = MENU.FTMnuCode
                    LEFT JOIN TSysMenuList_L        MNU_L   WITH(NOLOCK) ON USRM.FTMnuCode = MNU_L.FTMnuCode AND MNU_L.FNLngID = $nLngID
                    LEFT JOIN TSysMenuGrpModule     MOD     WITH(NOLOCK) ON MENU.FTGmnModCode = MOD.FTGmnModCode
                    LEFT JOIN TSysMenuGrpModule_L   MOD_L   WITH(NOLOCK) ON MOD.FTGmnModCode = MOD_L.FTGmnModCode AND MOD_L.FNLngID = $nLngID
                    INNER JOIN TSysMenuAlbAct       MNUALB  WITH(NOLOCK) ON USRM.FTMnuCode = MNUALB.FTMnuCode
                    WHERE 1=1 ";
            // if($this->session->userdata('nSesUsrBchCount')!=0){
                if(!empty($tSesUsrRoleCodeMulti)){
                   $tSQL   .= " AND USRM.FTRolCode IN ($tSesUsrRoleCodeMulti) ";
                }
            // }
                $tSQL .= " AND MOD.FTGmnModStaUse  = 1
                           AND MGP.FTGmnStaUse     = 1
                           AND MENU.FTMnuStaUse    = 1
                           ORDER BY FNGmnModShwSeq,FTGmnModCode,FNGmnShwSeq,FTGmnCode,FNMnuSeq,FTMnuCode
                            --ORDER BY FNGmnModShwSeq ASC,FNGmnShwSeq ASC,FNMnuSeq ASC,FNMnuLevel ASC 
                         ";

                    // echo $tSQL;
                    // die();
        }else{
            // $tSQL   = " SELECT DISTINCT
            //                 MENU.FTGmnModCode,
            //                 MOD_L.FTGmnModName,
            //                 MOD.FNGmnModShwSeq,
            //                 MOD.FTGmnModCode    AS FTGmnCode,
            //                 MOD_L.FTGmnModName	AS FTGmnName,
            //                 '0'                 AS FNGmnShwSeq,
            //                 MENU.FTMnuCode,
            //                 MNU_L.FTMnuName,
            //                 MENU.FNMnuSeq,
            //                 MENU.FNMnuLevel,
            //                 ISNULL(MNUALB.FTAutStaRead,1)       AS FTAutStaRead,
            //                 ISNULL(MNUALB.FTAutStaAdd,1)        AS FTAutStaAdd,
            //                 ISNULL(MNUALB.FTAutStaDelete,1)     AS FTAutStaDelete,
            //                 ISNULL(MNUALB.FTAutStaEdit,1)       AS FTAutStaEdit,
            //                 ISNULL(MNUALB.FTAutStaCancel,1)     AS FTAutStaCancel,
            //                 ISNULL(MNUALB.FTAutStaAppv,1)       AS FTAutStaAppv,
            //                 ISNULL(MNUALB.FTAutStaPrint,1)      AS FTAutStaPrint,
            //                 ISNULL(MNUALB.FTAutStaPrintMore,1)  AS FTAutStaPrintMore
            //             FROM TSysMenuList               MENU    WITH(NOLOCK)
            //             LEFT JOIN TSysMenuList_L        MNU_L   WITH(NOLOCK) ON MENU.FTMnuCode      = MNU_L.FTMnuCode       AND MNU_L.FNLngID = $nLngID
            //             LEFT JOIN TSysMenuGrpModule     MOD     WITH(NOLOCK) ON MENU.FTGmnModCode   = MOD.FTGmnModCode
            //             LEFT JOIN TSysMenuGrpModule_L   MOD_L   WITH(NOLOCK) ON MOD.FTGmnModCode    = MOD_L.FTGmnModCode    AND MOD_L.FNLngID = $nLngID
            //             LEFT JOIN TSysMenuAlbAct        MNUALB	WITH(NOLOCK) ON MENU.FTMnuCode      = MNUALB.FTMnuCode
            //             WHERE 1=1
            //             -- AND MENU.FTGmnModCode NOT IN ('RPT')
            //             AND MENU.FNMnuLevel     = 0
            //             AND MENU.FTMnuStaUse    = 1
            //             AND MOD.FTGmnModStaUse	= 1
            //             UNION  ";
            $tSQL   = " SELECT DISTINCT
                            MNU.FTGmnModCode,
                            MNU_L.FTGmnModName,
                            MNU.FNGmnModShwSeq,
                            MNG.FTGmnCode,
                            MNG_L.FTGmnName,
                            MNG.FNGmnShwSeq,
                            MNL.FTMnuCode,
                            MNL_L.FTMnuName,
                            MNL.FNMnuSeq,
                            MNL.FNMnuLevel,
                            ISNULL(MNUALB.FTAutStaRead,1)       AS FTAutStaRead,
                            ISNULL(MNUALB.FTAutStaAdd,1)        AS FTAutStaAdd,
                            ISNULL(MNUALB.FTAutStaDelete,1)     AS FTAutStaDelete,
                            ISNULL(MNUALB.FTAutStaEdit,1)       AS FTAutStaEdit,
                            ISNULL(MNUALB.FTAutStaCancel,1)     AS FTAutStaCancel,
                            ISNULL(MNUALB.FTAutStaAppv,1)       AS FTAutStaAppv,
                            ISNULL(MNUALB.FTAutStaPrint,1)      AS FTAutStaPrint,
                            ISNULL(MNUALB.FTAutStaPrintMore,1)  AS FTAutStaPrintMore
                        FROM TSysMenuGrpModule        MNU    WITH (NOLOCK)
                        LEFT JOIN TSysMenuGrpModule_L MNU_L  WITH (NOLOCK) ON MNU.FTGmnModCode = MNU_L.FTGmnModCode  AND MNU_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrp         MNG    WITH (NOLOCK) ON MNU.FTGmnModCode = MNG.FTGmnModCode
                        LEFT JOIN TSysMenuGrp_L       MNG_L  WITH (NOLOCK) ON MNG.FTGmnCode    = MNG_L.FTGmnCode     AND MNG_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList        MNL    WITH (NOLOCK) ON MNU.FTGmnModCode = MNL.FTGmnModCode    AND MNG.FTGmnCode = MNL.FTGmnCode AND MNG.FTGmnCode = MNL.FTMnuParent
                        LEFT JOIN TSysMenuList_L      MNL_L  WITH (NOLOCK) ON MNL.FTMnuCode    = MNL_L.FTMnuCode     AND MNL_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuAlbAct      MNUALB WITH (NOLOCK) ON MNL.FTMnuCode    = MNUALB.FTMnuCode
                        WHERE MNU.FTGmnModStaUse  = 1
                        AND MNG.FTGmnStaUse     = 1
                        AND MNL.FTMnuStaUse     = 1
                        ORDER BY FNGmnModShwSeq,FTGmnModCode,FNGmnShwSeq,FTGmnCode,FNMnuSeq,FTMnuCode
                        --ORDER BY FNGmnModShwSeq ASC,FNGmnShwSeq ASC,FNMnuSeq ASC,FNMnuLevel ASC
                    ";
        }
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query(); exit;
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oList,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Functionality : Function List Data Menu
    // Parameters : 
    // Creator : 24/07/2019 Saharat(Golf)
    // Last Modified : 27/08/2019 Wasin(Yoshi)
    // Return : array
    // Return Type : array
    public function FSaMRptListMenu($paData)
    {
        $nLngID     = $paData['FNLngID'];
        $tSesUsrRoleCodeMulti = $paData['tSesUsrRoleCodeMulti'];
        // if($this->session->userdata('tSesUserCode')!='00001' && $this->session->userdata('tSesUserLogin')!='009'){
        if( $this->session->userdata('nSesUsrRoleLevel') != '99' ){
        $tSQL   =   "  SELECT DISTINCT
                        RPM.FTGrpRptModCode,
                        RPM.FNGrpRptModShwSeq,
                        RPG.FNGrpRptShwSeq,
                        RPML.FNGrpRptModName,
                        RPG.FTGrpRptCode,
                        RPGL.FTGrpRptName,
                        RPT.FTRptCode,
                        RPTL.FTRptName
                        FROM
                        TCNTUsrFuncRpt UFR
                        INNER JOIN TSysReport RPT WITH (NOLOCK) ON UFR.FTUfrGrpRef = RPT.FTGrpRptCode AND UFR.FTUfrRef = RPT.FTRptCode
                        LEFT JOIN TSysReport_L RPTL WITH (NOLOCK) ON RPT.FTRptCode = RPTL.FTRptCode AND RPTL.FNLngID = $nLngID
                        LEFT JOIN TSysReportGrp RPG WITH (NOLOCK) ON UFR.FTUfrGrpRef = RPG.FTGrpRptCode
                        LEFT JOIN TSysReportGrp_L RPGL WITH (NOLOCK) ON RPG.FTGrpRptCode = RPGL.FTGrpRptCode AND RPGL.FNLngID = $nLngID
                        LEFT JOIN TSysReportModule RPM WITH (NOLOCK) ON RPT.FTGrpRptModCode = RPM.FTGrpRptModCode 
                        LEFT JOIN TSysReportModule_L RPML WITH (NOLOCK) ON RPM.FTGrpRptModCode = RPML.FTGrpRptModCode AND RPML.FNLngID = $nLngID
                        WHERE
                            1 = 1
                        AND UFR.FTUfrType = 2
                        AND RPG.FTGrpRptStaUse = 1
                        AND RPM.FTGrpRptModStaUse = 1
                        AND RPT.FTRptStaUse = 1 ";

                if(!empty($tSesUsrRoleCodeMulti)){
                    $tSQL   .= " AND UFR.FTRolCode IN ($tSesUsrRoleCodeMulti) ";
                }
              
            $tSQL   .= " ORDER BY
                                    RPM.FNGrpRptModShwSeq ASC,
                                    RPG.FNGrpRptShwSeq ASC
                ";
                
            }else{
         $tSQL   =   "   SELECT 
                RPM.FTGrpRptModCode,
                RPM.FNGrpRptModShwSeq,
                RPML.FNGrpRptModName,
                RPG.FTGrpRptCode,
                RPGL.FTGrpRptName,
                RPT.FTRptCode,
                RPTL.FTRptName                         
            FROM TSysReportModule           RPM     WITH(NOLOCK)
            LEFT JOIN TSysReportModule_L    RPML    WITH(NOLOCK)    ON RPM.FTGrpRptModCode  = RPML.FTGrpRptModCode AND RPML.FNLngID = $nLngID 
            LEFT JOIN TSysReportGrp         RPG     WITH(NOLOCK)    ON RPM.FTGrpRptModCode  = RPG.FTGrpRptModCode
            LEFT JOIN TSysReportGrp_L       RPGL    WITH(NOLOCK)    ON RPG.FTGrpRptCode     = RPGL.FTGrpRptCode    AND RPGL.FNLngID = $nLngID 
            LEFT JOIN TSysReport            RPT     WITH(NOLOCK)    ON RPM.FTGrpRptModCode  = RPT.FTGrpRptModCode  AND RPG.FTGrpRptCode = RPT.FTGrpRptCode
            LEFT JOIN TSysReport_L          RPTL    WITH(NOLOCK)    ON RPT.FTRptCode        = RPTL.FTRptCode       AND RPTL.FNLngID = $nLngID 
            WHERE 1 = 1 
            AND RPG.FTGrpRptStaUse    = 1
            AND RPM.FTGrpRptModStaUse = 1
            AND RPT.FTRptStaUse       = 1
            ORDER BY RPM.FNGrpRptModShwSeq ASC , RPG.FNGrpRptShwSeq ASC 
            ";
        }
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oList,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'raItems' => '0',
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    /**
     * Functionality : Get Setting Function List (TPSMFuncHD, TPSMFuncDT, TPSMFuncDT_L)
     * Parameters : -
     * Creator : 23/04/2020 piya
     * Last Modified : -
     * Return : Setting Funtion Data
     * Return Type : array
     */
    public function FSaMGetFuncSettingList($paParams = [])
    {
        $nLngID = $paParams['FNLngID'];
        $tRoleCode = $paParams['FTRolCode'];
        $tSesUsrRoleCodeMulti = $paParams['tSesUsrRoleCodeMulti'];
        
        $tSQL = " SELECT DISTINCT
                HD.FTGhdApp,
                HD.FTKbdScreen,
                APL.FTAppName,
                DTL.FTGdtName,
                DT.FTGhdCode,
                DT.FTSysCode,
                DT.FTGdtCallByName,
                DT.FNGdtFuncLevel,
                DT.FTGdtStaUse,
                (SELECT FUNC.FTUfrStaAlw FROM TCNTUsrFuncRpt FUNC WHERE FUNC.FTGhdApp = HD.FTGhdApp AND FUNC.FTUfrGrpRef = HD.FTGhdCode AND FUNC.FTUfrRef = DT.FTSysCode AND  FUNC.FTUfrType = '1' AND FUNC.FTRolCode='$tRoleCode'  ) AS FTUfrStaAlw
                --USRFUNC.FTUfrStaAlw
            FROM TPSMFuncHD HD WITH (NOLOCK)
            INNER JOIN TPSMFuncDT DT WITH (NOLOCK) ON HD.FTGhdCode = DT.FTGhdCode
            INNER JOIN TPSMFuncDT_L DTL WITH (NOLOCK) ON DT.FTGhdCode = DTL.FTGhdCode AND DT.FTSysCode = DTL.FTSysCode AND DTL.FNLngID = $nLngID
            INNER JOIN TSysApp_L APL WITH (NOLOCK) ON HD.FTGhdApp = APL.FTAppCode AND APL.FNLngID = $nLngID
            LEFT JOIN TCNTUsrFuncRpt USRFUNC WITH (NOLOCK) ON USRFUNC.FTGhdApp = HD.FTGhdApp AND USRFUNC.FTUfrGrpRef = HD.FTGhdCode AND USRFUNC.FTUfrRef = DT.FTSysCode AND USRFUNC.FTUfrType = '1' 
            WHERE DT.FTGdtSysUse = '1' 
            AND DT.FTGdtStaUse = '1' ";
    // if($this->session->userdata('tSesUserCode')!='00001' && $this->session->userdata('tSesUserLogin')!='009'){
    if( $this->session->userdata('nSesUsrRoleLevel') != '99' ){
        if(!empty($tSesUsrRoleCodeMulti)){
        $tSQL .= "AND USRFUNC.FTRolCode IN($tSesUsrRoleCodeMulti)";
        }
    }
     $tSQL .=" ORDER BY APL.FTAppName ASC, HD.FTKbdScreen ASC, DTL.FTGdtName ASC
        ";

        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            $aItems = $oQuery->result_array();
            $aResult = array(
                'raItems' => $aItems,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found'
            );
        }
        return $aResult;
    }

    /**
     * Functionality : Add/Update Function Setting Role
     * Parameters : -
     * Creator : 24/04/2020 piya
     * LastUpdate: -
     * Return : -
     * Return Type : -
     */
    public function FSxMAddRoleFuncSetting($paParams = [])
    {
        // Insert
        $this->db->set('FTRolCode', $paParams['tRoleCode']);
        $this->db->set('FTGhdApp', $paParams['tGhdApp']);
        $this->db->set('FTUfrGrpRef', $paParams['tGhdCode']);
        $this->db->set('FTUfrRef', $paParams['tSysCode']);
        $this->db->set('FTUfrStaAlw', $paParams['tUfrStaAlw']);

        $this->db->set('FDCreateOn', 'GETDATE()', false);
        $this->db->set('FTCreateBy', $paParams['tUserLoginCode']);
        $this->db->set('FDLastUpdOn', 'GETDATE()', false);
        $this->db->set('FTLastUpdBy', $paParams['tUserLoginCode']);
        $this->db->set('FTUfrType', "1");
        $this->db->set('FTUfrStaFavorite', "0");
        $this->db->insert('TCNTUsrFuncRpt');
    }

    /**
     * Functionality : Clear Function Setting Role
     * Parameters : -
     * Creator : 24/04/2020 piya
     * LastUpdate: -
     * Return : -
     * Return Type : -
     */
    public function FSxClearRoleFuncSetting($paParams = [])
    {
        // Delete Data User Role Function Setting
        $this->db->where('FTRolCode', $paParams['tRoleCode']);
        $this->db->where('FTUfrType', "1");
        $this->db->delete('TCNTUsrFuncRpt');
    }

    // Functionality : Count Data Role
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 28/08/2019 Wasin(Yoshi)
    // Return : array result from db
    // Return Type : array
    public function FSnMCountDataRole()
    {
        $tSQL   = " SELECT
                        COUNT(FTRolCode) AS FNRolCountAll
                    FROM TCNMUsrRole WITH(NOLOCK)
        ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->row_array()["FNRolCountAll"];
    }

    // Functionality : Add/Update Main Data User Role
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 28/08/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMRoleAddUpdateUsrRole($paDataMaster)
    {
        // Update Main User Role 
        $this->db->where('FTRolCode', $paDataMaster['FTRolCode']);
        $this->db->update('TCNMUsrRole', array(
            'FNRolLevel'    => $paDataMaster['FNRolLevel'],
            'FDLastUpdOn'   => $paDataMaster['FDLastUpdOn'],
            'FTLastUpdBy'   => $paDataMaster['FTLastUpdBy'],
        ));

        if ($this->db->affected_rows() == 0) {
            // Add Main User Role
            $this->db->insert('TCNMUsrRole', array(
                'FTRolCode'     => $paDataMaster['FTRolCode'],
                'FNRolLevel'    => $paDataMaster['FNRolLevel'],
                'FDCreateOn'    => $paDataMaster['FDCreateOn'],
                'FTCreateBy'    => $paDataMaster['FTCreateBy'],
                'FDLastUpdOn'   => $paDataMaster['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataMaster['FTLastUpdBy'],
            ));
        }
        return;
    }

    // Functionality : Add/Update Main Data User Role
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 28/08/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMRoleAddUpdateUsrRoleSpc($paBchCode, $paData){
        try{
            $aResult = array(
                'FTRolCode'     => $paData['FTRolCode'],
                'FTAgnCode'     => $paData['FTAgnCode'],
                'FTBchCode'     => $paBchCode,
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                'FDCreateOn'    => $paData['FDCreateOn'],
                'FTCreateBy'    => $paData['FTCreateBy'],
            );
            $this->db->insert('TCNMUsrRoleSpc', $aResult);
            // echo $this->db->last_query();
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality : Add/Update Main Data User Role Lang
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 28/08/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMRoleAddUpdateUsrRoleLang($paDataMaster)
    {
        // Update Main User Role Lang
        $this->db->where('FNLngID', $paDataMaster['FNLngID']);
        $this->db->where('FTRolCode', $paDataMaster['FTRolCode']);
        $this->db->update('TCNMUsrRole_L', array(
            'FTRolName' => $paDataMaster['FTRolName'],
            'FTRolRmk'  => $paDataMaster['FTRolRmk'],
        ));
        if ($this->db->affected_rows() == 0) {
            // Add Main User Role Lang
            $this->db->insert('TCNMUsrRole_L', array(
                'FTRolCode' => $paDataMaster['FTRolCode'],
                'FNLngID'   => $paDataMaster['FNLngID'],
                'FTRolName' => $paDataMaster['FTRolName'],
                'FTRolRmk'  => $paDataMaster['FTRolRmk'],
            ));
        }
        return;
    }

    // Functionality : Add/Update Role User Menu
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 28/08/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMRoleAddUpdateUsrMenu($paDataMaster, $paRoleMnuData, $paRoleRptMnuData)
    {
        // Delete Data User Role Menu
        $this->db->where('FTRolCode', $paDataMaster['FTRolCode']);
        $this->db->delete('TCNTUsrMenu');

        // Check Data Role Menu Empty
        if (isset($paRoleMnuData) && !empty($paRoleMnuData)) {
            // Loop Add/Update Data User Role Menu
            foreach ($paRoleMnuData as $nKey => $aValue) {
                // Add Data User Role Menu
                $this->db->insert('TCNTUsrMenu', array(
                    'FTRolCode'         => $paDataMaster['FTRolCode'],
                    'FTGmnCode'         => $aValue['tGrpCode'],
                    'FTMnuParent'       => $aValue['tGrpCode'],
                    'FTMnuCode'         => $aValue['tMenuCode'],
                    'FTAutStaFull'      => 0,
                    'FTAutStaRead'      => $aValue['tMenuStaRead'],
                    'FTAutStaAdd'       => $aValue['tMenuStaAdd'],
                    'FTAutStaEdit'      => $aValue['tMenuStaEdit'],
                    'FTAutStaDelete'    => $aValue['tMenuStaDel'],
                    'FTAutStaCancel'    => $aValue['tMenuStaCancel'],
                    'FTAutStaAppv'      => $aValue['tMenuStaAppv'],
                    'FTAutStaPrint'     => $aValue['tMenuStaPrintMore'],
                    'FTAutStaPrintMore' => $aValue['tMenuStaPrintMore'],
                    'FTAutStaFavorite'  => 0,
                    'FDLastUpdOn'       => $paDataMaster['FDLastUpdOn'],
                    'FTLastUpdBy'       => $paDataMaster['FTLastUpdBy'],
                    'FDCreateOn'        => $paDataMaster['FDCreateOn'],
                    'FTCreateBy'        => $paDataMaster['FTCreateBy'],
                ));
            }
        }

        // Create By : 04/11/2020 Napat(Jame)
        // ตรวจสอบว่ามีการอนุญาตสิทธิ์การมองเห็น Report หรือไม่ ถ้ามีให้เพิ่ม UsrMenu Report
        if ( isset($paRoleRptMnuData) && !empty($paRoleRptMnuData) && FCNnHSizeOf($paRoleRptMnuData) > 0 ) {
            $aRptDupGrpModCode = [];
            foreach( $paRoleRptMnuData as $nKey => $tValue ){
                if( !in_array($tValue['tRptGrpModCode'], $aRptDupGrpModCode) ){
                    array_push($aRptDupGrpModCode,$tValue['tRptGrpModCode']);
                    $this->db->insert('TCNTUsrMenu', array(
                        'FTRolCode'         => $paDataMaster['FTRolCode'],
                        'FTGmnCode'         => 'RPT',
                        'FTMnuParent'       => 'RPT',
                        'FTMnuCode'         => 'RPT'.$tValue['tRptGrpModCode'],
                        'FTAutStaFull'      => '0',
                        'FTAutStaRead'      => '1',
                        'FTAutStaAdd'       => '1',
                        'FTAutStaEdit'      => '1',
                        'FTAutStaDelete'    => '1',
                        'FTAutStaCancel'    => '0',
                        'FTAutStaAppv'      => '0',
                        'FTAutStaPrint'     => '0',
                        'FTAutStaPrintMore' => '0',
                        'FTAutStaFavorite'  => '0',
                        'FDLastUpdOn'       => $paDataMaster['FDLastUpdOn'],
                        'FTLastUpdBy'       => $paDataMaster['FTLastUpdBy'],
                        'FDCreateOn'        => $paDataMaster['FDCreateOn'],
                        'FTCreateBy'        => $paDataMaster['FTCreateBy'],
                    ));

                }
            }
            
        }
        

        return;
    }

    // Functionality : Add/Update Role User Report Menu
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 28/08/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMRoleAddUpdateUsrRptMenu($paDataMaster, $paRoleRptMnuData)
    {
        // Delete Data User Role Menu
        $this->db->where('FTRolCode', $paDataMaster['FTRolCode']);
        $this->db->where('FTUfrType', "2");
        $this->db->delete('TCNTUsrFuncRpt');

        // Check Data Role Menu Report
        if (isset($paRoleRptMnuData) && !empty($paRoleRptMnuData)) {
            // Loop Add/Update Data User Role Report Menu
            foreach ($paRoleRptMnuData as $nKey => $aValue) {
                // Add Data User Role Report Menu
                $this->db->insert('TCNTUsrFuncRpt', array(
                    'FTRolCode'         => $paDataMaster['FTRolCode'],
                    'FTUfrType'         => 2,
                    'FTUfrGrpRef'       => $aValue['tRptGrpCode'],
                    'FTUfrRef'          => $aValue['tRptCode'],
                    'FTUfrStaAlw'       => $aValue['tRptStaAlw'],
                    'FTUfrStaFavorite'  => 0,
                    'FDCreateOn'        => $paDataMaster['FDCreateOn'],
                    'FTCreateBy'        => $paDataMaster['FTCreateBy'],
                ));
            }
        }
        return;
    }


    // Functionality : Add/Update Role User Report Menu
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 28/08/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMAddRoleNotiSetting($paDataMaster, $paRoleNotiData)
    {
        // Delete Data User Role Menu
        $this->db->where('FTRolCode', $paDataMaster['FTRolCode']);
        $this->db->where('FNRptGrpSeq', "3");
        $this->db->where('FTRptRoute', "");
        $this->db->where('FTRptGrpCode', $paDataMaster['FTRolCode']);
        $this->db->delete('TCNSRptSpc');

        // Check Data Role Menu Report
        if (isset($paRoleNotiData) && !empty($paRoleNotiData)) {
            // Loop Add/Update Data User Role Report Menu
            foreach ($paRoleNotiData as $nKey => $aValue) {
                // Add Data User Role Report Menu
                $this->db->insert('TCNSRptSpc', array(
                    'FNRptGrpSeq'       => 3,
                    'FTRptGrpCode'      => $paDataMaster['FTRolCode'],
                    'FTRptRoute'        => '',
                    'FNRptSeq'          => $nKey,
                    'FTRolCode'         => $paDataMaster['FTRolCode'],
                    'FTRptCode'         => $aValue['tNotiCode'],
                    'FTRptStaActive'     => '1',
                    'FDLastUpdOn'        => $paDataMaster['FDCreateOn'],
                    'FTLastUpdBy'        => $paDataMaster['FTCreateBy'],
                    'FDCreateOn'        => $paDataMaster['FDCreateOn'],
                    'FTCreateBy'        => $paDataMaster['FTCreateBy'],
                ));
            }
        }
        return;
    }

    // Functionality : Delete Role
    // Parameters : function parameters
    // Creator :  05/06/2019 Saharat(Golf)
    // Last Modified : 28/08/2019 Wasin(Yoshi)
    // Return : Status Delete
    // Return Type : array
    public function FSaMRoleDeleteData($paData)
    {
        $this->db->trans_begin();

        $this->db->where_in('FTRolCode', $paData['FTRolCode']);
        $this->db->delete('TCNMUsrRole');

        $this->db->where_in('FTRolCode', $paData['FTRolCode']);
        $this->db->delete('TCNMUsrRole_L');

        $this->db->where_in('FTRolCode', $paData['FTRolCode']);
        $this->db->delete('TCNTUsrMenu');

        $this->db->where_in('FTRolCode', $paData['FTRolCode']);
        $this->db->delete('TCNTUsrFuncRpt');

        $this->db->where_in('FTRolCode', $paData['FTRolCode']);
        $this->db->delete('TCNMUsrRoleSpc');

        $this->db->where_in('FTRolCode', $paData['FTRolCode']);
        $this->db->delete('TCNMUsrRoleChain');

        // Del IMGobj
        $this->db->where_in('FTImgRefID', $paData['FTRolCode']);
        $this->db->delete('TCNMImgObj');


        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Delete Data Role.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Role And Menu Complete.'
            );
        }
        return $aStatus;
    }

    // Functionality : Get Data Master Role
    // Parameters : function parameters
    // Creator :  05/06/2019 Saharat(Golf)
    // Last Modified : 28/08/2019 Wasin(Yoshi)
    // Return : Array Data Role Master
    // Return Type : array
    public function FSaMRoleGetDataMaster($paDataWhere)
    {
        $tRoleCode  = $paDataWhere['FTRolCode'];
        $nLngID     = $paDataWhere['FNLngID'];
        $tSQL       = " SELECT
                            ROL.FTRolCode,
                            ROL.FNRolLevel,
                            ROL_L.FTRolName,
                            ROL_L.FTRolRmk,
                            IMG.FTImgObj   AS rtRoleImgObj
                        FROM TCNMUsrRole        ROL     WITH(NOLOCK)
                        LEFT JOIN TCNMUsrRole_L ROL_L   WITH(NOLOCK) ON ROL.FTRolCode = ROL_L.FTRolCode AND ROL_L.FNLngID = $nLngID
                        LEFT JOIN TCNMImgObj IMG ON IMG.FTImgRefID = ROL.FTRolCode AND IMG.FTImgTable = 'TCNMUsrRole'
                        WHERE ROL.FTRolCode = '$tRoleCode'
        ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataReturn    = $oQuery->row_array();
        } else {
            $aDataReturn    = array();
        }
        return $aDataReturn;
    }

    // Functionality : Get Data Master RoleSpc
    // Parameters : function parameters
    // Creator :  19/06/2020 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Role Master
    // Return Type : array
    public function FSaMUsrRoleSpcGetDataMaster($paData){

        $tRoleCode  = $paData['FTRolCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL       = " SELECT 
                            ROLSPC.FTRolCode,
                            ROLSPC.FTAgnCode,
                            ROLSPC.FTBchCode,
                            AGN_L.FTAgnName,
                            BCH_L.FTBchName,
                            USRACT.FTRolCode AS rtUsrActRole
                        FROM TCNMUsrRoleSpc ROLSPC WITH(NOLOCK)
                        LEFT JOIN TCNMUsrRole ROL WITH(NOLOCK) ON ROLSPC.FTRolCode = ROL.FTRolCode
                        LEFT JOIN TCNMUsrRole_L ROL_L WITH(NOLOCK) ON ROLSPC.FTRolCode = ROL_L.FTRolCode AND ROL_L.FNLngID = $nLngID
                        LEFT JOIN TCNMAgency AGN WITH(NOLOCK) ON ROLSPC.FTAgnCode = AGN.FTAgnCode
                        LEFT JOIN TCNMAgency_L AGN_L WITH(NOLOCK) ON ROLSPC.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                        LEFT JOIN TCNMBranch BCH WITH(NOLOCK) ON ROLSPC.FTBchCode = BCH.FTBchCode
                        LEFT JOIN TCNMBranch_L BCH_L WITH(NOLOCK) ON ROLSPC.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                        LEFT JOIN TCNMUsrActRole USRACT WITH(NOLOCK) ON ROLSPC.FTRolCode = USRACT.FTRolCode
                        WHERE ROLSPC.FTRolCode = '$tRoleCode'
        "; 
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        
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


    // Functionality: Get Data Edit Menu Role
    // Parameters:  Function Parameter
    // Creator: 27/06/2019 Saharat(Golf)
    // Last Modified: -
    // Return: array
    // ReturnType: array
    public function FSaMGetDataRoleMenuEdit($paDataWhere)
    {
        $nLngID     = $paDataWhere['FNLngID'];
        $tRoleCode  = $paDataWhere['FTRolCode'];
        $tSQL       = " SELECT
                            USERMENU.*,
                            ISNULL(MNUDATAAUT.FTAutStaRead,0)       AS FTAutStaRead,
                            ISNULL(MNUDATAAUT.FTAutStaAdd,0)        AS FTAutStaAdd,
                            ISNULL(MNUDATAAUT.FTAutStaDelete,0)     AS FTAutStaDelete,
                            ISNULL(MNUDATAAUT.FTAutStaEdit,0)       AS FTAutStaEdit,
                            ISNULL(MNUDATAAUT.FTAutStaAppv,0)       AS FTAutStaAppv,
                            ISNULL(MNUDATAAUT.FTAutStaCancel,0)     AS FTAutStaCancel,
                            ISNULL(MNUDATAAUT.FTAutStaPrint,0)      AS FTAutStaPrint,
                            ISNULL(MNUDATAAUT.FTAutStaPrintMore,0)  AS FTAutStaPrintMore
                        FROM (
                            SELECT
                                USRM.FTRolCode,
                                MOD.FTGmnModCode,
                                MOD.FNGmnModShwSeq,
                                MOD_L.FTGmnModName,
                                USRM.FTGmnCode,
                                0 AS FNGmnShwSeq,
                                MOD_L.FTGmnModName AS FTGmnName,
                                MNL.FTMnuCode,
                                MNL.FNMnuSeq,
                                MNL_L.FTMnuName,
                                MNL.FNMnuLevel,
                                ISNULL(USRM.FTAutStaFull,0)         AS FTUsrUseStaStaFull,
                                ISNULL(USRM.FTAutStaRead,0)         AS FTUsrUseStaStaRead,
                                ISNULL(USRM.FTAutStaAdd,0)          AS FTUsrUseStaStaAdd,
                                ISNULL(USRM.FTAutStaDelete,0)       AS FTUsrUseStaStaDelete,
                                ISNULL(USRM.FTAutStaEdit,0)         AS FTUsrUseStaStaEdit,
                                ISNULL(USRM.FTAutStaAppv,0)         AS FTUsrUseStaStaAppv,
                                ISNULL(USRM.FTAutStaCancel,0)       AS FTUsrUseStaStaCancel,
                                ISNULL(USRM.FTAutStaPrint,0)        AS FTUsrUseStaPrint,
                                ISNULL(USRM.FTAutStaPrintMore,0)    AS FTUsrUseStaPrintMore,
                                ISNULL(USRM.FTAutStaFavorite,0)     AS FTUsrUseStaFavorite
                            FROM TCNTUsrMenu                USRM	WITH(NOLOCK)
                            LEFT JOIN TSysMenuList          MNL		WITH(NOLOCK) ON USRM.FTGmnCode 		= MNL.FTGmnCode         AND USRM.FTMnuParent = MNL.FTMnuParent AND USRM.FTMnuCode = MNL.FTMnuCode
                            LEFT JOIN TSysMenuList_L        MNL_L	WITH(NOLOCK) ON MNL.FTMnuCode 		= MNL_L.FTMnuCode 		AND MNL_L.FNLngID = $nLngID
                            LEFT JOIN TSysMenuGrpModule     MOD		WITH(NOLOCK) ON MNL.FTGmnModCode	= MOD.FTGmnModCode
                            LEFT JOIN TSysMenuGrpModule_L   MOD_L	WITH(NOLOCK) ON MOD.FTGmnModCode	= MOD_L.FTGmnModCode	AND MOD_L.FNLngID = $nLngID
                            WHERE 1=1
                            AND USRM.FTRolCode      = '$tRoleCode'
                            AND MNL.FNMnuLevel      = 0
                            AND MNL.FTMnuStaUse     = 1
                            AND MOD.FTGmnModStaUse  = 1
                            UNION ALL
                            SELECT
                                USRM.FTRolCode,
                                MOD.FTGmnModCode,
                                MOD.FNGmnModShwSeq,
                                MOD_L.FTGmnModName,
                                MGP.FTGmnCode,
                                MGP.FNGmnShwSeq,
                                MGP_L.FTGmnName,
                                MNL.FTMnuCode,
                                MNL.FNMnuSeq,
                                MNL_L.FTMnuName,
                                MNL.FNMnuLevel,
                                ISNULL(USRM.FTAutStaFull,0)         AS FTUsrUseStaStaFull,
                                ISNULL(USRM.FTAutStaRead,0)         AS FTUsrUseStaStaRead,
                                ISNULL(USRM.FTAutStaAdd,0)          AS FTUsrUseStaStaAdd,
                                ISNULL(USRM.FTAutStaDelete,0)       AS FTUsrUseStaStaDelete,
                                ISNULL(USRM.FTAutStaEdit,0)         AS FTUsrUseStaStaEdit,
                                ISNULL(USRM.FTAutStaCancel,0)       AS FTUsrUseStaStaCancel,
                                ISNULL(USRM.FTAutStaAppv,0)         AS FTUsrUseStaStaAppv,
                                ISNULL(USRM.FTAutStaPrint,0)        AS FTUsrUseStaPrint,
                                ISNULL(USRM.FTAutStaPrintMore,0)    AS FTUsrUseStaPrintMore,
                                ISNULL(USRM.FTAutStaFavorite,0)     AS FTUsrUseStaFavorite
                            FROM TCNTUsrMenu USRM               WITH(NOLOCK)
                            LEFT JOIN TSysMenuList MNL          WITH(NOLOCK) ON USRM.FTGmnCode   = MNL.FTGmnCode         AND USRM.FTMnuParent = MNL.FTMnuParent AND USRM.FTMnuCode = MNL.FTMnuCode
                            LEFT JOIN TSysMenuList_L MNL_L      WITH(NOLOCK) ON MNL.FTMnuCode    = MNL_L.FTMnuCode       AND MNL_L.FNLngID = $nLngID
                            LEFT JOIN TSysMenuGrp MGP           WITH(NOLOCK) ON MNL.FTGmnCode    = MGP.FTGmnCode
                            LEFT JOIN TSysMenuGrp_L MGP_L       WITH(NOLOCK) ON MGP.FTGmnCode    = MGP_L.FTGmnCode       AND MGP_L.FNLngID = $nLngID
                            LEFT JOIN TSysMenuGrpModule MOD     WITH(NOLOCK) ON MGP.FTGmnModCode = MOD.FTGmnModCode
                            LEFT JOIN TSysMenuGrpModule_L MOD_L WITH(NOLOCK) ON MOD.FTGmnModCode = MOD_L.FTGmnModCode    AND MOD_L.FNLngID = $nLngID
                            WHERE 1=1 
                            AND USRM.FTRolCode      = '$tRoleCode'
                            AND MNL.FTMnuStaUse     = 1
                            AND MGP.FTGmnStaUse     = 1
                            AND MOD.FTGmnModStaUse  = 1
                        ) AS USERMENU
                        LEFT JOIN (
                            SELECT
                                MENUAUT.FTMnuCode,
                                MENUAUT.FTAutStaRead,
                                MENUAUT.FTAutStaAdd,
                                MENUAUT.FTAutStaDelete,
                                MENUAUT.FTAutStaEdit,
                                MENUAUT.FTAutStaCancel,
                                MENUAUT.FTAutStaAppv,
                                MENUAUT.FTAutStaPrint,
                                MENUAUT.FTAutStaPrintMore
                            FROM TSysMenuAlbAct MENUAUT 
                        ) AS MNUDATAAUT ON  USERMENU.FTMnuCode = MNUDATAAUT.FTMnuCode 
                        ORDER BY USERMENU.FNGmnModShwSeq ASC,USERMENU.FNGmnShwSeq ASC,USERMENU.FNMnuSeq ASC,USERMENU.FNMnuLevel ASC
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aList  = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $aList,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        unset($nLngID);
        unset($tRoleCode);
        unset($tSQL);
        unset($oQuery);
        unset($aList);
        return $aResult;
    }

    // Functionality: Get Data Edit Menu Role Edit
    // Parameters:  Function Parameter
    // Creator: 27/06/2019 Saharat(Golf)
    // Last Modified: -
    // Return: array
    // ReturnType: array
    public function FSaMGetDataRoleMenuRptEdit($paDataWhere)
    {
        $nLngID     = $paDataWhere['FNLngID'];
        $tRoleCode  = $paDataWhere['FTRolCode'];
        $tSQL       = " SELECT
                            RPM.FTGrpRptModCode,
                            UFR.FTUfrStaAlw,
                            RPM.FNGrpRptModShwSeq,
                            RPML.FNGrpRptModName,
                            RPG.FTGrpRptCode,
                            RPGL.FTGrpRptName,
                            RPT.FTRptCode,
                            RPTL.FTRptName
                        FROM TCNTUsrFuncRpt             UFR     WITH(NOLOCK)
                        LEFT JOIN TSysReport            RPT     WITH(NOLOCK)    ON UFR.FTUfrGrpRef      = RPT.FTGrpRptCode      AND  UFR.FTUfrRef   = RPT.FTRptCode
                        LEFT JOIN TSysReport_L          RPTL    WITH(NOLOCK)    ON RPT.FTRptCode        = RPTL.FTRptCode        AND  RPTL.FNLngID   = $nLngID 
                        LEFT JOIN TSysReportGrp         RPG     WITH(NOLOCK)    ON RPT.FTGrpRptCode     = RPG.FTGrpRptCode      AND  RPT.FTGrpRptModCode = RPG.FTGrpRptModCode
                        LEFT JOIN TSysReportGrp_L       RPGL    WITH(NOLOCK)    ON RPG.FTGrpRptCode     = RPGL.FTGrpRptCode     AND RPGL.FNLngID    = $nLngID 
                        LEFT JOIN TSysReportModule      RPM     WITH(NOLOCK)    ON RPG.FTGrpRptModCode  = RPM.FTGrpRptModCode
                        LEFT JOIN TSysReportModule_L    RPML    WITH(NOLOCK)    ON RPM.FTGrpRptModCode  = RPML.FTGrpRptModCode  AND RPML.FNLngID    = $nLngID 
                        WHERE 1=1
                        AND UFR.FTRolCode           = '$tRoleCode'
                        AND RPG.FTGrpRptStaUse      = 1
                        AND RPM.FTGrpRptModStaUse   = 1
                        AND RPT.FTRptStaUse         = 1
                        ORDER BY RPM.FNGrpRptModShwSeq ASC,RPG.FNGrpRptShwSeq ASC 
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aList      = $oQuery->result_array();
            $aResult    = array(
                'raItems'   => $aList,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        unset($nLngID);
        unset($tRoleCode);
        unset($tSQL);
        unset($oQuery);
        unset($aList);
        return $aResult;
    }

    //Functionality : Get Branch From Agency
    //Parameters : FTAgnCode
    //Creator : 19/05/2020 Witsarut(Bel)
    //Return : array result from db
    //Return Type : array
    public function FSaMRoleGetBchFromAgnCode($ptAgnCode){
        $tSQL  = "  SELECT 
                        FTBchCode
                    FROM TCNMBranch WITH (NOLOCK)
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

      //Functionality : Count Branch From Agency
    //Parameters : FTAgnCode
    //Creator : 19/05/2020 Witsarut(Bel)
    //Return : array result from db
    //Return Type : array
    public function FSaMRoleCountNRolCodeFromUsrSpc($ptAgnCode, $ptBchCode, $ptRoleCode){
        try{
            $tSQL = "  SELECT COUNT (FTRolCode) AS counts 
                    FROM  TCNMUsrRoleSpc WITH(NOLOCK)
                    WHERE  FTRolCode = '$ptRoleCode' ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail    = $oQuery->result();
                $aResult= array(
                    'raItems'   => $oDetail[0],
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //if data not found
                $aResult    = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found',
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    // Delete TCNMUsrRoleSpc ก่อน แล้วจึง loop
    // Create By Witsarut 24/02/2020
    public function FSaMDelRoleCode($paData){
        try{
            $this->db->where_in('FTRolCode', $paData);
            $this->db->delete('TCNMUsrRoleSpc');
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // ===============================================  Export  Data ==================================================================


        // Function : Get Data TCNMUsrRoleSpc
        // Create By Witsarut 28-10-2020
        public function FSaMROlExportDetailUsrRoleSpc($paData){
            $tRoleCode  = $paData['tRoleCode'];
            $nLngID     = $this->session->userdata("tLangEdit");

            $tSQL       = " SELECT 
                                ROLSPC.FTRolCode,
                                ROLSPC.FTAgnCode,
                                ROLSPC.FTBchCode,
                                AGN_L.FTAgnName,
                                BCH_L.FTBchName
                        FROM TCNMUsrRoleSpc ROLSPC WITH(NOLOCK)
                        LEFT JOIN TCNMUsrRole ROL WITH(NOLOCK) ON ROLSPC.FTRolCode = ROL.FTRolCode
                        LEFT JOIN TCNMUsrRole_L ROL_L WITH(NOLOCK) ON ROLSPC.FTRolCode = ROL_L.FTRolCode AND ROL_L.FNLngID = $nLngID
                        LEFT JOIN TCNMAgency AGN WITH(NOLOCK) ON ROLSPC.FTAgnCode = AGN.FTAgnCode
                        LEFT JOIN TCNMAgency_L AGN_L WITH(NOLOCK) ON ROLSPC.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                        LEFT JOIN TCNMBranch BCH WITH(NOLOCK) ON ROLSPC.FTBchCode = BCH.FTBchCode
                        LEFT JOIN TCNMBranch_L BCH_L WITH(NOLOCK) ON ROLSPC.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                        WHERE ROLSPC.FTRolCode = '$tRoleCode'  "; 

                $oQuery = $this->db->query($tSQL);

                if ($oQuery->num_rows() > 0) {
                    $aItems = $oQuery->result_array();
                    $aResult = array(
                        'raItems' => $aItems,
                        'rtCode' => '1',
                        'rtDesc' => 'success',
                    );
                } else {
                    $aResult = array(
                        'raItems'   => array(),
                        'rtCode'    => '800',
                        'rtDesc'    => 'data not found'
                    );
                }
            return $aResult;

        }

        // Function : Get Data TCNTUsrMenu
        // Create By Witsarut 28-10-2020
        public function FSaMROlExportDetailUsrMenu($paData){
            $tRoleCode  = $paData['tRoleCode'];
            $nLngID     = $this->session->userdata("tLangEdit");
    
            $tSQL   = " SELECT DISTINCT
                            USRM.FTRolCode,
                            MENU.FTGmnModCode,
                            MOD_L.FTGmnModName,
                            MOD.FNGmnModShwSeq,
                            MOD.FTGmnModCode AS FTGmnCode,
                            MOD_L.FTGmnModName AS FTGmnName,
                            '0' AS FNGmnShwSeq,
                            MENU.FTMnuCode,
                            MNU_L.FTMnuName,
                            MENU.FNMnuSeq,
                            MENU.FNMnuLevel,
                            ISNULL(USRM.FTAutStaRead, 1) AS FTAutStaRead,
                            ISNULL(USRM.FTAutStaAdd, 1) AS FTAutStaAdd,
                            ISNULL(USRM.FTAutStaDelete, 1) AS FTAutStaDelete,
                            ISNULL(USRM.FTAutStaEdit, 1) AS FTAutStaEdit,
                            ISNULL(USRM.FTAutStaCancel, 1) AS FTAutStaCancel,
                            ISNULL(USRM.FTAutStaAppv, 1) AS FTAutStaAppv,
                            ISNULL(USRM.FTAutStaPrint, 1) AS FTAutStaPrint,
                            ISNULL(USRM.FTAutStaPrintMore, 1) AS FTAutStaPrintMore
                        FROM
                            TCNTUsrMenu USRM
                        LEFT JOIN TSysMenuGrp MGP ON USRM.FTGmnCode = MGP.FTGmnCode
                        LEFT JOIN TSysMenuGrp_L MGPL ON USRM.FTGmnCode = MGPL.FTGmnCode AND MGPL.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList MENU ON USRM.FTMnuCode = MENU.FTMnuCode
                        LEFT JOIN TSysMenuList_L MNU_L ON USRM.FTMnuCode = MNU_L.FTMnuCode AND MNU_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrpModule MOD ON MENU.FTGmnModCode = MOD.FTGmnModCode
                        LEFT JOIN TSysMenuGrpModule_L MOD_L ON MOD.FTGmnModCode = MOD_L.FTGmnModCode AND MOD_L.FNLngID = $nLngID
                        WHERE 1=1 ";
                    if(!empty($tRoleCode)){
                       $tSQL   .= " AND USRM.FTRolCode IN ('$tRoleCode') ";
                    }
                    $tSQL   .= " AND MENU.FNMnuLevel = 0
                        AND MENU.FTMnuStaUse = 1
                        AND MOD.FTGmnModStaUse = 1
                        UNION
                        SELECT DISTINCT
                            USRM.FTRolCode,
                            MENU.FTGmnModCode,
                            MOD_L.FTGmnModName,
                            MOD.FNGmnModShwSeq,
                            MGP.FTGmnCode,
                            MGPL.FTGmnName,
                            MGP.FNGmnShwSeq,
                            MENU.FTMnuCode,
                            MNU_L.FTMnuName,
                            MENU.FNMnuSeq,
                            MENU.FNMnuLevel,
                            ISNULL(USRM.FTAutStaRead, 1) AS FTAutStaRead,
                            ISNULL(USRM.FTAutStaAdd, 1) AS FTAutStaAdd,
                            ISNULL(USRM.FTAutStaDelete, 1) AS FTAutStaDelete,
                            ISNULL(USRM.FTAutStaEdit, 1) AS FTAutStaEdit,
                            ISNULL(USRM.FTAutStaCancel, 1) AS FTAutStaCancel,
                            ISNULL(USRM.FTAutStaAppv, 1) AS FTAutStaAppv,
                            ISNULL(USRM.FTAutStaPrint, 1) AS FTAutStaPrint,
                            ISNULL(USRM.FTAutStaPrintMore, 1) AS FTAutStaPrintMore
                        FROM
                            TCNTUsrMenu USRM
                        LEFT JOIN TSysMenuGrp MGP ON USRM.FTGmnCode = MGP.FTGmnCode
                        LEFT JOIN TSysMenuGrp_L MGPL ON USRM.FTGmnCode = MGPL.FTGmnCode AND MGPL.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList MENU ON USRM.FTMnuCode = MENU.FTMnuCode
                        LEFT JOIN TSysMenuList_L MNU_L ON USRM.FTMnuCode = MNU_L.FTMnuCode AND MNU_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrpModule MOD ON MENU.FTGmnModCode = MOD.FTGmnModCode
                        LEFT JOIN TSysMenuGrpModule_L MOD_L ON MOD.FTGmnModCode = MOD_L.FTGmnModCode AND MOD_L.FNLngID = $nLngID
                        WHERE 1=1 ";
                    if(!empty($tRoleCode)){
                       $tSQL   .= " AND USRM.FTRolCode IN ('$tRoleCode') ";
                    }
                    $tSQL .= " AND MOD.FTGmnModStaUse  = 1
                               AND MGP.FTGmnStaUse     = 1
                               AND MENU.FTMnuStaUse     = 1
                               ORDER BY FNGmnModShwSeq,FTGmnModCode,FNGmnShwSeq,FTGmnCode,FNMnuSeq,FTMnuCode
                      ";
         
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $oList = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $oList,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            } else {
                $aResult = array(
                    'raItems'   => array(),
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found'
                );
            }
            unset($nLngID);
            unset($tSQL);
            unset($oQuery);
            unset($oList);
            return $aResult;
        }

        // Function : Get Data RptMenu
        // Create By Witsarut 28-10-2020
        public function FSaMROlExportDetailRptMenu($paData){
            $tRoleCode  = $paData['tRoleCode'];
            $nLngID     = $this->session->userdata("tLangEdit");

            $tSQL   =   "   SELECT DISTINCT
                                RPM.FTGrpRptModCode,
                                RPM.FNGrpRptModShwSeq,
                                RPG.FNGrpRptShwSeq,
                                RPML.FNGrpRptModName,
                                RPG.FTGrpRptCode,
                                RPGL.FTGrpRptName,
                                RPT.FTRptCode,
                                RPTL.FTRptName    
                            FROM TCNTUsrFuncRpt UFR
                            INNER JOIN TSysReport RPT WITH (NOLOCK) ON UFR.FTUfrGrpRef = RPT.FTGrpRptCode AND UFR.FTUfrRef = RPT.FTRptCode
                            LEFT JOIN TSysReport_L RPTL WITH (NOLOCK) ON RPT.FTRptCode = RPTL.FTRptCode AND RPTL.FNLngID = $nLngID
                            LEFT JOIN TSysReportGrp RPG WITH (NOLOCK) ON UFR.FTUfrGrpRef = RPG.FTGrpRptCode
                            LEFT JOIN TSysReportGrp_L RPGL WITH (NOLOCK) ON RPG.FTGrpRptCode = RPGL.FTGrpRptCode AND RPGL.FNLngID = $nLngID
                            LEFT JOIN TSysReportModule RPM WITH (NOLOCK) ON RPT.FTGrpRptModCode = RPM.FTGrpRptModCode 
                            LEFT JOIN TSysReportModule_L RPML WITH (NOLOCK) ON RPM.FTGrpRptModCode = RPML.FTGrpRptModCode AND RPML.FNLngID = $nLngID
                            WHERE 1 = 1
                            AND UFR.FTUfrType = 2
                            AND RPG.FTGrpRptStaUse = 1
                            AND RPM.FTGrpRptModStaUse = 1
                            AND RPT.FTRptStaUse = 1 ";

                    if(!empty($tRoleCode)){
                        $tSQL   .= " AND UFR.FTRolCode IN ('$tRoleCode') ";
                    }

                    $tSQL   .= " ORDER BY
                                    RPM.FNGrpRptModShwSeq ASC,
                                    RPG.FNGrpRptShwSeq ASC
                    ";

                    $oQuery = $this->db->query($tSQL);

                    if ($oQuery->num_rows() > 0) {
                        $oList = $oQuery->result_array();
                        $aResult = array(
                            'raItems'   => $oList,
                            'rtCode'    => '1',
                            'rtDesc'    => 'success',
                        );
                    } else {
                        $aResult = array(
                            'raItems'   => array(),
                            'rtCode'    => '800',
                            'rtDesc'    => 'data not found'
                        );
                    }
                unset($nLngID);
                unset($tSQL);
                unset($oQuery);
                unset($oList);
                return $aResult;
        }

        // Function : Get Data TPSMFuncHD
        // Create By Witsarut 28-10-2020
        public function FSaMROlExportDetailFuncSetting($paData){
            $tRoleCode  = $paData['tRoleCode'];
            $nLngID     = $this->session->userdata("tLangEdit");

            $tSQL = " SELECT DISTINCT
                            HD.FTGhdApp,
                            HD.FTKbdScreen,
                            APL.FTAppName,
                            DTL.FTGdtName,
                            DT.FTGhdCode,
                            DT.FTSysCode,
                            DT.FTGdtCallByName,
                            DT.FNGdtFuncLevel,
                            DT.FTGdtStaUse,
                            (SELECT FUNC.FTUfrStaAlw FROM TCNTUsrFuncRpt FUNC WHERE FUNC.FTGhdApp = HD.FTGhdApp AND FUNC.FTUfrGrpRef = HD.FTGhdCode AND FUNC.FTUfrRef = DT.FTSysCode AND  FUNC.FTUfrType = '1' AND FUNC.FTRolCode='$tRoleCode'  ) AS FTUfrStaAlw
                        FROM TPSMFuncHD HD WITH (NOLOCK)
                        INNER JOIN TPSMFuncDT DT WITH (NOLOCK) ON HD.FTGhdCode = DT.FTGhdCode
                        INNER JOIN TPSMFuncDT_L DTL WITH (NOLOCK) ON DT.FTGhdCode = DTL.FTGhdCode AND DT.FTSysCode = DTL.FTSysCode AND DTL.FNLngID = $nLngID
                        INNER JOIN TSysApp_L APL WITH (NOLOCK) ON HD.FTGhdApp = APL.FTAppCode AND APL.FNLngID = $nLngID
                        LEFT JOIN TCNTUsrFuncRpt USRFUNC WITH (NOLOCK) ON USRFUNC.FTGhdApp = HD.FTGhdApp AND USRFUNC.FTUfrGrpRef = HD.FTGhdCode AND USRFUNC.FTUfrRef = DT.FTSysCode AND USRFUNC.FTUfrType = '1' 
                        WHERE DT.FTGdtSysUse = '1' 
                        AND DT.FTGdtStaUse = '1' ";
                if(!empty($tRoleCode)){
                    $tSQL .= "AND USRFUNC.FTRolCode IN('$tRoleCode')";
                }
              
                $tSQL .=" ORDER BY APL.FTAppName ASC, HD.FTKbdScreen ASC, DTL.FTGdtName ASC
                ";

                $oQuery = $this->db->query($tSQL);

                if ($oQuery->num_rows() > 0) {
                    $aItems = $oQuery->result_array();
                    $aResult = array(
                        'raItems' => $aItems,
                        'rtCode' => '1',
                        'rtDesc' => 'success',
                    );
                } else {
                    $aResult = array(
                        'raItems'   => array(),
                        'rtCode'    => '800',
                        'rtDesc'    => 'data not found'
                    );
                }
            return $aResult;

        }

       
        // function insert ตาราง TCNTUsrMenu
        // Create By Witsarut 31-10-2020 
        public function FSaMROlInsertUsrMenu($paDataUsrRole){
            try{

                $aInsUsrMenu  = array(
                    'FTRolCode'         => $paDataUsrRole['FTRolCode'],
                    'FTGmnCode'         => $paDataUsrRole['FTGmnCode'],
                    'FTMnuParent'       => $paDataUsrRole['FTGmnCode'],
                    'FTMnuCode'         => $paDataUsrRole['FTMnuCode'],
                    'FTAutStaFull'      => 0,
                    'FTAutStaRead'      => $paDataUsrRole['FTAutStaRead'],
                    'FTAutStaAdd'       => $paDataUsrRole['FTAutStaAdd'],
                    'FTAutStaEdit'      => $paDataUsrRole['FTAutStaEdit'],
                    'FTAutStaDelete'    => $paDataUsrRole['FTAutStaDelete'],
                    'FTAutStaCancel'    => $paDataUsrRole['FTAutStaCancel'],
                    'FTAutStaAppv'      => $paDataUsrRole['FTAutStaAppv'],
                    'FTAutStaPrint'     => $paDataUsrRole['FTAutStaPrint'],
                    'FTAutStaPrintMore' => $paDataUsrRole['FTAutStaPrintMore'],
                    'FTAutStaFavorite'  => 0,
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                );

                $this->db->insert('TCNTUsrMenu', $aInsUsrMenu);

            }catch(Exception $Error){
                echo $Error;
            }

        }

        //function insert ตาราง TCNTUsrFuncRpt
        //create By Witsarut 31-10-2020
        public function FSaMROlInsertUsrFuncRpt($paDataUsrFuncRpt){
            try{
                $aInsUsrFuncRpt = array(
                    'FTRolCode'         => $paDataUsrFuncRpt['FTRolCode'],
                    'FTUfrType'         => 2,
                    'FTUfrGrpRef'       => $paDataUsrFuncRpt['FTGrpRptCode'],
                    'FTUfrRef'          => $paDataUsrFuncRpt['FTRptCode'],
                    'FTUfrStaAlw'       => '1',
                    'FTUfrStaFavorite'  => 0,
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                ); 

                $this->db->insert('TCNTUsrFuncRpt', $aInsUsrFuncRpt);

            }catch(Exception $Error){
                echo $Error;
            }
        }

        //function insert ตาราง TPSMFuncHD
        //create By Witsarut 31-10-2020
        public function FSaMROlInsertFuncHD($paDataFuncHD){
            try{
                
                $aInsUsrFuncHD = array(
                    'FTRolCode'         => $paDataFuncHD['FTRolCode'],
                    'FTUfrType'         => 1,
                    'FTUfrGrpRef'       => $paDataFuncHD['FTGhdCode'],
                    'FTUfrRef'          => $paDataFuncHD['FTSysCode'],
                    'FTGhdApp'          => $paDataFuncHD['FTGhdApp'],
                    'FTUfrStaAlw'       => '1',
                    'FTUfrStaFavorite'  => 0,
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                );

                $this->db->insert('TCNTUsrFuncRpt', $aInsUsrFuncHD);

            }catch(Exception $Error){
                echo $Error;
            }
        }


        //function insert ตาราง TCNMUsrRoleSpc
        //create By Witsarut 31-10-2020
        public function FSaMROlInsertUsrRoleSpc($paDataUsrRoleSpc){
            try{
                $aResult = array(
                    'FTRolCode'     => $paDataUsrRoleSpc['FTRolCode'],
                    'FTAgnCode'     => $paDataUsrRoleSpc['FTAgnCode'],
                    'FTBchCode'     => $paDataUsrRoleSpc['FTBchCode'],
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                );
                $this->db->insert('TCNMUsrRoleSpc', $aResult);
                
            }catch(Exception $Error){
                echo $Error;
            }
        }


    // ===============================================  Export  Data ==================================================================


    // Create By Napat(Jame) 07/01/2021
    public function FSxMRoleAddUpdateUsrRoleChain($paData){
        $tSesUsrRoleCodeMulti   = $this->session->userdata("tSesUsrRoleCodeMulti");
        $tSesUserCode           = $this->session->userdata("tSesUserCode");
        $tRolCode               = $paData['FTRolCode'];
        $tSQL  = "  SELECT DISTINCT
                        FTRolCode
                    FROM TCNMUsrRoleChain WITH(NOLOCK) 
                    WHERE FTRolChain IN ($tSesUsrRoleCodeMulti) 
                    AND FNRolType = 2
                ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){

            // Insert Parents
            $tSQL = "   INSERT INTO TCNMUsrRoleChain (FTRolCode,FNRolType,FTRolChain,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            '$tRolCode'         AS FTRolCode,
                            '1'                 AS FNRolType,
                            FTRolCode           AS FTRolChain,
                            GETDATE()           AS FDLastUpdOn,
                            '$tSesUserCode'     AS FTLastUpdBy,
                            GETDATE()           AS FDCreateOn,
                            '$tSesUserCode'     AS FTCreateBy
                        FROM TCNMUsrActRole WITH(NOLOCK)
                        WHERE FTUsrCode = '$tSesUserCode'
                    ";
            $this->db->query($tSQL);

            // Insert Chain
            $tSQL  = "  INSERT INTO TCNMUsrRoleChain (FTRolCode,FNRolType,FTRolChain,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT DISTINCT
                            '$tRolCode'         AS FTRolCode,
                            '2'                 AS FNRolType,
                            FTRolChain          AS FTRolChain,
                            GETDATE()           AS FDLastUpdOn,
                            '$tSesUserCode'     AS FTLastUpdBy,
                            GETDATE()           AS FDCreateOn,
                            '$tSesUserCode'     AS FTCreateBy
                        FROM TCNMUsrRoleChain WITH(NOLOCK) 
                        WHERE FTRolCode IN ($tSesUsrRoleCodeMulti) 
                          AND FNRolType = 2
                        
                        UNION ALL

                        SELECT DISTINCT
                            '$tRolCode'         AS FTRolCode,
                            '2'                 AS FNRolType,
                            '$tRolCode'         AS FTRolChain,
                            GETDATE()           AS FDLastUpdOn,
                            '$tSesUserCode'     AS FTLastUpdBy,
                            GETDATE()           AS FDCreateOn,
                            '$tSesUserCode'     AS FTCreateBy
                    ";
            $this->db->query($tSQL);

        }
        
    }



        /**
     * Functionality : Get Setting Function List (TPSMFuncHD, TPSMFuncDT, TPSMFuncDT_L)
     * Parameters : -
     * Creator : 23/04/2020 piya
     * Last Modified : -
     * Return : Setting Funtion Data
     * Return Type : array
     */
    public function FSaMGetNotiSettingList($paParams = [])
    {
        $nLngID = $paParams['FNLngID'];
        $tRoleCode = $paParams['FTRolCode'];
        
        $tSQL = "SELECT
                    NOTI.FTNotCode,
                    NOTI.FTNotStaResponse,
	                NOTI_L.FTNotTypeName,
                    RPTSPC.FTRptCode 
                FROM
                    TCNSNoti NOTI WITH(NOLOCK)
                LEFT OUTER JOIN TCNSNoti_L NOTI_L WITH(NOLOCK) ON NOTI.FTNotCode = NOTI_L.FTNotCode AND NOTI_L.FNLngID = $nLngID
                LEFT OUTER JOIN TCNSRptSpc RPTSPC WITH(NOLOCK) ON NOTI.FTNotCode = RPTSPC.FTRptCode AND RPTSPC.FTRolCode = '$tRoleCode'  ";
   

        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            $aItems = $oQuery->result_array();
            $aResult = array(
                'raItems' => $aItems,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found'
            );
        }
        return $aResult;
    }
}
