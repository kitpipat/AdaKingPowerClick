<?php defined('BASEPATH') or exit('No direct script access allowed');

class mSalemachineAddress extends CI_Model {

    // Functionality: Selete Data Salemachine Address List
    // Parameters: function parameters
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: Data Salemachine Address List
    // ReturnType: Array
    public function FSaMSalemachineAddressDataList($paDataWhere){
        $tSQL   = " SELECT
                        ADDL.FNLngID,
                        ADDL.FTAddGrpType,
                        ADDL.FTAddRefCode,
                        ADDL.FNAddSeqNo,
                        ADDL.FTAddRefNo,
                        ADDL.FTAddName,
                        ADDL.FTAddTaxNo,
                        ADDL.FTAddWebsite,
                        ADDL.FTAddRmk,
                        ADDL.FDCreateOn
                    FROM TCNMAddress_L ADDL WITH(NOLOCK)
                    WHERE 1=1 
                    AND ADDL.FTAddGrpType   = 6
                    AND ADDL.FNLngID        = '".$paDataWhere['FNLngID']."'
                    AND ADDL.FTAddRefCode   = '".$paDataWhere['FTAddRefCode']."'
                    ORDER BY FDCreateOn DESC
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

    // Functionality: Salemachine Address Get Version
    // Parameters: function parameters
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: Data Salemachine Address Version Config
    // ReturnType: Array
    public function FSaMSalemachineAddressGetVersion(){
        $tSQL   = " SELECT
                        FTSysStaDefValue,
                        FTSysStaUsrValue  
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE 1=1
                    AND FTSysCode   = 'tCN_AddressType'
                    AND FTSysKey    = 'TCNMPos'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = array();
        }
        return $aResult;
    }

    // Functionality: Salemachine Address Get Data By ID
    // Parameters: function parameters
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: Data Salemachine Address
    // ReturnType: Array
    public function FSaMSalemachineAddressGetDataID($paDataWhereAddress){
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
                    AND ADDL.FNLngID        = '".$paDataWhereAddress['FNLngID']."'
                    AND ADDL.FTAddGrpType   = '".$paDataWhereAddress['FTAddGrpType']."'
                    AND ADDL.FTAddRefCode   = '".$paDataWhereAddress['FTAddRefCode']."'
                    AND ADDL.FNAddSeqNo     = '".$paDataWhereAddress['FNAddSeqNo']."'
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

    // Functionality: Salemachine Address Update Seq
    // Parameters: function parameters
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMSalemachineAddressUpdateSeq($paSalemachineDataAddress){
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
                        AND FNLngID         = '".$paSalemachineDataAddress['FNLngID']."'
                        AND FTAddRefCode    = '".$paSalemachineDataAddress['FTAddRefCode']."'
                        AND FTAddGrpType    = '".$paSalemachineDataAddress['FTAddGrpType']."'
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

    // Functionality: Salemachine Address Add Event
    // Parameters: function parameters
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMSalemachineAddressAddData($paSalemachineDataAddress){
        $tAddressVersion    = $paSalemachineDataAddress['FTAddVersion'];
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
                            '".$paSalemachineDataAddress['FNLngID']."',
                            '".$paSalemachineDataAddress['FTAddGrpType']."',
                            '".$paSalemachineDataAddress['FTAddRefCode']."',
                            '".$paSalemachineDataAddress['FTAddName']."',
                            '".$paSalemachineDataAddress['FTAddTaxNo']."',
                            '".$paSalemachineDataAddress['FTAddRmk']."',
                            '".$paSalemachineDataAddress['FTAddVersion']."',
                            '".$paSalemachineDataAddress['FTAddV1No']."',
                            '".$paSalemachineDataAddress['FTAddV1Soi']."',
                            '".$paSalemachineDataAddress['FTAddV1Village']."',
                            '".$paSalemachineDataAddress['FTAddV1Road']."',
                            '".$paSalemachineDataAddress['FTAddV1SubDist']."',
                            '".$paSalemachineDataAddress['FTAddV1DstCode']."',
                            '".$paSalemachineDataAddress['FTAddV1PvnCode']."',
                            '".$paSalemachineDataAddress['FTAddV1PostCode']."',
                            '".$paSalemachineDataAddress['FTAddWebsite']."',
                            '".$paSalemachineDataAddress['FTAddLongitude']."',
                            '".$paSalemachineDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paSalemachineDataAddress['FTLastUpdBy']."',
                            '".$paSalemachineDataAddress['FTCreateBy']."'
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
                            '".$paSalemachineDataAddress['FNLngID']."',
                            '".$paSalemachineDataAddress['FTAddGrpType']."',
                            '".$paSalemachineDataAddress['FTAddRefCode']."',
                            '".$paSalemachineDataAddress['FTAddName']."',
                            '".$paSalemachineDataAddress['FTAddTaxNo']."',
                            '".$paSalemachineDataAddress['FTAddRmk']."',
                            '".$paSalemachineDataAddress['FTAddVersion']."',
                            '".$paSalemachineDataAddress['FTAddV2Desc1']."',
                            '".$paSalemachineDataAddress['FTAddV2Desc2']."',
                            '".$paSalemachineDataAddress['FTAddWebsite']."',
                            '".$paSalemachineDataAddress['FTAddLongitude']."',
                            '".$paSalemachineDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paSalemachineDataAddress['FTLastUpdBy']."',
                            '".$paSalemachineDataAddress['FTCreateBy']."'
                        )
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Salemachine Address Edit Event
    // Parameters: function parameters
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMSalemachineAddressEditData($paSalemachineDataAddress){
        $tAddressVersion    = $paSalemachineDataAddress['FTAddVersion'];
        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " UPDATE TCNMAddress_L
                        SET
                            FTAddName       = '".$paSalemachineDataAddress['FTAddName']."',
                            FTAddTaxNo      = '".$paSalemachineDataAddress['FTAddTaxNo']."',
                            FTAddRmk        = '".$paSalemachineDataAddress['FTAddRmk']."',
                            FTAddVersion    = '".$paSalemachineDataAddress['FTAddVersion']."',
                            FTAddV1No       = '".$paSalemachineDataAddress['FTAddV1No']."',
                            FTAddV1Soi      = '".$paSalemachineDataAddress['FTAddV1Soi']."',
                            FTAddV1Village  = '".$paSalemachineDataAddress['FTAddV1Village']."',
                            FTAddV1Road     = '".$paSalemachineDataAddress['FTAddV1Road']."',
                            FTAddV1SubDist  = '".$paSalemachineDataAddress['FTAddV1SubDist']."',
                            FTAddV1DstCode  = '".$paSalemachineDataAddress['FTAddV1DstCode']."',
                            FTAddV1PvnCode  = '".$paSalemachineDataAddress['FTAddV1PvnCode']."',
                            FTAddV1PostCode = '".$paSalemachineDataAddress['FTAddV1PostCode']."',
                            FTAddWebsite    = '".$paSalemachineDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paSalemachineDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paSalemachineDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paSalemachineDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paSalemachineDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paSalemachineDataAddress['FTAddGrpType']."'
                        AND FTAddRefCode    = '".$paSalemachineDataAddress['FTAddRefCode']."'
                        AND FNAddSeqNo      = '".$paSalemachineDataAddress['FNAddSeqNo']."'
            ";
        }else{
            $tSQL   = " UPDATE TCNMAddress_L
                        SET
                            FTAddName       = '".$paSalemachineDataAddress['FTAddName']."',
                            FTAddTaxNo      = '".$paSalemachineDataAddress['FTAddTaxNo']."',
                            FTAddVersion    = '".$paSalemachineDataAddress['FTAddVersion']."',
                            FTAddV2Desc1    = '".$paSalemachineDataAddress['FTAddV2Desc1']."',
                            FTAddV2Desc2    = '".$paSalemachineDataAddress['FTAddV2Desc1']."',
                            FTAddWebsite    = '".$paSalemachineDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paSalemachineDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paSalemachineDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paSalemachineDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paSalemachineDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paSalemachineDataAddress['FTAddGrpType']."'
                        AND FTAddRefCode    = '".$paSalemachineDataAddress['FTAddRefCode']."'
                        AND FNAddSeqNo      = '".$paSalemachineDataAddress['FNAddSeqNo']."'
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Salemachine Address Delete Event
    // Parameters: function parameters
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSaMSalemachineAddressDelete($paDataWhereDelete){
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