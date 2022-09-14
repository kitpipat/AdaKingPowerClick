<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php   
            if( $tCode == '1' ){
                echo "<strong style='font-size:25px;'>".language('document/document/document','tDocPdtName')." : (".$aItems[0]['FTPdtCode'].") ".$aItems[0]['FTPdtName']."</strong>";
            }
        ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbABBPdtTableList" class="table xWPdtTableFont">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap width="10%"><?=language('document/document/document','tDocNumber')?></th>
                        <th nowrap><?=language('document/document/document','tDocPdtS/N')?></th>
                        <th nowrap><?=language('document/document/document','LOT/BATCH No.')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if( $tCode == '1' ){
                        foreach($aItems as $nKey => $aDataVal){
                ?>
                            <tr class="text-center xCNTextDetail2 xWPdtItem" data-pdtcode="<?=$aDataVal['FTPdtCode']?>" data-pdtname="<?=$aDataVal['FTPdtName']?>" data-barcode="<?=$aDataVal['FTXsdBarCode']?>" data-oldsn="<?=($aDataVal['FTXtdRmk'] == "" ? $aDataVal['FTPdtSerial'] : $aDataVal['FTXtdRmk'])?>" >
                                <td nowrap class="text-center"><?=($nKey + 1)?></td>
                                <td nowrap class="text-left">
                                    <?=($aDataVal['FTPdtSerial'] == "" ? "-" : $aDataVal['FTPdtSerial'])?>
                                </td>
                                <td nowrap class="text-left"><?=($aDataVal['FTPdtBatchID'] == "" ? "-" : $aDataVal['FTPdtBatchID'])?></td>
                            </tr>
                <?php
                        }
                    }else{
                ?>
                            <tr><td class="text-center xCNTextDetail2 xWTWITextNotfoundDataPdtTable" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>