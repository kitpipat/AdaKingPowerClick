<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCreditcard extends CI_Model {
    
    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCDCSearchByID($paData){

        $tCrdCode   = $paData['FTCrdCode'];
        $nLngID     = $paData['FNLngID'];
        $tImgTable  = $paData['FTImgTable'];
        
        $tSQL = "SELECT
                    CRD.FTCrdCode   AS rtCrdCode,
                    CRD.FTBnkCode   AS rtBnkCode,
                    BNKL.FTBnkName  AS rtBnkName,
                    CRD.FCCrdChgPer AS rtCrdChgPer,
                    CRD.FTCrdCrdFmt AS rtCrdCrdFmt,
                    CRDL.FTCrdName  AS rtCrdName,
                    CRDL.FTCrdRmk   AS rtCrdRmk,
                    IMG.FTImgObj    AS rtImgObj,
                    CRD.FTAgnCode        AS rtAgnCode,
                    AGN_L.FTAgnName      AS rtAgnName

                 FROM [TFNMCreditCard] CRD
                 LEFT JOIN TCNMAgency_L AGN_L ON CRD.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                 LEFT JOIN [TFNMCreditCard_L] CRDL ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                 LEFT JOIN [TFNMBank_L] BNKL ON CRD.FTBnkCode = BNKL.FTBnkCode AND BNKL.FNLngID = $nLngID
                 LEFT JOIN [TCNMImgObj] IMG  ON CRD.FTCrdCode = IMG.FTImgRefID AND IMG.FTImgTable = '$tImgTable'
                 WHERE 1=1 ";
        
        if($tCrdCode!= ""){
            $tSQL .= "AND CRD.FTCrdCode = '$tCrdCode'";
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
    public function FSaMCDCList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tImgTable  = $paData['FTImgTable'];
        $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");

        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTCrdCode DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                CDC.FTCrdCode,
                                CDCL.FTCrdName,
                                CDCL.FTCrdRmk,
                                BNKL.FTBnkName,
                                IMG.FTImgObj,
                                CDC.FDCreateOn
                            FROM [TFNMCreditCard] CDC
                            LEFT JOIN [TFNMCreditCard_L] CDCL ON CDC.FTCrdCode = CDCL.FTCrdCode AND CDCL.FNLngID = $nLngID
                            LEFT JOIN [TFNMBank_L] BNKL ON CDC.FTBnkCode = BNKL.FTBnkCode AND BNKL.FNLngID = $nLngID
                            LEFT JOIN [TCNMImgObj] IMG  ON CDC.FTCrdCode = IMG.FTImgRefID AND IMG.FTImgTable = '$tImgTable'
                            WHERE 1=1 ";
        
        if($tAgnCode != ''){
            $tSQL .= "AND CDC.FTAgnCode = $tAgnCode";
        }

        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (CDC.FTCrdCode LIKE '%$tSearchList%'";
            $tSQL .= "      OR CDCL.FTCrdName LIKE '%$tSearchList%')";
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
   
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCDCGetPageAll($tSearchList,$nLngID);
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
    
    //Functionality : Update Creditcard
    //Parameters : function parameters
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : 28/01/2020 Saharat(Golf)
    //Return : response
    //Return Type : Array
    public function FSaMCDCAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTBnkCode' ,   $paData['FTBnkCode']);
            $this->db->set('FCCrdChgPer' , $paData['FCCrdChgPer']);
            $this->db->set('FTCrdCrdFmt' , $paData['FTCrdCrdFmt']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTCrdCode',  $paData['FTCrdCode']);
            $this->db->update('TFNMCreditCard');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TFNMCreditCard',array(
                    'FTCrdCode'   => $paData['FTCrdCode'],
                    'FTBnkCode'   => $paData['FTBnkCode'],
                    'FCCrdChgPer' => $paData['FCCrdChgPer'],
                    'FTCrdCrdFmt' => $paData['FTCrdCrdFmt'],
                    'FDCreateOn'  => $paData['FDCreateOn'],
                    'FTCreateBy'  => $paData['FTCreateBy'],
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
    //Last Modified : 28/01/2020 Saharat(Golf)
    //Return : response
    //Return Type : num
    public function FSaMCDCAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTCrdName', $paData['FTCrdName']);
            $this->db->set('FTCrdRmk', $paData['FTCrdRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCrdCode', $paData['FTCrdCode']);
            $this->db->update('TFNMCreditCard_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TFNMCreditCard_L',array(
                    'FTCrdCode' => $paData['FTCrdCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCrdName' => $paData['FTCrdName'],
                    'FTCrdRmk'  => $paData['FTCrdRmk'],
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
    public function FSnMCDCGetPageAll($ptSearchList,$ptLngID){
        $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");
        $tSQL = "SELECT COUNT (CRD.FTCrdCode) AS counts
                 FROM TFNMCreditCard CRD
                 LEFT JOIN [TFNMCreditCard_L] CRDL ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $ptLngID
                 WHERE 1=1 ";

        if($tAgnCode != ''){
            $tSQL .= "AND CRD.FTAgnCode = $tAgnCode";
        }
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CRD.FTCrdCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CRDL.FTCrdName LIKE '%$ptSearchList%')";
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
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMCRDCheckDuplicate($ptCrdCode){
        $tSQL = "SELECT COUNT(FTCrdCode)AS counts
                 FROM TFNMCreditCard
                 WHERE FTCrdCode = '$ptCrdCode' ";
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
    public function FSnMCDCDel($paData){

        $this->db->where_in('FTCrdCode', $paData['FTCrdCode']);
        $this->db->delete('TFNMCreditCard');

        $this->db->where_in('FTCrdCode', $paData['FTCrdCode']);
        $this->db->delete('TFNMCreditCard_L');
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

    //Functionality : insert image 
    //Parameters : function parameters
    //Creator : 30/01/2020 Saharat(Golf)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMCDCAddUpdateImgObj($paData){ 
        try{
       
                $tParthImg          = $paData['tModuleName'].'/assets/systemimg/creditcard/'.$paData['tImgRefID'].'/'.$paData['tImgColor'];
                $aUrlPathServer 	= explode('/index.php',$_SERVER['SCRIPT_FILENAME']);
                $tPathFullComputer	= str_replace('\\', "/", $aUrlPathServer[0]. "/application/modules/");
                
                $this->db->where_in('FTImgTable', $paData['tImgTable']);
                $this->db->where_in('FTImgRefID', $paData['tImgRefID']);
                $this->db->delete('TCNMImgObj');

                //Add Master
                $this->db->insert('TCNMImgObj',array(
                    'FTImgRefID'        => $paData['tImgRefID'],
                    'FTImgTable'        => $paData['tImgTable'],
                    'FTImgObj'          => $tPathFullComputer.$tParthImg,
                    'FNImgSeq'          => 1,
                    'FTImgKey'          => $paData['tImgKey'],
                    'FDLastUpdOn'       => $paData['FDLastUpdOn'],
                    'FDCreateOn'        => $paData['FDCreateOn'],
                    'FTLastUpdBy'       => $paData['FTLastUpdBy'],
                    'FTCreateBy'        => $paData['FTCreateBy'],
                ));
                if($this->db->affected_rows() > 0){
                    if(file_exists('application/modules/creditcard/assets/systemimg/creditcard/color/'.$paData['tImgColor'])){
                        $tPart = 'modules/creditcard/assets/systemimg/creditcard/color/'.$paData['tImgColor'];
                        // เช็ค Folder System
                        if(!is_dir('./application/modules/'.$paData['tModuleName'].'/assets/systemimg/creditcard/'.$paData['tImgRefID'])){
                            mkdir('./application/modules/'.$paData['tModuleName'].'/assets/systemimg/creditcard/'.$paData['tImgRefID']);
                        }
                       
                        if(!empty($paData['tImgColor'])){
                            $files	= glob('application/modules/'.$paData['tModuleName'].'/assets/systemimg/'.$paData['tImgFolder']."/".$paData['tImgRefID']."/*"); // get all file names
                            foreach($files as $file){ // iterate files
                                if(is_file($file))
                                    unlink($file); // delete file
                            }
                        }
                            
                        copy(APPPATH.$tPart , APPPATH.'modules/'.$tParthImg);
                    }
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
            
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
