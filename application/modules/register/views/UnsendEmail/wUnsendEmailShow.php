<!doctype html>
<html lang="th" class="fullscreen-bg">

<head>
    <title>ข้อกำหนดการรับข่าวสาร</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>application/modules/common/assets/images/AdaLogo.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>application/modules/common/assets/images/AdaLogo.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/authen/assets/css/localcss/ada.login.css">


    <!-- Javascript -->
    <input type="hidden" id="ohdBaseURL" name="ohdBaseURL" value="<?php echo base_url(); ?>">
    <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/jquery3.5.1.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/dataTables.scroller.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/scroller.dataTables.min.css">


    <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/PasswordAES128/aes.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/PasswordAES128/cAES128.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/PasswordAES128/AESKeyIV.js"></script>

</head>

<style>
    body {
        font-family: THSarabunNew !important;
    }

    .xWLoginBox {
        border-radius: 5px !important;
    }

    div.container {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -100px;
        margin-left: -580px;
    }

    .xWLoginBox {
        -webkit-box-shadow: 0px 0px 105px -23px rgba(0, 0, 0, 1);
        -moz-box-shadow: 0px 0px 105px -23px rgba(0, 0, 0, 1);
        box-shadow: 0px 0px 43px -25px rgba(0, 0, 0, 1)
    }

    li {
        display: inline-block;
        list-style-type: none;
        margin-right: -4px;
        padding: 10px;
        cursor: pointer;
    }


    .active {
        color: #0081c2;
    }

    .avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
    }

    .xCNThumbnail img {
        width: 130px;
        height: 130px;
        margin: 16px auto;
        display: block;
        object-fit: cover;
        border-radius: 50%;

    }

    .table tbody tr,
    .table>tbody>tr>td {
        color: #232C3D !important;
        font-size: 18px !important;
    }

    .xCNBTNDefult {
        font-size: 18px !important;
        font-weight: normal !important;
    }




    .xWCtlBtn {
        border-radius: 20px !important;
        background-color: #ffffff !important;
        border-color: #0081c2 !important;
        width: 100% !important;
        height: 40px !important;
    }

    .xWCtlBtn :hover {
        color: #0081c2 !important;
    }

    .xWCtlForm {
        border-radius: 20px !important;
    }
</style>

<body class="xCNBody layout-fullwidth  xWUnSubShow">

    <input name="ohdbaseurlunsub" id="ohdbaseurlunsub" type="hidden" value="<?php echo base_url(); ?>">


    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel" style="border-top-left-radius: 6px;border-top-right-radius: 6px;">
                    <div class="panel-heading" style="background-color: #222b3c;border-top-left-radius: 6px;border-top-right-radius: 6px;">
                        <label class="panel-title" style="color: white; font-size:19; font-weight:bold;">ยืนยันยกเลิกการรับข่าวสาร</label>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" name="ofmUnsendEmail" id="ofmUnsendEmail">
                            <fieldset>
                                <div class="form-group">
                                    <label>อีเมล์</label>
                                    <input class="form-control" name="oetUnsendEmailCstEmailShow" id="oetUnsendEmailCstEmailShow" type="text" disabled>


                                    <input name="oetUnsendEmailCstEmail" id="oetUnsendEmailCstEmail" type="hidden">
                                    <input name="oetUnsendEmailCstEmailURL" id="oetUnsendEmailCstEmailURL" type="hidden" value="<?php echo $tEmail; ?>">

                                </div>
                                <div>
                                    <hr>
                                </div>
                                <div style="padding:0" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <button   type="button" onclick="JSxUEMSubmit()" id="obtUnsendEmailSubmit" class="btn xWCtlBtn"><span style="color:#0081c2;"><?php echo language('common/main/main', 'tCMNConfirm') ?></span></button>
                                </div>
                            </fieldset>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




</body>

</html>



<script src="<?php echo base_url('application/modules/register/assets/src/UnsendEmail/jUnsendEmail.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jCommon.js') ?>"></script>