<?php
// Fashion Sub Class
$route ['masPDTSubClass/(:any)/(:any)']                     = 'fashion/fashionsubclass/Fashionsubclass_controller/index/$1/$2';
$route ['masSCLPageList']                                   = 'fashion/fashionsubclass/Fashionsubclass_controller/FSvCSCLPageList';
$route ['masSCLPageDataTable']                              = 'fashion/fashionsubclass/Fashionsubclass_controller/FSvCSCLPageDataTable';
$route ['masSCLPageAdd']                                    = 'fashion/fashionsubclass/Fashionsubclass_controller/FSvCSCLPageAdd';
$route ['masSCLEventAdd']                                   = 'fashion/fashionsubclass/Fashionsubclass_controller/FSvCSCLEventAdd';
$route ['masSCLPageEdit']                                   = 'fashion/fashionsubclass/Fashionsubclass_controller/FSvCSCLPageEdit';
$route ['masSCLEventEdit']                                  = 'fashion/fashionsubclass/Fashionsubclass_controller/FSvCSCLEventEdit';
$route ['masSCLEventDelete']                                = 'fashion/fashionsubclass/Fashionsubclass_controller/FSvCSCLEventDelete';


//Fashion Depart
//Create By Worakorn 26/04/2021
$route['fashiondepart/(:any)/(:any)']         = 'fashion/fashiondepart/Fashiondepart_controller/index/$1/$2';
$route['fashiondepartList']                   = 'fashion/fashiondepart/Fashiondepart_controller/FSvCFSDListPage';
$route['fashiondepartDataTable']              = 'fashion/fashiondepart/Fashiondepart_controller/FSvCFSDDataList';
$route['fashiondepartPageAdd']               = 'fashion/fashiondepart/Fashiondepart_controller/FSvFSDAddPage';
$route['fashiondepartEventAdd']              = 'fashion/fashiondepart/Fashiondepart_controller/FSaFSDAddEvent';
$route['fashiondepartPageEdit']              = 'fashion/fashiondepart/Fashiondepart_controller/FSvFSDEditPage';
$route['fashiondepartEventEdit']             = 'fashion/fashiondepart/Fashiondepart_controller/FSaFSDEditEvent';
$route['fashiondepartDeleteMulti']           = 'fashion/fashiondepart/Fashiondepart_controller/FSoFSDDeleteMulti';
$route['fashiondepartDelete']                = 'fashion/fashiondepart/Fashiondepart_controller/FSoFSDDelete';
$route['fashiondepartUniqueValidate/(:any)'] = 'fashion/fashiondepart/Fashiondepart_controller/FStFSDUniqueValidate/$1';


//Fashion Class
//Create By Worakorn 27/04/2021
$route['masPDTClass/(:any)/(:any)']         = 'fashion/fashionclass/Fashionclass_controller/index/$1/$2';
$route['fashionclassList']                   = 'fashion/fashionclass/Fashionclass_controller/FSvCFSCListPage';
$route['fashionclassDataTable']              = 'fashion/fashionclass/Fashionclass_controller/FSvCFSCDataList';
$route['fashionclassPageAdd']               = 'fashion/fashionclass/Fashionclass_controller/FSvFSCAddPage';
$route['fashionclassEventAdd']              = 'fashion/fashionclass/Fashionclass_controller/FSaFSCAddEvent';
$route['fashionclassPageEdit']              = 'fashion/fashionclass/Fashionclass_controller/FSvFSCEditPage';
$route['fashionclassEventEdit']             = 'fashion/fashionclass/Fashionclass_controller/FSaFSCEditEvent';
$route['fashionclassDeleteMulti']           = 'fashion/fashionclass/Fashionclass_controller/FSoFSCDeleteMulti';
$route['fashionclassDelete']                = 'fashion/fashionclass/Fashionclass_controller/FSoFSCDelete';
$route['fashionclassUniqueValidate/(:any)'] = 'fashion/fashionclass/Fashionclass_controller/FStFSCUniqueValidate/$1';

//Fashion Season
//Create By Worakorn 28/04/2021
$route['masPDTSeason/(:any)/(:any)']         = 'fashion/fashionseason/Fashionseason_controller/index/$1/$2';
$route['fashionseasonList']                   = 'fashion/fashionseason/Fashionseason_controller/FSvCFSSListPage';
$route['fashionseasonDataTable']              = 'fashion/fashionseason/Fashionseason_controller/FSvCFSSDataList';
$route['fashionseasonPageAdd']               = 'fashion/fashionseason/Fashionseason_controller/FSvFSSAddPage';
$route['fashionseasonEventAdd']              = 'fashion/fashionseason/Fashionseason_controller/FSaFSSAddEvent';
$route['fashionseasonPageEdit']              = 'fashion/fashionseason/Fashionseason_controller/FSvFSSEditPage';
$route['fashionseasonEventEdit']             = 'fashion/fashionseason/Fashionseason_controller/FSaFSSEditEvent';
$route['fashionseasonDeleteMulti']           = 'fashion/fashionseason/Fashionseason_controller/FSoFSSDeleteMulti';
$route['fashionseasonDelete']                = 'fashion/fashionseason/Fashionseason_controller/FSoFSSDelete';
$route['fashionseasonUniqueValidate/(:any)'] = 'fashion/fashionseason/Fashionseason_controller/FStFSSUniqueValidate/$1';
$route['fashionseasonDataTableChain']           = 'fashion/fashionseason/Fashionseason_controller/FSvCFSSDataListChain';



//Fashion Fabric
//Create By Worakorn 29/04/2021
$route['masPDTFabric/(:any)/(:any)']         = 'fashion/fashionfabric/Fashionfabric_controller/index/$1/$2';
$route['fashionfabricList']                   = 'fashion/fashionfabric/Fashionfabric_controller/FSvCFSFListPage';
$route['fashionfabricDataTable']              = 'fashion/fashionfabric/Fashionfabric_controller/FSvCFSFDataList';
$route['fashionfabricPageAdd']               = 'fashion/fashionfabric/Fashionfabric_controller/FSvFSFAddPage';
$route['fashionfabricEventAdd']              = 'fashion/fashionfabric/Fashionfabric_controller/FSaFSFAddEvent';
$route['fashionfabricPageEdit']              = 'fashion/fashionfabric/Fashionfabric_controller/FSvFSFEditPage';
$route['fashionfabricEventEdit']             = 'fashion/fashionfabric/Fashionfabric_controller/FSaFSFEditEvent';
$route['fashionfabricDeleteMulti']           = 'fashion/fashionfabric/Fashionfabric_controller/FSoFSFDeleteMulti';
$route['fashionfabricDelete']                = 'fashion/fashionfabric/Fashionfabric_controller/FSoFSFDelete';
$route['fashionfabricUniqueValidate/(:any)'] = 'fashion/fashionfabric/Fashionfabric_controller/FStFSFUniqueValidate/$1';


//Fashion group4
//Create By most 12/05/2021
$route['masPDTGroup/(:any)/(:any)']         = 'fashion/fashiongroup/Fashiongroup_controller/index/$1/$2';
$route['fashiongroupList']                   = 'fashion/fashiongroup/Fashiongroup_controller/FSvCFSGListPage';
$route['fashiongroupDataTable']              = 'fashion/fashiongroup/Fashiongroup_controller/FSvCFSGDataList';
$route['fashiongroupPageAdd']               = 'fashion/fashiongroup/Fashiongroup_controller/FSvFSGAddPage';
$route['fashiongroupEventAdd']              = 'fashion/fashiongroup/Fashiongroup_controller/FSaFSGAddEvent';
$route['fashiongroupPageEdit']              = 'fashion/fashiongroup/Fashiongroup_controller/FSvFSGEditPage';
$route['fashiongroupEventEdit']             = 'fashion/fashiongroup/Fashiongroup_controller/FSaFSGEditEvent';
$route['fashiongroupDeleteMulti']           = 'fashion/fashiongroup/Fashiongroup_controller/FSoFSGDeleteMulti';
$route['fashiongroupDelete']                = 'fashion/fashiongroup/Fashiongroup_controller/FSoFSGDelete';
$route['fashiongroupUniqueValidate/(:any)'] = 'fashion/fashiongroup/Fashiongroup_controller/FStFSGUniqueValidate/$1';


//Fashion group5
//Create By most 12/05/2021
$route['masPDTComLines/(:any)/(:any)']      = 'fashion/fashioncomlines/Fashioncomlines_controller/index/$1/$2';
$route['fashioncomlinesList']                  = 'fashion/fashioncomlines/Fashioncomlines_controller/FSvCFSCListPage';
$route['fashioncomlinesDataTable']             = 'fashion/fashioncomlines/Fashioncomlines_controller/FSvCFSCDataList';
$route['fashioncomlinesPageAdd']               = 'fashion/fashioncomlines/Fashioncomlines_controller/FSvFSCAddPage';
$route['fashioncomlinesEventAdd']              = 'fashion/fashioncomlines/Fashioncomlines_controller/FSaFSCAddEvent';
$route['fashioncomlinesPageEdit']              = 'fashion/fashioncomlines/Fashioncomlines_controller/FSvFSCEditPage';
$route['fashioncomlinesEventEdit']             = 'fashion/fashioncomlines/Fashioncomlines_controller/FSaFSCEditEvent';
$route['fashioncomlinesDeleteMulti']           = 'fashion/fashioncomlines/Fashioncomlines_controller/FSoFSCDeleteMulti';
$route['fashioncomlinesDelete']                = 'fashion/fashioncomlines/Fashioncomlines_controller/FSoFSCDelete';
$route['fashioncomlinesUniqueValidate/(:any)'] = 'fashion/fashioncomlines/Fashioncomlines_controller/FStFSCUniqueValidate/$1';
