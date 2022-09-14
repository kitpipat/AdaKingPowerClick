<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <div id="odvCFSContentDemo" style="line-height: 20px;"></div>

        <!-- Template -->
        <div id="odvCFSDemoGshCode-001" class="row text-center" style="display:none;">
            <img src="<?=$aDemoData['001']?>" height="50"> 
        </div>

        <div id="odvCFSDemoGshCode-002" class="row" style="display:none;margin-top:5px;margin-bottom:5px;"></div>

        <div id="odvCFSDemoGshCode-003" class="row text-center" style="display:none;">
        <?php foreach($aDemoData['003'] as $nKey => $aValue){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?=$aValue['FTSmgName']?></div>
        <?php } ?>
        </div>

        <div id="odvCFSDemoGshCode-004" class="row" style="display:none;">
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">ID: <?=$aDemoData['004']['FTPosRegNo']?></div>
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">USR: <?=$aDemoData['004']['FTUsrCode']?> T: <?=$aDemoData['004']['FTPosCode']?></div>
        </div>

        <div id="odvCFSDemoGshCode-005" class="row" style="display:none;">
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5"><?=$aDemoData['005']['FDXshDocDate']?></div>
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 text-right">BNO: <?=$aDemoData['005']['FTXshDocNo']?></div>
        </div>

        <div id="odvCFSDemoGshCode-006" class="row" style="display:none;">
        <?php $nSeq = 0; ?>
        <?php foreach($aDemoData['006'] as $nKey => $aValue){ $nSeq += 1; ?>
            <div id="<?=$nSeq?>">
                <span id="odvCFSDemoSubCode-<?=$nSeq?>-PdtCode" class="xWleft"><?=$aValue['FTPdtCode']?></span>
                <span id="odvCFSDemoSubCode-<?=$nSeq?>-BarCode" class="xWleft"><?=$aValue['FTBarCode']?></span>
                <span id="odvCFSDemoSubCode-<?=$nSeq?>-PdtName" class="xWleft"><?=$aValue['FTPdtName']?></span>

                <span id="odvCFSDemoSubCode-<?=$nSeq?>-Qty" class="xWleft"><?=number_format($aValue['FCXsdQty'],$nDecimalShow)?></span>
                <span id="odvCFSDemoSubCode-<?=$nSeq?>-Unit" class="xWleft"><?=$aValue['FTPunName']?></span>
                <span id="odvCFSDemoSubCode-<?=$nSeq?>-Price" class="xWleft"><?=number_format($aValue['FCXsdSalePrice'],$nDecimalShow)?></span>
                
                <span id="odvCFSDemoSubCode-<?=$nSeq?>-TotalAmt" class="xWRight"><?=number_format($aValue['FCXsdNet'],$nDecimalShow)?></span>
                <span id="odvCFSDemoSubCode-<?=$nSeq?>-VatType" class="xWRight"><?=($aValue['FTPdtStaVat'] == '1' ? 'V' : '')?></span>
                <?php if( !empty($aValue['FNXddStaDis']) ){ ?>
                <div id="odvCFSDemoDTDis-<?=$nSeq?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right xWPaddingRight xWPaddingLeft">
                    <span class="xWleft">
                    <?php 
                        switch($aValue['FTXddDisChgType']){
                            case '1':
                                echo "ลด (".number_format($aValue['FCXddValue'],$nDecimalShow).")";
                                break;
                            case '3':
                                echo "ชาร์จ (".number_format($aValue['FCXddValue'],$nDecimalShow).")";
                                break;
                        }
                    ?>
                    </span>
                    <span class="xWRight">
                    <?php 
                        switch($aValue['FTXddDisChgType']){
                            case '1':
                                echo number_format($aValue['FCXsdNet'] - $aValue['FCXddValue'],$nDecimalShow);
                                break;
                            case '3':
                                echo number_format($aValue['FCXsdNet'] + $aValue['FCXddValue'],$nDecimalShow);
                                break;
                        }
                    ?>
                    </span>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
        </div>

        <div id="odvCFSDemoGshCode-007" class="row" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right xWPaddingRight xWPaddingLeft">
                <span class="xWleft">ลด <?=$aDemoData['007']['FTPmhNameSlip']?></span>
                <span class="xWRight">-<?=number_format($aDemoData['007']['FCXddValue'],$nDecimalShow)?></span>
            </div>
        </div>

        <div id="odvCFSDemoGshCode-008" class="row" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right xWPaddingRight">
                <span class="xWleft">รวมเงิน ( <?=number_format($aDemoData['008']['FCXsdQtyAll'],$nDecimalShow)?> รายการ )</span>
                <span class="xWRight"><?=number_format($aDemoData['008']['FCXshTotal'],$nDecimalShow)?></span>
            </div>
        </div>

        <div id="odvCFSDemoGshCode-009" class="row" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right xWPaddingRight">
                <span class="xWleft">ลด(<?=number_format($aDemoData['009']['FCXddValue'],$nDecimalShow)?>)</span>
                <span class="xWRight"><?=number_format($aDemoData['009']['FCXddValue'],$nDecimalShow)?></span>
            </div>
        </div>

        <div id="odvCFSDemoGshCode-010" class="row" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right xWPaddingRight">
                <span class="xWleft">ยอดสุทธิ(รวมภาษีมูลค่าเพิ่ม)</span>
                <span class="xWRight"><?=number_format($aDemoData['010']['FCXshGrand'],$nDecimalShow)?></span>
            </div>
            <div id="1">
                <span id="odvCFSDemoSubCode-1-Vat" class="xWleft">ภาษี : <?=$aDemoData['010']['FCXshVat']?></span>
                <span id="odvCFSDemoSubCode-1-Vatable" class="xWleft">ก่อนภาษี : <?=$aDemoData['010']['FCXshVatable']?></span>
            </div>
        </div>

        <div id="odvCFSDemoGshCode-011" class="row" style="display:none;">
        <?php foreach($aDemoData['011'] as $nKey => $aValue){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right xWPaddingRight">
                <span class="xWleft"><?=$aValue['FTRcvName']?></span>
                <span class="xWRight"><?=number_format($aValue['FCRcvAmt'],$nDecimalShow)?></span>
            </div>
            <?php if( !empty($aValue['FCRcvRefNo']) ){ ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <span class="xWleft">Ref No: <?=$aValue['FCRcvRefNo']?></span>
                </div>
            <?php } ?>
        <?php } ?>
        </div>

        <div id="odvCFSDemoGshCode-012" class="row" style="display:none;">
            <div id="1">
                <span id="odvCFSDemoSubCode-1-MemCode" class="xWleft">รหัสสมาชิก : <?=$aDemoData['012']['FTCstCode']?></span>
                <span id="odvCFSDemoSubCode-1-MemName" class="xWleft">ชื่อสมาชิก : <?=$aDemoData['012']['FTCstName']?></span>
                <span id="odvCFSDemoSubCode-1-CardCode" class="xWleft">หมายเลขบัตรสมาชิก : <?=$aDemoData['012']['FTCstCrdNo']?></span>
                <span id="odvCFSDemoSubCode-1-ExpireDate" class="xWleft">วันหมดอายุ : <?=$aDemoData['012']['FDCstCrdExpire']?></span>
                <span id="odvCFSDemoSubCode-1-Point" class="xWleft" style="width: 100%;margin-top: 5px;margin-bottom: 5px;">
                    <table style="width: 100%;text-align: left;">
                        <tr>
                            <td>แต้มเติม</td>
                            <td>ใช้/ได้รับ</td>
                            <td>แต้มโปร</td>
                            <td>คงเหลือ</td>
                        </tr>
                        <tr>
                            <td><?=number_format($aDemoData['012']['FCCstPoint'])?></td>
                            <td><?=number_format($aDemoData['012']['FCCstPointUse'])?></td>
                            <td><?=number_format($aDemoData['012']['FCCstPointPro'])?></td>
                            <td><?=number_format($aDemoData['012']['FCCstPointBal'])?></td>
                        </tr>
                    </table>
                </span>
            </div>
        </div>

        <div id="odvCFSDemoGshCode-013" class="row" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <span class="xWleft">ชื่อพนักงาน : <?=$aDemoData['013']['FTUsrName']?></span>
            </div>
        </div>

        <div id="odvCFSDemoGshCode-014" class="row text-center" style="display:none;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <span><?=$aDemoData['014']['FTXshRmk']?></span>
            </div>
        </div>

        <div id="odvCFSDemoGshCode-015" class="row text-center" style="display:none;">
        <?php foreach($aDemoData['015'] as $nKey => $aValue){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?=$aValue['FTSmgName']?></div>
        <?php } ?>
        </div>

        <div id="odvCFSDemoGshCode-016" class="row text-center" style="display:none;margin-top:5px;margin-bottom:5px;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <img src="<?=$aDemoData['016']['FTImgUrl']?>" height="25">
            </div>
        </div>

        <div id="odvCFSDemoGshCode-017" class="row text-center" style="display:none;margin-top:5px;margin-bottom:5px;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <img src="<?=$aDemoData['017']['FTImgUrl']?>" height="125">
            </div>
        </div>
        
        <!-- Template -->

    </div>

</div>

<style>
    .xWleft {
        float: left;
        margin-right: 5px;
    }

    .xWRight {
        margin-left: 5px;
    }

    .xWPaddingLeft {
        padding-left: 27px;
    }

    .xWPaddingRight {
        padding-right: 27px;
    }
</style>

