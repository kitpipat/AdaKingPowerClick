<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mVdSaleInfor extends CI_Model {
    public function FSxMGetBranchInfor(){
        $tSQL = "SELECT BCH.FTBchCode,BCHL.FTBchName
                 FROM TCNMBranch BCH
                 LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode = BCHL.FTBchCode
                 AND BCHL.FNLngID = '".$this->session->userdata("tLangEdit")."'
                 WHERE BCH.FTBchStaActive = 1";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aSaleBillInfor = $oQuery->result_array();
        }else{
            $aSaleBillInfor = false;
        }
        return $aSaleBillInfor;
    }
    public function FSxMGetMerChantInfor($tBranch){
        $tSQL = "SELECT MCH.FTMerCode,MCHL.FTMerName
                 FROM TCNMMerchant MCH
                 LEFT JOIN TCNMMerchant_L MCHL ON MCH.FTMerCode = MCHL.FTMerCode 
                 AND MCHL.FNLngID = '".$this->session->userdata("tLangEdit")."'
                 WHERE MCH.FTMerStaActive = 1";
        if($tBranch!=0){
            $tSQL .= " AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = MCH.FTMerCode AND TCNMShop.FTBchCode = '".$tBranch."') != 0";
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aSaleBillInfor = $oQuery->result_array();
        }else{
            $aSaleBillInfor = false;
        }
        return $aSaleBillInfor;
    }
    public function FSxMGetShopInfor($tBranch,$tMerChant){
        $tSQL = "SELECT SCH.FTShpCode,SCHL.FTShpName
                FROM TCNMShop SCH 
                LEFT JOIN TCNMShop_L SCHL ON SCH.FTShpCode = SCHL.FTShpCode 
                AND SCHL.FNLngID = '".$this->session->userdata("tLangEdit")."'
                WHERE 1=1";
        if($tBranch!=0){
            $tSQL .= " AND SCH.FTBchCode = '".$tBranch."'";
        }
        if($tMerChant!=0){
            $tSQL .= " AND SCH.FTMerCode = '".$tMerChant."'";
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aSaleBillInfor = $oQuery->result_array();
        }else{
            $aSaleBillInfor = false;
        }
        return $aSaleBillInfor;
    }
    public function FSxMGetNumBillSale($paSendToFillter){
        
        $tSesUsrBchCode = $this->session->userdata ("tSesUsrBchCode");
        $tSesUsrLevel = $this->session->userdata ("tSesUsrLevel");
        /* Sale Bill In Date */
        if($tSesUsrLevel=="HQ"){
            $tSQL = "SELECT COUNT(TVDHD.FTXshDocNo) AS FNCountBill,ISNULL(SUM(TVDHD.FCXshGrand) ,0) AS FNSumCountBill
                    FROM TVDTSalHD TVDHD
                    LEFT JOIN TCNMShop TSHP ON TVDHD.FTBchCode = TSHP.FTBchCode AND TVDHD.FTShpCode = TSHP.FTShpCode";
            $tSQL .= " WHERE 
                    TVDHD.FNXshDocType = 1
                    AND CONVERT(char(10), TVDHD.FDXshDocDate,126) = '".$paSendToFillter["dDateFilter"]."'
                    AND TVDHD.FTBchCode = '".$paSendToFillter["tBCH"]."'";
            if($paSendToFillter["tMCH"]!=0){
                $tSQL .= " AND TSHP.FTMerCode = '".$paSendToFillter["tMCH"]."'";
            }
            if($paSendToFillter["tSPH"]!=0){
                $tSQL .= " AND TSHP.FTShpCode = '".$paSendToFillter["tSPH"]."'";
            }
        }else{
            $tSQL = "SELECT COUNT(TVDHD.FTXshDocNo) AS FNCountBill,ISNULL(SUM(TVDHD.FCXshGrand) ,0) AS FNSumCountBill
                    FROM TVDTSalHD TVDHD
                    LEFT JOIN TCNMShop TSHP ON TVDHD.FTBchCode = TSHP.FTBchCode AND TVDHD.FTShpCode = TSHP.FTShpCode";
            $tSQL .= " WHERE 
                    TVDHD.FNXshDocType = 1
                    AND CONVERT(char(10), TVDHD.FDXshDocDate,126) = '".$paSendToFillter["dDateFilter"]."'
                    AND TVDHD.FTBchCode = '".$tSesUsrBchCode."'";
            if($paSendToFillter["tMCH"]!=0){
                $tSQL .= " AND TSHP.FTMerCode = '".$paSendToFillter["tMCH"]."'";
            }
            if($paSendToFillter["tSPH"]!=0){
                $tSQL .= " AND TSHP.FTShpCode = '".$paSendToFillter["tSPH"]."'";
            }
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aSaleBillInfor = $oQuery->row_array();
            $tFNCountBill = $aSaleBillInfor["FNCountBill"];
            $tFNSumCountBill = $aSaleBillInfor["FNSumCountBill"];
        }else{
            $tFNCountBill = false;
            $tFNSumCountBill = false;
        }
        /* end */
        $aSendInfor = array(
            "tFNCountBill" => $tFNCountBill,
            "tFNSumCountBill"=>$tFNSumCountBill
        );
        return $aSendInfor;
    }
    public function FSxMGetNumBillReturn($paSendToFillter){
        $tSesUsrBchCode = $this->session->userdata ("tSesUsrBchCode");
        $tSesUsrLevel = $this->session->userdata ("tSesUsrLevel");
        /* Sale Bill In Date */
        if($tSesUsrLevel=="HQ"){
            $tSQL = "SELECT COUNT(TVDHD.FTXshDocNo) AS FNCountBill,ISNULL(SUM(TVDHD.FCXshGrand) ,0) AS FNSumCountBill
                    FROM TVDTSalHD TVDHD
                    LEFT JOIN TCNMShop TSHP ON TVDHD.FTBchCode = TSHP.FTBchCode AND TVDHD.FTShpCode = TSHP.FTShpCode";
            $tSQL .= " WHERE 
                    TVDHD.FNXshDocType = 9
                    AND CONVERT(char(10), TVDHD.FDXshDocDate,126) = '".$paSendToFillter["dDateFilter"]."'
                    AND TVDHD.FTBchCode = '".$paSendToFillter["tBCH"]."'";
            if($paSendToFillter["tMCH"]!=0){
                $tSQL .= " AND TSHP.FTMerCode = '".$paSendToFillter["tMCH"]."'";
            }
            if($paSendToFillter["tSPH"]!=0){
                $tSQL .= " AND TSHP.FTShpCode = '".$paSendToFillter["tSPH"]."'";
            }
        }else{
            $tSQL = "SELECT COUNT(TVDHD.FTXshDocNo) AS FNCountBill,ISNULL(SUM(TVDHD.FCXshGrand) ,0) AS FNSumCountBill
                    FROM TVDTSalHD TVDHD
                    LEFT JOIN TCNMShop TSHP ON TVDHD.FTBchCode = TSHP.FTBchCode AND TVDHD.FTShpCode = TSHP.FTShpCode";
            $tSQL .= " WHERE 
                    TVDHD.FNXshDocType = 9
                    AND CONVERT(char(10), TVDHD.FDXshDocDate,126) = '".$paSendToFillter["dDateFilter"]."'
                    AND TVDHD.FTBchCode = '".$tSesUsrBchCode."'";
            if($paSendToFillter["tMCH"]!=0){
                $tSQL .= " AND TSHP.FTMerCode = '".$paSendToFillter["tMCH"]."'";
            }
            if($paSendToFillter["tSPH"]!=0){
                $tSQL .= " AND TSHP.FTShpCode = '".$paSendToFillter["tSPH"]."'";
            }
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aSaleBillInfor = $oQuery->row_array();
            $tFNCountBill = $aSaleBillInfor["FNCountBill"];
            $tFNSumCountBill = $aSaleBillInfor["FNSumCountBill"];
        }else{
            $tFNCountBill = false;
            $tFNSumCountBill = false;
        }
        /* end */
        $aSendInfor = array(
            "tFNCountBill" => $tFNCountBill,
            "tFNSumCountBill"=>$tFNSumCountBill
        );
        return $aSendInfor;
    }
    public function FSxMGetALLGrossSale($paSendToFillter){
        $tWhere = " AND TSHD.FTBchCode = '".$paSendToFillter["tBCH"]."'";
        if($paSendToFillter["tMCH"]!=0){
            $tWhere .= " AND TSHP.FTMerCode = '".$paSendToFillter["tMCH"]."'";
        }
        if($paSendToFillter["tSPH"]!=0){
            $tWhere .= " AND TSHD.FTShpCode = '".$paSendToFillter["tSPH"]."'";
        }
        $tSQL = "SELECT 
                 TSHD.FTPosCode AS FTType,
                 SUM(
                        CASE WHEN TSHD.FNXshDocType = 1
                                  THEN TSDT.FCXsdNetAfHD 
                             WHEN TSHD.FNXshDocType = 9
                                  THEN TSDT.FCXsdNetAfHD * (-1)
                             ELSE 0
                             END
                    ) AS FCValue
                 FROM TVDTSalDT TSDT
                 LEFT JOIN TVDTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                 LEFT JOIN TCNMShop TSHP ON TSHD.FTBchCode = TSHP.FTBchCode AND TSHD.FTShpCode = TSHP.FTShpCode
                 WHERE 1=1".$tWhere;
        $tSQL .= " AND CONVERT(char(10), TSHD.FDXshDocDate,126) = '".$paSendToFillter["dDateFilter"]."'";         
        $tSQL .= " GROUP BY TSHD.FTPosCode
                   ORDER BY FCValue DESC
                 ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aInfor = $oQuery->result_array();
        }else{
            $aInfor = false;
        }
        return $aInfor;
    }

    public function FSxMGetListBestSalePdt($paFillter){
        $tWhere = " AND TSLHD.FTBchCode = '".$paFillter["tBCH"]."'";
        if($paFillter["tMCH"]!=0){
            $tWhere .= " AND TSHP.FTMerCode = '".$paFillter["tMCH"]."'";
        }
        if($paFillter["tSPH"]!=0){
            $tWhere .= " AND TSLHD.FTShpCode = '".$paFillter["tSPH"]."'";
        }
        $tSQL = "SELECT * FROM (	    
                    SELECT TOP 4
                    TPDTL.FTPdtName,
                    TUPDTL.FTPunName,
                    ISNULL(TIMG.FTImgObj,'') AS FTImgObj,
                    SUM(CASE WHEN TSLHD.FNXshDocType =1 
                            THEN TSLDT.FCXsdQtyAll
                            ELSE TSLDT.FCXsdQtyAll * -1
                            END ) AS FNXdtSaleQty
                    FROM TVDTSalDT TSLDT
                    LEFT JOIN TVDTSalHD TSLHD ON TSLDT.FTXshDocNo = TSLHD.FTXshDocNo
                    LEFT JOIN TCNMShop TSHP ON TSLHD.FTBchCode = TSHP.FTBchCode AND TSLHD.FTShpCode = TSHP.FTShpCode
                    LEFT JOIN TCNMPdtBar TBAR ON TSLDT.FTPdtCode = TBAR.FTPdtCode AND TSLDT.FTXsdBarCode = TBAR.FTBarCode
                    LEFT JOIN TCNMPdtUnit_L TUPDTL ON TBAR.FTPunCode = TUPDTL.FTPunCode AND TUPDTL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    LEFT JOIN TCNMPdt_L TPDTL ON TSLDT.FTPdtCode = TPDTL.FTPdtCode AND TPDTL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    LEFT JOIN TCNMImgPdt TIMG ON TSLDT.FTPdtCode = TIMG.FTImgRefID AND TIMG.FTImgTable = 'TCNMPdt' AND TIMG.FTImgKey = 'master' AND TIMG.FNImgSeq = 1
                    WHERE CONVERT(VARCHAR(10),TSLDT.FDCreateOn,121)  = '".$paFillter["dDateFilter"]."'";
        $tSQL .= $tWhere;
        $tSQL .= "  GROUP BY TPDTL.FTPdtName,TUPDTL.FTPunName,TIMG.FTImgObj 
                    ORDER BY FNXdtSaleQty DESC
                ) AS TPDTBestSale
                WHERE FNXdtSaleQty != 0
                ORDER BY FNXdtSaleQty DESC";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aListBestSalePdt = $oQuery->result_array();
        }else{
            $aListBestSalePdt = false;
        }
        return $aListBestSalePdt;
    }

    public function FSxMLoadHistoryPosSale($paFillter){
        $tWhere = " AND TSLHD.FTBchCode = '".$paFillter["tBCH"]."'";
        if($paFillter["tMCH"]!=0){
            $tWhere .= " AND TSHP.FTMerCode = '".$paFillter["tMCH"]."'";
        }
        if($paFillter["tSPH"]!=0){
            $tWhere .= " AND TSLHD.FTShpCode = '".$paFillter["tSPH"]."'";
        }
        $aInforPosDetail = array();
        $aPosGrossInfor = $this->FSxMGetALLGrossSale($paFillter);
        if($aPosGrossInfor){
            for($nI=0;$nI<FCNnHSizeOf($aPosGrossInfor);$nI++){
                $tSQL = "SELECT 
                            SUM(
                                CASE WHEN TSLHD.FNXshDocType = 1
                                        THEN 1
                                    WHEN TSLHD.FNXshDocType = 9
                                        THEN 1 * (-1)
                                    ELSE 0
                                    END
                            ) AS FCNumBill
                        FROM TVDTSalHD TSLHD
                        LEFT JOIN TCNMShop TSHP ON TSLHD.FTBchCode = TSHP.FTBchCode AND TSLHD.FTShpCode = TSHP.FTShpCode
                        WHERE TSLHD.FTPosCode = '".$aPosGrossInfor[$nI]["FTType"]."'".$tWhere;
                $oQuery = $this->db->query($tSQL);
                if($oQuery->num_rows() > 0){
                    $nNumBill = $oQuery->row_array()["FCNumBill"];
                }else{
                    $nNumBill = 0;
                }
                array_push($aInforPosDetail,array(
                    "tPosCode" => $aPosGrossInfor[$nI]["FTType"],
                    "tGrossSale" => $aPosGrossInfor[$nI]["FCValue"],
                    "tNumBillSale" => $nNumBill
                ));
                if($nI==9){
                    break;
                }
            }
        }else{
            $aInforPosDetail = false;
        }
        
        return $aInforPosDetail;
    }
}

