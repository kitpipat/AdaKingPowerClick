<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mArea extends CI_Model {

    //Functionality : list Area
    //Parameters : function parameters
    //Creator :  22/11/2018 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSaMAREList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtAreCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        ARE.FTAreCode   AS rtAreCode,
                                        ARE_L.FTAreName AS rtAreName
                                    FROM [TCNMArea] Are
                                    LEFT JOIN [TCNMArea_L]  ARE_L ON ARE.FTAreCode = ARE_L.FTAreCode AND ARE_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (ARE.FTAreCode LIKE '%$tSearchList%'";
                $tSQL .= " OR ARE_L.FTAreName  LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMAREGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of Area
    //Parameters : function parameters
    //Creator :  22/11/2018 Witsarut 
    //Return : object Count All Area
    //Return Type : Object
    public function FSoMAREGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (ARE.FTAreCode) AS counts
                     FROM [TCNMArea] ARE
                     LEFT JOIN [TCNMArea_L]  ARE_L ON Are.FTAreCode = ARE_L.FTAreCode AND ARE_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (ARE.FTAreCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR ARE_L.FTAreName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Area By ID
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSaMAREGetDataByID($paData){
        try{
            $tAreCode   = $paData['FTAreCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                Are.FTAreCode   AS rtAreCode,
                                Are_L.FTAreName AS rtAreName
                            FROM TCNMArea ARE
                            LEFT JOIN TCNMArea_L ARE_L ON ARE.FTAreCode = ARE_L.FTAreCode AND ARE_L.FNLngID = $nLngID 
                            WHERE 1=1 AND ARE.FTAreCode = '$tAreCode' ";
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

    //Functionality : Checkduplicate Area
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSnMARECheckDuplicate($ptAreCode){
        $tSQL = "SELECT COUNT(ARE.FTAreCode) AS counts
                 FROM TCNMArea ARE 
                 WHERE ARE.FTAreCode = '$ptAreCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Area (TCNMArea)
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMAREAddUpdateMaster($paDataArea){
        try{
            // Update TCNMArea
            $this->db->where('FTAreCode', $paDataArea['FTAreCode']);
            $this->db->update('TCNMArea',array(
                'FDLastUpdOn' => $paDataArea['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataArea['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            }else{
                //Add TCNMArea
                $this->db->insert('TCNMArea', array(
                    'FTAreCode' => $paDataArea['FTAreCode'],
                    'FDCreateOn' => $paDataArea['FDCreateOn'],
                    'FTCreateBy'  => $paDataArea['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Area Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Area.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Area (TCNMArea_L)
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMAREAddUpdateLang($paDataArea){
        try{
            //Update Pdt Brand Lang
            $this->db->where('FNLngID', $paDataArea['FNLngID']);
            $this->db->where('FTAreCode', $paDataArea['FTAreCode']);
            $this->db->update('TCNMArea_L',array(
                'FTAreName' => $paDataArea['FTAreName'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Area Lang Success.',
                );
            }else{
                //Add Pdt Brand Lang
                $this->db->insert('TCNMArea_L', array(
                    'FTAreCode' => $paDataArea['FTAreCode'],
                    'FNLngID'   => $paDataArea['FNLngID'],
                    'FTAreName' => $paDataArea['FTAreName']
                   
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Area Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Area Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Area
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : Status Delete
    //Return Type : array
    public function FSaMAREDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTAreCode', $paData['FTAreCode']);
            $this->db->delete('TCNMArea');

            $this->db->where_in('FTAreCode', $paData['FTAreCode']);
            $this->db->delete('TCNMArea_L');

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

    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMArea";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }  



}