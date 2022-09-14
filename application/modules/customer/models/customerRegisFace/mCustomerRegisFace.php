<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerRegisFace extends CI_Model {

    //เอารหัส Company
    function FSaMCstGetCompany(){
        $tSQL   = "SELECT TOP 1 FTCmpCode FROM TCNMComp";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        return $aResult;
    }

    //เอา Seq ของรูปภาพ
    function FSaMCstGetSeqImage($ptCustomerCode){
        $tSQL   = "SELECT TOP 1 FNImgSeq FROM TCNMImgObj WHERE FTImgKey = 'Face' AND FTImgRefID = '$ptCustomerCode' ORDER BY FNImgID DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        return $aResult;
    }

    //เอารูปภาพจาก ตาราง TCNMImgObj
    function FSaMCstGetImage($ptCode, $ptTable){
        
        //เช็คในตารางจริงก่อน 
        if($ptTable == 'TCNMCst'){
            $tSQL   = "SELECT * FROM TCNMCstLogin WHERE FTCstCode = '$ptCode' AND FTCstLogType = '5' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() == 0){
                $this->db->where('FTImgRefID', $ptCode);
                $this->db->where('FTImgTable', $ptTable);
                $this->db->where('FTImgKey', 'Face');
                $this->db->delete('TCNMImgObj');
            }
        }else if($ptTable == 'TCNMCrdLogin'){
            $tSQL   = "SELECT * FROM TCNMCrdLogin WHERE FTCrdCode = '$ptCode' AND FTCrdLogType = '5' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() == 0){
                $this->db->where('FTImgRefID', $ptCode);
                $this->db->where('FTImgTable', $ptTable);
                $this->db->where('FTImgKey', 'Face');
                $this->db->delete('TCNMImgObj');
            }
        }

        $tSQL   = "SELECT * FROM TCNMImgObj WHERE FTImgKey = 'Face' AND FTImgRefID = '$ptCode' AND FTImgTable = '$ptTable' ORDER BY FNImgSeq ASC";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.'
            );
        }
        return $aResult;
    }

    //ลบรูปภาพ
    function FSaMCstDeleteImage($ptCustomerCode,$pnSeq, $ptTable){

        //ลบรูปภาพ
        $this->db->where('FTImgRefID', $ptCustomerCode);
        $this->db->where('FNImgSeq', $pnSeq);
        $this->db->where('FTImgTable', $ptTable);
        $this->db->where('FTImgKey', 'Face');
        $this->db->delete('TCNMImgObj');

        //เรียง Seq ใหม่
        $tSQL   = " UPDATE TCNMImgObj WITH(ROWLOCK)
                        SET FNImgSeq = NewObj.NewSeq 
                        FROM TCNMImgObj DT 
                        INNER JOIN (
                            SELECT  ROW_NUMBER() OVER (ORDER BY FNImgSeq) AS NewSeq,
                                    FTImgTable ,
                                    FNImgSeq AS OldSeq
                            FROM TCNMImgObj 
                            WHERE 
                                FTImgTable = '$ptTable'
                            AND FTImgKey = 'Face'
                            AND FTImgRefID = '$ptCustomerCode'
                    ) NewObj ON DT.FNImgSeq = NewObj.OldSeq";
        $oQuery = $this->db->query($tSQL);
    }

    //ไปเอา Config API
    function FSaMCstGetConfigAPI($pnComCode){
        $tSQL   = "SELECT FTUrlAddress FROM TCNTUrlObject WHERE FNUrlType = '11' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        return $aResult;
    }
}
