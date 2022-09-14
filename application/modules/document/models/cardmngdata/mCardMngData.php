<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCardMngData extends CI_Model
{

    //Functionality : Get Data Card For Condition Export
    //Parameters : function parameters
    //Creator :  17/10/2018 Wasin
    //Return : array Data Card Beetween Condition
    //Return Type : Array
    public function FSaMCMDGetDataCardExport($paData)
    {
        try {
            $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nLngID = $paData['FNLngID'];
            $tSearchList = $paData['tSearchAll'];
            $aBeetween = $paData['aCMDDataCons'];

            $tSQL = "
                SELECT 
                    c.* 
                FROM(
                    SELECT  
                        ROW_NUMBER() OVER(ORDER BY rtCrdCode ASC) AS rtRowID,* 
                    FROM(
                        SELECT DISTINCT
                            CRD.FTCrdCode AS rtCrdCode,
                            CRD_L.FTCrdName AS rtCrdName,
                            CRD.FTCrdHolderID AS rtCrdHolderID,
                            CRD.FDCrdStartDate AS rtCrdStartDate,
                            CRD.FDCrdExpireDate AS rtCrdExpireDate,
                            CRD.FTCtyCode AS rtCrdCtyCode,
                            CTY_L.FTCtyName AS rtCrdCtyName,
                            CRDT.FTCtyStaShift AS rtCrdStaType

                        FROM TFNMCard CRD WITH (NOLOCK)
                        LEFT JOIN TFNMCardType CRDT WITH(NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
                        LEFT JOIN TFNMCard_L CRD_L WITH (NOLOCK) ON CRD.FTCrdCode = CRD_L.FTCrdCode AND CRD_L.FNLngID = $nLngID
                        LEFT JOIN TFNMCardType_L CTY_L WITH (NOLOCK) ON CRD.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $nLngID
                        WHERE 1=1 
            ";

            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND (CRD.FTCrdCode LIKE '%$tSearchList%'";
                $tSQL .= " OR CRD_L.FTCrdName LIKE '%$tSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName LIKE '%$tSearchList%')";
            }

            if (!empty($aBeetween['tCmdCardTypeForm']) && !empty($aBeetween['tCmdCardTypeTo'])) {
                $tSQL .= " AND (CRD.FTCtyCode BETWEEN '$aBeetween[tCmdCardTypeForm]' AND '$aBeetween[tCmdCardTypeTo]'";
                $tSQL .= " OR CRD.FTCtyCode BETWEEN '$aBeetween[tCmdCardTypeTo]' AND '$aBeetween[tCmdCardTypeForm]')";
            }

            if (!empty($aBeetween['tCmdCardCodeFrom']) && !empty($aBeetween['tCmdCardCodeTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardCodeFrom]' AND '$aBeetween[tCmdCardCodeTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardCodeTo]' AND '$aBeetween[tCmdCardCodeFrom]')";
            }

            if (!empty($aBeetween['tCmdCardNameFrom']) && !empty($aBeetween['tCmdCardNameTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardNameFrom]' AND '$aBeetween[tCmdCardNameTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardNameTo]' AND '$aBeetween[tCmdCardNameFrom]')";
            }

            if (!empty($aBeetween['tCmdCardHolderIDFrom']) && !empty($aBeetween['tCmdCardHolderIDTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardHolderIDFrom]' AND '$aBeetween[tCmdCardHolderIDTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardHolderIDTo]' AND '$aBeetween[tCmdCardHolderIDFrom]')";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMCMDGetPageAll($tSearchList, $nLngID, $aBeetween);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow / $paData['nRow']);
                $aResult = array(
                    'raItems' => $aList,
                    'rnAllRow' => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage' => $nPageAll,
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            } else {
                // No Data
                $aResult = array(
                    'rnAllRow' => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage" => 0,
                    'rtCode' => '800',
                    'rtDesc' => 'data not found',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Get Data Card By Card Code
    //Parameters : function parameters
    //Creator :  19/11/2018 Wasin
    //Return : array Data Card Beetween Condition
    //Return Type : Array
    public function FSaMCMDGetDataCardById($ptCrdCode)
    {
        try {
            $nLngID = $this->session->userdata('tLangEdit');
            $tSQL = "SELECT 
                        CRD.FTCrdCode       AS rtCrdCode,
                        CRD.FCCrdValue      AS rtCrdValue,
                        CRD.FTCtyCode       AS rtCtyCode,
                        CRD.FTCrdHolderID   AS rtCrdHolderID,
                        CRD.FTDptCode       AS rtDptCode,
                        CRD_L.FTCrdName     AS rtCrdName
                     FROM TFNMCard CRD WITH (NOLOCK)
                     LEFT JOIN TFNMCard_L CRD_L WITH (NOLOCK) ON CRD.FTCrdCode = CRD_L.FTCrdCode AND CRD_L.FNLngID = $nLngID
                     WHERE CRD.FTCrdCode = '$ptCrdCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Get Vat Code Company
    //Parameters : function parameters
    //Creator :  19/11/2018 Wasin
    //Return : array Data Card Beetween Condition
    //Return Type : Array
    public function FSaMCMDGetVatCodeCompany()
    {
        try {
            $tSQL = "SELECT CMP.FTVatCode AS rtVatCode FROM TCNMComp CMP ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->first_row('array');
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : All Data Card For Condition Export
    //Parameters : function parameters
    //Creator :  18/10/2018 Wasin
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMCMDGetPageAll($ptSearchList, $pnLngID, $paBeetween)
    {
        try {
            $tSQL = "SELECT COUNT (CRD.FTCrdCode) AS counts
                     FROM TFNMCard CRD WITH (NOLOCK)
                     LEFT JOIN TFNMCard_L CRD_L WITH (NOLOCK) ON CRD.FTCrdCode = CRD_L.FTCrdCode AND CRD_L.FNLngID = $pnLngID
                     LEFT JOIN TFNMCardType_L CTY_L WITH (NOLOCK) ON CRD.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $pnLngID
                     WHERE 1=1 ";

            if (isset($ptSearchList) && !empty($ptSearchList)) {
                $tSQL .= " AND (CRD.FTCrdCode   LIKE '%$ptSearchList%'";
                $tSQL .= " OR CRD_L.FTCrdName   LIKE '%$ptSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName   LIKE '%$ptSearchList%')";
            }

            if (!empty($paBeetween['tCmdCardTypeForm']) && !empty($paBeetween['tCmdCardTypeTo'])) {
                $tSQL .= " AND (CRD.FTCtyCode BETWEEN '$paBeetween[tCmdCardTypeForm]' AND '$paBeetween[tCmdCardTypeTo]'";
                $tSQL .= " OR CRD.FTCtyCode BETWEEN '$paBeetween[tCmdCardTypeTo]' AND '$paBeetween[tCmdCardTypeForm]')";
            }

            if (!empty($paBeetween['tCmdCardCodeFrom']) && !empty($paBeetween['tCmdCardCodeTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$paBeetween[tCmdCardCodeFrom]' AND '$paBeetween[tCmdCardCodeTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$paBeetween[tCmdCardCodeTo]' AND '$paBeetween[tCmdCardCodeFrom]')";
            }

            if (!empty($paBeetween['tCmdCardNameFrom']) && !empty($paBeetween['tCmdCardNameTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$paBeetween[tCmdCardNameFrom]' AND '$paBeetween[tCmdCardNameTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$paBeetween[tCmdCardNameTo]' AND '$paBeetween[tCmdCardNameFrom]')";
            }

            if (!empty($paBeetween['tCmdCardHolderIDFrom']) && !empty($paBeetween['tCmdCardHolderIDTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$paBeetween[tCmdCardHolderIDFrom]' AND '$paBeetween[tCmdCardHolderIDTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$paBeetween[tCmdCardHolderIDTo]' AND '$paBeetween[tCmdCardHolderIDFrom]')";
            }

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Query Data Export Process
    //Parameters : function parameters
    //Creator :  24/10/2018 Wasin
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMCMDExpProcessData($paDataCons)
    {
        try {
            $nLngID = $paDataCons['FNLngID'];
            $aBeetween  = $paDataCons['aExportCons'];

            $tSQL = " 
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY rtCrdCode ASC) AS rtRowID,* 
                FROM(
                    SELECT DISTINCT
                        CRD.FTCrdCode AS rtCrdCode,
                        CRD_L.FTCrdName AS rtCrdName,
                        CRD.FTCrdHolderID AS rtCrdHolderID,
                        CRD.FDCrdStartDate AS rtCrdStartDate,
                        CRD.FDCrdExpireDate AS rtCrdExpireDate,
                        CRD.FTCtyCode AS rtCrdCtyCode,
                        CTY_L.FTCtyName AS rtCrdCtyName,
                        CRDT.FTCtyStaShift AS rtCrdStaType

                    FROM TFNMCard CRD WITH (NOLOCK)
                    LEFT JOIN TFNMCardType CRDT WITH(NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
                    LEFT JOIN TFNMCard_L CRD_L WITH (NOLOCK) ON CRD.FTCrdCode = CRD_L.FTCrdCode AND CRD_L.FNLngID = $nLngID
                    LEFT JOIN TFNMCardType_L CTY_L WITH (NOLOCK) ON CRD.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $nLngID
                    WHERE 1=1 
            ";

            if (!empty($aBeetween['tCmdCardTypeForm']) && !empty($aBeetween['tCmdCardTypeTo'])) {
                $tSQL .= " AND (CRD.FTCtyCode BETWEEN '$aBeetween[tCmdCardTypeForm]' AND '$aBeetween[tCmdCardTypeTo]'";
                $tSQL .= " OR CRD.FTCtyCode BETWEEN '$aBeetween[tCmdCardTypeTo]' AND '$aBeetween[tCmdCardTypeForm]')";
            }

            if (!empty($aBeetween['tCmdCardCodeFrom']) && !empty($aBeetween['tCmdCardCodeTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardCodeFrom]' AND '$aBeetween[tCmdCardCodeTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardCodeTo]' AND '$aBeetween[tCmdCardCodeFrom]')";
            }

            if (!empty($aBeetween['tCmdCardNameFrom']) && !empty($aBeetween['tCmdCardNameTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardNameFrom]' AND '$aBeetween[tCmdCardNameTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardNameTo]' AND '$aBeetween[tCmdCardNameFrom]')";
            }

            if (!empty($aBeetween['tCmdCardHolderIDFrom']) && !empty($aBeetween['tCmdCardHolderIDTo'])) {
                $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardHolderIDFrom]' AND '$aBeetween[tCmdCardHolderIDTo]'";
                $tSQL .= " OR CRD.FTCrdCode BETWEEN '$aBeetween[tCmdCardHolderIDTo]' AND '$aBeetween[tCmdCardHolderIDFrom]')";
            }

            $tSQL .= ") BASE";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aDataList  = $oQuery->result_array();
                $aResult = array(
                    'raItems' => $aDataList,
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Check Card ID In Void DT
    //Parameters : function parameters
    //Creator : 20/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMCMDChkCardCodeInVoidDT($ptNewCrdCode)
    {
        try {
            $tSQL = "SELECT COUNT(CRV_DT.FTCvdNewCode) AS counts
                     FROM TFNTCrdVoidDT CRV_DT
                     WHERE CRV_DT.FTCvdStaPrc != 1 AND CRV_DT.FTCvdNewCode = '$ptNewCrdCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return FALSE;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Check Card ID Duplicate
    //Parameters : function parameters
    //Creator : 12/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMCMDChkCardCodeInDB($ptCrdCode)
    {
        try {
            $tSQL = "SELECT COUNT(CRD.FTCrdCode) AS counts
                     FROM TFNMCard CRD WITH (NOLOCK)
                     WHERE CRD.FTCrdCode = '$ptCrdCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return FALSE;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Check Depart Code In DB
    //Parameters : function parameters
    //Creator : 20/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMCMDChkCardDepartInDB($ptDptCode)
    {
        try {
            $tSQL = "SELECT COUNT(DPT.FTDptCode) AS counts
                     FROM TCNMUsrDepart DPT 
                     WHERE DPT.FTDptCode = '$ptDptCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return FALSE;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Check Card ID Duplicate
    //Parameters : function parameters
    //Creator : 12/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMCMDChkCardTypeInDB($ptCtyCode)
    {
        try {
            $tSQL = "SELECT COUNT(CTY.FTCtyCode) AS counts
                     FROM TFNMCardType CTY WITH (NOLOCK)
                     WHERE CTY.FTCtyCode = '$ptCtyCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return FALSE;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : ฟังก์ชั่น Insert Doc Import HD
    //Parameters : $ptTable : ตารางที่จะ Insert / $paData : ข้อมูลทีต้องการ Insert
    //Creator : 19/11/2018 Wasin
    //Return : Array Status Insert HD
    //Return Type : Array
    public function FSaMCMDInsertDocHD($ptTable, $paData)
    {
        try {
            $this->db->insert($ptTable, $paData);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Import HD Success.',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Import HD.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : ฟังก์ชั่น Insert Doc Import DT
    //Parameters : $ptTable : ตารางที่จะ Insert / $paData : ข้อมูลทีต้องการ Insert
    //Creator : 19/11/2018 Wasin
    //Return : Array Status Insert DT
    //Return Type : Array
    public function FSaMCMDInsertDocDT($ptTable, $paData)
    {
        try {
            $this->db->insert_batch($ptTable, $paData);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Import DT Success.',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Import DT.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality: ฟังก์ชั่น Find CardType Name In DB
     * Parameters: 
     * Creator: 07/12/2018 Wasin(Yoshi)
     * Return : Array Data Card Type
     * Return Type : Array
     */
    public function FSaMCMDFindCardTypeNameInDB($ptDptName)
    {
        try {
            $tSQL = "SELECT
                        DPT.FTDptCode       AS rtDptCode,
                        DPT_L.FTDptName     AS rtDptName
                     FROM TCNMUsrDepart DPT
                     LEFT JOIN TCNMUsrDepart_L DPT_L ON DPT.FTDptCode = DPT_L.FTDptCode
                     WHERE DPT_L.FTDptName = '$ptDptName'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return FALSE;
            }
        } catch (Exception $Error) {
            echo 'Error Fnc.FSaMCMDFindCardTypeNameInDB =>' . $Error;
        }
    }

    /**
     * Functionality: ฟังก์ชั่น Find Depart Name In DB
     * Parameters: 
     * Creator: 10/12/2018 Wasin(Yoshi)
     * Return : Array Data Card Type
     * Return Type : Array
     */
    public function FSaMCheckDataDepartInDB($ptDptName)
    {
        try {
            $tSQL = "SELECT 
                        DPT.FTDptCode       AS rtDptCode,
                        DPT_L.FTDptName     AS rtDptName
                     FROM TCNMUsrDepart DPT
                     LEFT JOIN TCNMUsrDepart_L DPT_L ON DPT.FTDptCode = DPT_L.FTDptCode
                     WHERE DPT_L.FTDptName = '$ptDptName'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return FALSE;
            }
        } catch (Exception $Error) {
            echo 'Error FN.FSaMCheckDataDepartInDB => ' . $Error;
        }
    }
}
