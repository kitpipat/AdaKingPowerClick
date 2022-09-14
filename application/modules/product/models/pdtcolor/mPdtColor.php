<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtColor extends CI_Model {

    //Functionality : list Product Color
    //Parameters : function parameters
    //Creator :  24/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCLRList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode = $paData['tSesAgnCode'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtClrCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        CLR.FTClrCode   AS rtClrCode,
                                        CLR.FTClrRefValue AS rtClrIdColor,
                                        CLR_L.FTClrName AS rtClrName,
                                        CLR.FDCreateOn
                                    FROM [TCNMPdtColor] CLR
                                    LEFT JOIN [TCNMPdtColor_L]  CLR_L ON CLR.FTClrCode = CLR_L.FTClrCode AND CLR_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (CLR.FTClrCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR CLR_L.FTClrName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }

            if ($tSesAgnCode != '') {
                $tSQL .= " AND CLR.FTAgnCode = $tSesAgnCode";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMCLRGetPageAll($tSearchList,$nLngID,$tSesAgnCode);
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

    //Functionality : All Page Of Product Color
    //Parameters : function parameters
    //Creator :  24/09/2018 Witsarut (Bell)
    //Return : object Count All Product Color
    //Return Type : Object
    public function FSoMCLRGetPageAll($ptSearchList,$ptLngID,$ptSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (CLR.FTClrCode) AS counts
                     FROM [TCNMPdtColor] CLR
                     LEFT JOIN [TCNMPdtColor_L]  CLR_L ON CLR.FTClrCode = CLR_L.FTClrCode AND CLR_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (CLR.FTClrCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR CLR_L.FTClrName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
            }

            if ($ptSesAgnCode != '') {
                $tSQL .= " AND CLR.FTAgnCode = $ptSesAgnCode";
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

    //Functionality : Get Data Product Color By ID
    //Parameters : function parameters
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCLRGetDataByID($paData){
        try{
            $tClrCode   = $paData['FTClrCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                CLR.FTClrCode   AS rtClrCode,
                                CLR.FTClrRefValue AS rtClrIdColor,
                                CLR_L.FTClrName AS rtClrName,
                                CLR_L.FTClrRmk  AS rtClrRmk,
                                CLR.FTAgnCode   AS rtAgnCode,
                                AGNL.FTAgnName  AS rtAgnName
                            FROM TCNMPdtColor CLR
                            LEFT JOIN TCNMPdtColor_L CLR_L ON CLR.FTClrCode = CLR_L.FTClrCode AND CLR_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMAgency_L AGNL ON  CLR.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                            WHERE 1=1 AND CLR.FTClrCode = '$tClrCode' ";
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

    //Functionality : Checkduplicate Product Color
    //Parameters : function parameters
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMCLRCheckDuplicate($ptClrCode){
        $tSQL = "SELECT COUNT(CLR.FTClrCode) AS counts
                 FROM TCNMPdtColor CLR 
                 WHERE CLR.FTClrCode = '$ptClrCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product Product Color (TCNMPdtColor)
    //Parameters : function parameters
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCLRAddUpdateMaster($paDataPdtColor){
        try{
            // Update TCNMPdtColor
            $this->db->where('FTClrCode', $paDataPdtColor['FTClrCode']);
            $this->db->update('TCNMPdtColor',array(
                'FTClrRefValue' => $paDataPdtColor['FTClrRefValue'],
                'FDLastUpdOn'   => $paDataPdtColor['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataPdtColor['FTLastUpdBy'],
                'FDCreateOn'    => $paDataPdtColor['FDCreateOn'],
                'FTCreateBy'    => $paDataPdtColor['FTCreateBy'],
                'FTAgnCode'     => $paDataPdtColor['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Color Success',
                );
            }else{
                //Add TCNMPdtColor
                $this->db->insert('TCNMPdtColor', array(
                    'FTClrCode'     => $paDataPdtColor['FTClrCode'],
                    'FTClrRefValue' => $paDataPdtColor['FTClrRefValue'],
                    'FDCreateOn'    => $paDataPdtColor['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtColor['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtColor['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataPdtColor['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataPdtColor['FTAgnCode'],

                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Color',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Color.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Color (TCNMPdtColor_L)
    //Parameters : function parameters
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCLRAddUpdateLang($paDataPdtColor){
        try{
            //Update Pdt Color Lang
            $this->db->where('FNLngID', $paDataPdtColor['FNLngID']);
            $this->db->where('FTClrCode', $paDataPdtColor['FTClrCode']);
            $this->db->update('TCNMPdtColor_L',array(
                'FTClrName' => $paDataPdtColor['FTClrName'],
                'FTClrRmk'  => $paDataPdtColor['FTClrRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Color Lang Success.',
                );
            }else{
                //Add Pdt Color Lang
                $this->db->insert('TCNMPdtColor_L', array(
                    'FTClrCode' => $paDataPdtColor['FTClrCode'],
                    'FNLngID'   => $paDataPdtColor['FNLngID'],
                    'FTClrName' => $paDataPdtColor['FTClrName'],
                    'FTClrRmk'  => $paDataPdtColor['FTClrRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Color Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Color Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Color
    //Parameters : function parameters
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMCLRDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTClrCode', $paData['FTClrCode']);
            $this->db->delete('TCNMPdtColor');

            $this->db->where_in('FTClrCode', $paData['FTClrCode']);
            $this->db->delete('TCNMPdtColor_L');

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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtColor";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}