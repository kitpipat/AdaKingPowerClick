<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class mSaleMonitor extends CI_Model {

    //Functionality : list Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMSMTBCHList($paData) {

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY rtBchCode ASC) AS rtRowID,* FROM (
                                SELECT DISTINCT
                                    BCH.FTBchCode AS rtBchCode,
                                    FTBchName AS rtBchName,
                                    FTBchType AS rtBchType,
                                    BCH.FTBchPriority AS rtBchPriority
    					FROM TCNMBranch   BCH  WITH(NOLOCK)
						LEFT JOIN TCNMBranch_L  BCHL  WITH(NOLOCK) ON BCH.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLngID
						WHERE 1 = 1
        ";
        $tBchCode       = $paData['FTBchCode'];
        $tFilterBchCode    = $paData['tFilterBchCode'];
        
		// User BCH Level
		if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
			$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
			$tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }

        if(!empty($tFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
            $tSQL .= " AND BCH.FTBchCode IN ('$tFilterBchCodeWhere') ";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) {

            $aList = $oQuery->result();
            $aFoundRow = $this->JSnMSMTBCHGetPageAll($tFilterBchCode, $tBchCode, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

            $aResult = array(
                'raItems' => $aList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;
    }

    //Functionality : All Page Of Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    function JSnMSMTBCHGetPageAll($ptFilterBchCode, $ptBchCode, $ptLngID) {

        $tSQL = "SELECT COUNT (BCH.FTBchCode) AS counts
                        FROM TCNMBranch BCH
                        LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $ptLngID
                        WHERE 1 = 1";

		// User BCH Level
		if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
			$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
			$tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }

        if(!empty($ptFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$ptFilterBchCode);
            $tSQL .= " AND BCH.FTBchCode IN ('$tFilterBchCodeWhere') ";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }



    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSaMSMTCallSalHD($paDatWhere){


         $tDateData = $paDatWhere['tDateDataTo'];
         $tFilterBchCode = $paDatWhere['tFilterBchCode'];
         $tFilterShpCode = $paDatWhere['tFilterShpCode'];
         $tFilterPosCode = $paDatWhere['tFilterPosCode'];
         $tSqlWhere = "  SAL.FDXshDocDate BETWEEN '$tDateData 00:00:00' AND '$tDateData 23:59:59' ";

        	// User BCH Level
            if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
                $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
                $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
            }

            if(!empty($tFilterBchCode)){
                $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
                $tSqlWhere .= " AND SAL.FTBchCode IN ('$tFilterBchCodeWhere') ";
            }

            if(!empty($tFilterShpCode)){
                $tFilterShpCodeWhere = str_replace(",","','",$tFilterShpCode);
                $tSqlWhere .= " AND SAL.FTShpCode IN ('$tFilterShpCodeWhere') ";
            }

            if(!empty($tFilterPosCode)){
                $tFilterPosCodeWhere = str_replace(",","','",$tFilterPosCode);
                $tSqlWhere .= " AND SAL.FTPosCode IN ('$tFilterPosCodeWhere') ";
            }

            $nLangEdit      = $this->session->userdata("tLangEdit");

            $tSql = "SELECT
                            BCHL.FTBchName,
                            SAL.FTWahCode,
                            SAL.FTPosCode,
                            SAL.FTShfCode,
                            SAL.FTXshDocNo,
                            SAL.FTBchCode,
                            SAL.FDXshDocDate,
                            SAL.FTShpCode,
                            SAL.FCXshGrand,
                            SHPL.FTShpName,
                            POSL.FTPosName,
                            SAL.FNXshDocType
                        FROM
                        TPSTSalHD AS SAL
                            LEFT JOIN TCNMBranch_L AS BCHL ON SAL.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLangEdit
                            LEFT JOIN TCNMShop_L   AS SHPL ON SAL.FTShpCode = SHPL.FTShpCode AND SHPL.FTBchCode = SAL.FTBchCode AND SHPL.FNLngID = $nLangEdit
                            LEFT JOIN TCNMPos_L   AS POSL ON SAL.FTPosCode = POSL.FTPosCode AND POSL.FTBchCode = SAL.FTBchCode AND POSL.FNLngID = $nLangEdit
                        WHERE
                        $tSqlWhere
                        ORDER BY
                            SAL.FTBchCode ASC,
                            SAL.FTShpCode ASC,
                            SAL.FTPosCode ASC
            ";

            // echo $tSql ;
            $oQuery = $this->db->query($tSql);
            return $oQuery->result_array();

    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSdMSMTGetLastGrandSiftDate($ptBchCode,$ptShpCode,$ptPosCode,$paDataWhere){

        $tDateData = $paDataWhere['tDateDataTo'];

            $tSql ="SELECT TOP 1
                    SAL.FDLastUpdOn AS lastData,
                    SAL.FTXshDocNo AS LastDoc
                    FROM
                        TPSTSalHD SAL
                    WHERE SAL.FTBchCode='$ptBchCode'
                    AND SAL.FTShpCode='$ptShpCode'
                    AND SAL.FTPosCode='$ptPosCode'
                    AND SAL.FDXshDocDate BETWEEN '$tDateData 00:00:00' AND '$tDateData 23:59:59'
                    ORDER BY SAL.FDLastUpdOn DESC
                    ";

            $oQuery = $this->db->query($tSql);
            return $oQuery->row_array();


    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSaMSMTCallSiftHD($paDataWhere){

        $tDateData = $paDataWhere['tDateDataTo'];
        $tFilterBchCode = $paDataWhere['tFilterBchCode'];
        $tFilterPosCode = $paDataWhere['tFilterPosCode'];
        $tSqlWhere = " SHD.FDShdSaleDate BETWEEN '$tDateData 00:00:00' AND '$tDateData 23:59:59' ";

        // User BCH Level
        if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }


        if(!empty($tFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
            $tSqlWhere .= " AND SHD.FTBchCode IN ('$tFilterBchCodeWhere') ";
        }

        if(!empty($tFilterPosCode)){
            $tFilterPosCodeWhere = str_replace(",","','",$tFilterPosCode);
            $tSqlWhere .= " AND SHD.FTPosCode IN ('$tFilterPosCodeWhere') ";
        }


            $tSql ="SELECT
                        SHD.FTBchCode,
                        SHD.FTPosCode,
                        SHD.FTShfCode,
                        SHD.FDShdSignIn,
                        SHD.FDShdSignOut,
                        SLD.FTLstDocNoFrm,
                        SLD.FTLstDocNoTo,
                        SLD.FNLstDocType
                        FROM
                        TPSTShiftHD AS SHD
                        LEFT JOIN TPSTShiftSLastDoc SLD ON SHD.FTBchCode = SLD.FTBchCode AND SHD.FTPosCode = SLD.FTPosCode AND SHD.FTShfCode = SLD.FTShfCode 
                        WHERE
                        $tSqlWhere
            ";

            // echo $tSql;
            $oQuery = $this->db->query($tSql);
            return $oQuery->result_array();
    }


    public function FSaMSMTCallSumRcvShift($paData,$pType){
       $tBchCode    = $paData['tBchCode'];
       $tPosCode    = $paData['tPosCode'];
       $tShfCode  = $paData['tShfCode'];
       $tSqlWhere ='';
    if(!empty($pType)){
        $tSqlWhere .= " AND SRV.FTRcvDocType ='$pType' ";
    }
        $tSql = "SELECT
                        SUM (
                            CASE
                            WHEN SRV.FTRcvDocType = 1 THEN
                                ISNULL(SRV.FCRcvPayAmt, 0)
                            ELSE
                                ISNULL(SRV.FCRcvPayAmt, 0) *- 1
                            END
                        ) AS FCRcvPayAmt
                    FROM
                        TPSTShiftSSumRcv SRV
                    WHERE
                        SRV.FTBchCode = '$tBchCode'
                    AND SRV.FTPosCode = '$tPosCode'
                    AND SRV.FTShfCode = '$tShfCode'
                    $tSqlWhere
                    GROUP BY
                        SRV.FTShfCode
                ";
        $oQuery = $this->db->query($tSql);
        return $oQuery->row_array()['FCRcvPayAmt'];
    }


    public function FSaMSMTCallObjectData($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNUrlType ASC) AS rtRowID,* FROM (
                                SELECT
                                    OBJ.FNUrlID,
                                    OBJ.FTUrlRefID AS rtBchCode,
                                    BCHL.FTBchName AS rtBchName,
                                    OBJ.FNUrlType,
                                    OBJ.FTUrlAddress,
                                    OBJ.FTUrlPort
                                FROM
                                    TCNTUrlObject OBJ
                                LEFT JOIN TCNMBranch_L BCHL on OBJ.FTUrlRefID = BCHL.FTBchCode AND BCHL.FNLngID=$nLngID
					     	WHERE OBJ.FNUrlType NOT IN (1,2)
        ";

        $tBchCode       = $paData['FTBchCode'];
        $tFilterBchCode    = $paData['tFilterBchCode'];
        

        // User BCH Level
        if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }


        if(!empty($tFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
            $tSQL .= " AND OBJ.FTUrlRefID IN ('$tFilterBchCodeWhere') ";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            $aList = $oQuery->result();
            $aFoundRow = $this->JSnMSMTUrlObjectGetPageAll($tFilterBchCode, $tBchCode, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

            $aResult = array(
                'raItems' => $aList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;



    }


        //Functionality : All Page Of Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    function JSnMSMTUrlObjectGetPageAll($ptFilterBchCode, $ptBchCode, $ptLngID) {

        $tSQL = "SELECT COUNT (OBJ.FNUrlID) AS counts
		    					FROM TCNTUrlObject OBJ
								WHERE OBJ.FNUrlType NOT IN (1,2) ";

        // if ($this->session->userdata('tSesUsrBchCode')!= '') {
        //     $tBchCode = $this->session->userdata('tSesUsrBchCode');
        //     $tSQL .= " AND OBJ.FTUrlRefID = '$tBchCode' ";
        // }

        // User BCH Level
        if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }

        if(!empty($ptFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$ptFilterBchCode);
            $tSQL .= " AND OBJ.FTUrlRefID IN ('$tFilterBchCodeWhere') ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }


    // Last Update : Napat(Jame) 24/03/2022 เพิ่มการดึงข้อมูล แคชเชียร์
    public function FSaMSMTSALTotalSaleByBranch($paData){
        
        $dDateFrom = $this->input->post('oetSMTSALDateDataForm');
        $dDateTo = $this->input->post('oetSMTSALDateDataTo');
        $oetDSHSALSort = $this->input->post('oetDSHSALSort');
        $oetDSHSALFild = $this->input->post('oetDSHSALFild');

        // Branch Filter
        $tDSHSALFilterBchStaAll  = (!empty($this->input->post('oetSMTSALFilterBchStaAll')) && ($this->input->post('oetSMTSALFilterBchStaAll') == 1)) ? true : false;
        $nDSHSALFilterBchCode    = (!empty($this->input->post('oetSMTSALFilterBchCode'))) ? $this->input->post('oetSMTSALFilterBchCode') : "";
        $tDSHSALFilterBchName   = (!empty($this->input->post('oetSMTSALFilterBchName'))) ? $this->input->post('oetSMTSALFilterBchName') : "";
        // Pos Filter
        $tDSHSALFilterPosStaAll  = (!empty($this->input->post('oetSMTSALFilterPosStaAll')) && ($this->input->post('oetSMTSALFilterPosStaAll') == 1)) ? true : false;
        $nDSHSALFilterPosCode  = (!empty($this->input->post('oetSMTSALFilterPosCode'))) ? $this->input->post('oetSMTSALFilterPosCode') : "";
        $tDSHSALFilterPosName    = (!empty($this->input->post('oetSMTSALFilterPosName'))) ? $this->input->post('oetSMTSALFilterPosName') : "";
        // Cashier Filter
        $bFilterUsrStaAll  = (!empty($this->input->post('oetSMTSALFilterUsrStaAll')) && ($this->input->post('oetSMTSALFilterUsrStaAll') == 1))? true : false;
        $tFilterUsrCode    = (!empty($this->input->post('oetSMTSALFilterUsrCode')))? $this->input->post('oetSMTSALFilterUsrCode') : "";
        $tFilterUsrName    = (!empty($this->input->post('oetSMTSALFilterUsrName')))? $this->input->post('oetSMTSALFilterUsrName') : "";
        // Diff Filter
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

        // Check Data Where In Branch
        $tTextWhereCashier   = '';
        if (isset($bFilterUsrStaAll) &&  $bFilterUsrStaAll == false) {
            if (isset($tFilterUsrCode) && !empty($tFilterUsrCode)) {
                $tTextWhereCashier   = 'AND SHD.FTUsrCode IN (' . FCNtAddSingleQuote($tFilterUsrCode) . ')';
            }
        }

        // Check Data Where Diff
        $tTextWhereDiff      = '';
        if ($tDSHSALFilterDiff == '1') {
            $tTextWhereDiff  = 'AND  CalDiff.BillDiff <> 0';
        }

        $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID         = $paData['FNLngID'];

        $tUsrBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
        $tUsrLevel = $this->session->userdata("tSesUsrLevel");
        $tTextWhereBranchRole = '';
        if ($tUsrLevel != 'HQ') {
            $tTextWhereBranchRole =  "AND  SHD.FTBchCode IN ($tUsrBchCodeMulti)";
        }


        $tSQL1 = "SELECT c.* FROM ( SELECT ROW_NUMBER() OVER(ORDER BY $oetDSHSALFild $oetDSHSALSort) AS rtRowID, DataMain.* FROM ( ";
        $tSQL2 = "  SELECT CalDiff.* FROM (
                        SELECT
                            SHD.FTBchCode,
                            BCHL.FTBchName,
                            SHD.FTPosCode,
                            POSL.FTPosName,
                            CONVERT (DATE, SHD.FDShdSaleDate, 103) AS FDShdSaleDate,
                            SHD.FTShfCode,
                            CONVERT (VARCHAR,SHD.FDShdSignIn,120) AS FDShdSignIn,
                            CONVERT (VARCHAR,SHD.FDShdSignOut,120) AS FDShdSignOut,
                            SHD.FTShdUsrClosed,
                            SALHD.BillQty,
                            CASE 
                                WHEN ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN ISNULL(SHD.FNShdQtyBill, 0)
                            ELSE
                                ISNULL(SHLD.BillChk, 0)
                            END FNShdQtyBill,
                            CASE
                                WHEN ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN (ISNULL(SHD.FNShdQtyBill, 0) - ISNULL(SALHD.BillQty, 0))
                            ELSE 
                                (ISNULL(SHLD.BillChk, 0) - ISNULL(SALHD.BillQty, 0))
                            END BillDiff,
                            SHD.FTUsrCode,
                            USRL.FTUsrName,
                            SHD.FTShdStaPrc
                        FROM TPSTShiftHD SHD WITH(NOLOCK)
                        LEFT OUTER JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON SHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMUser_L USRL WITH(NOLOCK) ON SHD.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                        LEFT JOIN TCNMPos_L POSL WITH(NOLOCK) ON SHD.FTBchCode = POSL.FTBchCode AND SHD.FTPosCode = POSL.FTPosCode AND USRL.FNLngID = $nLngID
                        LEFT OUTER JOIN (
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM TPSTSalHD HD WITH(NOLOCK)
                            GROUP BY HD.FTBchCode,HD.FTPosCode,HD.FTShfCode
                            UNION ALL
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM TVDTSalHD HD WITH(NOLOCK)
                            GROUP BY HD.FTBchCode,HD.FTPosCode,HD.FTShfCode
                        ) SALHD ON SHD.FTBchCode = SALHD.FTBchCode AND SHD.FTPosCode = SALHD.FTPosCode AND SHD.FTShfCode = SALHD.FTShfCode
                        LEFT JOIN (
                            SELECT
                                FTBchCode,
                                FTPosCode,
                                FTShfCode,
                                SUM (ISNULL((CONVERT (BIGINT,RIGHT (SLD.FTLstDocNoTo, 7)) - CONVERT (BIGINT,RIGHT (SLD.FTLstDocNoFrm, 7))) + 1,0)) AS BillChk
                            FROM TPSTShiftSLastDoc SLD WITH(NOLOCK)
                            GROUP BY FTBchCode,FTPosCode,FTShfCode
                        ) SHLD ON SHD.FTBchCode = SHLD.FTBchCode AND SHD.FTPosCode = SHLD.FTPosCode AND SHD.FTShfCode = SHLD.FTShfCode
                        WHERE CONVERT (DATE, SHD.FDShdSignIn, 103) BETWEEN '$dDateFrom' AND '$dDateTo'
                        $tTextWhereBranchRole  
                        $tTextWhereBranch
                        $tTextWherePos
                        $tTextWhereCashier
                    ) CalDiff WHERE 1=1
                    $tTextWhereDiff
                ";
        $tSQL3 = ") DataMain) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
        $tSQLMain = $tSQL1.$tSQL2.$tSQL3;
        $oQuery = $this->db->query($tSQLMain);
        // echo $this->db->last_query();exit;
        if( $oQuery->num_rows() > 0 ){
            $aList = $oQuery->result_array();
            // $nFoundRow = $this->FSoMSMTGetPageAll($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereDiff, $oetDSHSALSort, $oetDSHSALFild, $tTextWhereBranchRole);
            $oQueryPage = $this->db->query($tSQL2);
            $nFoundRow = $oQueryPage->num_rows();
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aDataReturn = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
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
//     public function FSoMSMTGetPageAll($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereDiff, $oetDSHSALSort, $oetDSHSALFild , $ptTextWhereBranchRole)
//     {


//                 $tSQL = " SELECT c.*
//         FROM
//         (
//             SELECT ROW_NUMBER() OVER(
//                 ORDER BY $oetDSHSALFild $oetDSHSALSort) AS rtRowID, 
//                 DataMain.*
//             FROM
//             (
//                 SELECT CalDiff.* FROM (
//                     SELECT
//                             SHD.FTBchCode,
//                             BCHL.FTBchName,
//                             SHD.FTPosCode,
//                             CONVERT (DATE, SHD.FDShdSaleDate, 103) AS FDShdSaleDate,
//                             SHD.FTShfCode,
//                             CONVERT (
//                                 VARCHAR,
//                                 SHD.FDShdSignIn,
//                                 120
//                             ) AS FDShdSignIn,
//                             CONVERT (
//                                 VARCHAR,
//                                 SHD.FDShdSignOut,
//                                 120
//                             ) AS FDShdSignOut,
//                             SHD.FTShdUsrClosed,
//                             SALHD.BillQty,
//                             CASE WHEN  ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
//                             ISNULL(SHD.FNShdQtyBill, 0)
//                             ELSE
//                             ISNULL(SHLD.BillChk, 0)
//                             END FNShdQtyBill,
//                             CASE
//                         WHEN ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
//                             (
//                                 ISNULL(SHD.FNShdQtyBill, 0) - ISNULL(SALHD.BillQty, 0)
//                             )
//                         ELSE
//                             (
//                                 ISNULL(SHLD.BillChk, 0) - ISNULL(SALHD.BillQty, 0)
//                             )
//                         END BillDiff
//                         FROM
//                             TPSTShiftHD SHD
//                         LEFT OUTER JOIN TCNMBranch_L BCHL ON SHD.FTBchCode = BCHL.FTBchCode
//                         LEFT OUTER JOIN (
//                             SELECT
//                                 HD.FTShfCode,
//                                 HD.FTBchCode,
//                                 HD.FTPosCode,
//                                 COUNT (HD.FTXshDocNo) AS BillQty
//                             FROM
//                                 TPSTSalHD HD
//                             GROUP BY
//                                 HD.FTBchCode,
//                                 HD.FTPosCode,
//                                 HD.FTShfCode
//                         UNION ALL
//                             SELECT
//                                 HD.FTShfCode,
//                                 HD.FTBchCode,
//                                 HD.FTPosCode,
//                                 COUNT (HD.FTXshDocNo) AS BillQty
//                             FROM
//                                 TVDTSalHD HD
//                             GROUP BY
//                                 HD.FTBchCode,
//                                 HD.FTPosCode,
//                                 HD.FTShfCode
//                         ) SALHD ON SHD.FTBchCode = SALHD.FTBchCode
//                         AND SHD.FTPosCode = SALHD.FTPosCode
//                         AND SHD.FTShfCode = SALHD.FTShfCode
//                         LEFT JOIN (
//                             SELECT
//                                 FTBchCode,
//                                 FTPosCode,
//                                 FTShfCode,
//                                 SUM (
//                                     ISNULL(
//                                         (
//                                             CONVERT (
//                                                 BIGINT,
//                                                 RIGHT (SLD.FTLstDocNoTo, 7)
//                                             ) - CONVERT (
//                                                 BIGINT,
//                                                 RIGHT (SLD.FTLstDocNoFrm, 7)
//                                             )
//                                         ) + 1,
//                                         0
//                                     )
//                                 ) AS BillChk
//                             FROM
//                                 TPSTShiftSLastDoc SLD
//                             GROUP BY
//                                 FTBchCode,
//                                 FTPosCode,
//                                 FTShfCode
//                         ) SHLD ON SHD.FTBchCode = SHLD.FTBchCode
//                         AND SHD.FTPosCode = SHLD.FTPosCode
//                         AND SHD.FTShfCode = SHLD.FTShfCode
// 				WHERE
// 					CONVERT (DATE, SHD.FDShdSignIn, 103) BETWEEN '$pdDateFrom'
// 				AND '$pdDateTo'
//                     $ptTextWhereBranchRole  
//                     $ptTextWhereBranch
//                     $ptTextWherePos
//                     ) CalDiff WHERE 1=1
//                     $tTextWhereDiff
//  ";

//         $tSQL .= ") DataMain) AS c ";

//         $oQuery = $this->db->query($tSQL);
//         if ($oQuery->num_rows() > 0) {
//             return $oQuery->num_rows();
//         } else {
//             return false;
//         }
//     }

    // Create By : Napat(Jame) 25/03/2022
    public function FSaMSMTEventInsertRcvApv($paParamsData){
        
        $tBchCode = $paParamsData['FTBchCode'];
        $tShfCode = $paParamsData['FTShfCode'];
        $nLngID   = $paParamsData['FNLngID'];
        $dDate    = date('Y-m-d h:i:s');
        $tUser    = $this->session->userdata('tSesUsername');

        // ตรวจสอบว่ามีข้อมูลอยู่แล้ว หรือป่าว ?
        $tSQL = " SELECT FTShfCode FROM TPSTShiftSKeyRcvApv WITH(NOLOCK) WHERE FTShfCode = '$tShfCode' AND FTBchCode = '$tBchCode' ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aDataReturn = array(
                'tCode' => '1',
                'tDesc' => 'มีรอบการขายนี้อยู่แล้วในตาราง TPSTShiftSKeyRcvApv ข้ามขั้นตอนการ insert'
            );
        }else{
            
            $tSQL  = "  INSERT INTO TPSTShiftSKeyRcvApv (FTBchCode,FTPosCode,FTShfCode,FNSdtSeqNo,FTRcvCode,FTRcvName,FTRcvRefType,FTRcvRefNo1,FTRcvRefNo2,FNRcvUseAmt,FCRcvPayAmt,FCRcvUsrKeyAmt,FCRcvUsrKeyDiff,FCRcvSupKeyAmt,FCRcvSupKeyDiff,FTRcvRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy) ";
            $tSQL .= "  SELECT
                            A.FTBchCode,
                            A.FTPosCode,
                            A.FTShfCode,
                            ROW_NUMBER() OVER(PARTITION BY FTRcvCode ORDER BY FTRcvCode ASC) AS FNRcvSeqNo,
                            A.FTRcvCode,
                            A.FTRcvName,
                            A.FTRefType,
                            A.FTRefNo1,
                            A.FTRefNo2,
                            A.FNRcvUseAmt,
                            A.FCRcvPayAmt,
                            A.FCRcvUsrKeyAmt,
                            A.FCRcvUsrKeyDiff,
                            A.FCRcvSupKeyAmt,
                            A.FCRcvSupKeyDiff,
                            NULL AS FTRcvRmk,
                            '$dDate' AS FDLastUpdOn,
                            '$tUser' AS FTLastUpdBy,
                            '$dDate' AS FDCreateOn,
                            '$tUser' AS FTCreateBy
                        FROM (
                            SELECT
                                SHFHD.FTBchCode,
                                SHFHD.FTPosCode,
                                SHFHD.FTShfCode,
                                RCV.FTRcvCode,
                                RCVL.FTRcvName,
                                NULL AS FTRefType,
                                NULL AS FTRefNo1,
                                NULL AS FTRefNo2,
                                ISNULL(SALRC.FNRcvUseAmt,0) AS FNRcvUseAmt,
                                ISNULL(RCV.FCRcvPayAmt,0) AS FCRcvPayAmt,
                                ISNULL(RCV.FCRcvUsrKeyAmt,0) AS FCRcvUsrKeyAmt,
                                (ISNULL(RCV.FCRcvUsrKeyAmt,0) - ISNULL(RCV.FCRcvPayAmt,0)) AS FCRcvUsrKeyDiff,
                                0 AS FCRcvSupKeyAmt,
                                (0 - ISNULL(RCV.FCRcvPayAmt,0)) AS FCRcvSupKeyDiff
                            FROM TPSTShiftHD SHFHD WITH(NOLOCK)
                            INNER JOIN (
                                SELECT 
                                    A.FTBchCode,A.FTPosCode,A.FTShfCode,A.FTRcvCode,
                                    SUM(FCRcvUsrKeyAmt) AS FCRcvUsrKeyAmt,SUM(FCRcvPayAmt) AS FCRcvPayAmt
                                FROM (
                                    SELECT FTBchCode,FTPosCode,FTShfCode,FTRcvCode,FCRcvPayAmt AS FCRcvUsrKeyAmt, 0 AS FCRcvPayAmt
                                    FROM TPSTShiftSKeyRcv WITH(NOLOCK)
                                    WHERE FCRcvPayAmt > 0
                                    UNION
                                    SELECT FTBchCode,FTPosCode,FTShfCode,FTRcvCode,0 AS FCRcvUsrKeyAmt,FCRcvPayAmt AS FCRcvPayAmt
                                    FROM TPSTShiftSSumRcv WITH(NOLOCK)
                                    WHERE FTRcvDocType = '1'
                                ) A
                                GROUP BY A.FTBchCode,A.FTPosCode,A.FTShfCode,FTRcvCode
                            ) RCV ON RCV.FTShfCode = SHFHD.FTShfCode AND RCV.FTBchCode = SHFHD.FTBchCode
                            INNER JOIN TFNMRcv_L RCVL  WITH(NOLOCK) ON RCV.FTRcvCode = RCVL.FTRcvCode AND RCVL.FNLngID = $nLngID
                            LEFT JOIN (
                                SELECT HD.FTBchCode,HD.FTShfCode,RC.FTRcvCode,COUNT(RC.FTRcvCode) AS FNRcvUseAmt 
                                FROM TPSTSalHD HD WITH(NOLOCK)
                                INNER JOIN TPSTSalRC RC WITH(NOLOCK) ON HD.FTXshDocNo = RC.FTXshDocNo AND HD.FTBchCode = RC.FTBchCode
                                GROUP BY HD.FTBchCode,HD.FTShfCode,RC.FTRcvCode
                            ) SALRC ON SHFHD.FTShfCode = SALRC.FTShfCode AND SHFHD.FTBchCode = SALRC.FTBchCode AND RCV.FTRcvCode = SALRC.FTRcvCode
                            WHERE SHFHD.FTShfCode = '$tShfCode' AND SHFHD.FTBchCode = '$tBchCode'

                            UNION
                        
                            SELECT
                                SHFHD.FTBchCode,
                                SHFHD.FTPosCode,
                                SHFHD.FTShfCode,
                                RCV.FTRcvCode,
                                RCVL.FTRcvName,
                                '1' AS FTRefType,
                                BNK.FTRcvRefNo1 AS FTRefNo1,
                                BNK.FTRcvRefNo2 AS FTRefNo2,
                                ISNULL(BNK.FNRcvUseAmt,0) AS FNRcvUseAmt,
                                ISNULL(BNK.FCRcvPayAmt,0) AS FCRcvPayAmt,
                                0 AS FCRcvUsrKeyAmt,
                                (0 - ISNULL(BNK.FCRcvPayAmt,0)) AS FCRcvUsrKeyDiff,
                                0 AS FCRcvSupKeyAmt,
                                (0 - ISNULL(BNK.FCRcvPayAmt,0)) AS FCRcvSupKeyDiff
                            FROM TPSTShiftHD SHFHD WITH(NOLOCK)
                            INNER JOIN (
                                SELECT 
                                    A.FTBchCode,A.FTPosCode,A.FTShfCode,A.FTRcvCode,
                                    SUM(FCRcvUsrKeyAmt) AS FCRcvUsrKeyAmt,SUM(FCRcvPayAmt) AS FCRcvPayAmt
                                FROM (
                                    SELECT FTBchCode,FTPosCode,FTShfCode,FTRcvCode,FCRcvPayAmt AS FCRcvUsrKeyAmt, 0 AS FCRcvPayAmt
                                    FROM TPSTShiftSKeyRcv WITH(NOLOCK)
                                    WHERE FCRcvPayAmt > 0
                                    UNION
                                    SELECT FTBchCode,FTPosCode,FTShfCode,FTRcvCode,0 AS FCRcvUsrKeyAmt,FCRcvPayAmt AS FCRcvPayAmt
                                    FROM TPSTShiftSSumRcv WITH(NOLOCK)
                                    WHERE FTRcvDocType = '1'
                                ) A
                                GROUP BY A.FTBchCode,A.FTPosCode,A.FTShfCode,FTRcvCode
                            ) RCV ON RCV.FTShfCode = SHFHD.FTShfCode AND RCV.FTBchCode = SHFHD.FTBchCode
                            INNER JOIN TFNMRcv_L RCVL  WITH(NOLOCK) ON RCV.FTRcvCode = RCVL.FTRcvCode AND RCVL.FNLngID = $nLngID
                            INNER JOIN (
                                SELECT
                                    HD.FTBchCode,HD.FTShfCode,RC.FTRcvCode,CRD.FTCrdCode AS FTRcvRefNo1,CRDL.FTCrdName AS FTRcvRefNo2,SUM(RC1.FCXrcNet) AS FCRcvPayAmt,COUNT(RC1.FTRcvCode) AS FNRcvUseAmt
                                FROM TFNMCreditCard CRD WITH(NOLOCK)
                                LEFT JOIN TFNMCreditCard_L CRDL WITH(NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                                INNER JOIN TPSTSalHD HD WITH(NOLOCK) ON HD.FTShfCode = '$tShfCode' AND HD.FTBchCode = '$tBchCode'
                                INNER JOIN TPSTSalRC RC WITH(NOLOCK) ON HD.FTXshDocNo = RC.FTXshDocNo AND HD.FTBchCode = RC.FTBchCode
                                LEFT JOIN TPSTSalRC RC1 WITH(NOLOCK) ON HD.FTXshDocNo = RC1.FTXshDocNo AND HD.FTBchCode = RC1.FTBchCode AND RC.FTRcvCode = RC1.FTRcvCode AND CRD.FTBnkCode = RC1.FTBnkCode
                                WHERE ISNULL(RC.FTBnkCode,'') <> ''
                                GROUP BY HD.FTBchCode,HD.FTShfCode,RC.FTRcvCode,CRD.FTCrdCode,CRDL.FTCrdName
                            ) BNK ON SHFHD.FTShfCode = BNK.FTShfCode AND SHFHD.FTBchCode = BNK.FTBchCode AND RCV.FTRcvCode = BNK.FTRcvCode
                            WHERE SHFHD.FTShfCode = '$tShfCode' AND SHFHD.FTBchCode = '$tBchCode'
                        
                            UNION
                        
                            SELECT
                                SHFHD.FTBchCode,
                                SHFHD.FTPosCode,
                                SHFHD.FTShfCode,
                                SALRC.FTRcvCode,
                                SALRC.FTRcvName,
                                '2' AS FTRefType,
                                SALRC.FTXrcRefNo1 AS FTRefNo1,
                                SALRC.FTXrcRefDesc AS FTRefNo2,
                                COUNT(SALRC.FCXrcNet) AS FNRcvUseAmt,
                                SUM(SALRC.FCXrcNet) AS FCRcvPayAmt,
                                0 AS FCRcvUsrKeyAmt,
                                (0 - SUM(SALRC.FCXrcNet)) AS FCRcvUsrKeyDiff,
                                0 AS FCRcvSupKeyAmt,
                                (0 - SUM(SALRC.FCXrcNet)) AS FCRcvSupKeyDiff
                            FROM TPSTShiftHD SHFHD WITH(NOLOCK)
                            INNER JOIN TPSTSalHD SALHD WITH(NOLOCK) ON SHFHD.FTShfCode = SALHD.FTShfCode
                            INNER JOIN TPSTSalRC SALRC WITH(NOLOCK) ON SALHD.FTXshDocNo = SALRC.FTXshDocNo AND SALHD.FTBchCode = SALRC.FTBchCode
                            INNER JOIN TFNMRcv   RCV   WITH(NOLOCK) ON SALRC.FTRcvCode = RCV.FTRcvCode
                            WHERE SHFHD.FTShfCode = '$tShfCode' AND SHFHD.FTBchCode = '$tBchCode'
                              AND RCV.FTFmtCode = '004'
                            GROUP BY SHFHD.FTBchCode,SHFHD.FTPosCode,SHFHD.FTShfCode,SALRC.FTRcvCode,SALRC.FTRcvName,SALRC.FTXrcRefNo1,SALRC.FTXrcRefDesc
                        ) A ";
            $oQuery = $this->db->query($tSQL);
            if( $this->db->affected_rows() > 0 ){
                $aDataReturn = array(
                    'tCode' => '1',
                    'tDesc' => 'เพิ่มข้อมูลลงตาราง TPSTShiftSKeyRcvApv สำเร็จ'
                );
            }else{
                $aDataReturn = array(
                    'tCode' => '99',
                    'tDesc' => 'ไม่พบข้อมูลที่จะ Insert'
                );
            }
        }
        return $aDataReturn;
        
    }

    // Create By : Napat(Jame) 25/03/2022
    public function FSaMSMTEventGetDataRcvApv($paParamsData){
        $tBchCode = $paParamsData['FTBchCode'];
        $tShfCode = $paParamsData['FTShfCode'];

        $tSQL = "   SELECT 
                        RCVAPV.*,
                        RCVSUM.FCSumRcvPayAmt,
                        RCVSUM.FCSumRcvUsrKeyAmt,
                        RCVSUM.FCSumRcvUsrKeyDiff,
                        RCVSUM.FCSumRcvSupKeyAmt,
                        RCVSUM.FCSumRcvSupKeyDiff,
                        ISNULL(HD.FTShdStaPrc,'2') AS FTShdStaPrc,
                        SUM(1) OVER (PARTITION BY FTRcvCode ORDER BY FTRcvCode ASC) AS FNMaxSeqNo,
                        CASE 
                            WHEN ISNULL(RCVAPV.FCRcvPayAmt,0) = 0 AND ISNULL(RCVAPV.FCRcvUsrKeyAmt,0) = 0 AND ISNULL(RCVAPV.FCRcvUsrKeyDiff,0) = 0
                             AND ISNULL(RCVAPV.FCRcvSupKeyAmt,0) = 0 AND ISNULL(RCVAPV.FCRcvSupKeyDiff,0) = 0
                            THEN '1'
                            ELSE '2'
                        END AS FTStaHideOnApv
                    FROM TPSTShiftSKeyRcvApv RCVAPV WITH(NOLOCK)
                    INNER JOIN TPSTShiftHD HD WITH(NOLOCK) ON HD.FTBchCode = RCVAPV.FTBchCode AND HD.FTShfCode = RCVAPV.FTShfCode
                    INNER JOIN (
                        SELECT 
                            FTBchCode,
                            FTShfCode,
                            SUM(FCRcvPayAmt) AS FCSumRcvPayAmt,
                            SUM(FCRcvUsrKeyAmt) AS FCSumRcvUsrKeyAmt,
                            SUM(FCRcvUsrKeyDiff) AS FCSumRcvUsrKeyDiff,
                            SUM(FCRcvSupKeyAmt) AS FCSumRcvSupKeyAmt,
                            SUM(FCRcvSupKeyDiff) AS FCSumRcvSupKeyDiff
                        FROM TPSTShiftSKeyRcvApv WITH(NOLOCK) 
                        WHERE FNSdtSeqNo = 1
                        GROUP BY FTBchCode,FTShfCode
                    ) RCVSUM ON RCVAPV.FTShfCode = RCVSUM.FTShfCode AND RCVAPV.FTBchCode = RCVSUM.FTBchCode
                    WHERE RCVAPV.FTShfCode = '$tShfCode'
                      AND RCVAPV.FTBchCode = '$tBchCode'
                    ORDER BY RCVAPV.FTRcvCode,RCVAPV.FNSdtSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aDataReturn = array(
                'aItems'    => $oQuery->result_array(),
                'tCode'     => '1',
                'tDesc'     => 'success',
            );
        }else{
            $aDataReturn = array(
                'aItems'    => array(),
                'tCode'     => '800',
                'tDesc'     => 'data not found',
            );
        }
        return $aDataReturn;
    }

    
    // Create By : Napat(Jame) 25/03/2022
    public function FSaMSMTEventGetDataShfHD($paParamsData){
        $tBchCode = $paParamsData['FTBchCode'];
        $tShfCode = $paParamsData['FTShfCode'];
        $nLngID   = $paParamsData['FNLngID'];

        $tSQL = "   SELECT
                        HD.FTBchCode,
                        BCHL.FTBchName,
                        HD.FTPosCode,
                        POSL.FTPosName,
                        HD.FTShfCode,
                        HD.FTUsrCode,
                        USRL.FTUsrName,
                        HD.FDShdSignIn,
                        HD.FDShdSignOut,
                        ISNULL(HD.FTShdStaPrc,'') AS FTShdStaPrc,
                        USRAPV.FTUsrCode AS FTUsrApvCode,
                        USRAPV.FTUsrName AS FTUsrApvName
                    FROM TPSTShiftHD HD WITH(NOLOCK)
                    LEFT JOIN TCNMBranch_L	BCHL   WITH(NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMPos_L		POSL   WITH(NOLOCK) ON HD.FTPosCode = POSL.FTPosCode AND HD.FTBchCode = POSL.FTBchCode AND POSL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L	USRL   WITH(NOLOCK) ON HD.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L	USRAPV WITH(NOLOCK) ON HD.FTLastUpdBy = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                    WHERE HD.FTBchCode = '$tBchCode' 
                      AND HD.FTShfCode = '$tShfCode' ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aDataReturn = array(
                'aItems'    => $oQuery->row_array(),
                'tCode'     => '1',
                'tDesc'     => 'success',
            );
        }else{
            $aDataReturn = array(
                'aItems'    => array(),
                'tCode'     => '800',
                'tDesc'     => 'data not found',
            );
        }
        return $aDataReturn;
    }

    // Create By : Napat(Jame) 25/03/2022
    public function FSaMSMTEventEditInline($paParamsData){
        $tBchCode    = $paParamsData['FTBchCode'];
        $tShfCode    = $paParamsData['FTShfCode'];
        $tRcvCode    = $paParamsData['FTRcvCode'];
        $nRcvSeqNo   = $paParamsData['FNSdtSeqNo'];
        $cSupKeyAmt  = $paParamsData['FCRcvSupKeyAmt'];

        // อัพเดทฟิวส์ FCRcvSupKeyAmt
        // นำฟิวส์ที่อัพเดทไป - ยอดชำระจากระบบ = ยอด diff
        $tSQL = "   UPDATE A
                    SET A.FCRcvSupKeyDiff = ($cSupKeyAmt - B.FCRcvPayAmt),
                        A.FCRcvSupKeyAmt = $cSupKeyAmt
                    FROM TPSTShiftSKeyRcvApv A
                    INNER JOIN TPSTShiftSKeyRcvApv B ON A.FTBchCode = B.FTBchCode AND A.FTShfCode = B.FTShfCode AND A.FTRcvCode = B.FTRcvCode AND A.FNSdtSeqNo = B.FNSdtSeqNo
                    WHERE A.FTShfCode = '$tShfCode' 
                        AND A.FTBchCode = '$tBchCode'
                        AND A.FTRcvCode = '$tRcvCode'
                        AND A.FNSdtSeqNo = $nRcvSeqNo  ";
        $this->db->query($tSQL);
        
        // $this->db->set('FCRcvSupKeyAmt', $cSupKeyAmt);
        // $this->db->where('FTBchCode', $tBchCode);
        // $this->db->where('FTShfCode', $tShfCode);
        // $this->db->where('FTRcvCode', $tRcvCode);
        // $this->db->where('FNSdtSeqNo', $nRcvSeqNo);
        // $this->db->update('TPSTShiftSKeyRcvApv');

        // $tSQL = "   UPDATE TPSTShiftSKeyRcvApv
        //                 SET TPSTShiftSKeyRcvApv.FCRcvSupKeyDiff = (RCVAPV.FCRcvSupKeyAmt - RCVAPV.FCRcvPayAmt)
        //             FROM TPSTShiftSKeyRcvApv RCVAPV
        //             WHERE RCVAPV.FTShfCode = '$tShfCode' 
        //               AND RCVAPV.FTBchCode = '$tBchCode'
        //               AND RCVAPV.FTRcvCode = '$tRcvCode'
        //               AND RCVAPV.FNSdtSeqNo = $nRcvSeqNo ";
        // $this->db->query($tSQL);

        // ถ้า seq ที่แก้ไขอยู่ ไม่ใช่ตัวหลัก ต้องเอายอดคีย์ทั้งหมดของตัวย่อย SUM และอัพเดทให้ตัวหลัก
        // SUM(ยอดตัวย่อย) add to ยอดตัวหลัก
        if( $nRcvSeqNo != 1 ){
            $tSQL = "   SELECT RCVAPV.FTBchCode,RCVAPV.FTPosCode,RCVAPV.FTShfCode,RCVAPV.FTRcvCode,SUM(RCVAPV.FCRcvSupKeyAmt) AS FCRcvSupKeyAmt
                        FROM TPSTShiftSKeyRcvApv RCVAPV
                        WHERE RCVAPV.FTShfCode = '$tShfCode' 
                        AND RCVAPV.FTBchCode = '$tBchCode'
                        AND RCVAPV.FTRcvCode = '$tRcvCode'
                        AND RCVAPV.FNSdtSeqNo <> 1
                        GROUP BY RCVAPV.FTBchCode,RCVAPV.FTPosCode,RCVAPV.FTShfCode,RCVAPV.FTRcvCode ";
            $oQuery = $this->db->query($tSQL);
            $cRcvSupKeyAmt = $oQuery->row_array()['FCRcvSupKeyAmt'];

            $tSQL = "   UPDATE A
                        SET A.FCRcvSupKeyDiff = ($cRcvSupKeyAmt - B.FCRcvPayAmt),
                            A.FCRcvSupKeyAmt = $cRcvSupKeyAmt
                        FROM TPSTShiftSKeyRcvApv A
                        INNER JOIN TPSTShiftSKeyRcvApv B ON A.FTBchCode = B.FTBchCode AND A.FTShfCode = B.FTShfCode AND A.FTRcvCode = B.FTRcvCode AND A.FNSdtSeqNo = B.FNSdtSeqNo
                        WHERE A.FTShfCode = '$tShfCode' 
                          AND A.FTBchCode = '$tBchCode'
                          AND A.FTRcvCode = '$tRcvCode'
                          AND A.FNSdtSeqNo = 1  ";
            $this->db->query($tSQL);
        }

        if( $this->db->affected_rows() > 0 ){
            $aDataReturn = array(
                'tCode' => '1',
                'tDesc' => 'อัพเดทฟิวส์ FCRcvSupKeyAmt สำเร็จ'
            );
        }else{
            $aDataReturn = array(
                'tCode' => '99',
                'tDesc' => 'ไม่สามารถอัพเดทได้'
            );
        }
        return $aDataReturn;
    }
    
    // Create By : Napat(Jame) 31/03/2022
    public function FSaMSMTEventShiftApprove($paParamsData){
        $tBchCode    = $paParamsData['FTBchCode'];
        $tShfCode    = $paParamsData['FTShfCode'];
        $tLastUpdBy  = $paParamsData['FTLastUpdBy'];

        // อัพเดทสถานะ Approve
        $this->db->set('FTShdStaPrc', '1');
        $this->db->set('FTLastUpdBy', $tLastUpdBy);
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->where('FTShfCode', $tShfCode);
        $this->db->update('TPSTShiftHD');

        if( $this->db->affected_rows() > 0 ){
            $aDataReturn = array(
                'tCode' => '1',
                'tDesc' => 'อนุมัติสำเร็จ'
            );
        }else{
            $aDataReturn = array(
                'tCode' => '99',
                'tDesc' => 'ไม่สามารถอนุมัติได้'
            );
        }
        return $aDataReturn;
    }


}