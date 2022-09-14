<style>
    .xCNTableDataViewRack .otdClassColumn{
        padding     : 10px 0px !important;
        width: 10%;
    }

    .xCNTableDataViewRack .otdClassColumn:first-child{
        padding-left: 10px !important;
        width: 10%;
    }

    .xCNTableDataViewRack .otdClassColumn:last-child{
        padding-right: 10px !important;
        width: 0;
    }

    .xCNTableDataViewRack tbody td tr:nth-child(n+2){
        /*border-top  : 5px solid #FFF !important;*/
    }

    .xCNTableDataViewRack tbody td{
        text-align      : center;
        color           : #FFF;
        vertical-align  : top;
    }

    .ospTextChanel{
        font-size : 17px !important;
    }

    .otdClassColumnWidthFull{
        /*width : 100% !important;*/
    }
</style>
<?php if($aResultData['rtCode'] == '800'):?>
    <div class="row" style="min-height:430px;vertical-align:middle;display:grid;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label> <?php echo language('sale/bookinglocker/bookinglocker','tBKLNotFoundDataRackStatus');?></label>
        </div>
    </div>
<?php else:?>
    <?php
        $nHeightPanalSML    = 550;
        $nCalcuHeight       = 300;
        $nWidthColumn       = 0;
        $nLayCol            = 1;
        $aPackData          = [];
        // Loop Calcurate Width Colums
        for($k=0; $k<FCNnHSizeOf($aResultData['raItems']); $k++){
            if($nLayCol != $aResultData['raItems'][$k]['FNLayCol']){
                $nWidthColumn   = $nWidthColumn + $aResultData['raItems'][$k]['FNLayScaleX'];
            }else{
                $nWidthColumn   = $aResultData['raItems'][$k]['FNLayScaleX'];
            }
        }
        // Loop Creat Data Pack
        for($i=0; $i<FCNnHSizeOf($aResultData['raItems']); $i++){
            $nHeightItem    = floor($aResultData['raItems'][$i]['FNLayScaleY']);
            $nWidthItem     = floor($aResultData['raItems'][$i]['FNLayScaleX']);
            $tResult        = [
                'floor'         => $aResultData['raItems'][$i]['FNLayRow'], 
                'col'           => $aResultData['raItems'][$i]['FNLayCol'], 
                'width'         => $nWidthItem, 
                'height'        => $nHeightItem,
                'number'        => $aResultData['raItems'][$i]['FNLayNo'],
                'statusrack'    => $aResultData['raItems'][$i]['FTRackStatus'],
                'statusBooking' => $aResultData['raItems'][$i]['FNStaBooking'],
                'name'          => $aResultData['raItems'][$i]['FTLayName']
            ];
            array_push($aPackData,$tResult);
        }
        $aPackData  = json_encode($aPackData);
    ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel-body text-center">
                <div id="odvBKLDataViewRackStatus" style="overflow-y: scroll; height: <?php echo $nHeightPanalSML;?>px;">
                    <table class="xCNTableDataViewRack table" style="width: 100% !important; border:1px solid #c7c7c7; float:left;">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var aPackdata = JSON.parse('<?php echo $aPackData;?>');
        $(function(){
            let nColumn   = 0;
            let nResultTD = 1;
            for(i = 0; i<aPackdata.length; i++){
                if(aPackdata[i].col == nColumn){
                    var tIDOtd  = 'otd' + aPackdata[i].col + aPackdata[i].floor;
                    var tHTML   = '<tr>'
                        tHTML   += '<td id='+tIDOtd+' data-layno='+aPackdata[i].number+' data-starack='+aPackdata[i].statusrack+' data-stabooking='+aPackdata[i].statusBooking+'>';
                        tHTML   += '<span class="ospTextChanel" style="display:block">' + aPackdata[i].name + '</span>';
                        tHTML   += '</td>';
                        tHTML   += '</tr>';
                    $('#odvBKLDataViewRackStatus .xCNTableDataViewRack tbody #otdC'+aPackdata[i].col).append(tHTML);

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
                    $('#'+tIDOtd).css({'min-width':nMinWidth,'background-color':tColorbox,'height':aPackdata[i].height +'PX','width':aPackdata[i].width +'PX','vertical-align':'middle','cursor':'pointer'});
                    $('#'+tIDOtd).addClass('xCNBKLEventBookingLocker');
                    nColumn = aPackdata[i].col;
                }else{
                    //ของเดิมใช้ตัวแปร นี้ nResultTD
                    $('#odvBKLDataViewRackStatus .xCNTableDataViewRack tbody').append('<td class="otdClassColumn otdClassColumnWidthFull" id=otdC'+aPackdata[i].col+'></td>');
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
                    $('#odvBKLDataViewRackStatus .xCNTableDataViewRack tbody #otdC'+aPackdata[i].col).append(tHTML);
                    $('#'+tIDOtd).css({'min-width':nMinWidth,'background-color':tColorbox,'height':aPackdata[i].height+'PX','width':aPackdata[i].width+'PX','vertical-align':'middle','cursor':'pointer'});
                    $('#'+tIDOtd).addClass('xCNBKLEventBookingLocker');
                    nColumn     = aPackdata[i].col;
                    nResultTD   = nResultTD+1;
                }
            }

            $('.xCNBKLEventBookingLocker').click(function(){
                let nDataLayno          = $(this).attr('data-layno');
                let nDataStaRak         = $(this).attr('data-starack');
                let nDataStaBooking     = $(this).attr('data-stabooking');

                // Check Status Rack
                let tTextStatusRack     = "";
                if(nDataStaBooking == '1'){
                    tTextStatusRack += "<?php echo language('sale/bookinglocker/bookinglocker','tBKLStaBooking');?>";
                }else{
                    switch(nDataStaRak){
                        case '1':
                            tTextStatusRack += "<?php echo language('sale/bookinglocker/bookinglocker','tBKLStaEmpty');?>";
                        break;
                        case '2':
                            tTextStatusRack += "<?php echo language('sale/bookinglocker/bookinglocker','tBKLStaUsing');?>";
                        break;
                        case '3':
                            tTextStatusRack += "<?php echo language('sale/bookinglocker/bookinglocker','tBKLStaNotUsing');?>";
                        break;
                    }
                }

                // Set Data In Input Hidden
                $('#oetBKLDataLayNoSelect').val(nDataLayno);
                $('#odvBKLBoxShowNumberLocker #odvContentNumberLocker #oliBKLLockerNumberIS').text(nDataLayno);
                $('#odvBKLBoxShowNumberLocker #odvContentNumberLocker #oliBKLLockerStatus').text(tTextStatusRack);
                // Set Default Button
                $('#obtBKLBookingLockerDetail').addClass('xCNHide');
                $('#obtBKLBookingLockerDetail').prop("disabled",true);
                $('#obtBKLBookingLockerAdd').addClass('xCNHide');
                $('#obtBKLBookingLockerAdd').prop("disabled",true);
                // Control Button Add/Detail Booking
                if(nDataStaBooking == 1){
                    // Add Class Hide
                    $('#obtBKLBookingLockerDetail').removeClass('xCNHide').fadeIn('500');
                    $('#obtBKLBookingLockerAdd').addClass('xCNHide');
                    // Remove Disable Button
                    $('#obtBKLBookingLockerDetail').prop("disabled",false);
                    $('#obtBKLBookingLockerAdd').prop("disabled",true);
                }else{
                    // Switch Case Type
                    if(nDataStaRak == 1){
                        $('#obtBKLBookingLockerDetail').addClass('xCNHide');
                        $('#obtBKLBookingLockerDetail').prop("disabled",true);
                        $('#obtBKLBookingLockerAdd').removeClass('xCNHide');
                        $('#obtBKLBookingLockerAdd').prop("disabled",false);
                    }else{
                        $('#obtBKLBookingLockerDetail').addClass('xCNHide');
                        $('#obtBKLBookingLockerDetail').prop("disabled",true);
                        $('#obtBKLBookingLockerAdd').removeClass('xCNHide');
                        $('#obtBKLBookingLockerAdd').prop("disabled",true);
                    }
                }
            });
        });
    </script>
<?php endif;?>

