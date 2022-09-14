<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep4PriceGroupCondition extends CI_Model
{
    /**
     * Functionality : Get PdtPmtHDCstPri in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PdtPmtHDCstPri
     * Return Type : Array
     */
    public function FSaMGetPdtPmtHDCstPriInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTPplName ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmhDocNo,
                        TMP.FTPplCode,
                        TMP.FTPplName,
                        TMP.FTPmhStaType,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtHDCstPri_Tmp TMP WITH(NOLOCK)
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
     * Functionality : Count PdtPmtHDCstPri in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PdtPmtHDCstPri
     * Return Type : Number
     */
    public function FSnMTFWGetPdtPmtHDCstPriInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTPdtPmtHDCstPri_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert PdtPmtHDCstPri to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPdtPmtHDCstPriToTemp($paParams = [])
    {
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];

        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->set('FTPplCode', $paParams['tPplCode']); // รหัสกลุ่มราคา
        $this->db->set('FTPplName', $paParams['tPplName']); // ชื่อกลุ่มราคา
        $this->db->set('FTPmhStaType', '1'); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น

        $this->db->set('FDCreateOn', $tUserSessionDate);
        $this->db->set('FTSessionID', $tUserSessionID);
        $this->db->insert('TCNTPdtPmtHDCstPri_Tmp');

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert TCNTPdtPmtHDCstPri_Tmp Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert TCNTPdtPmtHDCstPri_Tmp Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update PmtCB Value in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePriceGroupInTmpByKey($paParams = [])
    {
        $this->db->set('FTPmhStaType', $paParams['tPmhStaType']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPplCode', $paParams['tPplCode']);
        $this->db->update('TCNTPdtPmtHDCstPri_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete PdtPmtHDCstPri in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePdtPmtHDCstPriInTmpByKey($paParams = [])
    {
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTPplCode', $paParams['tPplCode']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDCstPri_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear PdtPmtHDCstPri in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPdtPmtHDCstPriInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTPdtPmtHDCstPri_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
