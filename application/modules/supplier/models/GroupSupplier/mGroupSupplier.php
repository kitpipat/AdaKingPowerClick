<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mGroupSupplier extends CI_Model {

    //Functionality : list GroupSupplier
    //Parameters : function parameters
    //Creator :  17/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSaMSGPList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtSgpCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        SGP.FTSgpCode   AS rtSgpCode,
                                        SGP_L.FTSgpName AS rtSgpName,
                                        SGP.FDCreateOn
                                    FROM [TCNMSplGrp] SGP
                                    LEFT JOIN [TCNMSplGrp_L]  SGP_L ON SGP.FTSgpCode = SGP_L.FTSgpCode AND SGP_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                // $tSQL .= " AND (SGP.FTSgpCode LIKE '%$tSearchList%'";
                // $tSQL .= " OR SGP_L.FTSgpName  LIKE '%$tSearchList%')";
                $tSQL .= " AND SGP.FTSgpCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR SGP_L.FTSgpName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMSGPGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of GroupSupplier
    //Parameters : function parameters
    //Creator :  17/10/2018 witsarut
    //Return : object Count All GroupSupplier
    //Return Type : Object
    public function FSoMSGPGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (SGP.FTSgpCode) AS counts
                     FROM [TCNMSplGrp] SGP
                     LEFT JOIN [TCNMSplGrp_L]  SGP_L ON SGP.FTSgpCode = SGP_L.FTSgpCode AND SGP_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (SGP.FTSgpCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR SGP_L.FTSgpName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data GroupSupplier By ID
    //Parameters : function parameters
    //Creator : 17/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSaMSGPGetDataByID($paData){
        try{
            $tSgpCode   = $paData['FTSgpCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                SGP.FTSgpCode   AS rtSgpCode,
                                SGP_L.FTSgpName AS rtSgpName,
                                SGP_L.FTSgpRmk  AS rtSgpRmk
                            FROM TCNMSplGrp SGP
                            LEFT JOIN TCNMSplGrp_L SGP_L ON SGP.FTSgpCode = SGP_L.FTSgpCode AND SGP_L.FNLngID = $nLngID 
                            WHERE 1=1 AND SGP.FTSgpCode = '$tSgpCode' ";
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

    //Functionality : Checkduplicate GroupSupplier 
    //Parameters : function parameters
    //Creator : 17/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSnMSGPCheckDuplicate($ptSgpCode){
        $tSQL = "SELECT COUNT(SGP.FTSgpCode) AS counts
                 FROM TCNMSplGrp SGP 
                 WHERE SGP.FTSgpCode = '$ptSgpCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update GroupSupplier (TCNMSplGrp)
    //Parameters : function parameters
    //Creator : 17/10/2018 witsarut
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMSGPAddUpdateMaster($paDataGroupSupplier){
        try{
            // Update TCNMSplGrp
            $this->db->where('FTSgpCode', $paDataGroupSupplier['FTSgpCode']);
            $this->db->update('TCNMSplGrp',array(
                'FDLastUpdOn'   => $paDataGroupSupplier['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataGroupSupplier['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update GroupSupplier Success',
                );
            }else{
                //Add TCNMSplGrp
                $this->db->insert('TCNMSplGrp', array(
                    'FTSgpCode'     => $paDataGroupSupplier['FTSgpCode'],
                    'FDCreateOn'    => $paDataGroupSupplier['FDCreateOn'],
                    'FTCreateBy'    => $paDataGroupSupplier['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataGroupSupplier['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataGroupSupplier['FTLastUpdBy'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add GroupSupplier Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit GroupSupplier.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update GroupSupplier (TCNMSplGrp_L)
    //Parameters : function parameters
    //Creator : 17/10/2018 witsarut
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMSGPAddUpdateLang($paDataGroupSupplier){
        try{
            //Update Pdt Type Lang
            $this->db->where('FNLngID', $paDataGroupSupplier['FNLngID']);
            $this->db->where('FTSgpCode', $paDataGroupSupplier['FTSgpCode']);
            $this->db->update('TCNMSplGrp_L',array(
                'FTSgpName' => $paDataGroupSupplier['FTSgpName'],
                'FTSgpRmk'  => $paDataGroupSupplier['FTSgpRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update GroupSupplier Success.',
                );
            }else{
                //Add Pdt Type Lang
                $this->db->insert('TCNMSplGrp_L', array(
                    'FTSgpCode' => $paDataGroupSupplier['FTSgpCode'],
                    'FNLngID'   => $paDataGroupSupplier['FNLngID'],
                    'FTSgpName' => $paDataGroupSupplier['FTSgpName'],
                    'FTSgpRmk'  => $paDataGroupSupplier['FTSgpRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add GroupSupplier Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit GroupSupplier.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete GroupSupplier
    //Parameters : function parameters
    //Creator : 17/10/2018 witsarut
    //Return : Status Delete
    //Return Type : array
    public function FSaMSGPDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTSgpCode', $paData['FTSgpCode']);
            $this->db->delete('TCNMSplGrp');

            $this->db->where_in('FTSgpCode', $paData['FTSgpCode']);
            $this->db->delete('TCNMSplGrp_L');

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

}