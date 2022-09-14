<?php
defined('BASEPATH') or exit('No direct script access allowed');
class mMovement extends CI_Model
{
    //Functionality : list Data Movement
    //Parameters : function parameters
    //Creator :  10/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSaMMovementList($paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tWhereBch = "";
        $tWherePdt = "";
        $tWhereWah = "";
        $tWhereDate = "";
        $SqlWhere = "";
        $tWhereProductActive = "";

        $nLngID = $paData['FNLngID'];
        $tSearchList = $paData['tSearchAll'];
        $tBchCode = $paData['tSearchAll']['tBchCode'];
        $tShpCode = $paData['tSearchAll']['tShpCode'];
        $tWahCode = $paData['tSearchAll']['tWahCode'];
        $tPdtCode = $paData['tSearchAll']['tPdtCode'];
        $dDateStart = $paData['tSearchAll']['dDateStart'];
        $dDateTo = $paData['tSearchAll']['dDateTo'];
        $tMmtPdtActive = $paData['tSearchAll']['nPdtActive'];
        $tMmtMonth = $paData['tSearchAll']['tMmtMonth'];
        $tMmtYear = $paData['tSearchAll']['tMmtYear'];

        if ($tBchCode != "") {
            $tBchCodeText = str_replace(",", "','", $tBchCode);
            $tWhereBch = " AND StkCrd.FTBchCode IN ('$tBchCodeText')";
        }
        // (String)
        if ($tPdtCode != "") {
            // echo $tPdtCode;
            // $aPdtCode = explode(',',$tPdtCode);
            // $nCount = FCNnHSizeOf($aPdtCode);

            // if(!empty($aPdtCode)){
            //     // print_r($aPdtCode);
            //     $nCheck = 1;
            //     $tWherePdt = " AND (";
            //         foreach($aPdtCode as $aData){
            //             $tWherePdt .= " StkCrd.FTPdtCode = '$aData' ";
            //             if($nCheck!=$nCount){
            //                 $tWherePdt .= " OR ";
            //             }
            //             $nCheck++;
            //         }
            //     $tWherePdt .= " )";
            // }
            $tPdtCodeText = str_replace(",", "','", $tPdtCode);
            $tWherePdt = " AND StkCrd.FTPdtCode IN ('$tPdtCodeText')";
        }

        if ($tWahCode != "") {
            $tWahCodeText = str_replace(",", "','", $tWahCode);
            $tWhereWah = " AND StkCrd.FTWahCode IN ('$tWahCodeText')";
        }

        if ($tMmtPdtActive == "1") {
            $tWhereProductActive = " AND PDTM.FTPdtStaActive = '1' ";
        }

        $tWhereStartDate = '';
        $tWhereEndDate = '';
        if ($dDateStart != "") {
            $tWhereStartDate = " AND CONVERT(VARCHAR(10),StkCrd.FDStkDate,121) >= '$dDateStart' ";
        }
        if ($dDateTo != "") {
            $tWhereEndDate = " AND CONVERT(VARCHAR(10),StkCrd.FDStkDate,121) <= '$dDateTo' ";
        }

        if($tMmtMonth!=""){
            $tWhereMonth = " AND FORMAT(StkCrd.FDStkDate, 'MM') = FORMAT($tMmtMonth,'00') ";
        }

        if($tMmtYear!=""){
            $tWhereYear = " AND FORMAT(StkCrd.FDStkDate, 'yyyy') = FORMAT($tMmtYear,'0000') ";
        }
        
        $SqlWhere = $tWhereBch . ' ' . $tWherePdt . ' ' . $tWhereWah . ' ' . $tWhereStartDate . " " . $tWhereEndDate . ' ' . $tWhereProductActive.' '.$tWhereMonth." ".$tWhereYear;
        // ROW_NUMBER() OVER(ORDER BY FDStkDate ASC,FTBchCode ASC,FTPdtCode ASC,FTWahCode ASC,FDStkDate ASC) AS rtRowID,* 
        $tSQL = "
                SELECT 
                    C.* 
                FROM(
                    SELECT 
                        ROW_NUMBER() OVER(ORDER BY FDStkDate ASC,FTPdtCode ASC,FTPdtName ASC,FDCreateOn ASC,FTStkDocNo ASC,FTWahCode ASC) AS rtRowID,* 
                    FROM
                        (SELECT 
                            StkCrd.FTBchCode, 
                            StkCrd.FTPdtCode, 
                            PDT.FTPdtName,
                            StkCrd.FTStkDocNo,
                            StkCrd.FDStkDate,
                            StkCrd.FCStkQty,
                            StkCrd.FTWahCode,
                            WAH.FTWahName,
                            StkCrd.FTStkType,
                            
                            CASE
                                WHEN StkCrd.FTStkType = '0' THEN StkCrd.FCStkQty
                                ELSE 0
                            END AS FCStkMonthEnd,

                            CASE
                                WHEN StkCrd.FTStkType = '1' THEN StkCrd.FCStkQty
                                ELSE 0
                            END AS FCStkIN,

                            CASE
                                WHEN StkCrd.FTStkType = '2' THEN StkCrd.FCStkQty
                                ELSE 0
                            END AS FCStkOUT,

                            CASE
                                WHEN StkCrd.FTStkType = '3' THEN StkCrd.FCStkQty
                                ELSE 0
                            END AS FCStkSale,

                            CASE
                                WHEN StkCrd.FTStkType = '4' THEN StkCrd.FCStkQty
                                ELSE 0
                            END AS FCStkReturn,

                            CASE
                                WHEN StkCrd.FTStkType = '5' THEN StkCrd.FCStkQty
                                ELSE 0
                            END AS FCStkAdjust,

                            SUM(  
                                CASE
                                    WHEN StkCrd.FTStkType = '0' THEN StkCrd.FCStkQty * 1
                                    WHEN StkCrd.FTStkType = '1' THEN StkCrd.FCStkQty * 1
                                    WHEN StkCrd.FTStkType = '2' THEN StkCrd.FCStkQty * -1
                                    WHEN StkCrd.FTStkType = '3' THEN StkCrd.FCStkQty * -1
                                    WHEN StkCrd.FTStkType = '4' THEN StkCrd.FCStkQty
                                    WHEN StkCrd.FTStkType = '5' THEN StkCrd.FCStkQty * 1
                                    ELSE 0 
                                END 
                            ) 
                            OVER(PARTITION BY StkCrd.FTPdtCode,StkCrd.FTWahCode,CONVERT (VARCHAR (7),StkCrd.FDStkDate,121) ORDER BY StkCrd.FDStkDate ASC,StkCrd.FTBchCode, 
                            StkCrd.FTPdtCode, StkCrd.FTWahCode,StkCrd.FDCreateOn) AS FCStkQtyInWah
                            ,StkCrd.FDCreateOn
                        FROM (
                            SELECT
                                STK.FNStkCrdID,
                                STK.FTBchCode,
                                STK.FDStkDate,
                                STK.FTStkDocNo,
                                STK.FTWahCode,
                                STK.FTPdtCode,
                                STK.FTStkType,
                                STK.FCStkQty,
                                STK.FCStkSetPrice,
                                STK.FCStkCostIn,
                                STK.FCStkCostEx,
                                STK.FDCreateOn,
                                STK.FTCreateBy,
                                STK.FTPdtParent
                            FROM TCNTPdtStkCrd STK WITH (NOLOCK)

                            UNION ALL

                            SELECT
                                STKME.FNStkCrdID,
                                STKME.FTBchCode,
                                STKME.FDStkDate,
                                STKME.FTStkDocNo,
                                STKME.FTWahCode,
                                STKME.FTPdtCode,
                                STKME.FTStkType,
                                STKME.FCStkQty,
                                STKME.FCStkSetPrice,
                                STKME.FCStkCostIn,
                                STKME.FCStkCostEx,
                                STKME.FDCreateOn,
                                STKME.FTCreateBy,
                                '' AS FTPdtParent
                            FROM TCNTPdtStkCrdME STKME WITH (NOLOCK)
                        ) StkCrd

                        INNER JOIN TCNMPdt PDTM WITH(NOLOCK) ON StkCrd.FTPdtCode = PDTM.FTPdtCode
                        LEFT JOIN TCNMPdt_L PDT WITH(NOLOCK) ON StkCrd.FTPdtCode = PDT.FTPdtCode AND PDT.FNLngID = $nLngID
                        LEFT JOIN TCNMWaHouse_L WAH WITH(NOLOCK) ON StkCrd.FTBchCode = WAH.FTBchCode AND StkCrd.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $nLngID
                WHERE 1=1 
            ";

        $tSQL .= $SqlWhere;

        $tSQL .= " ) Base) AS C WHERE C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]";

        // $tSQL .= " ORDER BY C.FTPdtCode ASC, C.FTPdtName, C.FDStkDate, C.FTStkDocNo , C.FTWahCode";
        // FTPdtCode ASC,FTPdtName ASC,FDStkDate ASC,FTStkDocNo ASC,FTWahCode
        // echo $tSQL;
        // die();
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aList = $oQuery->result_array();
            $oFoundRow = $this->FSoMMerchantGetPageAll($SqlWhere, $nLngID);
            $nFoundRow = $oFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $aList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        return $aResult;
    }

    //Functionality : All Page Of Movement
    //Parameters : function parameters
    //Creator :  11/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : object Count All Movement
    //Return Type : Object
    public function FSoMMerchantGetPageAll($SqlWhere, $ptLngID)
    {
        $tSQL = "
            SELECT 
                COUNT (StkCrd.FTPdtCode) AS counts
                FROM (
                    SELECT
                        STK.FNStkCrdID,
                        STK.FTBchCode,
                        STK.FDStkDate,
                        STK.FTStkDocNo,
                        STK.FTWahCode,
                        STK.FTPdtCode,
                        STK.FTStkType,
                        STK.FCStkQty,
                        STK.FCStkSetPrice,
                        STK.FCStkCostIn,
                        STK.FCStkCostEx,
                        STK.FDCreateOn,
                        STK.FTCreateBy,
                        STK.FTPdtParent
                    FROM TCNTPdtStkCrd STK WITH (NOLOCK)

                    UNION ALL

                    SELECT
                        STKME.FNStkCrdID,
                        STKME.FTBchCode,
                        STKME.FDStkDate,
                        STKME.FTStkDocNo,
                        STKME.FTWahCode,
                        STKME.FTPdtCode,
                        STKME.FTStkType,
                        STKME.FCStkQty,
                        STKME.FCStkSetPrice,
                        STKME.FCStkCostIn,
                        STKME.FCStkCostEx,
                        STKME.FDCreateOn,
                        STKME.FTCreateBy,
                        '' AS FTPdtParent
                    FROM TCNTPdtStkCrdME STKME WITH (NOLOCK)
                ) StkCrd

                INNER JOIN TCNMPdt PDTM WITH(NOLOCK) ON StkCrd.FTPdtCode = PDTM.FTPdtCode
                LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON StkCrd.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $ptLngID
                LEFT JOIN TCNMWaHouse_L WAH WITH(NOLOCK) ON StkCrd.FTBchCode = WAH.FTBchCode AND StkCrd.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $ptLngID
            WHERE 1=1 
            $SqlWhere 
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }
}
