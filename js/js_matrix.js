var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

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
    //added on 2021-12-03,options for test order(A,B,C...)
    var oo = ""
    var arr_testorder = Array();
    var test_order = document.getElementById("test_order");
    var test_order_opt = test_order.options;
    for(var i=0; i<test_order_opt.length; i++){
        arr_testorder.push(test_order_opt[i].value);
    }
    for(var j=0; j<arr_testorder.length; j++){
        oo += "<option>"+arr_testorder[j]+"</option>";
    }

    var units_qty = document.getElementById("units_qty");
    var counts = units_qty.value;
    var couts = 0;
    var coutI = 0;
    $(function(){
        $(':button[name=add]').click(function(){
            addTr(couts);
        })
        $('button[name=del]').click(function(){
            $(this).parents('tr').remove();
        })
    })
    
    function addTr(couts){
        var html='';
        html+='<tr>';
        html+='<td><select name="group[]" id="group">';
        html+=gg;
        html+='</select></td>';
       
        html+='<td><select name="test_item[]" class="selbox" id="test_item">';
        html+=tt;
        html+='</select></td>';
        
        for(var i=0; i<counts; i++){
            //html+='<td><input name="test_order[]" type="text" onkeyup="value=value.replace(/[^a-zA-Z]/g,")" />';
            //html+='</td>';
            //html+='<input name="unit_order[]" type="hidden" value='+(i+1)+'>';
            //html+='<input name="unit_order[]" type="hidden" value="'+(i+1)+'" />';
            html+='<td><select name="test_order[]" id="test_order">';
            html+=oo;
            html+='</select></td>';
        }
        couts=coutI+1;

        html+='<td><input type="button" name="add" class="btn_add" value="Add" />&nbsp;&nbsp;<input type="button" name="del" class="btn_del" value="Del" /></td>';
        html+='<tr>';
        $('#customers').append(html);
        $(':button[name=add]').click(function(){
            if(coutI<couts){
                coutI += 1;
                addTr(couts);
            }
        })
        $(':button[name=del]').click(function(){
            $(this).parents('tr').remove();
        })
    }
    // loading animation added on 2022-01-06
    $(document).ready(function(){
        $("#form2").on("submit", function(){
            $("#preloder").fadeIn();
        });//submit
    });//document ready
}