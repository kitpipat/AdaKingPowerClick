if(typeof CustomDrillDown =="undefined")
{
    function CustomDrillDown(name,options)
    {
        this.name = name;
        this.options = options;
        $("#"+this.name+" .btnBack").attr('disabled','disabled');
        this.events = {};
        this.titles = [];
        for(var i=0;i<this.options.subReports.length;i++)
        {
            this.titles.push(null);
        }
        this.levelTitle($("sub-report#"+this.options.subReports[this.reportIndex] +" level-title").text());
    }
    CustomDrillDown.prototype = {
        name:null,
        options:null,
        reportIndex:0,
        titles:null,
        events:null,
        copyObject:function(obj)
        {
            var newObj = {};
            for(var i in obj)
            {
                newObj[i] = obj[i];
            }
            return newObj;
        },
        next:function(params)
        {
            var total = this.options.subReports.length;
            var dataSent = Object.assign(this.copyObject(this.options.scope),params);
            if(this.reportIndex<total-1)
            {
                dataSent["@subReport"] = this.options.subReports[this.reportIndex+1];
                dataSent["@drilldown"] = this.name;    
                if(this.fireEvent("nexting",dataSent))
                {
                    this.reportIndex++;
                    $.ajax({
                        method:"POST",
                        data:dataSent,
                        async:true,
                    }).done(function(content){
                        var start_mark = "<!--subreport-start-->";
                        var end_mark = "<!--subreport-end-->";
                        content = content.substring(content.indexOf(start_mark)+start_mark.length,content.indexOf(end_mark));
                        $('#'+this.name+' .btnBack').attr('disabled',(this.reportIndex>0)?false:'disabled');
                        $("sub-report#"+this.options.subReports[this.reportIndex-1]).hide();
                        $("sub-report#"+this.options.subReports[this.reportIndex]).html(content).show();
                        this.levelTitle($("sub-report#"+this.options.subReports[this.reportIndex] +" level-title").text());
                        this.fireEvent("nexted",{level:this.reportIndex});
                        this.fireEvent("changed",{level:this.reportIndex});
                    }.bind(this));    
                }
            }
        },
        back:function(level=null)
        {
            
            if(level==null)
            {
                level = this.reportIndex-1;
            }
            if(level>=0 && level<this.reportIndex)
            {
                this.fireEvent("backing",{level:level})
                {
                    this.reportIndex = level;
                    for(var i=0;i<this.options.subReports.length;i++)
                    {
                        if(i==this.reportIndex)
                        {
                            $("sub-report#"+this.options.subReports[i]).show();
                        }
                        else
                        {
                            $("sub-report#"+this.options.subReports[i]).hide();
                        }
                    }
                    $('#'+this.name+' .btnBack').attr('disabled',(this.reportIndex>0)?false:'disabled');
                    this.renderLevelTitles();
                    this.fireEvent("backed",{level:this.reportIndex});
                    this.fireEvent("changed",{level:this.reportIndex});                        
                }            
            }
        },
        levelTitle:function(title,level=null)
        {
            
            if(level==null)
            {
                level = this.reportIndex;
            }
            if(title==null||title=="")
            {
                title = "Level "+level;
            }
            this.titles[level] = title;
            this.renderLevelTitles();
        },
        renderLevelTitles:function()
        {
            $('#'+this.name+' .breadcrumb').empty();
            for(var i=0;i<this.reportIndex;i++)
            {
                $('#'+this.name+' .breadcrumb').append("<li><a href='javascript:"+this.name+".back("+i+")'>"+this.titles[i]+"</a></li>");
            }
            $('#'+this.name+' .breadcrumb').append("<li><span class='custom-drilldown-clevel-title'>"+this.titles[this.reportIndex]+"</span></li>")
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