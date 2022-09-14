<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mDashBoardSaleTable extends CI_Model
{

    // Functionality: Get Data Total Sale Bill All
    // Parameters: function parameters
    // Creator:  16/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaNDSHSALCountBillAll($paDataWhere)
    {
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Data Where Date Data
        $tTextWhereDateData = '';
        if (!empty($paDataWhere['tDateDataForm']) && !empty($paDataWhere['tDateDataTo'])) {
            $tTextWhereDateData = " AND (CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) OR CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121))";
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND SHP.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND SHP.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos  = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterPosCode']) && !empty($paDataWhere['tFilterPosCode'])) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPosCode']) . ')';
            }
        }

        // Check Data Where In Product
        $tTextWherePdt  = '';
        if (isset($paDataWhere['bFilterPdtStaAll']) && $paDataWhere['bFilterPdtStaAll'] == false) {
            if (isset($paDataWhere['tFilterPdtCode']) && !empty($paDataWhere['tFilterPdtCode'])) {
                $tTextWherePdt  = 'AND DT.FTPdtCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPdtCode']) . ')';
            }
        }

        // Check Data Where Customer Have
        $tTextWhereCstHavePS    = '';
        $tTextWhereCstHaveVD    = '';
        $tTextWhereCstHaveRT    = '';
        if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
            if ($paDataWhere['tFilterStaCst'] == '1') {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave > 0';
            } else {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave = 0';
            }
        }

        // Check Data Where Status Payment
        // $tTextWhereStaRcPS  = '';
        // $tTextWhereStaRcVD  = '';
        // $tTextWhereStaRcRT  = '';
        // if (isset($paDataWhere['tFilterStaPayment']) && !empty($paDataWhere['tFilterStaPayment'])) {
        //     if ($paDataWhere['tFilterStaPayment'] == '1') {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc > 0';
        //     } else {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc = 0';
        //     }
        // }

        $tTextWhereStaPayment = '';
        if (isset($paDataWhere['tFilterStaPayment']) && !empty($paDataWhere['tFilterStaPayment'])) {
            if ($paDataWhere['tFilterStaPayment'] == '1') {
                $tTextWhereStaPayment = " AND ISNULL(RC.FTXshDocNo,'') != '' ";
            } else {
                $tTextWhereStaPayment  = " AND ISNULL(RC.FTXshDocNo,'') = '' ";
            }
        }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                // $tTextSubSale   .= ' UNION ALL ';
            }
            switch ($nStaAppType) {
                case '1': {
                        $tTextSubSale .= "  SELECT PSSALE.*
                                        FROM(
                                            SELECT DISTINCT
                                                HD.FTBchCode,HD.FTXshDocNo,HD.FNXshDocType,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TPSTSalHD HD WITH(NOLOCK)
                                            INNER JOIN TPSTSalDT DT WITH(NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TPSTSalRc RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWhereStaPayment
                                        ) PSSALE
                                        WHERE 1=1
                                        $tTextWhereCstHavePS                                  
                    ";
                        break;
                    }
                case '2': {
                        /*$tTextSubSale .= "  SELECT VDSALE.*
                                        FROM (
                                            SELECT DISTINCT 
                                                HD.FTBchCode,HD.FTXshDocNo,HD.FNXshDocType,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TVDTSalHD HD WITH(NOLOCK)
                                            INNER JOIN TVDTSalDT DT WITH(NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo
                                            INNER JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TVDTSalRc RC WITH(NOLOCK)
                                                LEFT JOIN TFNMRcv RCV WITH(NOLOCK) ON  RC.FTRcvCode = RCV.FTRcvCode  
		                                        -- WHERE 1=1 AND RCV.FTFmtCode <> '004'
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWhereStaPayment
                                        ) VDSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveVD
                                        $tTextWhereStaRcVD
                    ";*/
                        break;
                    }
                case '3': {
                        /*$tTextSubSale .= "  SELECT RTSALE.*
                                        FROM (
                                            SELECT DISTINCT 
                                                HD.FTBchCode,HD.FTXshDocNo,HD.FNXshDocType,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TRTTSalHD HD WITH(NOLOCK)
                                            INNER JOIN TRTTSalDT DT WITH(NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT RC.FTBchCode,RC.FTXsdRefDocNo,COUNT(RC.FTXsdRefDocNo) AS FNCountSaleRc
                                                FROM TRTTPayDT RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXsdRefDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXsdRefDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON DT.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWhereStaPayment
                                        ) RTSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveRT
                                        $tTextWhereStaRcRT
                    ";*/
                        break;
                    }
            }
        }

        $tSQL   = " SELECT
                        COUNT(FTXshDocNo) AS FNXshCountAll,
                        COUNT(CASE WHEN ALLSALE.FNXshDocType = 1 THEN 1 ELSE NULL END) AS FNXshCountSalAll,
                        COUNT(CASE WHEN ALLSALE.FNXshDocType = 9 THEN 1 ELSE NULL END) AS FNXshCountRefundAll
                    FROM (" . $tTextSubSale . ") ALLSALE
        ";
        // print_r($tSQL);
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataReturn    = $oQuery->row_array();
        } else {
            $aDataReturn    = [];
        }

        unset($nLngID);
        unset($aStaAppType);
        unset($tTextWhereBranch);
        unset($tTextWhereMerchant);
        unset($tTextWhereShop);
        unset($tTextWherePos);
        unset($tTextWherePdt);
        unset($tTextWhereCstHavePS);
        unset($tTextWhereCstHaveVD);
        unset($tTextWhereCstHaveRT);
        unset($tTextWhereStaRcPS);
        unset($tTextWhereStaRcVD);
        unset($tTextWhereStaRcRT);
        unset($tTextSubSale);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Data Total Sale All
    // Parameters: function parameters
    // Creator:  16/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaNDSHSALCountTotalSaleAll($paDataWhere)
    {
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Data Where Date Data
        $tTextWhereDateData     = '';
        if (!empty($paDataWhere['tDateDataForm']) && !empty($paDataWhere['tDateDataTo'])) {
            $tTextWhereDateData = " AND (CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) OR CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121))";
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND SHP.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND SHP.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos  = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterPosCode']) && !empty($paDataWhere['tFilterPosCode'])) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPosCode']) . ')';
            }
        }

        // Check Data Where In Product
        $tTextWherePdt  = '';
        if (isset($paDataWhere['bFilterPdtStaAll']) && $paDataWhere['bFilterPdtStaAll'] == false) {
            if (isset($paDataWhere['tFilterPdtCode']) && !empty($paDataWhere['tFilterPdtCode'])) {
                $tTextWherePdt  = 'AND DT.FTPdtCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPdtCode']) . ')';
            }
        }

        // Check Data Where Customer Have
        $tTextWhereCstHavePS    = '';
        $tTextWhereCstHaveVD    = '';
        $tTextWhereCstHaveRT    = '';
        if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
            if ($paDataWhere['tFilterStaCst'] == '1') {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave > 0';
            } else {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave = 0';
            }
        }

        // Check Data Where Status Payment
        // $tTextWhereStaRcPS  = '';
        // $tTextWhereStaRcVD  = '';
        // $tTextWhereStaRcRT  = '';
        // if (isset($paDataWhere['tFilterStaPayment']) && !empty($paDataWhere['tFilterStaPayment'])) {
        //     if ($paDataWhere['tFilterStaPayment'] == '1') {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc > 0';
        //     } else {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc = 0';
        //     }
        // }

        $tTextWhereStaPayment = '';
        if (isset($paDataWhere['tFilterStaPayment']) && !empty($paDataWhere['tFilterStaPayment'])) {
            if ($paDataWhere['tFilterStaPayment'] == '1') {
                $tTextWhereStaPayment = " AND ISNULL(RC.FTXshDocNo,'') != '' ";
            } else {
                $tTextWhereStaPayment = " AND ISNULL(RC.FTXshDocNo,'') = '' ";
            }
        }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                // $tTextSubSale   .= ' UNION ALL ';
            }
            switch ($nStaAppType) {
                case '1': {
                        $tTextSubSale .= "  SELECT PSSALE.*
                                        FROM(
                                            SELECT DISTINCT
                                                HD.FTXshDocNo,HD.FNXshDocType,HD.FCXshGrand,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TPSTSalHD HD WITH(NOLOCK)
                                            INNER JOIN TPSTSalDT DT WITH(NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo
                                            INNER JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TPSTSalRc RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWhereStaPayment
                                        ) PSSALE
                                        WHERE 1=1
                                        $tTextWhereCstHavePS
                                       
                    ";
                        break;
                    }
                case '2': {
                        // $tTextSubSale .= "  SELECT VDSALE.*
                        //                     FROM (
                        //                         SELECT DISTINCT
                        //                             HD.FTXshDocNo,HD.FNXshDocType,HD.FCXshGrand,
                        //                             CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                        //                             ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                        //                         FROM TVDTSalHD HD WITH(NOLOCK)
                        //                         INNER JOIN TVDTSalDT DT WITH(NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo
                        //                         INNER JOIN (
                        //                             SELECT
                        //                                 RC.FTBchCode,RC.FTXshDocNo,
                        //                                 COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                        //                             FROM TVDTSalRc RC WITH(NOLOCK)
                        //                             LEFT JOIN TFNMRcv RCV WITH(NOLOCK) ON  RC.FTRcvCode = RCV.FTRcvCode  
                        //                             -- WHERE 1=1 AND RCV.FTFmtCode <> '004'
                        //                             GROUP BY RC.FTBchCode,RC.FTXshDocNo
                        //                         ) RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                        //                         LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTShpCode = SHP.FTShpCode
                        //                         WHERE 1=1 
                        //                         AND HD.FTXshStaDoc = 1
                        //                         $tTextWhereDateData
                        //                         $tTextWhereBranch
                        //                         $tTextWhereMerchant
                        //                         $tTextWhereShop
                        //                         $tTextWherePos
                        //                     ) VDSALE
                        //                     WHERE 1=1 
                        //                     $tTextWhereCstHaveVD
                        //                     $tTextWhereStaRcVD
                        // ";
                        break;
                    }
                case '3': {
                        // $tTextSubSale .= "  SELECT RTSALE.*
                        //                     FROM (
                        //                         SELECT DISTINCT
                        //                             HD.FTXshDocNo,HD.FNXshDocType,HD.FCXshGrand,
                        //                             CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                        //                             ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                        //                         FROM TRTTSalHD HD WITH(NOLOCK)
                        //                         INNER JOIN TRTTSalDT DT WITH(NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo
                        //                         INNER JOIN (
                        //                             SELECT
                        //                                 RC.FTBchCode,RC.FTXsdRefDocNo,
                        //                                 COUNT(RC.FTXsdRefDocNo) AS FNCountSaleRc
                        //                             FROM TRTTPayDT RC WITH(NOLOCK)
                        //                             GROUP BY RC.FTBchCode,RC.FTXsdRefDocNo
                        //                         ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXsdRefDocNo
                        //                         WHERE 1=1
                        //                         AND HD.FTXshStaDoc = 1
                        //                         $tTextWhereDateData
                        //                         $tTextWhereBranch
                        //                         $tTextWhereMerchant
                        //                         $tTextWhereShop
                        //                         $tTextWherePos
                        //                     ) RTSALE
                        //                     WHERE 1=1
                        //                     $tTextWhereCstHaveRT
                        //                     $tTextWhereStaRcRT
                        // ";
                        break;
                    }
            }
        }

        $tSQL   = " SELECT 
                        SUM(CASE WHEN ALLSALE.FNXshDocType = 1 THEN ALLSALE.FCXshGrand ELSE ALLSALE.FCXshGrand * -1 END) AS FCXshTotalAll,
                        SUM(CASE WHEN ALLSALE.FNXshDocType = 1 THEN ALLSALE.FCXshGrand ELSE 0 END) AS FCXshTotalSaleAll,
                        SUM(CASE WHEN ALLSALE.FNXshDocType = 9 THEN ALLSALE.FCXshGrand ELSE 0 END) AS FCXshTotalRefundAll
                    FROM (" . $tTextSubSale . ") ALLSALE
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn    = $oQuery->row_array();
        } else {
            $aDataReturn    = [];
        }
        unset($nLngID);
        unset($aStaAppType);
        unset($tTextWhereBranch);
        unset($tTextWhereMerchant);
        unset($tTextWhereShop);
        unset($tTextWherePos);
        unset($tTextWherePdt);
        unset($tTextWhereCstHavePS);
        unset($tTextWhereCstHaveVD);
        unset($tTextWhereCstHaveRT);
        unset($tTextWhereStaRcPS);
        unset($tTextWhereStaRcVD);
        unset($tTextWhereStaRcRT);
        unset($tTextSubSale);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Data Total Sale By Pdt Grp
    // Parameters: function parameters
    // Creator:  15/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALTotalSaleByPdtGrp($paDataWhere)
    {
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Data Where Date Data
        $tTextWhereDateData     = '';
        if (!empty($paDataWhere['tDateDataForm']) && !empty($paDataWhere['tDateDataTo'])) {
            $tTextWhereDateData = " AND (CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) OR CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121))";
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND SHP.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop     = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND SHP.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterPosCode']) && !empty($paDataWhere['tFilterPosCode'])) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPosCode']) . ')';
            }
        }

        // Check Data Where In Product Group
        $tTextWherePdtGroup = '';
        if (isset($paDataWhere['bFilterPgpStaAll']) && $paDataWhere['bFilterPgpStaAll'] == false) {
            if (isset($paDataWhere['tFilterPgpCode']) && !empty($paDataWhere['tFilterPgpCode'])) {
                $tTextWherePdtGroup = 'AND GRP.FTPgpChain IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPgpCode']) . ')';
            }
        }

        // Check Data Where Customer Have
        $tTextWhereCstHavePS    = '';
        $tTextWhereCstHaveVD    = '';
        $tTextWhereCstHaveRT    = '';
        if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
            if ($paDataWhere['tFilterStaCst'] == '1') {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave > 0';
            } else {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave = 0';
            }
        }

        // Check Data Where Status Payment
        // $tTextWhereStaRcPS  = '';
        // $tTextWhereStaRcVD  = '';
        // $tTextWhereStaRcRT  = '';
        // if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
        //     if ($paDataWhere['tFilterStaCst'] == '1') {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc > 0';
        //     } else {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc = 0';
        //     }
        // }


        $tTextWhereStaPayment = '';
        if (isset($paDataWhere['tFilterStaPayment']) && !empty($paDataWhere['tFilterStaPayment'])) {
            if ($paDataWhere['tFilterStaPayment'] == '1') {
                $tTextWhereStaPayment = " AND ISNULL(HD.FTXshDocNo,'') != '' ";
            } else {
                $tTextWhereStaPayment = " AND ISNULL(HD.FTXshDocNo,'') = '' ";
            }
        }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                $tTextSubSale   .= ' UNION ALL ';
            }
            // Switch Case Check App Type
            switch ($nStaAppType) {
                case '1': {
                        $tTextSubSale .= "  SELECT PSSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(GRP.FTPgpChainName, 'N/A') AS FTPgpChainName, 
                                                HD.FNXshDocType,
                                                DT.FCXsdNetAfHD AS FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TPSTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TPSTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TPSTSalRc RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                                            LEFT JOIN TCNMPdtGrp_L GRP WITH(NOLOCK) ON PDT.FTPgpChain = GRP.FTPgpChain AND GRP.FNLngID = '1'
                                            LEFT JOIN TCNMShop	SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdtGroup
                                            $tTextWhereStaPayment
                                        ) PSSALE
                                        WHERE 1=1
                                        $tTextWhereCstHavePS
                                        
                    ";
                        break;
                    }
                case '2': {
                        $tTextSubSale .= "  SELECT VDSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(GRP.FTPgpChainName, 'N/A') AS FTPgpChainName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNetAfHD AS FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TVDTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TVDTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            INNER JOIN (
                                                SELECT
                                                    RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TVDTSalRC RC WITH(NOLOCK)
                                                LEFT JOIN TFNMRcv RCV WITH(NOLOCK) ON  RC.FTRcvCode = RCV.FTRcvCode  
                                                -- WHERE 1=1 AND RCV.FTFmtCode <> '004'
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                                            LEFT JOIN TCNMPdtGrp_L GRP WITH(NOLOCK) ON PDT.FTPgpChain = GRP.FTPgpChain AND GRP.FNLngID = '1'
                                            LEFT JOIN TCNMShop	SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdtGroup
                                            $tTextWhereStaPayment
                                        ) VDSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveVD
                                    
                    ";
                        break;
                    }
                case '3': {
                        $tTextSubSale .= "  SELECT RTSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(GRP.FTPgpChainName, 'N/A') AS FTPgpChainName,
                                                HD.FNXshDocType, 
                                                DT.FCXsdNetAfHD AS FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TRTTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TRTTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT
                                                    RC.FTBchCode,RC.FTXsdRefDocNo,
                                                    COUNT(RC.FTXsdRefDocNo) AS FNCountSaleRc
                                                FROM TRTTPayDT RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXsdRefDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXsdRefDocNo
                                            LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                                            LEFT JOIN TCNMPdtGrp_L GRP WITH(NOLOCK) ON PDT.FTPgpChain = GRP.FTPgpChain AND GRP.FNLngID = '1'
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON DT.FTBchCode = SHP.FTBchCode AND DT.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdtGroup
                                            $tTextWhereStaPayment
                                        ) RTSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveRT
                                        
                    ";
                        break;
                    }
            }
        }

        $tSQL   = " SELECT
                        ALLSALE.FTPgpChainName,
                        SUM(CASE WHEN ALLSALE.FNXshDocType = 1 THEN ALLSALE.FCXsdNet ELSE ALLSALE.FCXsdNet * -1 END) AS FCXsdNet
                    FROM (" . $tTextSubSale . ") ALLSALE
                    GROUP BY FTPgpChainName
                    ORDER BY FTPgpChainName;
        ";
        // print_r($tSQL);
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn    = $oQuery->result_array();
        } else {
            $aDataReturn    = [];
        }

        unset($nLngID);
        unset($aStaAppType);
        unset($tTextSubSale);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Data Total Sale By Pdt Typ
    // Parameters: function parameters
    // Creator:  15/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALTotalSaleByPdtPty($paDataWhere)
    {
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Data Where Date Data
        $tTextWhereDateData     = '';
        if (!empty($paDataWhere['tDateDataForm']) && !empty($paDataWhere['tDateDataTo'])) {
            $tTextWhereDateData = " AND (CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) OR CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121))";
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND SHP.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop     = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND SHP.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterPosCode']) && !empty($paDataWhere['tFilterPosCode'])) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPosCode']) . ')';
            }
        }

        // Check Data Where In Product Type
        $tTextWherePdtType  = '';
        if (isset($paDataWhere['bFilterPtyStaAll']) && $paDataWhere['bFilterPtyStaAll'] == false) {
            if (isset($paDataWhere['tFilterPtyCode']) && !empty($paDataWhere['tFilterPtyCode'])) {
                $tTextWherePdtType  = 'AND PDT.FTPtyCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPtyCode']) . ')';
            }
        }

        // Check Data Where Customer Have
        $tTextWhereCstHavePS    = '';
        $tTextWhereCstHaveVD    = '';
        $tTextWhereCstHaveRT    = '';
        if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
            if ($paDataWhere['tFilterStaCst'] == '1') {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave > 0';
            } else {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave = 0';
            }
        }

        // Check Data Where Status Payment
        // $tTextWhereStaRcPS  = '';
        // $tTextWhereStaRcVD  = '';
        // $tTextWhereStaRcRT  = '';
        // if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
        //     if ($paDataWhere['tFilterStaCst'] == '1') {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc > 0';
        //     } else {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc = 0';
        //     }
        // }

        $tTextWhereStaPayment = '';
        if (isset($paDataWhere['tFilterStaPayment']) && !empty($paDataWhere['tFilterStaPayment'])) {
            if ($paDataWhere['tFilterStaPayment'] == '1') {
                $tTextWhereStaPayment = " AND ISNULL(HD.FTXshDocNo,'') != '' ";
            } else {
                $tTextWhereStaPayment = " AND ISNULL(HD.FTXshDocNo,'') = '' ";
            }
        }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                $tTextSubSale   .= ' UNION ALL ';
            }
            // Switch Case Check App Type
            switch ($nStaAppType) {
                case '1': {
                        $tTextSubSale .= "  SELECT PSSALE.*
                                        FROM (
                                            SELECT 
                                                ISNULL(PTY.FTPtyName, 'N/A') AS FTPtyName, 
                                                HD.FNXshDocType, 
                                                DT.FCXsdNetAfHD AS FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TPSTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TPSTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TPSTSalRc RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                                            LEFT JOIN TCNMPdtType_L PTY WITH(NOLOCK) ON PDT.FTPtyCode = PTY.FTPtyCode AND PTY.FNLngID = '$nLngID'
                                            LEFT JOIN TCNMShop	SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdtType
                                            $tTextWhereStaPayment
                                        ) PSSALE
                                        WHERE 1=1
                                        $tTextWhereCstHavePS
                                        
                    ";
                        break;
                    }
                case '2': {
                        $tTextSubSale .= "  SELECT VDSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(PTY.FTPtyName,'N/A') AS FTPtyName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNetAfHD AS FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TVDTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TVDTSalHD  HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            INNER JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TVDTSalRC RC WITH(NOLOCK)
                                                LEFT JOIN TFNMRcv RCV WITH(NOLOCK) ON  RC.FTRcvCode = RCV.FTRcvCode  
                                                -- WHERE 1=1 AND RCV.FTFmtCode <> '004'
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                                            LEFT JOIN TCNMPdtType_L PTY WITH(NOLOCK) ON PDT.FTPtyCode	= PTY.FTPtyCode AND PTY.FNLngID = '$nLngID'
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdtType
                                            $tTextWhereStaPayment
                                        ) VDSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveVD
                                       
                    ";
                        break;
                    }
                case '3': {
                        $tTextSubSale .= "  SELECT RTSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(PTY.FTPtyName,'N/A') AS FTPtyName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNetAfHD AS FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TRTTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TRTTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT RC.FTBchCode,RC.FTXsdRefDocNo,COUNT(RC.FTXsdRefDocNo) AS FNCountSaleRc
                                                FROM TRTTPayDT RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXsdRefDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXsdRefDocNo
                                            LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                                            LEFT JOIN TCNMPdtType_L PTY WITH(NOLOCK) ON PDT.FTPtyCode	= PTY.FTPtyCode AND PTY.FNLngID = '1'
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON DT.FTBchCode = SHP.FTBchCode AND DT.FTShpCode = SHP.FTShpCode 
                                            WHERE 1=1 
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdtType
                                        ) RTSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveRT
                                        
                    ";
                        break;
                    }
            }
        }

        $tSQL   = " SELECT
                        ALLSALE.FTPtyName, 
                        SUM(CASE WHEN ALLSALE.FNXshDocType = 1 THEN ALLSALE.FCXsdNet ELSE ALLSALE.FCXsdNet * -1 END) AS FCXsdNet
                    FROM (" . $tTextSubSale . ") ALLSALE
                    GROUP BY FTPtyName
                    ORDER BY FTPtyName;
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn    = $oQuery->result_array();
        } else {
            $aDataReturn    = [];
        }
        unset($nLngID);
        unset($aStaAppType);
        unset($tTextSubSale);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Data Total Sale By Recive
    // Parameters: function parameters
    // Creator:  15/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALTotalSaleByRcv($paDataWhere)
    {
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Data Where Date Data
        $tTextWhereDateData     = '';
        if (!empty($paDataWhere['tDateDataForm']) && !empty($paDataWhere['tDateDataTo'])) {
            $tTextWhereDateData = " AND (CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) OR CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121))";
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND SHP.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop     = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND SHP.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterPosCode']) && !empty($paDataWhere['tFilterPosCode'])) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPosCode']) . ')';
            }
        }

        // Check Data Where In Recive
        $tTextWhereRcv      = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterRcvCode']) && !empty($paDataWhere['tFilterRcvCode'])) {
                $tTextWhereRcv  = 'AND RC.FTRcvCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterRcvCode']) . ')';
            }
        }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                $tTextSubSale   .= ' UNION ALL ';
            }
            // Switch Case Check App Type
            switch ($nStaAppType) {
                case '1': {
                        $tTextSubSale .= "  SELECT PSSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(RCV.FTRcvName,'N/A') AS FTRcvName,
                                                HD.FNXshDocType,
                                                RC.FCXrcNet
                                            FROM TPSTSalHD HD WITH(NOLOCK)
                                            LEFT JOIN TPSTSalRC RC WITH(NOLOCK) 	ON HD.FTXshDocNo 	= RC.FTXshDocNo
                                            LEFT JOIN TCNMShop	SHP WITH(NOLOCK) 	ON HD.FTShpCode		= SHP.FTShpCode
                                            LEFT JOIN TFNMRcv_L RCV WITH(NOLOCK) 	ON RC.FTRcvCode 	= RCV.FTRcvCode AND RCV.FNLngID = '$nLngID'
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWhereRcv
                                        ) PSSALE
                    ";
                        break;
                    }
                case '2': {
                        $tTextSubSale .= "  SELECT VDSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(RC.FTRcvName,'N/A') AS FTRcvName,
                                                HD.FNXshDocType,
                                                RC.FCXrcNet
                                            FROM TVDTSalHD HD WITH(NOLOCK)
                                            INNER JOIN (
                                                SELECT RC.FTXshDocNo,RC.FTRcvCode,RCVL.FTRcvName,RC.FCXrcNet
                                                FROM TVDTSalRc RC WITH(NOLOCK)
                                                LEFT JOIN TFNMRcv RCV WITH(NOLOCK) ON RC.FTRcvCode = RCV.FTRcvCode
                                                LEFT JOIN TFNMRcv_L RCVL WITH(NOLOCK) ON RCV.FTRcvCode = RCVL.FTRcvCode AND RCVL.FNLngID = '$nLngID'
                                                --WHERE RCV.FTFmtCode <> '004'
                                            ) RC ON HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTShpCode	= SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWhereRcv
                                        ) VDSALE
                    ";
                        break;
                    }
                case '3': {
                        $tTextSubSale .= "  SELECT RTSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(RC.FTRcvName,'N/A') AS FTRcvName,
                                                HD.FNXshDocType,
                                                RC.FCXrcNet
                                            FROM TRTTSalHD HD WITH(NOLOCK)
                                            INNER JOIN TRTTSalDT DT WITH(NOLOCK) ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT
                                                    DT.FTXsdRefDocNo AS FTXshDocNo,RC.FTRcvCode,RC.FTRcvName,RC.FCXrcNet
                                                FROM TRTTPayDT DT WITH(NOLOCK)
                                                INNER JOIN TRTTPayRC RC WITH(NOLOCK) ON DT.FTXshDocNo = RC.FTXshDocNo
                                            ) RC ON HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON DT.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWhereRcv
                                        ) RTSALE
                    ";
                        break;
                    }
            }
        }

        $tSQL   = " SELECT
                        ALLSALE.FTRcvName,
                        ISNULL(SUM(CASE WHEN ALLSALE.FNXshDocType = 1 THEN ALLSALE.FCXrcNet ELSE ALLSALE.FCXrcNet * -1 END),'0.01') AS FCXsdNet
                    FROM (" . $tTextSubSale . ") ALLSALE
                    GROUP BY FTRcvName
                    ORDER BY FTRcvName;
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn    = $oQuery->result_array();
        } else {
            $aDataReturn    = [];
        }
        unset($nLngID);
        unset($aStaAppType);
        unset($tTextSubSale);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Data Pdt Stock Barlance
    // Parameters: function parameters
    // Creator:  04/02/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALPdtStkBal($paDataWhere)
    {
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Top Limit Select
        $nTopLimit  = 5;
        if (isset($paDataWhere['tFilterTopLimit']) && !empty($paDataWhere['tFilterTopLimit'])) {
            $nTopLimit  = $paDataWhere['tFilterTopLimit'];
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND STKBAL.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In WareHouse
        $tTextWhereWareHouse    = '';
        if (isset($paDataWhere['bFilterWahStaAll']) && $paDataWhere['bFilterWahStaAll'] == false) {
            if (isset($paDataWhere['tFilterWahCode']) && !empty($paDataWhere['tFilterWahCode'])) {
                $tTextWhereWareHouse    = 'AND STKBAL.FTWahCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterWahCode']) . ')';
            }
        }

        // Check Data Where In Product
        $tTextWhereProduct  = '';
        if (isset($paDataWhere['bFilterPdtStaAll']) && $paDataWhere['bFilterPdtStaAll'] == false) {
            if (isset($paDataWhere['tFilterPdtCode']) && !empty($paDataWhere['tFilterPdtCode'])) {
                $tTextWhereProduct  = 'AND STKBAL.FTPdtCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPdtCode']) . ')';
            }
        }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                $tTextSubSale   .= ' UNION ALL ';
            }
            // Switch Case Check App Type
            switch ($nStaAppType) {
                case '1': {
                        $tTextSubSale .= "  SELECT PSSALBAL.*
                                        FROM (
                                            SELECT
                                                CASE WHEN STKBAL.FTPdtCode IS NULL OR STKBAL.FTPdtCode = '' THEN 'N/A' ELSE STKBAL.FTPdtCode END AS FTPdtCode,
                                                ISNULL(PDTL.FTPdtName,'N/A') AS FTPdtName,
                                                FCStkQty
                                            FROM TCNTPdtStkBal STKBAL WITH(NOLOCK)
                                            LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON STKBAL.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '$nLngID'
                                            WHERE 1=1
                                            $tTextWhereBranch
                                            $tTextWhereWareHouse
                                            $tTextWhereProduct
                                        ) PSSALBAL
                    ";
                        break;
                    }
                case '2': {
                        $tTextSubSale .= "  SELECT VDSALBAL.*
                                        FROM (
                                            SELECT 
                                                CASE WHEN STKBAL.FTPdtCode IS NULL OR STKBAL.FTPdtCode = '' THEN 'N/A' ELSE STKBAL.FTPdtCode END AS FTPdtCode,
                                                ISNULL(PDTL.FTPdtName,'N/A') AS FTPdtName,
                                                FCStkQty
                                            FROM TVDTPdtStkBal STKBAL WITH(NOLOCK)
                                            LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON STKBAL.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '$nLngID'
                                            WHERE 1=1
                                            $tTextWhereBranch
                                            $tTextWhereWareHouse
                                            $tTextWhereProduct
                                        ) VDSALBAL
                    ";
                        break;
                    }
                case '3': {
                        $tTextSubSale .= "  SELECT RTSTKBAL.*
                                        FROM (
                                            SELECT 
                                                FTPdtCode   = 'N/A',
                                                FTPdtName   = 'N/A',
                                                FCStkQty    = 0
                                        ) RTSTKBAL
                    ";
                        break;
                    }
            }
        }

        $tSQL   = " SELECT TOP $nTopLimit
                        ALLSALE.FTPdtCode,
                        ALLSALE.FTPdtName,
                        SUM(ALLSALE.FCStkQty) AS FCStkQty
                    FROM (" . $tTextSubSale . ") ALLSALE
                    GROUP BY FTPdtCode,FTPdtName
                    ORDER BY FTPdtCode
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn    = $oQuery->result_array();
        } else {
            $aDataReturn    = [];
        }
        unset($nLngID);
        unset($aStaAppType);
        unset($tTextSubSale);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Data Top 10 New Product
    // Parameters: function parameters
    // Creator:  17/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALTopTenNewProduct($paDataWhere)
    {
        $nLngID = $paDataWhere['nLngID'];

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND PDTSPC.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterMerStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND PDTSPC.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop     = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND PDTSPC.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }


        $tSQL   = " SELECT TOP 10
                        PDT.FTPdtCode,
                        PDTL.FTPdtName,
                        IMGP.FTImgObj,
                        PDT.FDCreateOn
                    FROM TCNMPdt PDT WITH(NOLOCK)
                    LEFT JOIN TCNMPdtSpcBch PDTSPC WITH(NOLOCK) ON PDT.FTPdtCode = PDTSPC.FTPdtCode 
                    LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '$nLngID'
                    LEFT JOIN TCNMImgPdt IMGP WITH(NOLOCK) ON PDT.FTPdtCode = IMGP.FTImgRefID AND IMGP.FNImgSeq = 1 AND IMGP.FTImgKey = 'master' AND IMGP.FTImgTable = 'TCNMPdt'
                    WHERE 1=1
                    $tTextWhereBranch
                    $tTextWhereMerchant
                    $tTextWhereShop
                    ORDER BY PDT.FDCreateOn DESC
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn = $oQuery->result_array();
        } else {
            $aDataReturn = [];
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    // Functionality: Get Data Top 10 Best Seller
    // Parameters: function parameters
    // Creator:  17/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALTopTenBestSeller($paDataWhere)
    {
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Data Where Date Data
        $tTextWhereDateData     = '';
        if (!empty($paDataWhere['tDateDataForm']) && !empty($paDataWhere['tDateDataTo'])) {
            $tTextWhereDateData = " AND (CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) OR CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121))";
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND SHP.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop     = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND SHP.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterPosCode']) && !empty($paDataWhere['tFilterPosCode'])) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPosCode']) . ')';
            }
        }

        // Check Data Where In Product
        $tTextWherePdt  = '';
        if (isset($paDataWhere['bFilterPdtStaAll']) && $paDataWhere['bFilterPdtStaAll'] == false) {
            if (isset($paDataWhere['tFilterPdtCode']) && !empty($paDataWhere['tFilterPdtCode'])) {
                $tTextWherePdt  = 'AND DT.FTPdtCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPdtCode']) . ')';
            }
        }

        // Check Data Where Customer Have
        $tTextWhereCstHave   = '';

        if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
            if ($paDataWhere['tFilterStaCst'] == '1') {
                $tTextWhereCstHave   = ' AND FNStaCstHave > 0';
            } else {
                $tTextWhereCstHave   = ' AND FNStaCstHave = 0';
            }
        }

        // Check Data Where Status Payment
        // $tTextWhereStaRcPS  = '';
        // $tTextWhereStaRcVD  = '';
        // $tTextWhereStaRcRT  = '';
        // if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
        //     if ($paDataWhere['tFilterStaCst'] == '1') {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc > 0';
        //     } else {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc = 0';
        //     }
        // }


        $tTextWhereStaPayment = '';
        if (isset($paDataWhere['tFilterStaPayment']) && !empty($paDataWhere['tFilterStaPayment'])) {
            if ($paDataWhere['tFilterStaPayment'] == '1') {
                $tTextWhereStaPayment = " AND ISNULL(HD.FTXshDocNo,'') != '' ";
            } else {
                $tTextWhereStaPayment = " AND ISNULL(HD.FTXshDocNo,'') = '' ";
            }
        }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                /*$tTextSubSale   .= ' UNION ALL ';*/
            }
            // Switch Case Check App Type
            switch ($nStaAppType) {
                case '1': {
                        /*$tTextSubSale .= "  SELECT PSSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(DT.FTXsdPdtName,'N/A') AS FTPdtName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TPSTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TPSTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TPSTSalRc RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdt
                                        ) PSSALE
                                        WHERE 1=1
                                        $tTextWhereCstHavePS
                                        $tTextWhereStaRcPS
                    ";*/
                        break;
                    }
                case '2': {
                        /*$tTextSubSale .= "  SELECT VDSALE.*
                                        FROM (
                                            SELECT 
                                                ISNULL(DT.FTXsdPdtName,'N/A') AS FTPdtName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TVDTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TVDTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            INNER JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TVDTSalRC RC WITH(NOLOCK)
                                                LEFT JOIN TFNMRcv RCV WITH(NOLOCK) ON  RC.FTRcvCode = RCV.FTRcvCode  
                                                -- WHERE 1=1 AND RCV.FTFmtCode <> '004'
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdt
                                        ) VDSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveVD
                                        $tTextWhereStaRcVD
                    ";*/
                        break;
                    }
                case '3': {
                        /*$tTextSubSale .= "  SELECT RTSALE.*
                                        FROM (
                                            SELECT 
                                                ISNULL(PDTL.FTPdtName, 'N/A') AS FTPdtName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TRTTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TRTTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT
                                                    RC.FTBchCode,RC.FTXsdRefDocNo,
                                                    COUNT(RC.FTXsdRefDocNo) AS FNCountSaleRc
                                                FROM TRTTPayDT RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXsdRefDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXsdRefDocNo
                                            LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtName AND PDTL.FNLngID = '$nLngID'
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON DT.FTBchCode = SHP.FTBchCode AND DT.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdt
                                        ) RTSALE
                                        $tTextWhereCstHaveRT
                                        $tTextWhereStaRcRT
                    ";*/
                        break;
                    }
            }
        }

        /*$tSQL   = " SELECT TOP 10 
                        DATASALE.FTPdtName,
                        DATASALE.FCXsdNet
                    FROM (
                        SELECT
                            ALLSALE.FTPdtName,
                            SUM(CASE WHEN ALLSALE.FNXshDocType = 1 THEN ALLSALE.FCXsdNet ELSE ALLSALE.FCXsdNet * -1 END) AS FCXsdNet
                        FROM (".$tTextSubSale.") ALLSALE
                        GROUP BY ALLSALE.FTPdtName
                    ) DATASALE
                    ORDER BY DATASALE.FCXsdNet DESC";*/


        $tSQL   = " SELECT 
                        TOP 10 
                        TOPBESTSELL.* 
                    FROM (SELECT 
                        DT.FTPdtCode,
                        PDTL.FTPdtName,
                        CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                        SUM(CASE WHEN 
                            HD.FNXshDocType = 1
                        THEN 
                            DT.FCXsdQty * 1 
                        ELSE
                            DT.FCXsdQty * -1 
                        END ) AS FCXsdNet                    
                        FROM TPSTSalDT DT
                        LEFT JOIN TPSTSalHD HD ON HD.FTXshDocNo = DT.FTXshDocNo
                        LEFT JOIN TCNMPdt_L PDTL ON DT.FTPdtCode = PDTL.FTPdtCode
                        WHERE 1=1 AND HD.FTXshStaDoc = 1
                        $tTextWhereDateData
                        $tTextWhereBranch
                        $tTextWhereMerchant
                        $tTextWhereShop
                        $tTextWherePos
                        $tTextWherePdt
                        $tTextWhereStaPayment
                        $tTextWhereCstHave
                    GROUP BY DT.FTPdtCode , PDTL.FTPdtName , HD.FTCstCode
                    ) AS TOPBESTSELL ORDER BY TOPBESTSELL.FCXsdNet DESC";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn = $oQuery->result_array();
        } else {
            $aDataReturn = [];
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }



    // Functionality: Get Data Top 10 Best Seller By Value
    // Parameters: function parameters
    // Creator:  17/07/2020 Worakorn
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALTopTenBestSellerByValue($paDataWhere)
    {

        // print_r($paDataWhere); die();
        $nLngID         = $paDataWhere['nLngID'];
        $aStaAppType    = $paDataWhere['aStaAppType'];
        $tTextSubSale   = '';

        // Check Data Where Date Data
        $tTextWhereDateData     = '';
        if (!empty($paDataWhere['tDateDataForm']) && !empty($paDataWhere['tDateDataTo'])) {
            $tTextWhereDateData = " AND (CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) OR CONVERT(DATE,HD.FDXshDocDate,121) BETWEEN CONVERT(DATE,'" . $paDataWhere['tDateDataTo'] . "',121) AND CONVERT(DATE,'" . $paDataWhere['tDateDataForm'] . "',121))";
        }

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterBchStaAll'] == false) {
            if (isset($paDataWhere['tFilterBchCode']) && !empty($paDataWhere['tFilterBchCode'])) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterBchCode']) . ')';
            }
        }

        // Check Data Where In Merchant
        $tTextWhereMerchant = '';
        if (isset($paDataWhere['bFilterBchStaAll']) && $paDataWhere['bFilterMerStaAll'] == false) {
            if (isset($paDataWhere['tFilterMerCode']) && !empty($paDataWhere['tFilterMerCode'])) {
                $tTextWhereMerchant = 'AND SHP.FTMerCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterMerCode']) . ')';
            }
        }

        // Check Data Where In Shop
        $tTextWhereShop     = '';
        if (isset($paDataWhere['bFilterShpStaAll']) && $paDataWhere['bFilterShpStaAll'] == false) {
            if (isset($paDataWhere['tFilterShpCode']) && !empty($paDataWhere['tFilterShpCode'])) {
                $tTextWhereShop = 'AND SHP.FTShpCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterShpCode']) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($paDataWhere['bFilterPosStaAll']) && $paDataWhere['bFilterPosStaAll'] == false) {
            if (isset($paDataWhere['tFilterPosCode']) && !empty($paDataWhere['tFilterPosCode'])) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPosCode']) . ')';
            }
        }

        // Check Data Where In Product
        $tTextWherePdt  = '';
        if (isset($paDataWhere['bFilterPdtStaAll']) && $paDataWhere['bFilterPdtStaAll'] == false) {
            if (isset($paDataWhere['tFilterPdtCode']) && !empty($paDataWhere['tFilterPdtCode'])) {
                $tTextWherePdt  = 'AND DT.FTPdtCode IN (' . FCNtAddSingleQuote($paDataWhere['tFilterPdtCode']) . ')';
            }
        }

        // Check Data Where Customer Have
        $tTextWhereCstHavePS    = '';
        $tTextWhereCstHaveVD    = '';
        $tTextWhereCstHaveRT    = '';
        if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
            if ($paDataWhere['tFilterStaCst'] == '1') {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave > 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave > 0';
            } else {
                $tTextWhereCstHavePS    = ' AND PSSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveVD    = ' AND VDSALE.FNStaCstHave = 0';
                $tTextWhereCstHaveRT    = ' AND RTSALE.FNStaCstHave = 0';
            }
        }

        // Check Data Where Status Payment
        // $tTextWhereStaRcPS  = '';
        // $tTextWhereStaRcVD  = '';
        // $tTextWhereStaRcRT  = '';
        // if (isset($paDataWhere['tFilterStaCst']) && !empty($paDataWhere['tFilterStaCst'])) {
        //     if ($paDataWhere['tFilterStaCst'] == '1') {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc > 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc > 0';
        //     } else {
        //         $tTextWhereStaRcPS  = ' AND PSSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcVD  = ' AND VDSALE.FNCountSaleRc = 0';
        //         $tTextWhereStaRcRT  = ' AND RTSALE.FNCountSaleRc = 0';
        //     }
        // }

        // Loop Status App Type Select
        foreach ($aStaAppType as $nKey => $nStaAppType) {
            // Check Union All
            if (isset($tTextSubSale) && !empty($tTextSubSale)) {
                /*$tTextSubSale   .= ' UNION ALL ';*/
            }
            // Switch Case Check App Type
            switch ($nStaAppType) {
                case '1': {
                        /*$tTextSubSale .= "  SELECT PSSALE.*
                                        FROM (
                                            SELECT
                                                ISNULL(DT.FTXsdPdtName,'N/A') AS FTPdtName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TPSTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TPSTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TPSTSalRc RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdt
                                        ) PSSALE
                                        WHERE 1=1
                                        $tTextWhereCstHavePS
                                        $tTextWhereStaRcPS
                    ";*/
                        break;
                    }
                case '2': {
                        /*$tTextSubSale .= "  SELECT VDSALE.*
                                        FROM (
                                            SELECT 
                                                ISNULL(DT.FTXsdPdtName,'N/A') AS FTPdtName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TVDTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TVDTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            INNER JOIN (
                                                SELECT RC.FTBchCode,RC.FTXshDocNo,COUNT(RC.FTXshDocNo) AS FNCountSaleRc
                                                FROM TVDTSalRC RC WITH(NOLOCK)
                                                LEFT JOIN TFNMRcv RCV WITH(NOLOCK) ON  RC.FTRcvCode = RCV.FTRcvCode  
                                                -- WHERE 1=1 AND RCV.FTFmtCode <> '004'
                                                GROUP BY RC.FTBchCode,RC.FTXshDocNo
                                            ) RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON HD.FTBchCode = SHP.FTBchCode AND HD.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdt
                                        ) VDSALE
                                        WHERE 1=1
                                        $tTextWhereCstHaveVD
                                        $tTextWhereStaRcVD
                    ";*/
                        break;
                    }
                case '3': {
                        /*$tTextSubSale .= "  SELECT RTSALE.*
                                        FROM (
                                            SELECT 
                                                ISNULL(PDTL.FTPdtName, 'N/A') AS FTPdtName,
                                                HD.FNXshDocType,
                                                DT.FCXsdNet,
                                                CASE WHEN HD.FTCstCode IS NULL THEN 0 ELSE 1 END AS FNStaCstHave,
                                                ISNULL(RC.FNCountSaleRc,0) AS FNCountSaleRc
                                            FROM TRTTSalDT DT WITH(NOLOCK)
                                            INNER JOIN TRTTSalHD HD WITH(NOLOCK) ON DT.FTXshDocNo = HD.FTXshDocNo
                                            LEFT JOIN (
                                                SELECT
                                                    RC.FTBchCode,RC.FTXsdRefDocNo,
                                                    COUNT(RC.FTXsdRefDocNo) AS FNCountSaleRc
                                                FROM TRTTPayDT RC WITH(NOLOCK)
                                                GROUP BY RC.FTBchCode,RC.FTXsdRefDocNo
                                            ) AS RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXsdRefDocNo
                                            LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtName AND PDTL.FNLngID = '$nLngID'
                                            LEFT JOIN TCNMShop SHP WITH(NOLOCK) ON DT.FTBchCode = SHP.FTBchCode AND DT.FTShpCode = SHP.FTShpCode
                                            WHERE 1=1
                                            AND HD.FTXshStaDoc = 1
                                            $tTextWhereDateData
                                            $tTextWhereBranch
                                            $tTextWhereMerchant
                                            $tTextWhereShop
                                            $tTextWherePos
                                            $tTextWherePdt
                                        ) RTSALE
                                        $tTextWhereCstHaveRT
                                        $tTextWhereStaRcRT
                    ";*/
                        break;
                    }
            }
        }

        /*$tSQL   = " SELECT TOP 10 
                        DATASALE.FTPdtName,
                        DATASALE.FCXsdNet
                    FROM (
                        SELECT
                            ALLSALE.FTPdtName,
                            SUM(CASE WHEN ALLSALE.FNXshDocType = 1 THEN ALLSALE.FCXsdNet ELSE ALLSALE.FCXsdNet * -1 END) AS FCXsdNet
                        FROM (".$tTextSubSale.") ALLSALE
                        GROUP BY ALLSALE.FTPdtName
                    ) DATASALE
                    ORDER BY DATASALE.FCXsdNet DESC";*/


        $tSQL   = " SELECT TOP 10 S.*
        FROM
        (
            SELECT DT.FTPdtCode, 
                   PDTL.FTPdtName, 
                   SUM(CASE
                           WHEN HD.FNXshDocType = 1
                           THEN DT.FCXsdNetAfHD
                           ELSE DT.FCXsdNetAfHD * -1
                       END) AS FCXsdNet
            FROM TPSTSalDT DT
                 LEFT JOIN TPSTSalHD HD ON DT.FTXshDocNo = HD.FTXshDocNo
                                           AND DT.FTBchCode = HD.FTBchCode
                 LEFT JOIN TCNMPdt_L PDTL ON DT.FTPdtCode = PDTL.FTPdtCode
            WHERE HD.FTXshStaDoc = 1
                  AND DT.FTXsdStaPdt <> 4
                        $tTextWhereDateData
                        $tTextWhereBranch
                        $tTextWhereMerchant
                        $tTextWhereShop
                        $tTextWherePos
                        $tTextWherePdt
                        GROUP BY DT.FTPdtCode, 
                       PDTL.FTPdtName ) S ORDER BY FCXsdNet DESC";

        $oQuery = $this->db->query($tSQL);
        // print_r($tSQL); die();
        if ($oQuery->num_rows() > 0) {
            $aDataReturn = $oQuery->result_array();
        } else {
            $aDataReturn = [];
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }


    // Functionality: Get Data Total By Branch
    // Parameters: function parameters
    // Creator:  06/10/2020 Worakorn
    // Return: Data Array
    // Return Type: Array
    public function FSaMDSHSALTotalSaleByBranch($paData)
    {
       

        $dDateFrom = $this->input->post('ptDateDataForm');
        $dDateTo = $this->input->post('ptDateDataTo');
        $oetDSHSALSort = $this->input->post('oetDSHSALSort');
        $oetDSHSALFild = $this->input->post('oetDSHSALFild');

        // Branch Filter
        $tDSHSALFilterBchStaAll  = (!empty($this->input->post('oetDSHSALFilterBchStaAll')) && ($this->input->post('oetDSHSALFilterBchStaAll') == 1)) ? true : false;
        $nDSHSALFilterBchCode    = (!empty($this->input->post('oetDSHSALFilterBchCode'))) ? $this->input->post('oetDSHSALFilterBchCode') : "";
        $tDSHSALFilterBchName   = (!empty($this->input->post('oetDSHSALFilterBchName'))) ? $this->input->post('oetDSHSALFilterBchName') : "";
        // Pos Filter
        $tDSHSALFilterPosStaAll  = (!empty($this->input->post('oetDSHSALFilterPosStaAll')) && ($this->input->post('oetDSHSALFilterPosStaAll') == 1)) ? true : false;
        $nDSHSALFilterPosCode  = (!empty($this->input->post('oetDSHSALFilterPosCode'))) ? $this->input->post('oetDSHSALFilterPosCode') : "";
        $tDSHSALFilterPosName    = (!empty($this->input->post('oetDSHSALFilterPosName'))) ? $this->input->post('oetDSHSALFilterPosName') : "";
        // Diff Filter
        // $tDSHSALFilterDiff = $this->input->post('orbDSHSALDiff');
        $tDSHSALFilterDiff = (!empty($this->input->post('orbDSHSALDiff'))) ? $this->input->post('orbDSHSALDiff') : "";

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($tDSHSALFilterBchStaAll) &&  $tDSHSALFilterBchStaAll == false) {
            if (isset($nDSHSALFilterBchCode) && !empty($nDSHSALFilterBchCode)) {
                $tTextWhereBranch   = 'AND HD.FTBchCode IN (' . FCNtAddSingleQuote($nDSHSALFilterBchCode) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($tDSHSALFilterPosStaAll) && $tDSHSALFilterPosStaAll == false) {
            if (isset($nDSHSALFilterPosCode) && !empty($nDSHSALFilterPosCode)) {
                $tTextWherePos  = 'AND HD.FTPosCode IN (' . FCNtAddSingleQuote($nDSHSALFilterPosCode) . ')';
            }
        }

        // Check Data Where Diff
        $tTextWhereDiff      = '';
        if ($tDSHSALFilterDiff == '1') {
            $tTextWhereDiff  = 'WHERE BillChk - BillQty <> 0';
        }


        $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);


        $tUsrBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
        $tUsrLevel = $this->session->userdata("tSesUsrLevel");
        $tTextWhereBranchRole = '';
        if ($tUsrLevel != 'HQ') {
            $tTextWhereBranchRole =  "AND  HD.FTBchCode IN ($tUsrBchCodeMulti)";
        }


        
        // $tSQL   = " SELECT c.* FROM (
        //     SELECT
        //       ROW_NUMBER() OVER(ORDER BY $oetDSHSALFild $oetDSHSALSort ) AS rtRowID, 
        //       DataMain.*
        //     FROM (
        //   SELECT
        //    BCH.FTBchName,
        //    SALE.FTPosCode,
        //    SALE.FNXshDocType,
        //    SALE.BillMin,
        //    SALE.BillMax,
        //    SALE.BillQty,
        //    SALE.BillAmt,
        //    (
        //     CONVERT (bigint, RIGHT(BillMax, 7)) - CONVERT (bigint, RIGHT(BillMin, 7))
        //    ) + 1 AS BillChk ,
        //     ISNULL((SALE.BillQty - ( (
        //     CONVERT (bigint, RIGHT(BillMax, 7)) - CONVERT (bigint, RIGHT(BillMin, 7))
        //    ) + 1) ),0) AS BillDiff
        //   FROM
        //    (
        //     SELECT
        //      SHD.FTBchCode,
        //      SHD.FTPosCode,
        //      FNXshDocType,
        //      MIN (SHD.FTLstDocNoFrm) AS BillMin,
        //      MAX (SHD.FTLstDocNoTo) AS BillMax,
        //      COUNT (FTXshDocNo) AS BillQty,
        //      SUM (FCXshGrand) AS BillAmt

        //     FROM
        //      TPSTSalHD HD
        //     INNER JOIN TPSTShiftSLastDoc SHD ON HD.FTBchCode = SHD.FTBchCode
        //     AND HD.FTShfCode = SHD.FTShfCode
        //     AND HD.FNXshDocType = SHD.FNLstDocType
        //     WHERE
        //      CONVERT (DATE, FDXshDocDate, 103) BETWEEN '" . $dDateFrom . "'
        //     AND '" . $dDateTo . "'
        //     $tTextWhereBranch 
        //     $tTextWherePos
        //     GROUP BY
        //      SHD.FTBchCode,
        //      SHD.FTPosCode,
        //      FNXshDocType
        //    ) SALE
        //   INNER JOIN TCNMBranch_L BCH ON SALE.FTBchCode = BCH.FTBchCode
        //   AND FNLngID = 1  $tTextWhereDiff";


        //         $tSQL = " SELECT
        // c.*
        // FROM
        // (
        //  SELECT
        //   ROW_NUMBER () OVER (ORDER BY $oetDSHSALFild $oetDSHSALSort ) AS rtRowID,
        //   DataMain.*
        //  FROM
        //   (
        // SELECT *,BillChk-BillQty AS BillDiff 
        // FROM (
        // SELECT BCH.FTBchName,SALE.FTPosCode,SALE.FDXshDocDate,SALE.FTShfCode, SALE.FNXshDocType,SALE.BillMin,SALE.BillMax,SALE.BillQty,SALE.BillAmt
        // , ISNULL((CONVERT(bigint, RIGHT(BillMax,7))-CONVERT(bigint, RIGHT(BillMin,7)))+1,0) AS BillChk 
        // FROM (
        // SELECT convert(date, HD.FDXshDocDate,103)AS FDXshDocDate,SHD.FTShfCode,SHD.FTBchCode,  SHD.FTPosCode,FNXshDocType
        // ,MIN(SHD.FTLstDocNoFrm) AS BillMin
        // ,MAX(SHD.FTLstDocNoTo) AS BillMax
        // ,COUNT(FTXshDocNo)AS BillQty,SUM(FCXshGrand)AS BillAmt 
        // FROM TPSTSalHD HD 
        // INNER JOIN TPSTShiftSLastDoc SHD
        // ON HD.FTBchCode=SHD.FTBchCode 
        // AND HD.FTShfCode =SHD.FTShfCode 
        // AND HD.FNXshDocType =SHD.FNLstDocType
        // WHERE  convert(date, HD.FDXshDocDate,103)
        // BETWEEN  '" . $dDateFrom . "' AND  '" . $dDateTo . "' 
        // $tTextWhereBranch 
        // $tTextWherePos  
        // GROUP BY SHD.FTBchCode,SHD.FTPosCode,convert(date, HD.FDXshDocDate,103),SHD.FTShfCode,HD.FNXshDocType)SALE 
        // INNER JOIN TCNMBranch_L BCH ON SALE.FTBchCode=BCH.FTBchCode AND FNLngID =1)MONITOR

        // $tTextWhereDiff

        //  ";



        $tSQL = " SELECT c.*
FROM
(
    SELECT ROW_NUMBER() OVER(
           ORDER BY $oetDSHSALFild $oetDSHSALSort) AS rtRowID, 
           DataMain.*
    FROM
    (
        SELECT *, 
               BillChk - BillQty AS BillDiff
        FROM
        (
            SELECT BCH.FTBchName, 
                   SALE.FTPosCode, 
                   SALE.FDXshDocDate, 
                   SALE.FTShfCode, 
                   SALE.FNXshDocType, 
                   SALE.BillMin, 
                   SALE.BillMax, 
                   SALE.BillQty, 
                   SALE.BillAmt, 
                   ISNULL((CONVERT(BIGINT, RIGHT(BillMax, 7)) - CONVERT(BIGINT, RIGHT(BillMin, 7))) + 1, 0) AS BillChk
            FROM
            (
                SELECT CONVERT(DATE, HD.FDXshDocDate, 103) AS FDXshDocDate, 
                       HD.FTShfCode, 
                       HD.FTBchCode, 
                       HD.FTPosCode, 
                       HD.FNXshDocType, 
                       MIN(SHD.FTLstDocNoFrm) AS BillMin, 
                       MAX(SHD.FTLstDocNoTo) AS BillMax, 
                       COUNT(HD.FTXshDocNo) AS BillQty, 
                       SUM(HD.FCXshGrand) AS BillAmt
                FROM TPSTSalHD HD
                     LEFT JOIN TPSTShiftSLastDoc SHD ON HD.FTBchCode = SHD.FTBchCode AND HD.FTShfCode = SHD.FTShfCode AND HD.FNXshDocType = SHD.FNLstDocType
                WHERE CONVERT(DATE, HD.FDXshDocDate, 103) BETWEEN '" . $dDateFrom . "' AND  '" . $dDateTo . "'   $tTextWhereBranchRole
                $tTextWhereBranch
                $tTextWherePos
                GROUP BY HD.FTBchCode, 
                         HD.FTPosCode, 
                         CONVERT(DATE, HD.FDXshDocDate, 103), 
                         HD.FTShfCode, 
                         HD.FNXshDocType
            ) SALE
            INNER JOIN TCNMBranch_L BCH ON SALE.FTBchCode = BCH.FTBchCode AND FNLngID = 1
        ) MONITOR
    
        $tTextWhereDiff
 ";




        $tSQL .= ") DataMain) AS c  WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";


        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            $aList = $oQuery->result_array();
            $nFoundRow = $this->FSoMSPLGetPageAll($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereDiff, $oetDSHSALSort, $oetDSHSALFild, $tTextWhereBranchRole);
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aDataReturn = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn = array(
                'raItems'       => array(),
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }

        return $aDataReturn;
    }



    // Functionality: Get Numrows Total By Branch
    // Parameters: function parameters
    // Creator:  06/10/2020 Worakorn
    // Return: Data Int
    // Return Type: Int
    public function FSoMSPLGetPageAll($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereDiff, $oetDSHSALSort, $oetDSHSALFild , $ptTextWhereBranchRole)
    {

        // $tSQL   = " SELECT c.* FROM (
        //     SELECT
        //       ROW_NUMBER() OVER(ORDER BY $oetDSHSALFild $oetDSHSALSort ) AS rtRowID, 
        //       DataMain.*
        //     FROM (
        //   SELECT
        //    BCH.FTBchName,
        //    SALE.FTPosCode,
        //    SALE.FNXshDocType,
        //    SALE.BillMin,
        //    SALE.BillMax,
        //    SALE.BillQty,
        //    SALE.BillAmt,
        //    (
        //     CONVERT (bigint, RIGHT(BillMax, 7)) - CONVERT (bigint, RIGHT(BillMin, 7))
        //    ) + 1 AS BillChk ,
        //     ISNULL((SALE.BillQty - ( (
        //     CONVERT (bigint, RIGHT(BillMax, 7)) - CONVERT (bigint, RIGHT(BillMin, 7))
        //    ) + 1) ),0) AS BillDiff
        //   FROM
        //    (
        //     SELECT
        //      SHD.FTBchCode,
        //      SHD.FTPosCode,
        //      FNXshDocType,
        //      MIN (SHD.FTLstDocNoFrm) AS BillMin,
        //      MAX (SHD.FTLstDocNoTo) AS BillMax,
        //      COUNT (FTXshDocNo) AS BillQty,
        //      SUM (FCXshGrand) AS BillAmt

        //     FROM
        //      TPSTSalHD HD
        //     INNER JOIN TPSTShiftSLastDoc SHD ON HD.FTBchCode = SHD.FTBchCode
        //     AND HD.FTShfCode = SHD.FTShfCode
        //     AND HD.FNXshDocType = SHD.FNLstDocType
        //     WHERE
        //      CONVERT (DATE, FDXshDocDate, 103) BETWEEN '" . $pdDateFrom . "'
        //     AND '" . $pdDateTo . "'
        //     $ptTextWhereBranch 
        //     $ptTextWherePos
        //     GROUP BY
        //      SHD.FTBchCode,
        //      SHD.FTPosCode,
        //      FNXshDocType
        //    ) SALE
        //   INNER JOIN TCNMBranch_L BCH ON SALE.FTBchCode = BCH.FTBchCode
        //   AND FNLngID = 1  $tTextWhereDiff";
        //         $tSQL = " SELECT
        // c.*
        // FROM
        // (
        //  SELECT
        //   ROW_NUMBER () OVER (ORDER BY $oetDSHSALFild $oetDSHSALSort ) AS rtRowID,
        //   DataMain.*
        //  FROM
        //   (
        // SELECT *,BillChk-BillQty AS BillDiff 
        // FROM (
        // SELECT BCH.FTBchName,SALE.FTPosCode,SALE.FDXshDocDate,SALE.FTShfCode, SALE.FNXshDocType,SALE.BillMin,SALE.BillMax,SALE.BillQty,SALE.BillAmt
        // , ISNULL((CONVERT(bigint, RIGHT(BillMax,7))-CONVERT(bigint, RIGHT(BillMin,7)))+1,0) AS BillChk 
        // FROM (
        // SELECT convert(date, HD.FDXshDocDate,103)AS FDXshDocDate,SHD.FTShfCode,SHD.FTBchCode,  SHD.FTPosCode,FNXshDocType
        // ,MIN(SHD.FTLstDocNoFrm) AS BillMin
        // ,MAX(SHD.FTLstDocNoTo) AS BillMax
        // ,COUNT(FTXshDocNo)AS BillQty,SUM(FCXshGrand)AS BillAmt 
        // FROM TPSTSalHD HD 
        // INNER JOIN TPSTShiftSLastDoc SHD
        // ON HD.FTBchCode=SHD.FTBchCode 
        // AND HD.FTShfCode =SHD.FTShfCode 
        // AND HD.FNXshDocType =SHD.FNLstDocType
        // WHERE  convert(date, HD.FDXshDocDate,103)
        // BETWEEN  '" . $pdDateFrom . "' AND  '" . $pdDateTo . "' 
        // $ptTextWhereBranch 
        // $ptTextWherePos  
        // GROUP BY SHD.FTBchCode,SHD.FTPosCode,convert(date, HD.FDXshDocDate,103),SHD.FTShfCode,HD.FNXshDocType)SALE 
        // INNER JOIN TCNMBranch_L BCH ON SALE.FTBchCode=BCH.FTBchCode AND FNLngID =1)MONITOR

        // $tTextWhereDiff

        //  ";

        $tSQL = " SELECT c.*
FROM
(
    SELECT ROW_NUMBER() OVER(
           ORDER BY $oetDSHSALFild $oetDSHSALSort) AS rtRowID, 
           DataMain.*
    FROM
    (
        SELECT *, 
               BillChk - BillQty AS BillDiff
        FROM
        (
            SELECT BCH.FTBchName, 
                   SALE.FTPosCode, 
                   SALE.FDXshDocDate, 
                   SALE.FTShfCode, 
                   SALE.FNXshDocType, 
                   SALE.BillMin, 
                   SALE.BillMax, 
                   SALE.BillQty, 
                   SALE.BillAmt, 
                   ISNULL((CONVERT(BIGINT, RIGHT(BillMax, 7)) - CONVERT(BIGINT, RIGHT(BillMin, 7))) + 1, 0) AS BillChk
            FROM
            (
                SELECT CONVERT(DATE, HD.FDXshDocDate, 103) AS FDXshDocDate, 
                       HD.FTShfCode, 
                       HD.FTBchCode, 
                       HD.FTPosCode, 
                       HD.FNXshDocType, 
                       MIN(SHD.FTLstDocNoFrm) AS BillMin, 
                       MAX(SHD.FTLstDocNoTo) AS BillMax, 
                       COUNT(HD.FTXshDocNo) AS BillQty, 
                       SUM(HD.FCXshGrand) AS BillAmt
                FROM TPSTSalHD HD
                     LEFT JOIN TPSTShiftSLastDoc SHD ON HD.FTBchCode = SHD.FTBchCode AND HD.FTShfCode = SHD.FTShfCode AND HD.FNXshDocType = SHD.FNLstDocType
                WHERE CONVERT(DATE, HD.FDXshDocDate, 103) BETWEEN '" . $pdDateFrom . "' AND  '" . $pdDateTo . "'   $ptTextWhereBranchRole  
                $ptTextWhereBranch
                $ptTextWherePos
                GROUP BY HD.FTBchCode, 
                         HD.FTPosCode, 
                         CONVERT(DATE, HD.FDXshDocDate, 103), 
                         HD.FTShfCode, 
                         HD.FNXshDocType
            ) SALE
            INNER JOIN TCNMBranch_L BCH ON SALE.FTBchCode = BCH.FTBchCode AND FNLngID = 1
        ) MONITOR
    
        $tTextWhereDiff
 ";

        $tSQL .= ") DataMain) AS c ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->num_rows();
        } else {
            return false;
        }
    }
}
