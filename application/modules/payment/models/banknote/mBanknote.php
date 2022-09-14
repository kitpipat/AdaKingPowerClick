<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBanknote extends CI_Model {

    //Functionality : list Banknote
    //Parameters : function parameters
    //Creator :  30/01/2019 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSaMBNTList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSesAgnCode   = $paData['tSesAgnCode'];

            $tSQL           =   "   SELECT c.* FROM(
                                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtBntCode ASC) AS rtRowID,* FROM (
                                            SELECT DISTINCT
                                                IMG.FTImgObj        AS rtBntImage,
                                                BNT.FTBntCode       AS rtBntCode,
                                                BNT.FCBntRateAmt    AS rtBntAmt,
                                                BNT_L.FTBntName     AS rtBntName,
                                                BNT_L.FTBntRmk      AS rtBntRmk,
                                                BNT.FDCreateOn,
                                                BNT.FTAgnCode AS rtAgnCode,
                                                AGNL.FTAgnName   AS rtAgnName
                                            FROM [TFNMBankNote]         BNT     WITH(NOLOCK)
                                            LEFT JOIN [TFNMBankNote_L]  BNT_L   WITH(NOLOCK) ON BNT.FTBntCode   = BNT_L.FTBntCode AND BNT_L.FNLngID = $nLngID       
                                            LEFT JOIN TCNMImgObj        IMG     WITH(NOLOCK) ON IMG.FTImgRefID  = BNT.FTBntCode AND IMG.FTImgTable  = 'TFNMBankNote' AND IMG.FNImgSeq = 1
                                            LEFT JOIN [TCNMAgency_L]  AGNL WITH(NOLOCK) ON BNT.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                                            WHERE 1=1
                                ";

            if($tSesAgnCode != ''){
                $tSQL .= " AND BNT.FTAgnCode = $tSesAgnCode";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL   .= " AND (BNT.FTBntCode LIKE '%$tSearchList%'";
                $tSQL   .= " OR BNT_L.FTBntName  LIKE '%$tSearchList%')";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMBNTGetPageAll($tSearchList,$nLngID,$tSesAgnCode);
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

    //Functionality : All Page Of Banknote
    //Parameters : function parameters
    //Creator :  30/01/2019 Witsarut 
    //Return : object Count All Banknote
    //Return Type : Object
    public function FSoMBNTGetPageAll($ptSearchList,$ptLngID,$tSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (Bnt.FTBntCode) AS counts
                     FROM [TFNMBankNote] BNT
                     LEFT JOIN [TFNMBankNote_L]  BNT_L ON Bnt.FTBntCode = BNT_L.FTBntCode AND BNT_L.FNLngID = $ptLngID
                     LEFT JOIN [TCNMAgency_L]  AGNL WITH(NOLOCK) ON BNT.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $ptLngID
                     WHERE 1=1 ";

            if($tSesAgnCode != ''){
                $tSQL .= " AND BNT.FTAgnCode = $tSesAgnCode";
            }

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (Bnt.FTBntCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR BNT_L.FTBntName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Banknote By ID
    //Parameters : function parameters
    //Creator : 30/01/2019 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSaMBNTGetDataByID($paData){
        try{
            $tBntCode   = $paData['FTBntCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                IMG.FTImgObj   AS rtBntImage,
                                BNT.FTBntCode   AS rtBntCode,
                                BNT.FCBntRateAmt AS rtBntAmt,
                                BNT.FTBntStaShw AS rtBntStaShw,
                                BNT_L.FTBntName AS rtBntName,
                                BNT_L.FTBntRmk   AS rtBntRmk,
                                BNT.FTAgnCode AS rtAgnCode,
                                AGNL.FTAgnName   AS rtAgnName
                            FROM TFNMBankNote Bnt
                            LEFT JOIN TFNMBankNote_L BNT_L ON BNT.FTBntCode = BNT_L.FTBntCode AND BNT_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMImgObj IMG ON IMG.FTImgRefID = BNT.FTBntCode AND IMG.FTImgTable = 'TFNMBankNote'
                            LEFT JOIN [TCNMAgency_L]  AGNL WITH(NOLOCK) ON BNT.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1=1 AND Bnt.FTBntCode = '$tBntCode' ";
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

    //Functionality : Checkduplicate Banknote
    //Parameters : function parameters
    //Creator : 30/01/2019 Witsarut 
    //Return : data
    //Return Type : Array
    public function FSnMBNTCheckDuplicate($ptBntCode){
        $tSQL = "SELECT COUNT(BNT.FTBntCode) AS counts
                 FROM TFNMBankNote BNT
                 WHERE BNT.FTBntCode = '$ptBntCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Banknote (TFNMBankNote)
    //Parameters : function parameters
    //Creator : 30/01/2019 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMBNTAddUpdateMaster($paDataBnt){
        try{
            // Update TFNMBankNote
            $this->db->where('FTBntCode', $paDataBnt['FTBntCode']);
            $this->db->update('TFNMBankNote',array(
                'FTRteCode'     => $paDataBnt['FTRteCode'],
                'FTBntCode'     => $paDataBnt['FTBntCode'],
                'FTBntStaShw'   => $paDataBnt['FTBntStaShw'],
                'FCBntRateAmt'  => $paDataBnt['FCBntRateAmt'],
                'FDLastUpdOn'   => $paDataBnt['FDLastUpdOn'], 
                'FTLastUpdBy'   => $paDataBnt['FTLastUpdBy'],
                'FTAgnCode'     => $paDataBnt['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Type Success',
                );
            }else{
                //Add TFNMBankNote
                $this->db->insert('TFNMBankNote', array(
                    'FTRteCode'     => $paDataBnt['FTRteCode'],
                    'FTBntCode'     => $paDataBnt['FTBntCode'],
                    'FTBntStaShw'   => $paDataBnt['FTBntStaShw'],
                    'FCBntRateAmt'  => $paDataBnt['FCBntRateAmt'],
                    'FDLastUpdOn'   => $paDataBnt['FDLastUpdOn'],
                    'FDCreateOn'    => $paDataBnt['FDCreateOn'],
                    'FTCreateBy'    => $paDataBnt['FTCreateBy'],
                    'FTAgnCode'     => $paDataBnt['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Banknote Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Banknote.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Banknote (TFNMBankNote_L)
    //Parameters : function parameters
    //Creator : 30/01/2019 Witsarut 
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMBNTAddUpdateLang($paDataBnt){
        try{
            //Update Banknote Lang
            $this->db->where('FNLngID', $paDataBnt['FNLngID']);
            $this->db->where('FTBntCode', $paDataBnt['FTBntCode']);
            $this->db->update('TFNMBankNote_L',array(
                'FTRteCode' => $paDataBnt['FTRteCode'],
                'FTBntName' => $paDataBnt['FTBntName'],
                'FTBntRmk'  => $paDataBnt['FTBntRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Banknote Lang Success.',
                );
            }else{
                //Add Banknote Lang
                $this->db->insert('TFNMBankNote_L', array(
                    'FTRteCode' => $paDataBnt['FTRteCode'],
                    'FTBntCode' => $paDataBnt['FTBntCode'],
                    'FNLngID'   => $paDataBnt['FNLngID'],
                    'FTBntName' => $paDataBnt['FTBntName'],
                    'FTBntRmk'  => $paDataBnt['FTBntRmk']
                   
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Banknote Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Banknote Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Banknote
    //Parameters : function parameters
    //Creator : 30/01/2019 Witsarut 
    //Return : Status Delete
    //Return Type : array
    public function FSaMBNTDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTBntCode', $paData['FTBntCode']);
            $this->db->delete('TFNMBankNote');

            $this->db->where_in('FTBntCode', $paData['FTBntCode']);
            $this->db->delete('TFNMBankNote_L');

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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMBankNote";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    /**
     * Functionality : Check Code is Duplicate
     * Parameters : Code
     * Creator : 11/06/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Boolean
     */
    public function FSbMCheckDuplicate($ptCode = '')
    {
        $tSQL = "   
            SELECT 
                FTBntCode
            FROM TFNMBankNote
            WHERE FTBntCode = '$ptCode'
        ";

        $bStatus = false;
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }


    /**
     * Functionality : Check Chk Sta Show limit 
     * Parameters : -
     * Creator : 28/10/2020 nale
     * Last Modified : -
     * Return : array
     * Return Type : array
     */
    public function FSnMChkStaShw(){

           $nQtyBntStaShw = $this->db->where('FTBntStaShw','1')->get('TFNMBankNote')->num_rows();
           return $nQtyBntStaShw;
    }


    public function FSaMUpdateStaShw($paDataBnt){

    
        $this->db->where('FTRteCode', $paDataBnt['FTRteCode']);
        $this->db->where('FTBntCode', $paDataBnt['FTBntCode']);
        $this->db->update('TFNMBankNote',array(
            'FTBntStaShw'  => $paDataBnt['FTBntStaShw'],
            'FTLastUpdBy'  => $paDataBnt['FTLastUpdBy'],
            'FDLastUpdOn'  => $paDataBnt['FDLastUpdOn']
        ));
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Banknote Success.',
            );
            }else{
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Banknote UnSuccess.',
            );
            }
            return $aStatus;
    }

}