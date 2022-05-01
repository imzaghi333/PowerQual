var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script"); 
script2.type = "text/javascript"; 
script2.src = "js/layui/layui.js"; 
document.getElementsByTagName("head")[0].appendChild(script2);

function addLoadEvent(func){
    var oldonload = window.onload;
    if(typeof window.onload != "function"){
        window.onload = func;
    }
    else{
        window.onload = function(){
            oldonload();
            func();
        }
    }
}

function addRow(){
    var units_qty = document.getElementById("units_qty");
    var number = units_qty.value;    //added on 2022-02-08,获取测试机数量
    var counts = units_qty.value;    //获取测试机数量,用于添加测试项控制循环

    var gg = ""    //用于保存option group的字符串
    var arr_group = Array();
    var group = document.getElementById("group");
    var group_opt = group.options;    //获得该下拉框所有的option的节点对象
    for(var i=0; i<group_opt.length; i++){
        arr_group.push(group_opt[i].value);
    }
    for(var j=0; j<arr_group.length; j++){
        gg += "<option>"+arr_group[j]+"</option>";
    }
   
    var tt = ""    //用于保存option test item的字符串
    var arr_testitem = Array();
    var test_item = document.getElementById("test_item");
    var test_item_opt = test_item.options;
    for(var i=0; i<test_item_opt.length; i++){
        arr_testitem.push(test_item_opt[i].value);
    }
    for(var j=0; j<arr_testitem.length; j++){
        tt += "<option>"+arr_testitem[j]+"</option>";
    }

    var tc = ""    //用于保存test condition的字符串
    var arr_tc = Array();
    var conditions = document.getElementById("conditions");
    var tc_opt = conditions.options;
    for(var i=0; i<tc_opt.length; i++){
        arr_tc.push(tc_opt[i].value);
    }
    for(var j=0; j<arr_tc.length; j++){
        tc += "<option>"+arr_tc[j]+"</option>";
    }
    /*
    var ss = "";    //用于保存test status的字符串
    var arr_status = Array();
    var status = document.getElementById("status");
    var ss_opt = status.options;
    for(var i=0; i<ss_opt.length; i++){
        arr_status.push(ss_opt[i].value);
    }
    for(var j=0; j<arr_status.length; j++){
        ss += "<option>"+arr_status[j]+"</option>";
    }

    var res = ""    //用于保存option test result的字符串
    var arr_result = Array();
    var test_result = document.getElementById("result["+number+"]");
    var res_opt = test_result.options;
    for(var i=0; i<res_opt.length; i++){
        arr_result.push(res_opt[i].value);
    }
    for(var j=0; j<arr_result.length; j++){
        res += "<option>"+arr_result[j]+"</option>";
    }
    */
    counts=parseInt(counts)+4;
    total_rows = getRows()-1;    //新增行之后
    var couts = 0;
    var coutI = 0;
    $(function(){
        $(':button[name=add]').click(function(){
            rowid=parseInt($(this).parents('tr').index())+1;//
            rowCount=CountRows();
            //alert("rowid="+rowid+" ,Cell counter:"+rowCount);
            addTr(couts,rowid);
        })
        $(':button[name=del]').click(function(){
            $(this).parents('tr').remove();
        })
    })
    function addTr(couts,rowid){
        var table = document.getElementById("customers");
        var row = table.insertRow(rowid);
        var cell0 = row.insertCell(0);                                                              
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);

        rowid -= 2;    //编号可以从0开始
        cell0.innerHTML = '<input name="requests[]" id="requests" type="text" value="Yes" />';
        cell1.innerHTML = '<select name="group[]" id="group" class="gp">'+gg+'</select>';
        cell2.innerHTML = '<select name="test_item[]" id="test_item" class="selbox">'+tt+'</select>';
        cell3.innerHTML = '<select name="conditions[]" id="conditions" class="selbox">'+tc+'</select>';
        
        for(i=4; i<counts;i++){
            var test_item = row.insertCell(i); 
            rowCount=rowCount+1;
            // ----------------- hidden area -------------------
            /*
            test_item.innerHTML='<input type="text" style="width:20px;display:none;" name="subject1['+rowCount+']" id="subject1['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject2['+rowCount+']" id="subject2['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject3['+rowCount+']" id="subject3['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject4['+rowCount+']" id="subject4['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject5['+rowCount+']" id="subject5['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject6['+rowCount+']" id="subject6['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject7['+rowCount+']" id="subject7['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject8['+rowCount+']" id="subject8['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject9['+rowCount+']" id="subject9['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject10['+rowCount+']" id="subject10['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject11['+rowCount+']" id="subject11['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject12['+rowCount+']" id="subject12['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject13['+rowCount+']" id="subject13['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject14['+rowCount+']" id="subject14['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject16['+rowCount+']" id="subject15['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject16['+rowCount+']" id="subject16['+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject17['+rowCount+']" id="subject17['+rowCount+']" value="">';
            */
            //Default result is TBD
            test_item.innerHTML+='<input type="text" style="width:50px;display:none;" name="subject18['+rowCount+']" id="subject18['+rowCount+']" value="TBD">';
            //test_item.innerHTML+='<input name="test_order[]" id="test_order" type="text" style="width:23px;" />';
            //test_item.innerHTML+='cell:'+rowCount;    //打印编号而已
        }
        var cell_start = row.insertCell(counts);
        var cell_end = row.insertCell(counts+1);
        var cell_status = row.insertCell(counts+2);
        var cell_result = row.insertCell(counts+3);
        
        var cell_fail_link = row.insertCell(counts+4);
        var cell_fail = row.insertCell(counts+5);
        var cell_fa = row.insertCell(counts+6);
        var cell_remark = row.insertCell(counts+7);
        var cell_action = row.insertCell(counts+8);
        ++rowCount;

        cell_start.innerHTML = '<input type="date" name="starting[]" id="starting" />';
        cell_end.innerHTML = '<input type="date" name="ending[]" id="ending" />';
        cell_status.innerHTML = '<select name="status[]" id="status" class="statusbox">'+ss+'</select>';
        //cell_result.innerHTML = '<select class="resultbox" name="result['+rowCount+']" id="result['+rowCount+']" onchange="printMatrixResult('+rowid+','+rowCount+','+number+','+rowCount+','+total_rows+')">'+res+'</select>';
        cell_result.innerHTML = '<select class="resultbox" name="result['+rowCount+']" id="result['+rowCount+']" >'+res+'</select>';
        cell_fail_link.innerHTML = '<td><input type="button" name="FF['+rowCount+']" id="FF['+rowCount+']" value="F" onclick="printMatrixResult('+rowid+','+rowCount+','+number+','+rowCount+','+total_rows+');"></td>';
        //cell_result.innerHTML += "cell:"+rowCount; //打印编号
        cell_fail.innerHTML = '<textarea name="fail['+rowid+']" id="fail['+rowid+']" rows="1" class="text-adaption"></textarea>';
        cell_fa.innerHTML = '<textarea name="rcca['+rowid+']" id="rcca['+rowid+']" rows="1" class="text-adaption"></textarea>';
        cell_remark.innerHTML = '<textarea name="remarks['+rowid+']" id="remarks['+rowid+']" rows="1" class="text-adaption"></textarea>';
        cell_action.innerHTML = '<input type="button" name="new_add" class="btn_add" value="Add" />&nbsp;<input type="button" name="new_del" class="btn_del" value="Del" />';

        $(':button[name=new_add]').click(function(){
            //alert("coutI="+coutI+"couts="+couts);
            if(couts==coutI){
                //couts--;
                rowid=parseInt($(this).parents('tr').index())+1;
                addTr(couts,rowid);
            }
        })
        $(':button[name=new_del]').click(function(){
            $(this).parents('tr').remove();
        })
    }
    //loading animation added on 2022-01-06
    $(document).ready(function(){
        $("#form8").on("submit", function(){
            $("#preloder").fadeIn();
        });//submit
    });//document ready
}

function checkTemp(){
    var temps = document.getElementsByClassName("temp_txt");
    //var results = document.getElementsByClassName("result_txt");
    var orders = document.getElementsByClassName("order_txt");

    for(var i=0; i<temps.length; i++){
        if(temps[i].value=="Hot"){
            orders[i].style.color = "#cc2229";
        }
        if(temps[i].value=="Room"){
            orders[i].style.color = "#0aa344";
        }
        if(temps[i].value=="Cold"){
            orders[i].style.color = "#1565c0";
        }
    }
}
addLoadEvent(addRow);
addLoadEvent(checkTemp);

// 通过样式名获取元素
function getClass(c){
    return document.getElementsByClassName(c)
}

//rowid是表格行编号,selectid是单元格编号,count是机台数量,current是RecordID,rows是总行数
function printResult(rowid,selectid,count,currentid,rows){
    //alert("参数列表，表格行编号: "+rowid+", 单元格编号: "+selectid+", 机台数量: "+count+", RecordID: "+currentid+", 总行数: "+rows);
    /*
    var result = document.getElementById("result["+selectid+"]");
    var index = result.selectedIndex;
    var txt = result.options[index].value
    var reg = RegExp(/Fail/);
    if(txt.match(reg)){
        window.open("fail.php?rowid="+rowid+"&cellid="+selectid+"&count="+count+"&currentid="+currentid+"&rows="+rows,"填写Fail的原因","height=500, width=850, top=100, left=100");
    }*/
    window.open("fail.php?rowid="+rowid+"&cellid="+selectid+"&count="+count+"&currentid="+currentid+"&rows="+rows,"Fail Links","height=500, width=850, top=100, left=100");
}

//JS中fail调用fail.php
function printMatrixResult(rowid,selectid,count,currentid,rows){
    /*
    var result = document.getElementById("result["+selectid+"]");
    var index = result.selectedIndex;
    var txt = result.options[index].value;
    var reg = RegExp(/Fail/);
    if(txt.match(reg)){
        window.open("fail.php?rowid="+rowid+"&cellid="+selectid+"&count="+count+"&currentid="+currentid+"&rows="+rows,"_blank","填写Fail的原因","height=500, width=850, top=100, left=100");
    }*/
    window.open("fail.php?rowid="+rowid+"&cellid="+selectid+"&count="+count+"&currentid="+currentid+"&rows="+rows,"_blank","填写Fail的原因","height=500, width=850, top=100, left=100");
}

//获取表格的单元格数量
function CountRows() {
    var rowCount = 0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")
    for (var i = 0; i < rows.length; i++) {
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+rows[i].getElementsByTagName("td").length;
        }
    }
    return rowCount;
}

//获取表格的行数
function getRows(){
    var totalRowCount = 0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")
    for (var i = 0; i < rows.length; i++) {
        totalRowCount++;
    }
    var message = "Total Row Count: " + totalRowCount;
    return totalRowCount;
}

function oneRowAllPass(rowid,number){
    var row_no = rowid;          //行號,從0開始計數
    var cell_length = number+4;  //單元格數量,从0开始计数
    var oTab = document.getElementById("customers");    //Test Matrix Table
    var oTbody = oTab.tBodies[0];    //表格不含標題欄部分
    var reg1 = RegExp(/value=""/i);  //匹配tes order為空的單元格,不改變默認的TBD
    var reg2 = RegExp(/TBD/i);       //匹配有tes order單元格,改變其結果為Pass

    //Test order從第五列開始
    for(var i=4; i<cell_length; i++){
        var s = oTbody.rows[row_no].cells[i].innerHTML;    //獲取原來單元格的html内容
        var m = "";
        if(!s.match(reg1)){
            m = s.replace(reg2,"Pass");    //有test order字符串的TBD改成Pass
            oTbody.rows[row_no].cells[i].innerHTML = m;    //新的html替換原來的html内容
        }
    }
    layer.msg("第"+(row_no+1)+"行全部設置為Pass U•ェ•*U",{icon: 6});
}