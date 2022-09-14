<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mInv extends CI_Model {
        //Functionality : list Data Movement
    //Parameters : function parameters
    //Creator :  10/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSaMInvList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tWhereBch      = "";
            $tWherePdt      = "";
            $tWhereWah      = "";
            $SqlWhere       = "";

            $nLngID         = $paData['FNLngID'];
            $tBchCode       = $paData['tSearchAll']['tBchCode'];
            $tWahCode       = $paData['tSearchAll']['tWahCode'];
            $tPdtCode       = $paData['tSearchAll']['tPdtCode'];

            if($tBchCode != ""){
                $tBchCodeText= str_replace(",","','",$tBchCode);
                $tWhereBch  = "AND BAL.FTBchCode IN ('$tBchCodeText')";
            }else{
                $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
                if($tStaUsrLevel == 'HQ'){
                    $SqlWhere   .= "";
                }else if($tStaUsrLevel == 'BCH'){
                    $tBCH    = $this->session->userdata("tSesUsrBchCodeMulti");
                    $SqlWhere   .= " AND BAL.FTBchCode IN ($tBCH) ";
                }
            }

            if($tPdtCode != ""){
                $tPdtCodeText= str_replace(",","','",$tPdtCode);
                $tWherePdt = "AND PDT.FTPdtCode IN ('$tPdtCodeText')";
            }

            if($tWahCode != ""){
                $tWahCodeText= str_replace(",","','",$tWahCode);
                $tWhereWah = "AND  BAL.FTWahCode IN ('$tWahCodeText')";
            }

            $SqlWhere =  $tWhereBch.' '.$tWherePdt.' '.$tWhereWah;

            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTPdtCode, FTBchCode, FTWahCode ASC) AS rtRowID,* FROM
                                    (
                                        SELECT
                                            PDT.FTPdtCode,
                                            PDT.FTPdtForSystem,
                                            PDT_L.FTPdtName, 
                                            BCH.FTBchCode,
                                            BCH.FTBchName,
                                            BAL.FTWahCode,
                                            WAH.FTWahName,
                                            BAL.FCStkQty,
                                            BAL.FDCreateOn,
                                            ISNULL(ITA.FCXtdQtyAll,0) AS FCXtdQtyInt,
                                            ISNULL(BAL.FCStkQty,0) + ISNULL(ITA.FCXtdQtyAll,0) AS FCXtdQtyBal
                                        FROM TCNTPdtStkBal BAL
                                            LEFT JOIN TCNMPdt PDT ON BAL.FTPdtCode = PDT.FTPdtCode
                                            LEFT JOIN TCNMPdt_L PDT_L ON BAL.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $nLngID 
                                            LEFT JOIN TCNMBranch_L BCH ON BAL.FTBchCode = BCH.FTBchCode AND BCH.FNLngID = $nLngID 
                                            LEFT JOIN TCNMWaHouse_L WAH ON BAL.FTBchCode = WAH.FTBchCode AND BAL.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $nLngID 
                                            LEFT JOIN
                                                (
                                                    SELECT FTBchCode, 
                                                        FTXthWahTo, 
                                                        FTPdtCode, 
                                                        SUM(INT.FCXtdQtyAll) AS FCXtdQtyAll
                                                    FROM
                                                    (
                                                        SELECT FTBchCode, 
                                                            FTXthWahTo, 
                                                            FTPdtCode, 
                                                            FCXtdQtyAll
                                                        FROM TCNTPdtIntDT
                                                        WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                                        --AND
                                                        UNION ALL
                                                        SELECT FTXthBchTo AS FTBchCode, 
                                                            FTXthWahTo, 
                                                            FTPdtCode, 
                                                            FCXtdQtyAll
                                                        FROM TCNTPdtIntDTBCH
                                                        WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                                    --AND
                                                    ) INT
                                                    GROUP BY FTBchCode, FTXthWahTo, FTPdtCode
                                                ) ITA ON BAL.FTBchCode = ITA.FTBchCode AND BAL.FTWahCode = ITA.FTXthWahTo AND BAL.FTPdtCode = ITA.FTPdtCode
                                        --ORDER BY BAL.FTPdtCode,BAL.FTBchCode,BAL.FTWahCode ASC
                                        WHERE 1=1 
                                    ";
            $tSQL .=  $SqlWhere;
      
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";


            $tSQL .= " ORDER BY FDCreateOn DESC, FTPdtCode, FTBchCode, FTWahCode ASC";
            // print_r("<pre>");
            // print_r($tSQL);
            // print_r("</pre>");
            // die();

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMInvGetPageAll($SqlWhere,$nLngID);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
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
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

        //Functionality : All Page Of Movement
    //Parameters : function parameters
    //Creator :  11/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : object Count All Movement
    //Return Type : Object
    public function FSoMInvGetPageAll($SqlWhere,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (*) AS counts
                        FROM TCNTPdtStkBal BAL
                        LEFT JOIN TCNMPdt_L PDT ON BAL.FTPdtCode = PDT.FTPdtCode AND PDT.FNLngID = $ptLngID
                        LEFT JOIN TCNMBranch_L BCH ON BAL.FTBchCode = BCH.FTBchCode AND PDT.FNLngID = $ptLngID
                        LEFT JOIN TCNMWaHouse_L WAH ON BAL.FTBchCode = WAH.FTBchCode AND BAL.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $ptLngID
                        LEFT JOIN
                            (
                                SELECT FTBchCode, 
                                    FTXthWahTo, 
                                    FTPdtCode, 
                                    SUM(INT.FCXtdQtyAll) AS FCXtdQtyAll
                                FROM
                                (
                                    SELECT FTBchCode, 
                                        FTXthWahTo, 
                                        FTPdtCode, 
                                        FCXtdQtyAll
                                    FROM TCNTPdtIntDT
                                    WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                    --AND
                                    UNION ALL
                                    SELECT FTXthBchTo AS FTBchCode, 
                                        FTXthWahTo, 
                                        FTPdtCode, 
                                        FCXtdQtyAll
                                    FROM TCNTPdtIntDTBCH
                                    WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                --AND
                                ) INT
                                GROUP BY FTBchCode, FTXthWahTo, FTPdtCode
                            ) ITA ON BAL.FTBchCode = ITA.FTBchCode AND BAL.FTWahCode = ITA.FTXthWahTo AND BAL.FTPdtCode = ITA.FTPdtCode
                                
                    WHERE 1=1 $SqlWhere ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }



            //Functionality : list Data Movement
    //Parameters : function parameters
    //Creator :  10/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSaMInvPdtFhnList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tWhereBch      = "";
            $tWherePdt      = "";
            $tWhereWah      = "";
            $SqlWhere       = "";

            $nLngID         = $paData['FNLngID'];
            $tBchCode       = $paData['tSearchAll']['tBchCode'];
            $tWahCode       = $paData['tSearchAll']['tWahCode'];
            $tPdtCode       = $paData['tSearchAll']['tPdtCode'];
            $tFhnRefCode    = $paData['tSearchAll']['tFhnRefCode'];
            $tSeaCode       = $paData['tSearchAll']['tSeaCode'];
            $tSzeCode       = $paData['tSearchAll']['tSzeCode'];
            $tFabCode       = $paData['tSearchAll']['tFabCode'];
            $nPdtFhnStaUse       = $paData['tSearchAll']['nPdtFhnStaUse'];

            if($tBchCode != ""){
                $tBchCodeText= str_replace(",","','",$tBchCode);
                $tWhereBch  = "AND BAL.FTBchCode IN ('$tBchCodeText')";
                $tJoinBch = "  TFHTPdtStkBal.FTBchCode = BAL.FTBchCode AND ";
                $tGroupByBch = "  TFHTPdtStkBal.FTBchCode ";
            }else{
                $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel"); 
                if($tStaUsrLevel == 'HQ'){
                    $SqlWhere   .= "";
                    $tJoinBch = "";
                    $tGroupByBch = "";
                }else if($tStaUsrLevel == 'BCH'){
                    $tBCH    = $this->session->userdata("tSesUsrBchCodeMulti");
                    $SqlWhere   .= " AND BAL.FTBchCode IN ($tBCH)";
                    $tJoinBch = "  TFHTPdtStkBal.FTBchCode = BAL.FTBchCode AND ";
                    $tGroupByBch = "  TFHTPdtStkBal.FTBchCode ";
                }
            }

            if($tPdtCode != ""){
                $tPdtCodeText= str_replace(",","','",$tPdtCode);
                $tWherePdt = "AND PDT.FTPdtCode IN ('$tPdtCodeText')";
            }

            if($tWahCode != ""){
                $tWahCodeText= str_replace(",","','",$tWahCode);
                $tWhereWah = "AND  BAL.FTWahCode IN ('$tWahCodeText')";
                $tJoinBch .= "  TFHTPdtStkBal.FTWahCode IN ('$tWahCodeText') AND ";
            
            }


            if($tFhnRefCode != ""){
                $tWhereWah .= " AND  BAL.FTFhnRefCode ='$tFhnRefCode' ";
            }

            if($tSeaCode != ""){
                $tWhereWah .= " AND  PDTCS.FTSeaCode ='$tSeaCode' ";
            }

            if($tSzeCode != ""){
                $tWhereWah .= " AND  PDTCS.FTPszCode ='$tSzeCode' ";
            }

            if($tFabCode != ""){
                $tWhereWah .= " AND  PDTCS.FTFabCode ='$tFabCode' ";
            }

       

            $SqlWhere =  $tWhereBch.' '.$tWherePdt.' '.$tWhereWah;

            $tMainQuery = "SELECT
						ROW_NUMBER () OVER (
                                PARTITION BY BAL.FTFhnRefCode
                                ORDER BY
                                    BAL.FTPdtCode,
                                    BAL.FTFhnRefCode,
                                    BAL.FTBchCode,
                                    BAL.FTWahCode ASC
                            ) AS RowNumberSub,
                            PDT.FTPdtCode,
                            PDT.FTPdtForSystem,
                            PDT_L.FTPdtName, 
                            BCH.FTBchCode,
                            BCH.FTBchName,
                            BAL.FTWahCode,
                            WAH.FTWahName,
                            BAL.FTFhnRefCode,
                            PDTCS.FTSeaCode,
                            PDTCS.FTPszCode,
                            PDTCS.FTClrCode,
                            PDTCS.FTFabCode,
                            SEA_L.FTSeaName,
                            SEA_L.FTSeaChainName,
                            FAB_L.FTFabName,
                            PDTCLR_L.FTClrName,
                            PDTSZE_L.FTPszName,
                            BAL.FCStfBal,
                            BAL.FDCreateOn,
                            0 AS FCXtdQtyInt,
                            ISNULL(BAL.FCStfBal,0) + 0 AS FCXtdQtyBal

                        FROM TFHTPdtStkBal BAL
                            LEFT JOIN TCNMPdt PDT ON BAL.FTPdtCode = PDT.FTPdtCode
                            LEFT JOIN TCNMPdt_L PDT_L ON BAL.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMBranch_L BCH ON BAL.FTBchCode = BCH.FTBchCode AND BCH.FNLngID = $nLngID 
                            LEFT JOIN TCNMWaHouse_L WAH ON BAL.FTBchCode = WAH.FTBchCode AND BAL.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $nLngID 
                            LEFT JOIN TFHMPdtColorSize PDTCS ON BAL.FTPdtCode = PDTCS.FTPdtCode AND  BAL.FTFhnRefCode = PDTCS.FTFhnRefCode AND PDTCS.FNFhnSeq = 1
                            LEFT JOIN TFHMPdtSeason SEA ON PDTCS.FTSeaCode = SEA.FTSeaCode
                            LEFT JOIN TFHMPdtSeason_L SEA_L ON SEA.FTSeaCode = SEA_L.FTSeaCode AND  SEA.FTSeaChain = SEA_L.FTSeaChain AND SEA_L.FNLngID = $nLngID 
                            LEFT JOIN TFHMPdtFabric_L FAB_L ON PDTCS.FTFabCode = FAB_L.FTFabCode AND FAB_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMPdtColor_L PDTCLR_L ON PDTCS.FTClrCode = PDTCLR_L.FTClrCode AND PDTCLR_L.FNLngID = $nLngID 
                            LEFT JOIN TCNMPdtSize_L PDTSZE_L ON PDTCS.FTPszCode = PDTSZE_L.FTPszCode AND PDTSZE_L.FNLngID = $nLngID 
                
                        WHERE 1=1 $SqlWhere";


            $tSQL = "SELECT c.* FROM(
                        SELECT 
                        ROW_NUMBER() OVER(PARTITION BY FTFhnRefCode ORDER BY FTPdtCode, FTFhnRefCode , FTBchCode, FTWahCode ASC) AS RowNumber,
                        ROW_NUMBER() OVER(PARTITION BY FTFhnRefCode , FTBchCode ORDER BY FTPdtCode, FTFhnRefCode , FTBchCode, FTWahCode ASC) AS RowNumberByBch,
                        ROW_NUMBER() OVER(ORDER BY FTPdtCode ,FTFhnRefCode, FTBchCode, FTWahCode ASC) AS rtRowID,* FROM
                        (
                        $tMainQuery
                        ";
      
            $tSQL .= " ) Base";


            $tSQL .= " LEFT JOIN ( SELECT FTPdtCode AS SumPdtCode,FTFhnRefCode AS SumRefCode,SUM(FCStfBal) AS SumQtyBal,SUM(FCXtdQtyInt) AS SumStBalIntPdt,SUM(FCXtdQtyBal) AS SumQtyPdtBal , 	MAX (RowNumberSub) AS LastBchRowID FROM  (";
            $tSQL .=  $tMainQuery ;
            $tSQL .= ") SumFooter GROUP BY FTPdtCode,FTFhnRefCode ) SUM_FOOTER ON  Base.FTPdtCode = SUM_FOOTER.SumPdtCode AND  Base.FTFhnRefCode=SUM_FOOTER.SumRefCode";

             $tSQL .= ") AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";


            $tSQL .= " ORDER BY  FTPdtCode,FTFhnRefCode, FTBchCode, FTWahCode ASC";
        

            $oQuery = $this->db->query($tSQL);
            // echo $this->db->last_query();
            // die();                
        
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMInvPdtFhnGetPageAll($SqlWhere,$nLngID);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
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
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of Movement
    //Parameters : function parameters
    //Creator :  11/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : object Count All Movement
    //Return Type : Object
    public function FSoMInvPdtFhnGetPageAll($SqlWhere,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (*) AS counts
                        FROM TFHTPdtStkBal BAL
                        LEFT JOIN TCNMPdt_L PDT ON BAL.FTPdtCode = PDT.FTPdtCode AND PDT.FNLngID = $ptLngID
                        LEFT JOIN TCNMBranch_L BCH ON BAL.FTBchCode = BCH.FTBchCode AND PDT.FNLngID = $ptLngID
                        LEFT JOIN TCNMWaHouse_L WAH ON BAL.FTBchCode = WAH.FTBchCode AND BAL.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $ptLngID
                        LEFT JOIN TFHMPdtColorSize PDTCS ON BAL.FTPdtCode = PDTCS.FTPdtCode AND  BAL.FTFhnRefCode = PDTCS.FTFhnRefCode AND PDTCS.FNFhnSeq = 1
                       
                                
                    WHERE 1=1 $SqlWhere ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : All Page Of Movement
    //Parameters : function parameters
    //Creator :  11/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : object Count All Movement
    //Return Type : Object
    public function FSaMInvPdtFhnColorSizeActive($paData){
        try{
            $nLngID         = $this->session->userdata("tLangEdit");
            $tPdtCode       = $paData['tPdtCode'];
            $nPdtFhnStaUse  = $paData['nPdtFhnStaUse'];
            $tWhereStaActive = "";
            if(!empty($nPdtFhnStaUse)){
                $tWhereStaActive .= " AND PDTCS.FTFhnStaActive = '$nPdtFhnStaUse'";
            }

                $tSQL = "SELECT
                            PDTCS.FTFhnRefCode,
                            SEA_L.FTSeaChainName,
                            SEA_L.FTSeaName,
                            PDTCLR_L.FTClrName,
                            PDTSZE_L.FTPszName,
                            FAB_L.FTFabName,
                            PDTCS.FTSeaCode,
                            PDTCS.FTPszCode,
                            PDTCS.FTClrCode,
                            PDTCS.FTFabCode
                        FROM
                            TFHMPdtColorSize PDTCS
                        LEFT OUTER JOIN TFHMPdtSeason SEA ON PDTCS.FTSeaCode = SEA.FTSeaChain 
                        LEFT OUTER JOIN TFHMPdtSeason_L SEA_L ON SEA.FTSeaCode = SEA_L.FTSeaCode AND SEA.FTSeaChain = SEA_L.FTSeaChain AND SEA_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TFHMPdtFabric_L FAB_L ON PDTCS.FTFabCode = FAB_L.FTFabCode AND FAB_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtColor_L PDTCLR_L ON PDTCS.FTClrCode = PDTCLR_L.FTClrCode AND PDTCLR_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtSize_L PDTSZE_L ON PDTCS.FTPszCode = PDTSZE_L.FTPszCode AND PDTSZE_L.FNLngID = $nLngID
                        WHERE PDTCS.FTPdtCode = '$tPdtCode'
                        $tWhereStaActive
             ";

                $oQuery = $this->db->query($tSQL);
                if ($oQuery->num_rows() > 0) {
                    return $oQuery->result_array();
                }else{
                    return false;
                }
        }catch(Exception $Error){
            echo $Error;
        }
    }
}