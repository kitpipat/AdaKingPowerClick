<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mSettingmenu extends CI_Model
{

    // Functionality : Function Get Menu
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUGetListMenu($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT DISTINCT
                        A.FTGmnModCode,
                                ISNULL(A_L.FTGmnModName, A.FTGmnModCode) AS FTGmnModName,
                                A.FNGmnModShwSeq,
                                A.FTGmnModStaUse,
                                ISNULL(B.FTGmnCode, A.FTGmnModCode) AS FTGmnCode,
                                B_L.FTGmnName,
                                B.FNGmnShwSeq,
                                B.FTGmnStaUse,
                                ISNULL(C.FTMnuCode, B.FTGmnCode) AS FTMnuCode,
                                ISNULL(C_L.FTMnuName, 'N/A') AS FTMnuName,
                                C.FNMnuSeq,
                                C.FTMnuStaUse
                        FROM TSysMenuGrpModule A
                        LEFT JOIN TSysMenuGrpModule_L A_L ON A_L.FTGmnModCode = A.FTGmnModCode AND A_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrp B ON A.FTGmnModCode = B.FTGmnModCode
                        LEFT JOIN TSysMenuGrp_L B_L ON B_L.FTGmnCode = B.FTGmnCode AND B_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList C ON A.FTGmnModCode = C.FTGmnModCode AND B.FTGmnCode = C.FTGmnCode
                        LEFT JOIN TSysMenuList_L C_L ON C.FTMnuCode = C_L.FTMnuCode AND C_L.FNLngID = $nLngID
                        WHERE 1=1
                        AND B.FTGmnCode IS NOT NULL
                        UNION


                        SELECT
                        S.FTGmnModCode,
                        S.FTGmnModName,
                        S.FNGmnModShwSeq,
                        S.FTGmnModStaUse,
                        S.FTGmnCode,
                        S.FTGmnName,
                        S.FNGmnShwSeq,
                        S.FTGmnStaUse,
                        T.FTMnuCode,
                        T.FTMnuName,
                        T.FNMnuSeq,
                        T.FTMnuStaUse
                        FROM
                        (SELECT DISTINCT
                        A.FTGmnModCode,
                                ISNULL(A_L.FTGmnModName, A.FTGmnModCode) AS FTGmnModName,
                                A.FNGmnModShwSeq,
                                A.FTGmnModStaUse,
                                ISNULL(B.FTGmnCode, A.FTGmnModCode) AS FTGmnCode,
                                B_L.FTGmnName,
                                B.FNGmnShwSeq,
                                B.FTGmnStaUse,
                                ISNULL(C.FTMnuCode, A.FTGmnModCode) AS FTMnuCode,
                                ISNULL(C_L.FTMnuName, 'N/A') AS FTMnuName,
                                C.FNMnuSeq,
                                C.FTMnuStaUse
                        FROM TSysMenuGrpModule A
                        LEFT JOIN TSysMenuGrpModule_L A_L ON A_L.FTGmnModCode = A.FTGmnModCode AND A_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrp B ON A.FTGmnModCode = B.FTGmnModCode
                        LEFT JOIN TSysMenuGrp_L B_L ON B_L.FTGmnCode = B.FTGmnCode AND B_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList C ON A.FTGmnModCode = C.FTGmnModCode AND B.FTGmnCode = C.FTGmnCode
                        LEFT JOIN TSysMenuList_L C_L ON C.FTMnuCode = C_L.FTMnuCode AND C_L.FNLngID = $nLngID
                        WHERE 1=1
                        AND A_L.FTGmnModCode IS NOT NULL
                        AND B.FTGmnCode IS NULL
                        AND C.FTMnuCode IS NULL
                        ) S
                        LEFT JOIN (SELECT DISTINCT
                        A.FTGmnModCode,
                                ISNULL(A_L.FTGmnModName, A.FTGmnModCode) AS FTGmnModName,
                                A.FNGmnModShwSeq,
                                A.FTGmnModStaUse,
                                ISNULL(B.FTGmnCode, A.FTGmnModCode) AS FTGmnCode,
                                B_L.FTGmnName,
                                B.FNGmnShwSeq,
                                B.FTGmnStaUse,
                                ISNULL(C.FTMnuCode, B.FTGmnCode) AS FTMnuCode,
                                ISNULL(C_L.FTMnuName, 'N/A') AS FTMnuName,
                                C.FNMnuSeq,
                                C.FTMnuStaUse
                        FROM TSysMenuGrpModule A
                        LEFT JOIN TSysMenuGrpModule_L A_L ON A_L.FTGmnModCode = A.FTGmnModCode AND A_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList C ON A.FTGmnModCode = C.FTGmnModCode
                        LEFT JOIN TSysMenuList_L C_L ON C.FTMnuCode = C_L.FTMnuCode AND C_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrp B ON A.FTGmnModCode = B.FTGmnModCode AND C.FTGmnCode = B.FTGmnCode
                        LEFT JOIN TSysMenuGrp_L B_L ON B_L.FTGmnCode = B.FTGmnCode AND B_L.FNLngID = $nLngID
                        WHERE 1=1
                        AND B.FTGmnCode IS NULL
                        AND C.FTMnuCode IS NOT NULL) T ON S.FTGmnModCode = T.FTGmnModCode
                        UNION
                        SELECT DISTINCT
                        A.FTGmnModCode,
                                ISNULL(A_L.FTGmnModName, A.FTGmnModCode) AS FTGmnModName,
                                A.FNGmnModShwSeq,
                                A.FTGmnModStaUse,
                                ISNULL(B.FTGmnCode, A.FTGmnModCode) AS FTGmnCode,
                                B_L.FTGmnName,
                                B.FNGmnShwSeq,
                                B.FTGmnStaUse,
                                ISNULL(C.FTMnuCode, B.FTGmnCode) AS FTMnuCode,
                                ISNULL(C_L.FTMnuName, 'N/A') AS FTMnuName,
                                C.FNMnuSeq,
                                C.FTMnuStaUse
                        FROM TSysMenuGrpModule A
                        LEFT JOIN TSysMenuGrpModule_L A_L ON A_L.FTGmnModCode = A.FTGmnModCode AND A_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuList C ON A.FTGmnModCode = C.FTGmnModCode
                        LEFT JOIN TSysMenuList_L C_L ON C.FTMnuCode = C_L.FTMnuCode AND C_L.FNLngID = $nLngID
                        LEFT JOIN TSysMenuGrp B ON A.FTGmnModCode = B.FTGmnModCode AND C.FTGmnCode = B.FTGmnCode
                        LEFT JOIN TSysMenuGrp_L B_L ON B_L.FTGmnCode = B.FTGmnCode AND B_L.FNLngID = $nLngID
                        WHERE 1=1
                        AND B.FTGmnCode IS NULL
                        AND C.FTMnuCode IS NOT NULL
                        ORDER BY A.FNGmnModShwSeq,A.FTGmnModCode,B.FNGmnShwSeq,FTGmnCode,C.FNMnuSeq,FTMnuCode";

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

    // Functionality : Function AddEdit Module
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUAddEditModule($paData)
    {
        try {
            $tSQL = "UPDATE TSysMenuGrpModule
                         SET    FTGmnModCode        = '" . $paData['FTGmnModCode'] . "',
                                FNGmnModShwSeq      = '" . $paData['FNGmnModShwSeq'] . "',
                                FTGmmModPathIcon    = '" . $paData['FTGmmModPathIcon'] . "'
                         WHERE  FTGmnModCode        = '" . $paData['FTGmnModCode'] . "'";
            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysMenuGrpModule
                        VALUES (
                                '" . $paData['FTGmnModCode'] . "',
                                '" . $paData['FNGmnModShwSeq'] . "',
                                '" . $paData['FTGmnModStaUse'] . "',
                                '" . $paData['FTGmmModPathIcon'] . "',
                                '" . $paData['FTGmmModColorBtn'] . "'
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

    // Functionality : Function AddEdit Module_L
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUAddEditModule_L($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            $tSQL = "UPDATE TSysMenuGrpModule_L
                     SET    FTGmnModCode = '" . $paData['FTGmnModCode'] . "',
                            FTGmnModName = '" . $paData['FTGmnModName'] . "'
                     WHERE  FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
                     AND FNLngID = $nLngID";

            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysMenuGrpModule_L (FTGmnModCode, FTGmnModName, FNLngID)
                VALUES (
                        '" . $paData['FTGmnModCode'] . "',
                        '" . $paData['FTGmnModName'] . "',
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

    // Functionality : Function Get Data Edit module
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUCallModalEditModule($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT B.FTGmnModCode,
                        B.FTGmnModName,
                        B.FNGmnModShwSeq,
                        B.FTGmnModStaUse,
                        B.FTGmmModPathIcon
                FROM
                (SELECT A.FTGmnModCode,
                        A_L.FTGmnModName,
                        A.FNGmnModShwSeq,
                        A.FTGmnModStaUse,
                        A.FTGmmModPathIcon,
                        ISNULL(A_L.FNLngID,0) AS FNLngID
                FROM    TSysMenuGrpModule A
                LEFT JOIN TSysMenuGrpModule_L A_L ON A.FTGmnModCode = A_L.FTGmnModCode
                ) B
                WHERE 1=1
                AND B.FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
                AND(B.FNLngID = 0 OR  B.FNLngID = $nLngID)";
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

    // Functionality : Function Dlete Module
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUModuleDeleteData($paData)
    {
        $this->db->trans_begin();

        $tSQL = "DELETE FROM TCNTUsrMenu
        WHERE FTGmnCode IN (
                           SELECT FTGmnCode
                           FROM TSysMenuGrp A
                           WHERE A.FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
                           )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGmnModCode', $paData['FTGmnModCode']);
        $this->db->delete('TSysMenuGrpModule');

        $this->db->where_in('FTGmnModCode', $paData['FTGmnModCode']);
        $this->db->delete('TSysMenuGrpModule_L');

        $tSQL = "DELETE FROM TSysMenuGrp_L
                 WHERE FTGmnCode IN (
                                    SELECT FTGmnCode
                                    FROM TSysMenuGrp A
                                    WHERE A.FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
                                    )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGmnModCode', $paData['FTGmnModCode']);
        $this->db->delete('TSysMenuGrp');

        $tSQL = "DELETE FROM TSysMenuList_L
                 WHERE FTMnuCode IN (
                                    SELECT FTMnuCode
                                    FROM TSysMenuList A
                                    WHERE A.FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
                                    )";

        $this->db->query($tSQL);

        $tSQL = "DELETE FROM TSysMenuAlbAct
        WHERE FTMnuCode IN (
                           SELECT FTMnuCode
                           FROM TSysMenuList A
                           WHERE A.FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
                           )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGmnModCode', $paData['FTGmnModCode']);
        $this->db->delete('TSysMenuList');

        if ($paData['FTGmnModCode'] == 'RPT') {
            $this->db->empty_table('TSysReportModule');
            $this->db->empty_table('TSysReportModule_L');
            $this->db->empty_table('TSysReportGrp');
            $this->db->empty_table('TSysReportGrp_L');
            $this->db->empty_table('TSysReport');
            $this->db->empty_table('TSysReport_L');
            $this->db->empty_table('TCNTUsrFuncRpt');
        }
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

    // Functionality : Function AddEdit MenuGrp
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUAddEditMenuGrp($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            $tSQL = "UPDATE TSysMenuGrp
                SET
                      FTGmnCode    = '" . $paData['FTGmnCode'] . "',
                      FNGmnShwSeq  = '" . $paData['FNGmnShwSeq'] . "',
                      FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
                WHERE FTGmnCode = '" . $paData['FTGmnCode'] . "'";
            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysMenuGrp(FTGmnCode, FNGmnShwSeq, FTGmnStaUse, FTGmnModCode)
                        VALUES (
                                '" . $paData['FTGmnCode'] . "',
                                '" . $paData['FNGmnShwSeq'] . "',
                                '" . $paData['FTGmnStaUse'] . "',
                                '" . $paData['FTGmnModCode'] . "'
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

    // Functionality : Function Update TSysMenuGrp
    // Parameters : Function Parameter
    // Creator : 16/10/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUUpdateTSysMenuGrp($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            $tSQL = "UPDATE TSysMenuList
            SET
                  FTGmnModCode   = '" . $paData['FTGmnModCode'] . "'
            WHERE FTGmnCode   = '" . $paData['FTGmnCode'] . "'";

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

    // Functionality : Function AddEdit MenuGrp_L
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUAddEditMenuGrp_L($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            $tSQL = "UPDATE TSysMenuGrp_L
            SET
                  FTGmnCode   = '" . $paData['FTGmnCode'] . "',
                  FTGmnName   = '" . $paData['FTGmnName'] . "',
                  FTGmnSystem = '" . $paData['FTGmnModCode'] . "'
            WHERE FTGmnCode   = '" . $paData['FTGmnCode'] . "'
            AND FNLngID = $nLngID";

            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysMenuGrp_L
                    VALUES (
                            '" . $paData['FTGmnCode'] . "',
                            $nLngID,
                            '" . $paData['FTGmnName'] . "',
                            '" . $paData['FTGmnModCode'] . "'
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

    // Functionality : Function Get Dataedit MenuGrp
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUCallModalEditMenuGrp($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT B.FTGmnModCode,
                        B.FTGmnCode,
                        B.FTGmnName,
                        B.FNGmnShwSeq,
                        B.FTGmnModCode
                FROM
                (SELECT A.FTGmnCode,
                        A_L.FTGmnName,
                        A.FNGmnShwSeq,
                        A.FTGmnModCode,
                        ISNULL(A_L.FNLngID,0) AS FNLngID
                FROM    TSysMenuGrp A
                LEFT JOIN TSysMenuGrp_L A_L ON A.FTGmnCode = A_L.FTGmnCode
                ) B
                WHERE 1=1
                AND B.FTGmnCode = '" . $paData['FTGmnCode'] . "'
                AND(B.FNLngID = 0 OR  B.FNLngID = $nLngID)";
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
                'raItems' => $tSQL,
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
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUMenuGrpDeleteData($paData)
    {
        $this->db->trans_begin();

        $this->db->where_in('FTGmnCode', $paData['FTGmnCode']);
        $this->db->delete('TSysMenuGrp');

        $this->db->where_in('FTGmnCode', $paData['FTGmnCode']);
        $this->db->delete('TSysMenuGrp_L');

        $tSQL = "DELETE FROM TSysMenuList_L
                 WHERE FTMnuCode IN (
                                    SELECT FTMnuCode
                                    FROM TSysMenuList A
                                    WHERE A.FTGmnCode = '" . $paData['FTGmnCode'] . "'
                                    )";

        $this->db->query($tSQL);

        $this->db->where_in('FTGmnCode', $paData['FTGmnCode']);
        $this->db->delete('TSysMenuList');

        $this->db->where_in('FTGmnCode', $paData['FTGmnCode']);
        $this->db->delete('TCNTUsrMenu');

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

    // Functionality : Function Adedit menulist
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUAddEditMenuList($paData)
    {
        try {
            if ($paData['FTGmnCode'] != '') {
                $tGmnCode = $paData['FTGmnCode'];
            } else {
                $tGmnCode = $paData['FTGmnModCode'];
            }

            $tTypeURL = $paData['tTypeURL'];
            if($tTypeURL == '2'){
                $tFTMnuCtlName = 'External Link';
                $tFTMnuPath = $paData['FTMnuCtlName'];
            }else{
                $tFTMnuCtlName = $paData['FTMnuCtlName'];
                $tFTMnuPath = '';
            }
            $tSQL = "UPDATE TSysMenuList
            SET
                  FTGmnCode    = '" . $tGmnCode . "',
                  FTMnuParent  = '" . $tGmnCode . "',
                  FTMnuCode    = '" . $paData['FTMnuCode'] . "',
                  FNMnuSeq     = '" . $paData['FNMnuSeq'] . "',
                  FTMnuCtlName = '" . $tFTMnuCtlName . "',
                  FNMnuLevel   = '" . $paData['FNMnuLevel'] . "',
                  FTGmnModCode = '" . $paData['FTGmnModCode'] . "',
                  FTMnuPath    = '" . $tFTMnuPath . "'
            WHERE FTMnuCode    = '" . $paData['FTMnuCode'] . "'
            AND  FTGmnCode    = '" . $tGmnCode . "'
            AND  FTGmnModCode = '" . $paData['FTGmnModCode'] . "'
            ";

            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {
                $tSQL = "INSERT INTO TSysMenuList
                        (
                        FTGmnCode,
                        FTMnuParent,
                        FTMnuCode,
                        FTLicPdtCode,
                        FNMnuSeq,
                        FTMnuCtlName,
                        FNMnuLevel,
                        FTMnuStaPosHpm,
                        FTMnuStaPosFhn,
                        FTMnuStaSmartHpm,
                        FTMnuStaSmartFhn,
                        FTMnuStaMoreHpm,
                        FTMnuStaMoreFhn,
                        FTMnuType,
                        FTMnuStaAPIPos,
                        FTMnuStaAPISmart,
                        FTMnuStaUse,
                        FTMnuPath,
                        FTGmnModCode,
                        FTMnuImgPath
                        )
                        VALUES (
                                '" . $tGmnCode . "',
                                '" . $tGmnCode . "',
                                '" . $paData['FTMnuCode'] . "',
                                '" . $paData['FTMnuCode'] . "',
                                '" . $paData['FNMnuSeq'] . "',
                                '" . $tFTMnuCtlName . "',
                                '" . $paData['FNMnuLevel'] . "',
                                'Y','Y','Y','Y','Y','Y','1','Y','Y','1','" . $tFTMnuPath . "',
                                '" . $paData['FTGmnModCode'] . "',''
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
    public function FSaMSMUAddEditMenuList_L($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];
            $tSQL = "UPDATE TSysMenuList_L
                    SET
                          FTMnuCode   = '" . $paData['FTMnuCode'] . "',
                          FTMnuName   = '" . $paData['FTMnuName'] . "',
                          FTMnuRmk    = '" . $paData['FTMnuRmk'] . "'
                    WHERE FTMnuCode   = '" . $paData['FTMnuCode'] . "'
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
                            '" . $paData['FTMnuCode'] . "',
                            '" . $paData['FNLngID'] . "',
                            '" . $paData['FTMnuName'] . "',
                            '" . $paData['FTMnuRmk'] . "'
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
    public function FSaMSMUAddEditTSysMenuAlbAct($paData)
    {
        try {
            $nLngID = $paData['FNLngID'];

            $tSQL = "UPDATE TSysMenuAlbAct
            SET
                  FTMnuCode      = '" . $paData['FTMnuCode'] . "',
                  FTAutStaRead   = '" . $paData['FTAutStaRead'] . "',
                  FTAutStaAdd    = '" . $paData['FTAutStaAdd'] . "',
                  FTAutStaEdit   = '" . $paData['FTAutStaEdit'] . "',
                  FTAutStaDelete = '" . $paData['FTAutStaDelete'] . "',
                  FTAutStaCancel = '" . $paData['FTAutStaCancel'] . "',
                  FTAutStaAppv   = '" . $paData['FTAutStaAppv'] . "',
                  FTAutStaPrint  = '" . $paData['FTAutStaPrint'] . "',
                  FTAutStaPrintMore  = '" . $paData['FTAutStaPrintMore'] . "'
            WHERE FTMnuCode   = '" . $paData['FTMnuCode'] . "'";
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {

                $tSQL = "INSERT INTO TSysMenuAlbAct
                    VALUES (
                            '" . $paData['FTMnuCode'] . "',
                            '" . $paData['FTAutStaRead'] . "',
                            '" . $paData['FTAutStaAdd'] . "',
                            '" . $paData['FTAutStaEdit'] . "',
                            '" . $paData['FTAutStaDelete'] . "',
                            '" . $paData['FTAutStaCancel'] . "',
                            '" . $paData['FTAutStaAppv'] . "',
                            '" . $paData['FTAutStaPrint'] . "',
                            '" . $paData['FTAutStaPrintMore'] . "'
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
    public function FSaMSMUAddEditTCNTUsrMenu($paData,$paDataHQ)
    {
        try {
            if ($paData['FTGmnCode'] != '') {
                $tGmnCode = $paData['FTGmnCode'];
            } else {
                $tGmnCode = $paData['FTGmnModCode'];
            }
            $tSQL = "UPDATE TCNTUsrMenu
            SET
                  FTGmnCode      = '" . $tGmnCode . "',
                  FTMnuParent    = '" . $tGmnCode . "'
            WHERE FTMnuCode   = '" . $paData['FTMnuCode'] . "'";
            
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success.',
                );
            } else {

                $dDateNow = date("Y-m-d H:i:s");
                for ($n=0; $n < count($paDataHQ['raItems']); $n++) {
                    $tUsrCode = $paDataHQ['raItems'][$n]['FTUsrCode'];
                    $tFTRolCode = $paDataHQ['raItems'][$n]['FTRolCode'];
                    $tSQL .= "INSERT INTO TCNTUsrMenu
                              VALUES (
                                    '" . $tFTRolCode . "',
                                    '" . $tGmnCode . "',
                                    '" . $tGmnCode . "',
                                    '" . $paData['FTMnuCode'] . "',
                                    '0','1','1','1','1','0','0','0','0','0',
                                    '" . $dDateNow . "',
                                    '" . $tUsrCode . "',
                                    '" . $dDateNow . "',
                                    '" . $tUsrCode . "'
                                )";
                }

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


    public function FSaMSMUGETHQ()
    {
      $tSQL = "SELECT A.FTUsrCode , B.FTRolCode FROM TCNTUsrGroup A
                LEFT JOIN TCNMUsrActRole B ON A.FTUsrCode = B.FTUsrCode
                WHERE A.FTBchCode = '' AND A.FTShpCode ='' AND A.FTMerCode='' AND A.FTAgnCode ='' AND ISNULL(B.FTRolCode,'') <> ''";
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
      return $aResult;
    }

    // Functionality : Function Call Modal EditMenuList
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUCallModalEditMenuList($paData)
    {
        $nLngID = $paData['FNLngID'];

        $tSQL = "SELECT E.FTGmnModCode,
                        E.FTGmnModName,
                        D.FTGmnCode,
                        D.FTGmnName,
                        B.FTMnuCode,
                        B.FTMnuName,
                        B.FTMnuRmk,
                        A.FNMnuSeq,
                        A.FTMnuCtlName,
                        A.FTMnuPath,
                        C.FTAutStaAdd,
                        C.FTAutStaAppv,
                        C.FTAutStaCancel,
                        C.FTAutStaDelete,
                        C.FTAutStaEdit,
                        C.FTAutStaPrint,
                        C.FTAutStaPrintMore,
                        C.FTAutStaRead
                FROM TSysMenuList A
                LEFT JOIN TSysMenuList_L B ON B.FTMnuCode = A.FTMnuCode AND B.FNLngID = $nLngID
                LEFT JOIN TSysMenuAlbAct C ON C.FTMnuCode = B.FTMnuCode
                LEFT JOIN TSysMenuGrp_L  D ON D.FTGmnCode = A.FTGmnCode AND D.FNLngID = $nLngID
                LEFT JOIN TSysMenuGrpModule_L E ON E.FTGmnModCode = A.FTGmnModCode AND E.FNLngID = $nLngID
                WHERE A.FTMnuCode = '" . $paData['FTMnuCode'] . "'";
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
                'raItems' => $tSQL,
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

    // Functionality : Function Delete Menulist
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUMenuListDeleteData($paData)
    {
        $this->db->trans_begin();

        $this->db->where_in('FTMnuCode', $paData['FTMnuCode']);
        $this->db->delete('TSysMenuList');

        $this->db->where_in('FTMnuCode', $paData['FTMnuCode']);
        $this->db->delete('TSysMenuList_L');

        $this->db->where_in('FTMnuCode', $paData['FTMnuCode']);
        $this->db->delete('TSysMenuAlbAct');

        $this->db->where_in('FTMnuCode', $paData['FTMnuCode']);
        $this->db->delete('TCNTUsrMenu');

        if (substr($paData['FTMnuCode'], 0, -3) == 'RPT') {
            $tRptModCode = substr($paData['FTMnuCode'], 3, 3);
            $this->db->where_in('FTGrpRptModCode', $tRptModCode);
            $this->db->delete('TSysReportModule');

            $this->db->where_in('FTGrpRptModCode', $tRptModCode);
            $this->db->delete('TSysReportModule_L');

            $tSQL = "DELETE FROM TSysReportGrp_L
            WHERE FTGrpRptCode IN (
                               SELECT FTGrpRptCode
                               FROM TSysReportGrp A
                               WHERE A.FTGrpRptModCode = '" . $tRptModCode . "'
                               )";

            $this->db->query($tSQL);

            $this->db->where_in('FTGrpRptModCode', $tRptModCode);
            $this->db->delete('TSysReportGrp');

            $tSQL = "DELETE FROM TSysReport_L
            WHERE FTRptCode IN (
                               SELECT FTRptCode
                               FROM TSysReport A
                               WHERE A.FTGrpRptModCode = '" . $tRptModCode . "'
                               )";

            $this->db->query($tSQL);

            $this->db->where_in('FTGrpRptModCode', $tRptModCode);
            $this->db->delete('TSysReport');
        }
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

    // Functionality : Function Update StaUse
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUUpdateStaUse($paData)
    {
        $this->db->set($paData['tFieldName'], $paData['nValue']);
        $this->db->where($paData['tFieldWhere'], $paData['tCode']);
        $this->db->update($paData['tTableName']);

        if ($this->db->trans_status() === false) {
            $aStatus = array(
                'rtCode' => '99',
                'rtDesc' => 'Error Cannot Update Data Stause.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Stause Complete.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function Get MaxSequence
    // Parameters : Function Parameter
    // Creator : 20/08/2020 Sooksanti(Non)
    // Last Modified :
    // Return : array
    // Return Type : array
    public function FSaMSMUCallMaxSequence($paData)
    {
        $this->db->select_max($paData['tFieldName']);
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

    public function FSaMSMUCheckDupSeq($paData)
    {
        switch ($paData['tType']) {
            case "Module":
                $this->db->select('*');
                $this->db->where($paData['tFieldWhere'].'!=', $paData['tCode']);
                $this->db->where($paData['tSeqTableName'], $paData['tSeq']);
                $oQuery = $this->db->get($paData['tTableName']);
              break;
            case "MenuGrp":
                $this->db->select('*');
                $this->db->where('FTGmnCode !=', $paData['tCode']);
                $this->db->where('FTGmnModCode', $paData['tCode1']);
                $this->db->where('FNGmnShwSeq', $paData['tSeq']);
                $oQuery = $this->db->get($paData['tTableName']);
              break;
            case "Menulist":
                $this->db->select('*');
                $this->db->where('FTMnuCode !=', $paData['tCode']);
                $this->db->where('FTGmnModCode', $paData['tCode1']);
                $this->db->where('FTGmnCode', $paData['tCode2']);
                $this->db->where('FNMnuSeq', $paData['tSeq']);
                $oQuery = $this->db->get($paData['tTableName']);
              break;
            case "RptMod":
                $this->db->select('*');
                $this->db->where('FTGrpRptModCode !=', $paData['tCode']);
                $this->db->where('FNGrpRptModShwSeq', $paData['tSeq']);
                $oQuery = $this->db->get($paData['tTableName']);
              break;
            case "MenuGrpRpt":
                $this->db->select('*');
                $this->db->where('FTGrpRptCode !=', $paData['tCode']);
                $this->db->where('FTGrpRptModCode', $paData['tCode1']);
                $this->db->where('FNGrpRptShwSeq', $paData['tSeq']);
                $oQuery = $this->db->get($paData['tTableName']);
              break;
            case "MenulistRpt":
                $this->db->select('*');
                $this->db->where('FTRptCode !=', $paData['tCode']);
                $this->db->where('FTGrpRptModCode', $paData['tCode1']);
                $this->db->where('FTGrpRptCode', $paData['tCode2']);
                $this->db->where('FTRptSeqNo', $paData['tSeq']);
                $oQuery = $this->db->get($paData['tTableName']);
              break;
        }

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aStatus = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'Sequence Duplicate',
            );
        } else {
            $aStatus = array(
                'rtCode' => '99',
                'rtDesc' => 'Sequence Not Duplicate',
            );
        }
        return $aStatus;
    }

    public function FSaMSMUSwitchSeq($paData)
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
