<?php 

//Event Hall
$route ['eventhall/(:any)/(:any)']       = 'eventhall/eventhall/cEventhall/index/$1/$2';
$route ['EventhallSearchList']           = 'eventhall/eventhall/cEventhall/FSxCEVNTHFormSearchList';
$route ['EventHallDataTable']            = 'eventhall/eventhall/cEventhall/FSvCEVNTHCallPageDataTable';