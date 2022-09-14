<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mInterfaceImport extends CI_Model {

    public function FSaMINMGetHD($pnLang){

    //     $tSql = "SELECT
    //         MTHD.FTInfCode,
    //         MTHD.FTInfNameTH,
    //         MTHD.FTInfNameEN,
    //         MTHD.FTInfType,
    //         MTHD.FTInfStaUse
    //     FROM TLKSysMTableHD MTHD ";
    // if($pnType!=''){
    //     $tSql .= " WHERE MTHD.FTInfType=$pnType ";
    // }
    // $tSql .=  "ORDER BY MTHD.FTInfNameTH DESC";
        $tSesUsrAgnCode = $this->session->userdata('tSesUsrAgnCode');
        $tSQL = "   SELECT
                        API.FTApiCode,
                        API_L.FTApiName,
                        API.FTApiGrpPrc,
                        CASE WHEN ((SELECT MAX(LGH.FDLogCreate) FROM TLKTLogHis LGH WHERE LGH.FTLogType=1 AND API_L.FTApiName LIKE '%'+LGH.FTLogTask+'%') IS NOT NULL AND  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES  WHERE TABLE_SCHEMA = 'dbo' AND  TABLE_NAME = 'TLKTLogHis')>0 ) THEN
                        CONVERT(VARCHAR(16),(SELECT MAX(LGH.FDLogCreate) FROM TLKTLogHis LGH WHERE LGH.FTLogType=1 AND API_L.FTApiName LIKE '%'+LGH.FTLogTask+'%'),120)
                            ELSE
                                    ''
                            END
                        AS FDLogCreate
                    FROM TCNMTxnAPI API WITH(NOLOCK)
                    LEFT JOIN TCNMTxnAPI_L API_L ON API.FTApiCode = API_L.FTApiCode AND API_L.FNLngID = $pnLang ";
                if($this->session->userdata('tSesUsrLevel')!='HQ'){
                    $tSQL .= " LEFT JOIN TCNMTxnSpcAPI SpcAPI WITH(NOLOCK)  ON API.FTApiCode = SpcAPI.FTApiCode ";
                }
                    $tSQL .=" WHERE 1=1   AND  API.FTApiTxnType = '1' ";
                if($this->session->userdata('tSesUsrLevel')!='HQ'){
                    $tSQL .= " AND ( SpcAPI.FTAgnCode = '$tSesUsrAgnCode' OR  SpcAPI.FTAgnCode IS NULL )";
                }
                    $tSQL .= "  ORDER BY API.FTApiCode ASC
        ";

        $oQuery     = $this->db->query($tSQL);
        $aResult    = $oQuery->result_array();
        return $aResult;
    }


    //Get Data TLKMConfig
    public function FSaMINMGetDataConfig($paLang){
        $tSQL = " SELECT *
        FROM TLKMConfig WITH(NOLOCK)
             LEFT JOIN TLKMConfig_L ON TLKMConfig.FTCfgCode = TLKMConfig_L.FTCfgCode
        WHERE TLKMConfig_L.FNLngID = '$paLang'
              AND TLKMConfig.FTCfgKey = 'Noti'
              AND TLKMConfig_L.FTCfgSeq = '4'
              AND TLKMConfig.FTCfgSeq = '4' ";    //Type 1 นำเข้า
            $oQuery     = $this->db->query($tSQL);
            $aResult    = $oQuery->result_array();
            return $aResult;
    }

}
