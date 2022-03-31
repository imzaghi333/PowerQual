var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script"); 
script2.type = "text/javascript"; 
script2.src = "js/layui/layui.js"; 
document.getElementsByTagName("head")[0].appendChild(script2);

//禁用Enter键
document.onkeydown = function (e) {
    //捕捉回车事件
    var ev = (typeof window.event != 'undefined') ? window.event : e;
    if (ev.keyCode == 13 || window.event.which == 13) {
        return false;
    }
}

window.onload = function(){
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

    var res = ""    //用于保存option test result的字符串
    var arr_testresult = Array();
    var test_itemresult = document.getElementById("result[0]");
    //alert(test_itemresult);
    var test_itemresult_opt = test_itemresult.options;
    for(var i=0; i<test_itemresult_opt.length; i++){
        arr_testresult.push(test_itemresult_opt[i].value);
    }
    for(var j=0; j<arr_testresult.length; j++){
        res += "<option>"+arr_testresult[j]+"</option>";
    }
    
    var units_qty = document.getElementById("units_qty");
    var counts = units_qty.value;
    counts=parseInt(counts)+3;
    //alert("counts="+counts);
    var couts = 0;
    var coutI = 0;
    $(function(){
       $(':button[name=add]').click(function(){
            rowid=parseInt($(this).parents('tr').index()) + 1;
            rowCount=CountRows();
            //alert("rowid="+rowid+"cell counts="+rowCount);
            addTr(couts,rowid);
        })
        $(':button[name=del]').click(function(){
            $(this).parents('tr').remove();
        })
    })
    function addTr(couts,rowid){
        var table = document.getElementById("customers");
        var row = table.insertRow(rowid);
        var cell1 = row.insertCell(0);                                                              
        var cell2 = row.insertCell(1);
        //alert("rowid="+rowid);
        cell1.innerHTML = '<select name="group[]" id="group">'+gg+'</select>';
        cell2.innerHTML = '<select name="test_item[]" id="test_item">'+tt+'</select>';
        //counts=parseInt(counts)+3;
        //finlclum=counts+1;
        //couts=coutI+1;                                                                                                                                                                                                                                                                                                                                                                                                                                                   
        //alert("counts="+counts);
        for(var i=2; i<counts; i++){
            var test_item = row.insertCell(i); 
            rowCount=rowCount+1;
            //test_item.innerHTML='<input type="text" style="width:20px;display:none;" name="subject['+rowid+rowCount+']" id="subject['+rowid+rowCount+']" value=""> <input name="test_order[]" id="test_order" type="text" style="width:20px;" />&nbsp;<select name="result['+rowid+rowCount+']" id="result['+rowid+rowCount+']" onchange="printMatrixResult('+rowid+','+rowid+rowCount+')">'+res+'</select>';
            // ----------- added on 2022-1-3 -----------
            test_item.innerHTML='<input type="text" style="width:20px;display:none;" name="subject1['+rowid+rowCount+']" id="subject1['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject2['+rowid+rowCount+']" id="subject2['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject3['+rowid+rowCount+']" id="subject3['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject4['+rowid+rowCount+']" id="subject4['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject5['+rowid+rowCount+']" id="subject5['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject6['+rowid+rowCount+']" id="subject6['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject7['+rowid+rowCount+']" id="subject7['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject8['+rowid+rowCount+']" id="subject8['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject9['+rowid+rowCount+']" id="subject9['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject10['+rowid+rowCount+']" id="subject10['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject11['+rowid+rowCount+']" id="subject11['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject12['+rowid+rowCount+']" id="subject12['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject13['+rowid+rowCount+']" id="subject13['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject14['+rowid+rowCount+']" id="subject14['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject16['+rowid+rowCount+']" id="subject15['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject16['+rowid+rowCount+']" id="subject16['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject17['+rowid+rowCount+']" id="subject17['+rowid+rowCount+']" value="">';
            test_item.innerHTML+='<input type="text" style="width:20px;display:none;" name="subject18['+rowid+rowCount+']" id="subject18['+rowid+rowCount+']" value="">';
            // ---------- End here ----------
            test_item.innerHTML+='<input name="test_order[]" id="test_order" type="text" style="width:20px;" />&nbsp;<select name="result['+rowid+rowCount+']" id="result['+rowid+rowCount+']" onchange="printMatrixResult('+rowid+','+rowid+rowCount+')" class="resultbox">'+res+'</select>';
            //test_item.innerHTML+='<input type="text" style="width:20px;" value="'+rowCount+'" />';
            if(i==counts-1){            
                test_item.innerHTML='<input type="button" name="new_add" class="btn_add" value="Add" />&nbsp;<input type="button" name="new_del" class="btn_del" value="Del" />';
                couts=coutI+1;
            }
            //alert("i="+i);     
        }
        //couts=coutI+1;
        $(':button[name=new_add]').click(function(){
            //alert("coutI="+coutI+"couts="+couts);
            if(couts>coutI){
                couts--;
               rowid=parseInt($(this).parents('tr').index()) + 1;
               //alert("rowid="+rowid);
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

function printResult(selecid,value,failcontent){
    var result = document.getElementById("result["+selecid+"]");
    var index = result.selectedIndex;
   // alert("index="+index);
    var txt = result.options[index].value;
    //alert("txt="+txt);
    var reg = RegExp(/Fail/);
    //alert("faildis="+value+"fial="+failcontent+"selecid="+selecid);
    if(txt.match(reg)){
        window.open("fail_inner.php?id="+value+"&selecid="+selecid,"填写Fail的原因","height=500, width=850, top=100, left=100");
    }
}
function printMatrixResult(value,selecid){
    //alert("selecid="+selecid);
    var result = document.getElementById("result["+selecid+"]");
    var index = result.selectedIndex;
    var txt = result.options[index].value;
    var reg = RegExp(/Fail/);
    if(txt.match(reg)){
        window.open("fail_inner.php?id="+value+"&selecid="+selecid,"_blank","填写Fail的原因","height=500, width=800, top=100, left=100");
    }
}

function CountRows() {
    var totalRowCount = 0;
    var rowCount = 0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr");
    for (var i = 0; i < rows.length; i++) {
        totalRowCount++;
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+rows[i].getElementsByTagName("td").length;
        }
    }
    var message = "Total Row Count: " + totalRowCount;
    message += "\nRow Count: " + rowCount;
    return rowCount;
}

function checkFormUploadSN(){
    if(document.form10.sn_file.value==""){
        layer.msg("請選取需要上傳的Excel",{icon: 2});
        return false;
    }
    else{
        return true;
    }
}