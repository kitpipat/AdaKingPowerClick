<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Installmentterms_model extends CI_Model {

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSesUsrLevel   = $paData['tSesUsrLevel'];
            $tAgnCode       = $paData['tAgnCode'];

            $tSQLFist       = " SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS rtRowID,* FROM ( ";
            $tSQLContent    = "     SELECT DISTINCT
                                        STM.FTAgnCode,
                                        STM.FTStmCode,
                                        STM_L.FTStmName,
                                        STM.FDCreateOn,
                                        STM.FCStmLimit,
                                        STM.FNStmQty,
                                        STM.FTStmStaUnit,
                                        STM.FCStmRate
                                    FROM TFNMInstallment STM WITH(NOLOCK)
                                    LEFT JOIN TFNMInstallment_L STM_L WITH(NOLOCK) ON STM.FTStmCode = STM_L.FTStmCode AND STM_L.FNLngID = ".$this->db->escape($nLngID)."
                                    WHERE 1=1
                              ";

            if( $tSesUsrLevel != "HQ" ){
                $tSQLContent .= " AND ( ISNULL(STM.FTAgnCode,'') = '' OR STM.FTAgnCode = '$tAgnCode' ) ";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQLContent .= " AND (STM.FTStmCode COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($tSearchList)."%' OR STM_L.FTStmName COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($tSearchList)."%') ";
            }
            $tSQLEnd        = ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $tMainSQL = $tSQLFist.$tSQLContent.$tSQLEnd;

            $oQuery = $this->db->query($tMainSQL);
            if( $oQuery->num_rows() > 0 ){
                $nFoundRow = $this->db->query($tSQLContent)->num_rows();
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
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

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMGetDataByID($paData){
        try{
            $tStmCode   = $paData['FTStmCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT
                                STM.FTAgnCode,
                                AGN_L.FTAgnName,
                                STM.FTStmCode,
                                ISNULL(STM.FCStmLimit,0) AS FCStmLimit,
                                ISNULL(STM.FNStmQty,0) AS FNStmQty,
                                ISNULL(STM.FCStmRate,0) AS FCStmRate,
                                STM.FTStmStaUnit,
                                STM_L.FTStmName,
                                STM_L.FTStmRmk
                            FROM TFNMInstallment          STM WITH(NOLOCK)
                            LEFT JOIN TFNMInstallment_L STM_L WITH(NOLOCK) ON STM.FTStmCode = STM_L.FTStmCode AND STM_L.FNLngID = $nLngID
                            LEFT JOIN TCNMAgency_L      AGN_L WITH(NOLOCK) ON STM.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                            WHERE STM.FTStmCode = '$tStmCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aResult = array(
                    'raItems'   => $oQuery->row_array(),
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

    // Create By : Napat(Jame) 08/11/2021
    public function FSnMSTMCheckDuplicate($ptData){
        $tStmCode = $ptData['FTStmCode'];
        $tAgnCode = $ptData['FTAgnCode'];
        $tSQL = "SELECT COUNT(STM.FTStmCode) AS counts
                 FROM TFNMInstallment STM
                 WHERE STM.FTStmCode = '$tStmCode' AND STM.FTAgnCode = '$tAgnCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMAddUpdateMaster($paData){
        try{
            // Update TFNMInstallment
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTStmCode', $paData['FTStmCode']);
            $this->db->update('TFNMInstallment',array(

                'FCStmLimit'    => $paData['FCStmLimit'],
                'FNStmQty'      => $paData['FNStmQty'],
                'FCStmRate'     => $paData['FCStmRate'],
                'FTStmStaUnit'  => $paData['FTStmStaUnit'],

                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update TFNMInstallment Success',
                );
            }else{
                //Add TFNMInstallment
                $this->db->insert('TFNMInstallment', array(
                    'FTAgnCode'     => $paData['FTAgnCode'],
                    'FTStmCode'     => $paData['FTStmCode'],

                    'FCStmLimit'    => $paData['FCStmLimit'],
                    'FNStmQty'      => $paData['FNStmQty'],
                    'FCStmRate'     => $paData['FCStmRate'],
                    'FTStmStaUnit'  => $paData['FTStmStaUnit'],

                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add TFNMInstallment Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit TFNMInstallment.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMAddUpdateLang($paData){
        try{
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTStmCode', $paData['FTStmCode']);
            $this->db->update('TFNMInstallment_L',array(
                'FTStmName' => $paData['FTStmName'],
                'FTStmRmk'  => $paData['FTStmRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update TFNMInstallment_L Success.',
                );
            }else{
                $this->db->insert('TFNMInstallment_L', array(
                    'FTAgnCode' => $paData['FTAgnCode'],
                    'FTStmCode' => $paData['FTStmCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTStmName' => $paData['FTStmName'],
                    'FTStmRmk'  => $paData['FTStmRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add TFNMInstallment_L Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit TFNMInstallment_L.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMDelAll($paData){
        try{
            $this->db->trans_begin();

            // $this->db->where_in('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where_in('FTStmCode', $paData['FTStmCode']);
            $this->db->delete('TFNMInstallment');

            // $this->db->where_in('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where_in('FTStmCode', $paData['FTStmCode']);
            $this->db->delete('TFNMInstallment_L');

            // $this->db->where_in('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where_in('FTStmCode', $paData['FTStmCode']);
            $this->db->delete('TFNMInstallmentSub');

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

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMSubList($paData){
        try{

            $nLngID         = $paData['nLngID'];
            $tAgnCode       = $paData['tAgnCode'];
            $tStmCode       = $paData['tStmCode'];
            $tCrdCode       = $paData['tCrdCode'];
            $tBnkCode       = $paData['tBnkCode'];

            $tSQL = "   SELECT DISTINCT
                            SUB.FTAgnCode,
                            SUB.FTStmCode,
                            SUB.FTCrdCode,
                            CRD_L.FTCrdName,
                            SUB.FTBnkCode,
                            BNK_L.FTBnkName
                        FROM TFNMInstallmentSub SUB WITH(NOLOCK)
                        LEFT JOIN TFNMCreditCard_L CRD_L WITH(NOLOCK) ON SUB.FTCrdCode = CRD_L.FTCrdCode AND CRD_L.FNLngID = $nLngID
                        LEFT JOIN TFNMBank_L BNK_L WITH(NOLOCK) ON SUB.FTBnkCode = BNK_L.FTBnkCode AND BNK_L.FNLngID = $nLngID
                        WHERE SUB.FTAgnCode = '$tAgnCode' AND SUB.FTStmCode = '$tStmCode'
                    ";

            $oQuery = $this->db->query($tSQL);
            if( $oQuery->num_rows() > 0 ){
                $aResult = array(
                    'raItems'       => $oQuery->result_array(),
                    'rtCode'        => '1',
                    'rtDesc'        => 'found data',
                );
            }else{
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMSubEventAdd($paPackData){
        $this->db->trans_begin();
        $this->db->insert_batch('TFNMInstallmentSub', $paPackData);
        if( $this->db->trans_status() === FALSE ){
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Can not Insert TFNMInstallmentSub',
            );
        }else{
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Insert TFNMInstallmentSub Success.',
            );
        }
        return $aStatus;
    }

    // Create By : Napat(Jame) 08/11/2021
    public function FSaMSTMSubEventDelete($paData){

        $this->db->trans_begin();
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where('FTStmCode', $paData['FTStmCode']);
        $this->db->where('FTCrdCode', $paData['FTCrdCode']);
        $this->db->delete('TFNMInstallmentSub');

        if( $this->db->trans_status() === FALSE ){
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Can not Delete TFNMInstallmentSub',
            );
        }else{
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete TFNMInstallmentSub Success.',
            );
        }
        return $aStatus;
    }

}
