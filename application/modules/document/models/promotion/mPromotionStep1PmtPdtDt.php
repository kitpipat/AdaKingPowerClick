<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep1PmtPdtDt extends CI_Model
{
    /**
     * Functionality : Get PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtPdtDt
     * Return Type : Array
     */
    public function FSaMGetPmtPdtDtInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tPmtGroupNameTmp = $paParams['tPmtGroupNameTmp'];
        $tPmtGroupTypeTmp = $paParams['tPmtGroupTypeTmp'];
        $tPmtGroupListTypeTmp = $paParams['tPmtGroupListTypeTmp'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNPmdSeq ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmhDocNo,
                        TMP.FNPmdSeq,
                        TMP.FTPmdStaType,
                        TMP.FTPmdGrpName,
                        TMP.FTPmdRefCode,
                        TMP.FTPmdRefName,
                        TMP.FTPmdSubRef,
                        TMP.FTPmdSubRefName,
                        TMP.FTPmdBarCode,
                        TMP.FTPmdStaListType,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND TMP.FTPmdGrpName = '$tPmtGroupNameTmp'
                    AND TMP.FTPmdStaType = '$tPmtGroupTypeTmp'
                    AND TMP.FTPmdStaListType = '$tPmtGroupListTypeTmp'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPmtPdtDtInTmpPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Count PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtPdtDt
     * Return Type : Number
     */
    public function FSnMTFWGetPmtPdtDtInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tPmtGroupNameTmp = $paParams['tPmtGroupNameTmp'];
        $tPmtGroupTypeTmp = $paParams['tPmtGroupTypeTmp'];
        $tPmtGroupListTypeTmp = $paParams['tPmtGroupListTypeTmp'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdGrpName = '$tPmtGroupNameTmp'
            AND TMP.FTPmdStaType = '$tPmtGroupTypeTmp'
            AND TMP.FTPmdStaListType = '$tPmtGroupListTypeTmp'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Get All PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtPdtDt
     * Return Type : Number
     */
    public function FSaMGetPmtPdtDtInAllTmp($paParams = []){
        $tPmtGroupNameTmpOld = $paParams['tPmtGroupNameTmpOld'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                *
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdRefCode IS NOT NULL
            AND TMP.FTPmdRefCode <> ''
            /* AND TMP.FTPmdGrpName = '$tPmtGroupNameTmpOld' */
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    /**
     * Functionality : Insert PmtPdtDt to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPmtPdtDtToTemp($paParams = [])
    {
        $tPmtGroupNameTmpOld = $paParams['tPmtGroupNameTmpOld'];
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];

        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->set('FNPmdSeq', "(SELECT (ISNULL(MAX(FNPmdSeq), 0) + 1) AS FNPmdSeq FROM TCNTPdtPmtDT_Tmp WITH(NOLOCK) WHERE FTSessionID = '$tUserSessionID' AND FTBchCode = '$tBchCodeLogin')", false);
        $this->db->set('FTPmdStaType', $paParams['tPmtGroupTypeTmp']); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น
        $this->db->set('FTPmdStaListType', $paParams['tPmtGroupListTypeTmp']); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น
        $this->db->set('FTPmdGrpName', $tPmtGroupNameTmpOld); // ชื่อกลุ่มจัดรายการ
        $this->db->set('FTPmdRefCode', $paParams['tPdtCode']); // รหัสสินค้า
        $this->db->set('FTPmdRefName', $paParams['tPdtName']); // ชื่อรหัสสินค้า
        $this->db->set('FTPmdSubRef', $paParams['tPunCode']); // รหัสหน่วย
        $this->db->set('FTPmdSubRefName', $paParams['tPunName']); // ชื่อรหัสหน่วย
        $this->db->set('FTPmdBarCode', $paParams['tBarCode']); // รหัสบาร์โค้ด ณ. บันทึก
        $this->db->set('FDCreateOn', $tUserSessionDate);
        $this->db->set('FTSessionID', $tUserSessionID);
        $this->db->insert('TCNTPdtPmtDT_Tmp');

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert PmtPdtDt Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert PmtPdtDt Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update PmtPdtDt Value in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtPdtDtInTmpBySeq($paParams = [])
    {
        $this->db->set('FDBddRefDateForDeposit', $paParams['tPmtPdtDtDate']);
        $this->db->set('FCBddRefAmtForDeposit', $paParams['cPmtPdtDtValue']);
        $this->db->set('FDLastUpdOn', 'GETDATE()', false);
        $this->db->set('FTLastUpdBy', $paParams['tUserLoginCode']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->where('FTBddTypeForDeposit', '1');
        $this->db->update('TCNTPdtPmtDT_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Update PmtPdtDt Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtPdtDtInTmp($paParams = [])
    {
        $this->db->set('FTPmdGrpName', $paParams['tPmtGroupNameTmp']);
        $this->db->where('FTPmdGrpName', $paParams['tPmtGroupNameTmpOld']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->update('TCNTPdtPmtDT_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PmtPdtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePmtPdtDtInTmpBySeq($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNPmdSeq', $paParams['nSeqNo']);
        $this->db->delete('TCNTPdtPmtDT_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PmtPdtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePmtPdtDtInTmpByGroupName($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTPmdGrpName', $paParams['tGroupName']);
        $this->db->delete('TCNTPdtPmtDT_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete More PmtPdtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeleteMorePmtPdtDtInTmpBySeq($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where_in('FNPmdSeq', $paParams['aSeqNo']);
        $this->db->delete('TCNTPdtPmtDT_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Check Group Name is Duplicate
     * Parameters : 
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Boolean
     */
    public function FSbMCheckPmtPdtDtDuplicateGroupName($paParams = [])
    {
        $tPmtGroupNameTmp = $paParams['tPmtGroupNameTmp'];
        $tPmtGroupNameTmpOld = $paParams['tPmtGroupNameTmpOld'];
        $tPmtGroupTypeTmp = $paParams['tPmtGroupTypeTmp'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "   
            SELECT 
                FTPmdGrpName
            FROM TCNTPdtPmtDT_Tmp
            WHERE FTPmdGrpName = '$tPmtGroupNameTmp'
            AND FTSessionID = '$tUserSessionID'
        ";

        $bStatus = false;
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
