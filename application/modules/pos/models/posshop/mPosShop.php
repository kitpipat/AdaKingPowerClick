<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPosShop extends CI_Model {

    //Functionality : List POS SHOP Type4
    //Parameters : function parameters
    //Creator :  11/07/2019 saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMPSHListType4($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tBchCode       = $paData['tBchCode'];
            $tShpCode       = $paData['tShpCode'];
            $tSearchAll     = $paData['tSearchAll'];
            $tShpType       = $paData['tShpType'];
            $tFNLngID       = $paData['FNLngID'];
            $tSQL = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTPosCode ASC) AS rtRowID,* FROM
                                (SELECT DISTINCT
                                        PSH.FTShpCode           AS FTShpCode,
                                        PSH.FTPosCode    		AS FTPosCode,
                                        PSH.FTBchCode    		AS FTBchCode,
                                        PSH.FTPshPosSN			AS FTPshPosSN,
                                        PSH.FTPshStaUse			AS FTPshStaUse,
                                        PSH.FTShpSceLayout	    AS FTShpSceLayout,
                                        PNA.FTPosComName        AS Namepos,
                                        SHPL.FTShpName          AS FTShpName,
                                        BCHL.FTBchName          AS FTBchName,
                                        POSL.FTPosName          AS FTPosName
                                        
                                FROM TVDMPosShop PSH
                               
                                LEFT JOIN TCNMPosLastNo PNA ON PSH.FTPosCode = PNA.FTPosCode  
                                
                                LEFT JOIN TCNMShop_L SHPL   ON PSH.FTShpCode = SHPL.FTShpCode AND PSH.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = '$tFNLngID'
                                LEFT JOIN TCNMBranch_L BCHL    ON PSH.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID   = '$tFNLngID'
                                LEFT JOIN TCNMPos_L  POSL  ON  POSL.FTPosCode  =  PSH.FTPosCode    AND POSL.FTBchCode = SHPL.FTBchCode  AND POSL.FNLngID  = '$tFNLngID'
                                WHERE 1=1 AND PSH.FTShpCode = '$tShpCode' AND PSH.FTBchCode='$tBchCode' ";


            if ($tSearchAll != ''){
                $tSQL .= " AND (PSH.FTPosCode COLLATE THAI_BIN LIKE '%$tSearchAll%'";
                $tSQL .= " OR PSH.FTPshPosSN  COLLATE THAI_BIN LIKE '%$tSearchAll%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            // echo $tSQL;

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPSHGetPageAllType4($tBchCode,$tShpCode);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
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
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : List POS SHOP Type5
    //Parameters : function parameters
    //Creator :  11/07/2019 saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMPSHListType5($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tBchCode       = $paData['tBchCode'];
            $tShpCode       = $paData['tShpCode'];
            $tSearchAll     = $paData['tSearchAll'];
            $tShpType       = $paData['tShpType'];
            $tFNLngID       = $paData['FNLngID'];
            $tSQL = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTPosCode ASC) AS rtRowID,* FROM
                                (SELECT DISTINCT
                                MPS.FTShpCode           AS FTShpCode,
                                        MPS.FTPosCode    		AS FTPosCode,
                                        MPS.FTBchCode    		AS FTBchCode,
                                        MPS.FTPshPosSN			AS FTPshPosSN,
                                        MPS.FTPshStaUse			AS FTPshStaUse,
                                        MPS.FTPshNetIP          AS FTPshNetIP,
                                        MPS.FTPshNetPort        AS FTPshNetPort,
                                        0      AS FTShpSceLayout,
                                        SHPL.FTShpName          AS FTShpName,
                                        BCHL.FTBchName          AS FTBchName,
                                        PosL.FTPosName          AS FTPosName
                                FROM TRTMShopPos MPS
                                LEFT JOIN TCNMShop_L SHPL   ON MPS.FTShpCode = SHPL.FTShpCode AND MPS.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = '$tFNLngID'
                                LEFT JOIN TCNMPos_L PosL ON MPS.FTPosCode =  PosL.FTPosCode AND MPS.FTBchCode = PosL.FTBchCode AND PosL.FNLngID = '$tFNLngID'
                                LEFT JOIN TCNMBranch_L BCHL    ON MPS.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID  = '$tFNLngID'
                                WHERE 1=1 AND MPS.FTShpCode = '$tShpCode' AND MPS.FTBchCode = '$tBchCode'  ";

            if ($tSearchAll != ''){
                $tSQL .= " AND (MPS.FTPosCode COLLATE THAI_BIN LIKE '%$tSearchAll%'";
                $tSQL .= " OR MPS.FTPshPosSN  COLLATE THAI_BIN LIKE '%$tSearchAll%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPSHGetPageAllType5($tBchCode,$tShpCode);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
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
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of POS SHOP Type4
    //Parameters : function parameters
    //Creator :  11/07/2019 saharat(Golf)
    //Return : object Count All
    //Return Type : Object
    public function FSoMPSHGetPageAllType4($ptBchCode,$ptShpCode){
        try{
            $tSQL = "SELECT COUNT (DISTINCT PSH.FTPosCode) AS counts
                     FROM TVDMPosShop PSH
                     WHERE  PSH.FTShpCode = '$ptShpCode' AND PSH.FTBchCode = '$ptBchCode' ";
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

    //Functionality : All Page Of POS SHOP Type5
    //Parameters : function parameters
    //Creator :  11/07/2019 saharat(Golf)
    //Return : object Count All
    //Return Type : Object
    public function FSoMPSHGetPageAllType5($ptBchCode,$ptShpCode){
        try{
            $tSQL = "SELECT COUNT (DISTINCT MSP.FTPosCode) AS counts
                     FROM TRTMShopPos MSP
                     WHERE  MSP.FTShpCode = '$ptShpCode'";
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

    //Functionality : Update POS SHOP (TVDMPosShop)
    //Parameters : function parameters
    //Creator : 11/07/2019 Sahaart(Golf)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPSHAddUpdateMasterType4($paData){
        try{
            // Update TVDMPosShop
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->where('FTPosCode', $paData['FTPosCodeOld']);
            $this->db->update('TVDMPosShop' ,array(
                'FTPosCode'         => $paData['FTPosCode'],
                'FTShpSceLayout'    => $paData['FTShpSceLayout'],
                'FTPshPosSN'        => $paData['FTPshPosSN'],
                'FTPshStaUse'       => $paData['FTPshStaUse'],
                'FDLastUpdOn'       => $paData['FDLastUpdOn'], 
                'FTLastUpdBy'       => $paData['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update POS SHOP Success',
                );
            }else{
                //Add TVDMPosShop
                $this->db->insert('TVDMPosShop', array(
                    'FTBchCode'         => $paData['FTBchCode'],
                    'FTShpCode'         => $paData['FTShpCode'],
                    'FTPosCode'         => $paData['FTPosCode'],
                    'FTPshPosSN'        => $paData['FTPshPosSN'],
                    'FTPshStaUse'       => $paData['FTPshStaUse'],
                    'FTShpSceLayout'    => $paData['FTShpSceLayout'],
                    'FDLastUpdOn'       => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'       => $paData['FTLastUpdBy'],
                    'FDCreateOn'        => $paData['FDCreateOn'],
                    'FTCreateBy'        => $paData['FTCreateBy']

                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add POS SHOP Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit POS SHOP',
                    );
                }
            }
        return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update POS SHOP (TRTMShopPos)
    //Parameters : function parameters
    //Creator : 11/07/2019 Sahaart(Golf)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPSHAddUpdateMasterType5($paData){
        try{
            // Update TRTMShopPos
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
           $this->db->where('FTPosCode', $paData['FTPosCodeOld']);
            $this->db->update('TRTMShopPos' ,array(
                'FTPosCode'         => $paData['FTPosCode'],
                'FTPshNetIP'        => $paData['FTPshNetIP'],
                'FTPshNetPort'      => $paData['FTPshNetPort'],
                'FTPshPosSN'        => $paData['FTPshPosSN'],
                'FTPshStaUse'       => $paData['FTPshStaUse'],
                'FDLastUpdOn'       => $paData['FDLastUpdOn'], 
                'FTLastUpdBy'       => $paData['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update POS SHOP Success',
                );
            }else{
                //Add TRTMShopPos
                $this->db->insert('TRTMShopPos', array(
                    'FTBchCode'         => $paData['FTBchCode'],
                    'FTShpCode'         => $paData['FTShpCode'],
                    'FTPshNetPort'      => $paData['FTPshNetPort'],
                    'FTPshNetIP'        => $paData['FTPshNetIP'],
                    'FTPshPosSN'        => $paData['FTPshPosSN'],
                    'FTPosCode'         => $paData['FTPosCode'],
                    'FTPshPosSN'        => $paData['FTPshPosSN'],
                    'FTPshStaUse'       => $paData['FTPshStaUse'],
                    'FDCreateOn'        => $paData['FDCreateOn'],
                    'FTCreateBy'        => $paData['FTCreateBy'],
                    'FDLastUpdOn'       => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'       => $paData['FTLastUpdBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add POS SHOP Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit POS SHOP',
                    );
                }
            }
        return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Delete POS SHOP  Type4
    //Parameters : function parameters
    //Creator : 10/07/2019 Saharat(Golf)
    //Return : Status Delete
    //Return Type : array
    public function FSaMPSHDelAllType4($paData){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTBchCode', $paData['FTBchCode']);
            $this->db->where_in('FTShpCode', $paData['FTShpCode']);
            $this->db->where_in('FTPosCode', $paData['FTPosCode']);
            $this->db->delete('TVDMPosShop');

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

    //Functionality : Delete POS SHOP type5
    //Parameters : function parameters
    //Creator : 10/07/2019 Saharat(Golf)
    //Return : Status Delete
    //Return Type : array
    public function FSaMPSHDelAllType5($paData){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTBchCode', $paData['FTBchCode']);
            $this->db->where_in('FTShpCode', $paData['FTShpCode']);
            $this->db->where_in('FTPosCode', $paData['FTPosCode']);
            $this->db->delete('TRTMShopPos');

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

    //Functionality : Get Data POS SHOP By ID
    //Parameters : function parameters
    //Creator : 13/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMPSHGetDataByID($paData){
        try{
            $FTBchCode   = $paData['FTBchCode'];
            $FTShpCode   = $paData['FTShpCode'];
            $FTPosCode   = $paData['FTPosCode'];
            $nLngID      = $paData['FNLngID'];
            $tShpType    = $paData['tShpType'];
            switch ($tShpType) {
                case "4":
                        $tTable = "TVDMPosShop";
                    break;
                case "5":
                        $tTable = "TRTMShopPos";
                    break;
                default:
                        $tTable = "TVDMPosShop";
                break;    
                }
            $tSQL        = "SELECT
                                PSH.FTShpCode       AS FTShpCode,
                                PSH.FTBchCode       AS FTBchCode,
                                PSH.FTPosCode    	AS FTPosCode,
                                PSH.FTPshPosSN		AS FTPshPosSN,
                                PSH.FTPshStaUse		AS FTPshStaUse,
                                SHP_L.FTShpName     AS FTShpName
                            FROM $tShpType PSH
                            LEFT JOIN TCNMShop_L SHP_L ON SHP_L.FTBchCode = PSH.FTBchCode AND SHP_L.FTShpCode = PSH.FTShpCode AND FNLngID = $nLngID
                            WHERE PSH.FTBchCode='$FTBchCode' AND PSH.FTShpCode='$FTShpCode' AND PSH.FTPosCode='$FTPosCode'";
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

    //Check duplicate
    public function FSaMPSHCheckDatabeforeUpdate($paData){
        $tSHPCode = $paData['FTShpCode'];
        $tPOSCode = $paData['FTPosCode'];
        $tSQL = "SELECT FTShpCode FROM TVDMPosShop WHERE FTShpCode = '$tSHPCode' AND FTPosCode = '$tPOSCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Update inline
    public function FSaMPSHUpdateDataInline($paData){
        try{
            // Update TVDMPosShop
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->where('FTPosCode', $paData['OldPosCode']);
            $this->db->update('TVDMPosShop',array(
                'FTPosCode'         => $paData['FTPosCode'],
                'FTPshPosSN'        => $paData['FTPshPosSN'],
                'FTPshStaUse'       => $paData['FTPshStaUse'],
                'FDLastUpdOn'       => $paData['FDLastUpdOn'], 
                'FTLastUpdBy'       => $paData['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update POS SHOP Success',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Get Data
    public function FSaMPSHDataList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tRakCode       = $paData['FTRakCode'];
            $tLayNo         = $paData['FNLayNo'];
            $tLayRow        = $paData['FNLayRow'];
            $tLayCol        = $paData['FNLayCol'];
            $ShpCode        = $paData['FTShpCode'];
            $tMerCode       = $paData['FTMerCode'];
            $tPosCode       = $paData['FTPosCode'];
            if($paData['FTBchCodeOver'] != ''){
                $tBchCode =  trim($paData['FTBchCodeOver']);
            }else{
                $aBchCode = explode(",",$paData['FTBchCode']);
                $tBchCode = $aBchCode[0]; 
            }
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FTShpCode ASC) AS rtRowID,* FROM
                                    (SELECT 
                                        SML.FTBchCode,
                                        SML.FTShpCode,
                                        SML.FNLayNo,
                                        SML.FNLayScaleX,
                                        SML.FNLayScaleY,
                                        SML.FNLayRow,
                                        SML.FNLayCol,
                                        SML.FTPzeCode,
                                        SML.FTRakCode,
                                        SML.FTLayStaUse,
                                        SML_L.FTLayName,
                                        SML_L.FTLayRemark,
                                        SML.FTMerCode,
                                        BCH_L.FTBchName,
                                        RACK_L.FTRakName,
                                        SHP_L.FTSizName,
                                        SPL.FNLayBoardNo,
                                        SPL.FTPosCode,
                                        SPL.FTLayBoxNo

                            FROM [TRTMShopLayout] SML
                            LEFT JOIN [TRTMShopLayout_L] SML_L ON SML.FTShpCode = SML_L.FTShpCode 
                            AND SML.FNLayNo   = SML_L.FNLayNo 
                            AND SML.FTBchCode = SML_L.FTBchCode
                            AND SML_L.FNLngID = '$tFNLngID'
                            LEFT JOIN [TCNMBranch_L] BCH_L     ON SML.FTBchCode = BCH_L.FTBchCode  AND BCH_L.FNLngID  = '$tFNLngID'
                            LEFT JOIN [TRTMShopRack_L] RACK_L  ON SML.FTRakCode = RACK_L.FTRakCode AND RACK_L.FNLngID = '$tFNLngID'
                            LEFT JOIN [TRTMShopSize_L] SHP_L   ON SML.FTPzeCode = SHP_L.FTSizCode  AND SHP_L.FNLngID  = '$tFNLngID'
                            LEFT JOIN [TRTMShopPosLayout] SPL  ON SML.FTBchCode = SPL.FTBchCode    AND SML.FTShpCode  =  SPL.FTShpCode
                            AND SPL.FTPosCode  = '$tPosCode'
                            AND SML.FNLayNo    =  SPL.FNLayNo
                            WHERE 1=1  
                            AND SML.FTBchCode  = $tBchCode 
                            -- AND SML.FTMerCode  = $tMerCode 
                            AND SML.FTShpCode  = $ShpCode 
                            "; 


            if($tRakCode != ''){
                $tSQL .= " AND (SML.FTRakCode = '$tRakCode')";
            }

            if($tLayNo != ''){
                $tSQL .= " AND (SML.FNLayNo = '$tLayNo')";
            }

            if($tLayRow != ''){
                $tSQL .= " AND (SML.FNLayRow = '$tLayRow')";
            }

            if($tLayCol != ''){
                $tSQL .= " AND (SML.FNLayCol = '$tLayCol')";
            }
        
            $tFTShpCode = $paData['FTShpCode'];
            $tFTBchCode = $paData['FTBchCode'];
            $tSQL .= " AND (SML.FTBchCode IN ($tFTBchCode) AND SML.FTShpCode = '$tFTShpCode')";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMPSHLayoutGetPageAll($paData);
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
    public function FSoMPSHLayoutGetPageAll($paData){
        $tRakCode       = $paData['FTRakCode'];
        $tLayNo         = $paData['FNLayNo'];
        $tLayRow        = $paData['FNLayRow'];
        $tLayCol        = $paData['FNLayCol'];
        try{
            $tFNLngID = $paData['FNLngID'];
            if($paData['FTBchCodeOver'] != ''){
                $tBchCode =  trim($paData['FTBchCodeOver']);
            }else{
                $aBchCode = explode(",",$paData['FTBchCode']);
                $tBchCode = $aBchCode[0]; 
            }
            $tSQL = "SELECT COUNT (SML.FNLayNo) AS counts
                    FROM [TRTMShopLayout] SML
                    LEFT JOIN [TRTMShopLayout_L] SML_L ON SML.FTShpCode = SML_L.FTShpCode  AND SML.FNLayNo     = SML_L.FNLayNo AND SML.FTBchCode = SML_L.FTBchCode AND SML_L.FNLngID = '$tFNLngID'
                    LEFT JOIN [TCNMBranch_L] BCH_L     ON SML.FTBchCode = BCH_L.FTBchCode  AND BCH_L.FNLngID   = '$tFNLngID'
                    LEFT JOIN [TRTMShopRack_L] RACK_L  ON SML.FTRakCode = RACK_L.FTRakCode AND RACK_L.FNLngID  = '$tFNLngID'
                    LEFT JOIN [TRTMShopSize_L] SHP_L   ON SML.FTPzeCode = SHP_L.FTSizCode  AND SHP_L.FNLngID   = '$tFNLngID'
                    WHERE 1=1 AND SML.FTBchCode = '$tBchCode' ";


            if($tRakCode != ''){
                $tSQL .= " AND (SML.FTRakCode = '$tRakCode')";
            }

            if($tLayNo != ''){
                $tSQL .= " AND (SML.FNLayNo = '$tLayNo')";
            }

            if($tLayRow != ''){
                $tSQL .= " AND (SML.FNLayRow = '$tLayRow')";
            }

            if($tLayCol != ''){
                $tSQL .= " AND (SML.FNLayCol = '$tLayCol')";
            }
            $tFTShpCode = $paData['FTShpCode'];
            $tFTBchCode = $paData['FTBchCode'];
            $tSQL .= " AND (SML.FTBchCode IN ($tFTBchCode) AND SML.FTShpCode = '$tFTShpCode')";

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

    //Get Data Setting
    public function FSaMPSHGetDataSetting($paData){
        try{
            $tBchCode   = $paData['FTBchCode'];
            $tShpCode   = $paData['FTShpCode'];
            $tPosCode   = $paData['FTPosCode'];
            $tLayNo     = $paData['FNLayNo'];


            $tSQL        = "SELECT
                               MSPL.FTLayBoxNo,
                               MSPL.FNLayBoardNo

                            FROM TRTMShopLayout MSL
                            LEFT JOIN TRTMShopPosLayout MSPL    ON MSL.FTBchCode = MSPL.FTBchCode 
                            AND MSPL.FTPosCode = '$tPosCode'
                            AND MSL.FTShpCode = MSPL.FTShpCode 
                            AND MSL.FNLayNo = MSPL.FNLayNo
                            where 1=1 
                            AND MSPL.FTBchCode = $tBchCode 
                            AND MSL.FTShpCode = $tShpCode 
                            AND MSL.FNLayNo = $tLayNo ";
        
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

    //update insert 
    public function FSaMPSHUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTBchCode' , $paData['FTBchCode']);
            $this->db->set('FTShpCode' , $paData['FTShpCode']);
            $this->db->set('FTPosCode' , $paData['FTPosCode']);
            $this->db->set('FNLayNo' , $paData['FNLayNo']);
            $this->db->set('FNLayBoardNo' , $paData['FNLayBoardNo']);
            $this->db->set('FTLayBoxNo' , $paData['FTLayBoxNo']);

            $this->db->where('FTPosCode', $paData['FTPosCode']);
            $this->db->where('FNLayNo', $paData['FNLayNo']);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->update('TRTMShopPosLayout');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TRTMShopPosLayout',array(
                    'FTBchCode'         => $paData['FTBchCode'],
                    'FTShpCode'         => $paData['FTShpCode'],
                    'FTPosCode'         => $paData['FTPosCode'],
                    'FNLayNo'           => $paData['FNLayNo'],
                    'FNLayBoardNo'      => $paData['FNLayBoardNo'],
                    'FTLayBoxNo'         => $paData['FTLayBoxNo'],
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

    //check Rack
    public function FSaMPSHGetDataRack(){
        try{
            $tSQL = "SELECT DISTINCT 
                        FTRakName,
                        FTRakCode
                     FROM TRTMShopRack_L";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result_array();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        } 
    }

    //check Layout
    public function FSaMPSHGetDataLayout(){
        try{
            $tSQL = "SELECT DISTINCT 
                        FNLayNo
                     FROM TRTMShopLayout";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result_array();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        } 
        
    }

    //Get Data PosSho
    public function FSaMPSHGetDataPosShopType4($paData){

        $tPosCode   = $paData['FTPosCode'];
        $tShpCode   = $paData['FTShpCode'];
        $tBchCode   = $paData['FTBchCode'];
        $tFNLngID   = $this->session->userdata("tLangEdit");
        
        $tSQL = "SELECT 
                    MPS.FTBchCode,
                    MPS.FTShpCode,
                    MPS.FTPosCode,
                    MPS.FTPshPosSN,
                    MPS.FTPshStaUse,
                    TMP.FTPosRegNo,
                    POSL.FTPosName,
                    MPS.FTShpSceLayout
                FROM [TVDMPosShop]  MPS
                LEFT JOIN [TCNMPos] TMP ON MPS.FTPosCode = TMP.FTPosCode AND TMP.FTBchCode = MPS.FTBchCode
                LEFT JOIN [TCNMPos_L] POSL ON POSL.FTPosCode = MPS.FTPosCode AND POSL.FTBchCode = MPS.FTBchCode AND POSL.FNLngID = '$tFNLngID'
                WHERE 1=1 
                AND MPS.FTPosCode = '$tPosCode' 
                AND MPS.FTShpCode = '$tShpCode'
                AND MPS.FTBchCode = '$tBchCode' 
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

     //Get Data PosSho
     public function FSaMPSHGetDataPosShopType5($paData){
        $tPosCode   = $paData['FTPosCode'];
        $tShpCode   = $paData['FTShpCode'];
        $tBchCode   = $paData['FTBchCode'];
        $tFNLngID   = $paData['FNLngID'];
        $tSQL = "SELECT 
                    MPS.FTBchCode,
                    MPS.FTShpCode,
                    MPS.FTPosCode,
                    MPS.FTPshPosSN,
                    MPS.FTPshStaUse,
                    MPS.FTPshNetIP,
                    MPS.FTPshNetPort,
                    TMP.FTPosRegNo,
                    POSL.FTPosName
                FROM [TRTMShopPos] MPS
                LEFT JOIN [TCNMPos] TMP ON MPS.FTPosCode = TMP.FTPosCode AND MPS.FTBchCode = TMP.FTBchCode
                LEFT JOIN [TCNMPos_L] POSL ON POSL.FTPosCode = MPS.FTPosCode AND MPS.FTBchCode = POSL.FTBchCode AND POSL.FNLngID = $tFNLngID
                WHERE 1=1 
                AND MPS.FTPosCode = '$tPosCode' 
                AND MPS.FTShpCode = '$tShpCode'
                AND MPS.FTBchCode = '$tBchCode' 
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

    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 17/07/2016 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMEdcCheckDuplicate($ptEdcCode){
        $tSQL = "SELECT COUNT(FTEdcCode)AS counts
                 FROM TFNMEdc
                 WHERE FTEdcCode = '$ptEdcCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //เพิ่ม EDC
    public function FSaMEdcAddUpdateMaster($paData){
        try{
            $this->db->insert('TFNMEdc', array(
                'FTEdcCode'         => $paData['FTEdcCode'],
                'FTSedCode'         => $paData['FTSedCode'],
                'FTBnkCode'         => $paData['FTBnkCode'],
                'FTEdcShwFont'      => $paData['FTEdcShwFont'],
                'FTEdcShwBkg'       => $paData['FTEdcShwBkg'],
                'FTEdcOther'        => $paData['FTEdcOther'],
                'FDLastUpdOn'       => $paData['FDLastUpdOn'],
                'FDCreateOn'        => $paData['FDCreateOn'],
                'FTCreateBy'        => $paData['FTCreateBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add EDC Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add EDC',
                );
            }
        return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //เพิ่ม EDC_L
    public function FSaMEdcAddUpdateLang($paData){
        try{
            $this->db->insert('TFNMEdc_L', array(
                'FTEdcCode'      => $paData['FTEdcCode'],
                'FNLngID'        => $paData['FNLngID'],
                'FTEdcName'      => $paData['FTEdcName'],
                'FTEdcRmk'       => $paData['FTEdcRmk'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add EDC Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add EDC',
                );
            }
        return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

}

