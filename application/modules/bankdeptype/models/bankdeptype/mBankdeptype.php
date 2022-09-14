<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBankdeptype extends CI_Model {
    
    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMBDTSearchByID($paData){

        $tBdtCode   = $paData['FTBdtCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT
                    BDT.FTBdtCode   AS rtBdtCode,
                    BDTL.FTBdtName  AS rtBdtName,
                    BDT.FTAgnCode   AS rtAgnCode,
                    AGN_L.FTAgnName AS rtAgnName
                 FROM [TFNMBnkDepType] BDT

                 LEFT JOIN TCNMAgency_L AGN_L ON BDT.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                 LEFT JOIN [TFNMBnkDepType_L] BDTL ON BDT.FTBdtCode = BDTL.FTBdtCode AND BDTL.FNLngID = $nLngID
                 WHERE 1=1 "; 
        
        if($tBdtCode!= ""){
            $tSQL .= "AND BDT.FTBdtCode = '$tBdtCode'";
        }

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
    
    //Functionality : list Recive
    //Parameters : function parameters
    //Creator :  11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMBDTListBDT($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");

        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTBdtCode ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                BDT.FTBdtCode,
                                BDTL.FTBdtName,
                                BDT.FDCreateOn
                            FROM [TFNMBnkDepType] BDT
                            LEFT JOIN [TFNMBnkDepType_L] BDTL ON BDT.FTBdtCode = BDTL.FTBdtCode AND BDTL.FNLngID = $nLngID
                          
                            WHERE 1=1 ";

        if($tAgnCode != ''){
            $tSQL .= "AND BDT.FTAgnCode = $tAgnCode";
        }

        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (BDT.FTBdtCode LIKE '%$tSearchList%'";
            $tSQL .= " OR BDTL.FTBdtName LIKE '%$tSearchList%')";
           
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FsnMBDTGetPageAll($tSearchList,$nLngID,$tAgnCode);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
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
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    //Functionality : Update Bank
    //Parameters : function parameters
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMBDTAddUpdateMaster($paData){
       
        try{
            //Update Master
            $this->db->set('FTBdtCode' , $paData['FTBdtCode']);
            $this->db->set('FDCreateOn' , $paData['FDCreateOn']);
            $this->db->set('FTCreateBy' , $paData['FTCreateBy']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTBdtCode', $paData['FTBdtCode']);
            $this->db->update('TFNMBnkDepType');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TFNMBnkDepType',array(
                    'FTBdtCode' => $paData['FTBdtCode'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FTCreateBy' => $paData['FTCreateBy'],
                    'FDLastUpdOn' => $paData['FDLastUpdOn'],
                    'FTLastUpdBy' => $paData['FTLastUpdBy'],
                    'FTAgnCode'   => $paData['FTAgnCode'],
                    
                ));
                if($this->db->affected_rows() > 0){
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


    //Functionality : Update Lang Bank
    //Parameters : function parameters
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSaMBDTAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTBdtName', $paData['FTBdtName']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTBdtCode', $paData['FTBdtCode']);
            
            $this->db->update('TFNMBnkDepType_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TFNMBnkDepType_L',array(
                    'FTBdtCode' => $paData['FTBdtCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTBdtName' => $paData['FTBdtName']
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



    //Functionality : All Page Of Recive
    //Parameters : function parameters
    //Creator :  11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FsnMBDTGetPageAll($ptSearchList,$ptLngID,$tAgnCode){
        
        $tSQL = "SELECT COUNT (BDT.FTBdtCode) AS counts
                 FROM TFNMBnkDepType BDT
                 LEFT JOIN [TFNMBnkDepType_L] BDTL ON BDT.FTBdtCode = BDTL.FTBdtCode AND BDTL.FNLngID = $ptLngID
                 LEFT JOIN TCNMAgency_L AGN_L ON BDT.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $ptLngID
                 WHERE 1=1 ";

            if($tAgnCode != ''){
                $tSQL .= "AND BDT.FTAgnCode = $tAgnCode";
            }
        
        if($ptSearchList != ''){
            $tSQL .= " AND (BDT.FTBdtCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR BDTL.FTBdtName LIKE '%$ptSearchList%')";
        }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }
    
    
    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMBDTCheckDuplicate($ptBDTCode){
        $tSQL = "SELECT COUNT(FTBdtCode)   AS counts
                 FROM TFNMBnkDepType
                 WHERE FTBdtCode = '$ptBDTCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
    
    //Functionality : Delete Recive
    //Parameters : function parameters
    //Creator : 14/05/2018 wasin
    //Return : response
    //Return Type : array
    public function FSnMBDTDel($paData){
        $this->db->where_in('FTBdtCode', $paData['FTBdtCode']);
        $this->db->delete('TFNMBnkDepType');
        
        $this->db->where_in('FTBdtCode', $paData['FTBdtCode']);
        $this->db->delete('TFNMBnkDepType_L');
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
    


      //Functionality : Delete Agency
    //Parameters : function parameters
    //Creator : 11/06/2019 saharat(Golf)
    //Return : response
    //Return Type : array
    public function FSnMBDTDelete($paData){
        $this->db->where_in('FTBdtCode', $paData['FTBdtCode']);
        $this->db->delete('TFNMBnkDepType');
 
        $this->db->where_in('FTBdtCode', $paData['FTBdtCode']);
        $this->db->delete('TFNMBnkDepType_L');
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
    //Creator : 11/06/2019 saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMBDTGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMBnkDepType";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }


    //Functionality : Update&insert bank
    //Parameters : function parameters
    //Creator : 10/06/2019 nonpawich (petch)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMBDTAddAndUpdateMaster($paData){
        try{

           
                //Update Master
                $this->db->set('FTBdtCode' , $paData['FTBdtCode']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->where('FTBdtCode', $paData['FTBdtCode']);
                $this->db->update('TFNMBnkDepType');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                }else{
                    //Add Master
                    $this->db->insert('TFNMBnkDepType',array(
                        'FTBdtCode' => $paData['FTBdtCode'],
                        'FDLastUpdOn' => $paData['FDLastUpdOn']        
                    ));
                    if($this->db->affected_rows() > 0){
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
   
}


