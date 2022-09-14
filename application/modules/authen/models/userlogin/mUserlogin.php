<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mUserlogin extends CI_Model {

    //Functionality : LIist Userlogin
    //Parameters : function parameters
    //Creator :  19/08/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMUSRLDataList($paData){

        try{

            $tUsrCode       = $paData['FTUsrCode'];
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FTUsrLogin ASC) AS rtRowID,*
                                FROM(
                                    SELECT 	
                                        USRLOGIN.FTUsrCode,
                                        USRLOGIN.FTUsrLogType,
                                        CONVERT(VARCHAR(15), USRLOGIN.FDUsrPwdStart, 111) AS FDUsrPwdStart,
                                        CONVERT(VARCHAR(15), USRLOGIN.FDUsrPwdExpired, 111) AS FDUsrPwdExpired,
                                        USRLOGIN.FTUsrLogin,
                                        USRLOGIN.FTUsrLoginPwd,
                                        USRLOGIN.FTUsrRmk,
                                        USRLOGIN.FTUsrStaActive
                                    FROM [TCNMUsrLogin] USRLOGIN WITH(NOLOCK)
                                    WHERE 1=1
                                    AND USRLOGIN.FTUsrCode    = '$tUsrCode'
            ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
           
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
               
                $oFoundRow  = $this->FSoMUSRLGetPageAll($tSearchList,$paData);
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

    //Functionality : Count Userlogin
    //Parameters : function parameters
    //Creator :  19/08/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSoMUSRLGetPageAll($ptSearchList,$paData){
        try{
            $tUsrCode       = $paData['FTUsrCode'];
            $tSQL       = " SELECT
                                COUNT (USRLOGIN.FTUsrLogin) AS counts
                            FROM [TCNMUsrLogin] USRLOGIN WITH(NOLOCK)
                            WHERE 1=1
                            AND USRLOGIN.FTUsrCode    = '$tUsrCode'
            ";

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (USRLOGIN.FTUsrLogin LIKE '%$ptSearchList%')";
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

    //Functionality : check Data Userlogin
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMUSRLCheckID($paData){
        
        $tUsrCode    = $paData['FTUsrCode'];
        $tUsrlogin   = $paData['FTUsrLogin'];
        $tnLngID     = $paData['FNLngID'];

        $tSQL = "SELECT 
                    USRLOGIN.FTUsrCode,
                    USRLOGIN.FTUsrLogType,
                    USRLOGIN.FDUsrPwdStart,
                    USRLOGIN.FDUsrPwdExpired,
                    USRLOGIN.FTUsrLogin,
                    USRLOGIN.FTUsrLoginPwd,
                    USRLOGIN.FTUsrRmk,
                    USRLOGIN.FTUsrStaActive
                FROM [TCNMUsrLogin] USRLOGIN
                WHERE 1=1 AND USRLOGIN.FTUsrLogin = '$tUsrlogin'";

        $oQuery = $this->db->query($tSQL);
   
        if ($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $aResult= array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //if data not found
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }



    //Functionality : Checkduplicate Data 
    //Parameters : function parameters
    //Creator :  20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data Count Duplicate
    //Return Type : object
    public function FSoMUSRLCheckDuplicate($ptUsrLogin,$ptTypeLogin){
        $tSQL   = "SELECT COUNT(FTUsrLogin)AS counts
                   FROM TCNMUsrLogin
                   WHERE FTUsrLogin = '$ptUsrLogin' AND FTUsrLogType = '$ptTypeLogin' ";
        $oQuery = $this->db->query($tSQL);
        $nResult = $oQuery->row_array()["counts"];
        if($nResult>0){
            return true;
        }else{
            return false;
        }
    }


    // update Last UpdateON Table TCNMUSER
    //Create By Witsarut 04/08/2020
     public function FSaMUSRLAddUpdateLastUp($paData, $paWhere){
        // update LastUpdateON
        $this->db->where('FTUsrCode'  , $paWhere['FTUsrCode']);
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->update('TCNMUser');
    }


    //Functionality : Function Add Update Master Userlogin
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function  FSaMUSRLAddUpdateMaster($paData,$ptType){

        try{
            if($ptType == 'ADD'){
                $aResult = array(
                    'FTUsrCode'          => $paData['FTUsrCode'],
                    'FTUsrLogType'       => $paData['FTUsrLogType'],
                    'FDUsrPwdStart'      => $paData['FDUsrPwdStart'],
                    'FDUsrPwdExpired'    => $paData['FDUsrPwdExpired'],
                    'FTUsrLogin'         => $paData['FTUsrLogin'],
                    'FTUsrLoginPwd'      => $paData['FTUsrLoginPwd'],
                    'FTUsrRmk'           => $paData['FTUsrRmk'],
                    'FTUsrStaActive'     => $paData['FTUsrStaActive'],
                );
                $this->db->insert('TCNMUsrLogin', $aResult);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }else if($ptType == 'EDIT'){
                $this->db->set('FDUsrPwdStart'    , $paData['FDUsrPwdStart']);
                $this->db->set('FDUsrPwdExpired'  , $paData['FDUsrPwdExpired']);
                $this->db->set('FTUsrLogin'       , $paData['FTUsrLogin']);
                $this->db->set('FTUsrLoginPwd'    , $paData['FTUsrLoginPwd']);
                $this->db->set('FTUsrRmk'         , $paData['FTUsrRmk']);
                $this->db->set('FTUsrStaActive'   , $paData['FTUsrStaActive']);
                $this->db->where('FTUsrCode'      , $paData['FTUsrCode']);
                $this->db->where('FTUsrLogType'   , $paData['FTUsrLogType']);
                // $this->db->where('FDUsrPwdStart'  , $paData['FDUsrPwdStartOld']);
                $this->db->update('TCNMUsrLogin');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Success',
                    );
                }else{
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

    //Functionality : Delete Userlogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMUSRLDel($paData){
        $this->db->where_in('FTUsrLogin', $paData['FTUsrLogin']);
        $this->db->where_in('FTUsrLogType', $paData['FTUsrLogType']);
        $this->db->delete('TCNMUsrLogin');

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

    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 26/07/2019 Witsarut
    //Return : data
    //Return Type : Arra
    public function FSaMUSRLDeleteMultiple($paDataDelete){
        $this->db->where_in('FTUsrLogin' ,$paDataDelete['aDataUsrLogin']);
        $this->db->where_in('FTUsrCode' ,$paDataDelete['aDataUsrCode']);
        $this->db->where_in('FTUsrLogType' ,$paDataDelete['aDataLogType']);
        // $this->db->where_in('FDUsrPwdStart' ,$paDataDelete['aDataPwStart']);
        $this->db->delete('TCNMUsrLogin');

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

    //Functionality : Get all row 
    //Parameters : -
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMUsrLogin";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }


    //Functionality : Function Add Update Master User
    //Parameters : function parameters
    //Creator : 03/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMUSRAddUpMaster($paDataMaster){
        try{

            //Update Master
            $this->db->set('FTUsrLoginType' , $paDataMaster['FTUsrLogType']);
            $this->db->set('FDUsrStart'   , $paDataMaster['FDUsrPwdStart']);
            $this->db->set('FDUsrFinish'  , $paDataMaster['FDUsrPwdExpired']);
            $this->db->where('FTUsrCode'  , $paDataMaster['FTUsrCode']);
            $this->db->update('TCNMUser');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                //Add Master
                $this->db->insert('TCNMUser',array(
                    'FTUsrLoginType' => $paDataMaster['FTUsrCode'],
                    'FTUsrLogType'   => $paDataMaster['FTUsrLogType'],
                    'FDUsrStart'     => $paDataMaster['FDUsrPwdStart'],
                    'FDUsrFinish'    => $paDataMaster['FDUsrPwdExpired']

                ));
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

 }


