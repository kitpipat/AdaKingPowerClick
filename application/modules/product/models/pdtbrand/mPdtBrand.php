<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPdtBrand extends CI_Model
{

    //Functionality : list Product Brand
    //Parameters : function parameters
    //Creator :  20/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMBNList($paData)
    {
        try {
            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode = $paData['tSesAgnCode'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPbnCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        PBN.FTPbnCode   AS rtPbnCode,
                                        PBN_L.FTPbnName AS rtPbnName,
                                        PBN.FDCreateOn
                                    FROM [TCNMPdtBrand] PBN WITH(NOLOCK)
                                    LEFT JOIN [TCNMPdtBrand_L] PBN_L WITH(NOLOCK) ON PBN.FTPbnCode = PBN_L.FTPbnCode AND PBN_L.FNLngID = $nLngID
                                    WHERE 1=1 ";

            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND (PBN.FTPbnCode COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($tSearchList)."%'";
                $tSQL .= " OR PBN_L.FTPbnName  COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($tSearchList)."%')";
            }

            if ($tSesAgnCode != '') {
                $tSQL .= " AND PBN.FTAgnCode = '$tSesAgnCode' ";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            // echo $this->db->last_query(); exit;
            if ($oQuery->num_rows() > 0) {
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMBNGetPageAll($tSearchList, $nLngID, $tSesAgnCode);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
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
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : All Page Of Product Brand
    //Parameters : function parameters
    //Creator :  20/09/2018 Witsarut (Bell)
    //Return : object Count All Product Brand
    //Return Type : Object
    public function FSoMBNGetPageAll($ptSearchList, $ptLngID, $tSesAgnCode)
    {
        try {
            $tSQL = "SELECT COUNT (PBN.FTPbnCode) AS counts
                     FROM [TCNMPdtBrand] PBN WITH(NOLOCK)
                     LEFT JOIN [TCNMPdtBrand_L] PBN_L WITH(NOLOCK) ON PBN.FTPbnCode = PBN_L.FTPbnCode AND PBN_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if (isset($ptSearchList) && !empty($ptSearchList)) {
                $tSQL .= " AND (PBN.FTPbnCode COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($ptSearchList)."%'";
                $tSQL .= " OR PBN_L.FTPbnName  COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($ptSearchList)."%')";
            }

            if ($tSesAgnCode != '') {
                $tSQL .= " AND PBN.FTAgnCode = '$tSesAgnCode' ";
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

    //Functionality : Get Data Product Brand By ID
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMBNGetDataByID($paData)
    {
        try {
            $tPbnCode   = $paData['FTPbnCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                PBN.FTPbnCode   AS rtPbnCode,
                                PBN_L.FTPbnName AS rtPbnName,
                                PBN_L.FTPbnRmk  AS rtPbnRmk,
                                PBN.FTAgnCode   AS rtAgnCode,
                                AGNL.FTAgnName  AS rtAgnName
                            FROM TCNMPdtBrand PBN
                            LEFT JOIN TCNMPdtBrand_L PBN_L ON PBN.FTPbnCode = PBN_L.FTPbnCode AND PBN_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMAgency_L AGNL ON  PBN.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                            WHERE 1=1 AND PBN.FTPbnCode = '$tPbnCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
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

    //Functionality : Checkduplicate Product Brand
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMBNCheckDuplicate($ptPbnCode)
    {
        $tSQL = "SELECT COUNT(PBN.FTPbnCode) AS counts
                 FROM TCNMPdtBrand PBN 
                 WHERE PBN.FTPbnCode = '$ptPbnCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return FALSE;
        }
    }

    //Functionality : Update Product Product Brand (TCNMPdtBrand)
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMBNAddUpdateMaster($paDataPdtBrand)
    {
        try {
            // Update TCNMPdtBrand
            $this->db->where('FTPbnCode', $paDataPdtBrand['FTPbnCode']);
            $this->db->update('TCNMPdtBrand', array(
                'FDLastUpdOn' => $paDataPdtBrand['FDLastUpdOn'],
                'FTLastUpdBy'  => $paDataPdtBrand['FTLastUpdBy'],
                'FTAgnCode'     => $paDataPdtBrand['FTAgnCode'],
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            } else {
                //Add TCNMPdtBrand
                $this->db->insert('TCNMPdtBrand', array(
                    'FTPbnCode'     => $paDataPdtBrand['FTPbnCode'],
                    'FDCreateOn'    => $paDataPdtBrand['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtBrand['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtBrand['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataPdtBrand['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataPdtBrand['FTAgnCode'],
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Promotion Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Promotion.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Update Product Brand (TCNMPdtBrand_L)
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMBNAddUpdateLang($paDataPdtBrand)
    {
        try {
            //Update Pdt Brand Lang
            $this->db->where('FNLngID', $paDataPdtBrand['FNLngID']);
            $this->db->where('FTPbnCode', $paDataPdtBrand['FTPbnCode']);
            $this->db->update('TCNMPdtBrand_L', array(
                'FTPbnName' => $paDataPdtBrand['FTPbnName'],
                'FTPbnRmk'  => $paDataPdtBrand['FTPbnRmk']
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Promotion Lang Success.',
                );
            } else {
                //Add Pdt Brand Lang
                $this->db->insert('TCNMPdtBrand_L', array(
                    'FTPbnCode' => $paDataPdtBrand['FTPbnCode'],
                    'FNLngID'   => $paDataPdtBrand['FNLngID'],
                    'FTPbnName' => $paDataPdtBrand['FTPbnName'],
                    'FTPbnRmk'  => $paDataPdtBrand['FTPbnRmk']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Promotion Lang Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Promotion Lang.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Delete Product Brand
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMBNDelAll($paData)
    {
        try {
            $this->db->trans_begin();

            $this->db->where_in('FTPbnCode', $paData['FTPbnCode']);
            $this->db->delete('TCNMPdtBrand');

            $this->db->where_in('FTPbnCode', $paData['FTPbnCode']);
            $this->db->delete('TCNMPdtBrand_L');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Delete Unsuccess.',
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMPGPGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtBrand";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }
}
