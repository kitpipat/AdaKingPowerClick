<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCustomerAddress extends CI_Model{

    // Functionality: Selete Data Customer Address List
    // Parameters: function parameters
    // Creator: 07/11/2019 Wasin(Yoshi)
    // Return: Data Customer Address List
    // ReturnType: Array
    public function FSaMCSTAddressDataList($paDataWhere){
        $tSQL   = " SELECT
                        CSTA.FTCstCode,
                        CSTA.FNLngID,
                        CSTA.FTAddGrpType,
                        CSTA.FNAddSeqNo,
                        CSTA.FTAddRefNo,
                        CSTA.FTAddName,
                        CSTA.FTAddCountry,
                        CSTA.FTAddWebsite,
                        CSTA.FTAddRmk
                    FROM TCNMCstAddress_L CSTA WITH(NOLOCK)
                    WHERE 1=1
                    AND CSTA.FTAddGrpType   <> 4
                    AND CSTA.FNLngID        = '".$paDataWhere['FNLngID']."'
                    AND CSTA.FTCstCode      = '".$paDataWhere['FTCstCode']."'
                    ORDER BY CSTA.FNAddSeqNo ASC
        ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataReturn    = $oQuery->result_array();
        }else{
            $aDataReturn    = [];
        }
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Customer Address Get Version
    // Parameters: function parameters
    // Creator: 07/11/2019 Wasin(Yoshi)
    // Return: Data Customer Address Version Config
    // ReturnType: Array
    public function FSaMCSTAddressGetVersion(){
        $tSQL   = " SELECT
                        FTSysStaDefValue,
                        FTSysStaUsrValue
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE 1=1
                    AND FTSysCode   = 'tCN_AddressType'
                    AND FTSysKey    = 'TCNMCst'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = [];
        }
        unset($tSQL);
        unset($oQuery);
        return $aResult;
    }
    
    // Functionality: Customer Address Get Data By ID
    // Parameters: function parameters
    // Creator: 11/11/2019 Wasin(Yoshi)
    // Return: Data Shop Address
    // ReturnType: Array
    public function FSaMCSTAddressGetDataID($paDataWhereAddress){
        $tSQL   = " SELECT
                        CSTA.FTCstCode,
                        CSTA.FNLngID,
                        CSTA.FTAddGrpType,
                        CSTA.FNAddSeqNo,
                        CSTA.FTAddRefNo,
                        CSTA.FTAddName,
                        CSTA.FTAddRmk,
                        CSTA.FTAddCountry,
                        CSTA.FTAreCode,
                        AREL.FTAreName,
                        ZNEL.FTZneCode,
                        ZNEL.FTZneName,
                        CSTA.FTZneCode AS FTZneChain,
                        ZNEL.FTZneChainName,
                        CSTA.FTAddVersion,
                        CSTA.FTAddV1No,
                        CSTA.FTAddV1Soi,
                        CSTA.FTAddV1Village,
                        CSTA.FTAddV1Road,
                        CSTA.FTAddV1SubDist AS FTSudCode,
                        SDSTL.FTSudName,
                        CSTA.FTAddV1DstCode AS FTDstCode,
                        DSTL.FTDstName,
                        CSTA.FTAddV1PvnCode AS FTPvnCode,
                        PVNL.FTPvnName,
                        CSTA.FTAddV1PostCode,
                        CSTA.FTAddV2Desc1,
                        CSTA.FTAddV2Desc2,
                        CSTA.FTAddWebsite,
                        CSTA.FTAddLongitude,
                        CSTA.FTAddLatitude
                    FROM TCNMCstAddress_L       CSTA WITH(NOLOCK)
                    LEFT JOIN TCNMArea_L        AREL WITH(NOLOCK)   ON CSTA.FTAreCode       = AREL.FTAreCode    AND AREL.FNLngID    = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMZone_L        ZNEL WITH(NOLOCK)   ON CSTA.FTZneCode       = ZNEL.FTZneChain   AND ZNEL.FNLngID    = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMSubDistrict_L SDSTL WITH(NOLOCK)  ON CSTA.FTAddV1SubDist  = SDSTL.FTSudCode   AND SDSTL.FNLngID   = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMDistrict_L    DSTL WITH(NOLOCK)   ON CSTA.FTAddV1DstCode  = DSTL.FTDstCode    AND DSTL.FNLngID    = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMProvince_L    PVNL WITH(NOLOCK)   ON CSTA.FTAddV1PvnCode  = PVNL.FTPvnCode    AND PVNL.FNLngID    = '".$paDataWhereAddress['FNLngID']."'
                    WHERE 1=1
                    AND CSTA.FTCstCode      = '".$paDataWhereAddress['FTCstCode']."'
                    AND CSTA.FNLngID        = '".$paDataWhereAddress['FNLngID']."'
                    AND CSTA.FTAddGrpType   = '".$paDataWhereAddress['FTAddGrpType']."'
                    AND CSTA.FNAddSeqNo     = '".$paDataWhereAddress['FNAddSeqNo']."'
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

    // Functionality: Customer Address Update Seq
    // Parameters: function parameters
    // Creator: 11/11/2019 Wasin(Yoshi)
    // Return: Updaet Seq Address
    // ReturnType: None Response
    public function FSxMCSTAddressUpdateSeq($paCSTDataAddress){
        $tSQL   = " UPDATE ADDRUPD
                    SET	ADDRUPD.FTAddRefNo = DATARUNSEQ.FTAddRefNo
                    FROM TCNMCstAddress_L AS ADDRUPD WITH(ROWLOCK)
                    INNER JOIN (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FNAddSeqNo ASC) AS FTAddRefNo,
                            FTCstCode,
                            FNLngID,
                            FTAddGrpType,
                            FNAddSeqNo
                        FROM TCNMCstAddress_L WITH(NOLOCK)
                        WHERE 1=1
                        AND FTCstCode       = '".$paCSTDataAddress['FTCstCode']."'
                        AND FNLngID         = '".$paCSTDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paCSTDataAddress['FTAddGrpType']."'
                    ) AS DATARUNSEQ
                    ON 1=1
                    AND ADDRUPD.FTCstCode       = DATARUNSEQ.FTCstCode
                    AND ADDRUPD.FNLngID         = DATARUNSEQ.FNLngID
                    AND ADDRUPD.FTAddGrpType    = DATARUNSEQ.FTAddGrpType
                    AND ADDRUPD.FNAddSeqNo      = DATARUNSEQ.FNAddSeqNo
        ";

        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Customer Address Add Event
    // Parameters: function parameters
    // Creator: 11/11/2019 Wasin(Yoshi)
    // Return: Insert Data Address
    // ReturnType: None Response
    public function FSxMCSTAddressAddData($paCSTDataAddress){
        $tAddressVersion    = $paCSTDataAddress['FTAddVersion'];
        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " INSERT INTO TCNMCstAddress_L (
                            FTCstCode,FNLngID,FTAddGrpType,FTAddName,FTAddRmk,FTAreCode,FTZneCode,FTAddVersion,FTAddV1No,
                            FTAddV1Soi,FTAddV1Village,FTAddV1Road,FTAddV1SubDist,FTAddV1DstCode,FTAddV1PvnCode,FTAddV1PostCode,
                            FTAddWebsite,FTAddLongitude,FTAddLatitude,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                        )
                        VALUES (
                            '".$paCSTDataAddress['FTCstCode']."',
                            '".$paCSTDataAddress['FNLngID']."',
                            '".$paCSTDataAddress['FTAddGrpType']."',
                            '".$paCSTDataAddress['FTAddName']."',
                            '".$paCSTDataAddress['FTAddRmk']."',
                            '".$paCSTDataAddress['FTAreCode']."',
                            '".$paCSTDataAddress['FTZneCode']."',
                            '".$paCSTDataAddress['FTAddVersion']."',
                            '".$paCSTDataAddress['FTAddV1No']."',
                            '".$paCSTDataAddress['FTAddV1Soi']."',
                            '".$paCSTDataAddress['FTAddV1Village']."',
                            '".$paCSTDataAddress['FTAddV1Road']."',
                            '".$paCSTDataAddress['FTAddV1SubDist']."',
                            '".$paCSTDataAddress['FTAddV1DstCode']."',
                            '".$paCSTDataAddress['FTAddV1PvnCode']."',
                            '".$paCSTDataAddress['FTAddV1PostCode']."',
                            '".$paCSTDataAddress['FTAddWebsite']."',
                            '".$paCSTDataAddress['FTAddLongitude']."',
                            '".$paCSTDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            '".$paCSTDataAddress['FTLastUpdBy']."',
                            GETDATE(),
                            '".$paCSTDataAddress['FTCreateBy']."'
                        )
            ";
        }else{
            $tSQL   = " INSERT INTO TCNMCstAddress_L (
                            FTCstCode,FNLngID,FTAddGrpType,FTAddName,FTAddRmk,FTAreCode,FTZneCode,FTAddVersion,
                            FTAddV2Desc1,FTAddV2Desc2,FTAddWebsite,FTAddLongitude,FTAddLatitude,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FTAddRefNo
                        )
                        VALUES (
                            '".$paCSTDataAddress['FTCstCode']."',
                            '".$paCSTDataAddress['FNLngID']."',
                            '".$paCSTDataAddress['FTAddGrpType']."',
                            '".$paCSTDataAddress['FTAddName']."',
                            '".$paCSTDataAddress['FTAddRmk']."',
                            '".$paCSTDataAddress['FTAreCode']."',
                            '".$paCSTDataAddress['FTZneCode']."',
                            '".$paCSTDataAddress['FTAddVersion']."',
                            '".$paCSTDataAddress['FTAddV2Desc1']."',
                            '".$paCSTDataAddress['FTAddV2Desc2']."',
                            '".$paCSTDataAddress['FTAddWebsite']."',
                            '".$paCSTDataAddress['FTAddLongitude']."',
                            '".$paCSTDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            '".$paCSTDataAddress['FTLastUpdBy']."',
                            GETDATE(),
                            '".$paCSTDataAddress['FTCreateBy']."',
                            '".$paCSTDataAddress['FTAddRefNo']."'
                        )
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    

    // Functionality: Customer Address Edit Event
    // Parameters: function parameters
    // Creator: 11/11/2019 Wasin(Yoshi)
    // Return: Update Data Address
    // ReturnType: None Response
    public function FSxMCSTAddressEditData($paCSTDataAddress){
       
        $tAddressVersion    = $paCSTDataAddress['FTAddVersion'];

        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " UPDATE CSTA_UPD
                        SET 
                            CSTA_UPD.FTAddName          = '".$paCSTDataAddress['FTAddName']."',
                            CSTA_UPD.FTAddRmk           = '".$paCSTDataAddress['FTAddRmk']."',
                            CSTA_UPD.FTAreCode          = '".$paCSTDataAddress['FTAreCode']."',
                            CSTA_UPD.FTZneCode          = '".$paCSTDataAddress['FTZneCode']."',
                            CSTA_UPD.FTAddVersion       = '".$paCSTDataAddress['FTAddVersion']."',
                            CSTA_UPD.FTAddV1No          = '".$paCSTDataAddress['FTAddV1No']."',
                            CSTA_UPD.FTAddV1Soi         = '".$paCSTDataAddress['FTAddV1Soi']."',
                            CSTA_UPD.FTAddV1Village     = '".$paCSTDataAddress['FTAddV1Village']."',
                            CSTA_UPD.FTAddGrpType       = '".$paCSTDataAddress['FTAddGrpType']."',
                            CSTA_UPD.FTAddV1Road        = '".$paCSTDataAddress['FTAddV1Road']."',
                            CSTA_UPD.FTAddV1SubDist     = '".$paCSTDataAddress['FTAddV1SubDist']."',
                            CSTA_UPD.FTAddV1DstCode     = '".$paCSTDataAddress['FTAddV1DstCode']."',
                            CSTA_UPD.FTAddV1PvnCode     = '".$paCSTDataAddress['FTAddV1PvnCode']."',
                            CSTA_UPD.FTAddV1PostCode    = '".$paCSTDataAddress['FTAddV1PostCode']."',
                            CSTA_UPD.FTAddWebsite       = '".$paCSTDataAddress['FTAddWebsite']."',
                            CSTA_UPD.FTAddLongitude     = '".$paCSTDataAddress['FTAddLongitude']."',
                            CSTA_UPD.FTAddLatitude      = '".$paCSTDataAddress['FTAddLatitude']."',
                            CSTA_UPD.FDLastUpdOn        = GETDATE(),
                            CSTA_UPD.FTLastUpdBy        = '".$paCSTDataAddress['FTLastUpdBy']."'
                        FROM TCNMCstAddress_L AS CSTA_UPD WITH(ROWLOCK)
                        WHERE 1=1
                        AND CSTA_UPD.FTCstCode       = '".$paCSTDataAddress['FTCstCode']."'
                        AND CSTA_UPD.FNLngID         = '".$paCSTDataAddress['FNLngID']."'
                        AND CSTA_UPD.FNAddSeqNo      = '".$paCSTDataAddress['FNAddSeqNo']."'
            ";
        }else{
            $tSQL   = " UPDATE CSTA_UPD
                        SET
                            CSTA_UPD.FTAddName      = '".$paCSTDataAddress['FTAddName']."',
                            CSTA_UPD.FTAddRmk       = '".$paCSTDataAddress['FTAddRmk']."',
                            CSTA_UPD.FTAreCode      = '".$paCSTDataAddress['FTAreCode']."',
                            CSTA_UPD.FTZneCode      = '".$paCSTDataAddress['FTZneCode']."',
                            CSTA_UPD.FTAddGrpType   = '".$paCSTDataAddress['FTAddGrpType']."',
                            CSTA_UPD.FTAddRefNo     = '".$paCSTDataAddress['FTAddRefNo']."',
                            CSTA_UPD.FTAddVersion   = '".$paCSTDataAddress['FTAddVersion']."',
                            CSTA_UPD.FTAddV2Desc1   = '".$paCSTDataAddress['FTAddV2Desc1']."',
                            CSTA_UPD.FTAddV2Desc2   = '".$paCSTDataAddress['FTAddV2Desc2']."',
                            CSTA_UPD.FTAddWebsite   = '".$paCSTDataAddress['FTAddWebsite']."',
                            CSTA_UPD.FTAddLongitude = '".$paCSTDataAddress['FTAddLongitude']."',
                            CSTA_UPD.FTAddLatitude  = '".$paCSTDataAddress['FTAddLatitude']."',
                            CSTA_UPD.FDLastUpdOn    = GETDATE(),
                            CSTA_UPD.FTLastUpdBy    = '".$paCSTDataAddress['FTLastUpdBy']."'
                        FROM TCNMCstAddress_L AS CSTA_UPD WITH(ROWLOCK)
                        WHERE 1=1
                        AND CSTA_UPD.FTCstCode       = '".$paCSTDataAddress['FTCstCode']."'
                        AND CSTA_UPD.FNLngID         = '".$paCSTDataAddress['FNLngID']."'
                        AND CSTA_UPD.FNAddSeqNo      = '".$paCSTDataAddress['FNAddSeqNo']."'
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Customer Address Delete Event
    // Parameters: function parameters
    // Creator: 11/11/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSaMCSTAddressDelete($paDataWhereDelete){
        $tSQL   = " DELETE
                    FROM TCNMCstAddress_L WITH(ROWLOCK)
                    WHERE 1=1
                    AND FTCstCode       = '".$paDataWhereDelete['FTCstCode']."'
                    AND FNLngID         = '".$paDataWhereDelete['FNLngID']."'
                    AND FTAddGrpType    = '".$paDataWhereDelete['FTAddGrpType']."'
                    AND FNAddSeqNo      = '".$paDataWhereDelete['FNAddSeqNo']."' 
        ";
        $oQuery = $this->db->query($tSQL);
        return;
    }



    
}