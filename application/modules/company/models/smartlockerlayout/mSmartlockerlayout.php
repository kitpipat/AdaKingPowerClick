<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSmartlockerlayout extends CI_Model {

    //Get Date
    public function FSaMSMLDataList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FTShpCode ASC) AS rtRowID,* FROM
                                    (SELECT 
                                        SML.FTBchCode,
                                        SML.FTShpCode,
                                        SML.FNLayNo,
                                        SML.FNLayScaleX,
                                        SML.FNLayScaleY,
                                        SML.FNLayRow,
                                        SML.FNLayCol,
                                        SML.FTPzeCode,
                                        SML.FTRakCode,
                                        SML.FTLayStaUse,
                                        SML_L.FTLayName,
                                        SML_L.FTLayRemark,
                                        BCH_L.FTBchName,
                                        RACK_L.FTRakName,
                                        SHP_L.FTSizName
                                    FROM [TRTMShopLayout] SML
                                    LEFT JOIN [TRTMShopLayout_L] SML_L ON SML.FTShpCode = SML_L.FTShpCode AND SML.FNLayNo = SML_L.FNLayNo AND SML.FTBchCode = SML_L.FTBchCode AND SML_L.FNLngID = '$tFNLngID'
                                    LEFT JOIN [TCNMBranch_L] BCH_L ON SML.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = '$tFNLngID'
                                    LEFT JOIN [TRTMShopRack_L] RACK_L ON SML.FTRakCode = RACK_L.FTRakCode AND RACK_L.FNLngID = '$tFNLngID'
                                    LEFT JOIN [TRTMShopSize_L] SHP_L ON SML.FTPzeCode = SHP_L.FTSizCode AND SHP_L.FNLngID = '$tFNLngID'
                                    WHERE 1=1 ";

            if(empty($tSearchList)){
                $tGroup          = ''; 
                $tLayoutColumn   = ''; 
                $tFloor          = ''; 
                $tColumn         = ''; 
            }else{
                $tGroup          = $tSearchList[0][0]; 
                $tLayoutColumn   = $tSearchList[0][1]; 
                $tFloor          = $tSearchList[0][2]; 
                $tColumn         = $tSearchList[0][3]; 
            }

            if($tGroup != ''){
                $tSQL .= " AND (RACK_L.FTRakCode = '$tGroup')";
            }

            if($tLayoutColumn != ''){
                $tSQL .= " AND (SML.FNLayNo = '$tLayoutColumn')";
            }

            if($tFloor != ''){
                $tSQL .= " AND (SML.FNLayRow = '$tFloor')";
            }

            if($tColumn != ''){
                $tSQL .= " AND (SML.FNLayCol = '$tColumn')";
            }

            $tFTShpCode = $paData['FTShpCode'];
            $tFTBchCode = $paData['FTBchCode'];
            $tSQL .= " AND (SML.FTBchCode IN ($tFTBchCode) AND SML.FTShpCode = '$tFTShpCode')";

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMSMLGetPageAll($tSearchList,$paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'tSQL'          => $tSQL
                );
            }else{
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
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Get Group : For [option select] search list page
    public function FSaMSMLGetGroup($tBchCode,$tShpCode,$tLang){
        $tSQL   = " SELECT distinct  SML.FTRakCode , RACK_L.FTRakName  FROM TRTMShopLayout SML
                    LEFT JOIN TRTMShopRack_L RACK_L ON SML.FTRakCode = RACK_L.FTRakCode AND RACK_L.FNLngID = '$tLang' 
                    WHERE 1=1 AND SML.FTBchCode IN ($tBchCode)
                            AND SML.FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn        = array(
                'aList'         => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'Pass',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Notfound',
            );
        }
        return $aDataReturn;
    }

    //Get Column : For [option select] search list page
    public function FSaMSMLGetColumn($tBchCode,$tShpCode){
        $tSQL   = " SELECT distinct FNLayNo FROM TRTMShopLayout  
                    WHERE 1=1 AND FTBchCode IN ($tBchCode)
                            AND FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn        = array(
                'aList'         => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'Pass',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Notfound',
            );
        }
        return $aDataReturn;
    }

    //Count 
    public function FSoMSMLGetPageAll($ptSearchList,$paData){
        try{
            $tFNLngID = $paData['FNLngID'];
            $tSQL = "SELECT COUNT (SML.FNLayNo) AS counts
                    FROM [TRTMShopLayout] SML
                    LEFT JOIN [TRTMShopLayout_L] SML_L ON SML.FTShpCode = SML_L.FTShpCode AND SML.FNLayNo = SML_L.FNLayNo AND SML.FTBchCode = SML_L.FTBchCode AND SML_L.FNLngID = '$tFNLngID'
                    LEFT JOIN [TCNMBranch_L] BCH_L ON SML.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = '$tFNLngID'
                    LEFT JOIN [TRTMShopRack_L] RACK_L ON SML.FTRakCode = RACK_L.FTRakCode AND RACK_L.FNLngID = '$tFNLngID'
                    LEFT JOIN [TRTMShopSize_L] SHP_L ON SML.FTPzeCode = SHP_L.FTSizCode AND SHP_L.FNLngID = '$tFNLngID'
                    WHERE 1=1 ";

            $tFTShpCode = $paData['FTShpCode'];
            $tFTBchCode = $paData['FTBchCode'];
            $tSQL .= " AND (SML.FTBchCode IN ($tFTBchCode) AND SML.FTShpCode = '$tFTShpCode')";

            if(empty($ptSearchList)){
                $tGroup          = ''; 
                $tLayoutColumn   = ''; 
                $tFloor          = ''; 
                $tColumn         = ''; 
            }else{
                $tGroup          = $ptSearchList[0][0]; 
                $tLayoutColumn   = $ptSearchList[0][1]; 
                $tFloor          = $ptSearchList[0][2]; 
                $tColumn         = $ptSearchList[0][3]; 
            }

            if($tGroup != ''){
                $tSQL .= " AND (RACK_L.FTRakCode = '$tGroup')";
            }

            if($tLayoutColumn != ''){
                $tSQL .= " AND (SML.FNLayNo = '$tLayoutColumn')";
            }

            if($tFloor != ''){
                $tSQL .= " AND (SML.FNLayRow = '$tFloor')";
            }

            if($tColumn != ''){
                $tSQL .= " AND (SML.FNLayCol = '$tColumn')";
            }

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Check Layno ห้ามค่าซ้ำ
    public function FSaMSMLCheckLayout($paData){
        $tFTBchCode = $paData['FTBchCode'];
        $tFTShpCode = $paData['FTShpCode']; 
        $tFNLayNo   = $paData['FNLayNo']; 

        $tSQL   = " SELECT FNLayNo FROM TRTMShopLayout  
                    WHERE 1=1  AND FTBchCode = '$tFTBchCode' 
                               AND FTShpCode = '$tFTShpCode'
                               AND FNLayNo = '$tFNLayNo' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn        = array(
                'rtCode'        => '800',
                'rtDesc'        => 'Duplicate',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '1',
                'rtDesc'        => 'Pass',
            );
        }
        return $aDataReturn;
    }

    //Check Floor and column ห้ามซ้ำ
    public function FSaMSMLCheckColumnANDFloor($paData,$paWhere){
        $tFTBchCode     = $paData['FTBchCode'];
        $tFTShpCode     = $paData['FTShpCode']; 
        $tFTRakCode     = $paData['FTRakCode']; 
        $tFNLayRow      = $paData['FNLayRow']; 
        $tFNLayCol      = $paData['FNLayCol'];

        if($paWhere == 'ADD'){
            $tWhereSQL = '';
        }else{
            if(isset($paWhere)){
                $tFNLayNo    = $paWhere['FNLayNoOld'];
                $tWhereSQL   = " AND FNLayNo != '$tFNLayNo' ";
            }else{
                $tWhereSQL = '';
            }
        }

        $tSQL   = " SELECT FTRakCode FROM TRTMShopLayout  
                    WHERE 1=1  AND FTBchCode = '$tFTBchCode' 
                               AND FTShpCode = '$tFTShpCode'
                               AND FTRakCode = '$tFTRakCode'
                               AND FNLayRow = '$tFNLayRow'
                               AND FNLayCol = '$tFNLayCol' ";
        $tSQL   .= $tWhereSQL;
                            
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn        = array(
                'rtCode'        => '800',
                'rtDesc'        => 'Duplicate',
            );
        }else{
            $aDataReturn        =  array(
                'rtCode'        => '1',
                'rtDesc'        => 'Pass',
            );
        }
        return $aDataReturn;
    }

    //Insert 
    public function FSaMSMLInsertLayout($paData){

        $tSesUserLevel  = $this->session->userdata("tSesUsrLevel"); 
        $tShopGetMer    = $paData['FTShpCode'];
        $tBchGetMer     = $paData['FTBchCode'];
        $tGetMerSQL     = " SELECT FTMerCode FROM TCNMShop  
                                WHERE 1=1
                                AND FTShpCode = '$tShopGetMer' ";
        $oGetMerQuery   = $this->db->query($tGetMerSQL);
        if($oGetMerQuery->num_rows() > 0) {
            $tMercode       = $oGetMerQuery->result_array();
            $tMercode       = $tMercode[0]['FTMerCode'];
        }else{
            $tMercode       = '000';
        }

        $this->db->insert('TRTMShopLayout', array(
            'FTBchCode'     => $paData['FTBchCode'],
            'FTMerCode'     => $tMercode,
            'FTShpCode'     => $paData['FTShpCode'],
            'FNLayNo'       => $paData['FNLayNo'],
            'FNLayScaleX'   => $paData['FNLayScaleX'],
            'FNLayScaleY'   => $paData['FNLayScaleY'],
            'FNLayRow'      => $paData['FNLayRow'],
            'FNLayCol'      => $paData['FNLayCol'],
            'FTPzeCode'     => $paData['FTPzeCode'],
            'FTRakCode'     => $paData['FTRakCode'],
            'FTLayStaUse'   => $paData['FTLayStaUse'],    
            'FDLastUpdOn'	=> $paData['FDCreateOn'],  
            'FTLastUpdBy'	=> $paData['FTCreateBy'],  
            'FDCreateOn'    => $paData['FDCreateOn'], 
            'FTCreateBy'    => $paData['FTCreateBy']
        ));

        $this->db->insert('TRTMShopLayout_L', array(
            'FTBchCode'      => $paData['FTBchCode'],
            'FTShpCode'      => $paData['FTShpCode'],
            'FNLayNo'        => $paData['FNLayNo'],
            'FNLngID'        => $paData['FNLngID'],
            'FTLayName'      => $paData['FTLayName'],
            'FTLayRemark'    => $paData['FTLayRemark']
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

    //Delete
    public function FSaMSMLDelete($paData){

        $ptBch      = $paData['FTBchCode'];
        $ptShp      = $paData['FTShpCode'];
        $ptLayno    = $paData['FNLayNo'];

        $tSQLLayout =	"DELETE FROM TRTMShopLayout
                        WHERE FNLayNo = '".$ptLayno."' 
                        AND FTBchCode = '".$ptBch."'
                        AND FTShpCode = '".$ptShp."' ";

        $tSQLLayoutL =	"DELETE FROM TRTMShopLayout_L
                        WHERE FNLayNo = '".$ptLayno."' 
                        AND FTBchCode = '".$ptBch."'
                        AND FTShpCode = '".$ptShp."' ";

        $oQuery = $this->db->query($tSQLLayout);
        $oQuery = $this->db->query($tSQLLayoutL);
    }

    //Update
    public function FSaMSMLUpdateLayout($paData,$paDataWhere){
        //Update Master
        $this->db->set('FTBchCode', $paData['FTBchCode']);
        $this->db->set('FTShpCode', $paData['FTShpCode']);
        $this->db->set('FNLayNo', $paData['FNLayNo']);
        $this->db->set('FNLayScaleX', $paData['FNLayScaleX']);
        $this->db->set('FNLayScaleY', $paData['FNLayScaleY']);
        $this->db->set('FNLayRow', $paData['FNLayRow']);
        $this->db->set('FNLayCol', $paData['FNLayCol']);
        $this->db->set('FTPzeCode', $paData['FTPzeCode']);
        $this->db->set('FTRakCode', $paData['FTRakCode']);
        $this->db->set('FTLayStaUse', $paData['FTLayStaUse']);
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        $this->db->where('FTBchCode', $paDataWhere['FTBchCodeOld']);
        $this->db->where('FTShpCode', $paDataWhere['FTShpCodeOld']);
        $this->db->where('FNLayNo', $paDataWhere['FNLayNoOld']);
        $this->db->update('TRTMShopLayout');

        //Update Lang
        $this->db->set('FTBchCode', $paData['FTBchCode']);
        $this->db->set('FTShpCode', $paData['FTShpCode']);
        $this->db->set('FNLayNo', $paData['FNLayNo']);
        $this->db->set('FNLngID', $paData['FNLngID']);
        $this->db->set('FTLayName', $paData['FTLayName']);
        $this->db->set('FTLayRemark', $paData['FTLayRemark']);
        $this->db->where('FTBchCode', $paDataWhere['FTBchCodeOld']);
        $this->db->where('FTShpCode', $paDataWhere['FTShpCodeOld']);
        $this->db->where('FNLayNo', $paDataWhere['FNLayNoOld']);
        $this->db->update('TRTMShopLayout_L');
        if($this->db->affected_rows() > 0 ){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '800',
                'rtDesc' => 'fail',
            );
        }

        return $aStatus;
    }

   
}