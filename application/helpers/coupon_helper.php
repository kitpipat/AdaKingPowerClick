<?php
    /**
     * Functionality : Check FTCptCode in TFNTCouponHD
     * Parameters : $ptCptCode
     * Creator : 09/12/2020 Sooksanti(Nont)
     * Last Modified : -
     * Return : Status true is have user, false is empty user
     * Return Type : Boolean
    */
    function FCNbIsHaveCoupInCouponHD($ptCptCode){
        $ci = &get_instance();
        $ci->load->database();
        
        $bHaveCoup = false;
        
        $tSQL = "   
            SELECT 
                COUP.FTCptCode
            FROM TFNTCouponHD COUP
            WHERE COUP.FTCptCode = '$ptCptCode'
        ";
        
        $oQuery = $ci->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) {
            $bHaveCoup = true;
        }
        
        return $bHaveCoup;
    }