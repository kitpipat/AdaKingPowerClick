<style>
    .xWSetting{
        background-color    : transparent; 
        float               : right;
    }

    .xWDivSetting{
        vertical-align      : middle; 
        display             : inline;
    }

    #xWLabelSetting{
        margin              : 0px !important;
        padding-right       : 5px;
        font-weight         : bold;
        font-size           : 20px !important;
    }

    .xWIconTable{
        height              : 30px;
        width               : 30px;
    }

    .xWDivInsert{
        box-shadow          : 0 1px 2px rgba(0, 0, 0, 0.08);
        background-color    : #fff;
        width               : 100%; 
        border              : 1px solid #efefef; 
        max-width           : 430px;
        margin              : 20px auto;
    }

    .xWDivInsert:hover{
        background-color    : #e2e3e4;
        cursor              : pointer;
    }

    #xWFontIconInsert{
        text-align          : center;
        display             : block;
        font-family         : THSarabunNew;
        font-size           : 90px !important;
        font-weight         : 500;
    }

    #xWFontTextInsert{
        text-align          : center;
        display             : block;
        font-family         : THSarabunNew;
        font-size           : 35px !important;
        font-weight         : 500;
        margin-bottom       : 20px;
    }

</style>

<!--ปุ่มตรงกลาง-->
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4"> 
        <div class="xWDivInsert" onclick="JSxSettingVendingLayout('INSERT')">
            <span id="xWFontIconInsert"> + </span>
            <span id="xWFontTextInsert"><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingInsert')?></span>
        </div>
    </div>
    <div class="col-lg-4"></div>
</div>