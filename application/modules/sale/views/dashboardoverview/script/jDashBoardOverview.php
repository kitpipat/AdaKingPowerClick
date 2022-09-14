<script type="text/javascript" src="https://api.longdo.com/map/?key=<?=MAP_APIKEY?>"></script> <!--fd7eddf5deb105e270336bdcc927e973-->
<script>
    $("document").ready(function() {
        localStorage.removeItem("LocalItemData");
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        console.log( <?php echo json_encode($oPackDataDashboard); ?> );

        setTimeout(function(){ 
            JSxDBOInitMap();
        }, 1000);

    });

    function JSxDBOInitMap(){
        map = new longdo.Map({
            placeholder: document.getElementById('odvMap'),
            language: 'th'
        });

        map.bound({
            "minLat": 7.578478613590115,
            "minLon": 95.40783628821373,
            "maxLat": 18.22757947766232,
            "maxLon": 105.64709410071373
        });

        map.Ui.DPad.visible(false);
        map.Ui.Zoombar.visible(false);
        map.Ui.Geolocation.visible(false);
        map.Ui.Toolbar.visible(false);
        map.Ui.LayerSelector.visible(false);
        map.Ui.Fullscreen.visible(false);
        map.Ui.Crosshair.visible(false);
        map.Ui.Scale.visible(false);

        // map.Ui.Keyboard.enable(false);
        // map.Ui.Keyboard.enableInertia(false);
        // map.Ui.Mouse.enableClick(false);
        // map.Ui.Mouse.enableWheel(false);
        // map.Ui.Mouse.enableInertia(false);
        // map.Ui.Mouse.enableDrag(false);

        var aDataMap = <?php echo json_encode($aDataMap);?>;
        console.log(aDataMap);
        for( var i = 0; i < aDataMap.length; i++ ){
            var tIconMarker = '';
            switch(aDataMap[i]['nPosType']){
                case 1:
                    tIconMarker = '<?php echo base_url(); ?>application/modules/sale/assets/images/PosMarker.png';
                    break;
                case 2:
                    tIconMarker = '<?php echo base_url(); ?>application/modules/sale/assets/images/MobileMarker.png';
                    break;
                default:
                    tIconMarker = '<?php echo base_url(); ?>application/modules/sale/assets/images/PosMarker.png';
            }
            var oMarker = new longdo.Marker(
                { lon: aDataMap[i]['cLong'], lat: aDataMap[i]['cLat'] },
                { title: aDataMap[i]['tPosCode'], icon: { url: tIconMarker , offset: { x: 0, y: 15 } } }
            );
            map.Overlays.add(oMarker);
        }

        map.Event.bind('ready', function() {
            map.Event.bind('resize', function() {
                var cMapHeight = $('#odvMap').outerHeight(true);
                // console.log(cMapHeight);
                if( cMapHeight > 300 && cMapHeight < 400 ){
                    map.zoom(5.0,true);
                }else if( cMapHeight > 400 && cMapHeight < 500 ){
                    map.zoom(5.2,true);
                }else if( cMapHeight > 500 && cMapHeight < 700 ){
                    map.zoom(5.4,true);
                // }else if( cMapHeight > 600 && cMapHeight < 700 ){
                //     map.zoom(5.4,true);
                }else if( cMapHeight > 700 && cMapHeight < 800 ){
                    map.zoom(5.6,true);
                }else if( cMapHeight > 800 && cMapHeight < 900 ){
                    map.zoom(6.0,true);
                }else if( cMapHeight > 900 && cMapHeight < 1000 ){
                    map.zoom(6.2,true);
                }else if( cMapHeight > 1000 && cMapHeight < 1100 ){
                    map.zoom(6.4,true);
                }else if( cMapHeight > 1100 && cMapHeight < 1200 ){
                    map.zoom(6.6,true);
                }else if( cMapHeight > 1200 && cMapHeight < 1300 ){
                    map.zoom(6.8,true);
                }else if( cMapHeight > 1300 && cMapHeight < 1400 ){
                    map.zoom(7.0,true);
                }else if( cMapHeight > 1400 && cMapHeight < 1500 ){
                    map.zoom(7.2,true);
                }
            });
        });
    }

    var dDataLastUpdOn = '<?php echo $dDataLastUpdOn; ?>';
    // console.log(dDataLastUpdOn.trim());
    // console.log( typeof(dDataLastUpdOn.trim()) );
    // console.log( dDataLastUpdOn.trim().length );

    oDOVEventChkNewData = setInterval(function(){ 
        $.ajax({
            type: "POST",
            url: "dasDOVEventCheckLastData",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                // var aResult = JSON.parse(oResult);
                // console.log(tResult);
                // console.log( typeof(tResult.trim()) );
                // console.log( tResult.trim().length );
                    if( dDataLastUpdOn.trim() !== tResult.trim() ){
                        clearInterval(oDOVEventChkNewData);
                        $.ajax({
                            type: "POST",
                            url: "dasDOV/0/0",
                            data: {},
                            cache: false,
                            timeout: 0,
                            success: function(tView) {
                                $('.odvMainContent').html(tView);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxResponseError(jqXHR, textStatus, errorThrown);
                                JCNxCloseLoading();
                            }
                        });
                    }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('jqXHR: ' + jqXHR + ' textStatus: ' + textStatus + ' errorThrown: ' + errorThrown);
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                // JCNxCloseLoading();
            }
        });
    }, <?=REDIS_INTERVAL?>);

    var nBeforeResize = 0;
    $(window).ready(function(){
        // setTimeout(function(){ 
            var w = window,
                d = document,
                e = d.documentElement,
                g = d.getElementsByTagName('body')[0],
                x = w.innerWidth || e.clientWidth || g.clientWidth;
            nBeforeResize = x;
            JSxODSSizeControl();
        // }, 500);
        // console.log('ready');
    });

    $(window).resize(function(){
        JSxODSSizeControl();
        // console.log('resize');
    });

    // Create By : Napat(Jame) 20/04/2021
    function JSxODSSizeControl(){
        var w = window,
            d = document,
            e = d.documentElement,
            g = d.getElementsByTagName('body')[0],
            x = w.innerWidth || e.clientWidth || g.clientWidth,
            y = w.innerHeight || e.clientHeight || g.clientHeight;

        var nFooterHeight   = $('#odvLangEditPanal').outerHeight(true);
        var nHeaderHeight   = $('#odvNavibarClearfixed').outerHeight(true);
        var nContentHeight  = y-nHeaderHeight-nFooterHeight;

        var nMapLabelHeight = $('#odvGraphShwUsageLabel').outerHeight(true);
        var nMapMakerHeight = $('#odvMapMakerExample').outerHeight(true);
        var nMapResize      = nContentHeight - nMapMakerHeight - nMapLabelHeight;

        // console.log('Current: '+x);
        // console.log('nBeforeResize: '+nBeforeResize);

        // console.log(nContentHeight);

        if( x > 960 ){
            // For Desktop
            $('#odvDOVBody').css('height',nContentHeight+'px');
            $('#odvMap').css('height',nMapResize+'px');

            if( nContentHeight > 600 && nContentHeight < 750 ){
                $('#odvDOVTableTop10').css('height','200px');
            }else if( nContentHeight > 750 ){
                $('#odvDOVTableTop10').css('height','360px');
            }else{
                $('#odvDOVTableTop10').css('height','130px');
            }

        }else{
            // For Mobile
            $('#odvDOVBody').css('height','');
            $('#odvMap').css('height','400px');
            $('#odvDOVTableTop10').css('height','200px');
        }

        setTimeout(function(){ 
            var nTop10Height  = $('#odvDOVTop10SaleByValue').outerHeight(true);
            var nAllPosHeight = $('#odvDOVAllPos').outerHeight(true);

            var nChartWidth = $('#odvChart1').innerWidth();
            var nChartHeight = nContentHeight - nTop10Height - nAllPosHeight - 35;
            if( x < 960 ){
                // ถ้าขนาดหน้าจอน้อยกว่า 960 px ให้ขนาดของ chart เป็น 280px
                nChartHeight = parseFloat('280');
            }
            JSxDOVPageChart(nChartWidth,nChartHeight);

        }, 100);

    }

    // Create By : Napat(Jame) 20/04/2021
    function JSxDOVPageChart(pnChartWidth,pnChartHeight){
        $.ajax({
            type: "POST",
            url: "dasDOVPageChart",
            data: {
                pnChartWidth: pnChartWidth,
                pnChartHeight: pnChartHeight
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                
                // $('#oifChartSaleByRegionFrame').width(pnChartWidth+'px');
                // $('#oifChartSaleByRegionFrame').height(pnChartHeight+'px');
                // setTimeout(function(){ 
                //     document.getElementById('oifChartSaleByRegionFrame').contentDocument.location.reload(true);
                //     console.log('re');
                // }, 5000);
                
                // $('#oifChartSaleByPosTypeFrame').width(pnChartWidth+'px');
                // $('#oifChartSaleByPosTypeFrame').height(pnChartHeight+'px');
                // setTimeout(function(){ 
                //     document.getElementById('oifChartSaleByPosTypeFrame').contentDocument.location.reload(true);
                //     console.log('re');
                // }, 5000);

                var aResult = $.parseJSON(oResult);
                $('#odvChartSaleByRegion').html(aResult['oChartSaleByRegion']);
                $('#odvChartSaleByPosType').html(aResult['oChartSaleByPosType']);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

</script>