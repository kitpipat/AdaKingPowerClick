<style>
    .xCNodvContentleft{
        border          : 1px solid #DCE6EB;
        padding         : 20px;
        margin-bottom   : 20px;
    }

    #ospTimeStampDate{
        text-align      : center;
        font-size       : 1.55rem !important;
        font-weight     : bold;
        margin          : 10px;
    }

    #iconClock{
        margin          : 10px 0px;
        display         : block;
        text-align      : right;
    }

    #ospTimeStampTime{
        text-align      : center;
        font-size       : 1.45rem !important;
        font-weight     : bold;
        text-align      : left;
    }

    .xCNBTNTimeStampInput{
        width           : 100%;
        background      : #4ebef6 !important;
        color           : #FFF !important;
        padding         : 6px 0px !important;
        font-size       : 20px;
        margin          : 10px 0px;
    }

    .xCNBTNTimeStampOutput{
        width           : 100%;
        background      : #FFF !important;
        border          : 1px solid #4ebef6 !important;
        color           : black;
        padding         : 6px 0px !important;
        font-size       : 20px;
        margin          : 10px 0px;
    }

    #oliLabelSuccess{
        color           : #449d44;
        font-weight     : bold;
        text-align      : center;
        display         : none;
    }

    #oliLabelError{
        color           : #c9302c;
        font-weight     : bold;
        text-align      : center;
        display         : none;
    }

    #ospMsgSuccess{
        font-size       : 18px !important;
        font-weight     : bold;
    }

    #ospMsgError{
        font-size       : 18px !important;
        font-weight     : bold;
    }

</style>

<div class="panel-body" style="padding-top: 0px !important;"> 
    <div class="row">

        <!-- layout left -->
        <div class="col-lg-3 col-sm-12 xCNodvContentleft panel panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <p id="ospTimeStampDate"> วันจันทร์ , 24 กันยายน 2561 </p>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-xs-5">
                            <span class="lnr lnr-clock" id="iconClock"></span> 
                        </div>
                        <div class="col-lg-7 col-md-7 col-xs-7">
                            <p id="ospTimeStampTime">10:00:00 </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">   

                <!--Hidden Status Input or Output-->
                <input class="form-control" type="hidden" id="oetTimeStampInputorOutput" name="oetTimeStampInputorOutput" value="1">

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('time/timeStamp/timeStamp','tTimeStampNameUser')?> </label>
                        <input class="form-control" type="text" id="oetTimeStampUser" name="oetTimeStampUser" placeholder='<?= language('time/timeStamp/timeStamp','tTimeStampNameUser')?>' >
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('time/timeStamp/timeStamp','tTimeStampPassword')?> </label>
                        <input class="form-control" type="password" id="oetTimeStampPassword" name="oetTimeStampPassword" placeholder='••••••••' onkeypress="Javascript: if (event.keyCode==13) JSxCallInsert()" >
                    </div>
                </div>

                <div class="col-lg-12">
                    <label id="oliLabelSuccess"><span class="lnr lnr-checkmark-circle"></span>  <label id="ospMsgSuccess"> บันทึกข้อมูลสำเร็จ </label></label>
                    <label id="oliLabelError">  <span class="lnr lnr-cross-circle"></span>      <label id="ospMsgError"> บันทึกข้อมูลไม่สำเร็จ </label></label>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" id="obtTimeStampInput" class="btn xCNBTNTimeStampInput"><?= language('time/timeStamp/timeStamp','tTimeStampBTNInput')?></button>
                </div>
                <div class="col-lg-6">
                    <button type="button" id="obtTimeStampOutput" class="btn xCNBTNTimeStampOutput"><?= language('time/timeStamp/timeStamp','tTimeStampBTNOutput')?> </button>
                </div>
            </div>
        </div>
        <!-- end layout left -->

        <!-- layout right -->
        <div class="col-lg-9 col-sm-12">

            <!-- ประวัติ -->
            <div class="panel panel-headline">
                <div class="panel-heading xCNPanelHeadColor">
                    <label><?= language('time/timeStamp/timeStamp','tTimeStampHeadHisInputOutput')?></label>
                </div>
                <div class="panel-body">
                    <div id="odvContentHistoryInputOutput">
                        <!--defeul-->
                        <table id="otbStyDataList" class="table table-striped"> <!-- เปลี่ยน -->
                            <thead>
                                <tr>
                                    <th class="text-center xCNTextBold" style="width:20%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableTime')?></th>
                                    <th class="text-center xCNTextBold" style="width:10%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableCode')?></th>
                                    <th class="text-center xCNTextBold" style="width:20%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableName')?></th>
                                    <th class="text-center xCNTextBold" style="width:10%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableType')?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class='text-center xCNTextDetail2' colspan='5'><?= language('time/timeStamp/timeStamp','tMsgTimeStampNofoundData')?></td>
                                </tr>
                            </tbody>
                        </table>
                        <!--defeul-->
                    </div>
                </div>
            </div>
            <!-- จบประวัติ -->

            <!-- เข้าออกล่าสุด -->
            <div class="panel panel-headline">
                <div class="panel-heading xCNPanelHeadColor">
                    <label><?= language('time/timeStamp/timeStamp','tTimeStampHeadLastInputOutput')?></label>
                </div>
                <div class="panel-body">
                    <div id="odvContentLastInputOutput"></div>
                </div>
            </div>
            <!-- จบเข้าออกล่าสุด -->

        </div>
        <!-- end layout right -->

    </div>
</div>

<?php include "script/jTimeStampMain.php"; ?>
