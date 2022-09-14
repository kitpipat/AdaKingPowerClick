<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 */
class mVerification extends CI_Model {

    public $nAlwHD;

    private function FCNaMVFNCallLenData($pnPerPage, $pnPage) {
        $nPerPage = $pnPerPage;
        if (isset($pnPage)) {
            $nPage = $pnPage;
        } else {
            $nPage = 1;
        }
        $nRowStart = (($nPerPage * $nPage) - $nPerPage);
        $nRowEnd = $nPerPage * $nPage;
        $aLenData = array(
            $nRowStart,
            $nRowEnd
        );
        return $aLenData;
    }

    public function FSxCVFNList($tFTBnkCode, $tFDDate, $tFTShdDocNo, $tFTRcvCode, $nPageNo = 1) {
        $aRowLen = $this->FCNaMVFNCallLenData(8, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        if ($tFTBnkCode != '') {
            $tFTBnkCode = " AND CRC.FTBnkCode = '$tFTBnkCode'";
        }
        if ($tFTShdDocNo != '') {
            $tFTShdDocNo = " AND CRC.FTShdDocNo = '$tFTShdDocNo'";
        }
        if ($tFDDate != '') {
            $tFDDate = " AND CONVERT(char(10), CRC.FDShdDocDate,126) = '$tFDDate'";
        }
        $tSQL = "SELECT c.* FROM (
		SELECT ROW_NUMBER() OVER(ORDER BY CRC.FNSrcID DESC) AS RowID,		
		CRC.FNSrcID,
		CRC.FTShdDocNo,
		CRC.FCSrcFAmt,
		CRC.FCSrcAmt,
		CRC.FCSrcNet,
		CRC.FTRcvCode,					
		CRC.FDShdDocDate,
		CST.FTCstKeyAccess,
		CST.FTCstTel,
		CST.FTCstEmail,
		CSTL.FTCstName,
		BNK.FTBnkName,
		IMG.FTImgObj,
		MDL.FTPmoName
		FROM TTKTxnCartHD AS HD
		INNER JOIN TTKTxnCartRC AS CRC ON CRC.FTShdDocNo = HD.FTTxhDocRef AND CRC.FTRcvCode = '$tFTRcvCode'".$tFTBnkCode . $tFTShdDocNo . $tFDDate ."
		LEFT JOIN TTKMPdtModel_L AS MDL ON MDL.FNPmoID = HD.FNPmoID
		LEFT JOIN TFNMBank_L AS BNK ON BNK.FTBnkCode = CRC.FTBnkCode AND BNK.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
		LEFT JOIN TTKMCst AS CST ON CST.FTCstKeyAccess = CRC.FTCstKeyAccess					
		LEFT JOIN TTKMCst_L AS CSTL ON CSTL.FNCstID = CST.FNCstID AND CSTL.FNLngID = '1'
		LEFT JOIN TCNMImgObj AS IMG ON IMG.FTImgRefID = CRC.FTShdDocNo AND IMG.FTImgTable = 'TTKTxnCartRC' 
		WHERE NULLIF(HD.FTTxhDocRef, '') IS NOT NULL AND HD.FTTxhStaPaid = '4' ";
        $tSQL .= " GROUP BY CRC.FNSrcID, CRC.FTShdDocNo, CRC.FCSrcFAmt, CRC.FCSrcAmt, CRC.FCSrcNet, CRC.FTRcvCode, CRC.FDShdDocDate, CST.FTCstKeyAccess, CST.FTCstTel, CST.FTCstEmail, CSTL.FTCstName, BNK.FTBnkName, IMG.FTImgObj, MDL.FTPmoName";
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }
    public function FStMVFNCount($tFTBnkCode, $tFDDate, $tFTShdDocNo, $tFTRcvCode) {
        if ($tFTBnkCode != '') {
            $tFTBnkCode = " AND CRC.FTBnkCode = '$tFTBnkCode'";
        }
        if ($tFTShdDocNo != '') {
            $tFTShdDocNo = " AND CRC.FTShdDocNo = '$tFTShdDocNo'";
        }
        if ($tFDDate != '') {
            $tFDDate = " AND CONVERT(char(10), CRC.FDShdDocDate,126) = '$tFDDate'";
        }
        $tSQL = "SELECT COUNT(DISTINCT CRC.FNSrcID) AS counts 
		FROM TTKTxnCartHD AS HD
		INNER JOIN TTKTxnCartRC AS CRC ON CRC.FTShdDocNo = HD.FTTxhDocRef AND CRC.FTRcvCode = '$tFTRcvCode' " . $tFTBnkCode . $tFTShdDocNo . $tFDDate . "
		WHERE NULLIF(HD.FTTxhDocRef, '') IS NOT NULL AND HD.FTTxhStaPaid = '4' 
		";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMVFNBankMaster() {
        $tSQL = "SELECT *
		FROM TFNMBank_L 
		WHERE FNLngID = '" . $this->session->userdata("tLangEdit") . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMVFNApprove($aData) {
        $this->db->where('FTShdDocNo', $aData ['FTShdDocNo']);
        $this->db->update('TTKTxnCartRC', array(
            'FCSrcNet' => $aData ['FCSrcNet']
        ));
        $this->db->where('FTTxhDocRef', $aData ['FTShdDocNo']);
        $this->db->where('FTTxhStaPaid', 4);
        $this->db->update('TTKTxnCartHD', array(
            'FTTxhStaPaid' => 3,
            'FDTxhChkPay' => date('Y-m-d H:i'),
            'FTTxhUsrChkPay' => $this->session->userdata("tSesUsername"),
        ));
        $tSQL = "SELECT FNTxhID
		FROM TTKTxnCartHD
		WHERE FTTxhDocRef = '" . $aData ['FTShdDocNo'] . "'";
        $oQuery = $this->db->query($tSQL);
        $oResult = $oQuery->result();

        $this->db->where('FNTxhID', $oResult [0]->FNTxhID);
        $this->db->where('FTTxhStaPaid', 4);
        $this->db->update('TTKTxnCartDT', array(
            'FTTxhStaPaid' => 3,
        ));
    }

    public function FSxCVFNCheckTicketCancellation($aData,$nPageNo = 1) {
        $aRowLen = $this->FCNaMVFNCallLenData(8, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQLtFTRcvCode = '';
        if ($aData['FTRcvCode'] != '') {
            $tSQLtFTRcvCode = " AND CRC.FTRcvCode = '".$aData['FTRcvCode']."' ";
        }
        $tSQLtFTShdDocNo = '';
        if ($aData['FTShdDocNo'] != '') {
            $tSQLtFTShdDocNo = " AND CRC.FTShdDocNo = '" . $aData['FTShdDocNo'] . "' ";
        }

        $tSQL = "SELECT c.* FROM(
            SELECT ROW_NUMBER() OVER(ORDER BY CRC.FNSrcID DESC) AS RowID,	
		HD.FDTxhChkPay,
		CRC.FNSrcID,
		CRC.FTShdDocNo,
		CRC.FCSrcFAmt,
		CRC.FCSrcAmt,
		CRC.FCSrcNet,
		CRC.FTRcvCode,					
		CRC.FDShdDocDate,
		CST.FTCstKeyAccess,
		CST.FTCstTel,
		CST.FTCstEmail,
		CSTL.FTCstName,
		BNK.FTBnkName,
		IMG.FTImgObj,
		MDL.FTPmoName,
		USRL.FTUsrName
		FROM TTKTxnCartHD AS HD
		INNER JOIN TTKTxnCartRC AS CRC ON CRC.FTShdDocNo = HD.FTTxhDocRef $tSQLtFTRcvCode $tSQLtFTShdDocNo
		LEFT JOIN TTKMPdtModel_L AS MDL ON MDL.FNPmoID = HD.FNPmoID
		LEFT JOIN TFNMBank_L AS BNK ON BNK.FTBnkCode = CRC.FTBnkCode AND BNK.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
		LEFT JOIN TTKMCst AS CST ON CST.FTCstKeyAccess = CRC.FTCstKeyAccess					
		LEFT JOIN TTKMCst_L AS CSTL ON CSTL.FNCstID = CST.FNCstID AND CSTL.FNLngID = '1'
		LEFT JOIN TCNMUser_L AS USRL ON USRL.FTUsrCode = HD.FTTxhUsrChkPay AND USRL.FNLngID = '1'
        LEFT JOIN TCNMImgObj AS IMG ON IMG.FTImgRefID = CRC.FTShdDocNo AND IMG.FTImgTable = 'TTKTxnCartRC'                
        WHERE NULLIF(HD.FTTxhDocRef, '') IS NOT NULL AND HD.FTTxhStaPaid = '3' GROUP BY HD.FDTxhChkPay, CRC.FNSrcID, CRC.FTShdDocNo, CRC.FCSrcFAmt, CRC.FCSrcAmt, CRC.FCSrcNet, CRC.FTRcvCode, CRC.FDShdDocDate, CST.FTCstKeyAccess, CST.FTCstTel, CST.FTCstEmail, CSTL.FTCstName, BNK.FTBnkName, IMG.FTImgObj, MDL.FTPmoName, USRL.FTUsrName";
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
            
        } else {
            return false;
        }
    }


    public function FStMVFNCancellationCount($aData) {
        $tSQLtFTRcvCode = '';
        if ($aData['FTRcvCode'] != '') {
            $tSQLtFTRcvCode = " AND CRC.FTRcvCode = '".$aData['FTRcvCode']."' ";
        }
        $tSQLtFTShdDocNo = '';
        if ($aData['FTShdDocNo'] != '') {
            $tSQLtFTShdDocNo = " AND CRC.FTShdDocNo = '" . $aData['FTShdDocNo'] . "' ";
        }
        $tSQL = "SELECT count(base.FTShdDocNo) AS counts FROM (
            SELECT  CRC.FTShdDocNo
             FROM TTKTxnCartHD AS HD
             INNER JOIN TTKTxnCartRC AS CRC ON CRC.FTShdDocNo = HD.FTTxhDocRef $tSQLtFTRcvCode $tSQLtFTShdDocNo
             LEFT JOIN TTKMPdtModel_L AS MDL ON MDL.FNPmoID = HD.FNPmoID
             LEFT JOIN TFNMBank_L AS BNK ON BNK.FTBnkCode = CRC.FTBnkCode AND BNK.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
             LEFT JOIN TTKMCst AS CST ON CST.FTCstKeyAccess = CRC.FTCstKeyAccess     
             LEFT JOIN TTKMCst_L AS CSTL ON CSTL.FNCstID = CST.FNCstID AND CSTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
             LEFT JOIN TCNMUser_L AS USRL ON USRL.FTUsrCode = HD.FTTxhUsrChkPay AND USRL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
             LEFT JOIN TCNMImgObj AS IMG ON IMG.FTImgRefID = CRC.FTShdDocNo AND IMG.FTImgTable = 'TTKTxnCartRC'                
             WHERE NULLIF(HD.FTTxhDocRef, '') IS NOT NULL AND HD.FTTxhStaPaid = '3' GROUP BY HD.FDTxhChkPay, CRC.FNSrcID, CRC.FTShdDocNo, CRC.FCSrcFAmt, 
            CRC.FCSrcAmt, CRC.FCSrcNet, CRC.FTRcvCode, CRC.FDShdDocDate, 
            CST.FTCstKeyAccess, CST.FTCstTel, CST.FTCstEmail, 
            CSTL.FTCstName, BNK.FTBnkName, IMG.FTImgObj, MDL.FTPmoName, USRL.FTUsrName
           ) base";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMVFNRsn() {
        $tSQL = "SELECT RSN.*, RSNL.FTRsnName
		FROM TCNMRsn AS RSN
		LEFT JOIN TCNMRsn_L AS RSNL ON RSNL.FTRsnCode = RSN.FTRsnCode AND RSNL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMVFNCancelTicket($FTSDocNo,$FTTxhRsnCode)
    {
       
        $tSQL = "SELECT COUNT(FTShdDocNo) AS count
		FROM TTKTxnCartRC
		WHERE FTShdDocNo = '$FTSDocNo'";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count != 0) {
        $this->db->where('FTShdDocNo', $FTSDocNo);
        $this->db->update('TTKTxnCartRC', array(
            'FCSrcAmt' => NULL,
            'FCSrcNet' => NULL,
        ));
        $this->db->where('FTTxhDocRef', $FTSDocNo);
        $this->db->where('FTTxhStaPaid', 3);
        $this->db->update('TTKTxnCartHD', array(
            'FTTxhRsnCode' => $FTTxhRsnCode,
            'FTTxhStaPaid' => 1,
            'FDTxhChkPay' => NULL,
            'FTTxhUsrChkPay' => NULL,
            'FDTxhVoidPay' => date('Y-m-d H:i'),
            'FDTxhUsrVoidPay' => $this->session->userdata("tSesUsername"),
        ));
        $tSQL = "SELECT FNTxhID
                FROM TTKTxnCartHD
                WHERE FTTxhDocRef = '" . $FTSDocNo . "'";
        $oQuery = $this->db->query($tSQL);
        $oResult = $oQuery->result();
        $this->db->where('FNTxhID', $oResult [0]->FNTxhID);
        $this->db->where('FTTxhStaPaid', 3);
        $this->db->update('TTKTxnCartDT', array(
            'FTTxhStaPaid' => 1,
        ));
            return 1;
        } else {
            return 0;
        }
    }
    
        

    public function FSxMVFNRCVM() {
        $tSQL = "SELECT FTRcvCode
		FROM TFNMRcv WHERE FTFmtCode = '005'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }
    
    
    public function FSxMVFNOrder($tShdDocNo) {
        $tSQL = "SELECT *
		FROM TTKTxnCartRC WHERE FTShdDocNo = '$tShdDocNo'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }


    //  Functionality : ส่งเมล์ User
    //  Parameters : -
    //  Creator : 15/02/2562 (saharat)
    //  Last Modified : -  
    //  Return : array
    //  Return Type : array
    public function FSaMVFNEmail(){
        $tSQL = " SELECT US.FTUsrEmail,TUL.FTUsrName
        FROM TCNMUser AS US
        LEFT JOIN TCNMUser_L AS TUL ON TUL.FTUsrCode = US.FTUsrCode AND TUL.FNLngID  = '" . $this->session->userdata("tLangEdit") . "'
        WHere  US.FTUsrCode  = '" .$this->session->userdata("tSesUsername"). "' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        } else {
            return false;
        }

    }

}

