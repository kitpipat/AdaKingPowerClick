<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSysConfig extends CI_Model{
    /**
     * Functionality: Branch Address Get Version
     * Parameters: function parameters
     * Creator: 16/09/2019 Piya
     * Return: Data System Config
     * ReturnType: Array
     */
    public function FSaMGetSysConfig($aParams = []){
        
        $tSysCode = $aParams['tSysCode'];
        $tSysKey = $aParams['tSysKey'];
        $tSysSeq = $aParams['tSysSeq'];
        
        $tSysSeqSql = "";
        if(isset($aParams['tSysSeq'])) {
            $tSysSeqSql = " AND FTSysSeq    = '$tSysSeq'";
        }
        $tSQL = " 
            SELECT
                FTSysStaDefValue,
                FTSysStaUsrValue  
            FROM TSysConfig WITH(NOLOCK)
            WHERE 1=1
            AND FTSysCode   = '$tSysCode' /* tCN_AddressType */
            AND FTSysKey    = '$tSysKey' /* TCNMBranch */
            $tSysSeqSql /* 2 */
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array();
        }else{
            $aResult = array();
        }
        return $aResult;
    }
    
}


























