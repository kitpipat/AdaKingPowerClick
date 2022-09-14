<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep1PmtDt extends CI_Model
{
    /**
     * Functionality : Get PmtDt Group in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtDt Group
     * Return Type : Array
     */
    public function FSaMGetPmtDtGroupInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTPmdGrpName ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmdStaType,
                        TMP.FTPmdGrpName,
                        TMP.FTPmdStaListType,
                        PdtCondL.FTDropName AS FTPmdStaListTypeName,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtDT_Tmp TMP WITH (NOLOCK)
                    LEFT JOIN TCNSPmtPdtCond_L PdtCondL WITH (NOLOCK) ON PdtCondL.FNPmtID = TMP.FTPmdStaListType AND PdtCondL.FNLngID = $nLngID
                    WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPmtDtGroupInTmpPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
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
     * Functionality : Count PmtDt Group in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtDt Group
     * Return Type : Number
     */
    public function FSnMTFWGetPmtDtGroupInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT DISTINCT
                TMP.FTBchCode,
                TMP.FTPmdStaType,
                TMP.FTPmdGrpName,
                TMP.FTPmdStaListType,
                TMP.FTSessionID
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Get PmtDt StaListType On Exclude Type in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data PmtDt Exclude
     * Return Type : Array
     */
    public function FStMGetPmtDtStaListTypeOnExcudeTypeInTmp($paParams = []){
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT DISTINCT
                TMP.FTPmdStaListType
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdStaType = '2'
        ";

        $oQuery = $this->db->query($tSQL);
        
        $tPmdStaListType = '';

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->row_array();
            $tPmdStaListType = $oDetail['FTPmdStaListType'];
        }
        return $tPmdStaListType;
    }

    /**
     * Functionality : Insert PmtPdtDt to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPmtDtShopAllToTemp($paParams = [])
    {
        $tPmtGroupNameTmp = $paParams['tPmtGroupNameTmp'];
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->set('FNPmdSeq', "(SELECT (ISNULL(MAX(FNPmdSeq), 0) + 1) AS FNPmdSeq FROM TCNTPdtPmtDT_Tmp WITH(NOLOCK) WHERE FTSessionID = '$tUserSessionID' AND FTBchCode = '$tBchCodeLogin')", false);
        $this->db->set('FTPmdStaType', $paParams['tPmtGroupTypeTmp']); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น
        $this->db->set('FTPmdStaListType', $paParams['tPmtGroupListTypeTmp']); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น
        $this->db->set('FTPmdGrpName', $tPmtGroupNameTmp); // ชื่อกลุ่มจัดรายการ
        $this->db->set('FTPmdRefCode', ''); // รหัสสินค้า
        $this->db->set('FTPmdRefName', ''); // ชื่อรหัสสินค้า
        $this->db->set('FTPmdSubRef', ''); // รหัสหน่วย
        $this->db->set('FTPmdSubRefName', ''); // ชื่อรหัสหน่วย
        $this->db->set('FTPmdBarCode', ''); // รหัสบาร์โค้ด ณ. บันทึก
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
     * Functionality : Update PmtDt Value in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtDtInTmp($paParams = [])
    {
        $this->db->set('FTPmdGrpName', $paParams['tPmtGroupNameTmp']);
        $this->db->set('FTPmdStaType', $paParams['tPmtGroupTypeTmp']);
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
     * Functionality : Delete PmtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePmtDtInTmpBySeq($paParams = [])
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
     * Functionality : Delete PmtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePmtDtInTmpByGroupName($paParams = [])
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
     * Functionality : Copy PmtDt in Temp to Bin By Group Name
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbPmtDtInTmpToBinByGroupName($paParams = []){
        $tGroupName = $paParams['tGroupName'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session

        // ทำการลบ ใน TCNTPdtPmtDT_Bin ก่อนสำเนา Temp ไป TCNTPdtPmtDT_Bin
        $this->db->where('FTPmdGrpName', $tGroupName);
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtDT_Bin');

        $tSQL = "   
            INSERT TCNTPdtPmtDT_Bin
        ";

        $tSQL .= "  
            SELECT
                TMP.*
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK)
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdGrpName = '$tGroupName'
            ORDER BY TMP.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Copy PmtDt in Bin to PmtDt in Temp By Group Name
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbBinToPmtDtInTmpByGroupName($paParams = []){
        $tGroupName = $paParams['tGroupName'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session

        // ทำการลบ ใน TCNTPdtPmtDT_Tmp ก่อนสำเนา Temp ไป TCNTPdtPmtDT_Tmp
        $this->db->where('FTPmdGrpName', $tGroupName);
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtDT_Tmp');

        $tSQL = "   
            INSERT TCNTPdtPmtDT_Tmp
        ";

        $tSQL .= "  
            SELECT
                BIN.*
            FROM TCNTPdtPmtDT_Bin BIN WITH(NOLOCK)
            WHERE BIN.FTSessionID = '$tUserSessionID'
            AND BIN.FTPmdGrpName = '$tGroupName'
            ORDER BY BIN.FTPmdGrpName ASC
        ";

        $this->db->query($tSQL);

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        // ทำการลบ ใน TCNTPdtPmtDT_Bin เมื่อสำเนา ไป TCNTPdtPmtDT_Tmp เสร็จแล้ว
        $this->db->where('FTPmdGrpName', $tGroupName);
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTPdtPmtDT_Bin');

        return $bStatus;
    }

    /**
     * Functionality : Clear PmtDt in Bin
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPmtDtInBin($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtDT_Bin');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete More PmtDt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeleteMorePmtDtInTmpBySeq($paParams = [])
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
     * Functionality : Clear PmtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPmtDtInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTPmdGrpName', $paParams['tPmtGroupNameTmpOld']);
        $this->db->delete('TCNTPdtPmtDT_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear PmtDt Shop All in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPmtDtShopAllInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTPmdGrpName', $paParams['tPmtGroupNameTmpOld']);
        $this->db->where("(FTPmdRefCode IS NULL OR FTPmdRefCode = '')");
        $this->db->where("(FTPmdSubRef IS NULL OR FTPmdSubRef = '')");
        $this->db->where("(FTPmdBarCode IS NULL OR FTPmdBarCode = '')");
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
    public function FSbMCheckPmtDtDuplicateGroupName($paParams = [])
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
