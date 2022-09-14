<?php
$route ['timeStamp/(:any)/(:any)']                  = 'time/timeStamp/cTimeStamp/index/$1/$2';
$route ['timeStampMainpage']                        = 'time/timeStamp/cTimeStamp/FSvTimeStampMainpage';
$route ['timeStampMainInsert']                      = 'time/timeStamp/cTimeStamp/FSvTimeStampInsert';
$route ['timeStampMainGetHistoryCheckinCheckout']   = 'time/timeStamp/cTimeStamp/FSvTimeStampGetHistoryCheckinCheckout';
$route ['timeStampMainGetLastCheckinCheckout']      = 'time/timeStamp/cTimeStamp/FSvTimeStampGetLastCheckinCheckout';
$route ['timeStampMainGetDetail']                   = 'time/timeStamp/cTimeStamp/FSvTimeStampGetDetail';
$route ['timeStampMainGetDetailDataTable']          = 'time/timeStamp/cTimeStamp/FSvTimeStampGetDataTable';
$route ['timeStampMainUpdate']                      = 'time/timeStamp/cTimeStamp/FSvTimeStampUpdateinline';