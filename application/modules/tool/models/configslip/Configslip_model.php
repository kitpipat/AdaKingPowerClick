<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Configslip_model extends CI_Model {

    // Create By: Napat(Jame) 30/05/2022
    public function FSaMCFSGetDataGrpSlip($ptType){

        $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");

        $tSQLGrpSlip = "    SELECT
                                ROW_NUMBER() OVER(PARTITION BY GHD.FTGshCode ORDER BY GHD.FTGshCode ASC, GDT.FNGsdSeqNo ASC) AS FNGshSeqNo,
                                SUM(1) OVER(PARTITION BY GHD.FTGshCode) AS FNGshDTSeqNo,
                                GHD.FTGshCode,GHD.FTGshName,ISNULL(GDT.FNGsdSeqNo,1) AS FNGsdSeqNo,GDT.FTGsdSubCode,GDT.FTGsdName,GDT.FNGsdLine,GDT.FTGsdStaUse
                            FROM TPSSGrpSlipHD GHD WITH(NOLOCK)
                            LEFT JOIN TPSSGrpSlipDT GDT WITH(NOLOCK) ON GDT.FTGshCode = GHD.FTGshCode
                            WHERE GHD.FTGshStaUse = '1'
                            AND (GDT.FTGsdStaUse = '1' OR GDT.FTGsdStaUse IS NULL) ";

        if( $ptType == 'GrpSlip' ){
            // $tCondition = "IS NULL";
            // $tOrderBy   = " ORDER BY GRP.FTGshCode ASC, GRP.FNGsdSeqNo ASC ";
            $oQuery = $this->db->query($tSQLGrpSlip);
        }else{
            // $tCondition = "IS NOT NULL";
            // $tOrderBy   = " ORDER BY UHD.FNUshSeq ASC, UDT.FNUsdSeqNo ASC ";

            $tSQLUsrSlip = "   SELECT 
                                    GRP.FNGshSeqNo,GRP.FNGshDTSeqNo,
                                    GRP.FTGshCode,GRP.FTGshName,GRP.FNGsdSeqNo,GRP.FTGsdSubCode,GRP.FTGsdName,GRP.FNGsdLine,GRP.FTGsdStaUse,
                                    ROW_NUMBER() OVER(PARTITION BY UHD.FNUshSeq ORDER BY UHD.FNUshSeq ASC, UDT.FNUsdSeqNo) AS FNUsrSeqNo,
                                    SUM(1) OVER(PARTITION BY UHD.FNUshSeq) AS FNUsrDTSeqNo,
                                    UHD.FNUshSeq,UHD.FTUshStaShw,
                                    UDT.FNUsdSeqNo,UDT.FNUsdLine,UDT.FTUsdStaShw
                                FROM (
                                    ".$tSQLGrpSlip."
                                ) GRP
                                LEFT JOIN TPSMUsrSlipHD UHD WITH(NOLOCK) ON UHD.FTGshCode = GRP.FTGshCode
                                LEFT JOIN TPSMUsrSlipDT UDT WITH(NOLOCK) ON UHD.FTAgnCode = UDT.FTAgnCode AND UDT.FNUshSeq = UHD.FNUshSeq AND UDT.FTUsdSubCode = GRP.FTGsdSubCode
                                WHERE ISNULL(UHD.FTAgnCode,'') = '".$tSesUsrAgnCode."' 
                                  AND (UHD.FTGshCode IS NOT NULL)
                                ORDER BY UHD.FNUshSeq ASC, UDT.FNUsdSeqNo ASC ";
            $oQuery = $this->db->query($tSQLUsrSlip);
        }
        
        if( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'aItems' => $oQuery->result_array(),
                'tCode' => '1',
                'tDesc' => 'found data',
            );
        }else{
            $aResult = array(
                'tCode' => '800',
                'tDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    // Create By: Napat(Jame) 30/05/2022
    public function FSxMCFSEventInsertHD($paDataUsrSlipHD){
        // เคลียร์ตารางก่อนแล้วค่อย Insert
        $this->db->where('FTAgnCode', $paDataUsrSlipHD[0]['FTAgnCode']);
        $this->db->delete('TPSMUsrSlipHD');

        $this->db->insert_batch('TPSMUsrSlipHD', $paDataUsrSlipHD);
    }

    // Create By: Napat(Jame) 30/05/2022
    public function FSxMCFSEventInsertDT($paDataUsrSlipDT){
        // เคลียร์ตารางก่อนแล้วค่อย Insert
        $this->db->where('FTAgnCode', $paDataUsrSlipDT[0]['FTAgnCode']);
        $this->db->delete('TPSMUsrSlipDT');

        $this->db->insert_batch('TPSMUsrSlipDT', $paDataUsrSlipDT);
    }

    // Create By: Napat(Jame) 31/05/2022
    public function FSxMCFSEventResetDefault(){

        $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
        $tSesUsername   = $this->session->userdata("tSesUsername");
        $dDate          = date('Y-m-d H:i:s');

        // เคลียร์ตารางก่อนแล้วค่อย Insert
        $this->db->where('FTAgnCode', $tSesUsrAgnCode);
        $this->db->delete('TPSMUsrSlipHD');

        $this->db->where('FTAgnCode', $tSesUsrAgnCode);
        $this->db->delete('TPSMUsrSlipDT');

        $tSQL = "   INSERT INTO TPSMUsrSlipHD (FTAgnCode,FNUshSeq,FTGshCode,FTUshStaShw,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                    SELECT
                        '$tSesUsrAgnCode'                               AS FTAgnCode,
                        ROW_NUMBER() OVER(ORDER BY GHD.FTGshCode ASC)   AS FNUshSeq,
                        GHD.FTGshCode                                   AS FTGshCode,
                        '1'                                             AS FTUshStaShw,
                        '$dDate'                                        AS FDLastUpdOn,
                        '$tSesUsername'                                 AS FTLastUpdBy,
                        '$dDate'                                        AS FDCreateOn,
                        '$tSesUsername'                                 AS FTCreateBy
                    FROM TPSSGrpSlipHD GHD WITH(NOLOCK)
                    LEFT JOIN TPSSGrpSlipDT GDT WITH(NOLOCK) ON GDT.FTGshCode = GHD.FTGshCode AND GDT.FNGsdSeqNo = 1
                    WHERE GHD.FTGshStaUse = '1'
                     AND (GDT.FTGsdStaUse = '1' OR GDT.FTGsdStaUse IS NULL) ";
        $this->db->query($tSQL);

        $tSQL = "   INSERT INTO TPSMUsrSlipDT (FTAgnCode,FNUshSeq,FTUsdSubCode,FTUsdStaShw,FNUsdSeqNo,FNUsdLine,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                    SELECT A.* FROM (
                        SELECT
                            '$tSesUsrAgnCode'                                   AS FTAgnCode,
                            DENSE_RANK () OVER(ORDER BY GHD.FTGshCode ASC)      AS FNUshSeq,
                            GDT.FTGsdSubCode                                    AS FTUsdSubCode,
                            '1'                                                 AS FTUsdStaShw,
                            GDT.FNGsdSeqNo                                      AS FNUsdSeqNo,
                            GDT.FNGsdLine                                       AS FNUsdLine,
                            '$dDate'                                            AS FDLastUpdOn,
                            '$tSesUsername'                                     AS FTLastUpdBy,
                            '$dDate'                                            AS FDCreateOn,
                            '$tSesUsername'                                     AS FTCreateBy
                        FROM TPSSGrpSlipHD GHD WITH(NOLOCK)
                        LEFT JOIN TPSSGrpSlipDT GDT WITH(NOLOCK) ON GDT.FTGshCode = GHD.FTGshCode
                        WHERE GHD.FTGshStaUse = '1'
                         AND (GDT.FTGsdStaUse = '1' OR GDT.FTGsdStaUse IS NULL) 
                    ) A WHERE A.FTUsdSubCode IS NOT NULL ";
        $this->db->query($tSQL);
        
    }

    // Create By: Napat(Jame) 06/06/2022
    public function FSxMCFSEventUpdMasPos(){
        $tSesUsername   = $this->session->userdata("tSesUsername");
        $dDate          = date('Y-m-d H:i:s');
        $tSQL           = " UPDATE TCNMPos SET FDLastUpdOn = '$dDate', FTLastUpdBy = '$tSesUsername' ";
        $this->db->query($tSQL);
    }

    public function FSxMCFSEventGetDataDemo(){
        $nLang      = $this->session->userdata("tLangEdit");
        $aPackData  = array();

        $aPackData['001'] = 'application/modules/common/assets/images/logo/AdaPos5_Logo.png';

        // ดึงบิลขายล่าสุดมาเป็นตัวอย่าง
        $tSQL = "   SELECT TOP 1 HD.FTBchCode,HD.FTXshDocNo,HD.FDXshDocDate,HD.FTPosCode,HD.FTUsrCode,HD.FCXshTotal 
                    FROM TPSTSalHD HD WITH(NOLOCK) 
                    WHERE HD.FNXshDocType = 1 
                    ORDER BY FDCreateOn DESC ";
        $oQuery  = $this->db->query($tSQL);
        $aSalHD = $oQuery->row_array();

        $tBchCode       = $aSalHD['FTBchCode'];
        $tPosCode       = $aSalHD['FTPosCode'];
        $tXshDocNo      = $aSalHD['FTXshDocNo'];
        $dXshDocDate    = $aSalHD['FDXshDocDate'];
        $tCashier       = $aSalHD['FTUsrCode'];

        // 004 ข้อจุดขาย
        $tSQL    = "    SELECT TOP 1 FTBchCode,FTPosCode,FTPosRegNo,FTSmgCode, '$tCashier' AS FTUsrCode
                        FROM TCNMPos WITH(NOLOCK) 
                        WHERE FTBchCode = '".$tBchCode."' 
                          AND FTPosCode = '".$tPosCode."' ";
        $oQuery  = $this->db->query($tSQL);
        $aPackData['004'] = $oQuery->row_array();
        
        $tSmgCode = $aPackData['004']['FTSmgCode'];

        // 003 ข้อความหัวใบเสร็จ
        $tSQL   = " SELECT DT.FNSmgSeq,DT.FTSmgName
                    FROM TCNMSlipMsgDT_L DT WITH(NOLOCK)
                    WHERE DT.FTSmgType = '1' AND DT.FTSmgCode = '$tSmgCode' AND DT.FNLngID = $nLang
                    ORDER BY DT.FNSmgSeq ASC ";
        $oQuery  = $this->db->query($tSQL);
        $aPackData['003'] = $oQuery->result_array();

        // 005 เลขที่บิล
        $aPackData['005'] = array(
            'FTXshDocNo'    => $tXshDocNo/*'S'.date("y").$tBchCode.$tPosCode.'XXXXXXX'*/,
            'FDXshDocDate'  => date_format(date_create($dXshDocDate),"d/m/Y H:i")/*date("d/m/Y H:i")*/
        );

        // 006 รายการสินค้า
        $tSQL = "   SELECT 
                        DT.FTPdtCode,PDTL.FTPdtNameABB AS FTPdtName,DT.FTXsdBarCode AS FTBarCode,DT.FCXsdQtyAll AS FCXsdQty,
                        DT.FTPunName,DT.FCXsdSalePrice,DT.FCXsdNet,DT.FTXsdVatType AS FTPdtStaVat
                    FROM TPSTSalDT DT WITH(NOLOCK) 
                    LEFT JOIN TCNMPdt_L PDTL WITH(NOLOCK) ON DT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLang
                    WHERE DT.FTXshDocNo = '$tXshDocNo' ";
        $oQuery  = $this->db->query($tSQL);
        $aPackData['006'] = $oQuery->result_array();

        return $aPackData;
        
    }

}
?>