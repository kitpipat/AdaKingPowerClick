<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCardType extends CI_Model {
    
    /**
     * Functionality : List CardType
     * Parameters : Ajax Call View DataTable
     * Creator : 05/10/2018 Witsarut (Bell)
     * Last Modified : 11/1/2019 Piya 
     * Return : CardType Data
     * Return Type : array
     */
    public function FSaMCTYList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");

            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtCtyCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        CTY.FTCtyCode   AS rtCtyCode,
                                        CTY_L.FTCtyName AS rtCtyName,
                                        CTY.FCCtyDeposit AS rtCtyDeposit,
                                        CTY.FCCtyTopupAuto AS rtCtyTopupAuto,
                                        CTY.FNCtyExpiredType AS rtCtyExpiredType,
                                        CTY.FNCtyExpirePeriod AS rtCtyExpirePeriod,
                                        CTY.FTCtyStaAlwRet AS rtCtyStaAlwRet,
                                        CTY.FTCtyStaPay AS rtCtyStaPay,
                                        CTY.FCCtyCreditLimit AS rtCtyCreditLimit,
                                        CTY.FTCtyStaShift AS rtCtyStaShif,
                                        CTY.FDCreateOn
                                    FROM [TFNMCardType] CTY
                                    LEFT JOIN [TFNMCardType_L] CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $nLngID   
                                    WHERE 1=1 ";
            if($tAgnCode != ''){
                $tSQL .= "AND CTY.FTAgnCode = $tAgnCode";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (CTY.FTCtyCode LIKE '%$tSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName  LIKE '%$tSearchList%')";

            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMCTYGetPageAll($tSearchList,$nLngID,$tAgnCode);
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

    //Functionality : All Page Of CardType
    //Parameters : function parameters
    //Creator :  05/10/2018 Witsarut (Bell)
    //Return : object Count All CardType
    //Return Type : Object
    public function FSoMCTYGetPageAll($ptSearchList,$ptLngID,$tAgnCode){
        try{
            $tSQL = "SELECT COUNT (CTY.FTCtyCode) AS counts
                     FROM [TFNMCardType] CTY
                     LEFT JOIN [TFNMCardType_L]  CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $ptLngID
                     WHERE 1=1 ";

            if($tAgnCode != ''){
                $tSQL .= "AND CTY.FTAgnCode = $tAgnCode";
            }
            
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (CTY.FTCtyCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data CardType By ID
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCTYGetDataByID($paData){
        try{
            $tCtyCode   = $paData['FTCtyCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                CTY.FTCtyCode   AS rtCtyCode,
                                CTY_L.FTCtyName AS rtCtyName,
                                CTY.FCCtyDeposit AS rtCtyDeposit, 
                                CTY.FCCtyTopupAuto AS rtCtyTopupAuto,
                                CTY.FNCtyExpiredType AS rtCtyExpiredType,
                                CTY.FNCtyExpirePeriod AS rtCtyExpirePeriod,
                                CTY.FTCtyStaAlwRet  AS rtCtyStaAlwRet,
                                CTY.FTCtyStaPay AS rtCtyStaPay,
                                CTY.FCCtyCreditLimit AS rtCtyCreditLimit,
                                CTY_L.FTCtyRmk  AS rtCtyRmk,
                                CTY.FTCtyStaShift AS rtCtyStaShif,
                                CTY.FTAgnCode        AS rtAgnCode,
                                AGN_L.FTAgnName      AS rtAgnName
                            FROM TFNMCardType CTY
                            LEFT JOIN TCNMAgency_L AGN_L ON CTY.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                            LEFT JOIN TFNMCardType_L CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $nLngID 
                            WHERE 1=1 AND CTY.FTCtyCode = '$tCtyCode' ";
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

    //Functionality : Checkduplicate CardType
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSnMCTYCheckDuplicate($ptCtyCode){
        try{
            $tSQL = "SELECT COUNT(CTY.FTCtyCode) AS counts
                    FROM TFNMCardType CTY
                    WHERE CTY.FTCtyCode = '$ptCtyCode' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->row_array();
            }else{
                return FALSE;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update CardType (TFNMCardType)
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCTYAddUpdateMaster($paDataCardType){
        try{
            // Update TFNMCardType
            $this->db->where('FTCtyCode', $paDataCardType['FTCtyCode']);
            $this->db->update('TFNMCardType',array(
                'FCCtyDeposit'      => $paDataCardType['FCCtyDeposit'],
                'FCCtyTopupAuto'    => $paDataCardType['FCCtyTopupAuto'],
                'FNCtyExpiredType'  => $paDataCardType['FNCtyExpiredType'],
                'FNCtyExpirePeriod' => $paDataCardType['FNCtyExpirePeriod'],
                'FTCtyStaAlwRet'    => $paDataCardType['FTCtyStaAlwRet'],
                'FTCtyStaPay'       => $paDataCardType['FTCtyStaPay'],
                'FCCtyCreditLimit'  => $paDataCardType['FCCtyCreditLimit'],
                'FDLastUpdOn'       => $paDataCardType['FDLastUpdOn'], 
                'FTLastUpdBy'       => $paDataCardType['FTLastUpdBy'],
                'FTCtyStaShift'     => $paDataCardType['FTCtyStaShift'],
                'FTAgnCode'         => $paDataCardType['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CardType Success',
                );
            }else{
                //Add TFNMCardType
                $this->db->insert('TFNMCardType', array(
                    'FCCtyDeposit'      => $paDataCardType['FCCtyDeposit'], 
                    'FCCtyTopupAuto'    => $paDataCardType['FCCtyTopupAuto'],
                    'FNCtyExpiredType'  => $paDataCardType['FNCtyExpiredType'],
                    'FNCtyExpirePeriod' => $paDataCardType['FNCtyExpirePeriod'],
                    'FTCtyStaAlwRet'    => $paDataCardType['FTCtyStaAlwRet'],
                    'FTCtyStaPay'       => $paDataCardType['FTCtyStaPay'],
                    'FCCtyCreditLimit'  => $paDataCardType['FCCtyCreditLimit'],
                    'FTCtyCode'         => $paDataCardType['FTCtyCode'],
                    'FDCreateOn'        => $paDataCardType['FDCreateOn'],
                    'FTCreateBy'        => $paDataCardType['FTCreateBy'],
                    'FDLastUpdOn'       => $paDataCardType['FDLastUpdOn'], 
                    'FTLastUpdBy'       => $paDataCardType['FTLastUpdBy'],
                    'FTCtyStaShift'     => $paDataCardType['FTCtyStaShift'],
                    'FTAgnCode'         => $paDataCardType['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add CardType Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit CardType.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update CardType (TFNMCardType_L)
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCTYAddUpdateLang($paDataCardType){
        try{
            //Update Pdt Brand Lang
            $this->db->where('FNLngID', $paDataCardType['FNLngID']);
            $this->db->where('FTCtyCode', $paDataCardType['FTCtyCode']);
            $this->db->update('TFNMCardType_L',array(
                'FTCtyName' => $paDataCardType['FTCtyName'],
                'FTCtyRmk'  => $paDataCardType['FTCtyRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update CardType Lang Success.',
                );
            }else{
                //Add Pdt Brand Lang
                $this->db->insert('TFNMCardType_L', array(
                    'FTCtyCode' => $paDataCardType['FTCtyCode'],
                    'FNLngID'   => $paDataCardType['FNLngID'],
                    'FTCtyName' => $paDataCardType['FTCtyName'],
                    'FTCtyRmk'  => $paDataCardType['FTCtyRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add CardType Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit CardType Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete CardType
    //Parameters : function parameters
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMCTYDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTCtyCode', $paData['FTCtyCode']);
            $this->db->delete('TFNMCardType');

            $this->db->where_in('FTCtyCode', $paData['FTCtyCode']);
            $this->db->delete('TFNMCardType_L');

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
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMCardType";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }




}
