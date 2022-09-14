<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPosRegister extends CI_Model {
    
    //Get App Type เอาไปไว้ใน Option
    // Create By Witsarut 14/07/2020
    public function FSaMPRGGetStaApp(){
        $tSQL = "SELECT DISTINCT FTPrgStaApv FROM TPSTPosReg";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
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
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    // Function Get Data Table TPSTPosReg
    // Create By Witsarut 14/07/2020
    public function FSaMPRGDataTable($paData){

        $tWhere = "";

        if(!empty($paData['tStaUsrLevel']) && $paData['tStaUsrLevel'] != "HQ"){
            if(!empty($paData['tUsrBchCode'])){
                $tUsrBchCode = $paData['tUsrBchCode'];
                $tWhere .=  " AND PRG.FTBchCode IN ($tUsrBchCode) ";
            }
        }

        $nLngID  = $paData['FNLngID'];
        $tSQL  = "SELECT
                    PRG.FTBchCode,
                    PRG.FTPosCode,
                    PRG.FTPrgMacAddr,
                    PRG.FTPrgStaApv,
                    PRG.FDPrgDate,
                    -- CONVERT(VARCHAR(15), PRG.FDPrgDate, 111) AS FDPrgDate,
                    CONVERT(VARCHAR(15), PRG.FDPrgExpire, 111) AS FDPrgExpire,
                    PRG.FTPrgUsrApv,
                    BCH_L.FTBchName,
                    POS_L.FTPosName,
                    USR_L.FTUsrName
                FROM [TPSTPosReg] PRG  WITH(NOLOCK)
                LEFT JOIN TCNMBranch_L BCH_L WITH(NOLOCK) ON PRG.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                LEFT JOIN TCNMPos_L POS_L WITH(NOLOCK) ON PRG.FTPosCode = POS_L.FTPosCode AND  POS_L.FTBchCode = PRG.FTBchCode AND POS_L.FNLngID = $nLngID
                LEFT JOIN TCNMUser_L USR_L WITH(NOLOCK) ON PRG.FTPrgUsrApv = USR_L.FTUsrCode AND USR_L.FNLngID = $nLngID
                WHERE 1=1 
                $tWhere ";

        $tSearchList    = trim($paData['tSearchAll']);
        $tStaApv        = $paData['tStaApv'];

        
        switch($tStaApv) {
            case "1":
                $tConcatSQL = "AND PRG.FTPrgStaApv = '1'";
            break;
            case "2":
                $tConcatSQL = "AND PRG.FTPrgStaApv = '2'";
            break;
            case "3":
                $tConcatSQL = "AND PRG.FTPrgStaApv = '3'";
            break;
            default:
                $tConcatSQL = "";
        }
        $tSQL .= " $tConcatSQL ";
        if($tSearchList != ''){
            if($tSearchList == 'อนุมัติแล้ว'){
                $tSQL .= "AND (PRG.FTPrgStaApv = 1) ";
            }else if($tSearchList == 'ยังไม่อนุมัติ'){
                $tSQL .= "AND (PRG.FTPrgStaApv = 2) ";
            }else if($tSearchList == 'ยกเลิก'){
                $tSQL .= "AND (PRG.FTPrgStaApv = 3) ";
            }else{
                $tSQL .= " AND (BCH_L.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= "      OR PRG.FTPosCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= "      OR PRG.FTPrgMacAddr COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= "      OR USR_L.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= "      OR POS_L.FTPosName COLLATE THAI_BIN LIKE '%$tSearchList%')";
            }
        }
        $tSQL   .= " ORDER BY PRG.FTPrgStaApv ASC";
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
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
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    // function Loop insert TPSTPosReg
    //Create Witsarut 15/07/2020
    public function FSaMPRGAddUpdateMaster($paData, $paMacAddr, $paEncPassword, $paBchCode, $paPosCode, $paPrgDate){
        try{
            $this->db->set('FTPrgRegToken', $paEncPassword);
            $this->db->set('FTPrgUsrApv', $paData['FTPrgUsrApv']);
            $this->db->set('FTPrgStaApv', $paData['FTPrgStaApv']);
            $this->db->set('FDPrgExpire', $paData['FDPrgExpire']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FDCreateOn', $paData['FDCreateOn']);
            $this->db->set('FTCreateBy', $paData['FTCreateBy']);
            $this->db->where('FDPrgDate', $paPrgDate);
            $this->db->where('FTPrgMacAddr', $paMacAddr);
            $this->db->where('FTBchCode', $paBchCode);
            $this->db->where('FTPosCode', $paPosCode);
            $this->db->update('TPSTPosReg');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'UnSuccess.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(exception $Error){
            return $Error;
        }
    }

    // function Loop insert TPSTPosReg
    //Create Witsarut 15/07/2020
    public function FSaMPRGAddUpdateMasterPOS($paData, $paPosCode, $paEncPassword, $paBchCode){
        try{
            $this->db->set('FTPrgRegToken', $paEncPassword);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->where('FTPosCode', $paPosCode);
            $this->db->where('FTBchCode', $paBchCode);
            $this->db->update('TCNMPos');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'UnSuccess.',
                    );
                }
                $jStatus = json_encode($aStatus);
                $aStatus = json_decode($jStatus, true);
                return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    // function insert TPSTPosReg for Sta type 3 (Cancel)
    // Create By Witsarut 16/07/2020
    public function FSaMPRGCancelUpdateMaster($paData, $paMacAddr, $paEncPassword, $paBchCode, $paPosCode){
        try{
            $this->db->set('FTPrgRegToken', $paEncPassword);
            $this->db->set('FTPrgUsrApv', $paData['FTPrgUsrApv']);
            $this->db->set('FTPrgStaApv', $paData['FTPrgStaApv']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FDCreateOn', $paData['FDCreateOn']);
            $this->db->set('FTCreateBy', $paData['FTCreateBy']);
            $this->db->where('FTPrgMacAddr', $paMacAddr);
            $this->db->where('FTBchCode', $paBchCode);
            $this->db->where('FTPosCode', $paPosCode);
            $this->db->update('TPSTPosReg');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'UnSuccess.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    // function insert TPSTPosReg for Sta type 3 (Cancel) ไป Delete Feild FTPrgRegToken ของ TCNMPOS ให้เป็นค่าว่าง
    // Create By Witsarut 16/07/2020
    public function FSaMPRGCancelUpdateMasterPOS($paData, $paPosCode, $paEncPassword, $paBchCode){
        try{    
          $this->db->set('FTPrgRegToken', $paEncPassword);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->where('FTPosCode', $paPosCode);
            $this->db->where('FTBchCode', $paBchCode);
            $this->db->update('TCNMPos');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'UnSuccess.',
                    );
                }
                $jStatus = json_encode($aStatus);
                $aStatus = json_decode($jStatus, true);
                return $aStatus;

        }catch(Exception $Error){
            return $Error;
        }
    }


}