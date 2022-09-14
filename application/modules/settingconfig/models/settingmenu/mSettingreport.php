<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mSettingreport extends CI_Model
{

    // Functionality : Function Get reportlist
    // Parameters : Function Parameter
    // Creator : 15/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUGetListReport($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT DISTINCT
            M.FTGrpRptModCode,
            ML.FNGrpRptModName,
            M.FTGrpRptModStaUse,
            M.FNGrpRptModShwSeq,
            ISNULL(G.FTGrpRptCode,M.FTGrpRptModCode) FTGrpRptCode,
            GL.FTGrpRptName,
            G.FTGrpRptStaUse,
            G.FNGrpRptShwSeq,
            ISNULL(R.FTRptCode,M.FTGrpRptModCode) FTRptCode,
            RL.FTRptName,
            R.FTRptStaUse,
            R.FTRptSeqNo
    FROM TSysReportModule M
        LEFT JOIN TSysReportModule_L ML ON M.FTGrpRptModCode = ML.FTGrpRptModCode AND ML.FNLngID= $nLngID
        LEFT JOIN TSysReportGrp G ON M.FTGrpRptModCode = G.FTGrpRptModCode
        LEFT JOIN TSysReportGrp_L GL ON G.FTGrpRptCode = GL.FTGrpRptCode AND GL.FNLngID = $nLngID
        LEFT JOIN TSysReport R ON M.FTGrpRptModCode = R.FTGrpRptModCode
                                    AND G.FTGrpRptCode = R.FTGrpRptCode
        LEFT JOIN TSysReport_L RL ON R.FTRptCode = RL.FTRptCode AND RL.FNLngID=$nLngID
        ORDER BY M.FNGrpRptModShwSeq ,M.FTGrpRptModCode,FNGrpRptShwSeq ,FTGrpRptCode,FTRptSeqNo,FTRptCode";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Functionality : Function Get MaxSequenceRPT
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTCallMaxSequenceRpt($paData)
    {
        $this->db->select('MAX('.$paData['tFieldSeq'].') AS '.$paData['tFieldSeq'].',MAX('.$paData['tFieldCode'].') AS '.$paData['tFieldCode'].'');
        if ($paData['tFieldWhere'] != '') {
            $this->db->where($paData['tFieldWhere'], $paData['tCode']);
        }
        $oQuery = $this->db->get($paData['tTableName']);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aStatus = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'call maxsequence Complete.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '99',
                'rtDesc' => 'Error call maxsequence.',
            );
        }
        return $aStatus;
    }


    // Functionality : Function Get MaxSequenceRPT
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTGencode($paData)
    {
        $this->db->select_max($paData['tFieldCode']);
        if ($paData['tFieldWhere'] != '') {
            $this->db->like($paData['tFieldWhere'], $paData['tCode'],'after');
        }
        $oQuery = $this->db->get($paData['tTableName']);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aStatus = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'call maxsequence Complete.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '99',
                'rtDesc' => 'Error call maxsequence.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function Add Module Report
    // Parameters : Function Parameter
    // Creator : 16/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTAddEditModuleRpt($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            if ($nLngID == 1) {
                $FTGmnModName = "'รายงาน'";
            } else {
                $FTGmnModName = "'Report'";
            }
            $this->db->select('FTGmnModCode');
            $this->db->where('FTGmnModCode', 'RPT');

            $oQuery = $this->db->get('TSysMenuGrpModule');
            if ($oQuery->num_rows() < 1) {
                $this->db->select_max('FNGmnModShwSeq');
                $oQuery = $this->db->get('TSysMenuGrpModule');
                $oList = $oQuery->result_array();
                if ($oQuery->num_rows() > 0) {
                    $FNGmnModShwSeq = $oList[0]['FNGmnModShwSeq'] + 1;
                } else {
                    $FNGmnModShwSeq = 0 + 1;
                }

                $tSQL = "INSERT INTO TSysMenuGrpModule
                VALUES (
                        'RPT',
                        '$FNGmnModShwSeq',
                        '1',
                        '/application/modules/common/assets/images/iconsmenu/rpt.png',
                        ''
                        )";
                $this->db->query($tSQL);

                $tSQL = "INSERT INTO TSysMenuGrpModule_L (FTGmnModCode, FTGmnModName, FNLngID)
                VALUES (
                        'RPT',
                        $FTGmnModName,
                        '" . $paData['FNLngID'] . "'
                        )";
                $this->db->query($tSQL);
            }

            $this->db->where('FTGrpRptModCode', $paData['FTGrpRptModCode']);
            $this->db->update('TSysReportModule', array(
                'FNGrpRptModShwSeq' => $paData['FNGrpRptModShwSeq'],
                'FTGrpRptModStaUse' => $paData['FTGrpRptModStaUse'],
                'FTGrpRptModRoute' => $paData['FTGrpRptModRoute'],
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysReportModule
                            VALUES (
                                    '" . $paData['FTGrpRptModCode'] . "',
                                    '" . $paData['FNGrpRptModShwSeq'] . "',
                                    '" . $paData['FTGrpRptModStaUse'] . "',
                                    '" . $paData['FTGrpRptModRoute'] . "'
                                    )";
                $this->db->query($tSQL);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function Add ModuleReport_L
    // Parameters : Function Parameter
    // Creator : 16/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTAddEditModuleRpt_L($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            $this->db->where('FNLngID', $nLngID);
            $this->db->where('FTGrpRptModCode', $paData['FTGrpRptModCode']);
            $this->db->update('TSysReportModule_L', array(
                'FNGrpRptModName' => $paData['FNGrpRptModName'],
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysReportModule_L
                            VALUES (
                                    '" . $paData['FTGrpRptModCode'] . "',
                                    '" . $paData['FNGrpRptModName'] . "',
                                    '" . $paData['FNLngID'] . "'
                                    )";
                $this->db->query($tSQL);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function Adedit menulist
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTAddEditMenuList($paData)
    {
        try {
            $tSQL = "UPDATE TSysMenuList
            SET
                  FTGmnCode    = 'RPT',
                  FTMnuParent  = 'RPT',
                  FTMnuCode    = 'RPT" . $paData['FTGrpRptModCode'] . "',
                  FNMnuSeq     = '" . $paData['FNGrpRptModShwSeq'] . "',
                  FTMnuCtlName = '" . $paData['FTGrpRptModRoute'] . "',
                  FNMnuLevel   = '0',
                  FTGmnModCode = 'RPT'
            WHERE FTMnuCode    = 'RPT" . $paData['FTGrpRptModCode'] . "'";

            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysMenuList
                        VALUES (
                                'RPT',
                                'RPT',
                                'RPT" . $paData['FTGrpRptModCode'] . "',
                                '" . $paData['FNGrpRptModShwSeq'] . "',
                                '" . $paData['FTGrpRptModRoute'] . "',
                                '0',
                                'Y','Y','Y','Y','Y','Y','1','Y','Y','1','',
                                'RPT',''
                                )";
                $this->db->query($tSQL);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }

    }

    // Functionality : Function Adedit menulist_L
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTAddEditMenuList_L($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            if ($nLngID == 1) {
                $FTMnuName = "'ข้อมูล" . $paData['FNGrpRptModName'] . "'";
                $FTMnuRmk = "'รายงาน'";
            } else {
                $FTMnuName = "'Report " . $paData['FNGrpRptModName'] . "'";
                $FTMnuRmk = "'Report'";
            }
            $tSQL = "UPDATE TSysMenuList_L
                    SET
                          FTMnuCode   = 'RPT" . $paData['FTGrpRptModCode'] . "',
                          FTMnuName   = $FTMnuName,
                          FTMnuRmk    = $FTMnuRmk
                    WHERE FTMnuCode   = 'RPT" . $paData['FTGrpRptModCode'] . "'
                    AND FNLngID = $nLngID";
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysMenuList_L
                    VALUES (
                            'RPT" . $paData['FTGrpRptModCode'] . "',
                            '" . $paData['FNLngID'] . "',
                            $FTMnuName,
                            $FTMnuRmk
                            )";
                $this->db->query($tSQL);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }

    }

    // Functionality : Function AddEdit TSysMenuAlbAct
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTAddEditTSysMenuAlbAct($paData)
    {
        try {
            $tSQL = "UPDATE TSysMenuAlbAct
            SET
                  FTMnuCode      = 'RPT" . $paData['FTGrpRptModCode'] . "',
                  FTAutStaRead   = '1',
                  FTAutStaAdd    = '0',
                  FTAutStaEdit   = '0',
                  FTAutStaDelete = '0',
                  FTAutStaCancel = '0',
                  FTAutStaAppv   = '0',
                  FTAutStaPrint  = '0',
                  FTAutStaPrintMore  = '0'
            WHERE FTMnuCode   = 'RPT" . $paData['FTGrpRptModCode'] . "'";
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {

                $tSQL = "INSERT INTO TSysMenuAlbAct
                    VALUES (
                            'RPT" . $paData['FTGrpRptModCode'] . "',
                            '1','0','0','0','0','0','0','0'
                            )";
                $this->db->query($tSQL);

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function AddEdit TCNTUsrMenu
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTAddEditTCNTUsrMenu($paData)
    {
        try {
            $tSQL = "UPDATE TCNTUsrMenu
            SET
                  FTGmnCode      = 'RPT',
                  FTMnuParent    = 'RPT'
            WHERE FTMnuCode   = 'RPT" . $paData['FTGrpRptModCode'] . "'";
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {

                $dDateNow = date("Y-m-d H:i:s");
                $tSQL = "INSERT INTO TCNTUsrMenu
                            VALUES (
                                    '00002',
                                    'RPT',
                                    'RPT',
                                    'RPT" . $paData['FTGrpRptModCode'] . "',
                                    '0','1','1','1','1','0','0','0','0','0',
                                    '" . $dDateNow . "',
                                    '00002',
                                    '" . $dDateNow . "',
                                    '00002'
                                    )";
                $this->db->query($tSQL);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function Get Data Edit modulereport
    // Parameters : Function Parameter
    // Creator : 16/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTReportCallEdit($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT R.FTGrpRptModCode,
                            RL.FNGrpRptModName,
                            R.FNGrpRptModShwSeq,
                            R.FTGrpRptModRoute
                 FROM TSysReportModule R
                 LEFT JOIN TSysReportModule_L RL ON R.FTGrpRptModCode = RL.FTGrpRptModCode
                 WHERE RL.FNLngID = $nLngID AND R.FTGrpRptModCode = '" . $paData['tCode'] . "';";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Functionality : Function Dlete ModuleRpt
    // Parameters : Function Parameter
    // Creator : 17/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTModuleDeleteData($paData)
    {
        $this->db->trans_begin();

        $tSQL = "DELETE FROM TCNTUsrFuncRpt
        WHERE FTUfrGrpRef IN (
                                    SELECT FTGrpRptCode
                                    FROM TSysReportGrp A
                                    WHERE A.FTGrpRptModCode = '" . $paData['FTGrpRptModCode'] . "'
                           )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGrpRptModCode', $paData['FTGrpRptModCode']);
        $this->db->delete('TSysReportModule');

        $this->db->where_in('FTGrpRptModCode', $paData['FTGrpRptModCode']);
        $this->db->delete('TSysReportModule_L');

        $tSQL = "DELETE FROM TSysReportGrp_L
                 WHERE FTGrpRptCode IN (
                                    SELECT FTGrpRptCode
                                    FROM TSysReportGrp A
                                    WHERE A.FTGrpRptModCode = '" . $paData['FTGrpRptModCode'] . "'
                                    )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGrpRptModCode', $paData['FTGrpRptModCode']);
        $this->db->delete('TSysReportGrp');

        $tSQL = "DELETE FROM TSysReport_L
                 WHERE FTRptCode IN (
                                    SELECT FTRptCode
                                    FROM TSysReport A
                                    WHERE A.FTGrpRptModCode = '" . $paData['FTGrpRptModCode'] . "'
                                    )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGrpRptModCode', $paData['FTGrpRptModCode']);
        $this->db->delete('TSysReport');

        $this->db->where_in('FTMnuCode', 'RPT' . $paData['FTGrpRptModCode']);
        $this->db->delete('TSysMenuList');

        $this->db->where_in('FTMnuCode', 'RPT' . $paData['FTGrpRptModCode']);
        $this->db->delete('TSysMenuList_L');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '99',
                'rtDesc' => 'Error Cannot Delete Data Module.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Module Complete.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function AddEdit ReportGrp
    // Parameters : Function Parameter
    // Creator : 17/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMRRTAddEditReportGrp($paData)
    {
        try {
            $tSQL = "UPDATE TSysReportGrp
                SET
                      FTGrpRptCode    = '" . $paData['FTGrpRptCode'] . "',
                      FNGrpRptShwSeq  = '" . $paData['FNGrpRptShwSeq'] . "',
                      FTGrpRptModCode = '" . $paData['FTGrpRptModCode'] . "'
                WHERE FTGrpRptCode    = '" . $paData['FTGrpRptCode'] . "'";

            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysReportGrp
                        VALUES (
                                '" . $paData['FTGrpRptCode'] . "',
                                '" . $paData['FNGrpRptShwSeq'] . "',
                                '" . $paData['FTGrpRptStaUse'] . "',
                                '" . $paData['FTGrpRptModCode'] . "'
                                )";
                $this->db->query($tSQL);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    public function FSaMRRTUpdateReportGrp($paData)
    {
        try {
            $tSQL = "UPDATE TSysReport
            SET
                    FTGrpRptModCode   = '" . $paData['FTGrpRptModCode'] . "'
            WHERE   FTGrpRptCode   = '" . $paData['FTGrpRptCode'] . "'";

            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                );
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function AddEdit ReportGrp_L
    // Parameters : Function Parameter
    // Creator : 17/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMRRTAddEditReportGrp_L($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            $tSQL = "UPDATE TSysReportGrp_L
            SET
                  FTGrpRptCode   = '" . $paData['FTGrpRptCode'] . "',
                  FTGrpRptName   = '" . $paData['FTGrpRptName'] . "'
            WHERE FTGrpRptCode   = '" . $paData['FTGrpRptCode'] . "'
            AND FNLngID = $nLngID";

            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysReportGrp_L
                    VALUES (
                            '" . $paData['FTGrpRptCode'] . "',
                            $nLngID,
                            '" . $paData['FTGrpRptName'] . "'
                            )";
                $this->db->query($tSQL);

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function Get Data Edit ReportGrp
    // Parameters : Function Parameter
    // Creator : 16/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTReportGrpCallEdit($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT RG.FTGrpRptModCode,
                        RG.FTGrpRptCode,
                        RL.FTGrpRptName,
                        RG.FNGrpRptShwSeq
                FROM TSysReportGrp RG
                    LEFT JOIN TSysReportGrp_L RL ON RG.FTGrpRptCode = RL.FTGrpRptCode
                 WHERE RL.FNLngID = $nLngID AND RG.FTGrpRptCode = '" . $paData['FTGrpRptCode'] . "';";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Functionality : Function Delete MenuGrp
    // Parameters : Function Parameter
    // Creator : 18/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTRptGrpDeleteData($paData)
    {
        $this->db->trans_begin();

        $this->db->where_in('FTGrpRptCode', $paData['FTGrpRptCode']);
        $this->db->delete('TSysReportGrp');

        $this->db->where_in('FTGrpRptCode', $paData['FTGrpRptCode']);
        $this->db->delete('TSysReportGrp_L');

        $tSQL = "DELETE FROM TSysReport_L
                 WHERE FTRptCode IN (
                                    SELECT FTRptCode
                                    FROM TSysReportGrp A
                                    WHERE A.FTGrpRptCode = '" . $paData['FTGrpRptCode'] . "'
                                    )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGrpRptCode', $paData['FTGrpRptCode']);
        $this->db->delete('TSysReportGrp');

        $this->db->where_in('FTUfrGrpRef', $paData['FTGrpRptCode']);
        $this->db->delete('TCNTUsrFuncRpt');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '99',
                'rtDesc' => 'Error Cannot Delete Data Module.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Module Complete.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function AddEdit TSysReport
    // Parameters : Function Parameter
    // Creator : 18/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUAddEditTSysReport($paData)
    {
        try {
            $tSQL = "UPDATE TSysReport
            SET
                FTGrpRptModCode      = '" . $paData['FTGrpRptModCode'] . "',
                FTGrpRptCode     = '" . $paData['FTGrpRptCode'] . "',
                FTRptRoute       = '" . $paData['FTRptRoute'] . "',
                FTRptFilterCol   = '" . $paData['FTRptFilterCol'] . "',
                FTRptSeqNo       = '" . $paData['FTRptSeqNo'] . "'
            WHERE FTRptCode      = '" . $paData['FTRptCode'] . "'";
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tFTLicPdtCode = 'SB-RPT'.$paData['FTRptCode'];

                $this->db->insert('TSysReport', array(
                    'FTRptCode'         => $paData['FTRptCode'],
                    'FTGrpRptModCode'    => $paData['FTGrpRptModCode'],
                    'FTGrpRptCode'   => $paData['FTGrpRptCode'],
                    'FTRptRoute'         => $paData['FTRptRoute'],
                    'FTRptFilterCol'     => $paData['FTRptFilterCol'],
                    'FTRptStaShwBch'     => '1',
                    'FTRptStaShwYear'    => '1',
                    'FTRptSeqNo'        => $paData['FTRptSeqNo'],
                    'FTRptStaUse'       => '1',
                    'FTLicPdtCode'        => $tFTLicPdtCode
                ));

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function AddEdit TSysReport_L
    // Parameters : Function Parameter
    // Creator : 18/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUAddEditTSysReport_L($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];

            $tSQL = "UPDATE TSysReport_L
            SET
            FTRptName  = '" . $paData['FTRptName'] . "'
            WHERE FTRptCode      = '" . $paData['FTRptCode'] . "'";
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {

                $tSQL = "INSERT INTO TSysReport_L
                    VALUES (
                            '" . $paData['FTRptCode'] . "',
                            $nLngID,
                            '" . $paData['FTRptName'] . "',
                            ''
                            )";
                $this->db->query($tSQL);

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality : Function Get Data Edit ReportGrp
    // Parameters : Function Parameter
    // Creator : 18/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTReportMenuCallEdit($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT *,
                        RL.FTRptName,
                        ML.FNGrpRptModName,
                        GL.FTGrpRptName
                FROM TSysReport R
                    LEFT JOIN TSysReport_L RL ON RL.FTRptCode = R.FTRptCode AND RL.FNLngID = $nLngID
                    LEFT JOIN TSysReportModule_L ML ON R.FTGrpRptModCode = ML.FTGrpRptModCode AND ML.FNLngID = $nLngID
                    LEFT JOIN TSysReportGrp_L GL ON R.FTGrpRptCode = GL.FTGrpRptCode AND GL.FNLngID = $nLngID
                 WHERE R.FTRptCode = '" . $paData['FTRptCode'] . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Functionality : Function Get Data Filter
    // Parameters : Function Parameter
    // Creator : 18/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTReportFilterCallEdit($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT *
                FROM TSysReportFilter_L FL
                WHERE FL.FTRptFltCode IN
                (SELECT value FROM STRING_SPLIT(
                    (SELECT TOP 1 R.FTRptFilterCol FROM TSysReport R WHERE R.FTRptCode = '" . $paData['FTRptCode'] . "'),
                    ',')) AND FL.FNLngID = $nLngID";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '99',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Functionality : Function Delete MenuReport
    // Parameters : Function Parameter
    // Creator : 19/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSRTMenuReportDeleteData($paData)
    {
        $this->db->trans_begin();

        $this->db->where_in('FTRptCode', $paData['FTRptCode']);
        $this->db->delete('TSysReport');

        $this->db->where_in('FTRptCode', $paData['FTRptCode']);
        $this->db->delete('TSysReport_L');

        $this->db->where_in('FTUfrRef', $paData['FTRptCode']);
        $this->db->delete('TCNTUsrFuncRpt');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '99',
                'rtDesc' => 'Error Cannot Delete Data Module.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Module Complete.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function AddEdit UsrFuncRpt
    // Parameters : Function Parameter
    // Creator : 17/09/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMRRTAddEditUsrFuncRpt($paData)
    {
        try {
            $dDateNow = date("Y-m-d H:i:s");
            $tSesUserCode = $this->session->userdata('tSesUserCode');
            $tSQL = "UPDATE TCNTUsrFuncRpt
            SET
                  FTUfrGrpRef   = '" . $paData['FTGrpRptCode'] . "',
                  FTUfrRef   = '" . $paData['FTRptCode'] . "',
                  FDLastUpdOn = '" . $dDateNow . "',
                  FTLastUpdBy = $tSesUserCode
            WHERE FTUfrRef   = '" . $paData['FTRptCode'] . "'";

            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $dDateNow = date("Y-m-d H:i:s");

                $tSQL = "INSERT INTO TCNTUsrFuncRpt
                (FTRolCode, FTUfrType, FTUfrGrpRef, FTUfrRef,FTUfrStaAlw,FTUfrStaFavorite,FDCreateOn,FTCreateBy,FTGhdApp)
                    VALUES (
                            '00002',
                            '2',
                            '" . $paData['FTGrpRptCode'] . "',
                            '" . $paData['FTRptCode'] . "',
                            '1','0',
                            '" . $dDateNow . "',
                            $tSesUserCode,
                            'SB'
                            )";
                $this->db->query($tSQL);

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success.',
                    );
                } else {
                    $aStatus = array(
                        'tCode' => '99',
                        'tDesc' => 'Error',
                    );
                }
            }
            return $aStatus;

        } catch (Exception $Error) {
            return $Error;
        }
    }

    public function FSaMRRTSwitchSeq($paData)
    {
        try {
            
            $this->db->set($paData['tFieldSeqName'], $paData['tSeqAfter']);
            $this->db->where($paData['tFieldWhere'], $paData['tCode']);
            $this->db->update($paData['tTableName']);
            if ($this->db->trans_status() === true) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $aStatus = array(
                    'tCode' => '99',
                    'tDesc' => 'Error',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

}
