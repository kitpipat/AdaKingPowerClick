<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCourierMan extends CI_Model {

    //Functionality : list CourierGrp
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut(Bell)
    //update  : 10/08/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMCurmanList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtManCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        Curman.FTManCardEmp   AS rtManCode,
                                        Curman_L.FTManName    AS rtManName,
                                        Curman.FTManSex       AS rtManSex,
                                        Cur_L.FTCryName       AS rtCryName,
                                        Curman.FTManTel       AS rtManTel,
                                        Curman.FTCryCode      AS rtCryCode,
                                        Curman.FTManCardID    AS rtID,
                                        Curman.FTManStaActive AS rtStaActive,
                                        IMG.FTImgObj
                                    FROM [TCNMCourieMan] Curman WITH(NOLOCK)
                                    LEFT JOIN [TCNMCourieMan_L] Curman_L WITH(NOLOCK) ON Curman.FTCryCode = Curman_L.FTCryCode AND Curman.FTManCardID = Curman_L.FTManCardID AND Curman_L.FNLngID = $nLngID 
                                    LEFT JOIN [TCNMCourier_L] Cur_L WITH(NOLOCK) ON Curman.FTCryCode = Cur_L.FTCryCode AND Cur_L.FNLngID = $nLngID
                                    LEFT JOIN [TCNMImgPerson] IMG WITH(NOLOCK) ON Curman.FTCryCode + Curman.FTManCardID = IMG.FTImgRefID AND IMG.FTImgTable = 'TCNMCourieMan'
                                    WHERE 1=1 ";

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND Curman.FTManCardEmp COLLATE THAI_BIN LIKE '%$tSearchList%'  OR Curman_L.FTManName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";


            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMCpgGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of CourierGrp
    //Parameters : function parameters
    //Creator :  21/09/2018 Witsarut (Bell)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMCpgGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (Curman.FTCryCode) AS counts
                     FROM [TCNMCourieMan] Curman
                     LEFT JOIN [TCNMCourieMan_L]  Curman_L ON Curman.FTCryCode = Curman_L.FTCryCode AND Curman.FTManCardID = Curman_L.FTManCardID
                     AND Curman_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (Curman.FTCryCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR Curman_L.FTManName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data CourierMan By ID
    //Parameters : function parameters
    //Creator : 11/0/2019 Sarun
    //Return : data
    //Return Type : Array
    public function FSaMCurGetDataByID($paData){
        try{
            $tCryCode   = $paData['FTCryCode'];
            $tID        = $paData['FTManCardID'];
            $nLngID     = $paData['FNLngID'];
            $tRef       = $tCryCode.$tID;
            // $tSQL       = " SELECT 
            //                     Crm.FTCryCode     AS rtCryCode,
            //                     Crm.FTManCardID   AS rtCryManID,
            //                     Crm.FTManTel      AS rtCryTel,
            //                     Crm.FTManCardEmp   AS rtCryManCard,
            //                     Crm.FTManSex      AS rtCrySex,
            //                     Crm.FDManDob      AS rtCryDob,
            //                     Crm.FTManStaActive      AS rtCryStaActive,
            //                     Crm_L.FTManName AS rtCryManName,
            //                     Crm_L.FTCryRmk  AS rtCryRmk,
            //                     Cur_L.FTCryName AS rtCryName,
            //                     IMGO.FTImgObj       AS rtImgObj
            //                 FROM TCNMCourieMan Crm
            //                 LEFT JOIN TCNMCourieMan_L Crm_L ON Crm.FTCryCode = Crm_L.FTCryCode 
            //                 AND Crm.FTManCardID = Crm_L.FTManCardID 
            //                 AND Crm_L.FNLngID = $nLngID 
            //                 LEFT JOIN TCNMCourier_L Cur_L ON Crm.FTCryCode = Cur_L.FTCryCode 
            //                 LEFT JOIN [TCNMImgPerson] IMGO ON IMGO.FTImgRefID = Crm.FTCryCode+Crm.FTManCardID AND IMGO.FTImgTable = 'TCNMCourieMan'
            //                 WHERE 1=1 AND Crm.FTCryCode = '$tCryCode' AND Crm.FTManCardID = '$tID'";



            $tSQL = "SELECT C.*, CmImg.FTImgObj AS rtImgObj FROM (
                SELECT Crm.FTCryCode AS rtCryCode, 
                Crm.FTManCardID AS rtCryManID, Crm.FTManTel AS rtCryTel, 
                Crm.FTManCardEmp AS rtCryManCard, 
                Crm.FTManSex AS rtCrySex, Crm.FDManDob AS rtCryDob, 
                Crm.FTManStaActive AS rtCryStaActive, 
                Crm_L.FTManName AS rtCryManName, 
                Crm_L.FTCryRmk AS rtCryRmk, Cur_L.FTCryName AS rtCryName,
                Crm.FTCryCode+Crm.FTManCardID   AS FTImgRefID_Man
                FROM TCNMCourieMan Crm
                LEFT JOIN TCNMCourieMan_L Crm_L ON Crm.FTCryCode = Crm_L.FTCryCode AND Crm.FTManCardID = Crm_L.FTManCardID AND Crm_L.FNLngID = $nLngID 
                LEFT JOIN TCNMCourier_L Cur_L ON Crm.FTCryCode = Cur_L.FTCryCode 
                
                WHERE 1=1 AND Crm.FTCryCode = '$tCryCode' AND Crm.FTManCardID = '$tID' ) C
                LEFT JOIN (
                SELECT FTImgRefID , FTImgObj 
                FROM   TCNMImgPerson 
                WHERE FTImgRefID = (SELECT FTCryCode+FTManCardID FROM TCNMCourieMan WHERE FTCryCode = '$tCryCode' AND FTManCardID = '$tID' )
                ) CmImg ON C.FTImgRefID_Man = CmImg.FTImgRefID ";

                
                            // echo $tSQL; exit();
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

    //Functionality : Checkduplicate CourierGrp
    //Parameters : function parameters
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMCpgCheckDuplicate($ptCryCode, $ptID, $pTel){
        $tSQL = "SELECT COUNT(Crm.FTCryCode) AS counts
                 FROM TCNMCourieMan Crm 
                 WHERE Crm.FTManTel = '$pTel' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : ADD Update TCNMCourieMan
    //Parameters : function parameters
    //Creator : 11/07/2019 Sarun
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCrmAddUpdateMaster($paData){
        try{
            // Update TCNMCourieMan
            $this->db->where('FTCryCode', $paData['FTCryCode'] );
            $this->db->where('FTManCardID', $paData['FTManCardID'] );
            $this->db->update('TCNMCourieMan',array(
                'FTManTel'          => $paData['FTManTel'], 
                'FTManSex'          => $paData['FTManSex'],
                'FDManDob'          => $paData['FDManDob'],
                'FTManStaActive'    => $paData['FTManStaActive'],
                'FTManCardEmp'      => $paData['FTManCardEmp'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CourierGrp Success',
                );
            }else{
                //Add TCNMCourieMan
                $this->db->insert('TCNMCourieMan', array(
                    'FTCryCode'         => $paData['FTCryCode'],
                    'FTManCardID'       => $paData['FTManCardID'],
                    'FTManTel'          => $paData['FTManTel'],
                    'FTManSex'          => $paData['FTManSex'],
                    'FDManDob'          => $paData['FDManDob'],
                    'FTManStaActive'    => $paData['FTManStaActive'],
                    'FTManCardEmp'      => $paData['FTManCardEmp'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add TCNMCourieMan Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit TCNMCourieMan',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Add Update TCNMCourieMan_L (TCNMCourieMan_L)
    //Parameters : function parameters
    //Creator : 11/07/2019 Sarun
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCrmAddUpdateLang($paData){
        try{
            //Update  Lang
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTManCardID', $paData['FTManCardID']);
            $this->db->where('FTCryCode', $paData['FTCryCode']);
            $this->db->update('TCNMCourieMan_L',array(
                'FTManName' => $paData['FTManName'],
                'FTCryRmk'  => $paData['FTCryRmk']
               
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update TCNMCourieMan_L Lang Success.',
                );
            }else{
                //Add Lang
                $this->db->insert('TCNMCourieMan_L', array(
                    'FNLngID'   => $paData['FNLngID'],
                    'FTManName' => $paData['FTManName'],
                    'FTCryRmk'  => $paData['FTCryRmk'],
                    'FTCryCode'  => $paData['FTCryCode'],
                    'FTManCardID' => $paData['FTManCardID']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add TCNMCourieMan_L Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit TCNMCourieMan_L Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete CourierGrp
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMCpgDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTCryCode', $paData['FTCryCode']);
            $this->db->where_in('FTManCardID', $paData['FTManCardID']);
            $this->db->delete('TCNMCourieMan');

            $this->db->where_in('FTCryCode', $paData['FTCryCode']);
            $this->db->where_in('FTManCardID', $paData['FTManCardID']);
            $this->db->delete('TCNMCourieMan_L');

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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMCourieMan";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

     //Functionality : Delete CourierGrp
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMCpgDelIMG($paData){
        try{
            $this->db->trans_begin();
            // print_r($paData['FTCryCode'].$paData['FTManCardID']);exit();
            $this->db->where_in('FTImgRefID',$paData['FTCryCode'].$paData['FTManCardID']);
            $this->db->delete('TCNMImgPerson');
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Delete Img Unsuccess.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Img Success.'.$paData['FTCryCode'].$paData['FTManCardID'],
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

}