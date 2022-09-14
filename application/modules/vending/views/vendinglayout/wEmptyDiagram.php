<style>

    .xCNDivContentCenter{
        margin          : 0;
        position        : absolute;
        top             : 50%;
        left            : 50%;
        -ms-transform   : translate(-50%, -50%);
        transform       : translate(-50%, -50%);
    }

    .ospPleaseCabinet{
        font-size   : 40px !important;
        text-align  : center;
        color       : #d1d1d1;
        display     : block;
    }

    .xCNImgVending{
        opacity     : 0.5;
        width       : 150px;
        text-align  : center;
        display     : block;
        margin      : 20px auto;
    }
</style>

<div class="xCNDivContentCenter">
    <img class="xCNImgVending" src="<?=base_url().'/application/modules/common/assets/images/icons/VendingEmpty.png'?>">
    <span class="ospPleaseCabinet"> <?=language('vending/vendingshoplayout/vendingmanage', 'tVendingPleaseInsertPanelLeft')?> </span>
</div>