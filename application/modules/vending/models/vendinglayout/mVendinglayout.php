<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mVendinglayout extends CI_Model {

    //เข้าไปหาข้อมูลก่อนว่าเคยถูกเพิ่มไหม
    function FSaMVEDFindDataHD($paData){
        $tShpCode = $paData['tShpCode'];
        $tBchCode = $paData['tBchCode'];

        //TVDMShopSize ตารางนี้ คือไว้เซตความสูง ความกว้าง ของตู้สินค้า
        $tSQL = "SELECT VSL.FTBchCode AS FTBchCode FROM [TVDMShopSize] VSL WHERE 1=1 AND FTBchCode ='$tBchCode' AND FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    //เพิ่มข้อมูลพวกจำนวนชั้น จำนวนช่อง
    function FSaMVEDInsertSettingLayout($paData){
        try{
            $dDateCreateOn  = date("Y-m-d H:i:s");
            $tSesUsername   = $this->session->userdata("tSesUsername");
            $FNLngID        = $this->session->userdata("tLangEdit");
            $FTShpCode      = $paData['tShpCode'];
            $FTBchCode      = $paData['tBchCode'];
            $FCLayRowQty    = $paData['nVBFloor'];
            $FCLayColQty    = $paData['nVBColumn'];
            $FTLayName      = $paData['tVBName'];
            $FTLayRemark    = $paData['tVBReason'];
            $tTypePage      = $paData['tTypePage'];

            if($tTypePage == "INSERT"){
                $this->db->insert('TVDMShopSize',array(
                    'FTBchCode'      => $FTBchCode,
                    'FTShpCode'      => $FTShpCode,
                    'FCLayRowQty'    => $FCLayRowQty,
                    'FCLayColQty'    => $FCLayColQty,
                    'FTLayStaUse'    => 1,
                    'FDCreateOn'     => $dDateCreateOn,
                    'FTCreateBy'     => $tSesUsername,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));
    
                $this->db->insert('TVDMShopSize_L',array(
                    'FTBchCode'     => $FTBchCode,
                    'FTShpCode'     => $FTShpCode,
                    'FNLngID'       => $FNLngID,
                    'FTLayName'     => $FTLayName,
                    'FTLayRemark'   => $FTLayRemark
                ));
            }else if($tTypePage == "EDIT"){
                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize',array(
                    'FCLayRowQty'    => $FCLayRowQty,
                    'FCLayColQty'    => $FCLayColQty,
                    'FTLayStaUse'    => 1,
                    'FDCreateOn'     => $dDateCreateOn,
                    'FTCreateBy'     => $tSesUsername,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize_L',array(
                    'FNLngID'       => $FNLngID,
                    'FTLayName'     => $FTLayName,
                    'FTLayRemark'   => $FTLayRemark
                ));
            }else if($tTypePage == "CONFIRM"){
                //ถ้าไม่สนใจ ยืนยันจะลดขนาดความสูงและลดชั้น จะต้องลบเเละทำรายการใหม่
                $tDisType      = $paData['tDisType'];
                if($tDisType == 'FLOOR'){
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->where('FTBchCode', $FTBchCode);
                    $this->db->where('FNLayRow > ', $FCLayRowQty);
                    $this->db->delete('TVDMPdtLayout');
                }else{
                    $this->db->where('FTBchCode', $FTBchCode);
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->delete('TVDMPdtLayout');
                }

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize',array(
                    'FCLayRowQty'    => $FCLayRowQty,
                    'FCLayColQty'    => $FCLayColQty,
                    'FTLayStaUse'    => 1,
                    'FDCreateOn'     => $dDateCreateOn,
                    'FTCreateBy'     => $tSesUsername,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize_L',array(
                    'FNLngID'       => $FNLngID,
                    'FTLayName'     => $FTLayName,
                    'FTLayRemark'   => $FTLayRemark
                ));
            }
            
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //ลบความสูงจากตาราง Tmp
    function FSaMVEDDeleteHeightToTmp($paData){
        $FTShpCode      = $paData['tShpCode'];
        $FTBchCode      = $paData['tBchCode'];
        $tCabinetSeq    = $paData['tCabinetSeq'];
        $this->db->where('FTMttTableKey', 'TVDMShopCabinet');
        $this->db->where('FTBchCode', $FTBchCode); 
        $this->db->where('FTShpCode', $FTShpCode); 
        $this->db->where('FTGhdApp', $tCabinetSeq);
        $this->db->delete('TsysMasTmp');
    }

    //เพิ่มความสูงลงตาราง Tmp
    function FSaMVEDInsertHeightToTmp($nKey,$nHeight,$paData){
        $FTShpCode      = $paData['tShpCode'];
        $FTBchCode      = $paData['tBchCode'];
        $tCabinetSeq    = $paData['tCabinetSeq'];

        $this->db->insert('TsysMasTmp', array(
            'FTMttTableKey' => 'TVDMShopCabinet',
            'FTBchCode'     => $FTBchCode,
            'FTGhdApp'      => $tCabinetSeq ,
            'FTShpCode'     => $FTShpCode,
            'FTRefPdtCode'  => $nKey,
            'FTPdtCode'     => $nHeight,
            'FDCreateOn'    => date('Y-m-d')
        ));


        $this->db->where('FNCabSeq', $tCabinetSeq);
        $this->db->where('FTShpCode', $FTShpCode);
        $this->db->where('FNLayRow', $nKey);
        $this->db->update('TVDMPdtLayout',array(
            'FCLayHigh'    => $nHeight
        ));
    }

    //เอาความสูงจากตาราง Tmp
    function FSaMVEDGetDataHeightTemp($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nSeqCabinet    = $paData['nSeqCabinet'];
        $tSQL = "SELECT 
                    FTPdtCode , FTRefPdtCode FROM TsysMasTmp 
                WHERE FTMttTableKey = 'TVDMShopCabinet' AND FTBchCode = '$tBchCode' AND FTShpCode = '$tShpCode' AND FTGhdApp = '$nSeqCabinet'  ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
        }else{
            $oDetail = array();
        }
        return $oDetail;
    }

    //เอาข้อมูลไปแสดง HD ใช้ชั้นเท่าไหร่ ใช้ช่องเท่าไหร่
    function FSaMVEDGetDataHD($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                    Vsl.FTBchCode       AS rtVslBch,
                    BchL.FTBchName      AS rtBchName,
                    Vsl.FTShpCode       AS rtVslShp,
                    Vsl.FCLayRowQty     AS rtVslRowQty,
                    Vsl.FCLayColQty     AS rtVslColQty,
                    Vsl.FTLayStaUse     AS rtVslStaUse,
                    Vsl_L.FTLayName     AS rtVslName,
                    Vsl_L.FTLayRemark   AS rtVslRemark,
                    Shp_L.FTShpName     AS rtShpName
                FROM [TVDMShopSize] Vsl
                LEFT JOIN [TCNMBranch_L] BchL       ON Vsl.FTBchCode = BchL.FTBchCode   AND BchL.FNLngID = $nLngID 
                LEFT JOIN [TVDMShopSize_L] Vsl_L    ON Vsl.FTShpCode = Vsl_L.FTShpCode  AND Vsl_L.FNLngID = $nLngID
                LEFT JOIN [TCNMShop_L] Shp_L        ON Vsl.FTShpCode = Shp_L.FTShpCode  AND Vsl.FTBchCode = SHP_L.FTBchCode  AND Shp_L.FNLngID = $nLngID
                WHERE 1=1 AND Vsl.FTBchCode ='$tBchCode' AND Vsl.FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    //เอาข้อมูลของ Settting ออกมาโชว์
    function FSaMVEDGetDataSetting($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                    Vsl.FTBchCode       AS rtVslBch,
                    Vsl.FTShpCode       AS rtVslShp,
                    Vsl.FCLayRowQty     AS rtVslRowQty,
                    Vsl.FCLayColQty     AS rtVslColQty,
                    Vsl.FTLayStaUse     AS rtVslStaUse,
                    Vsl_L.FTLayName     AS rtVslName,
                    Vsl_L.FTLayRemark   AS rtVslRemark
                FROM [TVDMShopSize] Vsl
                LEFT JOIN [TVDMShopSize_L] Vsl_L    ON Vsl.FTShpCode = Vsl_L.FTShpCode AND Vsl_L.FNLngID = $nLngID 
                WHERE 1=1 AND Vsl.FTBchCode ='$tBchCode' AND Vsl.FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    //เอาข้อมูลความสูงของแต่ละชั้น 
    function FSaMVEDGetDataHeightFloor($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nSeqCabinet    = $paData['nSeqCabinet'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                        PDT.FNLayRow ,
                        PDT.FCLayHigh 
                FROM [TVDMPdtLayout] PDT
                WHERE 1=1 AND PDT.FTBchCode ='$tBchCode' AND PDT.FTShpCode = '$tShpCode' AND PDT.FNCabSeq = '$nSeqCabinet'  ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $oDetail = array();
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        // $jResult = json_encode($aResult);
        // $aResult = json_decode($jResult, true);
        return $oDetail;
    }

    //เอาข้อมูลไปแสดง DT รายการสินค้าต่างๆ
    public function FSaMVEDGetDataDT($paData){
        $tShpCode           = $paData['tShpCode'];
        $tBchCode           = $paData['tBchCode'];
        $nSeqCabinet        = $paData['nSeqCabinet'];
        $nLngID             = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT 
                    DISTINCT
                    Vslpdt.FTShpCode        AS rtPdtShp,   
                    Vslpdt.FNLayRow         AS rtPdtRow,
                    Vslpdt.FNLayCol         AS rtPdtCol,
                    Vslpdt.FTPdtCode        AS rtPdtCode,
                    Vslpdt.FCLayColQtyMax   AS rtPdtColQtyMax,
                    Vslpdt.FTLayStaCtrlXY   AS FTLayStaCtrlXY,
                    Vslpdt.FTWahCode        AS FTWahCode,
                    Vslpdt.FCLayDim         AS rtPdtDim,
                    Vslpdt.FCLayHigh        AS rtPdtHigh,
                    Vslpdt.FCLayWide        AS rtPdtWide,
                    Vslpdt.FTLayStaUse      AS rtPdtStaUse,
                    Vslpdt.FNCabSeq         AS FNCabSeq,
                    REPLACE(PDTIMG.FTImgObj,'\','/')         AS rtPdtImage,
                    PDTL.FTPdtName          AS rtPdtName,
                    PDTL.FTPdtRmk           AS rtPdtRmk,
                    PDAGE.FCPdtCookTime     AS rtPdtCookTime,  
                    PDAGE.FCPdtCookHeat     AS rtPdtCookHeat,
                    CAST(STKBAL.FCStkQty AS INT) AS rtStkQty
                    FROM [TVDMPdtLayout] Vslpdt
                    LEFT JOIN TCNMPdt    PDT     ON Vslpdt.FTPdtCode  	= PDT.FTPdtCode
                    LEFT JOIN TCNMPdt_L  PDTL    ON PDT.FTPdtCode       = PDTL.FTPdtCode AND PDTL.FNLngID = '$nLngID' 
                    LEFT JOIN TCNMPdtAge PDAGE   ON PDAGE.FTPdtCode     = PDT.FTPdtCode 
                    LEFT JOIN TCNMImgPdt PDTIMG  ON PDT.FTPdtCode       = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                    LEFT JOIN (
                        SELECT SUM(FCSTKQty) AS FCSTKQty , FNLayRow , FNLayCol , FTPdtCode FROM TVDTPdtStkBal WHERE 
                        FTWahCode IN (
                            SELECT WAH.FTWahCode FROM TVDMPosShop POS 
                            LEFT JOIN TCNMWaHouse WAH ON POS.FTBchCode = WAH.FTBchCode AND POS.FTPosCode = WAH.FTWahRefCode AND WAH.FTWahStaType = '6'
                            WHERE  POS.FTShpCode = '$tShpCode' AND POS.FTBchCode = '$tBchCode'
                        ) 
                        GROUP BY FNLayRow , FNLayCol , FTPdtCode , FNCabSeq
                    ) AS STKBAL ON Vslpdt.FNLayRow = STKBAL.FNLayRow AND Vslpdt.FNLayCol = STKBAL.FNLayCol AND Vslpdt.FTPdtCode = STKBAL.FTPdtCode
                    WHERE 1=1 AND Vslpdt.FTShpCode = '$tShpCode' AND Vslpdt.FTBchCode = '$tBchCode' AND Vslpdt.FNCabSeq = '$nSeqCabinet'  ";
                    
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    //หาว่า MerCode อะไร
    public function FSaMVslFindMerCode($paDataFindMercode){
        $tFTBchCode = $paDataFindMercode['FTBchCode'];
        $tFTShpCode = $paDataFindMercode['FTShpCode'];
        $tSQL = "SELECT FTMerCode FROM TCNMShop WHERE FTBchCode = '$tFTBchCode' AND FTShpCode = '$tFTShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    //ลบสินค้าใน Diagram ทั้งหมดก่อนเพิ่มสินค้าใหม่
    public function FSaMVslDeleteItem($paData){
        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        $this->db->where_in('FNCabSeq', $paData['FNCabSeq']);
        $this->db->delete('TVDMPdtLayout');
        
    }

    //เพิ่มสินค้าจาก Diagram ลงฐานข้อมูล
    public function FSaMVslInsertPDT($paData){
        try{
            $this->db->insert('TVDMPdtLayout',$paData);
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //หาว่าความสูงแต่ละชั้นเท่าไหร่
    public function FStMVEDFindHeight($pnBCH,$pnSHP,$pnFloor,$pnSeqCabinet){
        //หาความสูงแต่ละชั้น
        $tSQL = "SELECT FTPdtCode FROM TsysMasTmp 
                WHERE FTMttTableKey = 'TVDMShopCabinet' 
                AND FTBchCode = '$pnBCH' 
                AND FTShpCode = '$pnSHP' 
                AND FTRefPdtCode = '$pnFloor'
                AND FTGhdApp = '$pnSeqCabinet' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $nHeight = $oDetail[0]['FTPdtCode'];
        }else{
            $nHeight = '100';
        }
        return $nHeight;
    }

    //ลบข้อมูล ที่ถูก Merge
    public function FSxMVslDeletePDT($paData){
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->where('FTMerCode', $paData['FTMerCode']);
        $this->db->where('FTShpCode', $paData['FTShpCode']);
        $this->db->where('FNLayRow', $paData['FNLayRow']);
        $this->db->where('FNLayCol', $paData['FNLayCol']);
        $this->db->delete('TVDMPdtLayout');
    }

    //เรียง Seq ใหม่
    public function FSxMVEDSortSeqrow($paData){
        $tFTBchCode = $paData['FTBchCode'];
        $tFTShpCode = $paData['FTShpCode'];
        $tFNCabSeq  = $paData['FNCabSeq'];
        $tSql = "UPDATE T1 
                SET T1.FNLayCol = T2.FNLayNewCol -1
                FROM  TVDMPdtLayout T1 
                LEFT JOIN(
                    SELECT  ROW_NUMBER() OVER(PARTITION BY FNLayRow ORDER BY  FNLayRow,FNLayCol ASC) AS FNLayNewCol , 
                    FTBchCode AS FTBchCodeX,
                    FTShpCode AS FTShpCodeX,
                    FNLayRow AS FNLayRowX,
                    FNLayCol AS FNLayColX
                    FROM  TVDMPdtLayout 
                    WHERE FTBchCode = '$tFTBchCode' AND FTShpCode = '$tFTShpCode' AND FNCabSeq = '$tFNCabSeq' ) T2 ON T1.FTBchCode = T2.FTBchCodeX AND T1.FTShpCode = T2.FTShpCodeX 
                    AND T1.FNLayRow=T2.FNLayRowX AND T1.FNLayCol = T2.FNLayColX
                WHERE T1.FTBchCode = '$tFTBchCode' AND T1.FTShpCode = '$tFTShpCode' AND T1.FNCabSeq = '$tFNCabSeq' ";
        $oQuery = $this->db->query($tSql);
    }

    //###### New Version ######

    //Get Cabinet
    public function FSaMVEDGetCabinet($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                    SCB.FTBchCode ,
                    SCB.FTShpCode ,
                    SCB.FNCabSeq ,
                    SCB.FNCabMaxRow ,
                    SCB.FNCabMaxCol ,
                    SCB.FNCabType ,
                    SCB.FTShtCode ,
                    SCB.FDLastUpdOn ,
                    SCB.FTLastUpdBy ,
                    SCB.FDCreateOn ,
                    SCB.FTCreateBy ,
                    CabinetL.FTCabName ,
                    CabinetL.FTCabRmk ,
                    SPY.FTShtType,
                    SPT.FTShtName
                FROM [TVDMShopCabinet] SCB
                LEFT JOIN  [TVDMShopType] SPY ON SCB.FTShtCode = SPY.FTShtCode
                LEFT JOIN  [TVDMShopType_L] SPT ON SCB.FTShtCode = SPT.FTShtCode AND SPT.FNLngID = $nLngID
                LEFT JOIN  [TVDMShopCabinet_L] CabinetL ON SCB.FNCabSeq = CabinetL.FNCabSeq AND SCB.FTShpCode = CabinetL.FTShpCode 
                            AND SCB.FTBchCode = CabinetL.FTBchCode AND CabinetL.FNLngID = $nLngID 
                WHERE 1=1 AND SCB.FTShpCode ='$tShpCode' AND SCB.FTBchCode = '$tBchCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    //Update Cabinet
    public function FSxMVEDUpdateCabinet($paData){
        try{
            $dDateCreateOn  = date("Y-m-d H:i:s");
            $tSesUsername   = $this->session->userdata("tSesUsername");
            $FNLngID        = $this->session->userdata("tLangEdit");
            $FTShpCode      = $paData['tShpCode'];
            $FTBchCode      = $paData['tBchCode'];
            $FNCabSeq       = $paData['tCabinetSeq'];
            $FNCabMaxRow    = $paData['nVBFloor'];
            $FNCabMaxCol    = $paData['nVBColumn'];
            $FTCabName      = $paData['tVBName'];
            $FTCabRmk       = $paData['tVBReason'];
            $tTypePage      = $paData['tTypePage'];

            if($tTypePage == "EDIT"){
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FNCabSeq' , $FNCabSeq);
                $this->db->update('TVDMShopCabinet',array(
                    'FNCabMaxRow'    => $FNCabMaxRow,
                    'FNCabMaxCol'    => $FNCabMaxCol,
                ));

                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FNCabSeq', $FNCabSeq);
                $this->db->update('TVDMShopCabinet_L',array(
                    'FNLngID'           => $FNLngID,
                    'FTCabName'         => $FTCabName,
                    'FTCabRmk'          => $FTCabRmk,
                ));
            }else if($tTypePage == "CONFIRM"){
                //ถ้าไม่สนใจ ยืนยันจะลดขนาดความสูงและลดชั้น จะต้องลบเเละทำรายการใหม่
                $tDisType      = $paData['tDisType'];
                if($tDisType == 'FLOOR'){
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->where('FNCabSeq' , $FNCabSeq);
                    $this->db->where('FTBchCode' , $FTBchCode);
                    $this->db->where('FNLayRow > ', $FNCabMaxRow);
                    $this->db->delete('TVDMPdtLayout');
                }else{
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->where('FNCabSeq' , $FNCabSeq);
                    $this->db->where('FTBchCode' , $FTBchCode);
                    $this->db->delete('TVDMPdtLayout');
                }

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopCabinet',array(
                    'FNCabMaxRow'    => $FNCabMaxRow,
                    'FNCabMaxCol'    => $FNCabMaxCol,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->where('FNCabSeq', $FNCabSeq);
                $this->db->update('TVDMShopCabinet_L',array(
                    'FNLngID'           => $FNLngID,
                    'FTCabName'         => $FTCabName,
                    'FTCabRmk'          => $FTCabRmk,
                ));
            }
            
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Delete Diagram
    public function FSaMVEDDeleteDiagram($paData){
        try{
            $tShpCode       = $paData['tShpCode'];
            $tBchCode       = $paData['tBchCode'];
            $nSeqCabinet    = $paData['nSeqCabinet'];

            $this->db->where('FTShpCode', $tShpCode);
            $this->db->where('FTBchCode', $tBchCode);
            $this->db->where('FNCabSeq', $nSeqCabinet);
            $this->db->delete('TVDMPdtLayout');

            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Delete',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Get wahhouse
    public function FSaMVEDGetWahhouse($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");

        $tSQL = "SELECT
                     SHP.FTWahCode,
                     SHP.FTWahCode AS WAHMain,
                     WAH_L.FTWahName
                 FROM [TCNMWaHouse] SHP
                 LEFT JOIN  [TCNMWaHouse_L] WAH_L ON SHP.FTWahCode = WAH_L.FTWahCode AND SHP.FTBchCode = WAH_L.FTBchCode AND WAH_L.FNLngID = $nLngID
                 WHERE 1=1 AND SHP.FTBchCode ='$tBchCode' AND SHP.FTWahStaType != 6 ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    //Export
    public function FSaMVEDExportDetailDiagram($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nSeqCabinet    = $paData['nSeqCabinet'];
        $nLngID         = $this->session->userdata("tLangEdit");

        $tSQLLayout = "SELECT 
                        LAY.* , PDTL.* , WAHL.FTWahName , TYP.* , TYPL.* , CAB.* , CABL.*  FROM TVDMPdtLayout LAY 
                       LEFT JOIN TCNMPDT_L          PDTL    ON LAY.FTPdtCode = PDTL.FTPdtCode   AND PDTL.FNLngID  = '$nLngID' 
                       LEFT JOIN TCNMWahouse_L      WAHL    ON LAY.FTWahCode = WAHL.FTWahCode   AND LAY.FTBchCode = WAHL.FTBchCode  AND WAHL.FNLngID  = '$nLngID' 
                       INNER JOIN TVDMShopCabinet   CAB     ON LAY.FNCabSeq = CAB.FNCabSeq      AND LAY.FTBchCode = CAB.FTBchCode   AND LAY.FTShpCode = CAB.FTShpCode
                       INNER JOIN TVDMShopCabinet_L CABL    ON CAB.FNCabSeq = CABL.FNCabSeq     AND LAY.FTBchCode = CABL.FTBchCode  AND LAY.FTShpCode = CABL.FTShpCode
                       INNER JOIN TVDMShopType      TYP     ON CAB.FTShtCode = TYP.FTShtCode 
                       INNER JOIN TVDMShopType_L    TYPL    ON CAB.FTShtCode = TYPL.FTShtCode   AND TYPL.FNLngID = '$nLngID' 
                       WHERE 1=1 AND LAY.FTBchCode ='$tBchCode' AND LAY.FTShpCode = '$tShpCode' AND CABL.FNLngID = '$nLngID' ";

        $oQueryLayout = $this->db->query($tSQLLayout);
        $oDetail      = $oQueryLayout->result();

        $aResult = array(
            'raItemsLayout'   => $oDetail
        );
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Check ว่าถ้าไม่มี ใน PDTLayout จะ export ไม่ได้
    public function FSaMVEDCheckPDTInCabinet($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nSeqCabinet    = $paData['nSeqCabinet'];

        $tSQL = "SELECT TOP 1 * FROM [TVDMPdtLayout] PDT WHERE 1=1 AND PDT.FTBchCode ='$tBchCode' AND PDT.FTShpCode = '$tShpCode' AND PDT.FNCabSeq ='$nSeqCabinet' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $tResult = 'Found';
        }else{
            $tResult = 'Notfound';
        }

        return $tResult;
    }

    //Import หา WAH , MER 
    public function FSaMVEDFindWAHAndMER($ptType,$tBchCode,$tShopCode){
        if($ptType == 'WAH'){
            //หาคลังว่าเป็นคลังร้านค้า หรือคลังสาขา
            $tSQL = "SELECT TOP 1 * FROM [TCNMShpWah] SHPWAH WHERE 1=1 AND SHPWAH.FTBchCode ='$tBchCode' AND SHPWAH.FTShpCode = '$tShopCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $oDetail  = $oQuery->result();
                $tReturn = $oDetail[0]->FTWahCode;
            }else{
                $tReturn = '00001';
            }
        }else if($ptType == 'MER'){
            //หา Merchant ของร้านค้านี้
            $tSQL = "SELECT TOP 1 * FROM [TCNMShop] SHP WHERE 1=1 AND SHP.FTBchCode ='$tBchCode' AND SHP.FTShpCode = '$tShopCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $oDetail  = $oQuery->result();
                $tReturn = $oDetail[0]->FTMerCode;
            }else{
                $tReturn = '00001';
            }      
        }

        return $tReturn;
    }

    //Delete ก่อน เเล้วค่อย Import
    public function FSaMVEDImportDeleteDiagramByCab($tBchCode,$tShopCode,$nCabinetCode){
        //ถ้าเป็นลำดับ 0 จะต้องลบ Diagram ทั้งหมดก่อน
        $this->db->where('FTShpCode', $tShopCode);
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->where('FNCabSeq', $nCabinetCode);
        $this->db->delete('TVDMPdtLayout');
    }

    //Import
    public function FSaMVEDImportDetailDiagram($paData,$tBchCode,$tShopCode,$aItem,$nIndex,$tWAH,$tMER){
        $FNLngID  = $this->session->userdata("tLangEdit");
        switch ($paData['tTable']) {
            case "TVDMShopCabinet":
                $this->db->set('FNCabMaxRow', $paData['FNCabMaxRow']);
                $this->db->set('FNCabMaxCol', $paData['FNCabMaxCol']);
                $this->db->set('FNCabType', $paData['FNCabType']);
                $this->db->set('FTShtCode', $paData['FTShtCode']);
                $this->db->where('FTBchCode', $tBchCode);
                $this->db->where('FTShpCode', $tShopCode);
                $this->db->where('FNCabSeq', $paData['FNCabSeq']);
                $this->db->update('TVDMShopCabinet');
                if($this->db->affected_rows() > 0){
                    
                }else{
                    $this->db->insert('TVDMShopCabinet', array(
                        'FTBchCode'     => $tBchCode,
                        'FTShpCode'     => $tShopCode,
                        'FNCabSeq'      => $paData['FNCabSeq'],
                        'FNCabMaxRow'   => $paData['FNCabMaxRow'],
                        'FNCabMaxCol'   => $paData['FNCabMaxCol'],
                        'FNCabType'     => $paData['FNCabType'],
                        'FTShtCode'     => $paData['FTShtCode'],
                        'FDCreateOn'    => date("Y-m-d H:i:s"),
                        'FTCreateBy'    => $this->session->userdata("tSesUsername")
                    ));
                }
                break;
            case "TVDMShopCabinet_L":
                $this->db->set('FTCabName', $paData['FTCabName']);
                $this->db->set('FTCabRmk', $paData['FTCabRmk']);
                $this->db->where('FTBchCode', $tBchCode);
                $this->db->where('FTShpCode', $tShopCode);
                $this->db->where('FNCabSeq', $paData['FNCabSeq']);
                $this->db->where('FNLngID', $FNLngID);
                $this->db->update('TVDMShopCabinet_L');
                if($this->db->affected_rows() > 0){
                    
                }else{
                    $this->db->insert('TVDMShopCabinet_L', array(
                        'FTBchCode'     => $tBchCode,
                        'FTShpCode'     => $tShopCode,
                        'FNCabSeq'      => $paData['FNCabSeq'],
                        'FNLngID'       => $FNLngID,
                        'FTCabName'     => $paData['FTCabName'],
                        'FTCabRmk'      => $paData['FTCabRmk']
                    ));
                }
                break;
            case "TVDMShopType":
                $this->db->set('FTShtType', $paData['FTShtType']);
                $this->db->set('FNShtValue', $paData['FNShtValue']);
                $this->db->set('FNShtMin', $paData['FNShtMin']);
                $this->db->set('FNShtMax', $paData['FNShtMax']);
                $this->db->where('FTShtCode', $paData['FTShtCode']);
                $this->db->update('TVDMShopType');
                if($this->db->affected_rows() > 0){
                    
                }else{
                    $this->db->insert('TVDMShopType', array(
                        'FTShtCode'     => $paData['FTShtCode'],
                        'FTShtType'     => $paData['FTShtType'],
                        'FNShtValue'    => $paData['FNShtValue'],
                        'FNShtMin'      => $paData['FNShtMin'],
                        'FNShtMax'      => $paData['FNShtMax'],
                        'FDLastUpdOn'   => date("Y-m-d H:i:s"),
                        'FTLastUpdBy'   => $this->session->userdata("tSesUsername"),
                        'FDCreateOn'    => date("Y-m-d H:i:s"),
                        'FTCreateBy'    => $this->session->userdata("tSesUsername")
                    ));
                }
                break;
            case "TVDMShopType_L";
                $this->db->set('FTShtName', $paData['FTShtName']);
                $this->db->set('FTShtRemark', $paData['FTShtRemark']);
                $this->db->where('FNLngID', $FNLngID);
                $this->db->where('FTShtCode', $paData['FTShtCode']);
                $this->db->update('TVDMShopType_L');
                if($this->db->affected_rows() > 0){
                    
                }else{
                    $this->db->insert('TVDMShopType_L', array(
                        'FTShtCode'     => $paData['FTShtCode'],
                        'FNLngID'       => $FNLngID,
                        'FTShtName'     => $paData['FTShtName'],
                        'FTShtRemark'   => $paData['FTShtRemark']
                    ));
                }
                break;
            case "TVDMPdtLayout";
                $tWahCode = $tWAH;
                $tMerCode = $tMER;

                //STEP 1 : insert ทั้งหมด
                $this->db->insert('TVDMPdtLayout', array(
                    'FTBchCode'     => $tBchCode,
                    'FTMerCode'     => $tMerCode,
                    'FTShpCode'     => $tShopCode,
                    'FNCabSeq'      => $aItem['FNCabSeq'],
                    'FNLayRow'      => $aItem['FNLayRow'],
                    'FNLayCol'      => $aItem['FNLayCol'],
                    'FTLayStaCtrlXY'=> $aItem['FTLayStaCtrlXY'],
                    'FTPdtCode'     => $aItem['FTPdtCode'],
                    'FCLayColQtyMax'=> $aItem['FCLayColQtyMax'],
                    'FCLayDim'      => $aItem['FCLayDim'],
                    'FCLayHigh'     => $aItem['FCLayHigh'],
                    'FCLayWide'     => $aItem['FCLayWide'],
                    'FTLayStaUse'   => $aItem['FTLayStaUse'],
                    'FTWahCode'     => $tWahCode,
                    'FDLastUpdOn'   => date("Y-m-d H:i:s"),
                    'FTLastUpdBy'   => $this->session->userdata("tSesUsername"),
                    'FDCreateOn'    => date("Y-m-d H:i:s"),
                    'FTCreateBy'    => $this->session->userdata("tSesUsername")
                ));

                //STEP 2 : เช็คสินค้าถ้าสินค้าตัวนั้นไม่ตรงเงื่อนไข
                $aCheckData = array(
                    'tShpCode'          => $tShopCode,
                    'tBchCode'          => $tBchCode,
                    'nPDTCode'          => $aItem['FTPdtCode']
                );
                $tResultCheck = $this->FSaMVEDImportCheckPDT($aCheckData,$tMER);
                if($tResultCheck['rtCode'] == 800){
                    $this->db->where('FTBchCode', $tBchCode);
                    $this->db->where('FTShpCode', $tShopCode);
                    $this->db->where('FNCabSeq', $aItem['FNCabSeq']);
                    $this->db->where('FTPdtCode', '');
                    $this->db->update('TVDMPdtLayout',array(
                        'FTWahCode'         => ''
                    ));

                    $this->db->where('FTBchCode', $tBchCode);
                    $this->db->where('FTShpCode', $tShopCode);
                    $this->db->where('FNCabSeq', $aItem['FNCabSeq']);
                    $this->db->where('FTPdtCode', $aItem['FTPdtCode']);
                    $this->db->where('FTPdtCode !=', '');
                    $this->db->update('TVDMPdtLayout',array(
                        'FTPdtCode'         => 'IMPORTFAIL',
                        'FCLayColQtyMax'    => 0,
                        'FCLayDim'          => 0,
                        'FTWahCode'         => ''
                    ));
                }
                break;
            default:
        }
    }

    //Check PDT
    public function FSaMVEDImportCheckPDT($paData,$tMER){
        $tShpCode          = $paData['tShpCode'];
        $tBchCode          = $paData['tBchCode'];
        $nPDTCode          = $paData['nPDTCode'];

        //หา Merchant ของร้านค้านี้
        $tMerCode = $tMER;
        
        $tSQL = "SELECT TOP 1 * FROM [TCNMPdtSpcBch] SPCBCH WHERE 1=1 
                AND (SPCBCH.FTBchCode = '$tBchCode' AND SPCBCH.FTShpCode = '$tShpCode' AND SPCBCH.FTPDTCode = '$nPDTCode' )
                OR  (SPCBCH.FTBchCode = '' AND SPCBCH.FTShpCode = '' AND SPCBCH.FTMerCode = '$tMerCode' AND SPCBCH.FTPDTCode = '$nPDTCode' ); ";
                
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = array(
                'rtCode' => '1',
                'rtDesc' => 'Found',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'Data not found.',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Delete TVDTPdtStkBal ช่องเก่าเสมอ
    public function FSxMVEDDeleteSTKBal($paData){
        $tShpCode          = $paData['FTShpCode'];
        $tBchCode          = $paData['FTBchCode'];
        $nCabSeq           = $paData['FNCabSeq'];

        $tSQL = "   SELECT WAH.FTWahCode FROM TCNMWaHouse WAH 
                    INNER JOIN TVDMPosShop POS ON WAH.FTBchCode = POS.FTBchCode AND POS.FTPosCode = WAH.FTWahRefCode 
                    WHERE WAH.FTWahStaType = 6 AND WAH.FTBchCode = '$tBchCode' AND POS.FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail        = $oQuery->result();
            $nWahHouseCode  =  $oDetail[0]->FTWahCode;
            $dDateLast  = date("Y-m-d H:i:s");

            //ปรับเวลาให้ล่าสุด ให้ตู้ sync สามารถ sync ได้
            $this->db->where('FTWahCode', $nWahHouseCode);
            $this->db->where('FTBchCode', $tBchCode);
            $this->db->where('FNCabSeq' , $nCabSeq);
            $this->db->update('TVDTPdtStkBal',array(
                'FDLastUpdOn'    => $dDateLast
            ));
            
            //ลบตัวที่เอาออกใน STKBal
            $tSQL = "  DELETE STK
                        FROM TVDTPdtStkBal STK 
                        LEFT JOIN TVDMPdtLayout PDT ON STK.FNLayCol = PDT.FNLayCol AND STK.FNLayRow = PDT.FNLayRow AND STK.FTPdtCode = PDT.FTPdtCode
                        WHERE 
                            STK.FTBchCode = '$tBchCode' 
                        AND STK.FTWahCode = '$nWahHouseCode'
                        AND STK.FNCabSeq = '$nCabSeq'
                        AND ISNULL(PDT.FTPdtCode,'') = '' ";
            $oQuery = $this->db->query($tSQL);
        }
    }

    //Check เอกสารที่เกี่ยวข้อง ว่าอนุมัติหรือยัง
    public function FSaMVEDFindDocumentWhenNotApv($tBchCode){
        $tSQL = "SELECT DISTINCT ALLDOC.DOCTYPE FROM (

                    --เอกสารใบเติมสินค้าแบบชุด
                    SELECT TVDTPdtTwxHD.FTXthDocNo AS 'DOCNO'  , 'TOPUP' AS 'DOCTYPE'
                    FROM TVDTPdtTwxHD 
                    WHERE FTXthStaApv = '' 
                    AND FTXthStaDoc != 3 
                    AND FTXthDocType = 1
                    AND FTBchCode = '$tBchCode'
                    
                    UNION ALL 

                    --เอกสารนำสินค้าออกจากตู้
                    SELECT TVDTPdtTwxHD.FTXthDocNo AS 'DOCNO' , 'PDTOUT' AS 'DOCTYPE'    
                    FROM TVDTPdtTwxHD 
                    WHERE FTXthStaApv = '' 
                    AND FTXthStaDoc != 3 
                    AND FTXthDocType = 2
                    AND FTBchCode = '$tBchCode'
                    
                    UNION ALL 

                    --เอกสารใบตรวจนับสินค้า
                    SELECT TCNTPdtAdjStkHD.FTAjhDocNo AS 'DOCNO' , 'ADJ' AS 'DOCTYPE'  
                    FROM TCNTPdtAdjStkHD 
                    WHERE FTAjhStaApv = '' 
                    AND FTAjhStaDoc != 3 
                    AND FTAjhDocType = 3
                    AND FTBchCode = '$tBchCode'
                    
                ) AS ALLDOC ";
                
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Found',
                'raItem'    => $oQuery->result()
            );
        }else{
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data not found.',
                'raItem'    => ''
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

}