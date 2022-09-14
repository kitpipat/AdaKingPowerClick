
<base href="<?=base_url('/')?>">

<!-- Overlay Projects -->
<div class="xCNOverlay4Pos">
    <img src="<?php echo base_url() ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
</div>
<style>
    #odvChangepasswordTopBar{
        padding: 10px 20px;
        cursor : pointer;
    }

    #odvChangepasswordTopBar:hover{
        background-color: #fafafa;
    }

    @media screen and (max-width: 767px){
        #odvChangepasswordTopBar{
            padding: 10px 15px !important;
        }
    }

    #oimImgPerson{
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline;
        margin-right: 5px;
        border: 1px solid #d8d8d8;
    }

/* Css Notification */
/* Create By witsarut 04/03/2020 */

    #odvCntMessage {
        display:block;
        position:absolute;
        background:#E1141E;
        color:#FFF;
        font-size:12px;
        font-weight:normal;
        padding:0px 6px;
        margin: 3px 0px 0px 18px;
        border-radius:2px;
        -moz-border-radius:2px; 
        -webkit-border-radius:2px;
        z-index:1;
    }

    #oliContainer {
        position:relative;
    }
   
    #odvNotiMessageAlert {
        display:none;
        width:380px;
        position:absolute;
        top:55px;
        left:-356px;
        background:#FFF;
        border:solid 1px rgba(100, 100, 100, .20);
        -webkit-box-shadow:0 3px 8px rgba(0, 0, 0, .20);
        z-index: 0;
    }

    #odvNotiMessageAlert:before {         
        content: '';
        display:block;
        width:0;
        height:0;
        color:transparent;
        border:10px solid #CCC;
        border-color:transparent transparent #f5f5f5;
        margin-top:-20px;
        margin-left:-800px;
    }
    .xCNShwAllMessage {
        background:#F6F7F8;
        padding:13px;
        font-size:12px;
        font-weight:bold;
        border-top:solid 1px rgba(100, 100, 100, .30);
        text-align:center;
    }

    .xCNShwAllMessage a {
        color:#3b5998;
    }

    .xCNShwAllMessage a:hover {
        background:#F6F7F8;
        color:#3b5998;
        text-decoration:underline;
    }

    .xCNMessageAlert {
        background      : #F6F7F8;
        font-weight     : bold;
        padding         : 15px;
        border          : 1px solid transparent;
        border-radius   : 4px;
    }

    .xCNBlockNoti{
        border      : 1px solid #dedede;
        background  : #fefefe;
        padding     : 10px;
        border-top  : 0px;
    }

</style>
<!-- WRAPPER -->
<div id="wrapper">

    <div id="odvNavibarClearfixed" style="background:#FFFFFF;z-index:500"></div>

    
<style>
    .layout-fullwidth #wrapper .main{
        padding-left: 60px;
    }

    #odvContentWellcome {
        background-image: url('application/modules/common/assets/images/bg/Moshi-Moshi-Backoffice.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        opacity: 0.6 !important;
    }
</style>
<div class="odvMainContent main xWWidth100" style="padding-bottom: 0px;padding-left: 0px;">
    <div class="container-fluid">
        <div class="" id="odvContentWellcome" style="margin:0px 0px; background-color:#FFF;">
        
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/src/jCommon.js')?>"></script>
<script>

$(function(){
$('.xCNOverlay4Pos').delay(5).fadeIn();
$('#wrapper').hide();
$('.navbar').attr('style','');
$('.navbar').hide();
$('#odvNavibarClearfixed').attr('style','').hide();

 var aReslut =  JSxCNCallFunct();

});

 function JSxCNCallFunct(){

   $.ajax({
        url:'<?=base_url('dcmTXFC/0/0')?>',
        type:'post',
        success:function(res){
              $('.main').html(res);
        }
    }).then(function(){
        setTimeout(() => {
            JSvTAXLoadPageAddOrPreview();
        }, 500);
       
    }).done(function(){
        setTimeout(() => {
        $('#wrapper').show();
        $('.xCNOverlay4Pos').delay(10).fadeOut();
         }, 2000);
    });



}


</script>