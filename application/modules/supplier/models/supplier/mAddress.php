<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAddress extends CI_Model {

    //Functionality : list Data Address
    //Parameters : function parameters
    //Creator :  22/10/2018 Phisan
    //Return : data
    //Return Type : Array
    public function FSaMADDList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSplCode         = $paData['tSplCode'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = "SELECT c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY rtSplCode ASC) AS rtRowID,* FROM
                                        (SELECT DISTINCT
                                        FTSplCode AS rtSplCode,
                                        FNLngID AS rtLngID,
                                        FTAddGrpType AS rtAddGrpType,
                                        FNAddSeqNo AS rtAddSeqNo,
                                        FTAddRefNo AS rtAddRefNo,
                                        FTAddName AS rtAddName,
                                        FTAddCountry AS rtAddCountry,
                                        FTAreCode AS rtAreCode,
                                        FTZneCode AS rtZneCode,

                                        FTAddV1No AS rtAddV1No,
                                        FTAddV1Soi AS rtAddV1Soi,
                                        FTAddV1Village AS rtAddV1Village,
                                        FTAddV1Road AS rtAddV1Road,
                                        FTAddV1SubDist AS rtAddV1SubDist,
                                        FTAddV1DstCode AS rtAddV1DstCode,
                                        FTAddV1PvnCode AS rtAddV1PvnCode,
                                        FTAddV1PostCode AS rtAddV1PostCode,

                                        FTAddV2Desc1 AS rtAddV2Desc1,

                                        FTAddWebsite AS rtAddWebsite
                                        FROM TCNMSplAddress_L
                                        WHERE FTSplCode = '$tSplCode' AND FNLngID = $nLngID AND FTAddGrpType != '2' ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (FTAddName   LIKE '%$tSearchList%'";
                $tSQL .= " OR FTAddWebsite LIKE '%$tSearchList%' )";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMADDGetPageAll($tSearchList,$nLngID,$tSplCode);
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

    //Functionality : All Page Of Address
    //Parameters : function parameters
    //Creator :  22/10/2018 Phisan
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMADDGetPageAll($ptSearchList,$pnLngID,$ptSplCode){
        try{
            $tSQL = "SELECT COUNT (FTSplCode) AS counts
                     FROM TCNMSplAddress_L
                     WHERE FTSplCode = '$ptSplCode' AND FNLngID = $pnLngID  AND FTAddGrpType != '2' ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (FTAddName   LIKE '%$ptSearchList%'";
                $tSQL .= " OR FTAddWebsite LIKE '%$ptSearchList%' )";
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

    //Functionality : Get Data Address By ID
    //Parameters : function parameters
    //Creator : 22/10/2018 Phisan
    //Return : data
    //Return Type : Array
    public function FSaMADDGetDataByID($paData){
        try{
            $tSplCode   = $paData['FTSplCode'];
            $nLngID     = $paData['FNLngID'];
            $tAddGrpType   = $paData['FTAddGrpType'];
            $tAddSeqNo     = $paData['FNAddSeqNo'];
            $tSQL       = " SELECT
                                FTSplCode AS rtSplCode,
                                FTAddGrpType AS rtAddGrpType,
                                FNAddSeqNo AS rtAddSeqNo,
                                Address_L.FNLngID AS rtLngID,
                                FTAddRefNo AS rtAddRefNo,
                                FTAddName AS rtAddName,
                                FTAddTaxNo AS rtAddTaxNo,
                                FTAddRmk AS rtAddRmk,

                                FTAddCountry AS rtAddCountry,
                                Address_L.FTAreCode AS rtAreCode,
                                Address_L.FTZneCode AS rtZneCode,
                                FTAddVersion AS rtAddVersion,
                                FTAddV1No AS rtAddV1No,
                                FTAddV1Soi AS rtAddV1Soi,
                                FTAddV1Village AS rtAddV1Village,
                                FTAddV1Road AS rtAddV1Road,
                                Address_L.FTAddV1SubDist AS rtAddV1SubDist,
                                Address_L.FTAddV1DstCode AS rtAddV1DstCode,
                                Address_L.FTAddV1PvnCode AS rtAddV1PvnCode,
                                FTAddV1PostCode AS rtAddV1PostCode,

                                FTAddV2Desc1 AS rtAddV2Desc1,
                                FTAddV2Desc2 AS rtAddV2Desc2,
                                FTAddWebsite AS rtAddWebsite,


                                FTAreName AS rtAreName,
                                FTZneChainName AS rtZneChainName,
                                FTPvnName AS rtPvnName,
                                FTDstName AS rtDstName,
                                FTSudName AS rtSudName,


                                FTAddLongitude AS rtAddLongitude,
                                FTAddLatitude AS rtAddLatitude

                            FROM TCNMSplAddress_L Address_L
                            LEFT JOIN TCNMArea_L Area_L ON Address_L.FTAreCode = Area_L.FTAreCode AND Area_L.FNLngID = $nLngID
                            LEFT JOIN TCNMZone_L Zone_L ON Address_L.FTZneCode = Zone_L.FTZneChain AND Zone_L.FNLngID = $nLngID
                            LEFT JOIN TCNMProvince_L Province_L ON Address_L.FTAddV1PvnCode = Province_L.FTPvnCode AND Province_L.FNLngID = $nLngID
                            LEFT JOIN TCNMDistrict_L Dist_L ON Address_L.FTAddV1DstCode = Dist_L.FTDstCode AND Dist_L.FNLngID = $nLngID
                            LEFT JOIN TCNMSubDistrict_L SubD ON Address_L.FTAddV1SubDist = SubD.FTSudCode AND SubD.FNLngID = $nLngID
                            WHERE Address_L.FNLngID = $nLngID AND FTSplCode = '$tSplCode' AND FTAddGrpType = '$tAddGrpType' AND FNAddSeqNo = '$tAddSeqNo' ";
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

    //Functionality : Add Table Address
    //Parameters : function parameters
    //Creator : 22/10/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMADDAddMaster($paData){
        try{
            //Add Address Main Table
            $this->db->insert('TCNMSplAddress_L',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Address Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Address.',
                );
            }
            
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Table Address
    //Parameters : function parameters
    //Creator : 09/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMADDUpdateMaster($paData,$paPK){
        try{
            $this->db->where('FTSplCode', $paPK['FTSplCode']);
            $this->db->where('FNLngID', $paPK['FNLngID']);
            $this->db->where('FTAddGrpType', $paPK['FTAddGrpType']);
            $this->db->where('FNAddSeqNo', $paPK['FNAddSeqNo']);
            $this->db->update('TCNMSplAddress_L',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Address Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Edit Address.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Check duplicate
    //Parameters : function parameters
    //Creator : 15/11/2018 Phisan
    //Return : Array num row
    //Return Type : Array
    public function FSaMADDChkDup($paData){
        try{
            $this->db->select('FTSplCode');
            $this->db->where('FTSplCode', $paData['FTSplCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTAddGrpType', $paData['FTAddGrpType']);
            $this->db->where('FNAddSeqNo', $paData['FNAddSeqNo']);
            $oQuery = $this->db->get('TCNMSplAddress_L');
            $nRow = $oQuery->num_rows();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success.',
                'nRow' => $nRow
            );
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Address
    //Parameters : function parameters
    //Creator : 22/10/2018 Phisan
    //Return : Status Delete
    //Return Type : array
    public function FSnMADDDel($paData){
        try{
            $this->db->trans_begin();
            $this->db->where('FTSplCode', $paData['FTSplCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTAddGrpType', $paData['FTAddGrpType']);
            $this->db->where('FNAddSeqNo', $paData['FNAddSeqNo']);
            $this->db->delete('TCNMSplAddress_L');

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

}