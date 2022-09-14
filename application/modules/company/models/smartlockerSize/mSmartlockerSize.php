<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSmartlockerSize extends CI_Model {

    //Get Date
    public function FSaMSMSDataList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FTPzeCode ASC) AS rtRowID,* FROM
                                    ( SELECT 	
                                    SHPS.FTPzeCode,
                                    SHPS.FCPzeDim,
                                    SHPS.FCPzeHigh,
                                    SHPS.FCPzeWide,
                                    SHPSL.FTSizName,
                                    SHPSL.FTSizRemark
                                FROM [TRTMShopSize] SHPS
                                LEFT JOIN [TRTMShopSize_L]  SHPSL ON SHPS.FTPzeCode = SHPSL.FTSizCode AND SHPSL.FNLngID = $tFNLngID  
                                WHERE 1=1 
                                    ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMSMLGetPageAll($tSearchList,$paData);
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
    public function FSoMSMLGetPageAll($ptSearchList,$paData){
        try{
            $tSQL = "SELECT COUNT (SMS.FTPzeCode) AS counts
                     FROM [TRTMShopSize] SMS
                     WHERE 1=1 ";

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (SMS.FTPzeCode LIKE '%$tSearchList%')";
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
    //Creator : 04/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : data Count Duplicate
    //Return Type : object
    public function FSoMSMSCheckDuplicate($ptPzeCode){
        $tSQL   = "SELECT COUNT(FTPzeCode)AS counts
                   FROM TRTMShopSize
                   WHERE FTPzeCode = '$ptPzeCode' ";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add Update Master TRTMShopSize
    //Parameters : function parameters
    //Creator : 04/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMSMSAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FCPzeDim' , $paData['FCPzeDim']);
            $this->db->set('FCPzeHigh' , $paData['FCPzeHigh']);
            $this->db->set('FCPzeWide' , $paData['FCPzeWide']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTPzeCode',$paData['FTPzeCode']);
            $this->db->update('TRTMShopSize');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                //Add Master
                $this->db->insert('TRTMShopSize',array(
                    'FTPzeCode'     => $paData['FTPzeCode'],
                    'FCPzeDim'      => $paData['FCPzeDim'],
                    'FCPzeHigh'     => $paData['FCPzeHigh'],
                    'FCPzeWide'     => $paData['FCPzeWide'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy']
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

    //Functionality : Function Add Update Master TRTMShopSize_L
    //Parameters : function parameters
    //Creator : 04/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMSMSAddUpdateLang($paData){
        try{
                //Update Master
                $this->db->set('FTSizName' , $paData['FTSizName']);
                $this->db->set('FTSizRemark' , $paData['FTSizRemark']);
                $this->db->where('FTSizCode',$paData['FTPzeCode']);
                $this->db->update('TRTMShopSize_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'UpdateSuccess ',
                );
            }else{
                //Add Master
                $this->db->insert('TRTMShopSize_L',array(
                    'FTSizCode'      => $paData['FTPzeCode'],
                    'FTSizName'      => $paData['FTSizName'],
                    'FTSizRemark'    => $paData['FTSizRemark'],
                    'FNLngID'        => $paData['FNLngID']
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

    //Functionality : check Data TRTMShopSize
    //Parameters : function parameters
    //Creator : 04/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMSMSCheckID($paData){
        $tPzeCode   = $paData['FTPzeCode'];
        $nLngID     = $paData['FNLngID'];
    
        $tSQL = "SELECT 	
                    SHPS.FTPzeCode,
                    SHPS.FCPzeDim,
                    SHPS.FCPzeHigh,
                    SHPS.FCPzeWide,
                    SHPSL.FTSizName,
                    SHPSL.FTSizRemark,
                    IMG.FTImgObj

                FROM [TRTMShopSize] SHPS
                LEFT JOIN [TRTMShopSize_L]  SHPSL ON SHPS.FTPzeCode = SHPSL.FTSizCode AND SHPSL.FNLngID = $nLngID  
                LEFT JOIN [TCNMImgObj]      IMG   ON SHPS.FTPzeCode = IMG.FTImgRefID  AND IMG.FTImgTable = 'TRTMShopSize'
                WHERE 1=1 AND SHPS.FTPzeCode = '$tPzeCode'";       
  
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

    //Functionality : Delete ShopSize
    //Parameters : function parameters
    //Creator : 04/07/2019 saharat(Golf)
    //Return : response
    //Return Type : array
    public function FSnMSMSDel($paData){
        $this->db->where_in('FTPzeCode', $paData['FTPzeCode']);
        $this->db->delete('TRTMShopSize');
        
        $this->db->where_in('FTSizCode', $paData['FTPzeCode']);
        $this->db->delete('TRTMShopSize_L');
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
    //Creator : 04/07/2019 saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMSMSGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TRTMShopSize";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }


}