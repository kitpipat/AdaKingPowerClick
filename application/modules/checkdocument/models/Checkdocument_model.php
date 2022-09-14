<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Checkdocument_model extends CI_Model {
    

    //Functionality : Get Data Account BY Cst Key
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMMNTGetDocType($paData){

        $tLangEdit = $paData['tLangEdit'];
        $tRoleCode = $paData['tSesUsrRoleCodeMulti'];
        
        $tSQL = "SELECT
                    NOTI.FTNotCode,
                    NOTI.FTNotStaResponse,
	                NOTI_L.FTNotTypeName,
                    RPTSPC.FTRptCode 
                FROM
                    TCNSNoti NOTI WITH(NOLOCK)
                LEFT OUTER JOIN TCNSNoti_L NOTI_L WITH(NOLOCK) ON NOTI.FTNotCode = NOTI_L.FTNotCode AND NOTI_L.FNLngID = $tLangEdit
                LEFT OUTER JOIN TCNSRptSpc RPTSPC WITH(NOLOCK) ON NOTI.FTNotCode = RPTSPC.FTRptCode AND RPTSPC.FTRolCode IN($tRoleCode) 
                WHERE ISNULL(RPTSPC.FTRptCode,'')!=''   ";
   
        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            $aItems = $oQuery->result_array();
            $aResult = array(
                'raItems' => $aItems,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found'
            );
        }
        return $aResult;
    }

   
}


