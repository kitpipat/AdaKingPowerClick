<style>
    .xCNTablePSHCheckStatusLocker .otdClassColumn{
        padding     : 10px 0px !important;
        width: 10%;
    }

    .xCNTablePSHCheckStatusLocker .otdClassColumn:first-child{
        padding-left: 10px !important;
        width: 10%;
    }

    .xCNTablePSHCheckStatusLocker .otdClassColumn:last-child{
        padding-right: 10px !important;
        width: 0;
    }

    .xCNTablePSHCheckStatusLocker tbody td tr:nth-child(n+2){
        /*border-top  : 5px solid #FFF !important;*/
    }

    .xCNTablePSHCheckStatusLocker tbody td{
        text-align      : center;
        color           : #FFF;
        vertical-align  : top;
    }

    .xCNPSHTextStatus{
        text-align      : center;
        color           : black;
        width           : 100%;
        text-align      : center !important;
        vertical-align  : top;
    }

    .ospTextChanel{
        font-size : 17px !important;
    }

    .otdClassColumnWidthFull{
        /*width : 100% !important;*/
    }
</style>

<?php 
if($aDataList['rtCode'] == 800){ ?>
    <!--รายละเอียด-->
    <div class="col-xs-12 col-md-4 col-lg-4">
        <div style="border: 1px solid #e8e8e8; border-radius: 3px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);">
            <div style="height:35px; background-color:#222b3c; color:#FFF; width:100%; border-top-left-radius: 3px; border-top-right-radius: 3px;">
                <label style="margin:1% 20px;"> <?=language('vending/vendingshoplayout/vendingmanage', 'tDetailsPDFLayout')?> </label>
            </div>
            <div style="padding: 20px;">
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-xs-3"><span> <?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBch')?></span></div>
                    <div class="col-lg-8 col-sm-8 col-xs-9"><span> : <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusNoneData')?> </span></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-xs-3"><span> <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus', 'tPSHCheckStatusCodeLayout')?></span></div>
                    <div class="col-lg-8 col-sm-8 col-xs-9"><span> : <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusNoneData')?>  </span></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-xs-3"><span> <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus', 'tPSHCheckStatusRack')?></span></div>
                    <div class="col-lg-8 col-sm-8 col-xs-9"><span> : <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusNoneData')?>  </span></div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:10px;">
            <div class='col-lg-12'><hr></div>
            <div class='col-lg-12' style="margin-bottom: 15px;">
                <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColor')?></label>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                 <!-- จอง -->
                <div style="background-color:#f1d342; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorB')?></span>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                <!--ว่าง-->
                <div style="background-color:#0081c2; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorE')?></span>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                <!--ใช้งาน-->
                <div style="background-color:#d63031; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorU')?></span>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                <!--ปิดใช้งาน-->
                <div style="background-color:#636e72; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorC')?></span>
            </div>
        </div>
    </div>

    <!--ไม่พบข้อมูล-->
    <div class="col-xs-12 col-md-5 col-lg-5">
        <label> <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusNoneData')?>  </label>
    </div>
<?php }else{ ?>
    <?php 
        $nHeightPanalSML    = 400;
        $nCalcuHeight       = 300;
        $nWidthColumn       = 0;
        $nLayCol            = 1;
        $aPackData          = [];

        for($k=0; $k<FCNnHSizeOf($aDataList['raItems']); $k++){
            if($nLayCol != $aDataList['raItems'][$k]['FNLayCol']){
                //echo 'คนละชั้น';
                $nWidthColumn = $nWidthColumn + $aDataList['raItems'][$k]['FNLayScaleX'];
            }else{
                //echo 'ชั้นเดียวกัน';
                $nWidthColumn = $aDataList['raItems'][$k]['FNLayScaleX'];
            }
        }


        for($i=0; $i<FCNnHSizeOf($aDataList['raItems']); $i++){
            // $nHeightItem    = floor($aDataList['raItems'][$i]['FNLayScaleY']) * $nCalcuHeight / 10;
            // $nWidthItem     = floor($aDataList['raItems'][$i]['FNLayScaleX']) * ($nWidth - 32) / $nWidthColumn ;

            $nHeightItem    = floor($aDataList['raItems'][$i]['FNLayScaleY']);
            $nWidthItem     = floor($aDataList['raItems'][$i]['FNLayScaleX']);
            
  
            $tResult    = array(
                'floor'         => $aDataList['raItems'][$i]['FNLayRow'], 
                'col'           => $aDataList['raItems'][$i]['FNLayCol'], 
                'width'         => $nWidthItem, 
                'height'        => $nHeightItem,
                'number'        => $aDataList['raItems'][$i]['FNLayNo'],
                'statusrack'    => $aDataList['raItems'][$i]['FTRackStatus'],
                'statusBooking' => $aDataList['raItems'][$i]['FNStaBooking'],
                'name'          => $aDataList['raItems'][$i]['FTLayName']
            );
            array_push($aPackData,$tResult);
        }
        $aPackData  = json_encode($aPackData);
    ?>

    <!--ซ่อนค่า-->
    <input type="hidden" id="ohdPSHCheckStatusBCH" value='<?php echo $aDataList['raItems'][0]['FTBchCode'];?>'>
    <input type="hidden" id="ohdPSHCheckStatusSHP" value='<?php echo $aDataList['raItems'][0]['FTShpCode'];?>'>
    <input type="hidden" id="ohdPSHCheckStatusPOS" value='<?php echo $tSaleMac;?>'>
   
    <!--รายละเอียด-->
    <div class="col-xs-12 col-md-4 col-lg-4">
        <div style="border: 1px solid #e8e8e8; border-radius: 3px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);">
            <div style="height:35px; background-color:#222b3c; color:#FFF; width:100%; border-top-left-radius: 3px; border-top-right-radius: 3px;">
                <label style="margin:1% 20px;"> <?=language('vending/vendingshoplayout/vendingmanage', 'tDetailsPDFLayout')?> </label>
            </div>
            <div style="padding: 20px;">
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-xs-3"><span> <?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBch')?></span></div>
                    <div class="col-lg-8 col-sm-8 col-xs-9"><span> : <?=$aDataList['raItems'][0]['FTBchName']?> ( <?php echo language('vending/vendingshoplayout/vendingmanage', 'tCode')?> <?=$aDataList['raItems'][0]['FTBchCode']?> )</span></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-xs-3"><span> <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus', 'tPSHCheckStatusCodeLayout')?></span></div>
                    <div class="col-lg-8 col-sm-8 col-xs-9"><span> : <?=$tSaleMac?> </span></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-xs-3"><span> <?=language('company/smartlockerCheckstatus/smartlockerCheckstatus', 'tPSHCheckStatusRack')?></span></div>
                    <div class="col-lg-8 col-sm-8 col-xs-9"><span> : <?=$aDataList['raItems'][0]['FTRakName']?> </span></div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:10px;">
            <div class='col-lg-12'><hr></div>
            <div class='col-lg-12' style="margin-bottom: 15px;">
                <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColor')?></label>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                 <!-- จอง -->
                <div style="background-color:#f1d342; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorB')?></span>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                <!--ว่าง-->
                <div style="background-color:#0081c2; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorE')?></span>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                <!--ใช้งาน-->
                <div style="background-color:#d63031; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorU')?></span>
            </div>
            <div class='col-lg-3 col-md-3 col-xs-3 col-sm-3'>
                <!--ปิดใช้งาน-->
                <div style="background-color:#636e72; height:20px; width:20px; display: inline-block; margin-right: 5px;"></div>
                <span class="xCNPSHTextStatus"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusColorC')?></span>
            </div>
        </div>
    </div>

    <!--ตาราง-->    
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div id="odvLayoutCheckStatus" style="overflow-y: scroll; height: <?=$nHeightPanalSML?>px;">
            <table class="xCNTablePSHCheckStatusLocker table" style="width: 100% !important; border:1px solid #c7c7c7; float:left;">
                <tbody>
                    <!--Detail-->
                </tbody>
            </table>
        </div>
    </div>

    <!--สั้งเปิดตุ้-->    
    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
        <div id="odvContentOpenLocker" style="display:none;  min-width: 180px;">
            <div id="odvContentOpenTheDoor" style="border:1px solid #c7c7c7; width:100%; padding: 10px;">
                <label class="xCNLabelFrm" style="text-align: center; width: 100%; border-bottom: 1px solid #c7c7c7;"><?=language('company/smartlockerlayout/smartlockerlayout','tPSHCheckStatusNumberIS')?></label>
                <label class="xCNLabelFrm" style="text-align: center; width: 100%; font-size:8rem !important;" id="oliNumberIS"></label>
            </div>

            <!--BTN เปิดล็อกเกอร์-->
            <div class="form-group" id="odvPSHCheckStatusProcess" style="margin-top: 10px;">
                <button type="submit" style="width: 100%;" class="btn btn-primary" onclick="JSvPSHOpenTheDoor();"><?=language('company/smartlockerCheckstatus/smartlockerCheckstatus', 'tPSHCheckStatusOpenTheDoor')?></button>
            </div>
        </div>
    </div>



    <!--Modal Open locker-->
    <div id="odvModalOpenLocker" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?=language('company/smartlockerCheckstatus/smartlockerCheckstatus', 'tPSHCheckStatusOpenTheDoor')?></label>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="xCNLabelFrm" style="text-align: center; width: 100%;"><?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusNumberIS')?></label>
                            <label class="xCNLabelFrm" style="text-align: center; width: 100%; font-size:4rem !important;" id="oliModalNumberIS"></label>
                        </div>
                        <div class="col-lg-9">
                            <!--เบอร์โทรศัพท์-->
                            <label class="xCNLabelFrm"><?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusTelphone');?></label>
                            <input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetPSHOpenLockerTelphone" name="oetPSHOpenLockerTelphone" placeholder="<?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusTelphone');?>">
                            <!--เหตุผล-->
                            <label class="xCNLabelFrm"><?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusReason')?></label>
                            <div class="input-group">
                                <input name="oetInputPSHCheckStatusReasonName" id="oetInputPSHCheckStatusReasonName" class="form-control"  type="text" readonly="" placeholder="<?=language('company/smartlockerCheckstatus/smartlockerCheckstatus','tPSHCheckStatusReason')?>">
                                <input name="oetInputPSHCheckStatusReasonCode" id="oetInputPSHCheckStatusReasonCode" class="form-control xCNHide"  type="text" >
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="obtPSHCheckStatusBrowseReason" type="button">
                                        <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelete" type="button" class="btn xCNBTNPrimery" onclick="JSxPSHCheckStatusInsertLocker();"><?=language('common/main/main', 'tModalConfirm')?></button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
    <!--End modal Open locker-->
    <script>
        var aPackdata   = JSON.parse('<?php echo $aPackData;?>');
        $(function(){
            nColumn     = 0;
            nResultTD   = 1;
            for(i=0; i<aPackdata.length; i++){
                if(aPackdata[i].col == nColumn){
                    var tIDOtd  = 'otd' + aPackdata[i].col + aPackdata[i].floor;
                    var tHTML   = '<tr>'
                        tHTML   += '<td id='+tIDOtd+' data-layno='+aPackdata[i].number+' data-starack='+aPackdata[i].statusrack+' data-stabooking='+aPackdata[i].statusBooking+'>';
                        tHTML   += '<span class="ospTextChanel" style="display:block">' + aPackdata[i].name + '</span>';
                        tHTML   += '</td>';
                        tHTML   += '</tr>';
                    $('.xCNTablePSHCheckStatusLocker tbody #otdC'+aPackdata[i].col).append(tHTML);

                    // Check Check Data Color
                    if(aPackdata[i].statusBooking == 1){
                        // จองแล้ว
                        var tColorbox   = '#f1d342';
                    }else{
                        switch(aPackdata[i].statusrack){
                            case 1 :
                                //ว่าง
                                var tColorbox = '#0081c2';
                            break;
                            case 2 :
                                //ใช้งาน
                                var tColorbox = '#d63031';
                            break;
                            case 3 :
                                //ปิดการใช้งาน
                                var tColorbox = '#636e72';
                            break;
                            default:
                                var tColorbox = '#0081c2';
                        }
                    }

                    if(aPackdata[i].height <= 0 || aPackdata[i].width <= 0){
                        nMinHeight  = '100px';
                        nMinWidth   = '100px';
                    }else{
                        nMinHeight  = aPackdata[i].height;
                        nMinWidth   = aPackdata[i].width;
                    }
                    $('#'+tIDOtd).css({'min-width':nMinWidth,'background-color':tColorbox,'height':aPackdata[i].height +'PX','width':aPackdata[i].width +'PX','vertical-align':'middle','cursor':'pointer'});
                    $('#'+tIDOtd).addClass('xCNPanalPSHCheckStatus');
                    nColumn = aPackdata[i].col;
                }else{
                    //ของเดิมใช้ตัวแปร นี้ nResultTD
                    $('.xCNTablePSHCheckStatusLocker tbody').append('<td class="otdClassColumn otdClassColumnWidthFull" id=otdC'+aPackdata[i].col+'></td>');
                    var tIDOtd  = 'otd' + aPackdata[i].col + aPackdata[i].floor;
                    var tHTML   = '<tr>'
                        tHTML   += '<td id='+tIDOtd+' data-layno='+aPackdata[i].number+' data-starack='+aPackdata[i].statusrack+' data-stabooking='+aPackdata[i].statusBooking+'>';
                        tHTML   += '<span class="ospTextChanel" style="display:block">' + aPackdata[i].name + '</span>';
                        tHTML   += '</td>';
                        tHTML   += '</tr>';

                    // Check Check Data Color
                    if(aPackdata[i].statusBooking == 1){
                        // จองแล้ว
                        var tColorbox = '#f1d342';
                    }else{
                        switch(aPackdata[i].statusrack){
                            case 1 :
                                //ว่าง
                                var tColorbox = '#0081c2';
                            break;
                            case 2 :
                                //ใช้งาน
                                var tColorbox = '#d63031';
                            break;
                            case 3 :
                                //ปิดการใช้งาน
                                var tColorbox = '#636e72';
                            break;
                            default:
                                var tColorbox = '#0081c2';
                        }
                    }

                    if(aPackdata[i].height <= 0 || aPackdata[i].width <= 0){
                        nMinHeight  = '100px';
                        nMinWidth   = '100px';
                    }else{
                        nMinHeight  = aPackdata[i].height;
                        nMinWidth   = aPackdata[i].width;
                    }
                    $('.xCNTablePSHCheckStatusLocker tbody #otdC'+aPackdata[i].col).append(tHTML);
                    $('#'+tIDOtd).css({'min-width':nMinWidth,'background-color':tColorbox,'height':aPackdata[i].height+'PX','width':aPackdata[i].width+'PX','vertical-align':'middle','cursor':'pointer'});
                    $('#'+tIDOtd).addClass('xCNPanalPSHCheckStatus');
                    nColumn     = aPackdata[i].col;
                    nResultTD   = nResultTD+1;
                }
            }

            $('.xCNPanalPSHCheckStatus').click(function(){
                let nDataLayno          = $(this).attr('data-layno');
                let nDataStaRak         = $(this).attr('data-starack');
                let nDataStaBooking     = $(this).attr('data-stabooking');

                // Set Data In Box Number
                $('#odvContentOpenLocker').css('display','block');
                $('#oliNumberIS').text(nDataLayno);
                $('#oliModalNumberIS').text(nDataLayno);
                // Set Default Button
                $('#odvPSHCheckStatusProcess button').prop("disabled",true);
                // Control Button Open Locker Button
                if(nDataStaBooking == 1){
                    $('#odvPSHCheckStatusProcess button').prop("disabled",false);
                }else{
                    // Check Status Rack
                    if(nDataStaRak == 3){
                        $('#odvPSHCheckStatusProcess button').prop("disabled",true);
                    }else{
                        $('#odvPSHCheckStatusProcess button').prop("disabled",false);
                    }
                }
            });
    
        });

        //Open Locker
        function JSvPSHOpenTheDoor(){
            $('#oetPSHOpenLockerTelphone').val('');
            $('#oetInputPSHCheckStatusReasonCode').val('');
            $('#oetInputPSHCheckStatusReasonName').val('');
            $('#odvModalOpenLocker').modal('show');
        }

        //Browse เหตุผล
        var nLangEdits          = '<?php echo $this->session->userdata("tLangEdit");?>';
        var oPSHBrowseReason    = {
            Title   : ["other/reason/reason","tRSNTitle"],
            Table   : {Master:"TCNMRsn",PK:"FTRsnCode"},
            Join    : {
                Table   : ["TCNMRsn_L"],
                On      : ["TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = '"+nLangEdits+"'"]
            },
            Where: {
                Condition : ["AND TCNMRsn.FTRsgCode = '007' "]
            },
            GrideView: {
                ColumnPathLang      : 'other/reason/reason',
                ColumnKeyLang       : ['tRSNTBCode','tRSNTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMRsn.FTRsnCode','TCNMRsn_L.FTRsnName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 10,
                OrderBy             : ['TCNMRsn_L.FTRsnName ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: ["oetInputPSHCheckStatusReasonCode","TCNMRsn.FTRsnCode"],
                Text		: ["oetInputPSHCheckStatusReasonName","TCNMRsn_L.FTRsnName"],
            },
            NextFunc:{
                FuncName    :'JSvCallPageModalInserRack',
                ArgReturn   :['FTRsnCode']
            },
            RouteAddNew : 'reason',
            BrowseLev   : 2
            // DebugSQL : true
        }

        $('#obtPSHCheckStatusBrowseReason').click(function(){ 
            JCNxBrowseData('oPSHBrowseReason'); 
            $('#odvModalOpenLocker').modal('hide');
            JCNxCloseLoading();
        });

        //Modal Open
        function JSvCallPageModalInserRack(elem){
            $('#odvModalOpenLocker').modal('show');
        }

        //Insert Locker
        function JSxPSHCheckStatusInsertLocker(){
            var tBCH        = $('#ohdPSHCheckStatusBCH').val();
            var tSHP        = $('#ohdPSHCheckStatusSHP').val();
            var tPOS        = $('#ohdPSHCheckStatusPOS').val();
            var nLayno      = $('#oliModalNumberIS').text();
            var nTelphone   = $('#oetPSHOpenLockerTelphone').val();
            var nReasonCode = $('#oetInputPSHCheckStatusReasonCode').val();
            $.ajax({
                type: "POST",
                url : "PSHSmartLockerCheckStatusInsertLocker",
                data: { 
                    tBCH        : tBCH,
                    tSHP        : tSHP,
                    tPOS        : tPOS,
                    nLayno      : nLayno,
                    nTelphone   : nTelphone,
                    nReasonCode : nReasonCode
                },
                success: function(tResult){
                    let tTextMessageRespone = "";
                    let aDataReturn         = JSON.parse(tResult);
                    switch(aDataReturn['nStaReturn']){
                        case 1 :
                            $('#oetPSHOpenLockerTelphone').val('');
                            $('#oetInputPSHCheckStatusReasonCode').val('');
                            $('#oetInputPSHCheckStatusReasonName').val('');
                            $('#odvModalOpenLocker').modal('hide');
                        break;
                        case 500 :
                            // เกิดเครส Error
                            tTextMessageRespone = aDataReturn['tStaTextReturn'];
                            FSvCMNSetMsgErrorDialog(tTextMessageRespone);
                        break;
                        case 800 :
                            // เกิดเครสกรณี สั่งเปิด Locker แต่ไม่มีการกำหนด Board หรือ ไม่มีการกำหนด Box No Board
                            tTextMessageRespone = aDataReturn['tStaTextReturn'];
                            FSvCMNSetMsgWarningDialog(tTextMessageRespone);
                        break;
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
        
    </script>
<?php } ?>

