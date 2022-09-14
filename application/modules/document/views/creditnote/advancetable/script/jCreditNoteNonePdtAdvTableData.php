<script>
    $(document).ready(function () {
        // เปิด/ปิด ฟอร์ม หรับใบลดหนี้ไม่มีสินค้า
        $('#oetCreditNoteSplCode').on('change', function(){
            if($(this).val() != ''){
                JSxCMNVisibleComponent('#otrCreditNoteNonePdtMessageForm', false);
                JSxCMNVisibleComponent('#otrCreditNoteNonePdtActiveForm', true);
            }else{
                JSxCMNVisibleComponent('#otrCreditNoteNonePdtMessageForm', true);
                JSxCMNVisibleComponent('#otrCreditNoteNonePdtActiveForm', false);
            }
        });
        
        if(JCNbCreditNoteIsUpdatePage()){
            JSxCMNVisibleComponent('#otrCreditNoteNonePdtActiveForm', true);
            JSxCMNVisibleComponent('#otrCreditNoteNonePdtMessageForm', false);
            JSoCreditNoteCalEndOfBillNonePdt();
        }
        
        
    });
    
    /**
    * Functionality : Add or Update
    * Parameters : route
    * Creator : 25/06/2019 Piya
    * Update : -
    * Return : -
    * Return Type : -
    */
    function JSxCreditNoteAddUpdateDisChg() {
        FSvPDTAddPdtIntoTableDT();
    }
</script>










