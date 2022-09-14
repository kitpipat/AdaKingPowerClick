<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mShipVia extends CI_Model {

    //Functionality : list Shipvia
    //Parameters : function parameters
    //Creator :  04/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMVIAList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtViaCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        VIA.FTViaCode   AS rtViaCode,
                                        VIA_L.FTViaName AS rtViaName
                                    FROM [TCNMShipVia] VIA
                                    LEFT JOIN [TCNMShipVia_L]  VIA_L ON VIA.FTViaCode = VIA_L.FTViaCode AND VIA_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (VIA.FTViaCode LIKE '%$tSearchList%'";
                $tSQL .= " OR VIA_L.FTViaName  LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMVIAGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of ShipVia
    //Parameters : function parameters
    //Creator :  04/10/2018 Witsarut (Bell)
    //Return : object Count All ShipVia
    //Return Type : Object
    public function FSoMVIAGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (VIA.FTViaCode) AS counts
                     FROM [TCNMShipVia] VIA
                     LEFT JOIN [TCNMShipVia_L]  VIA_L ON VIA.FTViaCode = VIA_L.FTViaCode AND VIA_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (VIA.FTViaCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR VIA_L.FTViaName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data ShipVia By ID
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMVIAGetDataByID($paData){
        try{
            $tViaCode   = $paData['FTViaCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                VIA.FTViaCode   AS rtViaCode,
                                VIA_L.FTViaName AS rtViaName
                            FROM TCNMShipVia VIA
                            LEFT JOIN TCNMShipVia_L VIA_L ON VIA.FTViaCode = VIA_L.FTViaCode AND VIA_L.FNLngID = $nLngID 
                            WHERE 1=1 AND VIA.FTViaCode = '$tViaCode' ";
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

    //Functionality : Checkduplicate ShipVia
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMVIACheckDuplicate($ptViaCode){
        $tSQL = "SELECT COUNT(VIA.FTViaCode) AS counts
                 FROM TCNMShipVia VIA 
                 WHERE VIA.FTViaCode = '$ptViaCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product ShipVia (TCNMShipVia)
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMVIAAddUpdateMaster($paDataShipVia){
        try{
            // Update TCNMShipVia
            $this->db->where('FTViaCode', $paDataShipVia['FTViaCode']);
            $this->db->update('TCNMShipVia',array(
                'FDLastUpdOn' => $paDataShipVia['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataShipVia['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ShipVia Success',
                );
            }else{
                //Add TCNMShipVia
                $this->db->insert('TCNMShipVia', array(
                    'FTViaCode' => $paDataShipVia['FTViaCode'],
                    'FDCreateOn' => $paDataShipVia['FDCreateOn'],
                    'FTCreateBy'  => $paDataShipVia['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add ShipVia Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit ShipVia.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update ShipVia (TCNMShipVia_L)
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMVIAAddUpdateLang($paDataShipVia){
        try{
            //Update Pdt Brand Lang
            $this->db->where('FNLngID', $paDataShipVia['FNLngID']);
            $this->db->where('FTViaCode', $paDataShipVia['FTViaCode']);
            $this->db->update('TCNMShipVia_L',array(
                'FTViaName' => $paDataShipVia['FTViaName']
                
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ShipVia Lang Success.',
                );
            }else{
                //Add Pdt Brand Lang
                $this->db->insert('TCNMShipVia_L', array(
                    'FTViaCode' => $paDataShipVia['FTViaCode'],
                    'FNLngID'   => $paDataShipVia['FNLngID'],
                    'FTViaName' => $paDataShipVia['FTViaName']
                   
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add ShipVia Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit ShipVia Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete ShipVia
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMVIADelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTViaCode', $paData['FTViaCode']);
            $this->db->delete('TCNMShipVia');

            $this->db->where_in('FTViaCode', $paData['FTViaCode']);
            $this->db->delete('TCNMShipVia_L');

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