<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSaleMachineDevice extends CI_Model {

    //Functionality : list SaleMachine Device
    //Parameters : function parameters
    //Creator :  05/11/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMPHWList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tSearchList    = $paData['tSearchAll'];
            $nPosCode       = $paData['nPosCode'];
            $nPosCode       = $paData['nPosCode'];
            $tBchCode       = $paData['tBchCode'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtPhwCode ASC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        PHW.FTBchCode  AS rtBchCode,
                                        PHW.FTPosCode  AS rtPosCode,
                                        PHW.FTPhwCode  AS rtPhwCode,
                                        POSHW.FTShwCode AS rtShwCode,
                                        POSHW.FTShwName AS rtShwName,
                                        PHW.FTPhwName AS rtPhwName,
                                        PHW.FTPhwConnType AS rtConnType,
                                        PHW.FTPhwConnRef AS rtConnRef,
                                        PHW.FTPhwCodeRef AS rtCodeRef,
                                        PHW.FNPhwSeq AS rtPhwSeq
                                    FROM [TCNMPosHW] PHW WITH(NOLOCK)
                                    LEFT JOIN [TSysPosHW] POSHW WITH(NOLOCK) ON PHW.FTShwCode  = POSHW.FTShwCode
                                    WHERE PHW.FTBchCode  = '$tBchCode' ";

            // if($this->session->userdata("tSesUsrLevel") != "HQ"){
            //     $tBchCode = $this->session->userdata("tSesUsrBchCode");
            //     $tSQL .= " AND PHW.FTBchCode  = '$tBchCode' ";
            // }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PHW.FTPhwCode LIKE '%$tSearchList%'";
                $tSQL .= " OR PHW.FTPhwName  LIKE '%$tSearchList%')";
            }
            if(isset($nPosCode) && !empty($nPosCode)){
                $tSQL .= " AND PHW.FTPosCode = '$nPosCode'";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            // print_r($tSQL);
            // exit;

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPHWGetPageAll($tSearchList,$nPosCode,$tBchCode);
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

    //Functionality : list SaleMachine Device from TSysPosHW
    //Parameters : function parameters
    //Creator :  12/11/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMGetSysPosHW(){
        try{
            $tSQL  = "SELECT
                        TSysPosHW.FTShwCode AS rtShwCode,
                        TSysPosHW.FTShwName AS rtShwName,
                        TSysPosHW.FTShwNameEng  AS rtShwNameEng
                      FROM TSysPosHW WITH(NOLOCK)
                      WHERE TSysPosHW.FTShwSystem = 'AdaPos' ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $aResult = array(
                    'raItems'       => $aList,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow' => 0,
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

    //Functionality : list SaleMachine Device from TSysPrinter
    //Parameters : function parameters
    //Creator :  12/11/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMGetSysPrinter(){
        try{
            $tSQL  = "SELECT
                        TSysPortPrn.FTSppCode  AS rtSppCode,
                        TSysPortPrn.FTSppValue AS rtSppValue,
                        TSysPortPrn.FTSppRef   AS rtFTSppRef
                      FROM TSysPortPrn WITH(NOLOCK)
                      WHERE TSysPortPrn.FTSppType = 'PRN' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                return $oQuery->result_array();
            }else{
                return FALSE;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : All Page Of SaleMachine Device
    //Parameters : function parameters
    //Creator :  05/11/2018 Witsarut
    //Return : object Count All SaleMachine Device
    //Return Type : Object
    public function FSoMPHWGetPageAll($ptSearchList,$pnPosCode,$ptBchCode){
        try{
            $tSQL = "SELECT COUNT (PHW.FTPosCode) AS counts
                        FROM [TCNMPosHW] PHW
                        LEFT JOIN [TCNMPos] POS ON PHW.FTPhwCode = POS.FTPosCode AND PHW.FTBchCode = POS.FTBchCode
                        LEFT JOIN [TSysPosHW] POSHW ON PHW.FTShwCode  = POSHW.FTShwCode
                     WHERE 1=1 AND PHW.FTBchCode  = '$ptBchCode' ";

            // if($this->session->userdata("tSesUsrLevel") != "HQ"){
            //     $tBchCode = $this->session->userdata("tSesUsrBchCode");
            //     $tSQL .= " AND PHW.FTBchCode  = '$tBchCode' ";
            // }

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PHW.FTPhwCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR PHW.FTPhwName  LIKE '%$ptSearchList%')";
            }
            if(isset($pnPosCode) && !empty($pnPosCode)){
                $tSQL .= " AND PHW.FTPosCode = '$pnPosCode'";
            }

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

    //Functionality : Get Data SaleMachine Device By ID
    //Parameters : function parameters
    //Creator : 05/11/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMPHWGetDataByID($paData){
        try{
            $nLangEdit  = $this->session->userdata("tLangEdit");
            $tPhwCode   = $paData['tPhwCode'];
            $tPosCode   = $paData['FTPosCode'];
            $tBchCode   = $paData['FTBchCode'];

            $tSQL       = " SELECT
                                PHW.FTPhwCode  AS rtPhwCode,
                                PHW.FTBchCode  AS rtBchCode,

                                POS_L.FTPosName AS rtPosName,
                                PHW.FTPhwName AS rtPhwName,
                                PHW.FTPhwConnType AS rtConnType,
                                PHW.FTPhwConnRef AS rtConnRef,
                                PHW.FTPhwCodeRef AS rtCodeRef,
                                PHW.FTPosCode  AS rtPosCode,
                                PHW.FNPhwSeq AS rtPhwSeq,
                                POSHW.FTShwCode AS rtShwCode,
                                POSHW.FTShwName AS rtShwName,
                                PRN.FTPrnName AS rtNamePrinter,
                                PHW.FTPhwCustom AS FTPhwCustom,
                                EDC.FTEdcName AS NameEDC
                            FROM [TCNMPosHW]            PHW     WITH(NOLOCK)
                            LEFT JOIN [TSysPosHW]       POSHW   WITH(NOLOCK) ON PHW.FTShwCode  = POSHW.FTShwCode
                            LEFT JOIN [TCNMPrinter_L]   PRN     WITH(NOLOCK) ON PHW.FTPhwCodeRef = PRN.FTPrnCode AND PRN.FNlngID = $nLangEdit
                            LEFT JOIN [TCNMPos_L]       POS_L   WITH(NOLOCK) ON PHW.FTBchCode = POS_L.FTBchCode AND PHW.FTPhwCodeRef = POS_L.FTPosCode AND POS_L.FNlngID = $nLangEdit
                            LEFT JOIN [TFNMEdc_L]       EDC     WITH(NOLOCK) ON PHW.FTPhwCodeRef = EDC.FTEdcCode AND EDC.FNLngID = $nLangEdit
                            WHERE PHW.FTPhwCode = '$tPhwCode'
                              AND PHW.FTBchCode = '$tBchCode'
                              AND PHW.FTPosCode = '$tPosCode'
                        ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Max Seq TCNMPosHw
    //Parameters : phw code, pos code , shw code
    //Creator : -
    //Update : 03/04/2019 pap
    //Return : max seq
    //Return Type : number
    public function FSaMLastSeqByShwCode($ptPhwPosCode){
        // try{
        //     $tSQL = "SELECT TOP 1 PHW.FNPhwSeq AS rtPhwSeq
        //              FROM TCNMPosHW PHW
        //              WHERE 1=1
        //              AND PHW.FTPhwCode = '$ptPhwCode' AND PHW.FTPhwCode = '$ptPosCode' AND PHW.FTShwCode = '$ptShwCode'
        //              ORDER BY PHW.FNPhwSeq*1 DESC ";
        //     $oQuery = $this->db->query($tSQL);
        //     if ($oQuery->num_rows() > 0){
        //         return $oQuery->row_array();
        //     }else{
        //         return FALSE;
        //     }
        // }catch(Exception $Error){
        //     echo $Error;
        // }
        $tSQL = "SELECT TOP 1 FNPhwSeq FROM TCNMPosHW
                WHERE FTPosCode = '".$ptPhwPosCode."'
                ORDER BY FNPhwSeq DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            return $oQuery->row_array()["FNPhwSeq"];
        }else{
            return 0;
        }
    }



    //Functionality : Checkduplicate SaleMachine Device
    //Parameters : function parameters
    //Creator : 05/11/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSnMPHWCheckDuplicate($ptPhwCode,$ptPosCode,$ptBchCode){
        $tSQL = "SELECT COUNT(PHW.FTPhwCode) AS counts
                 FROM TCNMPosHW PHW
                 WHERE PHW.FTPhwCode = '$ptPhwCode'
                 AND PHW.FTBchCode ='$ptBchCode'
                 AND PHW.FTPosCode = '$ptPosCode'
                 ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array()['counts'];
        }else{
            return FALSE;
        }
    }

    //Functionality : Update Product SaleMachine Device (TCNMPosHW)
    //Parameters : function parameters
    //Creator : 05/11/2018 Witsarut
    //Update : 03/04/2019 Pap
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPHWAddUpdateMaster($paDataSaleMachineDevice){
        try{
            // Update TCNMPosHW
            $this->db->where('FTBchCode', $paDataSaleMachineDevice['FTBchCode']);
            $this->db->where('FTPhwCode', $paDataSaleMachineDevice['FTPhwCode']);
            $this->db->where('FTPosCode', $paDataSaleMachineDevice['FTPosCode']);
            $this->db->update('TCNMPosHW',array(
                'FTBchCode'     => $paDataSaleMachineDevice['FTBchCode'],
                'FTPhwCode'     => $paDataSaleMachineDevice['FTPhwCode'],
                'FTShwCode'     => $paDataSaleMachineDevice['FTShwCode'],
                'FTPhwName'     => $paDataSaleMachineDevice['FTPhwName'],
                'FTPhwConnType' => $paDataSaleMachineDevice['FTPhwConnType'],
                'FTPhwConnRef'  => $paDataSaleMachineDevice['FTPhwConnRef'],
                'FTPhwCodeRef'  => $paDataSaleMachineDevice['FTPhwCodeRef'],
                'FTPhwCustom'   => $paDataSaleMachineDevice['FTPhwCustom'],
                'FDLastUpdOn'   => $paDataSaleMachineDevice['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataSaleMachineDevice['FTLastUpdBy']
            ));
            if($this->db->affected_rows() > 0){

                $this->db->set('FDLastUpdOn', $paDataSaleMachineDevice['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paDataSaleMachineDevice['FTLastUpdBy']);
                $this->db->where('FTBchCode', $paDataSaleMachineDevice['FTBchCode']);
                $this->db->where('FTPosCode', $paDataSaleMachineDevice['FTPosCode']);
                $this->db->update('TCNMPos');

                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SaleMachine Success',
                );
            }else{
                //Add TCNMPosHW
                $this->db->insert('TCNMPosHW', array(
                    'FTBchCode'     => $paDataSaleMachineDevice['FTBchCode'],
                    'FTPhwCode'     => $paDataSaleMachineDevice['FTPhwCode'],
                    'FTPosCode'     => $paDataSaleMachineDevice['FTPosCode'],
                    'FTShwCode'     => $paDataSaleMachineDevice['FTShwCode'],
                    'FNPhwSeq'      => $paDataSaleMachineDevice['FNPhwSeq'],
                    'FTPhwName'     => $paDataSaleMachineDevice['FTPhwName'],
                    'FTPhwConnType' => $paDataSaleMachineDevice['FTPhwConnType'],
                    'FTPhwConnRef'  => $paDataSaleMachineDevice['FTPhwConnRef'],
                    'FTPhwCodeRef'  => $paDataSaleMachineDevice['FTPhwCodeRef'],
                    'FTPhwCustom'   => $paDataSaleMachineDevice['FTPhwCustom'],
                    'FDLastUpdOn'   => $paDataSaleMachineDevice['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataSaleMachineDevice['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataSaleMachineDevice['FDCreateOn'],
                    'FTCreateBy'    => $paDataSaleMachineDevice['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){

                    $this->db->set('FDLastUpdOn', $paDataSaleMachineDevice['FDLastUpdOn']);
                    $this->db->set('FTLastUpdBy', $paDataSaleMachineDevice['FTLastUpdBy']);
                    $this->db->where('FTBchCode', $paDataSaleMachineDevice['FTBchCode']);
                    $this->db->where('FTPosCode', $paDataSaleMachineDevice['FTPosCode']);
                    $this->db->update('TCNMPos');

                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SaleMachine Device Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SaleMachine Device.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update SaleMachine (TCNMPosHW)
    //Parameters : function parameters
    //Creator : 05/11/2018 Witsarut
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMPHWAddUpdateLang($paDataSaleMachineDevice){
        try{
            //Update Sale Machine Device Lang
            $this->db->where('FTPhwCode', $paDataSaleMachineDevice['FTPhwCode']);
            $this->db->update('TCNMPosHW',array(
                'FTPhwName'     => $paDataSaleMachineDevice['FTPhwName'],
                'FTPosCode'     => $paDataSaleMachineDevice['FTPosCode']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SaleMachine Device Lang Success.',
                );
            }else{
                //Add Sale Machine Device Lang
                $this->db->insert('TCNMPosHW', array(
                    'FTPhwCode'     => $paDataSaleMachineDevice['FTPhwCode'],
                    'FTPosCode'     => $paDataSaleMachineDevice['FTPosCode']

                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SaleMachine Device Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SaleMachine Device Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete SaleMachine Device
    //Parameters : function parameters
    //Creator : 05/11/2018 Witsarut
    //Update : 03/04/2019 pap
    //Return : Status Delete
    //Return Type : array
    public function FSaMPHWDelAll($paData){
        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTPhwCode', $paData['FTPhwCode']);
        $this->db->delete('TCNMPosHW');

        if($this->db->affected_rows() > 0){
            //Success
            if(FCNnHSizeOf($paData['FTBchCode']) > 0){
                for($i=0;$i<FCNnHSizeOf($paData['FTBchCode']);$i++){
                    $tSQL = "SELECT * FROM TCNMPosHW WHERE FTPosCode = '".$paData["FTPosCode"]."' AND FTBchCode = '".$paData["FTBchCode"][$i]."' ORDER BY FNPhwSeq";
                    $oQuery = $this->db->query($tSQL);
                    if($oQuery->num_rows() > 0){
                        $aResult = $oQuery->result_array();
                        for($nI=0;$nI<FCNnHSizeOf($aResult);$nI++){
                            $tSQL = "UPDATE TCNMPosHW SET
                                        FNPhwSeq = '".($nI+1)."'
                                    WHERE FTPhwCode = '".$aResult[$nI]["FTPhwCode"]."'
                                    AND FTBchCode = '$paData[FTBchCode][$i]'
                                    ";
                            $this->db->query($tSQL);
                        }
                    }
                }
            }else{
                $tSQL = "SELECT * FROM TCNMPosHW WHERE FTPosCode = '".$paData["FTPosCode"]."' AND FTBchCode = '$paData[FTBchCode]' ORDER BY FNPhwSeq";
                $oQuery = $this->db->query($tSQL);
                if($oQuery->num_rows() > 0){
                    $aResult = $oQuery->result_array();
                    for($nI=0;$nI<FCNnHSizeOf($aResult);$nI++){
                        $tSQL = "UPDATE TCNMPosHW SET
                                    FNPhwSeq = '".($nI+1)."'
                                WHERE FTPhwCode = '".$aResult[$nI]["FTPhwCode"]."'
                                AND FTBchCode = '".$paData["FTBchCode"]."'
                                ";
                        $this->db->query($tSQL);
                    }
                }
            }
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => $tSQL,
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

        // try{
        //     $this->db->trans_begin();

        //     $this->db->where_in('FTPhwCode', $paData['FTPhwCode']);
        //     $this->db->delete('TCNMPosHW');

        //     if($this->db->trans_status() === FALSE){
        //         $this->db->trans_rollback();
        //         $aStatus = array(
        //             'rtCode' => '905',
        //             'rtDesc' => 'Delete Unsuccess.',
        //         );
        //     }else{
        //         $this->db->trans_commit();
        //         $aStatus = array(
        //             'rtCode' => '1',
        //             'rtDesc' => 'Delete Success.',
        //         );
        //     }
        //     return $aStatus;
        // }catch(Exception $Error){
        //     echo $Error;
        // }
    }

    //Functionality : get all row data from phw
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMPHWGetAllNumRow($ptPosCode){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMPosHW WHERE FTPosCode = '".$ptPosCode."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }


    //Functionality : CheckInputGenCode
    //Parameters : - form cSaleMacinDevice
    //Creator : - 26/09/2019 Saharat(Golf)
    //Return : array
    //Return Type : array
    public function FSaMCheckInputGenCode($paData){
        $tPosCode = $paData['tPosCode'];
        $tPhwCode = $paData['tPhwCode'];

        $tSQL = "SELECT COUNT (FTPhwCode) AS nNum
        FROM TCNMPosHW
        WHERE 1=1
        AND FTPosCode = '$tPosCode'
        AND FTPhwCode = '$tPhwCode'
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }

    }

    /*
    //Functionality : get bch
    //Parameters : ptPosCode salemachine
    //Creator : - 19/2/2020  nonpawich
    //Return : object
    //Return Type : object
    */
    function FSaMGetBch($ptPosCode){
        $tPosCode = $ptPosCode;

        $tSQL = "SELECT FTBchCode FROM TCNMPosHW
        WHERE 1=1
        AND FTPosCode = '$tPosCode'  ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }


    }










}
