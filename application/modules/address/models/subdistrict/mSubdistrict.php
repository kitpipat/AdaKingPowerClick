<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSubdistrict extends CI_Model {

    //Functionality : Search Subdistrict By ID
    //Parameters : function parameters
    //Creator : 12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMSDTSearchByID($paData){
        $tSudCode   = $paData['FTSudCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    SDT.FTSudCode       AS rtSudCode,
                    SDT.FTDstCode       AS rtDstCode,
                    DSTL.FTDstName      AS rtDstName,
                    SDT.FTSudLatitude   AS rtSudLatitude,
                    SDT.FTSudLongitude  AS rtSudLongitude,
                    SDTL.FTSudName      AS rtSudName,
                    PVNL.FTPvnCode      AS rtPvnCode,
                    PVNL.FTPvnName      AS rtPvnName
                FROM TCNMSubDistrict SDT
                LEFT JOIN TCNMSubDistrict_L SDTL ON SDT.FTSudCode = SDTL.FTSudCode AND SDTL.FNLngID = $nLngID
                LEFT JOIN TCNMDistrict  DST ON SDT.FTDstCode = DST.FTDstCode
                LEFT JOIN TCNMDistrict_L DSTL ON SDT.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                LEFT JOIN TCNMProvince_L PVNL ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                WHERE 1=1 ";

        if($tSudCode!= ""){
            $tSQL .= "AND SDT.FTSudCode = '$tSudCode'";
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
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : Data List Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMSDTList($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY rtSudCode ASC) AS rtRowID,* FROM
                            (SELECT DISTINCT
                                SDT.FTSudCode       AS rtSudCode,
                                SDT.FTDstCode       AS rtDstCode,
                                DSTL.FTDstName      AS rtDstName,
                                SDT.FTSudLatitude   AS rtSudLatitude,
                                SDT.FTSudLongitude  AS rtSudLongitude,
                                SDTL.FTSudName      AS rtSudName,
                                PVNL.FTPvnCode      AS rtPvnCode,
                                PVNL.FTPvnName      AS rtPvnName
                            FROM TCNMSubDistrict SDT
                            LEFT JOIN TCNMSubDistrict_L SDTL ON SDT.FTSudCode = SDTL.FTSudCode AND SDTL.FNLngID = $nLngID
                            LEFT JOIN TCNMDistrict  DST ON SDT.FTDstCode = DST.FTDstCode
                            LEFT JOIN TCNMDistrict_L DSTL ON SDT.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                            LEFT JOIN TCNMProvince_L PVNL ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                            WHERE 1=1 ";

        $tSearchList = $paData['tSearchAll'];
        if($tSearchList != ''){
            $tSQL .= " AND (SDT.FTSudCode LIKE '%$tSearchList%'";
            $tSQL .= " OR SDTL.FTSudName LIKE '%$tSearchList%'";
            $tSQL .= " OR DSTL.FTDstName LIKE '%$tSearchList%'";
            $tSQL .= " OR PVNL.FTPvnName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow  = $this->FSnMSDTGetPageAll($tSearchList,$nLngID);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
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

    //Functionality : All Page Of Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSnMSDTGetPageAll($ptSearchList,$ptLngID){
        $tSQL = "SELECT COUNT (SDT.FTSudCode) AS counts

                FROM TCNMSubDistrict SDT
                LEFT JOIN TCNMSubDistrict_L SDTL ON SDT.FTSudCode = SDTL.FTSudCode AND SDTL.FNLngID = $ptLngID
                LEFT JOIN TCNMDistrict  DST ON SDT.FTDstCode = DST.FTDstCode
                LEFT JOIN TCNMDistrict_L DSTL ON SDT.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $ptLngID
                LEFT JOIN TCNMProvince_L PVNL ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $ptLngID
                WHERE 1=1 ";

        if($ptSearchList != ''){
            $tSQL .= " AND (SDT.FTSudCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR SDTL.FTSudName LIKE '%$ptSearchList%'";
            $tSQL .= " OR DSTL.FTDstName LIKE '%$ptSearchList%'";
            $tSQL .= " OR PVNL.FTPvnName LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : Chack Data Code Duplicate
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Array Count Data
    //Return Type : Array
    public function FSnMSDTCheckDuplicate($ptSubCode){
        $tSQL = "SELECT COUNT(FTSudCode)AS counts
                 FROM TCNMSubDistrict
                 WHERE FTSudCode = '$ptSubCode' ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMSDTAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTDstCode' , $paData['FTDstCode']);
            $this->db->set('FTSudLatitude' , $paData['FTSudLatitude']);
            $this->db->set('FTSudLongitude' , $paData['FTSudLongitude']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTSudCode', $paData['FTSudCode']);
            $this->db->update('TCNMSubDistrict');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TCNMSubDistrict',array(
                    'FTSudCode'         => $paData['FTSudCode'],
                    'FTDstCode'         => $paData['FTDstCode'],
                    'FTSudLatitude'     => $paData['FTSudLatitude'],
                    'FTSudLongitude'    => $paData['FTSudLongitude'],
                    'FDCreateOn'        => $paData['FDCreateOn'],
                    'FTCreateBy'        => $paData['FTCreateBy']
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

    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMSDTAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTSudName' , $paData['FTSudName']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTSudCode', $paData['FTSudCode']);
            $this->db->update('TCNMSubDistrict_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                //Add Lang
                $this->db->insert('TCNMSubDistrict_L',array(
                    'FTSudCode' => $paData['FTSudCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTSudName' => $paData['FTSudName']
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

    //Functionality : Delete Subdistrict
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSaMSDTDel($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTSudCode', $paData['FTSudCode']);
            $this->db->delete('TCNMSubDistrict');

            $this->db->where_in('FTSudCode', $paData['FTSudCode']);
            $this->db->delete('TCNMSubDistrict_L');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    
    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow(){
        
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMSubDistrict";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }   
  





}