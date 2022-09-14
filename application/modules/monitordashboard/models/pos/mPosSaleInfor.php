<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPosSaleInfor extends CI_Model {

    public function FSxMGetNumBillSale($paSendToFillter){
        $tSQLWhere = '';
        if($paSendToFillter["tConditionWritGraph"]=="day"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126)  = '".$paSendToFillter["dDateFilter"]."'";
        }else if($paSendToFillter["tConditionWritGraph"]=="week"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126) 
                       BETWEEN '".date("Y-m-d", strtotime("monday this week",strtotime($paSendToFillter["dDateFilter"])))."' 
                       AND '".date("Y-m-d", strtotime("sunday this week",strtotime($paSendToFillter["dDateFilter"])))."'";
        }else if($paSendToFillter["tConditionWritGraph"]=="month"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126) 
                       BETWEEN '".date("Y-m-01",strtotime($paSendToFillter["dDateFilter"]))."' 
                       AND '".date("Y-m-t",strtotime($paSendToFillter["dDateFilter"]))."'";
        }else if($paSendToFillter["tConditionWritGraph"]=="year"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126)
                       BETWEEN '".date("Y-01-01",strtotime($paSendToFillter["dDateFilter"]))."' 
                       AND '".date("Y-12-31",strtotime($paSendToFillter["dDateFilter"]))."'";
        }
        $tSesUsrBchCode = $this->session->userdata ("tSesUsrBchCode");
        $tSesUsrLevel = $this->session->userdata ("tSesUsrLevel");
        /* Sale Bill In Date */
        if($tSesUsrLevel=="HQ"){
            $tSQL = "SELECT COUNT(FTXshDocNo) AS FNCountBill,ISNULL(SUM(FCXshGrand) ,0) AS FNSumCountBill
                    FROM TPSTSalHD
                    WHERE 
                    FNXshDocType = 1".$tSQLWhere;
        }else{
            $tSQL = "SELECT COUNT(FTXshDocNo) AS FNCountBill,ISNULL(SUM(FCXshGrand) ,0) AS FNSumCountBill
                    FROM TPSTSalHD
                    WHERE 
                    FTBchCode = '".$tSesUsrBchCode."'
                    AND FNXshDocType = 1".$tSQLWhere;
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
        $tSQLWhere = '';
        if($paSendToFillter["tConditionWritGraph"]=="day"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126)  = '".$paSendToFillter["dDateFilter"]."'";
        }else if($paSendToFillter["tConditionWritGraph"]=="week"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126) 
                       BETWEEN '".date("Y-m-d", strtotime("monday this week",strtotime($paSendToFillter["dDateFilter"])))."' 
                       AND '".date("Y-m-d", strtotime("sunday this week",strtotime($paSendToFillter["dDateFilter"])))."'";
        }else if($paSendToFillter["tConditionWritGraph"]=="month"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126) 
                       BETWEEN '".date("Y-m-01",strtotime($paSendToFillter["dDateFilter"]))."' 
                       AND '".date("Y-m-t",strtotime($paSendToFillter["dDateFilter"]))."'";
        }else if($paSendToFillter["tConditionWritGraph"]=="year"){
            $tSQLWhere .= " AND CONVERT(char(10), FDXshDocDate,126)
                       BETWEEN '".date("Y-01-01",strtotime($paSendToFillter["dDateFilter"]))."' 
                       AND '".date("Y-12-31",strtotime($paSendToFillter["dDateFilter"]))."'";
        }
        $tSesUsrBchCode = $this->session->userdata ("tSesUsrBchCode");
        $tSesUsrLevel = $this->session->userdata ("tSesUsrLevel");
        /* Sale Bill In Date */
        if($tSesUsrLevel=="HQ"){
            $tSQL = "SELECT COUNT(FTXshDocNo) AS FNCountBill,ISNULL(SUM(FCXshGrand) ,0) AS FNSumCountBill
                    FROM TPSTSalHD
                    WHERE 
                    FNXshDocType = 9".$tSQLWhere;
        }else{
            $tSQL = "SELECT COUNT(FTXshDocNo) AS FNCountBill,ISNULL(SUM(FCXshGrand) ,0) AS FNSumCountBill
                    FROM TPSTSalHD
                    WHERE 
                    FTBchCode = '".$tSesUsrBchCode."'
                    AND FNXshDocType = 9".$tSQLWhere;
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
    public function FSxMGetALLBillSale($pdDateFilter){
        $tSQLWhere = '';
        if($pdDateFilter["tConditionWritGraph"]=="day"){
            $tSQLWhere .= " AND CONVERT(VARCHAR(10),TSDT.FDCreateOn,121)  = '".$pdDateFilter["dDateFilter"]."'";
        }else if($pdDateFilter["tConditionWritGraph"]=="week"){
            $tSQLWhere .= " AND CONVERT(VARCHAR(10),TSDT.FDCreateOn,121) 
                       BETWEEN '".date("Y-m-d", strtotime("monday this week",strtotime($pdDateFilter["dDateFilter"])))."' 
                       AND '".date("Y-m-d", strtotime("sunday this week",strtotime($pdDateFilter["dDateFilter"])))."'";
        }else if($pdDateFilter["tConditionWritGraph"]=="month"){
            $tSQLWhere .= " AND CONVERT(VARCHAR(10),TSDT.FDCreateOn,121) 
                       BETWEEN '".date("Y-m-01",strtotime($pdDateFilter["dDateFilter"]))."' 
                       AND '".date("Y-m-t",strtotime($pdDateFilter["dDateFilter"]))."'";
        }else if($pdDateFilter["tConditionWritGraph"]=="year"){
            $tSQLWhere .= " AND CONVERT(VARCHAR(10),TSDT.FDCreateOn,121) 
                       BETWEEN '".date("Y-01-01",strtotime($pdDateFilter["dDateFilter"]))."' 
                       AND '".date("Y-12-31",strtotime($pdDateFilter["dDateFilter"]))."'";
        }
        if($pdDateFilter["tTypeCalDisplayGraph"]=="gross"){
            $aSaleBillInfor = $this->FSxMSumGrossSaleInfor($pdDateFilter,$tSQLWhere); 
        }else{
            $aSaleBillInfor = $this->FSxMCountBillSaleInfor($pdDateFilter,$tSQLWhere); 
        }
        return $aSaleBillInfor;
    }
    
    // หาจำนวนยอดขาย ตามรายการการค้นหา และ วันที่
    public function FSxMSumGrossSaleInfor($pdDateFilter,$tSQLWhere){
        if($pdDateFilter["tTypeWriteGraph"]=="pdtGroup"){
            $tSQL = "SELECT 
                    TPDTGL.FTPgpChainName AS FTType,
                    SUM(
                        CASE WHEN TSHD.FNXshDocType = 1
                                  THEN TSDT.FCXsdNetAfHD 
                             WHEN TSHD.FNXshDocType = 9
                                  THEN TSDT.FCXsdNetAfHD * (-1)
                             ELSE 0
                             END
                    ) AS FCValue";
            $tSQL .= " FROM TPSTSalDT TSDT
                    LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                    LEFT JOIN TCNMPdt TPDT ON TSDT.FTPdtCode = TPDT.FTPdtCode
                    LEFT JOIN TCNMPdtGrp_L TPDTGL ON TPDT.FTPgpChain = TPDTGL.FTPgpChain AND TPDTGL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    WHERE 1=1";
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TPDTGL.FTPgpChainName";
        }else if($pdDateFilter["tTypeWriteGraph"]=="pdtType"){
            $tSQL = "SELECT 
                    TPDTTL.FTPtyName AS FTType,
                    SUM(
                        CASE WHEN TSHD.FNXshDocType = 1
                                    THEN TSDT.FCXsdNetAfHD 
                                WHEN TSHD.FNXshDocType = 9
                                    THEN TSDT.FCXsdNetAfHD * (-1)
                                ELSE 0
                                END
                    ) AS FCValue";
            $tSQL .= " FROM TPSTSalDT TSDT
                    LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                    LEFT JOIN TCNMPdt TPDT ON TSDT.FTPdtCode = TPDT.FTPdtCode
                    LEFT JOIN TCNMPdtType_L TPDTTL ON TPDT.FTPtyCode = TPDTTL.FTPtyCode AND TPDTTL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    WHERE 1=1";
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TPDTTL.FTPtyName";
        }else if($pdDateFilter["tTypeWriteGraph"]=="usrBranch"){
            $tSQL = "SELECT 
                    TBCHL.FTBchName AS FTType,
                    SUM(
                        CASE WHEN TSHD.FNXshDocType = 1
                                    THEN TSDT.FCXsdNetAfHD 
                                WHEN TSHD.FNXshDocType = 9
                                    THEN TSDT.FCXsdNetAfHD * (-1)
                                ELSE 0
                                END
                    ) AS FCValue";
            $tSQL .= " FROM TPSTSalDT TSDT
                    LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                    LEFT JOIN TCNMBranch_L TBCHL ON TSDT.FTBchCode = TBCHL.FTBchCode AND TBCHL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    WHERE 1=1";
            if($this->session->userdata( "tSesUsrLevel")!="HQ"){
                $tSQL .= " AND TSDT.FTBchCode = '".$this->session->userdata( "tSesUsrBchCode")."'";
            }
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TBCHL.FTBchName";
        }else if($pdDateFilter["tTypeWriteGraph"]=="usrShop"){
            $tSQL = "SELECT 
                TSPHL.FTShpName AS FTType,
                SUM(
                    CASE WHEN TSHD.FNXshDocType = 1
                                THEN TSDT.FCXsdNetAfHD 
                            WHEN TSHD.FNXshDocType = 9
                                THEN TSDT.FCXsdNetAfHD * (-1)
                            ELSE 0
                            END
                ) AS FCValue";
            $tSQL .= " FROM TPSTSalDT TSDT
                    LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                    LEFT JOIN TCNMShop_L TSPHL ON TSHD.FTBchCode = TSPHL.FTBchCode AND TSHD.FTShpCode = TSPHL.FTShpCode  AND TSPHL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    WHERE 1=1";
            if($this->session->userdata( "tSesUsrLevel")!="HQ"){
                $tSQL .= " AND TSHD.FTBchCode = '".$this->session->userdata( "tSesUsrBchCode")."'";
            }
            if($this->session->userdata( "tSesUsrLevel")=="SHP"){
                $tSQL .= " AND TSHD.FTShpCode = '".$this->session->userdata( "tSesUsrShpCode")."'";
            }
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TSHD.FTBchCode,TSPHL.FTShpName";
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aSaleBillInfor = $oQuery->result_array();
        }else{
            $aSaleBillInfor = false;
        }
        return $aSaleBillInfor;
    }

    //หาจำนวน บิลจาก รายการค้นหา และ วันที่
    public function FSxMCountBillSaleInfor($pdDateFilter,$tSQLWhere){
        if($pdDateFilter["tTypeWriteGraph"]=="pdtGroup"){
            $tSQL = "SELECT 
                        TPDTGL.FTPgpChainName,
                        TPDTGL.FTPgpChain
                    FROM TPSTSalDT TSDT
                    LEFT JOIN TCNMPdt TPDT ON TSDT.FTPdtCode = TPDT.FTPdtCode
                    LEFT JOIN TCNMPdtGrp_L TPDTGL ON TPDT.FTPgpChain = TPDTGL.FTPgpChain AND TPDTGL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    WHERE 1=1";
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TPDTGL.FTPgpChain,TPDTGL.FTPgpChainName";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aBufferFTType = $oQuery->result_array();
                $aSaleBillInfor = array();
                for($nI=0;$nI<FCNnHSizeOf($aBufferFTType);$nI++){
                    $aBufferDataFillter = array();
                    $aBufferDataFillter["FTType"] = $aBufferFTType[$nI]["FTPgpChainName"];
                    $tSQL = "SELECT SUM(
                                        CASE WHEN TSalInfor.FNXshDocType = 1
                                                THEN 1
                                        WHEN TSalInfor.FNXshDocType = 9
                                                THEN 1 * (-1)
                                        ELSE 0
                                        END
                                    ) AS FCValue
                            FROM(
                                SELECT TSDT.FTXshDocNo,TSHD.FNXshDocType";
                    $tSQL .= " FROM TPSTSalDT TSDT
                                LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                                LEFT JOIN TCNMPdt TPDT ON TSDT.FTPdtCode = TPDT.FTPdtCode
                                WHERE 1=1";
                    $tSQL .= $tSQLWhere;
                    $tSQL .= " AND TPDT.FTPgpChain = '".$aBufferFTType[$nI]["FTPgpChain"]."'";
                    $tSQL .= " GROUP BY TSDT.FTXshDocNo,TSHD.FNXshDocType
                                ) AS TSalInfor";
                    $oQuery = $this->db->query($tSQL);
                    if($oQuery->num_rows() > 0){
                        $aBufferFCValue = $oQuery->row_array();
                        $aBufferDataFillter["FCValue"] = $aBufferFCValue["FCValue"];
                    }else{
                        $aBufferDataFillter["FCValue"] = 0;
                    } 
                    array_push($aSaleBillInfor,$aBufferDataFillter);       
                }
            }else{
                $aSaleBillInfor = false;
            }
            return $aSaleBillInfor;
        }else if($pdDateFilter["tTypeWriteGraph"]=="pdtType"){
            $tSQL = "SELECT 
                        TPDTTL.FTPtyName,
                        TPDT.FTPtyCode
                    FROM TPSTSalDT TSDT
                    LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                    LEFT JOIN TCNMPdt TPDT ON TSDT.FTPdtCode = TPDT.FTPdtCode
                    LEFT JOIN TCNMPdtType_L TPDTTL ON TPDT.FTPtyCode = TPDTTL.FTPtyCode AND TPDTTL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    WHERE 1=1";
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TPDT.FTPtyCode,TPDTTL.FTPtyName";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aBufferFTType = $oQuery->result_array();
                $aSaleBillInfor = array();
                for($nI=0;$nI<FCNnHSizeOf($aBufferFTType);$nI++){
                    $aBufferDataFillter = array();
                    $aBufferDataFillter["FTType"] = $aBufferFTType[$nI]["FTPtyName"];
                    $tSQL = "SELECT SUM(
                                        CASE WHEN TSalInfor.FNXshDocType = 1
                                                THEN 1
                                        WHEN TSalInfor.FNXshDocType = 9
                                                THEN 1 * (-1)
                                        ELSE 0
                                        END
                                    ) AS FCValue
                            FROM(
                                SELECT TSDT.FTXshDocNo,TSHD.FNXshDocType";
                    $tSQL .= "  FROM TPSTSalDT TSDT
                                LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                                LEFT JOIN TCNMPdt TPDT ON TSDT.FTPdtCode = TPDT.FTPdtCode
                                WHERE 1=1";
                    $tSQL .= $tSQLWhere;
                    $tSQL .= " AND TPDT.FTPtyCode = '".$aBufferFTType[$nI]["FTPtyCode"]."'";
                    $tSQL .= " GROUP BY TSDT.FTXshDocNo,TSHD.FNXshDocType
                                ) AS TSalInfor";
                    $oQuery = $this->db->query($tSQL);
                    if($oQuery->num_rows() > 0){
                        $aBufferFCValue = $oQuery->row_array();
                        $aBufferDataFillter["FCValue"] = $aBufferFCValue["FCValue"];
                    }else{
                        $aBufferDataFillter["FCValue"] = 0;
                    } 
                    array_push($aSaleBillInfor,$aBufferDataFillter);       
                }
            }else{
                $aSaleBillInfor = false;
            }
            return $aSaleBillInfor;
        }else if($pdDateFilter["tTypeWriteGraph"]=="usrBranch"){
            $tSQL = "SELECT 
                        TBCHL.FTBchName,
                        TSHD.FTBchCode
                        FROM TPSTSalDT TSDT
                    LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                    LEFT JOIN TCNMBranch_L TBCHL ON TSHD.FTBchCode = TBCHL.FTBchCode AND TBCHL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    WHERE 1=1";
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TSHD.FTBchCode,TBCHL.FTBchName";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aBufferFTType = $oQuery->result_array();
                $aSaleBillInfor = array();
                for($nI=0;$nI<FCNnHSizeOf($aBufferFTType);$nI++){
                    $aBufferDataFillter = array();
                    $aBufferDataFillter["FTType"] = $aBufferFTType[$nI]["FTBchName"];
                    $tSQL = "SELECT SUM(
                                        CASE WHEN TSalInfor.FNXshDocType = 1
                                                THEN 1
                                        WHEN TSalInfor.FNXshDocType = 9
                                                THEN 1 * (-1)
                                        ELSE 0
                                        END
                                    ) AS FCValue
                            FROM(
                                SELECT TSDT.FTXshDocNo,TSHD.FNXshDocType";
                    $tSQL .= "  FROM TPSTSalDT TSDT
                                LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                                LEFT JOIN TCNMBranch_L TBCHL ON TSDT.FTBchCode = TBCHL.FTBchCode AND TBCHL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                                WHERE 1=1";
                    $tSQL .= $tSQLWhere;
                    $tSQL .= " AND TSHD.FTBchCode = '".$aBufferFTType[$nI]["FTBchCode"]."'";
                    $tSQL .= " GROUP BY TSDT.FTXshDocNo,TSHD.FNXshDocType
                                ) AS TSalInfor";
                    $oQuery = $this->db->query($tSQL);
                    if($oQuery->num_rows() > 0){
                        $aBufferFCValue = $oQuery->row_array();
                        $aBufferDataFillter["FCValue"] = $aBufferFCValue["FCValue"];
                    }else{
                        $aBufferDataFillter["FCValue"] = 0;
                    } 
                    array_push($aSaleBillInfor,$aBufferDataFillter);       
                }
            }else{
                $aSaleBillInfor = false;
            }
            return $aSaleBillInfor;
        }else if($pdDateFilter["tTypeWriteGraph"]=="usrShop"){
            $tSQL = "SELECT 
                        TSHD.FTBchCode,
                        TSHD.FTShpCode,
                        TSPHL.FTShpName";
            $tSQL .= " FROM TPSTSalDT TSDT
                        LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                        LEFT JOIN TCNMShop_L TSPHL ON TSHD.FTBchCode = TSPHL.FTBchCode AND TSHD.FTShpCode = TSPHL.FTShpCode  AND TSPHL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                        WHERE 1=1";
            if($this->session->userdata( "tSesUsrLevel")!="HQ"){
                $tSQL .= " AND TSHD.FTBchCode = '".$this->session->userdata( "tSesUsrBchCode")."'";
            }
            if($this->session->userdata( "tSesUsrLevel")=="SHP"){
                $tSQL .= " AND TSHD.FTShpCode = '".$this->session->userdata( "tSesUsrShpCode")."'";
            }
            $tSQL .= $tSQLWhere;
            $tSQL .= " GROUP BY TSHD.FTBchCode,TSHD.FTShpCode,TSPHL.FTShpName";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aBufferFTType = $oQuery->result_array();
                $aSaleBillInfor = array();
                for($nI=0;$nI<FCNnHSizeOf($aBufferFTType);$nI++){
                    $aBufferDataFillter = array();
                    $aBufferDataFillter["FTType"] = $aBufferFTType[$nI]["FTShpName"];
                    $tSQL = "SELECT SUM(
                                        CASE WHEN TSalInfor.FNXshDocType = 1
                                                THEN 1
                                        WHEN TSalInfor.FNXshDocType = 9
                                                THEN 1 * (-1)
                                        ELSE 0
                                        END
                                    ) AS FCValue
                            FROM(
                                SELECT TSDT.FTXshDocNo,TSHD.FNXshDocType";
                    $tSQL .= " FROM TPSTSalDT TSDT
                            LEFT JOIN TPSTSalHD TSHD ON TSDT.FTBchCode = TSHD.FTBchCode AND TSDT.FTXshDocNo = TSHD.FTXshDocNo
                            LEFT JOIN TCNMShop_L TSPHL ON TSHD.FTBchCode = TSPHL.FTBchCode AND TSHD.FTShpCode = TSPHL.FTShpCode  AND TSPHL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                            WHERE 1=1";
                    $tSQL .= $tSQLWhere;
                    $tSQL .= " AND TSHD.FTShpCode = '".$aBufferFTType[$nI]["FTShpCode"]."'";
                    $tSQL .= " GROUP BY TSDT.FTXshDocNo,TSHD.FNXshDocType
                                ) AS TSalInfor";
                    $oQuery = $this->db->query($tSQL);
                    if($oQuery->num_rows() > 0){
                        $aBufferFCValue = $oQuery->row_array();
                        $aBufferDataFillter["FCValue"] = $aBufferFCValue["FCValue"];
                    }else{
                        $aBufferDataFillter["FCValue"] = 0;
                    } 
                    array_push($aSaleBillInfor,$aBufferDataFillter);       
                }
            }else{
                $aSaleBillInfor = false;
            }
            return $aSaleBillInfor;
        }
    }

    public function FSxMGetListBestSalePdt($pdDateFilter){
        $tSQL = "SELECT * FROM (	    
                    SELECT TOP 10
                    TPDTL.FTPdtName,
                    TUPDTL.FTPunName,
                    ISNULL(TIMG.FTImgObj,'') AS FTImgObj,
                    SUM(CASE WHEN TSLHD.FNXshDocType =1 
                            THEN TSLDT.FCXsdQtyAll
                            ELSE TSLDT.FCXsdQtyAll * -1
                            END ) AS FNXdtSaleQty
                    FROM TPSTSalDT TSLDT
                    LEFT JOIN TPSTSalHD TSLHD ON TSLDT.FTXshDocNo = TSLHD.FTXshDocNo
                    LEFT JOIN TCNMPdtBar TBAR ON TSLDT.FTPdtCode = TBAR.FTPdtCode AND TSLDT.FTXsdBarCode = TBAR.FTBarCode
                    LEFT JOIN TCNMPdtUnit_L TUPDTL ON TBAR.FTPunCode = TUPDTL.FTPunCode AND TUPDTL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    LEFT JOIN TCNMPdt_L TPDTL ON TSLDT.FTPdtCode = TPDTL.FTPdtCode AND TPDTL.FNLngID = '".$this->session->userdata( "tLangEdit")."'
                    LEFT JOIN TCNMImgPdt TIMG ON TSLDT.FTPdtCode = TIMG.FTImgRefID AND TIMG.FTImgTable = 'TCNMPdt' AND TIMG.FTImgKey = 'master' AND TIMG.FNImgSeq = 1
                    WHERE CONVERT(VARCHAR(10),TSLDT.FDCreateOn,121)  = '".$pdDateFilter."'
                    GROUP BY TPDTL.FTPdtName,TUPDTL.FTPunName,TIMG.FTImgObj 
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
}

