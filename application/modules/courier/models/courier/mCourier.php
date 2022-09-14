<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCourier extends CI_Model {

    //Functionality : list Courier
    //Parameters : function parameters
    //Creator :  09/07/2019 Napat(Jame)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCRYDataList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTCryCode ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                CRY.FTCryCode,
                                CRY_L.FTCryName,
                                CRY.FTCryBusiness,
                                CRY.FTCryTel,
                                CRY.FTCryBchCode AS FTBchName,
                                CRY.FTCryEmail,
                                CRY.FTCryBchHQ,
                                IMG.FTImgObj
                            FROM TCNMCourier CRY WITH(NOLOCK)
                            LEFT JOIN TCNMCourier_L CRY_L   WITH(NOLOCK) ON CRY_L.FTCryCode = CRY.FTCryCode        AND CRY_L.FNLngID = $nLngID

                            LEFT JOIN [TCNMImgObj]  IMG     WITH(NOLOCK) ON CRY.FTCryCode   = IMG.FTImgRefID       AND IMG.FTImgTable = 'TCNMCourier'
                            WHERE 1=1 ";

        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (CRY.FTCryCode       LIKE '%$tSearchList%'";
            $tSQL .= "      OR CRY_L.FTCryName  LIKE '%$tSearchList%'";
            $tSQL .= "      OR CRY.FTCryEmail   LIKE '%$tSearchList%'";
            $tSQL .= "      OR CRY.FTCryTel     LIKE '%$tSearchList%')";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCRYGetPageAll($tSearchList,$nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'aItems'       => $oList,
                'nAllRow'      => $nFoundRow,
                'nCurrentPage' => $paData['nPage'],
                'nAllPage'     => $nPageAll,
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'nAllRow'       => 0,
                'nCurrentPage'  => $paData['nPage'],
                "nAllPage"      => 0,
                'tCode'         => '800',
                'tDesc'         => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : All Page Of Courier
    //Parameters : function parameters
    //Creator :  09/07/2019 Napat(Jame)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMCRYGetPageAll($ptSearchList,$ptLngID){

        $tSQL = "SELECT COUNT (CRY.FTCryCode) AS counts
                 FROM TCNMCourier CRY
                 LEFT JOIN TCNMCourier_L CRY_L ON CRY_L.FTCryCode = CRY.FTCryCode AND CRY_L.FNLngID = $ptLngID
                 WHERE 1=1 ";

        if($ptSearchList != ''){
            $tSQL .= " AND (CRY.FTCryCode       LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CRY_L.FTCryName  LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CRY.FTCryEmail   LIKE '%$ptSearchList%'";
            $tSQL .= "      OR CRY.FTCryTel     LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : Checkduplicate Courier
    //Parameters : function parameters
    //Creator : 10/07/2562 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMCRYCheckDuplicate($ptCryCode){
        $tSQL = "SELECT COUNT(FTCryCode) AS counts
                 FROM TCNMCourier
                 WHERE FTCryCode = '$ptCryCode'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Courier
    //Parameters : function parameters
    //Creator : 10/07/2562 Napat(Jame)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCRYUpdateMaster($paDataUpdate){
        try{
            //Update
            $this->db->where('FTCryCode',$paDataUpdate['FTCryCode']);
            $this->db->set('FTCryCardID',$paDataUpdate['FTCryCardID']);
            $this->db->set('FTCryTaxNo',$paDataUpdate['FTCryTaxNo']);
            $this->db->set('FTCryTel',$paDataUpdate['FTCryTel']);
            $this->db->set('FTCryFax',$paDataUpdate['FTCryFax']);
            $this->db->set('FTCryEmail',$paDataUpdate['FTCryEmail']);
            $this->db->set('FTCrySex',$paDataUpdate['FTCrySex']);
            $this->db->set('FDCryDob',$paDataUpdate['FDCryDob']);
            $this->db->set('FTCgpCode',$paDataUpdate['FTCgpCode']);
            $this->db->set('FTCtyCode',$paDataUpdate['FTCtyCode']);
            $this->db->set('FTCryBusiness',$paDataUpdate['FTCryBusiness']);
            $this->db->set('FTCryBchHQ',$paDataUpdate['FTCryBchHQ']);
            $this->db->set('FTCryBchCode',$paDataUpdate['FTCryBchCode']);
            $this->db->set('FTCryDelimeterQR',$paDataUpdate['FTCryDelimeterQR']);
            $this->db->set('FDCreateOn', 'GETDATE()', false);
            $this->db->set('FDLastUpdOn', 'GETDATE()', false);
            $this->db->update('TCNMCourier');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Update Success',
                );
            }else{
                //Insert
                $this->db->set('FDCreateOn', 'GETDATE()', false);
                $this->db->set('FDLastUpdOn', 'GETDATE()', false);
                $this->db->insert('TCNMCourier', array(
                    'FTCryCode'         => $paDataUpdate['FTCryCode'],
                    'FTCryCardID'       => $paDataUpdate['FTCryCardID'],
                    'FTCryTaxNo'        => $paDataUpdate['FTCryTaxNo'],
                    'FTCryTel'          => $paDataUpdate['FTCryTel'],
                    'FTCryFax'          => $paDataUpdate['FTCryFax'],
                    'FTCryEmail'        => $paDataUpdate['FTCryEmail'],
                    'FTCrySex'          => $paDataUpdate['FTCrySex'],
                    'FDCryDob'          => $paDataUpdate['FDCryDob'],
                    'FTCgpCode'         => $paDataUpdate['FTCgpCode'],
                    'FTCtyCode'         => $paDataUpdate['FTCtyCode'],
                    'FTCryBusiness'     => $paDataUpdate['FTCryBusiness'],
                    'FTCryBchHQ'        => $paDataUpdate['FTCryBchHQ'],
                    'FTCryBchCode'      => $paDataUpdate['FTCryBchCode'],
                    'FTCryDelimeterQR'  => $paDataUpdate['FTCryDelimeterQR'],
                    'FTCryStaActive'    => $paDataUpdate['FTCryStaActive'],
                    'FTCryLoginType'    => $paDataUpdate['FTCryLoginType'],
                    'FNCryCrTerm'       => $paDataUpdate['FNCryCrTerm'],
                    'FCCryCrLimit'      => $paDataUpdate['FCCryCrLimit'],
                    'FTLastUpdBy'       => $paDataUpdate['FTLastUpdBy'],
                    'FTCreateBy'        => $paDataUpdate['FTCreateBy'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'tCode' => '1',
                        'tDesc' => 'Insert Success',
                    );
                }else{
                    $aStatus = array(
                        'tCode' => '905',
                        'tDesc' => 'Error Cannot Insert/Update (FSaMCRYUpdateMaster)',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Courier
    //Parameters : function parameters
    //Creator : 10/07/2562 Napat(Jame)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCRYUpdateLang($paDataUpdate){
        try{
            //Update
            $this->db->where('FTCryCode', $paDataUpdate['FTCryCode']);
            $this->db->where('FNLngID', $paDataUpdate['FNLngID']);
            $this->db->update('TCNMCourier_L',$paDataUpdate);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Update Success',
                );
            }else{
                //Insert
                $this->db->insert('TCNMCourier_L',$paDataUpdate);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'tCode' => '1',
                        'tDesc' => 'Insert Success',
                    );
                }else{
                    $aStatus = array(
                        'tCode' => '905',
                        'tDesc' => 'Error Cannot Insert/Update (FSaMCRYUpdateLang)',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : list Courier
    //Parameters : function parameters
    //Creator :  09/07/2019 Napat(Jame)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCRYGetDataByID($paDataCourier){
        try{
            $tCryCode   = $paDataCourier['FTCryCode'];
            $nLngID     = $paDataCourier['FNLngID'];
            $tSQL   = "SELECT
                            CRY.FTCryCode,
                            CRY.FNCryCrTerm,
                            CRY.FCCryCrLimit,
                            CRY_L.FTCryName,
                            CRY_L.FTCryNameOth,
                            CRY_L.FTCryRmk,
                            CRY.FTCryCardID,
                            CRY.FTCryTaxNo,
                            CRY.FTCryTel,
                            CRY.FTCryFax,
                            CRY.FTCryEmail,
                            CRY.FTCrySex,
                            CRY.FDCryDob,
                            CRY.FTCgpCode,
                            GRP_L.FTCgpName,
                            CRY.FTCtyCode,
                            TYP_L.FTCtyName,
                            CRY.FTCryBusiness,
                            CRY.FTCryBchHQ,
                            CRY.FTCryBchCode,
                            CRY.FTCryDelimeterQR,
                            CRY.FTCryStaActive,
                            CRY.FTCryLoginType
                        FROM TCNMCourier CRY
                        LEFT JOIN TCNMCourier_L     CRY_L ON CRY_L.FTCryCode = CRY.FTCryCode AND CRY_L.FNLngID = $nLngID
                        LEFT JOIN TCNMCourierGrp_L  GRP_L ON GRP_L.FTCgpCode = CRY.FTCgpCode AND GRP_L.FNLngID = $nLngID
                        LEFT JOIN TCNMCourierType_L TYP_L ON TYP_L.FTCtyCode = CRY.FTCtyCode AND TYP_L.FNLngID = $nLngID
                        WHERE CRY.FTCryCode = '$tCryCode'";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aResult = array(
                    'aItems'       => $oQuery->result_array()[0],
                    'tCode'        => '1',
                    'tDesc'        => 'success',
                );
            }else{
                $aResult = array(
                    'tCode'         => '800',
                    'tDesc'         => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Image for Courier
    //Parameters : function parameters
    //Creator :  10/07/2019 Napat(Jame)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCRYGetImageByID($paDataCourier){
        try{
            $tCryCode   = $paDataCourier['FTCryCode'];
            $tImgTable  = $paDataCourier['FTImgTable'];
            $nLngID     = $paDataCourier['FNLngID'];
            $tSQL       = " SELECT
                                IMG.FTImgRefID,
                                IMG.FNImgSeq,
                                IMG.FTImgObj
                            FROM TCNMImgObj IMG
                            WHERE 1=1
                            AND FTImgTable  = '$tImgTable'
                            AND FTImgRefID  = '$tCryCode'
            ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aResult = array(
                    'aItems'    => $oQuery->result_array()[0],
                    'tCode'     => '1',
                    'tDesc'     => 'success',
                );
            }else{
                $aResult = array(
                    'tCode'         => '800',
                    'tDesc'         => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Courier
    //Parameters : function parameters
    //Creator : 10/07/2562 Napat(Jame)
    //Return : Status Delete
    //Return Type : array
    public function FSaMCRYDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTCryCode', $paData['FTCryCode']);
            $this->db->delete('TCNMCourier');

            $this->db->where_in('FTCryCode', $paData['FTCryCode']);
            $this->db->delete('TCNMCourier_L');

            $this->db->where_in('FTImgTable', 'TCNMCourier');
            $this->db->where_in('FTImgRefID', $paData['FTCryCode']);
            $this->db->delete('TCNMImgObj');

            $this->db->where_in('FTAddGrpType', '8');
            $this->db->where_in('FTAddRefCode', $paData['FTCryCode']);
            $this->db->delete('TCNMAddress_L');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'tCode' => '905',
                    'tDesc' => 'Delete Unsuccess.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

}
