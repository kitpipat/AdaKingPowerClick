<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCouponSetupImport extends CI_Model {

    //ข้อมูลใน Temp
    public function FSaMCPHGetTempData($paDataSearch){
        $tType          = $paDataSearch['tType'];
        $nLngID         = $paDataSearch['nLangEdit'];
        $tTableKey      = $paDataSearch['tTableKey'];
        $tSessionID     = $paDataSearch['tSessionID'];
        $tTextSearch    = $paDataSearch['tTextSearch'];
        $nDecimalShw    = FCNxHGetOptionDecimalShow();

        switch ($tType) {
            case "TFNTCouponHD":
                $tSQL   = " SELECT 
                                IMP.FTBchCode,IMP.FTCphDocNo,IMP.FTCptCode,CONVERT(DATE,IMP.FDCphDocDate) AS FDCphDocDate,IMP.FTCphDisType,
                                FORMAT(IMP.FCCphDisValue,'N".$nDecimalShw."') AS FCCphDisValue,IMP.FTPplCode,CONVERT(DATE,IMP.FDCphDateStart) AS FDCphDateStart,CONVERT(DATE,IMP.FDCphDateStop) AS FDCphDateStop,CONVERT(VARCHAR,IMP.FTCphTimeStart,108) AS FTCphTimeStart,
                                CONVERT(VARCHAR,IMP.FTCphTimeStop,108) AS FTCphTimeStop,FORMAT(IMP.FCCphMinValue,'N".$nDecimalShw."') AS FCCphMinValue,IMP.FTCphStaOnTopPmt,IMP.FNCphLimitUsePerBill,
                                IMP.FTCphRefAccCode,IMP.FTStaChkMember,IMP.FTCpnName,IMP.FTCpnMsg1,IMP.FTCpnMsg2,
                                IMP.FTTmpTableKey,IMP.FTSessionID,IMP.FTTmpStatus,IMP.FTTmpRemark,IMP.FNTmpSeq,
                                CTL.FTCptName,TPL.FTPplName
                            FROM TCNTImpCouponTmp       IMP  WITH(NOLOCK)
                            LEFT JOIN TFNMCouponType_L  CTL  WITH(NOLOCK) ON IMP.FTCptCode = CTL.FTCptCode AND CTL.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtPriList_L  TPL  WITH(NOLOCK) ON IMP.FTPplCode = TPL.FTPplCode AND TPL.FNLngID = $nLngID
                            WHERE IMP.FTSessionID     = '$tSessionID'
                              AND IMP.FTTmpTableKey   = '$tTableKey' ";
                // if($tTextSearch != '' || $tTextSearch != null){
                //     $tSQL .= " AND (IMP.FTTcgCode LIKE '%$tTextSearch%' ";
                //     $tSQL .= " OR IMP.FTTcgName LIKE '%$tTextSearch%' ";
                //     $tSQL .= " )";
                // }
            break;
            case "TFNTCouponDT":
                $tSQL   = " SELECT 
                                IMP.FTCpdBarCpn,IMP.FNCpdSeqNo,IMP.FNCpdAlwMaxUse,
                                IMP.FTTmpTableKey,IMP.FTSessionID,IMP.FTTmpStatus,IMP.FTTmpRemark,IMP.FNTmpSeq
                            FROM TCNTImpCouponTmp IMP  WITH(NOLOCK)
                            WHERE IMP.FTSessionID = '$tSessionID'
                            AND IMP.FTTmpTableKey = '$tTableKey' ";
                // if($tTextSearch != '' || $tTextSearch != null){
                //     $tSQL .= " AND (IMP.FTPgpChain LIKE '%$tTextSearch%' ";
                //     $tSQL .= " OR IMP.FTPgpName LIKE '%$tTextSearch%' ";
                //     $tSQL .= " )";
                // }
            break;
            // case "TCNMPdtModel":
            //     $tSQL   = " SELECT 
            //                     IMP.FNTmpSeq,
            //                     IMP.FTPmoCode,
            //                     IMP.FTPmoName,
            //                     IMP.FTTmpRemark,
            //                     IMP.FTTmpStatus
            //                 FROM TCNTImpMasTmp IMP WITH(NOLOCK)
            //                 WHERE 1=1
            //                     AND IMP.FTSessionID     = '$tSessionID'
            //                     AND FTTmpTableKey       = '$tTableKey'";
            //     if($tTextSearch != '' || $tTextSearch != null){
            //         $tSQL .= " AND (IMP.FTPmoCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPmoName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " )";
            //     }
            // break;
            // case "TCNMPdtType":
            //     $tSQL   = " SELECT 
            //                     IMP.FNTmpSeq,
            //                     IMP.FTPtyCode,
            //                     IMP.FTPtyName,
            //                     IMP.FTTmpRemark,
            //                     IMP.FTTmpStatus
            //                 FROM TCNTImpMasTmp IMP WITH(NOLOCK)
            //                 WHERE 1=1
            //                     AND IMP.FTSessionID     = '$tSessionID'
            //                     AND FTTmpTableKey       = '$tTableKey'";
            //     if($tTextSearch != '' || $tTextSearch != null){
            //         $tSQL .= " AND (IMP.FTPtyCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPtyName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " )";
            //     }
            // break;
            // case "TCNMPdtBrand":
            //     $tSQL   = " SELECT 
            //                     IMP.FNTmpSeq,
            //                     IMP.FTPbnCode,
            //                     IMP.FTPbnName,
            //                     IMP.FTTmpRemark,
            //                     IMP.FTTmpStatus
            //                 FROM TCNTImpMasTmp IMP WITH(NOLOCK)
            //                 WHERE 1=1
            //                     AND IMP.FTSessionID     = '$tSessionID'
            //                     AND FTTmpTableKey       = '$tTableKey'";
            //     if($tTextSearch != '' || $tTextSearch != null){
            //         $tSQL .= " AND (IMP.FTPbnCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPbnName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " )";
            //     }
            // break;
            // case "TCNMPdtUnit":
            //     $tSQL   = " SELECT 
            //                     IMP.FNTmpSeq,
            //                     IMP.FTPunCode,
            //                     IMP.FTPunName,
            //                     IMP.FTTmpRemark,
            //                     IMP.FTTmpStatus
            //                 FROM TCNTImpMasTmp IMP WITH(NOLOCK)
            //                 WHERE 1=1
            //                     AND IMP.FTSessionID     = '$tSessionID'
            //                     AND FTTmpTableKey       = '$tTableKey'";
            //     if($tTextSearch != '' || $tTextSearch != null){
            //         $tSQL .= " AND (IMP.FTPunCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPunName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " )";
            //     }
            // break;
            // case "TCNMPDT":
            //     $tSQL   = " SELECT 
            //                     IMP.FNTmpSeq,
            //                     IMP.FTPdtCode,
            //                     IMP.FTPdtName,
            //                     IMP.FTPdtNameABB,
            //                     IMP.FTPunCode,
            //                     UNIT.FTPunName,
            //                     IMP.FCPdtUnitFact,
            //                     IMP.FTBarCode,
            //                     IMP.FTPbnCode,
            //                     BRAND.FTPbnName,
            //                     IMP.FTTcgCode,
            //                     TOUCH.FTTcgName,
            //                     IMP.FTTmpRemark,
            //                     IMP.FTTmpStatus,
            //                     UNIT_L.FTPunName AS Master_FTPunName,
            //                     BRAND_L.FTPbnName AS Master_FTPbnName,
            //                     TOUCH_L.FTTcgName AS Master_FTTcgName,
            //                     IMP.FTPtyCode,
            //                     IMP.FTPmoCode,
            //                     IMP.FTPgpChain,
            //                     IMP.FTPdtStaVat
            //                 FROM TCNTImpMasTmp IMP WITH(NOLOCK)
            //                 LEFT JOIN TCNTImpMasTmp UNIT        ON UNIT.FTPunCode       = IMP.FTPunCode  AND UNIT.FTTmpTableKey = 'TCNMPdtUnit'         AND UNIT.FTTmpStatus = 1
            //                 LEFT JOIN TCNTImpMasTmp BRAND       ON BRAND.FTPbnCode      = IMP.FTPbnCode  AND BRAND.FTTmpTableKey = 'TCNMPdtBrand'       AND BRAND.FTTmpStatus = 1
            //                 LEFT JOIN TCNTImpMasTmp TOUCH       ON TOUCH.FTTcgCode      = IMP.FTTcgCode  AND TOUCH.FTTmpTableKey = 'TCNMPdtTouchGrp'    AND TOUCH.FTTmpStatus = 1
            //                 LEFT JOIN TCNMPdtUnit_L UNIT_L      ON UNIT_L.FTPunCode     = IMP.FTPunCode  AND UNIT_L.FNLngID = $nLngID                   AND IMP.FTTmpStatus = 1
            //                 LEFT JOIN TCNMPdtBrand_L BRAND_L    ON BRAND_L.FTPbnCode    = IMP.FTPbnCode  AND BRAND_L.FNLngID = $nLngID                  AND IMP.FTTmpStatus = 1
            //                 LEFT JOIN TCNMPdtTouchGrp_L TOUCH_L ON TOUCH_L.FTTcgCode    = IMP.FTTcgCode  AND TOUCH_L.FNLngID = $nLngID                  AND IMP.FTTmpStatus = 1
            //                 WHERE 1=1
            //                     AND IMP.FTSessionID     = '$tSessionID'
            //                     AND IMP.FTTmpTableKey       = '$tTableKey'
                                
            //                     ";
            //     if($tTextSearch != '' || $tTextSearch != null){
            //         $tSQL .= " AND (IMP.FTPdtCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPdtName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPdtNameABB LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPunCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR UNIT.FTPunName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FCPdtUnitFact LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTBarCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTPbnCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR BRAND.FTPbnName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR IMP.FTTcgCode LIKE '%$tTextSearch%' ";
            //         $tSQL .= " OR TOUCH.FTTcgName LIKE '%$tTextSearch%' ";
            //         $tSQL .= " )";
            //     }
            // break;
        }
        
        // echo $tSQL ;

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

    //หาจำนวน record ทั้งหมด
    public function FSaMCPHGetTempDataAtAll($ptTableName){
        try{
            $tSesSessionID = $this->session->userdata("tSesSessionID");
            $tSQL   = "SELECT TOP 1
                        (SELECT COUNT(FTTmpTableKey) AS TYPESIX FROM TCNTImpCouponTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        AND IMP.FTTmpStatus       = '6') AS TYPESIX ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpCouponTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        AND IMP.FTTmpStatus       = '1') AS TYPEONE ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpCouponTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        ) AS ITEMALL
                    FROM TCNTImpCouponTmp ";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //ลบข้อมูล Temp 
    public function FSaMCPHImportDelete($paParamMaster) {
        try{
            $this->db->where_in('FNTmpSeq', $paParamMaster['FNTmpSeq']);
            $this->db->where_in('FTTmpTableKey', $paParamMaster['tTableKey']);
            $this->db->where('FTSessionID', $paParamMaster['tSessionID']);
            $this->db->delete('TCNTImpCouponTmp');

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

    public function FSxMCPHImportMove2MasterNew($paDataSearch){
        try{
            $nLngID             = $paDataSearch['nLangEdit'];
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $dDateStart         = $paDataSearch['dDateStart'];
            $dDateStop          = $paDataSearch['dDateStop'];

            //เพิ่มข้อมูลลงตาราง TFNTCouponHD
            $tSQL   = " INSERT INTO TFNTCouponHD (
                            FTBchCode,FTCphDocNo,FTCptCode,FDCphDocDate,FTCphDisType,
                            FCCphDisValue,FTPplCode,FDCphDateStart,FDCphDateStop,FTCphTimeStart,
                            FTCphTimeStop,FTCphStaClosed,FTUsrCode,FTCphUsrApv,FTCphStaDoc,
                            FTCphStaApv,FTCphStaPrcDoc,FTCphStaDelMQ,FCCphMinValue,FTCphStaOnTopPmt,
                            FNCphLimitUsePerBill,FTCphRefAccCode,FTStaChkMember,FDLastUpdOn,FTLastUpdBy,
                            FDCreateOn,FTCreateBy )
                        SELECT
                            FTBchCode,FTCphDocNo,FTCptCode,FDCphDocDate,FTCphDisType,
                            FCCphDisValue,FTPplCode,FDCphDateStart,FDCphDateStop,FTCphTimeStart,
                            FTCphTimeStop,FTCphStaClosed,FTUsrCode,FTCphUsrApv,FTCphStaDoc,
                            FTCphStaApv,FTCphStaPrcDoc,FTCphStaDelMQ,FCCphMinValue,FTCphStaOnTopPmt,
                            FNCphLimitUsePerBill,FTCphRefAccCode,FTStaChkMember,'$dDateOn' AS FDLastUpdOn,'$tUserBy' AS FTLastUpdBy,
                            '$dDateOn' AS FDCreateOn,'$tUserBy' AS FTCreateBy
                        FROM TCNTImpCouponTmp WITH(NOLOCK)
                        WHERE FTSessionID = '$tSessionID' 
                        AND FTTmpTableKey = 'TFNTCouponHD'
                        AND FTTmpStatus = '1' ";
            $this->db->query($tSQL);
            
            //เพิ่มข้อมูลลงตาราง TFNTCouponHD_L
            $tSQL   = " INSERT INTO TFNTCouponHD_L (FTBchCode,FTCphDocNo,FNLngID,FTCpnName,FTCpnMsg1,FTCpnMsg2,FTCpnCond)
                        SELECT FTBchCode,FTCphDocNo,$nLngID AS FNLngID,FTCpnName,FTCpnMsg1,FTCpnMsg2,FTCpnCond
                        FROM TCNTImpCouponTmp WITH(NOLOCK)
                        WHERE FTSessionID = '$tSessionID' 
                          AND FTTmpTableKey = 'TFNTCouponHD'
                          AND FTTmpStatus = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TFNTCouponDT
            $tSQL   = " INSERT INTO TFNTCouponDT (FTBchCode,FTCphDocNo,FTCpdBarCpn,FNCpdSeqNo,FNCpdAlwMaxUse)
                        SELECT FTBchCode,FTCphDocNo,FTCpdBarCpn,FNCpdSeqNo,FNCpdAlwMaxUse
                        FROM TCNTImpCouponTmp 
                        WHERE FTSessionID = '$tSessionID' 
                          AND FTTmpTableKey = 'TFNTCouponDT'
                          AND FTTmpStatus = '1' ";
            $this->db->query($tSQL);

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

}

?>