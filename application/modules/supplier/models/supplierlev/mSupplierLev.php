<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSupplierLev extends CI_Model {

    //Functionality : list SupplierLevel
    //Parameters : function parameters
    //Creator :  09/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSaMSLVList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtSlvCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        SLV.FTSlvCode   AS rtSlvCode,
                                        SLV_L.FTSlvName AS rtSlvName,
                                        SLV.FDCreateOn
                                    FROM [TCNMSplLev] SLV
                                    LEFT JOIN [TCNMSplLev_L]  SLV_L ON SLV.FTSlvCode = SLV_L.FTSlvCode AND SLV_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                // $tSQL .= " AND (SLV.FTSlvCode LIKE '%$tSearchList%'";
                // $tSQL .= " OR SLV_L.FTSlvName  LIKE '%$tSearchList%')";
                $tSQL .= " AND SLV.FTSlvCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR SLV_L.FTSlvName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMSLVGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of SupplierLevel
    //Parameters : function parameters
    //Creator :  09/10/2018 witsarut
    //Return : object Count All SupplierLevel
    //Return Type : Object
    public function FSoMSLVGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (SLV.FTSlvCode) AS counts
                     FROM [TCNMSplLev] SLV
                     LEFT JOIN [TCNMSplLev_L]  SLV_L ON SLV.FTSlvCode = SLV_L.FTSlvCode AND SLV_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (SLV.FTSlvCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR SLV_L.FTSlvName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data SupplierLevel By ID
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSaMSLVGetDataByID($paData){
        try{
            $tSlvCode   = $paData['FTSlvCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                SLV.FTSlvCode   AS rtSlvCode,
                                SLV_L.FTSlvName AS rtSlvName,
                                SLV_L.FTSlvRmk  AS rtSlvRmk
                            FROM TCNMSplLev SLV
                            LEFT JOIN TCNMSplLev_L SLV_L ON SLV.FTSlvCode = SLV_L.FTSlvCode AND SLV_L.FNLngID = $nLngID 
                            WHERE 1=1 AND SLV.FTSlvCode = '$tSlvCode' ";
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

    //Functionality : Checkduplicate SupplierLevel 
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSnMSLVCheckDuplicate($ptSlvCode){
        $tSQL = "SELECT COUNT(SLV.FTSlvCode) AS counts
                 FROM TCNMSplLev SLV 
                 WHERE SLV.FTSlvCode = '$ptSlvCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update SupplierLevel (TCNMSplLev)
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMSLVAddUpdateMaster($paDataSupplierLevel){
        try{
            // Update TCNMSplLev
            $this->db->where('FTSlvCode', $paDataSupplierLevel['FTSlvCode']);
            $this->db->update('TCNMSplLev',array(
                'FDLastUpdOn'   => $paDataSupplierLevel['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataSupplierLevel['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SupplierLevel Success',
                );
            }else{
                //Add TCNMSplLev
                $this->db->insert('TCNMSplLev', array(
                    'FTSlvCode'     => $paDataSupplierLevel['FTSlvCode'],
                    'FDCreateOn'    => $paDataSupplierLevel['FDCreateOn'],
                    'FTCreateBy'    => $paDataSupplierLevel['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataSupplierLevel['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataSupplierLevel['FTLastUpdBy'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SupplierLevel Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SupplierLevel.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update SupplierLevel Lang (TCNMSplLev_L)
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMSLVAddUpdateLang($paDataSupplierLevel){
        try{
            //Update Pdt Type Lang
            $this->db->where('FNLngID', $paDataSupplierLevel['FNLngID']);
            $this->db->where('FTSlvCode', $paDataSupplierLevel['FTSlvCode']);
            $this->db->update('TCNMSplLev_L',array(
                'FTSlvName' => $paDataSupplierLevel['FTSlvName'],
                'FTSlvRmk'  => $paDataSupplierLevel['FTSlvRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SupplierLevel Lang Success.',
                );
            }else{
                //Add Pdt Type Lang
                $this->db->insert('TCNMSplLev_L', array(
                    'FTSlvCode' => $paDataSupplierLevel['FTSlvCode'],
                    'FNLngID'   => $paDataSupplierLevel['FNLngID'],
                    'FTSlvName' => $paDataSupplierLevel['FTSlvName'],
                    'FTSlvRmk'  => $paDataSupplierLevel['FTSlvRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SupplierLevel Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SupplierLevel Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete SupplierLevel
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : Status Delete
    //Return Type : array
    public function FSaMSLVDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTSlvCode', $paData['FTSlvCode']);
            $this->db->delete('TCNMSplLev');

            $this->db->where_in('FTSlvCode', $paData['FTSlvCode']);
            $this->db->delete('TCNMSplLev_L');

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