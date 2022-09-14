<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class mSaleImportBill extends CI_Model {
    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
   public function FSaMIMPAddUpdateBill($poBillFile){

        try{

                if(!empty($poBillFile)){
                    foreach($poBillFile as $tTable => $aDataTable){
                            $tSessionID = $this->session->userdata('tSesSessionID');
                            $tTableName = substr($tTable,2).'IMPTmp';
                            if(!empty($aDataTable)){
                                $this->db->where('FTSessionID',$tSessionID)->delete($tTableName);
                                $aPackDataTable = $this->FSaMIMPSetCreateAndUpdate($aDataTable);
                                $this->db->insert_batch($tTableName, $aPackDataTable); 
                            }else{
                                $this->db->where('FTSessionID',$tSessionID)->delete($tTableName);
                            }
                    }

                }

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
                        'rtDesc' => 'Error Not Insert',
                    );
                }

                    // die();
                    return $aStatus;
            }catch(Exception $Error){
                return $Error;
            }

   }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
   public function FSaMIMPUpdateSalHDSpc($ptDocNo){
    try{

        $tSessionID = $this->session->userdata('tSesSessionID');
        $tSQL = "UPDATE 
                        SalHDTmp
                    SET 
                        SalHDTmp.FTXshStaRefund = SalHD.FTXshStaRefund,
                        SalHDTmp.FTXshDocVatFull = SalHD.FTXshDocVatFull,
                        SalHDTmp.FTXshStaPrcStk  = SalHD.FTXshStaPrcStk,
                        SalHDTmp.FNXshStaRef    = SalHD.FNXshStaRef
                    FROM TPSTSalHDIMPTmp AS SalHDTmp
                        INNER JOIN TPSTSalHD AS SalHD ON SalHDTmp.FTBchCode = SalHD.FTBchCode AND  SalHDTmp.FTXshDocNo = SalHD.FTXshDocNo
                    WHERE SalHDTmp.FTXshDocNo = '$ptDocNo'
                    AND SalHDTmp.FTSessionID = '$tSessionID' 
        ";
             $oQuery = $this->db->query($tSQL);
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
                        'rtDesc' => 'Error Not Insert',
                    );
                }

                    // die();
                    return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
   }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
   public function FSaMIMPUpdateSalDTSpc($ptDocNo){
    try{

        $tSessionID = $this->session->userdata('tSesSessionID');
        $tSQL = "UPDATE 
                        SalDTTmp
                    SET 
                        SalDTTmp.FTXsdStaPdt = SalDT.FTXsdStaPdt,
                        SalDTTmp.FCXsdQtyLef = SalDT.FCXsdQtyLef,
                        SalDTTmp.FCXsdQtyRfn  = SalDT.FCXsdQtyRfn,
                        SalDTTmp.FTXsdStaPrcStk  = SalDT.FTXsdStaPrcStk
                    FROM TPSTSalDTIMPTmp AS SalDTTmp
                        INNER JOIN TPSTSalDT AS SalDT ON SalDTTmp.FTBchCode = SalDT.FTBchCode AND  SalDTTmp.FTXshDocNo = SalDT.FTXshDocNo AND SalDTTmp.FNXsdSeqNo = SalDT.FNXsdSeqNo
                    WHERE SalDTTmp.FTXshDocNo = '$ptDocNo'
                    AND SalDTTmp.FTSessionID = '$tSessionID'
        ";
            $oQuery = $this->db->query($tSQL);
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
                        'rtDesc' => 'Error Not Insert',
                    );
                }

                    // die();
                    return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
   }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
   private function FSaMIMPSetCreateAndUpdate($paData){
    try{
            if(!empty($paData)){
                foreach($paData as $tKey => $aDataBill){
                        if(!empty($aDataBill)){
                            foreach($aDataBill as $tFeild => $tValue){
                            //    if($pType=='insert'){
                                if($tFeild=='FDCreateOn'){
                                    $paData[$tKey][$tFeild] = date('Y-m-d H:i:s');
                                }
                                if($tFeild=='FTCreateBy'){
                                    $paData[$tKey][$tFeild] = $this->session->userdata('tSesUserCode');
                                }
                            //    }
                                if($tFeild=='FDLastUpdOn'){
                                    $paData[$tKey][$tFeild] = date('Y-m-d H:i:s');
                                }
                                if($tFeild=='FTLastUpdBy'){
                                    $paData[$tKey][$tFeild] = $this->session->userdata('tSesUserCode');
                                }

                                $paData[$tKey]['FTSessionID'] = $this->session->userdata('tSesSessionID');

                            }
                        }
                        
                }
            }
            return $paData;
        }catch(Exception $Error){
            return $Error;
        }
           
   }

    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
       //ข้อมูลการขาย DT
       public function FSaMIMPGetDT($paData){
        $aRowLen            = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $tSessionID         = $this->session->userdata('tSesSessionID');
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXshDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                    DTDis.DISPMT , SALDT.FTBchCode , SALDT.FTXshDocNo , SALDT.FNXsdSeqNo , FTPdtCode , FTXsdPdtName ,
                                    FTPunCode , FTPunName , FCXsdFactor , FTXsdBarCode , FTSrnCode ,
                                    FTXsdVatType , FTVatCode , FTPplCode , FCXsdVatRate , FTXsdSaleType ,
                                    FCXsdSalePrice , FCXsdQty , FCXsdQtyAll , FCXsdSetPrice , FCXsdAmtB4DisChg ,
                                    FTXsdDisChgTxt , FCXsdDis , FCXsdChg , FCXsdNet , FCXsdNetAfHD ,
                                    FCXsdVat , FCXsdVatable , FCXsdWhtAmt , FTXsdWhtCode , FCXsdWhtRate ,
                                    FCXsdCostIn , FCXsdCostEx , FTXsdStaPdt , FCXsdQtyLef , FCXsdQtyRfn ,
                                    FTXsdStaPrcStk , FTXsdStaAlwDis , FNXsdPdtLevel , FTXsdPdtParent , FCXsdQtySet ,
                                    FTPdtStaSet , FTXsdRmk , FDLastUpdOn , FTLastUpdBy , FDCreateOn , FTCreateBy
                            FROM TPSTSalDTIMPTmp SALDT WITH (NOLOCK)
                            LEFT JOIN ( SELECT SUM(FCXddValue) as DISPMT , FNXsdSeqNo , FTBchCode FROM TPSTSalDTDisIMPTmp 
                                        WHERE FNXddStaDis = 2 AND FTXddDisChgType IN ('1','2') AND ISNULL(FTXddRefCode,'') <> ''
                                        AND TPSTSalDTDisIMPTmp.FTXshDocNo = '$tDocumentNumber' AND TPSTSalDTDisIMPTmp.FTSessionID = '$tSessionID'
                                        GROUP BY FNXsdSeqNo , FTBchCode
                                    ) DTDis ON DTDis.FNXsdSeqNo = SALDT.FNXsdSeqNo AND DTDis.FTBchCode = SALDT.FTBchCode
                            WHERE 1=1 AND SALDT.FTXshDocNo = '$tDocumentNumber' AND SALDT.FTSessionID = '$tSessionID' ";

        //ค้นหาแบบพิเศษ
        @$tSearchPDT   = $paData['tSearchPDT'];
        $tSQL .= "  AND ((SALDT.FTXshDocNo LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTPdtCode LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTXsdPdtName LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTPunName LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTXsdBarCode LIKE '%$tSearchPDT%') 
                        OR (SALDT.FCXsdQty LIKE '%$tSearchPDT%') 
                        OR (SALDT.FCXsdSetPrice LIKE '%$tSearchPDT%') 
                        OR (SALDT.FCXsdNetAfHD LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTBchCode LIKE '%$tSearchPDT%')
                    )";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMIMPGetDTPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']);
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    //หาจำนวนการขาย DT
    public function FSnMIMPGetDTPageAll($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $tSessionID         = $this->session->userdata('tSesSessionID');
        $tSQL   = " SELECT COUNT (SALDT.FTXshDocNo) AS counts FROM TPSTSalDTIMPTmp SALDT WITH (NOLOCK) WHERE 1=1 AND SALDT.FTXshDocNo = '$tDocumentNumber' AND SALDT.FTSessionID = '$tSessionID' ";

        //ค้นหาแบบพิเศษ
        @$tSearchPDT   = $paData['tSearchPDT'];
        $tSQL   .= "  AND ((SALDT.FTXshDocNo LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTPdtCode LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTXsdPdtName LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTPunName LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTXsdBarCode LIKE '%$tSearchPDT%') 
                        OR (SALDT.FCXsdQty LIKE '%$tSearchPDT%') 
                        OR (SALDT.FCXsdSetPrice LIKE '%$tSearchPDT%') 
                        OR (SALDT.FCXsdNetAfHD LIKE '%$tSearchPDT%') 
                        OR (SALDT.FTBchCode LIKE '%$tSearchPDT%')
                    )";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }
    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    //ข้อมูลการขาย HD
    public function FSaMIMPGetHD($paData){
        $tDocumentNumber    = $paData['tDocumentNumber'];
        $nLangEdit          = $paData['nLangEdit'];
        $tSessionID         = $this->session->userdata('tSesSessionID');
        $tSQL               = "SELECT
                                  SALHD.*,
                                  BCH_L.FTBchName,
                                  CstHD.FTXshCstName 
                            FROM TPSTSalHDIMPTmp SALHD WITH (NOLOCK)
                            LEFT JOIN TCNMBranch_L BCH_L ON SALHD.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLangEdit
                            LEFT JOIN TPSTSalHDCstIMPTmp CstHD ON SALHD.FTXshDocNo = CstHD.FTXshDocNo  AND  SALHD.FTBchCode = CstHD.FTBchCode
                            WHERE 1=1 AND SALHD.FTXshDocNo = '$tDocumentNumber' AND SALHD.FTSessionID = '$tSessionID' AND ISNULL(SALHD.FTXshDocVatFull,'') = '' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalHD($paData){
    try{
        $tImpXthDocNo = $paData['tImpXthDocNo'];
        $tSesSessionID = $paData['tSesSessionID'];
 
        $tSQLDelete = "DELETE FROM TPSTSalHD WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
        $oQuery = $this->db->query($tSQLDelete);

        $tSqlInsert = "
                INSERT INTO TPSTSalHD (
                    FTBchCode,
                    FTXshDocNo,
                    FTShpCode,
                    FNXshDocType,
                    FDXshDocDate,
                    FTXshCshOrCrd,
                    FTXshVATInOrEx,
                    FTDptCode,
                    FTWahCode,
                    FTPosCode,
                    FTShfCode,
                    FNSdtSeqNo,
                    FTUsrCode,
                    FTSpnCode,
                    FTXshApvCode,
                    FTCstCode,
                    FTXshDocVatFull,
                    FTXshRefExt,
                    FDXshRefExtDate,
                    FTXshRefInt,
                    FDXshRefIntDate,
                    FTXshRefAE,
                    FNXshDocPrint,
                    FTRteCode,
                    FCXshRteFac,
                    FCXshTotal,
                    FCXshTotalNV,
                    FCXshTotalNoDis,
                    FCXshTotalB4DisChgV,
                    FCXshTotalB4DisChgNV,
                    FTXshDisChgTxt,
                    FCXshDis,
                    FCXshChg,
                    FCXshTotalAfDisChgV,
                    FCXshTotalAfDisChgNV,
                    FCXshRefAEAmt,
                    FCXshAmtV,
                    FCXshAmtNV,
                    FCXshVat,
                    FCXshVatable,
                    FTXshWpCode,
                    FCXshWpTax,
                    FCXshGrand,
                    FCXshRnd,
                    FTXshGndText,
                    FCXshPaid,
                    FCXshLeft,
                    FTXshRmk,
                    FTXshStaRefund,
                    FTXshStaDoc,
                    FTXshStaApv,
                    FTXshStaPrcStk,
                    FTXshStaPaid,
                    FNXshStaDocAct,
                    FNXshStaRef,
                    FDLastUpdOn,
                    FTLastUpdBy,
                    FDCreateOn,
                    FTCreateBy,
                    FTRsnCode,
                    FTXshAppVer
                ) 
                SELECT
                    TMP.FTBchCode,
                    TMP.FTXshDocNo,
                    TMP.FTShpCode,
                    TMP.FNXshDocType,
                    TMP.FDXshDocDate,
                    TMP.FTXshCshOrCrd,
                    TMP.FTXshVATInOrEx,
                    TMP.FTDptCode,
                    TMP.FTWahCode,
                    TMP.FTPosCode,
                    TMP.FTShfCode,
                    TMP.FNSdtSeqNo,
                    TMP.FTUsrCode,
                    TMP.FTSpnCode,
                    TMP.FTXshApvCode,
                    TMP.FTCstCode,
                    TMP.FTXshDocVatFull,
                    TMP.FTXshRefExt,
                    TMP.FDXshRefExtDate,
                    TMP.FTXshRefInt,
                    TMP.FDXshRefIntDate,
                    TMP.FTXshRefAE,
                    TMP.FNXshDocPrint,
                    TMP.FTRteCode,
                    TMP.FCXshRteFac,
                    TMP.FCXshTotal,
                    TMP.FCXshTotalNV,
                    TMP.FCXshTotalNoDis,
                    TMP.FCXshTotalB4DisChgV,
                    TMP.FCXshTotalB4DisChgNV,
                    TMP.FTXshDisChgTxt,
                    TMP.FCXshDis,
                    TMP.FCXshChg,
                    TMP.FCXshTotalAfDisChgV,
                    TMP.FCXshTotalAfDisChgNV,
                    TMP.FCXshRefAEAmt,
                    TMP.FCXshAmtV,
                    TMP.FCXshAmtNV,
                    TMP.FCXshVat,
                    TMP.FCXshVatable,
                    TMP.FTXshWpCode,
                    TMP.FCXshWpTax,
                    TMP.FCXshGrand,
                    TMP.FCXshRnd,
                    TMP.FTXshGndText,
                    TMP.FCXshPaid,
                    TMP.FCXshLeft,
                    TMP.FTXshRmk,
                    TMP.FTXshStaRefund,
                    TMP.FTXshStaDoc,
                    TMP.FTXshStaApv,
                    TMP.FTXshStaPrcStk,
                    TMP.FTXshStaPaid,
                    TMP.FNXshStaDocAct,
                    TMP.FNXshStaRef,
                    TMP.FDLastUpdOn,
                    TMP.FTLastUpdBy,
                    TMP.FDCreateOn,
                    TMP.FTCreateBy,
                    TMP.FTRsnCode,
                    TMP.FTXshAppVer
                    FROM
                    TPSTSalHDIMPTmp TMP WITH (NOLOCK)
                    WHERE
                    TMP.FTXshDocNo = '$tImpXthDocNo'
                    AND TMP.FTSessionID = '$tSesSessionID' 
            ";

            $this->db->query($tSqlInsert);

            $aResult    = array(
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        }
    }
    


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalDT($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalDT WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalDT (
                        FTBchCode,
                        FTXshDocNo,
                        FNXsdSeqNo,
                        FTPdtCode,
                        FTXsdPdtName,
                        FTPunCode,
                        FTPunName,
                        FCXsdFactor,
                        FTXsdBarCode,
                        FTSrnCode,
                        FTXsdVatType,
                        FTVatCode,
                        FTPplCode,
                        FCXsdVatRate,
                        FTXsdSaleType,
                        FCXsdSalePrice,
                        FCXsdQty,
                        FCXsdQtyAll,
                        FCXsdSetPrice,
                        FCXsdAmtB4DisChg,
                        FTXsdDisChgTxt,
                        FCXsdDis,
                        FCXsdChg,
                        FCXsdNet,
                        FCXsdNetAfHD,
                        FCXsdVat,
                        FCXsdVatable,
                        FCXsdWhtAmt,
                        FTXsdWhtCode,
                        FCXsdWhtRate,
                        FCXsdCostIn,
                        FCXsdCostEx,
                        FTXsdStaPdt,
                        FCXsdQtyLef,
                        FCXsdQtyRfn,
                        FTXsdStaPrcStk,
                        FTXsdStaAlwDis,
                        FNXsdPdtLevel,
                        FTXsdPdtParent,
                        FCXsdQtySet,
                        FTPdtStaSet,
                        FTXsdRmk,
                        FDLastUpdOn,
                        FTLastUpdBy,
                        FDCreateOn,
                        FTCreateBy
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FNXsdSeqNo,
                        TMP.FTPdtCode,
                        TMP.FTXsdPdtName,
                        TMP.FTPunCode,
                        TMP.FTPunName,
                        TMP.FCXsdFactor,
                        TMP.FTXsdBarCode,
                        TMP.FTSrnCode,
                        TMP.FTXsdVatType,
                        TMP.FTVatCode,
                        TMP.FTPplCode,
                        TMP.FCXsdVatRate,
                        TMP.FTXsdSaleType,
                        TMP.FCXsdSalePrice,
                        TMP.FCXsdQty,
                        TMP.FCXsdQtyAll,
                        TMP.FCXsdSetPrice,
                        TMP.FCXsdAmtB4DisChg,
                        TMP.FTXsdDisChgTxt,
                        TMP.FCXsdDis,
                        TMP.FCXsdChg,
                        TMP.FCXsdNet,
                        TMP.FCXsdNetAfHD,
                        TMP.FCXsdVat,
                        TMP.FCXsdVatable,
                        TMP.FCXsdWhtAmt,
                        TMP.FTXsdWhtCode,
                        TMP.FCXsdWhtRate,
                        TMP.FCXsdCostIn,
                        TMP.FCXsdCostEx,
                        TMP.FTXsdStaPdt,
                        TMP.FCXsdQtyLef,
                        TMP.FCXsdQtyRfn,
                        TMP.FTXsdStaPrcStk,
                        TMP.FTXsdStaAlwDis,
                        TMP.FNXsdPdtLevel,
                        TMP.FTXsdPdtParent,
                        TMP.FCXsdQtySet,
                        TMP.FTPdtStaSet,
                        TMP.FTXsdRmk,
                        TMP.FDLastUpdOn,
                        TMP.FTLastUpdBy,
                        TMP.FDCreateOn,
                        TMP.FTCreateBy
                        FROM
                        TPSTSalDTIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }



    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalDTDis($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalDTDis WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalDTDis (
                        FTBchCode,
                        FTXshDocNo,
                        FNXsdSeqNo,
                        FDXddDateIns,
                        FTXddRefCode,
                        FNXddStaDis,
                        FTXddDisChgTxt,
                        FTXddDisChgType,
                        FCXddNet,
                        FCXddValue,
                        FTDisCode,
                        FTRsnCode
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FNXsdSeqNo,
                        TMP.FDXddDateIns,
                        TMP.FTXddRefCode,
                        TMP.FNXddStaDis,
                        TMP.FTXddDisChgTxt,
                        TMP.FTXddDisChgType,
                        TMP.FCXddNet,
                        TMP.FCXddValue,
                        TMP.FTDisCode,
                        TMP.FTRsnCode
                        FROM
                        TPSTSalDTDisIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }



    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalDTPmt($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalDTPmt WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalDTPmt (
                        FTBchCode,
                        FTXshDocNo,
                        FTPmhCode,
                        FTXdpGrpName,
                        FTXsdBarCode,
                        FNXsdSeqNo,
                        FCXdpQtyAll,
                        FCXdpNet,
                        FCXdpSetPrice,
                        FCXdpGetQtyDiv,
                        FCXdpGetCond,
                        FCXdpGetValue,
                        FCXdpDis,
                        FCXdpDisAvg,
                        FCXdpPoint,
                        FTXdpStaExceptPmt,
                        FTXdpStaRcv
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FTPmhCode,
                        TMP.FTXdpGrpName,
                        TMP.FTXsdBarCode,
                        TMP.FNXsdSeqNo,
                        TMP.FCXdpQtyAll,
                        TMP.FCXdpNet,
                        TMP.FCXdpSetPrice,
                        TMP.FCXdpGetQtyDiv,
                        TMP.FCXdpGetCond,
                        TMP.FCXdpGetValue,
                        TMP.FCXdpDis,
                        TMP.FCXdpDisAvg,
                        TMP.FCXdpPoint,
                        TMP.FTXdpStaExceptPmt,
                        TMP.FTXdpStaRcv
                        FROM
                        TPSTSalDTPmtIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalHDCst($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalHDCst WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalHDCst (
                        FTBchCode,
                        FTXshDocNo,
                        FTXshCardID,
                        FTXshCardNo,
                        FNXshCrTerm,
                        FDXshDueDate,
                        FDXshBillDue,
                        FTXshCtrName,
                        FDXshTnfDate,
                        FTXshRefTnfID,
                        FNXshAddrShip,
                        FNXshAddrTax,
                        FTXshCstName,
                        FTXshCstTel,
                        FCXshCstPnt,
                        FCXshCstPntPmt
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FTXshCardID,
                        TMP.FTXshCardNo,
                        TMP.FNXshCrTerm,
                        TMP.FDXshDueDate,
                        TMP.FDXshBillDue,
                        TMP.FTXshCtrName,
                        TMP.FDXshTnfDate,
                        TMP.FTXshRefTnfID,
                        TMP.FNXshAddrShip,
                        TMP.FNXshAddrTax,
                        TMP.FTXshCstName,
                        TMP.FTXshCstTel,
                        TMP.FCXshCstPnt,
                        TMP.FCXshCstPntPmt
                        FROM
                        TPSTSalHDCstIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalHDDis($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalHDDis WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalHDDis (
                        FTBchCode,
                        FTXshDocNo,
                        FDXhdDateIns,
                        FTXhdDisChgTxt,
                        FTXhdDisChgType,
                        FCXhdTotalAfDisChg,
                        FCXhdDisChg,
                        FCXhdAmt,
                        FTXhdRefCode,
                        FTDisCode,
                        FTRsnCode
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FDXhdDateIns,
                        TMP.FTXhdDisChgTxt,
                        TMP.FTXhdDisChgType,
                        TMP.FCXhdTotalAfDisChg,
                        TMP.FCXhdDisChg,
                        TMP.FCXhdAmt,
                        TMP.FTXhdRefCode,
                        TMP.FTDisCode,
                        TMP.FTRsnCode
                        FROM
                        TPSTSalHDDisIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalPD($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalPD WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalPD (
                        FTBchCode,
                        FTXshDocNo,
                        FTPmhDocNo,
                        FNXsdSeqNo,
                        FTPmdGrpName,
                        FTPdtCode,
                        FTPunCode,
                        FCXsdQty,
                        FCXsdQtyAll,
                        FCXsdSetPrice,
                        FCXsdNet,
                        FCXpdGetQtyDiv,
                        FTXpdGetType,
                        FCXpdGetValue,
                        FCXpdDis,
                        FCXpdPerDisAvg,
                        FCXpdDisAvg,
                        FCXpdPoint,
                        FTXpdStaRcv,
                        FTPplCode,
                        FTXpdCpnText,
                        FTCpdBarCpn
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FTPmhDocNo,
                        TMP.FNXsdSeqNo,
                        TMP.FTPmdGrpName,
                        TMP.FTPdtCode,
                        TMP.FTPunCode,
                        TMP.FCXsdQty,
                        TMP.FCXsdQtyAll,
                        TMP.FCXsdSetPrice,
                        TMP.FCXsdNet,
                        TMP.FCXpdGetQtyDiv,
                        TMP.FTXpdGetType,
                        TMP.FCXpdGetValue,
                        TMP.FCXpdDis,
                        TMP.FCXpdPerDisAvg,
                        TMP.FCXpdDisAvg,
                        TMP.FCXpdPoint,
                        TMP.FTXpdStaRcv,
                        TMP.FTPplCode,
                        TMP.FTXpdCpnText,
                        TMP.FTCpdBarCpn
                        FROM
                        TPSTSalPDIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }

    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalRC($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalRC WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalRC (
                        FTBchCode,
                        FTXshDocNo,
                        FNXrcSeqNo,
                        FTRcvCode,
                        FTRcvName,
                        FTXrcRefNo1,
                        FTXrcRefNo2,
                        FDXrcRefDate,
                        FTXrcRefDesc,
                        FTBnkCode,
                        FTRteCode,
                        FCXrcRteFac,
                        FCXrcFrmLeftAmt,
                        FCXrcUsrPayAmt,
                        FCXrcDep,
                        FCXrcNet,
                        FCXrcChg,
                        FTXrcRmk,
                        FTPhwCode,
                        FTXrcRetDocRef,
                        FTXrcStaPayOffline,
                        FDLastUpdOn,
                        FTLastUpdBy,
                        FDCreateOn,
                        FTCreateBy
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FNXrcSeqNo,
                        TMP.FTRcvCode,
                        TMP.FTRcvName,
                        TMP.FTXrcRefNo1,
                        TMP.FTXrcRefNo2,
                        TMP.FDXrcRefDate,
                        TMP.FTXrcRefDesc,
                        TMP.FTBnkCode,
                        TMP.FTRteCode,
                        TMP.FCXrcRteFac,
                        TMP.FCXrcFrmLeftAmt,
                        TMP.FCXrcUsrPayAmt,
                        TMP.FCXrcDep,
                        TMP.FCXrcNet,
                        TMP.FCXrcChg,
                        TMP.FTXrcRmk,
                        TMP.FTPhwCode,
                        TMP.FTXrcRetDocRef,
                        TMP.FTXrcStaPayOffline,
                        TMP.FDLastUpdOn,
                        TMP.FTLastUpdBy,
                        TMP.FDCreateOn,
                        TMP.FTCreateBy
                        FROM
                        TPSTSalRCIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }



    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTPSTSalRD($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     
            $tSQLDelete = "DELETE FROM TPSTSalRD WHERE 1=1 AND FTXshDocNo = '$tImpXthDocNo' ";
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TPSTSalRD (
                        FTBchCode,
                        FTXshDocNo,
                        FNXrdSeqNo,
                        FTRdhDocType,
                        FNXrdRefSeq,
                        FTXrdRefCode,
                        FCXrdPdtQty,
                        FNXrdPntUse
                    ) 
                    SELECT
                        TMP.FTBchCode,
                        TMP.FTXshDocNo,
                        TMP.FNXrdSeqNo,
                        TMP.FTRdhDocType,
                        TMP.FNXrdRefSeq,
                        TMP.FTXrdRefCode,
                        TMP.FCXrdPdtQty,
                        TMP.FNXrdPntUse
                        FROM
                        TPSTSalRDIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTXshDocNo = '$tImpXthDocNo'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTCNTMemTxnRedeem($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];

            $tXshRefInt =  $this->db->where('FTXshDocNo',$tImpXthDocNo)->select('FTXshRefInt')->get('TPSTSalHD')->row_array()['FTXshRefInt'];
     
            if($tXshRefInt!=''){
                $tImpXthDocNo = $tXshRefInt;
                $tSQLDelete = "DELETE FROM TCNTMemTxnRedeem WHERE 1=1 AND FTRedRefInt = '$tXshRefInt' ";
            }else{
                $tSQLDelete = "DELETE FROM TCNTMemTxnRedeem WHERE 1=1 AND FTRedRefDoc = '$tImpXthDocNo' ";
            }
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TCNTMemTxnRedeem (
                        FTCgpCode,
                        FTMemCode,
                        FTRedRefDoc,
                        FTRedRefInt,
                        FTRedRefSpl,
                        FDRedRefDate,
                        FCRedPntB4Bill,
                        FCRedPntBillQty,
                        FTRedPntStaClosed,
                        FDRedPntStart,
                        FDRedPntExpired,
                        FDLastUpdOn,
                        FTLastUpdBy,
                        FDCreateOn,
                        FTCreateBy,
                        FTRedPntDocType,
                        FTRedStaSend
                    ) 
                    SELECT
                        TMP.FTCgpCode,
                        TMP.FTMemCode,
                        TMP.FTRedRefDoc,
                        TMP.FTRedRefInt,
                        TMP.FTRedRefSpl,
                        TMP.FDRedRefDate,
                        TMP.FCRedPntB4Bill,
                        TMP.FCRedPntBillQty,
                        TMP.FTRedPntStaClosed,
                        TMP.FDRedPntStart,
                        TMP.FDRedPntExpired,
                        TMP.FDLastUpdOn,
                        TMP.FTLastUpdBy,
                        TMP.FDCreateOn,
                        TMP.FTCreateBy,
                        TMP.FTRedPntDocType,
                        TMP.FTRedStaSend
                        FROM
                        TCNTMemTxnRedeemIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTRedRefDoc LIKE '$tImpXthDocNo%'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }


    //Functionality : Function Insert FSaMRDHAddUpdateConditionRedeemCD
    //Parameters : function parameters
    //Creator : 02/03/2020 Nattakit(Nale)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMIMPTCNTMemTxnSale($paData){
        try{
            $tImpXthDocNo = $paData['tImpXthDocNo'];
            $tSesSessionID = $paData['tSesSessionID'];
     

            $tXshRefInt =  $this->db->where('FTXshDocNo',$tImpXthDocNo)->select('FTXshRefInt')->get('TPSTSalHD')->row_array()['FTXshRefInt'];

            if($tXshRefInt!=''){
                $tImpXthDocNo = $tXshRefInt;
                $tSQLDelete = "DELETE FROM TCNTMemTxnSale WHERE 1=1 AND FTTxnRefInt = '$tXshRefInt' ";
            }else{
                $tSQLDelete = "DELETE FROM TCNTMemTxnSale WHERE 1=1 AND FTTxnRefDoc = '$tImpXthDocNo' ";
            }

          
            $oQuery = $this->db->query($tSQLDelete);
    
            $tSqlInsert = "
                    INSERT INTO TCNTMemTxnSale (
                        FTCgpCode,
                        FTMemCode,
                        FTTxnRefDoc,
                        FTTxnRefInt,
                        FTTxnRefSpl,
                        FDTxnRefDate,
                        FCTxnRefGrand,
                        FCTxnPntOptBuyAmt,
                        FCTxnPntOptGetQty,
                        FCTxnPntB4Bill,
                        FDTxnPntStart,
                        FDTxnPntExpired,
                        FCTxnPntBillQty,
                        FCTxnPntUsed,
                        FCTxnPntExpired,
                        FTTxnPntStaClosed,
                        FDLastUpdOn,
                        FTLastUpdBy,
                        FDCreateOn,
                        FTCreateBy,
                        FTTxnPntDocType,
                        FTTxnStaSend
                    ) 
                    SELECT
                        TMP.FTCgpCode,
                        TMP.FTMemCode,
                        TMP.FTTxnRefDoc,
                        TMP.FTTxnRefInt,
                        TMP.FTTxnRefSpl,
                        TMP.FDTxnRefDate,
                        TMP.FCTxnRefGrand,
                        TMP.FCTxnPntOptBuyAmt,
                        TMP.FCTxnPntOptGetQty,
                        TMP.FCTxnPntB4Bill,
                        TMP.FDTxnPntStart,
                        TMP.FDTxnPntExpired,
                        TMP.FCTxnPntBillQty,
                        TMP.FCTxnPntUsed,
                        TMP.FCTxnPntExpired,
                        TMP.FTTxnPntStaClosed,
                        TMP.FDLastUpdOn,
                        TMP.FTLastUpdBy,
                        TMP.FDCreateOn,
                        TMP.FTCreateBy,
                        TMP.FTTxnPntDocType,
                        TMP.FTTxnStaSend
                        FROM
                        TCNTMemTxnSaleIMPTmp TMP WITH (NOLOCK)
                        WHERE
                        TMP.FTTxnRefDoc LIKE '$tImpXthDocNo%'
                        AND TMP.FTSessionID = '$tSesSessionID' 
                ";
    
                $this->db->query($tSqlInsert);
    
                $aResult    = array(
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
                return $aResult;
            }catch(Exception $Error){
                return $Error;
            }
        }


}