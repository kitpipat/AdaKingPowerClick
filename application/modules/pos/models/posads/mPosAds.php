<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPosAds extends CI_Model {

    //Functionality : list PosAds
    //Parameters : function parameters
    //Creator :  30/10/2018 Witsarut
    //Last Update : 11/08/2020 Napat(Jame) เพิ่มการ where BchCode จาก parameters
    //Return : data
    //Return Type : Array
    public function FSaMADSList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPsdSeq DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        ADS.FTBchCode       AS rtBchCode,
                                        ADS.FTShpCode       AS rtShpCode,
                                        ADS.FTPosCode       AS rtPosCode,
                                        ADS.FNPsdSeq        AS rtPsdSeq,
                                        ADS.FTPsdPosition   AS rtPsdPosition,
                                        ADS.FTAdvCode       AS rtAdvCode,
                                        ADS.FNPsdWide       AS rtPsdWide,
                                        ADS.FNPsdHigh       AS rtPsdHigh,
                                        --BCH_L.FTBchName     AS rtBchName,
                                        --SHP_L.FTShpName     AS rtShpName,
                                        POSL.FTPosComName   AS rtPosComName,
                                        ADMSG_L.FTAdvMsg    AS rtAdsMsg,
                                        ADMSG_L.FTAdvName   AS rtAdsName,
                                        ADMSG.FTAdvType     AS rtAdvType,
                                        MedObj.FTMedRefID   AS rtMedRefID,
                                        ADS.FDCreateOn
                                    FROM [TCNMPosAds] ADS
                                    --LEFT JOIN [TCNMBranch_L] BCH_L ON ADS.FTBchCode = BCH_L.FTBchCode
                                    --LEFT JOIN [TCNMShop_L] SHP_L ON ADS.FTShpCode = SHP_L.FTShpCode
                                    LEFT JOIN [TCNMPosLastNo] POSL ON ADS.FTPosCode = POSL.FTPosCode
                                    LEFT JOIN [TCNMAdMsg_L] ADMSG_L ON ADS.FTAdvCode = ADMSG_L.FTAdvCode
                                    LEFT JOIN [TCNMAdMsg] ADMSG ON ADS.FTAdvCode = ADMSG.FTAdvCode
                                    LEFT JOIN [TCNMMediaObj] MedObj ON ADS.FTAdvCode = MedObj.FTMedRefID
                                    WHERE 1=1 
                                    AND ADS.FTPosCode = '$paData[tPosCode]'
                                    AND ADS.FTBchCode = '$paData[tBchCode]'
                          ";

            // if($this->session->userdata("tSesUsrLevel") != "HQ"){
            //     $tBchCode = $this->session->userdata("tSesUsrBchCode");
            //     $tSQL .= " AND ADS.FTBchCode  = '$tBchCode' ";
            // }

            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                $tShpCode = $this->session->userdata("tSesUsrShpCode");
                $tSQL .= " AND ADS.FTShpCode  = '$tShpCode' ";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (ADS.FTAdvCode COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            // echo $tSQL;
            // exit;

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMADSGetPageAll($paData);
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
                // print_r($aResult);

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

    //Functionality : All Page Of PosAds
    //Parameters : function parameters
    //Creator :  20/09/2018 Witsarut (Bell)
    //Last Update : 11/08/2020 Napat(Jame) เพิ่มการ where BchCode จาก parameters
    //Return : object Count All PosAds
    //Return Type : Object
    public function FSoMADSGetPageAll($paData){
        try{
            $tSearchList    = $paData['tSearchAll'];
            $tSQL = "   SELECT COUNT (ADS.FTAdvCode) AS counts
                        FROM [TCNMPosAds] ADS WITH(NOLOCK)
                        WHERE 1=1 
                            AND ADS.FTPosCode = '$paData[tPosCode]'
                            AND ADS.FTBchCode = '$paData[tBchCode]'
                     ";

            // if($this->session->userdata("tSesUsrLevel") != "HQ"){
            //     $tBchCode = $this->session->userdata("tSesUsrBchCode");
            //     $tSQL .= " AND ADS.FTBchCode  = '$tBchCode' ";
            // }

            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                $tShpCode = $this->session->userdata("tSesUsrShpCode");
                $tSQL .= " AND ADS.FTShpCode  = '$tShpCode' ";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (ADS.FTAdvCode COLLATE THAI_BIN LIKE  '%$tSearchList%')";
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


    //Functionality : Get Data PosAds By ID
    //Parameters : function parameters
    //Creator : 30/10/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMADSGetDataByID($paData){
        try{
            $tAdsCode   = $paData['FTAdvCode'];
            $tSQL       = " SELECT 
                                ADS.FTBchCode   AS rtBchCode,
                                ADS.FTShpCode   AS rtShpCode,
                                ADS.FTPosCode   AS rtPosCode,
                                ADS.FNPsdSeq    AS rtPsdSeq,
                                ADS.FTPsdPosition AS rtPsdPosition,
                                ADS.FTAdvCode   AS rtAdvCode,
                                ADS.FNPsdWide   AS rtPsdWide,
                                ADS.FNPsdHigh   AS rtPsdHigh,
                                BCH_L.FTBchName  AS rtBchName,
                                SHP_L.FTShpName  AS rtShpName,
                                POSL.FTPosComName AS rtPosComName,
                                ADMSG_L.FTAdvName AS rtAdsName,
                                MedObj.FTMedRefID AS rtMedRefID

                            FROM [TCNMPosAds] ADS
                            LEFT JOIN [TCNMBranch_L] BCH_L ON ADS.FTBchCode = BCH_L.FTBchCode 
                            LEFT JOIN [TCNMShop_L] SHP_L ON ADS.FTShpCode = SHP_L.FTShpCode
                            LEFT JOIN [TCNMPosLastNo] POSL ON ADS.FTPosCode = POSL.FTPosCode
                            LEFT JOIN [TCNMAdMsg_L] ADMSG_L ON ADS.FTAdvCode = ADMSG_L.FTAdvCode
                            LEFT JOIN [TCNMMediaObj] MedObj ON ADS.FTAdvCode = MedObj.FTMedRefID
                            WHERE 1=1 AND ADS.FTAdvCode = '$tAdsCode' ";
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

   

    //Functionality : Update Product PosAds (TCNMPos)
    //Parameters : function parameters
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMADSAddUpdateMaster($paData){
        try{
            // Update TCNMPosAds
            $this->db->set('FTPsdPosition' , $paData['FTPsdPosition']);
            $this->db->set('FNPsdWide' , $paData['FNPsdWide']);
            $this->db->set('FNPsdHigh' , $paData['FNPsdHigh']);
            $this->db->set('FDPsdStart' , $paData['FDPsdStart']);
            $this->db->set('FDPsdStop' , $paData['FDPsdStop']);
            $this->db->set('FTAdvCode' , $paData['FTAdvCode']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->where('FTPosCode', $paData['FTPosCode']);
            $this->db->where('FNPsdSeq',  $paData['FNPsdSeq']);
            $this->db->update('TCNMPosAds');
            if($this->db->affected_rows() > 0){

                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->where('FTBchCode', $paData['FTBchCode']);
                $this->db->where('FTPosCode', $paData['FTPosCode']);
                $this->db->update('TCNMPos');

                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update PosAds Success',
                );
            }else{
                //Add TCNMPosAds
                $this->db->insert('TCNMPosAds', array(
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTShpCode'     => $paData['FTShpCode'],
                    'FTPosCode'     => $paData['FTPosCode'],
                    'FNPsdSeq'      => $paData['FNPsdSeq'],
                    'FTPsdPosition' => $paData['FTPsdPosition'],
                    'FNPsdWide'     => $paData['FNPsdWide'],
                    'FNPsdHigh'     => $paData['FNPsdHigh'],
                    'FDPsdStart'    => $paData['FDPsdStart'],
                    'FDPsdStop'     => $paData['FDPsdStop'],
                    'FTAdvCode'     => $paData['FTAdvCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy']
                ));
                if($this->db->affected_rows() > 0){

                    $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                    $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                    $this->db->where('FTBchCode', $paData['FTBchCode']);
                    $this->db->where('FTPosCode', $paData['FTPosCode']);
                    $this->db->update('TCNMPos');

                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add PosAds Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit PosAds.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete PosAds
    //Parameters : function parameters
    //Creator : 30/10/2018 Witsarut
    //Return : Status Delete
    //Return Type : array
    public function FSaMADSDelAll($paData){
   
        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        $this->db->where_in('FTPosCode', $paData['FTPosCode']);
        $this->db->where_in('FNPsdSeq', $paData['FNPsdSeq']);
        $this->db->delete('TCNMPosAds');

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


    //Functionality : Get MediaRefID
    //Parameters : function parameters
    //Creator : 15/02/2019 Bell
    //Return : Status Get MediaRefID
    //Return Type : array
    public function FSaMADSGetMediaRefID($ptPosAdsVdCode){
        $tSQL   = " SELECT
                        Med.FTMedRefID,
                        Med.FNMedSeq,
                        Med.FNMedType,
                        Med.FTMedFileType,
                        Med.FTMedPath
                    FROM TCNMMediaObj Med
                    WHERE 1=1 
                    AND Med.FTMedRefID = '$ptPosAdsVdCode'
                    ORDER BY Med.FNMedSeq ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->result_array();
            $aResult    = array(
                'raItems'	=> $aDetail,
                'rtCode'	=> '1',
                'rtDesc'	=> 'success'
            );
        }else{
            $aResult = array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }


    //Functionality : Get MediaRefID
    //Parameters : function parameters
    //Creator : 15/02/2019 Bell
    //Return : Status Get MediaRefID
    //Return Type : array
    public function FSaMADSGetImageobj($ptPosAdsVdCode){
        $tSQL = " SELECT  
                IMGObj.FTImgRefID,
                IMGObj.FNImgSeq,
                IMGObj.FTImgTable,
                IMGObj.FTImgKey,
                IMGObj.FTImgObj
            FROM TCNMImgObj IMGObj
            WHERE 1=1
            AND IMGObj.FTImgRefID = '$ptPosAdsVdCode'
            ORDER BY  IMGObj.FNImgSeq ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->result_array();
            $aResult    = array(
                'raItems'	=> $aDetail,
                'rtCode'	=> '1',
                'rtDesc'	=> 'success'
            );
        }else{
            $aResult = array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    //Functionality : Get AdsMsg
    //Parameters : function parameters
    //Creator : 04/09/2019 Bell
    //Return : Status Get MsgRefID
    //Return Type : array
    public function FSaMADSGetAdsMsg($ptPosAdsVDCode){

            $tSQL =   "SELECT
                        ADV.FTAdvCode AS rtAdvCode,
                        ADV.FTAdvType AS rtAdvType,
                        ADVL.FTAdvName AS rtAdvName,
                        ADVL.FTAdvMsg AS rtAdvMsg
                FROM [TCNMAdMsg] ADV
                LEFT JOIN [TCNMAdMsg_L] ADVL ON ADVL.FTAdvCode = ADV.FTAdvCode
                WHERE 1=1 
                AND ADV.FTAdvCode = '$ptPosAdsVDCode'
            ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aDetail    = $oQuery->result_array();
                $aResult    = array(
                    'raItems'	=> $aDetail,
                    'rtCode'	=> '1',
                    'rtDesc'	=> 'success'
                );
            }else{
                $aResult = array(
                    'rtCode'	=> '800',
                    'rtDesc'	=> 'data not found'
                );
            }
            return $aResult;
    }

    //Functionality : Count Seq
    //Parameters : function parameters
    //Creator : 05/11/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSnMCountSeq($ptDataWhere){
        $tSQL = "   SELECT COUNT(PADS.FNPsdSeq) AS counts
                    FROM TCNMPosAds PADS WITH(NOLOCK)
                    WHERE 1=1
                        AND PADS.FTBchCode = '$ptDataWhere[tBchCode]'
                        AND PADS.FTPosCode = '$ptDataWhere[tPosCode]'
                        AND PADS.FTShpCode = '$ptDataWhere[tShpCode]'
                ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array()["counts"];
        }else{
            return 0;
        }
    }
    
    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 17/09/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMPosAdsDeleteMultiple($paData){
        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        $this->db->where_in('FTPosCode', $paData['FTPosCode']);
        $this->db->where_in('FNPsdSeq',  $paData['FNPsdSeq']);
        $this->db->delete('TCNMPosAds');
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

    //Functionality : Update Seq Number In Table Pos Ads
    //Parameters : function parameters
    //Creator : 26/07/2019 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMPosAdsUpdateSeqNumber(){
        $tSessionUserEdit   = $this->session->userdata('tSesUsername');
        $tSQL   = " UPDATE TBLUPD
                    SET
                        TBLUPD.FNPsdSeq	        = TBLSEQ.nRowID,
                        TBLUPD.FDLastUpdOn      = CONVERT(VARCHAR(19),GETDATE(),121),
                        TBLUPD.FTLastUpdBy      = '$tSessionUserEdit'
                    FROM TCNMPosAds TBLUPD WITH(NOLOCK)
                    INNER JOIN (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FNPsdSeq ASC) AS nRowID,*
                        FROM TCNMPosAds WITH(NOLOCK)
                    ) AS TBLSEQ 
                    ON 1=1
                    AND TBLUPD.FTBchCode	= TBLSEQ.FTBchCode
                    AND TBLUPD.FTShpCode	= TBLSEQ.FTShpCode
                    AND TBLUPD.FTPosCode	= TBLSEQ.FTPosCode
        ";
        return $this->db->query($tSQL);
    }


    //Functionality : Get Data For Branch And Shop
    //Parameters : function parameters
    //Creator : 26/07/2019 Wasin
    //Return : data
    //Return Type : Array
    public function FSxMGetPosInfor($tPosCode){
        $tSQL = "SELECT TVDMPosShop.FTBchCode,
                        TCNMBranch_L.FTBchName,
                        TVDMPosShop.FTShpCode, 
                        TCNMShop_L.FTShpName,
                        TCNMPos.FTPosCode
                FROM TCNMPos
                LEFT JOIN TVDMPosShop ON TCNMPos.FTPosCode = TVDMPosShop.FTPosCode
                LEFT JOIN TCNMBranch_L ON TVDMPosShop.FTBchCode = TCNMBranch_L.FTBchCode
                LEFT JOIN TCNMShop_L ON TVDMPosShop.FTBchCode = TCNMShop_L.FTBchCode AND TVDMPosShop.FTShpCode = TCNMShop_L.FTShpCode
                WHERE TCNMPos.FTPosCode = '".$tPosCode."'";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return false;
        }
    }



    //Functionality : Get Data PosAds By ID
    //Parameters : function parameters
    //Creator : 16/09/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMADSGetDataByIDEdit($paData){
        try{
            $tPosCode   = $paData['ptPosCode'];
            $tBchCode   = $paData['ptBchCode'];
            $tShpCode   = $paData['ptShpCode'];
            $tPsdSeq    = $paData['ptPsdSeq'];
            $nLangEdit  = $paData['nLangEdit'];
            $tSQL       = " SELECT 
                                TPA.FTBchCode AS rtBchCode,
                                TPA.FTShpCode AS rtShpCode,
                                TPA.FTPosCode AS rtPosCode,
                                TPA.FNPsdSeq  AS rtPsdSeq,
                                TPA.FTPsdPosition AS rtPsdPosition,
                                TPA.FTAdvCode AS rtAdvCode,
                                TPA.FNPsdWide AS rtPsdWide,
                                TPA.FNPsdHigh AS rtPsdHigh,
                                TML.FTAdvName AS rtAdvName,
                                TPA.FDPsdStart AS rtDateStart,
                                TPA.FDPsdStop  AS rtDateStop
                                FROM TCNMPosAds TPA 
                                LEFT JOIN  TCNMAdMsg_L TML ON TPA.FTAdvCode = TML.FTAdvCode 
                                AND TML.FNLngID = '".$nLangEdit."'
                                WHERE 1=1 AND TPA.FNPsdSeq = '".$tPsdSeq."'  ";
                if(isset($tPosCode) && !empty($tPosCode)){
                    $tSQL .= " AND FTPosCode = '".$tPosCode."' ";
                }
                if(isset($tBchCode) && !empty($tBchCode)){
                    $tSQL .= " AND FTBchCode = '".$tBchCode."' ";
                }
                if(isset($tShpCode) && !empty($tShpCode)){
                    $tSQL .= " AND FTShpCode = '".$tShpCode."' ";
                }           
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

    //Functionality : get all row 
    //Parameters : -
    //Creator : 11/06/2019 saharat(Golf)
    //Return : array result from db
    //Return Type : array
    public function FSnMPosGetAllNumRow($ptData){ 
        $tPosCode = $ptData['FTPosCode'][0];
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow 
        FROM TCNMPosAds 
        WHERE FTPosCode = '".$tPosCode."' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }



}