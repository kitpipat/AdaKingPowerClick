<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class Configslip_controller extends MX_Controller {
    public function __construct() {
        $this->load->model('tool/configslip/Configslip_model');
        parent::__construct();
    }

    public function index(){
        $this->load->view('tool/configslip/wConfigSlip');
    }

    // Create By: Napat(Jame) 30/05/2022
    public function FSvCCFSPageDataTable(){
        $aPackData = array(
            'aGetGrpSlip' => $this->Configslip_model->FSaMCFSGetDataGrpSlip('GrpSlip'),
            'aGetUsrSlip' => $this->Configslip_model->FSaMCFSGetDataGrpSlip('UsrSlip'),
        );
        // print_r($aPackData);exit;
        $this->load->view('tool/configslip/wConfigSlipDataTable', $aPackData);
    }

    // Create By: Napat(Jame) 30/05/2022
    public function FSaCCFSEventSave(){
        $aDataUsrSlipHD = $this->input->post('paDataUsrSlipHD');
        $aDataUsrSlipDT = $this->input->post('paDataUsrSlipDT');
        $this->db->trans_begin();
        $this->Configslip_model->FSxMCFSEventInsertHD($aDataUsrSlipHD);
        $this->Configslip_model->FSxMCFSEventInsertDT($aDataUsrSlipDT);
        $this->Configslip_model->FSxMCFSEventUpdMasPos();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturnData = array(
                'nStaEvent' => '905',
                'tStaMessg' => $this->db->error()['message'],
            );
        } else {
            $this->db->trans_commit();
            $aReturnData = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Save Success.',
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By: Napat(Jame) 31/05/2022
    public function FSvCCFSPageDemo(){
        // $aPackData = array(
        //     'aDemoData' => $this->Configslip_model->FSxMCFSEventGetDataDemo()
        // );

        $aPackData = array(
            'nDecimalShow' => FCNxHGetOptionDecimalShow(),
            'aDemoData' => array(
                '001' => base_url('application/modules/common/assets/images/logo/AdaPos5_Logo.png'),
                '003' => array( //ข้อความหัวใบเสร็จ
                    0 => array( 'FNSmgSeq' => 1, 'FTSmgName' => 'ใบกำกับภาษีอย่างย่อ' ),
                    1 => array( 'FNSmgSeq' => 2, 'FTSmgName' => 'บริษัท เอด้าซอฟท์ จำกัด' ),
                    2 => array( 'FNSmgSeq' => 3, 'FTSmgName' => '22/5-8 ถนนนลาดพร้าว 83 แขวง คลองเจ้าคุณสิงห์' ),
                    3 => array( 'FNSmgSeq' => 4, 'FTSmgName' => 'เขตวังทองหลาง กรุงเทพมหานคร 10240' ),
                    4 => array( 'FNSmgSeq' => 5, 'FTSmgName' => 'TAX ID : 0105542005555 (VAT INCLUDED)' ),
                    5 => array( 'FNSmgSeq' => 6, 'FTSmgName' => 'BRANCH : 00001 Tel. 02-530-1681' )
                ),
                '004' => array( //ข้อมูลจุดขาย
                    'FTBchCode'     => '00001',
                    'FTPosCode'     => '00001',
                    'FTPosRegNo'    => 'E2022XXXX',
                    'FTUsrCode'     => '00001'
                ),
                '005' => array( //เลขที่บิล
                    'FTXshDocNo'    => 'S2200001000010000001',
                    'FDXshDocDate'  => date("d/m/Y H:i")
                ),
                '006' => array( //รายการสินค้า
                    0 => array(
                        'FTPdtCode' => '8850773110077',
                        'FTPdtName' => 'ดอยคำ น้ำเห็นหลินจือผสมน้ำผึ้ง 200 มล',
                        'FTBarCode' => '8850773110077',
                        'FCXsdQty' => 2.0000,
                        'FTPunName' => 'กล่อง',
                        'FCXsdSalePrice' => 25.0000,
                        'FCXsdNet' => 50.0000,
                        'FTPdtStaVat' => '1',
                        'FNXddStaDis' => 1,
                        'FTXddDisChgType' => '1',
                        'FCXddValue'  => 5.0000
                    ),
                    1 => array(
                        'FTPdtCode' => '59215',
                        'FTPdtName' => 'โค้ก ออริจินัล 325 มล.',
                        'FTBarCode' => '8851959132012',
                        'FCXsdQty' => 12.0000,
                        'FTPunName' => 'หน่วย',
                        'FCXsdSalePrice' => 10.0000,
                        'FCXsdNet' => 120.0000,
                        'FTPdtStaVat' => '1',
                        'FNXddStaDis' => '',
                        'FTXddDisChgType' => '',
                        'FCXddValue'  => 0
                    ),
                    2 => array(
                        'FTPdtCode' => '59216',
                        'FTPdtName' => 'โอรีโอ สอดไส้ครีมวานิลลา 123 กรัม',
                        'FTBarCode' => '8992760221028',
                        'FCXsdQty' => 2.0000,
                        'FTPunName' => 'หน่วย',
                        'FCXsdSalePrice' => 20.0000,
                        'FCXsdNet' => 40.0000,
                        'FTPdtStaVat' => '1',
                        'FNXddStaDis' => 1,
                        'FTXddDisChgType' => '3',
                        'FCXddValue'  => 5
                    )
                ),
                '007' => array( //ส่วนลดโปรโมชั่น
                    'FTPmhNameSlip' => 'ส่วนลดต้อนรับสมาชิกใหม่',
                    'FCXddValue' => 10.0000
                ),
                '008' => array( //ยอดรวม
                    'FCXshTotal' => 200.0000,
                    'FCXsdQtyAll' => 16.0000
                ),
                '009' => array( //ส่วนลดท้ายบิล
                    'FCXddValue' => 50.0000
                ),
                '010' => array( //ยอดรวมสุทธิ
                    'FCXshGrand' => 150.0000,
                    'FCXshVatable'  => 140.1900,
                    'FCXshVat' => 9.8100
                ),
                '011' => array( //การชำระ
                    0 => array( 'FTRcvName' => 'เงินสด', 'FCRcvAmt' => 50.0000, 'FCRcvRefNo' => '' ),
                    1 => array( 'FTRcvName' => 'SCB', 'FCRcvAmt' => 100.0000, 'FCRcvRefNo' => '**************1546' ),
                    3 => array( 'FTRcvName' => 'เงินทอน', 'FCRcvAmt' => 0.0000, 'FCRcvRefNo' => '' ),
                ),
                '012' => array( //สมาชิก
                    'FTCstCode' => 'AR0000000001',
                    'FTCstName' => 'Adasoft',
                    'FTCstCrdNo' => '833633733',
                    'FDCstCrdExpire' => date("d-m-Y" ,strtotime('+5 year')),
                    'FCCstPoint' => 0.0000,
                    'FCCstPointUse' => 15.0000,
                    'FCCstPointPro' => 0.0000,
                    'FCCstPointBal' => 15.0000,
                ),
                '013' => array( //พนักงาน
                    'FTUsrName' => 'ผู้ดูแลระบบ(แอดมิน)Adasoft'
                ),
                '014' => array( //อ้างอิง/สำเนา
                    'FTXshRmk' => '!!! พิมพ์ครั้งที่ 1 !!!'
                ),
                '015' => array( //ข้อความท้ายใบเสร็จ
                    0 => array( 'FNSmgSeq' => 1, 'FTSmgName' => 'ขอบคุณที่มาอุดหนุน' ),
                    1 => array( 'FNSmgSeq' => 2, 'FTSmgName' => 'เอกสารนี้ได้จัดทำและส่งข้อมูลให้แก่กรมสรรพากร' ),
                    2 => array( 'FNSmgSeq' => 3, 'FTSmgName' => 'ด้วยวิธีการทางอิเล็กทรอนิกส์' ),
                    3 => array( 'FNSmgSeq' => 4, 'FTSmgName' => 'Thank you for visiting us' ),
                    4 => array( 'FNSmgSeq' => 5, 'FTSmgName' => 'Please contact the cashier to request' ),
                    5 => array( 'FNSmgSeq' => 6, 'FTSmgName' => 'full tax invoice within the day of service' )
                ),
                '016' => array(
                    'FTImgUrl' => base_url('application\modules\common\assets\images\icons\barcode.png')
                ),
                '017' => array(
                    'FTImgUrl' => base_url('application\modules\common\assets\images\icons\qrcode.png')
                ),
            ),
        );

        // echo "<pre>";
        // print_r($aPackData);
        // exit;
        $this->load->view('tool/configslip/wConfigSlipDemo', $aPackData);
    }

    // Create By: Napat(Jame) 31/05/2022
    public function FSaCCFSEventResetDefault(){
        $this->db->trans_begin();
        $this->Configslip_model->FSxMCFSEventResetDefault();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturnData = array(
                'nStaEvent' => '905',
                'tStaMessg' => $this->db->error()['message'],
            );
        } else {
            $this->db->trans_commit();
            $aReturnData = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Reset Default Success.',
            );
        }
        echo json_encode($aReturnData);
    }
}
?>