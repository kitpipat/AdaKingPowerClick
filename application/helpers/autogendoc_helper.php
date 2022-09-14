<?php

  function FCNaHAUTGenDocNo($paParam){

    $ci = &get_instance();
    $ci->load->database();

    $aDocumentNumber = FCNaHAUTExecuteDocNo($paParam);
    $tDocumentNumber = $aDocumentNumber[0]['FTXxhDocNo'];
    $tTable   = $paParam['tTblName'];
    $tBchCode = $paParam['tBchCode'];
    $tShpCode = $paParam['tShpCode'];
    $nDocType = $paParam['tDocType'];

    if($nDocType == 0){ //ข้อมูลมาสเตอร์ 
      return $aDocumentNumber;
    }else{ //ข้อมูลเอกสาร

      //หาว่าฟิวส์ของเอกสาร PK คืออะไร
      $tSQL     = " SELECT TOP 1 A.FTSatFedCode FROM TCNTAuto A WHERE A.FTSatTblName = '$tTable' AND A.FTSatStaDocType = '$nDocType' ";
      $oQuery   = $ci->db->query($tSQL);
      $aResult  = $oQuery->result_array();
      $tFieldPK = $aResult[0]['FTSatFedCode'];

      $tSQLCheck   = " SELECT B.FTSatFedCode FROM $tTable A LEFT JOIN TCNTAuto B ON B.FTSatTblName = '$tTable'
                       WHERE A.FTBchCode = '$tBchCode' AND A.$tFieldPK = '$tDocumentNumber' AND B.FTSatStaDocType = '$nDocType' ";
      if($tShpCode != '' || $tShpCode != null){ //ถ้ามีร้านค้า
        $tSQLCheck  .= " AND A.FTShpCode = '$tShpCode' ";
      }
      $oQueryCheck = $ci->db->query($tSQLCheck);
      if ($oQueryCheck->num_rows() > 0){ //เจอข้อมูลซ้ำ
        return FCNaHAUTExecuteDocNo($paParam);
      }else{
        return $aDocumentNumber;
      }
    }
  }

  function FCNaHAUTExecuteDocNo($paParam){

    $ci = &get_instance();
    $ci->load->database();

    $tSP = "SP_CNtAUTAutoDocNo ?,?,?,?,?,?,?"; 

    $aSPParams = array(
      'ptTblName' => $paParam['tTblName'],
      'ptDocType' => $paParam['tDocType'],
      'ptBchCode' => $paParam['tBchCode'],
      'ptShpCode' => $paParam['tShpCode'],
      'ptPosCode' => $paParam['tPosCode'],
      'pdDocDate' => $paParam['dDocDate'],
      'ptResult' => ''
    );
    $oQuery = $ci->db->query($tSP,$aSPParams);

    return $oQuery->result_array();
  }
?>
