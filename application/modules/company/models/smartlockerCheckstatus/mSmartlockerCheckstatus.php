<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSmartlockerCheckstatus extends CI_Model {

    //Get Rack
    public function FSaMPSHCheckStatusGetRack($tBCH,$tSHP){
        $tSQL   = " SELECT distinct SP.FTRakCode , RL.FTRakName FROM TRTMShopLayout SP
                    LEFT JOIN TRTMShopRack_L RL on SP.FTRakCode = RL.FTRakCode 
                    WHERE 1=1 AND SP.FTBchCode IN ($tBCH) AND SP.FTShpCode = '$tSHP' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
        $aDataReturn        = array(
            'aList'         => $oQuery->result_array(),
            'rtCode'        => '1',
            'rtDesc'        => 'Pass',
        );
        }else{
        $aDataReturn        =  array(
            'rtCode'        => '800',
            'rtDesc'        => 'Notfound',
        );
        }
        return $aDataReturn;
    }

    //Get Detail
    public function FSaMPSHCheckStatusGetDetail($paData){
        try{
            $tFNLngID       = $paData['FNLngID'];
            $tFTBchCode     = $paData['FTBchCode'];
            $tFTShpCode     = $paData['FTShpCode'];
            $tFTRakCode     = $paData['FTRakCode'];
            $tPosCode       = $paData['tSaleMac'];
            
            // Get Config And Check Config Time Exprie AdaBackOffice Producer
            $aConfigParamsOnline    = [
                "tSysCode"  => "tRT_Booking",
                "tSysApp"   => "SL",
                "tSysKey"   => "TimeExpire",
                "tSysSeq"   => "1",
                "tGmnCode"  => "XBUY"
            ];
            $aConfigBookingExpOnline    = FCNaGetSysConfig($aConfigParamsOnline);
            if($aConfigBookingExpOnline['rtCode'] == 1){
                if(isset($aConfigBookingExpOnline['raItems']['FTSysStaUsrValue']) && !empty($aConfigBookingExpOnline['raItems']['FTSysStaUsrValue'])){
                    $nTimeExpOnline = $aConfigBookingExpOnline['raItems']['FTSysStaUsrValue'];
                }else{
                    $nTimeExpOnline = $aConfigBookingExpOnline['raItems']['FTSysStaDefValue'];
                }
            }else{
                $nTimeExpOnline = 180;
            }

            // Get Config And Check Config Time Exprie AdaSmartLocker Producer
            $aConfigParamsOffline   = [
                "tSysCode"  => "tRT_Booking",
                "tSysApp"   => "SL",
                "tSysKey"   => "TimeExpire",
                "tSysSeq"   => "2",
                "tGmnCode"  => "XBUY"
            ];
            $aConfigBookingExpOffline    = FCNaGetSysConfig($aConfigParamsOffline);
            if($aConfigBookingExpOffline['rtCode'] == 1){
                if(isset($aConfigBookingExpOffline['raItems']['FTSysStaUsrValue']) && !empty($aConfigBookingExpOffline['raItems']['FTSysStaUsrValue'])){
                    $nTimeExpOffline    = $aConfigBookingExpOffline['raItems']['FTSysStaUsrValue'];
                }else{
                    $nTimeExpOffline    = $aConfigBookingExpOffline['raItems']['FTSysStaDefValue'];
                }
            }else{
                $nTimeExpOffline    = 5;
            }

            $tSQL   = " SELECT
                            RAKSTADATA.*,
                            CASE WHEN BKLDATA.FNBkgDocID IS NULL THEN 0 ELSE 1 END AS FNStaBooking
                        FROM (
                            SELECT DISTINCT
                                SLY.FTBchCode,
                                SLY.FTShpCode,
                                SLY.FNLayNo,
                                SLY.FNLayScaleX,
                                SLY.FNLayScaleY,
                                SLY.FNLayRow,
                                SLY.FNLayCol,
                                SLY.FTPzeCode,
                                SLY.FTRakCode,
                                SLY.FTLayStaUse,
                                SRL.FTRakName,
                                BCL.FTBchName,
                                SPL.FTPosCode,
                                ISNULL(LSA.FTLayStaUse,1) AS FTRackStatus,
                                SLYL.FTLayName
                            FROM TRTMShopLayout         SLY     WITH(NOLOCK)
                            LEFT JOIN TRTMShopLayout_L  SLYL    WITH(NOLOCK) ON SLY.FNLayNo = SLYL.FNLayNo AND SLY.FTBchCode = SLYL.FTBchCode AND SLY.FTShpCode = SLYL.FTShpCode AND SLYL.FNLngID = '$tFNLngID'
                            LEFT JOIN TCNMBranch_L      BCL     WITH(NOLOCK) ON SLY.FTBchCode = BCL.FTBchCode AND BCL.FNLngID = '$tFNLngID'
                            LEFT JOIN TRTMShopRack_L    SRL     WITH(NOLOCK) ON SLY.FTRakCode = SRL.FTRakCode AND SRL.FNLngID = '$tFNLngID'
                            LEFT JOIN TRTMShopPosLayout SPL     WITH(NOLOCK) ON SLY.FNLayNo = SPL.FNLayNo AND SLY.FTBchCode = SPL.FTBchCode AND SLY.FTShpCode = SPL.FTShpCode
                            LEFT JOIN TRTTLockerStatus  LSA     WITH(NOLOCK) ON SPL.FTPosCode = LSA.FTPosCode AND BCL.FTBchCode = LSA.FTBchCode AND SPL.FNLayNo = LSA.FNLayNo
                            WHERE 1=1
                            AND SLY.FTLayStaUse = '1'
                            AND SPL.FTPosCode   = '$tPosCode'
                            AND SLY.FTBchCode   = '$tFTBchCode'
                            AND SLY.FTShpCode   = '$tFTShpCode'
                            AND SLY.FTRakCode   = '$tFTRakCode'
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
                        ORDER BY RAKSTADATA.FNLayCol ASC,RAKSTADATA.FNLayRow ASC
            ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $aResult    = array(
                    'raItems'       => $aList,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'tSQL'          => $tSQL 
                );
            }else{
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found'
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Insert Open locker
    public function FSaMPSHInsertOpenLocker($paData){
        $this->db->insert('TRTTAdminHis', array(
            'FTBchCode'          => $paData['FTBchCode'],
            'FTShpCode'          => $paData['FTShpCode'],
            'FTPosCode'          => $paData['FTPosCode'],
            'FDHisDateTime'      => $paData['FDHisDateTime'],
            'FNHisLayNo'         => $paData['FNHisLayNo'],
            'FTHisUsrCode'       => $paData['FTHisUsrCode'],
            'FTHisCstTel'        => $paData['FTHisCstTel'],
            'FTHisRsnCode'       => $paData['FTHisRsnCode'],
            'FDLastUpdOn'        => $paData['FDLastUpdOn'],
            'FTLastUpdBy'        => $paData['FTLastUpdBy'],
            'FDCreateOn'         => $paData['FDCreateOn'],
            'FTCreateBy'         => $paData['FTCreateBy'],
            'FTHisType'          => $paData['FTHisType'],
        ));

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Master Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }
        return $aStatus;
    }

    // Functionality: Get Data Board No And FTLayBoxNo Shop Pos Lay Out
    // Parameters:  Function Parameter
    // Creator: 09/08/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Shop Pos Lay Out
    // Return Type: Array
    public function FSaMPSHGetDataShopLayOut($paData){
        $tBchCode   = $paData['FTBchCode'];
        $tShpCode   = $paData['FTShpCode'];
        $tPosCode   = $paData['FTPosCode'];
        $nLayNo     = $paData['FNHisLayNo'];

        $tSQL   = " SELECT
                        SHPPOSLAY.FTBchCode,
                        SHPPOSLAY.FTShpCode,
                        SHPPOSLAY.FTPosCode,
                        SHPPOSLAY.FNLayNo,
                        SHPPOSLAY.FNLayBoardNo,
                        SHPPOSLAY.FTLayBoxNo
                    FROM TRTMShopPosLayout AS SHPPOSLAY WITH(NOLOCK)
                    WHERE 1=1
                    AND SHPPOSLAY.FTBchCode = '$tBchCode'
                    AND SHPPOSLAY.FTShpCode = '$tShpCode'
                    AND SHPPOSLAY.FTPosCode = '$tPosCode'
                    AND SHPPOSLAY.FNLayNo   = $nLayNo
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aData  = $oQuery->row_array();
        }else{
            $aData  = array();
        }
        return $aData;
    }



}