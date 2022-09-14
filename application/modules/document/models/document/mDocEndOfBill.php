<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mDocEndOfBill extends CI_Model {
    /**
     * 
     * @param type $paParams
     * @return string
     */
    public function FSaMDOCEndOfBillGetDTSumVat($paParams){
        $nLngID = $paParams['FNLngID'];
        $tDocNo = $paParams['FTXthDocNo'];
        $tDocKey = $paParams['FTXthDocKey'];
        $tBchCode = $paParams['FTBchCode'];
        $tSessionID = $paParams['FTSessionID'];

        $tSQL = "   SELECT
                        ISNULL(DOCTMP.FCXtdVatRate, 0) AS FCXtdVatRate,
                        SUM( ISNULL(DOCTMP.FCXtdVat, 0) ) AS FCXtdVat
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1=1
                    AND DOCTMP.FTSessionID ='$tSessionID' AND DOCTMP.FTXthDocKey = '$tDocKey' AND DOCTMP.FTXthDocNo = '$tDocNo' 
                    --AND DOCTMP.FTBchCode = '$tBchCode' เนลเอาออกเพราะไม่คำนวณ
                    AND DOCTMP.FTXtdVatType = 1 AND DOCTMP.FCXtdVatRate > 0   
                    GROUP BY DOCTMP.FCXtdVatRate
                    ORDER BY DOCTMP.FCXtdVatRate ASC";

        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
        $aData = $oQuery->result_array();
        
        }else{
            $aData = [];
        }
        return $aData;
    }
    
    /**
     * 
     * @param type $paParams
     * @return string
     */
    public function FSaMDOCEndOfBillGetDTTmp($paParams){
        $nLngID = $paParams['FNLngID'];
        $tDocNo = $paParams['FTXthDocNo'];
        $tDocKey = $paParams['FTXthDocKey'];
        $tBchCode = $paParams['FTBchCode'];
        $tSessionID = $paParams['FTSessionID'];

        $tSQL = "   SELECT 
                        SUM( ISNULL(DOCTMP.FCXtdNet, 0) ) AS FCXtdNet,
                        SUM( ISNULL(DOCTMP.FCXtdNetAfHD, 0) ) AS FCXtdNetAfHD,
                        SUM( ISNULL(DOCTMP.FCXtdVat, 0) ) AS FCXtdVat
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1=1
                    AND DOCTMP.FTSessionID ='$tSessionID' AND DOCTMP.FTXthDocKey = '$tDocKey' AND DOCTMP.FTXthDocNo = '$tDocNo' --AND DOCTMP.FTBchCode = '$tBchCode'
                    /*AND DOCTMP.FTXtdVatType = 1*/  
                    GROUP BY DOCTMP.FTSessionID
                    ORDER BY DOCTMP.FTSessionID ASC";

        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
        $aData = $oQuery->result_array();
        
        }else{
            $aData = [
                'FCXtdNet' => .00,
                'FCXtdNetAfHD' => .00,
                'FCXtdVat' => .00
            ];
        }
        return $aData;
    }
    
    /**
     * 
     * @param type $paParams
     * @return string
     */
    public function FSaMDOCEndOfBillGetHDDisTmp($paParams){
        $nLngID = $paParams['FNLngID'];
        $tDocNo = $paParams['FTXthDocNo'];
        $tBchCode = $paParams['FTBchCode'];
        $tSessionID = $paParams['FTSessionID'];

        $tSQL = "   SELECT 
                        /*SUM( ISNULL(DOCHDDISTMP.FCXtdDisChg, 0) ) AS FCXtdDisChg,*/
                        
                        SUM( 
                            CASE 
                                WHEN DOCHDDISTMP.FTXtdDisChgType = 1 THEN ISNULL(DOCHDDISTMP.FCXtdAmt, 0) * -1
                                WHEN DOCHDDISTMP.FTXtdDisChgType = 2 THEN ISNULL(DOCHDDISTMP.FCXtdAmt, 0) * -1
                                WHEN DOCHDDISTMP.FTXtdDisChgType = 3 THEN ISNULL(DOCHDDISTMP.FCXtdAmt, 0)
                                WHEN DOCHDDISTMP.FTXtdDisChgType = 4 THEN ISNULL(DOCHDDISTMP.FCXtdAmt, 0)
                                ELSE 0 
                            END
                        ) AS FCXtdAmt,
                        
                        STUFF((
                            SELECT  ',' + DOCCONCAT.FTXtdDisChgTxt
                            FROM TCNTDocHDDisTmp DOCCONCAT
                            WHERE  1=1 
                            AND DOCCONCAT.FTBchCode 		= '".$tBchCode."'
                            AND DOCCONCAT.FTXthDocNo		= '".$tDocNo."'
                            AND DOCCONCAT.FTSessionID		= '".$tSessionID."'
                        FOR XML PATH('')), 1, 1, '') AS FTXtdDisChgTxt
                    FROM TCNTDocHDDisTmp DOCHDDISTMP WITH (NOLOCK)
                    WHERE DOCHDDISTMP.FTSessionID ='$tSessionID' AND DOCHDDISTMP.FTXthDocNo = '$tDocNo' --AND DOCHDDISTMP.FTBchCode = '$tBchCode'
                    GROUP BY DOCHDDISTMP.FTSessionID
                    ORDER BY DOCHDDISTMP.FTSessionID ASC";

        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
        $aData = $oQuery->result_array();
        
        }else{
            $aData = [
                'FCXtdAmt' => .00
            ];
        }
        return $aData;
    }
    
}

