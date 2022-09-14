<script type="text/javascript">

        var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;

        // call BrowseUsrRole get RoleGrp
        function FSxPADPermissionApvDocAddUsrRole(ptDapRoleGrp){
            var nStaSession  = JCNxFuncChkSessionExpired();
            var tDapRoleGrp = ptDapRoleGrp;
            $('#ohdDapRoleGrp').val('');
            if(tDapRoleGrp != ''){
                $('#ohdDapRoleGrp').val(tDapRoleGrp);
            }
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oRoleOPtion      = undefined;
                oRoleOPtion             = oBrowseRole({
                    'tReturnInputRoleCode'  : 'ohdBnkCode',
                    'tReturnInputRoleName'  : 'oetBnkName',
                    'tNextFuncName'     : 'JSxRptConsNextFuncBrowseUsrRole',
                    'aArgReturn'        : ['FTRolCode','FTRolName']
                });

                JCNxBrowseData('oRoleOPtion');
                // JCNxBrowseData('oRoleOPtion');
            }else{
                JCNxShowMsgSessionExpired();
            }
            
        };
        


        var oBrowseRole = function(poReturnInputRole){
            let tInputReturnRoleCode    = poReturnInputRole.tReturnInputCode;
            let tInputReturnRoleName    = poReturnInputRole.tReturnInputName;
            let tRoleNextFunc           = poReturnInputRole.tNextFuncName;
            let aRoleArgReturn          = poReturnInputRole.aArgReturn;
            let tSesUsrRoleSpcCodeMulti    =  "<?=$this->session->userdata('tSesUsrRoleSpcCodeMulti')?>";
            let nSesUsrBchCount         =  '<?=$this->session->userdata('nSesUsrBchCount')?>';
            let tCondition              = '';
            // ถ้าไม่ใช่ระดับ HQ
            // ไปหา FTRolCode จากตาราง TCNMUsrRoleSpc Where ด้วยสาขาที่ Login
            if(nSesUsrBchCount != 0){
                tCondition += " AND TCNMUsrRole.FTRolCode IN ("+tSesUsrRoleSpcCodeMulti+")";
            }

            let oRoleOptionReturn       = {
                Title : ['authen/role/role','tROLTitle'],
                Table:{Master:'TCNMUsrRole',PK:'FTRolCode'},
                Join :{
                    Table:	['TCNMUsrRole_L'],
                    On:['TCNMUsrRole_L.FTRolCode = TCNMUsrRole.FTRolCode AND TCNMUsrRole_L.FNLngID = '+nLangEdits,]
                },
                Where: {
                    Condition: [
                        tCondition
                    ]
                },
                GrideView:{
                    ColumnPathLang	: 'authen/role/role',
                    ColumnKeyLang	: ['tROLTBCode','tROLTBName'],
                    ColumnsSize     : ['15%','75%'],
                    WidthModal      : 50,
                    DataColumns		: ['TCNMUsrRole.FTRolCode','TCNMUsrRole_L.FTRolName'],
                    DataColumnsFormat : ['',''],
                    Perpage			: 5,
                    OrderBy			: ['TCNMUsrRole.FTRolCode'],
                    SourceOrder		: "ASC"
                },
                NextFunc : {
                    FuncName  : tRoleNextFunc,
                    ArgReturn : aRoleArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: ["ohdBnkCode","TCNMUsrRole.FTRolCode"],
                    Text		: ["oetBnkName","TCNMUsrRole_L.FTRolName"],
                },

            };
            return oRoleOptionReturn;
        }

        function JSxRptConsNextFuncBrowseUsrRole(poDataNextFunc){
            if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            var aDataNextFunc   = JSON.parse(poDataNextFunc);
            tRolCode      = aDataNextFunc[0];
            tRolName      = aDataNextFunc[1];
        }
        let tDapRoleGrp = $('#ohdDapRoleGrp').val();
        //push Data
        $('.xCNNotdetermined'+tDapRoleGrp).html(tRolName);
        $('.xWUsrRole'+tDapRoleGrp).attr( "data-userrole",tRolCode) ;


    }

</script>