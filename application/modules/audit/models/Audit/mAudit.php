<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAudit extends CI_Model {
  //Functionality : ข้อมูล Map Company
  //Parameters : function parameters
  //Creator :  18/03/2021 Mos
  //Return : data
  //Return Type : object//
  public function FSoMAUDGetData($paData)
  {
    try {
      $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
      $tSesUsrAgnCode = $this->session->userdata('tSesUsrAgnCode');
      $tSearchList = $paData['tSearchAll'];
      $nLngID = $paData['FNLngID'];
      $tSql = "SELECT c.*
      FROM
      (
      SELECT
       ROW_NUMBER() OVER(ORDER BY M1.FTAgnFrm DESC) AS rtRowID,
       M1.FTAgnFrm,
       M1.FTAgnNameFrm,
       M2.FTAgnTo,
       M2.FTAgnNameTo
      FROM
      (
          SELECT M.FTAgnFrm,
                 M.FTAgnTo,
                 A.FTAgnName AS FTAgnNameFrm
          FROM TCNTMapping M
               LEFT JOIN TCNMAgency_L A ON M.FTAgnFrm = A.FTAgnCode

                                           AND A.FNLngID = $nLngID
      	WHERE M.FTMapTable = 'TCNMAgency'
      ) M1
      INNER JOIN
      (
          SELECT M.FTAgnFrm,
                 M.FTAgnTo,
                 A.FTAgnName AS FTAgnNameTo
          FROM TCNTMapping M
               LEFT JOIN TCNMAgency_L A ON M.FTAgnTo = A.FTAgnCode

                                           AND A.FNLngID = $nLngID
      	WHERE M.FTMapTable = 'TCNMAgency'
      ) M2 ON M1.FTAgnFrm = M2.FTAgnFrm
              AND M1.FTAgnTo = M2.FTAgnTo";

      if ($tSearchList != '') {
        $tSql.=" AND ( M1.FTAgnFrm COLLATE THAI_BIN LIKE '%$tSearchList%'
          OR M1.FTAgnNameFrm COLLATE THAI_BIN LIKE '%$tSearchList%'
          OR M2.FTAgnTo COLLATE THAI_BIN LIKE '%$tSearchList%'
          OR M2.FTAgnNameTo COLLATE THAI_BIN LIKE '%$tSearchList%' )";
      }
      //กรณี User AD ให้ WHERE ADCode
      //WHERE M1.FTAgnFrm = '00001'
      if ($this->session->userdata('tSesUsrLevel') != "HQ") {
        $tSql.=" WHERE M1.FTAgnFrm = '$tSesUsrAgnCode'";
      }
      $tSql .= ")  As c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

      $oQuery = $this->db->query($tSql);
      if($oQuery->num_rows() > 0){
          $aList = $oQuery->result_array();
          $oFoundRow = $this->FSoMAUDGetPageAll($tSearchList,$nLngID);
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
    } catch (Exception $Error) {
            return $Error;
    }
  }

    //Functionality : ข้อมูล Map Company
    //Parameters : function parameters
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : object
  public function FSaMAUDGetDataEdit($ptSearchList)
  {
    try {
      $tSesUsrAgnCode = $this->session->userdata('tSesUsrAgnCode');
      $tSql = "SELECT
       M1.FTAgnFrm,
       M1.FTAgnNameFrm,
       M2.FTAgnTo,
       M2.FTAgnNameTo,
  	   M1.FTAgnRefCode,
       M1.FTBchCode
      FROM
      (
        SELECT M.FTAgnFrm,
         M.FTAgnTo,
         A.FTAgnName AS FTAgnNameFrm,
         AGN.FTAgnRefCode,
         AGN.FTBchCode
      FROM TCNTMapping M
           LEFT JOIN TCNMAgency AGN ON AGN.FTAgnCode = M.FTAgnFrm
           LEFT JOIN TCNMAgency_L A ON A.FTAgnCode = AGN.FTAgnCode
        WHERE M.FTMapTable = 'TCNMAgency'
      ) M1
      INNER JOIN
      (
          SELECT M.FTAgnFrm,
                 M.FTAgnTo,
                 A.FTAgnName AS FTAgnNameTo
          FROM TCNTMapping M
              LEFT JOIN TCNMAgency AGN ON AGN.FTAgnCode = M.FTAgnTo
              LEFT JOIN TCNMAgency_L A ON A.FTAgnCode = AGN.FTAgnCode
        WHERE M.FTMapTable = 'TCNMAgency'
      ) M2 ON M1.FTAgnFrm = M2.FTAgnFrm
              AND M1.FTAgnTo = M2.FTAgnTo";

      $tSql.=" AND ( M1.FTAgnFrm COLLATE THAI_BIN LIKE '%$ptSearchList%')";
      $oQuery = $this->db->query($tSql);
      if($oQuery->num_rows() > 0){
          $aResult = $oQuery->result_array();
      }else{
          $aResult = array();
      }
      return $aResult;
    } catch (Exception $Error) {
      return $Error;
    }
  }

  //Functionality : ข้อมูล Map Company
  //Parameters : function parameters
  //Creator :  18/03/2021 Mos
  //Return : data
  //Return Type : array
  public function FSaMAUDGetDataSteting($ptSearchList)
  {
    try {
      $nLngID = $this->session->userdata("tLangID");
      $tSql = "SELECT A.FTAgnCode AS FTAgnFrm,
                       B.FTAgnName AS FTAgnNameFrm,
                       null AS FTAgnTo,
                       null AS FTAgnNameTo,
                       A.FTAgnRefCode
                FROM TCNMAgency A
                     LEFT JOIN TCNMAgency_L B ON A.FTAgnCode = B.FTAgnCode
                WHERE A.FTAgnCode = '$ptSearchList'
                      AND B.FNLngID = $nLngID ";
      $oQuery = $this->db->query($tSql);
      if($oQuery->num_rows() > 0){
          $aResult = $oQuery->result_array();
      }else{
          $aResult = array();
      }
      return $aResult;
    } catch (Exception $Error) {
      return $Error;
    }
  }

  //Functionality : ข้อมูล Map Company
  //Parameters : function parameters
  //Creator :  18/03/2021 Mos
  //Return : data
  //Return Type : object
  public function FSoMAUDGetPageAll($ptSearchList,$ptLngID)
  {
    $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");
    try{
        $tSql = "SELECT count(M1.FTAgnFrm) as counts
        FROM
        (
            SELECT M.FTAgnFrm,
                   M.FTAgnTo,
                   A.FTAgnName AS FTAgnNameFrm
            FROM TCNTMapping M
                 LEFT JOIN TCNMAgency_L A ON M.FTAgnFrm = A.FTAgnCode

                                             AND A.FNLngID = $ptLngID
          WHERE M.FTMapTable = 'TCNMAgency'
        ) M1
        INNER JOIN
        (
            SELECT M.FTAgnFrm,
                   M.FTAgnTo,
                   A.FTAgnName AS FTAgnNameTo
            FROM TCNTMapping M
                 LEFT JOIN TCNMAgency_L A ON M.FTAgnTo = A.FTAgnCode

                                             AND A.FNLngID = $ptLngID
          WHERE M.FTMapTable = 'TCNMAgency'
        ) M2 ON M1.FTAgnFrm = M2.FTAgnFrm
                AND M1.FTAgnTo = M2.FTAgnTo";
        if ($ptSearchList != '') {
          $tSql.=" AND ( M1.FTAgnFrm COLLATE THAI_BIN LIKE '%$ptSearchList%'
            OR M1.FTAgnNameFrm COLLATE THAI_BIN LIKE '%$ptSearchList%'
            OR M2.FTAgnTo COLLATE THAI_BIN LIKE '%$ptSearchList%'
            OR M2.FTAgnNameTo COLLATE THAI_BIN LIKE '%$ptSearchList%' )";
        }
        //กรณี User AD ให้ WHERE ADCode
        //WHERE M1.FTAgnFrm = '00001'
        if ($this->session->userdata('tSesUsrLevel') != "HQ") {
          $tSql.=" WHERE M1.FTAgnFrm = '$tAgnCode'";
        }
        $oQuery = $this->db->query($tSql);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }catch(Exception $Error){
        echo $Error;
    }
  }

  //Functionality : ข้อมูล ซ้ำ
  //Parameters : function parameters
  //Creator :  18/03/2021 Mos
  //Return : data
  //Return Type : number
  public function FSnMAUDCheckDuplicate($paDataCompany)
  {
    $tCode = $paDataCompany['FTAgnFrm'];
    $tSQL = "SELECT COUNT(FTAgnFrm) AS counts
             FROM TCNTMapping
             WHERE FTAgnFrm = '$tCode'";
    $oQuery = $this->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        return $oQuery->result();
    }else{
        return false;
    }
  }

  public function FSoMAUDGetBchCode($ptAgnCode)
  {
    $tSQL = "SELECT FTBchCode from TCNMAgency WHERE FTAgnCode ='$ptAgnCode'";
    $oQuery = $this->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        return $oQuery->result();
    }else{
        return false;
    }
  }


  //Functionality : ข้อมูล หัวข้อการโอนข้อมูล
  //Parameters : function parameters
  //Creator :  18/03/2021 Mos
  //Return : data
  //Return Type : array
  public function FSaMAUDAddUpdateMaster($paData)
  {
    try{
        $this->db->set('FTAgnTo', $paData['FTAgnTo']);
        $this->db->set('FTMapCodeFrm', $paData['FTMapCodeFrm']);
        $this->db->set('FTMapCodeTo', $paData['FTMapCodeTo']);
        $this->db->where('FTAgnFrm', $paData['FTAgnFrm']);
        $this->db->where('FTMapTable', 'TCNMAgency');
        $this->db->update('TCNTMapping');
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => 'update',
                'rtDesc' => 'Update Master Success',
                'rtFTAgnFrm' => $paData['FTAgnFrm'],
                'rtFTAgnTo' => $paData['FTAgnTo'],
            );
        }else{
            $this->db->insert('TCNTMapping',array(
                'FTAgnFrm'   => $paData['FTAgnFrm'],
                'FTAgnTo' => $paData['FTAgnTo'],
                'FTMapTable' => $paData['FTMapTable'],
                'FTMapCodeFrm'  => $paData['FTMapCodeFrm'],
                'FTMapCodeTo'  => $paData['FTMapCodeTo']
            ));

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => 'Add',
                    'rtFTAgnFrm' => $paData['FTAgnFrm'],
                    'rtFTAgnTo' => $paData['FTAgnTo'],
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
  //Functionality : ข้อมูลการโอนมาสเตอร์
  //Parameters : function parameters
  //Creator :  18/03/2021 Mos
  //Return : data
  //Return Type : object
  public function FSoMAUDTranferMaster($paAgnCode)
  {
    $tSQL = "SELECT SM.FTSynTable,
                     SML.FTSynName,
                     HIS.FDSynLast
              FROM TCNSSyncMaster SM WITH(NOLOCK)
                   LEFT JOIN TCNSSyncMaster_L SML ON SM.FTSynTable = SML.FTSynTable
                                                     AND SML.FNLngID = 1
                   LEFT JOIN TCNTSyncMasHis  HIS WITH(NOLOCK) ON SM.FTSynTable = HIS.FTSynTable
                                                   AND HIS.FTSynPrc = 'AUDIT'
              									 --ส่ง Parameter ADCode มาแทนค่า
                                                   AND HIS.FTAgnCode = '$paAgnCode'
              WHERE SM.FTSynPrc = 'AUDIT'
                    AND SM.FTSynStaUse = 1";
    $oQuery = $this->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        return $oQuery->result();
    }else{
        return false;
    }
  }

  public function FSoMAUDGetListDoc($paDataShearch)
  {
    $tDocDateStart = $paDataShearch['tDocDateA']." 00:00:59";
    $tDocDateEnd = $paDataShearch['tDocDateB']." 23:59:59";
    $tAUDDocType = $paDataShearch['tAUDDocType'];
    $ptLangID = $paDataShearch['tLangID'];
    $tBchF = $paDataShearch['tBchF'];
    $tSQL = "SELECT
    TPSTSalHD.FDXshDocDate,
    TPSTSalHD.FTXshDocNo,
    TPSTSalHD.FCXshTotal,
    TPSTSalHD.FTXshDocVatFull,
    TPSTSalHD.FNXshDocType,
    Bch_L.FTBchName,
    Bch.FTBchCode
    FROM TPSTSalHD
    INNER JOIN TCNMBranch Bch ON Bch.FTBchCode = TPSTSalHD.FTBchCode
    LEFT JOIN TCNMBranch_L Bch_L ON Bch_L.FTBchCode = Bch.FTBchCode
         AND Bch_L.FNLngID = '$ptLangID'
    WHERE TPSTSalHD.FNXshDocType ='$tAUDDocType' AND Bch.FTBchCode='$tBchF'
    AND TPSTSalHD.FDXshDocDate BETWEEN '$tDocDateStart' AND '$tDocDateEnd'";

    $oQuery = $this->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        return $oQuery->result();
    }else{
        return false;
    }
  }

  public function FSaMAUDGetDataBch($paAgnCode,$ptLangID)
  {
    $tSQL = "SELECT
    Bch_L.FTBchName,
    Bch.FTBchCode
    FROM TCNMBranch Bch
    LEFT JOIN TCNMBranch_L Bch_L ON Bch_L.FTBchCode = Bch.FTBchCode
                                      AND Bch_L.FNLngID = '$ptLangID'
    WHERE Bch.FTAgnCode = '$paAgnCode'";
    $oQuery = $this->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        return $oQuery->result_array();
    }else{
        return false;
    }
  }
  
  public function FSaMAUDDel($paData){
      try{
          $this->db->trans_begin();
          $this->db->where('FTAgnFrm', $paData['FTAgnFrm']);
          $this->db->where('FTAgnTo', $paData['FTAgnTo']);
          $this->db->where('FTMapTable', 'TCNMAgency');
          $this->db->delete('TCNTMapping');
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
?>
