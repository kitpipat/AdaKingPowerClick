<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCustomerDebitCard extends CI_Model
{

    //Functionality : List CompSettingConnection
    //Parameters : function parameters
    //Creator :  19/10/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMCstDebitCardDataList($paData)
    {

        try {
            $tCstCode       =  $paData['FTCrdRefCode'];
            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FTCrdRefCode ASC) AS rtRowID,*
                                FROM(
                                    SELECT 	
                                        CRDMAN.FTCrdCode,
                                        CRDMAN.FTCrdRefCode,
                                        CRDMAN.FTCrdTable,
                                        CTY_L.FTCtyName, 
                                        --CRD.FCCrdValue,
                                        CRD.FDCrdExpireDate,
                                        CRD.FTCrdStaActive
                                    FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                                    LEFT JOIN TFNMCard CRD  WITH(NOLOCK) ON CRDMAN.FTCrdCode = CRD.FTCrdCode
                                    LEFT JOIN TFNMCardType_L CTY_L WITH(NOLOCK) ON CRD.FTCtyCode = CTY_L.FTCtyCode
                                    WHERE 1=1
                                    AND CRDMAN.FTCrdRefCode    = '$tCstCode'
                            ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";


            $oQuery  = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMCstDebitCardGetPageAll($tSearchList, $paData);
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
                // if don't have data
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


    //Functionality : Count CompSettingConnection
    //Parameters : function parameters
    //Creator :  19/08/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSoMCstDebitCardGetPageAll($ptSearchList, $paData)
    {
        try {
            $tCstCode       =  $paData['FTCrdRefCode'];
            $tSQL           =  " SELECT 
                                    COUNT (CRDMAN.FTCrdRefCode) AS counts
                                FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                                WHERE 1=1
                                AND CRDMAN.FTCrdRefCode    = '$tCstCode'
                        ";
            if (isset($ptSearchList) && !empty($ptSearchList)) {
                $tSQL .= " AND (URLObj.FNUrlID LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data FSaMCstDebitCardCheckID
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCstDebitCardCheckID($paData)
    {
        try {
            $tCstCode   =  $paData['FTCrdRefCode'];
            $tnLngID    = $paData['FNLngID'];

            $tSQL  = "SELECT 	
                        CRDMAN.FTCrdCode,
                        CRDMAN.FTCrdRefCode,
                        CRDMAN.FTCrdTable,
                        CTY_L.FTCtyName,                    
                        CRD.FDCrdExpireDate,
                        CRD.FTCrdStaActive
                    FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                    LEFT JOIN TFNMCard CRD  WITH(NOLOCK) ON CRDMAN.FTCrdCode = CRD.FTCrdCode
                    LEFT JOIN TFNMCardType_L CTY_L WITH(NOLOCK) ON CRD.FTCtyCode = CTY_L.FTCtyCode
                    WHERE 1=1
                    AND CRDMAN.FTCrdRefCode    = '$tCstCode'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $oDetail    = $oQuery->result();
                $aResult = array(
                    'raItems'   => $oDetail,
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
        } catch (exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Add Data
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCSTAddUpdateMaster($paDataAdd)
    {

        try {
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aResult = array(
                    'FTCrdCode'    => $paDataAdd['FTCrdCode'],
                    'FTCrdRefCode' => $paDataAdd['FTCrdRefCode'],
                    'FTCrdTable'   => $paDataAdd['FTCrdTable'],
                );

                //Add Master
                $this->db->insert('TFNMCardMan', $aResult);

                //update Card Holderid
                $this->db->where('FTCrdCode', $paDataAdd['FTCrdCode']);
                $this->db->update('TFNMCard', array(
                    'FTCrdHolderID' => $paDataAdd['FTCrdRefCode'],
                ));

                //ถ้าเพิ่มบัตรเดบิตเเล้ว ต้องเพิ่ม ข้อมูลบัตรสมาชิก
                $tFTCrdRefCode  = $paDataAdd['FTCrdRefCode'];
                $tSQL           = "SELECT * FROM TCNMCstCard WHERE FTCstCode  = '$tFTCrdRefCode' ";
                $oQuery         = $this->db->query($tSQL);
                $bInsertCstCard = false;
                if ($oQuery->num_rows() > 0) {
                    //ถ้ามันมีเเล้วไม่ต้องเพิ่ม
                    $bInsertCstCard = false;
                } else {
                    $this->db->insert('TCNMCstCard', array(
                        'FTCstCode'         => $tFTCrdRefCode,
                        'FTCstCrdNo'        => $paDataAdd['FTCrdCode'],
                        'FDCstApply'        => date('Y-m-d H:i:s'),
                        'FDCstCrdIssue'     => date('Y-m-d H:i:s'),
                        'FDCstCrdExpire'    => date('Y-m-d', strtotime("+1 year")),
                        'FTBchCode'         => $this->session->userdata("tSesUsrBchCodeDefault"),
                        'FTCstStaAge'       => 1
                    ));
                    $bInsertCstCard = true;
                }

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode'            => '1',
                        'rtDesc'            => 'Add Success',
                        'rtCardCode'        => $paDataAdd['FTCrdCode'],
                        'bInsertCstCard'    => $bInsertCstCard
                    );
                } else {
                    $aStatus = array(
                        'rtCode'            => '905',
                        'rtDesc'            => 'Error Cannot Add/Edit Master.',
                        'rtCardCode'        => '',
                        'bInsertCstCard'    => $bInsertCstCard
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            $Error;
        }
    }

    //Functionality : Delete CustomerDebitCard 
    //Parameters : function parameters
    //Creator : 19/09/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCstDebitCard($paData)
    {

        try {
            $this->db->trans_begin();
            $this->db->where_in('FTCrdCode', $paData['FTCrdCode']);
            $this->db->where_in('FTCrdRefCode', $paData['FTCrdRefCode']);
            $this->db->delete('TFNMCardMan');

            $this->db->where_in('FTCrdCode', $paData['FTCrdCode']);
            $this->db->update('TFNMCard', array(
                'FTCrdHolderID' => $paData['FTCrdRefCode'],
            ));

            //เอาบัตรออก จะวิ่งไปลบข้อมูลสมาชิกออกด้วย
            $this->db->where_in('FTCstCrdNo', $paData['FTCrdCode']);
            $this->db->where_in('FTCstCode', $paData['FTCrdRefCode']);
            $this->db->delete('TCNMCstCard');

            //ถ้าลบบัตรเดบิตเเล้ว ต้องวิ่งไปเช็คว่ายังมีผูกอยู่ไหม ถ้าไม่มี ให้ข้อมูลบัตรสมาชิกเอาออกด้วย
            $tFTCrdRefCode  = $paData['FTCrdRefCode'];
            $tSQL           = "SELECT * FROM TCNMCstCard WHERE FTCstCode  = '$tFTCrdRefCode' ";
            $oQuery         = $this->db->query($tSQL);
            $bClearCstCard  = false;
            if ($oQuery->num_rows() > 0) {
                //ถ้ามันมีอยู่ เเล้วไม่ต้องเคลียร์
                $bClearCstCard = false;
            } else {
                $bClearCstCard = true;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode'            => '905',
                    'rtDesc'            => 'Delete Unsuccess.',
                    'bClearCstCard'     => $bClearCstCard
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode'            => '1',
                    'rtDesc'            => 'Delete Success.',
                    'bClearCstCard'     => $bClearCstCard
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            $Error;
        }
    }

    //Functionality : Get all row 
    //Parameters : -
    //Creator : 19/09/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMCstDebitCrdGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMCardMan";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }

    //Functionality : check Data CheckDupiate
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCstCheckCrdCode($paData)
    {
        $tRefCode    = $paData['FTCrdRefCode'];
        $tCrdCode    = $paData['FTCrdCode'];

        $tSQL  = "SELECT 	
                    CRDMAN.FTCrdCode
                FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                WHERE 1=1
                AND CRDMAN.FTCrdRefCode = '$tRefCode'
                AND CRDMAN.FTCrdCode = '$tCrdCode'
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



    //Functionality : Get Sum Bal
    //Parameters : function parameters
    //Creator : 02/11/2020 Worakorn 
    //Last Modified : -
    //Return : data
    //Return Type : Numberic
    function FSnMCstDataSumTotalCard($paData)
    {
        $tCrdCode   = $paData['FTCrdCode'];
        $tSQL = "  SELECT ((Crad.CashIn + Promotion ) - Payment ) AS TotalAmount,((Crad.CashIn + Promotion ) - DepositCrd - Payment  ) AS TotalUse , DepositCrd AS TotalDepositCrd  FROM (
        SELECT 
            SUM(CASE WHEN TCB.FTCrdTxnCode='001'
            THEN ISNULL(TCB.FCCrdValue,0)
            ELSE 0
            END) CashIn ,
            SUM(CASE WHEN TCB.FTCrdTxnCode='002'
            THEN ISNULL(TCB.FCCrdValue,0)
            ELSE 0
            END) Promotion ,
            SUM(CASE WHEN TCB.FTCrdTxnCode='003'
            THEN ISNULL(TCB.FCCrdValue,0)
            ELSE 0
            END) DepositCrd ,
            SUM(CASE WHEN TCB.FTCrdTxnCode='004'
            THEN ISNULL(TCB.FCCrdValue,0)
            ELSE 0
            END) DepositPdt ,
            SUM(CASE WHEN TCB.FTCrdTxnCode='005'
            THEN ISNULL(TCB.FCCrdValue,0)
            ELSE 0
            END) NotReturn ,
            SUM(CASE WHEN TCB.FTCrdTxnCode='006'
            THEN ISNULL(TCB.FCCrdValue,0)
            ELSE 0
            END) Payment
        FROM TFNMCardBal TCB
        WHERE FTCrdCode  = '$tCrdCode'
     ) AS Crad";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        }
    }
}
