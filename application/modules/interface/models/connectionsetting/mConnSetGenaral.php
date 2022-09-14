<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mConnSetGenaral extends CI_Model {


    //Get Datatable List
    // Create By 18/05/2020 Witsarut (Bell)
    public function FSaMConnSetGenDataList($paData){

        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);

        $nLngID         = $paData['FNLngID'];
        $tSearchList    = $paData['tSearchAll'];

        $tSQL       = "SELECT c.* FROM(
            SELECT  ROW_NUMBER() OVER(ORDER BY FTCfgKey,FTCfgSeq ASC) AS rtRowID,* FROM
                (SELECT 
                        CONF.FTCfgCode,
                        CONF.FTCfgApp,
                        CONF.FTCfgKey,
                        CONF.FTCfgSeq,
                        CONF.FTGmnCode,
                        CONF.FTCfgStaAlwEdit,
                        CONF.FTCfgStaDataType,
                        CONF.FNCfgMaxLength,
                        CONF.FTCfgStaDefValue,
                        CONF.FTCfgStaDefRef,
                        CONF.FTCfgStaUsrValue,
                        CONF.FTCfgStaUsrRef,
                        CONFL.FTCfgName,
                        CONFL.FTCfgDesc,
                        CONFL.FTCfgRmk
                    FROM [TLKMConfig] CONF
                    LEFT JOIN [TLKMConfig_L] CONFL ON CONF.FTCfgCode = CONFL.FTCfgCode 
                    AND CONF.FTCfgApp = CONFL.FTCfgApp 
                    AND CONF.FTCfgKey = CONFL.FTCfgKey 
                    AND CONF.FTCfgSeq = CONFL.FTCfgSeq 
                    AND CONFL.FNLngID = $nLngID
                    WHERE 1=1
                    AND  CONF.FTCfgStaAlwEdit = '1'
                     ";
                    

            if ($tSearchList != ''){
                $tSQL .= " AND (CONFL.FTCfgName COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR CONF.FTCfgKey  COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR CONF.FTCfgStaDefValue  COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }

        $jResult  = json_encode($aResult);
        $aResult  = json_decode($jResult, true);
        return $aResult;
    }

    //Get Datatable ListAPI
    // Create By 18/05/2020 Witsarut (Bell)
    public function FSaMConnSetGenDataListApi($paData){
        
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchApi     = $paData['tSearchApi'];

            if($paData['tStaApiTxnType'] == '1'){
                // ประเภทของเส้น Interface 1=นำเข้า 2=ส่งออก  3= API (STD)  4=API (Link)
                // $tSQLWhere = " AND API.FTApiTxnType IN ('1','2','4') ";
                
                // เอาแคาเฉพาะ Type 4 API (LINK)
                $tSQLWhere = " AND API.FTApiTxnType IN ('4') ";
            }else{
                $tSQLWhere = " AND API.FTApiTxnType = '3' ";
            }

            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FTApiGrpPrc,FNApiGrpSeq ASC) AS rtRowID,* FROM
                    (SELECT DISTINCT
                        API.FTApiCode,
                        API.FTApiTxnType,
                        API.FTApiPrcType,
                        API.FTApiGrpPrc,
                        API.FNApiGrpSeq,
                        API.FTApiURL,
                        API.FTApiLoginUsr,
                        API.FTApiLoginPwd,
                        API.FTApiToken,
                        API.FTApiFmtCode,
                        APIL.FTApiName,
                        APIL.FTApiRmk,
                        FMTL.FTApiFmtName
                FROM [TCNMTxnAPI] API
                LEFT JOIN [TCNMTxnAPI_L] APIL ON API.FTApiCode  = APIL.FTApiCode AND APIL.FNLngID = $nLngID
                LEFT JOIN [TSysFormatAPI_L] FMTL ON API.FTApiFmtCode = FMTL.FTApiFmtCode AND FMTL.FNLngID = $nLngID
                WHERE 1 = 1 
                $tSQLWhere
            ";
                if(isset($tSearchApi) && !empty($tSearchApi)){ 
                    if($tSearchApi == 'นำเข้า'){
                        $tSQL .= " AND (API.FTApiTxnType = 1) "; 
                    }else if($tSearchApi == 'ส่งออก'){
                        $tSQL .= " AND (API.FTApiTxnType = 2) ";
                    }else if($tSearchApi == 'API'){     
                        $tSQL .= " AND (API.FTApiTxnType = 4) ";
                    }else{
                        $tSQL .= " AND (API.FNApiGrpSeq LIKE '%$tSearchApi%'";
                        $tSQL .= " OR API.FTApiGrpPrc LIKE '%$tSearchApi%'";
                        $tSQL .= " OR APIL.FTApiName   LIKE '%$tSearchApi%'";
                        $tSQL .= " OR API.FTApiURL LIKE '%$tSearchApi%')";
                    }
                }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $oList = $oQuery->result();
                $aResult    = array(
                    'raItems'       => $oList,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                $aResult    = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found',
                );
            }

            $jResult  = json_encode($aResult);
            $aResult  = json_decode($jResult, true);
            return $aResult;
    }

    //Update Table TLKMConfig
    // Create By Witsarut 18/05/2020
    public function FSaMCSSUpdate($paData){
        try{
            $this->db->set('FDLastUpdOn', date('Y-m-d h:i:s'));
            $this->db->set('FTLastUpdBy', $this->session->userdata("tSesUserCode"));
            $this->db->set('FTCfgStaUsrValue', $paData['FTCfgStaUsrValue']);
            $this->db->where('FTCfgCode', $paData['FTCfgCode']);
            $this->db->where('FTCfgApp', $paData['FTCfgApp']);
            $this->db->where('FTCfgKey', $paData['FTCfgKey']);
            $this->db->where('FTCfgSeq', $paData['FTCfgSeq']);
            $this->db->update('TLKMConfig');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Fail Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    // Update Table TCNMTxnAPI
    // Create by Witsarut 19/05/2020
    public function FSaMCSSUpdateApi($paData){
        try{
            $this->db->set('FDLastUpdOn', date('Y-m-d h:i:s'));
            $this->db->set('FTLastUpdBy', $this->session->userdata("tSesUserCode"));
            $this->db->set('FNApiGrpSeq', $paData['FNApiGrpSeq']);
            // $this->db->set('FTApiGrpPrc', $paData['FTApiGrpPrc']);
            $this->db->set('FTApiURL', $paData['FTApiURL']);
            $this->db->set('FTApiLoginUsr', $paData['FTApiLoginUsr']);
            $this->db->set('FTApiLoginPwd', $paData['FTApiLoginPwd']);
            $this->db->set('FTApiFmtCode', $paData['FTApiFmtCode']);
            $this->db->set('FTApiToken', $paData['FTApiToken']);
            $this->db->where('FTApiCode', $paData['FTApiCode']);
            $this->db->update('TCNMTxnAPI');
            if($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Update Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Fail Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    //function chkDupicate
    // Create By witsarut 20/05/2020
    public function FSaMCheckCodeDup($paData){

        $tApiGrpSeq  = $paData['FNApiGrpSeq'];
        $tApiCode    = $paData['FTApiCode'];

        $tSQL = "SELECT 
                    API.FNApiGrpSeq 
                FROM [TCNMTxnAPI] API WITH(NOLOCK)
                WHERE 1=1
                AND FNApiGrpSeq = '$tApiGrpSeq'
        ";
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
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
    }


    //Functionality : check Data PageEDit TCNMTxnSpcAPI
    //Parameters : function parameters
    //Creator : 29/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMSettingGenDataList($paData, $paDataApiCode){
        try{
            $nLngID     = $paData['FNLngID'];
            $tApiCode   = $paDataApiCode['tApiCode'];
            $tSearchApiAuthor = $paData['tSearchApiAuthor'];
            $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);

            $tSQL     = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS rtRowID,* FROM
                                (SELECT DISTINCT
                                    SPCAPI.FTApiCode,
                                    SPCAPI.FTAgnCode,
                                    SPCAPI.FTBchCode,
                                    SPCAPI.FTApiURL,
                                    SPCAPI.FTSpaUsrCode,
                                    SPCAPI.FTSpaUsrPwd,
                                    SPCAPI.FTSpaApiKey,
                                    SPCAPI.FTSpaRmk,
                                    SPCAPI.FDCreateOn,
                                    AGN_L.FTAgnName,
                                    BCH_L.FTBchName
                            FROM [TCNMTxnSpcAPI] SPCAPI WITH(NOLOCK)
                            LEFT JOIN [TCNMAgency_L] AGN_L ON SPCAPI.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                            LEFT JOIN [TCNMBranch_L] BCH_L ON SPCAPI.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                            WHERE 1=1 AND SPCAPI.FTApiCode  = '$tApiCode' ";

                    if(isset($tSearchApiAuthor) && !empty($tSearchApiAuthor)){ 
                        $tSQL .= " AND (AGN_L.FTAgnName  LIKE '%$tSearchApiAuthor%'";
                        $tSQL .= " OR BCH_L.FTBchName LIKE '%$tSearchApiAuthor%'";
                        $tSQL .= " OR SPCAPI.FTSpaUsrCode LIKE '%$tSearchApiAuthor%'";
                        $tSQL .= " OR SPCAPI.FTSpaUsrPwd LIKE '%$tSearchApiAuthor%'";
                        $tSQL .= " OR SPCAPI.FTSpaApiKey LIKE '%$tSearchApiAuthor%')";
                    }

                    $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

                    $oQuery = $this->db->query($tSQL);

                    if($oQuery->num_rows() > 0){
                        $aList      = $oQuery->result_array();
                        $oFoundRow  = $this->FSoMSetGetPageAll($tSearchApiAuthor, $tApiCode);
                        $nFoundRow  = $oFoundRow[0]->counts;
                        $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                        $aResult    = array(
                            'raItems'       => $aList,
                            'rnAllRow'      => $nFoundRow,
                            'rnCurrentPage' => $paData['nPage'],
                            'rnAllPage'     => $nPageAll,
                            'rtCode'        => '1',
                            'rtDesc'        => 'success',
                            'tSQL'          => $tSQL
                        );
                    }else{
                        //No Data
                        $aResult = array(
                            'rnAllRow'      => 0,
                            'rnCurrentPage' => $paData['nPage'],
                            "rnAllPage"     => 0,
                            'rtCode'        => '800',
                            'rtDesc'        => 'data not found'
                        );
                    }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : All Page 
    //Parameters : function parameters
    //Creator :  22/11/2018 Witsarut 
    //Return : object Count All Department
    //Return Type : Object
    public function FSoMSetGetPageAll($tSearchApiAuthor, $tApiCode){
        try{
            $tSQL = "SELECT COUNT (SPCAPI.FTApiCode) AS counts
                     FROM [TCNMTxnSpcAPI] SPCAPI WITH(NOLOCK)
                     WHERE 1=1 AND SPCAPI.FTApiCode  = '$tApiCode'";

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


    //Functionality : check Data PageEDit
    //Parameters : function parameters
    //Creator : 29/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMSettingGenCheckID($paData){

        $tnLngID     = $paData['FNLngID'];
        $tApiGrpSeq  = $paData['FNApiGrpSeq'];
        $tApiCode    = $paData['tApiCode'];

        $tSQL = "SELECT 
                    API.FTApiCode,
                    API.FTApiTxnType,
                    API.FTApiPrcType,
                    API.FTApiGrpPrc,
                    API.FNApiGrpSeq,
                    API.FTApiURL,
                    API.FTApiFmtCode,
                    API_L.FTApiName
                FROM [TCNMTxnAPI] API  WITH(NOLOCK)
                LEFT JOIN [TCNMTxnAPI_L] API_L ON API.FTApiCode = API_L.FTApiCode AND API_L.FNLngID = $tnLngID
                WHERE 1=1 
                AND API.FNApiGrpSeq = '$tApiGrpSeq'
                AND API.FTApiCode = '$tApiCode'";

        $oQuery  = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oDetail   = $oQuery->result();
            $aResult   = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            ); 
        }else{
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : check Data CompCode
    //Parameters : function parameters
    //Creator : 29/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMSettingGenCompCode(){
        try{
            $nLngID  =  $this->session->userdata("tLangEdit");

            $tSQL = "SELECT
                        CMP.FTCmpCode  AS rtCmpCode,
                        CMPL.FTCmpName    AS rtCmpName
                    FROM [TCNMComp] CMP
                    LEFT JOIN [TCNMComp_L]  CMPL ON CMP.FTCmpCode = CMPL.FTCmpCode  AND CMPL.FNLngID = $nLngID
            ";
            $oQuery  = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $oDetail   = $oQuery->result();
                $aResult   = array(
                    'raItems'   => $oDetail[0],
                    'rtCode'    => '1',
                    'rtDesc'    => 'success'
                ); 
            }else{
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


    // function Add into TCNMTxnSpcAPI
    // Create By Witsarut 01/06/2020
    public function FSaMSetAddUpdateMaster($paData){
        try{
            $this->db->set('FTSpaUsrCode', $paData['FTSpaUsrCode']);
            $this->db->set('FTSpaUsrPwd', $paData['FTSpaUsrPwd']);
            $this->db->set('FTSpaApiKey', $paData['FTSpaApiKey']);
            $this->db->set('FTApiURL', $paData['FTApiURL']);
            $this->db->set('FTSpaRmk', $paData['FTSpaRmk']);
            $this->db->set('FTApiFmtCode', $paData['FTApiFmtCode']);
            $this->db->set('FDCreateOn', $paData['FDCreateOn']);
            $this->db->set('FTCreateBy', $paData['FTCreateBy']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->where('FTApiCode', $paData['FTApiCode']);
            $this->db->where('FTCmpCode', $paData['FTCmpCode']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->update('TCNMTxnSpcAPI');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aResult  = array(
                    'FTApiCode'     => $paData['FTApiCode'],
                    'FTCmpCode'     => $paData['FTCmpCode'],
                    'FTAgnCode'     => $paData['FTAgnCode'],
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTApiFmtCode'  => $paData['FTApiFmtCode'],
                    'FTMerCode'     => $paData['FTMerCode'],
                    'FTShpCode'     => $paData['FTShpCode'],
                    'FTPosCode'     => $paData['FTPosCode'],
                    'FTApiURL'      => $paData['FTApiURL'],
                    'FTSpaUsrCode'  => $paData['FTSpaUsrCode'],
                    'FTSpaUsrPwd'   => $paData['FTSpaUsrPwd'],
                    'FTSpaApiKey'   => $paData['FTSpaApiKey'],
                    'FTSpaRmk'      => $paData['FTSpaRmk'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'], 
                    'FTLastUpdBy'   => $paData['FTLastUpdBy']
                );
                //Insert
                $this->db->insert('TCNMTxnSpcAPI', $aResult);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            // $jStatus = json_encode($aStatus);
            // $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By Witsarut 26/06/2020
    // Function Insert  TCNMTxnAPI
    public function FSaMSetAddUpdateMasterTxnApi($paData){
        try{
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->where('FTApiCode', $paData['FTApiCode']);
            $this->db->update('TCNMTxnAPI');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aResult  = array(
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'], 
                );
                //Insert
                $this->db->insert('TCNMTxnAPI', $aResult);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete 
    //Parameters : Ajax jReason()
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSnMSetGenaralDel($paData){
        $this->db->where('FTApiCode', $paData['FTApiCode']);
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TCNMTxnSpcAPI');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Success', 
            );
        }else{
            // UnSuccess
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item',
            ); 
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : Get all row 
    //Parameters : -
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMTxnSpcAPI";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    //Functionality : check Data ApiAuthor
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMSetGenaralCheckID($paData){
         $tApiCode  = $paData['tAPIApiCode'];
         $tAgnCode  = $paData['tAgnCode'];
         $tBchCode  = $paData['tBchCode'];
         $tCmpCode  = $paData['tCmpCode'];
         $nLngID    = $paData['FNLngID'];

        $tSQL  = "SELECT 
                      SPCAPI.FTApiCode,
                      SPCAPI.FTCmpCode,
                      SPCAPI.FTAgnCode,
                      SPCAPI.FTBchCode,
                      SPCAPI.FTApiFmtCode,
                      SPCAPI.FTApiURL,
                      SPCAPI.FTSpaUsrCode,
                      SPCAPI.FTSpaUsrPwd,
                      SPCAPI.FTSpaApiKey,
                      SPCAPI.FTSpaRmk,
                      AGN_L.FTAgnName,
                      BCH_L.FTBchName,
                      FMT_L.FTApiFmtName
                FROM [TCNMTxnSpcAPI] SPCAPI  WITH(NOLOCK)
                LEFT JOIN [TCNMAgency_L] AGN_L ON SPCAPI.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                LEFT JOIN [TCNMBranch_L] BCH_L ON SPCAPI.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                LEFT JOIN [TSysFormatAPI_L] FMT_L ON SPCAPI.FTApiFmtCode = FMT_L.FTApiFmtCode AND FMT_L.FNLngID = $nLngID
                WHERE 1=1 AND SPCAPI.FTApiCode = '$tApiCode'
                AND SPCAPI.FTCmpCode = '$tCmpCode'
                AND SPCAPI.FTAgnCode = '$tAgnCode'
                AND SPCAPI.FTBchCode = '$tBchCode'

                 ";
            
            $oQuery = $this->db->query($tSQL);
        
            if ($oQuery->num_rows() > 0){
                $oDetail    = $oQuery->result();
                $aResult= array(
                    'raItems'   => $oDetail[0],
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
    }
   

    public function FSaMCSGSpcCheckDupplicate($paData){

        $this->db->where('FTApiCode', $paData['FTApiCode']);
        $this->db->where('FTCmpCode', $paData['FTCmpCode']);
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $oQuery =  $this->db->get('TCNMTxnSpcAPI');
        if($oQuery->num_rows() > 0){
            $aStatus = array(
                'rtCode' => '2',
                'rtDesc' => 'Data Duplicate',
            );
        }else{
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Data Not Duplicate',
            );  
        }

        return $aStatus;

    }
}


