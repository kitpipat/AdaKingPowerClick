<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSettingconperiod extends CI_Model {
    
    //Functionality : list Data SettingConperiod
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSaMLIMList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSesAgnCode    = $this->session->userdata("tSesUsrAgnCode");

            $tSQL           = "SELECT c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY rtLhdCode DESC) AS rtRowID,* FROM
                                        (SELECT DISTINCT
                                            LIM.FTLhdCode    AS rtLhdCode,
                                            LIM.FTRolCode    AS rtRolCode,
                                            LIM.FNLimSeq     AS rtLimSeq,
                                            LIM.FCLimMin     AS rtLimMin,
                                            LIM.FCLimMax     AS rtLimMax,
                                            LIM.FTLimStaWarn AS rtLimStaWarn,
                                            LIM.FTLimMsgSpc  AS rtLimMsgSpc,
                                            LIM.FDCreateOn   AS rtCreateOn,
                                            ROL.FTRolName    AS rtRolName,
                                            LIMHD_L.FTLhdName AS rtLhdName,
                                            LIMHD.FTLhdStaAlwSeq AS rtStaAlwSeq,
			                                LIMHD.FTLhdStaUse AS rtStaUse 
                                        FROM TCNMLimitRole LIM  WITH(NOLOCK)
                                        LEFT JOIN TCNMUsrRole_L ROL ON LIM.FTRolCode = ROL.FTRolCode AND ROL.FNLngID = $nLngID
                                        LEFT JOIN TCNSLimitHD LIMHD ON LIM.FTLhdCode  = LIMHD.FTLhdCode
                                        LEFT JOIN TCNSLimitHD_L LIMHD_L ON LIM.FTLhdCode = LIMHD_L.FTLhdCode AND LIMHD_L.FNLngID = $nLngID
                                        WHERE 1=1 
                                        AND LIM.FNLimSeq = 1";

            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND (LIM.FTLhdCode LIKE '%$tSearchList%'";
                $tSQL .= " OR LIMHD_L.FTLhdName  LIKE '%$tSearchList%')";
            }

            if($tSesAgnCode != ''){
                $tSQL .= " AND LIM.FTAgnCode = '$tSesAgnCode' ";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMLIMGetPageAll($tSearchList, $nLngID);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
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
        }catch (Exception $Error) {
            echo $Error;
        }

    }

    //Functionality : All Page Of SettingConperiod
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSoMLIMGetPageAll($ptSearchList, $pnLngID){
        try{
            $tSesAgnCode  = $this->session->userdata("tSesUsrAgnCode");
            $tSQL = "SELECT COUNT (LIM.FTLhdCode) AS counts
                    FROM TCNMLimitRole LIM
                    LEFT JOIN TCNMUsrRole_L ROL ON LIM.FTRolCode = ROL.FTRolCode AND ROL.FNLngID = $pnLngID
                    LEFT JOIN TCNSLimitHD_L LIMHD_L ON LIM.FTLhdCode = LIMHD_L.FTLhdCode AND LIMHD_L.FNLngID = $pnLngID
                    WHERE 1=1 
                    AND LIM.FNLimSeq = 1 ";

            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND (LIM.FTLhdCode LIKE '%$tSearchList%'";
                $tSQL .= " OR LIMHD_L.FTLhdName  LIKE '%$tSearchList%')";
            }

            if($tSesAgnCode != ''){
                $tSQL .= " AND LIM.FTAgnCode = '$tSesAgnCode' ";
            }
    
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }

        }catch (Exception $Error) {
            echo $Error;
        }
    }

    //function Check StaAlwSeq จากตาราง TCNSLimitHD/TCNSLimitHD_L 
    // ถ้า เป็น 1 ให้อณุญาติ เพิ่ม REcord ได้ ถ้าเป็น 2 ไม่อณุญาติให้เพิ่ม
    public function FSaMLIMCheckStaAlwSeq($paData){
        try{
            $nLhdCode       =  $paData['FTLhdCode'];
            $nLngID       =  $paData['FNLngID'];

            $tSQL = "SELECT * 
                        FROM TCNSLimitHD  LIMHD
                        LEFT JOIN TCNSLimitHD_L LIMHD_L ON LIMHD.FTLhdCode = LIMHD_L.FTLhdCode AND LIMHD_L.FNLngID = $nLngID
                        WHERE 1 = 1
                        AND LIMHD.FTLhdCode = '$nLhdCode'  ";
                $oQuery = $this->db->query($tSQL);
                if ($oQuery->num_rows() > 0) {
                    $aList = $oQuery->result_array();
                    $aResult = array(
                        'raItems'       => $aList,
                        'rtCode'        => '1',
                        'rtDesc'        => 'success',
                    );
                } else {
                    //No Data
                    $aResult = array(
                        'rtCode' => '800',
                        'rtDesc' => 'data not found',
                    );
                }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    public function FSaMLIMCheckRolCode($paData){
        try{

            $nLngID  = $this->session->userdata("tLangEdit");
            $nLhdCode       =  $paData['FTLhdCode'];
            $nGrpRolCode    =  $paData['FTRolCode'];

            $tSQL = "SELECT *
                        FROM TCNMLimitRole LIM
                    LEFT JOIN TCNMUsrRole_L ROL ON LIM.FTRolCode = ROL.FTRolCode AND ROL.FNLngID = $nLngID
                    LEFT JOIN TCNSLimitHD LIMHD ON LIM.FTLhdCode  = LIMHD.FTLhdCode
                    LEFT JOIN TCNSLimitHD_L LIMHD_L ON LIM.FTLhdCode = LIMHD_L.FTLhdCode AND LIMHD_L.FNLngID = $nLngID
                    WHERE 1=1 
                    AND LIM.FTLhdCode = '$nLhdCode' 
                    AND LIM.FTRolCode = '$nGrpRolCode'";

                $oQuery = $this->db->query($tSQL);

                if ($oQuery->num_rows() > 0) {
                    $aList = $oQuery->result_array();
                    $aResult = array(
                        'raItems'       => $aList,
                        'rtCode'        => '1',
                        'rtDesc'        => 'success',
                    );
                } else {
                    //No Data
                    $aResult = array(
                        'rtCode' => '800',
                        'rtDesc' => 'data not found',
                    );
                }
            return $aResult;
        }catch(Exception  $Error){
            echo $Error;

        }

    }

    //Functionality : Delete Setting Connection 
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSnMSettingConDel($paData){
        $this->db->where_in('FTLhdCode',$paData['FTLhdCode']);
        $this->db->where_in('FTRolCode',$paData['FTRolCode']);
        $this->db->delete('TCNMLimitRole');

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

    //Functionality : Delete Mutiple Object
    //Creator : 26/07/2019 Witsarut
    public function FSaMLIMDeleteMultiple($paData){
        $this->db->where_in('FTLhdCode',$paData['aDataLhdCode']);
        $this->db->where_in('FTRolCode',$paData['aDataRolCode']);
        $this->db->delete('TCNMLimitRole');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus   = array(
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

    //Functionality : Get all row 
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSnMSettingConGetAllNumRow(){
        $tSQL = "SELECT 
                    COUNT(*) AS FNAllNumRow 
                FROM TCNMLimitRole
                WHERE 1=1
                AND FNLimSeq = '1' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    //Functionality : Function CallPage SettingConditioinPeriod
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSaMLIMGetDataByID($paData){
        try{

            $tLhdCode   = $paData['FTLhdCode'];
            $tRolCode   = $paData['FTRolCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                LIM.FTLhdCode    AS rtLhdCode,
                                LIM.FTRolCode    AS rtRolCode,
                                LIM.FNLimSeq     AS rtLimSeq,
                                LIM.FCLimMin     AS rtLimMin,
                                LIM.FCLimMax     AS rtLimMax,
                                LIM.FTLimStaWarn AS rtLimStaWarn,
                                LIM.FTLimMsgSpc  AS rtLimMsgSpc,
                                LIM.FDCreateOn   AS rtCreateOn,
                                ROL.FTRolName    AS rtRolName,
                                LIMHD_L.FTLhdName AS rtLhdName,
                                LIMHD.FTLhdStaAlwSeq AS rtStaAlwSeq,
                                LIMHD.FTLhdStaUse AS rtStaUse ,
                                AGNL.FTAgnCode ,
                                AGNL.FTAgnName
                            FROM TCNMLimitRole LIM  WITH(NOLOCK)
                            LEFT JOIN TCNMUsrRole_L ROL ON LIM.FTRolCode = ROL.FTRolCode AND ROL.FNLngID = $nLngID
                            LEFT JOIN TCNSLimitHD LIMHD ON LIM.FTLhdCode  = LIMHD.FTLhdCode
                            LEFT JOIN TCNSLimitHD_L LIMHD_L ON LIM.FTLhdCode = LIMHD_L.FTLhdCode AND LIMHD_L.FNLngID = $nLngID
                            LEFT JOIN TCNMAgency_L AGNL ON LIM.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                            WHERE 1=1
                            AND LIM.FTLhdCode ='$tLhdCode'
                            AND LIM.FTRolCode = '$tRolCode' ";

                $oQuery = $this->db->query($tSQL);

                if ($oQuery->num_rows() != 0){
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

    //Check Count Seq
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSaMLIMChkCntSeq($paData){

        $tLhdCode = $paData['FTLhdCode'];
        $tRolCode = $paData['FTRolCode'];


        $tSQL = "SELECT COUNT(*) AS FNAllNumRowSeq 
                FROM TCNMLimitRole
                WHERE 1=1
                AND FTLhdCode ='$tLhdCode' 
                AND FTRolCode ='$tRolCode' ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRowSeq"];
        }else{
            $aResult = false;
        }
        return $aResult;

    }

    // function Delete OldData first
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSaMLIMDeleteFrist($paData){
        try{
            $this->db->where_in('FTLhdCode', $paData['aFTLhdCode']);
            $this->db->where_in('FTRolCode', $paData['aFTRolCode']);
            $this->db->delete('TCNMLimitRole');

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
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Insert INto TCNMLimitRole
    //Creator :  19/09/2019 Witsarut (Bell)
    public function FSaMLIMUpdate($paData){
        try{

            $aResultAdd = array(
                'FTLhdCode'     => $paData['FTLhdCode'],
                'FTRolCode'     => $paData['FTRolCode'],
                'FTAgnCode'     => $paData['FTAgnCode'],
                'FNLimSeq'      => $paData['FNLimSeq'],
                'FCLimMin'      => $paData['FCLimMin'],
                'FCLimMax'      => $paData['FCLimMax'],
                'FTLimStaWarn'  => $paData['FTLimStaWarn'],
                'FTLimMsgSpc'   => $paData['FTLimMsgSpc'],
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata("tSesUserCode"),
                'FTLastUpdBy'   => $this->session->userdata("tSesUserCode"),
            );

            $this->db->insert('TCNMLimitRole',$aResultAdd);
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

        }

    }
  
}
