<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mServer extends CI_Model {

    //Functionality : list Server Data
    //Parameters : function parameters
    //Creator :  21/01/2021 Nale
    //Return : data
    //Return Type : Array
    public function FSaMSrvList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode = $paData['tSesAgnCode'];


            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtSrvCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        Srv.FTSrvCode   AS rtSrvCode,
                                        Srv_L.FTSrvName AS rtSrvName,
                                        Srv.FTSrvRefAPIMaste   AS rtSrvRefAPIMaste,
                                        Srv.FTSrvRefSBUrl   AS rtSrvRefSBUrl,
                                        CASE WHEN Srv.FTSrvStaCenter = 1 THEN
                                            'Centralize'
                                        ELSE
                                            'Branch Server'
                                        END AS rtSrvStaCenter,
                                        Srv.FTSrvDBName   AS rtSrvDBName,
                                        CASE WHEN Srv.FTSrvGroup = 1 THEN
                                            'Demo'
                                        ELSE
                                            'Production'
                                        END AS rtSrvGroup,
                                        Srv.FDCreateOn,
                                        '' AS rtSyncLast
                                    FROM [TRGMPosSrv] Srv
                                    LEFT JOIN [TRGMPosSrv_L]  Srv_L ON Srv.FTSrvCode = Srv_L.FTSrvCode AND Srv_L.FNLngID = $nLngID
    
                                    WHERE 1=1 ";

            if($tSesAgnCode != ''){
                // $tSQL .= "AND Srv.FTAgnCode = $tSesAgnCode";   
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (Srv.FTSrvCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR Srv_L.FTSrvName COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSQL .= " OR LEFT(Srv.FTSrvCode,1)   = '%$tSearchList%' " ;
                $tSQL .= " OR LEFT(Srv_L.FTSrvName,1) = '%$tSearchList%' )" ;
            }
            
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            // print_r($tSQL);
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMSrvGetPageAll($tSearchList,$nLngID, $tSesAgnCode);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
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

    //Functionality : All Page Of Server Data
    //Parameters : function parameters
    //Creator :  21/01/2021 Nale
    //Return : object Count All Server Data
    //Return Type : Object 
    public function FSoMSrvGetPageAll($ptSearchList,$ptLngID, $ptSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (Srv.FTSrvCode) AS counts
                        FROM [TRGMPosSrv] Srv
                    LEFT JOIN [TRGMPosSrv_L]  Srv_L ON Srv.FTSrvCode = Srv_L.FTSrvCode AND Srv_L.FNLngID = $ptLngID
                    WHERE 1=1 ";

            if($ptSesAgnCode != ''){
                // $tSQL .= "AND Srv.FTAgnCode = $ptSesAgnCode";   
            }

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (Srv.FTSrvCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR Srv_L.FTSrvName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Server Data By ID
    //Parameters : function parameters
    //Creator : 21/01/2021 Nale
    //Return : data
    //Return Type : Array
    public function FSaMSrvGetDataByID($paData){
        try{
            $tSrvCode   = $paData['FTSrvCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                Srv.FTSrvCode AS rtSrvCode,
                                Srv_L.FTSrvName AS rtSrvName,
                                Srv_L.FTSrvNameOth AS rtSrvNameOth,
                                Srv.FTSrvRefAPIMaste   AS rtSrvRefAPIMaste,
                                Srv.FTSrvRefSBUrl   AS rtSrvRefSBUrl,
                                Srv.FTSrvStaCenter   AS rtSrvStaCenter,
                                Srv.FTSrvDBName   AS rtSrvDBName,
                                Srv.FTSrvGroup   AS rtSrvGroup,
                                Srv_L.FTSrvRmk  AS rtSrvRmk
                            FROM TRGMPosSrv Srv 
                            LEFT JOIN TRGMPosSrv_L Srv_L ON Srv.FTSrvCode = Srv_L.FTSrvCode AND Srv_L.FNLngID = $nLngID
               
                            WHERE 1 = 1 
                            AND Srv.FTSrvCode = '$tSrvCode' ";
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

    //Functionality : Checkduplicate Server Data 
    //Parameters : function parameters
    //Creator : 21/01/2021 Nale
    //Return : data
    //Return Type : Array
    public function FSnMSrvCheckDuplicate($ptSrvCode){
        $tSQL = "SELECT COUNT(Srv.FTSrvCode) AS counts
                 FROM TRGMPosSrv Srv 
                 WHERE Srv.FTSrvCode = '$ptSrvCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update ProductUnit (TRGMPosSrv)
    //Parameters : function parameters
    //Creator : 21/01/2021 Nale
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMSrvAddUpdateMaster($paDataServer){

        try{
            // Update TRGMPosSrv
            $this->db->where('FTSrvCode', $paDataServer['FTSrvCode']);
            $this->db->update('TRGMPosSrv',array(
                'FTSrvRefAPIMaste'     => $paDataServer['FTSrvRefAPIMaste'],
                'FTSrvRefSBUrl'        => $paDataServer['FTSrvRefSBUrl'],
                'FTSrvStaCenter'       => $paDataServer['FTSrvStaCenter'],
                'FTSrvDBName'          => $paDataServer['FTSrvDBName'],
                'FTSrvGroup'           => $paDataServer['FTSrvGroup'],
                'FDLastUpdOn'          => $paDataServer['FDLastUpdOn'],
                'FTLastUpdBy'          => $paDataServer['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ProductUnit Success',
                );
            }else{
                //Add TRGMPosSrv
                $this->db->insert('TRGMPosSrv', array(
                    'FTSrvCode'     => $paDataServer['FTSrvCode'],
                    'FTSrvRefAPIMaste'     => $paDataServer['FTSrvRefAPIMaste'],
                    'FTSrvRefSBUrl'        => $paDataServer['FTSrvRefSBUrl'],
                    'FTSrvStaCenter'       => $paDataServer['FTSrvStaCenter'],
                    'FTSrvDBName'          => $paDataServer['FTSrvDBName'],
                    'FTSrvGroup'           => $paDataServer['FTSrvGroup'],
                    'FDCreateOn'           => $paDataServer['FDCreateOn'],
                    'FTCreateBy'           => $paDataServer['FTCreateBy'],
                    'FDLastUpdOn'          => $paDataServer['FDLastUpdOn'],
                    'FTLastUpdBy'          => $paDataServer['FTLastUpdBy']
                    
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

    //Functionality : Update ProductUnit Lang (TRGMPosSrv_L)
    //Parameters : function parameters
    //Creator : 21/01/2021 Nale
    //Update : 1/04/2019 Pap
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMSrvAddUpdateLang($paDataServer){
        try{
            //Update Pdt Unit Lang
            $this->db->where('FNLngID', $paDataServer['FNLngID']);
            $this->db->where('FTSrvCode', $paDataServer['FTSrvCode']);
            $this->db->update('TRGMPosSrv_L',array(
                                                    'FTSrvName' => $paDataServer['FTSrvName'],
                                                    'FTSrvNameOth' => $paDataServer['FTSrvNameOth'],
                                                    'FTSrvRmk' => $paDataServer['FTSrvRmk'],
                                                ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Server Data Lang Success.',
                );
            }else{
                //Add Pdt Unit Lang
                $this->db->insert('TRGMPosSrv_L', array(
                    'FTSrvCode' => $paDataServer['FTSrvCode'],
                    'FNLngID'   => $paDataServer['FNLngID'],
                    'FTSrvName' => $paDataServer['FTSrvName'],
                    'FTSrvNameOth' => $paDataServer['FTSrvNameOth'],
                    'FTSrvRmk' => $paDataServer['FTSrvRmk'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Server Data Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Server Data Lang.',
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
    //Creator : 21/01/2021 Nale
    //Update : 1/04/2019 Pap
    //Return : 
    //Return Type : array
    public function FSaMSrvDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTSrvCode', $paData['FTSrvCode']);
            $this->db->delete('TRGMPosSrv');

            $this->db->where_in('FTSrvCode', $paData['FTSrvCode']);
            $this->db->delete('TRGMPosSrv_L');

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
    public function FSnMSrvGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TRGMPosSrv";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }



































































































}