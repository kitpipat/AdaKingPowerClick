<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtUnit extends CI_Model {

    //Functionality : list Product Unit
    //Parameters : function parameters
    //Creator :  13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMPUNList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSesAgnCode    = $paData['tSesAgnCode'];

            // Last Update : 15/02/2021 ปรับการหาจำนวนรายการทั้งหมด
            $tSQLHeader = "SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPunCode DESC) AS rtRowID,* FROM ( ";
            $tSQL       = " SELECT DISTINCT
                                PUN.FTPunCode   AS rtPunCode,
                                PUN_L.FTPunName AS rtPunName,
                                PUN.FDCreateOn,
                                PUN.FTAgnCode  AS rtAgnCode,
                                AGNL.FTAgnName AS rtAgnName
                            FROM [TCNMPdtUnit] PUN WITH(NOLOCK)
                            LEFT JOIN [TCNMPdtUnit_L]   PUN_L   WITH(NOLOCK) ON PUN.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $nLngID
                            LEFT JOIN [TCNMAgency_L]    AGNL    WITH(NOLOCK) ON PUN.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1=1 
                           ";

            if( $tSesAgnCode != '' ){
                // Last Update : 15/02/2021 Napat(Jame) เพิ่มดึงข้อมูลหน่วย center มาด้วย
                $tSQL .= " AND ( PUN.FTAgnCode = '$tSesAgnCode' OR ISNULL(PUN.FTAgnCode,'') = '' ) ";   
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PUN.FTPunCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR PUN_L.FTPunName COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSQL .= " OR LEFT(PUN.FTPunCode,1)   = '%$tSearchList%' " ;
                $tSQL .= " OR LEFT(PUN_L.FTPunName,1) = '%$tSearchList%' )" ;
            }
            
            $tSQLFooter = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";

            $tSQLMain = $tSQLHeader.$tSQL.$tSQLFooter;
            $tSQLSub  = $tSQL;

            // print_r($tSQL);
            $oQuery = $this->db->query($tSQLMain);
            if($oQuery->num_rows() > 0){
                $oQuerySub  = $this->db->query($tSQLSub);
                $aList      = $oQuery->result_array();
                // $oFoundRow  = $this->FSoMPUNGetPageAll($tSearchList,$nLngID, $tSesAgnCode);
                // $nFoundRow  = $oFoundRow[0]->counts;
                $nFoundRow  = $oQuerySub->num_rows();
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => $aRowLen,
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of Product Unit
    //Parameters : function parameters
    //Creator :  13/09/2018 Wasin
    //Return : object Count All Product Unit
    //Return Type : Object 
    // public function FSoMPUNGetPageAll($ptSearchList,$ptLngID, $ptSesAgnCode){
    //     try{
    //         $tSQL = "SELECT COUNT (PUN.FTPunCode) AS counts
    //                     FROM [TCNMPdtUnit] PUN
    //                 LEFT JOIN [TCNMPdtUnit_L]  PUN_L ON PUN.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $ptLngID
    //                 LEFT JOIN [TCNMAgency_L] AGNL ON PUN.FTAgnCode  = AGNL.FTAgnCode AND AGNL.FNLngID = $ptLngID
    //                 WHERE 1=1 ";

    //         if($ptSesAgnCode != ''){
    //             $tSQL .= "AND PUN.FTAgnCode = $ptSesAgnCode";   
    //         }

    //         if(isset($ptSearchList) && !empty($ptSearchList)){
    //             $tSQL .= " AND (PUN.FTPunCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
    //             $tSQL .= " OR PUN_L.FTPunName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
    //         }
    //         $oQuery = $this->db->query($tSQL);
    //         if ($oQuery->num_rows() > 0) {
    //             return $oQuery->result();
    //         }else{
    //             return false;
    //         }
    //     }catch(Exception $Error){
    //         echo $Error;
    //     }
    // }

    //Functionality : Get Data Product Unit By ID
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMPUNGetDataByID($paData){
        try{
            $tPunCode   = $paData['FTPunCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                PUN.FTPunCode AS rtPunCode,
                                PUN_L.FTPunName AS rtPunName,
                                PUN.FTAgnCode  AS rtAgnCode,
                                AGNL.FTAgnName AS rtAgnName
                            FROM TCNMPdtUnit PUN 
                            LEFT JOIN TCNMPdtUnit_L PUN_L ON PUN.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $nLngID
                            LEFT JOIN [TCNMAgency_L] AGNL ON PUN.FTAgnCode  = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1 = 1 
                            AND PUN.FTPunCode = '$tPunCode' ";
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

    //Functionality : Checkduplicate Product Unit 
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMPUNCheckDuplicate($ptPunCode){
        $tSQL = "SELECT COUNT(PUN.FTPunCode) AS counts
                 FROM TCNMPdtUnit PUN 
                 WHERE PUN.FTPunCode = '$ptPunCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update ProductUnit (TCNMPdtUnit)
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPUNAddUpdateMaster($paDataPdtUnit){
        // $tSQL = "INSERT INTO TCNMPdtUnit (FTPunCode,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy)
        //          VALUES('".$paDataPdtUnit["FTPunCode"]."',
        //                 '".date("Y-m-d H:i:s")."',
        //                 '".date("Y-m-d H:i:s")."',
        //                 '".$this->session->userdata("tSesUsername")."',
        //                 '".$this->session->userdata("tSesUsername")."')";
        // $this->db->query($tSQL);
        try{
            // Update TCNMPdtUnit
            $this->db->where('FTPunCode', $paDataPdtUnit['FTPunCode']);
            $this->db->update('TCNMPdtUnit',array(
                'FTAgnCode'     => $paDataPdtUnit['FTAgnCode'],
                'FDLastUpdOn' => $paDataPdtUnit['FDLastUpdOn'],
                'FTLastUpdBy' => $paDataPdtUnit['FTLastUpdBy'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ProductUnit Success',
                );
            }else{
                //Add TCNMPdtUnit
                $this->db->insert('TCNMPdtUnit', array(
                    'FTPunCode'     => $paDataPdtUnit['FTPunCode'],
                    'FDCreateOn'    => $paDataPdtUnit['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtUnit['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtUnit['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataPdtUnit['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataPdtUnit['FTAgnCode'],
                    
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add ProductUnit Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit ProductUnit.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update ProductUnit Lang (TCNMPdtUnit_L)
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Update : 1/04/2019 Pap
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPUNAddUpdateLang($paDataPdtUnit){
        // $tSQL = "INSERT INTO TCNMPdtUnit_L (FTPunCode,FNLngID,FTPunName)
        //          VALUES('".$paDataPdtUnit["FTPunCode"]."',
        //                 '".$this->session->userdata("tLangID")."',
        //                 '".$paDataPdtUnit["FTPunName"]."')";
        // $this->db->query($tSQL);
        try{
            //Update Pdt Unit Lang
            $this->db->where('FNLngID', $paDataPdtUnit['FNLngID']);
            $this->db->where('FTPunCode', $paDataPdtUnit['FTPunCode']);
            $this->db->update('TCNMPdtUnit_L',array('FTPunName' => $paDataPdtUnit['FTPunName']));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Unit Lang Success.',
                );
            }else{
                //Add Pdt Unit Lang
                $this->db->insert('TCNMPdtUnit_L', array(
                    'FTPunCode' => $paDataPdtUnit['FTPunCode'],
                    'FNLngID'   => $paDataPdtUnit['FNLngID'],
                    'FTPunName' => $paDataPdtUnit['FTPunName']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Unit Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Unit Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete ProductUnit
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Update : 1/04/2019 Pap
    //Return : 
    //Return Type : array
    public function FSaMPUNDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTPunCode', $paData['FTPunCode']);
            $this->db->delete('TCNMPdtUnit');

            $this->db->where_in('FTPunCode', $paData['FTPunCode']);
            $this->db->delete('TCNMPdtUnit_L');

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
    public function FSnMPUNGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtUnit";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }



































































































}