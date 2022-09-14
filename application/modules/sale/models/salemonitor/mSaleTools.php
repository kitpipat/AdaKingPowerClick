<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class mSaleTools extends CI_Model {

   

    
    public function FSaMSTLSALTotalSaleByBranch($paData){


        $dDateFrom = $this->input->post('oetSTLSALDateDataTo');
        $dDateTo = $this->input->post('oetSTLSALDateDataTo');
        $oetSTLSALSort = $this->input->post('oetSTLSALSort');
        $oetSTLSALFild = $this->input->post('oetSTLSALFild');

        // Branch Filter
        $tDSHSALFilterBchStaAll  = (!empty($this->input->post('oetSMTSALFilterBchStaAll')) && ($this->input->post('oetSMTSALFilterBchStaAll') == 1)) ? true : false;
        $nDSHSALFilterBchCode    = (!empty($this->input->post('oetSMTSALFilterBchCodeTool'))) ? $this->input->post('oetSMTSALFilterBchCodeTool') : "";
        $tDSHSALFilterBchName   = (!empty($this->input->post('oetSMTSALFilterBchNameTool'))) ? $this->input->post('oetSMTSALFilterBchNameTool') : "";
        // Pos Filter
        $tDSHSALFilterPosStaAll  = (!empty($this->input->post('oetSMTSALFilterPosStaAll')) && ($this->input->post('oetSMTSALFilterPosStaAll') == 1)) ? true : false;
        $nDSHSALFilterPosCode  = (!empty($this->input->post('oetSMTSALFilterPosCodeTool'))) ? $this->input->post('oetSMTSALFilterPosCodeTool') : "";
        $tDSHSALFilterPosName    = (!empty($this->input->post('oetSMTSALFilterPosNameTool'))) ? $this->input->post('oetSMTSALFilterPosNameTool') : "";
        // Diff Filter
        // $tDSHSALFilterDiff = $this->input->post('orbDSHSALDiff');
        $tDSHSALFilterDiff = (!empty($this->input->post('orbDSHSALDiff'))) ? $this->input->post('orbDSHSALDiff') : "";

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($tDSHSALFilterBchStaAll) &&  $tDSHSALFilterBchStaAll == false) {
            if (isset($nDSHSALFilterBchCode) && !empty($nDSHSALFilterBchCode)) {
                $tTextWhereBranch   = 'AND SHD.FTBchCode IN (' . FCNtAddSingleQuote($nDSHSALFilterBchCode) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($tDSHSALFilterPosStaAll) && $tDSHSALFilterPosStaAll == false) {
            if (isset($nDSHSALFilterPosCode) && !empty($nDSHSALFilterPosCode)) {
                $tTextWherePos  = 'AND SHD.FTPosCode IN (' . FCNtAddSingleQuote($nDSHSALFilterPosCode) . ')';
            }
        }

        // Check Data Where Diff
        // $tTextWhereDiff      = '';
        // if ($tDSHSALFilterDiff == '1') {
            $tTextWhereDiff  = 'AND CalDiff.BillDiff <> 0';
        // }


        $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);


        $tUsrBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
        $tUsrLevel = $this->session->userdata("tSesUsrLevel");
        $tTextWhereBranchRole = '';
        if ($tUsrLevel != 'HQ') {
            $tTextWhereBranchRole =  "AND  SHD.FTBchCode IN ($tUsrBchCodeMulti)";
        }


        $tSQL = " SELECT c.*
            FROM
            (
                SELECT ROW_NUMBER() OVER(
                    ORDER BY $oetSTLSALFild $oetSTLSALSort) AS rtRowID, 
                    DataMain.*
                FROM
                (
                SELECT CalDiff.* FROM (
                    SELECT
                            SHD.FTBchCode,
                            BCHL.FTBchName,
                            SHD.FTPosCode,
                            CONVERT (DATE, SHD.FDShdSaleDate, 103) AS FDShdSaleDate,
                            SHD.FTShfCode,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignIn,
                                120
                            ) AS FDShdSignIn,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignOut,
                                120
                            ) AS FDShdSignOut,
                            SHD.FTShdUsrClosed,
                            SALHD.BillQty,
                            CASE WHEN  ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            ISNULL(SHD.FNShdQtyBill, 0)
                            ELSE
                            ISNULL(SHLD.BillChk, 0)
                            END FNShdQtyBill,
                            CASE
                        WHEN ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            (
                                ISNULL(SHD.FNShdQtyBill, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        ELSE
                            (
                                ISNULL(SHLD.BillChk, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        END BillDiff
                        FROM
                            TPSTShiftHD SHD
                        LEFT OUTER JOIN TCNMBranch_L BCHL ON SHD.FTBchCode = BCHL.FTBchCode
                        LEFT OUTER JOIN (
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM
                                TPSTSalHD HD
                            GROUP BY
                                HD.FTBchCode,
                                HD.FTPosCode,
                                HD.FTShfCode
                        UNION ALL
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM
                                TVDTSalHD HD
                            GROUP BY
                                HD.FTBchCode,
                                HD.FTPosCode,
                                HD.FTShfCode
                        ) SALHD ON SHD.FTBchCode = SALHD.FTBchCode
                        AND SHD.FTPosCode = SALHD.FTPosCode
                        AND SHD.FTShfCode = SALHD.FTShfCode
                        LEFT JOIN (
                            SELECT
                                FTBchCode,
                                FTPosCode,
                                FTShfCode,
                                SUM (
                                    ISNULL(
                                        (
                                            CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoTo, 7)
                                            ) - CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoFrm, 7)
                                            )
                                        ) + 1,
                                        0
                                    )
                                ) AS BillChk
                            FROM
                                TPSTShiftSLastDoc SLD
                            GROUP BY
                                FTBchCode,
                                FTPosCode,
                                FTShfCode
                        ) SHLD ON SHD.FTBchCode = SHLD.FTBchCode
                        AND SHD.FTPosCode = SHLD.FTPosCode
                        AND SHD.FTShfCode = SHLD.FTShfCode
				WHERE
					CONVERT (DATE, SHD.FDShdSignIn, 103) BETWEEN '$dDateFrom'
				AND '$dDateTo'
                    $tTextWhereBranchRole  
                    $tTextWhereBranch
                    $tTextWherePos
                    ) CalDiff WHERE 1=1
                    $tTextWhereDiff
 ";



        $tSQL .= ") DataMain) AS c  WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";

                                                // echo $tSQL ;
        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            $aList = $oQuery->result_array();
            $nFoundRow = $this->FSoMSTLGetPageAll($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereDiff, $oetSTLSALSort, $oetSTLSALFild, $tTextWhereBranchRole);
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
    public function FSoMSTLGetPageAll($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereDiff, $oetSTLSALSort, $oetSTLSALFild , $ptTextWhereBranchRole)
    {


                $tSQL = " SELECT c.*
        FROM
        (
            SELECT ROW_NUMBER() OVER(
                ORDER BY $oetSTLSALFild $oetSTLSALSort) AS rtRowID, 
                DataMain.*
            FROM
            (
                SELECT CalDiff.* FROM (
                    SELECT
                            SHD.FTBchCode,
                            BCHL.FTBchName,
                            SHD.FTPosCode,
                            CONVERT (DATE, SHD.FDShdSaleDate, 103) AS FDShdSaleDate,
                            SHD.FTShfCode,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignIn,
                                120
                            ) AS FDShdSignIn,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignOut,
                                120
                            ) AS FDShdSignOut,
                            SHD.FTShdUsrClosed,
                            SALHD.BillQty,
                            CASE WHEN  ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            ISNULL(SHD.FNShdQtyBill, 0)
                            ELSE
                            ISNULL(SHLD.BillChk, 0)
                            END FNShdQtyBill,
                            CASE
                        WHEN ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            (
                                ISNULL(SHD.FNShdQtyBill, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        ELSE
                            (
                                ISNULL(SHLD.BillChk, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        END BillDiff
                        FROM
                            TPSTShiftHD SHD
                        LEFT OUTER JOIN TCNMBranch_L BCHL ON SHD.FTBchCode = BCHL.FTBchCode
                        LEFT OUTER JOIN (
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM
                                TPSTSalHD HD
                            GROUP BY
                                HD.FTBchCode,
                                HD.FTPosCode,
                                HD.FTShfCode
                            UNION ALL
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM
                                TVDTSalHD HD
                            GROUP BY
                                HD.FTBchCode,
                                HD.FTPosCode,
                                HD.FTShfCode
                        ) SALHD ON SHD.FTBchCode = SALHD.FTBchCode
                        AND SHD.FTPosCode = SALHD.FTPosCode
                        AND SHD.FTShfCode = SALHD.FTShfCode
                        LEFT JOIN (
                            SELECT
                                FTBchCode,
                                FTPosCode,
                                FTShfCode,
                                SUM (
                                    ISNULL(
                                        (
                                            CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoTo, 7)
                                            ) - CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoFrm, 7)
                                            )
                                        ) + 1,
                                        0
                                    )
                                ) AS BillChk
                            FROM
                                TPSTShiftSLastDoc SLD
                            GROUP BY
                                FTBchCode,
                                FTPosCode,
                                FTShfCode
                        ) SHLD ON SHD.FTBchCode = SHLD.FTBchCode
                        AND SHD.FTPosCode = SHLD.FTPosCode
                        AND SHD.FTShfCode = SHLD.FTShfCode
				WHERE
					CONVERT (DATE, SHD.FDShdSignIn, 103) BETWEEN '$pdDateFrom'
				AND '$pdDateTo'
                    $ptTextWhereBranchRole  
                    $ptTextWhereBranch
                    $ptTextWherePos
                    ) CalDiff WHERE 1=1
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