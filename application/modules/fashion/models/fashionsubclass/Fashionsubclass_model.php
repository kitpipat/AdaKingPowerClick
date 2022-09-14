<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashionsubclass_model extends CI_Model {

    //Creator : 27/04/2021 Napat(Jame)
    public function FSaMSCLDataList($paData){
        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $tWhereCondition    = "";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {
            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");
            if (isset($tSesUsrAgnCode) && !empty($tSesUsrAgnCode)) {
                $tWhereCondition .= " AND ( SCL.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(SCL.FTAgnCode,'') = '' ) ";
            }
        }

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tWhereCondition .= " AND (SCL.FTSclCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR SCL_L.FTSclName LIKE '%$tSearchList%') ";
        }

        $tSQL1 = "  SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS rtRowID,* FROM ( ";
        $tSQL2 = "  SELECT DISTINCT
                        SCL.FTSclCode,
                        SCL_L.FTSclName,
                        SCL.FDCreateOn
                    FROM TFHMPdtF3SubClass SCL WITH(NOLOCK)
                    LEFT JOIN TFHMPdtF3SubClass_L   SCL_L WITH(NOLOCK) ON SCL.FTSclCode = SCL_L.FTSclCode AND SCL_L.FNLngID = $nLngID
                    LEFT JOIN TCNMAgency_L          AGN_L WITH(NOLOCK) ON SCL.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                    WHERE 1=1
                    $tWhereCondition
                 ";
        $tSQL3 = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";


        $tFullQuery  = $tSQL1 . $tSQL2 . $tSQL3;
        $tCountQuery = $tSQL2;

        $oQuery = $this->db->query($tFullQuery);
        if ($oQuery->num_rows() > 0) {
            $oCount = $this->db->query($tSQL2);

            $nFoundRow = $oCount->num_rows();
            $nPageAll  = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oQuery->result(),
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

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSbMSCLCheckDuplicate($paData){
        $tSQL = "   SELECT FTSclCode
                    FROM TFHMPdtF3SubClass WITH(NOLOCK)
                    WHERE FTSclCode = '".$paData['FTSclCode']."'
                ";
        // if ($this->session->userdata("tSesUsrLevel") != "HQ") {
        //     $tSQL .= " AND FTAgnCode = '".$paData['FTAgnCode']."' ";
        // }
        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSaMSCLEventAdd($paData){
        $this->db->insert('TFHMPdtF3SubClass', array(
            'FTSclCode'     => $paData['FTSclCode'],
            'FTAgnCode'     => $paData['FTAgnCode'],
            'FDCreateOn'    => $paData['FDCreateOn'],
            'FTCreateBy'    => $paData['FTCreateBy'],
            'FDLastUpdOn'   => $paData['FDLastUpdOn'],
            'FTLastUpdBy'   => $paData['FTLastUpdBy'],
        ));
        $this->db->insert('TFHMPdtF3SubClass_L', array(
            'FTSclCode'     => $paData['FTSclCode'],
            'FNLngID'       => $paData['FNLngID'],
            'FTSclName'     => $paData['FTSclName'],
            'FTSclRmk'      => $paData['FTSclRmk'],
        ));

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Master Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add Master.',
            );
        }
        return $aStatus;
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSaMSCLEventGetData($paData){
        $tSclCode   = $paData['FTSclCode'];
        // $tAgnCode   = $paData['FTAgnCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "   SELECT DISTINCT
                        SCL.FTSclCode,
                        SCL_L.FTSclName,
                        SCL.FDCreateOn,
                        SCL_L.FTSclRmk,
                        SCL.FTAgnCode,
                        AGN_L.FTAgnName
                    FROM TFHMPdtF3SubClass SCL WITH(NOLOCK)
                    LEFT JOIN TFHMPdtF3SubClass_L   SCL_L WITH(NOLOCK) ON SCL.FTSclCode = SCL_L.FTSclCode AND SCL_L.FNLngID = $nLngID
                    LEFT JOIN TCNMAgency_L          AGN_L WITH(NOLOCK) ON SCL.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                    WHERE 1=1
                     AND SCL.FTSclCode = '$tSclCode'
                  ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'       => $oDetail[0],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found.',
            );
        }
        $oResult = json_encode($aResult);
        $aResult = json_decode($oResult, true);
        return $aResult;
    }

    //Creator : 27/04/2021 Napat(Jame)
    public function FSxMSCLEventEdit($paData){
        // Update
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        $this->db->where('FTSclCode', $paData['FTSclCode']);
        $this->db->update('TFHMPdtF3SubClass');

        $this->db->set('FNLngID', $paData['FNLngID']);
        $this->db->set('FTSclName', $paData['FTSclName']);
        $this->db->set('FTSclRmk', $paData['FTSclRmk']);
        $this->db->where('FTSclCode', $paData['FTSclCode']);
        $this->db->update('TFHMPdtF3SubClass_L');
    }

    //Creator : 28/04/2021 Napat(Jame)
    public function FSxMSCLEventDelete($aDataCodeDel){
        $this->db->where_in('FTSclCode', $aDataCodeDel);
        $this->db->delete('TFHMPdtF3SubClass');

        $this->db->where_in('FTSclCode', $aDataCodeDel);
        $this->db->delete('TFHMPdtF3SubClass_L');

        if ($this->db->affected_rows() > 0) {
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

}

?>