<style>
    .xCNPanelSwitchLang {
        width           : 100%;
        height          : 70px;
        border-bottom   : 1px solid #efefef;
        padding         : 10% 10%;
        cursor          : pointer;
    }

    .xCNPanelSwitchLang:last-child {
        border-bottom   : 1px solid transparent;
    }

    .xCNPanelSwitchLang > label {
        font-weight     : bold;
        cursor          : pointer;
    }

    .xCNActivePanel{
        background-color: #efefef;
    }

    .xCNSwitchLangBorderLineActive{
        border          : 1.5px solid #222b3c;
        border-radius   : 100px;
        margin-top      : -8px;
        width           : 40%;
    }

    .xCNPanelSwitchLang > label:after {
        display         :   block;
        content         : '';
        border-bottom   : solid 3px #222b3c;  
        transform       : scaleX(0);  
        transition      : transform 250ms ease-in-out;
    }
    .xCNPanelSwitchLang > label:hover:after { transform: scaleX(1); }
    .xCNPanelSwitchLang > label.fromLeft:after{  transform-origin:  0% 50%; }

    .xCNMoreIconActive{
        float       : right;
        color       : #222b3c;
        font-size   : 20px !important;
        margin      : 0px -10px;
        font-family : cursive;
    }


    .xCNSwitchLangLineCenter{
        width       : 1px;
        background  : #efefef;
        height      : 100%;
        position    : absolute;
        margin-left : 25%;
    }

    
</style>

<div class="modal-header xCNModalHead">
    <h3 style="font-size:20px;color:#FFF;font-weight: 1000;">
        <?= language('common/main/main', 'tLangSystemsETC') ?>
    </h3>
</div>
<div class="modal-body" style="padding: 0px;">


    <div class="row" style="margin: 0px;">
        <!--session ซ้าย พวกภาษาทั้งหมด-->
        <div class="col-lg-3 col-md-3" style="padding: 0px;">
            <?php 

                $nLangLogin = $nLangLogin;
                for($i=0; $i<FCNnHSizeOf($aGetSysLang); $i++){
                    if($nLangLogin == 1 && $aGetSysLang[$i]['FNLngID'] == 1){
                        $tClassDivActive = 'xCNActivePanel';
                    }else{
                        $tClassDivActive = '';
                    }
                    echo '<div class="xCNPanelSwitchLang '.$tClassDivActive.'" data-activelang='.$aGetSysLang[$i]['FNLngID'].' id="odvLang'.$aGetSysLang[$i]['FNLngID'].'" ">
                            <a data-toggle="tab" href="#odvTabSwitchLang'.$aGetSysLang[$i]['FNLngID'].'"></a>
                            <label class="xCNTextUnderline fromLeft">'.$aGetSysLang[$i]['FTLngName'].' ( ' . $aGetSysLang[$i]['FTLngShortName'] . ' ) </label><label class="xCNMoreIcon" id="odvIconLang'.$aGetSysLang[$i]['FNLngID'].'"> </label>
                            <div class="xCNSwitchLangBorderLine" id="odvLineLang'.$aGetSysLang[$i]['FNLngID'].'"></div>
                         </div>';
                }
            ?>
        </div>

        <!--เส้นคั่นกลาง-->
        <div class='xCNSwitchLangLineCenter'></div>

        <!--session ขวา พวกข้อมูล-->
        <div class="col-lg-9 col-md-9">
            <div>
                <div class="tab-content">
                    <?php
                        $nKeyLang = 1;

                        //Loop แรกสำหรับสร้าง TAB
                        for($j=0; $j<FCNnHSizeOf($aGetSysLang); $j++){
                            if($nKeyLang == 1){
                                $tClassOpenPanel = 'in active';
                            }else{
                                $tClassOpenPanel = '';
                            }
                            echo '<div id="odvTabSwitchLang'.$nKeyLang.'" class="xCNTabPanel tab-pane fade'.$tClassOpenPanel.'" style="padding:10px 15px;">';
                            
                                //Loop สองสำหรับเอาฟิวส์มาสร้าง input
                                for($i=0; $i<FCNnHSizeOf($aPackFiled); $i++){

                                    if((stripos($aPackFiled[$i], "Code"))){
                                        echo    '<input type="hidden" name="ohdFiledPK[]" value="'.$aPackFiled[$i].'" >';
                                    }

                                    if ((stripos($aPackFiled[$i], "Code") !== false) || 
                                        (stripos($aPackFiled[$i], "LngID") !== false) ) {
                                        // echo    "ไม่ ต้อง มี in put";
                                    }else if(stripos($aPackFiled[$i], "Rmk") !== false){
                                        echo    '<div class="form-group">
                                                    <label class="xCNLabelFrm">'.language('product/product/product','tPDTRmk').'</label>
                                                    <textarea class="form-control xCNKeyUpSwitchLang" data-filedcode="'.$aPackFiled[$i].'" data-keylang="'.$nKeyLang.'" maxlength="200" rows="4" name="oetInputText'.$nKeyLang.'[]"></textarea>
                                                </div>';
                                    }else{
                                        $tLabelInput    =   language('common/switch','LANG_'.$aPackFiled[$i]);
                                        $tPlaceholder   =   language('common/switch','LANG_'.$aPackFiled[$i]);
                                        echo    '<div class="form-group">
                                                    <label class="xCNLabelFrm"><span style="color:red"></span> '.$tLabelInput.'</label>
                                                    <input type="text" class="form-control xCNKeyUpSwitchLang" data-filedcode="'.$aPackFiled[$i].'" data-keylang="'.$nKeyLang.'" maxlength="100" name="oetInputText'.$nKeyLang.'[]" value="" placeholder="'.$tPlaceholder.'" autocomplete="off">
                                                </div>';
                                    }
                                }

                            echo '</div>';
                            $nKeyLang++;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn xCNBTNPrimery xCNBTNDefult2Btn xWBtnOK" type="button" data-dismiss="modal" onClick="JSaGetDataSwitchLang()">
        <?php echo language('common/main/main', 'tCMNOK') ?>
    </button>
    <button class="btn xCNBTNDefult xCNBTNDefult2Btn xWBtnCancel" type="button" data-dismiss="modal">
        <?php echo language('common/main/main', 'tCancel') ?>
    </button>
</div>


<script>
    var nLangLogin      = '<?= $nLangLogin; ?>';
    var nCountLangAll   = '<?=FCNnHSizeOf($aGetSysLang)?>';
    var tTable_L       = '<?=$Table_L;?>';                   


    //เข้ามาครั้งแรก
    $('.xCNActivePanel').addClass('xCNActivePanel');
    $('.xCNActivePanel').find('.xCNMoreIcon').addClass('xCNMoreIconActive');
    $('.xCNActivePanel').find('.xCNMoreIcon').text('>');
    $('.xCNActivePanel').find('.xCNSwitchLangBorderLine').addClass('xCNSwitchLangBorderLineActive');

    //Event เลือกภาษา
    $('.xCNPanelSwitchLang').click(function() {
        //ส่วนของการเปิด TAB
        var tActiveLang = $(this).attr('data-activelang');
        $('.xCNTabPanel').removeClass('in');
        $('.xCNTabPanel').removeClass('active');
        $('#odvTabSwitchLang'+tActiveLang).addClass('in');
        $('#odvTabSwitchLang'+tActiveLang).addClass('active');
        //จบส่วนของการเปิด TAB

        //ส่วนของขีดเส้นใต้ และ icon - removeclass
        $('.xCNPanelSwitchLang').removeClass('xCNActivePanel');
        $('.xCNMoreIcon').removeClass('xCNMoreIconActive');
        $('.xCNMoreIcon').text('');
        $('.xCNSwitchLangBorderLine').removeClass('xCNSwitchLangBorderLineActive');
        //จบส่วนขีดเส้นใต้ และ icon - removeclass

        //ส่วนของขีดเส้นใต้ และ icon - addclass
        var nWidthText = $(this).find('.xCNTextUnderline').width();
        $(this).addClass('xCNActivePanel');
        $(this).find('.xCNMoreIcon').addClass('xCNMoreIconActive');
        $(this).find('.xCNMoreIcon').text('>');
        $(this).find('.xCNSwitchLangBorderLine').addClass('xCNSwitchLangBorderLineActive');
        //จบส่วนของขีดเส้นใต้ และ icon - addclass
    });


    //Event กรอกข้อมูล 
    $('.xCNKeyUpSwitchLang').change(function() {
        // var nValue      = $(this).val();
        // var tID         = $(this).attr('data-filedcode');
        // var tKeyLang    = $(this).attr('data-keylang');
        // var tFiledPK    = $('input[name^="ohdFiledPK"]').val();

        // var resultObject = search(tID , nValue , aPackDataLang);
        // console.log('เจอไหม : ' + resultObject);

        // if(resultObject == 'FOUND'){
        //     var removeIndex = aPackDataLang.map(function(item) { return item.ID; }).indexOf(37);
        //     apps.splice(removeIndex, 1);
        // }

        // var aDataPure = {
        //         'FiledPK'   : tFiledPK,
        //         'LANG'      : tKeyLang,
        //         'TABLE'     : tTable_L,
        //         'ID'        : tID,
        //         'VALUE'     : nValue
        //     };
        //     aPackDataLang.push(aDataPure);
    });

    //กด save
    var aResult         = [];
    function JSaGetDataSwitchLang(){
        aPackDataLang   = [];
        aDataPure       = [];
        var tFiledPK    = $('input[name^="ohdFiledPK"]').val();
        for(k=1; k<=nCountLangAll; k++){
            $('input[name^="oetInputText'+k+'"]').each(function(){
                var nKeyLang    = $(this).attr('data-keylang');
                var tID         = $(this).attr('data-filedcode');
                var nValue      = $(this).val();

                var aDataPure = {
                    'LANG'    : nKeyLang,
                    'FiledPK' : tFiledPK,
                    'TABLE'   : tTable_L,
                    'ID'      : tID,
                    'VALUE'   : nValue
                };
                aResult.push(aDataPure);
            });

            aPackDataLang.push({'LANG' : k , 'RESULT' : aResult });
        }
        



        console.log('-RESULT-');
        console.log(aPackDataLang);
        console.log('-END-');
        // if(aPackDataLang.length != 0){
        //     aPackDataLang.sort(compare);  
        // }

        // // aPackDataLang.find(findObjectInArray,)
        // console.log(aPackDataLang);
    }

    function search(tID , nVal , myArray){
        for (var i=0; i < myArray.length; i++) {
            if (myArray[i].ID === tID && myArray[i].VALUE === nVal) {
                myArray.splice(i, 1);
                return 'FOUND';
            }
        }
    }

    //ฟังก์ชั่น sort array 
    function compare(a, b) {
        const LANGA = a.LANG.toUpperCase();
        const LANGB = b.LANG.toUpperCase();

        let comparison = 0;
        if (LANGA > LANGB) {
            comparison = 1;
        } else if (LANGA < LANGB) {
            comparison = -1;
        }
        return comparison;
    }

</script>