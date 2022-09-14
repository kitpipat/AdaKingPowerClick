<?php
use MongoDB\Operation\Count;

// Functionality: Calcurete Doc DT Temp
// Parameters:  Function Parameter
// Creator: 18/06/2019 Wasin (Yoshi Aka: Mr. JW)
// Last Modified : 01/07/2019 Wasin (Yoshi Aka: Mr. JW)
// Return : true = Success , false = Error
// Return Type: boolean
function FCNbHCallCalcDocDTTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $ci->db->trans_begin();
        $bStaUpdateDT           = FCNbHUpdateDocDTTemp($paParams);
        $bStaUpdateDisChgText   = FCNbHUpdateDocDTDisChgText($paParams);
    if($ci->db->trans_status() === FALSE){
        $ci->db->trans_rollback();
        return false;
    }else{
        $ci->db->trans_commit();
        return true;
    }
}

// Functionality: Updaet And Calcurete Doc DT Temp
// Parameters:  Function Parameter
// Creator: 01/07/2019 Wasin (Yoshi Aka: Mr. JW)
// Return : true = Success , false = Error
// Return Type: boolean
function FCNbHUpdateDocDTTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();
    /** Document Event Call
        * 1 => มีการเปลี่ยนแปลงจำนวน Qty ในตาราง DocDTTemp
        * 2 => มีการเปลี่ยนแปลงราคา ในตาราง DocDTTemp
        * 3 => มีการเพิ่มหรือแก้ไขส่วนลดรายการสินค้าจะทำการ คำนวณในรายการสินค้าใหม่
        * 4 => มีการเพิ่มส่วนลดท้ายบิลจะทำการคำนวณหลังจาก Pro-Rate
        * Null And ค่าว่าง  => Calc Rate รายการทั้งหมด ของ DocDTTemp
    */
    $tDataDocEvnCall    = $paParams['tDataDocEvnCall'];
    $tDataVatInOrEx     = $paParams['tDataVatInOrEx'];
    $tDataDocNo         = $paParams['tDataDocNo'];
    $tDataDocKey        = $paParams['tDataDocKey'];
    $tDataSeqNo         = $paParams['tDataSeqNo'];

    if(!empty($ci->session->userdata("tSesSessionID"))){
        $tDataSessionID     = $ci->session->userdata("tSesSessionID");
    }else{
        $tDataSessionID    = $ci->input->post("ohdSesSessionID");
        $tSesUsername   = $ci->input->post("ohdSOUsrCode");
        $tSesBCH        = $ci->input->post("ohdSOSesUsrBchCode");  
    }
   


    // Check Branch Code Login
    // $tSesUsrBchCode     = $ci->session->userdata("tSesUsrBchCode");
    // $tSesUsrBchCom      = $ci->session->userdata("tSesUsrBchCom");
    // if(isset($tSesUsrBchCode) && !empty($tSesUsrBchCode)){
    //     $tDataBchCode   = $tSesUsrBchCode;
    // }else{
    //     $tDataBchCode   = $tSesUsrBchCom;
    // }

    if(empty($paParams['tBchCode'])){
        if(!empty($ci->session->userdata("tSesUsrBchCode"))){
        $tSesUsrBchCode     = $ci->session->userdata("tSesUsrBchCode");
        $tSesUsrBchCom      = $ci->session->userdata("tSesUsrBchCom");
        if(isset($tSesUsrBchCode) && !empty($tSesUsrBchCode)){
            $tDataBchCode   = $tSesUsrBchCode;
        }else{
            $tDataBchCode   = $tSesUsrBchCom;
        }
    }else{
        $tDataBchCode   = $ci->input->post("ohdSOSesUsrBchCode");
    }
    }else{
        $tDataBchCode = $paParams['tBchCode'];
    }

    /** Check Vat Incluve And Excluve
     *  1 = Vat Inclusive
     *  2 = Vat Exclusive
    */
    if(isset($tDataVatInOrEx) && !empty($tDataVatInOrEx) && $tDataVatInOrEx == 1){
        // Vat
        $tSQLVatInOrEx  = " DocDTUpd.FCXtdVat       = DocDTSlt.FCXtdVatIn,
                            DocDTUpd.FCXtdVatable   = DocDTSlt.FCXtdVatTableIn, ";
                            
        // Cost
        $tSQLCostInOrEx = " DocDTUpd.FCXtdCostIn    = DocDTSlt.FCXtdCostInVatIn,
                            DocDTUpd.FCXtdCostEx    = DocDTSlt.FCXtdCostExVatIn ";
                        
    }else if(isset($tDataVatInOrEx) && !empty($tDataVatInOrEx) && $tDataVatInOrEx == 2){
        // Vat
        $tSQLVatInOrEx  = " DocDTUpd.FCXtdVat       = DocDTSlt.FCXtdVatEx,
                            DocDTUpd.FCXtdVatable   = DocDTSlt.FCXtdVatTableEx, ";
        // Cost
        $tSQLCostInOrEx = " DocDTUpd.FCXtdCostIn    = DocDTSlt.FCXtdCostInVatEx,
                            DocDTUpd.FCXtdCostEx    = DocDTSlt.FCXtdCostExVatEx
        ";

    }else{
        $tSQLVatInOrEx  = "";
        $tSQLCostInOrEx = "";
    }


    /** Check Seq No By Edit In Line */
    $tSQLWhereSeqDT     = "";
    $tSQLWhereSeqDis    = "";
    if(isset($tDataSeqNo) && !empty($tDataSeqNo)){
        $tSQLWhereSeqDT     = " AND DTTemp.FNXtdSeqNo = '".$tDataSeqNo."'";
        $tSQLWhereSeqDis    = " AND TCNTDocDTDisTmp.FNXtdSeqNo = '".$tDataSeqNo."'";
    }

    $tSQL   = " UPDATE DocDTUpd
                SET
                    DocDTUpd.FCXtdQtyAll        = DocDTSlt.FCXtdQtyAll,
                    DocDTUpd.FCXtdAmt           = DocDTSlt.FCXtdAmtB4DisChg,
                    DocDTUpd.FCXtdAmtB4DisChg   = DocDTSlt.FCXtdAmtB4DisChg,
                    DocDTUpd.FCXtdDis           = abs(DocDTSlt.FCXtdDis),
                    DocDTUpd.FCXtdChg           = abs(DocDTSlt.FCXtdChg),
                    DocDTUpd.FCXtdNet           = DocDTSlt.FCXtdNet,
                    DocDTUpd.FCXtdNetAfHD       = DocDTSlt.FCXtdNetAfHD,
                    ".$tSQLVatInOrEx."
                    ".$tSQLCostInOrEx."
                FROM TCNTDocDTTmp DocDTUpd WITH (NOLOCK)
                INNER JOIN (
                    SELECT
                        DataB4CalcCost.*,
                        (DataB4CalcCost.FCXtdNetAfHD - DataB4CalcCost.FCXtdVatIn) AS FCXtdVatTableIn,
                        DataB4CalcCost.FCXtdNetAfHD AS FCXtdVatTableEx,
                        ((DataB4CalcCost.FCXtdNetAfHD - DataB4CalcCost.FCXtdVatIn)*ISNULL(DataB4CalcCost.FCXtdWhtRate,0)) AS FCXtdWhtAmtIn,
                        ((DataB4CalcCost.FCXtdNetAfHD - DataB4CalcCost.FCXtdVatEx)*ISNULL(DataB4CalcCost.FCXtdWhtRate,0)) AS FCXtdWhtAmtEx,
                        (DataB4CalcCost.FCXtdVatIn+(DataB4CalcCost.FCXtdNetAfHD - DataB4CalcCost.FCXtdVatIn)) AS 	FCXtdCostInVatIn,
                        (DataB4CalcCost.FCXtdVatEx+(DataB4CalcCost.FCXtdNetAfHD - DataB4CalcCost.FCXtdVatEx)) AS	FCXtdCostInVatEx,
                        (DataB4CalcCost.FCXtdNetAfHD - DataB4CalcCost.FCXtdVatIn) AS FCXtdCostExVatIn,
                        (DataB4CalcCost.FCXtdNetAfHD - DataB4CalcCost.FCXtdVatEx) AS FCXtdCostExVatEx
                    FROM (
                        SELECT
                            DataB4Calc.FTBchCode,
                            DataB4Calc.FTXthDocNo,
                            DataB4Calc.FTXthDocKey,
                            DataB4Calc.FTSessionID,
                            DataB4Calc.FNXtdSeqNo,
                            DataB4Calc.FTXtdStaAlwDis,
                            DataB4Calc.FTXtdVatType,
                            DataB4Calc.FTVatCode,
                            DataB4Calc.FCXtdVatRate,
                            DataB4Calc.FTXtdWhtCode,
                            DataB4Calc.FCXtdWhtRate,
                            DataB4Calc.FCXtdQty,
                            ISNULL(DataB4Calc.FCXtdQtyAll,0)        AS FCXtdQtyAll,
                            ISNULL(DataB4Calc.FCXtdSetPrice,0)      AS FCXtdSetPrice,
                            ISNULL(DataB4Calc.FCXtdDis,0)           AS FCXtdDis,
                            ISNULL(DataB4Calc.FCXtdChg,0)           AS FCXtdChg,
                            ISNULL(DataB4Calc.FTXtdDisHD,0)         AS FTXtdDisHD,
                            ISNULL(DataB4Calc.FTXtdChgHD,0)         AS FTXtdChgHD,
                            ISNULL(DataB4Calc.FCXtdAmtB4DisChg,0)   AS FCXtdAmtB4DisChg,
                            ISNULL(DataB4Calc.FCXtdNet,0)           AS FCXtdNet,
                            ISNULL(DataB4Calc.FCXtdNetAfHD,0)       AS FCXtdNetAfHD,
                            CASE 	
                                WHEN DataB4Calc.FTXtdVatType = 1 AND (DATALENGTH(DataB4Calc.FTVatCode) <> 0 OR DATALENGTH(DataB4Calc.FCXtdVatRate) <> 0)
                                THEN (DataB4Calc.FCXtdNetAfHD-((DataB4Calc.FCXtdNetAfHD*100)/(100+DataB4Calc.FCXtdVatRate)))
                            ELSE 0 END AS FCXtdVatIn,
                            CASE
                                WHEN DataB4Calc.FTXtdVatType = 1 AND (DATALENGTH(DataB4Calc.FTVatCode) <> 0 OR DATALENGTH(DataB4Calc.FCXtdVatRate) <> 0)
                                THEN (((DataB4Calc.FCXtdNetAfHD*(100+DataB4Calc.FCXtdVatRate))/100)-DataB4Calc.FCXtdNetAfHD)
                            ELSE 0 END AS FCXtdVatEx
                        FROM (
                            SELECT
                                DTTemp.FTBchCode,DTTemp.FTXthDocNo,DTTemp.FTXthDocKey,DTTemp.FTSessionID,DTTemp.FNXtdSeqNo,DTTemp.FTXtdStaAlwDis,
                                DTTemp.FTXtdVatType,DTTemp.FTVatCode,DTTemp.FCXtdVatRate,DTTemp.FTXtdWhtCode,DTTemp.FCXtdWhtRate,DTTemp.FCXtdQty,
                                DTTemp.FCXtdSetPrice,
                                
                                (DTTemp.FCXtdQty * DTTemp.FCXtdFactor ) AS FCXtdQtyAll,
                                ISNULL(DTDisAll.FTXtdDisList,0)         AS FCXtdDis,
                                ISNULL(DTDisAll.FTXtdChgList,0)	        AS FCXtdChg,
                                ISNULL(DTDisAll.FTXtdDisFoot,0)	        AS FTXtdDisHD,
                                ISNULL(DTDisAll.FTXtdChgFoot,0)	        AS FTXtdChgHD,

                                (ISNULL(DTTemp.FCXtdQty,0)*ISNULL(DTTemp.FCXtdSetPrice,0))  AS FCXtdAmtB4DisChg,

                                ((ISNULL(DTTemp.FCXtdQty,0)*ISNULL(DTTemp.FCXtdSetPrice,0))-(-ISNULL(DTDisAll.FTXtdDisList,0))+(ISNULL(DTDisAll.FTXtdChgList,0)))   AS FCXtdNet,

                                (((ISNULL(DTTemp.FCXtdQty,0)*ISNULL(DTTemp.FCXtdSetPrice,0))-(-ISNULL(DTDisAll.FTXtdDisList,0))+(ISNULL(DTDisAll.FTXtdChgList,0)))+((ISNULL(DTDisAll.FTXtdDisFoot,0))+(ISNULL(DTDisAll.FTXtdChgFoot,0))))  AS FCXtdNetAfHD
                            
                            FROM (
                                SELECT
                                    DTTemp.FTBchCode,DTTemp.FTXthDocNo,DTTemp.FTXthDocKey,DTTemp.FTSessionID,DTTemp.FNXtdSeqNo,DTTemp.FTXtdStaAlwDis,DTTemp.FCXtdFactor,DTTemp.FTXtdVatType,
                                    DTTemp.FTVatCode,DTTemp.FCXtdVatRate,DTTemp.FTXtdWhtCode,DTTemp.FCXtdWhtRate,DTTemp.FCXtdQty,DTTemp.FCXtdQtyAll,DTTemp.FCXtdSetPrice
                                FROM TCNTDocDTTmp DTTemp WITH (NOLOCK)
                                WHERE 1=1
                                -- Edit By Jame,Nale AND DTTemp.FTBchCode    = '".$tDataBchCode."'
                                AND DTTemp.FTXthDocNo   = '".$tDataDocNo."'
                                AND DTTemp.FTXthDocKey	= '".$tDataDocKey."'
                                AND DTTemp.FTSessionID	= '".$tDataSessionID."'
                                ".$tSQLWhereSeqDT."
                                ) DTTemp
                            LEFT JOIN (
                                SELECT 
                                    CASE	WHEN DTDisList.FNXtdSeqNo		IS NULL THEN DTDisFoot.FNXtdSeqNo
                                            WHEN DTDisFoot.FTXtdDisFoot	IS NULL THEN DTDisList.FNXtdSeqNo
                                    ELSE DTDisFoot.FNXtdSeqNo END
                                    AS FNXtdSeqNo,
                                    DTDisList.FTXtdDisList,
                                    DTDisList.FTXtdChgList,
                                    DTDisFoot.FTXtdDisFoot,
                                    DTDisFoot.FTXtdChgFoot
                                FROM (
                                    SELECT
                                        TCNTDocDTDisTmp.FNXtdSeqNo,
                                        SUM(CASE	WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 1	THEN -FCXtdValue
                                                    WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 2	THEN -FCXtdValue
                                            ELSE 0 END
                                        )AS FTXtdDisList,
                                        SUM(CASE 	WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 3	THEN FCXtdValue
                                                    WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 4	THEN FCXtdValue
                                            ELSE 0 END
                                        ) AS FTXtdChgList
                                    FROM TCNTDocDTDisTmp WITH (NOLOCK)
                                    WHERE 1=1
                                    AND TCNTDocDTDisTmp.FNXtdStaDis = 1
                                    -- Edit By Jame,Nale AND TCNTDocDTDisTmp.FTBchCode   = '".$tDataBchCode."'
                                    AND TCNTDocDTDisTmp.FTXthDocNo  = '".$tDataDocNo."'
                                    AND TCNTDocDTDisTmp.FTSessionID = '".$tDataSessionID."'
                                    ".$tSQLWhereSeqDis."
                                    GROUP BY TCNTDocDTDisTmp.FNXtdSeqNo ) AS DTDisList
                                FULL OUTER JOIN (
                                    SELECT
                                        TCNTDocDTDisTmp.FNXtdSeqNo,
                                        SUM(	CASE	WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 1	THEN -FCXtdValue
                                                        WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 2	THEN -FCXtdValue
                                                ELSE 0 END
                                        ) AS FTXtdDisFoot,
                                        SUM(	CASE	WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 3	THEN FCXtdValue
                                                        WHEN TCNTDocDTDisTmp.FTXtdDisChgType = 4	THEN FCXtdValue
                                                ELSE 0 END
                                        ) AS FTXtdChgFoot
                                    FROM TCNTDocDTDisTmp WITH (NOLOCK)
                                    WHERE 1=1
                                    AND TCNTDocDTDisTmp.FNXtdStaDis		= 2
                                    -- Edit By Jame,Nale AND TCNTDocDTDisTmp.FTBchCode       = '".$tDataBchCode."'
                                    AND TCNTDocDTDisTmp.FTXthDocNo		= '".$tDataDocNo."'
                                    AND TCNTDocDTDisTmp.FTSessionID		= '".$tDataSessionID."'
                                    ".$tSQLWhereSeqDis."
                                    GROUP BY TCNTDocDTDisTmp.FNXtdSeqNo ) AS DTDisFoot
                                ON DTDisList.FNXtdSeqNo	= DTDisFoot.FNXtdSeqNo ) AS DTDisAll
                            ON DTTemp.FNXtdSeqNo = DTDisAll.FNXtdSeqNo
                        ) AS DataB4Calc
                    ) AS DataB4CalcCost
                ) AS DocDTSlt
                ON 1=1
                -- Edit By Jame,Nale AND DocDTUpd.FTBchCode		= DocDTSlt.FTBchCode
                AND DocDTUpd.FTXthDocNo 	= DocDTSlt.FTXthDocNo
                AND DocDTUpd.FTXthDocKey	= DocDTSlt.FTXthDocKey
                AND DocDTUpd.FNXtdSeqNo 	= DocDTSlt.FNXtdSeqNo
                AND DocDTUpd.FTSessionID	= DocDTSlt.FTSessionID
    ";
    $oQuery = $ci->db->query($tSQL);
    if($oQuery == 1){
        return true;
    }else{
        return false;
    }
}

// Functionality: Calcurete Doc DT Temp
// Parameters:  Function Parameter
// Creator: 01/07/2019 Wasin (Yoshi Aka: Mr. JW)
// Return : true = Success , false = Error
// Return Type: boolean
function FCNbHUpdateDocDTDisChgText($paParams){
    $ci = &get_instance();
    $ci->load->database();
    $tDataDocNo         = $paParams['tDataDocNo'];
    $tDataDocKey        = $paParams['tDataDocKey'];
    $tDataSeqNo         = $paParams['tDataSeqNo'];
    // $tDataSessionID     = $ci->session->userdata("tSesSessionID");
    if(!empty($ci->session->userdata("tSesSessionID"))){
        $tDataSessionID     = $ci->session->userdata("tSesSessionID");
    }else{
        $tDataSessionID    = $ci->input->post("ohdSesSessionID");
        $tSesUsername   = $ci->input->post("ohdSOUsrCode");
        $tSesBCH        = $ci->input->post("ohdSOSesUsrBchCode");  
    }

    // Check Branch Code Login
    // $tSesUsrBchCode     = $ci->session->userdata("tSesUsrBchCode");
    // $tSesUsrBchCom      = $ci->session->userdata("tSesUsrBchCom");

    // if(isset($tSesUsrBchCode) && !empty($tSesUsrBchCode)){
    //     $tDataBchCode   = $tSesUsrBchCode;
    // }else{
    //     $tDataBchCode   = $tSesUsrBchCom;
    // }

    if(empty($paParams['tBchCode'])){
      if(!empty($ci->session->userdata("tSesSessionID"))){
        $tSesUsrBchCode     = $ci->session->userdata("tSesUsrBchCode");
        $tSesUsrBchCom      = $ci->session->userdata("tSesUsrBchCom");
        if(isset($tSesUsrBchCode) && !empty($tSesUsrBchCode)){
            $tDataBchCode   = $tSesUsrBchCode;
        }else{
            $tDataBchCode   = $tSesUsrBchCom;
        }
     }else{
        $tDataBchCode   = $ci->input->post("ohdSOSesUsrBchCode");  
     }
    }else{
        $tDataBchCode = $paParams['tBchCode'];
    }

    /** Check Seq No By Edit In Line */
    if(isset($tDataSeqNo) && !empty($tDataSeqNo)){
        $tSQLWhereSeq   = " AND DTDISTemp.FNXtdSeqNo = '".$tDataSeqNo."' ";
    }else{
        $tSQLWhereSeq   = "";
    }

    $tSQL   = " UPDATE DocDTUpd
                SET DocDTUpd.FTXtdDisChgTxt = DocDTSlt.FTXtdDisChgTxt
                FROM TCNTDocDTTmp DocDTUpd WITH (NOLOCK)
                INNER JOIN (
                    SELECT
                        DTDISTemp.FTBchCode,
                        DTDISTemp.FTXthDocNo,
                        DTDISTemp.FNXtdSeqNo,
                        DTDISTemp.FTSessionID,
                        STUFF((
                            SELECT  ',' + DOCCONCAT.FTXtdDisChgTxt
                            FROM TCNTDocDTDisTmp DOCCONCAT
                            WHERE  1=1 
                            AND DTDISTemp.FNXtdSeqNo = DOCCONCAT.FNXtdSeqNo
                            AND DOCCONCAT.FNXtdStaDis		= 1
                            AND DOCCONCAT.FTBchCode 		= '".$tDataBchCode."'
                            AND DOCCONCAT.FTXthDocNo		= '".$tDataDocNo."'
                            AND DOCCONCAT.FTSessionID		= '".$tDataSessionID."'
                        FOR XML PATH('')), 1, 1, '') AS FTXtdDisChgTxt
                    FROM TCNTDocDTDisTmp DTDISTemp WITH (NOLOCK)
                    WHERE 1 = 1
                    AND DTDISTemp.FNXtdStaDis 	= 1
                    AND DTDISTemp.FTBchCode			= '".$tDataBchCode."'
                    AND DTDISTemp.FTXthDocNo		= '".$tDataDocNo."'
                    AND DTDISTemp.FTSessionID		= '".$tDataSessionID."'
                    ".$tSQLWhereSeq."
                    GROUP BY DTDISTemp.FTBchCode,DTDISTemp.FTXthDocNo,DTDISTemp.FNXtdSeqNo,DTDISTemp.FTSessionID
                ) AS DocDTSlt
                ON 1=1
                AND DocDTUpd.FTBchCode		= DocDTSlt.FTBchCode
                AND DocDTUpd.FTXthDocNo		= DocDTSlt.FTXthDocNo
                AND DocDTUpd.FTSessionID	= DocDTSlt.FTSessionID
                AND DocDTUpd.FNXtdSeqNo		= DocDTSlt.FNXtdSeqNo
                AND DocDTUpd.FTXthDocKey    = '".$tDataDocKey."' ";

    $oQuery = $ci->db->query($tSQL);
    if($oQuery == 1){
        return true;
    }else{
        return false;
    }
}


//คำนวณราคาท้ายบิลใหม่อีกครั้ง 03-04-2020 [wat]
//22-07-2020 แก้ไข ใบ SO ให้เก็บ session ไว้ใน input เพื่อรองรับหน้าจอเปิดทิ้งไว้นานๆ ให้ ใช้ session ใน input แทน
function FSaCCNDocumentUpdateHDDisAgain($paParams){
    $ci = &get_instance();
    $ci->load->database();


    if(!empty($ci->session->userdata('tSesUsrLevel'))){
    $tUserLevel         = $ci->session->userdata('tSesUsrLevel');
    }else{
    $tUserLevel         = $ci->input->post('ohdSesUsrLevel');
    }
    $tDocNo             = $paParams['tDocNo']; 
    $tBCHCode           = $paParams['tBchCode']; 
    // $FCXtdTotalB4DisChg = $paParams['nB4Dis']; 
    // $tVATCode           = $paParams['tSplVatType']; 
    $nB4                = 0;
    $nCalSumDiscount    = 0;
    $nTextDiscount      = 0;
    if($tBCHCode == '' || $tBCHCode == null){
        if($tUserLevel == 'HQ'){
            $tBCH = FCNtGetBchInComp();
        }else{
            if(!empty($ci->session->userdata("tSesUsrBchCode"))){
                $tBCH = $ci->session->userdata("tSesUsrBchCode");
            }else{
                $tBCH = $ci->input->post("ohdSOSesUsrBchCode");
            }
         
        }
    }else{
        $tBCH =  $tBCHCode;
    }

    if(!empty($ci->session->userdata('tSesSessionID'))){
        $tSesSessionID = $ci->session->userdata('tSesSessionID');
    }else{
        $tSesSessionID = $ci->input->post('ohdSesSessionID');
    } 

    $aWhere         = array(
        'tBchCode'      => $tBCH,
        'tDocNo'        => $tDocNo,
        'tSessionID'    => $tSesSessionID
    );

    $tSQL = "   SELECT * FROM TCNTDocHDDisTmp 
                WHERE 
                    TCNTDocHDDisTmp.FTSessionID    = '".$aWhere['tSessionID']."'
                AND TCNTDocHDDisTmp.FTBchCode      = '".$aWhere['tBchCode']."'
                AND TCNTDocHDDisTmp.FTXthDocNo     = '".$aWhere['tDocNo']."' ";

    $oQuery = $ci->db->query($tSQL);
    if($oQuery->num_rows() > 0){
        $aDataDiscountList = $oQuery->result_array();
    }else{
        $aDataDiscountList = array();
        return 'FAIL';
    }

    $nCount = FCNnHSizeOf($aDataDiscountList);
    if($nCount == 0){
        //ไม่เจอส่วนลดท้ายบิลไม่ต้องทำ
        return 'FAIL';
    }else{

        $tSQLSum = "SELECT SUM(FCXtdNet) AS Total FROM TCNTDocDTTmp WHERE 
            TCNTDocDTTmp.FTSessionID    = '".$aWhere['tSessionID']."'
        AND TCNTDocDTTmp.FTBchCode      = '".$aWhere['tBchCode']."'
        AND TCNTDocDTTmp.FTXthDocNo     = '".$aWhere['tDocNo']."' 
        AND FTXtdStaAlwDis = '1' ";

        $oQuery             = $ci->db->query($tSQLSum);
        $aResult            = $oQuery->result_array();
        $FCXtdTotalB4DisChg = $aResult[0]['Total'];

        if($FCXtdTotalB4DisChg == '' || $FCXtdTotalB4DisChg == null){
            $ci->db->where_in('FTBchCode',$aWhere['tBchCode']);
            $ci->db->where_in('FTXthDocNo',$aWhere['tDocNo']);
            $ci->db->where_in('FTSessionID',$aWhere['tSessionID']);
            $ci->db->delete('TCNTDocHDDisTmp');
            return 'FAIL';
        }

        if(str_replace(",","",$FCXtdTotalB4DisChg) == str_replace(",","",$aDataDiscountList[0]['FCXtdTotalB4DisChg'])){
            return 'FAIL';
        }else{
            //เจอส่วนลดต้องคำนวณใหม่่
            $tFCXtdTotalB4DisChg  = str_replace(",","",$FCXtdTotalB4DisChg);
            for($i=0; $i<$nCount; $i++){

                if($i == 0){
                    //ตัวแรกต้องใช้ค่าที่มันถูกเปลี่ยนล่าสุด
                    $nPrice = str_replace(",","",$tFCXtdTotalB4DisChg);
                }else{
                    //ตัวต่อๆไป ใช้ค่าใหม่ตาม loop 
                    $nPrice = str_replace(",","",$nB4);
                }
            
                switch ($aDataDiscountList[$i]['FTXtdDisChgType']) {
                    case 1: //ลดบาท
                        $nTotal         = $nPrice - str_replace(",","",$aDataDiscountList[$i]['FCXtdDisChg']);
                        $FCXtdAmt       = $aDataDiscountList[$i]['FCXtdAmt'];
                        $nTextDiscount  = $nCalSumDiscount + (-$FCXtdAmt);
                        break;
                    case 2: //ลด percent
                        $FCXtdAmt       = ($nPrice * (str_replace(",","",$aDataDiscountList[$i]['FCXtdDisChg']))) / 100;
                        $nTotal         = $nPrice - $FCXtdAmt;
                        $nTextDiscount  = $nCalSumDiscount + (-$FCXtdAmt);
                        break;
                    case 3: //ชาร์ทบาท
                        $nTotal         = $nPrice + str_replace(",","",$aDataDiscountList[$i]['FCXtdAmt']);
                        $FCXtdAmt       = $aDataDiscountList[$i]['FCXtdAmt'];
                        $nTextDiscount  = $nCalSumDiscount + $FCXtdAmt;
                        break;
                    case 4: //ชาร์ท percent
                        $FCXtdAmt       = ($nPrice * (str_replace(",","",$aDataDiscountList[$i]['FCXtdDisChg']))) / 100;
                        $nTotal         = $nPrice + $FCXtdAmt;
                        $nTextDiscount  = $nCalSumDiscount + $FCXtdAmt;
                        break;
                }

                $aUpdateDis = array(
                    'FCXtdTotalAfDisChg'    => str_replace(",","",$nTotal),
                    'FCXtdTotalB4DisChg'	=> str_replace(",","",$nPrice),
                    'FCXtdAmt'	            => str_replace(",","",$FCXtdAmt)
                );

                $aWhereDis = array(
                    'FTBchCode'	            => $aDataDiscountList[$i]['FTBchCode'],
                    'FTXthDocNo'            => $aDataDiscountList[$i]['FTXthDocNo'],
                    'FDXtdDateIns'          => $aDataDiscountList[$i]['FDXtdDateIns'],
                    'FTXtdDisChgTxt'	    => $aDataDiscountList[$i]['FTXtdDisChgTxt'],    
                    'FTXtdDisChgType'	    => $aDataDiscountList[$i]['FTXtdDisChgType'],
                    'FTSessionID'	        => $aDataDiscountList[$i]['FTSessionID']
                );

                $ci->db->set('FCXtdTotalAfDisChg', $aUpdateDis['FCXtdTotalAfDisChg']);
                $ci->db->set('FCXtdTotalB4DisChg', $aUpdateDis['FCXtdTotalB4DisChg']);
                $ci->db->set('FCXtdAmt', $aUpdateDis['FCXtdAmt']);
                $ci->db->where_in('FTBchCode',$aWhereDis['FTBchCode']);
                $ci->db->where_in('FTXthDocNo',$aWhereDis['FTXthDocNo']);
                $ci->db->where_in('FDXtdDateIns',$aWhereDis['FDXtdDateIns']);
                $ci->db->where_in('FTXtdDisChgTxt',$aWhereDis['FTXtdDisChgTxt']);
                $ci->db->where_in('FTXtdDisChgType',$aWhereDis['FTXtdDisChgType']);
                $ci->db->where_in('FTSessionID',$aWhereDis['FTSessionID']);
                $ci->db->update('TCNTDocHDDisTmp');

                //แทนค่ายอดหลังลดใหม่
                $nB4                = str_replace(",","",$nTotal);
                $nCalSumDiscount    = str_replace(",","",$nTextDiscount);
            }

            return 'CHANGE';
        }
    }
}