<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBookingLocker extends CI_Model {
    
    // Functionality: Get Data Detail Rack
    // Parameters: Function Controler
    // Creator: 31/10/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSaMBKLGetDetailDataRack($paDataFilter){
        $tBKLBchCode        = $paDataFilter['FTBchCode'];
        $tBKLShpCode        = $paDataFilter['FTShpCode'];
        $tBKLPosCode        = $paDataFilter['FTPosCode'];
        $tBKLRakCode        = $paDataFilter['FTRakCode'];
        $nBKLLngID          = $paDataFilter['FNLngID'];
        $nTimeExpOnline     = $paDataFilter['FNTimeExpOnline'];
        $nTimeExpOffline    = $paDataFilter['FNTimeExpOffline'];
        
        // Check Rack Data Where
        $tWhereRack = "";
        if(isset($tBKLRakCode) && !empty($tBKLRakCode)){
            $tWhereRack = " AND SLY.FTRakCode = '".$tBKLRakCode."'";
        }

        $tSQL           = " SELECT
                                RAKSTADATA.*,
                                CASE WHEN BKLDATA.FNBkgDocID IS NULL THEN 0 ELSE 1 END AS FNStaBooking
                            FROM (
                                SELECT DISTINCT
                                    SLY.FTBchCode,
                                    SLY.FTShpCode,
                                    SPL.FTPosCode,
                                    SLY.FTPzeCode,
                                    SLY.FTRakCode,
                                    SLY.FNLayNo,
                                    SLY.FNLayScaleX,
                                    SLY.FNLayScaleY,
                                    SLY.FNLayRow,
                                    SLY.FNLayCol,
                                    SLY.FTLayStaUse,
                                    SLYL.FTLayName,
                                    ISNULL(LSA.FTLayStaUse,1) AS FTRackStatus
                                FROM TRTMShopLayout         SLY     WITH(NOLOCK)
                                LEFT JOIN TRTMShopLayout_L  SLYL	WITH(NOLOCK) ON SLY.FTBchCode = SLYL.FTBchCode  AND SLY.FTShpCode = SLYL.FTShpCode AND SLY.FNLayNo = SLYL.FNLayNo AND SLYL.FNLngID = $nBKLLngID
                                LEFT JOIN TRTMShopPosLayout SPL		WITH(NOLOCK) ON SLY.FTBchCode = SPL.FTBchCode 	AND SLY.FTShpCode = SPL.FTShpCode AND SLY.FNLayNo = SPL.FNLayNo
                                LEFT JOIN TRTTLockerStatus 	LSA 	WITH(NOLOCK) ON SPL.FTPosCode = LSA.FTPosCode 	AND SPL.FTBchCode = LSA.FTBchCode AND SPL.FNLayNo = LSA.FNLayNo
                                WHERE 1=1
                                AND SLY.FTBchCode 	= '$tBKLBchCode'
                                AND SLY.FTShpCode	= '$tBKLShpCode'
                                AND SPL.FTPosCode	= '$tBKLPosCode'
                                ".$tWhereRack."
                            ) AS RAKSTADATA
                            LEFT JOIN (
                                SELECT
                                    BKL.FNBkgDocID,
                                    BKL.FTBkgToBch,
                                    BKL.FTBkgToPos,
                                    BKL.FNBkgToLayNo,
                                    BKL.FTBkgRefSale
                                FROM TRTTBooking BKL WITH(NOLOCK)
                                WHERE 1=1
                                AND (BKL.FTBkgStaBook = 1)
                                AND (BKL.FTBkgRefSale IS NULL OR BKL.FTBkgRefSale = '')
                                AND (GETDATE() <= CASE	WHEN BKL.FTBkgProducer = 'AdaStoreBack' THEN DATEADD(MINUTE,$nTimeExpOnline,BKL.FDBkgToStart) WHEN BKL.FTBkgProducer = 'AdaSmartLocker'	THEN DATEADD(MINUTE,$nTimeExpOffline,BKL.FDBkgToStart) END)
                            ) AS BKLDATA ON RAKSTADATA.FTBchCode = BKLDATA.FTBkgToBch AND RAKSTADATA.FTPosCode = BKLDATA.FTBkgToPos AND RAKSTADATA.FNLayNo = BKLDATA.FNBkgToLayNo
                            ORDER BY RAKSTADATA.FTBchCode ASC,RAKSTADATA.FTShpCode ASC,RAKSTADATA.FTPosCode ASC,RAKSTADATA.FTRakCode ASC,RAKSTADATA.FNLayCol ASC,RAKSTADATA.FNLayRow ASC
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataRack  = $oQuery->result_array();
            $aResult    = [
                'raItems'   => $aDataRack,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            ];
        }else{
            $aResult    = [
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            ];
        }
        unset($tBKLBchCode);
        unset($tBKLShpCode);
        unset($tBKLPosCode);
        unset($tBKLRakCode);
        unset($nBKLLngID);
        unset($tSQL);
        unset($oQuery);
        unset($aDataRack);
        return $aResult;
    }

    // Functionality: Get Data Detail LayOut
    // Parameters: Function Controler
    // Creator: 01/11/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSaMBKLGetDataDetailLayOut($paDataFilter){
        $tBKLBchCode        = $paDataFilter['FTBchCode'];
        $tBKLShpCode        = $paDataFilter['FTShpCode'];
        $tBKLPosCode        = $paDataFilter['FTPosCode'];
        $tBKLRakCode        = $paDataFilter['FTRakCode'];
        $tBKLLayNo          = $paDataFilter['FNLayNo'];
        $nBKLLngID          = $paDataFilter['FNLngID'];
        $nTimeExpOnline     = $paDataFilter['FNTimeExpOnline'];
        $nTimeExpOffline    = $paDataFilter['FNTimeExpOffline'];

        // Check Rack Data Where
        $tWhereRack = "";
        if(isset($tBKLRakCode) && !empty($tBKLRakCode)){
            $tWhereRack = " AND SLY.FTRakCode = '".$tBKLRakCode."'";
        }

        $tSQL           = " SELECT 
                                RACKDATA.*,RAKDTBK.*
                            FROM (
                                SELECT DISTINCT
                                    SLY.FTBchCode,
                                    BCHL.FTBchName,
                                    SLY.FTShpCode,
                                    SHPL.FTShpName,
                                    SPL.FTPosCode,
                                    SLY.FTPzeCode,
                                    PZEL.FTSizName,
                                    SLY.FTRakCode,
                                    RAKL.FTRakName,
                                    SLY.FNLayNo
                                FROM TRTMShopLayout         SLY     WITH(NOLOCK)
                                LEFT JOIN TRTMShopLayout_L  SLYL    WITH(NOLOCK) ON SLY.FTBchCode = SLYL.FTBchCode  AND SLY.FTShpCode   = SLYL.FTShpCode    AND SLY.FNLayNo     = SLYL.FNLayNo AND SLYL.FNLngID = '$nBKLLngID'
                                LEFT JOIN TRTMShopPosLayout SPL     WITH(NOLOCK) ON SLY.FTBchCode = SPL.FTBchCode   AND SLY.FTShpCode	= SPL.FTShpCode     AND SLY.FNLayNo     = SPL.FNLayNo
                                LEFT JOIN TRTTLockerStatus 	LSA     WITH(NOLOCK) ON SPL.FTPosCode = LSA.FTPosCode   AND SPL.FTBchCode	= LSA.FTBchCode     AND SPL.FNLayNo     = LSA.FNLayNo
                                LEFT JOIN TCNMBranch_L      BCHL    WITH(NOLOCK) ON SLY.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID	= '$nBKLLngID'
                                LEFT JOIN TCNMShop_L        SHPL    WITH(NOLOCK) ON SLY.FTBchCode = SHPL.FTBchCode  AND SLY.FTShpCode	= SHPL.FTShpCode	AND SHPL.FNLngID    = '$nBKLLngID'
                                LEFT JOIN TRTMShopSize_L    PZEL    WITH(NOLOCK) ON SLY.FTPzeCode = PZEL.FTSizCode  AND PZEL.FNLngID	= '$nBKLLngID'
                                LEFT JOIN TRTMShopRack_L    RAKL    WITH(NOLOCK) ON SLY.FTRakCode = RAKL.FTRakCode  AND RAKL.FNLngID	= '$nBKLLngID'
                                WHERE 1=1
                                AND SLY.FTBchCode   = '$tBKLBchCode'
                                AND SLY.FTShpCode   = '$tBKLShpCode'
                                AND SPL.FTPosCode   = '$tBKLPosCode'
                                AND SLY.FNLayNo     = '$tBKLLayNo'
                                ".$tWhereRack."
                            ) AS RACKDATA
                            LEFT JOIN (
                                SELECT
                                    BKL.FNBkgDocID,
                                    BKL.FTAgnCode,
                                    BKL.FTBchCode   AS FTBkgBchCode,
                                    BKL.FTUsrCode,
                                    USRL.FTUsrName,
                                    BKL.FTBkgToBch,
                                    BKL.FTBkgToPos,
                                    BKL.FNBkgToLayNo,
                                    BKL.FTBkgToSize,
                                    BKL.FTBkgToRate,
                                    PRIRATEL.FTRthName,
                                    CONVERT(DATE,BKL.FDBkgToStart,121) AS FDBkgToStart,
                                    BKL.FTBkgRefCst,
                                    BKL.FTBkgRefCstLogin,
                                    BKL.FTBkgRefCstDoc,
                                    BKL.FTBkgRefSale,
                                    BKL.FTBkgStaBook
                                FROM TRTTBooking BKL WITH(NOLOCK)
                                LEFT JOIN TCNMUser_L USRL WITH(NOLOCK) ON BKL.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = '$nBKLLngID'
                                LEFT JOIN TRTMPriRateHD_L PRIRATEL WITH(NOLOCK) ON BKL.FTBkgToRate = PRIRATEL.FTRthCode AND PRIRATEL.FNLngID = '$nBKLLngID'
                                WHERE 1=1
                                AND (BKL.FTBkgStaBook = 1)
                                AND (BKL.FTBkgRefSale IS NULL OR BKL.FTBkgRefSale = '')
                                AND (GETDATE() <= CASE	WHEN BKL.FTBkgProducer = 'AdaStoreBack' THEN DATEADD(MINUTE,$nTimeExpOnline,BKL.FDBkgToStart) WHEN BKL.FTBkgProducer = 'AdaSmartLocker'	THEN DATEADD(MINUTE,$nTimeExpOffline,BKL.FDBkgToStart) END)
                            ) AS RAKDTBK
                            ON RACKDATA.FTBchCode = RAKDTBK.FTBkgToBch AND RACKDATA.FTPosCode = RAKDTBK.FTBkgToPos AND RACKDATA.FNLayNo = RAKDTBK.FNBkgToLayNo
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataReturn = $oQuery->row_array();
        }else{
            $aDataReturn = [];
        }
        unset($tBKLBchCode);
        unset($tBKLShpCode);
        unset($tBKLPosCode);
        unset($tBKLRakCode);
        unset($tBKLLayNo);
        unset($nBKLLngID);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Config Booking Expire Back Office 
    // Parameters: Function Controler
    // Creator: 04/12/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSaMBKLGetSysConfigBookingOnlineExpire(){
        $tSQL   = " SELECT DISTINCT
                        SYS.FTSysCode,
                        SYS.FTSysApp,
                        SYS.FTSysKey,
                        SYS.FTSysSeq,
                        SYS.FTGmnCode,
                        SYS.FTSysStaDefValue,
                        SYS.FTSysStaUsrValue
                    FROM TSysConfig SYS WITH(NOLOCK)
                    WHERE 1=1
                    AND SYS.FTSysCode   = 'tRT_Booking'
                    AND SYS.FTSysSeq    = 1
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataReturn = $oQuery->row_array();
        }else{
            $aDataReturn = [];
        }
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Config Booking Expire Smart Locker
    // Parameters: Function Controler
    // Creator: 04/12/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSaMBKLGetSysConfigBookingOfflineExpire(){
        $tSQL   = " SELECT DISTINCT
                        SYS.FTSysCode,
                        SYS.FTSysApp,
                        SYS.FTSysKey,
                        SYS.FTSysSeq,
                        SYS.FTGmnCode,
                        SYS.FTSysStaDefValue,
                        SYS.FTSysStaUsrValue
                    FROM TSysConfig SYS WITH(NOLOCK)
                    WHERE 1=1
                    AND SYS.FTSysCode   = 'tRT_Booking'
                    AND SYS.FTSysSeq    = 2
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataReturn = $oQuery->row_array();
        }else{
            $aDataReturn = [];
        }
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }


}