<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtPriceGroup extends CI_Model {

    //Functionality : list Product Price List
    //Parameters : function parameters
    //Creator :  18/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPPLList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSesAgnCode    = $paData['tSesAgnCode'];

            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPplCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        PPL.FTPplCode   AS rtPplCode,
                                        PPL_L.FTPplName AS rtPplName,
                                        PPL.FDCreateOn,
                                        PPL.FTAgnCode       AS rtAgnCode,
                                        AGNL.FTAgnName      AS rtAgnName
                                    FROM [TCNMPdtPriList] PPL
                                    LEFT JOIN [TCNMPdtPriList_L]  PPL_L ON PPL.FTPplCode = PPL_L.FTPplCode AND PPL_L.FNLngID = $nLngID
                                    LEFT JOIN [TCNMAgency_L] AGNL ON PPL.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                                    WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= " AND PPL.FTAgnCode = $tSesAgnCode";
            }                                  

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PPL.FTPplCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR PPL_L.FTPplName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPPLGetPageAll($tSearchList,$nLngID, $tSesAgnCode);
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

    //Functionality : All Page Of Product Price List
    //Parameters : function parameters
    //Creator :  18/09/2018 Witsarut (Bell)
    //Return : object Count All Product Price List
    //Return Type : Object
    public function FSoMPPLGetPageAll($ptSearchList,$ptLngID, $tSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (PPL.FTPplCode) AS counts
                     FROM [TCNMPdtPriList] PPL
                     LEFT JOIN [TCNMPdtPriList_L]  PPL_L ON PPL.FTPplCode = PPL_L.FTPplCode AND PPL_L.FNLngID = $ptLngID
                     LEFT JOIN [TCNMAgency_L] AGNL ON PPL.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $ptLngID
                     WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= " AND PPL.FTAgnCode = $tSesAgnCode";
            } 

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PPL.FTPplCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR PPL_L.FTPplName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Product Price List By ID
    //Parameters : function parameters
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPPLGetDataByID($paData){
        try{
            $tPplCode   = $paData['FTPplCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                PPL.FTPplCode   AS rtPplCode,
                                PPL_L.FTPplName AS rtPplName,
                                PPL_L.FTPplRmk  AS rtPplRmk,
                                PPL.FTAgnCode   AS rtAgnCode,
                                AGNL.FTAgnName  AS rtAgnName
                            FROM TCNMPdtPriList PPL
                            LEFT JOIN TCNMPdtPriList_L PPL_L ON PPL.FTPplCode = PPL_L.FTPplCode AND PPL_L.FNLngID = $nLngID 
                            LEFT JOIN [TCNMAgency_L] AGNL ON PPL.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1=1 AND PPL.FTPplCode = '$tPplCode' ";
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

    //Functionality : Checkduplicate Product Price List
    //Parameters : function parameters
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMPPLCheckDuplicate($ptPplCode){
        $tSQL = "SELECT COUNT(PPL.FTPplCode) AS counts
                 FROM TCNMPdtPriList PPL 
                 WHERE PPL.FTPplCode = '$ptPplCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product Price List (TCNMPdtPriList)
    //Parameters : function parameters
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPPLAddUpdateMaster($paDataPdtPrice){
        try{
            // Update TCNMPdtPriList
            $this->db->where('FTPplCode', $paDataPdtPrice['FTPplCode']);
            $this->db->update('TCNMPdtPriList',array(
                'FDLastUpdOn'   => $paDataPdtPrice['FDLastUpdOn'], 
                'FTLastUpdBy'   => $paDataPdtPrice['FTLastUpdBy'],
                'FTAgnCode'     => $paDataPdtPrice['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            }else{
                //Add TCNMPdtPriList
                $this->db->insert('TCNMPdtPriList', array(
                    'FTPplCode'     => $paDataPdtPrice['FTPplCode'],
                    'FDCreateOn'    => $paDataPdtPrice['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtPrice['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtPrice['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataPdtPrice['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataPdtPrice['FTAgnCode'],
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

    //Functionality : Update Product Price Lang (TCNMPdtPriList_L)
    //Parameters : function parameters
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPPLAddUpdateLang($paDataPdtPrice){
        try{
            //Update Pdt Type Lang
            $this->db->where('FNLngID', $paDataPdtPrice['FNLngID']);
            $this->db->where('FTPplCode', $paDataPdtPrice['FTPplCode']);
            $this->db->update('TCNMPdtPriList_L',array(
                'FTPplName' => $paDataPdtPrice['FTPplName'],
                'FTPplRmk'  => $paDataPdtPrice['FTPplRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product pri list Lang Success.',
                );
            }else{
                //Add Pdt Proce list Lang
                $this->db->insert('TCNMPdtPriList_L', array(
                    'FTPplCode' => $paDataPdtPrice['FTPplCode'],
                    'FNLngID'   => $paDataPdtPrice['FNLngID'],
                    'FTPplName' => $paDataPdtPrice['FTPplName'],
                    'FTPplRmk'  => $paDataPdtPrice['FTPplRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Price price list Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Price list Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Price List
    //Parameters : function parameters
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMPPLDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTPplCode', $paData['FTPplCode']);
            $this->db->delete('TCNMPdtPriList');

            $this->db->where_in('FTPplCode', $paData['FTPplCode']);
            $this->db->delete('TCNMPdtPriList_L');

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


    //Functionality : get all row data from pdt group price
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMPdtGrpGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtPriList_L";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }
}