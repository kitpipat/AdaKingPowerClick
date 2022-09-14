<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mReciveSpc extends CI_Model
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
                    $tWhereBch  =  " AND RCVSPC.FTBchCode IN ($tUsrBchCodeMulti) ";
                } else {
                    $tWhereBch  =  " AND RCVSPC.FTBchCode = '$tUsrBchCodeDefult' ";
                }
            }
            if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "SHP") {
                // Check User Level SHP
                // $tWhereShp  =   " AND RCVSPC.FTShpCode = '" . $aDataUserInfo['FTShpCode'] . "'";
                if ($nUsrShpCount > 1) {
                    $tWhereShp  =  " AND RCVSPC.FTShpCode IN ('$tUsrShpCodeMulti') ";
                } else {
                    $tWhereShp  =  " AND RCVSPC.FTShpCode = '$tUsrShpCodeDefult' ";
                }
            }
            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FTRcvCode ASC) AS rtRowID,*
                                FROM(
                                    SELECT
                                        RCVSPC.FTRcvCode,
                                        RCVL.FTRcvName,
                                        RCVSPC.FTBchCode,
                                        BCHL.FTBchName,
                                        RCVSPC.FTMerCode,
                                        MERL.FTMerName,
                                        RCVSPC.FTShpCode,
                                        SHPL.FTShpName,
                                        RCVSPC.FTAggCode,
                                        -- AGGL.FTAggName,
                                        AGGL.FTAgnName,
                                        RCVSPC.FTAppCode,
                                        TSYSApp.FTAppName,
                                        RCVSPC.FNRcvSeq,
                                        RCVSPC.FTPdtRmk,
                                        RCVSPC.FTPosCode,
			                            POSL.FTPosName
                                    FROM [TFNMRcvSpc] RCVSPC WITH(NOLOCK)
                                    LEFT JOIN [TFNMRcv_L] RCVL WITH(NOLOCK) ON RCVSPC.FTRcvCode = RCVL.FTRcvCode AND RCVL.FNLngID = $nFNLngID
                                    LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON RCVSPC.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nFNLngID
                                    LEFT JOIN [TCNMMerchant_L] MERL WITH(NOLOCK) ON RCVSPC.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nFNLngID
                                    LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON RCVSPC.FTShpCode = SHPL.FTShpCode AND SHPL.FTBchCode = RCVSPC.FTBchCode AND  SHPL.FNLngID = $nFNLngID
                                    LEFT JOIN [TCNMPos_L] POSL WITH(NOLOCK) ON RCVSPC.FTPosCode = POSL.FTPosCode  AND POSL.FTBchCode = RCVSPC.FTBchCode AND POSL.FNLngID = $nFNLngID
                                    -- LEFT JOIN [TCNMAgencyGrp_L] AGGL WITH(NOLOCK) ON RCVSPC.FTAggCode = AGGL.FTAggCode AND AGGL.FNLngID = $nFNLngID
                                    LEFT JOIN [TCNMAgency_L] AGGL WITH(NOLOCK) ON RCVSPC.FTAggCode = AGGL.FTAgnCode AND AGGL.FNLngID = $nFNLngID
                                    LEFT JOIN [TSysApp_L] TSYSApp WITH(NOLOCK) ON RCVSPC.FTAppCode = TSYSApp.FTAppCode AND TSYSApp.FNLngID = $nFNLngID
                                    WHERE 1=1
                                    AND RCVSPC.FTRcvCode    = '$tRcvSpcCode'


            ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
             //print_r($tSQL); die();
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
                $tWhereBch  =  " AND RCVSPC.FTBchCode IN ($tUsrBchCodeMulti) ";
            } else {
                $tWhereBch  =  " AND RCVSPC.FTBchCode = '$tUsrBchCodeDefult' ";
            }
        }
        if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "SHP") {
            // Check User Level SHP
            // $tWhereShp  =   " AND RCVSPC.FTShpCode = '" . $aDataUserInfo['FTShpCode'] . "'";
            if ($nUsrShpCount > 1) {
                $tWhereShp  =  " AND RCVSPC.FTShpCode IN ('$tUsrShpCodeMulti') ";
            } else {
                $tWhereShp  =  " AND RCVSPC.FTShpCode = '$tUsrShpCodeDefult' ";
            }
        }

        try {
            $tRcvSpcCode    = $paData['FTRcvCode'];
            $tSQL       = " SELECT
                                COUNT (RCVSPC.FTRcvCode) AS counts
                            FROM [TFNMRcvSpc] RCVSPC WITH(NOLOCK)
                            WHERE 1=1
                            AND RCVSPC.FTRcvCode    = '$tRcvSpcCode'
              
            ";

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
        $tAggCode   = $paData['FTAggCode'];
        $tShpCode   = $paData['FTShpCode'];
        $tMerCode   = $paData['FTMerCode'];
        $tBchCode   = $paData['FTBchCode'];
        $tPosCode   = $paData['FTPosCode'];
        $nRcvSeq    = $paData['FNRcvSeq'];
        $nLngID     = $paData['FNLngID'];


        $tSQL   = " SELECT
                        RCVSPC.FTRcvCode,
                        RCVL.FTRcvName,
                        RCVSPC.FTBchCode,
                        BCHL.FTBchName,
                        RCVSPC.FTMerCode,
                        MERL.FTMerName,
                        RCVSPC.FTShpCode,
                        SHPL.FTShpName,
                        RCVSPC.FTAggCode,
                        AGGL.FTAgnName,
                        RCVSPC.FTAppCode,
                        TSYSApp.FTAppName,
                        RCVSPC.FNRcvSeq,
                        RCVSPC.FTPdtRmk,
                        RCVSPC.FTPosCode,
                        POSL.FTPosName,
                        SHP.FTShpType
                    FROM [TFNMRcvSpc] RCVSPC WITH(NOLOCK)
                    LEFT JOIN [TFNMRcv_L] RCVL WITH(NOLOCK) ON RCVSPC.FTRcvCode = RCVL.FTRcvCode AND RCVL.FNLngID = $nLngID
                    LEFT JOIN [TCNMBranch_L] BCHL WITH(NOLOCK) ON RCVSPC.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN [TCNMMerchant_L] MERL WITH(NOLOCK) ON RCVSPC.FTMerCode = MERL.FTMerCode AND MERL.FNLngID = $nLngID
                    LEFT JOIN [TCNMShop_L] SHPL WITH(NOLOCK) ON RCVSPC.FTShpCode = SHPL.FTShpCode AND SHPL.FTBchCode = RCVSPC.FTBchCode AND  SHPL.FNLngID = $nLngID
                    LEFT JOIN [TCNMPos_L] POSL WITH(NOLOCK) ON RCVSPC.FTPosCode = POSL.FTPosCode  AND POSL.FTBchCode = RCVSPC.FTBchCode AND POSL.FNLngID = $nLngID
                    LEFT JOIN [TCNMAgency_L] AGGL WITH(NOLOCK) ON RCVSPC.FTAggCode = AGGL.FTAgnCode AND AGGL.FNLngID = $nLngID
                    LEFT JOIN [TSysApp_L] TSYSApp WITH(NOLOCK) ON RCVSPC.FTAppCode = TSYSApp.FTAppCode AND TSYSApp.FNLngID = $nLngID
                    LEFT JOIN [TCNMShop] SHP WITH(NOLOCK) ON RCVSPC.FTShpCode = SHP.FTShpCode AND RCVSPC.FTBchCode = SHPL.FTBchCode
                    WHERE 1=1
                    AND ISNULL(RCVSPC.FTRcvCode,'') = '$tRcvCode'
                    AND ISNULL(RCVSPC.FTAppCode,'')= '$tAppCode'
                    AND ISNULL(RCVSPC.FTAggCode,'')= '$tAggCode'
                    AND ISNULL(RCVSPC.FTBchCode,'')= '$tBchCode'
                    AND ISNULL(RCVSPC.FTMerCode,'')= '$tMerCode'
                    AND ISNULL(RCVSPC.FTShpCode,'')= '$tShpCode'
                    AND ISNULL(RCVSPC.FTPosCode,'')= '$tPosCode'
                    AND ISNULL(RCVSPC.FNRcvSeq,'') = '$nRcvSeq'

        ";
        // print_r($tSQL); die();
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
            'FNRcvSeq'         => $paData['FNRcvSeq'],
            // 'FTAppStaAlwRet'    => $paData['FTAppStaAlwRet'],
            // 'FTAppStaAlwCancel' => $paData['FTAppStaAlwCancel'],
            // 'FTAppStaPayLast'   => $paData['FTAppStaPayLast'],
        );
        $this->db->insert('TFNMRcvSpc', $aResult);

        $this->FSaMRCVSPCUpdateDateRcv($paData['FTRcvCode']);

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

        // $this->db->set('FTBchCode', $paData['FTBchCode']);
        // $this->db->set('FTMerCode', $paData['FTMerCode']);
        // $this->db->set('FTShpCode', $paData['FTShpCode']);
        // $this->db->set('FTAggCode', $paData['FTAggCode']);
        // $this->db->set('FTPdtRmk', $paData['FTPdtRmk']);
        // $this->db->set('FNRcvSeq', $paData['FNRcvSeq']);
        // $this->db->set('FTAppCode', $paData['FTAppCode']);
        // $this->db->set('FTPosCode', $paData['FTPosCode']);

        // $this->db->where('FTRcvCode', $paData['FTRcvCode']);
        // $this->db->where('FTAppCode', $paData['FTAppCodeold']);
        // $this->db->where('FTBchCode', $paData['FTBchCodeold']);
        // $this->db->where('FTMerCode', $paData['FTMerCodeold']);
        // $this->db->where('FTShpCode', $paData['FTShpCodeold']);
        // $this->db->where('FTAggCode', $paData['FTAggCodeold']);
        // $this->db->where('FTPosCode', $paData['FTPosCodeold']);
        // $this->db->where('FNRcvSeq', $paData['FNRcvSeqW']);

        // $this->db->update('TFNMRcvSpc');

        $FTBchCode =  $paData['FTBchCode'];
        $FTMerCode =  $paData['FTMerCode'];
        $FTShpCode = $paData['FTShpCode'];
        $FTAggCode =  $paData['FTAggCode'];
        $FTPdtRmk = $paData['FTPdtRmk'];

        $FTAppCode =  $paData['FTAppCode'];
        $FTPosCode =   $paData['FTPosCode'];

        $FTRcvCode =   $paData['FTRcvCode'];
        $FTAppCodeold =  $paData['FTAppCodeold'];
        $FTBchCodeold =  $paData['FTBchCodeold'];
        $FTMerCodeold = $paData['FTMerCodeold'];
        $FTShpCodeold = $paData['FTShpCodeold'];
        $FTAggCodeold = $paData['FTAggCodeold'];
        $FTPosCodeold =  $paData['FTPosCodeold'];
        $FNRcvSeqW =  $paData['FNRcvSeqW'];


        // if ($paData['FNRcvSeq'] > 0) {
        //     $FNRcvSeq =  $paData['FNRcvSeq'];
        // } else {
        $FNRcvSeq =  $paData['FNRcvSeq'];
        // }

        $tSQL = "   UPDATE TFNMRcvSpc
                  SET
                FTBchCode = '$FTBchCode',
                 FTMerCode = '$FTMerCode',
                FTShpCode = '$FTShpCode',
                FTAggCode = '$FTAggCode',
                    FTPdtRmk = '$FTPdtRmk',
                       FTAppCode = '$FTAppCode',
                       FTPosCode = '$FTPosCode', ";

        if ($paData['FNRcvSeq'] != '') {
            $tSQL .= "FNRcvSeq =  $FNRcvSeq  ";
        } else {
            $tSQL .= "FNRcvSeq =  NULL ";
        }

        $tSQL .= " WHERE FTRcvCode = '$FTRcvCode'
      AND ISNULL(FTAppCode,'') = '$FTAppCodeold'
      AND ISNULL(FTBchCode,'') = '$FTBchCodeold'
      AND ISNULL(FTMerCode,'') = '$FTMerCodeold'
      AND ISNULL(FTShpCode,'') = '$FTShpCodeold'
      AND ISNULL(FTAggCode,'') = '$FTAggCodeold'
      AND ISNULL(FTPosCode,'') = '$FTPosCodeold' ";


        // AND ISNULL(FNRcvSeq,'') = $FNRcvSeqW "

        // print_r($tSQL);
        // die();
        // echo $this->db->last_query(); die();
        $this->db->query($tSQL);

        $this->FSaMRCVSPCUpdateDateRcv($paData['FTRcvCode']);

        return;
    }

    //Functionality : Function Update Master RCVSPCCFG
    //Parameters : function parameters
    //Creator : 16/10/2020 Worakorn (Doz)
    //Last Modified : -
    //Return : Status Add Update Master Config
    //Return Type : Array
    public function FSaMRCVSPCUpdateMasterConfig($paDataMaster, $paDataMasterConfig)
    {
        // print_r($paDataMaster);
        // '<pre>';
        // print_r($paDataMasterConfig);
        // die();


        $nCount = FCNnHSizeOf($paDataMasterConfig['FNSysSeq']) - 1;

        $this->db->select('*');
        $this->db->from('TFNMRcvSpcConfig');
        $this->db->where('FTRcvCode',  $paDataMaster['FTRcvCode']);
        $this->db->where('FNRcvSeq', $paDataMaster['FNRcvSeq']);
        $oResultConfigNum = $this->db->get();
        $nDataConfigNum = $oResultConfigNum->num_rows();


        for ($i = 0; $i <= $nCount; $i++) {
            $this->db->set('FTRcvCode', $paDataMaster['FTRcvCode']);
            $this->db->set('FNRcvSeq', $paDataMaster['FNRcvSeq']);
            $this->db->set('FNSysSeq', $paDataMasterConfig['FNSysSeq'][$i]);
            $this->db->set('FTSysKey', $paDataMasterConfig['FTSysKey'][$i]);
            $this->db->set('FTAgnCode', $paDataMaster['FTAggCode']);
            $this->db->set('FTBchCode', $paDataMaster['FTBchCode']);
            $this->db->set('FTMerCode', $paDataMaster['FTMerCode']);
            $this->db->set('FTShpCode', $paDataMaster['FTShpCode']);
            $this->db->set('FTPosCode', $paDataMaster['FTPosCode']);
            $this->db->set('FTSysStaUsrValue', $paDataMasterConfig['FTSysStaUsrValue'][$i]);
            $this->db->set('FTSysStaUsrRef', $paDataMasterConfig['FTSysStaUsrRef'][$i]);
            // $this->db->where('FNSysSeq', $paDataMasterConfig['FNSysSeq'][$i]);
            // $this->db->where('FTFmtCode', $paDataMasterConfig['FTFmtCode'][$i]);
            if ($nDataConfigNum > 0) {
                $this->db->where('FTRcvCode', $paDataMaster['FTRcvCode']);
                $this->db->where('FNRcvSeq', $paDataMaster['FNRcvSeq']);
                $this->db->where('FNSysSeq', $paDataMasterConfig['FNSysSeq'][$i]);
                $this->db->update('TFNMRcvSpcConfig');
            } else {
                $this->db->insert('TFNMRcvSpcConfig');
            }
        }
        // print_r($paData['FTSysStaUsrRef']);
        // die();
        // foreach ($paData['FNSysSeq'] as $aValue) {
        // FTSysStaUsrRef
        // $this->db->set('FTSysStaUsrValue ', $aValue['FTSysStaUsrValue']);
        // $this->db->set('FTSysStaUsrRef', $aValue['FTSysStaUsrRef']);

        // }

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
        if ($paDataWhere['FNRcvSeq'] == '') {
            $twhereRevSeq = NULL;
        } else {
            $twhereRevSeq = $paDataWhere['FNRcvSeq'];
        }

        $this->db->where_in('FTRcvCode', $paDataWhere['FTRcvCode']);
        $this->db->where_in('FTAppCode', $paDataWhere['FTAppCode']);
        $this->db->where_in('FNRcvSeq', $twhereRevSeq);
        $this->db->where_in('FTBchCode', $paDataWhere['FTBchCode']);
        $this->db->where_in('FTMerCode', $paDataWhere['FTMerCode']);
        $this->db->where_in('FTShpCode', $paDataWhere['FTShpCode']);
        $this->db->where_in('FTAggCode', $paDataWhere['FTAggCode']);
        $this->db->where_in('FTPosCode', $paDataWhere['FTPosCode']);
        $this->db->delete('TFNMRcvSpc');

        $this->FSaMRCVSPCUpdateDateRcv($paDataWhere['FTRcvCode']);

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
    }

    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 28/11/2019 Witsarut
    //Return : data
    //Return Type : Arra
    public function FSaMRCVSPCDeleteMultiple($paDataDelete, $ptRevCodeWhere)
    {

        // echo FCNnHSizeOf($paDataDelete['FNRcvSeq']);

        $this->db->where_in('FTRcvCode', $paDataDelete['FTRcvCode']);
        $this->db->where_in('FTAppCode', $paDataDelete['FTAppCode']);
        // if ($paDataDelete['FTRcvSpcStaAlwCfg'] != 1) {
        if (count(array_filter($paDataDelete['FNRcvSeq'])) == FCNnHSizeOf($paDataDelete['FNRcvSeq'])) {
            $this->db->where_in('FNRcvSeq', $paDataDelete['FNRcvSeq']);
        } else {
            $this->db->where('FNRcvSeq', NULL);
        }
        $this->db->where_in('FTBchCode', $paDataDelete['FTBchCode']);
        $this->db->where_in('FTMerCode', $paDataDelete['FTMerCode']);
        $this->db->where_in('FTShpCode', $paDataDelete['FTShpCode']);
        $this->db->where_in('FTAggCode', $paDataDelete['FTAggCode']);
        $this->db->where_in('FTPosCode', $paDataDelete['FTPosCode']);
        $this->db->delete('TFNMRcvSpc');



        $this->FSaMRCVSPCUpdateDateRcv($ptRevCodeWhere);

        // echo $this->db->last_query();
        // die();
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


    public  function FSaMRCVSPCChkDupAddMaster($paData)
    {

        $this->db->select('FTRcvCode');
        $this->db->from('TFNMRcvSpc');
        $this->db->where('FTRcvCode', $paData['FTRcvCode']);
        $this->db->where('FTAppCode', $paData['FTAppCode']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->where('FTMerCode', $paData['FTMerCode']);
        $this->db->where('FTShpCode', $paData['FTShpCode']);
        $this->db->where('FTAggCode', $paData['FTAggCode']);
        $this->db->where('FTPosCode', $paData['FTPosCode']);
        $tGet = $this->db->get();
        $nData = $tGet->num_rows();

        return  $nData;
    }


    public function FSaMRCVSPCUpdateDateRcv($ptRevCode)
    {

        $aDataUpdateDate = array(
            'FDLastUpdOn' =>  date('Y-m-d H:i:s'),
            'FTLastUpdBy' => $this->session->userdata('tSesUsername')
        );

        $this->db->where('FTRcvCode', $ptRevCode);
        $this->db->update('TFNMRcv', $aDataUpdateDate);
    }


    //Functionality : Get Numrow Config
    //Parameters : function parameters
    //Creator : 19/10/2020 Worakorn (Doz)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVSPCCheckIDConfigNumrowCombobox($pnRcvCode)
    {
        $this->db->select('*');
        $this->db->from('TFNMRcvSpcConfig');
        $this->db->where('FTRcvCode', $pnRcvCode);
        $oResultConfigNum = $this->db->get();
        $nDataConfigNum = $oResultConfigNum->num_rows();
        // print_r($aDataConfig); die();

        return $nDataConfigNum;

        // print_r($aData); die();
    }
}
