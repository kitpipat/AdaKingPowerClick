<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep4ChnCondition extends CI_Model
{
    /**
     * Functionality : Get Channel in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Data List PdtPmtHDChn
     * Return Type : Array
     */
    public function FSaMGetPdtPmtHDChnInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTChnName ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmhDocNo,
                        TMP.FTChnCode,
                        TMP.FTChnName,
                        TMP.FTPmhStaType,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtHDChn_Tmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPdtPmtHDCstPriInTmpPageAll($paParams);
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
     * Functionality : Count PdtPmtHDChn in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Count PdtPmtHDChn
     * Return Type : Number
     */
    public function FSnMTFWGetPdtPmtHDCstPriInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTPdtPmtHDChn_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert PdtPmtHDChn to Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtHDChnToTemp($paParams = [])
    {
       
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];

        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->set('FTChnCode', $paParams['tChnCode']); // รหัสช่องทางการขาย
        $this->db->set('FTChnName', $paParams['tChnName']); // ชื่อช่องทางการขาย
        $this->db->set('FTPmhStaType', '1'); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น

        $this->db->set('FDCreateOn', $tUserSessionDate);
        $this->db->set('FTSessionID', $tUserSessionID);
        $this->db->insert('TCNTPdtPmtHDChn_Tmp');

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert TCNTPdtPmtHDChn_Tmp Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert TCNTPdtPmtHDChn_Tmp Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update PmtCB Value in Temp by Primary Key
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdateChnInTmpByKey($paParams = [])
    {
        $this->db->set('FTPmhStaType', $paParams['tPmhStaType']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTChnCode', $paParams['tChnCode']);
        $this->db->update('TCNTPdtPmtHDChn_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PdtPmtHDChn in Temp by Primary Key
     * Parameters : -
     * Creator :  04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePdtPmtHDChnInTmpByKey($paParams = [])
    {
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTChnCode', $paParams['tChnCode']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDChn_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear PdtPmtHDChn in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPdtPmtHDCstPriInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDChn_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
