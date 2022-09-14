<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPurchaseorder extends CI_Model {

    //Function : Cancel Doc
    public function FSvMPOCancel($paDataUpdate){
        try{
            //DT Dis
            $this->db->set('FTXphStaDoc' , 3);
            $this->db->where('FTXphDocNo', $paDataUpdate['FTXphDocNo']);
            $this->db->update('TAPTOrdHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }

    //Function : Approve Doc
    public function FSvMPOApprove($paDataUpdate){
        try{
            //DT Dis
            $this->db->set('FTXphStaDoc' , 1);
            $this->db->set('FTXphStaApv' , 1);
            $this->db->set('FTXphApvCode' , $paDataUpdate['FTXphApvCode']);
            $this->db->where('FTXphDocNo', $paDataUpdate['FTXphDocNo']);
            $this->db->update('TAPTOrdHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }

    public function FStPOGetShpCodeForUsrLogin($paDataShp){

        $nLngID     = $paDataShp['FNLngID'];
        $tUsrLogin  = $paDataShp['tUsrLogin'];

        $tSQL = "SELECT UGP.FTShpCode,
                        SHP.FTWahCode,
                        SHPL.FTShpName,
			            WAHL.FTWahName
                FROM TCNTUsrGroup UGP
                LEFT JOIN TCNMShop      SHP ON UGP.FTShpCode = SHP.FTShpCode
                LEFT JOIN TCNMShop_L    SHPL ON SHP.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = $nLngID
                LEFT JOIN TCNMWaHouse_L WAHL ON SHP.FTWahCode = WAHL.FTWahCode 
                WHERE FTUsrCode ='$tUsrLogin' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oRes  = $oQuery->result();
        $tDataShp = $oRes[0];
        }else{
        $tDataShp = '';
        }

        return $tDataShp;
    }

    public function FSaMPOGetDefOptionPO($paData){

        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT CON.FTSysStaUsrValue,WAHL.FTWahName
                FROM TSysConfig CON
                LEFT JOIN TCNMWaHouse_L WAHL ON CON.FTSysStaUsrValue = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                WHERE FTSysCode='tCN_WahPO' AND FTSysSeq='1'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oRes  = $oQuery->result();
        $tData = $oRes[0];
        }else{
        $tData = '';
        }

        return $tData;

    }

    //Get Vat rate ของ DocNo
    public function FSaMPOGetAddress($ptBchCode,$ptXphShipAdd,$nLngID){
    
        $tSQL = "SELECT FTAddV1No,
                        FTAddV1Soi,
                        FTAddV1Village,
                        FTAddV1Road,
                        FTAddV1SubDist,
                        FTAddV1DstCode,
                        FTAddV1PvnCode,
                        FTAddV1PostCode,
                        PVNL.FTPvnName,
                        DSTL.FTDstName,
                        SUBDSTL.FTSudName
        
                FROM TCNMAddress_L ADDL

                LEFT JOIN TCNMProvince_L   PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                LEFT JOIN TCNMDistrict_L   DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                LEFT JOIN TCNMSubDistrict_L SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
                
                ";

        if($ptBchCode!= ""){
            $tSQL .= "WHERE FTAddGrpType = 1 AND FTAddRefCode = '$ptBchCode' AND FNAddSeqNo = '$ptXphShipAdd'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oData    = $oQuery->result();
        }else{
            $oData = 0;
        }

        return $oData;
    }

    //Get Vat rate ของ DocNo
    public function FScMPOGetVatRateFromDoc($ptXphDocNo){
        
        $tSQL = "SELECT ISNULL(FCXphVATRate,0) AS FCXphVATRate    
                FROM TAPTOrdHD ";

        if($ptXphDocNo!= ""){
            $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphVATRate = $oData[0]->FCXphVATRate;
        }else{
        $cXphVATRate = 0;
        }

        return $cXphVATRate;
    }

    public function FSaMPOGetHDFCXphWpTax($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdWhtAmt),0) AS FCXphWpTax  
                 FROM TAPTOrdDT ";

        if($ptXphDocNo!= ""){
        $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphWpTax = $oData[0]->FCXphWpTax;
        }else{
        $cXphWpTax = 0;
        }

        return $cXphWpTax;

    }

    public function FSaMPOGetHDFCXphNoVatAfDisChg($ptXphDocNo){

        $tSQL = "SELECT ISNULL(HDis.FCXphNoVatDisChgAvi-SUM(HDis.FCXphDisNoVat-HDis.FCXphChgNoVat),0) AS FCXphNoVatAfDisChg
                 FROM TAPTOrdHDDis HDis ";

        if($ptXphDocNo != ""){
            $tSQL .= " WHERE HDis.FTXphDocNo = '$ptXphDocNo'";
        }

        $tSQL .= " GROUP BY HDis.FCXphNoVatDisChgAvi";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphNoVatAfDisChg = $oData[0]->FCXphNoVatAfDisChg;
        }else{
        $cXphNoVatAfDisChg = 0;
        }

        return $cXphNoVatAfDisChg;

    }

    public function FSaMPOGetFCXphRefAEAmt($ptXphDocNo){

        $tSQL = "SELECT FCXphRefAEAmt
                 FROM TAPTOrdHD HD";

        if($ptXphDocNo != ""){
            $tSQL .= " WHERE HD.FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphRefAEAmt = $oData[0]->FCXphRefAEAmt;
        }else{
        $cXphRefAEAmt = 0;
        }

        return $cXphRefAEAmt;

    }
    
    public function FSaMPOGetSUMFCXddDisVatMinusFCXddChgVat($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXphDisVat - FCXphChgVat),0) AS  FCXphDisRes
                 FROM TAPTOrdHDDis HDis ";

        if($ptXphDocNo != ""){
            $tSQL .= "WHERE HDis.FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphDisRes = $oData[0]->FCXphDisRes;
        }else{
        $cXphDisRes = 0;
        }

        return $cXphDisRes;

    }

    public function FSaMPOGetHDFCXphChg($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(HDis.FCXphChgVat+HDis.FCXphChgNoVat),0) AS FCXphChg
                 FROM TAPTOrdHDDis HDis ";

        if($ptXphDocNo != ""){
            $tSQL .= "WHERE HDis.FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXpdChg = $oData[0]->FCXphChg;
        }else{
        $cXpdChg = 0;
        }

        return $cXpdChg;

    }

    public function FSaMPOGetHDFCXphDis($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(HDis.FCXphDisVat+HDis.FCXphDisNoVat),0) AS FCXphDis
                 FROM TAPTOrdHDDis HDis ";

        if($ptXphDocNo != ""){
            $tSQL .= "WHERE HDis.FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphDis = $oData[0]->FCXphDis;
        }else{
        $cXphDis = 0;
        }

        return $cXphDis;

    }

    public function FSaMPOGetHDFCXphNoVatDisChgAvi($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0) AS FCXphNoVatDisChgAvi  
                 FROM TAPTOrdDT ";

        if($ptXphDocNo!= ""){
        $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'
                  AND FTXpdStaAlwDis='1' 
                  AND FTXpdVatType ='2'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphTotal = $oData[0]->FCXphNoVatDisChgAvi;
        }else{
        $cXphTotal = 0;
        }

        return $cXphTotal;

    }

    public function FSaMPOGetHDFTXphDisChgTxt($ptXphDocNo){

        $tSQL = "SELECT FTXphDisChgTxt 
                 FROM TAPTOrdHDDis ";

        if($ptXphDocNo!= ""){
        $tSQL .= " WHERE FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphTotal = $oData;
        }else{
        $cXphTotal = 0;
        }

        return $cXphTotal;

    }

    public function FSaMPOGetHDFCXphVatDisChgAvi($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0) AS FCXphVatDisChgAvi  
                 FROM TAPTOrdDT ";

        if($ptXphDocNo!= ""){
        $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'
                  AND FTXpdStaAlwDis = '1' 
                  AND FTXpdVatType ='1'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphTotal = $oData[0]->FCXphVatDisChgAvi;
        }else{
        $cXphTotal = 0;
        }

        return $cXphTotal;

    }

    public function FSaMPOGetHDFCXphNoVatNoDisChg($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0)AS FCXphNoVatNoDisChg  
                 FROM TAPTOrdDT ";

        if($ptXphDocNo!= ""){
        $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'
                    AND FTXpdStaAlwDis='2' 
                    AND FTXpdVatType ='2'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphTotal = $oData[0]->FCXphNoVatNoDisChg;
        }else{
        $cXphTotal = 0;
        }

        return $cXphTotal;

    }

    public function FSaMPOGetHDFCXphVatNoDisChg($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0)AS FCXphVatNoDisChg  
                 FROM TAPTOrdDT ";

        if($ptXphDocNo!= ""){
        $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'
                  AND FTXpdStaAlwDis='2'
                  AND FTXpdVatType ='1' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
        $oData    = $oQuery->result();
        $cXphTotal = $oData[0]->FCXphVatNoDisChg;
        }else{
        $cXphTotal = 0;
        }

        return $cXphTotal;

    }

    public function FSaMPOGetHDFCXphTotal($ptXphDocNo){

        $tSQL = "SELECT ISNULL(SUM(FCXpdNet),0) AS FCXphTotal
                 FROM TAPTOrdDT 
                ";

        if($ptXphDocNo!= ""){
            $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oData    = $oQuery->result();
            $cXphTotal = $oData[0]->FCXphTotal;
        }else{
            $cXphTotal = 0;
        }

        return $cXphTotal;

    }

    public function FCNxPOGetvatInOrEx($ptXphDocNo){

        $tSQL = "SELECT FTXphVATInOrEx
                 FROM TAPTOrdHD 
                ";

        if($ptXphDocNo!= ""){
            $tSQL .= "WHERE FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $tXphVATInOrEx = $oDetail[0]->FTXphVATInOrEx;
        }else{
            $tXphVATInOrEx = '';
        }

        return $tXphVATInOrEx;
    }


    public function FSaMPOGetRteFacHD($ptXphDocNo){

        $tSQL = "SELECT FCXphRteFac
                 FROM TAPTOrdHD ORDHD
                 WHERE 1 = 1
                ";

        if($ptXphDocNo!= ""){
            $tSQL .= "AND ORDHD.FTXphDocNo = '$ptXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $cXphRteFac = $oDetail[0]->FCXphRteFac;
        }else{
            $cXphRteFac = '';
        }

        return $cXphRteFac;

    }

    public function FSaMPOGetPdtIntoTableDT($paData){

        $tPdtCode   = $paData['FTPdtCode'];
        $FTPunCode   = $paData['FTPunCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT

                    PDT.FTPdtCode,
                    PDT.FTPdtStkControl,
                    PDT.FTPdtGrpControl,
                    PDT.FTPdtForSystem,
                    PDT.FCPdtQtyOrdBuy,
                    PDT.FCPdtCostDef,
                    PDT.FCPdtCostOth,
                    PDT.FCPdtCostStd,
                    PDT.FCPdtMin,
                    PDT.FCPdtMax,
                    PDT.FTPdtPoint,
                    PDT.FCPdtPointTime,
                    PDT.FTPdtType,
                    PDT.FTPdtSaleType,
                    PDT.FTPdtSetOrSN,
                    PDT.FTPdtStaSetPri,
                    PDT.FTPdtStaSetShwDT,
                    PDT.FTPdtStaAlwDis,
                    PDT.FTPdtStaAlwReturn,
                    PDT.FTPdtStaVat,
                    PDT.FTPdtStaActive,
                    PDT.FTPdtStaAlwReCalOpt,
                    PDT.FTPdtStaCsm,
                    PDT.FTShpCode,
                    PDT.FTPdtRefShop,
                    PDT.FTTcgCode,
                    PDT.FTPtyCode,
                    PDT.FTPbnCode,
                    PDT.FTPmoCode,
                    PDT.FTVatCode,
                    PDT.FTEvnCode,
                    PDT.FDPdtSaleStart,
                    PDT.FDPdtSaleStop,

                    PDTL.FTPdtName,
                    PDTL.FTPdtNameOth,
                    PDTL.FTPdtNameABB,
                    PDTL.FTPdtRmk,

                    PKS.FTPunCode,
                    PKS.FCPdtUnitFact,

                    VAT.FCVatRate,
                    
                    UNTL.FTPunName,
                    
                    BAR.FTBarCode,

                    PDTSRL.FTSrnCode,

                    PDT.FCPdtCostStd,
                    CAVG.FCPdtCostEx,
                    CAVG.FCPdtCostIn,
                    SPL.FCSplLastPrice
         
                    
                FROM TCNMPdt PDT
                LEFT JOIN TCNMPdt_L PDTL                ON PDT.FTPdtCode = PDTL.FTPdtCode   AND PDTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtPackSize  PKS          ON PDT.FTPdtCode = PKS.FTPdtCode    AND PKS.FTPunCode = $FTPunCode
                LEFT JOIN TCNMPdtUnit_L UNTL            ON UNTL.FTPunCode = $FTPunCode      AND UNTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtBar BAR                ON PKS.FTPdtCode = BAR.FTPdtCode    AND BAR.FTPunCode = $FTPunCode
                LEFT JOIN (SELECT FTVatCode,FCVatRate,FDVatStart   
                           FROM TCNMVatRate WHERE GETdate()> FDVatStart) VAT
                           ON PDT.FTVatCode=VAT.FTVatCode 
                LEFT JOIN TCNTPdtSerial PDTSRL          ON PDT.FTPdtCode = PDTSRL.FTPdtCode
                LEFT JOIN TCNMPdtSpl SPL                ON PDT.FTPdtCode = SPL.FTPdtCode  AND BAR.FTBarCode = SPL.FTBarCode
                LEFT JOIN TCNMPdtCostAvg CAVG           ON PDT.FTPdtCode = CAVG.FTPdtCode

                WHERE PDT.FTPdtForSystem = '1'
                AND PDT.FTPdtType IN('1','2','4')
                AND PDT.FTPdtStaActive = '1'
                AND SPL.FTSplStaAlwPO = '1'
                -- AND '2018/08/06' Between SPL.FDPdtAlwOrdStart AND SPL.FDPdtAlwOrdStop
                -- AND SPL.FTPdtStaAlwOrdSun='1'
                ";


            if($tPdtCode!= ""){
            $tSQL .= " AND PDT.FTPdtCode = '$tPdtCode'";
            }

            $tSQL .= " ORDER BY FDVatStart DESC";
            
            $oQuery = $this->db->query($tSQL);
            
            if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItem'   => $oDetail[0],
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

    public function FSaMPOGetPdtDetail($paData){

        $tPdtCode   = $paData['FTPdtCode'];
        $FTPunCode   = $paData['FTPunCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT

                    PDT.FTPdtCode,
                    PDT.FTPdtStkControl,
                    PDT.FTPdtGrpControl,
                    PDT.FTPdtForSystem,
                    PDT.FCPdtQtyOrdBuy,
                    PDT.FCPdtCostDef,
                    PDT.FCPdtCostOth,
                    PDT.FCPdtCostStd,
                    PDT.FCPdtMin,
                    PDT.FCPdtMax,
                    PDT.FTPdtPoint,
                    PDT.FCPdtPointTime,
                    PDT.FTPdtType,
                    PDT.FTPdtSaleType,
                    PDT.FTPdtSetOrSN,
                    PDT.FTPdtStaSetPri,
                    PDT.FTPdtStaSetShwDT,
                    PDT.FTPdtStaAlwDis,
                    PDT.FTPdtStaAlwReturn,
                    PDT.FTPdtStaVat,
                    PDT.FTPdtStaActive,
                    PDT.FTPdtStaAlwReCalOpt,
                    PDT.FTPdtStaCsm,
                    PDT.FTShpCode,
                    PDT.FTPdtRefShop,
                    PDT.FTTcgCode,
                    PDT.FTPtyCode,
                    PDT.FTPbnCode,
                    PDT.FTPmoCode,
                    PDT.FTVatCode,
                    PDT.FTEvnCode,
                    PDT.FDPdtSaleStart,
                    PDT.FDPdtSaleStop,

                    PDTL.FTPdtName,
                    PDTL.FTPdtNameOth,
                    PDTL.FTPdtNameABB,
                    PDTL.FTPdtRmk,

                    PDTPCKSZE.FCPdtUnitFact,

                    UNTL.FTPunName,

                    BAR.FTBarCode,

                    PDTSRL.FTSrnCode
                    
                FROM TCNMPdt PDT
                LEFT JOIN TCNMPdt_L PDTL                ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
                LEFT JOIN TCNMPdtPackSize  PDTPCKSZE    ON PDT.FTPdtCode = PDTPCKSZE.FTPdtCode AND PDTPCKSZE.FTPunCode = $FTPunCode
                LEFT JOIN TCNMPdtUnit_L UNTL            ON UNTL.FTPunCode = $FTPunCode
                LEFT JOIN TCNMPdtBar BAR                ON PDT.FTPdtCode = BAR.FTPdtCode AND BAR.FTPunCode = $FTPunCode
                LEFT JOIN TCNTPdtSerial PDTSRL          ON PDT.FTPdtCode = PDTSRL.FTPdtCode 
                WHERE 1=1 ";

            if($tPdtCode!= ""){
            $tSQL .= "AND PDT.FTPdtCode = '$tPdtCode'";
            }

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItem'   => $oDetail[0],
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

    //Functionality : Search Subdistrict By ID
    //Parameters : function parameters
    //Creator : 12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMSDTSearchByID($paData){

        $tSudCode   = $paData['FTSudCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    SDT.FTSudCode       AS rtSudCode,
                    SDT.FTDstCode       AS rtDstCode,
                    DSTL.FTDstName      AS rtDstName,
                    SDT.FTSudLatitude   AS rtSudLatitude,
                    SDT.FTSudLongitude  AS rtSudLongitude,
                    SDTL.FTSudName      AS rtSudName,
                    PVNL.FTPvnCode      AS rtPvnCode,
                    PVNL.FTPvnName      AS rtPvnName
                FROM TCNMSubDistrict SDT
                LEFT JOIN TCNMSubDistrict_L SDTL ON SDT.FTSudCode = SDTL.FTSudCode AND SDTL.FNLngID = $nLngID
                LEFT JOIN TCNMDistrict  DST ON SDT.FTDstCode = DST.FTDstCode
                LEFT JOIN TCNMDistrict_L DSTL ON SDT.FTDstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                LEFT JOIN TCNMProvince_L PVNL ON DST.FTPvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                WHERE 1=1 ";

        if($tSudCode!= ""){
            $tSQL .= "AND SDT.FTSudCode = '$tSudCode'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
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

    //Functionality : Data List Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMPOList($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXphDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT

                                    ORD.FTBchCode,
                                    ORD.FTXphDocNo,
                                    ORD.FTShpCode,
                                    ORD.FNXphDocType,
                                    CONVERT(CHAR(10),ORD.FDXphDocDate,103)   AS FDXphDocDate,
                                    ORD.FTXphCshOrCrd,
                                    ORD.FTXphVATInOrEx,
                                    ORD.FTDptCode,
                                    ORD.FTWahCode,
                                    ORD.FTUsrCode,
                                    ORD.FTXphApvCode,
                                    ORD.FTSplCode,
                                    ORD.FTXphRefExt,
                                    CONVERT(CHAR(10),ORD.FDXphRefExtDate,103)   AS FDXphRefExtDate,
                                    ORD.FTXphRefInt,
                                    CONVERT(CHAR(10),ORD.FDXphRefIntDate,103)   AS FDXphRefIntDate,
                                    ORD.FTXphRefAE,
                                    ORD.FNXphDocPrint,
                                    ORD.FTRteCode,
                                    ORD.FCXphRteFac,
                                    ORD.FTVatCode,
                                    ORD.FCXphVATRate,
                                    ORD.FCXphTotal,
                                    ORD.FCXphVatNoDisChg,
                                    ORD.FCXphNoVatNoDisChg,
                                    ORD.FCXphVatDisChgAvi,
                                    ORD.FCXphNoVatDisChgAvi,
                                    ORD.FCXphDis,
                                    ORD.FCXphChg,
                                    ORD.FCXphRefAEAmt,
                                    ORD.FCXphVatAfDisChg,
                                    ORD.FCXphNoVatAfDisChg,
                                    ORD.FCXphAfDisChgAE,
                                    ORD.FTXphWpCode,
                                    ORD.FCXphVat,
                                    ORD.FCXphVatable,
                                    ORD.FCXphGrandB4Wht,
                                    ORD.FCXphWpTax,
                                    ORD.FCXphGrand,
                                    ORD.FCXphRnd,
                                    ORD.FTXphGndText,
                                    ORD.FCXphPaid,
                                    ORD.FCXphLeft,
                                    ORD.FTXphStaRefund,
                                    ORD.FTXphRmk,
                                    ORD.FTXphStaDoc,
                                    ORD.FTXphStaApv,
                                    ORD.FTXphStaPrcStk,
                                    ORD.FTXphStaPaid,
                                    ORD.FNXphStaDocAct,
                                    ORD.FNXphStaRef,
                                    CONVERT(CHAR(10),ORD.FDLastUpdOn,103)   AS FDLastUpdOn,
                                    ORD.FTLastUpdBy,
                                    ORD.FDCreateOn,
                                    ORD.FTCreateBy,
                                    
                                    BCHL.FTBchName,
                                    SHPL.FTShpName,
                                    SPLL.FTSplName

                            FROM [TAPTOrdHD] ORD
                            LEFT JOIN TCNMBranch_L BCHL ON ORD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                            LEFT JOIN TCNMShop_L   SHPL ON ORD.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = $nLngID 
                            LEFT JOIN TCNMSpl_L    SPLL ON ORD.FTSplCode = SPLL.FTSplCode AND SPLL.FNLngID = $nLngID 
                            
                            WHERE 1=1 ";
        
        @$tSearchList = $paData['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND (ORD.FTXphDocNo LIKE '%$tSearchList%')";
        }

        @$tBchCode = $paData['tBchCode'];
        if(@$tBchCode != ''){
            $tSQL .= " AND (ORD.FTBchCode LIKE '%$tBchCode%')";
        }

        @$tShpCode = $paData['tShpCode'];
        if(@$tShpCode != ''){
            $tSQL .= " AND (ORD.FTShpCode LIKE '%$tShpCode%')";
        }

        @$tXphStaDoc = $paData['tXphStaDoc'];
        if(@$tXphStaDoc != ''){
            $tSQL .= " AND (ORD.FTXphStaDoc LIKE '%$tXphStaDoc%')";
        }

        @$dXphDocDateFrom   = $paData['dXphDocDateFrom'];
        @$dXphDocDateTo     = $paData['dXphDocDateTo'];
        
        if(@$dXphDocDateFrom != ''){
            $tSQL .= " AND(ORD.FDXphDocDate BETWEEN '$dXphDocDateFrom' AND '$dXphDocDateTo')";
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
       
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMPOGetPageAll($tSearchList);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
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
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }


    //Functionality : Search PO By ID
    //Parameters : function parameters
    //Creator : 07/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMPOGetOrdHD($paData){

        $tXphDocNo   = $paData['FTXphDocNo'];
        $nLngID     = $paData['FNLngID'];
        
        $tSQL = "SELECT
                        --TAPTOrdHD
                        ORD.FTBchCode,
                        ORD.FTXphDocNo,
                        ORD.FTShpCode,
                        ORD.FNXphDocType,
                        ORD.FDXphDocDate,
                        ORD.FTXphCshOrCrd,
                        ORD.FTXphVATInOrEx,
                        ORD.FTDptCode,
                        ORD.FTWahCode,
                        ORD.FTUsrCode,
                        ORD.FTXphApvCode,
                        ORD.FTSplCode,
                        ORD.FTXphRefExt,
                        ORD.FDXphRefExtDate,
                        ORD.FTXphRefInt,
                        ORD.FDXphRefIntDate,
                        ORD.FTXphRefAE,
                        ORD.FNXphDocPrint,
                        ORD.FTRteCode,
                        ORD.FCXphRteFac,
                        ORD.FTVatCode,
                        ORD.FCXphVATRate,
                        ORD.FCXphTotal,
                        ORD.FCXphVatNoDisChg,
                        ORD.FCXphNoVatNoDisChg,
                        ORD.FCXphVatDisChgAvi,
                        ORD.FCXphNoVatDisChgAvi,
                        ORD.FCXphDis,
                        ORD.FCXphChg,
                        ORD.FCXphRefAEAmt,
                        ORD.FCXphVatAfDisChg,
                        ORD.FCXphNoVatAfDisChg,
                        ORD.FCXphAfDisChgAE,
                        ORD.FTXphWpCode,
                        ORD.FCXphVat,
                        ORD.FCXphVatable,
                        ORD.FCXphGrandB4Wht,
                        ORD.FCXphWpTax,
                        ORD.FCXphGrand,
                        ORD.FCXphRnd,
                        ORD.FTXphGndText,
                        ORD.FCXphPaid,
                        ORD.FCXphLeft,
                        ORD.FTXphStaRefund,
                        ORD.FTXphRmk,
                        ORD.FTXphStaDoc,
                        ORD.FTXphStaApv,
                        ORD.FTXphStaPrcStk,
                        ORD.FTXphStaPaid,
                        ORD.FNXphStaDocAct,
                        ORD.FNXphStaRef,
                        ORD.FDLastUpdOn,
                        ORD.FTLastUpdBy,
                        ORD.FDCreateOn,
                        ORD.FTCreateBy,

                        --TCNMUsrDepart_L
                        DPTL.FTDptName,

                        --TCNMShop_L
                        SHPL.FTShpName,

                        --TCNMWaHouse_L
                        WAHL.FTWahName,
                        
                        --TCNMSpl_L
                        SPLL.FTSplName,

                        --TAPTOrdHDSpl
                        ORDHDSPL.FTXphDstPaid,
                        ORDHDSPL.FNXphCrTerm,
                        ORDHDSPL.FDXphDueDate,
                        ORDHDSPL.FDXphBillDue,
                        ORDHDSPL.FTXphCtrName,
                        ORDHDSPL.FDXphTnfDate,
                        ORDHDSPL.FTXphRefTnfID,
                        ORDHDSPL.FTXphRefVehID,
                        ORDHDSPL.FTXphRefInvNo,
                        ORDHDSPL.FTXphQtyAndTypeUnit,
                        ORDHDSPL.FNXphShipAdd,
                        ORDHDSPL.FNXphTaxAdd,
                        ORDHDSPL.FTXphDocNo,

                        -- -- TCNMUser_L
                        USRL.FTUsrName,
                        USRAPV.FTUsrName AS FTUsrNameApv

                        -- --TCNMAddress_L
                        -- ADDL.FTAddV1No,
                        -- ADDL.FTAddV1Soi,
                        -- ADDL.FTAddV1Village,
                        -- ADDL.FTAddV1Road,
                        -- ADDL.FTAddV1SubDist,
                        -- ADDL.FTAddV1DstCode,
                        -- ADDL.FTAddV1PvnCode,
                        -- ADDL.FTAddV1PostCode,

                        -- -- TCNMProvince_L
                        -- PVNL.FTPvnName,
                        -- DSTL.FTDstName,
                        -- SUBDSTL.FTSudName



                 FROM [TAPTOrdHD] ORD
             
                 LEFT JOIN TCNMUser_L       USRL    ON ORD.FTCreateBy   = USRL.FTUsrCode AND USRL.FNLngID = $nLngID
                 LEFT JOIN TCNMUser_L       USRAPV  ON ORD.FTXphApvCode = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID

                 LEFT JOIN TCNMUsrDepart_L  DPTL ON ORD.FTDptCode = DPTL.FTDptCode AND DPTL.FNLngID = $nLngID
                 LEFT JOIN TCNMShop_L       SHPL ON ORD.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID = $nLngID
                 LEFT JOIN TCNMWaHouse_L    WAHL ON ORD.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                 LEFT JOIN TCNMSpl_L        SPLL ON ORD.FTSplCode = SPLL.FTSplCode AND SPLL.FNLngID = $nLngID
                 
                 LEFT JOIN TAPTOrdHDSpl ORDHDSPL ON ORD.FTXphDocNo = ORDHDSPL.FTXphDocNo 
                --  LEFT JOIN TCNMAddress_L    ADDL ON ORD.FTBchCode  = ADDL.FTAddRefCode AND ORDHDSPL.FNXphShipAdd = ADDL.FNAddSeqNo AND ADDL.FTAddGrpType = 1 AND ADDL.FNLngID = $nLngID
                --  LEFT JOIN TCNMProvince_L   PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                --  LEFT JOIN TCNMDistrict_L   DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                --  LEFT JOIN TCNMSubDistrict_L SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
                 
                 WHERE 1=1 ";
        
        if($tXphDocNo != ""){
            $tSQL .= "AND ORD.FTXphDocNo = '$tXphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }



    //Functionality : Data List Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMPOGetOrdDT($paData){

        $tXphDocNo = $paData['FTXphDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXphDocNo ASC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                    
                                    ORDDT.FTBchCode,
                                    ORDDT.FTXphDocNo,
                                    ORDDT.FNXpdSeqNo,
                                    ORDDT.FTPdtCode,
                                    ORDDT.FTXpdPdtName,
                                    ORDDT.FTXpdStkCode,
                                    ORDDT.FCXpdStkFac,
                                    ORDDT.FTPunCode,
                                    ORDDT.FTPunName,
                                    ORDDT.FCXpdFactor,
                                    ORDDT.FTXpdBarCode,
                                    ORDDT.FTSrnCode,
                                    ORDDT.FTXpdVatType,
                                    ORDDT.FTVatCode,
                                    ORDDT.FCXpdVatRate,
                                    ORDDT.FTXpdSaleType,
                                    ORDDT.FCXpdSalePrice,
                                    ORDDT.FCXpdQty,
                                    ORDDT.FCXpdQtyAll,
                                    ORDDT.FCXpdSetPrice,
                                    ORDDT.FCXpdAmt,
                                    ORDDT.FCXpdDisChgAvi,
                                    ORDDT.FTXpdDisChgTxt,
                                    ORDDT.FCXpdDis,
                                    ORDDT.FCXpdChg,
                                    ORDDT.FCXpdNet,
                                    ORDDT.FCXpdNetAfHD,
                                    ORDDT.FCXpdNetEx,
                                    ORDDT.FCXpdVat,
                                    ORDDT.FCXpdVatable,
                                    ORDDT.FCXpdWhtAmt,
                                    ORDDT.FTXpdWhtCode,
                                    ORDDT.FCXpdWhtRate,
                                    ORDDT.FCXpdCostIn,
                                    ORDDT.FCXpdCostEx,
                                    ORDDT.FTXpdStaPdt,
                                    ORDDT.FCXpdQtyLef,
                                    ORDDT.FCXpdQtyRfn,
                                    ORDDT.FTXpdStaPrcStk,
                                    ORDDT.FTXpdStaAlwDis,
                                    ORDDT.FNXpdPdtLevel,
                                    ORDDT.FTXpdPdtParent,
                                    ORDDT.FCXpdQtySet,
                                    ORDDT.FTPdtStaSet,
                                    ORDDT.FTXpdRmk,
                                    ORDDT.FDLastUpdOn,
                                    ORDDT.FTLastUpdBy,
                                    ORDDT.FDCreateOn,
                                    ORDDT.FTCreateBy

                            FROM [TAPTOrdDT] ORDDT
                            ";
        
       
        if(@$tXphDocNo != ''){
            $tSQL .= " WHERE (ORDDT.FTXphDocNo = '$tXphDocNo')";
        }
        
        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'rtCode' => '1',
                'raItems'   => $oDetail,
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }


    //Functionality : Data List DT Dis
    //Parameters : function parameters
    //Creator :  03/09/2018 Krit(Copter)
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMPOGetOrdHDDis($paData){

        $tXphDocNo = $paData['FTXphDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tSQL   = "SELECT
                        HDD.FTBchCode,
                        HDD.FTXphDocNo,
                        HDD.FDXphDateIns,
                        HDD.FTXphDisChgTxt,
                        HDD.FNXphStaDis,
                        HDD.FCXphVatDisChgAvi,
                        HDD.FCXphNoVatDisChgAvi,
                        HDD.FCXphDis,
                        HDD.FCXphChg,
                        HDD.FCXphDisVat,
                        HDD.FCXphDisNoVat,
                        HDD.FCXphChgVat,
                        HDD.FCXphChgNoVat,
                        HDD.FTXphUsrApv

                FROM [TAPTOrdHDDis] HDD
                ";
        
       
        if(@$tXphDocNo != ''){
            $tSQL .= " WHERE (HDD.FTXphDocNo = '$tXphDocNo')";
        }

        $tSQL .= " ORDER BY FDXphDateIns ASC";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'OK.',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }


    //Functionality : Data List DT Dis
    //Parameters : function parameters
    //Creator :  03/09/2018 Krit(Copter)
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSaMPOGetOrdDTDis($paData){

        $tXphDocNo = $paData['FTXphDocNo'];

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tSQL   = "SELECT
                        DTD.FTBchCode,
                        DTD.FTXphDocNo,
                        DTD.FNXpdSeqNo,
                        DTD.FDXddDateIns,
                        DTD.FNXpdStaDis,
                        DTD.FCXddDisChgAvi,
                        DTD.FTXddDisChgTxt,
                        DTD.FCXddDis,
                        DTD.FCXddChg,
                        DTD.FTXddUsrApv
                FROM [TAPTOrdDTDis] DTD
                ";
        
       
        if(@$tXphDocNo != ''){
            $tSQL .= " WHERE (DTD.FTXphDocNo = '$tXphDocNo')";
        }

        $tSQL .= " ORDER BY FDXddDateIns ASC";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    }



    //Functionality : All Page Of Subdistrict
    //Parameters : function parameters
    //Creator :  12/06/2018 Wasin
    //Last Modified : -
    //Return : Data Array
    //Return Type : Array
    public function FSnMPOGetPageAll($ptSearchList){

        $tSQL = "SELECT COUNT (ORD.FTXphDocNo) AS counts

                FROM TAPTOrdHD ORD

                WHERE 1=1 ";

        if($ptSearchList != ''){
            $tSQL .= " AND (ORD.FTXphDocNo LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : Chack Data Code Duplicate
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Array Count Data
    //Return Type : Array
    public function FSnMPOCheckDuplicate($ptCode){
        $tSQL = "SELECT COUNT(FTXphDocNo)AS counts
                 FROM TAPTOrdHD
                 WHERE FTXphDocNo = '$ptCode' ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Functionality : Function Add/Update Master
    //Parameters : function parameters
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMPOAddUpdateOrdHD($paData){
        try{
            //Update Master
            $this->db->set('FTBchCode'              , $paData['FTBchCode']);
            $this->db->set('FTShpCode'              , $paData['FTShpCode']);
            $this->db->set('FNXphDocType'           , $paData['FNXphDocType']);
            $this->db->set('FDXphDocDate'           , $paData['FDXphDocDate']);
            $this->db->set('FTXphCshOrCrd'          , $paData['FTXphCshOrCrd']);
            $this->db->set('FTXphVATInOrEx'         , $paData['FTXphVATInOrEx']);
            $this->db->set('FTDptCode'              , $paData['FTDptCode']);
            $this->db->set('FTWahCode'              , $paData['FTWahCode']);
            $this->db->set('FTUsrCode'              , $paData['FTUsrCode']);
            $this->db->set('FTXphApvCode'           , $paData['FTXphApvCode']);
            $this->db->set('FTSplCode'              , $paData['FTSplCode']);
            $this->db->set('FTXphRefExt'            , $paData['FTXphRefExt']);
            $this->db->set('FDXphRefExtDate'        , $paData['FDXphRefExtDate']);
            $this->db->set('FTXphRefInt'            , $paData['FTXphRefInt']);
            $this->db->set('FDXphRefIntDate'        , $paData['FDXphRefIntDate']);
            $this->db->set('FTXphRefAE'             , $paData['FTXphRefAE']);
            $this->db->set('FNXphDocPrint'          , $paData['FNXphDocPrint']);
            $this->db->set('FTRteCode'              , $paData['FTRteCode']);
            $this->db->set('FCXphRteFac'            , $paData['FCXphRteFac']);
            $this->db->set('FTVatCode'              , $paData['FTVatCode']);
            $this->db->set('FCXphVATRate'           , $paData['FCXphVATRate']);
            $this->db->set('FCXphTotal'             , $paData['FCXphTotal']);
            $this->db->set('FCXphVatNoDisChg'       , $paData['FCXphVatNoDisChg']);
            $this->db->set('FCXphNoVatNoDisChg'     , $paData['FCXphNoVatNoDisChg']);
            $this->db->set('FCXphVatDisChgAvi'      , $paData['FCXphVatDisChgAvi']);
            $this->db->set('FCXphNoVatDisChgAvi'    , $paData['FCXphNoVatDisChgAvi']);
            $this->db->set('FCXphDis'               , $paData['FCXphDis']);
            $this->db->set('FCXphChg'               , $paData['FCXphChg']);
            $this->db->set('FCXphRefAEAmt'          , $paData['FCXphRefAEAmt']);
            $this->db->set('FCXphVatAfDisChg'       , $paData['FCXphVatAfDisChg']);
            $this->db->set('FCXphNoVatAfDisChg'     , $paData['FCXphNoVatAfDisChg']);
            $this->db->set('FCXphAfDisChgAE'        , $paData['FCXphAfDisChgAE']);
            $this->db->set('FTXphWpCode'            , $paData['FTXphWpCode']);
            $this->db->set('FCXphVat'               , $paData['FCXphVat']);
            $this->db->set('FCXphVatable'           , $paData['FCXphVatable']);
            $this->db->set('FCXphGrandB4Wht'        , $paData['FCXphGrandB4Wht']);
            $this->db->set('FCXphWpTax'             , $paData['FCXphWpTax']);
            $this->db->set('FCXphGrand'             , $paData['FCXphGrand']);
            $this->db->set('FCXphRnd'               , $paData['FCXphRnd']);
            $this->db->set('FTXphGndText'           , $paData['FTXphGndText']);
            $this->db->set('FCXphPaid'              , $paData['FCXphPaid']);
            $this->db->set('FCXphLeft'              , $paData['FCXphLeft']);
            $this->db->set('FTXphStaRefund'         , $paData['FTXphStaRefund']);
            $this->db->set('FTXphRmk'               , $paData['FTXphRmk']);
            $this->db->set('FTXphStaDoc'            , $paData['FTXphStaDoc']);
            $this->db->set('FTXphStaApv'            , $paData['FTXphStaApv']);
            $this->db->set('FTXphStaPrcStk'         , $paData['FTXphStaPrcStk']);
            $this->db->set('FTXphStaPaid'           , $paData['FTXphStaPaid']);
            $this->db->set('FNXphStaDocAct'         , $paData['FNXphStaDocAct']);
            $this->db->set('FNXphStaRef'            , $paData['FNXphStaRef']);
            $this->db->where('FTXphDocNo'           , $paData['FTXphDocNo']);

            $this->db->update('TAPTOrdHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TAPTOrdHD',array(

                    'FTBchCode'             => $paData['FTBchCode'],
                    'FTXphDocNo'            => $paData['FTXphDocNo'],
                    'FTShpCode'             => $paData['FTShpCode'],
                    'FNXphDocType'          => $paData['FNXphDocType'],
                    'FDXphDocDate'          => $paData['FDXphDocDate'],
                    'FTXphCshOrCrd'         => $paData['FTXphCshOrCrd'],
                    'FTXphVATInOrEx'        => $paData['FTXphVATInOrEx'],
                    'FTDptCode'             => $paData['FTDptCode'],
                    'FTWahCode'             => $paData['FTWahCode'],
                    'FTUsrCode'             => $paData['FTUsrCode'],
                    'FTXphApvCode'          => $paData['FTXphApvCode'],
                    'FTSplCode'             => $paData['FTSplCode'],
                    'FTXphRefExt'           => $paData['FTXphRefExt'],
                    'FDXphRefExtDate'       => $paData['FDXphRefExtDate'],
                    'FTXphRefInt'           => $paData['FTXphRefInt'],
                    'FDXphRefIntDate'       => $paData['FDXphRefIntDate'],
                    'FTXphRefAE'            => $paData['FTXphRefAE'],
                    'FNXphDocPrint'         => $paData['FNXphDocPrint'],
                    'FTRteCode'             => $paData['FTRteCode'],
                    'FCXphRteFac'           => $paData['FCXphRteFac'],
                    'FTVatCode'             => $paData['FTVatCode'],
                    'FCXphVATRate'          => $paData['FCXphVATRate'],
                    'FCXphTotal'            => $paData['FCXphTotal'],
                    'FCXphVatNoDisChg'      => $paData['FCXphVatNoDisChg'],
                    'FCXphNoVatNoDisChg'    => $paData['FCXphNoVatNoDisChg'],
                    'FCXphVatDisChgAvi'     => $paData['FCXphVatDisChgAvi'],
                    'FCXphNoVatDisChgAvi'   => $paData['FCXphNoVatDisChgAvi'],
                    'FCXphDis'              => $paData['FCXphDis'],
                    'FCXphChg'              => $paData['FCXphChg'],
                    'FCXphRefAEAmt'         => $paData['FCXphRefAEAmt'],
                    'FCXphVatAfDisChg'      => $paData['FCXphVatAfDisChg'],
                    'FCXphNoVatAfDisChg'    => $paData['FCXphNoVatAfDisChg'],
                    'FCXphAfDisChgAE'       => $paData['FCXphAfDisChgAE'],
                    'FTXphWpCode'           => $paData['FTXphWpCode'],
                    'FCXphVat'              => $paData['FCXphVat'],
                    'FCXphVatable'          => $paData['FCXphVatable'],
                    'FCXphGrandB4Wht'       => $paData['FCXphGrandB4Wht'],
                    'FCXphWpTax'            => $paData['FCXphWpTax'],
                    'FCXphGrand'            => $paData['FCXphGrand'],
                    'FCXphRnd'              => $paData['FCXphRnd'],
                    'FTXphGndText'          => $paData['FTXphGndText'],
                    'FCXphPaid'             => $paData['FCXphPaid'],
                    'FCXphLeft'             => $paData['FCXphLeft'],
                    'FTXphStaRefund'        => $paData['FTXphStaRefund'],
                    'FTXphRmk'              => $paData['FTXphRmk'],
                    'FTXphStaDoc'           => $paData['FTXphStaDoc'],
                    'FTXphStaApv'           => $paData['FTXphStaApv'],
                    'FTXphStaPrcStk'        => $paData['FTXphStaPrcStk'],
                    'FTXphStaPaid'          => $paData['FTXphStaPaid'],
                    'FNXphStaDocAct'        => $paData['FNXphStaDocAct'],
                    'FNXphStaRef'           => $paData['FNXphStaRef'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy']

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
            return $Error;
        }
    }


    //Update HD After process  
    public function FSaMPOUpdateOrdHD($paData,$paWhere){

        try{
            //DT Dis
            $this->db->set('FCXphTotal' , $paData['FCXphTotal']);
            $this->db->set('FCXphVatNoDisChg' , $paData['FCXphVatNoDisChg']);
            $this->db->set('FCXphNoVatNoDisChg' , $paData['FCXphNoVatNoDisChg']);
            $this->db->set('FCXphVatDisChgAvi' , $paData['FCXphVatDisChgAvi']);
            $this->db->set('FCXphNoVatDisChgAvi' , $paData['FCXphNoVatDisChgAvi']);
            $this->db->set('FTXphDisChgTxt' , $paData['FTXphDisChgTxt']);
            $this->db->set('FCXphDis' , $paData['FCXphDis']);
            $this->db->set('FCXphChg' , $paData['FCXphChg']);
            $this->db->set('FCXphRefAEAmt' , $paData['FCXphRefAEAmt']);
            $this->db->set('FCXphVatAfDisChg' , $paData['FCXphVatAfDisChg']);
            $this->db->set('FCXphNoVatAfDisChg' , $paData['FCXphNoVatAfDisChg']);
            $this->db->set('FCXphAfDisChgAE' , $paData['FCXphAfDisChgAE']);
            $this->db->set('FTXphWpCode' , $paData['FTXphWpCode']);
            $this->db->set('FCXphVat' , $paData['FCXphVat']);
            $this->db->set('FCXphVatable' , $paData['FCXphVatable']);
            $this->db->set('FCXphGrandB4Wht' , $paData['FCXphGrandB4Wht']);
            // $this->db->set('FCXphWpTax' , $paData['FCXphWpTax']);
            $this->db->set('FCXphGrand' , $paData['FCXphGrand']);
            $this->db->set('FTXphGndText' , $paData['FTXphGndText']);
            $this->db->set('FCXphLeft' , $paData['FCXphLeft']);

            $this->db->where('FTXphDocNo', $paWhere['FTXphDocNo']);
            $this->db->update('TAPTOrdHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update HD.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Update HD.',
                );
            }
            return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }

    }


    //Functionality : Function Add/Update OrdHDSpl
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMPOAddUpdateOrdHDSpl($paData){

        try{
            //Update Master
            $this->db->set('FTBchCode'              , $paData['FTBchCode']);
            $this->db->set('FTXphDstPaid'           , $paData['FTXphDstPaid']);
            $this->db->set('FNXphCrTerm'            , $paData['FNXphCrTerm']);
            $this->db->set('FDXphDueDate'           , $paData['FDXphDueDate']);
            $this->db->set('FDXphBillDue'           , $paData['FDXphBillDue']);
            $this->db->set('FTXphCtrName'           , $paData['FTXphCtrName']);
            $this->db->set('FDXphTnfDate'           , $paData['FDXphTnfDate']);
            $this->db->set('FTXphRefTnfID'          , $paData['FTXphRefTnfID']);
            $this->db->set('FTXphRefVehID'          , $paData['FTXphRefVehID']);
            $this->db->set('FTXphRefInvNo'          , $paData['FTXphRefInvNo']);
            $this->db->set('FTXphQtyAndTypeUnit'    , $paData['FTXphQtyAndTypeUnit']);
            $this->db->set('FNXphShipAdd'           , $paData['FNXphShipAdd']);
            $this->db->set('FNXphTaxAdd'            , $paData['FNXphTaxAdd']);
            $this->db->where('FTXphDocNo'           , $paData['FTXphDocNo']);
            $this->db->update('TAPTOrdHDSpl');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TAPTOrdHDSpl',array(

                    'FTBchCode'             => $paData['FTBchCode'],
                    'FTXphDstPaid'             => $paData['FTXphDstPaid'],
                    'FTXphDocNo'            => $paData['FTXphDocNo'],
                    'FNXphCrTerm'           => $paData['FNXphCrTerm'],
                    'FDXphDueDate'          => $paData['FDXphDueDate'],
                    'FDXphBillDue'          => $paData['FDXphBillDue'],
                    'FTXphCtrName'          => $paData['FTXphCtrName'],
                    'FDXphTnfDate'          => $paData['FDXphTnfDate'],
                    'FTXphRefTnfID'         => $paData['FTXphRefTnfID'],
                    'FTXphRefVehID'         => $paData['FTXphRefVehID'],
                    'FTXphRefInvNo'         => $paData['FTXphRefInvNo'],
                    'FTXphQtyAndTypeUnit'   => $paData['FTXphQtyAndTypeUnit'],
                    'FNXphShipAdd'          => $paData['FNXphShipAdd'],
                    'FNXphTaxAdd'           => $paData['FNXphTaxAdd']

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
            return $Error;
        }
    }


    //Functionality : Function Add/Update OrdHDDis
    //Parameters : function parameters
    //Creator : 12/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMPOAddUpdateOrdHDDis($paData){

        //Add Master
        $this->db->insert('TAPTOrdHDDis',array(

            'FTBchCode'             => $paData['FTBchCode'],
            'FTXphDocNo'            => $paData['FTXphDocNo'],
            'FDXphDateIns'          => $paData['FDXphDateIns'],
            'FTXphDisChgTxt'        => $paData['FTXphDisChgTxt'],
            'FNXphStaDis'           => $paData['FNXphStaDis'],
            'FCXphVatDisChgAvi'     => $paData['FCXphVatDisChgAvi'],
            'FCXphNoVatDisChgAvi'   => $paData['FCXphNoVatDisChgAvi'],
            'FCXphDis'              => $paData['FCXphDis'],
            'FCXphChg'              => $paData['FCXphChg'],
            'FCXphDisVat'           => $paData['FCXphDisVat'],
            'FCXphDisNoVat'         => $paData['FCXphDisNoVat'],
            'FCXphChgVat'           => $paData['FCXphChgVat'],
            'FCXphChgNoVat'         => $paData['FCXphChgNoVat'],
            'FTXphUsrApv'           => $paData['FTXphUsrApv'],

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

    //Functionality : Function Add/Update OrdDT
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMPOAddUpdateOrdDT($paData){

                //Add Master
                $this->db->insert('TAPTOrdDT',array(

                    'FTBchCode'             => $paData['FTBchCode'],
                    'FTXphDocNo'            => $paData['FTXphDocNo'],
                    'FNXpdSeqNo'            => $paData['FNXpdSeqNo'],
                    'FTPdtCode'             => $paData['FTPdtCode'],
                    'FTXpdPdtName'          => $paData['FTXpdPdtName'],
                    'FTXpdStkCode'          => $paData['FTXpdStkCode'],
                    'FCXpdStkFac'           => $paData['FCXpdStkFac'],
                    'FTPunCode'             => $paData['FTPunCode'],
                    'FTPunName'             => $paData['FTPunName'],
                    'FCXpdFactor'           => $paData['FCXpdFactor'],
                    'FTXpdBarCode'          => $paData['FTXpdBarCode'],
                    'FTSrnCode'             => $paData['FTSrnCode'],
                    'FTXpdVatType'          => $paData['FTXpdVatType'],
                    'FTVatCode'             => $paData['FTVatCode'],
                    'FCXpdVatRate'          => $paData['FCXpdVatRate'],
                    'FTXpdSaleType'         => $paData['FTXpdSaleType'],
                    'FCXpdSalePrice'        => $paData['FCXpdSalePrice'],
                    'FCXpdQty'              => $paData['FCXpdQty'],
                    'FCXpdQtyAll'           => $paData['FCXpdQtyAll'],
                    'FCXpdSetPrice'         => $paData['FCXpdSetPrice'],
                    'FCXpdAmt'              => $paData['FCXpdAmt'],
                    'FCXpdDisChgAvi'        => $paData['FCXpdDisChgAvi'],
                    'FTXpdDisChgTxt'        => $paData['FTXpdDisChgTxt'],
                    'FCXpdDis'              => $paData['FCXpdDis'],
                    'FCXpdChg'              => $paData['FCXpdChg'],
                    'FCXpdNet'              => $paData['FCXpdNet'],
                    'FCXpdNetAfHD'          => $paData['FCXpdNetAfHD'],
                    'FCXpdNetEx'            => $paData['FCXpdNetEx'],
                    'FCXpdVat'              => $paData['FCXpdVat'],
                    'FCXpdVatable'          => $paData['FCXpdVatable'],
                    'FCXpdWhtAmt'           => $paData['FCXpdWhtAmt'],
                    'FTXpdWhtCode'          => $paData['FTXpdWhtCode'],
                    'FCXpdWhtRate'          => $paData['FCXpdWhtRate'],
                    'FCXpdCostIn'           => $paData['FCXpdCostIn'],
                    'FCXpdCostEx'           => $paData['FCXpdCostEx'],
                    'FTXpdStaPdt'           => $paData['FTXpdStaPdt'],
                    'FCXpdQtyLef'           => $paData['FCXpdQtyLef'],
                    'FCXpdQtyRfn'           => $paData['FCXpdQtyRfn'],
                    'FTXpdStaPrcStk'        => $paData['FTXpdStaPrcStk'],
                    'FTXpdStaAlwDis'        => $paData['FTXpdStaAlwDis'],
                    'FNXpdPdtLevel'         => $paData['FNXpdPdtLevel'],
                    'FTXpdPdtParent'        => $paData['FTXpdPdtParent'],
                    'FCXpdQtySet'           => $paData['FCXpdQtySet'],
                    'FTPdtStaSet'           => $paData['FTPdtStaSet'],
                    'FTXpdRmk'              => $paData['FTXpdRmk'],
                    'FDLastUpdOn'           => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'           => $paData['FTLastUpdBy'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy']


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


    //Functionality : Function Update OrdDT DisChgTxt,Dis,Chg
    //Parameters : function parameters
    //Creator : 05/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Update Master
    //Return Type : array
    public function FSaMPOUpdateOrdDT($paData,$paWhere){

            try{
                //DT Dis
                $this->db->set('FTXpdDisChgTxt' , $paData['FTXpdDisChgTxt']);
                $this->db->set('FCXpdDis' , $paData['FCXpdDis']);
                $this->db->set('FCXpdChg' , $paData['FCXpdChg']);
                $this->db->set('FCXpdNet' , $paData['FCXpdNet']);
                $this->db->set('FCXpdNetAfHD' , $paData['FCXpdNetAfHD']);
                $this->db->set('FCXpdVat' , $paData['FCXpdVat']);
                $this->db->set('FCXpdVatable' , $paData['FCXpdVatable']);
                $this->db->set('FCXpdWhtAmt' , $paData['FCXpdWhtAmt']);
                $this->db->set('FCXpdCostIn' , $paData['FCXpdCostIn']);
                $this->db->set('FCXpdCostEx' , $paData['FCXpdCostEx']);
                $this->db->set('FCXpdQtyLef' , $paData['FCXpdQtyLef']);
                $this->db->set('FCXpdNetEx' , $paData['FCXpdNetEx']);

                $this->db->where('FTXphDocNo', $paWhere['FTXphDocNo']);
                $this->db->where('FNXpdSeqNo', $paWhere['FNXpdSeqNo']);
                $this->db->update('TAPTOrdDT');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update DT.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '903',
                        'rtDesc' => 'Not Update DT.',
                    );
                }
                return $aStatus;
            }catch(Exception $Error){
                return $Error;
            }

    }


    //Functionality : Function Add/Update TAPTOrdDTDis
    //Parameters : function parameters
    //Creator : 03/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add/Update Master
    //Return Type : array
    public function FSaMPOAddUpdateOrdDTDis($paData){

            //Add Master
            $this->db->insert('TAPTOrdDTDis',array(

                'FTBchCode'             => $paData['FTBchCode'],
                'FTXphDocNo'            => $paData['FTXphDocNo'],
                'FNXpdSeqNo'            => $paData['FNXpdSeqNo'],
                'FDXddDateIns'          => $paData['FDXddDateIns'],
                'FNXpdStaDis'           => $paData['FNXpdStaDis'],
                'FCXddDisChgAvi'        => $paData['FCXddDisChgAvi'],
                'FTXddDisChgTxt'        => $paData['FTXddDisChgTxt'],
                'FCXddDis'              => $paData['FCXddDis'],
                'FCXddChg'              => $paData['FCXddChg'],
                'FTXddUsrApv'           => $paData['FTXddUsrApv']

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


    //Functionality : Delete DT
    //Parameters : function parameters
    //Creator : 17/07/2018 Krit
    //Return : response
    //Return Type : array
    public function FSnMPMTDelPcoDT($ptXphDocNo){

        $this->db->where_in('FTXphDocNo', $ptXphDocNo);
        $this->db->delete('TAPTOrdDT');

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


    //Functionality : Delete DT Dis
    //Parameters : function parameters
    //Creator : 17/07/2018 Krit
    //Return : response
    //Return Type : array
    public function FSnMPMTDelPcoDTDis($ptXphDocNo){

        $this->db->where_in('FTXphDocNo', $ptXphDocNo);
        $this->db->delete('TAPTOrdDTDis');

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


    //Functionality : Delete DT Dis
    //Parameters : function parameters
    //Creator : 17/07/2018 Krit
    //Return : response
    //Return Type : array
    public function FSnMPMTDelPcoHDDis($ptXphDocNo){

        $this->db->where_in('FTXphDocNo', $ptXphDocNo);
        $this->db->delete('TAPTOrdHDDis');

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


    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  12/06/2018 wasin
    //Last Modified : -
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMSDTAddUpdateLang($paData){
        try{
            //Update Lang
            $this->db->set('FTSudName' , $paData['FTSudName']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTSudCode', $paData['FTSudCode']);
            $this->db->update('TCNMSubDistrict_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{
                //Add Lang
                $this->db->insert('TCNMSubDistrict_L',array(
                    'FTSudCode' => $paData['FTSudCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTSudName' => $paData['FTSudName']
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
            return $Error;
        }
    }

    //Functionality : Delete PurchaseOrder
    //Parameters : function parameters
    //Creator : 29/08/2018 Krit(Copter)
    //Last Modified : -
    //Return : Array Status Delete
    //Return Type : array
    public function FSnMPODel($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->delete('TAPTOrdDT');

            $this->db->where_in('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->delete('TAPTOrdDTDis');

            $this->db->where_in('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->delete('TAPTOrdHD');
            
            $this->db->where_in('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->delete('TAPTOrdHDDis');

            $this->db->where_in('FTXphDocNo', $paData['FTXphDocNo']);
            $this->db->delete('TAPTOrdHDSpl');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }



    public function FSnMPOGetDocType($ptTableName){

        $tSQL = "SELECT FNSdtDocType FROM TSysDocType WHERE FTSdtTblName='$ptTableName'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $nDetail = $oDetail[0]->FNSdtDocType;
          
        }else{
            $nDetail = '';
        }

        return $nDetail;
       
    }


    



}