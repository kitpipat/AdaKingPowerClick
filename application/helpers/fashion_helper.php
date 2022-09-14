<?php
    // Create By: Napat(Jame) 13/05/2021
    function FCNxClearDTFhnTmp($paDataPdtParams){
        $ci = &get_instance();
        $ci->load->database();
        
        $tSesSessionID = $_SESSION['tSesSessionID'];
        $tSQL   =   "   DELETE FROM TCNTDocDTFhnTmp
                        WHERE 1=1 
                        AND FTXshDocNo      = '" . $paDataPdtParams['tDocNo'] . "'
                        AND FTBchCode       = '" . $paDataPdtParams['tBchCode'] . "'
                        AND FTXthDocKey     = '" . $paDataPdtParams['tDocKey'] . "'
                        AND FTSessionID     = '" . $tSesSessionID . "'
                        AND FTPdtCode       = '" . $paDataPdtParams["tPdtCode"] . "'
        ";
        $ci->db->query($tSQL);
    }

    // Create By: Napat(Jame) 13/05/2021
    function FCNnGetMaxSeqDTFhnTmp($paDataWhere){
        $ci = &get_instance();
        $ci->load->database();
        
        $tBchCode         = $paDataWhere['tBchCode'];
        $tDocNo           = $paDataWhere['tDocNo'];
        $tDocKey          = $paDataWhere['tDocKey'];
        $tPdtCode         = $paDataWhere['tPdtCode'];
        $tBarCode         = $paDataWhere['tBarCode'];
        $tPunCode         = $paDataWhere['tPunCode'];
        $tSesSessionID    = $_SESSION['tSesSessionID'];
        $tSQL   =   "   SELECT MAX(DOCTMP.FNXtdSeqNo) AS nMaxSeqNo
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTBchCode       = '$tBchCode'";
        $tSQL   .= " AND DOCTMP.FTXthDocNo      = '$tDocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey     = '$tDocKey'";
        $tSQL   .= " AND DOCTMP.FTPdtCode       = '$tPdtCode'";
        $tSQL   .= " AND ISNULL(DOCTMP.FTXtdBarCode,'')    = '$tBarCode'";
        $tSQL   .= " AND DOCTMP.FTPunCode       = '$tPunCode'";
        $tSQL   .= " AND DOCTMP.FTSessionID     = '$tSesSessionID'";
        $oQuery = $ci->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail    = $oQuery->row_array();
            $nResult    = $aDetail['nMaxSeqNo'];
        } else {
            $nResult    = 0;
        }
        return empty($nResult) ? 0 : $nResult;
    }

    // Create By: Napat(Jame) 13/05/2021
    function FCNaInsertPDTFhnToTemp($paDataPdtParams){
        $ci = &get_instance();
        $ci->load->database();

        // นำสินค้าเพิ่มจำนวนในแถวแรก
        $tSQL   =   "   SELECT
                            FNXsdSeqNo, 
                            FCXtdQty
                        FROM TCNTDocDTFhnTmp WITH(NOLOCK)
                        WHERE 1=1 
                        AND FTBchCode       = '" . $paDataPdtParams['tBchCode'] . "'
                        AND FTXshDocNo      = '" . $paDataPdtParams['tDocNo'] . "'
                        AND FTXthDocKey     = '" . $paDataPdtParams['tDocKey'] . "'
                        AND FTSessionID     = '" . $paDataPdtParams['tSessionID'] . "'
                        AND FTPdtCode       = '" . $paDataPdtParams["tPdtCode"] . "'
                        AND FTFhnRefCode    = '" . $paDataPdtParams["tRefCode"] . "'
                        AND FNXsdSeqNo      = '" . $paDataPdtParams["nMaxSeqNo"] . "'
                        ORDER BY FNXsdSeqNo";
        $oQuery = $ci->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            // เพิ่มจำนวนให้รายการที่มีอยู่แล้ว
            $aResult    = $oQuery->row_array();
            $tSQL       =   "   UPDATE TCNTDocDTFhnTmp WITH(ROWLOCK)
                                SET FCXtdQty = '" . ($paDataPdtParams["nQty"]) . "' 
                                WHERE 1=1
                                AND FTBchCode       = '" . $paDataPdtParams['tBchCode'] . "'
                                AND FTXshDocNo      = '" . $paDataPdtParams['tDocNo'] . "'
                                AND FTXthDocKey     = '" . $paDataPdtParams['tDocKey'] . "'
                                AND FTSessionID     = '" . $paDataPdtParams['tSessionID'] . "'
                                AND FTPdtCode       = '" . $paDataPdtParams["tPdtCode"] . "'
                                AND FTFhnRefCode    = '" . $paDataPdtParams["tRefCode"] . "' 
                                AND FNXsdSeqNo      = '" . $paDataPdtParams["nMaxSeqNo"] . "' ";
            $ci->db->query($tSQL);
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Update Success.',
            );
        } else {
            // เพิ่มรายการใหม่
            $aDataInsert    = array(
                'FTBchCode'         => $paDataPdtParams['tBchCode'],
                'FTXshDocNo'        => $paDataPdtParams['tDocNo'],
                'FNXsdSeqNo'        => $paDataPdtParams['nMaxSeqNo'],
                'FTXthDocKey'       => $paDataPdtParams['tDocKey'],
                'FTPdtCode'         => $paDataPdtParams['tPdtCode'],
                'FTXtdPdtName'      => '',
                'FCXtdQty'          => $paDataPdtParams['nQty'],
                'FTFhnRefCode'      => $paDataPdtParams['tRefCode'],
                'FTSessionID'       => $paDataPdtParams['tSessionID'],
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $_SESSION['tSesUsername']
            );
            $ci->db->insert('TCNTDocDTFhnTmp', $aDataInsert);
            if ($ci->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            } else {
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
        }
        return $aStatus;
    }

    // Create By: Napat(Jame) 13/05/2021
    function FCNtGetBarCodePdtFhn($ptDataPdtFhn){
        $ci = &get_instance();
        $ci->load->database();

        $tPdtCode       = $ptDataPdtFhn['FTPdtCode']; 
        $tFhnRefCode    = $ptDataPdtFhn['FTFhnRefCode'];
        $tBarCodeQuery  = $ci->db->where('FTPdtCode',$tPdtCode)->where('FTFhnRefCode',$tFhnRefCode)->order_by('FDCreateOn','ASC')->limit(1)->get('TCNMPdtBar');
        if( $tBarCodeQuery->num_rows() > 0 ){
            $tBarCode = $tBarCodeQuery->row_array()['FTBarCode'];
        }else{
            $tBarCode = '';
        }
        return $tBarCode;
    }

    // Create By: Napat(Jame) 13/05/2021
    function FCNxDeletePDTInTmp($paDataPdtParams){
        $ci = &get_instance();
        $ci->load->database();

        $tSQL   =   "   DELETE FROM TCNTDocDTTmp WITH(ROWLOCK)
                        WHERE 1=1 
                        AND FTXthDocNo      = '" . $paDataPdtParams['tDocNo'] . "'
                        AND FTBchCode       = '" . $paDataPdtParams['tBchCode'] . "'
                        AND FTXthDocKey     = '" . $paDataPdtParams['tDocKey'] . "'
                        AND FTSessionID     = '" . $paDataPdtParams['tSessionID'] . "'
                        AND FTPdtCode       = '" . $paDataPdtParams["tPdtCode"] . "'
                        AND FNXtdSeqNo      = (
                                              SELECT TOP 1 FNXtdSeqNo FROM TCNTDocDTTmp  
                                                WHERE  1= 1 
                                                AND FTXthDocNo      = '" . $paDataPdtParams['tDocNo'] . "'
                                                AND FTBchCode       = '" . $paDataPdtParams['tBchCode'] . "'
                                                AND FTXthDocKey     = '" . $paDataPdtParams['tDocKey'] . "'
                                                AND FTSessionID     = '" . $paDataPdtParams['tSessionID'] . "'
                                                AND FTPdtCode       = '" . $paDataPdtParams["tPdtCode"] . "' 
                                                ORDER BY FNXtdSeqNo DESC
                        )
                    ";
          
        $ci->db->query($tSQL);

        FCNxFHNCallDTQtyOnDtFhn($paDataPdtParams);

    }

    function FCNxFHNCallDTQtyOnDtFhn($paDataPdtParams){
        $ci = &get_instance();
        $ci->load->database();
            $tSQL = "UPDATE DT SET
                     DT.FCXtdQty = DTFHN.FCXtdQty ,
                     DT.FCAjdQtyAll = (DTFHN.FCXtdQty * DT.FCXtdFactor)
                    FROM
                        TCNTDocDTTmp DT
                    LEFT JOIN (
                        SELECT
                            FTSessionID,
                            FTXthDocKey,
                            FTXshDocNo,
                            FNXsdSeqNo,
                            SUM (FCXtdQty) AS FCXtdQty
                        FROM
                            TCNTDocDTFhnTmp
                        WHERE
                            FTSessionID = '" . $paDataPdtParams['tSessionID'] . "'
                        AND FTXthDocKey = '" . $paDataPdtParams['tDocKey'] . "'
                        AND FTXshDocNo = '" . $paDataPdtParams['tDocNo'] . "'
                        AND FTBchCode = '" . $paDataPdtParams['tBchCode'] . "'
                        GROUP BY
                            FTSessionID,
                            FTXthDocKey,
                            FTXshDocNo,
                            FNXsdSeqNo
                    ) DTFHN ON DT.FTSessionID = DTFHN.FTSessionID
                    AND DT.FTXthDocKey = DTFHN.FTXthDocKey
                    AND DT.FTXthDocNo = DTFHN.FTXshDocNo
                    AND DT.FNXtdSeqNo = DTFHN.FNXsdSeqNo
                    WHERE
                        DT.FTSessionID = '" . $paDataPdtParams['tSessionID'] . "'
                    AND DT.FTXthDocKey = '" . $paDataPdtParams['tDocKey'] . "'
                    AND DT.FTXthDocNo = '" . $paDataPdtParams['tDocNo'] . "' 
                    AND DT.FTBchCode = '" . $paDataPdtParams['tBchCode'] . "' 
                    ";
            
            $ci->db->query($tSQL);
            

    }

    // Create By: Napat(Jame) 13/05/2021
    function FCNaUpdateInlineDTTmp($paDataUpdateDT){
        $ci = &get_instance();
        $ci->load->database();
        
            $tSQL = "  UPDATE TCNTDocDTTmp
                        SET FCXtdQty = ( SELECT
                                SUM (DTFHN.FCXtdQty) AS rnQTY
                                FROM TCNTDocDTFhnTmp DTFHN WITH(NOLOCK) 
                                WHERE DTFHN.FTSessionID = '".$paDataUpdateDT['tSessionID']."'
                                AND DTFHN.FTXshDocNo = '".$paDataUpdateDT['tDocNo']."'
                                AND DTFHN.FTXthDocKey = '".$paDataUpdateDT['tDocKey']."'
                                AND DTFHN.FNXsdSeqNo = '".$paDataUpdateDT['nXtdSeq']."' ) ,
                         FCAjdQtyAll =  (( SELECT
                                SUM (DTFHN.FCXtdQty) AS rnQTY
                                FROM TCNTDocDTFhnTmp DTFHN WITH(NOLOCK) 
                                WHERE DTFHN.FTSessionID = '".$paDataUpdateDT['tSessionID']."'
                                AND DTFHN.FTXshDocNo = '".$paDataUpdateDT['tDocNo']."'
                                AND DTFHN.FTXthDocKey = '".$paDataUpdateDT['tDocKey']."'
                                AND DTFHN.FNXsdSeqNo = '".$paDataUpdateDT['nXtdSeq']."' ) *  FCXtdFactor  ) 

                        WHERE TCNTDocDTTmp.FTSessionID = '".$paDataUpdateDT['tSessionID']."'
                                AND TCNTDocDTTmp.FTXthDocNo = '".$paDataUpdateDT['tDocNo']."'
                                AND TCNTDocDTTmp.FTXthDocKey = '".$paDataUpdateDT['tDocKey']."'
                                AND TCNTDocDTTmp.FNXtdSeqNo = '".$paDataUpdateDT['nXtdSeq']."'
                        ";
            $ci->db->query($tSQL);

        // $ci->db->where('')
        // $ci->db->set('FCXtdQty', $paDataUpdateDT['tValue']);
        // $ci->db->where('FTSessionID', $paDataUpdateDT['tSessionID']);
        // $ci->db->where('FTXthDocKey', $paDataUpdateDT['tDocKey']);
        // $ci->db->where('FNXtdSeqNo', $paDataUpdateDT['nXtdSeq']);
        // $ci->db->where('FTXthDocNo', $paDataUpdateDT['tDocNo']);
        // $ci->db->update('TCNTDocDTTmp');

        if ( $ci->db->affected_rows() > 0 ) {
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Update Success',
            );
        } else {
            $aStatus = array(
                'rtCode'    => '903',
                'rtDesc'    => 'Update Fail',
            );
        }
        return $aStatus;
    }

    // Create By: Napat(Jame) 14/05/2021
    function FCNxMoveDTTmpToDTFhn($paDataWhere, $paTableAddUpdate){
        $ci = &get_instance();
        $ci->load->database();

        $tBchCode     = $paDataWhere['FTBchCode'];
        $tDocNo       = $paDataWhere['FTXthDocNo'];
        $tDocKey      = $paTableAddUpdate['tTableHD'];
        $tSessionID   = $_SESSION['tSesSessionID'];

        if (isset($tDocNo) && !empty($tDocNo)) {
            $ci->db->where('FTXthDocNo', $tDocNo);
            $ci->db->delete($paTableAddUpdate['tTableDTFhn']);
        }

        $tSQL   = " INSERT INTO " . $paTableAddUpdate['tTableDTFhn'] . " ( FTBchCode , FTXthDocNo , FNXtdSeqNo , FTPdtCode , FTFhnRefCode , FCXtdQty ) ";
        $tSQL  .= " SELECT
                        DOCTMP.FTBchCode,
                        DOCTMP.FTXshDocNo,
                        DOCTMP.FNXsdSeqNo,
                        DOCTMP.FTPdtCode,
                        DOCTMP.FTFhnRefCode,
                        DOCTMP.FCXtdQty
                    FROM TCNTDocDTFhnTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1
                    AND DOCTMP.FTBchCode    = '$tBchCode'
                    AND DOCTMP.FTXshDocNo   = '$tDocNo'
                    AND DOCTMP.FTXthDocKey  = '$tDocKey'
                    AND DOCTMP.FTSessionID  = '$tSessionID'
                    ORDER BY DOCTMP.FNXsdSeqNo ASC ";
        $ci->db->query($tSQL);
    }

    // Create By: Napat(Jame) 17/05/2021
    function FCNxMoveDTToDTFhnTemp($paDataWhere){
        $ci = &get_instance();
        $ci->load->database();

        $tDocNo         = $paDataWhere['FTXthDocNo'];
        $tDocKey        = $paDataWhere['FTXthDocKey'];
        $tSessionID     = $_SESSION['tSesSessionID'];
        $tTableDTFhn    = $paDataWhere['tTableDTFhn'];

        $ci->db->where('FTSessionID', $tSessionID);
        $ci->db->where('FTXshDocNo', $tDocNo);
        $ci->db->delete('TCNTDocDTFhnTmp');

        $tSQL   = " INSERT INTO TCNTDocDTFhnTmp ( FTBchCode, FTXshDocNo, FNXsdSeqNo , FTXthDocKey , FTPdtCode, FTFhnRefCode , FCXtdQty ,FTSessionID )
                    SELECT DT.FTBchCode, DT.FTXthDocNo, DT.FNXtdSeqNo, '$tDocKey' AS FTXthDocKey, DT.FTPdtCode, DT.FTFhnRefCode,
                           DT.FCXtdQty,'$tSessionID' AS FTSessionID 
                    FROM $tTableDTFhn DT WITH (NOLOCK)
                    WHERE 1=1 
                        AND DT.FTXthDocNo = '$tDocNo'
                    ORDER BY DT.FNXtdSeqNo ASC ";
        $ci->db->query($tSQL);
    }
