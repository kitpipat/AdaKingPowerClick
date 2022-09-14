<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mChkSaleOrderApprove extends CI_Model {

    //Functionality : Get Data ChkSaleOrderApprove
    //Parameters : function parameters
    //Creator : 22/01/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCHKSoGetDetailData($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tBchCode       = $paData['FTBchCode'];
            $dDateNow       = date('Y-m-d H:i:s');
            $tUserCode      = $this->session->userdata('tSesUsername');

            $aAdvanceSearch         = $paData['aAdvanceSearch'];
            $aDatSessionUserLogIn   = $paData['aDatSessionUserLogIn'];

            // Advance Search
            $tSearchBchCodeSlt    = $aAdvanceSearch['oetChkBchCodeSelect'];
            $tSearchMerCodeSlt    = $aAdvanceSearch['oetChkMerCodeSelect'];
            $tSearchShpCodeSlt    = $aAdvanceSearch['oetChkShpCodeSelect'];
            $tSearchWahCodeSlt    = $aAdvanceSearch['oetChkWahCodeSelect'];

            $tSQL  = " SELECT
                            TARTSoHD.FTBchCode,
                            TARTSoHD.FTWahCode,
                            TARTSoHD.FTShpCode,
                            TARTSoHD.FTCstCode,
                            TARTSoHD.FTXshDocNo,
                            TARTSoHD.FTXshRefExt,
                            TARTSoHD.FTDptCode, 
                            DPL.FTDptName,
                            TARTSoHD.FNXshDocType,
                            TARTSoHD.FDXshDocDate,
                            TARTSoHDCst.FTXshCstName,
                            TARTSoHDCst.FTXshCstTel,
                        (
                            SELECT
                                MAX (FNDatApvSeq)+1
                            FROM
                                TARTDocApvTxn WITH(NOLOCK)
                            WHERE
                                TARTDocApvTxn.FTBchCode = TARTSoHD.FTBchCode
                            AND TARTDocApvTxn.FTDatRefCode = TARTSoHD.FTXshDocNo
                            AND TARTDocApvTxn.FTDatUsrApv IS NOT NULL
                            GROUP BY
                                TARTDocApvTxn.FTDatRefCode
                        ) AS LastSeq,
                            TCNMDocApvRole.FTDarUsrRole,
                        DOCTNX.FTDatStaPrc,
                        DATEADD(
                            MINUTE,
                            15,
                            DOCTNX.FDLastUpdOn
                        ) AS ExpDateLast
                    FROM
                        TARTSoHD WITH(NOLOCK)
                    LEFT OUTER JOIN TARTSoHDCst ON TARTSoHD.FTXshDocNo = TARTSoHDCst.FTXshDocNo AND TARTSoHD.FTBCHCode = TARTSoHDCst.FTBchCode
                    LEFT OUTER JOIN TCNMDocApvRole ON (
                        SELECT
                            MAX (FNDatApvSeq) + 1
                        FROM
                            TARTDocApvTxn WITH(NOLOCK)
                        WHERE
                            TARTDocApvTxn.FTBchCode = TARTSoHD.FTBchCode
                        AND TARTDocApvTxn.FTDatRefCode = TARTSoHD.FTXshDocNo
                        AND TARTDocApvTxn.FTDatUsrApv IS NOT NULL
                        GROUP BY
                            TARTDocApvTxn.FTDatRefCode
                    ) = TCNMDocApvRole.FNDarApvSeq
                    LEFT OUTER JOIN TARTDocApvTxn DOCTNX ON TARTSoHD.FTXshDocNo = DOCTNX.FTDatRefCode AND TARTSoHD.FTBCHCode = TARTSoHDCst.FTBchCode
                    AND DOCTNX.FNDatApvSeq = (
                        SELECT
                            MAX (FNDatApvSeq) + 1
                        FROM
                            TARTDocApvTxn DOCTNXSub WITH(NOLOCK)
                        WHERE
                            DOCTNXSub.FTBchCode = TARTSoHD.FTBchCode
                        AND DOCTNXSub.FTDatRefCode = TARTSoHD.FTXshDocNo
                        AND DOCTNXSub.FTDatUsrApv IS NOT NULL
                        GROUP BY
                            DOCTNXSub.FTDatRefCode
                    )
                    AND TCNMDocApvRole.FTDarTable = 'TARTSoHD'
                    LEFT OUTER JOIN TSysConfig TCF ON TCF.FTSysCode='tVD_DocApprove'
                    LEFT JOIN TCNMUsrDepart_L DPL ON DPL.FTDptCode = TARTSoHD.FTDptCode
                    WHERE
                        1 = 1
                        AND FTDarTable = 'TARTSoHD'
                    AND ((
                        DOCTNX.FTDatStaPrc IS NULL
                        AND DOCTNX.FTDatUsrApv IS NULL
                    )
                    OR (
                        DOCTNX.FTDatStaPrc = 2
                        AND DATEADD(
                            MINUTE,
                            CONVERT(INT,TCF.FTSysStaUsrValue),
                            DOCTNX.FDLastUpdOn
                        ) <= '$dDateNow'
                    )
                    OR (
                        DOCTNX.FTLastUpdBy = '$tUserCode'
                        AND  DOCTNX.FTDatStaPrc = 2
                    )
                    )
                    ";

            // ค้นหาจาก Branch (สาขา)
            if(!empty($tSearchBchCodeSlt) && !empty($tSearchBchCodeSlt)){
                $tSQL .= " AND TARTSoHD.FTBchCode = $tSearchBchCodeSlt OR $tSearchBchCodeSlt = ''";
            }

            // ค้นหาจาก MerChant (กลุ่มธุรกิจ)
            if(!empty($tSearchMerCodeSlt) && !empty($tSearchMerCodeSlt)){
                $tSQL .= " AND TARTSoHD.FTShpCode = $tSearchMerCodeSlt OR $tSearchMerCodeSlt = ''";
            }

            //ค้นหาจาก Shop (ร้านค้า)
            if(!empty($tSearchShpCodeSlt) && !empty($tSearchShpCodeSlt)){
                $tSQL .= " AND TARTSoHD.FTShpCode = $tSearchShpCodeSlt OR $tSearchShpCodeSlt = ''";
            }

            //ค้นหาจาก Wahourse (คลังสินค้า)
            if(!empty($tSearchWahCodeSlt) && !empty($tSearchWahCodeSlt)){
                $tSQL .= "AND TARTSoHD.FTWahCode = $tSearchWahCodeSlt OR $tSearchWahCodeSlt = ''";
            }

            $tSQL .= " ORDER BY TARTSoHD.FTXshDocNo  ASC";

            //check Order BY DocNO
            
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail    = $oQuery->result();
                $aResult= array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //if data not found
                $aResult    = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found',
                );
            }    
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality GetTimeMonitorCountDown
    //Parameters : function parameters
    // Create -
    // Return data
    // public function
    public function FSnMCHKSoGetTimeMonitorCountDown(){

        $dStandrad = date('Y-m-d 17:39:00');
        $dDateTimeNow = date('Y-m-d H:i:s');
        
        if($dDateTimeNow>$dStandrad){
            $dStandrad  = date('Y-m-d 17:39:00',strtotime("+1 day"));
        }
    
        $tSql = " SELECT DATEDIFF(SECOND, '$dDateTimeNow', '$dStandrad') AS SecondDiff ";
        $oQuery = $this->db->query($tSql);
        $reustl =  $oQuery->row_array();
        return  $reustl['SecondDiff'];
    
    }


    // Functionality GetDataloop
    // Parameters : function parameters
    // Create Witsarut (Bell) 14/02/2020
    // Return data
    // public function
    public function FSaMCHKSoGetdataloop($paData){
            $nLangEdit = $this->session->userdata("tLangEdit");

            if($nLangEdit==1){
                $tFildName = 'FTDapName';
            }else{
                $tFildName = 'FTDapNameOth';
            }

            $tSQL  = "SELECT 
                       APVRol.FNDarApvSeq,
                       APVDoc.$tFildName AS FTDapName
                    FROM TCNMDocApvRole APVRol WITH(NOLOCK)
                    LEFT JOIN TSysDocApv APVDoc ON FNDarApvSeq = APVDoc.FNDapSeq AND FTDapTable = 'TARTSoHD' 
                    WHERE APVRol.FNDarApvSeq > 1  AND FTDarTable = 'TARTSoHD' AND FNDapStaUse = 1
                    ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                return $oQuery->result_array();
            }else{
                return false;
            }
    }

    // Functionality Count Seq
    // Create Witsarut 6/02/2020
    public function FSaMCHKSoCountSeq(){
        $tSQL = "SELECT 
                    COUNT (APVRol.FNDarApvSeq) AS counts
                FROM TCNMDocApvRole APVRol WITH(NOLOCK)
                WHERE 1=1  AND FTDarTable = 'TARTSoHD' ";
                 $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result_array();
            }else{
                return false;
            }
    }

    


}