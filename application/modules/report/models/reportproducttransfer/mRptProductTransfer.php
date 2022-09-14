<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptProductTransfer extends CI_Model
{

    /**
     * Functionality: Call Store Procuture
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Wasin(Yoshi)
     * Last Modified : 19/11/2019 Piya
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreCReport($paDataFilter)
    {

        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];

        $tCallStore = "{ CALL SP_RPTxVDPdtTwx2002003(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            // 21
            'pnLngID' => $paDataFilter['nLangID'],
            'pnComName' => $paDataFilter['tCompName'],
            'ptRptCode' => $paDataFilter['tRptCode'],
            'ptUsrSession' => $paDataFilter['tUserSessionID'],
            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF' => $paDataFilter['tMerCodeFrom'],
            'ptMerT' => $paDataFilter['tMerCodeTo'],
            'ptShpFF' => $paDataFilter['tShpTCodeFrom'],
            'ptShpFT' => $paDataFilter['tShpTCodeTo'],
            'ptShpTF' => $paDataFilter['tShpRCodeFrom'],
            'ptShpTT' => $paDataFilter['tShpRCodeTo'],
            'ptPosFF' => $paDataFilter['tPosTCodeFrom'],
            'ptPosFT' => $paDataFilter['tPosTCodeTo'],
            'ptPosTF' => $paDataFilter['tPosRCodeFrom'],
            'ptPosTT' => $paDataFilter['tPosRCodeTo'],
            'ptWahFF' => $paDataFilter['tWahTCodeFrom'],
            'ptWahFT' => $paDataFilter['tWahTCodeTo'],
            'ptWahTF' => $paDataFilter['tWahRCodeFrom'],
            'ptWahTT' => $paDataFilter['tWahRCodeTo'],
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'FNResult' => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        if ($oQuery !== FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession)
    {

        $tSQL = "
            UPDATE TRPTVDPdtTwxTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT 
                    ROW_NUMBER() OVER(PARTITION BY FTXthDocNo ORDER BY FDXthDocDate DESC, FTXthDocNo ASC, FTPdtCode ASC) AS PartID, 
                    FTRptRowSeq  
                FROM TRPTVDPdtTwxTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$ptComName' 
                AND TMP.FTRptCode = '$ptRptCode'
                AND TMP.FTUsrSession = '$ptUsrSession'
            ) B
            WHERE TRPTVDPdtTwxTmp.FTRptRowSeq = B.FTRptRowSeq 
            AND TRPTVDPdtTwxTmp.FTComName = '$ptComName' 
            AND TRPTVDPdtTwxTmp.FTRptCode = '$ptRptCode'
            AND TRPTVDPdtTwxTmp.FTUsrSession = '$ptUsrSession'
        ";
        $this->db->query($tSQL);
    }

    public function FMaMRPTPagination($paDataWhere)
    {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tSessionID'];

        $tSQL = "   
            SELECT
                TTVD_TMP.FTXthDocNo
            FROM TRPTVDPdtTwxTmp TTVD_TMP WITH(NOLOCK)
            WHERE TTVD_TMP.FTComName    = '$tComName'
            AND TTVD_TMP.FTRptCode    = '$tRptCode'
            AND TTVD_TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage); //RowId Start
        if ($nRptAllRecord <= $nPerPage) {
            $nTotalPage = 1;
        } else if (($nRptAllRecord % $nPerPage) == 0) {
            $nTotalPage = ($nRptAllRecord / $nPerPage);
        } else {
            $nTotalPage = ($nRptAllRecord / $nPerPage) + 1;
            $nTotalPage = (int) $nTotalPage;
        }

        // get rowid end
        $nRowIDEnd = $nPerPage * $nPage;
        if ($nRowIDEnd > $nRptAllRecord) {
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord" => $nRptAllRecord,
            "nTotalPage" => $nTotalPage,
            "nDisplayPage" => $paDataWhere['nPage'],
            "nRowIDStart" => $nRowIDStart,
            "nRowIDEnd" => $nRowIDEnd,
            "nPrevPage" => $nPrevPage,
            "nNextPage" => $nNextPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    /**
     * Functionality: Get Report
     * Parameters:  Function Parameter
     * Creator: 18/07/2019 Wasin(Yoshi)
     * Last Modified : 19/11/2019 Piya
     * Return : Data Report
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere)
    {
        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];

        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);
        $this->tCompName = $tFullHost;

        //Set Priority
        $tComName = $tFullHost;
        $tRptCode = $paDataWhere['tRptCode'];
        $tSession = $this->session->userdata('tSesSessionID');


        $aDta = $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        $tSQL = " 
            SELECT 
                L.*,
                T.FCXrcNetFooter
            FROM(
                SELECT 
                    ROW_NUMBER() OVER(ORDER BY FDXthDocDate DESC, FTXthDocNo ASC, FTPdtCode ASC) AS RowID, 
                    A.*,
                    S.FNRptGroupMember,
                    S.FCSdtSubQty
                FROM TRPTVDPdtTwxTmp A
                /* Calculate Misures */
                LEFT JOIN 
                (SELECT FTXthDocNo AS FTRcvCode_SUM,
                    COUNT(FTXthDocNo) AS FNRptGroupMember,
                    SUM(FCXtdQty) AS FCSdtSubQty
                FROM TRPTVDPdtTwxTmp 
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tSession'
                GROUP BY FTXthDocNo
                ) S ON A.FTXthDocNo = S.FTRcvCode_SUM
                WHERE A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tSession'
                /* End Calculate Misures */
            ) L 
        ";

        //Join เพื่อหา Summaty Footer
        $tSQL .= " LEFT JOIN ";

        //Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {

            $tSQL .= " 
                (SELECT 
                    FTUsrSession AS  FTUsrSession_Footer, 
                    SUM(FCXrcNet) AS FCXrcNetFooter
                FROM TRPTSalRCTmp
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tSession'
                GROUP BY FTUsrSession) T ON L.FTUsrSession = T.FTUsrSession_Footer 
            ";
        } else{

            //ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
            $tSQL .= " 
                (SELECT '$tSession' AS FTUsrSession_Footer,
                     '0' AS FCXrcNetFooter ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FDXthDocDate DESC, L.FTXthDocNo ASC, L.FTPdtCode ASC ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->result_array();
        } else {
            $aData = NULL;
        }

        $aErrorList = array(
            "nErrInvalidPage" => ""
        );

        $aResualt = array(
            "aPagination" => $aPagination,
            "aRptData" => $aData,
            "aError" => $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return  $aResualt;
    }
 
    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 11/04/2019 Witsarut(Bell)
     * Last Modified: 19/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSnMCountDataReportAll($paDataWhere)
    {
        $tSessionID = $paDataWhere['tSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSQL = "   
            SELECT 
                COUNT(DTTMP.FTRptCode) AS rnCountPage 
            FROM TRPTVDPdtTwxTmp AS DTTMP WITH(NOLOCK)
            WHERE 1 = 1
            AND FTUsrSession = '$tSessionID'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
         ";
         $oQuery = $this->db->query($tSQL);
         $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
         unset($oQuery);
         return $nRptAllRecord;
    }
}
