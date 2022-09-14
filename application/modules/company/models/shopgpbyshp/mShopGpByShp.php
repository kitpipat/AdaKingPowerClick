<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mShopGpByShp extends CI_Model {

    public function FSaMShopGpByShpDataList($paData){
        if($paData['tOcmBchCode'] != ''){
            $tBchCode =  trim($paData['tOcmBchCode']);
        }else{
            $aBchCode = explode(",",$paData['FTBchCode']);
            $tBchCode = $aBchCode[0]; 
        }
        
        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID         = $paData['FNLngID'];
        $tFDSgpStart    = $paData['tSearchAll'];
        $tFTBchCode     = $tBchCode;
        $tFTShpCode     = $paData['FTShpCode'];
        $tSQL           = " SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDSgpStart ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        SHPGP.FTBchCode,
                                        SHPGP.FTShpCode,
                                        SHPGP.FTPdtCode,
                                        SHPGP.FDSgpStart,
                                        SHPGP.FCSgpPerAvg,
                                        SHPGP.FCSgpPerMon,
                                        SHPGP.FCSgpPerTue,
                                        SHPGP.FCSgpPerWed,
                                        SHPGP.FCSgpPerThu,
                                        SHPGP.FCSgpPerFri,
                                        SHPGP.FCSgpPerSat,
                                        SHPGP.FCSgpPerSun,
                                        SHPGP.FNSgpSeq,
                                        BCHL.FTBchName
                                    FROM TCNMShopGP SHPGP
                                    LEFT JOIN TCNMBranch BCH    ON SHPGP.FTBchCode = BCH.FTBchCode
                                    LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode   = BCHL. FTBchCode AND BCHL.FNLngID =  $nLngID
                                    WHERE 1=1  AND SHPGP.FTPdtCode = '' AND SHPGP.FTBchCode = '$tFTBchCode' AND SHPGP.FTShpCode = '$tFTShpCode' ";
                                    
          if($tFDSgpStart != ''){ 
              $tSQL .= "  AND CONVERT(varchar(10),SHPGP.FDSgpStart,121) = '$tFDSgpStart' ";
          }else{
              $tSQL .= "";
          }
  
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aList          = $oQuery->result_array();
            $aFoundRow      = $this->FSaMShopGpByShpGetPageAll($paData);
            $nFoundRow      = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;

            $nPageAll       = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aDataReturn    = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
     
        }else{
            $aDataReturn    = array(
                'rtCode' => '800',
                'rtDesc' => 'Data not found.',
            );
        }
        return $aDataReturn;
    }

    
    public function FSaMShopGpByShpGetPageAll($paData){
        if($paData['tOcmBchCode'] != ''){
            $tBchCode = trim($paData['tOcmBchCode']);
        }else{
            $aBchCode = explode(",",$paData['FTBchCode']);
            $tBchCode = $aBchCode[0]; 
        }
        // $tBchCode       = $paData['FTBchCode'];
        $tOcmBchCode    = $paData['tOcmBchCode'];
        $nLngID         = $paData['FNLngID'];
        $tSearchList    = $paData['tSearchAll'];
        $tBchCode       = $tBchCode;
        $tShpCpde       = $paData['FTShpCode'];
        $tSQL   = " SELECT COUNT (SHPGP.FDSgpStart) AS counts
                    FROM TCNMShopGP SHPGP
                    WHERE 1=1 AND(SHPGP.FTBchCode = '$tBchCode' AND SHPGP.FTShpCode = '$tShpCpde') ";
        if(isset($tSearchList) && !empty($tSearchList)){
            // $tSQL .= " AND (SHPGP.FDSgpStart    LIKE '%$tSearchList%'";
            // $tSQL .= " OR SHPGP.FCSgpPerAvg     LIKE '%$tSearchList%'";
            $tSQL .= " AND ( SHPGP.FCSgpPerMon  LIKE '%$tSearchList%'";
            $tSQL .= " OR SHPGP.FCSgpPerTue     LIKE '%$tSearchList%'";
            $tSQL .= " OR SHPGP.FCSgpPerWed     LIKE '%$tSearchList%'";
            $tSQL .= " OR SHPGP.FCSgpPerThu     LIKE '%$tSearchList%'";
            $tSQL .= " OR SHPGP.FCSgpPerFri     LIKE '%$tSearchList%'";
            $tSQL .= " OR SHPGP.FCSgpPerSat     LIKE '%$tSearchList%'";
            $tSQL .= " OR SHPGP.FCSgpPerSun     LIKE '%$tSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        return $aDataReturn;
    }

    //Functionality : Check if Date 
    //Parameters : function parameters
    //Creator : 10/05/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMShpGpByShpCheckDateStart($paData){
        $tBchCode     = $paData['FTBchCode'];
        $tShpCode     = $paData['FTShpCode'];
        $tDateStart   = $paData['FDSgpStartNew'];

    
        
        $tSQL  = "SELECT TOP 1 FTPdtCode 
            FROM   TCNMShopGP
            WHERE  FTBchCode = '$tBchCode'  
            AND    FTShpCode = '$tShpCode'  
            AND   CONVERT(VARCHAR(10),FDSgpStart,121) = '$tDateStart'
         ";
    
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result_array();  
            $aResult = array(
                'raDetail'   => $oDetail[0],
                'rtCode'     => '1',
                'rtDesc'     => 'success',
            );
        }else{
            $aResult = array(
                'raDetail'   => $oQuery->result_array(),
                'rtCode'     => '800',
                'rtDesc'     => 'data not found.',
            );
        }
        return $aResult;
    }

    //Functionality : insert Data ShopGP
    //Parameters : function parameters
    //Creator : 10/05/2019 Saharat(Golf)
    //Return : Array
    //Return Type : Array
    public function FSaMSHPAddUpdateMaster($paData){
      
            try{
                //Add Master
                $this->db->insert('TCNMShopGP', array( 
                    'FNSgpSeq'          => $paData['FNSgpSeq'],
                    'FTPdtCode'         => $paData['FTPdtCode'],
                    'FTBchCode'         => $paData['FTBchCode'],
                    'FTShpCode'         => $paData['FTShpCode'],
                    'FCSgpPerAvg'       => $paData['FCSgpPerAvg'],
                    'FDSgpStart'        => $paData['FDSgpStartNew'],
                ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'Add ShopGP Success',
                    'rtBchCode'     => $paData['FTBchCode']
                );
            }else{
                $aStatus = array(
                    'rtCode'        => '905',
                    'rtDesc'        => 'Error Cannot Add/Edit ShopGP'
                );
            }
        return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Edit Data ShopGP
    //Parameters : function parameters
    //Creator : 02/07/2019 Saharat(Golf)
    //Return : Array
    //Return Type : Array
    public function FSaMSHPEditUpdateMaster($paData){  
        try{
            //Update Master
            $this->db->set('FTBchCode',   $paData['FTBchCode']);
            $this->db->set('FCSgpPerAvg', $paData['FCSgpPerAvg']);
            $this->db->set('FDSgpStart' , $paData['FDSgpStartNew']);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FDSgpStart',$paData['FDSgpStartOld']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->where('FNSgpSeq', $paData['FNSgpSeq']);
            $this->db->where('FTPdtCode',"");
            $this->db->update('TCNMShopGP');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update ShopGp Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Edit ShopGp',
            );
        }
        return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Data TCNMShopGP
    //Parameters : function parameters
    //Creator : 13/05/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMSHPDel($paData){
        if($paData['FTOCBchCode'] != ''){
            $tBchCode = trim($paData['FTOCBchCode']);
        }else{
            $aBchCode = explode(",",$paData['FTBchCode']);
            $tBchCode = $aBchCode[0]; 
        }
        try{

            $this->db->trans_begin();
            $this->db->where_in('FTBchCode', $tBchCode);
            $this->db->where_in('FDSgpStart', $paData['FDSgpStart']);
            $this->db->delete('TCNMShopGP');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '500',
                    'rtDesc' => 'Error Cannot Delete ShopGP.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete ShopGP Success.',
                    'rtBchCode' => $tBchCode
                );
            }
        }catch(Exception $Error){
            $aStatus = array(
                'rtCode' => '500',
                'rtDesc' => $Error->getMessage()
            );
        }
        return $aStatus;
    }

    //Functionality : Delete Data TCNMShopGP
    //Parameters : function parameters
    //Creator : 13/05/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMSHPDelAll($paData){
            try{
                $this->db->trans_begin();
                $this->db->where_in('FTShpCode', $paData['pnSHP']);
                $this->db->where_in('FNSgpSeq', $paData['pnSeq']);
                $this->db->where_in('FTBchCode', $paData['tBchCode']);
                $this->db->where_in('FDSgpStart', $paData['tDstCode']);
                $this->db->delete('TCNMShopGP');
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aStatus = array(
                        'rtCode' => '500',
                        'rtDesc' => 'Error Cannot Delete ShopGP.',
                    );
                }else{
                    $this->db->trans_commit();
                    $aStatus = array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'Delete ShopGP Success.',
                        'rtBchCode' => $paData['tBchCode']
                    );
                }
            }catch(Exception $Error){
                $aStatus = array(
                    'rtCode' => '500',
                    'rtDesc' => $Error->getMessage()
                );
            }
        return $aStatus;
    }

    //Check duplicate
    public function FSaMSHPCheckDatabeforeUpdate($paData){
        $tSHPCode = $paData['FTShpCode'];
        $dDateStr = $paData['FDSgpStart'];
        $tSQL = "SELECT FDSgpStart FROM TCNMShopGP WHERE FDSgpStart = '$dDateStr' AND FTShpCode = '$tSHPCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Update Edit inline
    //Parameters : function parameters
    //Creator : 22/05/2019 Saharat(Golf)
    //Return : text
    //Return Type : Array
    public function FSaMSHPUpdateDataInline($paData){  
        try{
            // Update TCNMShopGP
            $this->db->where('FTShpCode' , $paData['FTShpCode']);
            $this->db->where('FTBchCode' , $paData['FTBchCode']);
            $this->db->where('FDSgpStart', $paData['FDSgpStart']);

            $this->db->update('TCNMShopGP',array(
                'FCSgpPerAvg'      => $paData['FCSgpPerAvg'],
                'FCSgpPerMon'      => $paData['FCSgpPerMon'],
                'FCSgpPerTue'      => $paData['FCSgpPerTue'],
                'FCSgpPerWed'      => $paData['FCSgpPerWed'],
                'FCSgpPerThu'      => $paData['FCSgpPerThu'],
                'FCSgpPerFri'      => $paData['FCSgpPerFri'],
                'FCSgpPerSat'      => $paData['FCSgpPerSat'],
                'FCSgpPerSun'      => $paData['FCSgpPerSun']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update  SHOP ByGP  Success',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //function select DT
    public function FSaMShopGpBySelectDataDT($paData,$ptTypeCheck){
        $tFTShpCode     = $paData['FTShpCode'];
        $tFTBchCode     = $paData['FTBchCode'];
        $tLangID        = $paData['FNLngID'];
        

        if($ptTypeCheck == 'shop'){
            $tSQL   = "SELECT TOP 1 SHPL.FTShpName FROM TCNMShop_L SHPL WHERE SHPL.FTShpCode = '$tFTShpCode' AND SHPL.FTBchCode = '$tFTBchCode' AND FNLngID = '$tLangID' ";
        }else if($ptTypeCheck == 'branch'){
            $tSQL   = "SELECT TOP 1 BCHL.FTBchName FROM TCNMBranch_L BCHL WHERE BCHL.FTBchCode = '$tFTBchCode' AND FNLngID = '$tLangID'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aDataReturn        = array(
                'raItems'       => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        return $aDataReturn;
    }
    
    //function Get Data page Efit
    public function FSaMShopGpGetData($paData){
        $tDateStart     = $paData['FDSgpStart'];
        $tFTBchCode     = $paData['FTBchCode'];
        $tFTShpCode     = $paData['FTShpCode'];
        $nLngID         = $paData['FNLngID'];
        $tSQL   = "SELECT 
                SHPG.FTBchCode,
                SHPG.FTShpCode,
                SHPG.FDSgpStart,
                SHPG.FCSgpPerAvg,
                BCHL.FTBchName,
                SHPG.FNSgpSeq
        FROM TCNMShopGP SHPG
        LEFT JOIN TCNMBranch BCH    ON SHPG.FTBchCode = BCH.FTBchCode
        LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode  = BCHL.FTBchCode AND  BCHL.FNLngID = $nLngID
        WHERE 1=1 AND SHPG.FTBchCode = '$tFTBchCode'  AND SHPG.FDSgpStart = '$tDateStart' AND SHPG.FTShpCode = '$tFTShpCode' ";
    
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aDataReturn        = array(
                'raItems'       => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        return $aDataReturn;
    }
    
    //check SHOP GP Data 
    public function FSaMShopGpByShpCheckeData($paData){

        $nLngID         = $paData['FNLngID'];
        $tBchCode       = $paData['FTBchCode'];
        $tShpCpde       = $paData['FTShpCode'];
        $dDateNew       = $paData['FDSgpStartNew'];
        $tSQL           = " SELECT 
                                SHPGP.FTBchCode,
                                SHPGP.FTShpCode,
                                SHPGP.FTPdtCode,
                                SHPGP.FDSgpStart,
                                SHPGP.FCSgpPerAvg,
                                SHPGP.FCSgpPerMon,
                                SHPGP.FCSgpPerTue,
                                SHPGP.FCSgpPerWed,
                                SHPGP.FCSgpPerThu,
                                SHPGP.FCSgpPerFri,
                                SHPGP.FCSgpPerSat,
                                SHPGP.FCSgpPerSun,
                                BCHL.FTBchName
                            FROM TCNMShopGP SHPGP
                            LEFT JOIN TCNMBranch BCH    ON SHPGP.FTBchCode = BCH.FTBchCode
                            LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode   = BCHL. FTBchCode AND BCHL.FNLngID =  $nLngID
                            WHERE 1=1 AND SHPGP.FDSgpStart = CONVERT(DATE,'$dDateNew',121) AND SHPGP.FTBchCode = '$tBchCode' 
                            AND SHPGP.FTShpCode = '$tShpCpde' AND SHPGP.FTPdtCode = '' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
            $aDataReturn    = array(
                'raItems'       => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
                'rtCode' => '800',
                'rtDesc' => 'Data not found.',
            );
        }
        return $aDataReturn;
    }

    //Delete data TCNMShopGP
    public function FSaMShopGpByShpDateDeleteData($paData){
        $nLngID         = $paData['FNLngID'];
        $tBchCode       = $paData['FTBchCode'];
        $tShpCpde       = $paData['FTShpCode'];
        $dDateOld       = $paData['FDSgpStartOld'];
        
        $tSQL           = " DELETE
                            FROM TCNMShopGP 
                            WHERE 1=1 
                            AND FDSgpStart = '$dDateOld'  
                            AND FTShpCode =  '$tShpCpde'
                            AND FTBchCode = '$tBchCode'
                            AND FTPdtCode =  ' '
                          ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery){
            $aDataReturn    = array(
                'rtCode'        => '1',
                'rtDesc'        => 'delete success',
            );
        }else{
            $aDataReturn    = array(
                'rtCode' => '800',
                'rtDesc' => 'delete not found.',
            );
        }
        return $aDataReturn;
    }

    //Functionality : Update Data GpShop
    //Parameters : function parameters
    //Creator : 02/07/2019 Saharat(Golf)
    //Return : 
    //Return Type : 
    public function FSaMSHPGPEditUpdateMaster($paData){  
        try{
            //Update Master
            $this->db->set('FCSgpPerSun',   $paData['FCSgpPerSun']);
            $this->db->set('FCSgpPerMon',   $paData['FCSgpPerMon']);
            $this->db->set('FCSgpPerTue',   $paData['FCSgpPerTue']);
            $this->db->set('FCSgpPerWed',   $paData['FCSgpPerWed']);
            $this->db->set('FCSgpPerThu',   $paData['FCSgpPerThu']);
            $this->db->set('FCSgpPerFri',   $paData['FCSgpPerFri']);
            $this->db->set('FCSgpPerSat',   $paData['FCSgpPerSat']);

            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->where('FDSgpStart',$paData['FDSgpStart']);
            $this->db->where('FTPdtCode',"");
            $this->db->update('TCNMShopGP');

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : get all row 
    //Parameters : -
    //Creator : 13/08/2019 saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMMSHPGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMShopGP";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    //Find Seq in GP
    public function FSaMShopGpFindSeq($tSHP,$tBCH){
        $tSQL  = "SELECT TOP 1 FNSgpSeq FROM TCNMShopGP WHERE 1=1 ";
        $tSQL .= " AND FTShpCode = '$tSHP' AND FTBchCode = '$tBCH' ORDER BY FNSgpSeq DESC ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

}