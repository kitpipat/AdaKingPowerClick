<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtType extends CI_Model {

    //Functionality : list Product Type
    //Parameters : function parameters
    //Creator :  14/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMPTYList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSesAgnCode    = $paData['tSesAgnCode'];

            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPtyCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        PTY.FTPtyCode   AS rtPtyCode,
                                        PTY_L.FTPtyName AS rtPtyName,
                                        PTY.FDCreateOn,
                                        PTY.FTAgnCode       AS rtAgnCode,
                                        AGNL.FTAgnName       AS rtAgnName
                                    FROM [TCNMPdtType] PTY
                                    LEFT JOIN [TCNMPdtType_L]  PTY_L ON PTY.FTPtyCode = PTY_L.FTPtyCode AND PTY_L.FNLngID = $nLngID
                                    LEFT JOIN [TCNMAgency_L] AGNL ON PTY.FTAgnCode  = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                                    WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= "AND PTY.FTAgnCode = $tSesAgnCode";     
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PTY.FTPtyCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR PTY_L.FTPtyName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPTYGetPageAll($tSearchList,$nLngID, $tSesAgnCode);
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

    //Functionality : All Page Of Product Type
    //Parameters : function parameters
    //Creator :  14/09/2018 Wasin
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMPTYGetPageAll($ptSearchList,$ptLngID, $tSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (PTY.FTPtyCode) AS counts
                     FROM [TCNMPdtType] PTY
                     LEFT JOIN [TCNMPdtType_L]  PTY_L ON PTY.FTPtyCode = PTY_L.FTPtyCode AND PTY_L.FNLngID = $ptLngID
                     LEFT JOIN [TCNMAgency_L] AGNL ON PTY.FTAgnCode  = AGNL.FTAgnCode AND AGNL.FNLngID = $ptLngID
                     WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= "AND PTY.FTAgnCode = $tSesAgnCode";    
            }         
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PTY.FTPtyCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR PTY_L.FTPtyName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Product Type By ID
    //Parameters : function parameters
    //Creator : 17/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMPTYGetDataByID($paData){
        try{
            $tPtyCode   = $paData['FTPtyCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                PTY.FTPtyCode   AS rtPtyCode,
                                PTY_L.FTPtyName AS rtPtyName,
                                PTY_L.FTPtyRmk  AS rtPtyRmk,
                                PTY.FTAgnCode   AS rtAgnCode,
                                AGNL.FTAgnName  AS rtAgnName
                            FROM TCNMPdtType PTY
                            LEFT JOIN TCNMPdtType_L PTY_L ON PTY.FTPtyCode = PTY_L.FTPtyCode AND PTY_L.FNLngID = $nLngID 
                            LEFT JOIN [TCNMAgency_L] AGNL ON PTY.FTAgnCode  = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1=1 AND PTY.FTPtyCode = '$tPtyCode' ";
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

    //Functionality : Checkduplicate Product Type 
    //Parameters : function parameters
    //Creator : 17/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMPTYCheckDuplicate($ptPtyCode){
        $tSQL = "SELECT COUNT(PTY.FTPtyCode) AS counts
                 FROM TCNMPdtType PTY 
                 WHERE PTY.FTPtyCode = '$ptPtyCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product Type (TCNMPdtType)
    //Parameters : function parameters
    //Creator : 17/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPTYAddUpdateMaster($paDataPdtType){
        try{
            // Update TCNMPdtType
            $this->db->where('FTPtyCode', $paDataPdtType['FTPtyCode']);
            $this->db->update('TCNMPdtType',array(
                'FDLastUpdOn'   => $paDataPdtType['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataPdtType['FTLastUpdBy'],
                'FTAgnCode'     => $paDataPdtType['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            }else{
                //Add TCNMPdtType
                $this->db->insert('TCNMPdtType', array(
                    'FTPtyCode'     => $paDataPdtType['FTPtyCode'],
                    'FDCreateOn'    => $paDataPdtType['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtType['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtType['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataPdtType['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataPdtType['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Type Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Type.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Type Lang (TCNMPdtType_L)
    //Parameters : function parameters
    //Creator : 17/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPTYAddUpdateLang($paDataPdtType){
        try{
            //Update Pdt Type Lang
            $this->db->where('FNLngID', $paDataPdtType['FNLngID']);
            $this->db->where('FTPtyCode', $paDataPdtType['FTPtyCode']);
            $this->db->update('TCNMPdtType_L',array(
                'FTPtyName' => $paDataPdtType['FTPtyName'],
                'FTPtyRmk'  => $paDataPdtType['FTPtyRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Lang Success.',
                );
            }else{
                //Add Pdt Type Lang
                $this->db->insert('TCNMPdtType_L', array(
                    'FTPtyCode' => $paDataPdtType['FTPtyCode'],
                    'FNLngID'   => $paDataPdtType['FNLngID'],
                    'FTPtyName' => $paDataPdtType['FTPtyName'],
                    'FTPtyRmk'  => $paDataPdtType['FTPtyRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Type Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Type Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Type
    //Parameters : function parameters
    //Creator : 17/09/2018 Wasin
    //Return : Status Delete
    //Return Type : array
    public function FSaMPTYDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTPtyCode', $paData['FTPtyCode']);
            $this->db->delete('TCNMPdtType');

            $this->db->where_in('FTPtyCode', $paData['FTPtyCode']);
            $this->db->delete('TCNMPdtType_L');

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



    //Functionality : get all row data from pdt type
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtType";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }







}