<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mDepositCash extends CI_Model
{
    /**
     * Functionality : Get Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List Cash
     * Return Type : Array
     */
    public function FSaMGetCashInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTXthDocNo,
                        TMP.FNXtdSeqNo,
                        TMP.FTXthDocKey,
                        TMP.FTPdtCode,
                        TMP.FTXtdPdtName,
                        TMP.FTBddTypeForDeposit,
                        TMP.FTBddRefNoForDeposit,
                        TMP.FDBddRefDateForDeposit,
                        TMP.FCBddRefAmtForDeposit,
                        TMP.FTSessionID
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND TMP.FTBddTypeForDeposit = '1'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetCashInTmpPageAll($paParams);
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
     * Functionality : Count Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count Cash
     * Return Type : Number
     */
    public function FSnMTFWGetCashInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTDocDTTmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID' 
            AND TMP.FTBddTypeForDeposit = '1'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert Cash to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMCashToTemp($paParams = [])
    {
        $tBchCode = $paParams['tBchCode'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tDocKey = $paParams['tDocKey'];

        $this->db->set('FTBchCode', $tBchCode);
        $this->db->set('FTXthDocNo', $paParams['tDocNo']);
        $this->db->set('FNXtdSeqNo', "(SELECT (ISNULL(MAX(FNXtdSeqNo), 0) + 1) AS FNXtdSeqNo FROM TCNTDocDTTmp WHERE FTSessionID = '$tUserSessionID' AND FTXthDocKey = '$tDocKey' AND FTBchCode = '$tBchCode')", false);
        $this->db->set('FTXthDocKey', $tDocKey);
        $this->db->set('FTBddTypeForDeposit', '1'); // เงินสด
        $this->db->set('FDBddRefDateForDeposit', $paParams['tCashDate']);
        $this->db->set('FCBddRefAmtForDeposit', $paParams['cCashValue']);
        $this->db->set('FTSessionID', $tUserSessionID);
        $this->db->insert('TCNTDocDTTmp');

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert Cash Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert Cash Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update Cash Value in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdateCashInTmpBySeq($paParams = [])
    {
        $this->db->set('FDBddRefDateForDeposit', $paParams['tCashDate']);
        $this->db->set('FCBddRefAmtForDeposit', $paParams['cCashValue']);
        $this->db->set('FDLastUpdOn', 'GETDATE()', false);
        $this->db->set('FTLastUpdBy', $paParams['tUserLoginCode']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->where('FTBddTypeForDeposit', '1');
        $this->db->update('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete Cash in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeleteCashInTmpBySeq($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->where('FTBddTypeForDeposit', '1');
        $this->db->delete('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearCashInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTBddTypeForDeposit', '1');
        $this->db->delete('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
