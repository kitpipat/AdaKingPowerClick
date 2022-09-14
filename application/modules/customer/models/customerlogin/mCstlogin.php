<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCstlogin extends CI_Model {

    //Functionality : LIist Userlogin
    //Parameters : function parameters
    //Creator :  25/11/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMCSTLOGDataList($paData){

        try{
            $tCstCode       = $paData['FTCstCode'];
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FDCstPwdStart DESC , FTCstCode DESC) AS rtRowID,*
                                FROM(
                                    SELECT 	
                                        CSTLOGIN.FTCstCode,
                                        CSTLOGIN.FTCstLogType,
                                        CSTLOGIN.FDCstPwdStart,
                                        CSTLOGIN.FDCstPwdExpired,
                                        CSTLOGIN.FTCstLogin,
                                        CSTLOGIN.FTCstLoginPwd,
                                        CSTLOGIN.FTCstRmk,
                                        CSTLOGIN.FTCstStaActive,
                                        CSTL.FTCstName AS rtCstType
                                    FROM [TCNMCstLogin] CSTLOGIN WITH(NOLOCK)
                                    LEFT JOIN TCNMCst_L CSTL ON CSTLOGIN.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $tFNLngID
                                    WHERE 1=1
                                    AND CSTLOGIN.FTCstCode    = '$tCstCode'
            ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
           
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
               
                $oFoundRow  = $this->FSoMCSTLOGINGetPageAll($tSearchList,$paData);
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
    public function FSoMCSTLOGINGetPageAll($ptSearchList,$paData){
        try{
            $tCstCode       = $paData['FTCstCode'];
            $tSQL       = " SELECT
                                COUNT (CSTLOGIN.FTCstCode) AS counts
                            FROM [TCNMCstLogin] CSTLOGIN WITH(NOLOCK)
                            WHERE 1=1
                            AND CSTLOGIN.FTCstCode    = '$tCstCode'
            ";

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (CSTLOGIN.FTCstCode LIKE '%$ptSearchList%')";
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
    public function FSaMCSTLCheckID($paData){

        $tCstCode    = $paData['FTCstCode'];
        $tCstlogin   = $paData['FTCstLogin'];
        $tPwdStart   = $paData['FDCstPwdStart'];
        $tnLngID     = $paData['FNLngID'];

            $tSQL = "SELECT 
                        CSTLOGIN.FTCstCode,
                        CSTLOGIN.FTCstLogType,
                        CSTLOGIN.FDCstPwdStart,
                        CSTLOGIN.FDCstPwdExpired,
                        CSTLOGIN.FTCstLogin,
                        CSTLOGIN.FTCstLoginPwd,
                        CSTLOGIN.FTCstRmk,
                        CSTLOGIN.FTCstStaActive
                FROM [TCNMCstLogin] CSTLOGIN
                WHERE 1=1 
                AND CSTLOGIN.FTCstLogin = '$tCstlogin'
                AND CSTLOGIN.FTCstCode = '$tCstCode'
                AND CSTLOGIN.FDCstPwdStart = '$tPwdStart'
            ";
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
    public function FSoMCSTLCheckDuplicate($ptCstLogin, $paCstLogType, $paCstCode, $ptPwdStart){

        $tSQLWhere = "";

        if($paCstLogType == 5){
            $tSQLWhere .= "AND FTCstLogin = '$ptCstLogin' AND FTCstLogType = '$paCstLogType' AND FTCstCode = '$paCstCode' ";
        }else if($paCstLogType == 0){
            $tSQLWhere .= "AND FTCstLogin = '$ptCstLogin' AND 'FDCstPwdStart' = '$ptPwdStart' ";
        }else{
            $tSQLWhere .= "AND FTCstLogin = '$ptCstLogin' ";
        }

        $tSQL   = "SELECT COUNT(FTCstLogin)AS counts
                    FROM TCNMCstLogin
                    WHERE  1=1 
                    $tSQLWhere
                ";
        $oQuery = $this->db->query($tSQL);
        $nResult = $oQuery->row_array()["counts"];
        if($nResult>0){
            return true;
        }else{
            return false;
        }

    }


    //Functionality : Function Add Update Master Userlogin
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMCSTLAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FDCstPwdStart'    , $paData['FDCstPwdStart']);
            $this->db->set('FDCstPwdExpired'  , $paData['FDCstPwdExpired']);
            $this->db->set('FTCstLogin'       , $paData['FTCstLogin']);
            $this->db->set('FTCstLoginPwd'    , $paData['FTCstLoginPwd']);
            $this->db->set('FTCstRmk'         , $paData['FTCstRmk']);
            $this->db->set('FTCstStaActive'   , $paData['FTCstStaActive']);
            $this->db->where('FTCstCode'      , $paData['FTCstCode']);
            $this->db->where('FTCstLogType'   , $paData['FTCstLogType']);
            $this->db->where('FDCstPwdStart'  , $paData['FDCstPwdStartOld']);
            $this->db->update('TCNMCstLogin');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aResult= array(
                    'FTCstCode'          => $paData['FTCstCode'],
                    'FTCstLogType'       => $paData['FTCstLogType'],
                    'FDCstPwdStart'      => $paData['FDCstPwdStart'],
                    'FDCstPwdExpired'    => $paData['FDCstPwdExpired'],
                    'FTCstLogin'         => $paData['FTCstLogin'],
                    'FTCstLoginPwd'      => $paData['FTCstLoginPwd'],
                    'FTCstRmk'           => $paData['FTCstRmk'],
                    'FTCstStaActive'     => $paData['FTCstStaActive'],
                );
                //Add Master
                $this->db->insert('TCNMCstLogin', $aResult);
                if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success',
                );
                }else{
                    // Error
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

    // update Last UpdateON Table TCNMUSER
    // create by witsarut 11-09-2020
    public function FSaMCSTLAddUpdateLastUp($paData, $paWhere){
        $this->db->where('FTCstCode', $paWhere['FTCstCode']);
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->update('TCNMCst');
    }


    //Functionality : Delete Userlogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCSTLDel($paData){
        $this->db->where_in('FTCstCode', $paData['FTCstCode']);
        $this->db->where_in('FTCstLogin', $paData['FTCstLogin']);
        $this->db->where_in('FDCstPwdStart', $paData['FDCstPwdStart']);
        $this->db->delete('TCNMCstLogin');

        $this->db->where_in('FTImgRefID', $paData['FTCstCode']);
        $this->db->where_in('FTImgTable', 'TCNMCst');
        $this->db->where_in('FTImgKey', 'Face');
        $this->db->delete('TCNMImgObj');

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

    //Functionality : Get all row 
    //Parameters : -
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMCstLogin";
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
    public function FSaMCSTLDeleteMultiple($paDataDelete){
        
        $this->db->where_in('FTCstCode',$paDataDelete['aDataCstCode']);
        $this->db->where_in('FTCstLogType',$paDataDelete['aDataLogType']);
        $this->db->where_in('FDCstPwdStart',$paDataDelete['aDataPwStart']);
        $this->db->delete('TCNMCstLogin');

        $this->db->where_in('FTImgRefID', $paDataDelete['aDataCstCode']);
        $this->db->where_in('FTImgTable', 'TCNMCst');
        $this->db->where_in('FTImgKey', 'Face');
        $this->db->delete('TCNMImgObj');

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




}