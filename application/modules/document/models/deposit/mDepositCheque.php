<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mDepositCheque extends CI_Model
{
    /**
     * Functionality : Get Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List Cheque
     * Return Type : Array
     */
    public function FSaMGetChequeInTmp($paParams = [])
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
                        TMP.FTBddRefBnkNameForDeposit,
                        TMP.FTSessionID
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND TMP.FTBddTypeForDeposit = '2'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetChequeInTmpPageAll($paParams);
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
     * Functionality : Count Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count Cheque
     * Return Type : Number
     */
    public function FSnMTFWGetChequeInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTDocDTTmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID' 
            AND TMP.FTBddTypeForDeposit = '2'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Insert Cheque to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMChequeToTemp($paParams = [])
    {
        $tBchCode = $paParams['tBchCode'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tDocKey = $paParams['tDocKey'];

        $this->db->set('FTBchCode', $tBchCode);
        $this->db->set('FTXthDocNo', $paParams['tDocNo']);
        $this->db->set('FNXtdSeqNo', "(SELECT (ISNULL(MAX(FNXtdSeqNo), 0) + 1) AS FNXtdSeqNo FROM TCNTDocDTTmp WHERE FTSessionID = '$tUserSessionID' AND FTXthDocKey = '$tDocKey' AND FTBchCode = '$tBchCode')", false);
        $this->db->set('FTXthDocKey', $tDocKey);
        $this->db->set('FTBddTypeForDeposit', '2'); // เช็ค
        $this->db->set('FTBddRefNoForDeposit', $paParams['tChequeRefNo']);
        $this->db->set('FCBddRefAmtForDeposit', $paParams['cChequeValue']);
        $this->db->set('FTBddRefBnkNameForDeposit', $paParams['tChequeBnkName']);
        $this->db->set('FTSessionID', $tUserSessionID);
        $this->db->insert('TCNTDocDTTmp');

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert Cheque Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert Cheque Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update Cheque Value in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdateChequeInTmpBySeq($paParams = [])
    {
        $this->db->set('FTBddRefNoForDeposit', $paParams['tChequeRefNo']);
        $this->db->set('FCBddRefAmtForDeposit', $paParams['cChequeValue']);
        $this->db->set('FDLastUpdOn', 'GETDATE()', false);
        $this->db->set('FTLastUpdBy', $paParams['tUserLoginCode']);
        $this->db->where('FTBddTypeForDeposit', '2');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->update('TCNTDocDTTmp');
        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete Cheque in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeleteChequeInTmpBySeq($paParams = [])
    {
        $this->db->where('FTBddTypeForDeposit', '2');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->delete('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearChequeInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTBddTypeForDeposit', '2');
        $this->db->delete('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
