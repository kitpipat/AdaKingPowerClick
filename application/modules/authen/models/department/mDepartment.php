<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mDepartment extends CI_Model {

    //Functionality : list Department
    //Parameters : function parameters
    //Creator :  22/11/2018 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSaMDPTList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode = $paData['tSesAgnCode'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtDptCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        Dpt.FTDptCode   AS rtDptCode,
                                        Dpt_L.FTDptName AS rtDptName,
                                        Dpt_L.FTDptRmk   AS rtDptRmk,
                                        Dpt.FDCreateOn

                                    FROM [TCNMUsrDepart] Dpt
                                    LEFT JOIN [TCNMUsrDepart_L]  Dpt_L ON Dpt.FTDptCode = Dpt_L.FTDptCode AND Dpt_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                // $tSQL .= " AND (Dpt.FTDptCode LIKE '%$tSearchList%'";
                // $tSQL .= " OR Dpt_L.FTDptName  LIKE '%$tSearchList%')";
                $tSQL .= " AND Dpt.FTDptCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR Dpt_L.FTDptName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            }
            if ($tSesAgnCode != '') {
                $tSQL .= " AND Dpt.FTAgnCode = $tSesAgnCode";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMDPTGetPageAll($tSearchList,$nLngID,$tSesAgnCode);
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

    //Functionality : All Page Of Department
    //Parameters : function parameters
    //Creator :  22/11/2018 Witsarut 
    //Return : object Count All Department
    //Return Type : Object
    public function FSoMDPTGetPageAll($ptSearchList,$ptLngID,$tSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (Dpt.FTDptCode) AS counts
                     FROM [TCNMUsrDepart] Dpt
                     LEFT JOIN [TCNMUsrDepart_L]  Dpt_L ON Dpt.FTDptCode = Dpt_L.FTDptCode AND Dpt_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (Dpt.FTDptCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR Dpt_L.FTDptName  LIKE '%$ptSearchList%')";
            }

            
        if ($tSesAgnCode != '') {
            $tSQL .= " AND Dpt.FTAgnCode = $tSesAgnCode";
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

    //Functionality : Get Data Department By ID
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSaMDPTGetDataByID($paData){
        try{
            $tDptCode   = $paData['FTDptCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                Dpt.FTDptCode   AS rtDptCode,
                                Dpt_L.FTDptName AS rtDptName,
                                Dpt_L.FTDptRmk   AS rtDptRmk,
                                Dpt.FTAgnCode   AS rtAgnCode,
                            AGNL.FTAgnName  AS rtAgnName
                            FROM TCNMUsrDepart Dpt
                            LEFT JOIN TCNMUsrDepart_L Dpt_L ON Dpt.FTDptCode = Dpt_L.FTDptCode AND Dpt_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMAgency_L AGNL ON  Dpt.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                            WHERE 1=1 AND Dpt.FTDptCode = '$tDptCode' ";
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

    //Functionality : Checkduplicate Department
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSnMDPTCheckDuplicate($ptDptCode){
        $tSQL = "SELECT COUNT(Dpt.FTDptCode) AS counts
                 FROM TCNMUsrDepart Dpt 
                 WHERE Dpt.FTDptCode = '$ptDptCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Department (TCNMUsrDepart)
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMDPTAddUpdateMaster($paDataDpt){
        try{
            // Update TCNMUsrDepart
            $this->db->where('FTDptCode', $paDataDpt['FTDptCode']);
            $this->db->update('TCNMUsrDepart',array(
                'FDLastUpdOn' => $paDataDpt['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataDpt['FTLastUpdBy'],
                'FTAgnCode'     => $paDataDpt['FTAgnCode']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            }else{
                //Add TCNMUsrDepart
                $this->db->insert('TCNMUsrDepart', array(
                    'FTDptCode'     => $paDataDpt['FTDptCode'],
                    'FDCreateOn'    => $paDataDpt['FDCreateOn'],
                    'FTCreateBy'    => $paDataDpt['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataDpt['FDLastUpdOn'], 
                    'FTLastUpdBy'   => $paDataDpt['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataDpt['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Department Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Department.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Department (TCNMUsrDepart_L)
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMDPTAddUpdateLang($paDataDpt){
        try{
            //Update Department Lang
            $this->db->where('FNLngID', $paDataDpt['FNLngID']);
            $this->db->where('FTDptCode', $paDataDpt['FTDptCode']);
            $this->db->update('TCNMUsrDepart_L',array(
                'FTDptName' => $paDataDpt['FTDptName'],
                'FTDptRmk'  => $paDataDpt['FTDptRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Department Lang Success.',
                );
            }else{
                //Add Department Lang
                $this->db->insert('TCNMUsrDepart_L', array(
                    'FTDptCode' => $paDataDpt['FTDptCode'],
                    'FNLngID'   => $paDataDpt['FNLngID'],
                    'FTDptName' => $paDataDpt['FTDptName'],
                    'FTDptRmk'  => $paDataDpt['FTDptRmk']
                   
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Department Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Department Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Department
    //Parameters : function parameters
    //Creator : 22/11/2018 Witsarut 
    //Return : Status Delete
    //Return Type : array
    public function FSaMDPTDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTDptCode', $paData['FTDptCode']);
            $this->db->delete('TCNMUsrDepart');

            $this->db->where_in('FTDptCode', $paData['FTDptCode']);
            $this->db->delete('TCNMUsrDepart_L');

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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMUsrDepart";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}