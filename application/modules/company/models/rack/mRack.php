<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRack extends CI_Model {
    
    //Functionality : Search Rack By ID
    //Parameters : function parameters
    //Creator : 29/08/2019 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCKSearchByID($paData){
        $tRckCode   = $paData['FTRckCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL   =   "   SELECT
                            RCK.FTRakCode    AS rtRckCode,
                            RCKL.FTRakName   AS rtRckName,
                            RCKL.FTRakRmk    AS rtRckRmk,
                            IMG.FTImgObj     AS rtImgObj
                        FROM [TRTMShopRack] RCK
                        LEFT JOIN [TRTMShopRack_L] RCKL ON RCK.FTRakCode = RCKL.FTRakCode AND RCKL.FNLngID = $nLngID 
                        LEFT JOIN [TCNMImgObj]  IMG ON RCK.FTRakCode = IMG.FTImgRefID AND IMG.FTImgTable = 'TRTMShopRack' AND IMG.FNImgSeq = 1
                        WHERE 1=1 
                        AND RCK.FTRakCode = '$tRckCode'
        ";

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
    
    //Functionality : list Rack
    //Parameters : function parameters
    //Creator :  28/09/2019 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRckList($ptAPIReq,$ptMethodReq,$paData){
        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tSQL = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY rtRckCode ASC) AS rtRowID,* FROM
                        (SELECT DISTINCT
                            Rck.FTRakCode    AS rtRckCode,
                            Rck_L.FTRakName  AS rtRckName,
                            Rck_L.FTRakRmk   AS rtRckRmk,
                            IMG.FTImgObj     AS rtImgObj

                        FROM [TRTMShopRack] Rck
                        LEFT JOIN [TRTMShopRack_L] Rck_L ON Rck.FTRakCode = Rck_L.FTRakCode AND Rck_L.FNLngID = $nLngID
                        LEFT JOIN [TCNMImgObj]  IMG ON Rck.FTRakCode = IMG.FTImgRefID AND IMG.FTImgTable = 'TRTMShopRack'
                        WHERE 1=1 ";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (Rck.FTRakCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR Rck_L.FTRakName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMRckGetPageAll($tSearchList,$nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> $nPageAll, 
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }else{
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        
        return $aResult;
    }

    //Functionality : All Page Of Rack
    //Parameters : function parameters
    //Creator :  28/08/2019 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMRckGetPageAll($ptSearchList,$ptLngID){
        
        $tSQL = "SELECT COUNT (RCL.FTRakCode) AS counts
                 FROM TRTMShopRack RCL
                 LEFT JOIN [TRTMShopRack_L] RCKL ON RCL.FTRakCode = RCKL.FTRakCode AND RCKL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (RCL.FTRakCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= "  OR RCKL.FTRakName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : Select Data Reason Group
    //Parameters : function parameters
    //Creator :  09/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRSNSysGroup($ptAPIReq,$ptMethodReq,$paData){
        $nLngID = $paData['FNLngID'];
        $tSQL = "SELECT
                    RSNG.FTRsgCode AS rtRsgCode,
                    RSNG.FTRsgName AS rtRsgName,
                    RSNG.FTRsgRmk  AS rtRsgRmk
                 FROM [TSysRsnGrp_L] RSNG
                 WHERE RSNG.FNLngID = $nLngID
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aResult = array(
                'raItems'   => $oList,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 10/05/2018 wasin
    //Last Modified : -
    //Return : Data Count Duplicate
    //Return Type : Object
    public function FSoMRacCheckDuplicate($ptRacCode){
        $tSQL   = "SELECT COUNT(FTRakCode)AS counts
                   FROM TRTMShopRack
                   WHERE FTRakCode = '$ptRacCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 10/05/2018 wasin
    //Last Modified : 11/06/2018 wasin
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMRacAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTRakCode' , $paData['FTRacCode']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTRakCode', $paData['FTRacCode']);
            $this->db->update('TRTMShopRack');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TRTMShopRack',array(
                    'FTRakCode'     => $paData['FTRacCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                ));
                if($this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  10/05/2018 Wasin
    //Last Modified : 11/06/2018 wasin
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMRacAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTRakName', $paData['FTRacName']);
            $this->db->set('FTRakRmk', $paData['FTRacRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTRakCode', $paData['FTRacCode']);
            $this->db->update('TRTMShopRack_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                //Add Lang
                $this->db->insert('TRTMShopRack_L',array(
                    'FTRakCode'     => $paData['FTRacCode'],
                    'FNLngID'       => $paData['FNLngID'],
                    'FTRakName'     => $paData['FTRacName'],
                    'FTRakRmk'      => $paData['FTRacRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Delete Rack
    //Parameters : function parameters
    //Creator : 29/05/2019 Saharat(Golf)
    //Return : array
    //Return Type : array
    public function FSnMRCKDel($paData){

        $this->db->where_in('FTRakCode',$paData['FTRakCode']);
        $this->db->delete('TRTMShopRack');
        
        $this->db->where_in('FTRakCode',$paData['FTRakCode']);
        $this->db->delete('TRTMShopRack_L');
        
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



  
    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 29/08/2019 Saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TRTMShopRack";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }





}