<?php
    /**
     * Functionality : Check card have in card type
     * Parameters : $ptCardTypeCode
     * Creator : 11/1/2019 Piya
     * Last Modified : -
     * Return : Status true is have card, false is empty card
     * Return Type : Boolean
    */
    function FCNbIsHaveCardInCardType($ptCardTypeCode){
        $ci = &get_instance();
        $ci->load->database();
        
        $bHaveCard = false;
        
        $tSQL = "SELECT CRD.FTCtyCode
                FROM TFNMCard CRD
                WHERE CRD.FTCtyCode = '$ptCardTypeCode'";
        
        $oQuery = $ci->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $bHaveCard = true;
        }
        
        return $bHaveCard;
    }
