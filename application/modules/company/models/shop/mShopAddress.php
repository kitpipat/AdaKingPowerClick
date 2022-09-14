<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mShopAddress extends CI_Model{
    

    // Functionality: Selete Data Shop Address List
    // Parameters: function parameters
    // Creator: 10/09/2019 Wasin(Yoshi)
    // Return: Data Shop Address List
    // ReturnType: Array
    public function FSaMShopAddressDataList($paDataWhere){
        $tSQL   = " SELECT
                        ADDL.FNLngID,
                        ADDL.FTAddGrpType,
                        ADDL.FTAddRefCode,
                        ADDL.FNAddSeqNo,
                        ADDL.FTAddRefNo,
                        ADDL.FTAddName,
                        ADDL.FTAddTaxNo,
                        ADDL.FTAddWebsite,
                        ADDL.FTAddRmk
                    FROM TCNMAddress_L ADDL WITH(NOLOCK)
                    WHERE 1=1 
                    AND ADDL.FTAddGrpType   = 4
                    AND ADDL.FNLngID        = '".$paDataWhere['FNLngID']."'
                    AND ADDL.FTAddRefCode   = '".$paDataWhere['FTAddRefCode']."'
                    ORDER BY FNAddSeqNo ASC
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDataReturn    = $oQuery->result_array();
        }else{
            $aDataReturn    = array();
        }
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Shop Address Get Version
    // Parameters: function parameters
    // Creator: 10/09/2019 Wasin(Yoshi)
    // Return: Data Shop Address Version Config
    // ReturnType: Array
    public function FSaMShopAddressGetVersion(){
        $tSQL   = " SELECT
                        FTSysStaDefValue,
                        FTSysStaUsrValue  
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE 1=1
                    AND FTSysCode   = 'tCN_AddressType'
                    AND FTSysKey    = 'TCNMShop'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = array();
        }
        return $aResult;
    }

    // Functionality: Shop Address Get Data By ID
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: Data Shop Address
    // ReturnType: Array
    public function FSaMShopAddressGetDataID($paDataWhereAddress){
        $tSQL   = " SELECT DISTINCT
                        ADDL.FNLngID,
                        ADDL.FTAddGrpType,
                        ADDL.FTAddRefCode,
                        ADDL.FNAddSeqNo,
                        ADDL.FTAddRefNo,
                        ADDL.FTAddName,
                        ADDL.FTAddTaxNo,
                        ADDL.FTAddRmk,
                        ADDL.FTAddCountry,
                        ADDL.FTAddVersion,
                        ADDL.FTAddV1No,
                        ADDL.FTAddV1Soi,
                        ADDL.FTAddV1Village,
                        ADDL.FTAddV1Road,
                        ADDL.FTAddV1SubDist AS FTSudCode,
                        SDSTL.FTSudName,
                        ADDL.FTAddV1DstCode AS FTDstCode,
                        DSTL.FTDstName,
                        ADDL.FTAddV1PvnCode AS FTPvnCode,
                        PVNL.FTPvnName,
                        ADDL.FTAddV1PostCode,
                        ADDL.FTAddV2Desc1,
                        ADDL.FTAddV2Desc2,
                        ADDL.FTAddWebsite,
                        ADDL.FTAddLongitude,
                        ADDL.FTAddLatitude
                    FROM TCNMAddress_L ADDL WITH(NOLOCK)
                    LEFT JOIN TCNMSubDistrict_L SDSTL WITH(NOLOCK) ON ADDL.FTAddV1SubDist = SDSTL.FTSudCode AND SDSTL.FNLngID = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMDistrict_L DSTL WITH(NOLOCK) ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMProvince_L PVNL WITH(NOLOCK) ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = '".$paDataWhereAddress['FNLngID']."'
                    WHERE 1=1
                    AND ADDL.FNLngID         = '".$paDataWhereAddress['FNLngID']."'
                    AND ADDL.FTAddGrpType    = '".$paDataWhereAddress['FTAddGrpType']."'
                    AND ADDL.FTAddRefCode    = '".$paDataWhereAddress['FTAddRefCode']."'
                    AND ADDL.FNAddSeqNo      = '".$paDataWhereAddress['FNAddSeqNo']."'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDataReturn    = $oQuery->row_array();
        }else{
            $aDataReturn    = array();
        }
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Shop Address Update Seq
    // Parameters: function parameters
    // Creator: 10/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMShopAddressUpdateSeq($paShopDataAddress){
        $tSQL   = " UPDATE ADDRUPD
                    SET	ADDRUPD.FTAddRefNo = DATARUNSEQ.FTAddRefNo
                    FROM TCNMAddress_L AS ADDRUPD WITH(NOLOCK)
                    INNER JOIN (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FNAddSeqNo ASC) AS FTAddRefNo,
                            FNLngID,
                            FTAddGrpType,
                            FTAddRefCode,
                            FNAddSeqNo
                        FROM TCNMAddress_L WITH(NOLOCK)
                        WHERE 1=1
                        AND FNLngID         = '".$paShopDataAddress['FNLngID']."'
                        AND FTAddRefCode    = '".$paShopDataAddress['FTAddRefCode']."'
                        AND FTAddGrpType    = '".$paShopDataAddress['FTAddGrpType']."'
                    ) AS DATARUNSEQ
                    ON 1=1
                    AND ADDRUPD.FNLngID         = DATARUNSEQ.FNLngID
                    AND ADDRUPD.FTAddGrpType	= DATARUNSEQ.FTAddGrpType
                    AND ADDRUPD.FTAddRefCode	= DATARUNSEQ.FTAddRefCode
                    AND ADDRUPD.FNAddSeqNo		= DATARUNSEQ.FNAddSeqNo
        ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Shop Address Add Event
    // Parameters: function parameters
    // Creator: 10/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMShopAddressAddData($paShopDataAddress){
        $tAddressVersion    = $paShopDataAddress['FTAddVersion'];
        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " INSERT INTO TCNMAddress_L (
                            FNLngID,FTAddGrpType,FTAddRefCode,
                            FTAddName,FTAddTaxNo,FTAddRmk,
                            FTAddVersion,FTAddV1No,FTAddV1Soi,
                            FTAddV1Village,FTAddV1Road,FTAddV1SubDist,
                            FTAddV1DstCode,FTAddV1PvnCode,FTAddV1PostCode,
                            FTAddWebsite,FTAddLongitude,FTAddLatitude,
                            FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
                        )
                        VALUES (
                            '".$paShopDataAddress['FNLngID']."',
                            '".$paShopDataAddress['FTAddGrpType']."',
                            '".$paShopDataAddress['FTAddRefCode']."',
                            '".$paShopDataAddress['FTAddName']."',
                            '".$paShopDataAddress['FTAddTaxNo']."',
                            '".$paShopDataAddress['FTAddRmk']."',
                            '".$paShopDataAddress['FTAddVersion']."',
                            '".$paShopDataAddress['FTAddV1No']."',
                            '".$paShopDataAddress['FTAddV1Soi']."',
                            '".$paShopDataAddress['FTAddV1Village']."',
                            '".$paShopDataAddress['FTAddV1Road']."',
                            '".$paShopDataAddress['FTAddV1SubDist']."',
                            '".$paShopDataAddress['FTAddV1DstCode']."',
                            '".$paShopDataAddress['FTAddV1PvnCode']."',
                            '".$paShopDataAddress['FTAddV1PostCode']."',
                            '".$paShopDataAddress['FTAddWebsite']."',
                            '".$paShopDataAddress['FTAddLongitude']."',
                            '".$paShopDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paShopDataAddress['FTLastUpdBy']."',
                            '".$paShopDataAddress['FTCreateBy']."'
                        )
            ";
        }else{
            $tSQL   = " INSERT INTO TCNMAddress_L (
                            FNLngID,FTAddGrpType,FTAddRefCode,
                            FTAddName,FTAddTaxNo,FTAddRmk,
                            FTAddVersion,FTAddV2Desc1,FTAddV2Desc2,
                            FTAddWebsite,FTAddLongitude,FTAddLatitude,
                            FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
                        )
                        VALUES (
                            '".$paShopDataAddress['FNLngID']."',
                            '".$paShopDataAddress['FTAddGrpType']."',
                            '".$paShopDataAddress['FTAddRefCode']."',
                            '".$paShopDataAddress['FTAddName']."',
                            '".$paShopDataAddress['FTAddTaxNo']."',
                            '".$paShopDataAddress['FTAddRmk']."',
                            '".$paShopDataAddress['FTAddVersion']."',
                            '".$paShopDataAddress['FTAddV2Desc1']."',
                            '".$paShopDataAddress['FTAddV2Desc2']."',
                            '".$paShopDataAddress['FTAddWebsite']."',
                            '".$paShopDataAddress['FTAddLongitude']."',
                            '".$paShopDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paShopDataAddress['FTLastUpdBy']."',
                            '".$paShopDataAddress['FTCreateBy']."'
                        )
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Shop Address Edit Event
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMShopAddressEditData($paShopDataAddress){
        $tAddressVersion    = $paShopDataAddress['FTAddVersion'];
        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " UPDATE TCNMAddress_L
                        SET
                            FTAddName       = '".$paShopDataAddress['FTAddName']."',
                            FTAddTaxNo      = '".$paShopDataAddress['FTAddTaxNo']."',
                            FTAddRmk        = '".$paShopDataAddress['FTAddRmk']."',
                            FTAddVersion    = '".$paShopDataAddress['FTAddVersion']."',
                            FTAddV1No       = '".$paShopDataAddress['FTAddV1No']."',
                            FTAddV1Soi      = '".$paShopDataAddress['FTAddV1Soi']."',
                            FTAddV1Village  = '".$paShopDataAddress['FTAddV1Village']."',
                            FTAddV1Road     = '".$paShopDataAddress['FTAddV1Road']."',
                            FTAddV1SubDist  = '".$paShopDataAddress['FTAddV1SubDist']."',
                            FTAddV1DstCode  = '".$paShopDataAddress['FTAddV1DstCode']."',
                            FTAddV1PvnCode  = '".$paShopDataAddress['FTAddV1PvnCode']."',
                            FTAddV1PostCode = '".$paShopDataAddress['FTAddV1PostCode']."',
                            FTAddWebsite    = '".$paShopDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paShopDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paShopDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paShopDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paShopDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paShopDataAddress['FTAddGrpType']."'
                        AND FTAddRefCode    = '".$paShopDataAddress['FTAddRefCode']."'
                        AND FNAddSeqNo      = '".$paShopDataAddress['FNAddSeqNo']."'
            ";
        }else{
            $tSQL   = " UPDATE TCNMAddress_L
                        SET
                            FTAddName       = '".$paShopDataAddress['FTAddName']."',
                            FTAddTaxNo      = '".$paShopDataAddress['FTAddTaxNo']."',
                            FTAddVersion    = '".$paShopDataAddress['FTAddVersion']."',
                            FTAddV2Desc1    = '".$paShopDataAddress['FTAddV2Desc1']."',
                            FTAddV2Desc2    = '".$paShopDataAddress['FTAddV2Desc1']."',
                            FTAddWebsite    = '".$paShopDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paShopDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paShopDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paShopDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paShopDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paShopDataAddress['FTAddGrpType']."'
                        AND FTAddRefCode    = '".$paShopDataAddress['FTAddRefCode']."'
                        AND FNAddSeqNo      = '".$paShopDataAddress['FNAddSeqNo']."'
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Shop Address Delete Event
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSaMShopAddressDelete($paDataWhereDelete){
        $tSQL   = " DELETE
                    FROM TCNMAddress_L
                    WHERE 1=1
                    AND FNLngID         = '".$paDataWhereDelete['FNLngID']."'
                    AND FTAddGrpType    = '".$paDataWhereDelete['FTAddGrpType']."'
                    AND FTAddRefCode    = '".$paDataWhereDelete['FTAddRefCode']."'
                    AND FNAddSeqNo      = '".$paDataWhereDelete['FNAddSeqNo']."'
        ";
        $oQuery = $this->db->query($tSQL);
        return;
    }


    


}