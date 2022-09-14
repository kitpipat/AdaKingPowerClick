<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCourierGrp extends CI_Model {

    //Functionality : list CourierGrp
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCpgList($paData){


        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtCgpCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        Cgp.FTCgpCode   AS rtCgpCode,
                                        Cgp_L.FTCgpName AS rtCgpName
                                    FROM [TCNMCourierGrp] Cgp
                                    LEFT JOIN [TCNMCourierGrp_L]  Cgp_L ON Cgp.FTCgpCode = Cgp_L.FTCgpCode AND Cgp_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (Cgp.FTCgpCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR Cgp_L.FTCgpName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMCpgGetPageAll($tSearchList,$nLngID);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow' => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"=> 0,
                    'rtCode' => '800',
                    'rtDesc' => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of CourierGrp
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut (Bell)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMCpgGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (Cgp.FTCgpCode) AS counts
                     FROM [TCNMCourierGrp] Cgp
                     LEFT JOIN [TCNMCourierGrp_L]  Cgp_L ON Cgp.FTCgpCode = Cgp_L.FTCgpCode AND Cgp_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (Cgp.FTCgpCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR Cgp_L.FTCgpName  LIKE '%$ptSearchList%')";
            }
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Data CourierGrp By ID
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCpgGetDataByID($paData){
        try{
            $tCgpCode   = $paData['FTCgpCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                Cgp.FTCgpCode   AS rtCgpCode,
                                Cgp_L.FTCgpName AS rtCgpName,
                                Cgp_L.FTCgpRmk  AS rtCgpRmk
                            FROM TCNMCourierGrp Cgp
                            LEFT JOIN TCNMCourierGrp_L Cgp_L ON Cgp.FTCgpCode = Cgp_L.FTCgpCode AND Cgp_L.FNLngID = $nLngID 
                            WHERE 1=1 AND Cgp.FTCgpCode = '$tCgpCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Checkduplicate CourierGrp
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMCpgCheckDuplicate($ptCgpCode){
        $tSQL = "SELECT COUNT(Cgp.FTCgpCode) AS counts
                 FROM TCNMCourierGrp Cgp 
                 WHERE Cgp.FTCgpCode = '$ptCgpCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product CourierGrp (TCNMCourierGrp)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCpgAddUpdateMaster($paDataCourierGrp){
        try{
            // Update TCNMCourierGrp
            $this->db->where('FTCgpCode', $paDataCourierGrp['FTCgpCode']);
            $this->db->update('TCNMCourierGrp',array(
                'FDLastUpdOn' => $paDataCourierGrp['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataCourierGrp['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CourierGrp Success',
                );
            }else{
                //Add TCNMCourierGrp
                $this->db->insert('TCNMCourierGrp', array(
                    'FTCgpCode'     => $paDataCourierGrp['FTCgpCode'],
                    'FDLastUpdOn'   => $paDataCourierGrp['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataCourierGrp['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataCourierGrp['FDCreateOn'],
                    'FTCreateBy'    => $paDataCourierGrp['FTCreateBy'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add CourierGrp Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit CourierGrp',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update CourierGrp (TCNMCourierGrp_L)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCpgAddUpdateLang($paDataCourierGrp){
        try{
            //Update Pdt Size Lang
            $this->db->where('FNLngID', $paDataCourierGrp['FNLngID']);
            $this->db->where('FTCgpCode', $paDataCourierGrp['FTCgpCode']);
            $this->db->update('TCNMCourierGrp_L',array(
                'FTCgpName' => $paDataCourierGrp['FTCgpName'],
                'FTCgpRmk'  => $paDataCourierGrp['FTCgpRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CourierGrp Lang Success.',
                );
            }else{
                //Add Pdt Size Lang
                $this->db->insert('TCNMCourierGrp_L', array(
                    'FTCgpCode' => $paDataCourierGrp['FTCgpCode'],
                    'FNLngID'   => $paDataCourierGrp['FNLngID'],
                    'FTCgpName' => $paDataCourierGrp['FTCgpName'],
                    'FTCgpRmk'  => $paDataCourierGrp['FTCgpRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add CourierGrp Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit CourierGrp Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete CourierGrp
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMCpgDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTCgpCode', $paData['FTCgpCode']);
            $this->db->delete('TCNMCourierGrp');

            $this->db->where_in('FTCgpCode', $paData['FTCgpCode']);
            $this->db->delete('TCNMCourierGrp_L');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Delete Unsuccess.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMPGPGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMCourierGrp";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}