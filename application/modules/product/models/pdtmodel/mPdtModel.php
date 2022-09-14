<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtModel extends CI_Model {

    //Functionality : list Product Model
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPMOList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode    = $paData['tSesAgnCode'];

            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPmoCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        PTY.FTPmoCode   AS rtPmoCode,
                                        PTY_L.FTPmoName AS rtPmoName,
                                        PTY.FDCreateOn,
                                        PTY.FTAgnCode       AS rtAgnCode,
                                        AGNL.FTAgnName       AS rtAgnName
                                    FROM [TCNMPdtModel] PTY
                                    LEFT JOIN [TCNMPdtModel_L]  PTY_L ON PTY.FTPmoCode = PTY_L.FTPmoCode AND PTY_L.FNLngID = $nLngID
                                    LEFT JOIN [TCNMAgency_L] AGNL ON PTY.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                                    WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= "AND PTY.FTAgnCode = $tSesAgnCode";     
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PTY.FTPmoCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR PTY_L.FTPmoName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPMOGetPageAll($tSearchList,$nLngID,$tSesAgnCode);
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

    //Functionality : All Page Of Product Model
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut (Bell)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMPMOGetPageAll($ptSearchList,$ptLngID, $tSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (PTY.FTPmoCode) AS counts
                     FROM [TCNMPdtModel] PTY
                     LEFT JOIN [TCNMPdtModel_L]  PTY_L ON PTY.FTPmoCode = PTY_L.FTPmoCode AND PTY_L.FNLngID = $ptLngID
                     LEFT JOIN [TCNMAgency_L] AGNL ON PTY.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $ptLngID
                     WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= "AND PTY.FTAgnCode = $tSesAgnCode";     
            }

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PTY.FTPmoCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR PTY_L.FTPmoName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Product Model By ID
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPMOGetDataByID($paData){
        try{
            $tPmoCode   = $paData['FTPmoCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                PTY.FTPmoCode   AS rtPmoCode,
                                PTY_L.FTPmoName AS rtPmoName,
                                PTY_L.FTPmoRmk  AS rtPmoRmk,
                                PTY.FTAgnCode       AS rtAgnCode,
                                AGNL.FTAgnName       AS rtAgnName
                            FROM TCNMPdtModel PTY
                            LEFT JOIN TCNMPdtModel_L PTY_L ON PTY.FTPmoCode = PTY_L.FTPmoCode AND PTY_L.FNLngID = $nLngID 
                            LEFT JOIN [TCNMAgency_L] AGNL ON PTY.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1=1 AND PTY.FTPmoCode = '$tPmoCode' ";
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

    //Functionality : Checkduplicate Product Model
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMPMOCheckDuplicate($ptPmoCode){
        $tSQL = "SELECT COUNT(PTY.FTPmoCode) AS counts
                 FROM TCNMPdtModel PTY 
                 WHERE PTY.FTPmoCode = '$ptPmoCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product Product Model (TCNMPdtModel)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPMOAddUpdateMaster($paDataPdtModel){
        try{
            // Update TCNMPdtModel
            $this->db->where('FTPmoCode', $paDataPdtModel['FTPmoCode']);
            $this->db->update('TCNMPdtModel',array(
                'FDLastUpdOn'  => $paDataPdtModel['FDLastUpdOn'],
                'FTLastUpdBy'  => $paDataPdtModel['FTLastUpdBy'],
                'FTAgnCode'    => $paDataPdtModel['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            }else{
                //Add TCNMPdtModel
                $this->db->insert('TCNMPdtModel', array(
                    'FTPmoCode'   => $paDataPdtModel['FTPmoCode'],
                    'FDCreateOn'  => $paDataPdtModel['FDCreateOn'],
                    'FTCreateBy'  => $paDataPdtModel['FTCreateBy'],
                    'FDLastUpdOn' => $paDataPdtModel['FDLastUpdOn'],
                    'FTLastUpdBy' => $paDataPdtModel['FTLastUpdBy'],
                    'FTAgnCode'    => $paDataPdtModel['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Model Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Model',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Model (TCNMPdtModel_L)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPMOAddUpdateLang($paDataPdtModel){
        try{
            //Update Pdt Model Lang
            $this->db->where('FNLngID', $paDataPdtModel['FNLngID']);
            $this->db->where('FTPmoCode', $paDataPdtModel['FTPmoCode']);
            $this->db->update('TCNMPdtModel_L',array(
                'FTPmoName' => $paDataPdtModel['FTPmoName'],
                'FTPmoRmk'  => $paDataPdtModel['FTPmoRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Model Lang Success.',
                );
            }else{
                //Add Pdt Model Lang
                $this->db->insert('TCNMPdtModel_L', array(
                    'FTPmoCode' => $paDataPdtModel['FTPmoCode'],
                    'FNLngID'   => $paDataPdtModel['FNLngID'],
                    'FTPmoName' => $paDataPdtModel['FTPmoName'],
                    'FTPmoRmk'  => $paDataPdtModel['FTPmoRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Model Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Model Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Model
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMPMODelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTPmoCode', $paData['FTPmoCode']);
            $this->db->delete('TCNMPdtModel');

            $this->db->where_in('FTPmoCode', $paData['FTPmoCode']);
            $this->db->delete('TCNMPdtModel_L');

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
    public function FSnMPmoGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtModel";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}