<?php
require APPPATH."libraries\koolreport\autoload.php";

use \koolreport\processes\CalculatedColumn;
class rRptCardActiveSummary extends \koolreport\KoolReport {
    use \koolreport\clients\jQuery;
    use \koolreport\clients\Bootstrap;

    public function settings(){
        return array(
            "assets"=>array(
                "path"  => "../../assets/koolreport",
                "url"   => base_url()."application/assets/koolreport"
            ),
            "dataSources"   =>array(
                "DataReport"    =>array(
                    "class"         =>  "\koolreport\datasources\ArrayDataSource",
                    "data"          =>  $this->params["aDataReport"]['raItems'],
                    "dataFormat"    =>  "associate"
                )
            )
        );
    }

    /**
     * rcTxnRemainVal               => ยกมา
     * rcTxnTranferInVal            => โอนเข้า
     * rcTxnTopUpVal                => เติมเงิน
     * rcTxnCancelTopUpVal          => ยกเลิกเติม
     * rcTxnSalePayMentVal          => ตัดจ่าย
     * rcTxnCancelSalePayMentVal    => ยกเลิกจ่าย
     * rcTxnReturnValueVal          => แลกคืน
     * rcTxnTranferOutVal           => โอนออก
    */
    protected function setup(){
        $this->src('DataReport')
        ->pipe(new CalculatedColumn(array(
            "rcTotalBalance"   => "{rcTxnRemainVal}+{rcTxnTranferInVal}+{rcTxnTopUpVal}+{rcTxnCancelSalePayMentVal}+{rcTxnCancelTopUpVal}+{rcTxnSalePayMentVal}+{rcTxnReturnValueVal}+{rcTxnTranferOutVal}"
        )))->pipe($this->dataStore('RptCardActiveSummary'));
    }
}
