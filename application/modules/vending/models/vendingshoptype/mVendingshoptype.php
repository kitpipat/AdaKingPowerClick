<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mVendingshoptype extends CI_Model {
    
    //Functionality : Search Vending shop type By ID
    //Parameters : function parameters
    //Creator : 08/05/2018 Supawat
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMVstSearchByID($ptAPIReq,$ptMethodReq,$paData){
        // $tVstCode       = $paData['FTShpCode'];
        // $tBchCode       = $paData['FTBchCode'];
        // $nLngID         = $paData['FNLngID'];
        
        // $tSQL = "SELECT
        //                 Vst.FTBchCode   AS rtVstBch,
        //                 BchL.FTBchName  AS rtBchName,
        //                 Vst.FTShpCode   AS rtVstCode,
		// 				Vst.FTShtType   AS rtVstType,
		// 				Vst.FNShtValue  AS rtVstTempAgg ,
		// 				Vst.FNShtMin    AS rtVstTempMin,
		// 				Vst.FNShtMax    AS rtVstTempMax,
		// 				VstL.FTShtName  AS rtVstName,
		// 				VstL.FTShtRemark  AS rtVstRemark,
        //                 ShpL.FTShpName AS  rtVstShopName
        //             FROM [TVDMShopType] Vst
        //             LEFT JOIN [TCNMBranch_L] BchL ON Vst.FTBchCode = BchL.FTBchCode AND BchL.FNLngID = $nLngID 
        //             LEFT JOIN [TVDMShopType_L] VstL ON Vst.FTShpCode = VstL.FTShpCode AND VstL.FNLngID = $nLngID
        //             LEFT JOIN [TCNMShop_L] ShpL ON Vst.FTShpCode = ShpL.FTShpCode AND Vst.FTBchCode = ShpL.FTBchCode AND ShpL.FNLngID = $nLngID
        //             WHERE 1=1 ";
        
        // if($tVstCode!= ""){
        //     $tSQL .= "AND Vst.FTShpCode = '$tVstCode' ";
        // }
        // $oQuery = $this->db->query($tSQL);
        // if ($oQuery->num_rows() > 0){
        //     $oDetail = $oQuery->result();
        //     $aResult = array(
        //         'raItems'   => $oDetail[0],
        //         'rtCode'    => '1',
        //         'rtDesc'    => 'success',
        //     );
        // }else{
        //     //Not Found
        //     $aResult = array(
        //         'rtCode' => '800',
        //         'rtDesc' => 'data not found.',
        //     );
        // }
        // $jResult = json_encode($aResult);
        // $aResult = json_decode($jResult, true);
        // return $aResult;
    }
    
    //Functionality : list Vending shop type 
    //Parameters : function parameters
    //Creator :  08/05/2018 Supawat
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMVstList($ptAPIReq,$ptMethodReq,$paData){

        // $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        
        // $nLngID = $paData['FNLngID'];
        
        // $tSQL = "SELECT c.* FROM(
        //             SELECT  ROW_NUMBER() OVER(ORDER BY rtVstCode ASC) AS rtRowID,* FROM
        //                 (SELECT DISTINCT
        //                     Vst.FTBchCode   AS rtVstBch,
		// 					Vst.FTShpCode   AS rtVstCode,
		// 					Vst.FTShtType   AS rtVstType,
		// 					Vst.FNShtValue  AS rtVstTempAgg ,
		// 					Vst.FNShtMin    AS rtVstTempMin,
		// 					Vst.FNShtMax    AS rtVstTempMax,
		// 					VstL.FTShtName  AS rtVstName,
		// 					VstL.FTShtRemark  AS rtVstRemark,
        //                     ShpL.FTShpName AS  rtVstShopName
        //                  FROM [TVDMShopType] Vst
        //                  LEFT JOIN [TVDMShopType_L] VstL ON Vst.FTShpCode = VstL.FTShpCode AND VstL.FNLngID = $nLngID
        //                  LEFT JOIN [TCNMShop_L] ShpL ON Vst.FTShpCode = ShpL.FTShpCode AND Vst.FTBchCode = ShpL.FTBchCode AND ShpL.FNLngID = $nLngID
        //                  WHERE 1=1 ";
        
        // $tSearchList = $paData['tSearchAll'];
        // if ($tSearchList != ''){
        //     $tSQL .= " AND (Vst.FTShpCode LIKE '%$tSearchList%'";
        //     $tSQL .= " OR VstL.FTShtName LIKE '%$tSearchList%')";
        // }
        
        // $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        // $oQuery = $this->db->query($tSQL);
        // if ($oQuery->num_rows() > 0) {
        //     $oList = $oQuery->result();
        //     $aFoundRow = $this->FSnMVstGetPageAll($tSearchList,$nLngID);
        //     $nFoundRow = $aFoundRow[0]->counts;
        //     $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
        //     $aResult = array(
        //         'raItems' => $oList,
        //         'rnAllRow' => $nFoundRow,
        //         'rnCurrentPage' => $paData['nPage'],
        //         "rnAllPage"=> $nPageAll, 
        //         'rtCode' => '1',
        //         'rtDesc' => 'success',
        //     );
        //     $jResult = json_encode($aResult);
        //     $aResult = json_decode($jResult, true);
        // }else{
        //     //No Data
        //     $aResult = array(
        //         'rnAllRow' => 0,
        //         'rnCurrentPage' => $paData['nPage'],
        //         "rnAllPage"=> 0,
        //         'rtCode' => '800',
        //         'rtDesc' => 'data not found',
        //     );
        //     $jResult = json_encode($aResult);
        //     $aResult = json_decode($jResult, true);
        // }
        
        // return $aResult;
    }

    //Functionality : All Page Of Vending shop type 
    //Parameters : function parameters
    //Creator :  08/05/2018 Supawat
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMVstGetPageAll($ptSearchList,$ptLngID){
        
        // $tSQL = "SELECT COUNT (Vst.FTShpCode) AS counts

        //          FROM TVDMShopType Vst
        //          LEFT JOIN [TVDMShopType_L] VstL ON Vst.FTShpCode = VstL.FTShpCode AND VstL.FNLngID = $ptLngID
        //          WHERE 1=1 ";
        
        // if($ptSearchList != ''){
        //     $tSQL .= " AND (Vst.FTShpCode LIKE '%$ptSearchList%'";
        //     $tSQL .= " OR VstL.FTShtName LIKE '%$ptSearchList%')";
        // }
        // $oQuery = $this->db->query($tSQL);
        // if ($oQuery->num_rows() > 0) {
        //     return $oQuery->result();
        // }else{
        //     //No Data
        //     return false;
        // }
    }

    
    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 10/05/2018 Supawat
    //Last Modified : -
    //Return : Data Count Duplicate
    //Return Type : Object
    public function FSoMVstCheckDuplicate($ptVstCode){
        $tSQL   = "SELECT COUNT(FTShtCode) AS counts
                   FROM TVDMShopType
                   WHERE FTShtCode = '$ptVstCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 10/05/2018 Supawat
    //Last Modified : 11/06/2018 Supawat
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMVstAddUpdateMaster($paData,$ptType){
        try{
            //Add Master    
            if($ptType == 'Add'){
                $this->db->insert('TVDMShopType',array(
                    'FTShtCode'     => $paData['FTShtCode'],
                    'FTShtType'     => $paData['FTShtType'],
                    'FNShtValue'    => $paData['FNShtValue'],
                    'FNShtMin'      => $paData['FNShtMin'],
                    'FNShtMax'      => $paData['FNShtMax'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy']
                ));
            }
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
    public function FSaMVstAddUpdateLang($paData,$ptType){
        try{
            //Add Lang
            if($ptType == 'Add'){
                $this->db->insert('TVDMShopType_L',array(
                    'FTShtCode'         => $paData['FTShtCode'],
                    'FNLngID'           => $paData['FNLngID'],
                    'FTShtName'         => $paData['FTShtName'],
                    'FTShtRemark'       => $paData['FTShtRemark']
                ));
            }

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
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Delete Vending shop type
    //Parameters : function parameters
    //Creator : 10/05/2018 Supawat
    //Return : response
    //Return Type : array
    public function FSnMVstDel($ptAPIReq,$ptMethodReq,$paData){
        // $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        // $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        // $this->db->delete('TVDMShopType');
        
        // $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        // $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        // $this->db->delete('TVDMShopType_L');
        
        // if($this->db->affected_rows() > 0){
        //     //Success
        //     $aStatus = array(
        //         'rtCode' => '1',
        //         'rtDesc' => 'success',
        //     );
        // }else{
        //     //Ploblem
        //     $aStatus = array(
        //         'rtCode' => '905',
        //         'rtDesc' => 'cannot Delete Item.',
        //     );
        // }
        // $jStatus = json_encode($aStatus);
        // $aStatus = json_decode($jStatus, true);
        // return $aStatus;
    }
}