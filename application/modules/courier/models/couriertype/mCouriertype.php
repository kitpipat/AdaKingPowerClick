<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCouriertype extends CI_Model {

    //Functionality : list CourierType
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCTYList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtCtyCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        CTY.FTCtyCode   AS rtCtyCode,
                                        CTY_L.FTCtyName AS rtCtyName
                                    FROM [TCNMCourierType] CTY
                                    LEFT JOIN [TCNMCourierType_L]  CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (CTY.FTCtyCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMCTYGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of CourierType
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut (Bell)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMCTYGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (CTY.FTCtyCode) AS counts
                    FROM [TCNMCourierType] CTY
                    LEFT JOIN [TCNMCourierType_L] CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $ptLngID
                    WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (CTY.FTCtyCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data CourierType By ID
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCTYGetDataByID($paData){
        try{
            $tCtyCode   = $paData['FTCtyCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                CTY.FTCtyCode   AS rtCtyCode,
                                CTY_L.FTCtyName AS rtCtyName,
                                CTY_l.FTCtyRmk  AS rtCtyRmk
                            FROM TCNMCourierType CTY
                            LEFT JOIN TCNMCourierType_L CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $nLngID
                            WHERE 1=1 AND CTY.FTCtyCode = '$tCtyCode' ";
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


    //Functionality : Checkduplicate CourierType
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMCTYCheckDuplicate($ptCtyCode){
        $tSQL = "SELECT COUNT(CTY.FTCtyCode) AS counts
                    FROM TCNMCourierType CTY
                    WHERE CTY.FTCtyCode = '$ptCtyCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return false;
        }
    }

    //Functionality : Update Product CourierType (TCNMCourierType)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCTYAddUpdateMaster($paDataCouriertype){
        try{
                // Update TCNMCourierType
                $this->db->where('FTCtyCode', $paDataCouriertype['FTCtyCode']);
                $this->db->update('TCNMCourierType',array(
                    'FDLastUpdOn'  => $paDataCouriertype['FDLastUpdOn'], 
                    'FTLastUpdBy'  => $paDataCouriertype['FTLastUpdBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update CourierType Success',
                    );
                }else{
                    //Add TCNMCourierType
                    $this->db->insert('TCNMCourierType', array(
                        'FTCtyCode'     => $paDataCouriertype['FTCtyCode'],
                        'FDLastUpdOn'   => $paDataCouriertype['FDLastUpdOn'],
                        'FTLastUpdBy'   => $paDataCouriertype['FTLastUpdBy'],
                        'FDCreateOn'    => $paDataCouriertype['FDCreateOn'],
                        'FTCreateBy'    => $paDataCouriertype['FTCreateBy'],
                    ));
                    if($this->db->affected_rows() > 0){
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Add CourierType Success',
                        );
                    }else{
                        $aStatus = array(
                            'rtCode' => '905',
                            'rtDesc' => 'Error Cannot Add/Edit CourierType',
                        );
                    }
                }
                return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Update CourierTYpe (TCNMCourierType)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCTYAddUpdateLang($paDataCouriertype){
        try{
             //Update TCNMCourierType Lang
            $this->db->where('FNLngID', $paDataCouriertype['FNLngID']);
            $this->db->where('FTCtyCode', $paDataCouriertype['FTCtyCode']);
            $this->db->update('TCNMCourierType_L', array(
                'FTCtyName' => $paDataCouriertype['FTCtyName'],
                'FTCtyRmk'  => $paDataCouriertype['FTCtyRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CourierType Lang Success.',
                );
            }else{
                 //Add TCNMCourierType Lang 
                 $this->db->insert('TCNMCourierType_L', array(
                    'FTCtyCode' => $paDataCouriertype['FTCtyCode'],
                    'FNLngID'   => $paDataCouriertype['FNLngID'],
                    'FTCtyName' => $paDataCouriertype['FTCtyName'],
                    'FTCtyRmk'  => $paDataCouriertype['FTCtyRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add CourierType Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit CourierType Lang.',
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
    public function FSaMCTYDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTCtyCode', $paData['FTCtyCode']);
            $this->db->delete('TCNMCourierType');

            $this->db->where_in('FTCtyCode', $paData['FTCtyCode']);
            $this->db->delete('TCNMCourierType_L');

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
    public function FSnMCTYGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMCourierType";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}