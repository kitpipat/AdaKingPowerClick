<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mContact extends CI_Model {

    //Functionality : list Data Contact
    //Parameters : function parameters
    //Creator :  20/11/2018 Phisan
    //Return : data
    //Return Type : Array
    public function FSaMCTRList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSplCode         = $paData['tSplCode'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = "SELECT c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY rtSplCode ASC) AS rtRowID,* FROM
                                        (SELECT 
                                        Contact_L.FTSplCode AS rtSplCode,
                                        FNCtrSeq AS rtCtrSeq,
                                        Contact_L.FNLngID AS rtLngID,
                                        FTAddGrpType AS rtAddGrpType,
                                        FNAddSeqNo AS rtAddSeqNo,
                                        FTAddRefNo AS rtAddRefNo,
                                        FTCtrName AS rtCtrName,
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
                                        FROM TCNMSplContact_L Contact_L
                                        LEFT JOIN TCNMSplAddress_L Address_L ON Contact_L.FNCtrSeq = Address_L.FTAddRefNo AND Address_L.FNLngID = $nLngID AND FTAddGrpType = '2'
                                        WHERE Contact_L.FTSplCode = '$tSplCode' AND Contact_L.FNLngID = $nLngID  ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (FTAddName   LIKE '%$tSearchList%'";
                $tSQL .= " OR FTCtrName LIKE '%$tSearchList%' )";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMCTRGetPageAll($tSearchList,$nLngID,$tSplCode);
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

    //Functionality : All Page Of Contact
    //Parameters : function parameters
    //Creator :  20/11/2018 Phisan
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMCTRGetPageAll($ptSearchList,$pnLngID,$ptSplCode){
        try{
            $tSQL = "SELECT COUNT (FTSplCode) AS counts
                     FROM TCNMSplContact_L
                     WHERE FNLngID = $pnLngID AND FTSplCode = '$ptSplCode' ";
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

    //Functionality : Get Data Contact By ID
    //Parameters : function parameters
    //Creator : 20/11/2018 Phisan
    //Return : data
    //Return Type : Array
    public function FSaMCTRGetDataByID($paData){
        try{
            $tSplCode   = $paData['FTSplCode'];
            $nLngID     = $paData['FNLngID'];
            $tCtrSeq   = $paData['FNCtrSeq'];
            $tSQL       = " SELECT
                                Contact_L.FTSplCode AS rtSplCode,
                                FNCtrSeq AS rtCtrSeq,
                                FTCtrName AS rtCtrName,
                                FTCtrFax AS rtCtrFax,
                                FTCtrTel AS rtCtrTel,
                                FTCtrEmail AS rtCtrEmail,
                                FTCtrRmk AS rtCtrRmk,

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

                            FROM TCNMSplContact_L Contact_L
                            LEFT JOIN TCNMSplAddress_L Address_L ON Contact_L.FNCtrSeq = Address_L.FTAddRefNo AND Address_L.FNLngID = $nLngID
                            LEFT JOIN TCNMArea_L Area_L ON Address_L.FTAreCode = Area_L.FTAreCode AND Area_L.FNLngID = $nLngID
                            LEFT JOIN TCNMZone_L Zone_L ON Address_L.FTZneCode = Zone_L.FTZneChain AND Zone_L.FNLngID = $nLngID
                            LEFT JOIN TCNMProvince_L Province_L ON Address_L.FTAddV1PvnCode = Province_L.FTPvnCode AND Province_L.FNLngID = $nLngID
                            LEFT JOIN TCNMDistrict_L Dist_L ON Address_L.FTAddV1DstCode = Dist_L.FTDstCode AND Dist_L.FNLngID = $nLngID
                            LEFT JOIN TCNMSubDistrict_L SubD ON Address_L.FTAddV1SubDist = SubD.FTSudCode AND SubD.FNLngID = $nLngID
                            WHERE Contact_L.FNLngID = $nLngID AND Contact_L.FTSplCode = '$tSplCode' AND FNCtrSeq = '$tCtrSeq' ";
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

    //Functionality : Add Table Contact
    //Parameters : function parameters
    //Creator : 20/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMCTRAddMaster($paData){
        try{
            //Add Contact Main Table
            $this->db->insert('TCNMSplContact_L',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Contact Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Contact.',
                );
            }
            
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }
    //Functionality : Add Table Ad
    //Parameters : function parameters
    //Creator : 21/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMCTRAddDT($paData){
        try{
            //Add Contact Main Table
            $this->db->insert('TCNMSplAddress_L',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Address Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Address.',
                );
            }
            
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Last Seq
    //Parameters : function parameters
    //Creator : 20/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMCTRGetLastSeq(){
        try{
            //Add Contact Main Table
            $this->db->select('FNCtrSeq');
            $this->db->order_by('FNCtrSeq','desc');
            $this->db->limit(1);
            $oQuery = $this->db->get('TCNMSplContact_L');
            $aItem = $oQuery->result_array();
            // echo '<pre>';
            // print_r($aItem);
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success.',
                'rnCtrSeq' => $aItem[0]['FNCtrSeq']
            );
            
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Table Contact
    //Parameters : function parameters
    //Creator : 20/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMCTRUpdateMaster($paData,$ptCtrSeq){
        try{
            $this->db->where('FTSplCode', $paData['FTSplCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FNCtrSeq', $ptCtrSeq);
            $this->db->update('TCNMSplContact_L',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Contact Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Edit Contact.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Table DT
    //Parameters : function parameters
    //Creator : 20/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMCTRDT($paData,$aPK){
        try{
            $this->db->where('FTSplCode', $aPK['FTSplCode']);
            $this->db->where('FNLngID', $aPK['FNLngID']);
            $this->db->where('FTAddGrpType', $aPK['FTAddGrpType']);
            $this->db->where('FNAddSeqNo', $aPK['FNAddSeqNo']);
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


    //Functionality : Delete Contact
    //Parameters : function parameters
    //Creator : 20/11/2018 Phisan
    //Return : Status Delete
    //Return Type : array
    public function FSnMCTRDel($paData){
        try{
            $this->db->trans_begin();
            $this->db->where('FTSplCode', $paData['FTSplCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FNCtrSeq', $paData['FNCtrSeq']);
            $this->db->delete('TCNMSplContact_L');

            $this->db->where('FTAddRefNo', $paData['FNCtrSeq']);
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