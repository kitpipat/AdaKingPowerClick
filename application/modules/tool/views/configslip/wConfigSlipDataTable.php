<?php /*echo "<pre>"; print_r($aGetUsrSlip['aItems']);exit;*/ ?>
<style>
    .xWRemoveItems {
        font-size: 11px !important;
        position: absolute;
        top: 2px;
        right: 3px;
        color: #cecbcb;
        cursor: pointer;
        transition: all .2s ease-in;
    }
    .xWRemoveItems:hover {
        color: #cb5252;
    }
    
    .xCNMenuplus {
        float: right;
        margin-right: 10px;
        margin-top: 2px;
    }
    .xCNPanelHeadColor {
        background-color: #1D2530 !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }
    .xWSmgMoveIcon {
        cursor: move !important;
        border-radius: 0px;
        box-shadow: none;
        padding: 0px 10px;
    }
    .placeholder {
        background: #fff;
        visibility: visible;
        border: 2px dashed #dbdbdb;
        border-radius: 10px;
    }
    .xCNMenuplus .xWCssSwiftIcon {
        color: #333;
	    -webkit-transform: translateZ(0);
	    transform: translateZ(0);
	    -webkit-transition-duration: 0.5s;
	    transition-duration: 0.5s;
	    -webkit-transition-property: color;
	    transition-property: color;
	}
	
	.xCNMenuplus:hover .xWCssSwiftIcon {
	    color: #00a0f0;
        vertical-align: middle;
	}
	
	.panel-heading .collapsed .fa-angle-double-down::before {
	    content: "\f103";
	}
	
	.panel-heading .fa-angle-double-down::before {
	    content: "\f102";
	}

    .xWSmgMoveIcon .fa-arrows{
        font-size: 14px;
        color: #333 !important;
    }

    .connectedSortable .xCNPanelHeadColor{
        background-color: #f1f1f1 !important;
    }

    .connectedSortable .xCNPanelHeadColor .xCNTextDetail1{
        color: #333 !important;
    }

    .connectedSortable .panel-default{
        margin-bottom: 15px;
        margin-top: 15px;
    }

    .connectedSortable{
        padding-top: 0px !important;
    }

    .toggle-switch {
        /** bar */
        --bar-height: 14px;
        --bar-width: 40px;
        --bar-color: #eee;

        /** knob */
        --knob-size: 20px;
        --knob-color: #fff;

        /** switch */
        --switch-offset: calc(var(--knob-size) - var(--bar-height));
        --switch-width: calc(var(--bar-width) + var(--switch-offset));
        --transition-duration: 200ms;
        --switch-transition: all var(--transition-duration) ease-in-out;
        --switch-theme-rgb: 26, 115, 232;
        --switch-theme-color: rgb(var(--switch-theme-rgb));
        --switch-box-shadow: 0 0 var(--switch-offset) #11111180;
        --switch-margin: 8px;

        position: relative;
        display: inline-flex;
        align-items: center;
        box-sizing: border-box;
        min-width: var(--bar-width);
        min-height: var(--bar-height);
        margin: var(--switch-margin);
        user-select: none;
    }

    .toggle-switch.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .toggle-switch > input,
    .toggle-switch-input {
        position: absolute;
        width: 0;
        height: 0;
        opacity: 0;
    }

    .toggle-switch > label,
    .toggle-switch-label {
        --knob-x: calc((var(--bar-height) - var(--bar-width)) / 2);
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        width: var(--bar-width);
        height: var(--bar-height);
        /* margin: var(--switch-margin); */
        user-select: none;
    }

    /* checked */
    .toggle-switch > :checked + label,
    :checked + .toggle-switch-label {
        --knob-x: calc((var(--bar-width) - var(--bar-height)) / 2);
    }

    /* bar */
    .toggle-switch > label::before,
    .toggle-switch-label::before {
        position: absolute;
        top: 0;
        left: 0;
        box-sizing: border-box;
        width: var(--bar-width);
        height: var(--bar-height);
        background: var(--bar-color);
        border: 1px solid #d1d1d1; /*--switch-theme-color*/
        border-radius: var(--bar-height);
        opacity: 0.5;
        transition: var(--switch-transition);
        content: "";
    }

    /* checked bar */
    .toggle-switch > :checked + label::before,
    :checked + .toggle-switch-label::before {
        background: var(--switch-theme-color);
    }

    /* knob */
    .toggle-switch > label::after,
    .toggle-switch-label::after {
        box-sizing: border-box;
        width: var(--knob-size);
        height: var(--knob-size);
        background: var(--knob-color);
        border-radius: 50%;
        box-shadow: var(--switch-box-shadow);
        transform: translateX(var(--knob-x));
        transition: var(--switch-transition);
        content: "";
    }

    /* checked knob */
    .toggle-switch > :checked + label::after,
    :checked + .toggle-switch-label::after {
        background: var(--switch-theme-color);
    }

    /* hover & focus knob */
    .toggle-switch > :focus + label::after,
    :focus + .toggle-switch-label::after,
    .toggle-switch:hover > label::after,
    :hover > .toggle-switch-label::after {
        box-shadow: var(--switch-box-shadow), 0 0 0 calc(var(--knob-size) / 2) rgba(var(--switch-theme-rgb), 0.2);
    }

    .xWIconRefresh {
        position: absolute;
        font-size: 12vw;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #179BFD !important;
        opacity: 0.5;
        cursor: pointer;
        transition: all .2s ease-in;
    }

    .xWIconRefreshSpin {
        top: calc(50% - 6.3vw);
        left: calc(50% - 5vw);
    }

    .xWIconRefresh:hover {
        color: #179BFD !important;
        opacity: 1;
    }

</style>
<script>

    $('document').ready(function(){
        var nHeightContent = $('.xCNBody').height() - $('.navbar').height() - $('.xCNMrgNavMenu').height() - $('.footer').height() - 77;
        $('.xWAutoHeight').css({
            'height'        : nHeightContent,
            'overflow-y'    : 'auto'
        });
    });

    $("#odvCFSUsrSlip").sortable({
        revert: true,
        handle      : ".xWSmgMoveIcon",
        placeholder : 'placeholder',
        forcePlaceholderSize  : true,
        update : function (event, ui) {
            JSxCFSShwRefresh();
        },
        receive: function(event, ui) {
            $('#odvCFSUsrSlip').children().each(function(){
                if($(this).hasClass('draggable')){
                    $(this).removeClass('draggable');
                    $(this).removeAttr('style');
                    $(this).append('<div class="xWRemoveItems"><i class="fa fa-times xWClickRemoveItems" aria-hidden="true" onclick="JSxCFSRemoveItems(this)"></i></div>');
                    $(this).children().children().eq(1).before($(this).children().last());
                }
            });
        },
    });

    $(".draggable").draggable({
        connectToSortable: "#odvCFSUsrSlip",
        handle      : ".xWSmgMoveIcon",
        placeholder : 'placeholder',
        forcePlaceholderSize  : true,
        helper: function(e) {
            var tWidth = $(this).width();
            return $(this).clone().attr('style', 'width:'+tWidth+'px;');
        },
        revert: "invalid",
        zIndex: 1000,
        update : function (event, ui) {
            JSxCFSShwRefresh();
        },
        start: function(event, ui){
            var tGshCode = ui.helper.attr('data-orgid');
            var nNextSeq = $('#ohdCFSCountUsrSlip').val();
            nNextSeq = parseInt(nNextSeq) + 1;
            $('#ohdCFSCountUsrSlip').val(nNextSeq);

            ui.helper.attr('id', tGshCode);
            ui.helper.attr('data-seq', nNextSeq);

            // console.log( ui.helper.children().length );
            if( ui.helper.children().length > 1 ){
                ui.helper.children().children()[2].attr('href', '#odvPanelGshCode-Usr-'+tGshCode+'-'+nNextSeq);
                ui.helper.children()[1].attr('id', 'odvPanelGshCode-Usr-'+tGshCode+'-'+nNextSeq);
                ui.helper.children().children().children().children().children()[0].attr('id', 'odvGshCode-Usr-'+tGshCode+'-'+nNextSeq);
                ui.helper.children().children().children().children().children().children().each(function(){
                    var tSubCode = $(this).children().children()[2].attr('data-subcode');
                    $(this).children().children()[2].attr('id', 'ocmCFSUsdLine-Usr-'+tGshCode+'-'+nNextSeq+'-'+tSubCode);
                    $(this).children().children().children()[2].attr('id', 'ocbCFSStaShw-Usr-'+tGshCode+'-'+nNextSeq+'-'+tSubCode);
                    $(this).children().children().children()[3].attr('for', 'ocbCFSStaShw-Usr-'+tGshCode+'-'+nNextSeq+'-'+tSubCode);
                    // console.log($(this).children().children().children());
                });

                var script = document.createElement("script");

                // Add script content
                var tScript  = '$("#odvGshCode-Usr-'+tGshCode+'-'+nNextSeq+'").sortable({';
                    tScript += '    connectWith : "#odvGshCode-Usr-'+tGshCode+'-'+nNextSeq+'",'
                    tScript += '    handle : ".xWSmgMoveIcon",'
                    tScript += '    placeholder : "placeholder",'
                    tScript += '    forcePlaceholderSize : true,'
                    tScript += '    update : function () {'
                    tScript += '        JSxCFSShwRefresh();'
                    tScript += '    }'
                    tScript += '}).disableSelection();'
                script.innerHTML = tScript;

                // Append
                document.head.appendChild(script);
            }
        } 
    });

    function JSxCFSRemoveItems(oElem){
        event.preventDefault();
        var oPanelHeader = $(oElem).parents('.xWPanelHeader');
        oPanelHeader.fadeTo(500, 0.01, function(){ 
            oPanelHeader.slideUp(150, function() {
                oPanelHeader.remove();
                JSxCFSShwRefresh();
            });
        });
    }
    
    $('.selectpicker').selectpicker();

    // $('.toggle-switch-input').off('click').on('click', function(){
    //     JSxCFSShwRefresh();
    // });

    // $('.xWOnChangeLine').off('change').on('change', function(){
    //     JSxCFSShwRefresh();
    // });

    function JSxCFSShwRefresh(){
        // $('.xWCFSDemoContent').css("opacity", "0.5");
        // $('.xWShwIconRefresh').show();
        JSxCFSRenderDemo();
    }

    // function JSxCFSHideRefresh(){
    //     $('.xWShwIconRefresh').hide();
    //     $('.xWCFSDemoContent').css("opacity", "1");
    //     // setTimeout(() => {
    //     //     // $('.xWIconRefresh').removeClass('xWIconRefreshSpin');
    //     //     $('.xWIconRefresh').removeClass('fa-spin');
    //     // }, 1000);
    // }

    $('.xCNMenuplus').off('click').on('click', function(){
        if($(this).hasClass('collapsed')){
            $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
            $('.xCNMenuPanelData').removeClass('in');
        }
    });

    // $('.xWIconRefresh').off('click').on('click', function(){
    //     JSxCFSRenderDemo();
    // });

    function JSxCFSRenderDemo(){
        var aDataUsrSlip = JSaCFSGetDataUsrSlip('Demo');
        var aDataUsrSlipHD = aDataUsrSlip['aDataUsrSlipHD'];
        var aDataUsrSlipDT = aDataUsrSlip['aDataUsrSlipDT'];
        var nMaxUsrSlipHD = aDataUsrSlipHD.length;
        var nMaxUsrSlipDT = aDataUsrSlipDT.length;

        // Clear Old Data
        $('#odvCFSContentDemo').children().remove();

        for(var i=0;i<nMaxUsrSlipHD;i++){
            var nSeqNo      = aDataUsrSlipHD[i]['FNUshSeq'];
            var tGshCode    = aDataUsrSlipHD[i]['FTGshCode'];

            $("<div id='odvCFSDemoSeqNo-"+nSeqNo+"'></div>").appendTo('#odvCFSContentDemo');
            $("#odvCFSDemoGshCode-"+tGshCode).clone().appendTo("#odvCFSDemoSeqNo-"+nSeqNo);
            $("#odvCFSDemoSeqNo-"+nSeqNo+" #odvCFSDemoGshCode-"+tGshCode).show();
        }

        aDataUsrSlipDT.sort(function(a,b){
            if(a.FNUsdLine > b.FNUsdLine && a.FNUshSeq == b.FNUshSeq){ return 1}
            if(a.FNUsdLine < b.FNUsdLine && a.FNUshSeq == b.FNUshSeq){ return -1}
            return 0;
        });

        var aCurLine        = [];
        var nCurSeq         = "";
        var tBeforeSubCode  = "";
        var nBeforeLine     = "";
        for(var i=0;i<nMaxUsrSlipDT;i++){
            var tGshCode        = aDataUsrSlipDT[i]['FTGshCode'];
            var nUshSeq         = aDataUsrSlipDT[i]['FNUshSeq'];
            var tUsdSubCode     = aDataUsrSlipDT[i]['FTUsdSubCode'];
            var nUsdSeqNo       = aDataUsrSlipDT[i]['FNUsdSeqNo'];
            var nUsdLine        = aDataUsrSlipDT[i]['FNUsdLine'];
            var nUsdStaShw      = aDataUsrSlipDT[i]['FTUsdStaShw'];
            var nUsdMaxSeqNo    = aDataUsrSlipDT[i]['FNUsdMaxSeqNo'];

            // จำนวนรายการทั้งหมด
            var nMaxPdt         = $('#odvCFSDemoSeqNo-'+nUshSeq+' #odvCFSDemoGshCode-'+tGshCode).children().length;

            if( nCurSeq != nUshSeq ){
                nCurSeq = nUshSeq;
                aCurLine = [];
            }

            // สร้าง Line ตามรายการสินค้า
            if( aCurLine.indexOf(nUsdLine) == -1 ){
                aCurLine.push(nUsdLine);
                for(var a=1;a<=nMaxPdt;a++){
                    $("<div id='odvCFSDemoLine-"+a+"-"+nUsdLine+"' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right'></div>").appendTo('#odvCFSDemoSeqNo-'+nUshSeq+' #odvCFSDemoGshCode-'+tGshCode+' #'+a);
                }
            }

            // ย้ายสินค้า ตามรายการสินค้า ไปยัง Line ของตัวเอง
            for(var a=1;a<=nMaxPdt;a++){
                var oSpanDT = $("#odvCFSDemoSeqNo-"+nUshSeq+" #odvCFSDemoSubCode-"+a+"-"+tUsdSubCode);
                if( nUsdStaShw == '1' ){

                    if( tUsdSubCode == 'TotalAmt' ){
                        var tNextUsdLine  = aDataUsrSlipDT[(i+1)]['FNUsdLine'];
                        var tNextSubCode  = aDataUsrSlipDT[(i+1)]['FTUsdSubCode'];
                        if( nUsdSeqNo == nUsdMaxSeqNo ){
                            // console.log('อยู่ตำแหน่งสุดท้าย ให้ชิดขวาได้เลย');
                            $("#odvCFSDemoLine-"+a+"-"+nUsdLine).addClass('xWPaddingRight');
                        }else{
                            if( tNextUsdLine == nUsdLine && tNextSubCode == 'VatType' ){
                                // console.log('ข้างหลังเป็น VatType');
                                if( (nUsdSeqNo <= nUsdMaxSeqNo && nUsdSeqNo >= (nUsdMaxSeqNo-1)) ){
                                    // console.log('อยู่ตำแหน่งสุดท้าย หรือเกือบสุดท้าย');
                                }else{
                                    // console.log('ไม่ได้อยู่ใตตำแหน่งสุดท้าย หรือเกือบสุดท้าย');
                                    oSpanDT.removeClass('xWRight');
                                    oSpanDT.addClass('xWleft');
                                }
                            }else{
                                // console.log('ข้างหลังไม่ใช่ VatType');
                                oSpanDT.removeClass('xWRight');
                                oSpanDT.addClass('xWleft');
                            }
                        }
                    }

                    if( tUsdSubCode == 'VatType' ){
                        if( nBeforeLine == nUsdLine && tBeforeSubCode == 'TotalAmt' && nUsdSeqNo == nUsdMaxSeqNo ){
                            // console.log('ข้างหน้าเป็น TotalAmt');
                        }else{
                            // console.log('ข้างหน้าไม่ใช่ TotalAmt');
                            oSpanDT.removeClass('xWRight');
                            oSpanDT.addClass('xWleft');
                        }
                    }
                    

                    // if( tGshCode == '006' && tUsdSubCode == 'VatType' && tBeforeSubCode == 'TotalAmt' ){
                    //     nStaTotalAmt = "xWRight";
                    //     nStaVatType  = "xWRight";
                    // }

                    // ใส่เครื่องหมาย 'x' ไว้ข้างหน้า ราคาหน่วย เมื่อ Seq ข้างหน้าเป็น หน่วย หรือ จำนวน
                    if( tGshCode == '006' && tUsdSubCode == 'Price' && (tBeforeSubCode == 'Unit' || tBeforeSubCode == 'Qty') && nBeforeLine == nUsdLine ){
                        oSpanDT.text('x '+oSpanDT.text());
                    }

                    // ใส่เครื่องหมาย 'x' ไว้ข้างหน้า จำนวน หรือ หน่วย เมื่อ Seq ข้างหน้าเป็น ราคาต่อหน่วย
                    if( tGshCode == '006' && (tUsdSubCode == 'Qty' || tUsdSubCode == 'Unit') && tBeforeSubCode == 'Price' && nBeforeLine == nUsdLine ){
                        oSpanDT.text('x '+oSpanDT.text());
                    }

                    // console.log('1 tBeforeSubCode: '+tBeforeSubCode, 'tUsdSubCode: '+tUsdSubCode, 'nBeforeLine: '+nBeforeLine, 'nUsdLine: '+nUsdLine, 'PdtID: '+a, 'MaxPdt: '+nMaxPdt);
                    if( a == nMaxPdt ){
                        tBeforeSubCode = tUsdSubCode;
                        nBeforeLine = nUsdLine;
                    }
                    // console.log('2 tBeforeSubCode: '+tBeforeSubCode, 'tUsdSubCode: '+tUsdSubCode, 'nBeforeLine: '+nBeforeLine, 'nUsdLine: '+nUsdLine, 'PdtID: '+a, 'MaxPdt: '+nMaxPdt);

                    oSpanDT.appendTo('#odvCFSDemoSeqNo-'+nUshSeq+' #odvCFSDemoLine-'+a+'-'+nUsdLine);
                }else{
                    oSpanDT.remove();
                }
                $("#odvCFSDemoSeqNo-"+nUshSeq+" #odvCFSDemoDTDis-"+a).appendTo('#odvCFSDemoSeqNo-'+nUshSeq+' #odvCFSDemoGshCode-'+tGshCode+' #'+a);
            }

        }

        // JSxCFSHideRefresh();
    }

</script>

<?php
    if( $aGetUsrSlip['tCode'] == '1' ){
        $nCountUsrSlip = FCNnHSizeOf($aGetUsrSlip['aItems']);
    }else{
        $nCountUsrSlip = 1;
    }
?>
<input type="hidden" id="ohdCFSCountUsrSlip" value="<?=$nCountUsrSlip?>">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="panel panel-default" style="margin-bottom: 0px;">
            <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab">
                <label class="xCNTextDetail1"><?php echo language('tool/configslip','tCFSPanelTool');?></label>
            </div>
            <div class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" >
                <div id="odvCFSGrpSlip" class="panel-body connectedSortable xWAutoHeight"> <!-- style="background-image: url('application/modules/common/assets/images/drag-and-drop.jpg');background-size: contain;" -->
                    <?php
                        if( $aGetGrpSlip['tCode'] == '1' ){
                            foreach ($aGetGrpSlip['aItems'] as $nKey => $aValue) {
                    ?> 
                                
                                <?php if( $aValue['FNGsdSeqNo'] == 1 ){ ?>
                                <div id="<?=$aValue['FTGshCode']?>" class="panel panel-default xWPanelHeader draggable" data-orgid="<?=$aValue['FTGshCode']?>">
                                    <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab">
                                        <label class="xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></label>
                                        <label class="xCNTextDetail1"><?=$aValue['FTGshName']?></label>
                                        <?php if( !empty($aValue['FTGsdSubCode']) ){ ?>
                                        <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvPanelGshCode<?=$aValue['FTGshCode']?>" aria-expanded="true">
                                            <i class="fa fa-angle-double-down xWCssSwiftIcon"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                    <?php if( $aValue['FNGsdSeqNo'] == 1 && !empty($aValue['FTGsdSubCode']) ){ ?>
                                    <div id="odvPanelGshCode<?=$aValue['FTGshCode']?>" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="true" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div id="odvGshCode<?=$aValue['FTGshCode']?>">
                                    <?php } ?>
                                                        <?php if( !empty($aValue['FTGsdSubCode']) ){ ?>
                                                        <div id="<?=$aValue['FTGsdSubCode']?>" class="row" style="padding-bottom: 10px;">
                                                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="height: 34px;vertical-align: middle;line-height: 34px;">
                                                                <span class="input-group-btn">
                                                                    <div class="btn xWSmgMoveIcon" style="margin-top: 4px;" type="button"><i class="icon-move fa fa-sort"></i></div>
                                                                    <label><?=$aValue['FTGsdName']?></label>
                                                                </span>
                                                            </div>
                                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                                                                <label class="toggle-switch">
                                                                    <input type="checkbox" id="ocbCFSStaShw-<?=$aValue['FTGshCode']?>-<?=$aValue['FTGsdSubCode']?>" name="ocbCFSStaShw-<?=$aValue['FTGshCode']?>-<?=$aValue['FTGsdSubCode']?>" class="toggle-switch-input" onclick="JSxCFSShwRefresh()" <?php echo ($aValue['FTGsdStaUse'] == '1' ? 'checked' : '')?> />  
                                                                    <label for="ocbCFSStaShw-<?=$aValue['FTGshCode']?>-<?=$aValue['FTGsdSubCode']?>" class="toggle-switch-label"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                                                <select id="ocmCFSUsdLine-<?=$aValue['FTGshCode']?>-<?=$aValue['FTGsdSubCode']?>" class="form-control" onchange="JSxCFSShwRefresh()" data-subcode="<?=$aValue['FTGsdSubCode']?>">
                                                                    <?php for($i=1;$i<=$aValue['FNGshDTSeqNo'];$i++){ ?>
                                                                    <option <?php if($aValue['FNGsdLine'] == $i){ echo "selected";} ?> value="<?=$i?>"><?php echo language('tool/configslip','tCFSLine');?> <?=$i?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                    <?php if( $aValue['FNGshSeqNo'] == $aValue['FNGshDTSeqNo'] && !empty($aValue['FTGsdSubCode']) ){ ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if( $aValue['FNGshSeqNo'] == $aValue['FNGshDTSeqNo'] ){ ?>
                                </div>
                                <?php } ?>
                                
                    <?php
                            }
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
    

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="panel panel-default" style="margin-bottom: 0px;">
            <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('tool/configslip','tCFSPanelDesign');?></label>
            </div>
            <div class="xWPanelContent panel-collapse collapse in" role="tabpanel" aria-expanded="true" >
                <div id="odvCFSUsrSlip" class="panel-body connectedSortable xWAutoHeight">
                <?php
                        if( $aGetUsrSlip['tCode'] == '1' ){
                            foreach ($aGetUsrSlip['aItems'] as $nKey => $aValue) {
                    ?>
                                <?php if( $aValue['FNUsrSeqNo'] == 1 ){ ?>
                                <div id="<?=$aValue['FTGshCode']?>" data-seq="<?=$aValue['FNUshSeq']?>" class="panel panel-default xWPanelHeader">
                                    <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab">
                                        <label class="xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></label>
                                        <div class="xWRemoveItems"><i class="fa fa-times xWClickRemoveItems" aria-hidden="true" onclick="JSxCFSRemoveItems(this)"></i></div>
                                        <label class="xCNTextDetail1"><?=$aValue['FTGshName']?></label>
                                        <?php if( !empty($aValue['FTGsdSubCode']) ){ ?>
                                        <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvPanelGshCode-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>" aria-expanded="true">
                                            <i class="fa fa-angle-double-down xWCssSwiftIcon"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                    <?php if( $aValue['FNUsrSeqNo'] == 1 && !empty($aValue['FTGsdSubCode']) ){ ?>
                                    <script>
                                        $("#odvGshCode-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>").sortable({
                                            connectWith           : "#odvGshCode-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>",
                                            handle                : ".xWSmgMoveIcon",
                                            placeholder           : 'placeholder',
                                            forcePlaceholderSize  : true,
                                            update                : function () {
                                                JSxCFSShwRefresh();
                                            }
                                        }).disableSelection();
                                    </script>
                                    <div id="odvPanelGshCode-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="true" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div id="odvGshCode-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>">
                                    <?php } ?>
                                                        <?php if( !empty($aValue['FTGsdSubCode']) ){ ?>
                                                        <div id="<?=$aValue['FTGsdSubCode']?>" class="row" style="padding-bottom: 10px;">
                                                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="height: 34px;vertical-align: middle;line-height: 34px;">
                                                                <span class="input-group-btn">
                                                                    <div class="btn xWSmgMoveIcon" style="margin-top: 4px;" type="button"><i class="icon-move fa fa-sort"></i></div>
                                                                    <label><?=$aValue['FTGsdName']?></label>
                                                                </span>
                                                            </div>
                                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                                                                <label class="toggle-switch">
                                                                    <input type="checkbox" id="ocbCFSStaShw-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>-<?=$aValue['FTGsdSubCode']?>" name="ocbCFSStaShw-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>-<?=$aValue['FTGsdSubCode']?>" class="toggle-switch-input" onclick="JSxCFSShwRefresh()" <?php echo ($aValue['FTUsdStaShw'] == '1' ? 'checked' : '')?> />
                                                                    <label for="ocbCFSStaShw-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>-<?=$aValue['FTGsdSubCode']?>" class="toggle-switch-label"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                                                <select id="ocmCFSUsdLine-Usr-<?=$aValue['FTGshCode']?>-<?=$aValue['FNUshSeq']?>-<?=$aValue['FTGsdSubCode']?>" class="form-control" onchange="JSxCFSShwRefresh()" data-subcode="<?=$aValue['FTGsdSubCode']?>">
                                                                    <?php for($i=1;$i<=$aValue['FNGshDTSeqNo'];$i++){ ?>
                                                                    <option <?php if($aValue['FNUsdLine'] == $i){ echo "selected";} ?> value="<?=$i?>"><?php echo language('tool/configslip','tCFSLine');?> <?=$i?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                    <?php if( $aValue['FNUsrSeqNo'] == $aValue['FNUsrDTSeqNo'] && !empty($aValue['FTGsdSubCode']) ){ ?>
                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if( $aValue['FNUsrSeqNo'] == $aValue['FNUsrDTSeqNo'] ){ ?>
                                </div>
                                <?php } ?>
                    <?php
                            }   
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <div class="panel panel-default" style="margin-bottom: 0px;">
            <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('tool/configslip','tCFSPanelDemo');?></label>
            </div>
            <div class="xWPanelContent panel-collapse collapse in" role="tabpanel" aria-expanded="true" >
                <div class="panel-body xWAutoHeight">
                    <div class="xWCFSDemoContent"></div>
                    <i class="fa fa-refresh xWShwIconRefresh xWIconRefresh" aria-hidden="true" style="display:none;"></i>
                </div>
            </div>
        </div>
    </div>

</div>
