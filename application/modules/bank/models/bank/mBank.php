<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBank extends CI_Model {

    //Functionality : list Bank
    //Parameters : function parameters
    //Creator :  20/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMBNKList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");

            $tSQL       = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY rtCreateOn DESC, rtBnkCode DESC) AS rtRowID,* FROM
                    (SELECT DISTINCT
                            IMG.FTImgObj    AS rtBnkImage,
                            BNK.FTBnkCode   AS rtBnkCode,
                            BNK.FDCreateOn  AS rtCreateOn,
                            BNK_L.FTBnkName AS rtBnkName,
                            BNK_L.FTBnkRmk  AS rtBnkRmk,
                            BNK.FTAgnCode       AS rtAgnCode,
                            TRC.FTBnkCode   AS rtBnkCodeLef
                    FROM [TFNMBank] BNK WITH(NOLOCK)
                    LEFT JOIN [TFNMBank_L]  BNK_L ON BNK.FTBnkCode = BNK_L.FTBnkCode AND BNK_L.FNLngID = ".$this->db->escape($nLngID)."
                    LEFT JOIN TCNMImgObj IMG WITH(NOLOCK) ON IMG.FTImgRefID  = BNK.FTBnkCode AND IMG.FTImgTable  = 'TFNMBank'
                    AND IMG.FNImgSeq = 1
                    LEFT JOIN (SELECT DISTINCT FTBnkCode FROM TPSTSalRC WITH(NOLOCK) ) TRC ON TRC.FTBnkCode  = BNK.FTBnkCode
                    WHERE 1=1 ";

                if($tAgnCode != ''){
                    $tSQL .= "AND ( BNK.FTAgnCode = '$tAgnCode' OR ISNULL(BNK.FTAgnCode,'') = '' )";
                }

                if(isset($tSearchList) && !empty($tSearchList)){
                    $tSQL .= " AND (BNK.FTBnkCode COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($tSearchList)."%'";
                    $tSQL .= " OR BNK_L.FTBnkName  COLLATE THAI_BIN LIKE '%".$this->db->escape_like_str($tSearchList)."%')";
                }
                $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

                $oQuery = $this->db->query($tSQL);

                    if($oQuery->num_rows() > 0){
                        $aList = $oQuery->result_array();
                        $oFoundRow = $this->FSoBNKGetPageAll($tSearchList,$nLngID);
                        $nFoundRow = $oFoundRow[0]->counts;
                        $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                        $aResult = array(
                            'raItems'       => $aList,
                            'rnAllRow'      => $nFoundRow,
                            'rnCurrentPage' => $paData['nPage'],
                            'rnAllPage'     => $nPageAll,
                            'rtCode'        => '1',
                            'rtDesc'        => 'success'
                        );
                    }else{
                        //No Data
                        $aResult = array(
                            'rnAllRow' => 0,
                            'rnCurrentPage' => $paData['nPage'],
                            "rnAllPage"=> 0,
                            'rtCode' => '800',
                            'rtDesc' => 'data not found'
                        );
                    }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : Get Data Bank By ID
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : data
    //Return Type : Array
    public function FSaMBnkGetDataByID($paData){
        try{

            $tBnkCode    = $paData['tBnkCode'];
            $nLngID      = $paData['nLangEdit'];

            $tSQL = "SELECT
                IMG.FTImgObj   AS rtBnkImage,
                BNK.FTBnkCode   AS rtBnkCode,
                BNKL.FTBnkName  AS rtBnkName,
                BNKL.FTBnkRmk   AS rtBnkRmk,
                BNK.FTAgnCode        AS rtAgnCode,
                AGN_L.FTAgnName      AS rtAgnName
                -- BNK.FTBnkRefExt     AS rtBnkRefIn
            FROM [TFNMBank] BNK
            LEFT JOIN TCNMAgency_L AGN_L ON BNK.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
            LEFT JOIN [TFNMBank_L] BNKL ON BNK.FTBnkCode = BNKL.FTBnkCode AND BNKL.FNLngID = $nLngID
            LEFT JOIN TCNMImgObj IMG ON IMG.FTImgRefID = BNK.FTBnkCode AND IMG.FTImgTable = 'TFNMBank'
            WHERE 1=1 ";
            $tSQL .= " AND BNK.FTBnkCode = '$tBnkCode' ";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
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

    public function FSaMBNKGetStmSeq($ptData)
    {
      try{
              $tSQL = "SELECT *
              FROM [TFNMBnkInstallment]  WHERE FTBnkCode='$ptData' ORDER BY FNStmSeq DESC";
              $oQuery = $this->db->query($tSQL);
              if($oQuery->num_rows() > 0){
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
    public function FSaMBnkGetDataEditInfo2ByID($ptData)
    {
      try{
              $nStmSeq = $ptData['nStmSeq'];
              $tBnkCode = $ptData['tBnkCode'];
              $tSQL = "SELECT *
              FROM [TFNMBnkInstallment]  WHERE FTBnkCode='$tBnkCode' AND FNStmSeq='$nStmSeq' ORDER BY FNStmSeq DESC";
              $oQuery = $this->db->query($tSQL);
              if($oQuery->num_rows() > 0){
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
    public function FSaMBnkGetDataInfo2ByID($paData){
        try{

                $tBnkCode    =  $paData['tBnkCode'];
                $nLngID      = $paData['nLangEdit'];
                $tSQL = "SELECT *
                FROM [TFNMBnkInstallment]  WHERE FTBnkCode='$tBnkCode'";
                $oQuery = $this->db->query($tSQL);
                if($oQuery->num_rows() > 0){
                    $aDetail = $oQuery->result_array();
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

    //Functionality : All Page Of Bank
    //Parameters : function parameters
    //Creator :  20/09/2018 Witsarut (Bell)
    //Return : object Count All Bank
    //Return Type : Object
    public function FSoBNKGetPageAll($ptSearchList,$ptLngID){
        $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");
        try{
            $tSQL = "SELECT COUNT (BNK.FTBnkCode) AS counts
                     FROM [TFNMBank] BNK
                     LEFT JOIN [TFNMBank_L]  BNK_L ON BNK.FTBnkCode = BNK_L.FTBnkCode AND BNK_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (BNK.FTBnkCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR BNK_L.FTBnkName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
            }
            if($tAgnCode != ''){
                $tSQL .= "AND ( BNK.FTAgnCode = '$tAgnCode' OR ISNULL(BNK.FTAgnCode,'') = '' )";
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

    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 15/05/2018 wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMBNKCheckDuplicate($ptBnkCode){

        $tSQL = "SELECT COUNT(FTBnkCode)   AS counts
                 FROM TFNMBank
                 WHERE FTBnkCode = '$ptBnkCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 04/06/2021 mos
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMBNKInfo2CheckDuplicate($ptBnkCode,$ptStmName,$pnStmSeq){
        $tSQL = "SELECT COUNT(FTBnkCode)   AS counts
                 FROM TFNMBnkInstallment
                 WHERE FTBnkCode = '$ptBnkCode' AND FTStmName='$ptStmName' AND FNStmSeq !='$pnStmSeq'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Update Bank
    //Parameters : function parameters
    //Creator : 02/07/2018 Witsarut
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMBNKAddUpdateMaster($paData){
        try{
            $this->db->set('FTBnkCode', $paData['FTBnkCode']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTAgnCode', $paData['FTAgnCode']);
            // $this->db->set('FTBnkRefExt', $paData['FTBnkRefExt']);
            $this->db->where('FTBnkCode', $paData['tBnkCodeOld']);
            $this->db->update('TFNMBank');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                $this->db->insert('TFNMBank',array(
                    'FTBnkCode'   => $paData['FTBnkCode'],
                    'FDLastUpdOn' => $paData['FDLastUpdOn'],
                    'FTLastUpdBy' => $paData['FTLastUpdBy'],
                    'FDCreateOn'  => $paData['FDCreateOn'],
                    'FTCreateBy'  => $paData['FTCreateBy'],
                    'FTAgnCode'   => $paData['FTAgnCode'],
                    // 'FTBnkRefExt' => $paData['FTBnkRefExt']
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
            echo $Error;
        }
    }

    public function FSaMBNKInfo2AddUpdateMaster($paData){
        try{
            $this->db->set('FTStmName', $paData['FTStmName']);
            $this->db->set('FCStmLimit', $paData['FCStmLimit']);
            $this->db->set('FCStmQty', $paData['FCStmQty']);
            $this->db->set('FTStmStaUnit', $paData['FTStmStaUnit']);
            $this->db->set('FCStmRate', $paData['FCStmRate']);
            $this->db->where('FTBnkCode', $paData['FTBnkCode']);
            $this->db->where('FNStmSeq', $paData['FNStmSeq']);
            $this->db->update('TFNMBnkInstallment');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                $this->db->insert('TFNMBnkInstallment',array(
                    'FTBnkCode'         => $paData['FTBnkCode'],
                    'FNStmSeq'          => $paData['FNStmSeq'],
                    'FTStmName'         => $paData['FTStmName'],
                    'FCStmLimit'        => $paData['FCStmLimit'],
                    'FCStmQty'          => $paData['FCStmQty'],
                    'FTStmStaUnit'      => $paData['FTStmStaUnit'],
                    'FCStmRate'         => $paData['FCStmRate'],
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
            echo $Error;
        }
    }

    //Functionality : Update Lang Bank
    //Parameters : function parameters
    //Creator : 02/07/2018 Witsarut(Bel)
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSaMBNKAddUpdateLang($paData){

        try{
            $this->db->set('FTBnkCode', $paData['FTBnkCode']);
            $this->db->set('FTBnkName', $paData['FTBnkName']);
            $this->db->set('FTBnkRmk', $paData['FTBnkRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTBnkCode', $paData['tBnkCodeOld']);
            $this->db->update('TFNMBank_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                $this->db->insert('TFNMBank_L',array(
                    'FTBnkCode' => $paData['FTBnkCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTBnkName' => $paData['FTBnkName'],
                    'FTBnkRmk' => $paData['FTBnkRmk'],
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
            echo $Error;
        }
    }

    //Functionality : Delete Bank
    //Parameters : function parameters
    //Creator : 20/09/2018 Witsarut(Bell)
    //Return : Status Delete
    //Return Type : array
    public function FSaMBNKDelAll($paData){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTBnkCode', $paData['FTBnkCode']);
            $this->db->delete('TFNMBank');

            $this->db->where_in('FTBnkCode', $paData['FTBnkCode']);
            $this->db->delete('TFNMBank_L');

            $this->db->where_in('FTImgRefID', $paData['FTBnkCode']);
            $this->db->delete('TCNMImgObj');

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


    public function FSaMBNKDelAllInfo2($paData){
        try{
            $this->db->trans_begin();
            $this->db->where('FNStmSeq', $paData['FNStmSeq']);
            $this->db->where('FTBnkCode', $paData['FTBnkCode']);
            $this->db->delete('TFNMBnkInstallment');

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

    //Functionality : Event Delete Bank
    //Parameters : Ajax jReason()
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSnMBNKGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMBank";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;

    }

    // Edit image
    public function FSaMBNKAddImgObj($paData){
        $this->db->set('FTImgRefID', $paData['FTBnkCode']);
        $this->db->where('FTImgRefID', $paData['tBnkCodeOld']);
        $this->db->update('TCNMImgObj');
    }

    //อัพเดทแม่ ต้องไปอัพเดทตารางลูกด้วย (เงื่อนไขการผ่อน)
    public function FSaMBNKUpdateInstallment($paData){
        $tCodeold = $paData['tBnkCodeOld'];
        $tCodenew = $paData['FTBnkCode'];

        $this->db->set('FTBnkCode', $tCodenew);
        $this->db->where('FTBnkCode', $tCodeold);
        $this->db->update('TFNMBnkInstallment');
    }



}
