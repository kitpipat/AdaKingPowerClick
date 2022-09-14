<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mDiscountpolicy extends CI_Model {

    // เอาไว้ Auto สร้าง config เข้ามายังตาราง TPSTDiscPolicy
    // 1. ดึงมาจากตาราง TSysDisPolicy เสร็จแล้วจะเข้า ไป insert Auto ที่ตาราง TPSTDiscPolicy
    // Create By Witsarut 21/07/2020
    public function FSaMPRGDataAutoConfig(){


        $tSQL = " INSERT INTO TPSTDiscPolicy 
            SELECT
                B.FTDpcDisCodeX,
                A.FTDisCode AS FTDpcDisCodeY,
            CASE
            WHEN B.FTDisGroup = 2 THEN
                3
            ELSE
                1
            END AS FTDpcStaAlw, GETDATE(),'System', GETDATE(),'System'
            FROM
                (
                    SELECT
                        FTDisCode
                    FROM
                        TSysDisPolicy
                    WHERE
                        FTDisStaUse = 1
                ) A
            CROSS JOIN (
                SELECT
                    PLC.FTDisCode AS FTDpcDisCodeX,
                    PLC.FTDisGroup
                FROM
                    TSysDisPolicy PLC
                LEFT JOIN TPSTDiscPolicy PSP ON PLC.FTDisCode = FTDpcDisCodeX
                WHERE
                    ISNULL(PSP.FTDpcDisCodeX, '') = ''
                AND PLC.FTDisStaUse = 1
            ) B
            UNION

            SELECT DISTINCT
                TPT.FTDpcDisCodeX,
                TSD.FTDisCode AS FTDpcDisCodeY ,
                CASE
            WHEN TSD.FTDisGroup = 2 THEN
                3
            ELSE
                1
            END AS FTDpcStaAlw,GETDATE(),'System', GETDATE(),'System'
            FROM
                TPSTDiscPolicy TPT
            CROSS JOIN (	SELECT
                        TSD.FTDisCode,
                TSD.FTDisGroup
                    FROM
                        TSysDisPolicy TSD
                LEFT JOIN TPSTDiscPolicy PSP ON TSD.FTDisCode = PSP.FTDpcDisCodeY
                WHERE
                    ISNULL(PSP.FTDpcDisCodeY, '') = ''
                    AND
                        TSD.FTDisStaUse = 1

            ) TSD
        ";
        $oQuery = $this->db->query($tSQL);
    }
    

    // Check Status TSysDisPolicy ถ้า เท่ากับ 2 ให้ไป Delete ที่ TPSTDiscPolicy
    public function FSaMPRGDataStaDelUse($paData){
        $nLngID  = $paData['FNLngID'];

        $tSQL  =  " SELECT
                        PLC.FTDisCode,
                        PLC.FTDisStaUse
                    FROM  [TSysDisPolicy] PLC 
                    LEFT JOIN TSysDisPolicy_L PLC_L ON PLC.FTDisCode = PLC_L.FTDisCode AND PLC_L.FNLngID =  $nLngID
                ";
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Get Data Table Header  TPSTDiscPolicy/TSysDisPolicy_L
    // Create By Witsarut 17/07/2020
    public function FSaMPRGDataTableHeader($paData){
        $nLngID  = $paData['FNLngID'];

        $tSQL = "SELECT 
                    PLC.FTDpcDisCodeY, 
                    PLL.FTDisName,
                    PL.FTDisGroup,
                    PL.FTDisStaUse,
                    PL.FTDisCode
            FROM
            (
                SELECT DISTINCT 
                    FTDpcDisCodeY
                FROM TPSTDiscPolicy
                ) PLC
                LEFT JOIN TSysDisPolicy_L PLL ON PLC.FTDpcDisCodeY = PLL.FTDisCode AND PLL.FNLngID = $nLngID
                LEFT JOIN TSysDisPolicy PL ON PLL.FTDisCode = PL.FTDisCode
            ";
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
    }

    // 1. Get ข้อมูลจาก ตาราง TPSTDiscPolicy distinct FTDpcDisCodeX 
    // Create By Witsarut 17/07/2020
    public function FSaMPRGDataComma(){

        $tSQL = "SELECT COUNT(DISTINCT FTDpcDisCodeY) AS FTDpcDisCodeY FROM TPSTDiscPolicy";
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Get Data Table Header
    // Create By Witsarut 17/07/2020
    public function FSaMPRGDataTable($paData, $paDpcDisCodeYSet, $paYColumnShow){

        $nLngID     = $paData['FNLngID'];
        $tSearchList = $paData['tSearchAll'];

        $tSQL = " SELECT  PPV.*,
                    PLL.FTDisName,  
                    CASE PLC.FTDisGroup 
                        WHEN 1 THEN 'ITEM'
                        WHEN 2 THEN 'PROMOTION'
                        WHEN 3 THEN 'BILL'
                        ELSE 'N/A'
                        END AS FTDisGroup,
                    CASE WHEN PLC.FTDisStaPrice = 1 THEN 'Full Price/Set Price' ELSE 'Net Peice' END AS FTDisStaPrice
                FROM (
                    SELECT  
                        $paYColumnShow
                    FROM(
                        SELECT FTDpcDisCodeX, 
                            col + CAST(seq AS VARCHAR(10)) AS col, 
                            value
                        FROM
                        (
                            SELECT
                                POL.FTDpcDisCodeX,
                                POL.FTDpcStaAlw,
                                POL.FTDpcDisCodeY,
                                PXY.FTDpcStaAlwYN,
                                PXY.FTDpcStaAlwB,
                                ROW_NUMBER () OVER (
                                    PARTITION BY POL.FTDpcDisCodeX
                                    ORDER BY
                                    POL.FTDpcDisCodeX
                                ) seq
                            FROM
                            TPSTDiscPolicy POL
                            LEFT JOIN TSysDiscPolicyXY PXY ON PXY.FTDpcDisCodeX = POL.FTDpcDisCodeX 
                            AND PXY.FTDpcDisCodeY = POL.FTDpcDisCodeY 
                        ) d CROSS APPLY 
                    (
                    SELECT 'FTDpcStaAlw', 
                        CAST(FTDpcStaAlw AS VARCHAR(20))
                    UNION ALL
                    SELECT 'FTDpcDisCodeY', 
                        FTDpcDisCodeY
                    UNION ALL
                        SELECT
                            'Column_YN',
                            FTDpcStaAlwYN
                    UNION ALL
                        SELECT
                            'Column_B',
                            FTDpcStaAlwB 
                ) c(col, value)
                    ) src PIVOT(MAX(value) FOR col IN(
                        $paDpcDisCodeYSet
                    )) piv ) PPV
            INNER JOIN TSysDisPolicy PLC ON PPV.FTDpcDisCodeX = PLC.FTDisCode
            INNER JOIN TSysDisPolicy_L PLL ON PPV.FTDpcDisCodeX = PLL.FTDisCode AND PLL.FNLngID = $nLngID
        ";

        if(isset($tSearchList) && !empty($tSearchList)){
            if($tSearchList == 'ITEM'){
                $tSQL .= " AND (PLC.FTDisGroup = 1) "; 
            }else if($tSearchList == 'PROMOTION'){
                $tSQL .= " AND (PLC.FTDisGroup = 2) "; 
            }else if($tSearchList == 'SUB'){
                $tSQL .= " AND (PLC.FTDisGroup = 3) "; 
            }else if($tSearchList == 'Full Price/Set Price'){
                $tSQL .= " AND (PLC.FTDisStaPrice = 1) "; 
            }else if($tSearchList == 'Net Peice'){
                $tSQL .= " AND (PLC.FTDisStaPrice = 2) "; 
            }else{
                // $tSQL .= " AND (CRD.FTCrdCode   LIKE '%$tSearchList%'";
                // $tSQL .= " OR CRD.FTCrdHolderID LIKE '%$tSearchList%'";
                // $tSQL .= " OR CRD_L.FTCrdName   LIKE '%$tSearchList%'";
                // $tSQL .= " OR CTY_L.FTCtyName   LIKE '%$tSearchList%')";
            }
        }

        $oQuery = $this->db->query($tSQL);

        
        if($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Update DataMaster 
    // Create BY Witsarut 20/07/2020
    public function FSaMPRGUpdateMasterDataTable($paData){
        try{
            $this->db->set('FTDpcStaAlw',$paData['tStaAlw']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FDCreateOn', $paData['FDCreateOn']);
            $this->db->set('FTCreateBy', $paData['FTCreateBy']);
            $this->db->where('FTDpcDisCodeX', $paData['tDisCodeX']);
            $this->db->where('FTDpcDisCodeY', $paData['tDisCodeY']);
            $this->db->update('TPSTDiscPolicy');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'UnSuccess.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    // Delete ตาราง TPSTDiscPolicy
    // เงื่อนไข ถ้า ตาราง TSysDisPolicy Feild FTDisStaUse = 2 ให้ทำการ Delete ที่ตาราง TPSTDiscPolicy
    public function FSaMPRGDeleteCodeXY($paDataCodeX, $paDataCodeY){

        try{

            $this->db->where('FTDpcDisCodeX', $paDataCodeX);
            $this->db->where('FTDpcDisCodeY', $paDataCodeY);
            $this->db->delete('TPSTDiscPolicy');

        //    echo $this->db->last_query();

            if($this->db->affected_rows() > 0){
                //Success
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            }else{
                //Ploblem
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }
}