<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mImpproduct extends CI_Model {

    //ข้อมูลใน Temp
    public function FSaMUSRGetTempData($paDataSearch){
        $tType          = $paDataSearch['tType'];
        $nLngID         = $paDataSearch['nLangEdit'];
        $tTableKey      = $paDataSearch['tTableKey'];
        $tSessionID     = $paDataSearch['tSessionID'];
        $tTextSearch    = $paDataSearch['tTextSearch'];

        switch ($tType) {
            case "TCNMPdtTouchGrp":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTTcgCode,
                                IMP.FTTcgName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTTcgCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTTcgName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPdtGrp":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPgpChain,
                                IMP.FTPgpName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPgpChain LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPgpName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPdtModel":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPmoCode,
                                IMP.FTPmoName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPmoCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPmoName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPdtType":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPtyCode,
                                IMP.FTPtyName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPtyCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPtyName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPdtBrand":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPbnCode,
                                IMP.FTPbnName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPbnCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPbnName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPdtUnit":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPunCode,
                                IMP.FTPunName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPunCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPunName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPDT":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPdtCode,
                                IMP.FTPdtName,
                                IMP.FTPdtNameABB,
                                IMP.FTPunCode,
                                UNIT.FTPunName,
                                IMP.FCPdtUnitFact,
                                IMP.FTBarCode,
                                IMP.FTPbnCode,
                                BRAND.FTPbnName,
                                IMP.FTTcgCode,
                                TOUCH.FTTcgName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus,
                                UNIT_L.FTPunName AS Master_FTPunName,
                                BRAND_L.FTPbnName AS Master_FTPbnName,
                                TOUCH_L.FTTcgName AS Master_FTTcgName,
                                IMP.FTPtyCode,
                                IMP.FTPmoCode,
                                IMP.FTPgpChain,
                                IMP.FTPdtStaVat
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            LEFT JOIN TCNTImpMasTmp UNIT        ON UNIT.FTPunCode       = IMP.FTPunCode  AND UNIT.FTTmpTableKey = 'TCNMPdtUnit'         AND UNIT.FTTmpStatus = 1
                            LEFT JOIN TCNTImpMasTmp BRAND       ON BRAND.FTPbnCode      = IMP.FTPbnCode  AND BRAND.FTTmpTableKey = 'TCNMPdtBrand'       AND BRAND.FTTmpStatus = 1
                            LEFT JOIN TCNTImpMasTmp TOUCH       ON TOUCH.FTTcgCode      = IMP.FTTcgCode  AND TOUCH.FTTmpTableKey = 'TCNMPdtTouchGrp'    AND TOUCH.FTTmpStatus = 1
                            LEFT JOIN TCNMPdtUnit_L UNIT_L      ON UNIT_L.FTPunCode     = IMP.FTPunCode  AND UNIT_L.FNLngID = $nLngID                   AND IMP.FTTmpStatus = 1
                            LEFT JOIN TCNMPdtBrand_L BRAND_L    ON BRAND_L.FTPbnCode    = IMP.FTPbnCode  AND BRAND_L.FNLngID = $nLngID                  AND IMP.FTTmpStatus = 1
                            LEFT JOIN TCNMPdtTouchGrp_L TOUCH_L ON TOUCH_L.FTTcgCode    = IMP.FTTcgCode  AND TOUCH_L.FNLngID = $nLngID                  AND IMP.FTTmpStatus = 1
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND IMP.FTTmpTableKey       = '$tTableKey'
                                
                                ";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPdtCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPdtName LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPdtNameABB LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPunCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR UNIT.FTPunName LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FCPdtUnitFact LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTBarCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPbnCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR BRAND.FTPbnName LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTTcgCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR TOUCH.FTTcgName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
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

    //ลบข้อมูล Temp 
    public function FSaMPDTImportDelete($paParamMaster) {
        try{
            $this->db->where_in('FNTmpSeq', $paParamMaster['FNTmpSeq']);
            $this->db->where_in('FTTmpTableKey', $paParamMaster['tTableKey']);
            $this->db->where('FTSessionID', $paParamMaster['tSessionID']);
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

    //ลบข้อมูลใน Temp หลังจาก move เสร็จแล้ว
    public function FSaMPDTImportMove2MasterDeleteTemp($paDataSearch){
        try{
            $tSessionID     = $paDataSearch['tSessionID'];
            $aWhere         = array('TCNMPDT','TCNMPdtUnit','TCNMPdtBrand','TCNMPdtTouchGrp','TCNMPdtType','TCNMPdtModel','TCNMPdtGrp','TCNMPdtSpcBch');

            // ลบรายการใน Temp
            $this->db->where_in('FTSessionID', $tSessionID);
            $this->db->where_in('FTTmpTableKey' , $aWhere);
            $this->db->delete('TCNTImpMasTmp');
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //move temp to ตารางจริง
    public function FSaMPDTImportMove2Master($paDataSearch){
        try{
            $nLngID             = $paDataSearch['nLangEdit'];
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $dDateStart         = $paDataSearch['dDateStart'];
            $dDateStop          = $paDataSearch['dDateStop'];

            //*********************** TCNMPdtTouchGrp + TCNMPdtTouchGrp_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp
            $tSQL   = " INSERT INTO TCNMPdtTouchGrp (FTTcgCode,FTAgnCode,FTTcgStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTTcgCode,
                            IMP.FTAgnCode,
                            1 AS FTTcgStaUse,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp_L
            $tSQL   = " INSERT INTO TCNMPdtTouchGrp_L (FTTcgCode,FNLngID,FTTcgName,FTTcgRmk)
                        SELECT 
                            IMP.FTTcgCode,
                            $nLngID,
                            IMP.FTTcgName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtBrand + TCNMPdtBrand_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtBrand
            $tSQL   = " INSERT INTO TCNMPdtBrand (FTPbnCode,FTAgnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPbnCode,
                            IMP.FTAgnCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtBrand_L
            $tSQL   = " INSERT INTO TCNMPdtBrand_L (FTPbnCode,FNLngID,FTPbnName,FTPbnRmk)
                        SELECT 
                            IMP.FTPbnCode,
                            $nLngID,
                            IMP.FTPbnName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtUnit + TCNMPdtUnit_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtUnit
            $tSQL   = " INSERT INTO TCNMPdtUnit (FTPunCode,FTAgnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPunCode,
                            IMP.FTAgnCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtUnit_L
            $tSQL   = " INSERT INTO TCNMPdtUnit_L (FTPunCode,FNLngID,FTPunName)
                        SELECT 
                            IMP.FTPunCode,
                            $nLngID,
                            IMP.FTPunName
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);
        
            //*********************** TCNMPDT + TCNMPDT_L + TCNMPDTPackSize + TCNMPdtBar ************************//
            //เพิ่มข้อมูลลงตาราง TCNMPDT
            $tSQL   = " UPDATE
                            TCNMPDT
                        SET
                            TCNMPDT.FTTcgCode       = TCNTImpMasTmp.FTTcgCode,
                            TCNMPDT.FTPbnCode       = TCNTImpMasTmp.FTPbnCode
                        FROM
                            TCNMPDT
                        INNER JOIN
                            TCNTImpMasTmp
                        ON
                            TCNMPDT.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                        WHERE
                            TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                        AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                        AND TCNTImpMasTmp.FTTmpStatus = '1' ";
            $this->db->query($tSQL);
            if($this->db->affected_rows() == 0){
                $tSQL   = " INSERT INTO TCNMPDT (
                                FTPDTCode ,FTTcgCode ,FTPbnCode ,FTPdtStaVat ,FTPdtStaActive ,FTPdtStaAlwReturn,
                                FTPdtStaAlwDis ,FTPdtStaVatBuy ,FTPdtStaAlwReCalOpt ,FTPdtStaCsm ,FTPdtPoint ,FTPdtForSystem,
                                FTPdtStkControl ,FTPdtType , FTPdtSaleType ,FTPdtSetOrSN ,FTPdtStaSetPri ,FDPdtSaleStart,
                                FDPdtSaleStop ,FCPdtMin , FCPdtMax ,FTVatCode, FDLastUpdOn , FTLastUpdBy, FDCreateOn, FTCreateBy
                            )
                            SELECT DISTINCT
                                IMP.FTPDTCode,
                                IMP.FTTcgCode,
                                IMP.FTPbnCode,
                                1 AS FTPdtStaVat,
                                1 AS FTPdtStaActive,
                                1 AS FTPdtStaAlwReturn,
                                1 AS FTPdtStaAlwDis,
                                1 AS FTPdtStaVatBuy,
                                1 AS FTPdtStaAlwReCalOpt,
                                1 AS FTPdtStaCsm,
                                1 AS FTPdtPoint,
                                1 AS FTPdtForSystem,
                                1 AS FTPdtStkControl,
                                1 AS FTPdtType,
                                1 AS FTPdtSaleType,
                                1 AS FTPdtSetOrSN,
                                2 AS FTPdtStaSetPri,
                                '$dDateStart' AS FDPdtSaleStart,
                                '$dDateStop' AS FDPdtSaleStop,
                                1 AS FCPdtMin,
                                1 AS FCPdtMax,
                                (SELECT TOP 1 FTVatCode FROM TCNMComp) AS FTVatCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPDT'
                            AND IMP.FTTmpStatus       = '1' ";
                $this->db->query($tSQL);
            }

            //เพิ่มข้อมูลลงตาราง TCNMPDT_L
            $tSQL   = " UPDATE
                            TCNMPDT_L
                        SET
                            TCNMPDT_L.FTPdtName     = TCNTImpMasTmp.FTPdtName,
                            TCNMPDT_L.FTPdtNameABB  = TCNTImpMasTmp.FTPdtNameABB
                        FROM
                            TCNMPDT_L
                        INNER JOIN
                            TCNTImpMasTmp
                        ON
                            TCNMPDT_L.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                        WHERE
                            TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                        AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                        AND TCNTImpMasTmp.FTTmpStatus = '1' ";
            $this->db->query($tSQL);
            if($this->db->affected_rows() == 0){
                $tSQL   = " INSERT INTO TCNMPDT_L (FTPdtCode,FNLngID,FTPdtName,FTPdtNameABB,FTPdtRmk)
                            SELECT DISTINCT
                                IMP.FTPdtCode,
                                $nLngID,
                                IMP.FTPdtName,
                                IMP.FTPdtNameABB,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPDT'
                            AND IMP.FTTmpStatus       = '1' ";
                $this->db->query($tSQL);
            }

            //เพิ่มข้อมูลลงตาราง TCNMPDTPackSize
            $tSQL = "UPDATE
                        TCNMPDTPackSize
                    SET
                        TCNMPDTPackSize.FCPdtUnitFact = A.FCPdtUnitFact
                    FROM
                        TCNMPDTPackSize
                    INNER JOIN
                            ( SELECT DISTINCT 
                                    TMP.FTPdtCode,
                                    TMP.FTPunCode,
                                    TMP.FCPdtUnitFact,
                                    TMP.FTSessionID
                            FROM TCNTImpMasTmp TMP
                            LEFT JOIN TCNMPDTPackSize SIZ ON SIZ.FTPdtCode = TMP.FTPdtCode AND SIZ.FTPunCode = TMP.FTPunCode
                            WHERE TMP.FTTmpTableKey = 'TCNMPdt' AND TMP.FTTmpStatus = '1' AND TMP.FTSessionID = '$tSessionID'
                            AND ISNULL(SIZ.FTPunCode,'') = ISNULL(TMP.FTPunCode,'') 
                        ) AS A ON TCNMPDTPackSize.FTPdtCode = A.FTPdtCode AND TCNMPDTPackSize.FTPunCode = A.FTPunCode";
            $this->db->query($tSQL);       

            $tSQL   = " INSERT INTO TCNMPDTPackSize (FTPdtCode,FTPunCode,FCPdtUnitFact,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT DISTINCT 
                            TMP.FTPdtCode,
                            TMP.FTPunCode,
                            TMP.FCPdtUnitFact,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy' 
                        FROM TCNTImpMasTmp TMP
                        LEFT JOIN TCNMPDTPackSize SIZ ON SIZ.FTPdtCode = TMP.FTPdtCode AND SIZ.FTPunCode = TMP.FTPunCode AND SIZ.FCPdtUnitFact = TMP.FCPdtUnitFact
                        WHERE TMP.FTTmpTableKey = 'TCNMPdt' AND TMP.FTTmpStatus = '1' AND TMP.FTSessionID = '$tSessionID'
                        AND ISNULL(SIZ.FTPunCode,'') != ISNULL(TMP.FTPunCode,'') ";
            $this->db->query($tSQL);
            
            //เพิ่มข้อมูลลงตาราง TCNMPdtBar
            $tSQL   = " INSERT INTO TCNMPdtBar (FTPdtCode,FTBarCode,FTPunCode,FTBarStaUse,FTBarStaAlwSale,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FNBarRefSeq)
                        SELECT 
                            IMP.FTPdtCode,
                            IMP.FTBarCode,
                            IMP.FTPunCode,
                            1 AS FTBarStaUse,
                            1 AS FTBarStaAlwSale,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy',
                            '0'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPDT'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtSpcBch
            $tSQL   = " UPDATE
                                TCNMPdtSpcBch
                            SET
                                TCNMPdtSpcBch.FTAgnCode = TCNTImpMasTmp.FTAgnCode
                            FROM
                                TCNMPdtSpcBch
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPdtSpcBch.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtSpcBch'
                            AND TCNTImpMasTmp.FTTmpStatus = '1' ";
            $this->db->query($tSQL);
            if($this->db->affected_rows() == 0){       
                $tSQL   = " INSERT INTO TCNMPdtSpcBch (FTPdtCode,FTBchCode,FTMerCode,FTAgnCode,FTMgpCode,FCPdtMin,FTShpCode,FTPdtRmk)
                            SELECT DISTINCT
                                IMP.FTPdtCode,
                                IMP.FTBchCode,
                                IMP.FTMerCode,
                                IMP.FTAgnCode,
                                '',
                                0,
                                IMP.FTShpCode,
                                ''
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtSpcBch'
                            AND IMP.FTTmpStatus       = '1'
                        ";
                $this->db->query($tSQL);
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

    //อัพเดทรายการเดิม + ใช้รายการใหม่
    public function FSaMPDTImportMove2MasterAndReplaceOrInsert($paDataSearch){
        try{
            $tTypeCaseDuplicate = $paDataSearch['tTypeCaseDuplicate'];
            $nLngID             = $paDataSearch['nLangEdit'];
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $dDateStart         = $paDataSearch['dDateStart'];
            $dDateStop          = $paDataSearch['dDateStop'];
            
            if($tTypeCaseDuplicate == 2){ //อัพเดทรายการเดิม

                //อัพเดทตาราง TCNMPdtGrp_L
                $tSQL   = " UPDATE
                                TCNMPdtGrp_L
                            SET
                                TCNMPdtGrp_L.FTPgpName  = TCNTImpMasTmp.FTPgpName
                            FROM
                                TCNMPdtGrp_L WITH(NOLOCK)
                            INNER JOIN
                                TCNTImpMasTmp WITH(NOLOCK)
                            ON
                                TCNMPdtGrp_L.FTPgpChain = TCNTImpMasTmp.FTPgpChain
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtGrp'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQL);

                //อัพเดทตาราง TCNMPdtModel_L
                $tSQL   = " UPDATE
                                TCNMPdtModel_L
                            SET
                                TCNMPdtModel_L.FTPmoName  = TCNTImpMasTmp.FTPmoName
                            FROM
                                TCNMPdtModel_L WITH(NOLOCK)
                            INNER JOIN
                                TCNTImpMasTmp WITH(NOLOCK)
                            ON
                                TCNMPdtModel_L.FTPmoCode = TCNTImpMasTmp.FTPmoCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtModel'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQL);

                //อัพเดทตาราง TCNMPdtType_L
                $tSQL   = " UPDATE
                                TCNMPdtType_L
                            SET
                                TCNMPdtType_L.FTPtyName  = TCNTImpMasTmp.FTPtyName
                            FROM
                                TCNMPdtType_L WITH(NOLOCK)
                            INNER JOIN
                                TCNTImpMasTmp WITH(NOLOCK)
                            ON
                                TCNMPdtType_L.FTPtyCode = TCNTImpMasTmp.FTPtyCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtType'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQL);

                //อัพเดทตาราง TCNMPdtTouchGrp_L
                $tSQL   = " UPDATE
                                TCNMPdtTouchGrp_L
                            SET
                                TCNMPdtTouchGrp_L.FTTcgName  = TCNTImpMasTmp.FTTcgName
                            FROM
                                TCNMPdtTouchGrp_L WITH(NOLOCK)
                            INNER JOIN
                                TCNTImpMasTmp WITH(NOLOCK)
                            ON
                                TCNMPdtTouchGrp_L.FTTcgCode = TCNTImpMasTmp.FTTcgCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtTouchGrp'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPdtBrand_L
                $tSQL   = " UPDATE
                                TCNMPdtBrand_L
                            SET
                                TCNMPdtBrand_L.FTPbnName  = TCNTImpMasTmp.FTPbnName
                            FROM
                                TCNMPdtBrand_L WITH(NOLOCK)
                            INNER JOIN
                                TCNTImpMasTmp WITH(NOLOCK)
                            ON
                                TCNMPdtBrand_L.FTPbnCode = TCNTImpMasTmp.FTPbnCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtBrand'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPdtUnit_L
                $tSQL   = " UPDATE
                                TCNMPdtUnit_L
                            SET
                                TCNMPdtUnit_L.FTPunName  = TCNTImpMasTmp.FTPunName
                            FROM
                                TCNMPdtUnit_L WITH(NOLOCK)
                            INNER JOIN
                                TCNTImpMasTmp WITH(NOLOCK)
                            ON
                                TCNMPdtUnit_L.FTPunCode = TCNTImpMasTmp.FTPunCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtUnit'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPdt_L
                $tSQL = "   UPDATE TCNMPdt_L
                            SET 
                                TCNMPdt_L.FTPdtName     = A.FTPdtName, 
                                TCNMPdt_L.FTPdtNameABB  = A.FTPdtNameABB
                            FROM (
                                SELECT 
                                    ROW_NUMBER() OVER(PARTITION BY IMP.FTPdtCode ORDER BY IMP.FNTmpSeq DESC) as RowNum,
                                    IMP.FTPdtCode,
                                    IMP.FTPdtName,
                                    IMP.FTPdtNameABB
                                FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                                WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND IMP.FTTmpTableKey   = 'TCNMPDT'
                                AND IMP.FTTmpStatus     = '6' 
                            ) A
                            WHERE A.RowNum = '1'
                            AND TCNMPdt_L.FTPdtCode = A.FTPdtCode

                        ";
                $this->db->query($tSQL);

                // $tSQL   = " UPDATE
                //                 TCNMPDT_L
                //             SET
                //                 TCNMPDT_L.FTPdtName     = TCNTImpMasTmp.FTPdtName,
                //                 TCNMPDT_L.FTPdtNameABB  = TCNTImpMasTmp.FTPdtNameABB
                //             FROM
                //                 TCNMPDT_L
                //             INNER JOIN
                //                 TCNTImpMasTmp
                //             ON
                //                 TCNMPDT_L.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                //             WHERE
                //                 TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                //             AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                //             AND TCNTImpMasTmp.FTTmpStatus = '6' 
                // ";
                // $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPdtBar
                // $tSQL   = " UPDATE
                //                 TCNMPdtBar
                //             SET
                //                 TCNMPdtBar.FTBarCode     = TCNTImpMasTmp.FTBarCode,
                //                 TCNMPdtBar.FTPunCode     = TCNTImpMasTmp.FTPunCode
                //             FROM
                //                 TCNMPdtBar
                //             INNER JOIN
                //                 TCNTImpMasTmp
                //             ON
                //                 TCNMPdtBar.FTPdtCode = TCNTImpMasTmp.FTPdtCode AND
                //                 TCNMPdtBar.FTPunCode = TCNTImpMasTmp.FTPunCode
                //             WHERE
                //                 TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                //             AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                //             AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                // $this->db->query($tSQL);
                // if($this->db->affected_rows() == 0){

                //     $tSQLDelete = "DELETE FROM TCNMPdtBar WHERE FTPdtCode IN (
                //         SELECT FTPdtCode
                //         FROM TCNTImpMasTmp
                //         WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                //     )";
                //     $this->db->query($tSQLDelete);

                //     $tSQL   = " INSERT INTO TCNMPdtBar (FTPdtCode,FTBarCode,FTPunCode,FTBarStaUse,FTBarStaAlwSale,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FNBarRefSeq)
                //                 SELECT 
                //                     IMP.FTPdtCode,
                //                     IMP.FTBarCode,
                //                     IMP.FTPunCode,
                //                     1 AS FTBarStaUse,
                //                     1 AS FTBarStaAlwSale,
                //                     '$dDateOn',
                //                     '$tUserBy',
                //                     '$dDateOn',
                //                     '$tUserBy',
                //                     '0'
                //                 FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                //                 WHERE IMP.FTSessionID     = '$tSessionID'
                //                 AND IMP.FTTmpTableKey     = 'TCNMPDT'
                //                 AND IMP.FTTmpStatus       = '6' ";
                //     $this->db->query($tSQL);
                // }

                //อัพเดทรายการ TCNMPDTPackSize
                $tSQL = "   UPDATE TCNMPDTPackSize
                            SET TCNMPDTPackSize.FCPdtUnitFact = A.FCPdtUnitFact
                            FROM TCNMPDTPackSize WITH(NOLOCK)
                            INNER JOIN ( SELECT DISTINCT 
                                            TMP.FTPdtCode,
                                            TMP.FTPunCode,
                                            TMP.FCPdtUnitFact,
                                            TMP.FTSessionID
                                        FROM TCNTImpMasTmp TMP WITH(NOLOCK)
                                        LEFT JOIN TCNMPDTPackSize SIZ WITH(NOLOCK) ON SIZ.FTPdtCode = TMP.FTPdtCode AND SIZ.FTPunCode = TMP.FTPunCode AND SIZ.FCPdtUnitFact <> TMP.FCPdtUnitFact /*เช็ครหัสหน่วย*/
                                        LEFT JOIN TCNMPDTPackSize PS2 WITH(NOLOCK) ON PS2.FTPdtCode = TMP.FTPdtCode AND PS2.FCPdtUnitFact = TMP.FCPdtUnitFact /*เช็คอัตราส่วน/หน่วย*/
                                        WHERE 1=1
                                        AND TMP.FTTmpTableKey = 'TCNMPdt' 
                                        AND TMP.FTTmpStatus = '6' 
                                        AND TMP.FTSessionID = '$tSessionID'
                                        AND ( ISNULL(SIZ.FTPunCode,'') = ISNULL(TMP.FTPunCode,'') AND PS2.FCPdtUnitFact IS NULL )
                            ) AS A ON TCNMPDTPackSize.FTPdtCode = A.FTPdtCode AND TCNMPDTPackSize.FTPunCode = A.FTPunCode
                        ";
                $this->db->query($tSQL);
                // echo $this->db->last_query();exit;

                //อัพเดทรายการ TCNMPdt
                $tSQL   = " UPDATE
                                TCNMPdt
                            SET
                                TCNMPdt.FTPdtStaVat = CASE WHEN ISNULL(TCNTImpMasTmp.FTPdtStaVat,'') != '' THEN TCNTImpMasTmp.FTPdtStaVat ELSE TCNMPdt.FTPdtStaVat END,
                                TCNMPdt.FTTcgCode   = CASE WHEN ISNULL(TCNMPdtTouchGrp.FTTcgCode,'') != '' THEN TCNMPdtTouchGrp.FTTcgCode ELSE TCNMPdt.FTTcgCode END,
                                TCNMPdt.FTPbnCode   = CASE WHEN ISNULL(TCNMPdtBrand.FTPbnCode,'') != '' THEN TCNMPdtBrand.FTPbnCode ELSE TCNMPdt.FTPbnCode END,
                                TCNMPdt.FTPtyCode   = CASE WHEN ISNULL(TCNMPdtType.FTPtyCode,'') != '' THEN TCNMPdtType.FTPtyCode ELSE TCNMPdt.FTPtyCode END,
                                TCNMPdt.FTPmoCode   = CASE WHEN ISNULL(TCNMPdtModel.FTPmoCode,'') != '' THEN TCNMPdtModel.FTPmoCode ELSE TCNMPdt.FTPmoCode END,
                                TCNMPdt.FTPgpChain  = CASE WHEN ISNULL(TCNMPdtGrp.FTPgpChain,'') != '' THEN TCNMPdtGrp.FTPgpChain ELSE TCNMPdt.FTPgpChain END
                            FROM TCNMPdt WITH(NOLOCK)
                            INNER JOIN TCNTImpMasTmp WITH(NOLOCK) ON TCNMPdt.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                            LEFT JOIN TCNMPdtType WITH(NOLOCK) ON TCNTImpMasTmp.FTPtyCode = TCNMPdtType.FTPtyCode
                            LEFT JOIN TCNMPdtModel WITH(NOLOCK) ON TCNTImpMasTmp.FTPmoCode = TCNMPdtModel.FTPmoCode
                            LEFT JOIN TCNMPdtGrp WITH(NOLOCK) ON TCNTImpMasTmp.FTPmoCode = TCNMPdtGrp.FTPgpChain
                            LEFT JOIN TCNMPdtBrand WITH(NOLOCK) ON TCNTImpMasTmp.FTPmoCode = TCNMPdtBrand.FTPbnCode
                            LEFT JOIN TCNMPdtTouchGrp WITH(NOLOCK) ON TCNTImpMasTmp.FTPmoCode = TCNMPdtTouchGrp.FTTcgCode
                            WHERE 1=1
                            AND TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdt'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                // $tSQL   = " UPDATE
                //                 TCNMPDTPackSize
                //             SET
                //                 TCNMPDTPackSize.FTPunCode     = TCNTImpMasTmp.FTPunCode,
                //                 TCNMPDTPackSize.FCPdtUnitFact = TCNTImpMasTmp.FCPdtUnitFact 
                //             FROM
                //                 TCNMPDTPackSize
                //             INNER JOIN
                //                 TCNTImpMasTmp
                //             ON
                //                 TCNMPDTPackSize.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                //             WHERE
                //                 TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                //             AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                //             AND TCNTImpMasTmp.FTTmpStatus = '6' 
                // ";
                // $this->db->query($tSQL);
                // if($this->db->affected_rows() == 0){
                //     $tSQLDelete = "DELETE FROM TCNMPDTPackSize WHERE FTPunCode IN (
                //         SELECT FTPunCode
                //         FROM TCNTImpMasTmp
                //         WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                //     )";
                //     $this->db->query($tSQLDelete);

                //     $tSQL   = " INSERT INTO TCNMPDTPackSize (FTPdtCode,FTPunCode,FCPdtUnitFact,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                //                 SELECT DISTINCT
                //                     IMP.FTPdtCode,
                //                     IMP.FTPunCode,
                //                     IMP.FCPdtUnitFact,
                //                     '$dDateOn',
                //                     '$tUserBy',
                //                     '$dDateOn',
                //                     '$tUserBy'
                //                 FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                //                 WHERE IMP.FTSessionID     = '$tSessionID'
                //                 AND IMP.FTTmpTableKey     = 'TCNMPDT'
                //                 AND IMP.FTTmpStatus       = '6' ";
                //     $this->db->query($tSQL);
                // }

                //อัพเดทรายการ TCNMPdtSpcBch
                // $tSQL   = " UPDATE
                //                 TCNMPdtSpcBch
                //             SET
                //                 TCNMPdtSpcBch.FTAgnCode = TCNTImpMasTmp.FTAgnCode
                //             FROM
                //                 TCNMPdtSpcBch
                //             INNER JOIN
                //                 TCNTImpMasTmp
                //             ON
                //                 TCNMPdtSpcBch.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                //             WHERE
                //                 TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                //             AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtSpcBch'
                //             AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                // $this->db->query($tSQL);

            }else if($tTypeCaseDuplicate == 1){ //ใช้รายการใหม่
                
                //-------------------------ลบข้อมูลก่อน 

                //ลบข้อมูลในตาราง TCNMPdtGrp_L
                $tSQLDelete = "DELETE FROM TCNMPdtGrp_L WHERE FTPgpChain IN (
                                    SELECT DISTINCT FTPgpChain
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtGrp'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtGrp
                $tSQLDelete = "DELETE FROM TCNMPdtGrp WHERE FTPgpChain IN (
                                    SELECT DISTINCT FTPgpChain
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtGrp'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtModel_L
                $tSQLDelete = "DELETE FROM TCNMPdtModel_L WHERE FTPmoCode IN (
                                    SELECT DISTINCT FTPmoCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtModel'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtModel
                $tSQLDelete = "DELETE FROM TCNMPdtModel WHERE FTPmoCode IN (
                                    SELECT DISTINCT FTPmoCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtModel'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtType_L
                $tSQLDelete = "DELETE FROM TCNMPdtType_L WHERE FTPtyCode IN (
                                    SELECT DISTINCT FTPtyCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtType'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtType
                $tSQLDelete = "DELETE FROM TCNMPdtType WHERE FTPtyCode IN (
                                    SELECT DISTINCT FTPtyCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtType'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtTouchGrp_L
                $tSQLDelete = "DELETE FROM TCNMPdtTouchGrp_L WHERE FTTcgCode IN (
                                    SELECT DISTINCT FTTcgCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtTouchGrp'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtTouchGrp
                $tSQLDelete = "DELETE FROM TCNMPdtTouchGrp WHERE FTTcgCode IN (
                                    SELECT DISTINCT FTTcgCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtTouchGrp'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtUnit_L
                $tSQLDelete = "DELETE FROM TCNMPdtUnit_L WHERE FTPunCode IN (
                                    SELECT DISTINCT FTPunCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtUnit'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtUnit
                $tSQLDelete = "DELETE FROM TCNMPdtUnit WHERE FTPunCode IN (
                                    SELECT DISTINCT FTPunCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtUnit'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtBrand_L
                $tSQLDelete = "DELETE FROM TCNMPdtBrand_L WHERE FTPbnCode IN (
                                    SELECT DISTINCT FTPbnCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtBrand'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtBrand
                $tSQLDelete = "DELETE FROM TCNMPdtBrand WHERE FTPbnCode IN (
                                    SELECT DISTINCT FTPbnCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtBrand'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPDT_L
                $tSQLDelete = "DELETE FROM TCNMPDT_L WHERE FTPdtCode IN (
                                    SELECT DISTINCT FTPdtCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPDT
                $tSQLDelete = "DELETE FROM TCNMPDT WHERE FTPdtCode IN (
                                    SELECT DISTINCT FTPdtCode
                                    FROM TCNTImpMasTmp WITH(NOLOCK)
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                                )";
                $this->db->query($tSQLDelete);

                 //ลบข้อมูลในตาราง TCNMPDTPackSize
                //  $tSQLDelete = "DELETE FROM TCNMPDTPackSize WHERE FTPunCode IN (
                //                     SELECT FTPunCode
                //                     FROM TCNTImpMasTmp
                //                     WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                //                 )";
                // $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtBar
                // $tSQLDelete = "DELETE FROM TCNMPdtBar WHERE FTPdtCode IN (
                //                     SELECT FTPdtCode
                //                     FROM TCNTImpMasTmp
                //                     WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                //                 )";
                // $this->db->query($tSQLDelete);

                //*********************** TCNMPdtGrp + TCNMPdtGrp_L ************************//
                //เพิ่มข้อมูลลงตาราง TCNMPdtGrp
                $tSQL   = " INSERT INTO TCNMPdtGrp ([FTPgpCode],[FTAgnCode],[FNPgpLevel],[FTPgpParent],[FTPgpChain],[FDLastUpdOn],[FTLastUpdBy],[FDCreateOn],[FTCreateBy])
                            SELECT 
                                IMP.FTPgpChain AS FTPgpCode,
                                IMP.FTAgnCode,
                                1 AS FNPgpLevel,
                                '' AS FTPgpParent,
                                IMP.FTPgpChain,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtGrp'
                            AND IMP.FTTmpStatus       = '1' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtGrp_L
                $tSQL   = " INSERT INTO TCNMPdtGrp_L ([FTPgpChain],[FNLngID],[FTPgpName],[FTPgpChainName],[FTPgpRmk])
                            SELECT 
                                IMP.FTPgpChain,
                                $nLngID AS FNLngID,
                                IMP.FTPgpName,
                                IMP.FTPgpName AS FTPgpChainName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtGrp'
                            AND IMP.FTTmpStatus       = '1' ";
                $this->db->query($tSQL);

                //*********************** TCNMPdtModel + TCNMPdtModel_L ************************//
                //เพิ่มข้อมูลลงตาราง TCNMPdtModel
                $tSQL   = " INSERT INTO TCNMPdtModel ([FTPmoCode],[FTAgnCode],[FDLastUpdOn],[FTLastUpdBy],[FDCreateOn],[FTCreateBy])
                            SELECT 
                                IMP.FTPmoCode,
                                IMP.FTAgnCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtModel'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtModel_L
                $tSQL   = " INSERT INTO TCNMPdtModel_L ([FTPmoCode],[FNLngID],[FTPmoName],[FTPmoRmk])
                            SELECT 
                                IMP.FTPmoCode,
                                $nLngID,
                                IMP.FTPmoName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtModel'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //*********************** TCNMPdtType + TCNMPdtType_L ************************//
                //เพิ่มข้อมูลลงตาราง TCNMPdtType
                $tSQL   = " INSERT INTO TCNMPdtType ([FTPtyCode],[FTAgnCode],[FDLastUpdOn],[FTLastUpdBy],[FDCreateOn],[FTCreateBy])
                            SELECT 
                                IMP.FTPtyCode,
                                IMP.FTAgnCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtType'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtType_L
                $tSQL   = " INSERT INTO TCNMPdtType_L ([FTPtyCode],[FNLngID],[FTPtyName],[FTPtyRmk])
                            SELECT 
                                IMP.FTPtyCode,
                                $nLngID,
                                IMP.FTPtyName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtType'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);
                    
                //*********************** TCNMPdtTouchGrp + TCNMPdtTouchGrp_L ************************//

                //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp
                $tSQL   = " INSERT INTO TCNMPdtTouchGrp (FTTcgCode,FTTcgStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTTcgCode,
                                1 AS FTTcgStaUse,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID       = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp_L
                $tSQL   = " INSERT INTO TCNMPdtTouchGrp_L (FTTcgCode,FNLngID,FTTcgName,FTTcgRmk)
                            SELECT 
                                IMP.FTTcgCode,
                                $nLngID,
                                IMP.FTTcgName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID       = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //*********************** TCNMPdtBrand + TCNMPdtBrand_L ************************//

                //เพิ่มข้อมูลลงตาราง TCNMPdtBrand
                $tSQL   = " INSERT INTO TCNMPdtBrand (FTPbnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTPbnCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtBrand_L
                $tSQL   = " INSERT INTO TCNMPdtBrand_L (FTPbnCode,FNLngID,FTPbnName,FTPbnRmk)
                            SELECT 
                                IMP.FTPbnCode,
                                $nLngID,
                                IMP.FTPbnName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //*********************** TCNMPdtUnit + TCNMPdtUnit_L ************************//

                //เพิ่มข้อมูลลงตาราง TCNMPdtUnit
                $tSQL   = " INSERT INTO TCNMPdtUnit (FTPunCode, FTAgnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTPunCode,
                                IMP.FTAgnCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtUnit_L
                $tSQL   = " INSERT INTO TCNMPdtUnit_L (FTPunCode,FNLngID,FTPunName)
                            SELECT 
                                IMP.FTPunCode,
                                $nLngID,
                                IMP.FTPunName
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //*********************** TCNMPDT + TCNMPDT_L + TCNMPDTPackSize + TCNMPdtBar ************************//
                //เพิ่มข้อมูลลงตาราง TCNMPDT
                $tSQL   = " INSERT INTO TCNMPdt (
                                FTPDTCode ,FTPdtStaVat ,FTPdtStaActive ,FTPdtStaAlwReturn,
                                FTPdtStaAlwDis ,FTPdtStaVatBuy ,FTPdtStaAlwReCalOpt ,FTPdtStaCsm ,FTPdtPoint ,FTPdtForSystem,
                                FTPdtStkControl ,FTPdtType , FTPdtSaleType ,FTPdtSetOrSN ,FTPdtStaSetPri ,FDPdtSaleStart,
                                FDPdtSaleStop ,FCPdtMin , FCPdtMax ,FTVatCode, FDLastUpdOn , FTLastUpdBy, FDCreateOn, FTCreateBy,
                                FTPbnCode,FTTcgCode,FTPtyCode,FTPmoCode,FTPgpChain
                            )
                            SELECT 
                                A.FTPDTCode,A.FTPdtStaVat,A.FTPdtStaActive,A.FTPdtStaAlwReturn,A.FTPdtStaAlwDis,A.FTPdtStaVatBuy,
                                A.FTPdtStaAlwReCalOpt,A.FTPdtStaCsm,A.FTPdtPoint,A.FTPdtForSystem,A.FTPdtStkControl,A.FTPdtType,
                                A.FTPdtSaleType,A.FTPdtSetOrSN,A.FTPdtStaSetPri,A.FDPdtSaleStart,A.FDPdtSaleStop,A.FCPdtMin,
                                A.FCPdtMax,A.FTVatCode,A.FDLastUpdOn,A.FTLastUpdBy,A.FDCreateOn,A.FTCreateBy,A.FTPbnCode,
                                A.FTTcgCode,A.FTPtyCode,A.FTPmoCode,A.FTPgpChain
                            FROM (
                                SELECT 
                                    ROW_NUMBER() OVER(PARTITION BY IMP.FTPdtCode ORDER BY IMP.FNTmpSeq ASC) as RowNum,
                                    IMP.FTPDTCode,
                                    CASE WHEN IMP.FTPdtStaVat = '2' THEN '2' ELSE '1' END AS FTPdtStaVat,
                                    1 AS FTPdtStaActive,
                                    1 AS FTPdtStaAlwReturn,
                                    1 AS FTPdtStaAlwDis,
                                    1 AS FTPdtStaVatBuy,
                                    1 AS FTPdtStaAlwReCalOpt,
                                    1 AS FTPdtStaCsm,
                                    1 AS FTPdtPoint,
                                    1 AS FTPdtForSystem,
                                    1 AS FTPdtStkControl,
                                    1 AS FTPdtType,
                                    1 AS FTPdtSaleType,
                                    1 AS FTPdtSetOrSN,
                                    2 AS FTPdtStaSetPri,
                                    '$dDateStart' AS FDPdtSaleStart,
                                    '$dDateStop' AS FDPdtSaleStop,
                                    1 AS FCPdtMin,
                                    1 AS FCPdtMax,
                                    (SELECT TOP 1 FTVatCode FROM TCNMComp) AS FTVatCode,
                                    '$dDateOn' AS FDLastUpdOn,
                                    '$tUserBy' AS FTLastUpdBy,
                                    '$dDateOn' AS FDCreateOn,
                                    '$tUserBy' AS FTCreateBy,
                                    ISNULL(PBN.FTPbnCode,'') AS FTPbnCode,
                                    ISNULL(TCG.FTTcgCode,'') AS FTTcgCode,
                                    ISNULL(PTY.FTPtyCode,'') AS FTPtyCode,
                                    ISNULL(PMO.FTPmoCode,'') AS FTPmoCode,
                                    ISNULL(PGP.FTPgpChain,'') AS FTPgpChain
                                FROM TCNTImpMasTmp          IMP WITH(NOLOCK)
                                LEFT JOIN TCNMPdtBrand      PBN WITH(NOLOCK) ON IMP.FTPbnCode = PBN.FTPbnCode AND IMP.FTAgnCode = PBN.FTAgnCode
                                LEFT JOIN TCNMPdtTouchGrp   TCG WITH(NOLOCK) ON IMP.FTTcgCode = TCG.FTTcgCode AND IMP.FTAgnCode = TCG.FTAgnCode
                                LEFT JOIN TCNMPdtType       PTY WITH(NOLOCK) ON IMP.FTPtyCode = PTY.FTPtyCode AND IMP.FTAgnCode = PTY.FTAgnCode
                                LEFT JOIN TCNMPdtModel      PMO WITH(NOLOCK) ON IMP.FTPmoCode = PMO.FTPmoCode AND IMP.FTAgnCode = PMO.FTAgnCode
                                LEFT JOIN TCNMPdtGrp        PGP WITH(NOLOCK) ON IMP.FTPgpChain = PGP.FTPgpChain AND IMP.FTAgnCode = PGP.FTAgnCode
                                WHERE IMP.FTSessionID     = '$tSessionID'
                                AND IMP.FTTmpTableKey     = 'TCNMPDT'
                                AND IMP.FTTmpStatus       = '6' 
                            ) A
                            WHERE A.RowNum = '1'
                        ";
                $this->db->query($tSQL);
                // $tSQL   = " INSERT INTO TCNMPdt (
                //                 FTPDTCode ,FTPdtStaVat ,FTPdtStaActive ,FTPdtStaAlwReturn,
                //                 FTPdtStaAlwDis ,FTPdtStaVatBuy ,FTPdtStaAlwReCalOpt ,FTPdtStaCsm ,FTPdtPoint ,FTPdtForSystem,
                //                 FTPdtStkControl ,FTPdtType , FTPdtSaleType ,FTPdtSetOrSN ,FTPdtStaSetPri ,FDPdtSaleStart,
                //                 FDPdtSaleStop ,FCPdtMin , FCPdtMax ,FTVatCode, FDLastUpdOn , FTLastUpdBy, FDCreateOn, FTCreateBy,
                //                 FTPbnCode,FTTcgCode,FTPtyCode,FTPmoCode,FTPgpChain
                //             )
                //             SELECT DISTINCT
                //                 IMP.FTPDTCode,
                //                 CASE WHEN IMP.FTPdtStaVat = '2' THEN '2' ELSE '1' END AS FTPdtStaVat,
                //                 1 AS FTPdtStaActive,
                //                 1 AS FTPdtStaAlwReturn,
                //                 1 AS FTPdtStaAlwDis,
                //                 1 AS FTPdtStaVatBuy,
                //                 1 AS FTPdtStaAlwReCalOpt,
                //                 1 AS FTPdtStaCsm,
                //                 1 AS FTPdtPoint,
                //                 1 AS FTPdtForSystem,
                //                 1 AS FTPdtStkControl,
                //                 1 AS FTPdtType,
                //                 1 AS FTPdtSaleType,
                //                 1 AS FTPdtSetOrSN,
                //                 2 AS FTPdtStaSetPri,
                //                 '$dDateStart' AS FDPdtSaleStart,
                //                 '$dDateStop' AS FDPdtSaleStop,
                //                 1 AS FCPdtMin,
                //                 1 AS FCPdtMax,
                //                 (SELECT TOP 1 FTVatCode FROM TCNMComp) AS FTVatCode,
                //                 '$dDateOn',
                //                 '$tUserBy',
                //                 '$dDateOn',
                //                 '$tUserBy',
                //                 ISNULL(PBN.FTPbnCode,''),
                //                 ISNULL(TCG.FTTcgCode,''),
                //                 ISNULL(PTY.FTPtyCode,''),
                //                 ISNULL(PMO.FTPmoCode,''),
                //                 ISNULL(PGP.FTPgpChain,'')
                //             FROM TCNTImpMasTmp          IMP WITH(NOLOCK)
                //             LEFT JOIN TCNMPdtBrand      PBN WITH(NOLOCK) ON IMP.FTPbnCode = PBN.FTPbnCode AND IMP.FTAgnCode = PBN.FTAgnCode
                //             LEFT JOIN TCNMPdtTouchGrp   TCG WITH(NOLOCK) ON IMP.FTTcgCode = TCG.FTTcgCode AND IMP.FTAgnCode = TCG.FTAgnCode
                //             LEFT JOIN TCNMPdtType       PTY WITH(NOLOCK) ON IMP.FTPtyCode = PTY.FTPtyCode AND IMP.FTAgnCode = PTY.FTAgnCode
                //             LEFT JOIN TCNMPdtModel      PMO WITH(NOLOCK) ON IMP.FTPmoCode = PMO.FTPmoCode AND IMP.FTAgnCode = PMO.FTAgnCode
                //             LEFT JOIN TCNMPdtGrp        PGP WITH(NOLOCK) ON IMP.FTPgpChain = PGP.FTPgpChain AND IMP.FTAgnCode = PGP.FTAgnCode
                //             WHERE IMP.FTSessionID     = '$tSessionID'
                //             AND IMP.FTTmpTableKey     = 'TCNMPDT'
                //             AND IMP.FTTmpStatus       = '6' ";
                // $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPDT_L
                $tSQL   = " INSERT INTO TCNMPDT_L (FTPdtCode,FNLngID,FTPdtName,FTPdtNameABB,FTPdtRmk)
                            SELECT 
                                A.FTPdtCode,
                                $nLngID,
                                A.FTPdtName,
                                A.FTPdtNameABB,
                                A.FTPdtRmk
                            FROM (
                                SELECT 
                                    ROW_NUMBER() OVER(PARTITION BY IMP.FTPdtCode ORDER BY IMP.FNTmpSeq DESC) as RowNum,
                                    IMP.FTPdtCode,
                                    IMP.FTPdtName,
                                    IMP.FTPdtNameABB,
                                    'IMPORT' AS FTPdtRmk
                                FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                                WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND IMP.FTTmpTableKey   = 'TCNMPDT'
                                AND IMP.FTTmpStatus     = '6' 
                            ) A
                            WHERE A.RowNum = '1' 
                          ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPDTPackSize
                // $tSQL   = " INSERT INTO TCNMPDTPackSize (FTPdtCode,FTPunCode,FCPdtUnitFact,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                //             SELECT 
                //                 IMP.FTPdtCode,
                //                 IMP.FTPunCode,
                //                 IMP.FCPdtUnitFact,
                //                 '$dDateOn',
                //                 '$tUserBy',
                //                 '$dDateOn',
                //                 '$tUserBy'
                //             FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                //             WHERE IMP.FTSessionID     = '$tSessionID'
                //             AND IMP.FTTmpTableKey     = 'TCNMPDT'
                //             AND IMP.FTTmpStatus       = '6' ";
                // $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtBar
                // $tSQL   = " INSERT INTO TCNMPdtBar (FTPdtCode,FTBarCode,FTPunCode,FTBarStaUse,FTBarStaAlwSale,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                //             SELECT 
                //                 IMP.FTPdtCode,
                //                 IMP.FTBarCode,
                //                 IMP.FTPunCode,
                //                 1 AS FTBarStaUse,
                //                 1 AS FTBarStaAlwSale,
                //                 '$dDateOn',
                //                 '$tUserBy',
                //                 '$dDateOn',
                //                 '$tUserBy'
                //             FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                //             WHERE IMP.FTSessionID     = '$tSessionID'
                //             AND IMP.FTTmpTableKey     = 'TCNMPDT'
                //             AND IMP.FTTmpStatus       = '6' ";
                // $this->db->query($tSQL);
            }
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //หาจำนวน record ทั้งหมด
    public function FSaMPDTGetTempDataAtAll($ptTableName){
        try{
            $tSesSessionID = $this->session->userdata("tSesSessionID");
            $tSQL   = "SELECT TOP 1
                        (SELECT COUNT(FTTmpTableKey) AS TYPESIX FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        AND IMP.FTTmpStatus       = '6') AS TYPESIX ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        AND IMP.FTTmpStatus       = '1') AS TYPEONE ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        ) AS ITEMALL
                    FROM TCNTImpMasTmp ";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }catch(Exception $Error) {
            return $Error;
        }
    }

    
    public function FSaMPDTImportMove2MasterNew($paDataSearch){
        try{
            $nLngID             = $paDataSearch['nLangEdit'];
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $dDateStart         = $paDataSearch['dDateStart'];
            $dDateStop          = $paDataSearch['dDateStop'];
            $tTypeCaseDuplicate = $paDataSearch['tTypeCaseDuplicate'];

            //*********************** TCNMPdtGrp + TCNMPdtGrp_L ************************//
            //เพิ่มข้อมูลลงตาราง TCNMPdtGrp
            $tSQL   = " INSERT INTO TCNMPdtGrp ([FTPgpCode],[FTAgnCode],[FNPgpLevel],[FTPgpParent],[FTPgpChain],[FDLastUpdOn],[FTLastUpdBy],[FDCreateOn],[FTCreateBy])
                        SELECT 
                            IMP.FTPgpChain AS FTPgpCode,
                            IMP.FTAgnCode,
                            1 AS FNPgpLevel,
                            '' AS FTPgpParent,
                            IMP.FTPgpChain,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);
            
            //เพิ่มข้อมูลลงตาราง TCNMPdtGrp_L
            $tSQL   = " INSERT INTO TCNMPdtGrp_L ([FTPgpChain],[FNLngID],[FTPgpName],[FTPgpChainName],[FTPgpRmk])
                        SELECT 
                            IMP.FTPgpChain,
                            $nLngID AS FNLngID,
                            IMP.FTPgpName,
                            IMP.FTPgpName AS FTPgpChainName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtModel + TCNMPdtModel_L ************************//
            //เพิ่มข้อมูลลงตาราง TCNMPdtModel
            $tSQL   = " INSERT INTO TCNMPdtModel ([FTPmoCode],[FTAgnCode],[FDLastUpdOn],[FTLastUpdBy],[FDCreateOn],[FTCreateBy])
                        SELECT 
                            IMP.FTPmoCode,
                            IMP.FTAgnCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtModel'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);
            
            //เพิ่มข้อมูลลงตาราง TCNMPdtModel_L
            $tSQL   = " INSERT INTO TCNMPdtModel_L ([FTPmoCode],[FNLngID],[FTPmoName],[FTPmoRmk])
                        SELECT 
                            IMP.FTPmoCode,
                            $nLngID,
                            IMP.FTPmoName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtModel'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtType + TCNMPdtType_L ************************//
            //เพิ่มข้อมูลลงตาราง TCNMPdtType
            $tSQL   = " INSERT INTO TCNMPdtType ([FTPtyCode],[FTAgnCode],[FDLastUpdOn],[FTLastUpdBy],[FDCreateOn],[FTCreateBy])
                        SELECT 
                            IMP.FTPtyCode,
                            IMP.FTAgnCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtType'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtType_L
            $tSQL   = " INSERT INTO TCNMPdtType_L ([FTPtyCode],[FNLngID],[FTPtyName],[FTPtyRmk])
                        SELECT 
                            IMP.FTPtyCode,
                            $nLngID,
                            IMP.FTPtyName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtType'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtTouchGrp + TCNMPdtTouchGrp_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp
            $tSQL   = " INSERT INTO TCNMPdtTouchGrp (FTTcgCode,FTAgnCode,FTTcgStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTTcgCode,
                            IMP.FTAgnCode,
                            1 AS FTTcgStaUse,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp_L
            $tSQL   = " INSERT INTO TCNMPdtTouchGrp_L (FTTcgCode,FNLngID,FTTcgName,FTTcgRmk)
                        SELECT 
                            IMP.FTTcgCode,
                            $nLngID,
                            IMP.FTTcgName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtBrand + TCNMPdtBrand_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtBrand
            $tSQL   = " INSERT INTO TCNMPdtBrand (FTPbnCode,FTAgnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPbnCode,
                            IMP.FTAgnCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtBrand_L
            $tSQL   = " INSERT INTO TCNMPdtBrand_L (FTPbnCode,FNLngID,FTPbnName,FTPbnRmk)
                        SELECT 
                            IMP.FTPbnCode,
                            $nLngID,
                            IMP.FTPbnName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtUnit + TCNMPdtUnit_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtUnit
            $tSQL   = " INSERT INTO TCNMPdtUnit (FTPunCode,FTAgnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPunCode,
                            IMP.FTAgnCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtUnit_L
            $tSQL   = " INSERT INTO TCNMPdtUnit_L (FTPunCode,FNLngID,FTPunName)
                        SELECT 
                            IMP.FTPunCode,
                            $nLngID,
                            IMP.FTPunName
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);
        
            //*********************** TCNMPDT + TCNMPDT_L + TCNMPDTPackSize + TCNMPdtBar ************************//
            //เพิ่มข้อมูลลงตาราง TCNMPDT
            // $tSQL   = " UPDATE
            //                 TCNMPDT
            //             SET
            //                 TCNMPDT.FTTcgCode       = TCNTImpMasTmp.FTTcgCode,
            //                 TCNMPDT.FTPbnCode       = TCNTImpMasTmp.FTPbnCode
            //             FROM
            //                 TCNMPDT
            //             INNER JOIN
            //                 TCNTImpMasTmp
            //             ON
            //                 TCNMPDT.FTPdtCode = TCNTImpMasTmp.FTPdtCode
            //             WHERE
            //                 TCNTImpMasTmp.FTSessionID = '$tSessionID' 
            //             AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
            //             AND TCNTImpMasTmp.FTTmpStatus = '1' ";

            // $tSQL = "   SELECT 
            //                 TCNMPdt.FTPdtCode 
            //             FROM TCNMPdt WITH(NOLOCK)
            //             INNER JOIN TCNTImpMasTmp WITH(NOLOCK) ON TCNMPdt.FTPdtCode = TCNTImpMasTmp.FTPdtCode
            //             WHERE 1=1
            //                 AND TCNTImpMasTmp.FTSessionID = '$tSessionID'
            //                 AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
            //                 AND TCNTImpMasTmp.FTTmpStatus IN ('1','6')
            //         ";

            // $oQueryMasterPDT = $this->db->query($tSQL);
            // if( $oQueryMasterPDT->num_rows() > 0 ){

            //อัพเดทรายการ TCNMPDT_L
            // if( $tTypeCaseDuplicate == '2' ){
            //     $tSQL   = " UPDATE
            //                     TCNMPdt_L
            //                 SET
            //                     TCNMPdt_L.FTPdtName     = TCNTImpMasTmp.FTPdtName,
            //                     TCNMPdt_L.FTPdtNameABB  = TCNTImpMasTmp.FTPdtNameABB
            //                 FROM
            //                     TCNMPdt_L WITH(NOLOCK)
            //                 INNER JOIN
            //                     TCNTImpMasTmp WITH(NOLOCK)
            //                 ON
            //                     TCNMPdt_L.FTPdtCode = TCNTImpMasTmp.FTPdtCode AND ( TCNMPdt_L.FTPdtName != TCNTImpMasTmp.FTPdtName OR TCNMPdt_L.FTPdtNameABB != TCNTImpMasTmp.FTPdtNameABB )
            //                 WHERE
            //                     TCNTImpMasTmp.FTSessionID = '$tSessionID' 
            //                 AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
            //                 AND TCNTImpMasTmp.FTTmpStatus = '6' 
            //     ";
            //     $this->db->query($tSQL);
            // }
            
            //เพิ่มรายการ TCNMPdt
            $tSQL   = " INSERT INTO TCNMPdt (
                            FTPDTCode ,FTPdtStaVat ,FTPdtStaActive ,FTPdtStaAlwReturn,
                            FTPdtStaAlwDis ,FTPdtStaVatBuy ,FTPdtStaAlwReCalOpt ,FTPdtStaCsm ,FTPdtPoint ,FTPdtForSystem,
                            FTPdtStkControl ,FTPdtType , FTPdtSaleType ,FTPdtSetOrSN ,FTPdtStaSetPri ,FDPdtSaleStart,
                            FDPdtSaleStop ,FCPdtMin , FCPdtMax ,FTVatCode, FDLastUpdOn , FTLastUpdBy, FDCreateOn, FTCreateBy,
                            FTPbnCode,FTTcgCode,FTPtyCode,FTPmoCode,FTPgpChain
                        )
                        SELECT 
                            A.FTPDTCode,A.FTPdtStaVat,A.FTPdtStaActive,A.FTPdtStaAlwReturn,A.FTPdtStaAlwDis,A.FTPdtStaVatBuy,
                            A.FTPdtStaAlwReCalOpt,A.FTPdtStaCsm,A.FTPdtPoint,A.FTPdtForSystem,A.FTPdtStkControl,A.FTPdtType,
                            A.FTPdtSaleType,A.FTPdtSetOrSN,A.FTPdtStaSetPri,A.FDPdtSaleStart,A.FDPdtSaleStop,A.FCPdtMin,
                            A.FCPdtMax,A.FTVatCode,A.FDLastUpdOn,A.FTLastUpdBy,A.FDCreateOn,A.FTCreateBy,A.FTPbnCode,
                            A.FTTcgCode,A.FTPtyCode,A.FTPmoCode,A.FTPgpChain
                        FROM (
                            SELECT 
                                ROW_NUMBER() OVER(PARTITION BY IMP.FTPdtCode ORDER BY IMP.FNTmpSeq ASC) as RowNum,
                                IMP.FTPDTCode,
                                CASE WHEN IMP.FTPdtStaVat = '2' THEN '2' ELSE '1' END AS FTPdtStaVat,
                                1 AS FTPdtStaActive,
                                1 AS FTPdtStaAlwReturn,
                                1 AS FTPdtStaAlwDis,
                                1 AS FTPdtStaVatBuy,
                                1 AS FTPdtStaAlwReCalOpt,
                                1 AS FTPdtStaCsm,
                                1 AS FTPdtPoint,
                                1 AS FTPdtForSystem,
                                1 AS FTPdtStkControl,
                                1 AS FTPdtType,
                                1 AS FTPdtSaleType,
                                1 AS FTPdtSetOrSN,
                                2 AS FTPdtStaSetPri,
                                '$dDateStart' AS FDPdtSaleStart,
                                '$dDateStop' AS FDPdtSaleStop,
                                1 AS FCPdtMin,
                                1 AS FCPdtMax,
                                (SELECT TOP 1 FTVatCode FROM TCNMComp) AS FTVatCode,
                                '$dDateOn' AS FDLastUpdOn,
                                '$tUserBy' AS FTLastUpdBy,
                                '$dDateOn' AS FDCreateOn,
                                '$tUserBy' AS FTCreateBy,
                                ISNULL(PBN.FTPbnCode,'') AS FTPbnCode,
                                ISNULL(TCG.FTTcgCode,'') AS FTTcgCode,
                                ISNULL(PTY.FTPtyCode,'') AS FTPtyCode,
                                ISNULL(PMO.FTPmoCode,'') AS FTPmoCode,
                                ISNULL(PGP.FTPgpChain,'') AS FTPgpChain
                            FROM TCNTImpMasTmp          IMP WITH(NOLOCK)
                            LEFT JOIN TCNMPdtBrand      PBN WITH(NOLOCK) ON IMP.FTPbnCode = PBN.FTPbnCode AND IMP.FTAgnCode = PBN.FTAgnCode
                            LEFT JOIN TCNMPdtTouchGrp   TCG WITH(NOLOCK) ON IMP.FTTcgCode = TCG.FTTcgCode AND IMP.FTAgnCode = TCG.FTAgnCode
                            LEFT JOIN TCNMPdtType       PTY WITH(NOLOCK) ON IMP.FTPtyCode = PTY.FTPtyCode AND IMP.FTAgnCode = PTY.FTAgnCode
                            LEFT JOIN TCNMPdtModel      PMO WITH(NOLOCK) ON IMP.FTPmoCode = PMO.FTPmoCode AND IMP.FTAgnCode = PMO.FTAgnCode
                            LEFT JOIN TCNMPdtGrp        PGP WITH(NOLOCK) ON IMP.FTPgpChain = PGP.FTPgpChain AND IMP.FTAgnCode = PGP.FTAgnCode
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPDT'
                            AND IMP.FTTmpStatus       = '1' 
                        ) A
                        WHERE A.RowNum = '1'
                      ";
            $this->db->query($tSQL);
            // echo $this->db->last_query();exit;
            

            //เพิ่มข้อมูลลงตาราง TCNMPDT_L
            // $tSQL   = " UPDATE
            //                 TCNMPDT_L
            //             SET
            //                 TCNMPDT_L.FTPdtName     = TCNTImpMasTmp.FTPdtName,
            //                 TCNMPDT_L.FTPdtNameABB  = TCNTImpMasTmp.FTPdtNameABB
            //             FROM
            //                 TCNMPDT_L
            //             INNER JOIN
            //                 TCNTImpMasTmp
            //             ON
            //                 TCNMPDT_L.FTPdtCode = TCNTImpMasTmp.FTPdtCode
            //             WHERE
            //                 TCNTImpMasTmp.FTSessionID = '$tSessionID' 
            //             AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
            //             AND TCNTImpMasTmp.FTTmpStatus = '1' ";
            // $this->db->query($tSQL);
            // if($this->db->affected_rows() == 0){
                $tSQL   = " INSERT INTO TCNMPdt_L (FTPdtCode,FNLngID,FTPdtName,FTPdtNameABB,FTPdtRmk)
                            SELECT 
                                A.FTPdtCode,
                                $nLngID,
                                A.FTPdtName,
                                A.FTPdtNameABB,
                                A.FTPdtRmk
                            FROM (
                                SELECT 
                                    ROW_NUMBER() OVER(PARTITION BY IMP.FTPdtCode ORDER BY IMP.FNTmpSeq DESC) as RowNum,
                                    IMP.FTPdtCode,
                                    IMP.FTPdtName,
                                    IMP.FTPdtNameABB,
                                    'IMPORT' AS FTPdtRmk
                                FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                                WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND IMP.FTTmpTableKey   = 'TCNMPDT'
                                AND IMP.FTTmpStatus     = '1' 
                            ) A
                            WHERE A.RowNum = '1' 
                          ";
                $this->db->query($tSQL);
            // }

           
            // อัพเดทตาราง TCNMPDTPackSize
            // if( $tTypeCaseDuplicate == '2' ){
            //     $tSQL = "   UPDATE TCNMPDTPackSize
            //                 SET TCNMPDTPackSize.FCPdtUnitFact = A.FCPdtUnitFact
            //                 FROM TCNMPDTPackSize
            //                 INNER JOIN ( SELECT DISTINCT 
            //                                 TMP.FTPdtCode,
            //                                 TMP.FTPunCode,
            //                                 TMP.FCPdtUnitFact,
            //                                 TMP.FTSessionID
            //                             FROM TCNTImpMasTmp TMP WITH(NOLOCK)
            //                             LEFT JOIN TCNMPDTPackSize SIZ WITH(NOLOCK) ON SIZ.FTPdtCode = TMP.FTPdtCode AND SIZ.FTPunCode = TMP.FTPunCode AND SIZ.FCPdtUnitFact <> TMP.FCPdtUnitFact /*เช็ครหัสหน่วย*/
            //                             LEFT JOIN TCNMPDTPackSize PS2 WITH(NOLOCK) ON PS2.FTPdtCode = TMP.FTPdtCode AND PS2.FCPdtUnitFact = TMP.FCPdtUnitFact /*เช็คอัตราส่วน/หน่วย*/
            //                             WHERE 1=1
            //                             AND TMP.FTTmpTableKey = 'TCNMPdt' 
            //                             AND TMP.FTTmpStatus = '6' 
            //                             AND TMP.FTSessionID = '$tSessionID'
            //                             AND ( ISNULL(SIZ.FTPunCode,'') = ISNULL(TMP.FTPunCode,'') AND PS2.FCPdtUnitFact IS NULL )
            //                 ) AS A ON TCNMPDTPackSize.FTPdtCode = A.FTPdtCode AND TCNMPDTPackSize.FTPunCode = A.FTPunCode
            //             ";
            //     $this->db->query($tSQL);
            // }
            
            // เพิ่มตาราง TCNMPDTPackSize
            // - ถ้าไม่มีหน่วยอยู่จริงใน Master จะไม่ Insert ลง PackSize
            // - ถ้า อัตราส่วน/หน่วย ซ้ำ จะไม่ Insert ลง PackSize
            $tSQL   = " INSERT INTO TCNMPDTPackSize (FTPdtCode,FTPunCode,FCPdtUnitFact,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT DISTINCT 
                            TMP.FTPdtCode,
                            TMP.FTPunCode,
                            TMP.FCPdtUnitFact,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy' 
                        FROM TCNTImpMasTmp          TMP WITH(NOLOCK)
                        LEFT JOIN TCNMPdtPackSize   SIZ WITH(NOLOCK) ON SIZ.FTPdtCode = TMP.FTPdtCode AND SIZ.FTPunCode = TMP.FTPunCode
                        LEFT JOIN TCNMPDTPackSize   PS2 WITH(NOLOCK) ON PS2.FTPdtCode = TMP.FTPdtCode
                        LEFT JOIN TCNMPdtUnit       PUN WITH(NOLOCK) ON TMP.FTPunCode = PUN.FTPunCode AND TMP.FTAgnCode = PUN.FTAgnCode
                        WHERE 1=1
                        AND TMP.FTTmpTableKey   = 'TCNMPdt' 
                        AND TMP.FTSessionID     = '$tSessionID'
                        AND TMP.FTTmpStatus     IN ('1','6')
                        AND ISNULL(SIZ.FTPunCode,'') != ISNULL(TMP.FTPunCode,'')
                        AND PUN.FTPunCode       IS NOT NULL
                        AND TMP.FCPdtUnitFact != ISNULL(PS2.FCPdtUnitFact,0)
                      ";
            $this->db->query($tSQL);
            // echo $this->db->last_query();exit;
            
        
            // เพิ่มข้อมูลลงตาราง TCNMPdtBar
            // - ถ้าไม่มีหน่วยใน PackSize จะไม่ Insert BarCode
            $tSQL   = " INSERT INTO TCNMPdtBar (FTPdtCode,FTBarCode,FTPunCode,FTBarStaUse,FTBarStaAlwSale,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FNBarRefSeq)
                        SELECT DISTINCT
                            IMP.FTPdtCode,
                            IMP.FTBarCode,
                            IMP.FTPunCode,
                            1 AS FTBarStaUse,
                            1 AS FTBarStaAlwSale,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy',
                            '0'
                        FROM TCNTImpMasTmp          IMP WITH(NOLOCK)
                        LEFT JOIN TCNMPdtBar        BAR WITH(NOLOCK) ON IMP.FTPdtCode = BAR.FTPdtCode /*AND IMP.FTPunCode = BAR.FTPunCode*/  AND IMP.FTBarCode = BAR.FTBarCode
                        LEFT JOIN TCNMPdtPackSize   PSZ WITH(NOLOCK) ON IMP.FTPdtCode = PSZ.FTPdtCode AND IMP.FTPunCode = PSZ.FTPunCode
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPDT'
                        AND IMP.FTTmpStatus       IN ('1','6')
                        AND ISNULL(IMP.FTBarCode,'') != ISNULL(BAR.FTBarCode,'')
                        AND PSZ.FTPunCode         IS NOT NULL
                      ";
            $this->db->query($tSQL);
            // echo $this->db->last_query();exit;

            //เพิ่มข้อมูลลงตาราง TCNMPdtSpcBch
            // $tSQL   = " UPDATE
            //                     TCNMPdtSpcBch
            //                 SET
            //                     TCNMPdtSpcBch.FTAgnCode = TCNTImpMasTmp.FTAgnCode
            //                 FROM
            //                     TCNMPdtSpcBch
            //                 INNER JOIN
            //                     TCNTImpMasTmp
            //                 ON
            //                     TCNMPdtSpcBch.FTPdtCode = TCNTImpMasTmp.FTPdtCode
            //                 WHERE
            //                     TCNTImpMasTmp.FTSessionID = '$tSessionID' 
            //                 AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtSpcBch'
            //                 AND TCNTImpMasTmp.FTTmpStatus = '1' ";
            // $this->db->query($tSQL);
            // if($this->db->affected_rows() == 0){       
                $tSQL   = " INSERT INTO TCNMPdtSpcBch (FTPdtCode,FTBchCode,FTMerCode,FTAgnCode,FTMgpCode,FCPdtMin,FTShpCode,FTPdtRmk)
                            SELECT DISTINCT
                                IMP.FTPdtCode,
                                IMP.FTBchCode,
                                IMP.FTMerCode,
                                IMP.FTAgnCode,
                                '',
                                0,
                                IMP.FTShpCode,
                                ''
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            LEFT JOIN TCNMPdtSpcBch SPC WITH(NOLOCK) ON IMP.FTPdtCode = SPC.FTPdtCode
                                AND ISNULL(IMP.FTBchCode,'') = ISNULL(SPC.FTBchCode,'')
                                AND ISNULL(IMP.FTMerCode,'') = ISNULL(SPC.FTMerCode,'')
                                AND ISNULL(IMP.FTShpCode,'') = ISNULL(SPC.FTShpCode,'')
                                AND ISNULL(IMP.FTAgnCode,'') = ISNULL(SPC.FTAgnCode,'')
                            WHERE 1=1 
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND IMP.FTTmpTableKey   = 'TCNMPdtSpcBch'
                                AND SPC.FTPdtCode       IS NULL
                        ";
                $this->db->query($tSQL);
            // }

           

            $tSQL = "   INSERT INTO [dbo].[TCNMImgPdt] ([FTImgRefID],[FNImgSeq],[FTImgTable],[FTImgKey],[FTImgObj],[FDLastUpdOn],[FTLastUpdBy],[FDCreateOn],[FTCreateBy])
                        SELECT
                            IMP.FTPdtCode   AS FTImgRefID,
                            1               AS FNImgSeq,
                            'TCNMPdt'       AS FTImgTable,
                            'master'        AS FTImgKey,
                            (SELECT TOP 1 FTColorCode FROM ( VALUES ('#BCDDBE'),('#FF9AA2'),('#FFB7B2'),('#FFDAC1'),('#E2F0CB'),('#B5EAD7'),('#C7CEEA'),('#64E987'),('#92F294'),('#C0F9FA'),('#88CEFB') ) n (FTColorCode) ORDER BY NEWID()) AS FTImgObj,
                            '$dDateOn'      AS FDLastUpdOn,
                            '$tUserBy'      AS FTLastUpdBy,
                            '$dDateOn'      AS FDCreateOn,
                            '$tUserBy'      AS FTCreateBy
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE 1=1
                        AND IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey   = 'TCNMPDT'
                        AND IMP.FTTmpStatus     = '1' 
                    ";
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