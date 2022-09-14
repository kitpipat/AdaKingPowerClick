<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mVendingshoplayout extends CI_Model {

    
    //Functionality : Search Vending shop layout By ID
    //Parameters : function parameters
    //Creator : 08/05/2018 Supawat
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMVslSearchByID($ptAPIReq,$ptMethodReq,$paData){
        $tVslCode       = $paData['FTShpCode'];
        $nLngID         = $paData['FNLngID'];
        
        $tSQL = "SELECT
                        Vsl.FTBchCode AS rtVslBch,
                        BchL.FTBchName  AS rtBchName,
                        Vsl.FTShpCode AS rtVslShp,
                        Vsl.FCLayRowQty AS rtVslRowQty,
                        Vsl.FCLayColQty AS rtVslColQty,
                        Vsl.FTLayStaUse AS rtVslStaUse,
                        Vsl_L.FTLayName AS rtVslName,
                        Vsl_L.FTLayRemark AS rtVslRemark,
                        Shp_L.FTShpName AS rtShpName
                    FROM [TVDMShopSize] Vsl
                    LEFT JOIN [TCNMBranch_L] BchL ON Vsl.FTBchCode = BchL.FTBchCode AND BchL.FNLngID = $nLngID 
                    LEFT JOIN [TVDMShopSize_L] Vsl_L ON Vsl.FTShpCode = Vsl_L.FTShpCode AND Vsl_L.FNLngID = $nLngID
                    LEFT JOIN [TCNMShop_L] Shp_L ON Vsl.FTShpCode = Shp_L.FTShpCode AND Vsl.FTBchCode = SHP_L.FTBchCode  AND Shp_L.FNLngID = $nLngID
                    WHERE 1=1 ";
        
        if($tVslCode!= ""){
            $tSQL .= "AND Vsl.FTShpCode = '$tVslCode'  ";
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
    
    //Functionality : list Vending shop layout 
    //Parameters : function parameters
    //Creator :  08/05/2018 Supawat
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMVslList($ptAPIReq,$ptMethodReq,$paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        
        $nLngID = $paData['FNLngID'];
        
        $tSQL = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY rtVslShp ASC) AS rtRowID,* FROM
                        (SELECT DISTINCT
                            Vsl.FTBchCode AS rtVslBch,
                            BchL.FTBchName  AS rtBchName,
                            Vsl.FTShpCode AS rtVslShp,
                            Vsl.FCLayRowQty AS rtVslRowQty,
                            Vsl.FCLayColQty AS rtVslColQty,
                            Vsl.FTLayStaUse AS rtVslStaUse,
                            Vsl_L.FTLayName AS rtVslName,
                            Shp_L.FTShpName AS rtShpName
                         FROM [TVDMShopSize] Vsl
                         LEFT JOIN [TCNMBranch_L] BchL ON Vsl.FTBchCode = BchL.FTBchCode AND BchL.FNLngID = $nLngID 
                         LEFT JOIN [TVDMShopSize_L] Vsl_L ON Vsl.FTShpCode = Vsl_L.FTShpCode AND Vsl_L.FNLngID = $nLngID
                        LEFT JOIN [TCNMShop_L] SHP_L ON Vsl.FTShpCode = SHP_L.FTShpCode AND Vsl.FTBchCode = SHP_L.FTBchCode AND SHP_L.FNLngID = $nLngID 
                         WHERE 1=1 ";
        
       
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (Vsl.FTShpCode LIKE '%$tSearchList%'";
            $tSQL .= " OR Vsl_L.FTLayName LIKE '%$tSearchList%')";
        }

        $nSessionBCH = $paData['nSessionBCH'];
        $nSessionSHP = $paData['nSessionSHP'];

        if($nSessionBCH == '' &&  $nSessionSHP == ''){

        }else if($nSessionBCH != '' &&  $nSessionSHP == ''){
            $tSQL .= " AND (Vsl.FTBchCode = '$nSessionBCH' )";
        }else if($nSessionBCH != '' &&  $nSessionSHP != ''){
            $tSQL .= " AND (Vsl.FTBchCode = '$nSessionBCH' AND Vsl.FTShpCode = '$nSessionSHP')";
        }

        
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMVslGetPageAll($tSearchList,$nLngID,$nSessionBCH,$nSessionSHP);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => $nPageAll, 
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        
        return $aResult;
    }

    //Functionality : All Page Of Vending shop layout 
    //Parameters : function parameters
    //Creator :  08/05/2018 Supawat
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMVslGetPageAll($ptSearchList,$ptLngID,$nSessionBCH,$nSessionSHP){
        
        $tSQL = "SELECT COUNT (Vsl.FTShpCode) AS counts

                 FROM TVDMShopSize Vsl
                 LEFT JOIN [TVDMShopSize_L] Vsl_L ON Vsl.FTShpCode = Vsl_L.FTShpCode AND Vsl_L.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (Vsl.FTShpCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR Vsl_L.FTLayName LIKE '%$ptSearchList%')";
        }

        if($nSessionBCH == '' &&  $nSessionSHP == ''){

        }else if($nSessionBCH != '' &&  $nSessionSHP == ''){
            $tSQL .= " AND (Vsl.FTBchCode = '$nSessionBCH' )";
        }else if($nSessionBCH != '' &&  $nSessionSHP != ''){
            $tSQL .= " AND (Vsl.FTBchCode = '$nSessionBCH' AND Vsl.FTShpCode = '$nSessionSHP')";
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
    //Creator : 10/05/2018 Supawat
    //Last Modified : -
    //Return : Data Count Duplicate
    //Return Type : Object
    public function FSoMVslCheckDuplicate($ptVslCode,$ptVslBCH){
        $tSQL   = "SELECT COUNT(FTShpCode)AS counts
                   FROM TVDMShopSize
                   WHERE FTShpCode = '$ptVslCode' AND FTBchCode = '$ptVslBCH' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add/Update Master (HD)
    //Parameters : function parameters
    //Creator : 10/05/2018 Supawat
    //Last Modified : 11/06/2018 Supawat
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMVslAddUpdateMaster($paData){
        try{
            //Update Master
			$this->db->set('FCLayRowQty' , $paData['FCLayRowQty']);
			$this->db->set('FCLayColQty'   , $paData['FCLayColQty']);
            $this->db->set('FTLayStaUse'   , $paData['FTLayStaUse']);
            $this->db->set('FDLastUpdOn'   , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy'   , $paData['FTLastUpdBy']);
            
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->update('TVDMShopSize');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TVDMShopSize',array(
                    'FTBchCode'      => $paData['FTBchCode'],
                    'FTShpCode'      => $paData['FTShpCode'],
                    'FCLayRowQty'    => $paData['FCLayRowQty'],
                    'FCLayColQty'    => $paData['FCLayColQty'],
                    'FTLayStaUse'    => $paData['FTLayStaUse'],
                    'FDCreateOn'     => $paData['FDCreateOn'],
                    'FTCreateBy'     => $paData['FTCreateBy'],
                    'FDLastUpdOn'     => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'     => $paData['FTLastUpdBy']

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
    //Creator :  10/05/2018 Supawat
    //Last Modified : 11/06/2018 Supawat
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMVslAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTLayName'      , $paData['FTLayName']);
            $this->db->set('FTLayRemark'    , $paData['FTLayRemark']);
            $this->db->where('FNLngID'      , $paData['FNLngID']);
            $this->db->where('FTShpCode'      , $paData['FTShpCode']);
            $this->db->update('TVDMShopSize_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                //Add Lang
                $this->db->insert('TVDMShopSize_L',array(
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTShpCode'     => $paData['FTShpCode'],
                    'FNLngID'       => $paData['FNLngID'],
                    'FTLayName'     => $paData['FTLayName'],
                    'FTLayRemark'   => $paData['FTLayRemark']
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

    //Functionality : Delete Vending shop layout
    //Parameters : function parameters
    //Creator : 10/05/2018 Supawat
    //Return : response
    //Return Type : array
    public function FSnMVslDel($ptAPIReq,$ptMethodReq,$paData){
        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        $this->db->delete('TVDMShopSize');

        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        $this->db->delete('TVDMShopSize_L');
        
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

    //Delete Product
    public function FSaMVslDeleteProduct($paData,$ptType){
        if($ptType == 'ALL'){ //ลบสินค้าทั้งหมด
            $this->db->where_in('FTShpCode', $paData['FTShpCode']);
            $this->db->delete('TVDMPdtLayout');
        }else if($ptType == 'ROW'){ //ลบสินค้า บางชั้น
            $nSHOP  = $paData['FTShpCode'];
            $nROW   = $paData['FCLayRowQty'];
            $tSQL   = "DELETE FROM TVDMPdtLayout WHERE FTShpCode = '$nSHOP' AND FNLayRow > '$nROW' ";
            $oQuery = $this->db->query($tSQL);
        }
    }
}