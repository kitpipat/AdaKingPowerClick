<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mReciveSpcCfg extends CI_Model
{

    //Functionality : LIist ReciveSpc
    //Parameters : function parameters
    //Creator :  27/11/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMRCVSpcDataList($paData)
    {
        // $aDataUserInfo      = $this->session->userdata("tSesUsrInfo");


        $tUsrBchCodeDefult =  $this->session->userdata("tSesUsrBchCodeDefault");
        $tUsrBchNameDefult = $this->session->userdata("tSesUsrBchNameDefault");
        $tUsrBchCodeMulti =  $this->session->userdata("tSesUsrBchCodeMulti");
        $tUsrBchNameMulti =  $this->session->userdata("tSesUsrBchNameMulti");
        $nUsrBchCount =  $this->session->userdata("nSesUsrBchCount");

        $tUsrShpCodeDefult =  $this->session->userdata("tSesUsrShpCodeDefault");
        $tUsrShpNameDefult =  $this->session->userdata("tSesUsrShpNameDefault");
        $tUsrShpCodeMulti =  $this->session->userdata("tSesUsrShpCodeMulti");
        $tUsrShpNameMulti = $this->session->userdata("tSesUsrShpNameMulti");
        $nUsrShpCount =  $this->session->userdata("nSesUsrShpCount");


        try {

            $tRcvSpcCode    = $paData['FTRcvCode'];

            // Check User Level Branch HQ OR Bch Or Shop
            $tUserLevel = $this->session->userdata("tSesUsrLevel");
            $tWhereBch  = "";
            $tWhereShp  = "";
            if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH") {
                // Check User Level BCH
                // $tWhereBch  =   " AND RCVSPC.FTBchCode = '" . $aDataUserInfo['FTBchCode'] . "'";
                if ($nUsrBchCount > 1) {
                    $tWhereBch  =  " AND RCVSPC.FTBchCode IN ('$tUsrBchCodeMulti') ";
                } else {
                    $tWhereBch  =  " AND RCVSPC.FTBchCode = $tUsrBchCodeDefult ";
                }
            }
            if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "SHP") {
                // Check User Level SHP
                // $tWhereShp  =   " AND RCVSPC.FTShpCode = '" . $aDataUserInfo['FTShpCode'] . "'";
                if ($nUsrShpCount > 1) {
                    $tWhereShp  =  " AND RCVSPC.FTShpCode IN ('$tUsrShpCodeMulti') ";
                } else {
                    $tWhereShp  =  " AND RCVSPC.FTShpCode = $tUsrShpCodeDefult ";
                }
            }
            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FNRcvSeq ASC) AS rtRowID,*
                                FROM(
                                    SELECT DISTINCT 	
                                    FNRcvSeq
                                    FROM [TFNMRcvSpcConfig] RCVSPC WITH(NOLOCK)
                                    WHERE 1=1
                                    AND RCVSPC.FTRcvCode    = '$tRcvSpcCode'
                                    
            ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            // print_r($tSQL); die();
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aList      = $oQuery->result_array();

                $oFoundRow  = $this->FSoMRCVSpcGetPageAll($tSearchList, $paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'tSQL'          => $tSQL
                );
            } else {
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
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Count Userlogin
    //Parameters : function parameters
    //Creator :  19/08/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSoMRCVSpcGetPageAll($ptSearchList, $paData)
    {
        $tUsrBchCodeDefult =  $this->session->userdata("tSesUsrBchCodeDefault");
        $tUsrBchNameDefult = $this->session->userdata("tSesUsrBchNameDefault");
        $tUsrBchCodeMulti =  $this->session->userdata("tSesUsrBchCodeMulti");
        $tUsrBchNameMulti =  $this->session->userdata("tSesUsrBchNameMulti");
        $nUsrBchCount =  $this->session->userdata("nSesUsrBchCount");

        $tUsrShpCodeDefult =  $this->session->userdata("tSesUsrShpCodeDefault");
        $tUsrShpNameDefult =  $this->session->userdata("tSesUsrShpNameDefault");
        $tUsrShpCodeMulti =  $this->session->userdata("tSesUsrShpCodeMulti");
        $tUsrShpNameMulti = $this->session->userdata("tSesUsrShpNameMulti");
        $nUsrShpCount =  $this->session->userdata("nSesUsrShpCount");

        // Check User Level Branch HQ OR Bch Or Shop
        $tUserLevel = $this->session->userdata("tSesUsrLevel");
        $tWhereBch  = "";
        $tWhereShp  = "";
        if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH") {
            // Check User Level BCH
            // $tWhereBch  =   " AND RCVSPC.FTBchCode = '" . $aDataUserInfo['FTBchCode'] . "'";
            if ($nUsrBchCount > 1) {
                $tWhereBch  =  " AND RCVSPC.FTBchCode IN ('$tUsrBchCodeMulti') ";
            } else {
                $tWhereBch  =  " AND RCVSPC.FTBchCode = $tUsrBchCodeDefult ";
            }
        }
        if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "SHP") {
            // Check User Level SHP
            // $tWhereShp  =   " AND RCVSPC.FTShpCode = '" . $aDataUserInfo['FTShpCode'] . "'";
            if ($nUsrShpCount > 1) {
                $tWhereShp  =  " AND RCVSPC.FTShpCode IN ('$tUsrShpCodeMulti') ";
            } else {
                $tWhereShp  =  " AND RCVSPC.FTShpCode = $tUsrShpCodeDefult ";
            }
        }

        try {
            $tRcvSpcCode    = $paData['FTRcvCode'];
            // $tSQL       = " SELECT
            //                     COUNT (RCVSPC.FTRcvCode) AS counts
            //                 FROM [TFNMRcvSpcConfig] RCVSPC WITH(NOLOCK)
            //                 WHERE 1=1
            //                 AND RCVSPC.FTRcvCode    = '$tRcvSpcCode'        
            //                 -- $tWhereBch
            //                 --         $tWhereShp
            // ";
            $tSQL = " SELECT COUNT(c.FNRcvSeq) AS counts
            FROM
            (
                SELECT FNRcvSeq
                FROM
                (
                    SELECT DISTINCT 
                           FNRcvSeq
                    FROM [TFNMRcvSpcConfig] RCVSPC WITH(NOLOCK)
                    WHERE 1 = 1
                          AND RCVSPC.FTRcvCode = '$tRcvSpcCode' 
                ) Base
            ) AS c
            WHERE 1 = 1 ";

            if (isset($ptSearchList) && !empty($ptSearchList)) {
                $tSQL .= " AND (RCVSPC.FTRcvCode LIKE '%$ptSearchList%')";
            }
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : check Data Userlogin
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVSPCCheckID($paData)
    {
        $tRcvCode   = $paData['FTRcvCode'];
        $tAppCode   = $paData['FTAppCode'];
        $nRcvSeq    = $paData['FNRcvSeq'];
        $nLngID     = $paData['FNLngID'];

        $tSQL   = " SELECT 
                        RCVSPC.FTPosCode,
                        POSL.FTPosName,
                        RCVSPC.FTRcvCode,
                        RCVL.FTRcvName,
                        RCVSPC.FTBchCode,
                        BCHL.FTBchName,
                        RCVSPC.FTMerCode,
                        MERL.FTMerName,
                        RCVSPC.FTShpCode,
                        SHPL.FTShpName,
                        RCVSPC.FTAggCode,
                        AGGL.FTAggName,
                        RCVSPC.FTAppCode,
                        TSYSApp.FTAppName,
                        RCVSPC.FNRcvSeq,
                        RCVSPC.FTPdtRmk,
                        SHP.FTShpType
                        -- RCVSPC.FTAppStaAlwRet,
                        -- RCVSPC.FTAppStaAlwCancel,
                        -- RCVSPC.FTAppStaPayLast
                    FROM [TFNMRcvSpc] RCVSPC WITH(NOLOCK)
                    LEFT JOIN [TFNMRcv_L] RCVL WITH(NOLOCK) ON RCVSPC.FTRcvCode = RCVL.FTRcvCode 
                    LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON RCVSPC.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN [TCNMMerchant_L] MERL WITH(NOLOCK) ON RCVSPC.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                    LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON RCVSPC.FTShpCode = SHPL.FTShpCode AND RCVSPC.FTBchCode = SHPL.FTBchCode  AND SHPL.FNLngID = $nLngID
                    LEFT JOIN [TCNMAgencyGrp_L] AGGL WITH(NOLOCK) ON RCVSPC.FTAggCode = AGGL.FTAggCode AND AGGL.FNLngID = $nLngID
                    LEFT JOIN [TCNMPos_L] POSL WITH(NOLOCK) ON RCVSPC.FTPosCode = POSL.FTPosCode AND POSL.FNLngID = $nLngID
                    LEFT JOIN [TSysApp_L] TSYSApp WITH(NOLOCK) ON RCVSPC.FTAppCode = TSYSApp.FTAppCode AND TSYSApp.FNLngID = $nLngID
                    LEFT JOIN [TCNMShop] SHP WITH(NOLOCK) ON RCVSPC.FTShpCode = SHP.FTShpCode AND RCVSPC.FTBchCode = SHPL.FTBchCode
                    
                    
                    WHERE 1=1
                    AND RCVSPC.FTRcvCode = '$tRcvCode'
                    AND RCVSPC.FTAppCode = '$tAppCode'
                    AND RCVSPC.FNRcvSeq  = '$nRcvSeq'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail    = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //if data not found
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        unset($tRcvCode);
        unset($tAppCode);
        unset($nRcvSeq);
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oDetail);
        return $aResult;
    }


    //Functionality : check Data Config
    //Parameters : function parameters
    //Creator : 18/10/2020 Worakorn (Doz)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVSPCCheckIDConfig($pnRcvCode)
    {

        // $this->db->select('TFNMRcv.FTFmtCode,TSysRcvFmt.FTFmtStaAlwCfg');
        $this->db->select('*');
        $this->db->from('TFNMRcv');
        // $this->db->join('TSysRcvFmt','TSysRcvFmt.FTFmtCode = TFNMRcv.FTFmtCode');
        $this->db->where('FTRcvCode', $pnRcvCode);
        $oResult = $this->db->get();
        $aData = $oResult->result_array();
        // print_r($aData); die();

        $this->db->select('TSysRcvConfig.*,TSysRcvFmt.FTFmtStaAlwCfg');
        $this->db->from('TSysRcvConfig');
        $this->db->join('TSysRcvFmt', 'TSysRcvFmt.FTFmtCode = TSysRcvConfig.FTFmtCode');
        $this->db->where('TSysRcvConfig.FTFmtCode', $aData[0]['FTFmtCode']);
        $oResultConfig = $this->db->get();
        $aDataConfig = $oResultConfig->result_array();
        // print_r($aDataConfig); die();

        return $aDataConfig;

        // print_r($aData); die();
    }




    //Functionality : Get Data Config Value
    //Parameters : function parameters
    //Creator : 19/10/2020 Worakorn (Doz)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVSPCCheckIDConfigValue($pnRcvCode, $pnRcvSeq)
    {
        $this->db->select('*');
        $this->db->from('TFNMRcvSpcConfig');
        $this->db->where('FTRcvCode', $pnRcvCode);
        $this->db->where('FNRcvSeq', $pnRcvSeq);
        $oResultConfigVal = $this->db->get();
        $aDataConfigVal = $oResultConfigVal->result_array();
        // print_r($aDataConfig); die();

        return $aDataConfigVal;

        // print_r($aData); die();
    }

    //Functionality : Get Numrow Config Value
    //Parameters : function parameters
    //Creator : 19/10/2020 Worakorn (Doz)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVSPCCheckIDConfigNumrow($pnRcvCode, $pnRcvSeq)
    {
        $this->db->select('*');
        $this->db->from('TFNMRcvSpcConfig');
        $this->db->where('FTRcvCode', $pnRcvCode);
        $this->db->where('FNRcvSeq', $pnRcvSeq);
        $oResultConfigNum = $this->db->get();
        $nDataConfigNum = $oResultConfigNum->num_rows();
        // print_r($aDataConfig); die();

        return $nDataConfigNum;

        // print_r($aData); die();
    }



    //Functionality : Get Data Config Value For Select
    //Parameters : function parameters
    //Creator : 04/11/2020 Worakorn (Doz)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVSPCCheckIDConfigSelect($pnRcvCode)
    {
        $this->db->distinct();
        $this->db->select('FNRcvSeq');
        $this->db->from('TFNMRcvSpcConfig');
        $this->db->where('FTRcvCode', $pnRcvCode);
        $oResultConfigSel = $this->db->get();
        $aDataConfigSel = $oResultConfigSel->result_array();

        return $aDataConfigSel;

        // print_r($aData); die();
    }

    //Functionality : Count Seq
    //Parameters : function parameters
    //Creator : 27/09/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSnMRcvSpcCountSeq()
    {
        $tSQL = "SELECT COUNT(FNRcvSeq) AS counts
                FROM TFNMRcvSpc";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array()["counts"];
        } else {
            return FALSE;
        }
    }


    //Functionality : Checkduplicate Data 
    //Parameters : function parameters
    //Creator :  20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data Count Duplicate
    //Return Type : object
    public function FSaMRcvSpcCheckCrdCode($paData)
    {
        $tAppCode    = $paData['FTAppCode'];
        $tRcvCode    = $paData['FTRcvCode'];

        $tSQL = "SELECT 
                    RCVSPC.FTAppCode
                FROM [TFNMRcvSpc] RCVSPC WITH(NOLOCK)
                WHERE 1=1
                AND RCVSPC.FTRcvCode = '$tRcvCode'
                AND RCVSPC.FTAppCode = '$tAppCode'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
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

    //Functionality : Update Seq Number In Table TFNMRcvSpc
    //Parameters : function parameters
    //Creator : 28/11/2019 Witsarut (Bell)
    //Return : data
    //Return Type : Array
    public function FSaMRcvSpcUpdateSeqNumber()
    {
        $tSQL = " UPDATE RCVSPC
                SET
                RCVSPC.FNRcvSeq     = RCVSEQ.nRowID
            FROM TFNMRcvSpc RCVSPC WITH(NOLOCK)
            INNER JOIN (
                SELECT 
                ROW_NUMBER() OVER (PARTITION BY FTRcvCode ORDER BY FTRcvCode) nRowID , *
                FROM TFNMRcvSpc WITH(NOLOCK)
            ) AS RCVSEQ
            ON 1=1
            AND RCVSPC.FNRcvSeq     =  RCVSEQ.FNRcvSeq
            AND RCVSPC.FTRcvCode    =  RCVSEQ.FTRcvCode
        ";
        return $this->db->query($tSQL);
    }



    //Functionality : Function Add Update Master RCVSPC
    //Parameters : function parameters
    //Creator : 28/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function  FSaMRCVSPCAddMaster($paData)
    {
        $aResult    = array(
            'FTRcvCode'         => $paData['FTRcvCode'],
            'FTAppCode'         => $paData['FTAppCode'],
            // 'FTRcvSeq'         => $paData['FTRcvSeq'],
            'FTBchCode'         => $paData['FTBchCode'],
            'FTMerCode'         => $paData['FTMerCode'],
            'FTShpCode'         => $paData['FTShpCode'],
            'FTAggCode'         => $paData['FTAggCode'],
            'FTPdtRmk'          => $paData['FTPdtRmk'],
            'FTPosCode'         => $paData['FTPosCode'],
            // 'FTAppStaAlwRet'    => $paData['FTAppStaAlwRet'],
            // 'FTAppStaAlwCancel' => $paData['FTAppStaAlwCancel'],
            // 'FTAppStaPayLast'   => $paData['FTAppStaPayLast'],
        );
        $this->db->insert('TFNMRcvSpc', $aResult);

        $this->FSaMRCVSPCCFGUpdateDateRcv($paData['FTRcvCode']);
        return;
    }


    //Functionality : Function Update Master RCVSPC
    //Parameters : function parameters
    //Creator : 28/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMRCVSPCUpdateMaster($paData)
    {

        $this->db->set('FTBchCode', $paData['FTBchCode']);
        $this->db->set('FTMerCode', $paData['FTMerCode']);
        $this->db->set('FTShpCode', $paData['FTShpCode']);
        $this->db->set('FTAggCode', $paData['FTAggCode']);
        $this->db->set('FTPdtRmk', $paData['FTPdtRmk']);
        // $this->db->set('FTAppStaAlwRet',$paData['FTAppStaAlwRet']);
        // $this->db->set('FTAppStaAlwCancel',$paData['FTAppStaAlwCancel']);
        // $this->db->set('FTAppStaPayLast',$paData['FTAppStaPayLast']);
        $this->db->where('FTRcvCode', $paData['FTRcvCode']);
        $this->db->where('FTAppCode', $paData['FTAppCode']);
        $this->db->where('FNRcvSeq', $paData['FNRcvSeq']);
        $this->db->update('TFNMRcvSpc');

        $this->FSaMRCVSPCCFGUpdateDateRcv($paData['FTRcvCode']);
        return;
    }

    //Functionality : Function Update Master RCVSPCCFG
    //Parameters : function parameters
    //Creator : 16/10/2020 Worakorn (Doz)
    //Last Modified : -
    //Return : Status Add Update Master Config
    //Return Type : Array
    public function FSaMRCVSPCUpdateMasterConfig($paDataMaster)
    {
        // print_r($paDataMaster);
        // '<pre>';
        // print_r($paDataMasterConfig);
        // die();


        $nCount = FCNnHSizeOf($paDataMaster['FNSysSeq']) - 1;

        $this->db->select('FNRcvSeq');
        $this->db->from('TFNMRcvSpcConfig');
        $this->db->where('FTRcvCode',  $paDataMaster['FTRcvCode']);
        // $this->db->where('FNRcvSeq', $paDataMaster['FNRcvSeq']);
        $this->db->order_by('FNRcvSeq', 'DESC');
        $this->db->limit(1);
        $oResultConfigNum = $this->db->get();
        $aDataConfigNum = $oResultConfigNum->result_array();
        $nDataConfigNum = $oResultConfigNum->num_rows();
        if ($nDataConfigNum > 0) {
            $tRevSeq = $aDataConfigNum[0]['FNRcvSeq'] + 1;
        } else {
            $tRevSeq =  1;
        }
        // print_r($aDataConfigNum);
        // die();

        for ($i = 0; $i <= $nCount; $i++) {
            if ($paDataMaster['FNRcvSeq'] >= 0) {
                $this->db->set('FTRcvCode', $paDataMaster['FTRcvCode']);
                $this->db->set('FNRcvSeq', $paDataMaster['FNRcvSeq']);
                $this->db->set('FNSysSeq', $paDataMaster['FNSysSeq'][$i]);
                $this->db->set('FTSysKey', $paDataMaster['FTSysKey'][$i]);
                $this->db->set('FTSysStaUsrValue', $paDataMaster['FTSysStaUsrValue'][$i]);
                $this->db->set('FTSysStaUsrRef', $paDataMaster['FTSysStaUsrRef'][$i]);

                $this->db->where('FTRcvCode', $paDataMaster['FTRcvCode']);
                $this->db->where('FNRcvSeq', $paDataMaster['FNRcvSeq']);
                $this->db->where('FNSysSeq', $paDataMaster['FNSysSeq'][$i]);
                $this->db->update('TFNMRcvSpcConfig');
            } else {
                $this->db->set('FTRcvCode', $paDataMaster['FTRcvCode']);
                $this->db->set('FNRcvSeq', $tRevSeq);
                $this->db->set('FNSysSeq', $paDataMaster['FNSysSeq'][$i]);
                $this->db->set('FTSysKey', $paDataMaster['FTSysKey'][$i]);
                $this->db->set('FTSysStaUsrValue', $paDataMaster['FTSysStaUsrValue'][$i]);
                $this->db->set('FTSysStaUsrRef', $paDataMaster['FTSysStaUsrRef'][$i]);
                $this->db->insert('TFNMRcvSpcConfig');
            }

            // $this->db->where('FNSysSeq', $paDataMasterConfig['FNSysSeq'][$i]);
            // $this->db->where('FTFmtCode', $paDataMasterConfig['FTFmtCode'][$i]);
            // if ($nDataConfigNum > 0) {
            //     $this->db->where('FTRcvCode', $paDataMaster['FTRcvCode']);
            //     $this->db->where('FNRcvSeq', $paDataMaster['FNRcvSeq']);
            //     $this->db->where('FNSysSeq', $paDataMaster['FNSysSeq'][$i]);
            //     $this->db->update('TFNMRcvSpcConfig');
            // } else {

            // }
        }
        // print_r($paData['FTSysStaUsrRef']); 
        // die();
        // foreach ($paData['FNSysSeq'] as $aValue) {
        // FTSysStaUsrRef
        // $this->db->set('FTSysStaUsrValue ', $aValue['FTSysStaUsrValue']);
        // $this->db->set('FTSysStaUsrRef', $aValue['FTSysStaUsrRef']);

        // }
        $this->FSaMRCVSPCCFGUpdateDateRcv($paDataMaster['FTRcvCode']);
        return;
    }



    //Functionality : Get all row 
    //Parameters : -
    //Creator : 28/11/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMRcvSpc";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }


    //Functionality : Delete Userlogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMRCVSpcDel($paDataWhere)
    {
        $this->db->where('FTRcvCode', $paDataWhere['FTRcvCode']);
        $this->db->where('FNRcvSeq', $paDataWhere['FNRcvSeq']);
        $this->db->delete('TFNMRcvSpcConfig');

        $this->FSaMRCVSPCCFGUpdateDateRcv($paDataWhere['FTRcvCode']);
        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;
    }

    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 28/11/2019 Witsarut
    //Return : data
    //Return Type : Arra
    public function FSaMRCVSPCDeleteMultiple($paDataDelete)
    {
        $this->db->where_in('FTRcvCode', $paDataDelete['FTRcvCode']);
        $this->db->where_in('FNRcvSeq', $paDataDelete['FNRcvSeq']);
        $this->db->delete('TFNMRcvSpcConfig');

        $this->FSaMRCVSPCCFGUpdateDateRcv($paDataDelete['FTRcvCode']);
        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
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




    public function FSaMRCVSPCChkDelete($pnCode, $pnSeq)
    {
        $this->db->select('*');
        $this->db->from('TFNMRcvSpc');
        $this->db->where('FTRcvCode', $pnCode);
        $this->db->where('FnRcvSeq', $pnSeq);
        $oGet = $this->db->get();
        $nData = $oGet->num_rows();
        return $nData;
    }


    public function FSaMRCVSPCCFGUpdateDateRcv($ptRevCode)
    {

        $aDataUpdateDate = array(
            'FDLastUpdOn' =>  date('Y-m-d H:i:s'),
            'FTLastUpdBy' => $this->session->userdata('tSesUsername')
        );

        $this->db->where('FTRcvCode', $ptRevCode);
        $this->db->update('TFNMRcv', $aDataUpdateDate);
    }
}
