<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mLockerInfor extends CI_Model {

    // Functionality: Get Data Locker Status
    // Parameters: Function Controler
    // Creator: 11/11/2019 Wasin(Yoshi)
    // Return: Array Data Locker Status
    // ReturnType: Array
    public function FSaMDLKDataLockerStatus($paDataWhereFilter){
        $tDLKBchCode    = $paDataWhereFilter['FTBchCode'];
        $tDLKMerCode    = $paDataWhereFilter['FTMerCode'];
        $tDLKShopCode   = $paDataWhereFilter['FTShpCode'];
        $nDLKLngID      = $paDataWhereFilter['FNLngID'];

        // Check Brach Filter
        $tSQLWhereBranch    = "";
        if(isset($tDLKBchCode) && !empty($tDLKBchCode)){
            $tSQLWhereBranch    = " AND (LOCKERSTA_DATA.FTBchCode = '".$tDLKBchCode."')";
        }

        // Check Merchant Filter
        $tSQLWhereMerchant  = "";
        if(isset($tDLKMerCode) && !empty($tDLKMerCode)){
            $tSQLWhereMerchant  = " AND (LOCKERSTA_DATA.FTMerCode = '".$tDLKMerCode."')";
        }

        // Check Shop Filter
        $tSQLWhereShop  = "";
        if(isset($tDLKShopCode) && !empty($tDLKShopCode)){
            $tSQLWhereShop  = " AND (LOCKERSTA_DATA.FTShpCode = '".$tDLKShopCode."')";
        }

        $tSQL   = " SELECT
                        LOCKERSTA_DATA.FTBchCode,
                        ISNULL(BCH_L.FTBchName,'N/A') AS FTBchName,
                        LOCKERSTA_DATA.FTMerCode,
                        ISNULL(MER_L.FTMerName,'N/A') AS FTMerName,
                        LOCKERSTA_DATA.FTShpCode,
                        ISNULL(SHP_L.FTShpName,'N/A') AS FTShpName,
                        LOCKERSTA_DATA.FTPosCode,
                        LOCKERSTA_DATA.FNPosStaEmpty,
                        LOCKERSTA_DATA.FNPosStaUse,
                        LOCKERSTA_DATA.FNPosStaNotUse
                    FROM (
                        SELECT
                            SLY.FTBchCode,
                            SLY.FTMerCode,
                            SLY.FTShpCode,
                            SPL.FTPosCode,
                            COUNT(CASE WHEN LSA.FTLayStaUse = 1 OR LSA.FTLayStaUse IS NULL THEN 1 ELSE NULL END) AS FNPosStaEmpty,
                            COUNT(CASE WHEN LSA.FTLayStaUse = 2 THEN 1 ELSE NULL END) AS FNPosStaUse,
                            COUNT(CASE WHEN LSA.FTLayStaUse = 3 THEN 1 ELSE NULL END) AS FNPosStaNotUse
                        FROM TRTMShopLayout SLY WITH(NOLOCK)
                        LEFT JOIN TRTMShopPosLayout SPL WITH(NOLOCK) ON SLY.FTBchCode = SPL.FTBchCode AND SLY.FTShpCode = SPL.FTShpCode AND SLY.FNLayNo = SPL.FNLayNo
                        LEFT JOIN TRTTLockerStatus	LSA WITH(NOLOCK) ON SLY.FTBchCode = LSA.FTBchCode AND SLY.FNLayNo = LSA.FNLayNo
                        GROUP BY SLY.FTBchCode,SLY.FTMerCode,SLY.FTShpCode,SPL.FTPosCode
                    ) AS LOCKERSTA_DATA
                    LEFT JOIN TCNMBranch_L      BCH_L WITH(NOLOCK) ON LOCKERSTA_DATA.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = '".$nDLKLngID."'
                    LEFT JOIN TCNMMerchant_L    MER_L WITH(NOLOCK) ON LOCKERSTA_DATA.FTMerCode = MER_L.FTMerCode AND MER_L.FNLngID = '".$nDLKLngID."'
                    LEFT JOIN TCNMShop_L        SHP_L WITH(NOLOCK) ON LOCKERSTA_DATA.FTShpCode = SHP_L.FTShpCode AND SHP_L.FNLngID = '".$nDLKLngID."'
                    WHERE 1=1
                    ".$tSQLWhereBranch."
                    ".$tSQLWhereMerchant."
                    ".$tSQLWhereShop."
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDLKDataLocker = $oQuery->result_array();
            $aResult        = [
                'raItems'   => $aDLKDataLocker,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            ];
        }else{
            $aResult    = [
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            ];
        }
        unset($tDLKBchCode);
        unset($tDLKMerCode);
        unset($tDLKShopCode);
        unset($nDLKLngID);
        unset($tSQLWhereBranch);
        unset($tSQLWhereMerchant);
        unset($tSQLWhereShop);
        unset($tSQL);
        unset($oQuery);
        unset($aDLKDataLocker);
        return $aResult;
    }




    
}