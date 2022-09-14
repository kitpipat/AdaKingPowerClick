<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mShopGpByPdt  extends CI_Model {
    
    //function select list
    public function FSaMShopGpByProductDataList($paData){
        $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tFTBchCode     = $paData['FTBchCode'];
        $tFTShpCode     = $paData['FTShpCode'];
        $tFDSgpStart    = $paData['tSearchAll'];
        $nLngID         = $paData['FNLngID'];

        $tSQL           = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTShpCode ASC) AS FNRowID,* FROM
                            (SELECT distinct
                                SHP.FTBchCode,
                                SHP.FTShpCode,
                                SHPL.FTShpName,
                                BCHL.FTBchName,
                                SHP.FDSgpStart,
                                SHP.FNSgpSeq
                            FROM [TCNMShopGP] SHP ";
        $tSQL .= " LEFT JOIN [TCNMShop_L] SHPL ON SHPL.FTShpCode = SHP.FTShpCode AND SHPL.FTBchCode = SHP.FTBchCode AND SHPL.FNLngID = '$nLngID'  ";   
        $tSQL .= " LEFT JOIN [TCNMBranch_L] BCHL ON BCHL.FTBchCode = SHP.FTBchCode AND BCHL.FNLngID = '$nLngID'
                   WHERE 1=1 AND SHP.FTPdtCode != '' AND SHP.FTPdtCode != '*' ";

        //Get BCH 
        $tSesUserLevel        = $this->session->userdata("tSesUsrLevel");
        if($tSesUserLevel == 'HQ'){
            $tSQL .= "AND SHP.FTShpCode = '$tFTShpCode' ";
        }else{
            $tSQL .= "AND SHP.FTBchCode = '$tFTBchCode' AND SHP.FTShpCode = '$tFTShpCode' ";
        }

        if($tFDSgpStart != ''){ 
            $tSQL .= "  AND CONVERT(varchar(10), SHP.FDSgpStart,121) = '$tFDSgpStart' ";
        }else{
            $tSQL .= "";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMShopGpByProductGetPageAll($tFTBchCode,$tFTShpCode,$tFDSgpStart);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => $nPageAll, 
                'rtCode'        => '1',
                'rtDesc'        => 'success',
                'tSQL'          => $tSQL
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;
    }

    //function get page 
    public function FSnMShopGpByProductGetPageAll($tFTBchCode,$tFTShpCode,$tFDSgpStart){
        $tSQL   = " SELECT COUNT (A.FTShpCode) AS counts FROM(

                        SELECT DISTINCT SHP.FTShpCode,SHP.FTBchCode,SHP.FDSgpStart
                        FROM TCNMShopGP SHP 
                        WHERE 1=1 AND SHP.FTPdtCode != '' AND SHP.FTPdtCode != '*' ";

        //Get BCH 
        $tSesUserLevel        = $this->session->userdata("tSesUsrLevel");
        if($tSesUserLevel == 'HQ'){
            $tSQL .= "AND SHP.FTShpCode = '$tFTShpCode' ";
        }else{
            $tSQL .= "AND SHP.FTBchCode = '$tFTBchCode' AND SHP.FTShpCode = '$tFTShpCode' ";
        }

        if($tFDSgpStart != ''){ 
            $tSQL .= "  AND CONVERT(varchar(10), SHP.FDSgpStart,121) = '$tFDSgpStart' ";
        }else{
            $tSQL .= "";
        }

        $tSQL .= ") as A";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aDataReturn        =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        return $aDataReturn;
    }

    //function select DT
    public function FSaMShopGpBySelectDataDT($paData,$ptTypeCheck){
        $tFTShpCode     = $paData['FTShpCode'];
        $tFTBchCode     = $paData['FTBchCode'];

        if($ptTypeCheck == 'shop'){
            $tSQL   = "SELECT TOP 1 SHPL.FTShpName FROM TCNMShop_L SHPL WHERE SHPL.FTShpCode = '$tFTShpCode' AND SHPL.FTBchCode = '$tFTBchCode' ";
        }else if($ptTypeCheck == 'branch'){
            $tSQL   = "SELECT TOP 1 BCHL.FTBchCode,BCHL.FTBchName FROM TCNMBranch_L BCHL WHERE BCHL.FTBchCode = '$tFTBchCode'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aDataReturn        = array(
                'raItems'       => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        return $aDataReturn;
    }

    //function get Product
    public function FSaMShopGpSelectPDT($paData){
        $tFTBchCode     = $paData['FTBchCode'];
        $tFTShpCode     = $paData['FTShpCode'];
        $tFDSgpStart    = $paData['FDSgpStart'];
        $nLngID         = $paData['FNLngID'];
        $FNSgpSeq       = $paData['FNSgpSeq'];
        $tSQL = "SELECT 
                    SHP.FTBchCode,
                    SHP.FTShpCode,
                    SHPL.FTShpName,
                    PDTL.FTPdtName,
                    BCHL.FTBchName,
                    CONVERT(varchar(10), SHP.FDSgpStart,121) as FDSgpStart,
                    SHP.FTPdtCode,
                    SHP.FCSgpPerAvg,
                    SHP.FCSgpPerSun,
                    SHP.FCSgpPerMon,
                    SHP.FCSgpPerTue,
                    SHP.FCSgpPerWed,
                    SHP.FCSgpPerThu,
                    SHP.FCSgpPerFri, 
                    SHP.FCSgpPerSat,
                    SHP.FNSgpSeq
                FROM [TCNMShopGP] SHP
                LEFT JOIN [TCNMPdt_L] PDTL ON PDTL.FTPdtCode = SHP.FTPdtCode AND PDTL.FNLngID = '$nLngID'";
        $tSQL .= " LEFT JOIN [TCNMShop_L] SHPL ON SHPL.FTShpCode = SHP.FTShpCode AND SHPL.FTBchCode = SHP.FTBchCode AND SHPL.FNLngID = '$nLngID'  ";   
        $tSQL .= " LEFT JOIN [TCNMBranch_L] BCHL ON BCHL.FTBchCode = SHP.FTBchCode AND BCHL.FNLngID = '$nLngID'
                WHERE 1=1 AND SHP.FTPdtCode != '' AND SHP.FTPdtCode != '*' ";
        $tSQL .= " AND SHP.FTBchCode = '$tFTBchCode' AND SHP.FTShpCode = '$tFTShpCode' AND SHP.FNSgpSeq = '$FNSgpSeq' ";
        $tSQL .= " AND CONVERT(varchar(10), SHP.FDSgpStart,121) = '$tFDSgpStart' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail            = $oQuery->result_array();
            $aDataReturn        = array(
                'raItems'       => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        return $aDataReturn;
    }

    //Check date ห้ามชนกัน
    public function FSaMShopGpByPDTCheckDate($ptDate,$ptFTBchCode,$ptFTShpCode){
        $tSQL   = "SELECT TOP 1 FDSgpStart FROM TCNMShopGP WHERE CONVERT(varchar(10), FDSgpStart,121) = '$ptDate' 
                    AND FTBchCode = '$ptFTBchCode' AND FTShpCode = '$ptFTShpCode'  ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn        = array(
                'rtDesc'        => 'found'
            );
        }else{
            $aDataReturn        =  array(
                'rtDesc'        => 'data not found'
            );
        }
        return $aDataReturn;
    }

    //Event Insert PDT
    public function FSaMShopGpByPDTInsert($paData){
        $this->db->insert('TCNMShopGP', array(
            'FTBchCode'     => $paData['FTBchCode'],
            'FTShpCode'     => $paData['FTShpCode'],
            'FDSgpStart'    => $paData['FDSgpStart'],
            'FTPdtCode'     => $paData['FTPdtCode'],
            'FNSgpSeq'      => $paData['FNSgpSeq'],
            'FCSgpPerAvg'   => $paData['FCSgpPerAvg'],
            'FCSgpPerSun'   => $paData['FCSgpPerSun'],
            'FCSgpPerMon'   => $paData['FCSgpPerMon'],
            'FCSgpPerTue'   => $paData['FCSgpPerTue'],
            'FCSgpPerWed'   => $paData['FCSgpPerWed'],
            'FCSgpPerThu'   => $paData['FCSgpPerThu'],
            'FCSgpPerFri'   => $paData['FCSgpPerFri'],
            'FCSgpPerSat'   => $paData['FCSgpPerSat']
        ));

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Master Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }
        return $aStatus;
    }

    //Delete Product old
    public function FSaMShopGpByDeleteGPOld($ptDateOld,$ptFTBchCode,$ptFTShpCode,$ptFNSgpSeq){
        $tSQL =	"DELETE FROM TCNMShopGP
                WHERE CONVERT(varchar(10), FDSgpStart,121) = '".$ptDateOld."' 
                AND FTBchCode = '".$ptFTBchCode."'
                AND FTShpCode = '".$ptFTShpCode."' 
                AND FNSgpSeq = '".$ptFNSgpSeq."' ";
        $oQuery = $this->db->query($tSQL);
    }

    //Event Insert GP ตามวัน Temp
    public function FSaMShopGpByPDTInsertGPWeek($paData){

        $tFTBchCode         = $paData['FTBchCode'];
        $tFTShpCode         = $paData['FTShpCode'];
        $tFDSgpStart        = $paData['FDSgpStart'];
        $tFTPdtCode         = $paData['FTPdtCode'];
        $tFTMttSessionID    = $paData['FTMttSessionID'];
        $tFTMttTableKey     = $paData['FTMttTableKey'];
        $tFTMttRefKey       = $paData['FTMttRefKey'];

        $tSQL   = " SELECT FTPdtCode,FTBchCode,FTShpCode FROM TsysMasTmp  
                    WHERE 1=1   AND FTBchCode = '$tFTBchCode' 
                                AND FTShpCode = '$tFTShpCode'
                                AND CONVERT(varchar(10), FDSgpStart,121) = '$tFDSgpStart'
                                AND FTPdtCode = '$tFTPdtCode'
                                AND FTMttSessionID = '$tFTMttSessionID'
                                AND FTMttTableKey = '$tFTMttTableKey'
                                AND FTMttRefKey = '$tFTMttRefKey' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $tFCSgpPerMon = ($paData['FCSgpPerMon']  == '' ? '0.00' : $paData['FCSgpPerMon']); 
            $tFCSgpPerTue = ($paData['FCSgpPerTue']  == '' ? '0.00' : $paData['FCSgpPerTue']); 
            $tFCSgpPerWed = ($paData['FCSgpPerWed']  == '' ? '0.00' : $paData['FCSgpPerWed']);  
            $tFCSgpPerThu = ($paData['FCSgpPerThu']  == '' ? '0.00' : $paData['FCSgpPerThu']);  
            $tFCSgpPerFri = ($paData['FCSgpPerFri']  == '' ? '0.00' : $paData['FCSgpPerFri']); 
            $tFCSgpPerSat = ($paData['FCSgpPerSat']  == '' ? '0.00' : $paData['FCSgpPerSat']);
            $tFCSgpPerSun = ($paData['FCSgpPerSun']  == '' ? '0.00' : $paData['FCSgpPerSun']); 

            $tSQLUpdate = "UPDATE TsysMasTmp 
                        SET FCSgpPerSun = '$tFCSgpPerSun', 
                            FCSgpPerMon = '$tFCSgpPerMon', 
                            FCSgpPerTue = '$tFCSgpPerTue', 
                            FCSgpPerWed = '$tFCSgpPerWed', 
                            FCSgpPerThu = '$tFCSgpPerThu', 
                            FCSgpPerFri = '$tFCSgpPerFri', 
                            FCSgpPerSat = '$tFCSgpPerSat' 
                        WHERE FTBchCode = '$tFTBchCode' 
                              AND FTShpCode  = '$tFTShpCode' 
                              AND CONVERT(varchar(10), FDSgpStart,121) = '$tFDSgpStart' 
                              AND FTPdtCode  = '$tFTPdtCode' 
                              AND FTMttSessionID  = '$tFTMttSessionID' 
                              AND FTMttTableKey  = '$tFTMttTableKey' 
                              AND FTMttRefKey  = '$tFTMttRefKey' ";
            $this->db->query($tSQLUpdate);
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Master Success',
            );
        }else{
            $this->db->insert('TsysMasTmp', array(
                'FTBchCode'     => $paData['FTBchCode'],
                'FTShpCode'     => $paData['FTShpCode'],
                'FTPdtCode'     => $paData['FTPdtCode'],
                'FDSgpStart'    => $paData['FDSgpStart'],
                'FCSgpPerSun'   => $paData['FCSgpPerSun'],
                'FCSgpPerMon'   => $paData['FCSgpPerMon'],
                'FCSgpPerTue'   => $paData['FCSgpPerTue'],
                'FCSgpPerWed'   => $paData['FCSgpPerWed'],
                'FCSgpPerThu'   => $paData['FCSgpPerThu'],
                'FCSgpPerFri'   => $paData['FCSgpPerFri'],
                'FCSgpPerSat'   => $paData['FCSgpPerSat'],
                'FTMttSessionID'=> $paData['FTMttSessionID'],
                'FTMttTableKey' => $paData['FTMttTableKey'],
                'FTMttRefKey'   => $paData['FTMttRefKey'],
                'FDCreateOn'    => date('Y-m-d')
            ));

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
        }

        return $aStatus;
    }

    //Event Get GP ตามวัน Temp [where product] case : กดกำหนด GP ตามรหัสสินค้า
    public function FSaMShopGpGetDataGPWeek($paData){
        $tFTBchCode     = $paData['FTBchCode'];
        $tFTShpCode     = $paData['FTShpCode'];
        $tFDSgpStart    = $paData['FDSgpStart'];
        $tFTPdtCode     = $paData['FTPdtCode'];
        $tFTMttSessionID= $paData['FTMttSessionID'];
        $tFTMttTableKey = $paData['FTMttTableKey'];
        $tFTMttRefKey   = $paData['FTMttRefKey'];

        $tSQL   = " SELECT 
                    FCSgpPerSun,
                    FCSgpPerMon,
                    FCSgpPerTue,
                    FCSgpPerWed,
                    FCSgpPerThu,
                    FCSgpPerFri,
                    FCSgpPerSat
            FROM TsysMasTmp  
            WHERE 1=1   AND FTBchCode = '$tFTBchCode' 
                        AND FTShpCode = '$tFTShpCode'
                        AND CONVERT(varchar(10), FDSgpStart,121) = '$tFDSgpStart'
                        AND FTPdtCode = '$tFTPdtCode'
                        AND FTMttSessionID = '$tFTMttSessionID'
                        AND FTMttTableKey = '$tFTMttTableKey'
                        AND FTMttRefKey = '$tFTMttRefKey' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail            = $oQuery->row_array();
            $aDataReturn        =  array(
                'raItem'        => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        return $aDataReturn;
    }

    //Event get Gp ตามวัน Temp [ไม่ where product] case : เพื่อทำการ move จาก Temp to DT
    public function FSaMShopGpBySelectTemp($paData){
        $tFTBchCode     = $paData['FTBchCode'];
        $tFTShpCode     = $paData['FTShpCode'];
        $tFDSgpStart    = $paData['FDSgpStart'];
        $tFTMttSessionID= $paData['FTMttSessionID'];
        $tFTMttTableKey = $paData['FTMttTableKey'];
        $tFTMttRefKey   = $paData['FTMttRefKey'];

        $tSQL   = " SELECT 
                    FTPdtCode,
                    FCSgpPerSun,
                    FCSgpPerMon,
                    FCSgpPerTue,
                    FCSgpPerWed,
                    FCSgpPerThu,
                    FCSgpPerFri,
                    FCSgpPerSat
            FROM TsysMasTmp  
            WHERE 1=1   AND FTBchCode = '$tFTBchCode' 
                        AND FTShpCode = '$tFTShpCode'
                        AND CONVERT(varchar(10), FDSgpStart,121) = '$tFDSgpStart'
                        AND FTMttSessionID = '$tFTMttSessionID'
                        AND FTMttTableKey = '$tFTMttTableKey'
                        AND FTMttRefKey = '$tFTMttRefKey' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail            = $oQuery->result_array();
            $aDataReturn        =  array(
                'raItem'        => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
                'rtSQL'         => $tSQL,
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        return $aDataReturn;
    }

    //Event Delete Gp ตามวัน Temp
    public function FSaMShopGpByDeleteTemp($paData){

        $tFTBchCode = $paData['FTBchCode'];
        $tFTShpCode = $paData['FTShpCode'];
        $tFTMttTableKey = $paData['FTMttTableKey'];
        $tFTMttRefKey = $paData['FTMttRefKey'];
        $tFTMttSessionID = $paData['FTMttSessionID'];

        $tSQL =	"DELETE FROM TsysMasTmp WHERE
                FTBchCode = '".$tFTBchCode."'
                AND FTShpCode = '".$tFTShpCode."'
                AND FTMttTableKey = '".$tFTMttTableKey."'
                AND FTMttRefKey = '".$tFTMttRefKey."'
                AND FTMttSessionID = '".$tFTMttSessionID."' ";
        $oQuery = $this->db->query($tSQL);

    }

    //Event Delete Temp ทุกครั้งที่เข้ามา
    public function FSxMShopGpByRemoveTemp($ptSession){
        $tSQL =	"DELETE FROM TsysMasTmp WHERE
                FTMttTableKey = 'TCNMShopGP'
                AND FTMttRefKey = 'TCNMShopGP'
                AND FTMttSessionID = '".$ptSession."' ";
        $oQuery = $this->db->query($tSQL);
    }

    //Event Move DT to Temp
    public function FSxMShopGpMoveDTToTemp($paData){

        $tFTShpCode         = $paData['FTShpCode'];
        $tFTBchCode         = $paData['FTBchCode'];
        $tFTMttSessionID    = $paData['FTMttSessionID'];
        $tFDSgpStart        = $paData['FDSgpStart'];
        $dDate              = date('Y-m-d');
        $tSql = "INSERT INTO TsysMasTmp
                (
                    FTBchCode,
                    FTShpCode,
                    FTPdtCode,
                    FDSgpStart,
                    FCSgpPerSun,
                    FCSgpPerMon,
                    FCSgpPerTue,
                    FCSgpPerWed,
                    FCSgpPerThu,
                    FCSgpPerFri,
                    FCSgpPerSat,
                    FTMttSessionID,
                    FTMttTableKey,
                    FTMttRefKey,
                    FDCreateOn         
                )
                SELECT 
                    FTBchCode,
                    FTShpCode,
                    FTPdtCode,
                    FDSgpStart,
                    FCSgpPerSun,
                    FCSgpPerMon,
                    FCSgpPerTue,
                    FCSgpPerWed,
                    FCSgpPerThu,
                    FCSgpPerFri,
                    FCSgpPerSat,
                    '$tFTMttSessionID',
                    'TCNMShopGP',
                    'TCNMShopGP',
                    '$dDate'
                FROM TCNMShopGP
                WHERE FTBchCode = '$tFTBchCode' 
                AND FTShpCode = '$tFTShpCode'
                AND CONVERT(varchar(10), FDSgpStart,121) = '$tFDSgpStart' ";
        $oQuery = $this->db->query($tSql);
    }

    //Event Delete Main List
    public function FSaMShopGpByPDTDeleteMutirecord($paData){
        $tBch   = $paData['FTBchCode'];
        $tShp   = $paData['FTShpCode'];
        $tDate  = $paData['FDSgpStart'];
        $tSeq   = $paData['FNSgpSeq'];
        $tSQL =	"DELETE FROM TCNMShopGP WHERE
                FTBchCode = '$tBch' 
                AND FTShpCode = '$tShp'
                AND FNSgpSeq = '$tSeq'
                AND CONVERT(varchar(10), FDSgpStart,121) = '$tDate' ";
        $this->db->query($tSQL);
    }

    //Find Seq in GP
    public function FSaMShopGpFindSeq($tSHP,$tBCH){
        $tSQL  = "SELECT TOP 1 FNSgpSeq FROM TCNMShopGP WHERE 1=1 ";
        $tSQL .= " AND FTShpCode = '$tSHP' AND FTBchCode = '$tBCH' ORDER BY FNSgpSeq DESC ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

}