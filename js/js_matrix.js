var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var units_qty =""    // document.getElementById("units_qty");
var counts = ""      //units_qty.value;
var gg = ""          //用于保存option group的字符串
var tt = ""          //用于保存option test item的字符串

function innero(couts){
    var rowCount=0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")

    for(var i = 0; i < rows.length; i++){
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+1;
        }
    }
    if(couts<rowCount){
        for (var d = 1; d <(Number(counts)+1); d++){
            eval("original_select"+(couts+1)+d+"=''");
        }
        for(var i = (rowCount); i > (couts); i--){
            for (var d = 1; d <(Number(counts)+1); d++){
                document.getElementById("test_order"+(i)+d).setAttribute("id","test_order"+(i+1)+d);
                document.getElementById("test_order"+(i+1)+d).setAttribute("onchange","testchange("+(i+1)+","+d+")");
            }
        document.getElementById((i)+"add").setAttribute("id",(i+1)+"add");                    
        document.getElementById((i)+"del").setAttribute("id",(i+1)+"del");
        document.getElementById((i+1)+"add").setAttribute("name",(i+1)+"add");
        document.getElementById((i+1)+"del").setAttribute("name",(i+1)+"del");
        }
    }
    var gp="";
    gp+='<select name="group[]" id="group">';
    gp+=gg;
    gp+='</select>';
    var ti="";
    var bu="";
    ti+='<select name="test_item[]" class="selbox" id="test_item">';
    ti+=tt;
    ti+='</select>';
    var table = document.getElementById("customers");
    var row = table.insertRow(couts+1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = gp;
    cell2.innerHTML = ti;
    for(var ii=1; ii<(Number(counts)+1); ii++){
        var to="";
        to+='<select class="test_order" name="test_order[]" id="test_order'+(couts+1)+ii+'" onchange="testchange('+(couts+1)+','+ii+')">';
        to+=this["oo"+ii] ;
        to+='</select>';

        row.insertCell(ii+1).innerHTML=to;
    }
    var rowCount=0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")

    for (var i = 0; i < rows.length; i++) {
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+1;
        }
    }
    bu+='<input type="button" id="'+(couts+1)+'add"  name="'+(couts+1)+'add" class="btn_add" value="Add"/>&nbsp;&nbsp;<input type="button" id="'+(couts+1)+'del" name="'+(couts+1)+'del"  class="btn_del" value="Del" />'
    row.insertCell(ii+1).innerHTML=bu;
    $(':button[name='+(couts+1)+'add]').click(function(){
        var rowJavascript = this.parentNode.parentNode;
        var rowjQuery = $(this).closest("tr");
        var rowCount2=0;
        var table = document.getElementById("customers");
        var rows = table.getElementsByTagName("tr")

        for (var i = 0; i < rows.length; i++) {
            if (rows[i].getElementsByTagName("td").length > 0) {
                rowCount2=rowCount2+1;
            }
        }
        innero(rowJavascript.rowIndex);
    })
     
    $(':button[name='+(couts+1)+'del]').click(function(){
        //coutI = coutI-1;
        var rowJavascript = this.parentNode.parentNode;
        var rowjQuery = $(this).closest("tr");
        couts=rowJavascript.rowIndex;

        var rowCount2=0;
        var table = document.getElementById("customers");
        var rows = table.getElementsByTagName("tr")
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].getElementsByTagName("td").length > 0) {
                rowCount2=rowCount2+1;
            }
        }
        for (var i = 1; i < (rowCount2+1); i++){
            for (var d = 1; d <(Number(counts)+1); d++){
                var deletorder= document.getElementById("test_order"+(couts)+d).value;
                const iindex = eval('arrcontainer'+d).indexOf(deletorder);
                if (iindex > -1) {
                    eval('arrcontainer'+d).splice(iindex, 1); // 2nd parameter means remove one item only
                }
                if(JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length) == 0 && deletorder!="请选择"){
                    for(var mm=1;mm<(eval("test_order"+i+d).options.length);mm++){
                        if(deletorder.charCodeAt(0)<eval("test_order"+i+d).options[mm].value.charCodeAt(0)){
                            eval("test_order"+i+d).options.add(new Option(deletorder,deletorder),eval("test_order"+i+d)[mm]);
                            break;
                        }
                    }
                }
            }
        }
        $(this).parents('tr').remove();
        for (var i = (couts+1); i < (rowCount2+1); i++){
            for (var d = 1; d <(Number(counts)+1); d++){
                document.getElementById("test_order"+(i)+d).setAttribute("id","test_order"+(i-1)+d);
                document.getElementById("test_order"+(i-1)+d).setAttribute("onchange","testchange("+(i-1)+","+d+")");
            }
            document.getElementById((i)+"add").setAttribute("id",(i-1)+"add");                    
            document.getElementById((i)+"del").setAttribute("id",(i-1)+"del");
            document.getElementById((i-1)+"add").setAttribute("name",(i-1)+"add");
            document.getElementById((i-1)+"del").setAttribute("name",(i-1)+"del"); 
        }
        for (var d = 1; d <(Number(counts)+1); d++){
            var test_order = document.getElementById("test_order1"+d);
            var test_order_opt = test_order.options;
            var arr_testorder=[];
            for(var i=0; i<test_order_opt.length; i++){

                if(eval("arrcontainer"+d).indexOf(test_order_opt[i].value)==-1){
                    arr_testorder.push(test_order_opt[i].value);
                }
            }   
            var p ="";
            eval("oo"+d+"=p");
            for(var j=0; j<arr_testorder.length; j++){
                p= "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
                eval("oo"+d+"+=p");
            }
        }           
    })
}

function testchange(pp,ii){
    var totalRowCount = 0;
    var rowCount = 0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")
    for (var i = 0; i < rows.length; i++) {
        totalRowCount++;
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+1;
        }
    }
    var totalRowCount = rowCount;
    this["oo"+ii] = "" ; //dropdown list containter
    var arr_testorder = Array();
    var test_order = document.getElementById("test_order"+pp+ii);
    var strUser = test_order.value; //currently row two selecton item
    if(strUser!="请选择"){
        this["arrcontainer"+ii].push(strUser);
    }
    if(this["original_select"+pp+ii]==undefined||this["original_select"+pp+ii]==""){
        this["original_select"+pp+ii]=strUser;
        for(var aa=1; aa<totalRowCount+1; aa++){
            if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) > 0&&aa!==pp){
                $("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").remove();
            }
        }
    }
    else{
        for(var aa=1; aa<totalRowCount+1; aa++){
            if(this["original_select"+pp+ii]==undefined){
                //this["select_temp"+ii]=strUser;
            }
            else{
                var letterpo=this["original_select"+pp+ii].charCodeAt(0)-63;
                const iindex = this["arrcontainer"+ii].indexOf(this["original_select"+pp+ii]);
                if (iindex > -1) {
                    this["arrcontainer"+ii].splice(iindex, 1); // 2nd parameter means remove one item only
                }

                if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) == 0){
                    for(var mm=1;mm<(this["test_order"+aa+ii].options.length);mm++){
                        if(this["original_select"+pp+ii].charCodeAt(0)<this["test_order"+aa+ii].options[mm].value.charCodeAt(0)){
                            this["test_order"+aa+ii].options.add(new Option(this["original_select"+pp+ii],this["original_select"+pp+ii]),this["test_order"+aa+ii][mm]);
                            break;
                        }
                    }
                }
            }
        }
        this["original_select"+pp+ii]=strUser; //set new testorder1 value
        for(var aa=1; aa<totalRowCount+1; aa++){
            if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) > 0&&aa!=pp){
                $("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").remove();
            }
        }
    }
    var test_order_opt = test_order.options;
    for(var i=0; i<test_order_opt.length; i++){
        if(this["arrcontainer"+ii].indexOf(test_order_opt[i].value)==-1){
            arr_testorder.push(test_order_opt[i].value);
        }
    }
    for(var j=0; j<arr_testorder.length; j++){
        this["oo"+ii] += "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
    }
}

window.onload = function(){
    units_qty = document.getElementById("units_qty");
    counts = units_qty.value;
    var couts = 0;
    var coutI = 0;

    for(var i=0; i<counts; i++){
        w=i+1;
        this["arrcontainer"+w] = Array();
        this["oo"+w]="";
    }
    for(var i=1;i<50;i++){
        for(var ii=0; ii<counts; ii++){
            w=ii+1;
            this["original_select"+i+w] = "";    
        }
    }
    //var gg = ""    //用于保存option group的字符串
    var arr_group = Array();
    var group = document.getElementById("group");
    var group_opt = group.options;    //获得该下拉框所有的option的节点对象
    for(var i=0; i<group_opt.length; i++){
        arr_group.push(group_opt[i].value);
    }
    for(var j=0; j<arr_group.length; j++){
        gg += "<option>"+arr_group[j]+"</option>";
    }
    //var tt = ""    //用于保存option test item的字符串
    //var tt group
    var arr_testitem = Array();
    var test_item = document.getElementById("test_item");
    var test_item_opt = test_item.options;
    for(var i=0; i<test_item_opt.length; i++){
        arr_testitem.push(test_item_opt[i].value);
    }
    for(var j=0; j<arr_testitem.length; j++){
        tt += "<option>"+arr_testitem[j]+"</option>";
    }
    for(var e=0; e<counts; e++){
        ii=e+1;
        var arr_testorder = Array();
        var test_order = document.getElementById("test_order1"+ii);
        var strUser = test_order.value;
        if(strUser!="请选择"){
            this["arrcontainer"+ii].push(strUser);
        }
       
        var test_order_opt = test_order.options;
        for(var i=0; i<test_order_opt.length; i++){
                arr_testorder.push(test_order_opt[i].value);
        }
        for(var j=0; j<arr_testorder.length; j++){
            this["oo"+ii] += "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
        }
    }
    $(function(){
        $(':button[name=1add]').click(function(){
            var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = $(this).closest("tr");
            innero(rowJavascript.rowIndex);
            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")

            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount2=rowCount2+1;
                }
            }
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
        counts
        for(var i=0; i<counts; i++){
            ii=i+1;
            html+='<td><select class="test_order" name="test_order[]" id="test_order'+(couts+1)+ii+'" onchange="testchange('+(couts+1)+','+ii+')">';
            html+=this["oo"+ii] ;
            html+='</select></td>';
            
        }
        var rowCount=0;
        var table = document.getElementById("customers");
        var rows = table.getElementsByTagName("tr")

        for (var i = 0; i < rows.length; i++) {
            if (rows[i].getElementsByTagName("td").length > 0) {
                rowCount=rowCount+1;
            }
        }
        html+='<td><input type="button" id="'+(rowCount+1)+'add"  name="'+(rowCount+1)+'add" class="btn_add" value="Add" />&nbsp;&nbsp;<input type="button" id="'+(rowCount+1)+'del" name="'+(rowCount+1)+'del"  class="btn_del" value="Del" /></td>';
        html+='<tr>';
        $('#customers').append(html);

        $(':button[name='+(rowCount+1)+'add]').click(function(){

            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")

            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount2=rowCount2+1;
                }
            }
            addTr(rowCount2);
        })
        $(':button[name='+(rowCount+1)+'del]').click(function(){
            var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = $(this).closest("tr");
            alert("JavaScript Row Index : " + (rowJavascript.rowIndex - 1) );
            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount2=rowCount2+1;
                }
            }
            for (var i = 1; i < (rowCount2+1); i++){
                for (var d = 1; d <(Number(counts)+1); d++){
                    var deletorder= document.getElementById("test_order"+(rowCount+1)+d).value;
                    const iindex = eval('arrcontainer'+d).indexOf(deletorder);
                    if (iindex > -1) {
                        eval('arrcontainer'+d).splice(iindex, 1); // 2nd parameter means remove one item only
                    }

                    if(JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length) == 0 && deletorder!="请选择"){
                        for(var mm=1;mm<(eval("test_order"+i+d).options.length);mm++){
                            if(deletorder.charCodeAt(0)<eval("test_order"+i+d).options[mm].value.charCodeAt(0)){
                                eval("test_order"+i+d).options.add(new Option(deletorder,deletorder),eval("test_order"+i+d)[mm]);
                                break;
                            }
                        }
                    }
                }               
            }
            $(this).parents('tr').remove();
            for (var i = (rowCount+1); i < (rowCount2); i++){
                for (var d = 1; d <(Number(counts)+1); d++){
                    document.getElementById("test_order"+(i+1)+d).setAttribute("id","test_order"+(i)+d);    
                    document.getElementById("test_order"+(i)+d).setAttribute("onchange","testchange("+(i)+","+d+")");
                }
                document.getElementById((i+1)+"add").setAttribute("id",i+"add");                    
                document.getElementById((i+1)+"del").setAttribute("id",i+"del");
                document.getElementById((i)+"add").setAttribute("name",(i)+"add");
                document.getElementById((i)+"del").setAttribute("name",(i)+"del");
            }
            for (var d = 1; d <(Number(counts)+1); d++){
                var test_order = document.getElementById("test_order1"+d);
                var test_order_opt = test_order.options;
                var arr_testorder=[];
                for(var i=0; i<test_order_opt.length; i++){
                    if(eval("arrcontainer"+d).indexOf(test_order_opt[i].value)==-1){
                        arr_testorder.push(test_order_opt[i].value);
                    }
                }   
                var p ="";
                eval("oo"+d+"=p");
                for(var j=0; j<arr_testorder.length; j++){
                    p= "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
                    eval("oo"+d+"+=p");
                }
            }           
        })
    }
    $(document).ready(function(){
        $("#form2").on("submit", function(){
            $("#preloder").fadeIn();
        });//submit
    });//document ready
}

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