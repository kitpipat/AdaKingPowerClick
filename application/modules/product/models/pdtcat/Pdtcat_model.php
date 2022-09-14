<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Pdtcat_model extends CI_Model {

    //Functionality : list Product Unit
    //Parameters : function parameters
    //Creator :  13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMCATList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSesAgnCode    = $paData['tSesAgnCode'];
            $arrayName = array('0' => 1,'1' => 2,'2' => 3,'3' => 4,'4' => 5);
            $tCatCat         =  $arrayName[$paData['tCatCat']];
            if ($tSesAgnCode=="") {
              $tConditionAgn = "1=1";
            }else {
              $tConditionAgn = "CatInfo.FTAgnCode ='' OR CatInfo.FTAgnCode ='$tSesAgnCode'";
            }
            $tSQLHeader = "SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , tCatCode DESC) AS rtRowID,* FROM ( ";
            $tSQL = "SELECT DISTINCT
                      CatInfo.FTCatCode AS tCatCode,
                      CatInfo.FDCreateOn,
                      CatInfo_L.FTCatName AS tCatName,
                      CatInfo.FNCatLevel
                     FROM TCNMPdtCatInfo CatInfo
                     LEFT JOIN [TCNMPdtCatInfo_L]   CatInfo_L
                     WITH(NOLOCK) ON CatInfo.FTCatCode = CatInfo_L.FTCatCode AND CatInfo_L.FNLngID = $nLngID AND CatInfo.FNCatLevel = CatInfo_L.FNCatLevel
                     WHERE ($tConditionAgn) AND CatInfo.FNCatLevel = '$tCatCat' AND CatInfo_L.FNCatLevel = '$tCatCat'";

                     if(isset($tSearchList) && !empty($tSearchList)){
                         $tSQL .= " AND (CatInfo_L.FTCatName COLLATE THAI_BIN LIKE '%$tSearchList%' OR CatInfo.FTCatCode COLLATE THAI_BIN LIKE '%$tSearchList%')";
                     }

            $tSQLFooter = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
            $tSQLMain = $tSQLHeader.$tSQL.$tSQLFooter;
            //echo $tSQLMain;
            $tSQLSub  = $tSQL;
            $oQuery = $this->db->query($tSQLMain);
            if($oQuery->num_rows() > 0){
                $oQuerySub  = $this->db->query($tSQLSub);
                $aList      = $oQuery->result_array();
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
    // public function FSoMCATGetPageAll($ptSearchList,$ptLngID, $ptSesAgnCode){
    //     try{
    //         $tSQL = "SELECT COUNT (CAT.FTCatCode) AS counts
    //                     FROM [TCNMPdtCat] CAT
    //                 LEFT JOIN [TCNMPdtCat_L]  CAT_L ON CAT.FTCatCode = CAT_L.FTCatCode AND CAT_L.FNLngID = $ptLngID
    //                 LEFT JOIN [TCNMAgency_L] AGNL ON CAT.FTAgnCode  = AGNL.FTAgnCode AND AGNL.FNLngID = $ptLngID
    //                 WHERE 1=1 ";

    //         if($ptSesAgnCode != ''){
    //             $tSQL .= "AND CAT.FTAgnCode = $ptSesAgnCode";
    //         }

    //         if(isset($ptSearchList) && !empty($ptSearchList)){
    //             $tSQL .= " AND (CAT.FTCatCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
    //             $tSQL .= " OR CAT_L.FTCatName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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
    // Array (
    //   [FTAgnCode] =>
    //   [FTCatCode] => ClsCode001
    //   [FNCatLevel] => 4
    //   [FTCatParent] =>
    //   [FTCatStaUse] => 1
    //   [FDLastUpdOn] => 2021-07-05 11:46:48.340
    //   [FTLastUpdBy] => MQAdaLink
    //   [FDCreateOn] => 2021-07-05 11:44:56.020
    //   [FTCreateBy] => MQAdaLink
    //   )

     // Array (
     //   [FTCatCode] => ClsCode001
     //   [FNCatLevel] => 4
     //   [FNLngID] => 1
     //   [FTCatName] => ClsName001
     //   [FTCatRmk] => )
    public function FSaMCATGetDataByID($paData){
        try{
            $tCatCode   = $paData['FTCatCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT
                                CatInfo.FTCatCode AS rtCatCode,
                                CatInfo.FNCatLevel AS rtCatLevel,
                                CatInfo.FTCatParent AS rtCatParent,
                                CatInfo.FTAgnCode AS rtAgnCode,
                                CatInfo.FTCatStaUse AS rtCatStaUse,
                                CatInfo_L.FTCatName AS rtCatName,
                                CatInfo_L.FTCatRmk AS rtCatRmk,
                                AGNL.FTAgnName AS rtAgnName
                            FROM TCNMPdtCatInfo CatInfo
                            LEFT JOIN TCNMPdtCatInfo_L CatInfo_L ON CatInfo.FTCatCode = CatInfo_L.FTCatCode AND CatInfo_L.FNLngID = $nLngID
                            LEFT JOIN [TCNMAgency_L] AGNL ON CatInfo.FTAgnCode  = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1 = 1
                            AND CatInfo.FTCatCode = '$tCatCode' ";
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

    public function FSaMCATGetDataParByID($paData){
        try{
            $tCatCode   = $paData['FTCatCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT
                                CatInfo.FTCatCode AS rtCatCode,
                                CatInfo_L.FTCatName AS rtCatName
                            FROM TCNMPdtCatInfo CatInfo
                            LEFT JOIN TCNMPdtCatInfo_L CatInfo_L ON CatInfo.FTCatCode = CatInfo_L.FTCatCode AND CatInfo_L.FNLngID = $nLngID
                            WHERE 1 = 1
                            AND CatInfo.FTCatCode = '$tCatCode' ";
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
    public function FSnMCATCheckDuplicate($ptCatCode){
        $tSQL = "SELECT COUNT(CAT.FTCatCode) AS counts
                 FROM TCNMPdtCatInfo CAT
                 WHERE CAT.FTCatCode = '$ptCatCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update ProductUnit (TCNMPdtCat)
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCATAddUpdateMaster($paDataPdtCat){
        try{
            // Update TCNMPdtCat
            $this->db->where('FTCatCode', $paDataPdtCat['FTCatCode']);
            $this->db->update('TCNMPdtCatInfo',array(
                'FTCatParent'     => $paDataPdtCat['FTCatParent'],
                'FTCatStaUse'     => $paDataPdtCat['FTCatStaUse'],
                'FTAgnCode'     => $paDataPdtCat['FTAgnCode'],
                'FDLastUpdOn' => $paDataPdtCat['FDLastUpdOn'],
                'FTLastUpdBy' => $paDataPdtCat['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ProductUnit Success',
                );
            }else{
                //Add TCNMPdtCatInfo
                $this->db->insert('TCNMPdtCatInfo', array(
                    'FTCatCode'     => $paDataPdtCat['FTCatCode'],
                    'FNCatLevel'    => $paDataPdtCat['FNCatLevel'],
                    'FTCatParent'   => $paDataPdtCat['FTCatParent'],
                    'FTCatStaUse'   => $paDataPdtCat['FTCatStaUse'],
                    'FDCreateOn'    => $paDataPdtCat['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtCat['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtCat['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataPdtCat['FTLastUpdBy'],
                    'FTAgnCode'     => $paDataPdtCat['FTAgnCode']
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

    //Functionality : Update ProductUnit Lang (TCNMPdtCat_L)
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Update : 1/04/2019 Pap
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCATAddUpdateLang($paDataPdtCat){
        try{
            //Update Pdt Unit Lang
            $this->db->where('FNLngID', $paDataPdtCat['FNLngID']);
            $this->db->where('FTCatCode', $paDataPdtCat['FTCatCode']);
            $this->db->update('TCNMPdtCatInfo_L',array('FTCatName' => $paDataPdtCat['FTCatName'],'FTCatRmk' => $paDataPdtCat['FTCatRmk']));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Unit Lang Success.',
                );
            }else{
                //Add Pdt Unit Lang
                $this->db->insert('TCNMPdtCatInfo_L', array(
                    'FTCatCode' => $paDataPdtCat['FTCatCode'],
                    'FNLngID'   => $paDataPdtCat['FNLngID'],
                    'FTCatName' => $paDataPdtCat['FTCatName'],
                    'FNCatLevel' => $paDataPdtCat['FNCatLevel'],
                    'FTCatRmk' => $paDataPdtCat['FTCatRmk']
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
    public function FSaMCATDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTCatCode', $paData['FTCatCode']);
            $this->db->delete('TCNMPdtCatInfo');

            $this->db->where_in('FTCatCode', $paData['FTCatCode']);
            $this->db->delete('TCNMPdtCatInfo_L');

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
    public function FSnMCATGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtCatInfo";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }



































































































}
