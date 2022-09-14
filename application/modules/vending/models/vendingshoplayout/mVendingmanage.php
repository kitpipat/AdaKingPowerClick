<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mVendingmanage extends CI_Model {


    //Get Data HD
    public function FSaMVslGetDataHD($nID,$nLangID){
        $tSQL = "SELECT
                        Vsl.FTBchCode AS rtVslBch,
                        Vsl.FTShpCode AS rtVslShp,
                        Vsl.FCLayRowQty AS rtVslRowQty,
                        Vsl.FCLayColQty AS rtVslColQty,
                        Vsl.FTLayStaUse AS rtVslStaUse,
                        Vsl_L.FTLayName AS rtVslName,
                        Vsl_L.FTLayRemark AS rtVslRemark,
                        Shp_L.FTShpName AS rtShpName
                    FROM [TVDMShopSize] Vsl
                    LEFT JOIN [TVDMShopSize_L] Vsl_L ON Vsl.FTShpCode = Vsl_L.FTShpCode AND Vsl_L.FNLngID = $nLangID
                    LEFT JOIN [TCNMShop_L] Shp_L ON Vsl.FTShpCode = Shp_L.FTShpCode AND Vsl.FTBchCode = SHP_L.FTBchCode  AND Shp_L.FNLngID = $nLangID
                    WHERE 1=1 AND Vsl.FTShpCode = '$nID' ";
        
        $oQuery = $this->db->query($tSQL);
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
    
    //Get Data DT
    public function FSaMVslGetDataDT($nID,$nLangID){
        $tSQL = "SELECT 
                    DISTINCT
                    Vslpdt.FTShpCode        AS rtPdtShp,   
                    Vslpdt.FNLayRow         AS rtPdtRow,
                    Vslpdt.FNLayCol         AS rtPdtCol,
                    Vslpdt.FTPdtCode        AS rtPdtCode,
                    Vslpdt.FCLayColQtyMax   AS rtPdtColQtyMax,
                    Vslpdt.FCLayDim         AS rtPdtDim,
                    Vslpdt.FCLayHigh        AS rtPdtHigh,
                    Vslpdt.FCLayWide        AS rtPdtWide,
                    Vslpdt.FTLayStaUse      AS rtPdtStaUse,

                    REPLACE(PDTIMG.FTImgObj,'\','/')         AS rtPdtImage,
                    PDTL.FTPdtName          AS rtPdtName,
                    PDTL.FTPdtRmk           AS rtPdtRmk,
                    PDAGE.FCPdtCookTime     AS rtPdtCookTime, 
                    PDAGE.FCPdtCookHeat     AS rtPdtCookHeat
                    FROM [TVDMPdtLayout] Vslpdt
                    LEFT JOIN TCNMPdt    PDT     ON Vslpdt.FTPdtCode  	= PDT.FTPdtCode
                    LEFT JOIN TCNMPdt_L  PDTL    ON PDT.FTPdtCode       = PDTL.FTPdtCode AND PDTL.FNLngID = '$nLangID' 
                    LEFT JOIN TCNMPdtAge PDAGE   ON PDAGE.FTPdtCode     = PDT.FTPdtCode 
                    LEFT JOIN TCNMImgPdt PDTIMG  ON PDT.FTPdtCode       = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                    WHERE 1=1 AND Vslpdt.FTShpCode = '$nID' ";
        
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

    //Get MerCode 
    public function FSaMVslFindMerCode($aDataFindMercode){
        $tFTBchCode = $aDataFindMercode['FTBchCode'];
        $tFTShpCode = $aDataFindMercode['FTShpCode'];
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

    //Insert PDT
    public function FSaMVslInsertPDT($aData){
        try{
            $this->db->insert('TVDMPdtLayout',$aData);
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

    //Delete PDT 
    public function FSaMVslDeleteItem($aData){
        $this->db->where_in('FTShpCode', $aData['FTShpCode']);
        $this->db->delete('TVDMPdtLayout');
    }


}