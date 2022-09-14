<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtPrice extends CI_Model {
    
    // Functionality : Delete Product
    // Parameters : function parameters
    // Creator :  30/08/2018 wasin
    // Return : Status Delete Product
	// Return Type : Array
    public function FSaMPDTGetDataPdtPriModalUnit($paData){
        $nLngID     = $paData['FNLngID'];
        $tSQL       = " SELECT
                            PUN.FTPunCode,
                            PUN_L.FTPunName
                        FROM TCNMPdtUnit PUN
                        LEFT JOIN TCNMPdtUnit_L PUN_L ON  PUN.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $nLngID
                        WHERE 1=1 ";
        $oQuery     = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->result_array();
            $aResult = array(
                'raItems'	=> $aDataQuery,
                'rtCode'	=> '1',
                'rtDesc'	=> 'success'
            );
        }else{
            $aResult = array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }
}
