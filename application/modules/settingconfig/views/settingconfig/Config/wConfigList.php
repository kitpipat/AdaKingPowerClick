<style>

.xCNComboSelect{
    height: 33px !important;
}

.filter-option-inner-inner{
    margin-top : 0px;
}

.dropdown-toggle{
    height: 33px !important;
}
</style>


<input type="hidden" class="form-control" id="ohdSETTypePage" name="ohdSETTypePage" value="<?=$tTypePage;?>">

<div class="row">
    <div class="col-xs-12 col-md-4 col-lg-4">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('common/main/main','tSearchNew')?></label>
                        <select class="selectpicker form-control xCNComboSelect" id="ocmAppType" style="height:33px !important;">
                            <option value="0"><?=language('settingconfig/settingconfig/settingconfig','tOptionAllGroup')?></option>
                            <?php foreach($aOption['raItems'] AS $key=>$aValue){ ?>
                                <?php /*$tTextOption = 'tOption'.$aValue['FTSysApp'];*/ ?>
                                <option value="<?=$aValue['FTAppCode'];?>"><?=$aValue['FTAppName'];?></option> <?php /*language('settingconfig/settingconfig/settingconfig',$tTextOption)*/ ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                    <label class="xCNLabelFrm" style="color : #FFF !important;">.</label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvSettingConfigLoadTable()" autocomplete="off"  placeholder="<?=language('common/main/main','tPlaceholder'); ?>">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnSearch" type="button" onclick="JSvSettingConfigLoadTable()">
                                <img class="xCNIconAddOn" src="<?=base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
            <div id="odvBtnAddEdit" style="display: block;">
                <button type="button" class="btn btn-primary xCNBTNImportRole xCNBTNDefult xCNBTNDefult2Btn"  onclick="JSxSETImportConfig()"> <?= language('common/main/main', 'tImport') ?></button>
                <button id="oimBtnDisable" type="button" class="btn btn-primary xCNBTNExportRole xCNBTNDefult xCNBTNDefult2Btn" style="margin-left: 5px;" onclick="JSxSETExportConfig()"> <?= language('common/main/main', 'tExport') ?></button>
                <a id="ohdDowloadFile" href="<?=base_url();?>application\modules\settingconfig\views\settingconfig\Config\wExportFile.php?ptFile="></a>
                <button onclick="JSxSETReDefault()"  class="btn xCNBTNDefult xCNBTNDefult2Btn" style="margin-left: 5px;" type="button"><?=language('settingconfig/settingconfig/settingconfig', 'tBTNOriginal'); ?></button>
                <button onclick="JSxSETCancel()" class="btn xCNBTNDefult xCNBTNDefult2Btn" style="margin-left: 5px;" type="button"><?=language('common/main/main', 'tCancel'); ?></button>
                <button onclick="JSxSETSave()" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="margin-left: 5px;" style="display: block;"><?=language('common/main/main', 'tSave'); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="odvContentConfigTable"></div>

<!--MODAL กดยกเลิก-->
<div class="modal fade" id="odvModalSETCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tCancel'); ?></h5>
            </div>
            <div class="modal-body">
                <p><?=language('settingconfig/settingconfig/settingconfig', 'tTextModalCancel'); ?></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxSETModalCancel()" type="button" class="btn xCNBTNPrimery">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?=language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!--MODAL กดใช้แม่แบบ-->
<div class="modal fade" id="odvModalSETDefault">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('settingconfig/settingconfig/settingconfig', 'tTextModalSetDefaultHead'); ?></h5>
            </div>
            <div class="modal-body">
                <p><?=language('settingconfig/settingconfig/settingconfig', 'tTextModalSetDefault'); ?></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxSETModalDefault()" type="button" class="btn xCNBTNPrimery">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?=language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!--Modal นำเข้า (Import) Config-->
<div class="modal fade" id="odvModalConfigImport" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="width: 900px; margin: 1.75rem auto;top:5%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">นำเข้าข้อมูล</label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="odvContentRoleFileImport">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetFileNameConfigImport" name="oetFileNameConfigImport" placeholder="เลือกไฟล์" readonly="">
                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefFileConfigImport" name="oefFileConfigImport" onchange="JSxCheckFileConfigImport(this, event)"
                            accept=".json">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" style="border-radius: 0px 5px 5px 0px;" onclick="$('#oefFileConfigImport').click()">
                                    เลือกไฟล์
                                </button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="border-radius: 0px !important; margin-left: 30px; width: 100px;" onclick="JSxConfrimFileConfigImport()"><?php echo language('common/main/main', 'ตกลง') ?></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="odvContentConfigRenderHTMLImport"></div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <span id="ospTextSummaryImport" style="text-align: left; display: block; font-weight: bold;"></span>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPRoleUpdateAgain" style="display:none;"><?= language('common/main/main', 'เลือกไฟล์ใหม่') ?></button>
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPConfigConfirm" onclick="JSxImportDiagramToDatabase();" data-dismiss="modal" style="display:none;"><?= language('common/main/main', 'ยืนยันการนำเข้า') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtIMPRoleCancel" data-dismiss="modal"><?= language('common/main/main', 'ยกเลิก') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //ใช้ selectpicker
    $('.selectpicker').selectpicker();

    //LoadTable
    JSvSettingConfigLoadTable();

    //ทุกครั้งที่เปลี่ยน Type
    $('#ocmAppType').change(function() {
        JSvSettingConfigLoadTable();
    });

        // Export Role (ส่งออก)
        function JSxSETExportConfig(){
        $.ajax({
            type : "POST",
            url  : "configExportData",
            catch: false,
            timeout : 0,
            success : function(tResult){
                var aResult     = JSON.parse(tResult);
                var tStatus     = aResult.tStatusReturn;

                if(tStatus == '800' || tStatus == 800){
                    alert('ไม่พบข้อมูล');
                }else{
                    var tFileName   = aResult.tFilename;
                    $('#ohdDowloadFile').attr("href","<?=base_url();?>"+"application/modules/settingconfig/views/settingconfig/Config/wExportFile.php?ptFile="+tFileName+"");
                    $('#ohdDowloadFile')[0].click();
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

        //Import Config (นำเข้า)
    function JSxSETImportConfig(){
        //ล้างค่าใหม่ทุกครั้งที่กดนำเข้า
        $('#odvModalConfigImport').modal('show');
        $('#oefFileConfigImport').val('');
        $('#oetFileNameConfigImport').val('');
        $('#odvContentConfigRenderHTMLImport').html('');
        $('#obtIMPConfigConfirm').hide();
    }

    //Import File
    function JSxCheckFileConfigImport(poElement, poEvent){
        try{
            var oFile = $(poElement)[0].files[0];
            var oName = $(poElement)[0].files[0].name;
            var tType = oName.split('.')[1];
            if(oFile == undefined){
                $("#oetFileNameConfigImport").val("");
            }else{
                if(tType != 'json'){
                    alert('สามารถเลือกได้เฉพาะไฟล์ json เท่านั้น');
                    $("#oetFileNameConfigImport").val("");
                }else{
                    $("#oetFileNameConfigImport").val(oFile.name);
                }

            }
        } catch (err) {
            console.log("JSxCheckFileConfigImport Error: ", err);
        }
    }

        //Confirm File
    function JSxConfrimFileConfigImport(){
        var oFile = $('#oefFileConfigImport')[0].files[0];
        var reader      = new FileReader();
        reader.onload   = onReaderLoad;
        reader.readAsText(oFile);
    }

    //function Insert Data
    function onReaderLoad(event){

        if(event.target.result == '' || event.target.result == null){
            $('#odvContentConfigRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
            return;
        }

        var paData = JSON.parse(event.target.result);
        // var tRoleAutoGenCode    = $('#ocbRoleAutoGenCode').is(':checked')? 1 : 0;

        if(paData[0]['tTable'] != "TSysConfig" || paData[1]['tTable'] != "TSysConfig_L"){
            $('#odvContentConfigRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
        }else{
            $.ajax({
                type : "POST",
                url : "configInsertData",
                catch : false,
                data : {
                    aData : paData
                },
                timeout : 0,
                success : function(tResult){
                    let aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        $('#odvModalConfigImport').modal('hide');
                        JSvSettingConfigLoadTable();
                        $('.modal-backdrop').remove();
                    }else{
                        var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                    }
                    JCNxCloseLoading();
                },
            });
        }
    }
</script>
