<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPermissionApvDoc extends CI_Model {
    
    //Functionality : list Data PermissionApvDoc
    //Parameters : function parameters
    //Creator :  17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMPADListData($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID  = $paData['FNLngID'];
        $tSearchList = $paData['tSearchAll'];
        $tSQL    = "SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER( ORDER BY rtDapTable ASC) AS FNRowID, 
                            *
                    FROM
                    (
                        SELECT  DAP.*, 
                                DT.FTSdtDocName AS rtSdtDocName
                        FROM
                        (
                            SELECT DISTINCT 
                                FTDapTable   AS rtDapTable, 
                                FTDapRefType AS rtDapRefType
                            FROM TSysDocApv
                            where FNDapStaUse ='1' 
                        ) DAP
                        LEFT JOIN TSysDocType DT ON DAP.rtDapTable = DT.FTSdtTblName
                        AND DAP.rtDapRefType = DT.FNSdtDocType
                    
            ";
        if($tSearchList != ''){
            $tSQL .= "WHERE DT.FTSdtDocName COLLATE THAI_BIN LIKE '%$tSearchList%'"; 
        }
        $tSQL .= " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        // echo $tSQL;exit;
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMPADGetPageAll($tSearchList);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : All Page Of PermissionApvDoc
    //Parameters : function parameters
    //Creator :  17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMPADGetPageAll($ptSearchList){
        $tSQL = "SELECT  COUNT (DAP.rtDapTable) AS counts
                        FROM
                        (
                            SELECT DISTINCT 
                                FTDapTable   AS rtDapTable, 
                                FTDapRefType AS rtDapRefType
                            FROM TSysDocApv
                        ) DAP
                        LEFT JOIN TSysDocType DT ON DAP.rtDapTable = DT.FTSdtTblName
                        AND DAP.rtDapRefType = DT.FNSdtDocType
                 ";
        if(@$tSearchList != ''){
            $tSQL .= " AND (DT.FTSdtTblName COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : Search PermissionApvDoc By ID
    //Parameters : function parameters
    //Creator 17/02/2020 Saharat(Golf)
    //Last Modified : 05/10/2020 Napat(Jame) เปลี่ยนฟิวส์ จาก FTDapCode -> FNDapID
    //Return : data
    //Return Type : Array
    public function FSaMPADSearchByID($paData){

        $tDapTable       = $paData['FTDapTable'];
        $tDapRefType     = $paData['FTDapRefType'];
        $tFNLngID        = $paData['FNLngID'];
    
        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID  = $paData['FNLngID'];

        $tSQLMainSel = " SELECT
                            DAP.FNDapID,
                            DAP.FTDapName,
                            DAP.FNDapSeq,
                            DAP.FTDapRefType,
                            DAP.FTDapUsrRoleGrp,
                            DAP.FTDapTable,
                            DAR.FTDarUsrRole,
                            TRL.FTRolName,
                            DAR.FTDarStaColor 
                        ";
        $tSQLCountSel = " SELECT COUNT(DAP.FNDapID) AS counts ";
        $tSQLMain = "   FROM TSysDocApv DAP
                        LEFT JOIN TCNMDocApvRole DAR ON DAP.FTDapTable = DAR.FTDarTable 
                            AND DAP.FTDapRefType = DAR.FTDarRefType 
                            AND DAP.FNDapSeq = DAR.FNDarApvSeq  
                        LEFT JOIN TCNMUsrRole_L TRL ON DAR.FTDarUsrRole = TRL.FTRolCode  
                            AND TRL.FNLngID = '$tFNLngID'
                        WHERE 1=1
                        AND DAP.FTDapTable    = '$tDapTable'
                        AND DAP.FTDapRefType  = '$tDapRefType'
                        AND DAP.FNDapStaUse   = '1'
                    ";
        $tSQL    = " SELECT c.* FROM( SELECT ROW_NUMBER() OVER( ORDER BY FNDapSeq ASC) AS FNRowID, * FROM ( ";
        $tSQLEnd = " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";

        $tStageMentMain = $tSQL . $tSQLMainSel . $tSQLMain . $tSQLEnd;
        $oQuery = $this->db->query($tStageMentMain);

        $tStageMentCount = $tSQLCountSel . $tSQLMain;
        $oQueryCount = $this->db->query($tStageMentCount);

        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            // $aFoundRow = $this->FSnMPADGetPageGetID($paData);
            $nFoundRow = $oQueryCount->result()[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 1,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;


    }

     //Functionality : All Page Of PermissionApvDoc
    //Parameters : function parameters
    //Creator :  12/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMPADGetPageGetID($paData){

        $tDapTable       = $paData['FTDapTable'];
        $tDapRefType     = $paData['FTDapRefType'];

        $tSQL = "SELECT  COUNT (DAP.FNDapSeq) AS counts
            FROM TSysDocApv DAP
            LEFT JOIN TCNMDocApvRole DAR ON DAP.FTDapTable = DAR.FTDarTable AND DAP.FTDapRefType = DAR.FTDarRefType 
            AND DAP.FNDapSeq = DAR.FNDarApvSeq 
            WHERE 1=1
            AND DAP.FTDapTable    = '$tDapTable'
            AND DAP.FTDapRefType  = '$tDapRefType' ";
    
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }
    
    //Functionality : Update / Add TCNMDocApvRole
    //Parameters : function parameters
    //Creator : 17/02/2020 Saharat(Golf)
    //Last Modified : 06/10/2020 Napat(Jame) เปลี่ยน flow จาก delete insert เป็น update insert
    //Return : response
    //Return Type : Array
    public function FSaMPADAddUpdateMaster($paDetailItems,$paData){ /*FTDarCode '".$aValue['tCode']."',*/
        try{
            if(isset($paDetailItems) && !empty($paDetailItems)){

                // $this->db->where('FTDarTable', $paData['FTDarTable']);
                // $this->db->delete('TCNMDocApvRole');

                // Loop Add/Update 
                foreach($paDetailItems AS $nKey => $aValue){
                    $tColor = str_replace('#','',$aValue['tColorCode']);

                    // Update Master
                    $this->db->set('FTDarUsrRole', $aValue['tUserrole']);
                    $this->db->set('FTDarStaColor', $tColor);
                    $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                    $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                    $this->db->where('FTDarTable', $aValue['tTable']);
                    $this->db->where('FNDarApvSeq', $aValue['tDapSeq']);
                    $this->db->update('TCNMDocApvRole');
                    if($this->db->affected_rows() == 0){
                        // Insert Master
                        $this->db->insert('TCNMDocApvRole', array(
                            'FTDarTable'        => $aValue['tTable'],
                            'FTDarRefType'      => $aValue['tType'],
                            'FNDarApvSeq'       => $aValue['tDapSeq'],
                            'FTDarUsrRole'      => $aValue['tUserrole'],
                            'FTDarStaColor'     => $tColor,
                            'FDLastUpdOn'       => $paData['FDLastUpdOn'],
                            'FTLastUpdBy'       => $paData['FTLastUpdBy'],
                            'FDCreateOn'        => $paData['FDCreateOn'],
                            'FTCreateBy'        => $paData['FTCreateBy'],
                        ));
                    }
                }

            }
        }catch(Exception $Error){
            return $Error;
        }
        
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
