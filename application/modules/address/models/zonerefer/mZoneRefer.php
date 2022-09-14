<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mZoneRefer extends CI_Model {

    //Functionality : list ZoneRefer
    //Parameters : function parameters
    //Creator :  24/04/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMZNERList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtZneID ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT

                                        ZNEObj.FNZneID      AS rtZneID,
                                        ZNEObj.FTZneRefID   AS rtZneRefID,
                                        ZNEObj.FTZneTable   AS rtZneTable,
                                        ZNEObj.FTZneKey     AS rtZneKey,
                                        ZNEObj.FTZneChain   AS rtZneChain
                                                                     
                                    FROM [TCNMZoneObj] ZNEObj
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (ZNEObj.FTZneTable LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMZNERGetPageAll($tSearchList);
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

    //Functionality : All Page Of ZoneRefer
    //Parameters : function parameters
    //Creator :  24/04/2019 Witsarut (Bell)
    //Return : object Count All ZoneRefer
    //Return Type : Object
    public function FSoMZNERGetPageAll($ptSearchList){
        try{
            $tSQL = "SELECT COUNT (ZNEObj.rtZneID) AS counts
                     FROM [TCNMZoneObj] ZNEObj
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (ZNEObj.FTZneTable LIKE '%$tSearchList%')";
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


    //Functionality : Get Data ZoneRefer By ID
    //Parameters : function parameters
    //Creator :  24/04/2019 Witsarut (Bell)
    //Return : data
    //Return Type : Array
    public function FSaMZNERGetDataByID($paData){
        try{
            $tZneRCode   = $paData['FNZneID'];
            $tSQL       = " SELECT 

                                ZNEObj.FNZneID      AS rtZneID,
                                ZNEObj.FTZneRefID   AS rtZneRefID,
                                ZNEObj.FTZneTable   AS rtZneTable,
                                ZNEObj.FTZneKey     AS rtZneKey,
                                ZNEObj.FTZneChain   AS rtZneChain
                   
                                FROM [TCNMZoneObj] ZNEObj
                                WHERE 1=1 AND ZNEObj.FNZneID = '$tZneRCode' ";
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

   

    //Functionality : Update ZoneRefer
    //Parameters : function parameters
    //Creator : 24/04/2019 Witsarut (Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMZNERAddUpdateMaster($paData){
        try{
            // Update TCNMZoneObj
            $this->db->where('FNFTZneTable', $paData['FNFTZneTable']);
            $this->db->where('FTZneKey', $paData['FTZneKey']);
            $this->db->where('FTZneRefID', $paData['FTZneRefID']);
   
            $this->db->update('TCNMZoneObj',array(
                'FTZneKey'      => $paData['FTZneKey'],
                'FTZneRefID'    => $paData['FTZneRefID'],
                'FNFTZneTable'  => $paData['FNFTZneTable'],
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ZoneRefer Success',
                );
            }else{
                //Add TCNMZoneObj
                $this->db->insert('TCNMZoneObj', array(
                    'FTZneKey'     => $paData['FTZneKey'],
                    'FTZneRefID'   => $paData['FTZneRefID'],
                    'FNFTZneTable' => $paData['FNFTZneTable'],
                    'FDCreateOn'   => $paData['FDCreateOn'],
                    'FTCreateBy'   => $paData['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add ZoneRefer Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit ZoneRefer.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete ZoneRefer
    //Parameters : function parameters
    //Creator : 24/04/2019 Witsarut (Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMZNERDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FNZneID', $paData['FNZneID']);
            $this->db->delete('TCNMZoneObj');

            $this->db->where_in('FNZneID', $paData['FNZneID']);
            $this->db->delete('TCNMZoneObj');
            
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