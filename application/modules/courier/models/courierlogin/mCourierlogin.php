<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCourierlogin extends CI_Model {

    //Functionality : LIist CourierManlogin
    //Parameters : function parameters
    //Creator :  30/10/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMCURLDataList($paData){
        try{
            $tCryCode       = $paData['FTCryCode'];
            $tManCardID     = $paData['FTManCardID'];
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FTManLogin ASC) AS rtRowID,*
                                FROM(
                                    SELECT 	
                                        CURLOG.FTCryCode,
                                        CURLOG.FTManCardID,
                                        CURLOG.FTManLogType,
                                        CONVERT(VARCHAR(10), CURLOG.FDManPwdStart, 111) AS FDManPwdStart,
                                        CONVERT(VARCHAR(10), CURLOG.FDManPwdExpired, 111) AS FDManPwdExpired,
                                        CURLOG.FTManLogin,
                                        CURLOG.FTManLoginPwd,
                                        CURLOG.FTManRmk,
                                        CURLOG.FTManStaActive
                                    FROM [TCNMCourieLogin] CURLOG WITH(NOLOCK)
                                    WHERE 1=1
                                    AND CURLOG.FTCryCode    = '$tCryCode'
                                    AND CURLOG.FTManCardID	= '$tManCardID'
            ";

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMCURLGetPageAll($tSearchList,$paData);
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

    //Count 
    public function FSoMCURLGetPageAll($ptSearchList,$paData){
        try{
            $tCryCode   = $paData['FTCryCode'];
            $tManCardID = $paData['FTManCardID'];
            $tSQL       = " SELECT
                                COUNT (CURLOG.FTManLogin) AS counts
                            FROM [TCNMCourieLogin] CURLOG WITH(NOLOCK)
                            WHERE 1=1
                            AND CURLOG.FTCryCode    = '$tCryCode'
                            AND CURLOG.FTManCardID  = '$tManCardID'
            ";

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (CURLOG.FTManLogin LIKE '%$ptSearchList%')";
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

    //Functionality : Checkduplicate Data 
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data Count Duplicate
    //Return Type : object
    public function FSoMCURLCheckDuplicate($ptManLogin){
        $tSQL   = "SELECT COUNT(FTManLogin)AS counts
                   FROM TCNMCourieLogin
                   WHERE FTManLogin = '$ptManLogin' ";
        
        $oQuery = $this->db->query($tSQL);
        $nResult = $oQuery->row_array()["counts"];
        if($nResult>0){
            return true;
        }else{
            return false;
        }
    }

    //Functionality : Function Add Update Master TCNMCourieLogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMCURLAddUpdateMaster($paData){


        try{
            //Update Master
            $this->db->set('FDManPwdExpired'  , $paData['FDManPwdExpired']);
            $this->db->set('FTManLogin'       , $paData['FTManLogin']);
            $this->db->set('FTManLoginPwd'    , $paData['FTManLoginPwd']);
            $this->db->set('FTManRmk'         , $paData['FTManRmk']);
            $this->db->set('FTManStaActive'   , $paData['FTManStaActive']);
            $this->db->where('FTCryCode'      , $paData['FTCryCode']);
            $this->db->where('FTManCardID'    , $paData['FTManCardID']);
            $this->db->where('FTManLogType'   , $paData['FTManLogType']);
            $this->db->where('FDManPwdStart'  , $paData['FDManPwdStart']);
            $this->db->update('TCNMCourieLogin');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aManlogType = array(
                    'FTCryCode'         => $paData['FTCryCode'],
                    'FTManCardID'       => $paData['FTManCardID'],
                    'FTManLogType'      => $paData['FTManLogType'],
                    'FDManPwdStart'     => $paData['FDManPwdStart'],
                    'FDManPwdExpired'   => $paData['FDManPwdExpired'],
                    'FTManLogin'        => $paData['FTManLogin'],
                    'FTManLoginPwd'     => $paData['FTManLoginPwd'],
                    'FTManRmk'          => $paData['FTManRmk'],
                    'FTManStaActive'    => $paData['FTManStaActive']
                );
                
                //Add Master
                $this->db->insert('TCNMCourieLogin', $aManlogType);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    //Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

   

    //Functionality : check Data TCNMCourieLogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCURLCheckID($paData){

        $tCryCode         = $paData['FTCryCode'];
        $tCryManCardID    = $paData['FTManCardID'];
        $tManlogin        = $paData['FTManLogin'];
        $nLngID           = $paData['FNLngID'];
    
        $tSQL = "SELECT 	
                    CURLOG.FTCryCode,
                    CURLOG.FTManCardID,
                    CURLOG.FTManLogType,
                    CURLOG.FDManPwdStart,
                    CURLOG.FDManPwdExpired,
                    CURLOG.FTManLogin,
                    CURLOG.FTManLoginPwd,
                    CURLOG.FTManRmk,
                    CURLOG.FTManStaActive
                FROM [TCNMCourieLogin] CURLOG
                WHERE 1=1 AND CURLOG.FTManLogin = '$tManlogin'";       
  
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : Delete TCNMCourieLogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCURLDel($paData){

        $this->db->where_in('FTManLogin', $paData['FTManLogin']);
        $this->db->delete('TCNMCourieLogin');
        
        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
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
    }

     //Functionality : get all row 
    //Parameters : -
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMCourieLogin";
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
    //Return Type : Array
    public function FSaMCURLDeleteMultiple($paDataDelete){
   
        $this->db->where_in('FTCryCode', $paDataDelete['aDataCryCode']);
        $this->db->where_in('FTManCardID', $paDataDelete['aDataCardId']);
        $this->db->where_in('FTManLogType', $paDataDelete['aDataLogType']);
        $this->db->where_in('FDManPwdStart', $paDataDelete['aDataPwStart']);
        $this->db->delete('TCNMCourieLogin');

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
    }

    //Functionality : Checkduplicate Data 
    //Parameters : function parameters
    //Creator : 28/08/2019 Saharat(Golf)
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSoMCURLCheckDuplicateTel($ptData){
        $tManLogin =  $ptData['FTManLogin'];
        $tSQL   = "SELECT COUNT(FTManLogin)AS counts
                              FROM TCNMCourieLogin
                              WHERE FTManLogin = '$tManLogin' ";
        $oQuery = $this->db->query($tSQL);
        $nResult = $oQuery->row_array()["counts"];
        if($nResult > 0){
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Data Not Found.',
            );
        }
    return $aStatus;
    }

}


