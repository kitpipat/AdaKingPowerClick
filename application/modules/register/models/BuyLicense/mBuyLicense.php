<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mBuyLicense extends CI_Model {

    //Get ข้อมูล API
    public function FSxMBUYGetConfigAPI(){
        $tSQL       = "SELECT TOP 1 * FROM TCNTUrlObject WHERE FTUrlKey = 'REG' AND FTUrlTable = 'TCNMComp' AND FTUrlRefID = 'CENTER' ORDER BY FNUrlSeq ASC";
        $oQuery     = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //ล้างข้อมูลใน Temp - Data Show
    public function FSxMBUYClearTemp($paParams){
        if($paParams['ptTypeClear'] == 2){
            $aKey = ['Featues','Pos'];
        }else{
            $aKey = ['Featues','Pos','Package'];
        }
        $tSessionID = $paParams['tSessionID'];
        $this->db->where_in('FTXthDocKey', $aKey);
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocDTTmp');
    }

    //ล้างข้อมูลใน Temp - Data Use
    public function FSxMBUYClearTempData($paParams){
        $tSessionID = $paParams['tSessionID'];
        $tTypeClear = $paParams['ptTypeClear'];

        ($tTypeClear == 2) ? $this->db->where_in('FTXshDocNo', ['FEATUES','POS']) : '';
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalDTTmp');

        ($tTypeClear == 2) ? $this->db->where_in('FTXshDocNo', ['FEATUES','POS']) : '';
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalDTSetTmp');

        ($tTypeClear == 2) ? $this->db->where_in('FTXshDocNo', ['FEATUES','POS']) : '';
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalHDTmp');

        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalRCTmp');

        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalDTDisTmp');

        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalHDDisTmp');
    }

    //ล้างข้อมูลใน Temp - ตารางส่วนลด
    public function FSxMBUYClearTempDataDiscount($paParams){
        $tSessionID = $paParams['tSessionID'];

        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalDTDisTmp');

        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TRGTSalHDDisTmp');
    }

    //เพิ่มข้อมูลใน Temp
    public function FSxMBUYInsertToTemp($ptKey,$paParams){

        switch ($ptKey) {
            case "Featues": //เพิ่มข้อมูลฟิเจอร์ _ เอาไว้โชว์
                $this->db->insert('TCNTDocDTTmp', array(
                    'FTBchCode'                     => $paParams['tBchCode'],
                    'FTXthDocKey'                   => $paParams['tKey'],
                    'FTSessionID'                   => $paParams['tSessionID'],
                    'FNXtdSeqNo'                    => $paParams['nSeq'],
                    'FTBuyLicenseTextFeatues'       => $paParams['tTextFeatues'],
                    'FTBuyLicenseTextFeatuesDetail' => $paParams['tTextDetail'],
                    'FTBuyLicenseTextFeatuesQty'    => $paParams['tTextQty'],
                    'FTBuyLicenseTextFeatuesPrice'  => $paParams['tTextPrice'],
                    'FDCreateOn'                    => date('Y-m-d H:i:s')
                ));    
                break;
            case "Pos": //เพิ่มข้อมูลจุดขาย _ เอาไว้โชว์
                $this->db->insert('TCNTDocDTTmp', array(
                    'FTBchCode'                     => $paParams['tBchCode'],
                    'FTXthDocKey'                   => $paParams['tKey'],
                    'FTSessionID'                   => $paParams['tSessionID'],
                    'FNXtdSeqNo'                    => $paParams['nSeq'],
                    'FTBuyLicenseTextPos'           => $paParams['tTextPos'],
                    'FTBuyLicenseTextPosQty'        => $paParams['tTextPosQty'],
                    'FTBuyLicenseTextPosPrice'      => $paParams['tTextPosPrice'],
                    'FDCreateOn'                    => date('Y-m-d H:i:s')
                )); 
                break;
            case "Package": //เพิ่มข้อมูลแพ๊ตเกจ _ เอาไว้โชว์
                $this->db->insert('TCNTDocDTTmp', array(
                    'FTBchCode'                     => $paParams['tBchCode'],
                    'FTXthDocKey'                   => $paParams['tKey'],
                    'FTSessionID'                   => $paParams['tSessionID'],
                    'FNXtdSeqNo'                    => $paParams['nSeq'],
                    'FTBuyLicenseTextPackage'       => $paParams['tTextPackage'],
                    'FTBuyLicenseTextPackageDetail' => $paParams['tTextDetail'],
                    'FTBuyLicenseTextPackageMonth'  => $paParams['tTextMonth'],
                    'FTBuyLicenseTextPackagePrice'  => $paParams['tTextPrice'],
                    'FDCreateOn'                    => date('Y-m-d H:i:s')
                )); 
                break;
            case "TRGTSalDTTmp":  //เพิ่มข้อมูลแพ๊ตเกจ
                $this->db->insert('TRGTSalDTTmp', array(
                    'FTBchCode'         => $paParams['FTBchCode'],
                    'FTXshDocNo'        => $paParams['FTXshDocNo'],
                    'FNXsdSeqNo'        => $paParams['FNXsdSeqNo'],
                    'FTPdtCode'         => $paParams['FTPdtCode'],
                    'FTXsdPdtName'      => $paParams['FTXsdPdtName'],
                    'FTPunCode'         => $paParams['FTPunCode'],
                    'FTPunName'         => $paParams['FTPunName'],
                    'FCXsdFactor'       => $paParams['FCXsdFactor'],
                    'FTXsdBarCode'      => $paParams['FTXsdBarCode'],
                    'FTSrnCode'         => $paParams['FTSrnCode'],
                    'FTXsdVatType'      => $paParams['FTXsdVatType'],
                    'FTVatCode'         => $paParams['FTVatCode'],
                    'FTPplCode'         => $paParams['FTPplCode'],
                    'FCXsdVatRate'      => $paParams['FCXsdVatRate'],
                    'FTXsdSaleType'     => $paParams['FTXsdSaleType'],
                    'FCXsdSalePrice'    => $paParams['FCXsdSalePrice'],
                    'FCXsdQty'          => $paParams['FCXsdQty'],
                    'FCXsdQtyAll'       => $paParams['FCXsdQtyAll'],
                    'FCXsdSetPrice'     => $paParams['FCXsdSetPrice'],
                    'FCXsdAmtB4DisChg'  => $paParams['FCXsdAmtB4DisChg'],
                    'FTXsdDisChgTxt'    => $paParams['FTXsdDisChgTxt'],
                    'FCXsdDis'          => $paParams['FCXsdDis'],
                    'FCXsdChg'          => $paParams['FCXsdChg'],
                    'FCXsdNet'          => $paParams['FCXsdNet'],
                    'FCXsdNetAfHD'      => $paParams['FCXsdNetAfHD'],
                    'FCXsdVat'          => $paParams['FCXsdVat'],
                    'FCXsdVatable'      => $paParams['FCXsdVatable'],
                    'FCXsdWhtAmt'       => $paParams['FCXsdWhtAmt'],
                    'FTXsdWhtCode'      => $paParams['FTXsdWhtCode'],
                    'FCXsdWhtRate'      => $paParams['FCXsdWhtRate'],
                    'FCXsdCostIn'       => $paParams['FCXsdCostIn'],
                    'FCXsdCostEx'       => $paParams['FCXsdCostEx'],
                    'FTXsdStaPdt'       => $paParams['FTXsdStaPdt'],
                    'FCXsdQtyLef'       => $paParams['FCXsdQtyLef'],
                    'FCXsdQtyRfn'       => $paParams['FCXsdQtyRfn'],
                    'FTXsdStaPrcStk'    => $paParams['FTXsdStaPrcStk'],
                    'FTXsdStaAlwDis'    => $paParams['FTXsdStaAlwDis'],
                    'FNXsdPdtLevel'     => $paParams['FNXsdPdtLevel'],
                    'FTXsdPdtParent'    => $paParams['FTXsdPdtParent'],
                    'FCXsdQtySet'       => $paParams['FCXsdQtySet'],
                    'FTPdtStaSet'       => $paParams['FTPdtStaSet'],
                    'FTXsdRmk'          => $paParams['FTXsdRmk'],
                    'FDLastUpdOn'       => $paParams['FDLastUpdOn'],
                    'FTLastUpdBy'       => $paParams['FTLastUpdBy'],
                    'FDCreateOn'        => $paParams['FDCreateOn'],
                    'FTCreateBy'        => $paParams['FTCreateBy'],
                    'FTSessionID'       => $paParams['FTSessionID']
                )); 
                break;
            case "TRGTSalDTSetTmp":  //เพิ่มข้อมูลฟิเจอร์
                $this->db->insert('TRGTSalDTSetTmp', array(
                    'FTBchCode'         => $paParams['FTBchCode'],
                    'FTXshDocNo'        => $paParams['FTXshDocNo'],
                    'FNXsdSeqNo'        => $paParams['FNXsdSeqNo'],
                    'FNPstSeqNo'        => $paParams['FNPstSeqNo'],
                    'FTPdtCode'         => $paParams['FTPdtCode'],
                    'FTXsdPdtName'      => $paParams['FTXsdPdtName'],
                    'FTPunCode'         => $paParams['FTPunCode'],
                    'FCXsdQtySet'       => $paParams['FCXsdQtySet'],
                    'FCXsdSalePrice'    => $paParams['FCXsdSalePrice'],
                    'FTSessionID'       => $paParams['FTSessionID']
                )); 
                break;
            case "TRGTSalRCTmp":  //เพิ่มข้อมูลการชำระเงิน
                $this->db->insert('TRGTSalRCTmp', array(
                    'FTBchCode'         => $paParams['FTBchCode'],
                    'FTXshDocNo'        => $paParams['FTXshDocNo'],
                    'FNXrcSeqNo'        => $paParams['FNXrcSeqNo'],
                    'FTRcvCode'         => $paParams['FTRcvCode'],
                    'FTRcvName'         => $paParams['FTRcvName'],
                    'FTXrcRefNo1'       => $paParams['FTXrcRefNo1'],
                    'FTXrcRefNo2'       => $paParams['FTXrcRefNo2'],
                    'FDXrcRefDate'      => $paParams['FDXrcRefDate'],
                    'FTXrcRefDesc'      => $paParams['FTXrcRefDesc'],
                    'FTBnkCode'         => $paParams['FTBnkCode'],
                    'FTRteCode'         => $paParams['FTRteCode'],
                    'FCXrcRteFac'       => $paParams['FCXrcRteFac'],
                    'FCXrcFrmLeftAmt'   => $paParams['FCXrcFrmLeftAmt'],
                    'FCXrcUsrPayAmt'    => $paParams['FCXrcUsrPayAmt'],
                    'FCXrcDep'          => $paParams['FCXrcDep'],
                    'FCXrcNet'          => $paParams['FCXrcNet'],
                    'FCXrcChg'          => $paParams['FCXrcChg'],
                    'FTXrcRmk'          => $paParams['FTXrcRmk'],
                    'FTPhwCode'         => $paParams['FTPhwCode'],
                    'FTXrcRetDocRef'    => $paParams['FTXrcRetDocRef'],
                    'FTXrcStaPayOffline'=> $paParams['FTXrcStaPayOffline'],
                    'FDLastUpdOn'       => $paParams['FDLastUpdOn'],
                    'FTLastUpdBy'       => $paParams['FTLastUpdBy'],
                    'FDCreateOn'        => $paParams['FDCreateOn'],
                    'FTCreateBy'        => $paParams['FTCreateBy'],
                    'FTSessionID'       => $paParams['FTSessionID']
                )); 
                break;
            case "TRGTSalHDTmp":  //เพิ่มข้อมูลหัวรายการ
                $this->db->insert('TRGTSalHDTmp', array(
                    'FTBchCode'             => $paParams['FTBchCode'],
                    'FTXshDocNo'            => $paParams['FTXshDocNo'],
                    'FTShpCode'             => $paParams['FTShpCode'],
                    'FNXshDocType'          => $paParams['FNXshDocType'],
                    'FDXshDocDate'          => $paParams['FDXshDocDate'],
                    'FTXshCshOrCrd'         => $paParams['FTXshCshOrCrd'],
                    'FTXshVATInOrEx'        => $paParams['FTXshVATInOrEx'],
                    'FTDptCode'             => $paParams['FTDptCode'],
                    'FTWahCode'             => $paParams['FTWahCode'],
                    'FTPosCode'             => $paParams['FTPosCode'],
                    'FTShfCode'             => $paParams['FTShfCode'],
                    'FNSdtSeqNo'            => $paParams['FNSdtSeqNo'],
                    'FTUsrCode'             => $paParams['FTUsrCode'],
                    'FTSpnCode'             => $paParams['FTSpnCode'],
                    'FTXshApvCode'          => $paParams['FTXshApvCode'],
                    'FTCstCode'             => $paParams['FTCstCode'],
                    'FTXshDocVatFull'       => $paParams['FTXshDocVatFull'],
                    'FTXshRefExt'           => $paParams['FTXshRefExt'],
                    'FDXshRefExtDate'       => $paParams['FDXshRefExtDate'],
                    'FTXshRefInt'           => $paParams['FTXshRefInt'],
                    'FDXshRefIntDate'       => $paParams['FDXshRefIntDate'],
                    'FTXshRefAE'            => $paParams['FTXshRefAE'],
                    'FNXshDocPrint'         => $paParams['FNXshDocPrint'],
                    'FTRteCode'             => $paParams['FTRteCode'],
                    'FCXshRteFac'           => $paParams['FCXshRteFac'],
                    'FCXshTotal'            => $paParams['FCXshTotal'],
                    'FCXshTotalNV'          => $paParams['FCXshTotalNV'],
                    'FCXshTotalNoDis'       => $paParams['FCXshTotalNoDis'],
                    'FCXshTotalB4DisChgV'   => $paParams['FCXshTotalB4DisChgV'],
                    'FCXshTotalB4DisChgNV'  => $paParams['FCXshTotalB4DisChgNV'],
                    'FTXshDisChgTxt'        => $paParams['FTXshDisChgTxt'],
                    'FCXshDis'              => $paParams['FCXshDis'],
                    'FCXshChg'              => $paParams['FCXshChg'],
                    'FCXshTotalAfDisChgV'   => $paParams['FCXshTotalAfDisChgV'],
                    'FCXshTotalAfDisChgNV'  => $paParams['FCXshTotalAfDisChgNV'],
                    'FCXshRefAEAmt'         => $paParams['FCXshRefAEAmt'],
                    'FCXshAmtV'             => $paParams['FCXshAmtV'],
                    'FCXshAmtNV'            => $paParams['FCXshAmtNV'],
                    'FCXshVat'              => $paParams['FCXshVat'],
                    'FCXshVatable'          => $paParams['FCXshVatable'],
                    'FTXshWpCode'           => $paParams['FTXshWpCode'],
                    'FCXshWpTax'            => $paParams['FCXshWpTax'],
                    'FCXshGrand'            => $paParams['FCXshGrand'],
                    'FCXshRnd'              => $paParams['FCXshRnd'],
                    'FTXshGndText'          => $paParams['FTXshGndText'],
                    'FCXshPaid'             => $paParams['FCXshPaid'],
                    'FCXshLeft'             => $paParams['FCXshLeft'],
                    'FTXshRmk'              => $paParams['FTXshRmk'],
                    'FTXshStaRefund'        => $paParams['FTXshStaRefund'],
                    'FTXshStaDoc'           => $paParams['FTXshStaDoc'],
                    'FTXshStaApv'           => $paParams['FTXshStaApv'],
                    'FTXshStaPrcStk'        => $paParams['FTXshStaPrcStk'],
                    'FTXshStaPaid'          => $paParams['FTXshStaPaid'],
                    'FNXshStaDocAct'        => $paParams['FNXshStaDocAct'],
                    'FNXshStaRef'           => $paParams['FNXshStaRef'],
                    'FTRsnCode'             => $paParams['FTRsnCode'],
                    'FTXshAppVer'           => $paParams['FTXshAppVer'],
                    'FDLastUpdOn'           => $paParams['FDLastUpdOn'],
                    'FTLastUpdBy'           => $paParams['FTLastUpdBy'],
                    'FDCreateOn'            => $paParams['FDCreateOn'],
                    'FTCreateBy'            => $paParams['FTCreateBy'],
                    'FTSessionID'           => $paParams['FTSessionID']
                )); 
                break;
            case 'TRGTSalHDDisTmp': //ส่วนลดท้ายบิล
                $this->db->insert('TRGTSalHDDisTmp', array(
                    'FTBchCode'             => $paParams['FTBchCode'],
                    'FTXshDocNo'            => $paParams['FTXshDocNo'],
                    'FDXhdDateIns'          => $paParams['FDXhdDateIns'],
                    'FTXhdRefCode'          => $paParams['FTXhdRefCode'],
                    'FTXhdDisChgTxt'        => $paParams['FTXhdDisChgTxt'],
                    'FTXhdDisChgType'       => $paParams['FTXhdDisChgType'],
                    'FCXhdTotalAfDisChg'    => $paParams['FCXhdTotalAfDisChg'],
                    'FCXhdDisChg'           => $paParams['FCXhdDisChg'],
                    'FCXhdAmt'              => $paParams['FCXhdAmt'],
                    'FTDisCode'             => $paParams['FTDisCode'],
                    'FTRsnCode'             => $paParams['FTRsnCode'],
                    'FTSessionID'           => $paParams['FTSessionID']
                )); 
                break;
        }

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot',
            );
        }
        return $aStatus;
    }

    //ดึงข้อมูลจาก Temp
    public function FSxMBUYSelectTemp($ptKey){
        $tSession   = $this->session->userdata('tSesSessionID');

        if($ptKey == 'Package'){
            $tTextSelect = 'TOP 1 FTBchCode , 
                            FTXthDocKey , 
                            FTSessionID , 
                            FNXtdSeqNo , 
                            FTBuyLicenseTextPackage ,
                            FTBuyLicenseTextPackageDetail ,
                            FTBuyLicenseTextPackageMonth ,
                            FTBuyLicenseTextPackagePrice';
        }else if($ptKey == 'Pos'){
            $tTextSelect = 'FTBchCode , 
                            FTXthDocKey , 
                            FTSessionID , 
                            FNXtdSeqNo , 
                            FTBuyLicenseTextPos , 
                            FTBuyLicenseTextPosQty ,
                            FTBuyLicenseTextPosPrice ';
        }else if($ptKey == 'Featues'){
            $tTextSelect = 'FTBchCode , 
                            FTXthDocKey , 
                            FTSessionID , 
                            FNXtdSeqNo , 
                            FTBuyLicenseTextFeatues , 
                            FTBuyLicenseTextFeatuesDetail ,
                            FTBuyLicenseTextFeatuesQty,
                            FTBuyLicenseTextFeatuesPrice ';
        }

        $tSQL       = "SELECT $tTextSelect FROM TCNTDocDTTmp WHERE FTXthDocKey = '$ptKey' AND FTSessionID = '$tSession' ORDER BY FNXtdSeqNo ASC";
        $oQuery     = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //ผลรวมราคาจาก Temp 
    public function FSxMBUYSelectSumFooterTemp(){
        $tSession   = $this->session->userdata('tSesSessionID');

        $tSumPackage    = "ISNULL((SELECT TOP 1 ISNULL(FTBuyLicenseTextPackagePrice,0) FROM TCNTDocDTTmp WHERE FTXthDocKey IN ('Package') AND FTSessionID = '$tSession' ),0)";
        $tSumFeatues    = 'SUM(ISNULL(FTBuyLicenseTextFeatuesPrice,0))';
        $tSumPos        = 'SUM(ISNULL(FTBuyLicenseTextPosPrice,0))';

        $tSQL       = "SELECT $tSumPackage + $tSumFeatues + $tSumPos AS SumPrice FROM TCNTDocDTTmp 
                       WHERE FTXthDocKey IN ('Featues','Pos','Package') AND FTSessionID = '$tSession'";

        $oQuery     = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาเลขที่เอกสารใน client
    public function FSxMBUYInsertAndGetNumber($paParam){
        $tBchCode   = $paParam['tBchCode'];
        $tCstKey    = $paParam['tCstKey'];
        $dDate      = date('Y-m-d H:i:s');

        $this->db->insert('TRGTAutoNumber', array(
            'FTBchCode'         => $tBchCode,
            'FTCstKey'          => $tCstKey,
            'FTRegDateCreate'   => $dDate
        ));

        $tSQL       = "SELECT TOP 1 * FROM TRGTAutoNumber ORDER BY FNRegID DESC "; 
        $oQuery     = $this->db->query($tSQL);

        $oList          = $oQuery->result();
        $nLastCode 		= $oList[0]->FNRegID;
        $nCountNumber	= FCNnHSizeOf($nLastCode);
        if($nCountNumber == 1){
            $tFormat 		= '0000';
        }else if($nCountNumber == 2){
            $tFormat 		= '000';
        }else if($nCountNumber == 3){
            $tFormat 		= '00';
        }else if($nCountNumber == 4){
            $tFormat 		= '0';
        }else{
            $tFormat 		= '';
        }

        $tFormatCode = str_pad($nLastCode,strlen($tFormat)+1,$tFormat,STR_PAD_LEFT);
        $aResult    = array(
            'nDummyDocument' => $tFormatCode,
        );

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //select ตัวเลข คิดจากสูตร
    public function FSxMBUYSelectPrice($paParams){
        $tBchCode   = $paParams['tBchcode'];
        $tSessionID = $paParams['tSessionID'];
        $tSQL       = " SELECT
                            /* ยอดรวม ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXsdNet, 0)) AS FCXshTotal,

                            /* ยอดรวมสินค้าไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdNet, 0) ELSE 0 END) AS FCXshTotalNV,

                            /* ยอดรวมสินค้าห้ามลด ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXsdStaAlwDis = 2 THEN ISNULL(DTTMP.FCXsdNet, 0) ELSE 0 END) AS FCXshTotalNoDis,

                            /* ยอมรวมสินค้าลดได้ และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 1 THEN ISNULL(DTTMP.FCXsdAmtB4DisChg, 0) ELSE 0 END) AS FCXshTotalB4DisChgV,

                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                            SUM(CASE WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdAmtB4DisChg, 0) ELSE 0 END) AS FCXshTotalB4DisChgNV,

                            /* ยอดรวมหลังลด และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXsdVatType = 1 THEN ISNULL(DTTMP.FCXsdNetAfHD, 0) ELSE 0 END) AS FCXshTotalAfDisChgV,

                            /* ยอดรวมหลังลด และไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 2  THEN ISNULL(DTTMP.FCXsdNetAfHD, 0) ELSE 0 END) AS FCXshTotalAfDisChgNV,

                            /* ยอดรวมเฉพาะภาษี ==============================================================*/
                            (
                                SUM(ISNULL(DTTMP.FCXsdNet, 0))
                                -
                                SUM(CASE WHEN DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdNet, 0) ELSE 0 END)
                                -
                                (
                                    SUM(CASE WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 1 THEN ISNULL(DTTMP.FCXsdAmtB4DisChg, 0) ELSE 0 END)
                                    -
                                    SUM(CASE WHEN DTTMP.FTXsdVatType = 1 THEN ISNULL(DTTMP.FCXsdNetAfHD, 0) ELSE 0 END)
                                )
                            ) AS FCXshAmtV,

                            /* ยอดรวมเฉพาะไม่มีภาษี ==============================================================*/
                            (
                                SUM(CASE WHEN DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdNet, 0) ELSE 0 END)
                                -
                                (
                                    SUM(CASE WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdAmtB4DisChg, 0) ELSE 0 END)
                                    -
                                    SUM(CASE WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdNetAfHD, 0) ELSE 0 END)
                                )
                            ) AS FCXshAmtNV,

                            /* ยอดภาษี ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXsdVat, 0)) AS FCXshVat,

                            /* ยอดแยกภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวมเฉพาะภาษี */
                                    (
                                        (
                                            /* ยอดรวม */
                                            SUM(DTTMP.FCXsdNet)
                                            - 
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 1 THEN ISNULL(DTTMP.FCXsdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอดรวมหลังลด และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXsdVatType = 1 THEN ISNULL(DTTMP.FCXsdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                    -
                                    /* ยอดภาษี */
                                    SUM(ISNULL(DTTMP.FCXsdVat, 0))	
                                )
                                +
                                (
                                    /* ยอดรวมเฉพาะไม่มีภาษี */
                                    (
                                        (
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXsdStaAlwDis = 1 AND DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอดรวมหลังลด และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXsdVatType = 2 THEN ISNULL(DTTMP.FCXsdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                )
                            ) AS FCXshVatable
                        FROM TRGTSalDTTmp DTTMP
                        WHERE DTTMP.FTSessionID   = '$tSessionID'
                        AND DTTMP.FTBchCode     = '$tBchCode'
                        GROUP BY DTTMP.FTSessionID ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->result_array();
        }else{
            $aResult    = [];
        }
        return $aResult;
    }

    //อัพเดทเลขที่เอกสารทั้งหมด ทุกตาราง
    public function FSxMBUYUpdateDocumentToTemp($paParam){
        $tDocument      = $paParam['tDocument'];
        $tSession       = $paParam['tSession'];

        $this->db->set('FTXshDocNo', $tDocument);
        $this->db->where('FTSessionID', $tSession);
        $this->db->update('TRGTSalHDTmp');

        $this->db->set('FTXshDocNo', $tDocument);
        $this->db->where('FTSessionID', $tSession);
        $this->db->update('TRGTSalDTTmp');

        $this->db->set('FTXshDocNo', $tDocument);
        $this->db->where('FTSessionID', $tSession);
        $this->db->update('TRGTSalDTDisTmp');

        $this->db->set('FTXshDocNo', $tDocument);
        $this->db->where('FTSessionID', $tSession);
        $this->db->update('TRGTSalDTSetTmp');

        $this->db->set('FTXshDocNo', $tDocument);
        $this->db->where('FTSessionID', $tSession);
        $this->db->update('TRGTSalRCTmp');

        $this->db->set('FTXshDocNo', $tDocument);
        $this->db->where('FTSessionID', $tSession);
        $this->db->update('TRGTSalHDDisTmp');
    }

    //Selete ข้อมูลพร้อมส่งเข้า API
    public function FSxMBUYSeletedTemp($tTableName,$tDocumentNumber){
        $tSQLSelete     = "SELECT * FROM $tTableName TMP WHERE TMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."' ";
        $tSQLSelete     .= " AND TMP.FTXshDocNo = '$tDocumentNumber' ";
        $oQuerySelete    = $this->db->query($tSQLSelete);
        $oListResult     = $oQuerySelete->result();
        return $oListResult;
    }

    //Prorate การขาย
    public function FSxCCalculateProrate(){
        $tSession_id = $this->session->userdata('tSesSessionID');

        //Step 01 : วิ่งไปเช็คว่ามีส่วนลดท้ายบิล 
        $tSQLHDDis = "SELECT HDD.*,CASE WHEN HDD.FCXhdAmt < 0 THEN 1 ELSE 3 END AS FTXhdDisChgType FROM(
                        SELECT SUM(CASE WHEN FTXhdDisChgType = 1 THEN FCXhdAmt * -1
                                        WHEN FTXhdDisChgType = 2 THEN FCXhdAmt * -1
                                        WHEN FTXhdDisChgType = 3 THEN FCXhdAmt
                                        WHEN FTXhdDisChgType = 4 THEN FCXhdAmt
                                    ELSE 0 END 
                                ) FCXhdAmt
                        FROM  TRGTSalHDDisTmp
                        WHERE FTSessionID  = '$tSession_id'
                    ) HDD WHERE FCXhdAmt != 0 AND FCXhdAmt > 0 ";

        $oQueryHDDis = $this->db->query($tSQLHDDis);
        if($oQueryHDDis->num_rows() > 0){ //พบข้อมูล

            //ผลรวมของ ส่วนลดท้ายบิล
            $aDetailHDDis = $oQueryHDDis->result_array();
            $nDiscount    = $aDetailHDDis[0]['FCXhdAmt'];

            $tCheckType   =  substr($nDiscount,0,1);
            if($tCheckType == '-'){//'Type เป็น ลด ';
                $tFTXtdDisChgType = 1;
            }else{//'Type เป็น ชาร์ท ';
                $tFTXtdDisChgType = 3;
            }
            $nDiscount = abs($nDiscount); 

            //Step 03 : ไปเอาข้อมูลแต่ละรายการในตาราง Temp
            $tSQLDT = "SELECT FTPdtCode,FTXsdPdtName,FCXsdNet,FTXsdStaAlwDis,FNXsdSeqNo FROM TRGTSalDTTmp 
                       WHERE FTXsdStaAlwDis = 1 AND FTSessionID = '$tSession_id' ";

            $oQueryDT = $this->db->query($tSQLDT);
            if($oQueryDT->num_rows() > 0){

                //Step 04 : คำนวณ prorate เข้าสูตร : ส่วนลดท้ายบิลทั้งหมด x ราคาต่อชิ้น/ราคาทั้งหมดหลังหักส่วนลด
                $aDetail  = $oQueryDT->result_array();

                //ทศนิยม
                $nDecimal = FCNxHGetOptionDecimalShow();
                $dDate    = date("Y-m-d H:i:s");

                //Insert Prorate
                $tSql = "INSERT INTO TRGTSalDTDisTmp (
                            FTBchCode,
                            FTXshDocNo,
                            FNXsdSeqNo,
                            FTSessionID,
                            FDXddDateIns,
                            FNXddStaDis,
                            FTXddDisChgType,
                            FCXddNet,
                            FCXddValue,
                            FTXddDisChgTxt
                        ) 
                        SELECT 
                            PDT.FTBchCode,
                            PDT.FTXshDocNo,
                            PDT.FNXsdSeqNo,
                            '$tSession_id' AS FTSessionID,
                            '$dDate' AS FDXddDateIns,
                            '2' AS FNXddStaDis,
                            '$tFTXtdDisChgType' AS  FTXddDisChgType,
                            PDT.FCXsdNet AS FCXddNet,
                            SUBSTRING(CONVERT(VARCHAR(50),CONVERT(VARCHAR(100),(ISNULL(PDT.FCXsdNet,1) * $nDiscount) / PDT.SUMNET) ,121),1,CHARINDEX('.',CONVERT(VARCHAR(100),(ISNULL(PDT.FCXsdNet,1) * $nDiscount) / PDT.SUMNET))+2) AS FCXddValue,
                            '$nDiscount' AS FTXddDisChgTxt
                        FROM (
                            SELECT 
                                DT.FTPdtCode,
                                DT.FTXsdPdtName,
                                DT.FCXsdNet,
                                ( select SUM(FCXsdNet) FROM TRGTSalDTTmp WHERE FTSessionID = '$tSession_id' GROUP BY FTSessionID ) AS SUMNET,
                                DT.FTXsdStaAlwDis,
                                DT.FNXsdSeqNo ,
                                DT.FTBchCode,
                                DT.FTXshDocNo
                            FROM TRGTSalDTTmp DT
                            WHERE DT.FTXsdStaAlwDis = 1 
                            AND DT.FTSessionID = '$tSession_id'
                        ) AS PDT ";
                $tInsertDTDis = FCNaHProrateInsertDiscount($tSql);

                //Check ตัวสุดท้ายของ prorate
                $tSqlLastSum = "UPDATE Tmp SET Tmp.FCXddValue = LastProrate.FCXthLastProrate
                                FROM TRGTSalDTDisTmp Tmp INNER JOIN ( SELECT DT.FTXshDocNo 
                                                                            , DT.FNXsdSeqNo 
                                                                            , TmpLast.FCXddValue + ($nDiscount - (
                                                                                                                SELECT SUM(FCXddValue) FROM TRGTSalDTDisTmp  
                                                                                                                WHERE FTSessionID = '$tSession_id'
                                                                                                                AND FNXddStaDis = '2' )
                                                                                                                ) AS FCXthLastProrate  
                                                                        FROM TRGTSalDTTmp DT 
                                                                        INNER JOIN  ( SELECT TOP 1 FCXddValue , FNXsdSeqNo , FTXshDocNo
                                                                                    FROM TRGTSalDTDisTmp DT
                                                                                    WHERE DT.FTSessionID = '$tSession_id' 
                                                                                    AND DT.FNXddStaDis = '2'  ORDER BY FNXsdSeqNo DESC ) TmpLast
                                                                        ON DT.FTXshDocNo = TmpLast.FTXshDocNo AND DT.FNXsdSeqNo = TmpLast.FNXsdSeqNo 
                                                                        WHERE DT.FTSessionID = '$tSession_id' 
                                                                        GROUP BY DT.FTXshDocNo , DT.FNXsdSeqNo , TmpLast.FCXddValue
                                                                        ) AS LastProrate ON Tmp.FTXshDocNo = LastProrate.FTXshDocNo 
                                                                        AND Tmp.FNXsdSeqNo = LastProrate.FNXsdSeqNo AND Tmp.FNXddStaDis = 2 ";
                FCNaHProrateInsertDiscount($tSqlLastSum);
                
                if($tInsertDTDis == 'success'){
                    $aDataReturn    =  array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'success',
                    );
                }else{
                    $aDataReturn    =  array(
                        'rtCode'    => '800',
                        'rtDesc'    => 'Data Not Found',
                    );
                }

                return $aDataReturn;
            }else{ //ไม่พบข้อมูลของสินค้า
                return;
            }
        }else{
            return;
        }
    }

    //Calculate Document DT ใหม่
    public function FSxRecalUpdateDocDTTemp(){
        $tDataVatInOrEx     = $this->session->userdata("nVatCalculate");
        $tDataSeqNo         = '';
        $tDataSessionID     = $this->session->userdata('tSesSessionID');

        if(isset($tDataVatInOrEx) && !empty($tDataVatInOrEx) && $tDataVatInOrEx == 1){
            // Vat
            $tSQLVatInOrEx  = " DocDTUpd.FCXsdVat       = DocDTSlt.FCXsdVatIn,
                                DocDTUpd.FCXsdVatable   = DocDTSlt.FCXsdVatTableIn, ";
            // Cost
            $tSQLCostInOrEx = " DocDTUpd.FCXsdCostIn    = DocDTSlt.FCXsdCostInVatIn,
                                DocDTUpd.FCXsdCostEx    = DocDTSlt.FCXsdCostExVatIn ";
        }else if(isset($tDataVatInOrEx) && !empty($tDataVatInOrEx) && $tDataVatInOrEx == 2){
            // Vat
            $tSQLVatInOrEx  = " DocDTUpd.FCXsdVat       = DocDTSlt.FCXsdVatEx,
                                DocDTUpd.FCXsdVatable   = DocDTSlt.FCXsdVatTableEx, ";
            // Cost
            $tSQLCostInOrEx = " DocDTUpd.FCXsdCostIn    = DocDTSlt.FCXsdCostInVatEx,
                                DocDTUpd.FCXsdCostEx    = DocDTSlt.FCXsdCostExVatEx ";
        }else{
            $tSQLVatInOrEx  = "";
            $tSQLCostInOrEx = "";
        }

        $tSQLWhereSeqDT     = "";
        $tSQLWhereSeqDis    = "";
        if(isset($tDataSeqNo) && !empty($tDataSeqNo)){
            $tSQLWhereSeqDT     = " AND DTTemp.FNXsdSeqNo = '".$tDataSeqNo."'";
            $tSQLWhereSeqDis    = " AND TRGTSalDTTmp.FNXsdSeqNo = '".$tDataSeqNo."'";
        }

        $tSQL   = " UPDATE DocDTUpd
                    SET
                        DocDTUpd.FCXsdQtyAll        = DocDTSlt.FCXsdQtyAll,
                        DocDTUpd.FCXsdWhtAmt        = DocDTSlt.FCXsdAmtB4DisChg,
                        DocDTUpd.FCXsdAmtB4DisChg   = DocDTSlt.FCXsdAmtB4DisChg,
                        DocDTUpd.FCXsdDis           = DocDTSlt.FCXsdDis,
                        DocDTUpd.FCXsdChg           = DocDTSlt.FCXsdChg,
                        DocDTUpd.FCXsdNet           = DocDTSlt.FCXsdNet,
                        DocDTUpd.FCXsdNetAfHD       = DocDTSlt.FCXsdNetAfHD,
                        ".$tSQLVatInOrEx."
                        ".$tSQLCostInOrEx."
                    FROM TRGTSalDTTmp DocDTUpd WITH (NOLOCK)
                    INNER JOIN (
                        SELECT
                            DataB4CalcCost.*,
                            (DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatIn)	AS FCXsdVatTableIn,
                            (DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatEx)	AS FCXsdVatTableEx,
                            ((DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatIn)*ISNULL(DataB4CalcCost.FCXsdWhtRate,0))   AS FCXsdWhtAmtIn,
                            ((DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatEx)*ISNULL(DataB4CalcCost.FCXsdWhtRate,0))   AS FCXsdWhtAmtEx,
                            (DataB4CalcCost.FCXsdVatIn+(DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatIn))               AS FCXsdCostInVatIn,
                            (DataB4CalcCost.FCXsdVatEx+(DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatEx))	            AS FCXsdCostInVatEx,
                            (DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatIn) AS FCXsdCostExVatIn,
                            (DataB4CalcCost.FCXsdNetAfHD - DataB4CalcCost.FCXsdVatEx) AS FCXsdCostExVatEx
                        FROM (
                            SELECT
                                DataB4Calc.FTBchCode,
                                DataB4Calc.FTXshDocNo,
                                DataB4Calc.FTSessionID,
                                DataB4Calc.FNXsdSeqNo,
                                DataB4Calc.FTXsdStaAlwDis,
                                DataB4Calc.FTXsdVatType,
                                DataB4Calc.FTVatCode,
                                DataB4Calc.FCXsdVatRate,
                                DataB4Calc.FTXsdWhtCode,
                                DataB4Calc.FCXsdWhtRate,
                                DataB4Calc.FCXsdQty,
                                ISNULL(DataB4Calc.FCXsdQtyAll,0)        AS FCXsdQtyAll,
                                ISNULL(DataB4Calc.FCXsdSetPrice,0)      AS FCXsdSetPrice,
                                ISNULL(DataB4Calc.FCXsdDis,0)           AS FCXsdDis,
                                ISNULL(DataB4Calc.FCXsdChg,0)           AS FCXsdChg,
                                ISNULL(DataB4Calc.FTXsdDisHD,0)         AS FTXsdDisHD,
                                ISNULL(DataB4Calc.FTXsdChgHD,0)         AS FTXsdChgHD,
                                ISNULL(DataB4Calc.FCXsdAmtB4DisChg,0)   AS FCXsdAmtB4DisChg,
                                ISNULL(DataB4Calc.FCXsdNet,0)           AS FCXsdNet,
                                ISNULL(DataB4Calc.FCXsdNetAfHD,0)       AS FCXsdNetAfHD,
                                CASE 	
                                    WHEN DataB4Calc.FTXsdVatType = 1 AND (DATALENGTH(DataB4Calc.FTVatCode) <> 0 OR DATALENGTH(DataB4Calc.FCXsdVatRate) <> 0)
                                    THEN (DataB4Calc.FCXsdNetAfHD-((DataB4Calc.FCXsdNetAfHD*100)/(100+DataB4Calc.FCXsdVatRate)))
                                ELSE 0 END AS FCXsdVatIn,
                                CASE
                                    WHEN DataB4Calc.FTXsdVatType = 1 AND (DATALENGTH(DataB4Calc.FTVatCode) <> 0 OR DATALENGTH(DataB4Calc.FCXsdVatRate) <> 0)
                                    THEN (((DataB4Calc.FCXsdNetAfHD*(100+DataB4Calc.FCXsdVatRate))/100)-DataB4Calc.FCXsdNetAfHD)
                                ELSE 0 END AS FCXsdVatEx
                            FROM (
                                SELECT
                                    DTTemp.FTBchCode,DTTemp.FTXshDocNo,DTTemp.FTSessionID,DTTemp.FNXsdSeqNo,DTTemp.FTXsdStaAlwDis,
                                    DTTemp.FTXsdVatType,DTTemp.FTVatCode,DTTemp.FCXsdVatRate,DTTemp.FTXsdWhtCode,DTTemp.FCXsdWhtRate,DTTemp.FCXsdQty,
                                    DTTemp.FCXsdSetPrice,
                                    (DTTemp.FCXsdQty * DTTemp.FCXsdFactor ) AS FCXsdQtyAll,
                                    ISNULL(DTDisAll.FTXsdDisList,0)         AS FCXsdDis,
                                    ISNULL(DTDisAll.FTXsdChgList,0)	        AS FCXsdChg,
                                    ISNULL(DTDisAll.FTXsdDisFoot,0)	        AS FTXsdDisHD,
                                    ISNULL(DTDisAll.FTXsdChgFoot,0)	        AS FTXsdChgHD,
                                    (ISNULL(DTTemp.FCXsdQty,0)*ISNULL(DTTemp.FCXsdSetPrice,0))  AS FCXsdAmtB4DisChg,
                                    ((ISNULL(DTTemp.FCXsdQty,0)*ISNULL(DTTemp.FCXsdSetPrice,0))-(-ISNULL(DTDisAll.FTXsdDisList,0))+(ISNULL(DTDisAll.FTXsdChgList,0)))   AS FCXsdNet,
                                    (((ISNULL(DTTemp.FCXsdQty,0)*ISNULL(DTTemp.FCXsdSetPrice,0))-(-ISNULL(DTDisAll.FTXsdDisList,0))+(ISNULL(DTDisAll.FTXsdChgList,0)))+((ISNULL(DTDisAll.FTXsdDisFoot,0))+(ISNULL(DTDisAll.FTXsdChgFoot,0))))  AS FCXsdNetAfHD
                                FROM (
                                    SELECT
                                        DTTemp.FTBchCode,DTTemp.FTXshDocNo,DTTemp.FTSessionID,DTTemp.FNXsdSeqNo,DTTemp.FTXsdStaAlwDis,DTTemp.FCXsdFactor,
                                        DTTemp.FTXsdVatType,
                                        DTTemp.FTVatCode,DTTemp.FCXsdVatRate,DTTemp.FTXsdWhtCode,DTTemp.FCXsdWhtRate,DTTemp.FCXsdQty,
                                        DTTemp.FCXsdQtyAll,DTTemp.FCXsdSetPrice
                                    FROM TRGTSalDTTmp DTTemp WITH (NOLOCK)
                                    WHERE 1=1 AND DTTemp.FTSessionID	= '".$tDataSessionID."'
                                    ".$tSQLWhereSeqDT."
                                    ) DTTemp
                                LEFT JOIN (
                                    SELECT 
                                        CASE	WHEN DTDisList.FNXsdSeqNo IS NULL THEN DTDisFoot.FNXsdSeqNo
                                                WHEN DTDisFoot.FTXsdDisFoot	IS NULL THEN DTDisList.FNXsdSeqNo
                                        ELSE DTDisFoot.FNXsdSeqNo END
                                        AS FNXsdSeqNo,
                                        DTDisList.FTXsdDisList,
                                        DTDisList.FTXsdChgList,
                                        DTDisFoot.FTXsdDisFoot,
                                        DTDisFoot.FTXsdChgFoot
                                    FROM (
                                        SELECT
                                        TRGTSalDTDisTmp.FNXsdSeqNo,
                                            SUM(CASE	WHEN TRGTSalDTDisTmp.FTXddDisChgType = 1	THEN -FCXddValue
                                                        WHEN TRGTSalDTDisTmp.FTXddDisChgType = 2	THEN -FCXddValue
                                                ELSE 0 END
                                            )AS FTXsdDisList,
                                            SUM(CASE 	WHEN TRGTSalDTDisTmp.FTXddDisChgType = 3	THEN FCXddValue
                                                        WHEN TRGTSalDTDisTmp.FTXddDisChgType = 4	THEN FCXddValue
                                                ELSE 0 END
                                            ) AS FTXsdChgList
                                        FROM TRGTSalDTDisTmp WITH (NOLOCK)
                                        WHERE 1=1
                                        AND TRGTSalDTDisTmp.FNXddStaDis = 1
                                        AND TRGTSalDTDisTmp.FTSessionID = '".$tDataSessionID."'
                                        ".$tSQLWhereSeqDis."
                                        GROUP BY TRGTSalDTDisTmp.FNXsdSeqNo ) AS DTDisList
                                    FULL OUTER JOIN (
                                        SELECT
                                        TRGTSalDTDisTmp.FNXsdSeqNo,
                                            SUM(	CASE	WHEN TRGTSalDTDisTmp.FTXddDisChgType = 1	THEN -FCXddValue
                                                            WHEN TRGTSalDTDisTmp.FTXddDisChgType = 2	THEN -FCXddValue
                                                    ELSE 0 END
                                            ) AS FTXsdDisFoot,
                                            SUM(	CASE	WHEN TRGTSalDTDisTmp.FTXddDisChgType = 3	THEN FCXddValue
                                                            WHEN TRGTSalDTDisTmp.FTXddDisChgType = 4	THEN FCXddValue
                                                    ELSE 0 END
                                            ) AS FTXsdChgFoot
                                        FROM TRGTSalDTDisTmp WITH (NOLOCK)
                                        WHERE 1=1
                                        AND TRGTSalDTDisTmp.FNXddStaDis		= 2
                                        AND TRGTSalDTDisTmp.FTSessionID		= '".$tDataSessionID."'
                                        ".$tSQLWhereSeqDis."
                                        GROUP BY TRGTSalDTDisTmp.FNXsdSeqNo ) AS DTDisFoot
                                    ON DTDisList.FNXsdSeqNo	= DTDisFoot.FNXsdSeqNo ) AS DTDisAll
                                ON DTTemp.FNXsdSeqNo = DTDisAll.FNXsdSeqNo
                            ) AS DataB4Calc
                        ) AS DataB4CalcCost
                    ) AS DocDTSlt
                    ON 1=1
                    AND DocDTUpd.FTXshDocNo 	= DocDTSlt.FTXshDocNo
                    AND DocDTUpd.FNXsdSeqNo 	= DocDTSlt.FNXsdSeqNo
                    AND DocDTUpd.FTSessionID	= DocDTSlt.FTSessionID";
        $oQuery = $this->db->query($tSQL);
        if($oQuery == 1){
            return true;
        }else{
            return false;
        }
    }

    //ส่วนลดท้ายบิล
    public function FSxMBUYSelectHDDisTemp(){
        $tSession   = $this->session->userdata('tSesSessionID');
        $tSQL       = "SELECT * FROM TRGTSalHDDisTmp WHERE FTSessionID = '$tSession' ";
        $oQuery     = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Check DT Set
    public function FSxMBUYCheckDTSetInPackage($ptCodeFeature){
        $tSession   = $this->session->userdata('tSesSessionID');
        $tSQL       = "SELECT FNPstSeqNo FROM TRGTSalDTSetTmp WHERE FTPdtCode = '$ptCodeFeature' AND FTSessionID = '$tSession' ";
        $oQuery     = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = array(
                'rtCode'        => '1',
                'rtDesc'        => 'found'
            );
        }else{
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาค่า HD Dis
    public function FSaMBUYCalInHDDisTemp($paParams){
        $tDocNo     = $paParams['tDocNo'];
        $tBchCode   = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID']; 
        $tSQL       = " SELECT
                            /* ข้อความมูลค่าลดชาร์จ ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXhdDisChgTxt
                                FROM TRGTSalHDDisTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode 		= '$tBchCode'
                                AND DOCCONCAT.FTXshDocNo		= '$tDocNo'
                                AND DOCCONCAT.FTSessionID		= '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXhdDisChgTxt,
                            /* มูลค่ารวมส่วนลด ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXhdDisChgType = 1 THEN ISNULL(HDDISTMP.FCXhdAmt, 0)
                                    WHEN HDDISTMP.FTXhdDisChgType = 2 THEN ISNULL(HDDISTMP.FCXhdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXshDis,
                            /* มูลค่ารวมส่วนชาร์จ ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXhdDisChgType = 3 THEN ISNULL(HDDISTMP.FCXhdAmt, 0)
                                    WHEN HDDISTMP.FTXhdDisChgType = 4 THEN ISNULL(HDDISTMP.FCXhdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXshChg
                        FROM TRGTSalHDDisTmp HDDISTMP
                        WHERE 1=1 
                        AND HDDISTMP.FTXshDocNo     = '$tDocNo' 
                        AND HDDISTMP.FTSessionID    = '$tSessionID'
                        AND HDDISTMP.FTBchCode      = '$tBchCode'
                        GROUP BY HDDISTMP.FTSessionID ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = [];
        }
        return $aResult;
    }

    //Update HD
    public function FSaMBUYCalInHDTemp($paParam){
        $tSession       = $paParam['tSessionID'];

        $this->db->set('FTXshDisChgTxt', $paParam['FTXshDisChgTxt']);
        $this->db->set('FCXshDis', $paParam['FCXshDis']);
        $this->db->set('FCXshChg', $paParam['FCXshChg']);
        $this->db->where('FTSessionID', $tSession);
        $this->db->update('TRGTSalHDTmp');
    }

}


