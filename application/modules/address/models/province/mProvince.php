<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mProvince extends CI_Model
{

    //Functionality : Search Province By ID
    //Parameters : function parameters
    //Creator : 14/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMPVNSearchByID($ptAPIReq, $ptMethodReq, $paData)
    {
        $tPvnCode   = $paData['FTPvnCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    PVN.FTPvnCode   AS rtPvnCode,
                    PVNL.FTPvnName  AS rtPvnName,
                    ZNEL.FTZneCode  AS rtZneCode,
                    ZNEL.FTZneName  AS rtZneName
                 FROM [TCNMProvince] PVN
                 LEFT JOIN [TCNMProvince_L] PVNL ON PVN.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                 LEFT JOIN [TCNMZone_L] ZNEL ON ZNEL.FTZneCode = PVN.FTZneCode AND ZNEL.FNLngID = $nLngID
                 WHERE 1=1 ";
        if ($tPvnCode != "") {
            $tSQL .= "AND PVN.FTPvnCode = '$tPvnCode'";
        }
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

    //Functionality : list Province
    //Parameters : function parameters
    //Creator :  14/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMPVNList($ptAPIReq, $ptMethodReq, $paData)
    {
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY rtPvnCode ASC) AS rtRowID,* FROM
                                (SELECT DISTINCT
                                    PVN.FTPvnCode           AS rtPvnCode,
                                    PVNL.FTPvnName          AS rtPvnName,
                                    ZNEL.FTZneCode          AS rtZneCode,
                                    ZNEL.FTZneName          AS rtZneName,
                                    ZNEL.FTZneChainName     AS rtZneChainName
                                FROM [TCNMProvince] PVN
                                LEFT JOIN [TCNMProvince_L] PVNL ON PVN.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                                LEFT JOIN [TCNMZone_L] ZNEL ON PVN.FTZneCode = ZNEL.FTZneCode AND ZNEL.FNLngID = $nLngID
                                WHERE 1=1 ";

        @$tWhereCode = $paData['tWhereCode'];
        if (@$tWhereCode != '') {
            $tSQL .= " AND (PVN.FTZneCode = '$tWhereCode')";
        }

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND (PVN.FTPvnCode LIKE '%$tSearchList%'";
            $tSQL .= " OR PVNL.FTPvnName LIKE '%$tSearchList%')";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMPVNGetPageAll($tWhereCode, $tSearchList, $nLngID);
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

    //Functionality : All Page Of Province
    //Parameters : function parameters
    //Creator :  14/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMPVNGetPageAll($ptWhereCode, $ptSearchList, $ptLngID)
    {
        $tSQL = "SELECT COUNT (PVN.FTPvnCode) AS counts
                 FROM [TCNMProvince] PVN
                 LEFT JOIN [TCNMProvince_L] PVNL ON PVN.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        if (@$ptWhereCode != '') {
            $tSQL .= " AND (PVN.FTZneCode = '$ptWhereCode')";
        }

        if ($ptSearchList != '') {
            $tSQL .= " AND (PVN.FTPvnCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR PVNL.FTPvnName LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMPVNCheckDuplicate($ptPvnCode)
    {
        $tSQL = "SELECT COUNT(FTPvnCode)AS counts
                 FROM TCNMProvince
                 WHERE FTPvnCode = '$ptPvnCode' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Last Modified : 11/06/2018 wasin
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMPVNAddUpdateMaster($paData)
    {
        try {
            //Update Master
            $this->db->set('FTZneCode', $paData['FTZneCode']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);

            $this->db->where('FTPvnCode', $paData['FTPvnCode']);
            $this->db->update('TCNMProvince');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                //Add Master
                $this->db->insert('TCNMProvince', array(
                    'FTPvnCode'     => $paData['FTPvnCode'],
                    'FTZneCode'     => $paData['FTZneCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy']
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

    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  15/05/2018 wasin
    //Last Modified : 11/06/2018 wasin
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMPVNAddUpdateLang($paData)
    {
        try {
            //Update Lang
            $this->db->set('FTPvnName', $paData['FTPvnName']);
            $this->db->where('FTPvnCode', $paData['FTPvnCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->update('TCNMProvince_L');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            } else {
                $this->db->insert('TCNMProvince_L', array(
                    'FTPvnCode' => $paData['FTPvnCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTPvnName' => $paData['FTPvnName']
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

    //Functionality : Delete Province
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Return : response
    //Return Type : array
    public function FSnMPVNDel($ptAPIReq, $ptMethodReq, $paData)
    {
        $this->db->where_in('FTPvnCode', $paData['FTPvnCode']);
        $this->db->delete('TCNMProvince');

        $this->db->where_in('FTPvnCode', $paData['FTPvnCode']);
        $this->db->delete('TCNMProvince_L');
        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }



    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMProvince";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }
}
