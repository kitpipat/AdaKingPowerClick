<?php
    /**
     * Functionality : Check PosCode in SalHD
     * Creator : 08/01/2021 Sooksanti
     * Last Modified : -
     * Return : Status true is have PosCode, false is empty PosCode
     * Return Type : Boolean
    */
    function FCNbIsPosCodeInSalHD($ptPosCode,$ptBchCode,$ptPosType){
        $ci = &get_instance();
        $ci->load->database();
        $bHaveUser = false;
        $tSQL = "";
        if($ptPosType == '1'){
            $tSQL = "   
                SELECT 
                    SAL.FTPosCode,
                    SAL.FTBchCode
                FROM TPSTSalHD SAL
                WHERE SAL.FTBchCode = '$ptBchCode' AND SAL.FTPosCode = '$ptPosCode'
            ";            
        }else if($ptPosType == '2'){
            $tSQL = "   
                SELECT
                    TOPUP.FTPosCode,
                    TOPUP.FTBchCode
                FROM TFNTCrdTopUpHD TOPUP
                WHERE TOPUP.FTBchCode = '$ptBchCode' AND TOPUP.FTPosCode = '$ptPosCode'
            ";   
        }
        else if($ptPosType == '4'){
            $tSQL = "   
                SELECT 
                    SAL.FTPosCode,
                    SAL.FTBchCode
                FROM TVDTSalHD SAL
                WHERE SAL.FTBchCode = '$ptBchCode' AND SAL.FTPosCode = '$ptPosCode'
            ";
        }

        if($ptPosType != '5'){
            $oQuery = $ci->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0) {
                $bHaveUser = true;
            }            
        }

        
        return $bHaveUser;
    }