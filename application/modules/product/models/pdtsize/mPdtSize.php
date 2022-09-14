<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtSize extends CI_Model {

    //Functionality : list Product Size
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPSZList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode = $paData['tSesAgnCode'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPszCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        PSZ.FTPszCode   AS rtPszCode,
                                        PSZ_L.FTPszName AS rtPszName,
                                        PSZ.FDCreateOn
                                    FROM [TCNMPdtSize] PSZ
                                    LEFT JOIN [TCNMPdtSize_L]  PSZ_L ON PSZ.FTPszCode = PSZ_L.FTPszCode AND PSZ_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PSZ.FTPszCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR PSZ_L.FTPszName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }

            if ($tSesAgnCode != '') {
                $tSQL .= " AND PSZ.FTAgnCode = $tSesAgnCode";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPSZGetPageAll($tSearchList,$nLngID,$tSesAgnCode);
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

    //Functionality : All Page Of Product Size
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut (Bell)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMPSZGetPageAll($ptSearchList,$ptLngID,$ptSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (PSZ.FTPszCode) AS counts
                     FROM [TCNMPdtSize] PSZ
                     LEFT JOIN [TCNMPdtSize_L]  PSZ_L ON PSZ.FTPszCode = PSZ_L.FTPszCode AND PSZ_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PSZ.FTPszCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR PSZ_L.FTPszName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
            }

            if ($ptSesAgnCode != '') {
                $tSQL .= " AND PSZ.FTAgnCode = $ptSesAgnCode";
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

    //Functionality : Get Data Product Size By ID
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPSZGetDataByID($paData){
        try{
            $tPszCode   = $paData['FTPszCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                PSZ.FTPszCode   AS rtPszCode,
                                PSZ_L.FTPszName AS rtPszName,
                                PSZ_L.FTPszRmk  AS rtPszRmk,
                                PSZ.FTAgnCode   AS rtAgnCode,
                                AGNL.FTAgnName  AS rtAgnName
                            FROM TCNMPdtSize PSZ
                            LEFT JOIN TCNMPdtSize_L PSZ_L ON PSZ.FTPszCode = PSZ_L.FTPszCode AND PSZ_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMAgency_L AGNL ON  PSZ.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                            WHERE 1=1 AND PSZ.FTPszCode = '$tPszCode' ";
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

    //Functionality : Checkduplicate Product Size
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMPSZCheckDuplicate($ptPszCode){
        $tSQL = "SELECT COUNT(PSZ.FTPszCode) AS counts
                 FROM TCNMPdtSize PSZ 
                 WHERE PSZ.FTPszCode = '$ptPszCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product Product Size (TCNMPdtSize)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPSZAddUpdateMaster($paDataPdtSize){
        try{
            // Update TCNMPdtSize
            $this->db->where('FTPszCode', $paDataPdtSize['FTPszCode']);
            $this->db->update('TCNMPdtSize',array(
                'FDLastUpdOn' => $paDataPdtSize['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataPdtSize['FTLastUpdBy'],
                'FTAgnCode'     => $paDataPdtSize['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Size Success',
                );
            }else{
                //Add TCNMPdtSize
                $this->db->insert('TCNMPdtSize', array(
                    'FTPszCode'     => $paDataPdtSize['FTPszCode'],
                    'FDCreateOn'    => $paDataPdtSize['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtSize['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtSize['FDLastUpdOn'], 
                    'FTLastUpdBy'   => $paDataPdtSize['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataPdtSize['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Size Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Size',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Size (TCNMPdtSize_L)
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPSZAddUpdateLang($paDataPdtSize){
        try{
            //Update Pdt Size Lang
            $this->db->where('FNLngID', $paDataPdtSize['FNLngID']);
            $this->db->where('FTPszCode', $paDataPdtSize['FTPszCode']);
            $this->db->update('TCNMPdtSize_L',array(
                'FTPszName' => $paDataPdtSize['FTPszName'],
                'FTPszRmk'  => $paDataPdtSize['FTPszRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Size Lang Success.',
                );
            }else{
                //Add Pdt Size Lang
                $this->db->insert('TCNMPdtSize_L', array(
                    'FTPszCode' => $paDataPdtSize['FTPszCode'],
                    'FNLngID'   => $paDataPdtSize['FNLngID'],
                    'FTPszName' => $paDataPdtSize['FTPszName'],
                    'FTPszRmk'  => $paDataPdtSize['FTPszRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Size Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Size Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Size
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMPSZDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTPszCode', $paData['FTPszCode']);
            $this->db->delete('TCNMPdtSize');

            $this->db->where_in('FTPszCode', $paData['FTPszCode']);
            $this->db->delete('TCNMPdtSize_L');

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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtSize";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}