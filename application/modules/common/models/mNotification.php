<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mNotification extends CI_Model {

    //ไปดึงข้อความมาจากฐานข้อมูล
    public function FSaMGetNotification(){
        try{

            $tBranchCom  =  $this->session->userdata('tSesUsrBchCom');
            $tUserName   =  $this->session->userdata('tSesUsername');
            $tUserCode   =  $this->session->userdata('tSesUserCode');
            $tSQL        ="	SELECT 
                            NI.FTMsgID,
                            NI.FTNtiContents,
                            NI.FDNtiSendDate,
                            NI.FTBchCode,
                            NI.FTNtiTopic,
                            NR.FTUsrCode
                            FROM TCNTNoti NI
                        LEFT JOIN TCNTNotiRead NR ON NI.FTNtiID = NR.FTNtiID AND  NR.FTUsrCode = '$tUserCode'
                        WHERE NR.FTUsrCode IS NULL 
                        AND NI.FTBchCode = '$tBranchCom'";
            $oQuery  =  $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $aResult = array(
                    'raItems'       => $aList,
                    'rtCode'        => '1',
                );
            }else{
                $aResult = array(
                    'rtCode' => '900',
                    'rtDesc' => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //เพิ่มข้อความลงในฐานข้อมูล
    public function FSaMAddNotification($paData){
        $tContent =   $paData['FTNtiContents'];
        // Insert Table TCNTNoti
        $aResult   = array(
            'FTNtiID'         => $paData['FTNtiID'],
            'FTMsgID'         => $paData['FTMsgID'],
            'FTBchCode'       => $paData['FTBchCode'],
            'FDNtiSendDate'   => $paData['FDNtiSendDate'],
            'FTNtiTopic'      => $paData['FTNtiTopic'],
            'FTNtiContents'   => $tContent,
            'FTNtiUsrRole'    => $paData['FTNtiUsrRole'],
            'FDLastUpdOn'     => $paData['FDLastUpdOn'],
            'FTLastUpdBy'     => $paData['FTLastUpdBy'],
            'FDCreateOn'      => $paData['FDCreateOn'],
            'FTCreateBy'      => $paData['FTCreateBy']
        );

        $this->db->insert('TCNTNoti',$aResult);
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Noti Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Insert Noti.',
            );
        }
        return $aStatus;
    }

    //เช็คข้อความซ้ำ
    public function FSaMCheckNotiMsgID($paData){

        $tMsgID     = $paData['FTMsgID'];
        $tNtiID     = $paData['FTNtiID'];


        $tBranchCom  =  $this->session->userdata('tSesUsrBchCom');
        $tUserName   =  $this->session->userdata('tSesUsername');

        $tSQL       = "SELECT 
                            NOTI.FTNtiID
                       FROM [TCNTNoti] NOTI WITH(NOLOCK)
                       WHERE 1=1
                       AND NOTI.FTNtiID ='$tNtiID' 
                    ";
        $oQuery  =  $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            // IF data Not found
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //กดว่าอ่านแล้ว
    public function FSaMMoveDataTableNotiToTableRead(){
        try{
            $tBranchCom  = $this->session->userdata('tSesUsrBchCom');
            $tUserName   = $this->session->userdata('tSesUsername');
            $tUserCode   =  $this->session->userdata('tSesUserCode');

            $dDate       = date('Y-m-d H:i:s');
            $tSQL        = "INSERT INTO TCNTNotiRead (
                                FTNtiID, 
                                FTUsrCode, 
                                FDNtrReadDate
                            )
                            SELECT 
                                NOTI.FTNtiID , 
                                '$tUserName' AS FTUsrCode , 
                                '$dDate' AS FDNtrReadDate
                            FROM TCNTNoti NOTI  
                            LEFT JOIN TCNTNotiRead NOTR ON NOTI.FTNtiID = NOTR.FTNtiID AND NOTR.FTUsrCode = '$tUserCode'
                            WHERE ";
            $tSQL        .= "NOTI.FTBchCode = '$tBranchCom'";
            $tSQL        .= " AND NOTR.FTUsrCode IS NULL ";
            $this->db->query($tSQL);
        }catch(Exception $Error){
            echo $Error;
        }
    }

   //หาประเภท Noti ของ user
    public function FSoMNTFGetUsrNotCode(){
        try{
            $tSesUsrRoleCodeMulti   =  $this->session->userdata('tSesUsrRoleCodeMulti');
            $tSQL        = "SELECT
                                NOTI.FTRptCode
                            FROM
                                TCNSRptSpc NOTI
                            WHERE
                                NOTI.FTRolCode IN ($tSesUsrRoleCodeMulti)";
            $oQuery  =  $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $oDetail    = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                // IF data Not found
                $aResult = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    
   //หาวันที่ล่าสุดของ โนติของ ผู้ใช้
   public function FSoMNTFGetUsrLastNoti(){
    try{
        $tSesUserCode   =  $this->session->userdata('tSesUserCode');
        $tSQL        = "SELECT
                            USR.FDUsrLastNoti
                        FROM
                             TCNMUser USR
                        WHERE
                            USR.FTUsrCode ='$tSesUserCode' ";
        $oQuery  =  $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->row_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            // IF data Not found
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        return $aResult;
    }catch(Exception $Error){
        echo $Error;
    }
}

   //อัพเดทวันที่ล่าสุด
   public function FSoMNTFUpdateLastDate(){
    try{
            $this->db->set('FDUsrLastNoti',date('Y-m-d H:i:s'))->where('FTUsrCode',$this->session->userdata('tSesUserCode'))->update('TCNMUser');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Noti Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Insert Noti.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // ตรวจสอบว่ามีสิทธิการใช้งาน แจ้งเตือน หรือ ข่าวสาร หรือไม่ ?
    public function FSaMMENUChkAlwNoti(){

        $tRoleCodeMulti = FCNoGetCookieVal("tSesUsrRoleCodeMulti");

        $tSQL        = "    SELECT 
                                A.FTGrpNoti,
                                CASE WHEN ISNULL(SUM(A.FNAlwActive),0) > 0 THEN 'Y' ELSE 'N' END AS FTAlwActive
                            FROM (
                                SELECT
                                    NOTI.FTNotCode,
                                    CASE WHEN NOTI.FTNotCode = '00000' THEN 'NEWS' ELSE 'NOTI' END AS FTGrpNoti,
                                    SUM(ISNULL(CONVERT(INT,RPTSPC.FTRptStaActive),0)) AS FNAlwActive
                                FROM TCNSNoti           NOTI WITH(NOLOCK)
                                LEFT JOIN TCNSRptSpc RPTSPC WITH(NOLOCK) ON NOTI.FTNotCode = RPTSPC.FTRptCode AND RPTSPC.FTRolCode IN ($tRoleCodeMulti)
                                GROUP BY NOTI.FTNotCode
                            ) A
                            GROUP BY A.FTGrpNoti 
                       ";
        $oQuery  =  $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found',
            );
        }
        return $aResult;
    }
    
}