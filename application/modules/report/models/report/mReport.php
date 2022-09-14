<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mReport extends CI_Model {

    // Functionality: Get Modlue Report
    // Parameters:  Function Parameter
    // Creator: 21/03/2018 Wasin(Yoshi)
    // Last Modified :
    // Return : Array Data Menu List Report
    // Return Type: Array
    public function FSaMDataRptModules($paWhereData) {
        $tRptGrpMod = $paWhereData['tRptGrpMod'];
        $nLngID = $paWhereData['nLngID'];
        $tSQL = " SELECT DISTINCT
                            RPTMOD.FTGrpRptModCode      AS FTRptModCode,
                            RPTMOD.FNGrpRptModShwSeq    AS FTRptModSeq,
                            RPTMOD_L.FNGrpRptModName	AS FTRptModName
                        FROM TSysReportModule RPTMOD WITH(NOLOCK)
                        LEFT JOIN TSysReportModule_L RPTMOD_L WITH(NOLOCK) ON RPTMOD.FTGrpRptModCode = RPTMOD_L.FTGrpRptModCode AND RPTMOD_L.FNLngID = $nLngID
                        WHERE 1=1
                        AND RPTMOD.FTGrpRptModCode = '$tRptGrpMod'
                        AND RPTMOD.FTGrpRptModStaUse = 1 ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataModules = $oQuery->row_array();
            $aDataReturn = array(
                'raItems' => $aDataModules,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aDataReturn = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        return $aDataReturn;

    }

    // Functionality: Get Data Menu List Report Analysis
    // Parameters:  Function Parameter
    // Creator: 11/12/2018 Wasin(Yoshi)
    // Last Modified : 21/03/2019 Wasin (Yoshi)
    // Return : Array Data Menu List Report
    // Return Type: Array
    public function FSaMDataRptMunuList($paWhereData) {
        $tRptGrpMod     = $paWhereData['tRptGrpMod'];
        $nLngID         = $paWhereData['nLngID'];
        $tUsrID         = $this->session->userdata("tSesUsername");

        $tRptRoleCode = $this->FStMGEtRoleUserLogin($tUsrID);
        if( $tRptGrpMod != 'SPC' ){
            $tSQL = "   SELECT
                            /*USR.FTUsrCode               AS FTRptUsrCode,*/
                            TSRPTMOD.FTGrpRptModCode    AS FTRptModCode,
                            TSRPTMOD.FNGrpRptModShwSeq  AS FTRptModShwSeq,
                            /*TSRPTMOD_L.FNGrpRptModName  AS FTRptModName,*/
                            TSRPTGRP.FTGrpRptCode       AS FTRptGrpCode,
                            TSRPTGRP.FNGrpRptShwSeq     AS FTRptGrpSeq,
                            TSRPTGRP_L.FTGrpRptName     AS FTRptGrpName,
                            TSRPT.FTRptCode             AS FTRptCode,
                            TSRPT.FTRptSeqNo            AS FTRptSeq,
                            TSRPT_L.FTRptName           AS FTRptName,
                            TSRPT.FTRptRoute            AS FTRptRoute
                        FROM TCNMUser AS USR WITH(NOLOCK)
                        LEFT JOIN (
                            SELECT DISTINCT
                                UMRPTS.FTUfrType,
                                UMRPTS.FTUfrRef,
                                '$tUsrID' AS UsrCode
                            FROM TCNTUsrFuncRpt UMRPTS WITH(NOLOCK)
                            WHERE UMRPTS.FTRolCode IN($tRptRoleCode)
                        ) AS UMNRPT ON UMNRPT.UsrCode = USR.FTUsrCode
                        LEFT JOIN TSysReport AS TSRPT WITH(NOLOCK) ON UMNRPT.FTUfrRef = TSRPT.FTRptCode
                        LEFT JOIN TSysReport_L AS TSRPT_L WITH(NOLOCK) ON TSRPT.FTRptCode = TSRPT_L.FTRptCode AND TSRPT_L.FNLngID = $nLngID
                        LEFT JOIN TSysReportGrp AS TSRPTGRP WITH(NOLOCK) ON TSRPT.FTGrpRptCode = TSRPTGRP.FTGrpRptCode
                        LEFT JOIN TSysReportGrp_L AS TSRPTGRP_L	WITH(NOLOCK) ON TSRPTGRP.FTGrpRptCode = TSRPTGRP_L.FTGrpRptCode AND TSRPTGRP_L.FNLngID = $nLngID
                        LEFT JOIN TSysReportModule	AS TSRPTMOD WITH(NOLOCK) ON TSRPT.FTGrpRptModCode = TSRPTMOD.FTGrpRptModCode
                        LEFT JOIN TSysReportModule_L AS TSRPTMOD_L WITH(NOLOCK) ON TSRPTMOD.FTGrpRptModCode = TSRPTMOD_L.FTGrpRptModCode AND TSRPTMOD_L.FNLngID = $nLngID
                        WHERE 1=1
                        AND USR.FTUsrCode = '$tUsrID'
                        AND UMNRPT.FTUfrType = 2
                        AND TSRPT.FTRptStaUse = 1
                        AND TSRPTGRP.FTGrpRptStaUse = 1
                        AND TSRPTMOD.FTGrpRptModStaUse	= 1
                        AND TSRPT.FTGrpRptModCode = '$tRptGrpMod'
                        ORDER BY TSRPTMOD.FNGrpRptModShwSeq ASC,TSRPTGRP.FNGrpRptShwSeq ASC,TSRPT.FTRptSeqNo ASC
            ";
        }else{
            $tUsrLoginLevel     = $this->session->userdata("tSesUsrLoginLevel");
            $bIsHaveAgn         = $this->session->userdata("bIsHaveAgn");
            $tUsrAgnCode        = $this->session->userdata("tSesUsrAgnCode");
            $tUsrBchCodeMulti   = $this->session->userdata("tSesUsrBchCodeMulti");
            $tUsrMerCode        = $this->session->userdata("tSesUsrMerCode");
            $tUsrShpCodeMulti   = $this->session->userdata("tSesUsrShpCodeMulti");

            $tSQL = "   SELECT
                            1			                        AS FTRptModShwSeq,
                            'SPC'			                    AS FTRptModCode,
                            RSPC.FNRptGrpSeq			        AS FTRptGrpSeq,
                            RSPC.FTRptGrpCode			        AS FTRptGrpCode,
                            ISNULL(GRP_L.FTRptGrpName,'N/A')    AS FTRptGrpName,
                            RSPC.FNRptSeq				        AS FTRptSeq,
                            RSPC.FTRptCode				        AS FTRptCode,
                            ISNULL(RPT_L.FTRptName,'N/A')       AS FTRptName,
                            RSPC.FTRptRoute				        AS FTRptRoute
                        FROM TCNSRptSpc RSPC WITH(NOLOCK)
                        LEFT JOIN TCNSRptSpc_L RPT_L    WITH(NOLOCK) ON RSPC.FTRptCode = RPT_L.FTRptCode AND RPT_L.FNLngID = $nLngID
                        LEFT JOIN TCNSRptSpcGrp_L GRP_L WITH(NOLOCK) ON RSPC.FTRptGrpCode = GRP_L.FTRptGrpCode AND GRP_L.FNLngID = $nLngID
                        WHERE RSPC.FTRptStaActive = '1' AND ISNULL(RSPC.FTRptRoute,'') != '' AND ISNULL(RSPC.FTRptFilterCol,'') != ''
                    ";
            if( $tUsrLoginLevel != "HQ" ){
                if( $bIsHaveAgn ){
                    $tSQL .= " AND RSPC.FTAgnCode = '$tUsrAgnCode' ";
                }else{
                    $tSQL .= " AND ISNULL(RSPC.FTAgnCode,'') = '' ";
                }

                if( $tUsrLoginLevel == "BCH" || $tUsrLoginLevel == "SHP" ){
                    $tSQL .= " AND ( RSPC.FTBchCode IN ($tUsrBchCodeMulti) OR ( ISNULL(RSPC.FTBchCode,'') = '' ) ) ";
                }

                if( $tUsrMerCode != "" ){
                    $tSQL .= " AND ( RSPC.FTMerCode = '$tUsrMerCode' OR ( ISNULL(RSPC.FTMerCode,'') = '' ) ) ";
                }

                if( $tUsrLoginLevel == "SHP" ){
                    $tSQL .= " AND ( RSPC.FTShpCode IN ($tUsrShpCodeMulti) OR ( ISNULL(RSPC.FTShpCode,'') = '' ) ) ";
                }
            }

            $tSQL .= " ORDER BY RSPC.FTRptGrpCode ASC, RSPC.FNRptGrpSeq ASC, RSPC.FTRptCode ASC, RSPC.FNRptSeq ASC ";
        }
      
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        if ($oQuery->num_rows() > 0) {
            $aDataMenuList = $oQuery->result_array();
            $aDataReturn = array(
                'raItems' => $aDataMenuList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aDataReturn = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($tRptGrpMod);
        unset($nLngID);
        unset($tUsrID);
        unset($tSQL);
        unset($oQuery);
        unset($aDataMenuList);
        return $aDataReturn;
    }

    // Functionality: Get Data Role Code
    // Parameters:  Function Parameter
    // Creator: 30/03/2020 Nattakit(Nale)
    // Last Modified :
    // Return : Text  Role Code
    // Return Type: Array
    public function FStMGEtRoleUserLogin($pUserID){
        $tSqlRole = "
        SELECT FTRolCode FROM TCNMUsrActRole WITH(NOLOCK) WHERE FTUsrCode = '$pUserID'
        ";
        $query  = $this->db->query($tSqlRole);

        $aRole = $query->result_array();

        $nCount = FCNnHSizeOf($aRole);
        $tRoleCode = '';
        if(!empty($aRole)){
            $nK = 1;
            foreach($aRole AS $aData){
                $tRoleCode .=$aData['FTRolCode'];
                if($nCount!=$nK){
                  $tRoleCode .= ",";
                }
                $nK++;
            }
        }


        if($tRoleCode == '' || $tRoleCode == null){
            $tRoleCode = '00000';
        }else{
            $tRoleCode = $tRoleCode;
        }
        return $tRoleCode;

    }
    // Functionality: Get Data Condition Filter
    // Parameters:  Function Parameter
    // Creator: 11/12/2018 Wasin(Yoshi)
    // Last Modified : 28/03/2019 Wasin (Yoshi)
    // Return : Array Data Menu List Report
    // Return Type: Array
    public function FSaMDataRptConditionFilter($paWhereData) {
        $tRptModCode    = $paWhereData['tRptModCode'];
        $tRptGrpCode    = $paWhereData['tRptGrpCode'];
        $tRptCode       = $paWhereData['tRptCode'];
        $nLngID         = $paWhereData['nLngID'];
        if( $tRptModCode != 'SPC' ){
            $tSQL = "   SELECT
                            TSRPT.FTGrpRptModCode,
                            TSRPT.FTGrpRptCode,
                            TSRPT.FTRptCode,
                            TSRPT.FTRptFilterCol,
                            TSRPT.FTRptRoute
                        FROM TSysReport TSRPT WITH(NOLOCK)
                        WHERE TSRPT.FTGrpRptModCode = '$tRptModCode'
                        AND TSRPT.FTGrpRptCode      = '$tRptGrpCode'
                        AND TSRPT.FTRptCode         = '$tRptCode'
                        AND TSRPT.FTRptStaUse       = '1'
                    ";
        }else{
            $tUsrLoginLevel     = $this->session->userdata("tSesUsrLoginLevel");
            $bIsHaveAgn         = $this->session->userdata("bIsHaveAgn");
            $tUsrAgnCode        = $this->session->userdata("tSesUsrAgnCode");
            $tUsrBchCodeMulti   = $this->session->userdata("tSesUsrBchCodeMulti");
            $tUsrMerCode        = $this->session->userdata("tSesUsrMerCode");
            $tUsrShpCodeMulti   = $this->session->userdata("tSesUsrShpCodeMulti");

            $tSQL = "   SELECT
                            'SPC'               AS FTGrpRptModCode,
                            RSPC.FTRptGrpCode   AS FTGrpRptCode,
                            RSPC.FTRptCode      AS FTRptCode,
                            RSPC.FTRptFilterCol AS FTRptFilterCol,
                            RSPC.FTRptRoute     AS FTRptRoute
                        FROM TCNSRptSpc RSPC WITH(NOLOCK)
                        WHERE RSPC.FTRptGrpCode = '$tRptGrpCode'
                          AND RSPC.FTRptCode      = '$tRptCode'
                          AND RSPC.FTRptStaActive = '1'
                          AND ISNULL(RSPC.FTRptRoute,'') != '' 
                          AND ISNULL(RSPC.FTRptFilterCol,'') != ''
                    ";
            if( $tUsrLoginLevel != "HQ" ){
                if( $bIsHaveAgn ){
                    $tSQL .= " AND RSPC.FTAgnCode = '$tUsrAgnCode' ";
                }else{
                    $tSQL .= " AND ISNULL(RSPC.FTAgnCode,'') = '' ";
                }

                if( $tUsrLoginLevel == "BCH" || $tUsrLoginLevel == "SHP" ){
                    $tSQL .= " AND ( RSPC.FTBchCode IN ($tUsrBchCodeMulti) OR ( ISNULL(RSPC.FTBchCode,'') = '' ) ) ";
                }

                if( $tUsrMerCode != "" ){
                    $tSQL .= " AND ( RSPC.FTMerCode = '$tUsrMerCode' OR ( ISNULL(RSPC.FTMerCode,'') = '' ) ) ";
                }

                if( $tUsrLoginLevel == "SHP" ){
                    $tSQL .= " AND ( RSPC.FTShpCode IN ($tUsrShpCodeMulti) OR ( ISNULL(RSPC.FTShpCode,'') = '' ) ) ";
                }
            }

            $tSQL .= " ORDER BY RSPC.FNRptGrpSeq ASC, RSPC.FNRptSeq ASC ";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataMenuFilter = $oQuery->row_array();
            $aDataLoopFilter = $this->FSaMDataRptLoopFilter($aDataMenuFilter);
            $aDataItems = array(
                'rtGrpRptModCode' => $aDataMenuFilter['FTGrpRptModCode'],
                'rtGrpRptCode' => $aDataMenuFilter['FTGrpRptCode'],
                'rtRptCode' => $aDataMenuFilter['FTRptCode'],
                'rtRptRoute' => $aDataMenuFilter['FTRptRoute'],
                'raRptFilterCol' => $aDataLoopFilter,
            );
            $aDataReturn = array(
                'raItems' => $aDataItems,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aDataReturn = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($tRptModCode);
        unset($tRptGrpCode);
        unset($tRptCode);
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($aDataMenuFilter);
        unset($aDataLoopFilter);
        unset($aDataItems);
        return $aDataReturn;
    }

    // Functionality: Get Data Filter
    // Parameters:  Function Parameter
    // Creator: 28/03/2019 Wasin (Yoshi)
    // Last Modified : 04/05/2022 Napat(Jame) เปลี่ยนจากการ Loop Query เป็นการใช้ Where In เพื่อลดการใช้งาน Query
    // Return : Array Data Condtion Filter
    // Return Type: Array
    public function FSaMDataRptLoopFilter($paDataReport) {
        if (isset($paDataReport) && !empty($paDataReport['FTRptFilterCol'])) {
            $tConditionRpt = $paDataReport['FTRptFilterCol'];
            $aDataCond = "'".str_replace(",","','",$tConditionRpt)."'";
            // $aDataCondSplit = explode(",", $tConditionRpt);
            // $aDataReturn = array();
            $nLangEdit = $_SESSION ['tLangEdit'];
            // foreach ($aDataCondSplit AS $nKey => $tRptFilterCode) {
                $tSQL = " SELECT
                                TSRPTF.FTRptGrpFlt ,
                                TSRPTF.FTRptFltCode,
                                TSRPTF_L.FTRptFltName,
                                TSRPTF.FTRptFltStaFrm,
                                TSRPTF.FTRptFltStaTo
                            FROM TSysReportFilter AS TSRPTF WITH(NOLOCK)
                            LEFT JOIN TSysReportFilter_L AS TSRPTF_L WITH(NOLOCK) ON TSRPTF.FTRptFltCode = TSRPTF_L.FTRptFltCode AND TSRPTF_L.FNLngID = $nLangEdit
                            WHERE TSRPTF.FTRptFltCode IN ($aDataCond)
                            ";
                $oQuery = $this->db->query($tSQL);
                if ($oQuery->num_rows() > 0) {
                    $aDataReturn = $oQuery->result_array();
                    // $aDataFilterData = $oQuery->row_array();
                    // array_push($aDataReturn, $aDataFilterData);
                }
            // }
            return $aDataReturn;
        } else {
            return array();
        }
    }

    // Functionality: Get Data Tax No In Company (ดึงข้อมูลเลขประจำตัวผู่เสียภาษี)
    // Parameters:  Function Parameter
    // Creator: 09/04/2019 Wasin (Yoshi)
    // Last Modified : -
    // Return :
    // Return Type:
    public function FSaMRptGetAddTaxNo($ptBchCode) {
        if (isset($ptBchCode) && !empty($ptBchCode)) {
            $tWhereBranch = " AND (FTAddRefCode = '" . $ptBchCode . "')";
        } else {
            $tWhereBranch = "";
        }
        $tSQL = "SELECT TOP 1 FTAddTaxNo FROM TCNMAddress_L WITH(NOLOCK)";
        $tSQL .= " WHERE 1 = 1";
        $tSQL .= " $tWhereBranch";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->result_array();
            $tAddTaxNo = $aData[0]['FTAddTaxNo'];
            if ($tAddTaxNo == '') {
                $tAddTaxNo = '-';
            }
        } else {
            $tAddTaxNo = '-';
        }
        return $tAddTaxNo;
    }

    // Functionality: Get Data Address Comp Where Branch
    // Parameters:  Function Call Get Data
    // Creator: 18/07/2019 Wasin (Yoshi)
    // Last Modified : -
    // Return : Array Data Address Branch
    // Return Type: Array
    public function FSaMRptGetDataAddressByBranchComp($ptCompBranch, $pnLngID) {
        $tSQL = " SELECT
                        BCH.FTBchCode       AS FTCompCode,
                        BCH_L.FTBchName     AS FTCompName,
                        ADDL.FNLngID,
                        ADDL.FTAddGrpType,
                        ADDL.FTAddVersion,
                        ADDL.FTAddCountry,
                        ADDL.FTAddV1No,
                        ADDL.FTAddV1Soi,
                        ADDL.FTAddV1Village,
                        ADDL.FTAddV1Road,
                        ADDL.FTAddV1SubDist,
                        SUBDST_L.FTSudName,
                        ADDL.FTAddV1DstCode,
                        DST_L.FTDstName,
                        ADDL.FTAddV1PvnCode,
                        ADDL.FTAddTaxNo,
                        PVN_L.FTPvnName,
                        ADDL.FTAddV1PostCode,
                        ADDL.FTAddV2Desc1,
                        ADDL.FTAddV2Desc2
                    FROM TCNMAddress_L          ADDL        WITH(NOLOCK)
                    LEFT JOIN TCNMBranch        BCH         WITH(NOLOCK) ON ADDL.FTAddRefCode   = BCH.FTBchCode
                    LEFT JOIN TCNMBranch_L      BCH_L       WITH(NOLOCK) ON BCH.FTBchCode       = BCH_L.FTBchCode       AND BCH_L.FNLngID       = $pnLngID
                    LEFT JOIN TCNMSubDistrict   SUBDST      WITH(NOLOCK) ON ADDL.FTAddV1SubDist = SUBDST.FTSudCode
                    LEFT JOIN TCNMSubDistrict_L SUBDST_L    WITH(NOLOCK) ON SUBDST.FTSudCode    = SUBDST_L.FTSudCode    AND SUBDST_L.FNLngID    = $pnLngID
                    LEFT JOIN TCNMDistrict      DST         WITH(NOLOCK) ON ADDL.FTAddV1DstCode = DST.FTDstCode
                    LEFT JOIN TCNMDistrict_L    DST_L       WITH(NOLOCK) ON DST.FTDstCode       = DST_L.FTDstCode       AND DST_L.FNLngID       = $pnLngID
                    LEFT JOIN TCNMProvince      PVN         WITH(NOLOCK) ON ADDL.FTAddV1PvnCode = PVN.FTPvnCode
                    LEFT JOIN TCNMProvince_L    PVN_L       WITH(NOLOCK) ON PVN.FTPvnCode       = PVN_L.FTPvnCode       AND PVN_L.FNLngID       = $pnLngID
                    WHERE 1=1
                    AND ADDL.FTAddGrpType   = 1
                    AND ADDL.FNLngID        = $pnLngID
                    AND ADDL.FTAddRefCode   = '$ptCompBranch'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }

    /**
     * Functionality: Get Data History Export
     * Parameters: Event In Function
     * Creator: 15/08/2019 Wasin (Yoshi)
     * Last Modified : 18/10/2019 Piya
     * Return : Array Data In History Export
     * Return Type: Array
     */
    public function FCNaMGetDataTop1InTSysHisExport($paDataWhere) {
        $tCompName = $paDataWhere['FTComName'];
        $tUsrCode = $paDataWhere['FTUsrCode'];
        $tUsrSession = $paDataWhere['FTUsrSession'];
        $tRptCode = $paDataWhere['FTRptCode'];
        $tSQL = "
            SELECT TOP 1
                HisExp.FTComName,
                HisExp.FTUsrCode,
                HisExp.FTUsrSession,
                HisExp.FTRptCode,
                CONVERT(DATETIME,HisExp.FDCreateDate,121)   AS FDCreateDate,
                CONVERT(VARCHAR,HisExp.FDCreateDate,112)    AS FDDateSubscribe,
                CONVERT(VARCHAR,HisExp.FDCreateDate,108)    AS FDTimeSubscribe,
                CONVERT(DATETIME,HisExp.FDExprDate,121)     AS FDExprDate,
                HisExp.FTExpType,
                HisExp.FTFilter,
                HisExp.FTZipName,
                HisExp.FTZipPath,
                HisExp.FNTotalFile,
                HisExp.FNSuccessFile,
                HisExp.FTStaDownload,
                HisExp.FTStaZip,
                HisExp.FTStaCancelDownload
            FROM TSysHisExport HisExp WITH(NOLOCK)
            WHERE HisExp.FTExpType    = 'excel'
            AND HisExp.FTComName    = '$tCompName'
            AND HisExp.FTUsrCode    = '$tUsrCode'
            AND HisExp.FTUsrSession = '$tUsrSession'
            AND HisExp.FTRptCode    = '$tRptCode'
            AND HisExp.FTStaExpFail = '0'
            ORDER BY HisExp.FDCreateDate DESC
        ";
        // print_r($tSQL);
        // exit;
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }

    // Functionality: Update Status Cancel Download
    // Parameters: Event In Function
    // Creator: 16/08/2019 Wasin (Yoshi)
    // Last Modified : -
    // Return : Array Data In History Export
    // Return Type: Array
    public function FCNxMRPTUpdStaDownloadFile($paDataUpdStaCancel) {
        $this->db->where('FTComName', $paDataUpdStaCancel['FTComName']);
        $this->db->where('FTUsrCode', $paDataUpdStaCancel['FTUsrCode']);
        $this->db->where('FTUsrSession', $paDataUpdStaCancel['FTUsrSession']);
        $this->db->where('FTRptCode', $paDataUpdStaCancel['FTRptCode']);
        $this->db->where('FDCreateDate', $paDataUpdStaCancel['FDCreateDate']);
        $this->db->set('FTStaDownload', 1);
        $this->db->set('FTStaCancelDownload', 1);
        $this->db->update('TSysHisExport');
    }

    // Functionality: Get Bch By Agen Code
    // Parameters: Event In Function
    // Creator: 22/10/2020 Piya
    // Last Modified : -
    // Return : Data Bch
    // Return Type: Array
    public function FCNxMRPTGetBchByAgenCode(array $paParams = []) {
        $tAgenCode = $paParams['tAgenCode'];

        $tSQL = "
            SELECT
                BCH.FTBchCode,
                BCHL.FTBchName
            FROM TCNMBranch BCH WITH(NOLOCK)
            LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON BCHL.FTBchCode = BCH.FTBchCode
            WHERE BCH.FTAgnCode = '$tAgenCode'
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        } else {
            return array();
        }
    }

    // Create By : Napat(Jame) 29/03/2021 หาชื่อโมดูลรายงาน
    public function FStMGetRptModuleName($ptRptGrpMod){
        if( $ptRptGrpMod != "SPC" ){
            $nLngID = $this->session->userdata("tLangEdit");
            $tSQL = "   SELECT TOP 1
                            FNGrpRptModName AS FTRptModName
                        FROM TSysReportModule_L RPTM WITH(NOLOCK)
                        WHERE RPTM.FTGrpRptModCode = '$ptRptGrpMod'
                        AND FNLngID = $nLngID
                    ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $tRptModName = $oQuery->result_array()[0]['FTRptModName'];
            }else{
                $tRptModName = "N/A";
            }
        }else{
            $tRptModName = "รายงานพิเศษ";
        }
        return $tRptModName;
    }
}
