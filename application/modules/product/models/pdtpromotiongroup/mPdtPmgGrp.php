<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtPmgGrp extends CI_Model {

    //Functionality : list Product Promotion Group
    //Parameters : function parameters
    //Creator :  19/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPMGList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtPmgCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        PMG.FTPmgCode   AS rtPmgCode,
                                        PMG_L.FTPmgName AS rtPmgName
                                    FROM [TCNMPdtPmtGrp] PMG
                                    LEFT JOIN [TCNMPdtPmtGrp_L]  PMG_L ON PMG.FTPmgCode = PMG_L.FTPmgCode AND PMG_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PMG.FTPmgCode LIKE '%$tSearchList%'";
                $tSQL .= " OR PMG_L.FTPmgName  LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPMGGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of Product Promotion Group
    //Parameters : function parameters
    //Creator :  19/09/2018 Witsarut (Bell)
    //Return : object Count All Product Promotion Group
    //Return Type : Object
    public function FSoMPMGGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (PMG.FTPmgCode) AS counts
                     FROM [TCNMPdtPmtGrp] PMG
                     LEFT JOIN [TCNMPdtPmtGrp_L]  PMG_L ON PMG.FTPmgCode = PMG_L.FTPmgCode AND PMG_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PMG.FTPmgCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR PMG_L.FTPmgName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Product Promotion Group By ID
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMPMGGetDataByID($paData){
        try{
            $tPmgCode   = $paData['FTPmgCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                PMG.FTPmgCode   AS rtPmgCode,
                                PMG_L.FTPmgName AS rtPmgName,
                                PMG_L.FTPmgRmk  AS rtPmgRmk
                            FROM TCNMPdtPmtGrp PMG
                            LEFT JOIN TCNMPdtPmtGrp_L PMG_L ON PMG.FTPmgCode = PMG_L.FTPmgCode AND PMG_L.FNLngID = $nLngID 
                            WHERE 1=1 AND PMG.FTPmgCode = '$tPmgCode' ";
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

    //Functionality : Checkduplicate Product Promotion Group
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMPMGCheckDuplicate($ptPmgCode){
        $tSQL = "SELECT COUNT(PMG.FTPmgCode) AS counts
                 FROM TCNMPdtPmtGrp PMG 
                 WHERE PMG.FTPmgCode = '$ptPmgCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product Promotion Group (TCNMPdtPmtGrp)
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPMGAddUpdateMaster($paDataPdtPmgGrp){
        try{
            // Update TCNMPdtPmtGrp
            $this->db->where('FTPmgCode', $paDataPdtPmgGrp['FTPmgCode']);
            $this->db->update('TCNMPdtPmtGrp',array(
                'FDLastUpdOn' => $paDataPdtPmgGrp['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataPdtPmgGrp['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            }else{
                //Add TCNMPdtPmtGrp
                $this->db->insert('TCNMPdtPmtGrp', array(
                    'FTPmgCode' => $paDataPdtPmgGrp['FTPmgCode'],
                    'FDCreateOn' => $paDataPdtPmgGrp['FDCreateOn'],
                    'FTCreateBy' => $paDataPdtPmgGrp['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Promotion Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Promotion.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Promotion Lang (TCNMPdtPmtGrp_L)
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPMGAddUpdateLang($paDataPdtPmgGrp){
        try{
            //Update Pdt Promotion Lang
            $this->db->where('FNLngID', $paDataPdtPmgGrp['FNLngID']);
            $this->db->where('FTPmgCode', $paDataPdtPmgGrp['FTPmgCode']);
            $this->db->update('TCNMPdtPmtGrp_L',array(
                'FTPmgName' => $paDataPdtPmgGrp['FTPmgName'],
                'FTPmgRmk'  => $paDataPdtPmgGrp['FTPmgRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Promotion Lang Success.',
                );
            }else{
                //Add Pdt Promotion Lang
                $this->db->insert('TCNMPdtPmtGrp_L', array(
                    'FTPmgCode' => $paDataPdtPmgGrp['FTPmgCode'],
                    'FNLngID'   => $paDataPdtPmgGrp['FNLngID'],
                    'FTPmgName' => $paDataPdtPmgGrp['FTPmgName'],
                    'FTPmgRmk'  => $paDataPdtPmgGrp['FTPmgRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Promotion Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Promotion Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Promotion Group
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMPMGDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTPmgCode', $paData['FTPmgCode']);
            $this->db->delete('TCNMPdtPmtGrp');

            $this->db->where_in('FTPmgCode', $paData['FTPmgCode']);
            $this->db->delete('TCNMPdtPmtGrp_L');

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

    //Functionality : get all row data from pdt promotion group
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMPMGGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtPmtGrp";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}