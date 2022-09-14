<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lableprinter_Model extends CI_Model
{

    /**
     * Functionality : Search Lable Printer By ID
     * Parameters : $paData
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMLabPriSearchByID($paData)
    {
        $tAgnCode   = $paData['FTAgnCode'];
        $tLabPriCode   = $paData['FTLabPriCode'];
        $nLngID     = $paData['FNLngID'];


        $tSQL       = "SELECT
                            PrnLab.FTPlbCode   AS rtPrnLabCode,
                            PrnLabL.FTPblName  AS rtPrnLabName,
                            PrnLabL.FTPblRmk   AS rtPrnLabRmk,
                            PrnLab.FTPlbStaUse   AS rtPrnLabStaUse,
                            PrnLab.FTSppCode  AS rtPortPrnCode,
                            PortPrnL.FTSppName  AS rtPortPrnName,
                            LabFrtL.FTLblName  AS rtLabFrtName,
                            PrnLab.FTLblCode  AS rtLabFrtCode,
                            PrnLab.FTAgnCode,
                            AGN_L.FTAgnName
                       FROM [TCNMPrnLabel] PrnLab WITH(NOLOCK)
                       LEFT JOIN [TCNMPrnLabel_L]  PrnLabL WITH(NOLOCK) ON PrnLab.FTPlbCode = PrnLabL.FTPlbCode AND PrnLab.FTAgnCode = PrnLabL.FTAgnCode AND PrnLabL.FNLngID = $nLngID
                        LEFT JOIN [TSysPortPrn_L] PortPrnL WITH(NOLOCK) ON PortPrnL.FTSppCode = PrnLab.FTSppCode AND PortPrnL.FNLngID = $nLngID
                        LEFT JOIN [TCNSLabelFmt_L] LabFrtL WITH(NOLOCK) ON LabFrtL.FTLblCode = PrnLab.FTLblCode AND LabFrtL.FNLngID = $nLngID
                        LEFT JOIN TCNMAgency_L AGN_L WITH(NOLOCK) ON PrnLab.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                       WHERE 1=1 ";

        if ($tLabPriCode != "") {
            $tSQL .= " AND PrnLab.FTPlbCode = '$tLabPriCode' ";
        }

        $tSQL .= " AND PrnLab.FTAgnCode = '$tAgnCode' ";
 
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : List Lable Printer
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMLabPriList($paData)
    {
        // return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];

        $tSesAgnCode = $paData['tSesAgnCode'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPrnLabCode DESC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                            PrnLab.FTPlbCode   AS rtPrnLabCode,
                            PrnLabL.FTPblName  AS rtPrnLabName,
                            PrnLab.FTPlbStaUse  AS rtPrnLabSta,
                            PortPrnL.FTSppName  AS rtPortPrnName,
                            LabFrtL.FTLblName  AS rtLabFrtName,
                            PrnLab.FDCreateOn,
                            PrnLab.FTAgnCode,
                            AGN_L.FTAgnName
                        FROM [TCNMPrnLabel] PrnLab WITH(NOLOCK)
                        LEFT JOIN [TCNMPrnLabel_L] PrnLabL WITH(NOLOCK) ON PrnLabL.FTPlbCode = PrnLab.FTPlbCode AND PrnLab.FTAgnCode = PrnLabL.FTAgnCode AND PrnLabL.FNLngID = $nLngID
                        LEFT JOIN [TSysPortPrn_L] PortPrnL WITH(NOLOCK) ON PortPrnL.FTSppCode = PrnLab.FTSppCode AND PortPrnL.FNLngID = $nLngID
                        LEFT JOIN [TCNSLabelFmt_L] LabFrtL WITH(NOLOCK) ON LabFrtL.FTLblCode = PrnLab.FTLblCode AND LabFrtL.FNLngID = $nLngID
                        LEFT JOIN TCNMAgency_L AGN_L WITH(NOLOCK) ON PrnLab.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                        WHERE 1=1";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND PrnLab.FTPlbCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR PrnLabL.FTPblName COLLATE THAI_BIN LIKE '%$tSearchList%'";
        }

        if( $tSesAgnCode != "" ){
            $tSQL .= " AND PrnLab.FTAgnCode = '".$tSesAgnCode."' ";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";


        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMLabPriGetPageAll(/*$tWhereCode,*/$tSearchList, $nLngID, $tSesAgnCode);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
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
     * Functionality : All Page Of Lable Printer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMLabPriGetPageAll($ptSearchList, $ptLngID, $tSesAgnCode)
    {
        $tSQL = "SELECT COUNT (PrnLab.FTPlbCode) AS counts
                FROM [TCNMPrnLabel] PrnLab WITH(NOLOCK)
                LEFT JOIN [TCNMPrnLabel_L] PrnLabL ON PrnLabL.FTPlbCode = PrnLab.FTPlbCode AND PrnLab.FTAgnCode = PrnLabL.FTAgnCode AND PrnLabL.FNLngID = $ptLngID
                WHERE 1=1 ";

        if ($ptSearchList != '') {
            $tSQL .= " AND (PrnLab.FTPlbCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR PrnLabL.FTPblName LIKE '%$ptSearchList%')";
        }

        if( $tSesAgnCode != "" ){
            $tSQL .= " AND PrnLab.FTAgnCode = '".$tSesAgnCode."' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }


    /**
     * Functionality : Checkduplicate
     * Parameters : $ptLabPriCode
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMLabPriCheckDuplicate($paData)
    {
        $tLabPriCode = $paData['FTLabPriCode'];
        $tAgnCode = $paData['FTAgnCode'];
        

        $tSQL = "   SELECT COUNT(FTPlbCode) AS counts
                    FROM TCNMPrnLabel WITH(NOLOCK)
                    WHERE FTPlbCode = '$tLabPriCode' 
                      AND FTAgnCode = '$tAgnCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Update Lable Printer
     * Parameters : $paData is data for update
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMLabPriAddUpdateMaster($paData)
    {

        try {
            // Update Master
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FTPlbStaUse', $paData['FTLabPriStaUse']);
            $this->db->set('FTLblCode', $paData['FTLblCode']);
            // $this->db->set('FTSppCode', $paData['FTSppCode']);
            $this->db->where('FTPlbCode', $paData['FTLabPriCode']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->update('TCNMPrnLabel');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TCNMPrnLabel', array(
                    'FTAgnCode'     => $paData['FTAgnCode'],
                    'FTPlbCode'     => $paData['FTLabPriCode'],
                    'FTLblCode'     => $paData['FTLblCode'],
                    'FTSppCode'     => '', //$paData['FTSppCode']
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTPlbStaUse'   => $paData['FTLabPriStaUse']

                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Update Lang Lable Printer
     * Parameters : $paData is data for update
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMLabPriAddUpdateLang($paData)
    {
        try {
            // Update Lang
            $this->db->set('FTPblName', $paData['FTLabPriName']);
            $this->db->set('FTPblRmk', $paData['FTLabPriRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTPlbCode', $paData['FTLabPriCode']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->update('TCNMPrnLabel_L');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            } else { // Add Lang
                $this->db->insert('TCNMPrnLabel_L', array(
                    'FTAgnCode' => $paData['FTAgnCode'],
                    'FTPlbCode' => $paData['FTLabPriCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTPblName' => $paData['FTLabPriName'],
                    'FTPblRmk'  => $paData['FTLabPriRmk']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Delete Lable Printer
     * Parameters : $paData
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMLabPriDel($paData)
    {
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where('FTPlbCode', $paData['FTLabPriCode']);
        $this->db->delete('TCNMPrnLabel');

        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where('FTPlbCode', $paData['FTLabPriCode']);
        $this->db->delete('TCNMPrnLabel_L');

        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }



    /**
     * Functionality : -
     * Parameters : $paData
     * Creator : 27/12/2021 Worakorn
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMLabPriGetDataExport($tAgnCode,$tPlbCode,$nLngID)
    {
        try {
            $tSQL = "   SELECT * FROM TCNMPrnLabel PrnLab WITH(NOLOCK)
                        WHERE PrnLab.FTPlbCode IN ('$tPlbCode') 
                          AND PrnLab.FTAgnCode IN ('$tAgnCode')  ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : -
     * Parameters : $paData
     * Creator : 27/12/2021 Worakorn
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMLabPriGetDataExportLabelFmt($tAgnCode,$tPlbCode,$nLngID)
    {
        try {
            $tSQL = "   SELECT
                            LabFrt.FTLblCode,
                            LabFrt.FTLblRptNormal,
                            LabFrt.FTLblRptPmt,
                            LabFrt.FTLblStaUse,
                            LabFrt.FDLastUpdOn,
                            LabFrt.FTLastUpdBy,
                            LabFrt.FDCreateOn,
                            LabFrt.FTCreateBy
                        FROM TCNMPrnLabel PrnLab WITH(NOLOCK)
                        INNER JOIN TCNSLabelFmt LabFrt WITH(NOLOCK) ON LabFrt.FTLblCode = PrnLab.FTLblCode
                        WHERE PrnLab.FTPlbCode IN ('$tPlbCode') 
                          AND PrnLab.FTAgnCode IN ('$tAgnCode')  ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    /**
     * Functionality : -
     * Parameters : $paData
     * Creator : 27/12/2021 Worakorn
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMLabPriGetDataExportLabelFmtL($tAgnCode,$tPlbCode,$nLngID)
    {
        try {    
            $tSQL = "   SELECT
                            LabFrtL.FTLblCode,
                            LabFrtL.FNLngID,
                            LabFrtL.FTLblName,
                            LabFrtL.FTLblRmk
                        FROM TCNMPrnLabel PrnLab WITH(NOLOCK)
                        LEFT JOIN TCNSLabelFmt_L LabFrtL WITH(NOLOCK) ON LabFrtL.FTLblCode = PrnLab.FTLblCode AND LabFrtL.FNLngID = $nLngID
                        WHERE PrnLab.FTPlbCode IN ('$tPlbCode') 
                          AND PrnLab.FTAgnCode IN ('$tAgnCode') ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : -
     * Parameters : $paData
     * Creator : 27/12/2021 Worakorn
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMLabPriGetDataExportPrnLabel($tAgnCode,$tPlbCode,$nLngID)
    {
        try {
            $tSQL = "   SELECT
                            PrnLab.FTAgnCode,
                            PrnLab.FTPlbCode,
                            PrnLab.FTLblCode,
                            PrnLab.FTSppCode,
                            PrnLab.FTPlbStaUse,
                            PrnLab.FDLastUpdOn,
                            PrnLab.FTLastUpdBy,
                            PrnLab.FDCreateOn,
                            PrnLab.FTCreateBy
                        FROM TCNMPrnLabel PrnLab WITH(NOLOCK)
                        WHERE PrnLab.FTPlbCode IN ('$tPlbCode') 
                          AND PrnLab.FTAgnCode IN ('$tAgnCode') ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    /**
     * Functionality : -
     * Parameters : $paData
     * Creator : 27/12/2021 Worakorn
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMLabPriGetDataExportPrnLabelL($tAgnCode,$tPlbCode,$nLngID)
    {
        try {
            $tSQL = "   SELECT
                            PrnLabL.FTAgnCode,
                            PrnLabL.FTPlbCode,
                            PrnLabL.FNLngID,
                            PrnLabL.FTPblName,
                            PrnLabL.FTPblRmk
                        FROM TCNMPrnLabel PrnLab WITH(NOLOCK)
                        LEFT JOIN TCNMPrnLabel_L PrnLabL WITH(NOLOCK) ON PrnLab.FTPlbCode = PrnLabL.FTPlbCode AND PrnLab.FTAgnCode = PrnLabL.FTAgnCode AND PrnLabL.FNLngID = $nLngID
                        WHERE PrnLab.FTPlbCode IN ('$tPlbCode') 
                          AND PrnLab.FTAgnCode IN ('$tAgnCode') ";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                // $oDetail = $oQuery->row_array();
                $oDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'       => @$oDetail,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                //Not Found
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    /**
     * Functionality : -
     * Parameters : $paData
     * Creator : 27/12/2021 Worakorn
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMLabPriGetDataUrlObjectExport()
    {
        try {
            $tSQL = " SELECT * FROM TCNTUrlObject WITH(NOLOCK) ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }
    /**
     * Functionality : -
     * Parameters : $paData
     * Creator : 27/12/2021 Worakorn
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMLabPriGetDataUrlObjectLoginExport()
    {
        try {
            $tSQL = " SELECT * FROM TCNTUrlObjectLogin WITH(NOLOCK) ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }
}
