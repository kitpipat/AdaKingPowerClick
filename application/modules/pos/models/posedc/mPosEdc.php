<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mPosEdc extends CI_Model {
    
    // Functionality : list Pos Edc
    // Parameters : Function Parameter
    // Creator :  30/08/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Data Pos Edc List
    // Return Type : Array
    public function FSaMGetDataPosEdcList($paDataWhere){
        $aRowLen        = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);
        $nLngID         = $paDataWhere['FNLngID'];
        $tSearchList    = $paDataWhere['tSearchAll'];

        $tAgnCode   = $this->session->userdata("tSesUsrAgnCode");
        $tSQL           = " SELECT c.* FROM (
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FDCreateOn DESC , FTEdcCode DESC) AS rtRowID,* FROM (
                                    SELECT DISTINCT
                                        EDC.FTEdcCode,
                                        EDC_L.FTEdcName,
                                        EDC.FTSedCode,
                                        TSEDC.FTSedModel,
                                        EDC.FTBnkCode,
                                        BNK_L.FTBnkName,
                                        EDC.FTEdcShwFont,
                                        EDC.FTEdcShwBkg,
                                        EDC.FTEdcOther,
                                        EDC.FDCreateOn
                                    FROM TFNMEdc            AS EDC      WITH(NOLOCK)
                                    LEFT JOIN TFNMEdc_L     AS EDC_L    WITH(NOLOCK) ON EDC.FTEdcCode = EDC_L.FTEdcCode AND EDC_L.FNLngID   = $nLngID
                                    LEFT JOIN TSysEdc       AS TSEDC    WITH(NOLOCK) ON EDC.FTSedCode = TSEDC.FTSedCode
                                    LEFT JOIN TFNMBank      AS BNK      WITH(NOLOCK) ON EDC.FTBnkCode = BNK.FTBnkCode
                                    LEFT JOIN TFNMBank_L    AS BNK_L    WITH(NOLOCK) ON BNK.FTBnkCode = BNK_L.FTBnkCode AND BNK_L.FNLngID   = $nLngID
                                    WHERE 1=1
        ";

        if($tAgnCode != ''){
            $tSQL .= "AND EDC.FTAgnCode = $tAgnCode";
        }

        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL   .= " AND (EDC.FTEdcCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR EDC_L.FTEdcName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR TSEDC.FTSedModel COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR BNK_L.FTBnkName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aListData  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMCountDataPosEdcListAll($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataWhere['nRow']);
            $aResult = array(
                'raItems'       => $aListData,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aListData);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality : Count Data All Pos Edc List
    // Parameters : Function Parameter
    // Creator : 02/09/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : data
    // Return Type : Array
    public function FSaMCountDataPosEdcListAll($paDataWhere){
        $nLngID         = $paDataWhere['FNLngID'];
        $tSearchList    = $paDataWhere['tSearchAll'];
        $tAgnCode       = $this->session->userdata("tSesUsrAgnCode");
        $tSQL           = " SELECT
                                COUNT (EDC.FTEdcCode) AS counts
                            FROM TFNMEdc            AS EDC      WITH(NOLOCK)
                            LEFT JOIN TFNMEdc_L     AS EDC_L    WITH(NOLOCK) ON EDC.FTEdcCode = EDC_L.FTEdcCode AND EDC_L.FNLngID   = $nLngID
                            LEFT JOIN TSysEdc       AS TSEDC    WITH(NOLOCK) ON EDC.FTSedCode = TSEDC.FTSedCode
                            LEFT JOIN TFNMBank      AS BNK      WITH(NOLOCK) ON EDC.FTBnkCode = BNK.FTBnkCode
                            LEFT JOIN TFNMBank_L    AS BNK_L    WITH(NOLOCK) ON BNK.FTBnkCode = BNK_L.FTBnkCode AND BNK_L.FNLngID   = $nLngID
                            WHERE 1=1
        ";

        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL   .= " AND (EDC.FTEdcCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR EDC_L.FTEdcName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR TSEDC.FTSedModel COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR BNK_L.FTBnkName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        if($tAgnCode != ''){
            $tSQL .= "AND EDC.FTAgnCode = $tAgnCode";
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }

        unset($nLngID);
        unset($tSearchList);
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Add/Update Main Data Pos Edc
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 02/09/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMPosEdcAddUpdateMain($paDataMaster){
        // Update Main Pos Edc
        $this->db->where('FTEdcCode',$paDataMaster['FTEdcCode']);
        $this->db->update('TFNMEdc',array(
            'FTSedCode'     => $paDataMaster['FTSedCode'],
            'FTBnkCode'     => $paDataMaster['FTBnkCode'],
            'FTEdcShwFont'  => $paDataMaster['FTEdcShwFont'],
            'FTEdcShwBkg'   => $paDataMaster['FTEdcShwBkg'],
            'FTEdcOther'    => $paDataMaster['FTEdcOther'],
            'FDLastUpdOn'   => $paDataMaster['FDLastUpdOn'],
            'FTLastUpdBy'   => $paDataMaster['FTLastUpdBy'],
        ));
        
        if($this->db->affected_rows() == 0){
            // Add Main Pos Edc
            // $this->db->set('FDCreateOn', 'GETDATE()', false);
            // $this->db->set('FDLastUpdOn', 'GETDATE()', false);
            $this->db->insert('TFNMEdc',array(
                'FTEdcCode'     => $paDataMaster['FTEdcCode'],
                'FTSedCode'     => $paDataMaster['FTSedCode'],
                'FTBnkCode'     => $paDataMaster['FTBnkCode'],
                'FTEdcShwFont'  => $paDataMaster['FTEdcShwFont'],
                'FTEdcShwBkg'   => $paDataMaster['FTEdcShwBkg'],
                'FTEdcOther'    => $paDataMaster['FTEdcOther'],
                'FDCreateOn'    => $paDataMaster['FDCreateOn'],
                'FDLastUpdOn'   => $paDataMaster['FDLastUpdOn'],
                'FTCreateBy'    => $paDataMaster['FTCreateBy'],
                'FTLastUpdBy'   => $paDataMaster['FTLastUpdBy'],
                'FTAgnCode'     => $paDataMaster['FTAgnCode'],
            ));
        }
        return;
    }

    // Functionality : Add/Update Main Data Pos Edc
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 02/09/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSxMPosEdcAddUpdateLang($paDataMaster){
        // Update Lang Pos Edc 
        $this->db->where('FNLngID',$paDataMaster['FNLngID']);
        $this->db->where('FTEdcCode',$paDataMaster['FTEdcCode']);
        $this->db->update('TFNMEdc_L',array(
            'FTEdcName' => $paDataMaster['FTEdcName'],
            'FTEdcRmk'  => $paDataMaster['FTEdcRmk'],
        ));

        if($this->db->affected_rows() == 0){
            // Add Lang Pos Edc
            $this->db->insert('TFNMEdc_L',array(
                'FTEdcCode' => $paDataMaster['FTEdcCode'],
                'FNLngID'   => $paDataMaster['FNLngID'],
                'FTEdcName' => $paDataMaster['FTEdcName'],
                'FTEdcRmk'  => $paDataMaster['FTEdcRmk'],
            ));
        }
        return;
    }

    // Functionality : Get Data Pos Edc By ID
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 03/09/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSaMPosEdcGetDataByID($paDataWhere){
        $tPosEdcCode    = $paDataWhere['FTEdcCode'];
        $nLngID         = $paDataWhere['FNLngID'];
        $tSQL           = " SELECT
                                EDC.FTEdcCode,
                                EDC_L.FTEdcName,
                                EDC.FTSedCode,
                                TSEDC.FTSedModel,
                                EDC.FTBnkCode,
                                BNK_L.FTBnkName,
                                EDC.FTEdcShwFont,
                                EDC.FTEdcShwBkg,
                                EDC.FTEdcOther,
                                EDC_L.FTEdcRmk,
                                BNK.FTAgnCode       AS rtAgnCode,
                                AGN_L.FTAgnName     AS rtAgnName
                            FROM TFNMEdc            AS EDC      WITH(NOLOCK)
                            LEFT JOIN TCNMAgency_L  AS AGN_L    WITH(NOLOCK) ON EDC.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                            LEFT JOIN TFNMEdc_L     AS EDC_L    WITH(NOLOCK) ON EDC.FTEdcCode = EDC_L.FTEdcCode AND EDC_L.FNLngID = $nLngID
                            LEFT JOIN TSysEdc       AS TSEDC    WITH(NOLOCK) ON EDC.FTSedCode = TSEDC.FTSedCode
                            LEFT JOIN TFNMBank      AS BNK      WITH(NOLOCK) ON EDC.FTBnkCode = BNK.FTBnkCode
                            LEFT JOIN TFNMBank_L    AS BNK_L    WITH(NOLOCK) ON BNK.FTBnkCode = BNK_L.FTBnkCode AND BNK_L.FNLngID = $nLngID
                            WHERE 1=1
                            AND EDC.FTEdcCode = '$tPosEdcCode'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCode'    => '1',
                'rtDesc'    => 'success',
                'raItems'   => $aDetail
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($tPosEdcCode);
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Func Delete Event Pos Edc
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 03/09/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSaMPosEdcDeleteData($paDataWhere){
        $this->db->trans_begin();

        $this->db->where_in('FTEdcCode', $paDataWhere['FTEdcCode']);
        $this->db->delete('TFNMEdc');

        $this->db->where_in('FTEdcCode', $paDataWhere['FTEdcCode']);
        $this->db->delete('TFNMEdc_L');

        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Delete Data Pos Edc.',
            );
        }else{
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Pos Edc Complete.'
            );
        }
        return $aStatus;
    }

    // Functionality : Func Count Data Pos Edc
    // Parameters : Function Parameter In Controler
    // Creator : 24/07/2019 Saharat(Golf)
    // LastUpdate: 03/09/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : None
    public function FSnMCountDataPosEdc(){
        $tSQL   = " SELECT
                        COUNT(EDC.FTEdcCode) AS FNEdcCountAll
                    FROM TFNMEdc EDC WITH(NOLOCK)
        ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->row_array()["FNEdcCountAll"];
    }








}