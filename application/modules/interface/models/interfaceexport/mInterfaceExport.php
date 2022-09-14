<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mInterfaceExport extends CI_Model {

    public function FSaMIFXGetHD($pnLang){
        $tSesUsrAgnCode = $this->session->userdata('tSesUsrAgnCode');
        $tSQL = "   SELECT
                        API.FTApiCode,
                        API_L.FTApiName
                    FROM TCNMTxnAPI API WITH(NOLOCK)
                    LEFT JOIN TCNMTxnAPI_L API_L ON API.FTApiCode = API_L.FTApiCode AND API_L.FNLngID = $pnLang ";
        if($this->session->userdata('tSesUsrLevel')!='HQ'){
            $tSQL .= " LEFT JOIN TCNMTxnSpcAPI SpcAPI WITH(NOLOCK)  ON API.FTApiCode = SpcAPI.FTApiCode ";
        }
            $tSQL .= " WHERE 1=1
                        AND API.FTApiTxnType = '2'
                        AND ISNULL(API_L.FTApiName,'') != '' ";
        if($this->session->userdata('tSesUsrLevel')!='HQ'){
            $tSQL .= " AND ( SpcAPI.FTAgnCode = '$tSesUsrAgnCode' OR  SpcAPI.FTAgnCode IS NULL )";
        }
            $tSQL .= " ORDER BY API.FNApiGrpSeq ASC ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        $aResult = $oQuery->result_array();
        return $aResult;
    }


    //Get Data TLKMConfig
    public function FSaMINMGetDataConfig(){
    $tSQL = " SELECT  *
                FROM TLKMConfig WITH(NOLOCK)
                LEFT JOIN TLKMConfig_L ON TLKMConfig.FTCfgCode = TLKMConfig_L.FTCfgCode AND TLKMConfig_L.FNLngID = 1
                WHERE TLKMConfig.FTCfgKey = 'Noti'
                AND TLKMConfig_L.FTCfgSeq = '4'
                AND TLKMConfig.FTCfgSeq = '4'
             ";

        $oQuery     = $this->db->query($tSQL);

        $aResult    = $oQuery->result_array();
        return $aResult;
    }

        //19-11-2020 เนลว์เพิ่ม UNION การขายของ Vending
       //Get Data DocNo
       public function FSaMINMGetDataDocNo($ptDocNoFrom,$ptDocNoTo,$ptBchCode){
        // $tSQL = " SELECT  FTXshDocNo
        //             FROM TPSTSalHD WITH(NOLOCK)
        //             WHERE FTXshDocNo BETWEEN '$ptDocNoFrom' AND '$ptDocNoTo'
        //          ";

        $tSQL = "SELECT aData.*  FROM
                    ( SELECT
                        0 + ROW_NUMBER () OVER (ORDER BY FTXshDocNo ASC) AS rtRowID,
                        TPSTSalHD.FTBchCode AS FTBchCode,
                        TPSTSalHD.FTXshDocNo AS FTXshDocNo
                    FROM
                        TPSTSalHD WITH (NOLOCK)
                    UNION
                        SELECT
                            (
                                SELECT
                                    COUNT (*)
                                FROM
                                    TPSTSalHD
                                WHERE
                                    1 = 1
                            ) + ROW_NUMBER () OVER (

                                ORDER BY
                                    TVDTSalHD.FTXshDocNo ASC
                            ) AS rtRowID,
                            TVDTSalHD.FTBchCode AS FTBchCode,
                            TVDTSalHD.FTXshDocNo AS FTXshDocNo
                        FROM
                            TVDTSalHD WITH (NOLOCK)
                    ) AS aData
                    WHERE 1=1
                    ";

            if($ptBchCode!=''){
                $tSQL .=" AND aData.FTBchCode = '$ptBchCode' ";
            }

            $tSQL .=" AND aData.FTXshDocNo BETWEEN '$ptDocNoFrom' AND '$ptDocNoTo' ";

            $oQuery     = $this->db->query($tSQL);


            $aResult    = $oQuery->result_array();
            return $aResult;
        }

        public function FSaMINMGetLogHisError(){

          $tSql ="SELECT
          LKH.FTLogTaskRef,
          SHD.FTBchCode

          FROM
          dbo.TLKTLogHis AS LKH
          LEFT OUTER JOIN TPSTSalHD SHD ON LKH.FTLogTaskRef = SHD.FTXshDocNo
          WHERE
          LKH.FTLogType = 2 AND
          LKH.FTLogStaPrc = 2
          ";

          $oQuery     = $this->db->query($tSql);

          $aResult    = $oQuery->result_array();
          return $aResult;
        }
        // Nattakit Nale 25/11/2020
     //ยกบิลขายที่จะใช้ ไปในตาราง Temp ทำเพื่อเรียงลำดับบิลขายของท้ั้ง VD และ PS แสดงใน Brows
        public function FSxMIFXFillterBill($paData){


            $tSQLPSWhere=' WHERE 1=1 ';
            $tSQLVDWhere=' WHERE 1=1 ';

            if($paData['tFXBchCodeSale']!=''){
                $tFXBchCodeSale = $paData['tFXBchCodeSale'];
                 $tSQLPSWhere .=" AND TPSTSalHD.FTBchCode = '$tFXBchCodeSale' ";
             }

             if($paData['tFXBchCodeSale']!=''){
                 $tFXBchCodeSale = $paData['tFXBchCodeSale'];
                  $tSQLVDWhere .=" AND TVDTSalHD.FTBchCode = '$tFXBchCodeSale' ";
              }

              if($paData['tFXDateFromSale']!=''){
                $tFXDateFromSale = $paData['tFXDateFromSale'];
                 $tSQLPSWhere .=" AND CONVERT(VARCHAR(10),TPSTSalHD.FDXshDocDate,121) >= '$tFXDateFromSale' ";
             }

             if($paData['tFXDateFromSale']!=''){
                 $tFXBchCodeSale = $paData['tFXDateFromSale'];
                  $tSQLVDWhere .=" AND CONVERT(VARCHAR(10),TVDTSalHD.FDXshDocDate,121) >= '$tFXDateFromSale' ";
              }


              if($paData['tFXDateToSale']!=''){
                $tFXDateToSale = $paData['tFXDateToSale'];
                 $tSQLPSWhere .=" AND CONVERT(VARCHAR(10),TPSTSalHD.FDXshDocDate,121) <= '$tFXDateToSale' ";
             }

             if($paData['tFXDateToSale']!=''){
                 $tFXBchCodeSale = $paData['tFXDateToSale'];
                  $tSQLVDWhere .=" AND CONVERT(VARCHAR(10),TVDTSalHD.FDXshDocDate,121) <= '$tFXDateToSale' ";
              }

            $tSesUserCode = $this->session->userdata('tSesUserCode');

            $this->db->where('FTUsrCode',$tSesUserCode)->delete('TCNTBrsBillTmp');

            $tSQL = "INSERT INTO TCNTBrsBillTmp
                                SELECT
                                    '$tSesUserCode' AS FTUsrCode,
                                    Document.*,
                                    GETDATE() AS FTCreateOn ,
                                    '$tSesUserCode' AS FTCreateBy
                                FROM
                                    (
                                        SELECT
                                            TPSTSalHD.FTXshDocNo AS FTXshDocNo,
                                            TPSTSalHD.FDXshDocDate AS FTXshDocDate
                                        FROM
                                            TPSTSalHD WITH (NOLOCK)
                                            $tSQLPSWhere
                                        UNION
                                            SELECT
                                                TVDTSalHD.FTXshDocNo AS FTXshDocNo,
                                                TVDTSalHD.FDXshDocDate AS FTXshDocDate
                                            FROM
                                                TVDTSalHD WITH (NOLOCK)
                                            $tSQLVDWhere
                                    ) Document
                                ORDER BY
                                    Document.FTXshDocNo
                            ";
                // echo $tSQL;
                // die();
                $this->db->query($tSQL);

        }

}
