<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mMerpdtgroup extends CI_Model {

    //Functionality : list Product Group
    //Parameters : function parameters
    //Creator :  26/07/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMMGPList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tMerCode       = $paData['tMerCode'];
            $tSQL           = "SELECT c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY rtFDCreateOn DESC , rtMgpCode DESC) AS rtRowID,* FROM
                                        (SELECT DISTINCT
                                                MGP.FTMgpCode  AS rtMgpCode,
						                        MGPL.FTMgpName AS rtMgpName,
                                                MGP.FDCreateOn AS rtFDCreateOn
                                        FROM [TCNMMerPdtGrp] MGP
                                        LEFT JOIN [TCNMMerPdtGrp_L]  MGPL ON MGP.FTMgpCode = MGPL.FTMgpCode AND MGPL.FNLngID = '$nLngID'
                                        WHERE 1=1  AND MGP.FTMerCode = '$tMerCode' ";
            if($tSearchList != ""){
                $tSQL .= " AND (MGP.FTMgpCode COLLATE THAI_BIN LIKE '%$tSearchList%'  
                           OR MGPL.FTMgpName COLLATE THAI_BIN LIKE '%$tSearchList%' )
                ";
            }
            
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMMGPGetPageAll($tSearchList,$nLngID,$tMerCode );
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

    //Functionality : All Page Of Product Group
    //Parameters : function parameters
    //Creator :  26/07/2019 Saharat(Golf)
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMMGPGetPageAll($ptSearchList,$ptLngID,$tMerCode){
        try{ 
            $tSQL = "SELECT COUNT (MGP.FTMgpCode) AS counts
                     FROM [TCNMMerPdtGrp] MGP
                     LEFT JOIN [TCNMMerPdtGrp_L]  MGPL ON MGP.FTMgpCode = MGPL.FTMgpCode 
                     AND MGPL.FNLngID = $ptLngID
                     WHERE 1=1 
                     AND MGP.FTMerCode = '$tMerCode' ";
            if($ptSearchList != ""){
                $tSQL .= "AND (MGP.FTMgpCode COLLATE THAI_BIN LIKE '$ptSearchList'";
                $tSQL .= " OR MGPL.FTMgpName  COLLATE THAI_BIN LIKE '$ptSearchList')";
            }
         
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return FALSE;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Data Product Group By ID
    //Parameters : function parameters
    //Creator : 30/07/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMMGPGetDataByID($paData){
        try{
            $tMgpCode   = $paData['FTMgpCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT  MGP.FTMgpCode,
                                    MGP.FTMerCode,
                                    MGPL.FTMgpName
                            FROM TCNMMerPdtGrp MGP
                            LEFT JOIN TCNMMerPdtGrp_L MGPL ON MGP.FTMgpCode = MGPL.FTMgpCode AND MGPL.FNLngID =  $nLngID
                            WHERE 1=1 AND MGP.FTMgpCode = '$tMgpCode' " ;
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
            $Error;
        }
    }

    //Functionality : Get Data Parent (Level ChainCode and ChainName)
    //Parameters : function parameters
    //Creator : 18/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMPGPGetDataParent($ptPgpCode,$pnLngID){
        try{
            $tSQL = "SELECT
                        PGP.FTPgpCode           AS rtPgpCode,
                        PGP.FNPgpLevel          AS rtPgpLevel,
                        PGP.FTPgpChain          AS rtPgpChain,
                        PGP_L.FTPgpChainName    AS rtPgpChainName
                     FROM TCNMPdtGrp PGP
                     LEFT JOIN TCNMPdtGrp_L PGP_L ON  PGP.FTPgpChain = PGP_L.FTPgpChain AND PGP_L.FNLngID = $pnLngID
                     WHERE PGP.FTPgpCode = '$ptPgpCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aDetail = $oQuery->row_array();
            }else{
                $aDetail = FALSE;
            }
            return $aDetail;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Checkduplicate Product Group 
    //Parameters : function parameters
    //Creator : 26/07/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSnMMGPCheckDuplicate($ptMgpCode){
        $tSQL = "SELECT COUNT(FTMgpCode)AS counts
                 FROM TCNMMerPdtGrp
                 WHERE FTMgpCode = '$ptMgpCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Update Product Group (TCNMPdtGrp)
    //Parameters : function parameters
    //Creator : 18/09/2018 Saharat(Golf)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMMGPAddUpdateMaster($paDataPdtGroup){
        try{
            // Update TCNMMerPdtGrp
            $this->db->where('FTMgpCode', $paDataPdtGroup['FTMgpCode']);
            $this->db->update('TCNMMerPdtGrp',array(
                'FDLastUpdOn'   => $paDataPdtGroup['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataPdtGroup['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Group Success',
                );
            }else{
                $this->db->insert('TCNMMerPdtGrp', array(
                    'FTMgpCode'     => $paDataPdtGroup['FTMgpCode'],
                    'FTMerCode'    => $paDataPdtGroup['FTMerCode'],
                    'FDCreateOn'    => $paDataPdtGroup['FDCreateOn'],
                    'FTLastUpdBy'   => $paDataPdtGroup['FTLastUpdBy'],
                ));  
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Group Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Group.',
                    );
                }
                
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Group Lang (TCNMPdtGrp_L)
    //Parameters : function parameters
    //Creator : 18/09/2018 Saharat(Golf)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMMGPAddUpdateLang($paDataPdtGroup){
        try{
            $this->db->where('FTMgpCode', $paDataPdtGroup['FTMgpCode']);
            $this->db->update('TCNMMerPdtGrp_L',array(
                'FTMgpName'    => $paDataPdtGroup['FTMgpName'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Product Group Lang Success',
                );
            }else{
                $this->db->insert('TCNMMerPdtGrp_L', array(
                    'FTMgpName'        => $paDataPdtGroup['FTMgpName'],
                    'FTMgpCode'        => $paDataPdtGroup['FTMgpCode'],
                    'FNLngID'          => $paDataPdtGroup['FNLngID'],

                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Group Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Group.',
                    );
                }
               
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Chain For Delete
    //Parameters : function parameters
    //Creator : 01/10/2018 Saharat(Golf)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMGetChainForDelete($paDataMaster){
        try{
            $aDataWhere = $paDataMaster['FTMgpCode'];
            $aDataReturn = $this->db->where_in('FTMgpCode', $aDataWhere)->get('TCNMMerPdtGrp')->result_array();
            return $aDataReturn;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Group
    //Parameters : function parameters
    //Creator : 19/09/2018 Saharat(Golf)
    //Return : Status Delete
    //Return Type : array
    public function FSaMMgpDelAll($paData){
        try{
            $nLangID = $this->session->userdata("tLangEdit");
            $this->db->trans_begin();
            foreach($paData AS $nKeys => $aValue){
                //Delete Table Main
                $this->db->where_in('FTMgpCode',$aValue['FTMgpCode']);
                $this->db->delete('TCNMMerPdtGrp');

                //Delete Table Lang
                $this->db->where_in('FTMgpCode',$aValue['FTMgpCode']);
                $this->db->where('FNLngID',$nLangID);
                $this->db->delete('TCNMMerPdtGrp_L');
            }
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
    //Creator : 30/07/2019 Saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMPGPGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMMerPdtGrp";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }




















}