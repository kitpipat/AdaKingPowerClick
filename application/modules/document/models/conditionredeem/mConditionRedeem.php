<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mConditionRedeem extends CI_Model {

    // Functionality: Get Data Purchase Invoice HD List
    // Parameters: function parameters
    // Creator:  23/03/2020 Nattakit(Nale)
    // Return: Data Array
    // Return Type: Array
    public function FSaMRDHGetDataTableList($paDataCondition){
        $aRowLen                = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                 = $paDataCondition['FNLngID'];
        $aDatSessionUserLogIn   = $paDataCondition['aDatSessionUserLogIn'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList        = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaDocAct   = $aAdvanceSearch['tSearchStaDocAct'];
        $tSearchStaPrcStk   = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   =   "   SELECT c.* FROM (
                         SELECT
                            BCH.FTAgnCode,
                            A.*
                            FROM
                            (
                            SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM (
                                SELECT DISTINCT
                                    RDHD.FTBchCode,
                                    BCHL.FTBchName,
                                    RDHD.FTRdhDocNo,
                                    CONVERT(VARCHAR(10),RDHD.FDRdhDocDate,121) AS FDRdhDocDate,
                                    RDHD.FTRdhStaDoc,
                                    RDHD.FTRdhStaApv,
                                    RDHD.FTRdhStaPrcDoc,
                                    RDHDL.FTRdhName,
                                    RDHD.FDCreateOn,
                                    RDHD.FTUsrCode      AS FTUsrCodeIns,
                                    USRINS.FTUsrName    AS FTUsrNameIns,
                                    RDHD.FTRdhUsrApv    AS FTUsrCodeApv,
                                    USRAPV.FTUsrName    AS FTUsrNameApv,
                                    RDHD.FNRdhStaDocAct, 
			                        RDHD.FTRdhStaClosed, 
			                        RDHD.FDRdhDStop,
                                    RDHD.FDRdhTStop
                                FROM TARTRedeemHD RDHD WITH(NOLOCK)  
                                LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON RDHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                                LEFT JOIN TARTRedeemHD_L RDHDL WITH(NOLOCK) ON RDHD.FTBchCode = RDHDL.FTBchCode AND RDHD.FTRdhDocNo = RDHDL.FTRdhDocNo AND RDHDL.FNLngID = $nLngID
                                LEFT JOIN TCNMUser_L USRINS WITH(NOLOCK) ON RDHD.FTUsrCode = USRINS.FTUsrCode AND USRINS.FNLngID = $nLngID
                                LEFT JOIN TCNMUser_L USRAPV WITH(NOLOCK) ON RDHD.FTRdhUsrApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                                OUTER APPLY (  
                                    Select  *
                                    From TARTRedeemHDBch TARBCH1 
                                    WHERE TARBCH1.FTRdhDocNo = RDHD.FTRdhDocNo 
                                    AND  TARBCH1.FTBchCode = RDHD.FTBchCode 
                                    ) TARBCH
                                WHERE (  1=1
                                
        ";

        // Check User Login Branch
        if($this->session->userdata('tSesUsrLevel')!='HQ'){
            $tUserLoginBchCode  = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL   .=  "   AND RDHD.FTBchCode IN($tUserLoginBchCode)";
        }

        // Check User Login Shop
        if($this->session->userdata('nSesUsrShpCount')>0){
            $tUserLoginShpCode  = $this->session->userdata('tSesUsrShpCodeMulti');
            $tSQL   .=  "   AND RDHD.FTShpCode IN($tUserLoginShpCode) ";
        }

        // ต้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL   .=  "   AND ((RDHD.FTRdhDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(VARCHAR(10),RDHD.FDRdhDocDate,103) LIKE '%$tSearchList%'))";
        }

        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL   .= "    AND ((RDHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (RDHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL   .= " AND (
                            CONVERT(VARCHAR(10),RDHD.FDRdhDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) OR
                            CONVERT(VARCHAR(10),RDHD.FDRdhDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121)
                        )"
            ;
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND RDHD.FTRdhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(RDHD.FTRdhStaApv,'') = '' AND RDHD.FTRdhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND RDHD.FTRdhStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        if(isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)){
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (RDHD.FTRdhStaPrcDoc = '$tSearchStaPrcStk' OR ISNULL(RDHD.FTRdhStaPrcDoc,'') = '') ";
            } else {
                $tSQL .= " AND RDHD.FTRdhStaPrcDoc = '$tSearchStaPrcStk'";
            }
        }

        // ค้นหาสถานะเคลื่อนไหว
        if (isset($tSearchStaDocAct) && !empty($tSearchStaDocAct)) {
            if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND RDHD.FNRdhStaDocAct = 1";
            } else {
                $tSQL .= " AND RDHD.FNRdhStaDocAct = 0";
            }
        }

        $tSQL   .=" ) ";

        // if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
            if($this->session->userdata('tSesUsrLevel')!='HQ'){
            // $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
            $tUserLoginBchCode  = $this->session->userdata('tSesUsrBchCodeMulti');
                $tSQL  .="	OR (
                                RDHD.FTRdhStaApv = 1
                                AND (
                                    (ISNULL(TARBCH.FTRdhBchTo,'') = '')
                                    OR (
                                        TARBCH.FTRdhBchTo IN($tUserLoginBchCode)
                                        AND TARBCH.FTRdhStaType = 1
                                    )
                                OR (
                                        TARBCH.FTRdhBchTo NOT IN($tUserLoginBchCode)
                                        AND TARBCH.FTRdhStaType = 2
                                    )
                                )  ";
                   // ต้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
                if(isset($tSearchList) && !empty($tSearchList)){
                    $tSQL   .=  "   AND ((RDHD.FTRdhDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(VARCHAR(10),RDHD.FDRdhDocDate,103) LIKE '%$tSearchList%'))";
                }

                if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
                    $tSQL   .= "    AND ((RDHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (RDHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
                }
                     $tSQL  .=")";
        }
        

        $tSesUsrAgnCode  = $this->session->userdata('tSesUsrAgnCode');
        $tSQL   .=  ") Base"; 
        $tSQL   .=  ") A  LEFT JOIN TCNMBranch BCH WITH (NOLOCK) ON A.FTBchCode = BCH.FTBchCode";
        if($this->session->userdata('tSesUsrLevel')!='HQ'){
        $tSQL   .= " WHERE BCH.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(BCH.FTAgnCode,'') = '' ";
        }
        $tSQL   .= ") AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        // echo  $tSQL;
        // die();
        // print_r($tSQL);
      
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMRDHCountPageDocListAll($paDataCondition);
            $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1')? $aDataCountAllRow['rtCountData'] : 0;
            $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $oDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($nLngID);
        unset($aDatSessionUserLogIn);
        unset($aAdvanceSearch);
        unset($tSearchList);
        unset($tSearchBchCodeFrom);
        unset($tSearchBchCodeTo);
        unset($tSearchDocDateFrom);
        unset($tSearchDocDateTo);
        unset($tSearchStaDoc);
        // unset($tSearchStaDocAct);
        unset($tSearchStaPrcStk);
        unset($tUserLoginBchCode);
        unset($tUserLoginShpCode);
        unset($tSQL);
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality: Get Data Page All
    // Parameters: function parameters
    // Creator:  23/03/2020 Nattakit(Nale)
    // Return: Data Array
    // Return Type: Array
    public function FSnMRDHCountPageDocListAll($paDataCondition){
        $nLngID                 = $paDataCondition['FNLngID'];
        $aDatSessionUserLogIn   = $paDataCondition['aDatSessionUserLogIn'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList        = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        // $tSearchStaDocAct   = $aAdvanceSearch['tSearchStaDocAct'];
        $tSearchStaPrcStk   = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   =   "    SELECT COUNT(DISTINCT A.FTRdhDocNo) AS counts FROM 
                                (
                                    SELECT BCH.FTAgnCode ,RDH.FTRdhDocNo
                                    FROM TARTRedeemHD RDH WITH(NOLOCK)
                                    LEFT JOIN TCNMBranch BCH WITH(NOLOCK) ON BCH.FTBchCode = RDH.FTBchCode
                                    LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON RDH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                                    LEFT JOIN TCNMUser_L USRINS WITH(NOLOCK) ON RDH.FTUsrCode = USRINS.FTUsrCode AND USRINS.FNLngID = $nLngID
                                    LEFT JOIN TCNMUser_L USRAPV WITH(NOLOCK) ON RDH.FTRdhStaApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                                    OUTER APPLY (  
                                        Select *
                                        From TARTRedeemHDBch TARBCH1 
                                        WHERE TARBCH1.FTRdhDocNo = RDH.FTRdhDocNo 
                                        AND  TARBCH1.FTBchCode = RDH.FTBchCode 
                                        ) TARBCH
                                    WHERE ( 1=1
        ";

        // Check User Login Branch
        if($this->session->userdata('tSesUsrLevel')!='HQ'){
            $tUserLoginBchCode  = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL   .=  "   AND RDH.FTBchCode IN($tUserLoginBchCode)";
        }

        // Check User Login Shop
        if(isset($aDatSessionUserLogIn['FTShpCode']) && !empty($aDatSessionUserLogIn['FTShpCode'])){
            $tUserLoginShpCode  = $aDatSessionUserLogIn['FTShpCode'];
            $tSQL   .=  "   AND RDH.FTShpCode = '$tUserLoginShpCode' ";
        }

        // ต้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร,ผู้สร้าง,ผู้อนุมัตื
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL   .=  "   AND ((RDH.FTRdhDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(VARCHAR(10),RDH.FDRdhDocDate,103) LIKE '%$tSearchList%') OR (USRINS.FTUsrName LIKE '%$tSearchList%') OR (USRAPV.FTUsrName LIKE '%$tSearchList%'))";
        }

        // ค้นหาจากสาขา - ถึงสาขา
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL   .= "    AND ((RDH.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (RDH.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL   .= " AND (
                CONVERT(VARCHAR(10),RDH.FDRdhDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) OR
                CONVERT(VARCHAR(10),RDH.FDRdhDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121)
            )";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            $tSQL   .= " AND (RDH.FTRdhStaDoc = '$tSearchStaDoc')";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND RDHD.FTRdhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(RDHD.FTRdhStaApv,'') = '' AND RDHD.FTRdhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL .= " AND RDHD.FTRdhStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        if(isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)){
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (RDHD.FTRdhStaPrcDoc = '$tSearchStaPrcStk' OR ISNULL(RDHD.FTRdhStaPrcDoc,'') = '') ";
            } else {
                $tSQL .= " AND RDHD.FTRdhStaPrcDoc = '$tSearchStaPrcStk'";
            }
        }

        // // ค้นหาสถานะเคลื่อนไหว
        // if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
        //     if ($tSearchStaDocAct == 1) {
        //         $tSQL .= " AND RDHD.FNRdhStaDocAct = 1";
        //     } else {
        //         $tSQL .= " AND RDHD.FNRdhStaDocAct = 0";
        //     }
        // }

        $tSQL   .=" ) ";

        // if(isset($aDatSessionUserLogIn['FTBchCode']) && !empty($aDatSessionUserLogIn['FTBchCode'])){
            if($this->session->userdata('tSesUsrLevel')!='HQ'){
                // $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
                $tUserLoginBchCode  = $this->session->userdata('tSesUsrBchCodeMulti');
                $tSQL  .="	OR (
                             RDH.FTRdhStaApv = 1
                                AND (
                                    (ISNULL(TARBCH.FTRdhBchTo,'') = '')
                                    OR (
                                        TARBCH.FTRdhBchTo IN($tUserLoginBchCode)
                                        AND TARBCH.FTRdhStaType = 1
                                    )
                                OR (
                                        TARBCH.FTRdhBchTo NOT IN($tUserLoginBchCode)
                                        AND TARBCH.FTRdhStaType = 2
                                    )
                                    )  ";
                                            // ต้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร,ผู้สร้าง,ผู้อนุมัตื
                        if(isset($tSearchList) && !empty($tSearchList)){
                            $tSQL   .=  "   AND ((RDH.FTRdhDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(VARCHAR(10),RDH.FDRdhDocDate,103) LIKE '%$tSearchList%') OR (USRINS.FTUsrName LIKE '%$tSearchList%') OR (USRAPV.FTUsrName LIKE '%$tSearchList%'))";
                        }
                        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
                            $tSQL   .= "    AND ((RDH.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (RDH.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
                        }
                    $tSQL  .=")";
        }

        $tSesUsrAgnCode  = $this->session->userdata('tSesUsrAgnCode');
        $tSQL   .=  ") A  ";
        if($this->session->userdata('tSesUsrLevel')!='HQ'){
        $tSQL   .= " WHERE A.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(A.FTAgnCode,'') = ''  ";
        }
        // echo $tSQL;die();
        $oQuery = $this->db->query($tSQL);


        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
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
        unset($nLngID);
        unset($aDatSessionUserLogIn);
        unset($aAdvanceSearch);
        unset($tSearchList);
        unset($tSearchBchCodeFrom);
        unset($tSearchBchCodeTo);
        unset($tSearchDocDateFrom);
        unset($tSearchDocDateTo);
        unset($tSearchStaDoc);
        unset($tSearchStaDocAct);
        unset($tSearchStaPrcStk);
        unset($tUserLoginBchCode);
        unset($tUserLoginShpCode);
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn; 
    }

    // Functionality: Get Data Detail DT
    // Parameters: function parameters
    // Creator:  02/03/2020 Nattakit(Nale)
    // Return: Data Array
    // Return Type: Array
    public function FSaMRDHGetDataDetailDT($paDataWhere){
        $tRdhDocNo          = $paDataWhere['tRDHDocNo'];
        $aRowLenaRowLen     = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);
        $tSQL               = " SELECT
                                    RDD.FTBchCode,
                                    RDD.FTRdhDocNo,
                                    RDD.FTPdtCode,
                                    RDD.FTPunCode,
                                    RDD.FTRddBarCode,
                                    RDD.FNRddSeq,
                                    RDD.FTRddGrpName
                                FROM TARTRedeemDT RDD WITH(NOLOCK)
                                WHERE 1 = 1
                                AND (RDD.FTRdhDocNo='$tRdhDocNo')
                                ORDER BY FNRddSeq ASC
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMRDHCountDataDetailDT($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($tRdhDocNo);
        unset($tRdhSearchDataDT);
        unset($aRowLen);
        unset($tSQL);
        unset($oQuery);
        unset($aDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }

    // Functionality: Count Data Detail DT
    // Parameters: function parameters
    // Creator:  02/03/2020 Nattakit(Nale)
    // Return: Data Array
    // Return Type: Array
    private function FSaMRDHCountDataDetailDT($paDataWhere){
        $tRdhDocNo  = $paDataWhere['tRDHDocNo'];
        $tSQL       = " SELECT
                            COUNT(RDD.FTRdhDocNo) AS counts
                        FROM TFNTCouponDT RDD WITH(NOLOCK)
                        WHERE 1 = 1
                        AND (RDD.FTRdhDocNo  = '$tRdhDocNo')
        ";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($tRdhDocNo);
        unset($tRdhSearchDataDT);
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Delete Coupon Setup Document
    // Parameters : function parameters
    // Creator : 02/03/2020 Nattakit(Nale)
    // Return : Array Status Delete
    // Return Type : array
    public function FSnMRDHDelDocument($paDataDoc){
        $tDataDocNo = $paDataDoc['tDataDocNo'];
        $this->db->trans_begin();
        // Document HD
        $this->db->where_in('FTRdhDocNo',$tDataDocNo);
        $this->db->delete('TARTRedeemHD');
        // Document HD_L
        $this->db->where_in('FTRdhDocNo',$tDataDocNo);
        $this->db->delete('TARTRedeemHD_L');
        // Document DT
        $this->db->where_in('FTRdhDocNo',$tDataDocNo);
        $this->db->delete('TARTRedeemDT');
        // Document CD
        $this->db->where_in('FTRdhDocNo',$tDataDocNo);
        $this->db->delete('TARTRedeemCD');
        // Document HDBch
        $this->db->where_in('FTRdhDocNo',$tDataDocNo);
        $this->db->delete('TARTRedeemHDBch');
        // Document HDCstPri
        $this->db->where_in('FTRdhDocNo',$tDataDocNo);
        $this->db->delete('TARTRedeemHDCstPri');
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aStaDelDoc     = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Cannot Delete Item.',
            );
        }else{
            $this->db->trans_commit();
            $aStaDelDoc     = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }
        return $aStaDelDoc;
    }

    //Functionality : Insert TARTRedeemHD
    //Parameters : function parameters
    //Creator : 02/02/2020 nattakit(Nale)
    //Last Modified : -
    //Return : Array
    //Return Type : Array
    public function FSaMRDHAddUpdateConditionRedeemHD($paDataMaster,$paDataWhere){
        // Delete TARTRedeemHD
        $tSQLDelete = " SELECT * FROM TARTRedeemHD WHERE 1=1 AND TARTRedeemHD.FTBchCode = '".$paDataMaster['FTBchCode']."' AND TARTRedeemHD.FTRdhDocNo = '".$paDataMaster['FTRdhDocNo']."' ";
        $oQuery     = $this->db->query($tSQLDelete);
        $nCount =  $oQuery->num_rows(); 
        if($nCount==0){
        //Add TARTRedeemHD
        $tSQLInsert = " INSERT INTO TARTRedeemHD (
                            FTBchCode,
                            FTRdhDocNo,
                            FDRdhDocDate,
                            FTRdhDocType,
                            FTRdhCalType,
                            FDRdhDStart,
                            FDRdhDStop,
                            FDRdhTStart,
                            FDRdhTStop,
                            FTUsrCode,
                            FTRdhStaClosed,
                            FTRdhStaDoc,
                            FTRdhStaApv,
                            FTRdhStaPrcDoc,
                            FNRdhStaDocAct,
                            FTRdhStaOnTopPmt,
                            FNRdhLimitQty,
                            FTRdhRefAccCode,
                            FDLastUpdOn,
                            FTLastUpdBy,
                            FDCreateOn,
                            FTCreateBy
                        )VALUES(
                            '".$paDataMaster['FTBchCode']."',
                            '".$paDataMaster['FTRdhDocNo']."',
                            CONVERT(DATETIME,'".$paDataMaster['FDRdhDocDate']."'),
                            '".$paDataMaster['FTRdhDocType']."',
                            '".$paDataMaster['FTRdhCalType']."',
                            CONVERT(DATETIME,'".$paDataMaster['FDRdhDStart']."'),
                            CONVERT(DATETIME,'".$paDataMaster['FDRdhDStop']."'),
                            CONVERT(DATETIME,'".$paDataMaster['FDRdhTStart']."'),
                            CONVERT(DATETIME,'".$paDataMaster['FDRdhTStop']."'),
                            '".$paDataMaster['FTUsrCode']."',
                            '".$paDataMaster['FTRdhStaClosed']."',
                            '".$paDataMaster['FTRdhStaDoc']."',
                            '".$paDataMaster['FTRdhStaApv']."',
                            '".$paDataMaster['FTRdhStaPrcDoc']."',
                            '".$paDataMaster['FNRdhStaDocAct']."',
                            '".$paDataMaster['FTRdhStaOnTopPmt']."',
                            '".$paDataMaster['FNRdhLimitQty']."',
                            '".$paDataMaster['FTRdhRefAccCode']."',
                            GETDATE(),
                            '".$paDataWhere['FTLastUpdBy']."',
                            GETDATE(),
                            '".$paDataWhere['FTCreateBy']."'
                        )
        ";
        }else{
            $tSQLInsert = " UPDATE TARTRedeemHD SET 
                                FTRdhCalType = '".$paDataMaster['FTRdhCalType']."',
                                FDRdhDStart =  CONVERT(DATETIME,'".$paDataMaster['FDRdhDStart']."'),
                                FDRdhDStop = CONVERT(DATETIME,'".$paDataMaster['FDRdhDStop']."') ,
                                FDRdhTStart = CONVERT(DATETIME,'".$paDataMaster['FDRdhTStart']."'),
                                FDRdhTStop = CONVERT(DATETIME,'".$paDataMaster['FDRdhTStop']."'),
                                FTRdhStaClosed = '".$paDataMaster['FTRdhStaClosed']."',
                                FTRdhStaDoc = '".$paDataMaster['FTRdhStaDoc']."',
                                FTRdhStaApv = '".$paDataMaster['FTRdhStaApv']."',
                                FTRdhStaPrcDoc = '".$paDataMaster['FTRdhStaPrcDoc']."',
                                FNRdhStaDocAct = '".$paDataMaster['FNRdhStaDocAct']."',
                                FTRdhStaOnTopPmt = '".$paDataMaster['FTRdhStaOnTopPmt']."',
                                FNRdhLimitQty = '".$paDataMaster['FNRdhLimitQty']."',
                                FTRdhRefAccCode = '".$paDataMaster['FTRdhRefAccCode']."',
                                FDLastUpdOn =  GETDATE(),
                                FTLastUpdBy = '".$paDataWhere['FTLastUpdBy']."' 
                            WHERE TARTRedeemHD.FTBchCode = '".$paDataMaster['FTBchCode']."' AND TARTRedeemHD.FTRdhDocNo = '".$paDataMaster['FTRdhDocNo']."'
            ";
        }
        $oQuery = $this->db->query($tSQLInsert);
        return;
    }

    //Functionality : Insert TARTRedeemHD Lang
    //Parameters : function parameters
    //Creator : 02/02/2020 nattakit(Nale)
    //Last Modified : -
    //Return : Array
    //Return Type : Array
    public function FSaMRDHAddUpdateConditionRedeemHDL($paDataMaster){
        // Delete TARTRedeemHD_L
        $tSQLDelete = " DELETE FROM TARTRedeemHD_L WHERE 1=1 AND TARTRedeemHD_L.FTBchCode = '".$paDataMaster['FTBchCode']."' AND TARTRedeemHD_L.FTRdhDocNo = '".$paDataMaster['FTRdhDocNo']."' AND TARTRedeemHD_L.FNLngID = CONVERT(INT,'".$paDataMaster['FNLngID']."') ";
        $oQuery     = $this->db->query($tSQLDelete);

        //Add TARTRedeemHD_L
        $tSQLInsert = " INSERT INTO TARTRedeemHD_L(
                            FTBchCode,
                            FTRdhDocNo,
                            FNLngID,
                            FTRdhName,
                            FTRdhNameSlip
                        )VALUES(
                            '".$paDataMaster['FTBchCode']."',
                            '".$paDataMaster['FTRdhDocNo']."',
                            CONVERT(INT,'".$paDataMaster['FNLngID']."'),
                            '".$paDataMaster['FTRdhName']."',
                            '".$paDataMaster['FTRdhNameSlip']."'
                        )
        ";
        $oQuery = $this->db->query($tSQLInsert);
        return;
    }

    //Functionality : Function Insert TFNTCouponDT
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMRDHAddUpdateConditionRedeemDT($paDataDT){

        $tSQLDelete = "DELETE FROM TARTRedeemDT WHERE 1=1 AND TARTRedeemDT.FTBchCode = '".$paDataDT['FTBchCode']."' AND  TARTRedeemDT.FTRdhDocNo = '".$paDataDT['FTRdhDocNo']."' ";
        $oQuery = $this->db->query($tSQLDelete);

        $tSql = "
                    INSERT INTO TARTRedeemDT (
                        FTBchCode,
                        FTRdhDocNo,
                        FNRddSeq,
                        FTRddStaType,
                        FTRddGrpName,
                        FTPdtCode,
                        FTPunCode,
                        FTRddBarCode
                    ) 
                    SELECT
                        RDTTMP.FTBchCode,
                        '".$paDataDT['FTRdhDocNo']."' AS FTRdhDocNo,
                        ROW_NUMBER() OVER(ORDER BY RDTTMP.FNRddSeq) AS FNRddSeq,
                        RDTTMP.FTRddStaType,
                        RDTTMP.FTRddGrpName,
                        RDTTMP.FTPdtCode,
                        RDTTMP.FTPunCode,
                        RDTTMP.FTRddBarCode
                        FROM
                            TARTRedeemDT_Tmp RDTTMP WITH (NOLOCK)
                        WHERE
                            RDTTMP.FTBchCode = '".$paDataDT['FTBchCode']."'
                        AND RDTTMP.FTRdhDocNo = '".$paDataDT['FTRdhDocNoWhere']."'
                        AND RDTTMP.FTSessionID = '".$paDataDT['tSessionID']."'
                        AND RDTTMP.FTRddGrpCreated = '1'
            ";
            
         if($paDataDT['nRDHDocType']==1){
            $this->db->query($tSql);
           }


            $tSQLDelete = "DELETE FROM TARTRedeemDT_Tmp WHERE 1=1 AND TARTRedeemDT_Tmp.FTBchCode = '".$paDataDT['FTBchCode']."' AND  TARTRedeemDT_Tmp.FTRdhDocNo = '".$paDataDT['FTRdhDocNoWhere']."' ";
            $oQuery = $this->db->query($tSQLDelete);

           
          

        return;
    }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMRDHGenPdtInsertTempConditionRedeemDT($paData){

 
        $tSQLDelete = "DELETE FROM TARTRedeemDT_Tmp WHERE 1=1   AND TARTRedeemDT_Tmp.FTSessionID = '".$paData['tSessionID']."' ";
        $oQuery = $this->db->query($tSQLDelete);


       $nGroupCode = strtotime(date('Y-m-d H:i:s'));
        $tSql = "
                INSERT INTO TARTRedeemDT_Tmp (
                    FTBchCode,
                    FTRdhDocNo,
                    FNRddSeq,
                    FTRddStaType,
                    FTRddGrpName,
                    FTPdtCode,
                    FTPunCode,
                    FTRddBarCode,
                    FTSessionID,
                    FTRddGrpCode,
                    FTRddGrpCreated
                ) 
                SELECT
                    RDH.FTBchCode,
                    RDH.FTRdhDocNo,
                    ('$nGroupCode'+RDH.FNRddSeq) AS FNRddSeq,
                    RDH.FTRddStaType,
                    RDH.FTRddGrpName,
                    RDH.FTPdtCode,
                    RDH.FTPunCode,
                    RDH.FTRddBarCode,
                    '".$paData['tSessionID']."' AS FTSessionID,
                    RDH.FTRddGrpName AS FTRddGrpCode,
                    1 AS FTRddGrpCreated
                    FROM
                    TARTRedeemDT RDH WITH (NOLOCK)
                    WHERE
                     RDH.FTRdhDocNo = '".$paData['FTRdhDocNo']."'
   
            ";

                        // echo $tSql ;
                        // die();
            $this->db->query($tSql);



        return;
    }

    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 27/02/2020 Nale
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMRDHAddUpdateConditionRedeemCD($paDatCD,$apDataHD){

        $aRdcRefCode        = $paDatCD['aRdcRefCode'];
        $aRefCodeAuto       = $paDatCD['aRefCodeAuto'];
        $aRddGroupNameInput = $paDatCD['aRddGroupNameInput'];
        $aRdcUsePoint       = $paDatCD['aRdcUsePoint'];
        $aRdcUseMny         = $paDatCD['aRdcUseMny'];
        $aRdcMinTotBill     = $paDatCD['aRdcMinTotBill'];
        $tBchCode           = $apDataHD['FTBchCode'];
        $tRdhDocNo          = $apDataHD['FTRdhDocNo'];

        $this->db->where('FTBchCode',$tBchCode)->where('FTRdhDocNo',$tRdhDocNo)->delete('TARTRedeemCD');

        if(!empty($aRdcRefCode)){

                foreach($aRdcRefCode as $nKey => $aValue){

                    if($aValue!=''){
                        $tRdcRefCode=$aValue;
                    }else{
                        $tRdcRefCode=$aRefCodeAuto[$nKey];
                    }

                    $aDataInsert = array(
                        'FTBchCode'       => $tBchCode,
                        'FTRdhDocNo'      => $tRdhDocNo,
                        'FNRdcSeq'        => $nKey+1,
                        'FTRddGrpName'    => $aRddGroupNameInput[$nKey],
                        'FTRdcRefCode'    => $tRdcRefCode,
                        'FCRdcUsePoint'   => str_replace(',','',$aRdcUsePoint[$nKey]),
                        'FCRdcUseMny'     => str_replace(',','',$aRdcUseMny[$nKey]),
                        'FCRdcMinTotBill' => str_replace(',','',$aRdcMinTotBill[$nKey]),
                    );

                    $this->db->insert('TARTRedeemCD',$aDataInsert);

                }
        }   
     return;

    }

 
    //Functionality : Function Insert TFNTCouponHDCstPri
    //Parameters : function parameters
    //Creator : 27/02/2020 Nale
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMRDHAddUpdateConditionRedeemHDCstPri($paDataDT,$paDataHD){

        $tSQLDelete = "DELETE FROM TARTRedeemHDCstPri WHERE 1=1 AND TARTRedeemHDCstPri.FTBchCode = '".$paDataHD['FTBchCode']."' AND  TARTRedeemHDCstPri.FTRdhDocNo = '".$paDataHD['FTRdhDocNo']."' ";
        $oQuery = $this->db->query($tSQLDelete);

        if(isset($paDataDT['aRddPplCode']) && !empty($paDataDT['aRddPplCode'])){
            // Loop Add/Update 
            foreach($paDataDT['aRddPplCode'] AS $nKey => $aValue){
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TARTRedeemHDCstPri ( FTBchCode,FTRdhDocNo,FTPplCode,FTRdhStaType ) VALUES (
                                    '".$paDataHD['FTBchCode']."',
                                    '".$paDataHD['FTRdhDocNo']."',
                                    '".$aValue."',
                                    '".$paDataDT['aRdhPplStaType'][$nKey]."'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }

        return;
    }


    //Functionality : Function Insert TFNTCouponHDBch
    //Parameters : function parameters
    //Creator : 27/02/2020 Nale
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMRDHAddUpdateConditionRedeemHDBch($paDataBch,$apDataHD){
        $tSQLDelete = "DELETE FROM TARTRedeemHDBch WHERE 1=1 AND TARTRedeemHDBch.FTBchCode = '".$apDataHD['FTBchCode']."' AND  TARTRedeemHDBch.FTRdhDocNo = '".$apDataHD['FTRdhDocNo']."' ";
        $oQuery = $this->db->query($tSQLDelete);

        if(isset($paDataBch['aRddConditionRedeemBchCode']) && !empty($paDataBch['aRddConditionRedeemBchCode'])){
            // Loop Add/Update 
            foreach($paDataBch['aRddConditionRedeemBchCode'] AS $nKey => $aValue){
                $tAgnCode    = $paDataBch['aRddConditionRedeemAgnCode'][$nKey];
                $tBchCode    = $aValue;
                $tMerCode    = $paDataBch['aRddConditionRedeemMerCode'][$nKey];
                $tShpCode    = $paDataBch['aRddConditionRedeemShpCode'][$nKey];
                $tRdhStaType = $paDataBch['aRddBchModalType'][$nKey];
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TARTRedeemHDBch ( FTBchCode,FTRdhDocNo,FTRdhAgnTo,FTRdhBchTo,FTRdhMerTo,FTRdhShpTo,FTRdhStaType ) VALUES (
                                    '".$apDataHD['FTBchCode']."',
                                    '".$apDataHD['FTRdhDocNo']."',
                                    '".$tAgnCode."',
                                    '".$tBchCode."',
                                    '".$tMerCode."',
                                    '".$tShpCode."',
                                    '$tRdhStaType'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }


        return;
    }

    //Functionality : Search Condition By ID
    //Parameters : function parameters
    //Creator : 28/02/2020 nattakit(Nale)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRDHGetDataByID($paData){

        
        $nLngID     = $paData['FNLngID'];
        $tRdhDocNo  = $paData['FTRdhDocNo'];

        $tBchCode   = $paData['FTBchCode'];

        $tSQL       = " SELECT
                            RDH.FTBchCode,
                            BCHL.FTBchName,
                            RDH.FTRdhDocNo,
                            RDH.FDRdhDocDate,
                            RDH.FTRdhDocType,
                            RDH.FTRdhCalType,
                            RDH.FDRdhDStart,
                            RDH.FDRdhDStop,
                            RDH.FDRdhTStart,
                            RDH.FDRdhTStop,
                            RDH.FTRdhStaClosed,
                            RDH.FTRdhRefAccCode,
                            RDH.FTUsrCode       AS FTUserCodeCreate,
                            USRINS.FTUsrName    AS FTUserNameCreate,
                            RDH.FTRdhUsrApv     AS FTUserCodeAppove,
                            USRAPV.FTUsrName    AS FTUserNameAppove,
                            RDH.FTRdhStaDoc,
                            RDH.FTRdhStaApv,
                            RDH.FTRdhStaPrcDoc,
                            RDHL.FTRdhName,
                            RDHL.FTRdhNameSlip,

                            RDH.FTRdhStaOnTopPmt,
                            RDH.FNRdhLimitQty,
                            RDH.FNRdhStaDocAct

                        FROM TARTRedeemHD RDH WITH (NOLOCK)
                        LEFT JOIN TARTRedeemHD_L RDHL WITH (NOLOCK)   ON RDH.FTRdhDocNo  = RDHL.FTRdhDocNo  AND RDHL.FNLngID   =  $nLngID
                        LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK)      ON RDH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMUser_L USRINS  WITH (NOLOCK)    ON RDH.FTUsrCode   = USRINS.FTUsrCode AND USRINS.FNLngID =  $nLngID
                        LEFT JOIN TCNMUser_L USRAPV   WITH (NOLOCK)   ON RDH.FTRdhUsrApv = USRAPV.FTUsrCode AND USRAPV.FNLngID =  $nLngID
                        WHERE 1=1
        ";

        if($tRdhDocNo!= ""){
            $tSQL .= "AND RDH.FTRdhDocNo = '$tRdhDocNo' AND  RDH.FTBchCode = '$tBchCode' ";
        }

        $oQuery = $this->db->query($tSQL);
                                                                    


        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();

            $aResult = array(
                'raItems'                => $oDetail[0],
                'rtCode'                 => '1',
                'rtDesc'                 => 'success',
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

    //Functionality : Search Condition By ID
    //Parameters : function parameters
    //Creator : 28/02/2020 nattakit(Nale)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRDHGetDataBchByID($paData){

        $nLngID     = $paData['FNLngID'];
        $tRdhDocNo  = $paData['FTRdhDocNo'];
        $tBchCode   = $paData['FTBchCode'];

        $aConditionRedeemBch = $this->db->where('TARTRedeemHDBch.FTRdhDocNo',$tRdhDocNo)
                                        ->where('TARTRedeemHDBch.FTBchCode', $tBchCode)
        ->join('TCNMAgency_L' ,'TARTRedeemHDBch.FTRdhAgnTo=TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID='.$nLngID,'left')
        ->join('TCNMBranch_L' ,'TARTRedeemHDBch.FTRdhBchTo=TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID='.$nLngID,'left')
        ->join('TCNMMerchant_L' ,'TARTRedeemHDBch.FTRdhMerTo=TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID='.$nLngID,'left')
        ->join('TCNMShop_L' ,'TARTRedeemHDBch.FTRdhShpTo=TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID='.$nLngID,'left')
        ->get('TARTRedeemHDBch')
        ->result_array();
       
        return $aConditionRedeemBch;
    }

    //Functionality : Search Condition By ID
    //Parameters : function parameters
    //Creator : 28/02/2020 nattakit(Nale)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRDHGetDataCDByID($paData){

        $nLngID     = $paData['FNLngID'];
        $tRdhDocNo  = $paData['FTRdhDocNo'];
        $tBchCode   = $paData['FTBchCode'];


        $aConditionRedeemCD = $this->db->where('FTRdhDocNo',$tRdhDocNo)->where('FTBchCode', $tBchCode)->order_by('FNRdcSeq','ASC')->get('TARTRedeemCD')->result_array();
        return $aConditionRedeemCD;
    }

    //Functionality : Search Condition By ID
    //Parameters : function parameters
    //Creator : 28/02/2020 nattakit(Nale)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRDHGetDataCstPriByID($paData){
        $nLngID     = $paData['FNLngID'];
        $tRdhDocNo  = $paData['FTRdhDocNo'];
        $tBchCode   = $paData['FTBchCode'];

        $aConditionRedeemCstPri = $this->db->where('FTRdhDocNo',$tRdhDocNo)
                                            ->where('FTBchCode', $tBchCode)
        ->join('TCNMPdtPriList_L' ,'TARTRedeemHDCstPri.FTPplCode=TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID='.$nLngID,'left')
        ->get('TARTRedeemHDCstPri')
        ->result_array();
                            
        return $aConditionRedeemCstPri;
    }
    //Functionality : Event Cancel Document
    //Parameters : function parameters
    //Creator : 27/03/2020 Supawat(Wat)
    //Return : data
    //Return Type : Array
    public function FSaMRDHCancelStatus($paDataWhere){
        try{
            $tFTBchCode     = $paDataWhere['FTBchCode'];
            $tFTRdhDocNo    = $paDataWhere['FTRDHDocNo'];
            $this->db->set('FTRdhStaDoc','3');
            $this->db->where('FTBchCode' , $tFTBchCode);
            $this->db->where('FTRdhDocNo' , $tFTRdhDocNo);
            $this->db->update('TARTRedeemHD');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Success',
                    );
                    }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update',
                    );
                }
            return $aStatus;
        }catch(Exception  $Error){
            return $Error;
        }
    }

    //Functionality : Event Cancel Document
    //Parameters : function parameters
    //Creator : 27/03/2020 Supawat(Wat)
    //Return : data
    //Return Type : Array
    public function FSaMRDHAppoveStatus($paDataWhere){
        $tFTBchCode     = $paDataWhere['FTBchCode'];
        $tFTRdhDocNo    = $paDataWhere['FTRdhDocNo'];
        $tFTRdhUsrApv   = $paDataWhere['FTRdhUsrApv'];

        $this->db->set('FTRdhStaDoc','1');
        $this->db->set('FTRdhStaApv','1');
        $this->db->set('FTRdhStaPrcDoc','1');
        $this->db->set('FTRdhUsrApv',$tFTRdhUsrApv);
        $this->db->where('FTBchCode' , $tFTBchCode);
        $this->db->where('FTRdhDocNo' , $tFTRdhDocNo);
        $this->db->update('TARTRedeemHD');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Update',
            );
        }
        return $aStatus;
    }



    public function FSaMRDHInsertPDTToTemp($paDataPdtParams){
            $tDocNo        = $paDataPdtParams['tDocNo'];
            $tBchCode      = $paDataPdtParams['tBchCode'];
            $tGrpName      = $paDataPdtParams['tGrpName'];
            $nRDDStaType   = $paDataPdtParams['nRDDStaType'];
            $tSessionID    = $paDataPdtParams['tSessionID'];
            $aPdtData      = $paDataPdtParams['aPdtData'];    
            
         $this->db->where('FTSessionID',$tSessionID)
                    ->where('FTBchCode',$tBchCode)
                    ->where('FTRddGrpName',$tGrpName)
                    ->where('FTPdtCode IS NULL')
                    ->where('FTPunCode IS NULL')
                    ->where('FTRddBarCode IS NULL')
                    ->delete('TARTRedeemDT_Tmp');
        
         if(!empty($aPdtData)){
            foreach($aPdtData as $nKey=>$aValue){
                $aDataSet = array(
                    'FTSessionID'     => $tSessionID,
                    'FTBchCode'       => $tBchCode,
                    'FTRdhDocNo'      => $tDocNo,
                    'FNRddSeq'        => (strtotime("+$nKey second", strtotime(date('Y-m-d H:i:s')))),
                    'FTRddGrpName'    => '',
                    'FTRddStaType'    => $nRDDStaType,
                    'FTPdtCode'       => $aValue->pnPdtCode,
                    'FTPunCode'       => $aValue->ptPunCode,
                    'FTRddBarCode'    => $aValue->ptBarCode,
                    'FTRddGrpCreated' => 0
                );
                $this->db->insert('TARTRedeemDT_Tmp',$aDataSet);
            }
            // if(!empty($tGrpName)){
            //     $this->db->where('FTBchCode',$tBchCode)
            //     ->where('FTRdhDocNo',$tDocNo)
            //     ->where('FTSessionID',$tSessionID)
            //     ->update('TARTRedeemDT_Tmp',['FTRddGrpName'=>$tGrpName,'FTRddStaType'=>$nRDDStaType]);
            // }
           
            if($this->db->affected_rows() > 0){
                $aStatus = TRUE;
            }else{
                $aStatus = FALSE;
            }
         }else{
                $aStatus = TRUE;
         }
       
        return $aStatus;
        
    }



    
    public function FSaMRDHInsertGrpNamePDTToTemp($paDataPdtParams){

        $tDocNo        = $paDataPdtParams['tDocNo'];
        $tBchCode      = $paDataPdtParams['tBchCode'];
        $tGrpName      = $paDataPdtParams['tGrpName'];
        $tGrpCode      = $paDataPdtParams['tGrpCode'];
        $nRDDStaType   = $paDataPdtParams['nRDDStaType'];
        $tSessionID    = $paDataPdtParams['tSessionID'];

            if(empty($tGrpCode)){
                    $tGrpCode = strtotime(date('Y-m-d H:i:s'));
            }

          $nNumRow = $this->db->where('FTBchCode',$tBchCode)
            ->where('FTRdhDocNo',$tDocNo)
            ->where('FTSessionID',$tSessionID)
            ->where('FTRddGrpCreated',0)
            ->get('TARTRedeemDT_Tmp')
            ->num_rows();

            if($nNumRow>0){

    
            $this->db->where('FTBchCode',$tBchCode)
                ->where('FTRdhDocNo',$tDocNo)
                ->where('FTSessionID',$tSessionID)
                ->where('FTRddGrpCreated',0)
                ->update('TARTRedeemDT_Tmp',[  
                                    'FTRddGrpName'    => $tGrpName,
                                    'FTRddStaType'    => $nRDDStaType,
                                    'FTRddGrpCode'    => $tGrpCode,
                                    'FTRddGrpCreated' => 1
                                 ]);

                }else{

                    $aInsertRdh = array(
                        'FTBchCode'    => $tBchCode,
                        'FTRdhDocNo'   => $tDocNo,
                        'FNRddSeq'     => strtotime(date('Y-m-d H:i:s')),
                        'FTRddStaType' => $nRDDStaType,
                        'FTRddGrpName' => $tGrpName,
                        'FTSessionID'  => $tSessionID,
                        'FTRddGrpCode' =>  strtotime(date('Y-m-d H:i:s')),
                        'FTRddGrpCreated' => 1
                    );
                    $this->db->insert('TARTRedeemDT_Tmp',$aInsertRdh);
                }
       
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success',
            );
            }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Update',
            );
        }

   
       return $aStatus;
    
}





    
public function FSaMRDHDeleteGrpNamePDTToTemp($paDataPdtParams){

    $tDocNo        = $paDataPdtParams['tDocNo'];
    $tBchCode      = $paDataPdtParams['tBchCode'];
    $tGrpName      = $paDataPdtParams['tGrpName'];
    $tGrpCode      = $paDataPdtParams['tGrpCode'];
    $nRDDStaType   = $paDataPdtParams['nRDDStaType'];
    $tSessionID    = $paDataPdtParams['tSessionID'];

        if(empty($tGrpCode)){
                $tGrpCode = strtotime(date('Y-m-d H:i:s'));
        }




        $this->db->where('FTBchCode',$tBchCode)
            ->where('FTRdhDocNo',$tDocNo)
            ->where('FTSessionID',$tSessionID)
            ->where('FTRddGrpCreated',0)
            ->update('TARTRedeemDT_Tmp',[  
                                // 'FTRddGrpName'    => $tGrpName,
                                'FTRddStaType'    => $nRDDStaType,
                                'FTRddGrpCode'    => $tGrpCode,
                                'FTRddGrpCreated' => 1
                             ]);

          
   
    if($this->db->affected_rows() > 0){
        $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'Update Success',
        );
        }else{
        $aStatus = array(
            'rtCode' => '905',
            'rtDesc' => 'Error Cannot Update',
        );
    }


   return $aStatus;

}


    public function FSxMRDHClearTempRedeemDT($paDataParam){

        $tDocNo        = $paDataParam['tDocNo'];
        $tBchCode      = $paDataParam['tBchCode'];
        $tSessionID    = $paDataParam['tSessionID'];
        $tGrpCode    = $paDataParam['tRDDGrpCode'];

        if(!empty($tGrpCode)){
            $this->db->where('FTSessionID',$tSessionID)
            ->where('FTBchCode',$tBchCode)
            ->where('FTRddGrpCode',$tGrpCode)
            ->where('FTRdhDocNo',$tDocNo)
            ->where('FTSessionID',$tSessionID)
            ->update('TARTRedeemDT_Tmp',['FTRddGrpCreated'=>1]);

            $this->db->where('FTSessionID',$tSessionID)
            ->where('FTBchCode',$tBchCode)
            ->where('FTRddGrpCode IS NULL')
            ->delete('TARTRedeemDT_Tmp');

        }else{
        $this->db->where('FTSessionID',$tSessionID)
        ->where('FTBchCode',$tBchCode)
        ->where('FTRddGrpCode IS NULL')
        ->delete('TARTRedeemDT_Tmp');
        }

    }



    public function FSxMRDHClearTempRedeemDefaultDT($paDataParam){

        $tDocNo        = $paDataParam['tDocNo'];
        $tBchCode      = $paDataParam['tBchCode'];
        $tSessionID    = $paDataParam['tSessionID'];
        $this->db->where('FTSessionID',$tSessionID)
        ->where('FTBchCode',$tBchCode)
        ->delete('TARTRedeemDT_Tmp');

    }


    public function FSxMRDHFindDuplicatePdt($paDataPdtParams){

            $tDocNo        = $paDataPdtParams['tDocNo'];
            $tBchCode      = $paDataPdtParams['tBchCode'];
            $tSessionID    = $paDataPdtParams['tSessionID'];
            $aPdtData      = $paDataPdtParams['aPdtData'];    
    
            $nDuplicate = 0;

            if(!empty($aPdtData)){

                foreach($aPdtData as $nKey=>$aValue){
        
                   $nNumrow = $this->db->where('FTSessionID',$tSessionID)
                             ->where('FTBchCode',$tBchCode)
                             ->where('FTRdhDocNo',$tDocNo)
                             ->where('FTPdtCode',$aValue->pnPdtCode)
                             ->where('FTPunCode',$aValue->ptPunCode)
                             ->where('FTRddBarCode',$aValue->ptBarCode)
                             ->get('TARTRedeemDT_Tmp')
                             ->num_rows();
                             $nDuplicate = $nDuplicate + $nNumrow;
                }
               
            
             }
           
            return $nDuplicate;
    }


    // Functionality: Get Data In Doc DT Temp
    // Parameters: function parameters
    // Creator: 01/07/2019 wasin (Yoshi)
    // Last Modified: -
    // Return: Array Data Doc DT Temp
    // ReturnType: array
    public function FSaMRDHGetDocDTTempListPage($paDataWhere){
        
        $nLngID              = $paDataWhere['FNLngID'];
        $tRDHDocNo           = $paDataWhere['FTXthDocNo'];
        $FTRddGrpName        = $paDataWhere['FTRddGrpName'];
        $FTRddGrpCode        = $paDataWhere['FTRddGrpCode'];
        $tSearchPdtAdvTable  = $paDataWhere['tSearchPdtAdvTable'];
        $tRDHSesSessionID    = $this->session->userdata('tSesSessionID');

        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tSQL       = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNRddSeq ASC) AS rtRowID,* FROM (
                                SELECT
                                RDDTmp.FTRddGrpName,
                                RDDTmp.FTPdtCode,
                                RDDTmp.FTPunCode,
                                RDDTmp.FTRddBarCode,
                                RDDTmp.FTRdhDocNo,
                                RDDTmp.FNRddSeq,
                                RDDTmp.FTBchCode,
                                RDDTmp.FTRddStaType,
                                RDDTmp.FTSessionID,
                                PDTL.FTPdtName,
                                PUTL.FTPunName
                                FROM
                                TARTRedeemDT_Tmp RDDTmp WITH(NOLOCK)
                                LEFT OUTER JOIN TCNMPdt_L PDTL ON RDDTmp.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID=$nLngID 
                                LEFT OUTER JOIN TCNMPdtUnit_L PUTL ON RDDTmp.FTPunCode = PUTL.FTPunCode AND PUTL.FNLngID=$nLngID 
                                WHERE 1=1
                                AND RDDTmp.FTRdhDocNo = '$tRDHDocNo'
                                -- AND RDDTmp.FTRddGrpName ='$FTRddGrpName'
                                AND RDDTmp.FTSessionID = '$tRDHSesSessionID'
                                AND RDDTmp.FTRddGrpCreated='0'
                                AND RDDTmp.FTPdtCode IS NOT NULL
                                 ";
                                
        if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
            $tSQL   .=  "   AND (
                                RDDTmp.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR RDDTmp.FTRdhDocNo COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR RDDTmp.FTBchCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR PUTL.FTPunName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%' )
                        ";
            
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

 
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMRDHGetDocDTTempListPageAll($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }   

    // Functionality : Count All Documeny DT Temp
    // Parameters : function parameters
    // Creator : 01/07/2019 Nattakit(Nale)
    // Last Modified : -
    // Return : array Data Count All Data
    // Return Type : array
    public function FSaMRDHGetDocDTTempListPageAll($paDataWhere){
        $tRDHDocNo           = $paDataWhere['FTXthDocNo'];

        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tRDHSesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT COUNT (RDDTmp.FTRdhDocNo) AS counts
                    FROM TARTRedeemDT_Tmp RDDTmp WITH (NOLOCK)
                    WHERE 1 = 1 ";
        
        $tSQL   .= " AND RDDTmp.FTRdhDocNo  = '$tRDHDocNo' ";
        $tSQL   .= " AND RDDTmp.FTSessionID = '$tRDHSesSessionID' ";
        $tSQL   .= " AND RDDTmp.FTRddGrpCreated = '0' ";


        // if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
        //     $tSQL   .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchPdtAdvTable%' ";
        //     $tSQL   .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchPdtAdvTable%' ";
        //     $tSQL   .= " OR DOCTMP.FTPunName    LIKE '%$tSearchPdtAdvTable%' ";
        //     $tSQL   .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchPdtAdvTable%' ";
        // }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }



    public function FSaMRDHPdtAdvanceTableDeleteSingle($paDataWhere){
        try{

            $tRDHDocNo      = $paDataWhere['tRDHDocNo'];
            $nRddSeq        = $paDataWhere['nRddSeq'];
            $tSessionID    = $paDataWhere['tSessionID'];
            $tBchCode    = $paDataWhere['tBchCode'];

                $this->db->where('FTBchCode',$tBchCode)
                        ->where('FTRdhDocNo',$tRDHDocNo)
                        ->where('FTSessionID',$tSessionID)
                        ->where('FNRddSeq',$nRddSeq)
                        ->delete('TARTRedeemDT_Tmp');

                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Success',
                    );
                    }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update',
                    );
                }
            return $aStatus;
        }catch(Exception  $Error){
            return $Error;
        }


    }


    public function FSaMRDHGetGrpNamePDTToTemp($paDataWhere){  

            $tDocNo          = $paDataWhere['tDocNo'];
            $tBchCode        = $paDataWhere['tBchCode'];
            $tSessionID      = $paDataWhere['tSessionID'];

                $tSQL = " SELECT
                            RDD.FTRddGrpCode,
                            MAX(RDD.FNRddSeq) AS FNRddSeq
                        FROM
                            TARTRedeemDT_Tmp RDD WITH (NOLOCK)
                        WHERE 1=1 
                        AND RDD.FTBchCode='$tBchCode'
                        AND RDD.FTRdhDocNo='$tDocNo'
                        AND RDD.FTSessionID='$tSessionID'
                        AND RDD.FTRddGrpCode IS NOT NULL 
                        AND RDD.FTRddGrpCode != ''
                        GROUP BY RDD.FTRddGrpCode
                        ORDER BY FNRddSeq
                            ";
 
        $oQuery = $this->db->query($tSQL);
        $aDataList  = $oQuery->result_array();
        $aDataResutl = array();
        if(!empty($aDataList)){
            foreach($aDataList as $nKey => $aVal){
                    $tGroupName = $this->db->where('FTRddGrpCode',$aVal['FTRddGrpCode'])->get('TARTRedeemDT_Tmp')->row_array();
                 
                    $aDataResutl[$nKey]['FTRddGrpCode'] = $aVal['FTRddGrpCode'];
                    $aDataResutl[$nKey]['FTRddStaType'] = $tGroupName['FTRddStaType'];
                    $aDataResutl[$nKey]['FTRddGrpName'] = $tGroupName['FTRddGrpName'];
            }
        }

        if($oQuery){
        
            $aDataReturn    = array(
                'rtitem'        => $aDataResutl,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(

                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aDataList);
 

        return $aDataReturn;

    }



    public function FSaMRDHSetPdtGrpDTTemp($paDataWhere){
        try{

            $tDocNo      = $paDataWhere['tDocNo'];
            $tBchCode    = $paDataWhere['tBchCode'];
            $tGrpCode    = $paDataWhere['tGrpCode'];
            $tSessionID  = $paDataWhere['tSessionID'];

                $this->db->where('FTBchCode',$tBchCode)
                        ->where('FTRdhDocNo',$tDocNo)
                        ->where('FTSessionID',$tSessionID)
                        ->where('FTRddGrpCode',$tGrpCode)
                        ->update('TARTRedeemDT_Tmp',['FTRddGrpCreated'=>0]);

                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Success',
                    );
                    }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update',
                    );
                }
            return $aStatus;
        }catch(Exception  $Error){
            return $Error;
        }
    }

    public function FSaMRDHDelGroupInDTTemp($paDataWhere){
        try{

            $tDocNo      = $paDataWhere['tDocNo'];
            $tBchCode    = $paDataWhere['tBchCode'];
            $tGrpCode    = $paDataWhere['tGrpCode'];
            $tSessionID  = $paDataWhere['tSessionID'];
    
                $this->db->where('FTBchCode',$tBchCode)
                        ->where('FTRdhDocNo',$tDocNo)
                        ->where('FTSessionID',$tSessionID)
                        ->where('FTRddGrpCode',$tGrpCode)
                        ->delete('TARTRedeemDT_Tmp');

                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Delete Success',
                    );
                    }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update',
                    );
                }
            return $aStatus;
        }catch(Exception  $Error){
            return $Error;
        }
    }


    public function FSnMGetMaxCodeCDConditionRedeem(){
        // $tSql="
        // SELECT
        // RIGHT(ISNULL(MAX(RDCD.FTRdcRefCode),0),5)+1 AS FTRdcRefCode
        // FROM
        //     TARTRedeemCD RDCD WITH (NOLOCK)
        //     WHERE LEN(RDCD.FTRdcRefCode)>15
        //     ";
        //    $oQuery =  $this->db->query($tSql);
        //     $aResult = $oQuery->row_array();
           return rand(0, 9999);
    }

    //Functionality : Event Cancel Document
    //Parameters : function parameters
    //Creator : 27/03/2020 Supawat(Wat)
    //Return : data
    //Return Type : Array
    public function FSaMRDHChangStatusAfApv($paDataWhere){
   
        $nStaClosed     = $paDataWhere['nStaClosed'];
        $nStaDocAct     = $paDataWhere['nStaDocAct'];
        $tRDHDocNo      = $paDataWhere['tRDHDocNo'];
        $tBchCode       = $paDataWhere['tBchCode'];
        $dLastUpdOn     = date('Y-m-d H:i:s');
        $tSesUsername   = $this->session->userdata('tSesUsername');

        $this->db->set('FDLastUpdOn', $dLastUpdOn);
        $this->db->set('FTLastUpdBy', $tSesUsername);

        $this->db->set('FTRdhStaClosed',$nStaClosed);
        $this->db->set('FNRdhStaDocAct',$nStaDocAct);
        $this->db->where('FTBchCode' , $tBchCode);
        $this->db->where('FTRdhDocNo' , $tRDHDocNo);
        $this->db->update('TARTRedeemHD');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Update',
            );
        }
        return $aStatus;
    }



  

}