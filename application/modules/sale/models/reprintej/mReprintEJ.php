<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mReprintEJ extends CI_Model {

    // Functionality: Get Data EJ
    // Parameters: Ajax and Function Parameter
    // Creator: 11/10/2019 wasin(Yoshi)
    // Return: Array Data EJ
    // ReturnType: Array
    public function FSaMGetListDataEJ($paDataWhere){
        $aDataFilterEJ  = $paDataWhere['aDataFilterEJ'];
        $aRowLen        = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        // Filter Brnach
        $tBranchCode    = $aDataFilterEJ['oetEJBchCode'];
        $tWhereEJBranch = "";
        if(isset($tBranchCode) && !empty($tBranchCode)){
            $tWhereEJBranch = " AND (EJ.FTBchCode = '$tBranchCode')";
        }

        // Filter Shop
        $tShopCode      = $aDataFilterEJ['oetEJShopCode'];
        $tWhereEJShop   = "";
        if(isset($tShopCode) && !empty($tShopCode)){
            $tWhereEJShop = " AND (EJ.FTShpCode = '$tShopCode')";
        }

        // Filter Document Date
        $tDocDateFrom       = $aDataFilterEJ['oetEJDocDateFrom'];
        $tDocDateTo         = $aDataFilterEJ['oetEJDocDateTo'];
        $tWhereEJDocDate    = "";
        if((isset($tDocDateFrom) && !empty($tDocDateFrom)) && (isset($tDocDateTo) && !empty($tDocDateTo))){
            $tWhereEJDocDate    = " AND (
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tDocDateTo',121) OR 
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateTo',121) AND CONVERT(VARCHAR(10),'$tDocDateFrom',121)
                                    )
            ";
        }

        // Filter Document Document No
        $tDocNoSingle           = $aDataFilterEJ['oetEJSlipCode'];
        $tWhereEJDocNoSingle    = "";
        if(isset($tDocNoSingle) && !empty($tDocNoSingle)){
            $tWhereEJDocNoSingle    = " AND (EJ.FTXshDocNo = '$tDocNoSingle')";
        }

        // Filter Document Document No Between
        $tDocNoFrom = $aDataFilterEJ['oetEJSlipCodeFrom'];
        $tDocNoTo   = $aDataFilterEJ['oetEJSlipCodeTo'];
        $tWhereEJDocNoBetween   = "";
        if((isset($tDocNoFrom) && !empty($tDocNoFrom)) && (isset($tDocNoTo) && !empty($tDocNoTo))){
            $tWhereEJDocNoBetween   = " AND ((EJ.FTXshDocNo BETWEEN '$tDocNoFrom' AND '$tDocNoTo') OR (EJ.FTXshDocNo BETWEEN '$tDocNoTo' AND '$tDocNoFrom'))";
        }



        $tEjDocumentType   = $aDataFilterEJ['ocmEjDocumentType'];
        $tWhereEJDocType = "";
        if(isset($tEjDocumentType) && !empty($tEjDocumentType)){
            $tWhereEJDocType = " AND EJ.FTXshDocNo LIKE '$tEjDocumentType%' ";
            if($tEjDocumentType=='S'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'SUM' ";
            }
            if($tEjDocumentType=='R'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'RCV' ";
            }
        }

        $tSQL           = " SELECT c.* FROM (
                                SELECT  ROW_NUMBER() OVER(ORDER BY FTBchCode ASC,FTXshDocNo ASC) AS rtRowID,* FROM (
                                    SELECT DISTINCT
                                        EJ.FTBchCode,
                                        EJ.FTXshDocNo,
                                        EJ.FTShpCode,
                                        EJ.FDXshDocDate,
                                        EJ.FTJnlPicPath
                                    FROM TPSTSlipEJ EJ WITH(NOLOCK)
                                    WHERE 1=1
                                    ".$tWhereEJBranch."
                                    ".$tWhereEJShop."
                                    ".$tWhereEJDocDate."
                                    ".$tWhereEJDocNoSingle."
                                    ".$tWhereEJDocNoBetween."
                                    ".$tWhereEJDocType."
                            ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]
        ";
        $oQuery = $this->db->query($tSQL);


        if($oQuery->num_rows() > 0) {
            $aDataList      = $oQuery->result_array();
            $nFoundRow      = $this->FSnMEJCountDataAll($paDataWhere);
            $nPageAll       = ceil($nFoundRow/$paDataWhere['nRow']);
            $aDataReturn    = [
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => $nPageAll, 
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            ];
        }else{
            $aDataReturn    = [
                'raItems'       => [],
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            ];
        }
        unset($aDataFilterEJ);
        unset($aRowLen);
        unset($tBranchCode);
        unset($tWhereEJBranch);
        unset($tShopCode);
        unset($tWhereEJShop);
        unset($tDocDateFrom);
        unset($tDocDateTo);
        unset($tWhereEJDocDate);
        unset($tDocNoSingle);
        unset($tWhereEJDocNoSingle);
        unset($tDocNoFrom);
        unset($tDocNoTo);
        unset($tWhereEJDocNoBetween);
        unset($tWhereEJDocType);
        unset($tSQL);
        unset($oQuery);
        unset($aDataList);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }

    // Functionality: Count Data Data EJ
    // Parameters: Ajax and Function Parameter
    // Creator: 11/10/2019 wasin(Yoshi)
    // Return: Data Count All EJ Where Filter
    // ReturnType: numeric
    public function FSnMEJCountDataAll($paDataWhere){
        $aDataFilterEJ  = $paDataWhere['aDataFilterEJ'];
        // Filter Brnach
        $tBranchCode    = $aDataFilterEJ['oetEJBchCode'];
        $tWhereEJBranch = "";
        if(isset($tBranchCode) && !empty($tBranchCode)){
            $tWhereEJBranch = " AND (EJ.FTBchCode = '$tBranchCode')";
        }

        // Filter Shop
        $tShopCode      = $aDataFilterEJ['oetEJShopCode'];
        $tWhereEJShop   = "";
        if(isset($tShopCode) && !empty($tShopCode)){
            $tWhereEJShop = " AND (EJ.FTShpCode = '$tShopCode')";
        }

        // Filter Document Date
        $tDocDateFrom       = $aDataFilterEJ['oetEJDocDateFrom'];
        $tDocDateTo         = $aDataFilterEJ['oetEJDocDateTo'];
        $tWhereEJDocDate    = "";
        if((isset($tDocDateFrom) && !empty($tDocDateFrom)) && (isset($tDocDateTo) && !empty($tDocDateTo))){
            $tWhereEJDocDate    = " AND (
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tDocDateTo',121) OR 
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateTo',121) AND CONVERT(VARCHAR(10),'$tDocDateFrom',121)
                                    )
            ";
        }

        // Filter Document Document No
        $tDocNoSingle           = $aDataFilterEJ['oetEJSlipCode'];
        $tWhereEJDocNoSingle    = "";
        if(isset($tDocNoSingle) && !empty($tDocNoSingle)){
            $tWhereEJDocNoSingle    = " AND (EJ.FTXshDocNo = '$tDocNoSingle')";
        }

        // Filter Document Document No Between
        $tDocNoFrom = $aDataFilterEJ['oetEJSlipCodeFrom'];
        $tDocNoTo   = $aDataFilterEJ['oetEJSlipCodeTo'];
        $tWhereEJDocNoBetween   = "";
        if((isset($tDocNoFrom) && !empty($tDocNoFrom)) && (isset($tDocNoTo) && !empty($tDocNoTo))){
            $tWhereEJDocNoBetween   = " AND ((EJ.FTXshDocNo BETWEEN '$tDocNoFrom' AND '$tDocNoTo') OR (EJ.FTXshDocNo BETWEEN '$tDocNoTo' AND '$tDocNoFrom'))";
        }


        $tEjDocumentType   = $aDataFilterEJ['ocmEjDocumentType'];
        $tWhereEJDocType = "";
        if(isset($tEjDocumentType) && !empty($tEjDocumentType)){
            $tWhereEJDocType = " AND EJ.FTXshDocNo LIKE '$tEjDocumentType%' ";
            if($tEjDocumentType=='S'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'SUM' ";
            }
            if($tEjDocumentType=='R'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'RCV' ";
            }
        }


        $tSQL    = "    SELECT
                            COUNT(EJ.FTBchCode) AS FTCountDataAll
                        FROM TPSTSlipEJ EJ WITH(NOLOCK)
                        WHERE 1=1
                        ".$tWhereEJBranch."
                        ".$tWhereEJShop."
                        ".$tWhereEJDocDate."
                        ".$tWhereEJDocNoSingle."
                        ".$tWhereEJDocNoBetween."
                        ".$tWhereEJDocType."
        ";
        $oQuery = $this->db->query($tSQL);
        unset($aDataFilterEJ);
        unset($tBranchCode);
        unset($tWhereEJBranch);
        unset($tShopCode);
        unset($tWhereEJShop);
        unset($tDocDateFrom);
        unset($tDocDateTo);
        unset($tWhereEJDocDate);
        unset($tDocNoSingle);
        unset($tWhereEJDocNoSingle);
        unset($tDocNoFrom);
        unset($tDocNoTo);
        unset($tWhereEJDocNoBetween);
        unset($tWhereEJDocType);
        unset($tSQL);
        return $oQuery->row_array()['FTCountDataAll'];
    }

    // Functionality: Get Data Render Print ABB
    // Parameters: Ajax and Function Parameter
    // Creator: 15/10/2019 wasin(Yoshi)
    // Return: Data Count All EJ Where Filter
    // ReturnType: numeric
    public function FSaMGetDataRenderPrintABB($paDataFilterEJ){
        
        // Filter Brnach
        $tBranchCode    = $paDataFilterEJ['oetEJBchCode'];
        $tWhereEJBranch = "";
        if(isset($tBranchCode) && !empty($tBranchCode)){
            $tWhereEJBranch =   " AND (EJ.FTBchCode = '$tBranchCode')";
        }

        // Filter Shop
        $tShopCode      = $paDataFilterEJ['oetEJShopCode'];
        $tWhereEJShop   = "";
        if(isset($tShopCode) && !empty($tShopCode)){
            $tWhereEJShop   = " AND (EJ.FTShpCode = '$tShopCode')";
        }

        // Filter Document Date
        $tDocDateFrom       = $paDataFilterEJ['oetEJDocDateFrom'];
        $tDocDateTo         = $paDataFilterEJ['oetEJDocDateTo'];
        $tWhereEJDocDate    = "";
        if((isset($tDocDateFrom) && !empty($tDocDateFrom)) && (isset($tDocDateTo) && !empty($tDocDateTo))){
            $tWhereEJDocDate    = " AND (
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tDocDateTo',121) OR 
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateTo',121) AND CONVERT(VARCHAR(10),'$tDocDateFrom',121)
                                    )
            ";
        }

        // Filter Document Document No
        $tDocNoSingle           = $paDataFilterEJ['oetEJSlipCode'];
        $tWhereEJDocNoSingle    = "";
        if(isset($tDocNoSingle) && !empty($tDocNoSingle)){
            $tWhereEJDocNoSingle    = " AND (EJ.FTXshDocNo = '$tDocNoSingle')";
        }

        // Filter Document Document No Between
        $tDocNoFrom = $paDataFilterEJ['oetEJSlipCodeFrom'];
        $tDocNoTo   = $paDataFilterEJ['oetEJSlipCodeTo'];
        $tWhereEJDocNoBetween   = "";
        if((isset($tDocNoFrom) && !empty($tDocNoFrom)) && (isset($tDocNoTo) && !empty($tDocNoTo))){
            $tWhereEJDocNoBetween   = " AND ((EJ.FTXshDocNo BETWEEN '$tDocNoFrom' AND '$tDocNoTo') OR (EJ.FTXshDocNo BETWEEN '$tDocNoTo' AND '$tDocNoFrom'))";
        }

        $tEjDocumentType   = $aDataFilterEJ['ocmEjDocumentType'];
        $tWhereEJDocType = "";
        if(isset($tEjDocumentType) && !empty($tEjDocumentType)){
            $tWhereEJDocType = " AND EJ.FTXshDocNo LIKE '$tEjDocumentType%' ";
            if($tEjDocumentType=='S'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'SUM' ";
            }
            if($tEjDocumentType=='R'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'RCV' ";
            }
        }

        $tSQL   = " SELECT DISTINCT
                        EJ.FTBchCode,
                        EJ.FTXshDocNo,
                        EJ.FTShpCode,
                        EJ.FDXshDocDate,
                        EJ.FTJnlPicPath
                    FROM TPSTSlipEJ EJ WITH(NOLOCK)
                    WHERE 1=1
                    ".$tWhereEJBranch."
                    ".$tWhereEJShop."
                    ".$tWhereEJDocDate."
                    ".$tWhereEJDocNoSingle."
                    ".$tWhereEJDocNoBetween."
                    ".$tWhereEJDocType."
        ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aDataList  = $oQuery->result_array();
        }else{
            $aDataList  = [];
        }

        // Remove Variable
        unset($tBranchCode);
        unset($tWhereEJBranch);
        unset($tShopCode);
        unset($tWhereEJShop);
        unset($tDocDateFrom);
        unset($tDocDateTo);
        unset($tWhereEJDocDate);
        unset($tDocNoSingle);
        unset($tWhereEJDocNoSingle);
        unset($tDocNoFrom);
        unset($tDocNoTo);
        unset($tWhereEJDocNoBetween);
        unset($tWhereEJDocType);
        unset($tSQL);
        unset($oQuery);
        return $aDataList;
    }

    // Functionality: Update Print Count
    // Parameters: Ajax and Function Parameter
    // Creator: 15/10/2019 wasin(Yoshi)
    // Return: Update Print Count
    // ReturnType: numeric
    public function FSnMUpdPrintCount($paDataFilterEJ){
        // Filter Brnach
        $tBranchCode    = $paDataFilterEJ['oetEJBchCode'];
        $tWhereEJBranch = "";
        if(isset($tBranchCode) && !empty($tBranchCode)){
            $tWhereEJBranch =   " AND (EJ.FTBchCode = '$tBranchCode')";
        }

        // Filter Shop
        $tShopCode      = $paDataFilterEJ['oetEJShopCode'];
        $tWhereEJShop   = "";
        if(isset($tShopCode) && !empty($tShopCode)){
            $tWhereEJShop   = " AND (EJ.FTShpCode = '$tShopCode')";
        }

        // Filter Document Date
        $tDocDateFrom       = $paDataFilterEJ['oetEJDocDateFrom'];
        $tDocDateTo         = $paDataFilterEJ['oetEJDocDateTo'];
        $tWhereEJDocDate    = "";
        if((isset($tDocDateFrom) && !empty($tDocDateFrom)) && (isset($tDocDateTo) && !empty($tDocDateTo))){
            $tWhereEJDocDate    = " AND (
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tDocDateTo',121) OR 
                                        CONVERT(VARCHAR(10),EJ.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tDocDateTo',121) AND CONVERT(VARCHAR(10),'$tDocDateFrom',121)
                                    )
            ";
        }

        // Filter Document Document No
        $tDocNoSingle           = $paDataFilterEJ['oetEJSlipCode'];
        $tWhereEJDocNoSingle    = "";
        if(isset($tDocNoSingle) && !empty($tDocNoSingle)){
            $tWhereEJDocNoSingle    = " AND (EJ.FTXshDocNo = '$tDocNoSingle')";
        }

        // Filter Document Document No Between
        $tDocNoFrom = $paDataFilterEJ['oetEJSlipCodeFrom'];
        $tDocNoTo   = $paDataFilterEJ['oetEJSlipCodeTo'];
        $tWhereEJDocNoBetween   = "";
        if((isset($tDocNoFrom) && !empty($tDocNoFrom)) && (isset($tDocNoTo) && !empty($tDocNoTo))){
            $tWhereEJDocNoBetween   = " AND ((EJ.FTXshDocNo BETWEEN '$tDocNoFrom' AND '$tDocNoTo') OR (EJ.FTXshDocNo BETWEEN '$tDocNoTo' AND '$tDocNoFrom'))";
        }

        $tEjDocumentType   = $aDataFilterEJ['ocmEjDocumentType'];
        $tWhereEJDocType = "";
        if(isset($tEjDocumentType) && !empty($tEjDocumentType)){
            $tWhereEJDocType = " AND EJ.FTXshDocNo LIKE '$tEjDocumentType%' ";
            if($tEjDocumentType=='S'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'SUM' ";
            }
            if($tEjDocumentType=='R'){
                $tWhereEJDocType .= " AND LEFT(EJ.FTXshDocNo,3) <> 'RCV' ";
            }
        }

        $tSQL   = " UPDATE SLEJ_UPD
                    SET SLEJ_UPD.FNJnlPrintCount = SLEJ_SLT.FNJnlPrintCount+1
                    FROM TPSTSlipEJ SLEJ_UPD WITH(ROWLOCK)
                    INNER JOIN (
                        SELECT
                            EJ.FTBchCode,
                            EJ.FTXshDocNo,
                            EJ.FNJnlPrintCount
                        FROM TPSTSlipEJ EJ WITH(NOLOCK)
                        WHERE 1=1
                        ".$tWhereEJBranch."
                        ".$tWhereEJShop."
                        ".$tWhereEJDocDate."
                        ".$tWhereEJDocNoSingle."
                        ".$tWhereEJDocNoBetween."
                        ".$tWhereEJDocType."
                    ) AS SLEJ_SLT 
                    ON SLEJ_UPD.FTBchCode = SLEJ_SLT.FTBchCode AND SLEJ_UPD.FTXshDocNo = SLEJ_SLT.FTXshDocNo
        ";
        
        $this->db->trans_begin();
        $this->db->query($tSQL);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
    }


}