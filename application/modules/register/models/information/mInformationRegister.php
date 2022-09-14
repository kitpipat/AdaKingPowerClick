<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mInformationRegister extends CI_Model {
    

    //Functionality : Get Data Account BY Cst Key
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : array
    //Return Type : array
    public static function FSaMIMRGetDataCstInformationByCstKey($paData){

        $tLangEdit = $paData['tLangEdit'];
        $tSesLiceseCstKey = $paData['tSesLiceseCstKey'];

        $tSQL ="SELECT
                    LCK.FTCstKey AS rtCstKey,
                    LCK.FTRlkSrvType AS rtRlkSrvType,
                    LCK.FTRlkBchCode AS rtRlkBchCode,
                    CSTL.FTCstName AS rtCstName,
                    CSTRG.FTRegBusName AS rtRegBusName,
                    CSTRG.FTRegBusType AS rtRegBusType,
                    CSTRG.FTRegBusOth AS rtRegBusOth,
                    CST.FTCstTel AS rtCstTel,
                    CST.FTCstEmail AS rtCstEmail
                FROM
                    TRGTLicKey LCK WITH (NOLOCK)
                LEFT OUTER JOIN TRGMCstRegis CSTRG  WITH (NOLOCK) ON  LCK.FTCstKey = CSTRG.FTRegRefCst
                LEFT OUTER JOIN TCNMCst CST WITH (NOLOCK) ON LCK.FTCstKey = CST.FTCstCode
                LEFT OUTER JOIN TCNMCst_L CSTL WITH (NOLOCK) ON LCK.FTCstKey = CSTL.FTCstCode AND CSTL.FNLngID = $tLangEdit
                WHERE LCK.FTCstKey = '$tSesLiceseCstKey'
                ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //Not Found
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }

            return $aResult;
    }
   



    //Functionality : Get Data Branch BY Cst Key
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : array
    //Return Type : array
    public static function FSaMIMRGetDataBchInformationByCstKey($paData){

        $tLangEdit = $paData['tLangEdit'];
        $tSesLiceseCstKey = $paData['tSesLiceseCstKey'];

        $tSQL ="SELECT
                RGCSTBCH.FNCbrSeq,
                RGCSTBCH.FTCbrRefBch,
                BCHL.FTBchName,
                RGCSTBCH.FNCbrQtyPos
                FROM
                    TRGMCstBch RGCSTBCH WITH (NOLOCK)
                LEFT OUTER JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON RGCSTBCH.FTCbrRefBch = BCHL.FTBchCode AND BCHL.FNLngID = $tLangEdit
                WHERE RGCSTBCH.FTCstCode = '$tSesLiceseCstKey'
                ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //Not Found
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
            return $aResult;

    }




    //Functionality : Get Data Branch BY Cst Key
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMIMGetConfigApi(){

        $oResult = $this->db->where('FTSysCode','tCN_AgnKeyAPI')->where('FTSysApp','ALL')->where('FTSysKey','POS')->where('FTSysSeq','1')->get('TSysConfig')->row_array();

        if(!empty($oResult)){
                $aReturn = array(
                    'rtCode' => '01',
                    'oResult' => $oResult
                );
        }else{
            $aReturn = array(
                'rtCode' => '99',
                'oResult' => $oResult
            );
        }

        return $aReturn;
    }




    //Functionality : Get Data Branch BY Cst Key
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMIMGetObjectUrl($ptUrlKey,$pnUrlType){

        $aUrlObject = $this->db->where('FTUrlKey',$ptUrlKey)->where('FNUrlType',$pnUrlType)->get('TCNTUrlObject')->row_array();

        if(!empty($aUrlObject)){
            $tUrl = $aUrlObject['FTUrlAddress'].$aUrlObject['FTUrlPort'];
        }else{
            $tUrl = '';
        }

        return $tUrl;

    }
   
}


