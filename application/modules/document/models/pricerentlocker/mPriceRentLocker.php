<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPriceRentLocker extends CI_Model {

    // Functionality: Get Data Price Rate Locker List
    // Parameters: function parameters
    // Creator:  05/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMPriRntLkGetDataTableList($paDataCondition){
        $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID         = $paDataCondition['FNLngID'];
        $tSearchAll     = $paDataCondition['tSearchAll'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FTRthCode DESC) AS FNRowID,* FROM (
                                SELECT DISTINCT
                                    PRLHD.FTRthCode,
                                    PRLHD.FTRthCalType,
                                    PRLHD_L.FTRthName,
                                    PRLHD.FTAgnCode
                                FROM TRTMPriRateHD  PRLHD    WITH (NOLOCK)
                                LEFT JOIN TRTMPriRateHD_L PRLHD_L WITH (NOLOCK) ON PRLHD.FTRthCode = PRLHD_L.FTRthCode AND PRLHD_L.FNLngID = $nLngID
                                WHERE 1=1
                    ";
        // ค้นหาข้อมูล
        if(isset($tSearchAll) && !empty($tSearchAll)){
            $tSQL   .= " AND (PRLHD.FTRthCode COLLATE THAI_BIN LIKE '%".$tSearchAll."%') ";
            $tSQL   .= " OR (PRLHD_L.FTRthName COLLATE THAI_BIN LIKE '%".$tSearchAll."%') ";
        }   

        //มองตาม AGN
        $tAgnCode = $this->session->userdata("tSesUsrAgnCode");
        if($tAgnCode != ""){
            $tSQL .= " AND PRLHD.FTAgnCode = '$tAgnCode'";
        }

        $tSQL   .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMPriRntLkCountPageListAll($paDataCondition);
            $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1')? $aDataCountAllRow['rtCountData'] : 0;
            $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $oDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality: Data Get Data Page All
    // Parameters: function parameters
    // Creator:  05/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSnMPriRntLkCountPageListAll($paDataCondition){
        $nLngID     = $paDataCondition['FNLngID'];
        $tSearchAll = $paDataCondition['tSearchAll'];
        $tSQL       =   "   SELECT
                                COUNT (PRLHD.FTRthCode) AS counts
                            FROM TRTMPriRateHD  PRLHD   WITH (NOLOCK)
                            LEFT JOIN TRTMPriRateHD_L PRLHD_L WITH (NOLOCK) ON PRLHD.FTRthCode = PRLHD_L.FTRthCode AND PRLHD_L.FNLngID = $nLngID
                            WHERE 1=1
                        ";
        // ค้นหาข้อมูล
        if(isset($tSearchAll) && !empty($tSearchAll)){
            $tSQL   .= " AND (PRLHD.FTRthCode COLLATE THAI_BIN LIKE '%".$tSearchAll."%') ";
            $tSQL   .= " OR (PRLHD_L.FTRthName COLLATE THAI_BIN LIKE '%".$tSearchAll."%') ";
        }

        //มองตาม AGN
        $tAgnCode = $this->session->userdata("tSesUsrAgnCode");
        if($tAgnCode != ""){
            $tSQL .= " AND PRLHD.FTAgnCode = '$tAgnCode'";
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
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality: Data Get Data By ID
    // Parameters: function parameters
    // Creator:  10/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMPriRntLkGetDataByID($paDataWhere){
        $tRthCode   = $paDataWhere['FTRthCode'];
        $nLngID     = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            PRIRNTLK.FTRthCode,
                            PRIRNTLK.FTRthCalType,
                            PRIRNTLK_L.FTRthName,
                            AGN_L.FTAgnCode  AS FTAgnCode,
                            AGN_L.FTAgnName AS FTAgnName
                        FROM TRTMPriRateHD PRIRNTLK
                        LEFT JOIN [TCNMAgency_L] AGN_L WITH(NOLOCK) ON PRIRNTLK.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                        LEFT JOIN TRTMPriRateHD_L PRIRNTLK_L ON PRIRNTLK.FTRthCode = PRIRNTLK_L.FTRthCode AND PRIRNTLK_L.FNLngID = $nLngID
                        WHERE 1=1 AND PRIRNTLK.FTRthCode = '$tRthCode'  ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'raItems'       => $aDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality: Data Get Data DT
    // Parameters: function parameters
    // Creator:  08/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMPriRntLkGetDataDT($paDataWhere){
        $tPriRntLkRthCode   = $paDataWhere['FTRthCode'];
        $aRowLen            = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);
        $tSQL   =   " SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FNRtdSeqNo ASC) AS rtRowID,* FROM (
                            SELECT
                                PriRateDT.FTRthCode,
                                PriRateDT.FNRtdSeqNo,
                                PriRateDT.FTRtdTmeType,
                                PriRateDT.FNRtdMinQty,
                                PriRateDT.FNRtdCalMin,
                                PriRateDT.FCRtdTmeFact,
                                PriRateDT.FCRtdPrice
                            FROM TRTMPriRateDT PriRateDT WITH (NOLOCK)
                            WHERE 1 = 1 
                    ";

        $tSQL   .= " AND PriRateDT.FTRthCode  = '$tPriRntLkRthCode'";
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMPriRntLkCountDataDTAll($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        return $aDataReturn;
    }

    // Functionality: Data Count Data DT ALL
    // Parameters: function parameters
    // Creator:  08/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMPriRntLkCountDataDTAll($paDataWhere){
        $tPriRntLkRthCode   = $paDataWhere['FTRthCode'];

        $tSQL   = " SELECT
                        COUNT (PriRateDT.FTRthCode) AS counts
                    FROM TRTMPriRateDT PriRateDT WITH (NOLOCK)
                    WHERE 1 = 1 ";
        $tSQL   .= " AND PriRateDT.FTRthCode  = '$tPriRntLkRthCode'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality: Add / Update  Price Rent Locker HD
    // Parameters: function parameters
    // Creator:  10/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: -
    // Return Type: None
    public function FSxMPriRntLkAddUpdateHD($paDataWhere,$paDataMasterHD){
        //Update Price Rent Locker HD
        $this->db->where_in('FTRthCode',$paDataWhere['FTRthCode']);
        $this->db->update('TRTMPriRateHD',array(
            'FTRthCalType'  => $paDataMasterHD['FTRthCalType'],
            'FTAgnCode'     => $paDataWhere['FTAgnCode'],
            'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
            'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
        ));

        if($this->db->affected_rows() === 0){
            // Add Price Rent Locker HD            
            $this->db->insert('TRTMPriRateHD',array(
                'FTRthCode'     => $paDataWhere['FTRthCode'],
                'FTAgnCode'     => $paDataWhere['FTAgnCode'],
                'FTRthCalType'  => $paDataMasterHD['FTRthCalType'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
        }
        return;
    }

    // Functionality: Add / Update  Price Rent Locker HD Lang
    // Parameters: function parameters
    // Creator:  10/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: -
    // Return Type: None
    public function FSxMPriRntLkAddUpdateHDLang($paDataWhere,$paDataMasterHD){
        //Update Price Rent Locker HD Lang
        $this->db->where_in('FTRthCode',$paDataWhere['FTRthCode']);
        $this->db->where_in('FNLngID',$paDataWhere['FNLngID']);
        $this->db->update('TRTMPriRateHD_L',array(
            'FTRthName' => $paDataMasterHD['FTRthName']
        ));

        if($this->db->affected_rows() === 0){
            // Add Price Rent Locker HD
            $this->db->insert('TRTMPriRateHD_L',array(
                'FTRthCode'     => $paDataWhere['FTRthCode'],
                'FNLngID'       => $paDataWhere['FNLngID'],
                'FTRthName'     => $paDataMasterHD['FTRthName']
            ));
        }
        return;
    }


    // Functionality: Add / Update  Price Rent Locker DT
    // Parameters: function parameters
    // Creator:  11/07/2019 Wasin (AKA: MR.JW)
    // Last Modified: 
    // Return: -
    // Return Type: None
    public function FSxMPriRntLkDeleteDataDT($paDataWhere,$paDataMasterDT){
        // Delete Price Rent Locker DT
        $this->db->where_in('FTRthCode',$paDataWhere['FTRthCode']);
        $this->db->delete('TRTMPriRateDT');
        return;
    }

    // Functionality: Add / Update  Price Rent Locker DT
    // Parameters: function parameters
    // Creator:  10/07/2019 wasin (AKA: MR.JW)
    // Last Modified: 11/07/2019 Wasin (AKA: MR.JW)
    // Return: -
    // Return Type: None
    public function FSxMPriRntLkAddUpdateDT($paDataWhere,$paDataMasterDT){
        $aDataAddUpdDT  = array();
        foreach($paDataMasterDT AS $nKey => $aValue){
            // Insert Array DT
            $aDataAddUpdateDT   = array(
                'FTRthCode'     => $paDataWhere['FTRthCode'],
                'FNRtdSeqNo'    => $aValue['tRtdSeqNo'],
                'FNRtdMinQty'   => $aValue['tRtdMinQty'],
                'FNRtdCalMin'   => $aValue['tRtdCalMin'],
                'FTRtdTmeType'  => $aValue['tRtdTmeType'],
                'FCRtdTmeFact'  => 1,
                'FCRtdPrice'    => $aValue['tRtdPrice'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
            );
            $this->db->insert('TRTMPriRateDT',$aDataAddUpdateDT);
        }
        return;
    }

    // Functionality: Delete Data Price Rent Locker
    // Parameters: function parameters
    // Creator:  11/07/2019 wasin (AKA: MR.JW)
    // Last Modified: -
    // Return: -
    // Return Type: None
    public function FSaMPriRntLkDeleteData($paDataWhere){
        // Delete HD
        $this->db->where_in('FTRthCode',$paDataWhere);
        $this->db->delete('TRTMPriRateHD');

        // Delete HD Lang
        $this->db->where_in('FTRthCode',$paDataWhere);
        $this->db->delete('TRTMPriRateHD_L');

        // Delete DT
        $this->db->where_in('FTRthCode',$paDataWhere);
        $this->db->delete('TRTMPriRateDT');

        return;
    }



















}