<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
date_default_timezone_set("Asia/Bangkok");
class mRate extends CI_Model {
    
    //Functionality : Search Rate By ID
    //Parameters : function parameters
    //Creator : 04/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTESearchByID($paData){

        $tRteCode   = $paData['FTRteCode'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL   = " SELECT
                        RTE.FTRteCode       AS rtRteCode,
                        RTE.FCRteRate       AS rcRteRate,
                        RTE.FCRteFraction   AS rcRteFraction,
                        RTE.FTRteType       AS rtRteType,
                        RTE.FTRteTypeChg    AS rcRteTypeChg,
                        RTE.FTRteSign       AS rcRteSign,
                        RTE.FTRteStaLocal   AS rcRteStaLocal,
                        RTE.FTRteStaUse     AS rtRteStaUse,
                        RTEL.FTRteName      AS rtRteName,
                        RTEL.FTRteShtName   AS rtRteShtName,
                        RTEL.FTRteNameText  AS rtRteNameText,
                        RTEL.FTRteDecText   AS rtRteDecText,
                        RTE.FTRteStaUse     AS rtRteStaUse,
                        RTE.FTRteStaLocal   AS rtRteStaLocal,
                        IMGO.FTImgObj       AS rtImgObj
                    FROM [TFNMRate] RTE WITH(NOLOCK)
                    LEFT JOIN [TFNMRate_L] RTEL WITH(NOLOCK) ON RTE.FTRteCode = RTEL.FTRteCode AND RTEL.FNLngID = $nLngID
                    LEFT JOIN [TCNMImgObj] IMGO WITH(NOLOCK) ON RTE.FTRteCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TFNMRate' AND IMGO.FNImgSeq = 1
                    WHERE 1=1 
        ";
        
        if($tRteCode != ""){
            $tSQL .= "AND RTE.FTRteCode = '$tRteCode'";
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
    
    //Functionality : list Rate
    //Parameters : function parameters
    //Creator :  11/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTEList($paData){
        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tSearchList = $paData['tSearchAll'];
       
        $tSQL   = " SELECT c.* FROM(
                         SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC,FTRteCode DESC) AS FNRowID,* 
                        FROM
                            (SELECT DISTINCT
                                    RTE.FTRteCode,
                                    RTE.FCRteRate,
                                    RTE.FCRteFraction,
                                    RTE.FTRteType,
                                    RTE.FTRteTypeChg,
                                    RTE.FTRteSign,
                                    RTE.FTRteStaLocal,
                                    RTE.FTRteStaUse,
                                    RTEL.FTRteName,
                                    RTEL.FTRteShtName,
                                    RTEL.FTRteNameText,
                                    RTEL.FTRteDecText,
                                    IMGO.FTImgObj,
                                    RTE.FDCreateOn,
                                    CASE
                                        WHEN ISNULL(COMP.FTRteCode,'')  != '' THEN '1'
                                        WHEN ISNULL(ASPC.FTRteCode,'')  != '' THEN '1'
                                        WHEN ISNULL(PSSAL.FTRteCode,'') != '' THEN '1'
                                        WHEN ISNULL(VDSAL.FTRteCode,'') != '' THEN '1'
                                    ELSE
                                        '2'
                                    END AS FTStaRef
                            FROM [TFNMRate] RTE WITH(NOLOCK)
                            LEFT JOIN [TFNMRate_L] RTEL WITH(NOLOCK) ON RTE.FTRteCode = RTEL.FTRteCode   AND RTEL.FNLngID    = $nLngID
                            LEFT JOIN [TCNMImgObj] IMGO WITH(NOLOCK) ON RTE.FTRteCode = IMGO.FTImgRefID  AND IMGO.FTImgTable = 'TFNMRate' AND IMGO.FNImgSeq  = 1
                            LEFT JOIN TCNMComp COMP WITH(NOLOCK) ON RTE.FTRteCode = COMP.FTRteCode
                            LEFT JOIN (
                                SELECT DISTINCT FTRteCode FROM TCNMAgencySpc WITH(NOLOCK)
                            ) ASPC ON RTE.FTRteCode = ASPC.FTRteCode
                            LEFT JOIN (
                                SELECT DISTINCT FTRteCode FROM TPSTSalHD WITH(NOLOCK)
                            ) PSSAL ON RTE.FTRteCode = PSSAL.FTRteCode
                            LEFT JOIN (
                                SELECT DISTINCT FTRteCode FROM TVDTSalHD WITH(NOLOCK)
                            ) VDSAL ON RTE.FTRteCode = VDSAL.FTRteCode
                            WHERE 1=1
                    ";
        
        if($tSearchList != ''){
            $tSQL   .= " AND (RTE.FTRteCode COLLATE  THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR RTEL.FTRteName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }
    
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMRTEGetPageAll($tSearchList,$nLngID);
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
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMRTEAddUpdateMaster($paData){
        if($paData['FTRteStaLocal']== 1){
            $tRteCode      = $paData['FTRteCode'];
            $tRteStalocal  = $paData['FTRteStaLocal'];
    
            $tSQL  = "SELECT FTRteCode
                      FROM TFNMRate 
                      WHERE FTRteStaLocal = '$tRteStalocal' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aData = $oQuery->result();

                $aDataUpdate = array(
                    'FTRteStaLocal' => 2,
                );

                $this->db->where('FTRteCode', $aData[0]->FTRteCode);
                $this->db->update('TFNMRate', $aDataUpdate);
            }
        }

        try{
            //Update Master
            $this->db->set('FCRteRate' , $paData['FCRteRate']);
            $this->db->set('FCRteFraction' , $paData['FCRteFraction']);
            $this->db->set('FTRteType' , $paData['FTRteType']);
            $this->db->set('FTRteSign' , $paData['FTRteSign']);
            $this->db->set('FTRteStaUse' , $paData['FTRteStaUse']);
            $this->db->set('FTRteStaLocal' , $paData['FTRteStaLocal']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

            $this->db->where('FTRteCode', $paData['FTRteCode']);
            $this->db->update('TFNMRate');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TFNMRate',array(
                    'FTRteCode'     => $paData['FTRteCode'],
                    'FCRteRate'     => $paData['FCRteRate'],
                    'FCRteFraction' => $paData['FCRteFraction'],
                    'FTRteType'     => $paData['FTRteType'],
                    'FTRteSign'     => $paData['FTRteSign'],
                    'FTRteStaUse'   => $paData['FTRteStaUse'],
                    'FTRteStaLocal'   => $paData['FTRteStaLocal'],
                     //เวลาอัปเดทล่าสุด
                    'FDLastUpdOn'    => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'    => $paData['FTLastUpdBy'],
                     //เวลาบันทึกครั้งแรก
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy']
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
    public function FSaMRTEAddUpdateLang($paData){

        try{
            //Update Lang
            $this->db->set('FTRteName', $paData['FTRteName']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTRteCode', $paData['FTRteCode']);
            $this->db->update('TFNMRate_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TFNMRate_L',array(
                    'FTRteCode' => $paData['FTRteCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTRteName' => $paData['FTRteName'],
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


    //Functionality : Add Update Rate Unit  
    //Parameters : function parameters
    //Creator :  06/08/2020 Nale
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTEAddUpdateRateUnitFact($paData){
        try{
           $tRteCode = $paData['FTRteCode'];
           $aRtuFac = $paData['aRtuFac'];
        
           if(!empty($aRtuFac)){
            $nRateUnit = $this->db->where('FTRteCode',$tRteCode)->order_by('FNRtuSeq','ASC')->get('TFNMRateUnit')->num_rows();
            if($nRateUnit>0){
            $this->db->where('FTRteCode', $tRteCode);
            $this->db->delete('TFNMRateUnit');
            }
                foreach($aRtuFac as $nKey => $cRtuFac){
                    $this->db->insert('TFNMRateUnit',array(
                        'FTRteCode'     => $tRteCode,
                        'FNRtuSeq'      => ($nKey+1),
                        'FCRtuFac'      => $cRtuFac

                    ));
                }
              }

           if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Rate Unit Success',
            );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Rate Unit.',
                );
            }

           return $aStatus;

            }catch(Exception $Error){
                return $Error;
            }
    }

    //Functionality : Get Rate Unit  
    //Parameters : function parameters
    //Creator :  06/08/2020 Nale
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTERateUnit($paData){
       $tRteCode = $paData['FTRteCode'];
       $aRateUnit = $this->db->where('FTRteCode',$tRteCode)->order_by('FNRtuSeq','ASC')->get('TFNMRateUnit')->result_array();

       if (FCNnHSizeOf($aRateUnit)> 0) {
        return $aRateUnit;
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : All Page Of Rate
    //Parameters : function parameters
    //Creator :  11/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMRTEGetPageAll($ptSearchList,$ptLngID){
        $tSQL = "SELECT COUNT (RTE.FTRteCode) AS counts 
                 FROM TFNMRate RTE
                 LEFT JOIN [TFNMRate_L] RTEL ON RTE.FTRteCode = RTEL.FTRteCode AND RTEL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        if($ptSearchList != ''){
            $tSQL .= " AND (   RTE.FTRteCode     COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= "      OR RTEL.FTRteName    COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }
    

    //Functionality : Check Feild FTRteStaLocal
    //Parameters : function parameters
    //Creator : 24/08/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    public function FSnMRTECheckStaLocal($paData){
        $tRteCode     = $paData['FTRteCode'];
        $tRteStalocal = $paData['FTRteStaLocal'];

        $tSQL  = "SELECT FTRteStaLocal AS counts
                  FROM TFNMRate 
                  WHERE FTRteStaLocal = '$tRteStalocal' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->result();
            }else{
                return false;
            }
    }



    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMRTECheckDuplicate($ptRteCode){
        $tSQL = "SELECT COUNT(FTRteCode)AS counts
                 FROM TFNMRate
                 WHERE FTRteCode = '$ptRteCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
    


 

    //Functionality : Delete Rate
    //Parameters : function parameters
    //Creator : 14/05/2018 wasin
    //Return : response
    //Return Type : array
    public function FSnMRTEDel($paData){
        $this->db->where_in('FTRteCode', $paData['FTRteCode']);
        $this->db->delete('TFNMRate');
         
        
        $this->db->where_in('FTRteCode', $paData['FTRteCode']);
        $this->db->delete('TFNMRate_L');


        $this->db->where_in('FTRteCode', $paData['FTRteCode']);
        $this->db->delete('TFNMRateUnit');
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
    //Creator : 12/08/2019 Saharat(Golf)
    //Return : array 
    //Return Type : array
    public function FSnMRTEGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMRate";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }    
     
}
