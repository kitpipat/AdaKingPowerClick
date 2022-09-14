<?php
    // Functionality : คำส่วนลดท้ายบิล
    // Parameters : function parameters
    // Creator : -
    // Last Modified : 22-01-2020 Nale
    // Description Modified : เพิ่ม Where ที่เลขที่เอกสารในคิวรี่  
    // Return : -
    // Return Type : None

    // FCNaHCalculateProrate('TAPTPcHD','DEMODOCNO');

    //คำนวณ prorate
    function FCNaHCalculateProrate($ptPagename,$ptDocumentNo){
        $ci = &get_instance();
        $ci->load->database();
        set_time_limit(0);

        //Session ID
        if(!empty($ci->session->userdata("tSesSessionID"))){
        $tSession_id    = $ci->session->userdata("tSesSessionID");
        $tSesUsername   = $ci->session->userdata("tSesUsername");
        $tSesBCH        = $ci->session->userdata("tSesUsrBchCode");
        }else{
        $tSession_id    = $ci->input->post("ohdSesSessionID");
        $tSesUsername   = $ci->input->post("ohdSOUsrCode");
        $tSesBCH        = $ci->input->post("ohdSOSesUsrBchCode");       
        }

        //case : เข้ามาแบบ HQ จะใช้ tSesUsrBchCom 
		    // : เข้ามาแบบ BCH , SHP จะใช้ tSesUsrBchCode 
        // if($tSesBCH == '' ||  $tSesBCH == null){
        //     $tSesBCH  = $ci->session->userdata("tSesUsrBchCom");
        // }else{
        //     $tSesBCH  = $ci->session->userdata("tSesUsrBchCode");
        // }

        //Demo Test parameter
        // $tSesUsername   = 'WAT';
        // $tSession_id    = '00920190701093952';
        // $tSesBCH        = '00042';

        //parameter
        //$ptPagename   = ชือเอกสารของเรื่องนั้นๆ 
        //$ptDocumentNo = หมายเลขเอกสาร
        if($ptDocumentNo == '' || $ptDocumentNo == null){
            $ptDocumentNo = '';
        }else{
            $ptDocumentNo = $ptDocumentNo;
        }

        //Step 01 : วิ่งไปเช็คว่ามีส่วนลดท้ายบิล 
        // $tSQLHDDis = "SELECT SUM(FCXtdAmt) AS FCXtdAmt FROM TCNTDocHDDisTmp WHERE FTSessionID  = '$tSession_id' ";

        $tSQLHDDis = "SELECT HDD.*,CASE WHEN HDD.FCXtdAmt < 0 THEN 1 ELSE 3 END AS FTXtdDisChgType FROM(
                        SELECT SUM(CASE WHEN FTXtdDisChgType = 1 THEN FCXtdAmt * -1
                                        WHEN FTXtdDisChgType = 2 THEN FCXtdAmt * -1
                                        WHEN FTXtdDisChgType = 3 THEN FCXtdAmt
                                        WHEN FTXtdDisChgType = 4 THEN FCXtdAmt
                                    ELSE 0 END 
                                ) FCXtdAmt
                        FROM  TCNTDocHDDisTmp
                        WHERE FTSessionID  = '$tSession_id'   
                        AND FTXthDocNo ='$ptDocumentNo' 
                    ) HDD WHERE FCXtdAmt != 0 ";
            
        $oQueryHDDis = $ci->db->query($tSQLHDDis);
        if($oQueryHDDis->num_rows() > 0){
            //case พบข้อมูล

            //ผลรวมของ ส่วนลดท้ายบิล
            $aDetailHDDis = $oQueryHDDis->result_array();
            $nDiscount    = $aDetailHDDis[0]['FCXtdAmt'];

            $tCheckType   =  substr($nDiscount,0,1);
            if($tCheckType == '-'){
                // echo 'Type เป็น ลด ';
                $tFTXtdDisChgType = 1;
            }else{
                // echo 'Type เป็น ชาร์ท ';
                $tFTXtdDisChgType = 3;
            }
            $nDiscount = abs($nDiscount); 

            //Step 02 : วิ่งไปลบแต่ละรายการของ ข้อมูลส่วนลดท้ายบิล
            $tTableName = 'TCNTDocDTDisTmp';
            $ci->db->where_in('FNXtdStaDis', '2');
            $ci->db->where_in('FTSessionID', $tSession_id);
            $ci->db->delete($tTableName);

            //Step 03 : ไปเอาข้อมูลแต่ละรายการในตาราง Temp
            $tSQLDT = "SELECT FTPdtCode,FTXtdPdtName,FCXtdNet,FTXtdStaAlwDis,FNXtdSeqNo FROM TCNTDocDTTmp WHERE FTXtdStaAlwDis = 1 AND FTSessionID = '$tSession_id' AND FTXthDocKey = '$ptPagename' AND FTXthDocNo ='$ptDocumentNo'  ";
            $oQueryDT = $ci->db->query($tSQLDT);
            if($oQueryDT->num_rows() > 0){

                //Step 04 : คำนวณ prorate เข้าสูตร : ส่วนลดท้ายบิลทั้งหมด x ราคาต่อชิ้น/ราคาทั้งหมดหลังหักส่วนลด
                $aDetail  = $oQueryDT->result_array();

                //ทศนิยม
                $nDecimal = FCNxHGetOptionDecimalShow();
                $dDate    = date("Y-m-d H:i:s");

                //Insert Prorate
                $tSql = "INSERT INTO TCNTDocDTDisTmp (
                            FTBchCode,
                            FTXthDocNo,
                            FNXtdSeqNo,
                            FTSessionID,
                            FDXtdDateIns,
                            FNXtdStaDis,
                            FTXtdDisChgType,
                            FCXtdNet,
                            FCXtdValue,
                            FDCreateOn,
                            FTCreateBy,
                            FTXtdDisChgTxt
                        ) 
                        SELECT 
                            PDT.FTBchCode,
                            PDT.FTXthDocNo,
                            PDT.FNXtdSeqNo,
                            '$tSession_id' AS FTSessionID,
                            '$dDate' AS FDXtdDateIns,
                            '2' AS FNXtdStaDis,
                            '$tFTXtdDisChgType' AS  FTXtdDisChgType,
                            PDT.FCXtdNet,
                            SUBSTRING(CONVERT(VARCHAR(50),CONVERT(VARCHAR(100),(ISNULL(PDT.FCXtdNet,1) * $nDiscount) / PDT.SUMNET) ,121),1,CHARINDEX('.',CONVERT(VARCHAR(100),(ISNULL(PDT.FCXtdNet,1) * $nDiscount) / PDT.SUMNET))+2) AS FCXtdValue,
                            '$dDate' AS FDCreateOn,
                            '$tSesUsername' AS FTCreateBy,
                            '$nDiscount' AS FTXtdDisChgTxt
                        FROM (
                            SELECT 
                                DT.FTPdtCode,
                                DT.FTXtdPdtName,
                                DT.FCXtdNet,
                                ( select SUM(FCXtdNet) FROM TCNTDocDTTmp WHERE FTSessionID = '$tSession_id' AND FTXthDocKey = '$ptPagename' AND FTXthDocNo ='$ptDocumentNo' GROUP BY FTXthDocNo ) AS SUMNET,
                                DT.FTXtdStaAlwDis,
                                DT.FNXtdSeqNo ,
                                DT.FTBchCode,
                                DT.FTXthDocNo
                            FROM TCNTDocDTTmp DT
                            WHERE DT.FTXtdStaAlwDis = 1 
                            AND DT.FTSessionID = '$tSession_id' AND DT.FTXthDocKey = '$ptPagename' AND DT.FTXthDocNo ='$ptDocumentNo'
                        ) AS PDT ";
                $tInsertDTDis = FCNaHProrateInsertDiscount($tSql);

                //Check ตัวสุดท้ายของ prorate
                $tSqlLastSum = "UPDATE Tmp SET Tmp.FCXtdValue = LastProrate.FCXthLastProrate
                                FROM TCNTDocDTDisTmp Tmp INNER JOIN ( SELECT DT.FTXthDocNo 
                                                                            , DT.FNXtdSeqNO 
                                                                            , TmpLast.FCXtdValue + ($nDiscount - (
                                                                                                                  SELECT SUM(FCXtdValue) FROM TCNTDocDTDisTmp  
                                                                                                                  WHERE FTSessionID = '$tSession_id'
                                                                                                                  AND FTXthDocNo ='$ptDocumentNo' 
                                                                                                                  AND FNXtdStaDis = '2' )
                                                                                                                ) AS FCXthLastProrate  
                                                                        FROM TCNTDocDTDisTmp DT 
                                                                        INNER JOIN  ( SELECT TOP 1 FCXtdValue , FNXtdSeqNO , FTXthDocNo
                                                                                    FROM TCNTDocDTDisTmp DT
                                                                                    WHERE DT.FTSessionID = '$tSession_id' 
                                                                                    AND DT.FTXthDocNo ='$ptDocumentNo' AND DT.FNXtdStaDis = '2'  ORDER BY FNXtdSeqNO DESC ) TmpLast
                                                                        ON DT.FTXthDocNo = TmpLast.FTXthDocNo AND DT.FNXtdSeqNO = TmpLast.FNXtdSeqNO 
                                                                        WHERE DT.FTSessionID = '$tSession_id' 
                                                                        AND DT.FTXthDocNo ='$ptDocumentNo'
                                                                        GROUP BY DT.FTXthDocNo , DT.FNXtdSeqNO , TmpLast.FCXtdValue
                                                                        ) AS LastProrate ON Tmp.FTXthDocNo = LastProrate.FTXthDocNo 
                                                                        AND Tmp.FNXtdSeqNO = LastProrate.FNXtdSeqNO AND Tmp.FNXtdStaDis = 2 AND Tmp.FTXthDocNo = '$ptDocumentNo'  ";
                //echo  $tSqlLastSum ;
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
            }else{
                //case ไม่พบข้อมูลของสินค้า
                return;
            }
        }else{
            //case ไม่พบข้อมูลของส่วนลด
            return;
        }
    }

    //Function : insert TCNTDocDTDisTmp (ตารางส่วนลด)
    function FCNaHProrateInsertDiscount($ptSql){
         //Step 05 : เอาไป insert ที่ตาราง DTDisTmp
        $ci = &get_instance();
        $ci->load->database();
        set_time_limit(0);
        $oQuery = $ci->db->query($ptSql);
        if($oQuery == 1){
            return 'success';
        }else{
            return 'fail';
        }
    }

?>