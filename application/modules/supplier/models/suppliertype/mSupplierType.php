<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSupplierType extends CI_Model {

    //Functionality : list SupplierType
    //Parameters : function parameters
    //Creator :  04/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMSTYList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtStyCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        STY.FTStyCode   AS rtStyCode,
                                        STY_L.FTStyName AS rtStyName,
                                        STY.FDCreateOn
                                    FROM [TCNMSplType] STY
                                    LEFT JOIN [TCNMSplType_L]  STY_L ON STY.FTStyCode = STY_L.FTStyCode AND STY_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                // $tSQL .= " AND (STY.FTStyCode LIKE '%$tSearchList%'";
                // $tSQL .= " OR STY_L.FTStyName  LIKE '%$tSearchList%')";
                $tSQL .= " AND STY.FTStyCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR STY_L.FTStyName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMSTYGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of SupplierType
    //Parameters : function parameters
    //Creator :  04/10/2018 Witsarut (Bell)
    //Return : object Count All SupplierType
    //Return Type : Object
    public function FSoMSTYGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (STY.FTStyCode) AS counts
                     FROM [TCNMSplType] STY
                     LEFT JOIN [TCNMSplType_L]  STY_L ON STY.FTStyCode = STY_L.FTStyCode AND STY_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (STY.FTStyCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR STY_L.FTStyName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data SupplierType By ID
    //Parameters : function parameters
    //Creator : 04/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMSTYGetDataByID($paData){
        try{
            $tStyCode   = $paData['FTStyCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                STY.FTStyCode   AS rtStyCode,
                                STY_L.FTStyName AS rtStyName,
                                STY_L.FTStyRmk  AS rtStyRmk
                            FROM TCNMSplType STY
                            LEFT JOIN TCNMSplType_L STY_L ON STY.FTStyCode = STY_L.FTStyCode AND STY_L.FNLngID = $nLngID 
                            WHERE 1=1 AND STY.FTStyCode = '$tStyCode' ";
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

    //Functionality : Checkduplicate SupplierType
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMSTYCheckDuplicate($ptStyCode){
        $tSQL = "SELECT COUNT(STY.FTStyCode) AS counts
                 FROM TCNMSplType STY
                 WHERE STY.FTStyCode = '$ptStyCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product SupplierType (TCNMSplType)
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMSTYAddUpdateMaster($paDataSupplierType){
        try{
            // Update TCNMSplType
            $this->db->where('FTStyCode', $paDataSupplierType['FTStyCode']);
            $this->db->update('TCNMSplType',array(
                'FDLastUpdOn' => $paDataSupplierType['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataSupplierType['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SupplierType Success',
                );
            }else{
                //Add TCNMSplType
                $this->db->insert('TCNMSplType', array(
                    'FTStyCode'         => $paDataSupplierType['FTStyCode'],
                    'FDCreateOn'        => $paDataSupplierType['FDCreateOn'],
                    'FTCreateBy'        => $paDataSupplierType['FTCreateBy'],
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SupplierType Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SupplierType.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update SupplierType (TCNMSplType_L)
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMSTYAddUpdateLang($paDataSupplierType){
        try{
            //Update SupplierType Lang
            $this->db->where('FNLngID', $paDataSupplierType['FNLngID']);
            $this->db->where('FTStyCode', $paDataSupplierType['FTStyCode']);
            $this->db->update('TCNMSplType_L',array(
                'FTStyName' => $paDataSupplierType['FTStyName'],
                'FTStyRmk'  => $paDataSupplierType['FTStyRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SupplierType Lang Success.',
                );
            }else{
                //Add SupplierType Lang
                $this->db->insert('TCNMSplType_L', array(
                    'FTStyCode' => $paDataSupplierType['FTStyCode'],
                    'FNLngID'   => $paDataSupplierType['FNLngID'],
                    'FTStyName' => $paDataSupplierType['FTStyName'],
                    'FTStyRmk'  => $paDataSupplierType['FTStyRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SupplierType Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SupplierType Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete SupplierType
    //Parameters : function parameters
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMSTYDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTStyCode', $paData['FTStyCode']);
            $this->db->delete('TCNMSplType');

            $this->db->where_in('FTStyCode', $paData['FTStyCode']);
            $this->db->delete('TCNMSplType_L');

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