<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mFuncSetting extends CI_Model {
    
    /**
     * Functionality : Get Data List Form HD
     * Parameters : function parameters
     * Creator :  04/09/2019 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSaMFuncSetingGetDataHD($paParams = []){
        
        $aRowLen = FCNaHCallLenData($paParams['nRow'],$paParams['nPage']);
        $nLngID = $paParams['FNLngID'];
        $tSystemTypeFilter = $paParams['tGhdApp'];
        $nLevelFilter = $paParams['nGdtFuncLevel'];
        $tStaUseFilter = $paParams['tGdtStaUse'];
        
        $tSQL = "
            SELECT C.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTAppName ASC, FTKbdScreen ASC, FTGdtName ASC) AS FNRowID,* FROM
                    (SELECT --DISTINCT
                        HD.FTGhdApp,
                        HD.FTKbdScreen,
                        APL.FTAppName,
                        DTL.FTGdtName,
                        DT.FTGhdCode,
                        DT.FTSysCode,
                        DT.FTGdtCallByName,
                        DT.FNGdtFuncLevel,
                        DT.FTGdtStaUse
                    FROM TPSMFuncHD HD WITH (NOLOCK)
                    LEFT JOIN TPSMFuncDT DT WITH (NOLOCK) ON HD.FTGhdCode = DT.FTGhdCode
                    /* ส่งพารามิตเตอร์ภาษามา */
                    LEFT JOIN TPSMFuncDT_L DTL WITH (NOLOCK) ON DT.FTGhdCode = DTL.FTGhdCode AND DT.FTSysCode = DTL.FTSysCode AND DTL.FNLngID = $nLngID
                    LEFT JOIN TSysApp_L APL WITH (NOLOCK) ON HD.FTGhdApp = APL.FTAppCode AND APL.FNLngID = $nLngID
                    
                    WHERE DT.FTGdtSysUse = '1'
        ";

        // System Filter
        if(isset($tSystemTypeFilter) && !empty($tSystemTypeFilter) && $tSystemTypeFilter != '0'){
            $tSQL .= " AND HD.FTGhdApp = '$tSystemTypeFilter' ";
        }

        // Level Filter
        if(isset($nLevelFilter) && !empty($nLevelFilter) && $nLevelFilter != '0'){
            $tSQL .= " AND DT.FNGdtFuncLevel = $nLevelFilter ";
        }

        // Use Status Filter
        if(isset($tStaUseFilter) && !empty($tStaUseFilter) && $tStaUseFilter != '0'){
            if($tStaUseFilter == 2){ // ไม่ใช้งาน
                $tSQL .= " AND (DT.FTGdtStaUse = '' OR DT.FTGdtStaUse IS NULL) ";
            }
            if($tStaUseFilter == 1){ // ใช้งาน
                $tSQL .= " AND DT.FTGdtStaUse = '$tStaUseFilter' ";
            }
        }
        
        $tSQL .= ") Base) AS C WHERE C.FNRowID > $aRowLen[0] AND C.FNRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMFuncSettingGetPageAllHD($paParams);
            $nPageAll = ceil($nFoundRow/$paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }
    
    /**
     * Functionality : All Page Form HD
     * Parameters : function parameters
     * Creator :  12/06/2018 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSnMFuncSettingGetPageAllHD($paParams = []){

        $nLngID = $paParams['FNLngID'];
        $tSystemTypeFilter = $paParams['tGhdApp'];
        $nLevelFilter = $paParams['nGdtFuncLevel'];
        $tStaUseFilter = $paParams['tGdtStaUse'];
        
        $tSQL = "   
            SELECT --DISTINCT 
                DT.FTGdtCallByName,
                HD.FTGhdApp,
                HD.FTKbdScreen,
                APL.FTAppName,
                DTL.FTGdtName,
                DT.FTGhdCode,
                DT.FTSysCode,
                DT.FNGdtFuncLevel,
                DT.FTGdtStaUse
            FROM TPSMFuncHD HD WITH (NOLOCK)
            LEFT JOIN TPSMFuncDT DT WITH (NOLOCK) ON HD.FTGhdCode = DT.FTGhdCode
            /* ส่งพารามิตเตอร์ภาษามา */
            LEFT JOIN TPSMFuncDT_L DTL WITH (NOLOCK) ON DT.FTGhdCode = DTL.FTGhdCode AND DT.FTSysCode = DTL.FTSysCode AND DTL.FNLngID = $nLngID
            LEFT JOIN TSysApp_L APL WITH (NOLOCK) ON HD.FTGhdApp = APL.FTAppCode AND APL.FNLngID = $nLngID  
                
            WHERE DT.FTGdtSysUse = '1'
        ";

        // System Filter
        if(isset($tSystemTypeFilter) && !empty($tSystemTypeFilter) && $tSystemTypeFilter != '0'){
            $tSQL .= " AND HD.FTGhdApp = '$tSystemTypeFilter' ";
        }

        // Level Filter
        if(isset($nLevelFilter) && !empty($nLevelFilter) && $nLevelFilter != '0'){
            $tSQL .= " AND DT.FNGdtFuncLevel = $nLevelFilter ";
        }

        // Use Status Filter
        if(isset($tStaUseFilter) && !empty($tStaUseFilter) && $tStaUseFilter != '0'){
            if($tStaUseFilter == 2){ // ไม่ใช้งาน
                $tSQL .= " AND (DT.FTGdtStaUse = '' OR DT.FTGdtStaUse IS NULL) ";
            }
            if($tStaUseFilter == 1){ // ใช้งาน
                $tSQL .= " AND DT.FTGdtStaUse = '$tStaUseFilter' ";
            }
        }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) { // Found Data
            return $oQuery->num_rows();
        }else{ // Not Found Data
            return 0;
        }
        
    }
    
    /**
     * Functionality : Get Data List Form Temp
     * Parameters : function parameters
     * Creator :  04/09/2019 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSaMFuncSetingGetDataInTemp($paParams = []){
        
        $aRowLen = FCNaHCallLenData($paParams['nRow'],$paParams['nPage']);
        $tMttTableKey = $paParams['tMttTableKey'];
        $tMttRefKey = $paParams['tMttRefKey'];
        $tUserSessionID = $paParams['tUserSessionID'];
        
        $tSQL = "
            SELECT C.* FROM(
                SELECT ROW_NUMBER() OVER(ORDER BY FTAppName ASC, FTKbdScreen ASC, FTGdtName ASC) AS FNRowID,* FROM
                    (SELECT --DISTINCT 
                        TMP.FTGhdApp,
                        TMP.FTAppName,
                        TMP.FTKbdScreen,
                        TMP.FTGdtName,
                        TMP.FTGhdCode,
                        TMP.FTSysCode,
                        TMP.FTGdtCallByName,
                        TMP.FNGdtFuncLevel,
                        TMP.FTGdtStaUse
                    FROM TsysMasTmp TMP WITH (NOLOCK)
                    WHERE TMP.FTMttTableKey = '$tMttTableKey'
                    AND TMP.FTMttRefKey = '$tMttRefKey'
                    AND TMP.FTMttSessionID = '$tUserSessionID'
        ";
        
        $tSQL .= ") Base) AS C WHERE 1=1 /*C.FNRowID > $aRowLen[0] AND C.FNRowID <= $aRowLen[1]*/";
       
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMFuncSettingGetPageAllTemp($paParams);
            $nPageAll = ceil($nFoundRow/$paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }
    
    /**
     * Functionality : All Page Form Temp
     * Parameters : function parameters
     * Creator :  12/06/2018 Piya
     * Last Modified : -
     * Return : Data Array
     * Return Type : Array
     */
    public function FSnMFuncSettingGetPageAllTemp($paParams = []){
        
        $tMttTableKey = $paParams['tMttTableKey'];
        $tMttRefKey = $paParams['tMttRefKey'];
        $tUserSessionID = $paParams['tUserSessionID'];
        
        $tSQL = "   
            SELECT --DISTINCT 
                TMP.FTGhdApp,
                TMP.FTAppName,
                TMP.FTKbdScreen,
                TMP.FTGdtName,
                TMP.FTGhdCode,
                TMP.FTSysCode,
                TMP.FTGdtCallByName,
                TMP.FNGdtFuncLevel,
                TMP.FTGdtStaUse
            FROM TsysMasTmp TMP WITH (NOLOCK)
            WHERE TMP.FTMttTableKey = '$tMttTableKey'
            AND TMP.FTMttRefKey = '$tMttRefKey'
            AND TMP.FTMttSessionID = '$tUserSessionID'
        ";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) { // Found Data
            return $oQuery->num_rows();
        }else{ // Not Found Data
            return 0;
        }
        
    }
    
    /**
     * Functionality : Insert FuncDT To Temp
     * Parameters : function parameters
     * Creator : 04/09/2019 Piya
     * Last Modified : -
     * Return : Status Insert
     * Return Type : Array
     */
    public function FSaMFuncSettingInsertDTToTemp($paParams = []){
        
        $nLngID = $paParams['FNLngID'];
        $tSystemTypeFilter = $paParams['tGhdApp'];
        $tMttTableKey = $paParams['tMttTableKey'];
        $tMttRefKey = $paParams['tMttRefKey'];
        $tUserSessionID = $paParams['tUserSessionID'];
        
        // ทำการลบ ใน Temp ก่อนนำเข้า DT ไป Temp
        $this->db->where('FTMttTableKey', $tMttTableKey);
        $this->db->where('FTMttRefKey', $tMttRefKey);
        $this->db->where('FTMttSessionID', $tUserSessionID);
        $this->db->delete('TsysMasTmp');
        
        $tSQL = "   
            INSERT TsysMasTmp WITH (ROWLOCK)
                (FTGhdApp, FTAppName, FTGdtName, FTKbdScreen, FTGhdCode, FTSysCode, FTGdtCallByName, FNGdtFuncLevel, FTGdtStaUse, FTMttTableKey, FTMttRefKey, FTMttSessionID)
                
            SELECT --DISTINCT  
                HD.FTGhdApp,
                APL.FTAppName,
                DTL.FTGdtName,
                HD.FTKbdScreen,
                DT.FTGhdCode,
                DT.FTSysCode,
                DT.FTGdtCallByName,
                DT.FNGdtFuncLevel,
                DT.FTGdtStaUse,
                '$tMttTableKey' AS FTMttTableKey,
                '$tMttRefKey' AS FTMttRefKey,
                '$tUserSessionID' AS FTMttSessionID
            FROM TPSMFuncHD HD WITH (NOLOCK)
            LEFT JOIN TPSMFuncDT DT WITH (NOLOCK) ON HD.FTGhdCode = DT.FTGhdCode
            /* ส่งพารามิตเตอร์ภาษามา */
            LEFT JOIN TPSMFuncDT_L DTL WITH (NOLOCK) ON DT.FTGhdCode = DTL.FTGhdCode AND DT.FTSysCode = DTL.FTSysCode AND DTL.FNLngID = $nLngID
            LEFT JOIN TSysApp_L APL WITH (NOLOCK) ON HD.FTGhdApp = APL.FTAppCode AND APL.FNLngID = $nLngID    
            WHERE DT.FTGdtSysUse = '1'
            AND HD.FTGhdApp = '$tSystemTypeFilter'
            ORDER BY APL.FTAppName ASC, DT.FTGdtCallByName ASC    
        ";
        
        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Insert Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Insert Fail.',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Update FuncDT Form Temp
     * Parameters : function parameters
     * Creator : 04/09/2019 Piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSaMFuncSettingUpdateTmpToDT($paParams = []){
        
        $tSystemTypeFilter = $paParams['tGhdApp'];
        $tMttTableKey = $paParams['tMttTableKey'];
        $tMttRefKey = $paParams['tMttRefKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "   
            UPDATE TPSMFuncDT SET
                --FNGdtFuncLevel = TMP.FNGdtFuncLevel,
                FTGdtStaUse = TMP.FTGdtStaUse

            FROM(
                SELECT 
                    FTGhdApp,
                    FTGhdCode,
                    FTSysCode,
                    FTGdtCallByName,
                    FNGdtFuncLevel,
                    FTGdtStaUse
                FROM TsysMasTmp WITH (NOLOCK)
                WHERE FTMttTableKey = '$tMttTableKey'
                AND FTMttRefKey = '$tMttRefKey'
                AND FTMttSessionID = '$tUserSessionID'
            ) AS TMP

            WHERE TPSMFuncDT.FTGhdCode = TMP.FTGhdCode 
            AND TPSMFuncDT.FTSysCode = TMP.FTSysCode
            AND TPSMFuncDT.FTGdtCallByName = TMP.FTGdtCallByName
            AND TPSMFuncDT.FTGhdCode IN (
                SELECT 
                    FTGhdCode	
                FROM TPSMFuncHD WITH (NOLOCK)
                WHERE FTGhdApp = '$tSystemTypeFilter'
                AND FTGhdCode = TPSMFuncDT.FTGhdCode
            )
        ";
       
        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Update Fail.',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Update FuncHD
     * Parameters : function parameters
     * Creator : 04/09/2019 Piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSaMFuncSettingUpdateFuncInHD($paParams = []) {

        $tMttTableKey = $paParams['tMttTableKey'];
        $tMttRefKey = $paParams['tMttRefKey'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserLoginCode = $paParams['tUserLoginCode'];

        $tSQL = "   
            UPDATE TPSMFuncHD SET
                FDLastUpdOn = GETDATE(),
                FTLastUpdBy = '$tUserLoginCode'
            FROM(
                SELECT DISTINCT
                    FTGhdApp,
                    FTGhdCode,
                    FTSysCode,
                    FTGdtCallByName,
                    FNGdtFuncLevel,
                    FTGdtStaUse
                FROM TsysMasTmp WITH (NOLOCK)
                WHERE FTMttTableKey = '$tMttTableKey'
                AND FTMttRefKey = '$tMttRefKey'
                AND FTMttSessionID = '$tUserSessionID'
                AND FTStaEdit = '1'
            ) AS TMP

            WHERE TPSMFuncHD.FTGhdCode = TMP.FTGhdCode
        ";
       
        $oQuery = $this->db->query($tSQL);

        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Update Fail.',
            );
        }
        return $aStatus;
    }
    
    /**
     * Functionality : Update FuncDT In Temp
     * Parameters : function parameters
     * Creator : 04/09/2019 Piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSaMFuncSettingUpdateFuncInTmp($paParams = []) {
        
        // $this->db->set('FNGdtFuncLevel', $paParams['nGdtFuncLevel']);
        
        if($paParams['tGdtStaUse'] == '1'){ // 1: ใช้งาน
            $this->db->set('FTGdtStaUse', '1');
        }
        if($paParams['tGdtStaUse'] == '2'){ // NULL: ไม่ใช้งาน
            $this->db->set('FTGdtStaUse', NULL);
        }
        
        $this->db->set('FTStaEdit', '1');

        $this->db->where('FTGhdApp', $paParams['tGhdApp']);
        $this->db->where('FTGhdCode', $paParams['tGhdCode']);
        $this->db->where('FTSysCode', $paParams['tSysCode']);
        $this->db->where('FTGdtCallByName', $paParams['tGdtCallByName']);
        
        $this->db->where('FTMttTableKey', $paParams['tMttTableKey']);
        $this->db->where('FTMttRefKey', $paParams['tMttRefKey']);
        $this->db->where('FTMttSessionID', $paParams['tUserSessionID']);
        $this->db->update('TsysMasTmp');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Update Fail',
            );
        }
        return $aStatus;
        
    }
    
    /**
     * Functionality : Get System App All
     * Parameters : function parameters
     * Creator : 04/09/2019 Piya
     * Last Modified : -
     * Return : System App Data
     * Return Type : Array
     */
    public function FSaMFuncSettingGetSystemAppAll($paParams = []){
        
        $nLngID = $paParams['FNLngID'];
        
        $tSQL = "   
            SELECT DISTINCT 
                HD.FTGhdApp,
                APL.FTAppName
            FROM TPSMFuncHD HD 
            LEFT JOIN TPSMFuncDT DT ON HD.FTGhdCode = DT.FTGhdCode
            /* ส่งพารามิตเตอร์ ภาษา */
            LEFT JOIN TPSMFuncDT_L DTL ON DT.FTGhdCode = DTL.FTGhdCode AND DT.FTSysCode = DTL.FTSysCode AND DTL.FNLngID = $nLngID
            LEFT JOIN TSysApp_L APL ON HD.FTGhdApp = APL.FTAppCode AND APL.FNLngID = $nLngID

            WHERE DT.FTGdtSysUse = '1' 
            ORDER BY HD.FTGhdApp ASC
        ";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) { // Found Data
            return $oQuery->result();
        }else{ // Not Found Data
            return [];
        }
    }

}
