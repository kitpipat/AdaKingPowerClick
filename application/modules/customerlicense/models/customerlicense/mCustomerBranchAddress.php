<?php defined('BASEPATH') or exit('No direct script access allowed');

class mCustomerBranchAddress extends CI_Model {

    // Functionality: Selete Data Branch Address List
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: Data Branch Address List
    // ReturnType: Array
    public function FSaMCustomerBranchAddressDataList($paDataWhere){
        $tSQL   = " SELECT
                        ADDL.FNLngID,
                        ADDL.FTAddGrpType,
                        ADDL.FTAddRefNo,
                        ADDL.FNAddSeqNo,
                        ADDL.FTAddRefNo,
                        ADDL.FTAddName,
                        ADDL.FTAddWebsite,
                        ADDL.FTAddRmk,
                        ADDL.FDCreateOn
                    FROM TCNMCstAddress_L ADDL WITH(NOLOCK)
                    WHERE 1=1
                    AND ADDL.FTAddGrpType   = 4
                    AND ADDL.FNLngID        = '".$paDataWhere['FNLngID']."'
                    AND ADDL.FTCstCode   = '".$paDataWhere['FTCstCode']."'
                    AND ADDL.FTAddRefNo   = '".$paDataWhere['FTAddRefNo']."'
                    ORDER BY FDCreateOn ASC
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

    // Functionality: Branch Address Get Version
    // Parameters: function parameters
    // Creator: 10/09/2019 Wasin(Yoshi)
    // Return: Data Branch Address Version Config
    // ReturnType: Array
    public function FSaMCustomerBranchAddressGetVersion(){
        $tSQL   = " SELECT
                        FTSysStaDefValue,
                        FTSysStaUsrValue  
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE 1=1
                    AND FTSysCode   = 'tCN_AddressType'
                    AND FTSysKey    = 'TCNMBranch'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = array();
        }
        return $aResult;
    }

    // Functionality: Branch Address Get Data By ID
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: Data Branch Address
    // ReturnType: Array
    public function FSaMCustomerBranchAddressGetDataID($paDataWhereAddress){
        $tSQL   = " SELECT DISTINCT
                        ADDL.FNLngID,
                        ADDL.FTAddGrpType,
                        ADDL.FTAddRefNo,
                        ADDL.FNAddSeqNo,
                        ADDL.FTAddRefNo,
                        ADDL.FTAddName,
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
                    FROM TCNMCstAddress_L ADDL WITH(NOLOCK)
                    LEFT JOIN TCNMSubDistrict_L SDSTL WITH(NOLOCK) ON ADDL.FTAddV1SubDist = SDSTL.FTSudCode AND SDSTL.FNLngID = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMDistrict_L DSTL WITH(NOLOCK) ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = '".$paDataWhereAddress['FNLngID']."'
                    LEFT JOIN TCNMProvince_L PVNL WITH(NOLOCK) ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = '".$paDataWhereAddress['FNLngID']."'
                    WHERE 1=1
                    AND ADDL.FNLngID         = '".$paDataWhereAddress['FNLngID']."'
                    AND ADDL.FTAddGrpType    = '".$paDataWhereAddress['FTAddGrpType']."'
                    AND ADDL.FTAddRefNo    = '".$paDataWhereAddress['FTAddRefNo']."'
                    AND ADDL.FNAddSeqNo      = '".$paDataWhereAddress['FNAddSeqNo']."'
                    AND ADDL.FTCstCode      = '".$paDataWhereAddress['FTCstCode']."'
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

    // Functionality: Branch Address Update Seq
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMCustomerBranchAddressUpdateSeq($paBranchDataAddress){
        $tSQL   = " UPDATE ADDRUPD
                        SET	ADDRUPD.FNAddSeqNo = DATARUNSEQ.FNAddSeqNo
                        FROM TCNMCstAddress_L AS ADDRUPD WITH(ROWLOCK)
                        INNER JOIN (
                            SELECT
                                ROW_NUMBER() OVER(ORDER BY FNAddSeqNo ASC) AS FNAddSeqNo,
                                FTAddRefNo,
                                FNLngID,
                                FTAddGrpType
                            FROM TCNMCstAddress_L WITH(NOLOCK)
                            WHERE 1=1
                            AND FTAddRefNo       = '".$paBranchDataAddress['FTAddRefNo']."'
                            AND FNLngID         = '".$paBranchDataAddress['FNLngID']."'
                            AND FTAddGrpType    = '".$paBranchDataAddress['FTAddGrpType']."'
                        ) AS DATARUNSEQ
                        ON 1=1
                        AND ADDRUPD.FTAddRefNo       = DATARUNSEQ.FTAddRefNo
                        AND ADDRUPD.FNLngID         = DATARUNSEQ.FNLngID
                        AND ADDRUPD.FTAddGrpType    = DATARUNSEQ.FTAddGrpType
            
                ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Branch Address Add Event
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMCustomerBranchAddressAddData($paBranchDataAddress){
        $tAddressVersion    = $paBranchDataAddress['FTAddVersion'];
        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " INSERT INTO TCNMCstAddress_L (
                            FTCstCode,
                            FNLngID,FTAddGrpType,FTAddRefNo,
                            FTAddName,FTAddRmk,FTAreCode,FTZneCode,
                            FTAddVersion,FTAddV1No,FTAddV1Soi,
                            FTAddV1Village,FTAddV1Road,FTAddV1SubDist,
                            FTAddV1DstCode,FTAddV1PvnCode,FTAddV1PostCode,
                            FTAddWebsite,FTAddLongitude,FTAddLatitude,
                            FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
                        )
                        VALUES (
                            '".$paBranchDataAddress['FTCstCode']."',
                            '".$paBranchDataAddress['FNLngID']."',
                            '".$paBranchDataAddress['FTAddGrpType']."',
                            '".$paBranchDataAddress['FTAddRefNo']."',
                            '".$paBranchDataAddress['FTAddName']."',
                            '".$paBranchDataAddress['FTAddRmk']."',
                            '".$paBranchDataAddress['FTAreCode']."',
                            '".$paBranchDataAddress['FTZneCode']."',
                            '".$paBranchDataAddress['FTAddVersion']."',
                            '".$paBranchDataAddress['FTAddV1No']."',
                            '".$paBranchDataAddress['FTAddV1Soi']."',
                            '".$paBranchDataAddress['FTAddV1Village']."',
                            '".$paBranchDataAddress['FTAddV1Road']."',
                            '".$paBranchDataAddress['FTAddV1SubDist']."',
                            '".$paBranchDataAddress['FTAddV1DstCode']."',
                            '".$paBranchDataAddress['FTAddV1PvnCode']."',
                            '".$paBranchDataAddress['FTAddV1PostCode']."',
                            '".$paBranchDataAddress['FTAddWebsite']."',
                            '".$paBranchDataAddress['FTAddLongitude']."',
                            '".$paBranchDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paBranchDataAddress['FTLastUpdBy']."',
                            '".$paBranchDataAddress['FTCreateBy']."'
                        )
            ";
        }else{
            $tSQL   = " INSERT INTO TCNMCstAddress_L (
                            FTCstCode,
                            FNLngID,FTAddGrpType,FTAddRefNo,
                            FTAddName,FTAddRmk,FTAreCode,
                            FTAddVersion,FTAddV2Desc1,FTAddV2Desc2,
                            FTAddWebsite,FTAddLongitude,FTAddLatitude,
                            FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
                        )
                        VALUES (
                            '".$paBranchDataAddress['FTCstCode']."',
                            '".$paBranchDataAddress['FNLngID']."',
                            '".$paBranchDataAddress['FTAddGrpType']."',
                            '".$paBranchDataAddress['FTAddRefNo']."',
                            '".$paBranchDataAddress['FTAddName']."',
                            '".$paBranchDataAddress['FTAddRmk']."',
                            '".$paBranchDataAddress['FTAreCode']."',
                            '".$paBranchDataAddress['FTZneCode']."',
                            '".$paBranchDataAddress['FTAddVersion']."',
                            '".$paBranchDataAddress['FTAddV2Desc1']."',
                            '".$paBranchDataAddress['FTAddV2Desc2']."',
                            '".$paBranchDataAddress['FTAddWebsite']."',
                            '".$paBranchDataAddress['FTAddLongitude']."',
                            '".$paBranchDataAddress['FTAddLatitude']."',
                            GETDATE(),
                            GETDATE(),
                            '".$paBranchDataAddress['FTLastUpdBy']."',
                            '".$paBranchDataAddress['FTCreateBy']."'
                        )
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Branch Address Edit Event
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSxMCustomerBranchAddressEditData($paBranchDataAddress){
        $tAddressVersion    = $paBranchDataAddress['FTAddVersion'];
        if(isset($tAddressVersion) && $tAddressVersion == 1){
            $tSQL   = " UPDATE TCNMCstAddress_L
                        SET
                            FTAddName       = '".$paBranchDataAddress['FTAddName']."',
                            FTAddRmk        = '".$paBranchDataAddress['FTAddRmk']."',
                            FTAddVersion    = '".$paBranchDataAddress['FTAddVersion']."',
                            FTAddV1No       = '".$paBranchDataAddress['FTAddV1No']."',
                            FTAddV1Soi      = '".$paBranchDataAddress['FTAddV1Soi']."',
                            FTAddV1Village  = '".$paBranchDataAddress['FTAddV1Village']."',
                            FTAddV1Road     = '".$paBranchDataAddress['FTAddV1Road']."',
                            FTAddV1SubDist  = '".$paBranchDataAddress['FTAddV1SubDist']."',
                            FTAddV1DstCode  = '".$paBranchDataAddress['FTAddV1DstCode']."',
                            FTAddV1PvnCode  = '".$paBranchDataAddress['FTAddV1PvnCode']."',
                            FTAddV1PostCode = '".$paBranchDataAddress['FTAddV1PostCode']."',
                            FTAddWebsite    = '".$paBranchDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paBranchDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paBranchDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paBranchDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paBranchDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paBranchDataAddress['FTAddGrpType']."'
                        AND FTAddRefNo    = '".$paBranchDataAddress['FTAddRefNo']."'
                        AND FNAddSeqNo      = '".$paBranchDataAddress['FNAddSeqNo']."'
                        AND FTCstCode       = '".$paBranchDataAddress['FTCstCode']."'
            ";
        }else{
            $tSQL   = " UPDATE TCNMCstAddress_L
                        SET
                            FTAddName       = '".$paBranchDataAddress['FTAddName']."',
                            FTAddVersion    = '".$paBranchDataAddress['FTAddVersion']."',
                            FTAddV2Desc1    = '".$paBranchDataAddress['FTAddV2Desc1']."',
                            FTAddV2Desc2    = '".$paBranchDataAddress['FTAddV2Desc1']."',
                            FTAddWebsite    = '".$paBranchDataAddress['FTAddWebsite']."',
                            FTAddLongitude  = '".$paBranchDataAddress['FTAddLongitude']."',
                            FTAddLatitude   = '".$paBranchDataAddress['FTAddLatitude']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paBranchDataAddress['FTLastUpdBy']."'
                        WHERE 1=1
                        AND FNLngID         = '".$paBranchDataAddress['FNLngID']."'
                        AND FTAddGrpType    = '".$paBranchDataAddress['FTAddGrpType']."'
                        AND FTAddRefNo    = '".$paBranchDataAddress['FTAddRefNo']."'
                        AND FNAddSeqNo      = '".$paBranchDataAddress['FNAddSeqNo']."'
                        AND FTCstCode       = '".$paBranchDataAddress['FTCstCode']."'
            ";
        }
        $oQuery = $this->db->query($tSQL);
        return;
    }

    // Functionality: Branch Address Delete Event
    // Parameters: function parameters
    // Creator: 11/09/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    public function FSaMCustomerBranchAddressDelete($paDataWhereDelete){
        $tSQL   = " DELETE
                    FROM TCNMCstAddress_L
                    WHERE 1=1
                    AND FNLngID         = '".$paDataWhereDelete['FNLngID']."'
                    AND FTAddGrpType    = '".$paDataWhereDelete['FTAddGrpType']."'
                    AND FTAddRefNo    = '".$paDataWhereDelete['FTAddRefNo']."'
                    AND FNAddSeqNo      = '".$paDataWhereDelete['FNAddSeqNo']."'
                    AND FTCstCode       = '".$paDataWhereDelete['FTCstCode']."'
        ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    

}