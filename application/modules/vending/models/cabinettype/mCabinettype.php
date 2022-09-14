<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCabinettype extends CI_Model {

    /**
     * Functionality : List Cabinettype
     * Parameters : Ajax Call View DataTable
     * Creator : 05/10/2018 Witsarut (Bell)
     * Last Modified : -
     * Return : Cabinettype Data
     * Return Type : array
     */
    public function FSaMCBNList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSQL    = "SELECT c.* FROM(
                            SELECT ROW_NUMBER() OVER(ORDER BY rtShtCode ASC) AS rtRowID, * 
                            FROM(
                                SELECT 
                                    CBN.FTShtCode    AS rtShtCode,
                                    CBNL.FTShtName   AS rtShtName,
                                    CBN.FTShtType    AS rtShtType,
                                    CBN.FNShtValue   AS rtShtValue,
                                    CBN.FNShtMin     AS rtShtMin,
                                    CBN.FNShtMax     AS rtShtMax,
                                    CBNL.FTShtRemark AS rtShtReMark
                            FROM [TVDMShopType] CBN WITH(NOLOCK)
                            LEFT JOIN [TVDMShopType_L] CBNL ON CBN.FTShtCode = CBNL.FTShtCode AND CBNL.FNLngID = $nLngID
                            WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (CBN.FTShtCode LIKE '%$tSearchList%'";
                $tSQL .= " OR CBNL.FTShtName  LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
               
                $oFoundRow  = $this->FSoMCBNGetPageAll($tSearchList,$paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'tSQL'          => $tSQL
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found'
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of Cabinettype
    //Parameters : function parameters
    //Creator :  05/10/2018 Witsarut (Bell)
    //Return : object Count All CardType
    //Return Type : Object
    public function FSoMCBNGetPageAll($ptSearchList,$ptLang){

       $nLngID  = $ptLang['FNLngID'];

        try{
            $tSQL = "SELECT COUNT (CBN.FTShtCode) AS counts
                     FROM [TVDMShopType] CBN WITH(NOLOCK)
                     LEFT JOIN [TVDMShopType_L] CBNL ON CBN.FTShtCode = CBNL.FTShtCode AND CBNL.FNLngID = $nLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && ($ptSearchList)){
                $tSQL .= " AND (CBN.FTShtCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR CBNL.FTShtName  LIKE '%$ptSearchList%')";
            }
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
        
    }


    
    //Functionality : Checkduplicate CardType
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMCBNCheckDuplicate($ptCbnCode){
        try{
            $tSQL = "SELECT COUNT(CBN.FTShtCode) AS counts
                    FROM TVDMShopType CBN WITH(NOLOCK)
                    WHERE CBN.FTShtCode = '$ptCbnCode' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->row_array();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update CardType (CabinetTYpe)
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCBNAddUpdateMaster($paData){
        try{
            // Update TVDMShopType
            $this->db->set('FTShtType'  , $paData['FTShtType']);
            $this->db->set('FNShtValue' , $paData['FNShtValue']);
            $this->db->set('FNShtMin'   , $paData['FNShtMin']);
            $this->db->set('FNShtMax'   , $paData['FNShtMax']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FDCreateOn' , $paData['FDCreateOn']);
            $this->db->set('FTCreateBy' , $paData['FTCreateBy']);
            $this->db->where('FTShtCode', $paData['FTShtCode']);
            $this->db->update('TVDMShopType');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CardType Success',
                );
            }else{
                // Add TVDMShopType
                $aResult   = array(
                    'FTShtCode'     => $paData['FTShtCode'],
                    'FTShtType'     => $paData['FTShtType'],
                    'FNShtValue'    => $paData['FNShtValue'],
                    'FNShtMin'      => $paData['FNShtMin'],
                    'FNShtMax'      => $paData['FNShtMax'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                );
                $this->db->insert('TVDMShopType',$aResult);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add CardType Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit CardType.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update CabinetType ()
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCBNAddUpdateLang($paData){
        try{
            $this->db->set('FTShtName' , $paData['FTShtName']);
            $this->db->set('FTShtRemark' , $paData['FTShtRemark']);
            $this->db->where('FTShtCode' , $paData['FTShtCode']);
            $this->db->update('TVDMShopType_L');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CardType Lang Success.',
                );
            }else{
                  //Add Pdt Brand Lang
                $aResult  = array(
                    'FTShtCode'   => $paData['FTShtCode'],
                    'FNLngID'     => $paData['FNLngID'],
                    'FTShtName'   => $paData['FTShtName'],
                    'FTShtRemark' => $paData['FTShtRemark'],
                );
                $this->db->insert('TVDMShopType_L',$aResult);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add CardType Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit CardType Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Get Data Cabinet By ID
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCBNGetDataByID($paData){
        try{
            $tShtCode  =  $paData['FTShtCode'];
            $nLngID    =  $paData['FNLngID'];

            $tSQL   = " SELECT 
                            CBN.FTShtCode    AS rtShtCode,
                            CBNL.FTShtName   AS rtShtName,
                            CBN.FTShtType    AS rtShtType,
                            CBN.FNShtValue   AS rtShtValue,
                            CBN.FNShtMin     AS rtShtMin,
                            CBN.FNShtMax     AS rtShtMax,
                            CBNL.FTShtRemark AS rtShtReMark
                        FROM TVDMShopType CBN
                        LEFT JOIN [TVDMShopType_L] CBNL ON CBN.FTShtCode = CBNL.FTShtCode AND CBNL.FNLngID = $nLngID
                        WHERE  1=1
                        AND CBN.FTShtCode = '$tShtCode' ";
            $oQuery  = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0 ){
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


    //Functionality : Delete Userlogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCBNDel($paData){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTShtCode',$paData['FTShtCode']);
            $this->db->delete('TVDMShopType');

            $this->db->where_in('FTShtCode',$paData['FTShtCode']);
            $this->db->delete('TVDMShopType_L');

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


    //Functionality : Get all row 
    //Parameters : -
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TVDMShopType";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 26/07/2019 Witsarut
    //Return : data
    //Return Type : Arra
    public function FSaMCBNDeleteMultiple($paDataDelete){
        try{

            $this->db->where('FTShtCode' ,$paDataDelete['FTShtCode']);
            $this->db->delete('TVDMShopType');

            $this->db->where('FTShtCode' ,$paDataDelete['FTShtCode']);
            $this->db->delete('TVDMShopType_L');

            if($this->db->affected_rows() > 0){
                //Success
                $aStatus   = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            }else{
                //Ploblem
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'cannot Delete Item.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
           
    }

}