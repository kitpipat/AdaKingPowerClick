if(typeof DrillDown == "undefined")
{
    function DrillDown(name,options)
    {
        this.name = name;
        this.options = options;
        this.init();
    }
    DrillDown.prototype = {
        name:null,
        options:null,
        level:null,
        titles:null,
        events:null,
        init:function()
        {
            this.level = 0;
            this.titles = [];
            this.events = {};
            for(var i=0;i<this.options.totalLevels;i++)
            {
                this.titles.push(null);
            }
            $('#'+this.name+' .btnBack').attr('disabled','disabled');
        },
        next:function(params)
        {
            if(this.level<this.options.totalLevels-1)
            {
                var _data = {};
                _data[this.name] = {
                    partialRender:true,
                    currentLevel:[this.level+1,params],
                    scope:this.options.scope,
                };

                if(this.fireEvent("nexting",_data))
                {
                    this.level++;
                    $.ajax({
                        method:"POST",
                        data:_data,
                    }).done(function(content){
                        var start_mark = "<!--drilldown-partial-start-->";
                        var end_mark = "<!--drilldown-partial-end-->";
                        content = content.substring(content.indexOf(start_mark)+start_mark.length,content.indexOf(end_mark));
                        $('#'+this.name+' .drilldown-level').hide();
                        $('#'+this.name+' .drilldown-level-'+this.level).html(content).show();
                        $('#'+this.name+' .btnBack').attr('disabled',(this.level>0)?false:'disabled');
                        this.fireEvent("nexted",{level:this.level});
                        this.fireEvent("changed",{level:this.level});
                    }.bind(this)).fail(function(e){
                        console.log(e);
                    });    
                }

            }
        },
        levelTitle:function(title,level=null)
        {
            if(level==null)
            {
                level = this.level;
            }
            this.titles[level] = title;
            this.renderLevelTitles();
        },
        renderLevelTitles:function()
        {
            $('#'+this.name+' .breadcrumb').empty();
            for(var i=0;i<this.level;i++)
            {
                $('#'+this.name+' .breadcrumb').append("<li><a href='javascript:"+this.name+".back("+i+")'>"+this.titles[i]+"</a></li>");
            }
            $('#'+this.name+' .breadcrumb').append("<li><span class='drilldown-clevel-title'>"+this.titles[this.level]+"</span></li>")
        },
        back:function(level=null)
        {
            if(level==null)
            {
                level = this.level-1;
            }
            if(level>=0 && level<this.level)
            {
                if(this.fireEvent("backing",{level:level}))
                {
                    $('#'+this.name+' .drilldown-level-'+this.level).hide();
                    $('#'+this.name+' .drilldown-level-'+level).show();
                    this.level = level;
                    $('#'+this.name+' .btnBack').attr('disabled',(this.level>0)?false:'disabled');
                    this.renderLevelTitles();
                    this.fireEvent("backed",{level:level});
                    this.fireEvent("changed",{level:this.level});
                }
            }        
        },
        on:function(name,func){
            if(typeof this.events[name] == "undefined")
            {
                this.events[name] = [];
            }
            this.events[name].push(func);
        },
        fireEvent:function(name,params)
        {
            if(typeof this.events[name] !="undefined")
            {
                for(var i in this.events[name])
                {
                    if(this.events[name][i](params)==false)
                    {
                        return false;
                    }
                }
            }
            return true;
        }        
    };    
}
