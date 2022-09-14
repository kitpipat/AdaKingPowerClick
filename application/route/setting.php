<?php

// ตั้งค่าการใช้งานฟังก์ชัน (Function Setting)
$route ['funcSetting/(:any)/(:any)'] = 'setting/func_setting/cFuncSetting/index/$1/$2';
$route ['funcSettingGetSearchList'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingSearchList';
$route ['funcSettingGetEditPage'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingEditPage';
$route ['funcSettingGetDataTableHD'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingGetDataTableInHD';
$route ['funcSettingGetDataTableTemp'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingGetDataTableInTemp';

$route ['funcSettingInsertDTToTmp'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingInsertDTToTemp';
$route ['funcSettingUpdateFuncInTmp'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingUpdateFuncInTmp';
$route ['funcSettingUpdateFuncAllInTmp'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingUpdateFuncAllInTmp';
$route ['funcSettingSaveEvent'] = 'setting/func_setting/cFuncSetting/FSxCFuncSettingSaveEvent';
