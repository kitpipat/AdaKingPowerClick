<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSettingconfig extends CI_Model {
    
    //Get App Type เอาไปไว้ใน Option
    // Last Update : 13/08/2020 Napat(Jame)
    public function FSaMSETGetAppTpye(){
        // $tSQL   = "SELECT DISTINCT FTSysApp from TSysConfig";
        $nLngID = $this->session->userdata("tLangEdit");
        $tSQL = "   SELECT 
                        APP.FTAppCode,
                        APPL.FTAppName
                    FROM TsysApp APP WITH(NOLOCK)
                    INNER JOIN TSysApp_L APPL WITH(NOLOCK) ON APP.FTAppCode = APPL.FTAppCode AND APPL.FNLngID = $nLngID
                    WHERE FTAppVersion = '5'
                ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บตั้งค่าระบบ

    //Load Datatable Type Checkbox
    // Last Update : 13/08/2020 Napat(Jame)
    public function FSaMSETConfigDataTableByType($paData,$ptType){
        $nLngID     = $paData['FNLngID'];
        $tAgnCode   = $paData['FTAgnCode'];
        
        $tWhereTCNTConfigSpc = "";
        if( $paData['tTypePage'] == "Agency" ){
            $tWhereTCNTConfigSpc .= " AND CSPC.FTAgnCode = '$tAgnCode' ";
        }

        $tSQL   = " SELECT 
                        COM.FTSysCode , 
                        COM.FTSysApp ,
                        COM.FTSysKey ,
                        COM.FTSysSeq ,
                        COM.FTGmnCode ,
                        COM.FTSysStaAlwEdit , 
                        COM.FTSysStaDataType , 
                        COM.FNSysMaxLength , 
                        COM.FTSysStaDefValue , 
                        COM.FTSysStaDefRef ,
                        CASE
                            WHEN ISNULL(CSPC.FTCfgStaUsrValue,'') != '' THEN CSPC.FTCfgStaUsrValue 
                            ELSE COM.FTSysStaUsrValue
                        END AS FTSysStaUsrValue , 
                        CASE
                            WHEN ISNULL(CSPC.FTCfgStaUsrRef,'') != '' THEN CSPC.FTCfgStaUsrRef 
                            ELSE COM.FTSysStaUsrRef
                        END AS FTSysStaUsrRef ,
                        COL.FTSysName ,
                        COL.FTSysDesc ,
                        APPL.FTAppName
                    FROM [TSysConfig] COM WITH(NOLOCK)
                    LEFT JOIN [TSysConfig_L]    COL  WITH(NOLOCK) ON COM.FTSysCode = COL.FTSysCode  AND COM.FTSysSeq = COL.FTSysSeq AND COL.FNLngID = $nLngID
                    INNER JOIN TsysApp_L        APPL WITH(NOLOCK) ON COM.FTSysApp = APPL.FTAppCode  AND APPL.FNLngID = $nLngID
                    LEFT JOIN TCNTConfigSpc     CSPC WITH(NOLOCK) ON COM.FTSysCode = CSPC.FTSysCode AND COM.FTSysSeq = CSPC.FTSysSeq 
                                                                 AND COM.FTSysApp = CSPC.FTSysApp   AND COM.FTSysKey = CSPC.FTSysKey
                                                                 AND COM.FTSysStaDataType = CSPC.FTSysStaDataType
                                                                 $tWhereTCNTConfigSpc
                    WHERE 1=1 
                    AND COM.FTSysStaAlwEdit = '1'
                ";
               
        if($ptType == 'checkbox'){
            $tSQL   .= " AND COM.FTSysStaDataType = '4' ";
        }else{
            $tSQL   .= " AND COM.FTSysStaDataType != '4' ";
        }
        
        $tSearchList    = trim($paData['tSearchAll']);
        $tAppType       = $paData['tAppType'];
        if($tAppType != "0"){
            $tConcatSQL     = " AND COM.FTSysApp = '$tAppType' ";
        }else{
            $tConcatSQL     = "";
        }
        
        // switch ($tAppType) {
        //     case "API":
        //         $tConcatSQL = "AND COM.FTSysApp = 'API'";
        //         break;
        //     case "DOC":
        //         $tConcatSQL = "AND COM.FTSysApp = 'DOC'";
        //         break;
        //     case "POS":
        //         $tConcatSQL = "AND COM.FTSysApp = 'POS'";
        //         break;
        //     case "SL":
        //         $tConcatSQL = "AND COM.FTSysApp = 'SL'";
        //         break;
        //     case "WEB":
        //         $tConcatSQL = "AND COM.FTSysApp = 'WEB'";
        //         break;
        //     case "VD":
        //         $tConcatSQL = "AND COM.FTSysApp = 'VD'";
        //         break;
        //     case "ALL":
        //         $tConcatSQL = "AND COM.FTSysApp = 'ALL'";
        //         break;
        //     case "MQ":
        //         $tConcatSQL = "AND COM.FTSysApp = 'MQ'";
        //         break;
        //     default:
        //         $tConcatSQL = "";
        // }

        $tSQL .= " $tConcatSQL ";
        if($tSearchList != ''){
            $tSQL .= " AND (COL.FTSysName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR COL.FTSysName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR COL.FTSysDesc COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }
        $tSQL   .= " ORDER BY COM.FTSysApp , COM.FTSysSeq DESC";

        // echo $tSQL."<br>";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Update
    public function FSaMSETUpdate($paData){
        try{

            if($paData['tKind'] == 'Make'){ //แก้ไขประเภทกำหนดเอง
                $tMakeOrRef_Agn = 'FTCfgStaUsrValue';
                $tMakeOrRef     = 'FTSysStaUsrValue';
            }else if($paData['tKind'] == 'Ref'){ //แก้ไขประเภทอ้างอิง
                $tMakeOrRef_Agn = 'FTCfgStaUsrRef';
                $tMakeOrRef     = 'FTSysStaUsrRef';
            }

            if( $paData['tTypePage'] == "Agency" ){

                // ตรวจสอบ config ที่ระบุตรงกับ center หรือไม่ ?
                // $tSQL = "   SELECT TOP 1 FTSysCode
                //             FROM TSysConfig WITH(NOLOCK) 
                //             WHERE 1=1
                //                 AND FTSysCode           = '$paData[FTSysCode]'
                //                 AND FTSysApp            = '$paData[FTSysApp]'
                //                 AND FTSysKey            = '$paData[FTSysKey]'
                //                 AND FTSysSeq            = '$paData[FTSysSeq]'
                //                 AND FTSysStaDataType    = '$paData[FTSysStaDataType]'
                //                 AND $tMakeOrRef         = '$paData[nValue]'
                //         ";
                // $oQuery = $this->db->query($tSQL);
                // if( $oQuery->num_rows() > 0 ){
                //     // ถ้า Value เท่ากับ Center ให้ไปลบใน TCNTConfigSpc
                //     $this->db->where('FTSysCode', $paData['FTSysCode']);
                //     $this->db->where('FTSysApp', $paData['FTSysApp']);
                //     $this->db->where('FTSysKey', $paData['FTSysKey']);
                //     $this->db->where('FTAgnCode', $paData['FTAgnCode']);
                //     $this->db->where('FTSysSeq', $paData['FTSysSeq']);
                //     $this->db->where('FTSysStaDataType', $paData['FTSysStaDataType']);
                //     $this->db->delete('TCNTConfigSpc');
                //     if( $this->db->affected_rows() > 0 ){
                //         $aStatus = array(
                //             'rtCode' => '1',
                //             'rtDesc' => 'Delete TCNTConfigSpc Success.',
                //         );
                //     }else{
                //         $aStatus = array(
                //             'rtCode' => '800',
                //             'rtDesc' => 'Fail Delete TCNTConfigSpc.',
                //         );
                //     }
                // }else{ 
                    // ถ้า Value ไม่ตรงกับ Center ในเพิ่ม/อัพเดท ใน TCNTConfigSpc
                    $this->db->set($tMakeOrRef_Agn , $paData['nValue']); 
                    $this->db->where('FTSysCode', $paData['FTSysCode']);
                    $this->db->where('FTSysApp', $paData['FTSysApp']);
                    $this->db->where('FTSysKey', $paData['FTSysKey']);
                    $this->db->where('FTAgnCode', $paData['FTAgnCode']);
                    $this->db->where('FTSysSeq', $paData['FTSysSeq']);
                    $this->db->where('FTSysStaDataType', $paData['FTSysStaDataType']);
                    $this->db->update('TCNTConfigSpc');
                    if( $this->db->affected_rows() > 0 ){
                        // อัพเดทสำเร็จ
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Update TCNTConfigSpc Success.',
                        );
                    }else{
                        // ไม่พบข้อมูลอัพเดท ให้เพิ่มรายการใหม่
                        $aInsTSysConfig_L = array(
                            'FTSysCode'         => $paData['FTSysCode'],
                            'FTSysApp'          => $paData['FTSysApp'],
                            'FTSysKey'          => $paData['FTSysKey'],
                            'FTSysSeq'          => $paData['FTSysSeq'],
                            'FTAgnCode'         => $paData['FTAgnCode'],
                            'FTCfgStaUsrValue'  => ($paData['tKind'] == 'Make' ? $paData['nValue'] : ''),
                            'FTCfgStaUsrRef'    => ($paData['tKind'] == 'Ref' ? $paData['nValue'] : ''),
                            'FTSysStaDataType'  => $paData['FTSysStaDataType']
                        );
                        $this->db->insert('TCNTConfigSpc', $aInsTSysConfig_L);
                        if($this->db->affected_rows() > 0 ){
                            $aStatus = array(
                                'rtCode' => '1',
                                'rtDesc' => 'Insert Success.',
                            );
                        }else{
                            $aStatus = array(
                                'rtCode' => '800',
                                'rtDesc' => 'Fail Insert Success.',
                            );
                        }
                    }
                // }
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

                $this->db->where('FTSysCode', $paData['FTSysCode']);
                $this->db->where('FTSysApp', $paData['FTSysApp']);
                $this->db->where('FTSysKey', $paData['FTSysKey']);
                $this->db->where('FTSysSeq', $paData['FTSysSeq']);
                $this->db->where('FTSysStaDataType', $paData['FTSysStaDataType']);
                $this->db->update('TSysConfig');

            }else{

                $this->db->set($tMakeOrRef , $paData['nValue']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

                $this->db->where('FTSysCode', $paData['FTSysCode']);
                $this->db->where('FTSysApp', $paData['FTSysApp']);
                $this->db->where('FTSysKey', $paData['FTSysKey']);
                $this->db->where('FTSysSeq', $paData['FTSysSeq']);
                $this->db->where('FTSysStaDataType', $paData['FTSysStaDataType']);
                $this->db->update('TSysConfig');

                if($this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '800',
                        'rtDesc' => 'Fail Update Success.',
                    );
                }
            }

            
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Update ค่าเริ่มต้น
    public function FSaMSETUseValueDefult(){
        $tSQL   = "UPDATE SETHD
                    SET 
                        SETHD.FTSysStaUsrValue = SETDT.FTSysStaDefValue,
                        SETHD.FTSysStaUsrRef = SETDT.FTSysStaDefRef
                    FROM TSysConfig SETHD
                    LEFT JOIN TSysConfig SETDT 
                    ON 
                        SETHD.FTSysApp = SETDT.FTSysApp 
                        AND SETHD.FTSysKey = SETDT.FTSysKey 
                        AND SETHD.FTSysSeq = SETDT.FTSysSeq 
                        AND SETHD.FTGmnCode = SETDT.FTGmnCode 
                        AND SETHD.FTSysStaDataType = SETDT.FTSysStaDataType";
        $oQuery = $this->db->query($tSQL);
        if($this->db->affected_rows() > 0){
            $aResult    = array(
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บรหัสอัตโนมัติ

    public function FSaMSETConfigDataTableAutoNumber($paData){
        $nLngID     = $paData['FNLngID'];
        $tAgnCode   = $paData['tAgnCode']; 

        $tSQL       = "SELECT 
                        AO.FTSatTblName,
                        AO.FTSatStaDocType,
                        AO.FNSatMaxFedSize,
                        AO.FTSatDefFmtAll AS DefFmt,
                        AO.FTSatStaReset AS DefResetFmt,
                        TXN.FTAhmFmtAll AS UsrFmt,
                        TXN.FTAhmFmtReset AS UsrResetFmt,
                        AOL.FTSatTblDesc
                FROM [TCNTAuto] AO
                LEFT JOIN [TCNTAuto_L] AOL ON AO.FTSatTblName = AOL.FTSatTblName AND AO.FTSatFedCode = AOL.FTSatFedCode AND AO.FTSatStaDocType = AOL.FTSatStaDocType";

        if($tAgnCode == '' || $tAgnCode == null){
            $tSQL .= " LEFT JOIN [TCNTAutoHisTxn] TXN ON AO.FTSatTblName = TXN.FTAhmTblName AND AO.FTSatFedCode = TXN.FTAhmFedCode AND AO.FTSatStaDocType = TXN.FTSatStaDocType";
            $tSQL .= " AND ( ISNULL(TXN.FTAgnCode, '') = '' ) ";
        }else{
            $tSQL .= " LEFT JOIN [TCNTAutoHisTxn] TXN ON AO.FTSatTblName = TXN.FTAhmTblName AND AO.FTSatFedCode = TXN.FTAhmFedCode AND AO.FTSatStaDocType = TXN.FTSatStaDocType";
            $tSQL .= " AND ( TXN.FTAgnCode = '$tAgnCode' ) ";
        }

        $tSQL .= " AND AOL.FNLngID = $nLngID WHERE 1=1 ";
        $tSearchList = trim($paData['tSearchAll']);
        if($tSearchList != ''){
            $tSQL .= " AND (AO.FTSatTblName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AOL.FTSatTblDesc COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR TXN.FTAhmFmtAll COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR TXN.FTAhmFmtAll COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AO.FTSatTblName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AO.FTSatDefChar COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AO.FTSatStaDocType COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //อนุญาติให้จัดรูปแบบจากอะไรบ้างข้อมูล DT
    public function FSaMSETConfigGetAllowDataAutoNumber($paData){
        $tTable     = $paData['FTSatTblName'];
        $tType      = $paData['FTSatStaDocType'];
        $tAgnCode   = $paData['tAgnCode']; 

        $tSQL   = "SELECT 
                       AO.FTSatStaAlwChr ,
                       AO.FTSatStaAlwBch , 
                       AO.FTSatStaAlwPosShp , 
                       AO.FTSatStaAlwYear , 
                       AO.FTSatStaAlwMonth ,
                       AO.FTSatStaAlwDay , 
                       AO.FTSatStaAlwSep ,
                       AO.FNSatMinRunning ,
                       AO.FTSatDefFmtAll ,
                       AO.FTSatStaDefUsage,
                       AOL.FTSatTblDesc ,
                       AO.FNSatMaxFedSize ,
                       AO.FTSatDefChar,
                       AO.FTSatTblName,
                       AO.FTSatFedCode,
                       AO.FTSatStaDocType,
                       AO.FTSatDefNum,
                       TXN.FTAhmFmtAll AS FormatCustom,
                       TXN.FTAhmFmtPst,
                       TXN.FTAhmFmtChar,
                       TXN.FTAhmFmtReset,
                       TXN.FTSatStaAlwSep,
                       TXN.FTAhmFmtYear,
                       TXN.FNAhmFedSize,
                       TXN.FNAhmNumSize,
                       TXN.FTSatUsrNum
                FROM [TCNTAuto] AO
                LEFT JOIN [TCNTAuto_L] AOL ON AO.FTSatTblName = AOL.FTSatTblName AND AO.FTSatFedCode = AOL.FTSatFedCode AND AO.FTSatStaDocType = AOL.FTSatStaDocType 
                LEFT JOIN [TCNTAutoHisTxn] TXN ON AO.FTSatTblName = TXN.FTAhmTblName AND AO.FTSatFedCode = TXN.FTAhmFedCode AND AO.FTSatStaDocType = TXN.FTSatStaDocType ";

        if($tAgnCode == '' || $tAgnCode == null){
            $tSQL .= " AND ( ISNULL(TXN.FTAgnCode, '') = '' ) ";
        }else{
            $tSQL .= " AND ( TXN.FTAgnCode = '$tAgnCode' ) ";
        }

        $tSQL .= "WHERE 1=1 AND AO.FTSatTblName = '$tTable' AND AO.FTSatStaDocType = '$tType'";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาความยาวของสาขา และ เครื่องจุดขาย
    public function FSaMSETGetMaxLength($ptTable){
        $tSQL   = "SELECT 
                       AO.FNSatMaxFedSize
                    FROM [TCNTAuto] AO
                    WHERE 1=1 AND AO.FTSatTblName = '$ptTable' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //เลือกใช้ค่า ดีฟอล จำเป็นต้องลบ , ลบก่อน insert
    public function FSaMSETAutoNumberDelete($paData){
        $this->db->where_in('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where_in('FTAhmTblName', $paData['FTAhmTblName']);
        $this->db->where_in('FTAhmFedCode', $paData['FTAhmFedCode']);
        $this->db->where_in('FTSatStaDocType', $paData['FTSatStaDocType']);
        $this->db->delete('TCNTAutoHisTxn');
        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //เพิ่มข้อมูล
    public function FSaMSETAutoNumberInsert($paData){
        try{
            $this->db->set('FTAhmTblName', $paData['FTAhmTblName']);
            $this->db->set('FTAhmFedCode', $paData['FTAhmFedCode']);
            $this->db->set('FTSatStaDocType', $paData['FTSatStaDocType']);
            $this->db->set('FTAhmFmtAll', $paData['FTAhmFmtAll']);
            $this->db->set('FNAhmFedSize', $paData['FNAhmFedSize']);
            $this->db->set('FTAhmFmtChar', $paData['FTAhmFmtChar']);
            $this->db->set('FTAhmStaBch', $paData['FTAhmStaBch']);
            $this->db->set('FTAhmFmtYear', $paData['FTAhmFmtYear']);
            $this->db->set('FTAhmFmtMonth', $paData['FTAhmFmtMonth']);
            $this->db->set('FTAhmFmtDay', $paData['FTAhmFmtDay']);
            $this->db->set('FNAhmLastNum', $paData['FNAhmLastNum']);
            $this->db->set('FTAhmStaReset', $paData['FTAhmStaReset']);
            $this->db->set('FTAhmLastRun', $paData['FTAhmLastRun']);
            $this->db->set('FTSatUsrNum', $paData['FTSatUsrNum']);
            $this->db->set('FTAhmFmtReset', $paData['FTAhmFmtReset']);
            $this->db->set('FTAhmFmtPst', $paData['FTAhmFmtPst']);
            $this->db->set('FTSatStaAlwSep', $paData['FTSatStaAlwSep']);
            $this->db->set('FNAhmNumSize', $paData['FNAhmNumSize']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FDCreateOn', $paData['FDCreateOn']);
            $this->db->set('FTCreateBy', $paData['FTCreateBy']);
            $this->db->set('FTAgnCode', $paData['FTAgnCode']);
            $this->db->set('FTAhnLastFmt', '');

            $this->db->where('FTAhmTblName', $paData['FTAhmTblName']);
            $this->db->where('FTAhmFedCode', $paData['FTAhmFedCode']);
            $this->db->where('FTSatStaDocType', $paData['FTSatStaDocType']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->update('TCNTAutoHisTxn');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                $this->db->insert('TCNTAutoHisTxn',$paData);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }

        // $this->db->insert('TCNTAutoHisTxn',$paData);
        // if($this->db->affected_rows() > 0){
        //     $aStatus = array(
        //         'rtCode' => '1',
        //         'rtDesc' => 'success',
        //     );
        // }else{
        //     $aStatus = array(
        //         'rtCode' => '905',
        //         'rtDesc' => 'cannot insert.',
        //     );
        // }

        // $jStatus = json_encode($aStatus);
        // $aStatus = json_decode($jStatus, true);
        // return $aStatus;
    }

    // ===============================================  Export  Data ==================================================================

    // Function : Get Data Tsysconfig
    public function FSaMSETExportDetailTsysconfig()
    {
        // $tRoleCode  = $paData['tRoleCode'];
        // $nLngID     = $this->session->userdata("tLangEdit");

        $tSQL = " SELECT * FROM TSysConfig";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'raItems' => array(),
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Function : Get Data TSysConfig_L
    // Create By Sooksanti 05-10-2020
    public function FSaMSETExportDetailTSysConfig_L()
    {
        // $nLngID     = $this->session->userdata("tLangEdit");

        $tSQL = "   SELECT * FROM TSysConfig_L";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'raItems' => array(),
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Function : Delete TSysConfigTmp
    // Create By Sooksanti 06-10-2020
    public function FSaMSETDeleteTSysConfigTmp()
    {
        try {
            $tSQL = "DELETE FROM TSysConfigTmp";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig -> TSysConfigTmp
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertToTmpTSysConfig()
    {
        try {
            $tSQL = "INSERT INTO TSysConfigTmp
                                    (FTSysCode,
                                    FTSysApp,
                                    FTSysKey,
                                    FTSysSeq,
                                    FTGmnCode,
                                    FTSysStaAlwEdit,
                                    FTSysStaDataType,
                                    FNSysMaxLength,
                                    FTSysStaDefValue,
                                    FTSysStaDefRef,
                                    FTSysStaUsrValue,
                                    FTSysStaUsrRef,
                                    FDLastUpdOn,
                                    FTLastUpdBy,
                                    FDCreateOn,
                                    FTCreateBy
                                    )
                            SELECT FTSysCode,
                                FTSysApp,
                                FTSysKey,
                                FTSysSeq,
                                FTGmnCode,
                                FTSysStaAlwEdit,
                                FTSysStaDataType,
                                FNSysMaxLength,
                                FTSysStaDefValue,
                                FTSysStaDefRef,
                                FTSysStaUsrValue,
                                FTSysStaUsrRef,
                                FDLastUpdOn,
                                FTLastUpdBy,
                                FDCreateOn,
                                FTCreateBy
                            FROM TSysConfig";

            $this->db->query($tSQL);

        } catch (Exception $Error) {
            echo $Error;
        }
    }


    // Function : Delete TSysConfig
    // Create By Sooksanti 05-10-2020
    public function FSaMSETDeleteTSysConfig()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertTSysConfig($paDataInsTSysConfig)
    {
        try {
            $aInsTSysConfig = array(
                'FTSysCode' => $paDataInsTSysConfig['FTSysCode'],
                'FTSysApp' => $paDataInsTSysConfig['FTSysApp'],
                'FTSysKey' => $paDataInsTSysConfig['FTSysKey'],
                'FTSysSeq' => $paDataInsTSysConfig['FTSysSeq'],
                'FTGmnCode' => $paDataInsTSysConfig['FTGmnCode'],
                'FTSysStaAlwEdit' => $paDataInsTSysConfig['FTSysStaAlwEdit'],
                'FTSysStaDataType' => $paDataInsTSysConfig['FTSysStaDataType'],
                'FNSysMaxLength' => $paDataInsTSysConfig['FNSysMaxLength'],
                'FTSysStaDefValue' => $paDataInsTSysConfig['FTSysStaDefValue'],
                'FTSysStaDefRef' => $paDataInsTSysConfig['FTSysStaDefRef'],
                'FTSysStaUsrValue' => $paDataInsTSysConfig['FTSysStaUsrValue'],
                'FTSysStaUsrRef' => $paDataInsTSysConfig['FTSysStaUsrRef'],
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => '',
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
            );
            $this->db->insert('TSysConfig', $aInsTSysConfig);
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    // Function : Delete TSysConfig_LTmp
    // Create By Sooksanti 06-10-2020
    public function FSaMSETDeleteTSysConfig_LTmp()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig_LTmp";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig_L -> TSysConfig_LTmp
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertToTmpTSysConfig_L()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig_LTmp";
            $this->db->query($tSQL);

            $tSQL = "INSERT INTO TSysConfig_LTmp
                                    (FTSysCode,
                                    FTSysApp,
                                    FTSysKey,
                                    FTSysSeq,
                                    FNLngID,
                                    FTSysName,
                                    FTSysDesc,
                                    FTSysRmk
                                    )
                            SELECT  FTSysCode,
                                    FTSysApp,
                                    FTSysKey,
                                    FTSysSeq,
                                    FNLngID,
                                    FTSysName,
                                    FTSysDesc,
                                    FTSysRmk
                            FROM TSysConfig_L;";

            $this->db->query($tSQL);

            $tSQL = "DELETE FROM TSysConfig_L";
            $this->db->query($tSQL);

        } catch (Exception $Error) {
            echo $Error;
        }
    }

    // Function : Delete TSysConfig_LTmp
    // Create By Sooksanti 06-10-2020
    public function FSaMSETDeleteTSysConfig_L()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig_L";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig_L
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertTSysConfig_L($paDataInsTSysConfig_L)
    {
        try {
            $aInsTSysConfig_L = array(
                'FTSysCode' => $paDataInsTSysConfig_L['FTSysCode'],
                'FTSysApp' => $paDataInsTSysConfig_L['FTSysApp'],
                'FTSysKey' => $paDataInsTSysConfig_L['FTSysKey'],
                'FTSysSeq' => $paDataInsTSysConfig_L['FTSysSeq'],
                'FNLngID' => $paDataInsTSysConfig_L['FNLngID'],
                'FTSysName' => $paDataInsTSysConfig_L['FTSysName'],
                'FTSysDesc' => $paDataInsTSysConfig_L['FTSysDesc'],
                'FTSysRmk' => $paDataInsTSysConfig_L['FTSysRmk'],
            );
            $this->db->insert('TSysConfig_L', $aInsTSysConfig_L);
        } catch (Exception $Error) {
            echo $Error;
        }
    }
}
