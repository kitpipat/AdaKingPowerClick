<?php defined('BASEPATH') or exit('No direct script access allowed');

class mCourierAddress extends CI_Model {

    // Functionality: Selete Data Courier Address List
    // Parameters: function parameters
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: Data Courier Address List
    // ReturnType: Array
    public function FSaMCourierAddressDataList($paDataWhere){
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
                    AND ADDL.FTAddGrpType   = 8
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

    // Functionality: Courier Address Get Version
    // Parameters: function parameters
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: Data Courier Address Version Config
    // ReturnType: Array
    public function FSaMCourierAddressGetVersion(){
        $tSQL   = " SELECT
                        FTSysStaDefValue,
                        FTSysStaUsrValue  
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE 1=1
                    AND FTSysCode   = 'tCN_AddressType'
                    AND FTSysKey    = 'TCNMCourier'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = array();
        }
        return $aResult;
    }

    // Functionality: Courier Address Get Data By ID
    // Parameters: function parameters
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: Data Courier Address
    // ReturnType: Array
    public function FSaMCourierAddressGetDataID($paDataWhereAddress){
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

    // Functionality: Courier Address Update Seq
    // Parameters: function parameters
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMCourierAddressUpdateSeq($paCourierDataAddress){
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
                        AND FNLngID         = '".$paCourierDataAddress['FNLngID']."'
                        AND FTAddRefCode    = '".$paCourierDataAddress['FTAddRefCode']."'
                        AND FTAddGrpType    = '".$paCourierDataAddress['FTAddGrpType']."'
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

    // Functionality: Courier Address Add Event
    // Parameters: function parameters
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMCourierAddressAddData($paCourierDataAddress){
        $tAddressVersion    = $paCourierDataAddress['FTAddVersion'];
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
                            '".$paCourierDataAddress['FNLngID']."',
                            '".$paCourierDataAddress['FTAddGrpType']."',
                            '".$paCourierDataAddress['FTAddRefCode']."',
                            '".$paCourierDataAddress['FTAddName']."',
                            '".$paCourierDataAddress['FTAddTaxNo']."',
                            '".$paCourierDataAddress['FTAddRmk']."',
                            '".$paCourierDataAddress['FTAddVersion']."',
                            '".$paCourierDataAddress['FTAddV1No']."',
                            '".$paCourierDataAddress['FTAddV1Soi']."',
                            '".$paCourierDataAddress['FTAddV1Village']."',
                            '".$paCourierDataAddress['FTAddV1Road']."',
                            '".$paCourierDataAddress['FTAddV1SubDist']."',
                            '".$paCourierDataAddress['FTAddV1DstCode']."',
                            '".$paCourierDataAddress['FTAddV1PvnCode']."',
                            '".$paCourierDataAddress['FTAddV1PostCode']."',
                            '".$paCourierDataAddress['FTAddWebsite']."',
                            '".$paCourierDataAddress['FTAddLongitude']."',
                            '".$paCourierDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paCourierDataAddress['FTLastUpdBy']."',
                            '".$paCourierDataAddress['FTCreateBy']."'
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
                            '".$paCourierDataAddress['FNLngID']."',
                            '".$paCourierDataAddress['FTAddGrpType']."',
                            '".$paCourierDataAddress['FTAddRefCode']."',
                            '".$paCourierDataAddress['FTAddName']."',
                            '".$paCourierDataAddress['FTAddTaxNo']."',
                            '".$paCourierDataAddress['FTAddRmk']."',
                            '".$paCourierDataAddress['FTAddVersion']."',
                            '".$paCourierDataAddress['FTAddV2Desc1']."',
                            '".$paCourierDataAddress['FTAddV2Desc2']."',
                            '".$paCourierDataAddress['FTAddWebsite']."',
                            '".$paCourierDataAddress['FTAddLongitude']."',
                            '".$paCourierDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paCourierDataAddress['FTLastUpdBy']."',
                            '".$paCourierDataAddress['FTCreateBy']."'
                        )
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Courier Address Edit Event
    // Parameters: function parameters
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMCourierAddressEditData($paCourierDataAddress){
        $tAddressVersion    = $paCourierDataAddress['FTAddVersion'];
        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " UPDATE TCNMAddress_L
                        SET
                            FTAddName       = '".$paCourierDataAddress['FTAddName']."',
                            FTAddTaxNo      = '".$paCourierDataAddress['FTAddTaxNo']."',
                            FTAddRmk        = '".$paCourierDataAddress['FTAddRmk']."',
                            FTAddVersion    = '".$paCourierDataAddress['FTAddVersion']."',
                            FTAddV1No       = '".$paCourierDataAddress['FTAddV1No']."',
                            FTAddV1Soi      = '".$paCourierDataAddress['FTAddV1Soi']."',
                            FTAddV1Village  = '".$paCourierDataAddress['FTAddV1Village']."',
                            FTAddV1Road     = '".$paCourierDataAddress['FTAddV1Road']."',
                            FTAddV1SubDist  = '".$paCourierDataAddress['FTAddV1SubDist']."',
                            FTAddV1DstCode  = '".$paCourierDataAddress['FTAddV1DstCode']."',
                            FTAddV1PvnCode  = '".$paCourierDataAddress['FTAddV1PvnCode']."',
                            FTAddV1PostCode = '".$paCourierDataAddress['FTAddV1PostCode']."',
                            FTAddWebsite    = '".$paCourierDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paCourierDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paCourierDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paCourierDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paCourierDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paCourierDataAddress['FTAddGrpType']."'
                        AND FTAddRefCode    = '".$paCourierDataAddress['FTAddRefCode']."'
                        AND FNAddSeqNo      = '".$paCourierDataAddress['FNAddSeqNo']."'
            ";
        }else{
            $tSQL   = " UPDATE TCNMAddress_L
                        SET
                            FTAddName       = '".$paCourierDataAddress['FTAddName']."',
                            FTAddTaxNo      = '".$paCourierDataAddress['FTAddTaxNo']."',
                            FTAddVersion    = '".$paCourierDataAddress['FTAddVersion']."',
                            FTAddV2Desc1    = '".$paCourierDataAddress['FTAddV2Desc1']."',
                            FTAddV2Desc2    = '".$paCourierDataAddress['FTAddV2Desc1']."',
                            FTAddWebsite    = '".$paCourierDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paCourierDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paCourierDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paCourierDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paCourierDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paCourierDataAddress['FTAddGrpType']."'
                        AND FTAddRefCode    = '".$paCourierDataAddress['FTAddRefCode']."'
                        AND FNAddSeqNo      = '".$paCourierDataAddress['FNAddSeqNo']."'
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Courier Address Delete Event
    // Parameters: function parameters
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSaMCourierAddressDelete($paDataWhereDelete){
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