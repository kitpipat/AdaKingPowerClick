<input id="oetCstStaBrowse" type="hidden" value="<?=$nCstBrowseType?>">
<input id="oetCstCallBackOption" type="hidden" value="<?=$tCstBrowseOption?>">

<?php if(isset($nCstBrowseType) && $nCstBrowseType == 0) : ?>
    <div id="odvCstMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">

                <div class="xCNCstVMaster">
                    <div class="col-xs-12 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <?php FCNxHADDfavorite('customer/0/0');?>
                            <li id="oliCstTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCSTCallPageCustomer('')"><?= language('customer/customer/customer','tCSTTitle')?></li>
                            <li id="oliCstTitleAdd" class="active"><a><?= language('customer/customer/customer','tCSTTitleAdd')?></a></li>
                            <li id="oliCstTitleEdit" class="active"><a><?= language('customer/customer/customer','tCSTTitleEdit')?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <div id="odvBtnCstInfo">
                                <button id="obtCstAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCSTCallPageCustomerAdd()">+</button>
                            </div>
                            <div id="odvBtnAddEdit">
                                <button onclick="JSvCSTCallPageCustomer()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?= language('common/main/main', 'tBack')?></button>
                                <div class="btn-group xWBtnSave">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxCheckCustomerValidateForm();$('#ohdCheckSubmitByButton').val(1);$('#ofmAddCustomerInfo1').submit();"> <?= language('common/main/main', 'tSave')?></button>
                                    <?=$vBtnSave?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNCstBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageCustomer"></div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tCstBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliCstNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCstBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('customer/customer/customer','tCSTTitle')?></a></li>
                    <li class="active"><a><?= language('customer/customer/customer','tCSTTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvCstBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#ohdCheckSubmitByButton').val(1);$('#ofmAddCustomerInfo1').submit();"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>	
<script src="<?php echo  base_url('application/modules/customer/assets/src/customer/jCustomer.js'); ?>"></script>

<script type="text/Javascript">
    //Function Click Manage Advance Table
    function JSxPdtOpenColumnFormSet(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "productAdvTableShwColList",
            cache: false,
            Timeout: 0,
            success: function(oResult){
                if(oResult.length > 0){
                    //Append Head Table Product Advance Modal Setting
                    $('#odvPdtDetailShowColumn').empty()
                    .append($('<div>')
                    .css('height','350px')
                    .css('overflow','auto')
                        .append($('<table>')
                        .attr('id','otbPdtOrderListDetail')
                        .attr('class','table table-bordered table-striped')
                            .append($('<thead>')
                                .append($('<tr>')
                                    .append($('<th>')
                                    .css('width','20px')
                                    .text('ลำดับ')
                                    )
                                    .append($('<th>')
                                    .text('ชื่อคอลัมน์')
                                    )
                                    .append($('<th>')
                                    .attr('class','text-center')
                                    .css('width','20px')
                                    .text('เลือก')
                                    )
                                )
                            )
                            .append($('<tbody>')
                            )
                        )
                    )
                    .append($('<div>')
                    .css('padding','10px 0px')
                        .append($('<label>')
                        .attr('class','fancy-checkbox')
                            .append($('<input>')
                            .attr('type','checkbox')
                            .attr('id','ocbPdtSetColDef')
                            )
                            .append($('<span>')
                            .text('ใช้ค่าเริ่มต้น')
                            )
                        )
                    )

                    //Loop Append Tr And Chk Statu Show Set By User
                    var aDataAdvCol = JSON.parse(oResult);
                    $.each(aDataAdvCol['aAvailableColumn'],function( nKey , aValue){
                        $('#odvPdtShowOrderColumn #otbPdtOrderListDetail tbody').append($('<tr>')
                            .append($('<td>')
                            .text(nKey+1)
                            )
                            .append($('<td>')
                                .append($('<label>')
                                .attr('contenteditable',"true")
                                .attr('class','olbColumnLabelName')
                                .text(aValue['FTShwNameUsr'])
                                )
                            )
                            .append($('<td>')
                            .attr('class','text-center')
                                .append($('<input>')
                                .attr('class','ocbColStaShow')
                                .attr('type','checkbox')
                                .attr('data-id',aValue['FTShwFedShw'])
                                )
                            )
                        )
                        if(aValue['FTShwFedSetByUsr'] == 1){
                            $('#otbPdtOrderListDetail tbody').find("[data-id='" + aValue['FTShwFedShw'] + "']").prop("checked",true);
                        }else{
                            $('#otbPdtOrderListDetail tbody').find("[data-id='" + aValue['FTShwFedShw'] + "']").prop("checked",false);
                        }
                    });
                    $('#otbPdtOrderListDetail').tableDnD();
                }else{
                    $('#odvPdtShowOrderColumn #otbPdtOrderListDetail tbody').append($('<tr>')
                        .append($('<td>')
                        .attr('class','text-center xCNTextDetail2 xWPdtMdAdvNoData')
                        .attr('colspan',3)
                        .text('ไม่พบรายการข้อมูล')
                        )
                    )
                }
                JCNxCloseLoading();
                $("#odvPdtShowOrderColumn").modal({ show: true });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                (jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Function Save Colu
    function JSxPdtSaveColumnShow(){
        var nCountAdvNoData = $('#odvPdtShowOrderColumn #otbPdtOrderListDetail tbody .xWPdtMdAdvNoData').length;
        if(nCountAdvNoData == 0){
            //Loop Get Data Col Table Setting 
            var aColShowSet = [];
            $("#odvPdtShowOrderColumn #otbPdtOrderListDetail .ocbColStaShow:checked").each(function(){
                aColShowSet.push($(this).data('id'));
            })
        
            //Loop Get Data Col Table All
            var aColShowAllList = [];
            $("#odvPdtShowOrderColumn #otbPdtOrderListDetail .ocbColStaShow").each(function(){
                aColShowAllList.push($(this).data('id'));
            });
        
            //Loop Get Data Label Head Table
            var aColumnLabelName = [];
            $("#odvPdtShowOrderColumn #otbPdtOrderListDetail .olbColumnLabelName").each(function(){
                aColumnLabelName.push($(this).text());
            });

            //Status Check Set Defult
            var nStaSetDef = ($('#ocbPdtSetColDef').is(':checked'))? 1 : 0;
            
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "productAdvTableShwColSave",
                data: {
                    aColShowSet      : aColShowSet,
                    aColShowAllList  : aColShowAllList,
                    aColumnLabelName : aColumnLabelName,
                    nStaSetDef       : nStaSetDef
                },
                cache: false,
                Timeout: 0,
                success: function(tResult){
                    if(tResult == 1){
                        $('#odvPdtShowOrderColumn').modal('hide');
                        $('.modal-backdrop').remove();
                        JSvProductDataTable();
                    }else{
                        alert('Unsucess Set Adavance Table.')
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    (jqXHR, textStatus, errorThrown);
                }
            });
        }
    }
</script>
