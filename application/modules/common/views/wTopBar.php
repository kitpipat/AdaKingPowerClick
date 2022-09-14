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

    .xWImgPerson {
        width: 30px !important;
        height: 30px !important;
        border-radius: 50% !important;
        display: inline !important;
        margin-right: 5px !important;
        border: 1px solid #d8d8d8 !important;
    }

    .xWImgLogo {
        padding: 5px !important;
        width: auto !important;
        height: 50px !important;
        margin: -8px !important;
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
/* -----------------------------------------
   Badge
----------------------------------------- */

.badge{
    /* padding: 3px 5px 2px; */
    position: absolute;
    top: 3px;
    right: 7px;
    display: inline-block;
    min-width: 10px;
    font-size: 12px;
    font-weight: bold;
    color: #ffffff;
    line-height: 1;
    vertical-align: baseline;
    white-space: nowrap;
    text-align: center;
    border-radius: 120px;
}
.badge-danger {
    background-color: #7795d6;
}


.notifications {
   min-width:420px; 
  }
  
  .notifications-wrapper {
     overflow-y:auto;
      max-height:250px;
    }
    
 .menu-title {
    color:#2c82b6;
    display:inline-block;
    font-family: THSarabunNew;
    font-size: 18px !important;
    font-weight: 500;
      }
 
.glyphicon-circle-arrow-right {
      margin-left:10px;     
   }
  
   
 .notification-heading, .notification-footer  {
 	padding:2px 10px;
       }
      
        
.dropdown-menu.divider {
  margin:5px 0;          
  }

.item-title {
font-family: THSarabunNew;
font-size: 18px !important;
font-weight: 500;
color:#000;
    
}

.notifications a.content {
 text-decoration:none;
 background:#ccc;

 }
    
.notification-item {
 padding:10px;
 margin:5px;
 background:#7795d64f;
 border-radius:4px;
 }
 .notification-item:hover {
 padding:10px;
 margin:5px;
 background:#F6F7F8;
 border-radius:4px;
 }
</style>
<div id="wrapper">
    <input type="hidden" id="ohdUsrCode" value="<?=$this->session->userdata('tSesUserCode')?>" >

    <!--ถ้ามาจาก font จะไม่ต้องแสดง bar -->
    <?php if($this->session->userdata("tStaByPass") != 1){ ?>
        <nav class="navbar navbar-default navbar-fixed-top" style="margin-left: 60px;">
            <div class="container-fluid">
                <div class="brand">
                    <a href="<?php echo base_url();?>" >
                        <?php echo FCNtHGetImagePageList('','30px','logo','xWImgLogo'); ?>
                        <!-- <img id="oimCompanyImage" src="<?php echo base_url();?>application/modules/common/assets/images/logo/AdaPos5_Logo.png" alt="AdaFC Logo" class="img-responsive logo" style="padding:5px;width: auto;height: 50px;margin:-8px;"> -->
                    </a>
                    <a href="<?php echo base_url();?>" >
                        <div style="padding:5px;margin:-8px;position:absolute;top:25%;left:35%;margin-left:-100px;width:40%;text-align: center;"><span id="spnCompanyName"></span></div>
                    </a>
                </div>
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" style="margin-left: 20px;">
                        <li class="dropdown">
                            <?php //FCNxHNotifications(); ?>
                            <?php echo FCNtHGetImagePageList($this->session->userdata('tSesUsrImagePerson'),'30px','user','xWImgPerson'); ?>
                            <?php /*if($this->session->userdata('tSesUsrImagePerson') == null){*/ ?>
                                <!-- ไม่มีภาพ -->
                                <!-- <?php $tPatchImg = base_url().'application/modules/common/assets/images/icons/Customer.png'; ?>
                                <img id="oimImgPerson" style="border: 0px !important;" class="img-responsive" src="<?php echo @$tPatchImg;?>"> -->
                            <?php 
                                // }else{
                                // $tImage = $this->session->userdata('tSesUsrImagePerson'); 
                                // $tImage = explode("application/modules",$tImage);
                                // $tPatchImg = base_url('application/modules/').$tImage[1];
                            ?>
                                <!-- <img id="oimImgPerson" class="img-responsive" src="<?=$tPatchImg?>">     -->
                            <?php /*}*/ ?>  
                            <button  class="dropdown-toggle" data-toggle="dropdown" style="color: white;margin-top: 10px;margin-right: 10px;"><a><span><?php echo $this->session->userdata('tSesUsrUsername') ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a></button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a style="cursor: pointer;" onclick="JSxGotoPageUser()">
                                        <i class="lnr lnr-user"></i> <span><?php echo language('common/main/main','tMNUProfile')?></span>
                                    </a>
                                </li>
                                <li>
                                    <div id="odvChangepasswordTopBar" onClick="JCNxCallModalChangePassword(1,<?php echo $this->session->userdata("tSesUsrInfo")['FTUsrLogType']; ?>);">
                                        <i class="lnr lnr-cog" style="vertical-align: middle;"></i>
                                        <span><?php echo language('common/main/main','tMNUChangePassword')?></span>
                                    </div>
                                </li>
                                <li>
                                    <a href="logout">
                                        <i class="lnr lnr-exit"></i> <span><?php echo language('common/main/main','tMNULogout')?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                                    
                    <ul class="nav navbar-nav navbar-right <?php if(!$this->session->userdata("bSesAlwNoti")){ echo "xCNHide"; } ?>" >
                        <li class="dropdown">
                        <a href="#" onclick="return false;" role="button" data-toggle="dropdown" id="notification" data-target="#" style="float: left" aria-expanded="true">
                        <i class="fa fa-bell-o" style="font-size: 20px; float: left; color: black">
                                </i>
                            </a>
                            <span class="badge badge-danger" id="ospNTFQty"></span>
                    
                                <ul class="dropdown-menu notifications" role="menu" aria-labelledby="notification" style="min-width: 350px;">
                   
                                    <div class="notifications-wrapper" id="odvNTFContent">
                                    <div class="notification-item">
                                    <h4 class="item-title text-center"><?php echo language('common/main/main','tMainRptNotFoundDataInDB')?></h4>
                                    </div>

                                    </div>
                                    <li class="divider"></li>
                                    <div class="notification-footer dropbtn" align="center" onclick="JCNxNTFJumpDocPageEdit('','mntDocSta/2','','')"><h4 class="menu-title"><?php echo language('common/main/main','tSeeAll')?> <i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div>
                                </ul>

                        </li>
                    </ul>


                    <ul class="nav navbar-nav navbar-right <?php if(!$this->session->userdata("bSesAlwNews")){ echo "xCNHide"; } ?>">
                        <li class="dropdown">
                        <a href="#" onclick="return false;" role="button" data-toggle="dropdown" id="notification" data-target="#" style="float: left" aria-expanded="true">
                        <i class="fa fa-envelope-o" style="font-size: 20px; float: left; color: black">
                                </i>
                            </a>
                            <span class="badge badge-danger" id="ospNEWQty"></span>
                    
                                <ul class="dropdown-menu notifications" role="menu" aria-labelledby="notification" style="min-width: 350px;">
                                    <div class="notifications-wrapper" id="odvNEWContent">
                                    <div class="notification-item">
                                    <h4 class="item-title text-center"><?php echo language('common/main/main','tMainRptNotFoundDataInDB')?></h4>
                                    </div>

                                    </div>
                                    <li class="divider"></li>
                                    <div class="notification-footer dropbtn" align="center" onclick="JCNxNTFJumpDocPageEdit('','mntNewSta/2','','')"><h4 class="menu-title"><?php echo language('common/main/main','tSeeAll')?> <i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div>
                                </ul>

                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <div id="odvNavibarClearfixed" style="background:#FFFFFF;z-index:500"></div>
    <?php } ?>

 <script>
     /////////////////////////////////////////////////////////////////////////////////////////////////////
    function JSxGotoPageUser(ptUsrCode){
        JCNxOpenLoading();
        $.ajax({
            type    : "GET",
            url     : "user/2/0",
            cache   : false,
            timeout : 5000,
            success : function (tResult) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tResult);
                //JSvCallPageUserEdit(ptUsrCode);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
    $(document).ready(function(){

        JSxGetNameCompany();
        var tSesAlwNoti = $('#ohdSesAlwNoti').val();
        var tSesAlwNews = $('#ohdSesAlwNews').val();
        if( tSesAlwNoti == '1' || tSesAlwNews == '1' ){
            JCNxNTFCallPrcNotifocation();
        }
        // JCNxNTFGetDataNotifocation();
        // ถ้าไม่มีรูปภาพอยู่ในโฟลเดอร์ ให้ใช้รูปภาพสแตนดาสของ AdaPos5 Logo
        // $('#oimCompanyImage').error(function() {
        //     var tLogoImage = "<?php echo base_url();?>"+"/application/modules/common/assets/images/logo/AdaPos5_Logo.png";
        //     var tLogoName  = "AdaFC Logo";
        //     $('#oimCompanyImage').attr('src',tLogoImage);
        //     $('#oimCompanyImage').attr('alt',tLogoName);
        // });

    });
    
    $('.dropdown').on('click',function(){
        setTimeout(() => {
            $('.notifications-wrapper').scrollTop(0);
        }, 25);
    });
    // call Company
    function JSxGetNameCompany(){
        $.ajax({
            type: "GET",
            url: "companyEventGetName",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturn    = JSON.parse(tResult);
                var tLogoName  = aReturn['raItems']['FTLogoName'];
                var tLogoImage = aReturn['raItems']['FTLogoImage'];
                console.log(tLogoImage);
                if( tLogoImage != "NULL" && tLogoImage != null && tLogoImage != "" ){
                //     var aLogoImage = tLogoImage.split("/application");
                //     tLogoImage = "<?php echo base_url(); ?>" + "/application" + aLogoImage[1];
                    $('.xWImgLogo').attr('src',tLogoImage);
                    $('.xWImgLogo').attr('alt',tLogoName);
                }
                $('#spnCompanyName').html(tLogoName);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                (jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>
<?php include('application/modules/common/views/script/jChangePassword.php'); ?>