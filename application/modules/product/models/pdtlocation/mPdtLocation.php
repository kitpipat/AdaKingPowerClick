<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtLocation extends CI_Model {

    //Functionality : List Product Location
    //Parameters : function parameters
    //Creator :  01/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMLOCList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSesAgnCode = $paData['tSesAgnCode'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtLocCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        LOC.FTPlcCode   AS rtLocCode,
                                        LOC_L.FTPlcName AS rtLocName,
                                        LOC.FDCreateOn
                                    FROM [TCNMPdtLoc] LOC
                                    LEFT JOIN [TCNMPdtLoc_L]  LOC_L ON LOC.FTPlcCode = LOC_L.FTPlcCode AND LOC_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (LOC.FTPlcCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR LOC_L.FTPlcName COLLATE THAI_BIN  LIKE '%$tSearchList%')";
            }

            if ($tSesAgnCode != '') {
                $tSQL .= " AND LOC.FTAgnCode = $tSesAgnCode";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMLOCGetPageAll($tSearchList,$nLngID,$tSesAgnCode);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => $aRowLen,
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow' => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"=> 0,
                    'rtCode' => '800',
                    'rtDesc' => $aRowLen,
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of Product Location
    //Parameters : function parameters
    //Creator :  01/02/2019 Napat(Jame)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMLOCGetPageAll($ptSearchList,$ptLngID,$ptSesAgnCode){
        try{
            $tSQL = "SELECT COUNT (LOC.FTPlcCode) AS counts
                     FROM [TCNMPdtLoc] LOC
                     LEFT JOIN [TCNMPdtLoc_L]  LOC_L ON LOC.FTPlcCode = LOC_L.FTPlcCode AND LOC_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (LOC.FTPlcCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR LOC_L.FTPlcName  LIKE '%$ptSearchList%')";
            }

            if ($ptSesAgnCode != '') {
                $tSQL .= " AND LOC.FTAgnCode = $ptSesAgnCode";
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

    //Functionality : All Page Of Product Location Seq
    //Parameters : function parameters
    //Creator :  11/02/2019 Napat(Jame)
    //Return : object Count All Product Model
    //Return Type : Object
    public function FSoMLOCSeqGetPageAll($ptSearchList,$ptPlcCode){
        try{
            $tSQL = "SELECT COUNT (PLS.FTBarCode) AS counts
                        FROM TCNTPdtLocSeq PLS
                        WHERE PLS.FTPlcCode = $ptPlcCode";
            // $tSQL = "SELECT COUNT (LOC.FTPlcCode) AS counts
            //          FROM [TCNMPdtLoc] LOC
            //          LEFT JOIN [TCNMPdtLoc_L]  LOC_L ON LOC.FTPlcCode = LOC_L.FTPlcCode AND LOC_L.FNLngID = $ptLngID
            //          WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PLS.FTBarCode LIKE '%$ptSearchList%')";
                // $tSQL .= " OR LOC_L.FTPlcName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Product Location By ID
    //Parameters : function parameters
    //Creator : 01/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMLOCGetDataByID($paData){
        try{
            $tPlcCode   = $paData['FTPlcCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = "SELECT 
                                LOC.FTPlcCode   AS rtPlcCode,
                                LOC_L.FTPlcName AS rtPlcName,
                                LOC_L.FTPlcRmk  AS rtPlcRmk,
                                LOC.FTAgnCode   AS rtAgnCode,
                                AGNL.FTAgnName  AS rtAgnName
                            FROM TCNMPdtLoc LOC
                            LEFT JOIN TCNMPdtLoc_L LOC_L ON LOC.FTPlcCode = LOC_L.FTPlcCode AND LOC_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMAgency_L AGNL ON  LOC.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID  = $nLngID
                            WHERE 1=1 AND LOC.FTPlcCode = '$tPlcCode' ";
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

    //Functionality : Get Data Location Seq By ID
    //Parameters : function parameters
    //Creator : 06/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMLOCGetDataLocSeqByID($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tPlcCode       = $paData['FTPlcCode'];
            $tSearchList    = $paData['tSearchAll'];
            $nLngID         = $paData['FNLngID'];
            $tSQL           = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtPldSeq ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                            PLS.FNPldSeq    AS rtPldSeq,
                                            PBR.FTPdtCode   AS rtPdtCode,
                                            PBR.FTBarCode   AS rtBarCode,
                                            PDT_L.FTPdtName AS rtPdtName,
                                            PUN_L.FTPunName AS rtPunName,
                                            PLC_L.FTPlcName AS rtPlcName,
                                            PLS.FTLastUpdBy AS rtLastUpdBy,
                                            PLS.FTPlcCode   AS rtPlcCode
                                    FROM TCNTPdtLocSeq PLS
                                    LEFT JOIN TCNMPdtLoc_L PLC_L ON PLS.FTPlcCode = PLC_L.FTPlcCode AND PLC_L.FNLngID = $nLngID
                                    LEFT JOIN TCNMPdtBar PBR ON PLS.FTBarCode = PBR.FTBarCode
                                    LEFT JOIN TCNMPdt_L PDT_L ON PBR.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $nLngID
                                    LEFT JOIN TCNMPdtUnit_L PUN_L ON PBR.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $nLngID
                                    WHERE PLS.FTPlcCode = '$tPlcCode'";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PLS.FTPlcCode LIKE '%$tSearchList%'";
                $tSQL .= " OR PLS.FTBarCode  LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            $oFoundRow = $this->FSoMLOCSeqGetPageAll($tSearchList,$tPlcCode);
            $nFoundRow = $oFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'       => $aDetail,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'Data not found.',
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Checkduplicate Product Location
    //Parameters : function parameters
    //Creator : 01/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSnMLOCCheckDuplicate($ptPlcCode){
        $tSQL = "SELECT COUNT(LOC.FTPlcCode) AS counts
                 FROM TCNMPdtLoc LOC 
                 WHERE LOC.FTPlcCode = '$ptPlcCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Checkduplicate Location Seq
    //Parameters : function parameters
    //Creator : 11/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSnMLOCSeqCheckDuplicate($paData){
        $FTPlcCode = $paData['rtPlcCode'];
        $FTBarCode = $paData['rtBarCode'];
        $tSQL = "SELECT COUNT(PLS.FTPlcCode) AS counts
                 FROM TCNTPdtLocSeq PLS
                 WHERE PLS.FTPlcCode = '$FTPlcCode' AND PLS.FTBarCode = '$FTBarCode'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product Product Location (TCNMPdtLoc)
    //Parameters : function parameters
    //Creator : 01/02/2019 Napat(Jame)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMLOCAddUpdateMaster($paDataPdtLocation){
        try{
            // Update TCNMPdtLoc
            $this->db->where('FTPlcCode', $paDataPdtLocation['FTPlcCode']);
            $this->db->update('TCNMPdtLoc',array(
                'FDLastUpdOn' => $paDataPdtLocation['FDLastUpdOn'], 
                'FTLastUpdBy'  => $paDataPdtLocation['FTLastUpdBy'],
                'FTAgnCode'     => $paDataPdtLocation['FTAgnCode'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Location Success',
                );
            }else{
                //Add TCNMPdtLoc
                $this->db->insert('TCNMPdtLoc', array(
                    'FTPlcCode'     => $paDataPdtLocation['FTPlcCode'],
                    'FDCreateOn'    => $paDataPdtLocation['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdtLocation['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataPdtLocation['FDLastUpdOn'], 
                    'FTLastUpdBy'   => $paDataPdtLocation['FTLastUpdBy'],
                    'FTZneChain'    => 1,
                    'FTPigCode'     => 1,
                    'FTAgnCode'     => $paDataPdtLocation['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Location Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Location',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Product Location (TCNMPdtLoc_L)
    //Parameters : function parameters
    //Creator : 01/02/2019 Napat(Jame)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMLOCAddUpdateLang($paDataPdtLocation){
        try{
            //Update Pdt Location Lang
            $this->db->where('FNLngID', $paDataPdtLocation['FNLngID']);
            $this->db->where('FTPlcCode', $paDataPdtLocation['FTPlcCode']);
            $this->db->update('TCNMPdtLoc_L',array(
                'FTPlcName' => $paDataPdtLocation['FTPlcName'],
                'FTPlcRmk'  => $paDataPdtLocation['FTPlcRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Location Lang Success.',
                );
            }else{
                //Add Pdt Location Lang
                $this->db->insert('TCNMPdtLoc_L', array(
                    'FTPlcCode' => $paDataPdtLocation['FTPlcCode'],
                    'FNLngID'   => $paDataPdtLocation['FNLngID'],
                    'FTPlcName' => $paDataPdtLocation['FTPlcName'],
                    'FTPlcRmk'  => $paDataPdtLocation['FTPlcRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Product Location Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Product Location Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete Product Size
    //Parameters : function parameters
    //Creator : 04/02/2019 Napat(Jame)
    //Return : Status Delete
    //Return Type : array
    public function FSaMLOCDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTPlcCode', $paData['FTPlcCode']);
            $this->db->delete('TCNMPdtLoc');

            $this->db->where_in('FTPlcCode', $paData['FTPlcCode']);
            $this->db->delete('TCNMPdtLoc_L');

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

    //Functionality : Get Data Product Group By ID
    //Parameters : function parameters
    //Creator : 06/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMLOCGetDataPdtGrpByID($paData){
        try{
            $FTPgpChain     = $paData['FTPgpCode'];
            $FTPlcCode      = $paData['FTPlcCode'];
            $FNPldSeq       = $paData['FNPldSeq'];
            $nLngID         = $paData['FNLngID'];
            $tSQL           = "	SELECT 
                                            PDT.FTPdtCode   AS rtPdtCode,
                                            PBR.FTBarCode   AS rtBarCode,
                                            PDT_L.FTPdtName AS rtPdtName,
                                            PUN_L.FTPunName AS rtPunName,
                                            PLC_L.FTPlcName   AS rtPlcName
                                FROM TCNMPdt PDT
                                LEFT JOIN TCNMPdt_L PDT_L ON PDT.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $nLngID
                                LEFT JOIN TCNMPdtBar PBR ON PDT.FTPdtCode = PBR.FTPdtCode
                                LEFT JOIN TCNMPdtUnit_L PUN_L ON PBR.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $nLngID
                                LEFT JOIN TCNTPdtLocSeq PLS ON PBR.FTBarCode = PLS.FTBarCode AND PLS.FTPlcCode = '$FTPlcCode'
                                LEFT JOIN TCNMPdtLoc_L PLC_L ON PLS.FTPlcCode = PLC_L.FTPlcCode AND PLC_L.FNLngID = $nLngID
                                WHERE PDT.FTPgpChain = '$FTPgpChain'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'FTPlcCode' => $FTPlcCode,
                    'FNPldSeq'  => $FNPldSeq,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success'
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

    //Functionality : Get Data Product Type By ID
    //Parameters : function parameters
    //Creator : 07/02/2019 Napat(Jame)
    //Return : data
    //Return Type : Array
    public function FSaMLOCGetDataPdtTypByID($paData){
        try{
            $FTPtyCode      = $paData['FTPtyCode'];
            $FTPlcCode      = $paData['FTPlcCode'];
            $FNPldSeq       = $paData['FNPldSeq'];
            $nLngID         = $paData['FNLngID'];
            $tSQL           = "SELECT 
                                                PDT.FTPdtCode   AS rtPdtCode,
                                                PBR.FTBarCode   AS rtBarCode,
                                                PDT_L.FTPdtName AS rtPdtName,
                                                PUN_L.FTPunName AS rtPunName,
                                                PLC_L.FTPlcName   AS rtPlcName
                                FROM TCNMPdtType PTY
                                LEFT JOIN TCNMPdt PDT ON PTY.FTPtyCode = PDT.FTPtyCode
                                LEFT JOIN TCNMPdt_L PDT_L ON PDT.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $nLngID
                                LEFT JOIN TCNMPdtBar PBR ON PDT.FTPdtCode = PBR.FTPdtCode
                                LEFT JOIN TCNMPdtUnit_L PUN_L ON PBR.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $nLngID
                                LEFT JOIN TCNTPdtLocSeq PLS ON PBR.FTBarCode = PLS.FTBarCode AND PLS.FTPlcCode = '$FTPlcCode'
                                LEFT JOIN TCNMPdtLoc_L PLC_L ON PLS.FTPlcCode = PLC_L.FTPlcCode AND PLC_L.FNLngID = $nLngID
                                WHERE PDT.FTPtyCode = '$FTPtyCode'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'FTPlcCode' => $FTPlcCode,
                    'FNPldSeq'  => $FNPldSeq,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success'
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

    //Functionality : Delect all data when data is temp
    //Parameters : FTPlcCode
    //Creator : 11/02/2019 Napat(Jame)
    //Return : -
    //Return Type : -
    public function FSaMLOCSeqDeleteDataAllByID($FTPlcCode){

        //Delete TCNTPdtLocSeq
        $this->db->where_in('FTPlcCode', $FTPlcCode);
        $this->db->delete('TCNTPdtLocSeq');
        
            
    }

    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPdtLoc";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    //Functionality : Edit Data Temp Location Seq
    //Parameters : function parameters
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Add Event
    //Return Type : array
    public function FSaMLOCEditDataLocSeq($paData){
        try{
            // Update TCNTPdtLocSeq
            $this->db->where('FTPlcCode', $paData['FTPlcCode']);
            $this->db->where('FTBarCode', $paData['FTBarCode']);
            $this->db->update('TCNTPdtLocSeq',array(
                'FNPldSeq'      => $paData['FNPldSeq'],
                'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                'FTLastUpdBy'   => $paData['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Location Seq Success',
                );
            }else{
               //Add TCNTPdtLocSeq
                $this->db->insert('TCNTPdtLocSeq', array(
                    'FTPlcCode'     => $paData['FTPlcCode'],
                    'FTBarCode'     => $paData['FTBarCode'],
                    'FNPldSeq'      => $paData['FNPldSeq'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTCreateBy'    => $paData['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Location Seq Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Location Seq',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Add Data Temp Location Seq
    //Parameters : function parameters
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Add Event
    //Return Type : array
    public function FSaMLOCLocSeqAddData($paData){

        $this->db->insert('TCNTPdtLocSeq', array(
            'FTPlcCode'     => $paData['rtPlcCode'],
            'FTBarCode'     => $paData['rtBarCode'],
            'FNPldSeq'      => $paData['rtPldSeq']
            // 'FDLastUpdOn'   => $paData['FDLastUpdOn'],
            // 'FDCreateOn'    => $paData['FDCreateOn'],
            // 'FTLastUpdBy'   => $paData['FTLastUpdBy'],
            // 'FTCreateBy'    => $paData['FTCreateBy']
        ));
        
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Location Seq Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Location Seq',
            );
        }
        
        return $aStatus;
    }

    //Functionality : Delete Location Seq
    //Parameters : function parameters
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Delete
    //Return Type : array
    public function FSaMLOCSeqDelAll($paData){
        try{
            $this->db->trans_begin();
            // $aWhere = array('FTPlcCode' => $paData['FTPlcCode'], 'FTBarCode' => $paData['FTBarCode']);
            // $this->db->where($aWhere);
            $this->db->where_in('FTPlcCode', $paData['FTPlcCode']);
            $this->db->where_in('FTBarCode', $paData['FTBarCode']);
            $this->db->delete('TCNTPdtLocSeq');

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