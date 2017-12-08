
$(function(){
var Table = function (element, options) {       
        this.options = options ;
        this.$element = $(element);
    }
Table.prototype = {
    //生成表格数据
    Table_get:function(Table_head,tableData,pageSize,pageNo,TableShuXing){  
        this.$element.empty();
        var th="",tr="";    
        th = "<th class='checbox display_none'></th>"
        for(var c in Table_head){
            th += "<th class=Num_"+c+">"+Table_head[c]+"</th>";
        }
        th = "<tr class='table_head'>"+th+"</tr>"
        this.$element.append(th);
       var Page_data = this.getPage_data(pageSize,pageNo,tableData);
          $.each(Page_data, function(i,eachData){
              var tr_str="";
              tr_str="<td class='checbox display_none'><input type='checkbox'></input></td>"
              for(var d in TableShuXing){
                
                     tr_str += "<td class=Num_"+d+">"+eachData[TableShuXing[d]]+"</td>";
              }
              tr_str = "<tr class='page_table_tr'>"+tr_str+"</tr>";
              tr +=tr_str;
          })
        this.$element.append(tr);
        this.Click_tr()
    },
    //获取总页数
    getAllPage : function (pageSize,tableData) {
            var TD_length = tableData.length;
            var shang = TD_length/pageSize;
            var yushu = TD_length%pageSize;
            if(yushu >0){
                shang ++;
            }
            return shang; 
        },
    //截取当前页数数据
    getPage_data : function (pageSize,pageNo,tableData){
            
            var TD_length = tableData.length;
            var shang = this.getAllPage(pageSize,tableData);
            var startIndex = (pageNo-1)*pageSize;
            var endIndex = (shang == pageNo)? TD_length:pageNo*pageSize;
            return tableData.slice(startIndex,endIndex);
        },
        //点击表格行切换选中状态事件
    Click_tr: function(){
           var n =1 ;
        function table_tr_click (){
                var chec_input = $(this).find("input").prop("checked");
                if (chec_input) {
                    $(this).find("input").prop("checked", false);
                    $(this).removeClass("active_tr");
                }
                else {
                    $(this).find("input").prop("checked", true);
                    $(this).addClass("active_tr");
                };
            }
            // var aa =this.$element.find(".page_table_tr")
            // aa.click(table_tr_click);
        //     this.$element.find(".page_table_tr").unbind("click",table_tr_click);//防止重复绑定同一个函数
           this.$element.find(".page_table_tr").bind("click",table_tr_click);
        //  this.$element.find("input").click(function(){
        //        event.stopPropagation();
        //  })
    }
}

   $.fn.table = function (options) {
                var that=$(this);
                var table = new Table(that, options);
                options = $.extend({}, $.fn.table.defaults, options)
            var table_head = options.Table_head,
                tableData = options.tableData,
                TableShuXing = options.TableShuXing,
                pageSize = options.pageSize,
                pageNo =  options.pageNo;
                return   table.Table_get(table_head,tableData,pageSize,pageNo,TableShuXing);                            
  }
   $.fn.table.defaults = {
        pageSize: 15
      , pageNo: 1  
    }
})

  


$.fn.extend({
    "initPage":function(listCount,currentPage,fun){
        
        var maxshowpageitem = $(this).attr("maxshowpageitem");
        if(maxshowpageitem!=null&&maxshowpageitem>0&&maxshowpageitem!=""){
            page.maxshowpageitem = maxshowpageitem;
        }
        var pagelistcount = parseInt($(this).attr("pagelistcount"));
        if(pagelistcount!=null&&pagelistcount>0&&pagelistcount!=""){
            page.pagelistcount = pagelistcount;
        }
        var pageCount = listCount%page.pagelistcount>0?parseInt(listCount/page.pagelistcount)+1:parseInt(listCount/page.pagelistcount);
        var pageId = $(this).attr("id");
        page.pageId=pageId;
        if(listCount<0){
            listCount = 0;
        }
        if(currentPage<=0){
            currentPage=1;
        }
        page.setPageListCount(listCount,currentPage,fun,pageCount);

    }
});
var  page = {
    "pageId":"",
    "maxshowpageitem":5,//最多显示的页码个数
    "pagelistcount":10,//每一页显示的内容条数
    /**
     * 初始化分页界面
     * @param listCount 列表总量
     */
    "initWithUl":function(listCount,currentPage){
        var pageCount = 1;
        if(listCount>=0){
             pageCount = listCount%page.pagelistcount>0?parseInt(listCount/page.pagelistcount)+1:parseInt(listCount/page.pagelistcount);
        }
        var appendStr = page.getPageListModel(listCount,pageCount,currentPage);
        $("#"+page.pageId).html(appendStr);
    },
    /**
     * 设置列表总量和当前页码
     * @param listCount 列表总量
     * @param currentPage 当前页码
     */
    "setPageListCount":function(listCount,currentPage,fun,pageCount){
        listCount = parseInt(listCount);
        currentPage = parseInt(currentPage);
        page.initWithUl(listCount,currentPage);
        page.initPageEvent(listCount,fun,pageCount);
        fun(currentPage);
    },
    "initPageEvent":function(listCount,fun,pageCount){
        
        $("#"+page.pageId +">li[class='pageItem']").on("click",function(e){
         var id  =  "#" +$(this).parent().attr("ID");
           $(id).initPage(listCount,$(this).attr("page-data"),fun);
        });
        $("#"+page.pageId +">li[class='select_pagesize'] select").on("change",function(e){
          var id  =  "#" +$(this).parent().parent().attr("ID");
          var pageSize = parseInt($(this).val());
           $(id).attr("pagelistcount",pageSize);
           $(id).initPage(listCount,1,fun);
        });
         $("#"+page.pageId +">li[class='go_page'] input").on("keypress",function(e){
           
             var that = $(this);
             if (e.keyCode == "13") {
              
                var pageNo = parseInt(that.val());
                if(pageNo <= pageCount){
                   id  =  "#" +$(this).parent().parent().parent().attr("ID");
                        $(id).initPage(listCount,pageNo,fun);      
                }
               else{return}
             }
        });
    },
    "getPageListModel":function(listCount,pageCount,currentPage){
        var prePage = currentPage-1;
        var nextPage = currentPage+1;
        var prePageClass ="pageItem";
        var nextPageClass = "pageItem";
        if(prePage<=0){
            prePageClass="pageItemDisable";
        }
        if(nextPage>pageCount){
            nextPageClass="pageItemDisable";
        }
        var appendStr ="";
        appendStr+="<li class='"+prePageClass+"' page-data='1' page-rel='firstpage'>首页</li>";
        appendStr+="<li class='"+prePageClass+"' page-data='"+prePage+"' page-rel='prepage'>&lt;上一页</li>";
        var miniPageNumber = 1;
        if(currentPage-parseInt(page.maxshowpageitem/2)>0&&currentPage+parseInt(page.maxshowpageitem/2)<=pageCount){
            miniPageNumber = currentPage-parseInt(page.maxshowpageitem/2);
        }else if(currentPage-parseInt(page.maxshowpageitem/2)>0&&currentPage+parseInt(page.maxshowpageitem/2)>pageCount){
            miniPageNumber = pageCount-page.maxshowpageitem+1;
            if(miniPageNumber<=0){
                miniPageNumber=1;
            }
        }
        var showPageNum = parseInt(page.maxshowpageitem);
        if(pageCount<showPageNum){
            showPageNum = pageCount
        }
        for(var i=0;i<showPageNum;i++){
            var pageNumber = miniPageNumber++;
            var itemPageClass = "pageItem";
            if(pageNumber==currentPage){
                itemPageClass = "pageItemActive";
            }

            appendStr+="<li class='"+itemPageClass+"' page-data='"+pageNumber+"' page-rel='itempage'>"+pageNumber+"</li>";
        }
        appendStr+="<li class='"+nextPageClass+"' page-data='"+nextPage+"' page-rel='nextpage'>下一页&gt;</li>";
        appendStr+="<li class='"+nextPageClass+"' page-data='"+pageCount+"' page-rel='lastpage'>尾页</li>";
        
        var count_str = "";
        count_str = "<li class='count_data'>共 "+pageCount+" 页/ "+listCount+" 条数据</li>"
          appendStr+=count_str;

        var select_str = "";
        switch(page.pagelistcount){
            case 10: select_str = "<li class='select_pagesize'><select><option selected='selected'>10</option><option>15</option><option>20</option><option>50</option><option>100</option></select><span>条/页</span></li>" ;  break;
            case 15:  select_str = "<li class='select_pagesize'><select><option >10</option><option selected='selected'>15</option><option>20</option><option>50</option><option>100</option></select><span>条/页</span></li>" ; break;
            case 20: select_str = "<li class='select_pagesize'><select><option >10</option><option>15</option><option selected='selected'>20</option><option>50</option><option>100</option></select><span>条/页</span></li>" ; break;
            case 50:  select_str = "<li class='select_pagesize'><select><option >10</option><option>15</option><option>20</option><option  selected='selected'>50</option><option>100</option></select><span>条/页</span></li>" ;break;
            case 100:  select_str = "<li class='select_pagesize'><select><option >10</option><option>15</option><option>20</option><option>50</option><option selected='selected'>100</option></select><span>条/页</span></li>" ;break;
            default : select_str = "<li class='select_pagesize'><select><option >10</option><option selected='selected'>15</option><option>20</option><option>50</option><option>100</option></select><span>条/页</span></li>" ;  break;
        }
        appendStr+=select_str;

        var go_page_str = "<li class='go_page'><span>转到</span><span><input ></input></span><span>页</span></li>";
        appendStr+=go_page_str;
       return appendStr;

    }
}

