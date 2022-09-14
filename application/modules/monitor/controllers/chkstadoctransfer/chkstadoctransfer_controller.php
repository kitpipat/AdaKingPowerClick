<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


include APPPATH .'libraries/spout-3.1.0/src/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;

class chkstadoctransfer_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('monitor/chkstadoctransfer/chkstadoctransfer_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nSDTBrowseType, $tSDTBrowseOption)
    {
        $aDataConfigView = array(
            'nSDTBrowseType'     => $nSDTBrowseType,
            'tSDTBrowseOption'   => $tSDTBrowseOption
        );
        $this->load->view('monitor/chkstadoctransfer/wChkStaDocTransfer', $aDataConfigView); 
    }

    public function FSvCSDTListPage()
    {
        $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
        $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $nDecimal       = FCNxHGetOptionDecimalShow();

        $aData  = array(
            'nPage'             => $nPage,
            'nRow'              => 10,
            'FNLngID'           => $nLangEdit,
            'aAdvanceSearch'    => $aAdvanceSearch
        );
        $aDataList = $this->chkstadoctransfer_model->FSoMMONGetData($aData);
        
        $aGenTable  = array(
            'aSDTDataList'      => $aDataList,
            'nPage'             => $nPage,
            'nDecimal'          => $nDecimal,
            'FNLngID'           => $nLangEdit,
            'nDocType'          => $aAdvanceSearch['tDocType']
        );

        $this->load->view('monitor/chkstadoctransfer/wChkStaDocTransferDataList',$aGenTable);
    }

    public function FSvCSDTExportExcel()
    {
        $aAdvanceSearch = array(
            'tBchCode'          => $this->input->get('oetSDTBchCode'),
            'tDocType'          => $this->input->get('ocmSDTDocType'),
            'tStaDocTRB'        => $this->input->get('ocmStaDocTRB'),
            'tStaDocTBO'        => $this->input->get('ocmStaDocTBO'),
            'tStaDocTBI'        => $this->input->get('ocmStaDocTBI'),
            'tStaDoc'           => $this->input->get('ocmStaDoc'),
            'tDocNo '           => $this->input->get('oetSDTDocNo'),
            'tDocDateForm'      => $this->input->get('oetSDTDocDateForm'),
            'tDocDateTo'        => $this->input->get('oetSDTDocDateTo')
        );

        $nPage          = ($this->input->get('nPageCurrent') == '' || null)? 1 : $this->input->get('nPageCurrent');   // Check Number Page
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'nPage'             => $nPage,
            'nRow'              => 10,
            'FNLngID'           => $nLangEdit,
            'aAdvanceSearch'    => $aAdvanceSearch,
        );


        $aDataList = $this->chkstadoctransfer_model->FSoMMONGetData($aData);

        $tTitleReport = language('monitor/monitor/monitor', 'tSDTTitle');
        $tFileName = $tTitleReport.'_'.date('YmdHis').'.xlsx';
        $oWriter = WriterEntityFactory::createXLSXWriter();

        $oWriter->openToBrowser($tFileName); // stream data directly to the browser

        // Sheet ที่ 1 ============================================================================
        $oSheet = $oWriter->getCurrentSheet();
        $oSheet->setName(language('monitor/monitor/monitor', 'tSDTTitle'));

        $oBorder = (new BorderBuilder())
        ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
        ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
        ->build();

        $oStyleColums = (new StyleBuilder())
        ->setFontBold()
        ->setBorder($oBorder)
        ->build(); 
        if ($aAdvanceSearch['tDocType'] == 2) {
            $aCells = [
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor', 'tSDTTitle')),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null)
            ];
        }else{
            $aCells = [
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor', 'tSDTTitle')),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null)
            ];
        }

            /** add a row at a time */
            $singleRow = WriterEntityFactory::createRow($aCells);
            $oWriter->addRow($singleRow);

            $aCells = [

                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null)
            ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells);
        $oWriter->addRow($singleRow);

        if ($aAdvanceSearch['tDocType'] == 0) {
            $aCells = [
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTSeq')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTBch')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTDocNo')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTDocDate')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTTRBBchFrm')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTTRBBchTo')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTCreateBy')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTStaDoc')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTStaTRB')),
            ];
        }elseif ($aAdvanceSearch['tDocType'] == 1) {
            $aCells = [
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTSeq')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTBch')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTDocNo')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTDocDate')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTTBOBchFrm')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTTBOBchTo')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTCreateBy')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTStaDoc')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTStaTBO')),
            ];
        }elseif ($aAdvanceSearch['tDocType'] == 2) {
            $aCells = [
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTSeq')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTBch')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTDocNo')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTDocDate')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTTBIBchFrm')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTTBIBchTo')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTCreateBy')),
                WriterEntityFactory::createCell(language('monitor/monitor/monitor','tSDTStaDoc'))
            ];
        }
        
        

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells,$oStyleColums);
        $oWriter->addRow($singleRow);

        if (isset($aDataList['aItems'])) {
            $nSeq = 1;
            foreach ($aDataList['aItems'] as $nKey => $aValue) {
                if ($aValue['FTXthStaDoc'] == 3) {
                    $tStaDoc = language('common/main/main', 'tStaDoc3');
                }else{
                    if ($aValue['FTXthStaDoc'] == 1 && $aValue['FTXthStaApv'] == '') {
                        $tStaDoc = language('common/main/main', 'tStaDoc');
                    }else{
                        $tStaDoc = language('common/main/main', 'tStaDoc1');
                    }
                }
            if ($aAdvanceSearch['tDocType'] == 0) {

                if ($aValue['FTXshRefKey'] == 'TBO') {
                    $tStaText = language('monitor/monitor/monitor', 'tSDTStaHaveTBO');
                }else{
                    $tStaText = language('monitor/monitor/monitor', 'tSDTStaWaitTBO'); 
                }

                $aCells = [
                    WriterEntityFactory::createCell($nSeq),
                    WriterEntityFactory::createCell($aValue['FTBchName']),
                    WriterEntityFactory::createCell($aValue['FTXthDocNo']),
                    WriterEntityFactory::createCell($aValue['FDXthDocDate']),
                    WriterEntityFactory::createCell($aValue['FTXthBchFrmName']),
                    WriterEntityFactory::createCell($aValue['FTXthBchToName']),
                    WriterEntityFactory::createCell($aValue['FTUsrName']),
                    WriterEntityFactory::createCell($tStaDoc),
                    WriterEntityFactory::createCell($tStaText),
                ];
            }elseif ($aAdvanceSearch['tDocType'] == 1) {

                if ($aValue['FTXthStaDoc'] == 1 && $aValue['FTXthStaPrcDoc'] == '' && $aValue['FTXthStaApv'] == '') {
                    $tStaText = language('common/main/main', 'tStaDoc'); 
                }elseif ($aValue['FTXthStaDoc'] == 1 && $aValue['FTXthStaPrcDoc'] == 1 && $aValue['FTXthStaApv'] == '') {
                    $tStaText = language('monitor/monitor/monitor', 'tSDTStaWaitPackingDoc');  
                }elseif ($aValue['FTXthStaDoc'] == 1 && $aValue['FTXthStaPrcDoc'] == 2 && $aValue['FTXthStaApv'] == '') {
                    $tStaText = language('monitor/monitor/monitor', 'tSDTStaWaitPacking');
                }elseif ($aValue['FTXthStaDoc'] == 1 && $aValue['FTXthStaPrcDoc'] == 3 && $aValue['FTXthStaApv'] == '') {
                    $tStaText = language('monitor/monitor/monitor', 'tSDTStaPacking');
                }elseif ($aValue['FTXthStaDoc'] == 1 && $aValue['FTXthStaPrcDoc'] == '' && $aValue['FTXthStaApv'] == 1) {
                    $tStaText = language('common/main/main', 'tStaDoc1');
                }elseif ($aValue['FTXthStaDoc'] == 3 && $aValue['FTXthStaPrcDoc'] == '' && $aValue['FTXthStaApv'] == ''){
                    $tStaText = language('common/main/main', 'tStaDoc3');
                }else{
                    $tStaText = "-";
                }

                $aCells = [
                    WriterEntityFactory::createCell($nSeq),
                    WriterEntityFactory::createCell($aValue['FTBchName']),
                    WriterEntityFactory::createCell($aValue['FTXthDocNo']),
                    WriterEntityFactory::createCell($aValue['FDXthDocDate']),
                    WriterEntityFactory::createCell($aValue['FTXthBchFrmName']),
                    WriterEntityFactory::createCell($aValue['FTXthBchToName']),
                    WriterEntityFactory::createCell($aValue['FTUsrName']),
                    WriterEntityFactory::createCell($tStaDoc),
                    WriterEntityFactory::createCell($tStaText),
                ];
            }elseif ($aAdvanceSearch['tDocType'] == 2) {
                $aCells = [
                    WriterEntityFactory::createCell($nSeq),
                    WriterEntityFactory::createCell($aValue['FTBchName']),
                    WriterEntityFactory::createCell($aValue['FTXthDocNo']),
                    WriterEntityFactory::createCell($aValue['FDXthDocDate']),
                    WriterEntityFactory::createCell($aValue['FTXthBchFrmName']),
                    WriterEntityFactory::createCell($aValue['FTXthBchToName']),
                    WriterEntityFactory::createCell($aValue['FTUsrName']),
                    WriterEntityFactory::createCell($tStaDoc),
                ];
            }

            $nSeq++;

            /** add a row at a time */
            $singleRow = WriterEntityFactory::createRow($aCells);
            $oWriter->addRow($singleRow);
            }
        }
        $oWriter->close();

    }

}
?>
