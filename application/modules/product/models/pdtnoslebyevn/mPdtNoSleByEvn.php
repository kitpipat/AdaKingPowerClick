<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtNoSleByEvn extends CI_Model {

    //Functionality : list Product NoSale By Event
    //Parameters : function parameters
    //Creator :  21/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMEVNList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = "SELECT  c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY rtEvnCode ASC,rtEvnSeqNo ASC) AS rtRowID,* FROM
                                        (SELECT DISTINCT
                                            EVN.FTEvnCode       AS rtEvnCode,
                                            EVN.FNEvnSeqNo      AS rtEvnSeqNo,
                                            (SELECT MAX(EVN_MaxSeq.FNEvnSeqNo) FROM [TCNMPdtNoSleByEvn] EVN_MaxSeq 
                                            WHERE EVN_MaxSeq.FTEvnCode = EVN.FTEvnCode) AS rtEvnMaxSeqNo,
                                            EVN.FTEvnType       AS rtEvnType,
                                            EVN.FTEvnStaAllDay  AS rtEvnStaAllDay,
                                            EVN.FDEvnDStart  	AS rtEvnDStart,
                                            /*EVN.FDEvnDStart,103)	AS rtEvnDStart,*/
                                            EVN.FTEvnTStart     AS rtEvnTStart,
                                            EVN.FDEvnDFinish    AS rtEvnDFinish,
                                            /*CONVERT(NVARCHAR,EVN.FDEvnDFinish,103)AS rtEvnDFinish,*/
                                            EVN.FTEvnTFinish    AS rtEvnTFinish,
                                            EVN_L.FTEvnName     AS rtEvnName
                                        FROM [TCNMPdtNoSleByEvn] EVN
                                        LEFT JOIN [TCNMPdtNoSleByEvn_L] EVN_L ON EVN.FTEvnCode = EVN_L.FTEvnCode AND EVN_L.FNLngID = $nLngID
                                        WHERE 1=1 ";

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (EVN.FTEvnCode LIKE '%$tSearchList%'";
                $tSQL .= " OR EVN_L.FTEvnName  LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMEVNGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of Product NoSale By Event
    //Parameters : function parameters
    //Creator :  21/09/2018 Wasin
    //Return : object Count All Product NoSale By Event
    //Return Type : Object
    public function FSoMEVNGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL   =   "SELECT COUNT (EVN.FTEvnCode) AS counts
                         FROM [TCNMPdtNoSleByEvn] EVN
                         LEFT JOIN [TCNMPdtNoSleByEvn_L] EVN_L ON EVN.FTEvnCode = EVN_L.FTEvnCode AND EVN_L.FNLngID = $ptLngID
                         WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (EVN.FTEvnCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR EVN_L.FTEvnName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Product NoSale By Event By ID
    //Parameters : function parameters
    //Creator : 27/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMEVNGetDataByID($paData){
        try{
            $tEvnCode   = $paData['FTEvnCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL1 = "SELECT DISTINCT
                        EVN1.FTEvnCode   AS rtEvnCode1,
                        EVN1_L.FTEvnName AS rtEvnName,
                        EVN1_L.FTEvnRmk  AS rtEvnRmk
                     FROM TCNMPdtNoSleByEvn EVN1
                     LEFT JOIN TCNMPdtNoSleByEvn_L EVN1_L ON EVN1.FTEvnCode = EVN1_L.FTEvnCode AND EVN1_L.FNLngID = $nLngID
                     WHERE 1=1 AND EVN1.FTEvnCode = '$tEvnCode' ";
            $tSQL2 = "SELECT 
                        EVN2.FTEvnCode      AS rtEvnCode2,
                        EVN2.FNEvnSeqNo     AS rtEvnSeqNo,
		                EVN2.FTEvnType      AS rtEvnType,
                        EVN2.FTEvnStaAllDay	AS rtEvnStaAllDay,
                        EVN2.FDEvnDStart    AS rtEvnDStart,
                        EVN2.FDEvnDFinish   AS rtEvnDFinish,
                        EVN2.FTEvnTStart    AS rtEvnTStart,
                        EVN2.FTEvnTFinish   AS rtEvnTFinish
                    FROM TCNMPdtNoSleByEvn EVN2
                    WHERE 1=1 AND EVN2.FTEvnCode = '$tEvnCode'
                    ORDER BY EVN2.FNEvnSeqNo ASC ";
            $oQuery1 = $this->db->query($tSQL1);
            $oQuery2 = $this->db->query($tSQL2);
            if ($oQuery1->num_rows() > 0 && $oQuery2->num_rows() > 0){
                $aDetail1 = $oQuery1->row_array();
                $aDetail2 = $oQuery2->result_array();
                $aDataReturn = array_merge($aDetail1,array('raDataList'=>$aDetail2));
                $aResult = array(
                    'raItems'   => $aDataReturn,
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

    //Functionality : Checkduplicate Product NoSale By Event
    //Parameters : function parameters
    //Creator : 27/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMEVNCheckDuplicate($ptEvnCode){
        try{
            $tSQL = "SELECT COUNT(EVN.FTEvnCode) AS counts
                     FROM TCNMPdtNoSleByEvn EVN
                     WHERE EVN.FTEvnCode = '$ptEvnCode' ";
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

    //Functionality : Add/Update Product NoSale By Event Master
    //Parameters : function parameters
    //Creator : 27/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMEVNAddUpdateMaster($paDataMaster){
        try{
            $tSQL = "SELECT COUNT(FNEvnSeqNo) AS NumRowEVN FROM TCNMPdtNoSleByEvn WHERE FTEvnCode = '".$paDataMaster['oetEvnCode']."'";
            $oQuery = $this->db->query($tSQL);
            $nCountRumrowEvn = $oQuery->row_array()["NumRowEVN"];
            if($paDataMaster["ocmEvnTypeSend"]!=null){
                for($nI=0;$nI<FCNnHSizeOf($paDataMaster["ocmEvnTypeSend"]);$nI++){
                    $nCountRumrowEvn += 1;
                    $this->db->insert('TCNMPdtNoSleByEvn',array(
                        'FTEvnCode'         => $paDataMaster['oetEvnCode'],
                        'FNEvnSeqNo'        => $nCountRumrowEvn,
                        'FTEvnType'         => $paDataMaster['ocmEvnTypeSend'][$nI],
                        'FTEvnStaAllDay'    => $paDataMaster['ocbEvnStaAllDay'][$nI],
                        'FDEvnDStart'       => (!empty($paDataMaster['oetEvnDStartSend'][$nI]))?   $paDataMaster['oetEvnDStartSend'][$nI] : null,
                        'FDEvnDFinish'      => (!empty($paDataMaster['oetEvnDFinishSend'][$nI]))?  $paDataMaster['oetEvnDFinishSend'][$nI] : null,
                        'FTEvnTStart'       => (!empty($paDataMaster['oetEvnTStartSend'][$nI]))?   $paDataMaster['oetEvnTStartSend'][$nI] : null,
                        'FTEvnTFinish'      => (!empty($paDataMaster['oetEvnTFinishSend'][$nI]))?  $paDataMaster['oetEvnTFinishSend'][$nI] : null,
                        'FDLastUpdOn'       => $paDataMaster['FDLastUpdOn'],
                        'FDCreateOn'        => $paDataMaster['FDCreateOn'],
                        'FTLastUpdBy'       => $paDataMaster['FTLastUpdBy'],
                        'FTCreateBy'        => $paDataMaster['FTCreateBy'],
                    ));
                    if($this->db->affected_rows() > 0){
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Add Product NoSale By Event Success.',
                        );
                    }else{
                        $aStatus = array(
                            'rtCode' => '905',
                            'rtDesc' => 'Error Cannot Add/Edit Product NoSale By Event Lang.',
                        );
                        break;
                    }
                }
            }else{
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Product NoSale By Event Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Add/Update Product NoSale By Event Lang
    //Parameters : function parameters
    //Creator : 27/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMEVNAddUpdateLang($paDataMaster){
        try{
            $this->db->where('FNLngID', $paDataMaster['FNLngID']);
            $this->db->where('FTEvnCode', $paDataMaster['oetEvnCode']);
            $this->db->update('TCNMPdtNoSleByEvn_L',array(
                'FTEvnName' => $paDataMaster['oetEvnName'],
                'FTEvnRmk'  => $paDataMaster['otaEvnRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product NoSale By Event Lang Success.',
                );
            }else{
                $this->db->insert('TCNMPdtNoSleByEvn_L',array(
                    'FTEvnCode' => $paDataMaster['oetEvnCode'],
                    'FNLngID'   => $paDataMaster['FNLngID'],
                    'FTEvnName' => $paDataMaster['oetEvnName'],
                    'FTEvnRmk'  => $paDataMaster['otaEvnRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product NoSale By Event Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product NoSale By Event Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product NoSale By Event
    //Parameters : function parameters
    //Creator : 24/09/2018 Wasin
    //Return : Status Delete
    //Return Type : array
    public function FSaMEVNDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTEvnCode', $paData['FTEvnCode']);
            $this->db->delete('TCNMPdtNoSleByEvn');

            $this->db->where_in('FTEvnCode', $paData['FTEvnCode']);
            $this->db->delete('TCNMPdtNoSleByEvn_L');

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

    //Functionality : ดึงรายการช่วงเวลาประเภทข้อมูล เวลา ออกมา กรองโดย evn code
    //Parameters : function parameters
    //Creator : 23/04/2019 pap
    //Return : ข้อมูลรายการเวลา
    //Return Type : array
    public function FSaMGetEVNListTime($pnEVNCode){
        $tSQL = "SELECT FNEvnSeqNo,
                        FTEvnTStart,
                        FTEvnTFinish
                FROM TCNMPdtNoSleByEvn 
                WHERE FTEvnCode = '".$pnEVNCode."'
                AND FTEvnType = 1";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result_array();
        }else{
            return FALSE;
        }
    } 

    //Functionality : ดึงรายการช่วงวันที่ประเภททั้งวัน ออกมา กรองโดย evn code
    //Parameters : function parameters
    //Creator : 23/04/2019 pap
    //Return : ข้อมูลรายการวันที่
    //Return Type : array
    public function FSaMGetEVNListDate($pnEVNCode){
        $tSQL = "SELECT FNEvnSeqNo,
                        REPLACE(CONVERT(varchar(10), FDEvnDStart, 111),'/','-') AS FDEvnDStart,
                        REPLACE(CONVERT(varchar(10), FDEvnDFinish, 111),'/','-') AS FDEvnDFinish
                        
                FROM TCNMPdtNoSleByEvn 
                WHERE FTEvnCode = '".$pnEVNCode."'
                AND FTEvnType = 2
                AND FTEvnStaAllDay = 1";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result_array();
        }else{
            return FALSE;
        }
    } 

    //Functionality : ดึงรายการช่วงวันที่ประเภทไม่ทั้งวัน ออกมา กรองโดย evn code
    //Parameters : function parameters
    //Creator : 23/04/2019 pap
    //Return : ข้อมูลรายการวันที่ เวลา
    //Return Type : array
    public function FSaMGetEVNListDateTime($pnEVNCode){
        $tSQL = "SELECT FNEvnSeqNo,
                        FTEvnTStart,
                        FTEvnTFinish,
                        REPLACE(CONVERT(varchar(10), FDEvnDStart, 111),'/','-') AS FDEvnDStart,
                        REPLACE(CONVERT(varchar(10), FDEvnDFinish, 111),'/','-') AS FDEvnDFinish
                FROM TCNMPdtNoSleByEvn 
                WHERE FTEvnCode = '".$pnEVNCode."'
                AND FTEvnType = 2
                AND FTEvnStaAllDay = 0";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result_array();
        }else{
            return FALSE;
        }
    } 
}