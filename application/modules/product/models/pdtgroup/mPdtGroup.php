<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtGroup extends CI_Model {

    //Functionality : list Product Group
    //Parameters : function parameters
    //Creator :  18/09/2018 Wasin
    //Last Update : 09/06/2020 Napat(Jame) เพิ่มเงื่อนไขการดึงรูปภาพ TIP.FTImgTable='TCNMPdtGrp'
    //Return : data
    //Return Type : Array
    public function FSaMPGPList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode = $paData['tSesAgnCode'];

            $tSQL           = "SELECT c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPgpCode DESC) AS rtRowID,* FROM
                                        (SELECT DISTINCT
                                            PGP.FTPgpCode           AS rtPgpCode,
                                            PGP.FNPgpLevel          AS rtPgpLevel,
                                            PGP.FTPgpParent         AS rtPgpParent,
                                            PGP.FTPgpChain          AS rtPgpChain,
                                            PGP_L.FTPgpName         AS rtPgpName,
                                            PGP_L.FTPgpChainName    AS rtPgpChainName,
                                            TIP.FTImgObj            AS rtFTImgObj,
                                            PGP.FDCreateOn,
                                            PGP.FTAgnCode           AS rtAgnCode,
                                            AGNL.FTAgnName          AS rtAgnName
                                        FROM [TCNMPdtGrp] PGP
                                        LEFT JOIN [TCNMPdtGrp_L]  PGP_L ON PGP.FTPgpChain = PGP_L.FTPgpChain AND PGP_L.FNLngID = $nLngID
                                        LEFT JOIN TCNMImgPdt TIP ON PGP.FTPgpCode = TIP.FTImgRefID AND TIP.FTImgTable='TCNMPdtGrp'
                                        LEFT JOIN TCNMAgency_L AGNL ON  PGP.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                                        WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= " AND PGP.FTAgnCode = $tSesAgnCode"; 
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                // $tSQL .= " AND (PGP.FTPgpCode LIKE '$tSearchList'";
                // $tSQL .= " OR PGP.FTPgpChain  LIKE '%$tSearchList%'";
                // $tSQL .= " OR PGP_L.FTPgpName  LIKE '%$tSearchList%'";
                // $tSQL .= " OR PGP_L.FTPgpChainName  LIKE '%$tSearchList%')";
                $tSQL .= " AND PGP.FTPgpCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR PGP.FTPgpChain COLLATE THAI_BIN LIKE '%$tSearchList%'
                    OR PGP_L.FTPgpName COLLATE THAI_BIN LIKE '%$tSearchList%' OR PGP_L.FTPgpChainName COLLATE THAI_BIN LIKE '%$tSearchList%' 
                ";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
       
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPGPGetPageAll($tSearchList,$nLngID,$tSesAgnCode);
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
    //Creator :  18/09/2018 Wasin
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMPGPGetPageAll($ptSearchList,$ptLngID,$tSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (PGP.FTPgpCode) AS counts
                     FROM [TCNMPdtGrp] PGP
                     LEFT JOIN [TCNMPdtGrp_L]  PGP_L ON PGP.FTPgpChain = PGP_L.FTPgpChain AND PGP_L.FNLngID = $ptLngID
                     LEFT JOIN TCNMAgency_L AGNL ON  PGP.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $ptLngID
                     WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= " AND PGP.FTAgnCode = $tSesAgnCode";
            }

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PGP.FTPgpCode LIKE '$ptSearchList'";
                $tSQL .= " OR PGP.FTPgpChain  LIKE '$ptSearchList'";
                $tSQL .= " OR PGP_L.FTPgpName  LIKE '%$ptSearchList%'";
                $tSQL .= " OR PGP_L.FTPgpChainName  LIKE '%$ptSearchList%')";
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
    //Creator : 18/09/2018 Wasin
    //Last Update : 09/06/2020 Napat(Jame) เพิ่มเงื่อนไขการดึงรูปภาพ TIP.FTImgTable='TCNMPdtGrp'
    //Return : data
    //Return Type : Array
    public function FSaMPGPGetDataByID($paData){
        try{
            $tPgpCode   = $paData['FTPgpCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT
                                aDataPgpHD.*,
                                aDataPgpParent.FTPgpCode        AS rtPgpParentCode,
                                aDataPgpParent.FTPgpChainName	AS rtPgpParentName
                            FROM (SELECT DISTINCT
                                    PGP.FTPgpCode           AS rtPgpCode,
                                    PGP.FNPgpLevel          AS rtPgpLevel,
                                    PGP.FTPgpChain          AS rtPgpChain,
                                    PGP_L.FTPgpName         AS rtPgpName,
                                    PGP_L.FTPgpChainName    AS rtPgpChainName,
                                    PGP_L.FTPgpRmk          AS rtPgpRmk,
                                    PGP.FTPgpParent         AS rtPgpParent,
                                    TIP.FTImgObj            AS rtFTImgObj,
                                    PGP.FTAgnCode           AS rtAgnCode,
                                    AGNL.FTAgnName          AS rtAgnName
                                 FROM TCNMPdtGrp PGP
                                 LEFT JOIN TCNMPdtGrp_L PGP_L ON PGP.FTPgpChain = PGP_L.FTPgpChain AND PGP_L.FNLngID = $nLngID
                                 LEFT JOIN TCNMImgPdt TIP ON PGP.FTPgpCode = TIP.FTImgRefID AND TIP.FTImgTable='TCNMPdtGrp'
                                 LEFT JOIN TCNMAgency_L AGNL ON  PGP.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                                 WHERE PGP.FTPgpCode = '$tPgpCode'
                                 ) AS aDataPgpHD
                            LEFT JOIN ( SELECT 
                                            TCNMPdtGrp.FTPgpCode,
                                            TCNMPdtGrp.FTPgpChain,
                                            TCNMPdtGrp_L.FTPgpChainName 
                                        FROM TCNMPdtGrp
                                        LEFT JOIN TCNMPdtGrp_L ON TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = $nLngID ) AS aDataPgpParent
                            ON aDataPgpHD.rtPgpParent = aDataPgpParent.FTPgpCode ";

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
    //Creator : 18/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMPGPCheckDuplicate($ptPgpCode){
        try{
            $tSQL = "SELECT COUNT(PGP.FTPgpCode) AS counts
                 FROM TCNMPdtGrp PGP 
                 WHERE PGP.FTPgpCode = '$ptPgpCode' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->row_array();
            }else{
                return FALSE;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Group (TCNMPdtGrp)
    //Parameters : function parameters
    //Creator : 18/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPGPAddUpdateMaster($paDataPdtGroup){
        try{
            // Update TCNMPdtGrp
            $this->db->where('FTPgpCode', $paDataPdtGroup['FTPgpCode']);
            $this->db->update('TCNMPdtGrp',array(
                'FNPgpLevel'    => $paDataPdtGroup['FNPgpLevel'],
                'FTPgpParent'   => $paDataPdtGroup['FTPgpParent'],
                'FTPgpChain'    => $paDataPdtGroup['FTPgpChain'],
                'FDLastUpdOn'   => $paDataPdtGroup['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataPdtGroup['FTLastUpdBy'],
                'FTAgnCode'     => $paDataPdtGroup['FTAgnCode'],
            ));
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Group Success',
                );
            }else{
                $this->db->insert('TCNMPdtGrp', array(
                    'FTPgpCode'     => $paDataPdtGroup['FTPgpCode'],
                    'FNPgpLevel'    => $paDataPdtGroup['FNPgpLevel'],
                    'FTPgpParent'   => $paDataPdtGroup['FTPgpParent'],
                    'FTPgpChain'    => $paDataPdtGroup['FTPgpChain'],
                    'FDCreateOn'    => $paDataPdtGroup['FDCreateOn'],
                    'FTLastUpdBy'   => $paDataPdtGroup['FTLastUpdBy'],
                    'FDLastUpdOn'   => $paDataPdtGroup['FDLastUpdOn'],
                    'FTCreateBy'    => $paDataPdtGroup['FTCreateBy'],
                    'FTAgnCode'     => $paDataPdtGroup['FTAgnCode'],
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
    //Creator : 18/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPGPAddUpdateLang($paDataPdtGroup){
        try{
            $this->db->where('FTPgpChain', $paDataPdtGroup['FTPgpChainOld']);
            $this->db->where('FNLngID', $this->session->userdata("tLangID"));
            $this->db->update('TCNMPdtGrp_L',array(
                'FTPgpChain'    => $paDataPdtGroup['FTPgpChain'],
                'FTPgpName'   => $paDataPdtGroup['FTPgpName'],
                'FTPgpChainName'   => $paDataPdtGroup['FTPgpChainName'],
                'FTPgpRmk'   => $paDataPdtGroup['FTPgpRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Product Group Lang Success',
                );
                
            }else{
                //Add New Product Group Lang
                $this->db->insert('TCNMPdtGrp_L', array(
                    'FTPgpChain'        => $paDataPdtGroup['FTPgpChain'],
                    // 'FNPgpLevel'        => $paDataPdtGroup['FNPgpLevel'],
                    'FNLngID'           => $paDataPdtGroup['FNLngID'],
                    'FTPgpName'         => $paDataPdtGroup['FTPgpName'],
                    'FTPgpChainName'    => $paDataPdtGroup['FTPgpChainName'],
                    'FTPgpRmk'          => $paDataPdtGroup['FTPgpRmk'],
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
    //Creator : 01/10/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMGetChainForDelete($paDataMaster){
        try{
            $aDataWhere = $paDataMaster['FTPgpCode'];
            $aDataReturn = $this->db->where_in('FTPgpCode', $aDataWhere)->get('TCNMPdtGrp')->result_array();
            return $aDataReturn;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Group
    //Parameters : function parameters
    //Creator : 19/09/2018 Wasin
    //Return : Status Delete
    //Return Type : array
    public function FSaMPGPDelAll($paData){
        try{
            $nLangID = $this->session->userdata("tLangEdit");
            $this->db->trans_begin();
            foreach($paData AS $nKeys => $aValue){
                //Delete Table Main
                $this->db->where('FTPgpChain',$aValue['FTPgpChain']);
                $this->db->delete('TCNMPdtGrp');
                //Delete Table Lang
                $this->db->where('FTPgpChain',$aValue['FTPgpChain']);
                $this->db->where('FNLngID',$nLangID);
                $this->db->delete('TCNMPdtGrp_L');
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
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMPGPGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtGrp";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }




















}